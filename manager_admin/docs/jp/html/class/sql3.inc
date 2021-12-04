<?php

//2012/10/22時点で最新版
//2013/02/19  sql_query_all($run = true) 等更新
//2013/06/29 limitの指定をdelete用追加
//2013/06/29 $GLOBALS['Database_res']を使用してトランザクションできるように変更
//2013/08/08 $collate を追加

class Sql_class3
{

    //testモード設定 falseにすると、viewを無効にする
    var $test_mode = true; //論理値 の true なら　MYSQLエラーも表示
    var $collate = "collate utf8_bin ";
    //濁点・半濁点をまとめて検索するには "COLLATE utf8_unicode_ci " を使用する（インスタンスで指定）

    var $default_table;
    var $sql;
    var $complete_sql;
    var $complete_sql_all;
    var $add;
    var $add_get;
    var $order;
    var $limit;
    var $res;
    var $res_all;
    var $data;
    var $count;
    var $count_all;
    var $group_by;
    var $column_array;
    var $transaction = 0;

    var $null = false;
    var $last_insert_id;

    function view()
    {
        if ($this->test_mode == true) {
            $array = debug_backtrace();

            $write_sql = str_replace(",", ",", $this->complete_sql); //コンマはなし
            $write_sql = str_replace("where ", "<br />where ", $write_sql);
            $write_sql = str_replace("and ", "<br />and ", $write_sql);
            $write_sql = str_replace("order by ", "<br />order by ", $write_sql);
            $write_sql = str_replace("inner join ", "<br />inner join ", $write_sql);
            $write_sql = str_replace("when ", "<br />when ", $write_sql);
            $write_sql = str_replace("end ", "<br />end ", $write_sql);
            $write_sql = str_replace("update ", "<span style='color:coral;'>update </span>", $write_sql);
            $write_sql = str_replace("delete ", "<span style='color:#ffffff;background: crimson;'>delete </span>", $write_sql);
            $write_sql = str_replace("select ", "<span style='color:dodgerblue;'>select </span>", $write_sql);

            ?>
            <div style="padding:5px;border:solid 1px darksalmon;font-weight: bold;background: ivory"><?= $write_sql ?>

                <br />
            <span style="font-weight: 400;text-decoration: underline;background: #ffffff">
            File = <?= $array[0]['file'] ?> <br />
            Line = <?= $array[0]['line'] ?>
                </span>
        </div>
        <?php

        }
    }

    function start_transaction()
    {
        //トランザクション開始
        //トランザクションをはじめる準備
        $Query = "set autocommit = 0;";

        mysql_query($Query, $GLOBALS['Database_res']);

        //トランザクション開始
        $Query = "START TRANSACTION;";
//        $Query = "begin;";

        mysql_query($Query, $GLOBALS['Database_res']);


        $this->transaction = 1; //トランザクション開始済みの合図

    }


    function rollback()
    {
        //ロールバック
        $Query = "rollback;";
        mysql_query($Query, $GLOBALS['Database_res']);

    }


    function commit()
    {
        //コミット
        $Query = "commit;";

        mysql_query($Query, $GLOBALS['Database_res']);

    }


    function get_array_column($table_name, $atmark_number = 0)
    {
        /* ========================================================
         * $add_column を指定すると@を含むカラム名も含む
         *@の個数でカラムの世代を表わす
         * 0個 初期のカラムで指定
         * 1個～カラムを追加する必要がある場合に段階的に個数を増やす
         *不使用のカラムは $db->column_array['Field']['$key']をunsetする
         * 例：unset($db->column_array['Field']['no']);
         * ======================================================*/

        $sql = 'show fields from ' . $table_name;

        $result = mysql_query($sql);

        $fieldAr = array();

        while ($ret = mysql_fetch_assoc($result)) {
            $array_key = $ret['Field'];

            ///@を含むカラム名は、個数を数える,指定個数を超えていれば飛ばす
            $at_count = substr_count($ret['Field'], "@");
            if ($at_count > $atmark_number) {
                continue;
            }

            foreach ($ret as $key => $fields) {

                $this->column_array[$key][$array_key] = $fields;
            }
        }


    }

    function blank_to_null($array, $not_key_array = array())
    {

        //空白の値をnullにする
        //変更しない値を指定 $not_key_array

        if (is_array($array)) {
            foreach ($array as $key => $value) {
                if ($value == "" && !array_search($key, $not_key_array)) {
                    $array[$key] = NULL;
                }
            }
        }
        return $array;
    }

    function mysql_fetch_assoc()
    {

        $this->data = mysql_fetch_assoc($this->res);
    }

    function add_get()
    {
        if ($this->add) {
            $this->add_get = preg_replace("/^ and /", "", $this->add) . $this->group_by . $this->order . $this->limit;
        }
    }

