<?php

include_once("Da_wts_base_route_time.php");

class M_wts_base_route_time extends Da_wts_base_route_time {

/*
* get_all_disease_time
* ดึงข้อมูลระยะเวลาของประเภทโรค
* @input -
* $output disease time list
* @author Supawee Sangrapee
* @Create Date 03/06/2024
*/
	function get_all() {
		$sql = "SELECT rt_id, rt_seq, rt_dst_id, wts_base_disease_time.dst_name_point as name_point, wts_base_disease_time.dst_minute as point_minute
				FROM `wts_base_route_time`
				LEFT JOIN wts_base_disease_time
				ON rt_dst_id = wts_base_disease_time.dst_id;
				";
		$query = $this->wts->query($sql);

		return $query;		
	}

/*
* get_all_route_time_list
* ดึงข้อมูลระยะเวลาของประเภทโรคตามไอดีระยะเวลา
* @input -
* $output disease time list by dst_id
* @author Supawee Sangrapee
* @Create Date 03/06/2024
*/
function get_all_route_time_list($rt_rdp_id) {
    $sql = "SELECT rt_id, rt_rdp_id, rt_seq, rt_dst_id, dst_id, dst_patient_treatment_type, dst_name_point, dst_minute, dst_active, dst_is_see_doctor
            FROM wts_base_route_time
            LEFT JOIN wts_base_disease_time
            ON rt_dst_id = wts_base_disease_time.dst_id
            WHERE rt_rdp_id = ?
            GROUP BY rt_dst_id
            ORDER BY rt_seq";

    $query = $this->wts->query($sql, array($rt_rdp_id));

    // Check if the result is empty
    if ($query->num_rows() == 0) {
        // Query again with rt_rdp_id = '1'
        $query = $this->wts->query($sql, array('1'));
    }

    return $query;
}

	/*
	* get_route_time_see_doctor_by_rdp_id
	* ดึงข้อมูลระยะเวลาของประเภทโรคที่เป็นการพบแพทย์ตามไอดีเส้นทาง
	* @input rt_rdp_id(wts_base_route_department id): ไอดีเส้นทาง
	* $output first dst_id
	* @author Areerat
	* @Create Date 01/08/2024
	*/
	function get_route_time_see_doctor_by_rdp_id($rt_rdp_id) {
		$sql = "SELECT dst_id 
				FROM `wts_base_route_time` 
				LEFT JOIN wts_base_disease_time ON rt_dst_id = wts_base_disease_time.dst_id 
				WHERE rt_rdp_id = ? AND dst_is_see_doctor = 1 
				GROUP BY rt_dst_id 
				ORDER BY rt_seq 
				LIMIT 1 ;";
		$query = $this->wts->query($sql, array($rt_rdp_id));
		return $query;		
	}

} // end class M_wts_base_disease_time
?>