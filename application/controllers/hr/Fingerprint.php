<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Fingerprint extends CI_Controller
{

    public function index()
    {
        // โหลดไลบรารีและกำหนดค่าพารามิเตอร์
        $this->load->library('FingerprintLib', ['ip' => '110.78.42.35', 'port' => 5005]);

        // เชื่อมต่อกับเครื่องสแกนนิ้ว
        $connection = $this->fingerprintlib->connect();
        if ($connection != true) {
            echo "การเชื่อมต่อล้มเหลว: " . $connection;
            die;
        } else {
            echo "เชื่อมต่อสำเร็จ<br>";
        }
        $attendance = $this->fingerprintlib->getAttendance();
        if (is_array($attendance) && !empty($attendance)) {
            echo "<h3>ข้อมูลการบันทึกเวลา:</h3>";
            echo "<pre>";
            print_r($attendance); // แสดงข้อมูลในรูปแบบที่อ่านง่าย
            echo "</pre>";
        } elseif (is_array($attendance) && empty($attendance)) {
            echo "ไม่มีข้อมูลการบันทึกเวลาในเครื่อง";
        } else {
            echo "ข้อผิดพลาดในการดึงข้อมูล: " . $attendance;
        }

        // ปิดการเชื่อมต่อ
        $this->fingerprintlib->disconnect();
        echo "การเชื่อมต่อถูกปิด";
    }
    
}
