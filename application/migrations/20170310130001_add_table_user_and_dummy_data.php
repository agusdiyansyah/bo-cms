<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_table_user_and_dummy_data extends CI_Migration {
    
    protected $tb = "user";

    public function __construct() {
        parent::__construct();
    }

    public function up() {
        $field = array(
            'id_user' => array(
                'type' => 'INT',
                'auto_increment' => TRUE,
            ),
            'username' => array(
                'type' => 'VARCHAR',
                'constraint' => '60',
                'null' => FALSE
            ),
            'password' => array(
                'type' => 'VARCHAR',
                'constraint' => '150',
                'null' => FALSE
            ),
            'nama' => array(
                'type' => 'VARCHAR',
                'constraint' => '50',
                'null' => FALSE
            ),
            'email' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => FALSE
            ),
            'status' => array(
                'type' => 'TINYINT',
                'null' => FALSE
            ),
            'level' => array(
                'type' => 'TINYINT',
                'null' => FALSE
            ),
            'foto' => array(
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => FALSE
            )
        );
        $this->dbforge->add_field($field);
        $this->dbforge->add_key('id_user', TRUE);
        $this->dbforge->create_table($this->tb);
        
        $this->db->insert($this->tb, array(
            "id_user" => null,
            "username" => "admin",
            "password" => password_hash(1,PASSWORD_BCRYPT),
            "nama" => "Root Admin",
            "email" => "admin@mail.com",
            "status" => 1,
            "level" => 100,
            "foto" => "",
        ));
    }
    
    public function down () {
        if ($this->db->table_exists($this->tb)) {
            $this->dbforge->drop_table($this->tb);
        }
    }

}