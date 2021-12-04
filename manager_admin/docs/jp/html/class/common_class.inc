<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


//ヒアドキュメント内用の変数
$GLOBALS['nl2br'] = "nl2br";
$GLOBALS['number_format'] = "number_format";
function if_num_number_formmat($number, $zero = true)
{

    if ($zero === false && $number == "0") { //0も表示しない
        return "";

    } else if (is_numeric($number) !== false || $number != "") {
        return number_format($number);
    } else {
        return "";
    }


}

$GLOBALS['if_num_number_format'] = "if_num_number_formmat";

//日付のオブジェクトを取得しておく
$GLOBALS['datetime_now_obj'] = new DateTime();

class Pager
{

    //キーワードの検索のときは、キーの末尾に[_key]をつける
    static function search_pager($line, $search_rows, $count_all, $yoko_kazu, $scroll = "")
    {

        $down_text = "...";
        if (!is_numeric($line)) {
            $line = 0;
        }
        foreach ($_GET as $key => $value) {
            if ($key != "line") { //line以外を取得
                if (is_array($value)) { //配列なら処理を別に
                    foreach ($value as $key1 => $value1) {
                        $url_search .= $key . "%5B%5D=" . rawurlencode($value1) . "&";
                    }
                } else { //配列じゃなければ
                    if (strpos($key, "_key") !== false) {
                        $url_search .= $key . "=" . rawurlencode($value) . "&";
                    } else {
                        $url_search .= $key . "=" . $value . "&";
                    }
                }
            }
        }
        //スクリプト取得
        //		$self_file = File_class::selffile();
        //戻る表示
        if (($line - $search_rows + 1) > 0) {
            $line_x = $line - $search_rows;
            ?>
            <a href="<?= File_class::selffile_noindex() ?>?<?= $url_search ?>line=<?= $line_x ?><?= $scroll ?>">前へ</a>
        <?php
        }
        //横の数の半分を取得
        $yokokazu_half = floor($yoko_kazu / 2);

        $loop_kaisu = 0;
        if ($line > $search_rows * $yokokazu_half) {
            $ii = $line - ($search_rows * $yokokazu_half);
            $bb = ($line - ($search_rows * $yokokazu_half)) / $search_rows;
            echo $down_text;
        } else {
            $ii = 0;
            $bb = 0;
        }
        $kazu_a = $count_all;


        while ($kazu_a > 0) {
            if ($ii >= $count_all) {
                break;
            }
            if ($loop_kaisu == $yoko_kazu) {
                echo $down_text;
                break;
            }

            $bb++;
            if ($line == $ii) {
                ?>
                <span class="bold"><?= $bb ?></span>&nbsp;
            <?php
            } else {
                ?>
                <a href="<?= File_class::selffile_noindex() ?>?<?= $url_search ?>line=<?= $ii ?><?= $scroll ?>"><?= $bb ?></a>&nbsp;
            <?php
            }
            $ii = $ii + $search_rows;
            $kazu_a = $kazu_a - $search_rows;
            $loop_kaisu++;
        }

        $kazu_a = $count_all;
        //次の件数取得
        if ($count_all - $line - $search_rows >= $search_rows) {

        } else {
            $next_num = $count_all - $line - $search_rows;
        }

        //次へひょうじ
        if (($kazu_a - ($line + $search_rows)) > 0) {
            $line_y = $line + $search_rows;
            ?>
            <a href="<?= File_class::selffile_noindex() ?>?<?= $url_search ?>line=<?= $line_y ?><?= $scroll ?>">次へ
                &gt;</a>


        <?php
        }
        ?>


    <?php
    }

    static function search_pager_return($line, $search_rows, $count_all, $yoko_kazu, $scroll = "", $num_view = false)
    {
        /* ========================================================
         * $line 何行目かを指定
         * $search_rows 1ページに表示する件数
         * $kazu 合計件数
         * $yoko_kazu 次へと前への間に表示する件数
         * $scroll リンクに貼るアンカー
         *
         * ====================================================== */
        $down_text = "...";
        if (!is_numeric($line)) {
            $line = 0;
        }
        if ($num_view && $count_all) {
            $line_next = $line + 1;
            if ($line + $search_rows < $count_all) {
                $next_next = $line + $search_rows;
            } else {
                $next_next = $count_all;
            }
            $html .= <<<HTML
						<div class="float_left"><span class="search_pager_all">{$count_all}</span>件中　{$line_next} 〜 {$next_next} 件</div>
HTML;
        }

        $self_file = File_class::selffile_noindex();
        foreach ($_GET as $key => $value) {
            if ($key != "line") { //line以外を取得
                if (is_array($value)) { //配列なら処理を別に
                    foreach ($value as $key1 => $value1) {
                        $url_search .= $key . "%5B%5D=" . rawurlencode($value1) . "&";
                    }
                } else { //配列じゃなければ
                    if (strpos($key, "_key") !== false) {
                        $url_search .= $key . "=" . rawurlencode($value) . "&";
                    } else {
                        $url_search .= $key . "=" . $value . "&";
                    }
                }
            }
        }
        //スクリプト取得
        //		$self_file = File_class::selffile();
        //戻る表示
        if (($line - $search_rows + 1) > 0) {
            $line_x = $line - $search_rows;
            $html .= <<<HTML
			<a href="{$self_file}?{$url_search}line={$line_x}{$scroll}">&lt;&lt; 前へ</a>
HTML;
            $mae = "on";
        }
        if ($yoko_kazu) {
            //横の数の半分を取得

            $yokokazu_half = floor($yoko_kazu / 2);

            $loop_kaisu = 0;
            if ($line > $search_rows * $yokokazu_half) {
                $ii = $line - ($search_rows * $yokokazu_half);
                $bb = ($line - ($search_rows * $yokokazu_half)) / $search_rows;
                $html .= $down_text;
            } else {
                $ii = 0;
                $bb = 0;
            }
            $kazu_a = $count_all;

            while ($kazu_a > 0) {
                if ($ii >= $count_all) {
                    break;
                }
                if ($loop_kaisu == $yoko_kazu) {
                    $html .= $down_text;
                    break;
                }

                $bb++;
                if ($line == $ii) {
                    $html .= <<<HTML
				<span class="bold">{$bb}</span>&nbsp;
HTML;
                } else {
                    $html .= <<<HTML
				<a href="{$self_file}?{$url_search}line={$ii}{$scroll}">{$bb}</a>&nbsp;
HTML;
                }
                $ii = $ii + $search_rows;
                $kazu_a = $kazu_a - $search_rows;
                $loop_kaisu++;
            }
        } elseif ($count_all) {
            if ($mae) {
                $html .= <<<HTML
 |
HTML;
            }
        }

        $kazu_a = $count_all;
        //次の件数取得
        //次へひょうじ
        if (($kazu_a - ($line + $search_rows)) > 0) {
            $line_y = $line + $search_rows;
            if (!$mae) {
                $html .= <<<HTML
 |
HTML;
            }
            $html .= <<<HTML
			<a href="{$self_file}?{$url_search}line={$line_y}{$scroll}">次へ &gt;&gt;</a>

HTML;
        }
        return $html;
        ?>


    <?php
    }

