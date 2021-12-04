<?php

abstract class AbstractDao {

	protected $logger;

	public $tableName;

	protected $connect;

	protected $config;
	
	public $isTransactionStart;

	public abstract function query($sql, $params);

	public abstract function sqlEscapeString($value);

	public abstract function fetchArray($result);

	public abstract function numRows($result);

	public abstract function freeResult($result);
	
	public abstract function insertId();

	public abstract function affectedRows();

	public abstract function connect();
	
	public abstract function close();
	
	public function insert($tableName, $arr){
		$fields = array();
		$values = array();
		foreach ($arr as $field=>$val){
			// null value => skip
			if($val != null || is_numeric($val)) {
				$fields[] = "`$field`";
				$values[] = $this->filter($val);
			}
		}
		$fields = implode(',', $fields);
		$values = implode(',', $values);
		$sql = "INSERT INTO " . $tableName . "($fields) VALUES ($values);";
		// write log the sql command
		$this->logger->debug(get_class($this) . "#insert[run sql = (" . $sql . ")");
		if($this->query($sql)) {
			$id = $this->insertId();
			if($id == 0) {
				$id = 1;
			}
			return $id;
		} else {
			return 0;
		}
	}

	public function update($tableName, $arr, $where, $delete){
		$set = null;
		if (is_array($arr)) {
			$set = array();
			foreach ($arr as $field=>$val){
				$set[] = "`$field`=" . $this->filter($val);;
			}
			$set = implode(', ', $set);
		} else {
			throw new Exception("The first parameter is require array with format key => value", 1);
		}
		
		// write log the sql command
		$sql = 'UPDATE ' . $tableName . " SET $set";
		
		// define default condition
		if($delete){
			$defaultWhere = " deleted_flag <> 1";
		}else {
			$defaultWhere = " deleted_flag = 1";
		}
		
		if(!isset($where)) {
			$where = array("where" => $defaultWhere);
		} else { //tồn tại
			$where ["where"] .=  " and " . $defaultWhere;
		} 
		
		if(isset($where['params'])) {
			$sql .= " WHERE " . $this->attachParams($where['where'] , $where['params']);
		} else {
			$sql .= " WHERE " . $where['where'];
			
		}
		
		// attach parameters
		
		// write log
		$this->logger->debug(get_class($this) . "#update[run sql = (" . $sql . ")");

		// execute query
        $result = $this->query($sql);
        $affectedRows = 0;
        if($result) {
        	 $affectedRows = $this->affectedRows();
	        // write log
			$this->logger->debug(get_class($this) . "#update result = (" . $affectedRows . ")");
        } else {
			$this->logger->debug(get_class($this) . "#update query false");
        }
        // return record affected
		return $affectedRows;
	}

	public function delete($tableName, $where){
		$sql = 'DELETE FROM ' . $tableName;
		if(isset($where)) {	
			if(isset($where['where']) && isset($where['params'])) {
				$sql .= " WHERE " . $this->attachParams($where['where'], $where['params']);	
			} else if(isset($where['where'])) {
				$sql .= " WHERE " . $where['where'];
			}
		}
		// write log the sql command
		$this->logger->debug(get_class($this) . "#delete[run sql = (" . $sql . ")");

		$this->query($sql);
		// return record affected
		return $this->affectedRows();
	}

	public function selectAll($tableName){
		$sql = 'SELECT * FROM ' . $tableName . ' where deleted_flag <> 1';
		// write log the sql command
		$this->logger->debug(get_class($this) . "#selectAll[run sql = (" . $sql . ")");
		return $this->query($sql);
	}

	public function beginTransaction() {
		// write log
		$this->logger->debug(get_class($this) . "#beginTransaction");
		if(!$this->connect) {
			$this->connect();
		}
		$this->isTransactionStart = true;
		if($this->connect) {
			$this->query("START TRANSACTION;");
		}
	}

	public function commit() {
		if($this->isTransactionStart) {
			// write log
			$this->logger->debug(get_class($this) . "#commit");
			$this->query("COMMIT;");
			$this->isTransactionStart = false;
			$this->close();	
		}
	}

	public function rollback() {
		if($this->isTransactionStart) {
			// write log
			$this->logger->debug(get_class($this) . "#rollback");
			$this->query("ROLLBACK;");
			$this->isTransactionStart = false;
			$this->close();
		}
	}
	private function sortKeyLength($params) {
		$arrayKeys = array_keys($params);

		usort($arrayKeys, function($a, $b){
			if(strlen($a) > strlen($b)) {
				return -1;
			}
			if(strlen($a) < strlen($b)) {
				return 1;
			}
			return 0;
		});

		return $arrayKeys;
	}

	public function attachParams($sql, $params) {
		if(isset($params)) {
			$arrayKeys = $this->sortKeyLength($params);
			foreach ($arrayKeys as $key) {
	            $p = $this->filter($params[$key]);
				$key = $this->repaireParamName($key);
				$posParameter = strpos($sql, $key);
				while ($posParameter) {
	            	$sql = substr_replace($sql, $p, $posParameter, strlen($key));
	            	$posParameter = strpos($sql, $key, $posParameter);
				}
			}	
		}
		return $sql;
	}

	private function repaireParamName($name) {
		if(!StringUtil::startsWith($name, ":")) {
			$name = ":" . $name;
		}
		return $name;
	}

	private function filterSingleValue($value) {
		$result = '';
		if (is_bool($value))
        {
            $result = $value ? 'TRUE' : 'FALSE';
        }
        else if (is_float($value) || is_int($value))
        {
            $result = $value;
        }
        else if (is_null($value))
        {
            $result = 'NULL';
        }
        else
        {
            $result = "'" . $this->sqlEscapeString($value) . "'";
        }
        return $result;
	}

	private function filter($value) {
		$result = '';
		if(is_array($value)) {
			$subParams = array();
			foreach ($value as $p) {
				$subParams[] = $this->filterSingleValue($p);
			}
			$result = implode(',', $subParams);
		} else {
			$result = $this->filterSingleValue($value);
		}
		return $result;
	}
}
?>