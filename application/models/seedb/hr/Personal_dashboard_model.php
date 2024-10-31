<?php
/*
* personal_dashboard
* Model for Manage about Personal Dashboard
* @Author Tanadon Tangjaimongkhon
* @Create Date 07/01/2024
*/
include_once(dirname(__FILE__)."/../seedb_model.php");

class Personal_dashboard_model extends seedb_model {

	public $profile_url;

	function __construct() {
		parent::__construct();
		$this->profile_url = site_url($this->config->item('hr_dir') . 'profile/Profile_summary/get_profile_summary/');
	}

	/*
	* personal_base_query
	* query ตัวกลางสำหรับ personal_dashboard
	* @input $dp_id, $year_type, $year
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 01/07/2024
	*/
	function personal_base_query($dp_id, $year_type, $year) {
		// Initialize date filter
		$dateFilter = "";

		if($dp_id == 1){
			$order_id = 1;
		}
		else{
			$order_id = 4;
		}

		// if ($month != "all") {
		// 	// Assuming the day is 01 for simplicity
		// 	$startDate = date("Y-m-01", strtotime("$year-$month-01"));
		// 	$endDate = date("Y-m-t", strtotime("$year-$month-01")); // End of the month
		// } else {
		// 	// Assuming the entire year
		// 	$startDate = "$year-01-01";
		// 	$endDate = "$year-12-31";
		// }

		$startDate = "$year-01-01";
		$endDate = "$year-12-31";
	
		// Filter based on start_date and end_date using BETWEEN
		$dateFilter = "AND (
			(history.hipos_start_date <= '$endDate' AND (history.hipos_end_date >= '$startDate' OR history.hipos_end_date IS NULL OR history.hipos_end_date = '9999-12-31'))
		)";
	
		$subquery = "
			SELECT h1.*, 
			GROUP_CONCAT(DISTINCT hr_base_admin_position.admin_name SEPARATOR ', ') AS ps_admin_name,
			GROUP_CONCAT(DISTINCT hr_base_special_position.spcl_name SEPARATOR ', ') AS ps_spcl_name,
			hr_base_adline_position.alp_name AS ps_alp_name,
			hr_base_retire.retire_name as ps_retire_name,
			hr_base_hire.hire_name as ps_hire_name,
			hr_base_hire.*,
			hr_person_history.*,
			ord_seq


			FROM ".$this->hr_db.".hr_person_position_history AS h1
			
			LEFT JOIN ".$this->hr_db.".hr_person_admin_position 
				ON h1.hipos_pos_admin_id = hr_person_admin_position.psap_pos_id
			LEFT JOIN ".$this->hr_db.".hr_base_admin_position 
				ON hr_person_admin_position.psap_admin_id = hr_base_admin_position.admin_id

			LEFT JOIN ".$this->hr_db.".hr_person_special_position 
				ON h1.hipos_pos_spcl_id = hr_person_special_position.pssp_pos_id
			LEFT JOIN ".$this->hr_db.".hr_base_special_position 
				ON hr_person_special_position.pssp_spcl_id = hr_base_special_position.spcl_id

			LEFT JOIN ".$this->hr_db.".hr_base_adline_position 
				ON h1.hipos_pos_alp_id = hr_base_adline_position.alp_id

			LEFT JOIN ".$this->hr_db.".hr_base_retire 
				ON h1.hipos_pos_retire_id = hr_base_retire.retire_id

			LEFT JOIN ".$this->hr_db.".hr_base_hire 
				ON h1.hipos_pos_hire_id = hr_base_hire.hire_id

			LEFT JOIN (
				SELECT hph.hips_id, hph.hips_ps_id, pf.pf_name, hph.hips_ps_fname, hph.hips_ps_lname, hph.hips_start_date, hph.hips_end_date
				FROM ".$this->hr_db.".hr_person_history AS hph
				LEFT JOIN ".$this->hr_db.".hr_base_prefix as pf
					ON pf.pf_id = hph.hips_ps_pf_id
				 WHERE hph.hips_start_date <= '$endDate'
            			AND (hph.hips_end_date >= '$startDate' OR hph.hips_end_date IS NULL OR hph.hips_end_date = '9999-12-31')
						AND hph.hips_id = (
							SELECT MAX(hph2.hips_id)
							FROM ".$this->hr_db.".hr_person_history AS hph2
							WHERE 	hph2.hips_ps_id = hph.hips_ps_id
									AND hph2.hips_start_date <= '$endDate'
									AND (hph2.hips_end_date >= '$startDate' OR hph2.hips_end_date IS NULL OR hph2.hips_end_date = '9999-12-31')
						)
			) AS hr_person_history
				ON h1.hipos_ps_id = hr_person_history.hips_ps_id

