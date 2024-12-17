<?php
/*
* M_hr_timework_person_plan
* Model for Manage about hr_timework_person_plan Table.
* @Author Tanadon Tangjaimongkhon
* @Create Date 23/08/2024
*/
include_once("Da_hr_timework_person_plan.php");

class M_hr_timework_person_plan extends Da_hr_timework_person_plan {

	/*
	* get_all_profile_data
	* ข้อมูลบุคลากรทั้งหมด
	* @input -
	* @output person all
	* @author Tanadon Tangjaimongkhon
	* @Create Date 2567-05-21
	*/
	function get_all_profile_data($dp_id, $admin_id, $hire_id, $status_id, $pos_active = 'Y')
	{
		$cond = "";

		if ($admin_id == 'none') {
			$cond .= " AND pos.pos_admin_id IS NULL";
		} elseif ($admin_id != "all") {
			// หาค่า psap_pos_id ที่ตรงกับ admin_id ที่ส่งมา

			$cond .= " AND pos.pos_admin_id IN (
            SELECT pap.psap_pos_id
            FROM " . $this->hr_db . ".hr_person_admin_position AS pap
            WHERE pap.psap_admin_id = " . $this->hr->escape($admin_id) . "
           )";
		}

		if ($hire_id == 'none') {
			$cond .= " AND pos.pos_hire_id IS NULL";
		} elseif ($hire_id != "all") {
			$cond .= " AND hire.hire_id = " . $this->hr->escape($hire_id);
		}

		if ($status_id != "all") {
			$cond .= " AND pos.pos_status = " . $this->hr->escape($status_id);
		}

		$hr_is_medical = "";
		if ($this->session->userdata('hr_hire_is_medical')) {
			$hr_hire = $this->session->userdata('hr_hire_is_medical');
			$hr_is_medical = " AND (";
			foreach ($hr_hire as $key => $value) {
				if ($key > 0) {
					$hr_is_medical .= " OR ";
				}
				$hr_is_medical .= "hire.hire_is_medical = " . $this->hr->escape($value['type']);
			}
			$hr_is_medical .= ')';
		}

		$sql = "
        SELECT 
            ps.ps_id,
            pf.pf_name,
            ps.ps_fname,
            ps.ps_lname,
            psd.psd_picture,
            pos.pos_status,
            hire.hire_name,
            alp.alp_name,
            dp.dp_name_th,
            JSON_ARRAYAGG(DISTINCT JSON_OBJECT('admin_name', ad.admin_name)) AS admin_position,
            CASE 
                WHEN hire.hire_is_medical = 'M' THEN 'สายการแพทย์'
                WHEN hire.hire_is_medical = 'N' THEN 'สายการพยาบาล'
                WHEN hire.hire_is_medical = 'SM' THEN 'สายสนับสนุนทางการแพทย์'
                WHEN hire.hire_is_medical = 'T' THEN 'สายเทคนิคและบริการ'
                WHEN hire.hire_is_medical = 'A' THEN 'สายบริหาร'
                ELSE '(ไม่ระบุ)'
            END AS hire_is_medical_label,
            stde.stde_name_th,
            CONCAT(
                stde.stde_name_th, 
                CASE 
                    WHEN stdp.stdp_po_id = 1 THEN 'หัวหน้าฝ่าย'
                    WHEN stdp.stdp_po_id = 2 THEN 'รองหัวหน้าฝ่าย'
                    WHEN stdp.stdp_po_id = 3 THEN 'หัวหน้าแผนก'
                    WHEN stdp.stdp_po_id = 4 THEN 'รองหัวหน้าแผนก'
                    WHEN stdp.stdp_po_id = 5 THEN ''
                    ELSE ''
                END
            ) AS stde_name_position
        FROM " . $this->hr_db . ".hr_person AS ps
        LEFT JOIN " . $this->hr_db . ".hr_person_detail AS psd ON psd.psd_ps_id = ps.ps_id
        LEFT JOIN " . $this->hr_db . ".hr_base_prefix AS pf ON ps.ps_pf_id = pf.pf_id
        LEFT JOIN " . $this->hr_db . ".hr_person_position AS pos ON pos.pos_ps_id = ps.ps_id
        LEFT JOIN " . $this->hr_db . ".hr_base_hire AS hire ON pos.pos_hire_id = hire.hire_id
        LEFT JOIN " . $this->hr_db . ".hr_person_admin_position AS pap ON pos.pos_admin_id = pap.psap_pos_id
        LEFT JOIN " . $this->hr_db . ".hr_base_adline_position AS alp ON pos.pos_alp_id = alp.alp_id
        LEFT JOIN " . $this->hr_db . ".hr_base_admin_position AS ad ON pap.psap_admin_id = ad.admin_id
        LEFT JOIN " . $this->ums_db . ".ums_department AS dp ON dp.dp_id = pos.pos_dp_id
        
