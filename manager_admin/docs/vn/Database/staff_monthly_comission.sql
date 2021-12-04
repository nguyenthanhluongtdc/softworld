-- Project Name : iwaki
-- Date/Time    : 2016-04-20 4:46:39 PM
-- Author       : iwaki
-- RDBMS Type   : MySQL
-- Application  : A5:SQL Mk-2

-- 個人別の月次歩合
drop table if exists staff_monthly_comission cascade;

create table staff_monthly_comission (
  staff_id INT(11) not null comment '社員ID'
  , comm_year_month VARCHAR(6) not null comment '年月'
  , commission_amount INT(12) comment '歩合金額'
  , list_prj VARCHAR(500) comment '案件リスト	 1,2,3,10...'
  , deleted_flag INT(1) default 0 comment '削除フラグ'
  , created_user INT(11) not null comment '初回登録者'
  , created_time DATETIME not null comment '初回登録日時'
  , updated_user INT(11) comment '最終更新者'
  , updated_time DATETIME comment '最終更新日時'
  , constraint staff_monthly_comission_PKC primary key (staff_id,comm_year_month)
) comment '個人別の月次歩合	 個人別の月次歩合' ;

