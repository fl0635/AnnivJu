<?php

if (!defined('utrail')) exit;

// Gestion par défaut des exceptions non capturées
function exceptionHandler($exception) {
		PError::run([$exception]);
}
set_exception_handler('exceptionHandler');

// Configuration
date_default_timezone_set('Europe/Paris');
$libsPath = "/libs/";
$utrailPath = "/utrail/";
$uploadDirPath = $utrailPath . 'uploads/';

// Autochargement des classes
spl_autoload_register(function ($class) {
	if (file_exists('includes/classes/' . $class . '.php'))
		require_once('includes/classes/' . $class . '.php');
	else if (file_exists('includes/pages/' . $class . '.php'))
		require_once('includes/pages/' . $class . '.php');
	else if ($class == 'Smarty')
		require_once('../libs/smarty/Smarty.class.php');
	else if (strpos($class, 'Smarty') !== false) {
		require_once('../libs/smarty/Autoloader.php');
		Smarty_Autoloader::autoload($class);
	}
});

// Instancie l'accès à la BDD
$db = DB::getInstance();

// Gestion de $_SESSION
session_start();
$visitor = new Visitor();
