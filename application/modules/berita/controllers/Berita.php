<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Berita extends Controller{
    
    private $module = "berita";
    private $stat   = false;
    private $valid  = false;
    
    private $ImageUploadPath = "./assets/upload/images/berita/";

    public function __construct() {
        parent::__construct();
        
        $this->load->model("M_berita");
    }

    public function index () {
		Modules::run('login/terlarang', 10);

		// datatables
        $this->output->css('assets/themes/adminLTE/plugins/datatables/dataTables.bootstrap.css');
        $this->output->js('assets/themes/adminLTE/plugins/datatables/jquery.dataTables.min.js');
        $this->output->js('assets/themes/adminLTE/plugins/datatables/dataTables.bootstrap.min.js');

        // select2
        $this->output->css('assets/themes/adminLTE/plugins/select2/select2.min.css');
		$this->output->css('assets/themes/adminLTE/plugins/select2/select2-bootstrap.css');
		$this->output->js('assets/themes/adminLTE/plugins/select2/select2.min.js');
        
        // magnific popup
        $this->output->css('assets/themes/adminLTE/plugins/magnific-popup/magnific-popup.css');
		$this->output->js('assets/themes/adminLTE/plugins/magnific-popup/magnific-popup.js');
        
        $data = array(
            "title" => ucwords($this->module),
            "subtitle" => "Data",
            "link_add" => site_url("$this->module/add"),
            "input" => array(
                "title" => array(
                    "name" => "title",
                    "type" => "text",
                    "class" => "form-control title",
                    "id" => "title"
                ),
                "status" => array(
                    "config" => array(
                        "name" => "status",
                        "class" => "form-control select2 status",
                        "id" => "status",
                    ),
                    "list" => $this->M_berita->status()
                )
            )
        );
        
        $this->output->set_title($data['title'] . " " . $data['subtitle']);
        
		$this->load->view("$this->module/data", $data);
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
	    	echo $this->M_berita->data($_POST);
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
		$this->load->view("$this->module/form", $data);
    }
    
    public function add_proses () {
        $this->output->unset_template();
        if ($this->input->post()) {

            $this->_rules();

            if (!$this->form_validation->run()) {
                $errorMsg = $this->_formPostProsesError();
                $notif = notification_proses("warning", "Gagal", $errorMsg);
                $this->session->set_flashdata('message', $notif);
                redirect("berita/add");
            } else {
                $cover = "";
                if (is_uploaded_file($_FILES['file']['tmp_name'])) {
                    $this->load->library('image');
                    $upload = $this->image->upload(array(
                        "upload_path" => $this->ImageUploadPath,
                    ));
                    if ($upload['stat']) {
                        $cover = $upload['file_name'];
                    }
                }
                
                $data = $this->_formPostInputData($cover);

                $add = $this->M_berita->add($data);

                if ($add) {
                    $this->stat = true;
                }
            }
        }

        if ($this->stat) {
            $notif = notification_proses("success", "Sukses", "Data Berhasil di proses");
            $this->session->set_flashdata('message', $notif);
        } else {
            $notif = notification_proses("warning", "Gagal", "Data gagal di proses");
            $this->session->set_flashdata('message', $notif);
        }
        
        redirect($this->module);
    }
    
    public function edit ($id = 0) {
        $res = $this->M_berita->getData("id_berita, id_kategori, title, sinopsis, status, content, cover", $id);
        if (
            $id > 0 AND
            $res->num_rows() > 0
        ) {
            $this->valid = true;
        }

        if ($this->valid) {
            
            $val = $res->row();
            $base_image = str_replace(".", "", $this->ImageUploadPath);
            $cover = (empty($val->cover)) ? "" : base_url($base_image . $val->cover);

            $data = $this->_formInputData(array(
                "subtitle" => "Ubah Data",
                "form_action" => "edit_proses",
                "id" => $id,
                "cover" => $cover,
                "status" => $val->status,
                "kategori" => $val->id_kategori,
                "title" => $val->title,
                "sinopsis" => $val->sinopsis,
                "content" => $val->content,
            ));
            
            $this->_formAssets();
            
            $this->output->set_title($data['title'] . " " . $data['subtitle']);
            $this->load->view("$this->module/form", $data);
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
            $id = $this->input->post('id');
            
            if (!$this->form_validation->run()) {
                $errorMsg = $this->_formPostProsesError();
                $notif = notification_proses("warning", "Gagal", $errorMsg);
                $this->session->set_flashdata('message', $notif);
                redirect("$this->module/edit/$id");
            } else {
                $image = $this->M_berita->getData("cover")->row();
                $cover = @$image->cover;
                if (is_uploaded_file($_FILES['file']['tmp_name'])) {
                    $this->load->library('image');
                    $upload = $this->image->upload(array(
                        "upload_path" => $this->ImageUploadPath,
                        "update" => @$image->cover
                    ));
                    if ($upload['stat']) {
                        $cover = $upload['file_name'];
                    }
                } elseif ($this->input->post('stat_removecover') == 1) {
                    unlink($this->ImageUploadPath . $image->cover);
                    unlink($this->ImageUploadPath . "thumb/" . $image->cover);
                }
                $data = $this->_formPostInputData($cover);
                $edit = $this->M_berita->edit($data, $id);
                if ($edit) {
                    $this->stat = true;
                }
                
                if ($this->stat) {
                    $notif = notification_proses("success", "Sukses", "Data Berhasil di proses");
                    $this->session->set_flashdata('message', $notif);
                } else {
                    $notif = notification_proses("warning", "Gagal", "Data gagal di proses");
                    $this->session->set_flashdata('message', $notif);
                }
                redirect($this->module);
            }
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
            $data = $this->M_berita->getData("cover", $id)->row();
            if (!empty($data->cover)) {
                if (file_exists($this->ImageUploadPath . $data->cover)) {
                    unlink($this->ImageUploadPath . $data->cover);
                    if (file_exists($this->ImageUploadPath . "thumb/" . $data->cover)) {
                        unlink($this->ImageUploadPath . "thumb/" . $data->cover);
                    }
                }
            }
            $del = $this->M_berita->delete($id);
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
        
        // select2
        $this->output->css('assets/themes/adminLTE/plugins/select2/select2.min.css');
		$this->output->css('assets/themes/adminLTE/plugins/select2/select2-bootstrap.css');
		$this->output->js('assets/themes/adminLTE/plugins/select2/select2.min.js');
        
        // ckeditor
        $this->output->js('assets/themes/adminLTE/plugins/ckeditor/ckeditor.js');
		$this->output->js('assets/themes/adminLTE/plugins/ckeditor/adapters/jquery.js');
        
        // fileinput
        $this->output->css("assets/themes/adminLTE/plugins/file-input/fileinput.min.css");
		$this->output->css("assets/themes/adminLTE/css/file-input-custom.css");
        $this->output->js("assets/themes/adminLTE/plugins/file-input/fileinput.min.js");
    }
    
    private function _formInputData ($data) {
        return array(
            "title" => ucwords($this->module),
            "subtitle" => @$data['subtitle'],
            "link_back" => site_url($this->module),
            "moduleLink" => base_url($this->module),
            "ImageUploadPath" => $this->ImageUploadPath,
            "form_action" => base_url($this->module . "/" . $data['form_action']),
            
            "cover" => @$data['cover'],
            
            "input" => array(
                "id_hide" => array(
                    "name" => "id",
                    "class" => "id",
                    "type" => "hidden",
                    "value" => @$data['id']
                ),
                
                "status" => array(
                    "config" => array(
                        "name" => "status",
                        "class" => "form-control select2 status",
                        "id" => "status",
                    ),
                    "list" => $this->M_berita->status(),
                    "selected" => @$data['status']
                ),
                
                "kategori" => array(
                    "config" => array(
                        "name" => "kategori",
                        "class" => "form-control select2 kategori",
                        "id" => "kategori",
                    ),
                    "list" => $this->M_berita->kategori(),
                    "selected" => @$data['kategori']
                ),

                "title" => array(
                    "name" => "title",
                    "type" => "text",
                    "class" => "form-control title",
                    "id" => "title",
                    "value" => @$data['title']
                ),
                
                "sinopsis" => array(
                    "name" => "sinopsis",
                    "type" => "text",
                    "class" => "form-control sinopsis",
                    "id" => "sinopsis",
                    "style" => "margin: 0px -0.25px 0px 0px; height: 60px; max-width: 100%;",
                    "value" => @$data['sinopsis']
                ),
                
                "content" => array(
                    "name" => "content",
                    "type" => "text",
                    "class" => "form-control content",
                    "id" => "content",
                    "value" => @$data['content']
                ),
            )
        );
    }
    
    private function _formPostInputData ($cover = "") {
        return array(
            "title" => $this->input->post('title'),
            "sinopsis" => $this->input->post('sinopsis'),
            "content" => $this->input->post('content'),
            "id_kategori" => $this->input->post('kategori'),
            "status" => $this->input->post('status'),
            "cover" => $cover,
        );
    }
    
    private function _formPostProsesError () {
        $errorMsg = "";
        if (form_error("kategori")) {
            $errorMsg .= form_error("kategori");
        }
        if (form_error("title")) {
            $errorMsg .= form_error("title");
        }
        if (form_error("sinopsis")) {
            $errorMsg .= form_error("sinopsis");
        }
        if (form_error("content")) {
            $errorMsg .= form_error("content");
        }
        return $errorMsg;
    }
    
    private function _rules () {
        $this->load->library('form_validation');
        $this->load->helper('security');
        
        $config = array(
            array(
                "field" => "title",
                "label" => "Title berita",
                "rules" => "required|xss_clean",
                "errors" => array(
                    "required" => "%s tidak boleh kosong"
                )
            ),
            array(
                "field" => "sinopsis",
                "label" => "Sinopsis",
                "rules" => "required|xss_clean",
                "errors" => array(
                    "required" => "%s tidak boleh kosong"
                )
            ),
            array(
                "field" => "content",
                "label" => "Content",
                "rules" => "required",
                "errors" => array(
                    "required" => "%s tidak boleh kosong"
                )
            ),
            array(
                "field" => "kategori",
                "label" => "Kategori",
                "rules" => "required|xss_clean",
                "errors" => array(
                    "required" => "%s tidak boleh kosong"
                )
            ),
            array(
                "field" => "status",
                "label" => "Status",
                "rules" => "required|xss_clean",
                "errors" => array(
                    "required" => "%s tidak boleh kosong"
                )
            ),
        );
        
        $this->form_validation->set_error_delimiters("<div class='text-danger'>", "</div>");
        
        $this->form_validation->set_rules($config);
    }

}