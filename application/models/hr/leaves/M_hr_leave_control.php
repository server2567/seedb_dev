<?php
/*
 * M_hr_leave_control
 * Model for Manage about hr_leave_control and hr_leave Table.
 * @Author Patcharapol Sirimaneechot
 * @Create Date 07/10/2024
 */
include_once("Da_hr_leave_control.php");

class M_hr_leave_control extends Da_hr_leave_control 
{
	/*
	* get_all_leave_type
	* ดึงข้อมูลชนิดการลาทั้งหมด
	* @input -
	* @output leave_type all
	* @author Patcharapol Sirimaneechot
	* @Create Date 2567-10-07
	*/

	function delete_leave_control($id) {
		try {
			$query = $this->hr->query("DELETE FROM hr_leave_control WHERE ctrl_id = ?", array($id));
			return $query;
		} catch (e) {
			return false;
		}
	}

	function get_leave_control_by_condition($hire_is_medical_id, $leave_id, $hire_type) {
		// -99 mean that param not recieved
		// -99 mean get all data (no need to use that param for write condition in sql statement)

		/*** edit query string ***/ 

		// main statement with where
		$main_statement = "SELECT * FROM hr_leave_control LEFT JOIN hr_leave ON hr_leave.leave_id = hr_leave_control.ctrl_leave_id WHERE ";
		$left_join_conjunction = " LEFT JOIN ";

		$and = " AND ";
		
		// filter by condition
		$hire_is_medical_id_condition = "ctrl_hire_id = ?";
		$leave_id_condition = "ctrl_leave_id = ?";
		$hire_type_condition = "ctrl_hire_type = ?";

		$myArray = array();
		
		if ($hire_is_medical_id == "-99" && $leave_id == "-99" && $hire_type == "-99") {
			return $this->get_all_leave_control();
		} else {
			if($hire_is_medical_id != "-99") {
				$main_statement .= $hire_is_medical_id_condition;
				$main_statement .= $and;
				array_push($myArray, $hire_is_medical_id);
			}

			if($leave_id != "-99") {
				$main_statement .= $leave_id_condition;
				$main_statement .= $and;
				array_push($myArray, $leave_id);
			}

			if($hire_type != "-99") {
				$main_statement .= $hire_type_condition;
				array_push($myArray, $hire_type);
			} else {
				// remove the " AND " string 	if last param not recieved (last param == "-99").
				$main_statement = substr($main_statement, 0, strlen($main_statement)-5); 
			}
		}

		/*
			paramName:	 |	paramA	|	paramB	|	paramC
			is  recieved:|		T		  T			  T
					     |		T		  T			  F
					     |		T		  F			  T
					     |		T		  F			  F
					     |		F		  T			  T
					     |		F		  T			  F
					     |		F		  F			  T
					     |		F		  F			  F
		*/

		$data = $this->hr->query($main_statement, $myArray);
		$data = $data->result_array();
		return $data;

		// ====================================================================================
		
		// legacy code
		// if ($hire_is_medical_id == "-99" && $leave_id == "-99" && $hire_type == "-99") {
		// 	return $this->get_all_leave_control();
		// } else if ($hire_is_medical_id == "-99" && $leave_id != "-99") {
		// 	$data = $this->hr->query("SELECT * FROM hr_leave_control LEFT JOIN hr_hire_is_medical ON hr_hire_is_medical.code = hr_leave_control.ctrl_hire_id LEFT JOIN hr_leave ON hr_leave.leave_id = hr_leave_control.ctrl_leave_id WHERE ctrl_leave_id = ?", array($leave_id));
		// 	$data = $data->result_array();
		// 	return $data;
		// } else if ($hire_is_medical_id != "-99" && $leave_id == "-99") {
		// 	$data = $this->hr->query("SELECT * FROM hr_leave_control LEFT JOIN hr_hire_is_medical ON hr_hire_is_medical.code = hr_leave_control.ctrl_hire_id LEFT JOIN hr_leave ON hr_leave.leave_id = hr_leave_control.ctrl_leave_id WHERE ctrl_hire_id = ?", array($hire_is_medical_id));
		// 	$data = $data->result_array();
		// 	return $data;
		// } else {
		// 	$data = $this->hr->query("SELECT * FROM hr_leave_control LEFT JOIN hr_hire_is_medical ON hr_hire_is_medical.code = hr_leave_control.ctrl_hire_id LEFT JOIN hr_leave ON hr_leave.leave_id = hr_leave_control.ctrl_leave_id WHERE ctrl_hire_id = ? AND ctrl_leave_id = ?", array($hire_is_medical_id, $leave_id));
		// 	$data = $data->result_array();
		// 	return $data;
		// }
	}

	// function get_all_hire_is_medical() {
	// 	$data = $this->hr->query("SELECT * FROM hr_hire_is_medical", array());
	// 	$data = $data->result_array();
	// 	return $data;
	// }
	
	function get_all_leave() {
		$data = $this->hr->query("SELECT * FROM hr_leave", array());
		$data = $data->result_array();
		return $data;
	}

	function get_leave_control($id) {
		$data = $this->hr->query("SELECT * FROM hr_leave_control WHERE ctrl_id = ?", array($id));
		$data = $data->result_array();
		return $data;
	}
	
