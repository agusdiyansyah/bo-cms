<?php
class M_login extends CI_Model {
	protected $table = '';
	private $loginvalid=FALSE;
	
	public function __construct() {
		$tb = $this->config->load("database_table", true);
        $this->table = $tb['tb_user'];
	}
	
	//cek user dan sandi di database
	public function cek($user, $sandi){
		$query = $this->db->get_where($this->table, array('username' => $user), 1, 0);
		if ($query->num_rows() > 0) {
			$hasil=$query->row();
			if (password_verify($sandi, $hasil->password)) {
			    $this->loginvalid=TRUE;
			    return TRUE;
			} else {
			    return FALSE;
			    //password salah
			}
		} else {
			return FALSE;
			//user tidak ditemukan
		}
	}
	//untuk mendapatkan data admin yg login
	public function getAdmin($user, $sandi){
		if($this->loginvalid){
			return $query = $this->db->get_where($this->table, array('username' => $user), 1, 0)->row();
		}
	}
}