<?php
$config['txt_copyright'] 	= "Copyright © " . date("Y") . " All<u>O</u>Soft. All Rights Reserved  
	| <a href='https://www.aos.in.th/storage/app/media/HOME/PrivacyPolicy.pdf' target='_blank'>Data Privacy Policy</a> 
	| <a href='https://www.aos.in.th/storage/app/media/HOME/PrivacyNotice.pdf' target='_blank'>Privacy Notice - Data Processor</a> 
	";

$config['site_logo'] = "images/logo2.png";
$config['site_name_th'] = "โรงพยาบาลจักษุสุราษฎร์";
$config['site_name_eng'] = "Surat Eye Hospital";

// Message validate from
$config['text_invalid_default'] = "กรุณาระบุข้อมูล";
$config['text_invalid_inputs'] = "ข้อมูลไม่ถูกต้อง กรุณาตรวจสอบอีกครั้ง";
$config['text_invalid_duplicate'] = "มีข้อมูลซ้ำอยู่ในระบบแล้ว กรุณาระบุใหม่";

// Message show swal
// $config['text_swal_default_success_title'] = "ดำเนินการเสร็จสิ้น";
// $config['text_swal_default_success_text'] = "บันทึกข้อมูลสำเร็จ";
// $config['text_swal_default_error_title'] = "ดำเนินการไม่สำเร็จ";
// $config['text_swal_default_error_text'] = "กรุณาติดต่อแอดมิน";

$config['text_swal_delete_title'] = "ลบข้อมูล";
$config['text_swal_delete_text'] = "คุณต้องการลบหรือไม่";
$config['text_swal_delete_confirm'] = "ตกลง";
$config['text_swal_delete_cancel'] = "ยกเลิก";


// Message show toast dialog
$config['text_toast_default_success_header'] = "ดำเนินการเสร็จสิ้น";
$config['text_toast_default_success_body'] = "บันทึกข้อมูลสำเร็จ";
$config['text_toast_default_error_header'] = "ดำเนินการไม่สำเร็จ";
$config['text_toast_default_error_body'] = "กรุณาติดต่อแอดมิน";

$config['text_toast_save_success_header'] = "ดำเนินการเสร็จสิ้น";
$config['text_toast_save_success_body'] = "บันทึกข้อมูลเสร็จสมบูรณ์";
$config['text_toast_save_error_header'] = "ดำเนินการไม่สำเร็จ";
$config['text_toast_save_error_body'] = "กรุณาติดต่อแอดมิน";

$config['text_toast_delete_success_header'] = "ลบข้อมูลสำเร็จ";
$config['text_toast_delete_success_body'] = "ลบข้อมูลเสร็จสมบูรณ์";
$config['text_toast_delete_error_header'] = "ไม่สามารถลบข้อมูลได้";
$config['text_toast_delete_error_body'] = "ข้อมูลนี้กำลังถูกใช้งาน";

// Message table
$config['text_table_no_data'] = "ไม่มีรายการข้อมูล";

// Config datatable
$config['datatable_second_reload'] = 10000;

/*
|--------------------------------------------------------------------------
| StatusCode
|--------------------------------------------------------------------------
| For use return response 
| Ex. When delete data, if delete complete no error then return status success to view for alert success
| Ex. When delete data, if delete incomplete (like this data is using(FK)) or error then return status error to view for alert error
*/
$config['status_response_show'] = 0; // for return load view
$config['status_response_success'] = 1; // for return load view
$config['status_response_error'] = 2; // for return load view

$config['aprov_pa'] = "1";
$config['redirect_to_pa'] = "personal_dashboard/Personal_dashboard";

$config['site_logo'] = "img/logo2.png";
$config['site_name_th'] = "โรงพยาบาลจักษุสุราษฎร์";
$config['site_name_eng'] = "Surat Eye Hospital";

?>