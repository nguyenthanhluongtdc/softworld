<?php

class template_admin
{

    static function javascript_read($path)
    {

        switch ($_GET['req']) {
            case "project_regi":

                $javahead = <<<HTML
<link rel="stylesheet" href="{$path}common/css/themes/base/jquery.ui.tabs.css" type="text/css" media="print, projection, screen">

<script src="{$path}common/js/ui.core.js" type="text/javascript"></script>
<script src="{$path}common/js/ui.tabs.min.js" type="text/javascript"></script>
<script type="text/javascript">

$(function() {
$('#ui-tab > ul').tabs({ fx: { opacity: 'toggle', duration: 'fast'  } });

});
</script>

HTML;
                break;
default:
                $javahead = <<<HTML

HTML;
                break;
        }


        return $javahead;
    }

    static function header($title = "", $js = false, $path = "./")
    {
        if ($title) {
            $SITE_TITLE = SITE_TITLE . " - " . $title;
        } else {
            $SITE_TITLE = SITE_TITLE;
        }
        if ($js){ //指定があれば
            $js_read = $js;
        } else { //指定無し（通常版・別関数で判断）
            $js_read = self::javascript_read($path);
        }

        print <<<HTML
<!DOCTYPE html>
HTML;
        ?>
        <html lang="ja">
        <head>
<meta charset="utf-8">
<title>聖陽 WEB管理システム</title>
<meta name="robots" content="noindex,nofollow">
<link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato" />
<link type="text/css" rel="stylesheet" href="<?= $path?>common/tb/css/bootstrap/bootstrap.css" />
<link type="text/css" rel="stylesheet" href="<?= $path?>common/tb/css/bootstrap/bootstrap-responsive.min.css" />
<link type="text/css" rel="stylesheet" href="<?= $path?>common/tb/css/supr-theme/jquery.ui.supr.css" />
<link type="text/css" rel="stylesheet" href="<?= $path?>common/tb/css/supr-theme/jquery.ui.datepicker.css" />
<link type="text/css" rel="stylesheet" href="<?= $path?>common/tb/css/icons.css" />
<link type="text/css" rel="stylesheet" href="<?= $path?>common/tb/plugins/misc/qtip/jquery.qtip.css" />
<link type="text/css" rel="stylesheet" href="<?= $path?>common/tb/plugins/forms/uniform/uniform.default.css" />
<link type="text/css" rel="stylesheet" href="<?= $path?>common/tb/css/main.css?cache=<?= time()?>" />
<link type="text/css" rel="stylesheet" href="<?= $path?>common/tb/css/custom.css" />
<link type="text/css" rel="stylesheet" href="<?= $path?>common/tb/css/default.css" />
            <!--[if lt IE 9]>
            <script type="text/javascript" src="https://html5shim.googlecode.com/svn/trunk/html5.js"></script>
            <![endif]-->
            <link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/apple-touch-icon-144-precomposed.png" />
<link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/apple-touch-icon-114-precomposed.png" />
<link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/apple-touch-icon-72-precomposed.png" />
<link rel="apple-touch-icon-precomposed" href="images/apple-touch-icon-57-precomposed.png" />
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script type="text/javascript" src="./common/js/admin.js?time=<?= time()?>"></script>
<script type="text/javascript" src="./common/tb/js/jquery.cookie.js"></script>
<script type="text/javascript" src="./common/js/ui/jquery.ui.datepicker.js"></script>
<script type="text/javascript" src="./common/tb/js/supr-theme/jquery-ui-1.10.1.custom.min.js"></script>
 <style type="text/css">
</style>
            <?= $js_read ?>
</head>
        <?php


    }

    static function top_html($path = "./")
    {
        ?>
        <body>
        <div id="qLoverlay"></div>
        <div id="qLbar"></div>
        <div id="header">
		<div class="navbar">
			<div class="navbar-inner">
			  <div class="container-fluid">
				<a class="brand" href="<?= $path ?>" style="font-size:28px;margin-left:-28px"><span class="slogan">聖陽 WEB管理システム</span></a>
				<div class="nav-no-collapse">
					<ul class="nav pull-right usernav">
						<li><a href=".?req=login" onclick="return window.confirm('ログアウトしますか？')"><span class="icon16 icomoon-icon-exit"></span>ログアウト</a></li>
					</ul>
				</div><!-- /.nav-collapse -->
			  </div>
			</div><!-- /navbar-inner -->
		  </div><!-- /navbar -->
	</div><!-- End #header -->
    <?php

    }


