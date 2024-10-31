<?php
include(dirname(__FILE__)."/../../config/hr_config.php");
	if (isset($_GET['type']) && isset( $_GET['image'])){
		$type =  $_GET['type'];
		$image =  $_GET['image'];
		$path = "{$config['hr_upload_folder']}{$type}/{$image}";
		//$path = $this->config->item("hr_upload_folder")."{$type}/{$image}";
		if (is_readable($path)) {
			$info = getimagesize($path);
			if ($info !== FALSE) {
				header("Content-type: {$info['mime']}");
				readfile($path);
				exit();
			}
		}
	}
?>