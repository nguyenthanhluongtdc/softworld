-- Project Name : iwaki
-- Date/Time    : 2016-04-11 8:05:55 PM
-- Author       : iwaki
-- RDBMS Type   : MySQL
-- Application  : A5:SQL Mk-2

-- 書類等承認
drop table if exists prj_shurui_appr_mgt cascade;

create table prj_shurui_appr_mgt (
  prj_id INT(11) not null comment '案件ID'
  , prj_shurui_sort INT(2) not null comment '書類等区分	 1~6'
  , prj_pic_approve_sts INT(2) comment '担当者承認状況	 0: 未承認、1:済承認'
  , prj_pic_approve_id INT(11) comment '担当ID	 承認者ID'
  , prj_pic_approve_date DATETIME comment '担当者承認日付'
  , prj_sup_approve_sts INT(2) comment '承認者承認状況'
  , prj_sup_approve_id INT(11) comment '承認者ID'
  , prj_sup_approve_date DATETIME comment '承認者承認日付'
  , deleted_flag INT(1) default 0 comment '削除フラグ'
  , created_user INT(11) not null comment '初回登録者'
  , created_time DATETIME not null comment '初回登録日時'
  , updated_user INT(11) comment '最終更新者'
  , updated_time DATETIME comment '最終更新日時'
  , constraint prj_shurui_appr_mgt_PKC primary key (prj_id,prj_shurui_sort)
) comment '書類等承認	 書類等承認' ;

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

-- 案件担当者
drop table if exists prj_assign_info cascade;

create table prj_assign_info (
  id INT(11) not null AUTO_INCREMENT comment 'ID'
  , prj_id INT(11) comment '案件ID'
  , prj_role_grp INT(2) comment '担当種別	 1:担当営業, 2:クローザー, 3:紹介者'
  , prj_staff_pos INT(2) comment '担当順番	 1～10'
  , prj_staff_id INT(11) comment '担当ID'
  , deleted_flag INT(1) default 0 comment '削除フラグ'
  , created_user INT(11) not null comment '初回登録者'
  , created_time DATETIME not null comment '初回登録日時'
  , updated_user INT(11) comment '最終更新者'
  , updated_time DATETIME comment '最終更新日時'
  , constraint prj_assign_info_PKC primary key (id)
) comment '案件担当者	 案件担当者' ;

-- 案件支払い詳細
drop table if exists prj_payment_info cascade;

create table prj_payment_info (
  id INT(11) not null AUTO_INCREMENT comment 'ID'
  , prj_id INT(11) comment '案件ID'
  , sort_id INT(1) comment '準備ID	 0~5'
  , prj_billing_date DATE comment '請求日'
  , prj_plan_pay_day INT(3) comment '支払い予定日'
  , prj_paid_date DATE comment '支払済日'
  , prj_plan_pay_amount INT(11) comment '支払予定金額'
  , prj_plan_pay_per INT(3) comment '支払予定金額%'
  , prj_plan_pay_deposit INT(1) comment '支払予定金額頭金	 0: チェックしない、1：チェックする'
  , prj_plan_pay_memo VARCHAR(250) comment '支払予定金額メモ'
  , prj_plan_paid_amount INT(11) comment '支払済金額'
  , prj_plan_paid_memo VARCHAR(250) comment '支払済メモ'
  , deleted_flag INT(1) default 0 comment '削除フラグ'
  , created_user INT(11) not null comment '初回登録者'
  , created_time DATETIME default current_timestamp not null comment '初回登録日時'
  , updated_user INT(11) comment '最終更新者'
  , updated_time DATETIME comment '最終更新日時'
  , constraint prj_payment_info_PKC primary key (id)
) comment '案件支払い詳細	 案件支払い詳細' ;

-- 案件製品情報
drop table if exists prj_prod_info cascade;

