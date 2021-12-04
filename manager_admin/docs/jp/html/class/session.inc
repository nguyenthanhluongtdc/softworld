<?php
//UTF版

session_start();

class Session {

    static function add_session_from_post($session_key) {
        if (is_array($_SESSION[$session_key])) {

            foreach ($_SESSION[$session_key] as $skey => $svalue) {//配列のみ初期化
                if (is_array($svalue) !== false) {
                    unset($_SESSION[$session_key][$skey]);
                    $_SESSION[$session_key][$skey] = "";
                }
            }
        }

        foreach ($_POST as $key => $value) {

            if (is_array($value)) {

                foreach ($value as $key2 => $value2) {

                    $temp = @htmlspecialchars($value2, ENT_QUOTES);
                    $temp = stripslashes($temp);
                    $temp = Text_class::trim_zen_space($temp);
                    $temp = mb_convert_kana($temp, "KV", "UTF-8");

                    $key_text = $key;
                    $_SESSION[$session_key][$key][$key2] = $temp;
                }
            } else {

                $$key = @htmlspecialchars($value, ENT_QUOTES);
                $$key = stripslashes($$key);
                $$key = Text_class::trim_zen_space($$key);
                $$key = mb_convert_kana($$key, "KV", "UTF-8");

                $_SESSION[$session_key][$key] = $$key;
            }
        }
    }

    static function add_session_from_get($session_key) {
        if (is_array($_SESSION[$session_key])) {

            foreach ($_SESSION[$session_key] as $skey => $svalue) {//配列のみ初期化
                if (is_array($svalue) !== false) {
                    unset($_SESSION[$session_key][$skey]);
                    $_SESSION[$session_key][$skey] = "";
                }
            }
        }

        foreach ($_GET as $key => $value) {

            if (is_array($value)) {

                foreach ($value as $key2 => $value2) {

                    $temp = @htmlspecialchars($value2, ENT_QUOTES);
                    $temp = stripslashes($temp);
                    $temp = Text_class::trim_zen_space($temp);
                    $temp = mb_convert_kana($temp, "K", "utf-8");

                    $key_text = $key;
                    $_SESSION[$session_key][$key][$key2] = $temp;
                }
            } else {

                $$key = @htmlspecialchars($value, ENT_QUOTES);
                $$key = stripslashes($$key);
                $$key = Text_class::trim_zen_space($$key);
                $$key = mb_convert_kana($$key, "K", "utf-8");

                $_SESSION[$session_key][$key] = $$key;
            }
        }
    }

    static function add_session_from_post_encode($session_key, $to_encode = false, $sample_text = false) {

        if ($to_encode && $sample_text) {
            $from_encode = mb_detect_encoding($sample_text);
        }

        if (is_array($_SESSION[$session_key])) {

            foreach ($_SESSION[$session_key] as $skey => $svalue) {//配列のみ初期化
                if (is_array($svalue) !== false) {
                    unset($_SESSION[$session_key][$skey]);
                    $_SESSION[$session_key][$skey] = "";
                }
            }
        }

        foreach ($_POST as $key => $value) {

            if (is_array($value)) {

                foreach ($value as $key2 => $value2) {

                    if ($to_encode && $sample_text && $from_encode) {
                        $value2 = mb_convert_encoding($value2, $to_encode, $from_encode);
                    }
                    $temp = @htmlspecialchars($value2, ENT_QUOTES);
//					$temp = stripcslashes($temp);
                    $temp = Text_class::trim_zen_space($temp);
                    $temp = mb_convert_kana($temp, "K", $to_encode);
                    $key_text = $key;
                    $_SESSION[$session_key][$key][$key2] = $temp;
                }
            } else {
                if ($to_encode && $sample_text && $from_encode) {
                    $value = mb_convert_encoding($value, $to_encode, $from_encode);
                }

                $$key = @htmlspecialchars($value, ENT_QUOTES);
//				$$key = stripcslashes($$key);
                $$key = Text_class::trim_zen_space($$key);
                $$key = mb_convert_kana($$key, "K", $to_encode);
                $_SESSION[$session_key][$key] = $$key;
            }
        }
    }

    static function session_delete($session_key) {
        if (is_array($_SESSION[$session_key])) {
            foreach ($_SESSION[$session_key] as $s_key => $s_value) {
                if (is_array($s_value)) {
                    foreach ($s_value as $key2 => $value2) {
                        unset($_SESSION[$session_key][$s_key][$key2]);
                    }
                }
                unset($_SESSION[$session_key][$s_key]);
            }
        }
    }

    static function session_if_empty_assign($session_key,$session_key2,$value){
        if(!isset($_SESSION[$session_key][$session_key2])){
            $_SESSION[$session_key][$session_key2] = $value;
        }
    }

}