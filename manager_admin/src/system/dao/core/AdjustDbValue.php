<?php
/**
* 
*/
class AdjustDbValue
{

	private static function adjustDate($val) {
		if(StringUtil::isNullOrEmpty($val)) {
			return null;
		}
		return $val;
	}

	private static function adjustNumber($val) {
		if(!isset($val) || !is_numeric($val) ) {
			return null;
		}
		return $val;
	}

	public static function adjust($tableName, &$arr) {
		if(array_key_exists($tableName, DbConfig::$DB_INFO)) {
		{
				$columns = DbConfig::$DB_INFO[$tableName];
				foreach ($columns as $key => $value) {
					if(array_key_exists($key, $arr)) {
						switch ($value) {
							case DbConfig::DT_DATE:
								$arr[$key] = AdjustDbValue::adjustDate($arr[$key]);
								break;
							case DbConfig::DT_NUMBER:
								$arr[$key] = AdjustDbValue::adjustNumber($arr[$key]);
								break;
							default:
								break;
						}
					}
				}	
			}
			
		}
	}
	
}
?>

