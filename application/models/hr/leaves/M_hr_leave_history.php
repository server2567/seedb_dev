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


		if ($status != "all" && $status != "number") {
			$cond .= " AND lhis_status = '{$status}'";
		} else if ($status == "number") {
			$cond .= " AND lhis_status NOT IN ('C', 'Y', 'N')";
		}

		$sql = "
        SELECT 
           *
           
        FROM " . $this->hr_db . ".hr_leave_history 
		LEFT JOIN " . $this->hr_db . ".hr_leave
			ON lhis_leave_id = leave_id
		LEFT JOIN " . $this->hr_db . ".hr_leave_approve_flow
			ON lafw_lhis_id = lhis_id 
        
        WHERE 
            lhis_ps_id = {$ps_id} 
			AND lhis_start_date >= '{$start_date}'
			AND lhis_end_date <= '{$end_date}'
			{$cond}
		GROUP BY lhis_id
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
	function get_leave_type_by_person($ps_id, $leave_id = "", $year = null)
	{
		if ($year === null) {
			$year = date("Y");
		}
		$cond = "";
		if ($leave_id != "") {
			$cond .= " AND lsum_leave_id = {$leave_id}";
		}
		$sql = "
			SELECT *,
				(
					SELECT lhis_id
					FROM " . $this->hr_db . ".hr_leave_history
					WHERE lhis_leave_id = lsum_leave_id AND lhis_status NOT IN ('Y','N','C') AND lhis_ps_id = {$ps_id}
				) as lhis_id
			FROM " . $this->hr_db . ".hr_leave_summary 
			LEFT JOIN " . $this->hr_db . ".hr_leave
				ON lsum_leave_id = leave_id
			
			WHERE 
				lsum_ps_id = {$ps_id} 
				AND lsum_year = {$year}
				$cond
				
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
	function get_person_replace_list()
	{
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
	function check_leaves_approve_group_by_ps_id($ps_id)
	{
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
	function check_leaves_approve_group_detail_by_lapg_id($lapg_id)
	{
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

	/*
	* get_all_timework_data_by_date
	* ข้อมูลการตารางวันทำงานรายบุคคลตามช่วงวันที่
	* @input $ps_id, $start_date, $end_date
	* @output timework data by_person
	* @author Tanadon Tangjaimongkhon
	* @Create Date 2567-10-31
	*/
	function get_all_timework_data_by_date($ps_id, $start_date, $end_date)
	{
		$sql = "SELECT 
						twpp_id,
						twpp_twac_id,
						twac_id,
						twac_name_th,
						twpp_start_date,
						twpp_end_date,
						twpp_start_time,
						twpp_end_time,
						twpp_is_public,
						twpp_is_holiday,
						twac_is_break,
						twac_is_ot,
						twpp_ps_id,
						twpp_status
        FROM " . $this->hr_db . ".hr_timework_person_plan
		LEFT JOIN " . $this->hr_db . ".hr_timework_attendance_config
			ON twpp_twac_id = twac_id
        WHERE 
            	(
					(twpp_start_date BETWEEN '{$start_date}' AND '{$end_date}') OR
					(twpp_end_date BETWEEN '{$start_date}' AND '{$end_date}') OR
					(twpp_start_date <= '{$start_date}' AND twpp_end_date >= '{$end_date}')
				)
				AND twpp_is_public = 0
				AND twpp_ps_id = {$ps_id}
				AND twpp_status = 'S'
			ORDER BY twpp_start_date ASC";
		$query = $this->hr->query($sql);
		$results = $query->result(); // ใช้ result() แทน result_array()

		$expanded_results = [];
		foreach ($results as $row) {
			// Convert string dates to DateTime for iteration
			$start_date = new DateTime($row->twpp_start_date);
			$end_date = new DateTime($row->twpp_end_date);

			// ลูปแสดงข้อมูลทุกๆวันในช่วงเวลา start_date ถึง end_date
			for ($date = clone $start_date; $date <= $end_date; $date->modify('+1 day')) {
				// สร้าง clone ของ object $row เพื่อไม่ให้เกิดการเปลี่ยนแปลงใน object ดั้งเดิม
				$expanded_row = clone $row;
				$expanded_row->twpp_display_date = $date->format('Y-m-d'); // กำหนดวันที่ในช่วงเวลา
				$expanded_row->twpp_start_time = $row->twpp_start_time; // เวลาเริ่มต้น
				$expanded_row->twpp_end_time = $row->twpp_end_time; // เวลาสิ้นสุด
				$expanded_results[] = $expanded_row; // เพิ่มข้อมูลที่แยกวันเข้าไปใน array
			}
		}

		// จัดเรียงข้อมูลตามวันที่และเวลาเริ่มต้น
		usort($expanded_results, function ($a, $b) {
			if ($a->twpp_display_date === $b->twpp_display_date) {
				// ถ้าวันเหมือนกัน ให้เรียงตามเวลาเริ่มต้น
				return strcmp($a->twpp_start_time, $b->twpp_start_time);
			}
			// เรียงตามวันที่
			return strcmp($a->twpp_display_date, $b->twpp_display_date);
		});

		return $expanded_results;
	}
	// get_all_timework_param_data_by_person_id

	/*
	* get_leave_history_by_lhis_id
	* ข้อมูลประวัติการลาตามไอดี
	* @input $ps_id, $start_date, $end_date
	* @output timework data by_person
	* @author Tanadon Tangjaimongkhon
	* @Create Date 2567-10-31
	*/
	function get_leave_history_by_lhis_id($lhis_id)
	{
		$sql = "SELECT *,
		 JSON_ARRAYAGG(DISTINCT JSON_OBJECT('stde_name_th', stde.stde_name_th)) AS stde_name_th
		FROM see_hrdb.hr_leave_history
		LEFT JOIN see_hrdb.hr_leave
			ON lhis_leave_id = leave_id
		LEFT JOIN see_hrdb.hr_person
			ON ps_id = lhis_ps_id
		LEFT JOIN (
			SELECT pos_ps_id, 
				MIN(pos_dp_id) AS min_pos_dp_id, 
				SUBSTRING_INDEX(GROUP_CONCAT(pos_alp_id ORDER BY pos_dp_id ASC), ',', 1) AS min_pos_alp_id
			FROM see_hrdb.hr_person_position
			GROUP BY pos_ps_id
		) AS min_position
			ON min_position.pos_ps_id = ps_id
		LEFT JOIN see_hrdb.hr_structure_person as stdp
		    ON stdp.stdp_ps_id = ps_id
		LEFT JOIN see_hrdb.hr_structure_detail as stde
		    ON stde.stde_id = stdp.stdp_stde_id
		INNER JOIN see_hrdb.hr_base_adline_position
			ON alp_id = min_position.min_pos_alp_id
		INNER JOIN see_hrdb.hr_person_detail
			ON psd_ps_id = ps_id
		LEFT JOIN see_hrdb.hr_base_prefix
			ON pf_id = ps_pf_id
		WHERE lhis_id = {$lhis_id}
		";

		$query = $this->hr->query($sql);
		return $query;
	}
	// get_leave_history_by_lhis_id

	/*
	* get_base_calendar_for_leave
	* ข้อมูลวันหยุดตามประเพณีตามปฏิทิน
	* @input $year_now, $ps_id, $start_date, $end_date
	* @output base calandar list
	* @author Tanadon Tangjaimongkhon
	* @Create Date 2567-11-20
	*/
	function get_base_calendar_for_leave($year_now, $ps_id, $start_date, $end_date)
	{

		$sql = "SELECT clnd_id, clnd_name, clnd_start_date, clnd_end_date, clnd_type_date, lct_name
			FROM " . $this->hr_db . ".hr_base_calendar
			LEFT JOIN " . $this->hr_db . ".hr_base_calendar_type ON clnd_type_date = lct_id
			WHERE clnd_id NOT IN (
				SELECT lhde_clnd_id
				FROM " . $this->hr_db . ".hr_leave_history_detail
				LEFT JOIN " . $this->hr_db . ".hr_leave_history ON lhde_lhis_id = lhis_id
				WHERE 
					lhis_ps_id = {$ps_id}
					AND lhis_leave_id = 2
					AND lhis_year = {$year_now}
			)
			AND clnd_type_date = 5
			AND clnd_year = {$year_now}
			AND clnd_end_date <= '{$end_date}'

			UNION

			SELECT clnd_id, clnd_name, clnd_start_date, clnd_end_date, clnd_type_date, lct_name
			FROM " . $this->hr_db . ".hr_base_calendar
			LEFT JOIN " . $this->hr_db . ".hr_base_calendar_type ON clnd_type_date = lct_id
			WHERE clnd_id NOT IN (
				SELECT lhde_clnd_id
				FROM " . $this->hr_db . ".hr_leave_history_detail
				LEFT JOIN " . $this->hr_db . ".hr_leave_history ON lhde_lhis_id = lhis_id
				WHERE 
					lhis_ps_id = {$ps_id}
					AND lhis_leave_id = 2
					AND lhis_year = " . ($year_now - 1) . "
			)
			AND clnd_type_date = 5
			AND clnd_year = " . ($year_now - 1) . "
			AND clnd_end_date <= '{$end_date}'
			AND clnd_pack = 'Y'
			
			ORDER BY clnd_start_date ASC

			";

		$query = $this->hr->query($sql);
		// echo  $this->hr->last_query();
		return $query;
	}
	// get_base_calendar_for_leave
    function get_leave_history_in_period($ps_id,$lhis_leave_id,$start_date,$lhis_year){
		// pre($start_date);
		$sql = "SELECT * FROM ".$this->hr_db.".hr_leave_history
		   WHERE lhis_end_date < '{$start_date}'AND lhis_ps_id = {$ps_id} AND lhis_leave_id = {$lhis_leave_id} AND lhis_year = {$lhis_year}
		   ORDER BY lhis_start_date DESC
		";
		$query = $this->hr->query($sql);
		// echo  $this->hr->last_query();
		// die;
		return $query;
	}
	function get_leave_history_bypass_detail($lhis_id){
      $sql = "SELECT 
				lhis_status,
				lhis_create_user,
				CONCAT(pf.pf_name, ' ', ps.ps_name, ' ', ps.ps_lname) AS ps_name,
				JSON_ARRAYAGG(
					DISTINCT JSON_OBJECT(
						'stde_name_th', 
						CONCAT(
							stde.stde_name_th, 
							CASE stdp.stdp_po_id
								WHEN 0 THEN ''
								WHEN 1 THEN ' หัวหน้าฝ่าย'
								WHEN 2 THEN ' รองหัวหน้าฝ่าย'
								WHEN 3 THEN ' หัวหน้าแผนก'
								WHEN 4 THEN ' รองหัวหน้าแผนก'
								WHEN 5 THEN ' เจ้าหน้าที่'
								WHEN 6 THEN ' หัวหน้าภาค'
								ELSE ''
							END
						)
					)
				) AS stde_name_th
			FROM 
				".$this->hr_db.".hr_leave_history
			INNER JOIN 
				".$this->ums_db.".ums_user AS us ON us.us_id = lhis_create_user
			INNER JOIN 
				".$this->hr_db.".hr_person AS ps ON ps.ps_id = us.us_ps_id
			INNER JOIN 
				".$this->hr_db.".hr_base_prefix AS pf ON pf.pf_name_abbr = ps.ps_prefix_abbr
			LEFT JOIN 
				".$this->hr_db.".hr_structure_person AS stdp ON stdp.stdp_ps_id = ps.ps_id
			LEFT JOIN 
				see_hrdb.hr_structure_detail AS stde ON stde.stde_id = stdp.stdp_stde_id
			WHERE 
				lhis_id = {$lhis_id}
			GROUP BY 
				lhis_status, lhis_create_user, pf.pf_name, ps.ps_name, ps.ps_lname;
			";
		$query = $this->hr->query($sql);
	}


} // end class M_hr_person
