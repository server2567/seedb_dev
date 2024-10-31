<?php
function check_username($username)
{
  $sql = "SELECT count(UsLogin) as num
		  FROM umuser
		  WHERE UsLogin = ?";
  $query = $this->ums->query($sql, array($username));
  return $query->row()->num;
}
function get_lastid()
{
	$sql = "SELECT MAX(UsID) AS id FROM umuser";
	$query = $this->ums->query($sql);
	if($query->num_rows())
	{
		$row = $query->row();
		return $row->id;
	}
	else
	{
		return '0';
	}
}
function insert_ps() {
	$sql = "INSERT INTO umuser (UsID, UsName, UsLogin, UsPassword, UsPsCode, UsWgID, UsQsID, UsAnswer, UsEmail, UsActive, UsAdmin, UsDesc, UsPwdExpDt, UsUpdDt, UsUpdUsID, UsSessionID,UsDpID)
				VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?)";
		 
		$this->ums->query($sql, array($this->UsID, $this->UsName, $this->UsLogin, $this->UsPassword, $this->UsPsCode, $this->UsWgID, $this->UsQsID, $this->UsAnswer, $this->UsEmail, $this->UsActive, $this->UsAdmin, $this->UsDesc, $this->UsPwdExpDt, $this->UsUpdDt, $this->UsUpdUsID, $this->UsSessionID, $this->UsDpID));
		$this->last_insert_id = $this->ums->insert_id();

	$sql = "INSERT INTO umusergroup (UgID,UgGpID, UgUsID)
			VALUES(?,?, ?)";
	$this->ums->query($sql, array(($this->last_id_umu()+1),$this->config->item('eoff_group_ps'), $this->last_insert_id));

}
?>