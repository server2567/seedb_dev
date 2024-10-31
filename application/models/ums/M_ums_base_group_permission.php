<?php

include_once("Da_ums_base_group_permission.php");

class M_ums_base_group_permission extends Da_ums_base_group_permission {
	
	/*
	* get_all
	* get all menus
	* @input aOrderBy: array('fieldname' => 'ASC|DESC', ... )
	* $output list of menu
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
				FROM ums_base_group_permission 
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
	* delete_by_base_group
	* delete ums_base_group_permission by ums_user_group id
	* @input 
		ugp_bg_id: ums_user_group
	* $output -
	* @author Areerat Pongurai
	* @Create Date 16/05/2024
	*/
	function delete_by_base_group() {
		$sql = "DELETE FROM ums_base_group_permission
				WHERE ugp_bg_id=?";
		 
		$this->ums->query($sql, array($this->ugp_bg_id));
	}

	/*
	* get_by_base_group
	* get ums_base_group_permission by ums_user_group id
	* @input 
		ugp_bg_id: ums_user_group
	* $output -
	* @author Areerat Pongurai
	* @Create Date 16/05/2024
	*/
	function get_by_base_group($withSetAttributeValue=FALSE) {	
		$sql = "SELECT * 
				FROM ums_base_group_permission 
				WHERE ugp_bg_id=?";
		$query = $this->ums->query($sql, array($this->ugp_bg_id));
		if ( $withSetAttributeValue ) {
			$this->row2attribute( $query->row() );
		} else {
			return $query ;
		}
	}
} // end class M_ums_base_group_permission
?>
