<?php
ini_set("display_errors", "On");
error_reporting(0);

require_once './config/conf.inc';

//if($GLOBALS['GET']['req']){
//    $path = "../";
//}else{
    $path = "./";

//}
//データベース接続
//$Database = new Database();

//require_once REQUIRE_PATH . '/attes.inc';

//ログインチェック
//attes_class::attes_pc();


require_once REQUIRE_PATH . '/default_admin_class.inc';

//HTML書き出し
	$js = false;//ここでは何も与えない



if(!$_GET['nh']){
    $js = false;//関数を使って読み込み
	template_admin::header($title,$js,$path);
}
        if(!$_GET['nh']){
	template_admin::top_html($path);

	template_admin::left_html($path);

        }
//コントローラー実行
$contr = new default_controller(REQUIRE_PATH . "/page_class","");


if(!$_GET['nf']){
	template_admin::footer();
}