        LEFT JOIN ".$this->hr_db.".hr_structure_person stdp ON stdp.stdp_ps_id = ps.ps_id
        LEFT JOIN ".$this->hr_db.".hr_structure_detail stde ON stdp.stdp_stde_id = stde.stde_id
        LEFT JOIN ".$this->hr_db.".hr_structure stuc ON stuc.stuc_id = stde.stde_stuc_id
        WHERE 
            pos.pos_dp_id = " . $this->hr->escape($dp_id) . " 
            {$hr_is_medical} 
            {$cond} 
            AND pos.pos_active = " . $this->hr->escape($pos_active) . "
            AND stdp.stdp_active = 1
            AND stuc.stuc_status = 1
        GROUP BY ps.ps_id
        ORDER BY pos.pos_status ASC";

		$query = $this->hr->query($sql);
		return $query;
	}
    // get_all_profile_data

    /*
	* get_all_profile_data_by_stucture
	* ข้อมูลบุคลากรทั้งหมดตามโครงสร้างองค์กร
	* @input -
	* @output person all
	* @author Tanadon Tangjaimongkhon
	* @Create Date 2567-05-21
	*/
	function get_all_profile_data_by_stucture($dp_id, $stde_id, $hr_is_medical, $status_id, $pos_active = 'Y')
	{
		$cond = "";

		if ($status_id != "all") {
			$cond .= " AND pos.pos_status = " . $this->hr->escape($status_id);
		}
		
		$sql = "
        SELECT 
            ps.ps_id,
            pf.pf_name,
            ps.ps_fname,
            ps.ps_lname
           
        FROM " . $this->hr_db . ".hr_person AS ps
        LEFT JOIN " . $this->hr_db . ".hr_person_detail AS psd ON psd.psd_ps_id = ps.ps_id
        LEFT JOIN " . $this->hr_db . ".hr_base_prefix AS pf ON ps.ps_pf_id = pf.pf_id
        LEFT JOIN " . $this->hr_db . ".hr_person_position AS pos ON pos.pos_ps_id = ps.ps_id
        LEFT JOIN " . $this->hr_db . ".hr_base_hire AS hire ON pos.pos_hire_id = hire.hire_id
        LEFT JOIN " . $this->ums_db . ".ums_department AS dp ON dp.dp_id = pos.pos_dp_id
        LEFT JOIN ".$this->hr_db.".hr_structure_person stdp ON stdp.stdp_ps_id = ps.ps_id
        LEFT JOIN ".$this->hr_db.".hr_structure_detail stde ON stdp.stdp_stde_id = stde.stde_id
        LEFT JOIN ".$this->hr_db.".hr_structure stuc ON stuc.stuc_id = stde.stde_stuc_id
        WHERE 
            pos.pos_dp_id = " . $this->hr->escape($dp_id) . " 
            AND hire.hire_is_medical = '{$hr_is_medical}'
            AND pos.pos_active = '{$pos_active}'
            AND stdp.stdp_active = 1
            AND stuc.stuc_status = 1
            AND stde.stde_id = {$stde_id}
            {$cond} 
        GROUP BY ps.ps_id
        ORDER BY pos.pos_status ASC";

		$query = $this->hr->query($sql);
		return $query;
	}
    // get_all_profile_data_by_stucture

	/*
	* get_all_profile_data_by_param
	* ข้อมูลบุคลากรทั้งหมดตามพารามิเตอร์
	* @input -
	* @output person all
	* @author Tanadon Tangjaimongkhon
	* @Create Date 2567-05-21
	*/
	function get_all_profile_data_by_param($dp_id, $stde_id, $hire_is_medical, $hire_type, $status_id=1)
	{
		$cond = "";
		if($stde_id != 0){
			$cond = "AND stde.stde_id = {$stde_id}
			 		 AND stdp.stdp_active = 1
            		 AND stuc.stuc_status = 1";
		}
		
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
            ps.ps_id,
            pf.pf_name,
            ps.ps_fname,
            ps.ps_lname,
			hire.hire_is_medical
           
        FROM " . $this->hr_db . ".hr_person AS ps
        LEFT JOIN " . $this->hr_db . ".hr_person_detail AS psd ON psd.psd_ps_id = ps.ps_id
        LEFT JOIN " . $this->hr_db . ".hr_base_prefix AS pf ON ps.ps_pf_id = pf.pf_id
        LEFT JOIN " . $this->hr_db . ".hr_person_position AS pos ON pos.pos_ps_id = ps.ps_id
        LEFT JOIN " . $this->hr_db . ".hr_base_hire AS hire ON pos.pos_hire_id = hire.hire_id
        LEFT JOIN " . $this->ums_db . ".ums_department AS dp ON dp.dp_id = pos.pos_dp_id
        LEFT JOIN ".$this->hr_db.".hr_structure_person stdp ON stdp.stdp_ps_id = ps.ps_id
        LEFT JOIN ".$this->hr_db.".hr_structure_detail stde ON stdp.stdp_stde_id = stde.stde_id
        LEFT JOIN ".$this->hr_db.".hr_structure stuc ON stuc.stuc_id = stde.stde_stuc_id
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
    // get_all_profile_data_by_param


    /*
	* get_eqs_building_data
	* ข้อมูลสิ่งก่อสร้าง/อาคาร
	* @input -
	* @output eqs building data
	* @author Tanadon Tangjaimongkhon
	* @Create Date 2567-09-16
	*/
	function get_eqs_building_data($dp_id)
	{
		$sql = "SELECT 	
						bd_id, 
						bd_name
				FROM " . $this->eqs_db . ".eqs_building
				WHERE bd_id = {$dp_id}
				ORDER BY bd_id ASC";
		$query = $this->hr->query($sql);
		return $query;
	}
	// get_eqs_building_data

    /*
	* eqs_room
	* ข้อมูลห้อง
	* @input -
	* @output eqs room data
	* @author Tanadon Tangjaimongkhon
	* @Create Date 2567-09-16
	*/
	function get_eqs_room_data($bd_id)
	{
		$sql = "SELECT 	
						rm_id, 
						rm_name,
                        rm_bdtype_id
				FROM " . $this->eqs_db . ".eqs_room
                WHERE rm_bd_id = {$bd_id}
				ORDER BY rm_name ASC";
		$query = $this->hr->query($sql);
		return $query;
	}
	// get_eqs_room_data

    /*
	* get_eqs_building_type_data
	* ข้อมูลประเภทการใช้สอย
	* @input -
	* @output eqs building type data
	* @author Tanadon Tangjaimongkhon
	* @Create Date 2567-09-16
	*/
	function get_eqs_building_type_data()
	{
		$sql = "SELECT 	
						bdtype_id, 
						bdtype_name
				FROM " . $this->eqs_db . ".eqs_building_type
				ORDER BY bdtype_name ASC";
		$query = $this->hr->query($sql);
		return $query;
	}
	// get_eqs_building_type_data

      /*
	* get_all_timework_data_by_person_id
	* ข้อมูลการตารางวันทำงานรายบุคคล
	* @input ps_id
	* @output timework data by_person
	* @author Tanadon Tangjaimongkhon
	* @Create Date 2567-09-20
	*/
	function get_all_timework_data_by_person_id($ps_id, $dp_id, $status, $public, $timework_date_open, $actor_type)
	{
		$cond = "";
		if ($public != "all") {
			$cond = " AND twpp_is_public = {$public}";
		}

		if($actor_type == "head_structure"){
			$cond .= " AND twpp_status IN ('{$status}', 'A')";
		}
		else{
			$cond .= " AND twpp_status IN ('{$status}' , 'S')";
		}

		// หา start_date (วันที่เริ่มต้นของเดือน)
		$start_date = date("Y-m-01", strtotime($timework_date_open));

		// หา end_date (วันที่สิ้นสุดของเดือน)
		$end_date = date("Y-m-t", strtotime($timework_date_open));

		// หา start_date ย้อนหลัง 1 เดือน
		$start_before_date = date("Y-m-01", strtotime("-1 month", strtotime($timework_date_open)));

		// หา end_date ย้อนหลัง 1 เดือน
		$end_before_date = date("Y-m-t", strtotime("-1 month", strtotime($timework_date_open)));

		// SQL Query
		$sql = "
			SELECT *
			FROM " . $this->hr_db . ".hr_timework_person_plan
			LEFT JOIN " . $this->hr_db . ".hr_timework_attendance_config ON twac_id = twpp_twac_id
			LEFT JOIN " . $this->eqs_db . ".eqs_room ON rm_id = twpp_rm_id
			LEFT JOIN " . $this->eqs_db . ".eqs_building ON rm_bd_id = bd_id
			WHERE twpp_ps_id = {$ps_id}
			AND twpp_start_date >= '{$start_date}'
			AND twpp_end_date <= '{$end_date}'
			AND twpp_dp_id = {$dp_id}
			AND twpp_is_public = {$public}
			{$cond}
			
			UNION
			
			SELECT *
			FROM " . $this->hr_db . ".hr_timework_person_plan
			LEFT JOIN " . $this->hr_db . ".hr_timework_attendance_config ON twac_id = twpp_twac_id
			LEFT JOIN " . $this->eqs_db . ".eqs_room ON rm_id = twpp_rm_id
			LEFT JOIN " . $this->eqs_db . ".eqs_building ON rm_bd_id = bd_id
			WHERE twpp_ps_id = {$ps_id}
			AND twpp_status IN ('{$status}' , 'S')
			AND twpp_start_date >= '{$start_before_date}'
			AND twpp_end_date <= '{$end_before_date}'
			AND twpp_dp_id = {$dp_id}
			AND twpp_is_public = {$public}
			{$cond}
			
			ORDER BY twpp_start_date ASC";

		// Execute the query and return the result
		$query = $this->hr->query($sql);
		// echo $this->hr->last_query();
		return $query;
	}
	// get_all_timework_data_by_person_id


	/*
	* get_all_timework_param_data_by_person_id
	* ข้อมูลการตารางวันทำงานรายบุคคล
	* @input ps_id
	* @output timework data by_person
	* @author Tanadon Tangjaimongkhon
	* @Create Date 2567-09-20
	*/
	function get_all_timework_param_data_by_person_id($ps_id, $public, $dp_id, $filter_start_date, $filter_end_date, $ps_array="")
	{
		$cond_ps = "";
		if($ps_id != "all"){
			$cond_ps = "AND twpp_ps_id = {$ps_id}";
		}
		else{
			$cond_ps = "AND twpp_ps_id IN ($ps_array)";
		}
		
		$sql = "SELECT 	*
				FROM " . $this->hr_db . ".hr_timework_person_plan
                LEFT JOIN " . $this->hr_db . ".hr_timework_attendance_config
                    ON twac_id = twpp_twac_id
                LEFT JOIN " . $this->eqs_db . ".eqs_room
                    ON rm_id = twpp_rm_id
                LEFT JOIN " . $this->eqs_db . ".eqs_building
                    ON rm_bd_id = bd_id
				LEFT JOIN " . $this->hr_db . ".hr_person
					ON ps_id = twpp_ps_id
				LEFT JOIN " . $this->hr_db . ".hr_base_prefix 
					ON ps_pf_id = pf_id
                WHERE 	
						twpp_start_date >= '{$filter_start_date}'
						AND twpp_end_date <= '{$filter_end_date}'
						AND twpp_is_public = {$public}
						AND twpp_dp_id = {$dp_id}
						{$cond_ps}
				ORDER BY twpp_start_time ASC, twpp_start_date ASC";
		$query = $this->hr->query($sql);
		return $query;
	}
	// get_all_timework_param_data_by_person_id

	/*
	* update_status
	* อัพเดทสถานะข้อมูลการทำงาน
	* @input twpp_id
	* @output 
	* @author Tanadon Tangjaimongkhon
	* @Create Date 2567-10-09
	*/
	function update_status() {
		$sql = "UPDATE ".$this->hr_db.".hr_timework_person_plan
				SET twpp_status=?, twpp_update_user=?, twpp_update_date=?
				WHERE twpp_id=?";
		$this->hr->query($sql, array($this->twpp_status, $this->twpp_update_user, $this->twpp_update_date, $this->twpp_id));
	}
	// update_status

	/*
	* get_all_timework_preview_report_list
	* ข้อมูลการตารางวันทำงานรายการรายงานภาพรวม
	* @input ps_id
	* @output timework data by_person
	* @author Tanadon Tangjaimongkhon
	* @Create Date 2567-10-10
	*/
	function get_all_timework_preview_report_list($ps_id, $public, $dp_id, $filter_start_date, $filter_end_date)
	{
		$cond_dp = "";	

		if($dp_id != "all"){
			$cond_dp = "AND twpp_dp_id = {$dp_id}";
		}
		
		
		$sql = "SELECT 	pf_name, 
						ps_fname,
						ps_lname,
						twpp_ps_id,
						twpp_dp_id,
						twpp_start_date,
						twpp_end_date,
						twpp_start_time,
						twpp_end_time,
						rm_name,
						twpp_desc,
						twpp_is_public,
						twpp_status,
						twpp_is_holiday


				FROM " . $this->hr_db . ".hr_timework_person_plan
                LEFT JOIN " . $this->hr_db . ".hr_timework_attendance_config
                    ON twac_id = twpp_twac_id
                LEFT JOIN " . $this->eqs_db . ".eqs_room
                    ON rm_id = twpp_rm_id
                LEFT JOIN " . $this->eqs_db . ".eqs_building
                    ON rm_bd_id = bd_id
				LEFT JOIN " . $this->hr_db . ".hr_person
					ON ps_id = twpp_ps_id
				LEFT JOIN " . $this->hr_db . ".hr_base_prefix 
					ON ps_pf_id = pf_id
                WHERE 	
						twpp_start_date >= '{$filter_start_date}'
						AND twpp_end_date <= '{$filter_end_date}'
						AND twpp_is_public = {$public}
						AND twpp_ps_id = {$ps_id}
						AND twpp_dp_id = {$dp_id}
						#AND twpp_status = 'S'
						{$cond_dp}
				ORDER BY twpp_start_time ASC, twpp_start_date ASC";
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
		usort($expanded_results, function($a, $b) {
			if ($a->twpp_display_date === $b->twpp_display_date) {
				// ถ้าวันเหมือนกัน ให้เรียงตามเวลาเริ่มต้น
				return strcmp($a->twpp_start_time, $b->twpp_start_time);
			}
			// เรียงตามวันที่
			return strcmp($a->twpp_display_date, $b->twpp_display_date);
		});
	
		return $expanded_results;
	}
	// get_all_timework_preview_report_list

	/*
	* update_status_to_approver
	* อัพเดทสถานะข้อมูลการทำงานตามเดือน
	* @input month
	* @output 
	* @author Tanadon Tangjaimongkhon
	* @Create Date 2567-10-16
	*/
	function update_status_to_approver($month) {
		// Use the provided month for the update
		$year = date("Y"); // Get the current year or specify a different one
	
		// Create a date string for the first day of the given month
		$timework_date_open = $year . "-" . str_pad($month, 2, "0", STR_PAD_LEFT) . "-01";
	
		// Find the start date (first day of the month)
		$start_date = date("Y-m-01", strtotime($timework_date_open));
	
		// Find the end date (last day of the month)
		$end_date = date("Y-m-t", strtotime($timework_date_open));
	
		// SQL query to update the status of work data where the start and end date match the month
		$sql = "UPDATE ".$this->hr_db.".hr_timework_person_plan
				SET twpp_status='A'
				WHERE twpp_status='W' 
				AND twpp_start_date >= '{$start_date}' 
				AND twpp_end_date <= '{$end_date}'";
	
		// Execute the query
		$this->hr->query($sql);
	}
	// update_status_to_approver

	function get_all_timework_param_data_by_stde_id($stde_id, $public, $actor_type, $dp_id, $filter_start_date, $filter_end_date, $group_by)
	{
		
		$cond = "";

		if($actor_type == "medical"){
			$cond = " AND stde_is_medical = 'Y'";
		}
		else{
			$cond = " AND stde_is_medical != 'Y'";
		}

		$group_text = "";

		if($group_by == "format"){
			$group_text = "GROUP BY twpp_twac_id";
		}
		
		$sql = "SELECT 	*
				FROM " . $this->hr_db . ".hr_timework_person_plan
                LEFT JOIN " . $this->hr_db . ".hr_timework_attendance_config
                    ON twac_id = twpp_twac_id
                LEFT JOIN " . $this->eqs_db . ".eqs_room
                    ON rm_id = twpp_rm_id
                LEFT JOIN " . $this->eqs_db . ".eqs_building
                    ON rm_bd_id = bd_id
				LEFT JOIN " . $this->hr_db . ".hr_person
					ON ps_id = twpp_ps_id
				LEFT JOIN " . $this->hr_db . ".hr_base_prefix 
					ON ps_pf_id = pf_id
				LEFT JOIN " . $this->hr_db . ".hr_structure_person
					ON stdp_ps_id = ps_id
				LEFT JOIN " . $this->hr_db . ".hr_structure_detail
					ON stdp_stde_id = stde_id
                WHERE 	
						twpp_start_date >= '{$filter_start_date}'
						AND twpp_end_date <= '{$filter_end_date}'
						AND twpp_is_public = {$public}
						AND twpp_is_holiday = 0
						AND twpp_dp_id = {$dp_id}
						AND stde_id = {$stde_id}
						{$cond}
				{$group_text}
				ORDER BY twpp_start_time ASC, twpp_start_date ASC";
		$query = $this->hr->query($sql);
		// echo $this->hr->last_query();
		return $query;
	}

	function get_structure_detail_by_actor_type($actor_type){
		$cond = "";

		// if($actor_type == "medical"){
		// 	$cond = " AND stde_is_medical = 'Y'";
		// }
		// else{
		// 	$cond = " AND stde_is_medical != 'Y'";
		// }
		$sql = "SELECT 	*
				
				FROM " . $this->hr_db . ".hr_structure_detail

                WHERE 	
						stde_active = 1
						{$cond}
				ORDER BY stde_level ASC";
		$query = $this->hr->query($sql);
		return $query;
	}

	function get_structure_detail_by_group_person($stuc_id){

		$stuc_cond = "";
		if($stuc_id != "all"){
			$stuc_cond = " AND stde_stuc_id = {$stuc_id}";
		}

		$hr_is_medical = "";
		if ($this->session->userdata('hr_hire_is_medical')) {
			$hr_hire = $this->session->userdata('hr_hire_is_medical');
			$hr_is_medical = " AND (";
			foreach ($hr_hire as $key => $value) {
				if ($key > 0) {
					$hr_is_medical .= " OR ";
				}
				$hr_is_medical .= "hire_is_medical = " . $this->hr->escape($value['type']);
			}
			$hr_is_medical .= ')';
		}

		$sql = "SELECT 	stde_id,
						stde_name_th
				
				FROM " . $this->hr_db . ".hr_structure_detail
				LEFT JOIN " . $this->hr_db . ".hr_structure_person
					ON stdp_stde_id = stde_id
				LEFT JOIN " . $this->hr_db . ".hr_person
					ON ps_id = stdp_ps_id
				LEFT JOIN " . $this->hr_db . ".hr_person_position 
					ON pos_ps_id = ps_id
				LEFT JOIN " . $this->hr_db . ".hr_base_hire 
					ON pos_hire_id = hire_id

                WHERE 	
						stde_active = 1
						AND	stdp_active = 1 
						AND stde_level >= 3
						{$hr_is_medical}
						{$stuc_cond}
				GROUP BY stde_id
				ORDER BY stde_level ASC";
		$query = $this->hr->query($sql);
		return $query;
	}

		/*
	* get_all_timework_preview_report_list
	* ข้อมูลการตารางวันทำงานรายการรายงานภาพรวม
	* @input ps_id
	* @output timework data by_person
	* @author Tanadon Tangjaimongkhon
	* @Create Date 2567-10-10
	*/
	function get_all_timework_date_by_twac_id($twac_id, $public, $actor_type, $dp_id, $filter_start_date, $filter_end_date)
	{

		if($actor_type == "medical"){
			$hr_is_medical = " AND hire_is_medical = 'M'";
		}
		else{
			$hr_is_medical = "";
			if ($this->session->userdata('hr_hire_is_medical')) {
				$hr_hire = $this->session->userdata('hr_hire_is_medical');
				$hr_is_medical = " AND (";
				foreach ($hr_hire as $key => $value) {
					if ($key > 0) {
						$hr_is_medical .= " OR ";
					}
					$hr_is_medical .= "hire_is_medical = " . $this->hr->escape($value['type']);
				}
				$hr_is_medical .= ')';
			}
		}

		$sql = "SELECT 	pf_name_abbr, 
						ps_fname,
						ps_lname,
						twpp_ps_id,
						twpp_dp_id,
						twpp_start_date,
						twpp_end_date,
						twpp_start_time,
						twpp_end_time,
						rm_name,
						twpp_desc,
						twpp_is_public,
						twpp_status


				FROM " . $this->hr_db . ".hr_timework_person_plan
                LEFT JOIN " . $this->hr_db . ".hr_timework_attendance_config
                    ON twac_id = twpp_twac_id
                LEFT JOIN " . $this->eqs_db . ".eqs_room
                    ON rm_id = twpp_rm_id
                LEFT JOIN " . $this->eqs_db . ".eqs_building
                    ON rm_bd_id = bd_id
				LEFT JOIN " . $this->hr_db . ".hr_person
					ON ps_id = twpp_ps_id
				LEFT JOIN " . $this->hr_db . ".hr_base_prefix 
					ON ps_pf_id = pf_id
				LEFT JOIN " . $this->hr_db . ".hr_person_position 
					ON pos_ps_id = ps_id
				LEFT JOIN " . $this->hr_db . ".hr_base_hire 
					ON pos_hire_id = hire_id
                WHERE 	
						twpp_start_date >= '{$filter_start_date}'
						AND twpp_end_date <= '{$filter_end_date}'
						AND twpp_is_public = {$public}
						AND twpp_dp_id = {$dp_id}
						AND twpp_status = 'S'
						AND twac_id = {$twac_id}
						$hr_is_medical
				ORDER BY twpp_start_time ASC, twpp_start_date ASC";
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
		usort($expanded_results, function($a, $b) {
			if ($a->twpp_display_date === $b->twpp_display_date) {
				// ถ้าวันเหมือนกัน ให้เรียงตามเวลาเริ่มต้น
				return strcmp($a->twpp_start_time, $b->twpp_start_time);
			}
			// เรียงตามวันที่
			return strcmp($a->twpp_display_date, $b->twpp_display_date);
		});
	
		return $expanded_results;
	}
	// get_all_timework_preview_report_list


	
} // end class M_hr_timework_person_plan
?>
