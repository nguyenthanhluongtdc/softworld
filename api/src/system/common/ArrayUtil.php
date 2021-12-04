<?php

class ArrayUtil {
	public static function isNullOrEmpty($arr) {
	  	if(isset($arr) && count($arr) > 0) {
	   		return false;
	  	} 
	  	return true;
 	}
	public static function get($arr, $key, $default = null) {
		if(isset($arr) && array_key_exists($key, $arr)) {
			return $arr[$key];
		} 
		return $default;
	}
	/*this function covert array to string
	example: array(1,2)=> "1,2"
	*/
	public static function ArrayToString($array){
		$string = null;
		if(!ArrayUtil::isNullOrEmpty($array)){
			$string = implode(',', $array);
		}
		return $string;
	}
	/*this function covert string to array
	example: "1,2" => array(1,2)
	*/
	public static function StringToArray($String){
		$array = array();
		if(!StringUtil::isNullOrEmpty($String))
		{
			$array = explode(',', $String);
		}
		return $array;
	}
	/*
		return array value by key of an array
	*/
	public static function getValueOfArray($array,$key){
		$value = array();
		if(count($array)>0 && is_array($array)){
			for ($i=0, $count = count($array); $i < $count; $i++) { 
				# code...
				$value[] = $array[$i][$key];
			}
		}
		return $value;
	}
    public static function array_to_csv_download($array, $filename = "export.csv", $delimiter=",") {
        $array = self::encodeSJIScsvarray($array);
        header('Content-Type: application/csv');
        header('Content-Disposition: attachment; filename="'.$filename.'";');

        // open the "output" stream
        // see http://www.php.net/manual/en/wrappers.php.php#refsect2-wrappers.php-unknown-unknown-unknown-descriptioq
        $f = fopen('php://output', 'w');
        ob_end_clean();
        foreach ($array as $line) {
            fputcsv($f, $line, $delimiter);
        }
    }
    public static function encodeSJIScsvarray($arrays){
        foreach ($arrays as &$array){
            foreach ($array as &$item){
                $item = mb_convert_encoding($item, 'SJIS-win', 'UTF-8');
            }
        }
        return $arrays;
    }
}





?>