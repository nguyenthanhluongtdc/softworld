<?php

class StringUtil {
	public static function isNullOrEmpty($value) {
		$result = false;
		//kiểm tra tồn tại và kiểu số hoặc chuỗi số
		if(!isset($value) || (!is_numeric($value) && empty($value))) {
			$result = true;
		}
		return $result;
	}

	public static function startsWith($str, $findValue)
	{
	     $length = strlen($findValue);
	     return (substr($str, 0, $length) === $findValue);
	}

	public static function getFirstCharactor($str)
	{
		if(StringUtil::isNullOrEmpty($str)) {
			return null;
		}
	    return mb_substr($str, 0, 1, "UTF-8");
	}

	public static function endsWith($str, $findValue)
	{
	    $length = strlen($findValue);
	    if ($length == 0) {
	        return true;
	    }
	    return (substr($str, - $length) === $findValue);
	}

	public static function randomString($len){
	    $result = "";
	    $chars = "abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
	    $charArray = str_split($chars);
	    for($i = 0; $i < $len; $i++){
		    $randItem = array_rand($charArray);
		    $result .= "".$charArray[$randItem];
	    }
	    return $result;
	}
	
	public static function removeNewLine($str)
	{
	     return preg_replace("/[\n\r]/"," ",$str); 
	}

	public static function removeWhiteSpace($str)
	{
	     return preg_replace('/\s+/', ' ', $str);
	}

	public static function arrayNullOrEmpty($arr)
	{
		$result = true;
		if(isset($arr)) {
			foreach ($arr as $value) {
				if(!StringUtil::isNullOrEmpty($value)) {
					$result = false;
					break;
				}
			}
		}
		return $result;
	}

	
}
?>