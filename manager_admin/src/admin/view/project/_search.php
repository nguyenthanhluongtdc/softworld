<table class="search_form_table">
   <tbody>
      <tr>
         <th>
            お客様氏名
         </th>
         <td>
            <input type="text" id="prj_cust_name" name="prj_cust_name" value="<?=$viewState->get("prj_cust_name")?>">
         </td>
      </tr>
      <tr>
         <th>
            お客様住所
         </th>
         <td>
            <?= HtmlUtil::dropList('prj_cust_prefectures', AppConfig::$PREFECTURE, $viewState->get("prj_cust_prefectures")) ?>
            <input type="text" name="prj_cust_address" id="prj_cust_address" value="<?=$viewState->get("prj_cust_address")?>">
         </td>
      </tr>
      <tr>
         <th>
            お客様電話番号
         </th>
         <td><input type="text" name="prj_cust_phone_num" id="prj_cust_phone_num" value="<?=$viewState->get("prj_cust_phone_num")?>"></td>
      </tr>
      <tr>
         <th>
            担当社員ID
         </th>
         <td><input type="text" name="prj_staff_id" id="prj_staff_id" value="<?=$viewState->get("prj_staff_id")?>"></td>
      </tr>
      <tr>
         <th>
            担当社員名
         </th>
         <td><input type="text" name="prj_staff_name" id="prj_staff_name" value="<?=$viewState->get("prj_staff_name")?>"></td>
      </tr>
      <tr>
         <th>
            契約日
         </th>
         <td>
            <?= HtmlUtil::CalendarInput('prj_keiyaku_bi_from',$viewState->get("prj_keiyaku_bi_from"));?>
            ～
            <?= HtmlUtil::CalendarInput('prj_keiyaku_bi_to',$viewState->get("prj_keiyaku_bi_to"));?>
            <span id="show-err-keiyaku-from"></span>
            <span id="show-err-keiyaku-to"></span>
         </td>
      </tr>
      <tr>
         <th>
            現調日
         </th>
         <td>
            <?= HtmlUtil::CalendarInput('prj_gencho_bi_from',$viewState->get("prj_gencho_bi_from"));?>
            ～
            <?= HtmlUtil::CalendarInput('prj_gencho_bi_to',$viewState->get("prj_gencho_bi_to"));?>
            <span id="show-err-gencho-from"></span>
            <span id="show-err-gencho-to"></span>
         </td>
      </tr>
      <tr>
         <th>
            完工日
         </th>
         <td>
            <?= HtmlUtil::CalendarInput('prj_kanko_bi_from',$viewState->get("prj_kanko_bi_from"));?>
            ～
            <?= HtmlUtil::CalendarInput('prj_kanko_bi_to',$viewState->get("prj_kanko_bi_to"));?>
            <span id="show-err-kanko-from"></span>
            <span id="show-err-kanko-to"></span>
         </td>
      </tr>
      <tr>
         <th>
            連系日
         </th>
         <td>
            <?= HtmlUtil::CalendarInput('prj_renkei_bi_from',$viewState->get("prj_renkei_bi_from"));?>
            ～
            <?= HtmlUtil::CalendarInput('prj_renkei_bi_to',$viewState->get("prj_renkei_bi_to"));?>
            <span id="show-err-renkei-from"></span>
            <span id="show-err-renkei-to"></span>
         </td>
      </tr>
      <tr>
         <th>
            ステータス
         </th>
         <td>
            <?= HtmlUtil::checkBoxs('prj_status[]', AppConfig::$PROJECT_STATUS, $viewState->get("prj_status"))?>
         </td>
      </tr>
      <tr>
         <th>
            契約種別
         </th>
         <td>
            <?= HtmlUtil::checkBoxs('prj_kind_contract[]', AppConfig::$CONTRACT, $viewState->get('prj_kind_contract')) ?>
         </td>
      </tr>
      <tr>
         <th>
            メーカー
         </th>
         <td>
             <?= HtmlUtil::checkBoxs('prj_maker[]', AppConfig::$MAKER, $viewState->get("prj_maker"))?>
         </td>
      </tr>
      <tr>
         <td colspan="2" class="text_center"><input type="submit" value="検索"></td>
      </tr>
   </tbody>
</table>