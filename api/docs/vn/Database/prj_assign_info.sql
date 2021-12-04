-- Project Name : iwaki
-- Date/Time    : 2016-03-21 4:37:35 PM
-- Author       : iwaki
-- RDBMS Type   : MySQL
-- Application  : A5:SQL Mk-2

-- ˆÄŒ’S“–Ò
drop table if exists prj_assign_info cascade;

create table prj_assign_info (
  id INT(11) not null AUTO_INCREMENT comment 'ID'
  , prj_id INT(11) comment 'ˆÄŒID'
  , prj_role_grp INT(2) comment '’S“–í•Ê	 1:’S“–‰c‹Æ, 2:ƒNƒ[ƒU[, 3:Ğ‰îÒ'
  , prj_staff_pos INT(2) comment '’S“–‡”Ô	 1`10'
  , prj_staff_id INT(11) comment '’S“–ID'
  , deleted_flag INT(1) default 0 comment 'íœƒtƒ‰ƒO'
  , created_user INT(11) not null comment '‰‰ñ“o˜^Ò'
  , created_time DATETIME default current_timestamp not null comment '‰‰ñ“o˜^“ú'
  , updated_user INT(11) comment 'ÅIXVÒ'
  , updated_time DATETIME comment 'ÅIXV“ú'
  , constraint prj_assign_info_PKC primary key (id)
) comment 'ˆÄŒ’S“–Ò	 ˆÄŒ’S“–Ò' ;

