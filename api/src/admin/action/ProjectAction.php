<?php

/**
 * */
require_once ROOT_PATH_COMMON . "/MessageConstants.php";
require_once ROOT_PATH_DAO . "/core/DbManager.php";
require_once ROOT_PATH_DAO . "/MStaffDao.php";
require_once ROOT_PATH_DAO . "/MOfficeDao.php";
require_once ROOT_PATH_DAO . "/MStaffRoleDao.php";
require_once ROOT_PATH_DAO . "/MProjectStatusHistoryDao.php";
require_once ROOT_PATH_DAO . "/MProjectDao.php";
require_once ROOT_PATH_DAO . "/MFileHistoryDao.php";
require_once ROOT_PATH_DAO . "/MPrjProdDao.php";
require_once ROOT_PATH_DAO . "/MPrjPaymentInfoDao.php";
require_once ROOT_PATH_DAO . "/MPrjAssignInfoDao.php";
require_once ROOT_PATH_COMMON . "/SessionManager.php";
require_once ROOT_PATH_DAO . "/MPrjProgressDao.php";
require_once ROOT_PATH_DAO . "/MShuruiApproveDao.php";
require_once ROOT_PATH_DAO . "/MPrjUpdateHistoryDao.php";
class ProjectAction extends BaseAction {

    public function rules() {
        return array(
            "search" => array("post", "get")
            , "regist" => array("post", "get")
            , "edit" => array("post", "get")
            , "cal" => array("post", "get")
            , "imp" => array("post", "get")
            , "delete" => "post"
            , "sort" => array('post', 'get')
        );
    }

    public function render() {
        // set url for screen
        $this->setAttribute("urlRegist", ActionUtil::getActionUrl(PageIdConstants::PROJECT, "regist"));
        $this->setAttribute("urlSearch", ActionUtil::getActionUrl(PageIdConstants::PROJECT, "search"));
        $this->setAttribute("urlEdit", ActionUtil::getActionUrl(PageIdConstants::PROJECT, "edit"));
        $this->setAttribute("urlDelete", ActionUtil::getActionUrl(PageIdConstants::PROJECT, "delete"));

        $this->setAttribute("urlDownload", ActionUtil::getActionUrl(PageIdConstants::DOWNLOAD, "save"));
        $this->setAttribute("urlDeleteFileHistory", ActionUtil::getActionUrl(PageIdConstants::FILEHISTORY, "delete"), false);
        $this->setAttribute("urlCal", ActionUtil::getActionUrl(PageIdConstants::PROJECT, "cal"));
        $this->setAttribute("urlImp", ActionUtil::getActionUrl(PageIdConstants::PROJECT, "imp"), false);
        $this->setAttribute("urlHistory", ActionUtil::getActionUrl(PageIdConstants::HISTORY, "index"));
    }

    public function index() {
        $this->search();
    }

    public function search() {
        $pageSize = ParamsUtil::getQueryParamNumeric("page_size", AppConfig::$DEFAULT_PAGE_SIZE);
        $currentPage = ParamsUtil::getQueryParamNumeric("current_page", 1);
        $totalRow = 0;
        /*GET PARAM FOR SEARCH */
          $params['prj_cust_name'] = ParamsUtil::getQueryParam("prj_cust_name",null);
          $params['prj_cust_prefectures']  = ParamsUtil::getQueryParamNumeric("prj_cust_prefectures",null);
          $params['prj_cust_address']  = ParamsUtil::getQueryParam("prj_cust_address",null);
          $params['prj_cust_phone_num']  = ParamsUtil::getQueryParam("prj_cust_phone_num",null);
          $params['prj_staff_id']  = ParamsUtil::getQueryParam("prj_staff_id",null);
          $params['prj_staff_name']  = ParamsUtil::getQueryParam("prj_staff_name",null);
          $params['prj_keiyaku_bi_from']  = ParamsUtil::getQueryParam("prj_keiyaku_bi_from",null);
          $params['prj_keiyaku_bi_to']  = ParamsUtil::getQueryParam("prj_keiyaku_bi_to",null);
          $params['prj_gencho_bi_from']  = ParamsUtil::getQueryParam("prj_gencho_bi_from",null);
          $params['prj_gencho_bi_to']  = ParamsUtil::getQueryParam("prj_gencho_bi_to",null);
          $params['prj_kanko_bi_from']  = ParamsUtil::getQueryParam("prj_kanko_bi_from",null);
          $params['prj_kanko_bi_to']  = ParamsUtil::getQueryParam("prj_kanko_bi_to",null);
          $params['prj_renkei_bi_from']  = ParamsUtil::getQueryParam("prj_renkei_bi_from",null);
          $params['prj_renkei_bi_to']  = ParamsUtil::getQueryParam("prj_renkei_bi_to",null);
          $params['prj_status']  = ParamsUtil::getQueryParam("prj_status",null);
          $params['prj_kind_contract']  = ParamsUtil::getQueryParam("prj_kind_contract",null);
          $params['prj_maker']  = ParamsUtil::getQueryParam("prj_maker",null);
        /*END GET PARAM FOR SEARCH  */
        if($params['prj_keiyaku_bi_from'] == '0/0/0')
            $params['prj_keiyaku_bi_from'] = null;
        if($params['prj_keiyaku_bi_to'] == '0/0/0')
            $params['prj_keiyaku_bi_to'] = null;
        if($params['prj_gencho_bi_from'] == '0/0/0')
            $params['prj_gencho_bi_from'] = null;
        if($params['prj_gencho_bi_to'] == '0/0/0')
            $params['prj_gencho_bi_to'] = null;
        if($params['prj_kanko_bi_from'] == '0/0/0')
            $params['prj_kanko_bi_from'] = null;
        if($params['prj_kanko_bi_to'] == '0/0/0')
            $params['prj_kanko_bi_to'] = null;
        if($params['prj_renkei_bi_from'] == '0/0/0')
            $params['prj_renkei_bi_from'] = null;
        if($params['prj_renkei_bi_to'] == '0/0/0')
            $params['prj_renkei_bi_to'] = null;
        /*check authority data*/
        $role = $this->role;
        if(!in_array(4,$role) && !in_array(5,$role))//if not 案件管理 
        {
            $params['role_required'] = $this->login_id;
        }
        $projectDao = new MProjectDao();
        $sortCondition .= " IFNULL(prj_info.updated_time, prj_info.created_time) desc";
        $this->validates_search($params);
        if (!$this->validate->hasError()) {
        	$lProject = $projectDao->getWithPagging($currentPage, $pageSize, $sortCondition, $totalRow, $params);
        }
        else{
        	$lProject = $projectDao->getWithPagging($currentPage, $pageSize, $sortCondition, $totalRow, null);
        }
        if (isset($lProject) && count($lProject) > 0) {
            $this->setAttribute("lProject", $lProject);
        } else {
            $this->validate->addError(MessageConstants::COM_INFO_SEARCH_RESULT_NOT_FOUND);
        }
        //die;
        $this->setAttribute("currentPage", $currentPage);
        $this->setAttribute("totalRow", $totalRow);
        $this->setAttribute("pageSize", $pageSize);
        $this->setView("view.php");
    }

