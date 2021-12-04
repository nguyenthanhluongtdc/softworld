<table class="scroll_table">
<tbody>
   <tr>
      <th style="width:80px">変更者名</th>
      <th style="width:80px">変更日</th>
      <th >変更箇所</th>
      <th style="width:150px">承認者名</th>
   </tr>
   <?php for($i=0,$count=count($dataTable3);$i<$count;$i++){ 
      $changes = ArrayUtil::StringToArray($dataTable3[$i]['changes']);
      $inchange_name = "";
      if(!StringUtil::isNullOrEmpty($dataTable3[$i]['staff_in_charge']) && ! StringUtil::isNullOrEmpty($dataTable3[$i]['supervisor_name']))
      {
         $inchange_name = $dataTable3[$i]['staff_in_charge'].'、'.$dataTable3[$i]['supervisor_name'];
      }
      elseif(!StringUtil::isNullOrEmpty($dataTable3[$i]['staff_in_charge'])){
         $inchange_name = $dataTable3[$i]['staff_in_charge'];
      }
   ?>
   <tr>
      <td><?=$dataTable3[$i]['update_user']?></td>
      <td><?=DateUtil::dateFormat($dataTable3[$i]['updated_time'],'Y-m-d H:i:s', 'Y-m-d')?></td>
      <td>
         <a target="_bank" style="background:none;color:#3399cc;font-weight:initial;white-space:normal;" href="<?=UrlUtil::url($urlHistory, array("prj_id"=>$dataTable3[$i]['prj_id'],'id'=>$dataTable3[$i]['id']))?>">
            <?php for ($j=0,$count2 = count($changes);$j < $count2; $j++) {
               if($j < $count2-1)
                  echo AppConfig::$HISTORY_CHANGE[$changes[$j]].'、';
               else
                  echo AppConfig::$HISTORY_CHANGE[$changes[$j]];
            } ?>
         </a>
      </td>
      <td><?= $inchange_name ?></td>
   </tr>
   <?php } ?>
</tbody>
</table>