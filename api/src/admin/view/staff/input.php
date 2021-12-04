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
                <ul id="show-error-messages" class="item-error-messages header-error-messages updatemessage"></ul>
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
                                            <input type="hidden" class="staff_id" name="staff_id" value="<?=$viewState->get("staff_id")?>" />
                                            <input type="password" style="display:none" />
                                            <?= !StringUtil::isNullOrEmpty($viewState->get("staff_id"))?$viewState->get("staff_id"): ""?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            Tên nhân viên <span class="komered">※</span>
                                        </th>
                                        <td>
                                            <input type="text" name="staff_name" id="staff_name" value="<?=$viewState->get("staff_name")?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            社員名　カナ
                                        </th>
                                        <td>
                                            <input type="text" name="staff_name_kana" id="staff_name_kana" value="<?=$viewState->get("staff_name_kana")?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            Văn phòng <span class="komered">※</span>
                                        </th>
                                        <td>
                                            <?= HtmlUtil::dropList('staff_office_id', $loffice, $viewState->get("staff_office_id"), 'office_id', 'office_name') ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            部署 <span class="komered">※</span>
                                        </th>
                                        <td>
                                            <?= HtmlUtil::dropList('staff_department_id', AppConfig::$STAFF_DEPARTMENT_ID, $viewState->get("staff_department_id")) ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            Quyền hạn <span class="komered">※</span>
                                        </th>
                                        <td>
                                            <?= HtmlUtil::checkBoxs('staff_role[]', AppConfig::$USER_ROLE, $viewState->get('staff_role'),null,null,"<br>") ?>
                                            <input type="hidden" id="staff_role_placehole"> 
                                            <input type="hidden" name="show_securiy" id="show_securiy" value="<?=$viewState->get('show_securiy')?>">
                                            <div id="security_key_block" style="display:<?=$viewState->get('show_securiy')?'block':'none';?>">
                                                <span class="komered">案件管理 [管理者向け]（仕切値閲覧・修正可）、歩合管理 [管理者向け]にチェックを入れる場合はセキュリティキー入力が必要です。</span><br>
                                                <input type="password" name="security_key" class="input-mini" id="security_key" value="<?=$viewState->get('security_key')?>" style="margin-bottom: 0px;">
                                            </div>

                                            <span class="komered">※ここで登録する社員に利用を許可する機能を選択して下さい。</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            郵便番号 <span class="komered">※</span>
                                        </th>
                                        <td>
                                            〒 <input type="text" name="staff_pos_code1" id="staff_pos_code1" value="<?=$viewState->get('staff_pos_code1')?>" class="input-mini">
                                            - <input type="text" name="staff_pos_code2" id="staff_pos_code2"  value="<?=$viewState->get('staff_pos_code2')?>" class="input-mini">
                                            <input type="hidden" name="staff_pos_code" id="staff_pos_code"  value="<?=$viewState->get('staff_pos_code')?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            Quận <span class="komered">※</span>
                                        </th>
                                        <td>
                                            <?= HtmlUtil::dropList('staff_prefectures', AppConfig::$PREFECTURE, $viewState->get("staff_prefectures")) ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            Thành phố
                                        </th>
                                        <td><input type="text" name="staff_city" id="staff_city" value="<?=$viewState->get('staff_city')?>"></td>
                                    </tr>
                                    <tr>
                                        <th>
                                            Địa chỉ
                                        </th>
                                        <td><input type="text" name="staff_address" id="staff_address" value="<?=$viewState->get('staff_address')?>"></td>
                                    </tr>
                                    <script type="text/javascript" src="../theme/admin/js/jquery.jpostal.js"></script>
                                    <script type="text/javascript">
                                        $(window).ready( function() {
                                        //jpostal用処理
                                        $('#staff_pos_code1').jpostal({
                                            postcode : [
                                            '#staff_pos_code1',
                                            '#staff_pos_code2'
                                            ],
                                            address : {
                                                '#staff_prefectures'  : '%3',
                                                '#staff_city'  : '%4',
                                                '#staff_address'  : '%5'
                                            }
                                        });
                                    });
                                    </script>
                                    <tr>
                                        <th>
                                            Số nhà
                                        </th>
                                        <td><input type="text" name="staff_mansion_info" id="staff_mansion_info" value="<?=$viewState->get('staff_mansion_info')?>"></td>
                                    </tr>
                                    <tr>
                                        <th>
                                            Số điện thoại <span class="komered">※</span>
                                        </th>
                                        <td><input type="text" name="staff_phone_num" id="staff_phone_num" value="<?=$viewState->get('staff_phone_num')?>"></td>
                                    </tr>
                                    <tr>
                                        <th>
                                            Email <span class="komered">※</span>
                                        </th>
                                        <td><input type="text" name="staff_email" id="staff_email" value="<?=$viewState->get('staff_email')?>"></td>
                                    </tr>
                                    <tr>
                                        <th>
                                            Mật khẩu
                                        </th>
                                        <td>
                                            <input type="password" name="staff_password" id="staff_password" value="<?=$viewState->get('staff_password')?>" class="input-medium">　<br>
                                            <?php if(!StringUtil::isNullOrEmpty($viewState->get("staff_id"))):?>
                                            <input type="checkbox" name="change_pass" id="change_pass" <?=!StringUtil::isNullOrEmpty($viewState->get("change_pass")) ? "checked" :" "; ?> >パスワードを変更する
                                            <br>
                                            <?php endif;?>
                                            <span class="komered">※半角英数字6～10文字</span>
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>
                                            上役指定
                                        </th>
                                        <td>
                                            <?= HtmlUtil::dropList('staff_supervisor', $lstaff, $viewState->get("staff_supervisor"), 'staff_id', 'staff_name') ?>                                        <span class="komered">
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
                                            <input type="checkbox" name="staff_is_notify_mail" class="form_radio" value="1" id="staff_is_notify_mail" <?=$viewState->get('staff_is_notify_mail')==1 ? 'checked' : ''?> >
                                            <label for="staff_is_notify_mail" style="display: inline;">
                                                全ての案件の変更メールを受け取る                            
                                            </label>&nbsp;&nbsp;<br>
                                            <span class="komered">※ここにチェックを入れると全ての案件の変更メールが届きます。
                                                <br>
                                                ここにチェックが入ることによって、全ての案件を閲覧・編集を出来る権限を持ちます。
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            その他備考
                                        </th>
                                        <td>
                                            <textarea name="staff_memo" id="staff_memo" cols="30" rows="10"><?=$viewState->get('staff_memo')?></textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="text_center">
                                            <input type="hidden" value="1" name="regist_step">
                                            <input type="hidden" name="created_user" value="<?=$viewState->get("created_user")?>" />
                                            <input type="hidden" name="created_time" value="<?=$viewState->get("created_time")?>" />
                                            <input type="hidden" name="updated_user" value="<?=$viewState->get("updated_user")?>" />
                                            <input type="hidden" name="updated_time" value="<?=$viewState->get("updated_time")?>" />
                                            <input type="submit" value="確認画面へ">
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

<script type="text/javascript">
    $('#staff_role').on('click', ':checkbox', function() {
        var roles = [];
        var staff_id = null;
        var staff_id = $('input.staff_id').val();
/*        alert(temp);*/
        $('#staff_role input:checked').each(function() {
            roles.push(this.value);
        });
        $.ajax({
                url:"<?=$urlCheckUpdateRole?>",
                type:"post",
                data:{
                    staff_id:staff_id, 
                    roles: roles  
                  },
                dataType:'json',
                success: function(result){
                    if(result.change === 1)
                    {
                        document.getElementById('security_key_block').style.display = 'block';
                        document.getElementById('show_securiy').value = 1;
                    }
                    else{
                        document.getElementById('security_key_block').style.display = 'none';   
                        document.getElementById('show_securiy').value = null;
                    }
                },
                error: function(error){
                    console.log(error);
                }
        });
    });
</script>