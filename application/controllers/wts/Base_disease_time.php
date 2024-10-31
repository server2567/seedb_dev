<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once('WTS_Controller.php');

class Base_disease_time extends WTS_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('wts/m_wts_base_disease');
		$this->load->model('wts/m_wts_base_disease_time');
		$this->load->model('hr/structure/m_hr_structure_detail');
		$this->load->model('ums/m_ums_user');
	}

	function index(){
		$data['disease_time'] = $this->m_wts_base_disease_time->get_all_disease_time()->result_array();
		$data['dst_name'] = $this->m_wts_base_disease_time->get_all_dst_name_point()->result_array();
		$data['stde'] = $this->m_wts_base_disease->get_all_stde_by_level()->result();
		$data['ds_type'] = $this->m_wts_base_disease->get_all_disease_name_type()->result();
		$data['session_mn_active_url'] = $this->uri->segment(1) . '/' . $this->uri->segment(2); // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
        $this->output('wts/base/v_base_disease_time',$data);
  	}
	
	  public function disease_time_add($dst_id=null) {
		$data['stde'] = $this->m_wts_base_disease->get_all_stde_by_level()->result();
		$data['ds_type'] = $this->m_wts_base_disease->get_all_disease_name_type()->result();
		$data['dst_treatment'] = $this->m_wts_base_disease_time->get_dst_patient_treatment_type()->result();
		$data['session_mn_active_url'] = $this->uri->segment(1) . '/' . $this->uri->segment(2); // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$this->output('wts/base/v_base_disease_time_form.php',$data);
	}
	  public function disease_time_edit($dst_id) {
		$data['stde'] = $this->m_wts_base_disease->get_all_stde_by_level()->result();
		$data['disease_time'] = $this->m_wts_base_disease_time->get_disease_time_list($dst_id)->result_array();
		$data['ds_type'] = $this->m_wts_base_disease->get_all_disease_name_type()->result();
		$data['dst_treatment'] = $this->m_wts_base_disease_time->get_dst_patient_treatment_type()->result();
		$data['session_mn_active_url'] = $this->uri->segment(1) . '/' . $this->uri->segment(2); // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$this->output('wts/base/v_base_disease_time_form.php',$data);
	}

	public function disease_time_insert() {
		$disease_time_form_data = $this->input->post();
		$this->m_wts_base_disease_time->dst_ds_id = $disease_time_form_data['dst_ds_id'];
		// $this->m_wts_base_disease_time->dst_patient_treatment_type = $disease_time_form_data['dst_patient_treatment_type'];
		$this->m_wts_base_disease_time->dst_name_point = $disease_time_form_data['dst_name_point'];
		$this->m_wts_base_disease_time->dst_name_point_en = $disease_time_form_data['dst_name_point_en'];
		$this->m_wts_base_disease_time->dst_minute = $disease_time_form_data['dst_minute'];
		$this->m_wts_base_disease_time->dst_active = !empty($disease_time_form_data['dst_active']) ? 1 : 0;
		$this->m_wts_base_disease_time->dst_create_user = 1;
		$this->m_wts_base_disease_time->dst_create_date = date('Y-m-d H:i:s');
		$this->m_wts_base_disease_time->dst_update_user = 1;
		$this->m_wts_base_disease_time->dst_update_date = date('Y-m-d H:i:s');
		
		$this->m_wts_base_disease_time->insert();

		// $response = array( 
		// 	'status' => 'success',
		// 	'header' => 'ดำเนินการเสร็จสิ้น',
		// 	'body' => 'บันทึกข้อมูลเสร็จสมบูรณ์',
		// 	'returnUrl' => base_url().'index.php/wts/Base_disease_time',

		// );
		// echo json_encode($response);

        $data['returnUrl'] = base_url() . 'index.php/wts/Base_disease_time';
        $data['status_response'] = $this->config->item('status_response_success');
        $result = array('data' => $data);
        echo json_encode($result);
	}

	public function disease_time_update() {
		$disease_time_form_data = $this->input->post();
		// $formData = $this->input->post() ;
		// $disease_form_data = $formData['formData'];
		$this->m_wts_base_disease_time->dst_id = $disease_time_form_data['dst_id'];
		$this->m_wts_base_disease_time->dst_ds_id = $disease_time_form_data['dst_ds_id'];
		// $this->m_wts_base_disease_time->dst_patient_treatment_type = $disease_time_form_data['dst_patient_treatment_type'];
		$this->m_wts_base_disease_time->dst_name_point = $disease_time_form_data['dst_name_point'];
		$this->m_wts_base_disease_time->dst_name_point_en = $disease_time_form_data['dst_name_point_en'];
		$this->m_wts_base_disease_time->dst_minute = $disease_time_form_data['dst_minute'];
		$this->m_wts_base_disease_time->dst_active = !empty($disease_time_form_data['dst_active']) ? 1 : 0;
		$this->m_wts_base_disease_time->dst_update_user = 1;
		$this->m_wts_base_disease_time->dst_update_date = date('Y-m-d H:i:s');

		$this->m_wts_base_disease_time->update();

		// $response = array( 
		// 	'status' => 'success',
		// 	'header' => 'ดำเนินการเสร็จสิ้น',
		// 	'body' => 'บันทึกข้อมูลเสร็จสมบูรณ์',
		// 	'returnUrl' => base_url().'index.php/wts/Base_disease_time',

		// );
		// echo json_encode($response);
		
        $data['returnUrl'] = base_url() . 'index.php/wts/Base_disease_time';
        $data['status_response'] = $this->config->item('status_response_success');
        $result = array('data' => $data);
        echo json_encode($result);
	}

	public function disease_time_show($dst_id) {
		$data['stde'] = $this->m_hr_structure_detail->get_all_by_level()->result();
		$data['disease_time'] = $this->m_wts_base_disease_time->get_disease_time_list($dst_id)->result_array();
		$data['ds_type'] = $this->m_wts_base_disease->get_all_disease_name_type()->result();


		$data['session_mn_active_url'] = $this->uri->segment(1) . '/' . $this->uri->segment(2); // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$this->output('wts/base/v_base_disease_time_info.php',$data);
	}
	public function disease_time_delete_data($dst_id) {
		//// case success
		$this->m_wts_base_disease_time->dst_id = $dst_id;
		$this->m_wts_base_disease_time->dst_active = 2;

		$this->m_wts_base_disease_time->delete();

		$data['returnUrl'] = base_url().'index.php/wts/Base_disease_time';
		$data['status_response'] = $this->config->item('status_response_success');
		$result = array('data' => $data);
		echo json_encode($result);

	}

	public function Disease_time_get_list() {
		$draw = intval($this->input->post('draw'));
		$start = $this->input->post('start');
		$length = $this->input->post('length');
		$order = $this->input->post('order');
		$order_dir = !empty($order) ? $order[1]['dir'] : 'DESC';
	
		$search = $this->input->post('search')['value'] ?? NULL;
	
		$params = [
			'dst_name_point' => $this->input->post('dst_name_point'),
			'ds_stde_id' => $this->input->post('ds_stde_id'),
			'ds_name_disease_type' => $this->input->post('ds_name_disease_type'),
			'search' => $search
		];
		
		$result = $this->m_wts_base_disease_time->get_all_with_detail_server($start, $length, $order_dir, $params);
		// pre($result);
		$list = $result['query']->result_array();
		// pre($list); die;
		$total_records = $result['total_records'];
	
		$data = [];
		foreach ($list as $row => $item) {
			if($item['dst_active'] % 2 != 0 ) {
				$class = "text-success";
			}else{
				$class = "text-danger";
			}
			if($item['dst_active'] % 2 != 0 ) {
				$item['dst_active_text'] = "เปิดการใช้งาน";
			}else{
				$item['dst_active_text'] = "ปิดการใช้งาน";
			}
			if($item['stde_name'] == NULL ) {
				$item['stde_name'] = "ค่าเริ่มต้น";
			}

			if($item['ds_type'] == NULL ) {
				$item['ds_type'] = "ค่าเริ่มต้น";
			}

			if($item['dst_minute'] == NULL ) {
				$item['dst_minute'] = '-';
			}

			if($item['user_name'] == NULL ) {
				$item['user_name'] = '-';
			}
	
			$data[] = [
				'dst_id' => '<div class="text-center">' . ($start + $row + 1) . '</div>',
				'stde_name' => '<div class="text-center">' . $item['stde_name'] . '</div>',
				'ds_type' => $item['ds_type'],
				'dst_name_point' => $item['dst_name_point'],
				'dst_minute' => '<div class="text-center">' . $item['dst_minute'] . '</div>',
				'dst_update_date' => '<div class="text-center">' . $item['dst_update_date'] . '</div>',
				'user_name' => '<div class="text-center">' . $item['user_name'] . '</div>',
				'dst_active' => '<div class="text-center"> <i class="bi-circle-fill ' . $class . '"></i> ' . $item['dst_active_text'] . '</div>',
				'actions' => '<div class="text-center option">
					<button class="btn btn-info" title="ดูรายละเอียด" onclick="window.location.href=\'' . base_url() . 'index.php/wts/Base_disease_time/disease_time_show/' . $item['dst_id'] . '\'"><i class="bi-search"></i></button>
					<button class="btn btn-warning" onclick="window.location.href=\'' . base_url() . 'index.php/wts/Base_disease_time/disease_time_edit/' . $item['dst_id'] . '\'"><i class="bi-pencil-square"></i></button>
					<button class="btn btn-danger swal-delete" data-url="' . base_url() . 'index.php/wts/Base_disease_time/disease_time_delete_data/' . $item['dst_id'] . '"><i class="bi-trash"></i></button>
				</div>'
			];
					}
	
		$response = [
			'draw' => $draw,
			'recordsTotal' => $total_records,
			'recordsFiltered' => $total_records,
			'data' => $data
		];
	
		echo json_encode($response);
	}		

}
?>