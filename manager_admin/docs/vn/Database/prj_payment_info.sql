-- Project Name : iwaki
-- Date/Time    : 2016-03-21 4:37:11 PM
-- Author       : iwaki
-- RDBMS Type   : MySQL
-- Application  : A5:SQL Mk-2

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

