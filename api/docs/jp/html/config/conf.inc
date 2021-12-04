<?php

if ($_GET['ob']) {
    ob_start();
}
    define("DEMO_MODE", true);

mb_regex_encoding("UTF-8");
//ini_set( 'display_errors', 1 );
if (strstr(__FILE__, ":\\")) { //ローカルなら

    define("MAIN_DIR", "seiyou.dev");
    define("ROOT_PATH", "C:/xampp/htdocs/www/jav/ADN02/seiyo/docs/jp/html/" . MAIN_DIR);

    define("DOMAIN", "http://localhost/" . MAIN_DIR . "/");
    define("DOMAIN_SSL", "https://localhost/" . MAIN_DIR . "/");


    define("COOKIE_PATH", "/");
    define("DB_USER", "root");
    define("DB_HOST", "localhost");
    define("DB_PASS", "");


//    define("DB_SELE", "fukushi_test");
//    define("DB_SELE", "20151106test_seijukai");
    define("DB_SELE", "seiyo");

} else { //サーバーなら

    define("MAIN_DIR", "seiyo");
    define("ROOT_PATH", "/home/softworl/public_html/".MAIN_DIR);

    define("DOMAIN", "http://" . MAIN_DIR . "/");
    define("DOMAIN_SSL", "http://" . MAIN_DIR . "/");

    define("COOKIE_PATH", "/");

    define("DB_USER", "");
    define("DB_HOST", "localhost");
    define("DB_PASS", "");
}

//共通パス設定
define("REQUIRE_PATH", ROOT_PATH . "/class");
define("REQUIRE_PAGECLASS_PATH", ROOT_PATH . "/class/page_class");
define("STORAGE_PATH", ROOT_PATH . "/storage");
define("BACK_DIR", ROOT_PATH . "/backup");

//ログイン日数
define("LOGIN_DAY", 1);
define("SITE_TITLE", "案件管理システム");

define("ADMIN_MAIL", "morita@mshiba-system.com");
define("ADMIN_MAIL_NAME", "案件管理システム");

define("SEARCH_FORM_LINK_DEFAULT", "+ 開く");
define("SEARCH_FORM_LINK_DEFAULT_CLOSE", "+ 閉じる");
//radio_button_write_usekey での特殊処理用文字
define(FORM_SPECIAL_PROCESS, "@@@");
$admin_mail_name = mb_convert_encoding(ADMIN_MAIL_NAME, "ISO-2022-JP", "EUC-JP");
$mail_name = mb_encode_mimeheader($admin_mail_name) . "<" . ADMIN_MAIL . ">";
$GLOBALS['AdminMailHeader'] = <<<END
From:{$mail_name}
END;



//ファイル呼び出し
require_once REQUIRE_PATH . '/template.inc';
require_once dirname(__FILE__) . '/default_array.inc';
require_once REQUIRE_PATH . '/common_class.inc';
require_once REQUIRE_PATH . '/sql2.inc';
require_once REQUIRE_PATH . '/sql3.inc';
require_once REQUIRE_PATH . '/database.inc';
require_once REQUIRE_PATH . '/session.inc';
require_once REQUIRE_PATH . '/default_controller.inc';

//サニタイズ処理
$GLOBALS['GET'] = sanitize_class::sanitize_array($_GET);
$GLOBALS['POST'] = sanitize_class::sanitize_array($_POST);


