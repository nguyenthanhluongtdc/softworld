<?php

class DateUtil {

	public static function getCurrentDatetime($format = "Y-m-d H:i:s") {
		return date($format);
	}

	public static function getLastDateOfMonth($date) {
        return date("Y-m-t", strtotime($date));
    }

	public static function dateFromString($value, $format) {
		return DateTime::createFromFormat($format, $value);
	}

	public static function dateToArray($value, $format="Y-m-d", $isNowIfEmpty = false) {

		if(StringUtil::isNullOrEmpty($value)) {
            if ($isNowIfEmpty == true)
                return array(
                        "year" => date('Y')
                        , "month" => date('m')
                        , "day" => date('d')
                    );
			return array(
						"year" => ""
						, "month" => ""
						, "day" => ""
					);
		}
		$arrDate = explode("-", $value);
    	return array(
            "year" => $arrDate[0]
            , "month" => $arrDate[1]
            , "day" => $arrDate[2]
        );
	}
    
    public static function dateFormat($strdate, $currentformat, $format = 'Y-m-d H:i:s'){
        $date = DateUtil::dateFromString($strdate , $currentformat);
        if (!$date)
            return $strdate;
        return $date->format($format);
    }
    
    public static function yearmonthFormat($yearmonth){
        $yearmonth = substr($yearmonth, 0, 4) . '年' . substr($yearmonth, 4,2) . '月';
        return $yearmonth;
    }

    public static function PreviewDate($date){
        if(!StringUtil::isNullOrEmpty($date))
        {
            $date = str_replace('/', '-', $date);
            $dateArray = explode('-', $date);
            return $dateArray[0]."年&nbsp;". $dateArray[1].'月&nbsp;'.$dateArray[2].'日&nbsp;';
        }
        return null;
    }
    /* this function subtract(add) month of date by value
       date is String(yyyy-mm-dd)
       action (+,-);
       value 1..11
       return date(yyyy-mm-dd) affter calculate
    */
    public static function SubAddMonth($date, $action, $value){
        $date = new DateTime($date);
        $date->modify("$action$value month");
        return $date->format('Y-m-d');
    }

    public static function SubAddYear($date, $action, $value) {
        $date = new DateTime($date);
        $date->modify("$action$value year");
        return $date->format('Y-m-d');
    }

    public static function CompareTwoDateString($date1, $date2, $condition){
        $date1_time = strtotime($date1);
        $date2_time = strtotime($date2);
        if($condition == ">="){
            if($date1_time >= $date2_time)
                return true;
            else
                return false;
        }
        elseif($condition == "=="){
            if($date1_time == $date2_time)
                return true;
            else
                return false;
        }
        elseif($condition == "<="){
            if($date1_time <= $date2_time)
                return true;
            else
                return false;
        }
        elseif($condition == "<"){
            if($date1_time < $date2_time)
                return true;
            else
                return false;
        }
        elseif($condition == ">"){
            if($date1_time > $date2_time)
                return true;
            else
                return false;
        }
    }
    public static function convGtJDate($src) {
        list($year, $month, $day) = explode('/', $src);
        if (!@checkdate($month, $day, $year) || $year < 1869 || strlen($year) !== 4 || strlen($month) !== 2 || strlen($day) !== 2)
            return false;
        $date = str_replace('/', '', $src);
        if ($date >= 19890108) {
            $gengo = '平成';
            $wayear = $year - 1988;
        } elseif ($date >= 19261225) {
            $gengo = '昭和';
            $wayear = $year - 1925;
        } elseif ($date >= 19120730) {
            $gengo = '大正';
            $wayear = $year - 1911;
        } else {
            $gengo = '明治';
            $wayear = $year - 1868;
        }
        switch ($wayear) {
            case 1:
                $wadate = $gengo . '元年' . $month . '月' . $day . '日';
                break;
            default:
                $wadate = $gengo . sprintf("%02d", $wayear) . '年' . $month . '月' . $day . '日';
        }
        return $wadate;
    }
    public static function convertyearmonth($str) {
        $date = "";
        if (!StringUtil::isNullOrEmpty($str)) {
            $year = substr($str, 0, 4);
            $month = substr($str, 4, 2) == '' ? '' : '-' . substr($str, 4, 2);
            $date = $year . $month;
        }
        return $date;
    }	

    /*
        $date yyyy-mm-dd
        $action (+,-)
        $value 5,7 date
    */
    public static function calculateDateWithNumber($date, $action, $value){
        if(!StringUtil::isNullOrEmpty($date)){
            $date = date_create($date);
            date_add($date, date_interval_create_from_date_string($action.$value.' days'));
            return date_format($date, 'Y-m-d');
        }
        return null;
    }
}


?>