<?php

/**
**/
require_once ROOT_PATH_COMMON . "/MessageConstants.php";
require_once ROOT_PATH_DAO . "/MStaffDao.php";
require_once ROOT_PATH_DAO . "/MProjectDao.php";
require_once ROOT_PATH_DAO . "/MPrjUpdateHistoryDao.php";
require_once ROOT_PATH_DAO . "/MPrjApproveStatusDao.php";
require_once ROOT_PATH_DAO . "/MShuruiApproveDao.php";
class HistoryAction extends BaseAction {
	public function rules() {
		return array(
			"search" => array("post", "get")
			, "regist" => array("post", "get")
			, "edit" => array("post", "get")
			, "delete" => "post"
			, 'updateApproveMemo' => array("post","get")
		);
	}

	public function ajaxActions(){
		return array(
			'updateApproveStatus'
			,'updateApproveStatusEmail'
		);
	}

	public function render() {
		// set url for screen
		$this->setAttribute("urlSearch", ActionUtil::getActionUrl(PageIdConstants::HISTORY, "search"));
		$this->setAttribute("urlUpdateApprove", ActionUtil::getActionUrl(PageIdConstants::HISTORY, "updateApproveStatus"),false);
		$this->setAttribute("urlUpdateApproveEmail", ActionUtil::getActionUrl(PageIdConstants::HISTORY, "updateApproveStatusEmail"),false);
		$this->setAttribute("urlUpdateApproveMemo", ActionUtil::getActionUrl(PageIdConstants::HISTORY, "updateApproveMemo"),false);
		$this->setAttribute("urlPrjEdit", ActionUtil::getActionUrl(PageIdConstants::PROJECT, "edit"));
	}

	public function index() {
		$prj_id = ParamsUtil::getQueryParamNumeric('prj_id', 0);
		$id = ParamsUtil::getQueryParamNumeric('id', 0);
		$redirect = ParamsUtil::getQueryParamNumeric('redirect', 0);
		$projectDao = new MProjectDao();
		/*check authority data*/
        /*$role = $this->role;
        if(!in_array(4,$role) && !in_array(5,$role))//if not 案件管理 you need assign
        {
            $prjInfoData  = $projectDao->getByIdWithAuthority($prj_id,  $this->login_id);
        }else{
        	
        }*/
        $prjInfoData = $projectDao->getById($prj_id);
		if(ArrayUtil::isNullOrEmpty($prjInfoData) || !$prjInfoData){
			$this->setErrorNotFoundMessage();
            ActionUtil::redirect(PageIdConstants::INDEX);
		}

		$result = $this->getInChangeIDandSupID($prj_id);
		$approveInchange = false;
		$approveSup 	 = false;
		if($result['prj_staff_id'] === $this->login_id)
		{
			$approveInchange = true;
		}
		if($result['staff_supervisor'] === $this->login_id)
		{
			$approveSup = true;
		}


		$this->setViewState(array('approveInchange'	=> $approveInchange));
		$this->setViewState(array('approveSup'		=> $approveSup));

		$this->setViewShuruiApprove($prj_id);
		$this->setViewUpdateHistory($prj_id, $id);
		$this->setAtrributeStaffSendMail($prj_id);

		$this->setViewState($prjInfoData);
		$this->setViewState($redirect);
		$this->setView("view.php");
	}

	public function getInChangeIDandSupID($prj_id){
		$staffDao = new MStaffDao();
		return $staffDao->getInChangeAndSupervisor($prj_id);
	}

