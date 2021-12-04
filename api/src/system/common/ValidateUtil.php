<?php

class ValidateUtil {

    private $errors = array();


    const _IS_NUM = 1;
    const _IS_NULL = 2;
    const _IS_ALPHA = 3;
    const _IS_ALPHA_NUM = 4;
    const _IS_FILE = 5;
    const _IS_MAIL = 6;
    const _IS_MIN = 7;
    const _IS_MAX = 8;
    const _IS_MAX_MIN = 9;
    const _IS_PASSWORD = 10;
    const _IS_MB_MIN = 11;
    const _IS_MB_MAX = 12;
    const _IS_MB_MAX_MIN = 13;
    const _IS_EQUAL_STRLEN = 14;
    const _IS_EQUAL_STR = 15;
    const _IS_POST_NUM = 16;
    const _IS_TELPHONE = 17;
    const _IS_NOT_EQUAL_STR = 18;
    const _IS_KANA = 19;
    const _IS_DATE = 20; //不具合ある
    const _IS_MAX_NUM = 21;
    const _IS_MIN_NUM = 22;
    const _IS_MAX_MIN_NUM = 23;
    const _IS_ALPHA_NUM_MARK = 24;
    const _IS_DATA_UNIQUE = 25;
    const _IS_DECIMAL=26;
    const _IS_POSTAL_CODE = 27;
    const _IS_FAX = 28;
    const _IS_YEAR_MONTH = 29;
    const _COMPARE_SMALL = 30;
    // has error
    public function hasError(){
        return count($this->errors) > 0;
    }
    
    // get errors
    public function getErrors(){
        return $this->errors;
    }
    

    /**
     * add $errorMessage to $errors
     */
    public function addError($errorMessage, $htmlItemId = null) {
        $error["message"]= $errorMessage;
        if($htmlItemId != null) {
            $error["itemId"] = $htmlItemId;
        }
        $this->errors[] = $error;
    }

   

    /**
     * format message
     */
    public function messageFormat($message, $arg = array()) {
        for ($i=0; $i < count($arg); $i++) { 
            $message = str_replace("{" . $i ."}", $arg[$i], $message);
        }
        return $message;
    }


    
    public function validates($opts) {
        /**
        * $opts = array();
        * $opts[0] = array();
        * $opts[0]["itemName"] = $itemName;
        * $opts[0]["checkNumArray"] = $checkNumArray;
        * $opts[0]["data"] = $data;
        * $opts[0]["min"] = $min;
        * $opts[0]["max"] = $max;
        * $opts[0]["eq"] = $eq;
        * $opts[0]["errMsg"] = $errMsg;
         */
        //var_dump($opts); exit;
        if(is_array($opts)) {
            
            foreach ($opts as $value) {
                $this->validate(
                    $value["itemName"]
                    , isset($value["itemId"]) ? $value["itemId"] : null
                    , $value["data"]
                    , $value["types"]
                    , isset($value["min"]) ? $value["min"] : null
                    , isset($value["max"]) ? $value["max"] : null
                    , isset($value["eq"]) ? $value["eq"] : null
                    , isset($value["errMsg"]) ? $value["errMsg"] : null
                );

            }    
        } else {
            $this->validate(
                $opts["itemName"]
                , isset($opts["itemId"]) ? $opts["itemId"] : null
                , $opts["data"]
                , $opts["types"]
                , isset($opts["min"]) ? $opts["min"] : null
                , isset($opts["max"]) ? $opts["max"] : null
                , isset($opts["eq"]) ? $opts["eq"] : null
                , isset($opts["errMsg"]) ? $opts["errMsg"] : null
            );
        }
        
    }