    static function search_pager_all($line, $search_rows, $count_all, $yoko_kazu, $num_view = false, $scroll = "")
    {
        $down_text = "...";
        if (!is_numeric($line)) {
            $line = 0;
        }
        if ($num_view && $count_all) {
            $line_next = $line + 1;
            if ($line + $search_rows < $count_all) {
                $next_next = $line + $search_rows;
            } else {
                $next_next = $count_all;
            }
            ?>
            [<span class="search_pager_all"><?= $count_all ?></span>件中　<?= $line_next ?> - <?= $next_next ?> 件]



        <?php
        }
        foreach ($_GET as $key => $value) {
            if ($key != "line") { //line以外を取得
                if (is_array($value)) { //配列なら処理を別に
                    foreach ($value as $key1 => $value1) {
                        $url_search .= $key . "%5B%5D=" . rawurlencode($value1) . "&";
                    }
                } else { //配列じゃなければ
                    if (strpos($key, "_key") !== false) {
                        $url_search .= $key . "=" . rawurlencode($value) . "&";
                    } else {
                        $url_search .= $key . "=" . $value . "&";
                    }
                }
            }
        }
        //スクリプト取得
        //		$self_file = File_class::selffile();
        //最初へ表示
        if ($_GET['line'] > 0 && $_GET['line']) {
            ?>
            <a href="<?= File_class::selffile_noindex() ?>?<?= $url_search ?>line=0<?= $scroll ?>" class="big">&lt;&lt;&nbsp;</a>&nbsp;
        <?php
        } else {
            ?>
            <span>
				&lt;&lt;&nbsp;
			</span>
        <?php
        }

        //戻る表示
        if (($line - $search_rows + 1) > 0) {
            $line_x = $line - $search_rows;
            ?>
            <a href="<?= File_class::selffile_noindex() ?>?<?= $url_search ?>line=<?= $line_x ?><?= $scroll ?>" class="big">
                &lt;</a>&nbsp;
        <?php
        } else {
            ?>
            <span>
				&lt;&nbsp;
			</span>
        <?php
        }
        //横の数の半分を取得
        $yokokazu_half = floor($yoko_kazu / 2);

        $loop_kaisu = 0;
        if ($line > $search_rows * $yokokazu_half) {
            $ii = $line - ($search_rows * $yokokazu_half);
            $bb = ($line - ($search_rows * $yokokazu_half)) / $search_rows;
            echo $down_text;
        } else {
            $ii = 0;
            $bb = 0;
        }
        $kazu_a = $count_all;

        while ($kazu_a > 0) {
            if ($ii >= $count_all) {
                break;
            }

            if ($loop_kaisu == $yoko_kazu) {
                echo $down_text;
                break;
            }

            $bb++;
            if ($line == $ii) {
                ?>
                <span class="bold"><?= $bb ?></span>&nbsp;
            <?php
            } else {
                ?>
                <a href="<?= File_class::selffile_noindex() ?>?<?= $url_search ?>line=<?= $ii ?><?= $scroll ?>"><?= $bb ?></a>&nbsp;
            <?php
            }
            $ii = $ii + $search_rows;
            $kazu_a = $kazu_a - $search_rows;
            $loop_kaisu++;
        }


        $kazu_a = $count_all;
        //次の件数取得
        if ($count_all - $line - $search_rows >= $search_rows) {

        } else {
            $next_num = $count_all - $line - $search_rows;
        }

        //次へひょうじ
        if (($kazu_a - ($line + $search_rows)) > 0) {
            $line_y = $line + $search_rows;
            ?>
            &nbsp;
            <a href="<?= File_class::selffile_noindex() ?>?<?= $url_search ?>line=<?= $line_y ?><?= $scroll ?>" class="big">
                &gt;</a>
        <?php
        } else {
            ?>
            <span>
				&nbsp;&gt;
			</span>
        <?php
        }


        if (($kazu_a - ($line + $search_rows)) > 0) {
            if ($count_all % $search_rows == 0) {
                $ii2 = $count_all - $search_rows;
            } else {
                $ii2 = $count_all - ($count_all % $search_rows);
            }
            ?>
            &nbsp;
            <a href="<?= File_class::selffile_noindex() ?>?<?= $url_search ?>line=<?= $ii2 ?><?= $scroll ?>" class="big">
                &gt;&gt;</a>&nbsp;
        <?php
        } else {
            ?>
            <span>
				&nbsp;&gt;&gt;
			</span>
        <?php
        }
    }

    static function count_view($line, $search_rows, $count_all)
    {
        ?>
        <span class="count_view">
			<?php
            //一件でもあれば
            if ($count_all) {

                echo $line + 1;
                ?>
                件〜
                <?php
                if ($line + $search_rows > $count_all) {
                    echo $count_all;
                } else {
                    echo $line + $search_rows;
                }
                ?>
                件


            <?php
            }
            ?>
            (全
            <?php
            echo $count_all;
            echo "件)　 ";
            ?>
		</span>
    <?php
    }

}

class Date_class
{

    static function get_Day_of_the_week($Y_m_d)
    {
        //日付から曜日を取得

        $datetime = new DateTime($Y_m_d);
        $week = array("日", "月", "火", "水", "木", "金", "土");
        $w = (int)$datetime->format('w');
        return $week[$w];

    }

    static function get_period_from_ym_ym($y1, $m1, $y2 = "", $m2 = "")
    {
        //数字から期間を返す関数
        if ($y1 && $m1) {
            $return = $y1 . "年" . $m1 . "月";
        }
        if ($y2 && $m2) {
            $return2 = $y2 . "年" . $m2 . "月";
        }
        if ($return && $return2) {
            return $return . " 〜 " . $return2;
        } elseif ($return || $return2) {
            return $return . $return2;
        } else {
            return "";
        }
    }

    static function next_date($yyyy, $mmmm, $next_type = "month", $next_num = "+1")
    {
        //$yyyy,$mmから翌月を取得
        //$next_typeはyear month day などから選択
        //$next_num はどの程度先なのか、または以前なのかを+1、-2などで入力
        $moto_ym = $yyyy . "-" . $mmmm . "-1";
        $next_yyyy = date('Y', strtotime(date($moto_ym) . ' ' . $next_num . ' ' . $next_type));
        $next_mmmm = date('m', strtotime(date($moto_ym) . ' ' . $next_num . ' ' . $next_type));

        return array(
            $next_yyyy,
            $next_mmmm
        );
    }


