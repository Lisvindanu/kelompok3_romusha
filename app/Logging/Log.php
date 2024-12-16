<?php

namespace App\Logging;

class Log
{
    protected static $logFile = 'D:/LearnPHP/kelompok3_romusha/storage/logs/custom_genre_log.log';

    public static function info($message, $data = [])
    {
        self::writeLog('INFO', $message, $data);
    }

    public static function error($message, $data = [])
    {
        self::writeLog('ERROR', $message, $data);
    }

    protected static function writeLog($level, $message, $data)
    {
        $directory = dirname(self::$logFile);
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        $logEntry = date('Y-m-d H:i:s') . " [{$level}] {$message} " . json_encode($data) . PHP_EOL;
        file_put_contents(self::$logFile, $logEntry, FILE_APPEND);
    }
}
