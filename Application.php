<?php

namespace SkeletonFramework;

abstract class Application {
	protected $request;
	protected $response;
	protected $name;
	protected $user;
	protected $config;

	function __construct($name)
	{
		$this->request = new HTTPRequest($this);
		$this->response = new HTTPResponse($this);
		$this->user = new User($this);
		$this->config = new Config($this);
		$this->setName($name);
	}

	public function getController()
	{
	    $router = new Router($this);

	    $xml = new \DOMDocument;
	    $xml->load(__DIR__.'/../../App/' . $this->name . '/Config/routes.xml');

	    $routes = $xml->getElementsByTagName('route');

	    // On parcourt les routes du fichier XML.
	    foreach ($routes as $route)
	    {
	      $vars = [];

	      // On regarde si des variables sont présentes dans l'URL.
	      if ($route->hasAttribute('vars'))
	      {
	        $vars = explode(',', $route->getAttribute('vars'));
	      }

	      // On ajoute la route au routeur.
	      $router->addRoute(new Route($route->getAttribute('url'), $route->getAttribute('module'), $route->getAttribute('action'), $vars));
	    }

	    try
	    {
	      // On récupère la route correspondante à l'URL.
	      $matchedRoute = $router->getRoute($this->request->requestURI());
	    }
	    catch (\RuntimeException $e)
	    {
	      if ($e->getCode() == Router::NO_ROUTE)
	      {
	        // Si aucune route ne correspond, c'est que la page demandée n'existe pas.
	        $this->httpResponse->redirect404();
	      }
	    }

	    // On ajoute les variables de l'URL au tableau $_GET.
	    $_GET = array_merge($_GET, $matchedRoute->getVars());

	    // On instancie le contrôleur.
	    $controllerClass = 'App\\'.$this->name.'\\Modules\\'. $matchedRoute->getModule().'\\'.$matchedRoute->getModule().'Controller';

	    return new $controllerClass($this, $matchedRoute->getModule(), $matchedRoute->getAction());
	 }

	public function getName() {
		return $this->name;
	}

	protected function setName($name) {
		$this->name = $name;
	}

	public function getRequest() {
		return $this->request;
	}

	public function getResponse() {
		return $this->response;
	}

	public function getConfig() {
		return $this->config;
	}

	public function setConfig(Config $config) {
		$this->condig = $config;
	}

	public function getUser() {
		return $this->user;
	}

	abstract protected function run();


}