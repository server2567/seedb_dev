<?php
/*
 * M_hr_person_reward
 * Model for Manage about hr_person_reward Table.
 * @Author Tanadon
 * @Create Date 30/05/2024
 */
 
include_once("Da_hr_person_reward.php");
class M_hr_person_reward extends Da_hr_person_reward{
	
    /*
	* get_all_person_reward_data
	* ดึงข้อมูลรายการรางวัล
	* @input ps_id
	* $output reward all by ps_id
	* @author Tanadon Tangjaimongkhon
	* @Create Date 30/05/2024
	*/
	function get_all_person_reward_data($ps_id){
		$sql = "SELECT 
						rewd_id,
						rewd_ps_id,
						rewd_rwt_id,
						rwt_name,
						rewd_rwlv_id,
						rwlv_name,
						rewd_name_th,
						rewd_name_en,
						rewd_year,
						rewd_date,
						rewd_org_th,
						rewd_org_en,
						rewd_reward_file,
						rewd_cert_file
				FROM ".$this->hr_db.".hr_person_reward
				LEFT JOIN ".$this->hr_db.".hr_base_reward_type
					ON rewd_rwt_id = rwt_id
				LEFT JOIN ".$this->hr_db.".hr_base_reward_level
					ON rewd_rwlv_id = rwlv_id
				WHERE rewd_ps_id = {$ps_id}
				ORDER BY rewd_year";
		$query = $this->hr->query($sql);
		return $query;
	}
	// get_all_person_reward_data

	/*
	* get_reward_detail_by_id
	* ข้อมูลรายละเอียดรางวัล
	* @input rewd_id
	* $output reward all by rewd_id
	* @author Tanadon Tangjaimongkhon
	* @Create Date 30/05/2024
	*/
	function get_reward_detail_by_id($rewd_id){
		$sql = "SELECT 
						rewd_id,
						rewd_ps_id,
						rewd_rwt_id,
						rwt_name,
						rewd_rwlv_id,
						rwlv_name,
						rewd_name_th,
						rewd_name_en,
						rewd_year,
						rewd_date,
						rewd_org_th,
						rewd_org_en,
						rewd_reward_file,
						rewd_cert_file
				FROM ".$this->hr_db.".hr_person_reward
				LEFT JOIN ".$this->hr_db.".hr_base_reward_type
					ON rewd_rwt_id = rwt_id
				LEFT JOIN ".$this->hr_db.".hr_base_reward_level
					ON rewd_rwlv_id = rwlv_id
				WHERE rewd_id = {$rewd_id}";
		$query = $this->hr->query($sql);
		return $query;
	}
	// get_reward_detail_by_id


	/*
	* get_year_reward
	* ข้อมูลปีรางวัล
	* @input ps_id
	* $output reward yearl all by ps_id
	* @author Tanadon Tangjaimongkhon
	* @Create Date 31/05/2024
	*/
	function get_year_reward($ps_id){
		$sql = "SELECT 
						rewd_id,
						rewd_year
				FROM ".$this->hr_db.".hr_person_reward
				WHERE rewd_ps_id = {$ps_id}
				GROUP BY rewd_year";
		$query = $this->hr->query($sql);
		return $query;
	}
	// get_year_reward

	/*
	* get_reward_by_year
	* ข้อมูลรายละเอียดรางวัลตามปีั
	* @input rewd_year
	* $output reward all by rewd_year
	* @author Tanadon Tangjaimongkhon
	* @Create Date 31/05/2024
	*/
	function get_reward_by_year($ps_id, $rewd_year){
		$sql = "SELECT 
						rewd_id,
						rewd_ps_id,
						rewd_rwt_id,
						rwt_name,
						rewd_rwlv_id,
						rwlv_name,
						rewd_name_th,
						rewd_name_en,
						rewd_year,
						rewd_date,
						rewd_org_th,
						rewd_org_en,
						rewd_reward_file,
						rewd_cert_file
				FROM ".$this->hr_db.".hr_person_reward
				LEFT JOIN ".$this->hr_db.".hr_base_reward_type
					ON rewd_rwt_id = rwt_id
				LEFT JOIN ".$this->hr_db.".hr_base_reward_level
					ON rewd_rwlv_id = rwlv_id
				WHERE rewd_year = {$rewd_year} AND rewd_ps_id = {$ps_id}";
		$query = $this->hr->query($sql);
		return $query;
	}
	// get_reward_by_year
	
	
	
}	 //=== end class M_hr_person_reward
?>