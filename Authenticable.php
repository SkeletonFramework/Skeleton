<?php

namespace SkeletonFramework;

interface Authenticable {
	public function getUsername();

	public function setUsername($username);
	
	public function getPassword();

	public function setPassword($password);
}