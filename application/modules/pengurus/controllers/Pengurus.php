<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengurus extends Controller{
    
    protected $title = "Pengurus";
    protected $stat = false;
    protected $valid = false;

    public function __construct() {
        parent::__construct();
        
        $this->load->model("M_pengurus");
    }

    public function index () {
		Modules::run('login/terlarang', 10);
		$data['title'] = $this->title;
		$data['subtitle'] = "Data";
        
        $this->output->set_title($this->title . " " . $data['subtitle']);

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
            "title" => $this->title,
            "subtitle" => "Data",
            "link_add" => site_url('pengurus/add'),
            "input" => array(
                "nama_pengurus" => array(
                    "name" => "nama_pengurus",
                    "type" => "text",
                    "class" => "form-control nama_pengurus",
                    "id" => "nama_pengurus"
                )
            )
        );
        
		$this->load->view('data', $data);
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
	    	echo $this->M_pengurus->data($_POST);
    	}
    	return;
	}
    
    public function add () {
        // validate
        $this->output->js('assets/themes/adminLTE/plugins/jquery-validation/jquery.validate.js');
		$this->output->js('assets/themes/adminLTE/plugins/jquery-validation/localization/messages_id.js');
        
        $data = array(
            "title" => $this->title,
            "subtitle" => "Tambah Data",
            "link_back" => site_url('pengurus'),
            
            "form_action" => base_url("pengurus/add_proses"),
            "input" => array(
                "id_hide" => array(
                    "name" => "id",
                    "class" => "id",
                    "type" => "hidden"
                ),

                "nama_pengurus" => array(
                    "name" => "nama_pengurus",
                    "type" => "text",
                    "class" => "form-control nama_pengurus",
                    "id" => "nama_pengurus"
                )
            ),
            "error" => array(
                "nama_pengurus" => $this->session->flashdata('nama_pengurus'),
            )
        );
        
        $this->output->set_title($this->title . " " . $data['subtitle']);
		$this->load->view('form', $data);
    }
    
    public function add_proses () {
        if ($this->input->post()) {

            $this->rules();

            if (!$this->form_validation->run()) {
                $errorMsg = "";
                
                if (form_error("nama_pengurus")) {
                    $errorMsg .= form_error("nama_pengurus");
                }

                $notif = notification_proses("warning", "Gagal", $errorMsg);
                $this->session->set_flashdata('message', $notif);

                redirect("pengurus/add");
            } else {
                $nama_pengurus = $this->input->post('nama_pengurus');

                $data = array(
                    "nama_pengurus" => $nama_pengurus,
                );

                $add = $this->M_pengurus->add($data);

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
        
        redirect("pengurus");
    }
    
    public function edit ($id = 0) {
        $res = $this->M_pengurus->getDataPengurusById($id);
        
        if (
            $id > 0 AND
            $res->num_rows() > 0
        ) {
            $this->valid = true;
        }

        if ($this->valid) {
            
            $row = $res->row();

            $data = array(
                "form_action" => base_url("pengurus/edit_proses"),
                "link_back" => site_url("pengurus"),
                "input" => array(
                    "id_hide" => array(
                        "name" => "id",
                        "class" => "id",
                        "value" => $id,
                        "type" => "hidden"
                    ),

                    "nama_pengurus" => array(
                        "name" => "nama_pengurus",
                        "value" => $row->nama_pengurus,
                        "type" => "text",
                        "class" => "form-control nama_pengurus",
                        "id" => "nama_pengurus"
                    )
                ),
                "error" => array(
                    "nama_pengurus" => $this->session->flashdata('nama_pengurus'),
                )
            );
            
            $this->output->set_title($this->title . " " . $data['subtitle']);
            $this->load->view('pengurus/form', $data);
        }

    }
    
    public function edit_proses () {
        
        if (
            $this->input->post() AND
            !empty($this->input->post('id')) AND
            !empty($this->input->post('nama_pengurus'))
        ) {
            $this->valid = true;
        }

        if ($this->valid) {
            
            $this->rules();
            
            $id = $this->input->post('id');
            
            if (!$this->form_validation->run()) {
                $errorMsg = "";
                
                if (form_error("nama_pengurus")) {
                    $errorMsg .= form_error("nama_pengurus");
                }

                $notif = notification_proses("warning", "Gagal", $errorMsg);
                $this->session->set_flashdata('message', $notif);

                redirect("pengurus/edit/$id");
            } else {
                $nama_pengurus = $this->input->post('nama_pengurus');

                $data = array(
                    "nama_pengurus" => $nama_pengurus,
                );

                $edit = $this->M_pengurus->edit($data, $id);

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
        
        redirect("pengurus");

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
            
            $del = $this->M_pengurus->delete($id);

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
                "field" => "nama_pengurus",
                "label" => "Nama Pelanggan",
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