    public function regist() {
        $session = new SessionManager();
        $staff_role = $session->getUserRole();
        $regist_step = ParamsUtil::getPostParam("regist_step", 0);
        $view = null;
        $projectDao = new MProjectDao();
        $project_upload_file_path = FILE_UPLOAD . '/projectinfo';
        $tmp = FILE_UPLOAD . '/projectinfo/tmp';
        // create or back from the screen preview
        if ($regist_step == 0 || $regist_step == 3) {
            $view = "input.php";
            $params = $this->jsonDecode(ParamsUtil::getPostParam("json_regist_data"));
            $lProjectStatusHistory  = $this->getProjectStatusByProjectId($params['prj_id']);
            $this->setAttribute("lProjectStatusHistory", $lProjectStatusHistory);
            $this->getData($params['prj_id']);
            $this->setViewState($params);
        } else if ($regist_step == 1) { // move to the preview screen 
            $paramsArray = $this->getParamsArray($staff_role);
            $params = ParamsUtil::getPostParams($paramsArray);
            $this->getData($params['prj_id']);
            $params['prj_cust_pos_code'] = $params['prj_cust_pos_code1'] . '-' . $params['prj_cust_pos_code2'];
            $params['prj_cust_ins_loc_pos_code'] = $params['prj_cust_ins_loc_pos_code1'] . '-' . $params['prj_cust_ins_loc_pos_code2'];
            $lProjectStatusHistory  = $this->getProjectStatusByProjectId($params['prj_id']);
            $this->setAttribute("lProjectStatusHistory", $lProjectStatusHistory);
            /* Process Upload File */
            $this->deleteTmpFile('prj_file_file_name1', $params, $tmp);
            $this->uploadFile('prj_file_file_name1', $params, $tmp, AppConfig::$FILE_UPLOAD_EXTENSION_PDF, "各種書類アップロード");
            $this->deleteTmpFile('prj_file_file_name2', $params, $tmp);
            $this->uploadFile('prj_file_file_name2', $params, $tmp, AppConfig::$FILE_UPLOAD_EXTENSION_CSV, "見積アップロード");
            /* End Process Upload File */
            $params = $this->convertDateRegist($params);
            $this->validates($params);
            if (!$this->validate->hasError()) {
                $this->setViewState(array("json_regist_data" => $this->jsonEncode($params)));
                $view = "preview.php";
            } else {
                $this->validate->addError($this->validate->messageFormat(MessageConstants::COM_ERR_HAPPENED));
                $view = "input.php";
            }
        } else if ($regist_step == 2) { // process save
            $params = $this->jsonDecode(ParamsUtil::getPostParam("json_regist_data"));
            $this->validates($params);
            if ($this->validate->hasError()) {
                $this->validate->addError($this->validate->messageFormat(MessageConstants::COM_ERR_HAPPENED));
                $view = "input.php";
            } else {
                unset($params['prj_cust_pos_code1']);
                unset($params['prj_cust_pos_code2']);
                unset($params['prj_cust_ins_loc_pos_code1']);
                unset($params['prj_cust_ins_loc_pos_code2']);
                $params['prj_kind_pv'] = ArrayUtil::ArrayToString($params['prj_kind_pv']);
                $params['prj_kind_od'] = ArrayUtil::ArrayToString($params['prj_kind_od']);
                $params['prj_pay_remain'] = !StringUtil::isNullOrEmpty($params['prj_pay_remain']) ? $params['prj_pay_remain'] : 0;
                $dbManger = DbManager::getInstance();
                $dbManger->beginTransaction();
                try {
                    $prj_old = array();
                    $params_project_info = array(
                        'prj_id' => $params['prj_id']
                        ,'prj_status' => $params['prj_status']
                        ,'prj_maker' => $params['prj_maker']
                        ,'prj_cust_name' => $params['prj_cust_name']
                        ,'prj_cust_pos_code' => $params['prj_cust_pos_code']
                        ,'prj_cust_prefectures' => $params['prj_cust_prefectures']
                        ,'prj_cust_city' => $params['prj_cust_city']
                        ,'prj_cust_address' => $params['prj_cust_address']
                        ,'prj_cust_mansion_info' => $params['prj_cust_mansion_info']
                        ,'prj_cust_ins_loc_pos_code' => $params['prj_cust_ins_loc_pos_code']
                        ,'prj_cust_ins_loc_prefectures' => $params['prj_cust_ins_loc_prefectures']
                        ,'prj_cust_ins_loc_city' => $params['prj_cust_ins_loc_city']
                        ,'prj_cust_ins_loc_address' => $params['prj_cust_ins_loc_address']
                        ,'prj_cust_ins_loc_mansion_info' => $params['prj_cust_ins_loc_mansion_info']
                        ,'prj_cust_phone_num' => $params['prj_cust_phone_num']
                        ,'prj_cust_email' => $params['prj_cust_email']
                        ,'prj_cust_memo' => $params['prj_cust_memo']
                        ,'prj_kind_contract' => $params['prj_kind_contract']
                        ,'prj_kind_garage' => $params['prj_kind_garage']
                        ,'prj_kind_pv' => $params['prj_kind_pv']
                        ,'prj_kind_od' => $params['prj_kind_od']
                        ,'prj_gencho_bi' => $params['prj_gencho_bi']
                        ,'prj_keiyaku_bi' => $params['prj_keiyaku_bi']
                        ,'prj_koji_kaishi_bi' => $params['prj_koji_kaishi_bi']
                        ,'prj_setsubi_nintei_shinsei_bi1' => $params['prj_setsubi_nintei_shinsei_bi1']
                        ,'prj_setsubi_nintei_shinsei_bi2' => $params['prj_setsubi_nintei_shinsei_bi2']
                        ,'prj_setsubi_nintei_shinsei_bi3' => $params['prj_setsubi_nintei_shinsei_bi3']
                        ,'prj_uchi_ochi_yotei_bi' => $params['prj_uchi_ochi_yotei_bi']
                        ,'prj_uchi_ochi_kakutei_bi' => $params['prj_uchi_ochi_kakutei_bi']
                        ,'prj_renkei_bi' => $params['prj_renkei_bi']
                        ,'prj_renkei_done' => $params['prj_renkei_done']
                        ,'prj_kanko_bi' => $params['prj_kanko_bi']
                        ,'prj_setchi_hiyo_nenpo_shinsei_bi' => $params['prj_setchi_hiyo_nenpo_shinsei_bi']
                        ,'prj_unten_hiyo_nenpo_shinsei_bi' => $params['prj_unten_hiyo_nenpo_shinsei_bi']
                        ,'prj_kyanceru_bi' => $params['prj_kyanceru_bi']
                        ,'prj_prod_price_selling_total' => $params['prj_prod_price_selling_total']
                        ,'prj_prod_price_part_total' => $params['prj_prod_price_part_total']
                        ,'prj_prod_checklist' => $params['prj_prod_checklist']
                        ,'prj_prod_notices' => $params['prj_prod_notices']
                        ,'prj_pay_method' => $params['prj_pay_method']
                        ,'prj_pay_completed_date' => $params['prj_pay_completed_date']
                        ,'prj_pay_remain' => $params['prj_pay_remain']
                        ,'created_user' => $params['created_user']
                        ,'created_time' => $params['created_time']
                        ,'updated_time' => $params['prj_updated_time']
                    );
                    /*check status is change before edit*/
                    $check_status_project = true;
                    if (!StringUtil::isNullOrEmpty($params["prj_id"])){
                        /* Insert data table prj_status_history */
                        $check_status_project = $this->insertPrjStatusHistory($params['prj_id'], $params['prj_status']);
                        $prj_old   = $this->getPrjById($params['prj_id']);
                    }
                    $check_prj = $Id = $projectDao->doRegist($params_project_info);
                    
                    $check_shuri = true;
                    $check_update_history = true;
                    if (!StringUtil::isNullOrEmpty($params["prj_id"])){
                        if(StringUtil::isNullOrEmpty($params['notsavehistory']) ||  $params['notsavehistory'] != 1){
                            $check_update_history = $this->insertHistory($params['prj_id'], $params, 'update', $prj_old);
                        }
                        $params_project_info['prj_kyanceru_bi'] = str_replace('/', '-', $params_project_info['prj_kyanceru_bi']);
                        $Id = $params['prj_id'];
                    }else{
                        if(StringUtil::isNullOrEmpty($params['notsavehistory']) ||  $params['notsavehistory'] != 1){
                             $check_update_history = $this->insertHistory($Id, $params, 'insert');
                        }
                        $check_shuri = $this->insertShuriAppoveByPrjId($Id);
                    }
                    if (is_numeric($Id)) {
                        /* Process Insert prj_file_history */
                        $staff_id = null;
                        $time = null;
                        if(!StringUtil::isNullOrEmpty($params['prj_file_file_name1']) || !StringUtil::isNullOrEmpty($params['prj_file_file_name2'])){
                            $staff_id_current_login = $this->session->getLoginUserId();
                            $time_now = DateUtil::getCurrentDatetime();
                        }
                        $check_insert_file1 = true;
                        $check_insert_file2 = true;
                        if (!StringUtil::isNullOrEmpty($params['prj_file_file_name1']) && !StringUtil::isNullOrEmpty($params['prj_file_shubetsu'])) {
                            $params_file = array(
                                'prj_id' => $Id
                                , 'prj_file_type' => AppConfig::$FILE_TYPE_DOCS
                                , 'prj_file_shubetsu' =>$params['prj_file_shubetsu']
                                , 'prj_file_uploaded_date' =>  $time_now 
                                , 'prj_file_uploaded_staff' => $staff_id_current_login
                                , 'prj_file_file_name' => $params['prj_file_file_name1']
                                , 'prj_file_file_path' => $params['prj_file_file_name1_tmp']
                            );
                            $check_insert_file1 = $this->insertFileHistory($params_file);
                            $check_path = $project_upload_file_path . '/' . $Id . '/' . AppConfig::$DOCS_FOLDER . '/';
                            $docs_path = $check_path . $params['prj_file_file_name1_tmp'];
                            $docs_tmp = $tmp . '/' . $params['prj_file_file_name1_tmp'];
                            FileUploadUtil::CreateFolder($check_path);
                            FileUploadUtil::MoveFile($docs_tmp, $docs_path);
                        }
                        if (!StringUtil::isNullOrEmpty($params['prj_file_file_name2'])) {
                            $params_file = array(
                                'prj_id' => $Id
                                , 'prj_file_type' => AppConfig::$FILE_TYPE_ESTIMATE
                                , 'prj_file_shubetsu' =>null
                                , 'prj_file_uploaded_date' => $time_now
                                , 'prj_file_uploaded_staff' => $staff_id_current_login
                                , 'prj_file_file_name' => $params['prj_file_file_name2']
                                , 'prj_file_file_path' => $params['prj_file_file_name2_tmp']
                            );
                            $check_insert_file2 = $this->insertFileHistory($params_file);
                            $check_path = $project_upload_file_path . '/' . $Id . '/' . AppConfig::$ESTIMATE_FOLDER . '/';
                            $docs_path = $check_path . $params['prj_file_file_name2_tmp'];
                            $docs_tmp = $tmp . '/' . $params['prj_file_file_name2_tmp'];
                            FileUploadUtil::CreateFolder($check_path);
                            FileUploadUtil::MoveFile($docs_tmp, $docs_path);
                        }

                        /* End Process Insert prj_file_history */
                        /* Process Insert Update prj_prod_info */
                        $check_prj_prod = true;
                        $temp_prj_prod = array();
                        for ($i = 0; $i <= 25; $i++) {
                            if (!StringUtil::isNullOrEmpty($params["prj_prod_type_row$i"]) 
                                || !StringUtil::isNullOrEmpty($params["prj_prod_maker_row$i"]) 
                                || !StringUtil::isNullOrEmpty($params["prj_prod_model_row$i"]) 
                                || !StringUtil::isNullOrEmpty($params["prj_prod_num_row$i"]) 
                                || !StringUtil::isNullOrEmpty($params["prj_prod_unit_price_selling_row$i"]) 
                                || !StringUtil::isNullOrEmpty($params["prj_prod_price_selling_row$i"]) 
                                || !StringUtil::isNullOrEmpty($params["prj_prod_unit_price_part_row$i"]) 
                                || !StringUtil::isNullOrEmpty($params["prj_prod_price_part_row$i"]) 
                                || !StringUtil::isNullOrEmpty($params["prj_prod_kw$i"]) 
                                || !StringUtil::isNullOrEmpty($params["prj_prod_memo_row$i"]) 
                                || !StringUtil::isNullOrEmpty($params["prj_prod_info_id$i"])) {
                                if ($i >= 17 && $i <= 22)
                                    $prj_prod_class_nm = $params["prj_prod_class_nm_row$i"];
                                else
                                    $prj_prod_class_nm = AppConfig::$SORT_ID[$i][2];
                                $params_prod = array(
                                    "id" => $params["prj_prod_info_id$i"]
                                    , "prj_id" => $Id
                                    , "sort_id" => AppConfig::$SORT_ID[$i][0]
                                    , "prj_prod_class" => AppConfig::$SORT_ID[$i][1]
                                    , "prj_prod_class_nm" => $prj_prod_class_nm
                                    , "prj_prod_type" => $params["prj_prod_type_row$i"]
                                    , "prj_prod_maker" => $params["prj_prod_maker_row$i"]
                                    , "prj_prod_model" => $params["prj_prod_model_row$i"]
                                    , "prj_prod_num" => $params["prj_prod_num_row$i"]
                                    , "prj_prod_unit_price_selling" => $params["prj_prod_unit_price_selling_row$i"]
                                    , "prj_prod_price_selling" => $params["prj_prod_price_selling_row$i"]
                                    , "prj_prod_unit_price_part" => $params["prj_prod_unit_price_part_row$i"]
                                    , "prj_prod_price_part" => $params["prj_prod_price_part_row$i"]
                                    , "prj_prod_kw" => $params["prj_prod_kw$i"]
                                    , "prj_prod_memo" => $params["prj_prod_memo_row$i"]
                                    , "updated_time" => $params["prj_prod_info_updated_time$i"]
                                );
                                $temp_prj_prod[] = $this->insertAndUpdatePrjProdInfo($params_prod);
                            }elseif ($i >= 17 && $i <= 22) {//this case only prj_prod_class_nm_row have data
                                if (!StringUtil::isNullOrEmpty($params["prj_prod_class_nm_row$i"])) {
                                    $params_prod = array(
                                         "id" => $params["prj_prod_info_id$i"]
                                        , "prj_id" => $Id
                                        , "sort_id" => AppConfig::$SORT_ID[$i][0]
                                        , "prj_prod_class" => AppConfig::$SORT_ID[$i][1]
                                        , "prj_prod_class_nm" => $prj_prod_class_nm
                                        , "prj_prod_type" => null
                                        , "prj_prod_maker" => null
                                        , "prj_prod_model" => null
                                        , "prj_prod_num" => null
                                        , "prj_prod_unit_price_selling" => null
                                        , "prj_prod_price_selling" => null
                                        , "prj_prod_unit_price_part" => null
                                        , "prj_prod_price_part" => null
                                        , "prj_prod_kw" => null
                                        , "prj_prod_memo" => null
                                        , "updated_time" => $params["prj_prod_info_updated_time$i"]
                                    );
                                    $params_prj_prod_all[] = $params_prod;
                                    $temp_prj_prod[] = $this->insertAndUpdatePrjProdInfo($params_prod);
                                }
                            }
                        }

                        for ($i=0,$count_prj_prod = count($temp_prj_prod); $i < $count_prj_prod; $i++) { 
                            if($temp_prj_prod[$i] <= 0) {
                                $check_prj_prod = false;
                                break;
                            }
                        }
                        /* End Process Insert Update prj_prod_info */
                        /* Process Insert Update prj_payment_info */
                        $check_prj_pay = true;
                        $temp_prj_pay = array();
                        $array_payment_data = array();
                        for ($i = 1; $i <= 6; $i++) {
                            if (!StringUtil::isNullOrEmpty($params["prj_billing_date$i"]) 
                                || !StringUtil::isNullOrEmpty($params["prj_plan_pay_day$i"])
                                || !StringUtil::isNullOrEmpty($params["prj_paid_date$i"])
                                || !StringUtil::isNullOrEmpty($params["prj_plan_pay_amount$i"])
                                || !StringUtil::isNullOrEmpty($params["prj_plan_pay_per$i"])
                                || !StringUtil::isNullOrEmpty($params["prj_plan_pay_deposit$i"])
                                || !StringUtil::isNullOrEmpty($params["prj_plan_pay_memo$i"])
                                || !StringUtil::isNullOrEmpty($params["prj_plan_paid_amount$i"])
                                || !StringUtil::isNullOrEmpty($params["prj_plan_paid_memo$i"])
                                || !StringUtil::isNullOrEmpty($params["prj_payment_info_id$i"])
                                ) {
                                $params_payment = array(
                                    'prj_id' => $Id
                                    , 'prj_paid_date' => $params["prj_paid_date$i"]
                                    , 'prj_billing_date' => $params["prj_billing_date$i"]
                                    , 'prj_plan_paid_amount' => $params["prj_plan_paid_amount$i"]
                                    , 'prj_plan_pay_amount' => $params["prj_plan_pay_amount$i"]
                                    , 'sort_id' => AppConfig::$FILE_TYPE_SORTID[$i - 1]
                                    , 'prj_plan_paid_memo' => $params["prj_plan_paid_memo$i"]
                                    , 'prj_plan_pay_memo' => $params["prj_plan_pay_memo$i"]
                                    , 'prj_plan_pay_deposit' => $params["prj_plan_pay_deposit$i"]
                                    , 'prj_plan_pay_per' => $params["prj_plan_pay_per$i"]
                                    , 'prj_plan_pay_day' => $params["prj_plan_pay_day$i"]
                                    , 'id' => $params["prj_payment_info_id$i"]
                                    , 'updated_time' => $params["prj_payment_info_updated_time$i"]
                                );
                                $temp_prj_pay[]       = $this->insertAndUpdatePrjPaymentInfo($params_payment);
                                $array_payment_data[] = $params_payment;
                            }
                        }
                        for ($i=0,$count_prj_pay = count($temp_prj_pay); $i < $count_prj_pay; $i++) { 
                            if($temp_prj_pay[$i] <= 0) {
                                $check_prj_pay = false;
                                break;
                            }
                        }
                        $check_update_com_date = $this->updateProjectCompletedDate($Id,$array_payment_data);
                        /* End Process Insert Update prj_payment_info */
                        /* Process Insert Update prj_assign_info */
                        $check_prj_assign = true;
                        $temp_prj_assign = array();
                        if(!StringUtil::isNullOrEmpty($params['prj_id']))
                        {
                            $model = new MPrjAssignInfoDao();
                            $model->deleteFromByPrjId($Id);
                        }
                        for ($i = 1; $i <= count(AppConfig::$STAFF_POS); $i++) {
                            $params_assign = array(
                                "prj_id" => $Id
                                , "prj_role_grp" => AppConfig::$STAFF_POS[$i][0]
                                , "prj_staff_pos" =>AppConfig::$STAFF_POS[$i][1]
                                , "prj_staff_id" => $params["prj_staff_id$i"]
                                , "deleted_flag" => 0
                            );
                            if (!StringUtil::isNullOrEmpty($params["prj_staff_id$i"])) {
                                $temp_prj_assign[] = $this->insertPrjAssignInfo($params_assign);
                            }
                        }
                        for ($i=0,$count_prj_assign = count($temp_prj_assign); $i < $count_prj_assign; $i++) { 
                            if($temp_prj_assign[$i] <= 0) {
                                $check_prj_assign = false;
                                break;
                            }
                        }
                        /* end Process Insert Update prj_assign_info */
                        $this->sortAssignByPrjId($Id);

                        /*insert update progress*/
                        $check_prj_progress = false;
                        $modelProgress = new MPrjProgressDao();
                        $paramsProgress = array(
                            'prj_id' => $Id
                            ,'prj_prg_eq_accre_id' => $params['prj_prg_eq_accre_id']
                            ,'prj_prg_cust_login_id' => $params['prj_prg_cust_login_id']
                            ,'prj_prg_cust_login_passw' => $params['prj_prg_cust_login_passw']
                            ,'prj_prg_tepco_num1' => $params['prj_prg_tepco_num1']
                            ,'prj_prg_tepco_num2' => $params['prj_prg_tepco_num2']
                            ,'prj_prg_update_date' => $params['prj_prg_update_date']
                            ,'prj_prg_module' => $params['prj_prg_module']
                            ,'prj_prg_module_num' => $params['prj_prg_module_num']
                            ,'prj_prg_pcs1' => $params['prj_prg_pcs1']
                            ,'prj_prg_pcs1_num' => $params['prj_prg_pcs1_num']
                            ,'prj_prg_pcs2' => $params['prj_prg_pcs2']
                            ,'prj_prg_pcs2_num' => $params['prj_prg_pcs2_num']
                            ,'prj_prg_sum_exp' => $params['prj_prg_sum_exp']
                            ,'prj_prg_appl_out' => $params['prj_prg_appl_out']
                            ,'prj_prg_eq_cer_appl_date' => $params['prj_prg_eq_cer_appl_date']
                            ,'prj_prg_el_recept_recv_date' => $params['prj_prg_el_recept_recv_date']
                            ,'prj_prg_eq_acc_res_date' => $params['prj_prg_eq_acc_res_date']
                            ,'prj_prg_cons_grant_cal_date' => $params['prj_prg_cons_grant_cal_date']
                            ,'prj_prg_cons_grant' => $params['prj_prg_cons_grant']
                            ,'prj_prg_cons_grant_pay_date' => $params['prj_prg_cons_grant_pay_date']
                            ,'prj_prg_meter_fee' => $params['prj_prg_meter_fee']
                            ,'prj_prg_conn_cons_appl_date' => $params['prj_prg_conn_cons_appl_date']
                            ,'prj_prg_conn_cons_res_date' => $params['prj_prg_conn_cons_res_date']
                            ,'prj_prg_eq_cer_req' => $params['prj_prg_eq_cer_req']
                            ,'prj_prg_appl_date' => $params['prj_prg_appl_date']
                            ,'prj_prg_elec_use_appl_date' => $params['prj_prg_elec_use_appl_date']
                            ,'prj_prg_cons_amount' => $params['prj_prg_cons_amount']
                            ,'prj_prg_tokyo_supply_demand' => $params['prj_prg_tokyo_supply_demand']
                            ,'prj_prg_cons_grant_pay_date2' => $params['prj_prg_cons_grant_pay_date2']
                            ,'prj_prg_coop_pros' => $params['prj_prg_coop_pros']
                            ,'prj_prg_note' => $params['prj_prg_note']
                            ,'prj_prg_remark' => $params['prj_prg_remark']
                            ,'updated_time' => $params['progress_updated_time']
                        );
                        $id_prj_progress = $modelProgress->doInsertUpdate($paramsProgress);
                        if($id_prj_progress >= 0)
                            $check_prj_progress = true;
                    }

                    if (StringUtil::isNullOrEmpty($params["prj_id"])) {//if update prj
                        if ($Id > 0 
                            && $check_prj
                            && $check_update_history 
                            && $check_shuri 
                            && $check_insert_file1 
                            && $check_insert_file2
                            && $check_prj_prod
                            && $check_prj_pay
                            && $check_prj_assign
                            && $check_prj_progress
                            ) {
                                $dbManger->commit();
                                $this->setInsertSuccessMessage();
                        }
                    } else {
                        if ($Id > 0
                            && $check_prj
                            && $check_update_history 
                            && $check_shuri 
                            && $check_insert_file1 
                            && $check_insert_file2
                            && $check_prj_prod
                            && $check_prj_pay
                            && $check_prj_assign
                            && $check_prj_progress) {
                            $dbManger->commit();
                            if($params['notsavehistory']!=1)
                                $this->sendMailChangeHistory($Id, 'update');
                            if($params_project_info['prj_status'] == 4 && $prj_old['prj_status'] != 4){
                                $this->sendMailCancelProject($prj_old['prj_id']);
                            }
                            $this->setUpdateSuccessMessage();
                        } else {
                            $dbManger->rollback();
                            $this->setErrorExclusiveMessage();
                        }
                    }
                } catch (Exception $e) {
                    $dbManger->rollback();
                    $this->logger->error($e->getMessage() . "(at " . $e->getTraceAsString() . ")");
                    throw new Exception("Error Processing Request".$e, 1);
                }
            }
            $redirect = ParamsUtil::getPostParam("redirect");
            if ($redirect == null) {
                $redirect = PageIdConstants::PROJECT;
            }
            ActionUtil::redirect($redirect);
        }
        if (!StringUtil::isNullOrEmpty($view)) {
            $this->setView($view);
        }
    }

