<?php

use PhpOffice\PhpWord\Shared\Validate;

 if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once('QUE_Controller.php');

class Tracking extends QUE_Controller {
    public function __construct()
    {
        parent::__construct();
		$this->load->model('que/M_que_base_type');
		$this->load->library('session');
	}


    function index(){
        
		$data['session_mn_active_url'] = $this->uri->segment(1) . '/' . $this->uri->segment(2);
		$data['status_response'] = $this->config->item('status_response_show');;
        $data['Track'] = $this->M_que_base_type->get_all_active()->result();
        
		$this->output('que/tracking/v_tracking_show',$data);   
  }
  public function add_form(){
    
	$data['session_mn_active_url'] = $this->uri->segment(1) . '/' . $this->uri->segment(2); // set session_mn_active_url / breadcrumb
	$data['status_response'] = $this->config->item('status_response_show');;
	$this->output('que/tracking/v_tracking_add_form',$data);

  }

  public function update_form($type_id){
    $data['type_info']=$this->M_que_base_type->get_by_id($type_id)->row();
    if(!$data['type_info']){
        show_404();
        return;
    }
	$data['session_mn_active_url'] = $this->uri->segment(1) . '/' . $this->uri->segment(2); // set session_mn_active_url / breadcrumb
	$data['status_response'] = $this->config->item('status_response_show');;
	$this->output('que/tracking/v_tracking_update_form',$data);

  }

