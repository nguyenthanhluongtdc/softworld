<table id="td_width2" class="input_form_table">
 <tbody>
    <tr>
       <th class="cap" colspan="3">書類等処理</th>
    </tr>
    <tr>
       <th>処理内容</th>
       <th>担当者承認</th>
       <th>承認者承認</th>
    </tr>
    <?php for ($i=1,$count = count(AppConfig::$HISTORY_APPROVE); $i <= $count; $i++) { 
      $dateInchange = DateUtil::dateFormat($viewState->get("prj_pic_approve_date$i"),'Y-m-d H:i:s', 'Y-m-d');
      $dateSup      = DateUtil::dateFormat($viewState->get("prj_sup_approve_date$i"),'Y-m-d H:i:s', 'Y-m-d');
      $disableInchange = $viewState->get('approveInchange') ? '' : 'disabled';
      $disableSup      = $viewState->get('approveSup')      ? '' : 'disabled';
    ?>
    <tr>
        <th><?=AppConfig::$HISTORY_APPROVE[$i]?></th>
        <td>
            <?php if($viewState->get("prj_pic_approve_sts$i") != 1 
                    || StringUtil::isNullOrEmpty($viewState->get("prj_pic_approve_sts$i"))){ ?>
                <input  type="button" 
                        onclick="updateApproveStatus(
                        '<?=$viewState->get('prj_id')?>'
                        ,'<?=$i?>'
                        ,'1'
                        ,'<?=(int)$viewState->get("prj_pic_approve_sts$i")?>'
                        ,'承認してもよろしいですか？')" 
                        value="承認する"
                        <?=$disableInchange?>
                >
            <?php }elseif($viewState->get("prj_pic_approve_sts$i") == 1){ ?> 
                <span class="shonin"><?=$dateInchange;?>承認済（<?=$viewState->get("userNameApprove1$i")?>）</span><br>
                <input 
                  type="button" 
                  onclick="updateApproveStatus(
                  '<?=$viewState->get('prj_id')?>'
                  ,'<?=$i?>'
                  ,'1'
                  ,'<?=$viewState->get("prj_pic_approve_sts$i")?>'
                  ,'承認を取り消してもよろしいですか？')" 
                  value="承認取消"
                  <?=$disableInchange?>
                  >
            <?php } ?>
        </td>
        <td> 
            <?php if($viewState->get("prj_sup_approve_sts$i")!=1 
                    || StringUtil::isNullOrEmpty($viewState->get("prj_sup_approve_sts$i"))){ ?>
                <input 
                  type="button" 
                  onclick="updateApproveStatus(
                  '<?=$viewState->get('prj_id')?>'
                  ,'<?=$i?>'
                  ,'2'
                  ,'<?=(int)$viewState->get("prj_sup_approve_sts$i")?>'
                  ,'承認してもよろしいですか？')" 
                  value="承認する"
                  <?=$disableSup?>
                >
            <?php }elseif($viewState->get("prj_sup_approve_sts$i")==1){ ?> 
                <span class="shonin"><?=$dateSup;?>承認済（<?=$viewState->get("userNameApprove2$i")?>）</span><br>
                <input 
                  type="button" 
                  onclick="updateApproveStatus(
                  '<?=$viewState->get('prj_id')?>'
                  ,'<?=$i?>'
                  ,'2'
                  ,'<?=$viewState->get("prj_sup_approve_sts$i")?>'
                  ,'承認を取り消してもよろしいですか？')" 
                  value="承認取消"
                  <?=$disableSup?>
                >
            <?php } ?>
       </td>
    </tr>
    <?php } ?>
    <tr>
       <th>備考</th>
       <td colspan="3">
          <textarea  maxlength="5000" style="color:red;overflow:visible;width: 500px;text-decoration: underline" rows="10" cols="40" id="prj_shurui_appr_memo" name="prj_shurui_appr_memo"><?=$viewState->get('prj_shurui_appr_memo')?></textarea>                                    
       </td>
    </tr>
    <tr>
        <td class="text_center" colspan="3"><input class="button_submit_cancel" type="submit" value="データ更新"></td>
    </tr>
 </tbody>
</table>