<?php 
$actionUrl =  $urlRegist;
if(!StringUtil::isNullOrEmpty($viewState->get("event_id"))) {
  $actionUrl =  UrlUtil::url($urlEdit, array("edit_event_id"=>$viewState->get("event_id")));
}
?>
<div id="content" class="clearfix">
 <div class="contentwrapper"><!--Content wrapper-->
    <div class="heading">
       <h3>ĐĂNG KÝ EVENT</h3>
   </div><!-- End .heading-->
   <!-- Build page from here: Usual with <div class="row-fluid"></div> -->
   <div class="row-fluid">
       <div class="span12">
            <div class="box gradient">
                <ul id="show-error-messages" class="item-error-messages header-error-messages updatemessage"></ul>
                <form method="POST" action="<?=$actionUrl ?>">
                    <div class="content noPad clearfix" id="DataArea">
                        <div class="margin10"> <span class="komered">※</span>Trường bắt buộc</div>
                            <table class="input_form_table">
                                <tbody>
                                    <tr>
                                        <th>
                                            ID
                                        </th>
                                        <td>  
                                            <input type="hidden" class="event_id" name="event_id" value="<?=$viewState->get("event_id")?>" />
                                            <input type="password" style="display:none" />
                                            <?= !StringUtil::isNullOrEmpty($viewState->get("id"))?$viewState->get("id"): ""?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            Tên sự kiện: <span class="komered">※</span>
                                        </th>
                                        <td>
                                            <input type="text" name="event_name" id="event_name" value="<?=$viewState->get("event_name")?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            Thời gian bắt đầu: <span class="komered">※</span>
                                        </th>
                                        <td>
                                            <input type="datetime-local" name="start_time" id="start_time" value="<?=$viewState->get("start_time")?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            Thời gian kết thúc: <span class="komered">※</span>
                                        </th>
                                        <td>
                                            <input type="datetime-local" name="end_time" id="end_time" value="<?=$viewState->get("end_time")?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            Tên khách hàng: <span class="komered">※</span>
                                        </th>
                                        <td>
                                            <input type="text" name="name_customer" id="name_customer" value="<?=$viewState->get("name_customer")?>">
                                        </td>
                                    </tr>
                                    <!-- <tr>
                                        <th>
                                            Quận <span class="komered">※</span>
                                        </th>
                                        <td>
                                            <?= HtmlUtil::dropList('event_prefectures', AppConfig::$PREFECTURE, $viewState->get("event_prefectures")) ?>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            Thành phố
                                        </th>
                                        <td>
                                            <input type="text" name="event_city" id="event_city" value="<?=$viewState->get('event_city')?>"></td>
                                    </tr> -->
                                    <tr>
                                        <th>
                                            Địa chỉ
                                        </th>
                                        <td>
                                            <input type="text" name="event_address" id="event_address" value="<?=$viewState->get('event_address')?>"></td>
                                    </tr>
                                    <tr>
                                        <th>
                                            SDT:
                                        </th>
                                        <td>
                                            <input type="text" name="event_address" id="event_address" value="<?=$viewState->get('event_address')?>"></td>
                                    </tr>
                                    <tr>
                                        <th>
                                            Email
                                        </th>
                                        <td>
                                            <input type="text" name="event_name" id="event_name" value="<?=$viewState->get("event_name")?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            Số lượng người lớn:
                                        </th>
                                        <td>
                                            <input type="number" name="event_name" id="event_name" value="<?= $viewState->get("event_name") ?$viewState->get("event_name") : '0' ?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            Số lượng trẻ em:
                                        </th>
                                        <td>
                                            <input type="number" name="event_name" id="event_name" value="<?= $viewState->get("event_name") ?$viewState->get("event_name") : '0' ?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            Full ngày:
                                        </th>
                                        <td>
                                            <select name="cars" id="cars">
                                                <option value="volvo">Có</option>
                                                <option value="saab">Không</option>
                                            </select>
                                        </td>
                                    </tr>
                                    
                                    <script type="text/javascript" src="../theme/admin/js/jquery.jpostal.js"></script>
                                    <script type="text/javascript">
                                        $(window).ready( function() {
                                        //jpostal用処理
                                        $('#event_pos_code1').jpostal({
                                            postcode : [
                                            '#event_pos_code1',
                                            '#event_pos_code2'
                                            ],
                                            address : {
                                                '#event_prefectures'  : '%3',
                                                '#event_city'  : '%4',
                                                '#event_address'  : '%5'
                                            }
                                        });
                                    });
                                    </script>
                                  
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

<script type="text/javascript">
    $('#event_role').on('click', ':checkbox', function() {
        var roles = [];
        var event_id = null;
        var event_id = $('input.event_id').val();
/*        alert(temp);*/
        $('#event_role input:checked').each(function() {
            roles.push(this.value);
        });
        $.ajax({
                url:"<?=$urlCheckUpdateRole?>",
                type:"post",
                data:{
                    event_id:event_id, 
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