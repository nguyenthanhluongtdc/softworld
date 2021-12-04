
<?php

class AppConfig {

    public static $SELECT_DB = 'local';
    
    public static $DB_CONFIG = array(
        'local' => array(
            'host' => 'localhost'
            , 'user' => 'root'
            , 'password' => ''
            , 'db' => 'db_sw'
            , 'encoding' => 'utf8'
        )
        , 'publish' => array(
            'host' => 'localhost'
            , 'user' => 'softworl_seiyo'
            , 'password' => 'SvkZ0hPH'
            , 'db' => 'softworl_seiyo'
            , 'encoding' => 'utf8'
        )
    );
    
    // ユーザー権限
    public static $USER_NORMAL = 0;
    // 管理者権限
    public static $USER_ADMIN = 1;

    public static $PAGE_NOT_REQUIRE_AUTHORITY = array(
        PageIdConstants::LOGIN => "聖陽 WEB管理システム － ログイン"
        , PageIdConstants::ERROR => "聖陽 WEB管理システム"
    );

    public static $SECURITY_KEY = "123456";

    public static $R_ROLE_PAGE = array(
        // "社員管理&nbsp;&nbsp;&nbsp;&nbsp;[管理者向け]"
        1 => array(
            PageIdConstants::INDEX => "社員管理"
            , PageIdConstants::HISTORY => "案件変更履歴"
            , PageIdConstants::STAFF => "社員管理"
        )
        // "事業所管理&nbsp;&nbsp;[管理者向け] "
        , 2 => array(
            PageIdConstants::INDEX => "管理画面トップ 案件変更履歴 未承認一覧"
            , PageIdConstants::OFFICE => "事業所管理"
            , PageIdConstants::HISTORY => "案件変更履歴"
            /*, PageIdConstants::STAFF => "社員管理"
            , PageIdConstants::OFFICE => "事業所管理"
            , PageIdConstants::PROJECT => "案件検索"
            , PageIdConstants::PAYMENT => "入金状況検索"
            , PageIdConstants::KANKO => "定期点検リスト"
            , PageIdConstants::INCENTIVE => "歩合集計"
            , PageIdConstants::HISTORY => "案件変更履歴"
            , PageIdConstants::DOWNLOAD => "download"
            , PageIdConstants::FILEHISTORY => "filehistory"*/
        )
        //"案件管理&nbsp;&nbsp;&nbsp;&nbsp;[一般]（担当分のみ）"
        , 3 => array(
            PageIdConstants::INDEX => "管理画面トップ 案件変更履歴 未承認一覧"
            , PageIdConstants::HISTORY => "案件変更履歴"
            , PageIdConstants::PROJECT => "案件検索"
            #, PageIdConstants::PAYMENT => "入金状況検索"
            , PageIdConstants::KANKO => "定期点検リスト"
            , PageIdConstants::DOWNLOAD => "download"
            , PageIdConstants::KANKO => "定期点検リスト"
            , PageIdConstants::FILEHISTORY => "filehistory"
        )
        //"案件管理&nbsp;&nbsp;&nbsp;&nbsp;[管理者向け]（全案件）"
        , 4 => array(
            PageIdConstants::INDEX => "管理画面トップ 案件変更履歴 未承認一覧"
            , PageIdConstants::HISTORY => "案件変更履歴"
            , PageIdConstants::PROJECT => "案件検索"
            #, PageIdConstants::PAYMENT => "入金状況検索"
            , PageIdConstants::KANKO => "定期点検リスト"
            , PageIdConstants::DOWNLOAD => "download"
            , PageIdConstants::KANKO => "定期点検リスト"
            , PageIdConstants::FILEHISTORY => "filehistory"
        )
        //"案件管理&nbsp;&nbsp;&nbsp;&nbsp;[管理者向け]（仕切値閲覧・修正可）"
        , 5 => array(
            PageIdConstants::INDEX => "管理画面トップ 案件変更履歴 未承認一覧"
            , PageIdConstants::HISTORY => "案件変更履歴"
            , PageIdConstants::PROJECT => "案件検索"
            #, PageIdConstants::PAYMENT => "入金状況検索"
            , PageIdConstants::KANKO => "定期点検リスト"
            , PageIdConstants::DOWNLOAD => "download"
            , PageIdConstants::KANKO => "定期点検リスト"
            , PageIdConstants::FILEHISTORY => "filehistory"
        )
        //"歩合管理&nbsp;&nbsp;&nbsp;&nbsp;[管理者向け]"
        , 6 => array(
            PageIdConstants::INDEX => "管理画面トップ 案件変更履歴 未承認一覧"
            , PageIdConstants::HISTORY => "案件変更履歴"
            , PageIdConstants::INCENTIVE => "歩合集計"
        )

        //入金状況検索&nbsp;&nbsp;&nbsp;&nbsp;[一般]（担当分のみ）
        ,7 => array(
            PageIdConstants::PAYMENT => '入金状況検索'
        )

        //入金状況検索&nbsp;&nbsp;&nbsp;&nbsp;[管理者向け]（全案件）
        ,8 => array(
            PageIdConstants::PAYMENT => '入金状況検索'
        ),9 => array(
            PageIdConstants::EVENT => '入金状況検索'
        )
    );
    
