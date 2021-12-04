-- Project Name : iwaki
-- Date/Time    : 2016-03-21 4:37:11 PM
-- Author       : iwaki
-- RDBMS Type   : MySQL
-- Application  : A5:SQL Mk-2

-- Äx¥¢Ú×
drop table if exists prj_payment_info cascade;

create table prj_payment_info (
  id INT(11) not null AUTO_INCREMENT comment 'ID'
  , prj_id INT(11) comment 'ÄID'
  , sort_id INT(1) comment 'õID	 0~5'
  , prj_billing_date DATE comment '¿ú'
  , prj_plan_pay_day INT(3) comment 'x¥¢\èú'
  , prj_paid_date DATE comment 'x¥Ïú'
  , prj_plan_pay_amount INT(11) comment 'x¥\èàz'
  , prj_plan_pay_per INT(3) comment 'x¥\èàz%'
  , prj_plan_pay_deposit INT(1) comment 'x¥\èàzªà	 0: `FbNµÈ¢A1F`FbN·é'
  , prj_plan_pay_memo VARCHAR(250) comment 'x¥\èàz'
  , prj_plan_paid_amount INT(11) comment 'x¥Ïàz'
  , prj_plan_paid_memo VARCHAR(250) comment 'x¥Ï'
  , deleted_flag INT(1) default 0 comment 'ítO'
  , created_user INT(11) not null comment 'ño^Ò'
  , created_time DATETIME default current_timestamp not null comment 'ño^ú'
  , updated_user INT(11) comment 'ÅIXVÒ'
  , updated_time DATETIME comment 'ÅIXVú'
  , constraint prj_payment_info_PKC primary key (id)
) comment 'Äx¥¢Ú×	 Äx¥¢Ú×' ;

