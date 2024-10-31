<?php

include_once("Da_ums_menu.php");

class M_ums_menu extends Da_ums_menu
{
	/*
	* get_all
	* get all menus (not delete).
	* @input aOrderBy: array('fieldname' => 'ASC|DESC', ... )
	* $output list of menu
	* @author Areerat Pongurai
	* @Create Date 16/05/2024
	*/
	function get_all($aOrderBy = "")
	{
		$orderBy = "";
		if (is_array($aOrderBy)) {
			$orderBy .= "ORDER BY ";
			foreach ($aOrderBy as $key => $value) {
				$orderBy .= "$key $value, ";
			}
			$orderBy = substr($orderBy, 0, strlen($orderBy) - 2);
		}
		$sql = "SELECT * 
				FROM ums_menu 
				WHERE mn_active <> 2
				$orderBy";
		$query = $this->ums->query($sql);
		return $query;
	}

	/*
	* update_delete
	* update menu status(mn_active) = 2 (delete)
	* @input 
		mn_id: menu id
		mn_update_user: user session for save update user
	* $output -
	* @author Areerat Pongurai
	* @Create Date 16/05/2024
	*/
	function update_delete()
	{
		$sql = "UPDATE ums_menu 
				SET	mn_active=2, mn_update_user=?, mn_update_date=NOW()
				WHERE mn_id=?";	
			
		$this->ums->query($sql, array($this->mn_update_user, $this->mn_id));
	}

	/*
	* get_menus_sidebar
	* get all menus that from system id and that user can access
	* @input st_id: system id, us_id: user id from session
	* $output menus for sidebar
	* @author Areerat Pongurai
	* @Create Date 16/05/2024
	
		Condition
		1. us_id เข้าไปหา ums_usergroup ที่ ug_gp_id เพื่อต้องการ ug_gp_id 
		2. ug_gp_id เข้าไปหา ums_group_permission ที่ gpn_gp_id  เพื่อต้องการ gpn_mn_id มาแสดงเมนูที่ระบบที่เราเลือก
		join
		3. us_id เข้าไปหา ums_permission ที่ pm_us_id เพื่อต้องการ pm_mn_id มาแสดงเมนูที่ระบบที่เราเลือก
		distinct

		QS
		1. ถ้า group_permission มีสิทธิ์ mn_id = 1 แต่ใน permission ไม่มีสิทธิ์ mn_id = 1 ผู้ใช้งานคนนี้จะไม่มีสิทธิ์เห็น mn_id = 1 -> ถูกต้อง
	*/
	function get_menus_sidebar($st_id, $us_id)
	{
		$sql = "SELECT mn_id, mn_st_id, mn_seq, mn_icon, mn_name_th, mn_name_en, mn_url, mn_detail, mn_parent_mn_id, mn_level
				FROM ums_menu mn
				WHERE mn_st_id = ?
					AND mn_active = 1
					AND mn_id IN 
						(
							SELECT DISTINCT mn_id
							FROM (
								SELECT mn_id, 
									CASE 
										WHEN gpn_active = 1 AND pm_active = 0 THEN 0 /* set in group_permission and permission  */
										WHEN gpn_active = 0 AND pm_active = 1 THEN 1 /* set in group_permission and permission  */
										WHEN gpn_active = 1 AND pm_active = 1 THEN 1 /* set in group_permission and permission  */
										WHEN gpn_active = 0 AND pm_active = 0 THEN 0 /* set in group_permission and permission  */
										WHEN pm_active = 2 THEN gpn_active /* set in permission but not set(=2) in group_permission */
										WHEN gpn_active = 2 THEN pm_active /* set in group_permission but not sett(=2) in permission */
										ELSE 0 END AS active
								FROM (
									SELECT gpn.gpn_mn_id mn_id, gpn.gpn_active, 2 pm_active
									FROM ums_group_permission gpn
									LEFT JOIN ums_usergroup ug ON ug.ug_gp_id = gpn.gpn_gp_id
									WHERE ug.ug_us_id = ?
									GROUP BY gpn.gpn_mn_id, gpn.gpn_active 
									UNION
									SELECT pm_mn_id mn_id, 2 gpn_active, pm_active
									FROM ums_permission
									WHERE pm_us_id = ?
									GROUP BY pm_mn_id, pm_active
								) a
							) b
							WHERE active = 1
						)
				ORDER BY mn_level, mn_seq;";
		$result = $this->ums->query($sql, array($st_id, $us_id, $us_id));
		return $result;
	}

