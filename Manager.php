<?php

namespace SkeletonFramework;

abstract class Manager {
	private $dao;

	function __construct($dao)
	{
		$this->dao = $dao;
	}
}