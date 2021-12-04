<?php

/**
**/
require_once ROOT_PATH_COMMON . "/MessageConstants.php";
require_once ROOT_PATH_DAO . "/core/DbManager.php";
require_once ROOT_PATH_DAO . "/MStaffDao.php";
require_once ROOT_PATH_DAO . "/MOfficeDao.php";
require_once ROOT_PATH_DAO . "/MStaffRoleDao.php";
class StaffAction extends BaseAction {
	public function rules() {
		return array(
			"search" => array("post", "get")
			, "regist" => array("post", "get")
			, "edit" => array("post", "get")
			, "delete" => "post"
		);
	}

	public function ajaxActions(){
		return array('checkUpdateRole');
	}

	public function render() {
		// set url for screen
		$this->setAttribute("urlRegist", ActionUtil::getActionUrl(PageIdConstants::STAFF, "regist"));
		$this->setAttribute("urlSearch", ActionUtil::getActionUrl(PageIdConstants::STAFF, "search"));
		$this->setAttribute("urlEdit", ActionUtil::getActionUrl(PageIdConstants::STAFF, "edit"));
		$this->setAttribute("urlDelete", ActionUtil::getActionUrl(PageIdConstants::STAFF, "delete"));
		$this->setAttribute("urlAjaxOffice", ActionUtil::getActionUrl(PageIdConstants::OFFICE, "ajaxgetoffice"));
		$this->setAttribute('urlCheckUpdateRole', ActionUtil::getActionUrl(PageIdConstants::STAFF, 'checkUpdateRole'), false);
	}

	public function index() {
		$this->search();
	}

	public function search() {
	
		$pageSize = ParamsUtil::getQueryParamNumeric("page_size", AppConfig::$DEFAULT_PAGE_SIZE);
		$currentPage = ParamsUtil::getQueryParamNumeric("current_page", 1);
		$totalRow = 0;
		$this->getDataStaffAndOffice();

		//lấy giá khi form request
		$params['staff_id']  = ParamsUtil::getQueryParam("staff_id",null);
		$params['staff_office_id']  = ParamsUtil::getQueryParamNumeric("staff_office_id",null);
		$params['staff_department_id']  = ParamsUtil::getQueryParamNumeric("staff_department_id",null);
		$params['staff_name'] = ParamsUtil::getQueryParam("staff_name",null);
		$params['staff_phone_num'] = ParamsUtil::getQueryParam("staff_phone_num",null);
		$params['staff_email'] = ParamsUtil::getQueryParam("staff_email",null);

		$this->validates_search($params);
		if($this->validate->hasError()){
			$params = array();
		}
		
		$staffDao = new MStaffDao();
		$sortCondition .= " IFNULL(m_staff.updated_time, m_staff.created_time) desc";
	
		$lStaff = $staffDao->getWithPagging($currentPage, $pageSize, $sortCondition, $totalRow, $params);

		if(isset($lStaff) && count($lStaff) > 0) {
			$this->setAttribute("lStaff", $lStaff);
		} else {
			$this->validate->addError(MessageConstants::COM_INFO_SEARCH_RESULT_NOT_FOUND);
		}
		$this->setAttribute("currentPage", $currentPage);
		$this->setAttribute("totalRow", $totalRow);
		$this->setAttribute("pageSize", $pageSize);  
		$this->setView("view.php");
	}