    /**
     * checkNumArray array(_IS_ALPHA,_IS_NULL);
     *
     * @param int  $max 最大値
     * @param int  $min 最小値
     *
     */
    public function validate(
        $itemName
        , $htmlItemId
        , $data
        , $types
        , $min = null
        , $max = null
        , $eq = null
        , $errMsg = null
        , $uniqueCondition = null
    ) {
        //check types number
        if(is_int($types)) {
            $checkNumArray = array($types);
        } else {
            $checkNumArray = $types;
        }
        //checkout type array
        if (is_array($checkNumArray)) {
            foreach ($checkNumArray  as $key => $num) {
                switch ($num) {
                    case self::_IS_NUM :
                            if (!$this->is_num($data)) {
                                if (isset($errMsg[self::_IS_NUM])) {
                                    $this->addError($errMsg[self::_IS_NUM], $htmlItemId);
                                }
                                else {
                                    $this->addError($this->messageFormat(MessageConstants::COM_ERR_INPUT_DATA_TYPE, array($itemName, "半角数字")), $htmlItemId);
                                }
                            }
                        break;

                    case self::_IS_NULL :
                            if ($this->is_null($data)) {
                                if (isset($errMsg[self::_IS_NULL])) {
                                    $this->addError($errMsg[self::_IS_NULL], $htmlItemId);
                                }
                                else {

                                    $this->addError($this->messageFormat(MessageConstants::COM_ERR_REQUIRED, array($itemName)), $htmlItemId);
                                }
                            }
                        break;

                    case self::_IS_ALPHA :
                            if (!$this->is_alpha($data)) {
                                if (isset($errMsg[self::_IS_ALPHA])) {
                                    $this->addError($errMsg[self::_IS_ALPHA], $htmlItemId);
                                }
                                else {
                                    $this->addError($this->messageFormat(MessageConstants::COM_ERR_ALPHA, array($itemName)), $htmlItemId);
                                }
                            }
                        break;

                    case self::_IS_ALPHA_NUM:
                            if (!$this->is_alphanum($data)) {
                                if (isset($errMsg[self::_IS_ALPHA_NUM])) {
                                    $this->addError($errMsg[self::_IS_ALPHA_NUM], $htmlItemId);
                                }
                                else {
                                    $this->addError($this->messageFormat(MessageConstants::COM_ERR_ALPHA_NUM, array($itemName)), $htmlItemId);
                                }
                            }
                        break;

                    case self::_IS_FILE:
                            if (!$this->is_file($data)) {
                                if (isset($errMsg[self::_IS_FILE])) {
                                    $this->addError($errMsg[self::_IS_FILE], $htmlItemId);
                                }
                                else {
                                    $this->addError($this->messageFormat(MessageConstants::COM_ERR_FILE, array($itemName)), $htmlItemId);
                                }
                            }
                        break;

                    case self::_IS_MAIL:
                            if (!$this->is_mail($data)) {
                                if (isset($errMsg[self::_IS_MAIL])) {
                                    $this->addError($errMsg[self::_IS_MAIL], $htmlItemId);
                                }
                                else {
                                    $this->addError($this->messageFormat(MessageConstants::COM_ERR_EMAIL, array($itemName, "半角英数字と記号「@.-_」")), $htmlItemId);
                                }
                            }
                        break;

                    case self::_IS_MIN:
                            if (!$this->is_min_str($data, $min)) {
                                if (isset($errMsg[self::_IS_MIN])) {
                                    $this->addError($errMsg[self::_IS_MIN], $htmlItemId);
                                }
                                else {
                                    $this->addError($this->messageFormat(MessageConstants::COM_ERR_MIN, array($itemName, $min)), $htmlItemId);
                                }
                            }
                        break;

                    case self::_IS_MAX:
                            if (!$this->is_max_str($data, $max)) {
                                if (isset($errMsg[self::_IS_MAX])) {
                                    $this->addError($errMsg[self::_IS_MAX], $htmlItemId);
                                }
                                else {
                                    $this->addError($this->messageFormat(MessageConstants::COM_ERR_MAX_BYTES, array($itemName, $max)), $htmlItemId);
                                }
                            }
                        break;

                    case self::_IS_MAX_MIN:
                            if (!$this->is_max_min_str($data, $min, $max)) {
                                if (isset($errMsg[self::_IS_MAX_MIN])) {
                                    $this->addError($errMsg[self::_IS_MAX_MIN], $htmlItemId);
                                }
                                else {
                                    $this->addError($this->messageFormat(MessageConstants::COM_ERR_MAX_MIN, array($itemName, $min, $max)), $htmlItemId);
                                }
                            }
                        break;

                    case self::_IS_PASSWORD:
                            if (!$this->is_password($data)) {
                                if (isset($errMsg[self::_IS_PASSWORD])) {
                                    $this->addError($errMsg[self::_IS_PASSWORD], $htmlItemId);
                                }
                                else {
                                    $this->addError($this->messageFormat(MessageConstants::COM_ERR_PASSWORD, array($itemName)), $htmlItemId);
                                }
                            }
                        break;

                    case self::_IS_MB_MIN:
                            if (!$this->is_mb_min_num($data, $min)) {
                                if (isset($errMsg[self::_IS_MB_MIN])) {
                                    $this->addError($errMsg[self::_IS_MB_MIN], $htmlItemId);
                                }
                                else {
                                    $this->addError($this->messageFormat(MessageConstants::COM_ERR_MB_MIN, array($itemName, $min)), $htmlItemId);
                                }
                            }
                        break;

                    case self::_IS_MB_MAX:
                            if (!$this->is_mb_max_num($data, $max)) {
                                if (isset($errMsg[self::_IS_MB_MAX])) {
                                    $this->addError($errMsg[self::_IS_MB_MAX], $htmlItemId);
                                }
                                else {
                                    $this->addError($this->messageFormat(MessageConstants::COM_ERR_MAX_UPLOAD_SIZE, array($itemName, $max)), $htmlItemId);
                                }
                            }
                        break;

                    case self::_IS_MB_MAX_MIN:
                            if (!$this->is_mb_max_min_num($data, $min, $max)) {
                                if (isset($errMsg[self::_IS_MB_MAX_MIN])) {
                                    $this->addError($errMsg[self::_IS_MB_MAX_MIN], $htmlItemId);
                                }
                                else {
                                    $this->addError($this->messageFormat(MessageConstants::COM_ERR_MB_MAX_MIN, array($itemName, $max, $min)), $htmlItemId);
                                }
                            }
                        break;

                    case self::_IS_EQUAL_STRLEN:
                            if (!$this->is_equal_strlen($data, $eq)) {
                                if (isset($errMsg[self::_IS_EQUAL_STRLEN])) {
                                    $this->addError($errMsg[self::_IS_EQUAL_STRLEN], $htmlItemId);
                                }
                                else {
                                    $this->addError($this->messageFormat(MessageConstants::COM_ERR_EQUAL_STRLEN, array($itemName, $eq)), $htmlItemId);
                                }
                            }
                        break;

                    case self::_IS_EQUAL_STR:
                            if (!$this->is_equal_str($data, $eq)) {
                                if (isset($errMsg[self::_IS_EQUAL_STR])) {
                                    $this->addError($errMsg[self::_IS_EQUAL_STR], $htmlItemId);
                                }
                                else {
                                    $this->addError($this->messageFormat(MessageConstants::COM_ERR_EQUAL_STR, array($itemName, $eq)), $htmlItemId);
                                }
                            }
                        break;

                    case self::_IS_POST_NUM:
                            if (!$this->is_post_num($data)) {
                                if (isset($errMsg[self::_IS_POST_NUM])) {
                                    $this->addError($errMsg[self::_IS_POST_NUM], $htmlItemId);
                                }
                                else {
                                    $this->addError($this->messageFormat(MessageConstants::COM_ERR_INPUT_DATA_TYPE, array($itemName, "郵便番号")), $htmlItemId);
                                }
                            }
                        break;

                    case self::_IS_TELPHONE:
                            if (!$this->is_telphone($data)) {
                                if (isset($errMsg[self::_IS_TELPHONE])) {
                                    $this->addError($errMsg[self::_IS_TELPHONE], $htmlItemId);
                                }
                                else {
                                    $this->addError($this->messageFormat(MessageConstants::COM_ERR_INPUT_DATA_TYPE, array($itemName, "半角数字と記号「-」（ハイフン）")), $htmlItemId);
                                }
                            }
                        break;
                    case self::_IS_FAX:
                            if (!$this->is_telphone($data)) {
                                if (isset($errMsg[self::_IS_FAX])) {
                                    $this->addError($errMsg[self::_IS_FAX], $htmlItemId);
                                }
                                else {
                                    $this->addError($this->messageFormat(MessageConstants::COM_ERR_INPUT_DATA_TYPE, array($itemName, "半角数字と記号「-」（ハイフン）")), $htmlItemId);
                                }
                            }
                        break;

                    case self::_IS_NOT_EQUAL_STR:
                            if (!$this->is_not_equal_str($data, $eq)) {
                                if (isset($errMsg[self::_IS_NOT_EQUAL_STR])) {
                                    $this->addError($errMsg[self::_IS_NOT_EQUAL_STR], $htmlItemId);
                                }
                                else {
                                    $this->addError($this->messageFormat(MessageConstants::COM_ERR_NOT_EQUAL_STR_MSG, array($itemName, $eq)), $htmlItemId);
                                }
                            }
                        break;

                    case self::_IS_KANA:
                            if (!$this->is_kana($data)) {
                                if (isset($errMsg[self::_IS_KANA])) {
                                    $this->addError($errMsg[self::_IS_KANA], $htmlItemId);
                                }

                                else {
                                    $this->addError($this->messageFormat(MessageConstants::COM_ERR_INPUT_DATA_TYPE, array($itemName, "半角カタカナ、全角カタカナ")), $htmlItemId);
                                }
                            }
                        break;

                    case self::_IS_DATE:
                            if (!$this->is_date($data)) {
                                if (isset($errMsg[self::_IS_DATE])) {
                                    $this->addError($errMsg[self::_IS_DATE], $htmlItemId);
                                }
                                else {
                                    $this->addError($this->messageFormat(MessageConstants::COM_ERR_DATE_FORMAT, array($itemName)), $htmlItemId);
                                }
                            }
                        break;
                    case self::_IS_MIN_NUM:
                            if (!$this->is_min_num($data, $min)) {
                                if (isset($errMsg[self::_IS_MIN_NUM])) {
                                    $this->addError($errMsg[self::_IS_MIN_NUM], $htmlItemId);
                                }
                                else {
                                    $this->addError($this->messageFormat(MessageConstants::COM_ERR_MIN, array($itemName, $min)), $htmlItemId);
                                }
                            }
                        break;
                    case self::_IS_MAX_NUM:
                            if (!$this->is_max_num($data, $max)) {
                                if (isset($errMsg[self::_IS_MAX_NUM])) {
                                    $this->addError($errMsg[self::_IS_MAX_NUM], $htmlItemId);
                                }
                                else {
                                    $this->addError($this->messageFormat(MessageConstants::COM_ERR_MAX, array($itemName,  $max)), $htmlItemId);
                                }
                            }
                        break;
                    case self::_IS_MAX_MIN_NUM:
                            if (!$this->is_max_min_num($data, $min, $max)) {
                                if (isset($errMsg[self::_IS_MAX_MIN_NUM])) {
                                    $this->addError($errMsg[self::_IS_MAX_MIN_NUM], $htmlItemId);
                                }
                                else {
                                    $this->addError($this->messageFormat(MessageConstants::COM_ERR_MAX_MIN, array($itemName, $min, $max)), $htmlItemId);
                                }
                            }
                        break;

                    case self::_IS_ALPHA_NUM_MARK:
                            if (!$this->is_alphanum_mark($data)) {
                                if (isset($errMsg[self::_IS_ALPHA_NUM_MARK])) {
                                    $this->addError($errMsg[self::_IS_ALPHA_NUM_MARK], $htmlItemId);
                                }
                                else {
                                    $this->addError($this->messageFormat(MessageConstants::COM_ERR_ALPHA_NUM_MARK, array($itemName)), $htmlItemId);
                                }
                            }
                        break;
                        
                    case self::_IS_DECIMAL:
                            if (!$this->is_decimal($data)) {
                                if (isset($errMsg[self::_IS_DECIMAL])) {
                                    $this->addError($errMsg[self::_IS_DECIMAL], $htmlItemId);
                                }
                                else {
                                    $this->addError($this->messageFormat(MessageConstants::COM_ERR_INPUT_DATA_TYPE, array($itemName, "半角小数字")), $htmlItemId);
                                }
                            }
                        break;

                    case self::_IS_POSTAL_CODE:
                    if(!$this->is_postalcode($data)){
                        if(isset($errMsg[self::_IS_POSTAL_CODE])){
                            $this->addError($errMsg[self::_IS_POSTAL_CODE], $htmlItemId);
                        }else{
                            $this->addError($this->messageFormat(MessageConstants::COM_ERR_INPUT_DATA_TYPE, array($itemName,'正しい型式')), $htmlItemId);
                        }
                    }
                        break;
                    case self::_IS_YEAR_MONTH:
                    if(!$this->is_year_month($data)){
                        if(isset($errMsg[self::_IS_YEAR_MONTH])){
                            $this->addError($errMsg[self::_IS_YEAR_MONTH], $htmlItemId);
                        }else{
                            $this->addError($this->messageFormat(MessageConstants::COM_ERR_INPUT_DATA_TYPE, array($itemName,'正しく年月')), $htmlItemId);
                        }
                    }
                        break;

                    case self::_COMPARE_SMALL:            
                        
                        if($this->compareSmall($data, $key)){
                            if(isset($errMsg[self::_COMPARE_SMALL])){
                                $this->addError($errMsg[self::_COMPARE_SMALL], $htmlItemId);
                            }else{
                                $this->addError($this->messageFormat(MessageConstants::COM_ERR_INPUT_DATA_TYPE, array($itemName,'正しく年月')), $htmlItemId);
                            }   
                        }

                        break;
                }
            }
        }

    }

