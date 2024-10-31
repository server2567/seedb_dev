<?php
include(dirname(__FILE__) . "/config.php");

// Path
$config['line_dir'] = "line/"; // LINE Directory Name
$config['line_service_dir'] = "line/Services/"; // LINE Directory Name

// LINE TOKEN
$config['line_token'] = "vy1X/jz2yCuSLXpx+WVzOcTWB9pexy0M6lUT62zEhmRMNa9+tI6UmLjWTvXmY9TheEGv1YzB7GR2nQTH1y9aYgoXYZ1bqIxZliDaes6179QqzbXq+L7n4QhAYFAXijOV30wiXC4abHiKkSIgzZ+XmAdB04t89/1O/w1cDnyilFU=";

// LIFF ID
$config['default_liff_id'] = '2005869603-32jDDzW1';           //ค่าเริ่มต้น (default)
$config['login_liff_id'] = '2005869603-kGdBBZ95';           //เข้าสู่ระบบ
$config['profile_liff_id'] = '2005869603-7w6QQakX';           //ข้อมูลส่วนตัว
$config['noti_liff_id'] = '2005869603-l9qEE1Kk';           //การแจ้งเตือน
$config['wts_liff_id'] = '2005869603-JwlppaxB';           //จัดการการรอคอย
$config['rch_liff_id'] = '2005869603-9Z711plm';           //ตารางแพทย์ออกตรวจ
$config['que_liff_id'] = '2005869603-r7wXXj9A';           //จัดการคิว
$config['scan_liff_id'] = '2005869603-p8kDDPrb';           //สแกน QR Code


// LINE Rich menu ID
$config['line_menu_login'] = 'richmenu-1b7367fe0f9374811bc156c6c614421d';   // login
$config['line_menu_main'] = 'richmenu-9bb2b818dfb8d0319592600b6e63a9f7';   // main


// src api line
$config['api_line_message_push'] = "https://api.line.me/v2/bot/message/push"; // LINE API PUSH
$config['api_line_message_reply'] = "https://api.line.me/v2/bot/message/reply"; // LINE API REPLY 


// message id
$config['message_que_line_id'] = 1; // QUE
$config['message_ams_line_id'] = 2; // AMS

?>