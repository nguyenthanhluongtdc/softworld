<?php

/**
**/
require_once ROOT_PATH_COMMON . "/MessageConstants.php";
require_once ROOT_PATH_DAO . "/core/DbManager.php";
require_once ROOT_PATH_DAO . "/MTypeEventDao.php";
class TypeeventAction extends BaseAction {
    private $TypeEventDao;
	private $fieldEvent = array(
		"name_type" => "Ten type event"
		, "code_color" => "Ma mau"
		, "code_type" => "Ma phan loai"
		, "deleted_flag" => null
		, "created_user" => null
		, "created_time" => null
		, "updated_user" => null
		, "updated_time" => null
	);
	
	private $messages = [];
    public function __construct() {
        parent::__construct();
        $this->TypeEventDao = new MTypeEventDao();

		$this->fixAllowOrigin();
    }
    
	public function rules() {
		return array(
			"search" => array("post", "get")
			, "regist" => array("post", "get")
			, "edit" => array("post", "get", "put")
			, "delete" => array("post","delete")
			, "ajaxgetoffice" => array("post", "get")
		);
	}

	public function render() {
		// set url for screen
		$this->setAttribute("urlRegist", ActionUtil::getActionUrl(PageIdConstants::TYPE_EVENT, "regist"));
		$this->setAttribute("urlSearch", ActionUtil::getActionUrl(PageIdConstants::TYPE_EVENT, "search"));
		$this->setAttribute("urlEdit", ActionUtil::getActionUrl(PageIdConstants::TYPE_EVENT, "edit"));
		$this->setAttribute("urlDelete", ActionUtil::getActionUrl(PageIdConstants::TYPE_EVENT, "delete"));
	}

	public function index() {
		$this->search();
	}

	public function regist() {
		$method = $_SERVER['REQUEST_METHOD'];
		if($method == 'POST'){
			// create or back from the screen preview move to the screen preview
			$params = ParamsUtil::getPostParams(array_keys($this->fieldEvent));

			$this->validates($params);
			if( ! $this->validate->hasError()){
				$result = $this->TypeEventDao->insert($params);
				// if is create
				if($result > 0) {
					array_push($this->messages, "true");
				}else{
					array_push($this->messages, "Them that bai");
				}      
			}else {
				foreach($this->validate->getErrors() as $item){
					array_push($this->messages, array($this->fieldEvent[$item['itemId']]=>$item[message]));
				}
			}
		}
		else array_push($this->messages, "Phuong thuc gui khong hop le");
		echo json_encode($this->messages);
	}

	public function edit() {
		
		$id = ParamsUtil::getQueryParamNumeric("id", 0);
		// create or back from the screen preview move to the screen preview
		$method = $_SERVER['REQUEST_METHOD'];
		$params = array();

		if ('PUT' === $method) {
			parse_str(file_get_contents('php://input'), $_PUT);
			$params = $_PUT;
			
		}else if ('POST' === $method) {
			$params = ParamsUtil::getPostParams(array_keys($this->fieldEvent));
		}

		$this->validates($params);

		if( ! $this->validate->hasError()){
			$result = $this->TypeEventDao->update($params, array( "where" => "id = :id" , "params" => array("id" => $id) ),false);

			if(!$result) {
				// submit data is error or delete not success
				array_push($this->messages, "Cap nhat thanh cong");
			} else {
				array_push($this->messages, "Cap nhat that bai");
			}	
		}else {
			foreach($this->validate->getErrors() as $item){
				array_push($this->messages, array($this->fieldEvent[$item['itemId']]=>$item[message]));
			}
		}

		echo json_encode($this->messages);
	}

	public function delete() {

        $rowAffected = 0; 

		$method = $_SERVER['REQUEST_METHOD'];
		$id = null;

		if ('DELETE' === $method) {
			parse_str(file_get_contents('php://input'), $_DELETE);

			if(!StringUtil::isNullOrEmpty($_DELETE['id'])){
				$id = (int)$_DELETE['id'];
			}
		}
		// else if ('POST' === $method) {
		// 	$id = ParamsUtil::getPostParamNumeric("id", 0);
		// }

        if($id) {
            $rowAffected = $this->TypeEventDao->deleteLogic($id);
            if($rowAffected > 0) {
				array_push($this->messages, "Xoa thanh cong");
            }else array_push($this->messages, "Xoa that bai");
        } else {
			array_push($this->messages, "Phuong thuc gui khong hop le");
		}

		echo json_encode($this->messages);
        
	}

