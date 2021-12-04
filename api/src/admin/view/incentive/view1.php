<style>
    .table th, .table td {
        line-height: 15px;
    }
</style>
<form action="" method="post" >
    <div class="content noPad clearfix" id="DataArea">
        <div class="title">
            <table style="width: 100%;">
                <tbody><tr>
                        <td style="width: 33%;text-align: left;"> </td>
                        <td style="width: 33%;text-align: center;"><h4>
                            </h4></td>
                        <td style="width: 33%;text-align: right;">  </td>
                    </tr>
                </tbody></table>
        </div>
        <div class="text_right padding_10px">
            <button type="button" class="btn-primary btn" onclick="ExportCSV();">CSVダウンロード</button>
        </div>
      
        <table id="DnDTable" cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered table-condensed" width="100%">
            <thead>
                <tr>
                    <th style="white-space:nowrap;">案件<br>ID</th>
                    <th style="white-space:nowrap;">社員名/<br>担当種別</th>
                    <th style="white-space:nowrap;">契約日/完納日 <br>キャンセル日</th>
                    <th style="white-space:nowrap;">PV,EQ,IH</th>
                    <th style="white-space:nowrap;">メーカー</th>
                    <th style="white-space:nowrap;">お客様名</th>
                    <th style="white-space:nowrap;">Kw &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                    <th style="white-space:nowrap;">売上金額<br>（支払済金額）</th>
                    <th style="white-space:nowrap;">仕切金額</th>
                    <th style="white-space:nowrap;">利益額</th>
                    <th style="white-space:nowrap;">歩合締日</th>
                    <th style="white-space:nowrap;">歩合(円)</th>
                    <th style="white-space:nowrap;">歩合<br>合計(%)</th>
                    <th style="white-space:nowrap;">メモ</th>
                </tr>
            </thead>
            <tbody>
            
                <?php
                    $i = 1;
                    $check_row = null;
                    $staff_role = null;
                    $incentive = $data1;
                    $last = 0;
                    $has_repeat = false;
                    $repeating  = false;
                    $flag = false;
                    $re_row = null;
                    for ($k = 0, $countI = count($incentive); $k < $countI; $k++){

                        /*2605*/
                        $rowspan = $incentive[$k]['num_staff_join'];
                        $repeat = false;
                        
                        if($check_row != $incentive[$k]['prj_id']) { 
                            $last = 0;
                        }
                        if($last === ($rowspan-1))
                        {
                            if(!$has_repeat) {
                                if(!StringUtil::isNullOrEmpty($incentive[$k]['prj_kyanceru_bi'])){
                                    $repeat     = true;
                                    //$repeating  = true;
                                }
                            }else{
                                $repeating = false;
                            }
                        }

                        if($flag){
                            $re = "re_";
                            $disabled = "disabled";
                        }
                        else{
                            $re = null;
                            $disabled = null;
                        }
                        /*2605*/


                        $total_percent = 0;
                        $total_percent_item = 0;

                        $re_total_percent = 0;
                        $re_total_percent_item = 0;

                        $prj_comm_partition_amount= $incentive[$k]['prj_comm_partition_amount']!=null?$incentive[$k]['prj_comm_partition_amount']:(int)$incentive[$k]['total_prod_price_part']- (int)$incentive[$k]['total_prod_price_part2'];
                        $prj_prod_price_selling_total = $incentive[$k]['prj_prod_price_selling_total'] ;
                        $prj_comm_income_amount    = (StringUtil::isNullOrEmpty($incentive[$k]['prj_comm_income_amount']) || $incentive[$k]['prj_comm_income_amount'] == 0) ? (int)$prj_prod_price_selling_total - (int)$prj_comm_partition_amount : $incentive[$k]['prj_comm_income_amount'];
                        
                        foreach ($data1 as $item2)
                        {
                            if ($incentive[$k]['prj_id'] == $item2['prj_id']){
                                $total_percent    += $prj_comm_income_amount == '' ? 0 : round(($item2['prj_comm_amount']/$prj_comm_income_amount) * 100,2);
                                $re_total_percent += $prj_comm_income_amount == '' ? 0 : round(($item2['re_prj_comm_amount']/$prj_comm_income_amount) * 100,2);
                            }
                        }

                        $totalprj_comm_amount_item = $incentive[$k]['prj_comm_amount'] == '' ? 0 : $incentive[$k]['prj_comm_amount'];
                        $total_percent_item = ($prj_comm_income_amount == '' || $prj_comm_income_amount == 0) ? 0 : round(($totalprj_comm_amount_item/$prj_comm_income_amount) * 100,2);
                        
                        $re_totalprj_comm_amount_item = $incentive[$k]['re_prj_comm_amount'] == '' ? 0 : $incentive[$k]['re_prj_comm_amount'];
                        $re_total_percent_item = ($prj_comm_income_amount == '' || $prj_comm_income_amount == 0) ? 0 : round(($re_totalprj_comm_amount_item/$prj_comm_income_amount) * 100,2);
                        
                        for($j=0,$count=count(AppConfig::$STAFF_POS); $j <= $count; $j++)
                        {
                            if(AppConfig::$STAFF_POS[$j][0] == $incentive[$k]['prj_role_grp']){
                                $staff_role = AppConfig::$STAFF_POS[$j][2];
                                break;
                            }
                        }
                        
                        
                        $prj_comm_memo             = $incentive[$k]['prj_comm_memo'];
                        $prj_comm_close_date       = $incentive[$k]['prj_comm_close_date'];
                        $prj_comm_amount           = $incentive[$k]['prj_comm_amount'];

                        $re_prj_comm_close_date    = $incentive[$k]['re_prj_comm_close_date'];
                        $re_prj_comm_amount        = $incentive[$k]['re_prj_comm_amount'];

                        if($re === "re_"){
                            if(!StringUtil::isNullOrEmpty($re_prj_comm_close_date)){
                                $year  = substr($incentive[$k]['re_prj_comm_close_date'], 0, 4);
                                $month = substr($incentive[$k]['re_prj_comm_close_date'], 4, 2);
                            }
                        }else{
                            if(!StringUtil::isNullOrEmpty($prj_comm_close_date)){
                                $year  = substr($incentive[$k]['prj_comm_close_date'], 0, 4);
                                $month = substr($incentive[$k]['prj_comm_close_date'], 4, 2);
                            }
                        }
                        
                        

                        if ($viewState->get('isErrorValidate') == 1) {
                            if($re === "re_"){
                                $year  = $viewState->get("re_prj_comm_close_date_year_" . $incentive[$k]['prj_id'].'_'.$incentive[$k]['staff_join_id'].'_'.$incentive[$k]['prj_role_grp']);
                                $month = $viewState->get('re_prj_comm_close_date_month_' . $incentive[$k]['prj_id'].'_'.$incentive[$k]['staff_join_id'].'_'.$incentive[$k]['prj_role_grp']);
                            }else{
                                $year = $viewState->get("prj_comm_close_date_year_" . $incentive[$k]['prj_id'].'_'.$incentive[$k]['staff_join_id'].'_'.$incentive[$k]['prj_role_grp']);
                                $month = $viewState->get('prj_comm_close_date_month_' . $incentive[$k]['prj_id'].'_'.$incentive[$k]['staff_join_id'].'_'.$incentive[$k]['prj_role_grp']);
                            }
                            
                            $prj_comm_close_date = $viewState->get('prj_comm_close_date_'.$incentive[$k]['prj_id'].'_'.$incentive[$k]['staff_join_id'].'_'.$incentive[$k]['prj_role_grp']);
                            $prj_comm_amount    = $viewState->get('prj_comm_amount_'.$incentive[$k]['prj_id'].'_'.$incentive[$k]['staff_join_id'].'_'.$incentive[$k]['prj_role_grp']) ;

                            $re_prj_comm_close_date = $viewState->get('re_prj_comm_close_date_'.$incentive[$k]['prj_id'].'_'.$incentive[$k]['staff_join_id'].'_'.$incentive[$k]['prj_role_grp']);
                            $re_prj_comm_amount     = $viewState->get('re_prj_comm_amount_'.$incentive[$k]['prj_id'].'_'.$incentive[$k]['staff_join_id'].'_'.$incentive[$k]['prj_role_grp']) ;
                        }
                ?>  
                    <?php if($check_row != $incentive[$k]['prj_id']) { 
                        //$last = 0;
                        //$has_repeat = false;
                        $check_row = $incentive[$k]['prj_id'];
                        $total_type1 = (int) $total_type1 + (int) $incentive[$k]['total1'];
                        $total_type2 = (int) $total_type2 + (int) $incentive[$k]['total2'];
                        $total_type3 = (int) $total_type3 + (int) $incentive[$k]['total3'];
                        $total_income   += (int) ($incentive[$k]['prj_prod_price_selling_total'] - $incentive[$k]['prj_comm_partition_amount']);
                        $total_selling  += (int) $incentive[$k]['prj_prod_price_selling_total'];
                        $total_revent   += (int) $incentive[$k]['total_reven'];
                        $total_parti    += (int) ($incentive[$k]['prj_comm_partition_amount'] != NULL ? $incentive[$k]['prj_comm_partition_amount'] : $incentive[$k]['total_prod_price_part'] );

                        if(StringUtil::isNullOrEmpty($prj_comm_income_amount)){
                            $prj_comm_income_amount = $incentive[$k]['prj_prod_price_selling_total'] - $incentive[$k]['prj_comm_partition_amount'];
                        }
                    ?>

                    <tr id="1">
                        <?php if($re===null){ ?>
                            <td class="hide">
                            <input type="hidden" name="updated_time_<?=$incentive[$k]['prj_id']?>" value="<?=$incentive[$k]['updated_time']?>" /> 
                            <input type="hidden" name="prj_id_<?=$incentive[$k]['prj_id']?>" value="<?=$incentive[$k]['prj_id']?>" /> 
                            </td>
                        <?php } ?>
                       <td style="border-top:solid 2px #000000;">
                        <p <?=$flag ? 'class="re_label"':'' ?> ><?=$incentive[$k]['prj_id']?></p>
                       </td>
                       <td style="white-space: nowrap;border-top:solid 2px #000000;"><span class="<?=$re? 're_label' : ''?>"><?=$incentive[$k]['staff_join']?><span><br>(<?=$staff_role?>)</td>
                       <td rowspan="<?=$rowspan?>" style="white-space: nowrap;border-top:solid 2px #000000;" class="<?=$re? 're_label' : ''?>">
                            <?=$incentive[$k]['prj_keiyaku_bi'] ?> / <br>
                            <?=StringUtil::isNullOrEmpty($incentive[$k]['prj_pay_completed_date'])?'----------':$incentive[$k]['prj_pay_completed_date']?> / <br> 
                            <span class="komered"><?=$incentive[$k]['prj_kyanceru_bi']?></span>
                       </td>
                       <td rowspan="<?=$rowspan?>" style="border-top:solid 2px #000000;" class="<?=$re? 're_label' : ''?>"> 
                            <?php
                            $pv = ArrayUtil::StringToArray($incentive[$k]['prj_kind_pv']);
                            if (in_array(1, $pv))
                                echo '○、';
                            else
                                echo 'なし、';
                            $prj_kind_od = ArrayUtil::StringToArray($incentive[$k]['prj_kind_od']);
                            if (in_array(1, $prj_kind_od))
                                echo '○、';
                            else
                                echo 'なし、';
                            $prj_kind_od = ArrayUtil::StringToArray($incentive[$k]['prj_kind_od']);
                            if (in_array(2, $prj_kind_od))
                                echo '○';
                            else
                                echo 'なし';
                            ?>    
                       </td>
                       <td rowspan="<?=$rowspan?>" style="border-top:solid 2px #000000;" class="<?=$re? 're_label' : ''?>">
                            <?= AppConfig::$MAKER[$incentive[$k]['prj_maker']] ?>
                        </td>
                       <td rowspan="<?=$rowspan?>" style="border-top:solid 2px #000000;">
                            <a href="<?=UrlUtil::url($urlEdit, array("edit_prj_id"=>$incentive[$k]["prj_id"]))?>" target="_blank"><?= $incentive[$k]['prj_cust_name'] ?></a>
                       </td>
                       <td rowspan="<?=$rowspan?>" style="border-top:solid 2px #000000;" class="<?=$re? 're_label' : ''?>"><?= $incentive[$k]['prj_prod_kw'] ?>Kw</td>
                        
                       <td rowspan="<?=$rowspan?>" style="border-top:solid 2px #000000" class="<?=$re? 're_label' : ''?>" >
                          <span class="<?=$re?>totalrow8_<?=$incentive[$k]['prj_id']?>  number ">
                            <?= $incentive[$k]['prj_prod_price_selling_total'] ?></span><br>
                          <input type="hidden" value="<?= $prj_prod_price_selling_total?>">
                           <span>
                           <?= $incentive[$k]['total_reven']!=null?'('.number_format($incentive[$k]['total_reven']).')':''?>
                           </span>&nbsp;
                       </td>
                       <td rowspan="<?=$rowspan?>" style="border-top:solid 2px #000000;" class="<?=$re? 're_label' : ''?>">
                            <span class="number"><?= $incentive[$k]['total_prod_price_part']- $incentive[$k]['total_prod_price_part2'] ?></span>
                            <br>
                          
                            <input 
                                type="text" 
                                onblur="<?=$re?>cal( <?= $incentive[$k]['prj_id'] ?>
                                            ,<?= $incentive[$k]['staff_join_id'] ?> 
                                            ,<?= $incentive[$k]['prj_role_grp'] ?> )"   
                                name="<?=$re?>prj_comm_partition_amount_<?= $incentive[$k]['prj_id'] ?>"  
                                class="<?=$re?>shi<?= $incentive[$k]['prj_id'] ?>_<?= $incentive[$k]['staff_join_id'] ?>_<?= $incentive[$k]['prj_role_grp'] ?> input-mini <?=$re?>input" 
                                value="<?=$prj_comm_partition_amount?>" 
                                <?= $disabled ?>
                                >円
                       </td>
                       <td rowspan="<?=$rowspan?>" class="ws_nowrap <?=$re? 're_label' : ''?>" style="border-top:solid 2px #000000;">
                            <span class="diff_koji ">工事：<span  class="number"><?= ($incentive[$k]['total1']) ?></span> </span><br>
                            <span class="diff_seichi ">整地：<span  class="number"><?= ($incentive[$k]['total2']) ?></span></span> <br>
                            <span class="diff ">利益：<span  class="number"><?= ($incentive[$k]['total3']) ?></span></span>
                            <br>
                            （値引き合計：<span class="number"><?=!StringUtil::isNullOrEmpty($incentive[$k]['promotionTotal']) ? '-'.$incentive[$k]['promotionTotal'] : '0';?></span>）<br>
                            利益額調整：<br>
                            <input 
                                type="text" 
                                <?=$re?>onchange="<?=$re?>cal_else(
                                    <?= $incentive[$k]['prj_id'] ?>
                                    ,<?= $incentive[$k]['staff_join_id'] ?>
                                    ,<?= $incentive[$k]['prj_role_grp'] ?>)" 
                                name="<?=$re?>prj_comm_income_amount_<?= $incentive[$k]['prj_id'] ?>"  
                                class="<?=$re?>ri<?= $incentive[$k]['prj_id'] ?> input-mini <?=$re?>input"
                                value="<?=  $prj_comm_income_amount ?>"  
                                <?=$disabled?>
                                > 円
                       </td>
                       <td style="border-top:solid 2px #000000;" class="<?=$re? 're_label' : ''?>">
                          <?php $commission_date = $re ? $re_prj_comm_close_date : $prj_comm_close_date ?>
                          <input 
                            type="hidden" 
                            value="<?= $commission_date ?>"  
                            name="<?=$re?>prj_comm_close_date_<?= $incentive[$k]['prj_id'] ?>_<?=$incentive[$k]['staff_join_id']?>_<?=$incentive[$k]['prj_role_grp']?>" 
                            class="<?=$re?>prj_comm_close_date_<?= $incentive[$k]['prj_id'] ?>_<?=$incentive[$k]['staff_join_id']?>_<?=$incentive[$k]['prj_role_grp']?>">     
                                <span style="display:inline-flex">
                                    <?= HtmlUtil::dropList(
                                        $re."prj_comm_close_date_year_" . $incentive[$k]['prj_id'].'_'.$incentive[$k]['staff_join_id'].'_'.$incentive[$k]['prj_role_grp']
                                        , AppConfig::$YEAR
                                        , $year
                                        , ""
                                        , ""
                                        , ""
                                        , array()
                                        , $re."prj_comm_close_date_year_" . $incentive[$k]['prj_id'].'_'.$incentive[$k]['staff_join_id'].'_'.$incentive[$k]['prj_role_grp']. " input-small ".$re."input"
                                        , array('onchange' => $re.'changeDate(' . $incentive[$k]["prj_id"] . ','.$incentive[$k]['staff_join_id'].','.$incentive[$k]['prj_role_grp'].')')); ?>年</span><br>
                                    <?= HtmlUtil::dropList(
                                        $re."prj_comm_close_date_month_" . $incentive[$k]['prj_id'].'_'.$incentive[$k]['staff_join_id'].'_'.$incentive[$k]['prj_role_grp']
                                        , AppConfig::$MONTH
                                        , $month
                                        , ""
                                        , ""
                                        , ""
                                        , array()
                                        , $re."prj_comm_close_date_month_" . $incentive[$k]['prj_id'].'_'.$incentive[$k]['staff_join_id'] .'_'.$incentive[$k]['prj_role_grp']. " input-mini ".$re."input"
                                        , array('onchange' => $re.'changeDate(' . $incentive[$k]["prj_id"] . ','.$incentive[$k]['staff_join_id'].','.$incentive[$k]['prj_role_grp'].')')); ?>月分
                            <?php
                            if(!StringUtil::isNullOrEmpty($commission_date)){
                                echo "<br>";
                                $target_date  = $year. '-' .$month.'-11';
                                $target_date  = DateUtil::SubAddMonth($target_date, '+', 1);
                                if(DateUtil::CompareTwoDateString($target_date,  date('Y-m-d'), '<=')){
                                    echo '<span class="komered">支払済<span>';
                                }
                            }
                            ?>
                       </td>
                       <td style="border-top:solid 2px #000000;" class="<?=$re? 're_label' : ''?>">
                            <input 
                                type="text" 
                                name="<?=$re?>prj_comm_amount_<?= $incentive[$k]['prj_id'] ?>_<?=$incentive[$k]['staff_join_id']?>_<?=$incentive[$k]['prj_role_grp']?>"  
                                onblur="<?=$re?>percent(<?= $incentive[$k]['prj_id'] ?>, <?= $incentive[$k]['staff_join_id'] ?>,<?=$incentive[$k]['prj_role_grp']?>)" 
                                value="<?= $re ? $re_prj_comm_amount : $prj_comm_amount ?>"
                                class="<?=$re.'input'?> input-mini ime_off judge1 <?=$re?>incentive<?= $incentive[$k]['prj_id'] ?>_<?= $incentive[$k]['staff_join_id'] ?>_<?=$incentive[$k]['prj_role_grp']?>" /><br>円
                            <div class="<?=$re?>supper_percent_<?= $incentive[$k]['prj_id'] ?>" 
                                 id="<?=$re?>sub_percent<?= $incentive[$k]['prj_id'] ?>_<?= $incentive[$k]['staff_join_id'] ?>_<?=$incentive[$k]['prj_role_grp']?>" 
                                 style="text-decoration: underline">
                                    <?php 
                                    $sub_percent_input_value = null;
                                    if($re === null){ 
                                        echo $total_percent_item!=null?$total_percent_item."%":"";
                                        $sub_percent_input_value = $total_percent_item;
                                    }elseif($re === 're_'){
                                        echo $re_total_percent_item!=null?$re_total_percent_item."%":"";
                                        $sub_percent_input_value = $re_total_percent_item;
                                    }
                                    ?>
                                 </div>
                            <input id="<?=$re?>sub_percent_input<?= $incentive[$k]['prj_id'] ?>_<?= $incentive[$k]['staff_join_id'] ?>_<?=$incentive[$k]['prj_role_grp']?>" 
                                name="<?=$re?>sub_percent_input<?= $incentive[$k]['prj_id'] ?>_<?= $incentive[$k]['staff_join_id'] ?>_<?=$incentive[$k]['prj_role_grp']?>" 
                                value="<?=$sub_percent_input_value?>"
                                type="hidden" >
                            <br>
                       </td>
                       <td rowspan="<?=$rowspan?>"  style="border-top:solid 2px #000000;" class="<?=$re? 're_label' : ''?>">
                            <span id="<?=$re?>total_percent<?= $incentive[$k]['prj_id'] ?>" >
                            <?php 
                                $value_total_percent = null;
                                if($re === null){
                                    echo $total_percent != 0 ? $total_percent . '%' : '';
                                    $value_total_percent = $total_percent;
                                }
                                if($re === 're_'){
                                    echo $re_total_percent != 0 ? $re_total_percent . '%' : '';
                                    $value_total_percent = $re_total_percent;
                                }
                            ?>
                            </span>
                            <input id="<?=$re?>total_percent_input<?= $incentive[$k]['prj_id'] ?>" 
                                name="<?=$re?>total_percent_input<?= $incentive[$k]['prj_id'] ?>"
                                value="<?=$value_total_percent?>"
                                type="hidden" >
                        </td>
                       <td rowspan="<?=$rowspan?>" style="border-top:solid 2px #000000;" >
                            <textarea <?=$disabled?> name="<?=$re?>prj_comm_memo_<?= $incentive[$k]['prj_id'] ?>"  cols="30" rows="10" class="input-mini <?=$re? 're_label' : ''?> <?=$re?>input"><?= $prj_comm_memo ?></textarea>
                        </td>
                    </tr>
                    <?php  }else{ ?>
                    <tr id="2">
                       <td style=""><p <?=$flag ? 'class="re_label"':'' ?>><?=$incentive[$k]['prj_id']?></p>
                       </td>
                       <td style="white-space: nowrap;"><span class="<?=$re? 're_label' : ''?>"><?=$incentive[$k]['staff_join']?><br>(<?=$staff_role?>)</span></td>
                       <td style="" class="<?=$re? 're_label' : ''?>">
                          <?php $commission_date = $re ? $re_prj_comm_close_date : $prj_comm_close_date ?>
                          <input 
                            type="hidden" 
                            value="<?= $commission_date ?>"  
                            name="<?=$re?>prj_comm_close_date_<?= $incentive[$k]['prj_id'] ?>_<?=$incentive[$k]['staff_join_id']?>_<?=$incentive[$k]['prj_role_grp']?>" 
                            class="<?=$re?>prj_comm_close_date_<?= $incentive[$k]['prj_id'] ?>_<?=$incentive[$k]['staff_join_id']?>_<?=$incentive[$k]['prj_role_grp']?>">     
                                <span style="display:inline-flex">
                                    <?= HtmlUtil::dropList(
                                        $re."prj_comm_close_date_year_" . $incentive[$k]['prj_id'].'_'.$incentive[$k]['staff_join_id'].'_'.$incentive[$k]['prj_role_grp']
                                        , AppConfig::$YEAR
                                        , $year
                                        , ""
                                        , ""
                                        , ""
                                        , array()
                                        , $re."prj_comm_close_date_year_" . $incentive[$k]['prj_id'].'_'.$incentive[$k]['staff_join_id'].'_'.$incentive[$k]['prj_role_grp']. " input-small ".$re."input"
                                        , array('onchange' => $re.'changeDate(' . $incentive[$k]["prj_id"] . ','.$incentive[$k]['staff_join_id'].','.$incentive[$k]['prj_role_grp'].')')); ?>年</span><br>
                                    <?= HtmlUtil::dropList(
                                        $re."prj_comm_close_date_month_" . $incentive[$k]['prj_id'].'_'.$incentive[$k]['staff_join_id'].'_'.$incentive[$k]['prj_role_grp']
                                        , AppConfig::$MONTH
                                        , $month
                                        , ""
                                        , ""
                                        , ""
                                        , array()
                                        , $re."prj_comm_close_date_month_" . $incentive[$k]['prj_id'].'_'.$incentive[$k]['staff_join_id'] .'_'.$incentive[$k]['prj_role_grp']. " input-mini ".$re."input"
                                        , array('onchange' => $re.'changeDate(' . $incentive[$k]["prj_id"] . ','.$incentive[$k]['staff_join_id'].','.$incentive[$k]['prj_role_grp'].')')); ?>月分
                                    <?php 
                                    if(!StringUtil::isNullOrEmpty($commission_date)){
                                        echo "<br>";
                                        $target_date  = $year. '-' .$month.'-11';
                                        $target_date  = DateUtil::SubAddMonth($target_date, '+', 1);
                                        if(DateUtil::CompareTwoDateString($target_date,  date('Y-m-d'), '<=')){
                                            echo '<span class="komered">支払済<span>';
                                        }
                                    }
                                    ?>
                       </td>
                       <td style="" data="prj_comm_amount" class="<?=$re? 're_label' : ''?>">
                            <input 
                                type="text" 
                                name="<?=$re?>prj_comm_amount_<?= $incentive[$k]['prj_id'] ?>_<?=$incentive[$k]['staff_join_id']?>_<?=$incentive[$k]['prj_role_grp']?>"  
                                onblur="<?=$re?>percent(<?= $incentive[$k]['prj_id'] ?>, <?= $incentive[$k]['staff_join_id'] ?>, <?= $incentive[$k]['prj_role_grp'] ?>)" 
                                value="<?= $re? $re_prj_comm_amount : $prj_comm_amount ?>"
                                class="<?=$re?>input input-mini ime_off judge1 <?=$re?>incentive<?= $incentive[$k]['prj_id'] ?>_<?= $incentive[$k]['staff_join_id'] ?> " /><br>円
                            <div class="<?=$re?>supper_percent_<?= $incentive[$k]['prj_id'] ?>" 
                                 id="<?=$re?>sub_percent<?= $incentive[$k]['prj_id'] ?>_<?= $incentive[$k]['staff_join_id'] ?>_<?=$incentive[$k]['prj_role_grp']?>" 
                                 style="text-decoration: underline">
                                 <?php 
                                    $sub_percent_input_value = null;
                                    if($re=== null){
                                        echo $total_percent_item!=null?$total_percent_item."%":"";
                                        $sub_percent_input_value = $total_percent_item;
                                    }elseif($re === 're_'){
                                        echo $re_total_percent_item!=null?$re_total_percent_item."%":"";
                                        $sub_percent_input_value = $re_total_percent_item;
                                    } 
                                 ?>
                            </div>
                            <input id="<?=$re?>sub_percent_input<?= $incentive[$k]['prj_id'] ?>_<?= $incentive[$k]['staff_join_id'] ?>_<?=$incentive[$k]['prj_role_grp']?>" 
                                name="<?=$re?>sub_percent_input<?= $incentive[$k]['prj_id'] ?>_<?= $incentive[$k]['staff_join_id'] ?>_<?=$incentive[$k]['prj_role_grp']?>"
                                value="<?=$sub_percent_input_value ?>"
                                type="hidden" >
                            <br>
                       </td>
                    </tr>
                    <?php } ?>
                <?php 
                $year  = null;
                $month = null;
                $commission_date = null;
                $i++;
                    if($repeat){
                        $k          = $k - ($rowspan);
                        $has_repeat = true;
                        $check_row  = null;
                        //$k          = $k-1;
                        $repeating  = true;
                        $flag   = true;
                    }
                    if(!$repeating){
                        $has_repeat = false;
                        $flag   = false;
                    }
                $last++;
                } 
                ?>
            </tbody>
            <tbody>
                <tr>
                    <th style="white-space:nowrap;">合計</th>
                    <th style="white-space:nowrap;"></th>
                    <th style="white-space:nowrap;"></th>
                    <th style="white-space:nowrap;"></th>
                    <th style="white-space:nowrap;"></th>
                    <th style="white-space:nowrap;"></th>
                    <th style="white-space:nowrap;"></th>
                    <th style="white-space:nowrap;">
                        <span class="number" data="total_selling"><?= ($total_selling) ?></span><br>
                        <span  data="total_revent"><?= $total_revent!=null?"(" . number_format($total_revent). ")":'' ?></span>
                    </th>
                    <th style="white-space:nowrap;" data="total_parti">
                        <span class="number"><?= $total_parti ?></span>

                    </th>
                    <th style="white-space:nowrap;">
                        <span class="diff_koji ">工事：<span  class="number" ><?= ($total_type1) ?></span><br></span>
                        <span class="diff_seichi ">整地：<span  class="number" ><?= ($total_type2) ?></span> <br></span>
                        <span class="diff ">利益：<span  class="number" ><?= ($total_type3) ?></span><br></span>
                    </th>
                    <th style="white-space:nowrap;"> </th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
                <tr>
                    <td colspan="14" class="text_center" style="text-align: center;"><input class="button_submit_cancel" type="submit" value="確認画面へ"></td>
                    <td class="text_center" colspan="2">
                        <input type="hidden" value="1" name="regist_step">
                    </td>
                </tr>
            </tbody>
        </table>
        <br>                                
    </div>
</form>
<style type="text/css">
    .re_input{
        background-color: #ffe1e1 !important;
    }
    .re_label{
        color:#f90000 !important;
    }
</style>