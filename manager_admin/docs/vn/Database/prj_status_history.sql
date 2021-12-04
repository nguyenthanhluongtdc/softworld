-- Project Name : iwaki
-- Date/Time    : 2016-03-16 5:02:21 PM
-- Author       : iwaki
-- RDBMS Type   : MySQL
-- Application  : A5:SQL Mk-2

-- 案件ステータス履歴
drop table if exists prj_status_history cascade;

create table prj_status_history (
  id INT(11) not null AUTO_INCREMENT comment 'ID'
  , prj_id INT(11) comment '案件ID'
  , prj_status INT(2) comment '案件ステータスID'
  , prj_status_updated_date DATETIME default current_timestamp comment '更新日付'
  , deleted_flag INT(1) default 0 comment '削除フラグ'
  , created_user INT(11) not null comment '初回登録者'
  , created_time DATETIME default current_timestamp not null comment '初回登録日時'
  , updated_user INT(11) comment '最終更新者'
  , updated_time DATETIME comment '最終更新日時'
  , constraint prj_status_history_PKC primary key (id)
) comment '案件ステータス履歴	 案件ステータス履歴' ;

