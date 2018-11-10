<?php

/* Change class name here */
class PRace {

	use TraitForPages;

	private static function initialize () : void {
		/* Configure your page settings here */
		self::setName('race');
		self::setRequiresAuth(true);
		self::setEmbedded(true);
	}

	private static function modelize () : void {
		$executeStatement = function(PDOStatement $statement) { $statement->execute(); };
		$statements = array(
			/* What you want to retrieve from the database here */
			'status' => DBRequest::cmd(DBRequest::RACE_STATUS),
		);
		array_walk($statements, $executeStatement);

		self::setModels(array(
			/* How you want the data here */
			'status' => $statements['status']->fetchAll(),
		));
	}
	
	private static function controler () : void {

		/* Code here */

		$raceState = "vanilla";

		// Récupération du status de la course
		if (empty(self::getModels()['status'])) $status = -1;
		else {
			$status = self::getModels()['status'][0]['raceStatus'];
			$idRace = self::getModels()['status'][0]['idRace'];
		}

		// Initialisation de la course
		if (count(self::getAttributes()) > 0 && self::getAttributes()[0] == "init" && $_SERVER['REQUEST_METHOD'] == "POST" && isset($_FILES['file-init']) && $status == 0) {

			if ($_FILES['file-init']['size'] > 0 &&
				$_FILES['file-init']['size'] < 10485760 &&
				preg_match('([^\s]+(\.(?i)(csv))$)', $_FILES['file-init']['name']) == 1 &&
				$_FILES['file-init']['error'] == UPLOAD_ERR_OK) {
					// Initialiser avec le .csv
					echo('Initialisation');
			} else {
				$raceState = "upload-init-not-ok";
			}

		}
		// Changement de status de la course
		elseif (count(self::getAttributes()) > 0 && self::getAttributes()[0] == "status-change" && $status != -1)  {
			if ($status == 0) $status = 1;
			elseif ($status == 1) $status = 2;
			elseif ($status == 2) $status = 1;
			DBRequest::cmd(DBRequest::RACE_STATUS_UPDATE)->execute(array($status, $idRace));
		}
		// Mise à jour manuelle du cache
		elseif (count(self::getAttributes()) > 0 && self::getAttributes()[0] == "dump" && $status > 0) {
			// mise à jour à proprement parlé
		}
		// Réception d'un fichier .csv
		elseif (count(self::getAttributes()) > 0 && self::getAttributes()[0] == "update" && $_SERVER['REQUEST_METHOD'] == "POST" && isset($_FILES['file-update']) && $status == 1) {

			if ($_FILES['file-update']['size'] > 0 &&
				$_FILES['file-update']['size'] < 10485760 &&
				preg_match('([^\s]+(\.(?i)(csv))$)', $_FILES['file-update']['name']) == 1 &&
				$_FILES['file-update']['error'] == UPLOAD_ERR_OK) {
					// Initialiser avec le .csv
					echo('Récupération .csv');
			} else {
				$raceState = "upload-update-not-ok";
			}
		}

		$statement = DBRequest::cmd(DBRequest::UTRAIL_NUMBER_PARTICIPANTS);
		$statement->execute();
		$numberParticipants = $statement->fetchAll()[0][0];

		$statement = DBRequest::cmd(DBRequest::UTRAIL_DATETIME_LAST_CSV);
		$statement->execute();
		$datetimeLastCSV = $statement->fetchAll()[0][0];

		$statement = DBRequest::cmd(DBRequest::UTRAIL_DATETIME_LAST_DUMP);
		$statement->execute();
		$datetimeLastDump = $statement->fetchAll()[0][0];

		$statement = DBRequest::cmd(DBRequest::UTRAIL_SIZE_LAST_DUMP);
		$statement->execute();
		$sizeDump = $statement->fetchAll()[0][0];

		self::setUsableVariablesInVue(array(
			'globals' => $GLOBALS,
			'activePage' => 'race',
			'logged' => $GLOBALS['visitor']->isLogged(),
			'attributes' => self::getAttributes(),
			'raceState' => $raceState,
			'status' => $status,
			'numberParticipants' => $numberParticipants,
			'datetimeLastCSV' => $datetimeLastCSV,
			'datetimeLastDump' => $datetimeLastDump,
			'sizeDump' => $sizeDump,
			/* Variables for vue here */
		));
	}

}