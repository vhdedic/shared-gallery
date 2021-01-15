<?php

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
        $config = include ROOT.'config/config.php';

        return $config[$key];
    }
}
