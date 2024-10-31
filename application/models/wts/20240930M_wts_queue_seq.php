<?php
/*
* M_wts_queue_seq
* Model for Manage about wts_queue_seq Table.
* @input -
* $output -
* @author Areerat Pongurai
* @Create Date 21/08/2024
*/
include_once("Da_wts_queue_seq.php");

class M_wts_queue_seq extends Da_wts_queue_seq {
	
	/*
	* update_seq
	* update seq of queue
	* @input qus_psrm_id, qus_seq, qus_apm_id
	* $output -
	* @author Areerat Pongurai
	* @Create Date 21/08/2024
	*/
	function update_seq() {
		$sql = "UPDATE wts_queue_seq
				SET	qus_psrm_id=?, qus_seq=?, qus_app_walk=?
				WHERE qus_apm_id=?";	
		 
		$this->wts->query($sql, array($this->qus_psrm_id, $this->qus_seq, $this->qus_app_walk, $this->qus_apm_id));
	}
	
	/*
	* search_by_apm_id
	* seach have apm_id in wts_queue_seq
	* @input qus_apm_id
	* $output -
	* @author Areerat Pongurai
	* @Create Date 21/08/2024
	*/
	function search_by_apm_id() {
		$sql = "SELECT *
				FROM wts_queue_seq
				WHERE qus_apm_id=?";	
		 
		 $query = $this->wts->query($sql, array($this->qus_apm_id));
		 return $query;
	}

	function get_waiting_que_by_room($date, $room, $include_sta_ids) {
		$where = '';
		if(!empty($include_sta_ids)) {
			$include_sta_ids_string = implode(", ", array_map(function($item) {
				return $item;
			}, $include_sta_ids));
	
			$where = ' AND apm_sta_id in ('.$include_sta_ids_string.') ';
		}

		// $sql = "SELECT qus_psrm_id, qus_app_walk, see_eqsdb.eqs_room.rm_name, see_hrdb.hr_person_room.psrm_date, see_hrdb.hr_base_prefix.pf_name, see_hrdb.hr_person.ps_fname,
		// 		see_hrdb.hr_person.ps_lname, qus_seq, qus_apm_id, see_quedb.que_appointment.apm_ql_code, see_quedb.que_appointment.apm_app_walk, see_quedb.que_appointment.apm_sta_id, see_quedb.que_appointment.apm_date, see_quedb.que_appointment.apm_time, see_quedb.que_appointment.apm_pri_id, que_base_priority.pri_name
		// 		FROM see_wtsdb.wts_queue_seq
		// 		LEFT JOIN see_hrdb.hr_person_room ON qus_psrm_id =psrm_id
		// 		LEFT JOIN see_eqsdb.eqs_room ON see_hrdb.hr_person_room.psrm_rm_id = rm_id
		// 		LEFT JOIN see_hrdb.hr_person ON see_hrdb.hr_person_room.psrm_ps_id = ps_id
		// 		LEFT JOIN see_hrdb.hr_base_prefix ON see_hrdb.hr_person.ps_pf_id = pf_id
		// 		LEFT JOIN see_quedb.que_appointment ON qus_apm_id = apm_id
		// 		LEFT JOIN see_quedb.que_base_priority ON pri_id = apm_pri_id
		// 		WHERE see_quedb.que_appointment.apm_date = ?
		// 		AND qus_psrm_id = ?
		// 		AND see_quedb.que_appointment.apm_pri_id != '3'
		// 		{$where}
		// 		ORDER BY qus_seq ASC
		// ";

		$sql = "SELECT qus_psrm_id, qus_app_walk, see_eqsdb.eqs_room.rm_name, see_hrdb.hr_person_room.psrm_date, see_hrdb.hr_base_prefix.pf_name, see_hrdb.hr_base_prefix.pf_name_abbr, see_hrdb.hr_person.ps_fname,
			see_hrdb.hr_person.ps_lname, qus_seq, qus_apm_id, see_quedb.que_appointment.apm_ql_code, see_quedb.que_appointment.apm_app_walk, see_quedb.que_appointment.apm_sta_id, see_quedb.que_appointment.apm_date, see_quedb.que_appointment.apm_time, see_quedb.que_appointment.apm_pri_id, que_base_priority.pri_name
			FROM see_wtsdb.wts_queue_seq
			LEFT JOIN see_quedb.que_appointment ON qus_apm_id = apm_id
			LEFT JOIN see_hrdb.hr_person ON ps_id = apm_ps_id
			LEFT JOIN see_hrdb.hr_base_prefix ON ps_pf_id = pf_id
			LEFT JOIN see_quedb.que_base_priority ON pri_id = apm_pri_id
			LEFT JOIN see_hrdb.hr_person_room ON qus_psrm_id =psrm_id
			LEFT JOIN see_eqsdb.eqs_room ON psrm_rm_id = rm_id
			WHERE see_quedb.que_appointment.apm_date = ?
			AND qus_psrm_id = ?
			AND see_quedb.que_appointment.apm_pri_id != '3'
			{$where}
			ORDER BY qus_seq ASC
		";

		$query = $this->wts->query($sql, array($date, $room));
		return $query;
	}