    static function left_html($path = "./"){
        ?>
        <div id="wrapper">
		<!--Responsive navigation button-->
		<div class="resBtn">
			<a href="#"><span class="icon16 minia-icon-list-3"></span></a>
		</div>
		<!--Sidebar collapse button-->
		<div class="collapseBtn leftbar">
			 <a href="#" class="tipR" title="管理メニューを隠す"><span class="icon12 minia-icon-layout"></span></a>
		</div>
		<!--Sidebar background-->
		<div id="sidebarbg"></div>
		<!--Sidebar content-->
		<div id="sidebar">
			<div class="sidenav">
				<div class="sidebar-widget" style="margin: -1px 0 0 0;">
					<h5 class="title" style="margin-bottom:0">管理メニュー</h5>
				</div><!-- End .sidenav-widget -->
				<div class="alert alert-info" style="margin:37px 5px 5px 5px;padding:2px 5px">
					システム管理者 でログイン中
				</div>
				<div class="mainnav">
					<ul>

						<li>
							<a href="#" class="hasUl"><span class="dark icon16 icomoon-icon-user-4"></span>社員管理</a>
							<ul class="sub opensub">
								<li><a href="<?= $path?>?req=staff_search"><span class="icon16 icomoon-icon-search-2 blue"></span>社員検索</a></li>
								<li><a href="<?= $path?>?req=staff_regi"><span class="icon16 icomoon-icon-file-add red"></span>社員新規登録</a></li>
                                        <li class="leftmenu_last">&nbsp;</li>
							</ul>
						</li>
						<li>
							<a href="#" class="hasUl drop"><span class="dark icon16 icomoon-icon-office"></span>事業所管理</a>
							<ul class="sub opensub" style="display:block">
								<li><a href="<?= $path?>?req=office_search"><span class="icon16 icomoon-icon-search-2 blue"></span>事業所検索<span class="notification green" id="cnt_logcontact" style="display:none">0</span></a></li>
								<li><a href="<?= $path?>?req=office_regi"><span class="icon16 icomoon-icon-file-add red"></span>事業所新規登録</a></li>
                                        <li class="leftmenu_last">&nbsp;</li>
							</ul>
						</li>

						<li>
							<a href="#" class="hasUl"><span class="dark icon16 entypo-icon-users"></span>案件管理</a>
							<ul class="sub opensub">
								<li><a href="<?= $path?>?req=project_search"><span class="icon16 icomoon-icon-search-2 blue"></span>案件検索</a></li>					<li><a href="<?= $path?>?req=project_calendar"><span class="icon16 icomoon-icon-search-2 blue"></span>スケジュール</a></li>
								<li><a href="<?= $path?>?req=project_regi"><span class="icon16 icomoon-icon-file-add red"></span>案件新規登録[画面入力]</a></li>
                                								<li><a href="<?= $path?>?req=project_import"><span class="icon16 icomoon-icon-file-add red"></span>案件新規登録[インポート]</a></li>
								<li><a href="<?= $path?>?req=payment_search"><span class="icon16 icomoon-icon-file blue"></span>入金状況検索</a></li>
                                	<li><a href="<?= $path?>?req=kanko_list"><span class="icon16 icomoon-icon-file blue"></span>定期点検リスト</a></li>
                                        <li class="leftmenu_last">&nbsp;</li>
							</ul>
						</li>
						<li style="display: none;">
							<a href="#" class="hasUl"><span class="dark icon16 icomoon-icon-file-pdf"></span>帳票管理</a>
							<ul class="sub opensub">
								<li><a href="<?= $path?>?req=order_regi"><span class="icon16 icomoon-icon-file blue"></span>発注書作成</a></li>
                                <li class="leftmenu_last">&nbsp;</li>
							</ul>
						</li>
<!--                        <li>-->
<!--							<a href="#" class="hasUl"><span class="dark icon16 icomoon-icon-bars-2"></span>集計管理</a>-->
<!--							<ul class="sub opensub">-->
<!--								<li><a href="--><?//= $path?><!--?req=total"><span class="icon16 icomoon-icon-bars blue"></span>社員別売上集計</a></li>-->
<!--        <li class="leftmenu_last">&nbsp;</li>-->
<!--							</ul>-->
<!--						</li>-->

                          <li>
							<a href="#" class="hasUl"><span class="dark icon16 icomoon-icon-bars-2"></span>歩合管理</a>
							<ul class="sub opensub">
								<li><a href="<?= $path?>?req=incentive"><span class="icon16 icomoon-icon-bars blue"></span>歩合集計</a></li>
        <li class="leftmenu_last">&nbsp;</li>
							</ul>
						</li>

								<li><a href="site_mnt.php?search=1&amp;site_no=1"><span class="icon16 icomoon-icon-exit-2 red"></span>ログアウト</a></li>
							</ul>
						</li>
					</ul>
				</div>
			</div><!-- End sidenav -->
		</div><!-- End #sidebar -->
        <?php
    }
static function auth_error()
{
    ?>
    <div id="content" class="clearfix">
    <div class="contentwrapper"><!--Content wrapper-->
    <div class="heading">
					<h3>権限エラー</h3>
    <div class="row-fluid">
    <div class="span12">
    <div class="box gradient">

ご指定の動作の権限がありません。
            <br />
            または不正なアクセスです。</div>

        <!--main--></div>
    </div>
    </div>
    <?php
    template_admin::footer();
    exit;
    //処理を強制的に中止する

}





