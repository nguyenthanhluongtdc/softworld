<?php


class payment_search extends default_admin_class
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
					<h3>入金状況検索</h3>
<div class="search_open">
   <a id="opener"><?= SEARCH_FORM_LINK_DEFAULT ?></a>
</div>
				</div><!-- End .heading-->
            <div class="content_border">
							<table class="search_form_table">
                                 <tr>
                                    <th>
                                        入金ステータス
                                    </th>
                                     <td>
<?php
foreach ($GLOBALS["MASTER"]['payment_status'] as $key1 => $value1) {
$payment_status[$key1] = $value1."有　";
}

Form::checkbox_write_usekey("status",$payment_status,$GLOBALS['GET']['status']);
?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        入金予定日

                                    </th>
                                    <td>
<?= template_admin::calendar_selectbox("keiyakudate_from", $GLOBALS['GET']) ?>
                                        ～
                                        <?= template_admin::calendar_selectbox("keiyakudate_to", $GLOBALS['GET']) ?>
                                    </td>
                                </tr>
                                  <tr>
                                    <th>
                                        お客様氏名
                                    </th>
                                    <td><input type="text" name="" id="" /></td>
                                </tr>
                                <tr>
                                    <th>
                                        お客様住所
                                    </th>
                                    <td><select name="prefecture" id="prefecture">
                                            <option value=""></option>
                                            <?php
                                            Form::pulldown_write_usekey($GLOBALS["MASTER"]["prefecture_list"],$GLOBALS['GET']['prefecture']);
                                            ?>
                                            </select><input type="text" name="" id="" /></td>
                                </tr>
                                 <tr>
                                    <th>
                                        お客様電話番号
                                    </th>
                                    <td><input type="text" name="" id="" /></td>
                                </tr>
                                <tr>
                                    <th>
                                        担当社員ID
                                    </th>
                                    <td><input type="text" name="" id="" /></td>
                                </tr>




                                <tr>
                                    <td colspan="2" class="text_center"><input type="submit" value="検索" /></td>
                                </tr>
							</table>
							</div>
				<!-- Build page from here: Usual with <div class="row-fluid"></div> -->

				<div class="row-fluid">
					<div class="span12">
						<div class="box gradient">

							<div class="title">

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
<div class="center">
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

<th style="white-space:nowrap;">お客様名</th>
<th style="white-space:nowrap;">住所</th>
<th style="white-space:nowrap;">担当者</th>
<th style="white-space:nowrap;">入金ステータス</th>
<th style="white-space:nowrap;">更新年月日</th>
<th style="white-space:nowrap;">登録者</th>
<th style="white-space:nowrap;">編集</th>
</tr></thead>

<tbody>
<?php
for($i = 1;$i<=30;$i++){
    $status_key = $i % 3 + 1;

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
	<td>篠田 康平</td>
	<td>栃木県足利市今福町1-2-5</td>
	<td>山田 次郎、浅田 五郎</td>
	<td><?= $span.$GLOBALS["MASTER"]['payment_status'][$status_key] .$spanc ?></td>
	<td>2015/12/<?= sprintf("%02d",31 -$i)?> 08:55</td>
	<td>山田 次郎</td>
        <td style="text-align:center;"><button type="button" class="btn-success btn" onclick="location.href='.?req=project_regi&id=100#payment'">編集</button>

        </td>
</tr>
    <?php
}
?>
</tbody>
<tfoot><tr>

<th style="white-space:nowrap;">お客様名</th>
<th style="white-space:nowrap;">住所</th>
<th style="white-space:nowrap;">担当者</th>
<th style="white-space:nowrap;">ステータス</th>
<th style="white-space:nowrap;">更新年月日</th>
<th style="white-space:nowrap;">登録者</th>
<th style="white-space:nowrap;">編集/削除</th>
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
        <script type="text/javascript">

        </script>
    <?php

    }


}