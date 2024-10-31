<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once(dirname(__FILE__) . "/../ums/UMS_Controller.php"); //Include file มาเพื่อ extend
class HR_Controller extends UMS_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model($this->config->item('hr_dir').'M_hr_logs');
	}

	public function index()
	{
		// Set a session variable to indicate that the sidebar menus have been initialized
		$this->session->set_userdata('is_have_menus_sidebar', true);
		
		// Initialize the sidebar menu for the user, typically done once when the user logs in
		$this->set_menu_sidebar();
	
		// Retrieve the user groups data from the session
		$session_us_groups = $this->session->userdata('us_groups');
	
		// Initialize arrays to store unique hire types and the final result set
		$hireArray = array();
		$uniqueHire = array();
	
		// Check if the user has no groups assigned
		if (count($session_us_groups) == 0) {
			// If no groups, redirect to the error page
			redirect($this->config->item('hr_dir').'home/Personal_home/error_page', 'refresh');
		} else {
			// Loop through each group in the session
			foreach ($session_us_groups as $group) {
				// Extract the 'gp_is_medical' value and split it into an array (using commas as the delimiter)
				$gp_is_medical = explode(',', $group['gp_is_medical']);
	
				// Loop through each medical type in the current group
				foreach ($gp_is_medical as $medicalType) {
					// Only add the medical type to the arrays if it hasn't been added already (ensure uniqueness)
					if (!in_array($medicalType, $uniqueHire)) {
						// Add to the hire array (used for setting session data later)
						$hireArray[] = array('type' => $medicalType);
						// Add to the unique hire array to prevent duplicates
						$uniqueHire[] = $medicalType;
					}
				}
			}
	
			// Check if there are any unique hire types found
			if (count($uniqueHire) > 0) {
				// If there are, set the 'hr_hire_is_medical' session data with the hire array
				$this->session->set_userdata('hr_hire_is_medical', $hireArray);

				// Extract the 'type' values from the array
				$type_values = array_column($hireArray, 'type');
			
				// Convert the array to a comma-separated string with proper quoting
				$type_values_string = "'" . implode("','", $type_values) . "'";

				$this->session->set_userdata('hr_hire_is_medical_string', $type_values_string);

				// Redirect to the profile summary page
				redirect($this->config->item('hr_dir').'profile/Profile_summary/get_profile_summary', 'refresh');
			} else {
				// If no unique hire types are found, redirect to the same profile summary page
				redirect($this->config->item('hr_dir').'profile/Profile_summary/get_profile_summary', 'refresh');
			}
		}
	}	

}
