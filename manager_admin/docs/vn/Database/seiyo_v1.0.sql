-- Project Name : iwaki
-- Date/Time    : 2016-02-29 2:08:22 PM
-- Author       : iwaki
-- RDBMS Type   : MySQL
-- Application  : A5:SQL Mk-2

-- 事業所管理テーブル
drop table if exists m_office_info cascade;

create table m_office_info (
  office_id INT(11) not null AUTO_INCREMENT comment '事業所ID'
  , office_name VARCHAR(200) not null comment '事業所名	 事業所名'
  , office_name_kana VARCHAR(200) comment '社員名カナ'
  , office_pos_code VARCHAR(8) not null comment '郵便番号	 XXX-YYYY'
  , office_prefectures INT not null comment '都道府県'
  , office_city VARCHAR(250) comment '市区町村'
  , office_address VARCHAR(500) comment '番地'
  , office_mansion_info VARCHAR(250) comment 'マンション/ビル名等	 マンション/ビル名等'
  , office_phone_num VARCHAR(13) not null comment '電話番号'
  , office_fax VARCHAR(13) comment 'FAX番号'
  , office_email VARCHAR(100) comment 'メールアドレス'
  , office_memo VARCHAR(2000) comment 'その他備考	 その他備考'
  , deleted_flag INT(1) default 0 comment '削除フラグ	 0:削除なし、1：削除する'
  , created_user INT(11) not null comment '初回登録者'
  , created_time DATETIME not null comment '初回登録日時'
  , updated_user INT(11) comment '最終更新者'
  , updated_time DATETIME comment '最終更新日時'
  , constraint m_office_info_PKC primary key (office_id)
) comment '事業所管理テーブル	 事業所管理テーブル' ;

-- 社員管理テーブル
drop table if exists m_staff cascade;

create table m_staff (
  staff_id INT(11) not null AUTO_INCREMENT comment '社員コード'
  , staff_name VARCHAR(100) not null comment '社員名	 社員名'
  , staff_name_kana VARCHAR(100) comment '社員名カナ'
  , staff_office_id INT(11) not null comment '事業所名	 事業所管理参考'
  , staff_department_id INT(11) not null comment '部署	 default_arrayから取得'
  , staff_password VARCHAR(128) not null comment 'パスワード	 MD5パスワード'
  , staff_role INT(2) not null comment '権限	 default_arrayから取得'
  , staff_pos_code VARCHAR(8) not null comment '郵便番号	 XXX-YYYY'
  , staff_prefectures INT not null comment '都道府県'
  , staff_city VARCHAR(250) comment '市区町村'
  , staff_address VARCHAR(500) comment '番地'
  , staff_mansion_info VARCHAR(250) comment 'マンション/ビル名等	 マンション/ビル名等'
  , staff_phone_num VARCHAR(13) not null comment '電話番号'
  , staff_email VARCHAR(100) not null comment 'メールアドレス'
  , staff_supervisor INT(11) comment '上役指定	 上役指定'
  , staff_is_notify_mail INT(1) comment '案件変更メール	 全ての案件の変更メールを受け取る'
  , staff_memo VARCHAR(2000) comment 'その他備考	 その他備考'
  , deleted_flag INT(1) default 0 comment '削除フラグ	 0:削除なし、1：削除する'
  , created_user INT(11) not null comment '初回登録者'
  , created_time DATETIME not null comment '初回登録日時'
  , updated_user INT(11) comment '最終更新者'
  , updated_time DATETIME comment '最終更新日時'
  , constraint m_staff_PKC primary key (staff_id)
) comment '社員管理テーブル	 システムユーザ管理テーブル' ;

