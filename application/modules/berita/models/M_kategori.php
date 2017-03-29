<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_kategori extends CI_Model{
    
    private $kategori;
    
    public function __construct() {
        parent::__construct();
        $table = $this->config->load("database_table", true);
        $this->kategori = $table['tb_berita_kategori'];
    }
    
    public function data ($post, $debug = false) {

        $this->db->start_cache();

            // filter
            if (!empty($post['kategori'])) {
                $this->db->like('kategori', $post['kategori'], 'both');
            }

            // order
            $this->db->order_by('id_kategori', 'DESC');

            // join

        $this->db->stop_cache();

            // get num rows
            $this->db->select('id_kategori');
            $rowCount = $this->db->get($this->kategori)->num_rows();

            // get result
            $this->db->select('id_kategori, kategori');

            $this->db->limit($post['length'], $post['start']);

            $val = $this->db->get($this->kategori)->result();

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
                <a href='{$base}berita/kategori/edit/$data->id_kategori' id='btn-edit'>
                    Ubah
                </a>
            </li>
            ";

            $btnAksi .= "
            <li>
                <a href='#' id='btn-hapus' data-id='$data->id_kategori'>
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
                $data->kategori,
            );

            array_push($output['data'], $baris);

            $no++;
        }

        return json_encode($output);

    }
    
    public function getData ($field = "*", $id = 0) {
        if ($id > 0) {
            $this->db
                ->where("id_kategori", $id)
                ->limit(1);
        }
        
        return $this->db
            ->select($field)
            ->get($this->kategori);
    }
    
    public function checkJumlahKategori () {
        
    }

}