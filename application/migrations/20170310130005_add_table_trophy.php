<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_table_trophy extends CI_Migration {
    
    protected $tb;

    public function __construct() {
        parent::__construct();
        $table = $this->config->load("database_table", true);
        $this->tb = $table['tb_trophy'];
    }

    public function up() {
        $field = array(
            'id_trophy' => array(
                'type' => 'INT',
                'auto_increment' => TRUE,
            ),
            'id_galeri' => array(
                'type' => 'INT',
                'null' => FALSE
            ),
            'nama_trophy' => array(
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => FALSE
            ),
            'slug' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => FALSE
            ),
            'tahun' => array(
                'type' => 'YEAR',
                'null' => TRUE
            ),
            'photo' => array(
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => FALSE
            ),
            'keterangan' => array(
                'type' => 'TEXT',
                'null' => TRUE
            )
        );
        $this->dbforge->add_field($field);
        $this->dbforge->add_key('id_trophy', TRUE);
        $this->dbforge->create_table($this->tb);
    }
    
    public function down () {
        if ($this->db->table_exists($this->tb)) {
            $this->dbforge->drop_table($this->tb);
        }
    }

}