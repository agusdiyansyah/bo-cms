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
		$this->output->set_title($data['title'] . " " . $data['subtitle']);
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
		
        $this->output->append_title($data['subtitle'] . " " . $data['title']);
        $this->load->view('form', $data);
	}
	
	// sampai sini udah ga kuat dah mate :D
	public function add_proses () {
		$this->output->unset_template();
		if ($this->input->post()) {
			$this->_rules();
			if ($this->form_validation->run() == FALSE){
				$this->msg = $this->_formPostProsesError();
			}
			else {
				if(is_uploaded_file($_FILES['foto']['tmp_name'])){
					$file_element_name = 'foto';
					$user_upload_path = 'assets/admin_foto/';

					$config['upload_path'] = './' . $user_upload_path;
					$config['allowed_types'] = 'jpg|jpeg|gif|png';
					$config['max_size']  = 1024 * 4;
					$config['encrypt_name'] = TRUE;

					$this->load->library('upload', $config);

					if (!$this->upload->do_upload($file_element_name))
					{
						$error = $this->upload->display_errors();
						$notif = notification_proses("error","Gagal",$error);
					    $this->session->set_flashdata('message', $notif);
						redirect('administrator/add');
					}
					else
					{
						$data_upload = $this->upload->data();

						$file_name = $data_upload["file_name"];

						$this->load->library('image_lib');
						$config_resize['image_library'] = 'gd2';	
						$config_resize['maintain_ratio'] = TRUE;
						$config_resize['master_dim'] = 'height';
						$config_resize['quality'] = "100%";
						$config_resize['source_image'] = './' . $user_upload_path . $file_name;
						$config_resize['new_image'] = './' . $user_upload_path .'thumb/';

						$config_resize['height'] = 251;
						$config_resize['width'] = 560;
						$this->image_lib->initialize($config_resize);
						$this->image_lib->resize();
						$data['foto'] = $file_name;
					}
				}
				$data['username'] = $this->input->post('username');
				$data['password'] = password_hash($this->input->post('password'),PASSWORD_BCRYPT);
				$data['nama'] = $this->input->post('nama');
				$data['level'] = $this->input->post('level');
				$data['email'] = $this->input->post('email');
				$data['status'] = $this->input->post('status');
				$insert = $this->M_admin->insert($data);
				$notif = notification_proses("success","Sukses","Data Berhasil di Tambah");
	            $this->session->set_flashdata('message', $notif);
				redirect('administrator');
			}
		} else {
			show_404();
		}
	}
	
	public function edit ($id){
		$query = $this->M_admin->getById($id);
		if ($query->num_rows() > 0) {
			$this->valid = true;
		}
		
		if ($this->valid) {
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
			
			$row = $query->row();
			
			$adminFoto = (empty($row->foto)) ? base_url('assets/themes/adminLTE/img/boxed-bg.png') : base_url("assets/admin_foto/thumb/$row->foto");
			
	        $data = array(
	            'title' => $this->title,
	            'subtitle' => 'Ubah',
	            'form_action' => site_url('administrator/edit_proses'),
				'link_back' => site_url('administrator'),
				
				"adminFoto" => $adminFoto, 
				"input" => array(
					"hide_id" => array(
	                    "name" => "id",
	                    "class" => "form-control hide_id",
						"id" => "hide_id",
	                    "type" => "hidden",
						"value" => $row->id_user
	                ),
					
					"level" => array(
	                    "config" => array(
	                        "name" => "level",
	                        "class" => "form-control select2 level",
	                        "id" => "level",
	                    ),
	                    "list" => $this->M_admin->level,
						"selected" => $row->level
	                ),
					"username" => array(
	                    "name" => "username",
	                    "class" => "form-control username",
						"id" => "username",
	                    "type" => "text",
						"value" => $row->username
	                ),
					"password" => array(
	                    "name" => "password",
	                    "class" => "form-control password",
						"id" => "password",
	                ),
					"nama" => array(
	                    "name" => "nama",
	                    "class" => "form-control nama",
						"id" => "nama",
	                    "type" => "text",
						"value" => $row->nama
	                ),
					"email" => array(
	                    "name" => "email",
	                    "class" => "form-control email",
						"id" => "email",
	                    "type" => "email",
						"value" => $row->email
	                ),
					"status" => array(
	                    "config" => array(
	                        "name" => "status",
	                        "class" => "form-control select2 status",
	                        "id" => "status",
	                    ),
	                    "list" => $this->M_admin->status,
						"selected" => $row->status
	                ),
	            )
	        );
	        $this->output->append_title($data['subtitle'] . " " . $data['title']);
	        $this->load->view('form', $data);
		} else {
			$notif = notification_proses("warning", "Gagal", "Data tidak ditemukan");
            $this->session->set_flashdata('message', $notif);
			redirect('administrator');
		}
	}

	public function edit_proses (){
		$id_user = $this->input->post('id');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('nama', 'Nama', 'required|trim');
		$this->form_validation->set_rules('level', 'Level', 'required');
		$this->form_validation->set_rules('status', 'Status', 'required');
		if ($this->form_validation->run() == FALSE){
			$msg_error = validation_errors('<span>', '</span>');
			$notif = notification_proses("error","Gagal",$msg_error);
            $this->session->set_flashdata('message', $notif);
			$this->edit($id);
		}
		else {
			if(is_uploaded_file($_FILES['foto']['tmp_name'])){
				$file_element_name = 'foto';
				$user_upload_path = 'assets/admin_foto/';

				$config['upload_path'] = './' . $user_upload_path;
				$config['allowed_types'] = 'jpg|jpeg|gif|png';
				$config['max_size']  = 1024 * 4;
				$config['encrypt_name'] = TRUE;

				$this->load->library('upload', $config);

				if (!$this->upload->do_upload($file_element_name))
				{
					$error = $this->upload->display_errors();
					$notif = notification_proses("error","Gagal",$error);
				    $this->session->set_flashdata('message', $notif);
					redirect('administrator/add');
				}
				else
				{
					$data_upload = $this->upload->data();

					$file_name = $data_upload["file_name"];

					$this->load->library('image_lib');
					$config_resize['image_library'] = 'gd2';	
					$config_resize['maintain_ratio'] = TRUE;
					$config_resize['master_dim'] = 'height';
					$config_resize['quality'] = "100%";
					$config_resize['source_image'] = './' . $user_upload_path . $file_name;
					$config_resize['new_image'] = './' . $user_upload_path .'thumb/';

					$config_resize['height'] = 251;
					$config_resize['width'] = 560;
					$this->image_lib->initialize($config_resize);
					$this->image_lib->resize();
					$data['foto'] = $file_name;
				}
			}
			$data['username'] = $this->input->post('username');
			$password = $this->input->post('password');
			if ($password != "") {
				$data['password'] = password_hash($password,PASSWORD_BCRYPT);
			}
			$data['nama'] = $this->input->post('nama');
			$data['level'] = $this->input->post('level');
			$data['email'] = $this->input->post('email');
			$data['status'] = $this->input->post('status');
			$update = $this->M_admin->update($id_user, $data);
			$notif = notification_proses("success","Sukses","Data Berhasil di Edit");
            $this->session->set_flashdata('message', $notif);
			redirect('administrator');
		}
	}
	
	public function delete (){
		$id = $this->input->post('id');
		$row = $this->M_admin->getById($id);
        if ($row) {
			$data = $row->row();
			$upload_path = "./assets/admin_foto/";
			
            $this->M_admin->delete($id);
			if (file_exists($upload_path . $data->foto)) {
				if (unlink($upload_path . $data->foto) AND file_exists($upload_path . "thumb/" . $data->foto)) {
					unlink($upload_path . "thumb/" . $data->foto);
				}
			}
			
            $notif = notification_proses("success","Sukses","Data Berhasil di Hapus $exists");
            $this->session->set_flashdata('message', $notif);
        } else {
            $notif = notification_proses("danger","Gagal", "Data Gagal di Hapus");
            $this->session->set_flashdata('message', $notif);
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
		if (!empty($data['photo'])) {
			
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
	
	private function _formPostInputData () {
	
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
	
	private function _rules () {
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
                "field" => "password",
                "label" => "Password",
                "rules" => "required",
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
        
        $this->form_validation->set_error_delimiters("<div class=''>", "</div>");
        $this->form_validation->set_rules($config);
	}
}

/* End of file admin.php */
/* Location: ./application/modules/admin/controllers/admin.php */