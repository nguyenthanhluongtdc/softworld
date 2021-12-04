<?php 
$role_login_id = $viewState->get('role_login_id');
$actionUrl =  $urlRegist;
if(!StringUtil::isNullOrEmpty($viewState->get("prj_id"))) {
  $actionUrl =  UrlUtil::url($urlEdit, array("edit_prj_id"=>$viewState->get("prj_id")));
}
?>
<div id="content" class="clearfix">
   <div class="contentwrapper">
      <!--Content wrapper-->
      <div class="heading">
         <h3>案件登録[画面入力]</h3>
      </div>
      <!-- End .heading-->
      <!-- Build page from here: Usual with <div class="row-fluid"></div> -->
      <div class="row-fluid">
         <div class="span12">
            <div class="box gradient">
              <ul id="show-error-messages" class="item-error-messages"></ul>
              <form method="POST" action="<?=$actionUrl ?>">
               <div class="content noPad clearfix" id="DataArea">
                  <div class="margin10"> <span class="komered">※</span>は入力必須項目です。</div>
                  <table class="input_form_table">
                     <tbody>
                        <tr>
                           <th colspan="2" class="cap">お客様基本情報</th>
                        </tr>
                        <tr>
                           <th>
                              案件ID
                           </th>
                           <td>
                              <input type="hidden" name="prj_id" value="<?=$viewState->get("prj_id")?>" />
                              <?= !StringUtil::isNullOrEmpty($viewState->get("prj_id"))?$viewState->get("prj_id"): "";?>
                           </td>
                        </tr>
                        <tr>
                           <th>
                              ステータス <span class="komered">※</span>
                           </th>
                           <td>
                            <?=AppConfig::$PROJECT_STATUS[$viewState->get("prj_status")];?>
                              <br>
                              <span class="komered">※すでに歩合が支払われている案件がキャンセルとなった場合は、ステータスはキャンセルにしないで下さい。<br>下記キャンセル日の設定をして頂きますようお願い致します。</span>
                              <!--Status - widget -->
                              <?php //require_once('fragment/subtable/_status.php'); ?>
                              <!--end Status - widget -->
                           </td>
                        </tr>
                        <tr>
                           <th>
                              メーカー
                           </th>
                           <td>
                             <?=AppConfig::$MAKER[$viewState->get("prj_maker")];?>
                           </td>
                        </tr>
                        <tr>
                           <th>
                              お客様氏名 <span class="komered">※</span>
                           </th>
                           <td><?=$viewState->get("prj_cust_name");?></td>
                        </tr>
                        <tr>
                           <th>
                              住所（お客様住居）
                           </th>
                           <td>
                              〒 <?=$viewState->get("prj_cust_pos_code1");?>
                              - <?=$viewState->get("prj_cust_pos_code2");?>
                                <input type="hidden" name="prj_cust_pos_code" id="prj_cust_pos_code"  value="<?=$viewState->get('prj_cust_pos_code')?>">
                              <br>
                              <?=AppConfig::$PREFECTURE[$viewState->get("prj_cust_prefectures")];?>
                              <br>
                              市区町村：<?=$viewState->get("prj_cust_city")?>
                              <br>
                              番地等：<?=$viewState->get("prj_cust_address");?>
                              <br>
                              マンション/ビル名等：<?=$viewState->get("prj_cust_mansion_info");?>
                           </td>
                        </tr>
                        <tr>
                           <th>
                              住所（設置場所）
                           </th>
                           <td>
                              <!--<input type="button" value="お客様住居からコピー" onclick="copy_address();">-->
                              <br>
                              〒 <?=$viewState->get("prj_cust_ins_loc_pos_code1");?>
                              - <?=$viewState->get("prj_cust_ins_loc_pos_code2");?>
                              <br>
                              <?=AppConfig::$PREFECTURE[$viewState->get("prj_cust_ins_loc_prefectures")];?>
                              <br>
                              市区町村：<?=$viewState->get("prj_cust_ins_loc_city");?>
                              <br>
                              番地等：<?=$viewState->get("prj_cust_ins_loc_address");?>
                              <br>
                              マンション/ビル名等：<?=$viewState->get("prj_cust_ins_loc_mansion_info");?>
                           </td>
                        </tr>
                        <tr>
                           <th>
                              電話番号 <span class="komered">※</span>
                           </th>
                           <td>
                              <?=$viewState->get("prj_cust_phone_num");?>
                           </td>
                        </tr>
                        <tr>
                           <th>
                              メールアドレス
                           </th>
                           <td> 
                            <?=$viewState->get("prj_cust_email");?>
                          </td>
                        </tr>
                        <tr>
                           <th>
                              その他備考
                           </th>
                           <td>
                              <?= nl2br($viewState->get("prj_cust_memo"));?>
                           </td>
                        </tr>
                     </tbody>
                  </table>
                  <br>
                  <br>
                  <?php require_once('_tabs-preview.php');?>
               </div>
                <input type="hidden" value="2" name="regist_step">
                <input type="hidden" name="json_regist_data" value="<?=$viewState->get("json_regist_data")?>" >
                <input type="hidden" name="created_user" value="<?=$viewState->get("created_user")?>" />
                <input type="hidden" name="created_time" value="<?=$viewState->get("created_time")?>" />
                <input type="hidden" name="updated_user" value="<?=$viewState->get("updated_user")?>" />
                <input type="hidden" name="prj_updated_time" value="<?=$viewState->get("prj_updated_time")?>" />
                <input type="hidden" name="progress_updated_time" value="<?=$viewState->get("progress_updated_time")?>" />
              </form>
            </div>
            <!-- End .box -->
         </div>
         <!-- End .span12 -->
      </div>
      <!-- End .row-fluid -->
      <!-- Page end here -->
   </div>
   <!-- End contentwrapper -->