			LEFT JOIN ".$this->hr_db.".hr_order_data
				ON ord_ps_id = hr_person_history.hips_ps_id
			LEFT JOIN ".$this->hr_db.".hr_order_data_type
				ON ord_ordt_id = ordt_id
			
			WHERE 	h1.hipos_id = (
						SELECT MAX(h2.hipos_id)
						FROM ".$this->hr_db.".hr_person_position_history AS h2
						WHERE h2.hipos_pos_id = h1.hipos_pos_id
								AND h2.hipos_start_date <= '$endDate' 
								AND (h2.hipos_end_date >= '$startDate' OR h2.hipos_end_date IS NULL OR h2.hipos_end_date = '9999-12-31')
					)
					AND h1.hipos_pos_dp_id = {$dp_id}
					AND ordt_dp_id = {$dp_id}
					AND ord_active = 1
					AND ord_ordt_id = {$order_id}
			GROUP BY h1.hipos_id
			ORDER BY ord_seq ASC
		";

		$base_sql = "
			FROM ".$this->hr_db.".hr_person
			LEFT JOIN ".$this->hr_db.".hr_person_position 
				ON hr_person.ps_id = hr_person_position.pos_ps_id
			LEFT JOIN ($subquery) AS history
				ON hr_person_position.pos_id = history.hipos_pos_id
			

			WHERE hr_person_position.pos_dp_id = {$dp_id}
				AND hr_person_position.pos_active = 'Y'
				
