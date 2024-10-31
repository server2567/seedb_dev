<?php

include_once("wts_model.php");

class Da_wts_base_disease_time extends wts_model {		
	
	// PK is dst_id
	
	public $dst_id;
	public $dst_ds_id;
	public $dst_name_point;
	public $dst_name_point_en;
	public $dst_minute;
	public $dst_active;
	public $dst_create_user;
	public $dst_create_date;
    public $dst_update_user;
    public $dst_update_date;

    public $last_insert_id;

	function __construct() {
		parent::__construct();
	}
	
	function insert() {
		// if there is no auto_increment field, please remove it
		$sql = "INSERT INTO wts_base_disease_time (dst_id, dst_ds_id, dst_name_point, dst_name_point_en, dst_minute, 
                            dst_active, dst_create_user, dst_create_date, dst_update_user, dst_update_date)
				VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
		 
		$this->wts->query($sql, array(  $this->dst_id, $this->dst_ds_id, $this->dst_name_point, $this->dst_name_point_en, $this->dst_minute, 
                                        $this->dst_active, $this->dst_create_user, $this->dst_create_date, $this->dst_update_user, $this->dst_update_date));
		$this->last_insert_id = $this->wts->insert_id();
	}
	
	function update() {

 	$sql = "UPDATE wts_base_disease_time
        	SET dst_ds_id=?, dst_name_point=?, dst_name_point_en=?, dst_minute=?, dst_active=?, dst_update_user=?, dst_update_date=?
			WHERE dst_id=?";	
		 
		$this->wts->query($sql, array(  $this->dst_ds_id, $this->dst_name_point, $this->dst_name_point_en, $this->dst_minute, 
                                        $this->dst_active, $this->dst_update_user, $this->dst_update_date, $this->dst_id));
	}
	
	function delete() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "UPDATE wts_base_disease_time
				SET dst_active=?
				WHERE dst_id=?";
		 
		$this->wts->query($sql, array($this->dst_active, $this->dst_id));
	}
	
	/*
	 * You have to assign primary key value before call this function.
	 */
	function get_by_key($withSetAttributeValue=FALSE) {	
		$sql = "SELECT * 
				FROM wts_base_disease_time
				WHERE dst_id=?";
		$query = $this->wts->query($sql, array($this->dst_id));
		if ( $withSetAttributeValue ) {
			$this->row2attribute( $query->row() );
		} else {
			return $query ;
		}
	}
    function get_by_id($dst_id)
	{
		$sql ="SELECT *
				FROM wts_base_disease_time
				WHERE dst_id=?";
		$query = $this->wts->query($sql,$dst_id);
		return $query;
	}
}	 //=== end class Da_umsystem
?>
