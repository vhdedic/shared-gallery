<?php
/**
 *
 */
class Config
{
    public static function getParams($key)
    {
        $config = include ROOT.'config/config.php';
        return $config[$key];
    }
}
