<?php

include_once(dirname(__FILE__)."/que_model.php");

/**
 * Class M_que_queue_list
 * @author Dechathon
 * @create_date 2024-07-24
 */
class M_que_queue_list extends que_model
{
	/**
	 * check_key
	 * @param $key
	 * @param $keyword
	 * @return bool [ true = ไม่ว่าง , false = ว่าง ]
	 * @author Dechathon
     * @create_date 2024-07-24
	 */
	public function check_has_key($key, $keyword)
	{
		$sql = "SELECT ql_id FROM $this->que_db.que_queue_list WHERE ql_code = ? AND ql_dpq_keyword = ?";
		$result = $this->que->query($sql, array($key, $keyword));
		return $result->num_rows() > 0;
	}

	/**
	 * insert_key
	 * @param $key
	 * @param $keyword
	 * @author Dechathon
	 * @create_date 2024-07-24
	 */
	public function insert_key($key, $keyword)
	{

		$data['ql_code'] = $key;
		$data['ql_dpq_keyword'] = $keyword;

		$this->que->insert($this->que_db . '.que_queue_list', $data);
	}

	/**
	 * get_by_track_code
	 * @param $track_code
	 * @param $key
	 * @return data
	 * @author Dechathon
	 * @create_date 2024-07-24
	 */
	public function get_by_track_code($key)
	{
		$sql = "SELECT * 
		FROM $this->que_db.que_queue_list 
		LEFT JOIN $this->que_db.que_base_department_queue ON ql_dpq_keyword = dpq_keyword
		WHERE ql_code = ? ";
		$result = $this->que->query($sql, array($key));
		return $result;
	}

	public function Check_last_que($keyword){
		
		$placeholders = implode(',', array_fill(0, count($keyword), '?'));
		$sql="WITH LatestEntries AS (
				SELECT ql_dpq_keyword, MAX(ql_date) AS max_date
				FROM que_queue_list
				GROUP BY ql_dpq_keyword)
		SELECT q.ql_dpq_keyword, q.ql_date
		FROM que_queue_list q
		JOIN LatestEntries l
		ON q.ql_dpq_keyword = l.ql_dpq_keyword AND q.ql_date = l.max_date
		WHERE BINARY q.ql_dpq_keyword IN ($placeholders)";
		
		$keyword_values = array_map(function($item) {
			return $item['cq_keyword'];
		}, $keyword);
		
		$query = $this->que->query($sql , $keyword_values);
		return $query->result_array();
	}
}