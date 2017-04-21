<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MX_Controller {
	public function __construct()
	{
		parent::__construct();
        $this->output->set_template('kancil/default');
	}

	public function index()
	{
		$my_team = webinfo();
		$data['my_team'] = $my_team;
		$data['slideshow'] = modules::run('slideshow/publik/widget');
		
		// widget latest result
		$this->load->model('pertandingan/M_widget', 'ls');
		$ls = $this->ls->latestResult();
		if ($ls->num_rows()>0) {
			$data['ls_status'] = true; 
			$data['ls'] = $ls->row();
		}
		else {
			$data['ls_status'] = false; 
			$data['ls'] = null;
		}

		// head_coach
		$this->load->model('pengurus/M_pengurus');
		$data['head_coach'] = $this->db->select('*')->where("id_jabatan", 0)->limit(1)->get('pengurus')->row();

		// berita terbaru
		$this->load->model('berita/M_publik', 'M_berita');
		$data['berita_query'] = $this->M_berita->latestNews(2)->result();

		// jadwal
		$this->db->where('match_status', 'jadwal');
		$this->db->order_by('match_date');
		$query_jadwal = $this->db->get('match', 5);
		$data['jadwal'] = $query_jadwal->result();

		// pengurus
		$this->db->join('pengurus_jabatan', 'pengurus.id_jabatan = pengurus_jabatan.id_jabatan', 'left');
		$data['pengurus'] = $this->db->get('pengurus', 4)->result();

		// player
		$this->db->where('no_jersey IN(2,5,7,8)');
		$data['pemain'] = $this->db->get('pemain')->result();

		// trophy
		$this->db->order_by('tahun', 'desc');
		$data['trophy'] = $this->db->get('trophy', 6)->result();

		$this->load->view('home', $data);
	}

}

/* End of file Home.php */
/* Location: ./application/modules/home/controllers/Home.php */