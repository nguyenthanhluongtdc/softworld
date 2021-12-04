<?php
require_once ROOT_PATH_DAO . "/core/BaseDao.php";
class MPrjUpdateHistoryDao extends BaseDao {
	public function __construct() {
		parent::__construct("prj_update_history");
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

	public function getByPrjId($Id){
		$sql = "SELECT * FROM prj_update_history where  prj_id = :prj_id ORDER BY upd_item_id ASC";
		return parent::select(
			$sql
			,array(
				"prj_id" => $Id
			)
		);
	}

	public function getHistoryByPrjIdAndId($prj_id, $id){
		$sql = "SELECT * FROM prj_update_history WHERE prj_update_history.id = :id AND prj_id = :prj_id";
		return parent::select(
			$sql
			,array(
				"prj_id" => $prj_id
				,'id'	 => $id
			)
		);
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

	/* this function called when a project created
	*/
	public function insertDefaultData($prj_id, $staff_id, $upd_item_id){
		$result = true;
		$temp = array();
		$sql_get_max_id = "select ifnull(max(id),0)  + 1 AS max_id FROM prj_update_history ;";
		$max_id = $this->select($sql_get_max_id);
		if(StringUtil::isNullOrEmpty($max_id[0]['max_id']) || $max_id[0]['max_id'] <= 0)
			return false;
		$max = $max_id[0]['max_id'];
		$time_now =  DateUtil::getCurrentDatetime();
		for ($i=1,$count = count(AppConfig::$HISTORY_CHANGE); $i <= $count; $i++) {
			$status = 0;
   			$params = array(
   							'id' 				=> $max
   							,'prj_id' 			=> $prj_id 
   							,'upd_item_id'		=> $i
   							,'upd_by' 			=> $staff_id
   							,'upd_item_before' 	=> null
   							,'upd_item_after'  	=> $upd_item_id[$i]
   							,'upd_date_time'	=> $time_now
   							,'upd_sts'			=> $status
   							);
   			$temp[] = parent::insert($params);
   		}
   		for ($i=0,$count = count($temp); $i < $count ; $i++) { 
  			if($temp[$i] <= 0) {
  				$result = false;
  				break;
  			}
   		}
   		return $result;
	}
	/* this funciton called when edit a project */
	public function updateData($prj_id, $staff_id, $upd_item_id, $upd_item_id_old, $upd_sts){
		$result = true;
		$temp = array();
		if(ArrayUtil::isNullOrEmpty($upd_item_id_old))
		{
			return $this->insertDefaultData($prj_id, $staff_id, $upd_item_id);
		}
		$sql_get_max_id = "select ifnull(max(id),0)  + 1 AS max_id FROM prj_update_history ;";
		$max_id = $this->select($sql_get_max_id);
		if(StringUtil::isNullOrEmpty($max_id[0]['max_id']) || $max_id[0]['max_id'] <= 0)
			return false;
		$max = $max_id[0]['max_id'];
		$time_now =  DateUtil::getCurrentDatetime();
		for ($i=1,$count = count(AppConfig::$HISTORY_CHANGE); $i <= $count; $i++) { 
			$params = array(
				'id'				=> $max
				,'prj_id'		  	=> $prj_id
				,'upd_item_id'		=> $i
				,'upd_by' 		  	=> $staff_id
				,'upd_item_before' 	=> $upd_item_id_old[$i]
				,'upd_item_after' 	=> $upd_item_id[$i]
				,'upd_sts' 		  	=> $upd_sts[$i]
				,'upd_date_time'	=> $time_now
			);
			$temp[] = parent::insert($params);
		}
		for ($i=0,$count = count($temp); $i < $count ; $i++) { 
  			if($temp[$i] <= 0)
  				return false;
   		}
   		return $result;
	}

	/*sub table in tab 1 (table3)*/
	public function getProgressUpdate($prj_id){
		$sql = "SELECT prj_update_history.id
			 ,prj_update_history.prj_id 															# history id 
			 ,m_udp_by.staff_name as update_user 								#変更者名
			 ,prj_update_history.upd_date_time  as updated_time	# time update 
			 ,GROUP_CONCAT(prj_update_history.upd_item_id ) as changes
		     ,m_staff.staff_name as staff_in_charge 						#承認者名1
				 ,(	SELECT s.staff_name  
					FROM m_staff s 
					WHERE s.staff_id = m_staff.staff_supervisor) as supervisor_name #承認者名2

				FROM `prj_update_history` 
				INNER JOIN prj_assign_info 
				ON prj_update_history.prj_id = prj_assign_info.prj_id
				INNER JOIN m_staff ON prj_assign_info.prj_staff_id = m_staff.staff_id
				INNER JOIN m_staff m_udp_by ON prj_update_history.upd_by = m_udp_by.staff_id

				WHERE prj_update_history.prj_id   = :prj_id
				AND prj_assign_info.prj_role_grp  = 1
				AND prj_assign_info.prj_staff_pos = 1
				and prj_update_history.upd_sts    = 1
			GROUP BY prj_update_history.id
			ORDER BY prj_update_history.id DESC
			 ";
		$params = array(
			'prj_id' => $prj_id
		);
		return $this->select($sql, $params);
	}

	public function getLastChangeByPrjId($prj_id, $updated_time){
		$sql = "SELECT * FROM prj_update_history WHERE prj_id = :prj_id AND updated_time = :updated_time";
		$params = array('prj_id' => $prj_id, 'updated_time' => $updated_time);
		return $this->select($sql, $params);
	}

	/*get update last by prj_id*/
	public function getLastHistoryByPrjId($Id){
		$sql = "SELECT *
				  	FROM prj_update_history 
				  	JOIN ( SELECT MAX(max_hi.created_time) AS max_created_time
				           FROM prj_update_history max_hi 
				      	 ) m
				    ON prj_update_history.created_time = m.max_created_time
				WHERE prj_update_history.prj_id = :prj_id
				";
		return parent::select(
			$sql
			,array(
				"prj_id" => $Id
			)
		);
	}
}
?>