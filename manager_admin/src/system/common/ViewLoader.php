<?php

class ViewLoader
{
    private $__content = array();

    /**
     * Load view
     * @param   string
     * @param   array
     * @desc
     */
    public function loadViewAdmin($view, $attributes = array(), $isLoginPage = false)
    {
        if (StringUtil::isNullOrEmpty($view) || !file_exists($view)) {
            $view = ROOT_PATH_VIEW  . '/error/404.php';
        }
        $attributes["viewPath"] = $view;
        extract($attributes); 

        ob_start();
        if($isLoginPage) {
            require_once ROOT_PATH_THEME . "/" . ADMIN_THEME . "/layout/login.php";
        } else {
            require_once ROOT_PATH_THEME . "/" . ADMIN_THEME . "/layout/main.php";
        }
        $content = ob_get_contents();
        ob_end_clean();
        $this->__content[] = $content;
        ob_end_clean();
    }

    /**
     * Show report
     * @param   string
     * @param   array
     * @desc
     */
    public function showReport($view, $attributes = array())
    {
        if (StringUtil::isNullOrEmpty($view) || !file_exists($view)) {
            $view = ROOT_PATH_VIEW  . '/error/404.php';
        }
        $attributes["viewPath"] = $view;
        extract($attributes); 

        ob_start();
        require_once ROOT_PATH_THEME . "/" . ADMIN_THEME . "/layout/report.php";
        $content = ob_get_contents();
        require_once ROOT_PATH_LIBRARY . "/mpdf60/mpdf.php";
        $mpdf = new mPDF();
        if(array_key_exists("reportTitle", $attributes)) {
            $mpdf->SetTitle($attributes["reportTitle"]);
        }
        // LOAD a stylesheet
        if (file_exists(ROOT_PATH_THEME . "/" . ADMIN_THEME . "/css/report.css")){
			$stylesheet = file_get_contents(ROOT_PATH_THEME . "/" . ADMIN_THEME . "/css/report.css");
		}else{
			$stylesheet="";
		}
        $mpdf->autoLangToFont = true;
        $mpdf->WriteHTML($stylesheet,1);    // The parameter 1 tells that this is css/style only and no body/html/text
        $mpdf->WriteHTML($content);
        ob_end_clean();
        $mpdf->Output();
    }
    
    /**
     * Show view
     * @desc
     */
    public function show()
    {
        foreach ($this->__content as $html) {
            echo $html;
        }
    }

}