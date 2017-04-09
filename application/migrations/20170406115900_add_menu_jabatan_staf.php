<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_menu_jabatan_staf extends CI_Migration{
    
    private $pengurus_jabatan;
    private $menu_admin;
    private $id_menu;

    public function __construct() {
        parent::__construct();
        $table = $this->config->load("database_table", true);
        $this->pengurus_jabatan = $table['tb_pengurus_jabatan'];
        $this->menu_admin = $table['tb_menu_admin'];
        
        $menu = $this->db
            ->select("id_menu")
            ->where("name", "Pengurus")
            ->get($this->menu_admin, 1)
            ->row();
            
        $this->id_menu = $menu->id_menu;
    }

    public function up() {
        $field = array(
            'id_jabatan' => array(
                'type' => 'INT',
                'auto_increment' => TRUE,
            ),
            'jabatan' => array(
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => FALSE,
            )
        );
        $this->dbforge->add_field($field);
        $this->dbforge->add_key('id_jabatan', TRUE);
        $this->dbforge->create_table($this->pengurus_jabatan);
        
        $this->db
            ->where("id_menu", $this->id_menu)
            ->update($this->menu_admin, array(
                "link" => "#"
            ));
            
        $menu = array(
            array(
                "id_menu" => null,
                "name" => "Data",
                "link" => "pengurus",
                "icon" => "fa fa-angle-right",
                "order" => 1,
                "is_active" => 1,
                "is_parent" => $this->id_menu,
                "level" => 0
            ),
            array(
                "id_menu" => null,
                "name" => "Jabatan",
                "link" => "pengurus/jabatan",
                "icon" => "fa fa-angle-right",
                "order" => 2,
                "is_active" => 1,
                "is_parent" => $this->id_menu,
                "level" => 0
            ),
        );
        
        $this->db->insert_batch($this->menu_admin, $menu);
    }
    
    public function down () {
        $this->db
            ->where("link", "pengurus")
            ->or_where("link", "pengurus/jabatan")
            ->delete($this->menu_admin);
            
        $this->db
            ->where("id_menu", $this->id_menu)
            ->update($this->menu_admin, array(
                "link" => "pengurus"
            ));
            
        if ($this->db->table_exists($this->pengurus_jabatan)) {
            $this->dbforge->drop_table($this->pengurus_jabatan);
        }
    }

}