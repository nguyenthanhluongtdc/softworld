-- Project Name : iwaki
-- Date/Time    : 2016-04-28 5:18:08 PM
-- Author       : iwaki
-- RDBMS Type   : MySQL
-- Application  : A5:SQL Mk-2

-- �Č��X�V����
drop table if exists prj_update_history cascade;

create table prj_update_history (
  id INT(11) not null AUTO_INCREMENT comment 'ID	 ����ID'
  , prj_id INT(11) not null comment '�Č�ID'
  , upd_date_time datetime not null comment '�X�V���t'
  , upd_item_id INT(2) not null comment '����ID'
  , upd_item_before VARCHAR(5000) comment '�X�V�O'
  , upd_item_after VARCHAR(5000) comment '�X�V��'
  , upd_sts INT(2) comment '�X�V��	 0: �X�V�Ȃ��A1�F�X�V����'
  , upd_by INT(11) comment '�X�V��'
  , deleted_flag INT(1) default 0 comment '�폜�t���O'
  , created_user INT(11) not null comment '����o�^��'
  , created_time DATETIME not null comment '����o�^����'
  , updated_user INT(11) comment '�ŏI�X�V��'
  , updated_time DATETIME comment '�ŏI�X�V����'
  , constraint prj_update_history_PKC primary key (id)
) comment '�Č��X�V����	 �Č��X�V����' ;

