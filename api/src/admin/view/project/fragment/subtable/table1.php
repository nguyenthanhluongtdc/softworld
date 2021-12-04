<table class="scroll_table">
   <tbody>
      <tr>
         <th>アップロード日</th>
         <th>アップロード者名</th>
         <th>種別</th>
         <th>ファイル名</th>
         <th>削除</th>
      </tr>

      <?php if(!ArrayUtil::isNullOrEmpty($dataTable1)){ 
         foreach ($dataTable1 as $value) {
         ?>
         <tr id="file<?=$value['id']?>">
            <td><?=DateUtil::dateFormat($value['prj_file_uploaded_date'],'Y-m-d H:i:s','Y-m-d');?></td>
            <td><?=$value['staff_name']?></td>
            <td><?=AppConfig::$DOCS_TYPE[$value['prj_file_shubetsu']];?></td>
            <td><a style="background:none;color:#3399cc;font-weight:initial;" href="<?=UrlUtil::url($urlDownload, array("Id"=>$value["id"]))?>"><?=$value['prj_file_file_name']?></a></td>
            <td><input type="button" value="削除" onclick="deleteFile(<?=$value["id"]?>)"></td>
         </tr>
      <?php 
         } }
      ?>
   </tbody>
</table>
