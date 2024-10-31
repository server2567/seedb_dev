<?php

include_once("Da_ums_sync.php");

class M_ums_sync extends Da_ums_sync {

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
				FROM ums_sync 
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
	
	
	// // add your functions here
	function get_all_with_user($aOrderBy=""){
		$orderBy = "";
		if ( is_array($aOrderBy) ) {
			$orderBy.= "ORDER BY "; 
			foreach ($aOrderBy as $key => $value) {
				$orderBy.= "$key $value, ";
			}
			$orderBy = substr($orderBy, 0, strlen($orderBy)-2);
		}
		$sql = "SELECT *, us.us_name
				FROM ums_sync sync
				LEFT JOIN ums_user us ON sync.sync_us_id = us.us_id
				$orderBy";
		$query = $this->ums->query($sql);
		return $query;
	}

	// check duplicate by psd_id_card_no
	// check sync by us_ps_id = null
	function get_sync_all(){
		$sql = "SELECT CONCAT(pf.pf_name_abbr, ' ', ps.ps_fname, ' ', ps.ps_lname) as name, ps.ps_fname_en, ps.ps_lname_en, ps.ps_id, 
					psd.psd_birthdate, psd.psd_email, us.us_ps_id, us.us_username, us.us_password, us.us_id
				FROM ".$this->hr_db.".hr_person ps
				INNER JOIN ".$this->hr_db.".hr_person_detail psd ON ps.ps_id = psd.psd_ps_id 
				LEFT JOIN ".$this->hr_db.".hr_base_prefix pf ON pf_id = ps.ps_pf_id
				LEFT JOIN ums_user us ON psd_id_card_no = us.us_psd_id_card_no 
				WHERE us.us_ps_id is null AND ps.ps_status = 1";
		$query = $this->ums->query($sql);
		return $query;
	}

	function get_sync_search($first_name = null, $last_name = null){
		$where = "";
		if (!empty($first_name) && !empty($first_name))
			$where .= " AND ps.ps_fname LIKE '%".$first_name."%' AND ps.ps_lname LIKE '%".$last_name."%' ";
		else if (!empty($first_name))
			$where .= " AND ps.ps_fname LIKE '%".$first_name."%' ";
		else if (!empty($last_name))
			$where .= " AND ps.ps_lname LIKE '%".$last_name."%' ";
		$sql = "SELECT CONCAT(pf.pf_name_abbr, ' ', ps.ps_fname, ' ', ps.ps_lname) as name, ps.ps_fname_en, ps.ps_lname_en, ps.ps_id, 
					psd.psd_birthdate, psd.psd_email, us.us_ps_id, us.us_username, us.us_password, us.us_id
				FROM ".$this->hr_db.".hr_person ps
				INNER JOIN ".$this->hr_db.".hr_person_detail psd ON ps.ps_id = psd.psd_ps_id 
				LEFT JOIN ".$this->hr_db.".hr_base_prefix pf ON pf_id = ps.ps_pf_id
				LEFT JOIN ums_user us ON CONCAT(pf.pf_name_abbr, ' ', ps.ps_fname, ' ', ps.ps_lname) = us.us_name 
				WHERE us.us_ps_id is null AND ps.ps_status = 1 
					$where";
		$query = $this->ums->query($sql);
		return $query;
	}
	
	function check_username($username){
		$sql = "SELECT us_username FROM ums_user WHERE us_username=? ";
		$query = $this->ums->query($sql,array($username));
		if($query->num_rows() < 1)
			return 1;
		else
			return 0;
	}
} // end class M_ums_sync
?>
