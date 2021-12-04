-- Project Name : iwaki
-- Date/Time    : 2016-04-11 8:05:55 PM
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

-- �i�����
drop table if exists prj_progress_info cascade;

create table prj_progress_info (
  prj_id INT(11) not null comment '�Č�ID'
  , prj_prg_eq_accre_id VARCHAR(250) comment '�ݔ��F��ID'
  , prj_prg_cust_login_id VARCHAR(250) comment '���q�l���O�C��ID'
  , prj_prg_cust_login_passw VARCHAR(250) comment '���q�l���O�C���p�X���[�h'
  , prj_prg_tepco_num1 VARCHAR(10) comment '�����d�͐\���ԍ�'
  , prj_prg_tepco_num2 VARCHAR(10) comment '�����d�͐\���ԍ�2'
  , prj_prg_update_date DATETIME comment '�X�V��'
  , prj_prg_module VARCHAR(250) comment '���W���[��'
  , prj_prg_module_num VARCHAR(250) comment '���W���[������'
  , prj_prg_pcs1 VARCHAR(250) comment 'PCS1'
  , prj_prg_pcs1_num VARCHAR(250)  comment 'PCS1�䐔'
  , prj_prg_pcs2 VARCHAR(250) comment 'PCS2'
  , prj_prg_pcs2_num VARCHAR(250) comment 'PCS2�䐔'
  , prj_prg_sum_exp VARCHAR(250) comment '���v�o��'
  , prj_prg_appl_out VARCHAR(250) comment '�\���o��'
  , prj_prg_eq_cer_appl_date DATE comment '�ݔ��F��\����'
  , prj_prg_el_recept_recv_date DATE comment '�d�͎󋋎�t��'
  , prj_prg_eq_acc_res_date DATE comment '�ݔ��F��񓚓�'
  , prj_prg_cons_grant_cal_date DATE comment '�H�����S���Z�o��'
  , prj_prg_cons_grant VARCHAR(250) comment '�H�����S��'
  , prj_prg_cons_grant_pay_date DATE comment '�H�����S���x����'
  , prj_prg_meter_fee VARCHAR(250) comment '���[�^�[��'
  , prj_prg_conn_cons_appl_date DATE comment '�ڑ������\����'
  , prj_prg_eq_acc_res_date2 DATE comment '�ݔ��F��񓚓�'
  , prj_prg_conn_cons_res_date DATE comment '�ڑ������񓚓�'
  , prj_prg_eq_cer_req VARCHAR(250) comment '�ݔ��F������t��'
  , prj_prg_appl_date DATE comment '�{�\���ݓ�'
  , prj_prg_elec_use_appl_date DATE comment '�d�C�g�p�\����'
  , prj_prg_cons_amount VARCHAR(250) comment '�H�����S���z'
  , prj_prg_tokyo_supply_demand DATE comment '�����d�͓d�͎���'
  , prj_prg_cons_grant_pay_date2 DATE comment '�H�����S���x������'
  , prj_prg_coop_pros VARCHAR(250) comment '�A�g������'
  , prj_prg_note VARCHAR(250) comment '������'
  , prj_prg_remark VARCHAR(5000) comment '���l��'
  , deleted_flag INT(1) default 0 comment '�폜�t���O'
  , created_user INT(11) not null comment '����o�^��'
  , created_time DATETIME not null comment '����o�^����'
  , updated_user INT(11) comment '�ŏI�X�V��'
  , updated_time DATETIME comment '�ŏI�X�V����'
  , constraint prj_progress_info_PKC primary key (prj_id)
) comment '�i�����' ;

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
  , created_time DATETIME not null comment '����o�^����'
  , updated_user INT(11) comment '�ŏI�X�V��'
  , updated_time DATETIME comment '�ŏI�X�V����'
  , constraint prj_assign_info_PKC primary key (id)
) comment '�Č��S����	 �Č��S����' ;

-- �Č��x�����ڍ�
drop table if exists prj_payment_info cascade;

create table prj_payment_info (
  id INT(11) not null AUTO_INCREMENT comment 'ID'
  , prj_id INT(11) comment '�Č�ID'
  , sort_id INT(1) comment '����ID	 0~5'
  , prj_billing_date DATE comment '������'
  , prj_plan_pay_day INT(3) comment '�x�����\���'
  , prj_paid_date DATE comment '�x���ϓ�'
  , prj_plan_pay_amount INT(11) comment '�x���\����z'
  , prj_plan_pay_per INT(3) comment '�x���\����z%'
  , prj_plan_pay_deposit INT(1) comment '�x���\����z����	 0: �`�F�b�N���Ȃ��A1�F�`�F�b�N����'
  , prj_plan_pay_memo VARCHAR(250) comment '�x���\����z����'
  , prj_plan_paid_amount INT(11) comment '�x���ϋ��z'
  , prj_plan_paid_memo VARCHAR(250) comment '�x���σ���'
  , deleted_flag INT(1) default 0 comment '�폜�t���O'
  , created_user INT(11) not null comment '����o�^��'
  , created_time DATETIME default current_timestamp not null comment '����o�^����'
  , updated_user INT(11) comment '�ŏI�X�V��'
  , updated_time DATETIME comment '�ŏI�X�V����'
  , constraint prj_payment_info_PKC primary key (id)
) comment '�Č��x�����ڍ�	 �Č��x�����ڍ�' ;

-- �Č����i���
drop table if exists prj_prod_info cascade;

