<div id="fragment-4" class="ui-tabs-panel">
   <p>
   </p>
   <table class="input_form_table">
      <tbody>
         <tr>
            <th colspan="4" class="cap">担当者情報</th>
         </tr>
         <?php for($i=1; $i <= count(AppConfig::$STAFF_POS); $i++) { ?>
            <tr>
               <th style="width: 12%;">
                  担当者 <?=$i?> <?=$i==1?"<span class='komered'>※</span>":""?>
                  <input type="hidden" name="prj_assign_info_id<?=$i?>" value="<?=$viewState->get("prj_assign_info_id$i")?>" />
                  <input type="hidden" name="prj_assign_info_updated_time<?=$i?>" value="<?=$viewState->get("prj_assign_info_updated_time$i")?>" />                            
               </th>
               <td style="width: 38%;">
                  <?= HtmlUtil::dropList('prj_staff_id'.$i, $ds, $viewState->get("prj_staff_id$i"), "staff_id", "staff_name") ?> 
               </td>
               <th style="width: 12%;">
                  担当種別 <?=$i?>                                       
               </th>
               <td style="width: 38%;">
                  <?= AppConfig::$STAFF_POS[$i][2];?> 
               </td>
            </tr>
         <?php } ?>
         <!--
         <tr>
            <td colspan="4" class="text_center"><input type="submit" value="確認画面へ"></td>
         </tr>
      -->
      </tbody>
   </table>
   <p></p>
</div>