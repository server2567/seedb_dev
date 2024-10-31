
<?php 
/*
* Queue_department
* Controller หลักของจัดการหมายเลขติดตามคิวของแผนก
* @input -
* $output -
* @author Dechathon Prajit
* @Create Date 19/07/2024
*/
if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once('QUE_Controller.php');

class Queue_department extends QUE_Controller {

    // Create __construct for load model use in this controller
    public function __construct() {
        parent::__construct();
		$this->load->model('que/M_que_base_department_queue');
        $this->load->model('hr/structure/M_hr_structure_detail');
        
        // check call function from WTS or QUE
        $this->session_ps_id = !empty($this->session->userdata('st_name_abbr_en')) && $this->session->userdata('st_name_abbr_en') == 'WTS' ? $this->session->userdata('us_ps_id') : null;
    }
    /*
	* index
	* index หลักของจัดการหมายเลขติดตามคิวของแผนก
	* @input -
	* $output -
	* @author Dechahon Prajit
	* @Create Date 19/07/2024
	*/
    function index(){
        
		$department = $this->M_que_base_department_queue->get_all_by_active()->result();
        foreach ($department as &$dep) {
            $dep->dpq_id = encrypt_id($dep->dpq_id);
        }
        $data['dep'] = $department;
		$data['session_mn_active_url'] = $this->uri->segment(1) . '/' . $this->uri->segment(2); // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');
		$this->output('que/queue/v_queue_department_show',$data);   
    }
    public function form_show($id=''){
        $id = decrypt_id($id);
        $data['dep_info']=$this->M_que_base_department_queue->get_department_join_hr()->result();
        if($id){
            $data['detail'] = $this->M_que_base_department_queue->get_department_queue_by_id($id)->row_array();
            $data['dep_info']=$this->M_que_base_department_queue->get_department_join_hr($data['detail']['dpq_stde_id'])->result();
            $data['detail']['dpq_id'] = encrypt_id($data['detail']['dpq_id']);
            
        } 

        $data['session_mn_active_url'] = $this->uri->segment(1) . '/' . $this->uri->segment(2); // set session_mn_active_url / breadcrumb
        $data['status_response'] = $this->config->item('status_response_show');
        $this->output('que/queue/v_queue_department_form',$data);
    }
    
    public function add($id='') {
        $dep_name_result = $this->M_hr_structure_detail->get_name_th_by_id($this->input->post('dep_id'))->result();
        $id = decrypt_id($id);
        
        if (!empty($dep_name_result)) {
            $dep_name = $dep_name_result[0]->stde_name_th;
        } else {
            $dep_name = null;
        }
        
        $keyword = $this->input->post('dep_keyword');
        $department = $this->input->post('dep_id');
        
        if ($this->M_que_base_department_queue->is_keyword_exists($keyword,$id)) {
            $response = array(
                'status' => 'error',
                'header' => 'ไม่สามารถเพิ่มข้อมูลได้',
                'body' => 'เนื่องจาก Keyword นี้กำลังถูกใช้งาน'
            );
        } else if ($this->M_que_base_department_queue->is_department_exists($department,$id)) {
            $response = array(
                'status' => 'error',
                'header' => 'ไม่สามารถเพิ่มข้อมูลได้',
                'body' => 'เนื่องจากแผนกนี้กำลังถูกใช้งาน'
            );
        } else {
            if ($id) {
                $this->M_que_base_department_queue->dpq_id = $id;
                $this->M_que_base_department_queue->dpq_name = $dep_name;
                $this->M_que_base_department_queue->dpq_stde_id = $this->input->post('dep_id');
                $this->M_que_base_department_queue->dpq_keyword = $this->input->post('dep_keyword');
                $this->M_que_base_department_queue->dpq_detail = $this->input->post('dep_desc');
                $this->M_que_base_department_queue->dpq_active = $this->input->post('dep_active') ? 1 : 0;
                $this->M_que_base_department_queue->dpq_update_date = date('Y-m-d H:i:s');
                $this->M_que_base_department_queue->dpq_update_user = $this->session->userdata('us_id');
                $this->M_que_base_department_queue->update();
            } else {
                $this->M_que_base_department_queue->dpq_name = $dep_name;
                $this->M_que_base_department_queue->dpq_stde_id = $this->input->post('dep_id');
                $this->M_que_base_department_queue->dpq_keyword = $this->input->post('dep_keyword');
                $this->M_que_base_department_queue->dpq_detail = $this->input->post('dep_desc');
                $this->M_que_base_department_queue->dpq_active = $this->input->post('dep_active') ? 1 : 0;
                $this->M_que_base_department_queue->dpq_create_user = $this->session->userdata('us_id');
                $this->M_que_base_department_queue->dpq_create_date = date('Y-m-d H:i:s');
                $this->M_que_base_department_queue->insert();
            }
    
            $response = array(
                'status' => 'success',
                'header' => 'ดำเนินการเสร็จสิ้น',
                'body' => 'บันทึกข้อมูลเสร็จสมบูรณ์',
                'returnUrl' => base_url() . 'index.php/que/Queue_department'
            );
        }
    
        echo json_encode($response);
    }
    public function delete($dpq_id){ //id ของหมายเลขติดตาม 
        
        $current = $this->M_que_base_department_queue->get_all_by_id($dpq_id)->row();


        if ($current->dpq_active == "0") { 
        $this->M_que_base_department_queue->dpq_id = $dpq_id; //หากสถานะเป็น 0
        $this->M_que_base_department_queue->dpq_active = '2'; //เปลี่ยนสถานะเป็น 2 : ลบ
        $this->M_que_base_department_queue->disabled();//ลบโดยเปลี่ยนสถานะเป็น 2
        $data['returnUrl'] = base_url().'index.php/que/Queue_department';
        $data['status_response'] = $this->config->item('status_response_success');
        $result = array('data' => $data);
        echo json_encode($result);
        } else {
            $data['returnUrl'] = base_url().'index.php/que/Queue_department';
        $data['status_response'] = $this->config->item('status_response_error');
        $result = array('data' => $data);
        echo json_encode($result);
        }
    }

}