    public function edit() {
        $projectDao = new MProjectDao();
        if ($this->isGet()) {
            $editProjectId = ParamsUtil::getQueryParamNumeric("edit_prj_id", 0);
            $dataProject = $this->getAllDataOfProjectByProjectID($editProjectId);
            if (!ArrayUtil::isNullOrEmpty($dataProject)) {
                $this->getData($editProjectId);
                $project = $dataProject['project'];
                $project_progress = $dataProject['project_progress'];
                if (!ArrayUtil::isNullOrEmpty($project)) {
                    if (!StringUtil::isNullOrEmpty($project['prj_cust_pos_code'])) {
                        $project['prj_cust_pos_code1'] = explode("-", $project['prj_cust_pos_code']);
                        $project['prj_cust_pos_code2'] = explode("-", $project['prj_cust_pos_code']);
                        $project['prj_cust_pos_code1'] = $project['prj_cust_pos_code1'][0];
                        $project['prj_cust_pos_code2'] = $project['prj_cust_pos_code2'][1];
                    }
                    if (!StringUtil::isNullOrEmpty($project['prj_cust_ins_loc_pos_code'])) {
                        $project['prj_cust_ins_loc_pos_code1'] = explode("-", $project['prj_cust_ins_loc_pos_code']);
                        $project['prj_cust_ins_loc_pos_code2'] = explode("-", $project['prj_cust_ins_loc_pos_code']);
                        $project['prj_cust_ins_loc_pos_code1'] = $project['prj_cust_ins_loc_pos_code1'][0];
                        $project['prj_cust_ins_loc_pos_code2'] = $project['prj_cust_ins_loc_pos_code2'][1];
                    }

                    $project['prj_kind_pv'] = ArrayUtil::StringToArray($project['prj_kind_pv']);
                    $project['prj_kind_od'] = ArrayUtil::StringToArray($project['prj_kind_od']);
                    /*tab1*/
                    $project['prj_updated_time'] =  $project['updated_time'];

                    $this->setViewState($project);
                    $lProjectStatusHistory  = $this->getProjectStatusByProjectId($editProjectId);
                    $this->setAttribute("lProjectStatusHistory", $lProjectStatusHistory);

                    /* tab2*/
                    $prjprod = $dataProject['prjprod'];
                    $dataPjrProd = $this->convertPrjProdFromDBtoView($prjprod);
                    $this->setViewState($dataPjrProd);

                    /*tab3*/
                    $List_payment_info = $dataProject['List_payment_info'];
                    $dataPjrPay = array();
                    for ($i = 1; $i <= 6; $i++) {
                        foreach ($List_payment_info as $value) {
                            if (AppConfig::$FILE_TYPE_SORTID[$i - 1] == $value['sort_id']) {
                                $dataPjrPay["prj_payment_info_id$i"] = $value['id'];
                                $dataPjrPay["prj_plan_pay_day$i"] = $value['prj_plan_pay_day'];
                                $dataPjrPay["prj_pay_method$i"] = $value['prj_pay_method'];
                                $dataPjrPay["prj_billing_date$i"] = $value['prj_billing_date'];
                                $dataPjrPay["prj_plan_pay_day$i"] = $value['prj_plan_pay_day'];
                                $dataPjrPay["prj_paid_date$i"] = $value['prj_paid_date'];
                                $dataPjrPay["prj_plan_pay_amount$i"] = $value['prj_plan_pay_amount'];
                                $dataPjrPay["prj_plan_pay_per$i"] = $value['prj_plan_pay_per'];
                                $dataPjrPay["prj_plan_pay_deposit$i"] = $value['prj_plan_pay_deposit'];
                                $dataPjrPay["prj_plan_pay_memo$i"] = $value['prj_plan_pay_memo'];
                                $dataPjrPay["prj_plan_paid_amount$i"] = $value['prj_plan_paid_amount'];
                                $dataPjrPay["prj_plan_paid_memo$i"] = $value['prj_plan_paid_memo'];
                                $dataPjrPay["prj_payment_info_updated_time$i"] = $value['updated_time'];
                                continue;
                            }
                        }
                    }
                    $this->setViewState($dataPjrPay);

                    /*tab4*/
                    $List_assign_info1 = $dataProject['List_assign_info1'];
                    $List_assign_info2 = $dataProject['List_assign_info2'];
                    $List_assign_info3 = $dataProject['List_assign_info3'];
                    $dataPjrAssign = array();
                    if (!ArrayUtil::isNullOrEmpty($List_assign_info1)) {
                        $i = 1;
                        foreach ($List_assign_info1 as $value) {
                            $dataPjrAssign["prj_staff_id$i"] = !StringUtil::isNullOrEmpty($value['prj_staff_id']) ? $value['prj_staff_id'] : null;
                            $i++;
                        }
                    }
                    if (!ArrayUtil::isNullOrEmpty($List_assign_info2)) {
                        $i = 5;
                        foreach ($List_assign_info2 as $value) {
                            $dataPjrAssign["prj_staff_id$i"] = !StringUtil::isNullOrEmpty($value['prj_staff_id']) ? $value['prj_staff_id'] : null;
                            $i++;
                        }
                    }
                    if (!ArrayUtil::isNullOrEmpty($List_assign_info3)) {
                        $i = 8;
                        foreach ($List_assign_info3 as $value) {
                            $dataPjrAssign["prj_staff_id$i"] = !StringUtil::isNullOrEmpty($value['prj_staff_id']) ? $value['prj_staff_id'] : null;
                            $i++;
                        }
                    }
                    $this->setViewState($dataPjrAssign);

                    /*tab5*/
                    $project_progress['progress_updated_time'] = $project_progress['updated_time'];
                    unset($project_progress['updated_time']);
                    $this->setViewState($project_progress);

                    $this->setView("input.php");
                } else {
                    $this->setErrorNotFoundMessage();
                    ActionUtil::redirect(PageIdConstants::PROJECT);
                }
            } else {
                $this->setErrorNotFoundMessage();
                ActionUtil::redirect(PageIdConstants::PROJECT);
            }
        } else {
            $this->regist();
        }
    }

    public function delete() {
        $Id = ParamsUtil::getPostParam("delete_prj_id");
        $rowAffected = 0;
        if ($Id) {
            $dbManger = DbManager::getInstance();
            $dbManger->beginTransaction();
            try{
                $projectDao = new MProjectDao();
                $rowAffected = $projectDao->deleteLogic($Id);
                if ($rowAffected) {
                    // delete success
                    $this->setDeleteSuccessMessage();
                    $prj_status     = new MProjectStatusHistoryDao();
                    $prj_file       = new MFileHistoryDao();
                    $prj_payment    = new MPrjPaymentInfoDao();
                    $prj_assign     = new MPrjAssignInfoDao();
                    $prj_progress   = new MPrjProgressDao();
                    $prj_prod       = new MPrjProdDao();
                    $prj_status->DeleteByPrjId($Id);
                    $prj_file->DeleteByPrjId($Id);
                    $prj_payment->DeleteByPrjId($Id);
                    $prj_assign->DeleteByPrjId($Id);
                    $prj_progress->DeleteByPrjId($Id);
                    $prj_prod->DeleteByPrjId($Id);
                    $dbManger->commit();
                }    
            }catch (Exception $e) {
                $dbManger->rollback();
                $rowAffected = false;
            }
        }
        if (!$rowAffected) {
            // submit data is error or delete not success
            $this->setErrorNotFoundMessage();
        }
        $redirect = ParamsUtil::getPostParam("redirect");
        if ($redirect == null) {
            $redirect = PageIdConstants::PROJECT;
        }
        // show list
        ActionUtil::redirect($redirect);
    }

