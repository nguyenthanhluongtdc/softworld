<?php

//2013/06/28 エラーを格納する変数名を変更可能に(result_to_function)
//フォームからの入力値チェッククラス
//オブジェクトで処理をする
//$_POSTチェック用 または配列を指定する(インスタンス化の引数で指定）
class input_check_class2
{

	var $postvalue;
	var $return;//エラーを直接格納する場合は、これに入れる

	function __construct($array = false)
	{
		if (!$array) {
			$array = $_POST;
		}
		if (is_array($array)) {
			foreach ($array as $key => $value) {
				if (!is_array($value)) {
					$this->postvalue[$key] = Text_class::trim_zen_space($value);
				} else {
					foreach ($value as $key2 => $value2) {
						$this->postvalue[$key][$key2] = Text_class::trim_zen_space($value2);
					}
				}
			}
		}
	}

	function return_value()
	{
		//		var_dump($this->return);
		if (is_array($this->return)) {
			foreach ($this->return as $key => $value) {
				if ($value === true) {
					unset($this->return[$key]);
				}
			}

			if (is_array($this->return)) {
				return $this->return;
			} else {
				return true;
			}
		} else { //チェック項目がない場合
			return false;
		}
	}

	function result_to_function($obj , $func = false,$error = 'error')
	{
        //
		//        エラーの場合、指定の関数を実行する
		//        $objはエラーチェックのオブジェクトではなく、処理をしているメインのオブジェクト
        //          $error はエラーを格納する変数名を変更する場合、通常は変更なし　例：error2　など

		if (is_object($obj) && $func) {
			$obj->$error = $this->return_value();

			if (!$obj->$error == false) {
				if ($func) {

					$obj->$func();
					return false;
				} else {
					return $obj->error;
				}
			} else {
				return true;
			}
		}
	}

	function multi_error_merge($array_error_key , $new_error_key,$hissu = false)
	{
		/* ========================================================
		 * 複数のエラー項目を一つにまとめて別なキーのエラーにする関数
		 * $hissu falseじゃない場合、どれか一つでも入力あれば、他も必須にする（$hissuはエラーを返す項目名）
		 * ======================================================*/
        $hissu_check = false;
        $kara = false;


		if (is_array($array_error_key)) {
			foreach ($array_error_key as $key => $value) {
                if($hissu && $this->postvalue[$value]){
                    $hissu_check = true;
                }
                //空チェック
                if(!$this->postvalue[$value]){
                    $kara = true;
                }

				if ($this->return[$value] !== true && $this->return[$value] != "") {

					$this->return[$new_error_key] = $this->return[$value];
					break;
				}
			}

            if($hissu_check && $kara && !$this->return[$new_error_key]){
                unset($this->postvalue[$new_error_key]);
                $this->input_check($new_error_key, $hissu, "全て入力", false, false);
            }
		}
	}

	function input_check($postkey , $name , $hissu = false , $strlen_check = false , $value_type = false , $dup = false)
	{
		/* ========================================================
		 * 入力チェッククラス
		 * $key チェックするポストのキー（配列の場合もあり）※配列の場合は、全ての値が条件をクリアしないとエラー（andテスト）
		 * $name エラーで返す項目名
		 * ※特殊処理　$nameに@@@ が含まれていれば、エラーメッセージは$nameから@@@を除いたものにする
		 * $hissu 必須入力項目とする場合はtrue （0の場合はOKにする）
		 * $hissu がtrueでもfalseでもない場合、「選択」などの文字に変更する
		 * $strlen_check 入力値の長さをチェックする（形式 ：10,15　）（0,15）（mb0,300）
		 * ※mbを入れるとチェックをmb_strlenで行う、下限や上限が0ならチェックを行わない
		 * $value_type ↓値によって入力値のタイプを選択↓複数指定可能
		 * err または error 無条件でエラーとする
		 * n 半角数字
		 * i_n is_numeric（マイナスを許可）
		 * n,0,5 半角数字 指定の範囲内で入力　0 =< n =<5
		 * N 全角数字
		 * a 半角英字
		 * A 全角英字
		 * na 半角英数字
		 * n- 半角数字とハイフン
		 * na- 半角英数字とハイフン
		 * k 半角カタカナ
		 * K 全角カタカナ
		 * s スペースを許可する（併用可）
		 * () カッコを許可する（併用可）
		 * t 電話番号
		 * u URL
		 * m メールアドレス
		 * $dup ～ DBの重複チェック
		 * table_name:column_name:許可する番号(テーブルのカラム名[no]のみで指定可能）
		 *
		 * $dupが配列なら
		 * 例：tablenameにある code の値が、parent_no = 1 で重複していないかを調べる、その時に、no = 3は対象外とする場合
         * $dup_array = array("tablename","code","parent_no","1","3");

		 * 返り値 エラーが無ければtrueを返す
		 * ====================================================== */


		if (is_array($this->postvalue[$postkey])) { //配列なら
			foreach ($this->postvalue[$postkey] as $key => $val) {

				self::check_func($postkey , $val , $name , $hissu , $strlen_check , $value_type , $dup);
				if ($this->return[$postkey] !== true) {
					break;
				}
			}
		} else { //値なら

			self::check_func($postkey , $this->postvalue[$postkey] , $name , $hissu , $strlen_check , $value_type , $dup);
		}
	}