    public static $MAIL_SETTING = array(
        "MAIL_USERNAME"         => ""//SMTPアカウント
        , "MAIL_PASSWORD"       => ""//SMTPパスワード
        , "MAIL_ITEM_NAME"      => "mime.qpheaderencoder"//エンコード設定
        , "MAIL_LOOK_UP"        => "mime.base64headerencoder"//エンコード設定
        , "MAIL_CHARSET"        => "iso-2022-jp"//メールメッセージCharset
        , "MAIL_IP"             => "localhost" //"173.194.65.108"//SMTPサーバ
        , "MAIL_PORT"           => 25//25//465//SMTPポート
        , "MAIL_SECURITY"       => ""//"ssl"//送信メソッド
        , "MAIL_SENDER_NAME"    => "SEIYOU"//送信表示名前
        , "MAIL_FROM"           => "info@seiyou.com"//送信アドレス
    );
	//Mail template 案件登録メール
	public static $PROJECT_ADDED_MAIL="聖陽 WEB管理システム
{0} 様

【{1}】お客様の案件が登録されましたのでご確認してください。

このメールは「案件変更メール」がチェックしたため送信します。";
	//案件更新メール
	public static $PROJECT_UPDATED_MAIL_TITLE = "【案件変更通知】聖陽WEB管理システム";
    public static $PROJECT_UPDATED_MAIL="{0}様

下記の案件について変更がありましたので通知いたします。
管理画面にログインしてトップページの「案件変更履歴 未承認一覧」から
内容を確認して下さい。

案件ID： {1}
お客様名：{2}様
変更内容：
{3}

※このメールは送信専用メールアドレスです。
返信しても届きませんのご注意下さい。
※不明点がございましたら管理者までご連絡下さい。";

    //キャンセル日
    public static $PROJECT_ADD_KYANCERUDATE_TITLE   = "【案件キャンセル通知】聖陽WEB管理システム";
    public static $PROJECT_ADD_KYANCERUDATE         = "{0}様

下記の案件のステータスがキャンセルに変更されましたので通知いたします。

案件ID： {1}
お客様名：{2}様

※このメールは送信専用メールアドレスです。
返信しても届きませんのご注意下さい。
※不明点がございましたら管理者までご連絡下さい。";
	
    // Allow file extension
    public static $FILE_UPLOAD_EXTENSION     = array('pdf', 'doc', 'docx', 'txt', 'xls', 'xlsx', 'csv');
    
    //各種書類履歴
    public static $FILE_UPLOAD_EXTENSION_PDF = array('xml' => '.xml','exe' => '.exe','vbs' => '.vbs');
    
