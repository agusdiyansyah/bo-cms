<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Hasil extends Controller{
    
    private $module = "pertandingan";
    private $submodule = "hasil";
    private $moduleLink;
    private $stat   = false;
    private $valid  = false;

    public function __construct() {
        parent::__construct();
        
        $this->load->model("$this->module/M_hasil");
        $this->moduleLink = "$this->module/$this->submodule";
    }

    public function index () {
		Modules::run('login/terlarang', 10);

		// datatables
        $this->output->css('assets/themes/adminLTE/plugins/datatables/dataTables.bootstrap.css');
        $this->output->js('assets/themes/adminLTE/plugins/datatables/jquery.dataTables.min.js');
        $this->output->js('assets/themes/adminLTE/plugins/datatables/dataTables.bootstrap.min.js');
        
        // magnific popup
        $this->output->css('assets/themes/adminLTE/plugins/magnific-popup/magnific-popup.css');
		$this->output->js('assets/themes/adminLTE/plugins/magnific-popup/magnific-popup.js');
        
        $data = array(
            "moduleLink" => $this->moduleLink,
            "title" => ucwords($this->submodule),
            "subtitle" => "Data",
            "link_add" => site_url("pertandingan/jadwal/add"),
            "link_hapus" => base_url("pertandingan/jadwal/delete_proses"),
            "link_skor" => base_url("pertandingan/jadwal/selesai"),
            "input" => array(
                "match_rival" => array(
                    "name" => "match_rival",
                    "type" => "text",
                    "class" => "form-control match_rival",
                    "id" => "match_rival"
                )
            )
        );
        
        $this->output->set_title($data['title'] . " " . $data['subtitle']);
        
		$this->load->view("$this->moduleLink/data", $data);
	}
    
    public function data () {
		$this->output->unset_template();
		header("Content-type: application/json");
    	if(
    		isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
    		!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
    		strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'
    		)
    	{
	    	echo $this->M_hasil->data($_POST);
    	}
    	return;
	}

}