</div>
<script type="text/javascript">
   function per_cnange(num){
       var per = document.getElementById('per' + num).value;
       document.getElementById('en' + num).value = document.getElementById('all_hanbai2').innerHTML * per * 0.01;
   }
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
           location.href = './?req=project_regi&mode=toden&id=&type=' + toden_radio;
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
   
       var array = ['1',
       '1_1',
       '1_2 ',
       '2',
       '3',
       '4',
       '5',
       '6',
       '7',
       '7_1',
       '8',
       '9',
       '10',
       '11',
       '12',
       '13',
       '20',
       '21',
       '22',
       ''];
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
       document.getElementById('all_hanbai2').innerHTML = hanbai_value2;
       document.getElementById('all_hanbai3').innerHTML = "円";
       document.getElementById('all_shikiri').innerHTML = shikiri_value2;
   }
   function copy_address(){
   //アドレスをコピ
   document.getElementById('prj_cust_ins_loc_pos_code1').value = document.getElementById('prj_cust_pos_code1').value
   document.getElementById('prj_cust_ins_loc_pos_code2').value = document.getElementById('prj_cust_pos_code2').value
   document.getElementById('prj_cust_ins_loc_prefectures').value = document.getElementById('prj_cust_prefectures').value
   document.getElementById('prj_cust_ins_loc_city').value = document.getElementById('prj_cust_city').value
   document.getElementById('prj_cust_ins_loc_address').value = document.getElementById('prj_cust_address').value
   document.getElementById('prj_cust_ins_loc_mansion_info').value = document.getElementById('prj_cust_mansion_info').value
   }
</script>
<script type="text/javascript">
    function setTabActive(index){
      $( "#ui-tab" ).tabs({ selected: index-1 }); 
   }
   function setTabOpen(index){
      $('input#open_tab').attr('value',index);
   }
   $( document ).ready(function() {
      setTabActive(<?=!StringUtil::isNullOrEmpty($viewState->get('open_tab')) ? $viewState->get('open_tab') : 1?>);
  });
</script>