    //見積履歴
    public static $FILE_UPLOAD_EXTENSION_CSV = array('xml' => '.xml','exe' => '.exe','vbs' => '.vbs');
    
    // file size 10MB
    public static $FILE_UPLOAD_MAX_SIZE = 10485760;
    
    public static $REPORTS = array(
        ReportIdConstants::PAYMENTREPORT => "店舗別請求一覧表",
        ReportIdConstants::PRODUCTREPORT => "個別管理表",
    );
    public static $LIST_PAGE_SIZE = array(
        "5" => "5"
        , "20" => "20"
        , "100" => "100"
        , "200" => "200"
    );
    public static $DEFAULT_PAGE_SIZE = "20";
    //社員登録 部署
    public static $STAFF_DEPARTMENT_ID = array(
        "1" => "社長室"
        , "2" => "経理"
        , "3" => "営業"
        , "4" => "工事部"
        , "5" => "総務"
    );
    //権限
    public static $USER_ROLE = array(
          "1" => "社員管理&nbsp;&nbsp;&nbsp;&nbsp;[管理者向け]"
        , "2" => "事業所管理&nbsp;&nbsp;[管理者向け] "
        , "3" => "案件管理&nbsp;&nbsp;&nbsp;&nbsp;[一般]（担当分のみ）"
        , "4" => "案件管理&nbsp;&nbsp;&nbsp;&nbsp;[管理者向け]（全案件）"
        , "7" => "入金状況検索&nbsp;&nbsp;&nbsp;&nbsp;[一般]（担当分のみ）"
        , "8" => "入金状況検索&nbsp;&nbsp;&nbsp;&nbsp;[管理者向け]（全案件）"
        , "5" => "案件管理&nbsp;&nbsp;&nbsp;&nbsp;[管理者向け]（仕切値閲覧・修正可）"
        , "6" => "歩合管理&nbsp;&nbsp;&nbsp;&nbsp;[管理者向け]"
    );
    //都道府県
    public static $PREFECTURE = array(
        "1" => "北海道"
        , "2" => "青森県"
        , "3" => "岩手県"
        , "4" => "宮城県"
        , "5" => "秋田県"
        , "6" => "山形県"
        , "7" => "福島県"
        , "8" => "茨城県"
        , "9" => "栃木県"
        , "10" => "群馬県"
        , "11" => "埼玉県"
        , "12" => "千葉県"
        , "13" => "東京都"
        , "14" => "神奈川県"
        , "15" => "山梨県"
        , "16" => "長野県"
        , "17" => "新潟県"
        , "18" => "富山県"
        , "19" => "石川県"
        , "20" => "福井県"
        , "21" => "岐阜県"
        , "22" => "静岡県"
        , "23" => "愛知県"
        , "24" => "三重県"
        , "25" => "滋賀県"
        , "26" => "京都府"
        , "27" => "大阪府"
        , "28" => "兵庫県"
        , "29" => "奈良県"
        , "30" => "和歌山県"
        , "31" => "鳥取県"
        , "32" => "島根県"
        , "33" => "岡山県"
        , "34" => "広島県"
        , "35" => "山口県"
        , "36" => "徳島県"
        , "37" => "香川県"
        , "38" => "愛媛県"
        , "39" => "高知県"
        , "40" => "福岡県"
        , "41" => "佐賀県"
        , "42" => "長崎県"
        , "43" => "熊本県"
        , "44" => "大分県"
        , "45" => "宮崎県"
        , "46" => "鹿児島県"
        , "47" => "沖縄県"
    );
    //年
    public static $YEAR = array(
        '0'=>''
        , "2005" => "2005"
		, "2006" => "2006"
		, "2007" => "2007"
		, "2008" => "2008"
		, "2009" => "2009"
		, "2010" => "2010"
		, "2011" => "2011"
		, "2012" => "2012"
		, "2013" => "2013"
		, "2014" => "2014"
		, "2015" => "2015"
        , "2016" => "2016"
        , "2017" => "2017"
        , "2018" => "2018"
		, "2019" => "2019"
		, "2020" => "2020"
    );
    //月
    public static $MONTH = array(
        '0'=>'',
         "01" => "01"
        , "02" => "02"
        , "03" => "03"
        , "04" => "04"
        , "05" => "05"
        , "06" => "06"
        , "07" => "07"
        , "08" => "08"
        , "09" => "09"
        , "10" => "10"
        , "11" => "11"
        , "12" => "12"
    );
    //日
    public static $DATE = array(
        "0" => ""
        , "01" => "01"
        , "02" => "02"
        , "03" => "03"
        , "04" => "04"
        , "05" => "05"
        , "06" => "06"
        , "07" => "07"
        , "08" => "08"
        , "09" => "09"
        , "10" => "10"
        , "11" => "11"
        , "12" => "12"
        , "13" => "13"
        , "14" => "14"
        , "15" => "15"
        , "16" => "16"
        , "17" => "17"
        , "18" => "18"
        , "19" => "19"
        , "20" => "20"
        , "21" => "21"
        , "22" => "22"
        , "23" => "23"
        , "24" => "24"
        , "25" => "25"
        , "26" => "26"
        , "27" => "27"
        , "28" => "28"
        , "29" => "29"
        , "30" => "30"
        , "31" => "31"
    );
    //ステータス
    public static $PROJECT_STATUS = array(
        "1" => "見積提出"
        , "2" => "仮契約"
        , "3" => "本契約"
        , "4" => "キャンセル"
    );
    //メーカー 
    public static $MAKER = array(
        "1" => "パナソニック"
        , "2" => "メーカー2"
        , "3" => "メーカー3"
        , "4" => "メーカー4"
        , "5" => "メーカー5"
    );
    //契約種別
    public static $CONTRACT = array(
        "0" => "未選択"
        , "1" => "余剰10"
        , "2" => "余剰20"
        , "3" => "全量"
        , "4" => "OD"
        , "5" => "工事"
        , "6" => "蓄電池"
        , "7" => "車庫"
        , "8" => "リフォーム"
        , "9" => "増設余剰10"
        , "10" => "増設余剰20"
        , "11" => "増設全量"
        , "12" => "新築"
    );
    //車庫
    public static $GARAGE = array(
        "0" => "なし"
        , "1" => "日創車庫"
        , "2" => "AA車庫"
        , "3" => "BB車庫"
        , "4" => "CC車庫"
        , "5" => "DD車庫"
        , "6" => "EE車庫"
        , "7" => "FF車庫"
    );
    //PV
    public static $PV = array(
        "1" => "PV"
    );
    //OD
    public static $OD = array(
        "1" => "EQ"
        , "2" => "IH"
    );
    //Upload File Size
    public static $UPLOAD_FILE_MAX_SIZE = 10485760; //10M
    //各種書類アップロード 種別
    public static $DOCS_TYPE = array(
        "1" => "契約書"
        , "2" => "現調"
        , "3" => "見積書"
        , "4" => "申請書"
        , "5" => "その他"
    );
    //prj_file_type
    public static $FILE_TYPE_DOCS = 1; //各種書類履歴
    public static $FILE_TYPE_ESTIMATE = 2; //見積履歴
    public static $DOCS_FOLDER = "docs"; //各種書類履歴
    public static $ESTIMATE_FOLDER = 'estimates'; //見積履歴
    //商品情報 商品名  prj_prod_info prj_prod_type
    public static $PRODUCT_NAME_TYPE = array(
        "1" => "工事"
        , "2" => "整地"
        , "3" => "他"
    );
    //商品名 prj_prod_class_nm
    //fragment2
    //sort_id
    //prj_prod_class
    //prj_prod_class_nm
    public static $SORT_ID = array(
        1 => array(1, 1, 'モジュール1')
        , 2 => array(2, 1, 'モジュール2')
        , 3 => array(3, 1, 'モジュール3')
        , 4 => array(1, 2, '架台')
        , 5 => array(1, 3, 'パワコン1')
        , 6 => array(2, 3, 'パワコン2')
        , 7 => array(3, 3, 'パワコン3')
        , 8 => array(1, 4, '接続箱/昇圧機1')
        , 9 => array(2, 4, '接続箱/昇圧機2')
        , 10 => array(3, 4, '接続箱/昇圧機3')
        , 11 => array(1, 5, 'モニター1')
        , 12 => array(2, 5, 'モニター2')
        , 13 => array(1, 6, 'CT')
        , 14 => array(1, 7, 'エコキュート')
        , 15 => array(1, 8, 'IH')
        , 16 => array(1, 9, 'その他機器')
        , 17 => array(1, 10, null)
        , 18 => array(2, 10, null)
        , 19 => array(3, 10, null)
        , 20 => array(4, 10, null)
        , 21 => array(5, 10, null)
        , 22 => array(6, 10, null)
        , 23 => array(1, 11, '値引')
        , 24 => array(1, 12, 'サービス料値引')
        , 25 => array(1, 13, '工事負担金立替分')
    );
    //支払い方法
    public static $METHOD_PAYMENT = array(
        "1" => "未定"
        , "2" => "現金"
        , "3" => "クレジット"
    );
    //準備ID
    public static $FILE_TYPE_SORTID = array(1, 2, 3, 4, 5, 6);
    //担当順番

