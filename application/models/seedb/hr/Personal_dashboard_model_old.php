<?php
/*
* personal_dashboard
* Model for Manage about Personal Dashboard
* @Author Tanadon Tangjaimongkhon
* @Create Date 07/01/2024
*/
include_once(dirname(__FILE__)."/../seedb_model.php");

class Personal_dashboard_model extends seedb_model {

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
			hr_person_history.*


			FROM {$this->hr_db}.hr_person_position_history AS h1
			
			LEFT JOIN {$this->hr_db}.hr_person_admin_position 
				ON h1.hipos_pos_admin_id = hr_person_admin_position.psap_pos_id
			LEFT JOIN {$this->hr_db}.hr_base_admin_position 
				ON hr_person_admin_position.psap_admin_id = hr_base_admin_position.admin_id

			LEFT JOIN {$this->hr_db}.hr_person_special_position 
				ON h1.hipos_pos_spcl_id = hr_person_special_position.pssp_pos_id
			LEFT JOIN {$this->hr_db}.hr_base_special_position 
				ON hr_person_special_position.pssp_spcl_id = hr_base_special_position.spcl_id

			LEFT JOIN {$this->hr_db}.hr_base_adline_position 
				ON h1.hipos_pos_alp_id = hr_base_adline_position.alp_id

			LEFT JOIN {$this->hr_db}.hr_base_retire 
				ON h1.hipos_pos_retire_id = hr_base_retire.retire_id

			LEFT JOIN {$this->hr_db}.hr_base_hire 
				ON h1.hipos_pos_hire_id = hr_base_hire.hire_id

			LEFT JOIN (
				SELECT hph.hips_id, hph.hips_ps_id, pf.pf_name, hph.hips_ps_fname, hph.hips_ps_lname, hph.hips_start_date, hph.hips_end_date
				FROM {$this->hr_db}.hr_person_history AS hph
				LEFT JOIN {$this->hr_db}.hr_base_prefix as pf
					ON pf.pf_id = hph.hips_ps_pf_id
				 WHERE hph.hips_start_date <= '$endDate'
            			AND (hph.hips_end_date >= '$startDate' OR hph.hips_end_date IS NULL OR hph.hips_end_date = '9999-12-31')
						AND hph.hips_id = (
							SELECT MAX(hph2.hips_id)
							FROM {$this->hr_db}.hr_person_history AS hph2
							WHERE 	hph2.hips_ps_id = hph.hips_ps_id
									AND hph2.hips_start_date <= '$endDate'
									AND (hph2.hips_end_date >= '$startDate' OR hph2.hips_end_date IS NULL OR hph2.hips_end_date = '9999-12-31')
						)
			) AS hr_person_history
				ON h1.hipos_ps_id = hr_person_history.hips_ps_id

			LEFT JOIN {$this->hr_db}.hr_order_data
				ON ord_ps_id = hr_person_history.hips_ps_id
			LEFT JOIN {$this->hr_db}.hr_order_data_type
				ON ord_ordt_id = ordt_id
			
			WHERE 	h1.hipos_id = (
						SELECT MAX(h2.hipos_id)
						FROM {$this->hr_db}.hr_person_position_history AS h2
						WHERE h2.hipos_pos_id = h1.hipos_pos_id
								AND h2.hipos_start_date <= '$endDate' 
								AND (h2.hipos_end_date >= '$startDate' OR h2.hipos_end_date IS NULL OR h2.hipos_end_date = '9999-12-31')
					)
					AND h1.hipos_pos_dp_id = {$dp_id}
					AND ordt_dp_id = {$dp_id}
					AND ord_active = 1
					AND ord_ordt_id = 13
			GROUP BY h1.hipos_id
			ORDER BY ord_seq ASC
		";

