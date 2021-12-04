<?php
/**
*
*/
require_once ROOT_PATH_DAO . "/core/DbManager.php";
require_once ROOT_PATH_COMMON . "/SessionManager.php";

class RunAction
{
	public static function run($pageId, $method)
	{
		$pageId = trim($pageId);
		$method = trim($method);
		try {
			RunAction::initEnvironmentMode();
			$logger = LoggerManager::getLogger("ACTION");
			$logger->info("RunAction#run:[$pageId, $method]");
			$logger->debug("POST:" . print_r($_POST, true));
			$logger->debug("GET:" . print_r($_GET, true));
			RunAction::runActionScreen($pageId, $method);
			// if(StringUtil::isNullOrEmpty($pageId)) {
			// 	// redirect to index
				
			// 	ActionUtil::redirect(PageIdConstants::INDEX);
			// }
			// else if(!RunAction::checkPageAuthority($pageId)) {
			// 	$session = new SessionManager();
			// 	if($session->isLogin()) {
			// 		// Access is denied due to invalid credentials
			// 		ActionUtil::redirect(PageIdConstants::ERROR, "unauthorized");
			// 	} else {
			// 		// redirect to login
			// 		ActionUtil::redirect(PageIdConstants::LOGIN);
			// 	}
			// } 
			// else if(strtolower($method) == strtolower(REQUEST_PARAM_ACTION_METHOD_VALUE)) {
			// 	$reportId = ParamsUtil::getQueryParam(REQUEST_PARAM_ACTION_REPORT_ID);
			// 	RunAction::runActionReport($pageId, $reportId);
			// } else {
			// 	RunAction::runActionScreen($pageId, $method);
			// }
			
		} catch (Exception $e) {
			$session = new SessionManager();
			$session->remove(SessionKeyConstants::STATUS_MESSAGE);
		   	$logger->error($e->getMessage() . "(at " . $e->getTraceAsString() . ")");
		   	throw $e;
		}

	}
	
	private static function initEnvironmentMode() {
		if(ENVIRONMENT_MODE_DEBUG) {
			ini_set("display_errors", "On");
			error_reporting(E_ALL ^ E_NOTICE);
		} else {
			ini_set("display_errors", "Off");
			error_reporting(0);
		}
	}

	private static function runActionScreen($pageId, $method) {
		// check input request
	
		//check req have null with value not number
		if(StringUtil::isNullOrEmpty($pageId)) {
			throw new InvalidArgumentException("The pageId is require.");
		}
		
		$actionClass = ucfirst($pageId) . "Action";
		
		$actionFilePath = ROOT_PATH_ACTION . "/" . $actionClass . ".php";
		
		
		if(file_exists($actionFilePath)) {
			require_once $actionFilePath;
		} else {
			throw new Exception("The file [" . $actionFilePath . "] dose not exist");
		}

		$reflectionClass = new ReflectionClass($actionClass);
		if($reflectionClass == null) {
			throw new Exception("The class[" . $actionClass . "] dose not exists.");
		}

		$reflectionInstance = $reflectionClass->newInstance();

		$reflectionClass->getProperty('pageId')->setValue($reflectionInstance, $pageId);
		// get ajaxMethod rules
		$ajaxActions = RunAction::invokeMethod($reflectionInstance, $reflectionClass, "ajaxActions");
		$isAjaxAction = (is_array($ajaxActions) && in_array($method, $ajaxActions));
		if($isAjaxAction) {
			// check cross site scripting forgery if APP_CSRF is true
			if(!RunAction::checkCsrf()) {
				throw new Exception("The CSRF token is invalid.", 1);
			}
			echo RunAction::invokeMethod($reflectionInstance, $reflectionClass, $method);
		} else {
			$processAction = "processAction";
			// check method is exist
			if(method_exists($reflectionInstance, $method)) {
				// check cross site scripting forgery if APP_CSRF is true
				if(!RunAction::checkCsrf()) {
					throw new Exception("The CSRF token is invalid.", 1);
				}
				
				// load master data for template
				RunAction::invokeMethod($reflectionInstance, $reflectionClass, "loadMasterData");

				// get access rules
				$accessMethod = RunAction::invokeMethod($reflectionInstance, $reflectionClass, "rules");

				// check access rules
				if(isset($accessMethod) && isset($accessMethod[$method])) {
					$reqMethod = strtolower($_SERVER['REQUEST_METHOD']);
					if(
						(
							is_array($accessMethod[$method]) 
							&& in_array($reqMethod, array_map('strtolower', $accessMethod[$method]))
						)
						||
						(
							!is_array($accessMethod[$method]) 
							&& $accessMethod[$method] == $reqMethod
						)
					) {
						// call action method
						RunAction::invokeMethod($reflectionInstance, $reflectionClass, $method);
					} else {
						ActionUtil::redirect($pageId);
					}
				} else {
					// call action method
					RunAction::invokeMethod($reflectionInstance, $reflectionClass, $method);
				}

				// call render method
				//RunAction::invokeMethod($reflectionInstance, $reflectionClass, "render");
				
				// load data for theme
				//RunAction::invokeMethod($reflectionInstance, $reflectionClass, "loadDataForTheme");
				
				// call process view
				//RunAction::invokeMethod($reflectionInstance, $reflectionClass, $processAction);

			}
			else if(StringUtil::isNullOrEmpty($method)){
				// load master data
				RunAction::invokeMethod($reflectionInstance, $reflectionClass, "loadMasterData");
				// call index method
				RunAction::invokeMethod($reflectionInstance, $reflectionClass, "index");
				// call render method
				//RunAction::invokeMethod($reflectionInstance, $reflectionClass, "render");
				// load data for theme
				//RunAction::invokeMethod($reflectionInstance, $reflectionClass, "loadDataForTheme");
				// call process view
				//RunAction::invokeMethod($reflectionInstance, $reflectionClass, $processAction);
			} else {
			 	throw new InvalidArgumentException("The method [" . $method . "] dose not exist.");
			}
		}
	}
	