    // 数字チェック
    private function is_num($data) {
        $result = true;

        if (!$this->is_null($data)) {
            if (preg_match('/^-?[0-9]+$/', $data)) {
                // 数字の場合
                $result = true;
            } else {
                // 数字ではない場合
                $result = false;
            }
        }

        return $result;
    }

    private function compareSmall($number1, $number2){
        if($number1 < $number2){
            return true;
        }else return false;
    }


    // 英字チェック
    private function is_alpha($data) {
        $result = true;

        if (preg_match('/^[a-zA-Z]+$/', $data)) {
            // 英字の場合
            $result = true;
        } else {
            // 英字ではない場合
            $result = false;
        }

        return $result;
    }

    // 英数字チェック
    private function is_alphanum($data) {
        $result = true;
        if ($data != '') {

            if (preg_match('/^[a-zA-Z0-9]+$/', $data)) {
                // 英数字の場合
                $result = true;
            } else {
                // 英数字ではない場合
                $result = false;
            }
        }

        return $result;
    }

    // 英数字チェックと - +
    private function is_alphanum_mark($data) {
        $result = true;
        if ($data != '') {

            if (preg_match('/^[a-zA-Z0-9\-\+]+$/', $data)) {
                $result = true;
            } else {
                $result = false;
            }
        }

        return $result;
    }

