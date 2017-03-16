<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Galeri extends Controller{
    
    private $valid = false;
    private $stat = false;
    private $msg = "Data gagal di proses";

    public function __construct() {
        parent::__construct();
        
        $this->load->model("media/M_galeri");
    }

    public function tambahProses () {
        $this->output->unset_template();
        if ($this->input->post()) {
            $this->load->library('form_validation');

            $this->load->helper('security');

            $config = array(
                array(
                    "field" => "title",
                    "label" => "Nama Galeri",
                    "rules" => "required|xss_clean",
                    "errors" => array(
                        "required" => "%s tidak boleh kosong"
                    )
                )
            );

            $this->form_validation->set_error_delimiters("<div class='text-danger'>", "</div>");

            $this->form_validation->set_rules($config);
            if (!$this->form_validation->run()) {
                $this->msg = validation_errors("<div class='text-danger'>", "</div>");
            } else {
                $this->load->library('slug');
                $data = array(
                    "title" => $this->input->post('title'),
                    "slug" => $this->slug->createSlugDB($this->input->post('title'), "galeri", "slug"),
                    "status" => $this->input->post('publish'),
                    "keterangan" => $this->input->post('keterangan'),
                );
                
                $add = $this->M_galeri->add($data);
                if ($add) {
                    $this->stat = true;
                    $this->msg = "Data berhasil di proses";
                }
            }
            
            echo json_encode(array(
                'stat' => $this->stat,
                'msg' => $this->msg,
            ));
        } else {
            show_404();
        }
    }
    
    public function ubahProses () {
        $this->output->unset_template();
        if ($this->input->post()) {
            $this->load->library('form_validation');

            $this->load->helper('security');

            $config = array(
                array(
                    "field" => "id",
                    "label" => "",
                    "rules" => "required",
                    "errors" => array(
                        "required" => "Data gagal di proses"
                    )
                ),
                array(
                    "field" => "title",
                    "label" => "Nama Galeri",
                    "rules" => "required|xss_clean",
                    "errors" => array(
                        "required" => "%s tidak boleh kosong"
                    )
                )
            );

            $this->form_validation->set_error_delimiters("<div class='text-danger'>", "</div>");

            $this->form_validation->set_rules($config);
            if (!$this->form_validation->run()) {
                $this->msg = validation_errors("<div class='text-danger'>", "</div>");
            } else {
                $id = $this->input->post('id');
                $data = array(
                    "title" => $this->input->post('title'),
                    "status" => $this->input->post('publish'),
                    "keterangan" => $this->input->post('keterangan'),
                );
                
                $up = $this->M_galeri->update($data, $id);
                if ($up) {
                    $this->stat = true;
                    $this->msg = "Data berhasil di proses";
                }
            }
            
            echo json_encode(array(
                'stat' => $this->stat,
                'msg' => $this->msg,
            ));
        } else {
            show_404();
        }
    }
    
    public function hapus () {
        $this->output->unset_template();
        if (
            $this->input->post() AND
            $this->input->post('id') > 0
        ) {
            $this->valid = true;
        }
        
        if ($this->valid) {
            $id = $this->input->post('id');
            $del = $this->M_galeri->hapus($id);
            if ($del) {
                $this->stat = true;
                $this->msg  = "Data berhasil di proses";
            }
            
            echo json_encode(array(
                'stat' => $this->stat,
                'msg'  => $this->msg,
            ));
        } else {
            show_404();
        }
    }
    
    public function getDataById () {
        $this->output->unset_template();
        if (
            $this->input->post() AND
            $this->input->post('id') > 0
        ) {
            $this->valid = true;
        }
        
        if ($this->valid) {
            $id = $this->input->post('id');
            $data = $this->M_galeri->getDataById($id)->row();
            $res = array();
            if (count($data) > 0) {
                $this->stat = true;
                $res = array(
                    'title' => $data->title,
                    'status' => $data->status,
                    'keterangan' => $data->keterangan
                );
            }
            
            echo json_encode(array(
                'stat' => $this->stat,
                'data' => $res
            ));
        } else {
            show_404();
        }
        
    }

}