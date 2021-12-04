<?php

/**
**/
require_once ROOT_PATH_COMMON . "/MessageConstants.php";
require_once ROOT_PATH_DAO . "/core/DbManager.php";
require_once ROOT_PATH_DAO . "/MTypeEventDao.php";
require_once ROOT_PATH_DAO . "/MEventDao.php";
class TypeeventAction extends BaseAction {
    private $TypeEventDao;
    private $EventDao;
    public function __construct() {
        parent::__construct();
        $this->TypeEventDao = new MTypeEventDao();
        $this->EventDao = new MEventDao();
    }
    
	public function rules() {
		return array(
			"search" => array("post", "get")
			, "regist" => array("post", "get")
			, "edit" => array("post", "get","put")
			, "delete" => array("post", "delete")
			, "ajaxgetoffice" => array("post", "get")
		);
	}

	public function render() {
		// set url for screen
		$this->setAttribute("urlRegist", ActionUtil::getActionUrl(PageIdConstants::TYPE_EVENT, "regist"));
		$this->setAttribute("urlSearch", ActionUtil::getActionUrl(PageIdConstants::TYPE_EVENT, "search"));
		$this->setAttribute("urlEdit", ActionUtil::getActionUrl(PageIdConstants::TYPE_EVENT, "edit"));
		$this->setAttribute("urlDelete", ActionUtil::getActionUrl(PageIdConstants::TYPE_EVENT, "delete"));
        $this->setAttribute("urlCopy", ActionUtil::getActionUrl(PageIdConstants::TYPE_EVENT, "copy"));
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
			//echo json_encode($listTypeEvent);
			$this->setAttribute("listTypeEvent", $listTypeEvent);
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
        $regist_step = ParamsUtil::getPostParam("regist_step", 0);
		$view = null;
		// create or back from the screen preview move to the screen preview
		

        if($regist_step == 0 || $regist_step==3){
            $view = "input.php";
			$params = $this->jsonDecode(ParamsUtil::getPostParam("json_regist_data"));

			$this->setViewState($params);

        }else if($regist_step == 1){

            $params = ParamsUtil::getPostParams(array(
                  "id"
                , "name_type"
                , "code_color"
                , "code_type"
                , "deleted_tag"
				, "updated_time"
				, "created_time"
				, "updated_user"
				, "created_user"
           ));
           //$params['code_type'] = $this->slug(ParamsUtil::getPostParam('name_type'));

            $this->validates($params);
		
			if(!$this->validate->hasError()) {
				// $this->setViewState(array("json_regist_data" => $this->jsonEncode($params)));
                // $this->setAttribute("code_type", $params['code_type'] );
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

                ActionUtil::redirect(PageIdConstants::TYPE_EVENT);
			} else {
                $this->validate->addError($this->validate->messageFormat(MessageConstants::COM_ERR_HAPPENED));
				$view = "input.php";
			}

        }else if($regist_step == 2){
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
            ActionUtil::redirect(PageIdConstants::TYPE_EVENT);
        }

        if(!StringUtil::isNullOrEmpty($view)) {
			$this->setView($view);
		}

		//var_dump($params['name_customer']); exit;

		// $result = $this->TypeEventDao->insert($params);
        //     // if is create

        // if($result > 0) {
        //     $this->setInsertSuccessMessage();
		// 	echo 'true';
        // }else{
		// 	echo 'false';
		// }      
	}

    public function copy(){
		//Phương thức get
		if($this->isGet()) {	
			$id = ParamsUtil::getQueryParamNumeric("id", 0);
			if($id) {
                $typeevent = $this->TypeEventDao->getTypeEventById($id);

				$typeevent['name_type'] .= " (copy)";
				$this->setViewState($typeevent);
				$this->setView("input.php");
			} else {
				$this->setErrorNotFoundMessage();
				ActionUtil::redirect(PageIdConstants::EVENT);
			}
		} else {
			$this->regist();
		}
	}

	public function edit() {
		
		if($this->isGet()) {	
			$id = ParamsUtil::getQueryParamNumeric("id", 0);
			if($id) {
                $typeEvent = $this->TypeEventDao->getTypeEventById($id);

				$this->setViewState($typeEvent);
				$this->setView("input.php");
			} else {
				$this->setErrorNotFoundMessage();
				ActionUtil::redirect(PageIdConstants::TYPE_EVENT);
			}
		} else {
			$this->regist();
		}
	}

	public function delete() {

		$id = ParamsUtil::getPostParamNumeric("delete_id", 0);
        $rowAffected = 0; 
        if($id) {
            $rowAffected = $this->TypeEventDao->deleteLogic($id);
            //$this->EventDao->resetDeletedtag($id);
            if($rowAffected > 0) {
                $this->setDeleteSuccessMessage();
            }
        } 
        if($rowAffected <= 0) {
            // submit data is error or delete not success
           $this->setErrorNotFoundMessage();
        }

        $redirect = ParamsUtil::getPostParam('redirect');

        if($redirect==null){
            $redirect = PageIdConstants::TYPE_EVENT;
            ActionUtil::redirect($redirect);
        }else {
            header('Location:'.$redirect);
        }
	}

	private function validates($params) {

		$validateOpts = array(
			array(
				"itemId" => "name_type"
				, "itemName" => "事業所名"
				, "types" => array(ValidateUtil::_IS_NULL, ValidateUtil::_IS_MAX)
				, "data" => $params["name_type"]
				, "max" => 200
                , "errMsg"=> array(ValidateUtil::_IS_NULL=>"* Trường bắt buộc nhập", ValidateUtil::_IS_MAX=>"Vui lòng nhập <=200 ký tự")
			),
			array(
				"itemId" => "code_color"
				, "itemName" => "事業所名&#12288;カナ"
				, "types" => array(ValidateUtil::_IS_NULL)
				, "data" => $params["code_color"]
				, "max" => 200
			)
		);

		$this->validate->validates($validateOpts);
		return !$this->validate->hasError();    
	}

    private function doRegist($params) {
        $id = null;
        $editTypeEventId = null;
        $method = ParamsUtil::getQueryParam('mode', null);

        if(array_key_exists("id", $params)) {
            $editTypeEventId = $params["id"];
        }
        if(!StringUtil::isNullOrEmpty($editTypeEventId) && $method=="edit") {
            $id = $this->TypeEventDao->update(
                $params
                , array("where" => "id = :id", "params" => array("id" => $editTypeEventId))
            );
        } else {
            $params['id']=null;
            $id = $this->TypeEventDao->insert($params);    
        }
        return $id;
    }

    private function validatesSearch($params) {
          
        $validateOpts = array(
            array(
                "itemId" => "name_type"
                , "itemName" => "事業所名"
                , "types" => array(ValidateUtil::_IS_MAX)
                , "data" => $params["name_type"]
                , "max" => 200
                , "errMsg"=> array(ValidateUtil::_IS_MAX=>"Vui lòng nhập <=200 ký tự")
            ),
            array(
                "itemId" => "code_color"
                , "itemName" => "都道府県"
                , "types" => array(ValidateUtil::_IS_NUM)
                , "data" => $params["code_color"]
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