				$dateFilter
		";

	
		return $base_sql;
	}
	// personal_base_query
	
	/*
	* get_HRM_1_card
	* ดึงข้อมูลการ์ด SEE-HRM-C1 - C6
	* @input $dp_id, $year_type, $year
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 01/07/2024
	*/
	function get_HRM_1_card($dp_id, $year_type, $year) {
		$base_sql = $this->personal_base_query($dp_id, $year_type, $year);
	
		$sql_all = "
			SELECT 
				'all' AS card_type,
				'บุคลากรทั้งหมด' AS card_name,
				COUNT(*) AS card_count
			$base_sql
		";
	
		$sql_medical = "
			SELECT 
				'medical' AS card_type,
				'สายแพทย์เต็มเวลา / แพทย์บางเวลา' AS card_name,
				COUNT(*) AS card_count
			$base_sql
			
			AND EXISTS (
				SELECT 1
				FROM ".$this->hr_db.".hr_base_hire
				WHERE hr_base_hire.hire_id = history.hipos_pos_hire_id
				AND hr_base_hire.hire_is_medical = 'M'
			)
		";
	
		$sql_nurse = "
			SELECT 
				'nurse' AS card_type,
				'สายการพยาบาล' AS card_name,
				COUNT(*) AS card_count
			$base_sql
			
			AND EXISTS (
				SELECT 1
				FROM ".$this->hr_db.".hr_base_hire
				WHERE hr_base_hire.hire_id = history.hipos_pos_hire_id
				AND hr_base_hire.hire_is_medical = 'N'
			)
		";

		$sql_admin = "
			SELECT 
				'admin' AS card_type,
				'สายบริหาร' AS card_name,
				COUNT(*) AS card_count
			$base_sql
			
			AND EXISTS (
				SELECT 1
				FROM ".$this->hr_db.".hr_base_hire
				WHERE hr_base_hire.hire_id = history.hipos_pos_hire_id
				AND hr_base_hire.hire_is_medical = 'A'
			)
		";

		$sql_support_medical = "
			SELECT 
				'support_medical' AS card_type,
				'สายสนับสนุนทางการแพทย์' AS card_name,
				COUNT(*) AS card_count
			$base_sql
			
			AND EXISTS (
				SELECT 1
				FROM ".$this->hr_db.".hr_base_hire
				WHERE hr_base_hire.hire_id = history.hipos_pos_hire_id
				AND hr_base_hire.hire_is_medical = 'SM'
			)
		";

		$sql_technical = "
			SELECT 
				'technical' AS card_type,
				'สายเทคนิคและบริการ' AS card_name,
				COUNT(*) AS card_count
			$base_sql
			
			AND EXISTS (
				SELECT 1
				FROM ".$this->hr_db.".hr_base_hire
				WHERE hr_base_hire.hire_id = history.hipos_pos_hire_id
				AND hr_base_hire.hire_is_medical = 'T'
			)
		";
	
		$sql = "$sql_all UNION $sql_medical UNION $sql_nurse UNION $sql_admin UNION $sql_support_medical UNION $sql_technical";
	
		$query = $this->hr->query($sql);
		// echo $this->hr->last_query()."<br><br>"; // สำหรับการตรวจสอบ query ที่ถูกสร้างขึ้น
		return $query;
	}
	// get_HRM_1_card
	
	/*
	* get_HRM_1_card_person_detail
	* ดึงข้อมูลรายละเอียดการ์ด SEE-HRM-C1 - C6 
	* @input $dp_id, $year_type, $year
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 01/07/2024
	*/
	public function get_HRM_1_card_person_detail($dp_id, $year_type, $year, $card_type) {
		$base_sql = $this->personal_base_query($dp_id, $year_type, $year);

		// Start building the SQL query
		$sql = "
		SELECT 
			history.hipos_id,
			history.hipos_ps_id,
			CASE 
				WHEN history.ps_admin_name IS NOT NULL THEN 
					CONCAT(
						'<a href=\"', 
						'" . $this->profile_url . "','/',
						'PLACEHOLDER', 
						'\" target=\"_blank\">', 
						history.pf_name, 
						history.hips_ps_fname, ' ',
						history.hips_ps_lname, 
						'</a>',
						'<br><span style=\"font-size:12px; color:#7d7878;\">', 
						history.ps_admin_name, 
						'</span>'
					)
				ELSE 
					CONCAT(
						'<a href=\"', 
						'" . $this->profile_url . "','/',
						'PLACEHOLDER', 
						'\" target=\"_blank\">', 
						history.pf_name, 
						history.hips_ps_fname, ' ',
						history.hips_ps_lname, 
						'</a>'
					)
			END AS full_name,
			history.ps_hire_name,
			history.ps_admin_name,
			history.ps_spcl_name,
			history.ps_alp_name,
			history.ps_retire_name,
			history.hipos_pos_work_end_date AS ps_work_end_date,
			history.hire_type
		$base_sql
		";

		switch ($card_type) {
			case 'all':
				$sql .= " ";
				break;
			case 'medical':
				$sql .= " AND EXISTS (
					SELECT 1
					FROM ".$this->hr_db.".hr_base_hire
					WHERE hr_base_hire.hire_id = history.hipos_pos_hire_id
					AND hr_base_hire.hire_is_medical = 'M'
				)";
				break;
			case 'nurse':
				$sql .= " AND EXISTS (
					SELECT 1
					FROM ".$this->hr_db.".hr_base_hire
					WHERE hr_base_hire.hire_id = history.hipos_pos_hire_id
					AND hr_base_hire.hire_is_medical = 'N'
				)";

				break;

			case 'admin':
				$sql .= " AND EXISTS (
					SELECT 1
					FROM ".$this->hr_db.".hr_base_hire
					WHERE hr_base_hire.hire_id = history.hipos_pos_hire_id
					AND hr_base_hire.hire_is_medical = 'A'
				)";

				break;

			case 'support_medical':
				$sql .= " AND EXISTS (
					SELECT 1
					FROM ".$this->hr_db.".hr_base_hire
					WHERE hr_base_hire.hire_id = history.hipos_pos_hire_id
					AND hr_base_hire.hire_is_medical = 'SM'
				)";

				break;

			case 'technical':
				$sql .= " AND EXISTS (
					SELECT 1
					FROM ".$this->hr_db.".hr_base_hire
					WHERE hr_base_hire.hire_id = history.hipos_pos_hire_id
					AND hr_base_hire.hire_is_medical = 'T'
				)";

				break;
		}
		$sql .= "ORDER BY history.ord_seq ASC";
		$query = $this->hr->query($sql);
		// echo $this->hr->last_query();
		
		// Loop through the results to encrypt the ID and replace the placeholder
		foreach ($query->result() as $row) {
			$row->full_name = str_replace('PLACEHOLDER', encrypt_id($row->hipos_ps_id), $row->full_name);
		}
		return $query;
	}
	// get_HRM_1_card_person_detail

	/*
	* get_HRM_chart_1
	* ดึงข้อมูลกราฟ SEE-HRM-1
	* @input $dp_id, $year_type, $year
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 02/07/2024
	*/
	function get_HRM_chart_1($dp_id, $year_type, $year) {
		$base_sql = $this->personal_base_query($dp_id, $year_type, $year);
	
		$sql = "
			SELECT 
				CASE 
					WHEN hr_base_hire.hire_is_medical = 'M' THEN 'สายแพทย์' 
					WHEN hr_base_hire.hire_is_medical = 'N' THEN 'สายการพยาบาล'
					WHEN hr_base_hire.hire_is_medical = 'A' THEN 'สายบริหาร'
					WHEN hr_base_hire.hire_is_medical = 'SM' THEN 'สายสนับสนุนทางการแพทย์'
					ELSE 'สายเทคนิคและบริการ'
				END AS chart_name,
				hr_base_hire.hire_is_medical AS chart_type,
				COALESCE(COUNT(category_hire.hipos_pos_hire_id), 0) AS chart_count
			FROM ".$this->hr_db.".hr_base_hire
			LEFT JOIN (
				SELECT history.hipos_pos_hire_id
				$base_sql
			) AS category_hire
			ON hr_base_hire.hire_id = category_hire.hipos_pos_hire_id
			GROUP BY chart_name
			ORDER BY 
				CASE hr_base_hire.hire_is_medical
					WHEN 'M' THEN 1
					WHEN 'N' THEN 2
					WHEN 'SM' THEN 3
					WHEN 'A' THEN 4
					WHEN 'T' THEN 5
					ELSE 6
				END;

		";
	
		$query = $this->hr->query($sql);
		// echo $this->hr->last_query(); // สำหรับการตรวจสอบ query ที่ถูกสร้างขึ้น
		return $query;
	}
	// get_HRM_chart_1

	/*
	* get_HRM_chart_1_person_detail
	* ดึงข้อมูลรายละเอียดกราฟ SEE-HRM-1
	* @input $dp_id, $year_type, $year
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 02/07/2024
	*/
	function get_HRM_chart_1_person_detail($dp_id, $year_type, $year, $hire_is_medical) {
		$base_sql = $this->personal_base_query($dp_id, $year_type, $year);
	
		$sql = "
			SELECT 
				history.hipos_ps_id,
				CASE 
					WHEN history.ps_admin_name IS NOT NULL THEN 
						CONCAT(
							'<a href=\"', 
							'" . $this->profile_url . "','/', 
							history.hipos_ps_id,
							'\" target=\"_blank\">', 	
							history.pf_name, 
							history.hips_ps_fname, ' ',
							history.hips_ps_lname, 
							'</a>',
							'<br><span style=\"font-size:12px; color:#7d7878;\">', 
							history.ps_admin_name, 
							'</span>'
						)
					ELSE 
						CONCAT(
							'<a href=\"', 
							'" . $this->profile_url . "','/', 
							history.hipos_ps_id, 
							'\" target=\"_blank\">', 
							history.pf_name, 
							history.hips_ps_fname, ' ',
							history.hips_ps_lname, 
							'</a>'
						)
				END AS full_name,
				history.ps_hire_name,
				history.ps_admin_name,
				history.ps_spcl_name,
				history.ps_alp_name,
				history.ps_retire_name,
				history.hipos_pos_work_end_date AS ps_work_end_date,
				history.hire_type
			$base_sql

			AND history.hipos_pos_hire_id IN (
					SELECT h3.hire_id
					FROM ".$this->hr_db.".hr_base_hire AS h3
					WHERE h3.hire_is_medical = '{$hire_is_medical}'
				)
			ORDER BY history.ord_seq ASC
		";
	
		$query = $this->hr->query($sql);
		// echo $this->hr->last_query(); // สำหรับการตรวจสอบ query ที่ถูกสร้างขึ้น

		// Loop through the results to encrypt the ID and replace the placeholder
		foreach ($query->result() as $row) {
			$row->full_name = str_replace('PLACEHOLDER', encrypt_id($row->hipos_ps_id), $row->full_name);
		}

		return $query;
	}
	// get_HRM_chart_1_person_detail

	/*
	* get_hr_base_hire_group_data
	* ดึงข้อมูลประเภทบุคลากร GROUP BY
	* @input -
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 02/07/2024
	*/
	function get_hr_base_hire_group_data($hire_is_medical="")
	{
		$cond = "";

		// $hire_is_medical => ex. "Y,N"
		if($hire_is_medical != ""){
			$cond = "AND hire_is_medical IN ($hire_is_medical)";
		}
		
		$sql = "SELECT 	
						hire_id, 
						hire_name,
						hire_abbr,
						hire_type,
						hire_active,
						hire_is_medical,
						CASE 
							WHEN hire_is_medical = 'M' THEN 'สายแพทย์'
							WHEN hire_is_medical = 'N' THEN 'สายการพยาบาล'
							WHEN hire_is_medical = 'SM' THEN 'สายสนับสนุนทางการแพทย์'
							WHEN hire_is_medical = 'T' THEN 'สายเทคนิคและบริการ'
							WHEN hire_is_medical = 'A' THEN 'สายบริหาร'
							ELSE 'ไม่ระบุ'
						END AS hire_is_medical_label
				FROM ".$this->hr_db.".hr_base_hire
				WHERE hire_active = 1
						{$cond}
				GROUP BY hire_is_medical";
		$query = $this->hr->query($sql);
		// echo $this->hr->last_query(); // สำหรับการตรวจสอบ query ที่ถูกสร้างขึ้น
		return $query;
	}
	// get_hr_base_hire_group_data

	/*
	* get_structure_now_is_confirm
	* ดึงข้อมูลโครงสร้างองค์กรปัจจุบัน
	* @input dp_id
	* @output โครงสร้างองค์กรปัจจุบัน
	* @Create Date 08/07/2024
	*/
	function get_structure_now_is_confirm($dp_id, $year_type, $year)
	{
		// กำหนดช่วงวันที่สำหรับปีที่เลือก
		$startDate = "$year-01-01";
		$endDate = "$year-12-31";
	
		// SQL Query ที่รองรับทั้งการดูประวัติย้อนหลังและข้อมูลปัจจุบัน
		$sql = "
			SELECT 
				stuc_id,
				stuc_dp_id,
				stuc_status,
				stuc_confirm_date,
				stuc_end_date
			FROM ".$this->hr_db.".hr_structure
			WHERE 
				stuc_dp_id = $dp_id
				AND stuc_confirm_date <= '$endDate'
				AND (
					stuc_end_date >= '$startDate' 
					OR stuc_end_date IS NULL 
					OR stuc_end_date = '9999-12-31'
				)
			ORDER BY stuc_status DESC, stuc_confirm_date DESC
			LIMIT 1
		";
	
		// เรียกใช้งาน query
		$query = $this->hr->query($sql);
	
		// ส่งคืนผลลัพธ์ query
		return $query;
	}	
	// get_structure_now_is_confirm

	/*
	* get_structure_detail_by_stuc_id
	* ดึงข้อมูลรายละเอียดโครงสร้างองค์กรปัจจุบัน
	* @input stuc_id
	* @output รายละเอียดโครงสร้างองค์กรปัจจุบัน
	* @Create Date 08/07/2024
	*/
	function get_structure_detail_by_stuc_id($stuc_id, $stde_level, $stde_id="", $stde_is_medical="")
	{
		$cond_name = "";
		$cond_level = "";

		if($stde_level == ">2"){
			$cond_level = "AND stde_level > 2";
		}
		else{
			$cond_level = "AND stde_level = $stde_level";
			if($stde_level == 3){
				
				// $cond_name = "AND stde_name_th LIKE '%ฝ่าย%'";
			}
			else if($stde_level == 4){
				// $cond_name = "AND stde_name_th LIKE '%แผนก%'
				// 			  AND stde_parent = $stde_id";
				$cond_name = "AND stde_parent = $stde_id";
			}
			else{
				$cond_name = "";
			}
		}
		
	

		$cond_is_medical = "";
		if($stde_is_medical != ""){
			$cond_is_medical = "AND stde_is_medical = 'Y'";
		}
	
		// Construct the SQL query
		$sql = "
			SELECT 
				stde_id,
				stde_stuc_id,
				stde_name_th
			FROM ".$this->hr_db.".hr_structure_detail
			WHERE 
				stde_stuc_id = {$stuc_id}
				AND stde_active = 1
				{$cond_name}
				{$cond_is_medical}
				{$cond_level}
			ORDER BY 
            CASE 
                WHEN stde_is_medical = 'Y' THEN 0
				WHEN stde_is_medical = 'N' THEN 1
				WHEN stde_is_medical = 'SM' THEN 2
				WHEN stde_is_medical = 'A' THEN 3
				WHEN stde_is_medical = 'T' THEN 4
                ELSE 5
            END,
            stde_level ASC
		";
		
		// Execute the query
		$query = $this->hr->query($sql);
		return $query;
	}
	// get_structure_detail_by_stuc_id

		/*
	* get_structure_person_by_stde_id
	* ดึงข้อมูลรายละเอียดโครงสร้างองค์กรปัจจุบัน
	* @input stde_id
	* @output รายละเอียดโครงสร้างองค์กรปัจจุบัน
	* @Create Date 08/07/2024
	*/
	function get_structure_person_by_stde_id($dp_id, $year_type, $year, $stde_id, $hire_is_medical="")
	{
		// Define variables for the query
		$person_active = 1;

		// Construct the base SQL for the subquery
		$base_sql = $this->personal_base_query($dp_id, $year_type, $year);

		$cond = "";
		if($hire_is_medical != ""){
			$cond = "AND history.hipos_pos_hire_id IN (
					SELECT h3.hire_id
					FROM ".$this->hr_db.".hr_base_hire AS h3
					WHERE h3.hire_is_medical IN ({$hire_is_medical})
				)";
		}

		// Construct the SQL query for person details
		$sql = "
			SELECT 
				history.hipos_ps_id,
				CASE 
					WHEN history.ps_admin_name IS NOT NULL THEN 
						CONCAT(
							'<a href=\"', 
							'" . $this->profile_url . "','/', 
							history.hipos_ps_id,
							'\" target=\"_blank\">', 	
							history.pf_name, 
							history.hips_ps_fname, ' ',
							history.hips_ps_lname, 
							'</a>',
							'<br><span style=\"font-size:12px; color:#7d7878;\">', 
							history.ps_admin_name, 
							'</span>'
						)
					ELSE 
						CONCAT(
							'<a href=\"', 
							'" . $this->profile_url . "','/', 
							history.hipos_ps_id, 
							'\" target=\"_blank\">', 
							history.pf_name, 
							history.hips_ps_fname, ' ',
							history.hips_ps_lname, 
							'</a>'
						)
				END AS full_name,
				history.ps_hire_name,
				history.ps_admin_name,
				history.ps_spcl_name,
				history.ps_alp_name,
				history.ps_retire_name,
				history.hipos_pos_work_start_date,
				history.hipos_pos_work_end_date,
				history.hire_type,
				CASE 
					WHEN history.hire_type = 1 THEN 'เต็มเวลา (Full-Time)'
					ELSE 'บางเวลา (Part-Time)'
				END AS hire_type_label,
				history.hire_is_medical,
				CASE 
					WHEN history.hire_is_medical = 'M' THEN 'สายแพทย์'
					WHEN history.hire_is_medical = 'N' THEN 'สายการพยาบาล'
					WHEN history.hire_is_medical = 'SM' THEN 'สายสนับสนุนทางการแพทย์'
					WHEN history.hire_is_medical = 'T' THEN 'สายเทคนิคและบริการ'
					WHEN history.hire_is_medical = 'A' THEN 'สายบริหาร'
					ELSE 'ไม่ระบุ'
				END AS hire_is_medical_label,
				stde.stde_id,
				stde.stde_name_th,
				stpo.stpo_name AS stde_name_position,
				stdp.stdp_seq

			FROM ".$this->hr_db.".hr_structure_person stdp
			LEFT JOIN ".$this->hr_db.".hr_person ps ON stdp.stdp_ps_id = ps.ps_id
			LEFT JOIN ".$this->hr_db.".hr_structure_detail stde ON stdp.stdp_stde_id = stde.stde_id
			LEFT JOIN ".$this->hr_db.".hr_base_structure_position stpo ON stpo.stpo_id = stdp.stdp_po_id 
			LEFT JOIN (
				SELECT history.*
				$base_sql
			) AS history ON stdp.stdp_ps_id = history.hipos_ps_id
			WHERE stdp.stdp_stde_id = $stde_id
				AND stdp.stdp_active = $person_active
				AND history.hipos_ps_id IS NOT NULL
				$cond
			ORDER BY stdp.stdp_seq ASC
		";


		// Execute the query
		$query = $this->hr->query($sql);
		// echo  $this->hr->last_query()."<br><br><br><br>";

		// Loop through the results to encrypt the ID and replace the placeholder
		foreach ($query->result() as $row) {
			$row->full_name = str_replace('PLACEHOLDER', encrypt_id($row->hipos_ps_id), $row->full_name);
		}

		return $query;
	}
	// get_structure_person_by_stde_id

	/*
	* get_education_level
	* ดึงข้อมูลระดับการศึกษา
	* @input 
	* @output รายละเอียดโครงสร้างองค์กรปัจจุบัน
	* @Create Date 08/07/2024
	*/
	function get_education_level()
	{
		// Construct the SQL query for education levels
		$sql = "
			SELECT 
				edulv_id,
				CASE 
					WHEN edulv_id IN (1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 12, 14, 16, 24) THEN 'ต่ำกว่าปริญญาตรี'
					WHEN edulv_id = 11 THEN 'ปริญญาตรี'
					WHEN edulv_id = 13 THEN 'ปริญญาโท'
					WHEN edulv_id = 15 THEN 'ปริญญาเอก'
					WHEN edulv_id IN (16, 23) THEN 'เฉพาะทาง'
					ELSE edulv_name
				END as edulv_name
			FROM ".$this->hr_db.".hr_base_education_level
			WHERE edulv_id IN (1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 12, 14, 16, 23, 24, 11, 13, 15)
		";

		// Execute the query
		$query = $this->hr->query($sql);
		return $query;
	}
	// get_structure_person_by_stde_id

	/*
	* get_HRM_chart_5_person_detail
	* ดึงข้อมูลกราฟ SEE-HRM-5
	* @input $dp_id, $year_type, $year
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 02/07/2024
	*/
	function get_HRM_chart_5($dp_id, $year_type, $year, $hire_is_medical, $edulv_id) {
		$base_sql = $this->personal_base_query($dp_id, $year_type, $year);
		
		$sql = "
			SELECT 
				COUNT(DISTINCT history.hipos_ps_id) as count_data
			FROM ".$this->hr_db.".hr_person_education AS education
			LEFT JOIN ".$this->hr_db.".hr_base_education_level ON edulv_id = education.edu_edulv_id 
			LEFT JOIN (
				SELECT history.*
				$base_sql
				AND history.hipos_pos_hire_id IN (
					SELECT h3.hire_id
					FROM ".$this->hr_db.".hr_base_hire AS h3
					WHERE h3.hire_is_medical = '{$hire_is_medical}'
				)
			) AS history ON education.edu_ps_id = history.hipos_ps_id
			WHERE education.edu_edulv_id = {$edulv_id}
			AND education.edu_highest = 'Y'  -- นับเฉพาะวุฒิสูงสุด
		";
	
		$query = $this->hr->query($sql);
		$result = $query->row();
		return $result ? $result->count_data : 0;
	}
	// get_HRM_chart_5

		/*
	* get_HRM_chart_5_detail
	* ดึงข้อมูลรายละเอียดกราฟ SEE-HRM-5
	* @input $dp_id, $year_type, $year
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 02/07/2024
	*/
	function get_HRM_chart_5_detail($dp_id, $year_type, $year, $hire_is_medical, $edulv_id) {
		$base_sql = $this->personal_base_query($dp_id, $year_type, $year);
	
		$sql = "
			SELECT 
				history.hipos_ps_id,
				CASE 
					WHEN history.ps_admin_name IS NOT NULL THEN 
						CONCAT(
							'<a href=\"', 
							'" . $this->profile_url . "','/', 
							history.hipos_ps_id,
							'\" target=\"_blank\">', 	
							history.pf_name, 
							history.hips_ps_fname, ' ',
							history.hips_ps_lname, 
							'</a>',
							'<br><span style=\"font-size:12px; color:#7d7878;\">', 
							history.ps_admin_name, 
							'</span>'
						)
					ELSE 
						CONCAT(
							'<a href=\"', 
							'" . $this->profile_url . "','/', 
							history.hipos_ps_id, 
							'\" target=\"_blank\">', 
							history.pf_name, 
							history.hips_ps_fname, ' ',
							history.hips_ps_lname, 
							'</a>'
						)
				END AS full_name,
				history.ps_hire_name,
				history.ps_admin_name,
				history.ps_spcl_name,
				history.ps_alp_name,
				history.ps_retire_name,
				history.hipos_pos_work_start_date,
				history.hipos_pos_work_end_date,
				history.hire_type,
				CASE 
					WHEN history.hire_type = 1 THEN 'เต็มเวลา (Full-Time)'
					ELSE 'บางเวลา (Part-Time)'
				END AS hire_type_label,
				history.hire_is_medical,
				CASE 
					WHEN history.hire_is_medical = 'M' THEN 'สายแพทย์'
					WHEN history.hire_is_medical = 'N' THEN 'สายการพยาบาล'
					WHEN history.hire_is_medical = 'SM' THEN 'สายสนับสนุนทางการแพทย์'
					WHEN history.hire_is_medical = 'T' THEN 'สายเทคนิคและบริการ'
					WHEN history.hire_is_medical = 'A' THEN 'สายบริหาร'
					ELSE 'ไม่ระบุ'
				END AS hire_is_medical_label,
				edulv_name,
				edudg_name,
				edumj_name,
				place_name,
				country_name
			FROM ".$this->hr_db.".hr_person_education AS education
			LEFT JOIN ".$this->hr_db.".hr_base_education_level ON edulv_id = education.edu_edulv_id 
			LEFT JOIN ".$this->hr_db.".hr_base_education_degree ON edudg_id = education.edu_edudg_id
			LEFT JOIN ".$this->hr_db.".hr_base_education_major ON edumj_id = education.edu_edumj_id
			LEFT JOIN ".$this->hr_db.".hr_base_place ON place_id = education.edu_place_id
			LEFT JOIN ".$this->hr_db.".hr_base_country ON country_id = education.edu_country_id
			LEFT JOIN (
				SELECT history.*
				$base_sql
				AND history.hipos_pos_hire_id IN (
					SELECT h3.hire_id
					FROM ".$this->hr_db.".hr_base_hire AS h3
					WHERE h3.hire_is_medical = '{$hire_is_medical}'
				)
			) AS history ON education.edu_ps_id = history.hipos_ps_id
			WHERE education.edu_edulv_id = {$edulv_id}
			AND education.edu_highest = 'Y'
		";
	
		$query = $this->hr->query($sql);

		// Loop through the results to encrypt the ID and replace the placeholder
		foreach ($query->result() as $row) {
			$row->full_name = str_replace('PLACEHOLDER', encrypt_id($row->hipos_ps_id), $row->full_name);
		}
		
		return $query;
	}
	// get_HRM_chart_5_detail
	


}
?>