    // null チェック
    private function is_null($data) {
        if (is_null($data)) {
            return true;
        } else {
            if ($data === '') {
                return true;
            }
        }
        return false;

    }

    // file チェック
    private function is_file($filepath) {
        $result = true;
        if (file_exists($filepath)) {
            $result = true;
        } else {
            $result = false;
        }

        return $result;
    }

    // mail チェック用
    private function is_mail($email){
        $result = true;
        if (!$this->is_null($email)) {
            if (preg_match('/^([\w])+([\w\._-])*\@([\w])+([\w\._-])*\.([a-zA-Z])+$/', $email)) {
                $reuslt =  true;
            } else {
                $result = false;
            }
        }

        return $result;
    }

    // 数字範囲  1以上とか
    private function is_min_num($data, $min) {
        $result = true;
        if (!$this->is_null($data)) {
            if ($data >= $min) {
                $result = true;
            } else {
                $result = false;
            }
        }
        return $result;
    }

    // 数字範囲 10以下
    private function is_max_num($data, $max) {
        $result = true;
        if (!$this->is_null($data)) {
            if ($max >= $data) {
                $result = true;
            } else {
                $result = false;
            }
        }
        return $result;
    }

    private function is_max_min_num($data, $min, $max) {
        $result = true;
        if (!$this->is_null($data)) {
            if ($this->is_max_num($data, $max) && $this->is_min_num($data, $min)) {
                $reuslt = true;
            } else {
                $result = false;
            }
        }
        return $result;
    }


