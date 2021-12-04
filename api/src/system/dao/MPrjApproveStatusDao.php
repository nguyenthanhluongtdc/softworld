<?php
require_once ROOT_PATH_DAO . "/core/BaseDao.php";
class MPrjApproveStatusDao extends BaseDao {
	
	public function __construct() {
		parent::__construct("prj_approve_status");
	}

	public function getApproveStatusOfStaffMail($prj_id){
		$sql = 'SELECT 
					m_staff.staff_name
					,m_staff.staff_id
					,m_staff.staff_department_id
					,app_sts.approve_sts
					,app_sts.updated_time
					,app_sts.approve_date
				FROM m_staff
				LEFT JOIN
					(SELECT * FROM prj_approve_status where prj_id = :prj_id AND deleted_flag <> 1) as app_sts
				ON m_staff.staff_id = app_sts.staff_id
				WHERE m_staff.staff_is_notify_mail = 1';
		$params = array(
			'prj_id' => $prj_id
		);
		return $this->select($sql,$params);
	}

	public function checkExist($prj_id,$staff_id){
		$sql = "SELECT * FROM prj_approve_status where prj_id = :prj_id AND staff_id = :staff_id AND deleted_flag <> 1";
		$params = array(
			'prj_id' 	=> $prj_id
			,'staff_id' 	=> $staff_id
		);
		return $this->selectOne($sql,$params);
	}
}
?>