-- Project Name : iwaki
-- Date/Time    : 2016-04-20 2:45:06 PM
-- Author       : iwaki
-- RDBMS Type   : MySQL
-- Application  : A5:SQL Mk-2

-- ���F��
drop table if exists prj_approve_status cascade;

create table prj_approve_status (
  prj_id INT(11) not null comment '�Č�ID'
  , staff_id INT(11) not null comment '�Ј�ID	 ���F��ID'
  , approve_date DATETIME comment '���F���t'
  , approve_sts INT(2) comment '���F��'
  , deleted_flag INT(1) default 0 comment '�폜�t���O'
  , created_user INT(11) not null comment '����o�^��'
  , created_time DATETIME not null comment '����o�^����'
  , updated_user INT(11) comment '�ŏI�X�V��'
  , updated_time DATETIME comment '�ŏI�X�V����'
  , constraint prj_approve_status_PKC primary key (prj_id,staff_id)
) comment '���F��	 ���F��' ;

