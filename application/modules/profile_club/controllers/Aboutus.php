<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Aboutus extends Controller{
    
    private $module = "profile_club";
    private $submodule = "aboutus";
    private $moduleLink;
    private $stat   = false;
    private $valid  = false;
    private $msg = "Data gagal di proses";
    private $ImageUploadPath = "./assets/upload/images/page/";

    public function __construct() {
        parent::__construct();
        
        $this->load->model("page/M_page");
        $this->moduleLink = "$this->module/$this->submodule";
    }

    public function index () {
		Modules::run('login/terlarang', 10);
        
        $this->db->where("tipe", "aboutus");
        $data = $this->M_page->getData("cover, content")->row();
        
        $cover = (empty($data->cover)) ? "" : base_url($this->ImageUploadPath) . "/" . $data->cover;
        
        $data = $this->_formData(array(
            "subtitle" => "",
            "form_action" => "$this->moduleLink/prosesSpecialPage",
            "cover" => $cover,
            "content" => @$data->content,
        ));
        
        $this->_formAssets();
        
        $this->output->set_title($data['title'] . " " . $data['subtitle']);
        
		$this->load->view("$this->moduleLink/form", $data);
	}
    
    public function prosesSpecialPage () {
        $this->output->unset_template();
        
        if ($this->input->post()) {

            $this->_rules();

            if (!$this->form_validation->run()) {
                $errorMsg = "";
                
                $this->msg = $this->_postProsesError();
            } else {
                $this->db->where("tipe", "aboutus");
                $val = $this->M_page->getData("cover")->row();
                $cover = @$val->cover;
                
                if (is_uploaded_file($_FILES['file']['tmp_name']) AND $this->input->post('stat_removecover') == 0) {
                    $this->load->library('image');
                    $upload = $this->image->upload(array(
                        "upload_path" => $this->ImageUploadPath,
                        "update" => @$val->cover
                    ));
                    if ($upload['stat']) {
                        $cover = $upload['file_name'];
                    }
                } elseif ($this->input->post('stat_removecover') > 0 AND !empty($val->cover)) {
                    unlink($this->ImageUploadPath . $val->cover);
                    unlink($this->ImageUploadPath . "thumb/" . $val->cover);
                    $cover = "";
                }
                
                $data = $this->_postData($cover);

                $proses = $this->M_page->prosesSpecialPage($data, "aboutus");

                if ($proses) {
                    $this->stat = true;
                }
            }
        }

        if ($this->stat) {
            $notif = notification_proses("success", "Sukses", "Data Berhasil di proses");
            $this->session->set_flashdata('message', $notif);
        } else {
            $notif = notification_proses("warning", "Gagal", $this->msg);
            $this->session->set_flashdata('message', $notif);
        }
        
        redirect($this->moduleLink);
    }
    
    private function _formAssets () {
        // ckeditor
        $this->output->js('assets/themes/adminLTE/plugins/ckeditor/ckeditor.js');
		$this->output->js('assets/themes/adminLTE/plugins/ckeditor/adapters/jquery.js');
        
        // fileinput
        $this->output->css("assets/themes/adminLTE/plugins/file-input/fileinput.min.css");
		$this->output->css("assets/themes/adminLTE/css/file-input-custom.css");
        $this->output->js("assets/themes/adminLTE/plugins/file-input/fileinput.min.js");
        
        // validate
        $this->output->js('assets/themes/adminLTE/plugins/jquery-validation/jquery.validate.js');
		$this->output->js('assets/themes/adminLTE/plugins/jquery-validation/localization/messages_id.js');
    }
    
    private function _formData ($data = array()) {
        return array(
            "title" => ucwords($this->submodule),
            "subtitle" => $data['subtitle'],
            "moduleLink" => $this->moduleLink,
            "link_back" => site_url($this->moduleLink),
            "form_action" => base_url($data['form_action']),
            
            "cover" => @$data['cover'],
            
            "input" => array(
                "content" => array(
                    "name" => "content",
                    "class" => "form-control content",
                    "id" => "content",
                    "value" => @$data['content']
                ),
            )
        );
    }
    
    private function _postData ($cover = "") {
        $content = $this->input->post('content');

        return array(
            "content" => $content,
            "cover" => $cover,
            "status" => 1,
            "tipe" => "aboutus",
            "title" => "Tentang Kami",
            "slug" => "tentang-kami",
        );
    }
    
    private function _postProsesError () {
        if (form_error("content")) {
            $errorMsg .= form_error("content");
        }
        
        return $errorMsg;
    }
    
    private function _rules () {
        $this->load->library('form_validation');
        
        $config = array(
            array(
                "field" => "content",
                "label" => "Konten",
                "rules" => "required",
                "errors" => array(
                    "required" => "%s tidak boleh kosong"
                )
            )
        );
        
        $this->form_validation->set_error_delimiters("<div class='text-danger'>", "</div>");
        
        $this->form_validation->set_rules($config);
    }

}