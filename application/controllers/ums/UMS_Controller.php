<?php
/*	UMS Version 1.71 Update 12/03/2557
	change how to select data user
	Copyright (C) 2013 by UMS Team ,Software Engineering of Burapha University.
	This program is free software;you can redistribute it and/or modify it under the terms of the GNU General Public License version 2
	as published by the Free Software Foundation*/
//include("eperson/getIcon.php");
class UMS_Controller extends CI_Controller{	
	
	public $mn_active_url; // for set active menu at sidebar and breadcrumb

	public function __construct()
	{ 
		parent::__construct();
		$this->load->helper('encryption_helper');
		$this->load->model('ums/m_ums_user');
		$this->load->model('ums/m_ums_menu');
		$this->load->model('ums/m_ums_system');

		$this->load->model('ums/m_ums_logs');
		
		// $this->load->model('ums/m_umshowprofile','');//echo "adsadasdasd";die;
		
		// $this->load->model('ums/m_umpermission','');
		// $this->load->model('ums/m_umgpermission','');
		// $this->load->model('ums/m_ummenu','');
		// $this->load->model('ums/m_umuser','');
		// $this->load->model('ums/m_umgroup','');
		// $this->load->model('ums/m_umhistory','');
		// $this->load->model('ums/m_umlog','');
		// $this->load->model('ums/m_umtemplate','');
		// $this->load->model("ums/m_umicon");
		
		// $this->load->model("ums/m_umnotification"); //for notification
		
		// // $this->load->model($this->config->item("hr_dir")."/M_hr_person_detail",'m_persont');
		
		// force_ssl();
		// if(!$this->session->userdata('Language')){
		// 	$this->session->set_userdata('Language',"TH");
		// }
	
	}

	public function index()
	{
		$data['status_response'] = $this->config->item('status_response_show');
		
		$menus_sidebar = $this->session->userdata('menus_sidebar');
		
		// encrypt id
		$names = ['mn_id']; // object name need to encrypt 
		$menus_sidebar = isset($menus_sidebar) ? encrypt_arr_obj_id($menus_sidebar, $names) : array();
		$data['session_menus_sidebar'] = $menus_sidebar;

		$this->output('ums/v_ums_home_show',$data);
	}
	
	/*	header()=> This Function is show the header of the website and user informations
	[[Be Careful]] ,If you want to override.
		The UMS Team have working with config the header by don't coding and Easy to Use.
		it's coming soon in next version....*/
	// function header()
	// {	
	// 	// if($this->config->item('notification_on')=="on"){
	// 	// 	$data['news_notification'] = $this->m_umnotification->get_news();				//for notification
	// 	// 	$data['notification'] = $this->m_umnotification->get_all()->result_array();		//for notification
	// 	// }

	// 	// if($this->session->userdata('StID') == null){
	// 	// 	$this->m_umtemplate->StID = 0;
	// 	// }else{
	// 	// 	$this->m_umtemplate->StID = $this->session->userdata('StID');
	// 	// }
		
	// 	// //echo $this->m_umtemplate->StID;
	// 	// $data['tem'] = $this->m_umtemplate->get_by_key_sys()->row_array();
	// 	// //var_dump($data['tem']);
	// 	// if($data['tem']==null){
	// 	// 	// var_dump($this->session->userdata('StID'));
	// 	// 	//$this->m_umtemplate->StID = $this->session->userdata('StID');
	// 	// 	$this->m_umtemplate->StID = $this->m_umtemplate->StID;
			
	// 	// 	$this->m_umtemplate->add_default();
	// 	// 	$data['tem'] = $this->m_umtemplate->get_by_key_sys()->row_array();
	// 	// }
	// 	// $icon['temp'] = $this->m_umtemplate->get_icon()->result_array();
	// 	// foreach($icon['temp'] as $temp){
	// 	// 	$iconname = $temp['HeadIcon'];
	// 	// }
	// 	// $this->m_umicon->IcName = $iconname;
	// 	// $data['Icon'] = $this->m_umicon->get_by_name()->row_array();
	// 	// // $this->load->view('template/header',$data);
	// 	// if(in_array($this->session->userdata('StID'),$this->config->item('ums_system_template_new'))){
	// 	// 	$this->load->view('template/material/header',$data);
	// 	// }else{
	// 	// 	if(in_array($this->session->userdata('StID'),$this->config->item('ums_system_fix'))){
	// 	// 		$this->load->view('template/header_new',$data);
	// 	// 	}else{
	// 	// 		$this->load->view('template/header',$data);
	// 	// 	}
	// 	// }

