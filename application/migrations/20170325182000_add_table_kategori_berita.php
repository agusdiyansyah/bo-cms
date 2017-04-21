<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_table_kategori_berita extends CI_Migration {
    
    private $berita_kategori;
    private $menu_admin;
    private $id_menu;

    public function __construct() {
        parent::__construct();
        $table = $this->config->load("database_table", true);
        $this->berita_kategori = $table['tb_berita_kategori'];
        $this->menu_admin = $table['tb_menu_admin'];
        
        $menu = $this->db
            ->select("id_menu")
            ->where("name", "Berita")
            ->get($this->menu_admin, 1)
            ->row();
            
        $this->id_menu = $menu->id_menu;
    }

    public function up() {
        $field = array(
            'id_kategori' => array(
                'type' => 'INT',
                'auto_increment' => TRUE,
            ),
            'kategori' => array(
                'type' => 'VARCHAR',
                'default' => '',
                'constraint' => 50,
                'null' => FALSE,
            ),
            'slug' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => FALSE
            ),
        );
        
        $this->dbforge->add_field($field);
        $this->dbforge->add_key('id_kategori', TRUE);
        $this->dbforge->create_table($this->berita_kategori);
            
        $this->db
            ->where("id_menu", $this->id_menu)
            ->update($this->menu_admin, array(
                "link" => "#"
            ));
    }
    
    public function down () {    
        if ($this->db->table_exists($this->berita_kategori)) {
            $this->dbforge->drop_table($this->berita_kategori);
        }
    }

}