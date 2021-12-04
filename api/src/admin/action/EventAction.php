<?php

/**
**/
require_once ROOT_PATH_COMMON . "/MessageConstants.php";
require_once ROOT_PATH_DAO . "/core/DbManager.php";
require_once ROOT_PATH_DAO . "/MEventDao.php";
class EventAction extends BaseAction {
    private $EventDao;
	private $fieldEvent = array(
		"event_name" => "Ten event"
		, "start_time" => "Ngay bat dau"
		, "end_time" => "Ngay ket thuc"
		, "name_customer" => "Ten khach hang"
		, "phone_customer" => "So dien thoai"
		, "email_customer" => "Email"
		, "number_adults" => "So nguoi lon"
		, "number_kid" => "So tre em"
		, "type_id" => "Loai event"
		, "status" => "Ca ngay"
		, "deleted_flag" => null
		, "created_user" => null
		, "created_time" => null
		, "updated_user" => null
		, "updated_time" => null
	);
	private $messages = [];
    public function __construct() {
        parent::__construct();
        $this->EventDao = new MEventDao();
		$this->fixAllowOrigin();
    }
    
	public function rules() {
		
		return array(
			"search" => array("post", "get")
			, "regist" => array("post", "get")
			, "edit" => array("post", "get", "put")
			, "delete" => array("delete","put")
			, "ajaxgetoffice" => array("post", "get")
		);
	}

	public function render() {
		// set url for screen
		$this->setAttribute("urlRegist", ActionUtil::getActionUrl(PageIdConstants::EVENT, "regist"));
		$this->setAttribute("urlSearch", ActionUtil::getActionUrl(PageIdConstants::EVENT, "search"));
		$this->setAttribute("urlEdit", ActionUtil::getActionUrl(PageIdConstants::EVENT, "edit"));
		$this->setAttribute("urlDelete", ActionUtil::getActionUrl(PageIdConstants::EVENT, "delete"));
	}

	public function index() {
		$this->search();
	}

