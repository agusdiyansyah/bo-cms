<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_default_menu extends CI_Migration {
    
    protected $tb = "menu_admin";

    public function __construct() {
        parent::__construct();
    }

    public function up() {
        $data = array(
            array(
                "id_menu" => null,
                "name" => "Dashboard",
                "link" => "dashboard",
                "icon" => "fa fa-dashboard",
                "order" => 1,
                "is_active" => 1,
                "is_parent" => 0,
                "level" => 0
            ),
            array(
                "id_menu" => null,
                "name" => "Profile Klub",
                "link" => "#",
                "icon" => "fa fa-bank",
                "order" => 2,
                "is_active" => 1,
                "is_parent" => 0,
                "level" => 0
            ),
                array(
                    "id_menu" => null,
                    "name" => "Histori",
                    "link" => "profile_club/histori",
                    "icon" => "",
                    "order" => 3,
                    "is_active" => 1,
                    "is_parent" => 2,
                    "level" => 0
                ),
                array(
                    "id_menu" => null,
                    "name" => "Galeri",
                    "link" => "profile_club/galeri",
                    "icon" => "",
                    "order" => 4,
                    "is_active" => 1,
                    "is_parent" => 2,
                    "level" => 0
                ),
                array(
                    "id_menu" => null,
                    "name" => "Trophy",
                    "link" => "profile_club/trophy",
                    "icon" => "",
                    "order" => 5,
                    "is_active" => 1,
                    "is_parent" => 2,
                    "level" => 0
                ),
            array(
                "id_menu" => null,
                "name" => "Pengurus",
                "link" => "pengurus",
                "icon" => "fa fa-users",
                "order" => 6,
                "is_active" => 1,
                "is_parent" => 0,
                "level" => 0
            ),
            array(
                "id_menu" => null,
                "name" => "Setting",
                "link" => "#",
                "icon" => "fa fa-gear",
                "order" => 7,
                "is_active" => 1,
                "is_parent" => 0,
                "level" => 0
            ),
                array(
                    "id_menu" => null,
                    "name" => "Administrator",
                    "link" => "administrator",
                    "icon" => "",
                    "order" => 8,
                    "is_active" => 1,
                    "is_parent" => 7,
                    "level" => 0
                ),
                array(
                    "id_menu" => null,
                    "name" => "Manajemen Menu",
                    "link" => "menu/admin",
                    "icon" => "",
                    "order" => 9,
                    "is_active" => 1,
                    "is_parent" => 7,
                    "level" => 0
                ),
        );
        
        $this->db->insert_batch($this->tb, $data);
    }
    
    public function down () {
        
    }

}