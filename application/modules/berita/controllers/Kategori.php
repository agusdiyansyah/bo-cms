<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kategori extends Controller{
    
    private $module = "kategori";
    private $stat   = false;
    private $valid  = false;
    private $msg    = "Data gagal di proses";

    public function __construct() {
        parent::__construct();
        
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
            "link_add" => site_url("berita/$this->module/add"),
            "input" => array(
                "kategori" => array(
                    "name" => "kategori",
                    "class" => "form-control kategori",
                    "type" => "text"
                )
            )
        );
        
        $this->output->set_title($data['title'] . " " . $data['subtitle']);
        
		$this->load->view('data-kategori', $data);
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
	    	echo $this->M_kategori->data($_POST);
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
		$this->load->view('form-kategori', $data);
    }
    
    public function add_proses () {
        $this->output->unset_template();
        if ($this->input->post()) {
            $this->_rules();
            if (!$this->form_validation->run()) {
                $this->msg = $this->_formPostProsesError();
            } else {
                $data = $this->_formPostInputData();
                $add = $this->M_kategori->add($data);
                if ($add) {
                    $this->stat = true;
                }
            }
            if ($this->stat) {
                $notif = notification_proses("success", "Sukses", "Data Berhasil di proses");
                $this->session->set_flashdata('message', $notif);
                $_backto = "berita/kategori";
            } else {
                $notif = notification_proses("warning", "Gagal", $this->msg);
                $this->session->set_flashdata('message', $notif);
                $_backto = "berita/kategori/add";
            }
            
            redirect($_backto);
        } else {
            show_404();
        }
    }
    
    public function edit ($id = 0) {
        $res = $this->M_kategori->getData("id_kategori", $id);
        if (
            $id > 0 AND
            $res->num_rows() > 0
        ) {
            $row = $res->row();
            $data = $this->_formInputData(array(
                "subtitle" => "Ubah Data",
                "form_action" => "edit_proses",
                "id" => $id,
            ));
            $this->_formAssets();
            $this->output->set_title($data['title'] . " " . $data['subtitle']);
            $this->load->view("berita/form-kategori", $data);
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
                redirect("berita/$this->module/edit/$id");
            } else {
                $kategori = $this->input->post('kategori');
                $data = array(
                    "kategori" => $kategori,
                );
                $edit = $this->M_kategori->edit($data, $id);
                if ($edit) {
                    $this->stat = true;
                }
            }
            
            if ($this->stat) {
                $notif = notification_proses("success", "Sukses", "Data Berhasil di proses");
                $this->session->set_flashdata('message', $notif);
                $_backto = "berita/$this->module";
            } else {
                $notif = notification_proses("warning", "Gagal", "Data gagal di proses");
                $this->session->set_flashdata('message', $notif);
                $_backto = "berita/$this->module/edit/$id";
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
            $del = $this->M_kategori->delete($id);
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
    
    public function checkKategori () {
        $this->output->unset_template();
        if ($this->input->post()) {
            $cari = $this->input->post('q');
            
            if ($this->M_kategori->checkJumlahKategori($cari) > 0) {
                $data = array('disabled' => true, 'id' => 0, 'text' => 'Data telah terdaftar');
            } else {
                $data = array('disabled' => false, 'id' => $cari, 'text' => $cari);
            }
            
            echo json_encode(array($data));
        } else {
            show_404();
        }
    }
    
    public function srcKategori () {
        $this->output->unset_template();
        if ($this->input->post()) {
            $cari = $this->input->post('q');
            $this->db->like("kategori", $cari, "both");
            $sql = $this->M_kategori->getData("id_kategori, kategori");
            $data = array();
            if ($sql->num_rows() > 0) {
                foreach ($sql->result() as $val) {
                    $res = array('disabled' => false, 'id' => $val->id_kategori, 'text' => $val->kategori);
                    array_push($data, $res);
                }
            } else {
                $data = array(array('disabled' => true, 'id' => 0, 'text' => 'Data tidak di temukan'));
            }
            
            echo json_encode($data);
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
    }
    
    private function _formInputData ($data) {
        $kategori = array("" => "");
        if (!empty($data['id'])) {
            $row = $this->M_kategori->getData("kategori", $data['id']);
            if ($row->num_rows() > 0) {
                $row = $row->row();
                $kategori = array($data['id'] => $row->kategori);
            }
        }
        return array(
            "title" => ucwords($this->module),
            "subtitle" => $data['subtitle'],
            "link_back" => site_url("berita/" . $this->module),
            "moduleLink" => base_url("berita/" . $this->module),
            "form_action" => base_url("berita/" . $this->module . "/" . $data['form_action']),
            
            "input" => array(
                "hide" => array(
                    "id" => array(
                        "name" => "id",
                        "type" => "hidden",
                        "class" => "id",
                        "value" => @$data['id']
                    ),
                ),
                
                "kategori" => array(
                    "config" => array(
                        "name" => "kategori",
                        "class" => "form-control select2 kategori",
                        "id" => "kategori",
                    ),
                    "list" => $kategori
                ),
            )
        );
    }
    
    private function _formPostInputData () {
        return array(
            "kategori" => $this->input->post('kategori'),
        );
    }
    
    private function _formPostProsesError () {
        $errorMsg = "";
        if (form_error("kategori")) {
            $errorMsg .= form_error("kategori");
        }
        return $errorMsg;
    }
    
    private function _rules () {
        $this->load->library('form_validation');
        $this->load->helper('security');
        
        $config = array(
            array(
                "field" => "kategori",
                "label" => "Kategori berita",
                "rules" => "required|xss_clean",
                "errors" => array(
                    "required" => "%s tidak boleh kosong"
                )
            )
        );
        
        $this->form_validation->set_error_delimiters("<div class='text-danger'>", "</div>");
        
        $this->form_validation->set_rules($config);
    }

}