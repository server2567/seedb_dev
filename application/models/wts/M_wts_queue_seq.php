<?php
/*
* M_wts_queue_seq
* Model for Manage about wts_queue_seq Table.
* @input -
* $output -
* @author Areerat Pongurai
* @Create Date 21/08/2024
dev
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
				SET	qus_psrm_id=?, qus_seq=?, qus_app_walk=?, qus_announce=?, qus_time_start=?, qus_time_end=?
				WHERE qus_apm_id=?";	
		 
		$this->wts->query($sql, array($this->qus_psrm_id, $this->qus_seq, $this->qus_app_walk, $this->qus_announce, $this->qus_time_start, $this->qus_time_end, $this->qus_apm_id));
	}

	function update_seq_by_announce_id() {
		$sql = "UPDATE wts_queue_seq
				SET	qus_psrm_id=?, qus_seq=?, qus_app_walk=?, qus_announce=?, qus_time_start=?, qus_time_end=?
				WHERE qus_announce_id=?";	
		 
		$this->wts->query($sql, array($this->qus_psrm_id, $this->qus_seq, $this->qus_app_walk, $this->qus_announce, $this->qus_time_start, $this->qus_time_end, $this->qus_announce_id));
	}
	public function delete_by_apm_id($apm_id) {
		$sql = "DELETE FROM wts_queue_seq 
				WHERE qus_apm_id = ?";
	
		// Use the parameter passed to the function
		return $this->wts->query($sql, array($apm_id)); // Return the result of the query execution
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

	function search_by_announce_id($announce_id, $psrm_id) {
		$sql = "SELECT *
		FROM wts_queue_seq
		WHERE qus_announce_id=? AND qus_psrm_id=?";	
 
 $query = $this->wts->query($sql, array($announce_id, $psrm_id));
 return $query;
	}

	function search_apm_id_by_announce_id($announce_id) {
		$sql = "SELECT qus_apm_id
		FROM wts_queue_seq
		WHERE qus_announce_id=?";	
 
 $query = $this->wts->query($sql, array($announce_id));
 return $query;

	}

	function get_lastest_announce_id() {
		$sql = "SELECT qus_announce_id
		FROM wts_queue_seq
		ORDER BY qus_announce_id DESC
		LIMIT 1";	
 
		$query = $this->wts->query($sql, array());
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
			ORDER BY CAST(see_quedb.que_appointment.apm_ql_code AS UNSIGNED) ASC
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
    // $where .= ' AND (see_eqsdb.eqs_room.rm_floor != 1 OR apm_stde_id NOT IN (81)) ';
    // $where .= ' AND (see_eqsdb.eqs_room.rm_floor != 2 OR apm_stde_id NOT IN (68)) ';

		$sql = "SELECT qus_psrm_id, qus_app_walk, see_eqsdb.eqs_room.rm_name, see_hrdb.hr_structure_detail.stde_name_th, see_hrdb.hr_person_room.psrm_date, see_hrdb.hr_base_prefix.pf_name, see_hrdb.hr_base_prefix.pf_name_abbr, see_hrdb.hr_person.ps_fname,
			see_hrdb.hr_person.ps_lname, see_hrdb.hr_person.ps_id, see_hrdb.hr_person_detail.psd_picture, qus_seq, qus_apm_id, see_quedb.que_appointment.apm_ql_code, see_quedb.que_appointment.apm_app_walk, see_quedb.que_appointment.apm_sta_id, see_quedb.que_base_status.sta_show, see_quedb.que_base_status.sta_show_en, see_quedb.que_appointment.apm_date, see_quedb.que_appointment.apm_time, see_quedb.que_appointment.apm_pri_id, que_base_priority.pri_name,see_wtsdb.wts_queue_seq.qus_announce,
      see_quedb.que_appointment.apm_pt_id
			FROM see_wtsdb.wts_queue_seq
			LEFT JOIN see_quedb.que_appointment ON qus_apm_id = apm_id
			LEFT JOIN see_hrdb.hr_person ON ps_id = apm_ps_id
			LEFT JOIN see_hrdb.hr_person_detail ON ps_id = psd_ps_id
			LEFT JOIN see_hrdb.hr_base_prefix ON ps_pf_id = pf_id
			LEFT JOIN see_quedb.que_base_priority ON pri_id = apm_pri_id
			LEFT JOIN see_quedb.que_base_status ON sta_id = apm_sta_id
			LEFT JOIN see_hrdb.hr_person_room ON qus_psrm_id =psrm_id
			LEFT JOIN see_eqsdb.eqs_room ON psrm_rm_id = rm_id
			LEFT JOIN see_hrdb.hr_structure_detail ON rm_stde_id = stde_id
			WHERE see_quedb.que_appointment.apm_date = ?
			AND apm_ps_id = ?
			AND see_quedb.que_appointment.apm_pri_id != '3'
			AND apm_dp_id = '1'
			{$where}
      		GROUP BY apm_id
			ORDER BY  
				CASE 
					WHEN see_quedb.que_appointment.apm_pri_id = 1 THEN 1
					WHEN see_quedb.que_appointment.apm_pri_id = 6 THEN 2
					WHEN see_quedb.que_appointment.apm_ql_code LIKE 'I-%' THEN 3
					ELSE 4
				END,
				CASE 
					WHEN see_quedb.que_appointment.apm_ql_code LIKE 'I-%' THEN see_quedb.que_appointment.apm_time
					ELSE NULL
				END,
				CASE WHEN see_quedb.que_appointment.apm_ql_code IS NULL THEN 1 ELSE 0 END ASC, 
				CASE WHEN see_wtsdb.wts_queue_seq.qus_seq IS NULL THEN 1 ELSE 0 END ASC, 
				CAST(see_quedb.que_appointment.apm_ql_code AS UNSIGNED) ASC,  
				see_wtsdb.wts_queue_seq.qus_seq ASC;
			";
		$query = $this->wts->query($sql, array($date, $ps_id));
    // echo $this->wts->last_query(); die;
		return $query;
	}

	function get_waiting_que_by_doctor_clinic($date, $ps_id, $include_sta_ids) {
		$where = '';
		if(!empty($include_sta_ids)) {
			$include_sta_ids_string = implode(", ", array_map(function($item) {
				return $item;
			}, $include_sta_ids));
	 
			$where = ' AND apm_sta_id in ('.$include_sta_ids_string.') ';
		}
    // $where .= ' AND (see_eqsdb.eqs_room.rm_floor != 1 OR apm_stde_id NOT IN (81)) ';
    // $where .= ' AND (see_eqsdb.eqs_room.rm_floor != 2 OR apm_stde_id NOT IN (68)) ';

		$sql = "SELECT qus_psrm_id, qus_app_walk, see_eqsdb.eqs_room.rm_name, see_hrdb.hr_structure_detail.stde_name_th, see_hrdb.hr_person_room.psrm_date, see_hrdb.hr_base_prefix.pf_name, see_hrdb.hr_base_prefix.pf_name_abbr, see_hrdb.hr_person.ps_fname,
			see_hrdb.hr_person.ps_lname, see_hrdb.hr_person.ps_id, see_hrdb.hr_person_detail.psd_picture, qus_seq, qus_apm_id, see_quedb.que_appointment.apm_ql_code, see_quedb.que_appointment.apm_app_walk, see_quedb.que_appointment.apm_sta_id, see_quedb.que_base_status.sta_show, see_quedb.que_base_status.sta_show_en, see_quedb.que_appointment.apm_date, see_quedb.que_appointment.apm_time, see_quedb.que_appointment.apm_pri_id, que_base_priority.pri_name,see_wtsdb.wts_queue_seq.qus_announce,
      see_quedb.que_appointment.apm_pt_id
			FROM see_wtsdb.wts_queue_seq
			LEFT JOIN see_quedb.que_appointment ON qus_apm_id = apm_id
			LEFT JOIN see_hrdb.hr_person ON ps_id = apm_ps_id
			LEFT JOIN see_hrdb.hr_person_detail ON ps_id = psd_ps_id
			LEFT JOIN see_hrdb.hr_base_prefix ON ps_pf_id = pf_id
			LEFT JOIN see_quedb.que_base_priority ON pri_id = apm_pri_id
			LEFT JOIN see_quedb.que_base_status ON sta_id = apm_sta_id
			LEFT JOIN see_hrdb.hr_person_room ON qus_psrm_id =psrm_id
			LEFT JOIN see_eqsdb.eqs_room ON psrm_rm_id = rm_id
			LEFT JOIN see_hrdb.hr_structure_detail ON rm_stde_id = stde_id
			WHERE see_quedb.que_appointment.apm_date = ?
			AND apm_ps_id = ?
			AND see_quedb.que_appointment.apm_pri_id != '3'
			AND apm_dp_id = '2'
			{$where}
      		GROUP BY apm_id
			ORDER BY  
				CASE 
					WHEN see_quedb.que_appointment.apm_pri_id = 1 THEN 1
					WHEN see_quedb.que_appointment.apm_pri_id = 6 THEN 2
					WHEN see_quedb.que_appointment.apm_ql_code LIKE 'I-%' THEN 3
					ELSE 4
				END,
				CASE 
					WHEN see_quedb.que_appointment.apm_ql_code LIKE 'I-%' THEN see_quedb.que_appointment.apm_time
					ELSE NULL
				END,
				CASE WHEN see_quedb.que_appointment.apm_ql_code IS NULL THEN 1 ELSE 0 END ASC, 
				CASE WHEN see_wtsdb.wts_queue_seq.qus_seq IS NULL THEN 1 ELSE 0 END ASC, 
				CAST(see_quedb.que_appointment.apm_ql_code AS UNSIGNED) ASC,  
				see_wtsdb.wts_queue_seq.qus_seq ASC;
			";
		$query = $this->wts->query($sql, array($date, $ps_id));
    // echo $this->wts->last_query(); die;
		return $query;
	}

  function get_waiting_que_by_doctor_den($date, $ps_id, $include_sta_ids) {
		$where = '';
		if(!empty($include_sta_ids)) {
			$include_sta_ids_string = implode(", ", array_map(function($item) {
				return $item;
			}, $include_sta_ids));
	
			$where = ' AND apm_sta_id in ('.$include_sta_ids_string.') ';
		}
    // $where .= ' AND (see_eqsdb.eqs_room.rm_floor != 1 OR apm_stde_id NOT IN (81)) ';
    // $where .= ' AND (see_eqsdb.eqs_room.rm_floor != 2 OR apm_stde_id IN (68)) ';
		$sql = "SELECT qus_psrm_id, qus_app_walk, see_eqsdb.eqs_room.rm_name, see_hrdb.hr_structure_detail.stde_name_th, see_hrdb.hr_person_room.psrm_date, see_hrdb.hr_base_prefix.pf_name, see_hrdb.hr_base_prefix.pf_name_abbr, see_hrdb.hr_person.ps_fname,
			see_hrdb.hr_person.ps_lname, see_hrdb.hr_person.ps_id, see_hrdb.hr_person_detail.psd_picture, qus_seq, qus_apm_id, see_quedb.que_appointment.apm_ql_code, see_quedb.que_appointment.apm_app_walk, see_quedb.que_appointment.apm_sta_id, see_quedb.que_appointment.apm_date, see_quedb.que_appointment.apm_time, see_quedb.que_appointment.apm_pri_id, que_base_priority.pri_name,see_wtsdb.wts_queue_seq.qus_announce
			FROM see_wtsdb.wts_queue_seq
			LEFT JOIN see_quedb.que_appointment ON qus_apm_id = apm_id
			LEFT JOIN see_hrdb.hr_person ON ps_id = apm_ps_id
			LEFT JOIN see_hrdb.hr_person_detail ON ps_id = psd_ps_id
			LEFT JOIN see_hrdb.hr_base_prefix ON ps_pf_id = pf_id
			LEFT JOIN see_quedb.que_base_priority ON pri_id = apm_pri_id
			LEFT JOIN see_hrdb.hr_person_room ON qus_psrm_id =psrm_id
			LEFT JOIN see_eqsdb.eqs_room ON psrm_rm_id = rm_id
			LEFT JOIN see_hrdb.hr_structure_detail ON rm_stde_id = stde_id
			WHERE see_quedb.que_appointment.apm_date = ?
			AND apm_ps_id = ? 
			AND see_quedb.que_appointment.apm_pri_id != '3'
			{$where}
      GROUP BY apm_id
			ORDER BY qus_seq ASC
		";

		// echo $sql; die();
		$query = $this->wts->query($sql, array($date, $ps_id));
    // pre($this->wts->last_query()); die;
		return $query;
	}

	function get_waiting_que_by_doctor_stde_id($date, $ps_id, $include_sta_ids) {
		$where = '';
		$stde_id = $this->db->query("SELECT stde_id FROM see_hrdb.hr_structure_detail
					WHERE stde_name_th LIKE '%แผนกศูนย์เคลียร์เลสิค%' AND stde_active = '1' ");
		
		// Extract stde_id values into a simple array
		$stde_id_array = array_column($stde_id->result_array(), 'stde_id');

		// Check if we have results, convert array to a comma-separated list
		if (!empty($stde_id_array)) {
		$stde_id_list = implode(',', $stde_id_array);
		} else {
		// If no matching stde_id, handle gracefully (e.g., empty list or default value)
		$stde_id_list = '0'; // Default to 0 if no stde_id found to prevent SQL error
		}
			
		if(!empty($include_sta_ids)) {
			$include_sta_ids_string = implode(", ", array_map(function($item) {
				return $item;
			}, $include_sta_ids));
	 
			$where = ' AND apm_sta_id in ('.$include_sta_ids_string.') ';
		}

		$sql = "SELECT qus_psrm_id, qus_app_walk, see_eqsdb.eqs_room.rm_name, see_hrdb.hr_structure_detail.stde_name_th, see_hrdb.hr_person_room.psrm_date, see_hrdb.hr_base_prefix.pf_name, see_hrdb.hr_base_prefix.pf_name_abbr, see_hrdb.hr_person.ps_fname,
			see_hrdb.hr_person.ps_lname, see_hrdb.hr_person.ps_id, see_hrdb.hr_person_detail.psd_picture, qus_seq, qus_apm_id, see_quedb.que_appointment.apm_ql_code, see_quedb.que_appointment.apm_app_walk, see_quedb.que_appointment.apm_sta_id, see_quedb.que_base_status.sta_show, see_quedb.que_base_status.sta_show_en, see_quedb.que_appointment.apm_date, see_quedb.que_appointment.apm_time, see_quedb.que_appointment.apm_pri_id, que_base_priority.pri_name,see_wtsdb.wts_queue_seq.qus_announce
      		,see_quedb.que_appointment.apm_stde_id
			FROM see_wtsdb.wts_queue_seq
			LEFT JOIN see_quedb.que_appointment ON qus_apm_id = apm_id
			LEFT JOIN see_hrdb.hr_person ON ps_id = apm_ps_id
			LEFT JOIN see_hrdb.hr_person_detail ON ps_id = psd_ps_id
			LEFT JOIN see_hrdb.hr_base_prefix ON ps_pf_id = pf_id
			LEFT JOIN see_quedb.que_base_priority ON pri_id = apm_pri_id
			LEFT JOIN see_quedb.que_base_status ON sta_id = apm_sta_id
			LEFT JOIN see_hrdb.hr_person_room ON qus_psrm_id =psrm_id
			LEFT JOIN see_eqsdb.eqs_room ON psrm_rm_id = rm_id
			LEFT JOIN see_hrdb.hr_structure_detail ON rm_stde_id = stde_id
			WHERE see_quedb.que_appointment.apm_date = ?
			AND apm_ps_id = ?
			AND see_quedb.que_appointment.apm_pri_id != '3'
			-- AND apm_stde_id IN ($stde_id_list)
			{$where}
      		GROUP BY apm_id
			ORDER BY  
				CASE 
					WHEN see_quedb.que_appointment.apm_pri_id = 1 THEN 1
					WHEN see_quedb.que_appointment.apm_pri_id = 6 THEN 2
					WHEN see_quedb.que_appointment.apm_ql_code LIKE 'I-%' THEN 3
					ELSE 4
				END,
				CASE 
					WHEN see_quedb.que_appointment.apm_ql_code LIKE 'I-%' THEN see_quedb.que_appointment.apm_time
					ELSE NULL
				END,
				CASE WHEN see_quedb.que_appointment.apm_ql_code IS NULL THEN 1 ELSE 0 END ASC, 
				CASE WHEN see_wtsdb.wts_queue_seq.qus_seq IS NULL THEN 1 ELSE 0 END ASC, 
				CAST(see_quedb.que_appointment.apm_ql_code AS UNSIGNED) ASC,  
				see_wtsdb.wts_queue_seq.qus_seq ASC;
		";
	
		$query = $this->wts->query($sql, array($date, $ps_id));
    // echo $this->wts->last_query(); die;
		return $query;
	}

	function get_waiting_que_by_finance_medicine($date) {
    $sql = "SELECT qa_with_rn.*, qs.*, 
                status.sta_id AS status_sta_id, status.sta_name AS status_name, status.sta_name_en AS status_name_en, status.sta_color AS status_color,
                subquery.channel_names, subquery.channel_names_en, priority.*
            FROM (
            SELECT qa.*, ntd.*, 
                    ROW_NUMBER() OVER (PARTITION BY qa.apm_id ORDER BY ntd.ntdp_time_start DESC) AS rn
            FROM see_quedb.que_appointment AS qa
            LEFT JOIN see_wtsdb.wts_notifications_department AS ntd
            ON qa.apm_id = ntd.ntdp_apm_id 
              AND (
                  (ntdp_seq = 10 AND qa.apm_sta_id = 16) 
                  OR 
                  (ntdp_seq = 10 AND qa.apm_sta_id = 18) 
                  OR 
                  (ntdp_seq = 11 AND qa.apm_sta_id = 17) 
                  OR 
                  (ntdp_seq = 11 AND qa.apm_sta_id = 19)
              )
            WHERE qa.apm_date = ? 
            AND qa.apm_sta_id IN (16,17,18,19) AND apm_dp_id = '1'
            ) AS qa_with_rn
            LEFT JOIN see_wtsdb.wts_queue_seq AS qs 
            ON qs.qus_apm_id = qa_with_rn.apm_id
            LEFT JOIN see_wtsdb.wts_base_status AS status
            ON status.sta_id = qs.qus_status
            LEFT JOIN (
            SELECT 
              qs.qus_apm_id,
              -- Logic for Thai channel names
              TRIM(TRAILING ', ' FROM 
                  IF(
                      GROUP_CONCAT(DISTINCT channel.sta_name ORDER BY channel.sta_id DESC SEPARATOR ', ') REGEXP '^(ช่อง|ห้อง)',
                      SUBSTRING_INDEX(
                          GROUP_CONCAT(DISTINCT channel.sta_name ORDER BY channel.sta_id DESC SEPARATOR ', '),
                          ',',
                          1
                      ),
                      GROUP_CONCAT(DISTINCT channel.sta_name ORDER BY channel.sta_id DESC SEPARATOR ', ')
                  )
              ) AS channel_names,
              -- Logic for English channel names
              TRIM(TRAILING ', ' FROM 
                  IF(
                      GROUP_CONCAT(DISTINCT channel.sta_name_en ORDER BY channel.sta_id DESC SEPARATOR ', ') REGEXP '^(Medicine receptacle|Finance room)',
                      SUBSTRING_INDEX(
                          GROUP_CONCAT(DISTINCT channel.sta_name_en ORDER BY channel.sta_id DESC SEPARATOR ', '),
                          ',',
                          1
                      ),
                      GROUP_CONCAT(DISTINCT channel.sta_name_en ORDER BY channel.sta_id DESC SEPARATOR ', ')
                  )
              ) AS channel_names_en

          FROM 
              see_wtsdb.wts_queue_seq AS qs
          LEFT JOIN 
              see_wtsdb.wts_base_status AS channel
          ON 
              FIND_IN_SET(channel.sta_id, qs.qus_channel) > 0
          GROUP BY 
              qs.qus_apm_id
            ) AS subquery
            ON subquery.qus_apm_id = qa_with_rn.apm_id
            LEFT JOIN see_quedb.que_base_priority AS priority
            ON qa_with_rn.apm_pri_id = priority.pri_id
            WHERE qa_with_rn.rn = 1 
            GROUP BY qa_with_rn.apm_id 
            ORDER BY 
            CASE 
                WHEN priority.pri_id = 1 THEN 1
                WHEN priority.pri_id = 6 THEN 2
                ELSE 3
            END,
            CASE 
                WHEN qa_with_rn.apm_ql_code LIKE '%I%' THEN 1
                ELSE 2
            END,
            qa_with_rn.apm_rm_time ASC,
            qa_with_rn.apm_ql_code ASC";
		$query = $this->wts->query($sql, array($date));
		return $query;
	}

	function get_waiting_que_by_finance_medicine_clinic($date) {
    $sql = "SELECT qa_with_rn.*, qs.*, 
                status.sta_id AS status_sta_id, status.sta_name AS status_name, status.sta_name_en AS status_name_en, status.sta_color AS status_color,
                subquery.channel_names, subquery.channel_names_en, priority.*
            FROM (
            SELECT qa.*, ntd.*, 
                    ROW_NUMBER() OVER (PARTITION BY qa.apm_id ORDER BY ntd.ntdp_time_start DESC) AS rn
            FROM see_quedb.que_appointment AS qa
            LEFT JOIN see_wtsdb.wts_notifications_department AS ntd
            ON qa.apm_id = ntd.ntdp_apm_id 
              AND (
                  (ntdp_seq = 10 AND qa.apm_sta_id = 16) 
                  OR 
                  (ntdp_seq = 10 AND qa.apm_sta_id = 18) 
                  OR 
                  (ntdp_seq = 11 AND qa.apm_sta_id = 17) 
                  OR 
                  (ntdp_seq = 11 AND qa.apm_sta_id = 19)
              )
            WHERE qa.apm_date = ? 
            AND qa.apm_sta_id IN (16,17,18,19) AND apm_dp_id = '2'
            ) AS qa_with_rn
            LEFT JOIN see_wtsdb.wts_queue_seq AS qs 
            ON qs.qus_apm_id = qa_with_rn.apm_id
            LEFT JOIN see_wtsdb.wts_base_status AS status
            ON status.sta_id = qs.qus_status
            LEFT JOIN (
            SELECT 
              qs.qus_apm_id,
              -- Logic for Thai channel names
              TRIM(TRAILING ', ' FROM 
                  IF(
                      GROUP_CONCAT(DISTINCT channel.sta_name ORDER BY channel.sta_id DESC SEPARATOR ', ') REGEXP '^(ช่อง|ห้อง)',
                      SUBSTRING_INDEX(
                          GROUP_CONCAT(DISTINCT channel.sta_name ORDER BY channel.sta_id DESC SEPARATOR ', '),
                          ',',
                          1
                      ),
                      GROUP_CONCAT(DISTINCT channel.sta_name ORDER BY channel.sta_id DESC SEPARATOR ', ')
                  )
              ) AS channel_names,
              -- Logic for English channel names
              TRIM(TRAILING ', ' FROM 
                  IF(
                      GROUP_CONCAT(DISTINCT channel.sta_name_en ORDER BY channel.sta_id DESC SEPARATOR ', ') REGEXP '^(Medicine receptacle|Finance room)',
                      SUBSTRING_INDEX(
                          GROUP_CONCAT(DISTINCT channel.sta_name_en ORDER BY channel.sta_id DESC SEPARATOR ', '),
                          ',',
                          1
                      ),
                      GROUP_CONCAT(DISTINCT channel.sta_name_en ORDER BY channel.sta_id DESC SEPARATOR ', ')
                  )
              ) AS channel_names_en

          FROM 
              see_wtsdb.wts_queue_seq AS qs
          LEFT JOIN 
              see_wtsdb.wts_base_status AS channel
          ON 
              FIND_IN_SET(channel.sta_id, qs.qus_channel) > 0
          GROUP BY 
              qs.qus_apm_id
            ) AS subquery
            ON subquery.qus_apm_id = qa_with_rn.apm_id
            LEFT JOIN see_quedb.que_base_priority AS priority
            ON qa_with_rn.apm_pri_id = priority.pri_id
            WHERE qa_with_rn.rn = 1 
            GROUP BY qa_with_rn.apm_id 
            ORDER BY 
            CASE 
                WHEN priority.pri_id = 1 THEN 1
                WHEN priority.pri_id = 6 THEN 2
                ELSE 3
            END,
            CASE 
                WHEN qa_with_rn.apm_ql_code LIKE '%I%' THEN 1
                ELSE 2
            END,
            qa_with_rn.apm_rm_time ASC,
            qa_with_rn.apm_ql_code ASC";
		$query = $this->wts->query($sql, array($date));
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
		$us_dp_id = $this->session->userdata('us_dp_id');
		$sql = "
			SELECT qus_psrm_id, qus_app_walk, see_eqsdb.eqs_room.rm_name, see_hrdb.hr_person_room.psrm_date, see_hrdb.hr_base_prefix.pf_name, see_hrdb.hr_base_prefix.pf_name_abbr, see_hrdb.hr_person.ps_id, see_hrdb.hr_person.ps_fname,
					see_hrdb.hr_person.ps_lname, qus_seq, qus_apm_id, see_quedb.que_appointment.apm_ql_code, see_quedb.que_appointment.apm_date, see_quedb.que_appointment.apm_pri_id, que_base_priority.pri_name, see_hrdb.hr_structure_detail.stde_name_th, see_wtsdb.wts_queue_seq.qus_announce,see_hrdb.hr_person_room.psrm_rm_id,
			see_quedb.que_appointment.apm_pt_id
					FROM see_wtsdb.wts_queue_seq
					LEFT JOIN see_quedb.que_appointment ON qus_apm_id = apm_id
					LEFT JOIN see_hrdb.hr_person ON ps_id = apm_ps_id
					LEFT JOIN see_hrdb.hr_base_prefix ON ps_pf_id = pf_id
					LEFT JOIN see_quedb.que_base_priority ON pri_id = apm_pri_id
					LEFT JOIN see_hrdb.hr_person_room ON qus_psrm_id = psrm_id
					LEFT JOIN see_eqsdb.eqs_room ON psrm_rm_id = rm_id
					LEFT JOIN see_hrdb.hr_structure_detail ON rm_stde_id = stde_id
					WHERE 
					see_quedb.que_appointment.apm_date = ?
					AND see_eqsdb.eqs_room.rm_floor = ?
        	" . ($floor == 1 ? " AND see_eqsdb.eqs_room.rm_id NOT IN (38)" : "") . "
					" . ($floor == 2 ? " AND see_eqsdb.eqs_room.rm_id NOT IN (29, 30, 6, 28)" : "") . "
					AND see_quedb.que_appointment.apm_sta_id IN (2,4,11,12)
					AND DATE(see_hrdb.hr_person_room.psrm_date) = ?
					GROUP BY ps_id
					ORDER BY psrm_rm_id DESC 
			";
		// echo $sql; die;
			$query = $this->wts->query($sql, array($date, $floor, $date));
    	// echo $this->wts->last_query(); die;
		return $query;
	}

	function get_waiting_doctor_by_floor_clinic($date) {
		$sql = "
			SELECT qus_psrm_id, qus_app_walk, see_eqsdb.eqs_room.rm_name, see_hrdb.hr_person_room.psrm_date, see_hrdb.hr_base_prefix.pf_name, see_hrdb.hr_base_prefix.pf_name_abbr, see_hrdb.hr_person.ps_id, see_hrdb.hr_person.ps_fname,
					see_hrdb.hr_person.ps_lname, qus_seq, qus_apm_id, see_quedb.que_appointment.apm_ql_code, see_quedb.que_appointment.apm_date, see_quedb.que_appointment.apm_pri_id, que_base_priority.pri_name, see_hrdb.hr_structure_detail.stde_name_th, see_wtsdb.wts_queue_seq.qus_announce,see_hrdb.hr_person_room.psrm_rm_id,
			see_quedb.que_appointment.apm_pt_id
					FROM see_wtsdb.wts_queue_seq
					LEFT JOIN see_quedb.que_appointment ON qus_apm_id = apm_id
					LEFT JOIN see_hrdb.hr_person ON ps_id = apm_ps_id
					LEFT JOIN see_hrdb.hr_base_prefix ON ps_pf_id = pf_id
					LEFT JOIN see_quedb.que_base_priority ON pri_id = apm_pri_id
					LEFT JOIN see_hrdb.hr_person_room ON qus_psrm_id = psrm_id
					LEFT JOIN see_eqsdb.eqs_room ON psrm_rm_id = rm_id
					LEFT JOIN see_hrdb.hr_structure_detail ON rm_stde_id = stde_id
					WHERE 
					see_quedb.que_appointment.apm_date = ?
					AND see_quedb.que_appointment.apm_sta_id IN (2,4,11,12)
					AND DATE(see_hrdb.hr_person_room.psrm_date) = ?
					GROUP BY ps_id
					ORDER BY psrm_rm_id DESC 
			";
		// echo $sql; die;
			$query = $this->wts->query($sql, array($date, $date));
    	// echo $this->wts->last_query(); die;
		return $query;
	}

  function get_waiting_doctor_by_floor_den($date, $floor) {
    $sql = "
        SELECT qus_psrm_id, qus_app_walk, see_eqsdb.eqs_room.rm_name, see_hrdb.hr_person_room.psrm_date, see_hrdb.hr_base_prefix.pf_name, see_hrdb.hr_base_prefix.pf_name_abbr, see_hrdb.hr_person.ps_id, see_hrdb.hr_person.ps_fname,
               see_hrdb.hr_person.ps_lname, qus_seq, qus_apm_id, see_quedb.que_appointment.apm_ql_code, see_quedb.que_appointment.apm_date, see_quedb.que_appointment.apm_pri_id, que_base_priority.pri_name, see_hrdb.hr_structure_detail.stde_name_th, see_wtsdb.wts_queue_seq.qus_announce
        FROM see_wtsdb.wts_queue_seq
        LEFT JOIN see_quedb.que_appointment ON qus_apm_id = apm_id
        LEFT JOIN see_hrdb.hr_person ON ps_id = apm_ps_id
        LEFT JOIN see_hrdb.hr_base_prefix ON ps_pf_id = pf_id
        LEFT JOIN see_quedb.que_base_priority ON pri_id = apm_pri_id
        LEFT JOIN see_hrdb.hr_person_room ON qus_psrm_id = psrm_id
        LEFT JOIN see_eqsdb.eqs_room ON psrm_rm_id = rm_id
        LEFT JOIN see_hrdb.hr_structure_detail ON rm_stde_id = stde_id
        WHERE 
            see_quedb.que_appointment.apm_date = ?
            /* AND see_eqsdb.eqs_room.rm_floor = ?
            " . ($floor == 1 ? " AND see_eqsdb.eqs_room.rm_id NOT IN (43, 44)" : "") . " */
        ORDER BY psrm_rm_id DESC
    ";
		// echo $sql; die;
		$query = $this->wts->query($sql, array($date, $floor));
		// echo $this->que->last_query();
		return $query;
	}
	function get_announce_by_floor($date, $floor) {
		$sql = "SELECT qus_psrm_id,`qus_announce`,`qus_time_start`,`qus_time_end`, qus_app_walk, see_eqsdb.eqs_room.rm_name, see_hrdb.hr_person_room.psrm_date, see_hrdb.hr_base_prefix.pf_name, see_hrdb.hr_base_prefix.pf_name_abbr, see_hrdb.hr_person.ps_id, see_hrdb.hr_person.ps_fname,
				see_hrdb.hr_person.ps_lname, qus_seq, qus_apm_id, see_quedb.que_appointment.apm_ql_code, see_quedb.que_appointment.apm_date, see_quedb.que_appointment.apm_pri_id, que_base_priority.pri_name, see_hrdb.hr_structure_detail.stde_name_th,see_wtsdb.wts_queue_seq.qus_announce
				FROM see_wtsdb.wts_queue_seq
				LEFT JOIN see_quedb.que_appointment ON qus_apm_id = apm_id
				LEFT JOIN see_hrdb.hr_person ON ps_id = apm_ps_id
				LEFT JOIN see_hrdb.hr_base_prefix ON ps_pf_id = pf_id
				LEFT JOIN see_quedb.que_base_priority ON pri_id = apm_pri_id
				LEFT JOIN see_hrdb.hr_person_room ON qus_psrm_id =psrm_id
				LEFT JOIN see_eqsdb.eqs_room ON psrm_rm_id = rm_id
				LEFT JOIN see_hrdb.hr_structure_detail ON rm_stde_id = stde_id
				
				WHERE 
				see_quedb.que_appointment.apm_date = ?
				AND see_eqsdb.eqs_room.rm_floor = ?
                AND `qus_announce` IS NOT NULL
				ORDER BY psrm_rm_id DESC
		";
		// echo $sql;
		$query = $this->wts->query($sql, array($date, $floor));
		// echo $this->que->last_query();
		return $query;
	}
	function get_waiting_doctor_by_stde_id ($date){
		$stde_id = $this->db->query("SELECT stde_id FROM see_hrdb.hr_structure_detail
					WHERE stde_name_th LIKE '%แผนกศูนย์เคลียร์เลสิค%' AND stde_active = '1' ");
		
		// Extract stde_id values into a simple array
		$stde_id_array = array_column($stde_id->result_array(), 'stde_id');

		// Check if we have results, convert array to a comma-separated list
		if (!empty($stde_id_array)) {
		$stde_id_list = implode(',', $stde_id_array);
		} else {
		// If no matching stde_id, handle gracefully (e.g., empty list or default value)
		$stde_id_list = '0'; // Default to 0 if no stde_id found to prevent SQL error
		}
	
		$sql = "SELECT qus_psrm_id, qus_app_walk, see_eqsdb.eqs_room.rm_name, see_hrdb.hr_person_room.psrm_date, see_hrdb.hr_base_prefix.pf_name, see_hrdb.hr_base_prefix.pf_name_abbr, see_hrdb.hr_person.ps_id, see_hrdb.hr_person.ps_fname,
				see_hrdb.hr_person.ps_lname, qus_seq, qus_apm_id, see_quedb.que_appointment.apm_ql_code, see_quedb.que_appointment.apm_date, see_quedb.que_appointment.apm_pri_id, que_base_priority.pri_name, see_hrdb.hr_structure_detail.stde_name_th
				FROM see_wtsdb.wts_queue_seq
				LEFT JOIN see_quedb.que_appointment ON qus_apm_id = apm_id
				LEFT JOIN see_hrdb.hr_person ON ps_id = apm_ps_id
				LEFT JOIN see_hrdb.hr_base_prefix ON ps_pf_id = pf_id
				LEFT JOIN see_quedb.que_base_priority ON pri_id = apm_pri_id
				LEFT JOIN see_hrdb.hr_person_room ON qus_psrm_id =psrm_id
				LEFT JOIN see_eqsdb.eqs_room ON psrm_rm_id = rm_id
				LEFT JOIN see_hrdb.hr_structure_detail ON rm_stde_id = stde_id
				WHERE 
				see_quedb.que_appointment.apm_date = ? AND apm_sta_id IN (2,4)
				AND apm_stde_id IN ($stde_id_list)
				ORDER BY psrm_rm_id DESC
		";
		$query = $this->wts->query($sql, array($date));
		
		// echo $this->wts->last_query(); die;
		return $query;
	}
	function get_announce_by_stde_id ($date){
		$stde_id = $this->db->query("SELECT stde_id FROM see_hrdb.hr_structure_detail
					WHERE stde_name_th LIKE '%แผนกศูนย์เคลียร์เลสิค%' AND stde_active = '1' ");
		
		// Extract stde_id values into a simple array
		$stde_id_array = array_column($stde_id->result_array(), 'stde_id');

		// Check if we have results, convert array to a comma-separated list
		if (!empty($stde_id_array)) {
		$stde_id_list = implode(',', $stde_id_array);
		} else {
		// If no matching stde_id, handle gracefully (e.g., empty list or default value)
		$stde_id_list = '0'; // Default to 0 if no stde_id found to prevent SQL error
		}
	
		$sql = "SELECT qus_psrm_id, qus_app_walk,qus_announce,qus_time_start,qus_time_end,see_eqsdb.eqs_room.rm_name, see_hrdb.hr_person_room.psrm_date, see_hrdb.hr_base_prefix.pf_name, see_hrdb.hr_base_prefix.pf_name_abbr, see_hrdb.hr_person.ps_id, see_hrdb.hr_person.ps_fname,
				see_hrdb.hr_person.ps_lname, qus_seq, qus_apm_id, see_quedb.que_appointment.apm_ql_code, see_quedb.que_appointment.apm_date, see_quedb.que_appointment.apm_pri_id, que_base_priority.pri_name, see_hrdb.hr_structure_detail.stde_name_th
				FROM see_wtsdb.wts_queue_seq
				LEFT JOIN see_quedb.que_appointment ON qus_apm_id = apm_id
				LEFT JOIN see_hrdb.hr_person ON ps_id = apm_ps_id
				LEFT JOIN see_hrdb.hr_base_prefix ON ps_pf_id = pf_id
				LEFT JOIN see_quedb.que_base_priority ON pri_id = apm_pri_id
				LEFT JOIN see_hrdb.hr_person_room ON qus_psrm_id =psrm_id
				LEFT JOIN see_eqsdb.eqs_room ON psrm_rm_id = rm_id
				LEFT JOIN see_hrdb.hr_structure_detail ON rm_stde_id = stde_id
				-- LEFT JOIN see_hrdb.hr_person_room ON qus_psrm_id =psrm_id
				-- LEFT JOIN see_eqsdb.eqs_room ON see_hrdb.hr_person_room.psrm_rm_id = rm_id
				-- LEFT JOIN see_hrdb.hr_person ON see_hrdb.hr_person_room.psrm_ps_id = ps_id
				-- LEFT JOIN see_hrdb.hr_base_prefix ON see_hrdb.hr_person.ps_pf_id = pf_id
				-- LEFT JOIN see_quedb.que_appointment ON qus_apm_id = apm_id
				-- LEFT JOIN see_quedb.que_base_priority ON pri_id = apm_pri_id
				WHERE 
				see_quedb.que_appointment.apm_date = ?
				AND qus_announce IS NOT NULL
				AND see_eqsdb.eqs_room.rm_stde_id IN ($stde_id_list)
				ORDER BY psrm_rm_id DESC
		";
		$query = $this->wts->query($sql, array($date));
		
		// echo $this->que->last_query();
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
		INSERT INTO wts_queue_seq (qus_psrm_id, qus_seq, qus_apm_id, qus_app_walk, qus_announce, qus_time_start, qus_time_end)
			SELECT ?, COALESCE(MAX(qus_seq), 0) + 1, ?, ?, ?, ?, ?
			FROM wts_queue_seq 
			WHERE qus_psrm_id = ?
		" ;
		$query = $this->wts->query($sql, array($this->qus_psrm_id, $this->qus_apm_id, $this->qus_app_walk, $this->qus_announce, $this->qus_time_start, $this->qus_time_end, $this->qus_psrm_id));
		return $query;
	}

    public function get_announce_trello_wts($params) {
        $binds = array();
        $where = '';

        if (!empty($params['month'])) {
		    if(!empty($where)) $where .= " AND ";
            $where .= " MONTH(psrm.psrm_date) = ? ";
            $binds[] = $params['month'];
        }

        if (!empty($params['date'])) {
		    if(!empty($where)) $where .= " AND ";
            $dateParts = explode('/', $params['date']);
            $day = $dateParts[0];
            $month = $dateParts[1];
            $buddhistYear = $dateParts[2];
            $gregorianYear = (int)$buddhistYear - 543;
            $gregorianDate = $gregorianYear . '-' . $month . '-' . $day;
            $where .= " DATE(psrm.psrm_date) = ? ";
            $binds[] = $gregorianDate;
        } else {
		    if(!empty($where)) $where .= " AND ";
            $where .= " DATE(psrm.psrm_date) = CURDATE() ";
        }
        
        // check condition for order by
        $order = " ORDER BY qus.qus_seq ASC ";

        // if have parameter floor then where stde(แผนก) that in this floor

        $sql = " SELECT qus.qus_psrm_id,
						psrm.psrm_ps_id,
                    qus.qus_seq,
					qus.qus_announce_id,
					qus.qus_announce,
					qus.qus_time_start,
					qus.qus_time_end,
                    psrm.psrm_date
                FROM see_wtsdb.wts_queue_seq qus
                LEFT JOIN see_hrdb.hr_person_room psrm ON qus.qus_psrm_id = psrm.psrm_id
                LEFT JOIN see_hrdb.hr_person ps ON psrm.psrm_ps_id = ps.ps_id
                LEFT JOIN see_hrdb.hr_base_prefix pf ON pf.pf_id = ps.ps_pf_id
                WHERE {$where}";
                // apm.apm_stde_id IN ($stde_ids_str)

        $sql .= " GROUP BY qus.qus_psrm_id,
						psrm.psrm_ps_id,
                    qus.qus_seq,
					qus.qus_announce_id,
					qus.qus_announce,
					qus.qus_time_start,
					qus.qus_time_end,
                    psrm.psrm_date ";

        $sql .= $order;

        $query = $this->que->query($sql, $binds);
        if (!$sql) {
            log_message('error', 'Query error: ' . $this->db->_error_message());
        }

        return $query->result_array();
    }


} // end class M_wts_disease
?>
