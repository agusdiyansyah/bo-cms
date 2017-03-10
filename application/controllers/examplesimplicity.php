<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Examplesimplicity extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		$this->load->helper('url');

		$this->_init();
	}

	private function _init()
	{
		$this->output->set_template('default/default');

		$this->load->js('assets/themes/default/js/jquery-1.9.1.min.js');
		$this->load->js('assets/themes/default/hero_files/bootstrap-transition.js');
		$this->load->js('assets/themes/default/hero_files/bootstrap-collapse.js');
	}

	public function index()
	{
		$this->load->view('ci_simplicity/welcome');
	}

	public function example_1()
	{
		$this->load->view('ci_simplicity/example_1');
	}

	public function example_2()
	{
		$this->output->set_template('default/simple');
		$this->load->view('ci_simplicity/example_2');
	}

	public function example_3()
	{
		$this->load->section('sidebar', 'ci_simplicity/sidebar');
		$this->load->view('ci_simplicity/example_3');
	}

	public function example_4()
	{
		$this->output->unset_template();
		$this->load->view('ci_simplicity/example_4');
	}

}

/* End of file example.php */
/* Location: ./application/controllers/example.php */