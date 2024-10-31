<?php 
/*
* User_sync_hr
* Main controller of User_sync_hr
* @input -
* $output -
* @author Areerat Pongurai
* @Create Date 27/05/2024
*/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once('UMS_Controller.php');

class User_sync_hr extends UMS_Controller{
	// Create __construct for load model use in this controller
	public function __construct() {
		parent::__construct();
	}

	/*
	* index
	* Index controller of User_sync_hr
	* @input -
	* $output screen for sync hr
	* @author Areerat Pongurai
	* @Create Date 27/05/2024
	*/
	public function index() {
		$this->load->model('ums/m_ums_sync');
		$order = array('sync_file_name'=>'DESC');
		$syncs = $this->m_ums_sync->get_all_with_user($order)->result_array();

		// encrypt id
		$names = ['sync_id']; // object name need to encrypt 
		$data['syncs'] = encrypt_arr_obj_id($syncs, $names);

		$data['session_mn_active_url'] = $this->uri->segment(1) . '/' . $this->uri->segment(2); // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');
		$this->output('ums/user/v_user_sync_hr_form',$data);
	}

	/*
	* sync_hr
	* for sync hr persons data
	* @input -
	* $output html row of persons from hr
	* @author Areerat Pongurai
	* @Create Date 27/05/2024
	*/
	public function sync_hr() {
		// $this->da_ums_sync->UsDpID = $this->session->userdata('UsDpID');
		// $this->da_ums_sync->HRDB = $this->da_ums_sync->HRDB;
		// $groupname = $this->m_umwgroup->get_all();
		$this->load->model('ums/m_ums_sync');
		$firstname = $this->input->post('firstname');
		$lastname = $this->input->post('lastname');
		
		if(!empty($firstname) || !empty($lastname))
			$persons = $this->m_ums_sync->get_sync_search($firstname, $lastname)->result_array();
		else
			$persons = $this->m_ums_sync->get_sync_all()->result_array();
			
		header ('Content-type: text/html; charset=utf-8');

		// us_dp_id hard code = 0
		$i = 1;
		foreach($persons as $row){
			$ps_id = encrypt_id($row['ps_id']);
			$dp_id = encrypt_id(0);
			$check_us_ps_id = encrypt_id($row['us_ps_id']);
			$check_us_id = encrypt_id($row['us_id']);
			$is_have_user = !empty($check_us_id) && !empty($row['us_username']);

			echo "<tr>";
			echo "<td>".$i."</td>";

			// <input class='form-control' type='hidden' name='us_psd_id_card_no[]' value='".$row['psd_id_card_no']."' />
			echo "<td>
				<input class='form-control' type='hidden' name='us_ps_id[]' value='".$ps_id."' />
				<input class='form-control' type='hidden' name='us_dp_id[]' value='".$dp_id."' /> 
				<input class='form-control' type='hidden' name='check_us_ps_id[]' value='".$check_us_ps_id."' /> 
				<input class='form-control' type='hidden' name='check_us_id[]' value='".$check_us_id."' /> 
				<input class='form-control' type='hidden' name='us_name[]' value='".$row['name']."' /> 
				<input class='form-control' type='text' name='us_name_disabled[]' value='".$row['name']."' required disabled />
				<div class='invalid-feedback'>กรุณาระบุข้อมูล</div>
				</td>";
			echo "<td>
				<input class='form-control' type='email' name='us_email[]' value='".$row['psd_email']."' required />
				<div class='invalid-feedback'>กรุณาระบุข้อมูล</div>
				</td>";

			if($is_have_user) {	// case check from psd_id_card_no then have us_username but no have us_ps_id
				$check = "มีข้อมูลผู้ใช้งานคนนี้แล้วในระบบ UMS";
				$username = $row['us_username'];

				echo "<td>
						<input class='form-control input-username' type='hidden' name='us_username[]' value='".$username."' />
						<input class='form-control input-username' type='text' name='us_username_disabled[]' value='".$username."' required disabled />
						<div class='mt-2'>
							<span class='validate-username text-warning'>$check</span>
						</div>
					</td>";
			} else if(!empty($row['ps_fname_en']) && !empty($row['ps_lname_en'])) { // case normal sync valid
				$check = "";
				$username = strtolower($row['ps_fname_en'].".".substr($row['ps_lname_en'],0,1));

				echo "<td> $check
						<input class='form-control input-username' type='text' name='us_username[]' value='".$username."' required />
						<div class='mt-2'>
							<button type='button' class='btn btn-outline-secondary check-username' onclick='valid(this)'>validate</button>
							<span class='validate-username'>OK!</span>
						</div>
					</td>";
			} else { // case normal sync invalid
				$check = "ไม่พบข้อมูลสำหรับนำมาสร้าง Username";
				$username = "";

				echo "<td> $check
						<input class='form-control input-username' type='text' name='us_username[]' value='".$username."' required />
						<div class='mt-2'>
							<button type='button' class='btn btn-outline-secondary check-username' onclick='valid(this)'>validate</button>
							<span class='validate-username'>OK!</span>
						</div>
					</td>";
			}

			if($is_have_user) {	// case check from psd_id_card_no then have us_username but no have us_ps_id
				$check = "มีข้อมูลผู้ใช้งานคนนี้แล้วในระบบ UMS";
				$password = "";
				
				echo "<td>
						<input class='form-control input-password' type='hidden' name='us_password[]' value='".$password."' />
						<input class='form-control input-password' type='text' name='us_password_disabled[]' value='".$password."' disabled />
						<div class='mt-2'>
							<span class='validate-username text-warning'>$check</span>
						</div>
					</td>";
			// 20240901 Areerat แก้ให้ password = username เลย
			} else if(!empty($row['ps_fname_en']) && !empty($row['ps_lname_en'])) { // case normal sync valid
			// } else if(!empty($row['ps_lname_en']) && !empty($row['psd_birthdate'])) { // case normal sync valid
				// $check = '';
				// $birthdate = $date = new DateTime($row['psd_birthdate']);
				// $birthdate_year = $date->format('Y') + 543;
				// $password = strtolower($row['ps_fname_en'].$birthdate_year);
				$check = "";
				$password = strtolower($row['ps_fname_en'].".".substr($row['ps_lname_en'],0,1));

				// $validate = '<span class="text-success">OK!</span>';
			
				echo "<td> $check
						<input class='form-control input-password' type='text' name='us_password[]' value='".$password."' required />
						<div class='invalid-feedback'>กรุณาระบุข้อมูล</div>
					</td>";
			} else { // case normal sync invalid
				$check = "ไม่พบข้อมูลสำหรับนำมาสร้าง Password";
				$password = "";
				echo "<td> $check
						<input class='form-control input-password' type='text' name='us_password[]' value='".$password."' required />
						<div class='invalid-feedback'>กรุณาระบุข้อมูล</div>
					</td>";
			}

			echo "<td class='text-center option'>
					<button type='button' class='btn btn-danger delete' onclick='delete_row(this)'><i class='bi-trash'></i></button>
				</td>";
			echo "</tr>";

			$i++;
		}
	}

