<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_remove_column_isdelete_from_galeri_and_file extends CI_Migration{
    
    private $galeri;
    private $file;

    public function __construct() {
        parent::__construct();
        $table = $this->config->load("database_table", true);
        $this->galeri = $table['tb_galeri'];
        $this->file = $table['tb_file'];
    }

    public function up() {
        $this->dbforge->drop_column($this->galeri, 'isdelete');
        $this->dbforge->drop_column($this->file, 'isdelete');
    }

}