   <?php

include_once("wts_model.php");

class Da_wts_base_route_time extends wts_model {		
	
	// PK is dst_id
	
	public $rt_id;
	public $rt_rdp_id;
	public $rt_seq;
	public $rt_dst_id;

    public $last_insert_id;

	function __construct() {
		parent::__construct();
	}
	
	function insert() {
		// if there is no auto_increment field, please remove it
		$sql = "INSERT INTO wts_base_route_time (rt_id, rt_rdp_id, rt_seq, rt_dst_id)
				VALUES(?, ?, ?, ?)";
		 
		$this->wts->query($sql, array($this->rt_id, $this->rt_rdp_id, $this->rt_seq, $this->rt_dst_id));
		$this->last_insert_id = $this->wts->insert_id();
	}

	
	function update() {

 	$sql = "UPDATE wts_base_route_time
        	SET rt_seq=?, rt_dst_id=?
			WHERE rt_id=?";	
		 
		$this->wts->query($sql, array($this-> rt_seq, $this->rt_dst_id, $this->rt_id));
	}
	
	function delete() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "DELETE FROM wts_base_route_time
				WHERE rt_id=?";
		 
		$this->wts->query($sql, array($this->rt_id));
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
