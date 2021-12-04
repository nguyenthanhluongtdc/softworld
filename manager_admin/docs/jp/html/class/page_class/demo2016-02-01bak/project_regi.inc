<?php


class project_regi extends default_admin_class
{
    var $before_date_y;

    var $data1 = "佐藤 篤";
    var $data2 = "東京都";
    var $data2num = "13";
    var $data3 = "港区";
    var $data4 = "芝公園４丁目２−８";

    var $katashiki1 = "SF-165-S";
    var $katashiki2 = "";
    var $katashiki3 = "KP40K3-SS-A";
    var $katashiki4 = "";
    var $katashiki5 = "SCO-04A10001";
    var $katashiki6 = "KP-ST3-1-SS";
    var $katashiki8 = "SF2MHS-1001";
    var $katashiki9 = "SF2MHS-2001";
    var $katashiki10 = "";
    var $katashiki11 = "HWH-B374";
    var $katashiki12 = "";
    var $katashiki13 = "";


    var $num1 = "40";
    var $num2 = "";
    var $num3 = "1";
    var $num4 = "";
    var $num5 = "1";
    var $num6 = "1";
    var $num8 = "1";
    var $num9 = "1";
    var $num10 = "";
    var $num11 = "1";
    var $num12 = "";
    var $num13 = "";

    function __construct()
    {

        parent::__construct();

        $this->search_ym = $GLOBALS['GET']['date_y'] . "-" . sprintf("%02d", $GLOBALS['GET']['date_m']);
        $this->search_yymmmm = $GLOBALS['GET']['date_y'] . "" . sprintf("%02d", $GLOBALS['GET']['date_m']);
    }

