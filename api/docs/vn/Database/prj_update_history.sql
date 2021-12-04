-- Project Name : iwaki
-- Date/Time    : 2016-04-28 5:18:08 PM
-- Author       : iwaki
-- RDBMS Type   : MySQL
-- Application  : A5:SQL Mk-2

-- ÄXVð
drop table if exists prj_update_history cascade;

create table prj_update_history (
  id INT(11) not null AUTO_INCREMENT comment 'ID	 ðID'
  , prj_id INT(11) not null comment 'ÄID'
  , upd_date_time DATEIME not null comment 'XVút'
  , upd_item_id INT(2) not null comment 'ÚID'
  , upd_item_before VARCHAR(5000) comment 'XVO'
  , upd_item_after VARCHAR(5000) comment 'XVã'
  , upd_sts INT(2) comment 'XVóµ	 0: XVÈµA1FXV è'
  , upd_by INT(11) comment 'XVÒ'
  , deleted_flag INT(1) default 0 comment 'ítO'
  , created_user INT(11) not null comment 'ño^Ò'
  , created_time DATETIME not null comment 'ño^ú'
  , updated_user INT(11) comment 'ÅIXVÒ'
  , updated_time DATETIME comment 'ÅIXVú'
  , constraint prj_update_history_PKC primary key (id)
) comment 'ÄXVð	 ÄXVð' ;

