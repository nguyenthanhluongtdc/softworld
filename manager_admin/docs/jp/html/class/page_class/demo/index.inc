<?php


class index extends default_admin_class
{
    var $before_date_y;

    function __construct()
    {
        parent::__construct();
    }

    function main(){
        ?>
        <!--Body content-->
        <div id="content" class="clearfix">
			<div class="contentwrapper"><!--Content wrapper-->
				<div class="heading">
					<h3>管理画面トップ 案件変更履歴 未承認一覧</h3>
					<div class="resBtnSearch">
						<a href="#"><span class="icon16 icomoon-icon-search-3"></span></a>
					</div>

				</div><!-- End .heading-->

                承認をしなければいけない案件変更届があります。下記から変更内容を確認して、承認を行って下さい。



                				<div class="row-fluid">
					<div class="span12">
						<div class="box gradient">

							<div class="title">
								<h4>
									<span>件数：84件</span>
								</h4>
							</div>
							<div class="content noPad clearfix" id="DataArea">
<div class="center">
	<div class="pagination">
		<ul>
			<li class="active"><a href="#">1</a></li>
			<li><a href="#">2</a></li>
			<li><a href="#">3</a></li>
			<li><a href="#">4</a></li>
			<li><a href="#">5</a></li>
			<li><a href="#"><span class="icon12 minia-icon-arrow-right-2"></span></a></li>
			<li><a href="#"><span class="icon12 minia-icon-arrow-down-2"></span></a></li>
		</ul>
	</div>
</div>
<table id="DnDTable" cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered table-condensed" width="100%">
<thead><tr>
<th style="white-space:nowrap;width: 100px;">お客様名</th>
<th style="white-space:nowrap;">住所</th>
<th style="white-space:nowrap;">変更日</th>
<th style="white-space:nowrap;">変更箇所</th>
<th style="white-space:nowrap;">内容確認</th>
</tr></thead>
<tbody>
<?php
for($i = 1;$i<=30;$i++){
    ?>
    <tr id="<?= $i ?>">

	<td>佐藤 篤 </td>
	<td>群馬県館林市○○1-1-2</td>
	<td>2016-02-02</td>
	<td>モジュール型式、金額</td>
   <td style="text-align:center;"><button type="button" class="btn-primary btn" onclick="location.href='./?req=change_his&id='">履歴確認</button>

            </td>
</tr>
<?php
}
?>
</tbody>
<tfoot><tr>
<th style="white-space:nowrap;width: 100px;">お客様名</th>
<th style="white-space:nowrap;">住所</th>
<th style="white-space:nowrap;">変更日</th>
<th style="white-space:nowrap;">変更箇所</th>
<th style="white-space:nowrap;">内容確認</th>
</tr></tfoot>

</table><br /><div class="center">
	<div class="pagination">
		<ul>
			<li class="active"><a href="#">1</a></li>
			<li><a href="#">2</a></li>
			<li><a href="#">3</a></li>
			<li><a href="#">4</a></li>
			<li><a href="#">5</a></li>
			<li><a href="#"><span class="icon12 minia-icon-arrow-right-2"></span></a></li>
			<li><a href="#><span class="icon12 minia-icon-arrow-down-2"></span></a></li>
		</ul>
	</div>
</div>
                                </form>								</div>
							</div><!-- End .box -->
						</div><!-- End .span12 -->
					</div>

                </div>
                </div>
        <?php
    }

}