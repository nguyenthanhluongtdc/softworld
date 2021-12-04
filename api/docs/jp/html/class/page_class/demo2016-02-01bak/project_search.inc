<?php


class project_search extends default_admin_class
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
					<h3>案件検索</h3>
<div class="search_open">
    <a id="opener"><?= SEARCH_FORM_LINK_DEFAULT ?></a>
</div>
				</div><!-- End .heading-->
            <div class="content_border">
							<table class="search_form_table">
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
                                    <th>
                                        担当社員名
                                    </th>
                                    <td><input type="text" name="" id="" /></td>
                                </tr>

                                <tr>
                                    <th>
                                        契約日

                                    </th>
                                    <td>
<?= template_admin::calendar_selectbox("keiyakudate_from", $GLOBALS['GET']) ?>
                                     ～
<?= template_admin::calendar_selectbox("keiyakudate_to", $GLOBALS['GET']) ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        現調日
                                    </th>
                                     <td>
<?= template_admin::calendar_selectbox("checkdate_from", $GLOBALS['GET']) ?>
                                         ～
                                         <?= template_admin::calendar_selectbox("checkdate_to", $GLOBALS['GET']) ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        完工日
                                    </th>
                                     <td>
<?= template_admin::calendar_selectbox("enddate_from", $GLOBALS['GET']) ?>
                                         ～
                                         <?= template_admin::calendar_selectbox("enddate_to", $GLOBALS['GET']) ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        ステータス
                                    </th>
                                     <td>
<?php

Form::checkbox_write_inkey("status",$GLOBALS["MASTER"]['project_status'],Array_func::array_key_to_value($GLOBALS["MASTER"]['project_status']),$GLOBALS['GET']['status']);
?>
                                    </td>
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
<th style="white-space:nowrap;">ステータス</th>
<th style="white-space:nowrap;">更新年月日</th>
<th style="white-space:nowrap;">登録者</th>
<th style="white-space:nowrap;">編集/削除</th>
</tr></thead>

<tbody>
<?php
for($i = 1;$i<=30;$i++){
    $status_key = $i % 5;
    ?>
    <tr id="<?= $i ?>">
	<td>篠田 康平</td>
	<td>栃木県足利市今福町1-2-5</td>
	<td>山田 次郎、浅田 五郎</td>
	<td><?= $GLOBALS["MASTER"]['project_status'][$status_key] ?></td>
	<td>2015/12/<?= sprintf("%02d",31 -$i)?> 08:55</td>
	<td>山田 次郎</td>
        <td style="text-align:center;"><button type="button" class="btn-success btn" onclick="location.href='.?req=project_regi&id=100'">編集</button>
        <button type="button" class="btn-danger btn" onclick="return window.confirm('削除してもよろしいですか？');location.href='.?req=<?= $GLOBALS['GET']['req']?>'">削除</button>
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