	function check_func($postkey , $value , $name , $hissu , $strlen_check , $value_type , $dup)
	{


		if ($hissu === true || $hissu === false) {
			$text = "入力";
		} else {
			$text = $hissu;
		}

        if (isset($this->return[$postkey]) && $this->return[$postkey] !== true ) {
            //既に最初からエラーの値を持っていれば、上書きせずに処理終了（trueはエラーではないので除外）
            return;
        }

		if ($hissu) { //必須チェック
			$this->return[$postkey] = self::hissu($value , $name , $text);
			if ($this->return[$postkey] !== true) {
				return;
			}
		}

		if ($strlen_check) { //文字数チェック
			$this->return[$postkey] = self::strlen_check($value , $name , $strlen_check , $text);
			if ($this->return[$postkey] !== true) {
				return;
			}
		}

		if ($value_type) {
			$this->return[$postkey] = self::value_type_check($value , $name , $value_type , $text);

			if ($this->return[$postkey] !== true) {
				return;
			}
		}
        if (is_array($dup) !== false) {
            $this->return[$postkey] = self::db_duplicate_check_array($name , $dup , $value);
            if ($this->return[$postkey] !== true) {
                return;
            }
            }elseif ($dup) {
                $this->return[$postkey] = self::db_duplicate_check($name , $dup , $value);
                if ($this->return[$postkey] !== true) {
                    return;
                }
		}
		return true;
	}

	function hissu($value , $name , $text)
	{ //必須チェック
		if (!$value && $value != "0") {
            if(strpos($name,"@@@") !== false){
                return str_replace("@@@","",$name);

            } else{
			return $name . "を" . $text . "して下さい。";
            }
		} else {
			return true;
		}
	}

	function strlen_check($value , $name , $strlen_check , $text = "入力")
	{ //文字数チェック
		if (strpos($strlen_check , "mb") !== false) { //mbでチェック
			$strlen_check = str_replace("mb" , "" , $strlen_check);
			$type = "";
            $encoding = "utf-8";
            $strlen = mb_strlen($value,$encoding);
		} else {
			$type = "半角";
            $strlen = strlen($value);
		}
		list($short , $long) = explode("," , $strlen_check);



		if ($short && $value) { //最短チェック(データがあればチェック)
            if($short == $long && $strlen < $short){//最短と最長が同じなら
                $error1 = $type . $short . "文字";
            }elseif ($strlen < $short) {
				$error1 = $type . $short . "文字以上";
			}
		}

		if ($long) { //最長チェック
            if($short == $long && $strlen > $long){//最短と最長が同じなら
                $error2 = $type . $long . "文字";
            }elseif ($strlen > $long) {
				$error2 = $type . $long . "文字以下";
			}
		}
		if ($error1 || $error2) {
            if(strpos($name,"@@@") !== false){
                return str_replace("@@@","",$name);

            } else{

			return $name . "は" . $error1 . $error2 . "で" . $text . "して下さい。";
            }
		} else {
			return true;
		}
	}

