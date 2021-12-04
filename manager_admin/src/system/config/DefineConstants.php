<?php


define("BASE_URL",  "http://" . $_SERVER['HTTP_HOST']);
define("ADMIN_BASE_URL", BASE_URL . "/index.php");

define("ROOT_PATH", $_SERVER['DOCUMENT_ROOT']);

define("ROOT_PATH_CONFIG", ROOT_PATH . "/system/config");
define("ROOT_PATH_ACTION", ROOT_PATH . "/admin/action");
define("ROOT_PATH_ACTION_REPORT", ROOT_PATH . "/admin/action/report");

define("ROOT_PATH_VIEW", ROOT_PATH . "/admin/view");
define("ROOT_PATH_VIEW_REPORT", ROOT_PATH . "/admin/view/report");

define("ROOT_PATH_DAO", ROOT_PATH . "/system/dao");
define("ROOT_PATH_SERVICE", ROOT_PATH . "/system/service");
define("ROOT_PATH_COMMON", ROOT_PATH . "/system/common");
define("ROOT_PATH_LIBRARY", ROOT_PATH . "/system/library");
define("ROOT_PATH_RESOURCE", ROOT_PATH . "/system/resource");

define("ROOT_PATH_THEME", ROOT_PATH . "/theme");
define("ADMIN_THEME", "admin");

define("FILE_UPLOAD", ROOT_PATH . "/upload");


define("PATH_ADMIN_LOG", "log");

define("REQUEST_PARAM_PAGE_ID", "req");
define("REQUEST_PARAM_ACTION_METHOD", "mode");

define("REQUEST_PARAM_ACTION_METHOD_VALUE", "pdf");
define("REQUEST_PARAM_ACTION_REPORT_ID", "report");
define("REQUEST_PARAM_ACTION_REPORT_METHOD", "reportmode");

define("APP_CSRF", false);

define("ENVIRONMENT_MODE_DEBUG", true);


?>

