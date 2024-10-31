<?php

include_once("Da_hr_logs.php");

class M_hr_logs extends Da_hr_logs{

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
				FROM hr_logs 
				$orderBy";
		$query = $this->hr->query($sql);
		return $query;
	}

	function get_log_agent_group()
	{
		$sql = "SELECT log_agent 
		FROM ".$this->hr_db.".hr_logs
		GROUP BY log_agent";// yy/mm/dd
		$query = $this->hr->query($sql);
		return $query;
	}


	function get_log_list_by_param($start_date, $end_date, $agent)
	{
		$cond = "";
		if($agent != 'all'){
			$cond = "AND log_agent = '{$agent}'";
		}
		$sql = "SELECT * 
		FROM ".$this->hr_db.".hr_logs
		LEFT JOIN ".$this->ums_db.".ums_user
			ON	log_us_id = us_id
		LEFT JOIN ".$this->hr_db.".hr_person
			ON	us_ps_id = ps_id
		LEFT JOIN ".$this->hr_db.".hr_base_prefix
			ON	ps_pf_id = pf_id
		WHERE date(log_date) between ? AND ? {$cond}";// yy/mm/dd
		$query = $this->hr->query($sql,array($start_date,$end_date));
		// echo $this->hr->last_query();
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
		$sql = "SELECT * FROM `hr_logs` 
		WHERE log_us_id=? and date(log_date) 
		between ? AND ?";// yy/mm/dd
		$query = $this->hr->query($sql,array($this->session->userdata('us_id'),$TimeFrom,$TimeTo));
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
		$sql = "SELECT * FROM hr_logs INNER JOIN ums_user
		ON ums_user.us_id=hr_logs.log_us_id
		WHERE date(log_date) 
		between ? AND ? ".$option;// yy/mm/dd
		$query = $this->hr->query($sql,array($TimeFrom,$TimeTo));
		// echo $this->hr->last_query();
		return $query;
	}
	
	function get_count(){
		$sql = "SELECT count(*) as many 
				FROM ums_user 
				";
		$query = $this->hr->query($sql);
		return $query;
	}
	
	function get_log_action_report($StNameT)
	{
		$option = "log_changed like '%".$StNameT."' ";
		$sql = "SELECT * , date(log_date) AS dateLOG 
				FROM hr_logs
				INNER JOIN ums_user ON ums_user.us_id = log_us_id
				WHERE
         log_date BETWEEN '2022-01-01 00:00:00.000000' AND NOW()
					AND ".$option;
		$query = $this->hr->query($sql);
		return $query;
	}
	
	function get_log_action_report_android()
	{
		$sql = "SELECT log_us_id , log_date , log_changed  FROM hr_logs
					where log_changed like 'เข้าใช้สิทธิ์%'";
		$query = $this->hr->query($sql);
		return $query->result_array();
	}
	
	function get_log_action_report_edit_android()
	{
		$sql = "SELECT log_us_id , log_date , log_changed  FROM hr_logs
					where log_changed like '%ข้อมูลลงในตาราง%'";
		$query = $this->hr->query($sql);
		return $query->result_array();
	}
	
	function get_last_login_by_us_id(){
		$sql = "
				SELECT * , date(log_date) AS dateLOG 
					FROM hr_logs 
				WHERE 
          log_us_id = ?
				ORDER BY log_id DESC
				LIMIT 1
			";
		$query = $this->hr->query($sql,array($this->LogUsID));
		return $query;
	}
	// add your functions here
} // end class M_hr_logs
?>
