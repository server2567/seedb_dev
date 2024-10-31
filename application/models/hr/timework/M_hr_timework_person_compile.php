<?php
/*
* M_hr_timework_person_compile
* Model for Manage about hr_timework_person_compile Table.
* @Author Tanadon Tangjaimongkhon
* @Create Date 23/09/2024
*/
include_once("Da_hr_timework_person_compile.php");

class M_hr_timework_person_compile extends Da_hr_timework_person_compile {

    /*
	* get_all_profile_data_by_param
	* ข้อมูลบุคลากรทั้งหมดตามพารามิเตอร์
	* @input -
	* @output person all
	* @author Tanadon Tangjaimongkhon
	* @Create Date 2567-05-21
	*/
	function get_all_profile_data_by_param($dp_id, $hire_is_medical, $hire_type, $status_id, $month, $year)
	{
		$cond = "";
	
		// กรองตามประเภทการจ้างงาน
		if ($hire_type != "all") {
			$cond .= " AND hire.hire_type = " . $this->hr->escape($hire_type);
		}
	
		// กรองตามสถานะการทำงาน
		if ($status_id != "all") {
			$cond .= " AND pos.pos_status = " . $this->hr->escape($status_id);
		}
	
		// กรองตามสายปฏิบัติงาน
		if ($hire_is_medical != "all") {
			$cond .= " AND hire.hire_is_medical = " . $this->hr->escape($hire_is_medical);
		}
	
		// กำหนดวันที่เริ่มต้นและสิ้นสุดของเดือน
		$start_date = "{$year}-{$month}-01";
		$end_date = date("Y-m-t", strtotime($start_date)); // วันที่สิ้นสุดของเดือน
	
		// Query SQL
		$sql = "
			SELECT 
				ps.ps_id,
				ps.ps_fname,
				ps.ps_lname,
				pf.pf_name,
				-- นับสถานะตาม ws_id
				SUM(CASE WHEN twcp.twcp_ws_id = 10 THEN 1 ELSE 0 END) AS count_ws_id_10,
				SUM(CASE WHEN twcp.twcp_ws_id = 11 THEN 1 ELSE 0 END) AS count_ws_id_11,
				SUM(CASE WHEN twcp.twcp_ws_id = 12 THEN 1 ELSE 0 END) AS count_ws_id_12,
				SUM(CASE WHEN twcp.twcp_ws_id = 13 THEN 1 ELSE 0 END) AS count_ws_id_13,
				SUM(CASE WHEN twcp.twcp_ws_id = 20 THEN 1 ELSE 0 END) AS count_ws_id_20,
				SUM(CASE WHEN twcp.twcp_ws_id = 21 THEN 1 ELSE 0 END) AS count_ws_id_21,
				SUM(CASE WHEN twcp.twcp_ws_id = 22 THEN 1 ELSE 0 END) AS count_ws_id_22,
				SUM(CASE WHEN twcp.twcp_ws_id = 23 THEN 1 ELSE 0 END) AS count_ws_id_23,
				SUM(CASE WHEN twcp.twcp_ws_id = 24 THEN 1 ELSE 0 END) AS count_ws_id_24,
				SUM(CASE WHEN twcp.twcp_ws_id = 30 THEN 1 ELSE 0 END) AS count_ws_id_30,
				SUM(CASE WHEN twcp.twcp_ws_id = 31 THEN 1 ELSE 0 END) AS count_ws_id_31,
				SUM(CASE WHEN twcp.twcp_ws_id = 32 THEN 1 ELSE 0 END) AS count_ws_id_32,
				SUM(CASE WHEN twcp.twcp_ws_id = 33 THEN 1 ELSE 0 END) AS count_ws_id_33,
				SUM(CASE WHEN twcp.twcp_ws_id = 34 THEN 1 ELSE 0 END) AS count_ws_id_34,
				SUM(CASE WHEN twcp.twcp_ws_id = 35 THEN 1 ELSE 0 END) AS count_ws_id_35,
				SUM(CASE WHEN twcp.twcp_ws_id = 36 THEN 1 ELSE 0 END) AS count_ws_id_36,
				SUM(CASE WHEN twcp.twcp_ws_id = 37 THEN 1 ELSE 0 END) AS count_ws_id_37,
				SUM(CASE WHEN twcp.twcp_ws_id = 38 THEN 1 ELSE 0 END) AS count_ws_id_38,
				SUM(CASE WHEN twcp.twcp_ws_id = 39 THEN 1 ELSE 0 END) AS count_ws_id_39,
				SUM(CASE WHEN twcp.twcp_ws_id = 40 THEN 1 ELSE 0 END) AS count_ws_id_40,
				SUM(CASE WHEN twcp.twcp_ws_id = 41 THEN 1 ELSE 0 END) AS count_ws_id_41,
				SUM(CASE WHEN twcp.twcp_ws_id = 90 THEN 1 ELSE 0 END) AS count_ws_id_90,
				SUM(CASE WHEN twcp.twcp_ws_id = 91 THEN 1 ELSE 0 END) AS count_ws_id_91,
				SUM(CASE WHEN twcp.twcp_ws_id = 100 THEN 1 ELSE 0 END) AS count_ws_id_100
			FROM " . $this->hr_db . ".hr_person AS ps
			LEFT JOIN " . $this->hr_db . ".hr_person_detail AS psd 
				ON psd.psd_ps_id = ps.ps_id
			LEFT JOIN " . $this->hr_db . ".hr_base_prefix AS pf 
				ON ps.ps_pf_id = pf.pf_id
			LEFT JOIN " . $this->hr_db . ".hr_person_position AS pos 
				ON pos.pos_ps_id = ps.ps_id
			LEFT JOIN " . $this->hr_db . ".hr_base_hire AS hire 
				ON pos.pos_hire_id = hire.hire_id
			LEFT JOIN " . $this->hr_db . ".hr_timework_compile AS twcp 
				ON twcp.twcp_ps_id = ps.ps_id 
				
			LEFT JOIN " . $this->hr_db . ".hr_timework_status AS ws 
				ON ws.ws_id = twcp.twcp_ws_id
			WHERE 
				pos.pos_dp_id = " . $this->hr->escape($dp_id) . "
				AND pos.pos_active = 'Y'
				AND ws.ws_active = 'Y'
				AND twcp.twcp_date BETWEEN '{$start_date}' AND '{$end_date}'
				
				{$cond}
			GROUP BY ps.ps_id, ps.ps_fname, ps.ps_lname, pf.pf_name
			ORDER BY ps.ps_lname, ps.ps_fname
		";
		
		$query = $this->hr->query($sql);
		// echo $this->hr->last_query();
		return $query;
	}
    // get_all_profile_data_by_param