		$base_sql = "
			FROM {$this->hr_db}.hr_person
			LEFT JOIN {$this->hr_db}.hr_person_position 
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
	* get_HRM_card
	* ดึงข้อมูลการ์ด SEE-HRM-C1 - C6
	* @input $dp_id, $year_type, $year
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 01/07/2024
	*/
	function get_HRM_card($dp_id, $year_type, $year) {
		$base_sql = $this->personal_base_query($dp_id, $year_type, $year);
	
		$sql_all = "
			SELECT 
				'all' AS card_type,
				'บุคลากรทั้งหมด' AS card_name,
				COUNT(*) AS card_count
			$base_sql
		";
	
		$sql_working = "
			SELECT 
				'working' AS card_type,
				'ปฏิบัติงานจริง' AS card_name,
				COUNT(*) AS card_count
			$base_sql
			AND history.hipos_pos_status = 1
		";
	
		$sql_out = "
			SELECT 
				'out' AS card_type,
				'ลาออก' AS card_name,
				COUNT(*) AS card_count
			$base_sql
			AND history.hipos_pos_status = 2
		";
	
		$sql_medical = "
			SELECT 
				'medical' AS card_type,
				'ทีมสายแพทย์' AS card_name,
				COUNT(*) AS card_count
			$base_sql
			
			AND EXISTS (
				SELECT 1
				FROM {$this->hr_db}.hr_base_hire
				WHERE hr_base_hire.hire_id = history.hipos_pos_hire_id
				AND hr_base_hire.hire_is_medical = 'M'
			)
		";
	
		$sql_nurse = "
			SELECT 
				'nurse' AS card_type,
				'สายพยาบาล' AS card_name,
				COUNT(*) AS card_count
			$base_sql
			
			AND EXISTS (
				SELECT 1
				FROM {$this->hr_db}.hr_base_hire
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
				FROM {$this->hr_db}.hr_base_hire
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
				FROM {$this->hr_db}.hr_base_hire
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
				FROM {$this->hr_db}.hr_base_hire
				WHERE hr_base_hire.hire_id = history.hipos_pos_hire_id
				AND hr_base_hire.hire_is_medical = 'T'
			)
		";
	
		$sql_support = "
			SELECT 
				'support' AS card_type,
				'สายสนับสนุน' AS card_name,
				COUNT(*) AS card_count
			$base_sql
			
			AND EXISTS (
				SELECT 1
				FROM {$this->hr_db}.hr_base_hire
				WHERE hr_base_hire.hire_id = history.hipos_pos_hire_id
				AND hr_base_hire.hire_is_medical = 'S'
			)
		";
	
		$sql = "$sql_all UNION $sql_working UNION $sql_out UNION $sql_medical UNION $sql_nurse UNION $sql_admin UNION $sql_support_medical UNION $sql_technical UNION $sql_support";
	
		$query = $this->hr->query($sql);
		// echo $this->hr->last_query(); // สำหรับการตรวจสอบ query ที่ถูกสร้างขึ้น
		return $query;
	}
	// get_HRM_card
	
	/*
	* get_HRM_card_person_detail
	* ดึงข้อมูลรายละเอียดการ์ด SEE-HRM-C1 - C6 
	* @input $dp_id, $year_type, $year
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 01/07/2024
	*/
	public function get_HRM_card_person_detail($dp_id, $year_type, $year, $card_type) {
		$base_sql = $this->personal_base_query($dp_id, $year_type, $year);
	
		$sql = "
			SELECT 
				history.hipos_id,
				history.hipos_ps_id,
				CONCAT(history.pf_name,history.hips_ps_fname,' ',history.hips_ps_lname) as full_name,
				history.ps_hire_name,
				history.ps_admin_name,
				history.ps_spcl_name,
				history.ps_alp_name,
				history.ps_retire_name,
				history.hipos_pos_work_end_date AS ps_work_end_date
				
			$base_sql
		";
	
		switch ($card_type) {
			case 'working':
				$sql .= " AND history.hipos_pos_status = 1";
				break;
			case 'out':
				$sql .= " AND history.hipos_pos_status = 2";
				break;
			case 'medical':
				$sql .= " AND EXISTS (
					SELECT 1
					FROM {$this->hr_db}.hr_base_hire
					WHERE hr_base_hire.hire_id = history.hipos_pos_hire_id
					AND hr_base_hire.hire_is_medical = 'M'
				)";
				break;
			case 'nurse':
				$sql .= " AND EXISTS (
					SELECT 1
					FROM {$this->hr_db}.hr_base_hire
					WHERE hr_base_hire.hire_id = history.hipos_pos_hire_id
					AND hr_base_hire.hire_is_medical = 'N'
				)";

				break;

