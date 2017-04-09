<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_update_table_socmed extends CI_Migration {
    
    private $socmed;

    public function __construct() {
        parent::__construct();
        $table = $this->config->load("database_table", true);
        $this->socmed = $table['tb_socmed'];
    }

    public function up () {
        $fields = array(
            'id_player' => array(
                'name' => 'id_relasi',
                'type' => 'INT',
            ),
        );
        
        $this->dbforge->modify_column($this->socmed, $fields);
    }
    
    public function down () {
        $fields = array(
            'id_relasi' => array(
                'name' => 'id_player',
                'type' => 'INT',
            ),
        );
        
        $this->dbforge->modify_column($this->socmed, $fields);
    }

}