	 /*
	* get_all_timework_compile_data_by_param
	* ข้อมูลประมวลผลการทำงานทั้งหมดตามพารามิเตอร์
	* @input -
	* @output timework compile
	* @author Tanadon Tangjaimongkhon
	* @Create Date 2567-05-21
	*/
	function get_all_timework_compile_data_by_param($dp_id, $hire_is_medical, $hire_type, $status_id)
	{
		$cond = "";
	
		// กรองตามประเภทการจ้างงาน
		if ($hire_type != "all") {
			$cond .= " AND hire.hire_type = " . $this->hr->escape($hire_type);
		}
	
		// กรองตามสถานะการทำงาน
		if ($status_id != "all") {
			$cond .= " AND pos.pos_status = " . $this->hr->escape($status_id);
		}
	
		// กรองตามสายปฏิบัติงาน
		if ($hire_is_medical != "all") {
			$cond .= " AND hire.hire_is_medical = " . $this->hr->escape($hire_is_medical);
		}
	
		// Query SQL
		$sql = "
			SELECT 
				ps.ps_id
		
			FROM " . $this->hr_db . ".hr_person AS ps
			LEFT JOIN " . $this->hr_db . ".hr_person_position AS pos 
				ON pos.pos_ps_id = ps.ps_id
			LEFT JOIN " . $this->hr_db . ".hr_base_hire AS hire 
				ON pos.pos_hire_id = hire.hire_id
			WHERE 
				pos.pos_dp_id = " . $this->hr->escape($dp_id) . "
				AND pos.pos_active = 'Y'
				{$cond}
		";
	
		$query = $this->hr->query($sql);
		return $query;
	}
    // get_all_timework_compile_data_by_param

