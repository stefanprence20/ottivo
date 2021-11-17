<?php

namespace App\Helpers;


class Log
{
    const MESSAGE_TYPE = 3;
    const LOG_PATH = __DIR__ . '../../../data/logs/ottivo.log';
    const WARNING_TEXT = 'WARNING';
    const ERROR_TEXT = 'ERROR';

    /**
     * Log a warning
     * @param string $message
     * @param int $code
     * @param array $extra
     */
    public static function warning(string $message, int $code, array $extra = [])
    {
        $date = date("Y-m-d H:i:s.u", time());
        $message = "[$date] " .self::WARNING_TEXT. " | " .$code.  " : $message " .json_encode($extra). "\n";
        error_log($message, self::MESSAGE_TYPE, self::LOG_PATH);
    }

    /**
     * Log an error
     * @param string $message
     * @param int $code
     * @param array $extra
     */
    public static function error(string $message, int $code, array $extra = [])
    {
        $date = date("Y-m-d H:i:s.u", time());
        $message = "[$date] ".self::ERROR_TEXT. " | " .$code." : $message " .json_encode($extra). "\n";
        error_log($message, self::MESSAGE_TYPE, self::LOG_PATH);
    }

}