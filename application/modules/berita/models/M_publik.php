<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_publik extends CI_Model {

	public function latestNews($limit=5)
	{
		$this->db->select('b.*, k.kategori');
		$this->db->join('berita_kategori k', 'b.id_kategori = k.id_kategori', 'left');
		$this->db->where('b.status', 'publish');
		$this->db->where('b.isdelete', 0);
		return $this->db->get('berita b', $limit);
	}

}

/* End of file M_publik.php */
/* Location: ./application/modules/berita/models/M_publik.php */