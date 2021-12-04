<?php


class change_his extends default_admin_class
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
    var $katashiki7 = "SF2MHS-1001";
    var $katashiki8 = "SF2MHS-2001";
    var $katashiki9 = "";
    var $katashiki10 = "HWH-B374";
    var $katashiki11 = "";
    var $katashiki12 = "";


    var $num1 = "40";
    var $num2 = "";
    var $num3 = "1";
    var $num4 = "";
    var $num5 = "1";
    var $num6 = "1";
    var $num7 = "1";
    var $num8 = "1";
    var $num9 = "";
    var $num10 = "1";
    var $num11 = "";
    var $num12 = "";

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
					<h3>案件変更履歴</h3>
		</div><!-- End .heading-->

				<!-- Build page from here: Usual with <div class="row-fluid"></div> -->

				<div class="row-fluid">
					<div class="span12">

						<div class="box gradient">


							<div class="content noPad clearfix" id="DataArea">



 <table class="input_form_table" id="td_width">
                                <tr>
                                    <th colspan="3" class="cap">基本情報</th>
                                </tr>
     <tr>
                                    <th>
                                        変更日時
                                    </th>
                                    <td colspan="2">2015-12-08 12:00</td>
                                </tr>
                                <tr>
                                    <th>
                                        案件ID
                                    </th>
                                    <td colspan="2"><?= $GLOBALS['GET']['id'] ?></td>
                                </tr>
                                 <tr>
                                    <th>
                                        お客様氏名 <span class="komered">※</span>
                                    </th>
                                    <td colspan="2"><?= $this->data1 ?></td>
                                </tr>


     <tr>
         <th>変更内容</th>
         <th>変更前</th>
         <th>変更後</th>
                                </tr>
         <tr>

         <th>契約日</th>
     <td>2015/12/08</td>
     <td>2015/12/15</td>
     </tr>
     <tr>

         <th>モジュール</th>
     <td></td>
   <td>変更なし</td>
     </tr>
                                     <tr>

         <th>枚数</th>
     <td>1</td>
     <td>2</td>
     </tr>

                                     <tr>

         <th>設備容量</th>
     <td></td>
    <td>変更なし</td>
     </tr>

     <tr>

         <th>パワコン型式</th>
     <td>VBPC3555A2</td>
     <td>変更なし</td>
     </tr>
                                <tr>

         <th>パワコン 台数</th>
     <td>1台</td>
     <td>変更なし</td>
     </tr>
                                <tr>
     <th>接続箱型式</th>
     <td>VBPC3555A2</td>
     <td>変更なし</td>
                                </tr>
                                <tr>

         <th>接続箱 台数</th>
     <td>1台</td>
     <td>変更なし</td>
     </tr>

                                <tr>
     <th>モニター型式</th>
     <td>VBPC3555A2</td>
     <td>変更なし</td>
                                </tr>
                                <tr>

         <th>モニター 台数</th>
     <td>1台</td>
     <td>変更なし</td>
     </tr>

                                                            <tr>
     <th>合計金額</th>
     <td></td>
     <td>変更なし</td>
                                </tr>
                                <tr>

         <th>その他</th>
     <td>1台</td>
     <td>変更なし</td>
     </tr>


                                    <tr>
                                    <td colspan="4" class="text_center"><input type="button" value="閉じる" onclick="window.close();"/></td>
                                </tr>
