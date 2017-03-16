<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_image extends CI_Model{
    
    private $file;

    public function __construct() {
        parent::__construct();
        $table = $this->config->load('database_table', true);
        $this->file = $table['tb_file'];
    }
    
    public function data ($id = 0) {
        return $this->db
            ->select('id_file, title, file')
            ->where('id_galeri', (int) $id)
            ->get($this->file);
    }
    
    public function add ($data) {
        return $this->db->insert($this->file, $data);
    }
    
    public function update ($data, $id) {
        return $this->db
            ->where('id_file', $id)
            ->update($this->file, $data);
    }
    
    public function hapus ($id) {
        $upload_path = "./assets/upload/images/";
        
        $data = $this->getDataById($id)->row();
        if ($data->file != '') {
            if (file_exists($upload_path . $data->file)) {
                unlink($upload_path . $data->file);
                if ($upload_path . 'thumb/' . $data->file) {
                    unlink($upload_path . 'thumb/' . $data->file);
                }
            }
        }
        
        $del = $this->db
            ->where("id_file", $id)
            ->delete($this->file);
            
        return $del;
    }
    
    public function getDataById ($id) {
        return $this->db
            ->where('id_file', $id)
            ->select('id_file, id_galeri, title, file, keterangan')
            ->get($this->file);
    }

}