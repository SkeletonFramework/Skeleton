<?php

namespace SkeletonFramework;

abstract class Entity implements \ArrayAccess {
	private $id;

	// Prise en compte de l'hydratation mais facultative selon le type retourné par la BDD
	public function __construct($datas = null)
	{
		if (count($datas) > 0) {
			$this->hydrate($datas);
		}
	}

	public function hydrate($datas) {
		foreach ($datas as $key => $value) {
			$method = 'set' . ucfirst($key);

			if (is_callable([$this, $method])) {
				$this->$method($value);
			} else {
				throw new \NotFoundException("Method not found.", 1);				
			}
		}

		return $this;
	}

	protected function isNew () {
		return empty($this->getId());
	}

	protected function getId () {
		return $this->id;
	}

	protected function setId($id) {
		$this->id = $id;

		return $this;
	}

	public function offsetGet($var) {
		$method = 'get' . ucfirst($var);

		if (isset($this->$method) && is_callable([$this, $method])) {
			return $this->$method();
		} else {
			echo "Méthod non trouvé";
		}

		return $this;
	}

	public function offsetSet ($method, $value) {
		$method = 'set' . ucfirst($method);

		if (isset($this->$method) && is_callable([$this, $method])) {
			$this->$method($value);
		} else {
			echo "Méthod non trouvé";
		}

		return $this;
	}

	public function offsetExists ($var) {
		return isset($this->$var) && empty($this->$var);
	}

	public function offsetUnset ($var) {
		throw new \Exception("Error unset interdit", 1);
		
	}
}