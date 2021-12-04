-- Project Name : iwaki
-- Date/Time    : 2016-03-16 5:02:21 PM
-- Author       : iwaki
-- RDBMS Type   : MySQL
-- Application  : A5:SQL Mk-2

-- �Č��X�e�[�^�X����
drop table if exists prj_status_history cascade;

create table prj_status_history (
  id INT(11) not null AUTO_INCREMENT comment 'ID'
  , prj_id INT(11) comment '�Č�ID'
  , prj_status INT(2) comment '�Č��X�e�[�^�XID'
  , prj_status_updated_date DATETIME default current_timestamp comment '�X�V���t'
  , deleted_flag INT(1) default 0 comment '�폜�t���O'
  , created_user INT(11) not null comment '����o�^��'
  , created_time DATETIME default current_timestamp not null comment '����o�^����'
  , updated_user INT(11) comment '�ŏI�X�V��'
  , updated_time DATETIME comment '�ŏI�X�V����'
  , constraint prj_status_history_PKC primary key (id)
) comment '�Č��X�e�[�^�X����	 �Č��X�e�[�^�X����' ;

