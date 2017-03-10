<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu extends Controller {

	public function index()
	{
		$data = null;
		$this->load->view('menu', $data);
	}

}

/* End of file menu.php */
/* Location: ./application/modules/menu/controllers/menu.php */