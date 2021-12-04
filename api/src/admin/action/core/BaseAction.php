<?php
/**
*
*/
class ViewState
{
	const VIEW_CONTENT = 0;
	const JS_VARIABLE = 1;
	private $viewState;
	public function add($values, $replace = false) {
		if(!isset($this->viewState)) {
			$this->viewState = array();
		}
		if(is_array($values)) {
			foreach ($values as $key => $value) {
				if(!array_key_exists($key, $this->viewState) || $replace) {
					$this->viewState[$key] = $value;
				}
			}
		}
	}
	public function get($name, $type = ViewState::VIEW_CONTENT) {
		$val = isset($this->viewState) && isset($this->viewState[$name]) ? $this->viewState[$name] : null;
		if($val === null) {
			$val = ParamsUtil::getPostParam($name);
			if($val == null) {
				$val = ParamsUtil::getQueryParam($name);
			}
		}
		if($val === null) {
			return $type == ViewState::VIEW_CONTENT ? "" : "null";
		}
		if(!is_array($val)) {
			return htmlspecialchars($val, ENT_QUOTES, 'UTF-8');
		}
		return $val;
	}
	public function getChecked($name, $val = null) {
		$getVal = isset($this->viewState) && isset($this->viewState[$name]) ? $this->viewState[$name] : null;
		if($getVal === null) {
			return "";
		}
		if((isset($val) && $val == $getVal) || !isset($val)) {
			return "checked";
		} 
		return "";
	}
}
require_once ROOT_PATH_COMMON . "/SessionManager.php";
abstract class BaseAction {
	private $gobalAttributeName = array(
		"viewPath" => "viewPath"
		, "errorViewPath" => "errorViewPath"
		, "listErrorMessage" => "listErrorMessage"
		, "userInfo" => "userInfo"
		, "urlLogout" => "urlLogout"
		, "viewState" => "viewState"
	);
	protected $logger;

	protected $validate;

	protected $attributes;

	public $pageId;

	public $view;

	protected $autoControlMessage;
  	
  	protected $session;

  	protected $viewState;

  	protected $role;

  	protected $login_id;

	public function __construct()
    {
    	$this->autoControlMessage = true;
    	$this->logger = LoggerManager::getLogger("ACTION");
    	$this->validate = new ValidateUtil();
		$this->session = new SessionManager();
		$this->role = ArrayUtil::getValueOfArray($this->session->getUserRole(),'role_id');
		$this->login_id = $this->session->getLoginUserId();
    }

	protected function isPost() {
		return ("post" == strtolower($_SERVER['REQUEST_METHOD']));
	}
	
	protected function isGet() {
		return "get" == strtolower($_SERVER['REQUEST_METHOD']);
	}

	public function rules() {
		return array();
	}

	public function ajaxActions() {
		return array();
	}

	protected function setViewState($viewState = null) {
		if(
			!isset($this->attributes) 
			|| !array_key_exists($this->gobalAttributeName["viewState"], $this->attributes)
		) {
			$this->attributes[$this->gobalAttributeName["viewState"]] = new ViewState();
		}
		if(isset($viewState)) {
			//$this->logger->debug("BaseAction#setViewState(user set view state):" . print_r($viewState, true));
			$this->attributes[$this->gobalAttributeName["viewState"]]->add($viewState, true);
		}
	}

	public function setView($view) {
		$this->view = $view;
	}
	
	public function getView() {
		$notView = StringUtil::isNullOrEmpty($this->view);
		if($notView && !StringUtil::isNullOrEmpty($this->pageId)) {
	 		$defaults = array("index", "view", "default");
	 		foreach ($defaults as $value) {
	 			$path = ROOT_PATH_VIEW  . '/' . $this->pageId . "/" . $value . ".php";
	 			if(file_exists($path)) {
	 				$this->view = $path;
	 				return $this->view;
	 			}
	 		}
		}
		return $notView ? null : (ROOT_PATH_VIEW  . '/' . $this->pageId . "/" . $this->view);
	}
	
