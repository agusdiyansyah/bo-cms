<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_table_menu_admin extends CI_Migration {
    
    protected $tb;

    public function __construct() {
        parent::__construct();
        $table = $this->config->load("database_table", true);
        $this->tb = $table['tb_menu_admin'];
    }

    public function up() {
        $field = array(
            'id_menu' => array(
                'type' => 'INT',
                'auto_increment' => TRUE,
            ),
            'name' => array(
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => FALSE
            ),
            'link' => array(
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => FALSE
            ),
            'icon' => array(
                'type' => 'VARCHAR',
                'constraint' => '30',
                'null' => FALSE
            ),
            'order' => array(
                'type' => 'INT',
                'null' => FALSE
            ),
            'is_active' => array(
                'type' => 'TINYINT',
                'null' => FALSE
            ),
            'is_parent' => array(
                'type' => 'TINYINT',
                'null' => FALSE
            ),
            'level' => array(
                'type' => 'TINYINT',
                'null' => FALSE
            )
        );
        $this->dbforge->add_field($field);
        $this->dbforge->add_key('id_menu', TRUE);
        $this->dbforge->create_table($this->tb);
    }
    
    public function down () {
        if ($this->db->table_exists($this->tb)) {
            $this->dbforge->drop_table($this->tb);
        }
    }

}