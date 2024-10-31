<?php
/*
 * hr_leave_approve_person
 * Model for Manage about hr_leave_approve_person Table.
 * @Author Tanadon Tangjaimongkhon
 * @Create Date 26/10/2024
 */
include_once("Da_hr_leave_approve_person.php");

class M_hr_leave_approve_person extends Da_hr_leave_approve_person
{

	/*
	* get_leaves_approve_person_all
	* ข้อมูลกลุ่มเส้นทางการอนุมัติ
	* @input $lapg_type, $lapg_parent_id, $lapg_stuc_id, $lapg_active
	* @output leave approve group all data
	* @author Tanadon Tangjaimongkhon
	* @Create Date 26/10/2567
	*/
	function get_leaves_approve_person_all($dp_id, $hire_is_medical, $hire_type, $status_id)
	{
		$cond = "";
		
		if ($status_id != "all") {
			$cond .= " AND pos.pos_status = {$status_id}";
		}

		if($hire_type != "all"){
			$cond .= " AND hire.hire_type = {$hire_type}";
		}

		if($hire_is_medical != "all"){
			$cond .= " AND hire.hire_is_medical = '{$hire_is_medical}'";
		}
		
		
		$sql = "
        SELECT 

            pf.pf_name,
            ps.ps_fname,
            ps.ps_lname,
			laps.laps_lapg_id,
			CONCAT(
				IF(lapg.lapg_type = 'stuc', '<b>โครงสร้างองค์กร</b> : ', 
					IF(lapg.lapg_type = 'hire', '<b>สายปฏิบัติงาน</b> : ', 
						IF(lapg.lapg_type = 'ps', '<b>เฉพาะบุคคล</b> : ', '')
					)
				), 
				lapg.lapg_name
			) AS lapg_display_name,

			GROUP_CONCAT(
				DISTINCT CONCAT(
					lage.lage_seq, '. ', 
					lage_pf.pf_name,lage_person.ps_fname, ' ', lage_person.ps_lname, ' (',last.last_name,')', '<br>'
				) 
				ORDER BY lage.lage_seq
				SEPARATOR ''
			) AS group_detail 
           
        FROM " . $this->hr_db . ".hr_person AS ps
        LEFT JOIN " . $this->hr_db . ".hr_base_prefix AS pf ON ps.ps_pf_id = pf.pf_id
        LEFT JOIN " . $this->hr_db . ".hr_person_position AS pos ON pos.pos_ps_id = ps.ps_id
        LEFT JOIN " . $this->hr_db . ".hr_base_hire AS hire ON pos.pos_hire_id = hire.hire_id
		LEFT JOIN " . $this->hr_db . ".hr_leave_approve_person AS laps ON laps.laps_ps_id = ps.ps_id
		LEFT JOIN " . $this->hr_db . ".hr_leave_approve_group AS lapg ON lapg.lapg_id = laps.laps_lapg_id
		LEFT JOIN " . $this->hr_db . ".hr_leave_approve_group_detail AS lage ON lapg.lapg_id = lage.lage_lapg_id
		LEFT JOIN " . $this->hr_db . ".hr_person AS lage_person ON lage.lage_ps_id = lage_person.ps_id 
		LEFT JOIN " . $this->hr_db . ".hr_base_prefix AS lage_pf ON lage_pf.pf_id = lage_person.ps_pf_id 
		LEFT JOIN " . $this->hr_db . ".hr_base_leave_approve_status AS last ON last.last_id = lage.lage_last_id
        WHERE 
            pos.pos_dp_id = {$dp_id} 
			AND pos.pos_status = 1
			AND pos.pos_active = 'Y'
           
			{$cond}
			
        GROUP BY ps.ps_id";

		$query = $this->hr->query($sql);
		// echo $this->hr->last_query();
		return $query;
	}
	// get_leaves_approve_person_all

