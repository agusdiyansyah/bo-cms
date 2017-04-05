<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_update_column_in_table_berita extends CI_Migration{
    
    private $berita;

    public function __construct() {
        parent::__construct();
        $table = $this->config->load("database_table", true);
        $this->berita = $table['tb_berita'];
    }

    public function up() {
        $this->dbforge->add_column($this->berita, array(
            'slug' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => FALSE
            ),
        ));
    }
    
    public function down () {
        $this->dbforge->drop_column($this->berita, 'slug');
    }

}