<?php
require_once ROOT_PATH_COMMON . "/SessionKeyConstants.php";

class SessionManager {
	public function __construct() {
		if(!session_id()) {
			@session_start();
		}
	}
	
	public function getLoginInfo() {
		return $this->get(SessionKeyConstants::USER_LOGIN_INFO);
	}

	public function getLoginUserId() {
		$user = $this->getLoginInfo();
		if(isset($user)) {
			return $user["staff_id"];
		}
		return null;
	}
	
	public function getUserRole() {
		$user = $this->getLoginInfo();
		if(isset($user)) {
			return $user["roles"];
		}
		return null;
	}
	
	public function constraintKey($key) {
		return $this->get($key) != null;
	}

	public function isLogin() {
		return $this->getLoginInfo() != null;
	}

	public function set($key, $value) {
		$_SESSION[$key] = $value;
	}

	public function get($key) {
		if(isset($_SESSION) && array_key_exists($key, $_SESSION)) {
			return $_SESSION[$key];
		}
		return null;
	}

	public function setLoginInfo($user) {
		$this->set(SessionKeyConstants::USER_LOGIN_INFO, $user);
	}
	
	public function getToken() {
		$csrf = $this->get(SessionKeyConstants::APP_CSRF);
		if(StringUtil::isNullOrEmpty($csrf)) {
			// set cross site request forgery(CSRF)
			$csrf = StringUtil::randomString(10);
			$this->set(SessionKeyConstants::APP_CSRF, $csrf);
		}
		return $csrf;
	}

	public function remove($key) {
		unset($_SESSION[$key]);
	}

	public function logout() {
        // remove all session base on SessionKeys.php
        $session = new ReflectionClass("SessionKeyConstants");
        $sessionKeys = $session->getConstants();
        foreach ($sessionKeys as $value) {
            $this->remove($value);
        }
    }


}


?>