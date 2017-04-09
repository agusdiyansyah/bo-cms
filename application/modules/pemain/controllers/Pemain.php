<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pemain extends Controller{
    
    private $module = "pemain";
    private $submodule = "";
    private $moduleLink;
    private $stat   = false;
    private $valid  = false;
    private $ImageUploadPath = "./assets/upload/images/pemain/";

    public function __construct() {
        parent::__construct();
        
        $this->load->model("M_pemain");
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
            "pemain" => $this->M_pemain->getPemain(),
            "getPosisiName" => $this->M_pemain->getPosisiArray()
        );
        
        $this->output->set_title(ucwords($data['title']) . " " . $data['subtitle']);
        
		$this->load->view("data", $data);
	}
    
    public function add () {
        $this->_formAssets();
        
        $data = array(
            "title" => ucwords($this->module),
            "subtitle" => "Tambah Data",
            "link_back" => site_url($this->module),
            "form_action" => base_url("$this->module/add_proses"),
            
            "photo" => "",
            
            "input" => array(
                "id_hide" => array(
                    "name" => "id",
                    "class" => "id",
                    "type" => "hidden"
                ),
                
                "nama" => array(
                    "name" => "nama",
                    "type" => "text",
                    "class" => "form-control nama"
                ),
                "no_jersey" => array(
                    "name" => "no_jersey",
                    "type" => "number",
                    "class" => "form-control no_jersey"
                ),
                "posisi" => array(
                    "config" => array(
                        "name" => "posisi",
                        "class" => "form-control select2 posisi",
                    ),
                    "list" => $this->M_pemain->getPosisiArray()
                ),
				"kota_kelahiran" => array(
                    "name" => "kota_kelahiran",
                    "type" => "text",
                    "class" => "form-control kota_kelahiran"
                ),
				"tanggal_lahir" => array(
                    "name" => "tanggal_lahir",
                    "type" => "text",
                    "class" => "form-control tanggal_lahir"
                ),
				"socmed" => array(
                    array(
                        "icon" => "fa fa-facebook",
                        "item" => array(
                            "name" => "facebook",
                            "type" => "text",
                            "class" => "form-control facebook",
                            "placeholder" => "Facebook",
                        ),
                    ),
                    array(
                        "icon" => "fa fa-twitter",
                        "item" => array(
                            "name" => "twitter",
                            "type" => "text",
                            "class" => "form-control twitter",
                            "placeholder" => "Twitter",
                        ),
                    ),
                    array(
                        "icon" => "fa fa-instagram",
                        "item" => array(
                            "name" => "instagram",
                            "type" => "text",
                            "class" => "form-control instagram",
                            "placeholder" => "Instagram",
                        ),
                    ),
                    array(
                        "icon" => "fa fa-google",
                        "item" => array(
                            "name" => "google_plus",
                            "type" => "text",
                            "class" => "form-control google_plus",
                            "placeholder" => "Google Plus",
                        ),
                    ),
                    array(
                        "icon" => "fa fa-heart",
                        "item" => array(
                            "name" => "bloglovin",
                            "type" => "text",
                            "class" => "form-control bloglovin",
                            "placeholder" => "Bloglovin",
                        ),
                    ),
                    array(
                        "icon" => "fa fa-pinterest",
                        "item" => array(
                            "name" => "pinterest",
                            "type" => "text",
                            "class" => "form-control pinterest",
                            "placeholder" => "Pinterest",
                        ),
                    ),
                    array(
                        "icon" => "fa fa-youtube",
                        "item" => array(
                            "name" => "youtube",
                            "type" => "text",
                            "class" => "form-control youtube",
                            "placeholder" => "Youtube",
                        ),
                    ),
                    array(
                        "icon" => "fa fa-tumblr",
                        "item" => array(
                            "name" => "tumblr",
                            "type" => "text",
                            "class" => "form-control tumblr",
                            "placeholder" => "Tumblr",
                        ),
                    ),
                ),
				"biografi" => array(
                    "name" => "biografi",
                    "class" => "form-control biografi"
                ),
            )
        );
        
        $this->output->set_title($data['title'] . " " . $data['subtitle']);
		$this->load->view("form", $data);
    }
    
    public function add_proses () {
        $this->output->unset_template();
        if (
            $this->input->post() AND
            $this->input->post('nama') AND
            $this->input->post('no_jersey') AND
            $this->input->post('posisi')
        ) {

            $this->rules();

            if (!$this->form_validation->run()) {
                $errorMsg = $this->_formError();

                $notif = notification_proses("warning", "Gagal", $errorMsg);
                $this->session->set_flashdata('message', $notif);

                redirect("$this->module/add");
            } else {
                $nama = $this->input->post('nama');
                $posisi = $this->input->post('posisi');
                $no_jersey = $this->input->post('no_jersey');
                $kota_kelahiran = $this->input->post('kota_kelahiran');
                $tanggal_lahir = $this->input->post('tanggal_lahir');
                $biografi = $this->input->post('biografi');
                
                $facebook = $this->input->post('facebook');
                $twitter = $this->input->post('twitter');
                $instagram = $this->input->post('instagram');
                $google_plus = $this->input->post('google_plus');
                $bloglovin = $this->input->post('bloglovin');
                $pinterest = $this->input->post('pinterest');
                $youtube = $this->input->post('youtube');
                $tumblr = $this->input->post('tumblr');
                
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

                $dataPengurus = array(
                    "nama" => $nama,
                    "photo" => $photo,
                    "posisi" => $posisi,
                    "no_jersey" => $no_jersey,
                    "kota_kelahiran" => $kota_kelahiran,
                    "tanggal_lahir" => $tanggal_lahir,
                    "biografi" => $biografi,
                );
                
                $dataSocmed = array(
                    "facebook" => $facebook,
                    "twitter" => $twitter,
                    "instagram" => $instagram,
                    "google_plus" => $google_plus,
                    "bloglovin" => $bloglovin,
                    "pinterest" => $pinterest,
                    "youtube" => $youtube,
                    "tumblr" => $tumblr,
                );

                $proses = $this->M_pemain->add($dataPengurus, $dataSocmed);

                if ($proses) {
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
        
        redirect("pengurus");
    }
    
    public function edit ($id = 0) {
        $res = $this->M_pemain->getData("*", $id);
        if (
            $id > 0 AND
            $res->num_rows() > 0
        ) {
            $this->_formAssets();
            
            $data = $res->row();
            
            $photo = "";
            if (!empty($data->photo)) {
                $photo = base_url($this->ImageUploadPath.$data->photo);
            }
            
            $socmed = $this->M_pemain->getDataSocmedArray($id);
            
            $data = array(
                "title" => ucwords($this->module),
                "subtitle" => "Ubah Data",
                "link_back" => site_url($this->module),
                "form_action" => base_url("$this->module/edit_proses"),
                
                "photo" => $photo,
                
                "input" => array(
                    "id_hide" => array(
                        "name" => "id",
                        "class" => "id",
                        "type" => "hidden",
                        "value" => $id
                    ),
                    
                    "nama" => array(
                        "name" => "nama",
                        "type" => "text",
                        "class" => "form-control nama",
                        "value" => $data->nama
                    ),
                    "no_jersey" => array(
                        "name" => "no_jersey",
                        "type" => "text",
                        "class" => "form-control no_jersey",
                        "value" => $data->no_jersey
                    ),
                    "posisi" => array(
                        "config" => array(
                            "name" => "posisi",
                            "class" => "form-control select2 posisi",
                        ),
                        "list" => $this->M_pemain->getPosisiArray(),
                        "selected" => $data->posisi
                    ),
    				"kota_kelahiran" => array(
                        "name" => "kota_kelahiran",
                        "type" => "text",
                        "class" => "form-control kota_kelahiran",
                        "value" => $data->kota_kelahiran
                    ),
    				"tanggal_lahir" => array(
                        "name" => "tanggal_lahir",
                        "type" => "text",
                        "class" => "form-control tanggal_lahir",
                        "value" => $data->tanggal_lahir
                    ),
                    "socmed" => array(
                        array(
                            "icon" => "fa fa-facebook",
                            "item" => array(
                                "name" => "facebook",
                                "type" => "text",
                                "class" => "form-control facebook",
                                "placeholder" => "Facebook",
                                "value" => @$socmed['2']
                            ),
                        ),
                        array(
                            "icon" => "fa fa-twitter",
                            "item" => array(
                                "name" => "twitter",
                                "type" => "text",
                                "class" => "form-control twitter",
                                "placeholder" => "Twitter",
                                "value" => @$socmed['1']
                            ),
                        ),
                        array(
                            "icon" => "fa fa-instagram",
                            "item" => array(
                                "name" => "instagram",
                                "type" => "text",
                                "class" => "form-control instagram",
                                "placeholder" => "Instagram",
                                "value" => @$socmed['3']
                            ),
                        ),
                        array(
                            "icon" => "fa fa-google",
                            "item" => array(
                                "name" => "google_plus",
                                "type" => "text",
                                "class" => "form-control google_plus",
                                "placeholder" => "Google Plus",
                                "value" => @$socmed['4']
                            ),
                        ),
                        array(
                            "icon" => "fa fa-heart",
                            "item" => array(
                                "name" => "bloglovin",
                                "type" => "text",
                                "class" => "form-control bloglovin",
                                "placeholder" => "Bloglovin",
                                "value" => @$socmed['5']
                            ),
                        ),
                        array(
                            "icon" => "fa fa-pinterest",
                            "item" => array(
                                "name" => "pinterest",
                                "type" => "text",
                                "class" => "form-control pinterest",
                                "placeholder" => "Pinterest",
                                "value" => @$socmed['6']
                            ),
                        ),
                        array(
                            "icon" => "fa fa-youtube",
                            "item" => array(
                                "name" => "youtube",
                                "type" => "text",
                                "class" => "form-control youtube",
                                "placeholder" => "Youtube",
                                "value" => @$socmed['7']
                            ),
                        ),
                        array(
                            "icon" => "fa fa-tumblr",
                            "item" => array(
                                "name" => "tumblr",
                                "type" => "text",
                                "class" => "form-control tumblr",
                                "placeholder" => "Tumblr",
                                "value" => @$socmed['8']
                            ),
                        ),
                    ),
    				"biografi" => array(
                        "name" => "biografi",
                        "class" => "form-control biografi",
                        "value" => $data->biografi
                    ),
                )
            );
            
            $this->load->view("form", $data);
        }
    }
    
    public function edit_proses () {
        
        if (
            $this->input->post() AND
            !empty($this->input->post('id')) AND
            !empty($this->input->post('nama')) AND
            !empty($this->input->post('posisi'))
        ) {
            $this->valid = true;
        }

        if ($this->valid) {
            
            $this->rules();
            
            $id = $this->input->post('id');
            
            if (!$this->form_validation->run()) {
                $errorMsg = $this->_formError();

                $notif = notification_proses("warning", "Gagal", $errorMsg);
                $this->session->set_flashdata('message', $notif);

                redirect("$this->module/edit/$id");
            } else {
                $nama = $this->input->post('nama');
                $posisi = $this->input->post('posisi');
                $no_jersey = $this->input->post('no_jersey');
                $kota_kelahiran = $this->input->post('kota_kelahiran');
                $tanggal_lahir = $this->input->post('tanggal_lahir');
                $biografi = $this->input->post('biografi');
                
                $facebook = $this->input->post('facebook');
                $twitter = $this->input->post('twitter');
                $instagram = $this->input->post('instagram');
                $google_plus = $this->input->post('google_plus');
                $bloglovin = $this->input->post('bloglovin');
                $pinterest = $this->input->post('pinterest');
                $youtube = $this->input->post('youtube');
                $tumblr = $this->input->post('tumblr');
                
                if (is_uploaded_file($_FILES['file']['tmp_name'])) {
                    $pengurus = $this->M_pemain->getData("photo", $id)->row();
                    $this->load->library('image');
                    $upload = $this->image->upload(array(
                        "upload_path" => $this->ImageUploadPath,
                        "update" => @$pengurus->photo
                    ));
                    if ($upload['stat']) {
                        $dataPengurus["photo"] = $upload['file_name'];
                    }
                    
                }

                $dataPengurus["nama"] = $nama;
                $dataPengurus["posisi"] = $posisi;
                $dataPengurus["no_jersey"] = $no_jersey;
                $dataPengurus["kota_kelahiran"] = $kota_kelahiran;
                $dataPengurus["tanggal_lahir"] = $tanggal_lahir;
                $dataPengurus["biografi"] = $biografi;
                
                $dataSocmed = array(
                    "facebook" => $facebook,
                    "twitter" => $twitter,
                    "instagram" => $instagram,
                    "google_plus" => $google_plus,
                    "bloglovin" => $bloglovin,
                    "pinterest" => $pinterest,
                    "youtube" => $youtube,
                    "tumblr" => $tumblr,
                );

                $proses = $this->M_pemain->edit($id, $dataPengurus, $dataSocmed);

                if ($proses['stat']) {
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
            
            $del = $this->M_pemain->delete($id);

            if ($del['stat']) {
                $this->stat = true;
                if (!empty($del['photo'])) {
                    unlink($this->ImageUploadPath . $del['photo']);
                    unlink($this->ImageUploadPath . "thumb/" . $del['photo']);
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

    }
    
    private function rules () {
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
                "field" => "posisi",
                "label" => "Posisi",
                "rules" => "required|xss_clean",
                "errors" => array(
                    "required" => "%s tidak boleh kosong"
                )
            ),
        );
        
        $this->form_validation->set_error_delimiters("<div class='text-danger'>", "</div>");
        
        $this->form_validation->set_rules($config);
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
        
        // datepicker
        $this->output->css('assets/themes/adminLTE/plugins/datepicker/datepicker3.css');
		$this->output->js('assets/themes/adminLTE/plugins/datepicker/bootstrap-datepicker.js');
    }
    
    private function _formError () {
        $errorMsg = "";
        if (form_error("nama")) {
            $errorMsg .= form_error("nama");
        }
        if (form_error("posisi")) {
            $errorMsg .= form_error("posisi");
        }
        
        return $errorMsg;
    }

}