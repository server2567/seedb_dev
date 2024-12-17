<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once(dirname(__FILE__) . "/ums/UMS_Controller.php"); //Include file มาเพื่อ extend
class Gear extends UMS_Controller{
/* version 1.7 update 11/03/2557 */
public $ums;
public $ums_db;
	public function __construct()
	{
		parent::__construct();
		$this->load->model('ums/m_ums_user');
		$this->load->model('ums/m_ums_usergroup');
		$this->load->model('ums/m_ums_system');
		$this->load->model('ums/m_umlog'); //m_umlog
		$this->load->model('ums/m_ums_user'); //m_umlog
		$this->load->model('ums/Genmod', 'genmod');
    $this->ums = $this->load->database('ums', true);
    $this->ums_db = $this->ums->database;
	}
	public function index()
	{
		if ($this->checkUser()) {// Have Session data
			$data['permission'] = $this->m_ums_usergroup->get_gear()->result_array();
			$data['mission'] = $this->m_ums_usergroup->get_mission()->result_array(); 
			$data['system'] = $this->m_ums_usergroup->get_system()->result_array();

			$data['save'] = explode("?", get_cookie('gear' . $this->session->userdata('us_id')));

			$qry_check_more_menu = $this->m_ums_user->get_data_check_more_umusergroup($this->session->userdata('us_id'));
			$data['qry_check_more_menu'] = $qry_check_more_menu;
			// print_r($this->session->all_userdata());
			//   $this->login();
			redirect($this->config->item('pd_dir').'Home', 'refresh');
		} else {
			$this->login();
			// redirect('personal_dashboard/Personal_dashboard', 'refresh');
			//redirect('https://'.base_url().'/index.php/gear/login','refresh');
		}
	}

	public function index_ams()
	{
		if ($this->checkUser()) {// Have Session data
			$data['permission'] = $this->m_ums_usergroup->get_gear()->result_array();
			$data['mission'] = $this->m_ums_usergroup->get_mission()->result_array(); 
			$data['system'] = $this->m_ums_usergroup->get_system()->result_array();

			$data['save'] = explode("?", get_cookie('gear' . $this->session->userdata('us_id')));

			$qry_check_more_menu = $this->m_ums_user->get_data_check_more_umusergroup($this->session->userdata('us_id'));
			$data['qry_check_more_menu'] = $qry_check_more_menu;
      echo 'dddd'; die;
			redirect(site_url().'/ams/Notification_result', 'refresh');
		} else {
			$this->login();
		}
	}

	public function login()
	{
    
		force_ssl();
		delete_cookie($this->config->item('sess_cookie_name'));



    $data['departments'] = $this->ums->select('dp_id, dp_name_th')->from('ums_department')->get()->result_array();

    $this->load->view('gear/v_gear_login',$data);
	}