</table>

                                <table class="input_form_table" id="td_width2">
                                <tr>
                                    <th colspan="4" class="cap">書類等処理</th>
                                </tr>

                                    <tr>
                                        <th>処理内容</th>
                                        <th>処理日付</th>
                                        <th>担当者</th>
                                        <th>承認者</th>
                                    </tr>
                                    <tr>
                                       <th>変更後の契約書コピー</th>
                                    <td>
                                        <?= template_admin::calendar_selectbox("from".$i, $GLOBALS['GET']) ?>
                                    </td>
     <td><select name="" id="">
             <option value=""></option>
             <?php
             Form::pulldown_write_usekey($GLOBALS["MASTER"]['staff_list'],$_SESSION[$this->session_key]['tanto_type'.$t]);
             ?>
             </select></td>
     <td><select name="" id="">
             <option value=""></option>
             <?php
             Form::pulldown_write_usekey($GLOBALS["MASTER"]['staff_list'],$_SESSION[$this->session_key]['tanto_type'.$t]);
             ?>
             </select></td>
                                    </tr>

                                                                        <tr>
                                       <th>変更後の見積書</th>
                                    <td>
                                        <?= template_admin::calendar_selectbox("from".$i, $GLOBALS['GET']) ?>
                                    </td>
     <td><select name="" id="">
             <option value=""></option>
             <?php
             Form::pulldown_write_usekey($GLOBALS["MASTER"]['tanto_type'],$_SESSION[$this->session_key]['tanto_type'.$t]);
             ?>
             </select></td>
     <td><select name="" id="">
             <option value=""></option>
             <?php
             Form::pulldown_write_usekey($GLOBALS["MASTER"]['tanto_type'],$_SESSION[$this->session_key]['tanto_type'.$t]);
             ?>
             </select></td>
                                    </tr>

                                    <tr>
                                       <th>変更後のレイアウト</th>
                                    <td>
                                        <?= template_admin::calendar_selectbox("from".$i, $GLOBALS['GET']) ?>
                                    </td>
     <td><select name="" id="">
             <option value=""></option>
             <?php
             Form::pulldown_write_usekey($GLOBALS["MASTER"]['tanto_type'],$_SESSION[$this->session_key]['tanto_type'.$t]);
             ?>
             </select></td>
     <td><select name="" id="">
             <option value=""></option>
             <?php
             Form::pulldown_write_usekey($GLOBALS["MASTER"]['tanto_type'],$_SESSION[$this->session_key]['tanto_type'.$t]);
             ?>
             </select></td>
                                    </tr>
                                    <tr>
                                       <th>変更後の個別管理表　（不要？）</th>
                                    <td>
                                        <?= template_admin::calendar_selectbox("from".$i, $GLOBALS['GET']) ?>
                                    </td>
     <td><select name="" id="">
             <option value=""></option>
             <?php
             Form::pulldown_write_usekey($GLOBALS["MASTER"]['tanto_type'],$_SESSION[$this->session_key]['tanto_type'.$t]);
             ?>
             </select></td>
     <td><select name="" id="">
             <option value=""></option>
             <?php
             Form::pulldown_write_usekey($GLOBALS["MASTER"]['tanto_type'],$_SESSION[$this->session_key]['tanto_type'.$t]);
             ?>
             </select></td>
                                    </tr>

                                                                        <tr>
                                       <th>Share 各拠点データ更新</th>
                                    <td>
                                        <?= template_admin::calendar_selectbox("from".$i, $GLOBALS['GET']) ?>
                                    </td>
     <td><select name="" id="">
             <option value=""></option>
             <?php
             Form::pulldown_write_usekey($GLOBALS["MASTER"]['tanto_type'],$_SESSION[$this->session_key]['tanto_type'.$t]);
             ?>
             </select></td>
     <td><select name="" id="">
             <option value=""></option>
             <?php
             Form::pulldown_write_usekey($GLOBALS["MASTER"]['tanto_type'],$_SESSION[$this->session_key]['tanto_type'.$t]);
             ?>
             </select></td>
                                    </tr>
                                                                        <tr>
                                       <th>備考</th>
                                    <td colspan="3">
                                        <textarea name="" id="" cols="30" rows="10"></textarea>                                    </td>

                                    </tr>
    <tr>
                                    <td colspan="4" class="text_center"><input type="submit" value="確認画面へ" /></td>
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

            function paste_buy(){
                if(window.confirm('見積から商品情報入力欄に価格を貼り付けてもいいですか？')){
                    alert("貼り付けました。(仮)");
                }else{

                }
            }
        </script>
    <?php

    }

    function toden(){
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
     <tr>
         <th>電力需給受付日</th>
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

         <input type="button" value="戻る" onclick="location.href='./?req=<?= $GLOBALS['GET']['req']?>&id=<?= $GLOBALS['GET']['id']?>'"/>
         </td>
     </tr>
     </table>
        <?php





    }




}