<?php

namespace SkeletonFramework;

abstract class ApplicationComponent {

	protected $app;

	public function __construct(Application $app) {
		$this->app = $app;
	}

	public function getApplication() {
		return $this->app;
	}
}