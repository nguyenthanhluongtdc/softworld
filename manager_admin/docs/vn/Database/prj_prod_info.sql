-- Project Name : iwaki
-- Date/Time    : 2016-03-21 2:05:20 PM
-- Author       : iwaki
-- RDBMS Type   : MySQL
-- Application  : A5:SQL Mk-2

-- Ä»iîñ
drop table if exists prj_prod_info cascade;

create table prj_prod_info (
  id INT(11) not null AUTO_INCREMENT comment 'ID'
  , prj_id INT(11) comment 'ÄID'
  , sort_id INT(1) comment 'õID'
  , prj_prod_class INT(2) comment '»iªÞ'
  , prj_prod_class_nm VARCHAR(250) comment '»iªÞ¼'
  , prj_prod_type INT(1) comment '»iæª'
  , prj_prod_maker INT(3) comment '»i[J['
  , prj_prod_model VARCHAR(250) comment '»i^®'
  , prj_prod_num INT(4) comment '»iÂ'
  , prj_prod_unit_price_selling INT(11) comment '»iÌP¿'
  , prj_prod_price_selling INT(11) comment 'Ìàz'
  , prj_prod_unit_price_part INT(11) comment 'dØP¿'
  , prj_prod_price_part INT(11) comment 'dØèàz'
  , prj_prod_kw INT(11) comment 'Kw'
  , prj_prod_memo VARCHAR(5000) comment 'õl'
  , deleted_flag INT(1) default 0 comment 'ítO'
  , created_user INT(11) not null comment 'ño^Ò'
  , created_time DATETIME default current_timestamp not null comment 'ño^ú'
  , updated_user INT(11) comment 'ÅIXVÒ'
  , updated_time DATETIME comment 'ÅIXVú'
  , constraint prj_prod_info_PKC primary key (id)
) comment 'Ä»iîñ	 Ä»iîñ' ;

