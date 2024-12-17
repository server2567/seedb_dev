<?php
defined('BASEPATH') or exit('No direct script access allowed');

class FingerprintLib
{

    private $ip;
    private $port;
    private $socket;

    public function __construct($params = [])
    {
        // กำหนดค่าเริ่มต้น
        $this->ip = isset($params['ip']) ? $params['ip'] : '192.168.1.201';
        $this->port = isset($params['port']) ? $params['port'] : 4370;
    }

    // ฟังก์ชันเชื่อมต่อกับเครื่องสแกนนิ้ว
    public function connect()
    {
        $socket = fsockopen($this->ip, $this->port, $errno, $errstr, 5);
        if (!$socket) {
            return "Error: $errstr ($errno)";
        }
        return $socket;
    }

    // ฟังก์ชันดึงข้อมูลการบันทึกเวลา
    public function getAttendance()
    {
        $socket = $this->connect();
        if (!is_resource($socket)) {
            return $socket; // แสดงข้อความ Error
        }

        // ส่งคำสั่งเพื่อดึงข้อมูล (ตาม API/SDK ของ HIP)
        $command = "GET_ATTENDANCE"; // ตัวอย่างคำสั่ง (ปรับตามคู่มือ API)
        fwrite($socket, $command);

        // อ่านข้อมูลที่เครื่องส่งกลับ
        $response = '';
        while (!feof($socket)) {
            $response .= fread($socket, 8192); // อ่านข้อมูลทีละ 8 KB
        }
        fclose($socket);

        // แปลงข้อมูลให้เป็น Array
        return $this->parseAttendanceData($response);
    }



    // ฟังก์ชันแปลงข้อมูลการบันทึกเวลา
    private function parseAttendanceData($data)
    {
        // ตัวอย่างการแปลงข้อมูลเป็น Array
        $parsedData = [];
        $lines = explode("\n", $data);
        pre($lines);
        foreach ($lines as $line) {
            $parts = explode(",", $line); // สมมติว่าแบ่งด้วย ","
            if (count($parts) >= 3) {
                $parsedData[] = [
                    'user_id' => $parts[0],
                    'timestamp' => $parts[1],
                    'status' => $parts[2]
                ];
            }
        }

        return $parsedData;
    }

    // ฟังก์ชันปิดการเชื่อมต่อ
    public function disconnect()
    {
        if ($this->socket) {
            fclose($this->socket);
        }
    }
    // ฟังก์ชันดึงข้อมูลการบันทึกเวลา 1 แถวล่าสุดเฉพาะวันนี้
    public function getLastAttendanceToday()
    {
        if (!$this->socket) {
            return "Error: Not connected to device";
        }
        // คำสั่งที่ใช้ดึงข้อมูลจากเครื่อง (แก้ไขตาม API ของอุปกรณ์)
        $command = "GET_ATTENDANCE";
        fwrite($this->socket, $command);
        $response = fread($this->socket, 8192);

        // แปลงข้อมูล
        $parsedData = $this->parseAttendanceData($response);

        // กรองเฉพาะข้อมูลของวันนี้
        $today = date('Y-m-d');
        pre($today);
        die;
        $attendanceToday = array_filter($parsedData, function ($log) use ($today) {
            return strpos($log['timestamp'], $today) === 0; // ตรวจสอบว่าเป็นวันที่วันนี้
        });

        // หาข้อมูลแถวล่าสุด (เรียงลำดับ timestamp)
        if (!empty($attendanceToday)) {
            usort($attendanceToday, function ($a, $b) {
                return strtotime($b['timestamp']) - strtotime($a['timestamp']); // เรียงจากล่าสุดไปเก่าสุด
            });
            return $attendanceToday[0]; // คืนค่าข้อมูลแถวล่าสุด
        }

        return null; // ไม่มีข้อมูลของวันนี้
    }
}
