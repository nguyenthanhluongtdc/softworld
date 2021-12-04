<?php

//�ե����फ��������ͥ����å����饹
class input_check_class {

	function input_check($value, $name, $hissu = false, $strlen_check = false, $value_type = false) {
		/* ========================================================
		 * ���ϥ����å����饹
		 * $value �����å������͡�����ξ��⤢��ˢ�����ξ��ϡ����Ƥ��ͤ����򥯥ꥢ���ʤ��ȥ��顼��and�ƥ��ȡ�
		 * $name ���顼���֤�����̾
		 * $hissu ɬ�����Ϲ��ܤȤ������true ��0�ξ���OK�ˤ����
		 * $hissu ��true�Ǥ�false�Ǥ�ʤ���硢������פʤɤ�ʸ�����ѹ�����
		 * $strlen_check �����ͤ�Ĺ��������å�����ʷ��� ��10,15���ˡ�0,15�ˡ�mb0,300��
		 * ��mb�������ȥ����å���mb_strlen�ǹԤ������¤��¤�0�ʤ�����å���Ԥ�ʤ�
		 * $value_type ���ͤˤ�ä������ͤΥ����פ�����ʣ�������ǽ
		 * n Ⱦ�ѿ���
		 * N ���ѿ���
		 * a Ⱦ�ѱѻ�
		 * A ���ѱѻ�
		 * na Ⱦ�ѱѿ���
		 * na- Ⱦ�ѱѿ����ȥϥ��ե�
		 * k Ⱦ�ѥ�������
		 * K ���ѥ�������
		 * t �����ֹ�
		 * u URL
		 * m �᡼�륢�ɥ쥹
		 *
		 * ====================================================== */

		if (is_array($value)) {//����ʤ�
			foreach ($value as $key => $val) {
				$return = input_check_class::check_func($val, $name, $hissu, $strlen_check, $value_type);
				if ($return !== true) {
					break;
				}
			}
		} else {//�ͤʤ�
			$return = input_check_class::check_func($value, $name, $hissu, $strlen_check, $value_type);
		}

		if ($return !== true) {
			return $return;
		} else {
			
		}
	}

