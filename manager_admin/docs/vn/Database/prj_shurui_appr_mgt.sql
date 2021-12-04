-- Project Name : iwaki
-- Date/Time    : 2016-04-11 7:15:26 PM
-- Author       : iwaki
-- RDBMS Type   : MySQL
-- Application  : A5:SQL Mk-2

-- 書類等承認
drop table if exists prj_shurui_appr_mgt cascade;

create table prj_shurui_appr_mgt (
  prj_id INT(11) not null comment '案件ID'
  , prj_shurui_sort INT(2) not null comment '書類等区分	 1~6'
  , prj_pic_approve_sts INT(2) comment '担当者承認状況	 0: 未承認、1:済承認'
  , prj_pic_approve_id INT(11) comment '担当ID	 承認者ID'
  , prj_pic_approve_date DATETIME comment '担当者承認日付'
  , prj_sup_approve_sts INT(2) comment '承認者承認状況'
  , prj_sup_approve_id INT(11) comment '承認者ID'
  , prj_sup_approve_date DATETIME comment '承認者承認日付'
  , deleted_flag INT(1) default 0 comment '削除フラグ'
  , created_user INT(11) not null comment '初回登録者'
  , created_time DATETIME not null comment '初回登録日時'
  , updated_user INT(11) comment '最終更新者'
  , updated_time DATETIME comment '最終更新日時'
  , constraint prj_shurui_appr_mgt_PKC primary key (prj_id,prj_shurui_sort)
) comment '書類等承認	 書類等承認' ;