	public function search() {
		$pageSize = ParamsUtil::getQueryParamNumeric("page_size", AppConfig::$DEFAULT_PAGE_SIZE);
		$currentPage = ParamsUtil::getQueryParamNumeric("current_page", 1);
		$totalRow = 0;

        //kiểm tra và lấy giá trị resquest 
        $params['id']  = ParamsUtil::getQueryParam("id",null);
		$params['name_type']  = ParamsUtil::getQueryParam("name_type",null);
        $params['code_color']  = ParamsUtil::getQueryParam("code_color",null);
        $params['code_type']  = ParamsUtil::getQueryParam("code_type",null);
       // var_dump($params); exit;
		
		$this->validates_search($params);
		if($this->validate->hasError()){
			$params = array();
		}
        $sortCondition .= " IFNULL(e_event_type.updated_time, e_event_type.created_time) desc";
		$typeEventDao = new MTypeEventDao();
		$listTypeEvent = $typeEventDao->getWithPagging($currentPage, $pageSize, $sortCondition, $totalRow, $params);

		if(isset($listTypeEvent) && count($listTypeEvent) > 0) {
			echo json_encode($listTypeEvent, JSON_PRETTY_PRINT);
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

	private function validates($params) {

		$validateOpts = array(
			array(
				"itemId" => "name_type"
				, "itemName" => "事業所名"
				, "types" => array(ValidateUtil::_IS_NULL, ValidateUtil::_IS_MAX)
				, "data" => $params["name_type"]
				, "max" => 200
                , "errMsg"=> array(ValidateUtil::_IS_NULL=>"Null", ValidateUtil::_IS_MAX=>"Gia tri <= 200 ky tu")
			),
			array(
				"itemId" => "code_color"
				, "itemName" => "事業所名&#12288;カナ"
				, "types" => array(ValidateUtil::_IS_NULL)
				, "data" => $params["code_color"]
				, "max" => 200
				, "errMsg"=> array(ValidateUtil::_IS_NULL=>"Null")

			),
			array(
				"itemId" => "code_type"
				, "itemName" => "事業所名&#12288;カナ"
				, "types" => array(ValidateUtil::_IS_NULL, ValidateUtil::_IS_MAX)
				, "data" => $params["code_type"]
				, "max" => 150
				, "errMsg"=> array(ValidateUtil::_IS_NULL=>"Null", ValidateUtil::_IS_MAX=>"Gia tri <= 150 ky tu")

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

	
    public static function slug($title) {
        $replacement = '';
        $map = array();
        $quotedReplacement = preg_quote($replacement, '/');
        $default = array(
            '/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ|À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ|å/' => 'a',
            '/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ|È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ|ë/' => 'e',
            '/ì|í|ị|ỉ|ĩ|Ì|Í|Ị|Ỉ|Ĩ|î/' => 'i',
            '/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ|Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ|ø/' => 'o',
            '/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ|Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ|ů|û/' => 'u',
            '/ỳ|ý|ỵ|ỷ|ỹ|Ỳ|Ý|Ỵ|Ỷ|Ỹ/' => 'y',
            '/đ|Đ/' => 'd',
            '/ç/' => 'c',
            '/ñ/' => 'n',
            '/ä|æ/' => 'ae',
            '/ö/' => 'oe',
            '/ü/' => 'ue',
            '/Ä/' => 'Ae',
            '/Ü/' => 'Ue',
            '/Ö/' => 'Oe',
            '/ß/' => 'ss',
            '/[^\s\p{Ll}\p{Lm}\p{Lo}\p{Lt}\p{Lu}\p{Nd}]/mu' => ' ',
            '/\\s+/' => $replacement,
            sprintf('/^[%s]+|[%s]+$/', $quotedReplacement, $quotedReplacement) => '',
        );
        //Some URL was encode, decode first
        $title = urldecode($title);
        $map = array_merge($map, $default);
        return strtolower(preg_replace(array_keys($map), array_values($map), $title));
    }

}

?>