	function check_func($value, $name, $hissu, $strlen_check, $value_type) {


		if ($hissu === true || $hissu === false) {
			$text = "����";
		} else {
			$text = $hissu;
		}

		if ($hissu) {//ɬ�ܥ����å�
			$return = input_check_class::hissu($value, $name, $text);
			if ($return !== true) {
				return $return;
			}
		}

		if ($strlen_check) {//ʸ���������å�
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

	function hissu($value, $name, $text) {//ɬ�ܥ����å�
		if (!$value && $value != "0") {
			return $name . "��" . $text . "���Ʋ�������";
		} else {
			return true;
		}
	}

	function strlen_check($value, $name, $strlen_check, $text = "����") {//ʸ���������å�
		if (strpos($strlen_check, "mb") !== false) {//mb�ǥ����å�
			$strlen_check = str_replace("mb", "", $strlen_check);
			$strlen = "mb_strlen";
			$type = "";
		} else {
			$strlen = "strlen";
			$type = "Ⱦ��";
		}
		list($short, $long) = explode(",", $strlen_check);
		if ($short) {//��û�����å�
			if ($strlen($value) < $short) {
				$error1 = $type . $short . "ʸ���ʾ�";
			}
		}
		if ($long) {//��Ĺ�����å�
			if ($strlen($value) > $long) {
				$error2 = $type . $long . "ʸ���ʲ�";
			}
		}
		if ($error1 || $error2) {
			return $name . "��" . $error1 . $error2 . "��" . $text . "���Ʋ�������";
		} else {
			return true;
		}
	}

	function value_type_check($value, $name, $value_type, $text = "����") {//����ʸ���μ�������å�
		if($value || $value == "0"){
		if (strpos($value_type, "na-") !== false) {//Ⱦ�ѱѿ����ȥϥ��ե�OK
			if (!preg_match("/^[a-zA-Z0-9\-]+$/", $value)) {
				$error = "��Ⱦ�ѱѿ������ϥ��ե��";
			}
		} elseif (strpos($value_type, "na") !== false) {//Ⱦ�ѱѿ�����OK
			if (!preg_match("/^[a-zA-Z0-9]+$/", $value)) {
				$error = "��Ⱦ�ѱѿ�����";
			}
		} else {
			if (strstr($value_type, "n") !== false) {//Ⱦ�ѿ�����OK
				if (!preg_match("/^[0-9]+$/", $value)) {
					$error = "��Ⱦ�ѿ�����";
				}
			}
			if (strstr($value_type, "a") !== false) {//Ⱦ�ѱѻ���OK
				if (!preg_match("/^[a-zA-Z]+$/", $value)) {
					$error = "��Ⱦ�ѱѻ���";
				}
			}
			if (strstr($value_type, "N") !== false) {//���ѿ�����OK
				if (!preg_match("/^[��-��]+$/", $value)) {
					$error = "�����ѿ�����";
				}
			}
			if (strstr($value_type, "A") !== false) {//���ѱѻ���OK
				if (!preg_match("/^[��-����-��]+$/", $value)) {
					$error = "�����ѱѻ���";
				}
			}
			if (strstr($value_type, "k") !== false) {//Ⱦ�ѥ������ʤ�OK
				mb_regex_encoding("eucjp-win"); // EUC����
				if (mb_ereg("^[��-�ݎގߎ�-����-������������]+$", $value) === false) {
					$error = "��Ⱦ�ѥ������ʤ�";
				}
			}
			if (strstr($value_type, "K") !== false) {//���ѥ������ʤ�OK
				mb_regex_encoding("eucjp-win"); // EUC����
				if (mb_ereg("^[��-�󡫡���-����-�硼�֡ס���]+$", $value) === false) {
					$error = "�����ѥ������ʤ�";
				}
			}
			if (strstr($value_type, "m") !== false) {//�᡼�륢�ɥ쥹��OK
				mb_regex_encoding("eucjp-win"); // EUC����
				$pattern = '/^(?:(?:(?:(?:[a-zA-Z0-9\._!#\$\%&\'*+\/=?\^`{}~|\-]+)(?:(?:[a-zA-Z0-9_!#\$\%&\'*+\/=?\^`{}~|\-]+))*)|(?:"(?:\\[^\r\n]|[^\\"])*")))\@(?:(?:(?:(?:[a-zA-Z0-9_!#\$\%&\'*+\/=?\^`{}~|\-]+)(?:\.(?:[a-zA-Z0-9_!#\$\%&\'*+\/=?\^`{}~|\-]+))*)|(?:\[(?:\\\S|[\x21-\x5a\x5e-\x7e])*\])))$/';
				if (!preg_match($pattern, $value)) {
					$error = "��������������";
				}
			}
			if (strstr($value_type, "t") !== false) {//�����ֹ椬OK
				if (strpos($value, "-") === false) {
					if (!preg_match("/(^(?<!090|080|070)\d{10}$)|(^(090|080|070)\d{8}$)|(^0120\d{6}$)|(^0080\d{7}$)/", $value)) {
						$error = "��������";
					}
				} else {
					if (!preg_match("/(^(?<!090|080|070)(^\d{2,5}?\-\d{1,4}?\-\d{4}$|^[\d\-]{12}$))|(^(090|080|070)(\-\d{4}\-\d{4}|[\\d-]{13})$)|(^0120(\-\d{2,3}\-\d{3,4}|[\d\-]{12})$)|(^0080\-\d{3}\-\d{4})/", $value)) {
						$error = "��������";
					}
				}
			}
		}
	}
		if ($error) {
			return $name . $error . "" . $text . "���Ʋ�������";
		} else {
			return true;
		}
	}

}

?>