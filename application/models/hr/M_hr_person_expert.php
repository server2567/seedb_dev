<?php
/*
 * M_hr_person_expert
 * Model for Manage about hr_person_expert Table.
 * @Author Tanadon
 * @Create Date 30/05/2024
 */
 
include_once("Da_hr_person_expert.php");
class M_hr_person_expert extends Da_hr_person_expert{
	
    /*
	* get_all_person_expert_data
	* ดึงข้อมูลรายการความชำนาญของบุคลากร
	* @input ps_id
	* $output expert all by ps_id
	* @author Tanadon Tangjaimongkhon
	* @Create Date 29/05/2024
	*/
	function get_all_person_expert_data($ps_id){
		$sql = "SELECT 
						expt_id,
						expt_ps_id,
						expt_detail_th,
						expt_detail_en,
						expt_title_th,
						expt_title_en
				FROM ".$this->hr_db.".hr_person_expert
				WHERE expt_ps_id = {$ps_id}";
		$query = $this->hr->query($sql);
		return $query;
	}
	// get_all_person_expert_data

	/*
	* get_expert_detail_by_id
	* ข้อมูลรายละเอียดความชำนาญตามไอดี
	* @input expt_id
	* $output expert all by expt_id
	* @author Tanadon Tangjaimongkhon
	* @Create Date 29/05/2024
	*/
	function get_expert_detail_by_id($expt_id){
		$sql = "SELECT 
						expt_id,
						expt_ps_id,
						expt_detail_th,
						expt_detail_en,
						expt_title_th,
						expt_title_en
				FROM ".$this->hr_db.".hr_person_expert
				WHERE expt_id = {$expt_id}";
		$query = $this->hr->query($sql);
		return $query;
	}
	// get_expert_detail_by_id
	
	
	
}	 //=== end class M_hr_person_expert
?>