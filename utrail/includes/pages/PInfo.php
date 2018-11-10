<?php

/* Change class name here */
class PInfo {

	use TraitForPages;

	private static function initialize () : void {
		/* Configure your page settings here */
		self::setName('info');
		self::setRequiresAuth(true);
		self::setEmbedded(false);
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
		phpinfo();

		self::setUsableVariablesInVue(array(
			'globals' => $GLOBALS,
			'activePage' => 'error',
			'logged' => $GLOBALS['visitor']->isLogged(),
			'attributes' => self::getAttributes(),
			/* Variables for vue here */
		));
	}

}