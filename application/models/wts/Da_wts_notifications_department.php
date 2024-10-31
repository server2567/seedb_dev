<?php
/*
* Da_wts_notifications_department
* Model for Manage about Dwts_notifications_department Table.
* @input -
* $output -
* @author Dechathon Prajit
* @Create Date 11/07/2024
*/
include_once("wts_model.php");

class Da_wts_notifications_department extends wts_model {		
	
	
	
	public $ntdp_id;
	public $ntdp_rdp_id;
	public $ntdp_ds_id;
	public $ntdp_dst_id;
	public $ntdp_apm_id;
	public $ntdp_seq;
    public $ntdp_date_start;
	public $ntdp_time_start;
	public $ntdp_date_end;
	public $ntdp_time_end;
    public $ntdp_sta_id;
    public $ntdp_in_out;
    public $ntdp_loc_cf_id;
    public $ntdp_loc_id;
    public $ntdp_loc_ft_Id;


	function __construct() {
		parent::__construct();
	}
	
	function insert() {
		// if there is no auto_increment field, please remove it
		$sql = "INSERT INTO see_wtsdb.wts_notifications_department (
                        ntdp_rdp_id, 
                        ntdp_ds_id, 
                        ntdp_dst_id, 
                        ntdp_apm_id,
                        ntdp_seq, 
                        ntdp_date_start, 
                        ntdp_time_start,
                        ntdp_date_end, 
                        ntdp_time_end, 
                        ntdp_sta_id ,
                        ntdp_in_out,
                        ntdp_loc_cf_id,
                        ntdp_loc_id,
                        ntdp_loc_ft_Id,
                        ntdp_function
                ) VALUES (
                    ?,?,?,?,?,?,?,?,?,?,?,?,?,?,?
                )";
		 
		$this->wts->query($sql, array(  
            $this->ntdp_rdp_id, 
            $this->ntdp_ds_id, 
            $this->ntdp_dst_id, 
            $this->ntdp_apm_id, 
            $this->ntdp_seq, 
            $this->ntdp_date_start, 
            $this->ntdp_time_start, 
            $this->ntdp_date_end, 
            $this->ntdp_time_end, 
            $this->ntdp_sta_id, 
            $this->ntdp_in_out, 
            $this->ntdp_loc_cf_id,
            $this->ntdp_loc_id,
            $this->ntdp_loc_ft_Id,
            $this->ntdp_function,
        ));
	}
	
	function update() {
		// if there is no primary key, please remove WHERE clause.
		$sql = "UPDATE 
                    see_wtsdb.wts_notifications_department
				SET	
                    ntdp_rdp_id=?, 
                    ntdp_ds_id=?, 
                    ntdp_dst_id=?, 
                    ntdp_apm_id=?, 
                    ntdp_seq=?, 
                    ntdp_date_start=?, 
                    ntdp_time_start=?,  
                    ntdp_date_end=?,
                    ntdp_time_end=?, 
                    ntdp_sta_id=?,
                    ntdp_in_out=?,
                    ntdp_loc_cf_id=?,
                    ntdp_loc_id=?,
                    ntdp_loc_ft_Id=?
                    ntdp_function=?
				WHERE 
                    ntdp_id=? ";	
		 
		$this->wts->query($sql, array(  
            $this->ntdp_rdp_id, 
            $this->ntdp_ds_id, 
            $this->ntdp_dst_id, 
            $this->ntdp_apm_id, 
            $this->ntdp_seq, 
            $this->ntdp_date_start, 
            $this->ntdp_time_start, 
            $this->ntdp_date_end, 
            $this->ntdp_time_end, 
            $this->ntdp_sta_id, 
            $this->ntdp_in_out, 
            $this->ntdp_loc_cf_id,
            $this->ntdp_loc_id,
            $this->ntdp_loc_ft_Id,
            $this->ntdp_function,
            $this->ntdp_id));
	}
	
	
}	 //=== end class Da_umsystem
?>
