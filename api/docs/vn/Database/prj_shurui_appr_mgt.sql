-- Project Name : iwaki
-- Date/Time    : 2016-04-11 7:15:26 PM
-- Author       : iwaki
-- RDBMS Type   : MySQL
-- Application  : A5:SQL Mk-2

-- Þ³F
drop table if exists prj_shurui_appr_mgt cascade;

create table prj_shurui_appr_mgt (
  prj_id INT(11) not null comment 'ÄID'
  , prj_shurui_sort INT(2) not null comment 'Þæª	 1~6'
  , prj_pic_approve_sts INT(2) comment 'SÒ³Fóµ	 0: ¢³FA1:Ï³F'
  , prj_pic_approve_id INT(11) comment 'SID	 ³FÒID'
  , prj_pic_approve_date DATETIME comment 'SÒ³Fút'
  , prj_sup_approve_sts INT(2) comment '³FÒ³Fóµ'
  , prj_sup_approve_id INT(11) comment '³FÒID'
  , prj_sup_approve_date DATETIME comment '³FÒ³Fút'
  , deleted_flag INT(1) default 0 comment 'ítO'
  , created_user INT(11) not null comment 'ño^Ò'
  , created_time DATETIME not null comment 'ño^ú'
  , updated_user INT(11) comment 'ÅIXVÒ'
  , updated_time DATETIME comment 'ÅIXVú'
  , constraint prj_shurui_appr_mgt_PKC primary key (prj_id,prj_shurui_sort)
) comment 'Þ³F	 Þ³F' ;

