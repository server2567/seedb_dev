<?php
/**
 * request_number ใช้สำหรับขอหมายเลขนัดหมาย
 * @param $keyword
	 * @author patiya
	 * @create_date 2024-06-12
 */
function request_number($keyword)
{
	$ci = get_instance();
	$ci->load->model('que/M_que_create_tracking');
	$ci->load->model('que/M_que_code_list');
	$keyword_data = $ci->M_que_create_tracking->get_by_keyword_active($keyword);
	if ($keyword_data->num_rows() > 0) {
		$set_number = gen_number($keyword_data->row()->ct_value);
		
		while ($ci->M_que_code_list->check_has_key($set_number['number'], $keyword)) {
			$keyword_data = $ci->M_que_create_tracking->get_by_keyword_active($keyword);
			$set_number = gen_number($keyword_data->row()->ct_value);
		}
		$ci->M_que_code_list->insert_key($set_number['number'], $keyword);
		$ci->M_que_create_tracking->update_by_id($keyword_data->row()->ct_id, array("ct_value" => $set_number['value_update']));

		return $set_number['number'];
	}
	return "";
}
/**
 * request_number ใช้สำหรับขอหมายเลขคิว
 * @param $keyword
	 * @author Dechathon
	 * @create_date 2024-07-24
 */
function request_queue($keyword)
{
	$ci = get_instance();
	$ci->load->model('que/M_que_create_queue');
	$ci->load->model('que/M_que_queue_list');
	$keyword_data = $ci->M_que_create_queue->get_by_keyword_active($keyword);
	
	if ($keyword_data->num_rows() > 0) {
		
		$set_number = gen_number($keyword_data->row()->cq_value);
		
		$ci->M_que_queue_list->insert_key($set_number['number'], $keyword);
		$ci->M_que_create_queue->update_by_id($keyword_data->row()->cq_id, array("cq_value" => $set_number['value_update']));

		return $set_number['number'];
	}
	return " ";
}


/**
 * update_status_number ใช้สำหรับ เพิ่มการติดตามข้อมูล
 * @param $code
 * @param $keyword
 * @param $status เป็นข้อมูลข้อความ String
 * @param $make_status_by เป็นข้อมูลข้อความ String
	 * @author patiya
	 * @create_date 2024-06-12
 */
function update_status_number($code, $keyword, $status, $make_status_by)
{
	$ci = get_instance();
	//load model and update status
	$ci->load->model('tk/M_que_code_list');
	$ci->load->model('tk/M_que_code_history');

	if ($ci->M_que_code_list->check_has_key($code, $keyword)) {
		$data_insert = array();
		$data_insert['th_track_code'] = $code;
		$data_insert['th_keyword'] = $keyword;
		$data_insert['th_activity'] = $status;
		$data_insert['th_activity_by'] = $make_status_by;
		$ci->M_que_code_history->insert_history($data_insert);
		return true;
	}
	return false;
}

/**
 * gen_number ใช้สร้างตัวเลข แต่ไม่ได้ save ลงฐาน
 * @param $json_data_list
 * @return array[number] and [value_update] {JSON}
	 * @author patiya
	 * @create_date 2024-06-12
 */
function gen_number($json_data_list)
{
	$value_list = json_decode($json_data_list);
	
	$val_result = "";
	foreach ($value_list as $key => $value) {
		if ($value->char_type != "rd") {
			$val_result .= str_pad(
				$value->char_type_value,
				strlen($value->char_type_value) - mb_strlen($value->char_type_value, "UTF-8") + $value->char_length,
				"0",
				STR_PAD_LEFT);
			if ($value->char_type == "rn") {

				eval(base64_decode($value->function));
				$value_list[$key]->char_type_value = $get_value($value->char_type_value, $value->char_length);
				
				unset($get_value);
			}
		} else {
			$val_rd_select = json_decode(base64_decode($value->char_type_value));

			eval(base64_decode($value->function));
			$rd_string = $get_value($value->char_length,
				$val_rd_select->is_use_number,
				$val_rd_select->is_use_lowercase,
				$val_rd_select->is_use_uppercase,
				$val_rd_select->is_use_thai_str);
			unset($get_value);
			$val_result .= str_pad(
				$rd_string,
				strlen($rd_string) - mb_strlen($rd_string, "UTF-8") + $value->char_length,
				"0",
				STR_PAD_LEFT);
		}
	}
	
	return array("number" => $val_result, "value_update" => json_encode($value_list));
}