    private function validates($params) {
        $validateOpts = array(
            array(
                "itemId" => "prj_status"
                , "itemName" => "ステータス"
                , "types" => array(ValidateUtil::_IS_NULL, ValidateUtil::_IS_NUM)
                , "data" => $params["prj_status"]
            ),
            array(
                "itemId" => "prj_maker"
                , "itemName" => "メーカー"
                , "types" => array(ValidateUtil::_IS_NUM)
                , "data" => $params["prj_maker"]
            ),
            array(
                "itemId" => "prj_cust_name"
                , "itemName" => "お客様氏名"
                , "types" => array(ValidateUtil::_IS_MAX, ValidateUtil::_IS_NULL)
                , "data" => $params["prj_cust_name"]
                , "max" => 250
            ),
            array(
                "itemId" => "prj_cust_pos_code"
                , "itemName" => "住所（お客様住居） 郵便番号"
                , "types" => array(ValidateUtil::_IS_POSTAL_CODE)
                , "data" => $params["prj_cust_pos_code"]
            ),
            array(
                "itemId" => "prj_cust_prefectures"
                , "itemName" => "住所（お客様住居） 都道府県"
                , "types" => array(ValidateUtil::_IS_NUM)
                , "data" => $params["prj_cust_prefectures"]
            ),
            array(
                "itemId" => "prj_cust_city"
                , "itemName" => "住所（お客様住居） 市区町村"
                , "types" => array(ValidateUtil::_IS_MAX)
                , "data" => $params["prj_cust_city"]
                , "max" => 250
            ),
            array(
                "itemId" => "prj_cust_address"
                , "itemName" => "住所（お客様住居） 番地等"
                , "types" => array(ValidateUtil::_IS_MAX)
                , "data" => $params["prj_cust_address"]
                , "max" => 250
            ),
            array(
                "itemId" => "prj_cust_mansion_info"
                , "itemName" => "住所（お客様住居） マンション/ビル名等"
                , "types" => array(ValidateUtil::_IS_MAX)
                , "data" => $params["prj_cust_mansion_info"]
                , "max" => 250
            ),
            array(
                "itemId" => "prj_cust_ins_loc_pos_code"
                , "itemName" => "住所（設置場所） 郵便番号"
                , "types" => array(ValidateUtil::_IS_POSTAL_CODE)
                , "data" => $params["prj_cust_ins_loc_pos_code"]
            ),
            array(
                "itemId" => "prj_cust_ins_loc_prefectures"
                , "itemName" => "住所（設置場所） 都道府県"
                , "types" => array(ValidateUtil::_IS_NUM)
                , "data" => $params["prj_cust_ins_loc_prefectures"]
            ),
            array(
                "itemId" => "prj_cust_ins_loc_city"
                , "itemName" => "住所（設置場所） 市区町村"
                , "types" => array(ValidateUtil::_IS_MAX)
                , "data" => $params["prj_cust_ins_loc_city"]
                , "max" => 250
            ),
            array(
                "itemId" => "prj_cust_ins_loc_address"
                , "itemName" => "住所（設置場所） 番地等"
                , "types" => array(ValidateUtil::_IS_MAX)
                , "data" => $params["prj_cust_ins_loc_address"]
                , "max" => 250
            ),
            array(
                "itemId" => "prj_cust_ins_loc_mansion_info"
                , "itemName" => "住所（設置場所） マンション/ビル名等"
                , "types" => array(ValidateUtil::_IS_MAX)
                , "data" => $params["prj_cust_ins_loc_mansion_info"]
                , "max" => 250
            ),
            array(
                "itemId" => "prj_cust_phone_num"
                , "itemName" => "電話番号"
                , "types" => array(ValidateUtil::_IS_NULL, ValidateUtil::_IS_TELPHONE)
                , "data" => $params["prj_cust_phone_num"]
            ),
            array(
                "itemId" => "prj_cust_email"
                , "itemName" => "メールアドレス"
                , "types" => array(ValidateUtil::_IS_MAIL, ValidateUtil::_IS_MAX)
                , "data" => $params["prj_cust_email"]
                , "max" => 100
            ),
            array(
                "itemId" => "prj_cust_memo"
                , "itemName" => "その他備考"
                , "types" => array(ValidateUtil::_IS_MAX)
                , "data" => $params["prj_cust_memo"]
                , "max" => 50000
            ),
            array(
                "itemId" => "prj_kind_contract"
                , "itemName" => "種別 契約種別"
                , "types" => array(ValidateUtil::_IS_NUM)
                , "data" => $params["prj_kind_contract"]
            ),
            array(
                "itemId" => "prj_kind_garage"
                , "itemName" => "種別 車庫"
                , "types" => array(ValidateUtil::_IS_NUM)
                , "data" => $params["prj_kind_garage"]
            ),
            array(
                "itemId" => "prj_gencho_bi_msg"
                , "itemName" => "現調日"
                , "types" => array(ValidateUtil::_IS_DATE)
                , "data" => $params["prj_gencho_bi"]
            ),
            array(
                "itemId" => "prj_keiyaku_bi_msg"
                , "itemName" => "契約日"
                , "types" => array(ValidateUtil::_IS_DATE)
                , "data" => $params["prj_keiyaku_bi"]
            ),
            array(
                "itemId" => "prj_koji_kaishi_bi_msg"
                , "itemName" => "工事開始日"
                , "types" => array(ValidateUtil::_IS_DATE)
                , "data" => $params["prj_koji_kaishi_bi"]
            ),
            array(
                "itemId" => "prj_setsubi_nintei_shinsei_bi1_msg"
                , "itemName" => "設備認定 申請日1"
                , "types" => array(ValidateUtil::_IS_DATE)
                , "data" => $params["prj_setsubi_nintei_shinsei_bi1"]
            ),
            array(
                "itemId" => "prj_setsubi_nintei_shinsei_bi2_msg"
                , "itemName" => "設備認定 申請日2"
                , "types" => array(ValidateUtil::_IS_DATE)
                , "data" => $params["prj_setsubi_nintei_shinsei_bi2"]
            ),
            array(
                "itemId" => "prj_setsubi_nintei_shinsei_bi3_msg"
                , "itemName" => "設備認定 申請日3"
                , "types" => array(ValidateUtil::_IS_DATE)
                , "data" => $params["prj_setsubi_nintei_shinsei_bi3"]
            ),
            array(
                "itemId" => "prj_uchi_ochi_yotei_bi_msg"
                , "itemName" => "内落予定日"
                , "types" => array(ValidateUtil::_IS_DATE)
                , "data" => $params["prj_uchi_ochi_yotei_bi"]
            ),
            array(
                "itemId" => "prj_uchi_ochi_kakutei_bi_msg"
                , "itemName" => "内落確定日"
                , "types" => array(ValidateUtil::_IS_DATE)
                , "data" => $params["prj_uchi_ochi_kakutei_bi"]
            ),
            array(
                "itemId" => "prj_renkei_bi_msg"
                , "itemName" => "連系日"
                , "types" => array(ValidateUtil::_IS_DATE)
                , "data" => $params["prj_renkei_bi"]
            ),
            array(
                "itemId" => "prj_kanko_bi_msg"
                , "itemName" => "完工日"
                , "types" => array(ValidateUtil::_IS_DATE)
                , "data" => $params["prj_kanko_bi"]
            ),
            array(
                "itemId" => "prj_setchi_hiyo_nenpo_shinsei_bi_msg"
                , "itemName" => "設置費用年報申請日"
                , "types" => array(ValidateUtil::_IS_DATE)
                , "data" => $params["prj_setchi_hiyo_nenpo_shinsei_bi"]
            ),
            array(
                "itemId" => "prj_unten_hiyo_nenpo_shinsei_bi_msg"
                , "itemName" => "運転費用年報申請日"
                , "types" => array(ValidateUtil::_IS_DATE)
                , "data" => $params["prj_unten_hiyo_nenpo_shinsei_bi"]
            ),
            array(
                "itemId" => "prj_kyanceru_bi_msg"
                , "itemName" => "キャンセル日"
                , "types" => array(ValidateUtil::_IS_DATE)
                , "data" => $params["prj_kyanceru_bi"]
            )

            /* fragment 2 */
            , array(
                "itemId" => "prj_prod_price_selling_total"
                , "itemName" => "chua co text"
                , "types" => array(ValidateUtil::_IS_NUM)
                , "data" => $params["prj_prod_price_selling_total"]
            )
            , array(
                "itemId" => "prj_prod_price_part_total"
                , "itemName" => "chua co text"
                , "types" => array(ValidateUtil::_IS_NUM)
                , "data" => $params["prj_prod_price_part_total"]
            )
            , array(
                "itemId" => "prj_prod_checklist"
                , "itemName" => "確認事項$i"
                , "types" => array(ValidateUtil::_IS_MAX)
                , "data" => $params["prj_prod_checklist"]
                , "max" => 5000
            )
            , array(
                "itemId" => "prj_prod_notices"
                , "itemName" => "特記事項$i"
                , "types" => array(ValidateUtil::_IS_MAX)
                , "data" => $params["prj_prod_notices"]
                , "max" => 5000
            )
            /* end fragment 2 */
            ,array(
                "itemId" => "prj_staff_id1"
                , "itemName" => "担当者 1"
                , "types" => array(ValidateUtil::_IS_NULL, ValidateUtil::_IS_NUM)
                , "data" => $params["prj_staff_id1"]
            )
        );
        if ($params['prj_cust_pos_code'] == '-') {
            unset($validateOpts[3]);
        }
        if ($params['prj_cust_ins_loc_pos_code'] == '-') {
            unset($validateOpts[8]);
        }

        if ($params['prj_renkei_done'] == 1) {
            $validateOpts[] = array(
                "itemId" => "prj_renkei_bi"
                , "itemName" => "連系日"
                , "types" => array(ValidateUtil::_IS_NULL)
                , "data" => $params["prj_renkei_bi"]
            );
        }

        if (!StringUtil::isNullOrEmpty($params['prj_file_file_name1'])) {
            $validateOpts[] = array(
                "itemId" => "prj_file_shubetsu"
                , "itemName" => "種別"
                , "types" => array(ValidateUtil::_IS_NULL, ValidateUtil::_IS_NUM)
                , "data" => $params["prj_file_shubetsu"]
            );
        }

        $validateOptsFragment2 = $this->getValidateOptsFragment2($params);
        $validateOptsFragment3 = $this->getValidateOptsFragment3($params);
        $validateOptsFragment5 = $this->getValidateOptsFragment5($params);
        $validateOptsFragment4 = $this->getValidateOptsFragment4($params,4,3,3);
        $validateOpts = array_merge($validateOpts, $validateOptsFragment2, $validateOptsFragment3, $validateOptsFragment5);
        $this->validate->validates($validateOpts);
        return !$this->validate->hasError();
    }

    private function validates_search($params){
    	$validateOpts = array(
    		array(
                "itemId" => "prj_staff_id"
                , "itemName" => "担当社員ID "
                , "types" => array(ValidateUtil::_IS_NUM)
                , "data" => $params["prj_staff_id"]
            ),
           	array(
                "itemId" => "show-err-keiyaku-from"
                , "itemName" => "契約日1"
                , "types" => array(ValidateUtil::_IS_DATE)
                , "data" => $params["prj_keiyaku_bi_from"]
            ),
            array(
                "itemId" => "show-err-keiyaku-to"
                , "itemName" => "契約日2"
                , "types" => array(ValidateUtil::_IS_DATE)
                , "data" => $params["prj_keiyaku_bi_to"]
            ),
            array(
                "itemId" => "show-err-gencho-from"
                , "itemName" => "現調日1"
                , "types" => array(ValidateUtil::_IS_DATE)
                , "data" => $params["prj_gencho_bi_from"]
            ),
            array(
                "itemId" => "show-err-gencho-to"
                , "itemName" => "現調日2"
                , "types" => array(ValidateUtil::_IS_DATE)
                , "data" => $params["prj_gencho_bi_to"]
            ),
            array(
                "itemId" => "show-err-kanko-from"
                , "itemName" => "完工日1"
                , "types" => array(ValidateUtil::_IS_DATE)
                , "data" => $params["prj_kanko_bi_from"]
            ),
            array(
                "itemId" => "show-err-kanko-to"
                , "itemName" => "完工日2"
                , "types" => array(ValidateUtil::_IS_DATE)
                , "data" => $params["prj_kanko_bi_to"]
            ),
            array(
                "itemId" => "show-err-renkei-from"
                , "itemName" => "連系日1"
                , "types" => array(ValidateUtil::_IS_DATE)
                , "data" => $params["prj_renkei_bi_from"]
            ),
            array(
                "itemId" => "show-err-renkei-to"
                , "itemName" => "連系日2"
                , "types" => array(ValidateUtil::_IS_DATE)
                , "data" => $params["prj_renkei_bi_to"]
            ),
        );
        $this->validate->validates($validateOpts);
        return !$this->validate->hasError();
    }

    public function cal() {
        $project = new MProjectDao();

        $currentmonth = ParamsUtil::getQueryParamNumeric("curentmonth");
        $curentyear = ParamsUtil::getQueryParamNumeric("curentyear");
        $type = ParamsUtil::getQueryParam("type");
        $month = date("m");
        $year = date("Y");
        if(!StringUtil::isNullOrEmpty($type)||!StringUtil::isNullOrEmpty($curentmonth)||!StringUtil::isNullOrEmpty($curentyear)){
        	if($type=="next"){
        		$action = '+';
        	}
        	elseif($type=="preview"){
        		$action = '-';
        	}
        	else{
        		ActionUtil::redirect(PageIdConstants::PROJECT,'cal');
        	}
        	if($currentmonth < 10)
        		$currentmonth = '0'.$currentmonth;
        	$date = DateUtil::SubAddMonth($curentyear."-".$currentmonth."-01",$action,1);
        	$month = explode('-', $date);
            $month = $month[1];
        	$year =  explode('-', $date);
            $year = $year[0];
        }
        /*check authority data*/
        $staff_id = null;
        $role = $this->role;
        if(!in_array(4,$role) || !in_array(5,$role))//if not 案件管理 you need assign
        {
            $staff_id = $this->login_id;
        }
        $dsprj_gencho_bi = $project->getSchedule($month, $year, 'prj_gencho_bi', $staff_id);
        $dsprj_koji_kaishi_bi = $project->getSchedule($month, $year, 'prj_koji_kaishi_bi', $staff_id);
        $dsprj_renkei_bi = $project->getSchedule($month, $year, 'prj_renkei_bi', $staff_id);
        $dsprj_kanko_bi = $project->getSchedule($month, $year, 'prj_kanko_bi', $staff_id);

        $this->setAttribute("month", $month);
        $this->setAttribute("year", $year);
        $this->setAttribute("dsprj_gencho_bi", $dsprj_gencho_bi);
        $this->setAttribute("dsprj_koji_kaishi_bi", $dsprj_koji_kaishi_bi);
        $this->setAttribute("dsprj_renkei_bi", $dsprj_renkei_bi);
        $this->setAttribute("dsprj_kanko_bi", $dsprj_kanko_bi);
        $this->setView("cal.php");
    }

