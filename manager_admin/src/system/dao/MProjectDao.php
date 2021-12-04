<?php

require_once ROOT_PATH_DAO . "/core/BaseDao.php";

class MProjectDao extends BaseDao {

    public function __construct() {
        parent::__construct("prj_info");
    }

    public function getById($prj_id) {
        $sql = "SELECT * FROM prj_info WHERE prj_id = :prj_id AND deleted_flag <> 1";
        return $this->selectOne($sql, array("prj_id" => $prj_id));
    }

    public function getByIdWithAuthority($prj_id, $staff_id){
        $sql = "SELECT prj_info.* FROM prj_info 
                WHERE prj_id = :prj_id 
                AND deleted_flag <> 1  
                AND exists (SELECT pa.prj_staff_id 
                            FROM prj_assign_info pa 
                            WHERE pa.prj_id=prj_info.prj_id 
                            AND pa.prj_staff_id= :prj_staff_id) ";     
        return $this->selectOne($sql, array("prj_id" => $prj_id, 'prj_staff_id' => $staff_id));
    }

    public function getIncentiveData1($params) {
        $sql = "SELECT 
                    * 
                FROM
                (
                SELECT  P.deleted_flag,
                        P.prj_id, /*案件ID*/  
                        P.prj_status,
                        P.prj_keiyaku_bi, /*契約日*/
                        P.prj_kyanceru_bi,/*キャンセル日*/
                        P.prj_pay_completed_date, /*完納日*/
                        P.prj_kind_contract, /*契約種別*/
                        P.prj_kind_pv, 
                        P.prj_kind_od, 
                        P.prj_maker, /*メーカー*/
                        P.prj_cust_name, /*お客様名*/  
                        prj_payment_info.total_reven,
                        P.prj_prod_price_selling_total, /*売上金額*/
                        P.prj_comm_partition_amount,/*仕切金額*/
                        prj_prod_info_total1.total1, /*工事*/
                        prj_prod_info_total2.total2, /*整地*/
                        prj_prod_info_total3.total3, /*利益*/
                        P.prj_comm_income_amount, /*利益額*/
                        #Added 0428
                        psc.commission_year_month prj_comm_close_date,
                        psc.commission_amount prj_comm_amount,
                        re_psc.commission_year_month re_prj_comm_close_date,
                        re_psc.commission_amount re_prj_comm_amount,
                        #Added end
                        prj_prod_info_kw.prj_prod_kw, 
                        promotion.promotionTotal,
                        P.prj_comm_memo, 
                        prj_assign_staff.staff_name AS staff_join, /*担当営業*/
                        prj_assign_staff.staff_id as staff_join_id,
                        prj_assign_staff.prj_role_grp,
                        prj_assign_staff.prj_staff_pos,
                        P.prj_kanko_bi,
                        prj_prod_info_part.total_prod_price_part,
                        prj_prod_info_part2.total_prod_price_part as total_prod_price_part2,
                        count_by_prj_id.num_staff_join, /*number of staff join a project*/
                        P.created_user,
                        P.created_time,
                        P.updated_time,
                        P.updated_user
                                                
                     
                    FROM   prj_info P 
                    /*Get 社員名/担当種別*/
                    INNER JOIN (SELECT m_staff.staff_id, 
                                m_staff.staff_name, 
                                prj_assign_info.prj_role_grp,
                                prj_assign_info.prj_staff_pos,
                                prj_assign_info.prj_id 
                        FROM   prj_assign_info 
                        INNER JOIN m_staff 
                            ON  prj_assign_info.prj_staff_id = m_staff.staff_id ) 
                        AS prj_assign_staff                  
                    ON P.prj_id = prj_assign_staff.prj_id 
                    /*Get staff comission*/
                    #Added 0428
                    /*LEFT JOIN prj_staff_comission psc
                    ON prj_assign_staff.prj_id=psc.prj_id
                    AND prj_assign_staff.staff_id=psc.staff_id
                    AND prj_assign_staff.prj_role_grp=psc.staff_group*/
                    LEFT JOIN (
                        SELECT * FROM prj_staff_comission p_s_c WHERE p_s_c.cancel_flag <> 1 OR cancel_flag IS NULL
                    )AS psc
                    ON prj_assign_staff.prj_id=psc.prj_id
                    AND prj_assign_staff.staff_id=psc.staff_id
                    AND prj_assign_staff.prj_role_grp=psc.staff_group

                    LEFT JOIN(
                        SELECT * FROM prj_staff_comission p_s_c WHERE p_s_c.cancel_flag = 1 
                    )AS re_psc
                    ON  prj_assign_staff.prj_id=re_psc.prj_id
                    AND prj_assign_staff.staff_id=re_psc.staff_id
                    AND prj_assign_staff.prj_role_grp=re_psc.staff_group
                    #Added 0428 End
                    INNER JOIN (SELECT count(prj_assign_info.prj_staff_id) as num_staff_join,prj_assign_info.prj_id 
                        FROM   prj_assign_info 
                        INNER JOIN m_staff 
                            ON  prj_assign_info.prj_staff_id = m_staff.staff_id 
                                                GROUP BY prj_id
                                        )AS count_by_prj_id                  
                    ON P.prj_id = count_by_prj_id.prj_id 


                     /*Get 商品情報 kw*/
                     LEFT JOIN (SELECT prj_prod_info.prj_prod_kw, 
                                       prj_prod_info.prj_id 
                                FROM   prj_prod_info 
                                WHERE  prj_prod_info.prj_prod_class = 1 
                                       AND prj_prod_info.sort_id = 1)
                            AS prj_prod_info_kw 
                            ON P.prj_id = prj_prod_info_kw.prj_id 

                    /*値引き合計*/
                    LEFT JOIN (SELECT prj_prod_info.prj_id 
                                      ,SUM(IFNULL(prj_prod_info.prj_prod_price_selling, 0)) AS  promotionTotal
                                FROM   prj_prod_info 
                                WHERE  (prj_prod_info.prj_prod_class = 11 
                                        OR prj_prod_info.prj_prod_class = 12)
                                        AND prj_prod_info.sort_id = 1  
                                GROUP BY prj_prod_info.prj_id) 
                            AS promotion
                            ON P.prj_id = promotion.prj_id 

                     /*工事*/
                     LEFT JOIN (SELECT SUM(IFNULL(prj_prod_info.prj_prod_price_selling, 0))-SUM(IFNULL(prj_prod_info.prj_prod_price_part, 0)) AS total1, 
                                       prj_prod_info.prj_id 
                                FROM   prj_prod_info 
                                WHERE  prj_prod_info.prj_prod_type = 1 
                                GROUP  BY prj_id) 
                            AS prj_prod_info_total1 
                            ON P.prj_id = prj_prod_info_total1.prj_id 

                     /*整地*/
                     LEFT JOIN (SELECT SUM(IFNULL(prj_prod_info.prj_prod_price_selling, 0))-SUM(IFNULL(prj_prod_info.prj_prod_price_part,0)) AS total2, 
                                       prj_prod_info.prj_id 
                                FROM   prj_prod_info 
                                WHERE  prj_prod_info.prj_prod_type = 2 
                                GROUP  BY prj_id) 
                            AS prj_prod_info_total2 
                            ON P.prj_id = prj_prod_info_total2.prj_id 

                     /*利益*/
                     LEFT JOIN (SELECT SUM(IFNULL(prj_prod_info.prj_prod_price_selling, 0))-SUM(IFNULL(prj_prod_info.prj_prod_price_part, 0)) AS total3, 
                                       prj_prod_info.prj_id 
                                FROM   prj_prod_info 
                                WHERE  prj_prod_info.prj_prod_type = 3 
                                GROUP  BY prj_id) 
                            AS prj_prod_info_total3 
                            ON P.prj_id = prj_prod_info_total3.prj_id 

                     /*支払済金額*/
                     LEFT JOIN (SELECT PY.prj_id, SUM(IFNULL(PY.prj_plan_paid_amount, 0)) 
                                AS paid_amount /*支払済金額*/
                                FROM prj_payment_info PY 
                                WHERE PY.sort_id != 6 /*Except 工事負担金立替分*/
                                GROUP BY PY.prj_id
                                ) Payment
                            ON P.prj_id = Payment.prj_id

                    LEFT JOIN (SELECT SUM(IFNULL(prj_payment_info.prj_plan_paid_amount, 0)) 
                        AS  total_reven,
                            prj_payment_info.prj_id 
                        FROM prj_payment_info 
                        WHERE prj_payment_info.sort_id !=6 
                        GROUP BY prj_id
                        ) 
                    AS prj_payment_info
                    ON P.prj_id = prj_payment_info.prj_id

                    LEFT JOIN (
                        SELECT SUM(IFNULL(prj_prod_info.prj_prod_price_part, 0)) 
                        AS total_prod_price_part,prj_prod_info.prj_id 
                        FROM prj_prod_info 
                        WHERE  prj_prod_info.prj_prod_class < 11 
                        AND  prj_prod_info.prj_prod_class <> 13
                        GROUP BY prj_id)
                    AS prj_prod_info_part
                    ON P.prj_id = prj_prod_info_part.prj_id

                    LEFT JOIN (
                        SELECT SUM(IFNULL(prj_prod_info.prj_prod_price_part, 0)) 
                        AS total_prod_price_part,prj_prod_info.prj_id 
                        FROM prj_prod_info 
                        WHERE  prj_prod_info.prj_prod_class = 11 
                        OR  prj_prod_info.prj_prod_class =12
                        GROUP BY prj_id)
                    AS prj_prod_info_part2
                    ON P.prj_id = prj_prod_info_part2.prj_id
                    ORDER BY P.prj_id

            ) A
                WHERE  
                    EXISTS (SELECT PA.prj_staff_id 
                            FROM prj_assign_info PA 
                            LEFT JOIN m_staff MS ON PA.prj_staff_id=MS.staff_id 
                            WHERE PA.prj_id = A.prj_id";


        if (!StringUtil::isNullOrEmpty($params['prj_staff_id'])) {
            $sql .= " AND MS.staff_id = :prj_staff_id";
        }
        if (!StringUtil::isNullOrEmpty($params['staff_name'])) {
            $params['staff_name'] = "%" . $params['staff_name'] . "%";
            $sql .= " AND MS.staff_name  LIKE :staff_name";
        }

        if (!ArrayUtil::isNullOrEmpty($params['prj_role_grp'])) {
            if ($params['prj_role_grp'] != 0) {
                $sql .= " AND PA.prj_role_grp = :prj_role_grp";
            }
        }

        $sql1 = ")
                         
                AND A.deleted_flag <> 1 
                AND A.prj_status = 3 ";//ステータス [本契約]

        if (!ArrayUtil::isNullOrEmpty($params['prj_kind_contract'])) {
            if ($params['prj_kind_contract'] != 0) {
                $sql .= " AND A.prj_kind_contract =:prj_kind_contract";
            }
        }
        if (!StringUtil::isNullOrEmpty($params['prj_keiyaku_bi_from']) && !StringUtil::isNullOrEmpty($params['prj_keiyaku_bi_to'])) {
            $sql .= " AND A.prj_keiyaku_bi BETWEEN :prj_keiyaku_bi_from AND :prj_keiyaku_bi_to";
        } elseif (!StringUtil::isNullOrEmpty($params['prj_keiyaku_bi_from'])) {
            $sql .= " AND A.prj_keiyaku_bi >= :prj_keiyaku_bi_from";
        } elseif (!StringUtil::isNullOrEmpty($params['prj_keiyaku_bi_to'])) {
            $sql .= " AND A.prj_keiyaku_bi <= :prj_keiyaku_bi_to";
        }
        if (!StringUtil::isNullOrEmpty($params['date_ranked_from']) && !StringUtil::isNullOrEmpty($params['date_ranked_to'])) {
            $sql .= " AND (A.prj_pay_completed_date >= :date_ranked_from AND A.prj_pay_completed_date <= :date_ranked_to 
                           OR A.prj_kyanceru_bi >= :date_ranked_from AND A.prj_kyanceru_bi<= :date_ranked_to
                    )";
        } elseif (!StringUtil::isNullOrEmpty($params['date_ranked_from'])) {
            $sql .= " AND (A.prj_pay_completed_date >= :date_ranked_from OR  A.prj_kyanceru_bi >= :date_ranked_from )";
        } elseif (!StringUtil::isNullOrEmpty($params['date_ranked_to'])) {
            $sql .= " AND A.prj_pay_completed_date <= :date_ranked_to OR A.prj_kyanceru_bi<= :date_ranked_to ";
        }
        $sql.= $sql1.' order by prj_id, prj_role_grp, prj_staff_pos';
        return $this->select($sql, $params);
    }