	/*ajax action*/
	public function updateApproveStatus(){
		$prj_id = ParamsUtil::getPostParam('prj_id');
		$type = ParamsUtil::getPostParam('type');
		$sort_id = ParamsUtil::getPostParam('sort_id');
		$approve = ParamsUtil::getPostParam('approve');
		$params = array();
		$approveInchange = false;
		$approveSup 	 = false;
		$staff_id = $this->login_id;
		#check role
		$result = $this->getInChangeIDandSupID($prj_id);
		if($result['prj_staff_id'] === $staff_id)
		{
			$approveInchange = true;
		}
		if($result['staff_supervisor'] === $staff_id)
		{
			$approveSup = true;
		}

		if(StringUtil::isNullOrEmpty($approve) || $approve == 0)
			$approve = "1";
		else
			$approve = "0";
		$time_now = DateUtil::getCurrentDatetime();
		if($type == 1 && $approveInchange)
		{
			$params = array(
				'prj_id' => $prj_id
				,'prj_shurui_sort' => $sort_id
				,'prj_pic_approve_sts' => $approve
				,'prj_pic_approve_id' => $staff_id
				,'prj_pic_approve_date' => $time_now
			);
		}
		elseif($type==2 && $approveSup){
			$params = array(
				'prj_id' => $prj_id
				,'prj_shurui_sort' => $sort_id
				,'prj_sup_approve_sts' => $approve
				,'prj_sup_approve_id' => $staff_id
				,'prj_sup_approve_date' => $time_now
			);
		}
		if(!ArrayUtil::isNullOrEmpty($params)){
			$shuruiApprove = new MShuruiApproveDao();
			$checkExist = $shuruiApprove->getByPrjIdStaffIdSortId($prj_id,$sort_id);
			if(!$checkExist){
				$Id = $shuruiApprove->insert($params);
			}
			else{
				$Id = $shuruiApprove->UpdateApproveByPrjIdAndSortId($params);
			}
		}
		return $this->jsonEncode($Id);
	}

	public function updateApproveStatusEmail(){
		$app_sts  = new MPrjApproveStatusDao();
		$staffDao = new MStaffDao();
		$staff_id_login = $this->login_id;
		$staff_id = ParamsUtil::getPostParam('staff_id');
		#check role
		if($staff_id_login != $staff_id)
			return null;
		$check_role = $staffDao->checkIsSendMail($staff_id_login);
		if(ArrayUtil::isNullOrEmpty($check_role) || !$check_role)
			return $check_role;	
		$prj_id = ParamsUtil::getPostParam('prj_id');
		$updated_time = ParamsUtil::getPostParam('updated_time');
		$status = ParamsUtil::getPostParam('status');	
		if(StringUtil::isNullOrEmpty($status) || $status == 0)
			$status = "1";
		elseif($status == 1)
			$status = "0";
		$time_now = DateUtil::getCurrentDatetime();
		$params = array(
			'staff_id' => $staff_id
			,'prj_id'  => $prj_id
			,'updated_time' => $updated_time
			,'approve_sts'  => $status
			,'updated_user' => $staff_id_login
		);
		$condition = array(
			'staff_id' => $staff_id
			,'prj_id'  => $prj_id
		);
		$checkIsExist = $app_sts->checkExist($prj_id,$staff_id);
		if(ArrayUtil::isNullOrEmpty($checkIsExist) || !$checkIsExist){
			$params['updated_time'] = $updated_time;
			$params['approve_date'] = $time_now;
			$params['approve_sts'] 	= 1;
			$params['created_user'] = $staff_id_login;
			$id = $app_sts->insert($params);
		}else{
			unset($params['prj_id']);
			unset($params['staff_id']);
			$params['updated_time'] = $updated_time;
			$params['approve_date'] = $time_now;
			$id = $app_sts->update(
				$params
				,array(
					'where' => 'prj_id = :prj_id AND staff_id = :staff_id',
					'params' => $condition
				)
			);
		}
		return $this->jsonEncode($id);
	}

	public function updateApproveMemo(){
		$prj_id = ParamsUtil::getPostParam('prj_id');
		$approve_memo = ParamsUtil::getPostParam('prj_shurui_appr_memo');
		$updated_time = ParamsUtil::getPostParam('updated_time');
		$id 	      = ParamsUtil::getPostParam('id');
		$redirect = ParamsUtil::getPostParam("redirect");
		$staff_id = $this->login_id;
		$prjDao = new MProjectDao();
		$params_update_approve_memo = array(
			'prj_shurui_appr_memo' => $approve_memo,
			'updated_time' => $updated_time,
			'updated_user' => $staff_id
		);
		$condition = array(
			'prj_id' => $prj_id
		);
		$Id = $prjDao->updateApproveMemo($params_update_approve_memo, $condition);
		if($Id > 0)
		{
			$this->setUpdateSuccessMessage();
		}
		else{
			$this->setErrorExclusiveMessage();
		}
		if($redirect == null) {
			$Url_Approve =UrlUtil::url(ActionUtil::getActionUrl(PageIdConstants::HISTORY, "index"), array("prj_id"=>$prj_id,"id"=>$id));
			ActionUtil::redirect($Url_Approve);
		}
		ActionUtil::redirect(PageIdConstants::HISTORY);
	}

