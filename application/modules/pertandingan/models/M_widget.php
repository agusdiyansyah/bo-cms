<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_widget extends CI_Model {
	var $tb = 'match';

	public function latestResult()
	{
		$this->db->where('match_status', 'hasil');
		$this->db->order_by('match_date', 'desc');
		return $this->db->get($this->tb,1);
	}

}

/* End of file M_widget.php */
/* Location: ./application/modules/pertandingan/models/M_widget.php */