create table prj_prod_info (
  id INT(11) not null AUTO_INCREMENT comment 'ID'
  , prj_id INT(11) comment '案件ID'
  , sort_id INT(1) comment '準備ID'
  , prj_prod_class INT(2) comment '製品分類'
  , prj_prod_class_nm VARCHAR(250) comment '製品分類名'
  , prj_prod_type INT(1) comment '製品区分'
  , prj_prod_maker INT(3) comment '製品メーカー'
  , prj_prod_model VARCHAR(250) comment '製品型式'
  , prj_prod_num INT(4) comment '製品個数'
  , prj_prod_unit_price_selling INT(11) comment '製品販売単価'
  , prj_prod_price_selling INT(11) comment '販売金額'
  , prj_prod_unit_price_part INT(11) comment '仕切単価'
  , prj_prod_price_part INT(11) comment '仕切り金額'
  , prj_prod_kw INT(11) comment 'Kw'
  , prj_prod_memo VARCHAR(5000) comment '備考'
  , deleted_flag INT(1) default 0 comment '削除フラグ'
  , created_user INT(11) not null comment '初回登録者'
  , created_time DATETIME not null comment '初回登録日時'
  , updated_user INT(11) comment '最終更新者'
  , updated_time DATETIME comment '最終更新日時'
  , constraint prj_prod_info_PKC primary key (id)
) comment '案件製品情報	 案件製品情報' ;

-- 書類履歴
drop table if exists prj_file_history cascade;

create table prj_file_history (
  id INT(11) not null AUTO_INCREMENT comment 'ID'
  , prj_id INT(11) comment '案件ID'
  , prj_file_type INT(2) comment '書類区分	 1: 各種書類履歴, 2:見積履歴'
  , prj_file_shubetsu INT(2) comment '各種書類履歴種別'
  , prj_file_uploaded_date DATETIME comment 'アップロード日'
  , prj_file_uploaded_staff INT(11) comment 'アップロード者'
  , prj_file_file_name VARCHAR(500) comment 'ファイル名	 Display file name'
  , prj_file_file_path VARCHAR(500) comment 'ファイルパス	 Name that store on disk'
  , deleted_flag INT(1) default 0 comment '削除フラグ'
  , created_user INT(11) not null comment '初回登録者'
  , created_time DATETIME not null comment '初回登録日時'
  , updated_user INT(11) comment '最終更新者'
  , updated_time DATETIME comment '最終更新日時'
  , constraint prj_file_history_PKC primary key (id)
) comment '書類履歴	 書類履歴' ;

-- 案件ステータス履歴
drop table if exists prj_status_history cascade;

create table prj_status_history (
  id INT(11) not null AUTO_INCREMENT comment 'ID'
  , prj_id INT(11) comment '案件ID'
  , prj_status INT(2) comment '案件ステータスID'
  , prj_status_updated_date DATETIME comment '更新日付'
  , deleted_flag INT(1) default 0 comment '削除フラグ'
  , created_user INT(11) not null comment '初回登録者'
  , created_time DATETIME default current_timestamp not null comment '初回登録日時'
  , updated_user INT(11) comment '最終更新者'
  , updated_time DATETIME comment '最終更新日時'
  , constraint prj_status_history_PKC primary key (id)
) comment '案件ステータス履歴	 案件ステータス履歴' ;

-- 案件情報
drop table if exists prj_info cascade;

