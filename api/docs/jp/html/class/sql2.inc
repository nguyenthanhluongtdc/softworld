<?php

class Sql_class2 {

	function blank_to_null($array, $not_key_array = array()) {

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

	function query_or_die($sql) {
		if (strstr(__FILE__, ":\\")) {//ローカルなら
			$res = mysql_query($sql) or die(mysql_error() . " --  " . $sql);
		} else {
			$res = mysql_query($sql);
		}
		return $res;
	}

	function select_basic($table_name, $column = "*",$join_select_table = false) {
		/* ========================================================
		 * $join_select_table trueなら $table_name のデータを抽出する
		 * それ以外でfalseじゃなければ、テーブル名
		 *
		 *
		 * ======================================================*/
		if($join_select_table){
			if($join_select_table === true){
				$join_select_table = $table_name;
			}
			$column_array = explode(",", $column);
			$column = "";
			foreach($column_array as $key => $value){
				$column .= $join_select_table.".".$value.",";
			}
			$column = trim($column,",");
		}
		return "select " . $column . " from " . $table_name;
	}

	function delete($table_name) {

		return "delete from " . $table_name;
	}

	function get_column_select($sql, $target_column_array, $target_table_array = false) {
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

		$sql_new = str_replace("*", $new_column, $sql);
		return $sql_new;
	}

	function order_by_speed($sql, $table) {//通常のセレクト文を高速検索に$sql はindexの聞いたカラム[no]のみ指定する
		/*
		 * order by を高速化する関数
		 *
		 *
		 */
		$res = Sql_class::query_or_die($sql);

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

		return $new_sql;
	}

	function keyword($keyword, $array_column, $join_table = false, $special_search = false) {
		/* =============================================
		 * $keyword 検索キーワード（もともとのキーワード）
		 * $array_column 対象とするカラムを配列で指定
		 * $join_table 結合対象テーブルがあれば、対象テーブル
		 * =========================================== */

		if (!trim($keyword)) {
			return "";
		}

		//都道府県と市区町村が連続していたら分割する処理
		$keyword = Sql_class::prefecture_division($keyword);


//キーワード分割
		$keyword = mb_convert_kana($keyword, "s", "EUC-JP");
		$key_arr = split(" ", $keyword);
		$key_arr = (array_filter($key_arr));
//スペース削除キーワード

		if ($key_arr[0] != "") {

			foreach ($key_arr as $key => $value) {

				$value = ereg_replace("'", "&#039;", $value);
				$value = ereg_replace("&", "&amp;", $value);
				$value = ereg_replace("\"", "&quot;", $value);
				$value = mysql_escape_string($value);



				$value2 = mb_convert_kana($value, 'KV', "EUC-JP");
//columnの配列を指定
				$sql_tmp = "";

				foreach ($array_column as $key => $column) {
					if (is_array($join_table)) {
						$join = $join_table[$key] . ".";
					} elseif ($join_table) {//結合する場合
						$join = $join_table . ".";
					}
					if ($special_search) {
						$sql_tmp .= Sql_class::special_search($column, $value2, $join);
					} else {
						//数字の全角/半角のゆれも吸収できる。
						$sql_tmp .= "convert(" . $join . $column . " using utf8) collate utf8_bin like '%" . $value2 . "%' or ";
					}
				}

				$sql_tmp = trim($sql_tmp, " or ");

				$sql_key .= " and (" . $sql_tmp . ") ";
			}
		}

		return $sql_key;
	}

	function special_search($column, $value2, $join) {//特別な検索条件
		if (strpos($column, "area1") !== false) {//都道府県なら番号を都道府県に変換
			$sql_tmp .= Sql_class::keyword_to_db_search($GLOBALS["PREFECTURE_DEFAULT"], $value2, array($join . $column));
		} elseif (strpos($column, "sex") !== false) {//性別なら
			$sql_tmp .= Sql_class::keyword_to_db_search($GLOBALS["sex"], $value2, array($join . $column));
		} elseif (strpos($column, "gakureki2") !== false) {//なら
			$sql_tmp .= Sql_class::keyword_to_db_search($GLOBALS["gakureki2"], $value2, array($join . $column));
		} elseif (strpos($column, "gakureki1") !== false) {//なら
			$sql_tmp .= Sql_class::keyword_to_db_search($GLOBALS["gakureki1"], $value2, array($join . $column));
		} elseif (strpos($column, "shugyo_now") !== false) {//なら
			$sql_tmp .= Sql_class::keyword_to_db_search($GLOBALS["shugyo_now"], $value2, array($join . $column));
		} elseif (strpos($column, "koyou1") !== false) {//なら
			$sql_tmp .= Sql_class::keyword_to_db_search($GLOBALS["koyou"], $value2, array($join . $column));
		} elseif (strpos($column, "koyou2") !== false) {//なら
			$sql_tmp .= Sql_class::keyword_to_db_search($GLOBALS["koyou"], $value2, array($join . $column));
		} elseif (strpos($column, "shokushu1_1") !== false) {//なら
			$sql_tmp .= Sql_class::keyword_to_db_search($GLOBALS["shokushu1"], $value2, array($join . $column));
		} elseif (strpos($column, "shokushu2_1") !== false) {//なら
			$sql_tmp .= Sql_class::keyword_to_db_search($GLOBALS["shokushu1"], $value2, array($join . $column));
		} elseif (strpos($column, "shokushu3_1") !== false) {//なら
			$sql_tmp .= Sql_class::keyword_to_db_search($GLOBALS["shokushu1"], $value2, array($join . $column));
		} elseif (strpos($column, "shokushu1_2") !== false) {//なら
			$sql_tmp .= Sql_class::keyword_to_db_search_shokushu2($GLOBALS["shokushu2"], $value2, array($join . $column));
		} elseif (strpos($column, "shokushu2_2") !== false) {//なら
			$sql_tmp .= Sql_class::keyword_to_db_search_shokushu2($GLOBALS["shokushu2"], $value2, array($join . $column));
		} elseif (strpos($column, "shokushu3_2") !== false) {//なら
			$sql_tmp .= Sql_class::keyword_to_db_search_shokushu2($GLOBALS["shokushu2"], $value2, array($join . $column));
		} elseif (strpos($column, "joujou") !== false) {//なら
			$sql_tmp .= Sql_class::keyword_to_db_search($GLOBALS["joujou"], $value2, array($join . $column));
		} elseif (strpos($column, "shihon") !== false) {//なら
			$sql_tmp .= Sql_class::keyword_to_db_search($GLOBALS["shihon"], $value2, array($join . $column));
		} elseif (strpos($column, "english_eiken") !== false) {//なら
			$sql_tmp .= Sql_class::keyword_to_db_search($GLOBALS["EIKEN"], $value2, array($join . $column));
		} elseif (strpos($column, "birthday") !== false && strpos($value2, "歳") !== false) {//年齢なら
			$year = str_replace("歳", "", $value2);

			$years1 = Text_class::yearsold_to_birthday_low($year);
			$years2 = Text_class::yearsold_to_birthday_high($year);
			$sql_tmp .= ltrim(Sql_class::range("birthday", $years1, $years2, $join), " and ") . " or ";
//		$sql_tmp = rtrim($sql_tmp, " or ").")";
		} else {
//		$sql_tmp .= $join . $column . " like '%" . $value2 . "%' or ";
			//数字の全角/半角のゆれも吸収できる。
			$sql_tmp .= "convert(" . $join . $column . " using utf8) collate utf8_bin like '%" . $value2 . "%' or ";
		}
		return $sql_tmp;
	}

	function pluralsearch_array($array, $column, $number = false, $join_table = false) {
		/* =============================================================
		 * 複数選択時のSQL文
		 * $array 選択したチェックボックス等の配列
		 * $column 対象カラム
		 * $number 検索対象が数字ならtrueに
		 * $join_table 結合するテーブルがある場合、結合対象のテーブル
		 * ============================================================= */

		if ($join_table) {//結合する場合
			$join = $join_table . ".";
		}
		if ($array[0] != "") {
			foreach ($array as $key => $value) {
				if ($number) {//数字なら
					$sql_tmp .= $join . $column . " = " . $value . " or ";
				} else {
					$sql_tmp .= $join . $column . " = '" . $value . "' or ";
				}
			}
			$sql_tmp = rtrim($sql_tmp, " or ");
			$sql_key .= "and (" . $sql_tmp . ") ";
		}
		return $sql_key;
	}

	function search( $column,$palam, $number = false, $join_table = false) {
		/* =============================================
		 * $palam 検索語句（1または0など、all指定で全て
		 * $column 対象カラム
		 * $number 検索が数字で、クォートが不要ならtrue
		 * $join_table 結合するなら結合テーブル（結合しないなら空欄 "" を引数に）
		 * =========================================== */

		if ($join_table) {//結合する場合
			$join = $join_table . ".";
		}
		if (!$palam && $palam != "0") {//空かfalseなら
			return "";
		} elseif ($palam == "all") {//全てならSQLなし
			return "";
		} else {
			if ($number && is_numeric($palam)) {//数字なら
				return " and " . $join . $column . " = " . $palam;
			} else {
				return " and " . $join . $column . " = '" . $palam . "'";
			}
		}
	}

	function search_not($column, $palam, $number = false, $join_table = false) {
		/* =============================================
		 * $palam 検索語句（1または0など、all指定で全て #space なら空白以外
		 * $column 対象カラム
		 * $number 検索が数字で、クォートが不要ならtrue
		 * $join_table 結合するなら結合テーブル（結合しないなら空欄 "" を引数に）
		 * =========================================== */

		if ($join_table) {//結合する場合
			$join = $join_table . ".";
		}
		if (!$palam && $palam != "0") {
			return "";
		}
		if ($palam == "all" || !trim($palam)) {//全てならSQLなし
			return "";
		} else {
			if($palam == "#space"){$palam = "";}
			if ($number && (is_numeric($palam) || $palam == "NULL")) {//数字またはNULLなら
				return " and " . $join . $column . " <> " . $palam;
			} else {
				return " and " . $join . $column . " <> '" . $palam . "'";
			}
		}
	}
	function search_isnot($column, $palam, $number = false, $join_table = false) {
		/* =============================================
		 * $palam 検索語句（1または0など、all指定で全て #spaceは使えない
		 * $column 対象カラム
		 * $number 検索が数字で、クォートが不要ならtrue
		 * $join_table 結合するなら結合テーブル（結合しないなら空欄 "" を引数に）
		 * =========================================== */

		if ($join_table) {//結合する場合
			$join = $join_table . ".";
		}
		if (!$palam && $palam != "0") {
			return "";
		}
		if ($palam == "all" || !trim($palam)) {//全てならSQLなし
			return "";
		} else {

			if ($number && (is_numeric($palam) || $palam == "NULL")) {//数字またはNULLなら
				return " and " . $join . $column . " is not " . $palam;
			} else {
				return " and " . $join . $column . " is not '" . $palam . "'";
			}
		}
	}

	function search_array($column, $palam_array, $number = false, $join_table = false) {
		/* =============================================
		 * IN句使用
		 * $palam_array 検索語句を配列で（1または0など、all指定で全て
		 * $column 対象カラム
		 * $number 検索が数字で、クォートが不要ならtrue
		 * $join_table 結合するなら結合テーブル（結合しないなら空欄 "" を引数に）
		 * =========================================== */
		if ($join_table) {//結合する場合
			$join = $join_table . ".";
		}
		if (is_array($palam_array) !== false) {
			foreach ($palam_array as $value) {
				if ($number && is_numeric($value)) {//数字なら
					$in_word .= $value . ",";
				} else {
					$in_word .= "'" . $value . "',";
				}
			}
		}
		$in_word = trim($in_word, ",");
		if (!$palam_array && $palam_array != "0") {
			return "";
		}
		if ($palam_array == "all" || is_array($palam_array) === false) {//全てならSQLなし
			return "";
		} else {
			return " and " . $join . $column . " IN (" . $in_word . ")";
		}
	}

	function search_array_column($column_array, $palam, $number = false, $join_table = false) {
		/* =============================================
		 * $palam_array 検索語句
		 * $column 対象カラムを配列で
		 * $number 検索が数字で、クォートが不要ならtrue
		 * $join_table 結合するなら結合テーブル（結合しないなら空欄 "" を引数に）
		 * =========================================== */
		if ($palam || $param == "0") {
			if ($join_table) {//結合する場合
				$join = $join_table . ".";
			}

			$sql = " and (";
			if ($number && is_numeric($palam)) {//数字なら
				$in_word .= $palam . "";
			} else {
				$in_word .= "'" . $palam . "'";
			}
			if (is_array($column_array) !== false) {
				foreach ($column_array as $value) {
					$sql .= $value . " = " . $in_word . " or ";
				}
			}
			$sql = rtrim($sql, " or ");
			$sql .= ")";
		} else {
			$sql = "";
		}
		return $sql;
	}

	function range($column, $lowkey, $highkey, $number = false, $join_table = false) {
		/* ========================================================
		 * 検索条件を範囲で指定する関数
		 * $columun 検索対象カラム
		 * $lowkey 下の数値や日付
		 * $highkey 上の数値や日付
		 * ====================================================== */
		if ($join_table) {//結合する場合
			$join = $join_table . ".";
		}
		if ($number) {//数字なら
			$high .= $highkey;
			$low .= $lowkey;
		} else {
			$high .= "'" . $highkey . "'";
			$low .= "'" . $lowkey . "'";
		}
		$sql = "";
		if ($lowkey && $highkey) {//両方あればbetween
			$sql .= " and " . $join . $column . " between " . $low . " and " . $high;
		} else {
			if (trim($highkey) || $highkey == "0") {
				$sql .= " and " . $join . $column . " <= " . $high;
			}
			if (trim($lowkey) || $lowkey == "0") {
				$sql .= " and " . $join . $column . " >= " . $low;
			}
		}

		return $sql;
	}

	function create_sql($sql_basic, $sql_add, $sql_order_limit = "") {
		/* =============================================
		 * $sql_basic 基本となるSQL文（where limit を含まない
		 * $sql_add　追加SQL （where部分)and も含む文字で可
		 * $sql_limit limitのSQL文
		 * 戻り値 変換して完成したSQL文
		 * =========================================== */
		if ($sql_add) {
			return $sql_basic . " where " . preg_replace("/^ and /", "", $sql_add) . $sql_order_limit;
		} else {
			return $sql_basic . $sql_order_limit;
		}
	}

	function or_join($joken_array) {
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
			return $sql;
		} else {
			return "";
		}
	}

