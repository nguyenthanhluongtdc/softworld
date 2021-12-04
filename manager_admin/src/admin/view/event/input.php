<?php 
$actionUrl =  $urlRegist;
$title = "TẠO MỚI EVENT";

if(!StringUtil::isNullOrEmpty($viewState->get("id")) && $viewState->get('mode')=='edit') {
  $actionUrl =  UrlUtil::url($urlEdit, array("id"=>$viewState->get("id")));
  $title = "CẬP NHẬT EVENT";
}
else if(!StringUtil::isNullOrEmpty($viewState->get("id")) && $viewState->get('mode')=='copy') {
    $actionUrl =  UrlUtil::url($urlCopy, array("id"=>$viewState->get("id")));
    $title = "COPY EVENT";
}

// $to_time = strtotime("2008-12-13 10:43:00");
// $from_time = strtotime("2008-12-13 10:21:00");
// echo round(abs($to_time - $from_time) / 60,2). " minute";
?>
<script>
// var startTime = new Date('2013/10/09 12:00'); 
// var endTime = new Date('2013/10/09 13:00');
// var difference = endTime.getTime() - startTime.getTime(); // This will give difference in milliseconds
// var resultInMinutes = Math.round(difference / 60000);
// console.log(resultInMinutes)
</script>
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
                <form method="POST" action="<?=$actionUrl?>">
                    <div class="content noPad clearfix" id="DataArea">
                        <div class="margin10"> <span class="komered">*</span>Trường bắt buộc</div>
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
                                            <span class="komered">*</span>  Tên sự kiện: 
                                        </th>
                                        <td>
                                            <input type="text" name="event_name" id="event_name" value="<?=$viewState->get("event_name")?>" required> 
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            <span class="komered">*</span>Thời gian bắt đầu: 
                                        </th>
                                        <td>
                                            <input type="datetime-local" name="start_time" id="start_time"
                                             value="<?= !StringUtil::isNullOrEmpty($viewState->get("start_time")) 
                                             ? date('Y-m-d\TH:i', strtotime ($viewState->get("start_time") )) 
                                             : date('Y-m-d\TH:i')?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            <span class="komered">*</span>Thời gian kết thúc: 
                                        </th>
                                        <td>
                                            <input type="datetime-local" name="end_time" id="end_time" value="<?= !StringUtil::isNullOrEmpty($viewState->get("end_time")) 
                                            ? date('Y-m-d\TH:i', strtotime ($viewState->get("end_time") )) 
                                            : date('Y-m-d\TH:i')?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            <span class="komered">*</span>Tên khách hàng:
                                        </th>
                                        <td>
                                            <input type="text" name="name_customer" id="name_customer" value="<?=$viewState->get("name_customer")?>" required>
                                        </td>
                                    </tr>
                                  
                                    <tr>
                                        <th>
                                            <span class="komered">*</span>SDT:
                                        </th>
                                        <td>
                                            <input type="number" name="phone_customer" id="phone_customer" value="<?=$viewState->get('phone_customer')?>" required></td>
                                    </tr>
                                    <tr>
                                        <th>
                                            <span class="komered">*</span>Email
                                        </th>
                                        <td>
                                            <input type="text" name="email_customer" id="email_customer" value="<?=$viewState->get("email_customer")?>" required>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            <span class="komered">*</span>Số lượng người lớn:
                                        </th>
                                        <td>
                                            <input type="number" name="number_adults" min="0" id="number_adults" value="<?= !StringUtil::isNullOrEmpty($viewState->get("number_adults")) ? $viewState->get("number_adults") : '0' ?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            <span class="komered">*</span>Số lượng trẻ em:
                                        </th>
                                        <td>
                                            <input type="number" name="number_kid" min="0" id="number_kid" value="<?= !StringUtil::isNullOrEmpty($viewState->get("number_kid")) ? $viewState->get("number_kid") : '0' ?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            <span class="komered">*</span>Loại:
                                        </th>
                                        <td>
                                            <select name="type_id" id="type_id">
                                            <?php foreach($dataTypeEvent as $value) : ?>
                                                <option value="<?=$value['id']?>" <?= $viewState->get("type_id") == $value['id'] ? 'selected' :'' ?> > 
                                                    <?=$value['name_type']?> 
                                                </option>
                                            <?php endforeach ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            <span class="komered">*</span>Cả ngày:
                                        </th>
                                        <td>
                                            <select name="status" id="status">
                                                <option value="1" <?= $viewState->get("status") == 1 ? 'selected' : '' ?> >Có</option>
                                                <option value="0" <?= $viewState->get("status") == 0 ? 'selected' : '' ?>>Không</option>
                                            </select>
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
                                            <input type="submit" value="Xác nhận">
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

