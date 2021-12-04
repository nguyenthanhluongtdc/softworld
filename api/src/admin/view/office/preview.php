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
                    <ul id="show-error-messages" class="item-error-messages"></ul>
                    <form method="post" action="<?=$actionUrl?>">
                        <input type="hidden" name="id" value="<?=$viewState->get("office_id")?>" />
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
                                        <td><?=$viewState->get("office_name")?></td>
                                    </tr>
                                    <tr>
                                        <th>
                                            事業所名&#12288;カナ
                                        </th>
                                        <td><?=$viewState->get("office_name_kana")?></td>
                                    </tr>

                                    <tr>
                                        <th>
                                            郵便番号 <span class="komered">※</span>
                                        </th>
                                        <td>
                                            <?=$office_pos_code?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            都道府県 <span class="komered">※</span>
                                        </th>
                                        <td>
                                            <?= AppConfig::$PREFECTURE[$viewState->get('office_prefectures')]?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            市区町村
                                        </th>
                                        <td><?=$viewState->get('office_city')?></td>
                                    </tr>
                                    <tr>
                                        <th>
                                            番地
                                        </th>
                                        <td><?=$viewState->get('office_address')?></td>
                                    </tr>

                                    <tr>
                                        <th>
                                            マンション/ビル名等
                                        </th>
                                        <td><?=$viewState->get('office_mansion_info')?></td>
                                    </tr>
                                    <tr>
                                        <th>
                                            電話番号 <span class="komered">※</span>
                                        </th>
                                        <td><?=$viewState->get('office_phone_num')?></td>
                                    </tr>
                                    <tr>
                                        <th>
                                            FAX番号
                                        </th>
                                        <td><?=$viewState->get('office_fax_num')?></td>
                                    </tr>
                                    <tr>
                                        <th>
                                            メールアドレス
                                        </th>
                                        <td><?=$viewState->get('office_email')?></td>
                                    </tr>

                                    <tr>
                                        <th>
                                            その他備考
                                        </th>
                                        <td>
                                            <?= nl2br($viewState->get('office_memo'))?>
                                        </td>
                                    </tr>


                                    <tr>
                                        <td class="text_center" colspan="2">
                                            <input type="hidden" name="created_user" value="<?=$viewState->get("created_user")?>" />
                                            <input type="hidden" name="created_time" value="<?=$viewState->get("created_time")?>" />
                                            <input type="hidden" name="updated_user" value="<?=$viewState->get("updated_user")?>" />
                                            <input type="hidden" name="updated_time" value="<?=$viewState->get("updated_time")?>" />
                                            <input type="hidden" value="2" name="regist_step">
                                            <input type="hidden" name="json_regist_data" value="<?=$viewState->get("json_regist_data")?>" >
                                            <input  type="submit" autofocus value="データ更新" class="button button_submit_cancel" />

                                            <input type="button" 
                                            submit-action = "<?=$actionUrl?>"
                                            submit-method = "post"
                                            submit-data='{"regist_step":3, "json_regist_data":<?=$viewState->get("json_regist_data", ViewState::JS_VARIABLE)?>}' 
                                            class="button submit-form button_submit_cancel"  value="もどる" />
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