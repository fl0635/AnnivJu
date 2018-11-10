<?php

class DBRequest {

	const ALL_RUNNER =
		"SELECT * FROM Runner";

	const ALL_RACE =
		"SELECT * FROM Race";

	const ALL_SECTION =
		"SELECT * FROM Section";

	const ALL_TEAM =
		"SELECT * FROM Team";

	const ALL_COMPOSE =
		"SELECT * FROM Compose";

	const ALL_RANON =
		"SELECT * FROM RanOn";

	const ALL_BELONGTO =
		"SELECT * FROM BelongTo";

	const ALL_PARTICIPATE =
		"SELECT * FROM Participate";

	const ALL_VISITOR =
		"SELECT * FROM Visitor";

	const ALL_RECEIVEDFILE =
		"SELECT * FROM ReceivedFile";



	const UTRAIL_RACE_ID =
		"SELECT idRace FROM Race WHERE Race.raceName = 'utrail'";
	
	const UTRAIL_RUNNER =
		"SELECT * FROM Runner WHERE Runner.idRunner IN (
			SELECT idRunner FROM BelongTo WHERE BelongTo.idTeam IN (
				SELECT idTeam FROM Participate WHERE Participate.idRace IN (" . DBRequest::UTRAIL_RACE_ID . ")))";

	const UTRAIL_SECTION =
		"SELECT * FROM Section WHERE Section.idSection IN (
			SELECT idSection FROM Compose WHERE Compose.idRace IN (" . DBRequest::UTRAIL_RACE_ID . "))";

	const UTRAIL_TEAM =
		"SELECT * FROM Team WHERE Team.idTeam IN (
			SELECT idTeam FROM Participate WHERE Participate.idRace IN (" . DBRequest::UTRAIL_RACE_ID . "))";

	const UTRAIL_COMPOSE =
		"SELECT * FROM Compose WHERE Compose.idRace IN (" . DBRequest::UTRAIL_RACE_ID . ")";

	const UTRAIL_RANON =
		"SELECT * FROM RanOn WHERE RanOn.idSection IN (
			SELECT idSection FROM Compose WHERE Compose.idRace IN (" . DBRequest::UTRAIL_RACE_ID . "))";

	const UTRAIL_BELONGTO =
		"SELECT * FROM BelongTo WHERE BelongTo.idTeam IN (
			SELECT idTeam FROM Participate WHERE Participate.idRace IN (" . DBRequest::UTRAIL_RACE_ID . "))";

	const UTRAIL_PARTICIPATE =
		"SELECT * FROM Participate WHERE Participate.idRace IN (" . DBRequest::UTRAIL_RACE_ID . ")";

	const UTRAIL_RECEIVEDFILE =
		"SELECT * FROM ReceivedFile WHERE ReceivedFile.idRace IN (" . DBRequest::UTRAIL_RACE_ID . ")";

	const UTRAIL_DUMPEDCACHE =
		"SELECT * FROM DumpedCache WHERE DumpedCache.idRace IN (" . DBRequest::UTRAIL_RACE_ID . ")";



	const UTRAIL_NUMBER_PARTICIPANTS =
		"SELECT count(runners.idRunner) FROM (" . DBRequest::UTRAIL_RUNNER . ") AS runners";

	const UTRAIL_DATETIME_LAST_CSV =
		"SELECT receivedfiles.receptionDate FROM (" . DBRequest::UTRAIL_RECEIVEDFILE . ") AS receivedfiles ORDER BY receivedfiles.receptionDate DESC LIMIT 1";

	const UTRAIL_DATETIME_LAST_DUMP =
		"SELECT dumps.dumpDate FROM (" . DBRequest::UTRAIL_DUMPEDCACHE . ") AS dumps ORDER BY dumps.dumpDate DESC LIMIT 1";

	const UTRAIL_SIZE_LAST_DUMP =
		"SELECT dumps.dumpSize FROM (" . DBRequest::UTRAIL_DUMPEDCACHE . ") AS dumps ORDER BY dumps.dumpDate DESC LIMIT 1";



	const VISITOR_IS_AUTHENTICATED =
		"SELECT authenticated FROM Visitor WHERE (Visitor.IP = (?) AND Visitor.authenticated = 1)";

	const VISITOR_DELETE_OLD_LOGS =
		"DELETE FROM Visitor WHERE Visitor.IP = (?)";

	const VISITOR_CREATE_NEW_LOG =
		"INSERT INTO Visitor(idSession, IP, browser, authenticated) VALUES (?, ?, ?, ?)";



	const RACE_STATUS =
		"SELECT raceStatus, idRace FROM Race WHERE raceName = 'utrail'";

	const RACE_STATUS_UPDATE =
		"UPDATE Race SET raceStatus = (?) WHERE Race.idRace = (?)";



	public static function cmd (string $command) : PDOStatement { return DB::getInstance()->prepare($command); }

	public static function getUnparametrableRequests () : array {

		$reflectionClass = new ReflectionClass(__CLASS__);
		$allConstants = $reflectionClass->getConstants();

		foreach ($allConstants as $key => $constant)
			if (!(strpos($constant, "?") === false))
				unset($allConstants[$key]);

		return $allConstants;

	}

	public static function fetchAllEdArrayToHtml ($d) : string {

		if (is_array($d) && !empty($d)) {

			$html = '<table>';

			$html .= '<tr>';
			foreach ($d[0] as $key=>$value)
				if (!is_numeric($key))
					$html .= '<th>' . htmlspecialchars($key) . '</th>';
			$html .= '</tr>';

			foreach ($d as $key=>$value) {
				$html .= '<tr>';
				foreach ($value as $key2=>$value2)
					if (!is_numeric($key2))
						$html .= '<td>' . htmlspecialchars($value2) . '</td>';
				$html .= '</tr>';
			}

			$html .= '</table>';
			return $html;

		} else return '';

	}

}