<script type="text/javascript">
function ExportCSV() {
window.location.href = window.location + '&export=csv';
}

function re_cal(ma, staff_id, staff_role){
    prj_comm_partition_amount =  $(".re_shi" + ma+'_'+staff_id+'_'+staff_role).val().replace(',','');
    prj_prod_price_selling_total = $(".totalrow8_" + ma).html().replace(',','');

    if (isNaN(parseInt(prj_comm_partition_amount)) === false) {
        prj_comm_partition_amount = $(".re_shi" + ma+'_'+staff_id+'_'+staff_role).val().replace(',','');
    } else {
        prj_comm_partition_amount = 0;
    }
    if (isNaN(parseInt(prj_prod_price_selling_total)) === false) {
        prj_prod_price_selling_total = $(".re_totalrow8_" + ma).html().replace(',','');
    } else {
        prj_prod_price_selling_total = 0;
    }
    
    result = parseInt(prj_prod_price_selling_total) - parseInt(prj_comm_partition_amount);
    $(".re_ri" + ma).val(result);  
    $(".re_ri" + ma).trigger("change");      
}
function cal(ma, staff_id, staff_role) {
    prj_comm_partition_amount =  $(".shi" + ma+'_'+staff_id+'_'+staff_role).val().replace(',','');
    prj_prod_price_selling_total = $(".totalrow8_" + ma).html().replace(',','');

    if( $(".re_shi" + ma+'_'+staff_id+'_'+staff_role).length ){
        $(".re_shi" + ma+'_'+staff_id+'_'+staff_role).val(prj_comm_partition_amount);
        re_cal(ma, staff_id, staff_role);
    }

    if (isNaN(parseInt(prj_comm_partition_amount)) === false) {
        prj_comm_partition_amount = $(".shi" + ma+'_'+staff_id+'_'+staff_role).val().replace(',','');
    } else {
        prj_comm_partition_amount = 0;
    }
    if (isNaN(parseInt(prj_prod_price_selling_total)) === false) {
        prj_prod_price_selling_total = $(".totalrow8_" + ma).html().replace(',','');
    } else {
        prj_prod_price_selling_total = 0;
    }
    
    result = parseInt(prj_prod_price_selling_total) - parseInt(prj_comm_partition_amount);
    $(".ri" + ma).val(result);  
    $(".ri" + ma).trigger("change");


}

function re_cal_else(ma, staff_id, staff_role){
    prj_comm_partition_amount = $(".re_ri" + ma).val().replace(',','');
    prj_prod_price_selling_total = $(".re_totalrow8_" + ma).html().replace(',','');
    if (isNaN(parseInt(prj_comm_partition_amount)) === false) {
        prj_comm_partition_amount = $(".re_ri" + ma).val().replace(',','');
    } else {
        prj_comm_partition_amount = 0;
    }
    if (isNaN(parseInt(prj_prod_price_selling_total)) === false) {
        prj_prod_price_selling_total = $(".re_totalrow8_" + ma).html().replace(',','');
    } else {
        prj_prod_price_selling_total = 0;
    }
    result = parseInt(prj_prod_price_selling_total) - parseInt(prj_comm_partition_amount);
    $(".re_shi" + ma+'_'+staff_id+'_'+staff_role).val(result);
    $( ".re_supper_percent_" + ma).each(function() {
        var value = $(this).parent().find('.input-mini').attr("onblur");
        setTimeout ( value, 1 );
    });
}
function cal_else(ma,staff_id,staff_role) {
    prj_comm_partition_amount = $(".ri" + ma).val().replace(',','');

    if( $(".re_ri" + ma).length ){
        $(".re_ri" + ma).val(prj_comm_partition_amount);
        re_cal_else(ma, staff_id, staff_role);
    }
    
    prj_prod_price_selling_total = $(".totalrow8_" + ma).html().replace(',','');
    if (isNaN(parseInt(prj_comm_partition_amount)) === false) {
        prj_comm_partition_amount = $(".ri" + ma).val().replace(',','');
    } else {
        prj_comm_partition_amount = 0;
    }
    if (isNaN(parseInt(prj_prod_price_selling_total)) === false) {
        prj_prod_price_selling_total = $(".totalrow8_" + ma).html().replace(',','');
    } else {
        prj_prod_price_selling_total = 0;
    }
    result = parseInt(prj_prod_price_selling_total) - parseInt(prj_comm_partition_amount);
    $(".shi" + ma+'_'+staff_id+'_'+staff_role).val(result);
    $( ".supper_percent_" + ma).each(function() {
        var value = $(this).parent().find('.input-mini').attr("onblur");
        setTimeout ( value, 1 );
    });
}

