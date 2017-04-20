<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jabatan extends Controller{
    
    private $module = "pengurus";
    private $submodule = "jabatan";
    private $moduleLink;
    private $stat   = false;
    private $valid  = false;
    private $msg = "Data gagal di proses";

    public function __construct() {
        parent::__construct();
        
        $this->load->model("$this->module/M_$this->submodule");
        $this->moduleLink = "$this->module/$this->submodule/";
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
                $data = $this->_formPostInputData();
                $add = $this->M_jabatan->add($data);
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
            
            redirect($_backto);
        } else {
            show_404();
        }
    }
    
    public function edit ($id = 0) {
        $res = $this->M_jabatan->getData("jabatan", $id);
        
        if (
            $id > 0 AND
            $res->num_rows() > 0
        ) {
            $val = $res->row();

            $data = $this->_formInputData(array(
                "subtitle" => "Ubah Data",
                "form_action" => "edit_proses",
                "id" => $id
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
            $this->_rules();
            $id = $this->input->post('id');
            
            if (!$this->form_validation->run()) {
                $this->msg = $this->_formPostProsesError();
            } else {
                $data = $this->_formPostInputData();
                $edit = $this->M_jabatan->edit($data, $id);
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
            $del = $this->M_jabatan->delete($id);
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
    
    private function _formInputData ($data) {
        $jabatan = array("" => "");
        if (!empty($data['id'])) {
            $val = $this->M_jabatan->getData("jabatan", $data['id'])->row();
            if (!empty($val->jabatan)) {
                $jabatan = array($val->jabatan => $val->jabatan);
            }
        }
        return array(
            "title" => ucwords($this->module),
            "subtitle" => @$data['subtitle'],
            "link_back" => site_url($this->moduleLink),
            "moduleLink" => base_url($this->moduleLink),
            "form_action" => base_url($this->moduleLink . $data['form_action']),
            
            "input" => array(
                "hide" => array(
                    "id" => array(
                        "name" => "id",
                        "class" => "id",
                        "type" => "hidden",
                        "value" => @$data['id']
                    ),
                ),
                
                "jabatan" => array(
                    "config" => array(
                        "name" => "jabatan",
                        "class" => "form-control select2 jabatan",
                        "id" => "jabatan",
                    ),
                    "list" => $jabatan,
                ),
                
            )
        );
    }
    
    private function _formPostInputData () {
        return array(
            "jabatan" => $this->input->post('jabatan'),
        );;
    }
    
    private function _formPostProsesError () {
        if (form_error("jabatan")) {
            $errorMsg .= form_error("jabatan");
        }
        
        return $errorMsg;
    }
    
    private function _rules () {
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