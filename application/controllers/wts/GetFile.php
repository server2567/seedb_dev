<?php 
include(dirname(__FILE__)."/../../config/wts_config.php");

	if (isset( $_GET['type']) && isset( $_GET['image'])) {
		$type =  $_GET['type'];
		$image =  $_GET['image'];
		$path = $config['wts_uploads_dir'].$type."/".$image;
		if (is_readable($path)) {
			$info = getimagesize($path);
			$filesize = filesize($path);
			if ($info !== FALSE) {
				header('Content-Type: '.$info['mime']);
				header('Content-Disposition: attachment; filename="'.$image.'"');
				header('Content-Length: '.$filesize);
    			header("Content-Range: 0-".($filesize-1)."/".$filesize);

				readfile($path);
				exit();
			}
		}
	}
?>
