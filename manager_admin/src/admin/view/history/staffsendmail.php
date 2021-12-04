<?php 
    $count  = count($dataApprove);
    $row    = ceil($count/6);
?>
<table id="td_width2" class="input_form_table">
 <tbody>
    <tr>
       <th class="cap" colspan="6"> 承認状況</th>
    </tr>
    <?php 
        for($r = 0; $r < $row; $r++){ 
            $star = $r*6;
            $max = $star + 6;
        ?>
        <tr>
           <?php
                for($i=$star; $i<$max ; $i++){
                    if(!StringUtil::isNullOrEmpty($dataApprove[$i]['staff_name'])){
                        echo '<th>'.$dataApprove[$i]['staff_name'].'('.AppConfig::$STAFF_DEPARTMENT_ID[$dataApprove[$i]['staff_department_id']] .')</th>';
                    }
                    else{
                        echo '<th></th>';
                    }
                }
           ?>
        </tr>
        <tr>
            <?php  for($i=$star; $i<$max ; $i++){ 
                    if(!StringUtil::isNullOrEmpty($dataApprove[$i]['staff_name'])){
                        $disable = $userInfo['staff_id'] == $dataApprove[$i]['staff_id'] ? false : true;
                        if($dataApprove[$i]['approve_sts'] != 1){
                        ?>
                        <td>
                            <input 
                                type="button" 
                                onclick="updateAppoveStatusSendMail(
                                '<?=$dataApprove[$i]['staff_id']?>', 
                                '<?=$viewState->get('prj_id')?>', 
                                '<?=$dataApprove[$i]['updated_time']?>', 
                                '<?=$dataApprove[$i]['approve_sts']?>',
                                '承認してもよろしいですか？')" 
                                value="承認する"
                                <?= $disable ? ' disabled': '' ?>
                                >
                        </td>
                        <?php }else{ ?>
                        <td> 
                            <span class="shonin"><?=DateUtil::dateFormat($dataApprove[$i]['approve_date'],'Y-m-d H:i:s','Y-m-d') ?>承認済（<?=$dataApprove[$i]['staff_name']?>）</span><br>
                            <input 
                                type="button" 
                                onclick="updateAppoveStatusSendMail(
                                '<?=$dataApprove[$i]['staff_id']?>', 
                                '<?=$viewState->get('prj_id')?>', 
                                '<?=$dataApprove[$i]['updated_time']?>', 
                                '<?=$dataApprove[$i]['approve_sts']?>',
                                '承認を取り消してもよろしいですか？')" 
                                value="承認取消"
                                <?= $disable ? ' disabled': '' ?>
                                >
                        </td>
                        <?php } ?>
                    <?php }else{
                            echo '<td></td>';
                        } ?>
            <?php }  ?>
        </tr>
    <?php } ?>
 </tbody>
</table>