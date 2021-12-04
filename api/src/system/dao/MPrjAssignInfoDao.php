<?php

require_once ROOT_PATH_DAO . "/core/BaseDao.php";
class MPrjAssignInfoDao extends BaseDao {
	
	public function __construct() {
		parent::__construct("prj_assign_info");
	}
    
    public function getList()
    {
        return $this->selectAll();
    }
    
    public function getStaffname($id)
    {
        $sql = "SELECT * FROM m_staff AS st join prj_assign_info AS p ON st.staff_id = p.prj_staff_id WHERE st.staff_id= :staff_id";
        return $this->selectOne($sql,array("staff_id"=>$id));
    }

    public function doInsert($params){
        return $this->insert($params);
    }

    public function getByPrjId($Id, $prj_role_grp){
        $sql = "SELECT * FROM prj_assign_info WHERE prj_id = :prj_id AND prj_role_grp = :prj_role_grp ORDER BY prj_role_grp ASC, prj_staff_pos ASC";
        return $this->select($sql,array("prj_id"=>$Id, "prj_role_grp" => $prj_role_grp));
    }

    /*
        delete from by prj_id;
    */
    public function deleteFromByPrjId($Id){
        return parent::delete(
            array(
                "where" => "prj_id = :prj_id"
                , "params" => array("prj_id" => $Id)
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
    public function GetStaffAssign($prj_id,$prj_role_grp,$prj_staff_pos){
        $sql = "SELECT st.* FROM m_staff AS st inner join prj_assign_info AS p ON st.staff_id = p.prj_staff_id WHERE p.prj_id= :prj_id AND p.prj_role_grp = :prj_role_grp AND p.prj_staff_pos = :prj_staff_pos";
        return $this->selectOne($sql,array("prj_id"=>$prj_id, 'prj_role_grp'=>$prj_role_grp, 'prj_staff_pos'=>$prj_staff_pos));
    }

}
?>