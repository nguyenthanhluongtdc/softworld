<div id="ui-tab">
   <ul class="ui-tabs-nav">
      <li><a href="#fragment-1" onclick="setTabOpen(1)"><span>日程・各種履歴・帳票情報</span></a></li>
      <li><a href="#fragment-2" onclick="setTabOpen(2)"><span>商品情報</span></a></li>
      <li><a href="#fragment-3" onclick="setTabOpen(3)"><span>支払い情報</span></a></li>
      <li><a href="#fragment-4" onclick="setTabOpen(4)"><span>担当者情報</span></a></li>
      <li><a href="#fragment-5" onclick="setTabOpen(5)"><span>進捗情報</span></a></li>
   </ul>
   <?php require_once('fragment/fragment1.php') ?>
   <?php require_once('fragment/fragment2.php') ?>
   <?php require_once('fragment/fragment3.php') ?>
   <?php require_once('fragment/fragment4.php') ?>
   <?php require_once('fragment/fragment5.php') ?>
   <div class="ui-tabs-panel" style="border-top:none">
      <table class="input_form_table">
         <tbody>
            <tr>
               <th class="cap">
                  <input type="submit" value="確認画面へ">
                  <div class="hide"><input disabled=""> type="checkbox" name="notsavehistory" value="1" <?=$viewState->get('notsavehistory')==1 ? "checked": ""?> > 
                  <span class="komered" style="display:inline-flex;color:red">※案件更新履歴を保存しない</span></div>
               </th>
            </tr>
         </tbody>
      </table>
   </div>
</div>