<?php

class default_admin_class
{
	public $session_key;
	public $line;
	public $search_rows;
        public $month_array = array("01" , "02" , "03" , "04" , "05" , "06" , "07" , "08" , "09" , "10" , "11" , "12");
	public $day_array = array("01" , "02" , "03" , "04" , "05" , "06" , "07" , "08" , "09" , "10" ,
		"11" , "12" , "13" , "14" , "15" , "16" , "17" , "18" , "19" , "20" , "21" , "22" ,
		"23" , "24" , "25" , "26" , "27" , "28" , "29" , "30" , "31");
	public $hour_array = array("00" , "01" , "02" , "03" , "04" , "05" , "06" , "07" , "08" , "09" , "10" ,
		"11" , "12" , "13" , "14" , "15" , "16" , "17" , "18" , "19" , "20" , "21" , "22" , "23");
    public $minute_array = array("00" , "01" , "02" , "03" , "04" , "05" , "06" , "07" , "08" , "09" , "10" ,
        "11" , "12" , "13" , "14" , "15" , "16" , "17" , "18" , "19" , "20" , "21" , "22" ,
        "23" , "24" , "25" , "26" , "27" , "28" , "29" , "30" , "31" , "32" , "33" , "34" , "35" , "36" , "37" , "38" , "39" , "40" , "41" , "42" , "43" , "44" , "45" , "46" , "47" , "48" , "49" , "50" , "51" , "52" , "53" , "54" , "55" , "56" , "57" , "58" , "59");
    public $minute_10array = array("00" , "10" , "20", "30", "40", "50" );

	public $navigator;
    public $token;

	function __construct()
	{

		//token処理
		if($_GET['token']){
			$this->token = $_GET['token'];
		}else{
            $d2 = date_create();
            $time = date_format($d2, "YmdHis");

			$this->token = $time;
		}

		$this->session_key = $_GET['req'] . "_" . $_GET['no'] . "_" . $this->token;

        //2038年問題クリア
        $next_month_obj = new DateTime();
        $next_month_obj->modify('+1 month');
        $d = date_create();
        $y_limit = $next_month_obj->format('Y');
		$this->year_array = range("2013",$y_limit);


		if ($_SERVER['REQUEST_METHOD'] == "GET" && !$_GET['sd']) { //POST以外はセッション削除(特例あり）
			//SESSION削除
			$Session = new Session();
			$Session->session_delete($this->session_key);
		}

		if (is_numeric($_GET["line"])) {
			$this->line = $_GET["line"];
		} else {
			$this->line = 0;
		}
		if(is_numeric($_GET['rows'])){
		$this->search_rows = $_GET['rows'];
		}else{
			$this->search_rows = 100;//あくまでデフォルト、上書きあり
		}

        //関数の無効化(1文字目がアンダーバーの関数は直接は呼び出せない（関数内からは呼べる）)
        $pattern = '/^_/';                        // 検出パターン

        $match_num = preg_match($pattern, $_GET['mode'], $matches);

        if($match_num){
            $_GET['mode'] = "main";
        }

	}

	function endview($h3 , $text,$req = false)
	{

		if($req === false){
			$req = $_GET['req'];
		}

		?>
		<h2 class="admin_h2"><?= $h3 ?></h2>


		<div class="mypageBox">

			<p class="admin_end_text"><?= $text ?>

				<br/>
				<br/>
				<a href="./index.php?req=<?=    $req?>">戻る</a>
			</p>
		</div>

		</div>
		<!--============ ▲RightPart ▲ ============-->
		<p class="clear"></p>
	<?php
	}


    function end_message()
    {//特定の処理で変える場合は、上書きする

        if ($GLOBALS['GET']['em'] == "1") {
            $this->messege .= <<<HTML
<span class="em">登録が完了しました。</span>
HTML;

        } elseif ($GLOBALS['GET']['em'] == "2") {
            $this->messege .= <<<HTML
<span class="em">更新が完了しました。</span>
HTML;

        } elseif ($GLOBALS['GET']['em'] == "3") {
            $this->messege .= <<<HTML
<span class="em">削除が完了しました。</span>
HTML;

        } elseif ($GLOBALS['GET']['em'] == "4") {
            $this->messege .= <<<HTML
<span class="em">発行が完了しました。</span>
HTML;

        } elseif ($GLOBALS['GET']['em'] == "err1") {
            $this->messege .= <<<HTML
 <div class="error_div">⇒ファイルが見つかりませんでした。</div>
HTML;

        }

        if($GLOBALS['GET']['close']){ //windowを閉じる
            $this->messege .= <<<HTML
        <script type="text/javascript">
            <!--
         window.close();

            //-->
        </script>
HTML;
        }

        if($GLOBALS['GET']['open']){ //javascriptで別ウィンドウを開く
            $open_url = rawurldecode($GLOBALS['GET']['open']);
            $open_url = str_replace("&amp;","&",$open_url);
            $get = Array_func::GETquery(array("open"));
            $this->messege .= <<<HTML
        <script type="text/javascript">
            <!--
         window.open('{$open_url}');
location.href='./?{$get}'
            //-->
        </script>
HTML;
        }



        return $this->messege;

    }


	function template_view($filename = false)
	{
		//テンプレートがあれば読込
		if ($filename === false) {
			$path = REQUIRE_PATH . '/mypage/template/' . $_GET['req'] . "_" . $_GET['mode'] . ".tpl";
		} else {
			$path = REQUIRE_PATH . '/mypage/template/' . $filename . ".tpl";
		}

		if (is_file($path)) {
			require_once $path;
		}
	}

}