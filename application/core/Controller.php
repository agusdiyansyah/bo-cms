<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Controller extends MX_Controller {
    
    protected $template = "adminLTE/default";

    public function __construct() {
        parent::__construct();
        
        Modules::run('login/cek_login');
        
        // migrate
		if (MIGRATE) {
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, base_url("migrate/latest"));
			$response = curl_exec($ch);
			curl_close($ch);
		}
        
        $this->output->set_template($this->template);
    }
    
    public function set_template ($url = "") {
        $url = (empty($url)) ? $this->template : $url;
        
        $this->output->set_template($url);
    }

}