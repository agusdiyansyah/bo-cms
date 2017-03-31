<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_berita extends CI_Model{
    private $berita;
    private $kategori;
    private $status = array(
        'draf' => 'Draf',
        'publish' => 'Publish',
    );

    public function __construct() {
        parent::__construct();
        $tb = $this->config->load("database_table", true);
        $this->berita = $tb['tb_berita'];
        $this->kategori = $tb['tb_berita_kategori'];
    }
    
    public function data ($post, $debug = false) {

        $this->db->start_cache();
        
            $this->db->from("$this->berita b");

            // filter
            if (!empty($post['title'])) {
                $this->db->like('title', $post['title'], 'both');
            }

            // order
            $this->db->order_by('id_berita', 'DESC');

            // join
            $this->db->join("$this->kategori k", "k.id_kategori = b.id_kategori", "left");
            
        $this->db->stop_cache();

            // get num rows
            $this->db->select('id_berita');
            $rowCount = $this->db->get()->num_rows();

            // get result
            $this->db->select('id_berita, title, kategori, status, sinopsis');

            $this->db->limit($post['length'], $post['start']);

            $val = $this->db->get()->result();

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
            
            $title = $data->title;
            if ($data->status == "draf") {
                $title .= " <i><span class='label label-warning'>Draft</span></i>";
            }

            $baris = array(
                $no,
                $aksi,
                $title,
                $data->kategori,
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
    
    public function getData ($field = "*", $id = 0) {
        if ($id > 0) {
            $this->db
                ->where("id_berita", $id)
                ->limit(1);
        }
        
        return $this->db
            ->select($field)
            ->get($this->berita);
    }
    
    public function getStatus () {
        return $this->status;
    }
    
    public function status () {
        return $this->status;
    }

}