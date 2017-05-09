<?php

namespace SkeletonFramework;

class PDOFactory {
	public static function getPsqlConnection () {
		$db = new \PDO('pgsql:host=db;dbname=app_news','root', 'root');
		$db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

		return $db;
	}
}