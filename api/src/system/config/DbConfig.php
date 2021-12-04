<?php
class DbConfig {

	const DT_DATE = 0;
	const DT_NUMBER = 1;
	const DT_VARCHAR = 2;
	public static $DB_INFO = array(
    'e_event_type' => array(
      'id' => DbConfig::DT_NUMBER
      , 'name_type' => DbConfig::DT_VARCHAR
      , 'code_color' => DbConfig::DT_DATE
      , 'code_type' => DbConfig::DT_DATE
      , 'deleted_flag' => DbConfig::DT_NUMBER
      , 'updated_time' => DbConfig::DT_DATE
      , 'created_time' => DbConfig::DT_DATE
      , 'updated_user' => DbConfig::DT_NUMBER
      , 'created_user' => DbConfig::DT_NUMBER
  ),
		// 管理者テーブル
    'e_event' => array(
      'id' => DbConfig::DT_NUMBER
      , 'event_name' => DbConfig::DT_VARCHAR
      , 'start_time' => DbConfig::DT_DATE
      , 'end_time' => DbConfig::DT_DATE
      , 'name_customer' => DbConfig::DT_VARCHAR
      , 'phone_customer' => DbConfig::DT_VARCHAR
      , 'email_customer' => DbConfig::DT_VARCHAR
      , 'number_adults' => DbConfig::DT_NUMBER
      , 'number_kid' => DbConfig::DT_NUMBER
      , 'type_id' => DbConfig::DT_NUMBER
      , 'status' => DbConfig::DT_NUMBER
      , 'deleted_flag' => DbConfig::DT_NUMBER
      , 'updated_time' => DbConfig::DT_DATE
      , 'created_time' => DbConfig::DT_DATE
      , 'updated_user' => DbConfig::DT_NUMBER
      , 'created_user' => DbConfig::DT_NUMBER
    ),
        'm_staff' => array(
              'staff_id' => DbConfig::DT_NUMBER
              , 'staff_name' => DbConfig::DT_VARCHAR
              , 'staff_name_kana' => DbConfig::DT_VARCHAR
              , 'staff_office_id' => DbConfig::DT_NUMBER
              , 'staff_department_id' => DbConfig::DT_NUMBER
              , 'staff_password' => DbConfig::DT_VARCHAR
              , 'staff_pos_code' => DbConfig::DT_VARCHAR
              , 'staff_prefectures' => DbConfig::DT_NUMBER
              , 'staff_city' => DbConfig::DT_VARCHAR
              , 'staff_address' => DbConfig::DT_VARCHAR
              , 'staff_mansion_info' => DbConfig::DT_VARCHAR
              , 'staff_phone_num' => DbConfig::DT_VARCHAR
              , 'staff_email' => DbConfig::DT_VARCHAR
              , 'staff_supervisor' => DbConfig::DT_NUMBER
              , 'staff_is_notify_mail' => DbConfig::DT_NUMBER
              , 'staff_memo' => DbConfig::DT_VARCHAR
              , 'deleted_flag' => DbConfig::DT_NUMBER
              , 'created_user' => DbConfig::DT_NUMBER
              , 'created_time' => DbConfig::DT_DATE
              , 'updated_user' => DbConfig::DT_NUMBER
              , 'updated_time' => DbConfig::DT_DATE
        )
        
        ,'m_staff_roles' => array(
        	   'staff_id' => DbConfig::DT_NUMBER
        	   ,'role_id' => DbConfig::DT_NUMBER
        	   ,'deleted_flag' => DbConfig::DT_NUMBER
        	   ,'created_user' => DbConfig::DT_NUMBER
        	   ,'created_time' => DbConfig::DT_DATE
        	   ,'updated_user' => DbConfig::DT_NUMBER
        	   ,'updated_time' => DbConfig::DT_DATE
        )

        ,'m_office_info' => array(
              'office_id' => DbConfig::DT_NUMBER
              , 'office_name' => DbConfig::DT_VARCHAR
              , 'office_name_kana' => DbConfig::DT_VARCHAR
              , 'office_pos_code' => DbConfig::DT_VARCHAR
              , 'office_prefectures' => DbConfig::DT_NUMBER
              , 'office_city' => DbConfig::DT_VARCHAR
              , 'office_address' => DbConfig::DT_VARCHAR
              , 'office_mansion_info' => DbConfig::DT_VARCHAR
              , 'office_phone_num' => DbConfig::DT_VARCHAR
              , 'office_fax_num' => DbConfig::DT_VARCHAR
              , 'office_email' => DbConfig::DT_VARCHAR
              , 'office_memo' => DbConfig::DT_VARCHAR
              , 'deleted_flag' => DbConfig::DT_NUMBER
              , 'created_user' => DbConfig::DT_NUMBER
              , 'created_time' => DbConfig::DT_DATE
              , 'updated_user' => DbConfig::DT_NUMBER
              , 'updated_time' => DbConfig::DT_DATE
        )

        ,'prj_info' => array(
            'prj_id' => DbConfig::DT_NUMBER
            ,'prj_status' => DbConfig::DT_NUMBER
            ,'prj_maker' => DbConfig::DT_NUMBER
            ,'prj_cust_name' => DbConfig::DT_VARCHAR
            ,'prj_cust_pos_code' => DbConfig::DT_VARCHAR
            ,'prj_cust_prefectures' => DbConfig::DT_NUMBER
            ,'prj_cust_city' => DbConfig::DT_VARCHAR
            ,'prj_cust_address' => DbConfig::DT_VARCHAR
            ,'prj_cust_mansion_info' => DbConfig::DT_VARCHAR
            ,'prj_cust_ins_loc_pos_code' => DbConfig::DT_VARCHAR
            ,'prj_cust_ins_loc_prefectures' => DbConfig::DT_NUMBER
            ,'prj_cust_ins_loc_city' => DbConfig::DT_VARCHAR
            ,'prj_cust_ins_loc_address' => DbConfig::DT_VARCHAR
            ,'prj_cust_ins_loc_mansion_info' =>  DbConfig::DT_VARCHAR
            ,'prj_cust_phone_num' => DbConfig::DT_VARCHAR
            ,'prj_cust_email' => DbConfig::DT_VARCHAR
            ,'prj_cust_memo' => DbConfig::DT_VARCHAR

            ,'prj_kind_contract' => DbConfig::DT_NUMBER
            ,'prj_kind_garage' => DbConfig::DT_NUMBER
            ,'prj_kind_pv' => DbConfig::DT_VARCHAR
            ,'prj_kind_od' => DbConfig::DT_VARCHAR
            ,'prj_gencho_bi' => DbConfig::DT_DATE
            ,'prj_keiyaku_bi' => DbConfig::DT_DATE
            ,'prj_koji_kaishi_bi' => DbConfig::DT_DATE
            ,'prj_setsubi_nintei_shinsei_bi1' => DbConfig::DT_DATE
            ,'prj_setsubi_nintei_shinsei_bi2' => DbConfig::DT_DATE
            ,'prj_setsubi_nintei_shinsei_bi3' => DbConfig::DT_DATE
            ,'prj_uchi_ochi_yotei_bi' => DbConfig::DT_DATE
            ,'prj_uchi_ochi_kakutei_bi' => DbConfig::DT_DATE
            ,'prj_renkei_bi' => DbConfig::DT_DATE
            ,'prj_renkei_done' => DbConfig::DT_NUMBER
            ,'prj_kanko_bi' => DbConfig::DT_DATE
            ,'prj_setchi_hiyo_nenpo_shinsei_bi' => DbConfig::DT_DATE
            ,'prj_unten_hiyo_nenpo_shinsei_bi' => DbConfig::DT_DATE
            ,'prj_kyanceru_bi' => DbConfig::DT_DATE

            ,'prj_prod_checklist' => DbConfig::DT_VARCHAR
            ,'prj_prod_notices' => DbConfig::DT_VARCHAR

            ,'prj_prod_price_selling_total' => DbConfig::DT_NUMBER
            ,'prj_prod_price_part_total' => DbConfig::DT_NUMBER

            ,'prj_pay_method' => DbConfig::DT_NUMBER
            ,'prj_pay_completed_date' => DbConfig::DT_DATE
            ,'prj_pay_remain' => DbConfig::DT_NUMBER

            ,'prj_shurui_appr_memo' => DbConfig::DT_VARCHAR

            ,'prj_comm_partition_amount'=> DbConfig::DT_NUMBER
            ,'prj_comm_income_amount'=> DbConfig::DT_NUMBER
            ,'prj_comm_close_date_mgr'=> DbConfig::DT_VARCHAR
            ,'prj_comm_amount_mgr'=> DbConfig::DT_NUMBER
            ,'prj_comm_close_date_closer'=> DbConfig::DT_VARCHAR
            ,'prj_comm_amount_closer'=> DbConfig::DT_NUMBER
            ,'prj_comm_close_date_introducer'=> DbConfig::DT_VARCHAR
            ,'prj_comm_amount_introducer'=> DbConfig::DT_NUMBER
            ,'prj_comm_memo'=> DbConfig::DT_VARCHAR


            ,'deleted_flag' => DbConfig::DT_NUMBER
            ,'created_user' => DbConfig::DT_NUMBER
            ,'created_time' => DbConfig::DT_DATE
            ,'updated_user' => DbConfig::DT_NUMBER
            ,'updated_time' => DbConfig::DT_DATE
        )
        
        ,'prj_status_history' => array(
          'id' => DbConfig::DT_NUMBER
          ,'prj_id' => DbConfig::DT_NUMBER
          ,'prj_status' => DbConfig::DT_NUMBER
          ,'prj_status_updated_date' => DbConfig::DT_DATE
          ,'deleted_flag' => DbConfig::DT_NUMBER
          ,'created_user' => DbConfig::DT_NUMBER
          ,'created_time' => DbConfig::DT_DATE
          ,'updated_user' => DbConfig::DT_NUMBER
          ,'updated_time' => DbConfig::DT_DATE
        )

        ,'prj_file_history' => array(
          'id' => DbConfig::DT_NUMBER
          ,'prj_id' => DbConfig::DT_NUMBER
          ,'prj_file_type' => DbConfig::DT_NUMBER
          ,'prj_file_shubetsu' => DbConfig::DT_VARCHAR
          ,'prj_file_uploaded_date' => DbConfig::DT_DATE
          ,'prj_file_uploaded_staff' => DbConfig::DT_NUMBER
          ,'prj_file_file_name' => DbConfig::DT_VARCHAR
          ,'prj_file_file_path' => DbConfig::DT_VARCHAR
          ,'deleted_flag' => DbConfig::DT_NUMBER
          ,'created_user' => DbConfig::DT_NUMBER
          ,'created_time' => DbConfig::DT_DATE
          ,'updated_user' => DbConfig::DT_NUMBER
          ,'updated_time' => DbConfig::DT_DATE
        )

        ,'prj_prod_info' => array(
          'id' => DbConfig::DT_NUMBER
          ,'prj_id' => DbConfig::DT_NUMBER
          ,'sort_id' => DbConfig::DT_NUMBER
          ,'prj_prod_class' => DbConfig::DT_NUMBER
          ,'prj_prod_class_nm' => DbConfig::DT_VARCHAR
          ,'prj_prod_type' => DbConfig::DT_NUMBER
          ,'prj_prod_maker' => DbConfig::DT_NUMBER
          ,'prj_prod_model' => DbConfig::DT_VARCHAR
          ,'prj_prod_num' => DbConfig::DT_NUMBER
          ,'prj_prod_unit_price_selling' => DbConfig::DT_NUMBER
          ,'prj_prod_price_selling' => DbConfig::DT_NUMBER
          ,'prj_prod_unit_price_part' => DbConfig::DT_NUMBER
          ,'prj_prod_price_part' => DbConfig::DT_NUMBER
          ,'prj_prod_kw' => DbConfig::DT_NUMBER
          ,'prj_prod_memo' => DbConfig::DT_VARCHAR
          ,'deleted_flag' => DbConfig::DT_NUMBER
          ,'created_user' => DbConfig::DT_NUMBER
          ,'created_time' => DbConfig::DT_DATE
          ,'updated_user' => DbConfig::DT_NUMBER
          ,'updated_time' => DbConfig::DT_DATE
        )
        
        ,'prj_assign_info' => array(
          'id' => DbConfig::DT_NUMBER
          ,'prj_id' => DbConfig::DT_NUMBER
          ,'prj_role_grp' => DbConfig::DT_NUMBER
          ,'prj_staff_pos' => DbConfig::DT_NUMBER
          ,'prj_staff_id' => DbConfig::DT_NUMBER
          ,'deleted_flag' => DbConfig::DT_NUMBER
          ,'created_user' => DbConfig::DT_NUMBER
          ,'created_time' => DbConfig::DT_DATE
          ,'updated_user' => DbConfig::DT_NUMBER
          ,'updated_time' => DbConfig::DT_DATE
        )
        
        ,'prj_payment_info' => array(
          'id' => DbConfig::DT_NUMBER
          ,'prj_id' => DbConfig::DT_NUMBER
          ,'sort_id' => DbConfig::DT_NUMBER
          ,'prj_billing_date' => DbConfig::DT_DATE
          ,'prj_plan_pay_day' => DbConfig::DT_NUMBER
          ,'prj_paid_date' => DbConfig::DT_DATE
          ,'prj_plan_pay_amount' => DbConfig::DT_NUMBER
          ,'prj_plan_pay_per' => DbConfig::DT_NUMBER
          ,'prj_plan_pay_deposit' => DbConfig::DT_NUMBER
          ,'prj_plan_pay_memo' => DbConfig::DT_VARCHAR
          ,'prj_plan_paid_amount' => DbConfig::DT_NUMBER
          ,'prj_plan_paid_memo' => DbConfig::DT_VARCHAR
          ,'deleted_flag' => DbConfig::DT_NUMBER
          ,'created_user' => DbConfig::DT_NUMBER
          ,'created_time' => DbConfig::DT_DATE
          ,'updated_user' => DbConfig::DT_NUMBER
          ,'updated_time' => DbConfig::DT_DATE
        )

        ,'prj_progress_info' => array(
          'prj_id' => DbConfig::DT_NUMBER
          ,'prj_prg_eq_accre_id' => DbConfig::DT_VARCHAR
          ,'prj_prg_cust_login_id' => DbConfig::DT_VARCHAR
          ,'prj_prg_cust_login_passw' => DbConfig::DT_VARCHAR
          ,'prj_prg_tepco_num1' => DbConfig::DT_VARCHAR
          ,'prj_prg_tepco_num2' => DbConfig::DT_VARCHAR
          ,'prj_prg_update_date' => DbConfig::DT_DATE
          ,'prj_prg_module' => DbConfig::DT_VARCHAR
          ,'prj_prg_module_num' => DbConfig::DT_VARCHAR
          ,'prj_prg_pcs1' => DbConfig::DT_VARCHAR
          ,'prj_prg_pcs1_num' => DbConfig::DT_VARCHAR
          ,'prj_prg_pcs2' => DbConfig::DT_VARCHAR
          ,'prj_prg_pcs2_num' => DbConfig::DT_VARCHAR
          ,'prj_prg_sum_exp' => DbConfig::DT_VARCHAR
          ,'prj_prg_appl_out' => DbConfig::DT_VARCHAR
          ,'prj_prg_eq_cer_appl_date' => DbConfig::DT_DATE
          ,'prj_prg_el_recept_recv_date' => DbConfig::DT_DATE
          ,'prj_prg_eq_acc_res_date' => DbConfig::DT_DATE
          ,'prj_prg_cons_grant_cal_date' => DbConfig::DT_DATE
          ,'prj_prg_cons_grant' => DbConfig::DT_VARCHAR
          ,'prj_prg_cons_grant_pay_date' => DbConfig::DT_DATE
          ,'prj_prg_meter_fee' => DbConfig::DT_VARCHAR
          ,'prj_prg_conn_cons_appl_date' => DbConfig::DT_DATE
          ,'prj_prg_conn_cons_res_date' => DbConfig::DT_DATE
          ,'prj_prg_eq_cer_req' => DbConfig::DT_VARCHAR
          ,'prj_prg_appl_date' => DbConfig::DT_DATE
          ,'prj_prg_elec_use_appl_date' => DbConfig::DT_DATE
          ,'prj_prg_cons_amount' => DbConfig::DT_VARCHAR
          ,'prj_prg_tokyo_supply_demand' => DbConfig::DT_DATE
          ,'prj_prg_cons_grant_pay_date2' => DbConfig::DT_DATE
          ,'prj_prg_coop_pros' => DbConfig::DT_VARCHAR
          ,'prj_prg_note' => DbConfig::DT_VARCHAR
          ,'prj_prg_remark' => DbConfig::DT_VARCHAR 
          ,'deleted_flag' => DbConfig::DT_NUMBER
          ,'created_user' => DbConfig::DT_NUMBER
          ,'created_time' => DbConfig::DT_DATE
          ,'updated_user' => DbConfig::DT_NUMBER
          ,'updated_time' => DbConfig::DT_DATE
          )
      ,'prj_shurui_appr_mgt' => array(
          'prj_id'                => DbConfig::DT_NUMBER
          ,'prj_shurui_sort'      => DbConfig::DT_NUMBER
          ,'prj_pic_approve_sts'  => DbConfig::DT_NUMBER
          ,'prj_pic_approve_id'   => DbConfig::DT_NUMBER
          ,'prj_pic_approve_date' => DbConfig::DT_DATE
          ,'prj_sup_approve_sts'  => DbConfig::DT_NUMBER
          ,'prj_sup_approve_id'   => DbConfig::DT_NUMBER
          ,'prj_sup_approve_date' => DbConfig::DT_DATE
          ,'deleted_flag'         => DbConfig::DT_NUMBER
          ,'created_user'         => DbConfig::DT_NUMBER
          ,'created_time'         => DbConfig::DT_DATE
          ,'updated_user'         => DbConfig::DT_NUMBER
          ,'updated_time'         => DbConfig::DT_DATE
      )
      ,'prj_update_history' => array(
          'id'                => DbConfig::DT_NUMBER
          ,'prj_id'           => DbConfig::DT_NUMBER
          ,'upd_item_id'      => DbConfig::DT_NUMBER
          ,'upd_item_before'  => DbConfig::DT_VARCHAR 
          ,'upd_item_after'   => DbConfig::DT_VARCHAR 
          ,'upd_date_time'    => DbConfig::DT_DATE
          ,'upd_sts'          => DbConfig::DT_NUMBER
          ,'upd_by'           => DbConfig::DT_NUMBER
          ,'deleted_flag'     => DbConfig::DT_NUMBER
          ,'created_user'     => DbConfig::DT_NUMBER
          ,'created_time'     => DbConfig::DT_DATE
          ,'updated_user'     => DbConfig::DT_NUMBER
          ,'updated_time'     => DbConfig::DT_DATE
      )
      ,'staff_monthly_comission' => array(
          'staff_id'            => DbConfig::DT_NUMBER
          ,'comm_year_month'    => DbConfig::DT_VARCHAR 
          ,'commission_amount'  => DbConfig::DT_NUMBER
          ,'list_prj'           => DbConfig::DT_VARCHAR //for future
          ,'deleted_flag'       => DbConfig::DT_NUMBER
          ,'created_user'       => DbConfig::DT_NUMBER
          ,'created_time'       => DbConfig::DT_DATE
          ,'updated_user'       => DbConfig::DT_NUMBER
          ,'updated_time'       => DbConfig::DT_DATE
      )
      ,'prj_approve_status' => array(
        'prj_id'              =>  DbConfig::DT_NUMBER
        ,'staff_id'           =>  DbConfig::DT_NUMBER
        ,'approve_date'       =>  DbConfig::DT_DATE
        ,'approve_sts'        =>  DbConfig::DT_NUMBER
        ,'deleted_flag'       =>  DbConfig::DT_NUMBER
        ,'created_user'       =>  DbConfig::DT_NUMBER
        ,'created_time'       =>  DbConfig::DT_DATE
        ,'updated_user'       =>  DbConfig::DT_NUMBER
        ,'updated_time'       =>  DbConfig::DT_DATE
      )
      ,'prj_staff_comission' => array(
        'id'                     =>  DbConfig::DT_NUMBER
        ,'prj_id'                =>  DbConfig::DT_NUMBER
        ,'staff_id'              =>  DbConfig::DT_NUMBER
        ,'staff_group'           =>  DbConfig::DT_NUMBER
        ,'commission_year_month' =>  DbConfig::DT_VARCHAR 
        ,'commission_amount'     =>  DbConfig::DT_NUMBER
        ,'cancel_flag'           =>  DbConfig::DT_NUMBER 
        ,'deleted_flag'          =>  DbConfig::DT_NUMBER
        ,'created_user'          =>  DbConfig::DT_NUMBER
        ,'created_time'          =>  DbConfig::DT_DATE
        ,'updated_user'          =>  DbConfig::DT_NUMBER
        ,'updated_time'          =>  DbConfig::DT_DATE
      )
	);

}
?>

