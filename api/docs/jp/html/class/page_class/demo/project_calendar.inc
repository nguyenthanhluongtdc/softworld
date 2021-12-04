<?php


class project_calendar extends default_admin_class
{
    var $before_date_y;

    function __construct()
    {

        parent::__construct();
if($GLOBALS['GET']['date_y']){
        $this->search_y = $GLOBALS['GET']['date_y'];
}else{
    $this->search_y = $GLOBALS['datetime_now_obj']->format('Y');
}
        if($GLOBALS['GET']['date_m']){
        $this->search_m = sprintf("%02d", $GLOBALS['GET']['date_m']);
        }else{
        $this->search_m = $GLOBALS['datetime_now_obj']->format('m');
        }

        $this->next_obj = new datetime($this->search_y."-".$this->search_m."-01");
        $this->next_obj->modify('+1 month');


        $this->before_obj = new datetime($this->search_y."-".$this->search_m."-01");
        $this->before_obj->modify('-1 month');






    }

    function main(){
        ?>
        <!--Body content-->
        <div id="content" class="clearfix">
			<div class="contentwrapper"><!--Content wrapper-->
				<div class="heading">
					<h3>スケジュール</h3>
<div class="search_open">
<!--    <a id="opener">--><?//= SEARCH_FORM_LINK_DEFAULT ?><!--</a>-->
</div>
				</div><!-- End .heading-->
            <div class="content_border">
							<table class="search_form_table">
                                  <tr>
                                    <th>
                                        期間指定
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
                                        日程タイプ
                                    </th>
                                    <td><select name="cal_type" id="cal_type">
                                            <option value=""></option>
                                            <?php
                                            Form::pulldown_write_usekey($GLOBALS["MASTER"]['cal_type'],$GLOBALS['GET']['cal_type']);
                                            ?>
                                            </select>
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

							<div class="row-fluid">
		<div class="span12">
		<!-- BEGIN EXAMPLE TABLE PORTLET-->
		<!-- END EXAMPLE TABLE PORTLET-->
						<table width="100%"  border="0" cellspacing="0" cellpadding="5">
						<tr>
				<td colspan="3">スケジュールを確認したい月を選択して下さい。</td>
				</tr>
				<tr>
				<td width="33%"><a href="./?req=<?= $GLOBALS['GET']['req']?>&date_y=<?= $this->before_obj->format('Y') ?>&date_m=<?= $this->before_obj->format('m') ?>">&lt;&lt; 前の月へ</a>
				</td>
				<td width="33%" align="center"><b><?= $this->search_y ?>年<?= $this->search_m?>月</b></td>
				<td width="33%" align="right"><a href="./?req=<?= $GLOBALS['GET']['req']?>&date_y=<?= $this->next_obj->format('Y') ?>&date_m=<?= $this->next_obj->format('m') ?>">次の月へ &gt;&gt;</a></td>
				</tr>
			</table>
			<table width="100%" border="0" cellpadding="5" cellspacing="1" class="calendar_table">
				<tr>
					<td colspan="7" align="center" style="background:#E7E7E7;"><span class="col-bla33-b">現調日</span></td>
				</tr>
			</table>
			<table width="100%" border="0" cellpadding="5" cellspacing="1" class="calendar_table"><tr ><td align="center" class="col-33-bgf8">日</td><td align="center" class="col-33-bgff">月</td><td align="center" class="col-33-bgff">火</td><td align="center" class="col-33-bgff">水</td><td align="center" class="col-33-bgff">木</td><td align="center" class="col-33-bgff">金</td><td class="col-33-bgdc">土</td></tr><tr><td align="center" class="col-33-bgff"> </td><td class="col-33-bgff"><div>1</div><p> </p><p> </p></td><td class="col-33-bgff"><div>2</div><p><a href="./?req=project_regi">田中太郎(2541)</a></p><p> </p></td><td class="col-33-bgff"><div>3</div><p> </p><p> </p></td><td class="col-33-bgff"><div>4</div><p> </p><p> </p></td><td class="col-33-bgff"><div>5</div><p> </p><p> </p></td><td class="col-33-bgdc"><div>6</div><p> </p><p> </p></td></tr><tr><td class="col-33-bgf8"><div>7</div><p> </p><p> </p></td><td class="col-33-bgff"><div>8</div><p> </p><p> </p></td><td class="col-33-bgff"><div>9</div><p> </p><p> </p></td><td class="col-33-bgff"><div>10</div><p> </p><p> </p></td><td class="col-33-bgff"><div>11</div><p> </p><p> </p></td><td class="col-33-bgff"><div>12</div><p> </p><p> </p></td><td class="col-33-bgdc"><div>13</div><p> </p><p> </p></td></tr><tr><td class="col-33-bgf8"><div>14</div><p> </p><p> </p></td><td class="col-33-bgff"><div>15</div><p> </p><p> </p></td><td class="col-33-bgff"><div>16</div><p><a href="./?req=project_regi">小野寺昭(22501)</a></p><p> </p></td><td class="col-33-bgff"><div>17</div><p> </p><p> </p></td><td class="col-33-bgff"><div>18</div><p> </p><p> </p></td><td class="col-33-bgff"><div>19</div><p> </p><p> </p></td><td class="col-33-bgdc"><div>20</div><p> </p><p> </p></td></tr><tr><td class="col-33-bgf8"><div>21</div><p> </p><p> </p></td><td class="col-33-bgff"><div>22</div><p> </p><p> </p></td><td class="col-33-bgff"><div>23</div><p> </p><p> </p></td><td class="col-33-bgff"><div>24</div><p> </p><p> </p></td><td class="col-33-bgff"><div>25</div><p> </p><p> </p></td><td class="col-33-bgff"><div>26</div><p><a href="./?req=project_regi">君島祐司(65)</a></p><p> </p></td><td class="col-33-bgdc"><div>27</div><p> </p><p> </p></td></tr><tr><td class="col-33-bgf8"><div>28</div><p> </p><p> </p></td><td class="col-33-bgff"><div>29</div><p> </p><p> </p></td><td class="col-33-bgff"> </td><td class="col-33-bgff"> </td><td class="col-33-bgff"> </td><td class="col-33-bgff"> </td><td class="col-33-bgff"> </td></tr></table>



        <br />
            	<table width="100%" border="0" cellpadding="5" cellspacing="1" class="calendar_table">
				<tr>
					<td colspan="7" align="center" style="background:#E7E7E7;"><span class="col-bla33-b">工事開始日</span></td>
				</tr>
			</table>
            <table width="100%" border="0" cellpadding="5" cellspacing="1" class="calendar_table"><tr ><td align="center" class="col-33-bgf8">日</td><td align="center" class="col-33-bgff">月</td><td align="center" class="col-33-bgff">火</td><td align="center" class="col-33-bgff">水</td><td align="center" class="col-33-bgff">木</td><td align="center" class="col-33-bgff">金</td><td class="col-33-bgdc">土</td></tr><tr><td align="center" class="col-33-bgff"> </td><td class="col-33-bgff"><div>1</div><p> </p><p> </p></td><td class="col-33-bgff"><div>2</div><p><a href="./?req=project_regi">田中太郎(2541)</a></p><p> </p></td><td class="col-33-bgff"><div>3</div><p> </p><p> </p></td><td class="col-33-bgff"><div>4</div><p> </p><p> </p></td><td class="col-33-bgff"><div>5</div><p> </p><p> </p></td><td class="col-33-bgdc"><div>6</div><p> </p><p> </p></td></tr><tr><td class="col-33-bgf8"><div>7</div><p> </p><p> </p></td><td class="col-33-bgff"><div>8</div><p> </p><p> </p></td><td class="col-33-bgff"><div>9</div><p> </p><p> </p></td><td class="col-33-bgff"><div>10</div><p> </p><p> </p></td><td class="col-33-bgff"><div>11</div><p> </p><p> </p></td><td class="col-33-bgff"><div>12</div><p> </p><p> </p></td><td class="col-33-bgdc"><div>13</div><p> </p><p> </p></td></tr><tr><td class="col-33-bgf8"><div>14</div><p> </p><p> </p></td><td class="col-33-bgff"><div>15</div><p> </p><p> </p></td><td class="col-33-bgff"><div>16</div><p><a href="./?req=project_regi">小野寺昭(22501)</a></p><p> </p></td><td class="col-33-bgff"><div>17</div><p> </p><p> </p></td><td class="col-33-bgff"><div>18</div><p> </p><p> </p></td><td class="col-33-bgff"><div>19</div><p> </p><p> </p></td><td class="col-33-bgdc"><div>20</div><p> </p><p> </p></td></tr><tr><td class="col-33-bgf8"><div>21</div><p> </p><p> </p></td><td class="col-33-bgff"><div>22</div><p> </p><p> </p></td><td class="col-33-bgff"><div>23</div><p> </p><p> </p></td><td class="col-33-bgff"><div>24</div><p> </p><p> </p></td><td class="col-33-bgff"><div>25</div><p> </p><p> </p></td><td class="col-33-bgff"><div>26</div><p><a href="./?req=project_regi">君島祐司(65)</a></p><p> </p></td><td class="col-33-bgdc"><div>27</div><p> </p><p> </p></td></tr><tr><td class="col-33-bgf8"><div>28</div><p> </p><p> </p></td><td class="col-33-bgff"><div>29</div><p> </p><p> </p></td><td class="col-33-bgff"> </td><td class="col-33-bgff"> </td><td class="col-33-bgff"> </td><td class="col-33-bgff"> </td><td class="col-33-bgff"> </td></tr></table>

               <br />
            	<table width="100%" border="0" cellpadding="5" cellspacing="1" class="calendar_table">
				<tr>
					<td colspan="7" align="center" style="background:#E7E7E7;"><span class="col-bla33-b">連系日</span></td>
				</tr>
			</table>
            <table width="100%" border="0" cellpadding="5" cellspacing="1" class="calendar_table"><tr ><td align="center" class="col-33-bgf8">日</td><td align="center" class="col-33-bgff">月</td><td align="center" class="col-33-bgff">火</td><td align="center" class="col-33-bgff">水</td><td align="center" class="col-33-bgff">木</td><td align="center" class="col-33-bgff">金</td><td class="col-33-bgdc">土</td></tr><tr><td align="center" class="col-33-bgff"> </td><td class="col-33-bgff"><div>1</div><p> </p><p> </p></td><td class="col-33-bgff"><div>2</div><p><a href="./?req=project_regi">田中太郎(2541)</a></p><p> </p></td><td class="col-33-bgff"><div>3</div><p> </p><p> </p></td><td class="col-33-bgff"><div>4</div><p> </p><p> </p></td><td class="col-33-bgff"><div>5</div><p> </p><p> </p></td><td class="col-33-bgdc"><div>6</div><p> </p><p> </p></td></tr><tr><td class="col-33-bgf8"><div>7</div><p> </p><p> </p></td><td class="col-33-bgff"><div>8</div><p> </p><p> </p></td><td class="col-33-bgff"><div>9</div><p> </p><p> </p></td><td class="col-33-bgff"><div>10</div><p> </p><p> </p></td><td class="col-33-bgff"><div>11</div><p> </p><p> </p></td><td class="col-33-bgff"><div>12</div><p> </p><p> </p></td><td class="col-33-bgdc"><div>13</div><p> </p><p> </p></td></tr><tr><td class="col-33-bgf8"><div>14</div><p> </p><p> </p></td><td class="col-33-bgff"><div>15</div><p> </p><p> </p></td><td class="col-33-bgff"><div>16</div><p><a href="./?req=project_regi">小野寺昭(22501)</a></p><p> </p></td><td class="col-33-bgff"><div>17</div><p> </p><p> </p></td><td class="col-33-bgff"><div>18</div><p> </p><p> </p></td><td class="col-33-bgff"><div>19</div><p> </p><p> </p></td><td class="col-33-bgdc"><div>20</div><p> </p><p> </p></td></tr><tr><td class="col-33-bgf8"><div>21</div><p> </p><p> </p></td><td class="col-33-bgff"><div>22</div><p> </p><p> </p></td><td class="col-33-bgff"><div>23</div><p> </p><p> </p></td><td class="col-33-bgff"><div>24</div><p> </p><p> </p></td><td class="col-33-bgff"><div>25</div><p> </p><p> </p></td><td class="col-33-bgff"><div>26</div><p><a href="./?req=project_regi">君島祐司(65)</a></p><p> </p></td><td class="col-33-bgdc"><div>27</div><p> </p><p> </p></td></tr><tr><td class="col-33-bgf8"><div>28</div><p> </p><p> </p></td><td class="col-33-bgff"><div>29</div><p> </p><p> </p></td><td class="col-33-bgff"> </td><td class="col-33-bgff"> </td><td class="col-33-bgff"> </td><td class="col-33-bgff"> </td><td class="col-33-bgff"> </td></tr></table>


               <br />
            	<table width="100%" border="0" cellpadding="5" cellspacing="1" class="calendar_table">
				<tr>
					<td colspan="7" align="center" style="background:#E7E7E7;"><span class="col-bla33-b">完工日</span></td>
				</tr>
			</table>
            <table width="100%" border="0" cellpadding="5" cellspacing="1" class="calendar_table"><tr ><td align="center" class="col-33-bgf8">日</td><td align="center" class="col-33-bgff">月</td><td align="center" class="col-33-bgff">火</td><td align="center" class="col-33-bgff">水</td><td align="center" class="col-33-bgff">木</td><td align="center" class="col-33-bgff">金</td><td class="col-33-bgdc">土</td></tr><tr><td align="center" class="col-33-bgff"> </td><td class="col-33-bgff"><div>1</div><p> </p><p> </p></td><td class="col-33-bgff"><div>2</div><p><a href="./?req=project_regi">田中太郎(2541)</a></p><p> </p></td><td class="col-33-bgff"><div>3</div><p> </p><p> </p></td><td class="col-33-bgff"><div>4</div><p> </p><p> </p></td><td class="col-33-bgff"><div>5</div><p> </p><p> </p></td><td class="col-33-bgdc"><div>6</div><p> </p><p> </p></td></tr><tr><td class="col-33-bgf8"><div>7</div><p> </p><p> </p></td><td class="col-33-bgff"><div>8</div><p> </p><p> </p></td><td class="col-33-bgff"><div>9</div><p> </p><p> </p></td><td class="col-33-bgff"><div>10</div><p> </p><p> </p></td><td class="col-33-bgff"><div>11</div><p> </p><p> </p></td><td class="col-33-bgff"><div>12</div><p> </p><p> </p></td><td class="col-33-bgdc"><div>13</div><p> </p><p> </p></td></tr><tr><td class="col-33-bgf8"><div>14</div><p> </p><p> </p></td><td class="col-33-bgff"><div>15</div><p> </p><p> </p></td><td class="col-33-bgff"><div>16</div><p><a href="./?req=project_regi">小野寺昭(22501)</a></p><p> </p></td><td class="col-33-bgff"><div>17</div><p> </p><p> </p></td><td class="col-33-bgff"><div>18</div><p> </p><p> </p></td><td class="col-33-bgff"><div>19</div><p> </p><p> </p></td><td class="col-33-bgdc"><div>20</div><p> </p><p> </p></td></tr><tr><td class="col-33-bgf8"><div>21</div><p> </p><p> </p></td><td class="col-33-bgff"><div>22</div><p> </p><p> </p></td><td class="col-33-bgff"><div>23</div><p> </p><p> </p></td><td class="col-33-bgff"><div>24</div><p> </p><p> </p></td><td class="col-33-bgff"><div>25</div><p> </p><p> </p></td><td class="col-33-bgff"><div>26</div><p><a href="./?req=project_regi">君島祐司(65)</a></p><p> </p></td><td class="col-33-bgdc"><div>27</div><p> </p><p> </p></td></tr><tr><td class="col-33-bgf8"><div>28</div><p> </p><p> </p></td><td class="col-33-bgff"><div>29</div><p> </p><p> </p></td><td class="col-33-bgff"> </td><td class="col-33-bgff"> </td><td class="col-33-bgff"> </td><td class="col-33-bgff"> </td><td class="col-33-bgff"> </td></tr></table>

        </div>
	</div>
							<div class="content noPad clearfix" id="DataArea"></div>
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