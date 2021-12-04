<?php
require_once ROOT_PATH_DAO . "/core/BaseDao.php";
class MStaffMonthlyComissionDao extends BaseDao {
	public function __construct() {
		parent::__construct("staff_monthly_comission");
	}
    public function deleteByStaffid($staff_id, $comm_year_month) {
        return parent::update(
            array("deleted_flag" => 1)
            ,array(
                "where" => "staff_id = :staff_id AND comm_year_month = :comm_year_month"
                , "params" => array("office_id" => $OfficeId, "comm_year_month" => $comm_year_month)
            )
            ,false
        );

    }

}
?>