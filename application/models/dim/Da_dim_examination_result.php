<?php

include_once("dim_model.php");

class Da_dim_examination_result extends dim_model {		

	// PK is exr_id
	public $exr_id;
	public $exr_pt_id;
	public $exr_ntr_id;
	public $exr_ap_id;
	public $exr_order;
	public $exr_round;
	public $exr_stde_id;
	public $exr_ps_id;
	public $exr_eqs_id;
	public $exr_inspection_time;
	public $exr_status;
	public $exr_directory;
	public $exr_ip_internet;
	public $exr_ip_computer;
	public $exr_create_user;
	public $exr_create_date;
	public $exr_update_user;
	public $exr_update_date;

	public $ums_db;
	public $hr_db;
	public $eqs_db;
	public $ams_db;
	public $que_db;

	public $last_insert_id;

	function __construct() {
		parent::__construct();
		$this->ums_db = $this->load->database('ums', TRUE)->database;
		$this->hr_db = $this->load->database('hr', TRUE)->database;
		$this->eqs_db = $this->load->database('eqs', TRUE)->database;
		$this->ams_db = $this->load->database('ams', TRUE)->database;
		$this->que_db = $this->load->database('que', TRUE)->database;
	}
	
	function insert() {
		// if there is no auto_increment field, please remove it
		$sql = "INSERT INTO dim_examination_result (exr_id, exr_pt_id, exr_ntr_id, exr_ap_id, exr_order, exr_round, exr_stde_id, exr_ps_id, exr_eqs_id, exr_inspection_time, exr_status, exr_directory, exr_ip_internet, exr_ip_computer, exr_create_user, exr_create_date) 
				VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW());";
		 
		$this->dim->query($sql, array($this->exr_id, $this->exr_pt_id, $this->exr_ntr_id, $this->exr_ap_id, $this->exr_order, $this->exr_round, $this->exr_stde_id, $this->exr_ps_id, $this->exr_eqs_id, $this->exr_inspection_time, $this->exr_status, $this->exr_directory, $this->exr_ip_internet, $this->exr_ip_computer, $this->exr_create_user));
		$this->last_insert_id = $this->dim->insert_id();
	}
	
	function update() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "UPDATE dim_examination_result 
				SET	exr_pt_id=?, exr_ntr_id=?, exr_ap_id=?, exr_order=?, exr_round=?, exr_stde_id=?, exr_ps_id=?, exr_eqs_id=?, exr_inspection_time=?, exr_status=?, exr_directory=?, exr_ip_internet=?, exr_ip_computer=?, exr_update_user=?, exr_update_date=NOW()
				WHERE exr_id=? ";	
		 
		$this->dim->query($sql, array($this->exr_pt_id, $this->exr_ntr_id, $this->exr_ap_id, $this->exr_order, $this->exr_round, $this->exr_stde_id, $this->exr_ps_id, $this->exr_eqs_id, $this->exr_inspection_time, $this->exr_status, $this->exr_directory, $this->exr_ip_internet, $this->exr_ip_computer, $this->exr_update_user, $this->exr_id));
	}
	
	function delete() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "DELETE FROM dim_examination_result
				WHERE exr_id=?";
		 
		$this->dim->query($sql, array($this->exr_id));
	}
	
	/*
	 * You have to assign primary key value before call this function.
	 */
	function get_by_key($withSetAttributeValue=FALSE) {	
		$sql = "SELECT * 
				FROM dim_examination_result 
				WHERE exr_id=?";
		$query = $this->dim->query($sql, array($this->exr_id));
		if ( $withSetAttributeValue ) {
			$this->row2attribute( $query->row() );
		} else {
			return $query ;
		}
	}
	
}	 //=== end class Da_dim_examination_result
?>
