<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_admin extends CI_Model {
	private $tb;
	
	public $level = array(
		"" 	=> "Pilih Level", 
		100 => "root", 
		90 	=> "administrator", 
		80 	=> "operator", 
		10 	=> "pegawai", 
		0 	=> "default"
	);
	public $status = array(
		"" => "Status", 
		0 => "Unpublish", 
		1 => "Publish"
	);
	
	public function __construct() {
		$tb = $this->config->load("database_table", true);
        $this->tb = $tb['tb_user'];
	}
	
	public function data ($post, $debug = false) {

        $this->db->start_cache();

            // filter
			if (!empty($post['nama'])) {
                $this->db->like('nama', $post['nama'], 'both');
            }
			if (!empty($post['level'])) {
                $this->db->where('level', $post['level']);
            }
			if (!empty($post['status'])) {
                $this->db->where('status', $post['status']);
            }

            // order
            $this->db->order_by('id_user', 'DESC');

            // join

        $this->db->stop_cache();

            // get num rows
            $this->db->select('id_user');
            $rowCount = $this->db->get($this->tb)->num_rows();

            // get result
            $this->db->select('*');

            $this->db->limit($post['length'], $post['start']);

            $val = $this->db->get($this->tb)->result();

        $this->db->flush_cache();

        $output['draw']            = $post['draw'];
        $output['recordsTotal']    = $rowCount;
        $output['recordsFiltered'] = $rowCount;
		$output['data']            = array();

		if ($debug) {
		    $output['sql']             = $this->db->last_query();
		}

        $no = 1 + $post['start'];

        $base = base_url();

        foreach ($val as $data) {

            $btnAksi = "";

            $btnAksi .= "
            <li>
                <a href='{$base}administrator/edit/$data->id_user' id='btn-edit'>
                    Ubah
                </a>
            </li>
            ";

            if ($data->id_user != $this->session->userdata("id_user")) {
				$btnAksi .= "
	            <li>
	                <a href='#' id='btn-hapus' data-id='$data->id_user'>
	                    Hapus
	                </a>
	            </li>
	            ";
            }

            $aksi = "
			<div class='btn-group'>
				<button type='button' class='btn btn-default dropdown-toggle' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
					<i class='fa fa-gear'></i>
				</button>
				<ul class='dropdown-menu pull-right'>
					$btnAksi
				</ul>
			</div>
			";

            $baris = array(
                $no,
                $aksi,
				$data->username,
				$data->nama,
				$this->getLevel($data->level),
				$data->email,
                $this->statusLabel((int) $data->status)
            );

            array_push($output['data'], $baris);

            $no++;
        }

        return json_encode($output);

    }
	
	private function statusLabel ($showStat = "") {
		if ($showStat > 0 AND ( is_int($showStat) OR $showStat == "" )) {
			return $this->status[$showStat];
		}
	}
	
	public function insert($data) {
		return $this->db->insert($this->tb, $data);
	}
	
	public function update($id_user, $data) {
		$this->db->where('id_user', $id_user);
		return $this->db->update($this->tb, $data);
	}
	
	public function delete($id_user) {
		$this->db->where('id_user', $id_user);
		return $this->db->delete($this->tb);
	}
	
	public function getById($id_user) {
		$this->db->where('id_user', $id_user);
		return $this->db->get($this->tb);
	}
	
	public function combobox_level($selected="") {
		$options = $this->level;
		return form_dropdown('level', $options, $selected, 'class="form-control"');
	}
	
	public function getLevel($level){
		return $this->level[$level];
	}
	
}

/* End of file M_news.php */
/* Location: .//C/xampp/htdocs/dukcapil_landak/admin/modules/news/models/M_news.php */