-- Project Name : iwaki
-- Date/Time    : 2016-04-09 11:09:25 AM
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
  , prj_cust_memo VARCHAR(5000) comment '���̑����l	 ���̑����l'
  , prj_kind_contract INT(2) comment '��ʌ_����	 �����E�e�헚���E���[���'
  , prj_kind_garage INT(2) comment '��ʎԌ�	 �����E�e�헚���E���[���'
  , prj_kind_pv VARCHAR(250) comment '���PV	 Comma separated(A,B,C..)'
  , prj_kind_od VARCHAR(250) comment '���OD	 Comma separated(A,B,C..)'
  , prj_gencho_bi DATE comment '������	 �����E�e�헚���E���[���'
  , prj_keiyaku_bi DATE comment '�_���	 �����E�e�헚���E���[���'
  , prj_koji_kaishi_bi DATE comment '�H���J�n��	 �����E�e�헚���E���[���'
  , prj_setsubi_nintei_shinsei_bi1 DATE comment '�ݔ��F�� �\����1	 �����E�e�헚���E���[���'
  , prj_setsubi_nintei_shinsei_bi2 DATE comment '�ݔ��F�� �\����2	 �����E�e�헚���E���[���'
  , prj_setsubi_nintei_shinsei_bi3 DATE comment '�ݔ��F�� �\����3	 �����E�e�헚���E���[���'
  , prj_uchi_ochi_yotei_bi DATE comment '�����\���	 �����E�e�헚���E���[���'
  , prj_uchi_ochi_kakutei_bi DATE comment '�����m���	 �����E�e�헚���E���[���'
  , prj_renkei_bi DATE comment '�A�n��	 �����E�e�헚���E���[���'
  , prj_renkei_done INT(1) comment '�c�ƈ��A����	 �����E�e�헚���E���[���'
  , prj_kanko_bi DATE comment '���H��	 �����E�e�헚���E���[���'
  , prj_setchi_hiyo_nenpo_shinsei_bi DATE comment '�ݒu��p�N��\����	 �����E�e�헚���E���[���'
  , prj_unten_hiyo_nenpo_shinsei_bi DATE comment '�^�]��p�N��\����	 �����E�e�헚���E���[���'
  , prj_kyanceru_bi DATE comment '�L�����Z����	 �����E�e�헚���E���[���'
  , prj_prod_price_selling_total INT(11) comment '���i�̔����z���v	 ���i���'
  , prj_prod_price_part_total INT(11) comment '���i�d�؂���z���v	 ���i���'
  , prj_prod_checklist VARCHAR(5000) comment '���i���m�F����	 ���i���'
  , prj_prod_notices VARCHAR(5000) comment '���i�����L����	 ���i���'
  , prj_pay_method INT(1) comment '�x�������@	 1:����   2:����  3:�N���W�b�g'
  , prj_pay_completed_date DATE comment '�x�������[��'
  , deleted_flag INT(1) default 0 comment '�폜�t���O	 0:�폜�Ȃ��A1�F�폜����'
  , created_user INT(11) not null comment '����o�^��'
  , created_time DATETIME not null comment '����o�^����'
  , updated_user INT(11) comment '�ŏI�X�V��'
  , updated_time DATETIME comment '�ŏI�X�V����'
  , constraint prj_info_PKC primary key (prj_id)
) comment '�Č����	 �Č����e�[�u��' ;