    // max文字数　チェック
    private function is_max_str($data, $max) {
        $result = true;
        if (!$this->is_null($data)) {
            if ($max >= strlen($data)){
                $result =  true;
            } else {
                $result = false;
            }
        }
        return $result;
    }

    // min文字数　チェック
    private function is_min_str($data, $min) {
        $result = true;
        if (!$this->is_null($data)) {
            if (strlen($data) >= $min){
                $result =  true;
            } else {
                $result = false;
            }
        }
        return $result;
    }

    // min max 文字数　チェック
    private function is_max_min_str($data, $min, $max) {
        $result = true;

        if (!$this->is_null($data)) {
            if ($this->is_max_str($data, $max) && $this->is_min_str($data,$min)) {
                $result = true;
            } else {
                $result = false;
            }
        }
        return $result;
    }

    // 数字のみのパスワードは禁止
    private function is_password($data) {

        $result = true;
        if (!$this->is_null($data)) {
            if ($this->is_num($data)) {
                $result = false;
            }
        }

        return $result;
    }

    // max文字数　チェック
    private function is_mb_max_num($data, $max) {
        $result = true;
        if (!$this->is_null($data)) {
            if ($max >= mb_strlen($data)){
                $result =  true;
            } else {
                $result = false;
            }
        }
        return $result;
    }

    // min文字数　チェック
    private function is_mb_min_num($data, $min) {
        $result = true;
        if (!$this->is_null($data)) {
            if (mb_strlen($data) >= $min){
                $result =  true;
            } else {
                $result = false;
            }
        }
        return $result;
    }

