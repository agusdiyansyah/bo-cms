<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Image {
    
    private $ci;

    public function __construct() {
        $this->ci =& get_instance();
    }
    
    /**
     * file_element_name
     * crop
     * crop_center
     * crop_width
     * crop_height
     * upload_path
     * update
     * max_size
     */
    public function upload ($opt = array()) {
        $opt = array(
            "file_element_name" => empty($opt['file_element_name']) ? "file" : $opt['file_element_name'],
            "crop" => empty($opt['crop']) ? true : $opt['crop'],
            "crop_center" => empty($opt['crop_center']) ? true : $opt['crop_center'],
            "crop_width" => empty($opt['crop_width']) ? 350 : $opt['crop_width'],
            "crop_height" => empty($opt['crop_height']) ? 350 : $opt['crop_height'],
            "upload_path" => empty($opt['upload_path']) ? "./upload/image/" : $opt['upload_path'],
            "update" => empty($opt['update']) ? false : $opt['update'],
            "max_size" => empty($opt['max_size']) ? 1024*5 : $opt['max_size']
        );
        
        $valid = true;
        $file_name = "";
        $msg = "Data gagal di proses";
        
        if ($opt['update']) {
            if (file_exists($opt['upload_path'] . $opt['update'])) {
                unlink($opt['upload_path'] . $opt['update']);
            }
            
            if (file_exists($opt['upload_path'] . "thumb/" . $opt['update'])) {
                unlink($opt['upload_path'] . "thumb/" . $opt['update']);
            }
        }
        
        $file_element_name = $opt['file_element_name']; // input file name
        if (is_uploaded_file($_FILES[$file_element_name]['tmp_name'])) {
            $upload_path = $opt['upload_path'];
            
            if (!file_exists($upload_path)) {
                $msg = "Upload path is not exists";
                return array(
                    "stat" => $valid,
                    "msg" => $msg,
                    "file_name" => $file_name
                );
                // exit;
            }
            
            $conf = array(
                "upload_path" => $upload_path,
                "allowed_types" => "jpg|jpeg|gif|png",
                "max_size" => $opt['max_size'],
                "encrypt_name" => true
            );
            
            $this->ci->load->library('upload' , $conf);
            
            if (!$this->ci->upload->do_upload($file_element_name)) {
                $msg = $this->ci->upload->display_errors();
                return false;
                exit;
            } else {
                $msg = "file berhasil di upload";
                $upload = $this->ci->upload->data();
                
                $file_name = $upload['file_name'];
                
                $this->ci->load->library('image_lib');
                
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
                    "width" => $opt['crop_width'],
                    "height" => $opt['crop_height'],
                );
                
                $this->ci->image_lib->initialize($conf);
                
                $resize = false;
                if ($this->ci->image_lib->resize()) {
                    $resize = true;
                    $msg = "file berhasil di resize";
                } else {
                    if (file_exists($upload_path . $file_name)) {
                        unlink($upload_path . $file_name);
                    }
                    $msg = $this->ci->image_lib->display_errors();
                }
                
                // centering crop image
                if ($resize) {
                    if ($opt['crop']) {
                        if ($opt['crop_center']) {
                            if ($fit == "width") {
                                $heightAfterResize = ceil($opt['crop_width'] * ($upload['image_height']/$upload['image_width']));
                                $space = $heightAfterResize - $opt['crop_height'];
                                $x = 0;
                                $y = ceil($space/2);
                            } elseif ($fit == "height") {
                                $widthAfterResize = ceil($opt['crop_height'] / ($upload['image_height']/$upload['image_width']));
                                $space = $widthAfterResize - $opt['crop_width'];
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
                            "width" => $opt['crop_width'],
                            "height" => $opt['crop_height'],
                            "x_axis" => $x,
                            "y_axis" => $y,
                        );
                        $this->ci->image_lib->clear();
                        $this->ci->image_lib->initialize($conf);
                        if ($this->ci->image_lib->crop()) {
                            $valid = true;
                            $msg = "file berhasil di upload , resize, dan crop";
                        } else {
                            if (file_exists($upload_path . $file_name)) {
                                unlink($upload_path . $file_name);
                            }
                            if (file_exists($upload_path . "thumb/" . $file_name)) {
                                unlink($upload_path . $file_name);
                            }
                            $msg = $this->ci->image_lib->display_errors();
                        }
                    } else {
                        $valid = true;
                    }
                }
            }
            
        } else {
            $msg = "Tidak ada file yang di upload";
        }
        
        return array(
            "stat" => $valid,
            "msg" => $msg,
            "file_name" => $file_name
        );
        
    }

}