<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_trophy extends CI_Model{
    private $trophy;
    private $ci;

    public function __construct() {
        parent::__construct();
        
        $this->ci =& get_instance();
        // $this->galeri = $CI->load->model('media/M_galeri');
        
        $tb = $this->config->load("database_table", true);
        $this->trophy = $tb['tb_trophy'];
    }
    
    public function data ($post, $debug = false) {

        $this->db->start_cache();
        
            $this->db->from("$this->trophy t");

            // filter
            if (!empty($post['nama_trophy'])) {
                $this->db->like('nama_trophy', $post['nama_trophy'], 'both');
            }
            if (!empty($post['tahun'])) {
                $this->db->where('tahun', $post['tahun']);
            }

            // order
            $this->db->order_by('tahun', 'DESC');

            // join
            
        $this->db->stop_cache();

            // get num rows
            $this->db->select('id_trophy');
            $rowCount = $this->db->get()->num_rows();

            // get result
            $this->db->select('id_trophy, nama_trophy, tahun');

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
                <a href='{$base}/profile_club/trophy/edit/$data->id_trophy' id='btn-edit'>
                    Ubah
                </a>
            </li>
            ";

            $btnAksi .= "
            <li>
                <a href='#' id='btn-hapus' data-id='$data->id_trophy'>
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
                $data->nama_trophy,
                $data->tahun,
            );

            array_push($output['data'], $baris);

            $no++;
        }

        return json_encode($output);

    }
    
    public function add ($data) {
        $this->ci->load->library("slug");
        $data['slug'] = $this->ci->slug->createSlugDB($data['nama_trophy'], $this->trophy, "slug");
        return $this->db->insert($this->trophy, $data);
    }
    
    public function edit ($data, $id) {
        return $this->db
            ->where('id_trophy', $id)
            ->update($this->trophy, $data);
    }
    
    public function delete ($id) {
        return $this->db
            ->where('id_trophy', $id)
            ->delete($this->trophy);
    }
    
    public function getData ($field = "*", $id = 0) {
        if ($id > 0) {
            $this->db
                ->where("id_trophy", $id)
                ->limit(1);
        }
        
        return $this->db
            ->select($field)
            ->get($this->trophy);
    }
    
    public function galeriArray () {
        $galeri = array("" => "");
        foreach ($this->getGaleri()->result() as $data) {
            $galeri += array($data->id_galeri => $data->title);
        }
        
        return $galeri;
    }
    
    public function getGaleri () {
        $this->ci->load->model("media/M_galeri");
        return $this->M_galeri->data("", "publish");
    }
}