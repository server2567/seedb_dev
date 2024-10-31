<?php
/*
 * M_que_department
 * Model for Manage about que_base_department_queue Table.
 * @Author Dechathon Prajit 
 * @Create Date 17/05/2024
 */
include_once("Da_que_base_department_queue.php");

class M_que_base_department_queue extends Da_que_base_department_queue {

	/*
	* get_all_by_active 
	* ข้อมูลหมายเลขติดตามทั้งหมด
	* @input -
	* @output all_department_tracking
	* @author Dechathon
	* @Create Date 2567-07-19
	*/
	function get_all_by_active($active="2") {
		$sql = "SELECT dpq.* , create_user.us_name AS create_us , update_user.us_name AS update_us
				FROM ".$this->que_db.".que_base_department_queue AS dpq
				LEFT JOIN see_umsdb.ums_user AS create_user ON create_user.us_id = dpq.dpq_create_user
				LEFT JOIN see_umsdb.ums_user AS update_user ON update_user.us_id = dpq.dpq_update_user
				WHERE dpq.dpq_active != '$active'";
		$query = $this->que->query($sql);
	
		// Fetching the results as an array
		
		return $query;       
	}
	/*
	* get_department_join_hr 
	* get all structure details that not save in que_base_department_queue for create dropdown list, and get structure detail that used to save
	* @input 
		include_stde_id: some structure detail id that need to get for create dropdown list
		ps_id: hr_person id for scope to get some structure detail
	* @output structure details
	* @author Dechathon
	* @Create Date 2567-07-19
	*/
	function get_department_join_hr($dpk_stde_id =null){
		// $sql = "SELECT hr.stde_id , hr.stde_name_th
		// 		FROM see_hrdb.hr_structure_detail AS hr
		// 		LEFT JOIN see_quedb.que_base_department_keyword AS que
		// 		ON hr.stde_id = que.dpk_stde_id AND que.dpk_active != '2'
		// 		WHERE que.dpk_stde_id IS NULL AND hr.stde_is_medical = 'Y' AND hr.stde_active ='1' ";
		
		$sql = "SELECT *
				FROM see_hrdb.hr_structure_detail
				LEFT JOIN see_hrdb.hr_structure_person  ON stde_id = stdp_stde_id
				LEFT JOIN see_hrdb.hr_structure ON stde_stuc_id = stuc_id
				LEFT JOIN see_quedb.que_base_department_queue ON stde_id = dpq_stde_id AND dpq_active != '2'
				WHERE dpq_stde_id IS NULL AND stde_is_medical = 'Y' AND stde_active ='1' AND stuc_status = '1' OR stde_id = ?
				GROUP BY stde_id , stde_name_th";
		$query = $this->que->query($sql , array($dpk_stde_id));
		return $query;
	}
	function get_all_by_id($id) {
		$sql = "SELECT dpq.*,
					(SELECT stde_name_th FROM see_hrdb.hr_structure_detail WHERE stde_id = dpq.dpq_stde_id) AS stde_name_th
				FROM ".$this->que_db.".que_base_department_queue AS dpq
				WHERE dpq_id = '$id'";
		$query = $this->que->query($sql);
			
		return $query;
	}
	public function is_keyword_exists($keyword,$id) {
		$sql = "SELECT *
				FROM ".$this->que_db.".que_base_department_queue
				WHERE dpq_keyword = ? AND dpq_active != 2 AND dpq_id != ?";
		$query = $this->que->query($sql,array($keyword,$id));
		return $query->num_rows() > 0;
	}
	public function is_department_exists($department, $current_id = null) {
		$sql = "SELECT * 
				FROM ".$this->que_db.".que_base_department_queue
				WHERE dpq_stde_id = ? AND dpq_active != 2 ";
				if ($current_id !== null) {
					$sql .= " AND dpq_id != ?";
					$query = $this->que->query($sql, array($department, $current_id));
				} else {
					$query = $this->que->query($sql, array($department));
				}
		return $query->num_rows() > 0;
	}
	public function get_department_queue_by_id($id){
		$sql = "SELECT * 
				FROM ".$this->que_db.".que_base_department_queue
				WHERE dpq_id = ?";
		$query = $this->que->query($sql,array($id));
		return $query;
	}
	function get_all_by_active_and_person_sorted_name ( $active="2") {
		
		$sql = "SELECT dpq.dpq_id, dpq.dpq_keyword, dpq.dpq_name, dpq.dpq_detail, dpq.dpq_update_user, dpq.dpq_create_user, dpq.dpq_update_date, dpq.dpq_create_date, dpq.dpq_active
            FROM ".$this->que_db.".que_base_department_queue dpq
            LEFT JOIN ".$this->hr_db.".hr_structure_person stdp ON stdp.stdp_stde_id = dpq.dpq_stde_id
            WHERE dpq_active != 2 
			GROUP BY dpq.dpq_id, dpq.dpq_keyword, dpq.dpq_name, dpq.dpq_detail, dpq.dpq_update_user, dpq.dpq_create_user, dpq.dpq_update_date, dpq.dpq_create_date, dpq.dpq_active
            ORDER BY dpq.dpq_name ASC;";
		$query = $this->que->query($sql);
	
		// Fetching the results as an array
		
		return $query;       
	}
} 
?>
