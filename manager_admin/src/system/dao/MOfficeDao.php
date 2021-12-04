<?php

require_once ROOT_PATH_DAO . "/core/BaseDao.php";
class MOfficeDao extends BaseDao {
	
	public function __construct() {
		parent::__construct("m_office_info");
	}
	
	
    public function getOfficeById($officeId) {
        $sql = "SELECT * FROM m_office_info WHERE office_id = :office_id and deleted_flag <> 1";
        return $this->selectOne($sql, array("office_id" => $officeId));
    }
    
    public function getOfficeArrray(){
        $sql = "SELECT office_id,office_name FROM m_office_info WHERE deleted_flag <> 1";
        $office = $this->select($sql);
        return $office;
    }
    public function getWithPagging($currentPage, $pageSize, $sortCondition, &$totalRow, $params) {
        $sql = "SELECT 
                    *
                FROM 
                    m_office_info
                WHERE 
                    deleted_flag <> 1
            ";
        $result = $this->buildSql(
            $sql
            , $params
            , array(
                array(
                    "where" => "office_name like :office_name"
                    , "paramName" => "office_name"
                    , "format" => function($value) {
                        return '%' . $value . '%';
                    }
                )
                , array(
                    "where" => "office_phone_num like :office_phone_num"
                    , "paramName" => "office_phone_num"
                    , "format" => function($value) {
                        return '%' . $value . '%';
                    }
                )
                , array(
                    "where" => "office_prefectures = :office_prefectures"
                    , "paramName" => "office_prefectures"
                )
            )
        );
        if(StringUtil::isNullOrEmpty($sortCondition)) {
            $sortCondition = " IFNULL(updated_time, created_time) desc";
        } else {
            $sortCondition .= ", IFNULL(updated_time, created_time) desc";
        }

        $result["sql"] .= " order by " . $sortCondition;
        return $this->selectWithPagging($currentPage, $pageSize, $totalRow, $result["sql"], $result["params"]);
    }

    public function delete($OfficeId) {
        return parent::update(
            array("deleted_flag" => 1)
            ,array(
                "where" => "office_id = :office_id"
                , "params" => array("office_id" => $OfficeId)
            )
            ,false
        );

    }

}
?>