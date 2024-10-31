<?php

include_once(dirname(__FILE__)."/que_model.php");

/**
 * Class M_tk_key_code_list
 * @author Patiya
 * @create_date 2024-06-12
 */
class M_que_code_list extends que_model
{
	/**
	 * check_key
	 * @param $key
	 * @param $keyword
	 * @return bool [ true = ไม่ว่าง , false = ว่าง ]
	 * @author patiya
	 * @create_date 2024-06-12
	 */
	public function check_has_key($key, $keyword)
	{
		$sql = "SELECT cl_id FROM $this->que_db.que_code_list WHERE cl_code = ? AND cl_dpk_keyword = ?";
		$result = $this->que->query($sql, array($key, $keyword));
		return $result->num_rows() > 0;
	}

	/**
	 * insert_key
	 * @param $key
	 * @param $keyword
	 * @author patiya
	 * @create_date 2024-06-12
	 */
	public function insert_key($key, $keyword)
	{

		$data['cl_code'] = $key;
		$data['cl_dpk_keyword'] = $keyword;

		$this->que->insert($this->que_db . '.que_code_list', $data);
	}

	/**
	 * get_by_track_code
	 * @param $track_code
	 * @param $key
	 * @return data
	 * @author patiya
	 * @create_date 2024-06-12
	 */
	public function get_by_track_code($key)
	{
		$sql = "SELECT * 
		FROM $this->que_db.que_code_list 
		LEFT JOIN $this->que_db.que_base_department_keyword ON cl_dpk_keyword = dpk_keyword
		WHERE cl_code = ? ";
		$result = $this->que->query($sql, array($key));
		return $result;
	}
	public function Check_last_que($keyword) {
		// Ensure $keyword is an array, even if it's a single value
		if (!is_array($keyword)) {
			$keyword = [$keyword];
		}
		
		$placeholders = implode(',', array_fill(0, count($keyword), '?'));
		
		$sql = "
			WITH LatestEntries AS (
				SELECT cl_dpk_keyword, MAX(cl_date) AS max_date
				FROM que_code_list
				GROUP BY cl_dpk_keyword
			)
			SELECT q.cl_dpk_keyword, q.cl_date , q.cl_code
			FROM que_code_list q
			JOIN LatestEntries l
			ON q.cl_dpk_keyword = l.cl_dpk_keyword AND q.cl_date = l.max_date
			WHERE BINARY q.cl_dpk_keyword IN ($placeholders);
		";
		
		// No need to map $keyword if it's already an array of strings
		$query = $this->que->query($sql, $keyword);
		
		return $query->result_array();
	}
	
}