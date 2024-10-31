<?php

defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('encrypt_arr_obj_id')) {
    function encrypt_arr_obj_id($objs, $names) {
        $CI =& get_instance();
        $CI->load->library('encryption');

		$result = [];

		if (is_array($objs)) { // from ...()->result()
			if(!empty($objs[0])) {
				// Check if the first element is an object or an associative array
				$isObject = is_object($objs[0]);
		
				foreach ($objs as $obj) {
					foreach ($names as $name) {
						if ($isObject) {
							// Handling for objects
							if (!empty($obj->$name)) {
								$value = $CI->encryption->encrypt($obj->$name);
								$value = str_replace("/", "_", $value);
								$value = str_replace("+", ":", $value);
								$value = str_replace("=", "~", $value);
								$obj->$name = $value;
							} else {
								$obj->$name = null;
							}
						} else {
							// Handling for associative arrays
							if (!empty($obj[$name])) {
								$value = $CI->encryption->encrypt($obj[$name]);
								$value = str_replace("/", "_", $value);
								$value = str_replace("+", ":", $value);
								$value = str_replace("=", "~", $value);
								$obj[$name] = $value;
							} else {
								$obj[$name] = null;
							}
						}
					}
					$result[] = $obj;
				}
			}
		} 
		// else { // from ...()->result_array()
		// 	foreach ($objs as $obj) {
		// 		foreach ($names as $name) {
		// 			if (!empty($obj[$name])) {
		// 				$value = $CI->encryption->encrypt($obj[$name]);
		// 				$value = str_replace("/","_",$value);
		// 				$value = str_replace("+",":",$value);
		// 				$value = str_replace("=","~",$value);
		// 				$obj[$name] = $value;
		// 			} else {
		// 				$obj[$name] = null;
		// 			}
		// 		}
		// 		$result[] = $obj;
		// 	}
		// }
		return $result;
    }
}

if (!function_exists('encrypt_id')) {
    function encrypt_id($id) {
        $CI =& get_instance();
        $CI->load->library('encryption');

		if (!empty($id)) {
			$value = $CI->encryption->encrypt($id);
			$value = str_replace("/","_",$value);
			$value = str_replace("+",":",$value);
			$value = str_replace("=","~",$value);
			return $value;
		} else {
			return null;
		}
    }
}

if (!function_exists('decrypt_id')) {
    function decrypt_id($id) {
        $CI =& get_instance();
        $CI->load->library('encryption');

		if (!empty($id)) {
			$value = $CI->encryption->encrypt($id);
			$value = str_replace("_","/",$id);
			$value = str_replace(":","+",$value);
			$value = str_replace("~","=",$value);
			return $CI->encryption->decrypt($value);
		} else {
			return null;
		}
    }
}
?>