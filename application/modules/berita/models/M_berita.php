<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_berita extends CI_Model{
    private $berita;
    private $kategori;
    private $ci;
    private $status = array(
        'draf' => 'Draf',
        'publish' => 'Publish',
    );

    public function __construct() {
        parent::__construct();
        $this->ci =& get_instance();
        
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
            if (!empty($post['status'])) {
                $this->db->where('status', $post['status']);
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
        $this->ci->load->library("slug");
        $data['slug'] = $this->ci->slug->createSlugDB($data['title'], $this->berita, "slug");
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
    
    public function status () {
        return array("" => "") + $this->status;
    }
    
    public function kategori () {
        $this->ci->load->model("berita/M_kategori");
        $objKategori = $this->ci->M_kategori->getData("id_kategori, kategori")->result();
        $kategori = array("" => "");
        foreach ($objKategori as $val) {
            $kategori += array($val->id_kategori => $val->kategori);
        }
        return $kategori;
    }

}