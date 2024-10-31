<?php
/*
 * M_que_department
 * Model for Manage about que_base_department_keyword Table. Table.
 * @Author Dechathon Prajit 
 * @Create Date 17/05/2024
 */
include_once("Da_que_department.php");

class M_que_department extends Da_que_department {

	/*
	* get_all_by_active 
	* ข้อมูลหมายเลขติดตามทั้งหมด
	* @input -
	* @output all_department_tracking
	* @author Dechathon
	* @Create Date 2567-05-17
	*/
	function get_all_by_active($active="2") {
		$sql = "SELECT * ,
		        (SELECT us_name FROM see_umsdb.ums_user WHERE us_id = dpk_create_user) AS create_user_name,
                (SELECT us_name FROM see_umsdb.ums_user WHERE us_id = dpk_update_user) AS update_user_name
				FROM ".$this->que_db.".que_base_department_keyword
				WHERE dpk_active != '$active'";
		$query = $this->que->query($sql);
	
		// Fetching the results as an array
		
		return $query;       
	}

	/*
	* get_department_join_hr 
	* get all structure details that not save in que_base_department_keyword for create dropdown list, and get structure detail that used to save
	* @input 
		include_stde_id: some structure detail id that need to get for create dropdown list
		ps_id: hr_person id for scope to get some structure detail
	* @output structure details
	* @author Dechathon
	* @Create Date 2567-05-17
	* @Update Date 2567-07-04 Areerat Pongurai
	*/
	function get_department_join_hr($include_stde_id=null, $ps_id=null){
		// $sql = "SELECT hr.stde_id , hr.stde_name_th
		// 		FROM see_hrdb.hr_structure_detail AS hr
		// 		LEFT JOIN see_quedb.que_base_department_keyword AS que
		// 		ON hr.stde_id = que.dpk_stde_id AND que.dpk_active != '2'
		// 		WHERE que.dpk_stde_id IS NULL AND hr.stde_is_medical = 'Y' AND hr.stde_active ='1' ";
		$where = "";
		if(!empty($ps_id)) 
			$where .= " AND sp.stdp_ps_id = {$ps_id} ";
		if(!empty($include_stde_id)) 
			$where .= "  OR hr.stde_id = {$include_stde_id} ";
		
		$sql = "SELECT hr.stde_id , hr.stde_name_th
				FROM ".$this->hr_db.".hr_structure_detail hr
				LEFT JOIN ".$this->hr_db.".hr_structure_person sp ON hr.stde_id = sp.stdp_stde_id
				LEFT JOIN see_hrdb.hr_structure ON stde_stuc_id = stuc_id
				LEFT JOIN ".$this->que_db.".que_base_department_keyword que ON hr.stde_id = que.dpk_stde_id AND que.dpk_active != '2'
				WHERE que.dpk_stde_id IS NULL AND hr.stde_is_medical = 'Y' AND hr.stde_active ='1'  AND stuc_status = '1' {$where} 
				GROUP BY hr.stde_id , hr.stde_name_th ";
		$query = $this->que->query($sql);
		return $query;
	}

	/*
	* get_all_by_active_sorted_name 
	* ข้อมูลหมายเลขติดตามทั้งหมดเรียงตามชื่อ
	* @input -
	* @output all_department_tracking
	* @author Dechathon
	* @Create Date 2567-06-11
	*/
	function get_all_by_active_sorted_name ($active="2") {
		$sql = "SELECT * 
				FROM ".$this->que_db.".que_base_department_keyword
				WHERE dpk_active != '$active' 
				ORDER BY dpk_name ASC";
		$query = $this->que->query($sql);
	
		// Fetching the results as an array
		
		return $query;       
	}

	/*
	* get_all_by_active_and_person_sorted_name 
	* ข้อมูลหมายเลขติดตามทั้งหมดตามขอบเขตของ person_id เรียงตามชื่อ
	* @input 
		ps_id: hr_person id for scope to get some structure detail
	* @output all_department_tracking according to the scope of the ps_id
	* @author Areerat Pongurai
	* @Create Date 2567-07-04
	*/
	function get_all_by_active_and_person_sorted_name ($ps_id=null, $active="2") {
		$sql = "SELECT dpk.dpk_id, dpk.dpk_keyword, dpk.dpk_name, dpk.dpk_detail, dpk.dpk_update_user, dpk.dpk_create_user, dpk.dpk_update_date, dpk.dpk_create_date, dpk.dpk_active, 
                (SELECT us_name FROM see_umsdb.ums_user WHERE us_id = dpk.dpk_create_user) AS create_user_name,
                (SELECT us_name FROM see_umsdb.ums_user WHERE us_id = dpk.dpk_update_user) AS update_user_name
				FROM ".$this->que_db.".que_base_department_keyword dpk
					LEFT JOIN ".$this->hr_db.".hr_structure_person stdp ON stdp.stdp_stde_id = dpk.dpk_stde_id
				WHERE dpk_active != 2 AND stdp.stdp_ps_id = $ps_id 
				GROUP BY dpk.dpk_id, dpk.dpk_keyword, dpk.dpk_name, dpk.dpk_detail, dpk.dpk_update_user, dpk.dpk_create_user, dpk.dpk_update_date, dpk.dpk_create_date, dpk.dpk_active
				ORDER BY dpk_name ASC;";
		$query = $this->que->query($sql);
	
		// Fetching the results as an array
		
		return $query;       
	}

	/*
	* get_all_by_actvie 
	* ข้อมูลหมายเลขติดตามทั้งหมด
	* @input -
	* @output all_department_tracking
	* @author Dechathon
	* @Create Date 2567-05-17
	*/
	function get_all_by_id($id) {
		$sql = "SELECT dpk.*,
					(SELECT stde_name_th FROM see_hrdb.hr_structure_detail WHERE stde_id = dpk.dpk_stde_id) AS stde_name_th
				FROM ".$this->que_db.".que_base_department_keyword AS dpk
				WHERE dpk_id = '$id'";
		$query = $this->que->query($sql);
			
		return $query;
	}
	
	public function is_keyword_exists($keyword, $current_id = null) {
		$sql = "SELECT *
				FROM ".$this->que_db.".que_base_department_keyword
				WHERE dpk_keyword = ? AND dpk_active != 2";
				if ($current_id !== null) {
					$sql .= " AND dpk_id != ?";
					$query = $this->que->query($sql, array($keyword, $current_id));
				} else {
					$query = $this->que->query($sql, array($keyword));
				}
		return $query->num_rows() > 0;
	}
	public function is_department_exists($department, $current_id = null) {
		$sql = "SELECT * 
				FROM ".$this->que_db.".que_base_department_keyword
				WHERE dpk_stde_id = ? AND dpk_active != 2";
				if ($current_id !== null) {
					$sql .= " AND dpk_id != ?";
					$query = $this->que->query($sql, array($department, $current_id));
				} else {
					$query = $this->que->query($sql, array($department));
				}
		return $query->num_rows() > 0;
	}
	
	
	
} 
?>
