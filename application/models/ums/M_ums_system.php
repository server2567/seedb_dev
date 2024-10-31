<?php

include_once("Da_ums_system.php");

class M_ums_system extends Da_ums_system {

	/*
	 * aOrderBy = array('fieldname' => 'ASC|DESC', ... )
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
			$where = " AND st_active = " . $is_active;
		}
		$sql = "SELECT * 
				FROM ums_system 
				WHERE st_active <> 2 " . " $where
				$orderBy";
		$query = $this->ums->query($sql);
		return $query;
	}
	
	// function get_all_join_icon($aOrderBy=""){
	// 	$orderBy = "";
	// 	if ( is_array($aOrderBy) ) {
	// 		$orderBy.= "ORDER BY "; 
	// 		foreach ($aOrderBy as $key => $value) {
	// 			$orderBy.= "$key $value, ";
	// 		}
	// 		$orderBy = substr($orderBy, 0, strlen($orderBy)-2);
	// 	}
	// 	$sql = "SELECT * 
	// 			FROM ums_system 
	// 			LEFT JOIN umicon 
	// 			on ums_system.st_icon = umicon.IcName 
	// 			$orderBy";
	// 	$query = $this->ums->query($sql);
	// 	return $query;
	// }
	
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
	
	function update_delete()
	{
		$sql = "UPDATE ums_system 
				SET	st_active=2
				WHERE st_id=?";	
			
		$this->ums->query($sql, array($this->st_id));
	}
		
	function get_by_key_sys($withSetAttributeValue=FALSE) {	
		$sql = "SELECT * 
				FROM ums_system 
				WHERE st_id=?";
		$query = $this->ums->query($sql, array($this->st_id));
		if ( $withSetAttributeValue ) {
			$this->row2attribute( $query->row() );
		} else {
			return $query ;
		}
	}

	function get_count_by_icon($withSetAttributeValue=FALSE) {	
		$sql = "SELECT COUNT(st_id) count_st_id
				FROM ums_system 
				WHERE st_icon=?";
		$query = $this->ums->query($sql, array($this->st_icon));
		if ( $withSetAttributeValue ) {
			$this->row2attribute( $query->row() );
		} else {
			return $query ;
		}
	}
	
	function show_all()
	{
		$orderBy="";
		$sql = "SELECT * 
		FROM ums_system
		$orderBy";
		$query = $this->ums->query($sql);
		return $query;
	}
	
	/*function delete_in_gpermission($gpGpID)
	{
		$sql = "DELETE FROM umgpermission WHERE gpGpID in (?)";
		$this->ums->trans_begin();
		$this->ums->query($sql, array($gpGpID));
		if ($this->ums->trans_status() === FALSE)
			{
				$this->ums->trans_rollback();
			}
			else
			{
				$this->ums->trans_commit();
			}
	}
	function delete_in_permission($pmMnID)
	{
		$sql = "DELETE FROM umpermission WHERE pmMnID in (?)";
		$this->ums->trans_begin();
		$this->ums->query($sql, array($pmMnID));
		if ($this->ums->trans_status() === FALSE)
			{
				$this->ums->trans_rollback();
			}
			else
			{
				$this->ums->trans_commit();
			}
	}
	function delete_in_groupdefault($GdGpID)
	{
		$sql = "DELETE FROM umgroupdefault WHERE GdGpID in (?)";
		$this->ums->trans_begin();
		$this->ums->query($sql, array($GdGpID));
		if ($this->ums->trans_status() === FALSE)
			{
				$this->ums->trans_rollback();
			}
			else
			{
				$this->ums->trans_commit();
			}
	}
	function delete_in_gpermission()
	{
		$sql = "DELETE FROM umgpermission WHERE gpGpID in (SELECT GpID from umgroup where Gpst_id = ?)";
		$this->ums->trans_begin();
		$this->ums->query($sql, array($this->st_id));
		if ($this->ums->trans_status() === FALSE)
			{
				$this->ums->trans_rollback();
			}
			else
			{
				$this->ums->trans_commit();
			}
	}
	function delete_in_permission()
	{
		$sql = "DELETE FROM umpermission WHERE pmMnID in (SELECT MnID FROM ummenu WHERE Mnst_id = ?)";
		$this->ums->trans_begin();
		$this->ums->query($sql, array($this->st_id));
		if ($this->ums->trans_status() === FALSE)
			{
				$this->ums->trans_rollback();
			}
			else
			{
				$this->ums->trans_commit();
			}
	}*/
	
	function get_by_id($st_id)
	{
		$sql = "SELECT * FROM ums_system WHERE st_id = ?";
		$query = $this->ums->query($sql,array($st_id));
		return $query;
	}

	function get_unique_th()
	{
			$sql = "SELECT * FROM ums_system WHERE st_name_th = ?";
			$query = $this->ums->query($sql,array($this->st_name_th));
			return $query;
	}

