<?php

define('LOG_FILE','..\var\log');

function saveLog($message)
{
    if (!file_exists(LOG_FILE)) 
    {
        mkdir(LOG_FILE, 0777, true);
    }
    $date = new DateTime();
    $date = $date->format("y:m:d h:i:s");  
    $logData = LOG_FILE.'/log_' . date('d-M-Y') . '.log';
    file_put_contents($logData, $date."-->".$message . "\n", FILE_APPEND);
} 
?>