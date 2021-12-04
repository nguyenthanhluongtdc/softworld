<?php

/**
 * */
require_once ROOT_PATH_DAO . "/MPrjPaymentInfoDao.php";

class PaymentAction extends BaseAction {

    public function rules() {
        return array(
            "search" => array("post", "get")
            , "regist" => array("post", "get")
            , "edit" => array("post", "get")
            , "delete" => "post"
        );
    }

    public function render() {
        // set url for screen
        $this->setAttribute("urlRegist", ActionUtil::getActionUrl(PageIdConstants::PAYMENT, "regist"));
        $this->setAttribute("urlSearch", ActionUtil::getActionUrl(PageIdConstants::PAYMENT, "search"));
        $this->setAttribute("urlEdit", ActionUtil::getActionUrl(PageIdConstants::PROJECT, "edit"));
        $this->setAttribute("urlDelete", ActionUtil::getActionUrl(PageIdConstants::PAYMENT, "delete"));
    }

    public function index() {
        $this->search();
    }

    public function search() {
        $pageSize = ParamsUtil::getQueryParamNumeric("page_size", AppConfig::$DEFAULT_PAGE_SIZE);
        $currentPage = ParamsUtil::getQueryParamNumeric("current_page", 1);
        //get  info
        $params['prj_status_payment'] = ParamsUtil::getQueryParam("prj_status_payment", null);
        $params['prj_status_payment'] = ArrayUtil::ArrayToString($params['prj_status_payment']); // process get str prj_status
        $params['prj_pay_method'] = ParamsUtil::getQueryParam("prj_pay_method", null);
        $params['prj_pay_method'] = ArrayUtil::ArrayToString($params['prj_pay_method']); // process get str prj_pay_method
        $params['prj_cust_name'] = ParamsUtil::getQueryParam("prj_cust_name", null);
        $params['prj_cust_prefectures'] = ParamsUtil::getQueryParam("prj_cust_prefectures", null);
        $params['prj_cust_address_full'] = ParamsUtil::getQueryParam("prj_cust_address_full", null);
        $params['prj_staff_id'] = ParamsUtil::getQueryParam("prj_staff_id", null);
        $params['prj_cust_phone_num'] = ParamsUtil::getQueryParam("prj_cust_phone_num", null);
        $params['more_cust_address'] =ParamsUtil::getQueryParam("more_cust_address", null);
        $params['prj_billing_date_from'] =ParamsUtil::getQueryParam("prj_billing_date_from", null);
        $params['prj_billing_date_to'] =ParamsUtil::getQueryParam("prj_billing_date_to", null);

        if($params["prj_billing_date_from"] == "0/0/0")
            $params["prj_billing_date_from"] = null;
        if($params["prj_billing_date_to"] == "0/0/0")
            $params["prj_billing_date_to"] = null;
        /*check authority data*/
        $role = $this->role;
        //if(!in_array(4,$role) && !in_array(5,$role))//if not 案件管理 
        if(!in_array(8, $role))//if not 入金状況検索    [管理者向け]（全案件）
        {
            $params['role_required'] = $this->login_id;
        }
        $totalRow = 0;
        $payment = new MPrjPaymentInfoDao();
        $sortCondition .= " IFNULL(prj_info.updated_time, prj_info.created_time) desc";
        $this->validateSearch($params);
        if (!$this->validate->hasError()) {
        	 $lSprjInfo = $payment->getWithPagging($currentPage, $pageSize, $sortCondition, $totalRow, $params);
        }
        else{
        	$lSprjInfo = $payment->getWithPagging($currentPage, $pageSize, $sortCondition, $totalRow, null);
        }
        if (isset($lSprjInfo) && count($lSprjInfo) > 0) {
            $this->setAttribute("lSprjInfo", $lSprjInfo);
        } else {
            $this->validate->addError(MessageConstants::COM_INFO_SEARCH_RESULT_NOT_FOUND);
        }
        $this->setAttribute("params", $value);
        $this->setAttribute("currentPage", $currentPage);
        $this->setAttribute("totalRow", $totalRow);
        $this->setAttribute("pageSize", $pageSize);
        $this->setView("view.php");
    }

    private function validateSearch($params) {
        $validateOpts = array(
            array(
                "itemId" => "prj_staff_id"
                , "itemName" => "担当社員ID  "
                , "types" => array(ValidateUtil::_IS_NUM)
                , "data" => $params["prj_staff_id"]
            )
            ,array(
                "itemId" => "prj_billing_date_from_msg"
                , "itemName" => "入金予定日1"
                , "types" => array(ValidateUtil::_IS_DATE)
                , "data" => $params["prj_billing_date_from"]
            )
            ,array(
                "itemId" => "prj_billing_date_to_msg"
                , "itemName" => "入金予定日2"
                , "types" => array(ValidateUtil::_IS_DATE)
                , "data" => $params["prj_billing_date_to"]
            )
            
        );
         $this->validate->validates($validateOpts);
        return !$this->validate->hasError();
    }

}

?>