	// 	$this->load->view('template/header');
	// 	// $this->load->view('template/header',$data);
	// }
	function header()
	{
		// if($this->config->item('notification_on')=="on"){
		// 	$data['news_notification'] = $this->m_umnotification->get_news();				//for notification
		// 	$data['notification'] = $this->m_umnotification->get_all()->result_array();		//for notification
		// }

		// if($this->session->userdata('StID') == null){
		// 	$this->m_umtemplate->StID = 0;
		// }else{
		// 	$this->m_umtemplate->StID = $this->session->userdata('StID');
		// }
		
		// //echo $this->m_umtemplate->StID;
		// $data['tem'] = $this->m_umtemplate->get_by_key_sys()->row_array();
		// //var_dump($data['tem']);
		// if($data['tem']==null){
		// 	// var_dump($this->session->userdata('StID'));
		// 	//$this->m_umtemplate->StID = $this->session->userdata('StID');
		// 	$this->m_umtemplate->StID = $this->m_umtemplate->StID;
			
		// 	$this->m_umtemplate->add_default();
		// 	$data['tem'] = $this->m_umtemplate->get_by_key_sys()->row_array();
		// }
		// $icon['temp'] = $this->m_umtemplate->get_icon()->result_array();
		// foreach($icon['temp'] as $temp){
		// 	$iconname = $temp['HeadIcon'];
		// }
		// $this->m_umicon->IcName = $iconname;
		// $data['Icon'] = $this->m_umicon->get_by_name()->row_array();
		// // $this->load->view('template/header',$data);
		// if(in_array($this->session->userdata('StID'),$this->config->item('ums_system_template_new'))){
		// 	$this->load->view('template/material/header',$data);
		// }else{
		// 	if(in_array($this->session->userdata('StID'),$this->config->item('ums_system_fix'))){
		// 		$this->load->view('template/header_new',$data);
		// 	}else{
		// 		$this->load->view('template/header',$data);
		// 	}
		// }
    	$this->load->model('ums/m_ums_system');
		$is_have_menus_sidebar = $this->session->userdata('is_have_menus_sidebar');
		$data['session_is_have_menus_sidebar'] = isset($is_have_menus_sidebar) ? $is_have_menus_sidebar: true;

		$data['ps_id'] = $this->session->userdata('us_ps_id');
		$data['profile_person'] = !empty($data['ps_id']) ? $this->get_profile_person($data['ps_id']) : null;
		// pre($this->session->all_userdata());

		$data['systems'] = $this->m_ums_system->get_by_id($this->session->userdata('st_id'))->result_array();

		// 20240916 Areerat - add get ums_user_config for check [WTS] notification_department
		$this->load->model('ums/m_ums_user_config');
		$this->m_ums_user_config->usc_ps_id = $this->session->userdata('us_ps_id');
		$data['user_config'] = $this->m_ums_user_config->get_by_ps_id()->row();
    
		// $data['session_is_have_menus_sidebar'] = false;
		$this->load->view('template/header', $data);
	}

  function get_profile_person($ps_id){
		$this->load->model($this->config->item('hr_dir').'M_hr_person');
		$this->load->model($this->config->item('hr_dir').'M_hr_person_detail');
		$this->load->model($this->config->item('hr_dir').'M_hr_person_position');
		$this->load->model($this->config->item('hr_dir').'M_hr_person_education');
		$this->load->model($this->config->item('hr_dir').'M_hr_person_license');
		$this->load->model($this->config->item('hr_dir').'M_hr_person_work_history');
		$this->load->model($this->config->item('hr_dir').'M_hr_person_expert');
		$this->load->model($this->config->item('hr_dir').'M_hr_person_reward');

		$this->M_hr_person->ps_id = $ps_id;
		$this->M_hr_person_detail->psd_ps_id = $ps_id;
		$this->M_hr_person_position->pos_ps_id = $ps_id;
		$this->M_hr_person_education->edu_ps_id = $ps_id;
		$this->M_hr_person_license->licn_ps_id = $ps_id;
		$this->M_hr_person_work_history->wohr_ps_id = $ps_id;
		$this->M_hr_person_expert->expt_ps_id = $ps_id;
		$this->M_hr_person_reward->rewd_ps_id = $ps_id;

		// person detail
		$data['person_detail'] = $this->M_hr_person->get_personal_dashboard_profile_detail_data_by_id()->row();

		// person position by department
		$data['person_department_topic'] = $this->M_hr_person->get_person_ums_department_by_ps_id()->result();
		$position_department_array = array();
		foreach($data['person_department_topic'] as $row){
			$array_tmp = $this->M_hr_person->get_person_position_by_ums_department_detail($ps_id, $row->dp_id)->row();
			array_push($position_department_array, $array_tmp);
		}
		$data['person_department_detail'] = $position_department_array;

		// person education
		$data['person_education_list'] = $this->M_hr_person_education->get_all_person_education_data($ps_id)->result();
		foreach($data['person_education_list'] as $key=>$row){
			$row->edu_id = encrypt_id($row->edu_id);
			$row->edu_start_date = ($row->edu_start_date == "0000-00-00" ? ($row->edu_start_year) : abbreDate2($row->edu_start_date));
			$row->edu_end_date = ($row->edu_end_date == "0000-00-00" ? ($row->edu_end_year) : abbreDate2($row->edu_end_date));
		}

		// person license
		$data['person_license_list'] = $this->M_hr_person_license->get_all_person_license_data($ps_id)->result();
		foreach($data['person_license_list'] as $key=>$row){
			$row->licn_id = encrypt_id($row->licn_id);
			$row->licn_start_date = abbreDate2($row->licn_start_date);
			$row->licn_end_date = ($row->licn_end_date == "9999-12-31" ? "ตลอดชีพ" : abbreDate2($row->licn_end_date));
		}

		// person work history
		$data['person_work_history_list'] = $this->M_hr_person_work_history->get_all_person_work_history_data($ps_id)->result();
		foreach($data['person_work_history_list'] as $key=>$row){
			$row->wohr_id = encrypt_id($row->wohr_id);
			$row->wohr_start_date = abbreDate2($row->wohr_start_date);
			$row->wohr_end_date = ($row->wohr_end_date == "9999-12-31" ? "ปัจจุบัน" : abbreDate2($row->wohr_end_date));
		}

		// person expert
		$data['person_expert_list'] = $this->M_hr_person_expert->get_all_person_expert_data($ps_id)->result();
		foreach($data['person_expert_list'] as $key=>$row){
			$row->expt_id = encrypt_id($row->expt_id);
		}

		// person reward
		$data['person_reward_list'] = $this->M_hr_person_reward->get_all_person_reward_data($ps_id)->result();
		$data['person_reward_list'] = $this->M_hr_person_reward->get_year_reward($ps_id)->result();

		
		foreach($data['person_reward_list'] as $key=>$row){
			$row->rewd_id = encrypt_id($row->rewd_id);
			$row->reward_detail = $this->M_hr_person_reward->get_reward_by_year($ps_id, $row->rewd_year);
			$row->rewd_year = ($row->rewd_year != 0 ? $row->rewd_year : "ไม่ระบุ");
			if($row->reward_detail->num_rows() > 0){
				foreach($row->reward_detail->result() as $rewd){
					$rewd->rewd_date = ($rewd->rewd_date == "0000-00-00" ? date('d/m/Y', strtotime($rewd->rewd_end_date . ' +543 years')) : date('d/m/Y', strtotime($rewd->rewd_date . ' +543 years')));
				}
			}
			$row->reward_detail = $row->reward_detail->result();
		}
	
		return $data;
	}

