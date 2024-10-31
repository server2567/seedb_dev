<?php

include_once("Da_dim_examination_result_doc_bin.php");

class M_dim_examination_result_doc_bin extends Da_dim_examination_result_doc_bin {

	function get_all_with_detail($owner_user_id){
		$sql = "SELECT exrd.exrd_file_name, eqs.eqs_name, exrdb.exrdb_status, exr.exr_id, exr.exr_directory, exrdb.exrdb_exrd_id, exrdb.exrdb_expiration_date, exrdb.exrdb_recover_date, 
					CONCAT(dp.dp_name_th, '/', stde.stde_name_th) dp_stde_name, 
					CONCAT(pt.pt_prefix, pt.pt_fname, ' ', pt.pt_lname) pt_full_name, pt.pt_member, apm.apm_visit
				FROM dim_examination_result_doc_bin exrdb
				LEFT JOIN dim_examination_result_doc exrd ON exrd.exrd_id = exrdb.exrdb_exrd_id
				LEFT JOIN dim_examination_result exr ON exr.exr_id = exrd.exrd_exr_id
				LEFT JOIN ".$this->ams_db.".ams_notification_results ntr ON ntr.ntr_id = exr.exr_ntr_id
				LEFT JOIN ".$this->que_db.".que_appointment apm ON apm.apm_id = ntr.ntr_apm_id
				LEFT JOIN ".$this->ums_db.".ums_patient pt ON pt.pt_id = exr.exr_pt_id
				LEFT JOIN ".$this->eqs_db.".eqs_equipments eqs ON eqs.eqs_id = exr.exr_eqs_id 
				LEFT JOIN ".$this->hr_db.".hr_person ps ON ps.ps_id = exr.exr_ps_id
				LEFT JOIN ".$this->hr_db.".hr_structure_detail stde ON stde.stde_id = exr.exr_stde_id
				LEFT JOIN ".$this->hr_db.".hr_structure stuc ON stuc.stuc_id = stde.stde_stuc_id
				LEFT JOIN ".$this->ums_db.".ums_department dp ON dp.dp_id = stuc.stuc_dp_id
				WHERE COALESCE(exr.exr_update_user , exr.exr_create_user ) = ".$owner_user_id." 
				GROUP BY exrd.exrd_file_name, eqs.eqs_name, exrdb.exrdb_status, exrdb.exrdb_exrd_id, exrdb.exrdb_expiration_date, exrdb.exrdb_recover_date, 
					CONCAT(dp.dp_name_th, '/', stde.stde_name_th), 
					CONCAT(pt.pt_prefix, pt.pt_fname, ' ', pt.pt_lname), pt.pt_member, apm.apm_visit
				ORDER BY exrdb.exrdb_expiration_date DESC ";
		$query = $this->dim->query($sql);
		return $query;
	}

	function update_status_files() {
		$sql = "UPDATE dim_examination_result_doc_bin 
				SET	exrdb_status = ?, exrdb_recover_date = NOW()
				WHERE exrdb_exrd_id = ? ";
		$query = $this->dim->query($sql, array($this->exrdb_status, $this->exrdb_exrd_id));
	}
	
} // end class M_dim_examination_result_doc_bin
?>
