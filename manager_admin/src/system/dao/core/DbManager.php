<?php
require_once ROOT_PATH_CONFIG . "/DbConfig.php";
require_once ROOT_PATH_CONFIG . "/AppConfig.php";
require_once ROOT_PATH_DAO . "/core/AdjustDbValue.php";
class DbManager {
	private static $processUserId;
	private static $db;
	public static function getInstance() {
		if(DbManager::$db == null) {
			$config = AppConfig::$DB_CONFIG[AppConfig::$SELECT_DB];
			if (version_compare ( PHP_VERSION, '5.5.0' ) < 0) {
				require_once ('BaseMySqlDao.php');
				DbManager::$db = new BaseMySqlDao ($config);
			} else {
				require_once ('BaseMySqliDao.php');
				DbManager::$db  = new BaseMySqliDao ($config);
			}
			DbManager::$db->isTransactionStart = false;
		}
		
		return DbManager::$db;
	}

	public static function setProcessUserId($processUserId) {
		DbManager::$processUserId = $processUserId;
	}

	public static function getProcessUserId() {
		return DbManager::$processUserId;
	}

	public function beginTransaction() {
		DbManager::$db->beginTransaction();
	}

	public function commit() {
		DbManager::$db->commit();
	}

	public function rollback() {
		DbManager::$db->rollback();
	}
	
}
?>