	function value_type_check($value , $name , $value_type , $text = "入力")
	{ //入力文字の種類チェック

        if (strstr($value_type , "s") !== false) {
            //スペースを許可
$s = "\s";
            $space_error = "かスペース";
        }
        if (strstr($value_type , "()") !== false) {
            //かっこを許可
$s .= "\(\)（）";
            $space_error .= "かカッコ";
        }


		if ($value || $value == "0") {
            if (strpos($value_type , "i_n") !== false) { //数値（is_numeric）
                if (is_numeric($value) === false) {
                    $error = "は半角数字".$space_error."で";
                }
            } elseif (strpos($value_type , "na-") !== false) { //半角英数字とハイフンがOK
                if (!preg_match("/^[a-zA-Z0-9\-".$s."]+$/" , $value)) {
                    $error = "は半角英数字かハイフン".$space_error."で";
                }
            } elseif (strpos($value_type , "n-") !== false) { //半角数字とハイフンがOK
                if (!preg_match("/^[0-9\-".$s."]+$/" , $value)) {
                    $error = "は半角数字かハイフン".$space_error."で";
                }
            } elseif (strpos($value_type , "na") !== false) { //半角英数字がOK
                if (!preg_match("/^[a-zA-Z0-9".$s."]+$/" , $value)) {
                    $error = "は半角英数字".$space_error."で";
                }
            } else {
				if (strstr($value_type , "n") !== false) { //半角数字がOK
					if (!preg_match("/^[0-9".$s."]+$/" , $value)) {
						$error = "は半角数字".$space_error."で";
					}elseif (strstr($value_type , "n,") !== false) { ////数字の上下指定があれば
                    list($type,$low,$high) = explode(",",$value_type);
                        if(intval($low) > $value ||intval($high) < $value){
                            $error = "を正しく";
                        }
                    }
				}
				if (strstr($value_type , "a") !== false) { //半角英字がOK
					if (!preg_match("/^[a-zA-Z".$s."]+$/" , $value)) {
						$error = "は半角英字".$space_error."で";
					}
				}
			}

			//その他チェック

			if (strstr($value_type , "N") !== false) { //全角数字がOK
				if (!preg_match("/^[０-９".$s."]+$/" , $value)) {
					$error = "は全角数字".$space_error."で";
				}
			}
			if (strstr($value_type , "A") !== false) { //全角英字がOK
				if (!preg_match("/^[ａ-ｚＡ-Ｚ".$s."]+$/" , $value)) {
					$error = "は全角英字".$space_error."で";
				}
			}
			if (strstr($value_type , "k") !== false) { //半角カタカナがOK
                mb_regex_encoding('UTF-8'); // UTF8の例
//				mb_regex_encoding("eucjp-win"); // EUCの例
				if (mb_ereg("^[ｱ-ﾝﾞﾟｧ-ｫｬ-ｮｰ｡｢｣､".$s."]+$" , $value) === false) {
					$error = "は半角カタカナ".$space_error."で";
				}
			}
			if (strstr($value_type , "K") !== false) { //全角カタカナがOK
                mb_regex_encoding('UTF-8'); // UTF8の例
//				mb_regex_encoding("eucjp-win"); // EUCの例
				if (mb_ereg("^[ア-ン゛゜ァ-ォャ-ョー「」、。".$s."]+$" , $value) === false) {
					$error = "は全角カタカナ".$space_error."で";
				}
			}
			if (strstr($value_type , "m") !== false) { //メールアドレスがOK
                mb_regex_encoding('UTF-8'); // UTF8の例
//				mb_regex_encoding("eucjp-win"); // EUCの例
				$pattern = '/^(?:(?:(?:(?:[a-zA-Z0-9\._!#\$\%&\'*+\/=?\^`{}~|\-]+)(?:(?:[a-zA-Z0-9_!#\$\%&\'*+\/=?\^`{}~|\-]+))*)|(?:"(?:\\[^\r\n]|[^\\"])*")))\@(?:(?:(?:(?:[a-zA-Z0-9_!#\$\%&\'*+\/=?\^`{}~|\-]+)(?:\.(?:[a-zA-Z0-9_!#\$\%&\'*+\/=?\^`{}~|\-]+))*)|(?:\[(?:\\\S|[\x21-\x5a\x5e-\x7e])*\])))$/';
				if (!preg_match($pattern , $value)) {
					$error = "を正しい形式で";
				}
			}
			if (strstr($value_type , "t") !== false) { //電話番号がOK
				if (strpos($value , "-") === false) {
					if (!preg_match("/(^(?<!090|080|070)\d{10}$)|(^(090|080|070)\d{8}$)|(^0120\d{6}$)|(^0080\d{7}$)/" , $value)) {
						$error = "を正しく";
					}
				} else {
					if (!preg_match("/(^(?<!090|080|070)(^\d{2,5}?\-\d{1,4}?\-\d{4}$|^[\d\-]{12}$))|(^(090|080|070)(\-\d{4}\-\d{4}|[\\d-]{13})$)|(^0120(\-\d{2,3}\-\d{3,4}|[\d\-]{12})$)|(^0080\-\d{3}\-\d{4})/" , $value)) {
						$error = "を正しく";
					}
				}
			}
			if (strstr($value_type , "u") !== false) { //URL
				if (!preg_match('/^(https?|ftp)(:\/\/[-_.!~*\'()a-zA-Z0-9;\/?:\@&=+\$,%#]+)$/' , $value)) {
					$error = "を正しい形式で";
				}
			}


		}

        if (strpos($value_type , "err") !== false || strpos($value_type , "error") !== false) { //無条件でエラーにする
                $error = "を正しく";//文言はほぼ意味なし、
        }

		if ($error) {
            if(strpos($name,"@@@") !== false){
			return str_replace("@@@","",$name);

            } else{
			return $name . $error . "" . $text . "して下さい。";

            }
		} else {
			return true;
		}
	}

