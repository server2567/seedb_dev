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

class Da_wts_base_qrcode extends wts_model {		
	
	// PK is ds_id
	
	public $qr_id;
	public $qr_stde_id;
	public $qr_img_name;
	public $qr_img_path;
	public $qr_link;
	public $qr_deatile;
	public $qr_create_user;
    public $qr_create_date;
    public $qr_update_user;
    public $qr_update_date;

    public $last_insert_id;

	function __construct() {
		parent::__construct();
	}
	
	function insert() {
		// if there is no auto_increment field, please remove it
		$sql = "INSERT INTO wts_base_qrcode (qr_id, qr_stde_id, qr_img_name, 
                            qr_img_path, qr_link, qr_deatile, qr_create_user, qr_create_date, qr_update_user, qr_update_date)
				VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
		 
		$this->wts->query($sql, array(  $this->qr_id, $this->qr_stde_id, $this->qr_img_name, 
                                        $this->qr_img_path, $this->qr_link, $this->qr_deatile, $this->qr_create_user, $this->qr_create_date, $this->qr_update_user, $this->qr_update_date
                                        ));
		$this->last_insert_id = $this->wts->insert_id();
	}
	
	function update() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "UPDATE wts_base_qrcode
				SET	 qr_stde_id=?, qr_img_name=?, qr_img_path=?, qr_link=?, qr_deatile=?,
                    qr_update_user=?, qr_update_date=?
				WHERE qr_id=?";	
		 
		$this->wts->query($sql, array(  $this->qr_stde_id, $this->qr_img_name, 
                                        $this->qr_img_path, $this->qr_link, $this->qr_deatile, $this->qr_update_user, $this->qr_update_date, $this->qr_id));
	}
	
	function delete() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "DELETE FROM wts_base_qrcode
				WHERE qr_id=?";
		 
		$this->wts->query($sql, array($this->qr_id));
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
