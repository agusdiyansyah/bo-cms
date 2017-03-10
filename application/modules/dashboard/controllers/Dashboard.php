<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends Controller {
	function __construct() {
		parent::__construct();
		$this->load->helper('url');
	}

	public function index() {
		$data['title'] = "Dashboard";
		$this->load->view('beranda', $data);
	}

}

/* End of file dashboard.php */
/* Location: ./application/modules/dashboard/controllers/dashboard.php */