    public function getIncentiveData2($params) {
        if (!ArrayUtil::isNullOrEmpty($params)) {
            $sql = "SELECT 
                    prj_info.prj_id, /*案件ID*/  
                    assign_staff.staff_name,/*社員名*/
                    assign_staff.prj_role_grp, /*担当種別*/
                    prj_info.prj_keiyaku_bi, /*契約日*/
                    prj_info.prj_pay_completed_date, /*完納日*/
                    prj_info.prj_kind_contract, /*契約種別*/
                    prj_info.prj_kind_pv, /*pv*/
                    prj_info.prj_kind_od, /*od*/
                    prj_info.prj_maker, /*メーカー*/
                    prj_info.prj_cust_name, /*お客様名*/  
                    prj_info.prj_prod_price_selling_total, /*売上金額*/
                    prj_info.prj_comm_partition_amount,/*仕切金額*/
                    prj_info.prj_comm_income_amount, /*利益額*/
                    psc.commission_amount as prj_staff_commission_amount,
                    psc.commission_year_month,
                    prod_info.prj_prod_kw, /*kw*/
                    prj_info.prj_comm_memo, /*メモ*/
                    prj_info.prj_kanko_bi,
                    assign_staff.prj_staff_id as staff_id, 
                    commission.commission_amount,
                    commission.updated_time as comm_update_time,
					prj_prod_info_part.total_prod_price_part,
					prj_prod_info_part2.total_prod_price_part1
                FROM prj_info
                /* Get staff_name,staff_id (社員名/担当種別)*/
                INNER JOIN (
                    SELECT  prj_assign_info.prj_id,
                            prj_assign_info.id,
                            prj_assign_info.prj_staff_pos,
                            m_staff.staff_name,
                            prj_assign_info.prj_staff_id,
                            prj_assign_info.prj_role_grp 
                    FROM prj_assign_info 
                    INNER JOIN m_staff 
                    ON prj_assign_info.prj_staff_id = m_staff.staff_id
                    ) AS assign_staff
                    ON prj_info.prj_id = assign_staff.prj_id
                LEFT JOIN prj_staff_comission psc
                    ON prj_info.prj_id=psc.prj_id
                    AND assign_staff.prj_staff_id=psc.staff_id
                    AND assign_staff.prj_role_grp=psc.staff_group
                    /*GET   Kw*/
                LEFT JOIN(
                    SELECT prj_prod_info.prj_prod_kw,prj_prod_info.prj_id 
                    FROM prj_prod_info
                    WHERE prj_prod_info.prj_prod_class=1 
                        AND prj_prod_info.sort_id=1
                   ) AS prod_info
                ON prj_info.prj_id = prod_info.prj_id

                LEFT JOIN(
                        SELECT 
                            staff_monthly_comission.staff_id,
                            staff_monthly_comission.comm_year_month,
                            staff_monthly_comission.commission_amount,
                            staff_monthly_comission.updated_time
                        FROM  staff_monthly_comission
                ) AS commission
                ON assign_staff.prj_staff_id = commission.staff_id  
                AND commission.comm_year_month = :date_search
				LEFT JOIN (
                    SELECT SUM(IFNULL(prj_prod_info.prj_prod_price_part, 0)) 
                    AS total_prod_price_part,prj_prod_info.prj_id 
                    FROM prj_prod_info 
                    WHERE  prj_prod_info.prj_prod_class < 11 
                    AND  prj_prod_info.prj_prod_class <> 13
                    GROUP BY prj_id) AS prj_prod_info_part
					ON prj_info.prj_id = prj_prod_info_part.prj_id
				LEFT JOIN (
                    SELECT SUM(IFNULL(prj_prod_info.prj_prod_price_part, 0)) 
                    AS total_prod_price_part1,prj_prod_info.prj_id 
                    FROM prj_prod_info 
                    WHERE  prj_prod_info.prj_prod_class  = 11 /*値引*/
                        OR  prj_prod_info.prj_prod_class = 12 /*サービス料値引*/
                    GROUP BY prj_id) AS prj_prod_info_part2
					ON  prj_info.prj_id = prj_prod_info_part2.prj_id

                WHERE prj_info.deleted_flag <> 1 
                    AND prj_info.prj_status = 3 ";//ステータス [本契約]
            if (!StringUtil::isNullOrEmpty($params['staff_name'])) {
                $params['staff_name'] = "%" . $params['staff_name'] . "%";
                $sql .= " AND assign_staff.staff_name LIKE :staff_name";
            }
            if (!StringUtil::isNullOrEmpty($params['prj_staff_id'])) {
                $sql .= " AND assign_staff.prj_staff_id = :prj_staff_id";
            }
            if (!ArrayUtil::isNullOrEmpty($params['prj_role_grp'])) {
                if ($params['prj_role_grp'] != 0) {
                    $sql .= " AND assign_staff.prj_role_grp = :prj_role_grp";
                }
            }
            if (!ArrayUtil::isNullOrEmpty($params['prj_kind_contract'])) {
                if ($params['prj_kind_contract'] != 0) {
                    $sql .= " AND prj_info.prj_kind_contract = :prj_kind_contract";
                }
            }
            if (!StringUtil::isNullOrEmpty($params['prj_pay_completed_date_year']) && !StringUtil::isNullOrEmpty($params['prj_pay_completed_date_month'])) {
                $params['date_search'] = $params['prj_pay_completed_date_year'] . $params['prj_pay_completed_date_month'];
                if ($params['date_search'] != '00')
                    $sql .= " AND psc.commission_year_month = :date_search ";
            }
        }
        return $this->select($sql, $params);
    }