	private static function runActionReport($pageId, $reportId) {
		// check input request
		if(StringUtil::isNullOrEmpty($pageId)) {
			throw new InvalidArgumentException("The pageId is require.");
		}
		// check input request
		if(StringUtil::isNullOrEmpty($reportId)) {
			throw new InvalidArgumentException("The reportId is require.");
		}

		$actionClass = ucfirst($reportId) . "Action";
		
		$actionFilePath = ROOT_PATH_ACTION_REPORT . "/" . $actionClass . ".php";
		
		if(file_exists($actionFilePath)) {
			require_once $actionFilePath;
		} else {
			throw new Exception("The file [" . $actionFilePath . "] dose not exist");
		}

		$reflectionClass = new ReflectionClass($actionClass);
		if($reflectionClass == null) {
			throw new Exception("The class[" . $actionClass . "] dose not exists.");
		}

		$reflectionInstance = $reflectionClass->newInstance();

		$reflectionClass->getProperty('pageId')->setValue($reflectionInstance, $pageId);
		
		$reflectionClass->getProperty('reportId')->setValue($reflectionInstance, $reportId);
		
		if(isset(AppConfig::$REPORTS) && array_key_exists($reportId, AppConfig::$REPORTS)) {
			$reflectionClass->getProperty('reportTitle')->setValue($reflectionInstance, AppConfig::$REPORTS[$reportId]);
		}
		
		// check cross site scripting forgery if APP_CSRF is true
		if(!RunAction::checkCsrf()) {
			throw new Exception("The CSRF token is invalid.", 1);
		}
		$mode = ParamsUtil::getQueryParam(REQUEST_PARAM_ACTION_REPORT_METHOD);
		if($mode == "validate") {
			$result = RunAction::invokeMethod($reflectionInstance, $reflectionClass, "validate");
			echo json_encode($result);
		} else {
			RunAction::invokeMethod($reflectionInstance, $reflectionClass, "run");	
		}
	}

	private static function checkPageAuthority($pageId) {
		$allow = false;
		// check page is require login
		$session = new SessionManager();
		$pageNotRequire = AppConfig::$PAGE_NOT_REQUIRE_AUTHORITY;
		if(isset($pageNotRequire)) {
			foreach ($pageNotRequire as $key => $value) {
				if(strtoupper($key) == strtoupper($pageId)) {
					$allow = true;
					break;
				}
			}
		}
		if(!$allow && $session->isLogin()) {
			// check page permit
			$staff_role = $session->getUserRole();
			$pages = array();
			foreach ($staff_role as  $value) {
				$pages[] = AppConfig::$R_ROLE_PAGE[$value['role_id']];
			}
			$m_pages = array();
			foreach ($pages as $key => $value) {
				$m_pages = array_merge($m_pages,$value);
			}
			foreach ($m_pages as $key => $value) {
				if(strtoupper($key) == strtoupper($pageId)){
					$allow = true;
					break;
				}
			}
		} 
		return $allow;
	}
	
	private static function checkCsrf() {
		$result = true;
		if(APP_CSRF) {
			$session = new SessionManager();
			if($session->isLogin()) {
				$result = ParamsUtil::getQueryParam("token") == $session->getToken();
			}	
		}
		return $result;
	}

	private static function invokeMethod($reflectionInstance, $reflectionClass, $method, $isRequire = false) {
		if(method_exists($reflectionInstance, $method)) {
			$reflectionMethod = $reflectionClass->getMethod($method);
			return $reflectionMethod->invoke($reflectionInstance);	
		} else if($isRequire) {
		 	throw new InvalidArgumentException("The method [" . $method . "] dose not exist.");
		}
		
	}

}

?>