  public function validate_format($input) {
    // Pattern to match the required format
    $pattern = "/^
        ([0-9]-[0-9])|             # Matches 0-9
        ([a-z]-[a-z])|             # Matches a-z
        ([A-Z]-[A-Z])|             # Matches A-Z   
    $/x";
    return preg_match($pattern, $input);
}
    public function validate_thai_format($input){
        return preg_match("/[ก-ฮ]-[ก-ฮ]/",$input);
    }
    public function validate_uppercase_format($input){
        return preg_match("/[A-Z]-[A-Z]/",$input);
    }
    public function validate_lowercase_format($input){
        return preg_match("/[a-z]-[a-z]/",$input);
    }
    public function validate_number_format($input){
        return preg_match("/[0-9]-[0-9]/",$input);
    }
    public function test_validate_format(){
        $input = $this->input->post();
        echo $input['running_format'];
        if(  $this->validate_thai_format($input['running_format']) ){
            echo "test_true";
        } else {echo "test_false";} 
    }
  public function add(){
    $input = $this->input->post();
    $result = array('data' => array());
    if ($input['type_code']== 'fx'){
        $this->M_que_base_type->type_name = $input['type_name'];
        $this->M_que_base_type->type_code = $input['type_code'];
    } else if ($input['type_code'] == 'rd') {
        $type_value = json_encode(array(
            array("value" => "is_use_number", "name" => "สุ่มตัวเลข"),
            array("value" => "is_use_lowercase", "name" => "ตัวอักษร a b c ..."),
            array("value" => "is_use_uppercase", "name" => "ตัวอักษร A B C ..."),
            array("value" => "is_use_thai_str", "name" => "ตัวอักษร ก ข ค ...")
        ));
            $type_func = <<<EOD
            \$get_value = function (\$length = 64, \$is_use_number = true, \$is_use_lowercase = true, \$is_use_uppercase = true, \$is_use_thai_str = false)
            {
            if (\$length < 1) {
            return "";
            }
            \$number = "0123456789";
            \$lowercase = "abcdefghijklmnopqrstuvwxyz";
            \$uppercase = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
            
            \$characters = '';
            if (\$is_use_number) {
            \$characters .= \$number;
            }
            if (\$is_use_lowercase) {
            \$characters .= \$lowercase;
            }
            if (\$is_use_uppercase) {
            \$characters .= \$uppercase;
            }

            \$charactersLength = mb_strlen(\$characters, 'utf-8');
            \$randomString = '';
            for (\$i = 0; \$i < \$length; \$i++) {
            \$randomString .= mb_substr(\$characters, rand(0, \$charactersLength - 1), 1, 'utf-8');
            }
            return \$randomString;
            };
            EOD;
            $this->M_que_base_type->type_name = $input['type_name'];
            $this->M_que_base_type->type_code = $input['type_code'];
            $this->M_que_base_type->type_value = $type_value;
            $this->M_que_base_type->type_func = $type_func;
    } else if ($input['type_code']=='yr'){
            if($input['yearValue']== '1'){
                $type_func = <<<EOD
                \$get_value = function (\$length_limit = 2) {
                    switch (\$length_limit) {
                      case 2:
                        \$data = date('y') + 543;
                        if (date('m') > 12)
                          \$data++;
                        return \$data;
                      case 4:
                      default:
                        \$data = (date('Y') + 543);
                        if (date('m') > 12)
                          \$data++;
                        return \$data;
                    }
                    };
                EOD;
                $this->M_que_base_type->type_name = $input['type_name'];
                $this->M_que_base_type->type_code = $input['type_code'];
                $this->M_que_base_type->type_func = $type_func;
                $this->M_que_base_type->type_value = "ปีปฏิทิน";
            }
            else if($input['yearValue']== '2'){
                $type_func = <<<EOD
                \$get_value = function (\$length_limit = 2) {
                    switch (\$length_limit) {
                      case 2:
                        \$data = date('y') + 543;
                        if (date('m') > 9)
                          \$data++;
                        return \$data;
                      case 4:
                      default:
                        \$data = (date('Y') + 543);
                        if (date('m') > 9)
                          \$data++;
                        return \$data;
                    }
                    };
                EOD;
                $this->M_que_base_type->type_name = $input['type_name'];
                $this->M_que_base_type->type_code = $input['type_code'];
                $this->M_que_base_type->type_func = $type_func;
                $this->M_que_base_type->type_value = "ปีงบประมาณ";
            }
            
    } else if($input['type_code']=='rn'){
        if(ctype_upper($input['running']) && preg_match("/^[A-Z]+$/", $input['running']) && $this->validate_uppercase_format($input['running_format']) ){
            $type_value = json_encode(array("value" => $input['running'], "pattern" => "[".$input['running_format']."]"));
            $running_format = $input['running_format'];
            $type_func = <<<EOD
            \$get_value = function (\$value,\$length_limit=0){
                \$value = trim(\$value);
                if(\$value == ""){
                    return "";
                }
                if(!preg_match("/[$running_format]/",\$value)){
                    return "";
                }
                if(\$length_limit == 0) {
                    \$length_limit = strlen(\$value) + 1;
                }
                return substr(++\$value,-\$length_limit);
            };
            EOD;
            $this->M_que_base_type->type_name = $input['type_name'];
            $this->M_que_base_type->type_code = $input['type_code'];
            $this->M_que_base_type->type_func = $type_func;
            $this->M_que_base_type->type_value = $type_value;
        } else if(preg_match("/[a-z]/",$input['running']) && $this->validate_lowercase_format($input['running_format']) ){
            $type_value = json_encode(array("value" => $input['running'], "pattern" => "[".$input['running_format']."]"));
            $running_format = $input['running_format'];
            $type_func = <<<EOD
            \$get_value = function (\$value,\$length_limit=0){
                \$value = trim(\$value);
                if(\$value == ""){
                    return "";
                }
                if(!preg_match("/[$running_format]/",\$value)){
                    return "";
                }
                if(\$length_limit == 0) {
                    \$length_limit = strlen(\$value) + 1;
                }
                return substr(++\$value,-\$length_limit);
            };
            EOD;
            $this->M_que_base_type->type_name = $input['type_name'];
            $this->M_que_base_type->type_code = $input['type_code'];
            $this->M_que_base_type->type_func = $type_func;
            $this->M_que_base_type->type_value = $type_value;
        }else if(preg_match("/[0-9]/",$input['running']) && $this->validate_number_format($input['running_format']) ){
            $type_value = json_encode(array("value" => $input['running'], "pattern" => "[".$input['running_format']."]"));
            $running_format = $input['running_format'];
            $type_func = <<<EOD
            \$get_value = function (\$value,\$length_limit=0){
                \$value = trim(\$value);
                if(\$value == ""){
                    return "";
                }
                if(!preg_match("/[$running_format]/",\$value)){
                    return "";
                }
                if(\$length_limit == 0) {
                    \$length_limit = strlen(\$value) + 1;
                }
                return substr(++\$value,-\$length_limit);
            };
            EOD;
            $this->M_que_base_type->type_name = $input['type_name'];
            $this->M_que_base_type->type_code = $input['type_code'];
            $this->M_que_base_type->type_func = $type_func;
            $this->M_que_base_type->type_value = $type_value;
        }else if(preg_match("/^[\x{0E00}-\x{0E7F}]+$/u", $input['running']) &&  $this->validate_thai_format($input['running_format']) ){
            $type_value = json_encode(array("value" => $input['running'], "pattern" => "[".$input['running_format']."]"));
            $running_format = $input['running_format'];
            $type_func = <<<EOD
            \$get_value = function (\$value, \$length_limit = 0)
            {
                \$value = trim(\$value);
                if (\$value == "") {
                    return "";
                }
                if (!preg_match("/[$running_format]/", \$value)) {
                    return "";
                }
                if (\$length_limit == 0) {
                    \$length_limit = mb_strlen(\$value, 'utf-8') + 1;
                }
                \$array_thai = array(
                    'ก', 'ข', 'ค', 'ง', 'จ', 'ฉ', 'ช', 'ซ', 'ณ', 'ญ',
                    'ฐ', 'ฑ', 'ฒ', 'ณ', 'ด', 'ต', 'ถ', 'ท', 'ธ', 'น',
                    'บ', 'ป', 'ผ', 'ฝ', 'พ', 'ฟ', 'ภ', 'ม', 'ย', 'ร',
                    'ล', 'ว', 'ศ', 'ษ', 'ส', 'ห', 'ฬ', 'อ', 'ฮ'
                );
            
                \$size_array_thai = count(\$array_thai);
                \$size_value = mb_strlen(\$value, 'utf-8');
            
                \$is_last_ch_in_array = false;
                \$next_value = "";
                for (\$index = 1; \$index <= \$size_value; \$index++) {
                    \$value_last_str = mb_substr(\$value, -\$index, 1, 'utf-8');
                    \$pos_last_str = array_search(\$value_last_str, \$array_thai);
            
                    if (\$index == 1 || \$is_last_ch_in_array) {
                        \$next_value = \$array_thai[(\$pos_last_str + 1) % \$size_array_thai] . \$next_value;
                        \$is_last_ch_in_array = false;
                    } else {
                        \$next_value = \$value_last_str . \$next_value;
                    }
                    if (\$pos_last_str == \$size_array_thai - 1) {
                        \$is_last_ch_in_array = true;
                    }
                }
            
                if (\$is_last_ch_in_array) {
                    \$next_value = \$array_thai[0] . \$next_value;
                }
            
                return mb_substr(\$next_value, -\$length_limit, null, 'utf-8');
            };
            EOD;
            $this->M_que_base_type->type_name = $input['type_name'];
            $this->M_que_base_type->type_code = $input['type_code'];
            $this->M_que_base_type->type_func = $type_func;
            $this->M_que_base_type->type_value = $type_value;
        } else {
            
            $result['data']['returnUrl'] = base_url().'index.php/que/Tracking/add_form';
            $result['data']['status_response'] = $this->config->item('status_response_error');
            echo json_encode($result);
            return;
        }
    }


	
   
	$this->M_que_base_type->type_active = $this->input->post('type_active') ? 1 : 0;
	$this->M_que_base_type->type_create_date = date('Y-m-d H:i:s');
	$this->M_que_base_type->type_create_user = $this->session->userdata('us_id');
	$this->M_que_base_type->insert();
    $result['data']['returnUrl'] = base_url().'index.php/que/Tracking';
    $result['data']['status_response'] = $this->config->item('status_response_success');
    echo json_encode($result);
}

public function update($type_id){
    $input = $this->input->post();
    $result = array('data' => array());
    if ($input['type_code']== 'fx'){
        $this->M_que_base_type->type_name = $input['type_name'];
        $this->M_que_base_type->type_code = $input['type_code'];
    } else if ($input['type_code'] == 'rd') {
        $type_value = json_encode(array(
            array("value" => "is_use_number", "name" => "สุ่มตัวเลข"),
            array("value" => "is_use_lowercase", "name" => "ตัวอักษร a b c ..."),
            array("value" => "is_use_uppercase", "name" => "ตัวอักษร A B C ..."),
            array("value" => "is_use_thai_str", "name" => "ตัวอักษร ก ข ค ...")
        ));
            $type_func = <<<EOD
            \$get_value = function (\$length = 64, \$is_use_number = true, \$is_use_lowercase = true, \$is_use_uppercase = true, \$is_use_thai_str = false)
            {
            if (\$length < 1) {
            return "";
            }
            \$number = "0123456789";
            \$lowercase = "abcdefghijklmnopqrstuvwxyz";
            \$uppercase = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
            
            \$characters = '';
            if (\$is_use_number) {
            \$characters .= \$number;
            }
            if (\$is_use_lowercase) {
            \$characters .= \$lowercase;
            }
            if (\$is_use_uppercase) {
            \$characters .= \$uppercase;
            }

            \$charactersLength = mb_strlen(\$characters, 'utf-8');
            \$randomString = '';
            for (\$i = 0; \$i < \$length; \$i++) {
            \$randomString .= mb_substr(\$characters, rand(0, \$charactersLength - 1), 1, 'utf-8');
            }
            return \$randomString;
            };
            EOD;
            $this->M_que_base_type->type_name = $input['type_name'];
            $this->M_que_base_type->type_code = $input['type_code'];
            $this->M_que_base_type->type_value = $type_value;
            $this->M_que_base_type->type_func = $type_func;
    } else if ($input['type_code']=='yr'){
            if($input['yearValue']== '1'){
                $type_func = <<<EOD
                \$get_value = function (\$length_limit = 2) {
                    switch (\$length_limit) {
                      case 2:
                        \$data = date('y') + 543;
                        if (date('m') > 12)
                          \$data++;
                        return \$data;
                      case 4:
                      default:
                        \$data = (date('Y') + 543);
                        if (date('m') > 12)
                          \$data++;
                        return \$data;
                    }
                    };
                EOD;
                $this->M_que_base_type->type_name = $input['type_name'];
                $this->M_que_base_type->type_code = $input['type_code'];
                $this->M_que_base_type->type_func = $type_func;
                $this->M_que_base_type->type_value = "ปีปฏิทิน";
            }
            else if($input['yearValue']== '2'){
                $type_func = <<<EOD
                \$get_value = function (\$length_limit = 2) {
                    switch (\$length_limit) {
                      case 2:
                        \$data = date('y') + 543;
                        if (date('m') > 9)
                          \$data++;
                        return \$data;
                      case 4:
                      default:
                        \$data = (date('Y') + 543);
                        if (date('m') > 9)
                          \$data++;
                        return \$data;
                    }
                    };
                EOD;
                $this->M_que_base_type->type_name = $input['type_name'];
                $this->M_que_base_type->type_code = $input['type_code'];
                $this->M_que_base_type->type_func = $type_func;
                $this->M_que_base_type->type_value = "ปีงบประมาณ";
            }
            
    } else if($input['type_code']=='rn'){
        if(ctype_upper($input['running']) && preg_match("/^[A-Z]+$/", $input['running']) && $this->validate_uppercase_format($input['running_format']) ){
            $type_value = json_encode(array("value" => $input['running'], "pattern" => "[".$input['running_format']."]"));
            $running_format = $input['running_format'];
            $type_func = <<<EOD
            \$get_value = function (\$value,\$length_limit=0){
                \$value = trim(\$value);
                if(\$value == ""){
                    return "";
                }
                if(!preg_match("/[$running_format]/",\$value)){
                    return "";
                }
                if(\$length_limit == 0) {
                    \$length_limit = strlen(\$value) + 1;
                }
                return substr(++\$value,-\$length_limit);
            };
            EOD;
            $this->M_que_base_type->type_name = $input['type_name'];
            $this->M_que_base_type->type_code = $input['type_code'];
            $this->M_que_base_type->type_func = $type_func;
            $this->M_que_base_type->type_value = $type_value;
        } else if(preg_match("/[a-z]/",$input['running']) && $this->validate_lowercase_format($input['running_format']) ){
            $type_value = json_encode(array("value" => $input['running'], "pattern" => "[".$input['running_format']."]"));
            $running_format = $input['running_format'];
            $type_func = <<<EOD
            \$get_value = function (\$value,\$length_limit=0){
                \$value = trim(\$value);
                if(\$value == ""){
                    return "";
                }
                if(!preg_match("/[$running_format]/",\$value)){
                    return "";
                }
                if(\$length_limit == 0) {
                    \$length_limit = strlen(\$value) + 1;
                }
                return substr(++\$value,-\$length_limit);
            };
            EOD;
            $this->M_que_base_type->type_name = $input['type_name'];
            $this->M_que_base_type->type_code = $input['type_code'];
            $this->M_que_base_type->type_func = $type_func;
            $this->M_que_base_type->type_value = $type_value;
        }else if(preg_match("/[0-9]/",$input['running']) && $this->validate_number_format($input['running_format']) ){
            $type_value = json_encode(array("value" => $input['running'], "pattern" => "[".$input['running_format']."]"));
            $running_format = $input['running_format'];
            $type_func = <<<EOD
            \$get_value = function (\$value,\$length_limit=0){
                \$value = trim(\$value);
                if(\$value == ""){
                    return "";
                }
                if(!preg_match("/[$running_format]/",\$value)){
                    return "";
                }
                if(\$length_limit == 0) {
                    \$length_limit = strlen(\$value) + 1;
                }
                return substr(++\$value,-\$length_limit);
            };
            EOD;
            $this->M_que_base_type->type_name = $input['type_name'];
            $this->M_que_base_type->type_code = $input['type_code'];
            $this->M_que_base_type->type_func = $type_func;
            $this->M_que_base_type->type_value = $type_value;
        }else if(preg_match("/^[\x{0E00}-\x{0E7F}]+$/u", $input['running']) &&  $this->validate_thai_format($input['running_format']) ){
            $type_value = json_encode(array("value" => $input['running'], "pattern" => "[".$input['running_format']."]"));
            $running_format = $input['running_format'];
            $type_func = <<<EOD
            \$get_value = function (\$value, \$length_limit = 0)
            {
                \$value = trim(\$value);
                if (\$value == "") {
                    return "";
                }
                if (!preg_match("/[$running_format]/", \$value)) {
                    return "";
                }
                if (\$length_limit == 0) {
                    \$length_limit = mb_strlen(\$value, 'utf-8') + 1;
                }
                \$array_thai = array(
                    'ก', 'ข', 'ค', 'ง', 'จ', 'ฉ', 'ช', 'ซ', 'ณ', 'ญ',
                    'ฐ', 'ฑ', 'ฒ', 'ณ', 'ด', 'ต', 'ถ', 'ท', 'ธ', 'น',
                    'บ', 'ป', 'ผ', 'ฝ', 'พ', 'ฟ', 'ภ', 'ม', 'ย', 'ร',
                    'ล', 'ว', 'ศ', 'ษ', 'ส', 'ห', 'ฬ', 'อ', 'ฮ'
                );
            
                \$size_array_thai = count(\$array_thai);
                \$size_value = mb_strlen(\$value, 'utf-8');
            
                \$is_last_ch_in_array = false;
                \$next_value = "";
                for (\$index = 1; \$index <= \$size_value; \$index++) {
                    \$value_last_str = mb_substr(\$value, -\$index, 1, 'utf-8');
                    \$pos_last_str = array_search(\$value_last_str, \$array_thai);
            
                    if (\$index == 1 || \$is_last_ch_in_array) {
                        \$next_value = \$array_thai[(\$pos_last_str + 1) % \$size_array_thai] . \$next_value;
                        \$is_last_ch_in_array = false;
                    } else {
                        \$next_value = \$value_last_str . \$next_value;
                    }
                    if (\$pos_last_str == \$size_array_thai - 1) {
                        \$is_last_ch_in_array = true;
                    }
                }
            
                if (\$is_last_ch_in_array) {
                    \$next_value = \$array_thai[0] . \$next_value;
                }
            
                return mb_substr(\$next_value, -\$length_limit, null, 'utf-8');
            };
            EOD;
            $this->M_que_base_type->type_name = $input['type_name'];
            $this->M_que_base_type->type_code = $input['type_code'];
            $this->M_que_base_type->type_func = $type_func;
            $this->M_que_base_type->type_value = $type_value;
        } else {
            
            $result['data']['returnUrl'] = base_url().'index.php/que/Tracking/add_form';
            $result['data']['status_response'] = $this->config->item('status_response_error');
            echo json_encode($result);
            return;
        }
    }

	$this->M_que_base_type->type_id = $type_id;
    $this->M_que_base_type->type_active = $this->input->post('type_active') ? 1 : 0;
	$this->M_que_base_type->type_update_date = date('Y-m-d H:i:s');
	$this->M_que_base_type->type_update_user = $this->session->userdata('us_id');
	$this->M_que_base_type->update();
    $result['data']['returnUrl'] = base_url().'index.php/que/Tracking';
    $result['data']['status_response'] = $this->config->item('status_response_success');
    echo json_encode($result);
}
public function delete($type_id){
 
    $current_active = $this->M_que_base_type->get_by_id($type_id)->row();
    if ($current_active->type_active== "0"){ 
        $this->M_que_base_type->type_id = $type_id; //หากสถานะเป็น 0
        $this->M_que_base_type->type_active = '2'; //เปลี่ยนสถานะเป็น 2 : ลบ
        $this->M_que_base_type->delete();//ลบโดยเปลี่ยนสถานะเป็น 2
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