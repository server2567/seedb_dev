<?php

include_once("Da_ums_group.php");

class M_ums_group extends Da_ums_group {

	/*
	* get_all
	* get all ums_group (not delete).
	* @input 
		aOrderBy: array('fieldname' => 'ASC|DESC', ... )
		is_active: what status active need to get
	* $output list of ums_group
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
			$where = " AND gp_active = " . $is_active;
		}
		$sql = "SELECT * 
				FROM ums_group 
				WHERE gp_active <> 2 " . " $where
				$orderBy";
		$query = $this->ums->query($sql);
		return $query;
	}
	
	/*
	* update_delete
	* update ums_group status(bg_active) = 2 (delete)
	* @input gp_id: ums_group id
			 gp_update_user: ums_user id that update
	* $output -
	* @author Areerat Pongurai
	* @Create Date 16/05/2024
	*/
	function update_delete()
	{
		$sql = "UPDATE ums_group 
				SET	gp_active=2, gp_update_user=?, gp_update_date=NOW()
				WHERE gp_id=?";	
			
		$this->ums->query($sql, array($this->gp_update_user, $this->gp_id));
	}

	/*
	* get_all_with_system
	* get all ums_group with system data (not delete).
	* @input aOrderBy: array('fieldname' => 'ASC|DESC', ... )
	* $output list of ums_group
	* @author Areerat Pongurai
	* @Create Date 16/05/2024
	*/
	function get_all_with_system($aOrderBy="")
	{
		$orderBy = "";
		if ( is_array($aOrderBy) ) {
			$orderBy.= "ORDER BY "; 
			foreach ($aOrderBy as $key => $value) {
				$orderBy.= "$key $value, ";
			}
			$orderBy = substr($orderBy, 0, strlen($orderBy)-2);
		}
		$sql = "SELECT ums_group.*, ums_system.st_name_th
		FROM ums_group 
		INNER JOIN ums_system 
		ON ums_group.gp_st_id = ums_system.st_id
		WHERE ums_group.gp_active <> 2
		$orderBy";
		$query = $this->ums->query($sql);
		return $query;
	}

	/*
	* get_by_key_with_system
	* get ums_group with system data by ums_group id.
	* @input gp_id: ums_group id
			 aOrderBy: array('fieldname' => 'ASC|DESC', ... )
	* $output list of ums_group
	* @author Areerat Pongurai
	* @Create Date 16/05/2024
	*/
	function get_by_key_with_system($aOrderBy="")
	{
		$orderBy = "";
		if ( is_array($aOrderBy) ) {
			$orderBy.= "ORDER BY "; 
			foreach ($aOrderBy as $key => $value) {
				$orderBy.= "$key $value, ";
			}
			$orderBy = substr($orderBy, 0, strlen($orderBy)-2);
		}
		$sql = "SELECT ums_group.*, ums_system.st_name_th
		FROM ums_group 
		INNER JOIN ums_system 
		ON ums_group.gp_st_id = ums_system.st_id
		WHERE ums_group.gp_id = ?
		$orderBy";
		$query = $this->ums->query($sql, array($this->gp_id));
		return $query;
	}

	/*
	* get_by_system_id
	* get ums_group by ums_system id.
	* @input gp_st_id: ums_system id
			 aOrderBy: array('fieldname' => 'ASC|DESC', ... )
	* $output ums_group data
	* @author Areerat Pongurai
	* @Create Date 16/05/2024
	*/
	function get_by_system_id($aOrderBy="")
	{
		$orderBy = "";
		if ( is_array($aOrderBy) ) {
			$orderBy.= "ORDER BY "; 
			foreach ($aOrderBy as $key => $value) {
				$orderBy.= "$key $value, ";
			}
			$orderBy = substr($orderBy, 0, strlen($orderBy)-2);
		}
		$sql = "SELECT *
		FROM ums_group 
		WHERE gp_active = 1 AND gp_st_id = ?
		$orderBy";
		$query = $this->ums->query($sql, array($this->gp_st_id));
		return $query;
	}

