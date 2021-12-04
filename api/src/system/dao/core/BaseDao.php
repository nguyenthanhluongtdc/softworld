<?php

require_once ROOT_PATH_DAO . "/core/DbManager.php";
abstract class BaseDao {
	
	public $db;
	private $logger;
	private $tableName;
	public function __construct($tableName) {
		$this->db = DbManager::getInstance();
		$this->tableName = $tableName;
		$this->logger = LoggerManager::getLogger("DAO");
	}

	public function getDb() {
		if(!$this->db) {
			$this->db = DbManager::getInstance();
		}
		return $this->db;
	}


	public function selectWithPagging(
		$currentPage = 1
		, $pageSize
		, &$totalRow, $sql = null, $params = null) {
		// write log
		if($sql == null) {
			$sql = "select * from " . $this->tableName;
		}
		$this->logger->debug(get_class($this) . "#selectWithPagging[current page = ($currentPage), pageSize = ($pageSize), input sql = (" . $sql . "), params = (" . print_r($params, true) . ")]");
		$records = null;
		$exception = null;
		$isBeginTran = false;
		try {
			if(!$this->db->isTransactionStart) {
				$this->db->beginTransaction();
				$isBeginTran = true;
			}
			$sql = $this->db->attachParams($sql, $params);
			$from = 0;
			$result = $this->selectOne($this->createSqlCount($sql));
			if($result) {
				$totalRow = $result["CNT"];
				
				$this->caculateFromRecord($totalRow, $pageSize, $currentPage, $from, $pageSize);

				$sql .= " LIMIT $from,$pageSize";
				$records = $this->select($sql);
			}
		} catch (Exception $e) {
		   	$exception = $e;
		}
		if($isBeginTran) {
			$this->db->rollback();
		}
		else if(!$this->db->isTransactionStart) {
			$this->db->close();
		}
		if($exception) {
			throw $exception;
		}
		return $records;
	}
	
	public function selectAll() {
		$result = null;
		$exception = null;
		$records = null;
		try {
			if(!$this->db->isTransactionStart) {
				$this->db->connect();
			}
			$result = $this->db->selectAll($this->tableName);
			if($result) {
				$records = array();
				while ($row = $this->db->fetchArray($result)) {
					$records[] = $row;
				}
			}
		} catch (Exception $e) {
		   	$exception = $e;
		}
		if(!$this->db->isTransactionStart) {
			$this->db->close();
		}
		if($result) {
			$this->db->freeResult($result);
		}
		if($exception) {
			throw $exception;
		}
		return $records;	
	}

	public function selectOne($sql, $params = null) {
		// write log
		$this->logger->debug(get_class($this) . "#selectOne[input sql = (" . $sql . "), params = (" . print_r($params, true) . ")]");
		$record = null;
		$result = null;
		$exception = null;
		try {
			if(!$this->db->isTransactionStart) {
				$this->db->connect();
			}
			$result = $this->db->query($sql, $params);
			if($result) {
				$record = $this->db->fetchArray($result);
			}
		} catch (Exception $e) {
		   	$exception = $e;
		}
		if(!$this->db->isTransactionStart) {
			$this->db->close();
		}
		if($result) {
			$this->db->freeResult($result);
		}
		if($exception) {
			throw $exception;
		}
		return $record;
	}

	public function select($sql, $params = null) {
		// write log
		$this->logger->debug(get_class($this) . "#select[input sql = (" . $sql . "), params = (" . print_r($params, true) . ")]");
		$records = null;
		$result = null;
		$exception = null;
		try {
			if(!$this->db->isTransactionStart) {
				$this->db->connect();
			}
			$result = $this->db->query($sql, $params);
			if($result) {
				$records = array();
				while ($row = $this->db->fetchArray($result)) {
					$records[] = $row;
				}
			}
		} catch (Exception $e) {
		   	$exception = $e;
		}
		if(!$this->db->isTransactionStart) {
			$this->db->close();
		}
		if($result) {
			$this->db->freeResult($result);
		}
		if($exception) {
			throw $exception;
		}
		return $records;
	}

