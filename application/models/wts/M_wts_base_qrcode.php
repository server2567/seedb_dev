<?php
/*
* M_wts_base_disease
* Model for Manage about wts_base_disease Table.
* @input -
* $output -
* @author Supawee Sangrapee
* @Create Date 21/05/2024
*/
include_once("Da_wts_base_qrcode.php");

class M_wts_base_qrcode extends Da_wts_base_qrcode {
	
/*
* get_all_disease
* ดึงค่าข้อมูลประเภทโรคทั้งหมด
* @input -
* $output disease
* @author Supawee Sangrapee
* @Create Date 21/05/2024
*/
	function get_all() {
		$sql = "SELECT qr_id, qr_stde_id, hr_structure_detail.stde_name_th as qr_stde_name, qr_img_name, qr_img_path,
				qr_link, qr_deatile, qr_create_user, qr_create_date, qr_update_user, qr_update_date, ums_user.us_name as us_name
				FROM wts_base_qrcode
				LEFT JOIN see_hrdb.hr_structure_detail
				ON qr_stde_id = hr_structure_detail.stde_id
				LEFT JOIN see_umsdb.ums_user
				ON qr_update_user = ums_user.us_id
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
	function get_qr_list($qr_id) {
		$sql = "SELECT qr_id, qr_stde_id, hr_structure_detail.stde_name_th as qr_stde_name, qr_img_name, qr_img_path,
				qr_link, qr_deatile, qr_create_user, qr_create_date, qr_update_user, qr_update_date, ums_user.us_name as us_name
				FROM wts_base_qrcode
				LEFT JOIN ".$this->hr_db.".hr_structure_detail
				ON qr_stde_id = hr_structure_detail.stde_id
				LEFT JOIN ".$this->ums_db.".ums_user
				ON qr_update_user = ums_user.us_id
				WHERE qr_id = ?;
				";
		$query = $this->wts->query($sql, array($qr_id));
		return $query;		
	}

	public function get_qr_code_by_id($qr_id) {
		$sql = "SELECT qr_id, qr_stde_id, hr_structure_detail.stde_name_th as qr_stde_name, qr_img_name, qr_img_path,
				qr_link, qr_deatile, qr_create_user, qr_create_date, qr_update_user, qr_update_date, ums_user.us_name as us_name
				FROM wts_base_qrcode
				LEFT JOIN ".$this->hr_db.".hr_structure_detail
				ON qr_stde_id = hr_structure_detail.stde_id
				LEFT JOIN ".$this->ums_db.".ums_user
				ON qr_update_user = ums_user.us_id
				WHERE qr_id = ?
				";
        $query = $this->wts->query($sql, array($qr_id)); // ชื่อของตาราง QR Codes ในฐานข้อมูล
		return $query;
    }

	public function get_qr_last_id() {
		$sql = "SELECT MAX(qr_id) AS max_qr_id FROM `wts_base_qrcode`";
		$query = $this->wts->query($sql); // ชื่อของตาราง QR Codes ในฐานข้อมูล
		$result = $query->row(); // Get the first row of the result as an object
		return $result->max_qr_id; // Return the maximum qr_id
	}
	
} // end class M_wts_disease
?>