    static function yyyymm_separate($yyyymm)
    {
        //$yyyymmを$yyyy,$mmに分割して配列で返す

        $y = substr($yyyymm, 0, 4);
        $m = substr($yyyymm, 4, 2);
        return array(
            $y,
            $m
        );
    }
    static function calendar_value_merge($array)
    {
        //配列のキーが *_year, *_month ,*_day なら　* にまとめた値を入れる

        foreach ($array as $key => $value) {

            if(strpos($key,"_year") !== false){
                $key_front = str_replace("_year","",$key);
                if(isset($array[$key_front.'_year']) !== false
                && isset($array[$key_front.'_month']) !== false
                && isset($array[$key_front.'_day']) !== false){
                    $array[$key_front] = $array[$key_front.'_year']."-". $array[$key_front.'_month']."-". $array[$key_front.'_day'];

                }
            }
        }
return $array;

    }

}

class Text_class
{


    static function date_replace($key, $array)
    {
        //日付の桁数不足を自動で補う関数
        //$key は基本となるキー
        //$key = birthday なら
        //birthday_y ,birthday_m ,birthday_d をチェックして変更する

        $key_y = $key . "_y";
        $key_m = $key . "_m";
        $key_d = $key . "_d";

        $array[$key_y] = mb_convert_kana($array[$key_y], "n", "utf-8");
        $array[$key_m] = mb_convert_kana($array[$key_m], "n", "utf-8");
        $array[$key_d] = mb_convert_kana($array[$key_d], "n", "utf-8");

        if (is_numeric($array[$key_m]) !== false) {
            //数字なら桁数をそろえる
            $array[$key_m] = sprintf("%02d", $array[$key_m]);
        }
        if (is_numeric($array[$key_d]) !== false) {
            //数字なら桁数をそろえる
            $array[$key_d] = sprintf("%02d", $array[$key_d]);
        }

        return $array;


    }

    static function make_date_for_db($key, $array)
    {
        //年・月・日がばらばらのものをデータベースのdate型に入れるために変換する
        //$array 変換したいもとの配列　戻り値で再度代入しなおす
        //$key は基本となるキー
        //$key = birthday なら
        //birthday_y ,birthday_m ,birthday_d をチェックして変更する

        $key_y = $key . "_y";
        $key_m = $key . "_m";
        $key_d = $key . "_d";

        $array[$key_y] = mb_convert_kana($array[$key_y], "n", "utf-8");
        $array[$key_m] = mb_convert_kana($array[$key_m], "n", "utf-8");
        $array[$key_d] = mb_convert_kana($array[$key_d], "n", "utf-8");


        if (is_numeric($array[$key_m]) !== false) {
            //数字なら桁数をそろえる
            $array[$key_m] = sprintf("%02d", $array[$key_m]);
        }
        if (is_numeric($array[$key_d]) !== false) {
            //数字なら桁数をそろえる
            $array[$key_d] = sprintf("%02d", $array[$key_d]);
        }

        if ($array[$key_y] || $array[$key_m] || $array[$key_d]) {
            $array[$key] = $array[$key_y] . "-" . $array[$key_m] . "-" . $array[$key_d];

        } else {
            $array[$key] = "@NULL@"; //空ならnullにする
        }

        return $array;


    }

    static function make_date_for_search($key, $array, $end = false)
    {
        //年・月・日がばらばらのものを検索できるように変換する
        //$array 変換したいもとの配列　戻り値で再度代入しなおす
        //$key は基本となるキー
        //$key = birthday なら
        //birthday_y ,birthday_m ,birthday_d をチェックして変更する

        $key_y = $key . "_y";
        $key_m = $key . "_m";
        $key_d = $key . "_d";

        $array[$key_y] = mb_convert_kana($array[$key_y], "n", "utf-8");
        $array[$key_m] = mb_convert_kana($array[$key_m], "n", "utf-8");
        $array[$key_d] = mb_convert_kana($array[$key_d], "n", "utf-8");

        if (is_numeric($array[$key_m]) !== false) {
            //数字なら桁数をそろえる
            $array[$key_m] = sprintf("%02d", $array[$key_m]);
        }
        if (is_numeric($array[$key_d]) !== false) {
            //数字なら桁数をそろえる
            $array[$key_d] = sprintf("%02d", $array[$key_d]);
        }

        if ($array[$key_y] && $array[$key_m] && $array[$key_d]) {

            $array[$key] = $array[$key_y] . "-" . $array[$key_m] . "-" . $array[$key_d];

        } elseif ($array[$key_y] && $array[$key_m]) {
            if ($end) {

                $array[$key] = $array[$key_y] . "-" . $array[$key_m] . "-31";
            } else {
                $array[$key] = $array[$key_y] . "-" . $array[$key_m] . "-01";

            }
        } elseif ($array[$key_y]) {
            if ($end) {
                $array[$key] = $array[$key_y] . "-12-31";

            } else {

                $array[$key] = $array[$key_y] . "-01-01";
            }
        }

        return $array;


    }

    static function trim_zen_space_old($keyword, $encode = false)
    {
        if (!$encode) {
            $encode = "EUC-JP";
        }
        return trim(trim(trim($keyword), "　"));
    }

    static function trim_zen_space($str, $chars = "\s　")
    {
        $str = trim($str);
        $str = mb_ereg_replace("^[$chars]+", "", $str);
        $str = mb_ereg_replace("[$chars]+$", "", $str);
        return trim($str);
    }

    static function delete_zen_space($keyword, $encode = false)
    {
        if (!$encode) {
            $encode = "EUC-JP";
        }
        return str_replace(" ", "", trim(mb_convert_kana($keyword, "s", $encode)));
    }

    static function var_price_judgment($var)
    {

        if ($var || $var == "0") {
            return true;
        } else {
            return false;
        }
    }

    static function separator_change($text, $separator, $after_sparator)
    {
        if (strpos($text, $separator) !== false) {
            $return_array = explode($separator, $text);
            $end_key = Array_func::endKey($return_array);
            foreach ($return_array as $key => $value) {
                if ($key == $end_key) {
                    $return .= $value;
                } else {
                    $return .= $value . $after_sparator;
                }
            }
            return $return;
        } else {
            return $text;
        }
    }

    static function getRandom_String($nLengthRequired = 8)
    {
        $sCharList = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        mt_srand();
        $sRes = "";
        for ($i = 0; $i < $nLengthRequired; $i++)
            $sRes .= $sCharList{mt_rand(0, strlen($sCharList) - 1)};
        return $sRes;
    }

    static function birthday_return($birthday)
    {
        //$birthday YYYYmmdd
        $now = date('Ymd');
        return floor(($now - $birthday) / 10000);
    }

