<?php
/**
*
*/
require_once ROOT_PATH_COMMON . "/MessageConstants.php";
require_once ROOT_PATH_COMMON . "/SessionManager.php";
require_once ROOT_PATH_DAO . "/MStaffDao.php";
require_once ROOT_PATH_DAO ."/MStaffRoleDao.php";
require_once ROOT_PATH_DAO . "/core/DbManager.php";

class loginAction extends BaseAction {

	public function rules() {
		return array(
			"login" => "post"
			, "logout" => array("post", "get")
		);
	}

	public function render() {
		$this->setView("login.php");
		$this->setAttribute("urlLogin", ActionUtil::getActionUrl(PageIdConstants::LOGIN, "login"));
		
		$dbManger = DbManager::getInstance();
		$dbManger->beginTransaction();
		$result = $dbManger->selectAll('m_staff');
		
		$result_ex = json_encode($dbManger->pushArr($result));
		
		$this->setAttribute("result_ex", $result_ex );
	}

	public function login() {
		$userLoginame = ParamsUtil::getPostParam("staff_email");
		$userPassowrd = ParamsUtil::getPostParam("staff_password");
		// check validation
		$this->validates($userLoginame, $userPassowrd);
		if(!$this->validate->hasError()) {
			$staffDao = new MStaffDao();
			$dbManger = DbManager::getInstance();
			try {
				$dbManger->beginTransaction();
				$user = $staffDao->getUser($userLoginame, md5($userPassowrd));
				if($user) {
					$staffRoleDao = new MStaffRoleDao();
					$user["roles"] = $staffRoleDao->selectByStaffId($user['staff_id']);
				}
				$dbManger->commit();
			} catch (Exception $e) {
			   	$exception = $e;
			}
			$dbManger->rollback();
			if($user) {
				$session = new SessionManager();
				$session->setLoginInfo($user);
				// move to top page
				ActionUtil::redirect(PageIdConstants::INDEX);
			} else {
				$this->validate->addError(MessageConstants::LOGIN_NOT_SUCCESS);
			}
		}
	}
	
	private function validates($userLoginame, $userPassowrd) {
		$validateOpts = array(
			array(
				"itemId" => "staff_email"
				, "itemName" => "メールアドレス"
				, "types" => array(ValidateUtil::_IS_NULL, ValidateUtil::_IS_MAX)
				, "data" => $userLoginame
				, "max" => 100
			),
			array(
				"itemId" => "staff_password"
				, "itemName" => "管理者パスワード"
				, "types" => array(ValidateUtil::_IS_NULL, ValidateUtil::_IS_MAX)
				, "data" => $userPassowrd
				, "max" => 128
			)
		);
		
		$this->validate->validates($validateOpts);
		return !$this->validate->hasError();
	}

	public function logout() {
		$session = new SessionManager();
		$session->logout();
		$this->setAttribute("isLogout", true);
	}
}
?>