<?php
/*
* M_hr_timework_person_record
* Model for Manage about hr_timework_person_record Table.
* @Author Tanadon Tangjaimongkhon
* @Create Date 23/09/2024
*/
include_once("Da_hr_timework_person_record.php");

class M_hr_timework_person_record extends Da_hr_timework_person_record {

    	/*
	* get_all_profile_data_by_param
	* ข้อมูลบุคลากรทั้งหมดตามพารามิเตอร์
	* @input -
	* @output person all
	* @author Tanadon Tangjaimongkhon
	* @Create Date 2567-05-21
	*/
	function get_all_profile_data_by_param($dp_id, $hire_is_medical, $hire_type, $status_id, $start_date, $end_date)
	{
		$cond = "";

		if($hire_type != "all"){
			$cond .= " AND hire.hire_type = {$hire_type}";
		}

        if ($status_id != "all") {
			$cond .= " AND pos.pos_status = " . $this->hr->escape($status_id);
		}

        if($hire_is_medical != "all"){
			$cond .= " AND hire.hire_is_medical = '{$hire_is_medical}'";
		}
	    
		$sql = "
        SELECT 
            ps.ps_id,
            pf.pf_name,
            ps.ps_fname,
            ps.ps_lname,
            twpc.twpc_id,
            twpc.twpc_mc_code,
            twpc.twpc_ps_code,
            twpc.twpc_date,
            GROUP_CONCAT(twpc.twpc_time SEPARATOR ', ') AS twpc_time_text
           
        FROM " . $this->hr_db . ".hr_person AS ps
        LEFT JOIN " . $this->hr_db . ".hr_person_detail AS psd ON psd.psd_ps_id = ps.ps_id
        LEFT JOIN " . $this->hr_db . ".hr_base_prefix AS pf ON ps.ps_pf_id = pf.pf_id
        LEFT JOIN " . $this->hr_db . ".hr_person_position AS pos ON pos.pos_ps_id = ps.ps_id
        LEFT JOIN " . $this->hr_db . ".hr_base_hire AS hire ON pos.pos_hire_id = hire.hire_id
        LEFT JOIN " . $this->hr_db . ".hr_timework_person_record AS twpc ON twpc.twpc_ps_code = pos.pos_ps_code
		LEFT JOIN " . $this->hr_db . ".hr_timework_matching_code as mc ON mc.mc_ps_id = ps.ps_id
        WHERE 
            pos.pos_dp_id = {$dp_id} 
			AND pos.pos_active = 'Y'
            AND twpc.twpc_date >= '{$start_date}'
            AND twpc.twpc_date <= '{$end_date}'
			{$cond}
			
        GROUP BY twpc.twpc_date, ps.ps_id
        ORDER BY ps.ps_id, twpc.twpc_date";

		$query = $this->hr->query($sql);
		// echo $this->hr->last_query();
		return $query;
	}
    // get_all_profile_data_by_param

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
            twpc.twpc_id,
            twpc.twpc_mc_code,
            twpc.twpc_ps_code,
            twpc.twpc_date,
            GROUP_CONCAT(twpc.twpc_time SEPARATOR ', ') AS twpc_time_text
           
        FROM " . $this->hr_db . ".hr_person AS ps
        LEFT JOIN " . $this->hr_db . ".hr_person_detail AS psd ON psd.psd_ps_id = ps.ps_id
        LEFT JOIN " . $this->hr_db . ".hr_base_prefix AS pf ON ps.ps_pf_id = pf.pf_id
        LEFT JOIN " . $this->hr_db . ".hr_person_position AS pos ON pos.pos_ps_id = ps.ps_id
        LEFT JOIN " . $this->hr_db . ".hr_base_hire AS hire ON pos.pos_hire_id = hire.hire_id
        LEFT JOIN " . $this->hr_db . ".hr_timework_person_record AS twpc ON twpc.twpc_ps_code = pos.pos_ps_code
		LEFT JOIN " . $this->hr_db . ".hr_timework_matching_code as mc ON mc.mc_ps_id = ps.ps_id
        WHERE 
            pos.pos_ps_id = {$ps_id} 
            AND twpc.twpc_date >= '{$start_date}'
            AND twpc.twpc_date <= '{$end_date}'
            
        GROUP BY twpc.twpc_date, ps.ps_id
        ORDER BY ps.ps_id, twpc.twpc_date";

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
                WHERE mc_code = {$mc_code} AND pos_ps_code LIKE '%{$ps_pos_code}%'";
		$query = $this->hr->query($sql);
		return $query;
	}
    // get_person_matching_code

} // end class M_hr_timework_person_record
?>
