<?php
	require_once ROOT_PATH_DAO . "/MFileHistoryDao.php";
	require_once ROOT_PATH_COMMON . "/MessageConstants.php";
	class FilehistoryAction extends BaseAction{
		public function rules(){
			return array(
			 	"delete" => array("post", "get")
			);
		}
		public function ajaxActions(){
			return array("delete");
		}
		public function delete(){
			$Id = ParamsUtil::getPostParamNumeric("id", 0);
			$FileHistory = new MFileHistoryDao();
			if($FileHistory->deleteId($Id))
			{
				return json_encode(array(
					'status' => "1"
					,'msg' =>  MessageConstants::COM_INFO_DELETE_SUCCESS
				));
			}else{
				return json_encode(array(
					'status' => "0"
					,'msg' => MessageConstants::COM_ERR_DATA_NOT_FOUND
				));
			}
		}
	}