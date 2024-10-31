<?php
/*
 * M_ums_base_group
 * Model for Manage about ums_base_group Table.
 * @Author Areerat Pongurai
 * @Create Date 16/05/2024
 */

include_once("Da_ums_base_group.php");

class M_ums_base_group extends Da_ums_base_group {
	
	/*
	* get_all
	* get all base_groups (not delete).
	* @input 
		aOrderBy: array('fieldname' => 'ASC|DESC', ... )
		is_active: what status active need to get
	* $output list of base_group
	* @author Areerat Pongurai
	* @Create Date 16/05/2024
	*/
	function get_all($aOrderBy="", $is_active=""){
		$orderBy = "";
		if ( is_array($aOrderBy) ) {
			$orderBy.= "ORDER BY "; 
			foreach ($aOrderBy as $key => $value) {
				$orderBy.= "$key $value, ";
			}
			$orderBy = substr($orderBy, 0, strlen($orderBy)-2);
		}
		$where = "";
		if ( !empty($is_active) ) {
			$where = " AND bg_active = " . $is_active;
		}
		$sql = "SELECT * 
				FROM ums_base_group 
				WHERE bg_active <> 2 " . " $where
				$orderBy";
		$query = $this->ums->query($sql);
		return $query;
	}
	
	/*
	* update_delete
	* update base group status(bg_active) = 2 (delete)
	* @input bg_id: base group id
	* $output -
	* @author Areerat Pongurai
	* @Create Date 16/05/2024
	*/
	function update_delete()
	{
		$sql = "UPDATE ums_base_group 
				SET	bg_active=2
				WHERE bg_id=?";	
			
		$this->ums->query($sql, array($this->bg_id));
	}

	/*
	* get_unique_th
	* get datas that same name_th (case insert)
	* @input bg_name_th: for check duplicate name_th
	* $output datas that same name_th
	* @author Areerat Pongurai
	* @Create Date 16/05/2024
	*/
	function get_unique_th()
	{
			$sql = "SELECT * FROM ums_base_group WHERE bg_name_th = ?";
			$query = $this->ums->query($sql,array($this->bg_name_th));
			return $query;
	}

	/*
	* get_unique_en
	* get datas that same name_en (case insert)
	* @input bg_name_en: for check duplicate name_en
	* $output datas that same name_en
	* @author Areerat Pongurai
	* @Create Date 16/05/2024
	*/
	function get_unique_en()
	{
			$sql = "SELECT * FROM ums_base_group WHERE bg_name_en = ?";
			$query = $this->ums->query($sql,array($this->bg_name_en));
			return $query;
	}

	/*
	* get_unique_th_with_id
	* get datas that same name_th (case update)
	* @input bg_id (base_group id)
			 bg_name_th: for check duplicate name_th
	* $output datas that same name_th
	* @author Areerat Pongurai
	* @Create Date 16/05/2024
	*/
	function get_unique_th_with_id()
	{
			$sql = "SELECT * FROM ums_base_group WHERE bg_id != ? AND bg_name_th = ?";
			$query = $this->ums->query($sql,array($this->bg_id, $this->bg_name_th));
			return $query;
	}

	/*
	* get_unique_en_with_id
	* get datas that same name_en (case update)
	* @input bg_id (base_group id)
			 bg_name_en: for check duplicate name_en
	* $output datas that same name_en
	* @author Areerat Pongurai
	* @Create Date 16/05/2024
	*/
	function get_unique_en_with_id()
	{
			$sql = "SELECT * FROM ums_base_group WHERE bg_id != ? AND bg_name_en = ?";
			$query = $this->ums->query($sql,array($this->bg_id, $this->bg_name_en));
			return $query;
	}
} // end class M_umusergroup
?>