    public function getProjectStatusHistory($Id) {
        $ProjecStatustHistoryDao = new MProjectStatusHistoryDao();
        return $ProjecStatustHistoryDao->getStatusHistoryByProjectId($Id);
    }
    
    public function insertPrjStatusHistory($projectId, $StatusId) {
        $result = true;
        $projectDao = new MProjectDao();
        $project = $projectDao->getById($projectId);
        if ($project['prj_status'] != $StatusId) {
            $ProjectHistoryDao = new MProjectStatusHistoryDao();
            $params_status = array(
                'prj_id' => $projectId
                , 'prj_status' => $project['prj_status']
                , 'prj_status_updated_date' => DateUtil::getCurrentDatetime()
            );
            $id = $ProjectHistoryDao->insert($params_status);
            if($id < 0)
                $result = false;
        }
        return $result;
    }

    public function getProjectStatusByProjectId($projectId) {
        $ProjecStatustHistoryDao = new MProjectStatusHistoryDao();
        return $ProjecStatustHistoryDao->getByProjectId($projectId);
    }

    public function insertFileHistory($params) {
        $model = new MFileHistoryDao();
        $id = $model->insert($params);
        if($id > 0)
            return true;
        return false;
    }

    public function insertAndUpdatePrjProdInfo($params) {
        $model = new MPrjProdDao();
        return $model->doInsertUpdate($params);
    }

    public function insertAndUpdatePrjPaymentInfo($params) {
        $model = new MPrjPaymentInfoDao();
        return $model->doInsertUpdate($params);
    }

    public function insertPrjAssignInfo($params) {
        $model = new MPrjAssignInfoDao();
        return $model->doInsert($params);
    }

    //return null or data of table prj_file_history by prj_id and prj_file_type
    public function getHistoryFileData($prj_file_type, $prj_id) {
        if (!StringUtil::isNullOrEmpty($prj_id)) {
            $model = new MFileHistoryDao();
            $sortCondition = ' ORDER BY IFNULL(prj_file_history.updated_time, prj_file_history.created_time) DESC';
            $params = array(
                'prj_file_type' => $prj_file_type,
                'prj_id' => $prj_id
            );
            return $model->selectTable($params,$sortCondition);
        }
        return null;
    }

    public function getParamsArray($staff_role) {
        $role_id = ArrayUtil::getValueOfArray($staff_role,'role_id');
        $paramsArray = array(
            "prj_id"
            , "prj_status"
            , "prj_maker"
            , "prj_cust_name"
            , "prj_cust_pos_code"
            , "prj_cust_pos_code1"
            , "prj_cust_pos_code2"
            , "prj_cust_prefectures"
            , "prj_cust_city"
            , "prj_cust_address"
            , "prj_cust_mansion_info"
            , "prj_cust_ins_loc_pos_code"
            , "prj_cust_ins_loc_pos_code1"
            , "prj_cust_ins_loc_pos_code2"
            , "prj_cust_ins_loc_prefectures"
            , "prj_cust_ins_loc_city"
            , "prj_cust_ins_loc_address"
            , "prj_cust_ins_loc_mansion_info"
            , "prj_cust_phone_num"
            , "prj_cust_email"
            , "prj_cust_memo"
            , "prj_kind_contract"
            , "prj_kind_garage"
            , "prj_kind_pv"
            , "prj_kind_od"
            , "prj_gencho_bi"
            , "prj_keiyaku_bi"
            , "prj_koji_kaishi_bi"
            , "prj_setsubi_nintei_shinsei_bi1"
            , "prj_setsubi_nintei_shinsei_bi2"
            , "prj_setsubi_nintei_shinsei_bi3"
            , "prj_uchi_ochi_yotei_bi"
            , "prj_uchi_ochi_kakutei_bi"
            , "prj_renkei_bi"
            , "prj_renkei_done"
            , "prj_kanko_bi"
            , "prj_setchi_hiyo_nenpo_shinsei_bi"
            , "prj_unten_hiyo_nenpo_shinsei_bi"
            , "prj_kyanceru_bi"
            , "prj_file_shubetsu"
            , "prj_file_file_name1_tmp"
            , "prj_file_file_name1_tmp_recent"
            , "prj_file_file_name1_recent_name"
            , "prj_file_file_name2_tmp"
            , "prj_file_file_name2_tmp_recent"
            , "prj_file_file_name2_recent_name"
            , "notsavehistory"
            /* fragment2 */
            , 'prj_prod_price_selling_total'
            , 'prj_prod_price_part_total'
            , 'prj_prod_checklist'
            , 'prj_prod_notices'
            /* end fragment2 */

            , 'prj_pay_remain'
            /*to set tab opening*/
            , 'open_tab'
            , 'deleted_flag'
            , "created_user"
            , "created_time"
            , "updated_user"
            , "updated_time"
            , "prj_updated_time"
            , "progress_updated_time"
        );
        /* fragment2 */
            $params_fragment2 = array(
            );
            for ($i = 1; $i <= 25; $i++) {
                if ($i <= 3) {
                    array_push($params_fragment2, 'prj_prod_kw' . $i);
                }
                if ($i <= 22) {
                    array_push($params_fragment2, 'prj_prod_type_row' . $i);
                    array_push($params_fragment2, 'prj_prod_maker_row' . $i);
                }
                array_push($params_fragment2, 'prj_prod_info_id' . $i);
                array_push($params_fragment2, 'prj_prod_info_updated_time' . $i);
                array_push($params_fragment2, 'prj_prod_class_nm_row' . $i);
                array_push($params_fragment2, 'prj_prod_model_row' . $i);

                array_push($params_fragment2, 'prj_prod_num_row' . $i);
                array_push($params_fragment2, 'prj_prod_unit_price_selling_row' . $i);
                array_push($params_fragment2, 'prj_prod_price_selling_row' . $i);
                if(in_array(5, $role_id)){
                    //user_role = 5 = "案件管理 [管理者向け]（仕切値閲覧・修正可）"
                    array_push($params_fragment2, 'prj_prod_unit_price_part_row' . $i);
                    array_push($params_fragment2, 'prj_prod_price_part_row' . $i);
                }
                array_push($params_fragment2, 'prj_prod_memo_row' . $i);
            }
        /* end fragment2 */
        /* fragment 3 */
            $params_fragment3 = array(
                'prj_prod_price_selling_total'
                , 'prj_pay_method'
            );
            for ($i = 1; $i <= 6; $i++) {
                array_push($params_fragment3, "prj_billing_date$i");
                array_push($params_fragment3, "prj_paid_date$i");
                array_push($params_fragment3, "prj_plan_paid_amount$i");
                array_push($params_fragment3, "prj_plan_pay_amount$i");
                array_push($params_fragment3, "prj_plan_pay_memo$i");
                array_push($params_fragment3, "prj_plan_paid_memo$i");
                array_push($params_fragment3, "prj_plan_pay_deposit$i");
                array_push($params_fragment3, "prj_plan_pay_day$i");
                array_push($params_fragment3, "prj_plan_pay_per$i");
                array_push($params_fragment3, "prj_payment_info_id$i");
                array_push($params_fragment3, "prj_payment_info_updated_time$i");
            }
        /* end fragment 3 */
        /* fragment 4 */
            $params_fragment4 = array();
            for ($i = 1; $i <= count(AppConfig::$STAFF_POS); $i++) {
                array_push($params_fragment4, "prj_staff_id$i");
                array_push($params_fragment4, "prj_assign_info_id$i");
                array_push($params_fragment4, "prj_assign_info_updated_time$i");
            }
        /* end fragment 4 */
        /* fragment 5*/
            $params_fragment5 = array(
                'prj_progress_info_prj_id'
                ,'prj_prg_eq_accre_id'
                ,'prj_prg_cust_login_id'
                ,'prj_prg_cust_login_passw'
                ,'prj_prg_tepco_num1'
                ,'prj_prg_tepco_num2'
                ,'prj_prg_update_date'
                ,'prj_prg_module'
                ,'prj_prg_module_num'
                ,'prj_prg_pcs1'
                ,'prj_prg_pcs1_num'
                ,'prj_prg_pcs2'
                ,'prj_prg_pcs2_num'
                ,'prj_prg_sum_exp'
                ,'prj_prg_appl_out'
                ,'prj_prg_eq_cer_appl_date'
                ,'prj_prg_el_recept_recv_date'
                ,'prj_prg_eq_acc_res_date'
                ,'prj_prg_cons_grant_cal_date'
                ,'prj_prg_cons_grant'
                ,'prj_prg_cons_grant_pay_date'
                ,'prj_prg_meter_fee'
                ,'prj_prg_conn_cons_appl_date'
                ,'prj_prg_conn_cons_res_date'
                ,'prj_prg_eq_cer_req'
                ,'prj_prg_appl_date'
                ,'prj_prg_elec_use_appl_date'
                ,'prj_prg_cons_amount'
                ,'prj_prg_tokyo_supply_demand'
                ,'prj_prg_cons_grant_pay_date2'
                ,'prj_prg_coop_pros'
                ,'prj_prg_note'
                ,'prj_prg_remark'
            );
        /* end fragment 5*/
        $paramsArray = array_merge($params_fragment2, $params_fragment3, $params_fragment4, $params_fragment5, $paramsArray);
        return $paramsArray;
    }

    public function getValidateOptsFragment2($params) {
        $validateOptsFragment2 = array(
        );
        for ($i = 1; $i <= 25; $i++) {
            $prj_prod_class_nm = array(
                "itemId" => "prj_prod_class_nm$i"
                , "itemName" => "商品名$i"
                , "types" => array(ValidateUtil::_IS_MAX)
                , "data" => $params["prj_prod_class_nm$i"]
                , "max" => 250
            );
            $prj_prod_type_row = array(
                "itemId" => "prj_prod_type_row$i"
                , "itemName" => "商品名$i"
                , "types" => array(ValidateUtil::_IS_NUM)
                , "data" => $params["prj_prod_type_row$i"]
            );
            $prj_prod_type_row_required_on_prj_prod_num = array();
            if($i >= 1 && $i < 23 && !StringUtil::isNullOrEmpty($params["prj_prod_num_row$i"])){
              $prj_prod_type_row_required_on_prj_prod_num = array(
                    "itemId" => "prj_prod_type_row$i"
                    , "itemName" => "商品名$i"
                    , "types" => array(ValidateUtil::_IS_NULL)
                    , "data" => $params["prj_prod_type_row$i"]
                );  
            }
            $prj_prod_maker_row = array(
                "itemId" => "prj_prod_maker_row$i"
                , "itemName" => "メーカー$i"
                , "types" => array(ValidateUtil::_IS_NUM)
                , "data" => $params["prj_prod_maker_row$i"]
            );
            $prj_prod_model_row = array(
                "itemId" => "prj_prod_model_row$i"
                , "itemName" => "型式$i"
                , "types" => array(ValidateUtil::_IS_MAX)
                , "data" => $params["prj_prod_model_row$i"]
                , "max" => 250
            );
            $prj_prod_num_row = array(
                "itemId" => "prj_prod_num_row$i"
                , "itemName" => "個数$i"
                , "types" => array(ValidateUtil::_IS_NUM)
                , "data" => $params["prj_prod_num_row$i"]
            );
            $prj_prod_unit_price_selling_row = array(
                "itemId" => "prj_prod_unit_price_selling_row$i"
                , "itemName" => "販売単価$i"
                , "types" => array(ValidateUtil::_IS_NUM)
                , "data" => $params["prj_prod_unit_price_selling_row$i"]
            );
            $prj_prod_price_selling_row = array(
                "itemId" => "prj_prod_price_selling_row$i"
                , "itemName" => "販売金額$i"
                , "types" => array(ValidateUtil::_IS_NUM)
                , "data" => $params["prj_prod_price_selling_row$i"]
            );
            $prj_prod_unit_price_part_row = array(
                "itemId" => "prj_prod_unit_price_part_row$i"
                , "itemName" => "仕切単価$i"
                , "types" => array(ValidateUtil::_IS_NUM)
                , "data" => $params["prj_prod_unit_price_part_row$i"]
            );
            $prj_prod_price_part_row = array(
                "itemId" => "prj_prod_price_part_row$i"
                , "itemName" => "仕切り金額$i"
                , "types" => array(ValidateUtil::_IS_NUM)
                , "data" => $params["prj_prod_price_part_row$i"]
            );
            $prj_prod_memo_row = array(
                "itemId" => "prj_prod_memo_row$i"
                , "itemName" => "備考$i"
                , "types" => array(ValidateUtil::_IS_MAX)
                , "data" => $params["prj_prod_memo_row$i"]
                , "max" => 250
            );
            if ($i >= 17 && $i <= 22) {
                $prj_prod_class_nm_row = array(
                    "itemId" => "prj_prod_class_nm_row$i"
                    , "itemName" => "商品名$i"
                    , "types" => array(ValidateUtil::_IS_MAX)
                    , "data" => $params["prj_prod_class_nm_row$i"]
                    , "max" => 250
                );
                array_push($validateOptsFragment2, $prj_prod_class_nm_row);
            }
            if ($i <= 3) {
                $prj_prod_kw = array(
                    "itemId" => "prj_prod_kw$i"
                    , "itemName" => "Kw$i"
                    , "types" => array(ValidateUtil::_IS_NUM)
                    , "data" => $params["prj_prod_kw$i"]
                );
                array_push($validateOptsFragment2, $prj_prod_kw);
            }
            array_push(
                    $validateOptsFragment2, $prj_prod_class_nm, $prj_prod_type_row, $prj_prod_type_row_required_on_prj_prod_num, $prj_prod_maker_row, $prj_prod_model_row, $prj_prod_num_row, $prj_prod_unit_price_selling_row, $prj_prod_price_selling_row, $prj_prod_unit_price_part_row, $prj_prod_price_part_row, $prj_prod_memo_row
            );
        }
        return $validateOptsFragment2;
    }

