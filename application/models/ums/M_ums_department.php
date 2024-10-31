<?php

include_once("Da_ums_department.php");

class M_ums_department extends Da_ums_department {
	
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
				FROM ums_department 
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
		// print_r($qry->result()); die;
		foreach ($qry->result() as $row) {
			$opt[$row->PK_FIELD] = $row->FIELD_NAME;
		}
		return $opt;
	}
	
	// // add your functions here

	/*
	* get_unique_th
	* get datas that same name_th (case insert)
	* @input dp_name_th: for check duplicate name_th
	* $output datas that same name_th
	* @author Areerat Pongurai
	* @Create Date 27/05/2024
	*/
	function get_unique_th()
	{
			$sql = "SELECT * FROM ums_department WHERE dp_name_th = ?";
			$query = $this->ums->query($sql,array($this->dp_name_th));
			return $query;
	}

	/*
	* get_unique_en
	* get datas that same name_en (case insert)
	* @input dp_name_en: for check duplicate name_en
	* $output datas that same name_en
	* @author Areerat Pongurai
	* @Create Date 27/05/2024
	*/
	function get_unique_en()
	{
			$sql = "SELECT * FROM ums_department WHERE dp_name_en = ?";
			$query = $this->ums->query($sql,array($this->dp_name_en));
			return $query;
	}

	/*
	* get_unique_th_with_id
	* get datas that same name_th (case update)
	* @input dp_id (department id)
			 dp_name_th: for check duplicate name_th
	* $output datas that same name_th
	* @author Areerat Pongurai
	* @Create Date 27/05/2024
	*/
	function get_unique_th_with_id()
	{
			$sql = "SELECT * FROM ums_department WHERE dp_id != ? AND dp_name_th = ?";
			$query = $this->ums->query($sql,array($this->dp_id, $this->dp_name_th));
			return $query;
	}

	/*
	* get_unique_en_with_id
	* get datas that same name_en (case update)
	* @input dp_id (department id)
			 dp_name_en: for check duplicate name_en
	* $output datas that same name_en
	* @author Areerat Pongurai
	* @Create Date 27/05/2024
	*/
	function get_unique_en_with_id()
	{
			$sql = "SELECT * FROM ums_department WHERE dp_id != ? AND dp_name_en = ?";
			$query = $this->ums->query($sql,array($this->dp_id, $this->dp_name_en));
			return $query;
	}

} // end class M_umusergroup
?>