  function header_frontend(){
		$is_have_menus_sidebar = $this->session->userdata('is_have_menus_sidebar');
		$data['session_is_have_menus_sidebar'] = isset($is_have_menus_sidebar) ? $is_have_menus_sidebar: true;
    $this->load->view('template/header_frontend', $data);
  }

  function header_frontend_clinic()
	{
		$is_have_menus_sidebar = $this->session->userdata('is_have_menus_sidebar');
		$data['session_is_have_menus_sidebar'] = isset($is_have_menus_sidebar) ? $is_have_menus_sidebar : true;
		$this->load->view('template/header_frontend_clinic', $data);
	}

  function header_frontend_staff()
  {
	  $is_have_menus_sidebar = $this->session->userdata('is_have_menus_sidebar');
	  $data['session_is_have_menus_sidebar'] = isset($is_have_menus_sidebar) ? $is_have_menus_sidebar : true;
	  $this->load->view('template/header_frontend_staff', $data);
  }
	function javascript($data)
	{
		// if(in_array($this->session->userdata('StID'),$this->config->item('ums_system_template_new'))){
		// 	$this->load->view('template/material/scripts');
		// }else{
		// 	if(in_array($this->session->userdata('StID'),$this->config->item('ums_system_fix'))){
		// 		$this->load->view('template/javascript_new');
		// 	}else{
		// 		$this->load->view('template/javascript');
		// 	}
		// }
		$this->load->view('template/javascript', $data);
	}
	/* 	topbar() => This Function is show Search box and path of website 
		If your system can go to main path by Hyperlink set data Here!! */
	function topbar()
	{	
		// if($this->session->userdata('GpID')&& $this->session->userdata('StID'))
		// {
		// 	$GpID=$this->session->userdata('GpID');
		// 	$StID=$this->session->userdata('StID');
		// 	$UsID=$this->session->userdata('UsID');
		// 	$data['mainmenu'] = $this->m_ummenu->get_menu_lv($StID,$GpID,$UsID,0)->result_array();
		// 	$data['submenu'] = $this->m_ummenu->get_menu_lv($StID,$GpID,$UsID,1)->result_array();
		// 	if($this->session->userdata('MnID'))
		// 	{
		// 		$data['sidebarpath'] = $this->m_ummenu->get_sidebar_path($this->session->userdata('MnID'));	
		// 	}
		// 	$this->load->view('template/topbar',$data);
		// }
		// else
		// {
		// 	$this->load->view('template/topbar');
		// }
		$this->load->view('template/topbar');
	}

