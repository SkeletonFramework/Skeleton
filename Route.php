<?php

namespace SkeletonFramework;

class Route {
	private $url;
	private $module;
	private $action;
	// On passe le nom des variable associé au match, que l'on souhaite récupérer
	private $varsName;
	//Tableau contenant les valeur associé au variable demandé
	private $vars;


	public function __construct($url = "", $module = "", $action = "", $varsName = [])
	{
		$this->vars = [];
		$this->setUrl($url);
		$this->setModule($module);
		$this->setAction($action);
		$this->setVarsName($varsName);
	}

	public function hasVars () {
		return !empty($this->getVars());
	}

	public function getAction() {
		return $this->action;
	}

	public function getModule(){
		return $this->module;
	}

	public function getUrl(){
		return $this->url;
	}


	public function getVars(){
		return $this->vars;
	}

	public function getVarsname(){
		return $this->varsName;
	}


	public function setAction($action) {
		$this->action = $action;
	}

	public function setModule($module){
		$this->module = $module;
	}

	public function setUrl($url){
		$this->url = $url;
	}

	public function setVars(array $vars){

		$this->vars = $vars;

		return $this;
	}


	public function setVarsName($varsName){

		$this->varsName = $varsName;

		return $this;
	}

	/**
	 * Fonction qui permet de vérifier l'existance de l'URL
	 *
	 * @param  url   string Search url
	 * @return mixed matches Result find | bool false No result
	 */
	public function match($url) {
		if(preg_match_all('#' . $url . '#', $this->url, $matches)) {
			return $matches;
		} else {
			return false;
		}
	}

}