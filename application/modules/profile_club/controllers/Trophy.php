<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Trophy extends Controller{
    
    private $module = "profile_club";
    private $submodule = "trophy";
    private $moduleLink;
    private $stat   = false;
    private $valid  = false;
    private $ImageUploadPath = "./assets/upload/images/trophy/";
    private $msg = "Data gagal di proses";

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
        
        $data = $this->_formInputData(array(
            "subtitle" => "Tambah Data",
            "form_action" => "add_proses"
        ));
        
        $this->output->set_title($data['title'] . " " . $data['subtitle']);
		$this->load->view("$this->moduleLink/form", $data);
    }
    
    public function add_proses () {
        $this->output->unset_template();
        
        if ($this->input->post()) {

            $this->_rules();

            if (!$this->form_validation->run()) {
                $this->msg = $this->_formPostProsesError();
            } else {
                
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

                $data = $this->_formPostInputData($photo);

                $add = $this->M_trophy->add($data);

                if ($add) {
                    $this->stat = true;
                }
            }
            if ($this->stat) {
                $notif = notification_proses("success", "Sukses", "Data Berhasil di proses");
                $this->session->set_flashdata('message', $notif);
                $_backto = "$this->moduleLink";
            } else {
                $notif = notification_proses("warning", "Gagal", $this->msg);
                $this->session->set_flashdata('message', $notif);
                $_backto = "$this->moduleLink/add";
            }
            
            redirect($this->moduleLink);
        } else {
            show_404();
        }
    }
    
    public function edit ($id = 0) {
        $res = $this->M_trophy->getData("id_galeri, nama_trophy, tahun, keterangan, photo", $id);
        
        if (
            $id > 0 AND
            $res->num_rows() > 0
        ) {
            $val = $res->row();

            $data = $this->_formInputData(array(
                "subtitle" => "Ubah Data",
                "form_action" => "edit_proses",
                "id" => $id,
                "photo" => $val->photo,
                "galeri" => $val->id_galeri,
                "nama_trophy" => $val->nama_trophy,
                "tahun" => $val->tahun,
                "keterangan" => $val->keterangan,
            ));
            
            $this->_formAssets();
            
            $this->output->set_title($data['title'] . " " . $data['subtitle']);
            $this->load->view("$this->moduleLink/form", $data);
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
            $id = $this->input->post('id');
            $this->_rules();
            
            if (!$this->form_validation->run()) {
                $this->msg = $this->_formPostProsesError();
            } else {
                
                $image = $this->M_trophy->getData("photo", $id)->row();
                $photo = @$image->photo;
                
                if (is_uploaded_file($_FILES["file"]['tmp_name']) AND $this->input->post('stat_removecover') == 0) {
                    $this->load->library('image');
                    $upload = $this->image->upload(array(
                        "upload_path" => $this->ImageUploadPath,
                        "update" => @$image->photo,
                    ));
                    
                    if ($upload['stat']) {
                        $photo = $upload['file_name'];
                    }
                } elseif ($this->input->post('stat_removecover') > 0) {
                    unlink($this->ImageUploadPath . $image->photo);
                    unlink($this->ImageUploadPath . "thumb/" . $image->photo);
                    $photo = "";
                }
                
                $data = $this->_formPostInputData($photo);

                $edit = $this->M_trophy->edit($data, $id);

                if ($edit) {
                    $this->stat = true;
                }
            }
            if ($this->stat) {
                $notif = notification_proses("success", "Sukses", "Data Berhasil di proses");
                $this->session->set_flashdata('message', $notif);
                $_backto = "$this->moduleLink";
            } else {
                $notif = notification_proses("warning", "Gagal", $this->msg);
                $this->session->set_flashdata('message', $notif);
                $_backto = "$this->moduleLink/edit/$id";
            }
            
            redirect($_backto);
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
            
            $sql = $this->M_trophy->getData("photo", $id)->row();
            if (!empty($sql->photo)) {
                unlink($this->ImageUploadPath . $sql->photo);
                unlink($this->ImageUploadPath . "thumb/" . $sql->photo);
            }
            
            $del = $this->M_trophy->delete($id);
            
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
    
    private function _formInputData ($data) {
        $photo = "";
        if (!empty($data['photo'])) {
            $baseImage = str_replace(".", "", $this->ImageUploadPath);
            $photo = base_url($baseImage . $data['photo']);
        }
        return array(
            "title" => ucwords($this->submodule),
            "subtitle" => @$data['subtitle'],
            "link_back" => site_url("$this->moduleLink"),
            "moduleLink'" => $this->moduleLink,
            "form_action" => base_url($this->moduleLink . "/" . $data['form_action']),
            
            "photo" => $photo,
            
            "input" => array(
                "hide" => array(
                    "id" => array(
                        "name" => "id",
                        "class" => "id",
                        "type" => "hidden",
                        "value" => @$data['id']
                    )
                ),
                
                "galeri" => array(
                    "config" => array(
                        "name" => "galeri",
                        "class" => "form-control select2 galeri",
                        "id" => "galeri",
                    ),
                    "list" => $this->M_trophy->galeriArray(),
                    "selected" => @$data['galeri']
                ),
                
                "nama_trophy" => array(
                    "name" => "nama_trophy",
                    "type" => "text",
                    "class" => "form-control nama_trophy",
                    "id" => "nama_trophy",
                    "value" => @$data['nama_trophy']
                ),
                
                "tahun" => array(
                    "name" => "tahun",
                    "type" => "text",
                    "class" => "form-control tahun",
                    "id" => "tahun",
                    "value" => @$data['tahun']
                ),
                
                "keterangan" => array(
                    "name" => "keterangan",
                    "class" => "form-control keterangan",
                    "id" => "keterangan",
                    "value" => @$data['keterangan']
                ),
            )
        );
    }
    
    private function _formPostInputData ($photo) {
        return array(
            "nama_trophy" => $this->input->post('nama_trophy'),
            "tahun" => $this->input->post('tahun'),
            "keterangan" => $this->input->post('keterangan'),
            "id_galeri" => $this->input->post('galeri'),
            "photo" => $photo
        );
    }
    
    private function _formPostProsesError () {
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
    
    private function _rules () {
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