<?php

/**
**/
require_once ROOT_PATH_COMMON . "/MessageConstants.php";
require_once ROOT_PATH_DAO . "/core/DbManager.php";
require_once ROOT_PATH_DAO . "/MEventDao.php";
require_once ROOT_PATH_DAO . "/MTypeEventDao.php";
class EventAction extends BaseAction {
    private $EventDao;
    public function __construct() {
        parent::__construct();
        $this->EventDao = new MEventDao();
    }
    
	public function rules() {
		return array(
			"search" => array("post", "get")
			, "regist" => array("post", "get")
			, "edit" => array("post", "get", "put")
			, "delete" => array("post", "delete")
			, "ajaxgetoffice" => array("post", "get")
			, "calendar" => array("post", "get")
			, "trash" => array("post", "get")
		);
	}

	public function copy(){
		$this->getDataTypeEvent();
		//Phương thức get
		if($this->isGet()) {	
			$editEventId = ParamsUtil::getQueryParamNumeric("id", 0);
			if($editEventId) {
                $event = $this->EventDao->getEventById($editEventId);

				$typeEvent = new MTypeEventDao();
				$getDataAll = $typeEvent->getAllTypeEvent();
				$this->setAttribute('dataTypeEvent',$getDataAll);

				$event['event_name'] .= " (copy)";
				$this->setViewState($event);
				$this->setView("input.php");
			} else {
				$this->setErrorNotFoundMessage();
				ActionUtil::redirect(PageIdConstants::EVENT);
			}
		} else {
			$this->regist();
		}
	}

	public function trash(){
		
		$id = ParamsUtil::getPostParamNumeric("show_id", 0);
		
		if($id == 0){
			$this->getDataTypeEvent();
			$pageSize = ParamsUtil::getQueryParamNumeric("page_size", AppConfig::$DEFAULT_PAGE_SIZE);
			$currentPage = ParamsUtil::getQueryParamNumeric("current_page", 1);
			$totalRow = 0;
	
			$getDataTrash = $this->EventDao->select("SELECT * from e_event where deleted_flag <> 0 ORDER BY updated_time desc");
	
			$this->setView('trash.php');
		}else {
			$rowAffected = $this->EventDao->showLogic($id);
			if($rowAffected > 0) {
				// delete success
				$this->setDeleteSuccessMessage();
			}
			if($rowAffected <= 0) {
				// submit data is error or delete not success
				$this->setErrorNotFoundMessage();
			}
			
			$redirect = ParamsUtil::getPostParam("redirect");
			if($redirect == null) {
				$redirect = PageIdConstants::EVENT;
				ActionUtil::redirect($redirect);
			}else {
				header('Location:'.$redirect);
			}
		}

		$this->setAttribute("currentPage", $currentPage);
		$this->setAttribute("totalRow", $totalRow);
		$this->setAttribute("pageSize", $pageSize);  
		$this->setAttribute('dataTrash', $getDataTrash);
	}

	public function render() {
		// set url for screen
		$this->setAttribute("urlRegist", ActionUtil::getActionUrl(PageIdConstants::EVENT, "regist"));
		$this->setAttribute("urlSearch", ActionUtil::getActionUrl(PageIdConstants::EVENT, "search"));
		$this->setAttribute("urlEdit", ActionUtil::getActionUrl(PageIdConstants::EVENT, "edit"));
		$this->setAttribute("urlDelete", ActionUtil::getActionUrl(PageIdConstants::EVENT, "delete"));
		$this->setAttribute("urlCalendar", ActionUtil::getActionUrl(PageIdConstants::EVENT, "calendar"));
		$this->setAttribute("urlCopy", ActionUtil::getActionUrl(PageIdConstants::EVENT, "copy"));
		$this->setAttribute("urlTrash", ActionUtil::getActionUrl(PageIdConstants::EVENT, "trash"));
	}

	public function index() {
		$this->search();
	}

