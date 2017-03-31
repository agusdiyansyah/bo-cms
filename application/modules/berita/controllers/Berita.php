<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Berita extends Controller{
    
    private $module = "berita";
    private $stat   = false;
    private $valid  = false;

    public function __construct() {
        parent::__construct();
        
        $this->load->model("M_berita");
        $this->load->model("berita/M_kategori");
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
        
        $objKategori = $this->M_kategori->getData("id_kategori, kategori")->result();
        $kategori = array("" => "");
        foreach ($objKategori as $val) {
            $kategori += array($val->id_kategori => $val->kategori);
        }
        
        $data = array(
            "title" => ucwords($this->module),
            "subtitle" => "Tambah Data",
            "link_back" => site_url($this->module),
            
            "form_action" => base_url("$this->module/add_proses"),
            "input" => array(
                "id_hide" => array(
                    "name" => "id",
                    "class" => "id",
                    "type" => "hidden"
                ),
                
                "status" => array(
                    "config" => array(
                        "name" => "status",
                        "class" => "form-control select2 status",
                        "id" => "status",
                    ),
                    "list" => $this->M_berita->status()
                ),
                
                "kategori" => array(
                    "config" => array(
                        "name" => "kategori",
                        "class" => "form-control select2 kategori",
                        "id" => "kategori",
                    ),
                    "list" => $kategori
                ),

                "title" => array(
                    "name" => "title",
                    "type" => "text",
                    "class" => "form-control title",
                    "id" => "title"
                ),
                
                "sinopsis" => array(
                    "name" => "sinopsis",
                    "type" => "text",
                    "class" => "form-control sinopsis",
                    "id" => "sinopsis",
                    "rows" => "2"
                ),
                
                "content" => array(
                    "name" => "content",
                    "type" => "text",
                    "class" => "form-control content",
                    "id" => "content"
                ),
            )
        );
        
        $this->output->set_title($data['title'] . " " . $data['subtitle']);
		$this->load->view("$this->module/form", $data);
    }
    
    public function add_proses () {
        if ($this->input->post()) {

            $this->rules();

            if (!$this->form_validation->run()) {
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
                if (form_error("cpntent")) {
                    $errorMsg .= form_error("cpntent");
                }

                $notif = notification_proses("warning", "Gagal", $errorMsg);
                $this->session->set_flashdata('message', $notif);

                redirect("berita/add");
            } else {
                $title = $this->input->post('title');
                $sinopsis = $this->input->post('sinopsis');
                $content = $this->input->post('content');
                $kategori = $this->input->post('kategori');
                $status = $this->input->post('status');

                $data = array(
                    "title" => $title,
                    "sinopsis" => $sinopsis,
                    "content" => $content,
                    "id_kategori" => $kategori,
                    "status" => $status
                );

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
        $res = $this->M_berita->getData("id_berita, id_kategori, title, sinopsis, status, content", $id);
        
        if (
            $id > 0 AND
            $res->num_rows() > 0
        ) {
            $this->valid = true;
        }

        if ($this->valid) {
            
            $objKategori = $this->M_kategori->getData("id_kategori, kategori")->result();
            $kategori = array("" => "");
            foreach ($objKategori as $val) {
                $kategori += array($val->id_kategori => $val->kategori);
            }
            
            $val = $res->row();

            $data = array(
                "title" => ucwords($this->module),
                "subtitle" => "Ubah Data",
                "form_action" => base_url("$this->module/edit_proses"),
                "link_back" => site_url("berita"),
                "input" => array(
                    "id_hide" => array(
                        "name" => "id",
                        "class" => "id",
                        "type" => "hidden",
                        "value" => $val->id_berita
                    ),
                    
                    "status" => array(
                        "config" => array(
                            "name" => "status",
                            "class" => "form-control select2 status",
                            "id" => "status",
                        ),
                        "list" => $this->M_berita->status(),
                        "selected" => $val->status
                    ),
                    
                    "kategori" => array(
                        "config" => array(
                            "name" => "kategori",
                            "class" => "form-control select2 kategori",
                            "id" => "kategori",
                        ),
                        "list" => $kategori,
                        "selected" => $val->id_kategori
                    ),

                    "title" => array(
                        "name" => "title",
                        "type" => "text",
                        "class" => "form-control title",
                        "id" => "title",
                        "value" => $val->title
                    ),
                    
                    "sinopsis" => array(
                        "name" => "sinopsis",
                        "type" => "text",
                        "class" => "form-control sinopsis",
                        "id" => "sinopsis",
                        "rows" => "2",
                        "value" => $val->sinopsis
                    ),
                    
                    "content" => array(
                        "name" => "content",
                        "type" => "text",
                        "class" => "form-control content",
                        "id" => "content",
                        "value" => $val->content
                    ),
                )
            );
            
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
            
            $this->output->set_title($data['title'] . " " . $data['subtitle']);
            $this->load->view("$this->module/form", $data);
        }

    }
    
    public function edit_proses () {
        
        if (
            $this->input->post() AND
            !empty($this->input->post('id')) AND
            !empty($this->input->post('title')) AND
            !empty($this->input->post('sinopsis')) AND
            !empty($this->input->post('content')) AND
            !empty($this->input->post('kategori')) AND
            !empty($this->input->post('status'))
        ) {
            $this->valid = true;
        }

        if ($this->valid) {
            
            $this->rules();
            
            $id = $this->input->post('id');
            
            if (!$this->form_validation->run()) {
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
                if (form_error("cpntent")) {
                    $errorMsg .= form_error("cpntent");
                }

                $notif = notification_proses("warning", "Gagal", $errorMsg);
                $this->session->set_flashdata('message', $notif);

                redirect("$this->module/edit/$id");
            } else {
                $title = $this->input->post('title');
                $sinopsis = $this->input->post('sinopsis');
                $content = $this->input->post('content');
                $kategori = $this->input->post('kategori');
                $status = $this->input->post('status');

                $data = array(
                    "title" => $title,
                    "sinopsis" => $sinopsis,
                    "content" => $content,
                    "id_kategori" => $kategori,
                    "status" => $status
                );

                $edit = $this->M_berita->edit($data, $id);

                if ($edit) {
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
    
    public function delete_proses ($id) {
        if (
            $this->input->post() AND
            !empty($this->input->post('id')) AND
            $this->input->post('id') > 0
        ) {
            $this->valid = true;
        }
        
        if ($this->valid) {
            $id = $this->input->post('id');
            
            $del = $this->M_berita->delete($id);

            if ($del) {
                $this->stat = true;
            }
        }

        if ($this->stat) {
            $notif = notification_proses("success", "Sukses", "Data Berhasil di proses");
            $this->session->set_flashdata('message', $notif);
        } else {
            $notif = notification_proses("warning", "Gagal", "Data gagal di proses");
            $this->session->set_flashdata('message', $notif);
        }

    }
    
    protected function rules () {
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