-- Project Name : iwaki
-- Date/Time    : 2016-04-28 5:18:08 PM
-- Author       : iwaki
-- RDBMS Type   : MySQL
-- Application  : A5:SQL Mk-2

-- 案件更新履歴
drop table if exists prj_update_history cascade;

create table prj_update_history (
  id INT(11) not null AUTO_INCREMENT comment 'ID	 履歴ID'
  , prj_id INT(11) not null comment '案件ID'
  , upd_date_time DATEIME not null comment '更新日付'
  , upd_item_id INT(2) not null comment '項目ID'
  , upd_item_before VARCHAR(5000) comment '更新前'
  , upd_item_after VARCHAR(5000) comment '更新後'
  , upd_sts INT(2) comment '更新状況	 0: 更新なし、1：更新あり'
  , upd_by INT(11) comment '更新者'
  , deleted_flag INT(1) default 0 comment '削除フラグ'
  , created_user INT(11) not null comment '初回登録者'
  , created_time DATETIME not null comment '初回登録日時'
  , updated_user INT(11) comment '最終更新者'
  , updated_time DATETIME comment '最終更新日時'
  , constraint prj_update_history_PKC primary key (id)
) comment '案件更新履歴	 案件更新履歴' ;

