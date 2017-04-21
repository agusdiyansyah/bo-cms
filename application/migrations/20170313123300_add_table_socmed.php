<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_table_socmed extends CI_Migration {
    
    protected $tb;

    public function __construct() {
        parent::__construct();
        $table = $this->config->load("database_table", true);
        $this->tb = $table['tb_socmed'];
    }

    public function up() {
        $field = array(
            'id_socmed' => array(
                'type' => 'INT',
                'auto_increment' => TRUE,
            ),
            'id_relasi' => array(
                'type' => 'INT',
                'null' => FALSE,
            ),
            'id_jenis_socmed' => array(
                'type' => 'TINYINT',
                'null' => FALSE,
            ),
            'tipe' => array(
                'type' => 'VARCHAR',
                'constraint' => 20,
                'null' => FALSE,
            ),
            'link' => array(
                'type' => 'VARCHAR',
                'constraint' => 150,
                'null' => FALSE
            )
        );
        $this->dbforge->add_field($field);
        $this->dbforge->add_key('id_socmed', TRUE);
        $this->dbforge->create_table($this->tb);
    }
    
    public function down () {
        if ($this->db->table_exists($this->tb)) {
            $this->dbforge->drop_table($this->tb);
        }
    }

}