<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_page extends CI_Model {
    
    private $page;

    public function __construct() {
        parent::__construct();
        
        $table = $this->config->load("database_table", true);
        $this->page = $table['tb_page'];
    }
    
    public function prosesSpecialPage ($data, $tipe) {
        $this->db->where("tipe", $tipe);
        $sql = $this->getData("id_page");
        if ($sql->num_rows() > 0) {
            $val = $sql->row();
            $callback = $this->edit($data, $val->id_page);
        } else {
            $callback = $this->add($data);
        }
        
        return $callback;
    }
    
    public function add ($data) {
        return $this->db->insert($this->page, $data);
    }
    
    public function edit ($data, $id) {
        return $this->db
            ->where('id_page', $id)
            ->update($this->page, $data);
    }
    
    public function getData ($field = "*", $id = 0) {
        if ($id > 0) {
            $this->db
                ->where("id_page", $id)
                ->limit(1);
        }
        
        return $this->db
            ->select($field)
            ->get($this->page);
    }

}