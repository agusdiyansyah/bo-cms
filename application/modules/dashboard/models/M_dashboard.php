<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_dashboard extends CI_Model {

	public function jumlah($table="pegawai")
	{
		$query = $this->db->get($table);
		$num = $query->num_rows();
		return $num;
	}
	public function jum_jk($JK)
	{
		$this->db->where('KJKEL', $JK);
		$q = $this->db->get('pegawai');
		$num = $q->num_rows();
		return $num;
	}
}

/* End of file M_dashboard.php */
/* Location: ./application/modules/dashboard/models/M_dashboard.php */