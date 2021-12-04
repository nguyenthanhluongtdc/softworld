<table>
   <tbody>
      <tr>
         <th colspan="2" class="cap">ステータス変更履歴</th>
      </tr>
      <?php if(!ArrayUtil::isNullOrEmpty($lProjectStatusHistory)){?>
         <?php foreach ($lProjectStatusHistory as $value) { ?>
         <tr>
            <th><?= DateUtil::dateFormat($value['prj_status_updated_date'], 'Y-m-d H:i:s', $format = 'Y-m-d');?></th>
            <td><?= AppConfig::$PROJECT_STATUS[$value['prj_status']];?></td>
         </tr>
         <?php
         }
      }
      ?>
   </tbody>
</table>