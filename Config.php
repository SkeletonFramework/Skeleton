<?php

namespace SkeletonFramework;

class Config extends ApplicationComponent {
	protected $vars;
	private $file;

	public function __construct(Application $app)
	{
		$this->app = $app;
		$this->app->setConfig($this);

		$this->file = __DIR__ . "/../../App/" . $this->app->getName() . "/Config/app.xml";
	}

	public function getVar($var){
		// On récupère les variable de la config si une variable de configuration est demandé. Ainsi le tableau ne sera pas rechargé sistématiquement
		if (!isset($this->vars[$var])){

			$domDoc = new \DOMDocument();

			$elements = $domDoc->getElementsByTagName('define');

			foreach ($elements as $elt) {
				# code...
				$vars[$elt->getAttribute('var')] = $elt->getAttribut('value');
			}
		}

		if (isset($this->vars[$var])) {
			return $this->vars[$var];
		}

		return null;
	}

	public function addVar($name, $value) {
		$this->vars[$name] = $value;
	}

}