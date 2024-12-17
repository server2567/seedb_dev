<?php
// dev
include_once("Da_dim_examination_result_doc.php");

class M_dim_examination_result_doc extends Da_dim_examination_result_doc {

	function get_by_examination_result_id($withSetAttributeValue=FALSE) {	
		$sql = "SELECT * 
				FROM dim_examination_result_doc
				WHERE exrd_exr_id=? "; //  AND exrd_status = 1
		$query = $this->dim->query($sql, array($this->exrd_exr_id));
		if ( $withSetAttributeValue ) {
			$this->row2attribute( $query->row() );
		} else {
			return $query ;
		}
	}

	function get_count_by_examination_result_id($withSetAttributeValue=FALSE) {	
		$sql = "SELECT count(exrd_id) count_exrd
				FROM dim_examination_result_doc
				WHERE exrd_exr_id=?";
		$query = $this->dim->query($sql, array($this->exrd_exr_id));
		if ( $withSetAttributeValue ) {
			$this->row2attribute( $query->row() );
		} else {
			return $query ;
		}
	}

	function get_delete_files($withSetAttributeValue=FALSE) {
		$sql = "SELECT * 
				FROM dim_examination_result_doc
				WHERE exrd_exr_id=? AND exrd_status = 0";
		$query = $this->dim->query($sql, array($this->exrd_exr_id));
		if ( $withSetAttributeValue ) {
			$this->row2attribute( $query->row() );
		} else {
			return $query ;
		}
	}

	function update_delete_exclude_files($exclude_id) {
		$sql = "UPDATE dim_examination_result_doc 
				SET	exrd_status = 0
				WHERE exrd_exr_id = ? AND exrd_id not in ({$exclude_id})";
		$query = $this->dim->query($sql, array($this->exrd_exr_id));
	}

	/*
	* get_path_files
	* for get file path
	* @input exrd_id (dim_examination_result_doc id): ไอดีไฟล์ผลตรวจ
	* $output file path
	* @author Areerat Pongurai
	* @Create Date 13/06/2024
	* @Update Date 15/07/2024 Areerat Pongurai - Not use, will delete
	*/
	function get_path_files($withSetAttributeValue=FALSE) {
		$sql = "SELECT CASE WHEN exr.exr_directory IS NOT NULL AND exrd.exrd_file_name IS NOT NULL THEN CONCAT(exr.exr_directory, '/', exrd.exrd_file_name) ELSE null END path_file
				FROM dim_examination_result_doc exrd
				INNER JOIN dim_examination_result exr ON exr.exr_id = exrd.exrd_exr_id
				WHERE exrd.exrd_id=?";
		$query = $this->dim->query($sql, array($this->exrd_id));
		if ( $withSetAttributeValue ) {
			$this->row2attribute( $query->row() );
		} else {
			return $query ;
		}
	}

	function update_status_files() {
		$sql = "UPDATE dim_examination_result_doc 
				SET	exrd_status = ?
				WHERE exrd_id = ? ";
		$query = $this->dim->query($sql, array($this->exrd_status, $this->exrd_id));
	}

	function update_status_files_to_zero($exr_id) {
		$sql = "UPDATE dim_examination_result_doc 
				SET	exrd_status = 0
				WHERE exrd_exr_id = '".$exr_id."'";
		$query = $this->dim->query($sql);
	}
	
} // end class M_dim_examination_result_doc
?>
