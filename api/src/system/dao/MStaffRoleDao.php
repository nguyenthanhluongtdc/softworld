<?php
require_once ROOT_PATH_DAO . "/core/BaseDao.php";
class MStaffRoleDao extends BaseDao {
	public function __construct() {
		parent::__construct("m_staff_roles");
	}

	public function deleteByStaffId($staff_id) {
		return parent::delete(
			array(
				"where" => "staff_id = :staff_id"
				, "params" => array("staff_id" => $staff_id)
			)
		);
	}

	public function insertByStaffIdAndRole($staff_id, $stemp_role)
	{
		foreach ($stemp_role as $value) {
			$staff_role_params = array(
			'staff_id' => $staff_id,
			'role_id'  => $value
			);
			$a = $this->insert($staff_role_params);
		}	
	}

	public function selectByStaffId($staff_id)
	{
		$sql = "SELECT role_id FROM m_staff_roles where  staff_id = :staff_id";
		return parent::select(
			$sql
			,array(
				"staff_id" => $staff_id
			)
		);
	}

}
?>