<script>
    function ExportPdf(){
        var checkbox = '';
        $("input[name='view[]']").each( function (i) {
            
            if($(this).is(':checked')){
                if (checkbox == '')
                    checkbox = parseInt(parseInt(i) + 1);
                else
                    checkbox = checkbox + '|' + parseInt(parseInt(i) + 1);
            }
       });
       window.open('index.php?req=project&mode=pdf&report=productreport&prj_id=<?=$viewState->get("prj_id")?>&checked=' + checkbox);
    }
</script>
<div id="fragment-2" class="ui-tabs-panel">
      <p></p>
      <table class="input_form_table" >
         <tbody>
            <tr>
               <th colspan="10" class="cap">商品情報</th>
            </tr>
            <tr>
               <td colspan="10">
                  <div class="text_right padding_10px">
                     <button type="button" class="btn-primary btn" onclick="ExportPdf();">個別管理表 PDF発行</button>
                  </div>
               </td>
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
               <th>
                  Kw/備考
               </th>
            </tr>
            <!--group1-->
               <?php for($i=1;$i<=25;$i++){ ?>
                  <tr>
                  <th><input type="checkbox" name="view[]" id="" checked="checked">
                     <input type="hidden" id="prj_prod_info_id<?=$i?>" name="prj_prod_info_id<?=$i?>" value="<?=$viewState->get("prj_prod_info_id$i")?>" >
                     <input type="hidden" id="prj_prod_info_updated_time<?=$i?>" name="prj_prod_info_updated_time<?=$i?>" value="<?=$viewState->get("prj_prod_info_updated_time$i")?>" >
                  </th>
                  <th class="nowrap" style="width: 13%;"><?=!StringUtil::isNullOrEmpty(AppConfig::$SORT_ID[$i][2]) ? AppConfig::$SORT_ID[$i][2] : ""; ""?>
                     <?php if(!StringUtil::isNullOrEmpty(AppConfig::$SORT_ID[$i][2])) { ?>
                     <input type="hidden" name="prj_prod_class_nm_row<?=$i?>" value="<?=AppConfig::$SORT_ID[$i][2] ?>">
                     <?php }else{ ?>
                        <input type="text" class="input-small" id="prj_prod_class_nm_row<?=$i?>" name="prj_prod_class_nm_row<?=$i?>" value="<?=$viewState->get("prj_prod_class_nm_row$i")?>" >
                     <?php } ?>
                     <br>
                     <?php if($i==25){ ?><span class="komered">※工事負担金立替分は合計金額には含まない</span><?php } ?>
                     <span style="font-weight: 400;">
                        <?php if($i<23){ ?>
                        <?=HtmlUtil::radioButtons('prj_prod_type_row'.$i, AppConfig::$PRODUCT_NAME_TYPE, $viewState->get('prj_prod_type_row'.$i),null,null,'block')?> 
                        <?php } ?>                            
                     </span>
                     </th>
                     <td style="width: 12%;">
                        <?php if($i<23){ ?>
                        <?= HtmlUtil::dropList('prj_prod_maker_row'.$i, AppConfig::$MAKER, $viewState->get("prj_prod_maker_row".$i), null, null, null, array("" => ""), 'input-input-medium') ?>
                        <?php } ?> 
                     </td>
                     <td style="width: 18%;">
                        <input type="text" name="prj_prod_model_row<?=$i?>" id="prj_prod_model_row<?=$i?>" class="input-medium" value="<?=$viewState->get("prj_prod_model_row$i")?>">
                     </td>
                     <td style="width: 8%;">
                        <input type="text" name="prj_prod_num_row<?=$i?>" id="prj_prod_num_row<?=$i?>" class="input-XXmini ime_off" value="<?=$viewState->get("prj_prod_num_row$i")?>" onchange="total('<?=$i?>');">
                     </td>
                     <td style="width: 12%;">
                         \<br>
                        <input type="text" name="prj_prod_unit_price_selling_row<?=$i?>" id="prj_prod_unit_price_selling_row<?=$i?>" class="input-mini ime_off" onchange="total('<?=$i?>');" value="<?=$viewState->get("prj_prod_unit_price_selling_row$i")?>">
                     </td>
                     <td style="width: 12%;">
                         \<br>
                        <input type="text" name="prj_prod_price_selling_row<?=$i?>" id="prj_prod_price_selling_row<?=$i?>" class="input-mini ime_off" onchange="total('<?=$i?>');" value="<?=$viewState->get("prj_prod_price_selling_row$i")?>">
                     </td>

                     <?php 
                     //user_role = 5 = "案件管理 [管理者向け]（仕切値閲覧・修正可）"
                     if(in_array(5, $role_login_id)){ 
                     ?> 
                     <td style="width: 12%;">
                         \<br>
                        <input type="text" name="prj_prod_unit_price_part_row<?=$i?>" id="prj_prod_unit_price_part_row<?=$i?>" class="input-mini ime_off" onchange="total('<?=$i?>');" value="<?=$viewState->get("prj_prod_unit_price_part_row$i")?>">
                     </td>
                     <td style="width: 13%;">
                         \<br>
                        <input type="text" name="prj_prod_price_part_row<?=$i?>" id="prj_prod_price_part_row<?=$i?>" class="input-mini ime_off" onchange="total('<?=$i?>');" value="<?=$viewState->get("prj_prod_price_part_row$i")?>">
                     </td>
                     <?php } ?>
                     <td style="width: 20%;">
                        <?php if($i<= 3){ ?>
                        <input id="prj_prod_kw<?=$i?>" class="input-mini ime_off" type="text" value="<?=$viewState->get("prj_prod_kw$i")?>" name="prj_prod_kw<?=$i?>">
                        Kw
                        <br>
                        <?php } ?>
                        <textarea name="prj_prod_memo_row<?=$i?>" id="prj_prod_memo_row<?=$i?>" rows="3" class="input-small"><?=$viewState->get('prj_prod_memo_row'.$i)?></textarea>
                     </td>
                  </tr>
               <?php } ?>
            <!--end group1-->
            <tr>
               <th colspan="2">合計金額</th>
               <td></td>
               <td></td>
               <td></td>
               <td></td>
               
               <td id="all_hanbai">
                  <?=$viewState->get('prj_prod_price_selling_total');?>
               </td>
               <!--<input type="hidden" name="prj_prod_price_selling_total" value="<?=$viewState->get('prj_prod_price_selling_total');?>" id="prj_prod_price_selling_total">-->
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
               <th colspan="2">確認事項</th>
               <td colspan="8">
                  <textarea name="prj_prod_checklist" id="prj_prod_checklist" cols="30" rows="10"><?=$viewState->get('prj_prod_checklist');?></textarea>
               </td>
            </tr>
            <tr>
               <th colspan="2">特記事項</th>
               <td colspan="8">
                  <textarea name="prj_prod_notices" id="prj_prod_notices" cols="30" rows="10"><?=$viewState->get('prj_prod_notices');?></textarea>
               </td>
            </tr>
            <!--
            <tr>
               <td colspan="10" class="text_center"><input type="submit" value="確認画面へ"></td>
            </tr>
         -->
         </tbody>
      </table>
      <p></p>
   </div>