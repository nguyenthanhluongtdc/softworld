-- Project Name : iwaki
-- Date/Time    : 2016-03-21 2:04:57 PM
-- Author       : iwaki
-- RDBMS Type   : MySQL
-- Application  : A5:SQL Mk-2

-- Äîñ
drop table if exists prj_info cascade;

create table prj_info (
  prj_id INT(11) not null AUTO_INCREMENT comment 'ÄID'
  , prj_status INT(2) not null comment 'ÄXe[^X	 0:©ÏñoA1:¼_ñA2:{_ñA10:LZ'
  , prj_maker INT(3) comment 'Ä[J['
  , prj_cust_name VARCHAR(250) not null comment '¨ql¼	 ¨ql¼'
  , prj_cust_pos_code VARCHAR(8) comment 'Zi¨qlZj1	 XXX-YYYY'
  , prj_cust_prefectures INT comment 'Zi¨qlZj2'
  , prj_cust_city VARCHAR(250) comment 'Zi¨qlZj3'
  , prj_cust_address VARCHAR(250) comment 'Zi¨qlZj4'
  , prj_cust_mansion_info VARCHAR(250) comment 'Zi¨qlZj5'
  , prj_cust_ins_loc_pos_code VARCHAR(8) comment 'ZiÝuêj1	 XXX-YYYY'
  , prj_cust_ins_loc_prefectures INT comment 'ZiÝuêj2'
  , prj_cust_ins_loc_city VARCHAR(250) comment 'ZiÝuêj3'
  , prj_cust_ins_loc_address VARCHAR(250) comment 'ZiÝuêj4'
  , prj_cust_ins_loc_mansion_info VARCHAR(250) comment 'ZiÝuêj5'
  , prj_cust_phone_num VARCHAR(13) not null comment 'dbÔ'
  , prj_cust_email VARCHAR(100) not null comment '[AhX'
  , prj_cust_memo VARCHAR(50000) comment '»Ì¼õl	 »Ì¼õl'
  , prj_kind_contract INT(2) comment 'íÊ_ñíÊ	 úöEeíðE [îñ'
  , prj_kind_garage INT(2) comment 'íÊÔÉ	 úöEeíðE [îñ'
  , prj_kind_pv VARCHAR(250) comment 'íÊPV	 Comma separated(A,B,C..)'
  , prj_kind_od VARCHAR(250) comment 'íÊOD	 Comma separated(A,B,C..)'
  , prj_gencho_bi DATE comment '»²ú	 úöEeíðE [îñ'
  , prj_keiyaku_bi DATE comment '_ñú	 úöEeíðE [îñ'
  , prj_koji_kaishi_bi DATE comment 'HJnú	 úöEeíðE [îñ'
  , prj_setsubi_nintei_shinsei_bi1 DATE comment 'ÝõFè \¿ú1	 úöEeíðE [îñ'
  , prj_setsubi_nintei_shinsei_bi2 DATE comment 'ÝõFè \¿ú2	 úöEeíðE [îñ'
  , prj_setsubi_nintei_shinsei_bi3 DATE comment 'ÝõFè \¿ú3	 úöEeíðE [îñ'
  , prj_uchi_ochi_yotei_bi DATE comment 'à\èú	 úöEeíðE [îñ'
  , prj_uchi_ochi_kakutei_bi DATE comment 'àmèú	 úöEeíðE [îñ'
  , prj_renkei_bi DATE comment 'Anú	 úöEeíðE [îñ'
  , prj_renkei_done INT(1) comment 'cÆ¶AÏ	 úöEeíðE [îñ'
  , prj_kanko_bi DATE comment '®Hú	 úöEeíðE [îñ'
  , prj_setchi_hiyo_nenpo_shinsei_bi DATE comment 'ÝuïpNñ\¿ú	 úöEeíðE [îñ'
  , prj_unten_hiyo_nenpo_shinsei_bi DATE comment '^]ïpNñ\¿ú	 úöEeíðE [îñ'
  , prj_kyanceru_bi DATE comment 'LZú	 úöEeíðE [îñ'
  , prj_prod_price_selling_total INT(11) comment '»iÌàzv	 ¤iîñ'
  , prj_prod_price_part_total INT(11) comment '»idØèàzv	 ¤iîñ'
  , prj_prod_checklist VARCHAR(50000) comment '»iîñmF	 ¤iîñ'
  , prj_prod_notices VARCHAR(50000) comment '»iîñÁL	 ¤iîñ'
  , deleted_flag INT(1) default 0 comment 'ítO	 0:íÈµA1Fí·é'
  , created_user INT(11) not null comment 'ño^Ò'
  , created_time DATETIME not null comment 'ño^ú'
  , updated_user INT(11) comment 'ÅIXVÒ'
  , updated_time DATETIME comment 'ÅIXVú'
  , constraint prj_info_PKC primary key (prj_id)
) comment 'Äîñ	 Äîñe[u' ;