	/*
	* get_by_user_and_system_id
	* get ums_group by ums_user id and ums_system id.
	* @input gp_st_id: ums_system id
			 us_id: ums_user id
	* $output ums_group data
	* @author Areerat Pongurai
	* @Create Date 16/05/2024
	*/
	function get_by_user_and_system_id($us_id)
	{
		$sql = "SELECT gp.gp_id, gp.gp_name_th, gp.gp_url, gp.gp_is_medical
		FROM ums_group gp
		WHERE gp.gp_id in (
				SELECT DISTINCT bgp.ugp_gp_id gp_id
				FROM ums_base_group_permission bgp
				INNER JOIN ums_user us ON us.us_bg_id = bgp.ugp_bg_id
				WHERE us.us_id = ?
				UNION 
				SELECT DISTINCT ug_gp_id gp_id
				FROM ums_usergroup
				WHERE ug_us_id = ?
			)
			AND gp.gp_active = 1 AND gp.gp_st_id = ? 
		 GROUP BY gp.gp_id, gp.gp_name_th, gp.gp_url ";
		$query = $this->ums->query($sql, array($us_id, $us_id, $this->gp_st_id));
		return $query;
	}

	// // base_group_permission with ugp_bg_id 
	// // base_group with gp_st_id 
	// function get_all_with_system($aOrderBy="")
	// {
	// 	$orderBy = "";
	// 	if ( is_array($aOrderBy) ) {
	// 		$orderBy.= "ORDER BY "; 
	// 		foreach ($aOrderBy as $key => $value) {
	// 			$orderBy.= "$key $value, ";
	// 		}
	// 		$orderBy = substr($orderBy, 0, strlen($orderBy)-2);
	// 	}
	// 	//ums_group.*, ums_system.st_name_th
	// 	$sql = "SELECT *
	// 	FROM ums_group gp
	// 	LEFT JOIN ums_system st ON gp.gp_st_id = st.st_id
	// 	WHERE gp.gp_active <> 2
	// 	$orderBy";
	// 	$query = $this->ums->query($sql);
	// 	return $query;
	// }

	/*
	* get_unique_th
	* get datas that same name_th (case insert)
	* @input gp_st_id: ums_system id
			 gp_name_th: for check duplicate name_th
	* $output datas that same name_th
	* @author Areerat Pongurai
	* @Create Date 16/05/2024
	*/
	function get_unique_th(){
		$sql = "SELECT gp_id FROM ums_group WHERE gp_active <> 2 AND gp_st_id = ? AND gp_name_th = ?";
		$query = $this->ums->query($sql,array($this->gp_st_id ,$this->gp_name_th));
		return $query;
	}

	/*
	* get_unique_en
	* get datas that same name_en (case insert)
	* @input gp_st_id: ums_system id
			 gp_name_en: for check duplicate name_en
	* $output datas that same name_en
	* @author Areerat Pongurai
	* @Create Date 16/05/2024
	*/
	function get_unique_en(){
		$sql = "SELECT gp_id FROM ums_group WHERE gp_active <> 2 AND gp_st_id = ? AND gp_name_en = ?";
		$query = $this->ums->query($sql,array($this->gp_st_id ,$this->gp_name_en));
		return $query;
	}

	/*
	* get_unique_th_with_id
	* get datas that same name_th (case update)
	* @input gp_id: ums_group id
			 gp_st_id: ums_system id
			 gp_name_th: for check duplicate name_th
	* $output datas that same name_th
	* @author Areerat Pongurai
	* @Create Date 16/05/2024
	*/
	function get_unique_th_with_id(){
		$sql = "SELECT * FROM ums_group WHERE gp_active <> 2 AND gp_id != ? AND gp_st_id = ? AND gp_name_th = ?";
		$query = $this->ums->query($sql,array($this->gp_id ,$this->gp_st_id ,$this->gp_name_th));
		return $query;
	}

	/*
	* get_unique_en_with_id
	* get datas that same name_en (case update)
	* @input gp_id: ums_group id
			 gp_st_id: ums_system id
			 gp_name_en: for check duplicate name_en
	* $output datas that same name_en
	* @author Areerat Pongurai
	* @Create Date 16/05/2024
	*/
	function get_unique_en_with_id(){
		$sql = "SELECT * FROM ums_group WHERE gp_active <> 2 AND gp_id != ? AND gp_st_id = ? AND gp_name_en = ?";
		$query = $this->ums->query($sql,array($this->gp_id ,$this->gp_st_id ,$this->gp_name_en));
		return $query;
	}
} // end class M_ums_group
?>
