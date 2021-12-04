<?php


class total extends default_admin_class
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
					<h3>社員別売上集計</h3>
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
                                    <td><input type="text" name="" id="" /></td>
                                </tr>
                                 <tr>
                                    <th>
                                        担当社員名
                                    </th>
                                    <td><input type="text" name="" id="" /></td>
                                </tr>
   <tr>
                                    <th>
                                        所属事業所
                                    </th>
                                    <td>
                                           <select name="office" id="office">
                                            <option value=""></option>
                                               <?php
                                               Form::pulldown_write_usekey($GLOBALS["MASTER"]['office'],$GLOBALS['GET']['office']);
                                               ?>
                                            </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        対象完工期間  <span class="komered">※</span>

                                    </th>
                                    <td>
<?= template_admin::calendar_selectbox("keiyakudate_from", $GLOBALS['GET']) ?>
                                        ～
                                        <?= template_admin::calendar_selectbox("keiyakudate_to", $GLOBALS['GET']) ?>
                                    </td>
                                </tr>

                                <tr>
                                    <th>
                                        入金ステータス
                                    </th>
                                     <td>
<?php
$array = array(
    0 => "全て",
    1 => "入金済みの金額のみを対象とする",
);
if(isset($GLOBALS['GET']['status_pay']) === false){
    $GLOBALS['GET']['status_pay'] = 0;
}
Form::radio_button_write_usekey("status_pay",$array,$GLOBALS['GET']['status_pay']);
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
                                 <div class="text_right padding_10px">

                        <button type="button" class="btn-primary btn" onclick="window.open('./?req=total_csv')">CSVダウンロード</button>
                    </div>
<table id="DnDTable" cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered table-condensed" width="100%">
<thead><tr>

<th style="white-space:nowrap;">社員ID</th>
<th style="white-space:nowrap;">所属事業所</th>
<th style="white-space:nowrap;">社員名</th>
<th style="white-space:nowrap;">売上金額</th>
<th style="white-space:nowrap;">仕切金額</th>
<th style="white-space:nowrap;">利益額</th>
</tr></thead>

<tbody>
<?php
for($i = 1;$i<=30;$i++){
    $status_key = $i % 3 + 1;
    $office_key = $i % 6 + 1;
    $i_2 = $i + ($i * $i);

    $price = ($i % 3 + 1) * 100000;
    $price_koji = (int)$price * 0.8;
    $price_seichi = (int)$price * 0.2;

    $price_2 = ($i % 3 + 1) * 60000;
    $price_2_koji = (int)$price_2 * 0.8;
    $price_2_seichi = (int)$price_2 * 0.2;


    $price_diff = $price - $price_2;
    $price_diff_koji = (int)($price - $price_2) * 0.8;
    $price_diff_seichi = (int)($price - $price_2) * 0.2;

    $all['price'] += $price;
    $all['price_koji'] += $price_koji;
    $all['price_seichi'] += $price_seichi;

    $all['price_2'] += $price_2;
    $all['price_2_koji'] += $price_2_koji;
    $all['price_2_seichi'] += $price_2_seichi;

    $all['price_diff'] += $price_diff;
    $all['price_diff_koji'] += $price_diff_koji;
    $all['price_diff_seichi'] += $price_diff_seichi;

    if($status_key == 2){
        $span = <<<HTML
<span style="color:red">
HTML;
        $spanc = <<<HTML
</span>
HTML;


    }else{
        $span = <<<HTML

HTML;
        $spanc = <<<HTML

HTML;
    }
    $price_diff_format = number_format($price_diff);
    $price_diff_koji_format = number_format($price_diff_koji);
    $price_diff_seichi_format = number_format($price_diff_seichi);
    ?>
    <tr id="<?= $i ?>">
	<td><?= $i_2 ?></td>
	<td><?= $GLOBALS["MASTER"]['office'][$office_key] ?></td>
	<td><a href="./?req=<?= $GLOBALS['GET']['req']?>&mode=personal&id=<?= $status_key?>"><?= $GLOBALS["MASTER"]['staff_list'][$status_key] ?></a></td>
	<td>
                        <span class="diff_koji">工事：<?=number_format($price_koji)?> <br /></span>
        <span class="diff_seichi">整地：<?=number_format($price_seichi)?> <br /></span>
        <span class="diff">合計：<?=number_format($price)?><br /></span>
	</td>
	<td>
                 <span class="diff_koji">工事：<?=number_format($price_2_koji)?> <br /></span>
        <span class="diff_seichi">整地：<?=number_format($price_2_seichi)?> <br /></span>
        <span class="diff">合計：<?=number_format($price_2)?><br /></span>
	</td>
	<td>
                <span class="diff_koji">工事：<?=$price_diff_koji_format?> <br /></span>
        <span class="diff_seichi">整地：<?=$price_diff_seichi_format?> <br /></span>
        <span class="diff">合計：<?=$price_diff_format?><br /></span>
	</td>

        </td>
</tr>
<?php
}
?>
</tbody>
<tfoot><tr>