    function query_or_die()
    {

        if (strstr(__FILE__, ":\\") || $this->test_mode === true) { //ローカルかテストモードなら
            $this->res = mysql_query($this->complete_sql) or die(mysql_error() . " --  " . $this->complete_sql);
        } else {
            $this->res = mysql_query($this->complete_sql);
        }
        if ($this->transaction && !$this->res) { //トランザクション開始していて失敗ならrollback
            $this->rollback();
        } elseif (strpos($this->complete_sql, "insert into") !== false) {
            $this->last_insert_id = mysql_insert_id();
        }
    }

    function query_or_die_all()
    {

        if (strstr(__FILE__, ":\\")) { //ローカルなら
            $this->res_all = mysql_query($this->complete_sql_all) or die(mysql_error() . " --  " . $this->complete_sql_all);
        } else {
            $this->res_all = mysql_query($this->complete_sql_all);
        }
        if ($this->transaction && !$this->res) { //トランザクション開始していて失敗ならrollback
            $this->rollback();
        }
    }

    function count_all()
    {

        //sql処理実行
        if (!$this->res_all) {
            $this->sql_query_all();
        }
        $this->count_all = mysql_num_rows($this->res_all);
    }

    function count()
    {

        //sql処理実行
        if (!$this->res) {
            $this->sql_query();
        }
        $this->count = mysql_num_rows($this->res);
    }

    function group_by($column, $join_table = false)
    {
        if ($join_table) {
            $join = $join_table . ".";
        }
        $this->group_by = " group by " . $join . $column;
    }

    function select($table_name, $column = "*", $get_select_table = false)
    {
        /* ========================================================
         * $get_select_table trueなら $table_name のデータを抽出する(joinする場合)
         * それ以外でfalseじゃなければ、テーブル名
         * $column にドットがあれば、テーブル名指定として判断（変更しない）
         * ====================================================== */
        $this->default_table = $table_name;

        if ($get_select_table) {
            if ($get_select_table === true) {
                $get_select_table = $table_name;
            }
            $column_array = explode(",", $column);
            $column = "";
            foreach ($column_array as $key => $value) {
                //.ドットがあれば、変更しない
                if (strpos($value, ".") === false) { //ドット無し
                    $column .= $get_select_table . "." . $value . ",";
                } else { //ドットあり
                    $column .= $value . ",";
                }
            }
            $column = trim($column, ",");
        }
        $this->sql .= "select " . $column . " from " . $table_name;
    }

    function delete($table_name)
    {

        $this->sql = "delete from " . $table_name;
    }

    function get_column_select($target_column_array, $target_table_array = false)
    {
        /* ========================================================
         * 抜き出しカラムを指定するSQL（*を変換する）
         * $sql　元のSQL文
         * $target_column_array 対象カラムを配列に入れたもの
         * $target_table_array  対象テーブルを配列に入れたもの
         * ====================================================== */
        if (is_array($target_column_array)) {
            foreach ($target_column_array as $key => $value) {
                if (is_array($target_table_array)) {
                    $new_column .= $target_table_array[$key] . "." . $value . ",";
                } else {
                    $new_column .= $value . ",";
                }
            }
            $new_column = rtrim($new_column, ",");
        }

        $sql_new = str_replace("*", $new_column, $this->sql);
        $this->sql = $sql_new;
    }

    function order_by_speed($table)
    { //通常のセレクト文を高速検索に$sql はindexの利いたカラム[no]のみ指定する

        /*
         * order by を高速化する関数
         * ※使い方要注意
         *
         */
        $res = Sql_class2::query_or_die($this->sql);

        $primary_no = array();
        while ($echo = mysql_fetch_assoc($res)) {
            array_push($primary_no, $echo['no']);
        }

        $ii = 0;
        foreach ($primary_no as $key => $value) {
            $ii++;
            $sql1 .= $value . ",";
            $sql2 .= "when '$value' then $ii ";
        }

        $sql1 = trim($sql1, ",");
        $new_sql = "select * from " . $table . " where no in ($sql1) order by case no " . $sql2 . "end;";

        $this->sql = $new_sql;
    }

    function pluralsearch_array($array, $column, $number = false, $join_table = false)
    {
        /* =============================================================
         * 複数選択時のSQL文
         * $array 選択したチェックボックス等の配列
         * $column 対象カラム
         * $number 検索対象が数字ならtrueに
         * $join_table 結合するテーブルがある場合、結合対象のテーブル
         * ============================================================= */

        if ($join_table) { //結合する場合
            $join = $join_table . ".";
        }
        if ($array[0] != "") {
            foreach ($array as $key => $value) {
                if ($number) { //数字なら
                    $sql_tmp .= $join . $column . " = " . $value . " or ";
                } else {
                    $sql_tmp .= $join . $column . " = '" . $value . "' or ";
                }
            }
            $sql_tmp = rtrim($sql_tmp, " or ");
            $sql_key .= "and (" . $sql_tmp . ") ";
        }
        $this->add = $sql_key;
    }

