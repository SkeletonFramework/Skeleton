<?php


namespace SkeletonFramework;


class Router extends ApplicationComponent {
	protected $routes;

	public function __construct() {
		$this->routes = [];
	}

	const ROUTE_NOT_FIND = 1;


	public function addRoute(Route $route) {

		if(!in_array($route, $this->getRoutes())) {
			$this->routes[] = $route;
		}

		return $this;
	}

	public function getRoutes(){
		return $this->routes;
	}

	/**
	* Get the route match from url given.
	*/
	public function getRoute($url) {

		foreach ($this->getRoutes() as $route) {
			// Route match ? CAtch the match and assign it to the route
			if ($matches = $route->match($url)) {
				if ($route->hasVars()) {
					$varNames = $route->getVars();
					$vars = [];

					// On commence à un car preg_match retourne dans le première élément toute l'URL (voir doc)
					for ($i = 1; $i < count($matches) - 1; $i++) {
						// Clé : le nom de la variable avec le match associé à cette position 
						$vars[$varNames[$i - 1]] = $matches[$i];
					}

					$route->setVars($vars);

				}

				return $route;
			}

		}
		throw new \Exception("Error Processing Request : no route match", 1);
		
	}
}