	/*
	* topbar_frontend
	* for load topbar frontend
	* @input 
		is_public: boolean check public page, dont show any user(patient ot staff)
	* $output detail of topbar frontend.
	* @author ???
	* @Create Date ???
	* @Update Date 04/09/2024 Areerat Pongurai - add parameter is_public for check dont user data if have login.
	*/
  	function topbar_frontend($is_public = false)
	{	
		if($is_public) {
			$data['session_view'] = 'frontend';
		} else {
			$this->load->model('ums/M_ums_patient');
			if($this->session->userdata('pt_id') || ($this->session->userdata('pt_id') == '' && $this->input->post('pt_id') == '')){
			  $data['user'] = $this->M_ums_patient->check_pt_id($this->session->userdata('pt_id'))->row();
			  $data['session_view'] = 'frontend';
			} else {
			  $data['user'] = $this->M_ums_patient->check_pt_id($this->input->post('pt_id'))->row();
			  $data['session_view'] = 'backend';
			}
		}

		$this->load->view('template/topbar_frontend',$data);
	}

	/*	sidebar() => This Function is show Menu of This workgroup can use in this system
	[[Be Careful]] ,If you want to override
		The UMS Team working with config the icon of all menu 
		it's coming soon in next version....
		*** this version didn't check personnal permission*/
	function sidebar()
	{
		$menus_sidebar = $this->session->userdata('menus_sidebar');
		$data['session_menus_sidebar'] = isset($menus_sidebar) ? $menus_sidebar : array();

		$this->load->view('template/sidebar_menu', $data);
	}
	function set_menu_sidebar()
	{
		// get menus_sidebar
		$st_id = $this->session->userdata('st_id');
		$us_id = $this->session->userdata('us_id');
		$menus_sidebar = $this->m_ums_menu->get_menus_sidebar($st_id, $us_id)->result_array();
		
		// Step 1: Map mn_id to its encrypted value
		$menu_id_map = [];
		foreach ($menus_sidebar as $index => $menu) {
			$menu_id_temp = $menu['mn_id'];
			$menu_id_encrypt = encrypt_id($menu_id_temp);
			$menus_sidebar[$index]['mn_id'] = $menu_id_encrypt;
			$menu_id_map[$menu_id_temp] = $menu_id_encrypt;
		}

		// Step 2: Update mn_parent_mn_id using the mapping from Step 1
		foreach ($menus_sidebar as $index => $menu) {
			if (isset($menu_id_map[$menu['mn_parent_mn_id']])) {
				$menus_sidebar[$index]['mn_parent_mn_id'] = $menu_id_map[$menu['mn_parent_mn_id']];
			}
		}

		$this->session->set_userdata('menus_sidebar',$menus_sidebar);
	}

	// checkUser() => This Function is check session of This user login or not? return true and false
	function checkUser()
	{
		if($this->session->userdata('us_id'))
			return true;
		else
			return false;
	}

	function nosidebar(){
		$this->load->view('template/nosidebar');
	}
	
	// footer() => This Function is show normal footer 
	function footer()
	{
		// // $this->load->view('template/footer');
		// if(in_array($this->session->userdata('StID'),$this->config->item('ums_system_template_new'))){
		// 	$this->load->view('template/material/footer');
		// }else{
		// 	$this->load->view('template/footer');
		// }
		$this->load->view('template/footer');
	}

  function footer_frontend()
	{
		// // $this->load->view('template/footer');
		// if(in_array($this->session->userdata('StID'),$this->config->item('ums_system_template_new'))){
		// 	$this->load->view('template/material/footer');
		// }else{
		// 	$this->load->view('template/footer');
		// }
		$this->load->view('template/footer_frontend');
	}
	
	/*
	* main
	* load begin main content and breadcrumb.
	* @input $data: item want to show in content area.
	* $output detail of main content and breadcrumb.
	* @author Areerat Pongurai
	* @Create Date 16/05/2024
	*/
	function main($data=null){
		// set home url of system for breadcrumb
		$session_st_home_url = $this->session->userdata('st_home_url');
		$data['session_st_home_url'] = isset($session_st_home_url) ? $session_st_home_url : array();

		// set name abbr enlish of home url system for breadcrumb
		$session_st_name_abbr_en = $this->session->userdata('st_name_abbr_en');
		$data['session_st_name_abbr_en'] = isset($session_st_name_abbr_en) ? $session_st_name_abbr_en : array();
		
		// set menus active for breadcrumb
		$data['session_menus_active'] = $this->set_menus_active($data);

		$this->load->view('template/main', $data);
	}
	
	/*
	* set_menus_active
	* set for show menu active at sidebar and path on breadcrumb.
	* @input 
		$data['session_mn_active_id']: mn_id = menu id that active
		$data['session_mn_active_url']: mn_url = menu url that active
	* $output path menus active.
	* @author Areerat Pongurai
	* @Create Date 03/07/2024
	*/
	function set_menus_active($data) {
		// set menus active for breadcrumb
		$session_menus_active = array();
		if(isset($data['session_mn_active_id'])) // for sub menu send mn_id
			$session_menus_active = $this->m_ums_menu->get_menus_path($data['session_mn_active_id'])->result_array();
		else if(isset($data['session_mn_active_url']) && $this->session->userdata('st_id') <> null)
			$session_menus_active = $this->m_ums_menu->get_menus_path_by_url($data['session_mn_active_url'], $this->session->userdata('st_id'))->result_array();
      // pre($session_menus_active); die;
		// encrypt id
		$names = ['mn_id', 'mn_parent_mn_id']; // object name need to encrypt 
		$session_menus_active = encrypt_arr_obj_id($session_menus_active, $names);
		return isset($session_menus_active) ? $session_menus_active : array();
	}

