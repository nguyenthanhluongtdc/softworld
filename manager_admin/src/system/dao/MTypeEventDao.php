<?php

require_once ROOT_PATH_DAO . "/core/BaseDao.php";
require_once ROOT_PATH_DAO . "/MStaffRoleDao.php";
class MTypeEventDao extends BaseDao {
	
	public function __construct() {
		parent::__construct("e_event_type");
	}
	
	public function getUserNameById($staffId) {
		$sql = "SELECT event_name FROM e_event WHERE id = :id";
		$user = $this->selectOne($sql, array("staff_id" => $staffId));
		if($user) {
			return $user["staff_name"];
		}
		return null;
	}

	public function getTypeEventById($id) {
		$sql = "SELECT * FROM e_event_type WHERE id = :id and deleted_flag <> 1";
		return $this->selectOne($sql, array("id" => $id));
	}
	
	public function getUser($staffEmail, $userPassword) {
		$sql = "SELECT * FROM m_staff WHERE staff_email = :staffEmail AND staff_password = :userPassword AND deleted_flag <> 1";
		return $this->selectOne($sql, array("staffEmail" => $staffEmail, "userPassword" => $userPassword));
	}
	
	public function getWithPagging($currentPage, $pageSize, $sortCondition, &$totalRow, $params) {
		$sql = "SELECT * FROM e_event_type
				WHERE deleted_flag <> 1";
		$andwhere = null;
		if (!StringUtil::isNullOrEmpty($params['id'])) {
            $andwhere .= " AND e_event_type.id = :id";
        }
        if (!StringUtil::isNullOrEmpty($params['name_type'])) {
        	$params['name_type'] = "%".$params['name_type']."%";
            $andwhere .= " AND e_event_type.name_type LIKE :name_type";
        }if (!StringUtil::isNullOrEmpty($params['code_color'])) {
        	$params['code_color'] = "%".$params['code_color']."%";
            $andwhere .= " AND e_event_type.code_color LIKE :code_color";
        }if (!StringUtil::isNullOrEmpty($params['code_type'])) {
        	$params['code_type'] = "%".$params['code_type']."%";
            $andwhere .= " AND e_event_type.code_type LIKE :code_type";
        }
       
        $sql .= $andwhere;
		$endsql ="  order by " . $sortCondition;
		$sql .= $endsql;

		return $this->selectWithPagging($currentPage, $pageSize, $totalRow, $sql, $params);
	}

	public function deleteLogic($id) {
		return parent::update(
			array("deleted_flag" => 1)
			, array(
				"where" => "id = :id"
				, "params" => array("id" => $id)
			)
			, false
		);
	}

	public function getAllTypeEvent(){
		$sql = "SELECT id, name_type FROM e_event_type where deleted_flag <> 1 ";
		$typeEvent = $this->select($sql);
		return $typeEvent;
	}

	public function getSuperviserEdit($staff_id){
		$sql = "SELECT staff_id,staff_name FROM m_staff where deleted_flag <> 1 AND staff_id != :staff_id";
		$staff = $this->select($sql,array("staff_id" => $staff_id));
		return $staff;
	}

	public function isExistEmail($email, $staff_id = ''){
		$sql = "SELECT * FROM m_staff WHERE staff_email = :staff_email AND  m_staff.deleted_flag <> 1";
		if(!empty($staff_id)){
			$sql = $sql. " AND staff_id <> :staff_id";
		}
		return $this->selectOne($sql, array("staff_email" => $email, "staff_id" => $staff_id));
	}

	public function doRegist($params){
		$id = null;
		$editStaffId = null;
		if(array_key_exists("staff_id", $params)) {
			$editStaffId = $params["staff_id"];
		}
		if(!StringUtil::isNullOrEmpty($editStaffId)) {
			$stemp_role = $params['staff_role'];
			unset($params['deleted_flag']);
			unset($params['staff_id']);
			$dbManger = DbManager::getInstance();
			$dbManger->beginTransaction();
			try{
				$id = $this->update(
					$params
					, array(
						"where" => "staff_id = :staff_id"
						, "params" => array("staff_id" => $editStaffId)
					)
				);
				if($id){
					$staff_role = new MStaffRoleDao();
					$staff_role->deleteByStaffId($editStaffId);
					$staff_role->insertByStaffIdAndRole($editStaffId, $stemp_role);
				}
				$dbManger->commit();
			}
			catch(Exception $e){
				$dbManger->rollback();
			}
		} else {
			$stemp_role = $params['staff_role'];
			$dbManger = DbManager::getInstance();
			$dbManger->beginTransaction();
			try{
				$id = $this->insert($params);
				if($id){
					$staff_role = new MStaffRoleDao();
					$staff_role->insertByStaffIdAndRole($id, $stemp_role);
				}
				$dbManger->commit();
			}
			catch(Exception $e){
				$dbManger->rollback();
			}
		}
		return $id;
	}

	public function getStaffSentMail(){
		$sql = "SELECT m_staff.staff_name,m_staff.staff_email FROM m_staff WHERE deleted_flag <> 1 AND staff_is_notify_mail = 1";
		return $this->select($sql);
	}

	public function getInChangeAndSupervisor($prj_id){
		$sql = "SELECT
					pa.prj_staff_id
				    , s.staff_supervisor
				FROM
					prj_assign_info pa
				    INNER JOIN m_staff s
				    ON pa.prj_staff_id = s.staff_id
				    AND s.deleted_flag <> 1
				WHERE
					pa.deleted_flag <> 1
					AND pa.deleted_flag <> 1
					AND pa.prj_role_grp = 1
					AND pa.prj_staff_pos = 1
			        AND pa.prj_id = :prj_id";#input param"
		$params = array('prj_id' => $prj_id);
		return $this->selectOne($sql,$params);
	}

	public function checkIsSendMail($staff_id){
		$sql = "SELECT 1 FROM m_staff WHERE staff_id = :staff_id AND staff_is_notify_mail = 1 AND deleted_flag <> 1";
		return $this->selectOne($sql, array('staff_id' => $staff_id));	
	}
}
?>