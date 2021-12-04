<?php
/**
*
*/
require_once ROOT_PATH_COMMON . "/MessageConstants.php";
require_once ROOT_PATH_DAO . "/MPrjPaymentInfoDao.php";


class PaymentreportAction extends BaseReportAction {    
    protected function options() {
        return array(
            'sheet-size' => 'A4-L'
        );
    }

	public function validate() {
		$validateOpts = array(
            
        );
        $this->validate->validates($validateOpts);
        return array(
            "result" => !$this->validate->hasError()
            , "errors" => $this->validate->getErrors()
        );
	}

	public function process() {
		$prj_id = ParamsUtil::getQueryParam("prj_id");
        $sort_id = ParamsUtil::getQueryParam("sordid");
        $paymentinfo = new MPrjPaymentInfoDao();
        $paymentinfo = $paymentinfo->getByPrjIdAndSorId($prj_id,$sort_id) ;
        $reportData = array();
        $prjcustname = $reportData['prj_cust_name'] = $paymentinfo['prj_cust_name'];
        $reportData['brand'] = $sort_id == 6 ? "［$prjcustname 様邸］ 工事負担金立替分" : "［$prjcustname 様邸］ 第$sort_id"."回 請求分";
        $reportData['sort_id'] = $paymentinfo['sort_id'];
        $reportData['prj_plan_pay_day'] = $paymentinfo['prj_plan_pay_day'];
        $reportData['prj_plan_pay_amount'] = (int)$paymentinfo['prj_plan_pay_amount'];
        $reportData['tax'] = (int)($paymentinfo['prj_plan_pay_amount'] * 8 / 100);
        $reportData['sum'] = $reportData['prj_plan_pay_amount'] + $reportData['tax'];
        $reportData['prj_billing_date'] = $paymentinfo['prj_billing_date'];
        $reportData['adress'] = AppConfig::$PREFECTURE[$paymentinfo['prj_cust_prefectures']] . $paymentinfo['prj_cust_city'] . $paymentinfo['prj_cust_address'] . ' ' . $paymentinfo['prj_cust_mansion_info'];
        $reportData['prj_cust_pos_code'] = $paymentinfo['prj_cust_pos_code'];
        $this->setAttribute("reportData", $reportData);
	}
    
}
?>