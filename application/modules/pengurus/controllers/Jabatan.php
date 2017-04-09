<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jabatan extends Controller{
    
    private $module = "pengurus";
    private $submodule = "jabatan";
    private $moduleLink;
    private $stat   = false;
    private $valid  = false;

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
        
        $data = array(
            "moduleLink" => $this->moduleLink,
            "title" => ucwords($this->submodule),
            "subtitle" => "Data",
            "link_add" => site_url("$this->module/$this->submodule/add"),
            "input" => array(
                "jabatan" => array(
                    "name" => "jabatan",
                    "type" => "text",
                    "class" => "form-control jabatan",
                    "id" => "jabatan"
                )
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
	    	echo $this->M_jabatan->data($_POST);
    	}
    	return;
	}
    
    public function add () {
        $this->_formAssets();
        
        $data = array(
            "title" => ucwords($this->submodule),
            "subtitle" => "Tambah Data",
            "link_back" => site_url("$this->moduleLink"),
            
            "moduleLink" => $this->moduleLink,
            
            "form_action" => base_url("$this->moduleLink/add_proses"),
            "input" => array(
                "id_hide" => array(
                    "name" => "id",
                    "class" => "id",
                    "type" => "hidden"
                ),
                
                "jabatan" => array(
                    "config" => array(
                        "name" => "jabatan",
                        "class" => "form-control select2 jabatan",
                        "id" => "jabatan",
                    ),
                    "list" => array("" => "")
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
                $jabatan = $this->input->post('jabatan');

                $data = array(
                    "jabatan" => $jabatan,
                );

                $add = $this->M_jabatan->add($data);

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
        $res = $this->M_jabatan->getData("jabatan", $id);
        
        if (
            $id > 0 AND
            $res->num_rows() > 0
        ) {
            $this->valid = true;
        }

        if ($this->valid) {
            
            $val = $res->row();

            $data = array(
                "moduleLink" => $this->moduleLink,
                "title" => ucwords($this->submodule),
                "subtitle" => "Ubah Data",
                "link_back" => site_url("$this->moduleLink"),
                
                "form_action" => base_url("$this->moduleLink/edit_proses"),
                "input" => array(
                    "id_hide" => array(
                        "name" => "id",
                        "class" => "id",
                        "type" => "hidden",
                        "value" => $id,
                    ),
                    
                    "jabatan" => array(
                        "config" => array(
                            "name" => "jabatan",
                            "class" => "form-control select2 jabatan",
                            "id" => "jabatan",
                        ),
                        "list" => array($val->jabatan => $val->jabatan)
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
            !empty($this->input->post('jabatan'))
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
                $jabatan = $this->input->post('jabatan');
                
                $data = array(
                    "jabatan" => $jabatan
                );

                $edit = $this->M_jabatan->edit($data, $id);

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
            
            $del = $this->M_jabatan->delete($id);

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
    
    public function checkJumlahRow () {
        $this->output->unset_template();
        
        $cari = $this->input->post('q');
        
        $this->db->where("jabatan", $cari);
        
        if ($this->M_jabatan->getData("id_jabatan")->num_rows() > 0) {
            $data = array('disabled' => true, 'id' => 0, 'text' => 'Data telah terdaftar');
        } else {
            $data = array('disabled' => false, 'id' => $cari, 'text' => $cari);
        }
        
        echo json_encode(array($data));
    }
    
    private function _formAssets () {
        // validate
        $this->output->js('assets/themes/adminLTE/plugins/jquery-validation/jquery.validate.js');
		$this->output->js('assets/themes/adminLTE/plugins/jquery-validation/localization/messages_id.js');
        
        // select2
        $this->output->css('assets/themes/adminLTE/plugins/select2/select2.min.css');
		$this->output->css('assets/themes/adminLTE/plugins/select2/select2-bootstrap.css');
		$this->output->js('assets/themes/adminLTE/plugins/select2/select2.min.js');
    }
    
    private function _postProsesError () {
        if (form_error("jabatan")) {
            $errorMsg .= form_error("jabatan");
        }
        
        return $errorMsg;
    }
    
    private function rules () {
        $this->load->library('form_validation');
        $this->load->helper('security');
        
        $config = array(
            array(
                "field" => "jabatan",
                "label" => "Nama trophy",
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