	private function filterColumns(&$arr) {
		
		AdjustDbValue::adjust($this->tableName, $arr);
		$columns = array_keys(DbConfig::$DB_INFO[$this->tableName]);
		foreach ($arr as $key => $value) {
			if(!in_array($key, $columns)) {
				unset($arr[$key]);
			}
		}
	}	

	public function insert($params) {
		// write log
		$this->logger->debug(get_class($this) . "#insert[params=(" . print_r($params, true) . ")]");
		
		$this->filterColumns($params);

		$result = null;
		$exception = null;
		try {
			if(!$this->db->isTransactionStart) {
				$this->db->connect();
			}
			//$this->addCreatedProfie($params);
			$result = $this->db->insert($this->tableName, $params);
		} catch (Exception $e) {
		   	$exception = $e;
		}
		if(!$this->db->isTransactionStart) {
			$this->db->close();
		}
		if($exception) {
			throw $exception;
		}
		return $result;
	}

	public function update($params, $where, $checkExclusive = true) {
		// write log
	
		$this->logger->debug(get_class($this) . "#update[params=(" . print_r($params, true) . "), where=(" . print_r($where, true) . ")]");
	
		$result = null;
		$exception = null;

		try {
			//kiểm tra kết nối database
			if(!$this->db->isTransactionStart) {
				$this->db->connect();
			}
			
			if($checkExclusive) {
				if(!array_key_exists("updated_time", $params)) {
					throw new Exception("argument checkExclusive is true => updated_time is require.", 1);
				}
				// define default condition
				$defaultWhere = " (updated_time is NULL OR updated_time = :last_updated_time)";
				if(!isset($where)) {
					$where = array(
						"where" => $defaultWhere
						, "params" => array("last_updated_time" => $params["updated_time"])
					);
				} else {
					$where["where"] .=  " and " . $defaultWhere;
					if(isset($where['params'])) {
						$where['params']['last_updated_time'] = $params["updated_time"];
					} else {
						$where['params'] = array("last_updated_time" => $params["updated_time"]);
					}
				}
			}

			$this->filterColumns($params);
		
			$this->addUpdatedProfie($params);
			
			
			
			$result = $this->db->update($this->tableName, $params, $where);	
		} catch (Exception $e) {
		   	$exception = $e;
		}
		if(!$this->db->isTransactionStart) {
			$this->db->close();
		}
		if($exception) {
			throw $exception;
		}
		return $result;
	}

	public function delete($id) {
		$where = array( "where" => "id = :id" , "params" => array("id" => $id));
		// write log
		$this->logger->debug(get_class($this) . "#delete[where=(" . print_r($where, true) . ")]");
		
		$result = null;
		$exception = null;
		try {
			if(!$this->db->isTransactionStart) {
				$this->db->connect();
			}
			$result = $this->db->delete($this->tableName, $where);	
		} catch (Exception $e) {
		   	$exception = $e;
		}
		if(!$this->db->isTransactionStart) {
			$this->db->close();
		}
		if($exception) {
			throw $exception;
		}
		return $result;	
	}

	private function addUpdatedProfie(&$params) {
		$params["updated_time"] = DateUtil::getCurrentDatetime();
		$params["updated_user"] = DbManager::getProcessUserId();
		unset($params["created_time"]);
		unset($params["created_user"]);
	}
	
	private function addCreatedProfie(&$params) {
		$params["created_time"] = DateUtil::getCurrentDatetime();
		$params["created_user"] = DbManager::getProcessUserId();
		unset($params["updated_time"]);
		unset($params["updated_user"]);
	}
	
