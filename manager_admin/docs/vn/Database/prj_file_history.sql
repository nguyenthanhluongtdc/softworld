-- Project Name : iwaki
-- Date/Time    : 2016-03-18 6:53:27 PM
-- Author       : iwaki
-- RDBMS Type   : MySQL
-- Application  : A5:SQL Mk-2

-- ���ޗ���
drop table if exists prj_file_history cascade;

create table prj_file_history (
  id INT(11) not null AUTO_INCREMENT comment 'ID'
  , prj_id INT(11) comment '�Č�ID'
  , prj_file_type INT(2) comment '���ދ敪	 1: �e�폑�ޗ���, 2:���ϗ���'
  , prj_file_shubetsu INT(2) comment '�e�폑�ޗ������'
  , prj_file_uploaded_date DATETIME default current_timestamp comment '�A�b�v���[�h��'
  , prj_file_uploaded_staff INT(11) comment '�A�b�v���[�h��'
  , prj_file_file_name VARCHAR(500) comment '�t�@�C����	 Display file name'
  , prj_file_file_path VARCHAR(500) comment '�t�@�C���p�X	 Name that store on disk'
  , deleted_flag INT(1) default 0 comment '�폜�t���O'
  , created_user INT(11) not null comment '����o�^��'
  , created_time DATETIME default current_timestamp not null comment '����o�^����'
  , updated_user INT(11) comment '�ŏI�X�V��'
  , updated_time DATETIME comment '�ŏI�X�V����'
  , constraint prj_file_history_PKC primary key (id)
) comment '���ޗ���	 ���ޗ���' ;

