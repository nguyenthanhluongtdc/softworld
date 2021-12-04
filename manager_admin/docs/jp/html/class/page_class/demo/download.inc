<?php


class download extends default_admin_class
{


    function __construct()
    {

        parent::__construct();

        $this->search_ym = $GLOBALS['GET']['date_y'] . "-" . sprintf("%02d", $GLOBALS['GET']['date_m']);
        $this->search_yymmmm = $GLOBALS['GET']['date_y'] . "" . sprintf("%02d", $GLOBALS['GET']['date_m']);
    }

    function seikyu()
    {





        $filepath = REQUIRE_PAGECLASS_PATH . '/demo/' ;
        $filename = "seikyu.pdf";
        $output = $filepath . $filename;

        // メモリからダウンロードさせる
        header("Content-Type: application/pdf");
        header("Content-disposition: attachment; filename=$filename");
        header("Content-Length: " . filesize($output));

// 処理終了
        readfile($output);
//        print file_get_contents($output);

        exit;
    }



}