	/**
	* Input format:
	* $params => ["user_id" => "xxx", "first_name" => "xxx", "last_name" => "xxx"]
	* $opts = [
	*			[
	*				"where" => "user_id like :user_id"
	*				, "paramName" => "user_id"
	*				, "format" => function($value) {
	*					return '%' . $value . '%';
	*				}
	*			]
	*			, [
	*				"where" => "first_name like :first_name"
	*				, "paramName" => "first_name"
	*				, "format" => function($value) {
	*					return '%' . $value . '%';
	*				}
	*			]
	*			, [
	*				"where" => "last_name like :last_name"
	*				, "paramName" => "last_name"
	*				, "format" => function($value) {
	*					return '%' . $value . '%';
	*				}
	*			] 
	*			, [
	*				"where" => "email like :email"
	*				, "paramName" => "email"
	*				, "format" => function($value) {
	*					return '%' . $value . '%';
	*				}
	*			]
	*			, [
	*				"where" => "role_id = :role_id"
	*				, "paramName" => "role_id"
	*			] 
	*		]
	**/
	public function buildSql($sql, $params, $opts) {
		$returnParams = array();
		$firstOperator = "";
		$where = $this->buildWhereCondition($params, $returnParams, $firstOperator, $opts);
		if(!StringUtil::isNullOrEmpty($where)) {
			if($this->hasWhere($sql)) {
				$sql .= " " . $firstOperator;
			} else {
				$sql .= " WHERE ";
			}
			$sql = $sql . " " . $where;
		}
		return array("sql" => $sql, "params" => $returnParams);
	}
	
	private function buildWhereCondition($params, &$returnParams, &$firstOperator, $opts) {
		$where = "";
		foreach ($opts as $value) {
			if($this->isMultiArray($value)) {	
				if($firstOperator != "") {
					$firstOperator = "";
					$where .= " " . $value["operator"] . " (" . $this->buildWhereCondition($params, $returnParams, $firstOperator, $value["group"]) . ")";
				} else {
					$where .= "(" . $this->buildWhereCondition($params, $returnParams, $firstOperator, $value["group"]) . ")";
				}
			} 
			else {
				$rs = $this->checkWhere(
					$value["where"]
					, $value["paramName"]
					, $params
					, isset($value["require"]) ? $value["require"] : false
				);
				if($rs) {
					if(isset($value["format"]) && is_object($value["format"])) {
						$returnParams[$value["paramName"]] = $value["format"]($params[$value["paramName"]]);	
					} else {
						$returnParams[$value["paramName"]] = $params[$value["paramName"]];	
					}
					$sqlWhere = $value["where"];
					$operator = isset($value["operator"]) ? $value["operator"] : " AND ";
					if($firstOperator != "") {
						$sqlWhere = " " . $operator . " " . $sqlWhere;
					}
					$where .= $sqlWhere;
					if($where != "" && $firstOperator == "") {
						$firstOperator = $operator;
					}
				}
			}
		}
		return $where;
	}

	private function checkWhere($sqlWhere, $paramName, $params, $isRequire = false) {
		$result = false;
		if($isRequire && !array_key_exists($paramName, $params)) {
			throw new  InvalidArgumentException("The param $paramName not found.");
		}
		if($isRequire || (is_array($params) && array_key_exists($paramName, $params) && !StringUtil::isNullOrEmpty($params[$paramName]))) {
			$result = true;
		}
		return $result;
	}

	private function isMultiArray($arr){
		if (empty($arr)) {
			return false;
		}else{
			foreach ($arr as $a){
				if (is_array($a)) return true;
			}
			return false;
		}
	}

	private function createSqlCount($sql) {
        $sql = "SELECT COUNT(1) AS CNT FROM (".$sql.") A";
        return $sql;
	}
	
	private function hasWhere($sql) {
		$sql = StringUtil::removeWhiteSpace(StringUtil::removeNewLine($sql));
		preg_match_all('#( where)#i', $sql, $matches);
		return isset($matches[0]) && count($matches[0]) > 0;
	}

	private function caculateFromRecord($totalRow, $pageSize, $currentPage, &$from) {
		$maxPage = ceil($totalRow/$pageSize);
		if($maxPage == 0) {
			$maxPage = 1;
		}
		if($currentPage == 0) {
			$currentPage = 1;
		}
		if($currentPage > 1 && $currentPage > $maxPage) {
			$currentPage = $maxPage;
		}
		$from = ($currentPage - 1) * $pageSize;
	}

}
?>