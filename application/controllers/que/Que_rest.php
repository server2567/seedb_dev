<?php

/**
 * This is Email Service
 * User: Jiradat Pomyai
 * Date: 2024-07-25
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');
require(dirname(dirname(dirname(__FILE__))) . '/libraries/REST_Controller.php');

use \Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\ExpiredException;

class Que_rest extends REST_Controller
{
    public function getBearerToken()
    {
        $headers = apache_request_headers();
        if (isset($headers['Authorization'])) {
            $authHeader = $headers['Authorization'];
            // แยก Bearer token ออกจาก Authorization header
            if (preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
                return $matches[1];
            }
        }
        return null;
    }
    public function Daily_queue_reset_post()
    {
        $key = "que_reset_key";
        // รับ JWT จาก Authorization header
        $jwt = $this->getBearerToken();
        if (!$jwt) {
            http_response_code(401); // Unauthorized
            echo 'JWT not provided';
            exit();
        }

        try {
            // ตรวจสอบ JWT
            $decoded = JWT::decode($jwt, new Key($key, 'HS256'));
        } catch (Exception $e) {
            http_response_code(401); // Unauthorized
            echo 'Invalid token: ', $e->getMessage();
            exit();
        }

        // ตรวจสอบข้อมูลที่จำเป็นใน Payload (เช่น ข้อมูลสิทธิ์)
        if (!isset($decoded->sub) || $decoded->sub !== 'cron_job') {
            http_response_code(403); // Forbidden
            echo 'Access denied';
            exit();
        }
        $this->load->model('que/M_que_queue_list');
        $this->load->model('que/M_que_create_queue');
        $keyword = $this->M_que_create_queue->get_all_que_keyword()->result_array();

        $que = $this->M_que_queue_list->Check_last_que($keyword);

        $currentDate = new DateTime();
        foreach ($que as $q) {
            $queDate = new DateTime($q['ql_date']);

            if ($queDate->format('Y-m-d') != $currentDate->format('Y-m-d')) {
                $create_queue = $this->M_que_create_queue->get_by_keyword_active($q['ql_dpq_keyword'])->row();
                $queue_values = json_decode($create_queue->cq_value);
                
                foreach ($queue_values as $value) {
                    if ($value->char_type == 'rn') {
                        $char_type_value = $value->char_type_value;
                        if (ctype_digit($char_type_value)) {
                            $value->char_type_value = '1';
                        } elseif (ctype_lower($char_type_value)) {
                            $value->char_type_value = 'a';
                        } elseif (ctype_upper($char_type_value)) {
                            $value->char_type_value = 'A';
                        } elseif ($this->isThaiCharacter($char_type_value)) {
                            $value->char_type_value = 'ก';
                        }
                    }
                }
                $this->M_que_create_queue->cq_value = json_encode($queue_values);
                $this->M_que_create_queue->cq_id = $create_queue->cq_id;
                $this->M_que_create_queue->update_cq_value();
            } else {
                echo "The date in the queue is today: " . $q['ql_date'];
            }
        }
    }
}
