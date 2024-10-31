<?php
/*
 * M_eqs_equipments
 * Model for Manage about ams_appointment Table.
 * @Author Jiradat Pomyai
 * @Create Date 10/06/2024
*/

include_once("Da_eqs_equipments.php");

class M_eqs_equipments extends Da_eqs_equipments {

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
				FROM eqs_equipments 
				WHERE eqs_active <> 2
				$orderBy";
		$query = $this->eqs->query($sql);
		return $query;
	}
	
	// // add your functions here
	function update_delete()
	{
		$sql = "UPDATE eqs_equipments 
				SET	eqs_active=2, eqs_update_user=?, eqs_update_date=NOW()
				WHERE eqs_id=?";	
			
		$this->eqs->query($sql, array($this->eqs_update_user, $this->eqs_id));
	}

	function get_unique_th(){
		$sql = "SELECT eqs_id FROM eqs_equipments WHERE eqs_name = ?";
		$query = $this->eqs->query($sql,array($this->eqs_name));
		return $query;
	}

	function get_unique_th_with_id(){
		$sql = "SELECT * FROM eqs_equipments WHERE eqs_id != ? AND eqs_name = ?";
		$query = $this->eqs->query($sql,array($this->eqs_id ,$this->eqs_name));
		return $query;
	}

    /*
	* get_tools_by_room_id
	* get operative tools of room
	* @input sorting
	* @output operative tool list
	* @author Areerat Pongurai
	* @Create Date 10/06/2024
	* @Update Date 06/09/2024 Areerat - only eqs_active = 1
	*/
	function get_tools_by_room_id($aOrderBy=""){
		$orderBy = "";
		if ( is_array($aOrderBy) ) {
			$orderBy.= "ORDER BY "; 
			foreach ($aOrderBy as $key => $value) {
				$orderBy.= "$key $value, ";
			}
			$orderBy = substr($orderBy, 0, strlen($orderBy)-2);
		}
		$sql = "SELECT * 
				FROM eqs_equipments 
				WHERE eqs_active = 1 AND eqs_fmst_id=12 AND eqs_rm_id=?
				$orderBy";
		$query = $this->eqs->query($sql,array($this->eqs_rm_id));
		return $query;
	}
} // end class M_eqs_equipments
?>
