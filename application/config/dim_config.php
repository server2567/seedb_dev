<?php
include(dirname(__FILE__) . "/config.php");

$config['dim_dir'] = "dim/"; // DIM Directory Name
$config['dim_uploads_dir'] = $config['uploads_dir'].$config['dim_dir']; // DIM Directory Upload Name

// NAS
$config['dim_nas_ip'] = "110.78.42.35"; // ip path for upload file in NAS
$config['dim_nas_port'] = 445; // ip path for upload file in NAS

$config['dim_nas_path'] = $config['dim_uploads_dir']."examination_result_doc/"; // (For test) Vpn path for upload file in NAS
$config['dim_nas_share_path'] = $config['dim_uploads_dir']."nas_share/"; // (For test) Vpn path for upload file in NAS
// $config['dim_nas_path'] = "examination_result_doc/"; // (For prd) Vpn path for upload file in NAS

// สำหรับ vpn แต่ไม่ได้ใช้เชื่อมต่อระหว่าง server
$config['dim_vpn_path'] = "\\\\172.16.22.6\\"; // Vpn path for access NAS
$config['dim_vpn_username'] = "all"; // Vpn username for access NAS
$config['dim_vpn_password'] = "As42022"; // Vpn password for access NAS

?>