	public function convertJsonToArray($upd_item_id,$data){				
		$data = json_decode($data);
		$rowData = array();
		if(($upd_item_id == 2) || ($upd_item_id == 5) || ($upd_item_id == 7) || ($upd_item_id == 9)){
			if($upd_item_id == 2)
				$name = 'モジュール';
			if($upd_item_id == 5)
				$name = 'パワコン';
			if($upd_item_id == 7)
				$name = '接続箱/昇圧機';
			if($upd_item_id == 9)
				$name = 'モニター';
			for ($i=1,$count = count($data); $i <= $count ; $i++) { 
				if(!StringUtil::isNullOrEmpty($data[$i-1]->prj_prod_maker_row)){
					$rowData[$upd_item_id.'_'.$i.'_1'] = $name .$i. ':' . '[メーカー]' . AppConfig::$MAKER[$data[$i-1]->prj_prod_maker_row];
				}
				if(!StringUtil::isNullOrEmpty($data[$i-1]->prj_prod_model_row)){
					$rowData[$upd_item_id.'_'.$i.'_2'] = $name .$i. ':' . '[型式]' . $data[$i-1]->prj_prod_model_row;
				}
			}
			return $rowData;
		}elseif($upd_item_id == 1){
			if($data != null)
			{
				$rowData[$upd_item_id] = $data[0]->prj_keiyaku_bi;
			}
			return $rowData;
		}elseif($upd_item_id == 3 || $upd_item_id == 6 || $upd_item_id == 8 || $upd_item_id == 10){
			if($upd_item_id == 3)
				$name = 'モジュール';
			if($upd_item_id == 6)
				$name = 'パワコン';
			if($upd_item_id == 8)
				$name = '接続箱/昇圧機';
			if($upd_item_id == 10)
				$name = 'モニター';
			for ($i=1,$count = count($data); $i <= $count ; $i++) { 
				if(!StringUtil::isNullOrEmpty($data[$i-1]->prj_prod_num_row)){
					$rowData[$upd_item_id.'_'.$i] = $name .$i. ':' . $data[$i-1]->prj_prod_num_row.'枚';
				}
			}
			return $rowData;
		}elseif($upd_item_id == 4){
			for ($i=1,$count = count($data); $i <= $count ; $i++) { 
				if(!StringUtil::isNullOrEmpty($data[$i-1]->prj_prod_kw)){
					$rowData[$upd_item_id.'_'.$i] = $data[$i-1]->prj_prod_kw;
				}
			}
			return $rowData;
		}elseif($upd_item_id == 11){
			if(!StringUtil::isNullOrEmpty($data[0]->prj_prod_price_selling_total)){
				$rowData[$upd_item_id] = $data[0]->prj_prod_price_selling_total;
			}
			return $rowData;
		}
		elseif($upd_item_id == 12){
			$name = 'その他機器';
			for ($i=1,$count = count($data); $i <= $count ; $i++) { 
				/*switch ($i) {
					case '1':
                        $name = "CT";
						break;
					case '2':
                        $name = "エコキュート";
						break;
					case '3':
                        $name = "IH";
						break;
					case '4':
                        $name = "その他機器";
						break;
					default:
						$name =  $data[$i-1]->name;
					break;
				}*/
				if(!StringUtil::isNullOrEmpty($data[$i-1]->prj_prod_maker_row)){
					$rowData[$upd_item_id.'_'.$i.'_1'] = $name .':' . '[メーカー]' . AppConfig::$MAKER[$data[$i-1]->prj_prod_maker_row];
				}
				if(!StringUtil::isNullOrEmpty($data[$i-1]->prj_prod_model_row)){
					$rowData[$upd_item_id.'_'.$i.'_2'] = $name .':' . '[型式]' . $data[$i-1]->prj_prod_model_row;
				}
				if(!StringUtil::isNullOrEmpty($data[$i-1]->prj_prod_num_row)){
					$rowData[$upd_item_id.'_'.$i.'_3'] = $name .':' . $data[$i-1]->prj_prod_num_row.'枚';
				}
			}
			return $rowData;
		}
	}