    static function yearsold_to_birthday_high($yearsold)
    {
        //$yearsold 年齢
        return date('Ymd', strtotime("-$yearsold year"));
    }

    static function yearsold_to_birthday_low($yearsold)
    {
        //$yearsold 年齢
        $yearsold_2 = $yearsold + 1;
        return date('Ymd', strtotime("-$yearsold_2 year +1 day "));
    }

    static function mb_trim($str, $chars = "\s　")
    {
        $str = mb_ereg_replace("^[$chars]+", "", $str);
        $str = mb_ereg_replace("[$chars]+$", "", $str);
        return $str;
    }

}

class Form
{

    static function radio_button_write_usekey($name, $array_key_value, $value_sele, $br = false, $onclick = false)
    {

        //配列のキーをvalueに、値を表示テキストとして使用($array_key_value)


        if ($onclick) {
            $java_write = ' onclick="' . $onclick . '"';
        }


        foreach ($array_key_value as $key => $value) {

            if ($value_sele == $key && isset($value_sele) !== false) {
                $selected = " checked";
            } else {
                $selected = "";
            }


            //ラベルの外に表示する項目（selectなど）
            if (strpos($value, "@after_label") !== false) {
                list($value, $after_label) = explode("@after_label", $value);
            } else {
                $value = $value;
                $after_label = "";
            }

            ?>
            <input type="radio" name="<?= $name ?>" class="form_radio" value="<?= $key ?>"
                   id="<?= $name ?>_<?= $key ?>"<?= $selected . $java_write ?>><label
                for="<?= $name ?>_<?= $key ?>" style="display: inline;"> <?= $value ?> </label> <?= $after_label ?>
            <?php
            if ($br) {
                echo $br;
            }
        }
    }

    static function radio_button_write($name, $name_arr, $value_arr, $value_sele, $br = false)
    {

        foreach ($name_arr as $key => $value) {

            if ($value_sele == $value_arr[$key]) {
                $selected = " checked";
            } else {
                $selected = "";
            }
            ?>
            <input type="radio" name="<?= $name ?>" value="<?= $value_arr[$key] ?>"
                   id="<?= $name ?>_<?= $value_arr[$key] ?>"<?= $selected ?>><label
                for="<?= $name ?>_<?= $value_arr[$key] ?>"> <?= $value ?> </label>
            <?php
            if ($br) {
                echo $br;
            }
        }
    }

    static function radio_button_write_click($name, $name_arr, $value_arr, $click_arr, $value_sele, $br = false)
    {

        foreach ($name_arr as $key => $value) {

            if ($value_sele == $value_arr[$key]) {
                $selected = " checked";
            } else {
                $selected = "";
            }
            ?>
            <input type="radio" name="<?= $name ?>" value="<?= $value_arr[$key] ?>"
                   id="<?= $name ?>_<?= $value_arr[$key] ?>"<?= $selected ?> onclick="<?= $click_arr[$key] ?>"><label
                for="<?= $name ?>_<?= $value_arr[$key] ?>"> <?= $value ?> </label>
            <?php
            if ($br) {
                echo $br;
            }
        }
    }

    static function checkbox_write($name, $name_arr, $value_arr, $value_sele_arr, $br = false)
    { //$brが数字なら回数ごとに改行する
        $ii = 0;
        foreach ($name_arr as $key => $value) {
            $ii++;
            if ($value_sele_arr) {
                if (@array_search($value_arr[$key], $value_sele_arr) !== false) {
                    $selected = " checked";
                } else {
                    $selected = "";
                }
            }
            ?>
            <input type="checkbox" name="<?= $name ?>[]" value="<?= $value_arr[$key] ?>"
                   id="<?= $name ?>_<?= $value_arr[$key] ?>"<?= $selected ?>><label
                for="<?= $name ?>_<?= $value_arr[$key] ?>"> <?= $value ?> </label>
            <?php
            if (is_numeric($br)) {
                if ($ii % $br == 0) {
                    echo "<br />";
                }
            } elseif ($br) {
                echo $br;
            }
        }
    }


    static function checkbox_write_return($name, $name_arr, $value_arr, $value_sele_arr, $br = false)
    { //$brが数字なら回数ごとに改行する
        $ii = 0;
        foreach ($name_arr as $key => $value) {
            $ii++;
            if ($value_sele_arr) {
                if (@array_search($value_arr[$key], $value_sele_arr) !== false) {
                    $selected = " checked";
                } else {
                    $selected = "";
                }
            }
            $html .= <<<HTML
			<input type="checkbox" name="{$name}[]" value="{$value_arr[$key]}" id="{$name}_{$value_arr[$key]}"{$selected}><label for="{$name}_{$value_arr[$key]}"> {$value} </label>
HTML;
            if (is_numeric($br)) {
                if ($ii % $br == 0) {
                    $html .= "<br />";
                }
            } elseif ($br) {
                $html .= $br;
            }
        }
        return $html;
    }

    static function checkbox_preview_return($global, $value_array, $delimiter = ",", $return_text = "未選択")
    {
        if (is_array($value_array)) {
            foreach ($value_array as $key => $value) {
                if ($global[$value]) {
                    $return .= $global[$value] . $delimiter;
                }
            }
            $return = trim($return, $delimiter);
        } else {
            $return = $return_text;
        }

        return $return;
    }

    static function radiobutton_preview_return($text_array, $value_array, $value, $return_text = "未選択")
    {
        /**
         *ラジオボタンの選択内容をプレビューで表示するための値を返す関数
         * $text_array 表示する候補の配列
         * $value_array ラジオボタンで使用している値の配列
         * $value ラジオボタンで選択された値
         */

        if (is_array($value_array)) {
            foreach ($value_array as $key => $val) {
                if ($val == $value) {
                    $return .= $text_array[$key];
                    break;
                }
            }
            $return = trim($return, $delimiter);
        } else {
            $return = $return_text;
        }

        return $return;
    }

    static function checkbox_write_usekey($name, $array_key_value, $key_sele_array, $br = false, $onclick = false, $label = true, $user_key = true)
    {
        //配列のキーをoptionのvalueに、値を表示テキストとして使用
        //$user_key　true なら　key をoption のvalueに代入（デフォルト）
        //$user_key　falseならを配列の値をoption のvalueに代入

        foreach ($array_key_value as $key => $value) {
            $name_arr[$key] = $value;
            $value_arr[$key] = $key;
        }

        $value_sele_arr = $key_sele_array;


        Form::checkbox_write_inkey($name, $name_arr, $value_arr, $value_sele_arr, $br, $onclick, $label);
    }