    function main()
    {
        ?>
        <!--Body content-->
        <div id="content" class="clearfix">
			<div class="contentwrapper"><!--Content wrapper-->
				<div class="heading">
					<h3>案件登録[画面入力]</h3>
		</div><!-- End .heading-->

				<!-- Build page from here: Usual with <div class="row-fluid"></div> -->

				<div class="row-fluid">
					<div class="span12">

						<div class="box gradient">


							<div class="content noPad clearfix" id="DataArea">

<div class="margin10"> <span class="komered">※</span>は入力必須項目です。</div>


 <table class="input_form_table">
                                <tr>
                                    <th colspan="2" class="cap">お客様基本情報</th>
                                </tr>
                                <tr>
                                    <th>
                                        案件ID
                                    </th>
                                    <td><?= $GLOBALS['GET']['id'] ?></td>
                                </tr>
     <tr>
                                    <th>
                                        ステータス <span class="komered">※</span>
                                    </th>
                                    <td>
                                        <select name="status" id="status">
                                         <option value=""></option>
                                            <?php
                                            Form::pulldown_write_usekey($GLOBALS["MASTER"]['project_status'], $_SESSION[$this->session_key]['status']);
                                            ?>
                                        </select>

                                        <table>
                                            <tr>
                                    <th colspan="2" class="cap">ステータス変更履歴</th>
                                </tr>
                                            <tr>
                                                <th>2015-12-15</th>
                                                <td>本契約</td>
                                            </tr>
                                            <tr>
                                                <th>2015-12-10</th>
                                                <td>仮契約</td>
                                            </tr>
                                            <tr>
                                                <th>2015-12-08</th>
                                                <td>見積提出</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                 <tr>
                                    <th>
                                        お客様氏名 <span class="komered">※</span>
                                    </th>
                                    <td><input type="text" name="" id="" value="<?= $this->data1 ?>" /></td>
                                </tr>
                                   <tr>
                                    <th>
                                        住所（お客様住居）
                                    </th>
                                    <td>

                                        〒 <input type="text" name="post1" id="post1" class="input-mini" />
                                        - <input type="text" name="post2" id="post2" class="input-mini" />
                                        <br />
                                        <select name="prefecture" id="prefecture">
                                         <option value=""></option>
                                            <?php
                                            Form::pulldown_write_usekey($GLOBALS["MASTER"]["prefecture_list"], $GLOBALS['GET']['prefecture']);
                                            ?>
                                        </select><br />
                                        市区町村：<input type="text" name="city" id="city" />
                                        <br />
                                        番地等：<input type="text" name="street" id="street" />
                                        <br />
                                        マンション/ビル名等：<input type="text" name="bill" id="bill" />

                                    </td>
                                </tr>
     <tr>
                                    <th>
                                        住所（設置場所）
                                    </th>
                                    <td>

                                        〒 <input type="text" name="post1b" id="post1b" class="input-mini" />
                                        - <input type="text" name="post2b" id="post2b" class="input-mini" />
                                        <br />
                                        <select name="prefectureb" id="prefectureb">
                                         <option value=""></option>
                                            <?php
                                            Form::pulldown_write_usekey($GLOBALS["MASTER"]["prefecture_list"], $this->data2num);
                                            ?>
                                        </select><br />
                                        市区町村：<input type="text" name="city" id="cityb" value="<?= $this->data3 ?>" />
                                        <br />
                                        番地等：<input type="text" name="street" id="streetb" value="<?= $this->data4 ?>" />
                                        <br />
                                        マンション/ビル名等：<input type="text" name="bill" id="billb" value="" />

                                    </td>
                                </tr>

                                <tr>
                                    <th>
                                        電話番号 <span class="komered">※</span>
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
                                    <textarea name="memo" id="" cols="30" rows="10"></textarea>
                                    </td>
                                </tr>

							</table>

<br />
<br />
<div id="ui-tab">
<ul>
<li><a href="#fragment-1"><span>日程・各種履歴・帳票情報</span></a></li>
<li><a href="#fragment-2"><span>商品情報</span></a></li>
<li><a href="#fragment-3"><span>支払い情報</span></a></li>
<li><a href="#fragment-4"><span>担当者情報</span></a></li>
</ul>

<div id="fragment-1">
<p>
<table class="input_form_table">
                                <tr>
                                    <th colspan="4" class="cap">日程・各種履歴・帳票情報</th>
                                </tr>
 <tr>

         <th>種別</th>
     <td>
         <table class="width_100per">
             <tr>
                 <th>契約種別</th>
                 <td>
                     <?php

                     Form::radio_button_write_usekey("yojo", $GLOBALS["MASTER"]['keiyaku_type'], $yojo);
                     ?>
                 </td>
             </tr>
               <tr>
                 <th>PV</th>
                 <td><input type="checkbox" name="" id="" /></td>
             </tr>
             <tr>
                 <th>TD</th>
                 <td><input type="text" name="" id="" class="input-mini" /></td>
             </tr>
             <tr>
                 <th>OD</th>
                 <td><input type="text" name="" id="" class="input-mini" value="EQ" /></td>
             </tr>
         </table>

     </td>
     </tr>
     <tr>

         <th>現調日</th>
     <td><?= template_admin::calendar_selectbox("date_a", $GLOBALS['GET']) ?></td>
     </tr>
     <tr>
         <tr>

         <th>契約日</th>
     <td><?= template_admin::calendar_selectbox("date1", $GLOBALS['GET']) ?></td>
     </tr>
     <tr>

         <th>工事開始日</th>
     <td><?= template_admin::calendar_selectbox("date2", $GLOBALS['GET']) ?></td>
     </tr>
     <tr>

         <th>完工日</th>
     <td><?= template_admin::calendar_selectbox("date3", $GLOBALS['GET']) ?></td>
     </tr>

        <tr>

         <th>東電申請書出力</th>
     <td>

         <?php
         $type_toden_array = array(
             1 => "タイプA",
             2 => "タイプB",
         );
         Form::radio_button_write_usekey("type_toden", $type_toden_array, $_SESSION[$this->session_key]['type_toden']);
         ?>
         <button type="button" class="btn-info btn" onclick="toden_link();">申請書 作成</button>

         <br />

         （最終出力日：2015-12-07）
     </td>
     </tr>
        <tr>

         <th>経産省 申請日</th>
     <td><?= template_admin::calendar_selectbox("date3", $GLOBALS['GET']) ?></td>
     </tr>

     <tr>

         <th>各種書類履歴</th>
         <td>
             <div class="scroll_h" style="height: 100px">
    <table class="scroll_table">
        <tr>
            <th>アップロード者名</th>
            <th>アップロード日</th>
            <th>種別</th>
            <th>ファイル名</th>
        </tr>
    <tr>
                <td>山田 太郎</td>
                <td>2015-12-05</td>
                <td>経産省申請書</td>
                <td><a href="./upload/sample.pdf" target="_blank">○○申請書.pdf</a></td>
        </tr>
        <tr>
            <td>山田 太郎</td>
                <td>2015-11-29</td>
                <td>現調資料</td>
                <td><a href="./upload/sample.pdf" target="_blank">○○邸現調.pdf</a></td>
        </tr>
        <tr>
            <td>山田 太郎</td>
                <td>2015-11-29</td>
                <td>現調資料</td>
                <td><a href="./upload/sample.pdf" target="_blank">○○邸現調.pdf</a></td>
        </tr>
    <tr>
        <td>山田 太郎</td>
                <td>2015-11-27</td>
                <td>契約書</td>
                <td><a href="./upload/sample.pdf" target="_blank">○○邸契約書.pdf</a></td>
        </tr>


    </table>



  </div>

         </td>
     </tr>
  <tr>

         <th>各種書類アップロード
         </th>
         <td>

             <input type="file" name="file" id="" />
             種別：
             <select name="filetype" id="">
                 <option value=""></option>
                 <?php
                 Form::pulldown_write_usekey($GLOBALS["MASTER"]['filetype'], $_SESSION[$this->session_key]['filetype']);
                 ?>
             </select>
             <br />
             <span class="komered">※ここでアップロードされたファイルは、案件ID 100に関連付けられます。</span>
     </td></tr>



     <tr>

         <th>見積履歴</th>
         <td>
             <div class="scroll_h" style="height: 100px">
                 <span class="komered">※金額をクリックすると、見積内容が商品情報入力欄に貼り付けられます。</span>
    <table class="scroll_table">
        <tr>
            <th>アップロード者名</th>
            <th>アップロード日</th>
            <th>合計金額</th>
            <th>ファイル名</th>
        </tr>
    <tr>
        <td>山田 太郎</td>
                <td>2015-12-05</td>
                <td><a href="javascript:paste_buy();">2,500,000円</a></td>
                <td><a href="./upload/sample.csv" target="_blank">20151205見積.csv</a></td>
        </tr>
        <tr>
            <td>山田 太郎</td>
                <td>2015-11-29</td>
                <td><a href="javascript:paste_buy();">3,500,000円</a></td>
                <td><a href="./upload/sample.csv" target="_blank">20151129見積.csv</a></td>
        </tr>
        <tr>
            <td>山田 太郎</td>
                <td>2015-11-25</td>
                <td><a href="javascript:paste_buy();">2,900,000円</a></td>
                <td><a href="./upload/sample.csv" target="_blank">20151125見積.csv</a></td>
        </tr>


    </table>



  </div>

         </td>
     </tr>
  <tr>

         <th>見積アップロード
         </th>
         <td>

             <input type="file" name="file" id="" />
             <br />
        <span class="komered">※ここでアップロードされた見積は、案件ID 100に関連付けられます。</span>
     </td></tr>


      <tr>

         <th>案件変更履歴</th>
         <td>
             <div class="scroll_h" style="height: 100px">
    <table class="scroll_table">
        <tr>
            <td>変更者名</td>
            <th>変更日</th>
            <th>変更箇所</th>
            <th>承認者名</th>
        </tr>
    <tr>
        <td>山田 太郎</td>
                <td>2015-12-05</td>
                <td><a href="javascript:void();" onclick="window.open('./?req=change_his&id=<?= $GLOBALS['GET']['id'] ?>')">モジュール型式、金額</a></td>
                <td>田中篤、森村五郎</td>
        </tr>

            <tr>
        <td>山田 太郎</td>
                <td>2015-11-30</td>
                <td><a href="javascript:void();" onclick="window.open('./?req=change_his&id=<?= $GLOBALS['GET']['id'] ?>')">パワコン型式、モニター型式、金額</td>
                <td>田中篤、森村五郎</td>
        </tr>


    </table>



  </div>

         </td>
     </tr>
    <tr>
                                    <td colspan="4" class="text_center"><input type="submit" value="確認画面へ" /></td>
                                </tr>

							</table>
</p>
</div>

<div id="fragment-2">
<p>							<table class="input_form_table">
                                <tr>
                                    <th colspan="10" class="cap">商品情報</th>

                                </tr>
                                <tr>
                                    <th>
                                        帳票表示
                                    </th>
                                    <th style="width: 200px;">
                                        商品名
                                    </th>
                                    <th style="width: 150px;">
                                        メーカー
                                    </th>
                                    <th>
                                        型式
                                    </th>
                                    <th>
                                        個数
                                    </th>
                                    <th>
                                        販売単価
                                    </th>
                                    <th>
                                       　販売金額
                                    </th>
                                    <th>
                                        仕切単価
                                    </th>
                                    <th>
                                        仕切り金額
                                    </th>
                                    <th>
                                        Kw/備考

                                    </th>
                                </tr>
        <?php
        $iii = 1;
        $array = array(
            1 => "工事",
            2 => "整地",
            3 => "他",
        );
        foreach ($GLOBALS["MASTER"]['anken_goods_type'] as $key => $value) {

            $var = "katashiki" . $key;
            $var1 = "num" . $key;

            $iii++;
            if (!$value) {
                $value = <<<HTML
<input type="text" name="text" id="text" class="input-small"/>
HTML;
                $_SESSION[$this->session_key]['type' . $iii] = 1;
            } else {
                $_SESSION[$this->session_key]['type' . $iii] = 3;
            }
            ?>
            <tr>
<th><input type="checkbox" name="view[]" id="" checked="checked" /></th>
                                    <th class="nowrap" style="width: 13%;"><?= $value ?>
                                        <br />
                                        <span style="font-weight: 400;">
                                    <?php
                                    Form::radio_button_write_usekey("type" . $iii, $array, $_SESSION[$this->session_key]['type' . $iii], "<br />");
                                    ?>
                                            </span>
                                    </th>
                                    <td style="width: 12%;">
                                        <select name="maker" id="maker" class="input-small">
                                            <option value=""></option>
                                            <?php
                                            Form::pulldown_write_usekey($GLOBALS["MASTER"]['maker_list'], $_SESSION[$this->session_key]['maker_list']);
                                            ?>
                                            </select>
                                    </td>
                                    <td style="width: 18%;">
                                        <input type="text" name="type" id="" class="input-medium" value="<?= $this->$var ?>" />
                                    </td>
                                    <td style="width: 8%;"><input type="text" name="type" id="num<?= $key ?>" class="input-XXmini ime_off" value="<?= $this->$var1 ?>" onchange="total('<?= $key ?>');" /></td>
                                    <td style="width: 12%;">\<input type="text" name="type" id="tanka<?= $key ?>" class="input-mini ime_off" onchange="total('<?= $key ?>');" /></td>
                                    <td style="width: 12%;">\<input type="text" name="type" id="hanbai<?= $key ?>" class="input-mini ime_off" onchange="total('<?= $key ?>');" /></td>
                                    <td style="width: 12%;">\<input type="text" name="type" id="tanka_s<?= $key ?>" class="input-mini ime_off" onchange="total('<?= $key ?>');" /></td>
                                    <td style="width: 13%;">\<input type="text" name="type" id="shikiri<?= $key ?>" class="input-mini ime_off" onchange="total('<?= $key ?>');" /></td>

                                    <td style="width: 20%;">
                                        <?php
                                        if ($iii == 2) {
                                            ?>
                                            <input type="text" name="kw" id="kw" value="" class="input-mini ime_off" />Kw
                                            <br />
                                        <?php
                                        }
                                        ?>
                                        <textarea name="" id="" rows="3" class="input-small"></textarea></td>
                                </tr>

        <?php
        }
        ?>



        <tr>
            <th colspan="2">合計金額</th>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td id="all_hanbai"></td>
            <td></td>
            <td id="all_shikiri"></td>
            <td></td>

            </td>
        </tr>
        <tr>
            <th colspan="2">確認事項</th>
            <td colspan="8">
                  <textarea name="memo" id="" cols="30" rows="10"></textarea>
            </td>
        </tr>
        <tr>
            <th colspan="2">特記事項</th>
            <td colspan="8">
                  <textarea name="memo" id="" cols="30" rows="10"></textarea>
            </td>
        </tr>
        <tr>
    <td colspan="10">

          <div class="text_right padding_10px">
        <button type="button" class="btn-primary btn" onclick="window.open('./?req=seikyu_pdf')">請求書PDF発行</button>

                        <button type="button" class="btn-primary btn" onclick="window.open('./?req=hacchu_pdf')">部材発注書PDF 発行</button>
                    </div>
    </td>
</tr>
            <tr>
                                    <td colspan="10" class="text_center"><input type="submit" value="確認画面へ" /></td>
                                </tr>
                                </table>
    </p>
</div>

<div id="fragment-3">
    <a name="payment"></a>
<p>                                <table class="input_form_table">
                                <tr>
                                    <th colspan="4" class="cap">支払い情報</th>
                                </tr>

                                    <tr>
                                        <th>
                                            支払い方法
                                        </th>
                                        <td colspan="3" style="width: 75%;">

                                            <?php
                                            Form::radio_button_write_usekey("howpay", $GLOBALS["MASTER"]['howpay_list'], $_SESSION[$this->session_key]['howpay'], false, false, false)
                                            ?>
                                        </td>


                                    </tr>

        <?php
        for ($i = 1; $i <= 5; $i++) {
            ?>
            <tr>
                                        <th style="width: 12%;">
                                            支払予定日<?= $i ?>
                                        </th>
                                        <td style="width: 38%;">
<?= template_admin::calendar_selectbox("from" . $i, $GLOBALS['GET']) ?>
                                        </td>

                                          <th style="width: 12%;" class="color1">
                                            支払済日<?= $i ?>
                                        </th>
                                        <td style="width: 38%;">
<?= template_admin::calendar_selectbox("to" . $i, $GLOBALS['GET']) ?>
                                        </td>
                                    </tr>
            <tr>
                                        <th style="width: 12%;">
                                            支払予定金額<?= $i ?>
                                        </th>
                                        <td style="width: 38%;">
<input type="text" name="" id="" class="input-small ime_off" />円
                                            　メモ： <input type="text" name="" id="" class="input-medium" />
                                        </td>

                                          <th style="width: 12%;" class="color1">
                                            支払済金額<?= $i ?>
                                        </th>
                                        <td style="width: 38%;">
<input type="text" name="" id="" class="input-small ime_off" />円
                                            　メモ： <input type="text" name="" id="" class="input-medium" />
                                        </td>
                                    </tr>


        <?php
        }
        ?>
        <tr>
                                    <td colspan="4" class="text_center"><input type="submit" value="確認画面へ" /></td>
                                </tr>
                                    </table>
    </p>
</div>



<div id="fragment-4">
    <p>
   <table class="input_form_table">
                                <tr>
                                    <th colspan="4" class="cap">担当者情報</th>
                                </tr>
       <?php
       for ($t = 1; $t <= 10; $t++) {

           ?>
           <tr>
                                          <th style="width: 12%;">
                                            担当者 <?= $t ?>
                                        </th>
     <td style="width: 38%;">
         <select name="" id="">
             <option value=""></option>
             <?php
             Form::pulldown_write_usekey($GLOBALS["MASTER"]['staff_list'], $_SESSION[$this->session_key]['tanto_type' . $t]);
             ?>
         </select>
     </td>
                                        <th style="width: 12%;">
                                            担当種別 <?= $t ?>
                                        </th>
     <td style="width: 38%;">
         <select name="" id="">
             <option value=""></option>
             <?php
             Form::pulldown_write_usekey($GLOBALS["MASTER"]['tanto_type'], $_SESSION[$this->session_key]['tanto_type' . $t]);
             ?>
             </select>
     </td>


     </tr>
       <?php
       }
       ?>
       <tr>
                                    <td colspan="4" class="text_center"><input type="submit" value="確認画面へ" /></td>
                                </tr>
</table>

    </p>
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
              $('a#opener').click(function () {
                  if ($('.content_border').css('display') == 'block') {
                      $("#opener").html("+ 開く");
                  } else {
                      $("#opener").html("- 閉じる");
                  }
                  $('.content_border').slideToggle("fast");
              });

              function paste_buy() {
                  if (window.confirm('見積から商品情報入力欄に価格を貼り付けてもいいですか？')) {
                      alert("貼り付けました。(仮)");
                  } else {

                  }
              }

              function toden_link() {
                  var toden_radio = $("input[name='type_toden']:checked").val();

                  if (toden_radio == undefined) {
                      alert('タイプを選択して下さい。');
                  } else {
                      location.href = './?req=<?= $GLOBALS['GET']['req']?>&mode=toden&id=<?= $GLOBALS['GET']['id']?>&type=' + toden_radio;
                  }
              }

              function total(id_num) {

//                num
//                tanka
//                hanbai
//                tanka_s
//                shikiri

                  var num = "num" + id_num;
                  var tanka = "tanka" + id_num;
                  var hanbai = "hanbai" + id_num;
                  var tanka_s = "tanka_s" + id_num;
                  var shikiri = "shikiri" + id_num;


                  var hanbai_value = document.getElementById(num).value * document.getElementById(tanka).value
                  document.getElementById(hanbai).value = hanbai_value;
                  var shikiri_value = document.getElementById(num).value * document.getElementById(tanka_s).value
                  document.getElementById(shikiri).value = shikiri_value;

                  //合計計算

                  var array = [<?php
                foreach ($GLOBALS["MASTER"]['anken_goods_type'] as $key => $value) {
                if($value){
                    ?>'<?= $key?>',
                      <?php
                                      }

                                      }
                                      ?>''<?php
                                                    ?>];

                  var i;
                  var num = array.length;
                  var hanbai_value2 = 0;
                  var shikiri_value2 = 0;
                  for(i=0;i < num;i++){


                      var hanbai = "hanbai" + array[i];
                      var shikiri = "shikiri" + array[i];
                      if (document.getElementById(hanbai) != null) {
                          var hanbai_v = document.getElementById(hanbai).value;
                      }
                      if (document.getElementById(shikiri) != null) {
                          var shikiri_v = document.getElementById(shikiri).value;
                      }

                      if(isNaN(parseInt(hanbai_v)) === false){
                          hanbai_value2 += parseInt(hanbai_v);
                      }
                      if(isNaN(parseInt(shikiri_v)) === false){
                          shikiri_value2 += parseInt(shikiri_v);
                      }


                  }
                  document.getElementById('all_hanbai').innerHTML = hanbai_value2;
                  document.getElementById('all_shikiri').innerHTML = shikiri_value2;
              }
        </script>
    <?php

    }