    static function footer()
    {
        ?>
        <script type="text/javascript" src="./common/tb/js/bootstrap/bootstrap.min.js"></script>
        <script type="text/javascript" src="./common/tb/plugins/misc/qtip/jquery.qtip.min.js"></script>
        <script type="text/javascript" src="./common/tb/plugins/misc/totop/jquery.ui.totop.min.js"></script>
        <script type="text/javascript" src="./common/tb/plugins/forms/watermark/jquery.watermark.min.js"></script>
        <script type="text/javascript" src="./common/tb/plugins/forms/uniform/jquery.uniform.min.js"></script>
        <script type="text/javascript" src="./common/tb/js/main.js"></script>
        </body></html>

    <?php
    }

    static function end_view($message, $message2 = "")
    {
        ?>
        <div class="endview_div">
            <?= $message ?>
            <?php
            if ($message2) {
                ?>
                <div class="endview_div2">
                    <?= $message2 ?>
                </div>
            <?php
            }
            ?>
        </div>
        <br />
    <?php
    }

    static function form_error($text)
    {
        if ($text) {
            ?>
            <div class="error_div">⇒<?= $text ?></div>
        <?php
        }
    }

    static function form_error_for_tab($text, $tab_get)
    {
        /**
         * タブによって表示・非表示を選択するエラー
         * @var tab_get
         */
        if ($text && $tab_get == $GLOBALS['GET']['tab']) {
            ?>
            <div class="error_div">⇒<?= $text ?></div>
        <?php
        }
    }

