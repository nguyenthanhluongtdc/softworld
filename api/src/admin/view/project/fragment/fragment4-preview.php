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
                  担当者 <?=$i?>      
               </th>
               <td style="width: 38%;">
                  <?php 
                    if(!empty($ds))
                    foreach ($ds as  $value) {
                        if($value['staff_id'] == $viewState->get('prj_staff_id'.$i))
                        {
                          echo $value['staff_name'];
                          break;
                        }
                    }
                  ?> 
               </td>
               <th style="width: 12%;">
                  担当種別 <?=$i?>                                       
               </th>
               <td style="width: 38%;">
                  <?= AppConfig::$STAFF_POS[$i][2];?> 
               </td>
            </tr>
         <?php } ?>
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