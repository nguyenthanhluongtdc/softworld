-- Project Name : iwaki
-- Date/Time    : 2016-03-18 6:53:27 PM
-- Author       : iwaki
-- RDBMS Type   : MySQL
-- Application  : A5:SQL Mk-2

-- 書類履歴
drop table if exists prj_file_history cascade;

create table prj_file_history (
  id INT(11) not null AUTO_INCREMENT comment 'ID'
  , prj_id INT(11) comment '案件ID'
  , prj_file_type INT(2) comment '書類区分	 1: 各種書類履歴, 2:見積履歴'
  , prj_file_shubetsu INT(2) comment '各種書類履歴種別'
  , prj_file_uploaded_date DATETIME default current_timestamp comment 'アップロード日'
  , prj_file_uploaded_staff INT(11) comment 'アップロード者'
  , prj_file_file_name VARCHAR(500) comment 'ファイル名	 Display file name'
  , prj_file_file_path VARCHAR(500) comment 'ファイルパス	 Name that store on disk'
  , deleted_flag INT(1) default 0 comment '削除フラグ'
  , created_user INT(11) not null comment '初回登録者'
  , created_time DATETIME default current_timestamp not null comment '初回登録日時'
  , updated_user INT(11) comment '最終更新者'
  , updated_time DATETIME comment '最終更新日時'
  , constraint prj_file_history_PKC primary key (id)
) comment '書類履歴	 書類履歴' ;

