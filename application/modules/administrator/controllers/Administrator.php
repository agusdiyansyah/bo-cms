<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Administrator extends Controller {
	public $id_type_category = 2;
	
	private $module = "administrator";
	private $stat   = false;
	private $valid = false;
	private $msg = "Data gagal di proses";
	private $ImageUploadPath = "./assets/admin_foto/";
	private $status = array(
		"" => "Status", 
		0 => "Unpublish", 
		1 => "Publish"
	);
	
	public function __construct() {
		parent::__construct();
		$this->load->model('M_admin');
		$this->output->set_title(ucwords($this->module));
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
			"link_add" => site_url('administrator/add'),
			"input" => array(
                "nama" => array(
                    "name" => "nama",
                    "class" => "form-control nama",
					"id" => "nama",
                    "type" => "text"
                ),
				"level" => array(
                    "config" => array(
                        "name" => "level",
                        "class" => "form-control select2 level",
                        "id" => "level",
                    ),
                    "list" => $this->M_admin->level
                ),
				"status" => array(
                    "config" => array(
                        "name" => "status",
                        "class" => "form-control select2 status",
                        "id" => "status",
                    ),
                    "list" => $this->M_admin->status
                )
            ),
		);
		$this->output->append_title($data['subtitle']);
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
	    	echo $this->M_admin->data($_POST);
    	}
    	return;
	}
	
	public function add (){
		$this->_formAssets();
		
        $data = $this->_formInputData(array(
			"subtitle" => "Tambah Data",
			"form_action" => "add_proses",
		));
		
        $this->output->append_title($data['subtitle']);
        $this->load->view('form', $data);
	}
	
	public function add_proses () {
		$this->output->unset_template();
		if ($this->input->post()) {
			$this->_rules();
			if ($this->form_validation->run() == FALSE){
				$this->msg = $this->_formPostProsesError();
			}
			else {
				$photo = "";
                if (is_uploaded_file($_FILES['foto']['tmp_name'])) {
                    $this->load->library('image');
                    $upload = $this->image->upload(array(
						"file_element_name" => "foto",
						"max_size" => 1024*4,
						"crop_width" => 215,
						"crop_height" => 215,
						"resize_width" => 560,
						"resize_height" => 251,
                        "upload_path" => $this->ImageUploadPath
                    ));
                    if ($upload['stat']) {
                        $photo = $upload['file_name'];
                    } else {
						$notif = notification_proses("error","Gagal", $upload['msg']);
					    $this->session->set_flashdata('message', $notif);
						redirect('administrator/add');
                    }
                }
				$data = $this->_formPostInputData($photo);
				$insert = $this->M_admin->insert($data);
				
				if ($insert) {
					$this->stat = true;
				}
			}
			if ($this->stat) {
				$notif = notification_proses("success", "Sukses", "Data Berhasil di Tambah");
	            $this->session->set_flashdata('message', $notif);
				$_backto = "$this->module";
			} else {
				$notif = notification_proses("warning", "Gagal", $this->msg);
	            $this->session->set_flashdata('message', $notif);
				$_backto = "$this->module/add";
			}
			redirect($_backto);
		} else {
			show_404();
		}
	}
	
	public function edit ($id){
		$query = $this->M_admin->getById($id);
		if (
			$query->num_rows() > 0 AND
			$id > 0
		) {
			$this->_formAssets();
			$row = $query->row();
			
			$photo = (empty($row->foto)) ? base_url('assets/themes/adminLTE/img/boxed-bg.png') : base_url("assets/admin_foto/thumb/$row->foto");
			
			$data = $this->_formInputData(array(
				"subtitle" => "Ubah Data",
				"form_action" => "edit_proses",
				"id" => $id,
				"level" => $row->level,
				"foto" => $row->foto,
				"username" => $row->username,
				"nama" => $row->nama,
				"email" => $row->email,
				"status" => $row->status,
			));
			
	        $this->output->append_title($data['subtitle']);
	        $this->load->view('form', $data);
		} else {
			show_404();
		}
	}

	public function edit_proses () {
		$this->output->unset_template();
		$id_user = $this->input->post('id');
		$sql = $this->M_admin->getById($id_user);
		if (
			$this->input->post() AND
			!empty($id_user) AND
			$id_user > 0 AND
			$sql->num_rows() > 0
		) {
			$this->_rules("edit");
			
			if (!$this->form_validation->run()) {
				$this->msg = $this->_formPostProsesError();
			} else {
				$image = $sql->row();
				$photo = @$image->foto;
                if (is_uploaded_file($_FILES['foto']['tmp_name'])) {
                    $this->load->library('image');
                    $upload = $this->image->upload(array(
						"file_element_name" => "foto",
						"max_size" => 1024 * 4,
						"crop_width" => 215,
						"crop_height" => 215,
						"resize_width" => 560,
						"resize_height" => 251,
                        "upload_path" => $this->ImageUploadPath,
						"update" => @$image->foto
                    ));
                    if ($upload['stat']) {
                        $photo = $upload['file_name'];
                    } else {
						$notif = notification_proses("error","Gagal", $upload['msg']);
					    $this->session->set_flashdata('message', $notif);
						redirect("administrator/edit/$id_user");
                    }
                }
				$data = $this->_formPostInputData($photo);
				$update = $this->M_admin->update($id_user, $data);
				
				if ($update) {
					$this->stat = true;
				}
			}
			if ($this->stat) {
				$notif = notification_proses("success", "Sukses", "Data Berhasil di Proses");
	            $this->session->set_flashdata('message', $notif);
				if ($id_user == $this->session->userdata("id_user")) {
					Modules::run('login/logout');
				} else {
					$_backto = "$this->module";
				}
			} else {
				$notif = notification_proses("warning", "Gagal", $this->msg);
	            $this->session->set_flashdata('message', $notif);
				$_backto = "$this->module/edit/$id_user";
			}
			redirect($_backto);
		} else {
			show_404();
		}
	}
	
	public function delete () {
		$this->output->unset_template();
		$id = $this->input->post('id');
		$row = $this->M_admin->getById($id);
		if (
			!empty($id) AND
			$id > 0 AND
			$row->num_rows() > 0
		) {
			$data = $row->row();
            $del = $this->M_admin->delete($id);
			
			if (file_exists($this->ImageUploadPath . $data->foto)) {
				if (unlink($this->ImageUploadPath . $data->foto) AND file_exists($this->ImageUploadPath . "thumb/" . $data->foto)) {
					unlink($this->ImageUploadPath . "thumb/" . $data->foto);
				}
			}
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
	
	public function cari (){
		$ses['Admin_cari_nama'] = $this->input->post('nama');
        $ses['Admin_cari_status'] = $this->input->post('status');        
        $ses['Admin_cari_level'] = $this->input->post('level');        
        $this->session->set_userdata( $ses );
        redirect('administrator');
	}
	
	private function _formAssets () {
		// select2
        $this->output->css('assets/themes/adminLTE/plugins/select2/select2.min.css');
		$this->output->css('assets/themes/adminLTE/plugins/select2/select2-bootstrap.css');
		$this->output->js('assets/themes/adminLTE/plugins/select2/select2.min.js');
		
		// validate
        $this->output->js('assets/themes/adminLTE/plugins/jquery-validation/jquery.validate.js');
		$this->output->js('assets/themes/adminLTE/plugins/jquery-validation/localization/messages_id.js');
		
		// fileinput
        $this->output->css("assets/themes/adminLTE/plugins/file-input/fileinput.min.css");
		$this->output->css("assets/themes/adminLTE/css/file-input-custom.css");
        $this->output->js("assets/themes/adminLTE/plugins/file-input/fileinput.min.js");
	}
	
	private function _formInputData ($data) {
		$photo = "";
		if (!empty($data['foto'])) {
			$baseImage = str_replace(".", "", $this->ImageUploadPath);
			$photo = base_url($baseImage . $data['foto']);
		}
		
		return array(
			"title" => ucwords($this->module),
			"subtitle" => @$data['subtitle'],
			"link_back" => site_url($this->module),
			"moduleLink" => base_url($this->module),
			"ImageUploadPath" => $this->ImageUploadPath,
			"form_action" => base_url($this->module . "/" . $data['form_action']),
			
			"photo" => $photo,
			
			"input" => array(
				"hide" => array(
                    "id" => array(
						"name" => "id",
	                    "class" => "form-control hide_id",
						"id" => "hide_id",
	                    "type" => "hidden",
						"value" => @$data['id']
					)
                ),
				
				"level" => array(
                    "config" => array(
                        "name" => "level",
                        "class" => "form-control select2 level",
                        "id" => "level",
                    ),
                    "list" => $this->M_admin->level,
					"selected" => @$data['level']
                ),
				"username" => array(
                    "name" => "username",
                    "class" => "form-control username",
					"id" => "username",
                    "type" => "text",
					"value" => @$data['username'],
                ),
				"password" => array(
                    "name" => "password",
                    "class" => "form-control password",
					"id" => "password",
					"value" => @$data['password'],
                ),
				"nama" => array(
                    "name" => "nama",
                    "class" => "form-control nama",
					"id" => "nama",
                    "type" => "text",
					"value" => @$data['nama'],
                ),
				"email" => array(
                    "name" => "email",
                    "class" => "form-control email",
					"id" => "email",
                    "type" => "email",
					"value" => @$data['email'],
                ),
				"status" => array(
                    "config" => array(
                        "name" => "status",
                        "class" => "form-control select2 status",
                        "id" => "status",
                    ),
                    "list" => $this->M_admin->status,
					"selected" => @$data['status']
                ),
            )
        );
	}
	
	private function _formPostInputData ($photo) {
		if (!empty($this->input->post('password'))) {
			$data["password"] = password_hash($this->input->post('password'), PASSWORD_BCRYPT);
		}
		$data["foto"] = $photo;
		$data["username"] = $this->input->post('username');
		$data["nama"] = $this->input->post('nama');
		$data["level"] = $this->input->post('level');
		$data["email"] = $this->input->post('email');
		$data["status"] = $this->input->post('status');

		return $data;
	}
	
	private function _formPostProsesError () {
		$errorMsg = "";
        if (form_error("username")) {
            $errorMsg .= form_error("username");
        }
        if (form_error("password")) {
            $errorMsg .= form_error("password");
        }
        if (form_error("nama")) {
            $errorMsg .= form_error("nama");
        }
		if (form_error("level")) {
            $errorMsg .= form_error("level");
        }
		if (form_error("status")) {
            $errorMsg .= form_error("status");
        }
        
        return $errorMsg;
	}
	
	private function _rules ($tipe = "add") {
		$this->load->library('form_validation');
        $this->load->helper('security');
        
        $config = array(
            array(
                "field" => "username",
                "label" => "Username",
                "rules" => "required|xss_clean",
                "errors" => array(
                    "required" => "%s tidak boleh kosong"
                )
            ),
            array(
                "field" => "nama",
                "label" => "Nama",
                "rules" => "required|trim",
                "errors" => array(
                    "required" => "%s tidak boleh kosong"
                )
            ),
			array(
                "field" => "level",
                "label" => "Level",
                "rules" => "required",
                "errors" => array(
                    "required" => "%s tidak boleh kosong"
                )
            ),
			array(
                "field" => "status",
                "label" => "Status",
                "rules" => "required",
                "errors" => array(
                    "required" => "%s tidak boleh kosong"
                )
            ),
        );
		
		if ($tipe == "add") {
			array_push($config, array(
                "field" => "password",
                "label" => "Password",
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

/* End of file admin.php */
/* Location: ./application/modules/admin/controllers/admin.php */