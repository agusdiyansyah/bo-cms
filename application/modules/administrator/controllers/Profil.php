<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profil extends Controller {
	public $title = "Profil User";
	public $id_type_category = 2;
	public $status = array(""=>"Status", 0=>"Nonaktif", 1=>"Aktif");
	public function __construct()
	{
		parent::__construct();
		$this->load->library('indo_date');
		$this->load->model('M_admin');
		$this->output->set_template('adminLTE/default');
        $this->output->set_title($this->title);
	}
	public function index()
	{
		$id_user = $this->session->userdata('id_user');
		$q = $this->M_admin->getById($id_user);
		if ($q->num_rows()>0) {
			$r = $q->row();
			$data = array(
				"id_user" => $r->id_user,
				"username" => $r->username,
				"nama" => $r->nama,
				"email" => $r->email,
				"foto" => $r->foto,
				"status" => $this->status[$r->status],
				"level" => $this->M_admin->getLevel($r->level),
				);
			$this->load->view('profil', $data);
		}
		else {
			redirect("dashboard");
		}
	}
	public function edit()
	{
		$id_user = $this->session->userdata('id_user');
		$q = $this->M_admin->getById($id_user);
		if ($q->num_rows()>0) {
			$r = $q->row();
			$data = array(
				"action" => site_url('administrator/profil/edit_proses'),
				"title" => "Profil",
				"subtitle" => "Edit",
				"mode" => "edit",
				"button" => "Edit",
				"id_user" => set_value('id_user', $r->id_user),
				"username" => set_value('username', $r->username),
				"nama" => set_value('nama', $r->nama),
				"email" => set_value('email', $r->email),
				"foto" => set_value('foto', $r->foto),
				"status" => $this->status[$r->status],
				"level" => $this->M_admin->getLevel($r->level),
				);
			$this->load->view('profil_form', $data);
		}
		else {
			redirect("dashboard");
		}
	}
	function edit_proses(){
		$id_user = $this->input->post('id_user');
		$this->load->library('form_validation');
		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('nama', 'Nama', 'required|trim');
		if ($this->form_validation->run() == FALSE){
			$msg_error = validation_errors('<span>', '</span>');
			$notif = notification_proses("error","Gagal",$msg_error);
            $this->session->set_flashdata('message', $notif);
			$this->edit();
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
				$data['password'] = md5($password);
			}
			$data['nama'] = $this->input->post('nama');
			$data['email'] = $this->input->post('email');
			$update = $this->M_admin->update($id_user, $data);
			$notif = notification_proses("success","Sukses","Data Berhasil di Edit");
            $this->session->set_flashdata('message', $notif);
			redirect('administrator/profil');
		}
	}

}

/* End of file Profil.php */
/* Location: ./application/modules/administrator/controllers/Profil.php */