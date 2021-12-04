<?php
require_once ROOT_PATH_DAO . "/core/BaseDao.php";
class MPrjProgressDao extends BaseDao {
	public function __construct() {
		parent::__construct("prj_progress_info");
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
		$sql = "SELECT * FROM prj_progress_info WHERE prj_id = :id and deleted_flag <> 1";
		$params = array(
			'id' => $Id
		);
		return $this->selectOne($sql, $params);
	}

	public function doInsertUpdate($params){
		if(!StringUtil::isNullOrEmpty($params['prj_id'])){
			$progress = $this->getById($params['prj_id']);
			if(ArrayUtil::isNullOrEmpty($progress) || $progress == false)
			{
				return $this->insert($params);
			}
			else{
				$id = $params['prj_id'];
				unset($params['prj_id']);
				return $this->update(
					$params
					, array(
						"where" => "prj_id = :prj_id"
						, "params" => array("prj_id" => $id)
					)
				);
			}
		}
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