	function check_login($us_dp_id = '',$us_his_id = '')
	{
		// some logic with MD5 to query
    // echo $us_his_id; die;
    if($us_his_id){
      $us_dp_id = $us_dp_id;
      $user = $this->m_ums_user->check_login_his($us_his_id); 
      // pre($user->result_array()); die;
    } else {
      $us_dp_id = $this->input->post('department');
      $user = $this->m_ums_user->check_login($_POST['username'],md5("O]O".$_POST['password']."O[O")); 
    }
		// check it can log in ?
    // pre($user->result()); die;		// check it can log in ?
    if ($user == false) {

			if($this->config->item('ldap_on')=="on"){

				$this->load->library('service_ldap');
				$this->service_ldap->connect();
				if($this->service_ldap->authenticate($_POST['username'],$_POST['password']))
          {
            
            $user = $this->m_ums_user->check_user($_POST['username']);
            if(!$user)
            {
              $this->m_umlog->loginfailed();
            }
            else
            {
              $usr = $user->row_array();

              $this->session->set_userdata('us_id', $usr['us_id']);
              $this->session->set_userdata('us_ps_id', $usr['us_ps_id']);
              $this->session->set_userdata('us_username', $usr['us_username']);
              $this->session->set_userdata('us_dp_id', $us_dp_id);
              $this->session->set_userdata('us_name', $usr['us_name']);
              $this->session->set_userdata('dp_name_th', $usr['dp_name_th']);
              $this->session->set_userdata('logged_in', TRUE);
              $this->m_umlog->login();
            }
          }
				else
				{
				// when log in fail it have 2 case
				// If it has user but password wrong
					$user = $this->m_ums_user->check_user($_POST['username']);
          if ($user) {
            foreach ($user->result_array() as $usr) {
                $this->m_umlog->wrongpass($usr['us_id']);
                break;
            }

        } // or It don't have Account
					// or It don't have Account
					else
					{
            
						$this->m_umlog->loginfailed();
					}
				}
				$this->service_ldap->close(); 	
			}else{

          // Sanitize and validate the input username
          if ($us_his_id && $user == false) {
            // ตรวจสอบว่ามีข้อมูลก่อนจะเรียกใช้ row()
            if ($user) {
                $user_data = $user->row(); // ดึงข้อมูลแถวแรก
                $username = $user_data->us_username;
              } else {
                // ใช้ SweetAlert2 เพื่อแสดงการแจ้งเตือน
                $site_url = $this->site_url(); // ดึง URL ของคุณก่อน
                echo '
                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                <script>
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                        icon: "error",
                        title: "ไม่พบข้อมูลผู้ใช้งาน",
                        confirmButtonText: "ยืนยัน"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "' . $site_url . '/index.php/gear";
                        }
                    });
                });
                </script>';
            }
            } else {
                // กรณีที่ $us_his_id ไม่มีหรือไม่มีข้อมูลใน query
                $username = trim($_POST['username']);
            }
          if (empty($username)) {

              // Handle the case where username is empty
              $this->m_umlog->loginfailed();
              exit; // Exit if username is not provided
          }

          // Check if the username exists in the database
          $user = $this->m_ums_user->check_user($username);

          if ($user && !empty($user->result_array())) {
              // If user exists, log the wrong password attempt for the first found user
              $usr = $user->result_array()[0];
              $this->m_umlog->wrongpass($usr['us_id']);
              
          } else {
              // If user does not exist, log the login failed attempt
              $this->m_umlog->loginfailed();
              $data['login'] = 'loginfailed';
              $this->load->view('gear/v_gear_login',$data);
          }
          
			}
 
      // $this->load->view('gear/v_gear_login');
      // redirect('gear/login', 'refresh');
      // $this->service_ldap->close();
		}
		else
		{
      
			// create a session to log in this main system
			foreach ($user->result_array() as $usr)
			{
				$this->session->set_userdata('us_id',$usr['us_id']);
				$this->session->set_userdata('us_ps_id',$usr['us_ps_id']);
				$this->session->set_userdata('us_username',$usr['us_username']);
				$this->session->set_userdata('us_dp_id',$us_dp_id);
				$this->session->set_userdata('us_name',$usr['us_name']);
				$this->session->set_userdata('dp_name_th',$usr['dp_name_th']);
				$this->session->set_userdata('us_his_id',$usr['us_his_id']);
				// $this->session->set_userdata('menus',$usr['dp_name_th']);
				// $this->session->set_userdata('UsWgID',$usr['UsWgID']);
				// $this->session->set_userdata('UsAdmin',$usr['UsAdmin']);
				$this->session->set_userdata('logged_in',TRUE);
        // Update the ums_user table with the selected department
        $this->ums->where('us_id', $usr['us_id']);
        $this->ums->update('ums_user', ['us_dp_id' => $us_dp_id]);

				$this->m_umlog->login();
				break;
			}
			
			$data['return_url'] = base_url() . 'index.php/Gear';
			$data['status_response'] = $this->config->item('status_response_success');
		}

		// if($_POST['username'] == $_POST['password'])
		// {
    //   die;
      $this->index();
			// redirect('user/check_pass_change', 'refresh');
		// } else {
    //   $this->index();
    //   // redirect('gear/index','refresh');
    // }

		// redirect('Gear', 'refresh');
		
		// $result = array('data' => $data);
		// echo json_encode($result);	// return to jQuery.post()
	}

	function check_login_ams($us_dp_id = '',$us_his_id = '')
	{
		// some logic with MD5 to query
    // echo $us_his_id; die;
    if($us_his_id){
      $us_dp_id = $us_dp_id;
      $user = $this->m_ums_user->check_login_his($us_his_id); 
      // pre($user->result_array()); die;
    } else {
      $us_dp_id = $this->input->post('department');
      $user = $this->m_ums_user->check_login($_POST['username'],md5("O]O".$_POST['password']."O[O")); 
    }

		// check it can log in ?
    // pre($user->result()); die;		// check it can log in ?
    if ($user == false) {
			if($this->config->item('ldap_on')=="on"){

				$this->load->library('service_ldap');
				$this->service_ldap->connect();
				if($this->service_ldap->authenticate($_POST['username'],$_POST['password']))
          {
            
            $user = $this->m_ums_user->check_user($_POST['username']);
            if(!$user)
            {
              $this->m_umlog->loginfailed();
            }
            else
            {
              $usr = $user->row_array();

              $this->session->set_userdata('us_id', $usr['us_id']);
              $this->session->set_userdata('us_ps_id', $usr['us_ps_id']);
              $this->session->set_userdata('us_username', $usr['us_username']);
              $this->session->set_userdata('us_dp_id', $us_dp_id);
              $this->session->set_userdata('us_name', $usr['us_name']);
              $this->session->set_userdata('dp_name_th', $usr['dp_name_th']);
              $this->session->set_userdata('logged_in', TRUE);
              $this->m_umlog->login();
            }
          }
				else
				{
				// when log in fail it have 2 case
				// If it has user but password wrong
					$user = $this->m_ums_user->check_user($_POST['username']);
          if ($user) {
            foreach ($user->result_array() as $usr) {
                $this->m_umlog->wrongpass($usr['us_id']);
                break;
            }

        } // or It don't have Account
					// or It don't have Account
					else
					{
            
						$this->m_umlog->loginfailed();
					}
				}
				$this->service_ldap->close(); 	
			}else{
          // Sanitize and validate the input username
          if ($us_his_id && $user == false) {
            // ตรวจสอบว่ามีข้อมูลก่อนจะเรียกใช้ row()
            if ($user) {
                $user_data = $user->row(); // ดึงข้อมูลแถวแรก
                $username = $user_data->us_username;
              } else {
                // ใช้ SweetAlert2 เพื่อแสดงการแจ้งเตือน
                $site_url = $this->site_url(); // ดึง URL ของคุณก่อน
                echo '
                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
                <script>
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                        icon: "error",
                        title: "ไม่พบข้อมูลผู้ใช้งาน",
                        confirmButtonText: "ยืนยัน"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "' . $site_url . '/index.php/gear";
                        }
                    });
                });
                </script>';
            }
            } else {
                // กรณีที่ $us_his_id ไม่มีหรือไม่มีข้อมูลใน query
                $username = trim($_POST['username']);
            }
          if (empty($username)) {

              // Handle the case where username is empty
              $this->m_umlog->loginfailed();
              exit; // Exit if username is not provided
          }

          // Check if the username exists in the database
          $user = $this->m_ums_user->check_user($username);

          if ($user && !empty($user->result_array())) {
              // If user exists, log the wrong password attempt for the first found user
              $usr = $user->result_array()[0];
              $this->m_umlog->wrongpass($usr['us_id']);
              
          } else {
              // If user does not exist, log the login failed attempt
              $this->m_umlog->loginfailed();
              $data['login'] = 'loginfailed';
              $this->load->view('gear/v_gear_login',$data);
          }
          
			}
 
      // $this->load->view('gear/v_gear_login');
      // redirect('gear/login', 'refresh');
      // $this->service_ldap->close();
		}
		else
		{
			// create a session to log in this main system
			foreach ($user->result_array() as $usr)
			{
				$this->session->set_userdata('us_id',$usr['us_id']);
				$this->session->set_userdata('us_ps_id',$usr['us_ps_id']);
				$this->session->set_userdata('us_username',$usr['us_username']);
				$this->session->set_userdata('us_dp_id',$us_dp_id);
				$this->session->set_userdata('us_name',$usr['us_name']);
				$this->session->set_userdata('dp_name_th',$usr['dp_name_th']);
				$this->session->set_userdata('us_his_id',$usr['us_his_id']);
				// $this->session->set_userdata('menus',$usr['dp_name_th']);
				// $this->session->set_userdata('UsWgID',$usr['UsWgID']);
				// $this->session->set_userdata('UsAdmin',$usr['UsAdmin']);
				$this->session->set_userdata('logged_in',TRUE);
        // Update the ums_user table with the selected department
        $this->ums->where('us_id', $usr['us_id']);
        $this->ums->update('ums_user', ['us_dp_id' => $us_dp_id]);

				$this->m_umlog->login();
				break;
			}
      
      redirect(site_url().'/ams/Notification_result', 'refresh');
			// $data['return_url'] = base_url() . 'index.php/Gear/index_ams';
      // pre($data['return_url']); die;
			$data['status_response'] = $this->config->item('status_response_success');
		}

		// if($_POST['username'] == $_POST['password'])
		// {
    //   die;
      $this->index();
			// redirect('user/check_pass_change', 'refresh');
		// } else {
    //   $this->index();
    //   // redirect('gear/index','refresh');
    // }

		// redirect('Gear', 'refresh');
		
		// $result = array('data' => $data);
		// echo json_encode($result);	// return to jQuery.post()
	}


	public function forgetPassword()
	{
		$this->load->view('gear/v_gear_forgetPassword');
	}

	public function changePassword()
	{
		$this->load->view('gear/v_changepassword');
	}

	function check_old_password(){

		$this->m_ums_user->us_password = md5("O]O" .$this->input->post('old-password') . "O[O");
		$this->m_ums_user->us_id = $this->session->userdata('us_id');
		$count_data = $this->m_ums_user->check_password()->row()->count_data;
		// echo $this->m_ums_user->ums->last_query();
		echo json_encode($count_data);
	}

	public function changePasswordUpdate()
	{
		$this->m_ums_user->us_password = md5("O]O" . $this->input->post('password') . "O[O");
		$this->m_ums_user->us_password_confirm = md5("O]O" . $this->input->post('password') . "O[O");
		$this->m_ums_user->us_id = $this->session->userdata('us_id');
		$this->m_ums_user->resetpassword();
		echo json_encode("success");
	}

	function set_gear($st_id, $url_param="")
	{	
		// remove old session off this system
		// $this->session->unset_userdata('gp_id');
		$this->session->unset_userdata('st_id');
		$this->session->unset_userdata('st_home_url');
		$this->session->unset_userdata('st_name_abbr_en');
		$this->session->unset_userdata('us_groups');

		// // logging
		// $GpName=$this->m_umgroup->get_name($gp_id);
		// $this->session->set_userdata('GpName',$GpName);
		
		if(!empty($st_id)) {
			$this->load->model('ums/m_ums_group');
			$this->load->model('hr/structure/M_hr_structure_detail');

			// if($url_param != "" && $st_id == 7){	//QUE
			// 	$st_id = 6; //WTS
			// }
			
			$system = $this->m_ums_system->get_by_id($st_id);
			
			$system = $system->row_array();
			$this->session->set_userdata('st_id',(int)$st_id);
			
			$this->session->set_userdata('st_name_abbr_en', $system['st_name_abbr_en']);
			
			// check first page by url from system or group
			if(!empty($url_param)){
				$url = str_replace(".", "/", $url_param);
				$this->session->set_userdata('st_home_url', $url);
			}
			else{
				$url = $system['st_url']; // set default url is url from system
				$this->session->set_userdata('st_home_url', $system['st_url']);
			}
			
			$us_id = $this->session->userdata('us_id');
			
			$this->m_ums_group->gp_st_id = $st_id;
			$result = $this->m_ums_group->get_by_user_and_system_id($us_id)->result_array();
			if ($result && count($result) > 0) { // This use input type hidden to post Link of that ums_group to go to it
				if(!empty($result[0]['gp_url']) && empty($url_param)) // if have multi ums_group then user index 0
					$url = $result[0]['gp_url'];
					
				$groups = array_map(function($item) {
					return [
						'gp_id' => $item['gp_id'],
						'gp_name_th' => $item['gp_name_th'],
						'gp_is_medical' => $item['gp_is_medical']
					];
				}, $result);
				$this->session->set_userdata('us_groups', $groups);
			} else {
				$this->session->set_userdata('us_groups', []);
			}

			$stucture_person = $this->M_hr_structure_detail->get_stde_all_by_person_id($this->session->userdata('us_ps_id'))->result_array();
			if ($stucture_person && count($stucture_person) > 0) { // This use input type hidden to post Link of that ums_group to go to it
				$stde_person = array_map(function($item) {
					return [
						'stde_id' => $item['stde_id'],
						'stde_name_th' => $item['stde_name_th']
					];
				}, $stucture_person);
				$this->session->set_userdata('stde_person', $stde_person);
			} else {
				$this->session->set_userdata('stde_person', []);
			}
			
			// (from UMS_Controller) save log ums_user_logs_menu by data => session
			$this->insert_log_menu();

			 // Do once when login system
			$this->set_menu_sidebar();

			redirect($url,'refresh');
		}
	}

	function saveGear()
	{
		/*if($this->session->userdata('save')) for old version get save data from session
		{
			$this->session->unset_userdata('save');
		}
		$this->session->set_userdata('save',$this->input->post('contents',TRUE));*/
		delete_cookie('gear'.$this->session->userdata('us_id'));
		set_cookie('gear'.$this->session->userdata('us_id'),$this->input->post('contents',TRUE),60*60*24*90);
	}
	function logout()
	{
		// $this->m_umlog->logout();
		// $this->session->unset_userdata('HOME');
		// $this->session->unset_userdata('URL');
		// $this->session->unset_userdata('MnID');
		// $this->session->unset_userdata('MnURL');
		// $this->session->unset_userdata('MnNameT');
		// $this->session->unset_userdata('UsID');
		// $this->session->unset_userdata('GpID');
		// $this->session->unset_userdata('StID');
		// $this->session->unset_userdata('UsPsCode');
		// $this->session->unset_userdata('UsLogin');
		// $this->session->unset_userdata('SysName');
		// $this->session->unset_userdata('UsName');
		// $this->session->unset_userdata('dpName');
		// $this->session->unset_userdata('logged_in');
		// $this->session->unset_userdata('GpName');
		// $this->session->unset_userdata('UsWgID');
		// $this->session->unset_userdata('UsAdmin');
		
		$this->session->unset_userdata('us_id');
		$this->session->unset_userdata('us_ps_id');
		$this->session->unset_userdata('us_username');
		$this->session->unset_userdata('us_dp_id');
		$this->session->unset_userdata('us_name');
		$this->session->unset_userdata('dp_name_th');
		$this->session->unset_userdata('logged_in');
		$this->session->unset_userdata('us_his_id');
		
		$this->session->unset_userdata('st_id');
		$this->session->unset_userdata('st_home_url');
		$this->session->unset_userdata('st_name_abbr_en');
		$this->session->unset_userdata('menus_sidebar');
		
		$this->session->unset_userdata('language');

		$this->session->unset_userdata('us_groups');
		$this->session->unset_userdata('eqs_rm_id'); // for [DIM]
		$this->session->unset_userdata('wts_stde_id'); // for [WTS]
		$this->session->unset_userdata('wts_floor_of_manage_queue'); // for [WTS]
		
    $this->session->sess_destroy();



		redirect('gear','refresh');
	}
	function changelang($oldurl){

		if($this->session->userdata('Language')=="TH"){
			$this->session->set_userdata('Language',"EN");
		}else if($this->session->userdata('Language')=="EN"){
			$this->session->set_userdata('Language',"TH");
		}
		redirect(str_replace("..","/",$oldurl),'refresh');
	}
	// function error()
	// {
	// 	$this->output('error');
	// }
	/*
	* frontend_login
	* screen of frontend login
	* @input -
	* $output screen of frontend login
	* @author ???
	* @Create Date ???
	* @Update Date 04/09/2024 Areerat Pongurai - check have user session before then goto [UMS] frontend page else goto frontend login
	*/
  function frontend_login(){
		$data['arr'] = array();
		// $this->output_frontend('gear/v_gear_frontend_login',$data); 
		if(empty($this->session->userdata('pt_id')))
			$this->output_frontend('gear/v_gear_frontend_login',$data); 
		else
			redirect('ums/frontend/Dashboard_home_patient','refresh');
	}


  function frontend_forget(){
    $data['arr'] = array();
    $this->output_frontend('gear/v_gear_frontend_forget',$data); 
  }

  function frontend_register(){
    $this->load->model('hr/base/M_hr_prefix');
    $this->load->model('ums/M_ums_patient');
    $data['get_prefix'] = $this->M_hr_prefix->get_prefix_all()->result_array();
    




    $this->output_frontend('gear/v_gear_frontend_register',$data); 
  }

  function frontend_privacy_policy(){
    $data['ddd'] = array();
		$data['edit'] = $this->genmod->getOne('see_umsdb', 'ums_policy', '*', array('policy_status =' => 1));
		$policyDetailsArray = [];
		// แยก string เป็น array ตาม comma
		$entries = explode(", ", $data['edit']->policy_text);
		foreach ($entries as $entry) {
			// ใช้ preg_match เพื่อแยก index และค่า
			if (preg_match('/(\d+): (.+)/', $entry, $matches)) {
				$index = $matches[1];
				$value = $matches[2];
				$policyDetailsArray[$index] = $value;
			}
		}
		$data['DetailsArray'] = $policyDetailsArray; // แสดง array ที่แปลงกลับมา
    $this->output_frontend('gear/v_gear_frontend_privacy_policy',$data); 
  }

  function frontend_reset_password(){
    $data['arr'] = array();
    if($this->session->userdata('verified_user')) { 
      $this->output_frontend('gear/v_gear_frontend_reset_password',$data); 
    } else {
      redirect('gear/frontend_login','refresh');
    }
  }


}
?>
