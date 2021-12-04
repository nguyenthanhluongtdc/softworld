<?php

class ActionUtil {

	public static function redirect($page, $method = null, $params = null) {
		$url = $page;
		if(filter_var($url, FILTER_VALIDATE_URL) == false) {
			$url = ActionUtil::getActionUrl($page, $method, $params);
		}
		
        header("Location:" . $url);
        exit();
	}

	public static function getActionUrl($pageId, $actionMethod = null, $params = null) {
		if(StringUtil::isNullOrEmpty($pageId)) {
			throw new InvalidArgumentException("pageId is require.");
		}

		$url = ADMIN_BASE_URL . "?" . REQUEST_PARAM_PAGE_ID . "=" . $pageId;
		if(isset($actionMethod)) {
			$url .= "&" . REQUEST_PARAM_ACTION_METHOD . "=" . $actionMethod;
		}
		if(APP_CSRF) {
			$session = new SessionManager();
			$url .= "&token=" . $session->getToken();
		}
		return UrlUtil::url($url, $params);
	}

	public static function getReportActionUrl($pageId, $reportId, $params = null) {
		if(StringUtil::isNullOrEmpty($pageId)) {
			throw new InvalidArgumentException("pageId is require.");
		}
		if(StringUtil::isNullOrEmpty($reportId)) {
			throw new InvalidArgumentException("reportId is require.");
		}
		$url = ADMIN_BASE_URL . "?" . REQUEST_PARAM_PAGE_ID . "=" . $pageId;
		$url .= "&" . REQUEST_PARAM_ACTION_METHOD . "=pdf";
		$url .= "&" . REQUEST_PARAM_ACTION_REPORT_ID . "=" . $reportId;
		if(APP_CSRF) {
			$session = new SessionManager();
			$url .= "&token=" . $session->getToken();
		}
		return UrlUtil::url($url, $params);
	}
	

	public static function  getMasterName($lstMaster, $val, $keyName = null, $keyCompare = null) {
		if(isset($keyName) && isset($keyCompare)) {

			if(!isset($keyCompare)) {
                $keyCompare = $keyName;
            }
            if(isset($lstMaster)) {
                foreach ($lstMaster as $value) {
                    if($value[$keyCompare] == $val) {
                        return $value[$keyName];
                    }
                }
            }
            return "";
		} else {
			foreach ($lstMaster as $key => $value) {
				if($key == $val) {
                    return $value;
                }
			}
     	}
	}
}


?>