			case 'admin':
				$sql .= " AND EXISTS (
					SELECT 1
					FROM {$this->hr_db}.hr_base_hire
					WHERE hr_base_hire.hire_id = history.hipos_pos_hire_id
					AND hr_base_hire.hire_is_medical = 'A'
				)";

				break;

			case 'support_medical':
				$sql .= " AND EXISTS (
					SELECT 1
					FROM {$this->hr_db}.hr_base_hire
					WHERE hr_base_hire.hire_id = history.hipos_pos_hire_id
					AND hr_base_hire.hire_is_medical = 'SM'
				)";

				break;

			case 'technical':
				$sql .= " AND EXISTS (
					SELECT 1
					FROM {$this->hr_db}.hr_base_hire
					WHERE hr_base_hire.hire_id = history.hipos_pos_hire_id
					AND hr_base_hire.hire_is_medical = 'T'
				)";

				break;
			case 'support':
				$sql .= " AND EXISTS (
					SELECT 1
					FROM {$this->hr_db}.hr_base_hire
					WHERE hr_base_hire.hire_id = history.hipos_pos_hire_id
					AND hr_base_hire.hire_is_medical = 'S'
				)";
				break;
		}
	
		$query = $this->hr->query($sql);
		// echo $this->hr->last_query();
		return $query;
	}
	// get_HRM_card_person_detail

	/*
	* get_HRM_chart_G1
	* ดึงข้อมูลและจัดรูปแบบสำหรับกราฟ SEE-HRM-G1
	* @input dp_id, year_type, year
	* @output ข้อมูลที่จัดรูปแบบสำหรับกราฟ
	* @Create Date 08/07/2024
	*/
	function get_HRM_chart_G1($dp_id, $year_type, $year)
	{
		// Define variables for the query
		$is_medical = 'Y';
		$status = 1;
		$person_active = 1;

		// Construct the base SQL for the subquery
		$base_sql = $this->personal_base_query($dp_id, $year_type, $year);

		// Construct the SQL query
		$sql = "
			SELECT 
				stde.stde_id, 
				stde.stde_name_th AS stde_name, 
				hire.hire_is_medical, 
				COUNT(hsp.stdp_id) AS hire_person_count
			FROM " . $this->hr_db . ".hr_structure_detail stde
			LEFT JOIN " . $this->hr_db . ".hr_structure stuc ON stuc.stuc_id = stde.stde_stuc_id
			LEFT JOIN " . $this->hr_db . ".hr_structure_person hsp ON hsp.stdp_stde_id = stde.stde_id
			LEFT JOIN (
				SELECT history.hipos_ps_id, history.hipos_pos_hire_id
				$base_sql
			) AS history ON hsp.stdp_ps_id = history.hipos_ps_id
			LEFT JOIN " . $this->hr_db . ".hr_base_hire hire ON history.hipos_pos_hire_id = hire.hire_id
			WHERE 
				stde.stde_is_medical = '$is_medical'
				AND stde.stde_active = $status
				AND stuc.stuc_dp_id = $dp_id
				AND (
					(YEAR(stuc.stuc_confirm_date) = $year AND stuc.stuc_status = 1)
					OR
					(YEAR(stuc.stuc_confirm_date) < $year AND stuc.stuc_status IN (0, 2))
				)
				AND hsp.stdp_active = $person_active
				AND hire.hire_is_medical IN ('M','N')
			GROUP BY 
				stde.stde_id, 
				stde_name,
				hire.hire_is_medical

			UNION

			SELECT 
				stde.stde_id, 
				stde.stde_name_th AS stde_name, 
				hire.hire_is_medical, 
				COUNT(hsp.stdp_id) AS hire_person_count
			FROM " . $this->hr_db . ".hr_structure_detail stde
			LEFT JOIN " . $this->hr_db . ".hr_structure stuc ON stuc.stuc_id = stde.stde_stuc_id
			LEFT JOIN " . $this->hr_db . ".hr_structure_person hsp ON hsp.stdp_stde_id = stde.stde_id
			LEFT JOIN (
				SELECT history.hipos_ps_id, history.hipos_pos_hire_id
				$base_sql
			) AS history ON hsp.stdp_ps_id = history.hipos_ps_id
			LEFT JOIN " . $this->hr_db . ".hr_base_hire hire ON history.hipos_pos_hire_id = hire.hire_id
			WHERE 
				stde.stde_is_medical = '$is_medical'
				AND stde.stde_active = $status
				AND stuc.stuc_dp_id = $dp_id
				AND stuc.stuc_status = 1
				AND NOT EXISTS (
					SELECT 1
					FROM " . $this->hr_db . ".hr_structure
					WHERE 
						stuc_dp_id = $dp_id
						AND YEAR(stuc_confirm_date) = $year
				)
				AND hsp.stdp_active = $person_active
				AND hire.hire_is_medical IN ('M','N')
			GROUP BY 
				stde.stde_id, 
				stde_name,
				hire.hire_is_medical
		";

		// Execute the query
		$query = $this->hr->query($sql);
		return $query;
	}
	// get_HRM_chart_G1

	/*
	* get_HRM_chart_G1_person_detail
	* ดึงข้อมูลรายละเอียดบุคคลตามโครงสร้างย่อย (stde_id)
	* @input dp_id, year_type, year, stde_id
	* $output รายละเอียดบุคคลในโครงสร้างย่อยที่เลือก
	* @Create Date 08/07/2024
	*/
	function get_HRM_chart_G1_person_detail($dp_id, $year_type, $year, $stde_id)
	{
		// Define variables for the query
		$is_medical = 'Y';
		$status = 1;
		$person_active = 1;

		// Construct the base SQL for the subquery
		$base_sql = $this->personal_base_query($dp_id, $year_type, $year);

		// Construct the SQL query for person details
		$sql = "
			SELECT 
				history.hipos_ps_id,
				CONCAT(history.pf_name, history.hips_ps_fname, ' ', history.hips_ps_lname) AS full_name,
				history.ps_hire_name,
				history.ps_admin_name,
				history.ps_spcl_name,
				history.ps_alp_name,
				history.ps_retire_name,
				stde.stde_name_th AS stde_name,
				hire.hire_is_medical
			FROM " . $this->hr_db . ".hr_structure_person hsp
			LEFT JOIN " . $this->hr_db . ".hr_person hrp ON hsp.stdp_ps_id = hrp.ps_id
			LEFT JOIN " . $this->hr_db . ".hr_structure_detail stde ON hsp.stdp_stde_id = stde.stde_id
			LEFT JOIN (
				SELECT history.*
				$base_sql
			) AS history ON hsp.stdp_ps_id = history.hipos_ps_id
			 LEFT JOIN " . $this->hr_db . ".hr_base_hire hire ON hire.hire_id = history.hipos_pos_hire_id
			 
			WHERE hsp.stdp_stde_id = $stde_id
			AND hsp.stdp_active = $person_active
			AND stde.stde_is_medical = '$is_medical'
			AND stde.stde_active = $status
			AND history.hipos_ps_id IS NOT NULL
			AND hire.hire_is_medical IN ('M','N')
		";

		// Execute the query
		$query = $this->hr->query($sql);
		return $query;
	}

	/*
	* get_HRM_chart_G2
	* ดึงข้อมูลกราฟ SEE-HRM-G2
	* @input $dp_id, $year_type, $year
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 02/07/2024
	*/
	function get_HRM_chart_G2($dp_id, $year_type, $year) {
		$base_sql = $this->personal_base_query($dp_id, $year_type, $year);
	
		$sql = "
			SELECT 
				CASE 
					WHEN hr_base_hire.hire_is_medical = 'M' THEN 'สายแพทย์' 
					WHEN hr_base_hire.hire_is_medical = 'N' THEN 'สายพยาบาล'
					WHEN hr_base_hire.hire_is_medical = 'A' THEN 'สายบริหาร'
					WHEN hr_base_hire.hire_is_medical = 'SM' THEN 'สายสนับสนุนทางการแพทย์'
					WHEN hr_base_hire.hire_is_medical = 'T' THEN 'สายเทคนิคและบริการ'
					ELSE 'สายสนับสนุน'
				END AS chart_name,
				hr_base_hire.hire_is_medical AS chart_type,
				COALESCE(COUNT(category_hire.hipos_pos_hire_id), 0) AS chart_count
			FROM {$this->hr_db}.hr_base_hire
			LEFT JOIN (
				SELECT history.hipos_pos_hire_id
				$base_sql
			) AS category_hire
			ON hr_base_hire.hire_id = category_hire.hipos_pos_hire_id
			GROUP BY chart_name
			ORDER BY chart_type DESC

		";
	
		$query = $this->hr->query($sql);
		// echo $this->hr->last_query(); // สำหรับการตรวจสอบ query ที่ถูกสร้างขึ้น
		return $query;
	}
	// get_HRM_chart_G2

	/*
	* get_HRM_chart_G2_person_detail
	* ดึงข้อมูลรายละเอียดกราฟ SEE-HRM-G2
	* @input $dp_id, $year_type, $year
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 02/07/2024
	*/
	function get_HRM_chart_G2_person_detail($dp_id, $year_type, $year, $hire_is_medical) {
		$base_sql = $this->personal_base_query($dp_id, $year_type, $year);
	
		$sql = "
			SELECT 
				history.hipos_ps_id,
				CONCAT(history.pf_name,history.hips_ps_fname,' ',history.hips_ps_lname) as full_name,
				history.ps_hire_name,
				history.ps_admin_name,
				history.ps_spcl_name,
				history.ps_alp_name,
				history.ps_retire_name,
				history.hipos_pos_work_end_date AS ps_work_end_date

			$base_sql

			AND history.hipos_pos_hire_id IN (
					SELECT h3.hire_id
					FROM {$this->hr_db}.hr_base_hire AS h3
					WHERE h3.hire_is_medical = '{$hire_is_medical}'
				)

		";
	
		$query = $this->hr->query($sql);
		// echo $this->hr->last_query(); // สำหรับการตรวจสอบ query ที่ถูกสร้างขึ้น
		return $query;
	}
	// get_HRM_chart_G2_person_detail

	/*
	* get_HRM_chart_G3
	* ดึงข้อมูลกราฟ SEE-HRM-G3
	* @input $dp_id, $year_type, $year
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 03/07/2024
	*/
	function get_HRM_chart_G3($dp_id, $year_type, $year) {
		$base_sql = $this->personal_base_query($dp_id, $year_type, $year);
	
		$sql = "
			SELECT 
				TRIM(REPLACE(REPLACE(REPLACE(hr_base_hire.hire_name, 'ปฏิบัติงานเต็มเวลา', ''), 'ปฏิบัติงานบางเวลา', ''), 'ปฏิบัติงาน', '')) AS chart_name,
				CASE
					WHEN hr_base_hire.hire_type = 1 THEN 'Full'
					ELSE 'Part'
				END AS chart_subtype,
				COALESCE(COUNT(category_hire.hipos_pos_hire_id), 0) AS chart_count
			FROM {$this->hr_db}.hr_base_hire
			LEFT JOIN (
				SELECT history.hipos_pos_hire_id
				$base_sql
			) AS category_hire
			ON hr_base_hire.hire_id = category_hire.hipos_pos_hire_id
			WHERE hr_base_hire.hire_is_medical = 'M'
					AND hr_base_hire.hire_active = 1
			GROUP BY chart_name, chart_subtype
        	ORDER BY chart_name, chart_subtype
		";
	
		$query = $this->hr->query($sql);
		// echo $this->hr->last_query(); // สำหรับการตรวจสอบ query ที่ถูกสร้างขึ้น
		return $query;
	}
	// get_HRM_chart_G3

	/*
	* get_HRM_chart_G3_person_detail
	* ดึงข้อมูลรายละเอียดกราฟ SEE-HRM-G3
	* @input $dp_id, $year_type, $year
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 03/07/2024
	*/
	function get_HRM_chart_G3_person_detail($dp_id, $year_type, $year) {
		$base_sql = $this->personal_base_query($dp_id, $year_type, $year);
	
		$sql = "
			SELECT 
				history.hipos_ps_id,
				CONCAT(history.pf_name, history.hips_ps_fname, ' ', history.hips_ps_lname) as full_name,
				hr_base_hire.hire_name AS ps_hire_name,
				history.ps_admin_name,
				history.ps_spcl_name,
				history.ps_alp_name,
				history.ps_retire_name,
				history.hipos_pos_work_end_date AS ps_work_end_date,
				CASE
					WHEN hr_base_hire.hire_type = 1 THEN 'full-time'
					ELSE 'part-time'
				END AS chart_subtype
	
			FROM {$this->hr_db}.hr_base_hire
			LEFT JOIN (
				SELECT history.hipos_pos_hire_id, history.hipos_ps_id, history.pf_name, history.hips_ps_fname, history.hips_ps_lname,
					   history.ps_admin_name, history.ps_spcl_name, history.ps_alp_name, history.ps_retire_name, history.hipos_pos_work_end_date
				$base_sql
			) AS history
			ON hr_base_hire.hire_id = history.hipos_pos_hire_id
			WHERE hr_base_hire.hire_is_medical = 'M'
			AND hr_base_hire.hire_active = 1
			ORDER BY hr_base_hire.hire_name, chart_subtype, full_name
		";
		
		$query = $this->hr->query($sql);
		// echo $this->hr->last_query(); // สำหรับการตรวจสอบ query ที่ถูกสร้างขึ้น
		return $query;
	}
	// get_HRM_chart_G3_person_detail
	
	/*
	* get_HRM_chart_G4
	* ดึงข้อมูลกราฟ SEE-HRM-G4
	* @input $dp_id, $year_type, $year
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 03/07/2024
	*/
	public function get_HRM_chart_G4($dp_id, $year_type, $year) {
		$base_sql = $this->personal_base_query($dp_id, $year_type, $year);
	
		$sql = "
			SELECT 
				CASE 
					WHEN licn.licn_id IS NULL THEN 'ไม่มีข้อมูล'
					WHEN licn.licn_end_date IS NULL OR licn.licn_end_date <= CURDATE() THEN 'หมดอายุแล้ว'
					WHEN licn.licn_end_date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 3 MONTH) THEN 'หมดภายใน 3 เดือน'
					WHEN licn.licn_end_date BETWEEN DATE_ADD(CURDATE(), INTERVAL 3 MONTH) AND DATE_ADD(CURDATE(), INTERVAL 6 MONTH) THEN 'หมดภายใน 6 เดือน'
					WHEN licn.licn_end_date BETWEEN DATE_ADD(CURDATE(), INTERVAL 6 MONTH) AND DATE_ADD(CURDATE(), INTERVAL 9 MONTH) THEN 'หมดภายใน 9 เดือน'
					WHEN licn.licn_end_date BETWEEN DATE_ADD(CURDATE(), INTERVAL 9 MONTH) AND DATE_ADD(CURDATE(), INTERVAL 1 YEAR) THEN 'หมดภายใน 1 ปี'
					WHEN licn.licn_end_date BETWEEN DATE_ADD(CURDATE(), INTERVAL 1 YEAR) AND DATE_ADD(CURDATE(), INTERVAL 2 YEAR) THEN 'หมดภายใน 2 ปี'
					WHEN licn.licn_end_date BETWEEN DATE_ADD(CURDATE(), INTERVAL 2 YEAR) AND DATE_ADD(CURDATE(), INTERVAL 3 YEAR) THEN 'หมดภายใน 3 ปี'
					ELSE 'มากกว่า 3 ปี'
				END AS expiration_period,
				IF(hr_base_vocation.voc_name IS NOT NULL, hr_base_vocation.voc_name, 'ไม่มีข้อมูล') AS vocation_name,
				COUNT(*) AS person_count
			FROM {$this->hr_db}.hr_person
			LEFT JOIN (
				SELECT 
					hr_person_license.*,
					ROW_NUMBER() OVER (PARTITION BY hr_person_license.licn_ps_id ORDER BY hr_person_license.licn_end_date DESC) AS rn
				FROM {$this->hr_db}.hr_person_license
			) AS licn ON licn.licn_ps_id = hr_person.ps_id AND licn.rn = 1
			LEFT JOIN {$this->hr_db}.hr_base_vocation 
				ON licn.licn_voc_id = hr_base_vocation.voc_id
			LEFT JOIN (
				SELECT history.*
				$base_sql
			) AS history ON hr_person.ps_id = history.hipos_ps_id
			
			WHERE history.hire_is_medical IN ('M','N')
			AND history.hire_active = 1
			GROUP BY expiration_period, vocation_name
			ORDER BY 
			FIELD(expiration_period, 
				'ไม่มีข้อมูล', 
				'หมดอายุแล้ว', 
				'หมดภายใน 3 เดือน', 
				'หมดภายใน 6 เดือน', 
				'หมดภายใน 9 เดือน', 
				'หมดภายใน 1 ปี', 
				'หมดภายใน 2 ปี', 
				'หมดภายใน 3 ปี', 
				'มากกว่า 3 ปี'
			),
				CASE 
					WHEN vocation_name = 'ไม่มีข้อมูล' THEN 1 
					ELSE 0 
				END, 
				vocation_name
		";
		$query = $this->hr->query($sql);
		return $query;
	}
	// get_HRM_chart_G4

	public function get_HRM_chart_G4_detail($dp_id, $year_type, $year) {
		$base_sql = $this->personal_base_query($dp_id, $year_type, $year);
		
		$sql = "
			SELECT 
				CASE 
					WHEN licn.licn_id IS NULL THEN 'ไม่มีข้อมูล'
					WHEN licn.licn_end_date IS NULL OR licn.licn_end_date <= CURDATE() THEN 'หมดอายุแล้ว'
					WHEN licn.licn_end_date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 3 MONTH) THEN 'หมดภายใน 3 เดือน'
					WHEN licn.licn_end_date BETWEEN DATE_ADD(CURDATE(), INTERVAL 3 MONTH) AND DATE_ADD(CURDATE(), INTERVAL 6 MONTH) THEN 'หมดภายใน 6 เดือน'
					WHEN licn.licn_end_date BETWEEN DATE_ADD(CURDATE(), INTERVAL 6 MONTH) AND DATE_ADD(CURDATE(), INTERVAL 9 MONTH) THEN 'หมดภายใน 9 เดือน'
					WHEN licn.licn_end_date BETWEEN DATE_ADD(CURDATE(), INTERVAL 9 MONTH) AND DATE_ADD(CURDATE(), INTERVAL 1 YEAR) THEN 'หมดภายใน 1 ปี'
					WHEN licn.licn_end_date BETWEEN DATE_ADD(CURDATE(), INTERVAL 1 YEAR) AND DATE_ADD(CURDATE(), INTERVAL 2 YEAR) THEN 'หมดภายใน 2 ปี'
					WHEN licn.licn_end_date BETWEEN DATE_ADD(CURDATE(), INTERVAL 2 YEAR) AND DATE_ADD(CURDATE(), INTERVAL 3 YEAR) THEN 'หมดภายใน 3 ปี'
					ELSE 'มากกว่า 3 ปี'
				END AS expiration_period,
				licn.licn_start_date,
				licn.licn_end_date,
				IF(hr_base_vocation.voc_name IS NOT NULL, hr_base_vocation.voc_name, 'ไม่มีข้อมูล') AS vocation_name,
				history.hipos_ps_id,
				CONCAT(history.pf_name, history.hips_ps_fname, ' ', history.hips_ps_lname) as full_name,
				history.ps_hire_name,
				history.ps_admin_name,
				history.ps_spcl_name,
				history.ps_alp_name,
				history.ps_retire_name
			FROM (
				SELECT 
					hr_person_license.*,
					ROW_NUMBER() OVER (PARTITION BY hr_person_license.licn_ps_id ORDER BY hr_person_license.licn_end_date DESC) AS rn
				FROM {$this->hr_db}.hr_person_license
			) AS licn
			RIGHT JOIN {$this->hr_db}.hr_person ON licn.licn_ps_id = hr_person.ps_id AND licn.rn = 1
			LEFT JOIN {$this->hr_db}.hr_base_vocation 
				ON licn.licn_voc_id = hr_base_vocation.voc_id
			LEFT JOIN (
				SELECT history.*
				$base_sql
			) AS history ON hr_person.ps_id = history.hipos_ps_id

			WHERE history.hire_is_medical IN ('M','N')
			AND history.hire_active = 1
			
			ORDER BY 
			FIELD(expiration_period, 
				'ไม่มีข้อมูล', 
				'หมดอายุแล้ว', 
				'หมดภายใน 3 เดือน', 
				'หมดภายใน 6 เดือน', 
				'หมดภายใน 9 เดือน', 
				'หมดภายใน 1 ปี', 
				'หมดภายใน 2 ปี', 
				'หมดภายใน 3 ปี', 
				'มากกว่า 3 ปี'
			),
				CASE 
					WHEN vocation_name = 'ไม่มีข้อมูล' THEN 1 
					ELSE 0 
				END, 
				vocation_name
		";
		$query = $this->hr->query($sql);
		return $query;
	}

	/*
	* get_HRM_chart_G5
	* ดึงข้อมูลกราฟ SEE-HRM-G5
	* @input $dp_id, $year_type, $year
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 08/07/2024
	*/
	function get_HRM_chart_G5($dp_id, $year_type, $year) {
		$base_sql = $this->personal_base_query($dp_id, $year_type, $year);
	
		// Define age groups and genders
		$age_groups = ["น้อยกว่า 30", "31-40", "41-50", "51-60", "60 ปีขึ้นไป"];
		$genders = ["ชาย", "หญิง"];
	
		// Create SQL query
		$sql = "
			SELECT 
				all_combinations.age_group,
				all_combinations.gender_name,
				COALESCE(actual_data.person_count, 0) AS person_count
			FROM (
				SELECT 
					ages.age_group, 
					genders.gender_name
				FROM (
					SELECT 'น้อยกว่า 30 ปี' AS age_group UNION ALL
					SELECT '31 ปี - 40 ปี' UNION ALL
					SELECT '41 ปี - 50 ปี' UNION ALL
					SELECT '51 ปี - 60 ปี' UNION ALL
					SELECT '60 ปีขึ้นไป'
				) AS ages
				CROSS JOIN (
					SELECT 'ชาย' AS gender_name UNION ALL
					SELECT 'หญิง'
				) AS genders
			) AS all_combinations
			LEFT JOIN (
				SELECT 
					CASE 
						WHEN TIMESTAMPDIFF(YEAR, psd.psd_birthdate, CURDATE()) < 30 THEN 'น้อยกว่า 30 ปี'
						WHEN TIMESTAMPDIFF(YEAR, psd.psd_birthdate, CURDATE()) BETWEEN 31 AND 40 THEN '31 ปี - 40 ปี'
						WHEN TIMESTAMPDIFF(YEAR, psd.psd_birthdate, CURDATE()) BETWEEN 41 AND 50 THEN '41 ปี - 50 ปี'
						WHEN TIMESTAMPDIFF(YEAR, psd.psd_birthdate, CURDATE()) BETWEEN 51 AND 60 THEN '51 ปี - 60 ปี'
						ELSE '60 ปีขึ้นไป'
					END AS age_group,
					gd.gd_name AS gender_name,
					COUNT(*) AS person_count
				FROM {$this->hr_db}.hr_person_detail AS psd
				LEFT JOIN {$this->hr_db}.hr_base_gender AS gd ON gd.gd_id = psd.psd_gd_id
				LEFT JOIN (
					SELECT history.hipos_ps_id
					$base_sql
				) AS history ON psd.psd_ps_id = history.hipos_ps_id
				WHERE psd.psd_birthdate IS NOT NULL
				GROUP BY 
					age_group, gd.gd_name
			) AS actual_data
			ON all_combinations.age_group = actual_data.age_group 
			AND all_combinations.gender_name = actual_data.gender_name
			ORDER BY 
				FIELD(all_combinations.age_group, 'น้อยกว่า 30 ปี', '31 ปี - 40 ปี', '41 ปี - 50 ปี', '51 ปี - 60 ปี', '60 ปีขึ้นไป'),
				FIELD(all_combinations.gender_name, 'ชาย', 'หญิง');
		";
	
		$query = $this->hr->query($sql);
		// echo $this->hr->last_query(); // สำหรับการตรวจสอบ query ที่ถูกสร้างขึ้น
		return $query;
	}
	// get_HRM_chart_G5

	/*
	* get_HRM_chart_G5_detail
	* ดึงข้อมูลรายละเอียดกราฟ SEE-HRM-G5
	* @input $dp_id, $year_type, $year
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 08/07/2024
	*/
	function get_HRM_chart_G5_detail($dp_id, $year_type, $year) {
		$base_sql = $this->personal_base_query($dp_id, $year_type, $year);
	
		$sql = "
			SELECT 
				CASE 
					WHEN TIMESTAMPDIFF(YEAR, psd.psd_birthdate, CURDATE()) < 30 THEN 'น้อยกว่า 30 ปี'
					WHEN TIMESTAMPDIFF(YEAR, psd.psd_birthdate, CURDATE()) BETWEEN 31 AND 40 THEN '31 ปี - 40 ปี'
					WHEN TIMESTAMPDIFF(YEAR, psd.psd_birthdate, CURDATE()) BETWEEN 41 AND 50 THEN '41 ปี - 50 ปี'
					WHEN TIMESTAMPDIFF(YEAR, psd.psd_birthdate, CURDATE()) BETWEEN 51 AND 60 THEN '51 ปี - 60 ปี'
					ELSE '60 ปีขึ้นไป'
				END AS age_group,
				gd.gd_name AS gender_name,
				history.hipos_ps_id,
				CONCAT(history.pf_name, history.hips_ps_fname, ' ', history.hips_ps_lname) as full_name,
				history.ps_hire_name,
				history.ps_admin_name,
				history.ps_spcl_name,
				history.ps_alp_name,
				history.ps_retire_name,
				psd.psd_birthdate AS birthdate
			FROM {$this->hr_db}.hr_person_detail AS psd
			LEFT JOIN {$this->hr_db}.hr_base_gender AS gd ON gd.gd_id = psd.psd_gd_id
			LEFT JOIN (
				SELECT history.*
				$base_sql
			) AS history ON psd.psd_ps_id = history.hipos_ps_id
			WHERE psd.psd_birthdate IS NOT NULL
			ORDER BY 
				FIELD(age_group, 'น้อยกว่า 30 ปี', '31 ปี - 40 ปี', '41 ปี - 50 ปี', '51 ปี - 60 ปี', '60 ปีขึ้นไป'),
				FIELD(gd.gd_name, 'ชาย', 'หญิง');
		";
	
		$query = $this->hr->query($sql);
		return $query;
	}
	// get_HRM_chart_G5_detail
	
	
	
	/*
	* get_hr_base_hire_group_is_medical_data
	* ดึงข้อมูลประเภทบุคลากร GROUP BY
	* @input -
	* $output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 02/07/2024
	*/
	function get_hr_base_hire_group_is_medical_data()
	{
		$sql = "SELECT 	
						hire_id, 
						hire_name,
						hire_abbr,
						hire_type,
						hire_active,
						hire_is_medical
				FROM " . $this->hr_db . ".hr_base_hire
				GROUP BY hire_is_medical";
		$query = $this->hr->query($sql);
		return $query;
	}
	// get_hr_base_hire_group_is_medical_data

	
	
	

}
?>
