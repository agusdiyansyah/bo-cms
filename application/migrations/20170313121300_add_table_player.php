<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_table_player extends CI_Migration{
    
    protected $tb;

    public function __construct() {
        parent::__construct();
        $table = $this->config->load("database_table", true);
        $this->tb = $table['tb_player'];
    }

    public function up() {
        $field = array(
            'id_player' => array(
                'type' => 'VARCHAR',
                'constraint' => 32,
                'null', FALSE
            ),
            'id_team' => array(
                'type' => 'VARCHAR',
                'constraint' => 32,
                'null', FALSE
            ),
            'id_level' => array(
                'type' => 'SMALLINT',
                'null', FALSE
            ),
            'id_sosmed' => array(
                'type' => 'INT',
                'null', FALSE
            ),
            'player_name' => array(
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null', FALSE
            ),
            'no_jersey' => array(
                'type' => 'SMALLINT',
                'null', FALSE
            ),
            'dob' => array(
                'type' => 'DATE',
                'null', FALSE
            ),
            'nicename' => array(
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null', FALSE
            ),
            'pob' => array(
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null', FALSE
            ),
            'photo' => array(
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null', FALSE
            ),
            'description' => array(
                'type' => 'TEXT',
                'null', FALSE
            ),
        );
        
        $this->dbforge->add_field($field);
        $this->dbforge->add_key('id_player', TRUE);
        $this->dbforge->create_table($this->tb);
    }
    
    public function down () {
        if ($this->db->table_exists($this->tb)) {
            $this->dbforge->drop_table($this->tb);
        }
    }

}