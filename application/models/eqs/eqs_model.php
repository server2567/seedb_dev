<?php

class eqs_model extends CI_Model {

	function __construct() {
		parent::__construct();
		$this->eqs = $this->load->database('eqs', TRUE);
		
		//$this->eqsold = $this->load->database('eqsold', TRUE);
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