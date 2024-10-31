<?php
/*
 * m_hr_person_position
 * Model for Manage about hr_person_position Table.
 * Copyright (c) 2559. Information System Engineering Research Laboratory.
 * @Author Chain_Chaiwat
 * @Create Date 2559-06-27
 */
include_once("Da_hr_person_position.php");

class M_hr_person_position extends Da_hr_person_position
{

	/*
	* get_position_by_ps_id
	* ดึงข้อมูลการทำงานของบุคลากร
	* @input ps_id
	* $output position all by ps_id
	* @author Tanadon Tangjaimongkhon
	* @Create Date 05/06/2024
	*/
	function get_position_by_ps_id($ps_id)
	{
		$sql = "SELECT *
				FROM " . $this->hr_db . ".hr_person_position
				WHERE pos_ps_id = {$ps_id}";
		$query = $this->hr->query($sql);
		return $query;
	}
	// get_position_by_ps_id

	/*
	* get_department_not_in_by_ps_id
	* ดึงข้อมูลหน่วยงานของบุคลากรที่ไม่ได้ถูกเลือก
	* @input ps_id
	* $output department not in all by ps_id
	* @author Tanadon Tangjaimongkhon
	* @Create Date 06/06/2024
	*/
	function get_department_not_in_by_ps_id($ps_id)
	{
		$sql = "SELECT dp_id, dp_name_th
				FROM " . $this->ums_db . ".ums_department
				WHERE dp_id NOT IN (
								SELECT pos_dp_id 
								FROM " . $this->hr_db . ".hr_person_position
								WHERE 	pos_ps_id = {$ps_id}
										AND pos_active = 'Y'
							)";
		$query = $this->hr->query($sql);
		return $query;
	}
	// get_department_not_in_by_ps_id

	/*
	* get_person_ums_department_by_ps_id
	* ข้อมูลหน่วยงานตามรหัสบุคลากร
	* @input -
	* @output get position by ums department
	* @author Tanadon Tangjaimongkhon
	* @Create Date 2567-05-23
	*/
	function get_person_ums_department_by_ps_id()
	{
		$sql = "SELECT 	
						dp.dp_id,
						dp.dp_name_th,
						pos.pos_id,
						pos.pos_active,
						pos.pos_status
				FROM " . $this->hr_db . ".hr_person_position as pos
				LEFT JOIN " . $this->ums_db . ".ums_department as dp 
					ON dp.dp_id = pos.pos_dp_id
				WHERE 	pos.pos_ps_id = ? 
						AND pos.pos_active = 'Y'";
		$query = $this->hr->query($sql, array($this->ps_id));
		return $query;
	}
	// get_person_ums_department_by_ps_id

	/*
	* get_person_position_by_ums_department_detail
	* ข้อมูลตำแหน่งงานตามหน่วยงานของบุคลากร
	* @input -
	* @output get position by ums department detail
	* @author Tanadon Tangjaimongkhon
	* @Create Date 2567-05-23
	*/
	function get_person_position_by_ums_department_detail($ps_id, $dp_id)
	{
		$sql = "SELECT 	
						pos.pos_id,
						pos.pos_dp_id,
						pos.pos_ps_code,
						pos.pos_admin_id,
						pos.pos_alp_id,
						pos.pos_spcl_id,
						pos.pos_hire_id,
						pos.pos_status,
						pos.pos_retire_id,
						pos.pos_work_start_date,
						pos.pos_work_end_date,
						pos.pos_desc,
						pos.pos_active,
						pos.pos_out_desc,
						pos.pos_attach_file,
						retire.retire_ps_status,
						retire.retire_name,
						ad.admin_name,
						alp.alp_name,
						spcl.spcl_name,
						hire.hire_name
						
				FROM " . $this->hr_db . ".hr_person_position as pos
				LEFT JOIN " . $this->hr_db . ".hr_base_admin_position as ad 
					ON pos.pos_admin_id = ad.admin_id
				LEFT JOIN " . $this->hr_db . ".hr_base_adline_position as alp
					ON pos.pos_alp_id = alp.alp_id
				LEFT JOIN " . $this->hr_db . ".hr_base_special_position as spcl
					ON pos.pos_spcl_id = spcl.spcl_id
				LEFT JOIN " . $this->hr_db . ".hr_base_hire as hire
					ON pos.pos_hire_id = hire.hire_id
				LEFT JOIN " . $this->hr_db . ".hr_base_retire as retire
				    ON pos.pos_retire_id = retire.retire_id
				WHERE 	pos.pos_ps_id = {$ps_id}
						AND pos.pos_dp_id = {$dp_id}
						AND pos.pos_active = 'Y'";
		$query = $this->hr->query($sql);
		return $query;
	}
	// get_person_position_by_ums_department_detail