	/*
	* output
	* load and show result of screen.
	* @input $body: content area want to show , $data: item want to show in content area.
	* $output detail of screen.
	* @author Areerat Pongurai
	* @Create Date 16/05/2024
	*/
	function output($body='',$data='')
	{
		// $this->setCRUD($this->session->userdata('MnID'));
		if($this->checkUser()) {
			// // (ยังไม่ได้เทส) check $data['session_mn_active_url'] is a member of system id that login 
			// if(isset($data) && isset($data['session_mn_active_url']))
			// check_url_menu($data['session_mn_active_url'])

			$this->header();
			$this->sidebar();
			// $this->topbar();
			$this->main($data);
			$this->load->view($body,$data);
			$this->footer();
			$this->javascript(isset($data['Menus']) ? $data['Menus'] : array());
		}
		else {
			redirect('gear','refresh');
		}
	}

	/*
	* check_url_menu
	* Verify permissions to access this URL's menu.
	* @input $data['session_mn_active_url']
	* $output boolean => true: can access, false: can't access
	* @author Areerat Pongurai
	* @Create Date 05/06/2024
	*/
	function check_url_menu($url) {
		/*
			Condition check
			1. เข้าระบบ A แต่ระบุ url เมนูของระบบ B => เปลี่ยน sidebar จากระบบ A เป็น ระบบ B
				1.1 จำเป็นต้องเปลี่ยน $this->session->userdata('st_id') = $url.st_id
			2. เมื่อระบุ url เมนูที่ user ไม่มีสิทธิ์เข้าถึง => ต้องแสดงหน้าจอ ไม่มีสิทธิ์
		*/

		$st_id = $this->session->userdata('st_id');
		if (!empty($st_id) && !empty($url)) {
			$this->load->model('ums/m_ums_menu');
			$this->m_ums_menu->mn_st_id = $st_id;
			$this->m_ums_menu->mn_st_url = $url;

			// case 1
			$result = $this->m_ums_menu->get_menus_by_sys_and_url()->result_array();
			if (!$result) {
				$result = $this->m_ums_menu->get_menus_by_url()->result_array();
				if ($result) {
					$st_id = $result[0]['mn_st_id'];
					$this->session->unset_userdata('st_id');
					$this->session->set_userdata('st_id',(int)$st_id);
					$this->set_menu_sidebar();

					$menus_sidebar = $this->session->userdata('menus_sidebar');
					if (!isset($menus_sidebar) || empty($menus_sidebar)) {
						return false;
					}
				} else 
					return false;
			}
		}
		return true;
	}

	/*
	* insert_log_menu
	* insert ums_user_logs_menu 
	* @input 
		mn_id (menu_id): เมนูที่กดคลิกเข้ามา
		session: ข้อมูล session
	* $output -
	* @author Areerat Pongurai
	* @Create Date 18/06/2024
	*/
	function insert_log_menu($mn_id=null) {
		$us_id = $this->session->userdata('us_id');
		$st_id = $this->session->userdata('st_id');
		$url = null;
		if (!empty($us_id) && !empty($st_id)) {
			$ml_changed = "";

			if (!empty($mn_id)) { // get manu data by id
				$mn_id = decrypt_id($mn_id);
				
				$this->load->model('ums/m_ums_menu');
				$this->m_ums_menu->mn_id = $mn_id;
				$result = $this->m_ums_menu->get_by_key()->row_array();
				if ($result) {
					$menu = $result;
					$mn_id = $menu['mn_id'];
					$ml_changed = "เข้าใช้งานเมนู " . $menu['mn_name_th'];
					$url = $menu['mn_url'];
				}
			} else { // get system data
				$this->load->model('ums/m_ums_system');
				$this->m_ums_system->st_id = $st_id;
				$result = $this->m_ums_system->get_by_key()->row_array();
				if ($result) {
					$ml_changed = "เข้าใช้งานระบบ " . $result['st_name_abbr_en'];
				}
			}
			
			// insert
			$this->load->model('ums/m_ums_user_logs_menu');
			$this->m_ums_user_logs_menu->ml_us_id = $us_id;
			$this->m_ums_user_logs_menu->ml_st_id = $st_id;
			$this->m_ums_user_logs_menu->ml_mn_id = $mn_id;
			$this->m_ums_user_logs_menu->ml_changed = $ml_changed;
			$this->m_ums_user_logs_menu->ml_ip = $_SERVER['REMOTE_ADDR'];
			$this->m_ums_user_logs_menu->ml_agent = detect_device_type();
			$this->m_ums_user_logs_menu->insert();

			// if trigger click menu then redirect by path menu
			if(!empty($url))
				redirect($url,'refresh');
		}
		return true;
	}

