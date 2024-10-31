<?php
/*
 * M_hr_person
 * Model for Manage about hr_person Table.
 * @Author Tanadon Tangjaimongkhon
 * @Create Date 17/05/2024
 */
include_once("Da_hr_matching_code.php");

class M_hr_matching_code extends Da_hr_matching_code
{
	function get_person_matching_code()
	{
		$sql = "SELECT mc_code FROM " . $this->hr_db . ".hr_timework_matching_code WHERE mc_ps_id = ? AND mc_dp_id = ?";
		$query = $this->hr->query($sql, array($this->mc_ps_id, $this->mc_dp_id));
		return $query;
	}
	function get_matching_code()
	{
		$sql = "SELECT mc_code FROM " . $this->hr_db . ".hr_timework_matching_code WHERE mc_code = ?";
		$query = $this->hr->query($sql, array($this->mc_code));
		return $query;
	}

	/*
	* get_all_profile_data_by_param
	* ข้อมูลบุคลากรทั้งหมดตามพารามิเตอร์
	* @input -
	* @output person all
	* @author Tanadon Tangjaimongkhon
	* @Create Date 2567-05-21
	*/
	function get_all_profile_data_by_param($dp_id, $hire_is_medical, $hire_type, $mc_status)
	{
		$cond = "";
		
		if ($mc_status == "all") {

		}
		else if($mc_status == "1") {
			$cond .= " AND mc_code IS NOT NULL";
		}
		else {
			$cond .= " AND mc_code IS NULL";
		}

		if($hire_type != "all"){
			$cond .= " AND hire.hire_type = {$hire_type}";
		}

		if($hire_is_medical != "all"){
			$cond .= " AND hire.hire_is_medical = '{$hire_is_medical}'";
		}
		
		
		$sql = "
        SELECT 
           *
           
        FROM " . $this->hr_db . ".hr_person AS ps
        LEFT JOIN " . $this->hr_db . ".hr_person_detail AS psd ON psd.psd_ps_id = ps.ps_id
        LEFT JOIN " . $this->hr_db . ".hr_base_prefix AS pf ON ps.ps_pf_id = pf.pf_id
        LEFT JOIN " . $this->hr_db . ".hr_person_position AS pos ON pos.pos_ps_id = ps.ps_id
        LEFT JOIN " . $this->hr_db . ".hr_base_hire AS hire ON pos.pos_hire_id = hire.hire_id
		LEFT JOIN ".$this->hr_db.".hr_timework_matching_code as mc
			ON mc.mc_ps_id = ps.ps_id
        WHERE 
            pos.pos_dp_id = {$dp_id} 
			AND pos.pos_active = 'Y'
            
           
			{$cond}
			
        GROUP BY ps.ps_id";

		$query = $this->hr->query($sql);
		// echo $this->hr->last_query();
		return $query;
	}
    // get_all_profile_data_by_param
	// function get_order_person_data_by_type($type)
	// {
	// 	$sql = "SELECT * FROM " . $this->hr_db . ".hr_order_data WHERE ord_ordt_id = '$type'";
	// 	$query = $this->hr->query($sql);
	// 	return $query;
	// }
} // end class M_hr_person
