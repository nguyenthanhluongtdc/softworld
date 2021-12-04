<?php
require_once ROOT_PATH_DAO . "/core/BaseDao.php";
class MFileHistoryDao extends BaseDao {
	public function __construct() {
		parent::__construct("prj_file_history");
	}

	public function deleteId($Id) {
		return parent::delete(
			array(
				"where" => "id = :id"
				, "params" => array("id" => $Id)
			)
		);
	}

	public function getById($Id){
		$sql = "SELECT * FROM prj_file_history WHERE id = :id and deleted_flag <> 1";
		$params = array(
			'id' => $Id
		);
		return $this->selectOne($sql, $params);
	}

	public function selectTable($params, $sortCondition){
		$sql = "SELECT prj_file_history.*,m_staff.staff_name from prj_file_history LEFT JOIN m_staff ON prj_file_uploaded_staff = staff_id WHERE  prj_file_history.deleted_flag <> 1 AND prj_file_type = :prj_file_type AND prj_id = :prj_id ".$sortCondition;
		return $this->select($sql,$params);
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