<?php
/*
* m_hr_workforce_framework
* Model for Manage about hr_base_workforce_framework Table.
* @Author Tanadon Tangjaimongkhon
* @Create Date 10/09/2024
*/
include_once("Da_hr_workforce_framework.php");

class M_hr_workforce_framework extends Da_hr_workforce_framework{

	/*
	 * aOrderBy = array('fieldname' => 'ASC|DESC', ... )
	 */
	function get_all($aOrderBy=""){
		$orderBy = "";
		if ( is_array($aOrderBy) ) {
			$orderBy.= "ORDER BY ";
			foreach ($aOrderBy as $key => $value) {
				$orderBy.= "$key $value, ";
			}
			$orderBy = substr($orderBy, 0, strlen($orderBy)-2);
		}
		$sql = "SELECT *
				FROM ".$this->hr_db.".hr_prefix
				$orderBy";
		$query = $this->hr->query($sql);
		return $query;
	}

	/*
	* update active
	* update bwfw_active is "N"(not active) in database after form delete 
	* @input bwfw_id
	* @output -
	* @author Tanadon Tangjaimongkhon
	* @Create Date 10/09/2024
	*/
	function update_active($active){
		$sql = "UPDATE ".$this->hr_db.".`hr_base_workforce_framework` 
				SET `bwfw_active` = '".$active."' 
				WHERE `hr_base_workforce_framework`.`bwfw_id` = ?;";
		$query = $this->hr->query($sql,array($this->bwfw_id));
	}
	// update_active

	/*
	* get_all_by_active
	* ดึงข้อมูลทั้ง 2 สถานะ เปิดใช้งาน/ปิดใช้งาน
	* @input -
	* @output รายชื่อข้อมูล
	* @author Tanadon Tangjaimongkhon
	* @Create Date 10/09/2024
	*/
	function get_all_by_active($delete="2"){
		$sql = "SELECT * 
			FROM ".$this->hr_db.".hr_base_workforce_framework
			WHERE bwfw_active != '$delete'
			ORDER BY bwfw_name_th DESC";
		$query = $this->hr->query($sql);
		return $query;
	}
	// get_all_by_active

	/*
	* get_all_for_option
	* ดึงข้อมูลสถานะ เปิดใช้งาน [1]
	* @input -
	* @output รายชื่อข้อมูล
	* @author Tanadon Tangjaimongkhon
	* @Create Date 10/09/2024
	*/
	function get_all_for_option($active="1"){
		$sql = "SELECT * 
			FROM ".$this->hr_db.".hr_base_workforce_framework
			WHERE bwfw_active = '$active'
			ORDER BY bwfw_name_th DESC";
		$query = $this->hr->query($sql);
		return $query;
	}
	// get_all_for_option
	
	
	
} // end class M_hr_workforce_framework
?>
