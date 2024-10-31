
<?php 
/*
* Tracking_department
* Controller หลักของจัดการหมายเลขนัดหมายของแผนก
* @input -
* $output -
* @author Dechathon Prajit
* @Create Date 17/05/2024
*/
if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once('QUE_Controller.php');

class Tracking_department extends QUE_Controller {

    // Create __construct for load model use in this controller
    public function __construct() {
        parent::__construct();
		$this->load->model('que/M_que_department');
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
	* @Create Date 17/05/2024
	*/
    function index(){
        if(!empty($this->session_ps_id))
		    $data['dep']= $this->M_que_department->get_all_by_active_and_person_sorted_name($this->session_ps_id)->result();
        else
		    $data['dep']= $this->M_que_department->get_all_by_active()->result();

		$data['session_mn_active_url'] = $this->uri->segment(1) . '/' . $this->uri->segment(2); // set session_mn_active_url / breadcrumb
		$data['status_response'] = $this->config->item('status_response_show');
		$this->output('que/tracking/v_tracking_department_show',$data);   
    }

    /*
	* add_form
	* สำหรับเปิดหน้าฟอร์มการเพิ่มข้อมูล 
	* @input -
	* $output -
	* @author Dechahon Prajit
	* @Create Date 17/05/2024
	*/
    public function add_form(){
        $data['dep_info']=$this->M_que_department->get_department_join_hr(null, $this->session_ps_id)->result();

        $data['session_mn_active_url'] = $this->uri->segment(1) . '/' . $this->uri->segment(2); // set session_mn_active_url / breadcrumb
        $data['status_response'] = $this->config->item('status_response_show');
        $this->output('que/tracking/v_tracking_department_add_form',$data);
    }

    /*
	* update_form
	* สำหรับเปิดหน้าฟอร์มการแก้ไขข้อมูล 
	* @input -
	* $output -
	* @author Dechahon Prajit
	* @Create Date 17/05/2024
	*/
    public function update_form($dpk_id){
        $data['dep_detail'] = $this->M_que_department->get_all_by_id($dpk_id)->row();
        if (!$data['dep_detail']) {
            // Handle the case where the department is not found
            show_404();
            return;
        }
        
        // get ddl
        $data['dep_info']=$this->M_que_department->get_department_join_hr($data['dep_detail']->dpk_stde_id, $this->session_ps_id)->result();

        $data['session_mn_active_url'] = $this->uri->segment(1) . '/' . $this->uri->segment(2); // set session_mn_active_url / breadcrumb
        $data['status_response'] = $this->config->item('status_response_show');
        $this->output('que/tracking/v_tracking_department_update_form',$data);
    }

    /*
	* add 
	* เพิ่มหมายเลขติดตามลงฐานข้อมูล
	* @input -
	* $output -
	* @author Dechahon Prajit
	* @Create Date 28/05/2024
	*/
    public function add(){

        $dep_name_result=$this->M_hr_structure_detail->get_name_th_by_id($this->input->post('dep_id'))->result();  //ค้นหาชื่อ keyword จาก input dep_id
        if (!empty($dep_name_result)) {
            // Extract the first object and get the stde_name_th property
            $dep_name = $dep_name_result[0]->stde_name_th;
        } else {
            // Handle the case where no result is found
            $dep_name = null; // or set a default value, or handle the error
        }
        $keyword = $this->input->post('dep_keyword');// keyword หมายเลขติดตามของแผนก
        $department = $this->input->post('dep_id');
        if ($this->M_que_department->is_keyword_exists($keyword)){ //หากหมายเลขติดตามที่รับมาจาก input ซ้ำกับใน database ให้้แจ้งเตือน Keyword นี้กำลังถูกใช้งาน 
            
            $response = array(
                'status' => 'error',
                'header' => 'ไม่สามารถเพิ่มข้อมูลได้',
                'body' => 'เนื่องจาก Keyword นี้กำลังถูกใช้งาน'
            );
            echo json_encode($response);
        } else if ($this->M_que_department->is_department_exists($department)){ //หากหมายเลขติดตามที่รับมาจาก input ซ้ำกับใน database ให้้แจ้งเตือน Keyword นี้กำลังถูกใช้งาน 
            
            $response = array(
                'status' => 'error',
                'header' => 'ไม่สามารถเพิ่มข้อมูลได้',
                'body' => 'เนื่องจากแผนกนี้กำลังถูกใช้งาน'
            );
            echo json_encode($response);
        } else 
        {
        $this->M_que_department->dpk_name = $dep_name;
        $this->M_que_department->dpk_stde_id = $this->input->post('dep_id'); //id ของแผนก
        $this->M_que_department->dpk_keyword = $this->input->post('dep_keyword');//keyword ของหมายเลขติดตามแผนก
        $this->M_que_department->dpk_detail = $this->input->post('dep_desc'); //รายละเอียดหมายเลขติดตาม
        $this->M_que_department->dpk_active = $this->input->post('dep_active') ? 1: 0; //สถานะการใช้งาน 1 : เปิด ,2 : ปิด 
        
        $this->M_que_department->dpk_create_user = $this->session->userdata('us_id'); //id ของผู้สร้างหมายเลข
        $this->M_que_department->dpk_create_date = date('Y-m-d H:i:s'); //วันที่ตอนสร้างหมายเลข
        $this->M_que_department->insert(); //insert to database 
        $response = array(
            'status' => 'success',
            'header' => 'ดำเนินการเสร็จสิ้น',
            'body' => 'บันทึกข้อมูลเสร็จสมบูรณ์',
            'returnUrl' => base_url().'index.php/que/Tracking_department',

        );
        echo json_encode($response);
        }
    }

    /*
	* update
	* อัพเดทหมายเลขติดตามของแผนก
	* @input  v_tracking_department_update_form 
	* $output -
	* @author Dechathon Prajit 
	* @Create Date 28/05/2024
	*/
    public function update(){
        $dpk_id = $this->input->post('dpk_id');
        $new_keyword = $this->input->post('dep_keyword'); //keyword from input 
        $current_dep = $this->M_que_department->get_all_by_id($dpk_id)->row();
        $current_keyword = $current_dep->dpk_keyword; //keyword in database same id 
        
        if ($current_keyword !== $new_keyword && $this->M_que_department->is_keyword_exists($new_keyword)){ //หาก keyword ซ้ำกับ keyword อื่นในฐานข้อมูล และ keyword ใหม่ไม่ตรงกับ keyword เดิม 
            
            $response = array(
                'status' => 'error',
                'header' => 'ไม่สามารถเพิ่มข้อมูลได้',
                'body' => 'เนื่องจาก Keyword นี้กำลังถูกใช้งาน'
            );
            echo json_encode($response);
        } else {
        $dep_name_result = $this->M_hr_structure_detail->get_name_th_by_id($this->input->post('dep_id'))->result(); //ชื่อแผนก
        $dep_name = !empty($dep_name_result) ? $dep_name_result[0]->stde_name_th : null;
        
        $this->M_que_department->dpk_name = $dep_name; //ชื่อแผนกใน model 
        $this->M_que_department->dpk_id = $this->input->post('dpk_id');// id หมายเลขติดตามแผนก
        $this->M_que_department->dpk_stde_id = $this->input->post('dep_id');// id แผนก
        $this->M_que_department->dpk_keyword = $this->input->post('dep_keyword');//keyword 
        $this->M_que_department->dpk_detail = $this->input->post('dep_desc'); // รายละเอียดหมายเลขติดตาม 
        $this->M_que_department->dpk_active = $this->input->post('dep_active') ? 1: 0; //สถานะการใช้งาน 1 : เปิด ,2 : ปิด 
        
        $this->M_que_department->dpk_update_user = $this->session->userdata('us_id');//id ของผู้อัพเดทหมายเลข
        $this->M_que_department->dpk_update_date = date('Y-m-d H:i:s');//วันที่อัพเดท
        $this->M_que_department->update(); // update ฐานข้อมูล
        $response = array(
            'status' => 'success',
            'header' => 'ดำเนินการเสร็จสิ้น',
            'body' => 'บันทึกข้อมูลเสร็จสมบูรณ์',
            'returnUrl' => base_url().'index.php/que/Tracking_department',

        );
        echo json_encode($response);
        }
    }

    /*
	* delete 
	* ลบหมายเลขติดตามของแผนก
	* @input  v_tracking_department_show
	* $output -
	* @author Dechathon Prajit 
	* @Create Date 30/05/2024
	*/
    public function delete($dpk_id){ //id ของหมายเลขติดตาม 
        
        $current = $this->M_que_department->get_all_by_id($dpk_id)->row();


        if ($current->dpk_active == "0") { $this->M_que_department->dpk_id = $dpk_id; //หากสถานะเป็น 0
        $this->M_que_department->dpk_active = '2'; //เปลี่ยนสถานะเป็น 2 : ลบ
        $this->M_que_department->disabled();//ลบโดยเปลี่ยนสถานะเป็น 2
        $data['returnUrl'] = base_url().'index.php/que/Tracking_department';
        $data['status_response'] = $this->config->item('status_response_success');
        $result = array('data' => $data);
        echo json_encode($result);
        } else {
            $data['returnUrl'] = base_url().'index.php/que/Tracking_department';
        $data['status_response'] = $this->config->item('status_response_error');
        $result = array('data' => $data);
        echo json_encode($result);
        }
    }
}