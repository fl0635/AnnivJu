<?php

/* Change class name here */
class PData {

	use TraitForPages;

	private static function initialize () : void {
		/* Configure your page settings here */
		self::setName('data');
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
		$listRequests = DBRequest::getUnparametrableRequests();

		$dbState = "vanilla";
		$successReturn = null;

		if ($_SERVER["REQUEST_METHOD"] == "POST") {

			if (isset($_FILES['file'])) {

				if ($_FILES['file']['size'] > 0 &&
					$_FILES['file']['size'] < 1048576 &&
					preg_match('([^\s]+(\.(?i)(sql))$)', $_FILES['file']['name']) == 1 &&
					$_FILES['file']['error'] == UPLOAD_ERR_OK) {

					try {
						if (!(DB::getInstance()->exec((file_get_contents($_FILES['file']['tmp_name']))) === false))
							$dbState = "upload-ok";
						else $dbState = "upload-not-ok";
					} catch (Exception $e) {
						$dbState = "upload-not-ok";
					}

				} else $dbState = "upload-not-ok";

			} elseif (isset($_POST['req'])) {

				if (in_array($_POST['req'], $listRequests)) {

					$statement = DBRequest::cmd($_POST['req']);

					if ($statement->execute()) {
						$successReturn = $statement->fetchAll();
						$dbState = "exec-ok";
					} else $dbState = "exec-not-ok";

				} else $dbState = "exec-not-ok";

			}

		}

		self::setUsableVariablesInVue(array(
			'globals' => $GLOBALS,
			'activePage' => 'data',
			'logged' => $GLOBALS['visitor']->isLogged(),
			'attributes' => self::getAttributes(),
			'possibleRequests' => $listRequests,
			'dbState' => $dbState,
			'successReturn' => DBRequest::fetchAllEdArrayToHtml($successReturn),
			/* Variables for vue here */
		));
	}

}