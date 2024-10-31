<?php 
include(dirname(__FILE__)."/../../config/ums_config.php");
/* ********************************************************
 * Create By Areerat Pongurai - Date Modify 2024/05/29 ******
 * ********************************************************
 * วิธีการเรียกใช้ https://[path]/Getdoc?type=[foldername]&doc=[filename]&rename=[renamefile]
 * getDoc.php ใช้สำหรับดาวน์โหลดเอกสาร ที่อยู่ภายใต้ /var/www/uploads/....
 * ตัวแปรต้องส่งมาเป็นแบบ GET  : 	type (ชื่อโฟลเดอร์){ต้องมี}
 * 				doc (ชื่อไฟล์ที่จัดเก็บใน server){ต้องมี}
 * 				rename (ชื่อไฟล์เอกสาร ที่ต้องการเปลี่ยนชื่อก่อนดาวน์โหลด){ถ้ามี}
 * ******************************************************** */
if (isset($_GET['type']) && isset( $_GET['doc'])){
	$type =  $_GET['type'];
	$doc =  urldecode($_GET['doc']);
	$filename = "{$config['ums_uploads_dir']}{$type}/{$doc}"; //path
	$rename = basename($filename);//การตัดข้อความ path ที่อยู่ ให้อยู่ในรูปแบบไฟล์
	if(isset($_GET['rename'])){ //ตรวจสอบถ้ามีการเปลี่ยนแปลงชื่อ
		$rename = $_GET['rename'];
	}
	// echo $filename;die;
	//$filename = $_GET['C:\AppServ\www\WebCom\files'];
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