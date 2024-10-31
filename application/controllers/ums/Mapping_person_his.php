<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once(dirname(__FILE__) . "/../ums/UMS_Controller.php");
class Mapping_person_his extends UMS_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('ums/M_ums_user');
    }
    public function connect_his_database()
    {
        $host = $this->config->item('his_host');
        $dbname = $this->config->item('his_dbname');
        $username = $this->config->item('his_username');
        $password = $this->config->item('his_password');
        try {
            // สร้างการเชื่อมต่อฐานข้อมูลด้วย PDO
            $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
            // ตั้งค่า PDO ให้แสดงข้อผิดพลาดเป็น Exception
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            // กรณีเกิดข้อผิดพลาดในการเชื่อมต่อ
            // echo "เกิดข้อผิดพลาด: " . $e->getMessage();
            return null;
        }
    }
    public function index()
    {
        $data['mapping_users'] = $this->get_mapping_user();
        $data['session_mn_active_url'] = $this->uri->segment(1) . '/' . $this->uri->segment(2);
        $this->output('ums/user/v_mapping_person_his', $data);
    }
    /*
	* get_mapping_user
	* ดึงข้อมูลการจับคู่ User ระหว่างระบบ
	* @input - tab_active
	* $output -
	* @author Jiradat Pomyai
	* @Create Date 05/09/2024
	*/
    public function get_mapping_user()
    {
        $pdo = $this->connect_his_database();
        if ($pdo == null) {
            return false;
        }
        $UMS_users = $this->get_UMS_user();
        $data1_filtered_array = json_decode(json_encode($UMS_users), true);
        $sql = "SELECT *,User_ID as us_his_id, 0 as us_ums_id FROM tbluserid";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        // ดึงผลลัพธ์ทั้งหมด
        $HIS_users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // แสดงผลลัพธ์
        $us_his_ids = array_column($UMS_users, 'us_his_id');
        $data1_array = array_map(function ($item) {
            return (array)$item;
        }, $HIS_users);
        foreach ($data1_filtered_array as &$item1) {
            foreach ($HIS_users as $item2) {
                if ($item1['us_his_id'] == $item2['User_ID']) {
                    // ถ้า id ตรงกับ his_id ให้นำ Username จาก array2 มาใส่ใน array1
                    $item1['Username'] = $item2['Username'];
                    break; // หยุดการวนลูปเมื่อเจอ id ตรงกัน
                }
            }
        }
        $data1_filtered = array_filter($data1_array, function ($row) use ($us_his_ids) {
            return !in_array($row['User_ID'], $us_his_ids);
        });
        $combined_data = array_merge($data1_filtered_array, $data1_filtered);
        return $combined_data;
    }
    /*
	* get_UMS_user
	* ดึงข้อมูลUser ระบบ UMS
	* @input - tab_active
	* $output -
	* @author Jiradat Pomyai
	* @Create Date 05/09/2024
	*/
    public function get_UMS_user()
    {
        $user = $this->M_ums_user->get_all()->result();
        return $user;
    }
    /*
	* insert_ums_user
	* เพิ่ม User ในระบบ UMS
	* @input - user_id
	* $output -
	* @author Jiradat Pomyai
	* @Create Date 05/09/2024
	*/
    public function insert_ums_user()
    {
        $data = $this->input->post();
        $pdo = $this->connect_his_database();
        $sql = "SELECT * FROM tbluserid WHERE User_id = " . $data['userId'];
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $user_info = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($user_info) {
            $this->M_ums_user->us_name = $user_info[0]['U_name'] . ' ' . $user_info[0]['U_lastname'];
            $this->M_ums_user->us_username = $user_info[0]['Username'];
            $this->M_ums_user->us_username_his = $user_info[0]['Username'];
            $this->M_ums_user->us_password = encrypt_id($user_info[0]['Password']);
            $this->M_ums_user->us_his_id = $user_info[0]['User_ID'];
            $this->M_ums_user->us_active = 1;
            $this->M_ums_user->us_sync = 1;
            $this->M_ums_user->us_dp_id = 1;
            $this->M_ums_user->us_psd_id_card_no = '000';
            $this->M_ums_user->insert();
        }
        $data['status_response'] = $this->config->item('status_response_success');
        $data['message_dialog'] = $this->config->item('text_toast_default_success_body');
        $data['last_id'] = $this->M_ums_user->last_insert_id;
        $result = array('data' => $data);
        echo json_encode($result);
    }
    /*
	* insert_his_user
	* เพิ่ม User ในระบบ HIS
	* @input - user_id
	* $output -
	* @author Jiradat Pomyai
	* @Create Date 05/09/2024
	*/
    public function insert_his_user()
    {
        $data = $this->input->post();
        $this->M_ums_user->us_id = $data['userId'];
        $user_info = $this->M_ums_user->get_by_key()->row();
        $Username = $user_info->us_username;
        $Password = $user_info->us_password;

        $Privilege = 'officer';
        $UseStatus = 1;
        $Num_VOL = 0;
        $U_name_EN = '';
        $nameArray = explode(" ", $user_info->us_name);
        // ตรวจสอบจำนวน index
        if (count($nameArray) > 2) {
            $U_name = $nameArray[1]; // ถ้ามากกว่า 2 ให้เอา index 1
            $U_lastname = $nameArray[2];
        } elseif (count($nameArray) == 2) {
            $U_name = $nameArray[0]; // ถ้าเท่ากับ 2 ให้เอา index 0
            $U_lastname = $nameArray[1];
        }
        $pdo = $this->connect_his_database();
        // เตรียมคำสั่ง SQL
        $sql = "INSERT INTO tbluserid (Username, Password, Privilege, UseStatus, Num_VOL, U_name_EN, U_name, U_lastname) 
        VALUES (:Username, :Password, :Privilege, :UseStatus, :Num_VOL, :U_name_EN, :U_name, :U_lastname)";

        $stmt = $pdo->prepare($sql);

        // Binding Parameters
        $stmt->bindParam(':Username', $Username);
        $stmt->bindParam(':Password', $Password);
        $stmt->bindParam(':Privilege', $Privilege);
        $stmt->bindParam(':UseStatus', $UseStatus, PDO::PARAM_INT);
        $stmt->bindParam(':Num_VOL', $Num_VOL, PDO::PARAM_INT);
        $stmt->bindParam(':U_name_EN', $U_name_EN);
        $stmt->bindParam(':U_name', $U_name);
        $stmt->bindParam(':U_lastname', $U_lastname);
        // Execute Statement
        try {
            $stmt->execute();
            $lastInsertId = $pdo->lastInsertId();
            $this->M_ums_user->us_his_id = $lastInsertId;
            $this->M_ums_user->update_his_id();
            $data['status_response'] = $this->config->item('status_response_success');
            $data['message_dialog'] = $this->config->item('text_toast_default_success_body');
            $data['last_id'] = $lastInsertId;
            $result = array('data' => $data);
            echo json_encode($result);
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