	function and_join($joken_array) {
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
			return $sql;
		} else {
			return "";
		}
	}

	function autochoose_insert_update($table_name, $column_array,$param_array ,$search_column,$search_param) {
		//データが存在するかどうかでinsert とupdateを使い分ける
		$sql_basic = Sql_class::select_basic($table_name,"no");
		$sql_add = Sql_class::search($search_param, $search_column);
		$sql = Sql_class::create_sql($sql_basic, $sql_add);
		$res = Sql_class::query_or_die($sql);
		$count = mysql_num_rows($res);
		if($count){//存在すればupdate
			$sql_basic2 = Sql_class::update($table_name, $column_array, $param_array);
			$sql2 = Sql_class::create_sql($sql_basic2, $sql_add);

		}else{//見つからなければinesrt
			array_push($column_array, $search_column);
			array_push($param_array, $search_param);
			$sql2 = Sql_class::insert($table_name, $column_array, $param_array);

		}

		return $sql2;

	}

	function insert($table_name, $column_array,$param_array ) {
		$sql = "insert into " . $table_name . " (";
		if (is_array($column_array)) {
			foreach ($column_array as $key => $value) {
				$column_value .= "`" . $value . "`,";
			}
			$column_value = rtrim($column_value, ",") . ")";
		}
		if (is_array($param_array)) {
			foreach ($param_array as $key2 => $value2) {
				if (is_numeric($value2)) {
					$param_value .= $value2 . ",";
				} else {
					$param_value .= "'" . $value2 . "',";
				}
			}
			$param_value = rtrim($param_value, ",") . ")";
		}
		$sql .= $column_value . " values(" . $param_value;
		return $sql;
	}

	function update($table_name, $column_array, $param_array) {
		$sql = "update " . $table_name . " set ";
		if (is_array($column_array)) {
			foreach ($column_array as $key => $value) {

					$sql .= "`" . $value . "` = '" . $param_array[$key] . "',";

			}
			$sql = rtrim($sql, ",");
		}


		return $sql;
	}

	function join_table($main_table, $join_table, $main_column, $join_column, $join_type = "inner") {
		/* =============================================
		 * テーブル結合用関数
		 * $main_table メインのテーブル名
		 * $join_table 結合するテーブル名
		 * $main_column メインテーブルの結合対象カラム
		 * $join_column 結合するテーブルの結合対象カラム
		 * =========================================== */
		$join_sql = " " . $join_type . " join " . $join_table . " on " . $main_table . "." . $main_column . " = " . $join_table . "." . $join_column;
		return $join_sql;
	}

	function sort($column, $sort, $join_table = false) {
		/* ========================================================
		 * sqlのソート文作成関数
		 * $column ソートするカラム名
		 * $sort desc or asc
		 * $join_table 結合している場合は、ソート対象とするテーブル名
		 * ====================================================== */
		if ($join_table) {//結合する場合
			$join = $join_table . ".";
		}
		return " order by " . $join . $column . " " . $sort;
	}

	function upload_img_and_make_sql($name, $id, $shop, $session_key) {
		/* ========================================================
		 * $name　アップロードする画像のレコード名
		 * $id ユーザーまたはショップのno
		 * $shop アップロードするディレクトリ （shopならtrue,ユーザーならfalse）
		 * 戻り値　エラーならfalse
		 * 成功なら　update用のSQL文（変更がなければ空(falseではない）を返すので注意）
		 * ====================================================== */
		$tmp_file = $name . "_tmp_file";
		$delete = $name . "_delete";
		$img_db = $name . "_db_out";

		if (!$_SESSION[$session_key][$delete]) {
			$return0 = Img::img_upload(ROOT_PATH_DOG . $_SESSION[$session_key][$tmp_file], $id, $shop); //引数
		} else {
			$return0 = "";
		}
		if ($_SESSION[$session_key][$delete]) {

			Img::delete_img($_SESSION[$session_key][$img_db]);
			$img_db = $name . " = '', ";
		} elseif ($return0) {
			$img_db = $name . " = '$return0', ";
		} else {
			$img_db = "";
		}

		if ($return0 === false) {
			return false;
		} else {
			return $img_db;
		}
	}

	function upload_img_and_make_sql_insert($name, $id, $shop, $session_key) {
		/* ========================================================
		 * $name　アップロードする画像のレコード名
		 * $id ユーザーまたはショップのno
		 * $shop アップロードするディレクトリ （shopならtrue,ユーザーならfalse）
		 * 戻り値　エラーならfalse
		 * 成功なら　insert用のSQLの変数
		 * ====================================================== */
		$tmp_file = $name . "_tmp_file";
		$delete = $name . "_delete";
		$img_db = $name . "_db_out";

		if (!$_SESSION[$session_key][$delete]) {
			$return0 = Img::img_upload(ROOT_PATH_DOG . $_SESSION[$session_key][$tmp_file], $id, $shop); //引数
		} else {
			$return0 = "";
		}
		if ($_SESSION[$session_key][$delete]) {

			Img::delete_img($_SESSION[$session_key][$img_db]);
		}

		if ($return0 === false) {
			return false;
		} else {
			return $return0;
		}
	}

	function keyword_to_db_search($global_array, $keyword, $table_array) {
		$keyword = strtoupper(mb_convert_kana($keyword, "askh", "euc-jp"));
		//$table_array 配列でテーブルを指定、指定テーブルはand検索とする
		foreach ($global_array as $key => $value) {
			$value = strtoupper(mb_convert_kana($value, "askh", "euc-jp"));
			if (strpos($value, $keyword) !== false) {//見つかれば
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
			return $sql;
		}
	}

	function keyword_to_db_search_shokushu2($global_array, $keyword, $table_array) {
		$keyword = strtoupper(mb_convert_kana($keyword, "askh", "euc-jp"));

		//配列でテーブルを指定、指定テーブルはand検索とする
		foreach ($global_array as $key => $value_array) {
			foreach ($value_array as $key2 => $value2) {
				$value2 = strtoupper(mb_convert_kana($value2, "askh", "euc-jp"));
				if (strpos($value2, $keyword) !== false) {//見つかれば
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
			return $sql;
		}
	}

	function limit_sql($limit = 0, $search_rows = 10) {
		if (is_numeric($limit) === true) {
			return " limit " . $limit . ", " . $search_rows;
		} else {
			return " limit 0, " . $search_rows;
		}
	}

	function prefecture_division($keyword) {

		foreach ($GLOBALS["PREFECTURE_DEFAULT"] as $key => $value) {
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

}