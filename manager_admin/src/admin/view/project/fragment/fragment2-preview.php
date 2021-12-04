<div id="fragment-2" class="ui-tabs-panel">
      <p>             </p>
      <table class="input_form_table preview">
         <tbody>
            <tr>
               <th colspan="<?=in_array(5, $role_login_id) ? '9': '7' ?>" class="cap">商品情報</th>
            </tr>
            <tr>
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
               <?php 
                     //user_role = 5 = "案件管理 [管理者向け]（仕切値閲覧・修正可）"
                  if(in_array(5, $role_login_id)){ 
               ?> 
               <th>
                  仕切単価
               </th>
               <th>
                  仕切り金額
               </th>
               <?php } ?>
               <th style="min-width: 100px">
                  Kw/備考
               </th>
            </tr>
            <!--group1-->
               <?php for($i=1;$i<=25;$i++){ ?>
                  <tr>

                     <th class="nowrap" style="width: 13%;">
                        <?=!StringUtil::isNullOrEmpty(AppConfig::$SORT_ID[$i][2]) ? AppConfig::$SORT_ID[$i][2] : $viewState->get("prj_prod_class_nm_row$i");?>
                        <br>
                        <span style="font-weight: 400;">
                           <?php if($i<23){ ?>
                           <?=AppConfig::$PRODUCT_NAME_TYPE[$viewState->get('prj_prod_type_row'.$i)];?>      
                           <?php } ?>                     
                        </span>
                        <?php if($i==25){ ?><span class="komered">※工事負担金立替分は合計金額には含まない</span><?php } ?>
                     </th>
                     <td style="width: 12% !important;">
                        <?php if($i<23){ ?>
                        <?=AppConfig::$MAKER[ $viewState->get("prj_prod_maker_row".$i)]; ?>
                        <?php } ?>
                     </td>
                     <td style="width: 18%;">
                        <?=$viewState->get("prj_prod_model_row$i"); ?>
                     </td>
                     <td style="width: 8%;">
                        <?=$viewState->get("prj_prod_num_row$i"); ?>
                     </td>
                     <td style="width: 12%;">
                        <?=$viewState->get("prj_prod_unit_price_selling_row$i"); ?>
                     </td>
                     <td style="width: 12%;">
                        <?=$viewState->get("prj_prod_price_selling_row$i"); ?>
                     </td>
                     <?php 
                        //user_role = 5 = "案件管理 [管理者向け]（仕切値閲覧・修正可）"
                        if(in_array(5, $role_login_id)){ 
                     ?> 
                     <td style="width: 12%;">
                        <?=$viewState->get("prj_prod_unit_price_part_row$i"); ?>
                     </td>
                     <td style="width: 13%;">
                        <?=$viewState->get("prj_prod_price_part_row$i"); ?>
                     </td>
                     <?php } ?>
                     <td style="width: 20%;">
                        <?php if($i<=3){ ?>
                        <?=!StringUtil::isNullOrEmpty($viewState->get("prj_prod_kw$i")) ? $viewState->get("prj_prod_kw$i").'Kw' : ''; ?>
                        <br>
                        <?php } ?>
                        <?=nl2br($viewState->get('prj_prod_memo_row'.$i)); ?>
                     </td>
                  </tr>
               <?php } ?>
            <!--end group1-->
            <tr>
               <th>合計金額</th>
               <td></td>
               <td></td>
               <td></td>
               <td></td>
               <td id="all_hanbai">
                  <?=$viewState->get('prj_prod_price_selling_total');?>
               </td>
               <input type="hidden" name="prj_prod_price_selling_total" value="<?=$viewState->get('prj_prod_price_selling_total');?>" id="prj_prod_price_selling_total">
               <?php 
                  //user_role = 5 = "案件管理 [管理者向け]（仕切値閲覧・修正可）"
                  if(in_array(5, $role_login_id)){ 
               ?> 
               <td></td>
               <td id="all_shikiri">
                  <?=$viewState->get('prj_prod_price_part_total');?>
               </td>
               <?php } ?>
               <input type="hidden" name="prj_prod_price_part_total" value="<?=$viewState->get('prj_prod_price_part_total');?>" id="prj_prod_price_part_total">
               <td></td>
            </tr>
            <tr>
               <th colspan="1">確認事項</th>
               <td colspan="<?= in_array(5, $role_login_id) ? "8" : "6"?>">
                  <?=nl2br($viewState->get('prj_prod_checklist'));?>
               </td>
            </tr>
            <tr>
               <th colspan="1">特記事項</th>
               <td colspan="<?= in_array(5, $role_login_id) ? "8" : "6"?>">
                  <?=nl2br($viewState->get('prj_prod_notices'));?>
               </td>
            </tr>
            <!--<tr>
               <td colspan="10" class="text_center">
                  <input type="submit" value="データ更新">
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