	/*
	* get_leaves_approve_group_by_ps_id
	* ข้อมูลกลุ่มเส้นทางการอนุมัติ
	* @input $lapg_type, $lapg_parent_id, $lapg_stuc_id, $lapg_active
	* @output leave approve group all data
	* @author Tanadon Tangjaimongkhon
	* @Create Date 26/10/2567
	*/
	function get_leaves_approve_group_by_ps_id($lapg_id)
	{
		$sql = "
            SELECT 
                lapg_id,
                lapg_name,
                lapg_type,
                lapg_active,
                lapg_desc
            
            FROM " . $this->hr_db . ".hr_leave_approve_group 
			LEFT JOIN " . $this->hr_db . ".hr_leave_approve_group_detail
				ON lapg_id = lage_lapg_id
            WHERE 
                lapg_id = {$lapg_id}";

		$query = $this->hr->query($sql);
		// echo $this->hr->last_query();
		return $query;
	}
	// get_leaves_approve_group_by_ps_id

	/*
	* get_leaves_approve_person_for_select_approve_group
	* ข้อมูลรายชือบุคลากร ที่ไม่เคยได้รับการกำหนดกลุมอนุมัติการลา
	* @input 
	* @output leave approve person
	* @author Tanadon Tangjaimongkhon
	* @Create Date 28/10/2567
	*/
	function get_leaves_approve_person_for_select_approve_group($action="") {
		$conditions = [];
		$params = [];
	
		// Add filter from session if medical_string exists
		$medical_string = $this->session->userdata('hr_hire_is_medical_string');
		if (!empty($medical_string)) {
			// Remove outer quotes and split the string into an array
			$medical_array = explode(',', str_replace(["'", " "], '', $medical_string)); // Remove quotes and spaces
	
			// Construct the FIND_IN_SET clause with the cleaned values
			if (!empty($medical_array)) {
				$conditions[] = "(" . implode(" OR ", array_map(function($value) {
					return "FIND_IN_SET('$value', hire.hire_is_medical)";
				}, $medical_array)) . ")";
			}
		}
	
		$conditions[] = "pos.pos_status = 1";
		$conditions[] = "pos.pos_active = 'Y'";

		if($action == ""){
			$conditions[] = "lapg.lapg_parent_id IS NULL";  // To get personnel without a leave approval group
		}

		

		
		// Prepare the final WHERE clause
		$where_clause = !empty($conditions) ? "WHERE " . implode(" AND ", $conditions) : "";
		
		$sql = "
			SELECT 
				ps.ps_id,
                pf.pf_name,
                ps.ps_fname,
                ps.ps_lname,
                pos.pos_status,
                hire.hire_name,
                alp.alp_name,
                CONCAT('<ul>',
                    GROUP_CONCAT(
                        DISTINCT CONCAT('<li>', ad.admin_name, '</li>')
                        SEPARATOR ''
                    ),
                    '</ul>'
                ) AS admin_position, 
                CASE 
                    WHEN hire.hire_is_medical = 'M' THEN 'สายการแพทย์'
                    WHEN hire.hire_is_medical = 'N' THEN 'สายพยาบาล'
                    WHEN hire.hire_is_medical = 'SM' THEN 'สายสนับสนุนทางการแพทย์'
                    WHEN hire.hire_is_medical = 'T' THEN 'สายเทคนิคและบริการ'
                    WHEN hire.hire_is_medical = 'A' THEN 'สายบริหาร'
                    ELSE '(ไม่ระบุ)'
                END AS hire_is_medical_label,
				lapg.lapg_parent_id
			FROM " . $this->hr_db . ".hr_person AS ps
			LEFT JOIN " . $this->hr_db . ".hr_base_prefix AS pf ON ps.ps_pf_id = pf.pf_id
			LEFT JOIN " . $this->hr_db . ".hr_person_position AS pos ON pos.pos_ps_id = ps.ps_id
			LEFT JOIN " . $this->hr_db . ".hr_base_hire AS hire ON pos.pos_hire_id = hire.hire_id
            LEFT JOIN " . $this->hr_db . ".hr_person_admin_position AS pap ON pos.pos_admin_id = pap.psap_pos_id
            LEFT JOIN " . $this->hr_db . ".hr_base_adline_position AS alp ON pos.pos_alp_id = alp.alp_id
            LEFT JOIN " . $this->hr_db . ".hr_base_admin_position AS ad ON pap.psap_admin_id = ad.admin_id
			LEFT JOIN " . $this->hr_db . ".hr_leave_approve_group AS lapg ON lapg.lapg_parent_id = ps.ps_id AND lapg.lapg_type = 'ps'
			{$where_clause}
			GROUP BY ps.ps_id";
	
		$query = $this->hr->query($sql);
		// echo $this->hr->last_query();
		return $query;
	}	
	// get_leaves_approve_person_for_select_approve_group