	/*
	* sync_hr_check_username
	* for check username is duplicate in db or not
	* @input username
	* $output boolean
	* @author Areerat Pongurai
	* @Create Date 27/05/2024
	*/
	public function sync_hr_check_username($username) {
		$this->load->model('ums/m_ums_sync');
		$is_empty = $this->m_ums_sync->check_username($username);
		header ('Content-type: text/html; charset=utf-8');
		echo $is_empty;
	}

	/*
	* sync_hr_syncing
	* for sync hr persons data in db and create pdf data of this sync
	* @input -
	* $output data from form
	* @author Areerat Pongurai
	* @Create Date 27/05/2024
	*/
	public function sync_hr_syncing() {
		//Default User
		// $DefaultSyncWgID = 10; // WgID from umwgroup table
		// $DefaultSyncDpID = $this->session->userdata('UsDpID');  // DpID from umdepartment table
		$default_sync_dp_id = 1;  // dp_id from ums_department table
		
		// Inputs
		$check_us_ps_id = $this->input->post('check_us_ps_id');
		$check_us_id = $this->input->post('check_us_id');
		$us_ps_id = $this->input->post('us_ps_id');
		// $us_psd_id_card_no = $this->input->post('us_psd_id_card_no');
		$us_dp_id = $this->input->post('us_dp_id');
		$us_name = $this->input->post('us_name');
		$us_email =  $this->input->post('us_email');
		$us_username = $this->input->post('us_username');
		$us_password = $this->input->post('us_password');

		$this->load->model('hr/m_hr_person_detail');
		$this->load->model('ums/m_ums_user');
		$session_us_id = $this->session->userdata('us_id');
		$this->m_ums_menu->mn_create_user = $session_us_id;
		$this->m_ums_menu->mn_update_user = $session_us_id;
		$this->m_ums_user->us_sync = 1;
		$this->m_ums_user->us_active = 1;
		
		$user_insert = [];
		foreach($us_ps_id as $key => $person){
			$password = $us_password[$key];
			$ps_id = decrypt_id($person);
			// $us_psd_id_card_no = decrypt_id($us_psd_id_card_no[$key]);
			$dp_id = decrypt_id($us_dp_id[$key]);

			$this->m_ums_user->us_ps_id = $ps_id;
			$this->m_ums_user->us_name = $us_name[$key];
			$this->m_ums_user->us_email = $us_email[$key];
			$this->m_ums_user->us_username = $us_username[$key];
			$this->m_ums_user->us_password = md5("O]O".$password."O[O");

			$this->m_hr_person_detail->psd_ps_id = $ps_id;
			$us_psd_id_card_no = $this->m_hr_person_detail->get_by_key()->result_array()[0]['psd_id_card_no'];
			$this->m_ums_user->us_psd_id_card_no = $us_psd_id_card_no;

			if($dp_id != 0){
				$this->m_ums_user->us_dp_id = $default_sync_dp_id;
			}else{
				$this->m_ums_user->us_dp_id = $default_sync_dp_id;
			}
			
			if (empty($check_us_ps_id[$key]) && !empty($check_us_id[$key])) {
				$this->m_ums_user->us_update_user = $session_us_id;
				$this->m_ums_user->us_id = decrypt_id($check_us_id[$key]);
				$this->m_ums_user->update_sync_user();

				$password = "(มีข้อมูลผู้ใช้งานคนนี้แล้วในระบบ ไม่สามารถแสดงรหัสผ่านได้)";
			} else {
				$this->m_ums_user->us_id = null;
				$this->m_ums_user->insert();
			}

			$user_insert[] = (object) ['us_name' => $us_name[$key], 'us_username' => $us_username[$key], 'us_password' => $password, 'us_email' => $us_email[$key]];

			// send e mail show username and password of user
			// username & password can change if user want to change
			//
			/*
			*	edit here!!!! gif
			*/
		}
		
		// save log
		$this->m_ums_logs->insert_log("นำเข้าข้อมูลบุคลากร");
		
		if(count($user_insert) > 0){
			ob_start();

			$defaultConfig = (new Mpdf\Config\ConfigVariables())->getDefaults();
			$fontDirs = $defaultConfig['fontDir'];
			$defaultFontConfig = (new Mpdf\Config\FontVariables())->getDefaults();
			$fontData = $defaultFontConfig['fontdata'];

			$mpdf = new \Mpdf\Mpdf();
			$mpdf = new \Mpdf\Mpdf([
						'tempDir' => sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'mpdf',
						'fontDir' => array_merge($fontDirs, [
							__DIR__ . '/fonts',
						]),
						'fontdata' => $fontData + [
							'sarabun' => [
							'R' => 'THSarabunNew.ttf',
							'I' => 'THSarabunNewItalic.ttf',
							'B' =>  'THSarabunNewBold.ttf',
							'BI' => "THSarabunNewBoldItalic.ttf",
							]
						],
					]);
			$mpdf->allow_charset_conversion = true;
			$mpdf->charset_in = 'UTF-8';
			$mpdf->autoScriptToLang = true;
			$mpdf->shrink_tables_to_fit = 1;
			$mpdf->showImageErrors = true;
			$mpdf->curlAllowUnsafeSslRequests = true;
			$mpdf->useDictionaryLBR = false;
			$mpdf->setAutoTopMargin = 'stretch';
	  
			$mpdf->AddPageByArray([
				'margin-left' => '6mm',
				'margin-right' => '6mm',
				'margin-top' => '2mm',
				'margin-bottom' => '2mm',
			]);
			$mpdf->setDisplayMode('fullpage');
			
			$data['user_insert'] = $user_insert;
			$data['date'] = date('d-m-Y เวลา H:i น.');
			$html = $this->load->view('ums/user/v_user_sync_hr_pdf', $data, true);

			$mpdf->WriteHTML('<meta http-equiv="Content-Type" content="text/html; charset=utf-8">');
			$mpdf->WriteHTML($html);
			
			$filename = "sync".date("YmdHi");
			ob_clean();
			$path = $this->config->item('ums_uploads_dir');
			$file_path = $path.'sync_pdf/'.$filename.'.pdf';
			$mpdf->Output($file_path,'F');

			$this->load->model('ums/m_ums_sync');
			$this->m_ums_sync->sync_file_name = $filename;
			$this->m_ums_sync->sync_us_id = $session_us_id;
			$this->m_ums_sync->insert();
		}

		$data['status_response'] = $this->config->item('status_response_success');
		$data['returnUrl'] = base_url().'index.php/ums/User';

		$result = array('data' => $data);
		echo json_encode($result);
	}
}
?>