    function keyword_search_column_array($column_array, $keyword, $join_table = false, $prefectures_array = false, $before_percent = "%", $after_percent = "%")
    {

        /* =============================================
         * $keyword 検索キーワード（もともとのキーワード）
         * $column_array 対象とするカラムを配列で指定
         * $join_table 結合対象テーブルがあれば、対象テーブル
         * * $column_array にドットがあれば、テーブル名指定として判断
         * 　(引数$join_tableはそのカラムでは無視）
         * =========================================== */

        if (!trim($keyword) || !is_array($column_array)) {
            return "";
        }

        //都道府県と市区町村が連続していたら分割する処理
        if (is_array($prefectures_array)) {
            $keyword = Sql_class3::prefecture_division($keyword, $prefectures_array);
        }

        //キーワード分割
        $keyword = mb_convert_kana($keyword, "s", "UTF-8");
        $key_arr = split(" ", $keyword);
        $key_arr = (array_filter($key_arr));
        //スペース削除キーワード

        if ($key_arr[0] != "") {

            foreach ($key_arr as $key => $value) {

                $value = ereg_replace("'", "&#039;", $value);
                $value = ereg_replace("&", "&amp;", $value);
                $value = ereg_replace("\"", "&quot;", $value);
                $value = mysql_escape_string($value);


                $value2 = mb_convert_kana($value, 'KV', "UTF-8");
                //columnの配列を指定
                $sql_tmp = "";

                foreach ($column_array as $key => $column) {

                    list($column, $join_table) = self::join_table_column_get($column, $join_table);

                    //.ドットがあれば、変更しない
                    if (strpos($column, ".") !== false) { //ドットありの場合、join_table指定は無視
                        list($join_table_var, $column) = explode(".", $column);
                        $join = $join_table_var . ".";
                    } elseif (is_array($join_table)) { //join_tableが配列での指定なら
                        $join = $join_table[$key] . ".";
                        $join_table_var = $join_table;
                    } elseif ($join_table) { //結合する場合
                        $join = $join_table . ".";
                        $join_table_var = $join_table;
                    } else {
                        $join = "";
                        $join_table_var = "";
                    }

                    if ($column == "area1") { //都道府県なら
                        if ($join_table_var) {
                            $table_name = $join_table_var;
                        } else {
                            $table_name = $this->default_table;
                        }
                        $sql_tmp .= Sql_class3::keyword_to_area1_sql($table_name, $value2, $prefectures_array);
                    } else {
                        //数字の全角/半角のゆれも吸収できる。
                        $sql_tmp .= "convert(" . $join . $column . " using utf8) " . $this->collate . "like '" . $before_percent . $value2 . $after_percent . "' or ";
                    }
                }

                $sql_tmp = trim($sql_tmp, " or ");

                $sql_key .= " and (" . $sql_tmp . ") ";
            }
        }

        $this->add .= $sql_key;
    }

    function prefecture_division($keyword, $prefectures_array)
    {

        foreach ($prefectures_array as $key => $value) {
            if (strpos($keyword, $value) !== false) {
                $array_joken[$key] = "/(" . $value . ")/";
            }
        }

        if (is_array($array_joken) !== false) {
            return preg_replace($array_joken, "$1 ", $keyword);
        } else {
            return $keyword;
        }
    }

    function keyword_to_area1_sql($table_name, $keyword, $prefectures_array, $column = "area1")
    {

        foreach ($prefectures_array as $key => $value) {
            if ($keyword) {
                if (strpos($value, $keyword) !== false) { //見つかれば
                    $array_area1[$key] = $key;
                }
            }
        }
        //Sqlに置き換え
        if (is_array($array_area1) !== false) {
            $sql = " (";
            foreach ($array_area1 as $key2 => $value2) {
                $sql .= $table_name . "." . $column . " = " . $value2 . " or ";
            }
            $sql = rtrim($sql, " or ");

            $sql .= ") or ";
            return $sql;
        }
    }

    function search($column, $palam, $number = false, $join_table = false)
    {
        /* =============================================
         * $palam 検索語句（1または0など、all指定で全て
         * $column 対象カラム
         * $number 検索が数字で、クォートが不要ならtrue
         * $join_table 結合するなら結合テーブル（結合しないなら空欄 "" を引数に）
         * ※NULLはクォートで囲って指定する
         * =========================================== */

        list($getcolumn, $getjoin_table) = $this->join_table_column_get($column, $join_table);
        if (!$palam && $palam != "0") { //空かfalseなら(NULLは別）
            return "";
        } elseif ($palam == "all") { //全てならSQLなし
            return "";
        } else {
            if ($palam == 'NULL') {
                $this->add .= " and " . $getcolumn . " is NULL";
            } elseif (($number && is_numeric($palam)) || ($number && strpos($palam, ".") !== false)) { //数字ならまたはドットを含む文章なら
                $this->add .= " and " . $getcolumn . " = " . $palam;
            } else {
                $this->add .= " and " . $getcolumn . " = '" . $palam . "'";
            }
        }
    }


