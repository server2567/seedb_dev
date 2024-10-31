<?php

use Psr\Log\NullLogger;

 if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once('WTS_Controller.php');

class Base_sickness_path extends WTS_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('wts/m_wts_base_disease');
		$this->load->model('wts/m_wts_base_disease_time');
		$this->load->model('wts/m_wts_base_route_department');
		$this->load->model('wts/m_wts_base_route_time');
		$this->load->model('hr/structure/m_hr_structure_detail');
		$this->load->model('ums/m_ums_user');
	}

	function index(){
		$data['route'] = $this->m_wts_base_route_department->get_all()->result_array();

		$i = 0;
		foreach ($data['route'] as $row) {
			$data['time'] = $this->m_wts_base_route_time->get_all_route_time_list($row['rdp_id'])->result_array();
			$sum_time = 0;
			$j = 0;
			foreach ($data['time'] as $rt) {
				$sum_time += $rt['dst_minute']; // เวลาของแต่ละจุด
			}
			$data['route'][$i]['sum_time'] = $sum_time;
			$i++;
		}
		// pre($data['route']['']); die;		
		$data['stde'] = $this->m_wts_base_disease->get_all_stde_by_level()->result();
		$data['route_name'] = $this->m_wts_base_route_department->get_all_rdp_name()->result();

		$data['session_mn_active_url'] = $this->uri->segment(1) . '/' . $this->uri->segment(2); // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$this->output('wts/base/v_base_sickness_path',$data);
  	}
	
	  public function route_add($rdp_id=null) {
		$data['stde'] = $this->m_wts_base_disease->get_all_stde_by_level()->result();
		$data['ds_type'] = $this->m_wts_base_disease->get_all_disease_name_type()->result();

		$data['session_mn_active_url'] = $this->uri->segment(1) . '/' . $this->uri->segment(2); // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$this->output('wts/base/v_base_sickness_path_form.php',$data);
	}

	public function route_edit($rdp_id) {
		$data['route'] = $this->m_wts_base_route_department->get_route_dept_list($rdp_id)->result_array();
		// pre($data['route']); die;
		$data['stde'] = $this->m_wts_base_disease->get_all_stde_by_level()->result();
		$data['ds_type'] = $this->m_wts_base_disease->get_all_disease_name_type()->result();

		$data['session_mn_active_url'] = $this->uri->segment(1) . '/' . $this->uri->segment(2); // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$this->output('wts/base/v_base_sickness_path_form.php',$data);
	}

	public function route_time_edit($rdp_id) {
		$data['route'] = $this->m_wts_base_route_department->get_route_dept_list($rdp_id)->result_array();
		$data['route_time'] = $this->m_wts_base_route_time->get_all_route_time_list($rdp_id)->result_array();
		foreach($data['route_time'] as $key => $i) {
			if($data['route_time'][$key]['rt_rdp_id'] != $rdp_id) {
				$data['route_time'][$key]['rt_rdp_id'] = $rdp_id;
				$data['route_time'][$key]['rt_id'] = null;
			}
		}
		// pre($data['route_time']);
		// die;

		$data['select_dst'] = $this->m_wts_base_disease_time->get_all_dst_name_point()->result_array();

		//pre($data['select_dst']); die;
		$data['stde'] = $this->m_wts_base_disease->get_all_stde_by_level()->result();
		// $data['name_point'] = $this->m_wts_base_disease_time->get_all_dst_name_point_by_stde()->result();
		// $data['route_time'] = $this->m_wts_base_route_time->get_all_route_time_list_by_rdp_id($rdp_id)->result();
		$data['ds_type'] = $this->m_wts_base_disease->get_all_disease_name_type()->result();
		$data['rdp_id'] = $rdp_id;
		$data['session_mn_active_url'] = $this->uri->segment(1) . '/' . $this->uri->segment(2); // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');;
		$this->output('wts/base/v_base_sickness_path_manage.php',$data);
	}

	public function route_insert() {
		$route_form_data = $this->input->post();
		if($route_form_data['rdp_stde_id'] == NULL) {
			$data['status_response'] = $this->config->item('status_response_error');
		}else{
			$this->m_wts_base_route_department->rdp_stde_id = $route_form_data['rdp_stde_id'];
			$this->m_wts_base_route_department->rdp_name = $route_form_data['rdp_name'];
			$this->m_wts_base_route_department->rdp_ds_id = $route_form_data['rdp_ds_id'];
			$this->m_wts_base_route_department->rdp_active = !empty($route_form_data['rdp_active']) ? 1 : 0;
			$this->m_wts_base_route_department->rdp_create_user = 1;
			$this->m_wts_base_route_department->rdp_create_date = date('Y-m-d H:i:s');
			$this->m_wts_base_route_department->rdp_update_user = 1;
			$this->m_wts_base_route_department->rdp_update_date = date('Y-m-d H:i:s');

			$this->m_wts_base_route_department->insert();
			$data['returnUrl'] = base_url() . 'index.php/wts/Base_sickness_path';
        	$data['status_response'] = $this->config->item('status_response_success');

		}
        $result = array('data' => $data);
        echo json_encode($result);
	}

	public function route_update() {
		$route_form_data = $this->input->post();
		$this->m_wts_base_route_department->rdp_id = $route_form_data['rdp_id'];
		$this->m_wts_base_route_department->rdp_stde_id = $route_form_data['rdp_stde_id'];
		$this->m_wts_base_route_department->rdp_name = $route_form_data['rdp_name'];
		$this->m_wts_base_route_department->rdp_ds_id = $route_form_data['rdp_ds_id'];
		$this->m_wts_base_route_department->rdp_active = !empty($route_form_data['rdp_active']) ? 1 : 0;
		$this->m_wts_base_route_department->rdp_update_user = 1;
		$this->m_wts_base_route_department->rdp_update_date = date('Y-m-d H:i:s');

		$this->m_wts_base_route_department->update();

        $data['returnUrl'] = base_url() . 'index.php/wts/Base_sickness_path';
        $data['status_response'] = $this->config->item('status_response_success');
        $result = array('data' => $data);
        echo json_encode($result);
	}

	public function route_delete($rdp_id) {
		//// case success
		$this->m_wts_base_route_department->rdp_id = $rdp_id;
		$this->m_wts_base_route_department->rdp_active = 2;

		$this->m_wts_base_route_department->delete();
		$data['returnUrl'] = base_url().'index.php/wts/Base_sickness_path';
		$data['status_response'] = $this->config->item('status_response_success');
		$result = array('data' => $data);
		echo json_encode($result);

	}

	public function route_time_insert() {
        $route_time_form_data = json_decode(file_get_contents('php://input'), true);
            foreach ($route_time_form_data as $item) {
                $this->m_wts_base_route_time->rt_rdp_id = $item['rt_rdp_id']; // Assume rdp_id is available in the form data
                $this->m_wts_base_route_time->rt_seq = $item['rt_seq'];
                $this->m_wts_base_route_time->rt_dst_id = $item['dst_id'];
                $this->m_wts_base_route_time->insert();
            }

            $response = array(
                'status' => 'success',
                'header' => 'ดำเนินการเสร็จสิ้น',
                'body' => 'บันทึกข้อมูลเสร็จสมบูรณ์',
                'returnUrl' => base_url().'index.php/wts/Base_sickness_path',
            );
        

        echo json_encode($response);
    }

	public function route_time_update() {
		$route_time_form_data = json_decode(file_get_contents('php://input'), true);
			//pre($response); die;
		if (!empty($route_time_form_data)) {
			// $this->db->trans_start(); // Start transaction
	
			foreach ($route_time_form_data as $key => $item) {
				$seq = $key + 1; // Calculate sequence
				if (!empty($item['rt_id'])) {
					// Update existing record
					$this->m_wts_base_route_time->rt_id = $item['rt_id'];
					$this->m_wts_base_route_time->rt_seq = $seq;
					$this->m_wts_base_route_time->rt_dst_id = $item['dst_id'];
					$this->m_wts_base_route_time->update();
				} else {
					$this->m_wts_base_route_time->rt_id = NULL;
					$this->m_wts_base_route_time->rt_rdp_id = $item['rt_rdp_id']; // Assume rdp_id is available in the form data
					$this->m_wts_base_route_time->rt_seq = $seq;
					$this->m_wts_base_route_time->rt_dst_id = $item['dst_id'];
			// pre($route_time_form_data); die;
					$this->m_wts_base_route_time->insert();
				}
			}

			// if(empty($route_time_form_data)) {

			// }
	
			$response = array( 
				'status' => 'success',
				'header' => 'ดำเนินการเสร็จสิ้น',
				'body' => 'บันทึกข้อมูลเสร็จสมบูรณ์',
				'returnUrl' => base_url().'index.php/wts/Base_sickness_path',
	
			);
		} else {
			$response = array(
				'status' => 'error',
				'header' => 'เกิดข้อผิดพลาด',
				'body' => 'ไม่สามารถบันทึกข้อมูลได้',
			);
		}
		echo json_encode($response);
	}
			
	public function route_time_delete($rt_id) {
		//// case success
		$this->m_wts_base_route_time->rt_id = $rt_id;
		// $this->m_wts_base_route_time->rdp_active = 2;

		$this->m_wts_base_route_time->delete();

		// $data['returnUrl'] = base_url().'index.php/wts/Base_sickness_path';
		$data['status_response'] = $this->config->item('status_response_success');
		$result = array('data' => $data);
		echo json_encode($result);

	}
