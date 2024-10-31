<?php

include_once("Da_ums_logs.php");

class M_ums_logs extends Da_ums_logs {

	/*
	 * aOrderBy = array('fieldname' => 'ASC|DESC', ... )
	 */
	function get_all($filter){
		$sql = "SELECT l.log_changed, l.log_date, l.log_ip, us1.us_username, us1.us_name, pos.pos_ps_code
				FROM ums_logs l
				LEFT JOIN ums_user us1 ON us1.us_id = l.log_us_id
				LEFT JOIN ".$this->hr_db.".hr_person_position pos ON pos.pos_ps_id = us1.us_ps_id AND us1.us_dp_id = pos.pos_dp_id ";
		if(is_array($filter) && !empty($filter)) {
			$where = [];
			if (isset($filter['pos_ps_code']) && !empty($filter['pos_ps_code']))
				$where[] = " (pos.pos_ps_code LIKE '%".$filter['pos_ps_code']."%') ";
			if (isset($filter['us_username']) && !empty($filter['us_username']))
				$where[] = " (us1.us_username LIKE '%".$filter['us_username']."%') ";
			if (isset($filter['us_name']) && !empty($filter['us_name']))
				$where[] = " (us1.us_name LIKE '%".$filter['us_name']."%') ";
			if ((isset($filter['start_date']) && !empty($filter['start_date'])) || (isset($filter['end_date']) && !empty($filter['end_date']))) {
				$where[] = " ((l.log_date >= '".$filter['start_date']."' OR '".$filter['start_date']."' IS NULL)
							AND (l.log_date <= '".$filter['end_date']."' OR '".$filter['end_date']."' IS NULL)) ";
			}
			
			if(count($where) > 0) {
				$sql .= " WHERE ";
				for ($i = 0; $i < count($where); $i++) {
					$sql .= $where[$i];
					if(($i != 0) && ($i != count($where))) $sql .= " AND ";
				}
			}
		}
		$sql .= " GROUP BY l.log_changed, l.log_date, l.log_ip, us1.us_username, us1.us_name, pos.pos_ps_code ";
		$sql .= " ORDER BY l.log_date DESC "; 
		$query = $this->ums->query($sql);
		return $query;
	}
	
	// // add your functions here
	
	function insert_log($text) {
		// if there is no auto_increment field, please remove it
		$this->log_us_id = $this->session->userdata('us_id');
		$this->log_changed = $text;
		$this->log_ip = $_SERVER['REMOTE_ADDR'];
		$this->log_agent = detect_device_type();
		
		$qry = $this->insert();
		$this->last_insert_id = $this->ums->insert_id();
	}
} // end class M_ums_logs
?>
