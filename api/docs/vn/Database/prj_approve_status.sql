-- Project Name : iwaki
-- Date/Time    : 2016-04-20 2:45:06 PM
-- Author       : iwaki
-- RDBMS Type   : MySQL
-- Application  : A5:SQL Mk-2

-- ³Fóµ
drop table if exists prj_approve_status cascade;

create table prj_approve_status (
  prj_id INT(11) not null comment 'ÄID'
  , staff_id INT(11) not null comment 'ÐõID	 ³FÒID'
  , approve_date DATETIME comment '³Fút'
  , approve_sts INT(2) comment '³Fóµ'
  , deleted_flag INT(1) default 0 comment 'ítO'
  , created_user INT(11) not null comment 'ño^Ò'
  , created_time DATETIME not null comment 'ño^ú'
  , updated_user INT(11) comment 'ÅIXVÒ'
  , updated_time DATETIME comment 'ÅIXVú'
  , constraint prj_approve_status_PKC primary key (prj_id,staff_id)
) comment '³Fóµ	 ³Fóµ' ;

