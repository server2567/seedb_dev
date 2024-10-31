<?php

include_once("Da_umlog.php");

class M_umlog extends Da_umlog{

	/*
	 * aOrderBy = array('fieldname' => 'ASC|DESC', ... )
	 */
	function get_all($aOrderBy=""){
		$orderBy = "";
		if ( is_array($aOrderBy) ) {
			$orderBy.= "ORDER BY "; 
			foreach ($aOrderBy as $key => $value) {
				$orderBy.= "$key $value, ";
			}
			$orderBy = substr($orderBy, 0, strlen($orderBy)-2);
		}
		$sql = "SELECT * 
				FROM ums_user_logs_login 
				$orderBy";
		$query = $this->ums->query($sql);
		return $query;
	}
	
	/*
	 * create array of pk field and value for generate select list in view, must edit PK_FIELD and FIELD_NAME manually
	 * the first line of select list is '-----àÅ×Í¡-----' by default.
	 * if you do not need the first list of select list is '-----àÅ×Í¡-----', please pass $optional parameter to other values. 
	 * you can delete this function if it not necessary.
	 */
	function get_options($optional='y') {
		$qry = $this->get_all();
		if ($optional=='y') $opt[''] = '-----กรุณาเลือก-----';
		foreach ($qry->result() as $row) {
			$opt[$row->PK_FIELD] = $row->FIELD_NAME;
		}
		return $opt;
	}

	function get_time_between($TimeFrom,$TimeTo)
	{
		$sql = "SELECT * FROM `ums_user_logs_login` 
		WHERE ul_us_id=? and date(ul_date) 
		between ? AND ?";// yy/mm/dd
		$query = $this->ums->query($sql,array($this->session->userdata('us_id'),$TimeFrom,$TimeTo));
		return $query;
	}
	
	function get_time_between_specific_user($TimeFrom,$TimeTo,$UsLogin,$UsName)
	{
		if($UsName)	
			$option = "and us_name like '%".$UsName."%' ";
		else
			$option = "";
		if($UsLogin)
			$option .="and us_username like '%".$UsLogin."%' ";
		else
			$option .= "";
		$sql = "SELECT * FROM ums_user_logs_login INNER JOIN ums_user
		ON ums_user.us_id=ums_user_logs_login.ul_us_id
		WHERE date(ul_date) 
		between ? AND ? ".$option;// yy/mm/dd
		$query = $this->ums->query($sql,array($TimeFrom,$TimeTo));
		// echo $this->ums->last_query();
		return $query;
	}
	
	function get_count(){
		$sql = "SELECT count(*) as many 
				FROM ums_user 
				";
		$query = $this->ums->query($sql);
		return $query;
	}
	
	function get_log_action_report($StNameT)
	{
		$option = "ul_changed like '%".$StNameT."' ";
		$sql = "SELECT * , date(ul_date) AS dateLOG 
				FROM ums_user_logs_login
				INNER JOIN ums_user ON ums_user.us_id = ul_us_id
				WHERE
         ul_date BETWEEN '2022-01-01 00:00:00.000000' AND NOW()
					AND ".$option;
		$query = $this->ums->query($sql);
		return $query;
	}
	
	function get_log_action_report_android()
	{
		$sql = "SELECT ul_us_id , ul_date , ul_changed  FROM ums_user_logs_login
					where ul_changed like 'เข้าใช้สิทธิ์%'";
		$query = $this->ums->query($sql);
		return $query->result_array();
	}
	
	function get_log_action_report_edit_android()
	{
		$sql = "SELECT ul_us_id , ul_date , ul_changed  FROM ums_user_logs_login
					where ul_changed like '%ข้อมูลลงในตาราง%'";
		$query = $this->ums->query($sql);
		return $query->result_array();
	}
	
	function get_last_login_by_us_id(){
		$sql = "
				SELECT * , date(ul_date) AS dateLOG 
					FROM ums_user_logs_login 
				WHERE 
          ul_us_id = ?
				ORDER BY ul_id DESC
				LIMIT 1
			";
		$query = $this->ums->query($sql,array($this->LogUsID));
		return $query;
	}

} // end class M_umlog
?>
