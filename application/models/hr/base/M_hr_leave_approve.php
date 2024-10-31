<?php
/*
* M_hr_religion
* Model for Manage about hr_base_religion Table.
* @Author Jiradat Pomyai
* @Create Date 30/05/2024
*/
include_once("Da_hr_leave_approve.php");

class M_hr_leave_approve extends Da_hr_leave_approve {

	/*
	 * aOrderBy = array('fieldname' => 'ASC|DESC', ... )
	 */
	function get_by_id(){
		$sql = "SELECT *
				FROM ".$this->hr_db.".hr_base_leave_approve_status
				WHERE last_id = ?";
		$query = $this->hr->query($sql,array($this->last_id));
		return $query;
	}
	/*
	* update active
	* update pf_active is "N"(not active) in database after form delete 
	* @input pf_id
	* @output -
	* @author Sarun
	* @Create Date 2559-06-22
	*/
	function update_active($active){
		$sql = "UPDATE ".$this->hr_db.".`hr_base_religion` 
				SET `pf_active` = '".$active."' 
				WHERE `hr_prefix`.`pf_id` = ?;";
		$query = $this->hr->query($sql,array($this->pf_id));
	}

	/*
	* get_all_by_active
	* ดึงข้อมูลทั้ง 2 สถานะ เปิดใช้งาน/ปิดใช้งาน
	* @input -
	* @output รายชื่อข้อมูล
	* @author Jiradat Pomyai
	* @Create Date 2567-05-30
	*/
	function get_all_by_active($delete="2"){
		$sql = "SELECT * 
				FROM ".$this->hr_db.".hr_base_leave_approve_status 
				WHERE last_active != '$delete'
				ORDER BY last_active DESC,last_id DESC";
		$query = $this->hr->query($sql);
		return $query;
	}
	
	/*
	* for json datatable
	* @input pf_active
	* @output prefix data
	* @author Phanuphan
	* @Create Date 2559-10-19
	*/
	function json_prefix($cond='', $aColumns='', $sWhere='', $sOrder='', $sLimit='') { 
		$con = '';
		//if($s_partyId!='') $con .= "AND ps.partyId = ".$s_partyId;
		//if($cond!='') $cond =" AND ".$cond; else $cond =" AND ps.fStatus = 1";
		$sql = "SELECT
					SQL_CALC_FOUND_ROWS ".str_replace(" , ", " ", implode(", ", $aColumns))."
				FROM 
					".$this->hr_db.".hr_prefix
				WHERE
					1 $sWhere
				$sOrder $sLimit";
		$query = $this->db->query($sql);		
		return $query ;
	}
	
	/*
	* get_prefix_pos
	* @input -
	* @output *
	* @author Ilada Paisarn
	* @Create Date 2559-10-25
	*/
	function get_prefix_pos() { 
		$sql = "SELECT * FROM ".$this->hr_db.".hr_prefix
				WHERE pf_name LIKE '%ศาสตราจารย์%' ";
		$query = $this->db->query($sql);		
		return $query ;
	}
	
	
	
} // end class M_hr_prefix
?>
