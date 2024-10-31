<?php 
include(dirname(__FILE__)."/../../config/dim_config.php");

	if (isset( $_GET['path'])) {
		$path = $_GET['path'];
		$path = hex2bin($path);
		
		if (is_readable($path)) {
			$finfo = finfo_open(FILEINFO_MIME_TYPE); // Create a FileInfo object
			$mime_type = finfo_file($finfo, $path); // Get the MIME type of the file
			finfo_close($finfo); // Close the FileInfo object

			if ($mime_type !== false) {
				header('Content-Type: '.$mime_type);

				readfile($path);
				exit();
			}
		}
	}
?>
