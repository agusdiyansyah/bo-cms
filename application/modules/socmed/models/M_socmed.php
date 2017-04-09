<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_socmed extends CI_Model {
    
    private $socmed;
    private $pengurus;
    public $id_socmed = array(
        "facebook" => 2,
        "twitter" => 1,
        "instagram" => 3,
        "google_plus" => 4,
        "bloglovin" => 5,
        "pinterest" => 6,
        "youtube" => 7,
        "tumblr" => 8,
    );
    private $tipe;

    public function __construct() {
        parent::__construct();
        $tb = $this->config->load("database_table", true);
        $this->socmed = $tb['tb_socmed'];
        $this->pengurus = $tb['tb_pengurus'];
    }

    public function add ($id_relasi, $socmed) {
        foreach ($socmed as $key => $data) {
            if ($data != "") {
                $data = array(
                    "id_relasi" => $id_relasi,
                    "id_jenis_socmed" => $this->id_socmed[$key],
                    "tipe" => $this->tipe,
                    "link" => $data,
                );
                
                $this->db->insert($this->socmed, $data);
            }
        }
        
        return true;
    }
    
    public function tipe ($tipe) {
        $this->tipe = $tipe;
        return $this;
    }
    
    public function edit ($id_relasi, $socmed) {
        $this->delete($id_relasi);
        return $this->add($id_relasi, $socmed);
    }
    
    public function delete ($id_relasi) {
        return $this->db
            ->where("tipe", $this->tipe)
            ->where("id_relasi", $id_relasi)
            ->delete($this->socmed);
    }
    
    public function getData ($field = "*", $id = 0) {
        if ($id > 0) {
            $this->db
                ->where("id_socmed", $id)
                ->limit(1);
        }
        
        return $this->db
            ->select($field)
            ->get("$this->socmed s");
    }
    
    public function getDataSocmedArray () {
        $sql = $this->getData("id_jenis_socmed, link");
        $socmed = array();
        foreach ($sql->result() as $data) {
            $socmed += array(
                $data->id_jenis_socmed => $data->link
            );
        }
        
        return $socmed;
    }

}