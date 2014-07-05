<?php
/*
 * A session will be used to temporary store OAUTH credentials.
 * Once the session dies, re-authentication will be needed.
 */
session_start();
require 'vendor/autoload.php';

use Acme\LoggerSubscriber;
use Acme\ClientWrapper;

/*
 * Loading the global config entries
 */
$config = require_once('config.global.php');

/*
 * If a local config file exists, it will be merged to the global config, overriding it.
 */
if (file_exists('config.local.php') && is_readable('config.local.php')) {
    $localConfig = require_once('config.local.php');

    if (is_array($localConfig)) {
        $config = array_merge($config, $localConfig);
    }

}

date_default_timezone_set($config['timezone']);

/*
 * Fetching the log subscriber and attaching it to the Guzzle Client
 */
$logSubscriber = LoggerSubscriber::get();
$client = ClientWrapper::get($logSubscriber);