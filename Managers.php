<?php

namespace SkeletonFramework;

class Managers {
	private $managers;
	private $api;
	private $dao;

	public function __construct ($api, $dao)	{
		$this->dao = $dao;
		$this->api = $api;
		$this->managers = array();
	}

	public function getDao () {
		return $this->dao;
	}

	public function setDao($dao) {
		$this->dao = $dao;
		return $this;
	}

	public function getApi () {
		return $this->api;
	}

	public function setApi ($api) {
		$this->api = $api;
		return $this;
	}

	public function addManager ($module, Manager $manager) {
		$this->managers[$module]  = $manager;
	}

	public function getManagers() {
		return $this->managers;
	}

	public function getManagerOf($module) {
		if (!is_string($module) || empty($module)) {
			throw new \InvalidArgumentException("L'argument donné n'est pas le bon.", 1);			
		}


		if (!isset($this->getManagers()[$module])) {
			$manager = 'Model\\' . $module . 'Manager';

			$this->addManager($module, new $manager($this->dao));
		}

		return $this->getManagers()[$module];
	}
}