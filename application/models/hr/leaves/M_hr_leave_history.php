<?php
/*
 * M_hr_person
 * Model for Manage about hr_person Table.
 * @Author Tanadon Tangjaimongkhon
 * @Create Date 17/05/2024
 */
include_once("Da_hr_leave_history.php");

class M_hr_leave_history extends Da_hr_leave_history
{

	/*
	* get_leave_all_by_ps_id
	* ข้อมูลประวัติการลาของบุคลากร
	* @input $ps_id, $leave_id, $status, $start_date, $end_date
	* @output leave all data
	* @author Tanadon Tangjaimongkhon
	* @Create Date 10/24/2567
	*/
	function get_leave_all_by_ps_id($ps_id, $leave_id, $status, $start_date, $end_date)
	{
		$cond = "";
		
		if ($leave_id != "all") {
			$cond .= " AND lhis_leave_id = {$leave_id}"; 
		}
		

		if($status != "all" && $status != "number"){
			$cond .= " AND lhis_status = '{$status}'"; 
		}
		else if($status == "number"){
			$cond .= " AND lhis_status NOT IN ('C', 'Y', 'N')"; 
		}

		$sql = "
        SELECT 
           *
           
        FROM " . $this->hr_db . ".hr_leave_history 
		LEFT JOIN " . $this->hr_db . ".hr_leave
			ON lhis_leave_id = leave_id
        
        WHERE 
            lhis_ps_id = {$ps_id} 
			AND lhis_start_date >= '{$start_date}'
			AND lhis_end_date <= '{$end_date}'
			{$cond}
			
        ORDER BY lhis_start_date DESC";

		$query = $this->hr->query($sql);
		// echo $this->hr->last_query();
		return $query;
	}
	// get_leave_all_by_ps_id

	/*
	* get_lastest_lhis_leave_id_by_ps_id
	* ข้อมูลประวัติการลาของบุคลากรล่าสุดตามประเภทการลา
	* @input $ps_id, $leave_id
	* @output leave lastest by lhis_leave_id data
	* @author Tanadon Tangjaimongkhon
	* @Create Date 10/24/2567
	*/
	function get_lastest_lhis_leave_id_by_ps_id($ps_id, $leave_id)
	{
		$sql = "
        SELECT *
           
        FROM " . $this->hr_db . ".hr_leave_history 
		LEFT JOIN " . $this->hr_db . ".hr_leave
			ON lhis_leave_id = leave_id
        
        WHERE 
            lhis_ps_id = {$ps_id} 
			AND lhis_leave_id = {$leave_id}
			
        ORDER BY lhis_start_date DESC
		LIMIT 1";

		$query = $this->hr->query($sql);
		// echo $this->hr->last_query();
		return $query;
	}
	// get_lastest_lhis_leave_id_by_ps_id


	/*
	* get_leave_type_by_person
	* ข้อมูลประเภทการลาชองบุคลากรรายคน ของปีปัจจุบัน
	* @input $ps_id
	* @output leave type all data
	* @author Tanadon Tangjaimongkhon
	* @Create Date 10/24/2567
	*/
	function get_leave_type_by_person($ps_id){

		$sql = "
			SELECT *,
				(
					SELECT lhis_id
					FROM " . $this->hr_db . ".hr_leave_history
					WHERE lhis_leave_id = lsum_leave_id AND lhis_status NOT IN ('Y','N','C')
				) as lhis_id
			FROM " . $this->hr_db . ".hr_leave_summary 
			LEFT JOIN " . $this->hr_db . ".hr_leave
				ON lsum_leave_id = leave_id
			
			WHERE 
				lsum_ps_id = {$ps_id} AND
				lsum_year = YEAR(CURRENT_DATE) 
				
			ORDER BY leave_id ASC";

		$query = $this->hr->query($sql);
		// echo $this->hr->last_query();
		return $query;
	}
	// get_leave_type_by_person

	/*
	* get_person_replace_list
	* รายชื่อบุคลากรที่ปฏิบัติงานอยู่ในปัจจุบัน
	* @input 
	* @output person list
	* @author Tanadon Tangjaimongkhon
	* @Create Date 30/10/2567
	*/
    function get_person_replace_list() {
        $sql = "
            SELECT  		
                ps.ps_id,
                pf.pf_name,
                ps.ps_fname,
                ps.ps_lname
            FROM " . $this->hr_db . ".hr_person AS ps
            LEFT JOIN " . $this->hr_db . ".hr_base_prefix AS pf ON ps.ps_pf_id = pf.pf_id
               
            WHERE ps.ps_status = 1
            GROUP BY ps.ps_id
            ORDER BY ps.ps_fname ASC
        ";
    
        $query = $this->hr->query($sql);
        // echo $this->hr->last_query();
        return $query;
    }
    // get_person_replace_list

	/*
	* check_leaves_approve_group_by_ps_id
	* ตรวจสอบเส้นทางอนุมัติการลาของบุคลากรรายบุคคล
	* @input ps_id
	* @output leave person list
	* @author Tanadon Tangjaimongkhon
	* @Create Date 30/10/2567
	*/
	function check_leaves_approve_group_by_ps_id($ps_id){
		$sql = "
		SELECT 
			*
			FROM " . $this->hr_db . ".hr_leave_approve_person
			WHERE laps_ps_id = {$ps_id}";

		$query = $this->hr->query($sql);
		// echo $this->hr->last_query();
		return $query;
	}
	// check_leaves_approve_group_by_ps_id

	/*
	* check_leaves_approve_group_detail_by_lapg_id
	* รายละเอียดเส้นทางอนุมัติการลา ตามไอดีกลุ่ม
	* @input lapg_id
	* @output leave approve group detail list
	* @author Tanadon Tangjaimongkhon
	* @Create Date 30/10/2567
	*/
	function check_leaves_approve_group_detail_by_lapg_id($lapg_id){
		$sql = "
		SELECT 
			*
			FROM " . $this->hr_db . ".hr_leave_approve_group_detail
			WHERE lage_lapg_id = {$lapg_id}
			
			GROUP BY lage_id
			ORDER BY lage_seq ASC";

		$query = $this->hr->query($sql);
		// echo $this->hr->last_query();
		return $query;
	}
	// check_leaves_approve_group_detail_by_lapg_id

} // end class M_hr_person
