<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_table_jenis_socmed_and_default_data extends CI_Migration {
    
    protected $tb;

    public function __construct() {
        parent::__construct();
        $table = $this->config->load("database_table", true);
        $this->tb = $table['tb_jenis_socmed'];
    }

    public function up() {
        $field = array(
            'id_jenis_socmed' => array(
                'type' => 'INT',
                'auto_increment' => TRUE,
            ),
            'icon' => array(
                'type' => 'VARCHAR',
                'constraint' =>20,
                'null' => FALSE,
            ),
            'title' => array(
                'type' => 'VARCHAR',
                'constraint' => 10,
                'null' => FALSE
            )
        );
        $this->dbforge->add_field($field);
        $this->dbforge->add_key('id_jenis_socmed', TRUE);
        $this->dbforge->create_table($this->tb);
        
        $data = array(
            array(
                'id_jenis_socmed' => null,
                'icon' => 'fa fa-twitter',
                'title' => 'Twitter',
            ),
            array(
                'id_jenis_socmed' => null,
                'icon' => 'fa fa-facebook',
                'title' => 'Facebook',
            ),
            array(
                'id_jenis_socmed' => null,
                'icon' => 'fa fa-instagram',
                'title' => 'Instagram',
            ),
            array(
                'id_jenis_socmed' => null,
                'icon' => 'fa fa-google',
                'title' => 'Google plus',
            ),
            array(
                'id_jenis_socmed' => null,
                'icon' => 'fa fa-heart',
                'title' => 'Bloglovin',
            ),
            array(
                'id_jenis_socmed' => null,
                'icon' => 'fa fa-pinterest',
                'title' => 'Pinterest',
            ),
            array(
                'id_jenis_socmed' => null,
                'icon' => 'fa fa-youtube',
                'title' => 'YouTube',
            ),
            array(
                'id_jenis_socmed' => null,
                'icon' => 'fa fa-tumblr',
                'title' => 'Tumblr',
            )
        );
        
        $this->db->insert_batch($this->tb, $data);
    }
    
    public function down () {
        if ($this->db->table_exists($this->tb)) {
            $this->dbforge->drop_table($this->tb);
        }
    }

}