	function get_unique_en()
	{
			$sql = "SELECT * FROM ums_system WHERE st_name_en = ?";
			$query = $this->ums->query($sql,array($this->st_name_en));
			return $query;
	}

	function get_unique_th_with_id()
	{
			$sql = "SELECT * FROM ums_system WHERE st_id != ? AND st_name_th = ?";
			$query = $this->ums->query($sql,array($this->st_id, $this->st_name_th));
			return $query;
	}

	function get_unique_en_with_id()
	{
			$sql = "SELECT * FROM ums_system WHERE st_id != ? AND st_name_en = ?";
			$query = $this->ums->query($sql,array($this->st_id, $this->st_name_en));
			return $query;
	}
	
	function get_sys_count(){
		$sql = "SELECT ums_system.st_id,st_name_th , count(distinct UsID) as num  , st_icon , ColorHeadTop, UsID
					FROM umuser
					left join umusergroup on umuser.UsID = umusergroup.UgUsID 
					left join umgroup on umusergroup.UgGpID = umgroup.GpID
					left join ums_system on umgroup.Gpst_id = ums_system.st_id
					left join umtemplate on ums_system.st_id = umtemplate.st_id
					left join umicon on umtemplate.HeadIcon = umicon.IcName
					group by st_name_th
					order by num DESC
				";
		$query = $this->ums->query($sql);
		return $query;
	}
	
	// ต้อง join กับ usergroup ด้วย ทำเหมือน menu.get_menus_sidebar
	function get_sys_by_user_id($us_id) {
		$sql = "SELECT *
				FROM ums_system
				WHERE st_active = 1 AND st_id IN (
					SELECT DISTINCT gp.gp_st_id st_id
					FROM ums_group gp
					LEFT JOIN ums_base_group_permission ugp ON ugp.ugp_gp_id = gp.gp_id
					LEFT JOIN ums_base_group bg ON bg.bg_id = ugp.ugp_bg_id
					LEFT JOIN ums_user us ON us.us_bg_id = bg.bg_id
					WHERE us.us_id = ? AND gp.gp_active = 1 AND bg.bg_active = 1
					UNION
					SELECT DISTINCT gp.gp_st_id st_id
					FROM ums_usergroup ug
					LEFT JOIN ums_group gp ON ug.ug_gp_id = gp.gp_id
					WHERE ug.ug_us_id = ? AND gp.gp_active = 1
					)
				ORDER BY st_seq ASC;";
		$query = $this->ums->query($sql,array($us_id, $us_id));
		return $query;
	}

	/*
	* get_amount_bg_by_st
	* get amount [UMS] base_group by system_id
	* @input st_id (ums system id)
	* $output base_group amount
	* @author Areerat Pongurai
	* @Create Date 08/08/2024
	*/
	function get_amount_bg_by_st($st_id) {
		$sql = "SELECT st.st_id, COUNT(DISTINCT bg.bg_id) AS bg_count
				FROM ums_system st
				JOIN ums_group gp ON st.st_id = gp.gp_st_id
				JOIN ums_base_group_permission ugp ON gp.gp_id = ugp.ugp_gp_id
				JOIN ums_base_group bg ON ugp.ugp_bg_id = bg.bg_id
				WHERE st.st_id = {$st_id} AND bg.bg_active != 2
				GROUP BY st.st_id;";
		$query = $this->ums->query($sql);
		return $query;
	}

	/*
	* get_bg_by_st
	* get amount [UMS] base_group by system_id
	* @input st_id (ums system id)
	* $output base_group amount
	* @author Areerat Pongurai
	* @Create Date 08/08/2024
	*/
	function get_bg_by_st($st_id, $aOrderBy) {
		$orderBy = "";
		if ( is_array($aOrderBy) ) {
			$orderBy.= "ORDER BY "; 
			foreach ($aOrderBy as $key => $value) {
				$orderBy.= "$key $value, ";
			}
			$orderBy = substr($orderBy, 0, strlen($orderBy)-2);
		}
		$sql = "SELECT st.st_id, bg.bg_id, bg.bg_name_th, bg.bg_name_en, bg_active 
				FROM ums_system st
				JOIN ums_group gp ON st.st_id = gp.gp_st_id
				JOIN ums_base_group_permission ugp ON gp.gp_id = ugp.ugp_gp_id
				JOIN ums_base_group bg ON ugp.ugp_bg_id = bg.bg_id
				WHERE st.st_id = {$st_id} AND bg.bg_active != 2
				GROUP BY st.st_id, bg.bg_id, bg.bg_name_th, bg.bg_name_en, bg_active 
				{$orderBy} ";
		$query = $this->ums->query($sql);
		return $query;
	}
	
} // end class M_ums_system
?>
