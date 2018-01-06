<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends Controller {
    private $title = "Menu Admin Manajemen";
    private $valid = false;
    private $msg = "Data gagal di proses";
    private $module = "menu";
    private $submodule = "admin";
    private $moduleLink;
    private $stat   = false;
    
	public function __construct() {
		parent::__construct();
        $this->load->model('M_menu');
        $this->load->model('Administrator/M_admin');
        $this->output->set_title($this->title);
        $this->moduleLink = "$this->module/$this->submodule/";
    }   
    
    public function index () {
        Modules::run('login/terlarang', 10);
        
        // select2
        $this->output->css('assets/themes/adminLTE/plugins/select2/select2.min.css');
		$this->output->css('assets/themes/adminLTE/plugins/select2/select2-bootstrap.css');
		$this->output->js('assets/themes/adminLTE/plugins/select2/select2.min.js');
        
        // datatables
        $this->output->css('assets/themes/adminLTE/plugins/datatables/dataTables.bootstrap.css');
        $this->output->js('assets/themes/adminLTE/plugins/datatables/jquery.dataTables.min.js');
        $this->output->js('assets/themes/adminLTE/plugins/datatables/dataTables.bootstrap.min.js');
        
        // magnific popup
        $this->output->css('assets/themes/adminLTE/plugins/magnific-popup/magnific-popup.css');
		$this->output->js('assets/themes/adminLTE/plugins/magnific-popup/magnific-popup.js');
        
        $getParent = $this->M_menu->getParent();
        $combobox_parent = combobox_dynamic("combobox_parent", $getParent, "name", "id_menu", $this->session->userdata('Menu_cari_parent'));
        
        $data = array(
            'title' => $this->title,
            'subtitle' => 'Data',
            'link_add' => site_url("$this->moduleLink/add"),
            'combobox_parent' => $combobox_parent,
            'cari_name' => set_value('cari_name', $this->session->userdata('Menu_cari_name')),
        );
        $this->output->append_title($data['subtitle']);
		$this->load->view('admin/data', $data);
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
	    	echo $this->M_menu->data($_POST);
    	}
    	return;
	}
    
    public function add() {
        $this->_formAssets();
        
        $data = array(
            'title' => 'Tambah Data Menu Admin',
            'button' => 'Tambah',
            'action' => site_url('menu/admin/add_proses'),
            'id_menu' => set_value('id_menu'),
            'name' => set_value('name'),
            'link' => set_value('link'),
            'icon' => set_value('icon'),
            'order' => set_value('order', $this->M_menu->getLastOrder()),
            'is_active' => set_value('is_active'),
            'is_parent' => set_value('is_parent'),
            'level' => $this->M_admin->combobox_level(set_value('level')),
        );
        $this->output->set_template('adminLTE/default');
        $this->load->view('admin/form', $data);
    }
    
    public function add_proses() {
        $this->load->library('form_validation');
        $this->_rules();
        if ($this->form_validation->run() == FALSE) {
            $this->add();
        } 
        else {
            $data = array(
        		'name' => $this->input->post('name',TRUE),
        		'link' => $this->input->post('link',TRUE),
                'icon' => $this->input->post('icon',TRUE),
        		'order' => $this->input->post('order',TRUE),
        		'is_active' => $this->input->post('is_active',TRUE),
                'is_parent' => $this->input->post('is_parent',TRUE),
        		'level' => $this->input->post('level',TRUE),
    	    );
            $this->M_menu->insert($data);
            $notif = notification_proses("success","Sukses","Data Berhasil di Tambah");
            $this->session->set_flashdata('message', $notif);
            redirect(site_url('menu/admin'));
        }
    }
    
    public function edit($id) {
        $row = $this->M_menu->get_by_id($id);

        if ($row) {
            // select2
            $this->output->css('assets/themes/adminLTE/plugins/select2/select2.min.css');
    		$this->output->css('assets/themes/adminLTE/plugins/select2/select2-bootstrap.css');
    		$this->output->js('assets/themes/adminLTE/plugins/select2/select2.min.js');
            
            $data = array(
                'title' => 'Edit Data Menu Admin',
                'button' => 'Update',
                'action' => site_url('menu/admin/edit_proses'),
        		'id_menu' => set_value('id_menu', $row->id_menu),
        		'name' => set_value('name', $row->name),
        		'link' => set_value('link', $row->link),
                'icon' => set_value('icon', $row->icon),
        		'order' => set_value('order', $row->order),
        		'is_active' => set_value('is_active', $row->is_active),
                'is_parent' => set_value('is_parent', $row->is_parent),
        		'level' => $this->M_admin->combobox_level(set_value('level', $row->level))
            );
            $this->load->view('menu/admin/form', $data);
        } else {
            $notif = notification_proses("danger","Gagal","Data Tidak di Temukan");
            $this->session->set_flashdata('message', $notif);
            redirect(site_url('menu/admin'));
        }
    }
    
    public function edit_proses() {
        $this->load->library('form_validation');
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_menu', TRUE));
        } else {
            $data = array(
        		'name' => $this->input->post('name',TRUE),
        		'link' => $this->input->post('link',TRUE),
                'icon' => $this->input->post('icon',TRUE),
        		'order' => $this->input->post('order',TRUE),
        		'is_active' => $this->input->post('is_active',TRUE),
                'is_parent' => $this->input->post('is_parent',TRUE),
        		'level' => $this->input->post('level',TRUE),
    	    );

            $this->M_menu->update($this->input->post('id_menu', TRUE), $data);
            $notif = notification_proses("success","Sukses","Data Berhasil di Edit");
            $this->session->set_flashdata('message', $notif);
            redirect(site_url('menu/admin'));
        }
    }
    
    public function delete() {
        $id = $this->input->post('id');
        $row = $this->M_menu->get_by_id($id);
        if ($row) {
            $this->M_menu->delete($id);
            $notif = notification_proses("success","Sukses","Data Berhasil di Hapus");
            $this->session->set_flashdata('message', $notif);
            // redirect(site_url('menu/admin'));
        } else {
            $notif = notification_proses("danger","Gagal","Data Gagal di Hapus");
            $this->session->set_flashdata('message', $notif);
            // redirect(site_url('menu/admin'));
        }
    }
    
    public function cari() {
        $ses['Menu_cari_name'] = $this->input->post('name');
        $ses['Menu_cari_parent'] = $this->input->post('combobox_parent');
        $this->session->set_userdata( $ses );
        redirect('menu/admin');
    }
    
    public function getLastOrderByIdParent () {
        $this->output->unset_template();
        if (
            !empty($this->input->post('id')) AND
            $this->input->post('id') > 0
        ) {
            $this->valid = true;
        }
        
        if ($this->valid) {
            $id = $this->input->post('id');
            
            $order = $this->M_menu->getLastOrder($id);
        }
        
        echo json_encode(array("order" => $order));
    }

    public function order($status, $id_menu) {
        $row = $this->M_menu->get_by_id($id_menu);
        if ($row) {
            if ($status=="up") {
                $order = $row->order+1;
            }
            else {
                $order = $row->order;
                if ($row->order > 1) {
                    $order = $row->order-1;
                }
            }
            $data['order'] = $order;
            $this->db->where('id_menu', $id_menu);
            $this->db->update('menu_admin', $data);
            $notif = notification_proses("success","Berhasil","Data Berhasil di Proses");
            $this->session->set_flashdata('message', $notif);
            redirect(site_url('menu/admin'));
        }
        else {
            redirect('menu/admin');
        }
    }

	public function tampil() {
        $this->output->unset_template();
        $menu = $this->M_menu->recursive();
        echo $menu;
	}	
    
    private function _formAssets () {
        // select2
        $this->output->css('assets/themes/adminLTE/plugins/select2/select2.min.css');
		$this->output->css('assets/themes/adminLTE/plugins/select2/select2-bootstrap.css');
		$this->output->js('assets/themes/adminLTE/plugins/select2/select2.min.js');
        
        // validate
        $this->output->js('assets/themes/adminLTE/plugins/jquery-validation/jquery.validate.js');
		$this->output->js('assets/themes/adminLTE/plugins/jquery-validation/localization/messages_id.js');
    }
    
    private function _formInputData ($data) {
        $data = array(
            'title' => 'Tambah Data Menu Admin',
            'button' => 'Tambah',
            'action' => site_url('menu/admin/add_proses'),
            'id_menu' => set_value('id_menu'),
            'name' => set_value('name'),
            'link' => set_value('link'),
            'icon' => set_value('icon'),
            'order' => set_value('order', $this->M_menu->getLastOrder()),
            'is_active' => set_value('is_active'),
            'is_parent' => set_value('is_parent'),
            'level' => $this->M_admin->combobox_level(set_value('level')),
        );
        return array(
            "title" => $this->title,
            "subtitle" => @$data['subtitle'],
            "link_back" => site_url($this->moduleLink),
            "form_action" => base_url($this->moduleLink . $data['form_action']),
            
            "input" => array(
                "hide" => array(
                    "id" => array(
                        "name" => "id",
                        "class" => "id",
                        "type" => "hidden",
                        "value" => @$data['id']
                    )
                ),
                
                "nama" => array(
                    "name" => "nama",
                    "type" => "text",
                    "class" => "form-control nama",
                    "value" => @$data['nama']
                ),
            )
        );
    }
    
    private function _formPostInputData () {
    
    }
    
    private function _formPostProsesError () {
    
    }
    
    private function _rules() {
    	$this->form_validation->set_rules('name', 'name', 'trim|required');
    	$this->form_validation->set_rules('link', 'link', 'trim|required');
    	$this->form_validation->set_rules('is_active', 'is active', 'trim|required');
    	$this->form_validation->set_rules('is_parent', 'is parent', 'trim|required');

    	$this->form_validation->set_rules('id', 'id', 'trim');
    	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }
}

/* End of file admin.php */
/* Location: ./application/modules/menu/controllers/admin.php */