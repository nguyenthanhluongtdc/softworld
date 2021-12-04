-- Project Name : iwaki
-- Date/Time    : 2016-04-20 4:46:39 PM
-- Author       : iwaki
-- RDBMS Type   : MySQL
-- Application  : A5:SQL Mk-2

-- �l�ʂ̌�������
drop table if exists staff_monthly_comission cascade;

create table staff_monthly_comission (
  staff_id INT(11) not null comment '�Ј�ID'
  , comm_year_month VARCHAR(6) not null comment '�N��'
  , commission_amount INT(12) comment '�������z'
  , list_prj VARCHAR(500) comment '�Č����X�g	 1,2,3,10...'
  , deleted_flag INT(1) default 0 comment '�폜�t���O'
  , created_user INT(11) not null comment '����o�^��'
  , created_time DATETIME not null comment '����o�^����'
  , updated_user INT(11) comment '�ŏI�X�V��'
  , updated_time DATETIME comment '�ŏI�X�V����'
  , constraint staff_monthly_comission_PKC primary key (staff_id,comm_year_month)
) comment '�l�ʂ̌�������	 �l�ʂ̌�������' ;

