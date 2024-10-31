<?php 
/*
* Home_user
* Controller หลักของไลน์
* @input -
* $output -
* @author Tanadon Tangjaimongkhon
* @Create Date 17/07/2024
*/
if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once('Line_Controller.php');

class Frontend extends Line_Controller
{
	// Create __construct for load model use in this controller
	public function __construct()
	{
		parent::__construct();
		$this->controller .= "Frontend/";
		$this->load->model($this->model.'M_line_patient');

		$this->mn_active_url = uri_string();

        //Line Token The DB
		$this->line_token = $this->config->item('line_token');
		
		// Line Rich menu ID
		$this->line_menu_main = $this->config->item('line_menu_main');
        $this->line_menu_login = $this->config->item('line_menu_login');
	}
    
    /*
	 * frontend_default 
     * แสดงหน้าจอเมนูระบบ (LIFF)
	 * input : selected_system
	 * Tanadon Tangjaimongkhon
	 * @Create Date 17/07/2024
	 */
    public function frontend_default($selected_system = ''){
        $data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$data['view_dir'] = $this->view;
		$data['controller_dir'] = $this->controller;
        $data['selected_system'] = $selected_system;

        $this->load->view($this->view.'v_line_frontend_default', $data);
    }
    //frontend_default

	/*
	* frontend_login
	* เข้าสู่ระบบ
	* @input -
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 17/07/2024
	*/
	public function frontend_login()
	{
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$data['view_dir'] = $this->view;
		$data['controller_dir'] = $this->controller;
        $this->session->set_userdata('line_using_menu', 'login');

		$this->output_frontend($this->view.'v_line_frontend_login', $data);
	}
	// frontend_login

    /*
	* frontend_scan_qr_code
	* สแกน QR code
	* @input -
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 17/07/2024
	*/
	public function frontend_scan_qr_code()
	{
		$data['session_mn_active_url'] = $this->mn_active_url; // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$data['view_dir'] = $this->view;
		$data['controller_dir'] = $this->controller;
        $this->session->set_userdata('line_using_menu', 'scan_qr_code');

		$this->output_frontend($this->view.'v_line_frontend_scan_qr_code', $data);
	}
	// frontend_login

    /*
	* frontend_register
	* ลงทะเบียน
	* @input -
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 15/08/2024
	*/
	public function frontend_register()
	{
        $this->session->set_userdata('line_using_menu', 'register');
		redirect('Gear/frontend_register','refresh');
	}
	// frontend_register