	public function setAttribute($name, $value, $isHtmlEscape = true) {
		if(in_array($name, $this->gobalAttributeName)) {
			throw new InvalidArgumentException("The attribute name [$name] is conflit in master variable.");
		}
		if($this->attributes == null) {
			$this->attributes = array();
		}
		if(is_string($value) && $isHtmlEscape) {
			$value = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
		} else if(is_array($value)) {
            $value = $this->arrayHtmlspecialchars($value);
		}
		$this->attributes[$name] = $value;

	}
	
	private function arrayHtmlspecialchars($variable)
    {
        if (is_string($variable)) {
            return htmlspecialchars($variable, ENT_QUOTES, 'UTF-8');
        }
        if (is_array($variable)) {
            foreach( $variable as $key => $value ) {
                $variable[$key] = $this->arrayHtmlspecialchars($value);
            }   
        } 
        return $variable; 
    }

	public function getAttribute($name) {
		$result = null;
		if($this->attributes != null && array_key_exists($name, $this->attributes)) {
			$result = $this->attributes[$name];
		}
		return $result;
	}

	public function processAction() {
	 	$viewLoader = new ViewLoader();
	 	if($this->autoControlMessage && $this->validate->hasError()) {
			$this->attributes[$this->gobalAttributeName["listErrorMessage"]] = $this->validate->getErrors();
			
		} else if($this->session->constraintKey(SessionKeyConstants::STATUS_MESSAGE)) {
			$this->attributes[$this->gobalAttributeName["listErrorMessage"]] = array("message" => $this->session->get(SessionKeyConstants::STATUS_MESSAGE));
			$this->session->remove(SessionKeyConstants::STATUS_MESSAGE);
		}
		$this->logger->debug("processAction#attributes:" . print_r($this->attributes, true));
	 	$viewLoader->loadViewAdmin($this->getView(), $this->attributes, PageIdConstants::LOGIN == $this->pageId);
	 	$viewLoader->show();
	}
	
	public function loadMasterData() {
		$this->setViewState();	
    	if($this->session->isLogin()) {
    		DbManager::setProcessUserId($this->session->getLoginUserId());
		}
    }
	
	public function loadDataForTheme() {
		if($this->session->isLogin()) {
			if($this->attributes == null) {
				$this->attributes = array();
			}
			$staff_role = $this->session->getUserRole();
			$role_login_id = $this->setRole($staff_role);

			if($this->checkRole(PageIdConstants::EVENT,$staff_role))
			{
				//社員検索
				$this->setAttribute("headerUrlEvent", ActionUtil::getActionUrl(PageIdConstants::EVENT));
				$this->setAttribute("headerUrlEventRegist", ActionUtil::getActionUrl(PageIdConstants::EVENT, "regist"));
			}

			if($this->checkRole(PageIdConstants::STAFF,$staff_role))
			{
				//社員検索
				$this->setAttribute("headerUrlStaff", ActionUtil::getActionUrl(PageIdConstants::STAFF));
				$this->setAttribute("headerUrlStaffRegist", ActionUtil::getActionUrl(PageIdConstants::STAFF, "regist"));
			}

			if($this->checkRole(PageIdConstants::OFFICE,$staff_role))
			{
				//事業所検索
				$this->setAttribute("headerUrlOffice", ActionUtil::getActionUrl(PageIdConstants::OFFICE));
				$this->setAttribute("headerUrlOfficeRegist", ActionUtil::getActionUrl(PageIdConstants::OFFICE, "regist"));
			}

			if($this->checkRole(PageIdConstants::PROJECT,$staff_role))
			{
				//案件検索
				$this->setAttribute("headerUrlProject", ActionUtil::getActionUrl(PageIdConstants::PROJECT));
				$this->setAttribute("headerUrlProjectRegist", ActionUtil::getActionUrl(PageIdConstants::PROJECT, "regist"));
				$this->setAttribute("headerUrlProjectCal", ActionUtil::getActionUrl(PageIdConstants::PROJECT, "cal"));
				$this->setAttribute("headerUrlProjectImp", ActionUtil::getActionUrl(PageIdConstants::PROJECT, "imp"));
			}

			if($this->checkRole(PageIdConstants::PAYMENT,$staff_role))
			{
				//入金状況検索
				$this->setAttribute("headerUrlPayment", ActionUtil::getActionUrl(PageIdConstants::PAYMENT));
			}

			if($this->checkRole(PageIdConstants::KANKO,$staff_role))
			{
				//定期点検リスト
				$this->setAttribute("headerUrlKanko", ActionUtil::getActionUrl(PageIdConstants::KANKO));
			}

			if($this->checkRole(PageIdConstants::INCENTIVE,$staff_role))
			{
				//歩合集計
				$this->setAttribute("headerUrlIncentive", ActionUtil::getActionUrl(PageIdConstants::INCENTIVE));
			}
			$this->setAttribute("UrlIndex", ActionUtil::getActionUrl(PageIdConstants::INDEX));
			$this->attributes[$this->gobalAttributeName["userInfo"]] = $this->session->getLoginInfo();
			$urlLogout = ActionUtil::getActionUrl(PageIdConstants::LOGIN, "logout");
			$this->attributes[$this->gobalAttributeName["urlLogout"]] = $urlLogout;
		}
    }

