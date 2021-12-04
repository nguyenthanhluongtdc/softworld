<?php

/**
**/
require_once ROOT_PATH_COMMON . "/MessageConstants.php";
require_once ROOT_PATH_DAO . "/core/DbManager.php";
require_once ROOT_PATH_DAO . "/MOfficeDao.php";
class OfficeAction extends BaseAction {
    private $OfficeDao;
    public function __construct() {
        parent::__construct();
        $this->OfficeDao = new MOfficeDao();
    }
    
	public function rules() {
		return array(
			"search" => array("post", "get")
			, "regist" => array("post", "get")
			, "edit" => array("post", "get")
			, "delete" => "post"
			, "ajaxgetoffice" => array("post", "get")
		);
	}

	public function render() {
		// set url for screen
		$this->setAttribute("urlRegist", ActionUtil::getActionUrl(PageIdConstants::OFFICE, "regist"));
		$this->setAttribute("urlSearch", ActionUtil::getActionUrl(PageIdConstants::OFFICE, "search"));
		$this->setAttribute("urlEdit", ActionUtil::getActionUrl(PageIdConstants::OFFICE, "edit"));
		$this->setAttribute("urlDelete", ActionUtil::getActionUrl(PageIdConstants::OFFICE, "delete"));
	}

	public function index() {
		$this->search();
	}

	public function search() {
		$pageSize = ParamsUtil::getQueryParamNumeric("page_size", AppConfig::$DEFAULT_PAGE_SIZE);
		$currentPage = ParamsUtil::getQueryParamNumeric("current_page", 1);
        $params = ParamsUtil::getQueryParams(array(
            'office_name', 'office_phone_num', 'office_prefectures'
        ));
        $this->validatesSearch($params);
		$totalRow = 0;
		if(!$this->validate->hasError()) {
            $offices = $this->OfficeDao->getWithPagging($currentPage, $pageSize, $sortCondition, $totalRow, $params);
            if(isset($offices) && count($offices) > 0) {
                $this->setAttribute("sortColumns", $this->sortColumns());
                $this->setAttribute("lstOffices", $offices);
            } 
            else {
                $this->validate->addError(MessageConstants::COM_INFO_SEARCH_RESULT_NOT_FOUND);
            }
        }
        
        $this->setAttribute("sort_condition", $sortCondition);
        $this->setAttribute("currentPage", $currentPage);
        $this->setAttribute("pageSize", $pageSize);
        $this->setAttribute("totalRow", $totalRow);
        $this->setView("view.php");
	}

	public function regist() {
		$regist_step = ParamsUtil::getPostParam("regist_step", 0);
		$view = null;
		// create or back from the screen preview
		if($regist_step == 0 || $regist_step == 3) {
			$view = "input.php";
			$params = $this->jsonDecode(ParamsUtil::getPostParam("json_regist_data"));
			$this->setViewState($params);
		} else if($regist_step == 1) { // move to the screen preview
			$params = ParamsUtil::getPostParams(array(
				"office_id"
				, "office_name"
				, "office_name_kana"
				, "office_pos_code"
                , "office_pos_code1"
                , "office_pos_code2"
				, "office_prefectures"
				, "office_city"
				, "office_address"
				, "office_mansion_info"
				, "office_phone_num"
                , "office_fax_num"
				, "office_email"
				, "office_memo"
				, "created_user"
				, "created_time"
				, "updated_user"
				, "updated_time"
            ));
			$params['office_pos_code'] = $params['office_pos_code1'].'-'.$params['office_pos_code2'];
            $this->setAttribute("office_pos_code", $params['office_pos_code']);
			$this->validates($params);			
			if(!$this->validate->hasError()) {
				$this->setViewState(array("json_regist_data" => $this->jsonEncode($params)));
				$view = "preview.php";
			} else {
                $this->validate->addError($this->validate->messageFormat(MessageConstants::COM_ERR_HAPPENED));
				$view = "input.php";
			}
		} else if($regist_step == 2) {
			// get regist data from json
            $params = $this->jsonDecode(ParamsUtil::getPostParam("json_regist_data"));
            // check validation
            $this->validates($params);            
            if($this->validate->hasError()) {
                $this->validate->addError($this->validate->messageFormat(MessageConstants::COM_ERR_HAPPENED));
                $view = "input.php";
            } else {
                
                $result = $this->doRegist($params);
                // if is create
                if(StringUtil::isNullOrEmpty($params["office_id"])) {
                    if($result > 0) {
                        $this->setInsertSuccessMessage();
                    }
                } else {
                    if($result > 0) {
                        $this->setUpdateSuccessMessage();
                    } else {
                        $this->setErrorExclusiveMessage();
                    }
                }
                
            }
            // show list
            ActionUtil::redirect(PageIdConstants::OFFICE);
		}
		if(!StringUtil::isNullOrEmpty($view)) {
			$this->setView($view);
		}
	}

