<?php
namespace Acme;

use GuzzleHttp\Subscriber\Log\Formatter;
use GuzzleHttp\Subscriber\Log\LogSubscriber;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class LoggerSubscriber
{

    /**
     * This will create a logger subscriber for Guzzle Client, setting the log file to guzzle.log
     * @return LogSubscriber
     */
    public static function  get()
    {
        $log = new Logger('guzzle');
        $log->pushHandler(new StreamHandler('guzzle.log'));
        $subscriber = new LogSubscriber($log, Formatter::SHORT);

        return $subscriber;
    }

} 