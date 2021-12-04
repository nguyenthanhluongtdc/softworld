<table class="scroll_table">
   <tbody>
      <tr>
         <th>アップロード日</th>
         <th>アップロード者名</th>
         <th>ファイル名</th>
         <th>削除</th>
      </tr>
      <?php if(!ArrayUtil::isNullOrEmpty($dataTable2)){ 
         foreach ($dataTable2 as $value) {
      ?>
      <tr id="file<?=$value['id']?>">
         <td><?=DateUtil::dateFormat($value['prj_file_uploaded_date'],'Y-m-d H:i:s','Y-m-d');?></td>
         <td><?=$value['staff_name']?></td>
         <td><a style="background:none;color:#3399cc;font-weight:initial;" href="<?=UrlUtil::url($urlDownload, array("Id"=>$value["id"]))?>" target="_blank"><?=$value['prj_file_file_name']?></a></td>
         <td></td>
      </tr>
      <?php 
         } }
      ?>
   </tbody>
</table>