<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_table_page extends CI_Migration {
    
    protected $tb;

    public function __construct() {
        parent::__construct();
        $table = $this->config->load("database_table", true);
        $this->tb = $table['tb_page'];
    }

    public function up() {
        $field = array(
            'id_page' => array(
                'type' => 'INT',
                'auto_increment' => TRUE,
            ),
            'status' => array(
                'type' => 'TINYINT',
                'null' => FALSE,
                'default' => 1
            ),
            'tipe' => array(
                'type' => 'VARCHAR',
                'constraint' => 10,
                'null' => FALSE,
            ),
            'title' => array(
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => FALSE
            ),
            'slug' => array(
                'type' => 'VARCHAR',
                'constraint' => 150,
                'null' => FALSE
            ),
            'cover' => array(
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => FALSE
            ),
            'content' => array(
                'type' => 'TEXT',
                'null' => TRUE
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
        $this->dbforge->add_key('id_page', TRUE);
        $this->dbforge->create_table($this->tb);
    }
    
    public function down () {
        if ($this->db->table_exists($this->tb)) {
            $this->dbforge->drop_table($this->tb);
        }
    }

}