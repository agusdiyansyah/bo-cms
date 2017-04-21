<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Publik extends MX_Controller {

	public function index()
	{
		
	}

	public function widget()
	{
		$this->load->model('M_slideshow');
		$query = $this->M_slideshow->getPub();
		if ($query->num_rows()>0) {
			$data['result'] = $query->result();
			$this->load->view('publik/widget', $data);
		}
	}


}

/* End of file Publik.php */
/* Location: ./application/modules/slideshow/controllers/Publik.php */