create table prj_info (
  prj_id INT(11) not null AUTO_INCREMENT comment '案件ID'
  , prj_status INT(2) not null comment '案件ステータス	 0:見積提出、1:仮契約、2:本契約、10:キャンセル'
  , prj_maker INT(3) comment '案件メーカー'
  , prj_cust_name VARCHAR(250) not null comment 'お客様氏名	 お客様氏名'
  , prj_cust_pos_code VARCHAR(8) comment '住所（お客様住居）1	 XXX-YYYY'
  , prj_cust_prefectures INT comment '住所（お客様住居）2'
  , prj_cust_city VARCHAR(250) comment '住所（お客様住居）3'
  , prj_cust_address VARCHAR(250) comment '住所（お客様住居）4'
  , prj_cust_mansion_info VARCHAR(250) comment '住所（お客様住居）5'
  , prj_cust_ins_loc_pos_code VARCHAR(8) comment '住所（設置場所）1	 XXX-YYYY'
  , prj_cust_ins_loc_prefectures INT comment '住所（設置場所）2'
  , prj_cust_ins_loc_city VARCHAR(250) comment '住所（設置場所）3'
  , prj_cust_ins_loc_address VARCHAR(250) comment '住所（設置場所）4'
  , prj_cust_ins_loc_mansion_info VARCHAR(250) comment '住所（設置場所）5'
  , prj_cust_phone_num VARCHAR(13) not null comment '電話番号'
  , prj_cust_email VARCHAR(100) not null comment 'メールアドレス'
  , prj_cust_memo VARCHAR(5000) comment 'その他備考	 その他備考'
  , prj_kind_contract INT(2) comment '種別契約種別	 日程・各種履歴・帳票情報'
  , prj_kind_garage INT(2) comment '種別車庫	 日程・各種履歴・帳票情報'
  , prj_kind_pv VARCHAR(250) comment '種別PV	 Comma separated(A,B,C..)'
  , prj_kind_od VARCHAR(250) comment '種別OD	 Comma separated(A,B,C..)'
  , prj_gencho_bi DATE comment '現調日	 日程・各種履歴・帳票情報'
  , prj_keiyaku_bi DATE comment '契約日	 日程・各種履歴・帳票情報'
  , prj_koji_kaishi_bi DATE comment '工事開始日	 日程・各種履歴・帳票情報'
  , prj_setsubi_nintei_shinsei_bi1 DATE comment '設備認定 申請日1	 日程・各種履歴・帳票情報'
  , prj_setsubi_nintei_shinsei_bi2 DATE comment '設備認定 申請日2	 日程・各種履歴・帳票情報'
  , prj_setsubi_nintei_shinsei_bi3 DATE comment '設備認定 申請日3	 日程・各種履歴・帳票情報'
  , prj_uchi_ochi_yotei_bi DATE comment '内落予定日	 日程・各種履歴・帳票情報'
  , prj_uchi_ochi_kakutei_bi DATE comment '内落確定日	 日程・各種履歴・帳票情報'
  , prj_renkei_bi DATE comment '連系日	 日程・各種履歴・帳票情報'
  , prj_renkei_done INT(1) comment '営業宛連絡済	 日程・各種履歴・帳票情報'
  , prj_kanko_bi DATE comment '完工日	 日程・各種履歴・帳票情報'
  , prj_setchi_hiyo_nenpo_shinsei_bi DATE comment '設置費用年報申請日	 日程・各種履歴・帳票情報'
  , prj_unten_hiyo_nenpo_shinsei_bi DATE comment '運転費用年報申請日	 日程・各種履歴・帳票情報'
  , prj_kyanceru_bi DATE comment 'キャンセル日	 日程・各種履歴・帳票情報'
  , prj_prod_price_selling_total INT(11) comment '製品販売金額合計	 商品情報'
  , prj_prod_price_part_total INT(11) comment '製品仕切り金額合計	 商品情報'
  , prj_prod_checklist VARCHAR(5000) comment '製品情報確認事項	 商品情報'
  , prj_prod_notices VARCHAR(5000) comment '製品情報特記事項	 商品情報'
  , prj_pay_method INT(1) comment '支払い方法	 1:未定   2:現金  3:クレジット'
  , prj_pay_remain INT(11) comment '未納金額	 請求金額合計 - 支払い済み金額合計'
  , prj_pay_completed_date DATE comment '支払い完納日'
  , prj_comm_partition_amount INT(11) comment '仕切金額	 担当営業仕切金額'
  , prj_comm_income_amount INT(11) comment '利益額'
  , prj_comm_close_date_mgr VARCHAR(6) comment '担当営業歩合締日	 YYYYMM'
  , prj_comm_amount_mgr INT(11) comment '担当営業歩合'
  , prj_comm_close_date_closer VARCHAR(6) comment 'クローザー歩合締日	 YYYYMM'
  , prj_comm_amount_closer INT(11) comment 'クローザー歩合'
  , prj_comm_close_date_introducer VARCHAR(6) comment '紹介者歩合締日	 YYYYMM'
  , prj_comm_amount_introducer INT(11) comment '紹介者歩合'
  , prj_comm_memo VARCHAR(5000) comment '歩合メモ'
  , prj_shurui_appr_memo VARCHAR(5000) comment '書類等承認メモ'
  , deleted_flag INT(1) default 0 comment '削除フラグ	 0:削除なし、1：削除する'
  , created_user INT(11) not null comment '初回登録者'
  , created_time DATETIME not null comment '初回登録日時'
  , updated_user INT(11) comment '最終更新者'
  , updated_time DATETIME comment '最終更新日時'
  , constraint prj_info_PKC primary key (prj_id)
) comment '案件情報	 案件情報テーブル' ;