	public function regist() {
		$regist_step = ParamsUtil::getPostParam("regist_step", 0);
	
		$view = null;
		$this->getDataStaffAndOffice();
		$staffDao = new MStaffDao();
		// create or back from the screen preview
		if($regist_step == 0 || $regist_step == 3) {
			$view = "input.php";
			$params = $this->jsonDecode(ParamsUtil::getPostParam("json_regist_data"));
			$this->setViewState($params);
		} else if($regist_step == 1) { // move to the screen preview
			$params = ParamsUtil::getPostParams(array(
				"staff_id"
				, "staff_name"
				, "staff_name_kana"
				, "staff_office_id"
				, "staff_department_id"
				, "staff_password"
				, "staff_role"
				, "staff_pos_code"
				, "staff_pos_code1"
				, "staff_pos_code2"
				, "staff_prefectures"
				, "staff_city"
				, "staff_address"
				, "staff_mansion_info"
				, "staff_phone_num"
				, "staff_email"
				, "staff_supervisor"
				, "staff_is_notify_mail"
				, "staff_memo"
				, "deleted_flag"
				, "created_user"
				, "created_time"
				, "updated_user"
				, "updated_time"
				, "change_pass"
				, "security_key"
				, "show_securiy"));
			$params['staff_pos_code'] = $params['staff_pos_code1'].'-'.$params['staff_pos_code2'];
            $isExistEmail = $staffDao->isExistEmail($params['staff_email'], $params['staff_id']);
            if($isExistEmail){
            	$this->validate->addError(
            		$this->validate->messageFormat(MessageConstants::COM_ERR_DUPLICATE, array("メールアドレス")),"staff_email"
            	);
            }
            $need_check_security = $this->needcheckSecurity($params['staff_id'], $params['staff_role']);

            if($need_check_security === true){
            	$check_security = strcmp(AppConfig::$SECURITY_KEY, $params['security_key']);
            	if($check_security !== 0){
            		$this->validate->addError(
	            		$this->validate->messageFormat(MessageConstants::COM_ERR_SECURITY_FALSE, array("権限")),"security_key"
	            	);
	            	$this->setViewState(array('show_securiy' => true));
            	}
            }
			$this->validates($params);		
			if(!$this->validate->hasError()) {
				$this->setViewState(array("json_regist_data" => $this->jsonEncode($params)));
				$view = "preview.php";
			} else {
				$this->validate->addError($this->validate->messageFormat(MessageConstants::COM_ERR_HAPPENED));
				$view = "input.php";
			}
		} else if($regist_step == 2) {
			$params = $this->jsonDecode(ParamsUtil::getPostParam("json_regist_data"));
			$isExistEmail = $staffDao->isExistEmail($params['staff_email'], $params['staff_id']);
            if($isExistEmail)
            {
            	$this->validate->addError(
            		$this->validate->messageFormat(MessageConstants::COM_ERR_DUPLICATE, array("メールアドレス")),"staff_email"
            	);
            }
			$this->validates($params);			
			if($this->validate->hasError()) {
				$this->validate->addError($this->validate->messageFormat(MessageConstants::COM_ERR_HAPPENED));
				$view = "input.php";
			} else {
				if(empty($params['staff_password']) && !empty($params['staff_id']))
				{
					unset($params['staff_password']);
				}
				else
				{
					$params['staff_password'] = md5($params['staff_password']);
				}
				unset($params['staff_pos_code1']);
				unset($params['staff_pos_code2']);
				$result = $staffDao->doRegist($params);
				if(StringUtil::isNullOrEmpty($params["staff_id"])) {
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
			$redirect = ParamsUtil::getPostParam("redirect");
			if($redirect == null) {
				$redirect = PageIdConstants::STAFF;
			}
			ActionUtil::redirect($redirect);
		}
		if(!StringUtil::isNullOrEmpty($view)) {
			$this->setView($view);
		}
	}

	public function edit() {
		if($this->isGet()) {
			$editStaffId = ParamsUtil::getQueryParamNumeric("edit_staff_id", 0);
			$staffDao = new MStaffDao();
			$staff  = $staffDao->getUserById($editStaffId);
			if($editStaffId && !StringUtil::isNullOrEmpty($staff)) {
				$this->getDataStaffAndOffice($editStaffId);
				$staffroleDao = new MStaffRoleDao();
				$staff_role =  $staffroleDao->selectByStaffId($staff['staff_id']);
				$staff['staff_role'] = array();
				foreach ($staff_role as  $value) {
					$staff['staff_role'][] = $value['role_id'];
				}
				$staff["staff_password"] = "";
				if(!empty($staff['staff_pos_code'])){
					$tmp_staff_pos = explode("-", $staff['staff_pos_code']);
					$staff['staff_pos_code1'] = $tmp_staff_pos[0];
					$staff['staff_pos_code2'] = $tmp_staff_pos[1];
				}
				$this->setViewState($staff);
				$this->setView("input.php");
			} else {
				$this->setErrorNotFoundMessage();
				ActionUtil::redirect(PageIdConstants::STAFF);
			}
		} else {
			$this->regist();
		}
	}

	public function delete() {
		$deleteStaffId = ParamsUtil::getPostParam("delete_staff_id");
		$rowAffected = 0; 
		if($deleteStaffId) {
			$staffDao = new MStaffDao();
			$rowAffected = $staffDao->deleteLogic($deleteStaffId);
			if($rowAffected) {
				// delete success
				$this->setDeleteSuccessMessage();
			}
		} 
		if(!$rowAffected) {
			// submit data is error or delete not success
			$this->setErrorNotFoundMessage();
		}

		$redirect = ParamsUtil::getPostParam("redirect");

		if($redirect == null) {
            $redirect = PageIdConstants::STAFF;
            ActionUtil::redirect($redirect);
        }else {
            header('Location:'.$redirect);
        }
	}

	private function validates($params) {
		$validateOpts = array(
			array(
				"itemId" => "staff_name"
				, "itemName" => "社員名"
				, "types" => array(ValidateUtil::_IS_NULL, ValidateUtil::_IS_MAX)
				, "data" => $params["staff_name"]
				, "max" => 100
			),
			array(
				"itemId" => "staff_name_kana"
				, "itemName" => "社員名　カナ"
				, "types" => array(ValidateUtil::_IS_MAX, ValidateUtil::_IS_KANA)
				, "data" => $params["staff_name_kana"]
				, "max" => 100
			),
			array(
				"itemId" => "staff_office_id"
				, "itemName" => "事業所名"
				, "types" => array(ValidateUtil::_IS_NULL)
				, "data" => $params["staff_office_id"]
			),
			array(
				"itemId" => "staff_department_id"
				, "itemName" => "部署"
				, "types" => array(ValidateUtil::_IS_NULL)
				, "data" => $params["staff_department_id"]
			),
			array(
				"itemId" => "staff_role_placehole"
				, "itemName" => "権限"
				, "types" => array(ValidateUtil::_IS_NULL)
				, "data" => $params["staff_role"]
			),
			array(
				"itemId" => "staff_pos_code"
				, "itemName" => "郵便番号"
				, "types" => array(ValidateUtil::_IS_NULL, ValidateUtil::_IS_POSTAL_CODE)
				, "data" => $params["staff_pos_code"]
			),
			array(
				"itemId" => "staff_prefectures"
				, "itemName" => "都道府県"
				, "types" => array(ValidateUtil::_IS_NULL)
				, "data" => $params["staff_prefectures"]
			),
			array(
				"itemId" => "staff_city"
				, "itemName" => "市区町村 "
				, "types" => array(ValidateUtil::_IS_MAX)
				, "data" => $params["staff_city"]
				, "max" => 250
			),
			array(
				"itemId" => "staff_address"
				, "itemName" => "番地"
				, "types" => array(ValidateUtil::_IS_MAX)
				, "data" => $params["staff_address"]
				, "max" => 500
			),
			array(
				"itemId" => "staff_mansion_info"
				, "itemName" => "マンション/ビル名等 "
				, "types" => array(ValidateUtil::_IS_MAX)
				, "data" => $params["staff_mansion_info"]
				, "max" => 250
			),
			array(
				"itemId" => "staff_phone_num"
				, "itemName" => "電話番号"
				, "types" => array(ValidateUtil::_IS_NULL, ValidateUtil::_IS_TELPHONE)
				, "data" => $params["staff_phone_num"]
			),
			array(
				"itemId" => "staff_email"
				, "itemName" => "メールアドレス"
				, "types" => array(ValidateUtil::_IS_NULL, ValidateUtil::_IS_MAIL)
				, "data" => $params["staff_email"]
			),
			array(
				"itemId" => "staff_password"
				, "itemName" => "ログインパスワード"
				, "types" => array(ValidateUtil::_IS_NULL, ValidateUtil::_IS_MAX_MIN)
				, "data" => $params["staff_password"]
				, "max" => 10
				, "min" => 6
			),
			array(
				"itemId" => "staff_memo"
				, "itemName" => "その他備考"
				, "types" => array(ValidateUtil::_IS_MAX)
				, "data" => $params["staff_memo"]
				, "max" => 2000
			),
		);	
		if(!empty($params['staff_id']) && empty($params['change_pass'])){
			unset($validateOpts[12]);
		}
		$this->validate->validates($validateOpts);
		return !$this->validate->hasError();
	}

	private function validates_search($params){
		//var_dump($params);die;
		$validateOpts = array(
			array(
				"itemId" => "staff_id"
				, "itemName" => "社員ID"
				, "types" => array(ValidateUtil::_IS_NUM)
				, "data" => $params["staff_id"]
			)
		);
		$this->validate->validates($validateOpts);
		return !$this->validate->hasError();
	}

	public function getDataStaffAndOffice($staff_id=null){
		$staffDao = new MStaffDao();
		$officeDao = new MOfficeDao();
		//get list staff forum m_staff for supervisor dropdown
		if($staff_id != null)
			$lstaff = $staffDao->getSuperviserEdit($staff_id);
		else
			$lstaff = $staffDao->getAllStaff();
		$this->setAttribute("lstaff", $lstaff);
		//get list office forum m_office_info office dropdown
		$loffice = $officeDao->getOfficeArrray();
		$this->setAttribute("loffice", $loffice);
	}

	//全ての案件の変更メールを受け取る was checked
	public function getUserSendMail(){
		$sql = "SELECT * FROM m_staff WHERE staff_is_notify_mail = 1 AND deleted_flag <> 1";
		return $this->select($sql);
	}

	public function checkUpdateRole(){
		$staff_id    = ParamsUtil::getPostParam('staff_id');
		$staff_roles = ParamsUtil::getPostParam('roles');
		$check = $this->needcheckSecurity($staff_id, $staff_roles);
		if($check===true)
			return json_encode(array('change'=>1));
		else
			return json_encode(array('change'=>0));
	}

	public function needcheckSecurity($staff_id, $staff_roles){
		if(StringUtil::isNullOrEmpty($staff_id)){
			if(ArrayUtil::isNullOrEmpty($staff_roles)){
				return false;
			}
			if(in_array(5, $staff_roles) || in_array(6, $staff_roles)){
				return true;
			}else{
				return false;
			}
		}else{
			$staff_role = new MStaffRoleDao();
			$roles_old 	= $staff_role->selectByStaffId($staff_id);
			$roles_old  = ArrayUtil::getValueOfArray($roles_old, 'role_id');
			//return json_encode($roles_old);
			$check1 = in_array(5, $roles_old);
			$check2 = in_array(6, $roles_old);

			if(!ArrayUtil::isNullOrEmpty($staff_roles))
			{
				$check3 = in_array(5, $staff_roles);
				$check4 = in_array(6, $staff_roles);

				if(!$check3 && !$check4){
					return false;
				}elseif($check3){
					if($check1 !== $check3){
						return true;
					}
					else{
						return false;
					}
				}else{
					if($check2 !== $check4)
					{
						return true;
					}
					else{
						return fasle;
					}
				}
				
			}else{
				return false;
			}
		}
	}
}

?>