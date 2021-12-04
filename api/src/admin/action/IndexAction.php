<?php
/**
*/
require_once ROOT_PATH_DAO . "/MProjectDao.php";

class IndexAction extends BaseAction {
    private $ProjectDao;
    public function __construct() {
        parent::__construct();
        $this->ProjectDao = new MProjectDao();
    }
    public function rules() {
        return array(
            "search" => array('post', 'get'),
            "detail" => array('post', 'get')
            );
    }

    public function index() {
        $this->search();
    }

    public function render() {
        $this->setAttribute("urlSearch", ActionUtil::getActionUrl(PageIdConstants::INDEX, "search"));
        $this->setAttribute("urlHistory", ActionUtil::getActionUrl(PageIdConstants::HISTORY, "index"));
    }

    public function search() {
        $pageSize = ParamsUtil::getQueryParamNumeric("page_size", AppConfig::$DEFAULT_PAGE_SIZE);
        $currentPage = ParamsUtil::getQueryParamNumeric("current_page", 1);
        $totalRow = 0;
        $session = new SessionManager();
        $staff_id = $this->session->getLoginUserId();
        /*check authority data*/
        $role = $this->role;
        if(!in_array(4,$role) && !in_array(5,$role))//if not 案件管理 
        {
            $params['role_required'] = $this->login_id;
        }
        $sortCondition .= " IFNULL(pi.updated_time, pi.created_time) desc";
        $prjinfos = $this->ProjectDao->getWithPaggingFromStaff($staff_id, $currentPage, $pageSize, $sortCondition, $totalRow,$params);
        foreach ($prjinfos as &$info){
            $info['adress'] = $info['prj_cust_pos_code'] . $info['prj_cust_prefectures'] . $info['prj_cust_city'] . $prjdetail['prj_cust_address'] . $info['prj_cust_mansion_info'];
            $arrchange = explode(',',$info['history_upd_item_id']);
            $strchange = '';
            foreach ($arrchange as $change){
                $strchange .= $strchange == '' ? AppConfig::$HISTORY_CHANGE[$change] : ',' . AppConfig::$HISTORY_CHANGE[$change];
            }
            $info['update_item_str'] = $strchange;
        }
        if(isset($prjinfos) && count($prjinfos) > 0) {
            $this->setAttribute("sortColumns", $this->sortColumns());
            $this->setAttribute("lstprjinfos", $prjinfos);
        } else {
            //$this->validate->addError(MessageConstants::COM_INFO_SEARCH_RESULT_NOT_FOUND);
        }
        
        $this->setAttribute("sort_condition", $sortCondition);
        $this->setAttribute("currentPage", $currentPage);
        $this->setAttribute("pageSize", $pageSize);
        $this->setAttribute("totalRow", $totalRow);
        $this->setView("index.php");
    }
}
?>