    //担当種別
    public static  $ROLE_GROUP = array(
         "0" => "未選択"
        , "1" => "担当営業"
        , "2" => "クローザー"
        , "3"=>"紹介者"
    );
    public static  $ROLE_GROUP_SEARCH = array(
         "0" => "未選択"
        , "1" => "担当営業"
        , "2" => "クローザー"
    );
    //prj_staff_pos
    public static $STAFF_POS = array(
        "1" => array(1, 1, "担当営業")
        , "2" => array(1, 2, "担当営業")
        , "3" => array(1, 3, "担当営業")
        , "4" => array(1, 4, "担当営業")
        , "5" => array(2, 1, "クローザー")
        , "6" => array(2, 2, "クローザー")
        , "7" => array(2, 3, "クローザー")
        , "8" => array(3, 1, "紹介者")
        , "9" => array(3, 2, "紹介者")
        , "10" => array(3, 3, "紹介者")
    );
    public static $STATUS_PAYMENT = array(
        "1" => "未入金（入金予定日前）有"
        , "2" => "未入金（延滞）有"
        , "3" => "入金済み有"
        ,"4" =>"工事負担金立替分 未入金有　"
    );
    //並び順
    public static  $VIEW =array(
        '1'=>'案件順（入力画面）',
        '2'=>'社員順（閲覧のみ）'
    );

    //案件変更履歴 書類等処理
    public static $HISTORY_APPROVE = array(
        '1' => '変更後の契約書コピー'
        ,'2' => '変更後の見積書'
        ,'3' => '変更後のレイアウト'
        ,'4' => '変更後の個別管理表　（不要？）'
        ,'5' => 'Share 各拠点データ更新'
        ,'6' => 'クレジットカード'
    );

    //変更内容
    public static $HISTORY_CHANGE = array(
        '1' => '契約日'
        ,'2' => 'モジュール'
        ,'3' => '枚数'
        ,'4' => '設備容量'
        ,'5' => 'パワコン型式'
        ,'6' => 'パワコン 台数'
        ,'7' => '接続箱型式'
        ,'8' => '接続箱 台数'
        ,'9' => 'モニター型式'
        ,'10' => 'モニター 台数'
        ,'11' => '合計金額'
        ,'12' => 'その他'
    );
    public static $PAY = array(
        '銀行名' => '群馬銀行',
        '支店' => '板倉支店',
        '科目' => '普通',
        '口座番号' => '0426487'
        
    );

    public static $COMISSION_MAX_ALLOW_RESULT = 1000;
}
?>