    public function getPeriodically($month, $year, $staff_id = null) {
        $sql = "SELECT prj_info.prj_id,prj_cust_name,prj_kanko_bi
                FROM prj_info
                WHERE MONTH(prj_info.prj_kanko_bi) = :month
                AND YEAR(prj_info.prj_kanko_bi) = :year
                AND prj_info.deleted_flag <> 1";
        $params = array("month" => $month, "year" => $year);
        if(!StringUtil::isNullOrEmpty($staff_id)){
            $sql = "SELECT prj_info.prj_id,prj_cust_name,prj_kanko_bi
                FROM prj_info
                WHERE MONTH(prj_info.prj_kanko_bi) = :month
                AND YEAR(prj_info.prj_kanko_bi) = :year
                AND prj_info.deleted_flag <> 1
                AND exists (SELECT pa.prj_staff_id 
                    FROM prj_assign_info pa 
                    WHERE pa.prj_id=prj_info.prj_id 
                    AND pa.prj_staff_id= :prj_staff_id)";
            $params = array("month" => $month, "year" => $year, 'prj_staff_id' => $staff_id);
        }
        return $this->select($sql, $params);
    }

    public function getSchedule($month, $year, $type, $staff_id = null) {
        if ($type != 'prj_gencho_bi' && $type != 'prj_koji_kaishi_bi' && $type != 'prj_renkei_bi' && $type != 'prj_kanko_bi')
            return null;
        if($staff_id == null)
        {
            $sql = "SELECT prj_info.prj_id,prj_info.prj_cust_name,prj_info.$type
                FROM prj_info
                WHERE MONTH(prj_info.$type) = :month 
                AND YEAR(prj_info.$type) = :year 
                AND prj_info.deleted_flag <> 1";
            $params = array(
                "month" => $month, 
                "year" => $year
            );
        }else{
            $sql = "SELECT prj_info.prj_id,prj_info.prj_cust_name,prj_info.$type
                FROM prj_info
                WHERE MONTH(prj_info.$type) = :month 
                AND YEAR(prj_info.$type) = :year 
                AND prj_info.deleted_flag <> 1
                AND exists (SELECT pa.prj_staff_id 
                            FROM prj_assign_info pa 
                            WHERE pa.prj_id=prj_info.prj_id 
                            AND pa.prj_staff_id= :prj_staff_id)";
            $params = array(
                "month"         => $month 
                ,"year"          => $year
                ,"prj_staff_id"  => $staff_id
            );
        }
        return $this->select($sql, $params);
    }

