<div id="ui-tab">
   <ul class="ui-tabs-nav">
      <li class="ui-tabs-selected"><a href="#fragment-1"><span>日程・各種履歴・帳票情報</span></a></li>
      <li><a href="#fragment-2"><span>商品情報</span></a></li>
      <li><a href="#fragment-3"><span>支払い情報</span></a></li>
      <li><a href="#fragment-4"><span>担当者情報</span></a></li>
      <li><a href="#fragment-5"><span>進捗情報</span></a></li>
   </ul>
   <?php require_once('fragment/fragment1-preview.php') ?>
   <?php require_once('fragment/fragment2-preview.php') ?>
   <?php require_once('fragment/fragment3-preview.php') ?>
   <?php require_once('fragment/fragment4-preview.php') ?>
   <?php require_once('fragment/fragment5-preview.php') ?>
   <div class="ui-tabs-panel" style="border-top:none">
      <table class="input_form_table">
         <tbody>
            <tr>
                <th class="cap">
                   <input type="submit" autofocus value="データ更新" />
                   <input type="button" 
                   submit-action = "<?=$actionUrl?>"
                   submit-method = "post"
                   submit-data='{"regist_step":3, "json_regist_data":<?=$viewState->get("json_regist_data", ViewState::JS_VARIABLE)?>}' 
                   class="submit-form" value="もどる" />
                   <?= !StringUtil::isNullOrEmpty($viewState->get('notsavehistory')) ? "<span class='komered' style='display:inline-flex; color:red'>※案件更新履歴を保存しない</span>" : ''?>
               </th>
            </tr>
         </tbody>
      </table>
   </div>
</div>