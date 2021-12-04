<div id="fragment-1" class="ui-tabs-panel">
   <p>
   </p>
   <table class="input_form_table">
      <tbody>
         <tr>
            <th colspan="4" class="cap">日程・各種履歴・帳票情報</th>
         </tr>
         <tr>
            <th>種別</th>
            <td>
               <table class="width_100per">
                  <tbody>
                     <tr>
                        <th>契約種別</th>
                        <td>
                          <?= HtmlUtil::radioButtons('prj_kind_contract', AppConfig::$CONTRACT, $viewState->get('prj_kind_contract')) ?>                           
                        </td>
                     </tr>
                     <tr>
                        <th>車庫</th>
                        <td>
                          <?= HtmlUtil::dropList('prj_kind_garage', AppConfig::$GARAGE, $viewState->get("prj_kind_garage")) ?>
                        </td>
                     </tr>
                     <tr>
                        <th>PV</th>
                        <td>
                          <?= HtmlUtil::checkBoxs('prj_kind_pv[]', AppConfig::$PV, $viewState->get("prj_kind_pv"))?>
                        </td>
                     </tr>
                     <tr>
                        <th>OD</th>
                        <td>
                          <?= HtmlUtil::checkBoxs('prj_kind_od[]', AppConfig::$OD, $viewState->get("prj_kind_od"))?>
                        </td>
                     </tr>
                  </tbody>
               </table>
            </td>
         </tr>
         <tr>
            <th>現調日</th>
            <td>
              <?= HtmlUtil::CalendarInput('prj_gencho_bi',$viewState->get("prj_gencho_bi"));?>
              <span id="prj_gencho_bi_msg"></span>
            </td>
         </tr>
         <tr>
         </tr>
         <tr>
            <th>契約日</th>
            <td>
              <?= HtmlUtil::CalendarInput('prj_keiyaku_bi',$viewState->get("prj_keiyaku_bi"));?>
              <span id="prj_keiyaku_bi_msg"></span>
            </td>
         </tr>
         <tr>
            <th>工事開始日</th>
            <td>
               <?= HtmlUtil::CalendarInput('prj_koji_kaishi_bi',$viewState->get("prj_koji_kaishi_bi"));?>
               <span id="prj_koji_kaishi_bi_msg"></span>
            </td>
         </tr>
         <tr>
            <th>設備認定 申請日1</th>
            <td>
              <?= HtmlUtil::CalendarInput('prj_setsubi_nintei_shinsei_bi1',$viewState->get("prj_setsubi_nintei_shinsei_bi1"));?>
              <span id="prj_setsubi_nintei_shinsei_bi1_msg"></span>
            </td>
         </tr>
         <tr>
            <th>設備認定 申請日2</th>
            <td>
               <?= HtmlUtil::CalendarInput('prj_setsubi_nintei_shinsei_bi2',$viewState->get("prj_setsubi_nintei_shinsei_bi2"));?>
               <span id="prj_setsubi_nintei_shinsei_bi2_msg"></span>
            </td>
         </tr>
         <tr>
            <th>設備認定 申請日3</th>
            <td>
               <?= HtmlUtil::CalendarInput('prj_setsubi_nintei_shinsei_bi3',$viewState->get("prj_setsubi_nintei_shinsei_bi3"));?>
               <span id="prj_setsubi_nintei_shinsei_bi3_msg"></span>
            </td>
         </tr>
         <tr>
            <th>内落予定日</th>
            <td>
               <?= HtmlUtil::CalendarInput('prj_uchi_ochi_yotei_bi',$viewState->get("prj_uchi_ochi_yotei_bi"));?>
               <span id="prj_uchi_ochi_yotei_bi_msg"></span>
            </td>
         </tr>
         <tr>
            <th>内落確定日</th>
            <td>
              <?= HtmlUtil::CalendarInput('prj_uchi_ochi_kakutei_bi',$viewState->get("prj_uchi_ochi_kakutei_bi"));?>
              <span id="prj_uchi_ochi_kakutei_bi_msg"></span>
            </td>
         </tr>
         <tr>
            <th>連系日</th>
            <td>
               <?= HtmlUtil::CalendarInput('prj_renkei_bi',$viewState->get("prj_renkei_bi"));?>
               <input type="checkbox" name="prj_renkei_done" class="form_radio" value="1" id="prj_renkei_done" <?=$viewState->get('prj_renkei_done') == 1 ? "checked" : '';?> >
               <label for="prj_renkei_done" style="display: inline;">営業宛連絡済</label>  &nbsp;&nbsp;
               <span id="prj_renkei_bi_msg"></span>
            </td>
         </tr>
         <tr>
            <th>完工日</th>
            <td>
               <?= HtmlUtil::CalendarInput('prj_kanko_bi',$viewState->get("prj_kanko_bi"));?>
               <span id="prj_kanko_bi_msg"></span>
            </td>
         </tr>
         <tr>
            <th>設置費用年報申請日</th>
            <td>
               <?= HtmlUtil::CalendarInput('prj_setchi_hiyo_nenpo_shinsei_bi',$viewState->get("prj_setchi_hiyo_nenpo_shinsei_bi"));?>
               <span id="prj_setchi_hiyo_nenpo_shinsei_bi_msg"></span>
         </tr>
         <tr>
            <th>運転費用年報申請日</th>
            <td>
                <?= HtmlUtil::CalendarInput('prj_unten_hiyo_nenpo_shinsei_bi',$viewState->get("prj_unten_hiyo_nenpo_shinsei_bi"));?>
                <span id="prj_unten_hiyo_nenpo_shinsei_bi_msg"></span>
            </td>
         </tr>
         <tr>
            <th>キャンセル日</th>
            <td>
            <?= HtmlUtil::CalendarInput('prj_kyanceru_bi',$viewState->get("prj_kyanceru_bi"));?>
            <span id="prj_kyanceru_bi_msg"></span>
               <br>
               <span class="komered">※すでに歩合が支払われている案件がキャンセルとなった場合に、キャンセルとなった日付を設定して下さい。</span>
            </td>
         </tr>
         <tr>
            <th>各種書類履歴</th>
            <td>
               <div class="scroll_h" style="height: 100px">
                  <?php require_once('subtable/table1.php'); ?>
               </div>
            </td>
         </tr>
         <tr>
            <th>各種書類アップロード
            </th>
            <td>
               <?= HtmlUtil::UploadFileInput('prj_file_file_name1', $viewState->get('prj_file_file_name1'), $viewState->get('prj_file_file_name1_tmp')); ?>
             
               種別：
               <?= HtmlUtil::dropList('prj_file_shubetsu', AppConfig::$DOCS_TYPE, $viewState->get("prj_file_shubetsu")) ?>
               <br>
               <div style="display:inline-block;width:100%;"><span id="prj_file_file_name1_error"></span></div>
               <span style="display:inline-flex;" class="komered">※ここでアップロードされたファイルは、案件<?=!StringUtil::isNullOrEmpty($viewState->get("prj_id"))? "ID ".$viewState->get("prj_id") : "";?>に関連付けられます。</span>
            </td>
         </tr>
         <tr>
            <th>見積履歴</th>
            <td>
               <!--                 <span class="komered">※金額をクリックすると、見積内容が商品情報入力欄に貼り付けられます。</span>-->
               <div class="scroll_h" style="height: 100px">
                  <?php require_once('subtable/table2.php'); ?>
               </div>
            </td>
         </tr>
         <tr>
            <th>見積アップロード
            </th>
            <td>
              <?= HtmlUtil::UploadFileInput('prj_file_file_name2', $viewState->get('prj_file_file_name2'), $viewState->get('prj_file_file_name2_tmp')); ?>
               <br>
               <div style="display:inline-block;width:100%;"><span id="prj_file_file_name2_error"></span></div>
               <span style="display:inline-flex;" class="komered">※ここでアップロードされた見積は、案件<?=!StringUtil::isNullOrEmpty($viewState->get("prj_id"))? "ID ".$viewState->get("prj_id") : "";?>に関連付けられます。</span>
            </td>
         </tr>
         <tr>
            <th>案件変更履歴</th>
            <td>
               <div class="scroll_h" style="height: 100px">
                  <?php require_once('subtable/table3.php'); ?>
               </div>
            </td>
         </tr>
         <!--<tr>
            <td colspan="2" class="text_center">
               <input type="submit" value="確認画面へ">
               <input type="checkbox" name="notsavehistory" value="1" <?=$viewState->get('notsavehistory')==1 ? "checked": ""?> > 
                  <span class="komered" style="display:inline-flex;color:red">※案件更新履歴を保存しない</span>
            </td>
         </tr>-->
      </tbody>
   </table>
   <p></p>
</div>
<script type="text/javascript">
   function deleteFile(id){
   if(confirm('削除してもよろしいですか？')){
      $.ajax({
         type: 'post',
         dateType: 'json',
         url: "<?=$urlDeleteFileHistory;?>",
         data:{"id": id},
         success: function (result){
            console.log(result);
            var data = JSON.parse(result);
            console.log('data');
            console.log(data);
            if(data.status == '1'){
               alert(data.msg);
               $('#file'+id).hide();
            }else{
               alert(data.msg);
            }
         }
      });
   }
  }
</script>