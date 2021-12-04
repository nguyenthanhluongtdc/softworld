<?php


class staff_search extends default_admin_class
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
					<h3>社員検索</h3>
<div class="search_open">
    <a id="opener"><?= SEARCH_FORM_LINK_DEFAULT ?></a>
</div>
				</div><!-- End .heading-->
            <div class="content_border">
                    <form action="./">
                    <input type="hidden" name="req" value="<?= $GLOBALS['GET']['req'] ?>" />
							<table class="search_form_table">
                                <tr>
                                    <th>
                                        社員ID
                                    </th>
                                    <td><input type="text" name="" id="" /></td>
                                </tr>
                                 <tr>
                                    <th>
                                        社員名
                                    </th>
                                    <td><input type="text" name="" id="" /></td>
                                </tr>
                                <tr>
                                    <th>
                                        事業所名
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
                                        部署
                                    </th>
                                    <td>
                                        <select name="busho" id="busho">
                                            <option value=""></option>
                                            <?php
                                            Form::pulldown_write_usekey($GLOBALS["MASTER"]['busho'],$GLOBALS['GET']['busho']);
                                            ?>
                                            </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        電話番号
                                    </th>
                                    <td><input type="text" name="" id="" /></td>
                                </tr>
                                <tr>
                                    <th>
                                        メールアドレス
                                    </th>
                                    <td><input type="text" name="" id="" /></td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="text_center"><input type="submit" value="検索" /></td>
                                </tr>
							</table>
                        </form>
							</div>
				<!-- Build page from here: Usual with <div class="row-fluid"></div> -->

				<div class="row-fluid">
					<div class="span12">
						<div class="box gradient">

							<div class="title">

								<h4>
									<span>件数：84件</span>

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
<th width="40" style="white-space:nowrap;">事業所</th>
<th style="white-space:nowrap;">部署</th>
<th style="white-space:nowrap;">社員名</th>
<th style="white-space:nowrap;">電話番号</th>
<th style="white-space:nowrap;">住所</th>
<th style="white-space:nowrap;">メールアドレス</th>
<th style="white-space:nowrap;">編集/削除</th>
</tr></thead>

<tbody>
<?php
for($i = 1;$i<=30;$i++){
    ?>
    <tr id="<?= $i ?>">

	<td>館林</td>
	<td>企画</td>
	<td>山田 次郎</td>
	<td>080-0000-0000</td>
	<td>群馬県館林市○○1-1-2</td>
	<td><a href="mailto:test@test.com">test@test.com</a></td>
        	<td style="text-align:center;"><button type="button" class="btn-success btn" onclick="location.href='.?req=staff_regi&id=100'">編集</button>
            <button type="button" class="btn-danger btn" onclick="return window.confirm('削除してもよろしいですか？');location.href='.?req=<?= $GLOBALS['GET']['req']?>'">削除</button>
            </td>
</tr>
    <?php
}
?>
</tbody>
<tfoot><tr>
<th width="40" style="white-space:nowrap;">編集</th>
<th width="40" style="white-space:nowrap;">事業所</th>
<th style="white-space:nowrap;">部署</th>
<th style="white-space:nowrap;">社員名</th>
<th style="white-space:nowrap;">電話番号</th>
<th style="white-space:nowrap;">住所</th>
<th style="white-space:nowrap;">メールアドレス</th>
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