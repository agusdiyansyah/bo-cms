<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Media extends Controller {
    
    private $valid = false;
    private $stat = false;

    public function __construct() {
        parent::__construct();
        
        $this->load->model("media/M_galeri");
        $this->load->model("M_image");
    }

    public function index($unset = 0) {
        if ($unset) {
            $this->output->unset_template();
        }
        
        $data = array(
            'editor' => $unset,
            'content' => array(
                'view' => 'media/partial/all_data',
            )
        );
        
        $this->load->view('media/data', $data);
    }
    
    public function editor () {
        $this->index(1);
    }
    
    public function getDataImage () {
        if ($this->input->post()) {
            $this->valid = true;
        }
        
        if ($this->valid) {
            $this->output->unset_template();
            
            $id_galeri = (empty($this->input->post('id'))) ? 0 : $this->input->post('id');
            
            $sql = $this->M_image->data($id_galeri)->result();
            $res = array();
            foreach ($sql as $data) {
                array_push($res, array(
                    'id_file' => $data->id_file,
                    'title' => $data->title,
                    'file' => $data->file,
                ));
            }
            if (count($res) > 0) {
                $this->stat = true;
            }
            echo json_encode(array(
                'stat' => $this->stat,
                'data' => $res
            ));
        } else {
            show_404();
        }
    }
    
    public function getDataGaleri () {
        if ($this->input->post()) {
            $this->valid = true;
        }
        
        if ($this->valid) {
            $this->output->unset_template();
            
            $id = $this->input->post('id'); 
            
            $sql = $this->M_galeri->data($id)->result();
            $res = array();
            foreach ($sql as $data) {
                array_push($res, array(
                    'id_galeri' => $data->id_galeri,
                    'title' => $data->title,
                    'status' => $data->status,
                ));
            }
            if (count($res) > 0) {
                $this->stat = true;
            }
            echo json_encode(array('stat' => $this->stat, 'data' => $res));
        } else {
            show_404();
        }
    }

}