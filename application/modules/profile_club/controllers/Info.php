<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Info extends Controller{
    
    private $module = "profile_club";
    private $submodule = "info";
    private $moduleLink;
    private $stat   = false;
    private $valid  = false;
    private $msg = "Data gagal di proses";
    private $ImageUploadPath = "./assets/upload/images/meta/";

    public function __construct() {
        parent::__construct();
        $this->load->model("profile_club/M_info");
        $this->moduleLink = $this->module . "/" . $this->submodule . "/";
    }

    public function index($tabSelected = "") {
        $this->_formAssets();
        $data = $this->_formData(array(
            "tabSelected" => $tabSelected
        ));
        $this->load->view($this->moduleLink . "data", $data);
    }
    
    private function _formAssets () {
        // validate
        $this->output->js('assets/themes/adminLTE/plugins/jquery-validation/jquery.validate.js');
		$this->output->js('assets/themes/adminLTE/plugins/jquery-validation/localization/messages_id.js');
        // fileinput
        $this->output->css("assets/themes/adminLTE/plugins/file-input/fileinput.min.css");
		$this->output->css("assets/themes/adminLTE/css/file-input-custom.css");
        $this->output->js("assets/themes/adminLTE/plugins/file-input/fileinput.min.js");
    }
    
    public function getDataMetaUmum () {
        $this->output->unset_template();
        if ($this->input->post("ac") == "umum") {
            $config = array();
            foreach ($this->M_info->getDataMetaUmum()->result() as $data) {
                $config += array(
                    $data->label => $data->value
                );
            }
            echo json_encode(array(
                "nama_tim" => @$config["meta_umum_nama_tim"],
                "deskripsi" => @$config["meta_umum_deskripsi"],
                "keyword" => @$config["meta_umum_keyword"],
                "email" => @$config["meta_umum_email"],
                "telepon" => @$config["meta_umum_telepon"],
                "fax" => @$config["meta_umum_fax"],
                "alamat" => @$config["meta_umum_alamat"],
            ));
        } else {
            show_404();
        }
    }
    
    public function getDataMetaSocmed () {
        $this->output->unset_template();
        if ($this->input->post("ac") == "socmed") {
            $config = array();
            foreach ($this->M_info->getDataMetaSocmed()->result() as $data) {
                $config += array(
                    $data->label => $data->value
                );
            }
            echo json_encode(array(
                "facebook" => @$config["meta_socmed_facebook"],
                "twitter" => @$config["meta_socmed_twitter"],
                "instagram" => @$config["meta_socmed_instagram"],
                "google_plus" => @$config["meta_socmed_google_plus"],
                "bloglovin" => @$config["meta_socmed_bloglovin"],
                "pinterest" => @$config["meta_socmed_pinterest"],
                "youtube" => @$config["meta_socmed_youtube"],
                "tumblr" => @$config["meta_socmed_tumblr"],
            ));
        } else {
            show_404();
        }
    }
    
    public function getDataMetaImage () {
        $this->output->unset_template();
        if ($this->input->post("ac") == "image") {
            $config = $this->M_info->getDataMetaImage(true);
            $ImageUploadPath = str_replace(".", "", $this->ImageUploadPath);
            echo json_encode(array(
                "ImageUploadPath" => base_url($ImageUploadPath)."/",
                "meta_image_logo" => (empty($config["meta_image_logo"])) ? null : $config["meta_image_logo"],
                "meta_image_cover" => (empty($config["meta_image_cover"])) ? null : $config["meta_image_cover"],
            ));
        } else {
            show_404();
        }
    }
    
    public function prosesMetaUmum () {
        $this->output->unset_template();
        if ($this->input->post()) {
            $this->_rulesMetaUmum();
            if (!$this->form_validation->run()) {
                $this->msg = "";
                if (form_error("nama_tim")) {
                    $this->msg .= form_error("nama_tim");
                }
            } else {
                $data = array(
                    "nama_tim" => $this->input->post('nama_tim'),
                    "deskripsi" => $this->input->post('deskripsi'),
                    "keyword" => $this->input->post('keyword'),
                    "email" => $this->input->post('email'),
                    "telepon" => $this->input->post('telepon'),
                    "fax" => $this->input->post('fax'),
                    "alamat" => $this->input->post('alamat'),
                );
                if ($this->M_info->prosesMetaUmum($data)) {
                    $this->stat = true;
                }
            }
            $this->_notif();
        } else {
            show_404();
        }
    }
    
    public function prosesMetaSocmed () {
        $this->output->unset_template();
        if ($this->input->post()) {
            $data = array(
                "facebook" => $this->input->post("facebook"),
                "twitter" => $this->input->post("twitter"),
                "instagram" => $this->input->post("instagram"),
                "google_plus" => $this->input->post("google_plus"),
                "bloglovin" => $this->input->post("bloglovin"),
                "pinterest" => $this->input->post("pinterest"),
                "youtube" => $this->input->post("youtube"),
                "tumblr" => $this->input->post("tumblr"),
            );
            if ($this->M_info->prosesMetaSocmed($data)) {
                $this->stat = true;
            }
            $this->_notif("index/socmed");
        } else {
            show_404();
        }
    }
    
    public function prosesMetaImage () {
        $this->output->unset_template();
        
        if ($this->input->post()) {
            $logo = "";
            $val = $this->M_info->getDataMetaImage(true);
            if (is_uploaded_file($_FILES['logo']['tmp_name']) AND $this->input->post('remove-logo') == 0) {
                $this->load->library('image');
                $upload = $this->image->upload(array(
                    "upload_path" => $this->ImageUploadPath,
                    "thumbnail_path" => $this->ImageUploadPath,
                    "file_element_name" => "logo",
                    "resize" => false,
                    "update" => @$val['meta_image_logo']
                ));
                if ($upload['stat']) {
                    $data['logo'] = $upload['file_name'];
                    $icon144 = $this->image->upload(array(
                        "upload_path" => $this->ImageUploadPath,
                        "thumbnail_path" => $this->ImageUploadPath,
                        "file_element_name" => "logo",
                        "crop" => false,
                        "resize_width" => 144,
                        "resize_height" => 144,
                        "update" => @$val['meta_image_icon_144']
                    ));
                    if ($icon144['stat']) {
                        $data['icon_144'] = $icon144['file_name'];
                        $icon72 = $this->image->upload(array(
                            "upload_path" => $this->ImageUploadPath,
                            "thumbnail_path" => $this->ImageUploadPath,
                            "file_element_name" => "logo",
                            "crop" => false,
                            "resize_width" => 72,
                            "resize_height" => 72,
                            "update" => @$val['meta_image_icon_72']
                        ));
                        if ($icon72['stat']) {
                            $data['icon_72'] = $icon72['file_name'];
                            $icon58 = $this->image->upload(array(
                                "upload_path" => $this->ImageUploadPath,
                                "thumbnail_path" => $this->ImageUploadPath,
                                "file_element_name" => "logo",
                                "crop" => false,
                                "resize_width" => 58,
                                "resize_height" => 58,
                                "update" => @$val['meta_image_icon_58']
                            ));
                            if ($icon58['stat']) {
                                $data['icon_58'] = $icon58['file_name'];
                            }
                        }
                    }
                }
            } elseif ($this->input->post('remove-logo') > 0) {
                if (file_exists($this->ImageUploadPath . $val['meta_image_logo'])) {
                    unlink($this->ImageUploadPath . $val['meta_image_logo']);
                    $data['logo'] = "";
                }
                if (file_exists($this->ImageUploadPath . $val['meta_image_icon_144'])) {
                    unlink($this->ImageUploadPath . $val['meta_image_icon_144']);
                    $data['icon_144'] = "";
                }
                if (file_exists($this->ImageUploadPath . $val['meta_image_icon_72'])) {
                    unlink($this->ImageUploadPath . $val['meta_image_icon_72']);
                    $data['icon_72'] = "";
                }
                if (file_exists($this->ImageUploadPath . $val['meta_image_icon_58'])) {
                    unlink($this->ImageUploadPath . $val['meta_image_icon_58']);
                    $data['icon_58'] = "";
                }
            } else {
                $data['logo'] = @$val['meta_image_logo'];
                $data['icon_144'] = @$val['meta_image_icon_144'];
                $data['icon_72'] = @$val['meta_image_icon_72'];
                $data['icon_58'] = @$val['meta_image_icon_58'];
            }
            
            if (is_uploaded_file($_FILES['cover']['tmp_name']) AND $this->input->post('remove-cover') == 0) {
                $this->load->library('image');
                $upload = $this->image->upload(array(
                    "upload_path" => $this->ImageUploadPath,
                    "thumbnail_path" => $this->ImageUploadPath,
                    "file_element_name" => "cover",
                    "resize_width" => 1024,
                    "resize_height" => 768,
                    "crop" => false,
                    "update" => @$val['meta_image_cover'],
                ));
                if ($upload['stat']) {
                    $data['cover'] = $upload['file_name'];
                }
            } elseif ($this->input->post('remove-cover') > 0 AND !empty($val['meta_image_cover'])) {
                if (file_exists($this->ImageUploadPath . $val['meta_image_cover'])) {
                    unlink($this->ImageUploadPath . $val['meta_image_cover']);
                    $data['cover'] = "";
                }
            } else {
                $data['cover'] = @$val['meta_image_cover'];
            }
            
            if (count($data) > 0) {
                $this->M_info->prosesMetaImage($data);
            }
            
            $this->stat = true;
            
            $this->_notif("index/image");
        } else {
            show_404();
        }
    }
    
    private function _notif ($metaProses = "") {
        if ($this->stat) {
            $notif = notification_proses("success", "Sukses", "Data Berhasil di proses");
            $this->session->set_flashdata('message', $notif);
        } else {
            $notif = notification_proses("warning", "Gagal", $this->msg);
            $this->session->set_flashdata('message', $notif);
        }
        redirect($this->moduleLink . $metaProses);
    }
    
    private function _rulesMetaUmum () {
        $this->load->library('form_validation');
        $this->load->helper('security');
        $config = array(
            array(
                "field" => "nama_tim",
                "label" => "Nama tim",
                "rules" => "required|xss_clean",
                "errors" => array(
                    "required" => "%s tidak boleh kosong"
                )
            )
        );
        $this->form_validation->set_error_delimiters("<div class='text-danger'>", "</div>");
        $this->form_validation->set_rules($config);
    }
    
    private function _formData ($data = array()) {
        $icon = (empty($data['icon'])) ? "" : base_url($this->ImageUploadPath . $data['icon']);
        $logo = (empty($data['logo'])) ? "" : base_url($this->ImageUploadPath . $data['logo']);
        $cover = (empty($data['cover'])) ? "" : base_url($this->ImageUploadPath . $data['cover']);
        return array(
            "title" => "Informasi Umum",
            "tabSelected" => $data['tabSelected'],
            "aksi" => array(
                "umum" => base_url($this->moduleLink . "prosesMetaUmum"),
                "image" => base_url($this->moduleLink . "prosesMetaImage"),
                "socmed" => base_url($this->moduleLink . "prosesMetaSocmed"),
            ),
            "data" => array(
                "umum" => base_url($this->moduleLink . "getDataMetaUmum"),
                "image" => base_url($this->moduleLink . "getDataMetaImage"),
                "socmed" => base_url($this->moduleLink . "getDataMetaSocmed"),
            ),
            "form_umum" => array(
                "nama_tim" => array(
                    "name" => "nama_tim",
                    "class" => "form-control nama_tim",
                    "id" => "nama_tim",
                    "type" => "text",
                    "value" => @$data['nama_tim']
                ),
                "deskripsi" => array(
                    "name" => "deskripsi",
                    "class" => "form-control deskripsi",
                    "id" => "deskripsi",
                    "value" => @$data['deskripsi']
                ),
                "keyword" => array(
                    "name" => "keyword",
                    "class" => "form-control keyword",
                    "id" => "keyword",
                    "type" => "text",
                    "value" => @$data['keyword']
                ),
                "email" => array(
                    "name" => "email",
                    "class" => "form-control email",
                    "id" => "email",
                    "type" => "text",
                    "value" => @$data['email']
                ),
                "telepon" => array(
                    "name" => "telepon",
                    "class" => "form-control telepon",
                    "id" => "telepon",
                    "type" => "text",
                    "value" => @$data['telepon']
                ),
                "fax" => array(
                    "name" => "fax",
                    "class" => "form-control fax",
                    "id" => "fax",
                    "type" => "text",
                    "value" => @$data['fax']
                ),
                "alamat" => array(
                    "name" => "alamat",
                    "class" => "form-control alamat",
                    "id" => "alamat",
                    "value" => @$data['alamat']
                ),
            ),
            "form_image" => array(
                "icon" => $icon,
                "logo" => $logo,
                "cover" => $cover,
            ),
            "form_socmed" => array(
                "facebook" => array(
                    "name" => "facebook",
                    "class" => "form-control facebook",
                    "id" => "facebook",
                    "type" => "text",
                    "value" => @$data['facebook']
                ),
                "twitter" => array(
                    "name" => "twitter",
                    "class" => "form-control twitter",
                    "id" => "twitter",
                    "type" => "text",
                    "value" => @$data['twitter']
                ),
                "instagram" => array(
                    "name" => "instagram",
                    "class" => "form-control instagram",
                    "id" => "instagram",
                    "type" => "text",
                    "value" => @$data['instagram']
                ),
                "google_plus" => array(
                    "name" => "google_plus",
                    "class" => "form-control google_plus",
                    "id" => "google_plus",
                    "type" => "text",
                    "value" => @$data['google_plus']
                ),
                "bloglovin" => array(
                    "name" => "bloglovin",
                    "class" => "form-control bloglovin",
                    "id" => "bloglovin",
                    "type" => "text",
                    "value" => @$data['bloglovin']
                ),
                "pinterest" => array(
                    "name" => "pinterest",
                    "class" => "form-control pinterest",
                    "id" => "pinterest",
                    "type" => "text",
                    "value" => @$data['pinterest']
                ),
                "youtube" => array(
                    "name" => "youtube",
                    "class" => "form-control youtube",
                    "id" => "youtube",
                    "type" => "text",
                    "value" => @$data['youtube']
                ),
                "tumblr" => array(
                    "name" => "tumblr",
                    "class" => "form-control tumblr",
                    "id" => "tumblr",
                    "type" => "text",
                    "value" => @$data['tumblr']
                ),
            ),
        );
    }

}