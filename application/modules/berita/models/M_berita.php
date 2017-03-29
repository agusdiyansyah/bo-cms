<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_berita extends CI_Model{
    private $berita;
    private $status = array(
        'publish' => 'Publish',
        'draf' => 'Draf',
    );

    public function __construct() {
        parent::__construct();
        $tb = $this->config->load("database_table", true);
        $this->berita = $tb['tb_berita'];
    }
    
    public function data ($post, $debug = false) {

        $this->db->start_cache();

            // filter
            if (!empty($post['title'])) {
                $this->db->like('title', $post['title'], 'both');
            }

            // order
            $this->db->order_by('id_berita', 'DESC');

            // join

        $this->db->stop_cache();

            // get num rows
            $this->db->select('id_berita');
            $rowCount = $this->db->get($this->berita)->num_rows();

            // get result
            $this->db->select('id_berita, title, sinopsis');

            $this->db->limit($post['length'], $post['start']);

            $val = $this->db->get($this->berita)->result();

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
                <a href='{$base}berita/edit/$data->id_berita' id='btn-edit'>
                    Ubah
                </a>
            </li>
            ";

            $btnAksi .= "
            <li>
                <a href='#' id='btn-hapus' data-id='$data->id_berita'>
                    Hapus
                </a>
            </li>
            ";

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
                $data->title,
                $data->sinopsis,
            );

            array_push($output['data'], $baris);

            $no++;
        }

        return json_encode($output);

    }
    
    public function add ($data) {
        return $this->db->insert($this->berita, $data);
    }
    
    public function edit ($data, $id) {
        return $this->db
            ->where('id_berita', $id)
            ->update($this->berita, $data);
    }
    
    public function delete ($id) {
        return $this->db
            ->where('id_berita', $id)
            ->delete($this->berita);
    }
    
    public function getDataById ($id, $field = "*") {
        return $this->db
            ->select($field)
            ->where('id_berita', $id)
            ->get($this->berita, 1);
    }
    
    public function getStatus () {
        return $this->status;
    }
    
    public function status () {
        $status = array('' => ' ');
        $status += $this->status;
        return $status;
    }

}