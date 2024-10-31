<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;

class JWTHandler {
    private $secret_key = 'boom19970'; // คีย์ลับที่ใช้ในการเข้ารหัสและถอดรหัส

    // ฟังก์ชันสำหรับเข้ารหัสข้อมูล
    public function encode($data) {
        $issuedAt = time();
        $expirationTime = $issuedAt + 7200;  // กำหนดเวลาหมดอายุเป็น 2 ชั่วโมง
        $payload = array(
            'iat' => $issuedAt,
            'exp' => $expirationTime,
            'data' => $data
        );

        return JWT::encode($payload, $this->secret_key, 'HS256');
    }

    // ฟังก์ชันสำหรับถอดรหัสข้อมูล
    public function decode($jwt) {
        try {
            $decoded = JWT::decode($jwt, $this->secret_key, array('HS256'));
            return (array) $decoded->data;
        } catch (Exception $e) {
            return null;
        }
    }
}
?>
