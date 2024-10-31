<?php
    $config['wts_dir'] = "wts/"; // HR Directory Name

    
    $config['wts_uploads_dir'] = '/var/www/uploads/wts/'; // UMS Directory Upload Name
    $config['wts_upload_qr'] = '/var/www/uploads/wts/';
    $config['allowed_types'] = 'png';
    $config['file_name'] = uniqid() . '.png';
    $config['overwrite'] = TRUE;


    $config['wts_user_admin'] = '60001'; // สิทธิ์ผู้ดูแลระบบ WTS
    $config['wts_user_oph'] = '60005'; // สิทธิ์เจ้าหน้าที่แผนกผู้ป่วยนอก จักษุ
    $config['wts_user_ent'] = '60006'; // สิทธิ์เจ้าหน้าที่แผนกผู้ป่วยนอกหู คอ จมูก
    $config['wts_user_den'] = '60007'; // สิทธิ์เจ้าหน้าที่แผนกทันตกรรม
    $config['wts_user_rad'] = '60008'; // สิทธิ์เจ้าหน้าที่แผนกรังสีวิทยา
    $config['wts_user_lcc'] = '60009'; // สิทธิ์เจ้าหน้าที่แผนกศูนย์เคลียร์เลสิค

    // แจ้งเตือนแพทย์
    $config['wts_enable_to_alert'] = false; // (ไม่ใช้แล้ว ใช้ที่ ums_user_config) เปิดใช้งาน แจ้งเตือนแพทย์
    $config['wts_enable_sound_alert'] = false; // (ไม่ใช้แล้ว ใช้ที่ ums_user_config) เปิดใช้งาน แจ้งเตือนแพทย์ด้วยเสียงหรือไม่
    $config['wts_time_almost_min_alert'] = 3; // จำนวนนาทีในการแจ้งเตือนล่วงหน้า (แจ้งเตือนใกล้หมดเวลา)
    $config['wts_time_second_loop'] = 5000; // จำนวนวินาทีในการทำซ้ำเช็คการแจ้งเตือน


    $config['wts_room_ood'] = '4'; // แผนกผู้ป่วยนอกจักษุ ฟิกว่าไปที่ห้อง rm_his_id = 4
    $config['wts_room_floor2'] = '6'; // 'แผนกผู้ป่วยนอกหู/คอ/จมูก' 'แผนกรังสีวิทยา' 'แผนกผู้ป่วยนอกสูตินรีเวช' 'แผนกผู้ป่วยนอกอายุรกรรม' 'จิตแพทย์' 'แผนกเทคนิคการแพทย์'
    $config['wts_room_dd'] = '9'; // แผนกทันตกรรม 
    $config['wts_room_rel'] = '28'; // แผนกศูนย์เคลียร์เลสิค 



    // PROFILE Directory Name
?>