    function search_date($column, $param_array, $param_main_key, $before_percent = "", $after_percent = "%", $number = false, $join_table = false)
    {
        /* =============================================
        **　日付型を検索する関数　
        */
        /** $param_array 検索対象とする配列 ＄＿GET　や　$_SESSION[$this->session_key]など
         * $param_main_key 検索語句のメインのキー
         * 例：birthday なら　birthday_y,birthday_m,birthday_dをそれぞれと見る
         * $column 対象カラム
         * $number 検索が数字で、クォートが不要ならtrue
         * $join_table 結合するなら結合テーブル（結合しないなら空欄 "" を引数に）
         * ※NULLはクォートで囲って指定する
         * ※年のみ、または年月のみでも検索可。年がない場合は、月日があっても無効
         * =========================================== */

        list($getcolumn, $getjoin_table) = $this->join_table_column_get($column, $join_table);


        $key_y = $param_main_key . "_y";
        $key_m = $param_main_key . "_m";
        $key_d = $param_main_key . "_d";


        if (!$param_array[$key_y] && $param_array[$key_y] != "0") { //空かfalseなら(NULLは別）
            return "";
        } elseif ($param_array[$key_y] == "all") { //全てならSQLなし
            return "";
        } else {
            if ($param_array[$key_y] == 'NULL') {
                $this->add .= " and " . $join . $column . " is NULL";
            } else {

                //全て指定があれば
                if (strlen($param_array[$key_y]) == 4 && strlen($param_array[$key_m]) == 2 && strlen($param_array[$key_d]) == 2) {

                    $this->add .= " and " . $getcolumn . " = '" . $param_array[$key_y] . "-" . $param_array[$key_m] . "-" . $param_array[$key_d] . "'";

                } elseif (strlen($param_array[$key_y]) == 4 && strlen($param_array[$key_m]) == 2) {
                    //年・月だけ
                    $this->add .= " and " . $getcolumn . " like '" . $before_percent . $param_array[$key_y] . "-" . $param_array[$key_m] . "-" . $after_percent . "'";
                } elseif (strlen($param_array[$key_y]) == 4) {
                    //年だけ
                    $this->add .= " and " . $getcolumn . " like '" . $before_percent . $param_array[$key_y] . "-" . $after_percent . "'";
                }


            }
        }
    }

    function search_prefecture($column, $palam, $number = false, $join_table = false, $prefectures_array = false)
    {
        /* =============================================
         * $palam 検索語句（1または0など、all指定で全て
         * $column 対象カラム
         * $number 検索が数字で、クォートが不要ならtrue
         * $join_table 結合するなら結合テーブル（結合しないなら空欄 "" を引数に）
         * ※NULLはクォートで囲って指定する
         *
         * $column が area1なら都道府県を検索
         * =========================================== */


        if (!$palam && $palam != "0") { //空かfalseなら(NULLは別）
            return "";
        } elseif ($palam == "all") { //全てならSQLなし
            return "";
        } else {

            list($getcolumn, $getjoin_table) = $this->join_table_column_get($column, $join_table);
            if (is_array($prefectures_array) && $column == "area1") {

                $this->add .= Sql_class3::keyword_to_area1_sql($getjoin_table, $palam, $prefectures_array);
            } elseif ($palam == 'NULL') {
                $this->add .= " and " . $getcolumn . " is NULL";
            } elseif ($number && is_numeric($palam)) { //数字ならまたはNULLなら
                $this->add .= " and " . $getcolumn . " = " . $palam;
            } else {
                $this->add .= " and " . $getcolumn . " = '" . $palam . "'";
            }
        }
    }

    function search_not($column, $palam, $number = false, $join_table = false)
    {
        /* =============================================
         * $palam 検索語句（1または0など、all指定で全て #space なら空白以外
         * $column 対象カラム
         * $number 検索が数字で、クォートが不要ならtrue
         * $join_table 結合するなら結合テーブル（結合しないなら空欄 "" を引数に）
         * =========================================== */

        list($getcolumn, $getjoin_table) = $this->join_table_column_get($column, $join_table);
        if (!$palam && $palam != "0") {
            return "";
        }
        if ($palam == "all" || !trim($palam)) { //全てならSQLなし
            return "";
        } else {
            if ($palam == "#space") {
                $palam = "";
            }
            if ($number && (is_numeric($palam) || $palam == "NULL")) { //数字またはNULLなら
                $this->add .= " and " . $getcolumn . " <> " . $palam;
            } else {
                $this->add .= " and " . $getcolumn . " <> '" . $palam . "'";
            }
        }
    }

