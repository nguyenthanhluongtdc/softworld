-- Project Name : iwaki
-- Date/Time    : 2016-03-21 2:05:20 PM
-- Author       : iwaki
-- RDBMS Type   : MySQL
-- Application  : A5:SQL Mk-2

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
  , created_time DATETIME default current_timestamp not null comment '����o�^����'
  , updated_user INT(11) comment '�ŏI�X�V��'
  , updated_time DATETIME comment '�ŏI�X�V����'
  , constraint prj_prod_info_PKC primary key (id)
) comment '�Č����i���	 �Č����i���' ;

