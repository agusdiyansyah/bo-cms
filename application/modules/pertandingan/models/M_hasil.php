<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_hasil extends CI_Model{
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
            $this->db->where('match_status', 'hasil');

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
            $this->db->select('id_match, match_rival, match_date, alamat, match_resultscore1, match_resultscore2');

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
                <a href='#' id='btn-skor' data-id='$data->id_match'>
                    Skor
                </a>
            </li>
            ";
            
            $btnAksi .= "
            <li>
                <a href='{$base}pertandingan/jadwal/edit/$data->id_match/hasil' id='btn-edit'>
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
                $data->match_resultscore1,
                $data->match_resultscore2,
            );

            array_push($output['data'], $baris);

            $no++;
        }

        return json_encode($output);

    }
}