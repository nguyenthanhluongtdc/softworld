-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1:3306
-- Thời gian đã tạo: Th3 09, 2021 lúc 03:18 AM
-- Phiên bản máy phục vụ: 10.4.10-MariaDB
-- Phiên bản PHP: 7.4.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `db_softworld`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `m_staff`
--

DROP TABLE IF EXISTS `m_staff`;
CREATE TABLE IF NOT EXISTS `m_staff` (
  `staff_id` int(11) NOT NULL AUTO_INCREMENT COMMENT '?Ј??R?[?h',
  `staff_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT '?Ј???	 ?Ј???',
  `staff_name_kana` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '?Ј????J?i',
  `staff_office_id` int(11) NOT NULL COMMENT '???Ə???	 ???Ə??Ǘ??Q?l',
  `staff_department_id` int(11) NOT NULL COMMENT '????	 default_array?????擾',
  `staff_password` varchar(128) COLLATE utf8_unicode_ci NOT NULL COMMENT '?p?X???[?h	 MD5?p?X???[?h',
  `staff_role` int(2) NOT NULL COMMENT '????	 default_array?????擾',
  `staff_pos_code` varchar(8) COLLATE utf8_unicode_ci NOT NULL COMMENT '?X?֔ԍ?	 XXX-YYYY',
  `staff_prefectures` int(11) NOT NULL COMMENT '?s???{??',
  `staff_city` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '?s?撬??',
  `staff_address` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '?Ԓn',
  `staff_mansion_info` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '?}???V????/?r??????	 ?}???V????/?r??????',
  `staff_phone_num` varchar(13) COLLATE utf8_unicode_ci NOT NULL COMMENT '?d?b?ԍ?',
  `staff_email` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT '???[???A?h???X',
  `staff_supervisor` int(11) DEFAULT NULL COMMENT '?????w??	 ?????w??',
  `staff_is_notify_mail` int(1) DEFAULT NULL COMMENT '?Č??ύX???[??	 ?S?Ă̈Č??̕ύX???[?????????',
  `staff_memo` varchar(2000) COLLATE utf8_unicode_ci DEFAULT NULL COMMENT '???̑????l	 ???̑????l',
  `deleted_flag` int(1) DEFAULT 0 COMMENT '?폜?t???O	 0:?폜?Ȃ??A1?F?폜????',
  `created_user` int(11) NOT NULL COMMENT '?????o?^??',
  `created_time` datetime NOT NULL COMMENT '?????o?^????',
  `updated_user` int(11) DEFAULT NULL COMMENT '?ŏI?X?V??',
  `updated_time` datetime DEFAULT NULL COMMENT '?ŏI?X?V????',
  PRIMARY KEY (`staff_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='?Ј??Ǘ??e?[?u??	 ?V?X?e?????[?U?Ǘ??e?[?u??';

--
-- Đang đổ dữ liệu cho bảng `m_staff`
--

INSERT INTO `m_staff` (`staff_id`, `staff_name`, `staff_name_kana`, `staff_office_id`, `staff_department_id`, `staff_password`, `staff_role`, `staff_pos_code`, `staff_prefectures`, `staff_city`, `staff_address`, `staff_mansion_info`, `staff_phone_num`, `staff_email`, `staff_supervisor`, `staff_is_notify_mail`, `staff_memo`, `deleted_flag`, `created_user`, `created_time`, `updated_user`, `updated_time`) VALUES
(1, 'name_admin', NULL, 1, 2, '21232f297a57a5a743894a0e4a801fc3', 3, 'example', 4, NULL, NULL, NULL, '085536888', 'admin@gmail.com', NULL, NULL, NULL, NULL, 9, '2021-03-01 00:00:00', NULL, '2021-03-02 00:00:00');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
