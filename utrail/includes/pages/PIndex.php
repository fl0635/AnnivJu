<?php

/* Change class name here */
class PIndex {

	use TraitForPages;

	private static function initialize () : void {
		/* Configure your page settings here */
		self::setName('index');
		self::setRequiresAuth(false);
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

		self::setUsableVariablesInVue(array(
			'globals' => $GLOBALS,
			'activePage' => 'index',
			'logged' => $GLOBALS['visitor']->isLogged(),
			'attributes' => self::getAttributes(),
			/* Variables for vue here */
		));
	}

}