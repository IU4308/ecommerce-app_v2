<?php

namespace app\core;

class Log
{
    public string $timestamp = '';
    public string $message = '';
    public string $type = '';
    public string $path = '';

    public function __construct($message, $type = 'SUCCESS', $mode = 'w')
    {
        if ($mode === 'w') {
            $this->timestamp = date('Y-m-d H:i:s', time());
            $this->message = $message;
            $this->type = $type;
            $this->path = Application::$ROOT_DIR . '/public/logs/logs.txt';

            $f = fopen($this->path, 'a+');
            if ($f) {
                fputs($f, "$this->timestamp | $this->type | $this->message\n");
                fclose($f);
            }
        } else {
            $log_arr = explode(' | ', $message, 3);
            $this->timestamp = $log_arr[0];
            $this->type = $log_arr[1];
            $this->message = $log_arr[2];
        }
    }

    public static function read_logs($fileName = null): array
    {
        $fileName = $fileName ?? Application::$ROOT_DIR . '/public/logs/logs.txt';
        $logs = file($fileName, FILE_IGNORE_NEW_LINES);

        return array_reverse($logs);
    }
}
