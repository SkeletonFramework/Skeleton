<?php

namespace SkeletonFramework;

class HTTPResponse extends ApplicationComponent  {

	protected $page;

	public function redirectPageNotFound() {
		header('Location:' . $pageNF);
	}

	public function addHeader($header) {
		header($header);
	}

	public function send() {
		exit($this->getPage()->getGeneratedPage());
	}

	public function redirect($location) {
		header('Location:' . $location);
	}


	public function getPage() {
		return $this->page;
	}

	public function setPage(Page $page) {
		$this->page = $page;

		return $this;
	}

	public function setCookie($name, $value = '', $expire = 0, $path = null, $domain = null, $secure = null, $httpOnly = true) {
		setcookie($name, $value, $expire, $path, $domain, $secure, $httpOnly);
	}

	public static function redirect404 () {
		$page = new Page($this->app);

		$page->setContentFile(__DIR__ . '/../../Errors/404.html');

		$this->addHeader('HTTP/1.0 404 Not Found');

		$this->send();		
	}
}