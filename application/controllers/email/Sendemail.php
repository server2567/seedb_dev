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
use \PHPMailer\PHPMailer\PHPMailer;
use \PHPMailer\PHPMailer\SMTP;
use \PHPMailer\PHPMailer\Exception;

class Sendemail extends REST_Controller
{

    protected $view;
    protected $model;
    protected $controller;

    public function __construct()
    {
        parent::__construct();
        // Directory path
        //load model
        $this->load->model('ams/M_ams_appointment');
        $this->load->model('que/M_que_appointment');
    }
    // ดึง JWT จากเฮดเดอร์
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
    /*
     * send_email_appoint_to_patient_post
     * 
     * Retrieve patient information for sending email
     * 
     * @param None
     * 
     * @return object - Send Appointment Email to Patient
     * 
     * @author JIRADAT POMYAI
     * @created 24/07/2024
     */
    public function send_email_appoint_to_patient_post()
    {
        $key = "your_secret_key";
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
        $input = json_decode(file_get_contents('php://input'), true); // กรณีมีการระบุ ID ของ ap_id แต่ปกติถ้าแจ้งเตือนผ่านระบบ auto จะไม่มีการ post ค่ามา
        if (isset($input['ap_id'])) {
            $emails = $this->M_ams_appointment->get_email_patient(false, $input['ap_id'])->result();
        } else {
            $emails = $this->M_ams_appointment->get_email_patient(true)->result();
        }
        if ($emails) {
            foreach ($emails as $email) { // วนลูปผ่านแต่ละออบเจ็กต์ในอาเรย์ $emails
                $mail = new PHPMailer(true);
                try {
                    $mail->SMTPDebug = false; //Enable verbose debug output
                    $mail->isSMTP(); //Send using SMTP
                    $mail->Host = 'smtp.gmail.com'; //Set the SMTP server to send through
                    $mail->SMTPAuth = true; //Enable SMTP authentication
                    $mail->Username = $this->config->item('emailer'); //SMTP username
                    $mail->Password = $this->config->item('passwordForApp');
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; //SMTP password
                    $mail->Port = 587; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
                    $mail->CharSet = "UTF-8";
                    $mail->Encoding = 'base64';
                    $mail->setFrom($this->config->item('emailer'), 'ระบบสารสนเทศองค์กร โรงพยาบาลจักษุสุราษฎร์ (See Dashboard)');
                    $mail->addAddress($email->pt_email);
                    $mail->isHTML(true);
                    $mail->Subject = 'กำหนดการนัดหมายผู้ป่วย';
                    $html = '
                    <div style="background-color: #f5f5f5; font-family: Arial, sans-serif;">
                        <div style="width:100%; height:700px; margin:auto; padding: 20px;">
                            <div class="col-6" style="width:570px; min-height:500px; max-height: auto; background-color:white; text-align: center; margin:auto; padding-top: 20px; margin-bottom: 40px; padding:20px">
                                <h2>
                                 <img src="https://surateyehospital.com/wp-content/uploads/2020/08/surateyehospital-nobg.png" alt="" style="max-height: 60px; margin-top: -5px;">
                                 <img src="https://dev-seedb.aos.in.th/assets/img/logo.png" alt="Success" style=" bottom: 20px; right: 10px; max-height: 65px;margin-left: 10px;">
                                    <br>
                                    ใบนัดหมาย
                                </h2>
                                <p style="text-align:start; font-size: 16px;">วันที่นัดหมาย: <b>' . abbreDate2($email->ap_date) . ' ณ เวลา ' . substr($email->ap_time, 0, 5) . ' น.</b></p>
                                <p style="text-align:start; font-size: 16px;">หมายเลขคิว: <b>' . $email->apm_cl_code . '</b></p>
                                <hr>
                                <h3 style="text-align:start">เหตุผลการนัดหมาย:</h3>
                                <div style="padding:10px; text-align:start">' . $email->ap_detail_appointment . '</div>
                                <h3 style="text-align:start">การเตรียมตัวก่อนพบแพทย์:</h3>
                                <div style="padding:10px; text-align:start">' . $email->ap_detail_prepare . '</div>
                            </div>
                            <div style="font-size: 14px; color: #777; text-align: center;">
                                <p class="white"><br>' . $this->config->item('txt_copyright') . '</p>
                            </div>
                        </div>
                    </div>
                    ';
                    $mail->Body = $html;
                    $mail->send();
                    $this->M_ams_appointment->ap_id = $email->ap_id;
                    $this->M_ams_appointment->ap_ast_id = 2;
                    $this->M_ams_appointment->update_ap_ast_id();
                } catch (Exception $e) {
                    // จัดการกับข้อผิดพลาดในการส่งอีเมล
                }
            }
        }
    }
    //send_message_que_to_patient
    public function check_overdate_appointment_post()
    {
        $key = "your_secret_key";
        //รับ JWT จาก Authorization header
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
        $this->M_ams_appointment->update_ap_overdate();
    }
    public function send_que_to_patient_post()
    {
        $input = json_decode(file_get_contents('php://input'), true); // กรณีมีการระบุ ID ของ ap_id แต่ปกติถ้าแจ้งเตือนผ่านระบบ auto จะไม่มีการ post ค่ามา
        if (isset($input['ap_id'])) {
            $email = $this->M_que_appointment->get_appointment_by_id($input['ap_id'])->row();
            $mail = new PHPMailer(true);
            try {
                $mail->SMTPDebug = false; //Enable verbose debug output
                $mail->isSMTP(); //Send using SMTP
                $mail->Host = 'smtp.gmail.com'; //Set the SMTP server to send through
                $mail->SMTPAuth = true; //Enable SMTP authentication
                $mail->Username = $this->config->item('emailer'); //SMTP username
                $mail->Password = $this->config->item('passwordForApp');
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; //SMTP password
                $mail->Port = 587; //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
                $mail->CharSet = "UTF-8";
                $mail->Encoding = 'base64';
                $mail->setFrom($this->config->item('emailer'), 'ระบบสารสนเทศองค์กร โรงพยาบาลจักษุสุราษฎร์ (See Dashboard)');
                $mail->addAddress($email->pt_email);
                $mail->isHTML(true);
                $mail->Subject = 'รายละเอียดการเข้าตรวจ';
                $html = '
                      <div style="background-color: #f5f5f5; font-family: Arial, sans-serif;">
                        <div style="width: 570px; min-height: 350px; background-color: white; margin: auto; padding: 20px; position: relative; text-align: center;">
                            <h2>
                                <img src="https://surateyehospital.com/wp-content/uploads/2020/08/surateyehospital-nobg.png" alt="" style="max-height: 60px; margin-top: -5px;">
                                <img src="https://dev-seedb.aos.in.th/assets/img/logo.png" alt="Success" style=" bottom: 20px; right: 10px; max-height: 65px;margin-left: 10px;">
                                <p style="text-align: center; font-size: 20px;">รายละเอียดการนัดหมายแพทย์</p>
                                <hr>
                                <p style="text-align: start; font-size: 20px;">ชื่อ-นามสกุล: ' . $email->pt_name . ' </p>
                                <p style="text-align: start; font-size: 20px;">วันที่ และเวลาที่นัดหมาย: ' . abbreDate2($email->apm_date) . ' ณ ' . $email->apm_time . ' น. </p>
                                <p style="text-align: start; font-size: 20px;">แผนกที่เข้ารับการตรวจ: ' . $email->stde_name_th . ' </p>
                                <p style="text-align: start; font-size: 20px;">แพทย์: ' . $email->ps_name . '  </p> <br>
                                <!-- รูปภาพที่ต้องการให้แสดงที่มุมขวาล่าง -->
                            </h2>
                        </div>
                        <div style="font-size: 14px; color: #777; text-align: center;">
                            <p class="white"><br>' . $this->config->item('txt_copyright') . '</p>
                        </div>
                    </div>
                ';
                $mail->Body = $html;
                $mail->send();
            } catch (Exception $e) {
                // จัดการกับข้อผิดพลาดในการส่งอีเมล
            }
        }
    }
}