	//  fuction use for HR and REG 
	//  for system that have many Menu
	function outputnew($body='',$data='')
	{
		$this->setCRUD($this->session->userdata('MnID'));
		if($this->checkUser())
		{
			$this->header();
			$this->javascript();
			// $this->topbarnew();
			// $this->nosidebar();
			$this->topbar();
			$this->load->view($body,$data);
			$this->footer();
		}
		else
		{
			$this->load->view('Gear/extras-login');
		}
	}

	/*
	* output_frontend_public
	* Screen for public frontend no user login
	* @input -
	* $output system list
	* @author Areerat Pongurai
	* @Create Date 16/05/2024
	*/
	function output_frontend_public($body = '', $data = '')
	{
		$this->header_frontend();
		$this->javascript(isset($data['Menus']) ? $data['Menus'] : array());
		$this->topbar_frontend(true);
		$this->load->view($body, $data);
		$this->footer_frontend();
	}
  
  function output_frontend_clinic_public($body = '', $data = '')
	{
		$this->header_frontend_clinic();
		$this->javascript(isset($data['Menus']) ? $data['Menus'] : array());
		$this->topbar_frontend(true);
		$this->load->view($body, $data);
		$this->footer_frontend();
	}

	function output_frontend($body = '', $data = '')
	{
		$this->header_frontend();
		$this->javascript(isset($data['Menus']) ? $data['Menus'] : array());
		$this->topbar_frontend();
		$this->load->view($body, $data);
		$this->footer_frontend();
	}
	function output_frontend_staff($body = '', $data = '')
	{
		$this->header_frontend_staff();
		$this->javascript(isset($data['Menus']) ? $data['Menus'] : array());
		$this->topbar_frontend();
		$this->load->view($body, $data);
		$this->footer_frontend();
	}
	function output_staff($body = '', $data = '')
	{
		$this->header_frontend_staff();
		$this->javascript(isset($data['Menus']) ? $data['Menus'] : array());
		$this->topbar_frontend();
		$this->load->view($body, $data);
	}
	/* setCRUD(MenuID) => This function
		set Permission of Menu is using by User
		C => Can Create
		R => Can Read
		U => Can Update
		D => Can Delete
		credit : Wittawas Puntumchinda*/
	function setCRUD($mnid)
	{	// for set Permission in the menu
		$X = 1;
        $C = 1;
        $R = 1;
        $U = 1;
        $D = 1;
		//check on Person's Permission
        $person = $this->m_umpermission->SearchByKey($mnid); 
		// if query found may be in 5 permission have empty slot
        if ($person){
            $X = $person['pmX'];
            $C = $person['pmC'];
            $R = $person['pmR'];
            $U = $person['pmU'];
            $D = $person['pmD'];
        } else {// check on WorkGroup's Permission
            $Group = $this->m_umgpermission->SearchByKey($mnid); 
			// if query found may be in 5 permission have empty slot
            if ($Group){
                $X = $Group['gpX'];
                $C = $Group['gpC'];
                $R = $Group['gpR'];
                $U = $Group['gpU'];
                $D = $Group['gpD'];
            }
        }
		//set data session to use menu 
        $data = array(	'X' => $X, 
                    'C' => $C,
                    'R' => $R,
                    'U' => $U,
                    'D' => $D);
        $this->session->set_userdata($data);
		// this session didn't destory 
		// UpGrade in next Version
        return 0;
	}
	/*	setMenu(MenuID) => This function is setting session of menu is using by user now!*/
	public function setMenu($mnid)
	{
		$log_mn_id=$mnid;
		$log_us_id=$this->session->userdata('UsID');

    	$data = array(
        	'uml_mn_id'=>$log_mn_id,
        	'uml_us_id'=>$log_us_id
    	);
    	$this->db->insert('umlogmenu',$data);
    	
		$this->session->unset_userdata('MnID');
		$this->session->unset_userdata('MnNameT');
		$this->session->unset_userdata('MnNameE');
		$this->session->unset_userdata('MnLevel');
		$this->session->unset_userdata('MnURL');
		$this->session->set_userdata('MnID',$mnid);
		$menu = $this->m_ummenu->get_menu_url($this->session->userdata('MnID'));
		$this->session->set_userdata('MnNameT',$menu['MnNameT']);
		$this->session->set_userdata('MnNameE',$menu['MnNameE']);
		$this->session->set_userdata('MnLevel',$menu['MnLevel']);
		$this->session->set_userdata('MnURL',$menu['MnURL']);
		if(($menu['MnURL'] == "" || $menu['MnURL'] == "#" || $menu['MnURL'] == "-" || $menu['MnURL'] == "UMS_Controller/submenu/" || $menu['MnURL'] == "UMS_Controller/submenu")){
			redirect( base_url()."index.php/UMS_Controller/submenu/".$mnid,'refresh');
		}
		else
		{
			redirect(base_url()."index.php/".$menu['MnURL'],'refresh');
		}
	}
	function fancy()
	{	
		if(in_array($this->session->userdata('StID'),$this->config->item('ums_system_template_new'))){
			$this->load->view('template/material/fancy');
		}else{
			if(in_array($this->session->userdata('StID'),$this->config->item('ums_system_fix'))){
				$this->load->view('template/fancy_new');
			}else{
				$this->load->view('template/fancy');
			}
			// $this->load->view('template/fancy');
		}
		// $this->load->view('template/fancy');
	}
	function output_fancy($body='',$data='')
	{
		$this->setCRUD($this->session->set_userdata('MnID'));
		if($this->checkUser())
		{
			$this->fancy();
			$this->javascript();
			
			$this->load->view($body,$data);
			
		
		}
		else
		{
			$this->load->view('Gear/extras-login');
		}
	} 
	public function popup($view,$data)
	{
		$this->load->view('template/popup',$data);
	}
	
