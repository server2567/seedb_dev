<?php
/*
* Da_wts_base_qrcode
* Model for Manage about wts_base_disease Table.
* @input -
* $output -
* @author Supawee Sangrapee
* @Create Date 19/06/2024
*/
include_once("wts_model.php");

class Da_wts_qrcode_scan_patient extends wts_model {		
	
	// PK is ds_id
	
	public $qrsp_id;
	public $qrsp_pt_id;
	public $qrsp_qr_id;
	public $qrsp_dst_name;
	public $qrsp_data_time;
    public $last_insert_id;

	function __construct() {
		parent::__construct();
	}
	
	function insert() {
		// if there is no auto_increment field, please remove it
		$sql = "INSERT INTO wts_qrcode_scan_patient (qrsp_id, qrsp_pt_id, qrsp_qr_id, qrsp_dst_id, qrsp_date_time)
				VALUES(?, ?, ?, ?, ?)";
		 
		$this->wts->query($sql, array(  $this->qrsp_id, $this->qrsp_pt_id, $this->qrsp_qr_id, $this->qrsp_dst_id, 
                                        $this->qrsp_date_time
                                        ));
		$this->last_insert_id = $this->wts->insert_id();
	}
	
	function update() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "UPDATE wts_qrcode_scan_patient
				SET	qrsp_pt_id=?, qrsp_qr_id=?, qrsp_dst_id=?, qrsp_date_time=?
				WHERE qrsp_id=?";	
		 
		$this->wts->query($sql, array(  $this->qrsp_pt_id, $this->qrsp_qr_id, $this->qrsp_dst_id, 
                                        $this->qrsp_date_time, $this->qrsp_id));
	}
	
	function delete() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "DELETE FROM wts_qrcode_scan_patient
				WHERE qrsp_id=?";
		 
		$this->wts->query($sql, array($this->qrsp_id));
	}
	
	/*
	 * You have to assign primary key value before call this function.
	 */
	function get_by_key($withSetAttributeValue=FALSE) {	
		$sql = "SELECT * 
				FROM wts_base_disease
				WHERE ds_id=?";
		$query = $this->wts->query($sql, array($this->ds_id));
		if ( $withSetAttributeValue ) {
			$this->row2attribute( $query->row() );
		} else {
			return $query ;
		}
	}
    function get_by_id($qrsp_id)
	{
		$sql ="SELECT *
				FROM wts_base_disease
				WHERE ds_id=?";
		$query = $this->wts->query($sql,$qrsp_id);
		return $query;
	}
}	 //=== end class Da_umsystem
?>
