-- Project Name : iwaki
-- Date/Time    : 2016-03-16 5:01:53 PM
-- Author       : iwaki
-- RDBMS Type   : MySQL
-- Application  : A5:SQL Mk-2

-- �Č����
drop table if exists prj_info cascade;

create table prj_info (
  prj_id INT(11) not null AUTO_INCREMENT comment '�Č�ID'
  , prj_status INT(2) not null comment '�Č��X�e�[�^�X	 0:���ϒ�o�A1:���_��A2:�{�_��A10:�L�����Z��'
  , prj_maker INT(3) comment '�Č����[�J�['
  , prj_cust_name VARCHAR(250) not null comment '���q�l����	 ���q�l����'
  , prj_cust_pos_code VARCHAR(8) comment '�Z���i���q�l�Z���j1	 XXX-YYYY'
  , prj_cust_prefectures INT comment '�Z���i���q�l�Z���j2'
  , prj_cust_city VARCHAR(250) comment '�Z���i���q�l�Z���j3'
  , prj_cust_address VARCHAR(250) comment '�Z���i���q�l�Z���j4'
  , prj_cust_mansion_info VARCHAR(250) comment '�Z���i���q�l�Z���j5'
  , prj_cust_ins_loc_pos_code VARCHAR(8) comment '�Z���i�ݒu�ꏊ�j1	 XXX-YYYY'
  , prj_cust_ins_loc_prefectures INT comment '�Z���i�ݒu�ꏊ�j2'
  , prj_cust_ins_loc_city VARCHAR(250) comment '�Z���i�ݒu�ꏊ�j3'
  , prj_cust_ins_loc_address VARCHAR(250) comment '�Z���i�ݒu�ꏊ�j4'
  , prj_cust_ins_loc_mansion_info VARCHAR(250) comment '�Z���i�ݒu�ꏊ�j5'
  , prj_cust_phone_num VARCHAR(13) not null comment '�d�b�ԍ�'
  , prj_cust_email VARCHAR(100) not null comment '���[���A�h���X'
  , prj_cust_memo VARCHAR(50000) comment '���̑����l	 ���̑����l'
  , deleted_flag INT(1) default 0 comment '�폜�t���O	 0:�폜�Ȃ��A1�F�폜����'
  , created_user INT(11) not null comment '����o�^��'
  , created_time DATETIME not null comment '����o�^����'
  , updated_user INT(11) comment '�ŏI�X�V��'
  , updated_time DATETIME comment '�ŏI�X�V����'
  , constraint project_info_PKC primary key (prj_id)
) comment '�Č����	 �Č����e�[�u��' ;

