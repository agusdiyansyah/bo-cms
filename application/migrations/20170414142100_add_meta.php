<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_meta extends CI_Migration {
    
    private $berita;

    public function __construct() {
        parent::__construct();
        $table = $this->config->load("database_table", true);
        $this->meta = $table['tb_meta'];
    }

    public function up() {
        $field = array(
            'id_relasi' => array(
                'type' => 'INT',
                'null' => FALSE
            ),
            'tipe' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => FALSE
            ),
            'label' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => FALSE
            ),
            'value' => array(
                'type' => "TEXT",
                'null' => FALSE
            ),
        );
        
        $this->dbforge->add_field($field);
        $this->dbforge->add_key('id_meta', TRUE);
        $this->dbforge->create_table($this->meta);
    }
    
    public function down () {
        if ($this->db->table_exists($this->meta)) {
            $this->dbforge->drop_table($this->meta);
        }
    }

}