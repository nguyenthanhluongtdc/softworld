  <?php 
$actionUrl =  $urlRegist;
if(!StringUtil::isNullOrEmpty($viewState->get("staff_id"))) {
  $actionUrl =  UrlUtil::url($urlEdit, array("edit_staff_id"=>$viewState->get("staff_id")));
}
?>
<div id="content" class="clearfix">
 <div class="contentwrapper"><!--Content wrapper-->
    <div class="heading">
       <h3>社員登録</h3>
   </div><!-- End .heading-->
   <!-- Build page from here: Usual with <div class="row-fluid"></div> -->
   <div class="row-fluid">
       <div class="span12">
            <div class="box gradient">
                <ul id="show-error-messages" class="item-error-messages"></ul>
                <form method="POST" action="<?=$actionUrl ?>">
                    <div class="content noPad clearfix" id="DataArea">
                        <div class="margin10"> <span class="komered">※</span>は入力必須項目です。</div>
                            <table class="input_form_table">
                                <tbody>
                                    <tr>
                                        <th>
                                            社員ID
                                        </th>
                                        <td>  
                                            <input type="hidden" name="user_id" value="<?=$viewState->get("staff_id")?>" />
                                            <?= !StringUtil::isNullOrEmpty($viewState->get("staff_id"))?$viewState->get("staff_id"): ""?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            社員名 <span class="komered">※</span>
                                        </th>
                                        <td>
                                            <?=$viewState->get("staff_name")?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            社員名　カナ
                                        </th>
                                        <td>
                                            <?=$viewState->get("staff_name_kana")?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            事業所名 <span class="komered">※</span>
                                        </th>
                                        <td>
                                            <?php 
                                                foreach ($loffice as $value) {
                                                    if($value['office_id'] == $viewState->get("staff_office_id"))
                                                        echo $value['office_name'];
                                                }
                                            ?>  
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            部署 <span class="komered">※</span>
                                        </th>
                                        <td>
                                             <?=AppConfig::$STAFF_DEPARTMENT_ID[$viewState->get("staff_department_id")]?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            権限 <span class="komered">※</span>
                                        </th>
                                        <td>
                                            <?php 
                                                $staff_role = $viewState->get('staff_role');
                                                if(!StringUtil::isNullOrEmpty($staff_role))
                                                {
                                                    foreach ($staff_role as  $value) {
                                                        echo AppConfig::$USER_ROLE[$value]."<br>";
                                                    }
                                                }
                                            ?>
                                            <span class="komered">※ここで登録する社員に利用を許可する機能を選択して下さい。</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            郵便番号 <span class="komered">※</span>
                                        </th>
                                        <td>
                                            <?=$viewState->get('staff_pos_code1').'-'.$viewState->get('staff_pos_code2')?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            都道府県 <span class="komered">※</span>
                                        </th>
                                        <td>
                                            <?= AppConfig::$PREFECTURE[$viewState->get('staff_prefectures')]?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            市区町村
                                        </th>
                                        <td><?=$viewState->get('staff_city')?></td>
                                    </tr>
                                    <tr>
                                        <th>
                                            番地
                                        </th>
                                        <td><?=$viewState->get('staff_address')?>
                                    </tr>
                                    <tr>
                                        <th>
                                            マンション/ビル名等
                                        </th>
                                        <td><?=$viewState->get('staff_mansion_info')?></td>
                                    </tr>
                                    <tr>
                                        <th>
                                            電話番号 <span class="komered">※</span>
                                        </th>
                                        <td><?=$viewState->get('staff_phone_num')?></td>
                                    </tr>
                                    <tr>
                                        <th>
                                            メールアドレス <span class="komered">※</span>
                                        </th>
                                        <td><?=$viewState->get('staff_email')?></td>
                                    </tr>
                                    <tr>
                                        <th>
                                            ログインパスワード
                                        </th>
                                        <td>
                                            <?php  if(StringUtil::isNullOrEmpty($viewState->get("staff_id"))): ?>
                                              <?php for($i=0;$i < mb_strlen($viewState->get("staff_password")); $i++){
                                                echo '*';
                                              }?>
                                              <?php elseif(!StringUtil::isNullOrEmpty($viewState->get("change_pass"))):?>
                                              <?php for($i=0;$i < mb_strlen($viewState->get("staff_password")); $i++){
                                                echo '*';
                                              }?>
                                            <?php endif;?>
                                            <!--<br>
                                            <span class="komered">※半角英数字6～10文字</span>-->
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>
                                            上役指定
                                        </th>
                                        <td>
                                            <?php 
                                                foreach ($lstaff as $value) {
                                                    if($value['staff_id'] == $viewState->get("staff_supervisor"))
                                                        echo $value['staff_name'];
                                                }
                                            ?>                                        
                                            <span class="komered">
                                                <br>
                                                ※ここで上役を指定することで、該当の社員が(紹介者以外で）担当している案件が変更された場合に、<br>
                                                直属の上司として、変更メールが送られるようになります。
                                            </span>

                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            案件変更メール
                                        </th>
                                        <td>
                                            
                                            <?php if ($viewState->get('staff_is_notify_mail')==1) :?>
                                            <label for="staff_is_notify_mail" style="display: inline;">
                                                全ての案件の変更メールを受け取る                            
                                            </label>&nbsp;&nbsp;<br>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            その他備考
                                        </th>
                                        <td>
                                            <?= nl2br($viewState->get('staff_memo'))?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="text_center">
                                            <input type="hidden" name="created_user" value="<?=$viewState->get("created_user")?>" />
                                            <input type="hidden" name="created_time" value="<?=$viewState->get("created_time")?>" />
                                            <input type="hidden" name="updated_user" value="<?=$viewState->get("updated_user")?>" />
                                            <input type="hidden" name="updated_time" value="<?=$viewState->get("updated_time")?>" />
                                            <input type="hidden" value="2" name="regist_step">
                                            <input type="hidden" name="json_regist_data" value="<?=$viewState->get("json_regist_data")?>" >
                                            <input type="submit" autofocus value="データ更新" class="button button_submit_cancel" />

                                            <input type="button" 
                                            submit-action = "<?=$actionUrl?>"
                                            submit-method = "post"
                                            submit-data='{"regist_step":3, "json_regist_data":<?=$viewState->get("json_regist_data", ViewState::JS_VARIABLE)?>}' 
                                            class="button submit-form button_submit_cancel" value="もどる" />
                                        </td>
                                    </tr>      
                                </tbody>
                            </table>      
                        </div>
                    </div><!-- End .box -->
                </form>
        </div><!-- End .span12 -->
    </div><!-- End .row-fluid -->
    <!-- Page end here -->
</div><!-- End contentwrapper -->
</div>