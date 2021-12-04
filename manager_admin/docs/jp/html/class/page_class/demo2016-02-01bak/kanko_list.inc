<?php


class kanko_list extends default_admin_class
{
    var $before_date_y;

    function __construct()
    {

        parent::__construct();

        $this->search_ym = $GLOBALS['GET']['date_y'] . "-" . sprintf("%02d", $GLOBALS['GET']['date_m']);
        $this->search_yymmmm = $GLOBALS['GET']['date_y'] . "" . sprintf("%02d", $GLOBALS['GET']['date_m']);
    }

    function main(){

        if(!$GLOBALS['GET']['year'] || !$GLOBALS['GET']['month'] ){
            $GLOBALS['GET']['year'] = $GLOBALS['datetime_now_obj']->format('Y');
            $GLOBALS['GET']['month'] = $GLOBALS['datetime_now_obj']->format('m');
        }
        $b_obj = new datetime($GLOBALS['GET']['year']."-".$GLOBALS['GET']['month']."-01");
        $b_obj->modify("-1 month");
        $b_y = $b_obj->format('Y');
        $b_m = $b_obj->format('m');
        $b = <<<HTML
year={$b_y}&month={$b_m}
HTML;

        $n_obj = new datetime($GLOBALS['GET']['year']."-".$GLOBALS['GET']['month']."-01");
        $n_obj->modify("+1 month");
        $n_y = $n_obj->format('Y');
        $n_m = $n_obj->format('m');
        $n = <<<HTML
year={$n_y}&month={$n_m}
HTML;

        ?>
        <!--Body content-->
        <div id="content" class="clearfix">
			<div class="contentwrapper"><!--Content wrapper-->
				<div class="heading">
					<h3>定期点検リスト</h3>

				</div><!-- End .heading-->
				<!-- Build page from here: Usual with <div class="row-fluid"></div> -->
完工日から1,5,9,13年を迎える案件のリストです。
				<div class="row-fluid">
					<div class="span12">
						<div class="box gradient">

							<div class="title">

                                <table style="width: 100%;">
                                    <tr>
                                        <td style="width: 33%;text-align: left;">  <a href="./?<?= Array_func::GETquery(array())?>&<?= $b?>"><< 前の月へ</a></td>
                                        <td style="width: 33%;text-align: center;"><h4>
								<?= $GLOBALS['GET']['year'] ?> 年 <?= $GLOBALS['GET']['month'] ?> 月
								</h4></td>
                                        <td style="width: 33%;text-align: right;">  <a href="./?<?= Array_func::GETquery(array())?>&<?= $n?>">次の月へ >></a></td>
                                    </tr>
                                </table>

							</div>
							<div class="content noPad clearfix" id="DataArea">
<table id="DnDTable" cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered table-condensed" width="100%">
<thead><tr>

<th style="white-space:nowrap;">1年</th>
<th style="white-space:nowrap;">完工日</th>
<th style="white-space:nowrap;">5年</th>
<th style="white-space:nowrap;">完工日</th>
<th style="white-space:nowrap;">9年</th>
<th style="white-space:nowrap;">完工日</th>
<th style="white-space:nowrap;">13年</th>
<th style="white-space:nowrap;">完工日</th>
</tr></thead>

<tbody>
<?php
for($i = 1;$i<=30;$i++){
    $status_key = $i % 5;

    if($i > 10){
        $display = <<<HTML
 style="display:none;"
HTML;
    }

        if($i > 19){
            $display2 = <<<HTML
 style="display:none;"
HTML;

    }
    ?>
    <tr id="<?= $i ?>">
	<td><a href=".?req=project_regi&id=100">篠田 康平</a></td>
	<td>2014/12/<?= sprintf("%02d",31 -$i)?> </td>
        <td<?= $display2?>><a href=".?req=project_regi&id=100">篠田 康平</a></td>
	<td<?= $display2?>>2010/12/<?= sprintf("%02d",31 -$i)?> </td>
        <td<?= $display?>><a href=".?req=project_regi&id=100">篠田 康平</a></td>
	<td<?= $display?>>2006/12/<?= sprintf("%02d",31 -$i)?> </td>
        <td<?= $display?>><a href=".?req=project_regi&id=100">篠田 康平</a></td>
	<td<?= $display?>>2002/12/<?= sprintf("%02d",31 -$i)?> </td>
        </td>
</tr>
    <?php
}
?>
</tbody>
<tfoot><tr>

<th style="white-space:nowrap;">1年</th>
<th style="white-space:nowrap;">完工日</th>
<th style="white-space:nowrap;">5年</th>
<th style="white-space:nowrap;">完工日</th>
<th style="white-space:nowrap;">9年</th>
<th style="white-space:nowrap;">完工日</th>
<th style="white-space:nowrap;">13年</th>
<th style="white-space:nowrap;">完工日</th>
</tr></tfoot>

</table><br /><div class="center">

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