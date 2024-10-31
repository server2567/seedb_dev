<?php
include(dirname(__FILE__) . "/config.php");

$config['ldap_on']="off";
$config['notification_on']="off";
$config['ums_folder']="UMS/"; 
$config['ums_DevWgID']="1,14";



$config['ums_dp_name'] = 'โรงพยาบาลจักษุสุราษฎร์';
$config['ums_tel'] = '077-276-999';
$config['ums_email'] = 'surateyehospital@gmail.com';

$config['ums_address_top'] = '44/1 ถนนศรีวิชัย ต.มะขามเตี้ย';
$config['ums_address_bottom'] = 'อ.เมือง สุราษฎร์ธานี 84000';

$config['ums_date_top'] = 'จันทร์ - ศุกร์ 08.00 - 20.00 น.';
$config['ums_date_bottom'] = 'เสาร์ - อาทิตย์ 08.00 - 16.00 น.';

$config['ums_line'] = 'surateyehospital';
$config['ums_webstie'] = 'https://surateyehospital.com/';
$config['ums_google_map'] = 'https://maps.app.goo.gl/8AjDidSid8eLxocZ6';

$config['ums_dir'] = "ums/"; // UMS Directory Name
$config['ums_news_dir'] = "News/";  
$config['ums_uploads_dir'] = $config['uploads_dir'].$config['ums_dir']; // UMS Directory Upload Name
$config['ums_uploads_Policy'] = $config['uploads_dir'].$config['ums_dir']."Policy/"; // UMS Directory Upload Name
$config['ums_uploads_news_img'] = $config['uploads_dir'].$config['ums_dir']."News/img/"; // UMS Directory 
$config['ums_uploads_news_file'] = $config['uploads_dir'].$config['ums_dir']."News/file/"; // UMS Directory 
$config["THEDBJWTSECRET"] = "JWTForgotPassword";
$config["emailer"] = "noreply.thedb.aos@gmail.com";
//Password : devmaster@2023
$config['passwordForApp'] = "xjwqqchdbbdmeiny";
defined('ROLE') OR define('ROLE', array('1'=>'แพทย์', '2'=>'พยาบาล', '3'=>'เจ้าหน้าที่','4'=>'ผู้ป่วย','5' => 'ประชาสัมพันธ์แสดงหน้าจอเรียกคิว'));

$config['ums_register'] = '1'; // การอนุมัติการลงทะเบียน 1 = ให้เข้าหน้าที่อนุมัติ 0 = ลงทะเบียนเข้าสู่ระบบได้เลย สถานะจะเป็น 1
$config['ums_edit_patient'] = '1'; // การอนุมัติการแก้ไขข้อมูล 1 = ให้เข้าหน้าที่อนุมัติ 0 = แก้ไขได้เลย สถานะจะเป็น 1
?>