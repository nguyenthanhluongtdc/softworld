<div id="fragment-5" class="ui-tabs-panel">
      <p>
      </p>
      <table class="input_form_table">
         <tbody>
            <tr>
               <th colspan="4" class="cap">進捗情報</th>
            </tr>
            <tr>
               <th>設備認定ID</th>
               <input type="hidden" name="prj_progress_info_prj_id" id="prj_progress_info_prj_id" value="<?=$viewState->get('prj_progress_info_prj_id')?>">
               <td><input type="text" name="prj_prg_eq_accre_id" id="prj_prg_eq_accre_id" value="<?=$viewState->get('prj_prg_eq_accre_id')?>" class="input-small"></td>
            </tr>
            <tr>
               <th>お客様ログインID</th>
               <td><input type="text" name="prj_prg_cust_login_id" id="prj_prg_cust_login_id" value="<?=$viewState->get('prj_prg_cust_login_id')?>" class="input-small"></td>
            </tr>
            <tr>
               <th>お客様ログインパスワード</th>
               <td><input type="text" name="prj_prg_cust_login_passw" id="prj_prg_cust_login_passw" value="<?=$viewState->get('prj_prg_cust_login_passw')?>" class="input-small"></td>
            </tr>
            <tr>
               <th>東京電力申込番号</th>
               <td>
                  <input type="text" name="prj_prg_tepco_num1" id="prj_prg_tepco_num1" value="<?=$viewState->get('prj_prg_tepco_num1')?>" class="input-small"> 
                  <input type="text" name="prj_prg_tepco_num2" id="prj_prg_tepco_num2" value="<?=$viewState->get('prj_prg_tepco_num2')?>" class="input-small">
                </td>
            </tr>
            <tr>
               <th>更新日</th>
               <td>
                <?= HtmlUtil::CalendarInput('prj_prg_update_date',$viewState->get("prj_prg_update_date"));?>
                <span id="prj_prg_update_date_msg"></span>
               </td>
            </tr>
            <tr>
               <th>モジュール</th>
               <td><input type="text" name="prj_prg_module" id="prj_prg_module" value="<?=$viewState->get('prj_prg_module')?>" class="input-medium"></td>
            </tr>
            <tr>
               <th>モジュール枚数</th>
               <td><input type="text" name="prj_prg_module_num" id="prj_prg_module_num" value="<?=$viewState->get('prj_prg_module_num')?>" class="input-small">枚</td>
            </tr>
            <tr>
               <th>PCS1</th>
               <td><input type="text" name="prj_prg_pcs1" id="prj_prg_pcs1" value="<?=$viewState->get('prj_prg_pcs1')?>" class="input-medium"></td>
            </tr>
            <tr>
               <th>PCS1台数</th>
               <td><input type="text" name="prj_prg_pcs1_num" id="prj_prg_pcs1_num" value="<?=$viewState->get('prj_prg_pcs1_num')?>" class="input-small">台</td>
            </tr>
            <tr>
               <th>PCS2</th>
               <td><input type="text" name="prj_prg_pcs2" id="prj_prg_pcs2" value="<?=$viewState->get('prj_prg_pcs2')?>" class="input-medium"></td>
            </tr>
            <tr>
               <th>PCS2台数</th>
               <td><input type="text" name="prj_prg_pcs2_num" id="prj_prg_pcs2_num" value="<?=$viewState->get('prj_prg_pcs2_num')?>" class="input-small">枚</td>
            </tr>
            <tr>
               <th>合計出力</th>
               <td><input type="text" name="prj_prg_sum_exp" id="prj_prg_sum_exp" value="<?=$viewState->get('prj_prg_sum_exp')?>" class="input-small" ime_off="">Kw</td>
            </tr>
            <tr>
               <th>申請出力</th>
               <td><input type="text" name="prj_prg_appl_out" id="prj_prg_appl_out" value="<?=$viewState->get('prj_prg_appl_out')?>" class="input-small ime_off">Kw</td>
            </tr>
            <tr>
               <th>設備認定申請日</th>
               <td>
                  <?= HtmlUtil::CalendarInput('prj_prg_eq_cer_appl_date',$viewState->get("prj_prg_eq_cer_appl_date"));?>
                  <span id="prj_prg_eq_cer_appl_date_msg"></span>
               </td>
            </tr>
            <tr>
               <th>電力受給受付日</th>
               <td>
                  <?= HtmlUtil::CalendarInput('prj_prg_el_recept_recv_date',$viewState->get("prj_prg_el_recept_recv_date"));?>
                  <span id="prj_prg_el_recept_recv_date_msg"></span>
               </td>
            </tr>
            <tr>
               <th>設備認定回答日</th>
               <td>
                  <?= HtmlUtil::CalendarInput('prj_prg_eq_acc_res_date',$viewState->get("prj_prg_eq_acc_res_date"));?>
                  <span id="prj_prg_eq_acc_res_date_msg"></span>
               </td>
            </tr>
            <tr>
               <th>工事負担金算出日</th>
               <td>
                  <?= HtmlUtil::CalendarInput('prj_prg_cons_grant_cal_date',$viewState->get("prj_prg_cons_grant_cal_date"));?>
                  <span id="prj_prg_cons_grant_cal_date_msg"></span>
               </td>
            </tr>
            <tr>
               <th>工事負担金</th>
               <td><input type="text" name="prj_prg_cons_grant" id="prj_prg_cons_grant" value="<?=$viewState->get('prj_prg_cons_grant')?>" class="input-small ime_off">円</td>
            </tr>
            <tr>
               <th>工事負担金支払日</th>
               <td>
                  <?= HtmlUtil::CalendarInput('prj_prg_cons_grant_pay_date',$viewState->get("prj_prg_cons_grant_pay_date"));?>
                  <span id="prj_prg_cons_grant_pay_date_msg"></span>
               </td>
            </tr>
            <tr>
               <th>メーター代</th>
               <td><input type="text" name="prj_prg_meter_fee" id="prj_prg_meter_fee" value="<?=$viewState->get('prj_prg_meter_fee')?>" class="input-small ime_off">円</td>
            </tr>
            <tr>
               <th>接続検討申請日</th>
               <td>
                  <?= HtmlUtil::CalendarInput('prj_prg_conn_cons_appl_date',$viewState->get("prj_prg_conn_cons_appl_date"));?>
                  <span id="prj_prg_conn_cons_appl_date_msg"></span>
               </td>
            </tr>
            <tr>
               <th>接続検討回答日</th>
               <td>
                  <?= HtmlUtil::CalendarInput('prj_prg_conn_cons_res_date',$viewState->get("prj_prg_conn_cons_res_date"));?>
                  <span id="prj_prg_conn_cons_res_date_msg"></span>
               </td>
            </tr>
            <tr>
               <th>設備認定条件付き</th>
               <td><input type="text" name="prj_prg_eq_cer_req" id="prj_prg_eq_cer_req" value="<?=$viewState->get('prj_prg_eq_cer_req')?>" class="input-xlarge"></td>
            </tr>
            <tr>
               <th>本申込み日</th>
               <td>
                  <?= HtmlUtil::CalendarInput('prj_prg_appl_date',$viewState->get("prj_prg_appl_date"));?>
                  <span id="prj_prg_appl_date_msg"></span>
               </td>
            </tr>
            <tr>
               <th>電気使用申込日</th>
               <td>
                  <?= HtmlUtil::CalendarInput('prj_prg_elec_use_appl_date',$viewState->get("prj_prg_elec_use_appl_date"));?>
                  <span id="prj_prg_elec_use_appl_date_msg"></span>
               </td>
            </tr>
            <tr>
               <th>工事負担金額</th>
               <td><input type="text" name="prj_prg_cons_amount" id="prj_prg_cons_amount" value="<?=$viewState->get('prj_prg_cons_amount')?>" class="input-small ime_off">円</td>
            </tr>
            <tr>
               <th>東京電力電力需給</th>
               <td>
                  <?= HtmlUtil::CalendarInput('prj_prg_tokyo_supply_demand',$viewState->get("prj_prg_tokyo_supply_demand"));?>
                  <span id="prj_prg_tokyo_supply_demand_msg"></span>
               </td>
            </tr>
            <tr>
               <th>工事負担金支払い日</th>
               <td>
                  <?= HtmlUtil::CalendarInput('prj_prg_cons_grant_pay_date2',$viewState->get("prj_prg_cons_grant_pay_date2"));?>
                  <span id="prj_prg_cons_grant_pay_date2_msg"></span>
               </td>
            </tr>
            <tr>
               <th>連携見込み</th>
               <td><input type="text" name="prj_prg_coop_pros" id="prj_prg_coop_pros" value="<?=$viewState->get('prj_prg_coop_pros')?>" class="input-medium"></td>
            </tr>
            <tr>
               <th>メモ欄</th>
               <td><input type="text" name="prj_prg_note" id="prj_prg_note" value="<?=$viewState->get('prj_prg_note')?>" class="input-xlarge ime_off"></td>
            </tr>
            <tr>
               <th>備考欄</th>
               <td>
                  <textarea name="prj_prg_remark" id="prj_prg_remark" cols="30" rows="10"><?=$viewState->get('prj_prg_remark')?></textarea>
               </td>
            </tr>
            <!--
            <tr>
               <td colspan="4" class="text_center"><input type="submit" value="確認画面へ"></td>
            </tr>
         -->
         </tbody>
      </table>
      <p></p>
   </div>