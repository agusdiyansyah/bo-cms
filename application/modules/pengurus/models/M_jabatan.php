<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_jabatan extends CI_Model {
    
    private $jabatan;

    public function __construct() {
        parent::__construct();
        
        $table = $this->config->load("database_table");
        $this->jabatan = $table['tb_pengurus_jabatan'];
    }
    
    public function data ($post, $debug = false) {

        $this->db->start_cache();
        
            $this->db->from("$this->jabatan t");

            // filter
            if (!empty($post['jabatan'])) {
                $this->db->like('jabatan', $post['jabatan'], 'both');
            }

            // order
            $this->db->order_by('id_jabatan', 'DESC');

            // join
            
        $this->db->stop_cache();

            // get num rows
            $this->db->select('id_jabatan');
            $rowCount = $this->db->get()->num_rows();

            // get result
            $this->db->select('id_jabatan, jabatan');

            $this->db->limit($post['length'], $post['start']);

            $val = $this->db->get()->result();

        $this->db->flush_cache();

        $output['draw']            = $post['draw'];
        $output['recordsTotal']    = $rowCount;
        $output['recordsFiltered'] = $rowCount;
		$output['data']            = array();

		if ($debug) {
		    $output['sql']         = $this->db->last_query();
		}

        $no = 1 + $post['start'];

        $base = base_url();

        foreach ($val as $data) {

            $btnAksi = "";

            $btnAksi .= "
            <li>
                <a href='{$base}/pengurus/jabatan/edit/$data->id_jabatan' id='btn-edit'>
                    Ubah
                </a>
            </li>
            ";

            $btnAksi .= "
            <li>
                <a href='#' id='btn-hapus' data-id='$data->id_jabatan'>
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
                $data->jabatan
            );

            array_push($output['data'], $baris);

            $no++;
        }

        return json_encode($output);

    }
    
    public function add ($data) {
        return $this->db->insert($this->jabatan, $data);
    }
    
    public function edit ($data, $id) {
        return $this->db
            ->where("id_jabatan", $id)
            ->update($this->jabatan, $data);
    }
    
    public function delete ($id) {
        return $this->db
            ->where("id_jabatan", $id)
            ->delete($this->jabatan);
    }
    
    public function getData ($field = "*", $id = 0) {
        if ($id > 0) {
            $this->db
                ->where("id_jabatan", $id)
                ->limit(1);
        }
        
        return $this->db
            ->select($field)
            ->get($this->jabatan);
    }
    
    public function getJabatanArray ($isHC = 0) {
        if ($isHC) {
            $listJabatan = array("0" => "HEAD COACH");
        } else {
            $listJabatan = array("" => "");
            foreach ($this->getData()->result() as $data) {
                $listJabatan += array(
                    $data->id_jabatan => $data->jabatan,
                );
            }
        }
        
        return $listJabatan;
    }

}