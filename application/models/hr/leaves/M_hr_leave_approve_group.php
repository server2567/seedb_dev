<?php
/*
 * hr_leave_approve_group
 * Model for Manage about hr_leave_approve_group Table.
 * @Author Tanadon Tangjaimongkhon
 * @Create Date 26/10/2024
 */
include_once("Da_hr_leave_approve_group.php");

class M_hr_leave_approve_group extends Da_hr_leave_approve_group
{

	/*
	* get_leaves_approve_group_all_by_stuc
	* ข้อมูลกลุ่มเส้นทางการอนุมัติ
	* @input $lapg_type, $lapg_parent_id, $lapg_stuc_id, $lapg_active
	* @output leave approve group all data
	* @author Tanadon Tangjaimongkhon
	* @Create Date 26/10/2567
	*/
	function get_leaves_approve_group_all_by_stuc($lapg_type, $lapg_parent_id, $lapg_stuc_id, $lapg_active)
	{
		$cond = "";
		
		
		if($lapg_active != "all"){
			$cond .= " AND lapg_active = '{$lapg_active}'"; 
		}
		

		$sql = "
            SELECT 
                lapg_id,
                lapg_name,
                lapg_type,
                stde_name_th AS lapg_parent_name,
                lapg_active,
                lapg_desc
            
            FROM " . $this->hr_db . ".hr_leave_approve_group 
            LEFT JOIN " . $this->hr_db . ".hr_structure_detail
                ON lapg_parent_id = stde_id
            WHERE 
                stde_stuc_id = {$lapg_stuc_id}
				AND lapg_type = 'stuc'
                {$cond}
            GROUP BY lapg_id
                
            ORDER BY stde_level DESC";

		$query = $this->hr->query($sql);
		// echo $this->hr->last_query();
		return $query;
	}
	// get_leaves_approve_group_all_by_stuc

    /*
	* get_leaves_approve_group_all_by_hire
	* ข้อมูลกลุ่มเส้นทางการอนุมัติ
	* @input $lapg_type, $lapg_parent_id, $lapg_stuc_id, $lapg_active
	* @output leave approve group all data
	* @author Tanadon Tangjaimongkhon
	* @Create Date 26/10/2567
	*/
	function get_leaves_approve_group_all_by_hire($lapg_type, $lapg_parent_id, $lapg_stuc_id, $lapg_active)
	{
		$cond = "";
		
		
		if($lapg_active != "all"){
			$cond .= " AND lapg_active = '{$lapg_active}'"; 
		}
		
		$sql = "
            SELECT 
                lapg_id,
                lapg_name,
                lapg_type,
                CASE 
					WHEN lapg_parent_id = 'M' THEN 'สายแพทย์' 
					WHEN lapg_parent_id = 'N' THEN 'สายการพยาบาล'
					WHEN lapg_parent_id = 'A' THEN 'สายบริหาร'
					WHEN lapg_parent_id = 'SM' THEN 'สายสนับสนุนทางการแพทย์'
					ELSE 'สายเทคนิคและบริการ'
				END AS lapg_parent_name,
                lapg_active,
                lapg_desc
            
            FROM " . $this->hr_db . ".hr_leave_approve_group 
            WHERE
                lapg_parent_id = '{$lapg_parent_id}'
				AND lapg_type = 'hire'
                {$cond}
                
            ORDER BY 
				CASE lapg_parent_id
					WHEN 'M' THEN 1
					WHEN 'N' THEN 2
					WHEN 'SM' THEN 3
					WHEN 'A' THEN 4
					WHEN 'T' THEN 5
					ELSE 6
				END;";

		$query = $this->hr->query($sql);
		// echo $this->hr->last_query();
		return $query;
	}
	// get_leaves_approve_group_all_by_hire

        /*
	* get_leaves_approve_group_all_by_ps
	* ข้อมูลกลุ่มเส้นทางการอนุมัติ
	* @input $lapg_type, $lapg_parent_id, $lapg_stuc_id, $lapg_active
	* @output leave approve group all data
	* @author Tanadon Tangjaimongkhon
	* @Create Date 26/10/2567
	*/
	function get_leaves_approve_group_all_by_ps($lapg_type, $lapg_parent_id, $lapg_stuc_id, $lapg_active)
	{
		$cond = "";
		
		
		if($lapg_active != "all"){
			$cond .= "AND lapg_active = '{$lapg_active}'"; 
		}
		
		$sql = "
            SELECT 
                lapg_id,
                lapg_name,
                CONCAT(pf_name_abbr,ps_fname,' ',ps_lname) AS lapg_parent_name,
                lapg_active,
                lapg_desc
            
            FROM " . $this->hr_db . ".hr_leave_approve_group 
            LEFT JOIN " . $this->hr_db . ".hr_person ON lapg_parent_id = ps_id
            LEFT JOIN " . $this->hr_db . ".hr_base_prefix ON ps_pf_id = pf_id
			WHERE lapg_type = 'ps'
            {$cond}
                
            ORDER BY ps_fname ASC";

		$query = $this->hr->query($sql);
		// echo $this->hr->last_query();
		return $query;
	}
	// get_leaves_approve_group_all_by_ps

