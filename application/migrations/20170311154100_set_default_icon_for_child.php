<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_set_default_icon_for_child extends CI_Migration {
    
    protected $tb = "menu_admin";

    public function __construct() {
        parent::__construct();
    }

    public function up() {
        $upChildIcon = array(
            "icon" => "fa fa-angle-right",
        );
        
        $this->db
            ->where("icon", "")
            ->where("is_parent >", 0)
            ->update($this->tb, $upChildIcon);
    }
    
    public function down () {
        
    }

}