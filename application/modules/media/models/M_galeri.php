<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_galeri extends CI_Model {
    
    private $tb_galeri;
    private $file;

    public function __construct() {
        parent::__construct();
        $table = $this->config->load('database_table', true);
        $this->tb_galeri = $table['tb_galeri'];
        $this->file = $table['tb_file'];
    }
    
    public function data ($id, $status = "") {
        if ($id != "") {
            $this->db->where('id_galeri', $id);
        }
        if ($status == "publish") {
            $this->db->where('status', 1);
        } elseif ($status == "unpublish") {
            $this->db->where('status', 0);
        }
        return $this->db
            ->select('id_galeri, title, status')
            ->get($this->tb_galeri);
    }
    
    public function add ($data) {
        return $this->db->insert($this->tb_galeri, $data);
    }
    
    public function update ($data, $id) {
        return $this->db
            ->where('id_galeri', $id)
            ->update($this->tb_galeri, $data);
    }
    
    public function hapus ($id) {
        $sql = $this->db
            ->select('id_file')
            ->where('id_galeri', $id)
            ->get($this->file, 1);
        
        if ($sql->row() > 0) {
            $this->db
                ->where('id_galeri', $id)
                ->update($this->file, array(
                    'id_galeri' => 0
                ));
        }
            
        return $this->db
            ->where("id_galeri", $id)
            ->delete($this->tb_galeri);
    }
    
    public function getDataById ($id) {
        return $this->db
            ->where('id_galeri', $id)
            ->select('title, status, keterangan')
            ->get($this->tb_galeri);
    }

}