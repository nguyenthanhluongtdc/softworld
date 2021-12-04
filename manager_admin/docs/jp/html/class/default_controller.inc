<?php

class default_controller
{
	public $return;

	function __construct($require_dir_path , $prefix_class = "")
	{
		if (!$require_dir_path && defined('REQUIRE_PATH')) {
			$require_dir_path = REQUIRE_PATH;
		}

		//クラスファイル呼び出し
		if ($_GET['req']) {
			if (is_file($require_dir_path . '/demo/' . $_GET['req'] . '.inc') && DEMO_MODE === true) { //デモモード用
				require_once $require_dir_path . '/demo/' . $_GET['req'] . '.inc';

			} elseif (is_file($require_dir_path . "/" . $_GET['req'] . '.inc')) {
				require_once $require_dir_path . '/' . $_GET['req'] . '.inc';

			} else {
				echo "Parameter Error";
				exit;
			}

			$class_name = $prefix_class . $_GET['req'];
		} else { //reqがなければindex読込、なくてもok
			if (is_file($require_dir_path . '/demo/index.inc') && DEMO_MODE === true) { //デモモード用
				require_once $require_dir_path . '/demo/index.inc';

			} elseif (is_file($require_dir_path . '/index.inc')) {
				require_once $require_dir_path . '/index.inc';
			}

			$class_name = $prefix_class . "index";
		}


		if (class_exists($class_name)) {
			$obj = new $class_name;
		}

		//処理分岐
		if (method_exists($obj , $_GET['mode'])) {
			$obj->$_GET['mode']();
		} elseif (method_exists($obj , main)) {

			$obj->main();
		}
		//戻り値によっては、非表示の箇所を作るなど、に利用する（controller記載ページにて）
		$this->navigator = $obj->navigator;

//tmpを削除
        unset($_SESSION['tmp']);
	}

}
