<script type="text/javascript" src="../theme/admin/js/jquery.jpostal.js"></script>
<script type="text/javascript">
$(window).ready( function() {
    //jpostal用処理
    $('#office_pos_code1').jpostal({
        postcode : [
            '#office_pos_code1',
            '#office_pos_code2'
        ],
        address : {
            '#office_prefectures'  : '%3',
            '#office_city'  : '%4',
            '#office_address'  : '%5'
        }
    });
});
</script>
<?php 
    $actionUrl =  $urlRegist;
    if(!StringUtil::isNullOrEmpty($viewState->get("office_id"))) {
        $actionUrl =  UrlUtil::url($urlEdit, array("edit_id"=>$viewState->get("office_id")));
    }
    $idoffice = $viewState->get("office_id") == '' ? '' : $viewState->get("office_id");

?>
<div class="clearfix" id="content">
    <div class="contentwrapper"><!--Content wrapper-->
        <div class="heading">
            <h3>事業所登録</h3>
        </div><!-- End .heading-->

        <!-- Build page from here: Usual with <div class="row-fluid"></div> -->

        <div class="row-fluid">
            <div class="span12">
                <div class="box gradient">
                    <ul id="show-error-messages" class="item-error-messages header-error-messages updatemessage"></ul>
                    <form method="post" action="<?=$actionUrl?>">
                        <input type="hidden" name="office_id" value="<?=$viewState->get("office_id")?>" />
                        <div id="DataArea" class="content noPad clearfix">
                            <div class="margin10"> <span class="komered">※</span>は入力必須項目です。</div>

                            <table class="input_form_table">
                                <tbody><tr>
                                        <th>
                                            事業所ID
                                        </th>
                                        <td><?=$idoffice?></td>
                                    </tr>
                                    <tr>
                                        <th>
                                            事業所名 <span class="komered">※</span>
                                        </th>
                                        <td><input type="text" id="office_name" name="office_name" value="<?=$viewState->get("office_name")?>"></td>
                                    </tr>
                                    <tr>
                                        <th>
                                            事業所名&#12288;カナ
                                        </th>
                                        <td><input type="text" id="office_name_kana" name="office_name_kana" value="<?=$viewState->get("office_name_kana")?>"></td>
                                    </tr>

                                    <tr>
                                        <th>
                                            郵便番号 <span class="komered">※</span>
                                        </th>
                                        <td>
                                            〒 <input type="text" class="input-mini" id="office_pos_code1" name="office_pos_code1" value="<?=$viewState->get("office_pos_code1")?>">
                                            - <input type="text" class="input-mini" id="office_pos_code2" name="office_pos_code2" value="<?=$viewState->get("office_pos_code2")?>">
                                            <input type="hidden" name="office_pos_code" id="office_pos_code"  value="<?=$viewState->get('office_pos_code')?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            都道府県 <span class="komered">※</span>
                                        </th>
                                        <td>
                                            <?= HtmlUtil::dropList('office_prefectures', AppConfig::$PREFECTURE, $viewState->get("office_prefectures")) ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            市区町村
                                        </th>
                                        <td><input type="text" id="office_city" name="office_city" value="<?=$viewState->get('office_city')?>" >
                                    </tr>
                                    <tr>
                                        <th>
                                            番地
                                        </th>
                                        <td><input type="text" id="office_address" name="office_address" value="<?=$viewState->get('office_address')?>"></td>
                                    </tr>

                                    <tr>
                                        <th>
                                            マンション/ビル名等
                                        </th>
                                        <td><input type="text" class="" id="office_mansion_info" name="office_mansion_info" value="<?=$viewState->get('office_mansion_info')?>"></td>
                                    </tr>
                                    <tr>
                                        <th>
                                            電話番号 <span class="komered">※</span>
                                        </th>
                                        <td><input type="text" id="office_phone_num" name="office_phone_num" value="<?=$viewState->get('office_phone_num')?>"></td>
                                    </tr>
                                    <tr>
                                        <th>
                                            FAX番号
                                        </th>
                                        <td><input type="text" id="office_fax_num" name="office_fax_num" value="<?=$viewState->get('office_fax_num')?>"></td>
                                    </tr>
                                    <tr>
                                        <th>
                                            メールアドレス
                                        </th>
                                        <td><input type="text" id="office_email" name="office_email" value="<?=$viewState->get('office_email')?>"></td>
                                    </tr>

                                    <tr>
                                        <th>
                                            その他備考
                                        </th>
                                        <td>
                                            <textarea rows="10" id="office_memo" name="office_memo" value="<?=$viewState->get('office_memo')?>"><?=$viewState->get('office_memo')?></textarea>
                                        </td>
                                    </tr>


                                    <tr>
                                        <td class="text_center" colspan="2">
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
                    </form>
                </div><!-- End .box -->
            </div><!-- End .span12 -->
        </div><!-- End .row-fluid -->
        <!-- Page end here -->
    </div><!-- End contentwrapper -->
</div>