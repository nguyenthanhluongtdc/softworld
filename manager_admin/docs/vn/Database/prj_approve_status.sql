-- Project Name : iwaki
-- Date/Time    : 2016-04-20 2:45:06 PM
-- Author       : iwaki
-- RDBMS Type   : MySQL
-- Application  : A5:SQL Mk-2

-- 承認状況
drop table if exists prj_approve_status cascade;

create table prj_approve_status (
  prj_id INT(11) not null comment '案件ID'
  , staff_id INT(11) not null comment '社員ID	 承認者ID'
  , approve_date DATETIME comment '承認日付'
  , approve_sts INT(2) comment '承認状況'
  , deleted_flag INT(1) default 0 comment '削除フラグ'
  , created_user INT(11) not null comment '初回登録者'
  , created_time DATETIME not null comment '初回登録日時'
  , updated_user INT(11) comment '最終更新者'
  , updated_time DATETIME comment '最終更新日時'
  , constraint prj_approve_status_PKC primary key (prj_id,staff_id)
) comment '承認状況	 承認状況' ;

