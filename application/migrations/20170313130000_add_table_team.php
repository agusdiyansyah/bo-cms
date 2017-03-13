<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_table_team extends CI_Migration {
    
    protected $tb;

    public function __construct() {
        parent::__construct();
        $table = $this->config->load("database_table", true);
        $this->tb = $table['tb_team'];
    }

    public function up() {
        $field = array(
            'id_team' => array(
                'type' => 'VARCHAR',
                'constraint' => 32
            ),
            'id_city' => array(
                'type' => 'VARCHAR',
                'constraint' => 10,
                'null' => FALSE,
            ),
            'id_socmed' => array(
                'type' => 'INT',
                'null' => FALSE
            ),
            'team_name' => array(
                'type' => 'VARCHAR',
                'constraint' => 200,
                'null' => FALSE,
            ),
            'team_slug' => array(
                'type' => 'VARCHAR',
                'constraint' => 200,
                'null' => FALSE,
            ),
            'team_logo' => array(
                'type' => 'VARCHAR',
                'constraint' => 200,
                'null' => FALSE,
            ),
            'team_description' => array(
                'type' => 'TEXT',
                'null' => FALSE
            )
        );
        $this->dbforge->add_field($field);
        $this->dbforge->add_key('id_team', TRUE);
        $this->dbforge->create_table($this->tb);
    }
    
    public function down () {
        if ($this->db->table_exists($this->tb)) {
            $this->dbforge->drop_table($this->tb);
        }
    }

}