    static function calendar_selectbox($mainkey_name, $data, $from_year = 2015, $subkey = array("_year", "_month", "_day"))
    {
        if(!isset($data[$mainkey_name . $subkey[0]])){$data[$mainkey_name . $subkey[0]] = "";}
        if(!isset($data[$mainkey_name . $subkey[1]])){$data[$mainkey_name . $subkey[1]] = "";}
        if(!isset($data[$mainkey_name . $subkey[2]])){$data[$mainkey_name . $subkey[2]] = "";}
        if(!isset($data[$mainkey_name])){$data[$mainkey_name] = "";}

        //日付が年月日まとめてなら分割
        if (!$data[$mainkey_name . $subkey[0]] && !$data[$mainkey_name . $subkey[1]] && !$data[$mainkey_name . $subkey[2]] && $data[$mainkey_name]) {
            list($data[$mainkey_name . $subkey[0]], $data[$mainkey_name . $subkey[1]], $data[$mainkey_name . $subkey[2]]) = explode("-", $data[$mainkey_name]);
        }

        //nameが配列で指定されている場合　name=date[name1][name2]等の場合
        if (strpos($mainkey_name, "[") !== false && strpos($mainkey_name, "]") !== false) {
            $merge_main = str_replace("]", "", end(explode("[", $mainkey_name)));
            $main_front = str_replace("[" . $merge_main . "]", "", $mainkey_name);
            $merge_key0 = $main_front . "[" . $merge_main . $subkey[0] . "]";
            $merge_key1 = $main_front . "[" . $merge_main . $subkey[1] . "]";
            $merge_key2 = $main_front . "[" . $merge_main . $subkey[2] . "]";

        } else {
            $merge_key0 = $mainkey_name . $subkey[0];
            $merge_key1 = $mainkey_name . $subkey[1];
            $merge_key2 = $mainkey_name . $subkey[2];
            $merge_main = $mainkey_name;
        }

        $date = new DateTime();
        $date->modify("+2 year");
        $to_year = $date->format('Y');

        $year_array = array_combine(range($from_year, $to_year), range($from_year, $to_year));

        $month_array_tmp = array_combine(range(1, 12), range(1, 12));
        foreach ($month_array_tmp as $key => $value) {
            $month_array[sprintf("%02d", $value)] = sprintf("%02d", $value);
        }
        $day_array_tmp = array_combine(range(1, 31), range(1, 31));
        foreach ($day_array_tmp as $key => $value) {
            $day_array[sprintf("%02d", $value)] = sprintf("%02d", $value);
        }
        $date_y = $GLOBALS['datetime_now_obj']->format('Y');

        $minus_year = $date_y - $from_year;
        $e100 = 100;
        $html = <<<HTML
<script>
var d = new Date();
var year = d.getFullYear() - 20;
var yearn = d.getFullYear();
var day = d.getDate();
var yrRange = (yearn -{$e100}) + ":" + d.getFullYear() +2;
$(function() {
//カレンダーからプルダウンを更新
$('.{$merge_main}Date').each(function() {
var id = '#' + $(this).attr('id');
$(id + ' input').bind('change', function() {
var i = 0;
var dates = $(this).val().split('/');
$(id + ' select').each(function() {
$(this).val(dates[i]);
i++;
});
});
});

//プルダウンからカレンダーを更新
$('.{$merge_main}Date').each(function() {
var id = '#' + $(this).attr('id');
$(id + ' select').bind('change', function() {
var i = 0;
var dates = new Array(3);
$(id + ' select').each(function() {
dates[i] = $(this).val();
i++;
});
var newdate = dates[0] + '/' + dates[1] + '/' + dates[2];
$(id + ' input').val(newdate);
});
});

//カレンダーの表示
var date = new Date();
var year = date.getFullYear();
$.datepicker.setDefaults({
defaultDate: new Date(yearn, d.getMonth(), day),
changeMonth: true,
changeYear: true,
yearRange : yrRange,
//minDate:'-{$minus_year}y',
maxDate:'+2y',
closeText: '閉じる',
prevText: '<前',
nextText: '次>',
currentText: '今日',
monthNames: ['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月'],
monthNamesShort: ['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月'],
dayNames: ['日曜日','月曜日','火曜日','水曜日','木曜日','金曜日','土曜日'],
dayNamesShort: ['日','月','火','水','木','金','土'],
dayNamesMin: ['日','月','火','水','木','金','土'],
weekHeader: '週',
showOn: 'button',
buttonText: '',
buttonImage: './common/tb/images/icons/calendar.png',
buttonImageOnly: true,
dateFormat: 'yy/mm/dd',
firstDay: 0,
isRTL: false,
showMonthAfterYear: true,
yearSuffix: '年'
});
$('.{$merge_main}Date input').datepicker();

$("#clear_button{$merge_main}").click( function(){
    $("#{$merge_key0}").val("");
    $("#{$merge_key1}").val("");
    $("#{$merge_key2}").val("");
});

});


</script>

              <div id="{$merge_main}_id" class="{$merge_main}Date" style="display: inline;">
                <select name="{$merge_key0}" id="{$merge_key0}" class="selectbox_year">
                <option value=""></option>
HTML;

        $html .= Form::pulldown_write_usekey_return($year_array, $data[$merge_key0]);

        $html .= <<<HTML
                                   </select>
        年
                <select name="{$merge_key1}" id="{$merge_key1}" class="selectbox_month_day">
                <option value=""></option>
HTML;
        if ($data[$merge_key1]) {
//            $data[$merge_main.$subkey[1]] = $data[$merge_main.$subkey[1]] -1;
        }
        $html .= Form::pulldown_write_usekey_return($month_array, $data[$merge_key1]);
        $html .= <<<HTML
                </select>
                月
                <select name="{$merge_key2}" id="{$merge_key2}" class="selectbox_month_day">
                <option value=""></option>
HTML;
        $html .= Form::pulldown_write_usekey_return($day_array, $data[$merge_key2]);
        $html .= <<<HTML
                </select>
                日
                <input type="text" name="{$merge_main}Date" id="{$merge_main}Date" value="" class="input-medium ime_off" style="display: none;" readonly />
              </div>

              <input type="button" value="クリア" id="clear_button{$merge_main}" class="calendar_clear_button"/>

HTML;

        return $html;

    }


}


class form_parts
{


    static function row_selecter($url, $selected, $num)
    {


        switch ($selected) {
            case "5":
                $select5 = " selected";
                break;
            case "20":
                $select20 = " selected";
                break;
            case "100":
                $select100 = " selected";
                break;
            case "200":
                $select200 = " selected";
                break;

            default:

                $select100 = " selected";
                break;

        }
        ?>
        <table class="row_selecter_table">
            <tr>

                <td nowrap class="common-list-title-right" style="border:0px;priority"> 1ページ当たり：
                    <select name="" class="row_selecter_select input-medium" onChange="row_select('<?= $url ?>',this.value)">
                        <option value="5"<?= $select5 ?>>5</option>
                        <option value="20"<?= $select20 ?>>20</option>
                        <option value="100"<?= $select100 ?>>100</option>
                        <option value="200"<?= $select200 ?>>200</option>
                    </select>
                    件
                </td>
            </tr>
        </table>
    <?php
    }
}





