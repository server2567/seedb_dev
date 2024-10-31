<?php

include_once("Da_ums_usergroup_history.php");

class M_ums_usergroup_history extends Da_ums_usergroup_history {
	
	/*
	 * aOrderBy = array('fieldname' => 'ASC|DESC', ... )
	 */
	function get_all($filter){
		$sql = "SELECT ughi.ughi_changed, ughi.ughi_date, us1.us_username, us1.us_name, us2.us_name modified_user, pos.pos_ps_code
				FROM ums_usergroup_history ughi
				LEFT JOIN ums_user us1 ON us1.us_id = ughi.ughi_us_id
				LEFT JOIN ums_user us2 ON us2.us_id = ughi.ughi_create_user
				LEFT JOIN ".$this->hr_db.".hr_person_position pos ON pos.pos_ps_id = us1.us_ps_id ";
		if(is_array($filter) && !empty($filter)) {
			$where = [];
			if (isset($filter['pos_ps_code']) && !empty($filter['pos_ps_code']))
				$where[] = " (pos.pos_ps_code LIKE '%".$filter['pos_ps_code']."%') ";
			if (isset($filter['us_username']) && !empty($filter['us_username']))
				$where[] = " (us1.us_username LIKE '%".$filter['us_username']."%') ";
			if (isset($filter['us_name']) && !empty($filter['us_name']))
				$where[] = " (us1.us_name LIKE '%".$filter['us_name']."%') ";
			if ((isset($filter['start_date']) && !empty($filter['start_date'])) || (isset($filter['end_date']) && !empty($filter['end_date']))) {
				$where[] = " ((ughi.ughi_date >= '".$filter['start_date']."' OR '".$filter['start_date']."' IS NULL)
							AND (ughi.ughi_date <= '".$filter['end_date']."' OR '".$filter['end_date']."' IS NULL)) ";
			}
			
			if(count($where) > 0) {
				$sql .= " WHERE ";
				for ($i = 0; $i < count($where); $i++) {
					$sql .= $where[$i];
					if(($i != 0) && ($i != count($where))) $sql .= " AND ";
				}
			}
		}
		$sql .= " GROUP BY ughi.ughi_changed, ughi.ughi_date, us1.us_username, us1.us_name, us2.us_name ";
		$sql .= " ORDER BY ughi.ughi_date DESC "; 
		$query = $this->ums->query($sql);
		return $query;
	}
	
	// // add your functions here
	
} // end class M_ums_usergroup_history
?>
