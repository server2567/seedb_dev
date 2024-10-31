<?php 
include(dirname(__FILE__)."/../../config/hr_config.php");
if (isset($_GET['path']) && isset($_GET['doc'])){
	$path =  $_GET['path'];
	$doc =  urldecode($_GET['doc']);
	$filename = $path.$doc; //path
	$rename = basename($filename);//การตัดข้อความ path ที่อยู่ ให้อยู่ในรูปแบบไฟล์
	if(isset($_GET['rename'])){ //ตรวจสอบถ้ามีการเปลี่ยนแปลงชื่อ
		$rename = $_GET['rename'];
	}

	header("Pragma: public"); 
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0"); 
	header("Content-Type: application/force-download"); 
	header("Content-Type: application/octet-stream"); 
	header("Content-Type: application/download"); 
	header("Content-Disposition: attachment; filename=".$rename.";"); //ชื่อไฟล์เอกสารที่ดาวน์โหลด
	header("Content-Transfer-Encoding: binary"); 
	header("Content-Length: ".filesize($filename)); 
	@readfile($filename); 
	exit(0);
}
?>