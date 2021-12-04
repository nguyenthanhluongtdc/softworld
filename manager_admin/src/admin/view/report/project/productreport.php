<style type="text/css">
    .tdfirst{
        border: 1px solid black;
    }
    .normalheight
    {
        height:30px !important;
    }
    .common-list
    {
        font-size:12px;
    }
</style>
<div lang="ja" class="header">
    <h3>個別管理表</h3>
</div>
<table lang="ja" class="common-list" width="100%" style=" border: 1px solid black;border-collapse: collapse;text-align: center;" id="mainTable">
    <tr class="common-list-value normalheight">
        <td style="border: 1px solid black;width:30%;" nowrap class="common-list-title normalheight">
        お客様氏名 
        </td>
        <td style="border: 1px solid black;width:30%" nowrap class="common-list-title">
        <?= $reportData['valuenumber_1'] ?> <!--number 1-->
        </td>
        <td style="border: 1px solid black;" nowrap class="common-list-title">
        契約日
        </td>
        <td style="border: 1px solid black;width:30%;" colspan="3" nowrap class="common-list-title">
        <?= $reportData['valuenumber_2'] ?> <!--number 2-->
        </td>
    </tr>
    <tr class="common-list-value">
        <td style="border: 1px solid black;width:30%" nowrap class="common-list-title normalheight">
        住所
        </td>
        <td style="border: 1px solid black;width:30%;text-align:left;" nowrap class="common-list-title">
        〒<?= $reportData['valuenumber_3_1'] ?><!--number 3-->
        <br>
        <?= $reportData['valuenumber_3_2'] ?>
        </td>
        <td style="border: 1px solid black;" nowrap class="common-list-title">
        現調日
        </td>
        <td style="border: 1px solid black;width:30%;" colspan="3" nowrap class="common-list-title">
        <?= $reportData['valuenumber_4'] ?> <!--number 4-->
        </td>
    </tr>
    <tr class="common-list-value">
        <td style="border: 1px solid black;width:30%" nowrap class="common-list-title normalheight">
        担当営業
        </td>
        <td style="border: 1px solid black;width:30%" nowrap class="common-list-title">
        <?= $reportData['valuenumber_5'] ?><!--number 5-->
        </td>
        <td style="border: 1px solid black;" nowrap class="common-list-title">
        契約A
        </td>
        <td style="border: 1px solid black;width:30%;" colspan="3" nowrap class="common-list-title">
        <?= $reportData['valuenumber_6'] ?><!--number 6-->
        </td>
    </tr>
    <tr class="common-list-value">
        <td rowspan="2" colspan="1" style="border: 1px solid black;width:30%" nowrap class="common-list-title normalheight">
        TEL
        </td>
        <td rowspan="2" colspan="1" style="border: 1px solid black;width:30%" nowrap class="common-list-title">
        <?= $reportData['valuenumber_7'] ?>        <!--number 7-->
        </td>
        <td rowspan="2" colspan="1" style="border: 1px solid black;" nowrap class="common-list-title">
        
        </td>
        <td colspan="1" style="border: 1px solid black;width:10%" nowrap class="common-list-title">
        PV
        </td>
        <td colspan="1" style="border: 1px solid black;width:10%" nowrap class="common-list-title">
        TD
        </td>
        <td colspan="1" style="border: 1px solid black;width:10%" nowrap class="common-list-title">
        OD
        </td>
    </tr>
    <tr class="common-list-value">
        
        <td colspan="1" style="border: 1px solid black;width:10%" nowrap class="common-list-title normalheight normalheight">
        <?= $reportData['valuenumber_8'] ?><!--number 8-->
        </td>
        <td colspan="1" style="border: 1px solid black;width:10%" nowrap class="common-list-title">
        <?= $reportData['valuenumber_9'] ?><!--number 9-->
        </td>
        <td colspan="1" style="border: 1px solid black;width:10%" nowrap class="common-list-title">
        <?= $reportData['valuenumber_10'] ?><!--number 10-->
        </td>
    </tr>
    
   
