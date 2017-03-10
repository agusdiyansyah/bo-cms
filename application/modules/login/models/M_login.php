<?php
class M_login extends CI_Model {
	var $table = 'user';
	//cek user dan sandi di database
	function cek($user, $sandi){
		$query = $this->db->get_where($this->table, array('username' => $user, 'password' => $sandi), 1, 0);
		if ($query->num_rows() > 0)
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
	//untuk mendapatkan data admin yg login
	function getAdmin($user, $sandi){
		return $query = $this->db->get_where($this->table, array('username' => $user, 'password' => $sandi), 1, 0)->row();
	}
}