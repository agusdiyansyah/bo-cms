<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Administrator extends Controller {
	public $title = "Administrator";
	public $id_type_category = 2;
	public $status = array(""=>"Status", 0=>"Unpublish", 1=>"Publish");
	protected $valid = false;
	
	public function __construct()
	{
		parent::__construct();
		$this->load->library('indo_date');
		$this->load->model('M_admin');
        $this->output->set_title($this->title);
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
			"title" => $this->title,
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
	
	function add(){
		// select2
        $this->output->css('assets/themes/adminLTE/plugins/select2/select2.min.css');
		$this->output->css('assets/themes/adminLTE/plugins/select2/select2-bootstrap.css');
		$this->output->js('assets/themes/adminLTE/plugins/select2/select2.min.js');
		
		// validate
        $this->output->js('assets/themes/adminLTE/plugins/jquery-validation/jquery.validate.js');
		$this->output->js('assets/themes/adminLTE/plugins/jquery-validation/localization/messages_id.js');
		
        $data = array(
            'title' => $this->title,
            'subtitle' => 'Tambah',
            'form_action' => site_url('administrator/add_proses'),
			'link_back' => site_url('administrator'),
			
			"input" => array(
				"hide_id" => array(
                    "name" => "id",
                    "class" => "form-control hide_id",
					"id" => "hide_id",
                    "type" => "hidden"
                ),
				
				"level" => array(
                    "config" => array(
                        "name" => "level",
                        "class" => "form-control select2 level",
                        "id" => "level",
                    ),
                    "list" => $this->M_admin->level
                ),
				"username" => array(
                    "name" => "username",
                    "class" => "form-control username",
					"id" => "username",
                    "type" => "text"
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
                    "type" => "text"
                ),
				"email" => array(
                    "name" => "email",
                    "class" => "form-control email",
					"id" => "email",
                    "type" => "email"
                ),
				"status" => array(
                    "config" => array(
                        "name" => "status",
                        "class" => "form-control select2 status",
                        "id" => "status",
                    ),
                    "list" => $this->M_admin->status
                ),
            )
        );
        $this->output->append_title($data['subtitle'] . " " . $data['title']);
        $this->load->view('form', $data);
	}
	function add_proses(){
		$this->load->library('form_validation');
		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');
		$this->form_validation->set_rules('nama', 'Nama', 'required|trim');
		$this->form_validation->set_rules('level', 'Level', 'required');
		$this->form_validation->set_rules('status', 'Status', 'required');
		if ($this->form_validation->run() == FALSE){
			$msg_error = validation_errors('<span>', '</span>');
			$notif = notification_proses("error","Gagal",$msg_error);
            $this->session->set_flashdata('message', $notif);
			$this->add();
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
	}
	
	function edit($id){
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
			
			$row = $query->row();
			
	        $data = array(
	            'title' => $this->title,
	            'subtitle' => 'Ubah',
	            'form_action' => site_url('administrator/edit_proses'),
				'link_back' => site_url('administrator'),
				
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

	function edit_proses(){
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
	function delete(){
		$id = $this->input->post('id');
		$row = $this->M_admin->getById($id);
        if ($row) {
            $this->M_admin->delete($id);
            $notif = notification_proses("success","Sukses","Data Berhasil di Hapus");
            $this->session->set_flashdata('message', $notif);
        } else {
            $notif = notification_proses("danger","Gagal","Data Gagal di Hapus");
            $this->session->set_flashdata('message', $notif);
        }
	}
	function cari(){
		$ses['Admin_cari_nama'] = $this->input->post('nama');
        $ses['Admin_cari_status'] = $this->input->post('status');        
        $ses['Admin_cari_level'] = $this->input->post('level');        
        $this->session->set_userdata( $ses );
        redirect('administrator');
	}
}

/* End of file admin.php */
/* Location: ./application/modules/admin/controllers/admin.php */