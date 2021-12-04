<style>
.rp-table
{
    /*border:2px solid black;*/
	border-collapse: collapse;
    font-size:12px;
}
.rp-table-sub,.rp-table-sub tr,.rp-table-sub td
{
    border: 1px solid black;
    border-collapse: collapse;   
}
.align-right 
{
    text-align: right;
}
.align-center
{
	text-align:center;
}
.align-left
{
	text-align:left;
}
.border-full
{
    border:1px solid black;
	
}
h1 
{
	font-weight:500;
}
.common-list-title 
{
    color: white;
    background-color: #8E8B8B;
    text-align: center;
    border: 1px solid black;
}
</style>


<table style=" width:100%;" lang="ja" class="rp-table">
    <tr>
        <td colspan="5" class="align-center" style="border-bottom:5px double black;" >
			<span style="font-size:23px">請  求  書</span>
		</td>
        <td> &nbsp; </td>
        <td colspan="3" style="text-align: center;">
            <table>
                <tr>
                    <td style="font-weight:bold">聖陽株式会社</td>
                </tr>
                <tr>
                    <td>〒374-0123 群馬県邑楽郡板倉町飯野2360</td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="6"></td>
        <td colspan="3" class="align-center">請求日：<?= DateUtil::convGtJDate(DateUtil::dateFormat($reportData['prj_billing_date'],'Y-m-d' , "Y/m/d")) ?></td>
    </tr>
    <tr>
        <td style="text-align: right;">〒</td>
        <td colspan="2"><?= $reportData['prj_cust_pos_code'] ?></td>
        <td colspan="6"></td>
    </tr>
    <tr>
        <td style="width:10%"></td>
        <td style="width:40%;" colspan="4"><?= $reportData['adress'] ?></td>
        <td style="text-align: right;width:50px;">振込先</td>
        <td style="width:110px;" class="border-full align-center">銀行名</td>
        <td style="width:140px;" colspan="2" class="border-full align-center" ><?= AppConfig::$PAY['銀行名'] ?></td>
    </tr>
    <tr>
        <td></td>
        <td colspan="3" style="text-align: center;"><?= $reportData['prj_cust_name'] ?></td>
        <td style="text-align: left;">様</td>
        <td></td>
        <td style="text-align: center;" class="border-full align-center">支店</td>
        <td class="border-full align-center" colspan="2"><?= AppConfig::$PAY['支店'] ?></td>
    </tr>
    <tr>
        <td colspan="6"></td>
        <td class="border-full align-center">科目</td>
        <td class="border-full align-center" colspan="2"><?= AppConfig::$PAY['科目'] ?></td>
    </tr>
    <tr>
        <td colspan="6"></td>
        <td class="border-full align-center">口座番号</td>
        <td class="border-full align-center" colspan="2"><?= AppConfig::$PAY['口座番号'] ?></td>
    </tr>
    <tr>
        <td colspan="9" style="height:7px"></td>
    </tr>
    <tr>
        <td colspan="6"></td>
        <td class="border-full align-center " style="font-weight:bold" >ご請求金額</td>
        <td class="border-full align-center" colspan="2">¥<?= number_format($reportData['sum'],0,'.',',') ?></td>
    </tr>
    <tr>
        <td colspan="6"> ※下記の通りご請求いたします。 </td>
        <td colspan="3">振込手数料のご負担をお願い致します。</td>
    </tr>
    <tr>
        <td class="common-list-title" colspan="5">商 品 名</td>
        <td class="common-list-title">数量</td>
        <td class="common-list-title">単  価</td>
        <td class="common-list-title" colspan="2">金  額</td>
    </tr>
    <tr>
        <td class="common-list-value shohinmei border-full" style="" colspan="5"><?= $reportData['brand'] ?></td>
        <td class="common-list-value suryo align-right border-full">1</td>
        <td class="common-list-value tanatai align-center border-full"><?= number_format($reportData['prj_plan_pay_amount'],0,'.',',') ?></td>
        <td class="common-list-value kingaku align-center border-full" colspan="2"><?= number_format($reportData['prj_plan_pay_amount'],0,'.',',')?></td>
    </tr>
	<tr>
        <td class="common-list-value shohinmei border-full" style="" colspan="5">&nbsp;</td>
        <td class="common-list-value suryo align-right border-full"></td>
        <td class="common-list-value tanatai align-right border-full"></td>
        <td class="common-list-value kingaku align-center border-full" colspan="2"></td>
    </tr>
	<tr>
        <td class="common-list-value shohinmei border-full" style="" colspan="5">&nbsp;</td>
        <td class="common-list-value suryo align-right border-full"></td>
        <td class="common-list-value tanatai align-right border-full"></td>
        <td class="common-list-value kingaku align-center border-full" colspan="2"></td>
    </tr>
	<tr>
        <td class="common-list-value shohinmei border-full" style="" colspan="5">&nbsp;</td>
        <td class="common-list-value suryo align-right border-full"></td>
        <td class="common-list-value tanatai align-right border-full"></td>
        <td class="common-list-value kingaku align-center border-full" colspan="2"></td>
    </tr>
	<tr>
        <td class="common-list-value shohinmei border-full" style="" colspan="5">&nbsp;</td>
        <td class="common-list-value suryo align-right border-full"></td>
        <td class="common-list-value tanatai align-right border-full"></td>
        <td class="common-list-value kingaku align-center border-full" colspan="2"></td>
    </tr>
	<tr>
        <td class="common-list-value shohinmei border-full" style="" colspan="5">&nbsp;</td>
        <td class="common-list-value suryo align-right border-full"></td>
        <td class="common-list-value tanatai align-right border-full"></td>
        <td class="common-list-value kingaku align-center border-full" colspan="2"></td>
    </tr>
	<tr>
        <td class="common-list-value shohinmei border-full" style="" colspan="5">&nbsp;</td>
        <td class="common-list-value suryo align-right border-full"></td>
        <td class="common-list-value tanatai align-right border-full"></td>
        <td class="common-list-value kingaku align-center border-full" colspan="2"></td>
    </tr>
	<tr>
        <td class="common-list-value shohinmei border-full" style="" colspan="5">&nbsp;</td>
        <td class="common-list-value suryo align-right border-full"></td>
        <td class="common-list-value tanatai align-right border-full"></td>
        <td class="common-list-value kingaku align-center border-full" colspan="2"></td>
    </tr>
    <tr>
        <td class="common-list-value shohinmei border-full" style="" colspan="5">&nbsp;</td>
        <td class="common-list-value suryo align-right border-full"></td>
        <td class="common-list-value tanatai align-right border-full"></td>
        <td class="common-list-value kingaku align-center border-full" colspan="2"></td>
    </tr>
    <tr>
        <td class="common-list-value shohinmei border-full" style="" colspan="5">&nbsp;</td>
        <td class="common-list-value suryo align-right border-full"></td>
        <td class="common-list-value tanatai align-right border-full"></td>
        <td class="common-list-value kingaku align-center border-full" colspan="2"></td>
    </tr>
    <tr>
        <td class="common-list-value shohinmei border-full" style="" colspan="5">&nbsp;</td>
        <td class="common-list-value suryo align-right border-full"></td>
        <td class="common-list-value tanatai align-right border-full"></td>
        <td class="common-list-value kingaku align-center border-full" colspan="2"></td>
    </tr>
    <tr>
        <td class="common-list-value shohinmei border-full" style="" colspan="5">&nbsp;</td>
        <td class="common-list-value suryo align-right border-full"></td>
        <td class="common-list-value tanatai align-right border-full"></td>
        <td class="common-list-value kingaku align-center border-full" colspan="2"></td>
    </tr>
    <tr>
        <td class="common-list-value shohinmei border-full" style="" colspan="5">&nbsp;</td>
        <td class="common-list-value suryo align-right border-full"></td>
        <td class="common-list-value tanatai align-right border-full"></td>
        <td class="common-list-value kingaku align-center border-full" colspan="2"></td>
    </tr>
    <tr>
        <td class="common-list-value shohinmei border-full" style="" colspan="5">&nbsp;</td>
        <td class="common-list-value suryo align-right border-full"></td>
        <td class="common-list-value tanatai align-right border-full"></td>
        <td class="common-list-value kingaku align-center border-full" colspan="2"></td>
    </tr>
    <tr>
        <td class="common-list-value shohinmei border-full" style="" colspan="5">&nbsp;</td>
        <td class="common-list-value suryo align-right border-full"></td>
        <td class="common-list-value tanatai align-right border-full"></td>
        <td class="common-list-value kingaku align-center border-full" colspan="2"></td>
    </tr>
    <tr>
        <td class="common-list-value shohinmei border-full" style="" colspan="5">&nbsp;</td>
        <td class="common-list-value suryo align-right border-full"></td>
        <td class="common-list-value tanatai align-right border-full"></td>
        <td class="common-list-value kingaku align-center border-full" colspan="2"></td>
    </tr>
    <tr>
        <td class="common-list-value shohinmei border-full" style="" colspan="5">&nbsp;</td>
        <td class="common-list-value suryo align-right border-full"></td>
        <td class="common-list-value tanatai align-right border-full"></td>
        <td class="common-list-value kingaku align-center border-full" colspan="2"></td>
    </tr>
    <tr>
        <td class="common-list-value shohinmei border-full" style="" colspan="5">&nbsp;</td>
        <td class="common-list-value suryo align-right border-full"></td>
        <td class="common-list-value tanatai align-right border-full"></td>
        <td class="common-list-value kingaku align-center border-full" colspan="2"></td>
    </tr>
    <tr>
        <td class="common-list-value shohinmei border-full" style="" colspan="5">&nbsp;</td>
        <td class="common-list-value suryo align-right border-full"></td>
        <td class="common-list-value tanatai align-right border-full"></td>
        <td class="common-list-value kingaku align-center border-full" colspan="2"></td>
    </tr>
    <tr>
        <td class="common-list-value shohinmei border-full" style="" colspan="5">&nbsp;</td>
        <td class="common-list-value suryo align-right border-full"></td>
        <td class="common-list-value tanatai align-right border-full"></td>
        <td class="common-list-value kingaku align-center border-full" colspan="2"></td>
    </tr>
    <tr>
        <td class="common-list-value shohinmei border-full" style="" colspan="5">&nbsp;</td>
        <td class="common-list-value suryo align-right border-full"></td>
        <td class="common-list-value tanatai align-right border-full"></td>
        <td class="common-list-value kingaku align-center border-full" colspan="2"></td>
    </tr>
    <tr>
        <td class="common-list-value shohinmei border-full" style="" colspan="5">&nbsp;</td>
        <td class="common-list-value suryo align-right border-full"></td>
        <td class="common-list-value tanatai align-right border-full"></td>
        <td class="common-list-value kingaku align-center border-full" colspan="2"></td>
    </tr>
    <tr>
        <td class="common-list-value shohinmei border-full" style="" colspan="5">&nbsp;</td>
        <td class="common-list-value suryo align-right border-full"></td>
        <td class="common-list-value tanatai align-right border-full"></td>
        <td class="common-list-value kingaku align-center border-full" colspan="2"></td>
    </tr>
    <tr>
        <td class="common-list-value shohinmei border-full" style="" colspan="5">&nbsp;</td>
        <td class="common-list-value suryo align-right border-full"></td>
        <td class="common-list-value tanatai align-right border-full"></td>
        <td class="common-list-value kingaku align-center border-full" colspan="2"></td>
    </tr>
    <tr>
        <td class="common-list-value shohinmei border-full" style="" colspan="5">&nbsp;</td>
        <td class="common-list-value suryo align-right border-full"></td>
        <td class="common-list-value tanatai align-right border-full"></td>
        <td class="common-list-value kingaku align-center border-full" colspan="2"></td>
    </tr>
    <tr>
        <td class="common-list-value shohinmei border-full" style="" colspan="5">&nbsp;</td>
        <td class="common-list-value suryo align-right border-full"></td>
        <td class="common-list-value tanatai align-right border-full"></td>
        <td class="common-list-value kingaku align-center border-full" colspan="2"></td>
    </tr>
    <tr>
        <td class="common-list-value shohinmei border-full" style="" colspan="5">&nbsp;</td>
        <td class="common-list-value suryo align-right border-full"></td>
        <td class="common-list-value tanatai align-right border-full"></td>
        <td class="common-list-value kingaku align-center border-full" colspan="2"></td>
    </tr>
    <tr>
        <td class="common-list-value shohinmei border-full" style="" colspan="5">&nbsp;</td>
        <td class="common-list-value suryo align-right border-full"></td>
        <td class="common-list-value tanatai align-right border-full"></td>
        <td class="common-list-value kingaku align-center border-full" colspan="2"></td>
    </tr>
    <tr>
        <td class="common-list-value shohinmei border-full" style="" colspan="5">&nbsp;</td>
        <td class="common-list-value suryo align-right border-full"></td>
        <td class="common-list-value tanatai align-right border-full"></td>
        <td class="common-list-value kingaku align-center border-full" colspan="2"></td>
    </tr>
    <tr>
        <td class="common-list-value shohinmei border-full" style="" colspan="5">&nbsp;</td>
        <td class="common-list-value suryo align-right border-full"></td>
        <td class="common-list-value tanatai align-right border-full"></td>
        <td class="common-list-value kingaku align-center border-full" colspan="2"></td>
    </tr>
    <tr>
        <td class="common-list-value shohinmei border-full" style="" colspan="5">&nbsp;</td>
        <td class="common-list-value suryo align-right border-full"></td>
        <td class="common-list-value tanatai align-right border-full"></td>
        <td class="common-list-value kingaku align-center border-full" colspan="2"></td>
    </tr>
    <tr>
        <td class="common-list-value shohinmei border-full" style="" colspan="5">&nbsp;</td>
        <td class="common-list-value suryo align-right border-full"></td>
        <td class="common-list-value tanatai align-right border-full"></td>
        <td class="common-list-value kingaku align-center border-full" colspan="2"></td>
    </tr>
    <tr>
        <td class="common-list-value shohinmei border-full" style="" colspan="5">&nbsp;</td>
        <td class="common-list-value suryo align-right border-full"></td>
        <td class="common-list-value tanatai align-right border-full"></td>
        <td class="common-list-value kingaku align-center border-full" colspan="2"></td>
    </tr>
    <tr>
        <td class="common-list-value shohinmei border-full" style="" colspan="5">&nbsp;</td>
        <td class="common-list-value suryo align-right border-full"></td>
        <td class="common-list-value tanatai align-right border-full"></td>
        <td class="common-list-value kingaku align-center border-full" colspan="2"></td>
    </tr>
    <tr>
        <td class="common-list-value shohinmei border-full" style="" colspan="5">&nbsp;</td>
        <td class="common-list-value suryo align-right border-full"></td>
        <td class="common-list-value tanatai align-right border-full"></td>
        <td class="common-list-value kingaku align-center border-full" colspan="2"></td>
    </tr>
    <tr>
        <td style="vertical-align: top;" class="" colspan="5" rowspan="5">
			 <table>
                <tr>
                    <td></td> 
                    <td> ※<?= $reportData['prj_plan_pay_day'] ?>日以内のご入金をお願い申し上げます。</td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <table class="rp-table-sub"> 
							<tr> 
								<td class="align-center" style="font-weight: bold;">
									担当
								</td>
								<td class="align-center" style="font-weight: bold;">
                                    担当 
                                </td>
							</tr>
							<tr> 
								<td style="height: 100px;"> 
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								</td>
								<td style="height: 100px;"> 
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;   
								</td>
							</tr>
						</table>
                    </td>
                </tr>
            </table>
        </td>
        <td colspan="2" class="border-full align-center">小計</td>
        <td colspan="2" class="border-full align-center" ><?= number_format($reportData['prj_plan_pay_amount'],0,'.',',')?></td>
    </tr>
    <tr>
        <td colspan="2" class="border-full align-center">&nbsp;</td>
        <td colspan="2" class="border-full align-center" >&nbsp;</td>
    </tr> 
    <tr>
        <td colspan="2" class="border-full align-center">小計</td>
        <td colspan="2" class="border-full align-center" ><?= number_format($reportData['prj_plan_pay_amount'],0,'.',',')?></td>
    </tr>
    <tr>
        <td colspan="2" class="border-full align-center">消費税</td>
        <td colspan="2" class="border-full align-center" ><?= number_format($reportData['tax'],0,'.',',')?></td>
    </tr>
    <tr>
        <td colspan="2" class="border-full align-center common-list-title"  style="font-weight:bold">合           計</td>
        <td colspan="2" class="border-full align-center" style="font-weight:bold"><?= number_format($reportData['sum'],0,'.',',')  ?></td>
    </tr>
</table>