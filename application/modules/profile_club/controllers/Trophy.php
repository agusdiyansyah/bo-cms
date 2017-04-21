<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Trophy extends Controller{
    
    private $module = "profile_club";
    private $submodule = "trophy";
    private $moduleLink;
    private $stat   = false;
    private $valid  = false;
    private $ImageUploadPath = "./assets/upload/images/trophy/";

    public function __construct() {
        parent::__construct();
        
        $this->load->model("$this->module/M_$this->submodule");
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
        
        // datepicker
        $this->output->css('assets/themes/adminLTE/plugins/datepicker/datepicker3.css');
		$this->output->js('assets/themes/adminLTE/plugins/datepicker/bootstrap-datepicker.js');
        
        $data = array(
            "moduleLink" => $this->moduleLink,
            "title" => ucwords($this->submodule),
            "subtitle" => "Data",
            "link_add" => site_url("$this->module/$this->submodule/add"),
            "input" => array(
                "nama_trophy" => array(
                    "name" => "nama_trophy",
                    "type" => "text",
                    "class" => "form-control nama_trophy",
                    "id" => "nama_trophy"
                ),
                "tahun" => array(
                    "name" => "tahun",
                    "type" => "text",
                    "class" => "form-control tahun",
                    "id" => "tahun"
                ),
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
	    	echo $this->M_trophy->data($_POST);
    	}
    	return;
	}
    
    public function add () {
        $this->_formAssets();
        
        $data = array(
            "moduleLink'" => $this->moduleLink,
            "title" => ucwords($this->submodule),
            "subtitle" => "Tambah Data",
            "link_back" => site_url("$this->moduleLink"),
            
            "photo" => "",
            
            "form_action" => base_url("$this->moduleLink/add_proses"),
            "input" => array(
                "id_hide" => array(
                    "name" => "id",
                    "class" => "id",
                    "type" => "hidden"
                ),
                
                "galeri" => array(
                    "config" => array(
                        "name" => "galeri",
                        "class" => "form-control select2 galeri",
                        "id" => "galeri",
                    ),
                    "list" => $this->M_trophy->galeriArray()
                ),
                
                "nama_trophy" => array(
                    "name" => "nama_trophy",
                    "type" => "text",
                    "class" => "form-control nama_trophy",
                    "id" => "nama_trophy"
                ),
                
                "tahun" => array(
                    "name" => "tahun",
                    "type" => "text",
                    "class" => "form-control tahun",
                    "id" => "tahun"
                ),
                
                "keterangan" => array(
                    "name" => "keterangan",
                    "class" => "form-control keterangan",
                    "id" => "keterangan"
                ),
            )
        );
        
        $this->output->set_title($data['title'] . " " . $data['subtitle']);
		$this->load->view("$this->moduleLink/form", $data);
    }
    
    public function add_proses () {
        $this->output->unset_template();
        
        if ($this->input->post()) {

            $this->rules();

            if (!$this->form_validation->run()) {
                $errorMsg = "";
                
                $errorMsg = $this->_postProsesError();

                $notif = notification_proses("warning", "Gagal", $errorMsg);
                $this->session->set_flashdata('message', $notif);

                redirect("$this->moduleLink/add");
            } else {
                $nama_trophy = $this->input->post('nama_trophy');
                $tahun = $this->input->post('tahun');
                $keterangan = $this->input->post('keterangan');
                $galeri = $this->input->post('galeri');
                
                $photo = "";
                
                if (is_uploaded_file($_FILES['file']['tmp_name'])) {
                    $this->load->library('image');
                    $image = $this->image->upload(array(
                        "upload_path" => $this->ImageUploadPath,
                    ));
                    if ($image['stat']) {
                        $photo = $image['file_name'];
                    }
                }

                $data = array(
                    "nama_trophy" => $nama_trophy,
                    "tahun" => $tahun,
                    "keterangan" => $keterangan,
                    "id_galeri" => $galeri,
                    "photo" => $photo
                );

                $add = $this->M_trophy->add($data);

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
        
        redirect($this->moduleLink);
    }
    
    public function edit ($id = 0) {
        $res = $this->M_trophy->getData("id_galeri, nama_trophy, tahun, keterangan, photo", $id);
        
        if (
            $id > 0 AND
            $res->num_rows() > 0
        ) {
            $this->valid = true;
        }

        if ($this->valid) {
            
            $val = $res->row();
            
            $photo = (empty($val->photo)) ? "" : base_url("assets/upload/images/trophy/$val->photo");

            $data = array(
                "moduleLink'" => $this->moduleLink,
                "title" => ucwords($this->submodule),
                "subtitle" => "Ubah Data",
                "link_back" => site_url("$this->moduleLink"),
                
                "photo" => $photo,
                
                "form_action" => base_url("$this->moduleLink/edit_proses"),
                "input" => array(
                    "id_hide" => array(
                        "name" => "id",
                        "class" => "id",
                        "type" => "hidden",
                        "value" => $id,
                    ),
                    
                    "galeri" => array(
                        "config" => array(
                            "name" => "galeri",
                            "class" => "form-control select2 galeri",
                            "id" => "galeri",
                        ),
                        "list" => $this->M_trophy->galeriArray(),
                        "selected" => $val->id_galeri
                    ),
                    
                    "nama_trophy" => array(
                        "name" => "nama_trophy",
                        "type" => "text",
                        "class" => "form-control nama_trophy",
                        "id" => "nama_trophy",
                        "value" => $val->nama_trophy,
                    ),
                    
                    "tahun" => array(
                        "name" => "tahun",
                        "type" => "text",
                        "class" => "form-control tahun",
                        "id" => "tahun",
                        "value" => $val->tahun,
                    ),
                    
                    "keterangan" => array(
                        "name" => "keterangan",
                        "class" => "form-control keterangan",
                        "id" => "keterangan",
                        "value" => $val->keterangan,
                    ),
                )
            );
            
            $this->_formAssets();
            
            $this->output->set_title($data['title'] . " " . $data['subtitle']);
            $this->load->view("$this->moduleLink/form", $data);
        }

    }
    
    public function edit_proses () {
        
        $this->output->unset_template();
        
        if (
            $this->input->post() AND
            !empty($this->input->post('id')) AND
            !empty($this->input->post('nama_trophy')) AND
            !empty($this->input->post('tahun')) 
        ) {
            $this->valid = true;
        }

        if ($this->valid) {
            
            $this->rules();
            
            $id = $this->input->post('id');
            
            if (!$this->form_validation->run()) {
                $errorMsg = "";
                
                $errorMsg = $this->_postProsesError();

                $notif = notification_proses("warning", "Gagal", $errorMsg);
                $this->session->set_flashdata('message', $notif);

                redirect("$this->moduleLink/edit/$id");
            } else {
                $nama_trophy = $this->input->post('nama_trophy');
                $tahun = $this->input->post('tahun');
                $keterangan = $this->input->post('keterangan');
                $galeri = $this->input->post('galeri');
                
                $photo = "";
                
                $image = $this->M_trophy->getData("photo", $id)->row();
                if (is_uploaded_file($_FILES["file"]['tmp_name'])) {
                    $this->load->library('image');
                    $upload = $this->image->upload(array(
                        "upload_path" => $this->ImageUploadPath,
                        "update" => $image->photo,
                    ));
                    
                    if ($upload['stat']) {
                        $photo = $upload['file_name'];
                    }
                } elseif ($this->input->post('stat_removecover') == 1) {
                    unlink($this->ImageUploadPath . $image->photo);
                    unlink($this->ImageUploadPath . "thumb/" . $image->photo);
                }
                
                $data = array(
                    "nama_trophy" => $nama_trophy,
                    "tahun" => $tahun,
                    "keterangan" => $keterangan,
                    "id_galeri" => $galeri,
                    "photo" => $photo
                );

                $edit = $this->M_trophy->edit($data, $id);

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
        
        redirect($this->moduleLink);

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
            
            $del = $this->M_trophy->delete($id);

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
    
    private function _formAssets () {
        // validate
        $this->output->js('assets/themes/adminLTE/plugins/jquery-validation/jquery.validate.js');
		$this->output->js('assets/themes/adminLTE/plugins/jquery-validation/localization/messages_id.js');
        
        // ckeditor
        $this->output->js('assets/themes/adminLTE/plugins/ckeditor/ckeditor.js');
		$this->output->js('assets/themes/adminLTE/plugins/ckeditor/adapters/jquery.js');
        
        // datepicker
        $this->output->css('assets/themes/adminLTE/plugins/datepicker/datepicker3.css');
		$this->output->js('assets/themes/adminLTE/plugins/datepicker/bootstrap-datepicker.js');
        
        // fileinput
        $this->output->css("assets/themes/adminLTE/plugins/file-input/fileinput.min.css");
		$this->output->css("assets/themes/adminLTE/css/file-input-custom.css");
        $this->output->js("assets/themes/adminLTE/plugins/file-input/fileinput.min.js");
        
        // select2
        $this->output->css('assets/themes/adminLTE/plugins/select2/select2.min.css');
		$this->output->css('assets/themes/adminLTE/plugins/select2/select2-bootstrap.css');
		$this->output->js('assets/themes/adminLTE/plugins/select2/select2.min.js');
    }
    
    private function _postProsesError () {
        if (form_error("nama_trophy")) {
            $errorMsg .= form_error("nama_trophy");
        }
        if (form_error("tahun")) {
            $errorMsg .= form_error("tahun");
        }
        if (form_error("keterangan")) {
            $errorMsg .= form_error("keterangan");
        }
        
        return $errorMsg;
    }
    
    private function rules () {
        $this->load->library('form_validation');
        $this->load->helper('security');
        
        $config = array(
            array(
                "field" => "nama_trophy",
                "label" => "Nama trophy",
                "rules" => "required|xss_clean",
                "errors" => array(
                    "required" => "%s tidak boleh kosong"
                )
            ),
            array(
                "field" => "tahun",
                "label" => "Tahun",
                "rules" => "required|xss_clean|numeric",
                "errors" => array(
                    "required" => "%s tidak boleh kosong",
                    "numeric" => "%s harus berupa nomor %s"
                )
            )
        );
        
        $this->form_validation->set_error_delimiters("<div class='text-danger'>", "</div>");
        
        $this->form_validation->set_rules($config);
    }

}