	public function setViewShuruiApprove($prj_id){
		$shuruiApprove = new MShuruiApproveDao();
		$shuruiApproveData = $shuruiApprove->getByPrjId($prj_id);
		$shurui_temp = array();
		for($i=1,$count = count($shuruiApproveData); $i<=$count; $i++){
			$shurui_temp = array(
				"prj_shurui_sort".$shuruiApproveData[$i-1]['prj_shurui_sort'] 		=> $shuruiApproveData[$i-1]['prj_shurui_sort']
				,"prj_pic_approve_sts".$shuruiApproveData[$i-1]['prj_shurui_sort'] 	=> $shuruiApproveData[$i-1]['prj_pic_approve_sts']
				,"prj_pic_approve_id".$shuruiApproveData[$i-1]['prj_shurui_sort'] 	=> $shuruiApproveData[$i-1]['prj_pic_approve_id']
				,"prj_pic_approve_date".$shuruiApproveData[$i-1]['prj_shurui_sort'] => $shuruiApproveData[$i-1]['prj_pic_approve_date']
				,"prj_sup_approve_sts".$shuruiApproveData[$i-1]['prj_shurui_sort'] 	=> $shuruiApproveData[$i-1]['prj_sup_approve_sts']
				,"prj_sup_approve_id".$shuruiApproveData[$i-1]['prj_shurui_sort'] 	=> $shuruiApproveData[$i-1]['prj_sup_approve_id']
				,"prj_sup_approve_date".$shuruiApproveData[$i-1]['prj_shurui_sort'] => $shuruiApproveData[$i-1]['prj_sup_approve_date']
				,"updated_time".$shuruiApproveData[$i-1]['prj_shurui_sort'] 		=> $shuruiApproveData[$i-1]['updated_time']
				,"userNameApprove1".$shuruiApproveData[$i-1]['prj_shurui_sort'] 	=> $shuruiApproveData[$i-1]['userNameApprove1']
				,"userNameApprove2".$shuruiApproveData[$i-1]['prj_shurui_sort'] 	=> $shuruiApproveData[$i-1]['userNameApprove2']
			);
			$this->setViewState($shurui_temp);
		}
	}

	public function setViewUpdateHistory($prj_id, $id){
		if(StringUtil::isNullOrEmpty($id))
			return null;
		$prjUpdateHistory = new MPrjUpdateHistoryDao();
		$prjUpdateHistoryData = $prjUpdateHistory->getHistoryByPrjIdAndId($prj_id, $id);
		for($i = 1, $count = count($prjUpdateHistoryData); $i <= $count; $i++){
			$upd_item_after['upd_item_after'.$i] 	= $this->convertJsonToArray($i,$prjUpdateHistoryData[$i-1]['upd_item_after']);
			$upd_item_before['upd_item_before'.$i] 	= $this->convertJsonToArray($i,$prjUpdateHistoryData[$i-1]['upd_item_before']);
			$upd_item_id_upd_sts['upd_sts'.$i] 		= $prjUpdateHistoryData[$i-1]['upd_sts'];
		}
		$this->setViewState(array('id'=>$id));
		$this->setViewState($upd_item_before);
		$this->setViewState($upd_item_after);
		$this->setViewState($upd_item_id_upd_sts);
	}

	public function setAtrributeStaffSendMail($prj_id){
		$approveStatusDao = new MPrjApproveStatusDao();
		$dataApprove = $approveStatusDao->getApproveStatusOfStaffMail($prj_id);
		$this->setAttribute('dataApprove', $dataApprove);
	}
}

?>