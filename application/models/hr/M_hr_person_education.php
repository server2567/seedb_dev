<?php
/*
 * M_hr_person_education
 * Model for managing the hr_person_education table.
 * Copyright (c) 2559. Information System Engineering Research Laboratory.
 * @Author Tanadon Tangjaimongkhon
 * @Create Date 2567-05-27
 */
include_once("Da_hr_person_education.php");

class M_hr_person_education extends Da_hr_person_education {
	
	
	/*
	* get_education_degree_by_edulv_id
	* ดึงข้อมูลระดับการศึกษาตามวุฒิการศึกษา
	* @input edulv_id
	* $output education degree list by edulv id
	* @author Tanadon Tangjaimongkhon
	* @Create Date 27/05/2024
	*/
	function get_education_degree_by_edulv_id($edulv_id){
		$sql = "SELECT 	
					edudg_id, 
					edudg_name,
					edudg_abbr
		FROM ".$this->hr_db.".hr_base_education_degree
				WHERE 	edudg_edulv_id = {$edulv_id}
						AND edudg_active = 1";
		$query = $this->hr->query($sql);
		return $query;
	}
	// get_education_degree_by_edulv_id

	/*
	* get_all_person_education_data
	* ดึงการศึกษาตามไอดีบุคลากร
	* @input ps_id
	* $output education all by ps_id
	* @author Tanadon Tangjaimongkhon
	* @Create Date 28/05/2024
	*/
	function get_all_person_education_data($ps_id)
	{
		$sql = "SELECT 
						edu_id,
						edu_highest,
						edu_ps_id,
						edu_seq,
						edulv_name,
						edudg_name,
						edudg_abbr,
						edumj_name,
						place_name,
						edu_start_date,
						edu_end_date,
						edu_start_year,
						edu_end_year,
						edu_attach_file
				FROM " . $this->hr_db . ".hr_person_education as edu
				LEFT JOIN " . $this->hr_db . ".hr_base_education_level as edulv 
					ON edulv.edulv_id = edu.edu_edulv_id
				LEFT JOIN " . $this->hr_db . ".hr_base_education_degree as edudg 
					ON edudg.edudg_id = edu.edu_edudg_id
				LEFT JOIN " . $this->hr_db . ".hr_base_education_major as edumj 
					ON edumj.edumj_id = edu.edu_edumj_id
				LEFT JOIN " . $this->hr_db . ".hr_base_place as edupl 
					ON edupl.place_id = edu.edu_place_id
				WHERE edu.edu_ps_id = {$ps_id}
							ORDER BY 
				CASE WHEN edu.edu_highest = 'Y' THEN 0 ELSE 1 END, -- Prioritize 'Y' before 'N'
				edu.edu_seq ASC;";
		$query = $this->hr->query($sql);
		return $query;
	}
	// get_all_person_education_data

		/*
	* get_education_detail_by_id
	* ดึงการศึกษาตามไอดีข้อมูล
	* @input edu_id
	* $output education all by edu_id
	* @author Tanadon Tangjaimongkhon
	* @Create Date 28/05/2024
	*/
	function get_education_detail_by_id($edu_id){
		$sql = "SELECT 
						edu_id,
						edu_ps_id,
						edulv_id,
						edudg_id,
						edumj_id,
						place_id,
						country_id,
						edu_start_date,
						edu_end_date,
						edu_start_year,
						edu_end_year,
						edu_highest,
						edu_admid,
						edu_edumjt_id,
						edu_hon_id,
						edu_attach_file
				FROM ".$this->hr_db.".hr_person_education as edu
				LEFT JOIN ".$this->hr_db.".hr_base_education_level as edulv 
					ON edulv.edulv_id = edu.edu_edulv_id
				LEFT JOIN ".$this->hr_db.".hr_base_education_degree as edudg 
					ON edudg.edudg_id = edu.edu_edudg_id
				LEFT JOIN ".$this->hr_db.".hr_base_education_major as edumj 
					ON edumj.edumj_id = edu.edu_edumj_id
				LEFT JOIN ".$this->hr_db.".hr_base_place as edupl 
					ON edupl.place_id = edu.edu_place_id
				LEFT JOIN ".$this->hr_db.".hr_base_country as country 
					ON country.country_id = edu.edu_country_id
				WHERE edu.edu_id = {$edu_id}";
		$query = $this->hr->query($sql);
		return $query;
	}
	// get_education_detail_by_id
	
} // end class M_hr_person_education
?>
