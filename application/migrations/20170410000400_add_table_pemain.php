<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_table_pemain extends CI_Migration {
    
    private $berita;

    public function __construct() {
        parent::__construct();
        $table = $this->config->load("database_table", true);
        $this->pemain = $table['tb_pemain'];
    }

    public function up() {
        $field = array(
            'id_pemain' => array(
                'type' => 'INT',
                'auto_increment' => TRUE,
            ),
            'nama' => array(
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => FALSE
            ),
            'slug' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => FALSE
            ),
            'no_jersey' => array(
                'type' => 'INT',
                'null' => FALSE
            ),
            'posisi' => array(
                'type' => 'VARCHAR',
                'constraint' => '25',
                'null' => FALSE
            ),
            'photo' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => FALSE
            ),
            'kota_kelahiran' => array(
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => FALSE
            ),
            'tanggal_lahir' => array(
                'type' => 'DATE',
                'null' => FALSE
            ),
            'biografi' => array(
                'type' => 'TEXT',
                'null' => FALSE
            ),
        );
        
        $this->dbforge->add_field($field);
        $this->dbforge->add_key('id_pemain', TRUE);
        $this->dbforge->create_table($this->pemain);
    }
    
    public function down () {
        if ($this->db->table_exists($this->pemain)) {
            $this->dbforge->drop_table($this->pemain);
        }
    }

}