	public function search() {
		$this->getDataTypeEvent();

		$pageSize = ParamsUtil::getQueryParamNumeric("page_size", AppConfig::$DEFAULT_PAGE_SIZE);
		$currentPage = ParamsUtil::getQueryParamNumeric("current_page", 1);
		$totalRow = 0;

        //kiểm tra và lấy giá trị resquest 
        $params['id']  = ParamsUtil::getQueryParam("id",null);
		$params['event_name']  = ParamsUtil::getQueryParam("event_name",null);
        $params['name_customer']  = ParamsUtil::getQueryParam("name_customer",null);
        $params['phone_customer']  = ParamsUtil::getQueryParam("phone_customer",null);
        $params['email_customer']  = ParamsUtil::getQueryParam("email_customer",null);
       // var_dump($params); exit;
		
		$this->validates_search($params);
		if($this->validate->hasError()){
			$params = array();
		}
        $sortCondition .= " IFNULL(e_event.updated_time, e_event.created_time) desc";
		$eventDao = new MEventDao();
		$listEvent = $eventDao->getWithPagging($currentPage, $pageSize, $sortCondition, $totalRow, $params);
		
		if(isset($listEvent) && count($listEvent) > 0) {
			$this->setAttribute("listEvent", $listEvent);
		} else {
			$this->validate->addError(MessageConstants::COM_INFO_SEARCH_RESULT_NOT_FOUND);
		}
		$this->setAttribute("currentPage", $currentPage);
		$this->setAttribute("totalRow", $totalRow);
		$this->setAttribute("pageSize", $pageSize);  
		$this->setView("view.php");
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

	public function calendar(){
		$this->setView("calendar.php");
	}

	public function regist() {
		///kiểm tra xem có loại event nào trong database không
		if(!$this->getDataTypeEvent()){
			ActionUtil::redirect(PageIdConstants::EVENT);
		}
		$regist_step = ParamsUtil::getPostParam("regist_step", 0);
		$view = null;
		// create or back from the screen preview
		if($regist_step == 0 || $regist_step == 3) {
			
			$view = "input.php";
			$params = $this->jsonDecode(ParamsUtil::getPostParam("json_regist_data"));
			$this->setViewState($params);
		}
		//when click button đăng ký hoặc sửa
		else if($regist_step == 1) { // move to the screen preview
			$params = ParamsUtil::getPostParams(array(
				  "id"
				, "event_name"
				, "start_time"
				, "end_time"
                , "name_customer"
                , "phone_customer"
				, "email_customer"
				, "number_adults"
				, "number_kid"
				, "type_id"
				, "status"
				, "deleted_tag"
				, "updated_time"
				, "created_time"
				, "updated_user"
				, "created_user"
            ));

			//validates form
			$this->validates($params);	
		
			
			if(!$this->validate->hasError()) {
				// $this->setViewState(array("json_regist_data" => $this->jsonEncode($params)));
				// $view = "preview.php";
				$result = $this->doRegist($params);
                // if is create
                if(StringUtil::isNullOrEmpty($params["id"])) {
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
				ActionUtil::redirect(PageIdConstants::EVENT);
			} else {
				
                $this->validate->addError($this->validate->messageFormat(MessageConstants::COM_ERR_HAPPENED));
				$view = "input.php";
			}

		}
		//screen success
		else if($regist_step == 2) {
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
                if(StringUtil::isNullOrEmpty($params["id"])) {
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
            ActionUtil::redirect(PageIdConstants::EVENT);
		}
		if(!StringUtil::isNullOrEmpty($view)) {
			$this->setView($view);
		}
		
	}

	public function getDataTypeEvent(){
		$type_id = null;
		$type_name = null;
		$check = true;

		$typeEvent = new MTypeEventDao();
		$getDataAll = $typeEvent->getAllTypeEvent();

		if($getDataAll){
			$type_id = ParamsUtil::getPostParam('type_id');

			if($type_id != null){
				$type_name = $typeEvent->selectOne('select name_type from e_event_type where id = :id', array('id'=>$type_id));
			}
	
			if($type_name){
				$this->setAttribute('type_name', $type_name['name_type']);
			}
	
			$this->setAttribute('dataTypeEvent',$getDataAll);
		}else {
			$check = false;
		}

		return $check;
	}

	public function edit() {
		$this->getDataTypeEvent();
		//Phương thức get
		if($this->isGet()) {	
			$editEventId = ParamsUtil::getQueryParamNumeric("id", 0);
			if($editEventId) {
                $event = $this->EventDao->getEventById($editEventId);

				$typeEvent = new MTypeEventDao();
				$getDataAll = $typeEvent->getAllTypeEvent();
				$this->setAttribute('dataTypeEvent',$getDataAll);

				$this->setViewState($event);
				$this->setView("input.php");
			} else {
				$this->setErrorNotFoundMessage();
				ActionUtil::redirect(PageIdConstants::EVENT);
			}
		} else {
			$this->regist();
		}
	}

	public function delete() {
		
		$deleteEventId = ParamsUtil::getPostParamNumeric("delete_event_id", 0);
        $rowAffected = 0; 
       // var_dump($deleteEventId); exit;
        if($deleteEventId) {
            $rowAffected = $this->EventDao->deleteLogic($deleteEventId);
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
            $redirect = PageIdConstants::EVENT;
            ActionUtil::redirect($redirect);
        }else {
            header('Location:'.$redirect);
        }
        // show list
       
	}

	private function validates($params) {

		$validateOpts = array(
			array(
				"itemId" => "event_name"
				, "itemName" => "事業所名"
				, "types" => array(ValidateUtil::_IS_NULL, ValidateUtil::_IS_MAX)
				, "data" => $params["event_name"]
				, "max" => 200
				, "errMsg"=> array(ValidateUtil::_IS_NULL=>"* Trường bắt buộc nhập", ValidateUtil::_IS_MAX=>"Vui lòng nhập <=200 ký tự")
			),
			array(
				"itemId" => "start_time"
				, "itemName" => "事業所名&#12288;カナ"
				, "types" => array(ValidateUtil::_IS_NULL)
				, "data" => $params["start_time"]
			),
			array(
				"itemId" => "end_time"
				, "itemName" => "郵便番号"
				, "types" => array(ValidateUtil::_IS_NULL, $params['start_time'] => ValidateUtil::_COMPARE_SMALL )
				, "data" => $params["end_time"]
				, "errMsg" => array(ValidateUtil::_COMPARE_SMALL=>"Không hợp lệ! Thời gian phải lớn hơn ngày bắt đầu")
			),
			array(
				"itemId" => "name_customer"
				, "itemName" => "都道府県"
				, "types" => array(ValidateUtil::_IS_NULL, ValidateUtil::_IS_MAX)
				, "data" => $params["name_customer"]
				, "max" => 100
				, "errMsg"=> array(ValidateUtil::_IS_NULL=>"Trường bắt buộc nhập",ValidateUtil::_IS_MAX=>"Vui lòng nhập <=100 ký tự")
			),
			array(
				"itemId" => "phone_customer"
				, "itemName" => "市区町村"
				, "types" => array(ValidateUtil::_IS_MIN, ValidateUtil::_IS_MAX)
				, "data" => $params["phone_customer"]
                , "max" => 11
				,"errMsg"=> array(ValidateUtil::_IS_MAX=>"SDT Không hợp lệ <= 11 số", ValidateUtil::_IS_MIN=>"SDT Không hợp lệ >= 10 số")

			),
            array(
                "itemId" => "number_adults"
                , "itemName" => "マンション/ビル名等"
                , "types" => array(ValidateUtil::_IS_NUM)
                , "data" => $params["number_adults"]
                , "max" => 250
				, "errMsg"=> array(ValidateUtil::_IS_NUM=>"Giá trị phải là 1 số")
            ),
            array(
                "itemId" => "number_kid"
                , "itemName" => "電話番号"
                , "types" => array(ValidateUtil::_IS_NUM)
                , "data" => $params["number_kid"]
				, "errMsg"=> array(ValidateUtil::_IS_NUM=>"Giá trị phải là 1 số")
            ),
            array(
                "itemId" => "type_id"
                , "itemName" => "FAX番号"
                , "types" => array(ValidateUtil::_IS_NUM)
                , "data" => $params["type_id"]
				, "errMsg"=> array(ValidateUtil::_IS_NUM=>"Giá trị phải là 1 số")
            ),
            array(
                "itemId" => "status"
                , "itemName" => "メールアドレス"
                , "types" => array(ValidateUtil::_IS_NUM)
                , "data" => $params["status"]
                , "max" => 100
				, "errMsg"=> array(ValidateUtil::_IS_NUM=>"Giá trị phải là 1 số")
            )
            
		);

		$this->validate->validates($validateOpts);
		return !$this->validate->hasError();

	}

    private function doRegist($params) {
        $id = null;
        $id_event = null;
		$method = ParamsUtil::getQueryParam('mode', null);
		
        if(array_key_exists("id", $params) ) {
            $id_event = $params["id"];
        }
        if(!StringUtil::isNullOrEmpty($id_event) && $method =="edit") {
            $id = $this->EventDao->update(
                $params
                , array("where" => "id = :id", "params" => array("id" => $id_event),false)
            );
        } else {
			$params['id'] = null;
            $id = $this->EventDao->insert($params);    
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