</table>
<table lang="ja" class="common-list" width="100%" style=" border: 1px solid black;border-collapse: collapse;text-align: center;" id="mainTable">
    <tr class="common-list-value">
        <td style="border: 1px solid black;width:17.5%;border-top:0px solid black;" nowrap class="common-list-title normalheight">
        商品名
        </td>
        <td style="border: 1px solid black;width:17.5%;border-top:0px solid black;" nowrap class="common-list-title">
        メーカー
        </td>
        <td style="border: 1px solid black;width:25%;border-top:0px solid black;" nowrap class="common-list-title">
        型式
        </td>
        <td style="border: 1px solid black;width:10%;border-top:0px solid black;" nowrap class="common-list-title">
        個数
        </td>
        <td style="border: 1px solid black;width:30%;border-top:0px solid black;" nowrap class="common-list-title">
        備考
        </td>
    </tr>
    <tr class="common-list-value">
        <td style="border: 1px solid black;width:17.5%;border-top:0px solid black;" nowrap class="common-list-title">
        &nbsp;  
        <br>
        モジュール
        <br>
        &nbsp;  
        </td>
        <td style="border: 1px solid black;width:17.5%;border-top:0px solid black;" nowrap class="common-list-title">
        <?= HtmlUtil::AddSpaceStrPdf($reportData['valuenumber_11'][1]) ?><br><?= HtmlUtil::AddSpaceStrPdf($reportData['valuenumber_11'][2]) ?><br><?= HtmlUtil::AddSpaceStrPdf($reportData['valuenumber_11'][3]) ?>
        </td>
        <td style="border: 1px solid black;width:25%;border-top:0px solid black;" nowrap class="common-list-title">
        <?= HtmlUtil::AddSpaceStrPdf($reportData['valuenumber_12'][1]) ?><br><?= HtmlUtil::AddSpaceStrPdf($reportData['valuenumber_12'][2]) ?><br><?= HtmlUtil::AddSpaceStrPdf($reportData['valuenumber_12'][3]) ?><!--number 12-->
        </td>
        <td style="border: 1px solid black;width:10%;border-top:0px solid black;" nowrap class="common-list-title number">
        <?= HtmlUtil::AddSpaceStrPdf($reportData['valuenumber_13'][1]) ?><br><?= HtmlUtil::AddSpaceStrPdf($reportData['valuenumber_13'][2]) ?><br><?= HtmlUtil::AddSpaceStrPdf($reportData['valuenumber_13'][3]) ?><!--number 13-->
        </td>
        <td style="border: 1px solid black;width:30%;border-top:0px solid black;" nowrap class="common-list-title">
        <?= StringUtil::isNullOrEmpty($reportData['valuenumber_14']) ? '' : $reportData['valuenumber_14'] . ' KW' ?><!--number 14-->
        </td>
    </tr>
    <tr class="common-list-value">
        <td style="border: 1px solid black;width:17.5%;border-top:0px solid black;" nowrap class="common-list-title normalheight">
        架台 
        </td>
        <td style="border: 1px solid black;width:17.5%;border-top:0px solid black;" nowrap class="common-list-title">
        <?= $reportData['valuenumber_15'] ?><!--number 15-->
        </td>
        <td style="border: 1px solid black;width:25%;border-top:0px solid black;" nowrap class="common-list-title">
        <?= $reportData['valuenumber_16'] ?><!--number 16-->
        </td>
        <td style="border: 1px solid black;width:10%;border-top:0px solid black;" nowrap class="common-list-title">
        <?= $reportData['valuenumber_17'] ?><!--number 17-->
        </td>
        <td style="border: 1px solid black;width:30%;border-top:0px solid black;" nowrap class="common-list-title">
        <?= $reportData['valuenumber_18'] ?><!--number 18-->
        </td>
    </tr>
    <tr class="common-list-value">
        <td style="border: 1px solid black;width:17.5%;border-top:0px solid black;" nowrap class="common-list-title">
        &nbsp;  
        <br>
        パワコン  
        <br>
        &nbsp;  
        </td>
        <td style="border: 1px solid black;width:17.5%;border-top:0px solid black;" nowrap class="common-list-title">
        <?= HtmlUtil::AddSpaceStrPdf($reportData['valuenumber_19'][1]) ?><br><?= HtmlUtil::AddSpaceStrPdf($reportData['valuenumber_19'][2]) ?><br><?= HtmlUtil::AddSpaceStrPdf($reportData['valuenumber_19'][3]) ?><!--number 19-->
        </td>
        <td style="border: 1px solid black;width:25%;border-top:0px solid black;" nowrap class="common-list-title">
        <?= HtmlUtil::AddSpaceStrPdf($reportData['valuenumber_20'][1]) ?><br><?= HtmlUtil::AddSpaceStrPdf($reportData['valuenumber_20'][2]) ?><br><?= HtmlUtil::AddSpaceStrPdf($reportData['valuenumber_20'][3]) ?><!--number 20-->
        </td>
        <td style="border: 1px solid black;width:10%;border-top:0px solid black;" nowrap class="common-list-title">
        <?= HtmlUtil::AddSpaceStrPdf($reportData['valuenumber_21'][1]) ?><br><?= HtmlUtil::AddSpaceStrPdf($reportData['valuenumber_21'][2]) ?><br><?= HtmlUtil::AddSpaceStrPdf($reportData['valuenumber_21'][3]) ?><!--number 21-->
        </td>
        <td style="border: 1px solid black;width:30%;border-top:0px solid black;" nowrap class="common-list-title">
        <?= HtmlUtil::AddSpaceStrPdf($reportData['valuenumber_22'][1]) ?><br><?= HtmlUtil::AddSpaceStrPdf($reportData['valuenumber_22'][2]) ?><br><?= HtmlUtil::AddSpaceStrPdf($reportData['valuenumber_22'][3]) ?><!--number 22-->
        </td>
    </tr>
    <tr class="common-list-value">
        <td style="border: 1px solid black;width:17.5%;border-top:0px solid black;" nowrap class="common-list-title normalheight">
        &nbsp;  
        <br>
        接続箱/昇圧機  
        <br>
        &nbsp;  
        </td>
        <td style="border: 1px solid black;width:17.5%;border-top:0px solid black;" nowrap class="common-list-title">
        <?= HtmlUtil::AddSpaceStrPdf($reportData['valuenumber_23'][1]) ?><br><?= HtmlUtil::AddSpaceStrPdf($reportData['valuenumber_23'][2]) ?><br><?= HtmlUtil::AddSpaceStrPdf($reportData['valuenumber_23'][3]) ?><!--number 23-->
        </td>
        <td style="border: 1px solid black;width:25%;border-top:0px solid black;" nowrap class="common-list-title">
        <?= HtmlUtil::AddSpaceStrPdf($reportData['valuenumber_24'][1]) ?><br><?= HtmlUtil::AddSpaceStrPdf($reportData['valuenumber_24'][2]) ?><br><?= HtmlUtil::AddSpaceStrPdf($reportData['valuenumber_24'][3]) ?><!--number 24-->
        </td>
        <td style="border: 1px solid black;width:10%;border-top:0px solid black;" nowrap class="common-list-title">
        <?= HtmlUtil::AddSpaceStrPdf($reportData['valuenumber_25'][1]) ?><br><?= HtmlUtil::AddSpaceStrPdf($reportData['valuenumber_25'][2]) ?><br><?= HtmlUtil::AddSpaceStrPdf($reportData['valuenumber_25'][3]) ?><!--number 25-->
        </td>
        <td style="border: 1px solid black;width:30%;border-top:0px solid black;" nowrap class="common-list-title">
        <?= HtmlUtil::AddSpaceStrPdf($reportData['valuenumber_26'][1]) ?><br><?= HtmlUtil::AddSpaceStrPdf($reportData['valuenumber_26'][2]) ?><br><?= HtmlUtil::AddSpaceStrPdf($reportData['valuenumber_26'][3]) ?><!--number 26-->
        </td>
    </tr>
    <tr class="common-list-value">
        <td style="border: 1px solid black;width:17.5%;border-top:0px solid black;" nowrap class="common-list-title">
        モニター 
        </td>
        <td style="border: 1px solid black;width:17.5%;border-top:0px solid black;" nowrap class="common-list-title">
        <?= HtmlUtil::AddSpaceStrPdf($reportData['valuenumber_27'][1]) ?><br><?= HtmlUtil::AddSpaceStrPdf($reportData['valuenumber_27'][2]) ?><!--number 27-->
        </td>
        <td style="border: 1px solid black;width:25%;border-top:0px solid black;" nowrap class="common-list-title">
        <?= HtmlUtil::AddSpaceStrPdf($reportData['valuenumber_28'][1]) ?><br><?= HtmlUtil::AddSpaceStrPdf($reportData['valuenumber_28'][2]) ?><!--number 28-->
        </td>
        <td style="border: 1px solid black;width:10%;border-top:0px solid black;" nowrap class="common-list-title">
        <?= HtmlUtil::AddSpaceStrPdf($reportData['valuenumber_29'][1]) ?><br><?= HtmlUtil::AddSpaceStrPdf($reportData['valuenumber_29'][2]) ?><!--number 29-->
        </td>
        <td style="border: 1px solid black;width:30%;border-top:0px solid black;" nowrap class="common-list-title">
        <?= HtmlUtil::AddSpaceStrPdf($reportData['valuenumber_30'][1]) ?><br><?= HtmlUtil::AddSpaceStrPdf($reportData['valuenumber_30'][2]) ?><!--number 30-->
        </td>
    </tr>
    <tr class="common-list-value">
        <td style="border: 1px solid black;width:17.5%;border-top:0px solid black;" nowrap class="common-list-title normalheight">
        CT
        </td>
        <td style="border: 1px solid black;width:17.5%;border-top:0px solid black;" nowrap class="common-list-title">
        <?= $reportData['valuenumber_31'] ?><!--number 31-->
        </td>
        <td style="border: 1px solid black;width:25%;border-top:0px solid black;" nowrap class="common-list-title">
        <?= $reportData['valuenumber_32'] ?><!--number 32-->
        </td>
        <td style="border: 1px solid black;width:10%;border-top:0px solid black;" nowrap class="common-list-title">
        <?= $reportData['valuenumber_33'] ?><!--number 33-->
        </td>
        <td style="border: 1px solid black;width:30%;border-top:0px solid black;" nowrap class="common-list-title">
        <?= $reportData['valuenumber_34'] ?><!--number 34-->
        </td>
    </tr>
    <tr class="common-list-value">
        <td style="border: 1px solid black;width:17.5%;border-top:0px solid black;" nowrap class="common-list-title normalheight">
        エコキュート  
        </td>
        <td style="border: 1px solid black;width:17.5%;border-top:0px solid black;" nowrap class="common-list-title">
        <?= $reportData['valuenumber_35'] ?><!--number 35-->
        </td>
        <td style="border: 1px solid black;width:25%;border-top:0px solid black;" nowrap class="common-list-title">
        <?= $reportData['valuenumber_36'] ?><!--number 36-->
        </td>
        <td style="border: 1px solid black;width:10%;border-top:0px solid black;" nowrap class="common-list-title">
        <?= $reportData['valuenumber_37'] ?><!--number 37-->
        </td>
        <td style="border: 1px solid black;width:30%;border-top:0px solid black;" nowrap class="common-list-title">
        <?= $reportData['valuenumber_38'] ?><!--number 38-->
        </td>
    </tr>
    <tr class="common-list-value">
        <td style="border: 1px solid black;width:17.5%;border-top:0px solid black;" nowrap class="common-list-title normalheight">
        IH  
        </td>
        <td style="border: 1px solid black;width:17.5%;border-top:0px solid black;" nowrap class="common-list-title">
        <?= $reportData['valuenumber_39'] ?><!--number 39-->
        </td>
        <td style="border: 1px solid black;width:25%;border-top:0px solid black;" nowrap class="common-list-title">
        <?= $reportData['valuenumber_40'] ?><!--number 40-->
        </td>
        <td style="border: 1px solid black;width:10%;border-top:0px solid black;" nowrap class="common-list-title">
        <?= $reportData['valuenumber_41'] ?><!--number 41-->
        </td>
        <td style="border: 1px solid black;width:30%;border-top:0px solid black;" nowrap class="common-list-title">
        <?= $reportData['valuenumber_42'] ?><!--number 42-->
        </td>
    </tr>
    <tr class="common-list-value">
        <td style="border: 1px solid black;width:17.5%;border-top:0px solid black;" nowrap class="common-list-title normalheight">
        その他機器
        </td>
        <td style="border: 1px solid black;width:17.5%;border-top:0px solid black;" nowrap class="common-list-title">
        <?= $reportData['valuenumber_43'] ?><!--number 43-->
        </td>
        <td style="border: 1px solid black;width:25%;border-top:0px solid black;" nowrap class="common-list-title">
        <?= $reportData['valuenumber_44'] ?><!--number 44-->
        </td>
        <td style="border: 1px solid black;width:10%;border-top:0px solid black;" nowrap class="common-list-title">
        <?= $reportData['valuenumber_45'] ?><!--number 45-->
        </td>
        <td style="border: 1px solid black;width:30%;border-top:0px solid black;" nowrap class="common-list-title">
        <?= $reportData['valuenumber_46'] ?><!--number 46-->
        </td>
    </tr>
    <tr class="common-list-value">
        <td style="border: 1px solid black;width:17.5%;border-top:0px solid black;" nowrap class="common-list-title normalheight">
        &nbsp;
        </td>
        <td style="border: 1px solid black;width:17.5%;border-top:0px solid black;" nowrap class="common-list-title">
        &nbsp;
        </td>
        <td style="border: 1px solid black;width:25%;border-top:0px solid black;" nowrap class="common-list-title">
        &nbsp;
        </td>
        <td style="border: 1px solid black;width:10%;border-top:0px solid black;" nowrap class="common-list-title">
        &nbsp;
        </td>
        <td style="border: 1px solid black;width:30%;border-top:0px solid black;" nowrap class="common-list-title">
        &nbsp;
        </td>
    </tr>
    <tr class="common-list-value">
        <td style="border: 1px solid black;width:17.5%;border-top:0px solid black;" nowrap class="common-list-title normalheight">
        &nbsp;
        </td>
        <td style="border: 1px solid black;width:17.5%;border-top:0px solid black;" nowrap class="common-list-title">
        &nbsp;
        </td>
        <td style="border: 1px solid black;width:25%;border-top:0px solid black;" nowrap class="common-list-title">
        &nbsp;
        </td>
        <td style="border: 1px solid black;width:10%;border-top:0px solid black;" nowrap class="common-list-title">
        &nbsp;
        </td>
        <td style="border: 1px solid black;width:30%;border-top:0px solid black;" nowrap class="common-list-title">
        &nbsp;
        </td>
    </tr>
    <tr class="common-list-value">
        <td style="border: 1px solid black;width:17.5%;border-top:0px solid black;" nowrap class="common-list-title normalheight">
        &nbsp;
        </td>
        <td style="border: 1px solid black;width:17.5%;border-top:0px solid black;" nowrap class="common-list-title">
        &nbsp;
        </td>
        <td style="border: 1px solid black;width:25%;border-top:0px solid black;" nowrap class="common-list-title">
        &nbsp;
        </td>
        <td style="border: 1px solid black;width:10%;border-top:0px solid black;" nowrap class="common-list-title">
        &nbsp;
        </td>
        <td style="border: 1px solid black;width:30%;border-top:0px solid black;" nowrap class="common-list-title">
        &nbsp;
        </td>
    </tr>
    <tr class="common-list-value" style="text-align: left;" rowspan="2">
        <td colspan="5" style="text-align: left;font-size:13px;"  nowrap class="common-list-title">
        <b>確認事項</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>※持ち帰らずに現場で渡したものがあれば書いて下さい。</b>
        </td>
    </tr>
    <tr class="common-list-value" style="text-align: left;" rowspan="2">
        <td colspan="5" style="text-align:left;height:170px;vertical-align: text-top;" nowrap class="common-list-title">
        
        <?= nl2br($reportData['valuenumber_47']) ?><!--number 47-->
        <!--number 48-->
        </td>
    </tr>
    <tr class="common-list-value" style="text-align: left;">
        <td colspan="5" style="text-align:left;font-size:13px;" nowrap class="common-list-title">
        <b>特記事項</b>
        </td>
    </tr>    
    <tr class="common-list-value" style="text-align: left;">
        <td colspan="5" style="text-align:left;height:80px;vertical-align: text-top;" nowrap class="common-list-title">
        
        <?= nl2br($reportData['valuenumber_48']) ?>
        </td>
    </tr>
   
</table>
