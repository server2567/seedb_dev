<?php
/*
* M_wts_base_disease
* Model for Manage about wts_base_disease Table.
* @input -
* $output -
* @author Supawee Sangrapee
* @Create Date 21/05/2024
*/
include_once("Da_wts_qrcode_scan_patient.php");

class M_wts_qrcode_scan_patient extends Da_wts_qrcode_scan_patient {
	
/*
* get_all_disease
* ดึงค่าข้อมูลประเภทโรคทั้งหมด
* @input -
* $output disease
* @author Supawee Sangrapee
* @Create Date 21/05/2024
*/
	function get_all() {
		$sql = "SELECT qrsp_id, qrsp_pt_id, qrsp_qr_id, qrsp_dst_id, qrsp_date_time
				FROM wts_qrcode_scan_patient

				";
		$query = $this->wts->query($sql);

		return $query;		
	}

	function get_all_by_stde($stde_id) {
		$sql = "SELECT qrsp_id, qrsp_pt_id, qrsp_qr_id, qrsp_dst_id, qrsp_date_time
				FROM wts_qrcode_scan_patient
				LEFT JOIN wts_base_qrcode
				ON qrsp_qr_id = qr_id
				WHERE wts_base_qrcode.qr_stde_id = '$stde_id';
				";
		$query = $this->wts->query($sql);

		return $query;		
	}
/*
* get_disease_list
* ดึงค่าข้อมูลประเภทโรคตามไอดีประเภทโรค
* @input ds_id
* $output disease list by ds_id
* @author Supawee Sangrapee
* @Create Date 21/05/2024
*/
	function get_qr_list($stde_id) {
		$sql = "SELECT wts_qrcode_scan_patient.*, wts_base_disease_time.dst_name_point, hr_structure_detail.stde_name_th, wts_base_route_department.rdp_name, CONCAT(ums_patient.pt_prefix,ums_patient.pt_fname,' ', ums_patient.pt_lname) as pt_name
				FROM wts_qrcode_scan_patient
                LEFT JOIN wts_base_qrcode
                ON qrsp_qr_id = qr_id
				LEFT JOIN see_hrdb.hr_structure_detail
				ON qr_stde_id = stde_id
				LEFT JOIN see_umsdb.ums_patient
				ON qrsp_pt_id = pt_id
				LEFT JOIN see_quedb.que_appointment
                ON pt_id = apm_pt_id
				LEFT JOIN wts_notifications_department
				ON apm_id = ntdp_apm_id
				LEFT JOIN wts_base_route_department
				ON ntdp_rdp_id = rdp_id
				LEFT JOIN wts_base_disease_time
                ON qrsp_dst_id = dst_id
				WHERE wts_base_qrcode.qr_stde_id = ?
                GROUP BY qrsp_id
				ORDER BY qrsp_date_time DESC
				";
		$query = $this->wts->query($sql, array($stde_id));
		return $query;		
	}

	public function get_qr_code_by_id($qr_id) {
		$sql = "SELECT qr_id, wts_base_route_department.rdp_name as qr_rdp_name, qr_stde_id, hr_structure_detail.stde_name_th as qr_stde_name, qr_img_name, qr_img_path,
				qr_link, qr_deatile, qr_create_user, qr_create_date, qr_update_user, qr_update_date, ums_user.us_name as us_name
				FROM wts_base_qrcode
				LEFT JOIN see_hrdb.hr_structure_detail
				ON qr_stde_id = hr_structure_detail.stde_id
				LEFT JOIN see_umsdb.ums_user
				ON qr_update_user = ums_user.us_id
				WHERE qr_id = ?
				";
        $query = $this->wts->query($sql, array($qr_id)); // ชื่อของตาราง QR Codes ในฐานข้อมูล
		return $query;
    }

	public function get_count_qr_list_by_stde($stde_id) {
		$sql = "SELECT *
				FROM wts_qrcode_scan_patient
				LEFT JOIN wts_base_qrcode
				ON qrsp_qr_id = qr_id
				LEFT JOIN see_hrdb.hr_structure_detail
				ON wts_base_qrcode.qr_stde_id = stde_id
				WHERE stde_id = ?
				
				";
        $query = $this->wts->query($sql, array($stde_id)); // ชื่อของตาราง QR Codes ในฐานข้อมูล
		return $query;

	}

	public function get_qr_last_id() {
		$sql = "SELECT MAX(qr_id) AS max_qr_id FROM `wts_base_qrcode`";
		$query = $this->wts->query($sql); // ชื่อของตาราง QR Codes ในฐานข้อมูล
		$result = $query->row(); // Get the first row of the result as an object
		return $result->max_qr_id; // Return the maximum qr_id
	}

	public function set_qrcode_scan_log($data) {
		$this->wts->insert($this->wts_db . 'wts_qrcode_scan_patient', $data);
	}
	/*
* get_all_disease_name_type
* ดึงค่าข้อมูลชื่อประเภทโรคทั้งหมดที่มีการเปิดใช้งาน
* @input ds_id
* $output disease name type by ds_active = 1
* @author Supawee Sangrapee
* @Create Date 21/05/2024
*/
	// function get_all_disease_name_type($ds_active="1") {
	// 	$sql = "SELECT *
	// 			FROM ".$this->wts_db.".wts_base_disease
	// 			WHERE ds_active = '$ds_active'" ;
	// 	$query = $this->wts->query($sql);
	// 	return $query;
	// }

	// function get_all_disease_search($dn_id, $dnt_id, $stde_id)
	// {
	// 	$cond = "";
	// 	if($dn_id != "all"){
	// 		$cond .= "AND ".$this->wts_db.".ds_name_disease = {$dn_id}";
	// 	}
	// 	if($dnt_id != "all"){
	// 		$cond .= "AND ".$this->wts_db.".ds_name_disease_type = {$dnt_id}";
	// 	}
	// 	if($stde_id != "all"){
	// 		$cond .= "AND ".$this->wts_db.".ds_stde_id = {$stde_id}";
	// 	}
	// 	$sql = "SELECT ds_id, ".$this->hr_db.".hr_structure_detail.stde_name_th as stde_name, ds_name_disease_type, ds_name_disease_type_en, ds_name_disease, ds_name_disease_en, ds_detail, ds_detail_en, ds_stde_id, ds_update_date, ".$this->ums_db.".ums_user.us_name as user_name, ds_active
	// 			FROM wts_base_disease
	// 			LEFT JOIN ".$this->ums_db.".ums_user
	// 			ON ds_create_user = ".$this->ums_db.".ums_user.us_id
	// 			LEFT JOIN ".$this->hr_db.".hr_structure_detail
	// 			ON ds_stde_id = ".$this->hr_db.".hr_structure_detail.stde_id
	// 			LEFT JOIN ".$this->hr_db.".hr_structure
	// 			ON ".$this->hr_db.".hr_structure_detail.stde_stuc_id = ".$this->hr_db.".hr_structure.stuc_id
	// 			WHERE 	ds_id = {$ds_id}
	// 					{$cond}";
	// 	$query = $this->wts->query($sql);
	// 	return $query;
	// }
	
} // end class M_wts_disease
?>
