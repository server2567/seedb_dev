<?php

include_once("Da_ums_group_permission.php");

class M_ums_group_permission extends Da_ums_group_permission {

	/*
	* get_all
	* get all ums_group_permission.
	* @input aOrderBy: array('fieldname' => 'ASC|DESC', ... )
	* $output list of ums_group_permission
	* @author Areerat Pongurai
	* @Create Date 16/05/2024
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
				FROM ums_group_permission 
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
	
	/*
	* update_delete_with_group_id
	* update ums_group_permission status(gpn_active) = 2 (delete)
	* @input gpn_gp_id: ums_group id
	* $output -
	* @author Areerat Pongurai
	* @Create Date 16/05/2024
	*/
	function update_delete_with_group_id()
	{
		$sql = "UPDATE ums_group_permission 
				SET	gpn_active=2
				WHERE gpn_gp_id=?";	
			
		$this->ums->query($sql, array($this->gpn_gp_id));
	}

	/*
	* get_by_group_id
	* get ums_group_permission by ums_group id
	* @input gpn_gp_id: ums_group id
	* $output -
	* @author Areerat Pongurai
	* @Create Date 16/05/2024
	*/
	function get_by_group_id($withSetAttributeValue=FALSE) {	
		
		$sql = "SELECT * 
				FROM ums_group_permission 
				WHERE gpn_gp_id=?";//, gpMnID=?";
		$query = $this->ums->query($sql, $this->gpn_gp_id);
		if ( $withSetAttributeValue ) {
			$this->row2attribute( $query->row() );
		} else {
			return $query ;
		}
	}

	/*
	* get_id_by_menu_and_group_id
	* get ums_group_permission by ums_group id and ums_menu id
	* @input gpn_gp_id: ums_group id
			 gpn_mn_id: ums_menu id
	* $output -
	* @author Areerat Pongurai
	* @Create Date 16/05/2024
	*/
	function get_id_by_menu_and_group_id() {	
		$sql = "SELECT gpn_id
				FROM ums_group_permission
				WHERE gpn_mn_id=? AND gpn_gp_id=?";
		$query = $this->ums->query($sql, array($this->gpn_mn_id, $this->gpn_gp_id));
		return $query ;
	}

	/*
	* get_group_by_menu_id
	* get group that have menu_id
	* @input mn_id: menu id
	* $output group ids
	* @author Areerat Pongurai
	* @Create Date 16/05/2024
	*/
	function get_group_by_menu_id() {	
		$sql = "SELECT gpn_gp_id
				FROM ums_group_permission
				WHERE gpn_mn_id=? AND gpn_active=1 ";
		$query = $this->ums->query($sql, array($this->gpn_mn_id));
		return $query ;
	}
} // end class M_umgpermission
?>
