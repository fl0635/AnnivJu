<?php

/* Change class name here */
class PAdmin {

	use TraitForPages;

	private static function initialize () : void {
		/* Configure your page settings here */
		self::setName('admin');
		self::setRequiresAuth(true);
		self::setEmbedded(true);
	}

	private static function modelize () : void {
		$executeStatement = function(PDOStatement $statement) { $statement->execute(); };
		$statements = array(
			/* What you want to retrieve from the database here */
		);
		array_walk($statements, $executeStatement);

		self::setModels(array(
			/* How you want the data here */
		));
	}
	
	private static function controler () : void {

		/* Code here */
		$routes = explode(';', preg_replace('/\s/', '', strtolower(file_get_contents('config/routes'))));

		if ($_SERVER["REQUEST_METHOD"] == "POST" && (isset($_POST['add']) || isset($_POST['remove']))) {

			if (isset($_POST['add']) && strlen($_POST['add']) > 0)
				$routes[] = strtolower(preg_replace("/[^a-zA-Z0-9\-]/", "", $_POST['add']));
			if (isset($_POST['remove']) && strlen($_POST['remove']) > 0)
				$routes = array_diff($routes, [strtolower(preg_replace("/[^a-zA-Z0-9\-]/", "", $_POST['remove']))]);

			$routesStr = "";
			foreach ($routes as $route)
				if (strlen($route) > 0)
					$routesStr .= $route . ';';

			if ($routesStr[-1] == ';') $routesStr = substr($routesStr, 0, -1);
			file_put_contents('config/routes', $routesStr);

		}

		self::setUsableVariablesInVue(array(
			'globals' => $GLOBALS,
			'activePage' => 'admin',
			'logged' => $GLOBALS['visitor']->isLogged(),
			'attributes' => self::getAttributes(),
			'routes' => $routes,
			/* Variables for vue here */
		));
	}

}