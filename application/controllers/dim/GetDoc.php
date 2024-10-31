<?php 
include(dirname(__FILE__)."/../../config/ums_config.php");

if (isset($_GET['path'])){
	$path = $_GET['path'];
	$path = base64_decode($path);
	$rename = basename($path);
	// if(isset($_GET['rename'])){
	// 	$rename = $_GET['rename'];
	// }
	
	header("Pragma: public"); 
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
	header("Content-Type: application/force-download"); 
	header("Content-Type: application/octet-stream"); 
	header("Content-Type: application/download"); 
	header("Content-Disposition: attachment; filename=".$rename.";"); //ชื่อไฟล์เอกสารที่ดาวน์โหลด
	header("Content-Transfer-Encoding: binary"); 
	header("Content-Length: ".filesize($path)); 
	@readfile($path); 
	exit(0);
}
?>