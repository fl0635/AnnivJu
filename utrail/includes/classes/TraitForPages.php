<?php

trait TraitForPages {

	private static $name;
	private static $requiresAuth;
	private static $embedded;
	private static $template;
	private static $attributes;
	private static $usableVariablesInVue;
	private static $models;

	private static function getName () : string { return self::$name; }
	private static function getRequiresAuth () : bool { return self::$requiresAuth; }
	private static function getEmbedded () : bool { return self::$embedded; }
	private static function getTemplate () : Smarty { return self::$template; }
	private static function getAttributes () : array { return self::$attributes; }
	private static function getUsableVariablesInVue () : array { return self::$usableVariablesInVue; }
	private static function getModels () : array { return self::$models; }

	private static function setName (string $d) : void { self::$name = $d; }
	private static function setRequiresAuth (bool $d) : void { self::$requiresAuth = $d; }
	private static function setEmbedded (bool $d) : void { self::$embedded = $d; }
	private static function setTemplate (Smarty $d) : void { self::$template = $d; }
	private static function setAttributes (array $d) : void { self::$attributes = $d; }
	private static function setUsableVariablesInVue (array $d) : void { self::$usableVariablesInVue = $d; }
	private static function setModels (array $d) : void { self::$models = $d; }
	
	private static function assignTemplate () : void { self::$template->assign(self::getUsableVariablesInVue()); }
	
	private static function displayTemplate () : void {
		$templateDirectory = 'includes/templates/';
		if (self::getEmbedded()) self::$template->display($templateDirectory . 'header.tpl');
		self::$template->display($templateDirectory . self::getName() . '.tpl');
		if (self::getEmbedded()) self::$template->display($templateDirectory . 'footer.tpl');
	}

	private static function initializeAuto (array $attributes) : void {
		self::setAttributes($attributes);
		self::setTemplate(new Smarty());
		self::setModels(array());
	}

	private static function vue () : void {
		self::assignTemplate();
		self::displayTemplate();
	}

	public static function run (array $attributes) : void {
		self::initialize();

		if (self::getRequiresAuth() && !$GLOBALS['visitor']->isLogged()) {
			throw new Exception(ExceptionsMap::ERR_PAGES_UNAUTHORIZED);
		}

		self::initializeAuto($attributes);
		self::modelize();

		self::controler();
		self::vue();
	}
	
}