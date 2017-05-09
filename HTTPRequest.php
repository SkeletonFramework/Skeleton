<?php

namespace SkeletonFramework;

class HTTPRequest extends ApplicationComponent {

	public function cookieData ($key) {
		return $this->getExists($key) ? $_GET[$key] : null;
	}

	public function getData ($key) {
		return $this->getExists($key) ? $_GET[$key] : null;
	}

	public function cookieExists($key) {
		return $this->getExists($key) ? $_COOKIE[$key] : null;
	}

	public function postData($key) {
		return $this->postExists ? $_POST[$key] : null;
	}

	public function getExists($key) {
		return isset($_GET[$key]);
	}

	public function postExists($key) {
		return isset($_POST[$key]);
	}

	public function method() {
		return $_SERVER['HTTP_METHOD'];
	}

	public function requestUri() {
		return $_SERVER['REQUEST_URI'];
	}
}