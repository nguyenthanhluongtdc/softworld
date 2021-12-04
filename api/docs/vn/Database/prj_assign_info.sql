-- Project Name : iwaki
-- Date/Time    : 2016-03-21 4:37:35 PM
-- Author       : iwaki
-- RDBMS Type   : MySQL
-- Application  : A5:SQL Mk-2

-- �Č��S����
drop table if exists prj_assign_info cascade;

create table prj_assign_info (
  id INT(11) not null AUTO_INCREMENT comment 'ID'
  , prj_id INT(11) comment '�Č�ID'
  , prj_role_grp INT(2) comment '�S�����	 1:�S���c��, 2:�N���[�U�[, 3:�Љ��'
  , prj_staff_pos INT(2) comment '�S������	 1�`10'
  , prj_staff_id INT(11) comment '�S��ID'
  , deleted_flag INT(1) default 0 comment '�폜�t���O'
  , created_user INT(11) not null comment '����o�^��'
  , created_time DATETIME default current_timestamp not null comment '����o�^����'
  , updated_user INT(11) comment '�ŏI�X�V��'
  , updated_time DATETIME comment '�ŏI�X�V����'
  , constraint prj_assign_info_PKC primary key (id)
) comment '�Č��S����	 �Č��S����' ;

