<?php

class LoggerManager {
	static $logger = null;
	public static function getLogger($name = "root") {
		if(LoggerManager::$logger == null) {
			require_once ROOT_PATH_LIBRARY . '/apache-log4php-2.3.0/src/main/php/Logger.php';
			Logger::configure(ROOT_PATH_RESOURCE . '/log.properties');
			LoggerManager::$logger = Logger::getLogger($name);
		}
		return LoggerManager::$logger;
	}
}


?>