public function saveData($rt_dst_id) {
	$data = [
		'dst_id' => $rt_dst_id,
		'point_minute' => rand(1, 100), // Example: replace with actual logic
		'name_point' => 'Example Name' // Replace with actual logic to get the name
	];

	$this->wts->insert('route_time_table', $data);
	if ($this->wts->affected_rows() > 0) {
		$data['id'] = $this->wts->insert_id();
		return $data;
	} else {
		return false;
	}
}

public function Route_get_list() {
    $draw = intval($this->input->post('draw'));
    $start = $this->input->post('start');
    $length = $this->input->post('length');
    $order = $this->input->post('order');
    $order_dir = !empty($order) && isset($order[0]['dir']) ? $order[0]['dir'] : 'DESC';

    $search = $this->input->post('search')['value'] ?? NULL;

    $params = [
        'rdp_name' => $this->input->post('rdp_name'),
        'rdp_stde_id' => $this->input->post('rdp_stde_id'),
        'rdp_active' => $this->input->post('rdp_active'),
        'search' => $search
    ];
    
    $result = $this->m_wts_base_route_department->get_all_with_detail_server($start, $length, $order_dir, $params);

    $list = $result['query']->result_array();
    $total_records = $result['total_records'];

    foreach ($list as $row => $item) {
        $class = $item['rdp_active'] % 2 != 0 ? "text-success" : "text-danger";
        $item['rdp_active_text'] = $item['rdp_active'] % 2 != 0 ? "เปิดการใช้งาน" : "ปิดการใช้งาน";
        $item['stde_name'] = $item['stde_name'] != '' ? $item['stde_name'] : "ค่าเริ่มต้น";

        $sum_time = 0;
        $route_times = $this->m_wts_base_route_time->get_all_route_time_list($item['rdp_id'])->result_array();
        foreach ($route_times as $rt) {
            $sum_time += $rt['dst_minute']; // เวลาของแต่ละจุด
        }

		$data[] = [
			'rdp_id' => '<div class="text-center">' . ($start + $row + 1) . '</div>',
			'rdp_name' => '<div class="text-center">' . $item['rdp_name'] . '</div>',
			'stde_name' => '<div class="text-center">' . $item['stde_name'] . '</div>',
			'sum_time' => '<div class="text-center">' . $sum_time . '</div>', // sum_time
			'rdp_active' => '<div class="text-center"> <i class="bi-circle-fill ' . $class . '"></i> ' . $item['rdp_active_text'] . '</div>',
			'actions' => '<div class="text-center option">
							<button class="btn btn-warning" onclick="window.location.href=\'' . base_url() . 'index.php/wts/Base_sickness_path/route_edit/' . $item['rdp_id'] . '\'"><i class="bi-pencil-square"></i></button>
							<button class="btn btn-primary" title="จัดการจุดบริการ" onclick="window.location.href=\'' . base_url() . 'index.php/wts/Base_sickness_path/route_time_edit/' . $item['rdp_id'] . '\'"><i class="bi-card-list"></i></button>
							<button class="btn btn-danger swal-delete" data-url="' . base_url() . 'index.php/wts/Base_sickness_path/route_delete/' . $item['rdp_id'] . '"><i class="bi-trash"></i></button>
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