    public function checklogin() {
        $this->load->model($this->config->item('ums_dir').'M_ums_patient');
    
        // Get the form data
        $username = trim($this->input->post('Username'));
        $password = trim($this->input->post('Password'));
        
        // Validate the login credentials
        $user = $this->M_ums_patient->validate_login($username, $password);
        
        $ip_address = $this->input->ip_address();
        $location = get_location_from_ip($ip_address);
        $location_str = $location ? "{$location['region']}, {$location['country']}" : 'Unknown';
    
        $data = [];

        if ($user) {
            $data['is_exist'] = true;
            $data['status'] = $user->pt_sta_id;
    
            if ($this->config->item('ums_register') == 1) {
                switch ($user->pt_sta_id) {
                    case 4: // Pending approval
                        $this->log_login_attempt($user->pt_id, 'รอการอนุมัติการลงทะเบียน', $ip_address, $location_str);
                        $data['error'] = 'รอการอนุมัติการลงทะเบียน';
                        $data['message'] = 'กรุณารอการอนุมัติจากเจ้าหน้าที่โรงพยาบาล';
                        break;
    
                    case 2: // Account deactivated
                        $this->log_login_attempt($user->pt_id, 'ท่านถูกปิดการใช้งาน', $ip_address, $location_str);
                        $data['error'] = 'ท่านถูกปิดการใช้งาน';
                        $data['message'] = 'กรุณาติดต่อเจ้าหน้าที่โรงพยาบาล';
                        break;
    
                    case 3: // Account banned
                        $this->log_login_attempt($user->pt_id, 'ท่านถูกแบนการใช้งาน', $ip_address, $location_str);
                        $data['error'] = 'ท่านถูกแบนการใช้งาน';
                        $data['message'] = 'กรุณาติดต่อเจ้าหน้าที่โรงพยาบาล';
                        break;
    
                    default: // Successful login, no errors
                        $data['error'] = null;
                        $data['message'] = null;
                        break;
                }
            } else {
                switch ($user->pt_sta_id) {
                    case 4: // Pending approval
                        $this->log_login_attempt($user->pt_id, 'รอการอนุมัติการลงทะเบียน', $ip_address, $location_str);
                        $data['error'] = 'รอการอนุมัติการลงทะเบียน';
                        $data['message'] = 'กรุณารอการอนุมัติจากเจ้าหน้าที่โรงพยาบาล';
                        break;
    
                    case 2: // Account deactivated
                        $this->log_login_attempt($user->pt_id, 'ท่านถูกปิดการใช้งาน', $ip_address, $location_str);
                        $data['error'] = 'ท่านถูกปิดการใช้งาน';
                        $data['message'] = 'กรุณาติดต่อเจ้าหน้าที่โรงพยาบาล';
                        break;
    
                    case 3: // Account banned
                        $this->log_login_attempt($user->pt_id, 'ท่านถูกแบนการใช้งาน', $ip_address, $location_str);
                        $data['error'] = 'ท่านถูกแบนการใช้งาน';
                        $data['message'] = 'กรุณาติดต่อเจ้าหน้าที่โรงพยาบาล';
                        break;
    
                    default: // Successful login, no errors
                        $data['error'] = null;
                        $data['message'] = null;
                        break;
                }
            }
        } else {
            $data['is_exist'] = false;
            $data['error'] = 'เลขบัตรประจำตัวประชาชน / พาสปอร์ต / เลขบัตรต่างด้าว หรือรหัสผ่านไม่ถูกต้อง';
            $data['message'] = 'ไม่สามารถเข้าสู่ระบบได้';
            $this->log_login_attempt(null, 'เข้าสู่ระบบไม่สำเร็จ ไอดีหรือรหัสผ่านไม่ถูกต้อง', $ip_address, $location_str);
        }
    
        echo json_encode($data);
    }
    
  
    private function log_login_attempt($pt_id, $message, $ip_address, $location_str) {
        $log_data = array(
            'pl_pt_id' => $pt_id,
            'pl_date' => date('Y-m-d H:i:s'),
            'pl_changed' => $message,
            'pl_ip' => $ip_address . ' ' . $location_str,
            'pl_agent' => detect_device_type_ip($this->input->user_agent())
        );
        $this->M_ums_patient->log_login($log_data);
    }

     /*
	 * logout
     * ออกจากระบบ และเปลี่ยน rich menu กลับเป็นแบบเดิม
	 * input : line_user_id
	 * author: Tanadon
	 * Create Date : 2022-06-15
	 */
    public function logout(){
        $this->load->model($this->config->item('ums_dir').'M_ums_patient');
        $line_user_id = $this->session->userdata('line_user_id');

        $this->M_line_patient->lpt_status = "N";
        $this->M_line_patient->lpt_user_line_id = $line_user_id;
        $this->M_line_patient->update_status();

        $this->set_rich_menu($line_user_id, $this->line_menu_login);

        // remove session off this system
        $ip_address = $this->input->ip_address();
        $location = get_location_from_ip($ip_address);
        $location_str = $location ? "{$location['region']}, {$location['country']}" : 'Unknown';
        $log_data = array(
            'pl_pt_id' => $this->session->userdata('pt_id'),
            'pl_date' => date('Y-m-d H:i:s'),
            'pl_changed' => 'ออกจากระบบสำเร็จ',
            'pl_ip' => $ip_address.' '.$location_str,
            'pl_agent' => 'Line'
        );
        $this->M_ums_patient->log_login($log_data);

        // Destroy all sessions
        $this->session->sess_destroy();

        redirect($this->config->item('line_dir').'Frontend/frontend_login','refresh');
    }//logout

    /*
	 * set_rich_menu
     * เปลี่ยน rich_menu ของ user
	 * input : line_user_id, rich_menu_id
	 * author: Tanadon
	 * Create Date : 2022-06-14
	 */
    public function set_rich_menu($line_user_id, $rich_menu_id){
        $url = 'https://api.line.me/v2/bot/user/'.$line_user_id.'/richmenu/'.$rich_menu_id;
        $post_header = array('Content-Type: application/json', 'Authorization: Bearer ' . $this->line_token);
        $this->execute_command_line($url, "POST", $post_header, ''); //result
    }//set_rich_menu