	public function edit() {
		if($this->isGet()) {
			$editOfficeId = ParamsUtil::getQueryParamNumeric("edit_id", 0);
			if($editOfficeId) {
                $office = $this->OfficeDao->getOfficeById($editOfficeId);
                if(!empty($office['office_pos_code'])){
                    $arr_office_pos_code = explode("-", $office['office_pos_code']);
                    $office['office_pos_code1'] = $arr_office_pos_code[0];
                    $office['office_pos_code2'] = $arr_office_pos_code[1];
                }
				$this->setViewState($office);
				$this->setView("input.php");
			} else {
				$this->setErrorNotFoundMessage();
				ActionUtil::redirect(PageIdConstants::OFFICE);
			}
		} else {
			$this->regist();
		}
	}

	public function delete() {
		$deleteOfficeId = ParamsUtil::getPostParamNumeric("delete_id", 0);
        $rowAffected = 0; 
        if($deleteOfficeId) {
            $rowAffected = $this->OfficeDao->delete($deleteOfficeId);
            if($rowAffected > 0) {
                // delete success
                $this->setDeleteSuccessMessage();
            }
        } 
        if($rowAffected <= 0) {
            // submit data is error or delete not success
            $this->setErrorNotFoundMessage();

        }
        $redirect = ParamsUtil::getPostParam("redirect");
        if($redirect == null) {
            $redirect = PageIdConstants::OFFICE;
        }
        // show list
        ActionUtil::redirect($redirect);
	}

	private function validates($params) {

		$validateOpts = array(
			array(
				"itemId" => "office_name"
				, "itemName" => "事業所名"
				, "types" => array(ValidateUtil::_IS_NULL, ValidateUtil::_IS_MAX)
				, "data" => $params["office_name"]
				, "max" => 200
			),
			array(
				"itemId" => "office_name_kana"
				, "itemName" => "事業所名&#12288;カナ"
				, "types" => array(ValidateUtil::_IS_MAX, ValidateUtil::_IS_KANA)
				, "data" => $params["office_name_kana"]
				, "max" => 200
			),
			array(
				"itemId" => "office_pos_code"
				, "itemName" => "郵便番号"
				, "types" => array(ValidateUtil::_IS_NULL, ValidateUtil::_IS_POSTAL_CODE)
				, "data" => $params["office_pos_code"]
			),
			array(
				"itemId" => "office_prefectures"
				, "itemName" => "都道府県"
				, "types" => array(ValidateUtil::_IS_NULL,ValidateUtil::_IS_MAX, ValidateUtil::_IS_NUM)
				, "data" => $params["office_prefectures"]
				, "max" => 128
			),
			array(
				"itemId" => "office_city"
				, "itemName" => "市区町村"
				, "types" => array(ValidateUtil::_IS_MAX)
				, "data" => $params["office_city"]
                , "max" => 250
			),
            array(
                "itemId" => "office_address"
                , "itemName" => "番地"
                , "types" => array(ValidateUtil::_IS_MAX)
                , "data" => $params["office_address"]
                , "max" => 500
            ),
            array(
                "itemId" => "office_mansion_info"
                , "itemName" => "マンション/ビル名等"
                , "types" => array(ValidateUtil::_IS_MAX)
                , "data" => $params["office_mansion_info"]
                , "max" => 250
            ),
            array(
                "itemId" => "office_phone_num"
                , "itemName" => "電話番号"
                , "types" => array(ValidateUtil::_IS_NULL, ValidateUtil::_IS_TELPHONE)
                , "data" => $params["office_phone_num"]
            ),
            array(
                "itemId" => "office_fax_num"
                , "itemName" => "FAX番号"
                , "types" => array(ValidateUtil::_IS_FAX)
                , "data" => $params["office_fax_num"]
            ),
            array(
                "itemId" => "office_email"
                , "itemName" => "メールアドレス"
                , "types" => array(ValidateUtil::_IS_MAX, ValidateUtil::_IS_MAIL)
                , "data" => $params["office_email"]
                , "max" => 100
            ),
            array(
                "itemId" => "office_memo"
                , "itemName" => "その他備考"
                , "types" => array(ValidateUtil::_IS_MAX)
                , "data" => $params["office_memo"]
                , "max" => 2000
            ),
		);

		$this->validate->validates($validateOpts);
		return !$this->validate->hasError();

	}

    private function doRegist($params) {
        $id = null;
        $editOfficeId = null;
        if(array_key_exists("office_id", $params)) {
            $editOfficeId = $params["office_id"];
        }
        if(!StringUtil::isNullOrEmpty($editOfficeId)) {
            $id = $this->OfficeDao->update(
                $params
                , array("where" => "office_id = :edit_id", "params" => array("edit_id" => $editOfficeId))
            );
        } else {
            $id = $this->OfficeDao->insert($params);    
        }
        return $id;
    }

    private function validatesSearch($params) {
          
        $validateOpts = array(
            array(
                "itemId" => "office_name"
                , "itemName" => "事業所名"
                , "types" => array(ValidateUtil::_IS_MAX)
                , "data" => $params["office_name"]
                , "max" => 200
            ),
            array(
                "itemId" => "office_prefectures"
                , "itemName" => "都道府県"
                , "types" => array(ValidateUtil::_IS_NUM)
                , "data" => $params["office_prefectures"]
                , "max" => 128
            ),
        );
        
        $this->validate->validates($validateOpts);
        return !$this->validate->hasError();
    } 

}

?>