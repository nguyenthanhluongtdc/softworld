<?php


class index extends default_admin_class
{
    var $before_date_y;

    function __construct()
    {
        parent::__construct();


echo "test;;;";
    }

    function main(){
        ?>
        <!--Body content-->
        <div id="content" class="clearfix">
			<div class="contentwrapper"><!--Content wrapper-->
				<div class="heading">
					<h3>物件一覧</h3>
					<div class="resBtnSearch">
						<a href="#"><span class="icon16 icomoon-icon-search-3"></span></a>
					</div>
					<form name="SearchForm" id="SearchForm" action="/admin/article_list.php" method="post" autocomplete="off">
					<div class="search">
							<input type="text" name="post_key" id="tipue_search_input" class="top-search" placeholder="検索キーワード..." value="" />
							<input type="submit" name="search" id="tipue_search_button" class="search-btn" value=""/>
					</div><!-- End search -->
				</form>
				</div><!-- End .heading-->
					<form name="ListForm" id="ListForm" action="/admin/article_list.php" method="post" autocomplete="off">
				<!-- Build page from here: Usual with <div class="row-fluid"></div> -->
				<div class="row-fluid">
					<div class="span12">
						<div class="box gradient">
							<div class="title">
								<h4>
									<span>件数：84件</span>
									<div class="box-form right">
										<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
											<span class="icon16 icomoon-icon-cog-2"></span>
											<span class="caret"></span>
										</a>
										<ul class="dropdown-menu">
											<li><a href="javascript:void(0)" onclick="if(confirm('CSVエクスポートを行います。\n\nよろしいですか？\n')==true){ListForm.post_mode.value='CSVエクスポート';ListForm.submit();ListForm.post_mode.value='';}"><span class="icon-pencil"></span> CSVエクスポート</a></li>
											<li><a href="javascript:void(0)" onclick="if(confirm('チェック項目削除を行います。\n\nよろしいですか？\n')==true){ListForm.post_mode.value='チェック項目削除';ListForm.submit();ListForm.post_mode.value='';}"><span class="icon-pencil"></span> チェック項目削除</a></li>
										</ul>
									</div>
								</h4>
							</div>
							<div class="content noPad clearfix" id="DataArea">
					<form name="ListForm" id="ListForm" action="/admin/article_list.php" method="post" autocomplete="off">
<input type="hidden" name="post_search" id="post_search" value="" /><fieldset><label style="margin:0 5px 7px 0" for="post_act" class="select">
	<select name="post_act" id="post_act" onChange="ListForm.post_search.value=1;ListForm.submit();">
		<option value="" selected="selected">↓(公開フラグ)</option>
		<option value="0">保留</option>
		<option value="1"><span class="orange">公開</span></option>
		<option value="2"><span class="orange">トップおすすめ公開</span></option>
		<option value="8">終了物件</option>
	</select>
	</label>
<label style="margin:0 5px 7px 0" for="post_staff" class="select">
	<select name="post_staff" id="post_staff" onChange="ListForm.post_search.value=1;ListForm.submit();">
		<option value="" selected="selected">↓(オーナー)</option>
		<option value="1">システム管理者</option>
		<option value="2">?光南溶工</option>
		<option value="3">百鳥　雄二</option>
		<option value="4">木下　隆弘</option>
		<option value="5">川村建設工務</option>
		<option value="6">?SUMIDA</option>
		<option value="7">レネソーラ</option>
		<option value="8">ファーストクラス</option>
		<option value="9">ソーラーエナジー</option>
		<option value="10">ハイブリッド</option>
		<option value="11">株式会社WAKO</option>
	</select>
	</label>
<label style="margin:0 5px 7px 0" for="post_cate" class="select">
	<select name="post_cate" id="post_cate" onChange="ListForm.post_search.value=1;ListForm.submit();">
		<option value="" selected="selected">↓(カテゴリ)</option>
		<option value="1">稼働中</option>
		<option value="2">系統連携前</option>
		<option value="3">ID付土地</option>
	</select>
	</label>
<label style="margin:0 5px 7px 0" for="post_nedo_powercompany" class="select">
	<select name="post_nedo_powercompany" id="post_nedo_powercompany" onChange="ListForm.post_search.value=1;ListForm.submit();">
		<option value="" selected="selected">↓(管轄電力会社)</option>
		<option value="11">北海道電力</option>
		<option value="12">東北電力</option>
		<option value="13">東京電力</option>
		<option value="14">北陸電力</option>
		<option value="15">中部電力</option>
		<option value="16">関西電力</option>
		<option value="17">四国電力</option>
		<option value="18">中国電力</option>
		<option value="19">九州電力</option>
		<option value="20">沖縄電力</option>
	</select>
	</label>
<div style="clear:both;"><label style="margin:0 5px 7px 0" for="post_order" class="select">
	<select name="post_order" id="post_order" onChange="ListForm.post_search.value=1;ListForm.submit();">
		<option value="">↓(並べ替え)</option>
		<option value="article_no">No</option>
		<option value="article_act">公開フラグ</option>
		<option value="article_status">非公開物件フラグ</option>
		<option value="article_staff">オーナー</option>
		<option value="article_zip1">郵便番号1</option>
		<option value="article_zip2">郵便番号2</option>
		<option value="article_pref">都道府県</option>
		<option value="article_addr1">市区町村</option>
		<option value="article_addr2">丁目・地番</option>
		<option value="article_gmap_latitude">地図表示用緯度</option>
		<option value="article_gmap_longitude">地図表示用経度</option>
		<option value="article_rail_pref1">路線1都道府県</option>
		<option value="article_rail_rr1">路線1種類</option>
		<option value="article_rail_line1">路線1</option>
		<option value="article_rail_station1">最寄り駅名1</option>
		<option value="article_rail_time1">最寄り駅までの距離１</option>
		<option value="article_rail_pref2">路線2都道府県</option>
		<option value="article_rail_rr2">路線2種類</option>
		<option value="article_rail_line2">路線2</option>
		<option value="article_rail_station2">最寄り駅名2</option>
		<option value="article_rail_time2">最寄り駅までの距離２</option>
		<option value="article_thumbimg">サムネイル用イメージ</option>
		<option value="article_file">メインイメージ</option>
		<option value="article_cap">メインイメージキャプション</option>
		<option value="article_cate">カテゴリ</option>
		<option value="article_id" selected="selected">管理ID</option>
		<option value="article_name">発電所名</option>
		<option value="article_kana">発電所名（カナ）</option>
		<option value="article_catch">概要説明文</option>
		<option value="article_description">詳細説明文</option>
		<option value="article_access">アクセス</option>
		<option value="article_url">URL</option>
		<option value="article_capa">システム容量</option>
		<option value="article_price">販売価格</option>
		<option value="article_partition_num">区画番号</option>
		<option value="article_partition_totalnum">全区画数</option>
		<option value="article_nedo_point">NEDO　地点名</option>
		<option value="article_nedo_angle">NEDO　傾斜角</option>
		<option value="article_nedo_azimuth">NEDO　方位角</option>
		<option value="article_nedo_solarradiation">NEDO　年平均日射量</option>
		<option value="article_nedo_price">NEDO　調達価格</option>
		<option value="article_nedo_generatecapa">NEDO　年間想定発電量</option>
		<option value="article_nedo_salesrevenue">NEDO　年間想定売電収入</option>
		<option value="article_nedo_yield">NEDO　想定表面利回り</option>
		<option value="article_nedo_powercompany">NEDO　管轄電力会社</option>
		<option value="article_nedo_output">NEDO　出力抑制</option>
		<option value="article_nedo_burdencharge">NEDO　工事費負担金</option>
		<option value="article_nedo_coopdate">NEDO　連携年月日</option>
		<option value="article_land_agreement">土地　土地契約</option>
		<option value="article_land_tradingvalue">土地　土地売買代</option>
		<option value="article_land_rent">土地　土地賃借料</option>
		<option value="article_land_sitearea">土地　敷地面積</option>
		<option value="article_modules_maker">モジュール　メーカー</option>
		<option value="article_modules_model">モジュール　型式</option>
		<option value="article_modules_capa">モジュール　システム容量</option>
		<option value="article_power_maker">パワコン　メーカー</option>
		<option value="article_power_model">パワコン　型式</option>
		<option value="article_power_capa">パワコン　最大容量</option>
		<option value="article_etc_memo">スタッフメモ</option>
		<option value="article_free_title1">フリー１項目名</option>
		<option value="article_free_cont1">フリー１内容</option>
		<option value="article_free_title2">フリー２項目名</option>
		<option value="article_free_cont2">フリー２内容</option>
		<option value="article_free_title3">フリー３項目名</option>
		<option value="article_free_cont3">フリー３内容</option>
		<option value="article_free_title4">フリー４項目名</option>
		<option value="article_free_cont4">フリー４内容</option>
		<option value="article_free_title5">フリー５項目名</option>
		<option value="article_free_cont5">フリー５内容</option>
		<option value="article_lastdate">最終更新日</option>
		<option value="article_date">登録日</option>
	</select>
	</label>
<label style="margin:0 5px 7px 0" for="post_sort" class="select">
	<select name="post_sort" id="post_sort" onChange="ListForm.post_search.value=1;ListForm.submit();">
		<option value="">昇順</option>
		<option value="desc">降順</option>
	</select>
	</label>
</div></fieldset><div class="center">
	<div class="pagination">
		<ul>
			<li class="active"><a href="/admin/article_list.php?post_page=1">1</a></li>
			<li><a href="/admin/article_list.php?post_page=2">2</a></li>
			<li><a href="/admin/article_list.php?post_page=3">3</a></li>
			<li><a href="/admin/article_list.php?post_page=4">4</a></li>
			<li><a href="/admin/article_list.php?post_page=5">5</a></li>
			<li><a href="/admin/article_list.php?post_page=2"><span class="icon12 minia-icon-arrow-right-2"></span></a></li>
			<li><a href="/admin/article_list.php?post_page=5"><span class="icon12 minia-icon-arrow-down-2"></span></a></li>
		</ul>
	</div>
</div>
<table id="DnDTable" cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered table-condensed" width="100%">
<thead><tr>
<th width="40" style="white-space:nowrap;">編集</th>
<th width="40" style="white-space:nowrap;">公開</th>
<th style="white-space:nowrap;">物件タイプ</th>
<th style="white-space:nowrap;">管理ID</th>
<th style="white-space:nowrap;">オーナー</th>
<th style="white-space:nowrap;">発電所名</th>
<th style="white-space:nowrap;">カテゴリ</th>
<th style="white-space:nowrap;">住所</th>
</tr></thead>

<tbody>
<tr id="80">
	<td style="text-align:center;"><button type="button" class="btn-success btn" onclick="location.href='article_mnt.php?search=1&article_no=80'">編集</button></td>
	<td>保留</td>
	<td>通常公開物件</td>
	<td>a0002</td>
	<td>システム管理者</td>
	<td><a href="http://solorpanel.sysdemo.net/article/?no=80&access_key=U2FsdGVkX1%2BcJBt2rtg1x2zAR3tlLs4QaWzGSGwrAhvpmKLQibWE6hH8Scj27uFG" target="_blank">テスト</a></td>
	<td>稼働中</td>
	<td>広島県広島市中区</td>
</tr><tr id="84">
	<td style="text-align:center;"><button type="button" class="btn-success btn" onclick="location.href='article_mnt.php?search=1&article_no=84'">編集</button></td>
	<td><span class="orange">公開</span></td>
	<td>通常公開物件</td>
	<td>B001</td>
	<td>ソーラーエナジー</td>
	<td><a href="http://solorpanel.sysdemo.net/article/?no=84&access_key=U2FsdGVkX18Q3e7ArmEFeh6dFXBGaQW%2FP58R3qw9%2BdYiwzNH67GOyHSw8sJfRbdU" target="_blank">福島蛇音山発電所</a></td>
	<td>系統連携前</td>
	<td>福島県福島市山田</td>
</tr><tr id="2">
	<td style="text-align:center;"><button type="button" class="btn-success btn" onclick="location.href='article_mnt.php?search=1&article_no=2'">編集</button></td>
	<td><span class="orange">公開</span></td>
	<td>通常公開物件</td>
	<td>C001</td>
	<td>川村建設工務</td>
	<td><a href="http://solorpanel.sysdemo.net/article/?no=2&access_key=U2FsdGVkX1%2Bcg3r4zIsk0D0DgDRy5Bj8rNDNGNgMdRFXbzw4li%2FNVbAwQFjR8iGd" target="_blank">嵐山第４発電所</a></td>
	<td>系統連携前</td>
	<td>埼玉県比企郡嵐山町</td>
</tr><tr id="16">
	<td style="text-align:center;"><button type="button" class="btn-success btn" onclick="location.href='article_mnt.php?search=1&article_no=16'">編集</button></td>
	<td><span class="orange">公開</span></td>
	<td>通常公開物件</td>
	<td>C002</td>
	<td>川村建設工務</td>
	<td><a href="http://solorpanel.sysdemo.net/article/?no=16&access_key=U2FsdGVkX1%2Fk%2BHT74Q9hTi%2F%2BRuYGZkUzuGLiJaOjLXEw2ga7LXf1lapmYjXr5jvU" target="_blank">宇佐美太陽光発電所</a></td>
	<td>系統連携前</td>
	<td>静岡県伊東市宇佐美</td>
</tr><tr id="41">
	<td style="text-align:center;"><button type="button" class="btn-success btn" onclick="location.href='article_mnt.php?search=1&article_no=41'">編集</button></td>
	<td>保留</td>
	<td>通常公開物件</td>
	<td>C003</td>
	<td>?光南溶工</td>
	<td><a href="http://solorpanel.sysdemo.net/article/?no=41&access_key=U2FsdGVkX18FwfGNGlRpudXWBcJBcAbkd8ycBhIjJRt1TGDUx3SPHeqAqXXt%2FkhB" target="_blank">【低圧14区画】千葉県山武市</a></td>
	<td>ID付土地</td>
	<td>千葉県山武市</td>
</tr><tr id="42">
	<td style="text-align:center;"><button type="button" class="btn-success btn" onclick="location.href='article_mnt.php?search=1&article_no=42'">編集</button></td>
	<td>保留</td>
	<td>通常公開物件</td>
	<td>C006</td>
	<td>?光南溶工</td>
	<td><a href="http://solorpanel.sysdemo.net/article/?no=42&access_key=U2FsdGVkX1%2FIb%2Fyx1VeerQIq0VpFdiSixBBrz8XGUuzFCvfH8WT5rl7E4MCJRMbf" target="_blank">各務原発電所</a></td>
	<td>ID付土地</td>
	<td>岐阜県各務原市</td>
</tr><tr id="32">
	<td style="text-align:center;"><button type="button" class="btn-success btn" onclick="location.href='article_mnt.php?search=1&article_no=32'">編集</button></td>
	<td><span class="orange">公開</span></td>
	<td>通常公開物件</td>
	<td>C012</td>
	<td>レネソーラ</td>
	<td><a href="http://solorpanel.sysdemo.net/article/?no=32&access_key=U2FsdGVkX18huOBeNr%2BeYgz%2BGTHH5Q2TcM1b7QMWgkEC0rlUCvoMsH6FllyJRKtg" target="_blank">下野市坪山太陽光発電所?</a></td>
	<td>系統連携前</td>
	<td>栃木県下野市下坪山</td>
</tr><tr id="33">
	<td style="text-align:center;"><button type="button" class="btn-success btn" onclick="location.href='article_mnt.php?search=1&article_no=33'">編集</button></td>
	<td><span class="orange">公開</span></td>
	<td>通常公開物件</td>
	<td>C013</td>
	<td>レネソーラ</td>
	<td><a href="http://solorpanel.sysdemo.net/article/?no=33&access_key=U2FsdGVkX19m8h3MzyH9gXYiKFYWfSeZjqEv6cXSPNP11axCPUl5pjHhap5HczyZ" target="_blank">下野町下坪山太陽光発電所?</a></td>
	<td>系統連携前</td>
	<td>栃木県下野市下坪山</td>
</tr><tr id="82">
	<td style="text-align:center;"><button type="button" class="btn-success btn" onclick="location.href='article_mnt.php?search=1&article_no=82'">編集</button></td>
	<td><span class="orange">公開</span></td>
	<td>通常公開物件</td>
	<td>C014</td>
	<td>レネソーラ</td>
	<td><a href="http://solorpanel.sysdemo.net/article/?no=82&access_key=U2FsdGVkX1994tK6l7YEOUZwf7CoSf3c2VSHeJ1dfil7RJ%2FGzTsx%2Ff4KnHfmXX6H" target="_blank">多治見高圧太陽光発電所</a></td>
	<td>系統連携前</td>
	<td>岐阜県多治見市</td>
</tr><tr id="30">
	<td style="text-align:center;"><button type="button" class="btn-success btn" onclick="location.href='article_mnt.php?search=1&article_no=30'">編集</button></td>
	<td><span class="orange">公開</span></td>
	<td>通常公開物件</td>
	<td>C017</td>
	<td>ファーストクラス</td>
	<td><a href="http://solorpanel.sysdemo.net/article/?no=30&access_key=U2FsdGVkX1%2Fws%2B0GrODIwE8IxlMN0AJ4AmunIM%2FOMWNk0tZi3N%2FOkXF6bdn18dZc" target="_blank">土浦市神立町太陽光発電所</a></td>
	<td>稼働中</td>
	<td>茨城県土浦市神立町字鶴沼</td>
</tr><tr id="31">
	<td style="text-align:center;"><button type="button" class="btn-success btn" onclick="location.href='article_mnt.php?search=1&article_no=31'">編集</button></td>
	<td><span class="orange">公開</span></td>
	<td>通常公開物件</td>
	<td>C018</td>
	<td>ファーストクラス</td>
	<td><a href="http://solorpanel.sysdemo.net/article/?no=31&access_key=U2FsdGVkX18rraBLYlxxALNs%2BnwWqcBmg5o3qAR2naZSSFoZzgHoKx7GYFabfZt5" target="_blank">成田太陽光発電所</a></td>
	<td>稼働中</td>
	<td>千葉県成田市官林</td>
</tr><tr id="75">
	<td style="text-align:center;"><button type="button" class="btn-success btn" onclick="location.href='article_mnt.php?search=1&article_no=75'">編集</button></td>
	<td>保留</td>
	<td>通常公開物件</td>
	<td>C020</td>
	<td>川村建設工務</td>
	<td><a href="http://solorpanel.sysdemo.net/article/?no=75&access_key=U2FsdGVkX1%2FZy4JBly9xVQgPl8Fc6DpnwfhVYJORWH4T91kFa5qPA7FWoKpHT6Gw" target="_blank">瑞浪太陽光発電所</a></td>
	<td>系統連携前</td>
	<td>岐阜県瑞浪市</td>
</tr><tr id="83">
	<td style="text-align:center;"><button type="button" class="btn-success btn" onclick="location.href='article_mnt.php?search=1&article_no=83'">編集</button></td>
	<td>保留</td>
	<td>通常公開物件</td>
	<td>C021</td>
	<td>&nbsp;</td>
	<td><a href="http://solorpanel.sysdemo.net/article/?no=83&access_key=U2FsdGVkX1%2BYV9rSVgxxtGQMET11Qxf58F5TlxS0pBveg6%2BiQ3HjqnbTqua75FWp" target="_blank">野辺山太陽光発電所</a></td>
	<td>系統連携前</td>
	<td>長野県南佐久郡</td>
</tr><tr id="43">
	<td style="text-align:center;"><button type="button" class="btn-success btn" onclick="location.href='article_mnt.php?search=1&article_no=43'">編集</button></td>
	<td>保留</td>
	<td>通常公開物件</td>
	<td>D001</td>
	<td>?光南溶工</td>
	<td><a href="http://solorpanel.sysdemo.net/article/?no=43&access_key=U2FsdGVkX1%2BLg5Zlk592knZ0M3i%2BbYa71fb7VvTIgnQwQdjNevDXyxJNKov%2FJYSy" target="_blank">黒坂1発電所</a></td>
	<td>ID付土地</td>
	<td>愛知県豊田市</td>
</tr><tr id="44">
	<td style="text-align:center;"><button type="button" class="btn-success btn" onclick="location.href='article_mnt.php?search=1&article_no=44'">編集</button></td>
	<td><span class="orange">公開</span></td>
	<td>通常公開物件</td>
	<td>D002</td>
	<td>?光南溶工</td>
	<td><a href="http://solorpanel.sysdemo.net/article/?no=44&access_key=U2FsdGVkX1%2BzDrEK4RWttWMvj%2BlAtEVd0DOOoezLpdK6C733aVI0Qr0K0Rd8C1dg" target="_blank">羽根発電所</a></td>
	<td>系統連携前</td>
	<td>愛知県豊田市</td>
</tr><tr id="45">
	<td style="text-align:center;"><button type="button" class="btn-success btn" onclick="location.href='article_mnt.php?search=1&article_no=45'">編集</button></td>
	<td><span class="orange">公開</span></td>
	<td>通常公開物件</td>
	<td>D003</td>
	<td>?光南溶工</td>
	<td><a href="http://solorpanel.sysdemo.net/article/?no=45&access_key=U2FsdGVkX1%2BbzRd%2FcDZmDlroUGl%2FsfXQWRRGLX4a1X1NLJ7D0vTJ2b9euCD8Qlad" target="_blank">北畑発電所</a></td>
	<td>系統連携前</td>
	<td>愛知県豊田市</td>
</tr><tr id="46">
	<td style="text-align:center;"><button type="button" class="btn-success btn" onclick="location.href='article_mnt.php?search=1&article_no=46'">編集</button></td>
	<td><span class="orange">公開</span></td>
	<td>通常公開物件</td>
	<td>D005</td>
	<td>?光南溶工</td>
	<td><a href="http://solorpanel.sysdemo.net/article/?no=46&access_key=U2FsdGVkX19DAarBEr7dNHT%2FJ%2FxjVBBZjxoZnpJQ%2BSI6SV5J0gRvY9g3JWAx7ppW" target="_blank">黒坂北畑25発電所</a></td>
	<td>系統連携前</td>
	<td>愛知県豊田市</td>
</tr><tr id="5">
	<td style="text-align:center;"><button type="button" class="btn-success btn" onclick="location.href='article_mnt.php?search=1&article_no=5'">編集</button></td>
	<td>保留</td>
	<td>通常公開物件</td>
	<td>D006</td>
	<td>百鳥　雄二</td>
	<td><a href="http://solorpanel.sysdemo.net/article/?no=5&access_key=U2FsdGVkX1%2FAnW3L7Hs8CGfr18teoLHHj%2F620Mzyw7Og4OfLSu4isc6AjBPeIbnU" target="_blank">石川県加賀市低圧案件</a></td>
	<td>ID付土地</td>
	<td>石川県加賀市</td>
</tr><tr id="14">
	<td style="text-align:center;"><button type="button" class="btn-success btn" onclick="location.href='article_mnt.php?search=1&article_no=14'">編集</button></td>
	<td>保留</td>
	<td>通常公開物件</td>
	<td>E002</td>
	<td>川村建設工務</td>
	<td><a href="http://solorpanel.sysdemo.net/article/?no=14&access_key=U2FsdGVkX1%2BlflX7%2FkyOC7K6jP8wSx2gjv5xDY%2F4SMtdZ9WXdIhhS2AuZiqFmteE" target="_blank">北野山発電所</a></td>
	<td>ID付土地</td>
	<td>奈良県奈良市北野山町</td>
</tr><tr id="18">
	<td style="text-align:center;"><button type="button" class="btn-success btn" onclick="location.href='article_mnt.php?search=1&article_no=18'">編集</button></td>
	<td>保留</td>
	<td>通常公開物件</td>
	<td>E004</td>
	<td>川村建設工務</td>
	<td><a href="http://solorpanel.sysdemo.net/article/?no=18&access_key=U2FsdGVkX1%2FGuSpaiz4XtQ6FRByC6ftu%2BPyqRU6KYYBfI7NeDqEth8VRfvZqXidw" target="_blank">川村発電所</a></td>
	<td>ID付土地</td>
	<td>京都府亀岡市宮前町猪倉椿原</td>
</tr></tbody>
<tfoot><tr>
<th width="40" style="white-space:nowrap;">編集</th>
<th width="40" style="white-space:nowrap;">公開</th>
<th style="white-space:nowrap;">物件タイプ</th>
<th style="white-space:nowrap;">管理ID</th>
<th style="white-space:nowrap;">オーナー</th>
<th style="white-space:nowrap;">発電所名</th>
<th style="white-space:nowrap;">カテゴリ</th>
<th style="white-space:nowrap;">住所</th>
</tr></tfoot>

</table><br /><div class="center">
	<div class="pagination">
		<ul>
			<li class="active"><a href="/admin/article_list.php?post_page=1">1</a></li>
			<li><a href="/admin/article_list.php?post_page=2">2</a></li>
			<li><a href="/admin/article_list.php?post_page=3">3</a></li>
			<li><a href="/admin/article_list.php?post_page=4">4</a></li>
			<li><a href="/admin/article_list.php?post_page=5">5</a></li>
			<li><a href="/admin/article_list.php?post_page=2"><span class="icon12 minia-icon-arrow-right-2"></span></a></li>
			<li><a href="/admin/article_list.php?post_page=5"><span class="icon12 minia-icon-arrow-down-2"></span></a></li>
		</ul>
	</div>
</div>
</form>								</div>
							</div><!-- End .box -->
						</div><!-- End .span12 -->
					</div><!-- End .row-fluid -->
				<!-- Page end here -->
			</div><!-- End contentwrapper -->
		</div><!-- End #content -->
        </div><!-- End #wrapper -->
        <?php

    }


}