    function search_isnot($column, $palam, $number = false, $join_table = false)
    {
        /* =============================================
         * $palam 検索語句（1または0など、all指定で全て #spaceは使えない
         * $column 対象カラム
         * $number 検索が数字で、クォートが不要ならtrue
         * $join_table 結合するなら結合テーブル（結合しないなら空欄 "" を引数に）
         * ※$join_tableは検索対象とするテーブル名を指定
         * NULLを使用する場合は、文字列として'NULL'を指定する
         * =========================================== */

        list($getcolumn, $getjoin_table) = $this->join_table_column_get($column, $join_table);

        if (!$palam && $palam != "0") {
            return "";
        }
        if ($palam == "all" || !trim($palam)) { //全てならSQLなし
            return "";
        } else {

            if (($number && (is_numeric($palam)) || $palam == "NULL")) { //数字またはNULLなら
                $this->add .= " and " . $getcolumn . " is not " . $palam;
            } else {
                $this->add .= " and " . $getcolumn . " is not '" . $palam . "'";
            }
        }
    }

    function search_array_or($column_param_array, $number = false, $join_table = false)
    {
        /* =============================================
         * or検索を一回で作る処理
         * $column_param_array キー　column　値　palam
         * array(key1 => value1, key2 => value2)の場合
         * and ($key1 = value1 or key2 = value2) となる
         * =========================================== */

        if (is_array($column_param_array) !== false) {
            foreach ($column_param_array as $key => $value) {
                if (($number && is_numeric($value)) || ($number && strpos($value, ".") !== false)) { //数字ならまたはドットを含む文章なら
                    $joken_array[] = $key . " = " . $value;
                } else {
                    $joken_array[] = $key . " = '" . $value . "'";
                }
            }
            $this->or_join($joken_array);

        }


    }


    function search_array_palam($column, $palam_array, $number = false, $join_table = false)
    {
        /* =============================================
         * IN句使用(OR検索)
         * $palam_array 検索語句を配列で（1または0など、all指定で全て
         * $column 対象カラム
         * $number 検索が数字で、クォートが不要ならtrue
         * $join_table 結合するなら結合テーブル（結合しないなら空欄 "" を引数に）
         * =========================================== */
        list($getcolumn, $getjoin_table) = $this->join_table_column_get($column, $join_table);

        if (is_array($palam_array) !== false) {
            foreach ($palam_array as $value) {
                if ($number && is_numeric($value)) { //数字なら
                    $in_word .= $value . ",";
                } else {
                    $in_word .= "'" . $value . "',";
                }
            }
        }
        $in_word = trim($in_word, ",");
        if (!$palam_array && $palam_array != "0") {
            $this->add .= "";
        }
        if ($palam_array == "all" || is_array($palam_array) === false) { //全てならSQLなし
            $this->add .= "";
        } elseif (strpos($getcolumn, "(") !== false) { //カッコがあれば、IN句について、複数カラム指定として設定
            $this->add .= " and " . $getcolumn . " IN ((" . $in_word . "))";

        } else {
            $this->add .= " and " . $getcolumn . " IN (" . $in_word . ")";
        }
    }

    function search_array_column($column_array, $palam, $number = false, $join_table = false, $prefectures_array = false)
    {
        /* =============================================
         * $palam_array 検索語句
         * $column 対象カラムを配列で
         * $number 検索が数字で、クォートが不要ならtrue
         * $join_table 結合するなら結合テーブル（結合しないなら空欄 "" を引数に）
         * $prefectures_array が配列ならarea1を都道府県検索
         * =========================================== */
        if ($palam || $param == "0") {
            if ($join_table) { //結合する場合
                $join = $join_table . ".";
            }

            $sql = " and (";
            if ($number && is_numeric($palam)) { //数字なら
                $in_word .= $palam . "";
            } else {
                $in_word .= "'" . $palam . "'";
            }
            if (is_array($column_array) !== false) {
                foreach ($column_array as $value) {


                    list($getcolumn, $getjoin_table) = $this->join_table_column_get($value, $join_table);

                    if (is_array($prefectures_array) && $value == "area1") {

                        $sql .= Sql_class3::keyword_to_area1_sql($getjoin_table, $palam, $prefectures_array);
                    } else {
                        $sql .= $getcolumn . " = " . $in_word . " or ";
                    }
                }
            }
            $sql = rtrim($sql, " or ");
            $sql .= ")";
        } else {
            $sql = "";
        }
        $this->add .= $sql;
    }

