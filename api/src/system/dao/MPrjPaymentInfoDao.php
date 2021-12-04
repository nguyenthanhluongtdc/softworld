<?php
require_once ROOT_PATH_COMMON . "/MessageConstants.php";
require_once ROOT_PATH_DAO . "/core/BaseDao.php";

class MPrjPaymentInfoDao extends BaseDao {

    public function __construct() {
        parent::__construct("prj_payment_info");
    }

    public function getByPrjId($id) {
        $sql = "select * from prj_payment_info where prj_id= :prj_id";
        return $this->select($sql, array("prj_id" => $id));
    }

    public function getWithPagging($currentPage, $pageSize, $sortCondition, &$totalRow, $params) {
        $sql = "SELECT 
                    prj_info.prj_id
                    ,prj_info.prj_cust_name /*お客様名*/
                    ,prj_info.prj_cust_prefectures /*住所*/
                    ,prj_info.prj_cust_pos_code /*住所*/
                    ,prj_info.prj_cust_address /*住所*/
                    ,prj_info.prj_cust_city  /*住所*/
                    ,prj_info.prj_cust_mansion_info  /*住所*/
                    ,tb_staff_join.staff_name_prj /*担当者*/
                    ,tb_staff_join.staff_id_prj /*担当者ID*/
                    ,GROUP_CONCAT(DISTINCT payment_status) AS payment_status /*入金ステータス*/
                    ,prj_info.prj_pay_method /*支払い方法*/
                    ,prj_info.updated_time /*更新年月日*/
                    ,m_staff.staff_name AS userCreated /*登録者*/
                FROM prj_info 
    
                /*get payment_status for all of a payments of project*/
                INNER JOIN
                (
                    SELECT 
                        p.prj_id 
                        ,ppi.id
                        ,CASE  
                            WHEN ppi.sort_id < 6 AND DATE_ADD(ppi.prj_billing_date, INTERVAL ppi.prj_plan_pay_day DAY) >= now() /*deadline >= now*/
                                AND (ppi.prj_paid_date IS NULL OR prj_plan_paid_amount IS NULL OR prj_plan_paid_amount < prj_plan_pay_amount) THEN 1  /*and paid_mount < paymount then 1 未入金（入金予定日前）有*/
                            WHEN ppi.sort_id < 6 AND DATE_ADD(ppi.prj_billing_date, INTERVAL ppi.prj_plan_pay_day DAY) < now() /*deadline < now */ 
                                AND (ppi.prj_plan_paid_amount < ppi.prj_plan_pay_amount OR ppi.prj_paid_date IS NULL OR ppi.prj_plan_paid_amount IS NULL) THEN 2 /*and paid_mount < paymount then 2 未入金（延滞）有*/
                            WHEN ppi.sort_id < 6 AND DATE_ADD(ppi.prj_billing_date, INTERVAL ppi.prj_plan_pay_day DAY) < ppi.prj_paid_date THEN 2/*paid_date < deadline then 2 未入金（延滞）有*/
                            WHEN ppi.sort_id < 6 AND DATE_ADD(ppi.prj_billing_date, INTERVAL ppi.prj_plan_pay_day DAY) >= ppi.prj_paid_date /*paid_date >= deadline*/
                                AND prj_plan_paid_amount >= prj_plan_pay_amount THEN 3 /*and paid_amount >= pay_mount then 3 入金済み有*/
                            WHEN ppi.sort_id = 6 AND (DATE_ADD(ppi.prj_billing_date, INTERVAL ppi.prj_plan_pay_day DAY) <  ppi.prj_paid_date
                                OR ifnull(ppi.prj_plan_pay_amount,0) > ifnull(ppi.prj_plan_paid_amount,0))  THEN 4
                            END AS payment_status FROM prj_info p 
                            LEFT JOIN prj_payment_info ppi 
                            ON  p.prj_id = ppi.prj_id 
                            WHERE   1 = 1 
                )AS temp 
                ON prj_info.prj_id = temp.prj_id
        
                /*get all staff was joined in project*/
                LEFT JOIN(
                        SELECT  
                            GROUP_CONCAT(DISTINCT m_staff.staff_name) AS staff_name_prj,
                            GROUP_CONCAT(DISTINCT m_staff.staff_id) AS staff_id_prj,
                            prj_assign_info.prj_id 
                        FROM prj_assign_info 
                        INNER JOIN m_staff 
                        ON prj_assign_info.prj_staff_id = m_staff.staff_id
                        GROUP BY  prj_assign_info.prj_id 
                        ) AS tb_staff_join      
                ON prj_info.prj_id = tb_staff_join.prj_id
        
                /*get staff created the project*/
                INNER JOIN m_staff ON prj_info.created_user = m_staff.staff_id 

                /*get project has payment*/
                INNER JOIN (
                    SELECT prj_payment_info.prj_id 
                    FROM prj_payment_info 
                    INNER JOIN prj_info 
                    ON prj_payment_info.prj_id = prj_info.prj_id 
                    GROUP BY prj_id)AS pp
                ON pp.prj_id = prj_info.prj_id";

        $default_where =       " WHERE prj_info.deleted_flag <> 1 ";
        if(!StringUtil::isNullOrEmpty($params['role_required'])){//just project was assign
            $role_required = " INNER JOIN
                    (
                    SELECT prj_assign_info.prj_id FROM prj_assign_info
                            INNER JOIN m_staff 
                            ON prj_assign_info.prj_staff_id = m_staff.staff_id
                            WHERE m_staff.staff_id = :role_required  )prj_assign 
                    ON prj_info.prj_id = prj_assign.prj_id ";
            $sql .= $role_required;
        }
        $sql .= $default_where;
        if(!empty($params['prj_status_payment'])){
            $andwhere = " AND 
            EXISTS (
            SELECT 
            1,p1.prj_id
                FROM prj_info p1
                INNER JOIN prj_payment_info pp ON p1.prj_id = pp.prj_id
                WHERE p1.prj_id = prj_info.prj_id
                AND (
                    CASE  
                    WHEN pp.sort_id < 6 AND DATE_ADD(pp.prj_billing_date, INTERVAL pp.prj_plan_pay_day DAY) >= now() /*deadline >= now*/
                            AND (pp.prj_paid_date IS NULL OR pp.prj_plan_paid_amount IS NULL OR pp.prj_plan_paid_amount < pp.prj_plan_pay_amount) THEN 1  /*and paid_mount < paymount then 1 未入金（入金予定日前）有*/
                    WHEN pp.sort_id < 6 AND DATE_ADD(pp.prj_billing_date, INTERVAL pp.prj_plan_pay_day DAY) < now() /*deadline < now */ 
                            AND (pp.prj_plan_paid_amount < pp.prj_plan_pay_amount OR pp.prj_paid_date IS NULL OR pp.prj_plan_paid_amount IS NULL) THEN 2 /*and paid_mount < paymount then 2 未入金（延滞）有*/
                    WHEN pp.sort_id < 6 AND DATE_ADD(pp.prj_billing_date, INTERVAL pp.prj_plan_pay_day DAY) < pp.prj_paid_date THEN 2/*paid_date < deadline then 2 未入金（延滞）有*/
                    WHEN pp.sort_id < 6 AND DATE_ADD(pp.prj_billing_date, INTERVAL pp.prj_plan_pay_day DAY) >= pp.prj_paid_date /*paid_date >= deadline*/
                            AND pp.prj_plan_paid_amount >= pp.prj_plan_pay_amount THEN 3 /*and paid_amount >= pay_mount then 3 入金済み有*/
                    WHEN pp.sort_id = 6 AND (DATE_ADD(pp.prj_billing_date, INTERVAL pp.prj_plan_pay_day DAY) <  pp.prj_paid_date
                                OR ifnull(pp.prj_plan_pay_amount,0) > ifnull(pp.prj_plan_paid_amount,0))  THEN 4
                    END
                ) in (:prj_status_payment)
            GROUP BY p1.prj_id
            ) ";
        }
        if(!ArrayUtil::isNullOrEmpty($params['prj_pay_method'])){
            $andwhere .= " AND prj_info.prj_pay_method IN (:prj_pay_method) ";
        }
        if (!StringUtil::isNullOrEmpty($params['prj_billing_date_from']) && !StringUtil::isNullOrEmpty($params['prj_billing_date_to'])) {
            $andwhere .= "AND 
                            EXISTS (
                                    SELECT 
                                        1
                                    FROM prj_info p1
                                    INNER JOIN prj_payment_info pp ON p1.prj_id = pp.prj_id
                                    WHERE p1.prj_id = prj_info.prj_id
                                    AND   DATE_ADD(pp.prj_billing_date,INTERVAL pp.prj_plan_pay_day DAY) BETWEEN  :prj_billing_date_from AND :prj_billing_date_to
                                    AND   pp.sort_id != 6
                                    GROUP BY p1.prj_id
                            ) ";
        } elseif (!StringUtil::isNullOrEmpty($params['prj_billing_date_from'])) {
            $andwhere .= " AND 
                            EXISTS (
                                    SELECT 
                                        1
                                    FROM prj_info p1
                                    INNER JOIN prj_payment_info pp ON p1.prj_id = pp.prj_id
                                    WHERE p1.prj_id = prj_info.prj_id
                                    AND   DATE_ADD(pp.prj_billing_date,INTERVAL pp.prj_plan_pay_day DAY) >= :prj_billing_date_from
                                    AND   pp.sort_id != 6
                                    GROUP BY p1.prj_id
                            )";
        } elseif (!StringUtil::isNullOrEmpty($params['prj_kanko_bi_to'])) {
            $andwhere .= " AND 
                            EXISTS (
                                    SELECT 
                                        1
                                    FROM prj_info p1
                                    INNER JOIN prj_payment_info pp ON p1.prj_id = pp.prj_id
                                    WHERE p1.prj_id = prj_info.prj_id
                                    AND   DATE_ADD(pp.prj_billing_date,INTERVAL pp.prj_plan_pay_day DAY) <= :prj_billing_date_from
                                    AND   pp.sort_id != 6
                                    GROUP BY p1.prj_id
                            )";
        }
        if (!StringUtil::isNullOrEmpty($params['prj_cust_name'])) {
            $params['prj_cust_name'] = '%'.$params['prj_cust_name'].'%';
            $andwhere .= " AND prj_info.prj_cust_name LIKE :prj_cust_name";
        }
        if(!StringUtil::isNullOrEmpty($params['prj_cust_prefectures'])){
            $andwhere .= " AND prj_info.prj_cust_prefectures = :prj_cust_prefectures";
        }
        if (!StringUtil::isNullOrEmpty($params['prj_cust_address_full'])) {
            $params['prj_cust_address_full'] = '%'. $params['prj_cust_address_full'].'%';
            $andwhere .= " AND ( prj_info.prj_cust_address LIKE :prj_cust_address_full
                                 OR    prj_info.prj_cust_city LIKE :prj_cust_address_full
                                 OR    prj_info.prj_cust_mansion_info LIKE :prj_cust_address_full
                )";
        }
        if (!StringUtil::isNullOrEmpty($params['prj_cust_phone_num'])) {
            $params['prj_cust_phone_num'] = '%'. $params['prj_cust_phone_num'].'%';
            $andwhere .= " AND prj_info.prj_cust_phone_num LIKE :prj_cust_phone_num";
        }
        if (!StringUtil::isNullOrEmpty($params['prj_staff_id'])) {
            $andwhere .= " AND EXISTS (SELECT 
                                            p_a.prj_staff_id 
                                        FROM prj_assign_info p_a 
                                        WHERE p_a.prj_id=prj_info.prj_id 
                                        AND p_a.prj_staff_id= :prj_staff_id) ";
        }
        $group_by = " GROUP BY prj_info.prj_id";
        $orderby = "  ORDER BY " . $sortCondition;
        $sql .=$andwhere.$group_by.$orderby;
        return $this->selectWithPagging($currentPage, $pageSize, $totalRow, $sql, $params);
    }

  

    public function doInsertUpdate($params) {
        if (StringUtil::isNullOrEmpty($params['id']))
            return $this->insert($params);
        else {
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
    public function getByPrjIdAndSorId($prj_id,$sort_id){
        $sql = "select prj_payment_info.*,prj_info.* from prj_payment_info inner join prj_info on prj_payment_info.prj_id = prj_info.prj_id where prj_payment_info.prj_id= :prj_id AND prj_payment_info.sort_id= :sort_id and prj_info.deleted_flag = 0";
        return $this->selectOne($sql, array("prj_id" => $prj_id,"sort_id" => $sort_id));
    }
}

