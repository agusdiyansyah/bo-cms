<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_update_column_in_table_trophy extends CI_Migration{
    
    private $trophy;

    public function __construct() {
        parent::__construct();
        $table = $this->config->load("database_table", true);
        $this->trophy = $table['tb_trophy'];
    }

    public function up() {
        $this->dbforge->add_column($this->trophy, array(
            'id_galeri' => array(
                'type' => 'INT',
                'null' => FALSE
            ),
            'slug' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => FALSE
            ),
        ));
    }
    
    public function down () {
        $this->dbforge->drop_column($this->trophy, 'id_galeri');
        $this->dbforge->drop_column($this->trophy, 'slug');
    }

}