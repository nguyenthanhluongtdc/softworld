<?php

/**
**/
require_once ROOT_PATH_COMMON . "/MessageConstants.php";
require_once ROOT_PATH_DAO . "/core/DbManager.php";
require_once ROOT_PATH_DAO . "/MFileHistoryDao.php";
class DownloadAction extends BaseAction {
	public function rules() {
		return array(
			"docs" => array("post", "get")
		);
	}
	public function save(){
		$FileHistory = new MFileHistoryDao();
		$Id  = ParamsUtil::getQueryParamNumeric("Id", 0);
		if(!StringUtil::isNullOrEmpty($Id)){
			$file = $FileHistory->getById($Id);
			if($file['prj_file_type']==1)
				$folder = 'docs';
			if($file['prj_file_type']==2)
				$folder = 'estimates';
			$path = FILE_UPLOAD.'/projectinfo/'.$file['prj_id'].'/'.$folder.'/'.$file['prj_file_file_path'];
			$size   = filesize($path);
			$file_path  = $path;
			$path_parts = pathinfo($file_path);
			$file_name  = $path_parts['basename'];
			$file_ext   = $path_parts['extension'];
			if(file_exists($path)) {
	            header('Content-Description: File Transfer');
	            header('Content-Type: application/octet-stream');
	            header('Content-Disposition: attachment; filename='.$file['prj_file_file_name']);
	            header('Content-Transfer-Encoding: binary');
	            header('Expires: 0');
	            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	            header('Pragma: public');
	            header('Content-Length: ' . filesize($path));
	            ob_clean();
	            flush();
	            readfile($path);
	            exit;
	        }
		}
	}
}
