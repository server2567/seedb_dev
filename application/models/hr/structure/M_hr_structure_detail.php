<?php
/*
 * m_hr_structure_detail
 * Model for Manage about hr_structure_detail Table.
 * @Author Dechathon Prajit
 * @Create Date 2567-05-28
*/
include_once("Da_hr_structure_detail.php");

class M_hr_structure_detail extends Da_hr_structure_detail
{

	function get_all_by_level($level = "3")
	{
		$sql = "SELECT * 
				FROM " . $this->hr_db . ".hr_structure_detail 
				WHERE stde_level = '$level' ";
		$query = $this->hr->query($sql);
		return $query;
	}

	function get_name_th_by_id($id)
	{
		$sql = "SELECT stde_name_th
				FROM " . $this->hr_db . ".hr_structure_detail
				WHERE stde_id = '$id'";
		$query = $this->hr->query($sql);
		return $query;
	}
	function get_by_id($id)
	{
		$sql = "SELECT *
				FROM " . $this->hr_db . ".hr_structure_detail
				WHERE stde_id = '$id'";
		$query = $this->hr->query($sql);
		return $query;
	}
	function get_stde_check($stuc_id, $stde_seq,$active = 1)
	{
		$sql = "SELECT *
				FROM " . $this->hr_db . ".hr_structure_detail
				WHERE stde_stuc_id  = '$stuc_id' AND
				stde_seq LIKE '$stde_seq.%' AND stde_active = '$active'";
		$query = $this->hr->query($sql);
		return $query;
	}
	function get_stde_check_by_parent($parent_id,$active = 1)
	{
		$sql = "SELECT *
				FROM " . $this->hr_db . ".hr_structure_detail
				WHERE stde_parent  = '$parent_id' AND stde_active = '$active'
				ORDER BY stde_id DESC LIMIT 1";
		$query = $this->hr->query($sql);
		return $query;
	}
	function get_person_by_stde_id($stde_id,$active = 1)
	{
		$sql = "SELECT *
		FROM " . $this->hr_db . ".hr_structure_person
		WHERE stdp_stde_id  = '$stde_id' AND stdp_active = '$active'";
		$query = $this->hr->query($sql);
		return $query;
	}
	/*
	* get_all_by_level_from_dp_stuc
	* ดึงข้อมูลฝ่าย/แผนก(level 3) ของหน่วยงานที่เลือก
	* @input 
		dp_id: id หน่วยงาน
		is_medical: เป็นแผนกฝ่ายไหน (default ฝ่ายทางการแพทย์ stde_is_medical = 'Y')
		status: สถานะการใช้งาน(ที่ไม่ต้องการใช้) (default status = 2 => stde.stde_active != 2)
	* $output list of ฝ่าย/แผนก
	* @author Areerat Pongurai
	* @Create Date 10/06/2024
	*/
	function get_all_by_level_from_dp_stuc($dp_id, $is_medical = "Y", $status = '2')
	{
		$sql = "SELECT stde.*, stuc.stuc_dp_id 
				FROM " . $this->hr_db . ".hr_structure_detail stde
				LEFT JOIN " . $this->hr_db . ".hr_structure stuc ON stuc.stuc_id = stde.stde_stuc_id 
				WHERE stde.stde_is_medical = '$is_medical' AND stuc.stuc_dp_id = $dp_id 
				AND stde.stde_active != $status "; // AND stuc.stuc_status = 1
		$query = $this->hr->query($sql);
		return $query;
	}

	function get_stde_all_by_person_id($ps_id)
	{
		$sql = "SELECT *
		FROM " . $this->hr_db . ".hr_structure_person
		LEFT JOIN " . $this->hr_db . ".hr_structure_detail
		ON stdp_stde_id = stde_id
		LEFT JOIN " . $this->hr_db . ".hr_structure
		ON stde_stuc_id = stuc_id
		WHERE 	stdp_ps_id  = '$ps_id' 
				AND stdp_active = 1
				AND stde_active = 1
				AND stuc_status = 1
				AND stuc_dp_id = 1";
		$query = $this->hr->query($sql);
		return $query;
	}

	function get_stde_id_by_name($stde_name) {
		$sql = "SELECT stde_id
				FROM " . $this->hr_db . ".hr_structure_detail
				WHERE stde_name_th LIKE ?
				AND stde_active = '1'
				AND stde_is_medical = 'Y'";
		
		$query = $this->hr->query($sql, ["%$stde_name%"]);
		// echo $this->hr->last_query(); die;
		return $query->result_array(); // or $query->row() if expecting a single row
	}
	function get_max_seq($stde,$active = 1){
		$sql = "SELECT MAX(stdp_seq) as max_seq
		FROM ".$this->hr_db.".hr_structure_person 
		WHERE stdp_stde_id = ? AND stdp_active = ? LIMIT 1";
		$query = $this->hr->query($sql,array($stde,$active));
		return $query;
	}
} // end class M_hr_prefix
