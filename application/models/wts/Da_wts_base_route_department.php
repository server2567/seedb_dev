<?php

include_once("wts_model.php");

class Da_wts_base_route_department extends wts_model {		
	
	// PK is dst_id
	
	public $rdp_id;
	public $rdp_stde_id;
	public $rdp_name;
	public $rdp_ds_id;
	public $rdp_active;
	public $rdp_create_user;
	public $rdp_create_date;
    public $rdp_update_user;
    public $rdp_update_date;

    public $last_insert_id;

	function __construct() {
		parent::__construct();
	}
	
	function insert() {
		// if there is no auto_increment field, please remove it
		$sql = "INSERT INTO wts_base_route_department (rdp_id, rdp_stde_id, rdp_name, rdp_ds_id, rdp_active, rdp_create_user, rdp_create_date, rdp_update_user, rdp_update_date)
				VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?)";
		 
		$this->wts->query($sql, array(  $this->rdp_id, $this->rdp_stde_id, $this->rdp_name, $this->rdp_ds_id, $this->rdp_active, $this->rdp_create_user, 
                                        $this->rdp_create_date, $this->rdp_update_user, $this->rdp_update_date));
		$this->last_insert_id = $this->wts->insert_id();
	}
	
	function update() {

 	$sql = "UPDATE wts_base_route_department
        	SET rdp_name=?, rdp_ds_id=?, rdp_stde_id=?, rdp_active=?, rdp_update_user=?, rdp_update_date=?
			WHERE rdp_id=?";	
		 
		$this->wts->query($sql, array(  $this->rdp_name, $this->rdp_ds_id, $this->rdp_stde_id, $this->rdp_active, $this->rdp_update_user, $this->rdp_update_date, 
                                        $this->rdp_id));
	}
	
	function delete() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "UPDATE wts_base_route_department
				SET rdp_active=?
				WHERE rdp_id=?";
		 
		$this->wts->query($sql, array($this->rdp_active, $this->rdp_id));
	}
	
	/*
	 * You have to assign primary key value before call this function.
	 */
	function get_by_key($withSetAttributeValue=FALSE) {	
		$sql = "SELECT * 
				FROM wts_base_route_department
				WHERE rdp_id=?";
		$query = $this->wts->query($sql, array($this->rdp_id));
		if ( $withSetAttributeValue ) {
			$this->row2attribute( $query->row() );
		} else {
			return $query ;
		}
	}
    function get_by_id($rdp_id)
	{
		$sql ="SELECT *
				FROM wts_base_route_department
				WHERE rdp_id=?";
		$query = $this->wts->query($sql,$rdp_id);
		return $query;
	}
}	 //=== end class Da_umsystem
?>