    public function getValidateOptsFragment3($params) {
        $validateOptsFragment3 = array(
            array(
                "itemId" => "prj_pay_method"
                , "itemName" => "支払い方法"
                , "types" => array(ValidateUtil::_IS_NUM)
                , "data" => $params["prj_pay_method"]
            )
        );
        for ($i = 1; $i <= 6; $i++) {
            $prj_billing_date = array(
                "itemId" => "show-message-cal-bi$i"
                , "itemName" => "請求日$i"
                , "types" => array(ValidateUtil::_IS_DATE)
                , "data" => $params["prj_billing_date$i"]
            );
            $prj_plan_pay_day = array(
                "itemId" => "prj_plan_pay_day$i"
                , "itemName" => "支払い予定日：請求日の$i"
                , "types" => array(ValidateUtil::_IS_NUM)
                , "data" => $params["prj_plan_pay_day$i"]
            );

            $prj_paid_date_required_on_prj_plan_paid_amount = array();
            if(!empty($params["prj_plan_paid_amount$i"])){
                $prj_paid_date_required_on_prj_plan_paid_amount = array(
                    "itemId" => "prj_paid_date$i"
                    , "itemName" => "支払済日$i"
                    , "types" => array(ValidateUtil::_IS_NULL)
                    , "data" => $params["prj_paid_date$i"]
                );
            }

            $prj_paid_date = array(
                "itemId" => "show_cal_message$i"
                , "itemName" => "支払済日$i"
                , "types" => array(ValidateUtil::_IS_DATE)
                , "data" => $params["prj_paid_date$i"]
            );

            $prj_plan_pay_amount = array(
                "itemId" => "prj_plan_pay_amount$i"
                , "itemName" => "支払予定金額$i"
                , "types" => array(ValidateUtil::_IS_NUM)
                , "data" => $params["prj_plan_pay_amount$i"]
            );

            /*$prj_plan_pay_per = array(
                "itemId" => "prj_plan_pay_per$i"
                , "itemName" => "支払予定金額$i"
                , "types" => array(ValidateUtil::_IS_NUM)
                , "data" => $params["prj_plan_pay_per$i"]
            );*/
            $prj_plan_pay_memo = array(
                "itemId" => "prj_plan_pay_memo$i"
                , "itemName" => "支払予定金額 メモ$i"
                , "types" => array(ValidateUtil::_IS_MAX)
                , "data" => $params["prj_plan_pay_memo$i"]
                , "max" => 250
            );
            $prj_plan_paid_amount = array(
                "itemId" => "prj_plan_paid_amount$i"
                , "itemName" => "支払済金額$i"
                , "types" => array(ValidateUtil::_IS_NUM)
                , "data" => $params["prj_plan_paid_amount$i"]
            );
            $prj_plan_paid_memo = array(
                "itemId" => "prj_plan_paid_memo$i"
                , "itemName" => "支払済金額 メモ$i"
                , "types" => array(ValidateUtil::_IS_MAX)
                , "data" => $params["prj_plan_paid_memo$i"]
                , "max" => 250
            );
            array_push(
                    $validateOptsFragment3, $prj_billing_date, $prj_plan_pay_day, $prj_paid_date, $prj_paid_date_required_on_prj_plan_paid_amount,$prj_plan_pay_amount,
                    $prj_plan_pay_per, $prj_plan_pay_memo, $prj_plan_paid_amount, $prj_plan_paid_memo
            );
        }
        return $validateOptsFragment3;
    }

    public function getValidateOptsFragment4($params,$firstrow,$secondrow,$thirtrow){
        $validateOptsFragment4 = array();
        $array = array();
        for($j=1;$j<=3;$j++){
            switch ($j){
                case 1:
                    $lenght = $firstrow;
                    $start = 1;
                break;
                case 2:
                    $lenght = $secondrow;
                    $start = $firstrow + 1;
                break;
                case 3:
                    $lenght = $thirtrow;
                    $start = $firstrow + $secondrow + 1;
                break;
            }
            $array = array();
            for($i=0;$i<$lenght;$i++){
                $array[] = $params['prj_staff_id' . ($i + $start)];
            }
            $postion_error = $this->getPositionExist($array,$start);
            if ($postion_error != 0)
            {
                
                $this->validate->addError(
                    $this->validate->messageFormat(MessageConstants::COM_ERR_DUPLICATE, array('担当者'.$postion_error)),
                    "prj_staff_id" . $postion_error
                );
            }
        }
    }

    public function getValidateOptsFragment5($params){
        $validateOptsFragment5 = array(
            array(
                "itemId" => "prj_prg_eq_accre_id"
                , "itemName" => "設備認定ID"
                , "types" => array(ValidateUtil::_IS_MAX)
                , "data" => $params["prj_prg_eq_accre_id"]
                , "max" => 250
            )
            ,array(
                "itemId" => "prj_prg_cust_login_id"
                , "itemName" => "お客様ログインID"
                , "types" => array(ValidateUtil::_IS_MAX)
                , "data" => $params["prj_prg_cust_login_id"]
                , "max" => 250
            )
            ,array(
                "itemId" => "prj_prg_cust_login_passw"
                , "itemName" => "お客様ログインパスワード"
                , "types" => array(ValidateUtil::_IS_MAX)
                , "data" => $params["prj_prg_cust_login_passw"]
                , "max" => 250
            )
            ,array(
                "itemId" => "prj_prg_tepco_num1"
                , "itemName" => "東京電力申込番号1"
                , "types" => array(ValidateUtil::_IS_MAX)
                , "data" => $params["prj_prg_tepco_num1"]
                , "max" => 10
            )
            ,array(
                "itemId" => "prj_prg_tepco_num2"
                , "itemName" => "東京電力申込番号2"
                , "types" => array(ValidateUtil::_IS_MAX)
                , "data" => $params["prj_prg_tepco_num2"]
                , "max" => 10
            )
            ,array(
                "itemId" => "prj_prg_update_date_msg"
                , "itemName" => "更新日"
                , "types" => array(ValidateUtil::_IS_DATE)
                , "data" => $params["prj_prg_update_date"]
            )
            ,array(
                "itemId" => "prj_prg_module"
                , "itemName" => "モジュール"
                , "types" => array(ValidateUtil::_IS_MAX)
                , "data" => $params["prj_prg_module"]
                , "max" => 250
            )
            ,array(
                "itemId" => "prj_prg_module_num"
                , "itemName" => "モジュール枚数"
                , "types" => array(ValidateUtil::_IS_MAX)
                , "data" => $params["prj_prg_module_num"]
                , "max" => 250
            )
            ,array(
                "itemId" => "prj_prg_pcs1"
                , "itemName" => "PCS1"
                , "types" => array(ValidateUtil::_IS_MAX)
                , "data" => $params["prj_prg_pcs1"]
                , "max" => 250
            )
            ,array(
                "itemId" => "prj_prg_pcs1_num"
                , "itemName" => "PCS1台数"
                , "types" => array(ValidateUtil::_IS_MAX)
                , "data" => $params["prj_prg_pcs1_num"]
                , "max" => 250
            )
            ,array(
                "itemId" => "prj_prg_pcs2"
                , "itemName" => "PCS2"
                , "types" => array(ValidateUtil::_IS_MAX)
                , "data" => $params["prj_prg_pcs2"]
                , "max" => 250
            )
            ,array(
                "itemId" => "prj_prg_pcs2_num"
                , "itemName" => "PCS2台数"
                , "types" => array(ValidateUtil::_IS_MAX)
                , "data" => $params["prj_prg_pcs2_num"]
                , "max" => 250
            )
            ,array(
                "itemId" => "prj_prg_sum_exp"
                , "itemName" => "合計出力"
                , "types" => array(ValidateUtil::_IS_MAX)
                , "data" => $params["prj_prg_sum_exp"]
                , "max" => 250
            )
            ,array(
                "itemId" => "prj_prg_appl_out"
                , "itemName" => "申請出力"
                , "types" => array(ValidateUtil::_IS_MAX)
                , "data" => $params["prj_prg_appl_out"]
                , "max" => 250
            )
            ,array(
                "itemId" => "prj_prg_eq_cer_appl_date_msg"
                , "itemName" => "設備認定申請日"
                , "types" => array(ValidateUtil::_IS_DATE)
                , "data" => $params["prj_prg_eq_cer_appl_date"]
            )
            ,array(
                "itemId" => "prj_prg_el_recept_recv_date_msg"
                , "itemName" => "電力受給受付日"
                , "types" => array(ValidateUtil::_IS_DATE)
                , "data" => $params["prj_prg_el_recept_recv_date"]
            )
            ,array(
                "itemId" => "prj_prg_eq_acc_res_date_msg"
                , "itemName" => "設備認定回答日"
                , "types" => array(ValidateUtil::_IS_DATE)
                , "data" => $params["prj_prg_eq_acc_res_date"]
            )
            ,array(
                "itemId" => "prj_prg_cons_grant_cal_date_msg"
                , "itemName" => "工事負担金算出日"
                , "types" => array(ValidateUtil::_IS_DATE)
                , "data" => $params["prj_prg_cons_grant_cal_date"]
            )
            ,array(
                "itemId" => "prj_prg_cons_grant"
                , "itemName" => "工事負担金"
                , "types" => array(ValidateUtil::_IS_MAX)
                , "data" => $params["prj_prg_cons_grant"]
                , "max" => 250
            )
            ,array(
                "itemId" => "prj_prg_cons_grant_pay_date_msg"
                , "itemName" => "工事負担金支払日"
                , "types" => array(ValidateUtil::_IS_DATE)
                , "data" => $params["prj_prg_cons_grant_pay_date"]
            )
            ,array(
                "itemId" => "prj_prg_meter_fee"
                , "itemName" => "メーター代"
                , "types" => array(ValidateUtil::_IS_MAX)
                , "data" => $params["prj_prg_meter_fee"]
                , "max" => 250
            )
            ,array(
                "itemId" => "prj_prg_conn_cons_appl_date_msg"
                , "itemName" => "接続検討申請日"
                , "types" => array(ValidateUtil::_IS_DATE)
                , "data" => $params["prj_prg_conn_cons_appl_date"]
            )
            ,array(
                "itemId" => "prj_prg_conn_cons_res_date_msg"
                , "itemName" => "接続検討回答日"
                , "types" => array(ValidateUtil::_IS_DATE)
                , "data" => $params["prj_prg_conn_cons_res_date"]
            )
            ,array(
                "itemId" => "prj_prg_eq_cer_req"
                , "itemName" => "設備認定条件付き"
                , "types" => array(ValidateUtil::_IS_MAX)
                , "data" => $params["prj_prg_eq_cer_req"]
                , "max" => 250
            )
            ,array(
                "itemId" => "prj_prg_appl_date_msg"
                , "itemName" => "本申込み日"
                , "types" => array(ValidateUtil::_IS_DATE)
                , "data" => $params["prj_prg_appl_date"]
            )
            ,array(
                "itemId" => "prj_prg_elec_use_appl_date_msg"
                , "itemName" => "工事負担金額"
                , "types" => array(ValidateUtil::_IS_DATE)
                , "data" => $params["prj_prg_elec_use_appl_date"]
            )
            ,array(
                "itemId" => "prj_prg_cons_amount"
                , "itemName" => "設備認定回答日"
                , "types" => array(ValidateUtil::_IS_MAX)
                , "data" => $params["prj_prg_cons_amount"]
                , "max" => 250
            )
            ,array(
                "itemId" => "prj_prg_tokyo_supply_demand_msg"
                , "itemName" => "東京電力電力需給"
                , "types" => array(ValidateUtil::_IS_DATE)
                , "data" => $params["prj_prg_tokyo_supply_demand"]
            )
            ,array(
                "itemId" => "prj_prg_cons_grant_pay_date2_msg"
                , "itemName" => "工事負担金支払い日"
                , "types" => array(ValidateUtil::_IS_DATE)
                , "data" => $params["prj_prg_cons_grant_pay_date2"]
            )
            ,array(
                "itemId" => "prj_prg_coop_pros"
                , "itemName" => "連携見込み"
                , "types" => array(ValidateUtil::_IS_MAX)
                , "data" => $params["prj_prg_coop_pros"]
                , "max" => 250
            )
            ,array(
                "itemId" => "prj_prg_note"
                , "itemName" => "メモ欄"
                , "types" => array(ValidateUtil::_IS_MAX)
                , "data" => $params["prj_prg_note"]
                , "max" => 250
            )
            ,array(
                "itemId" => "prj_prg_remark"
                , "itemName" => "備考欄"
                , "types" => array(ValidateUtil::_IS_MAX)
                , "data" => $params["prj_prg_remark"]
                , "max" => 5000
            )
        );
        return $validateOptsFragment5;
    }

