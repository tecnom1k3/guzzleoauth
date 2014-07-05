<?php
require 'bootstrap.php';

use GuzzleHttp\Subscriber\Oauth\Oauth1;

/*
 * Get the new auth token and verifier after authorizing the request.
 * Please sanitize properly the input parameters. Never use them directly in a production environment.
 */
$authToken = $_GET['oauth_token'];
$authVerifier = $_GET['oauth_verifier'];

/*
 * Setting the temporary auth token in the oauth request
 */
$oauth = new Oauth1([
    'consumer_key'    => $config['consumer_key'],
    'consumer_secret' => $config['consumer_secret'],
    'token' => $_SESSION['oauth_token']
]);

$client->getEmitter()->attach($oauth);

/*
 * validate that the previously stored auth token matches the one recevied from Twitter
 */
if ($authToken == $_SESSION['oauth_token']) {

    /*
     * Request for definitive auth token and secret using the provided verifier by twitter
     */
    $res = $client->post('oauth/access_token', ['body' => ['oauth_verifier' => $authVerifier]]);

    $params = (string)$res->getBody();

    parse_str($params);

    $_SESSION['oauth_token'] = $oauth_token;
    $_SESSION['oauth_token_secret'] = $oauth_token_secret;
    $_SESSION['userId'] = $user_id;
    $_SESSION['screenName'] = $screen_name;

    /*
     * Head over to the timeline reader!
     */
    header("Location: timeline.php");
}