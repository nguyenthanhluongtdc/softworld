<?php

class ParamsUtil {

    public static function isExistsPostParam($name) {
        return isset($_POST) && array_key_exists($name, $_POST);
    }

    public static function isExistsQueryParam($name) {
        return isset($_GET) && array_key_exists($name, $_GET);
    }
    
    public static function isExistsFile($name) {

        return isset($_FILES) && array_key_exists($name, $_FILES);

    }
    
    public static function getPostParamDate($name, $default = null) {
        $val = ParamsUtil::isExistsPostParam($name) ? $_POST[$name] : $default;
        if(StringUtil::isNullOrEmpty($val)) {
            $val = null;
        }
        return $val;
    }
    
    public static function getPostFile($name, $default = null) {
        $val = ParamsUtil::isExistsFile($name) ? $_FILES[$name] : $default;
        return $val;

    }
    public static function getPostParamDates($mappingNames = null) {
        return ParamsUtil::getParamMapping($mappingNames, function($val) {
            return ParamsUtil::getPostParamDate($val);
        });
    }

    public static function getQueryParamNumeric($name, $default = null) {
        $val = ParamsUtil::isExistsQueryParam($name) ? $_GET[$name] : $default;
        if(is_array($val)) {
            foreach ($val as $key => $value) {
                $tempVal = NumberUtil::unformat($value);
                if(!is_numeric($tempVal)) {
                    if(isset($default)) {
                        $val[$key] = $default;
                    }
                } else {
                    $val[$key] = $tempVal;
                }
            }
        } else {
            $tempVal = NumberUtil::unformat($val);
            if(!is_numeric($tempVal)) {
                if(isset($default)) {
                    $val = $default;
                }
            } else {
                $val = $tempVal;
            }  
        }
        return $val;
    }

    public static function getQueryParamNumerics($mappingNames = null) {
        return ParamsUtil::getParamMapping($mappingNames, function($val) {
            return ParamsUtil::getQueryParamNumeric($val, 0);
        });
    }

    public static function getPostParamNumeric($name, $default = null) {
        $val =  ParamsUtil::isExistsPostParam($name)  ? $_POST[$name] : $default;
        if(is_array($val)) {
            foreach ($val as $key => $value) {
                $tempVal = NumberUtil::unformat($value);
                if(StringUtil::isNullOrEmpty($tempVal)) {
                    $tempVal = null;
                }
                if(!is_numeric($tempVal)) {
                    if(isset($default)) {
                        $val[$key] = $default;
                    }
                } else {
                    $val[$key] = $tempVal;
                }
            }
        } else {
            $tempVal = NumberUtil::unformat($val);
            if(StringUtil::isNullOrEmpty($tempVal)) {
                $tempVal = null;
            }
            if(!is_numeric($tempVal)) {
                if(isset($default)) {
                    $val = $default;
                }
            } else {
                $val = $tempVal;
            }  
        }
        return $val;
    }
    
    public static function getPostParamNumerics($mappingNames = null) {
        return ParamsUtil::getParamMapping($mappingNames, function($val) {
            return ParamsUtil::getPostParamNumeric($val, 0);
        });
    }

    public static function getQueryParam($name, $default = null) {
		return  ParamsUtil::isExistsQueryParam($name) ? $_GET[$name] : $default;
	}

    public static function getParam($name, $default = null) {
        $param = ParamsUtil::getPostParam($name, $default);
        if($param) {
            return $param;
        }
        return ParamsUtil::getQueryParam($name, $default);
    }

    public static function getParams($mappingNames = null) {
        return array_merge(ParamsUtil::getPostParams($mappingNames), ParamsUtil::getQueryParams($mappingNames));
    }
 
    public static function getPostParam($name, $default = null) {
		return  ParamsUtil::isExistsPostParam($name)  ? $_POST[$name] : $default;
	}

    public static function getPostParams($mappingNames = null) {
        return ParamsUtil::getParamMapping($mappingNames, function($val) {
            return ParamsUtil::getPostParam($val);
        });
	}

	public static function getQueryParams($mappingNames = null) {
        return ParamsUtil::getParamMapping($mappingNames, function($val) {
            return ParamsUtil::getQueryParam($val);
        });
	}

    public static function getParamMapping($mappingNames = null, $method) {
        if($mappingNames != null && !is_array($mappingNames) || !isset($method)) {
            throw new Exception("Error Processing Request", 1);
        }
        $result = array();
        if(isset($_POST)) {
            if(isset($mappingNames)) {
                if(ParamsUtil::isAssoc($mappingNames)) {
                    foreach ($mappingNames as $key => $rsKey) {
                        $result[$rsKey] = $method($key);
                    }    
                } else {
                    foreach ($mappingNames as $rsKey) {
                        $result[$rsKey] = $method($rsKey);
                    }
                }
            } else {
                foreach ($_POST as $key => $value) {
                    $result[$key] = $value;
                }
            }
        }
        
        return $result;
    }

	private static function isAssoc($arr)
    {
        return array_keys($arr) !== range(0, count($arr) - 1);
    }


    /**
    * Get list data with key mapping
    * EX:
    *       $mappings = [
    *           "uriage_sengyo_shire_id" => "id"
    *           , // 仕入先
    *           "uriage_sengyo_shire_supplier" => "supplier_id"
    *           // 部門
    *           , "uriage_sengyo_shire_bumon" => "bumon_id"
    *           // 金額
    *           , "uriage_sengyo_shire_kingaku" => [
    *               "keyResult" => "kingaku"
    *               , "method" => function($key){
    *                       return ParamsUtil::getPostParamNumeric($key);
    *                   }
    *           ]
    *       ]
    * Note: mapping element can include the method
    *       , it used get parameters from $_POST, Default is ParamsUtil::getPostParam
    * request data: 
    *   uriage_sengyo_shire_id = [1,2]
    *   uriage_sengyo_shire_supplier = [1,2]
    *   uriage_sengyo_shire_kingaku = [100,200]
    * array result:
    * $result[0] = ["id" => 1, "supplier_id" => 1, "kingaku" => 100]
    * $result[1] = ["id" => 2, "supplier_id" => 2, "kingaku" => 200]
    */
    public static function getListData($mappings) {
        $result = array();
        $size = 0;
        $data = array();
        
        foreach ($mappings as $key => $value) {
            if(is_array($value) && is_object($value["method"])) {
                $data[$key] = $value["method"]($key);
            } else {
                $data[$key] = ParamsUtil::getPostParam($key);
            }
            if($size == 0 && isset($data[$key])) {
                $size = count($data[$key]);
            }
        }   
        for ($i=0; $i < $size; $i++) { 
            $row = array();
            foreach ($mappings as $key => $value) {
                if(is_array($value)) {
                    $row[$value["keyResult"]] = $data[$key][$i];
                } else {
                    $row[$value] = $data[$key][$i];
                }
            }
            $result[] = $row;
        }

        return $result;
    }

}


?>