    function range($column, $lowkey, $highkey, $number = false, $join_table = false, $fukumu = true)
    {
        /* ========================================================
         * 検索条件を範囲で指定する関数
         * $columun 検索対象カラム
         * $lowkey 下の数値や日付
         * $highkey 上の数値や日付
         * $fukumu 既定はtrue で以上、以下　falseの場合は、指定の値は含まない（未満となる）
         * ※betweenでは使えないので、エラーで停止
         * ====================================================== */
        if ($join_table) { //結合する場合
            $join = $join_table . ".";
        }
        if ($number) { //数字なら
            $high .= $highkey;
            $low .= $lowkey;
        } else {
            $high .= "'" . $highkey . "'";
            $low .= "'" . $lowkey . "'";
        }
        $sql = "";
        if ($not) { //否定形
            $not_text = " not";
        } else {
            $not_text = "";
        }


        if ($lowkey && $highkey) { //両方あればbetween
            $sql .= " and " . $join . $column . $not_text . " between " . $low . " and " . $high;

            if ($fukumu === false) {
                //betweenで含まないは指定出来ないのでエラー
                echo "sql error";
                exit;
            }
        } else {

            if ($fukumu === false) {
                $left_allow = " < ";
                $right_allow = " > ";
            } else {
                $left_allow = " <= ";
                $right_allow = " >= ";
            }


            if (trim($highkey) || $highkey === 0) {
                $sql .= " and " . $join . $column . $left_allow . $high;
            }
            if (trim($lowkey) || $lowkey === 0) {
                $sql .= " and " . $join . $column . $right_allow . $low;
            }
        }

        $this->add .= $sql;
    }
    function roop_mysql_fetch_assoc($return = false)
    {
        /* =============================================
         * $sql_queryしたものをwhile で配列へ格納
         * =========================================== */
        if($this->res){

            while($data = mysql_fetch_assoc($this->res)){
                $this->data[] = $data;
            }

            if($return) {
                return $this->data;
            }
        }else{
            return "not res";
        }
    }

    function sql_query($run = true)
    {
        /* =============================================
         * $sql_basic 基本となるSQL文（where limit を含まない
         * $sql_add　追加SQL （where部分)and も含む文字で可
         * $sql_limit limitのSQL文
         * 戻り値 変換して完成したSQL文
         * $run をfalseで実行せずにSQL文だけ作成
         * =========================================== */
        if ($this->add) {
            $this->complete_sql = $this->sql . " where " . preg_replace("/^ and /", "", $this->add) . $this->group_by . $this->order . $this->limit;
        } else {
            $this->complete_sql = $this->sql . $this->group_by . $this->order . $this->limit;
        }
        //レスも作成
        if ($run) {
            $this->query_or_die();
        }
    }

    function sql_query_all($run = true)
    {
        /* =============================================
         * $sql_basic 基本となるSQL文（where limit を含まない
         * $sql_add　を含まないでqueryを実行
         * 戻り値 変換して完成したSQL文
         * $run をfalseで実行せずにSQL文だけ作成
         * =========================================== */
        if ($this->add) {
            $this->complete_sql_all = $this->sql . " where " . preg_replace("/^ and /", "", $this->add) . $this->group_by;
        } else {
            $this->complete_sql_all = $this->sql . $this->group_by;
        }
        //レスも作成
        if ($run) {
            $this->query_or_die_all();
        }
    }

    function or_join($joken_array)
    {
        /* =============================================
         * 複数の条件をorで結合して括弧で閉じる頭にandがあっても削除する）
         * 戻り値 変換して完成したSQL文
         * =========================================== */
        if (is_array($joken_array)) {
            $sql = " (";
            $i = 0;
            foreach ($joken_array as $key => $value) {
                if (!$value) {
                    continue;
                }
                $i++;
                $sql .= preg_replace("/^ and /", "", $value) . " or ";
            }
            $sql = " and " . preg_replace("/ or $/", "", $sql) . ")";
        }
        if ($i) {
            $this->add .= $sql;
        } else {
            $this->add .= "";
        }
    }

    function and_join($joken_array)
    {
        /* =============================================
         * 複数の条件をandで結合して括弧で閉じる頭にandがあっても削除する）
         * 戻り値 変換して完成したSQL文
         * =========================================== */

        if (is_array($joken_array)) {
            $sql = " (";
            $i = 0;
            foreach ($joken_array as $key => $value) {
                if (!$value) {
                    continue;
                }
                $i++;
                $sql .= preg_replace("/^ and /", "", $value) . " and ";
            }
            $sql = " and " . preg_replace("/ and $/", "", $sql) . ")";
        }
        if ($i) {
            $this->add .= $sql;
        } else {
            $this->add .= "";
        }
    }

