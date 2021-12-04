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
            <ul id="show-error-messages" class="item-error-messages header-error-messages updatemessage"></ul>
            <div class="box gradient">
              
              <form method="POST" action="<?=$actionUrl ?>" enctype="multipart/form-data" id="FrmProject">
               <input type="hidden" value="<?=!StringUtil::isNullOrEmpty($viewState->get('open_tab')) ? $viewState->get('open_tab') : 1?>" name="open_tab" id="open_tab">
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
                              <?= !StringUtil::isNullOrEmpty($viewState->get("prj_id"))?$viewState->get("prj_id"): ""?>
                           </td>
                        </tr>
                        <tr>
                           <th>
                              ステータス <span class="komered">※</span>
                           </th>
                           <td>
                             <?= HtmlUtil::dropList('prj_status', AppConfig::$PROJECT_STATUS, $viewState->get("prj_status")) ?>
                              <br>
                              <span class="komered">※すでに歩合が支払われている案件がキャンセルとなった場合は、ステータスはキャンセルにしないで下さい。<br>下記キャンセル日の設定をして頂きますようお願い致します。</span>
                              <!--Status - widget -->
                              <?php if(!StringUtil::isNullOrEmpty($viewState->get('prj_id'))):?>
                              <?php require_once('fragment/subtable/_status.php') ?>
                              <?php endif;?>
                              <!--end Status - widget -->
                           </td>
                        </tr>
                        <tr>
                           <th>
                              メーカー
                           </th>
                           <td>
                            <?= HtmlUtil::dropList('prj_maker', AppConfig::$MAKER, $viewState->get("prj_maker")) ?>
                           </td>
                        </tr>
                        <tr>
                           <th>
                              お客様氏名 <span class="komered">※</span>
                           </th>
                           <td><input type="text" name="prj_cust_name" id="prj_cust_name" value="<?=$viewState->get("prj_cust_name")?>"></td>
                        </tr>
                        <tr>
                           <th>
                              住所（お客様住居）
                           </th>
                           <td>
                              〒 <input type="text" name="prj_cust_pos_code1" id="prj_cust_pos_code1" class="input-mini" value="<?=$viewState->get("prj_cust_pos_code1")?>">
                              - <input type="text" name="prj_cust_pos_code2" id="prj_cust_pos_code2" class="input-mini" value="<?=$viewState->get("prj_cust_pos_code2")?>">
                                <input type="hidden" name="prj_cust_pos_code" id="prj_cust_pos_code"  value="<?=$viewState->get('prj_cust_pos_code')?>">
                              <br>
                               <?= HtmlUtil::dropList('prj_cust_prefectures', AppConfig::$PREFECTURE, $viewState->get("prj_cust_prefectures")) ?>
                              <br>
                              市区町村：<input type="text" name="prj_cust_city" id="prj_cust_city" value="<?=$viewState->get("prj_cust_city")?>" >
                              <br>
                              番地等：<input type="text" name="prj_cust_address" id="prj_cust_address" value="<?=$viewState->get("prj_cust_address")?>">
                              <br>
                              マンション/ビル名等：<input type="text" name="prj_cust_mansion_info" id="prj_cust_mansion_info" value="<?=$viewState->get("prj_cust_mansion_info")?>">
                           </td>
                        </tr>
                        <tr>
                           <th>
                              住所（設置場所）
                           </th>
                           <td>
                              <input type="button" value="お客様住居からコピー" onclick="copy_address();">
                              <br>
                              〒 <input type="text" name="prj_cust_ins_loc_pos_code1" id="prj_cust_ins_loc_pos_code1"  class="input-mini" value="<?=$viewState->get("prj_cust_ins_loc_pos_code1")?>">
                              - <input type="text" name="prj_cust_ins_loc_pos_code2" id="prj_cust_ins_loc_pos_code2" class="input-mini" value="<?=$viewState->get("prj_cust_ins_loc_pos_code2")?>">
                              <input type="hidden" name="prj_cust_ins_loc_pos_code" id="prj_cust_ins_loc_pos_code"  value="<?=$viewState->get('prj_cust_ins_loc_pos_code')?>">
                              <br>
                              <?= HtmlUtil::dropList('prj_cust_ins_loc_prefectures', AppConfig::$PREFECTURE, $viewState->get("prj_cust_ins_loc_prefectures")) ?>
                              <br>
                              市区町村：<input type="text" name="prj_cust_ins_loc_city" id="prj_cust_ins_loc_city" value="<?=$viewState->get("prj_cust_ins_loc_city")?>">
                              <br>
                              番地等：<input type="text" name="prj_cust_ins_loc_address" id="prj_cust_ins_loc_address" value="<?=$viewState->get("prj_cust_ins_loc_address")?>">
                              <br>
                              マンション/ビル名等：<input type="text" name="prj_cust_ins_loc_mansion_info" id="prj_cust_ins_loc_mansion_info" value="<?=$viewState->get("prj_cust_ins_loc_mansion_info")?>">
                           </td>
                        </tr>
                        <script type="text/javascript" src="../theme/admin/js/jquery.jpostal.js"></script>
                        <script type="text/javascript">
                           $(window).ready( function() {
                           //jpostal用処理
                           $('#prj_cust_pos_code1').jpostal({
                            postcode : [
                            '#prj_cust_pos_code1',
                            '#prj_cust_pos_code2'
                            ],
                            address : {
                                '#prj_cust_prefectures'  : '%3',
                                '#prj_cust_city'  : '%4',
                                '#prj_cust_address'  : '%5'
                            }
                           });
                           
                           $('#prj_cust_ins_loc_pos_code1').jpostal({
                            postcode : [
                            '#prj_cust_ins_loc_pos_code1',
                            '#prj_cust_ins_loc_pos_code2'
                            ],
                            address : {
                                '#prj_cust_ins_loc_prefectures'  : '%3',
                                '#prj_cust_ins_loc_city'  : '%4',
                                '#prj_cust_ins_loc_address'  : '%5'
                            }
                           });
                           });
                        </script>
                        <tr>
                           <th>
                              電話番号 <span class="komered">※</span>
                           </th>
                           <td>
                            <input type="text" name="prj_cust_phone_num" id="prj_cust_phone_num" value="<?=$viewState->get("prj_cust_phone_num")?>">
                           </td>
                        </tr>
                        <tr>
                           <th>
                              メールアドレス
                           </th>
                           <td> 
                            <input type="text" name="prj_cust_email" id="prj_cust_email" value="<?=$viewState->get("prj_cust_email")?>">
                          </td>
                        </tr>
                        <tr>
                           <th>
                              その他備考
                           </th>
                           <td>
                              <textarea name="prj_cust_memo" id="prj_cust_memo" cols="30" rows="10"><?=$viewState->get("prj_cust_memo")?></textarea>
                           </td>
                        </tr>
                     </tbody>
                  </table>
                  <br>
                  <br>
                  <?php require_once('_tabs.php');?>
               </div>
                <input type="hidden" value="1" name="regist_step">
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
  /*for cal in fragment3*/
  function cal(){
      var total = 0;
      var total_left = 0;
      var total_right = 0;
      for (var i = 1; i <= 5;  i++) {
          var prj_plan_pay_amount = $(".prj_plan_pay_amount"+i).val();
          var prj_plan_paid_amount = $(".prj_plan_paid_amount"+i).val();
          if(isNaN(parseInt(prj_plan_pay_amount)) === false)
          {
            total_left += parseInt(prj_plan_pay_amount);
          }
          if(isNaN(parseInt(prj_plan_paid_amount)) === false){
            total_right += parseInt(prj_plan_paid_amount);
          }
      };
      total = total_left - total_right;
      $("#cal_1").text(total + " 円");     
      $("#prj_pay_remain").val(total);   
   };
   function per_cnange(num){
       var per = $('.prj_plan_pay_per' + num).val();
       var pay = Math.floor(document.getElementById('all_hanbai2').innerHTML * per * 0.01);
       $('.prj_plan_pay_amount' + num).val(pay);
       cal();
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
   <?php if(in_array(5, $role_login_id)){ ?> 
   function total(id_num) {
   
   //                num prj_prod_num_row1
   //                tanka prj_prod_unit_price_selling_row1
   //                hanbai prj_prod_price_selling_row1
   //                tanka_s prj_prod_unit_price_part_row1
   //                shikiri prj_prod_price_part_row1
   
       var num = "prj_prod_num_row" + id_num; 
       var tanka = "prj_prod_unit_price_selling_row" + id_num;
       var hanbai = "prj_prod_price_selling_row" + id_num;
       var tanka_s = "prj_prod_unit_price_part_row" + id_num;
       var shikiri = "prj_prod_price_part_row" + id_num;

       var hanbai_value = document.getElementById(num).value * document.getElementById(tanka).value
       document.getElementById(hanbai).value = hanbai_value;
       var shikiri_value = document.getElementById(num).value * document.getElementById(tanka_s).value
       document.getElementById(shikiri).value = shikiri_value;
       //合計計算
       var array = [
         '1',
         '2',
         '3',
         '4',
         '5',
         '6',
         '7',
         '8',
         '9',
         '10',
         '11',
         '12',
         '13',
         '14',
         '15',
         '16',
         '17',
         '18',
         '19',
         '20',
         '21',
         '22',
         '23',
         '24',
         '25'
         ];
       var i;
       var num = array.length;
       var hanbai_value2 = 0;
       var shikiri_value2 = 0;
       for(i=0;i < num;i++){
           var hanbai = "prj_prod_price_selling_row" + array[i];
           var shikiri = "prj_prod_price_part_row" + array[i];
           if (document.getElementById(hanbai) != null) {
           var hanbai_v = document.getElementById(hanbai).value;
           }
           if (document.getElementById(shikiri) != null) {
           var shikiri_v = document.getElementById(shikiri).value;
           }
           if(i < 22){
            if(isNaN(parseInt(hanbai_v)) === false){
             hanbai_value2 += parseInt(hanbai_v);
             }
             if(isNaN(parseInt(shikiri_v)) === false){
             shikiri_value2 += parseInt(shikiri_v);
             }
           }
           else if(i!=24){
            if(isNaN(parseInt(hanbai_v)) === false){
             hanbai_value2 -= parseInt(hanbai_v);
             }
             if(isNaN(parseInt(shikiri_v)) === false){
             shikiri_value2 -= parseInt(shikiri_v);
             }
           }
       }
       document.getElementById('all_hanbai').innerHTML = hanbai_value2;
       document.getElementById('all_hanbai2').innerHTML = hanbai_value2;
       document.getElementById('all_hanbai3').innerHTML = "円";
       document.getElementById('all_shikiri').innerHTML = shikiri_value2;
       document.getElementById('prj_prod_price_selling_total').value  = hanbai_value2;
       document.getElementById('prj_prod_price_part_total').value  = shikiri_value2;
       
   }
   <?php }else{ ?>
    function total(id_num) {
       var num = "prj_prod_num_row" + id_num; 
       var tanka = "prj_prod_unit_price_selling_row" + id_num;
       var hanbai = "prj_prod_price_selling_row" + id_num;
       var hanbai_value = document.getElementById(num).value * document.getElementById(tanka).value
       document.getElementById(hanbai).value = hanbai_value;
       var array = [
         '1',
         '2',
         '3',
         '4',
         '5',
         '6',
         '7',
         '8',
         '9',
         '10',
         '11',
         '12',
         '13',
         '14',
         '15',
         '16',
         '17',
         '18',
         '19',
         '20',
         '21',
         '22',
         '23',
         '24',
         '25'
         ];
       var i;
       var num = array.length;
       var hanbai_value2 = 0;
       for(i=0;i < num;i++){
           var hanbai = "prj_prod_price_selling_row" + array[i];
           if (document.getElementById(hanbai) != null) {
           var hanbai_v = document.getElementById(hanbai).value;
           }
           if(i < 22){
            if(isNaN(parseInt(hanbai_v)) === false){
             hanbai_value2 += parseInt(hanbai_v);
             }
           }
           else if(i!=24){
            if(isNaN(parseInt(hanbai_v)) === false){
             hanbai_value2 -= parseInt(hanbai_v);
             }
           }
       }
       document.getElementById('all_hanbai').innerHTML = hanbai_value2;
       document.getElementById('all_hanbai2').innerHTML = hanbai_value2;
       document.getElementById('all_hanbai3').innerHTML = "円";
       document.getElementById('prj_prod_price_selling_total').value  = hanbai_value2;
   }
   <?php } ?>
   function copy_address(){
   //アドレスをコピ
   document.getElementById('prj_cust_ins_loc_pos_code1').value = document.getElementById('prj_cust_pos_code1').value
   document.getElementById('prj_cust_ins_loc_pos_code2').value = document.getElementById('prj_cust_pos_code2').value
   document.getElementById('prj_cust_ins_loc_prefectures').value = document.getElementById('prj_cust_prefectures').value
   document.getElementById('prj_cust_ins_loc_city').value = document.getElementById('prj_cust_city').value
   document.getElementById('prj_cust_ins_loc_address').value = document.getElementById('prj_cust_address').value
   document.getElementById('prj_cust_ins_loc_mansion_info').value = document.getElementById('prj_cust_mansion_info').value
   }

   function setTabActive(index){
      $( "#ui-tab" ).tabs({ selected: index-1 }); 
   }
   function setTabOpen(index){
      $('input#open_tab').attr('value',index);
   }
</script>
<script type="text/javascript">
   $( document ).ready(function() {
      setTabActive(<?=!StringUtil::isNullOrEmpty($viewState->get('open_tab')) ? $viewState->get('open_tab') : 1?>);
  });
</script>