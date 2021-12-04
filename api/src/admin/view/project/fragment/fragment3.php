<!---prj_payment_info     prj_info -->
<script type="text/javascript">
   
</script>
<div id="fragment-3" class="ui-tabs-panel">
   <a name="payment"></a>
   <p></p>
   <table class="input_form_table">
      <tbody>
         <tr>
            <th colspan="4" class="cap">支払い情報</th>
         </tr>
         <tr>
            <th>合計金額</th>
            <td colspan="3" style="width: 75%;">
               <span id="all_hanbai2" ><?= !StringUtil::isNullOrEmpty($viewState->get('prj_prod_price_selling_total')) ? $viewState->get('prj_prod_price_selling_total') : "自動計算されます";?></span>
               <input type="hidden" id="prj_prod_price_selling_total" name="prj_prod_price_selling_total" value="<?=$viewState->get('prj_prod_price_selling_total');?>"/>
               <span id="all_hanbai3"></span>
            </td>
         </tr>
         <tr>
            <th>未納金額</th>
            <td colspan="3" style="width: 75%;">
               <input type="hidden" id="prj_pay_remain" name="prj_pay_remain" value="<?=$viewState->get('prj_pay_remain');?>"/>
               <span id="cal_1"><?=!StringUtil::isNullOrEmpty($viewState->get('prj_pay_remain')) || $viewState->get('prj_pay_remain') ==="0"  ? $viewState->get('prj_pay_remain'). '円':'自動計算されます'?></span>
               <span id="cal_2"></span>
            </td>
         </tr>
         <tr>
            <th>完納日</th>
            <td colspan="3" style="width: 75%;">
               <?=!StringUtil::isNullOrEmpty($viewState->get('prj_pay_completed_date')) ? $viewState->get('prj_pay_completed_date') : '------' ?>
            </td>
         </tr>
         <tr>
            <th>
               支払い方法
            </th>
            <td colspan="3" style="width: 75%;">
               <?= HtmlUtil::radioButtons('prj_pay_method', AppConfig::$METHOD_PAYMENT, $viewState->get("prj_pay_method")) ?>                                              
            </td>
         </tr>
         <?php for($i=1;$i<=6;$i++){ ?>
           <tr>
              <th style="width: 12%;" <?=$i==6?"class='backcolor2'":""?> >
                 <?= $i!=6? 請求日.$i:"工事負担金立替分 請求日" ?>
                 <input type="hidden" name="prj_payment_info_id<?=$i?>" value="<?=$viewState->get("prj_payment_info_id$i")?>" />  
                 <input type="hidden" name="prj_payment_info_updated_time<?=$i?>" value="<?=$viewState->get("prj_payment_info_updated_time$i")?>" />                                     
              </th>
              <td style="width: 38%;">
                 <div id="from1_id" class="from1Date" style="display: inline;">
                    <?= HtmlUtil::CalendarInput("prj_billing_date$i",$viewState->get("prj_billing_date$i"));?>
                 </div>
                 <input type="button" value="今日" class="today_button_class" onclick="today_print_split('prj_billing_date<?=$i?>')">
                 <span id="show-message-cal-bi<?=$i?>"></span>
                 <br>
                 <div style="display:inline-block">
                    支払い予定日：請求日の<input type="text" name="prj_plan_pay_day<?=$i?>" value="<?=$viewState->get("prj_plan_pay_day$i")?>"  class="input-mini ime_off">日後
                    <span id="prj_plan_pay_day<?=$i?>"></span>
                  </div>
              </td>
              <th style="width: 12%;"   <?=$i==6?"class='backcolor2'":"class='color1'"?> >
                 <?=$i!=6? 支払済日.$i:"工事負担金立替分 支払済日" ?>                                        
              </th>
              <td style="width: 38%;">
                 <div id="to1_id" class="to1Date" style="display: inline;">
                    <?= HtmlUtil::CalendarInput("prj_paid_date$i",$viewState->get("prj_paid_date$i"));?>
                 </div>
                 <input type="button" value="今日" class="today_button_class" onclick="today_print_split('prj_paid_date<?=$i?>')">
                 <span id="show_cal_message<?=$i?>"></span>
              </td>
           </tr>
           <tr>
              <th style="width: 12%;" <?=$i==6?"class='backcolor2'":""?> >
                <?=$i!=6?支払予定金額.$i:"工事負担金立替分 支払予定金額"?>                                        
              </th>
              <td style="width: 38%;">
                  <div>
                   <input type="text" name="prj_plan_pay_amount<?=$i?>" value="<?=$viewState->get("prj_plan_pay_amount$i")?>" class="input-small ime_off prj_plan_pay_amount<?=$i?>">円
                   <input type="text" name="prj_plan_pay_per<?=$i?>" value="<?=$viewState->get("prj_plan_pay_per$i")?>"  class="ime_off input-mini prj_plan_pay_per<?=$i?>" > %
                   <input type="button" value="計算" onclick="per_cnange('<?=$i?>')"> 
                  </div>
                 <span id="prj_plan_pay_amount<?=$i?>"></span>
                 <br>
                 <div style="display:inline-block">
                 <?php if($i!=6) { ?>
                 <input type="checkbox" name="prj_plan_pay_deposit<?=$i?>" <?php echo $viewState->get("prj_plan_pay_deposit$i")==1?"checked='checked'":"" ?> value="1" id="prj_plan_pay_deposit<?=$i?>"> 頭金
                 <?php } ?>
                 　メモ： <input type="text" name="prj_plan_pay_memo<?=$i?>" value="<?=$viewState->get("prj_plan_pay_memo$i")?>"   class="input-medium">
                 <br>
               </div>
                 <span id="prj_plan_pay_memo<?=$i?>"></span>
                 <?php if($i==6) echo "<br>";?>
                 <button type="button" class="btn-primary btn" onclick="window.open('./index.php?req=project&mode=pdf&report=paymentreport&prj_id=<?=$viewState->get("prj_id")?>&sordid=<?=$i?>')" ;="">請求書PDF発行</button>
              </td>
              <th style="width: 12%;" <?=$i==6?"class='backcolor2'":"class='color1'"?>>
                 <?= $i!=6?支払済金額.$i:"工事負担金立替分 支払済金額"?>                                       
              </th>
              <td style="width: 38%;">
                <!--onchange="per_cnange('<?=$i?>')"-->
                 <input type="text" name="prj_plan_paid_amount<?=$i?>" value="<?=$viewState->get("prj_plan_paid_amount$i")?>"  class="input-small ime_off prj_plan_paid_amount<?=$i?>" >円
                 　メモ： <input type="text" name="prj_plan_paid_memo<?=$i?>"  value="<?=$viewState->get("prj_plan_paid_memo$i")?>" id="prj_plan_paid_memo<?=$i?>" class="input-medium">
                 <span id="prj_plan_paid_amount<?=$i?>"></span>
                 <span id="prj_plan_paid_amount<?=$i?>"></span>
              </td>
           </tr>
         <?php } ?>
         <!--        立替分支払い-->
         <!--
         <tr>
            <td colspan="4" class="text_center"><input type="submit"  value="確認画面へ"/></td>
         </tr>
       -->
      </tbody>
   </table>
   <p></p>
</div>