    public function jsonEncode($object) {
    	return json_encode($object);
    }

    public function jsonDecode($string) { 
    	return json_decode($string, true);
    }

	public function init() {
		
	}

	public function render() {
		
	}

	public function resource() {
		// process for Ajax, Download file,... 	
	}
	
	protected function setUpdateSuccessMessage($message = null) {
		if($message == null) {
			$message = MessageConstants::COM_INFO_UPDATE_SUCCESS;
		}
		$this->session->set(SessionKeyConstants::STATUS_MESSAGE, $message);
	}

	protected function setInsertSuccessMessage($message = null) {
		if($message == null) {
			$message = MessageConstants::COM_INFO_ADD_SUCCESS;
		}
		$this->session->set(SessionKeyConstants::STATUS_MESSAGE, $message);
	}

	protected function setDeleteSuccessMessage($message = null) {
		if($message == null) {
			$message = MessageConstants::COM_INFO_DELETE_SUCCESS;
		}
		$this->session->set(SessionKeyConstants::STATUS_MESSAGE, $message);
	}

	protected function setErrorNotFoundMessage($message = null) {
		if($message == null) {
			$message = MessageConstants::COM_ERR_DATA_NOT_FOUND;
		}
		$this->session->set(SessionKeyConstants::STATUS_MESSAGE, $message);
	}

	protected function setErrorExclusiveMessage($message = null) {
		if($message == null) {
			$message = MessageConstants::COM_ERR_EXCLUSIVE;
		}
		$this->session->set(SessionKeyConstants::STATUS_MESSAGE, $message);
	} 

	protected function sortColumns() {
		return array();
	}
	
	protected function getSortCondition($sortConditionName = "sort_condition") {
		$sortCondition = ParamsUtil::getQueryParam($sortConditionName);
		if(!StringUtil::isNullOrEmpty($sortCondition)) {
			$flag = false;
			$sort = strtolower($sortCondition);
			foreach ($this->sortColumns() as $key => $value) {
				$sortval = strtolower($value);
				if(($sortval . " desc") == $sort || ($sortval . " asc") == $sort) {
					$flag = true;
					break;
				}
			}
			if($flag) {
				return $sortCondition;
			}
		} 
		return null;
	}

	protected function checkRole($pageId,$staff_role){
		$allow = false;
		$pages = array();
		foreach ($staff_role as  $value) {
			$pages = array_merge($pages, AppConfig::$R_ROLE_PAGE[$value['role_id']]);
		} 
		foreach ($pages as $key => $value) {
			if(strtoupper($key) == strtoupper($pageId)){
				$allow = true; 
				break;
			}
		}
		return $allow;
	}

	protected function setRole($role){
		$role_login_id = array('role_login_id' =>ArrayUtil::getValueOfArray($role,'role_id'));
		$this->setViewState($role_login_id);
	}

	protected function fixAllowOrigin(){
		header('Access-Control-Allow-Origin: *');
        if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
            $headers=getallheaders();
            @$ACRH=$headers["Access-Control-Request-Headers"];
            header("Access-Control-Allow-Headers: $ACRH");
        }
		header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
	}
}
?>