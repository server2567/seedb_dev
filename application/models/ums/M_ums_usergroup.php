<?php

include_once("Da_ums_usergroup.php");

class M_ums_usergroup extends Da_ums_usergroup {
	
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
				FROM ums_usergroup 
				$orderBy";
		$query = $this->ums->query($sql);
		return $query;
	}
	
	/*
	 * create array of pk field and value for generate select list in view, must edit PK_FIELD and FIELD_NAME manually
	 * the first line of select list is '-----เลือก-----' by default.
	 * if you do not need the first list of select list is '-----เลือก-----', please pass $optional parameter to other values. 
	 * you can delete this function if it not necessary.
	 */
	function get_options($optional='y') {
		$qry = $this->get_all();
		if ($optional=='y') $opt[''] = '-----เลือก-----';
		foreach ($qry->result() as $row) {
			$opt[$row->PK_FIELD] = $row->FIELD_NAME;
		}
		return $opt;
	}
	
	// // add your functions here
	
	function delete_by_user_id() {
		$sql = "DELETE FROM ums_usergroup
				WHERE ug_us_id=?";
		 
		$this->ums->query($sql, array($this->ug_us_id));
	}
	
	function get_by_user_id($withSetAttributeValue=FALSE) {	
		$sql = "SELECT * 
				FROM ums_usergroup 
				WHERE ug_us_id=?";
		$query = $this->ums->query($sql, array($this->ug_us_id));
		if ( $withSetAttributeValue ) {
			$this->row2attribute( $query->row() );
		} else {
			return $query ;
		}
	}

	function get_groups_by_user_id($aOrderBy="") {	
		$orderBy = "";
		if ( is_array($aOrderBy) ) {
			$orderBy.= "ORDER BY "; 
			foreach ($aOrderBy as $key => $value) {
				$orderBy.= "$key $value, ";
			}
			$orderBy = substr($orderBy, 0, strlen($orderBy)-2);
		}
		$sql = "SELECT * 
				FROM ums_usergroup ug
				LEFT JOIN ums_group gp ON ug.ug_gp_id = gp.gp_id
				LEFT JOIN ums_system st ON gp.gp_st_id = st.st_id
				WHERE ug_us_id=? 
				$orderBy";
		$query = $this->ums->query($sql, array($this->ug_us_id));
		return $query;
	}

	function get_users_by_group_id($aOrderBy="") {	
		$orderBy = "";
		if ( is_array($aOrderBy) ) {
			$orderBy.= "ORDER BY "; 
			foreach ($aOrderBy as $key => $value) {
				$orderBy.= "$key $value, ";
			}
			$orderBy = substr($orderBy, 0, strlen($orderBy)-2);
		}
		$sql = "SELECT * 
				FROM ums_usergroup ug
				LEFT JOIN ums_user us ON us.us_id = ug.ug_us_id
				WHERE ug.ug_gp_id=? 
				$orderBy";
		$query = $this->ums->query($sql, array($this->ug_gp_id));
		return $query;
	}

	function get_users_each_group() {
		$sql = "SELECT st.st_id, st.st_name_th, st.st_icon, COUNT(DISTINCT ug.ug_us_id) AS user_count
				FROM ums_usergroup ug
				LEFT JOIN ums_group gp ON ug.ug_gp_id = gp.gp_id
				LEFT JOIN ums_system st ON st.st_id = gp.gp_st_id
				LEFT JOIN ums_user us ON us.us_id = ug.ug_us_id
				WHERE st.st_active = 1 AND gp.gp_active = 1 AND us.us_active = 1
				GROUP BY st.st_id, st.st_name_th, st.st_icon ";
		$query = $this->ums->query($sql);
		return $query;
	}

	function get_users_each_group_detail($st_id) {
		$sql = "SELECT st.st_name_th, gp.gp_id, gp.gp_name_th, us.us_name, us.us_username, MAX(ml.ml_date) last_login, MAX(ughi.ughi_date) last_get_permission
				FROM ums_usergroup ug
				LEFT JOIN ums_group gp ON ug.ug_gp_id = gp.gp_id
				LEFT JOIN ums_system st ON st.st_id = gp.gp_st_id
				LEFT JOIN ums_user us ON us.us_id = ug.ug_us_id
				LEFT JOIN ums_user_logs_menu ml ON ml.ml_us_id = us.us_id AND ml.ml_mn_id IS NULL
				LEFT JOIN ums_usergroup_history ughi ON ughi.ughi_us_id = us.us_id AND ughi.ughi_gp_id = ug.ug_gp_id
				WHERE st.st_id = {$st_id} AND gp.gp_active = 1 AND us.us_active = 1
				GROUP BY st.st_name_th, gp.gp_id, gp.gp_name_th, us.us_name, us.us_username ";
		$query = $this->ums->query($sql);
		return $query;
	}



	// /*
	//  *
	//  */
	function get_gear() {
		$us_id = $this->session->userdata('us_id');
		$sql = "SELECT * 
				FROM ums_usergroup inner join ums_group 
				on ums_usergroup.ug_gp_id = ums_group.gp_id
				INNER JOIN ums_system
				on ums_system.st_id = ums_group.gp_st_id
				LEFT JOIN ums_icon 
				on ums_icon.ic_name = ums_group.gp_icon
				where ug_us_id = ?";
		
		$query = $this->ums->query($sql,$us_id);
		
		return $query; 
	}

	function get_system() {
		$us_id = $this->session->userdata('us_id');
		$sql = "SELECT *
				FROM ums_usergroup inner join ums_group 
				on ums_usergroup.ug_id = ums_group.gp_id
				INNER JOIN ums_system
				on ums_system.st_id = ums_group.gp_st_id
				LEFT JOIN ums_icon 
				on ums_icon.ic_name = ums_group.gp_icon
				where ug_us_id = ?
				group by st_id ORDER BY st_seq ASC";
		
		$query = $this->ums->query($sql,$us_id);
		
		return $query; 
	}
	 
	function get_mission(){
	  	$us_id = $this->session->userdata('us_id');
    	$sql = "SELECT * FROM ums_usergroup 
    			INNER JOIN ums_group on ums_usergroup.ug_gp_id = ums_group.gp_id
    			INNER JOIN ums_system on ums_system.st_id = ums_group.gp_st_id
    			where ug_us_id = ?
    			GROUP BY ums_system.st_id
    			ORDER BY st_seq ASC";
    	$query = $this->ums->query($sql,$us_id);
      
    	return $query; 
	}

	function get_usergroup_dashboard() {
		$sql = "SELECT us.us_id, us.us_name, gp.gp_id, gp.gp_name_th, st.st_id, st.st_name_th, st.st_seq
				FROM ums_usergroup ug
				LEFT JOIN ums_user us ON us.us_id = ug.ug_us_id 
				LEFT JOIN ums_group gp ON gp.gp_id = ug.ug_gp_id
				LEFT JOIN ums_system st ON st.st_id = gp.gp_st_id
				WHERE gp.gp_active = 1 
					AND us.us_active = 1;";
	}
} // end class M_ums_usergroup
?>
