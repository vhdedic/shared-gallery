<?php
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

define('ROOT', dirname(__FILE__).'/');
define('APP', dirname(dirname(__FILE__)).'/');

require_once APP.'vendor/autoload.php';

$application = new App\Core\Application;
$application->run();