	/*
	* get_waiting_que_by_doctor
	* get list of doctor to show wait queue
	* @input $date, $ps_id, $include_sta_ids
	* $output -
	* @author Areerat Pongurai
	* @Create Date 05/09/2024
	*/
	function get_waiting_que_by_doctor($date, $ps_id, $include_sta_ids) {
		$where = '';
		if(!empty($include_sta_ids)) {
			$include_sta_ids_string = implode(", ", array_map(function($item) {
				return $item;
			}, $include_sta_ids));
	
			$where = ' AND apm_sta_id in ('.$include_sta_ids_string.') ';
		}

		$sql = "SELECT qus_psrm_id, qus_app_walk, see_eqsdb.eqs_room.rm_name, see_hrdb.hr_person_room.psrm_date, see_hrdb.hr_base_prefix.pf_name, see_hrdb.hr_base_prefix.pf_name_abbr, see_hrdb.hr_person.ps_fname,
			see_hrdb.hr_person.ps_lname, see_hrdb.hr_person.ps_id, see_hrdb.hr_person_detail.psd_picture, qus_seq, qus_apm_id, see_quedb.que_appointment.apm_ql_code, see_quedb.que_appointment.apm_app_walk, see_quedb.que_appointment.apm_sta_id, see_quedb.que_appointment.apm_date, see_quedb.que_appointment.apm_time, see_quedb.que_appointment.apm_pri_id, que_base_priority.pri_name
			FROM see_wtsdb.wts_queue_seq
			LEFT JOIN see_quedb.que_appointment ON qus_apm_id = apm_id
			LEFT JOIN see_hrdb.hr_person ON ps_id = apm_ps_id
			LEFT JOIN see_hrdb.hr_person_detail ON ps_id = psd_ps_id
			LEFT JOIN see_hrdb.hr_base_prefix ON ps_pf_id = pf_id
			LEFT JOIN see_quedb.que_base_priority ON pri_id = apm_pri_id
			LEFT JOIN see_hrdb.hr_person_room ON qus_psrm_id =psrm_id
			LEFT JOIN see_eqsdb.eqs_room ON psrm_rm_id = rm_id
			WHERE see_quedb.que_appointment.apm_date = ?
			AND apm_ps_id = ?
			AND see_quedb.que_appointment.apm_pri_id != '3'
			{$where}
			ORDER BY qus_seq ASC
		";

		$query = $this->wts->query($sql, array($date, $ps_id));
		return $query;
	}


	function get_waiting_room($date, $stde) {
		$sql = "SELECT qus_psrm_id, qus_app_walk, see_eqsdb.eqs_room.rm_name, see_hrdb.hr_person_room.psrm_date, see_hrdb.hr_base_prefix.pf_name, see_hrdb.hr_base_prefix.pf_name_abbr, see_hrdb.hr_person.ps_id, see_hrdb.hr_person.ps_fname,
				see_hrdb.hr_person.ps_lname, qus_seq, qus_apm_id, see_quedb.que_appointment.apm_ql_code, see_quedb.que_appointment.apm_date, see_quedb.que_appointment.apm_pri_id, que_base_priority.pri_name
				FROM see_wtsdb.wts_queue_seq
				LEFT JOIN see_quedb.que_appointment ON qus_apm_id = apm_id
				LEFT JOIN see_hrdb.hr_person ON ps_id = apm_ps_id
				LEFT JOIN see_hrdb.hr_base_prefix ON ps_pf_id = pf_id
				LEFT JOIN see_quedb.que_base_priority ON pri_id = apm_pri_id
				LEFT JOIN see_hrdb.hr_person_room ON qus_psrm_id =psrm_id
				LEFT JOIN see_eqsdb.eqs_room ON psrm_rm_id = rm_id
				-- LEFT JOIN see_hrdb.hr_person_room ON qus_psrm_id =psrm_id
				-- LEFT JOIN see_eqsdb.eqs_room ON see_hrdb.hr_person_room.psrm_rm_id = rm_id
				-- LEFT JOIN see_hrdb.hr_person ON see_hrdb.hr_person_room.psrm_ps_id = ps_id
				-- LEFT JOIN see_hrdb.hr_base_prefix ON see_hrdb.hr_person.ps_pf_id = pf_id
				-- LEFT JOIN see_quedb.que_appointment ON qus_apm_id = apm_id
				-- LEFT JOIN see_quedb.que_base_priority ON pri_id = apm_pri_id
				WHERE 
				see_quedb.que_appointment.apm_date = ?
				AND see_quedb.que_appointment.apm_stde_id = ?
				ORDER BY psrm_rm_id DESC
		";

		$query = $this->wts->query($sql, array($date, $stde));
		return $query;
	}
	
