<?php

require_once ROOT_PATH_DAO . "/core/BaseDao.php";
require_once ROOT_PATH_DAO . "/MStaffRoleDao.php";
class MShuruiApproveDao extends BaseDao {
	
	public function __construct() {
		parent::__construct("prj_shurui_appr_mgt");
	}

	public function deleteLogic($prj_id) {
		return parent::update(
			array("deleted_flag" => 1)
			, array(
				"where" => "prj_id = :prj_id"
				, "params" => array("prj_id" => $staffId)
			)
			, false
		);
	}

	public function getByPrjId($prj_id) {
 		$sql = "SELECT prj_shurui_appr_mgt.*
			,m1.staff_name as userNameApprove1
			,m2.staff_name as userNameApprove2
		 FROM prj_shurui_appr_mgt 
		 LEFT JOIN m_staff m1 ON prj_shurui_appr_mgt.prj_pic_approve_id = m1.staff_id
		 LEFT JOIN m_staff m2 ON prj_shurui_appr_mgt.prj_sup_approve_id = m2.staff_id
		 WHERE prj_shurui_appr_mgt.prj_id = :prj_id GROUP BY prj_shurui_sort";
		return $this->select($sql, array("prj_id" => $prj_id));
   	}

   	public function UpdateApproveByPrjIdAndSortId($params){
		$prj_id = $params['prj_id'];
		$prj_shurui_sort = $params['prj_shurui_sort'];
		unset($params['prj_id']);
		unset($params['prj_shurui_sort']);
   		return parent::update(
   			$params,
   			array(
   				"where" => "prj_id = :prj_id AND prj_shurui_sort = :prj_shurui_sort"
            	,"params" => array(
   					'prj_id' => $prj_id
   					,'prj_shurui_sort' => $prj_shurui_sort
   				) 
   			)
   			,false
   		);
   	}

   	public function insertDefaultData($prj_id){
   		$result = true;
		$temp = array();
   		for ($i=1,$count = count(AppConfig::$HISTORY_APPROVE); $i <= $count ; $i++) { 
   			$params_shuri_appove = array('prj_id' => $prj_id, 'prj_shurui_sort'=> $i);
   			$temp[] = parent::insert($params_shuri_appove);
   		}
   		for ($i=0,$count = count($temp); $i < $count ; $i++) { 
  			if($temp[$i] <= 0)
  				return false;
   		}
   		return $result;
   	}

   	public function getByPrjIdStaffIdSortId($prj_id,$sort_id){
   		$sql = 'SELECT 1 FROM prj_shurui_appr_mgt WHERE prj_id = :prj_id AND  prj_shurui_sort = :prj_shurui_sort';
   		$params = array('prj_id' => $prj_id, 'prj_shurui_sort' => $sort_id);
   		return $this->selectOne($sql, $params);
   	}
}
?>