<?php

include_once("Da_eqs_room.php");

class M_eqs_room extends Da_eqs_room {

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
				FROM eqs_room 
				$orderBy";
		$query = $this->eqs->query($sql);
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
	
	
	// // add your functions here
	function get_unique_th(){
		$sql = "SELECT rm_id FROM eqs_room WHERE rm_name = ?";
		$query = $this->eqs->query($sql,array($this->rm_name));
		return $query;
	}

	function get_unique_th_with_id(){
		$sql = "SELECT * FROM eqs_room WHERE rm_id != ? AND rm_name = ?";
		$query = $this->eqs->query($sql,array($this->rm_id ,$this->rm_name));
		return $query;
	}

    /*
	* get_rooms_tools
	* get all room and amount of tool
	* @input 
		aOrderBy = array('fieldname' => 'ASC|DESC', ... )
		eqs_status: eqs_equipments.eqs_status
	* @output room and amount of tool list
	* @author Areerat Pongurai
	* @Create Date 14/08/2024
	*/
	function get_rooms_tools($aOrderBy="", $eqs_status=""){
		$orderBy = "";
		if ( is_array($aOrderBy) ) {
			$orderBy.= "ORDER BY "; 
			foreach ($aOrderBy as $key => $value) {
				$orderBy.= "$key $value, ";
			}
			$orderBy = substr($orderBy, 0, strlen($orderBy)-2);
		}
		$where = "";
		if (!empty($eqs_status)) {
			$where = " AND eqs.eqs_status = " . $eqs_status;
		}
		$sql = "SELECT rm.rm_id, rm.rm_name, COUNT(eqs.eqs_id) eqs_amount 
				FROM eqs_room rm
				LEFT JOIN eqs_equipments eqs ON eqs.eqs_rm_id = rm.rm_id 
				WHERE rm.rm_status_id = 1 AND eqs_fmst_id=12 $where
				GROUP BY rm.rm_id, rm.rm_name 
				$orderBy ";
		$query = $this->eqs->query($sql);
    // echo $this->eqs->last_query(); die;
		return $query;
	}

    /*
	* get_all_by_rm_bdtype_id
	* get all room by_rm_bdtype_id
	* @input rm_bdtype_id
	* @output room list
	* @author Areerat Pongurai
	* @Create Date 22/08/2024
	*/
	function get_all_by_rm_bdtype_id($rm_bdtype_id){
		$sql = "SELECT rm.*, stde.stde_name_th
				FROM eqs_room rm
				LEFT JOIN see_hrdb.hr_structure_detail stde ON rm.rm_stde_id =  stde.stde_id
				WHERE rm.rm_bdtype_id = {$rm_bdtype_id}
				ORDER BY rm.rm_name
				";
		$query = $this->eqs->query($sql);
		return $query;
	}

    /*
	* get_room_by_floor
	* get all room by floor
	* @input rm_floor
	* @output room list
	* @author Areerat Pongurai
	* @Create Date 09/09/2024
	*/
	function get_room_by_floor($rm_floor){
		$sql = "SELECT rm.*, stde.stde_name_th
				FROM eqs_room rm
				LEFT JOIN see_hrdb.hr_structure_detail stde ON rm.rm_stde_id =  stde.stde_id
				WHERE rm.rm_floor = {$rm_floor}
				ORDER BY rm.rm_name
				";
		$query = $this->eqs->query($sql);
		return $query;
	}

	function get_stde_room_by_psrm_id($psrm_id) {
		$sql = "SELECT rm.rm_stde_id
		FROM eqs_room rm
		LEFT JOIN see_hrdb.hr_person_room psrm ON rm.rm_id = psrm.psrm_rm_id
        LEFT JOIN see_hrdb.hr_structure_detail stde ON rm.rm_stde_id =  stde.stde_id
		WHERE psrm.psrm_id = {$psrm_id}
		";
		$query = $this->eqs->query($sql);
		return $query;
	}
} // end class M_eqs_room
?>