	/*
	* get_person_position_count_work_now
	* ตรวจสอบจำนวน count_work ปัจจุบัน
	* @input 
	* $output 
	* @author Tanadon Tangjaimongkhon
	* @Create Date 06/06/2024
	*/
	function get_person_position_count_work_now(){
		$sql = "
			SELECT MAX(hipos_pos_count_work) AS max_count_work
			FROM " . $this->hr_db . ".hr_person_position_history
			WHERE hipos_ps_id = ? 
			AND hipos_pos_dp_id = ?
			AND hipos_pos_status = 2
		";
		$query = $this->hr->query($sql, array($this->pos_ps_id, $this->pos_dp_id));
		return $query;
	}
	// get_person_position_count_work_now

	/*
	* get_person_position_status_work
	* ตรวจสอบว่ามีการกลับมาทำงานหรือไม่
	* @input 
	* $output 
	* @author Tanadon Tangjaimongkhon
	* @Create Date 06/06/2024
	*/
	function get_person_position_status_work($max_count_work){
		$sql = "
		SELECT COUNT(*) AS count_work
			FROM " . $this->hr_db . ".hr_person_position_history
			WHERE hipos_ps_id = ? 
			AND hipos_pos_dp_id = ?
			AND hipos_pos_status = 2
			AND hipos_pos_count_work = ?
		";
		$query = $this->hr->query($sql, array($this->pos_ps_id, $this->pos_dp_id, $max_count_work));
		return $query;
	}
	// get_person_position_status_work


	/*
	* manage_triggers_position_history
	* ลบข้อมูลประวัติตำแหน่งงานของวันปัจจุบัน
	* @input 
	* $output 
	* @author Tanadon Tangjaimongkhon
	* @Create Date 06/06/2024
	*/
	function manage_triggers_position_history()
	{
		// ลบข้อมูลที่ตรงกับ hipos_ps_id และวันที่ปัจจุบัน
		$sql = "DELETE FROM " . $this->hr_db . ".hr_person_position_history
				WHERE hipos_ps_id=? 
				AND hipos_start_date = CURDATE() 
				AND hipos_end_date = CURDATE()";
		$this->hr->query($sql, array($this->pos_ps_id));

		// ลบข้อมูลที่มี hipos_start_date มากกว่า hipos_end_date เพื่อรักษาความถูกต้องของข้อมูล
		$sql = "DELETE FROM " . $this->hr_db . ".hr_person_position_history
				WHERE hipos_ps_id=? 
				AND hipos_start_date > hipos_end_date";
		$this->hr->query($sql, array($this->pos_ps_id));

		if ($this->pos_status == 1) {
				// กรณีที่ทำงานต่อเนื่องปกติ
				$sql = "
				UPDATE " . $this->hr_db . ".hr_person_position_history AS h
				JOIN (
					SELECT hipos_id
					FROM " . $this->hr_db . ".hr_person_position_history
					WHERE hipos_ps_id = ? 
					AND hipos_pos_dp_id = ?
					AND hipos_pos_count_work = (
						SELECT MAX(hipos_pos_count_work)
						FROM " . $this->hr_db . ".hr_person_position_history
						WHERE hipos_ps_id = ? 
						AND hipos_pos_dp_id = ?
					)
					ORDER BY hipos_start_date ASC
					LIMIT 1
				) AS sub
				ON h.hipos_id = sub.hipos_id
				SET h.hipos_start_date = ?
			";
			$this->hr->query($sql, array($this->pos_ps_id, $this->pos_dp_id, $this->pos_ps_id, $this->pos_dp_id, $this->pos_work_start_date));
		} else {
			// กรณีที่ผู้ใช้สิ้นสุดการทำงาน (pos_status != 1)

			// อัปเดต hipos_end_date โดยตั้งค่าให้เท่ากับ pos_work_end_date - 1 วัน
			$sql = "
				UPDATE " . $this->hr_db . ".hr_person_position_history AS h1
				JOIN (
					SELECT hipos_start_date, hipos_pos_work_end_date
					FROM " . $this->hr_db . ".hr_person_position_history
					WHERE hipos_ps_id = ? 
					AND hipos_pos_dp_id = ?
					ORDER BY hipos_start_date DESC
					LIMIT 1
				) h2 ON h1.hipos_end_date = h2.hipos_start_date
				SET h1.hipos_end_date = DATE_SUB(h2.hipos_pos_work_end_date, INTERVAL 1 DAY)
				WHERE h1.hipos_ps_id = ?
				AND h1.hipos_pos_dp_id = ?
			";
			$this->hr->query($sql, array($this->pos_ps_id, $this->pos_dp_id, $this->pos_ps_id, $this->pos_dp_id));

			// อัปเดต hipos_end_date โดยตั้งค่าให้เท่ากับ pos_work_end_date
			$sql = "
				UPDATE " . $this->hr_db . ".hr_person_position_history AS h
					SET h.hipos_start_date = ?
				WHERE h.hipos_ps_id = ? 
					AND h.hipos_pos_dp_id = ?
					AND h.hipos_pos_status = 2
				ORDER BY h.hipos_start_date DESC
				LIMIT 1
			";
			$this->hr->query($sql, array($this->pos_work_end_date, $this->pos_ps_id, $this->pos_dp_id));
		
		}		
	}
	// manage_triggers_position_history

