<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Guest
 *
 * @author iwn
 */
class Uploadfile {
    //put your code here
    function  __construct() {
         $this->obj = & get_instance();
//         $this->obj->load->model('travel_member_model');
 
    }


//
    function uploadthisfile($file_element_name,$upload_path) {

              //$upload_path = document/wholesales
        
              $config['upload_path'] = './'.$upload_path.'/';
              //$config['allowed_types'] = 'gif|jpg|png|doc|txt|pdf';
 //             $config['allowed_types'] = 'gif|jpg|png|bmp|pdf|doc|docx|rar|zip';
              $config['allowed_types'] = '*';
              $config['max_size']  = 1024 * 8;
              $config['encrypt_name'] = TRUE;
              $status = ''; $msg = ''; $file_attach = '';

              $this->obj->load->library('upload', $config);
              $this->obj->upload->initialize($config);

              if (!$this->obj->upload->do_upload($file_element_name))
              {
                 $msg = $this->obj->upload->display_errors('', '');
                 $status = 'error';
              }
              else
              {
                 $data = $this->obj->upload->data();
                 $file_attach = $data['file_name'];
                 $status = 'success';
              }
              @unlink($_FILES[$file_element_name]);
              
              $data = array (
                  'status' => $status,
                  'file_attach' => $file_attach
              );

              return $data;
    }


}
?>
