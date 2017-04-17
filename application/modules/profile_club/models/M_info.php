<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_info extends CI_Model {
    
    private $meta;

    public function __construct() {
        parent::__construct();
        $table = $this->config->load("database_table", true);
        $this->meta = $table['tb_meta'];
    }
    
    public function prosesMetaUmum ($data) {
        $sql = $this->getDataMetaUmum();
        if ($sql->num_rows() > 0) {
            $this->db
                ->where("tipe", "web_info")
                ->like("label", "meta_umum", "after")
                ->delete($this->meta);
        }
        $config = array();
        foreach ($data as $key => $val) {
            array_push($config, array(
                "id_relasi" => 0,
                "tipe" => "web_info",
                "label" => "meta_umum_" . $key,
                "value" => $val
            ));
        }
        return $this->db->insert_batch($this->meta, $config);
    }
    
    public function prosesMetaSocmed ($data) {
        $sql = $this->getDataMetaSocmed();
        if ($sql->num_rows() > 0) {
            $this->db
                ->where("tipe", "web_info")
                ->like("label", "meta_socmed", "after")
                ->delete($this->meta);
        }
        $config = array();
        foreach ($data as $key => $val) {
            array_push($config, array(
                "id_relasi" => 0,
                "tipe" => "web_info",
                "label" => "meta_socmed_" . $key,
                "value" => $val
            ));
        }
        return $this->db->insert_batch($this->meta, $config);
    }
    
    public function getDataMetaUmum () {
        return $this->db
            ->select("label, value")
            ->where("tipe", "web_info")
            ->like("label", "meta_umum", "after")
            ->get($this->meta);
    }
    
    public function getDataMetaSocmed () {
        return $this->db
            ->select("label, value")
            ->where("tipe", "web_info")
            ->like("label", "meta_socmed", "after")
            ->get($this->meta);
    }
    
    public function getData ($field = "*", $id = 0) {
        if ($id > 0) {
            $this->db
                ->where("id_meta", $id)
                ->limit(1);
        }
        return $this->db
            ->select($field)
            ->get($this->meta);
    }

}