    // min max 文字数　チェック
    private function is_mb_max_min_num($data, $min, $max) {
        $result = true;

        if (!$this->is_null($data)) {
            if ($this->is_mb_max_num($data, $max) && $this->is_mb_min_num($data,$min)) {
                $result = true;
            } else {
                $result = false;
            }
        }
        return $result;
    }

    // 文字数確認
    private function is_equal_strlen($data, $eq) {
        $result = true;

        if (strlen($data) != $eq) {
            $result = false;
        }

        return $result;
    }

    // 文字確認
    private function is_equal_str($data, $eq) {
        $result = true;

        if ($data != $eq) {
            $result = false;
        }

        return $result;
    }

    // 文字確認
    private function is_not_equal_str($data, $eq) {
        $result = true;

        if (!$this->is_null($data)) {
            if ($data == $eq) {
                $result = false;
            }
        }

        return $result;
    }

    // 郵便番号チェック
    private function is_post_num($data) {
        $result = true;
        if (!$this->is_null($data)) {
            if (preg_match("/^[0-9]{3}-[0-9]{4}$/", $data)) {//old: /^\d{3}\-\d{4}$/
                $result = true;
            } else {
                $result = false;
            }
        }

        return $result;
    }

    // 電話番号チェック
    private function is_telphone($data) {
        $result = true;
        if (!$this->is_null($data)) {
            if (preg_match("/^[0-9]{2,4}-[0-9]{2,4}-[0-9]{3,4}$/", $data)) {///^\d{2,4}-\d{2,4}-\d{4}$/
                $result = true;
            } else {
                $result = false;
            }
        }

        return $result;
    }

    // カナチェック
    public function is_kana($data) {
        $result = true;
        $data = preg_replace('/(\s|　)/','',$data);
        if (!$this->is_null($data)) {
                if(preg_match("/^[ァ-ヾ]+$/u",$data)){
                $result = true;
            }else{
                $result = false;
            }
        }

        return $result;
    }

    // 日付妥当性チェック
    // 不具合あるので使用しない
    public function is_date($date) {
        $result = true;
        if (!$this->is_null($date)) {
            $date = str_replace('/', '-', $date);
            if (self::checkInputDate($date)) {
                $timestamp = strtotime($date);
                $year = date("Y", $timestamp);
                $month = date("m", $timestamp);
                $day = date("d", $timestamp);
                $arrDate = DateUtil::dateToArray($date);
                if($arrDate["month"] != $month 
                    || $arrDate["day"] != $day 
                    ||  $arrDate["year"] != $year) {
                    return false;
                }
                if (checkdate($arrDate["month"], $arrDate["day"], $arrDate["year"])) {
                    $result = true;
                }
            } else {
                $result = false;
            }
        }

        return $result;
    }

    private function checkInputDate($date) {
        $result = true;
        if (!$this->is_null($date)) {
            if (preg_match("/^\d{4}-\d{1,2}-\d{1,2}$/", $date)) {
                $result = true;
            } else {
                $result = false;
            }
        }
        return $result;
    }

    public function check_start_time_end_time($itemName, $htmlItemId, $startTime, $endTime, $timeFormat = "Y-m-d") {
        $result = false;
        $startDateObj = DateTime::createFromFormat($timeFormat, $startTime);
        $endDateObj = DateTime::createFromFormat($timeFormat, $endTime);
        $errors = DateTime::getLastErrors();
        if (empty($errors["warning_count"]) && $startDateObj !== false && $endDateObj !== false) {
            $result = $startDateObj < $endDateObj;
        }
        if(!$result) {
            $this->addError($this->messageFormat(ErrorMessage::$error_messages["com_err_start_date_end_date"], array($itemName)), $htmlItemId);
        }
    }
    /**
     * Decimal値かチェックします（100、100.12などできます）
     * @param type $data
     */
    public function is_decimal($data){
        //^([0-9]\d*|0)(\.\d+)?$
        $result = true;
        if (!$this->is_null($data)) {
            if (preg_match("/^[0-9]+(\.[0-9]+)?$/", $data)) {
                $result = true;
            } else {
                $result = false;
            }
        }
        return $result;
    }
    
    public function is_postalcode($data){
        $pattern = "/^([0-9]){3}[-]([0-9]){4}$/";
        if (preg_match($pattern, $data)){
            return true;
        }
        return false;
    }

    /*ex:201604*/
    public function is_year_month($data){
        if(!$this->is_null($data) ){
            if(strlen($data) === 6)
                return true;
            return false;
        }
        return true;
    }
}