-- 社員権限
drop table if exists m_staff_roles cascade;

create table m_staff_roles (
  staff_id INT(11) not null comment '社員ID'
  , role_id INT(1) not null comment '権限ID'
  , deleted_flag INT(1) default 0 comment '削除フラグ'
  , created_user INT(11) not null comment '初回登録者'
  , created_time DATETIME default current_timestamp not null comment '初回登録日時'
  , updated_user INT(11) comment '最終更新者'
  , updated_time DATETIME comment '最終更新日時'
  , constraint m_staff_roles_PKC primary key (staff_id,role_id)
) comment '社員権限' ;

-- 事業所管理テーブル
drop table if exists m_office_info cascade;

create table m_office_info (
  office_id INT(11) not null AUTO_INCREMENT comment '事業所ID'
  , office_name VARCHAR(200) not null comment '事業所名	 事業所名'
  , office_name_kana VARCHAR(200) comment '社員名カナ'
  , office_pos_code VARCHAR(8) not null comment '郵便番号	 XXX-YYYY'
  , office_prefectures INT not null comment '都道府県'
  , office_city VARCHAR(250) comment '市区町村'
  , office_address VARCHAR(500) comment '番地'
  , office_mansion_info VARCHAR(250) comment 'マンション/ビル名等	 マンション/ビル名等'
  , office_phone_num VARCHAR(13) not null comment '電話番号'
  , office_fax_num VARCHAR(13) comment 'FAX番号'
  , office_email VARCHAR(100) not null comment 'メールアドレス'
  , office_memo VARCHAR(2000) comment 'その他備考	 その他備考'
  , deleted_flag INT(1) default 0 comment '削除フラグ	 0:削除なし、1：削除する'
  , created_user INT(11) not null comment '初回登録者'
  , created_time DATETIME not null comment '初回登録日時'
  , updated_user INT(11) comment '最終更新者'
  , updated_time DATETIME comment '最終更新日時'
  , constraint m_office_info_PKC primary key (office_id)
) comment '事業所管理テーブル	 事業所管理テーブル' ;

-- 社員管理テーブル
drop table if exists m_staff cascade;

create table m_staff (
  staff_id INT(11) not null AUTO_INCREMENT comment '社員コード'
  , staff_name VARCHAR(100) not null comment '社員名	 社員名'
  , staff_name_kana VARCHAR(100) comment '社員名カナ'
  , staff_office_id INT(11) not null comment '事業所名	 事業所管理参考'
  , staff_department_id INT(11) not null comment '部署	 default_arrayから取得'
  , staff_password VARCHAR(128) not null comment 'パスワード	 MD5パスワード'
  , staff_pos_code VARCHAR(8) not null comment '郵便番号	 XXX-YYYY'
  , staff_prefectures INT not null comment '都道府県'
  , staff_city VARCHAR(250) comment '市区町村'
  , staff_address VARCHAR(500) comment '番地'
  , staff_mansion_info VARCHAR(250) comment 'マンション/ビル名等	 マンション/ビル名等'
  , staff_phone_num VARCHAR(13) not null comment '電話番号'
  , staff_email VARCHAR(100) not null comment 'メールアドレス'
  , staff_supervisor INT(11) comment '上役指定	 上役指定'
  , staff_is_notify_mail INT(1) comment '案件変更メール	 全ての案件の変更メールを受け取る'
  , staff_memo VARCHAR(2000) comment 'その他備考	 その他備考'
  , deleted_flag INT(1) default 0 comment '削除フラグ	 0:削除なし、1：削除する'
  , created_user INT(11) not null comment '初回登録者'
  , created_time DATETIME not null comment '初回登録日時'
  , updated_user INT(11) comment '最終更新者'
  , updated_time DATETIME comment '最終更新日時'
  , constraint m_staff_PKC primary key (staff_id)
) comment '社員管理テーブル	 システムユーザ管理テーブル' ;

