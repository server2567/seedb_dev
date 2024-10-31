<?php
/*
 * M_ums_user_config
 * Model for Manage about ums_user_config Table.
 * @Author Areerat Pongurai
 * @Create Date 13/09/2024
 */

include_once("Da_ums_user_config.php");

class M_ums_user_config extends Da_ums_user_config {
	/*
	* get_all_ref_ps
	* get all user_configs.
	* @input aOrderBy: array('fieldname' => 'ASC|DESC', ... )
	* $output list of user_config
	* @author Areerat Pongurai
	* @Create Date 13/09/2024
	*/
	function get_all_ref_ps($aOrderBy=""){
		$orderBy = "";
		if ( is_array($aOrderBy) ) {
			$orderBy.= "ORDER BY "; 
			foreach ($aOrderBy as $key => $value) {
				$orderBy.= "$key $value, ";
			}
			$orderBy = substr($orderBy, 0, strlen($orderBy)-2);
		}
		$sql = "SELECT usc_id, usc_us_id, usc_ps_id, usc_wts_is_noti, usc_wts_is_noti_sound, usc_ams_minute, usc_create_date, usc_update_date, 
					   CONCAT(pf.pf_name_abbr, ' ', ps.ps_fname, ' ', ps.ps_lname) AS ps_name, ps.ps_id,
					   us1.us_name AS create_user, us2.us_name AS update_user
				FROM ".$this->hr_db.".hr_person ps
				LEFT JOIN ums_user_config usc ON ps.ps_id = usc.usc_ps_id
                LEFT JOIN ".$this->hr_db.".hr_base_prefix pf ON pf.pf_id = ps.ps_pf_id
                LEFT JOIN ".$this->hr_db.".hr_person_position pos ON pos.pos_ps_id = ps.ps_id
                LEFT JOIN ".$this->hr_db.".hr_base_hire hire ON hire.hire_id = pos.pos_hire_id
				LEFT JOIN ums_user us1 ON usc.usc_create_user = us1.us_id
				LEFT JOIN ums_user us2 ON usc.usc_update_user = us2.us_id
				WHERE hire.hire_is_medical IN ('M')
				GROUP BY usc_id, usc_us_id, usc_wts_is_noti, usc_ams_minute, usc_create_user, usc_create_date, usc_update_user, usc_update_date, 
					   CONCAT(pf.pf_name_abbr, ' ', ps.ps_fname, ' ', ps.ps_lname), ps.ps_id,
					   us1.us_name, us2.us_name
				$orderBy";
		$query = $this->ums->query($sql);
		return $query;
	}

	/*
	* get_person_data_by_ps_id
	* get person_data by hr person id
	* @input usc_ps_id(hr_person id)
	* $output person data
	* @author Areerat Pongurai
	* @Create Date 16/09/2024
	*/
	function get_person_data_by_ps_id() {	
		$sql = "SELECT CONCAT(pf.pf_name, ' ', ps.ps_fname, ' ', ps.ps_lname) AS ps_name
				FROM ".$this->hr_db.".hr_person ps
                LEFT JOIN ".$this->hr_db.".hr_base_prefix pf ON pf.pf_id = ps.ps_pf_id
				WHERE ps.ps_id = ? ";
		$query = $this->ums->query($sql, array($this->usc_ps_id));
		return $query ;
	}

	/*
	* get_by_us_id
	* get data by usc_us_id
	* @input usc_us_id(ums_user id)
	* $output user config data
	* @author Areerat Pongurai
	* @Create Date 16/09/2024
	*/
	function get_by_us_id() {	
		$sql = "SELECT *
				FROM ums_user_config
				WHERE usc_us_id = ? ";
		$query = $this->ums->query($sql, array($this->usc_us_id));
		return $query ;
	}

	/*
	* get_by_ps_id
	* get data by usc_ps_id
	* @input usc_ps_id(hr_person id)
	* $output user config data
	* @author Areerat Pongurai
	* @Create Date 16/09/2024
	*/
	function get_by_ps_id() {	
		$sql = "SELECT *
				FROM ums_user_config
				WHERE usc_ps_id = ? ";
		$query = $this->ums->query($sql, array($this->usc_ps_id));
		return $query ;
	}
} // end class M_ums_user_config
?>
