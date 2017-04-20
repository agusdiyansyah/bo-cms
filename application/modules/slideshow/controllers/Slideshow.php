<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Slideshow extends Controller{
    
    private $stat = false;
    private $valid = false;
    private $msg = "Data gagal di proses";
    private $title = "Slideshow";
    private $moduleLink;
    private $ImageUploadPath = "./assets/upload/images/slideshow/";
    
    public function __construct() {
        parent::__construct();
        $this->moduleLink = base_url("slideshow");
        $this->load->model("M_slideshow");
    }

    public function index () {
        Modules::run('login/terlarang', 10);
        // easy autocomplete
        $this->output->css('assets/themes/adminLTE/plugins/easyautocomplete/easyautocomplete.css');
        $this->output->js('assets/themes/adminLTE/plugins/easyautocomplete/easyautocomplete.js');
        
        // datatables
        $this->output->css('assets/themes/adminLTE/plugins/datatables/dataTables.bootstrap.css');
        $this->output->js('assets/themes/adminLTE/plugins/datatables/jquery.dataTables.min.js');
        $this->output->js('assets/themes/adminLTE/plugins/datatables/dataTables.bootstrap.min.js');
        
        // magnific popup
        $this->output->css('assets/themes/adminLTE/plugins/magnific-popup/magnific-popup.css');
		$this->output->js('assets/themes/adminLTE/plugins/magnific-popup/magnific-popup.js');
        
        $data = array(
            "title" => $this->title,
            "subtitle" => "Data",
            "moduleLink" => $this->moduleLink,
            "link_add" => site_url("slideshow/add"),
            "input" => array(
                "title" => array(
                    "name" => "title",
                    "type" => "text",
                    "class" => "form-control title",
                    "id" => "title"
                )
            )
        );
        
		$this->load->view('data', $data);
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
	    	echo $this->M_slideshow->data($_POST);
    	}
    	return;
	}
    
    public function add () {
        $this->_formAssets();
        
        $data = $this->_formInputData(array(
            "subtitle" => "Tambah Data",
            "form_action" => "add_proses"
        ));
        
        $this->output->set_title($data['title'] . " " . $data['subtitle']);
		$this->load->view("slideshow/form", $data);
    }
    
    public function add_proses () {
        $this->output->unset_template();
        
        if ($this->input->post()) {
            $this->_rules();
            if (!$this->form_validation->run()) {
                $this->msg = $this->_formPostProsesError();
            } else {
                $cover = "";
                if (is_uploaded_file($_FILES['file']['tmp_name'])) {
                    $this->load->library('image');
                    $upload = $this->image->upload(array(
                        "upload_path" => $this->ImageUploadPath,
                        "thumbnail_path" => $this->ImageUploadPath,
                        "resize_width" => 1024,
                        "resize_height" => 768,
                        "crop" => false
                    ));
                    if ($upload['stat']) {
                        $cover = $upload['file_name'];
                    }
                    $data = $this->_formPostInputData($cover);
                    $this->load->model("page/M_page");
                    $proses = $this->M_page->add($data);

                    if ($proses) {
                        $this->stat = true;
                    }
                } else {
                    $this->msg = "Image tidak boleh kosong";
                }
            }
            if ($this->stat) {
                $notif = notification_proses("success", "Sukses", "Data Berhasil di proses");
                $this->session->set_flashdata('message', $notif);
                $directo = "slideshow";
            } else {
                $notif = notification_proses("warning", "Gagal", $this->msg);
                $this->session->set_flashdata('message', $notif);
                $directo = "slideshow/add";
            }
            
            redirect($directo);
        } else {
            show_404();
        }
        
    }
    
    public function edit ($id = 0) {
        if ($id > 0) {
            $val = $this->M_slideshow->getDataById($id)->row();
            $data = $this->_formInputData(array(
                "subtitle" => "Ubah Data",
                "form_action" => "edit_proses",
                
                "id" => $id,
                "content" => $val->content,
                "title" => $val->title,
                "cover" => $val->cover,
            ));
            
            $this->_formAssets();
            $this->output->set_title($data['title'] . " " . $data['subtitle']);
    		$this->load->view("slideshow/form", $data);
        } else {
            show_404();
        }
    }
    
    public function edit_proses () {
        $this->output->unset_template();
        if (
            $this->input->post() AND
            !empty($this->input->post('id')) AND
            $this->input->post('id') > 0
        ) {
            $this->_rules();
            if (!$this->form_validation->run()) {
                $this->msg = $this->_formPostProsesError();
            } else {
                $data = $this->M_slideshow->getDataById($this->input->post('id'))->row();
                $cover = @$data->cover;
                if (is_uploaded_file($_FILES['file']['tmp_name'])) {
                    $this->load->library('image');
                    $upload = $this->image->upload(array(
                        "update" => @$data->cover,
                        "upload_path" => $this->ImageUploadPath,
                        "thumbnail_path" => $this->ImageUploadPath,
                        "resize_width" => 1024,
                        "resize_height" => 768,
                        "crop" => false,
                    ));
                    if ($upload['stat']) {
                        $cover = $upload['file_name'];
                    }
                }
                
                $data = $this->_formPostInputData($cover);
                $this->load->model("page/M_page");
                $proses = $this->M_page->edit($data, $this->input->post('id'));

                if ($proses) {
                    $this->stat = true;
                }
            }
            if ($this->stat) {
                $notif = notification_proses("success", "Sukses", "Data Berhasil di proses");
                $this->session->set_flashdata('message', $notif);
                $directo = "slideshow";
            } else {
                $notif = notification_proses("warning", "Gagal", $this->msg);
                $this->session->set_flashdata('message', $notif);
                $directo = "slideshow/edit/" . $this->input->post('id');
            }
            
            redirect($directo);
        } else {
            show_404();
        }
    }
    
    public function delete_proses () {
        $this->output->unset_template();
        if (
            $this->input->post() AND
            !empty($this->input->post('id')) AND
            $this->input->post('id') > 0
        ) {
            $id = $this->input->post('id');
            $data = $this->M_slideshow->getDataById($id)->row();
            if (!empty($data->cover)) {
                if (file_exists($this->ImageUploadPath . $data->cover)) {
                    unlink($this->ImageUploadPath . $data->cover);
                }
            }
            $del = $this->M_slideshow->delete($id);
            if ($del) {
                $this->stat = true;
            }
            echo json_encode(array(
                "stat" => $this->stat
            ));
        } else {
            show_404();
        }
    }
    
    private function _formAssets () {
        // validate
        $this->output->js('assets/themes/adminLTE/plugins/jquery-validation/jquery.validate.js');
		$this->output->js('assets/themes/adminLTE/plugins/jquery-validation/localization/messages_id.js');
        
        // ckeditor
        $this->output->js('assets/themes/adminLTE/plugins/ckeditor/ckeditor.js');
		$this->output->js('assets/themes/adminLTE/plugins/ckeditor/adapters/jquery.js');
        
        // fileinput
        $this->output->css("assets/themes/adminLTE/plugins/file-input/fileinput.min.css");
		$this->output->css("assets/themes/adminLTE/css/file-input-custom.css");
        $this->output->js("assets/themes/adminLTE/plugins/file-input/fileinput.min.js");
    }
    
    private function _formInputData ($data) {
        $cover = "";
        if (!empty($data['cover'])) {
            $baseImage = str_ireplace(".", "", $this->ImageUploadPath);
            $cover = base_url($baseImage . "/" . $data['cover']);
        }
        return array(
            "title" => $this->title,
            "subtitle" => $data['subtitle'],
            "link_back" => site_url("slideshow"),
            "moduleLink" => $this->moduleLink,
            "form_action" => $this->moduleLink . "/" . $data['form_action'],
            
            "cover" => $cover,
            
            "input" => array(
                "hide" => array(
                    "id" => array(
                        "name" => "id",
                        "class" => "id",
                        "type" => "hidden",
                        "value" => @$data['id'],
                    )
                ),
                
                "title" => array(
                    "name" => "title",
                    "type" => "text",
                    "class" => "form-control title",
                    "id" => "title",
                    "value" => @$data['title']
                ),
                
                "content" => array(
                    "name" => "content",
                    "class" => "form-control content",
                    "id" => "content",
                    "value" => @$data['content']
                ),
                
            )
        );
    }
    
    private function _formPostInputData ($cover = "") {
        $this->load->library('slug');
        return array(
            "cover" => $cover,
            "content" => $this->input->post('content'),
            "status" => 1,
            "tipe" => "slideshow",
            "title" => $this->input->post('title'),
            "slug" => $this->slug->createSlugDB($this->input->post('title'), "page", "slug"),
        );
    }
    
    private function _formPostProsesError () {
        if (form_error("title")) {
            $errorMsg .= form_error("title");
        }
        
        return $errorMsg;
    }
    
    private function _rules () {
        $this->load->library('form_validation');
        
        $config = array(
            array(
                "field" => "title",
                "label" => "Title",
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