	public function get_timework_status_by_group_and_parent($dp_id, $hire_is_medical, $hire_type, $status_id, $month, $year)
    {
		$cond = "";
	
		// กรองตามประเภทการจ้างงาน
		if ($hire_type != "all") {
			$cond .= " AND hire.hire_type = " . $this->hr->escape($hire_type);
		}
	
		// กรองตามสถานะการทำงาน
		if ($status_id != "all") {
			$cond .= " AND pos.pos_status = " . $this->hr->escape($status_id);
		}
	
		// กรองตามสายปฏิบัติงาน
		if ($hire_is_medical != "all") {
			$cond .= " AND hire.hire_is_medical = " . $this->hr->escape($hire_is_medical);
		}
	
		// กำหนดวันที่เริ่มต้นและสิ้นสุดของเดือน
		$start_date = "{$year}-{$month}-01";
		$end_date = date("Y-m-t", strtotime($start_date)); // วันที่สิ้นสุดของเดือน
	
		// Query SQL
		$sql = "
			SELECT 
				ws.*
			FROM " . $this->hr_db . ".hr_person AS ps
			LEFT JOIN " . $this->hr_db . ".hr_person_detail AS psd 
				ON psd.psd_ps_id = ps.ps_id
			LEFT JOIN " . $this->hr_db . ".hr_base_prefix AS pf 
				ON ps.ps_pf_id = pf.pf_id
			LEFT JOIN " . $this->hr_db . ".hr_person_position AS pos 
				ON pos.pos_ps_id = ps.ps_id
			LEFT JOIN " . $this->hr_db . ".hr_base_hire AS hire 
				ON pos.pos_hire_id = hire.hire_id
			LEFT JOIN " . $this->hr_db . ".hr_timework_compile AS twcp 
				ON twcp.twcp_ps_id = ps.ps_id 
				AND twcp.twcp_date BETWEEN '{$start_date}' AND '{$end_date}'
			LEFT JOIN " . $this->hr_db . ".hr_timework_status AS ws 
				ON ws.ws_id = twcp.twcp_ws_id
			WHERE 
				pos.pos_dp_id = " . $this->hr->escape($dp_id) . "
				AND pos.pos_active = 'Y'
				AND ws.ws_active = 'Y'
				
				{$cond}
			GROUP BY ws_id
        	ORDER BY ws_group, ws_parent_id, ws_seq
		";
		
		$query = $this->hr->query($sql);
		// echo $this->hr->last_query();
		// return $query;

		$statuses = [];
        foreach ($query->result() as $row) {
            $statuses[$row->ws_group][$row->ws_parent_id][] = [
                'ws_id' => $row->ws_id,
                'ws_name' => $row->ws_name
            ];
        }
        
        return $statuses;
    }

