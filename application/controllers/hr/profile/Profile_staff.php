<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require_once(dirname(__FILE__) . "/../../ums/UMS_Controller.php");
class Profile_staff extends UMS_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('staff/M_staff_profile');
	}

	function index()
	{

		$data['ddd'] = array();
		$this->output('hr/profile/staff/v_staff_directory_profile', $data);
	}

	public function doctors()
	{
		$data['ddd'] = array();
		$is_medical = 'M';
		$ft_name = null;
		$ft_stde = null;
		if (isset($_GET['ft_name']) || isset($_GET['ft_stde'])) {
			if ($_GET['ft_name']) {
				$ft_name = $_GET['ft_name'];
			}
			if ($_GET['ft_stde'] != 'all') {
				$ft_stde = $_GET['ft_stde'];
			}
			$data['medical_person'] = $this->M_staff_profile->get_medical_profile($is_medical, null, $ft_name, $ft_stde)->result();
			$data['ft_select'] = $ft_stde;
			$data['ft_name'] = $ft_name;
		}
		$data['controller_dir'] = 'staff/Directory_profile';
		// $data['filter'] = $this->m_staff_profile->filter_profile()->result();
		foreach ($data['medical_person'] as $key => $value) {
			$value->ps_id = encrypt_id($value->ps_id);
		}
		$data['filter_profile'] = $this->M_staff_profile->filter_profile_option($is_medical)->result();
		// pre($data['medical_person'] );
		$this->output_staff('staff/v_doctors', $data);
	}

	public function nurses()
	{
		$data['ddd'] = array();
		$data['controller_dir'] = 'staff/Directory_profile';
		$is_medical = 'N';
		$ft_name = null;
		$ft_stde = null;
		if (isset($_GET['ft_name']) || isset($_GET['ft_stde'])) {
			if ($_GET['ft_name']) {
				$ft_name = $_GET['ft_name'];
			}
			if ($_GET['ft_stde'] != 'all') {
				$ft_stde = $_GET['ft_stde'];
			}
			$data['nurses_person'] = $this->M_staff_profile->get_medical_profile($is_medical, null, $ft_name, $ft_stde)->result();
			$data['ft_select'] = $ft_stde;
			$data['ft_name'] = $ft_name;
		}
		$data['filter_profile'] = $this->M_staff_profile->filter_profile_option($is_medical)->result();
		$this->load->view('hr/profile/staff/v_nurses', $data);
	}

	public function staff()
	{
		$data['ddd'] = array();
		$data['controller'] = 'staff/Directory_profile';
		$is_medical = ['SM', 'T', 'A'];
		$ft_name = null;
		$ft_stde = null;
		if (isset($_GET['ft_name']) || isset($_GET['ft_stde'])) {
			if ($_GET['ft_name']) {
				$ft_name = $_GET['ft_name'];
			}
			if ($_GET['ft_stde'] != 'all') {
				$ft_stde = $_GET['ft_stde'];
			}
			$data['staff_person'] = $this->M_staff_profile->get_medical_profile($is_medical, null, $ft_name, $ft_stde)->result();
			$data['ft_select'] = $ft_stde;
			$data['ft_name'] = $ft_name;
		}
		$data['filter_profile'] = $this->M_staff_profile->filter_profile_option('SM')->result();
		$this->load->view('hr/profile/staff/v_staff', $data);
	}

	public function executives()
	{
		$data['ddd'] = array();
		$data['controller_dir'] = 'staff/Directory_profile';
		$is_medical = 'lvl';
		$ft_name = null;
		$ft_stde = null;
		if (isset($_GET['ft_name']) || isset($_GET['ft_stde'])) {
			if ($_GET['ft_name']) {
				$ft_name = $_GET['ft_name'];
			}
			if ($_GET['ft_stde'] != 'all') {
				$ft_stde = $_GET['ft_stde'];
			}
			$data['director_person'] = $this->M_staff_profile->get_medical_profile($is_medical, null, $ft_name, $ft_stde)->result();
			$data['ft_select'] = $ft_stde;
			$data['ft_name'] = $ft_name;
		}
		$data['filter_profile'] = $this->M_staff_profile->filter_profile_option('E')->result();
		foreach ($data['director_person'] as $key => $value) {
			$value->ps_id = encrypt_id($value->ps_id);
		}
		$this->output_staff('staff/v_executives', $data);
	}
}
