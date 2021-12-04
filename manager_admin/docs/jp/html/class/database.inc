<?php

//データベース接続クラス

//2013/6/29 $GLOBALS['Database_res']を追加 sql3.incでレスを使用できるように

class Database
{

    function __construct()
    {
        $this->Database();
    }

    function Database()
    {

        if (!$GLOBALS['Database_res'] = mysql_connect(DB_HOST, DB_USER, DB_PASS)) {
            return false;
        }

        if (!mysql_query('SET NAMES utf8', $GLOBALS['Database_res'])) { //MYSQLも文字コードを変換
            return false;
        }

        if (!mysql_select_db(DB_SELE, $GLOBALS['Database_res'])) {
            return false;
        }

        return true;
    }


    static function db_to_session($session_key, $table, $sql = false, $encode = false)
    { //データをセッションに入れる//
        /* ========================================================
         * $session_key セッションのkey
         * $table 操作するテーブル（$sqlが代入されていれば関係なし
         * $sql $_GET['no']では指定できなsqlの場合、代入
         * $encode trueなら文字コード変換関数 Array_func::encode_from_arrayのデフォルト変換
         * ====================================================== */
        if (!$sql && $_GET['no']) {
            $sql = "select * from " . $table . " where no = " . $_GET['no'];
        }
        if ($sql) {
            $res = mysql_query($sql);
            $echo = mysql_fetch_assoc($res);
        }
        if ($encode) {
            $echo = Array_func::encode_from_array($echo);
        }
        if (!is_array($echo)) {
            return false;
        }

        foreach ($echo as $key => $value) {
            $_SESSION[$session_key][$key] = $value;
        }
        return true;
    }

    static function session_db_out($session_key)
    {
        /* ========================================================
         *  必ずdb_to_sessionの後で使用する
         * 														  */
        if (is_array($_SESSION[$session_key])) {
            foreach ($_SESSION[$session_key] as $key => $value) {
                $key_db = $key . "_db_out";
                $_SESSION[$session_key][$key_db] = $value;
            }
        }
    }

    static function table_data_check($table, $no = "", $idno = "", $idno_name = "idno")
    {
        /* ========================================================
         * データが該当のテーブル・番号にあるかどうか調べる
         * $table 調べるテーブルの名前
         * $no 通常は$_GET['no']　指定があれば番号を指定（検索対象はno）
         * $id 保持しているアカウントのIDを指定する必要があれば
         * $idno_name $idnoのカラムの名前がidnoでなければ指定する
         * ====================================================== */
        if (!$no) {
            $no = $_GET['no'];
        }

        if ($idno) {
            $sql_id = " and " . $idno_name . " = " . $idno;
        }
        $sql = "select no from " . $table . " where no = " . $no . $sql_id;

        $res = mysql_query($sql);
        $count = mysql_num_rows($res);

        if ($count) {
            return true;
        } else {
            return false;
        }
    }

    static function db_to_session_to_array($name_array, $separator, $session_key)
    {
        /* ========================================================
         * データベースに入っているデータをセパレーターを指定して、セッションの配列に入れなおす
         * 必ずdb_to_session後に使用する
         * $name_array 対象とするレコードを配列にして引数に
         * $separator explodeで使用するセパレーター
         *
         * ====================================================== */

        foreach ($name_array as $key => $value) {
            $trim_value = trim($_SESSION[$session_key][$value], $separator);

            $_SESSION[$session_key][$value] = explode($separator, $trim_value);
        }
    }

    static function db_to_session_to_otherkey($db_columnname, $separator, $array_return_key, $session_key)
    {
        /* ========================================================
         * データベースに入っているデータをセパレーターを指定して、セッションの配列に入れなおす
         * 必ずdb_to_session後に使用する
         * $db_columnname 対象とするレコードを配列にして引数に
         * $separator explodeで使用するセパレーター
         * $array_return_key 分割したものをしまうkeyを配列で指定
         * ====================================================== */

        $trim_value = trim($_SESSION[$session_key][$db_columnname], $separator);

        $array = explode($separator, $trim_value);
        foreach ($array_return_key as $key => $value) {

            $_SESSION[$session_key][$value] = $array[$key];
        }
    }

    static function db_to_session_for_time($main_key_array = array(), $session_key, $separator = ":")
    {
        /* ========================================================
         * データベースに入っている時刻を簡単にform用に変換する
         * 必ずdb_to_session後に使用する
         * $main_key_array 対象とするキー　to_time ,など（_h,_i,_sは含まない）
         * $separator explodeで使用するセパレーター
         * ====================================================== */

        if (is_array($main_key_array)) {
            foreach ($main_key_array as $value) {
                $trim_value = trim($_SESSION[$session_key][$value], $separator);
                $array = explode($separator, $trim_value);
                $h = $value . "_h";
                $i = $value . "_i";
                $s = $value . "_s";
                $_SESSION[$session_key][$h] = $array[0];
                $_SESSION[$session_key][$i] = $array[1];
                $_SESSION[$session_key][$s] = $array[2];

            }
        }


    }

