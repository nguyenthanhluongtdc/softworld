<?php


class project_import extends default_admin_class
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
					<h3>案件登録[CSVインポート]</h3>
		</div><!-- End .heading-->

				<!-- Build page from here: Usual with <div class="row-fluid"></div> -->

				<div class="row-fluid">
					<div class="span12">

						<div class="box gradient">


							<div class="content noPad clearfix" id="DataArea">

<div class="margin10"> <span class="komered">※フォーマットにそったCSVを読み込む画面です。
CSVに入力した案件IDの案件が存在する場合は、自動で関連付けられます。 <br />
        存在しない場合は、新しく案件を作成します。
<br />
    </span>
</div>


 <table class="input_form_table">
                                <tr>
                                    <th colspan="2" class="cap">CSVインポート</th>
                                </tr>
                                <tr>
                                    <th>
                                        案件ID
                                    </th>
                                    <td></td>
                                </tr>
                                 <tr>
                                    <th>
                                        CSV読み込み <span class="komered">※</span>
                                    </th>
                                    <td><input type="file" name="csv" id="" /></td>
                                </tr>

                                    <tr>
                                    <td colspan="2" class="text_center"><input type="submit" value="確認画面へ" /></td>
                                </tr>
</table>





                                </form>								</div>
							</div><!-- End .box -->
						</div><!-- End .span12 -->
					</div><!-- End .row-fluid -->
				<!-- Page end here -->
			</div><!-- End contentwrapper -->
		</div><!-- End #content -->
        </div><!-- End #wrapper -->
        <script type="text/javascript">
              $('a#opener').click(function(){
                  if($('.content_border').css('display') == 'block'){
                      $("#opener").html("+ 開く");
                  }else{
                      $("#opener").html("- 閉じる");
                  }
                  $('.content_border').slideToggle("fast");
              });


        </script>
    <?php

    }





}