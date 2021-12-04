<?php
require_once ROOT_PATH_DAO . "/core/BaseDao.php";
class MPrjProdDao extends BaseDao {
	public function __construct() {
		parent::__construct("prj_prod_info");
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
		$sql = "SELECT * FROM prj_prod_info WHERE id = :id and deleted_flag <> 1";
		$params = array(
			'id' => $Id
		);
		return $this->selectOne($sql, $params);
	}

	public function getByPrjId($Id){
		$sql = "SELECT * FROM prj_prod_info WHERE prj_id = :prj_id";
		$params = array(
			"prj_id" => $Id
		);
		return $this->select($sql, $params);
	}

	public function doInsertUpdate($params){
		if(StringUtil::isNullOrEmpty($params['id']))
			return $this->insert($params);
		else
		{
			$id = $params['id'];
			unset($params['id']);
			unset($params['prj_id']);
			return $this->update(
					$params
					, array(
						"where" => "id = :id"
						, "params" => array("id" => $id)
					)
			);
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
    public function GetAllProdDao($prj_id){
        $sql = 'SELECT
                    prj_prod_info.sort_id,
                    prj_prod_info.prj_prod_class,
                    prj_prod_info.prj_prod_maker,
                    prj_prod_info.prj_prod_model,
                    prj_prod_info.prj_prod_num,
                    prj_prod_info.prj_prod_kw,
                    prj_prod_info.prj_prod_memo
                FROM
                    prj_info
                LEFT JOIN prj_prod_info ON prj_info.prj_id = prj_prod_info.prj_id
                WHERE
                    prj_info.prj_id = :prj_id AND prj_info.deleted_flag = 0';
        $params = array(
            "prj_id" => $prj_id
        );
        return $this->select($sql, $params);
    }
}
?>