	/*
	* submenu
	* get sub menus of parent manu id
	* @input mn_id(parent manu id)
	* $output screen of sub menus of parent manu id
	* @author Areerat Pongurai
	* @Create Date 03/07/2024
	*/
	public function submenu($mn_id) 
	{
		$mn_id = decrypt_id($mn_id);

		$this->load->model('ums/m_ums_menu');
		$this->m_ums_menu->mn_id = $mn_id;
		$result = $this->m_ums_menu->get_submenu()->result_array();
		if($result) {
			$parent_menu = [];
			$sub_menus = [];

			foreach($result as $item) {
				if($item['mn_id'] == $mn_id && is_null($item['mn_parent_mn_id']))
					$parent_menu[] = $item;
				if($item['mn_parent_mn_id'] == $mn_id && !is_null($item['mn_parent_mn_id']))
					$sub_menus[] = $item;
			}
			
			// encrypt id
			$names = ['mn_id', 'mn_parent_mn_id']; // object name need to encrypt 
			$data['parent_menu'] = encrypt_arr_obj_id($parent_menu, $names);
			$data['sub_menus'] = encrypt_arr_obj_id($sub_menus, $names);
		}
		
		$data['session_mn_active_id'] = $mn_id; // set session_mn_active_id / breadcrumb
		$this->output('template/submenu', $data);
	}
	
	/*
	* check_que_appointment_doctor_wts
	* alert doctor that que will be time over and update status
	* @input -
	* $output alert on screen
	* @author Areerat Pongurai
	* @Create Date 17/07/2024
	* @Update Date 28/08/2024 Areerat Pongurai - ไม่ใช้ ntdp_date_finish และ ntdp_time_finish แล้ว
	*/
	public function check_que_appointment_doctor_wts() {
		// 1 get wts_noti_dept that status = 1 and have end date/time and today
		// 2 check wts_noti_dept end date/time with wts_notifications_status time config (check till minute)
		// 2.1 if end date/time = (wts_notifications_status = 2 แจ้งเตือนแล้ว) -- get que_appointment data for alert and update wts_noti_dept.ntdp_sta_id = 2
		// 2.2 if end date/time = (wts_notifications_status = 3 ใกล้หมดเวลา) -- get que_appointment data for alert and update wts_noti_dept.ntdp_sta_id = 3
		// 2.3 if end date/time = (wts_notifications_status = 4 เลยระยะเวลา) -- dont alert but update wts_noti_dept.ntdp_sta_id = 4
		// 3 call this function in view template

		$this->load->model('ums/m_ums_user_config');
		$this->m_ums_user_config->usc_ps_id = $this->session->userdata('us_ps_id');
		$user_config = $this->m_ums_user_config->get_by_ps_id()->row();

		$almost_minute_check = $this->config->item('wts_time_almost_min_alert'); // เอาไว้สำหรับเช็คใกล้หมดเวลา (wts_notifications_status = 3 ใกล้หมดเวลา)

		$us_ps_id = $this->session->userdata('us_ps_id');
        $this->load->model('wts/m_wts_notifications_department');
		$noti_depts = $this->m_wts_notifications_department->get_all_for_alert_by_ps_id($us_ps_id)->result_array();

		// die(pre($noti_depts));
		$curr_date = new DateTime();
        $curr_date_formatted = $curr_date->format('Y-m-d H:i');

		$result = [];
		foreach ($noti_depts as $noti_dept) {
			// $is_not_finish for check to update status, dont alert
			// $is_not_finish = !empty($noti_dept['ntdp_date_finish']) || !empty($noti_dept['ntdp_time_finish']) ? false : true;

			// $is_finish for check ถ้าหมอยังตรวจผู้ป่วยไม่เสร็จ ให้แจ้งเตือนใกล้หมดเวลา
            $this->m_wts_notifications_department->ntdp_apm_id = $noti_dept['ntdp_apm_id'];
            $last_noti_dept = $this->m_wts_notifications_department->get_last_data_by_ntdp_apm_id()->row();
			$is_finish = false;
			if(!empty($last_noti_dept)) {
				if($last_noti_dept->ntdp_loc_Id == 8 && empty($noti_dept['ntdp_date_end']) && empty($noti_dept['ntdp_time_end'])) // last row คือพบแพทย์เสร็จแล้ว
					$is_finish = true;
			}

			$end_date_string = $noti_dept['ntdp_date_end'] . ' ' . $noti_dept['ntdp_time_end'];
			$end_date = new DateTime($end_date_string);
			
			$end_date_check = clone $end_date;
			$end_date_check->modify("-$almost_minute_check minutes"); // for wts_notifications_status = 3 ใกล้หมดเวลา

			$end_date_formatted = $end_date->format('Y-m-d H:i');
			$end_date_check_formatted = $end_date_check->format('Y-m-d H:i');

			$new_ntdp_sta_id = null;

			// user_config->usc_wts_is_noti  =  แพทย์ต้องการให้แจ้งเตือนหรือไม่
			if ($curr_date_formatted >= $end_date_check_formatted && $noti_dept['ntdp_sta_id'] == 1) {
				$new_ntdp_sta_id = 3; // ใกล้หมดเวลา
				if (!$is_finish && (!empty($user_config) && $user_config->usc_wts_is_noti)) 
					$result[] = $this->alert_que_appointment_doctor_wts($noti_dept['ntdp_apm_id'], $new_ntdp_sta_id);
			} else if($curr_date_formatted == $end_date_formatted && in_array($noti_dept['ntdp_sta_id'], [1, 3])) {
				$new_ntdp_sta_id = 2; // แจ้งเตือนแล้ว
				if (!$is_finish && (!empty($user_config) && $user_config->usc_wts_is_noti)) 
					$result[] = $this->alert_que_appointment_doctor_wts($noti_dept['ntdp_apm_id'], $new_ntdp_sta_id);
			} else if($curr_date_formatted > $end_date_formatted && in_array($noti_dept['ntdp_sta_id'], [1, 2, 3])) {
				if (!$is_finish)
					$new_ntdp_sta_id = 4; // เลยระยะเวลา
			}

			// update wts_noti_dept.ntdp_sta_id
			if(!empty($new_ntdp_sta_id)) {
				$this->m_wts_notifications_department->ntdp_id = $noti_dept['ntdp_id'];
				$this->m_wts_notifications_department->ntdp_sta_id = $new_ntdp_sta_id;
				$this->m_wts_notifications_department->update_status();
			}
		}
		
        // Prepare the response
        $response = array(
            'result' => $result,
        );
		
        echo json_encode($response);
	}