    static function db_to_session_for_date($main_key_array = array(), $session_key, $separator = "-")
    {
        /* ========================================================
         * データベースに入っている日付を簡単にform用に変換する
         * 必ずdb_to_session後に使用する
         * $main_key_array 対象とするキー　birthday ,など（_y,_m,_dは含まない）
         * $separator explodeで使用するセパレーター
         * ====================================================== */

        if (is_array($main_key_array)) {
            foreach ($main_key_array as $value) {
                $trim_value = trim($_SESSION[$session_key][$value], $separator);
                $array = explode($separator, $trim_value);


                $y = $value . "_y";
                $m = $value . "_m";
                $d = $value . "_d";
                $_SESSION[$session_key][$y] = $array[0];
                $_SESSION[$session_key][$m] = $array[1];
                $_SESSION[$session_key][$d] = $array[2];

            }
        }


    }

    static function db_to_session_for_date_ym($main_key_array = array(), $session_key)
    {
        /* ========================================================
         * データベースに入っている年月をform用に変換する
         * 必ずdb_to_session後に使用する
         * $main_key_array 対象とするキー　seikyu_ym ,など（_y,_mは含まない）
         *
         * ====================================================== */

        if (is_array($main_key_array)) {
            foreach ($main_key_array as $value) {

                $date_y = substr($_SESSION[$session_key][$value], 0, 4);
                $date_m = substr($_SESSION[$session_key][$value], 4, 2);



                $y = $value . "_y";
                $m = $value . "_m";
                $_SESSION[$session_key][$y] = $date_y;
                $_SESSION[$session_key][$m] = $date_m;

            }
        }


    }

    static function db_to_session_for_checkbox_solo($main_key_array = array(), $session_key)
    {
        /* ========================================================
         * データベースに入っているチェックボックス用の1 or 0の値をチェックボックス用配列に変換
         * 必ずdb_to_session後に使用する
         * $main_key_array 対象とするキー　
         * ====================================================== */
        if (is_array($main_key_array)) {
            foreach ($main_key_array as $value) {
                if ($_SESSION[$session_key][$value]) {

                    //有効な値なら
                    $value_old = $_SESSION[$session_key][$value];
                    $_SESSION[$session_key][$value] = "";
                    $_SESSION[$session_key][$value][0] = $value_old;
                } else {
                    $_SESSION[$session_key][$value] = "";
                    $_SESSION[$session_key][$value][0] = "";
                }
            }
        }
    }


    static function db_to_session_for_checkbox($db_data_value, $separator, $key, $session_key)
    {
        /* ========================================================
         * データベースのデータをチェックボックス用にセッションの配列に入れなおす
         * $db_data_value データベースのデータ 例： :5:2:6:
         * $separator 分割するためのseparator 例： :
         * $key 新しくセッションに格納するキー 例： $_SESSION[$session_key][$key]
        *======================================================*/
        $trim_value = trim($db_data_value, $separator);
        $value_array = explode($separator, $trim_value);
        unset($_SESSION[$session_key][$key]);
        foreach ($value_array as $key2 => $value) {
            $_SESSION[$session_key][$key][$key2] = $value;
        }
    }

    static function db_to_session_for_seriarize_array($name_array, $session_key)
    {
        /* ========================================================
         * データベースに入っているシリアライズされた配列を、アンシリアライズして配列に変換
            $name_array データベースのカラム名

        *======================================================*/
        foreach ($name_array as $key => $value) {
            $_SESSION[$session_key][$value] = unserialize($_SESSION[$session_key][$value]);
        }


    }

    static function session_to_db_from_solo_checkbox_array($name_array = array(), $session_key)
    {
        /* ========================================================
         * セッションに入っている配列の値を、DB挿入用のセッションに変換
         * （原則、ソロ用）1か0にする
         $name_array データベースのカラム名
        *======================================================*/

        foreach ($name_array as $key => $value) {
            $_SESSION[$session_key][$value] = $_SESSION[$session_key][$value][0];
        }
    }

}

class db_data_change
{

    function sex($sex)
    {
        switch ($sex) {
            case 1:
                return "男性";
                break;
            case 2:
                return "女性";
                break;
            default:
                break;
        }
    }


    function konin($konin)
    {
        switch ($konin) {
            case 1:
                return "有";
                break;
            case 2:
                return "無";
                break;

            default:
                break;
        }
    }


}