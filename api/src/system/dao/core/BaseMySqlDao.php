<?php
 require_once ROOT_PATH_DAO . "/core/AbstractDao.php";
class BaseMySqlDao extends AbstractDao {
	
	public function __construct($config) {
        $this->config = $config;
        $this->logger = LoggerManager::getLogger("DAO");
    }

	public function sqlEscapeString($value) {
		return mysql_real_escape_string($value);
	}
	
	public function query($sql, $params = null) {
		if(isset($params)) {
			$sql = $this->attachParams($sql, $params);	
		}
		// write log the sql command
		$this->logger->debug(get_class($this) . "#query[run sql = (" . $sql . ")]");
		$rs = mysql_query($sql, $this->connect);
		if($rs) {
			return $rs;
		} else {
			die(mysql_error($this->connect));
		}
	}
	
	public function fetchArray($result) {
		return @mysql_fetch_array($result, MYSQL_ASSOC);
	}

	public function numRows($result) {
		return @mysql_num_rows($result);
	}

	public function freeResult($result) {
		return @mysql_free_result($result);
	}

	public function insertId() {
		return @mysql_insert_id($this->connect);
	}

	public function affectedRows() {
		return @mysql_affected_rows($this->connect);
	}

	public function connect() {
		$this->connect = mysql_connect(
			$this->config["host"]
			, $this->config["user"]
			, $this->config["password"]
			, true) or die('Could not connect to database');
		if ($this->connect){
			@mysql_select_db($this->config["db"], $this->connect) or die ("Could not select database");
			if(StringUtil::isNullOrEmpty($this->config["encoding"])) {
				$this->config["encoding"] = "utf8";
			}
			@mysql_query("SET NAMES '" . $this->config["encoding"] . "'", $this->connect);	
		}
	}

	public function close() {
		if($this->connect) {
			@mysql_close($this->connect);
			$this->connect = null;
		}
	}
}
?>