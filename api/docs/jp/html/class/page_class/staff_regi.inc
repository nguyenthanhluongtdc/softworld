<?php


class staff_regi extends default_admin_class
{
    var $before_date_y;

    function __construct()
    {
        require_once REQUIRE_PATH . '/site_class/get_db_data.inc';
        require_once REQUIRE_PATH . '/site_class/service_class.inc';
        require_once REQUIRE_PATH . '/pageclass/service_class.inc';
        parent::__construct();

        $GLOBALS['GET']['service_no'] = get_other_data::get_default_table_no($GLOBALS['GET']['table']);
        $this->table_name_array = get_other_data::get_servicetype_tablename($GLOBALS['GET']['service_no']);
        $this->search_ym = $GLOBALS['GET']['date_y'] . "-" . sprintf("%02d", $GLOBALS['GET']['date_m']);
        $this->search_yymmmm = $GLOBALS['GET']['date_y'] . "" . sprintf("%02d", $GLOBALS['GET']['date_m']);
    }

    function main(){

        ?>

        <?php

    }


}