	/*
	* alert_que_appointment_doctor_wts
	* get object detail for alert 
	* @input 
			apm_id (que_appointment id): apm_id for get que_appointment data
			ntdp_sta_id (wts_notifications_status id): status for check object detail
	* $output object detail for alert 
	* @author Areerat Pongurai
	* @Create Date 17/07/2024
	*/
	private function alert_que_appointment_doctor_wts($apm_id, $ntdp_sta_id) {
        $this->load->model('que/m_que_appointment');
		$result = $this->m_que_appointment->get_appointment_by_id($apm_id)->row();
		$almost_minute_check = $this->config->item('wts_time_almost_min_alert');
		if(!empty($result)) {
			switch ($ntdp_sta_id) {
				case 2 :
					$subject = "แจ้งเตือนสิ้นสุดเวลา";
					$pt_full_name = $result->pt_prefix . " " . $result->pt_fname . " " . $result->pt_lname;
					$detail = "หมดเวลาการรักษาที่กำหนดไว้ <br>ผู้ป่วย: ".$pt_full_name;
					return ['subject' => $subject, 'detail' => $detail];
					break;
				case 3 :
					$subject = "แจ้งเตือนใกล้สิ้นสุดเวลา";
					$pt_full_name = $result->pt_prefix . " " . $result->pt_fname . " " . $result->pt_lname;
					$detail = "อีก $almost_minute_check นาทีจะหมดเวลาการรักษาที่กำหนดไว้ <br>ผู้ป่วย: ".$pt_full_name;
					return ['subject' => $subject, 'detail' => $detail];
					break;
			}
		}
	}
	
	/*
	* error
	* for show error screen
	* @input -
	* $output error screen
	* @author Areerat Pongurai
	* @Create Date 02/09/2024
	*/
	function error()
	{
		// ไม่ใช้ function output เพราะต้องการให้แสดงหน้าจอ error เลย ไม่ให้ redirect ไป gear/login		
		$this->header();
		$this->sidebar();
		// $this->topbar();
		$this->main();
		$this->load->view('error');
		$this->footer();
		$this->javascript(array());
	}

	public function his_database()
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
			// เขียน Query เพื่อดึงข้อมูลจาก tbluserid
			// $sql = "SELECT * FROM tbluserid";
			// $stmt = $pdo->prepare($sql);
			// $stmt->execute();

			// // ดึงผลลัพธ์ทั้งหมด
			// $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

			// // แสดงผลลัพธ์
			// foreach ($users as $user) {
			//     echo "UserID: " . $user['User_ID'] . " - Name: " . $user['Username'] . "<br>";
			// }

			echo "เชื่อมต่อฐานข้อมูลสำเร็จ!";
		} catch (PDOException $e) {
			// กรณีเกิดข้อผิดพลาดในการเชื่อมต่อ
			echo "เกิดข้อผิดพลาด: " . $e->getMessage();
		}
	}
}
