<?php
/*
 * M_hr_person
 * Model for Manage about hr_person Table.
 * @Author Tanadon Tangjaimongkhon
 * @Create Date 17/05/2024
 */
include_once("Da_hr_matching_code.php");

class M_hr_matching_code extends Da_hr_matching_code
{
	function get_person_matching_code()
	{
		$sql = "SELECT mc_code FROM " . $this->hr_db . ".hr_timework_matching_code WHERE mc_ps_id = ? AND mc_dp_id = ?";
		$query = $this->hr->query($sql, array($this->mc_ps_id, $this->mc_dp_id));
		return $query;
	}
	function get_matching_code()
	{
		$sql = "SELECT mc_code FROM " . $this->hr_db . ".hr_timework_matching_code WHERE mc_code = ?";
		$query = $this->hr->query($sql, array($this->mc_code));
		return $query;
	}
	// function get_order_person_data_by_type($type)
	// {
	// 	$sql = "SELECT * FROM " . $this->hr_db . ".hr_order_data WHERE ord_ordt_id = '$type'";
	// 	$query = $this->hr->query($sql);
	// 	return $query;
	// }
} // end class M_hr_person
