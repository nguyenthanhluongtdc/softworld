-- Project Name : iwaki
-- Date/Time    : 2016-04-27 6:48:37 PM
-- Author       : iwaki
-- RDBMS Type   : MySQL
-- Application  : A5:SQL Mk-2

-- �Č��S���ҕ���
drop table if exists prj_staff_comission cascade;

create table prj_staff_comission (
  id INT(11) not null AUTO_INCREMENT comment 'ID'
  , prj_id INT(11) not null comment '�Č�ID'
  , staff_id INT(11) not null comment '�Ј�ID'
  , staff_group INT(1) not null comment '�S�����	 1:�S���c��,2:�N���[�U�[,3:�Љ��'
  , commission_year_month VARCHAR(6) not null comment '�N��'
  , commission_amount INT(12) comment '�������z'
  , deleted_flag INT(1) default 0 comment '�폜�t���O'
  , created_user INT(11) not null comment '����o�^��'
  , created_time DATETIME not null comment '����o�^����'
  , updated_user INT(11) comment '�ŏI�X�V��'
  , updated_time DATETIME comment '�ŏI�X�V����'
  , constraint prj_staff_comission_PKC primary key (id)
) comment '�Č��S���ҕ���	 �Č��S���ҕ���' ;