<th style="white-space:nowrap;">合計</th>
<th style="white-space:nowrap;"></th>
<th style="white-space:nowrap;"></th>
<th style="white-space:nowrap;">
       <span class="diff_koji">工事：<?=number_format($all['price_koji'])?> <br /></span>
        <span class="diff_seichi">整地：<?=number_format($all['price_seichi'])?> <br /></span>
        <span class="diff_seichi">合計：<?=number_format($all['price'])?> <br /></span>
</th>
<th style="white-space:nowrap;">
           <span class="diff_koji">工事：<?=number_format($all['price_2_koji'])?> <br /></span>
        <span class="diff_seichi">整地：<?=number_format($all['price_2_seichi'])?> <br /></span>
        <span class="diff_seichi">合計：<?=number_format($all['price_2'])?> <br /></span>
</th>
<th style="white-space:nowrap;">
       <span class="diff_koji">工事：<?=number_format($all['price_diff_koji'])?> <br /></span>
        <span class="diff_seichi">整地：<?=number_format($all['price_diff_seichi'])?> <br /></span>
        <span class="diff_seichi">合計：<?=number_format($all['price_diff'])?> <br /></span>
</tr></tfoot>

</table>
                                <br /></form>								</div>
							</div><!-- End .box -->
						</div><!-- End .span12 -->
					</div><!-- End .row-fluid -->

                <?php
                }
                ?>

                <!-- Page end here -->
			</div><!-- End contentwrapper -->
		</div><!-- End #content -->
        </div><!-- End #wrapper -->
        <script type="text/javascript">

        </script>
    <?php

    }


    function personal(){
        ?>
        <!--Body content-->
        <div id="content" class="clearfix">
			<div class="contentwrapper"><!--Content wrapper-->
				<div class="heading">
					<h3>売上集計 [<?= $GLOBALS["MASTER"]['staff_list'][$GLOBALS['GET']['id']] ?>](社員ID:<?= $GLOBALS['GET']['id']?>)</h3>
<div class="text_right padingT10">
    <button type="button" class="btn-navbar btn" onclick="history.back();">戻る</button>
</div>
				<!-- Build page from here: Usual with <div class="row-fluid"></div> -->

                <?php
                if($GLOBALS['GET']['id']){
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
                                 <div class="text_right padding_10px">

                        <button type="button" class="btn-primary btn" onclick="window.open('./?req=total_personal_csv')">CSVダウンロード</button>
                    </div>
<table id="DnDTable" cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered table-condensed" width="100%">
<thead><tr>

<th style="white-space:nowrap;">完工日</th>
<th style="white-space:nowrap;">案件ID</th>
<th style="white-space:nowrap;">売上金額</th>
<th style="white-space:nowrap;">仕切り金額</th>
<th style="white-space:nowrap;">利益額</th>
<th style="white-space:nowrap;">未払い金額</th>
</tr></thead>

<tbody>
<?php
for($i = 1;$i<=30;$i++){
    $status_key = $i % 3 + 1;
    $office_key = $i % 6 + 1;
    $i_2 = $i + ($i * $i);

//    $price = ($i % 3 + 1) * 100000;
//    $price_2 = ($i % 3 + 1) * 60000;
//    $price_diff = $price - $price_2;
//
//    $all['price'] += $price;
//    $all['price_2'] += $price_2;
//    $all['price_diff'] += $price_diff;
//    $all['price_nopay'] += $price_nopay;

    if($i == 5){
    $price_nopay = 35000;

    }else{
    $price_nopay = 0;

    }

    $price = ($i % 3 + 1) * 100000;
    $price_koji = (int)$price * 0.8;
    $price_seichi = (int)$price * 0.2;

    $price_2 = ($i % 3 + 1) * 60000;
    $price_2_koji = (int)$price_2 * 0.8;
    $price_2_seichi = (int)$price_2 * 0.2;


    $price_diff = $price - $price_2;
    $price_diff_koji = (int)($price - $price_2) * 0.8;
    $price_diff_seichi = (int)($price - $price_2) * 0.2;

    $all['price'] += $price;
    $all['price_koji'] += $price_koji;
    $all['price_seichi'] += $price_seichi;

    $all['price_2'] += $price_2;
    $all['price_2_koji'] += $price_2_koji;
    $all['price_2_seichi'] += $price_2_seichi;

    $all['price_diff'] += $price_diff;
    $all['price_diff_koji'] += $price_diff_koji;
    $all['price_diff_seichi'] += $price_diff_seichi;

    $price_diff_format = number_format($price_diff);
    $price_diff_koji_format = number_format($price_diff_koji);
    $price_diff_seichi_format = number_format($price_diff_seichi);

    $date_obj = new datetime("2015-12-".sprintf("%02d",$i));
    if($status_key == 2){
        $span = <<<HTML
<span style="color:red">
HTML;
        $spanc = <<<HTML
</span>
HTML;


    }else{
        $span = <<<HTML

HTML;
        $spanc = <<<HTML

HTML;
    }
    ?>
    <tr id="<?= $i ?>">
	<td><?= $date_obj->format('Y-m-d') ?></td>
	<td><?= $i ?></td>

<td>
                        <span class="diff_koji">工事：<?=number_format($price_koji)?> <br /></span>
        <span class="diff_seichi">整地：<?=number_format($price_seichi)?> <br /></span>
        <span class="diff">合計：<?=number_format($price)?><br /></span>
	</td>
	<td>
                 <span class="diff_koji">工事：<?=number_format($price_2_koji)?> <br /></span>
        <span class="diff_seichi">整地：<?=number_format($price_2_seichi)?> <br /></span>
        <span class="diff">合計：<?=number_format($price_2)?><br /></span>
	</td>
	<td>
                <span class="diff_koji">工事：<?=$price_diff_koji_format?> <br /></span>
        <span class="diff_seichi">整地：<?=$price_diff_seichi_format?> <br /></span>
        <span class="diff">合計：<?=$price_diff_format?><br /></span>
	</td>
	<td><?= number_format($price_nopay) ?></td>

        </td>
</tr>
<?php
}
?>
</tbody>
<tfoot><tr>

<th style="white-space:nowrap;">合計</th>
<th style="white-space:nowrap;"></th>
<th style="white-space:nowrap;">
       <span class="diff_koji">工事：<?=number_format($all['price_koji'])?> <br /></span>
        <span class="diff_seichi">整地：<?=number_format($all['price_seichi'])?> <br /></span>
        <span class="diff_seichi">合計：<?=number_format($all['price'])?> <br /></span>
</th>
<th style="white-space:nowrap;">
           <span class="diff_koji">工事：<?=number_format($all['price_2_koji'])?> <br /></span>
        <span class="diff_seichi">整地：<?=number_format($all['price_2_seichi'])?> <br /></span>
        <span class="diff_seichi">合計：<?=number_format($all['price_2'])?> <br /></span>
</th>
<th style="white-space:nowrap;">
       <span class="diff_koji">工事：<?=number_format($all['price_diff_koji'])?> <br /></span>
        <span class="diff_seichi">整地：<?=number_format($all['price_diff_seichi'])?> <br /></span>
        <span class="diff_seichi">合計：<?=number_format($all['price_diff'])?> <br /></span>
<th style="white-space:nowrap;"><?= number_format($all['price_nopay']) ?></th>
</tr></tfoot>

</table>
                                <br /></form>								</div>
							</div><!-- End .box -->
						</div><!-- End .span12 -->
					</div><!-- End .row-fluid -->

                <?php
                }
                ?>

                <!-- Page end here -->
			</div><!-- End contentwrapper -->
		</div><!-- End #content -->
        </div><!-- End #wrapper -->
        <script type="text/javascript">

        </script>
    <?php

    }


}