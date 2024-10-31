<?php
/*
 * Da_hr_person_detail
 * Model for Manage about hr_structure_detail Table.
 * @Author Dechathon Prajit
 * @Create Date 2567-05-20
 */
include_once(dirname(__FILE__) . "/../hr_model.php");

class Da_hr_structure_person extends Hr_model
{

	// PK is psd_id
	public $stdp_id;
	public $stdp_stde_id;
	public $stdp_ps_id;
	public $stdp_po_id;
	public $stdp_seq;
	public $stdp_create_user;
	public $stdp_create_date;
	public $stdp_update_user;
	public $stdp_update_date;
	public $last_insert_id;


	function __construct()
	{
		parent::__construct();
	}

	function insert()
	{
		// if there is no auto_increment field, please remove it
		$sql = "INSERT INTO " . $this->hr_db . ".hr_structure_person (
			stdp_stde_id, stdp_ps_id,stdp_po_id,stdp_seq,stdp_active, stdp_create_user, 
			stdp_create_date
		) VALUES (
			 ?, ?, ?, ?, ?,?,?
		)";
		$this->hr->query($sql, array(
			$this->stdp_stde_id, $this->stdp_ps_id, $this->stdp_po_id, $this->stdp_seq, $this->stdp_active, $this->stdp_create_user,
			$this->stdp_create_date
		));
		$this->last_insert_id = $this->hr->insert_id();
	}

	function update()
	{
		// if there is no auto_increment field, please remove it
		$sql = "UPDATE " . $this->hr_db . ".hr_structure_person 
		SET  stdp_name_th =?, stdp_name_en =?, 
			stdp_desc = ?,stdp_po_id=?, stdp_level = ?,stdp_update_user = ?, stdp_update_date = ?
		    where stdp_id = ?";
		$this->hr->query($sql, array(
			$this->stdp_name_th, $this->stdp_name_en,
			$this->stdp_desc, $this->stdp_po_id, $this->stdp_level, $this->stdp_update_user, $this->stdp_update_date, $this->stdp_id
		));
	}
	function update_position()
	{
		$sql = "UPDATE " . $this->hr_db . ".hr_structure_person 
		SET  stdp_po_id =?,stdp_update_user = ?, stdp_update_date = ?
		WHERE stdp_id = ?";
		$this->hr->query($sql, array(
			$this->stdp_po_id, $this->stdp_update_user, $this->stdp_update_date, $this->stdp_id
		));
	}
	function update_person_seq()
	{
		$sql = "UPDATE " . $this->hr_db . ".hr_structure_person 
		SET  stdp_seq =?,stdp_update_user = ?
		WHERE stdp_id = ?";
		$this->hr->query($sql, array(
			$this->stdp_seq, $this->stdp_update_user,$this->stdp_id
		));
	}
	function delete()
	{
		// if there is no primary key, please remove WHERE clause.
		$sql = "DELETE FROM " . $this->hr_db . ".hr_structure_person
				WHERE stdp_id=?";
		$this->hr->query($sql, array($this->stdp_id));
	}
	function disabled()
	{
		// if there is no primary key, please remove WHERE clause.
		$sql = "UPDATE " . $this->hr_db . ".hr_structure_person
		        SET stdp_active=?
				WHERE stdp_id=?";
		$this->hr->query($sql, array($this->stdp_active, $this->stdp_id));
	}
}
