<?php

include_once("Da_ums_icon.php");

class M_ums_icon extends Da_ums_icon {

	/*
	* get_all
	* get all ums_icon.
	* @input aOrderBy: array('fieldname' => 'ASC|DESC', ... )
	* $output list of ums_icon
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
				FROM ums_icon 
				WHERE ic_type = 'system'
				$orderBy order by ic_id ";
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
	* get_by_type
	* get all ums_icon by icon type
	* @input ic_type: icon type
	* $output ums_icon list
	* @author Areerat Pongurai
	* @Create Date 16/05/2024
	*/
	function get_by_type($withSetAttributeValue=FALSE) {	
		$sql = "SELECT * 
				FROM ums_icon 
				WHERE ic_type=?";
		$query = $this->ums->query($sql, array($this->ic_type));
		if ( $withSetAttributeValue ) {
			$this->row2attribute( $query->row() );
		} else {
			return $query ;
		}
	}
	
	/*
	* get_unique
	* get datas that same icon (case insert)
	* @input ic_name: for check duplicate name
			 ic_type: icon type
	* $output datas that same icon
	* @author Areerat Pongurai
	* @Create Date 16/05/2024
	*/
	function get_unique()
	{
		$sql = "SELECT * FROM ums_icon WHERE ic_name = ? AND ic_type = ?";
		$query = $this->ums->query($sql,array($this->ic_name, $this->ic_type));
		return $query;
	}
	
	/*
	* get_unique_with_id
	* get datas that same icon (case update)
	* @input ic_name: for check duplicate name
			 ic_type: icon type
			 ic_id: ums_icon id
	* $output datas that same icon
	* @author Areerat Pongurai
	* @Create Date 16/05/2024
	*/
	function get_unique_with_id()
	{
		$sql = "SELECT * FROM ums_icon WHERE ic_name = ? AND ic_type = ? AND ic_id <> ?";
		$query = $this->ums->query($sql,array($this->ic_name, $this->ic_type, $this->ic_id));
		return $query;
	}
	
	// function get_by_name($withSetAttributeValue=FALSE) {	
	// 	$sql = "SELECT * 
	// 			FROM ums_icon 
	// 			WHERE ic_name=?";
	// 	$query = $this->ums->query($sql, array($this->ic_name));
	// 	if ( $withSetAttributeValue ) {
	// 		$this->row2attribute( $query->row() );
	// 	} else {
	// 		return $query ;
	// 	}
	// }
	
	// function get_date_by_name($withSetAttributeValue=FALSE) {	
	// 	$sql = "SELECT IcDate 
	// 			FROM ums_icon 
	// 			WHERE ic_name=?";
	// 	$query = $this->ums->query($sql, array($this->ic_name));
	// 	if ( $withSetAttributeValue ) {
	// 		$this->row2attribute( $query->row() );
	// 	} else {
	// 		return $query ;
	// 	}
	// }
	
} // end class M_ums_icon
?>