    static function checkbox_write_inkey($name, $name_arr, $value_arr, $value_sele_arr, $br = false, $onclick = false, $label = true)
    { //$brが数字なら回数ごとに改行する
        $ii = 0;

        if ($onclick) {
            $java_write = ' onclick="' . $onclick . '"';
        }

        foreach ($name_arr as $key => $value) {
            $ii++;
            if ($value_sele_arr) {
                if (@array_search($value_arr[$key], $value_sele_arr) !== false) {
                    $selected = " checked";
                } else {
                    $selected = "";
                }
            }

            //@@@を含む場合の特殊処理
            if (strpos($value, FORM_SPECIAL_PROCESS) !== false) {
                $value = str_replace(FORM_SPECIAL_PROCESS, "", $value);
                if ($selected) {

                    $input = <<<HTML
     <input type="hidden" name="{$name}[{$key}]" value="{$value_arr[$key]}" />
HTML;
                } else {
                    $input = "";
                }
                $disabled = " disabled='disabled'";
            } else {
                $disabled = "";
                $input = "";
            }
            if (strpos($br, "class=") !== false) {
                $class = $br;
            }
            if (strpos($br, "id=") !== false) {
                $id = $br;
            }
            ?>
            <input type="checkbox" name="<?= $name ?>[<?= $key ?>]" class="form_radio" value="<?= $value_arr[$key] ?>" id="<?= $name ?>_<?= $value_arr[$key] ?>"<?= $java_write ?><?= $selected . $disabled . $class . $id ?>>
            <?php
            if ($label) {
                ?>
                <label for="<?= $name ?>_<?= $value_arr[$key] ?>" style="display: inline;">
            <?php
            }
            ?>
            <?= $value ?>
            <?php
            if ($label) {
                ?>
                </label>  &nbsp;&nbsp;
            <?php
            }
            ?>
            <?= $input ?>
            <?php
            if (is_numeric($br)) {
                if ($ii % $br == 0) {
                    echo "<br />";
                }
            } elseif ($br && strpos($br, "class=") === false && strpos($br, "id=") === false) {
                echo $br;
            }
        }
    }

    static function next_back_view($line, $search_rows, $kazu, $yoko_kazu)
    {
        ?>

        <span style="font-weight:400;">
		<?php
        //一件でもあれば
        if ($kazu) {

            echo $line + 1;
            ?>
            件～
            <?php
            if ($line + $search_rows > $kazu) {
                echo $kazu;
            } else {
                echo $line + $search_rows;
            }
            ?>
            件


        <?php
        }
        ?>
            (全
            <?php
            echo $kazu;
            echo "件)　 ";
            ?>
		</span>
        <?php
        foreach ($_GET as $key => $value) {
            if ($key != "line") { //line以外を取得
                if ($key == "keyword") {
                    $url_search .= $key . "=" . urlencode($value) . "&";
                } else {
                    $url_search .= $key . "=" . $value . "&";
                }
            }
        }


        //戻る表示
        if (($line - $search_rows + 1) > 0) {
            $line_x = $line - $search_rows;
            ?>

            <a href="./?<?= $url_search ?>line=<?= $line_x ?>">&lt;&lt; 前の<?= $search_rows ?>件</a>&nbsp;
        <?php
        }
        //横の数の半分を取得
        $yokokazu_half = floor($yoko_kazu / 2);


        $loop_kaisu = 0;
        if ($line > $search_rows * $yokokazu_half) {
            $ii = $line - ($search_rows * $yokokazu_half);
            $bb = ($line - ($search_rows * $yokokazu_half)) / $search_rows;
            $down_text = "...";
        } else {
            $ii = 0;
            $bb = 0;
        }
        $kazu_a = $kazu;
        echo $down_text;
        while ($kazu_a > 0) {
            if ($ii >= $kazu) {
                break;
            }
            if ($loop_kaisu == $yoko_kazu) {
                echo "...";
                break;
            }

            $bb++;
            if ($line == $ii) {
                ?>
                <b style="color:#000000;"><?= $bb ?></b>&nbsp;
            <?php
            } else {
                ?>
                <a href="./?<?= $url_search ?>line=<?= $ii ?>"><?= $bb ?></a>&nbsp;
            <?php
            }
            $ii = $ii + $search_rows;
            $kazu_a = $kazu_a - $search_rows;
            $loop_kaisu++;
        }
        $kazu_a = $kazu;
        //次の件数取得
        if ($kazu - $line - $search_rows > $search_rows) {
            $next_text = "次の" . $search_rows . "件";
        } else {
            $next_num = $kazu - $line - $search_rows;
            $next_text = "次の" . $next_num . "件";
        }

        //次へひょうじ
        if (($kazu_a - ($line + $search_rows)) > 0) {
            $line_y = $line + $search_rows;
            ?>
            <a href="./?<?= $url_search ?>line=<?= $line_y ?>"><?= $next_text ?>> &gt;&gt;</a>&nbsp;


        <?php
        }
        ?>

    <?php
    }

    static function pulldown_write_usekey($array_key_value, $key_sele, $user_key = true)
    {
        //配列のキーをoptionのvalueに、値を表示テキストとして使用
        //$user_key　true なら　key をoption のvalueに代入（デフォルト）
        //$user_key　falseならを配列の値をoption のvalueに代入


        foreach ($array_key_value as $key => $value) {

            if ($user_key === false) { //オプションで、配列の値を使用
                $key = $value;
            }

            if ($key_sele == $key && isset($key_sele)) {
                $selected = " selected";
            } else {
                $selected = "";
            }




            ?>
            <option value="<?= $key ?>"<?= $selected ?>><?= $value ?></option>

        <?php
        }
    }
    static function pulldown_write_usekey_return($array_key_value, $key_sele, $user_key = true)
    {
        //配列のキーをoptionのvalueに、値を表示テキストとして使用
        //$user_key　true なら　key をoption のvalueに代入（デフォルト）
        //$user_key　falseならを配列の値をoption のvalueに代入
        //$key_seleが配列なら複数指定可能のセレクトボックスと判断


        foreach ($array_key_value as $key => $value) {
            if ($user_key === false) { //オプションで、配列の値を使用
                $key = $value;
            }

            if (is_array($key_sele) !== false) {
                //配列なら
                if (in_array($key, $key_sele) !== false) {
                    $selected = " selected";
                } else {
                    $selected = "";
                }
            } else {

                if (strval($key_sele) != "" && $key_sele == $key) {
                    $selected = " selected";
                } else {
                    $selected = "";
                }
            }

            $html .= <<<HTML
            <option value="{$key}"{$selected}>{$value}</option>
HTML;

        }
        return $html;
    }
    static function pulldown_write($name_arr, $name_sele)
    {

        foreach ($name_arr as $key => $value) {

            if ($name_sele == $value) {
                $selected = " selected";
            } else {
                $selected = "";
            }
            ?>
            <option value="<?= $value ?>"<?= $selected ?>><?= $value ?></option>

        <?php
        }
    }

    static function pulldown_write2($name_arr, $value_arr, $name_sele)
    {

        foreach ($name_arr as $key => $value) {
            settype($value_arr[$key], "string");
            if ($name_sele === $value_arr[$key]) {
                $selected = " selected";
            } else {
                $selected = "";
            }
            ?>
            <option value="<?= $value_arr[$key] ?>"<?= $selected ?>><?= $value ?></option>

        <?php
        }
    }

    static function pulldown_return($name_arr, $value_arr, $name_sele)
    {
        $return = "";
        foreach ($name_arr as $key => $value) {


            if ($name_sele === (string)$value_arr[$key]) {
                $selected = " selected";

            } else {
                $selected = "";
            }
            $return .= <<<HTML
			<option value="{$value_arr[$key]}"{$selected}>{$value}</option>
HTML;
        }
        return $return;
    }

    static function form_error_search($text)
    {
        if ($text) {
            ?>
            <span class="form-error-search"><?= $text ?></span>
        <?php
        }
    }

    static function image_error($error_int)
    {
        if ($error_int !== true) {
            if ($error_int == "filetype error") {
                $error = "指定された画像はアップロードできない形式のファイルです。";
            }
            if ($error_int[0] == "filesize error") {
                $error = "画像のサイズは" . $error_int[1] . "KBまでにして下さい。";
            }
            if ($error_int == "cmyk error") {
                $error = "CMYK画像はアップロードすることができません。RGB画像に変換してからご使用下さい。";
            }
        }
        if ($error) {
            return $error;
        } else {
            return null;
        }
    }

}

class File_class
{

