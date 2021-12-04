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
               <td><?=$viewState->get('prj_prg_eq_accre_id')?></td>
            </tr>
            <tr>
               <th>お客様ログインID</th>
               <td><?=$viewState->get('prj_prg_cust_login_id')?></td>
            </tr>
            <tr>
               <th>お客様ログインパスワード</th>
               <td>
                <?=$viewState->get('prj_prg_cust_login_passw')?>
              </td>
            </tr>
            <tr>
               <th>東京電力申込番号</th>
               <td>
                  <?=$viewState->get('prj_prg_tepco_num1')?>
                  <?=$viewState->get('prj_prg_tepco_num2')?>
                </td>
            </tr>
            <tr>
               <th>更新日</th>
               <td>
                 <?= DateUtil::PreviewDate($viewState->get("prj_prg_update_date"))?>
               </td>
            </tr>
            <tr>
               <th>モジュール</th>
               <td> <?=$viewState->get('prj_prg_module')?> </td>
            </tr>
            <tr>
               <th>モジュール枚数</th>
               <td> <?=$viewState->get('prj_prg_module_num')?> 枚</td>
            </tr>
            <tr>
               <th>PCS1</th>
               <td> <?=$viewState->get('prj_prg_pcs1')?> </td>
            </tr>
            <tr>
               <th>PCS1台数</th>
               <td> <?=$viewState->get('prj_prg_pcs1_num')?> 台</td>
            </tr>
            <tr>
               <th>PCS2</th>
               <td> <?=$viewState->get('prj_prg_pcs2')?></td>
            </tr>
            <tr>
               <th>PCS2台数</th>
               <td> <?=$viewState->get('prj_prg_pcs2_num')?> 枚</td>
            </tr>
            <tr>
               <th>合計出力</th>
               <td> <?=$viewState->get('prj_prg_sum_exp')?> Kw</td>
            </tr>
            <tr>
               <th>申請出力</th>
               <td> <?=$viewState->get('prj_prg_appl_out')?> Kw</td>
            </tr>
            <tr>
               <th>設備認定申請日</th>
               <td>
                  <?= DateUtil::PreviewDate($viewState->get("prj_prg_eq_cer_appl_date"))?>
               </td>
            </tr>
            <tr>
               <th>電力受給受付日</th>
               <td>
                  <?= DateUtil::PreviewDate($viewState->get("prj_prg_el_recept_recv_date"))?>
               </td>
            </tr>
            <tr>
               <th>設備認定回答日</th>
               <td>
                  <?= DateUtil::PreviewDate($viewState->get("prj_prg_eq_acc_res_date"))?>
               </td>
            </tr>
            <tr>
               <th>工事負担金算出日</th>
               <td>
                  <?= DateUtil::PreviewDate($viewState->get("prj_prg_cons_grant_cal_date"))?>
               </td>
            </tr>
            <tr>
               <th>工事負担金</th>
               <td> <?=$viewState->get('prj_prg_cons_grant')?>円</td>
            </tr>
            <tr>
               <th>工事負担金支払日</th>
               <td>
                  <?= DateUtil::PreviewDate($viewState->get("prj_prg_cons_grant_pay_date"))?>
               </td>
            </tr>
            <tr>
               <th>メーター代</th>
               <td> <?=$viewState->get('prj_prg_meter_fee')?>   円</td>
            </tr>
            <tr>
               <th>接続検討申請日</th>
               <td>
                  <?= DateUtil::PreviewDate($viewState->get("prj_prg_conn_cons_appl_date"))?>
               </td>
            </tr>
            <tr>
               <th>接続検討回答日</th>
               <td>
                  <?= DateUtil::PreviewDate($viewState->get("prj_prg_conn_cons_res_date"))?>
               </td>
            </tr>
            <tr>
               <th>設備認定条件付き</th>
               <td> <?=$viewState->get('prj_prg_eq_cer_req')?> </td>
            </tr>
            <tr>
               <th>本申込み日</th>
               <td>
                  <?= DateUtil::PreviewDate($viewState->get("prj_prg_appl_date"))?>
               </td>
            </tr>
            <tr>
               <th>電気使用申込日</th>
               <td>
                  <?= DateUtil::PreviewDate($viewState->get("prj_prg_elec_use_appl_date"))?>
               </td>
            </tr>
            <tr>
               <th>工事負担金額</th>
               <td> <?=$viewState->get('prj_prg_cons_amount')?>   円</td>
            </tr>
            <tr>
               <th>東京電力電力需給</th>
               <td>
                  <?= DateUtil::PreviewDate($viewState->get("prj_prg_tokyo_supply_demand"))?>
               </td>
            </tr>
            <tr>
               <th>工事負担金支払い日</th>
               <td>
                 <?= DateUtil::PreviewDate($viewState->get("prj_prg_cons_grant_pay_date2"))?>
               </td>
            </tr>
            <tr>
               <th>連携見込み</th>
               <td> <?=$viewState->get('prj_prg_coop_pros')?> </td>
            </tr>
            <tr>
               <th>メモ欄</th>
               <td> <?=$viewState->get('prj_prg_note')?></td>
            </tr>
            <tr>
               <th>備考欄</th>
               <td>
                   <?=nl2br($viewState->get('prj_prg_remark'))?> 
               </td>
            </tr>
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