	public function search() {
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
		$listEvent = $eventDao->getJoinTable();

		if(isset($listEvent) && count($listEvent) > 0) {
			echo json_encode($listEvent, JSON_PRETTY_PRINT);
			//$this->setAttribute("listEvent", $listEvent);
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

	public function regist() {
			// API
		$params = ParamsUtil::getPostParams(array_keys($this->fieldEvent));
		$this->validates($params);
		if( ! $this->validate->hasError()){
			$result = $this->EventDao->insert($params);
			if($result > 0) {
				$this->setInsertSuccessMessage();
				array_push($this->messages, "true");
			}else{
				array_push($this->messages, "Them that bai");
			}
		}else {
			foreach($this->validate->getErrors() as $item){
				array_push($this->messages, array($this->fieldEvent[$item['itemId']]=>$item[message]));
			}
		}
		echo json_encode($this->messages);
	}

	public function edit() {
		//get id
		$id = ParamsUtil::getQueryParamNumeric("id", 0);
		
		$method = $_SERVER['REQUEST_METHOD'];
		$params = array();

		//check method
		if ('PUT' === $method) {
			parse_str(file_get_contents('php://input'), $_PUT);
			$params = $_PUT;
		}else if ('POST' === $method) {

			$params = ParamsUtil::getPostParams(array_keys($this->fieldEvent));
		}

		//validate form
		$this->validates($params);
		if( ! $this->validate->hasError()){

			//update
			$result = $this->EventDao->update($params, array( "where" => "id = :id" , "params" => array("id" => $id) ),false);

			//check result update
			if(!$result) {
				// submit data is error or delete not success
				array_push($this->messages, "Cap nhap that bai");
			} else {
				array_push($this->messages, "Cap nhap thanh cong");
			}	
		}else {
			foreach($this->validate->getErrors() as $item){
				array_push($this->messages, array($this->fieldEvent[$item['itemId']]=>$item[message]));
			}
		}

		print json_encode($this->messages);

	}

	public function delete() {
		$deleteEventId = null;
        $rowAffected = 0; 
		$method = $_SERVER['REQUEST_METHOD'];

		if($method === 'DELETE'){
			parse_str(file_get_contents('php://input'), $_DELETE);
			if(!StringUtil::isNullOrEmpty($_DELETE['id'])){
				$deleteEventId = (int)$_DELETE['id'];
			}
		}
		// else if($method === 'POST'){
		// 	$deleteEventId = ParamsUtil::getPostParamNumeric("id", 0);
		// }

        if($deleteEventId) {
            $rowAffected = $this->EventDao->deleteLogic($deleteEventId);
            if($rowAffected > 0) {
				array_push($this->messages, "Xoa thanh cong");
            }else array_push($this->messages, "Xoa that bai");
        } else {
			array_push($this->messages, "Phuong thuc gui khong hop le");
		}

		echo json_encode($this->messages);
	}

	private function validates($params) {

		$validateOpts = array(
			array(
				"itemId" => "event_name"
				, "itemName" => "事業所名"
				, "types" => array(ValidateUtil::_IS_NULL, ValidateUtil::_IS_MAX)
				, "data" => $params["event_name"]
				, "max" => 200
				, "errMsg"=> array(ValidateUtil::_IS_NULL=>"Null", ValidateUtil::_IS_MAX=>"Vui long nhap <= 200 ky tu")
			),
			array(
				"itemId" => "start_time"
				, "itemName" => "事業所名&#12288;カナ"
				, "types" => array(ValidateUtil::_IS_NULL)
				, "data" => $params["start_time"]
				, "errMsg"=> array(ValidateUtil::_IS_NULL=>"Null")
			),
			array(
				"itemId" => "end_time"
				, "itemName" => "郵便番号"
				, "types" => array(ValidateUtil::_IS_NULL, $params['start_time'] => ValidateUtil::_COMPARE_SMALL )
				, "data" => $params["end_time"]
				, "errMsg" => array(ValidateUtil::_IS_NULL=>"Null",ValidateUtil::_COMPARE_SMALL=>"Thoi gian ket thuc, phai lon hon thoi gian bat dau")
			),
			array(
				"itemId" => "name_customer"
				, "itemName" => "都道府県"
				, "types" => array(ValidateUtil::_IS_NULL, ValidateUtil::_IS_MAX)
				, "data" => $params["name_customer"]
				, "max" => 100
				, "errMsg"=> array(ValidateUtil::_IS_NULL=>"Null",ValidateUtil::_IS_MAX=>"Vui long nhap <=100 ky tu")
			),
			array(
				"itemId" => "phone_customer"
				, "itemName" => "市区町村"
				, "types" => array(ValidateUtil::_IS_MIN, ValidateUtil::_IS_MAX, ValidateUtil::_IS_NULL)
				, "data" => $params["phone_customer"]
                , "max" => 11
				,"errMsg"=> array(ValidateUtil::_IS_NULL=>"Null",ValidateUtil::_IS_MAX=>"SDT Khong hop le <= 11 ky tu", ValidateUtil::_IS_MIN=>"SDT Khong hop le >= 10 so")

			),array(
				"itemId" => "email_customer"
				, "itemName" => "市区町村"
				, "types" => array(ValidateUtil::_IS_NULL, ValidateUtil::_IS_MAIL)
				, "data" => $params["email_customer"]
                , "max" => 11
				,"errMsg"=> array(ValidateUtil::_IS_NULL=>"Null",ValidateUtil::_IS_MAIL=>"Email khong hop le")
			),
            array(
                "itemId" => "number_adults"
                , "itemName" => "マンション/ビル名等"
                , "types" => array(ValidateUtil::_IS_NUM, ValidateUtil::_IS_NULL)
                , "data" => $params["number_adults"]
                , "max" => 250
				, "errMsg"=> array(ValidateUtil::_IS_NULL=>"Null",ValidateUtil::_IS_NUM=>"Gia tri phai la 1 so")
            ),
            array(
                "itemId" => "number_kid"
                , "itemName" => "電話番号"
                , "types" => array(ValidateUtil::_IS_NUM, ValidateUtil::_IS_NULL)
                , "data" => $params["number_kid"]
				, "errMsg"=> array(ValidateUtil::_IS_NULL=>"Null",ValidateUtil::_IS_NUM=>"Gia tri phai la 1 so")
            ),
            array(
                "itemId" => "type_id"
                , "itemName" => "FAX番号"
                , "types" => array(ValidateUtil::_IS_NUM, ValidateUtil::_IS_NULL)
                , "data" => $params["type_id"]
				, "errMsg"=> array(ValidateUtil::_IS_NULL=>"Null",ValidateUtil::_IS_NUM=>"Gia tri phai la 1 so")
            ),
            array(
                "itemId" => "status"
                , "itemName" => "メールアドレス"
                , "types" => array(ValidateUtil::_IS_NUM, ValidateUtil::_IS_NULL)
                , "data" => $params["status"]
                , "max" => 100
				, "errMsg"=> array(ValidateUtil::_IS_NULL=>"Null",ValidateUtil::_IS_NUM=>"Gia tri phai la 1 so")
            )
            
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