    static function selffile()
    {
        return end(explode("/", $_SERVER["PHP_SELF"]));
    }

    static function selffile_noindex()
    {
        $file = end(explode("/", $_SERVER["PHP_SELF"]));
        if ($file == "index.php") {
            $file = "./";
        }
        return $file;
    }

    static function referer_put($key, $mode)
    {
        if ($_GET['mode'] == $mode) {
            require_once REQUIRE_PATH . '/session.inc';
            $filename = File_class::selffile();
            $_SESSION[$key]['referer'] = $filename . "?" . $_SERVER['QUERY_STRING'];
        }
    }

    // 再帰的にディレクトリを削除する。
    //     * @param string $dir ディレクトリ名（フルパス）
    //     */
    static function removeDir($dir)
    {

        $cnt = 0;
        if (is_dir($dir)) {
            $handle = opendir($dir);
        }
        if (!$handle) {
            return;
        }

        while (false !== ($item = readdir($handle))) {
            if ($item === "." || $item === "..") {
                continue;
            }
            $path = $dir . DIRECTORY_SEPARATOR . $item;

            if (is_dir($path)) {
                // 再帰的に削除
                File_class::removeDir($path);
                //				$cnt = $cnt + File_class::removeDir($path);
            } else {
                // ファイルを削除
                unlink($path);
            }
        }
        closedir($handle);

        // ディレクトリを削除
        if (!rmdir($dir)) {
            return;
        }
    }

    static function byteConvert($bytes)
    {
        if ($bytes) {

            $s = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');
            $e = floor(log($bytes) / log(1024));
            return sprintf('%.1f ' . $s[$e], ($bytes / pow(1024, floor($e))));
        } else {
            return 0;
        }
    }

}

class Array_func
{

    static function array_key_to_value($array)
    {
        /* ========================================================
         * 配列のキーを値に入れる関数（キーはそのままで）
         * ====================================================== */
        $key_array = array();
        if (is_array($array)) {
            foreach ($array as $key => $value) {
                $key_array[$key] = $key;
            }
        }
        return $key_array;
    }

    static function array_value_to_key($array)
    {
        /* ========================================================
         * 配列の値をにキー入れる関数（値はそのままで）
         * 値が空なら飛ばす
         * ====================================================== */
        $key_array = array();
        foreach ($array as $key => $value) {
            if (trim($value)) {
                $key_array[$value] = trim($value);
            }
        }
        return $key_array;
    }

    //連想配列の最後のkey取得
    static function endKey($array)
    {
        end($array);
        return key($array);
    }

    //連想配列の最初のkey取得
    static function firstKey($array)
    {
        reset($array);
        return key($array);
    }

    static function GETquery($noget_key = false)
    {
        /* ========================================================
         * $noget_key arrayで指定する　除外するkey
         * ====================================================== */
        if (is_array($_GET)) {
            foreach ($_GET as $key => $value) {
                if (is_array($noget_key) !== false) {
                    if (array_search($key, $noget_key) !== false) {
                        continue;
                    }
                }
                if (is_array($value) !== false) {
                    foreach ($value as $key2 => $value2) {
                        $result .= $key . "[" . $key2 . "]=" . $value2 . "&";
                    }
                } else {
                    $result .= $key . "=" . strip_tags($value) . "&";
                }
            }
            return trim($result, "&");
        } else {
            return false;
        }
    }

    static function GETquery_encode($noget_key = false)
    {
        /* ========================================================
         * $noget_key arrayで指定する　除外するkey
         * encodeは値のみ（キーはエンコードしない）
         * ====================================================== */
        if (is_array($_GET)) {
            foreach ($_GET as $key => $value) {
                if (is_array($noget_key) !== false) {
                    if (array_search($key, $noget_key) !== false) {
                        continue;
                    }
                }
                if (is_array($value) !== false) {
                    foreach ($value as $key2 => $value2) {
                        $result .= $key . "[" . $key2 . "]=" . rawurlencode($value2) . "&";
                    }
                } else {
                    $result .= $key . "=" . rawurlencode(strip_tags($value)) . "&";
                }
            }
            return trim($result, "&");
        } else {
            return false;
        }
    }


    static function Array_to_hidden($array, $exclude_array = false)
    {
        /* ========================================================
         * $array 大本になる配列　（例；$_POST　でも可
         * $exclude_arrayで指定する　除外するkey
         * ====================================================== */
        if (is_array($array)) {
            foreach ($array as $key => $value) {
                if (is_array($exclude_array) !== false) {
                    if (array_search($key, $exclude_array) !== false) {
                        continue;
                    }
                }
                if (is_array($value) !== false) {
                    foreach ($value as $key2 => $value2) {
                        $result .= '<input type="hidden" id="' . $key . '[' . $key2 . ']" name="' . $key . '[' . $key2 . ']" value="' . $value2 . '" />';
                    }
                } else {
                    $result .= '<input type="hidden" id="' . $key . '" name="' . $key . '" value="' . $value . '" />';
                }
            }
            return trim($result, "&");
        } else {
            return false;
        }
    }