	/*
	* get_leaves_approve_person_by_lapg_id
	* ข้อมูลกลุ่มเส้นทางการอนุมัติ
	* @input $lapg_type, $lapg_parent_id, $lapg_stuc_id, $lapg_active
	* @output leave approve group all data
	* @author Tanadon Tangjaimongkhon
	* @Create Date 26/10/2567
	*/
	function get_leaves_approve_person_by_lapg_id($lapg_id)
	{
		$sql = "
            SELECT 
                ps.ps_id,
                pf.pf_name,
                ps.ps_fname,
                ps.ps_lname,
                pos.pos_status,
                hire.hire_name,
                alp.alp_name,
                CONCAT('<ul>',
                    GROUP_CONCAT(
                        DISTINCT CONCAT('<li>', ad.admin_name, '</li>')
                        SEPARATOR ''
                    ),
                    '</ul>'
                ) AS admin_position, 
                CASE 
                    WHEN hire.hire_is_medical = 'M' THEN 'สายการแพทย์'
                    WHEN hire.hire_is_medical = 'N' THEN 'สายพยาบาล'
                    WHEN hire.hire_is_medical = 'SM' THEN 'สายสนับสนุนทางการแพทย์'
                    WHEN hire.hire_is_medical = 'T' THEN 'สายเทคนิคและบริการ'
                    WHEN hire.hire_is_medical = 'A' THEN 'สายบริหาร'
                    ELSE '(ไม่ระบุ)'
                END AS hire_is_medical_label,
				lapg.lapg_id
            
            FROM " . $this->hr_db . ".hr_leave_approve_person AS laps
			LEFT JOIN " . $this->hr_db . ".hr_leave_approve_group AS lapg ON lapg.lapg_id = laps.laps_lapg_id
			LEFT JOIN " . $this->hr_db . ".hr_person AS ps ON laps.laps_ps_id = ps.ps_id
			LEFT JOIN " . $this->hr_db . ".hr_base_prefix AS pf ON ps.ps_pf_id = pf.pf_id
			LEFT JOIN " . $this->hr_db . ".hr_person_position AS pos ON pos.pos_ps_id = ps.ps_id
			LEFT JOIN " . $this->hr_db . ".hr_base_hire AS hire ON pos.pos_hire_id = hire.hire_id
            LEFT JOIN " . $this->hr_db . ".hr_person_admin_position AS pap ON pos.pos_admin_id = pap.psap_pos_id
            LEFT JOIN " . $this->hr_db . ".hr_base_adline_position AS alp ON pos.pos_alp_id = alp.alp_id
            LEFT JOIN " . $this->hr_db . ".hr_base_admin_position AS ad ON pap.psap_admin_id = ad.admin_id

            WHERE 
                lapg.lapg_id = {$lapg_id}
				AND pos.pos_status = 1
				AND pos.pos_active = 'Y'
			GROUP BY laps.laps_id";

		$query = $this->hr->query($sql);
		// echo $this->hr->last_query();
		return $query;
	}
	// get_leaves_approve_person_by_lapg_id


} // end class hr_leave_approve_person
