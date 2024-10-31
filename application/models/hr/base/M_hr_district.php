<?php
/*
* m_hr_district
* Model for Manage about hr_base_district Table.
* @Author Jiradat Pomyai
* @Create Date 30/05/2024
*/
include_once("Da_hr_district.php");

class m_hr_district extends Da_hr_district {

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
	 * create array of pk field and value for generate select list in view, must edit PK_FIELD and FIELD_NAME manually
	 * the first line of select list is '-----เลือก-----' by default.
	 * if you do not need the first list of select list is '-----เลือก-----', please pass $optional parameter to other values.
	 * you can delete this function if it not necessary.
	 */
	function get_options($optional='y') {
		$qry = $this->get_all();
		if ($optional=='y') $opt[''] = '-----เลือก-----';
		foreach ($qry->result() as $row) {
			$opt[$row->PK_FIELD] = $row->FIELD_NAME;
		}
		return $opt;
	}
	// add your functions here

	function get_max_pf_seq_no() {
		// if there is no auto_increment field, please remove it
		$sql = "SELECT MAX(`pf_seq_no`) AS max FROM ".$this->hr_db.".hr_prefix";
		$query = $this->hr->query($sql);
		if($query->row()){
			return $query->row()->max+1;
		}else{
			return 1;
		}
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
		$sql = "UPDATE ".$this->hr_db.".`hr_base_district` 
				SET `dist_active` = '".$active."' 
				WHERE `hr_base_district`.`dist_id` = ?;";
		$query = $this->hr->query($sql,array($this->dist_id));
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
				FROM ".$this->hr_db.".hr_base_district 
				WHERE dist_active != '$delete'
				ORDER BY dist_active DESC,dist_id DESC";
		$query = $this->hr->query($sql);
		return $query;
	}
	function filter_district($pv_id,$amph_id,$delete="2"){
		$sql = "SELECT * 
		        FROM ".$this->hr_db.".hr_base_district";
		if(!empty($amph_id)&& $amph_id != 'all' &&!empty($pv_id)){
        $sql = $sql." WHERE dist_amph_id ='$amph_id' AND dist_active != '$delete'";
		}else if(!empty($pv_id)){
			$sql = $sql." WHERE dist_pv_id ='$pv_id' AND dist_active != '$delete'";
		}else{
			$sql = $sql." WHERE dist_active !='$delete'";
		}
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
