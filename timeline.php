<?php
require 'bootstrap.php';

use GuzzleHttp\Subscriber\Oauth\Oauth1;

/*
 * Setting up the oauth subscriber parameters.
 */
$oauth = new Oauth1([
    'consumer_key'    => $config['consumer_key'],
    'consumer_secret' => $config['consumer_secret'],
    'token'           => $_SESSION['oauth_token'],
    'token_secret'    => $_SESSION['oauth_token_secret']
]);

/*
 * Attaching the complete oauth subscriber to the client
 */
$client->getEmitter()->attach($oauth);

/*
 * Executing a GET request on the timeline service, pass the result to the json parser
 */
$res = $client->get('1.1/statuses/home_timeline.json')->json();

echo '<pre>';

echo 'Timeline for user ' . $_SESSION['screenName'] . ':' . PHP_EOL . '<hr>';

foreach ($res as $tweet)
{
    echo 'From: ' . $tweet['user']['name'] . ' (@' . $tweet['user']['screen_name'] . ')' . PHP_EOL;
    echo '  ' . htmlentities($tweet['text']) . PHP_EOL .  '<hr>';
}
