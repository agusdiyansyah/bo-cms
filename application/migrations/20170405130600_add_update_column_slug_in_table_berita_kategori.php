<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_update_column_slug_in_table_berita_kategori extends CI_Migration{
    
    private $berita_kategori;

    public function __construct() {
        parent::__construct();
        $table = $this->config->load("database_table", true);
        $this->berita_kategori = $table['tb_berita_kategori'];
    }

    public function up() {
        $this->dbforge->add_column($this->berita_kategori, array(
            'slug' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => FALSE
            ),
        ));
    }
    
    public function down () {
        $this->dbforge->drop_column($this->berita_kategori, 'slug');
    }

}