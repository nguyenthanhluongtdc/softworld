
<?php

require_once ROOT_PATH_DAO . "/core/BaseDao.php";
class MStaffComDao extends BaseDao {
	public function __construct() {
		parent::__construct("prj_staff_comission");
	}

	public function checkExistCommission($params){
		$sql = "SELECT prj_id 
        		FROM prj_staff_comission 
        		WHERE prj_id= :prj_id
        		 AND staff_id= :staff_id
        		 AND staff_group = :staff_group
        		 AND (cancel_flag <> 1 OR cancel_flag IS NULL)
        		 ";
        if($params['cancel_flag'] === 1){
        	$sql = "SELECT prj_id 
        		FROM prj_staff_comission 
        		WHERE prj_id= :prj_id
        		 AND staff_id= :staff_id
        		 AND staff_group = :staff_group
        		 AND cancel_flag = 1
        		 ";
        }
        return $this->selectOne($sql,$params);
    }

    public function insertCom($params){
    	return $this->insert($params);
    }

    public function updateCom($params){
    	$condition = array(
            'prj_id'        => $params['prj_id']
            ,'staff_id'     => $params['staff_id']
            ,'staff_group'  => $params['staff_group']
            ,'cancel_flag'  => $params['cancel_flag']
        );
        unset($params['prj_id']);
        unset($params['staff_id']);
        unset($params['staff_group']);
        $where = "prj_id = :prj_id 
                        AND staff_id= :staff_id 
                        AND staff_group = :staff_group 
                        AND cancel_flag = :cancel_flag";
        if($params['cancel_flag'] === null){
            $where = "prj_id = :prj_id 
                        AND staff_id= :staff_id 
                        AND staff_group = :staff_group 
                        AND (cancel_flag <> 1 OR cancel_flag IS NULL)";
        }
    	return $this->update(
			$params
            , array(
            "where" => $where
            , "params" => $condition
            ),
            false
    	);
    }
}
?>