<?php
include(dirname(__FILE__) . "/config.php");

// Path
$config['hr_dir'] = "hr/"; // HR Directory Name
$config['hr_profile_dir'] = "profile/";       // PROFILE Directory Name
$config['hr_official_dir'] = "official/";       // PROFILE Directory Name
$config['hr_uploads_dir'] = $config['uploads_dir'];	//Directory Upload Name
$config['hr_upload_folder'] = $config['hr_uploads_dir'] . $config['hr_dir'];	//HR Directory Upload Name
$config['hr_upload_doc'] = $config['hr_upload_folder'] . "doc/";	//HR Directory Upload doc, docx, ..
$config['hr_upload_profile_picture'] = $config['hr_upload_folder'] . $config['hr_profile_dir'] . "profile_picture/";	//HR Directory Upload รูปภาพประจำตัว
$config['hr_upload_profile_education'] = $config['hr_upload_folder'] . $config['hr_profile_dir'] . "education/"; //HR Directory Upload ประวัติการศึกษา
$config['hr_upload_profile_license'] = $config['hr_upload_folder'] . $config['hr_profile_dir'] . "license/";	//HR Directory Upload ใบประกอบวิชาชีพ
$config['hr_upload_profile_reward'] = $config['hr_upload_folder'] . $config['hr_profile_dir'] . "reward/";	//HR Directory Upload รางวัล
$config['hr_upload_profile_external_service'] = $config['hr_upload_folder'] . $config['hr_profile_dir'] . "external_service/";	//HR Directory Upload รางวัล
$config['hr_upload_profile_official'] = $config['hr_upload_folder'] . $config['hr_profile_dir'] . $config['hr_official_dir'];	//HR Directory Upload Official

$config['hr_board_dir'] = "dashboard/";	// HR Directory Name
$config['hr_develop_dir'] = "develop/";    // DEVELOP Directory Name
$config['hr_leaves_dir'] = "leaves/";       // LEAVE Directory Name
$config['hr_timework_dir'] = "timework/";  // TIMEWORK Directory Name
$config['hr_home_dir'] = "home/";  // LOG Directory Name
$config['hr_log_dir'] = "log/";  // LOG Directory Name

$config['hr_structure_dir'] = "structure/";       // STRUCTURE Directory Name
$config['hr_base_dir'] = "base/";       // BASE Directory Name


//Upload file
$config['hr_upload_size'] = 2048; //2 MB

?>