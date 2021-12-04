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
                                            Tên sự kiện
                                        </th>
                                        <td>  
                                            <?=$viewState->get("event_name")?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            Thời gian bắt đầu <span class="komered">※</span>
                                        </th>
                                        <td>
                                            <?=$viewState->get("start_time")?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            Thời gian kết thúc
                                        </th>
                                        <td>
                                            <?=$viewState->get("end_time")?>
                                        </td>
                                    </tr>
                                   
                                    <tr>
                                        <th>
                                            Tên khách hàng <span class="komered">※</span>
                                        </th>
                                        <td>
                                            <?=$viewState->get("name_customer")?>
                                        </td>
                                    </tr>
                                   
                                    <tr>
                                        <th>
                                            SDT <span class="komered">※</span>
                                        </th>
                                        <td>
                                            <?=$viewState->get("phone_customer")?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            Email <span class="komered">※</span>
                                        </th>
                                        <td>
                                            <?=$viewState->get("email_customer")?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            Người lớn
                                        </th>
                                        <td>
                                            <?=$viewState->get("number_adults")?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            Trẻ em
                                        </th>
                                        <td>
                                            <?=$viewState->get("number_kid")?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            Loại sự kiện
                                        </th>
                                        <td>
                                            <?=$type_name?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            Full ngày
                                        </th>
                                        <td>
                                            <?=$viewState->get("status")==1 ? 'Có' : 'Không' ?>
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
                                            <input type="submit" autofocus value="Xác nhận" class="button button_submit_cancel" />

                                            <input type="button" 
                                            submit-action = "<?=$actionUrl?>"
                                            submit-method = "post"
                                            submit-data='{"regist_step":3, "json_regist_data":<?=$viewState->get("json_regist_data", ViewState::JS_VARIABLE)?>}' 
                                            class="button submit-form button_submit_cancel" value="Huỷ" />
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