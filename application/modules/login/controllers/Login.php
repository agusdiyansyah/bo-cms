<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MX_Controller {
	var $title = "TEAM NAME";
	function __construct(){
		parent::__construct();
		$this->load->model('M_login');
		$this->load->library('form_validation');
		$this->load->library('recaptcha');
		$this->lang->load('recaptcha');
	    $this->load->helper('form');
	}
	function index(){
		$data['title'] = $this->title;
		// $data['company'] = $config['name_website'];
		$data['form_action'] = site_url('login/login_proses');
		$data['html_captcha'] = $this->recaptcha->get_html();
		$data['userid'] = set_value('userid');
		$this->load->view('login', $data);
	}
	function login_proses(){
		//validasi form
		$this->form_validation->set_rules('userid', 'Nama', 'required|trim');
		$this->form_validation->set_rules('password', 'Sandi', 'required|trim');
		// $this->form_validation->set_rules('type', 'Tipe', 'required|trim');
		//$this->form_validation->set_rules('recaptcha_response_field', 'lang:recaptcha_field_name', 'required|callback_check_captcha');
		//jika validasi sukses
		if($this->form_validation->run($this) == TRUE){
			$userid = $this->input->post('userid');
			$password = $this->input->post('password');
			$type = $this->input->post('type');

			//cek user dan sandi di database
			if($this->M_login->cek($userid, $password) == TRUE){
				$admin = $this->M_login->getAdmin($userid, $password);
				$data['userid'] = $userid;
				$data['password'] = $password;
				$data['id_user'] = $admin->id_user;
				$data['level'] = $admin->level;
				$data['nama'] = $admin->nama;
				$data['status'] = $admin->status;
				$data['foto'] = $admin->foto;
				$data['login'] = TRUE;
				$this->session->set_userdata($data);
				redirect('dashboard');
			}
			else {
				$this->session->set_flashdata('message', 'Maaf, nama dan atau sandi Anda salah');
				redirect('login');
			}
			$this->M_login->cek($userid, $password);
		}
		else {
			$this->index();
		}
	}
	function cek_login($level = ""){		
		$status_login = $this->session->userdata('login');
		if (!isset($status_login) || $status_login != TRUE){
			redirect('login');
		}
		else {			
			if ($level) {				
				if (is_array($level)) { //cek apakah $level merupakan jenis array
					if (!in_array($this->session->userdata('level'), $level)) {//cek apakah level yg login masuk dalam array $level
						redirect('beranda');
					}
				}
				else {
					if ($this->session->userdata('level') != $level){
						redirect('login/forbiden');
					}
				}
			}
		}
	}
	function terlarang($level_forbiden){
		if ($this->session->userdata('level') == $level_forbiden) {
			redirect('login/forbiden');
		}
	}
	function logout(){
		$this->session->unset_userdata('userid');
		$this->session->unset_userdata('password');
		$this->session->unset_userdata('login');
		$this->session->unset_userdata('id_user');
		$this->session->unset_userdata('level');
		$this->session->unset_userdata('nama');
		$this->session->unset_userdata('status');
		$this->session->sess_destroy();
		redirect('login');
	}
	function forbiden()
	{
		$this->output->set_template('adminLTE/default');
        $this->output->set_title($this->title);
        $data['title'] = "Forbiden Area";
        $data['subtitle'] = "Hanya untuk level Admin";
		$this->load->view('forbiden', $data);
	}
	function check_captcha($val){
	  	if ($this->recaptcha->check_answer($this->input->ip_address(), $this->input->post('recaptcha_challenge_field'), $val))
		{
	    	return TRUE;
	  	}
		
	    $this->form_validation->set_message('check_captcha', $this->lang->line('recaptcha_incorrect_response'));
	    return FALSE;
	} 

}

/* End of file login.php */
/* Location: ./application/modules/login/controllers/login.php */