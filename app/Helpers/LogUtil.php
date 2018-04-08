<?php
/**
 * Created by PhpStorm.
 * User: wuchuanchuan
 * Date: 2018/4/8
 * Time: 9:35
 */

namespace App\Helpers;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\FirePHPHandler;

class LogUtil
{

    public static function getLogger($name) {

        $logger = new Logger($name);

        $logDir = storage_path('logs/'.$name);
        if (!is_dir($logDir)) {
            @mkdir($logDir, 0777, true);
        }

        $date = date('Ymd', time());
        $file_name = $date . '.log';
        $path = $logDir. '/' . $file_name;
        $stream = new StreamHandler($path, Logger::INFO);
        $firephp = new FirePHPHandler();
        $logger->pushHandler($stream);
        $logger->pushHandler($firephp);
        return $logger;
    }

}