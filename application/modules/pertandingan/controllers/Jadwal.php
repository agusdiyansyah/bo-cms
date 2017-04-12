<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jadwal extends Controller{
    
    private $module = "pertandingan";
    private $submodule = "jadwal";
    private $moduleLink;
    private $stat   = false;
    private $valid  = false;

    public function __construct() {
        parent::__construct();
        
        $this->load->model("$this->module/M_match");
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
                "match_rival" => array(
                    "name" => "match_rival",
                    "type" => "text",
                    "class" => "form-control match_rival",
                    "id" => "match_rival"
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
	    	echo $this->M_match->data($_POST);
    	}
    	return;
	}
    
    public function add () {
        $this->_formAssets();
        
        $data = $this->_formData(array(
            "form_action" => "$this->moduleLink/add_proses",
            "subtitle" => "Tambah Data"
        ));
        
        $this->output->set_title($data['title'] . " " . $data['subtitle']);
		$this->load->view("$this->moduleLink/form", $data);
    }
    
    public function add_proses () {
        $this->output->unset_template();
        
        if ($this->input->post()) {

            $this->_rules();

            if (!$this->form_validation->run()) {
                $errorMsg = "";
                
                $errorMsg = $this->_postProsesError();

                $notif = notification_proses("warning", "Gagal", $errorMsg);
                $this->session->set_flashdata('message', $notif);

                redirect("$this->moduleLink/add");
            } else {
                $data = $this->_postData();

                $add = $this->M_match->add($data);

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
        $res = $this->M_match->getData("match_rival, match_date, match_homeaway, alamat", $id);
        
        if (
            $id > 0 AND
            $res->num_rows() > 0
        ) {
            $this->valid = true;
        }

        if ($this->valid) {
            
            $val = $res->row();

            $data = $this->_formData(array(
                "form_action" => "$this->moduleLink/edit_proses",
                "subtitle" => "Ubah Data",
                
                "id" => $id,
                "match_homeaway" => $val->match_homeaway,
                "match_rival" => $val->match_rival,
                "match_date" => $val->match_date,
                "alamat" => $val->alamat,
            ));
            
            $this->_formAssets();
            
            $this->output->set_title($data['title'] . " " . $data['subtitle']);
            $this->load->view("$this->moduleLink/form", $data);
        }

    }
    
    public function edit_proses () {
        
        $this->output->unset_template();
        
        if (
            $this->input->post()
        ) {
            $this->valid = true;
        }

        if ($this->valid) {
            
            $this->_rules();
            
            $id = $this->input->post('id');
            
            if (!$this->form_validation->run()) {
                $errorMsg = "";
                
                $errorMsg = $this->_postProsesError();

                $notif = notification_proses("warning", "Gagal", $errorMsg);
                $this->session->set_flashdata('message', $notif);

                redirect("$this->moduleLink/edit/$id");
            } else {
                
                $data = $this->_postData();

                $edit = $this->M_match->edit($data, $id);

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
            
            $del = $this->M_match->delete($id);

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
    
    public function srcRival () {
        $this->output->unset_template();
        if ($this->input->post()) {
            $hasil = array();
            $cari = $this->input->post("phrase");
            
            $this->db->like("match_rival", $cari, "both");
            $sql = $this->M_match->getData("match_rival");
            
            foreach ($sql->result() as $data) {
                array_push($hasil, array(
                    "name" => $data->match_rival,
                    "sql" => $this->db->last_query()
                ));
            }
            
            echo json_encode($hasil);
        } else {
            show_404();
        }
        
    }
    
    private function _formAssets () {
        // validate
        $this->output->js('assets/themes/adminLTE/plugins/jquery-validation/jquery.validate.js');
		$this->output->js('assets/themes/adminLTE/plugins/jquery-validation/localization/messages_id.js');
        
        // material datetime picker
        $this->output->css('assets/themes/adminLTE/plugins/bootstrap-materialdatetimepicker/css/bootstrap-material-datetimepicker.css');
        $this->output->css('assets/themes/adminLTE/css/bootstrap-materialdatetimepicker-skin.css');
        $this->output->css('https://fonts.googleapis.com/icon?family=Material+Icons');
        $this->output->js('assets/themes/adminLTE/plugins/moment/moment.js');
        $this->output->js('assets/themes/adminLTE/plugins/bootstrap-materialdatetimepicker/js/bootstrap-material-datetimepicker.js');
        
        // easy autocomplete
        $this->output->css('assets/themes/adminLTE/plugins/easyautocomplete/easyautocomplete.css');
        $this->output->js('assets/themes/adminLTE/plugins/easyautocomplete/easyautocomplete.js');
    }
    
    private function _formData ($data = array()) {
        return array(
            "title" => ucwords($this->submodule),
            "subtitle" => $data['subtitle'],
            "moduleLink" => $this->moduleLink,
            "link_back" => site_url($this->moduleLink),
            "form_action" => base_url($data['form_action']),
            
            "input" => array(
                "hide" => array(
                    "id" => array(
                        "name" => "id",
                        "class" => "id",
                        "value" => @$data['id'],
                        "type" => "hidden",
                    ),
                    
                    "match_homeaway" => array(
                        "name" => "match_homeaway",
                        "class" => "match_homeaway",
                        "value" => @$data['match_homeaway'],
                        "type" => "hidden",
                    ),
                ),
                
                "match_rival" => array(
                    "name" => "match_rival",
                    "type" => "text",
                    "class" => "form-control match_rival",
                    "id" => "match_rival",
                    "value" => @$data['match_rival']
                ),
                
                "match_date" => array(
                    "name" => "match_date",
                    "type" => "text",
                    "class" => "form-control match_date",
                    "id" => "match_date",
                    "value" => @$data['match_date']
                ),
                
                "alamat" => array(
                    "name" => "alamat",
                    "type" => "text",
                    "class" => "form-control alamat",
                    "id" => "alamat",
                    "value" => @$data['alamat']
                ),
            )
        );
    }
    
    private function _postData () {
        $match_rival = $this->input->post('match_rival');
        $match_date = $this->input->post('match_date');
        $match_homeaway = $this->input->post('match_homeaway');
        $alamat = $this->input->post('alamat');

        return array(
            "match_rival" => $match_rival,
            "match_date" => $match_date,
            "match_homeaway" => $match_homeaway,
            "alamat" => $alamat,
        );
    }
    
    private function _postProsesError () {
        if (form_error("match_rival")) {
            $errorMsg .= form_error("match_rival");
        }
        if (form_error("match_homeaway")) {
            $errorMsg .= form_error("match_homeaway");
        }
        if (form_error("match_date")) {
            $errorMsg .= form_error("match_date");
        }
        
        return $errorMsg;
    }
    
    private function _rules () {
        $this->load->library('form_validation');
        $this->load->helper('security');
        
        $config = array(
            array(
                "field" => "match_rival",
                "label" => "Rival",
                "rules" => "required|xss_clean",
                "errors" => array(
                    "required" => "%s tidak boleh kosong"
                )
            ),
            array(
                "field" => "match_date",
                "label" => "Tanggal main",
                "rules" => "required|xss_clean",
                "errors" => array(
                    "required" => "%s tidak boleh kosong",
                )
            ),
            array(
                "field" => "match_homeaway",
                "label" => "Bermain sebagai",
                "rules" => "required|xss_clean",
                "errors" => array(
                    "required" => "%s harus diisi"
                )
            )
        );
        
        $this->form_validation->set_error_delimiters("<div class='text-danger'>", "</div>");
        
        $this->form_validation->set_rules($config);
    }

}