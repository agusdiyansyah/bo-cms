<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Image extends Controller {
    
    private $msg = "Data gagal di proses";
    private $valid = false;
    private $stat = false;
    
    // image
    private $ResizeWidth = 350;
    private $ResizeHeight = 350;
    
    private $file_name = "";

    public function __construct() {
        parent::__construct();
        $this->load->model("M_image");
    }

    public function index() {
        
    }
    
    public function tambahProses () {
        $this->output->unset_template();
        $upload = $this->_imageUpload(array(
            "upload_path" => "./assets/upload/images/"
        ));
        if ($upload) {
            $data = array(
                "title" => $this->input->post('title'),
                "id_galeri" => $this->input->post('galeri'),
                "keterangan" => $this->input->post('keterangan'),
                "file" => $this->file_name
            );
            $add = $this->M_image->add($data);
            if ($add) {
                $this->stat = true;
                $this->msg = "Data berhasil di proses";
            } else {
                if (file_exists($upload_path . $file_name)) {
                    unlink($upload_path . $file_name);
                }
            }
        }
        
        echo json_encode(array(
            'stat' => $this->stat,
            'msg' => $this->msg,
        ));
    }
    
    public function ubahProses () {
        $this->output->unset_template();
        if (
            $this->input->post('id') AND
            $this->input->post('id') > 0
        ) {
            $this->valid = true;
        }
        
        if ($this->valid) {
            $this->valid = false;
            
            $id = $this->input->post('id');
            
            $image = $this->M_image->getFieldValueById('file', $id);
            
            $upload = $this->_imageUpload(array(
                "upload_path" => "./assets/upload/images/",
                "update" => $image->file
            ));
            
            if (!empty($this->file_name)) {
                $data['file'] = $this->file_name;
            }
            
            $data['id_galeri'] = $this->input->post('galeri');
            $data['title'] = $this->input->post('title');
            $data['keterangan'] = $this->input->post('keterangan');
            
            $up = $this->M_image->update($data, $id);
            
            if ($up) {
                $this->stat = true;
                $this->msg = "Data berhasil di proses";
            }
        }
        
        echo json_encode(array(
            'stat' => $this->stat,
            'msg' => $this->msg
        ));
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
            $del = $this->M_image->hapus($id);
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
            $data = $this->M_image->getDataById($id)->row();
            $res = array();
            if (count($data) > 0) {
                $this->stat = true;
                $res = array(
                    'id_file' => $data->id_file,
                    'id_galeri' => $data->id_galeri,
                    'file' => $data->file,
                    'title' => $data->title,
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
    
    private function _imageUpload ($opt = array()) {
        $opt = array(
            "file_element_name" => empty($opt['file_element_name']) ? "file" : $opt['file_element_name'],
            "crop" => empty($opt['crop']) ? true : $opt['crop'],
            "crop_center" => empty($opt['crop_center']) ? true : $opt['crop_center'],
            "upload_path" => empty($opt['upload_path']) ? "./upload/image/" : $opt['upload_path'],
            "update" => empty($opt['update']) ? false : $opt['update']
        );
        
        $valid = true;
        $file_name = "";
        $upload = true;
        
        if ($opt['update']) {
            if (
                file_exists($opt['upload_path'] . $opt['update']) AND
                file_exists($opt['upload_path'] . "thumb/" . $opt['update'])
            ) {
                if (
                    unlink($opt['upload_path'] . $opt['update']) AND
                    unlink($opt['upload_path'] . "thumb/" . $opt['update'])
                ) {
                    $upload = true;
                } else {
                    $upload = false;
                }
            } else {
                $upload = false;
            }
        }
        
        $file_element_name = $opt['file_element_name']; // input file name
        if (is_uploaded_file($_FILES[$file_element_name]['tmp_name']) AND $upload) {
            $upload_path = $opt['upload_path'];
            
            if (!file_exists($upload_path)) {
                $this->msg = "Upload path is not exists";
                return false;
                exit;
            }
            
            $conf = array(
                "upload_path" => $upload_path,
                "allowed_types" => "jpg|jpeg|gif|png",
                "max_size" => 1024 * 5,
                "encrypt_name" => true
            );
            
            $this->load->library('upload' , $conf);
            
            if (!$this->upload->do_upload($file_element_name)) {
                $err = $this->upload->display_errors();
                $this->msg = $err;
                return false;
                exit;
            } else {
                $this->msg = "file berhasil di upload";
                $upload = $this->upload->data();
                
                $file_name = $upload['file_name'];
                
                $this->load->library('image_lib');
                
                if ($upload['image_width'] > $upload['image_height']) {
                    $fit = "height";
                } else {
                    $fit = "width";
                }
                
                $conf = array(
                    "image_library" => "gd2",
                    "maintain_ratio" => true,
                    "master_dim" => $fit,
                    "quality" => "100%",
                    "source_image" => $upload_path . $file_name,
                    "new_image" => $upload_path . "thumb/",
                    "width" => $this->ResizeWidth,
                    "height" => $this->ResizeHeight,
                );
                
                $this->image_lib->initialize($conf);
                
                $resize = false;
                if ($this->image_lib->resize()) {
                    $resize = true;
                    $this->msg = "file berhasil di resize";
                } else {
                    if (file_exists($upload_path . $file_name)) {
                        unlink($upload_path . $file_name);
                    }
                    $this->msg = $this->image_lib->display_errors();
                }
                
                // centering crop image
                if ($resize) {
                    if ($opt['crop']) {
                        if ($opt['crop_center']) {
                            if ($fit == "width") {
                                $heightAfterResize = ceil($this->ResizeWidth * ($upload['image_height']/$upload['image_width']));
                                $space = $heightAfterResize - $this->ResizeHeight;
                                $x = 0;
                                $y = ceil($space/2);
                            } elseif ($fit == "height") {
                                $widthAfterResize = ceil($this->ResizeHeight / ($upload['image_height']/$upload['image_width']));
                                $space = $widthAfterResize - $this->ResizeWidth;
                                $x = ceil($space/2);
                                $y = 0;
                            }
                        } else {
                            $x = 0;
                            $y = 0;
                        }
                        
                        $conf = array(
                            "image_library" => "gd2",
                            "maintain_ratio" => false,
                            "quality" => "100%",
                            "source_image" => $upload_path . "thumb/" . $file_name,
                            "new_image" => $upload_path . "thumb/",
                            "width" => $this->ResizeWidth,
                            "height" => $this->ResizeHeight,
                            "x_axis" => $x,
                            "y_axis" => $y,
                        );
                        $this->image_lib->clear();
                        $this->image_lib->initialize($conf);
                        if ($this->image_lib->crop()) {
                            $valid = true;
                            $this->msg = "file berhasil di upload , resize, dan crop";
                        } else {
                            if (file_exists($upload_path . $file_name)) {
                                unlink($upload_path . $file_name);
                            }
                            if (file_exists($upload_path . "thumb/" . $file_name)) {
                                unlink($upload_path . $file_name);
                            }
                            $this->msg = $this->image_lib->display_errors();
                        }
                    } else {
                        $valid = true;
                    }
                }
            }
            
        } else {
            $this->msg = "Tidak ada file yang di upload";
        }
        
        if ($valid) {
            $this->file_name = $file_name;
        }
        
        return $valid;
    }

}