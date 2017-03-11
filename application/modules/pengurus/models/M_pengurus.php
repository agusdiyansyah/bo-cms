<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_pengurus extends CI_Model{
    protected $tb_pengurus = "";

    public function __construct() {
        parent::__construct();
        $tb = $this->config->load("database_table", true);
        $this->tb_pengurus = $tb['tb_pengurus'];
    }
    
    public function data ($post, $debug = false) {

        $this->db->start_cache();

            // filter
            if (!empty($post['nama_pengurus'])) {
                $this->db->like('nama_pengurus', $post['nama_pengurus'], 'both');
            }

            // order
            $this->db->order_by('id_pengurus', 'DESC');

            // join

        $this->db->stop_cache();

            // get num rows
            $this->db->select('id_pengurus');
            $rowCount = $this->db->get($this->tb_pengurus)->num_rows();

            // get result
            $this->db->select('id_pengurus, nama_pengurus');

            $this->db->limit($post['length'], $post['start']);

            $val = $this->db->get($this->tb_pengurus)->result();

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
                <a href='{$base}pengurus/edit/$data->id_pengurus' id='btn-edit'>
                    Ubah
                </a>
            </li>
            ";

            $btnAksi .= "
            <li>
                <a href='#' id='btn-hapus' data-id='$data->id_pengurus'>
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
                $data->nama_pengurus
            );

            array_push($output['data'], $baris);

            $no++;
        }

        return json_encode($output);

    }
    
    public function add ($data) {
        return $this->db->insert($this->tb_pengurus, $data);
    }
    
    public function edit ($data, $id) {
        return $this->db
            ->where('id_pengurus', $id)
            ->update($this->tb_pengurus, $data);
    }
    
    public function delete ($id) {
        return $this->db
            ->where('id_pengurus', $id)
            ->delete($this->tb_pengurus);
    }
    
    public function getDataPengurusById ($id) {
        return $this->db
            ->select('id_pengurus, nama_pengurus')
            ->where('id_pengurus', $id)
            ->limit(1, 0)
            ->get($this->tb_pengurus);
    }

}