    static function GETquery_hidden($noget_key = false)
    {
        /* ========================================================
         * $noget_key arrayで指定する　除外するkey
         * ====================================================== */
        if (is_array($_GET)) {
            foreach ($_GET as $key => $value) {
                if (is_array($noget_key) !== false) {
                    if (array_search($key, $noget_key) !== false) {
                        continue;
                    }
                }
                if (is_array($value) !== false) {
                    foreach ($value as $key2 => $value2) {
                        $result .= '<input type="hidden" id="' . $key . '[' . $key2 . ']" name="' . $key . '[' . $key2 . ']" value="' . $value2 . '" />';
                    }
                } else {
                    $result .= '<input type="hidden" id="' . $key . '" name="' . $key . '" value="' . $value . '" />';
                }
            }
            return trim($result, "&");
        } else {
            return false;
        }
    }

    static function encode_from_array($array, $to_encoding = "Shift_JIS", $from_encoding = "EUC-JP")
    {
        if (is_array($array) !== false) {
            foreach ($array as $key => $value) {
                $array[$key] = mb_convert_encoding($value, $to_encoding, $from_encoding);
            }
        }
        return $array;
    }

}

class time_change
{

    static function from_datetime($time, $type = "jp", $length = 5, $figure = 2, $year_type = true)
    {
        /* ========================================================
         * データベースのdatetimeの値を表示用の日付に変更する関数
         * $type jp　日本語表示　y年m月d日 else  スラッシュ表示　y/m/d
         * $length どこまで表示するか
         * 1 年 まで
         * 2 月まで
         * 3　日まで
         * 4　時間まで
         * 5　分まで
         * t 時間のみ
         * $figure 最低桁数　$figure　1なら2012/1/1 2なら　2012/01/01
         * $year 通常は表示(true)　false なら年は非表示 2なら二文字
         * ====================================================== */

        if ($type == "jp") {
            $y_unit = "年";
            $m_unit = "月";
            $d_unit = "日";
            $h_unit = "時";
            $i_unit = "分";
        } else {
            $y_unit = "/";
            $m_unit = "/";
            $d_unit = " ";
            $h_unit = ":";
            $i_unit = "";
        }

        if ($length == "t") {
            $ymd .= "H" . $h_unit . "i" . $i_unit;
        } else {
            if ($length >= 1 && $year_type === true) {
                $ymd .= "Y" . $y_unit;
            } elseif ($length >= 1 && $year_type == "2") {
                $ymd .= "y" . $y_unit;
            }
            if ($length >= 2 && $figure == 2) {
                $ymd .= "m" . $m_unit;
            } elseif ($length >= 2 && $figure == 1) {
                $ymd .= "n" . $m_unit;
            }
            if ($length >= 3 && $figure == 2) {
                $ymd .= "d" . $d_unit;
            } elseif ($length >= 3 && $figure == 1) {
                $ymd .= "j" . $d_unit;
            }
            if ($length >= 4 && $figure == 2) {
                $ymd .= "H" . $h_unit;
            } elseif ($length >= 4 && $figure == 1) {
                $ymd .= "G" . $h_unit;
            }
            if ($length >= 5) {
                $ymd .= "i" . $i_unit;
            }
        }

        return date($ymd, strtotime($time));
    }

    static function from_date($date, $type = "jp", $length = 3, $figure = 2, $year_type = true, $w_day = false)
    {
        /* ========================================================
         * データベースのdateの値を表示用の日付に変更する関数
         * $type jp　日本語表示 (20140716update)　y年m月d日 else  スラッシュ表示　y/m/d
         * $w_day 文字があれば、曜日を表示　例：（w) とすると、（日）、w曜日 なら 日曜日
         * $length どこまで表示するか
         * 1 年 まで
         * 2 月まで
         * 3　日まで
         * * $figure 最低桁数　$figure　1なら2012/1/1 2なら　2012/01/01
         * $year 通常は表示(true)　false なら年は非表示 2なら二文字
         * ====================================================== */

        if ($date == "") {
            return "";
        }

        if ($type == "jp" || $type == "jpw") {
            $y_unit = "年";
            $m_unit = "月";
            $d_unit = "日";
        } else {
            $y_unit = "/";
            $m_unit = "/";
            $d_unit = "";
        }
        if ($w_day) {
            //曜日を表示

            $datetime = date_create($date);
            $week_array = array("日", "月", "火", "水", "木", "金", "土");
            $w = (int)date_format($datetime, "w");
            $w_value = $week_array[$w];
            $w_return = str_replace("w", $w_value, $w_day);
        }

        if ($length >= 1 && $year_type === true) {
            $ymd .= "Y" . $y_unit;
        } elseif ($length >= 1 && $year_type == "2") {
            $ymd .= "y" . $y_unit;
        }
        if ($length >= 2 && $figure == 2) {
            $ymd .= "m" . $m_unit;
        } elseif ($length >= 2 && $figure == 1) {
            $ymd .= "n" . $m_unit;
        }
        if ($length >= 3 && $figure == 2) {
            $ymd .= "d" . $d_unit;
        } elseif ($length >= 3 && $figure == 1) {
            $ymd .= "j" . $d_unit;
        }
        if ($length >= 4 && $figure == 2) {
            $ymd .= "H" . $h_unit;
        } elseif ($length >= 4 && $figure == 1) {
            $ymd .= "G" . $h_unit;
        }
        if ($length >= 5) {
            $ymd .= "i" . $i_unit;
        }
        $time_new = $date . " 00:00:00";
        return date($ymd, strtotime($time_new)) . $w_return;
    }


    static function from_date_for_day00($time, $type = "jp", $length = 3, $figure = 2, $year_type = true)
    {
        $time_a = explode("-", $time);
        $time_new = $time_a[0] . "-" . $time_a[1] . "-01";
        return self::from_date($time_new, $type, $length, $figure, $year_type);
    }

    static function from_db_datetime_to_timearray($datetime)
    {
        /* ========================================================
         * データベースのdatetimeの値を配列に置き換える関数

         * ====================================================== */

        list($before, $after) = explode(" ", $datetime);
        $array_before = explode("-", $before);
        $array_after = explode(":", $after);

        return array_merge($array_before, $array_after);

    }

