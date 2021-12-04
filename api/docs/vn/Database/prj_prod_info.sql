-- Project Name : iwaki
-- Date/Time    : 2016-03-21 2:05:20 PM
-- Author       : iwaki
-- RDBMS Type   : MySQL
-- Application  : A5:SQL Mk-2

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
  , created_time DATETIME default current_timestamp not null comment '初回登録日時'
  , updated_user INT(11) comment '最終更新者'
  , updated_time DATETIME comment '最終更新日時'
  , constraint prj_prod_info_PKC primary key (id)
) comment '案件製品情報	 案件製品情報' ;