    public function convertDateRegist($params){
        /*tab1*/
        if($params['prj_gencho_bi'] == '0/0/0')
            $params['prj_gencho_bi'] = null;
        if($params['prj_keiyaku_bi'] == '0/0/0')
            $params['prj_keiyaku_bi'] = null;
        if($params['prj_koji_kaishi_bi'] == '0/0/0')
            $params['prj_koji_kaishi_bi'] = null;
        if($params['prj_setsubi_nintei_shinsei_bi1'] == '0/0/0')
            $params['prj_setsubi_nintei_shinsei_bi1'] = null;
        if($params['prj_setsubi_nintei_shinsei_bi2'] == '0/0/0')
            $params['prj_setsubi_nintei_shinsei_bi2'] = null;
        if($params['prj_setsubi_nintei_shinsei_bi3'] == '0/0/0')
            $params['prj_setsubi_nintei_shinsei_bi3'] = null;
        if($params['prj_uchi_ochi_yotei_bi'] == '0/0/0')
            $params['prj_uchi_ochi_yotei_bi'] = null;
        if($params['prj_uchi_ochi_kakutei_bi'] == '0/0/0')
            $params['prj_uchi_ochi_kakutei_bi'] = null;
        if($params['prj_renkei_bi'] == '0/0/0')
            $params['prj_renkei_bi'] = null;
        if($params['prj_kanko_bi'] == '0/0/0')
            $params['prj_kanko_bi'] = null;
        if($params['prj_setchi_hiyo_nenpo_shinsei_bi'] == '0/0/0')
            $params['prj_setchi_hiyo_nenpo_shinsei_bi'] = null;
        if($params['prj_unten_hiyo_nenpo_shinsei_bi'] == '0/0/0')
            $params['prj_unten_hiyo_nenpo_shinsei_bi'] = null;
        if($params['prj_kyanceru_bi'] == '0/0/0')
            $params['prj_kyanceru_bi'] = null;
        /*end tab1*/
        /*tab3*/
        for ($i = 1; $i <= 6; $i++) {
            if($params["prj_billing_date$i"]=='0/0/0')
                $params["prj_billing_date$i"] = null;
            if($params["prj_paid_date$i"]=='0/0/0')
                $params["prj_paid_date$i"] = null;
        }
        /*end tab3*/
        /*tab5*/
        if($params['prj_prg_update_date']=='0/0/0')
            $params['prj_prg_update_date'] = null;
        if($params['prj_prg_eq_cer_appl_date']=='0/0/0')
            $params['prj_prg_eq_cer_appl_date'] = null;
        if($params['prj_prg_el_recept_recv_date']=='0/0/0')
            $params['prj_prg_el_recept_recv_date'] = null;
        if($params['prj_prg_eq_acc_res_date']=='0/0/0')
            $params['prj_prg_eq_acc_res_date'] = null;
        if($params['prj_prg_cons_grant_cal_date']=='0/0/0')
            $params['prj_prg_cons_grant_cal_date'] = null;
        if($params['prj_prg_cons_grant_pay_date']=='0/0/0')
            $params['prj_prg_cons_grant_pay_date'] = null;
        if($params['prj_prg_conn_cons_appl_date']=='0/0/0')
            $params['prj_prg_conn_cons_appl_date'] = null;
        if($params['prj_prg_conn_cons_res_date']=='0/0/0')
            $params['prj_prg_conn_cons_res_date'] = null;
        if($params['prj_prg_appl_date']=='0/0/0')
            $params['prj_prg_appl_date'] = null;
        if($params['prj_prg_elec_use_appl_date']=='0/0/0')
            $params['prj_prg_elec_use_appl_date'] = null;
        if($params['prj_prg_tokyo_supply_demand']=='0/0/0')
            $params['prj_prg_tokyo_supply_demand'] = null;
        if($params['prj_prg_cons_grant_pay_date2']=='0/0/0')
            $params['prj_prg_cons_grant_pay_date2'] = null;
        /*end tab5*/
        return $params;
    }

    public function getPositionExist($array, $startnum){
        $idcheck = '';
        $position = 0;
        foreach ($array as $key => $item){
            $arrcheck = $array;
            if (StringUtil::isNullOrEmpty($item))
                continue;
            unset($arrcheck[$key]);
            if (in_array($item,$arrcheck)){
                $position = $startnum + $key;
            }
            
            
        }
        return $position;
    }

    public function getMPrjProdbyPrjId($Id) {
        $prjprod = new MPrjProdDao();
        return $prjprod->getByPrjId($Id);
    }

    public function getMPrjPaymentbyPrjId($Id) {
        $model = new MPrjPaymentInfoDao();
        return $model->getByPrjId($Id);
    }

    public function getMPjrAssignbyPrjId($Id, $prj_role_grp) {
        $model = new MPrjAssignInfoDao();
        return $model->getByPrjId($Id, $prj_role_grp);
    }

    public function deleteTmpFile($filename, $params, $tmp){
        if (!StringUtil::isNullOrEmpty($params[$filename.'_tmp'])) {
            if ($params[$filename.'_tmp_recent'] == "2") {
                $file_recent_path = $tmp . '/' . $params[$filename.'_tmp'];
                FileUploadUtil::delete($file_recent_path);
                $this->setViewState(array($fileName => null));
                $params[$filename] = null;
            }
            if ($params[$fileName.'_tmp_recent'] == "3") {
                $file_recent_path = $tmp . '/' . $params[$filename.'_tmp'];
                FileUploadUtil::delete($file_recent_path);
            }
        }
    }

    public function uploadFile($filename, &$params, $tmp, $extension, $itemName){
        $fileUpload = ParamsUtil::getPostFile($filename);
        if(!StringUtil::isNullOrEmpty($fileUpload['name']))//check input file is choose
        {
            $FileUploadResult = FileUploadUtil::uploadFile('project_doc', $fileUpload, $tmp, $extension);
            if (!ArrayUtil::isNullOrEmpty($FileUploadResult) && is_array($FileUploadResult)) {//success
                $this->setViewState(array($filename => $FileUploadResult["OldName"]));
                $this->setViewState(array($filename."_tmp" => $FileUploadResult["FileName"]));
                $params[$filename] = $FileUploadResult['OldName'];
                $params[$filename.'_tmp'] = $FileUploadResult['FileName'];
            } else{
                if($FileUploadResult == 1){
                    $this->validate->addError(
                        $this->validate->messageFormat(MessageConstants::COM_ERR_UPLOAD_FILE_ERR, array($itemName)),$filename.'_error'
                    );
                }
                elseif($FileUploadResult == 2){
                    $this->validate->addError(
                        $this->validate->messageFormat(MessageConstants::COM_ERR_UPLOAD_FILE_TYPE, array($itemName,ArrayUtil::ArrayToString($extension))),$filename.'_error'
                    );
                }
                elseif($FileUploadResult == 3){
                    $this->validate->addError(
                        $this->validate->messageFormat(MessageConstants::COM_ERR_MAX_UPLOAD_SIZE, array($itemName, AppConfig::$FILE_UPLOAD_MAX_SIZE )),$filename.'_error'
                    );
                }
            }
        }
        //check input file is choose from back or validate false
        elseif (!StringUtil::isNullOrEmpty($params[$filename.'_recent_name']) && $params[$filename.'_tmp_recent'] != "2") {
            $params[$filename] = $params[$filename.'_recent_name'];
            $this->setViewState(array($filename => $params[$filename]));
        }
    }

    public function sortAssignByPrjId($sort_id){
        $List_assign_info1 = $this->getMPjrAssignbyPrjId($sort_id, 1);
        $this->sortAssign($List_assign_info1);
        $List_assign_info2 = $this->getMPjrAssignbyPrjId($sort_id, 2);
        $this->sortAssign($List_assign_info2);
        $List_assign_info3 = $this->getMPjrAssignbyPrjId($sort_id, 3);
        $this->sortAssign($List_assign_info3);
    }

    public function sortAssign($List_assign_info){
        if (!ArrayUtil::isNullOrEmpty($List_assign_info)) {
            for ($i=0; $i < 4; $i++) { 
                if(!ArrayUtil::isNullOrEmpty($List_assign_info[$i]) && $List_assign_info[$i]['prj_staff_pos']!=$i+1)
                {
                    $this->updateAssign($List_assign_info[$i],$i+1);
                }
            }
        }
    }

    public function updateAssign($data, $pos){
        $model = new MPrjAssignInfoDao();
        $data['prj_staff_pos'] = $pos;
        $model->update(
            $data
            , array(
                "where" => "id = :id"
                , "params" => array("id" => $data['id'])
            )
        );
    }

    public function convertPrjProdFromDBtoView($prjprod){
        $dataPjrProd = array();
        if (!ArrayUtil::isNullOrEmpty($prjprod)) {
            for ($i = 1; $i <= count(AppConfig::$SORT_ID); $i++) {
                foreach ($prjprod as $value) {
                    if (AppConfig::$SORT_ID[$i][0] == $value['sort_id'] && AppConfig::$SORT_ID[$i][1] == $value['prj_prod_class']) {
                        if ($i >= 17 && $i <= 22)
                            $dataPjrProd["prj_prod_class_nm_row$i"] = $value['prj_prod_class_nm'];
                        else
                            $dataPjrProd["prj_prod_class_nm_row$i"] = $value['prj_prod_class'];
                        $dataPjrProd["prj_prod_info_id$i"]          = $value['id'];
                        $dataPjrProd["prj_prod_type_row$i"]         = $value['prj_prod_type'];
                        $dataPjrProd["prj_prod_maker_row$i"]        = $value['prj_prod_maker'];
                        $dataPjrProd["prj_prod_model_row$i"]        = $value['prj_prod_model'];
                        $dataPjrProd["prj_prod_num_row$i"]          = $value['prj_prod_num'];
                        $dataPjrProd["prj_prod_unit_price_selling_row$i"] = $value['prj_prod_unit_price_selling'];
                        $dataPjrProd["prj_prod_price_selling_row$i"]    = $value['prj_prod_price_selling'];
                        $dataPjrProd["prj_prod_unit_price_part_row$i"]  = $value['prj_prod_unit_price_part'];
                        $dataPjrProd["prj_prod_price_part_row$i"]       = $value['prj_prod_price_part'];
                        $dataPjrProd["prj_prod_kw$i"]                   = $value['prj_prod_kw'];
                        $dataPjrProd["prj_prod_memo_row$i"]             = $value['prj_prod_memo'];
                        $dataPjrProd["prj_prod_info_updated_time$i"]    = $value['updated_time'];
                        continue;
                    }
                }
            }
        }
        return $dataPjrProd;
    }

    //set Attribute data
    public function getData($prj_id = null) {
        $dataTable1 = null;
        $dataTable2 = null;
        $staff = new MStaffDao();
        if (!StringUtil::isNullOrEmpty($prj_id)) {
            $dataTable1 = $this->getHistoryFileData(AppConfig::$FILE_TYPE_DOCS, $prj_id);
            $dataTable2 = $this->getHistoryFileData(AppConfig::$FILE_TYPE_ESTIMATE, $prj_id);
            $dataTable3 = $this->getProgressUpdateByPrj($prj_id);
        }
        $ds = $staff->getAllStaff();
        $this->setAttribute("ds", $ds);
        $this->setAttribute("dataTable1", $dataTable1);
        $this->setAttribute("dataTable2", $dataTable2);
        $this->setAttribute("dataTable3", $dataTable3);
    }

    /*this function for insert table history update project infomation*/
    public function getAllDataOfProjectByProjectID($prj_id){
        $dataProject    = array();
        $projectDao     = new MProjectDao();
        $PrjProgressDao = new MPrjProgressDao();
        /*check authority data*/
        $role = $this->role;
        if(!in_array(4,$role) && !in_array(5,$role))//if not 案件管理 you need assign
        {
            $dataProject['project']  = $projectDao->getByIdWithAuthority($prj_id,  $this->login_id);
        }else{
            $dataProject['project']  = $projectDao->getById($prj_id);
        }
        if(!$dataProject['project'])
                return null;
        //$dataProject['project']                 = $projectDao->getById($prj_id, $params['role_required']);
        $dataProject['prjprod']                 = $this->getMPrjProdbyPrjId($prj_id);
        $dataProject['List_payment_info']       = $this->getMPrjPaymentbyPrjId($prj_id);
        $dataProject['List_assign_info1']       = $this->getMPjrAssignbyPrjId($prj_id, 1);
        $dataProject['List_assign_info2']       = $this->getMPjrAssignbyPrjId($prj_id, 2);
        $dataProject['List_assign_info3']       = $this->getMPjrAssignbyPrjId($prj_id, 3);
        $dataProject['project_progress']        = $PrjProgressDao->getById($prj_id);
        return $dataProject;
    }

    public function getPrjById($prj_id){
        $projectDao     =   new MProjectDao();
        return  $projectDao->getById($prj_id);
    }

