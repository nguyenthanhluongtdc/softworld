<?php
date_default_timezone_set("Asia/Ho_Chi_Minh");
/**
*
*/
//test push
if( ! ini_get('date.timezone') )
{
    date_default_timezone_set('Asia/Tokyo');
}
require_once $_SERVER['DOCUMENT_ROOT'] . "/system/config/DefineConstants.php";

require_once ROOT_PATH_COMMON . "/PageIdConstants.php";
require_once ROOT_PATH_COMMON . "/ReportIdConstants.php";
require_once ROOT_PATH_CONFIG . "/AppConfig.php";

require_once ROOT_PATH_COMMON . "/UrlUtil.php";
require_once ROOT_PATH_COMMON . "/NumberUtil.php";
require_once ROOT_PATH_COMMON . "/ParamsUtil.php";
require_once ROOT_PATH_COMMON . "/ActionUtil.php";
require_once ROOT_PATH_COMMON . "/HtmlUtil.php";
require_once ROOT_PATH_COMMON . "/ViewLoader.php";
require_once ROOT_PATH_COMMON . "/StringUtil.php";
require_once ROOT_PATH_COMMON . "/ArrayUtil.php";
require_once ROOT_PATH_COMMON . "/DateUtil.php";
require_once ROOT_PATH_COMMON . "/ValidateUtil.php";
require_once ROOT_PATH_COMMON . "/FileUploadUtil.php";
require_once ROOT_PATH_COMMON . "/MailUtil.php";
require_once ROOT_PATH_COMMON . "/LoggerManager.php";

require_once ROOT_PATH_ACTION . "/core/RunAction.php";
require_once ROOT_PATH_ACTION . "/core/BaseAction.php";
require_once ROOT_PATH_ACTION . "/core/BaseReportAction.php";
//require_once ROOT_PATH_SERVICE . "/core/BaseService.php";

$pageId = ParamsUtil::getQueryParam(REQUEST_PARAM_PAGE_ID);
//var_dump($_GET['req']); exit;

$method = ParamsUtil::getQueryParam(REQUEST_PARAM_ACTION_METHOD);	
	
RunAction::run($pageId, $method);

?>