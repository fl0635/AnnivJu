<?php

ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);

define('utrail', true);
	
require_once('includes/init.php');

$router = new Router($_SERVER['REQUEST_URI'], 'config/routes');
$router->followRoute();