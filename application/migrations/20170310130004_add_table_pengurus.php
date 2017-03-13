<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_table_pengurus extends CI_Migration {
    
    protected $tb;

    public function __construct() {
        parent::__construct();
        $table = $this->config->load("database_table", true);
        $this->tb = $table['tb_pengurus'];
    }

    public function up() {
        $field = array(
            'id_pengurus' => array(
                'type' => 'INT',
                'auto_increment' => TRUE,
            ),
            'nama_pengurus' => array(
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => FALSE
            ),
        );
        $this->dbforge->add_field($field);
        $this->dbforge->add_key('id_pengurus', TRUE);
        $this->dbforge->create_table($this->tb);
    }
    
    public function down () {
        if ($this->db->table_exists($this->tb)) {
            $this->dbforge->drop_table($this->tb);
        }
    }

}