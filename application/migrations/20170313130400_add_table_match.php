<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_table_match extends CI_Migration {
    
    protected $tb;

    public function __construct() {
        parent::__construct();
        $table = $this->config->load("database_table", true);
        $this->tb = $table['tb_match'];
    }

    public function up() {
        $field = array(
            'id_match' => array(
                'type' => 'INT',
                'auto_increment' => TRUE,
            ),
            'match_status' => array(
                'type' => 'ENUM("jadwal", "hasil", "main")',
                'default' => 'jadwal',
                'null' => FALSE,
            ),
            'match_date' => array(
                'type' => 'DATETIME',
                'null' => FALSE
            ),
            'match_rival' => array(
                'type' => 'VARCHAR',
                'constraint' => 100,
                'null' => FALSE,
            ),
            'alamat' => array(
                'type' => 'VARCHAR',
                'constraint' => 200,
                'null' => FALSE,
            ),
            'match_homeaway' => array(
                'type' => 'ENUM("home", "away")',
                'default' => 'home',
                'null' => FALSE,
            ),
            'match_resultstatus' => array(
                'type' => 'ENUM("win", "lose", "draw")',
                'null' => FALSE,
            ),
            'match_resultscore1' => array(
                'type' => 'TINYINT',
                'null' => FALSE
            ),
            'match_resultscore2' => array(
                'type' => 'TINYINT',
                'null' => FALSE
            )
        );
        $this->dbforge->add_field($field);
        $this->dbforge->add_key('id_match', TRUE);
        $this->dbforge->create_table($this->tb);
    }
    
    public function down () {
        if ($this->db->table_exists($this->tb)) {
            $this->dbforge->drop_table($this->tb);
        }
    }

}