    /*this function update table prj_info.prj_pay_completed_date*/
    public function updateProjectCompletedDate($prj_id,$array_payment_data){
        $prj_plan_pay_amount = 0;
        $prj_plan_paid_amount = 0;
        $prj_info = new MProjectDao();
        if(!ArrayUtil::isNullOrEmpty($array_payment_data)){//had at leave one pay
            $prj_paid_date_max = $array_payment_data[0]['prj_paid_date'];
            for ($i=0, $count = count($array_payment_data); $i < $count ; $i++) { 
                $prj_plan_pay_amount  += $array_payment_data[$i]['prj_plan_pay_amount'];
                $prj_plan_paid_amount += $array_payment_data[$i]['prj_plan_paid_amount'];
                if(DateUtil::CompareTwoDateString($prj_paid_date_max, $array_payment_data[$i]['prj_paid_date'],"<")){
                    $prj_paid_date_max = $array_payment_data[$i]['prj_paid_date'];
                }
            }
            if($prj_plan_pay_amount - $prj_plan_paid_amount <= 0){//compele pay
                $prj_paid_date_max = str_replace('/', '-', $prj_paid_date_max);
                $params_update_prj = array(
                    'prj_pay_completed_date' => $prj_paid_date_max,
                );
            }
            else{
                $params_update_prj = array(//not complete pay
                    'prj_pay_completed_date' => null,
                );
            }
        }else{
            $params_update_prj = array(//not have at leave one pay
                'prj_pay_completed_date' => null,
            );
        }
        return $prj_info->update(
            $params_update_prj
            ,array(
            "where" => "prj_id = :prj_id"
            , "params" => array("prj_id" => $prj_id)
            )
            ,false
        );
    }

    /*insert prj_shurui_appr_mgt width default data by prj_id*/
    public function insertShuriAppoveByPrjId($prj_id){
        $shuruiApprove = new MShuruiApproveDao();
        return $shuruiApprove->insertDefaultData($prj_id);
    }

    public function encodeItem($upd_item_id){
        for ($i=1; $i <=12 ; $i++) { 
            $upd_item_id[$i] = $this->jsonEncode($upd_item_id[$i]);
        }
        return $upd_item_id;
    }
    /*insert prj_update_history */
    public function insertHistory($prj_id, $params, $type, $prj_old=null){
        $result = false;
        $staff_id = $this->login_id;
        $upd_item_id = $this->getUpdItemId($params);
        $updateHistory = new MPrjUpdateHistoryDao();
        if($type == 'insert')
        {
            $upd_item_id_json = $this->encodeItem($upd_item_id);
            $result = $updateHistory->insertDefaultData($prj_id, $staff_id, $upd_item_id_json);
        }elseif ($type == 'update' && !ArrayUtil::isNullOrEmpty($prj_old)) {
            $projectDao      = new MProjectDao();
            $prj_prod_old    = $this->getMPrjProdbyPrjId($prj_id);
            $prj_prod_old    = $this->convertPrjProdFromDBtoView($prj_prod_old);
            $prj_prod_old['prj_keiyaku_bi']               = str_replace('-', '/', $prj_old['prj_keiyaku_bi']);
            $prj_prod_old['prj_prod_price_selling_total'] = $prj_old['prj_prod_price_selling_total'];
            $upd_item_id_old = $this->getUpdItemId($prj_prod_old);
            $upd_item_id_sts = $this->getUpdStatus($upd_item_id, $upd_item_id_old);

            $upd_item_id_json     = $this->encodeItem($upd_item_id);
            $upd_item_id_old_json = $this->encodeItem($upd_item_id_old);
            
            $result = $updateHistory->updateData($prj_id, $staff_id, $upd_item_id_json, $upd_item_id_old_json, $upd_item_id_sts);
        }else{
            $result = false;
        }
        return $result;
    }

    public function getUpdStatus($upd_item_id, $upd_item_id_old){
        $upd_sts = array();
        for ($i=1; $i <=12; $i++) { 
            $temp = array();
            $c1     = count($upd_item_id_old[$i]);
            $c2     = count($upd_item_id[$i]);
            $max    = max($c1, $c2);
            for ($j = 0; $j < $max; $j++) { 
                $temp[] = array_diff($upd_item_id[$i][$j],$upd_item_id_old[$i][$j]);
            }
            $upd_sts[$i] = 0;
            for ($k=0,$c_temp = count($temp); $k < $c_temp ; $k++) { 
                if(!empty($temp[$k])){
                    $upd_sts[$i] = 1;
                    continue;
                }
            }
        }
        return $upd_sts;
    }

    /* covert to an Array for insert data */
    public function getUpdItemId($params){
        $upd_item_id = array();
        $upd_item_id[1] = array(//契約日
            array(
                'prj_keiyaku_bi' => $params['prj_keiyaku_bi']
            )
        );
        $upd_item_id[2] = array(//モジュール
            array(
                'prj_prod_maker_row'  => $params['prj_prod_maker_row1']
                ,'prj_prod_model_row' => $params['prj_prod_model_row1']
            )
            ,array(
                'prj_prod_maker_row'  => $params['prj_prod_maker_row2']
                ,'prj_prod_model_row' => $params['prj_prod_model_row2']
            )
            ,array(
                'prj_prod_maker_row'  => $params['prj_prod_maker_row3']
                ,'prj_prod_model_row' => $params['prj_prod_model_row3']
            )
        );
        $upd_item_id[3] = array(//枚数
            array(
                'prj_prod_num_row' => $params['prj_prod_num_row1']
            )
            ,array(
                'prj_prod_num_row' => $params['prj_prod_num_row2']
            )
            ,array(
                'prj_prod_num_row' => $params['prj_prod_num_row3']
            )
        );
        $upd_item_id[4] = array(//設備容量
            array(
                'prj_prod_kw' => $params['prj_prod_kw1']
            )
            ,array(
                'prj_prod_kw' => $params['prj_prod_kw2']
            )
            ,array(
                'prj_prod_kw' => $params['prj_prod_kw3']
            )
        );
        $upd_item_id[5] = array(//パワコン型式
            array(
                'prj_prod_maker_row'  => $params['prj_prod_maker_row5']
                ,'prj_prod_model_row' => $params['prj_prod_model_row5'] 
            )
            ,array(
                'prj_prod_maker_row'  => $params['prj_prod_maker_row6']
                ,'prj_prod_model_row' => $params['prj_prod_model_row6'] 
            )
            ,array(
                'prj_prod_maker_row'  => $params['prj_prod_maker_row7']
                ,'prj_prod_model_row' => $params['prj_prod_model_row7'] 
            )
        );
        $upd_item_id[6] = array(//パワコン 台数
            array(
                'prj_prod_num_row' => $params['prj_prod_num_row5']
            )
            ,array(
                'prj_prod_num_row' => $params['prj_prod_num_row6']
            )
            ,array(
                'prj_prod_num_row' => $params['prj_prod_num_row7']
            )
        );
        $upd_item_id[7] = array(//接続箱型式
            array(
                'prj_prod_maker_row'  => $params['prj_prod_maker_row8']
                ,'prj_prod_model_row' => $params['prj_prod_model_row8'] 
            )
            ,array(
                'prj_prod_maker_row'  => $params['prj_prod_maker_row9']
                ,'prj_prod_model_row' => $params['prj_prod_model_row9'] 
            )
            ,array(
                'prj_prod_maker_row'  => $params['prj_prod_maker_row10']
                ,'prj_prod_model_row' => $params['prj_prod_model_row10'] 
            )
        );
        $upd_item_id[8] = array(//接続箱 台数
            array(
                'prj_prod_num_row' => $params['prj_prod_num_row8']
            )
            ,array(
                'prj_prod_num_row' => $params['prj_prod_num_row9']
            )
            ,array(
                'prj_prod_num_row' => $params['prj_prod_num_row10']
            )
        );
        $upd_item_id[9] = array(//モニター型式
            array(
                'prj_prod_maker_row'  => $params['prj_prod_maker_row11']
                ,'prj_prod_model_row' => $params['prj_prod_model_row11'] 
            )
            ,array(
                'prj_prod_maker_row'  => $params['prj_prod_maker_row12']
                ,'prj_prod_model_row' => $params['prj_prod_model_row12'] 
            )
        );
        $upd_item_id[10] = array(//モニター 台数
            array(
                'prj_prod_num_row' => $params['prj_prod_num_row11']
            )
            ,array(
                'prj_prod_num_row' => $params['prj_prod_num_row12']
            )
        );
        $upd_item_id[11] = array(//合計金額
            array(
                'prj_prod_price_selling_total' => $params['prj_prod_price_selling_total']
            )
        );
        for ($i=13; $i <= 22; $i++) { //その他
            $upd_item_id[12][] =  array(
                'prj_prod_maker_row'    =>  $params['prj_prod_maker_row'.$i]
                ,'prj_prod_model_row'   =>  $params['prj_prod_model_row'.$i]
                ,'prj_prod_num_row'     =>  $params['prj_prod_num_row'.$i]
            );
        }
        return $upd_item_id;
    }

    public function getProgressUpdateByPrj($prj_id){
        $prj_upd_his = new MPrjUpdateHistoryDao();
        return $prj_upd_his->getProgressUpdate($prj_id);
    }

    public function sendMail($staff_info, $prj_info, $type){
        if($type == 'insert')
        {
            /*MailUtil::sendMail(
                $staff_info['staff_email']
                ,"聖陽 WEB管理システム  {0} 様"
                ,AppConfig::$PROJECT_ADDED_MAIL
                ,array(
                    "subject"   => array("{0}"   => $staff_info['staff_name'])
                    , "body"    => array(
                        "{0}"   => $staff_info['staff_name']
                        ,"{1}"  => $prj_info['prj_cust_name']
                    )
                )
            );*/
        }
        elseif($type == 'update'){ 
            $updateHistory = new MPrjUpdateHistoryDao();
            $lastUpdate = $updateHistory->getLastHistoryByPrjId($prj_info['prj_id']);
            $item_change = array();
            for($i=0,$count = count($lastUpdate); $i<$count; $i++){
                if($lastUpdate[$i]['upd_sts'] == 1)
                    $item_change[] = AppConfig::$HISTORY_CHANGE[$lastUpdate[$i]['upd_item_id']];
            }
            if(!ArrayUtil::isNullOrEmpty($lastUpdate) && !ArrayUtil::isNullOrEmpty($item_change)){
                $item_change = implode(" \n", $item_change);
                MailUtil::sendMail(
                    $staff_info['staff_email']
                    ,AppConfig::$PROJECT_UPDATED_MAIL_TITLE
                    ,AppConfig::$PROJECT_UPDATED_MAIL
                    ,array(
                        /*"subject"   => array("{0}"   => $staff_info['staff_name'])*/
                        "body"    => array(
                            "{0}"   => $staff_info['staff_name']
                            ,"{2}"  => $prj_info['prj_cust_name']
                            ,"{1}"  => $prj_info['prj_id']
                            ,"{3}"  => $item_change
                        ) 
                    )
                );
            }
        }
    }

    public function sendMailCancel($project, $staff){
        MailUtil::sendMail(
            $staff['staff_email']
            ,AppConfig::$PROJECT_ADD_KYANCERUDATE_TITLE
            ,AppConfig::$PROJECT_ADD_KYANCERUDATE
            ,array(
                /*"subject"   => array("{0}"   => $project['prj_cust_name'])*/
                "body"    => array(
                    "{0}"   => $staff['staff_name'],
                    "{1}"   => $project['prj_id'],
                    "{2}"   => $project['prj_cust_name']
                ) 
            )
        );
    }

    public function sendMailChangeHistory($prj_id, $type){
        $dataSendMail = $this->getUserNeedSendMail($prj_id);
        $this->sendMail($dataSendMail['staff_inchange'], $dataSendMail['project'], $type);//send mail to inchange staff
        if(!ArrayUtil::isNullOrEmpty($dataSendMail['staff_inchange_sup']))
            $this->sendMail($dataSendMail['staff_inchange_sup'], $dataSendMail['project'], $type);//send mail to supervisor of inchange staff
        for($i = 0, $count = count($dataSendMail['staff_notify']); $i < $count; $i++){
            $this->sendMail($dataSendMail['staff_notify'][$i], $dataSendMail['project'], $type);
        }
    }

    public function sendMailCancelProject($prj_id){
        $dataSendMail = $this->getUserNeedSendMail($prj_id);
        $this->sendMailCancel($dataSendMail['project'],$dataSendMail['staff_inchange']);//send mail to inchange staff
        if(!ArrayUtil::isNullOrEmpty($dataSendMail['staff_inchange_sup']))
            $this->sendMailCancel($dataSendMail['project'], $dataSendMail['staff_inchange_sup']);   //send mail to supervisor of inchange staff
        for($i = 0, $count = count($dataSendMail['staff_notify']); $i < $count; $i++){
            $this->sendMailCancel($dataSendMail['project'], $dataSendMail['staff_notify'][$i]);
        }
    }

    public function getUserNeedSendMail($prj_id){
        $dataSendMail          = array();
        $projectDao        = new MProjectDao();
        $project           = $projectDao->getById($prj_id); 
        $staffDao          = new MStaffDao();
        $staff_notify      = $staffDao->getStaffSentMail();
        $prjDao            = new MProjectDao();
        $staff_inchange_id = $prjDao->getUserInchangeId($prj_id);
        $staff_inchange    = $staffDao->getUserById($staff_inchange_id[0]['prj_staff_id']);
        $staff_inchange_sup = array();
        if(!StringUtil::isNullOrEmpty($staff_inchange['staff_supervisor']))
            $staff_inchange_sup= $staffDao->getUserById($staff_inchange['staff_supervisor']);
        $dataSendMail['staff_inchange']     = $staff_inchange;
        $dataSendMail['staff_inchange_sup'] = $staff_inchange_sup;
        $dataSendMail['staff_notify']       = $staff_notify;
        $dataSendMail['project']            = $project;
        return $dataSendMail;
    }
}
?>