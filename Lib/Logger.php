<?php

namespace Lib;

class Logger
{
    public static function log(string $message)
    {
        $logFile = LOG_PATH . '/' . date('Y-m-d') . '.log';
        if (!file_exists(LOG_PATH)) mkdir(LOG_PATH, 0777, true);
        if (!file_exists($logFile)) touch($logFile);
        $log = fopen($logFile, 'a');
        fwrite($log, date('H:i:s') . ' ' . $message . "\n");
        fclose($log);
    }
}