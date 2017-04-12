<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_match extends CI_Model{
    private $match;

    public function __construct() {
        parent::__construct();
        
        $tb = $this->config->load("database_table", true);
        $this->match = $tb['tb_match'];
    }
    
    public function data ($post, $debug = false) {
        $this->load->helper("z");
        
        $this->db->start_cache();
        
            $this->db->from("$this->match m");

            // filter
            if (!empty($post['match_rival'])) {
                $this->db->like('match_rival', $post['match_rival'], 'both');
            }

            // order
            $this->db->order_by('id_match', 'DESC');

            // join
            
        $this->db->stop_cache();

            // get num rows
            $this->db->select('id_match');
            $rowCount = $this->db->get()->num_rows();

            // get result
            $this->db->select('id_match, match_rival, match_date, alamat');

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
                <a href='#' id='btn-selesai' data-id='$data->id_match'>
                    Selesai
                </a>
            </li>
            ";

            $btnAksi .= "
            <li>
                <a href='{$base}/pertandingan/jadwal/edit/$data->id_match' id='btn-edit'>
                    Ubah
                </a>
            </li>
            ";

            $btnAksi .= "
            <li>
                <a href='#' id='btn-hapus' data-id='$data->id_match'>
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
                $data->match_rival,
                indoDateFormat($data->match_date, "j F Y H:i"),
                $data->alamat,
            );

            array_push($output['data'], $baris);

            $no++;
        }

        return json_encode($output);

    }
    
    public function add ($data) {
        return $this->db->insert($this->match, $data);
    }
    
    public function edit ($data, $id) {
        return $this->db
            ->where('id_match', $id)
            ->update($this->match, $data);
    }
    
    public function delete ($id) {
        return $this->db
            ->where('id_match', $id)
            ->delete($this->match);
    }
    
    public function getData ($field = "*", $id = 0) {
        if ($id > 0) {
            $this->db
                ->where("id_match", $id)
                ->limit(1);
        }
        
        return $this->db
            ->select($field)
            ->get($this->match);
    }
}