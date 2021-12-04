<?php

//フォームからの入力値チェッククラス
class input_check_class {

	function input_check($value, $name, $hissu = false, $strlen_check = false, $value_type = false) {
		/* ========================================================
		 * 入力チェッククラス
		 * $value チェックする値（配列の場合もあり）※配列の場合は、全ての値が条件をクリアしないとエラー（andテスト）
		 * $name エラーで返す項目名
		 * $hissu 必須入力項目とする場合はtrue （0の場合はOKにする）
		 * $hissu がtrueでもfalseでもない場合、「選択」などの文字に変更する
		 * $strlen_check 入力値の長さをチェックする（形式 ：10,15　）（0,15）（mb0,300）
		 * ※mbを入れるとチェックをmb_strlenで行う、下限や上限が0ならチェックを行わない
		 * $value_type ↓値によって入力値のタイプを選択↓複数指定可能
		 * n 半角数字
		 * N 全角数字
		 * a 半角英字
		 * A 全角英字
		 * na 半角英数字
		 * na- 半角英数字とハイフン
		 * k 半角カタカナ
		 * K 全角カタカナ
		 * t 電話番号
		 * u URL
		 * m メールアドレス
		 *
		 * ====================================================== */

		if (is_array($value)) {//配列なら
			foreach ($value as $key => $val) {
				$return = input_check_class::check_func($val, $name, $hissu, $strlen_check, $value_type);
				if ($return !== true) {
					break;
				}
			}
		} else {//値なら
			$return = input_check_class::check_func($value, $name, $hissu, $strlen_check, $value_type);
		}

		if ($return !== true) {
			return $return;
		} else {
			
		}
	}

	function check_func($value, $name, $hissu, $strlen_check, $value_type) {


		if ($hissu === true || $hissu === false) {
			$text = "入力";
		} else {
			$text = $hissu;
		}

		if ($hissu) {//必須チェック
			$return = input_check_class::hissu($value, $name, $text);
			if ($return !== true) {
				return $return;
			}
		}

		if ($strlen_check) {//文字数チェック
			$return = input_check_class::strlen_check($value, $name, $strlen_check, $text);
			if ($return !== true) {
				return $return;
			}
		}

		if ($value_type) {
			$return = input_check_class::value_type_check($value, $name, $value_type, $text);
			if ($return !== true) {
				return $return;
			}
		}
		return true;
	}

	function hissu($value, $name, $text) {//必須チェック
		if (!$value && $value != "0") {
			return $name . "を" . $text . "して下さい。";
		} else {
			return true;
		}
	}

	function strlen_check($value, $name, $strlen_check, $text = "入力") {//文字数チェック
		if (strpos($strlen_check, "mb") !== false) {//mbでチェック
			$strlen_check = str_replace("mb", "", $strlen_check);
			$strlen = "mb_strlen";
			$type = "";
		} else {
			$strlen = "strlen";
			$type = "半角";
		}
		list($short, $long) = explode(",", $strlen_check);
		if ($short) {//最短チェック
			if ($strlen($value) < $short) {
				$error1 = $type . $short . "文字以上";
			}
		}
		if ($long) {//最長チェック
			if ($strlen($value) > $long) {
				$error2 = $type . $long . "文字以下";
			}
		}
		if ($error1 || $error2) {
			return $name . "は" . $error1 . $error2 . "で" . $text . "して下さい。";
		} else {
			return true;
		}
	}

	function value_type_check($value, $name, $value_type, $text = "入力") {//入力文字の種類チェック
		if($value || $value == "0"){
		if (strpos($value_type, "na-") !== false) {//半角英数字とハイフンがOK
			if (!preg_match("/^[a-zA-Z0-9\-]+$/", $value)) {
				$error = "は半角英数字かハイフンで";
			}
		} elseif (strpos($value_type, "na") !== false) {//半角英数字がOK
			if (!preg_match("/^[a-zA-Z0-9]+$/", $value)) {
				$error = "は半角英数字で";
			}
		} else {
			if (strstr($value_type, "n") !== false) {//半角数字がOK
				if (!preg_match("/^[0-9]+$/", $value)) {
					$error = "は半角数字で";
				}
			}
			if (strstr($value_type, "a") !== false) {//半角英字がOK
				if (!preg_match("/^[a-zA-Z]+$/", $value)) {
					$error = "は半角英字で";
				}
			}
			if (strstr($value_type, "N") !== false) {//全角数字がOK
				if (!preg_match("/^[０-９]+$/", $value)) {
					$error = "は全角数字で";
				}
			}
			if (strstr($value_type, "A") !== false) {//全角英字がOK
				if (!preg_match("/^[ａ-ｚＡ-Ｚ]+$/", $value)) {
					$error = "は全角英字で";
				}
			}
			if (strstr($value_type, "k") !== false) {//半角カタカナがOK
				mb_regex_encoding("eucjp-win"); // EUCの例
				if (mb_ereg("^[ｱ-ﾝﾞﾟｧ-ｫｬ-ｮｰ｡｢｣､]+$", $value) === false) {
					$error = "は半角カタカナで";
				}
			}
			if (strstr($value_type, "K") !== false) {//全角カタカナがOK
				mb_regex_encoding("eucjp-win"); // EUCの例
				if (mb_ereg("^[ア-ン゛゜ァ-ォャ-ョー「」、。]+$", $value) === false) {
					$error = "は全角カタカナで";
				}
			}
			if (strstr($value_type, "m") !== false) {//メールアドレスがOK
				mb_regex_encoding("eucjp-win"); // EUCの例
				$pattern = '/^(?:(?:(?:(?:[a-zA-Z0-9\._!#\$\%&\'*+\/=?\^`{}~|\-]+)(?:(?:[a-zA-Z0-9_!#\$\%&\'*+\/=?\^`{}~|\-]+))*)|(?:"(?:\\[^\r\n]|[^\\"])*")))\@(?:(?:(?:(?:[a-zA-Z0-9_!#\$\%&\'*+\/=?\^`{}~|\-]+)(?:\.(?:[a-zA-Z0-9_!#\$\%&\'*+\/=?\^`{}~|\-]+))*)|(?:\[(?:\\\S|[\x21-\x5a\x5e-\x7e])*\])))$/';
				if (!preg_match($pattern, $value)) {
					$error = "を正しい形式で";
				}
			}
			if (strstr($value_type, "t") !== false) {//電話番号がOK
				if (strpos($value, "-") === false) {
					if (!preg_match("/(^(?<!090|080|070)\d{10}$)|(^(090|080|070)\d{8}$)|(^0120\d{6}$)|(^0080\d{7}$)/", $value)) {
						$error = "を正しく";
					}
				} else {
					if (!preg_match("/(^(?<!090|080|070)(^\d{2,5}?\-\d{1,4}?\-\d{4}$|^[\d\-]{12}$))|(^(090|080|070)(\-\d{4}\-\d{4}|[\\d-]{13})$)|(^0120(\-\d{2,3}\-\d{3,4}|[\d\-]{12})$)|(^0080\-\d{3}\-\d{4})/", $value)) {
						$error = "を正しく";
					}
				}
			}
		}
	}
		if ($error) {
			return $name . $error . "" . $text . "して下さい。";
		} else {
			return true;
		}
	}

}

?>