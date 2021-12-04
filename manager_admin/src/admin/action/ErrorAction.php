<?php
/**
**/
class ErrorAction extends BaseAction {

	public function index() {
		$this->error();
	}
	
	
	public function unauthorized() {
		$this->setView("unauthorized.php");
	}

	public function error() {
		$this->setView("error.php");
	}

}

?>