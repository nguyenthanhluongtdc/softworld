-- Project Name : iwaki
-- Date/Time    : 2016-03-08 4:34:31 PM
-- Author       : iwaki
-- RDBMS Type   : MySQL
-- Application  : A5:SQL Mk-2

-- 社員権限
drop table if exists m_staff_roles cascade;

create table m_staff_roles (
  staff_id INT(11) not null comment '社員ID'
  , role_id INT(1) not null comment '権限ID'
  , deleted_flag INT(1) default 0 comment '削除フラグ'
  , created_user INT(11) not null comment '初回登録者'
  , created_time DATETIME default current_timestamp not null comment '初回登録日時'
  , updated_user INT(11) comment '最終更新者'
  , updated_time DATETIME comment '最終更新日時'
  , constraint m_staff_roles_PKC primary key (staff_id,role_id)
) comment '社員権限' ;

