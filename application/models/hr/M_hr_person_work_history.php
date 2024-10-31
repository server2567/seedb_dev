<?php
/*
 * M_hr_person_work_history
 * Model for Manage about hr_person_work_history Table.
 * @Author Tanadon
 * @Create Date 29/05/2024
 */

include_once("Da_hr_person_work_history.php");
class M_hr_person_work_history extends Da_hr_person_work_history
{

	/*
	* get_all_person_work_history_data
	* ดึงข้อมูลรายการประสบการณ์ทำงานของบุคลากร
	* @input ps_id
	* $output work_history all by ps_id
	* @author Tanadon Tangjaimongkhon
	* @Create Date 29/05/2024
	*/
	function get_all_person_work_history_data($ps_id)
	{
		$sql = "SELECT 
						wohr_id,
						wohr_ps_id,
						wohr_detail_th,
						wohr_detail_en,
						wohr_stuc_id,
						wohr_stde_id,
						wohr_stde_name_th,
						wohr_place_name,
						wohr_start_date,
						wohr_end_date,
						alp_name,
						stde_name_th,
						admin_name
				FROM " . $this->hr_db . ".hr_person_work_history
				LEFT JOIN " . $this->hr_db . ".hr_base_adline_position
					ON wohr_alp_id = alp_id
				LEFT JOIN " . $this->hr_db . ".hr_base_admin_position
					ON wohr_admin_id = admin_id
				LEFT JOIN " . $this->hr_db . ".hr_structure_detail
					ON stde_id = wohr_stde_id 
				WHERE wohr_ps_id = {$ps_id}
				ORDER BY wohr_end_date DESC";
		$query = $this->hr->query($sql);
		return $query;
	}
	// get_all_person_work_history_data

	/*
	* get_work_history_detail_by_id
	* ข้อมูลรายละเอียดประสบการณ์ทำงานตามไอดี
	* @input wohr_id
	* $output work_history all by wohr_id
	* @author Tanadon Tangjaimongkhon
	* @Create Date 29/05/2024
	*/
	function get_work_history_detail_by_id($wohr_id)
	{
		$sql = "SELECT 
						wohr_id,
						wohr_ps_id,
						wohr_alp_id,
						wohr_admin_id,
						wohr_detail_th,
						wohr_detail_en,
						wohr_stuc_id,
						wohr_stde_id,
						wohr_stde_name_th,
						wohr_place_name,
						wohr_start_date,
						wohr_end_date,
						alp_name,
						admin_name
				FROM " . $this->hr_db . ".hr_person_work_history
				LEFT JOIN " . $this->hr_db . ".hr_base_adline_position
					ON wohr_alp_id = alp_id
				LEFT JOIN " . $this->hr_db . ".hr_base_admin_position
					ON wohr_admin_id = admin_id
				WHERE wohr_id = {$wohr_id}";
		$query = $this->hr->query($sql);
		return $query;
	}
	// get_work_history_detail_by_id
	function get_work_time_line()
	{
		$sql = "WITH RankedChanges AS (
				SELECT 
					hipos_ps_id,
					hipos_pos_dp_id,
					hipos_pos_status,
					hipos_start_date,
					hipos_end_date,
					hipos_pos_retire_id,
					hipos_update_date,
					LAG(hipos_pos_status) OVER (PARTITION BY hipos_ps_id, hipos_pos_dp_id ORDER BY hipos_update_date) AS prev_pos_status,
					ROW_NUMBER() OVER (PARTITION BY hipos_ps_id, hipos_pos_dp_id ORDER BY hipos_update_date DESC) AS rn
				FROM 
					" . $this->hr_db . ".hr_person_position_history
				WHERE 
					hipos_ps_id = 1
				ORDER BY hipos_end_date DESC
			),
			ChangesWithStatus AS (
				SELECT 
					hipos_ps_id,
					hipos_pos_dp_id,
					hipos_pos_status,
					hipos_start_date,
					hipos_end_date,
					hipos_pos_retire_id,
					hipos_update_date
				FROM 
					RankedChanges
				WHERE 
					hipos_pos_status != COALESCE(prev_pos_status, hipos_pos_status)
			),
			FinalChanges AS (
				SELECT 
					hipos_ps_id,
					hipos_pos_dp_id,
					hipos_pos_status,
					hipos_start_date,
					hipos_pos_retire_id,
					hipos_end_date,
					hipos_update_date
				FROM 
					RankedChanges
				WHERE 
					rn = 1
					OR hipos_update_date IN (SELECT hipos_update_date FROM ChangesWithStatus)
			)
			SELECT 
				p.ps_id,
				p.ps_fname,
				hipos_pos_dp_id,
				JSON_ARRAYAGG(
					JSON_OBJECT(
						'work_status', f.hipos_pos_status,
						'retire_name', retire.retire_name,
						'work_date', f.hipos_start_date,
						'work_end', f.hipos_end_date
					)
				ORDER BY f.hipos_update_date DESC) AS work_changes
			FROM 
				" . $this->hr_db . ".hr_person p
			JOIN 
				FinalChanges f ON p.ps_id = f.hipos_ps_id
			JOIN 
			    hr_base_retire retire on retire.retire_id = f.hipos_pos_retire_id
			GROUP BY 
				p.ps_id, p.ps_fname, hipos_pos_dp_id
			ORDER BY 
				p.ps_id, hipos_pos_dp_id;
			";
			$query = $this->hr->query($sql);
			return $query;
	}
}	 //=== end class M_hr_person_work_history
