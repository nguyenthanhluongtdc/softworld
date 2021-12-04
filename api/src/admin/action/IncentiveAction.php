<?php

    require_once ROOT_PATH_COMMON . "/MessageConstants.php";
    require_once ROOT_PATH_DAO . "/core/DbManager.php";
    require_once ROOT_PATH_DAO . "/MStaffDao.php";
    require_once ROOT_PATH_DAO . "/MOfficeDao.php";
    require_once ROOT_PATH_DAO . "/MStaffRoleDao.php";
    require_once ROOT_PATH_DAO . "/MProjectDao.php";
    require_once ROOT_PATH_DAO . "/MStaffMonthlyComissionDao.php";
    require_once ROOT_PATH_DAO . "/MStaffComDao.php";
    class IncentiveAction extends BaseAction {

    public function rules() {
        return array(
            "search" => array("post", "get")
        );
    }

    public function render() {
        $this->setAttribute("urlSearch", ActionUtil::getActionUrl(PageIdConstants::INCENTIVE, "search"));
        $this->setAttribute("urlEdit", ActionUtil::getActionUrl(PageIdConstants::PROJECT, "edit"));
    }

    public function index() {
        $this->search();
    }

    public function getSearchParams(){
        $params_search = array();
        /* GET PARAMS SEARCH */
        $params_search['prj_staff_id']                  = ParamsUtil::getQueryParam('prj_staff_id', NULL);
        $params_search['staff_name']                    = ParamsUtil::getQueryParam('staff_name', NULL);
        $params_search['prj_role_grp']                  = ParamsUtil::getQueryParamNumeric('prj_role_grp', NULL);
        $params_search['prj_kind_contract']             = ParamsUtil::getQueryParamNumeric('prj_kind_contract', NULL);
        $params_search['view']                          = ParamsUtil::getQueryParamNumeric('view', NULL);
        $params_search['prj_keiyaku_bi_from']           = ParamsUtil::getQueryParam('prj_keiyaku_bi_from', NULL);
        $params_search['prj_keiyaku_bi_to']             = ParamsUtil::getQueryParam('prj_keiyaku_bi_to', NULL);
        $params_search['date_ranked_from']              = ParamsUtil::getQueryParam('date_ranked_from', NULL);
        $params_search['date_ranked_to']                = ParamsUtil::getQueryParam('date_ranked_to', NULL);
        $params_search['prj_pay_completed_date_year']   = ParamsUtil::getQueryParam('prj_pay_completed_date_year', NULL);
        $params_search['prj_pay_completed_date_month']  = ParamsUtil::getQueryParam('prj_pay_completed_date_month', NULL);
        /* END GET PARAMS SEARCH */
        return $params_search;
    }

    public function search() {
        $view = "view.php";
        $params_search = $this->getSearchParams();
        $export = ParamsUtil::getQueryParam('export', null);
        if($params_search['prj_keiyaku_bi_from'] == '0/0/0')
            $params_search['prj_keiyaku_bi_from'] = null; 
        if($params_search['prj_keiyaku_bi_to'] == '0/0/0')
            $params_search['prj_keiyaku_bi_to'] = null; 
        if($params_search['date_ranked_from'] == '0/0/0')
            $params_search['date_ranked_from'] = null; 
        if($params_search['date_ranked_to'] == '0/0/0')
            $params_search['date_ranked_to'] = null; 
        $this->validateSearch($params_search);
        $data1 = array();
        $data2 = array();
        if($params_search['view'] == 1 && !ParamsUtil::isExistsPostParam('regist_step'))
        {
            
            if(!$this->validate->hasError()) {
                 $data1 = $this->getDataForView1($params_search);
            }
            $count = count($data1);
            if($count > AppConfig::$COMISSION_MAX_ALLOW_RESULT)
            {
                $this->validate->addError(MessageConstants::COMISSION_MAX_ALLOW_RESULT_MSG);
                $break = 1;
                $data1 = null;
            }
            if(ArrayUtil::isNullOrEmpty($data1) && $break != 1)
                $this->validate->addError(MessageConstants::COM_INFO_SEARCH_RESULT_NOT_FOUND);
        }
        if($params_search['view'] == 2 && !ParamsUtil::isExistsPostParam('regist_step'))
        {
            if(!$this->validate->hasError()){
                $data2 = $this->getDataForView2($params_search);
                if(ArrayUtil::isNullOrEmpty($data2))
                {
                    $this->validate->addError(MessageConstants::COM_INFO_SEARCH_RESULT_NOT_FOUND);
                }
                else{
                    $data2 = $this->convertData2($data2);
                }
            }
        }

        /*run when user submit form edit*/
            $regist_step = ParamsUtil::getPostParam("regist_step", 4);
            if ($regist_step == 0 || $regist_step == 3) {
                $view = "view.php";
                if($params_search['view'] == 1){
                    $data1 = $this->jsonDecode(ParamsUtil::getPostParam("json_regist_data"));
                }elseif($params_search['view'] == 2){
                    $data2 = $this->jsonDecode(ParamsUtil::getPostParam("json_regist_data"));
                }
            } 
            elseif($regist_step == 1){
                if($params_search['view'] == 1)
                {
                    $data1 = $this->getDataForView1($params_search);
                    $params_array = $this->getParamsArray($data1);
                    $params = ParamsUtil::getPostParams($params_array);
                    /*var_dump($params);die;*/
                    $this->validateDataEdit1($params, $data1);
                    if (!$this->validate->hasError()) {
                        $data1 = $this->convertData1($params, $data1);
                        /*var_dump($data1);die;*/
                        $this->setViewState(array("json_regist_data" => $this->jsonEncode($data1)));
                        $view = "preview.php";
                    }else{
                        $params['isErrorValidate'] = 1;
                        $this->setViewState($params);
                        $data1 = $this->convertData1($params, $data1);
                        $view = "view.php";    
                    }
                }
                if($params_search['view'] == 2){
                    $data2 = $this->getDataForView2($params_search);
                    $params_array = $this->getParamsArray2($data2);
                    $params = ParamsUtil::getPostParams($params_array);
                    $data2 = $this->convertData2($data2, $params);
                    $this->validateDataEdit2($params, $data2);
                    if(!$this->validate->hasError()){
                        $this->setViewState(array("json_regist_data" => $this->jsonEncode($data2)));
                        $view = "preview.php";
                    }else{
                        $params['isErrorValidate'] = 1;
                        $this->setViewState($params);
                        $view = "view.php";
                    }
                }
            }elseif ($regist_step == 2) {
                $dataEdit =  $this->jsonDecode(ParamsUtil::getPostParam("json_regist_data"));
                if($params_search['view'] == 1){
                    $dbManger = DbManager::getInstance();
                    $dbManger->beginTransaction();
                    try {
                        $check_update = array();
                        $check_insert = array();
                        $array_exist  = array();
                        foreach ($dataEdit as $value) {
                            /*var_dump($value);die;*/
                            $params_edit_prj = array(
                                'prj_comm_partition_amount'         => str_replace(',', '', $value['prj_comm_partition_amount'])
                                ,'prj_comm_income_amount'           => str_replace(',', '', $value['prj_comm_income_amount']) 
                                ,'prj_comm_memo'                    => $value['prj_comm_memo']
                                ,'updated_time'                     => $value['updated_time']
                            );
                            $condition = array(
                                'prj_id' => $value['prj_id']
                            );
                            $params_comission = array(
                                'prj_id'                 => $value['prj_id']
                                ,'staff_id'              => $value['staff_join_id']
                                ,'staff_group'           => $value['prj_role_grp']
                                ,'commission_year_month' => $value['prj_comm_close_date']
                                ,'commission_amount'     => $value['prj_comm_amount']   
                                ,'cancel_flag'           => null
                            );

                            $check_update_pr    = $this->updateData($params_edit_prj, $condition);
                            $array_exist[]      = $isExist = $this->checkExistCom($params_comission);
                            if(!$isExist)
                            {
                                $check_insert[] = $this->insertCommision($params_comission);
                            }
                            else{
                                $check_update[] = $this->updateCommision($params_comission);
                            }

                            /*insert or update if exist */
                            if(!empty($value['prj_kyanceru_bi'])){
                                $re_params_comission = array(
                                    'prj_id'                 => $value['prj_id']
                                    ,'staff_id'              => $value['staff_join_id']
                                    ,'staff_group'           => $value['prj_role_grp']
                                    ,'commission_year_month' => $value['re_prj_comm_close_date']
                                    ,'commission_amount'     => $value['re_prj_comm_amount']   
                                    ,'cancel_flag'           => 1   
                                );
                                $isExist = $this->checkExistCom($re_params_comission);
                                if(!$isExist){
                                    $re_check_insert[] = $this->insertCommision($re_params_comission);
                                }
                                else{
                                    $re_check_update[] = $this->updateCommision($re_params_comission);
                                }
                            }
                        }
                        /*echo '<br>update:';var_dump($re_check_update);
                        echo '<br>insert';var_dump($re_check_insert);die;*/
                        $this->setUpdateSuccessMessage();
                        $dbManger->commit();
                    } catch (Exception $e) {
                        $this->setErrorExclusiveMessage();
                        $dbManger->rollback();
                        $this->logger->error($e->getMessage() . "(at " . $e->getTraceAsString() . ")");
                    }
                    $data1 = $this->getDataForView1($params_search);
                }
                elseif($params_search['view'] == 2){
                    $comm_year_month = $params_search['prj_pay_completed_date_year'].$params_search['prj_pay_completed_date_month'];
                    $dbManger = DbManager::getInstance();
                    $dbManger->beginTransaction();
                    try {
                        foreach ($dataEdit as $key => $value) {
                            $params_edit = array(
                                'staff_id'              => $value['staff_id']
                                ,'comm_year_month'      => $comm_year_month
                                ,'commission_amount'    => $value['commission_amount']
                                ,'updated_time'         => $value['comm_update_time']
                            );
                            $condition = array(
                                'staff_id'          => $value['staff_id']
                                ,'comm_year_month'  => $comm_year_month
                            );
                            $this->updateData2($params_edit, $condition);
                        }
                        $this->setUpdateSuccessMessage();
                        $dbManger->commit();
                    }catch(Exception $e) {
                        $this->setErrorExclusiveMessage();
                        $dbManger->rollback();
                        $this->logger->error($e->getMessage() . "(at " . $e->getTraceAsString() . ")");
                    }
                    $data2 = $this->getDataForView2($params_search);
                    $data2 = $this->convertData2($data2);
                }
            }
        /*end run when user submit form edit*/
        /*process export*/
            if (!$this->validate->hasError()) {
                if ($params_search['view'] == 1 && !StringUtil::isNullOrEmpty($export)) {
                    $this->exportV1($params_search,$data1);
                } elseif ($params_search['view'] == 2 && !StringUtil::isNullOrEmpty($export)) {
                    $data2export = $this->getDataForView2($params_search);
                    $data2export = $this->convertData2($data2export);
                    $this->exportV2($params_search,$data2export);
                }
            }
        $this->setAttribute('data1', $data1);
        $this->setAttribute('flat', $params_search['view']);
        $this->setAttribute('data2', $data2);
        $this->setAttribute('flat', $params_search['view']);

        $this->setView($view);
    }

    public function  getParamsArray($incentiveData){
        $params_array = array();
        $i = 1;
        
        foreach ($incentiveData as $item) {
            /*var_dump($incentiveData);die;*/
            //array_push($params_array, 'prj_id' . "_" . $i);
            array_push($params_array, 'prj_comm_partition_amount_' . $item['prj_id']);
            array_push($params_array, 'prj_comm_income_amount_' . $item['prj_id']);
            array_push($params_array, 'prj_comm_memo_' . $item['prj_id']);
            array_push($params_array, 'prj_comm_close_date_' . $item['prj_id'].'_'.$item['staff_join_id'].'_'.$item['prj_role_grp']);
            array_push($params_array, 'prj_comm_close_date_year_' . $item['prj_id'].'_'.$item['staff_join_id'].'_'.$item['prj_role_grp']);
            array_push($params_array, 'prj_comm_close_date_month_' . $item['prj_id'].'_'.$item['staff_join_id'].'_'.$item['prj_role_grp']);
            array_push($params_array, 'prj_comm_amount_' . $item['prj_id'].'_'.$item['staff_join_id'].'_'.$item['prj_role_grp']);
            array_push($params_array, 'updated_time_' . $item['prj_id']);
            array_push($params_array, 'prj_id_' . $item['prj_id']);
            array_push($params_array, 'total_percent_input'. $item['prj_id']);
            array_push($params_array, 'sub_percent_input'. $item['prj_id'].'_'.$item['staff_join_id'].'_'.$item['prj_role_grp']);
            if(!StringUtil::isNullOrEmpty($item['prj_kyanceru_bi'])){
                array_push($params_array, 're_prj_comm_close_date_' . $item['prj_id'].'_'.$item['staff_join_id'].'_'.$item['prj_role_grp']);
                array_push($params_array, 're_prj_comm_close_date_year_' . $item['prj_id'].'_'.$item['staff_join_id'].'_'.$item['prj_role_grp']);
                array_push($params_array, 're_prj_comm_close_date_month_' . $item['prj_id'].'_'.$item['staff_join_id'].'_'.$item['prj_role_grp']);
                array_push($params_array, 're_prj_comm_amount_' . $item['prj_id'].'_'.$item['staff_join_id'].'_'.$item['prj_role_grp']);
                array_push($params_array, 're_total_percent_input'. $item['prj_id']);
                array_push($params_array, 're_sub_percent_input'. $item['prj_id'].'_'.$item['staff_join_id'].'_'.$item['prj_role_grp']);
            }
            $i++;
        }
        return $params_array;
    }
    
    public function  getParamsArray2($incentiveData){
        $params_array = array();
        $i = 1;
        foreach ($incentiveData as $item) {
            array_push($params_array, 'commission_amount' . $item['staff_id']);
        }
        return $params_array;
    }

    private function validateSearch($params) {
        $prj_pay_completed_date = $params['prj_pay_completed_date_year'].$params['prj_pay_completed_date_month'];
        if($prj_pay_completed_date == '00')
            $prj_pay_completed_date = null;
        $validateOpts = array(
            array(
                "itemId" => "prj_staff_id"
                , "itemName" => "担当社員ID"
                , "types" => array(ValidateUtil::_IS_NUM)
                , "data" => $params["prj_staff_id"]
            )
            ,array(
                "itemId" => "show_message_date"
                , "itemName" => "歩合締日"
                , "types" => array(ValidateUtil::_IS_YEAR_MONTH, ValidateUtil::_IS_NULL)
                , "data" => $prj_pay_completed_date
            )
            ,array(
                "itemId" => "show_message_date_v1_from1"
                , "itemName" => "契約日1"
                , "types" => array(ValidateUtil::_IS_DATE)
                , "data" => $params['prj_keiyaku_bi_from']
            )
            ,array(
                "itemId" => "show_message_date_v1_to1"
                , "itemName" => "契約日2"
                , "types" => array(ValidateUtil::_IS_DATE)
                , "data" => $params['prj_keiyaku_bi_to']
            )
            ,array(
                "itemId" => "show_message_date_v1_from2"
                , "itemName" => "完納年月日1"
                , "types" => array(ValidateUtil::_IS_DATE)
                , "data" => $params['date_ranked_from']
            )
            ,array(
                "itemId" => "show_message_date_v1_to2"
                , "itemName" => "完納年月日2"
                , "types" => array(ValidateUtil::_IS_DATE)
                , "data" => $params['date_ranked_to']
            )
        );
        if($params['view'] != 2)
        {
            unset($validateOpts[1]);
        }else{
            unset($validateOpts[2]);
            unset($validateOpts[3]);
            unset($validateOpts[4]);
            unset($validateOpts[5]);
        }
        $this->validate->validates($validateOpts);
        return !$this->validate->hasError();
    }

    private function validateDataEdit1($params, $incentiveData) {
        $validateOpts = array(
        );
        for($i=0,$count = count($incentiveData); $i < $count; $i++){
            $params["prj_comm_partition_amount_".$incentiveData[$i]['prj_id']]      = str_replace(',', '', $params["prj_comm_partition_amount_".$incentiveData[$i]['prj_id']]);
            $params["prj_comm_income_amount_".$incentiveData[$i]['prj_id']]         = str_replace(',', '', $params["prj_comm_income_amount_".$incentiveData[$i]['prj_id']]);
            $prj_comm_partition_amount = array(
                //"itemId" => "prj_comm_partition_amount_".$incentiveData[$i]['prj_id']
                 "itemName" => "仕切金額".$incentiveData[$i]['prj_id']
                , "types" => array(ValidateUtil::_IS_NUM)
                , "data" => $params["prj_comm_partition_amount_".$incentiveData[$i]['prj_id']]
            );
            $prj_comm_income_amount = array(
                //"itemId" => "prj_comm_income_amount_".$incentiveData[$i]['prj_id']
                 "itemName" => "利益額".$incentiveData[$i]['prj_id']
                , "types" => array(ValidateUtil::_IS_NUM)
                , "data" => $params["prj_comm_income_amount_".$incentiveData[$i]['prj_id']]
            );
            $prj_comm_close_date = array(
                //"itemId" => "prj_comm_close_date_".$incentiveData[$i]['prj_id'].'_'.$incentiveData[$i]['staff_join_id']
                 "itemName" => "歩合締日".$incentiveData[$i]['prj_id'].'-'.$incentiveData[$i]['staff_join']
                , "types" => array(ValidateUtil::_IS_YEAR_MONTH)
                , "data" => $params["prj_comm_close_date_".$incentiveData[$i]['prj_id'].'_'.$incentiveData[$i]['staff_join_id'].'_'.$incentiveData[$i]['prj_role_grp']]
            );
            $prj_comm_amount = array(
                //"itemId" => "prj_comm_amount_".$incentiveData[$i]['prj_id'].'_'.$incentiveData[$i]['staff_join_id']
                 "itemName" => "歩合(円)".$incentiveData[$i]['prj_id'].'-'.$incentiveData[$i]['staff_join']
                , "types" => array(ValidateUtil::_IS_NUM)
                , "data" => $params["prj_comm_amount_".$incentiveData[$i]['prj_id'].'_'.$incentiveData[$i]['staff_join_id'].'_'.$incentiveData[$i]['prj_role_grp']]
            );
            $prj_comm_memo = array(
                //"itemId" => "prj_comm_memo_".$incentiveData[$i]['prj_id']
                 "itemName" => "メモ".$incentiveData[$i]['prj_id']
                , "types" => array(ValidateUtil::_IS_MAX)
                , "data" => $params["prj_comm_memo_".$incentiveData[$i]['prj_id']]
                , "max" => 5000
            );

            $re_prj_comm_close_date = array();
            $re_prj_comm_amount     = array();

            if(!StringUtil::isNullOrEmpty($incentiveData[$i]['prj_kyanceru_bi'])){
                $re_prj_comm_close_date = array(
                    //"itemId" => "prj_comm_close_date_".$incentiveData[$i]['prj_id'].'_'.$incentiveData[$i]['staff_join_id']
                     "itemName" => "歩合締日(キャンセル)".$incentiveData[$i]['prj_id'].'-'.$incentiveData[$i]['staff_join']
                    , "types" => array(ValidateUtil::_IS_YEAR_MONTH)
                    , "data" => $params["re_prj_comm_close_date_".$incentiveData[$i]['prj_id'].'_'.$incentiveData[$i]['staff_join_id'].'_'.$incentiveData[$i]['prj_role_grp']]
                );
                $re_prj_comm_amount = array(
                    //"itemId" => "prj_comm_amount_".$incentiveData[$i]['prj_id'].'_'.$incentiveData[$i]['staff_join_id']
                     "itemName" => "歩合(円)(キャンセル)".$incentiveData[$i]['prj_id'].'-'.$incentiveData[$i]['staff_join']
                    , "types" => array(ValidateUtil::_IS_NUM)
                    , "data" => $params["re_prj_comm_amount_".$incentiveData[$i]['prj_id'].'_'.$incentiveData[$i]['staff_join_id'].'_'.$incentiveData[$i]['prj_role_grp']]
                );
            }

            array_push($validateOpts, 
                $prj_comm_partition_amount, 
                $prj_comm_income_amount, 
                $prj_comm_close_date,
                $prj_comm_amount,
                $prj_comm_memo,
                $re_prj_comm_close_date,
                $re_prj_comm_amount
            );
        }
        $this->validate->validates($validateOpts);
        return !$this->validate->hasError();
    }

    private function validateDataEdit2($params, $incentiveData){
        $validateOpts = array(
        );
        foreach($incentiveData as $name => $item){
            $commission_amount = array(
                "itemId" => "commission_amount".$item['staff_id']
                , "itemName" => "歩合".$name
                , "types" => array(ValidateUtil::_IS_NUM)
                , "data" => $params["commission_amount".$item['staff_id']]
            );
            array_push($validateOpts,$commission_amount);
        }
        $this->validate->validates($validateOpts);
        return !$this->validate->hasError();
    }

    private function getDataForView1($params) {
        $projectDao = new MProjectDao();
        $incentive = $projectDao->getIncentiveData1($params);
        return $incentive;
    }

    private function getDataForView2($params) {
        $projectDao = new MProjectDao();
        $data2 = $projectDao->getIncentiveData2($params);
        return $data2;
    }

    public function exportV1($params, $data){
        $export = ParamsUtil::getQueryParam('export', null);
        if (!StringUtil::isNullOrEmpty($export) && $export == 'csv') {
            $arraycsv = array();
            $arraycsv[] = array('案件ID', '社員名/担当種別', '契約日/完納日/キャンセル日', 'PV,EQ,IH', 'メーカー', 'お客様名', 'Kw', '売上金額（支払済金額）', '仕切金額', '利益額', '歩合締日','歩合(円)','歩合合計(%)','メモ');
            $sum_prj_prod_price_selling_total       = 0;
            $sum_prj_prod_price_selling_total_after = 0;
            $sum_prj_comm_partition_amount          = 0;
            $sum_total1 = 0;
            $sum_total2 = 0;
            $sum_total3 = 0;
            $staff_role = 0;
            $check_row  = 0;
            $sum        = 0;
            $index      = 0;
            $curindex   = 0;
            $flag       = false;
            for($k = 0,$countk = count($data); $k < $countk; $k++){
                $rowspan = $data[$k]['num_staff_join'];
                $repeat  = false;
                if($check_row != $data[$k]['prj_id']){ 
                    $last = 0;
                }
                if($last === ($rowspan-1)){
                    if(!$has_repeat) {
                        if(!StringUtil::isNullOrEmpty($data[$k]['prj_kyanceru_bi'])){
                            $repeat = true;
                        }
                    }else{
                        $repeating = false;
                    }
                }
                if($flag){
                    $re = "re_";
                }
                else{
                    $re = null;
                }

                if($check_row != $data[$k]['prj_id']){
                    if ($index != 0){
                        $arraycsv[$curindex][12] = $sum . '%';
                        $sum = 0;
                    }
                    $check_row = $data[$k]['prj_id'];
                    $arrchild = array();
                    $arrchild[] = $data[$k]['prj_id'];
                    for($j=0,$count=count(AppConfig::$STAFF_POS); $j <= $count; $j++)
                    {
                        if(AppConfig::$STAFF_POS[$j][0] == $data[$k]['prj_role_grp']){
                            $staff_role = AppConfig::$STAFF_POS[$j][2];
                            break;
                        }
                    }
                    $arrchild[] = $data[$k]['staff_join'] . "($staff_role)";
                    $arrchild[] = $data[$k]['prj_keiyaku_bi'] . '/' . $data[$k]['prj_pay_completed_date'].'/'.$data[$k]['prj_kyanceru_bi'];
                    $str = '';
                    $pv = ArrayUtil::StringToArray($data[$k]['prj_kind_pv']);
                    if (in_array(1, $pv))
                        $str .= '○、';
                    else
                        $str .= 'なし、';
                    $prj_kind_od = ArrayUtil::StringToArray($data[$k]['prj_kind_od']);
                    if (in_array(1, $prj_kind_od))
                        $str .= '○、';
                    else
                        $str .= 'なし、';
                    $prj_kind_od = ArrayUtil::StringToArray($data[$k]['prj_kind_od']);
                    if (in_array(2, $prj_kind_od))
                        $str .= '○';
                    else
                        $str .= 'なし';
                    $prj_comm_partition_amount    = $data[$k]['prj_comm_partition_amount'] != null ? $data[$k]['prj_comm_partition_amount'] : (int)$data[$k]['total_prod_price_part'] - (int)$data[$k]['total_prod_price_part2'];
                    $prj_prod_price_selling_total = $data[$k]['prj_prod_price_selling_total'] ;
                    $prj_comm_income_amount       = (StringUtil::isNullOrEmpty($data[$k]['prj_comm_income_amount']) || $data[$k]['prj_comm_income_amount'] == 0) ? (int)$prj_prod_price_selling_total - (int)$prj_comm_partition_amount : $data[$k]['prj_comm_income_amount'];
                
                    $sum = (float)$sum +  (float)($prj_comm_income_amount == 0 ? 0 : round($data[$k]['prj_comm_amount']/$prj_comm_income_amount * 100,2));
                    $total_123 = ($data[$k]['promotionTotal'])*-1;
                    $arrchild[] = $str;
                    $arrchild[] = AppConfig::$MAKER[$data[$k]['prj_maker']];
                    $arrchild[] = $data[$k]['prj_cust_name'];
                    $arrchild[] = $data[$k]['prj_prod_kw'] . 'kw';
                    $sum_prj_prod_price_selling_total += (int)$data[$k]['prj_prod_price_selling_total'];
                    $sum_prj_prod_price_selling_total_after += (int)$data[$k]['total_reven'];
                    $arrchild[] = $data[$k]['prj_prod_price_selling_total'] . "(".$data[$k]['total_reven'].")";
                    $arrchild[] = ($data[$k]['total_prod_price_part'] - $data[$k]['total_prod_price_part2']) . '円' . "\n" . ($data[$k]['prj_comm_partition_amount'] == NULL ? $data[$k]['total_prod_price_part'] . '円' : $data[$k]['prj_comm_partition_amount'] . '円');
                    $sum_prj_comm_partition_amount += $data[$k]['prj_comm_partition_amount'] == NULL ? $data[$k]['total_prod_price_part'] : $data[$k]['prj_comm_partition_amount'];
                    $arrchild[] = '工事：' . $data[$k]['total1'] . "\n" . '整地：' . $data[$k]['total2'] . "\n" . '利益：' . $data[$k]['total3'] ."\n"."（値引き合計：".$total_123.")". "\n".'利益額調整：' . $prj_comm_income_amount . '円';
                    $sum_total1 += $data[$k]['total1'];
                    $sum_total2 += $data[$k]['total2'];
                    $sum_total3 += $data[$k]['total3'];
                    //$prj_comm_close_date_mgr   = $data[$k]['prj_comm_close_date_mgr'];
                    //$prj_comm_close_date       = $data[$k]['prj_comm_close_date'];
                    if(!StringUtil::isNullOrEmpty($data[$k][$re.'prj_comm_close_date'])){
                        $year  = substr($data[$k][$re.'prj_comm_close_date'], 0, 4);
                        $month = substr($data[$k][$re.'prj_comm_close_date'], 4, 2);
                    }
                    


                    $arrchild[] = $year . '年'  . $month . '月分';
                    $arrchild[] = $data[$k][$re.'prj_comm_amount'] . '円' . "\n" . ($prj_comm_income_amount == 0 ? 0 : round($data[$k][$re.'prj_comm_amount']/$prj_comm_income_amount * 100,2)) . '%';
                    $arrchild[] = '';
                    $prj_comm_memo             = $data[$k]['prj_comm_memo'];
                    $arrchild[] = $prj_comm_memo;
                    $arraycsv[] = $arrchild;
                    $index++;
                    $curindex   = $index;
                }
                else{
                    $prj_comm_partition_amount    = $data[$k]['prj_comm_partition_amount'] != null ? $data[$k]['prj_comm_partition_amount'] : (int)$data[$k]['total_prod_price_part'] - (int)$data[$k]['total_prod_price_part2'];
                    $prj_prod_price_selling_total = $data[$k]['prj_prod_price_selling_total'] ;
                    $prj_comm_income_amount       = (StringUtil::isNullOrEmpty($data[$k]['prj_comm_income_amount']) || $data[$k]['prj_comm_income_amount'] == 0) ? (int)$prj_prod_price_selling_total - (int)$prj_comm_partition_amount : $data[$k]['prj_comm_income_amount'];
                    $arrchild = array();
                    $arrchild[] = $data[$k]['prj_id'];
                    for($j=0,$count=count(AppConfig::$STAFF_POS); $j <= $count; $j++){
                        if(AppConfig::$STAFF_POS[$j][0] == $data[$k]['prj_role_grp']){
                            $staff_role = AppConfig::$STAFF_POS[$j][2];
                            break;
                        }
                    }
                    $arrchild[] = $data[$k]['staff_join'] . "($staff_role)";
                    for ($i = 1; $i <= 8; $i++) {
                        $arrchild[] = '';
                    }
                    if(!StringUtil::isNullOrEmpty($data[$k][$re.'prj_comm_close_date'])){
                        $year = substr($data[$k][$re.'prj_comm_close_date'], 0, 4);
                        $month = substr($data[$k][$re.'prj_comm_close_date'], 4, 2);
                    }
                    $arrchild[] = $year . '年'  . $month . '月分';
                    $arrchild[] = $data[$k][$re.'prj_comm_amount'] . '円' . "\n" . ($prj_comm_income_amount == 0 ? 0 : round($data[$k][$re.'prj_comm_amount']/$prj_comm_income_amount * 100,2)) . '%';
                    $arrchild[] = '';
                    $sum        = (float)$sum + (float)($prj_comm_income_amount == 0 ? 0 : round($data[$k]['prj_comm_amount']/$prj_comm_income_amount * 100,2));
                    $arrchild[] = '';
                    $arraycsv[] = $arrchild;
                    $index++;  
                }
                
                if($repeat){
                    $k          = $k - ($rowspan);
                    $has_repeat = true;
                    $check_row  = null;
                    $repeating  = true;
                    $flag   = true;
                }
                if(!$repeating){
                    $has_repeat = false;
                    $flag       = false;
                }
                $year  = null;
                $month = null;
                $last++;
            }
            $arrchild = array();
            $arrchild[] = '合計';
            for ($i = 1; $i <= 6; $i++) {
                $arrchild[] = '';
            }
            $arrchild[] = $sum_prj_prod_price_selling_total . "\n" . "($sum_prj_prod_price_selling_total_after)";
            $arrchild[] = $sum_prj_comm_partition_amount;
            $arrchild[] = '工事:' . $sum_total1 . "\n" . '整地:'. $sum_total2 . "\n" . '利益:' .$sum_total3;
            for ($i = 1; $i <= 5; $i++) {
                $arrchild[] = '';
            }
            $arraycsv[] = $arrchild;

            ArrayUtil::array_to_csv_download($arraycsv);
            exit;
        }
    }

    public function exportV2($params, $data){
        $export = ParamsUtil::getQueryParam('export', null);
        if (!StringUtil::isNullOrEmpty($export) && $export == 'csv') {
            $arraycsv = array();
            $arraycsv[] = array('社員名/担当種別', '案件ID', '契約日', '完納日', 'PV,EQ,IH', 'メーカー', 'お客様名', 'Kw', '売上金額', '仕切金額', '利益額', '歩合(%)変更前','歩合(円)変更前','歩合(円)変更後');
            $sum_prj_prod_price_selling_total = 0;
            $sum_prj_prod_price_part_total = 0;
            $sum_earnings = 0;
            $sum_prj_comm_amount = 0;
            $commission_amount_total = 0;
            foreach ($data as $key => $value) {
                $arraychild = array();
                $arraychild[] = $key;
                for ($i = 1; $i <= 7; $i++) {
                    $arraychild[] = '';
                }
                if (!StringUtil::isNullOrEmpty($value['commission_amount']))
                    $commission_amount = $value['commission_amount'];
                else
                    $commission_amount = $prj_comm_amount;
                $commission_amount_total +=$commission_amount;
                $arraychild[] = $value['prj_prod_price_selling_total'];
                $arraychild[] = $value['prj_prod_price_part_total'];
                $arraychild[] = $value['prj_prod_price_selling_total'] - $value['prj_prod_price_part_total'];
                $arraychild[] = '';
                $arraychild[] = $value['prj_comm_amount'];
                $arraychild[] = $commission_amount;
                $sum_prj_prod_price_selling_total += $value['prj_prod_price_selling_total'];
                $sum_prj_prod_price_part_total += $value['prj_prod_price_part_total'];
                $sum_earnings += ($value['prj_prod_price_selling_total'] - $value['prj_prod_price_part_total']);
                $sum_prj_comm_amount += $value['prj_comm_amount'];
                $arraycsv[] = $arraychild;
                foreach ($value['array'] as $k => $v) {
                    foreach ($v as $item) {
                        $arraychild = array();
                        $arraychild[] = $item['staff_name'] . "(" . AppConfig::$ROLE_GROUP[$item['prj_role_grp']] . ")";
                        $arraychild[] = $item['prj_id'];
                        $arraychild[] = $item['prj_keiyaku_bi'];
                        $arraychild[] = $item['prj_kanko_bi'];
                        $str = '';
                        $pv = ArrayUtil::StringToArray($item['prj_kind_pv']);
                        if(in_array(1, $pv))
                            $str .= '○、';
                        else
                            $str .= 'なし、';
                    
                        $prj_kind_od = ArrayUtil::StringToArray($item['prj_kind_od']);
                        if(in_array(1, $prj_kind_od))
                            $str .= '○、';
                        else
                            $str .= 'なし、';
                        $prj_kind_od = ArrayUtil::StringToArray($item['prj_kind_od']);
                        if(in_array(2, $prj_kind_od))
                            $str .= '○';
                        else
                            $str .= 'なし';
                        $arraychild[] = $str;
                        $arraychild[] = !StringUtil::isNullOrEmpty(AppConfig::$MAKER[$item['prj_maker']]) ? AppConfig::$MAKER[$item['prj_maker']] : '';
                        $arraychild[] = $item['prj_cust_name'];
                        $arraychild[] = !StringUtil::isNullOrEmpty($item['prj_prod_kw']) ? $item['prj_prod_kw'] . ' Kw' : '';
                        if(StringUtil::isNullOrEmpty($item['prj_comm_partition_amount']))
                                $prj_comm_partition_amount = $item['prj_prod_price_part_total'];
                            else 
                                $prj_comm_partition_amount = $item['prj_comm_partition_amount'];
                        $arraychild[] = (int) $item['prj_prod_price_selling_total'];
                        $arraychild[] = $prj_comm_partition_amount;
                        $subtract = (int) $item['prj_prod_price_selling_total'] - (int)$prj_comm_partition_amount;
                        $arraychild[] = $subtract;
                       
                        $percent = 0;
                        if($item['prj_prod_price_selling_total'] != 0){
                            $percent = StringUtil::isNullOrEmpty($subtract) ? 0 : round(($item['prj_staff_commission_amount']/$subtract)* 100,2);
                        }
                        $arraychild[] = $percent ;
                        $arraychild[] = $item['prj_staff_commission_amount'];
                        $arraychild[] = '';
                        $arraycsv[] = $arraychild;
                    }
                }
            }
            $arraychild = array();
            $arraychild[] = '合計';
            for ($i = 1; $i <= 7; $i++) {
                $arraychild[] = '';
            }
            $arraychild[] = $sum_prj_prod_price_selling_total;
            $arraychild[] = $sum_prj_prod_price_part_total;
            $arraychild[] = $sum_earnings;
            $arraychild[] = '';
            $arraychild[] = $sum_prj_comm_amount;
            $arraychild[] = $commission_amount_total;
            $arraycsv[] = $arraychild;
            ArrayUtil::array_to_csv_download($arraycsv);
            exit;
        }
    }

    /*convertdata1 for view1 when has error validate or back from preview and to preview*/
    public function convertData1($params, $data){
        for($i=0,$count = count($data); $i<$count; $i++){
            $data[$i]['prj_comm_partition_amount']      =   $params['prj_comm_partition_amount_'.$data[$i]['prj_id']];
            $data[$i]['prj_comm_income_amount']         =   $params['prj_comm_income_amount_'.$data[$i]['prj_id']];
            $data[$i]['prj_comm_close_date']            =   $params['prj_comm_close_date_'.$data[$i]['prj_id'].'_'.$data[$i]['staff_join_id'].'_'.$data[$i]['prj_role_grp']];
            $data[$i]['prj_comm_amount']                =   $params['prj_comm_amount_'.$data[$i]['prj_id'].'_'.$data[$i]['staff_join_id'].'_'.$data[$i]['prj_role_grp']];
            $data[$i]['prj_comm_memo']                  =   $params['prj_comm_memo_'.$data[$i]['prj_id']];
            $data[$i]['updated_time']                   =   $params['updated_time_'.$data[$i]['prj_id']];
            if(!StringUtil::isNullOrEmpty($data[$i]['prj_kyanceru_bi'])){
                $data[$i]['re_prj_comm_close_date']     =   $params['re_prj_comm_close_date_'.$data[$i]['prj_id'].'_'.$data[$i]['staff_join_id'].'_'.$data[$i]['prj_role_grp']];
                $data[$i]['re_prj_comm_amount']         =   $params['re_prj_comm_amount_'.$data[$i]['prj_id'].'_'.$data[$i]['staff_join_id'].'_'.$data[$i]['prj_role_grp']];
            }
        }
        return $data;
    }

    /*update prj_info */
    public function updateData($params, $condition){
        $prjDao = new MProjectDao();
        return $prjDao->update(
            $params
            , array(
                "where" => "prj_id = :prj_id"
                , "params" => $condition
            )
        );
    }

    public function updateData2($params, $condition){

        $commissionDao = new MStaffMonthlyComissionDao();
        $sql = "SELECT * FROM staff_monthly_comission WHERE staff_id = :staff_id and comm_year_month = :comm_year_month";
        $checkExist = $commissionDao->selectOne($sql,$condition);
        if(!$checkExist || ArrayUtil::isNullOrEmpty($checkExist)){
            $a = $commissionDao->insert($params);
        }else{
            unset($params['staff_id']);
            unset($params['comm_year_month']);
            $commissionDao->update(
                $params
                ,array(
                    'where' => 'staff_id = :staff_id and comm_year_month = :comm_year_month'
                    ,'params' => $condition
                )
            );
        }
    }

    /*
        conver data2 for view
        params not null when has error validate or back from preview and to preview
    */
    public function convertData2($data,$params = null){
        $result = array();
        $array_temp = array();
        foreach ($data as $v2) {
            if (!in_array($v2['staff_name'], $array_temp)) {
                array_push($array_temp, $v2['staff_name']);
                $sum = 0;
                $sum1 = 0;
                $sum2 = 0;
                $sum4 = 0;
                foreach ($data as $v2_1) {
                    if ($v2['staff_name'] == $v2_1['staff_name']) {
                        if ($v2_1['prj_role_grp'] == 1) {
                            $sumreult = $v2_1['prj_comm_amount_mgr'];
                        } elseif ($v2_1['prj_role_grp'] == 2) {
                            $sumreult = $v2_1['prj_comm_amount_closer'];
                        } else {
                            $sumreult = $v2_1['prj_comm_amount_introducer'];
                        }
                        $v2_1['sumreult'] = $sumreult;
                      
                        $sum2 += $v2_1['prj_staff_commission_amount'];
                        $sum  += (int) $v2_1['prj_prod_price_selling_total'];
                        $sum1 += !StringUtil::isNullOrEmpty($v2_1['prj_comm_partition_amount']) ? (int)$v2_1['prj_comm_partition_amount']: (int) $v2_1['total_prod_price_part']-$v2_1['total_prod_price_part1'];
                        $sum4 += $sum;
                        $prj_id_role_by_name[]   = $v2_1['prj_id'].$v2_1['prj_role_grp'];
                        $result[$v2['staff_name']]['array'][] = array(
                            $v2['staff_name'] => $v2_1,
                        );
                    }
                }
                $result[$v2['staff_name']]['prj_staff_id']                      = $v2['prj_staff_id'];
                $result[$v2['staff_name']]['staff_id']                          = $v2['staff_id'];
                $result[$v2['staff_name']]['prj_id']                            = $v2['prj_id'];
                $result[$v2['staff_name']]['commission_amount']                 = $v2['commission_amount'];
                $result[$v2['staff_name']]['comm_update_time']                  = $v2['comm_update_time'];
                $result[$v2['staff_name']]['prj_prod_price_selling_total']      = $sum;
                $result[$v2['staff_name']]['prj_prod_price_part_total']         = $sum1;
                $result[$v2['staff_name']]['prj_comm_amount']                   = $sum2;
                $result[$v2['staff_name']]['prj_prod_price_selling_total_plus'] = $sum4;
                $result[$v2['staff_name']]['prj_id_role_by_name']               = $prj_id_role_by_name;
                /*get data user post when has error validate and back from preview*/

                if(!empty($params)){
                    $result[$v2['staff_name']]['commission_amount'] = $params['commission_amount'.$v2['staff_id']];
                }

            }
        }
        return $result;
    }

    public function updateCommision($params){
        $staffCom = new MStaffComDao();
        $staffCom->updateCom($params);
    }

    public function insertCommision($params){
        $staffCom = new MStaffComDao();
        return $staffCom->insertCom($params);
    }

    public function checkExistCom($params){
        $condition = array(
            'prj_id' => $params['prj_id']
            ,'staff_id' => $params['staff_id']
            ,'staff_group' => $params['staff_group']
            , 'cancel_flag' => $params['cancel_flag']
        );
        $staffCom = new MStaffComDao();
        return   $staffCom->checkExistCommission($params); 
    }
}
