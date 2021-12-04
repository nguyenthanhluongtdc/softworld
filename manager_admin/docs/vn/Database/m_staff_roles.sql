-- Project Name : iwaki
-- Date/Time    : 2016-03-08 4:34:31 PM
-- Author       : iwaki
-- RDBMS Type   : MySQL
-- Application  : A5:SQL Mk-2

-- �Ј�����
drop table if exists m_staff_roles cascade;

create table m_staff_roles (
  staff_id INT(11) not null comment '�Ј�ID'
  , role_id INT(1) not null comment '����ID'
  , deleted_flag INT(1) default 0 comment '�폜�t���O'
  , created_user INT(11) not null comment '����o�^��'
  , created_time DATETIME default current_timestamp not null comment '����o�^����'
  , updated_user INT(11) comment '�ŏI�X�V��'
  , updated_time DATETIME comment '�ŏI�X�V����'
  , constraint m_staff_roles_PKC primary key (staff_id,role_id)
) comment '�Ј�����' ;