	function insert_missing_timework($ps_id, $month, $year) {
		// กำหนดจำนวนวันในเดือน
		$total_days_in_month = cal_days_in_month(CAL_GREGORIAN, $month, $year);
		
		// ลูปตามจำนวนวันในเดือนนั้น
		for ($day = 1; $day <= $total_days_in_month; $day++) {
			// แปลงวันเป็นรูปแบบวันที่
			$date = sprintf('%04d-%02d-%02d', $year, $month, $day);
			
			// ดึงข้อมูล hipos_id ที่มี hipos_end_date มากที่สุดสำหรับ ps_id ที่กำหนด
			$this->hr->select('hipos_id');
			$this->hr->from('hr_person_position_history');
			$this->hr->where('hipos_ps_id', $ps_id);
			$this->hr->order_by('hipos_end_date', 'DESC');
			$this->hr->limit(1);

			$query = $this->hr->get();
			if ($query->num_rows() > 0) {
				$hipos_id = $query->row()->hipos_id; // นำ hipos_id มาใช้
			} else {
				$hipos_id = null; // กรณีไม่มีข้อมูล
			}

			// ตรวจสอบว่ามีข้อมูลอยู่แล้วหรือไม่
			$query_check = $this->hr->get_where('hr_timework_compile', array(
				'twcp_ps_id' => $ps_id,
				'twcp_date' => $date
			));

			// ถ้าไม่มีข้อมูล ให้ insert ข้อมูลใหม่พร้อม twcp_ws_id = 100
			if ($query_check->num_rows() == 0) {
				$this->hr->insert('hr_timework_compile', array(
					'twcp_ps_id' => $ps_id,
					'twcp_date' => $date,
					'twcp_ws_id' => 100,  // รอการประมวลผล
					'twcp_hipos_id' => $hipos_id, // ใช้ hipos_id ที่ได้จากการ query
					'twcp_time' => "00:00:00",
					'twcp_num_hour' => 0,
					'twcp_num_minute' => 0,
					'twcp_desc' => "",
					'twcp_seq' => 1,
					'twcp_create_user' => $this->session->userdata('us_id'),
					'twcp_create_date' => date('Y-m-d H:i:s'),
				));
			}

		}
	}


    	/*
	* get_all_profile_data_by_ps_id
	* ข้อมูลบุคลากรทั้งหมดตามพารามิเตอร์
	* @input -
	* @output person all
	* @author Tanadon Tangjaimongkhon
	* @Create Date 2567-05-21
	*/
	function get_all_profile_data_by_ps_id($ps_id, $start_date, $end_date)
	{
		
	    
		$sql = "
        SELECT 
            ps.ps_id,
            pf.pf_name,
            ps.ps_fname,
            ps.ps_lname,
            twcp.twcp_id,
            twcp.twcp_mc_code,
            twcp.twcp_ps_code,
            twcp.twcp_date,
            GROUP_CONCAT(twcp.twcp_time SEPARATOR ', ') AS twcp_time_text
           
        FROM " . $this->hr_db . ".hr_person AS ps
        LEFT JOIN " . $this->hr_db . ".hr_person_detail AS psd ON psd.psd_ps_id = ps.ps_id
        LEFT JOIN " . $this->hr_db . ".hr_base_prefix AS pf ON ps.ps_pf_id = pf.pf_id
        LEFT JOIN " . $this->hr_db . ".hr_person_position AS pos ON pos.pos_ps_id = ps.ps_id
        LEFT JOIN " . $this->hr_db . ".hr_base_hire AS hire ON pos.pos_hire_id = hire.hire_id
        LEFT JOIN " . $this->hr_db . ".hr_timework_person_compile AS twcp ON twcp.twcp_ps_code = pos.pos_ps_code
		LEFT JOIN " . $this->hr_db . ".hr_timework_matching_code as mc ON mc.mc_ps_id = ps.ps_id
        WHERE 
            pos.pos_ps_id = {$ps_id} 
            AND twcp.twcp_date >= '{$start_date}'
            AND twcp.twcp_date <= '{$end_date}'
            
        GROUP BY twcp.twcp_date, ps.ps_id
        ORDER BY ps.ps_id, twcp.twcp_date";

		$query = $this->hr->query($sql);
		// echo $this->hr->last_query();
		return $query;
	}
    // get_all_profile_data_by_ps_id

    /*
	* get_person_matching_code
	* ตรวจสอบรหัสเครื่องในระบบ
	* @input -
	* @output count_data
	* @author Tanadon Tangjaimongkhon
	* @Create Date 10/18/2567
	*/
	function get_person_matching_code($mc_code, $ps_pos_code)
	{
		$sql = "SELECT COUNT(*) as count_data, pos_ps_id
                FROM " . $this->hr_db . ".hr_timework_matching_code 
                LEFT JOIN " . $this->hr_db . ".hr_person_position
                    ON mc_ps_id = pos_ps_id AND mc_dp_id = pos_dp_id
                WHERE mc_code = {$mc_code} AND pos_ps_code = {$ps_pos_code}";
		$query = $this->hr->query($sql);
		return $query;
	}
    // get_person_matching_code

} // end class M_hr_timework_person_compile
?>
