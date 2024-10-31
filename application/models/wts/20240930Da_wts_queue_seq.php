<?php
/*
* Da_wts_queue_seq
* Model for Manage about wts_queue_seq Table.
* @input -
* $output -
* @author Areerat Pongurai
* @Create Date 21/05/2024
pro
*/
include_once("wts_model.php");

class Da_wts_queue_seq extends wts_model {		
	
	// PK is -
	public $qus_psrm_id;
	public $qus_seq;
	public $qus_apm_id;
	public $qus_app_walk;

	function __construct() {
		parent::__construct();
	}
	
	function insert() {
		// if there is no auto_increment field, please remove it
		$sql = "INSERT INTO wts_queue_seq (qus_psrm_id, qus_seq, qus_apm_id, qus_app_walk)
				VALUES(?, ?, ?, ?)";
		 
		$this->wts->query($sql, array($this->qus_psrm_id, $this->qus_seq, $this->qus_apm_id, $this->qus_app_walk));
		$this->last_insert_id = $this->wts->insert_id();
	}
	
	// function update() {
	// 	// if there is no primary key, please remove WHERE clause.
	// 	$sql = "UPDATE wts_queue_seq
	// 			SET	qus_psrm_id=?, qus_seq=?
	// 			WHERE qus_apm_id=?";	
		 
	// 	$this->wts->query($sql, array($this->qus_psrm_id, $this->qus_seq, $this->qus_apm_id));
	// }
	
	// function delete() {
	// 	// if there is no primary key, please remove WHERE clause.
	// 	$sql = "DELETE FROM wts_queue_seq
	// 	WHERE qus_apm_id=?";
		 
	// 	$this->wts->query($sql, array($this->ds_active, $this->ds_id));
	// }
	
	// /*
	//  * You have to assign primary key value before call this function.
	//  */
	// function get_by_key($withSetAttributeValue=FALSE) {	
	// 	$sql = "SELECT * 
	// 			FROM wts_queue_seq
	// 			WHERE qus_apm_id=?";
	// 	$query = $this->wts->query($sql, array($this->ds_id));
	// 	if ( $withSetAttributeValue ) {
	// 		$this->row2attribute( $query->row() );
	// 	} else {
	// 		return $query ;
	// 	}
	// }
}	 //=== end class Da_umsystem
?>
