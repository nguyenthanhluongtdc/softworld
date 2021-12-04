-- Project Name : iwaki
-- Date/Time    : 2016-04-11 7:15:26 PM
-- Author       : iwaki
-- RDBMS Type   : MySQL
-- Application  : A5:SQL Mk-2

-- ���ޓ����F
drop table if exists prj_shurui_appr_mgt cascade;

create table prj_shurui_appr_mgt (
  prj_id INT(11) not null comment '�Č�ID'
  , prj_shurui_sort INT(2) not null comment '���ޓ��敪	 1~6'
  , prj_pic_approve_sts INT(2) comment '�S���ҏ��F��	 0: �����F�A1:�Ϗ��F'
  , prj_pic_approve_id INT(11) comment '�S��ID	 ���F��ID'
  , prj_pic_approve_date DATETIME comment '�S���ҏ��F���t'
  , prj_sup_approve_sts INT(2) comment '���F�ҏ��F��'
  , prj_sup_approve_id INT(11) comment '���F��ID'
  , prj_sup_approve_date DATETIME comment '���F�ҏ��F���t'
  , deleted_flag INT(1) default 0 comment '�폜�t���O'
  , created_user INT(11) not null comment '����o�^��'
  , created_time DATETIME not null comment '����o�^����'
  , updated_user INT(11) comment '�ŏI�X�V��'
  , updated_time DATETIME comment '�ŏI�X�V����'
  , constraint prj_shurui_appr_mgt_PKC primary key (prj_id,prj_shurui_sort)
) comment '���ޓ����F	 ���ޓ����F' ;

