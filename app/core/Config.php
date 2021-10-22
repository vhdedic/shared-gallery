<?php

namespace App\Core;

/**
 * Get config parameters from config file
 */
class Config
{
    /**
     * Include config file and return parameters
     *
     * @param  string $key
     * @return string $key
     */
    public static function getParams($key)
    {
        $config = include APP.'app/config.php';

        return $config[$key];
    }
}
