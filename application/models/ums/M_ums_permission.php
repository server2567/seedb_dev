<?php

include_once("Da_ums_permission.php");

class M_ums_permission extends Da_ums_permission {

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
				FROM ums_permission 
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
	
	// add your functions here

	function get_by_user_id($withSetAttributeValue=FALSE) {	
		$sql = "SELECT * 
				FROM ums_permission 
				WHERE pm_us_id=?";
		$query = $this->ums->query($sql, array($this->pm_us_id));
		if ( $withSetAttributeValue ) {
			$this->row2attribute( $query->row() );
		} else {
			return $query ;
		}
	}

	function get_id_by_menu_and_user_id() {	
		$sql = "SELECT pm_id
				FROM ums_permission
				WHERE pm_mn_id=? AND pm_us_id=?";
		$query = $this->ums->query($sql, array($this->pm_mn_id, $this->pm_us_id));
		return $query ;
	}

	/*
	* get_user_by_menu_id
	* get user that have menu_id
	* @input mn_id: menu id
	* $output user ids
	* @author Areerat Pongurai
	* @Create Date 16/05/2024
	*/
	function get_user_by_menu_id() {	
		$sql = "SELECT pm_us_id
				FROM ums_permission
				WHERE pm_mn_id=? AND pm_active=1 ";
		$query = $this->ums->query($sql, array($this->pm_mn_id));
		return $query ;
	}
} // end class M_umpermission
?>
