<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migrate extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (ENVIRONMENT != 'development') {
            show_404();
            die();
        }
        $this->load->library('migration');
    }
    
    public function index ($show_msg = 0) {
        if ($show_msg) {
            echo $this->_version();
        }
    }
    
    public function reload ($show_msg = 0) {
        $msg = "";
        if ($this->reset()) {
            $msg .= "Database berhasil di reset";
        } else {
            $msg .= "Gagal reset <br />";
            $msg .= $this->migration->error_string() . PHP_EOL;
        }
        $msg .= "<br />";
        if ($this->latest()) {
            $msg .= "Berhasil di perbaharui - " . $this->_version();
        } else {
            $msg .= "Gagal update database ke versi terbaru <br />";
            $msg .= $this->migration->error_string() . PHP_EOL;
        }
        
        if ($show_msg) {
            echo $msg;
        }
    }
    
    public function reset ($show_msg = 0) {
        $ret = false;
        
        $this->migration->version(0);
        $err = $this->migration->error_string();
        
        if ($err != '') {
            $msg = $this->migration->error_string() . PHP_EOL;
        } else {
            $msg = "Database berhasil direset";
            $ret = true;
        }
        
        if ($show_msg == 1) {
            echo $msg;
        } else {
            return $ret;
        }
    }
    
    public function set_version ($version = 0, $show_msg = 0) {
        if ($version == 0) {
            $msg = "Versi database tidak boleh kosong";
        } else {
            if ($this->migration->version($version)) {
                $msg = "Database berhasil direset ke versi $version";
            } else {
                $msg = $this->migration->error_string() . PHP_EOL;
            }
        }
        if ($show_msg) {
            echo $msg;
        }
    }
    
    public function latest ($show_msg = 0) {
        $ret = false;
        if ($this->migration->latest()) {
            $msg = "Success - " . $this->_version();
            $ret = true;
        } else {
            $msg = $this->migration->error_string() . PHP_EOL;
        }
        
        if ($show_msg) {
            echo $msg;
        } else {
            return $ret;
        }
    }
    
    protected function _version () {
        $row = $this->db->select('version')->get('migrations')->row();
        $version = $row ? $row->version : 0;
        if ($version > 0) {
            $datetime = strtotime($version);
            $version = date('Y-m-d H:i:s', $datetime);
        }
		return "Database migration version $version";
    }

}