    function toden()
    {
        //東電申請


        ?>
        <!--Body content-->
        <div id="content" class="clearfix">
        <div class="contentwrapper"><!--Content wrapper-->
        <div class="heading">
					<h3>東京電力申請書 出力</h3>
		</div><!-- End .heading-->

        <!-- Build page from here: Usual with <div class="row-fluid"></div> -->

        <div class="row-fluid">
        <div class="span12">

        <div class="box gradient">


        <div class="content noPad clearfix" id="DataArea">

        <div class="margin10"> <span class="komered">※</span>は入力必須項目です。</div>


 <table class="input_form_table">
      <tr>
         <th>入力型式</th>
         <td>
             <?php
             if ($GLOBALS['GET']['type'] == "1") {
                 echo "タイプA";
             } elseif ($GLOBALS['GET']['type'] == "2") {
                 echo "タイプB";
             } else {
                 exit;
             }
             ?>
         </td>
     </tr>
 <tr>
         <th>お客様名</th>
         <td><input type="text" name="" id="" value="<?= $this->data1 ?>" class="input-medium" /></td>
     </tr>
     <tr>
         <th>設備認定ID</th>
         <td><input type="text" name="" id="" value="" class="input-small" /></td>
     </tr>
     <tr>
         <th>東京電力申込番号</th>
         <td><input type="text" name="" id="" value="" class="input-small" /></td>
     </tr>
     <tr>
         <th>設置住所</th>
         <td>
             <input type="text" name="" id="" value="<?= $this->data2 ?>" class="input-medium" />
             <input type="text" name="" id="" value="<?= $this->data3 ?>" class="input-medium" />
             <input type="text" name="" id="" value="<?= $this->data4 ?>" class="input-medium" />
         </td>
     </tr>
      <tr>
         <th>更新日</th>
         <td><?= template_admin::calendar_selectbox("date0", $GLOBALS['GET']) ?></td>
     </tr>
     <tr>
         <th>モジュール</th>
         <td><input type="text" name="" id="" value="<?= $this->katashiki1 ?>" class="input-medium" /></td>
     </tr>
     <tr>
         <th>モジュール枚数</th>
         <td><input type="text" name="" id="" value="<?= $this->num1 ?>" class="input-small" />枚</td>
     </tr>
     <tr>
         <th>PCS1</th>
         <td><input type="text" name="" id="" value="<?= $this->katashiki3 ?>" class="input-medium" /></td>
     </tr>
     <tr>
         <th>PCS1台数</th>
         <td><input type="text" name="" id="" value="<?= $this->num3 ?>" class="input-small" />台</td>
     </tr>
     <tr>
         <th>PCS2</th>
         <td><input type="text" name="" id="" value="<?= $this->katashiki4 ?>" class="input-medium" /></td>
     </tr>
     <tr>
         <th>PCS2台数</th>
         <td><input type="text" name="" id="" value="<?= $this->num4 ?>" class="input-small" />枚</td>
     </tr>
     <tr>
         <th>合計出力</th>
         <td><input type="text" name="" id="" value="" class="input-small" ime_off />Kw</td>
     </tr>
     <tr>
         <th>申請出力</th>
         <td><input type="text" name="" id="" value="" class="input-small ime_off" />Kw</td>
     </tr>
     <tr>
         <th>設備認定申請日</th>
         <td><?= template_admin::calendar_selectbox("date1", $GLOBALS['GET']) ?></td>
     </tr>

     <?php
     if ($GLOBALS['GET']['type'] == "1") {
         ?>
         <tr>
         <th>電力受給受付日</th>
         <td><?= template_admin::calendar_selectbox("date2", $GLOBALS['GET']) ?></td>
     </tr>
         <tr>
         <th>設備認定回答日</th>
         <td><?= template_admin::calendar_selectbox("date3", $GLOBALS['GET']) ?></td>
     </tr>
         <tr>
         <th>工事負担金算出日</th>
         <td><?= template_admin::calendar_selectbox("date4", $GLOBALS['GET']) ?></td>
     </tr>
         <tr>
         <th>工事負担金</th>
         <td><input type="text" name="" id="" value="" class="input-small ime_off" />円</td>
     </tr>
         <tr>
         <th>工事負担金支払日</th>
         <td><?= template_admin::calendar_selectbox("date5", $GLOBALS['GET']) ?></td>
     </tr>
         <tr>
         <th>メーター代</th>
         <td><input type="text" name="" id="" value="" class="input-small ime_off" />円</td>
     </tr>
     <?php
     } elseif ($GLOBALS['GET']['type'] == "2") {
         ?>
         <tr>
         <th>接続検討申請日</th>
         <td><?= template_admin::calendar_selectbox("date2", $GLOBALS['GET']) ?></td>
     </tr>
         <tr>
         <th>設備認定回答日</th>
         <td><?= template_admin::calendar_selectbox("date3", $GLOBALS['GET']) ?></td>
     </tr>
         <tr>
         <th>接続検討回答日</th>
         <td><?= template_admin::calendar_selectbox("date4", $GLOBALS['GET']) ?></td>
     </tr>
         <tr>
         <th>設備認定条件付き</th>
         <td><input type="text" name="" id="" value="" class="input-xlarge" /></td>
     </tr>
         <tr>
         <th>本申込み日</th>
         <td><?= template_admin::calendar_selectbox("date5", $GLOBALS['GET']) ?></td>
     </tr>
         <tr>
         <th>電気使用申込日</th>
         <td><?= template_admin::calendar_selectbox("date6", $GLOBALS['GET']) ?></td>
     </tr>
         <tr>
         <th>工事負担金額</th>
         <td><input type="text" name="" id="" value="" class="input-small ime_off" />円</td>
     </tr>
         <tr>
         <th>東京電力電力需給</th>
         <td><?= template_admin::calendar_selectbox("date7", $GLOBALS['GET']) ?></td>
     </tr>
         <tr>
         <th>工事負担金支払い日</th>
         <td><?= template_admin::calendar_selectbox("date8", $GLOBALS['GET']) ?></td>
     </tr>
         <tr>
         <th>メモ欄</th>
         <td><input type="text" name="" id="" value="" class="input-xlarge ime_off" /></td>
     </tr>
     <?php
     } else {


     }
     ?>

     <tr>
         <th>連携見込み</th>
         <td><input type="text" name="" id="" value="" class="input-medium" /></td>
     </tr>
     <tr>
         <th>連携確定日</th>
          <td><?= template_admin::calendar_selectbox("date5", $GLOBALS['GET']) ?></td>
     </tr>
     <tr>
         <th>備考欄</th>
         <td>
             <textarea name="" id="" cols="30" rows="10"></textarea>
         </td>
     </tr>

     <tr>
         <td colspan="2" class="text_center"><input type="submit" value="確認画面へ" />

         <input type="button" value="戻る" onclick="location.href='./?req=<?= $GLOBALS['GET']['req'] ?>&id=<?= $GLOBALS['GET']['id'] ?>'" />
         </td>
     </tr>
     </table>
    <?php


    }


}