create table prj_prod_info (
  id INT(11) not null AUTO_INCREMENT comment 'ID'
  , prj_id INT(11) comment '�Č�ID'
  , sort_id INT(1) comment '����ID'
  , prj_prod_class INT(2) comment '���i����'
  , prj_prod_class_nm VARCHAR(250) comment '���i���ޖ�'
  , prj_prod_type INT(1) comment '���i�敪'
  , prj_prod_maker INT(3) comment '���i���[�J�['
  , prj_prod_model VARCHAR(250) comment '���i�^��'
  , prj_prod_num INT(4) comment '���i��'
  , prj_prod_unit_price_selling INT(11) comment '���i�̔��P��'
  , prj_prod_price_selling INT(11) comment '�̔����z'
  , prj_prod_unit_price_part INT(11) comment '�d�ؒP��'
  , prj_prod_price_part INT(11) comment '�d�؂���z'
  , prj_prod_kw INT(11) comment 'Kw'
  , prj_prod_memo VARCHAR(5000) comment '���l'
  , deleted_flag INT(1) default 0 comment '�폜�t���O'
  , created_user INT(11) not null comment '����o�^��'
  , created_time DATETIME not null comment '����o�^����'
  , updated_user INT(11) comment '�ŏI�X�V��'
  , updated_time DATETIME comment '�ŏI�X�V����'
  , constraint prj_prod_info_PKC primary key (id)
) comment '�Č����i���	 �Č����i���' ;

-- ���ޗ���
drop table if exists prj_file_history cascade;

create table prj_file_history (
  id INT(11) not null AUTO_INCREMENT comment 'ID'
  , prj_id INT(11) comment '�Č�ID'
  , prj_file_type INT(2) comment '���ދ敪	 1: �e�폑�ޗ���, 2:���ϗ���'
  , prj_file_shubetsu INT(2) comment '�e�폑�ޗ������'
  , prj_file_uploaded_date DATETIME comment '�A�b�v���[�h��'
  , prj_file_uploaded_staff INT(11) comment '�A�b�v���[�h��'
  , prj_file_file_name VARCHAR(500) comment '�t�@�C����	 Display file name'
  , prj_file_file_path VARCHAR(500) comment '�t�@�C���p�X	 Name that store on disk'
  , deleted_flag INT(1) default 0 comment '�폜�t���O'
  , created_user INT(11) not null comment '����o�^��'
  , created_time DATETIME not null comment '����o�^����'
  , updated_user INT(11) comment '�ŏI�X�V��'
  , updated_time DATETIME comment '�ŏI�X�V����'
  , constraint prj_file_history_PKC primary key (id)
) comment '���ޗ���	 ���ޗ���' ;

-- �Č��X�e�[�^�X����
drop table if exists prj_status_history cascade;

create table prj_status_history (
  id INT(11) not null AUTO_INCREMENT comment 'ID'
  , prj_id INT(11) comment '�Č�ID'
  , prj_status INT(2) comment '�Č��X�e�[�^�XID'
  , prj_status_updated_date DATETIME comment '�X�V���t'
  , deleted_flag INT(1) default 0 comment '�폜�t���O'
  , created_user INT(11) not null comment '����o�^��'
  , created_time DATETIME default current_timestamp not null comment '����o�^����'
  , updated_user INT(11) comment '�ŏI�X�V��'
  , updated_time DATETIME comment '�ŏI�X�V����'
  , constraint prj_status_history_PKC primary key (id)
) comment '�Č��X�e�[�^�X����	 �Č��X�e�[�^�X����' ;

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
  , prj_cust_memo text comment '���̑����l	 ���̑����l'
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
  , prj_prod_checklist text comment '���i���m�F����	 ���i���'
  , prj_prod_notices text comment '���i�����L����	 ���i���'
  , prj_pay_method INT(1) comment '�x�������@	 1:����   2:����  3:�N���W�b�g'
  , prj_pay_remain INT(11) comment '���[���z	 �������z���v - �x�����ς݋��z���v'
  , prj_pay_completed_date DATE comment '�x�������[��'
  , prj_comm_partition_amount INT(11) comment '�d�؋��z	 �S���c�Ǝd�؋��z'
  , prj_comm_income_amount INT(11) comment '���v�z'
  , prj_comm_close_date_mgr VARCHAR(6) comment '�S���c�ƕ�������	 YYYYMM'
  , prj_comm_amount_mgr INT(11) comment '�S���c�ƕ���'
  , prj_comm_close_date_closer VARCHAR(6) comment '�N���[�U�[��������	 YYYYMM'
  , prj_comm_amount_closer INT(11) comment '�N���[�U�[����'
  , prj_comm_close_date_introducer VARCHAR(6) comment '�Љ�ҕ�������	 YYYYMM'
  , prj_comm_amount_introducer INT(11) comment '�Љ�ҕ���'
  , prj_comm_memo text comment '��������'
  , prj_shurui_appr_memo text comment '���ޓ����F����'
  , deleted_flag INT(1) default 0 comment '�폜�t���O	 0:�폜�Ȃ��A1�F�폜����'
  , created_user INT(11) not null comment '����o�^��'
  , created_time DATETIME not null comment '����o�^����'
  , updated_user INT(11) comment '�ŏI�X�V��'
  , updated_time DATETIME comment '�ŏI�X�V����'
  , constraint prj_info_PKC primary key (prj_id)
) comment '�Č����	 �Č����e�[�u��' ;

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
  , office_fax_num VARCHAR(13) comment 'FAX�ԍ�'
  , office_email VARCHAR(100) not null comment '���[���A�h���X'
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

