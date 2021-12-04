<?php


class office_regi extends default_admin_class
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
					<h3>事業所登録</h3>
		</div><!-- End .heading-->

				<!-- Build page from here: Usual with <div class="row-fluid"></div> -->

				<div class="row-fluid">
					<div class="span12">
						<div class="box gradient">


							<div class="content noPad clearfix" id="DataArea">
<div class="margin10"> <span class="komered">※</span>は入力必須項目です。</div>

							<table class="input_form_table">
                                <tr>
                                    <th>
                                        事業所ID
                                    </th>
                                     <td><?= $GLOBALS['GET']['id'] ?></td>
                                </tr>
                                 <tr>
                                    <th>
                                        事業所名 <span class="komered">※</span>
                                    </th>
                                    <td><input type="text" name="" id="" /></td>
                                </tr>
                                   <tr>
                                    <th>
                                        事業所名　カナ
                                    </th>
                                    <td><input type="text" name="" id="" /></td>
                                </tr>

                                <tr>
                                    <th>
                                        郵便番号 <span class="komered">※</span>
                                    </th>
                                    <td>
                                        〒 <input type="text" name="post1" id="post1" class="input-mini" />
                                        - <input type="text" name="post2" id="post2" class="input-mini" />
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        都道府県 <span class="komered">※</span>
                                    </th>
                                    <td>
                                        <select name="prefecture" id="prefecture">
                                            <option value=""></option>
                                            <?php
                                            Form::pulldown_write_usekey($GLOBALS["MASTER"]["prefecture_list"],$GLOBALS['GET']['prefecture']);
                                            ?>
                                            </select>
                                    </td>
                                </tr>
                                <tr>
                                    <th>
                                        市区町村
                                    </th>
                                    <td><input type="text" name="city" id="city" /></td>
                                </tr>
                                <tr>
                                    <th>
                                        番地
                                    </th>
                                    <td><input type="text" name="street" id="street"  /></td>
                                </tr>

                                              <script type="text/javascript" src="./common/js/jquery.jpostal.js"></script>
              <script type="text/javascript">
$(window).ready( function() {
    //jpostal用処理
    $('#post1').jpostal({
        postcode : [
            '#post1',
            '#post2'
        ],
        address : {
            '#prefecture'  : '%3',
            '#city'  : '%4',
            '#street'  : '%5'
        }
    });
});
</script>
                                <tr>
                                    <th>
                                        マンション/ビル名等
                                    </th>
                                    <td><input type="text" name="bill" id="bill" class="" /></td>
                                </tr>
                                <tr>
                                    <th>
                                        電話番号 <span class="komered">※</span>
                                    </th>
                                    <td><input type="text" name="" id="" /></td>
                                </tr>
                                      <tr>
                                    <th>
                                        FAX番号
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
                                    <th>
                                        その他備考
                                    </th>
                                    <td>
                                    <textarea name="memo" id="" rows="10"></textarea>
                                    </td>
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