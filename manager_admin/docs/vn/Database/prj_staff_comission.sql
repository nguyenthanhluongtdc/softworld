-- Project Name : iwaki
-- Date/Time    : 2016-04-27 6:48:37 PM
-- Author       : iwaki
-- RDBMS Type   : MySQL
-- Application  : A5:SQL Mk-2

-- ÄSÒà
drop table if exists prj_staff_comission cascade;

create table prj_staff_comission (
  id INT(11) not null AUTO_INCREMENT comment 'ID'
  , prj_id INT(11) not null comment 'ÄID'
  , staff_id INT(11) not null comment 'ÐõID'
  , staff_group INT(1) not null comment 'SíÊ	 1:ScÆ,2:N[U[,3:ÐîÒ'
  , commission_year_month VARCHAR(6) not null comment 'N'
  , commission_amount INT(12) comment 'ààz'
  , deleted_flag INT(1) default 0 comment 'ítO'
  , created_user INT(11) not null comment 'ño^Ò'
  , created_time DATETIME not null comment 'ño^ú'
  , updated_user INT(11) comment 'ÅIXVÒ'
  , updated_time DATETIME comment 'ÅIXVú'
  , constraint prj_staff_comission_PKC primary key (id)
) comment 'ÄSÒà	 ÄSÒà' ;

