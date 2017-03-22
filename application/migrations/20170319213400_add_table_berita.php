<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_table_berita extends CI_Migration {
    
    private $berita;
    private $menu_admin;

    public function __construct() {
        parent::__construct();
        $table = $this->config->load("database_table", true);
        $this->berita = $table['tb_berita'];
        $this->menu_admin = $table['tb_menu_admin'];
    }

    public function up() {
        $field = array(
            'id_berita' => array(
                'type' => 'INT',
                'auto_increment' => TRUE,
            ),
            'id_kategori' => array(
                'type' => 'INT',
                'null' => FALSE,
                'default' => 0
            ),
            'title' => array(
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => FALSE
            ),
            'sinopsis' => array(
                'type' => 'VARCHAR',
                'constraint' => '300',
                'null' => FALSE
            ),
            'content' => array(
                'type' => 'TEXT',
                'null' => FALSE
            ),
            'status' => array(
                'type' => 'ENUM("publish", "draf")',
                'default' => 'publish',
                'null' => FALSE
            ),
            'datecreate TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
            'dateupdate TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP',
            'isdelete' => array(
                'type' => 'TINYINT',
                'null' => FALSE,
                'default' => 0
            ),
        );
        
        $this->dbforge->add_field($field);
        $this->dbforge->add_key('id_berita', TRUE);
        $this->dbforge->create_table($this->berita);
        
        $menuBerita = array(
            "id_menu" => null,
            "name" => "Berita",
            "link" => "berita",
            "icon" => "fa fa-newspaper-o",
            "order" => 2,
            "is_active" => 1,
            "is_parent" => 0,
            "level" => 0
        );
        
        $this->db->insert($this->menu_admin, $menuBerita);
    }
    
    public function down () {
        if ($this->db->table_exists($this->berita)) {
            $this->dbforge->drop_table($this->berita);
        }
    }

}