	/*
	* manage_triggers_person_history
	* ลบข้อมูลประวัติบุคลากรของวันปัจจุบัน
	* @input 
	* $output 
	* @author Tanadon Tangjaimongkhon
	* @Create Date 06/06/2024
	*/
	function manage_triggers_person_history()
	{

		$sql = "DELETE FROM " . $this->hr_db . ".hr_person_history
                WHERE hips_ps_id=? 
				AND hips_start_date = CURDATE() 
				AND hips_end_date = CURDATE()";
		$this->hr->query($sql, array($this->pos_ps_id));

		$sql = "
				UPDATE " . $this->hr_db . ".hr_person_history AS h
				JOIN (
					SELECT hips_id
					FROM " . $this->hr_db . ".hr_person_history
					WHERE hips_ps_id = ?
					ORDER BY hips_start_date ASC
					LIMIT 1
				) AS sub
				ON h.hips_id = sub.hips_id
				SET h.hips_start_date = ?
			";
		$this->hr->query($sql, array($this->pos_ps_id, $this->pos_work_start_date));
	}
	// manage_triggers_person_history

	/*
	* insert_person_position
	* บันทึกตำแหน่งงานของบุคลากรตามหน่วยงานที่เลือก
	* @input 
	* $output 
	* @author Tanadon Tangjaimongkhon
	* @Create Date 06/06/2024
	*/
	function insert_person_position()
	{
		// if there is no auto_increment field, please remove it
		$sql = "INSERT INTO " . $this->hr_db . ".hr_person_position (
            pos_ps_id, pos_dp_id, pos_active,
			pos_create_user, pos_create_date
        ) VALUES (?, ?, ?, ?, ?)";
		$this->hr->query($sql, array(
			$this->pos_ps_id,
			$this->pos_dp_id,
			$this->pos_active,
			$this->pos_create_user,
			$this->pos_create_date
		));
		$this->last_insert_id = $this->hr->insert_id();
	}
	// insert_person_position

	/*
	* update_pos_active
	* อัพเดทสถานะการใช้งานตำแหน่งงาน
	* @input 
	* $output 
	* @author Tanadon Tangjaimongkhon
	* @Create Date 06/06/2024
	*/
	function update_pos_active()
	{
		$sql = "UPDATE " . $this->hr_db . ".hr_person_position
                SET
                    pos_active=?,
                    pos_update_user=?, pos_update_date=?
                WHERE pos_id=? AND pos_ps_id=? AND pos_dp_id=?";
		$this->hr->query($sql, array(
			$this->pos_active,
			$this->pos_update_user,
			$this->pos_update_date,
			$this->pos_id,
			$this->pos_ps_id,
			$this->pos_dp_id
		));
	}
	// update_pos_active

	function get_max_group_position($database, $gp_id)
	{
		$sql = "SELECT MAX(" . $gp_id . ") as gp FROM " . $this->hr_db . ".hr_person_" . $database;
		$query = $this->hr->query($sql);
		return $query;
	}
	function get_person_group_position_by_id($ps_id)
	{
		$sql = "SELECT pos_admin_id,pos_spcl_id  FROM " . $this->hr_db . ".hr_person_position WHERE pos_ps_id = '$ps_id'";
		$query = $this->hr->query($sql);
		return $query;
	}
	function get_admin_position_by_group($gp_id)
	{
		$sql = "SELECT *  FROM " . $this->hr_db . ".hr_person_admin_position as psap
		LEFT JOIN ".$this->hr_db.".hr_base_admin_position as admin on admin.admin_id = psap.psap_admin_id
		WHERE psap_pos_id = '$gp_id'";
		$query = $this->hr->query($sql);
		return $query;
	}
	function get_special_position_by_group($gp_id)
	{
		$sql = "SELECT *  FROM " . $this->hr_db . ".hr_person_special_position  as pssp
		LEFT JOIN ".$this->hr_db.".hr_base_special_position as spcl on spcl.spcl_id = pssp.pssp_spcl_id
		WHERE pssp_pos_id = '$gp_id'";
		$query = $this->hr->query($sql);
		return $query;
	}

	/*
	* get_person_position_ums_department_history
	* ข้อมูลหน่วยงานตามรหัสบุคลากร
	* @input -
	* @output get position by ums department
	* @author Tanadon Tangjaimongkhon
	* @Create Date 2567-07-15
	*/
	function get_person_position_ums_department_history()
	{
		$sql = "SELECT 	
						dp_id,
						dp_name_th
				FROM " . $this->hr_db . ".hr_person_position_history
				INNER JOIN " . $this->ums_db . ".ums_department 
					ON hipos_pos_dp_id = dp_id

				WHERE hipos_ps_id = ? 
				GROUP BY dp_id";
		$query = $this->hr->query($sql, array($this->pos_ps_id));
		return $query;
	}
	// get_person_position_ums_department_history

	/*
	* get_person_position_history_by_ps_id
	* ข้อมูลประวัติการทำงาน
	* @input -
	* @output get position by ums department
	* @author Tanadon Tangjaimongkhon
	* @Create Date 2567-07-15
	*/
	function get_person_position_history_by_ps_id($ps_id, $dp_id)
	{
		$sql = "SELECT h1.*, 
				GROUP_CONCAT(DISTINCT hr_base_admin_position.admin_name SEPARATOR ', ') AS ps_admin_name,
				GROUP_CONCAT(DISTINCT hr_base_special_position.spcl_name SEPARATOR ', ') AS ps_spcl_name,
				hr_base_adline_position.alp_name AS ps_alp_name,
				hr_base_retire.retire_name AS ps_retire_name,
				hr_base_hire.hire_name AS ps_hire_name,
				ums_user.us_name as ps_update_user

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
            LEFT JOIN {$this->ums_db}.ums_user
			    ON h1.hipos_update_user = ums_user.us_id
			WHERE h1.hipos_ps_id = {$ps_id}
				AND h1.hipos_pos_dp_id = {$dp_id}
			
			GROUP BY h1.hipos_id
			
			ORDER BY h1.hipos_id DESC";

		$query = $this->hr->query($sql);
		// echo $this->hr->last_query();
		return $query;
	}
	// get_person_position_history_by_ps_id


} // end class M_hr_person_position
