<?php
require_once ROOT_PATH_DAO . "/core/BaseDao.php";
class MProjectStatusHistoryDao extends BaseDao {
	public function __construct() {
		parent::__construct("prj_status_history");
	}
	public function deleteLogic($Id) {
		return parent::update(
			array("deleted_flag" => 1)
			, array(
				"where" => "id = :id"
				, "params" => array("id" => $Id)
			)
			, false
		);
	}

	public function getStatusHistoryByProjectId($Id){
		$sql = "SELECT * FROM prj_status_history where  prj_id = :prj_id";
		return parent::select(
			$sql
			,array(
				"prj_id" => $Id
			)
		);
	}

	public function getByProjectId($projectId) {
		$sql = "SELECT * FROM prj_status_history WHERE deleted_flag <> 1 AND prj_id = :prj_id  ORDER BY prj_status_updated_date DESC";
		$params = array(
			':prj_id' => $projectId
		);
        $data = $this->select($sql, $params);
        return $data;
	}
	/*
		update delete_flag = 1;
	*/
	public function DeleteByPrjId($prj_id){
		return parent::update(
			array("deleted_flag" => 1)
			, array(
				"where" => "prj_id = :prj_id"
				, "params" => array("prj_id" => $prj_id)
			)
			, false
		);
	}
}
?>