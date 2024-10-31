<?php
/*
* Da_wts_base_disease
* Model for Manage about wts_base_disease Table.
* @input -
* $output -
* @author Supawee Sangrapee
* @Create Date 21/05/2024
*/
include_once("wts_model.php");

class Da_wts_base_disease extends wts_model {		
	
	// PK is ds_id
	
	public $ds_id;
	public $ds_name_disease_type;
	public $ds_name_disease_type_en;
	public $ds_name_disease;
	public $ds_name_disease_en;
	public $ds_detail;
	public $ds_detail_en;
	public $ds_active;
	public $ds_stde_id;
    public $ds_create_user;
    public $ds_create_date;
    public $ds_update_user;
    public $ds_update_date;

    public $last_insert_id;

	function __construct() {
		parent::__construct();
	}
	
	function insert() {
		// if there is no auto_increment field, please remove it
		$sql = "INSERT INTO wts_base_disease (ds_id, ds_name_disease_type, ds_name_disease_type_en, ds_name_disease, ds_name_disease_en, 
                            ds_detail, ds_detail_en, ds_active, ds_stde_id, ds_create_user, ds_create_date, ds_update_user, ds_update_date)
				VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
		 
		$this->wts->query($sql, array(  $this->ds_id, $this->ds_name_disease_type, $this->ds_name_disease_type_en, $this->ds_name_disease, $this->ds_name_disease_en, 
                                        $this->ds_detail, $this->ds_detail_en, $this->ds_active, $this->ds_stde_id, $this->ds_create_user, $this->ds_create_date, $this->ds_update_user,
                                        $this->ds_update_date));
		$this->last_insert_id = $this->wts->insert_id();
	}
	
	function update() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "UPDATE wts_base_disease
				SET	ds_name_disease_type=?, ds_name_disease_type_en=?, ds_name_disease=?, ds_name_disease_en=?, ds_detail=?, ds_detail_en=?, ds_active=?,  ds_stde_id=?,
                    ds_update_user=?, ds_update_date=?
				WHERE ds_id=?";	
		 
		$this->wts->query($sql, array(  $this->ds_name_disease_type, $this->ds_name_disease_type_en, $this->ds_name_disease, $this->ds_name_disease_en, 
                                        $this->ds_detail, $this->ds_detail_en, $this->ds_active, $this->ds_stde_id, $this->ds_update_user, $this->ds_update_date, $this->ds_id));
	}
	
	function delete() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "UPDATE wts_base_disease
				SET ds_active=?
				WHERE ds_id=?";
		 
		$this->wts->query($sql, array($this->ds_active, $this->ds_id));
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
    function get_by_id($ds_id)
	{
		$sql ="SELECT *
				FROM wts_base_disease
				WHERE ds_id=?";
		$query = $this->wts->query($sql,$ds_id);
		return $query;
	}
}	 //=== end class Da_umsystem
?>
