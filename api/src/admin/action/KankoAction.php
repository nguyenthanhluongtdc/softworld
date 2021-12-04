<?php

/**
 * */
require_once ROOT_PATH_DAO . "/MProjectDao.php";

class KankoAction extends BaseAction {

    public function rules() {
        return array(
            "search" => array("post", "get")
        );
    }

    public function render() {
        // set url for screen
        $this->setAttribute("urlSearch", ActionUtil::getActionUrl(PageIdConstants::KANKO, "search"));
        $this->setAttribute("urlEdit", ActionUtil::getActionUrl(PageIdConstants::PROJECT, "edit"));
    }

    public function index() {

        $this->search();
    }

    public function search() {
        $currentyear = ParamsUtil::getQueryParamNumeric("year");
        $currentmonth = ParamsUtil::getQueryParamNumeric("month");
        $type = ParamsUtil::getQueryParam("type");
        $project = new MProjectDao();
        $month = date("m");
        $year = date("Y");
        $date = $year.'-'.$month.'-'.'01';
        if(!StringUtil::isNullOrEmpty($type)||!StringUtil::isNullOrEmpty($currentmonth)||!StringUtil::isNullOrEmpty($currentyear)){
            if($type=="next"){
                $action = '+';
            }
            elseif($type=="preview"){
                $action = '-';
            }
            else{
                ActionUtil::redirect(PageIdConstants::KANKO,'index');
            }
            if($currentmonth < 10)
            {
                $currentmonth = '0'.$currentmonth;
            }
            $date_get = $currentyear."-".$currentmonth."-01";
            $date  = DateUtil::SubAddMonth($date_get,$action,1);
            $month = explode('-', $date);
            $month = $month[1];
            $year  = explode('-', $date);
            $year  = $year[0];
        }
        
        $one_year_ago = DateUtil::SubAddYear($date,'-',1);
        $five_year_ago = DateUtil::SubAddYear($date,'-',5);
        $nine_year_ago = DateUtil::SubAddYear($date,'-',9);
        $thirteen_year_ago = DateUtil::SubAddYear($date,'-',13);
        /*check authority data*/
        $role = $this->role;
        $staff_id = null;
        if(!in_array(4,$role) && !in_array(5,$role))//if not 案件管理 
        {
            $staff_id = $this->login_id;
        }
        $lsKanko_1  = $project->getPeriodically($month, $one_year_ago, $staff_id);
        $lsKanko_5  = $project->getPeriodically($month, $five_year_ago, $staff_id);
        $lsKanko_9  = $project->getPeriodically($month, $nine_year_ago, $staff_id);
        $lsKanko_13 = $project->getPeriodically($month, $thirteen_year_ago, $staff_id);

        $c1 = count($lsKanko_1);
        $c2 = count($lsKanko_5);
        $c3 = count($lsKanko_9);
        $c4 = count($lsKanko_13);

        $max = max($c1, $c2, $c3, $c4);
        $this->setAttribute("max", $max);
        $this->setAttribute("lsKanko_1", $lsKanko_1);
        $this->setAttribute("lsKanko_5", $lsKanko_5);
        $this->setAttribute("lsKanko_9", $lsKanko_9);
        $this->setAttribute("lsKanko_13", $lsKanko_13);
        $this->setAttribute("month", $month);
        $this->setAttribute("year", $year);
        $this->setView("view.php");
    }
}

?>