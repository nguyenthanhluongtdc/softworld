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
                  <?= $viewState->get('prj_prod_price_selling_total')?>
               </td>
            </tr>
            <tr>
               <th>未納金額</th>
               <td colspan="3" style="width: 75%;">
                <?=$viewState->get('prj_pay_remain')?>円
               </td>
            </tr>
            <tr>
               <th>完納日</th>
               <td colspan="3" style="width: 75%;">
                  ------
               </td>
            </tr>
            <tr>
               <th>
                  支払い方法
               </th>
               <td colspan="3" style="width: 75%;">
                  <?=AppConfig::$METHOD_PAYMENT[$viewState->get("prj_pay_method")];?>                                                        
               </td>
            </tr>            
            <?php for($i=1;$i<=6;$i++){ ?>
               <tr>
                  <th style="width: 12%;" <?=$i==6?"class='backcolor2'":""?> >
                    <?= $i !=6 ? '請求日'.$i: '工事負担金立替分 請求日'?>                                  
                  </th>
                  <td style="width: 38%;">
                     <div id="from1_id" class="from1Date" style="display: inline;">
                       <?= DateUtil::PreviewDate($viewState->get("prj_billing_date$i"))?>
                     </div>
                     <br>
                     支払い予定日：請求日の <?=$viewState->get("prj_plan_pay_day$i")?> 日後
                  </td>
                  <th style="width: 12%;"   <?=$i==6?"class='backcolor2'":"class='color1'"?> >
                    <?= $i !=6 ? '支払済日'.$i: '工事負担金立替分 支払済日'?>                                    
                  </th>
                  <td style="width: 38%;">
                     <div id="to1_id" class="to1Date" style="display: inline;">
                        <?= DateUtil::PreviewDate($viewState->get("prj_paid_date$i"))?>
                     </div>
                  </td>
               </tr>
               <tr>
                  <th style="width: 12%;" <?=$i==6?"class='backcolor2'":""?> >
                    <?= $i !=6 ? '支払予定金額'.$i: '工事負担金立替分 支払予定金額'?>                                     
                  </th>
                  <td style="width: 38%;">
                     <?=$viewState->get("prj_plan_pay_amount$i")?>円
                     <?=$viewState->get("prj_plan_pay_per$i")?>%
                     <br>
                     <?php if($i!=6) { ?>
                     <?= $viewState->get("prj_plan_pay_deposit$i")==1?"頭金":"";?>
                     <?php } ?>
                    　メモ： <?=$viewState->get("prj_plan_pay_memo$i")?>
                     <br>
                     
                  </td>
                  <th style="width: 12%;" <?=$i==6?"class='backcolor2'":"class='color1'"?>>
                    <?= $i != 6 ? '支払済金額'.$i: '工事負担金立替分 支払済金額'?>                                    
                  </th>
                  <td style="width: 38%;">
                    <?=$viewState->get("prj_plan_paid_amount$i")?>円
                    　メモ： <?=$viewState->get("prj_plan_paid_memo$i")?>
                  </td>
               </tr>
            <?php } ?>
            <!--        立替分支払い-->
            <!--<tr>
               <td colspan="4" class="text_center">
                <input type="submit" autofocus value="データ更新" />
                <input type="button" 
                submit-action = "<?=$actionUrl?>"
                submit-method = "post"
                submit-data='{"regist_step":3, "json_regist_data":<?=$viewState->get("json_regist_data", ViewState::JS_VARIABLE)?>}' 
                class="submit-form" value="もどる" />
            </td>
            </tr>-->
         </tbody>
      </table>
      <p></p>
   </div>