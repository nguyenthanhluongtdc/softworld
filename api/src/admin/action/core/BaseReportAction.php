<?php
/**
*
*/
abstract class BaseReportAction extends BaseAction {

	public $reportId;
	public $reportTitle;

	public function __construct()
    {
    	parent::__construct();
    }

	public function getView() {
		$notView = StringUtil::isNullOrEmpty($this->reportId);
		if($notView && !StringUtil::isNullOrEmpty($this->pageId)) {
	 		$defaults = array("index", "view", "default");
	 		foreach ($defaults as $value) {
	 			$path = ROOT_PATH_VIEW_REPORT  .  "/" .$this->pageId . "/" . $value . ".php";
	 			if(file_exists($path)) {
	 				parent::setView($path);
	 				return $path;
	 			}
	 		}
		}
		return $notView ? null : (ROOT_PATH_VIEW_REPORT  .  "/" . $this->pageId . "/" . $this->reportId . ".php");
	}

	protected  function options(){
		return array();
	}

	public abstract function validate();

	public abstract function process();

	public  function run() {
		$this->validate();
		if(!isset($this->attributes)) {
			$this->attributes = array();
		}
	 	if($this->autoControlMessage && $this->validate->hasError()) {
			$this->attributes[$this->gobalAttributeName["listErrorMessage"]] = $this->validate->getErrors();
		} else {
			$viewLoader = new ViewLoader();
			$this->attributes["reportTitle"] = $this->reportTitle;
			$this->logger->debug("run#attributes:" . print_r($this->attributes, true));
			$this->process();
		 	$viewLoader->showReport($this->getView(), $this->attributes);	
		}
	}
}
?>