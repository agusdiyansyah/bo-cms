<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_default_menu extends CI_Migration {
    
    protected $tb;

    public function __construct() {
        parent::__construct();
        $table = $this->config->load("database_table", true);
        $this->tb = $table['tb_menu_admin'];
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
                "name" => "Slideshow",
                "link" => "slideshow",
                "icon" => "fa fa-slideshare",
                "order" => 2,
                "is_active" => 1,
                "is_parent" => 0,
                "level" => 0
            ),
            array(
                "id_menu" => null,
                "name" => "Profil Team",
                "link" => "#",
                "icon" => "fa fa-bank",
                "order" => 10,
                "is_active" => 1,
                "is_parent" => 0,
                "level" => 0
            ),
                array(
                    "id_menu" => null,
                    "name" => "Histori",
                    "link" => "profile_club/histori",
                    "icon" => "",
                    "order" => 4,
                    "is_active" => 1,
                    "is_parent" => 3,
                    "level" => 0
                ),
                array(
                    "id_menu" => null,
                    "name" => "Trophy",
                    "link" => "profile_club/trophy",
                    "icon" => "",
                    "order" => 6,
                    "is_active" => 1,
                    "is_parent" => 3,
                    "level" => 0
                ),
                array(
                    "id_menu" => null,
                    "name" => "Tentang Kami",
                    "link" => "profile_club/aboutus",
                    "icon" => "",
                    "order" => 14,
                    "is_active" => 1,
                    "is_parent" => 3,
                    "level" => 0
                ),
                array(
                    "id_menu" => null,
                    "name" => "Informasi Umum",
                    "link" => "profile_club/info",
                    "icon" => "",
                    "order" => 1,
                    "is_active" => 1,
                    "is_parent" => 3,
                    "level" => 0
                ),
                array(
                    "id_menu" => null,
                    "name" => "Galeri",
                    "link" => "media",
                    "icon" => "",
                    "order" => 16,
                    "is_active" => 1,
                    "is_parent" => 3,
                    "level" => 0
                ),
            array(
                "id_menu" => null,
                "name" => "Pemain",
                "link" => "pemain",
                "icon" => "fa fa-address-card-o",
                "order" => 6,
                "is_active" => 1,
                "is_parent" => 0,
                "level" => 0
            ),
            array(
                "id_menu" => null,
                "name" => "Pengurus",
                "link" => "pengurus",
                "icon" => "fa fa-address-card",
                "order" => 7,
                "is_active" => 1,
                "is_parent" => 0,
                "level" => 0
            ),
            array(
                "id_menu" => null,
                "name" => "Pertandingan",
                "link" => "#",
                "icon" => "fa fa-trophy",
                "order" => 8,
                "is_active" => 1,
                "is_parent" => 0,
                "level" => 0
            ),
                array(
                    "id_menu" => null,
                    "name" => "Jadwal",
                    "link" => "pertandingan/jadwal",
                    "icon" => "fa fa-angle-right",
                    "order" => 1,
                    "is_active" => 1,
                    "is_parent" => 11,
                    "level" => 0
                ),
                array(
                    "id_menu" => null,
                    "name" => "Hasil",
                    "link" => "pertandingan/hasil",
                    "icon" => "fa fa-angle-right",
                    "order" => 2,
                    "is_active" => 1,
                    "is_parent" => 11,
                    "level" => 0
                ),
            array(
                "id_menu" => null,
                "name" => "Setting",
                "link" => "#",
                "icon" => "fa fa-gear",
                "order" => 11,
                "is_active" => 1,
                "is_parent" => 0,
                "level" => 0
            ),
                array(
                    "id_menu" => null,
                    "name" => "Administrator",
                    "link" => "administrator",
                    "icon" => "",
                    "order" => 12,
                    "is_active" => 1,
                    "is_parent" => 13,
                    "level" => 0
                ),
                array(
                    "id_menu" => null,
                    "name" => "Manajemen Menu",
                    "link" => "menu/admin",
                    "icon" => "",
                    "order" => 13,
                    "is_active" => 1,
                    "is_parent" => 13,
                    "level" => 0
                ),
        );
        
        $this->db->insert_batch($this->tb, $data);
    }
    
    public function down () {
        
    }

}