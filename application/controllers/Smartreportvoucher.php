<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Smartreportvoucher extends CI_Controller{
  // Eryan Fauzan
  private $contoller_name;
  private $function_name;

  function __construct(){
    parent::__construct();
    if($this->session->userdata('logged_in') !== TRUE){
      redirect('errorpage/error403');
    }
      $this->contoller_name = $this->router->class;
      $this->function_name = $this->router->method;
      $this->load->model('Smartreport_users_model');
      $this->load->model('Smartreport_city_model');
      $this->load->model('Smartreport_hotels_model');
      $this->load->model('Smartreport_departement_model');
      $this->load->model('Smartreport_hca_model');
      $this->load->model('Smartreport_dsr_model');
      $this->load->model('Dashboard_model');
      $this->load->model('Smartreport_pnl_model');
      $this->load->model('Smartreport_actual_model');
      $this->load->model('Rolespermissions_model');
      $this->load->model('Smartreport_vouchers_model');
      $this->load->library('form_validation');
      $this->load->library('pagination');
      $this->load->library('session');
      $this->load->library('uploadfile');      
      $this->load->library('pdfgenerator');
     
      $this->load->helper('form');
      $this->load->helper('url');
      $this->load->helper('mydate');
      $this->load->helper('text');
      
  }

  function voucher_hotels(){
    $user_level = $this->session->userdata('user_level');
    $check_permission =  $this->Rolespermissions_model->check_permissions($this->contoller_name,$this->function_name,$user_level);    

    if($check_permission->num_rows() == 1){
        $idvoucher = urldecode($this->input->get('idvoucher', TRUE));
        $guestname = urldecode($this->input->get('guestname', TRUE));
        $listhotel = urldecode($this->input->get('listhotel', TRUE));

        $monthvoucher = $this->input->get('monthvoucher', TRUE);
        $yearvoucher = $this->input->get('yearvoucher', TRUE);

        $monthvoucher === NULL ? $monthvoucher = date('m') : $monthvoucher = urldecode($this->input->get('monthvoucher', TRUE));
        $yearvoucher === NULL ? $yearvoucher = date('Y') : $yearvoucher = urldecode($this->input->get('yearvoucher', TRUE));


        $start = intval($this->input->get('start'));
        
        if ($guestname <> '' || $listhotel <> '' ) {
            $config['base_url'] = base_url() . 'smartreportvoucher/voucher-hotels?guestname=' . urlencode($guestname).'&listhotel='.urlencode($listhotel) . '&idvoucher='.urlencode($idvoucher).'&monthvoucher='.urlencode($monthvoucher).'&yearvoucher='.urlencode($yearvoucher);
            $config['first_url'] = base_url() . 'smartreportvoucher/voucher-hotels?guestname=' . urlencode($guestname).'&listhotel='.urlencode($listhotel) .'&idvoucher='.urlencode($idvoucher).'&monthvoucher='.urlencode($monthvoucher).'&yearvoucher='.urlencode($yearvoucher);
        } else {
            $config['base_url'] = base_url() . 'smartreportvoucher/voucher-hotels';
            $config['first_url'] = base_url() . 'smartreportvoucher/voucher-hotels';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Smartreport_vouchers_model->total_rows_vouchers($guestname, $listhotel, $idvoucher, $monthvoucher, $yearvoucher);
        $smartreport_vouchers = $this->Smartreport_vouchers_model->get_limit_data_vouchers($config['per_page'], $start, $guestname, $listhotel, $idvoucher, $monthvoucher, $yearvoucher);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $page_data['page_name'] = 'voucher_hotels';
        
        $page_data['lang_hotel'] = $this->lang->line('hotel');
        $page_data['lang_search'] = $this->lang->line('search');
        $page_data['lang_guest_name'] = $this->lang->line('guest_name');
        $page_data['lang_guest_info'] = $this->lang->line('guest_info');
        $page_data['lang_voucher_info'] = $this->lang->line('voucher_info');
        $page_data['lang_search_voucher'] = $this->lang->line('search_voucher');
        $page_data['lang_idvoucher'] = $this->lang->line('idvoucher');
        $page_data['lang_lock_at'] = $this->lang->line('lock_at');
        $page_data['lang_last_lock_at'] = $this->lang->line('last_lock_at');
        $page_data['lang_created_at'] = $this->lang->line('created_at');
        $page_data['lang_redeem_at'] = $this->lang->line('redeem_at');
        $page_data['lang_action'] = $this->lang->line('action');
        $page_data['lang_voucher_amount'] = $this->lang->line('voucher_amount');
        $page_data['lang_phone'] = $this->lang->line('phone');
        $page_data['lang_email'] = $this->lang->line('email');

        $page_data['lang_add_voucher'] = $this->lang->line('add_voucher');
        $page_data['lang_voucher_hotels'] = $this->lang->line('voucher_hotels');
        $page_data['lang_data_vouchers'] = $this->lang->line('data_vouchers');
        $page_data['lang_stay_date'] = $this->lang->line('stay_date');
        $page_data['lang_stay_info'] = $this->lang->line('stay_info');
        $page_data['lang_choose_hotels'] = $this->lang->line('choose_hotels');
        $page_data['lang_lock_voucher'] = $this->lang->line('lock_voucher');


        $page_data['lang_input_success'] = $this->lang->line('input_success');
        $page_data['lang_success_input_data'] = $this->lang->line('success_input_data');
        $page_data['lang_delete_success'] = $this->lang->line('delete_success');
        $page_data['lang_delete_data'] = $this->lang->line('delete_data');
        $page_data['lang_delete_confirm'] = $this->lang->line('delete_confirm');
        $page_data['lang_success_delete_data'] = $this->lang->line('success_delete_data');
        $page_data['lang_update_success'] = $this->lang->line('update_success');
        $page_data['lang_success_update_data'] = $this->lang->line('success_update_data'); 
        $page_data['lang_cancel_data'] = $this->lang->line('cancel_data');
        $page_data['lang_cancel_confirm'] = $this->lang->line('cancel_confirm'); 
        $page_data['lang_submit'] = $this->lang->line('submit');
        $page_data['lang_close'] = $this->lang->line('close');     
        $page_data['lang_all_hotels'] = $this->lang->line('all_hotels');
        
        $page_data['lang_unlock_voucher_confirm'] = $this->lang->line('unlock_voucher_confirm');
        $page_data['lang_unlock_voucher'] = $this->lang->line('unlock_voucher');
        $page_data['lang_last_update'] = $this->lang->line('last_update');
        $page_data['lang_redeem_voucher_confirm'] = $this->lang->line('redeem_voucher_confirm');
        $page_data['lang_redeem_voucher'] = $this->lang->line('redeem_voucher');
        $page_data['lang_details_voucher'] = $this->lang->line('details_voucher');
        $page_data['lang_username'] = $this->lang->line('username');
        $page_data['lang_year'] = $this->lang->line('year');
        $page_data['lang_month'] = $this->lang->line('month');
        $page_data['lang_export_voucher'] = $this->lang->line('export_voucher');
        $page_data['smartreport_vouchers_data'] = $smartreport_vouchers;

        $page_data['guestname'] = $this->input->get('guestname', TRUE);
        $page_data['listhotel'] = $this->input->get('listhotel', TRUE);
        $page_data['idvoucher'] = $this->input->get('idvoucher', TRUE);
        $page_data['yearvoucher'] = $this->input->get('yearvoucher', TRUE);
        $page_data['monthvoucher'] = $this->input->get('monthvoucher', TRUE);



        $page_data['pagination'] = $this->pagination->create_links();
        $page_data['total_rows'] = $config['total_rows'];
        $page_data['start'] = $start;

       
        $this->load->view('smartreport/index', $page_data);
    }else{
      redirect('errorpage/error403');
    }

  }

  function insert_voucher(){
    $user_level = $this->session->userdata('user_level');
    $check_permission =  $this->Rolespermissions_model->check_permissions($this->contoller_name,$this->function_name,$user_level);    
    if($check_permission->num_rows() == 1){
      $type_sales = $this->input->post('voucher_amount', TRUE) >= 5 ? 2 : 1; 
      for($h = 0; $h<$this->input->post('voucher_amount', TRUE); ++$h){
        $data = array(       
          'guest_name'=>$this->input->post('guest_name', TRUE),
          'guest_phone'=>$this->input->post('guest_phone', TRUE),
          'guest_email'=>$this->input->post('guest_email', TRUE),
          'fk_iduser_generate'=>$this->session->userdata('iduser'),
          'created_at'=>date("Y-m-d H:i:s"),
          'lock_at' => '1970-01-01 00:00:00',
          'redeem_at' => '1970-01-01 00:00:00',
          'stay_date' => '1970-01-01 00:00:00',
          'status_voucher'=>1,
          'type_voucher'=>1,
          'type_sales'=>$type_sales
          //'date_analysis'=>$date_analysis,
          //'date_created' => date("Y-m-d H:i:s")
          );          
          $idvoucher = $this->Smartreport_vouchers_model->set_idvoucher();   
          $this->Smartreport_vouchers_model->insert_voucher($idvoucher,$data);
      }
      $this->session->set_flashdata('input_success','message');        
        redirect(site_url('smartreportvoucher/voucher-hotels'));
    }else{
        redirect('errorpage/error403');
    }
  }

  function lock_voucher(){
    $user_level = $this->session->userdata('user_level');
    $check_permission =  $this->Rolespermissions_model->check_permissions($this->contoller_name,$this->function_name,$user_level);    
    if($check_permission->num_rows() == 1){
      $stay_date = date_php_to_mysql($this->input->post('stay_date'));
      $data = array(
        
        'fk_idhotels' => $this->input->post('idhotels',TRUE),
        'lock_at' => date("Y-m-d H:i:s"),
        'stay_date' =>$stay_date,
        'fk_iduser_lock'=>$this->session->userdata('iduser'),
        'status_voucher' => 2
        );  
     
        $this->Smartreport_vouchers_model->update_data_voucher('smartreport_voucherhotels', $data, $this->input->post('idvoucher', TRUE));
        $this->session->set_flashdata('update_success','message');
        //redirect(site_url('smartreport/competitor-hotel'));
        redirect($_SERVER['HTTP_REFERER']);
      }else{
        redirect('errorpage/error403');
    }
      
  }

  function unlock_voucher($idvoucher){
    $user_level = $this->session->userdata('user_level');
    $check_permission =  $this->Rolespermissions_model->check_permissions($this->contoller_name,$this->function_name,$user_level);    
    if($check_permission->num_rows() == 1){
      $data = array(        
        'fk_idhotels' => '',
        'lock_at' => date("Y-m-d H:i:s"),
        'stay_date' => '1970-01-01 00:00:00',
        'fk_iduser_lock'=>$this->session->userdata('iduser'),
        'status_voucher' => 1
        );  
     
        $this->Smartreport_vouchers_model->update_data_voucher('smartreport_voucherhotels', $data, $idvoucher);
        $this->session->set_flashdata('update_success','message');
        //redirect(site_url('smartreport/competitor-hotel'));
        redirect($_SERVER['HTTP_REFERER']);
      }else{
        redirect('errorpage/error403');
    }
      
  }

  function redeem_voucher($idvoucher){
    $user_level = $this->session->userdata('user_level');
    $check_permission =  $this->Rolespermissions_model->check_permissions($this->contoller_name,$this->function_name,$user_level);    
    if($check_permission->num_rows() == 1){
      $data = array(
        'redeem_at' => date("Y-m-d H:i:s"),
        'fk_iduser_redeem'=>$this->session->userdata('iduser'),
        'status_voucher' => 0
        );  
     
        $this->Smartreport_vouchers_model->update_data_voucher('smartreport_voucherhotels', $data, $idvoucher);
        $this->session->set_flashdata('update_success','message');
        redirect($_SERVER['HTTP_REFERER']);
      }else{
        redirect('errorpage/error403');
    }
  }

  function export_voucher_pdf($idvoucher){
    $user_level = $this->session->userdata('user_level');
    //$user_hotel = $this->session->userdata('user_hotel');
    $check_permission =  $this->Rolespermissions_model->check_permissions($this->contoller_name,$this->function_name,$user_level);    
    if($check_permission->num_rows() == 1){  

      $voucher_data = $this->Smartreport_vouchers_model->get_info_voucher($idvoucher);

      $page_data['idvoucher'] = $idvoucher;
      $page_data['status_voucher'] = $voucher_data->status_voucher;

      // $this->pdfgenerator->setPaper('A4', 'potrait');
      //$customPaper = array(0,0,800,250);
      //$this->pdfgenerator->set_paper($customPaper);   
      
      
      $this->pdfgenerator->set_option('isRemoteEnabled', TRUE); // enable image export
      $this->pdfgenerator->set_option('isHtml5ParserEnabled', true);
      $this->pdfgenerator->filename = "Voucher Hotel ".$voucher_data->guest_name." ".$idvoucher.".pdf";
      //$this->pdfgenerator->load_view('smartreport/pdf_voucherhotel', $page_data);
      $this->load->view('smartreport/pdf_voucherhotel',$page_data);
    }else{
        redirect('errorpage/error403');
    }
  }
}