    function autochoose_insert_update($table_name, $column_array, $param_array, $search_column_key_palam_value,$unset_array = array('insert' => false,'update' => false))
    { //sql3版　20140812
        //データが存在するかどうかでinsert とupdateを使い分ける
        //$search_column_key_palam_value には、重複をチェックするための配列を入れる
        //key は カラム value は値
        //複数のand条件で検索が可能
        //$column_arrayと$param_arrayには検索対象は入れない（$search_columnと重複させない）
        //$unset_array['insert']['key]  insert時に不使用にしたいカラムを多重配列の「値」に入れる
        //$unset_array['update']['key]  update時に不使用にしたいカラムを多重配列の「値」に入れる

        /**
         * $column_arrayと$param_arrayはkeyをあわせる必要あり
         */
        if (is_array($this->column_array['Field']) && !$column_array) {
            $column_array = $this->column_array['Field'];
        }

        $db = new Sql_class3;
        $db->select($table_name);
        if (is_array($search_column_key_palam_value) !== false) {
            foreach ($search_column_key_palam_value as $key => $value) {
        $db->search($key, $value, false);
            }
        }
$db->sql_query(true);
        $db->count();

        if ($db->count) { //存在すればupdate

            if(is_array($unset_array['update']) !== false){

                foreach ($unset_array['update'] as $key_un => $un_column) {
                    unset($column_array[$un_column]);
                }
            }


            $this->update($table_name, $column_array, $param_array);
            if (is_array($search_column_key_palam_value) !== false) {
                foreach ($search_column_key_palam_value as $key => $value) {
                    $this->search($key, $value, false);
                }
            }
            $this->sql_query();
            $result = "update";
        } else { //見つからなければinesrt

            if(is_array($unset_array['insert']) !== false){
                foreach ($unset_array['insert'] as $key_un => $un_column) {
                    unset($column_array[$un_column]);
                }
            }

            if (is_array($search_column_key_palam_value) !== false) {
                foreach ($search_column_key_palam_value as $key => $value) {
                    array_push($column_array, $key);
                    array_push($param_array, $value);
                }
            }

            $this->insert($table_name, $column_array, $param_array);
            $result = "insert";
        }
        return $result;//更新か新規かを返す
    }

    function insert($table_name, $column_array, $param_array)
    {
        //$param_array @NULL@ の場合、NULLになる
        /**
         * $column_arrayと$param_arrayはkeyをあわせる必要あり
         */
        if (is_array($this->column_array['Field']) && !$column_array) {
            $column_array = $this->column_array['Field'];
        }
        if (!is_array($column_array) || !is_array($param_array)) {
            $this->sql = false;
            return;
        }
        $sql = "insert into " . $table_name . " (";

        foreach ($column_array as $key => $value) {
            if ($value) {
                $column_value .= "`" . $value . "`,";
                //				if (is_numeric($param_array[$key])) {
                //					$param_value .= $param_array[$key] . ",";
                //				} else {
                //数字判断はしない
                if ((string)$param_array[$key] == "@NULL@" || ($param_array[$key] == "" && $this->null)) {
                    //$param_array[$key]がint0の場合の対策でstringを入れる
                    $param_value .= "NULL,";

                } else {
                    $param_value .= "'" . $param_array[$key] . "',";

                }


                //				}
            } else {
                unset($param_array[$key]);
            }
        }
        $column_value = rtrim($column_value, ",") . ")";
        $param_value = rtrim($param_value, ",") . ")";


        $sql .= $column_value . " values(" . $param_value;
        $this->sql = $sql;;
    }

    function update($table_name, $column_array, $param_array)
    {
        /**
         * $column_arrayと$param_arrayはkeyをあわせる必要あり
         */
        //$param_array @NULL@ の場合、NULLになる　

        if (is_array($this->column_array['Field']) && !$column_array) {
            $column_array = $this->column_array['Field'];
        }
        $sql = "update " . $table_name . " set ";
        if (is_array($column_array)) {
            foreach ($column_array as $key => $value) {
                if ($value) {

                    if (strpos($param_array[$key], "@nocomma") !== false) {
                        //クオートではさまない（式をそのままSQL文に入れるため）
                        $nocomma_value = str_replace("@nocomma", "", $param_array[$key]);
                        $sql .= "`" . $value . "` = " . $nocomma_value . ",";

                    } elseif ((string)$param_array[$key] == '@NULL@' || ($param_array[$key] == "" && $this->null)) {
                        //$param_array[$key]がint0の場合の対策でstringを入れる
                        $sql .= "`" . $value . "` = NULL,";

                    } else {
                        $sql .= "`" . $value . "` = '" . $param_array[$key] . "',";

                    }
                }
            }
            $sql = rtrim($sql, ",");
        }


        $this->sql = $sql;
    }

    function join_table($main_table, $join_table, $main_column, $join_column, $join_type = "inner")
    {
        /* =============================================
         * テーブル結合用関数
         * $main_table メインのテーブル名
         * main_tableが空ならドットは入れない（メインカラムで指定する）
         * $join_table 結合するテーブル名
          * join_tableが空ならドットは入れない（ジョインカラムで指定する）
         * $main_column メインテーブルの結合対象カラム
         * $join_column 結合するテーブルの結合対象カラム
         * =========================================== */

        if ($main_table) {
            $main_table_after_dotted = ".";
        } else {
            $main_table_after_dotted = "";
        }
        if ($join_table) {
            $join_table_after_dotted = ".";
        } else {
            $join_table_after_dotted = "";
        }

        $join_sql = " " . $join_type . " join " . $join_table . " on " . $main_table . $main_table_after_dotted . $main_column . " = " . $join_table . $join_table_after_dotted . $join_column;
        $this->sql .= $join_sql;
    }

