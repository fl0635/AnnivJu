<?php

class Router {

	private static $allowedCharactersInRoute;
	private static $rootDepth;
	private static $routesFile;
	private static $routes;
	private static $initialized = false;

	private $URI;
	private $routeName;
	private $routeAttributes;
	
	private static function initialize (string $routesFile) : void {
		if (self::getInitialized()) return;
		self::setAllowedCharactersInRoute("/[^a-zA-Z0-9\-]/");
		self::setRootDepth(2); // eg. (0)/us(1)/utrail(2)/index(3)
		self::setRoutesFile($routesFile);
		self::loadRoutes();
		self::setInitialized(true);
	}

	private static function getAllowedCharactersInRoute () : string { return self::$allowedCharactersInRoute; }
	private static function getRootDepth () : int { return self::$rootDepth; }
	private static function getRoutesFile () : string { return self::$routesFile; }
	private static function getRoutes () : array { return self::$routes; }
	private static function getInitialized () : bool { return self::$initialized; }
	private static function setAllowedCharactersInRoute (string $d) : void { self::$allowedCharactersInRoute = $d; }
	private static function setRootDepth (int $d) : void { self::$rootDepth = $d; }
	private static function setRoutesFile (string $d) : void { self::$routesFile = $d; }
	private static function setRoutes (array $d) : void { self::$routes = $d; }
	private static function setInitialized (bool $d) : void { self::$initialized = true; }
	private static function loadRoutes () {
		try {
			$fileSanitarized = preg_replace('/\s/', '', strtolower(file_get_contents(self::getRoutesFile())));
			self::setRoutes(explode(';', $fileSanitarized));
		} catch (Exception $e) {
			throw new Exception(ExceptionsMap::ERR_ROUTER_READING_ROUTES_FILE . $e->getMessage());
		}
	}

	public function __construct (string $URI, string $routesFile) {
		self::initialize($routesFile);
		$this->setURI($URI);
		$this->setRouteAttributes(array());
		$this->extractRouteInfo();
	}

	private function getURI () : string { return $this->URI; }
	private function getRouteName () : string { return $this->routeName; }
	private function getRouteAttributes () : array { return $this->routeAttributes; }
	private function setURI (string $d) : void { $this->URI = $d; }
	private function setRouteName (string $d) : void { $this->routeName = $d; }
	private function setRouteAttributes (array $d) : void { $this->routeAttributes = $d; }
	private function addRouteAttribute (string $d) : void { $this->routeAttributes[] = $d; }

	private function extractRouteInfo () : void {
		$URIRawParts = explode('/', $this->getURI());
		$URIParts = [];
		foreach ($URIRawParts as $URIRawPart)
			$URIParts[] = strtolower(preg_replace(self::getAllowedCharactersInRoute(), "", pathinfo($URIRawPart)['filename']));
		
		$name = $URIParts[self::getRootDepth()];
		if ($name == "") $this->setRouteName("index");
		else $this->setRouteName($name);
		
		for ($i = self::getRootDepth() + 1; $i < count($URIParts); $i++)
			$this->addRouteAttribute($URIParts[$i]);
	}

	public function followRoute () : void {
		if (!in_array($this->getRouteName(), self::getRoutes()))
			throw new Exception(ExceptionsMap::ERR_ROUTER_UNKNOWN_ROUTE);
		
		('P' . ucfirst($this->getRouteName()))::run($this->getRouteAttributes());
	}

}