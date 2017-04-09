<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_pengurus extends CI_Model{
    private $pengurus;
    private $socmed;
    private $jabatan;
    private $ci;

    public function __construct() {
        parent::__construct();
        $tb = $this->config->load("database_table", true);
        $this->pengurus = $tb['tb_pengurus'];
        $this->socmed = $tb['tb_socmed'];
        $this->jabatan = $tb['tb_pengurus_jabatan'];
        
        $this->ci =& get_instance();
    }
    
    public function getStaf () {
        $this->db
            ->join($this->jabatan, "$this->pengurus.id_jabatan = $this->jabatan.id_jabatan", "left")
            ->where("$this->pengurus.id_jabatan !=", 0);
        return $this->getData("id_pengurus, nama, photo, jabatan")->result();
    }
    
    public function add ($dataPengurus, $dataSocmed) {
        return $this->_add_proses($dataPengurus, $dataSocmed);
    }
    
    public function edit ($id, $dataPengurus, $dataSocmed) {
        return $this->_edit_proses($id, $dataPengurus, $dataSocmed);
    }
    
    public function hc_proses ($dataPengurus, $dataSocmed) {
        $sql = $this->getData("id_pengurus", "hc");
        if ($sql->num_rows() > 0) {
            $data = $sql->row();
            $proses = $this->_edit_proses($data->id_pengurus, $dataPengurus, $dataSocmed);
        } else {
            $proses = $this->_add_proses($dataPengurus, $dataSocmed);
        }
        
        return $proses;
    }
    
    private function _add_proses ($dataPengurus, $dataSocmed) {
        $stat = false;
        $this->ci->load->model("socmed/M_socmed");
        if (!$this->db->insert($this->pengurus, $dataPengurus)) {
            $msg = "Gagal proses data pengurus";
        } else {
            $id = $this->db->insert_id();
            
            if (!$this->ci->M_socmed->add($id, $dataSocmed)) {
                $msg = "Gagal proses data socmed";
            } else {
                $msg = "Data berhasil di proses";
                $stat = true;
            }
        }
        
        return array(
            "stat" => $stat,
            "msg" => $msg,
        );
    }
    
    private function _edit_proses ($id, $dataPengurus, $dataSocmed) {
        $stat = false;
        $this->ci->load->model("socmed/M_socmed");
        $data = $this->getData("id_jabatan", $id)->row();
        $msg = "Gagal masuk";
        if (!$this->db
            ->where("id_jabatan", $data->id_jabatan)
            ->where("id_pengurus", $id)
            ->update($this->pengurus, $dataPengurus)) {
            $msg = "Gagal proses data pengurus";
        } else {
            if (!$this->ci->M_socmed->edit($id, $dataSocmed)) {
                $msg = "Gagal proses data socmed";
            } else {
                $msg = "Data berhasil di proses";
                $stat = true;
            }
        }
        
        return array(
            "stat" => $stat,
            "msg" => $msg,
        );
    }
    
    public function delete ($id) {
        $stat = false;
        $msg = "Gagal proses";
        $data = $this->getData("photo", $id)->row();
        $photo = "";
        if (!$this->db
            ->where('id_pengurus', $id)
            ->delete($this->pengurus)) {
            $msg = "Gagal menghapus data pengurus";
        } else {
            $photo = $data->photo;
            $this->ci->load->model("socmed/M_socmed");
            if (!$this->ci->M_socmed->delete($id, "pengurus")) {
                $msg = "Data socmed gagal di hapus";
            } else {
                $stat = true;
            }
        }
        
        return array(
            "stat" => $stat,
            "msg" => $stat,
            "photo" => $photo
        );
    }
    
    public function getDataPengurusById ($id) {
        return $this->db
            ->select('id_pengurus, nama_pengurus')
            ->where('id_pengurus', $id)
            ->limit(1, 0)
            ->get($this->pengurus);
    }

    public function getData ($field = "*", $id = 0) {
        if ($id > 0) {
            $this->db
                ->where("id_pengurus", $id)
                ->limit(1);
        }
        
        if ($id === "hc") {
            $this->db
                ->where("id_jabatan", 0)
                ->limit(1);
        }
        
        return $this->db
            ->select($field)
            ->get($this->pengurus);
    }

}