<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_pemain extends CI_Model{
    private $pemain;
    private $socmed;
    private $jabatan;
    private $ci;
    private $posisi = array(
        "keeper" => "Goal Keeper",
		"pivot" => "Pivot",
		"flank" => "Flank",
		"anchor" => "Anchor",
		"universal" => "Universal",
		"power_play" => "Power Play",
    );

    public function __construct() {
        parent::__construct();
        $tb = $this->config->load("database_table", true);
        $this->pemain = $tb['tb_pemain'];
        $this->socmed = $tb['tb_socmed'];
        
        $this->ci =& get_instance();
    }
    
    public function getPemain () {
        return $this->getData("id_pemain, nama, photo, posisi")->result();
    }
    
    public function add ($dataPemain, $dataSocmed) {
        $stat = false;
        $this->ci->load->model("socmed/M_socmed");
        $this->ci->load->library("slug");
        $dataPemain['slug'] = $this->ci->slug->createSlugDB($dataPemain['nama'], $this->pemain, "slug");
        if (!$this->db->insert($this->pemain, $dataPemain)) {
            $msg = "Gagal proses data pengurus";
        } else {
            $id = $this->db->insert_id();
            
            if (!$this->ci->M_socmed
                ->tipe("pemain")
                ->add($id, $dataSocmed)) {
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
    
    public function edit ($id, $dataPemain, $dataSocmed) {
        $stat = false;
        $this->ci->load->model("socmed/M_socmed");
        $msg = "Gagal masuk";
        if (!$this->db
            ->where("id_pemain", $id)
            ->update($this->pemain, $dataPemain)) {
            $msg = "Gagal proses data pengurus";
        } else {
            if (!$this->ci->M_socmed
                ->tipe("pemain")
                ->edit($id, $dataSocmed)) {
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
            ->where('id_pemain', $id)
            ->delete($this->pemain)) {
            $msg = "Gagal menghapus data pengurus";
        } else {
            $photo = $data->photo;
            $this->ci->load->model("socmed/M_socmed");
            if (!$this->ci->M_socmed
                ->tipe("pemain")
                ->delete($id)) {
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
    
    public function getPosisiArray () {
        $posisi = array("" => "") + $this->posisi;
        return $posisi;
    }

    public function getData ($field = "*", $id = 0) {
        if ($id > 0) {
            $this->db
                ->where("id_pemain", $id)
                ->limit(1);
        }
        
        return $this->db
            ->select($field)
            ->get($this->pemain);
    }

    public function getDataSocmedArray ($id) {
        $this->ci->load->model("socmed/M_socmed");
        $this->db
            ->where('p.id_pemain', $id)
            ->where('s.tipe', 'pemain')
            ->join("$this->pemain p", "p.id_pemain = s.id_relasi", "left");
        return $this->ci->M_socmed->getDataSocmedArray();
    }

}