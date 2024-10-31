<?php 
/*
* Base_disease
* Controller หลักของจัดการประเภทโรค
* @input -
* $output -
* @author Supawee Sangrapee
* @Create Date 21/05/2024
*/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once('WTS_Controller.php');

class Base_disease extends WTS_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('wts/m_wts_base_disease');
		$this->load->model('hr/structure/m_hr_structure_detail');
		$this->load->model('ums/m_ums_user');

	}

	public function index(){
		$data['disease'] = $this->m_wts_base_disease->get_all()->result_array();
		$data['ds_type'] = $this->m_wts_base_disease->get_all_disease_name_type()->result_array();
		// $names = ['ds_id'];
		// $data['disease'] = encrypt_arr_obj_id($disease, $names);
		$data['stde'] = $this->m_wts_base_disease->get_all_stde_by_level()->result();
		// $data['stde'] = $this->m_hr_structure_detail->get_all_by_level()->result();
		// $data['stde_name'] = $this->m_wts_base_disease->get_stde()->result();
		// $ds_update_user = $this->input->get('ds_update_user');

		// $data['user'] = $this->m_wts_base_disease->get_user_name()->result();
		$data['session_mn_active_url'] = $this->uri->segment(1) . '/' . $this->uri->segment(2); // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');
		$this->output('wts/base/v_base_disease',$data);
  	}

	public function disease_add($ds_id=null) {
		$data['stde'] = $this->m_wts_base_disease->get_all_stde_by_level()->result();
		$data['session_mn_active_url'] = $this->uri->segment(1) . '/' . $this->uri->segment(2); // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$this->output('wts/base/v_base_disease_from.php',$data);
	}

	public function disease_edit($ds_id) {
		$data['stde'] = $this->m_wts_base_disease->get_all_stde_by_level()->result();
		$data['disease'] = $this->m_wts_base_disease->get_disease_list($ds_id)->result_array();
		$data['session_mn_active_url'] = $this->uri->segment(1) . '/' . $this->uri->segment(2); // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$this->output('wts/base/v_base_disease_from.php',$data);
	}
	
	public function disease_insert() {
		$disease_form_data = $this->input->post();
		$this->m_wts_base_disease->ds_name_disease_type = $disease_form_data['ds_name_disease_type'];
		$this->m_wts_base_disease->ds_name_disease_type_en = $disease_form_data['ds_name_disease_type_en'];
		$this->m_wts_base_disease->ds_name_disease = $disease_form_data['ds_name_disease'];
		$this->m_wts_base_disease->ds_name_disease_en = $disease_form_data['ds_name_disease_en'];
		$this->m_wts_base_disease->ds_detail = $disease_form_data['ds_detail'];
		$this->m_wts_base_disease->ds_detail_en = $disease_form_data['ds_detail_en'];
		$this->m_wts_base_disease->ds_active = !empty($disease_form_data['ds_active']) ?  1 : 0;
		$this->m_wts_base_disease->ds_stde_id = $disease_form_data['ds_stde_id'];
		$this->m_wts_base_disease->ds_create_user = 1;
		$this->m_wts_base_disease->ds_create_date = date('Y-m-d H:i:s');
		$this->m_wts_base_disease->ds_update_user = 1;
		$this->m_wts_base_disease->ds_update_date = date('Y-m-d H:i:s');
		
		$this->m_wts_base_disease->insert();

        $data['returnUrl'] = base_url() . 'index.php/wts/Base_disease';
        $data['status_response'] = $this->config->item('status_response_success');
        $result = array('data' => $data);
        echo json_encode($result);
	}

	public function disease_update() {
		$disease_form_data = $this->input->post();
		// $formData = $this->input->post() ;
		// $disease_form_data = $formData['formData'];
		$this->m_wts_base_disease->ds_id = $disease_form_data['ds_id'];
		$this->m_wts_base_disease->ds_name_disease_type = $disease_form_data['ds_name_disease_type'];
		$this->m_wts_base_disease->ds_name_disease_type_en = $disease_form_data['ds_name_disease_type_en'];
		$this->m_wts_base_disease->ds_name_disease = $disease_form_data['ds_name_disease'];
		$this->m_wts_base_disease->ds_name_disease_en = $disease_form_data['ds_name_disease_en'];
		$this->m_wts_base_disease->ds_detail = $disease_form_data['ds_detail'];
		$this->m_wts_base_disease->ds_detail_en = $disease_form_data['ds_detail_en'];
		$this->m_wts_base_disease->ds_active = !empty($disease_form_data['ds_active']) ?  1 : 0;
		$this->m_wts_base_disease->ds_stde_id = $disease_form_data['ds_stde_id'];
		$this->m_wts_base_disease->ds_update_user = 1;
		$this->m_wts_base_disease->ds_update_date = date('Y-m-d H:i:s');
		
		$this->m_wts_base_disease->update();

		// $response = array( 
		// 	'status' => 'success',
		// 	'header' => 'ดำเนินการเสร็จสิ้น',
		// 	'body' => 'บันทึกข้อมูลเสร็จสมบูรณ์',
		// 	'returnUrl' => base_url().'index.php/wts/Base_disease',
		// );
		// echo json_encode($response);

        $data['returnUrl'] = base_url() . 'index.php/wts/Base_disease';
        $data['status_response'] = $this->config->item('status_response_success');
        $result = array('data' => $data);
        echo json_encode($result);
	}
	public function disease_delete_data($ds_id) {
		//// case success
		$this->m_wts_base_disease->ds_id = $ds_id;
		$this->m_wts_base_disease->ds_active = 2;
		$this->m_wts_base_disease->delete();

		$data['returnUrl'] = base_url().'index.php/wts/Base_disease';
		$data['status_response'] = $this->config->item('status_response_success');
		$result = array('data' => $data);
		echo json_encode($result);
	}

	public function disease_show($ds_id) {
		$data['stde'] = $this->m_wts_base_disease->get_all_stde_by_level()->result();
		$data['disease'] = $this->m_wts_base_disease->get_disease_list($ds_id)->result_array();

		$data['session_mn_active_url'] = $this->uri->segment(1) . '/' . $this->uri->segment(2); // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$this->output('wts/base/v_base_disease_info.php',$data);
	}

	public function get_disease_list()
	{
		$data['session_mn_active_url'] = $this->uri->segment(1) . '/' . $this->uri->segment(2); // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;

		$dn_id = $this->input->get('dn_id');
		$dnt_id = $this->input->get('dnt_id');
        $stde_id = $this->input->get('stde_id');
		
		$result = $this->m_wts_base_disease->get_all_disease_search($dn_id, $dnt_id, $stde_id)->result();

		foreach($result as $key=>$row){
			$row->ds_id = encrypt_id($row->ds_id);
		}

		echo json_encode($result);
		
	}

	public function Disease_get_list() {
		$draw = intval($this->input->post('draw'));
		$start = $this->input->post('start');
		$length = $this->input->post('length');
		$order = $this->input->post('order');
		$order_dir = !empty($order) ? $order[1]['dir'] : 'DESC';
	
		$search = $this->input->post('search')['value'] ?? NULL;
	
		$params = [
			'ds_name_disease' => $this->input->post('ds_name_disease'),
			'ds_name_disease_type' => $this->input->post('ds_name_disease_type'),
			'ds_stde_id' => $this->input->post('ds_stde_id'),
			'search' => $search
		];
		
		$result = $this->m_wts_base_disease->get_all_with_detail_server($start, $length, $order_dir, $params);
		// pre($result);
		$list = $result['query']->result_array();
		// pre($list); die;
		$total_records = $result['total_records'];
	
		$data = [];
		foreach ($list as $row => $item) {
			if($item['ds_active'] % 2 != 0 ) {
				$class = "text-success";
			}else{
				$class = "text-danger";
			}
			if($item['ds_active'] % 2 != 0 ) {
				$item['ds_active_text'] = "เปิดการใช้งาน";
			}else{
				$item['ds_active_text'] = "ปิดการใช้งาน";
			}
	
			$data[] = [
				'ds_id' => '<div class="text-center">' . ($start + $row + 1) . '</div>',
				'stde_name' => '<div class="text-center">' . $item['stde_name'] . '</div>',
				'ds_name_disease_type' => '<div class="text-center">' . $item['ds_name_disease_type'] . '</div>',
				'ds_name_disease' => $item['ds_name_disease'],
				'ds_update_date' => '<div class="text-center">' . $item['ds_update_date'] . '</div>',
				'user_name' => '<div class="text-center">' . $item['user_name'] . '</div>',
				'ds_active' => '<div class="text-center"> <i class="bi-circle-fill ' . $class . '"></i> ' . $item['ds_active_text'] . '</div>',
				'actions' => '<div class="text-center option">
					<button class="btn btn-info" title="ดูรายละเอียด" onclick="window.location.href=\'' . base_url() . 'index.php/wts/Base_disease/disease_show/' . $item['ds_id'] . '\'"><i class="bi-search"></i></button>
					<button class="btn btn-warning" onclick="window.location.href=\'' . base_url() . 'index.php/wts/Base_disease/disease_edit/' . $item['ds_id'] . '\'"><i class="bi-pencil-square"></i></button>
					<button class="btn btn-danger swal-delete" data-url="' . base_url() . 'index.php/wts/Base_disease/disease_delete_data/' . $item['ds_id'] . '"><i class="bi-trash"></i></button>
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