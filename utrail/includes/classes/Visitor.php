<?php

class Visitor {

	private $idSession;
	private $IP;
	private $browser;
	private $authenticated;

	public function __construct () {
		$this->setIdSession(session_id());
		$this->setIP($_SERVER['REMOTE_ADDR']);
		$this->setBrowser($_SERVER['HTTP_USER_AGENT']);
		$this->setAuthenticated($this->wasAuthenticated());

		$this->updateDb();
	}

	public function getIdSession () : string { return $this->idSession; }
	public function getIP () : string { return $this->IP; }
	public function getBrowser () : string { return $this->browser; }
	public function getAuthenticated () : int { return $this->authenticated; }
	public function isLogged () : bool { if ($this->getAuthenticated() == 1) return true; else return false; } // Alias

	private function setIdSession (string $d) : void { $this->idSession = $d; }
	private function setIP (string $d) : void { $this->IP = $d; }
	private function setBrowser (string $d) : void { $this->browser = $d; }
	private function setAuthenticated (int $d) : void { $this->authenticated = $d; }

	private function wasAuthenticated () : int {
		try {
			$statementIsAuthenticated = DBRequest::cmd(DBRequest::VISITOR_IS_AUTHENTICATED);
			$statementIsAuthenticated->execute([$this->getIP()]);
			if ($statementIsAuthenticated->rowCount() > 0)
				return 1;
			else return 0;
		} catch (Exception $e) {
			throw new Exception(ExceptionsMap::ERR_DB_VISITOR_AUTHENTICATION);
		}
	}

	private function updateDb () : void {
		try {
			(DBRequest::cmd(DBRequest::VISITOR_DELETE_OLD_LOGS))->execute([$this->getIp()]);
		} catch (Exception $e) {
			throw new Exception(ExceptionsMap::ERR_DB_VISITOR_DELETE);
		}
		
		try {
			(DBRequest::cmd(DBRequest::VISITOR_CREATE_NEW_LOG))->execute(array(
				$this->getIdSession(),
				$this->getIP(),
				$this->getBrowser(),
				$this->getAuthenticated()
			));
		} catch (Exception $e) {
			throw new Exception(ExceptionsMap::ERR_DB_VISITOR_CREATE);
		}
	}
	
	public function login () : void {
		if ($this->getAuthenticated() == 0) {
			$this->setAuthenticated(1);
			$this->updateDb();
		}
	}

	public function logout () : void {
		if ($this->getAuthenticated() != 0) {
			$this->setAuthenticated(0);
			$this->updateDb();
		}
	}
	
}