<?php
/**
*
*/
require_once ROOT_PATH_COMMON . "/MessageConstants.php";
require_once ROOT_PATH_DAO . "/MPrjProdDao.php";
require_once ROOT_PATH_DAO . "/MProjectDao.php";
require_once ROOT_PATH_DAO . "/MPrjAssignInfoDao.php";

class ProductreportAction extends BaseReportAction {
    protected function options() {
        return array(
            'orientation' => 'L'
        );
    }

	public function validate() {
		$validateOpts = array(
            
        );
        $this->validate->validates($validateOpts);
        return array(
            "result" => !$this->validate->hasError()
            , "errors" => $this->validate->getErrors()
        );
	}

	public function process() {
		$prj_id = ParamsUtil::getQueryParam("prj_id");
		$prjproddao = new MPrjProdDao();
        $MProjectDao = new MProjectDao();
        $PrjAssign = new MPrjAssignInfoDao();
        $prjdetail = $MProjectDao->getById($prj_id);
        $prjprods = $prjproddao->GetAllProdDao($prj_id);
        $reportData = array();
        $reportData['valuenumber_1'] = $prjdetail['prj_cust_name'];
        $reportData['valuenumber_2'] = $prjdetail['prj_keiyaku_bi'];
        $reportData['valuenumber_3_1'] = $prjdetail['prj_cust_pos_code'];
        $reportData['valuenumber_3_2'] = AppConfig::$PREFECTURE[$prjdetail['prj_cust_prefectures']] . $prjdetail['prj_cust_city'] . $prjdetail['prj_cust_address'] . ' ' . $prjdetail['prj_cust_mansion_info'];
        $reportData['valuenumber_4'] = $prjdetail['prj_gencho_bi'];
        $reportData['valuenumber_7'] = $prjdetail['prj_cust_phone_num'];
        $reportData['valuenumber_8'] = AppConfig::$PV[$prjdetail['prj_kind_pv']];
        $staff = $PrjAssign->GetStaffAssign($prj_id,1,1);
        $reportData['valuenumber_5'] = ArrayUtil::isNullOrEmpty($staff) ? '' : $staff['staff_name'];
        $arraykindod = explode(',',$prjdetail['prj_kind_od']);
        $reportData['valuenumber_10'] = '';
        foreach ($arraykindod as $oddata){
            $reportData['valuenumber_10'] .= $reportData['valuenumber_10'] == '' ? AppConfig::$OD[$oddata] : ',' . AppConfig::$OD[$oddata];
        }
        $checkedarr = ParamsUtil::getQueryParam("checked");
        if (StringUtil::isNullOrEmpty($checkedarr))
            $checkedarr = array();
        else
            $checkedarr = explode('|',$checkedarr);
        for ($i=0;$i<sizeof($prjprods);$i++){
            if ($prjprods[$i]['sort_id'] == 1 && $prjprods[$i]['prj_prod_class'] == 1 && in_array(1,$checkedarr))
            {
                $prj_prod_maker_row1 = AppConfig::$MAKER[$prjprods[$i]['prj_prod_maker']] ;
                $prj_prod_model_row1 = $prjprods[$i]['prj_prod_model'];
                $prj_prod_num_row1 = $prjprods[$i]['prj_prod_num'];
                $prj_prod_kw1 = $prjprods[$i]['prj_prod_kw'];
            }
            if ($prjprods[$i]['sort_id'] == 2 && $prjprods[$i]['prj_prod_class'] == 1 && in_array(2,$checkedarr))
            {
                $prj_prod_maker_row2 = AppConfig::$MAKER[$prjprods[$i]['prj_prod_maker']];
                $prj_prod_num_row2 = $prjprods[$i]['prj_prod_num'];
                $prj_prod_model_row2 = $prjprods[$i]['prj_prod_model'];
            }
            if ($prjprods[$i]['sort_id'] == 3 && $prjprods[$i]['prj_prod_class'] == 1 && in_array(3,$checkedarr))
            {
                $prj_prod_maker_row3 = AppConfig::$MAKER[$prjprods[$i]['prj_prod_maker']];
                $prj_prod_num_row3 = $prjprods[$i]['prj_prod_num'];
                $prj_prod_model_row3 = $prjprods[$i]['prj_prod_model'];
            }
            if ($prjprods[$i]['sort_id'] == 1 && $prjprods[$i]['prj_prod_class'] == 2 && in_array(4,$checkedarr))
            {
                $prj_prod_maker_row4 = AppConfig::$MAKER[$prjprods[$i]['prj_prod_maker']];
                $prj_prod_num_row4 = $prjprods[$i]['prj_prod_num'];
                $prj_prod_model_row4 = $prjprods[$i]['prj_prod_model'];
                $prj_prod_memo_row4 = $prjprods[$i]['prj_prod_memo'];
            }
            if ($prjprods[$i]['sort_id'] == 1 && $prjprods[$i]['prj_prod_class'] == 3 && in_array(5,$checkedarr))
            {
                $prj_prod_maker_row5 = AppConfig::$MAKER[$prjprods[$i]['prj_prod_maker']];
                $prj_prod_num_row5 = $prjprods[$i]['prj_prod_num'];
                $prj_prod_model_row5= $prjprods[$i]['prj_prod_model'];
                $prj_prod_memo_row5 = $prjprods[$i]['prj_prod_memo'];
            }
            if ($prjprods[$i]['sort_id'] == 2 && $prjprods[$i]['prj_prod_class'] == 3 && in_array(6,$checkedarr))
            {
                $prj_prod_maker_row6 = AppConfig::$MAKER[$prjprods[$i]['prj_prod_maker']];
                $prj_prod_num_row6 = $prjprods[$i]['prj_prod_num'];
                $prj_prod_model_row6= $prjprods[$i]['prj_prod_model'];
                $prj_prod_memo_row6 = $prjprods[$i]['prj_prod_memo'];
            }
            if ($prjprods[$i]['sort_id'] == 3 && $prjprods[$i]['prj_prod_class'] == 3 && in_array(7,$checkedarr))
            {
                $prj_prod_maker_row7 = AppConfig::$MAKER[$prjprods[$i]['prj_prod_maker']];
                $prj_prod_num_row7 = $prjprods[$i]['prj_prod_num'];
                $prj_prod_model_row7 = $prjprods[$i]['prj_prod_model'];
                $prj_prod_memo_row7 = $prjprods[$i]['prj_prod_memo'];
            }
            if ($prjprods[$i]['sort_id'] == 1 && $prjprods[$i]['prj_prod_class'] == 4 && in_array(8,$checkedarr))
            {
                $prj_prod_maker_row8 = AppConfig::$MAKER[$prjprods[$i]['prj_prod_maker']];
                $prj_prod_num_row8 = $prjprods[$i]['prj_prod_num'];
                $prj_prod_model_row8 = $prjprods[$i]['prj_prod_model'];
                $prj_prod_memo_row8 = $prjprods[$i]['prj_prod_memo'];
            }
            if ($prjprods[$i]['sort_id'] == 2 && $prjprods[$i]['prj_prod_class'] == 4 && in_array(9,$checkedarr))
            {
                $prj_prod_maker_row9 = AppConfig::$MAKER[$prjprods[$i]['prj_prod_maker']];
                $prj_prod_num_row9 = $prjprods[$i]['prj_prod_num'];
                $prj_prod_model_row9 = $prjprods[$i]['prj_prod_model'];
                $prj_prod_memo_row9 = $prjprods[$i]['prj_prod_memo'];
            }
            if ($prjprods[$i]['sort_id'] == 3 && $prjprods[$i]['prj_prod_class'] == 4 && in_array(10,$checkedarr))
            {
                $prj_prod_maker_row10 = AppConfig::$MAKER[$prjprods[$i]['prj_prod_maker']];
                $prj_prod_num_row10 = $prjprods[$i]['prj_prod_num'];
                $prj_prod_model_row10 = $prjprods[$i]['prj_prod_model'];
                $prj_prod_memo_row10 = $prjprods[$i]['prj_prod_memo'];
            }
            if ($prjprods[$i]['sort_id'] == 1 && $prjprods[$i]['prj_prod_class'] == 5 && in_array(11,$checkedarr))
            {
                $prj_prod_maker_row11 = AppConfig::$MAKER[$prjprods[$i]['prj_prod_maker']];
                $prj_prod_num_row11 = $prjprods[$i]['prj_prod_num'];
                $prj_prod_model_row11 = $prjprods[$i]['prj_prod_model'];
                $prj_prod_memo_row11 = $prjprods[$i]['prj_prod_memo'];
            }
            if ($prjprods[$i]['sort_id'] == 2 && $prjprods[$i]['prj_prod_class'] == 5 && in_array(12,$checkedarr))
            {
                $prj_prod_maker_row12 = AppConfig::$MAKER[$prjprods[$i]['prj_prod_maker']];
                $prj_prod_num_row12 = $prjprods[$i]['prj_prod_num'];
                $prj_prod_model_row12 = $prjprods[$i]['prj_prod_model'];
                $prj_prod_memo_row12 = $prjprods[$i]['prj_prod_memo'];
            }
            if ($prjprods[$i]['sort_id'] == 1 && $prjprods[$i]['prj_prod_class'] == 6 && in_array(13,$checkedarr))
            {
                $prj_prod_maker_row13 = AppConfig::$MAKER[$prjprods[$i]['prj_prod_maker']];
                $prj_prod_num_row13 = $prjprods[$i]['prj_prod_num'];
                $prj_prod_model_row13 = $prjprods[$i]['prj_prod_model'];
                $prj_prod_memo_row13 = $prjprods[$i]['prj_prod_memo'];
            }
            if ($prjprods[$i]['sort_id'] == 1 && $prjprods[$i]['prj_prod_class'] == 7 && in_array(14,$checkedarr))
            {
                $prj_prod_maker_row14 = AppConfig::$MAKER[$prjprods[$i]['prj_prod_maker']];
                $prj_prod_num_row14 = $prjprods[$i]['prj_prod_num'];
                $prj_prod_model_row14 = $prjprods[$i]['prj_prod_model'];
                $prj_prod_memo_row14 = $prjprods[$i]['prj_prod_memo'];
            }
            if ($prjprods[$i]['sort_id'] == 1 && $prjprods[$i]['prj_prod_class'] == 8 && in_array(15,$checkedarr))
            {
                $prj_prod_maker_row15 = AppConfig::$MAKER[$prjprods[$i]['prj_prod_maker']];
                $prj_prod_num_row15 = $prjprods[$i]['prj_prod_num'];
                $prj_prod_model_row15 = $prjprods[$i]['prj_prod_model'];
                $prj_prod_memo_row15 = $prjprods[$i]['prj_prod_memo'];
            }
            if ($prjprods[$i]['sort_id'] == 1 && $prjprods[$i]['prj_prod_class'] == 9 && in_array(16,$checkedarr))
            {
                $prj_prod_maker_row16 = AppConfig::$MAKER[$prjprods[$i]['prj_prod_maker']];
                $prj_prod_num_row16 = $prjprods[$i]['prj_prod_num'];
                $prj_prod_model_row16 = $prjprods[$i]['prj_prod_model'];
                $prj_prod_memo_row16 = $prjprods[$i]['prj_prod_memo'];
            }
        }
        
        $reportData['valuenumber_14'] = number_format($prj_prod_kw1,0,'.',',');
        $reportData['valuenumber_15'] = $prj_prod_maker_row4;
        $reportData['valuenumber_16'] = $prj_prod_model_row4;
        $reportData['valuenumber_17'] = StringUtil::isNullOrEmpty($prj_prod_num_row4) ? '' : number_format($prj_prod_num_row4,0,'.',',');
        $reportData['valuenumber_18'] = $prj_prod_memo_row4;
        $reportData['valuenumber_31'] = $prj_prod_maker_row13;
        $reportData['valuenumber_32'] = $prj_prod_model_row13;
        $reportData['valuenumber_33'] = StringUtil::isNullOrEmpty($prj_prod_num_row13) ? '' : number_format($prj_prod_num_row13,0,'.',',');
        $reportData['valuenumber_34'] = $prj_prod_memo_row13;
        $reportData['valuenumber_35'] = $prj_prod_maker_row14;
        $reportData['valuenumber_36'] = $prj_prod_model_row14;
        $reportData['valuenumber_37'] = StringUtil::isNullOrEmpty($prj_prod_num_row14) ? '' : number_format($prj_prod_num_row14,0,'.',',');
        $reportData['valuenumber_38'] = $prj_prod_memo_row14;
        $reportData['valuenumber_39'] = $prj_prod_maker_row15;
        $reportData['valuenumber_40'] = $prj_prod_model_row15;
        $reportData['valuenumber_41'] = StringUtil::isNullOrEmpty($prj_prod_num_row15) ? '' : number_format($prj_prod_num_row15,0,'.',',');
        $reportData['valuenumber_42'] = $prj_prod_memo_row15;
        $reportData['valuenumber_43'] = $prj_prod_maker_row16;
        $reportData['valuenumber_44'] = $prj_prod_model_row16;
        $reportData['valuenumber_45'] = StringUtil::isNullOrEmpty($prj_prod_num_row16) ? '' : number_format($prj_prod_num_row16,0,'.',',');
        $reportData['valuenumber_46'] = $prj_prod_memo_row16;
        $reportData['valuenumber_47'] = $prjdetail['prj_prod_checklist'];
        $reportData['valuenumber_48'] = $prjdetail['prj_prod_notices'];
        $reportData['valuenumber_11'] = $this->getArrayRow(array($prj_prod_maker_row1, $prj_prod_maker_row2,$prj_prod_maker_row3));  
        $reportData['valuenumber_12'] = $this->getArrayRow(array($prj_prod_model_row1,$prj_prod_model_row2,$prj_prod_model_row3),0);
        $reportData['valuenumber_13'] = $this->getArrayRow(array($prj_prod_num_row1,$prj_prod_num_row2,$prj_prod_num_row3));
        $reportData['valuenumber_19'] = $this->getArrayRow(array($prj_prod_maker_row5,$prj_prod_maker_row6,$prj_prod_maker_row7));
        $reportData['valuenumber_20'] = $this->getArrayRow(array($prj_prod_model_row5,$prj_prod_model_row6,$prj_prod_model_row7),0);
        $reportData['valuenumber_21'] = $this->getArrayRow(array($prj_prod_num_row5,$prj_prod_num_row6,$prj_prod_num_row7));
        $reportData['valuenumber_22'] = $this->getArrayRow(array($prj_prod_memo_row5,$prj_prod_memo_row6,$prj_prod_memo_row7));
        $reportData['valuenumber_23'] = $this->getArrayRow(array($prj_prod_maker_row8,$prj_prod_maker_row9,$prj_prod_maker_row10));
        $reportData['valuenumber_24'] = $this->getArrayRow(array($prj_prod_model_row8, $prj_prod_model_row9,$prj_prod_model_row10),0);
        $reportData['valuenumber_25'] = $this->getArrayRow(array($prj_prod_num_row8,$prj_prod_num_row9,$prj_prod_num_row10));
        $reportData['valuenumber_26'] = $this->getArrayRow(array($prj_prod_memo_row8,$prj_prod_memo_row9,$prj_prod_memo_row10));
        $reportData['valuenumber_27'] = $this->getArrayRow(array($prj_prod_maker_row11,$prj_prod_maker_row12));
        $reportData['valuenumber_28'] = $this->getArrayRow(array($prj_prod_model_row11,$prj_prod_model_row12),0);
        $reportData['valuenumber_29'] = $this->getArrayRow(array($prj_prod_num_row11,$prj_prod_num_row12));
        $reportData['valuenumber_30'] = $this->getArrayRow(array($prj_prod_memo_row11,$prj_prod_memo_row12));
        $this->setAttribute("reportData", $reportData);


	}
    public function getArrayRow($dataarr,$convert=1){
        $result = array();
        foreach ($dataarr as $key => $data)
        {
            if ($data == '' && (int)$data == 0){
                $result[$key+1] = '';
                continue;
            }
            elseif ((int)$data > 0 && $convert == 1)
            {
                //die($data);
                $result[$key+1] = number_format($data,0,'.',',');
                continue;
            }
            $result[$key+1] = $data;
        }
        return $result;
    }
}
?>