	/*
	* get_waiting_doctor_by_floor
	* get list of doctor to show wait queue
	* @input $date, $floor
	* $output -
	* @author Areerat Pongurai
	* @Create Date 06/09/2024
	*/
	function get_waiting_doctor_by_floor($date, $floor) {
		$sql = "SELECT qus_psrm_id, qus_app_walk, see_eqsdb.eqs_room.rm_name, see_hrdb.hr_person_room.psrm_date, see_hrdb.hr_base_prefix.pf_name, see_hrdb.hr_base_prefix.pf_name_abbr, see_hrdb.hr_person.ps_id, see_hrdb.hr_person.ps_fname,
				see_hrdb.hr_person.ps_lname, qus_seq, qus_apm_id, see_quedb.que_appointment.apm_ql_code, see_quedb.que_appointment.apm_date, see_quedb.que_appointment.apm_pri_id, que_base_priority.pri_name
				FROM see_wtsdb.wts_queue_seq
				LEFT JOIN see_quedb.que_appointment ON qus_apm_id = apm_id
				LEFT JOIN see_hrdb.hr_person ON ps_id = apm_ps_id
				LEFT JOIN see_hrdb.hr_base_prefix ON ps_pf_id = pf_id
				LEFT JOIN see_quedb.que_base_priority ON pri_id = apm_pri_id
				LEFT JOIN see_hrdb.hr_person_room ON qus_psrm_id =psrm_id
				LEFT JOIN see_eqsdb.eqs_room ON psrm_rm_id = rm_id
				-- LEFT JOIN see_hrdb.hr_person_room ON qus_psrm_id =psrm_id
				-- LEFT JOIN see_eqsdb.eqs_room ON see_hrdb.hr_person_room.psrm_rm_id = rm_id
				-- LEFT JOIN see_hrdb.hr_person ON see_hrdb.hr_person_room.psrm_ps_id = ps_id
				-- LEFT JOIN see_hrdb.hr_base_prefix ON see_hrdb.hr_person.ps_pf_id = pf_id
				-- LEFT JOIN see_quedb.que_appointment ON qus_apm_id = apm_id
				-- LEFT JOIN see_quedb.que_base_priority ON pri_id = apm_pri_id
				WHERE 
				see_quedb.que_appointment.apm_date = ?
				AND see_eqsdb.eqs_room.rm_floor = ?
				ORDER BY psrm_rm_id DESC
		";

		$query = $this->wts->query($sql, array($date, $floor));
		return $query;
	}

	/*
	* update_psrm_id_by_apm_id
	* update seq by queue
	* @input apm_id
	* $output -
	* @author Areerat Pongurai
	* @Create Date 02/09/2024
	*/
	function update_psrm_id_by_apm_id() {
		$sql = "UPDATE wts_queue_seq
				SET	qus_psrm_id=?
				WHERE qus_apm_id=?";	
		 
		$this->wts->query($sql, array($this->qus_psrm_id, $this->qus_apm_id));
	}
	
	/*
	* insert_seq_by_max_psrm_id
	* insert row that seq = max seq of psrm_id
	* @input qus_psrm_id
	* $output -
	* @author Areerat Pongurai
	* @Create Date 02/09/2024
	*/
	function insert_seq_by_max_psrm_id() {
		// $sql = " INSERT INTO wts_queue_seq (qus_psrm_id, qus_seq, qus_apm_id)
		// 		 VALUES (?, (SELECT COALESCE(MAX(qus_seq), 0) + 1 FROM wts_queue_seq WHERE qus_psrm_id = ?), ?) ";	
		$sql = " 
		INSERT INTO wts_queue_seq (qus_psrm_id, qus_seq, qus_apm_id, qus_app_walk)
			SELECT ?, COALESCE(MAX(qus_seq), 0) + 1, ?, ?
			FROM wts_queue_seq 
			WHERE qus_psrm_id = ?
		" ;
		$query = $this->wts->query($sql, array($this->qus_psrm_id, $this->qus_apm_id, $this->qus_app_walk, $this->qus_psrm_id));
		return $query;
	}

} // end class M_wts_disease
?>
