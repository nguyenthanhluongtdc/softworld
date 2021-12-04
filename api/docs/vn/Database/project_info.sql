-- Project Name : iwaki
-- Date/Time    : 2016-03-16 5:01:53 PM
-- Author       : iwaki
-- RDBMS Type   : MySQL
-- Application  : A5:SQL Mk-2

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
  , prj_cust_memo VARCHAR(50000) comment 'その他備考	 その他備考'
  , deleted_flag INT(1) default 0 comment '削除フラグ	 0:削除なし、1：削除する'
  , created_user INT(11) not null comment '初回登録者'
  , created_time DATETIME not null comment '初回登録日時'
  , updated_user INT(11) comment '最終更新者'
  , updated_time DATETIME comment '最終更新日時'
  , constraint project_info_PKC primary key (prj_id)
) comment '案件情報	 案件情報テーブル' ;

