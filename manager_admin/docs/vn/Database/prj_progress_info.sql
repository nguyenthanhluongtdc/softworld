-- Project Name : iwaki
-- Date/Time    : 2016-04-06 10:04:55 AM
-- Author       : iwaki
-- RDBMS Type   : MySQL
-- Application  : A5:SQL Mk-2

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

