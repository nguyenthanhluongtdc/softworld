<?php

require_once ROOT_PATH_DAO . "/core/AbstractDao.php";
class BaseMySqliDao extends AbstractDao {
	
	public function __construct($config) {
        $this->config = $config;
        $this->logger = LoggerManager::getLogger("DAO");
    }

	public function sqlEscapeString($value) {
		return mysqli_real_escape_string($this->connect, $value);
	}
	
	public function query($sql, $params = null) {
		if(isset($params)) {
			$sql = $this->attachParams($sql, $params);	
		}
		// write log the sql command
		$this->logger->debug(get_class($this) . "#query[run sql = (" . $sql . ")");
		$rs = mysqli_query($this->connect, $sql);
		if($rs) {
			return $rs;
		} else {
			die(mysqli_error($this->connect));
		}
	}

	public function pushArr($result){
		$records = null;

		if($result) {
			$records = array();
			while ($row = $this->fetchArray($result)) {
				$records[] = $row;
			}
		}	
		
		if(!$this->isTransactionStart) {
			$this->close();
		}

		if($result) {
			$this->freeResult($result);
		}

		return $records;
	}
	
	public function fetchArray($result) {
		return $result->fetch_array(MYSQLI_ASSOC);
	}

	public function numRows($result) {
		return $result->num_rows;
	}

	public function freeResult($result) {
		return $result->free_result();
	}

	public function insertId() {
		return $this->connect->insert_id;
	}

	public function affectedRows() {
		return mysqli_affected_rows($this->connect);
	}

	public function connect() {
		$this->connect = mysqli_connect(
			$this->config["host"]
			, $this->config["user"]
			, $this->config["password"]
			, $this->config["db"]) or die('Could not connect to database');
		if ($this->connect){
			if(StringUtil::isNullOrEmpty($this->config["encoding"])) {
				$this->config["encoding"] = "utf8";
			}
			$this->connect->set_charset($this->config["encoding"]);
		}

	}
	
	public function close() {
		if($this->connect) {
			$this->connect->close();
			$this->connect = null;
		}
	}
}
?>