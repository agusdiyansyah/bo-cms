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
            // dashboard
            array(
                "id_menu" => 1,
                "name" => "Dashboard",
                "link" => "dashboard",
                "icon" => "fa fa-dashboard",
                "order" => 1,
                "is_active" => 1,
                "is_parent" => 0,
                "level" => 0
            ),
            // berita
            array(
                "id_menu" => 2,
                "name" => "Berita",
                "link" => "#",
                "icon" => "fa fa-newspaper-o",
                "order" => 2,
                "is_active" => 1,
                "is_parent" => 0,
                "level" => 0
            ),
                array(
                    "id_menu" => 3,
                    "name" => "Data",
                    "link" => "berita",
                    "icon" => "fa fa-angle-right",
                    "order" => 1,
                    "is_active" => 1,
                    "is_parent" => 2,
                    "level" => 0
                ),
                array(
                    "id_menu" => 4,
                    "name" => "Kategori",
                    "link" => "berita/kategori",
                    "icon" => "fa fa-angle-right",
                    "order" => 2,
                    "is_active" => 1,
                    "is_parent" => 2,
                    "level" => 0
                ),
            // slideshow
            array(
                "id_menu" => 5,
                "name" => "Slideshow",
                "link" => "slideshow",
                "icon" => "fa fa-slideshare",
                "order" => 3,
                "is_active" => 1,
                "is_parent" => 0,
                "level" => 0
            ),
            // pemain
            array(
                "id_menu" => 6,
                "name" => "Pemain",
                "link" => "pemain",
                "icon" => "fa fa-address-card-o",
                "order" => 6,
                "is_active" => 1,
                "is_parent" => 0,
                "level" => 0
            ),
            // pengurus
            array(
                "id_menu" => 7,
                "name" => "Pengurus",
                "link" => "pengurus",
                "icon" => "fa fa-address-card",
                "order" => 7,
                "is_active" => 1,
                "is_parent" => 0,
                "level" => 0
            ),
                array(
                    "id_menu" => 8,
                    "name" => "Data",
                    "link" => "pengurus",
                    "icon" => "fa fa-angle-right",
                    "order" => 1,
                    "is_active" => 1,
                    "is_parent" => 7,
                    "level" => 0
                ),
                array(
                    "id_menu" => 9,
                    "name" => "Jabatan",
                    "link" => "pengurus/jabatan",
                    "icon" => "fa fa-angle-right",
                    "order" => 2,
                    "is_active" => 1,
                    "is_parent" => 7,
                    "level" => 0
                ),
            // pertandingan
            array(
                "id_menu" => 10,
                "name" => "Pertandingan",
                "link" => "#",
                "icon" => "fa fa-trophy",
                "order" => 8,
                "is_active" => 1,
                "is_parent" => 0,
                "level" => 0
            ),
                array(
                    "id_menu" => 11,
                    "name" => "Jadwal",
                    "link" => "pertandingan/jadwal",
                    "icon" => "fa fa-angle-right",
                    "order" => 1,
                    "is_active" => 1,
                    "is_parent" => 10,
                    "level" => 0
                ),
                array(
                    "id_menu" => 12,
                    "name" => "Hasil",
                    "link" => "pertandingan/hasil",
                    "icon" => "fa fa-angle-right",
                    "order" => 2,
                    "is_active" => 1,
                    "is_parent" => 10,
                    "level" => 0
                ),
            // profile team
            array(
                "id_menu" => 13,
                "name" => "Profil Team",
                "link" => "#",
                "icon" => "fa fa-bank",
                "order" => 10,
                "is_active" => 1,
                "is_parent" => 0,
                "level" => 0
            ),
                array(
                    "id_menu" => 14,
                    "name" => "Informasi Umum",
                    "link" => "profile_club/info",
                    "icon" => "fa fa-angle-right",
                    "order" => 1,
                    "is_active" => 1,
                    "is_parent" => 13,
                    "level" => 0
                ),
                array(
                    "id_menu" => 15,
                    "name" => "Histori",
                    "link" => "profile_club/histori",
                    "icon" => "fa fa-angle-right",
                    "order" => 2,
                    "is_active" => 1,
                    "is_parent" => 13,
                    "level" => 0
                ),
                array(
                    "id_menu" => 16,
                    "name" => "Trophy",
                    "link" => "profile_club/trophy",
                    "icon" => "fa fa-angle-right",
                    "order" => 3,
                    "is_active" => 1,
                    "is_parent" => 13,
                    "level" => 0
                ),
                array(
                    "id_menu" => 17,
                    "name" => "Tentang Kami",
                    "link" => "profile_club/aboutus",
                    "icon" => "fa fa-angle-right",
                    "order" => 4,
                    "is_active" => 1,
                    "is_parent" => 13,
                    "level" => 0
                ),
                array(
                    "id_menu" => 18,
                    "name" => "Galeri",
                    "link" => "media",
                    "icon" => "fa fa-angle-right",
                    "order" => 5,
                    "is_active" => 1,
                    "is_parent" => 13,
                    "level" => 0
                ),
            // setting
            array(
                "id_menu" => 19,
                "name" => "Setting",
                "link" => "#",
                "icon" => "fa fa-gear",
                "order" => 11,
                "is_active" => 1,
                "is_parent" => 0,
                "level" => 0
            ),
                array(
                    "id_menu" => 20,
                    "name" => "Administrator",
                    "link" => "administrator",
                    "icon" => "fa fa-angle-right",
                    "order" => 1,
                    "is_active" => 1,
                    "is_parent" => 19,
                    "level" => 0
                ),
                array(
                    "id_menu" => 21,
                    "name" => "Manajemen Menu",
                    "link" => "menu/admin",
                    "icon" => "fa fa-angle-right",
                    "order" => 2,
                    "is_active" => 1,
                    "is_parent" => 19,
                    "level" => 0
                ),
        );
        
        $this->db->insert_batch($this->tb, $data);
    }
    
    public function down () {
        
    }

}