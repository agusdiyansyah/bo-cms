<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_slideshow extends CI_Model {
    
    private $page;

    public function __construct() {
        parent::__construct();
        $tabel = $this->config->load("database_table");
        $this->page = $tabel['tb_page'];
    }
    
    public function data($post, $debug = false) {
		$this->db->start_cache();
            
            $this->db->where("tipe", "slideshow");
            
            // filter
            if (!empty($post['title'])) {
                $this->db->like('title', $post['title'], 'both');
            }

            // order
            $this->db->order_by('id_page', 'DESC');

            // join

        $this->db->stop_cache();

            // get num rows
            $this->db->select('id_page');
            $rowCount = $this->db->get($this->page)->num_rows();

            // get result
            $this->db->select('id_page, title');
			$this->db->from($this->page);
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

        $base = base_url('slideshow');
		
		foreach ($val as $data) {

            $btnAksi = "";

            $btnAksi .= "
            <li>
                <a href='{$base}/edit/$data->id_page' id='btn-edit'>
                    Ubah
                </a>
            </li>
            ";

            $btnAksi .= "
            <li>
                <a href='#' id='btn-hapus' data-id='$data->id_page'>
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
				$data->title
            );

            array_push($output['data'], $baris);

            $no++;
        }

        return json_encode($output);
    }
    
    public function getDataById ($id) {
        return $this->db
            ->select("title, cover, content")
            ->where("tipe", "slideshow")
            ->where("id_page", $id)
            ->get($this->page, 1);
    }
    
    public function delete ($id) {
        return $this->db
            ->where("id_page", $id)
            ->delete($this->page);
    }

    public function getPub()
    {
        $this->db->where('tipe', 'slideshow');
        $this->db->where('isdelete', 0);
        return $this->db->get('page');
    }
}