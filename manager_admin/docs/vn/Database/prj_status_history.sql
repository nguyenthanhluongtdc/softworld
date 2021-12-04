-- Project Name : iwaki
-- Date/Time    : 2016-03-16 5:02:21 PM
-- Author       : iwaki
-- RDBMS Type   : MySQL
-- Application  : A5:SQL Mk-2

-- ÄXe[^Xð
drop table if exists prj_status_history cascade;

create table prj_status_history (
  id INT(11) not null AUTO_INCREMENT comment 'ID'
  , prj_id INT(11) comment 'ÄID'
  , prj_status INT(2) comment 'ÄXe[^XID'
  , prj_status_updated_date DATETIME default current_timestamp comment 'XVút'
  , deleted_flag INT(1) default 0 comment 'ítO'
  , created_user INT(11) not null comment 'ño^Ò'
  , created_time DATETIME default current_timestamp not null comment 'ño^ú'
  , updated_user INT(11) comment 'ÅIXVÒ'
  , updated_time DATETIME comment 'ÅIXVú'
  , constraint prj_status_history_PKC primary key (id)
) comment 'ÄXe[^Xð	 ÄXe[^Xð' ;

