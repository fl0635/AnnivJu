<?php

class DB {

	private static $instance = NULL;

	public static function getInstance () : PDO {

		if (!self::$instance) {
			
			require_once('config/db.php');
			
			self::$instance = new PDO(
				'mysql:host=' . $dbConnection['dbHost'] . $dbConnection['dbPort'] . ';dbname=' . $dbConnection['dbName'],
				$dbConnection['dbId'],
				$dbConnection['dbPwd']);
				
			self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		}

		return self::$instance;
	}

	private function __clone () {}

}
