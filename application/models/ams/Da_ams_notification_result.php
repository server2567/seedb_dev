<?php
/*
 * Da_ams_notification_result
 * Model for Manage about ams_notification_result Table.
 * @Author Dechathon prajit
 * @Create Date 20/06/2024
*/
include_once(dirname(__FILE__)."/ams_model.php");

class Da_ams_notification_result extends Ams_model {

	// PK is ntr_id

	public $ntr_id;
	public $ntr_apm_id;
	public $ntr_pt_id;
	public $ntr_ps_id;
	public $ntr_patient_treatment_type;
	public $ntr_recover_begin_date;
	public $ntr_recover_end_date;
	public $ntr_recover_total_days;
    public $ntr_detail_lab_med;
	public $ntr_detail_lab;
	public $ntr_detail_advice;
	public $ntr_ntf_id;
	public $ntr_upnr_id;
    public $ntr_al_id;
    public $ntr_ast_id;
	public $ntr_create_user;
	public $ntr_create_date;
	public $ntr_update_user;
    public $ntr_update_date;
	
	public $ums_db;
	public $hr_db;
	public $que_db;
	public $dim_db;
	public $eqs_db;

	public $last_insert_id;

	function __construct() {
		parent::__construct();

		$this->ums_db = $this->load->database('ums', TRUE)->database;
		$this->hr_db = $this->load->database('hr', TRUE)->database;
		$this->que_db = $this->load->database('que', TRUE)->database;
		$this->dim_db = $this->load->database('dim', TRUE)->database;
		$this->eqs_db = $this->load->database('eqs', TRUE)->database;
	}

	function insert() {
		// if there is no auto_increment field, please remove it
		$sql = "INSERT INTO ".$this->ams_db.".ams_notification_results (
			ntr_id,
			ntr_apm_id,
			ntr_pt_id,
			ntr_ps_id,
			ntr_patient_treatment_type,
			ntr_recover_begin_date,
			ntr_recover_end_date,
			ntr_recover_total_days,
			ntr_detail_lab_med,
			ntr_detail_lab,
			ntr_detail_advice,
			ntr_ntf_id,
			ntr_ast_id,
			ntr_create_user,
			ntr_create_date
		) VALUES (
			?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
		)";
		$this->ams->query($sql, array(
			$this->ntr_id,
			$this->ntr_apm_id,
			$this->ntr_pt_id,
			$this->ntr_ps_id,
			$this->ntr_patient_treatment_type,
			$this->ntr_recover_begin_date,
			$this->ntr_recover_end_date,
			$this->ntr_recover_total_days,
			$this->ntr_detail_lab_med,
			$this->ntr_detail_lab,
			$this->ntr_detail_advice,
			$this->ntr_ntf_id,
			$this->ntr_ast_id,
			$this->ntr_create_user,
			$this->ntr_create_date,
		));
		$this->last_insert_id = $this->ams->insert_id();
	}

	function update() {
		// Construct the SQL query for UPDATE
		$sql = "UPDATE ".$this->ams_db.".ams_notification_results 
                SET 
					ntr_patient_treatment_type = ?,
					ntr_recover_begin_date = ?,
					ntr_recover_end_date = ?,
					ntr_recover_total_days = ?,
                    ntr_detail_lab_med = ?, 
                    ntr_detail_lab = ?,
					ntr_detail_advice = ?,
					ntr_ast_id = ?,
                	ntr_update_user = ?, 
                    ntr_update_date = ?
                WHERE
                    ntr_id = ?";
		$this->ams->query($sql, array(
			$this->ntr_patient_treatment_type,
			$this->ntr_recover_begin_date,
			$this->ntr_recover_end_date,
			$this->ntr_recover_total_days,
			$this->ntr_detail_lab_med,
			$this->ntr_detail_lab,
			$this->ntr_detail_advice,
            $this->ntr_ast_id,
			$this->ntr_update_user,
			$this->ntr_update_date,
			$this->ntr_id
		));
		
	}
	
}    
?>
