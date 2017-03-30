<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kategori extends Controller{
    
    private $module = "kategori";
    private $stat   = false;
    private $valid  = false;

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
        // validate
        $this->output->js('assets/themes/adminLTE/plugins/jquery-validation/jquery.validate.js');
		$this->output->js('assets/themes/adminLTE/plugins/jquery-validation/localization/messages_id.js');
        
        // select2
        $this->output->css('assets/themes/adminLTE/plugins/select2/select2.min.css');
		$this->output->css('assets/themes/adminLTE/plugins/select2/select2-bootstrap.css');
		$this->output->js('assets/themes/adminLTE/plugins/select2/select2.min.js');
        
        // $objKategori = $this->M_kategori->getData("id_kategori, kategori")->result();
        // $kategori = array("" => "");
        // foreach ($objKategori as $val) {
        //     $kategori += array($val->id_kategori => $val->kategori);
        // }
        
        $data = array(
            "title" => ucwords($this->module),
            "subtitle" => "Tambah Data",
            "link_back" => site_url("berita/$this->module"),
            
            "form_action" => base_url("berita/$this->module/add_proses"),
            "input" => array(
                "id_hide" => array(
                    "name" => "id",
                    "class" => "id",
                    "type" => "hidden"
                ),
                
                "kategori" => array(
                    "config" => array(
                        "name" => "kategori",
                        "class" => "form-control select2 kategori",
                        "id" => "kategori",
                    ),
                    "list" => array("" => "")
                ),
            )
        );
        
        $this->output->set_title(ucwords($this->module) . " " . $data['subtitle']);
		$this->load->view('form-kategori', $data);
    }
    
    public function add_proses () {
        if ($this->input->post()) {

            $this->rules();

            if (!$this->form_validation->run()) {
                $errorMsg = "";
                
                if (form_error("kategori")) {
                    $errorMsg .= form_error("kategori");
                }

                $notif = notification_proses("warning", "Gagal", $errorMsg);
                $this->session->set_flashdata('message', $notif);

                redirect("berita/kategori/add");
            } else {
                $kategori = $this->input->post('kategori');

                $data = array(
                    "kategori" => $kategori,
                );

                $add = $this->M_kategori->add($data);

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
        
        redirect("berita/kategori");
    }
    
    public function edit ($id = 0) {
        $res = $this->M_kategori->getData("id_kategori, kategori", $id);
        
        if (
            $id > 0 AND
            $res->num_rows() > 0
        ) {
            $this->valid = true;
        }

        if ($this->valid) {
            
            $row = $res->row();

            $data = array(
                "title" => ucwords($this->module),
                "subtitle" => "Ubah Data",
                "form_action" => base_url("berita/$this->module/edit_proses"),
                "link_back" => site_url("berita/$this->module"),
                "input" => array(
                    "id_hide" => array(
                        "name" => "id",
                        "class" => "id",
                        "value" => $id,
                        "type" => "hidden"
                    ),

                    "kategori" => array(
                        "config" => array(
                            "name" => "kategori",
                            "class" => "form-control select2 kategori",
                            "id" => "kategori",
                        ),
                        "list" => array($row->id_kategori => $row->kategori)
                    ),
                )
            );
            
            // validate
            $this->output->js('assets/themes/adminLTE/plugins/jquery-validation/jquery.validate.js');
    		$this->output->js('assets/themes/adminLTE/plugins/jquery-validation/localization/messages_id.js');
            
            // select2
            $this->output->css('assets/themes/adminLTE/plugins/select2/select2.min.css');
    		$this->output->css('assets/themes/adminLTE/plugins/select2/select2-bootstrap.css');
    		$this->output->js('assets/themes/adminLTE/plugins/select2/select2.min.js');
            
            $this->output->set_title($data['title'] . " " . $data['subtitle']);
            $this->load->view("berita/form-kategori", $data);
        }

    }
    
    public function edit_proses () {
        
        if (
            $this->input->post() AND
            !empty($this->input->post('id')) AND
            !empty($this->input->post('kategori'))
        ) {
            $this->valid = true;
        }

        if ($this->valid) {
            
            $this->rules();
            
            $id = $this->input->post('id');
            
            if (!$this->form_validation->run()) {
                $errorMsg = "";
                
                if (form_error("kategori")) {
                    $errorMsg .= form_error("kategori");
                }

                $notif = notification_proses("warning", "Gagal", $errorMsg);
                $this->session->set_flashdata('message', $notif);

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

        }

        if ($this->stat) {
            $notif = notification_proses("success", "Sukses", "Data Berhasil di proses");
            $this->session->set_flashdata('message', $notif);
        } else {
            $notif = notification_proses("warning", "Gagal", "Data gagal di proses");
            $this->session->set_flashdata('message', $notif);
        }
        
        redirect("berita/$this->module");

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
            
            $del = $this->M_kategori->delete($id);

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
    
    public function checkKategori () {
        $this->output->unset_template();
        
        $cari = $this->input->post('q');
        
        if ($this->M_kategori->checkJumlahKategori($cari) > 0) {
            $data = array('disabled' => true, 'id' => 0, 'text' => 'Data telah terdaftar');
        } else {
            $data = array('disabled' => false, 'id' => $cari, 'text' => $cari);
        }
        
        echo json_encode(array($data));
    }
    
    public function srcKategori () {
        $this->output->unset_template();
        
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
    }
    
    protected function rules () {
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