		/*
	* get_leaves_approve_group_id_by_stuc
	* ข้อมูลกลุ่มเส้นทางการอนุมัติ ตาม lapg_id
	* @input $lapg_id
	* @output leave approve group id data
	* @author Tanadon Tangjaimongkhon
	* @Create Date 26/10/2567
	*/
	function get_leaves_approve_group_id_by_stuc($lapg_id)
	{
	
		$sql = "
            SELECT 
                lapg_id,
                lapg_name,
                lapg_type,
                stde_name_th AS lapg_parent_name,
                lapg_active,
				lapg_stuc_id,
				lapg_parent_id,
                lapg_desc
            
            FROM " . $this->hr_db . ".hr_leave_approve_group 
            LEFT JOIN " . $this->hr_db . ".hr_structure_detail
                ON lapg_parent_id = stde_id
            WHERE 
                lapg_id = {$lapg_id}
				AND lapg_type = 'stuc'

            GROUP BY lapg_id";

		$query = $this->hr->query($sql);
		// echo $this->hr->last_query();
		return $query;
	}
	// get_leaves_approve_group_id_by_stuc

    /*
	* get_leaves_approve_group_id_by_hire
	* ข้อมูลกลุ่มเส้นทางการอนุมัติ ตาม lapg_id
	* @input $lapg_id
	* @output leave approve group id data
	* @author Tanadon Tangjaimongkhon
	* @Create Date 26/10/2567
	*/
	function get_leaves_approve_group_id_by_hire($lapg_id)
	{
		$sql = "
            SELECT 
                lapg_id,
                lapg_name,
                lapg_type,
				lapg_parent_id,
                CASE 
					WHEN lapg_parent_id = 'M' THEN 'สายแพทย์' 
					WHEN lapg_parent_id = 'N' THEN 'สายการพยาบาล'
					WHEN lapg_parent_id = 'A' THEN 'สายบริหาร'
					WHEN lapg_parent_id = 'SM' THEN 'สายสนับสนุนทางการแพทย์'
					ELSE 'สายเทคนิคและบริการ'
				END AS lapg_parent_name,
                lapg_active,
                lapg_desc
            
            FROM " . $this->hr_db . ".hr_leave_approve_group 
            WHERE
                lapg_id = '{$lapg_id}'
				AND lapg_type = 'hire'
                
           	GROUP BY lapg_id";

		$query = $this->hr->query($sql);
		// echo $this->hr->last_query();
		return $query;
	}
	// get_leaves_approve_group_id_by_hire

    /*
	* get_leaves_approve_group_id_by_ps
	* ข้อมูลกลุ่มเส้นทางการอนุมัติ ตาม lapg_id
	* @input $lapg_id
	* @output leave approve group id data
	* @author Tanadon Tangjaimongkhon
	* @Create Date 26/10/2567
	*/
	function get_leaves_approve_group_id_by_ps($lapg_id)
	{
		
		$sql = "
            SELECT 
                lapg_id,
                lapg_name,
				lapg_type,
				lapg_parent_id,
                CONCAT(pf_name_abbr,ps_fname,' ',ps_lname) AS lapg_parent_name,
                lapg_active,
                lapg_desc
            
            FROM " . $this->hr_db . ".hr_leave_approve_group 
            LEFT JOIN " . $this->hr_db . ".hr_person ON lapg_parent_id = ps_id
            LEFT JOIN " . $this->hr_db . ".hr_base_prefix ON ps_pf_id = pf_id
			WHERE lapg_id = '{$lapg_id}'
				  AND lapg_type = 'ps'
                
            GROUP BY lapg_id";

		$query = $this->hr->query($sql);
		// echo $this->hr->last_query();
		return $query;
	}
	// get_leaves_approve_group_id_by_ps

} // end class hr_leave_approve_group