function re_percent(ma, staff_id, staff_role){
    sub_amount = $('input[name="re_prj_comm_amount_' +ma+ '_'+staff_id+'_'+staff_role+'"]').val().replace(',','');
    total       = $("input.re_ri"+ ma).val();
    var percent = 0;
    if(total != 0){ 
        percent = (sub_amount/total )* 100;
    }
    $("#re_sub_percent"+ ma+'_'+staff_id+'_'+staff_role).text(percent.toFixed(2) + '%');
    $("input#re_sub_percent_input"+ ma+'_'+staff_id+'_'+staff_role).val(percent.toFixed(2));
    var total_percent = 0;
    $( ".re_supper_percent_" + ma).each(function() {
        var value = $(this).html().replace(',','');
        value = value.replace("%", "");    
        value = value.trim();
        if (value !== '' && value !== null && value.length > 0 && value !== undefined){
            total_percent = (parseFloat(total_percent) + parseFloat(value)).toFixed(2);
        }
    });
    $('#re_total_percent' + ma).html(total_percent + '%');
    $('#re_total_percent_input' +ma).val(total_percent);
}

function percent(ma, staff_id, staff_role) {
    sub_amount = $('input[name="prj_comm_amount_' +ma+ '_'+staff_id+'_'+staff_role+'"]').val().replace(',','');
    total       = $("input.ri"+ ma).val();
    var percent = 0;
    if(total != 0)
      { 
        percent = (sub_amount/total )* 100;
      }  
    $("#sub_percent"+ ma+'_'+staff_id+'_'+staff_role).text(percent.toFixed(2) + '%');
    $("input#sub_percent_input"+ ma+'_'+staff_id+'_'+staff_role).val(percent.toFixed(2));
    var total_percent = 0;
    $( ".supper_percent_" + ma).each(function() {
        var value = $(this).html().replace(',','');
        value = value.replace("%", "");    
        value = value.trim();     
        if (value != ''){
            total_percent = (parseFloat(total_percent) + parseFloat(value)).toFixed(2);
        }
    });
    $('#total_percent' + ma).html(total_percent + '%');
    $('#total_percent_input' +ma).val(total_percent);
}
function changeDate(prj_id,staff_id,role_grp){
    var year = $('#prj_comm_close_date_year_'+prj_id+'_'+staff_id+'_'+role_grp).val();
    var month = $('#prj_comm_close_date_month_'+prj_id+'_'+staff_id+'_'+role_grp).val();
    var date = year + month;
    if(date != '00')
        $('input.prj_comm_close_date_'+prj_id+'_'+staff_id+'_'+role_grp).val(date);
    else
        $('input.prj_comm_close_date_'+prj_id+'_'+staff_id+'_'+role_grp).val(null);
    
}
function re_changeDate(prj_id,staff_id,role_grp){
    var year = $('#re_prj_comm_close_date_year_'+prj_id+'_'+staff_id+'_'+role_grp).val();
    var month = $('#re_prj_comm_close_date_month_'+prj_id+'_'+staff_id+'_'+role_grp).val();
    var date = year + month;
    if(date != '00')
        $('input.re_prj_comm_close_date_'+prj_id+'_'+staff_id+'_'+role_grp).val(date);
    else
        $('input.re_prj_comm_close_date_'+prj_id+'_'+staff_id+'_'+role_grp).val(null);
    
}
jQuery(document).ready(function () {
    $('input:radio[name="view"]').change(function () {
        if ($(this).val() == 1) {
            $(".hs").show();
            $(".hs1").hide();
        }
        if ($(this).val() == 2) {
            $(".hs1").show();
            $(".hs").hide();
        }
    });
});
</script>
<?php
    $view = $viewState->get("view");
    if($view == '2')
    {
        $script = "<script type='text/javascript'>
            $( document ).ready(function() {
                $('.hs1').show();
                $('.hs').hide();
            });
        </script>";
        echo $script;
    }
?>

