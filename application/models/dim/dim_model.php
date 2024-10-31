<?php

class dim_model extends CI_Model {

	function __construct() {
		parent::__construct();
		$this->dim = $this->load->database('dim', TRUE);
		
		//$this->dimold = $this->load->database('dimold', TRUE);
	}
	
	function row2attribute($rw) {
		foreach ($rw as $key => $value) {
			if ( is_null($value) ) 
				eval("\$this->$key = NULL;");
			else
				eval("\$this->$key = '$value';");
		}
	}

}

?>