    /*
	 * execute_command_line
     * แปลงคำสั่งไลน์ตาม input
	 * input : $url, $method, $post_header, $post_body
	 * author: Tanadon
	 * Create Date : 2022-06-14
	 */
    function execute_command_line($url, $method, $post_header, $post_body='', $message_line_data=array()){
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $post_header);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_body);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

		$err = curl_error($ch);
		$data = curl_exec($ch);
        curl_close($ch);

		if(count($message_line_data) > 0){
			if ($err) {
				$datasReturn['result'] = 'N';
				$datasReturn['message'] = $err;
				$message_line_data['detail'] = $err;
				$message_line_data['status'] = 'N';
			} else {
				if($response == "{}"){
					$datasReturn['result'] = 'Y';
					$datasReturn['message'] = 'Success';
				}else{
					$datasReturn['result'] = 'N';
					$datasReturn['message'] = $response;
					$message_line_data['status'] = 'N';
					$message_line_data['detail'] = $response;
				}
			}
			$this->insert_message_log($message_line_data);
		}


        $result = json_decode($data);
        return $result;
    }//execute_command_line

    public function access_system($system, $line_user_id, $id=""){
        $this->load->model($this->config->item('ums_dir').'M_ums_patient');


        $this->M_line_patient->lpt_user_line_id = $line_user_id;
       	$user_line_data = $this->M_line_patient->get_by_person_line_id_login();

        if($user_line_data->num_rows() > 0){
			$us_line = $user_line_data->row();
			$this->M_line_patient->lpt_pt_id = $us_line->lpt_pt_id;

			$user = $this->M_line_patient->get_detail_person_id()->row();

			$pt_id = $us_line->lpt_pt_id;
			
			if(!$this->session->userdata('pt_id')){
				
                // Set user data in session
                $this->session->set_userdata('line_using_menu', '');
                $this->session->set_userdata('line_user_id', $line_user_id);
                $this->session->set_userdata('pt_id', $user->pt_id);
                $this->session->set_userdata('pt_member', $user->pt_member);
                $this->session->set_userdata('pt_identification', $user->pt_identification);
                $this->session->set_userdata('pt_passport', $user->pt_passport);
                $this->session->set_userdata('pt_peregrine', $user->pt_peregrine);
                $this->session->set_userdata('pt_prefix', $user->pt_prefix);
                $this->session->set_userdata('pt_fname', $user->pt_fname);
                $this->session->set_userdata('pt_lname', $user->pt_lname);

                // Validate the login credentials
                $ip_address = $this->input->ip_address();
                $location = get_location_from_ip($ip_address);
                $location_str = $location ? "{$location['region']}, {$location['country']}" : 'Unknown';

				// รับ IP address
                $log_data = array(
                    'pl_pt_id' => $user->pt_id,
                    'pl_date' => date('Y-m-d H:i:s'),
                    'pl_changed' => 'เข้าสู่ระบบสำเร็จ',
                    'pl_ip' => $ip_address.' '.$location_str,
                    'pl_agent' => 'Line'
                );
                $this->M_ums_patient->log_login($log_data);
                

				$this->M_line_patient->lpt_pt_id = $user->pt_id;
				$user_line_data = $this->M_line_patient->get_by_person_id();
				
				if($user_line_data->num_rows() == 0){
					$this->M_line_patient->lpt_pt_id = $user->pt_id;
					$this->M_line_patient->lpt_user_line_id = $line_user_id;
					$this->M_line_patient->lpt_status = "Y";
					$this->M_line_patient->lpt_create_user = $user->pt_id;
                    $this->M_line_patient->lpt_create_date = get_datetime_db();
					$this->M_line_patient->lpt_update_user = NULL;
					$this->M_line_patient->lpt_update_date = NULL;
					$this->M_line_patient->insert();
				}
				else{
					$this->M_line_patient->lpt_user_line_id = $line_user_id;
					$user_line_id_data = $this->M_line_patient->get_by_person_line_id();
					if($user_line_id_data->num_rows() == 1){
						$row = $user_line_id_data->row();
						$this->M_line_patient->lpt_user_line_id = $line_user_id;
						$this->M_line_patient->lpt_id = $row->lpt_id;
						$this->M_line_patient->lpt_status = "Y";
						$this->M_line_patient->lpt_update_user = $user->pt_id;
						$this->M_line_patient->lpt_update_date = get_datetime_db();
						$this->M_line_patient->update_for_login();
					}
					else{
						foreach($user_line_id_data->result() as $index => $row){
							if($user->pt_id == $row->lpt_pt_id){
								$this->M_line_patient->lpt_user_line_id = $line_user_id;
								$this->M_line_patient->lpt_id = $row->lpt_id;
								$this->M_line_patient->lpt_status = "Y";
								$this->M_line_patient->lpt_update_user = $user->pt_id;
								$this->M_line_patient->lpt_update_date = get_datetime_db();
								$this->M_line_patient->update_for_login();
							}
							else{
								// $this->M_line_patient->lpt_user_line_id = $line_user_id;
								$this->M_line_patient->lpt_id = $row->lpt_id;
								$this->M_line_patient->lpt_status = "N";
								$this->M_line_patient->lpt_update_user = $row->lpt_update_user;
								$this->M_line_patient->lpt_update_date = get_datetime_db();
								$this->M_line_patient->update_for_login();
							}
						}
					}	
				}
			}

            if($system == 'profile'){ //ข้อมูลส่วนตัว
				// $attributes = array('admin' => $this->session->userdata('UsAdmin'));
				// $this->redirectPost($this->config->item('line_dir').$this->config->item('leave_dir').'Leave/leaveType',$attributes); 
                // redirect($this->config->item('line_dir').'frontend_default','refresh');
                $this->session->set_userdata('line_using_menu', 'profile');
                redirect($this->config->item('ums_dir').'frontend/Dashboard_home_patient','refresh');
			}
			else if($system == 'noti'){ //การแจ้งเตือน
                $this->session->set_userdata('line_using_menu', 'history');
				redirect($this->config->item('ums_dir').'frontend/Dashboard_home_patient','refresh');
			}
			else if($system == 'wts'){  //จัดการการรอคอย
                $this->session->set_userdata('line_using_menu', 'wts');
				redirect($this->config->item('wts_dir').'frontend/User_scan_qrcode','refresh');
			}
			else if($system == 'rch'){  //ตารางแพทย์ออกตรวจ
                $this->session->set_userdata('line_using_menu', 'rch');
				redirect('https://surateyehospital.com/service/%E0%B8%95%E0%B8%B2%E0%B8%A3%E0%B8%B2%E0%B8%87%E0%B8%AD%E0%B8%AD%E0%B8%81%E0%B8%95%E0%B8%A3%E0%B8%A7%E0%B8%88%E0%B9%81%E0%B8%9E%E0%B8%97%E0%B8%A2%E0%B9%8C/','refresh');
			}
            else if($system == 'que'){  //นัดหมาย/จองคิว
                $this->session->set_userdata('line_using_menu', 'que');
                redirect($this->config->item('ums_dir').'frontend/Dashboard_home_patient','refresh');
            }
			
			
        }//if	
		else{
			$this->set_rich_menu($line_user_id, $this->line_menu_login);
			// $this->show_line_login_again();
            redirect($this->config->item('line_dir').'Frontend/frontend_login','refresh');
		}
    }
    //access_system

     /*
	 * login
     * ตรวจสอบการเข้าสู่ระบบ
	 * input : line_user_id, username, password
	 * author: Tanadon
	 * Create Date : 2024-07-14
	 */
    function login()
	{
        $this->load->model($this->config->item('ums_dir').'M_ums_patient');

        $line_user_id = $this->input->post('line_user_id');
        $username = $this->input->post('Username');
        $password = $this->input->post('Password');
        
		// Validate the login credentials
        $user = $this->M_ums_patient->validate_login($username, $password);
        $ip_address = $this->input->ip_address();
        $location = get_location_from_ip($ip_address);
        $location_str = $location ? "{$location['region']}, {$location['country']}" : 'Unknown';
		
        if($user) {
            $data['is_exist'] = true;
            $data['status_line'] = "Y";
            
            // Set user data in session
            $this->session->set_userdata('line_user_id', $line_user_id);
            $this->session->set_userdata('pt_id', $user->pt_id);
            $this->session->set_userdata('pt_member', $user->pt_member);
            $this->session->set_userdata('pt_identification', $user->pt_identification);
            $this->session->set_userdata('pt_passport', $user->pt_passport);
            $this->session->set_userdata('pt_peregrine', $user->pt_peregrine);
            $this->session->set_userdata('pt_prefix', $user->pt_prefix);
            $this->session->set_userdata('pt_fname', $user->pt_fname);
            $this->session->set_userdata('pt_lname', $user->pt_lname);

            // Validate the login credentials
            $ip_address = $this->input->ip_address();
            $location = get_location_from_ip($ip_address);
            $location_str = $location ? "{$location['region']}, {$location['country']}" : 'Unknown';

            // รับ IP address
            $log_data = array(
                'pl_pt_id' => $user->pt_id,
                'pl_date' => date('Y-m-d H:i:s'),
                'pl_changed' => 'เข้าสู่ระบบสำเร็จ',
                'pl_ip' => $ip_address.' '.$location_str,
                'pl_agent' => 'Line'
            );
            $this->M_ums_patient->log_login($log_data);
            

            $this->M_line_patient->lpt_pt_id = $user->pt_id;
            $user_line_data = $this->M_line_patient->get_by_person_id();
            
            if ($user_line_data->num_rows() == 0) {
                // กรณีไม่มีข้อมูลในฐานข้อมูล ให้ทำการบันทึกใหม่
                $this->M_line_patient->lpt_user_line_id = $line_user_id;
                $this->M_line_patient->lpt_status = "Y";
                $this->M_line_patient->lpt_create_user = $user->pt_id;
                $this->M_line_patient->lpt_create_date = get_datetime_db();
                $this->M_line_patient->insert();
            } else {
                // หากมีข้อมูลอยู่แล้ว
                $this->M_line_patient->lpt_user_line_id = $line_user_id;
                $this->M_line_patient->lpt_pt_id = $user->pt_id;
                $user_line_id_data = $this->M_line_patient->get_by_person_line_id_pt_id();
            
                if ($user_line_id_data->num_rows() == 0) {
                    // กรณีไม่มีรายการที่ตรงกับ pt_id แต่ตรงกับ line_user_id
                    $row = $user_line_id_data->row();
                    $this->M_line_patient->lpt_id = $row->lpt_id;
                    $this->M_line_patient->lpt_status = "Y";
                    $this->M_line_patient->lpt_update_user = $user->pt_id;
                    $this->M_line_patient->lpt_update_date = get_datetime_db();
                    $this->M_line_patient->update();
                } elseif ($user_line_id_data->num_rows() == 1) {
                    // กรณีมีข้อมูลที่ตรงกับ pt_id
                    $row = $user_line_id_data->row();
                    $this->M_line_patient->lpt_id = $row->lpt_id;
                    $this->M_line_patient->lpt_status = "Y";
                    $this->M_line_patient->lpt_update_user = $user->pt_id;
                    $this->M_line_patient->lpt_update_date = get_datetime_db();
                    $this->M_line_patient->update_for_login();
                } else {
                    // กรณีมีหลายรายการที่ตรงกับ line_user_id
                    foreach ($user_line_id_data->result() as $row) {
                        if ($user->pt_id == $row->lpt_pt_id) {
                            // กรณี pt_id ตรงกัน
                            $this->M_line_patient->lpt_id = $row->lpt_id;
                            $this->M_line_patient->lpt_status = "Y";
                            $this->M_line_patient->lpt_update_user = $user->pt_id;
                            $this->M_line_patient->lpt_update_date = get_datetime_db();
                            $this->M_line_patient->update_for_login();
                        } else {
                            // กรณี pt_id ไม่ตรงกัน
                            $this->M_line_patient->lpt_id = $row->lpt_id;
                            $this->M_line_patient->lpt_user_line_id = NULL;
                            $this->M_line_patient->lpt_status = "N";
                            $this->M_line_patient->lpt_update_user = $row->lpt_update_user;
                            $this->M_line_patient->lpt_update_date = get_datetime_db();
                            $this->M_line_patient->update_for_login();
                        }
                    }
                }
            }
            
            $data['richmenu'] = $this->line_menu_main;
            $this->set_rich_menu($line_user_id, $data['richmenu']);
        }
        else{
            $data['is_exist'] = false;
            $data['status_line'] = "N";
        }
            
		
        echo json_encode($data);
	}
	//login

    /*
	 * redirectPost
     * รีไดเรคตาม url และ พารามิเตอร์
	 * input : $encodeJson, $datas
	 * author: Tanadon
	 * Create Date : 2024-07-16
	 */
	function redirectPost($uri,$value="") {

		// Create Form
		$attributes = array('id' => 'redirectPost','name' => 'redirectPost');
		echo form_open($uri, $attributes);

		// Create Input By Value
		if(is_array($value)){
			foreach($value as $key=>$val){
				echo '<input type="hidden" name="'.$key.'" value="'.$val.'"/>';
			}
		}

		// Close Form
		echo form_close();

		// Submit Form
		echo '<script>document.getElementById("redirectPost").submit();</script>';
	}
	//redirectPost
	
}
