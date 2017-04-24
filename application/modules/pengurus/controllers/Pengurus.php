<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengurus extends Controller{
    
    private $module = "pengurus";
    private $submodule = "";
    private $moduleLink;
    private $stat   = false;
    private $valid  = false;
    private $ImageUploadPath = "./assets/upload/images/pengurus/";
    private $msg = "Data gagal di proses";

    public function __construct() {
        parent::__construct();
        
        $this->load->model("M_pengurus");
        $this->load->model("M_jabatan");
        $this->load->model("socmed/M_socmed");
        
        $this->moduleLink = $this->module;
    }

    public function index () {
		Modules::run('login/terlarang', 10);
        
        $this->output->css('assets/themes/adminLTE/css/pengurus.css');
        
        // magnific popup
        $this->output->css('assets/themes/adminLTE/plugins/magnific-popup/magnific-popup.css');
		$this->output->js('assets/themes/adminLTE/plugins/magnific-popup/magnific-popup.js');
        
        $data = array(
            "title" => ucwords($this->module),
            "subtitle" => "Data",
            "moduleLink" => $this->moduleLink,
            "ImageUploadPath" => $this->ImageUploadPath,
            "link_add" => site_url("$this->module/add"),
            "hc" => $this->_getHC(),
            "staf" => $this->_getStaf()
        );
        
        $this->output->set_title(ucwords($data['title']) . " " . $data['subtitle']);
        
		$this->load->view("pengurus/pengurus/data", $data);
	}
    
    public function add () {
        $this->_formAssets();
        
        $data = $this->_formInputData(array(
            "subtitle" => "Tambah Data Staf",
            "form_action" => "add_proses",
            "jenis_jabatan" => "staf"
        ));
        
        $this->output->set_title($data['title'] . " " . $data['subtitle']);
		$this->load->view("pengurus/pengurus/form", $data);
    }
    
    public function add_proses () {
        $this->output->unset_template();
        if (
            $this->input->post()
        ) {
            $this->_rules();

            if (!$this->form_validation->run()) {
                $this->msg = $this->_formPostProsesError();
            } else {
                
                $photo = "";
                if (is_uploaded_file($_FILES['file']['tmp_name'])) {
                    $this->load->library('image');
                    $upload = $this->image->upload(array(
                        "upload_path" => $this->ImageUploadPath
                    ));
                    if ($upload['stat']) {
                        $photo = $upload['file_name'];
                    }
                }

                $data = $this->_formPostInputData($photo);
                $proses = $this->M_pengurus->add($data['pengurus'], $data['socmed']);

                if ($proses) {
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
            
            redirect($_backto);
        } else {
            show_404();
        }
    }
    
    public function edit ($id = 0) {
        $res = $this->M_pengurus->getData("*", $id);
        if (
            $id > 0 AND
            $res->num_rows() > 0
        ) {
            $this->_formAssets();
            $data = $res->row();
            
            $socmed = $this->M_pengurus->getStafDataSocmedArray($id);
            
            $data = $this->_formInputData(array(
                "subtitle" => "Ubah Data Staf",
                "form_action" => "edit_proses",
                "jenis_jabatan" => "staf",
                "id" => $id,
                "nama" => $data->nama,
                "photo" => $data->photo,
                "jabatan" => $data->id_jabatan,
                "kota_kelahiran" => $data->kota_kelahiran,
                "tanggal_lahir" => $data->tanggal_lahir,
                "biografi" => $data->biografi,
                "facebook" => @$socmed["2"],
                "twitter" => @$socmed["1"],
                "instagram" => @$socmed["3"],
                "google_plus" => @$socmed["4"],
                "bloglovin" => @$socmed["5"],
                "pinterest" => @$socmed["6"],
                "youtube" => @$socmed["7"],
                "tumblr" => @$socmed["8"]
            ));
            
            $this->load->view("pengurus/pengurus/form", $data);
        }
    }
    
    public function edit_proses () {
        $this->output->unset_template();
        if (
            $this->input->post() AND
            !empty($this->input->post('id')) AND
            $this->input->post('id') > 0
        ) {
            $this->_rules("edit");
            $id = $this->input->post('id');
            
            if (!$this->form_validation->run()) {
                $this->msg = $this->_formPostProsesError();
            } else {
                $pengurus = $this->M_pengurus->getData("photo", $id)->row();
                $photo = @$pengurus->photo;
                
                if (is_uploaded_file($_FILES['file']['tmp_name'])) {
                    $this->load->library('image');
                    $upload = $this->image->upload(array(
                        "upload_path" => $this->ImageUploadPath,
                        "update" => @$pengurus->photo
                    ));
                    if ($upload['stat']) {
                        $photo = $upload['file_name'];
                    }
                    
                }
                
                $data = $this->_formPostInputData($photo);
                $proses = $this->M_pengurus->edit($id, $data['pengurus'], $data['socmed']);

                if ($proses['stat']) {
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
            $del = $this->M_pengurus->delete($id);

            if ($del['stat']) {
                $this->stat = true;
                if (!empty($del['photo'])) {
                    unlink($this->ImageUploadPath . $del['photo']);
                    unlink($this->ImageUploadPath . "thumb/" . $del['photo']);
                }
            }
            
            echo json_encode(array(
                "stat" => $this->stat
            ));
        } else {
            show_404();
        }
    }
    
    public function head_coach () {
        $this->_formAssets();
        
        $data = $this->M_pengurus->getData("*", "hc")->row();
        $socmed = $this->M_pengurus->getHCDataSocmedArray();
        
        $data = $this->_formInputData(array(
            "subtitle" => "Ubah Data Staf",
            "form_action" => "hc_proses",
            "id" => "",
            "nama" => @$data->nama,
            "photo" => @$data->photo,
            "jabatan" => @$data->id_jabatan,
            "kota_kelahiran" => @$data->kota_kelahiran,
            "tanggal_lahir" => @$data->tanggal_lahir,
            "biografi" => @$data->biografi,
            "facebook" => @$socmed["2"],
            "twitter" => @$socmed["1"],
            "instagram" => @$socmed["3"],
            "google_plus" => @$socmed["4"],
            "bloglovin" => @$socmed["5"],
            "pinterest" => @$socmed["6"],
            "youtube" => @$socmed["7"],
            "tumblr" => @$socmed["8"]
        ));
        
        $this->load->view("pengurus/pengurus/form", $data);
    }
    
    public function hc_proses () {
        $this->output->unset_template();
        
        if (
            $this->input->post()
        ) {
            $pengurus = $this->M_pengurus->getData("photo", "hc")->row();
            $tipe = (empty($pengurus->photo)) ? "add" : "edit";
            $this->_rules($tipe);
            
            if (!$this->form_validation->run()) {
                $this->msg = $this->_formPostProsesError();
            } else {
                
                $photo = @$pengurus->photo;
                if (is_uploaded_file($_FILES['file']['tmp_name'])) {
                    $this->load->library('image');
                    $upload = $this->image->upload(array(
                        "upload_path" => $this->ImageUploadPath,
                        "update" => @$pengurus->photo
                    ));
                    if ($upload['stat']) {
                        $photo = $upload['file_name'];
                    }
                }

                $data = $this->_formPostInputData($photo);
                $proses = $this->M_pengurus->hc_proses($data['pengurus'], $data['socmed']);

                if ($proses['stat']) {
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
                $_backto = "$this->moduleLink/head_coach";
            }
            
            redirect($_backto);
        } else {
            show_404();
        }

    }
    
    private function _getHC () {
        $res = $this->M_pengurus->getData("nama, photo", "hc");
        $nama = "The Secret Name";
        $photo = "assets/themes/adminLTE/img/boxed-bg.png";
        if ($res->num_rows() > 0) {
            $data = $res->row();
            $nama = $data->nama;
            if (!empty($data->photo)) {
                $photo = "{$this->ImageUploadPath}thumb/$data->photo";
            }
        }
        
        return array(
            "nama" => $nama,
            "photo" => $photo
        );
    }
    
    private function _getStaf () {
        return $this->M_pengurus->getStaf();
    }
    
    private function _formAssets () {
        // validate
        $this->output->js('assets/themes/adminLTE/plugins/jquery-validation/jquery.validate.js');
		$this->output->js('assets/themes/adminLTE/plugins/jquery-validation/localization/messages_id.js');
        
        // fileinput
        $this->output->css("assets/themes/adminLTE/plugins/file-input/fileinput.min.css");
		$this->output->css("assets/themes/adminLTE/css/file-input-custom.css");
        $this->output->js("assets/themes/adminLTE/plugins/file-input/fileinput.min.js");
        
        // ckeditor
        $this->output->js('assets/themes/adminLTE/plugins/ckeditor/ckeditor.js');
		$this->output->js('assets/themes/adminLTE/plugins/ckeditor/adapters/jquery.js');
        
        // select2
        $this->output->css('assets/themes/adminLTE/plugins/select2/select2.min.css');
		$this->output->css('assets/themes/adminLTE/plugins/select2/select2-bootstrap.css');
		$this->output->js('assets/themes/adminLTE/plugins/select2/select2.min.js');
        
        // material datetime picker
        $this->output->css('assets/themes/adminLTE/plugins/bootstrap-materialdatetimepicker/css/bootstrap-material-datetimepicker.css');
        $this->output->css('assets/themes/adminLTE/css/bootstrap-materialdatetimepicker-skin.css');
        $this->output->css('https://fonts.googleapis.com/icon?family=Material+Icons');
        $this->output->js('assets/themes/adminLTE/plugins/moment/moment.js');
        $this->output->js('assets/themes/adminLTE/plugins/bootstrap-materialdatetimepicker/js/bootstrap-material-datetimepicker.js');
    }
    
    private function _formInputData ($data) {
        $photo = $tanggal_lahir = "";
        if (!empty($data['photo'])) {
            $baseImage = str_replace(".", "", $this->ImageUploadPath);
            $photo = base_url($baseImage . "/" . $data['photo']);
        }
        if (!empty($data['tanggal_lahir']) AND $data['tanggal_lahir'] != "0000-00-00") {
            $tanggal_lahir = $data['tanggal_lahir'];
        }
        return array(
            "title" => ucwords($this->module),
            "subtitle" => $data['subtitle'],
            "link_back" => site_url($this->module),
            "moduleLink" => base_url($this->module),
            "ImageUploadPath" => $this->ImageUploadPath,
            "form_action" => base_url($this->module . "/" . $data['form_action']),
            
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
                
                "nama" => array(
                    "name" => "nama",
                    "type" => "text",
                    "class" => "form-control nama",
                    "value" => @$data['nama']
                ),
                "jabatan" => array(
                    "config" => array(
                        "name" => "jabatan",
                        "class" => "form-control select2 jabatan",
                    ),
                    "list" => $this->M_jabatan->getJabatanArray(@$data['jenis_jabatan']),
                    "selected" => @$data['jabatan']
                ),
				"kota_kelahiran" => array(
                    "name" => "kota_kelahiran",
                    "type" => "text",
                    "class" => "form-control kota_kelahiran",
                    "value" => @$data['kota_kelahiran']
                ),
				"tanggal_lahir" => array(
                    "name" => "tanggal_lahir",
                    "type" => "text",
                    "class" => "form-control tanggal_lahir",
                    "value" => $tanggal_lahir
                ),
				"socmed" => array(
                    array(
                        "icon" => "fa fa-facebook",
                        "item" => array(
                            "name" => "facebook",
                            "type" => "text",
                            "class" => "form-control facebook",
                            "placeholder" => "Facebook",
                            "value" => @$data['facebook']
                        ),
                    ),
                    array(
                        "icon" => "fa fa-twitter",
                        "item" => array(
                            "name" => "twitter",
                            "type" => "text",
                            "class" => "form-control twitter",
                            "placeholder" => "Twitter",
                            "value" => @$data['twitter']
                        ),
                    ),
                    array(
                        "icon" => "fa fa-instagram",
                        "item" => array(
                            "name" => "instagram",
                            "type" => "text",
                            "class" => "form-control instagram",
                            "placeholder" => "Instagram",
                            "value" => @$data['instagram']
                        ),
                    ),
                    array(
                        "icon" => "fa fa-google",
                        "item" => array(
                            "name" => "google_plus",
                            "type" => "text",
                            "class" => "form-control google_plus",
                            "placeholder" => "Google Plus",
                            "value" => @$data['google_plus']
                        ),
                    ),
                    array(
                        "icon" => "fa fa-heart",
                        "item" => array(
                            "name" => "bloglovin",
                            "type" => "text",
                            "class" => "form-control bloglovin",
                            "placeholder" => "Bloglovin",
                            "value" => @$data['bloglovin']
                        ),
                    ),
                    array(
                        "icon" => "fa fa-pinterest",
                        "item" => array(
                            "name" => "pinterest",
                            "type" => "text",
                            "class" => "form-control pinterest",
                            "placeholder" => "Pinterest",
                            "value" => @$data['pinterest']
                        ),
                    ),
                    array(
                        "icon" => "fa fa-youtube",
                        "item" => array(
                            "name" => "youtube",
                            "type" => "text",
                            "class" => "form-control youtube",
                            "placeholder" => "Youtube",
                            "value" => @$data['youtube']
                        ),
                    ),
                    array(
                        "icon" => "fa fa-tumblr",
                        "item" => array(
                            "name" => "tumblr",
                            "type" => "text",
                            "class" => "form-control tumblr",
                            "placeholder" => "Tumblr",
                            "value" => @$data['tumblr']
                        ),
                    ),
                ),
				"biografi" => array(
                    "name" => "biografi",
                    "class" => "form-control biografi",
                    "value" => @$data['biografi']
                ),
            )
        );
    }
    
    private function _formPostInputData ($photo) {
        $slug = "";
        if (!empty($this->input->post('nama'))) {
            $this->load->library('slug');
            $slug = $this->slug->createSlugDB($this->input->post('nama'), "pengurus", "slug");
        }
        $pengurus = array(
            "nama" => $this->input->post('nama'),
            "slug" => $slug,
            "photo" => $photo,
            "id_jabatan" => $this->input->post('jabatan'),
            "kota_kelahiran" => $this->input->post('kota_kelahiran'),
            "tanggal_lahir" => $this->input->post('tanggal_lahir'),
            "biografi" => $this->input->post('biografi'),
        );
        
        $socmed = array(
            "facebook" => $this->input->post('facebook'),
            "twitter" => $this->input->post('twitter'),
            "instagram" => $this->input->post('instagram'),
            "google_plus" => $this->input->post('google_plus'),
            "bloglovin" => $this->input->post('bloglovin'),
            "pinterest" => $this->input->post('pinterest'),
            "youtube" => $this->input->post('youtube'),
            "tumblr" => $this->input->post('tumblr'),
        );
        
        return array(
            "pengurus" => $pengurus,
            "socmed" => $socmed,
        );
    }
    
    private function _formPostProsesError () {
        $errorMsg = "";
        if (form_error("nama")) {
            $errorMsg .= form_error("nama");
        }
        if (form_error("jabatan")) {
            $errorMsg .= form_error("jabatan");
        }
        if (form_error("file")) {
            $errorMsg .= form_error("file");
        }
        
        return $errorMsg;
    }
    
    private function _rules ($action = "add") {
        $this->load->library('form_validation');
        $this->load->helper('security');
        
        $config = array(
            array(
                "field" => "nama",
                "label" => "Nama Pengurus",
                "rules" => "required|xss_clean",
                "errors" => array(
                    "required" => "%s tidak boleh kosong"
                )
            ),
            array(
                "field" => "jabatan",
                "label" => "Jabatan",
                "rules" => "required|xss_clean",
                "errors" => array(
                    "required" => "%s tidak boleh kosong"
                )
            ),
        );
        
        if ($_FILES['file']['name'] == "" AND $action == "add") {
            array_push($config, array(
                "field" => "file",
                "label" => "Photo Pengurus",
                "rules" => "required",
                "errors" => array(
                    "required" => "%s tidak boleh kosong"
                )
            ));
        }
        
        $this->form_validation->set_error_delimiters("<div class=''>", "</div>");
        
        $this->form_validation->set_rules($config);
    }
}