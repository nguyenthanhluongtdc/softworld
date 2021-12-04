/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50617
Source Host           : localhost:3306
Source Database       : seiyo

Target Server Type    : MYSQL
Target Server Version : 50617
File Encoding         : 65001

Date: 2016-02-29 13:56:45
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `m_user`
-- ----------------------------
DROP TABLE IF EXISTS `m_user`;
CREATE TABLE `m_user` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '管理者コード',
  `user_login_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT '管理者ID	 管理者ログイン名',
  `user_name` varchar(250) COLLATE utf8_unicode_ci NOT NULL COMMENT '管理者名',
  `user_note` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '備考	 メモ',
  `user_password` varchar(128) COLLATE utf8_unicode_ci NOT NULL COMMENT 'パスワード	 MD5パスワード',
  `user_role` int(1) NOT NULL COMMENT '権限	 0: ユーザー権限, 1:管理者権限',
  `user_last_login` datetime DEFAULT NULL COMMENT '最後ログイン',
  `deleted_flag` int(1) DEFAULT '0' COMMENT '削除フラグ	 0:削除なし、1：削除する',
  `created_user` int(11) NOT NULL COMMENT '初回登録者',
  `created_time` datetime NOT NULL COMMENT '初回登録日時',
  `updated_user` int(11) DEFAULT NULL COMMENT '最終更新者',
  `updated_time` datetime DEFAULT NULL COMMENT '最終更新日時',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_login_name` (`user_login_name`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='管理者テーブル	 システムユーザ管理テーブル';

-- ----------------------------
-- Records of m_user
-- ----------------------------
INSERT INTO `m_user` VALUES ('1', 'admin', 'admin', null, 'e10adc3949ba59abbe56e057f20f883e', '1', '2016-02-29 05:49:31', '0', '0', '0000-00-00 00:00:00', '1', '2016-02-29 05:49:31');