    static function from_time($time, $type = "jp", $length = 2, $figure = 2)
    {
        /* ========================================================
 * データベースのTIMEの値を表示用の日付に変更する関数
 * $type jp　日本語表示　y年m月d日 else  スラッシュ表示　y/m/d
 * $length どこまで表示するか
 * 1 時 まで
 * 2 分まで
 * 3 秒まで
 * * $figure 最低桁数　$figure　1なら9:35  2なら　09:35
 * ====================================================== */

        if ($time == "") {
            return "";
        } else {
            list($h, $i, $s) = explode(":", $time);
        }

        if ($type == "jp") {
            $h_unit = "時";
            $i_unit = "分";
            $s_unit = "秒";
        } else {
            $y_unit = ":";
            $m_unit = ":";
            $d_unit = "";
        }

        if ($length >= 1 && $figure == 2) {
            $his .= $h . $h_unit;
        } elseif ($length >= 1) {
            $his .= number_format($h) . $h_unit;
        }
        if ($length >= 2 && $figure == 2) {
            $his .= $i . $i_unit;
        } elseif ($length >= 2) {
            $his .= number_format($i) . $i_unit;
        }
        if ($length >= 3 && $figure == 2) {
            $his .= $s . $s_unit;
        } elseif ($length >= 3) {
            $his .= number_format($s) . $s_unit;
        }

        return $his;
    }

    static function His_minute_convert($his, $from = "his")
    {
        //H:i:s型式を分数に変換
        //その逆も行う

        if ($from == "his") {
            //Hisから秒へ
            list($h, $i, $s) = explode(":", $his);
            $result = $h * 60 + $i; //$sは切り捨て
        } else {
            //分からHisへ

            $hours = floor($his / 60);
            $minutes = floor(($his % 60));
            $seconds = $s;

            $result = sprintf("%02d:%02d:%02d", $hours, $minutes, $seconds);


        }
        return $result;
    }


}

class gengo_class
{

    static function to_gengo_from_db_date($date, $return_type = "str")
    {
        /**
         * $return_type デフォルトは、文字列　平成○年○月○日
         *　array なら配列のまま返す
         */

        $date_array = explode("-", $date);
        $gengo_array = self::to_gengo_from_year($date_array[0]);

        if ($date_array[2]) {
            $matsubi = "日";
        }
        if ($return_type == "str") {
            return $gengo_array['gengo'] . $gengo_array['year'] . "年" . $date_array[1] . "月" . $date_array[2] . $matsubi;
        } elseif ($return_type == "array") {
            $return_array = array(
                "gengo" => $gengo_array['gengo'],
                "y"     => $gengo_array['year'],
                "m"     => $date_array[1],
                "d"     => $date_array[2]
            );
            return $return_array;

        }


    }

    static function to_gengo_from_db_date_short($date)
    {

        $date_array = explode("-", $date);
        $gengo_array = self::to_gengo_from_year($date_array[0]);

        return $gengo_array['year'] . "/" . $date_array[1] . "/" . $date_array[2] . "";

    }

    static function to_gengo_from_year($year)
    {
        $year = intval($year);
        $str = $gengo = $y = "";

        if (1869 <= $year && $year < 1912) {
            $gengo = "明治";
            $y = $year - 1869 + 1;
            if ($year == 1869) {
                $str = "元";
            }
        } else if (1912 <= $year && $year < 1926) {
            $gengo = "大正";
            $y = $year - 1912 + 1;
            if ($year == 1912) {
                $str = "元";
            }
        } else if (1926 <= $year && $year < 1989) {
            $gengo = "昭和";
            $y = $year - 1926 + 1;
            if ($year == 1926) {
                $str = "元";
            }
        } else if (1989 <= $year) {
            $gengo = "平成";
            $y = $year - 1989 + 1;
            if ($year == 1989) {
                $str = "元";
            }
        }


        if (!$str) {
            $str = sprintf('%s%s', $gengo, strval($y));
        }


        return array(
            'gengo' => $gengo,
            'str'   => $str,
            'year'  => $y,
        );
    }

}

class Make_file_class
{

    static function make_file($file_pathname, $file_data, $encode = 'Shift_JIS')
    {

        $file_data_encode = mb_convert_encoding($file_data, $encode, "auto");

        //ファイル名
        $filename = end(explode("/", $file_pathname));
        $file = fopen($file_pathname, "at") or die("file open error"); //ファイルロック（排他的ロック：LOCK_EX）
        flock($file, LOCK_EX); //データをファイルに書き込む
        fputs($file, $file_data_encode . "\n"); //ファイルロック解除（ロック解除：LOCK_UN）
        flock($file, LOCK_UN); //ファイルクローズ
        fclose($file); //＊＊＊　ここまででStep1終了　＊＊＊＊＊＊＊＊＊＊＊＊

    }

    static function download_file($file_pathname, $unlink = true)
    {

        if (!is_file($file_pathname)) {
            exit;
        }
        //ファイル名
        $filename = end(explode("/", $file_pathname));

////HTTPヘッダー出力


        header('Content-Disposition: attachment; filename="' . basename($file_pathname) . '"');
        header('Content-Type: application/octet-stream');
        header('Content-Transfer-Encoding: binary');
        header('Content-Length: ' . filesize($file_pathname));

        readfile($file_pathname); // ファイルを読み込んでHTTP出力

        if ($unlink) {
            unlink($file_pathname);
        }

        if ($_GET['ob']) {
            ob_end_flush();
        }
    }

}

class sanitize_class
{

    static function sanitize_array($param)
    {
        $param_new = array();
        if (is_array($param) !== false) { //配列なら
            foreach ($param as $key => $value) {
                if (is_array($value) !== false) {
                    $param_new[$key] = sanitize_class::sanitize_array($value);
                } else {
                    $param_new[$key] = htmlspecialchars($value, ENT_QUOTES, "utf-8");
                }
            }
        }
        return $param_new;
    }

}

class DB_data
{

    static function get_data_from_primary_no($table_name, $no, $search_column = "no", $get_column = "*")
    {

        //プライマリーNOでデータを検索して持ってくる
        //簡易利用は引数２つのみ（テーブル名、検索No.
        //検索対象と、持ってくるデータも変更できる。

        $db = new Sql_class3;
        $db->select($table_name, $get_column);
        $db->search($search_column, $no, true);
        $db->sql_query(true);
        $db->mysql_fetch_assoc();
//        $db->view();

        return $db->data;


    }

    static function get_roop_data_array($table, $key, $value, $search_array = false)
    {
        /**
         * DBデータを配列のキーと値に入れて返す（2項目のみ返す）Form::pulldown_write_usekeyなど用
         * @param strings $tabie 取得するテーブル
         * @param strings $key 返り値の配列のキーに格納したいカラム
         * @param strings $value 返り値の配列のvalueに格納したいカラム
         * @param strings $search_array 指定があれば、検索対象とする　key => カラム value => 検索語句 like検索不可
         */

        $return_array = array();
        $db = new Sql_class3;
        $db->select($table);
        if (is_array($search_array) !== false) {
            foreach ($search_array as $key_d => $value_d) {
                $db->search($key_d, $value_d, false);
            }
        }
        $db->sql_query(true);
        while ($data = mysql_fetch_assoc($db->res)) {
            $return_array[$data[$key]] = $data[$value];
        }

        return $return_array;
    }

}