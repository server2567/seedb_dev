<?php
/*
 * M_hr_person_external_service
 * Model for Manage about hr_person_external_service Table.
 * @Author Tanadon Tangjaimongkhon
 * @Create Date 29/05/2024
 */
 
include_once("Da_hr_person_external_service.php");
class M_hr_person_external_service extends Da_hr_person_external_service{
	
	
	/*
	* get_all_external_service_data
	* ดึงข้อมูลรายการบริการหน่วยงานภายนอกของบุคลากร
	* @input ps_id
	* $output external service data by ps_id
	* @author Tanadon Tangjaimongkhon
	* @Create Date 29/05/2024
	*/
	function get_all_external_service_data($ps_id){
		$sql = "SELECT 
						pexs.pexs_id,
						pexs.pexs_ps_id,
						pexs.pexs_name_th,
						pexs.pexs_exts_id,
						pexs.pexs_date,
						pexs.pexs_place_id,
						place.place_name,
						pexs.pexs_attach_file,
						exts.exts_name_th,
						exts.exts_name_en
				FROM ".$this->hr_db.".hr_person_external_service as pexs
				LEFT JOIN ".$this->hr_db.".hr_base_external_service as exts 
					ON pexs.pexs_exts_id = exts.exts_id
				LEFT JOIN ".$this->hr_db.".hr_base_place as place 
					ON pexs.pexs_place_id = place.place_id
				WHERE pexs.pexs_ps_id = {$ps_id}
				ORDER BY pexs.pexs_date DESC";
		$query = $this->hr->query($sql);
		return $query;
	}
	// get_all_external_service_data

	/*
	* get_external_service_detail_by_id
	* ข้อมูลรายละเอียดบริการหน่วยงานภายนอกตามไอดี
	* @input pexs_id
	* $output external service data by pexs_id
	* @author Tanadon Tangjaimongkhon
	* @Create Date 29/05/2024
	*/
	function get_external_service_detail_by_id($pexs_id){
		$sql = "SELECT 
						pexs_id,
						pexs_name_th,
						pexs_exts_id,
						pexs_date,
						pexs_place_id,
						pexs_attach_file
				FROM ".$this->hr_db.".hr_person_external_service
				WHERE pexs_id = {$pexs_id}";
		$query = $this->hr->query($sql);
		return $query;
	}
	// get_external_service_detail_by_id

	/*
	* get_latest_external_service_data
	* ดึงข้อมูลรายการบริการหน่วยงานภายนอกล่าสุดของบุคลากรรายเดียว
	* @input ps_id
	* $output latest external service data by ps_id
	* @author Tanadon Tangjaimongkhon
	* @Create Date 07/08/2024
	*/
	function get_latest_external_service_data($ps_id){
		$sql = "SELECT 
						pexs.pexs_id,
						pexs.pexs_ps_id,
						pexs.pexs_name_th,
						pexs.pexs_exts_id,
						pexs.pexs_date,
						pexs.pexs_place_id,
						place.place_name,
						pexs.pexs_attach_file,
						exts.exts_name
				FROM ".$this->hr_db.".hr_person_external_service as pexs
				LEFT JOIN ".$this->hr_db.".hr_base_external_service as exts 
					ON pexs.pexs_exts_id = exts.exts_id
				LEFT JOIN ".$this->hr_db.".hr_base_place as place 
					ON pexs.pexs_place_id = place.place_id
				WHERE pexs.pexs_ps_id = {$ps_id}
				ORDER BY pexs.pexs_date DESC
				LIMIT 1";
		$query = $this->hr->query($sql);
		return $query;
	}
	// get_latest_external_service_data
	
}	 //=== end class M_hr_person_external_service
?>