	function get_all_leave_control() {
		// $data = $this->hr->query("SELECT * FROM hr_leave_control INNER JOIN hr_base_hire ON hr_base_hire.hire_is_medical = hr_leave_control.ctrl_hire_id INNER JOIN hr_hire_is_medical ON hr_hire_is_medical.code = hr_base_hire.hire_is_medical INNER JOIN hr_leave ON hr_leave.leave_id = hr_leave_control.ctrl_leave_id GROUP BY ctrl_id", array());
		// $data = $this->hr->query("SELECT * FROM hr_leave_control LEFT JOIN hr_hire_is_medical ON hr_hire_is_medical.code = hr_leave_control.ctrl_hire_id LEFT JOIN hr_leave ON hr_leave.leave_id = hr_leave_control.ctrl_leave_id", array());
		$data = $this->hr->query("SELECT * FROM hr_leave_control LEFT JOIN hr_leave ON hr_leave.leave_id = hr_leave_control.ctrl_leave_id ORDER BY hr_leave_control.ctrl_id DESC", array());
		$data = $data->result_array();
		return $data;
	}
	
	function store_leave_control($data, $us_id) {
		try {
			// $query = $this->hr->query("INSERT INTO `hr_leave_control`( `ctrl_hire_id`, `ctrl_hire_type`, `ctrl_leave_id`, `ctrl_start_age`, `ctrl_end_age`, `ctrl_time_per_year`, `ctrl_day_per_year`, `ctrl_date_per_time`, `ctrl_pack_per_year`, `ctrl_money`, `ctrl_day_before`, `ctrl_day_after`, `ctrl_gd_id`, `ctrl_update`, `ctrl_user_update`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?, CURRENT_TIMESTAMP() , CURRENT_TIMESTAMP() )", 
			$query = $this->hr->query("INSERT INTO `hr_leave_control`( `ctrl_hire_id`, `ctrl_hire_type`, `ctrl_leave_id`, `ctrl_start_age`, `ctrl_end_age`, `ctrl_time_per_year`, `ctrl_day_per_year`, `ctrl_hour_per_year`, `ctrl_minute_per_year`, `ctrl_date_per_time`, `ctrl_pack_per_year`, `ctrl_money`, `ctrl_day_before`, `ctrl_day_after`, `ctrl_gd_id`, `ctrl_update`, `ctrl_user_update`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?, CURRENT_TIMESTAMP() , ? )", 
				array(
					$data['ctrl_hire_id']
					,$data['ctrl_hire_type']
					,$data['ctrl_leave_id']
					,$data['ctrl_start_age']
					,$data['ctrl_end_age']
					,$data['ctrl_time_per_year']
					,$data['ctrl_day_per_year']
					,$data['ctrl_hour_per_year']
					,$data['ctrl_minute_per_year']
					,$data['ctrl_date_per_time']
					,$data['ctrl_pack_per_year']
					,$data['ctrl_money']
					,$data['ctrl_day_before']
					,$data['ctrl_day_after']
					,$data['ctrl_gd_id']
					,$us_id
				));
			return $query;
		} catch (e) {
			return false;
		}
	}
	
	function store_updated_leave_control($id, $data, $us_id) {
		try {
			// $query = $this->hr->query("UPDATE `hr_leave_control` SET `ctrl_hire_id` = ?, `ctrl_hire_type` = ?, `ctrl_leave_id` = ?, `ctrl_start_age` = ?, `ctrl_end_age` = ?, `ctrl_time_per_year` = ?, `ctrl_day_per_year` = ?, `ctrl_date_per_time` = ?, `ctrl_pack_per_year` = ?, `ctrl_money` = ?, `ctrl_day_before` = ?, `ctrl_day_after` = ?, `ctrl_gd_id` = ?, `ctrl_update` = CURRENT_TIMESTAMP(), `ctrl_user_update` = CURRENT_TIMESTAMP() WHERE ctrl_id = ?;", 
			$query = $this->hr->query("UPDATE `hr_leave_control` SET `ctrl_hire_id` = ?, `ctrl_hire_type` = ?, `ctrl_leave_id` = ?, `ctrl_start_age` = ?, `ctrl_end_age` = ?, `ctrl_time_per_year` = ?, `ctrl_day_per_year` = ?, `ctrl_hour_per_year` = ?, `ctrl_minute_per_year` = ?, `ctrl_date_per_time` = ?, `ctrl_pack_per_year` = ?, `ctrl_money` = ?, `ctrl_day_before` = ?, `ctrl_day_after` = ?, `ctrl_gd_id` = ?, `ctrl_update` = CURRENT_TIMESTAMP(), `ctrl_user_update` = ? WHERE ctrl_id = ?;", 
				array(
					$data['ctrl_hire_id']
					,$data['ctrl_hire_type']
					,$data['ctrl_leave_id']
					,$data['ctrl_start_age']
					,$data['ctrl_end_age']
					,$data['ctrl_time_per_year']
					,$data['ctrl_day_per_year']
					,$data['ctrl_hour_per_year']
					,$data['ctrl_minute_per_year']
					,$data['ctrl_date_per_time']
					,$data['ctrl_pack_per_year']
					,$data['ctrl_money']
					,$data['ctrl_day_before']
					,$data['ctrl_day_after']
					,$data['ctrl_gd_id']
					,$us_id
					,$id
				));
			return $query;
		} catch (e) {
			return false;
		}
	}

}