<div id="content" class="clearfix">
    <div class="contentwrapper">
        <!--Content wrapper-->
        <div class="heading">
            <h3>歩合集計</h3>
            <div class="search_open">
                <a id="opener">- 閉じる</a>
            </div>
        </div>
        
        <!-- End .heading-->
        <div class="content_border" id="disp_block"><br />
                    <ul id="show-error-messages" class="header-error-messages updatemessage"></ul>
            <form action="<?= $urlSearch ?>" method="get">
                <input type="hidden" name="<?= REQUEST_PARAM_PAGE_ID ?>" value="<?= PageIdConstants::INCENTIVE ?>" />
                <input type="hidden" name="<?= REQUEST_PARAM_ACTION_METHOD ?>" value="search" />
                <table class="search_form_table" >
                    <tbody>
                        <tr>
                            <th>
                                担当社員ID
                            </th>
                            <td><input type="text" id="prj_staff_id" name="prj_staff_id" value="<?= $viewState->get("prj_staff_id") ?>" id=""></td>
                        </tr>
                        <tr>
                            <th>
                                担当社員名
                            </th>
                            <td><input type="text" id="staff_name" name="staff_name" value="<?= $viewState->get("staff_name") ?>" id=""></td>
                        </tr>
                        <tr>
                            <th>
                                担当種別
                            </th>
                            <td>
                                <?= HtmlUtil::radioButtons("prj_role_grp", AppConfig::$ROLE_GROUP_SEARCH, $viewState->get("prj_role_grp") == NULL ? 0 : $viewState->get("prj_role_grp")) ?>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                契約種別
                            </th>
                            <td>
                                <?= HtmlUtil::radioButtons("prj_kind_contract", AppConfig::$CONTRACT, $viewState->get("prj_kind_contract") == NULL ? 0 : $viewState->get("prj_kind_contract")) ?>
                            </td>
                        </tr>
                        <tr>
                            <th>
                                並び順
                            </th>
                            <td>
                                <?= HtmlUtil::radioButtons("view", AppConfig::$VIEW, $viewState->get("view") == null ? 1 : $viewState->get("view")) ?>
                            </td>
                        </tr>
                        <tr id="keiyaku" class="hs">
                            <th>
                                契約日
                            </th>
                            <td>
                                <div id="sortproject1">
                                    <?= HtmlUtil::CalendarInput("prj_keiyaku_bi_from", $viewState->get("prj_keiyaku_bi_from")) ?>
                                    ～
                                    <?= HtmlUtil::CalendarInput("prj_keiyaku_bi_to", $viewState->get("prj_keiyaku_bi_to")) ?>
                                    <span id="show_message_date_v1_from1"></span>
                                    <span id="show_message_date_v1_to1"></span>
                                </div>
                            </td>
                        </tr>
                        <tr id="kanno" class="hs">
                            <th>
                                完納年月日
                            </th>
                            <td>
                                <div id="sortproject">
                                    <?= HtmlUtil::CalendarInput("date_ranked_from", $viewState->get("date_ranked_from")) ?>
                                    ～
                                    <?= HtmlUtil::CalendarInput("date_ranked_to", $viewState->get("date_ranked_to")) ?>
                                    <span id="show_message_date_v1_from2"></span>
                                    <span id="show_message_date_v1_to2"></span>
                                </div>
                            
                                <span class="komered">※「キャンセル日」が検索範囲内に含まれた場合、検索対象に含めます。
                                    <br>
                                    キャンセル日が設定された案件は、歩合のマイナス発行を行うために2回抽出されます。</span>
                            </td>
                        </tr>
                        <tr id="buai" class="hs1" style="display: none;">
                            <th>
                                歩合締日
                            </th>
                            <td>
                                <?= HtmlUtil::dropList("prj_pay_completed_date_year", AppConfig::$YEAR,  $viewState->get("prj_pay_completed_date_year"),"", "", "", array()) ?> 年
                                <?= HtmlUtil::dropList("prj_pay_completed_date_month", AppConfig::$MONTH, $viewState->get("prj_pay_completed_date_month"),"", "", "", array()) ?> 月分
                                   <span id="show_message_date"></span>
                            </td>
                            
                        </tr>
                        <tr>
                            <td colspan="2" class="text_center"><input class="button_submit_cancel" type="submit" value="検索"></td>
                        </tr>
                    </tbody>
                </table>
            </form>
        </div>
        <!-- Build page from here: Usual with <div class="row-fluid"></div> -->
        <div class="row-fluid">
            <div class="span12">
                <div class="box gradient">
            
                    <?php if (isset($data1) && $flat == 1): ?>   
                        <?php include_once('view1.php') ?>
                    <?php endif; ?>
                    <?php if (isset($data2) && $flat == 2) : ?>
                        <?php include_once('view2.php') ?>
                    <?php endif; ?>
                </div>
            <!-- End .box -->
            </div>
            <!-- End .span12 -->
        </div>
        <!-- Page end here -->
    </div>
    <!-- End contentwrapper -->
</div>