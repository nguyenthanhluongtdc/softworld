<?php 
$actionUrl =  $urlRegist;
$title = "TẠO MỚI TYPE EVENT";
if(!StringUtil::isNullOrEmpty($viewState->get("id")) && $viewState->get('mode')=="edit") {
  $actionUrl =  UrlUtil::url($urlEdit, array("id"=>$viewState->get("id")));
  $title = "CẬP NHẬT TYPE EVENT";
}else if(!StringUtil::isNullOrEmpty($viewState->get("id")) && $viewState->get('mode')=="copy") {
    $actionUrl =  UrlUtil::url($urlCopy, array("id"=>$viewState->get("id")));
    $title = "COPY TYPE EVENT";
}

?>
<div id="content" class="clearfix">
 <div class="contentwrapper"><!--Content wrapper-->
    <div class="heading">
       <h3> <?=$title?> </h3>
   </div><!-- End .heading-->
   <!-- Build page from here: Usual with <div class="row-fluid"></div> -->
   <div class="row-fluid">
       <div class="span12">
            <div class="box gradient">
                <ul id="show-error-messages" class="item-error-messages header-error-messages updatemessage"></ul>
                <form method="POST" action="<?=$actionUrl ?>">
                    <div class="content noPad clearfix" id="DataArea">
                        <div class="margin10"> <span class="komered">* </span>Trường bắt buộc</div>
                            <table class="input_form_table">
                                <tbody>
                                    <tr>
                                        <th>
                                            ID
                                        </th>
                                        <td>  
                                            <input type="hidden" class="id" name="id" value="<?=$viewState->get("id")?>" />
                                            <input type="password" style="display:none" />
                                            <?= !StringUtil::isNullOrEmpty($viewState->get("id"))?$viewState->get("id"): ""?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                        <span class="komered">* </span> Tên Loại: 
                                        </th>
                                        <td>
                                            <input type="text" name="name_type" id="name_type" value="<?=$viewState->get("name_type")?>" required>
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>
                                            <span class="komered">* </span> Mã phân loại:
                                        </th>
                                        <td>
                                            <input type="text" name="code_type" id="code_type" value="<?=$viewState->get("code_type")?>" required>
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>
                                            <span class="komered">* </span>Mã màu:
                                        </th>
                                        <td>
                                            <input type="color" name="code_color" id="code_color" value="<?=$viewState->get("code_color")?>" required> 
                                        </td>
                                    </tr>
                                   
                                    <script type="text/javascript" src="../theme/admin/js/jquery.jpostal.js"></script>
                                  
                                    <tr>
                                        <td colspan="2" class="text_center">
                                            <input type="hidden" value="1" name="regist_step">
                                            <input type="hidden" name="created_user" value="<?=$viewState->get("created_user")?>" />
                                            <input type="hidden" name="created_time" value="<?=$viewState->get("created_time")?>" />
                                            <input type="hidden" name="updated_user" value="<?=$viewState->get("updated_user")?>" />
                                            <input type="hidden" name="updated_time" value="<?=$viewState->get("updated_time")?>" />
                                            <input type="submit" value="Xác nhận" >
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