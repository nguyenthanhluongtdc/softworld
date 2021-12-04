<?php


class staff_regi extends default_admin_class
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
					<h3>社員登録</h3>
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
                                        社員ID
                                    </th>
                                    <td><?= $GLOBALS['GET']['id'] ?></td>
                                </tr>
                                 <tr>
                                    <th>
                                        社員名 <span class="komered">※</span>
                                    </th>
                                    <td><input type="text" name="" id="" /></td>
                                </tr>
                                   <tr>
                                    <th>
                                        社員名　カナ
                                    </th>
                                    <td><input type="text" name="" id="" /></td>
                                </tr>
                                <tr>
                                    <th>
                                        事業所名 <span class="komered">※</span>
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
                                        部署 <span class="komered">※</span>
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
                                        権限 <span class="komered">※</span>
                                    </th>
                                    <td>
                                      <?php
                                      Form::checkbox_write_usekey("permit",$GLOBALS["MASTER"]['permit'],$_SESSION[$this->session_key]['permit'],1);                                      ?>



                                         <span class="komered">※ここで登録する社員に利用を許可する機能を選択して下さい。</span>
                                    </td>
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
                                    <td><input type="text" name="street" id="street" class="" /></td>
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
                                    <td><input type="text" name="bill" id="bill"  /></td>
                                </tr>
                                <tr>
                                    <th>
                                        電話番号 <span class="komered">※</span>
                                    </th>
                                    <td><input type="text" name="" id="" /></td>
                                </tr>
                                <tr>
                                    <th>
                                        メールアドレス <span class="komered">※</span>
                                    </th>
                                    <td><input type="text" name="" id="" /></td>
                                </tr>

                                <tr>
                                    <th>
                                        ログインパスワード
                                    </th>
                                    <td>
                                        <input type="password" name="" id="" class="input-medium" />　<br />

                                        <input type="checkbox" name="pass" id="pass" />パスワードを変更する
                                        <br />
                                        <span class="komered">※半角英数字6～10文字</span>
                                    </td>
                                </tr>

                                   <tr>
                                    <th>
                                        上役指定
                                    </th>
                                    <td>
                                        <select name="" id="">
                                            <option value="">未指定</option>
                                            <?php
                                            Form::pulldown_write_usekey($GLOBALS["MASTER"]['staff_list'],"");
                                            ?>
                                        </select>
 <span class="komered">
                                        <br />
                                        ※ここで上役を指定することで、該当の社員が(紹介者以外で）担当している案件が変更された場合に、<br />
                                        直属の上司として、変更メールが送られるようになります。
     </span>

                                    </td>
                                </tr>
                                  <tr>
                                    <th>
                                        案件変更メール
                                    </th>
                                    <td>

                                        <?php
                                        Form::checkbox_write_usekey("mail_check",array(1 => "全ての案件の変更メールを受け取る"),"");
                                        ?>
                                        <br />
                                       <span class="komered">  ※ここにチェックを入れると全ての案件の変更メールが届きます。
                                        <br />
                                        ここにチェックが入ることによって、全ての案件を閲覧・編集を出来る権限を持ちます。
                                           </span>

                                    </td>
                                </tr>

   <tr>
                                    <th>
                                        その他備考
                                    </th>
                                    <td>
                                    <textarea name="memo" id="" cols="30" rows="10"></textarea>
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