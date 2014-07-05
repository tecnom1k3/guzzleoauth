<?php
require 'bootstrap.php';

use GuzzleHttp\Subscriber\Oauth\Oauth1;

/*
 * Create an OAUTH object to begin authentication, attaching it to the Guzzle Client created at bootstrap.php
 */

$oauth = new Oauth1([
    'consumer_key'    => $config['consumer_key'],
    'consumer_secret' => $config['consumer_secret']
]);

$client->getEmitter()->attach($oauth);

/*
 * Request oauth tokens to twitter
 */
$res = $client->post('oauth/request_token', ['body' => ['oauth_callback' => $config['oauth_callback']]]);

$params = (string)$res->getBody();

parse_str($params);

/*
 * store those tokens in session
 */
$_SESSION['oauth_token'] = $oauth_token;
$_SESSION['oauth_token_secret'] = $oauth_token_secret;

/*
 * Head to Twitter to sign-in/authorize the tokens
 */
header("Location: https://api.twitter.com/oauth/authenticate?oauth_token={$oauth_token}");
