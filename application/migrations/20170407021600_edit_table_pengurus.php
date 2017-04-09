<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_edit_table_pengurus extends CI_Migration {
    
    private $pengurus;

    public function __construct() {
        parent::__construct();
        $table = $this->config->load("database_table", true);
        $this->pengurus = $table['tb_pengurus'];
    }

    public function up() {
        $this->dbforge->drop_column($this->pengurus, "nama_pengurus");
        
        $field = array(
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
            'photo' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => FALSE
            ),
            'id_jabatan' => array(
                'type' => 'INT',
                'null' => FALSE
            ),
            "kota_kelahiran" => array(
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => FALSE
            ),
            "tanggal_lahir" => array(
                'type' => 'DATE',
                'null' => FALSE
            ),
            "biografi" => array(
                'type' => 'TEXT',
                'null' => FALSE
            ),
        );
        
        $this->dbforge->add_column($this->pengurus, $field);
    }
    
    public function down () {
        $this->dbforge->drop_column($this->pengurus, "nama");
        $this->dbforge->drop_column($this->pengurus, "slug");
        $this->dbforge->drop_column($this->pengurus, "id_jabatan");
        $this->dbforge->drop_column($this->pengurus, "kota_kelahiran");
        $this->dbforge->drop_column($this->pengurus, "tanggal_lahir");
        $this->dbforge->drop_column($this->pengurus, "biografi");
        
        $this->dbforge->add_field(array(
            'nama_pengurus' => array(
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => FALSE
            ),
        ));
    }

}