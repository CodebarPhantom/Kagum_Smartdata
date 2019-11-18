<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Smartreportlogin extends CI_Controller{
  function __construct(){
    parent::__construct();
      $this->load->model('Smartreportlogin_model');
      $this->load->library('session');
      $this->load->library('form_validation');
      $this->load->helper('form');
      $this->load->helper('url');
  }

  function index(){
      if ($this->session->userdata('user_email')) {
        redirect('smartreport', 'refresh');
    } else {
      $this->load->view('login_smartreport');
    }
    
  }

  function auth(){

      $data = array(
          'user_email' => $this->input->post('email'),
          'user_password' => $this->input->post('password'),
      );
          $result = $this->Smartreportlogin_model->verifyLogIn($data);

          if ($result['validation']) {
              $iduser = $result['iduser'];
              $user_email = $result['user_email'];
              $user_name = $result['user_name'];
              $user_level = $result['user_level'];
              $user_hotel = $result['idhotels'];

              $userdata = array(
                  'iduser' => $iduser,
                  'user_name' => $user_name,
                  'user_email' => $user_email,
                  'user_level' => $user_level,
                  'user_hotel' => $user_hotel,
                  'logged_in' => TRUE
              );

              $this->session->set_userdata($userdata);

              redirect(base_url().'smartreport', 'refresh');
          } else {
              $this->session->set_flashdata('alert_msg', array('failure', 'Login', $result['validation']));
              redirect(base_url('smartreportlogin'), 'refresh');
          }
      
  

    /*$user_email    = $this->input->post('email',TRUE);
    $user_password = SHA1($this->input->post('password',TRUE));
    $validate = $this->Smartreportlogin_model->validate($user_email,$user_password);
    if($validate->num_rows() > 0){
        $data  = $validate->row_array();
        $iduser = $data['iduser'];
        $user_name  = $data['user_name'];
        $user_email = $data['user_email'];
        $user_level = $data['user_level'];
        $sesdata = array(
            'iduser'=> $iduser,
            'user_name'  => $user_name,
            'user_email'     => $user_email,
            'user_level'     => $user_level,
            'logged_in' => TRUE
        );
        $this->session->set_userdata($sesdata);
		redirect('Smartreport'); 
    }else{
        echo $this->session->set_flashdata('msg','Username or Password is Wrong');
        redirect('Smartreportlogin');
    }*/
  }

  function logout(){
      $this->session->sess_destroy();
      redirect('smartreportlogin');
  }

}