    public function getWithPagging($currentPage, $pageSize, $sortCondition, &$totalRow, $params) {
        if (!ArrayUtil::isNullOrEmpty($params)) {
            if (!StringUtil::isNullOrEmpty($params['prj_staff_id'])) {
                $andwhere .= " AND exists (SELECT pa.prj_staff_id FROM prj_assign_info pa WHERE pa.prj_id=prj_info.prj_id AND pa.prj_staff_id= :prj_staff_id) ";
            }
            if (!StringUtil::isNullOrEmpty($params['prj_staff_name'])) {
                $params['prj_staff_name'] = "%".$params['prj_staff_name']."%";
                $andwhere .= " AND exists (SELECT pa.prj_staff_id FROM prj_assign_info pa INNER JOIN m_staff mt ON pa.prj_staff_id=mt.staff_id WHERE pa.prj_id=prj_info.prj_id AND mt.staff_name LIKE :prj_staff_name) ";
            }
            if (!StringUtil::isNullOrEmpty($params['prj_cust_name'])) {
                $params['prj_cust_name'] = "%".$params['prj_cust_name']."%";
                $andwhere .= " AND prj_info.prj_cust_name LIKE :prj_cust_name";
            }
            if (!StringUtil::isNullOrEmpty($params['prj_cust_prefectures'])) {
                $andwhere .= " AND prj_info.prj_cust_prefectures = :prj_cust_prefectures" ;
            }
            if (!StringUtil::isNullOrEmpty($params['prj_cust_address'])) {
                $params['prj_cust_address'] = "%".$params['prj_cust_address']."%";
                $andwhere .= " AND (prj_info.prj_cust_address LIKE :prj_cust_address";
                $andwhere .= " OR prj_info.prj_cust_city LIKE :prj_cust_address";
                $andwhere .= " OR prj_info.prj_cust_mansion_info LIKE :prj_cust_address";
                $andwhere .= " OR prj_info.prj_cust_pos_code LIKE :prj_cust_address ) ";
            }
            if (!StringUtil::isNullOrEmpty($params['prj_cust_phone_num'])) {
                $params['prj_cust_phone_num'] = "%".$params['prj_cust_phone_num']."%";
                $andwhere .= " AND prj_info.prj_cust_phone_num LIKE :prj_cust_phone_num";
            }
            if (!StringUtil::isNullOrEmpty($params['prj_keiyaku_bi_from']) && !StringUtil::isNullOrEmpty($params['prj_keiyaku_bi_to'])) {
                $andwhere .= " AND prj_info.prj_keiyaku_bi BETWEEN :prj_keiyaku_bi_from AND :prj_keiyaku_bi_to";
            } elseif (!StringUtil::isNullOrEmpty($params['prj_keiyaku_bi_from'])) {
                $andwhere .= " AND prj_info.prj_keiyaku_bi >= :prj_keiyaku_bi_from";
            } elseif (!StringUtil::isNullOrEmpty($params['prj_keiyaku_bi_to'])) {
                $andwhere .= " AND prj_info.prj_keiyaku_bi <= :prj_keiyaku_bi_to";
            }
            if (!StringUtil::isNullOrEmpty($params['prj_gencho_bi_from']) && !StringUtil::isNullOrEmpty($params['prj_gencho_bi_to'])) {
                $andwhere .= " AND prj_info.prj_gencho_bi BETWEEN :prj_gencho_bi_from AND :prj_gencho_bi_to";
            } elseif (!StringUtil::isNullOrEmpty($params['prj_gencho_bi_from'])) {
                $andwhere .= " AND prj_info.prj_gencho_bi >= :prj_gencho_bi_from";
            } elseif (!StringUtil::isNullOrEmpty($params['prj_gencho_bi_to'])) {
                $andwhere .= " AND prj_info.prj_gencho_bi <= :prj_gencho_bi_to";
            }
            if (!StringUtil::isNullOrEmpty($params['prj_kanko_bi_from']) && !StringUtil::isNullOrEmpty($params['prj_kanko_bi_to'])) {
                $andwhere .= " AND prj_info.prj_kanko_bi BETWEEN :prj_kanko_bi_from AND :prj_kanko_bi_to";
            } elseif (!StringUtil::isNullOrEmpty($params['prj_kanko_bi_from'])) {
                $andwhere .= " AND prj_info.prj_kanko_bi >= :prj_kanko_bi_from";
            } elseif (!StringUtil::isNullOrEmpty($params['prj_kanko_bi_to'])) {
                $andwhere .= " AND prj_info.prj_kanko_bi <= :prj_kanko_bi_to";
            }
            if (!StringUtil::isNullOrEmpty($params['prj_renkei_bi_from']) && !StringUtil::isNullOrEmpty($params['prj_renkei_bi_to'])) {
                $andwhere .= " AND prj_info.prj_renkei_bi BETWEEN :prj_renkei_bi_from AND :prj_renkei_bi_to";
            } elseif (!StringUtil::isNullOrEmpty($params['prj_renkei_bi_from'])) {
                $andwhere .= " AND prj_info.prj_renkei_bi >= :prj_renkei_bi_from";
            } elseif (!StringUtil::isNullOrEmpty($params['prj_renkei_bi_to'])) {
                $andwhere .= " AND prj_info.prj_renkei_bi <= :prj_renkei_bi_to";
            }
            if (!ArrayUtil::isNullOrEmpty($params['prj_status'])) {
                $andwhere .= " AND prj_info.prj_status IN (:prj_status)";
            }
            if (!ArrayUtil::isNullOrEmpty($params['prj_kind_contract'])) {
                $andwhere .= " AND prj_info.prj_kind_contract IN (:prj_kind_contract)";
            }
            if (!ArrayUtil::isNullOrEmpty($params['prj_maker'])) {
                $andwhere .= " AND prj_info.prj_maker IN (:prj_maker)";
            }
        }
        $sql = "SELECT 
                prj_info.prj_id
                ,prj_info.prj_cust_name /*お客様名*/
                ,prj_info.prj_cust_address /*住所*/
                ,prj_info.prj_cust_city /*住所*/
                ,prj_info.prj_cust_mansion_info /*住所*/
                ,prj_info.prj_cust_prefectures /*住所*/
                ,prj_info.prj_cust_pos_code /*住所*/
                ,GROUP_CONCAT(DISTINCT s.staff_name) AS inChangeName /*担当者*/
                ,GROUP_CONCAT(DISTINCT s.staff_id) AS inChangeID /*担当者ID*/
                ,prj_info.prj_status /*ステータス*/
                ,prj_info.updated_time /*更新年月日*/
                ,m_s.staff_name AS userCreated /*登録者*/
                FROM prj_info

                LEFT JOIN (
                    SELECT prj_assign_info.prj_id,m_staff.staff_name,m_staff.staff_id FROM prj_assign_info
                    INNER JOIN m_staff 
                    ON prj_assign_info.prj_staff_id = m_staff.staff_id
                )s
                ON s.prj_id = prj_info.prj_id

                INNER JOIN m_staff m_s 
                ON prj_info.created_user = m_s.staff_id";
        $default_where = " WHERE prj_info.deleted_flag <>1 ";        
        if(!StringUtil::isNullOrEmpty($params['role_required'])){//if not has role you need authorizone
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
        $sql .= $andwhere;
        $sql .= " GROUP BY prj_info.prj_id";
        $orderby = "  ORDER BY " . $sortCondition;
        $sql .= $orderby;
        return $this->selectWithPagging($currentPage, $pageSize, $totalRow, $sql, $params);
    }

    public function deleteLogic($Id) {
       
        return parent::update( array("deleted_flag" => 1), 
                                array( "where" => "prj_id = :prj_id" , "params" => array("prj_id" => $Id)) , 
                                false
        );
    }

    public function doRegist($params) {
        $id = null;
        if ($params['prj_cust_pos_code'] == '-')
            unset($params['prj_cust_pos_code']);
        if (!StringUtil::isNullOrEmpty($params['prj_id'])) {
            $prj_id = $params['prj_id'];
            unset($params['deleted_flag']);
            unset($params['prj_id']);
            $id = $this->update(
                    $params
                    , array(
                "where" => "prj_id = :prj_id"
                , "params" => array("prj_id" => $prj_id)
                    )
            );
        } else {
            $id = $this->insert($params);
        }
        return $id;
    }

    /* update prj_shurui_appr_memo called in HistoryAction method updateApproveMemo */

    public function updateApproveMemo($params, $condition) {
        return parent::update(
            $params
            , array(
                'where' => 'prj_id = :prj_id'
                ,'params' => $condition
            )
            , false
        );
    }

    public function getWithPaggingFromStaff($staff_id, $currentPage, $pageSize, $sortCondition, &$totalRow,$params) {
        $sql = 'SELECT
                    pi.prj_id,
                    pi.prj_cust_name,
                    pi.prj_cust_pos_code,
                    pi.prj_cust_prefectures,
                    pi.prj_cust_city,
                    pi.prj_cust_address,
                    pi.prj_cust_mansion_info,
                    history_upd_item_id,
                    #history_updated_time,
                    history_approve_info.id, #History ID
                    history_updated_time
                FROM
                    prj_info pi ';
                    if(!StringUtil::isNullOrEmpty($params['role_required'])){//if not has role you need authorizone
                        $role_required = " INNER JOIN
                                (
                                SELECT prj_assign_info.prj_id FROM prj_assign_info
                                        INNER JOIN m_staff 
                                        ON prj_assign_info.prj_staff_id = m_staff.staff_id
                                        WHERE m_staff.staff_id = :role_required  )prj_assign 
                                ON pi.prj_id = prj_assign.prj_id ";
                        $sql .= $role_required;
                    }
        $sql .='    INNER JOIN
                    (
                        SELECT
                          pi.prj_id
                          , puh.id
                          , GROUP_CONCAT(DISTINCT puh.upd_item_id ORDER BY upd_item_id) AS history_upd_item_id
                          ,  max(puh.upd_date_time) as history_updated_time
                        FROM
                            prj_info pi
                            INNER JOIN
                            (
                                SELECT
                                    pi.prj_id
                                FROM
                                    prj_info pi
                                    LEFT JOIN (
                                            SELECT
                                                pas.prj_id
                                                , pas.approve_sts
                                            FROM
                                                m_staff s
                                                INNER JOIN prj_approve_status pas
                                                ON
                                                    pas.staff_id = s.staff_id
                                                    AND pas.deleted_flag <> 1
                                                    AND s.deleted_flag <> 1
                                            WHERE
                                                s.staff_is_notify_mail = 1
                                                AND s.staff_id = :staff_id
                                                AND pas.approve_sts = 1
                                            GROUP BY
                                                pas.prj_id
                                    ) approve
                                    ON
                                        approve.prj_id = pi.prj_id
                                        AND pi.deleted_flag <> 1
                                WHERE
                                    EXISTS(
                                        SELECT 
                                            1
                                        FROM
                                            m_staff
                                        WHERE
                                            staff_id = :staff_id
                                            AND staff_is_notify_mail = 1
                                            AND deleted_flag <> 1
                                    )
                                    AND IFNULL(approve.approve_sts, 0) <> 1
                                UNION
                                SELECT
                                    p.prj_id
                                FROM
                                    prj_info p
                                    INNER JOIN prj_assign_info pa
                                    ON
                                        p.prj_id = pa.prj_id
                                        AND p.deleted_flag <> 1
                                        AND pa.deleted_flag <> 1
                                        AND pa.prj_role_grp = 1
                                        AND pa.prj_staff_pos = 1
                                        
                                    INNER JOIN m_staff s
                                    ON
                                        pa.prj_staff_id = s.staff_id
                                        AND (
                                                (
                                                    s.staff_id = :staff_id
                                                    AND EXISTS(
                                                        SELECT 
                                                            1
                                                        FROM
                                                            prj_shurui_appr_mgt psam
                                                        WHERE
                                                            pa.prj_id = psam.prj_id
                                                            AND
                                                                IFNULL(psam.prj_pic_approve_sts, 0) = 0
                                                            AND psam.deleted_flag <> 1
                                                    )
                                                )
                                                OR 
                                                (
                                                    s.staff_supervisor = :staff_id
                                                    AND EXISTS(
                                                        SELECT 
                                                            1
                                                        FROM
                                                            prj_shurui_appr_mgt psam
                                                        WHERE
                                                            pa.prj_id = psam.prj_id
                                                            AND IFNULL(psam.prj_sup_approve_sts, 0) = 0
                                                            AND psam.deleted_flag <> 1
                                                    )
                                                )
                                                
                                        )
                                GROUP BY
                                    p.prj_id

                            ) approve_info
                            ON
                                pi.prj_id = approve_info.prj_id
                            LEFT JOIN prj_update_history puh 
                            ON 
                                approve_info.prj_id = puh.prj_id
                                AND puh.upd_sts = 1
                                AND puh.deleted_flag <> 1
                        GROUP BY
                            pi.prj_id,puh.id
                    ) history_approve_info
                    ON
                        history_approve_info.prj_id = pi.prj_id
                WHERE pi.deleted_flag <> 1
                ORDER BY history_updated_time desc';
        //$sql .= " ORDER BY ".$sortCondition;
        $params = array(
            "staff_id" => $staff_id,
            "role_required" => $params['role_required'],
        );
        return $this->selectWithPagging($currentPage, $pageSize, $totalRow, $sql, $params);
    }

    public function getUserInchangeId($prj_id){
        $params = array('prj_id' => $prj_id);
        $sql = "SELECT prj_staff_id 
                FROM prj_assign_info 
                WHERE prj_id = :prj_id 
                    AND prj_role_grp = 1 
                    AND prj_staff_pos = 1";
        return $this->select($sql, $params);
    }
}

?>