    function sort($column, $sort, $join_table = false)
    {
        /* ========================================================
         * sqlのソート文作成関数
         * $column ソートするカラム名
         * $sort desc or asc
         * $join_table 結合している場合は、ソート対象とするテーブル名
         * ====================================================== */
        if ($join_table) { //結合する場合
            $join = $join_table . ".";
        }
        if (!$this->order) {
            $this->order .= " order by " . $join . $column . " " . $sort;
        } else {
            $this->order .= "," . $join . $column . " " . $sort;
        }
    }

    function keyword_to_db_search($global_array, $keyword, $table_array)
    {
        $keyword = strtoupper(mb_convert_kana($keyword, "askh", "euc-jp"));
        //$table_array 配列でテーブルを指定、指定テーブルはand検索とする
        foreach ($global_array as $key => $value) {
            $value = strtoupper(mb_convert_kana($value, "askh", "euc-jp"));
            if (strpos($value, $keyword) !== false) { //見つかれば
                $array_area1[$key] = $key;
            }
        }
        //Sqlに置き換え
        if (is_array($array_area1) !== false) {
            $sql .= " (";
            foreach ($table_array as $key_table => $value_table) {

                foreach ($array_area1 as $key2 => $value2) {
                    $sql .= $value_table . " = " . $value2 . " and ";
                }
            }
            $sql = rtrim($sql, " and ");
            $sql .= ") or ";
            $this->add .= $sql;
        }
    }

    function keyword_to_db_search_shokushu2($global_array, $keyword, $table_array)
    {
        $keyword = strtoupper(mb_convert_kana($keyword, "askh", "euc-jp"));

        //配列でテーブルを指定、指定テーブルはand検索とする
        foreach ($global_array as $key => $value_array) {
            foreach ($value_array as $key2 => $value2) {
                $value2 = strtoupper(mb_convert_kana($value2, "askh", "euc-jp"));
                if (strpos($value2, $keyword) !== false) { //見つかれば
                    $key_s = $key . "-" . $key2;
                    $array_area1[$key_s] = $key2;
                }
            }
        }
        //Sqlに置き換え
        if (is_array($array_area1) !== false) {
            $sql .= " (";
            foreach ($table_array as $key_table => $value_table) {

                foreach ($array_area1 as $key2 => $value2) {
                    $sql .= $value_table . " = " . $value2 . " and ";
                }
            }
            $sql = rtrim($sql, " and ");
            $sql .= ") or ";
            $this->add .= $sql;
        }
    }

    function limit($limit = 0, $search_rows = 10)
    {
//        $search_rowsをfalseにすると、削除用のlimit句を作成

        if ($search_rows) { //通常のselect用

            if (is_numeric($limit) === true) {
                $this->limit .= " limit " . $limit . ", " . $search_rows;
            } else {
                $this->limit .= " limit 0, " . $search_rows;
            }
        } else { //削除用
            if (is_numeric($limit) === true) {
                $this->limit .= " limit " . $limit;
            } else {
                $this->limit .= " limit 0";
            }
        }
    }

    function join_table_column_get($column, $join_table)
    {
        /* ========================================================
         * columnとjoin_tableを元に、正しいcolumnとjoin_tableを返す
         * (columnにはテーブル名も結合済みで返す
         * 例：t_client.id ,t_client
         * ====================================================== */

        if (strpos($column, ".") !== false) {
            list($getjoin_table, $dummy) = explode(".", $column);
            $getcolumn = $column;
        } elseif ($join_table) {
            $getjoin_table = $join_table;
            $getcolumn = $join_table . "." . $column;
        } else {
            $getjoin_table = $this->default_table;
            $getcolumn = $column;
        }


        return array($getcolumn, $getjoin_table);
    }



}


class Sql3_img
{


    function upload_img_and_return_filename($name, $id, $shop = true, $session_key)
    {
        /* ========================================================
         * $id ユーザーまたはショップのno
         * $shop アップロードするディレクトリ （shopならtrue,ユーザーならfalse）
         * 戻り値　エラーならfalse
         * 成功なら　update用のSQL文（変更がなければ空(falseではない）を返すので注意）
         * ====================================================== */
        $tmp_file = $name . "_tmp_file";
        $delete = $name . "_delete";
        $img_db = $name . "_db_out";

        if (!$_SESSION[$session_key][$delete] && $_SESSION[$session_key][$tmp_file]) {
            $return0 = Img::img_upload(ROOT_PATH_DOG . $_SESSION[$session_key][$tmp_file], $id, $shop); //引数
        }

        if (!$_SESSION[$session_key][$delete] && !$_SESSION[$session_key][$tmp_file]) {
            return "no_update";
        }

        if ($_SESSION[$session_key][$delete]) {

            Img::delete_img($_SESSION[$session_key][$img_db]);
            $_SESSION[$session_key][$name] = "";

        } elseif ($return0 !== false) {
            $_SESSION[$session_key][$name] = $return0;
        } else {
            return false;
        }
        return "update";
    }


}