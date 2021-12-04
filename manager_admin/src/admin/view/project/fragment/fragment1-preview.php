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
                          <?=AppConfig::$CONTRACT[$viewState->get("prj_kind_contract")];?>                              
                        </td>
                     </tr>
                     <tr>
                        <th>車庫</th>
                        <td>
                          <?=AppConfig::$GARAGE[$viewState->get("prj_kind_garage")];?>
                        </td>
                     </tr>
                     <tr>
                        <th>PV</th>
                        <td>
                          <?php
                            if(!ArrayUtil::isNullOrEmpty($viewState->get('prj_kind_pv')) && !StringUtil::isNullOrEmpty($viewState->get('prj_kind_pv'))){
                              $prj_kind_pv = $viewState->get('prj_kind_pv');
                              if(!empty($prj_kind_pv))
                              foreach ($prj_kind_pv as  $value) {
                                  echo AppConfig::$PV[$value]."&nbsp;";
                              }
                            }
                          ?>
                        </td>
                     </tr>
                     <tr>
                        <th>OD</th>
                        <td>
                          <?php
                            if(!ArrayUtil::isNullOrEmpty($viewState->get('prj_kind_od')) && !StringUtil::isNullOrEmpty($viewState->get('prj_kind_pv'))){
                              $prj_kind_od = $viewState->get('prj_kind_od');
                              if(!empty($prj_kind_od))
                              foreach ($prj_kind_od as  $value) {
                                  echo AppConfig::$OD[$value]."&nbsp;";
                              }
                            }
                          ?>
                        </td>
                     </tr>
                  </tbody>
               </table>
            </td>
         </tr>
         <tr>
            <th>現調日</th>
            <td>
                <?= DateUtil::PreviewDate($viewState->get('prj_gencho_bi'))?>
            </td>
         </tr>
         <tr>
         </tr>
         <tr>
            <th>契約日</th>
            <td>
              <?= DateUtil::PreviewDate($viewState->get('prj_keiyaku_bi'))?>
            </td>
         </tr>
         <tr>
            <th>工事開始日</th>
            <td>
              <?= DateUtil::PreviewDate($viewState->get('prj_koji_kaishi_bi'))?>
            </td>
         </tr>
         <tr>
            <th>設備認定 申請日1</th>
            <td>
              <?= DateUtil::PreviewDate($viewState->get('prj_setsubi_nintei_shinsei_bi1'))?>
            </td>
         </tr>
         <tr>
            <th>設備認定 申請日2</th>
            <td>
              <?= DateUtil::PreviewDate($viewState->get('prj_setsubi_nintei_shinsei_bi2'))?>
            </td>
         </tr>
         <tr>
            <th>設備認定 申請日3</th>
            <td>
              <?= DateUtil::PreviewDate($viewState->get('prj_setsubi_nintei_shinsei_bi3'))?>
            </td>
         </tr>
         <tr>
            <th>内落予定日</th>
            <td>
              <?= DateUtil::PreviewDate($viewState->get('prj_uchi_ochi_yotei_bi'))?>
            </td>
         </tr>
         <tr>
            <th>内落確定日</th>
            <td>
              <?= DateUtil::PreviewDate($viewState->get('prj_uchi_ochi_kakutei_bi'))?>
            </td>
         </tr>
         <tr>
            <th>連系日</th>
            <td>
              <?= DateUtil::PreviewDate($viewState->get('prj_renkei_bi'))?>
              <?= $viewState->get('prj_renkei_done') == 1 ? '営業宛連絡済' : ''; ?>
            </td>
         </tr>
         <tr>
            <th>完工日</th>
            <td>
              <?= DateUtil::PreviewDate($viewState->get('prj_kanko_bi'))?>
            </td>
         </tr>
         <tr>
            <th>設置費用年報申請日</th>
            <td>
              <?= DateUtil::PreviewDate($viewState->get('prj_setchi_hiyo_nenpo_shinsei_bi'))?>
            </td>
         </tr>
         <tr>
            <th>運転費用年報申請日</th>
            <td>
              <?= DateUtil::PreviewDate($viewState->get('prj_unten_hiyo_nenpo_shinsei_bi'))?>
            </td>
         </tr>
         <tr>
            <th>キャンセル日</th>
            <td>
              <?= DateUtil::PreviewDate($viewState->get('prj_kyanceru_bi'))?>
              <br>
              <span class="komered">※すでに歩合が支払われている案件がキャンセルとなった場合に、キャンセルとなった日付を設定して下さい。</span>
            </td>
         </tr>
         <tr>
            <th>各種書類履歴</th>
            <td>
               <div class="scroll_h" style="height: 100px">
                  <?php require_once('subtable/table1-preview.php') ?>
               </div>
            </td>
         </tr>
         <tr>
            <th>各種書類アップロード
            </th>
            <td>
               <?=$viewState->get("prj_file_file_name1")?>
               種別：
               <?=AppConfig::$DOCS_TYPE[$viewState->get("prj_file_shubetsu")];?>
               <br>
               <span class="komered">※ここでアップロードされたファイルは、案件<?=!StringUtil::isNullOrEmpty($viewState->get("prj_id"))? "ID ".$viewState->get("prj_id") : "";?>に関連付けられます。</span>
            </td>
         </tr>
         <tr>
            <th>見積履歴</th>
            <td>
               <!--<span class="komered">※金額をクリックすると、見積内容が商品情報入力欄に貼り付けられます。</span>-->
               <div class="scroll_h" style="height: 100px">
                  <?php require_once('subtable/table2-preview.php') ?>
               </div>
            </td>
         </tr>
         <tr>
            <th>見積アップロード
            </th>
            <td>
                <?=$viewState->get("prj_file_file_name2")?>
               <br>
               <span class="komered">※ここでアップロードされた見積は、案件<?=!StringUtil::isNullOrEmpty($viewState->get("prj_id"))? "ID ".$viewState->get("prj_id") : "";?>に関連付けられます。</span>
            </td>
         </tr>
         <tr>
            <th>案件変更履歴</th>
            <td>
               <div class="scroll_h" style="height: 100px">
                  <?php require_once('subtable/table3.php') ?>
               </div>
            </td>
         </tr>
         <!--<tr>
            <td colspan="2" class="text_center">
                <input type="submit" autofocus value="データ更新" />
                <input type="button" 
                submit-action = "<?=$actionUrl?>"
                submit-method = "post"
                submit-data='{"regist_step":3, "json_regist_data":<?=$viewState->get("json_regist_data", ViewState::JS_VARIABLE)?>}' 
                class="submit-form" value="もどる" />
                <?= !StringUtil::isNullOrEmpty($viewState->get('notsavehistory')) ? "<span class='komered' style='display:inline-flex; color:red'>※案件更新履歴を保存しない</span>" : ''?>
            </td>
         </tr>-->
      </tbody>
   </table>
   <p></p>
</div>