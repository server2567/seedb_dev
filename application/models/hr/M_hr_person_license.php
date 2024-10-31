<?php
/*
 * M_hr_person_license
 * Model for Manage about hr_person_license Table.
 * @Author Tanadon
 * @Create Date 29/05/2024
 */
 
include_once("Da_hr_person_license.php");
class M_hr_person_license extends Da_hr_person_license{
	
	
	/*
	* get_all_person_license_data
	* ดึงข้อมูลรายการใบประกอบวิชาชีพของบุคลากร
	* @input ps_id
	* $output license all by ps_id
	* @author Tanadon Tangjaimongkhon
	* @Create Date 29/05/2024
	*/
	function get_all_person_license_data($ps_id){
		$sql = "SELECT 
						licn.licn_id,
						licn.licn_code,
						licn.licn_start_date,
						licn.licn_end_date,
						licn.licn_ps_id,
						licn.licn_voc_id,
						licn.licn_attach_file,
						voc.voc_name
				FROM ".$this->hr_db.".hr_person_license as licn
				LEFT JOIN ".$this->hr_db.".hr_base_vocation as voc 
					ON licn.licn_voc_id = voc.voc_id
				WHERE licn.licn_ps_id = {$ps_id}
				ORDER BY licn.licn_end_date DESC";
		$query = $this->hr->query($sql);
		return $query;
	}
	// get_all_person_license_data

	/*
	* get_license_detail_by_id
	* ข้อมูลรายละเอียดใบประกอบวิชาชีพตามไอดี
	* @input licn_id
	* $output license all by licn_id
	* @author Tanadon Tangjaimongkhon
	* @Create Date 29/05/2024
	*/
	function get_license_detail_by_id($licn_id){
		$sql = "SELECT 
						licn_id,
						licn_code,
						licn_start_date,
						licn_end_date,
						licn_ps_id,
						licn_voc_id,
						licn_attach_file
				FROM ".$this->hr_db.".hr_person_license
				WHERE licn_id = {$licn_id}";
		$query = $this->hr->query($sql);
		return $query;
	}
	// get_license_detail_by_id

	/*
	* get_person_license_data
	* ดึงข้อมูลรายการใบประกอบวิชาชีพของบุคลากรรายกรเดียว
	* @input ps_id
	* $output license all by ps_id
	* @author Tanadon Tangjaimongkhon
	* @Create Date 07/08/2024
	*/
	function get_person_license_data($ps_id){
		$sql = "SELECT 
						licn.licn_id,
						licn.licn_code,
						licn.licn_start_date,
						licn.licn_end_date,
						licn.licn_ps_id,
						licn.licn_voc_id,
						licn.licn_attach_file,
						voc.voc_name
				FROM ".$this->hr_db.".hr_person_license as licn
				LEFT JOIN ".$this->hr_db.".hr_base_vocation as voc 
					ON licn.licn_voc_id = voc.voc_id
				WHERE licn.licn_ps_id = {$ps_id}
				ORDER BY licn.licn_end_date DESC
				LIMIT 1";
		$query = $this->hr->query($sql);
		return $query;
	}
	// get_person_license_data
	
}	 //=== end class M_hr_person_license
?>