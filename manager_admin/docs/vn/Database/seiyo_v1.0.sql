-- Project Name : iwaki
-- Date/Time    : 2016-02-29 2:08:22 PM
-- Author       : iwaki
-- RDBMS Type   : MySQL
-- Application  : A5:SQL Mk-2

-- ���Ə��Ǘ��e�[�u��
drop table if exists m_office_info cascade;

create table m_office_info (
  office_id INT(11) not null AUTO_INCREMENT comment '���Ə�ID'
  , office_name VARCHAR(200) not null comment '���Ə���	 ���Ə���'
  , office_name_kana VARCHAR(200) comment '�Ј����J�i'
  , office_pos_code VARCHAR(8) not null comment '�X�֔ԍ�	 XXX-YYYY'
  , office_prefectures INT not null comment '�s���{��'
  , office_city VARCHAR(250) comment '�s�撬��'
  , office_address VARCHAR(500) comment '�Ԓn'
  , office_mansion_info VARCHAR(250) comment '�}���V����/�r������	 �}���V����/�r������'
  , office_phone_num VARCHAR(13) not null comment '�d�b�ԍ�'
  , office_fax VARCHAR(13) comment 'FAX�ԍ�'
  , office_email VARCHAR(100) comment '���[���A�h���X'
  , office_memo VARCHAR(2000) comment '���̑����l	 ���̑����l'
  , deleted_flag INT(1) default 0 comment '�폜�t���O	 0:�폜�Ȃ��A1�F�폜����'
  , created_user INT(11) not null comment '����o�^��'
  , created_time DATETIME not null comment '����o�^����'
  , updated_user INT(11) comment '�ŏI�X�V��'
  , updated_time DATETIME comment '�ŏI�X�V����'
  , constraint m_office_info_PKC primary key (office_id)
) comment '���Ə��Ǘ��e�[�u��	 ���Ə��Ǘ��e�[�u��' ;

-- �Ј��Ǘ��e�[�u��
drop table if exists m_staff cascade;

create table m_staff (
  staff_id INT(11) not null AUTO_INCREMENT comment '�Ј��R�[�h'
  , staff_name VARCHAR(100) not null comment '�Ј���	 �Ј���'
  , staff_name_kana VARCHAR(100) comment '�Ј����J�i'
  , staff_office_id INT(11) not null comment '���Ə���	 ���Ə��Ǘ��Q�l'
  , staff_department_id INT(11) not null comment '����	 default_array����擾'
  , staff_password VARCHAR(128) not null comment '�p�X���[�h	 MD5�p�X���[�h'
  , staff_role INT(2) not null comment '����	 default_array����擾'
  , staff_pos_code VARCHAR(8) not null comment '�X�֔ԍ�	 XXX-YYYY'
  , staff_prefectures INT not null comment '�s���{��'
  , staff_city VARCHAR(250) comment '�s�撬��'
  , staff_address VARCHAR(500) comment '�Ԓn'
  , staff_mansion_info VARCHAR(250) comment '�}���V����/�r������	 �}���V����/�r������'
  , staff_phone_num VARCHAR(13) not null comment '�d�b�ԍ�'
  , staff_email VARCHAR(100) not null comment '���[���A�h���X'
  , staff_supervisor INT(11) comment '����w��	 ����w��'
  , staff_is_notify_mail INT(1) comment '�Č��ύX���[��	 �S�Ă̈Č��̕ύX���[�����󂯎��'
  , staff_memo VARCHAR(2000) comment '���̑����l	 ���̑����l'
  , deleted_flag INT(1) default 0 comment '�폜�t���O	 0:�폜�Ȃ��A1�F�폜����'
  , created_user INT(11) not null comment '����o�^��'
  , created_time DATETIME not null comment '����o�^����'
  , updated_user INT(11) comment '�ŏI�X�V��'
  , updated_time DATETIME comment '�ŏI�X�V����'
  , constraint m_staff_PKC primary key (staff_id)
) comment '�Ј��Ǘ��e�[�u��	 �V�X�e�����[�U�Ǘ��e�[�u��' ;

