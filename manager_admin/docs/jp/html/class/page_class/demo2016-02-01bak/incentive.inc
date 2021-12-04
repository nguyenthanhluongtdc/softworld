<?php


class incentive extends default_admin_class
{
    var $before_date_y;

    function __construct()
    {

        parent::__construct();

        $this->search_ym = $GLOBALS['GET']['date_y'] . "-" . sprintf("%02d", $GLOBALS['GET']['date_m']);
        $this->search_yymmmm = $GLOBALS['GET']['date_y'] . "" . sprintf("%02d", $GLOBALS['GET']['date_m']);
    }

    function main(){
        ?>
        <!--Body content-->
        <div id="content" class="clearfix">
			<div class="contentwrapper"><!--Content wrapper-->
				<div class="heading">
					<h3>歩合集計</h3>
<div class="search_open">
    <a id="opener"><?= SEARCH_FORM_LINK_DEFAULT_CLOSE ?></a>
</div>
				</div><!-- End .heading-->
            <div class="content_border" id="disp_block">
                                <form action="./">
                    <input type="hidden" name="req" value="<?= $GLOBALS['GET']['req'] ?>" />
                    <input type="hidden" name="s" value="1" />
							<table class="search_form_table">

                                <tr>
                                    <th>
                                        担当社員ID
                                    </th>
                                    <td><input type="text" name="staff_id" id="" /></td>
                                </tr>
                                 <tr>
                                    <th>
                                        担当社員名
                                    </th>
                                    <td><input type="text" name="staff_name" id="" /></td>
                                </tr>

                                <tr>
                                    <th>
                                        契約年月  <span class="komered">※</span>

                                    </th>
                                    <td>

<select name="year" id="">
    <option value=""></option>
    <?php
    Form::pulldown_write_usekey($GLOBALS['master']['all_year'],$GLOBALS['GET']['year']);
    ?>
</select>
         年
                                        <select name="month" id="">
    <option value=""></option>
                                            <?php
                                            Form::pulldown_write_usekey($GLOBALS['master']['all_month'],$GLOBALS['GET']['month']);
                                            ?>
</select> 月分

                                    </td>
                                </tr>
 <tr>
                                    <th>
                                       担当種別
                                    </th>
                                    <td>
                                        <?php
if(isset($GLOBALS['GET']['tanto_type']) === false){
    $GLOBALS['GET']['tanto_type'] = 0;
}
                                        $sort_array = array(
                                            0 => "未選択",
                                            1 => "一般",
                                            2 => "企画",
                                        );
                                        Form::radio_button_write_usekey("tanto_type",$sort_array,$GLOBALS['GET']['tanto_type']);
                                        ?>
                                    </td>
                                </tr>
                                 <tr>
                                    <th>
                                       契約種別
                                    </th>
                                    <td>
                                        <?php
                                        if(isset($GLOBALS['GET']['keiyaku_type']) === false){
                                            $GLOBALS['GET']['keiyaku_type'] = 0;
                                        }
                                        Form::radio_button_write_usekey("keiyaku_type",$GLOBALS["MASTER"]['keiyaku_type'],$GLOBALS['GET']['keiyaku_type']);
                                        ?>
                                    </td>
                                </tr>
   <tr>
                                    <th>
                                        並び順
                                    </th>
                                    <td>
                                        <?php
                                        if(isset($GLOBALS['GET']['type']) === false){
                                            $GLOBALS['GET']['type'] = "sortproject";
                                        }
                                        $sort_array = array(
                                            "sortproject" => "案件順（入力画面）",
                                            "sortstaff" => "社員順（閲覧のみ）",
                                        );
                                        Form::radio_button_write_usekey("type",$sort_array,$GLOBALS['GET']['type']);
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="text_center"><input type="submit" value="検索" /></td>
                                </tr>
							</table>
                                    </form>
							</div>
				<!-- Build page from here: Usual with <div class="row-fluid"></div> -->

                <?php
                if($GLOBALS['GET']['s']){
                ?>
                    <div class="row-fluid">
					<div class="span12">
						<div class="box gradient">

							<div class="title display_none">

								<h4>
									<span>件数：10件</span>

<div class="row_selecter">
                        <?php
                        form_parts::row_selecter(Array_func::GETquery_encode(array("rows", "line", "em")), $GLOBALS['GET']['rows'], $GLOBALS['GET']['line']);
                        ?>
					</div>
								</h4>
							</div>
							<div class="content noPad clearfix" id="DataArea">
<div class="center display_none">
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

                                <div class="title">

                                <table style="width: 100%;">
                                    <tr>
                                        <td style="width: 33%;text-align: left;"> </td>
                                        <td style="width: 33%;text-align: center;"><h4>
                                                <?php
                                                if($GLOBALS['GET']['year'] && $GLOBALS['GET']['month']){

                                                ?>
								<?= $GLOBALS['GET']['year'] ?> 年 <?= $GLOBALS['GET']['month'] ?> 月分
                                                <?php
                                                }

                                                ?>
								</h4></td>
                                        <td style="width: 33%;text-align: right;">  </td>
                                    </tr>
                                </table>

							</div>
                                 <div class="text_right padding_10px">

                        <button type="button" class="btn-primary btn" onclick="window.open('./?req=total_csv')">CSVダウンロード</button>
                    </div>

                                <?php
                                if($GLOBALS['GET']['type'] == "sortstaff"){

                                //スタッフ順

                                ?>
                                <table id="DnDTable" cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered table-condensed" width="100%">
<thead><tr>

<th style="white-space:nowrap;"><a href="./?<?= Array_func::GETquery(array('type'))?>&type=sortstaff">社員名/担当種別</a></th>
<th style="white-space:nowrap;"><a href="./?<?= Array_func::GETquery(array('type'))?>&type=sortproject">案件ID</a></th>
<th style="white-space:nowrap;">契約日</th>
<th style="white-space:nowrap;">PV,EQ,IH</th>
<th style="white-space:nowrap;">メーカー</th>
<th style="white-space:nowrap;">お客様名</th>
<th style="white-space:nowrap;">Kw</th>
<th style="white-space:nowrap;">売上金額</th>
<th style="white-space:nowrap;">仕切金額</th>
<th style="white-space:nowrap;">利益額</th>
<th style="white-space:nowrap;">歩合(%/円)</th>
</tr></thead>

<tbody>
<?php
for($i = 1;$i<=27;$i++){
    $per = $i + 50;
    $id = $i % 9;
    if($id == 0){
        $id = 9;
    }
    $staff_key = (int)($i / 9 + 0.9);
    $kw = (int)($id * 100);
    $rowspan_judge = $id;
    if($before_id != $staff_key){

        $class_td = <<<HTML
 border-top:solid 2px #000000;
HTML;
        //歩合合計
        $rows_td = <<<HTML
<td id="total_percent{$rowspan_judge}" style="{$class_td}" rowspan="3"></td>
HTML;

    }else{
        $class_td = <<<HTML

HTML;
        $rows_td = "";
        $rows_td2 = "";

    }




    $before_id = $staff_key;
    $date_obj = new datetime("2015-12-".sprintf("%02d",$id+3));
    $office_key = $i % 6 + 1;
    $i_2 = $i + ($i * $i);

    $price = ($id % 3 + 1) * 100000;
    $price_2 = ($id % 3 + 1) * 60000;
    $price_diff = $price - $price_2;

    $personal[$staff_key]['price'] += $price;
    $personal[$staff_key]['price_2'] += $price_2;
    $personal[$staff_key]['price_diff'] += $price_diff;
    $personal[$staff_key]['price_diff_personal'] += (int)($price_diff * $per * 0.01);

    $all['price'] += $price;
    $all['price_2'] += $price_2;
    $all['price_diff'] += $price_diff;
    $all['price_diff_personal'] += (int)($price_diff * $per * 0.01);

    $staff_typekey = $i % 4 + 1;
    $type_staff = $GLOBALS["MASTER"]['tanto_type'][$staff_typekey];
    ?>
    <tr id="<?= $i ?>">
	<td style="<?= $class_td?>"><?= $GLOBALS["MASTER"]['staff_list'][$staff_key] ?>(<?= $type_staff ?>)</td>
	<td style="<?= $class_td?>"><?= $id ?></td>
	<td style="<?= $class_td?>"><?= $date_obj->format('Y-m-d') ?></td>
	<td style="<?= $class_td?>">
        ○,なし、EQ
	</td>
	<td style="<?= $class_td?>"><?= $GLOBALS["MASTER"]['maker_list'][$id] ?></td>
        	<td style="<?= $class_td?>"><a href="./?req=project_regi&id=10" target="_blank"><?= $GLOBALS["MASTER"]['incentive_customer'][$id] ?></a></td>
	<td style="<?= $class_td?>"><?= $kw ?>Kw</td>

	<td style="<?= $class_td?>"><?= number_format($price) ?></td>
	<td style="<?= $class_td?>"><?= number_format($price_2) ?></td>
<td style="<?= $class_td?>"><?= number_format($price_diff) ?></td>
        <td style="<?= $class_td?>"><input type="text" name="incentive[<?= $i ?>]" id="incentive[<?= $i ?>]" class="input-Xmini ime_off judge<?=$rowspan_judge?>" onchange="" value="<?= $per ?>" readonly />%
        <br />
        <?= number_format($price_diff * $per * 0.01) ?>円
        </td>
        </td>
</tr>
<?php

    if($id == 9){
        //スタッフの合計額
?>
        <tr>

<th style="white-space:nowrap;<?= $class_td?>"><?= $GLOBALS["MASTER"]['staff_list'][$staff_key] ?>　合計</th>
<th style="white-space:nowrap;<?= $class_td?>"></th>
<th style="white-space:nowrap;<?= $class_td?>"></th>
<th style="white-space:nowrap;<?= $class_td?>"></th>
<th style="white-space:nowrap;<?= $class_td?>"></th>
<th style="white-space:nowrap;<?= $class_td?>"></th>
<th style="white-space:nowrap;<?= $class_td?>"></th>
<th style="white-space:nowrap;<?= $class_td?>"><?= number_format($personal[$staff_key]['price']) ?></th>
<th style="white-space:nowrap;<?= $class_td?>"><?= number_format($personal[$staff_key]['price_2']) ?></th>
<th style="white-space:nowrap;<?= $class_td?>"><?= number_format($personal[$staff_key]['price_diff']) ?></th>
<th style="white-space:nowrap;<?= $class_td?>"><?= number_format($personal[$staff_key]['price_diff_personal']) ?></th>
</tr>
<?php

    }

}
?>
</tbody>
<tr>

<th style="white-space:nowrap;<?= $class_td?>">合計</th>
<th style="white-space:nowrap;<?= $class_td?>"></th>
<th style="white-space:nowrap;<?= $class_td?>"></th>
<th style="white-space:nowrap;<?= $class_td?>"></th>
<th style="white-space:nowrap;<?= $class_td?>"></th>
<th style="white-space:nowrap;<?= $class_td?>"></th>
<th style="white-space:nowrap;<?= $class_td?>"></th>
<th style="white-space:nowrap;<?= $class_td?>"><?= number_format($all['price']) ?></th>
<th style="white-space:nowrap;<?= $class_td?>"><?= number_format($all['price_2']) ?></th>
<th style="white-space:nowrap;<?= $class_td?>"><?= number_format($all['price_diff']) ?></th>
<th style="white-space:nowrap;<?= $class_td?>"><?= number_format($all['price_diff_personal']) ?></th>
</tr>
                                       <tr>
                                    <td colspan="11" class="text_center" style="text-align: center;"><input type="submit" value="確認画面へ" /></td>
                                </tr>

</table>
                                <br /></form>								</div>
							</div><!-- End .box -->
						</div><!-- End .span12 -->
					</div><!-- End .row-fluid -->

            <?php
                                }else{
            /**
            * 案件順 こっちがデフォルト
            */


                                ?>
<table id="DnDTable" cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered table-condensed" width="100%">
<thead><tr>

<th style="white-space:nowrap;"><a href="./?<?= Array_func::GETquery(array('type'))?>&type=sortproject">案件<br />ID</a></th>
<th style="white-space:nowrap;"><a href="./?<?= Array_func::GETquery(array('type'))?>&type=sortstaff">社員名/<br />担当種別</a></th>
<th style="white-space:nowrap;">契約日</th>
    <th style="white-space:nowrap;">PV,EQ,IH</th>
<th style="white-space:nowrap;">メーカー</th>
<th style="white-space:nowrap;">お客様名</th>
<th style="white-space:nowrap;width:60px;">Kw</th>
<th style="white-space:nowrap;">売上金額<br />（支払済金額）</th>
<th style="white-space:nowrap;">仕切金額</th>
<th style="white-space:nowrap;">利益額</th>
<th style="white-space:nowrap;">歩合(%)</th>
<th style="white-space:nowrap;">歩合<br />合計(%)</th>
<th style="white-space:nowrap;">メモ</th>
</tr></thead>

<tbody>
<?php
for($i = 1;$i<=30;$i++){
    $id = (int)($i / 3+0.9);
    $kw = (int)($id * 100);
    $rowspan_judge = $id;

    $price = ($id % 3 + 1) * 100000;
    $price_complete = $price;//支払い済みはとりえずは全額
    $price_2 = ($id % 3 + 1) * 60000;
    $price_diff = $price - $price_2;
    $price_diff_koji = (int)($price - $price_2) * 0.8;
    $price_diff_seichi = (int)($price - $price_2) * 0.2;

    $all['price'] += $price;
    $all['price_complete'] += $price_complete;
    $all['price_2'] += $price_2;
    $all['price_diff'] += $price_diff;
    $all['price_diff_koji'] += $price_diff_koji;
    $all['price_diff_seichi'] += $price_diff_seichi;

    if($before_id != $id){
        $class_td = <<<HTML
 border-top:solid 2px #000000;
HTML;
        $rows_td = <<<HTML
<td id="total_percent{$rowspan_judge}" style="{$class_td}" rowspan="3"></td>
<td style="{$class_td}" rowspan="3"><textarea name="" id="" cols="30" rows="10" class="input-mini"></textarea></td>
HTML;

        //利益額
        $price_diff_format = number_format($price_diff);
        $price_diff_koji_format = number_format($price_diff_koji);
        $price_diff_seichi_format = number_format($price_diff_seichi);
        $rows_td2 = <<<HTML
        <td style="{$class_td}" class="ws_nowrap" rowspan="3">
        <span class="diff_koji">工事：{$price_diff_koji_format} <br /></span>
        <span class="diff_seichi">整地：{$price_diff_seichi_format} <br /></span>
        <span class="diff">利益：{$price_diff_format}</span>
        </td>
HTML;
    }else{
        $class_td = <<<HTML

HTML;
        $rows_td = "";
        $rows_td2 = "";


    }
    $before_id = $id;
    $date_obj = new datetime("2015-12-".sprintf("%02d",$id+3));
    $staff_key = $i % 3 + 1;
    $office_key = $i % 6 + 1;
    $i_2 = $i + ($i * $i);

;

    $staff_typekey = $i % 4 + 1;
    $type_staff = $GLOBALS["MASTER"]['tanto_type'][$staff_typekey];
    ?>
    <tr id="<?= $i ?>">
	<td style="<?= $class_td?>"><?= $id ?></td>
	<td style="white-space: nowrap;<?= $class_td?>"><?= $GLOBALS["MASTER"]['staff_list'][$staff_key] ?><br />(<?= $type_staff ?>)</td>
	<td style="white-space: nowrap;<?= $class_td?>"><?= $date_obj->format('Y-m-d') ?></td>
        <td style="<?= $class_td?>">
        ○,なし、EQ
	</td>
        	<td style="<?= $class_td?>"><?= $GLOBALS["MASTER"]['maker_list'][$id] ?></td>
	<td style="<?= $class_td?>"><a href="./?req=project_regi&id=10" target="_blank"><?= $GLOBALS["MASTER"]['incentive_customer'][$id] ?></a></td>
	<td style="<?= $class_td?>"><?= $kw ?>Kw</td>

	<td style="<?= $class_td?>"><?= number_format($price) ?><br />
（<?= number_format($price_complete) ?>）</td>
	<td style="<?= $class_td?>"><?= number_format($price_2) ?></td>
<?= $rows_td2 ?>
        <td style="<?= $class_td?>"><input type="text" name="incentive[<?= $i ?>]" id="incentive[<?= $i ?>]" class="input-mini ime_off judge<?=$rowspan_judge?>" onchange="total('judge<?=$rowspan_judge?>','total_percent<?=$rowspan_judge?>');" /></td>
<?= $rows_td?>

</tr>
<?php
}
?>
</tbody>
<tr>

<th style="white-space:nowrap;<?= $class_td?>">合計</th>
<th style="white-space:nowrap;<?= $class_td?>"></th>
<th style="white-space:nowrap;<?= $class_td?>"></th>
<th style="white-space:nowrap;<?= $class_td?>"></th>
<th style="white-space:nowrap;<?= $class_td?>"></th>
<th style="white-space:nowrap;<?= $class_td?>"></th>
<th style="white-space:nowrap;<?= $class_td?>"></th>
<th style="white-space:nowrap;<?= $class_td?>"><?= number_format($all['price']) ?><br />
（<?= number_format($all['price_complete']) ?>）</th>
<th style="white-space:nowrap;<?= $class_td?>"><?= number_format($all['price_2']) ?></th>
<th style="white-space:nowrap;<?= $class_td?>">
            <span class="diff_koji">工事：<?=number_format($all['price_diff_koji']) ?> <br /></span>
        <span class="diff_seichi">整地：<?=number_format($all['price_diff_seichi']) ?> <br /></span>
        <span class="diff">利益：<?=number_format($all['price_diff']) ?><br /></span>
</th>
    <th></th>
    <th></th>
    <th></th>
</tr>
                                       <tr>
                                    <td colspan="14" class="text_center" style="text-align: center;"><input type="submit" value="確認画面へ" /></td>
                                </tr>

</table>
                                <br /></form>								</div>
							</div><!-- End .box -->
						</div><!-- End .span12 -->
					</div><!-- End .row-fluid -->

                <?php
                                }
                }
                ?>
				<!-- Page end here -->
			</div><!-- End contentwrapper -->
		</div><!-- End #content -->
        </div><!-- End #wrapper -->
        <script type="text/javascript">

            function total(class_name,id_name){
                var elements = document.getElementsByClassName( class_name ) ;
                var var_num = 0;
                var Snumber = 0;
                for (var i = 0, len = elements.length; i < len; i++) {
                    if(isNaN(elements[i].value) === true){
                        alert('歩合は半角整数で入力して下さい。');
                    }
                    if(isNaN(elements[i].value) === false && elements[i].value){
                        Snumber = parseInt(elements[i].value);
                    var_num += Snumber;
                    }
                }
                document.getElementById(id_name).innerHTML = var_num + '%';
if(var_num > 100){
    alert('歩合が100%を超えています。');
}


            }
        </script>
    <?php

    }


}