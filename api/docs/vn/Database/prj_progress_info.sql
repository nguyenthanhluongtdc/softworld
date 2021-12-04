-- Project Name : iwaki
-- Date/Time    : 2016-04-06 10:04:55 AM
-- Author       : iwaki
-- RDBMS Type   : MySQL
-- Application  : A5:SQL Mk-2

-- 進捗情報
drop table if exists prj_progress_info cascade;

create table prj_progress_info (
  prj_id INT(11) not null comment '案件ID'
  , prj_prg_eq_accre_id VARCHAR(250) comment '設備認定ID'
  , prj_prg_cust_login_id VARCHAR(250) comment 'お客様ログインID'
  , prj_prg_cust_login_passw VARCHAR(250) comment 'お客様ログインパスワード'
  , prj_prg_tepco_num1 VARCHAR(10) comment '東京電力申込番号'
  , prj_prg_tepco_num2 VARCHAR(10) comment '東京電力申込番号2'
  , prj_prg_update_date DATETIME comment '更新日'
  , prj_prg_module VARCHAR(250) comment 'モジュール'
  , prj_prg_module_num VARCHAR(250) comment 'モジュール枚数'
  , prj_prg_pcs1 VARCHAR(250) comment 'PCS1'
  , prj_prg_pcs1_num VARCHAR(250)  comment 'PCS1台数'
  , prj_prg_pcs2 VARCHAR(250) comment 'PCS2'
  , prj_prg_pcs2_num VARCHAR(250) comment 'PCS2台数'
  , prj_prg_sum_exp VARCHAR(250) comment '合計出力'
  , prj_prg_appl_out VARCHAR(250) comment '申請出力'
  , prj_prg_eq_cer_appl_date DATE comment '設備認定申請日'
  , prj_prg_el_recept_recv_date DATE comment '電力受給受付日'
  , prj_prg_eq_acc_res_date DATE comment '設備認定回答日'
  , prj_prg_cons_grant_cal_date DATE comment '工事負担金算出日'
  , prj_prg_cons_grant VARCHAR(250) comment '工事負担金'
  , prj_prg_cons_grant_pay_date DATE comment '工事負担金支払日'
  , prj_prg_meter_fee VARCHAR(250) comment 'メーター代'
  , prj_prg_conn_cons_appl_date DATE comment '接続検討申請日'
  , prj_prg_eq_acc_res_date2 DATE comment '設備認定回答日'
  , prj_prg_conn_cons_res_date DATE comment '接続検討回答日'
  , prj_prg_eq_cer_req VARCHAR(250) comment '設備認定条件付き'
  , prj_prg_appl_date DATE comment '本申込み日'
  , prj_prg_elec_use_appl_date DATE comment '電気使用申込日'
  , prj_prg_cons_amount VARCHAR(250) comment '工事負担金額'
  , prj_prg_tokyo_supply_demand DATE comment '東京電力電力需給'
  , prj_prg_cons_grant_pay_date2 DATE comment '工事負担金支払い日'
  , prj_prg_coop_pros VARCHAR(250) comment '連携見込み'
  , prj_prg_note VARCHAR(250) comment 'メモ欄'
  , prj_prg_remark VARCHAR(5000) comment '備考欄'
  , deleted_flag INT(1) default 0 comment '削除フラグ'
  , created_user INT(11) not null comment '初回登録者'
  , created_time DATETIME not null comment '初回登録日時'
  , updated_user INT(11) comment '最終更新者'
  , updated_time DATETIME comment '最終更新日時'
  , constraint prj_progress_info_PKC primary key (prj_id)
) comment '進捗情報' ;

