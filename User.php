<?php

namespace SkeletonFramework;

session_start();
class User extends ApplicationComponent {

	private $username;
	private $password;

	public function __construct(Application $app) 
	{
		$this->attributes = [];
	}

	public function addAttribute($attr, $value) {
		$_SESSION[$attr] = $value;
	}

	public function getAttribute($attr) {
		if (isset($_SESSION[$attr])) {
			return $_SESSION[$attr];
		}
		return null;
	}
	
	// Authenticable attriute
	public function getUsername() {
		return $this->username;
	}
	
	// Authenticable attriute
	public function setUsername($username) {
		$this->username = $username;
		return $this;
	}
	
	// Authenticable attriute
	public function getPassword() {
		return $this->password;
	}
	
	// Authenticable attriute
	public function setPassword($password) {
		$this->password = $password;
		return $this;
	}

	public function isAuthenticated() {
		return isset($_SESSION['auth']) && $_SESSION['auth'];
	}

	public function setAuthenticated($auth = false) {

		if (!is_bool($auth)) {
			throw new \InvalidArgumentException("Not a bool in User::setAuthnticated");
		}

		$_SESSION['auth'] = $auth;
	}

	public function setSession() {
		return true === $this->application->getHttpRequest()->getSession()->isAuthenticated();
	}

	public function addFlag($name, $flag) {
		if (!is_string($name)) {
			throw new \InvalidArgumentException("Error in flag name");
		}

		$_SESSION['flags'][$name] = $flag;

		return $this;
	}

	public function hasFlag($name) {
		return isset($_SESSION[$name]);
	}

	public function getFlag($name) {
		if ($this->hasFlag($name)){
			$flag =  $_SESSION[$name];

			unset($_SESSION[$name]);
		}
		return null;
	}
}