<div class="clearfix" id="content">
   <div class="contentwrapper">
        <!--Content wrapper-->
        <div class="heading">
        <h3>案件変更履歴</h3>
        </div>
        <!-- End .heading-->
        <!-- Build page from here: Usual with <div class="row-fluid"></div> -->
        <div class="row-fluid">
        <div class="span12">
        <ul id="show-error-messages" class="header-error-messages updatemessage"></ul>
        <div class="box gradient">
        <form action="<?=$urlUpdateApproveMemo?>" method="post" id="frmApproveMemo">
            <input type="hidden" value="<?=$viewState->get('prj_id')?>" name="prj_id">
            <input type="hidden" value="<?=$viewState->get('id')?>" name="id">
            <input type="hidden" value="<?=$viewState->get('updated_time')?>" name="updated_time">
            <input type="hidden" value="<?=$viewState->get('redirect')?>" name="redirect">
            <div id="DataArea" class="content noPad clearfix">
                <div class="text_right padding_10px"><input type="button" class="btn-link btn" onclick="location.href='<?=UrlUtil::url($urlPrjEdit, array("edit_prj_id"=>$viewState->get('prj_id')));?>'" value="案件情報に戻る"></div>
                <table id="td_width" class="input_form_table">
                 <tbody>
                    <tr>
                       <th class="cap" colspan="3">基本情報</th>
                    </tr>
                    <tr>
                       <th>
                          変更日時
                       </th>
                       <td colspan="2"><?=$viewState->get('updated_time')?></td>
                    </tr>
                    <tr>
                       <th>
                          案件ID
                       </th>
                       <td colspan="2"><?=$viewState->get('prj_id')?></td>
                    </tr>
                    <tr>
                       <th>
                          お客様氏名 <span class="komered">※</span>
                       </th>
                       <td colspan="2"><?=$viewState->get('prj_cust_name')?></td>
                    </tr>
                    <tr>
                       <th>変更内容</th>
                       <th>変更前</th>
                       <th>変更後</th>
                    </tr>
                    <?php for ($i=1,$count = count(AppConfig::$HISTORY_CHANGE); $i <= $count; $i++) { 
                        $upd_item_before = null;
                        $upd_item_after = null;
                        $temp_before = $viewState->get('upd_item_before'.$i);
                        $temp_after = $viewState->get('upd_item_after'.$i);
                        $c1 = count($temp_before);
                        $c2 = count($temp_after);
                        $max = max($c1, $c2);
                        if($i==1){
                          $upd_item_before = $viewState->get('upd_item_before'.$i)[$i];
                          $upd_item_after = $viewState->get('upd_item_after'.$i)[$i];
                        }elseif($i==2 || $i==5 || $i==7 || $i==9){
                           for ($j=1; $j <= $max; $j++) { 
                              if(!StringUtil::isNullOrEmpty($temp_before[$i.'_'.$j.'_1']))
                                $upd_item_before .= $temp_before[$i.'_'.$j.'_1'].'<br>';
                              if(!StringUtil::isNullOrEmpty($temp_before[$i.'_'.$j.'_2']))
                                $upd_item_before .= $temp_before[$i.'_'.$j.'_2'].'<br>';
                              if(!StringUtil::isNullOrEmpty($temp_after[$i.'_'.$j.'_1']))
                                $upd_item_after .= $temp_after[$i.'_'.$j.'_1'].'<br>';
                              if(!StringUtil::isNullOrEmpty($temp_after[$i.'_'.$j.'_2']))
                                $upd_item_after .= $temp_after[$i.'_'.$j.'_2'].'<br>';
                           }
                        }elseif($i==3 || $i==6 || $i==8 || $i== 10){
                            for ($j=1,$count2=count($temp); $j <= $max; $j++) {
                              $upd_item_before .= $temp_before[$i.'_'.$j].'<br>';
                              $upd_item_after  .= $temp_after[$i.'_'.$j].'<br>';
                            }
                        }elseif($i==4){
                            for ($j=1; $j <= $max; $j++) {
                              $upd_item_before .= $temp_before[$i.'_'.$j].'<br>';
                              $upd_item_after .= $temp_after[$i.'_'.$j].'<br>';
                            }
                        }elseif($i==6){
                            for ($j=1; $j <= $max; $j++) {
                              $upd_item_before .= $temp_before[$i.'_'.$j].'<br>';
                              $upd_item_after .= $temp_after[$i.'_'.$j].'<br>';
                            }
                        }elseif($i==11){
                            $upd_item_before = $viewState->get('upd_item_before'.$i)[$i];
                            if(is_numeric($upd_item_before))
                              $upd_item_before = number_format($upd_item_before).'円';
                            $upd_item_after = $viewState->get('upd_item_after'.$i)[$i];
                            if(is_numeric($upd_item_after))
                              $upd_item_after = number_format($upd_item_after).'円';
                        }elseif($i == 12){
                          for ($j=1; $j <= 10; $j++) { 
                            if(!StringUtil::isNullOrEmpty($temp_before[$i.'_'.$j.'_1']))
                              $upd_item_before .= $temp_before[$i.'_'.$j.'_1'].'<br>';

                            if(!StringUtil::isNullOrEmpty($temp_before[$i.'_'.$j.'_2']))
                              $upd_item_before .= $temp_before[$i.'_'.$j.'_2'].'<br>';

                            if(!StringUtil::isNullOrEmpty($temp_before[$i.'_'.$j.'_2']))
                              $upd_item_before .= $temp_before[$i.'_'.$j.'_3'].'<br>';

                            if(!StringUtil::isNullOrEmpty($temp_after[$i.'_'.$j.'_1']))
                              $upd_item_after .= $temp_after[$i.'_'.$j.'_1'].'<br>';

                            if(!StringUtil::isNullOrEmpty($temp_after[$i.'_'.$j.'_2']))
                              $upd_item_after .= $temp_after[$i.'_'.$j.'_2'].'<br>';

                            if(!StringUtil::isNullOrEmpty($temp_after[$i.'_'.$j.'_2']))
                              $upd_item_after .= $temp_after[$i.'_'.$j.'_3'].'<br>';
                          }
                        }
                      ?> 
                      <tr>
                          <th><?=AppConfig::$HISTORY_CHANGE[$i]?></th>
                          <td><?=$upd_item_before?></td>
                          <td>
                            <?php if($viewState->get('upd_sts'.$i) == 1 ){ ?>
                            <span class='font_red': "" ?>
                              <?=$upd_item_after?>
                            </span>
                            <?php }else{ echo "変更なし";}?>
                          </td>
                      </tr>
                    <?php } ?>

                    <tr>
                       <td class="text_center" colspan="4"><input type="button" onclick="window.close();" value="閉じる"></td>
                    </tr>
                 </tbody>
                </table>
                <?php include_once('approve_status_sup.php') ?>
                <?php include_once('staffsendmail.php') ?>
            </div>
         </form>
        </div>
        <!-- End .box -->
        </div>
        <!-- End .span12 -->
        </div>
        <!-- End .row-fluid -->
        <!-- Page end here -->
   </div>
   <!-- End contentwrapper -->
</div>
<script type="text/javascript">
    function updateApproveStatus(prj_id,sort_id,type,approve,confirm_msg){
        var c = confirm(confirm_msg);
        if(c){
            $.ajax({
                url:"<?=$urlUpdateApprove?>",
                type:"post",
                data:{prj_id:prj_id, 
                      sort_id:sort_id, 
                      type:type,
                      approve:approve
                  },
                dataType:'json',
                success: function(result){
                    if(result == 1 || result == 0)
                        location.reload();
                }
            });
        }
    }

    function updateAppoveStatusSendMail(staff_id,prj_id,updated_time,status,confirm_msg){
        var c = confirm(confirm_msg);
        if(c){
            $.ajax({
                url:"<?=$urlUpdateApproveEmail?>",
                type:"post",
                data:{
                      staff_id:staff_id, 
                      prj_id:prj_id, 
                      updated_time:updated_time,
                      status:status
                },
                dataType:'json',
                success: function(result){
                    if(result == 1 || result == 0)
                        location.reload();
                }
            });
        }
    }
</script>