	function db_duplicate_check($name , $dup , $value)
	{
		//DBの重複チェック
		//$dup = table_name:column_name:許可する番号


		if ($dup) {
			$dup_type_array = explode(":" , $dup);
			$db = new Sql_class3;
			$db->select($dup_type_array[0]);
			$db->search($dup_type_array[1] , $value , false);
			$db->search_not("no" , $dup_type_array[2] , false);
			$db->sql_query(true);
//						$db->view();
			$db->count();

			if ($db->count) {
                if(strpos($name,"@@@") !== false){
                    return str_replace("@@@","",$name);

                } else{
				return $name . "の値はすでに使用されています。別な値を入力して下さい。";
                }
			} else {
				return true;
			}
		}
	}
    function db_duplicate_check_array($name , $dup_array , $value)
	{
		//DBの重複チェック（配列利用、重複を調べる対象を指定できる）
		//$dup_array = array("tablename","重複を調べるカラム","調べる範囲を指定するカラム","調べる範囲を指定する検索値","許可する番号（noのみ対象）");
        //例：tablenameにある code の値が、parent_no = 1 で重複していないかを調べる、その時に、no = 3は対象外とする場合
        //$dup_array = array("tablename","code","parent_no","1","3");

		if (is_array($dup_array)) {
			$db = new Sql_class3;
			$db->select($dup_array[0]);
			$db->search($dup_array[1] , $value , false);
            $db->search($dup_array[2],$dup_array[3],false);
			$db->search_not("no" , $dup_array[4] , false);
			$db->sql_query(true);
//						$db->view();
			$db->count();

			if ($db->count) {
				return $name . "の値はすでに使用されています。別な値を入力して下さい。";
			} else {
				return true;
			}

		}
	}

	function image_error($imgpath , $postkey , $name , $session_key , $hissu = false)
	{

		$tmp_key = $postkey . "_tmp_file";
		$db_key = $postkey . "_db_out";
		$delete_key = $postkey . "_delete";


		if ($hissu && (($imgpath === true && !$_SESSION[$session_key][$tmp_key] && !$_SESSION[$session_key][$db_key]) || $_SESSION[$session_key][$delete_key])) { //空か削除指定で、必須なら
			$this->return[$postkey] = $name . "を指定して下さい。";
			return;
		}
		if ($imgpath !== true) {
			if ($imgpath == "filetype error") {
				$this->return[$postkey] = $name . "で指定されたファイルはアップロードできない形式のファイルです。";
				return;
			}
			if ($imgpath[0] == "filesize error") {
				$this->return[$postkey] = $name . "画像のサイズは" . $error_int[1] . "KBまでにして下さい。";
				return;
			}
			if ($imgpath == "cmyk error") {
				$this->return[$postkey] = $name . "はCMYK画像ですのでアップロードすることができません。RGB画像に変換してからご使用下さい。";
				return;
			}
		}
	}

}

?>