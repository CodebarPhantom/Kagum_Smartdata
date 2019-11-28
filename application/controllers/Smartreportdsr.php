<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Smartreportdsr extends CI_Controller{


  function __construct(){
    parent::__construct();
    if($this->session->userdata('logged_in') !== TRUE){
      redirect('errorpage/error403');
    }
      $this->load->model('Smartreport_users_model');
      $this->load->model('Smartreport_city_model');
      $this->load->model('Smartreport_hotels_model');
      $this->load->model('Smartreport_departement_model');
      $this->load->model('Smartreport_dsr_model');
      $this->load->model('Smartreport_hca_model');
      $this->load->model('Smartreport_pnl_model');
      $this->load->model('Dashboard_model');
      $this->load->library('form_validation');
      $this->load->library('pagination');
      $this->load->library('session');
      $this->load->library('uploadfile');
      $this->load->helper('form');
      $this->load->helper('url');
      $this->load->helper('mydate');
      $this->load->helper('text');
      $this->load->library('pdfgenerator');
      
  }

  function daily_sales_report(){
    $user_level = $this->session->userdata('user_level');
    $user_HotelForDSR = $this->session->userdata('user_hotel');
    if($user_level === '1' || $user_level === '2' || $user_level === '3'){

        $getdate_dsr = strtotime($this->input->get('date_dsr', TRUE));
        $date_dsr = date("Y-m-d", $getdate_dsr);
        $page_data['page_name'] = 'daily_sales_report';        
        $page_data['lang_dashboard'] = $this->lang->line('dashboard');
        $page_data['lang_add_city'] = $this->lang->line('add_city');
        $page_data['lang_list_users'] = $this->lang->line('list_users');
        $page_data['lang_hotel'] = $this->lang->line('hotel');
        $page_data['lang_add_hotel'] = $this->lang->line('add_hotel');
        $page_data['lang_list_hotels'] = $this->lang->line('list_hotels');        
        $page_data['lang_competitor_hotels'] = $this->lang->line('competitor_hotels');
        $page_data['lang_analysis'] = $this->lang->line('analysis');        
        $page_data['lang_hotel_comp_anl'] = $this->lang->line('hotel_comp_anl');        
        $page_data['lang_dsr'] = $this->lang->line('dsr');
        $page_data['lang_city'] = $this->lang->line('city');
        $page_data['lang_add_city'] = $this->lang->line('add_city');
        $page_data['lang_list_city'] = $this->lang->line('list_city');
        $page_data['lang_departement'] = $this->lang->line('departement');
        $page_data['lang_add_departement'] = $this->lang->line('add_departement');
        $page_data['lang_list_departement'] = $this->lang->line('list_departement');
        $page_data['lang_setting'] = $this->lang->line('setting');
        $page_data['lang_user'] = $this->lang->line('user');
        $page_data['lang_search'] = $this->lang->line('search');
        $page_data['lang_pnl'] = $this->lang->line('pnl');
        $page_data['lang_pnl_category'] = $this->lang->line('pnl_category');
        $page_data['lang_pnl_list'] = $this->lang->line('pnl_list');
        $page_data['lang_budget'] = $this->lang->line('budget');
        $page_data['lang_pnl_budget'] = $this->lang->line('pnl_budget');
        $page_data['lang_expense'] = $this->lang->line('expense');
        $page_data['lang_pnl_expense'] = $this->lang->line('pnl_expense');
        $page_data['lang_category_hotels'] = $this->lang->line('category_hotels');
        $page_data['lang_statistic_dsr'] = $this->lang->line('statistic_dsr');

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

        $page_data['lang_date'] = $this->lang->line('date');
        $page_data['lang_add_dsr'] = $this->lang->line('add_dsr');
        $page_data['lang_category'] = $this->lang->line('category');
        $page_data['lang_today'] = $this->lang->line('today');
        $page_data['lang_actual'] = $this->lang->line('actual');
        $page_data['lang_budget'] = $this->lang->line('budget');
        $page_data['lang_number_days'] = $this->lang->line('number_days');
        $page_data['lang_room_available'] = $this->lang->line('room_available');
        $page_data['lang_room_sold'] = $this->lang->line('room_sold');
        $page_data['lang_occupancy'] = $this->lang->line('occupancy');
        $page_data['lang_number_guest'] = $this->lang->line('number_guest');
        $page_data['lang_arr'] = $this->lang->line('arr');
        $page_data['lang_statistic'] = $this->lang->line('statistic');
        $page_data['lang_sales'] = $this->lang->line('sales');
        $page_data['lang_rooms'] = $this->lang->line('rooms');
        $page_data['lang_fnb'] = $this->lang->line('fnb');
        $page_data['lang_other'] = $this->lang->line('other');
        $page_data['lang_laundry'] = $this->lang->line('laundry');
        $page_data['lang_total_sales'] = $this->lang->line('total_sales');
        

        $getHotelByUser = $this->Smartreport_hca_model->getHotelByUserHotel($user_HotelForDSR);
        $page_data['getHotelByUser_data'] = $getHotelByUser;

        $page_data['date_dsr'] = $this->input->get('date_dsr', TRUE);
        $page_data['dateToView'] = $date_dsr;
       

    $this->load->view('smartreport/index',$page_data);
    }else{
        redirect('errorpage/error403');
    }
  }

  function insert_dsr(){
    $user_level = $this->session->userdata('user_level');
    if($user_level === '1' || $user_level === '2' || $user_level === '3'){
      //$idanlysis = str_replace(".", "", uniqid('',true));
      $idhotels= $this->session->userdata('user_hotel');
      $date_dsr = date_php_to_mysql($this->input->post('date_dsr'));
      $dt_hotel = $this->Smartreport_dsr_model->select_hoteldsrbydate($idhotels,$date_dsr);
        if($dt_hotel->row() > 0){
          $data = array(    
            'sales_fnb'=>$this->input->post('dsr_fnb', TRUE),
            'sales_other'=>$this->input->post('dsr_other', TRUE),
            'numberofguest'=>$this->input->post('dsr_guest', TRUE));  
            $this->Smartreport_dsr_model->update_hoteldsrbyid($dt_hotel->row()->iddsr,$data);

        }else{
          $data = array(       
            'idhotels'=> $idhotels,
            'sales_fnb'=>$this->input->post('dsr_fnb', TRUE),
            'sales_other'=>$this->input->post('dsr_other', TRUE),
            'numberofguest'=>$this->input->post('dsr_guest', TRUE),
            'date_dsr'=>$date_dsr,
            'date_created' => date("Y-m-d H:i:s")
            );  
            $this->Smartreport_dsr_model->insertData('smartreport_dsr',$data);
        }
        $this->session->set_flashdata('input_success','message');        
        redirect(site_url('smartreportdsr/daily-sales-report'));
      }else{
        redirect('errorpage/error403');
    }
  
  }

  function statistic_dsr(){
    $user_level = $this->session->userdata('user_level');
    //$user_hotel = $this->session->userdata('user_hotel');
    if($user_level === '1' ){

        $getdate_dsr = strtotime($this->input->get('date_dsr', TRUE));
        $date_dsr = date("Y-m-d", $getdate_dsr);
        $page_data['page_name'] = 'statistic_dsr';        
        $page_data['lang_dashboard'] = $this->lang->line('dashboard');
        $page_data['lang_add_city'] = $this->lang->line('add_city');
        $page_data['lang_list_users'] = $this->lang->line('list_users');
        $page_data['lang_hotel'] = $this->lang->line('hotel');
        $page_data['lang_add_hotel'] = $this->lang->line('add_hotel');
        $page_data['lang_list_hotels'] = $this->lang->line('list_hotels');        
        $page_data['lang_competitor_hotels'] = $this->lang->line('competitor_hotels');
        $page_data['lang_analysis'] = $this->lang->line('analysis');        
        $page_data['lang_hotel_comp_anl'] = $this->lang->line('hotel_comp_anl');        
        $page_data['lang_dsr'] = $this->lang->line('dsr');
        $page_data['lang_city'] = $this->lang->line('city');
        $page_data['lang_add_city'] = $this->lang->line('add_city');
        $page_data['lang_list_city'] = $this->lang->line('list_city');
        $page_data['lang_departement'] = $this->lang->line('departement');
        $page_data['lang_add_departement'] = $this->lang->line('add_departement');
        $page_data['lang_list_departement'] = $this->lang->line('list_departement');
        $page_data['lang_setting'] = $this->lang->line('setting');
        $page_data['lang_user'] = $this->lang->line('user');
        $page_data['lang_search'] = $this->lang->line('search');
        $page_data['lang_pnl'] = $this->lang->line('pnl');
        $page_data['lang_pnl_category'] = $this->lang->line('pnl_category');
        $page_data['lang_pnl_list'] = $this->lang->line('pnl_list');
        $page_data['lang_budget'] = $this->lang->line('budget');
        $page_data['lang_pnl_budget'] = $this->lang->line('pnl_budget');
        $page_data['lang_expense'] = $this->lang->line('expense');
        $page_data['lang_pnl_expense'] = $this->lang->line('pnl_expense');
        $page_data['lang_category_hotels'] = $this->lang->line('category_hotels');
        $page_data['lang_statistic_dsr'] = $this->lang->line('statistic_dsr');

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

        $page_data['lang_date'] = $this->lang->line('date');
        $page_data['lang_category'] = $this->lang->line('category');
        $page_data['lang_today'] = $this->lang->line('today');
        $page_data['lang_actual'] = $this->lang->line('actual');
        $page_data['lang_budget'] = $this->lang->line('budget');
        $page_data['lang_number_days'] = $this->lang->line('number_days');
        $page_data['lang_room_available'] = $this->lang->line('room_available');
        $page_data['lang_room_sold'] = $this->lang->line('room_sold');
        $page_data['lang_occupancy'] = $this->lang->line('occupancy');
        $page_data['lang_number_guest'] = $this->lang->line('number_guest');
        $page_data['lang_arr'] = $this->lang->line('arr');
        $page_data['lang_statistic'] = $this->lang->line('statistic');
        $page_data['lang_sales'] = $this->lang->line('sales');
        $page_data['lang_rooms'] = $this->lang->line('rooms');
        $page_data['lang_fnb'] = $this->lang->line('fnb');
        $page_data['lang_other'] = $this->lang->line('other');
        $page_data['lang_total_sales'] = $this->lang->line('total_sales');
        $page_data['lang_hotel_name'] = $this->lang->line('hotel_name');  
        $page_data['lang_rev_today']  = $this->lang->line('rev_today');  
        $page_data['lang_mtd_rev'] = $this->lang->line('mtd_rev');
        $page_data['lang_achv'] = $this->lang->line('achv');      

        $smartreport_brand = $this->Smartreport_dsr_model->get_data_brand();
        $page_data['smartreport_brand_data'] = $smartreport_brand;

        $page_data['date_dsr'] = $this->input->get('date_dsr', TRUE);
        $page_data['dateToView'] = $date_dsr;

       

    $this->load->view('smartreport/index',$page_data);
    }else{
        redirect('errorpage/error403');
    }
  }

  function statistic_dsrpdf(){
    $user_level = $this->session->userdata('user_level');
    //$user_hotel = $this->session->userdata('user_hotel');
    if($user_level === '1' ){
        $getdate_dsr = strtotime($this->input->get('date_dsr', TRUE));
        $date_dsr = date("Y-m-d", $getdate_dsr);
           
        $smartreport_brand = $this->Smartreport_dsr_model->get_data_brand();
        $page_data['lang_hotel_name'] = $this->lang->line('hotel_name');  
        $page_data['lang_statistic_dsr'] = $this->lang->line('statistic_dsr');
        $page_data['smartreport_brand_data'] = $smartreport_brand;
        $page_data['date_dsr'] = $this->input->get('date_dsr', TRUE);
        $page_data['dateToView'] = $date_dsr;    
     

      $this->pdfgenerator->setPaper('A4', 'potrait');
      $this->pdfgenerator->filename = "Report Statistic DSR ".$date_dsr.".pdf";
      $this->pdfgenerator->load_view('smartreport/pdf_statisticdsr', $page_data);
      //$this->load->view('smartreport/pdf_statisticdsr',$page_data);
    }else{
        redirect('errorpage/error403');
    }
  }
}