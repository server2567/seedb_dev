<?php 
/*
* User
* Main controller of Dashboard_group
* @input -
* $output -
* @author Areerat Pongurai
* @Create Date 20/06/2024
*/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once('UMS_Controller.php');

// use PhpOffice\PhpSpreadsheet\Spreadsheet;
// use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Dashboard_group extends UMS_Controller{

	// Create __construct for load model use in this controller
	public function __construct() {
		parent::__construct();
	}

	/*
	* index
	* Index controller of Dashboard_group
	* @input -
	* $output usergroup_history list
	* @author Areerat Pongurai
	* @Create Date 20/06/2024
	*/
	public function index() {
		// 1. get_each_user
		// - get user active = 1
		// - get groups detail with system from usergroup by user => $users[$i]['groups']
		$this->load->model('ums/m_ums_user');
		$order = array('us_name'=>'ASC');
		$users = $this->m_ums_user->get_all($order, 1)->result_array();
		if(!empty($users)) {
			$this->load->model('ums/m_ums_usergroup');
			foreach ($users as $key => $user) {
				$this->m_ums_usergroup->ug_us_id = $user['us_id'];
				$order = array('st.st_name_th'=>'ASC');
				$groups = $this->m_ums_usergroup->get_groups_by_user_id($order)->result_array();
				$users[$key]['groups'] = $groups;
			}
		}

		// 2. get_each_system
		// - get system active = 1
		// - get groups detail from group by system => system[$i]['groups']
		// - get user detail from usergroup by group => system[$i]['groups'][&j]['users']
		$this->load->model('ums/m_ums_system');
		$order = array('st_name_th'=>'ASC');
		$systems = $this->m_ums_system->get_all($order, 1)->result_array();
		if(!empty($systems)) {
			$this->load->model('ums/m_ums_group');
			foreach ($systems as $key => $system) {
				$this->m_ums_group->gp_st_id = $system['st_id'];
				$order = array('gp_name_th'=>'ASC');
				$groups = $this->m_ums_group->get_by_system_id($order)->result_array();
				$systems[$key]['groups'] = $groups;

				$this->load->model('ums/m_ums_usergroup');
				foreach ($systems[$key]['groups'] as $key2 => $gp) {
					$this->m_ums_usergroup->ug_gp_id = $gp['gp_id'];
					$order = array('us.us_name'=>'ASC');
					$group_users = $this->m_ums_usergroup->get_users_by_group_id()->result_array();
					$systems[$key]['groups'][$key2]['users'] = $group_users;
				}
			}
		}
		
		// // encrypt id
		$names = ['us_id']; // object name need to encrypt 
		$data['users'] = encrypt_arr_obj_id($users, $names);
		$names = ['st_id']; // object name need to encrypt 
		$data['systems'] = encrypt_arr_obj_id($systems, $names);

		$data['session_mn_active_url'] = $this->uri->segment(1) . '/' . $this->uri->segment(2); // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');
		$this->output('ums/dashboard/v_dashboard_group_dashboard',$data);
	}

	/*
	* Dashboard_group_export_users
	* export permission detail each user to pdf
	* @input 
		type: pdf, excel
		us_id(user_id) : if null then get all users, else get by us_id
	* $output preview permission detail each user to pdf
	* @author Areerat Pongurai
	* @Create Date 20/06/2024
	*/
	public function Dashboard_group_export_users($type, $us_id=null) {
		$this->load->model('ums/m_ums_user');
		$users = [];
		if(!empty($us_id)) {
			// get 1 row
			$this->m_ums_user->us_id = decrypt_id($us_id);
			$users = $this->m_ums_user->get_by_key()->result_array();
		} else {
			// get all row
			$order = array('us_name'=>'ASC');
			$users = $this->m_ums_user->get_all($order, 1)->result_array();
		}

		// - get groups detail with system from usergroup by user => $users[$i]['groups']
		if(!empty($users)) {
			$this->load->model('ums/m_ums_usergroup');
			foreach ($users as $key => $user) {
				$this->m_ums_usergroup->ug_us_id = $user['us_id'];
				$order = array('st.st_name_th'=>'ASC');
				$groups = $this->m_ums_usergroup->get_groups_by_user_id($order)->result_array();
				$users[$key]['groups'] = $groups;
			}
			
			if ($type == 'pdf') {
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
				
				$data['users'] = $users;
				$data['header'] = "รายงานสิทธิ์การใช้งาน (รายบุคคล) ณ วันที่ " . date('d-m-Y เวลา H:i น.');
				$html = $this->load->view('ums/dashboard/v_dashboard_group_users_pdf', $data, true);

				$mpdf->WriteHTML('<meta http-equiv="Content-Type" content="text/html; charset=utf-8">');
				$mpdf->WriteHTML($html);
				
				$filename = "รายงานสิทธิ์การใช้งาน_รายบุคคล_".date("YmdHi");

				// Clean the output buffer
				ob_clean();

				// Stream the PDF to the browser for preview
				$mpdf->Output($filename . '.pdf', 'I');
			}
			else if ($type == 'excel') {
				// // Create a new Spreadsheet object
				// $spreadsheet = new Spreadsheet();
				// $sheet = $spreadsheet->getActiveSheet();
				
				// // Set some data in the spreadsheet
				// $sheet->setCellValue('A1', 'Hello');
				// $sheet->setCellValue('B1', 'World!');

				// // Create a writer
				// $writer = new Xlsx($spreadsheet);

				// // Set headers for download
				// header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
				// header('Content-Disposition: attachment; filename="hello_world.xlsx"');
				// header('Cache-Control: max-age=0');

				// // Write the spreadsheet to a file and output to the browser
				// $writer->save('php://output');
				
				// exit;

				// $this->load->library('excel');
			}
		}
	}

	/*
	* Dashboard_group_export_systems
	* export permission detail each system to pdf
	* @input 
		type: pdf, excel
		st_id(system_id) : if null then get all systems, else get by st_id
	* $output preview permission detail each system to pdf
	* @author Areerat Pongurai
	* @Create Date 20/06/2024
	*/
	public function Dashboard_group_export_systems($type, $st_id=null) {
		$this->load->model('ums/m_ums_system');
		$systems = [];
		if(!empty($st_id)) {
			// get 1 row
			$this->m_ums_system->st_id = decrypt_id($st_id);
			$systems = $this->m_ums_system->get_by_key()->result_array();
		} else {
			// get all row
			$order = array('st_name_th'=>'ASC');
			$systems = $this->m_ums_system->get_all($order, 1)->result_array();
		}

		// - get groups detail with system from usergroup by user => $users[$i]['groups']
		if(!empty($systems)) {
			$this->load->model('ums/m_ums_group');
			foreach ($systems as $key => $system) {
				$this->m_ums_group->gp_st_id = $system['st_id'];
				$order = array('gp_name_th'=>'ASC');
				$groups = $this->m_ums_group->get_by_system_id($order)->result_array();
				$systems[$key]['groups'] = $groups;

				$this->load->model('ums/m_ums_usergroup');
				foreach ($systems[$key]['groups'] as $key2 => $gp) {
					$this->m_ums_usergroup->ug_gp_id = $gp['gp_id'];
					$order = array('us.us_name'=>'ASC');
					$group_users = $this->m_ums_usergroup->get_users_by_group_id()->result_array();
					$systems[$key]['groups'][$key2]['users'] = $group_users;
				}
			}
			
			if ($type == 'pdf') {
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
				
				$data['systems'] = $systems;
				$data['header'] = "รายงานสิทธิ์การใช้งาน (รายระบบ) ณ วันที่ " . date('d-m-Y เวลา H:i น.');
				$html = $this->load->view('ums/dashboard/v_dashboard_group_systems_pdf', $data, true);

				$mpdf->WriteHTML('<meta http-equiv="Content-Type" content="text/html; charset=utf-8">');
				$mpdf->WriteHTML($html);
				
				$filename = "รายงานสิทธิ์การใช้งาน_รายระบบ_".date("YmdHi");

				// Clean the output buffer
				ob_clean();

				// Stream the PDF to the browser for preview
				$mpdf->Output($filename . '.pdf', 'I');
			}
			else if ($type == 'excel') {
			}
		}
	}
}
?>