	/*
	* get_menus_path
	* get path menu active for breadcrumb by menu id
	* @input mn_id: menu id
	* $output path menu active for breadcrumb
	* @author Areerat Pongurai
	* @Create Date 16/05/2024
	*/
	function get_menus_path($mn_id)
	{
		$sql = "WITH RECURSIVE cte (mn_id, mn_parent_mn_id, mn_name_th, mn_name_en, mn_url, mn_seq, mn_level) AS (
					SELECT mn_id, mn_parent_mn_id, mn_name_th, mn_name_en, mn_url, mn_seq, mn_level
					FROM ums_menu
					WHERE mn_id = ? AND mn_active = 1
					UNION ALL
					SELECT m.mn_id, m.mn_parent_mn_id, m.mn_name_th, m.mn_name_en, m.mn_url, m.mn_seq, m.mn_level
					FROM ums_menu m
					JOIN cte c ON m.mn_id = c.mn_parent_mn_id
				)
				SELECT mn_id, mn_parent_mn_id, mn_name_th, mn_name_en, mn_url, mn_seq
				FROM cte
				ORDER BY mn_level, mn_seq;";
		$query = $this->ums->query($sql, array($mn_id));
		//echo $this->ums->last_query();
		return $query;
	}

	/*
	* get_menus_path_by_url
	* get path menu active for breadcrumb by menu url and system id
	* @input 
		mn_url: url of menu
		mn_st_id(system id): system id of menu
	* $output path menu active for breadcrumb
	* @author Areerat Pongurai
	* @Create Date 16/05/2024
	*/
	function get_menus_path_by_url($mn_url, $mn_st_id)
	{
		$sql = "WITH RECURSIVE cte (mn_id, mn_parent_mn_id, mn_name_th, mn_name_en, mn_url, mn_seq, mn_level) AS (
					SELECT mn_id, mn_parent_mn_id, mn_name_th, mn_name_en, mn_url, mn_seq, mn_level
					FROM ums_menu
					WHERE mn_url = ? AND mn_st_id = ? AND mn_active = 1
					UNION ALL
					SELECT m.mn_id, m.mn_parent_mn_id, m.mn_name_th, m.mn_name_en, m.mn_url, m.mn_seq, m.mn_level
					FROM ums_menu m
					JOIN cte c ON m.mn_id = c.mn_parent_mn_id
				)
				SELECT mn_id, mn_parent_mn_id, mn_name_th, mn_name_en, mn_url, mn_seq
				FROM cte
				ORDER BY mn_level, mn_seq ";
		$query = $this->ums->query($sql, array($mn_url, $mn_st_id));
		return $query;
	}

	function get_menus_by_url($withSetAttributeValue = FALSE)
	{
		$sql = "SELECT * 
				FROM ums_menu
				WHERE mn_url='".$this->mn_url."' AND mn_active = 1 ";
		$query = $this->ums->query($sql, array($this->mn_url));
		if ($withSetAttributeValue) {
			$this->row2attribute($query->row());
		} else {
			return $query;
		}
	}

	function get_menus_by_sys_and_url($withSetAttributeValue = FALSE)
	{
		$sql = "SELECT * 
				FROM ums_menu
				WHERE mn_st_id=? AND mn_url=? AND mn_active = 1 ";
		$query = $this->ums->query($sql, array($this->mn_st_id, $this->mn_url));
		if ($withSetAttributeValue) {
			$this->row2attribute($query->row());
		} else {
			return $query;
		}
	}

	/*
	* get_menus_by_sys
	* get menus by system id (mn_active <> 2)
	* @input mn_st_id (system id)
	* $output menu list of system
	* @author Areerat Pongurai
	* @Create Date 16/05/2024
	*/
	function get_menus_by_sys($withSetAttributeValue = FALSE)
	{
		$sql = "SELECT * 
				FROM ums_menu
				WHERE mn_st_id=? AND mn_active <> 2
				ORDER BY mn_level, mn_seq";
		$query = $this->ums->query($sql, array($this->mn_st_id));
		if ($withSetAttributeValue) {
			$this->row2attribute($query->row());
		} else {
			return $query;
		}
	}

	/*
	* get_max_menu_seq_by_sys
	* get max sequence
	* @input mn_st_id (system id)
	* $output max sequence
	* @author Areerat Pongurai
	* @Create Date 16/05/2024
	*/
	function get_max_menu_seq_by_sys($withSetAttributeValue = FALSE)
	{
		$sql = "SELECT MAX(mn_seq) max_mn_seq
				FROM ums_menu
				WHERE mn_st_id=?";
		$query = $this->ums->query($sql, array($this->mn_st_id));
		if ($withSetAttributeValue) {
			$this->row2attribute($query->row());
		} else {
			return $query;
		}
	}

	/*
	* update_mn_seq
	* update menu sequence order 
	* @input mn_seq: new sequence order, mn_id(menu id): menu id need to update
	* $output -
	* @author Areerat Pongurai
	* @Create Date 16/05/2024
	*/
	function update_mn_seq() {
		$sql = "UPDATE ums_menu 
				SET mn_seq=? 
				WHERE mn_id=?";
		$this->ums->trans_begin();
		$this->ums->query($sql, array($this->mn_seq, $this->mn_id));
		if ($this->ums->trans_status() === FALSE)
			$this->ums->trans_rollback();
		else
			$this->ums->trans_commit();
	}

	/*
	* get_unique_th
	* get datas that same name_th (case insert)
	* @input mn_st_id (system id)
			 mn_parent_mn_id
			 mn_name_th: for check duplicate name_th
	* $output datas that same name_th
	* @author Areerat Pongurai
	* @Create Date 16/05/2024
	*/
	function get_unique_th()
	{
		$sql = "SELECT * FROM ums_menu WHERE mn_st_id = ? AND mn_parent_mn_id = ? AND mn_name_th = ?";
		$query = $this->ums->query($sql, array($this->mn_st_id, $this->mn_parent_mn_id, $this->mn_name_th));
		return $query;
	}

	/*
	* get_unique_en
	* get datas that same name_en (case insert)
	* @input mn_st_id (system id)
			 mn_parent_mn_id
			 mn_name_en: for check duplicate name_en
	* $output datas that same name_en
	* @author Areerat Pongurai
	* @Create Date 16/05/2024
	*/
	function get_unique_en()
	{
		$sql = "SELECT * FROM ums_menu WHERE mn_st_id = ? AND mn_parent_mn_id = ? AND mn_name_en = ?";
		$query = $this->ums->query($sql, array($this->mn_st_id, $this->mn_parent_mn_id, $this->mn_name_en));
		return $query;
	}

	/*
	* get_unique_th_with_id
	* get datas that same name_th (case update)
	* @input mn_st_id (system id)
			 mn_parent_mn_id
			 mn_id: menu id that exclude to check duplicate
			 mn_name_th: for check duplicate name_th
	* $output datas that same name_th
	* @author Areerat Pongurai
	* @Create Date 16/05/2024
	*/
	function get_unique_th_with_id()
	{
		$sql = "SELECT * FROM ums_menu WHERE mn_st_id = ? AND mn_parent_mn_id = ? AND mn_id <> ? AND mn_name_th = ?";
		$query = $this->ums->query($sql, array($this->mn_st_id, $this->mn_parent_mn_id, $this->mn_id, $this->mn_name_th));
		return $query;
	}

	/*
	* get_unique_en_with_id
	* get datas that same name_en (case update)
	* @input mn_st_id (system id)
			 mn_parent_mn_id
			 mn_id: menu id that exclude to check duplicate
			 mn_name_en: for check duplicate name_en
	* $output datas that same name_en
	* @author Areerat Pongurai
	* @Create Date 16/05/2024
	*/
	function get_unique_en_with_id()
	{
		$sql = "SELECT * FROM ums_menu WHERE mn_st_id = ? AND mn_parent_mn_id = ? AND mn_id <> ? AND mn_name_en = ?";
		$query = $this->ums->query($sql, array($this->mn_st_id, $this->mn_parent_mn_id, $this->mn_id, $this->mn_name_en));
		return $query;
	}

	/*
	* get_submenu
	* get sub menus by parent menu id (mn_active = 1)
	* @input mn_id (parent menu id)
	* $output sub menu list of parent menu
	* @author Areerat Pongurai
	* @Create Date 03/07/2024
	*/
	function get_submenu()
	{
		$sql =" WITH RECURSIVE MenuHierarchy AS (
					SELECT mn_id, mn_parent_mn_id, mn_level, mn_name_th, mn_active, mn_icon, mn_seq, mn_url 
					FROM ums_menu
					WHERE mn_id = ? AND mn_active = 1
					UNION ALL
					SELECT um.mn_id, um.mn_parent_mn_id, um.mn_level, um.mn_name_th, um.mn_active, um.mn_icon, um.mn_seq, um.mn_url 
					FROM 
						ums_menu um
						INNER JOIN MenuHierarchy mh ON um.mn_parent_mn_id = mh.mn_id
					WHERE um.mn_active = 1
				)
				SELECT mn_id, mn_parent_mn_id, mn_level, mn_name_th, mn_active, mn_icon, mn_seq, mn_url 
				FROM MenuHierarchy
				ORDER BY mn_seq ;
		";
		$query = $this->ums->query($sql,array($this->mn_id));
		return $query;
	}
} // end class M_ummenu
