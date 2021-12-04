<?php

class UrlUtil {

	public static function url($url, $params) {
		
		if(isset($params) && $params != null) {
			foreach ($params as $key => $value) {
				$url .= "&$key=$value";
			}
		}
		return $url;
	}

	public static function getCurrentUrl() {
		$url = htmlspecialchars(BASE_URL . $_SERVER['REQUEST_URI']);
		return $url;
	}

	public static function getRefererUrl() {
		$url = $_SERVER['HTTP_REFERER'];
		return $url;
	}

}


?>