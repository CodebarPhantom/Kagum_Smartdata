<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Smartreport extends CI_Controller{

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
      $this->load->library('form_validation');
      $this->load->library('pagination');
      $this->load->library('session');
      $this->load->library('uploadfile');
     
      $this->load->helper('form');
      $this->load->helper('url');
      $this->load->helper('mydate');
      $this->load->helper('text');
      
  }


  function index(){
    //Allowing akses to smartreport only
    $user_level = $this->session->userdata('user_level');
    $user_HotelForDashboard = $this->session->userdata('user_hotel');
    // buat ngecek misal si user nakal main masukin URL
    $check_permission =  $this->Rolespermissions_model->check_permissions($this->contoller_name,$this->function_name,$user_level);    
      if($check_permission->num_rows() == 1){
        $page_data['page_name'] = 'dashboard';
        $page_data['lang_dashboard'] = $this->lang->line('dashboard');
        $page_data['lang_dashboard_hotel'] = $this->lang->line('dashboard_hotel');
        $page_data['lang_user'] = $this->lang->line('user');
        $page_data['lang_add_user'] = $this->lang->line('add_user');
        $page_data['lang_list_users'] = $this->lang->line('list_users');
        $page_data['lang_departement'] = $this->lang->line('departement');
        $page_data['lang_add_departement'] = $this->lang->line('add_departement');
        $page_data['lang_list_departement'] = $this->lang->line('list_departement');
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
        $page_data['lang_setting'] = $this->lang->line('setting');
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
        $page_data['lang_choose_hotels'] = $this->lang->line('choose_hotels');


        $page_data['lang_date'] = $this->lang->line('date');
        $page_data['lang_search'] = $this->lang->line('search');
        
        //untuk Graph
        $getHotelAllStarByUser = $this->Smartreport_hca_model->getHotelAllStarByUserHotel($user_HotelForDashboard);
        $page_data['getHotelAllStarByUser_data'] = $getHotelAllStarByUser;

        //untuk table
        $getHotelByUser = $this->Smartreport_hca_model->getHotelByUserHotel($user_HotelForDashboard);
        $page_data['getHotelByUser_data'] = $getHotelByUser;

        $this->load->view('smartreport/index',$page_data);
     }else{
        redirect('errorpage/error403');
     }

  }

  function dashboard(){
    $user_level = $this->session->userdata('user_level');
    $user_HotelForDashboard = $this->session->userdata('user_hotel');
    $check_permission =  $this->Rolespermissions_model->check_permissions($this->contoller_name,$this->function_name,$user_level);    
    if($check_permission->num_rows() == 1){

        $getdate_dashboard = strtotime($this->input->post('date_dashboard', TRUE));
        $getidhotel_dashboard = $this->input->post('idhoteldashboard', TRUE);
        $date_dashboard = date("Y-m-d", $getdate_dashboard);

        $page_data['page_name'] = 'dashboard_search';
        $page_data['lang_dashboard'] = $this->lang->line('dashboard');
        $page_data['lang_dashboard_hotel'] = $this->lang->line('dashboard_hotel');
        $page_data['lang_user'] = $this->lang->line('user');
        $page_data['lang_add_user'] = $this->lang->line('add_user');
        $page_data['lang_list_users'] = $this->lang->line('list_users');
        $page_data['lang_departement'] = $this->lang->line('departement');
        $page_data['lang_add_departement'] = $this->lang->line('add_departement');
        $page_data['lang_list_departement'] = $this->lang->line('list_departement');
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
        $page_data['lang_setting'] = $this->lang->line('setting');
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
        $page_data['lang_choose_hotels'] = $this->lang->line('choose_hotels');

        $page_data['lang_date'] = $this->lang->line('date');
        $page_data['lang_search'] = $this->lang->line('search');

        //untuk yang bukan administrator
        if($getidhotel_dashboard == NULL){
          $getidhotel_dashboard = $user_HotelForDashboard; 
        }
        
        // untuk graph       

        $getHotelAllStarByUser = $this->Smartreport_hca_model->getHotelAllStarByUserHotel($getidhotel_dashboard);
        $page_data['getHotelAllStarByUser_data'] = $getHotelAllStarByUser;

        //untuk table
        $getHotelByUser = $this->Smartreport_hca_model->getHotelByUserHotel($getidhotel_dashboard);
        $page_data['getHotelByUser_data'] = $getHotelByUser;

        $page_data['date_dashboard'] = $this->input->post('date_dashboard', TRUE);
        $page_data['dateToView'] = $date_dashboard;
        $page_data['idhotel_dashboard'] = $getidhotel_dashboard;

        $this->load->view('smartreport/index',$page_data);
     }else{
        redirect('errorpage/error403');
     }
  }

  function list_users(){
    $user_level = $this->session->userdata('user_level');
    $check_permission =  $this->Rolespermissions_model->check_permissions($this->contoller_name,$this->function_name,$user_level);    
    if($check_permission->num_rows() == 1){

    $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'smartreport/list-users?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'smartreport/list-users?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'smartreport/list-users';
            $config['first_url'] = base_url() . 'smartreport/list-users';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Smartreport_users_model->total_rows_user($q);
        $smartreport_users = $this->Smartreport_users_model->get_limit_data_user($config['per_page'], $start, $q);
        
        $this->pagination->initialize($config);

        $page_data['page_name'] = 'list_users';
        $page_data['lang_dashboard'] = $this->lang->line('dashboard');
        $page_data['lang_dashboard_hotel'] = $this->lang->line('dashboard_hotel');
        $page_data['lang_submit'] = $this->lang->line('submit');
        $page_data['lang_close'] = $this->lang->line('close');
        $page_data['lang_input_success'] = $this->lang->line('input_success');
        $page_data['lang_success_input_data'] = $this->lang->line('success_input_data');
        $page_data['lang_delete_success'] = $this->lang->line('delete_success');
        $page_data['lang_delete_data'] = $this->lang->line('delete_data');
        $page_data['lang_delete_confirm'] = $this->lang->line('delete_confirm');
        $page_data['lang_success_delete_data'] = $this->lang->line('success_delete_data');
        $page_data['lang_update_success'] = $this->lang->line('update_success');
        $page_data['lang_success_update_data'] = $this->lang->line('success_update_data');
        $page_data['lang_update_password_failure'] = $this->lang->line('update_password_failure');
        $page_data['lang_failure_update_password'] = $this->lang->line('failure_update_password');
        $page_data['lang_new_password_must_same'] = $this->lang->line('new_password_must_same');  

        $page_data['lang_user'] = $this->lang->line('user');        
        $page_data['lang_username'] = $this->lang->line('username');
        $page_data['lang_password'] = $this->lang->line('password');
        $page_data['lang_new_password'] = $this->lang->line('new_password');
        $page_data['lang_confirm_password'] = $this->lang->line('confirm_password');
        $page_data['lang_change_password_for'] = $this->lang->line('change_password_for');
        $page_data['lang_change_password'] = $this->lang->line('change_password');
        $page_data['lang_email'] = $this->lang->line('email');
        $page_data['lang_level'] = $this->lang->line('level');
        $page_data['lang_choose_level'] = $this->lang->line('choose_level');
        $page_data['lang_status'] = $this->lang->line('status');
        $page_data['lang_active'] = $this->lang->line('active');
        $page_data['lang_inactive'] = $this->lang->line('inactive');
        $page_data['lang_choose_status'] = $this->lang->line('choose_status');
        $page_data['lang_add_user'] = $this->lang->line('add_user');
        $page_data['lang_edit_user'] = $this->lang->line('edit_user');
        $page_data['lang_delete_user'] = $this->lang->line('delete_user');
        $page_data['lang_list_users'] = $this->lang->line('list_users');
        $page_data['lang_departement'] = $this->lang->line('departement');
        $page_data['lang_add_departement'] = $this->lang->line('add_departement');
        $page_data['lang_list_departement'] = $this->lang->line('list_departement');
        $page_data['lang_choose_departement'] = $this->lang->line('choose_departement');
        $page_data['lang_choose_hotels'] = $this->lang->line('choose_hotels');
        $page_data['lang_hotel'] = $this->lang->line('hotel');
        $page_data['lang_add_hotel'] = $this->lang->line('add_hotel');
        $page_data['lang_list_hotels'] = $this->lang->line('list_hotels');
        $page_data['lang_city'] = $this->lang->line('city');
        $page_data['lang_add_city'] = $this->lang->line('add_city');
        $page_data['lang_list_city'] = $this->lang->line('list_city');
        $page_data['lang_setting'] = $this->lang->line('setting');
        $page_data['lang_search'] = $this->lang->line('search');        
        $page_data['lang_competitor_hotels'] = $this->lang->line('competitor_hotels');
        $page_data['lang_analysis'] = $this->lang->line('analysis');        
        $page_data['lang_hotel_comp_anl'] = $this->lang->line('hotel_comp_anl');        
        $page_data['lang_dsr'] = $this->lang->line('dsr');
        $page_data['lang_search_users'] = $this->lang->line('search_users');
        $page_data['lang_pnl'] = $this->lang->line('pnl');
        $page_data['lang_pnl_category'] = $this->lang->line('pnl_category');
        $page_data['lang_pnl_list'] = $this->lang->line('pnl_list');
        $page_data['lang_budget'] = $this->lang->line('budget');
        $page_data['lang_pnl_budget'] = $this->lang->line('pnl_budget');
        $page_data['lang_expense'] = $this->lang->line('expense');
        $page_data['lang_pnl_expense'] = $this->lang->line('pnl_expense');
        $page_data['lang_category_hotels'] = $this->lang->line('category_hotels');
        $page_data['lang_statistic_dsr'] = $this->lang->line('statistic_dsr');

        $page_data['smartreport_users_data'] = $smartreport_users;
        $page_data['q'] = $q;
        $page_data['pagination'] = $this->pagination->create_links();
        $page_data['total_rows'] = $config['total_rows'];
        $page_data['start'] = $start;

    $this->load->view('smartreport/index',$page_data);
      }else{
        redirect('errorpage/error403');
    }
  }

  function insert_user(){
    $user_level = $this->session->userdata('user_level');
    $check_permission =  $this->Rolespermissions_model->check_permissions($this->contoller_name,$this->function_name,$user_level);    
    if($check_permission->num_rows() == 1){
    $data = array(
      'iddept' => $this->input->post('iddept',TRUE),
      'idhotels' => $this->input->post('idhotel',TRUE),
      'user_name' => $this->input->post('user_name', TRUE),
      'user_email' => $this->input->post('user_email', TRUE),
      'user_password' => SHA1($this->input->post('user_password', TRUE)),
      'user_level' => $this->input->post('user_level', TRUE),
      'user_status' => $this->input->post('user_status', TRUE)
      );  
     
        $this->Smartreport_users_model->insertData( 'smartreport_users',$data);
        $this->session->set_flashdata('input_success','message');
        
        redirect(site_url('smartreport/list-users'));
        }else{
        redirect('errorpage/error403');
    }
      
  }

  function update_user(){
    $user_level = $this->session->userdata('user_level');
    $check_permission =  $this->Rolespermissions_model->check_permissions($this->contoller_name,$this->function_name,$user_level);    
    if($check_permission->num_rows() == 1){
    $data = array(
      'iddept' => $this->input->post('iddept',TRUE),      
      'idhotels' => $this->input->post('idhotel',TRUE),
      'user_name' => $this->input->post('user_name', TRUE),
      'user_email' => $this->input->post('user_email', TRUE),
      'user_level' => $this->input->post('user_level', TRUE),
      'user_status' => $this->input->post('user_status', TRUE)
      );  
     
        $this->Smartreport_users_model->updateDataUser('smartreport_users', $data, $this->input->post('iduser', TRUE));
        $this->session->set_flashdata('update_success','message');
        redirect(site_url('smartreport/list-users'));
      }else{
        redirect('errorpage/error403');
    }
  }

  function delete_user($iduser){
    $user_level = $this->session->userdata('user_level');
    $check_permission =  $this->Rolespermissions_model->check_permissions($this->contoller_name,$this->function_name,$user_level);    
    if($check_permission->num_rows() == 1){
          $this->Smartreport_users_model->deleteDataUser($iduser);
          $this->session->set_flashdata('delete_success','message');
          redirect(site_url('smartreport/list-users'));
        }else{
          redirect('errorpage/error403');
      }
      
  }

  function update_password_user(){
    $user_level = $this->session->userdata('user_level');
    $check_permission =  $this->Rolespermissions_model->check_permissions($this->contoller_name,$this->function_name,$user_level);    
    if($check_permission->num_rows() == 1){
        $iduser = $this->input->post('iduser');
        $newpass = $this->input->post('newpassword');
        $conpass = $this->input->post('conpassword');

        //$us_id = $this->session->userdata('user_id');
     
        if (empty($newpass)) {
            $this->session->set_flashdata('update_password_failure','message');
            redirect(base_url().'smartreport/list-users');
        } elseif (empty($conpass)) {
          $this->session->set_flashdata('update_password_failure','message');
            redirect(base_url().'smartreport/list-users');
        } elseif ($newpass != $conpass) {
           $this->session->set_flashdata('update_password_notsame','message');
            redirect(base_url().'smartreport/list-users');
        } else {
            $upd_data = array(
              'user_password' => SHA1($this->input->post('newpassword', TRUE)),
                    //'updated_user_id' => $us_id,
                    //'updated_datetime' => $tm,
            );
            if ($this->Smartreport_users_model->updatePasswordData('smartreport_users', $upd_data, $iduser)) {
                $this->session->set_flashdata('update_success','message');
                redirect(base_url().'smartreport/list-users');
            }
        }
      }else{
        redirect('errorpage/error403');
    }
  }

  function list_city(){
    $user_level = $this->session->userdata('user_level');
    $check_permission =  $this->Rolespermissions_model->check_permissions($this->contoller_name,$this->function_name,$user_level);    
    if($check_permission->num_rows() == 1){
    $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'smartreport/list-city?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'smartreport/list-city?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'smartreport/list-city';
            $config['first_url'] = base_url() . 'smartreport/list-city';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Smartreport_city_model->total_rows_city($q);
        $smartreport_city = $this->Smartreport_city_model->get_limit_data_city($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $page_data['page_name'] = 'list_city';
        
        $page_data['lang_dashboard'] = $this->lang->line('dashboard');
        $page_data['lang_dashboard_hotel'] = $this->lang->line('dashboard_hotel');
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

        $page_data['lang_edit_city'] = $this->lang->line('edit_city');
        $page_data['lang_city_name'] = $this->lang->line('city_name');
        $page_data['lang_delete_city'] = $this->lang->line('delete_city');
        $page_data['lang_search_city'] = $this->lang->line('search_city');

        $page_data['smartreport_city_data'] = $smartreport_city;
        $page_data['q'] = $q;
        $page_data['pagination'] = $this->pagination->create_links();
        $page_data['total_rows'] = $config['total_rows'];
        $page_data['start'] = $start;

       
        $this->load->view('smartreport/index', $page_data);
    }else{
      redirect('errorpage/error403');
    }

  }

  function insert_city(){
    $user_level = $this->session->userdata('user_level');
    $check_permission =  $this->Rolespermissions_model->check_permissions($this->contoller_name,$this->function_name,$user_level);    
    if($check_permission->num_rows() == 1){
    $data = array(
      'city_name' => ucwords($this->input->post('city_name',TRUE))
      );  
        $this->Smartreport_city_model->insertData('smartreport_city',$data);
        $this->session->set_flashdata('input_success','message');        
        redirect(site_url('smartreport/list-city'));
        }else{
        redirect('errorpage/error403');
    }
      
  }

  function update_city(){
    $user_level = $this->session->userdata('user_level');
    $check_permission =  $this->Rolespermissions_model->check_permissions($this->contoller_name,$this->function_name,$user_level);    
    if($check_permission->num_rows() == 1){
    $data = array(
      'city_name' => ucwords($this->input->post('city_name',TRUE))
      );  
     
        $this->Smartreport_city_model->updateDataCity('smartreport_city', $data, $this->input->post('idcity', TRUE));
        $this->session->set_flashdata('update_success','message');
        redirect(site_url('smartreport/list-city'));
      }else{
        redirect('errorpage/error403');
    }
      
  }

  function delete_city($idcity){
    $user_level = $this->session->userdata('user_level');
    $check_permission =  $this->Rolespermissions_model->check_permissions($this->contoller_name,$this->function_name,$user_level);    
    if($check_permission->num_rows() == 1){
    $this->Smartreport_city_model->deleteDataCity($idcity);
    $this->session->set_flashdata('delete_success','message');
    redirect(site_url('smartreport/list-city'));
    }else{
      redirect('errorpage/error403');
    }

  }

  function category_hotels(){
    $user_level = $this->session->userdata('user_level');
    $check_permission =  $this->Rolespermissions_model->check_permissions($this->contoller_name,$this->function_name,$user_level);    
    if($check_permission->num_rows() == 1){
    $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'smartreport/category-hotels?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'smartreport/category-hotels?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'smartreport/category-hotels';
            $config['first_url'] = base_url() . 'smartreport/category-hotels';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Smartreport_hotels_model->total_rows_categoryhotels($q);
        $smartreport_categoryhotels = $this->Smartreport_hotels_model->get_limit_data_categoryhotels($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $page_data['page_name'] = 'category_hotels';
        
        $page_data['lang_dashboard'] = $this->lang->line('dashboard');
        $page_data['lang_dashboard_hotel'] = $this->lang->line('dashboard_hotel');
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

        $page_data['lang_edit_categoryhotels'] = $this->lang->line('edit_categoryhotels');
        $page_data['lang_delete_categoryhotels'] = $this->lang->line('delete_categoryhotels');
        $page_data['lang_search_categoryhotels'] = $this->lang->line('search_categoryhotels');
        $page_data['lang_add_categoryhotels'] = $this->lang->line('add_categoryhotels');
        $page_data['lang_brand_id'] = $this->lang->line('brand_id');
        $page_data['lang_order'] = $this->lang->line('order');

        $page_data['smartreport_categoryhotels_data'] = $smartreport_categoryhotels;
        $page_data['q'] = $q;
        $page_data['pagination'] = $this->pagination->create_links();
        $page_data['total_rows'] = $config['total_rows'];
        $page_data['start'] = $start;

       
        $this->load->view('smartreport/index', $page_data);
    }else{
      redirect('errorpage/error403');
    }
  }

  function insert_categoryhotels(){
    $user_level = $this->session->userdata('user_level');
    $check_permission =  $this->Rolespermissions_model->check_permissions($this->contoller_name,$this->function_name,$user_level);    
    if($check_permission->num_rows() == 1){
    $data = array(
      'idhotelscategory'=> strtoupper($this->input->post('idcategoryhotels',TRUE)),
      'hotels_category' => ucwords($this->input->post('categoryhotels_name',TRUE)),
      'hotelscategory_order' =>$this->input->post('hotelscategory_order',TRUE)
      );  
        $this->Smartreport_hotels_model->insertData('smartreport_hotelscategory',$data);
        $this->session->set_flashdata('input_success','message');        
        redirect(site_url('smartreport/category-hotels'));
        }else{
        redirect('errorpage/error403');
    }
      
  }

  function update_categoryhotels(){
    $user_level = $this->session->userdata('user_level');
    $check_permission =  $this->Rolespermissions_model->check_permissions($this->contoller_name,$this->function_name,$user_level);    
    if($check_permission->num_rows() == 1){
    $data = array(
      'hotels_category' => ucwords($this->input->post('categoryhotels_name',TRUE)),
      'hotelscategory_order' =>$this->input->post('hotelscategory_order',TRUE)
      );  
     
        $this->Smartreport_hotels_model->updatedata_categoryhotels('smartreport_hotelscategory', $data, $this->input->post('idcategoryhotels', TRUE));
        $this->session->set_flashdata('update_success','message');
        redirect(site_url('smartreport/category-hotels'));
      }else{
        redirect('errorpage/error403');
    }
      
  }

  function delete_categoryhotels($idcategoryhotels){
    $user_level = $this->session->userdata('user_level');
    $check_permission =  $this->Rolespermissions_model->check_permissions($this->contoller_name,$this->function_name,$user_level);    
    if($check_permission->num_rows() == 1){ 
    $this->Smartreport_hotels_model->deletedata_categoryhotels($idcategoryhotels);
    $this->session->set_flashdata('delete_success','message');
    redirect(site_url('smartreport/category-hotels'));
    }else{
      redirect('errorpage/error403');
    }

  }

  function list_hotel(){
    $user_level = $this->session->userdata('user_level');
    $check_permission =  $this->Rolespermissions_model->check_permissions($this->contoller_name,$this->function_name,$user_level);    
    if($check_permission->num_rows() == 1){
    $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'smartreport/list-hotel?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'smartreport/list-hotel?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'smartreport/list-hotel';
            $config['first_url'] = base_url() . 'smartreport/list-hotel';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Smartreport_hotels_model->total_rows_hotels($q);
        $smartreport_hotel = $this->Smartreport_hotels_model->get_limit_data_hotels($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $page_data['page_name'] = 'list_hotel';
        
        $page_data['lang_dashboard'] = $this->lang->line('dashboard');
        $page_data['lang_dashboard_hotel'] = $this->lang->line('dashboard_hotel');
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

        $page_data['lang_edit_hotel'] = $this->lang->line('edit_hotel');
        $page_data['lang_idhotel'] = $this->lang->line('idhotel');
        $page_data['lang_status'] = $this->lang->line('status');
        $page_data['lang_hotel_name'] = $this->lang->line('hotel_name');
        $page_data['lang_hotel_star'] = $this->lang->line('hotel_star');
        $page_data['lang_delete_hotel'] = $this->lang->line('delete_hotel');
        $page_data['lang_choose_city'] = $this->lang->line('choose_city');
        $page_data['lang_choose_status'] = $this->lang->line('choose_status');
        $page_data['lang_choose_star'] = $this->lang->line('choose_star');
        $page_data['lang_search_hotel'] = $this->lang->line('search_hotel');
        $page_data['lang_total_rooms'] = $this->lang->line('total_rooms');
        $page_data['lang_rooms'] = $this->lang->line('rooms');
        $page_data['lang_hotel_star'] = $this->lang->line('hotel_star');
        $page_data['lang_brand_name'] = $this->lang->line('brand_name');
        $page_data['lang_choose_brand'] = $this->lang->line('choose_brand');




        $page_data['smartreport_hotel_data'] = $smartreport_hotel;
        $page_data['q'] = $q;
        $page_data['pagination'] = $this->pagination->create_links();
        $page_data['total_rows'] = $config['total_rows'];
        $page_data['start'] = $start;

       
        $this->load->view('smartreport/index', $page_data);
    }else{
      redirect('errorpage/error403');
    }

  }

  function insert_hotel(){
    $user_level = $this->session->userdata('user_level');
    $check_permission =  $this->Rolespermissions_model->check_permissions($this->contoller_name,$this->function_name,$user_level);    
    if($check_permission->num_rows() == 1){
    $data = array(
      'idhotels' => strtoupper($this->input->post('idhotels',TRUE)),
      'hotels_name' => ucwords( $this->input->post('hotels_name',TRUE)),
      'total_rooms' => $this->input->post('total_rooms',TRUE),
      'idcity' => $this->input->post('idcity',TRUE),
      'idhotelscategory' => $this->input->post('idhotelscategory',TRUE),
      'parent' => 'PARENT',
      'hotel_star' => $this->input->post('hotel_star',TRUE),
      'date_created' => date('Y-m-d H:i:s'),
      'status' => $this->input->post('status',TRUE)
      );  
        $this->Smartreport_city_model->insertData('smartreport_hotels',$data);
        $this->session->set_flashdata('input_success','message');        
        redirect(site_url('smartreport/list-hotel'));
        }else{
        redirect('errorpage/error403');
    }      
  }

  function update_hotel(){
    $user_level = $this->session->userdata('user_level');
    $check_permission =  $this->Rolespermissions_model->check_permissions($this->contoller_name,$this->function_name,$user_level);    
    if($check_permission->num_rows() == 1){
    $data = array(
      'idhotels' => strtoupper($this->input->post('idhotels',TRUE)),
      'hotels_name' => ucwords( $this->input->post('hotels_name',TRUE)),
      'total_rooms' => $this->input->post('total_rooms',TRUE),
      'idcity' => $this->input->post('idcity',TRUE),
      'idhotelscategory' => $this->input->post('idhotelscategory',TRUE),
      'hotel_star' => $this->input->post('hotel_star',TRUE),
      'status' => $this->input->post('status',TRUE)
      );  
     
        $this->Smartreport_hotels_model->updateDataHotels('smartreport_hotels', $data, $this->input->post('idhotels_old', TRUE));
        $this->session->set_flashdata('update_success','message');
        redirect(site_url('smartreport/list-hotel'));
      }else{
        redirect('errorpage/error403');
    }
      
  }

  function delete_hotel($idhotels){
    $user_level = $this->session->userdata('user_level');
    $check_permission =  $this->Rolespermissions_model->check_permissions($this->contoller_name,$this->function_name,$user_level);    
    if($check_permission->num_rows() == 1){
    $this->Smartreport_hotels_model->deleteDataHotels($idhotels);
    $this->session->set_flashdata('delete_success','message');
    redirect(site_url('smartreport/list-hotel'));
    }else{
      redirect('errorpage/error403');
    }

  }


  function competitor_hotel(){
    $user_level = $this->session->userdata('user_level');
    $check_permission =  $this->Rolespermissions_model->check_permissions($this->contoller_name,$this->function_name,$user_level);    
    if($check_permission->num_rows() == 1){
    $competitor = urldecode($this->input->get('competitor', TRUE));
    $city = urldecode($this->input->get('city', TRUE));
    $listhotel = urldecode($this->input->get('listhotel', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($competitor <> '' || $city <> '' || $listhotel <> '' ) {
            $config['base_url'] = base_url() . 'smartreport/competitor-hotel?competitor=' . urlencode($competitor).'&city='.urlencode($city).'&listhotel='.urlencode($listhotel);
            $config['first_url'] = base_url() . 'smartreport/competitor-hotel?competitor=' . urlencode($competitor).'&city='.urlencode($city).'&listhotel='.urlencode($listhotel);
        } else {
            $config['base_url'] = base_url() . 'smartreport/competitor-hotel';
            $config['first_url'] = base_url() . 'smartreport/competitor-hotel';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Smartreport_hotels_model->total_rows_competitor($competitor, $city, $listhotel);
        $smartreport_competitor = $this->Smartreport_hotels_model->get_limit_data_competitor($config['per_page'], $start, $competitor, $city, $listhotel);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $page_data['page_name'] = 'competitor_hotel';
        
        $page_data['lang_dashboard'] = $this->lang->line('dashboard');
        $page_data['lang_dashboard_hotel'] = $this->lang->line('dashboard_hotel');
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

        $page_data['lang_edit_hotel'] = $this->lang->line('edit_hotel');
        $page_data['lang_add_competitor'] = $this->lang->line('add_competitor');
        $page_data['lang_edit_competitor'] = $this->lang->line('edit_competitor');
        $page_data['lang_search_competitor'] = $this->lang->line('search_competitor');
        $page_data['lang_idhotel'] = $this->lang->line('idhotel');
        $page_data['lang_status'] = $this->lang->line('status');
        $page_data['lang_hotel_name'] = $this->lang->line('hotel_name');
        $page_data['lang_idcompetitor'] = $this->lang->line('idcompetitor');
        $page_data['lang_competitor'] = $this->lang->line('competitor');
        $page_data['lang_hotel_star'] = $this->lang->line('hotel_star');
        $page_data['lang_delete_hotel'] = $this->lang->line('delete_hotel');
        $page_data['lang_choose_city'] = $this->lang->line('choose_city');
        $page_data['lang_choose_status'] = $this->lang->line('choose_status');
        $page_data['lang_choose_competitor'] = $this->lang->line('choose_competitor');
        $page_data['lang_choose_hotels'] = $this->lang->line('choose_hotels');
        $page_data['lang_choose_star'] = $this->lang->line('choose_star');
        $page_data['lang_search_hotel'] = $this->lang->line('search_hotel');
        $page_data['lang_total_rooms'] = $this->lang->line('total_rooms');
        $page_data['lang_rooms'] = $this->lang->line('rooms');
        $page_data['lang_hotel_star'] = $this->lang->line('hotel_star');
        $page_data['lang_all_hotels'] = $this->lang->line('all_hotels');
        $page_data['lang_all_city'] = $this->lang->line('all_city');



        $page_data['smartreport_competitor_data'] = $smartreport_competitor;
        $page_data['competitor'] = $this->input->get('competitor', TRUE);
        $page_data['city'] = $this->input->get('city', TRUE);
        $page_data['listhotel'] = $this->input->get('listhotel', TRUE);


        $page_data['pagination'] = $this->pagination->create_links();
        $page_data['total_rows'] = $config['total_rows'];
        $page_data['start'] = $start;

       
        $this->load->view('smartreport/index', $page_data);
    }else{
      redirect('errorpage/error403');
    }
  }

  function insert_competitor(){
    $user_level = $this->session->userdata('user_level');
    $check_permission =  $this->Rolespermissions_model->check_permissions($this->contoller_name,$this->function_name,$user_level);    
    if($check_permission->num_rows() == 1){
    $data = array(
      'idhotels' => strtoupper($this->input->post('idcompetitor',TRUE)),
      'hotels_name' => ucwords( $this->input->post('hotels_name',TRUE)),
      'total_rooms' => $this->input->post('total_rooms',TRUE),
      'idcity' => $this->input->post('idcity',TRUE),
      'parent' => $this->input->post('idparent',TRUE),
      'hotel_star' => $this->input->post('hotel_star',TRUE),
      'date_created' => date('Y-m-d H:i:s'),
      //'idhotelscategory'=>'-',
      'status' => $this->input->post('status',TRUE)
      );  
        $this->Smartreport_city_model->insertData('smartreport_hotels',$data);
        $this->session->set_flashdata('input_success','message');        
        redirect(site_url('smartreport/competitor-hotel'));
        }else{
        redirect('errorpage/error403');
    }      
  }

  function update_competitor(){
    $user_level = $this->session->userdata('user_level');
    $check_permission =  $this->Rolespermissions_model->check_permissions($this->contoller_name,$this->function_name,$user_level);    
    if($check_permission->num_rows() == 1){
    $data = array(
      'hotels_name' => ucwords( $this->input->post('hotels_name',TRUE)),
      'total_rooms' => $this->input->post('total_rooms',TRUE),
      'idcity' => $this->input->post('idcity',TRUE),
      'parent' => $this->input->post('idparent',TRUE),
      'hotel_star' => $this->input->post('hotel_star',TRUE),
      'status' => $this->input->post('status',TRUE)
      );  
     
        $this->Smartreport_hotels_model->updateDataHotels('smartreport_hotels', $data, $this->input->post('idcompetitor_old', TRUE));
        $this->session->set_flashdata('update_success','message');
        redirect(site_url('smartreport/competitor-hotel'));
      }else{
        redirect('errorpage/error403');
    }
      
  }

  function delete_competitor($idcompetitor){
    $user_level = $this->session->userdata('user_level');
    $check_permission =  $this->Rolespermissions_model->check_permissions($this->contoller_name,$this->function_name,$user_level);    
    if($check_permission->num_rows() == 1){
    $this->Smartreport_hotels_model->deleteDataHotels($idcompetitor);
    $this->session->set_flashdata('delete_success','message');
    redirect(site_url('smartreport/competitor-hotel'));
    }else{
      redirect('errorpage/error403');
    }
  }


  function list_departement(){
    $user_level = $this->session->userdata('user_level');
    $check_permission =  $this->Rolespermissions_model->check_permissions($this->contoller_name,$this->function_name,$user_level);    
    if($check_permission->num_rows() == 1){
    $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'smartreport/list-departement?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'smartreport/list-departement?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'smartreport/list-departement';
            $config['first_url'] = base_url() . 'smartreport/list-departement';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Smartreport_departement_model->total_rows_departement($q);
        $smartreport_departement = $this->Smartreport_departement_model->get_limit_data_departement($config['per_page'], $start, $q);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $page_data['page_name'] = 'list_departement';
        
        $page_data['lang_dashboard'] = $this->lang->line('dashboard');
        $page_data['lang_dashboard_hotel'] = $this->lang->line('dashboard_hotel');
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

        $page_data['lang_edit_departement'] = $this->lang->line('edit_departement');
        $page_data['lang_delete_departement'] = $this->lang->line('delete_departement');       
        $page_data['lang_search_departement'] = $this->lang->line('search_departement');
        $page_data['lang_background_color'] = $this->lang->line('background_color');
        $page_data['lang_choose_bg_color'] = $this->lang->line('choose_bg_color');
   


        $page_data['smartreport_departement_data'] = $smartreport_departement;
        $page_data['q'] = $q;
        $page_data['pagination'] = $this->pagination->create_links();
        $page_data['total_rows'] = $config['total_rows'];
        $page_data['start'] = $start;

       
        $this->load->view('smartreport/index', $page_data);
    }else{
      redirect('errorpage/error403');
    }

  }

  function insert_departement(){
    $user_level = $this->session->userdata('user_level');
    $check_permission =  $this->Rolespermissions_model->check_permissions($this->contoller_name,$this->function_name,$user_level);    
    if($check_permission->num_rows() == 1){
    $data = array(      
      'deptname' => ucwords($this->input->post('departement',TRUE)),
      'background_class' => $this->input->post('bgcolor',TRUE)
      );  
        $this->Smartreport_departement_model->insertData('smartreport_dept',$data);
        $this->session->set_flashdata('input_success','message');        
        redirect(site_url('smartreport/list-departement'));
        }else{
        redirect('errorpage/error403');
    }      
  }

  function update_departement(){
    $user_level = $this->session->userdata('user_level');
    $check_permission =  $this->Rolespermissions_model->check_permissions($this->contoller_name,$this->function_name,$user_level);    
    if($check_permission->num_rows() == 1){
    $data = array(
      'deptname' => ucwords($this->input->post('departement',TRUE)),
      'background_class' => $this->input->post('bgcolor',TRUE)
      );  
     
        $this->Smartreport_departement_model->updateDataDepartement('smartreport_dept', $data, $this->input->post('iddept_old', TRUE));
        $this->session->set_flashdata('update_success','message');
        
        redirect(site_url('smartreport/list-departement'));
      }else{
        redirect('errorpage/error403');
    }
      
  }

  function delete_departement($iddept){
    $user_level = $this->session->userdata('user_level');
    $check_permission =  $this->Rolespermissions_model->check_permissions($this->contoller_name,$this->function_name,$user_level);    
    if($check_permission->num_rows() == 1){
    $this->Smartreport_departement_model->deleteDataDepartement($iddept);
    $this->session->set_flashdata('delete_success','message');
    redirect(site_url('smartreport/list-departement'));
    }else{
      redirect('errorpage/error403');
    }

  }


  function hotel_competitor_analysis(){
    $user_level = $this->session->userdata('user_level');    
    $user_HotelForHCA = $this->session->userdata('user_hotel');    
    $check_permission =  $this->Rolespermissions_model->check_permissions($this->contoller_name,$this->function_name,$user_level);    
    if($check_permission->num_rows() == 1){

        $getdate_analysis = strtotime($this->input->get('date_analysis', TRUE));
        $date_analysis = date("Y-m-d", $getdate_analysis);
        //$date_analysisMTD = date("Y-m", $getdate_analysis);

        $idcity = $this->input->get('city');

        $user_hotel = $this->session->userdata('user_hotel');
        $page_data['page_name'] = 'hotel_competitor_analysis';
        $page_data['lang_dashboard'] = $this->lang->line('dashboard');
        $page_data['lang_dashboard_hotel'] = $this->lang->line('dashboard_hotel');
        $page_data['lang_user'] = $this->lang->line('user');
        $page_data['lang_add_user'] = $this->lang->line('add_user');
        $page_data['lang_list_users'] = $this->lang->line('list_users');
        $page_data['lang_departement'] = $this->lang->line('departement');
        $page_data['lang_add_departement'] = $this->lang->line('add_departement');
        $page_data['lang_list_departement'] = $this->lang->line('list_departement');
        $page_data['lang_hotel'] = $this->lang->line('hotel');
        $page_data['lang_add_hotel'] = $this->lang->line('add_hotel');
        $page_data['lang_list_hotels'] = $this->lang->line('list_hotels');
        $page_data['lang_competitor_hotels'] = $this->lang->line('competitor_hotels');        
        $page_data['lang_analysis'] = $this->lang->line('analysis');        
        $page_data['lang_hotel_comp_anl'] = $this->lang->line('hotel_comp_anl');        
        $page_data['lang_dsr'] = $this->lang->line('dsr');
        $page_data['lang_view_data'] = $this->lang->line('view_data');
        $page_data['lang_view_data_all'] = $this->lang->line('view_data_all');
        $page_data['lang_add_data'] = $this->lang->line('add_data');
        $page_data['lang_city'] = $this->lang->line('city');
        $page_data['lang_add_city'] = $this->lang->line('add_city');
        $page_data['lang_list_city'] = $this->lang->line('list_city');
        $page_data['lang_setting'] = $this->lang->line('setting');
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

        $page_data['lang_add_data_byhotel'] = $this->lang->line('add_data_byhotel');
        $page_data['lang_competitor_hotels'] = $this->lang->line('competitor_hotels');
        $page_data['lang_room_sold'] = $this->lang->line('room_sold');
        $page_data['lang_avg_room_rate'] = $this->lang->line('avg_room_rate');
        $page_data['lang_gr_last_night'] = $this->lang->line('gr_last_night');
        $page_data['lang_date'] = $this->lang->line('date');
        $page_data['lang_choose_hotels'] = $this->lang->line('choose_hotels');
        $page_data['lang_choose_city'] = $this->lang->line('choose_city');
        $page_data['lang_search'] = $this->lang->line('search');

        

        //EA 1 Minggu ubah2 query baru ketemu -- Eryan Fauzan
        //$smartreport_hca_addhotel = $this->Smartreport_hca_model->get_add_hotel($user_hotel);        
        //$get_hotel4starnow = $this->Smartreport_hca_model->get_hotel4starnow($date_analysis, $id_city)->result();
        //$get_hotel4starMTD = $this->Smartreport_hca_model->get_hotel4starmtd($date_analysis,$id_city,$date_analysisMTD)->result();        
        //$page_data['smartreport_hca_addhotel_data'] = $smartreport_hca_addhotel;
        //$smartreport_hca_edithotel = $this->Smartreport_hca_model->get_update_hotel_correction($date_analysis);        
        //$page_data['smartreport_hca_edithotel_data'] = $smartreport_hca_edithotel;
        //$page_data['get_hotel4star_data'] = $get_hotel4starnow;
        //$page_data['get_hotel4starMTD_data'] = $get_hotel4starMTD;
        $smartreport_hca_addlist = $this->Smartreport_hca_model->get_add_list($user_hotel);
        $page_data['smartreport_hca_addlist_data'] = $smartreport_hca_addlist;
        $getHotel4Star = $this->Smartreport_hca_model->getHotelAllStar($idcity, "4");
        $page_data['getHotel4Star_data'] = $getHotel4Star;
        $getHotel3Star = $this->Smartreport_hca_model->getHotelAllStar($idcity, "3");
        $page_data['getHotel3Star_data'] = $getHotel3Star;
        $getHotel2Star = $this->Smartreport_hca_model->getHotelAllStar($idcity, "2");
        $page_data['getHotel2Star_data'] = $getHotel2Star;
        $getHotelByUser = $this->Smartreport_hca_model->getHotelAllStarByUserHotel($user_HotelForHCA);
        $page_data['getHotelByUser_data'] = $getHotelByUser; 

        $page_data['date_analysis'] = $this->input->get('date_analysis', TRUE);
        $page_data['dateToView'] = $date_analysis;
        $page_data['city'] = $this->input->get('city');
        $page_data['tab'] = $this->input->get('tab');

        $this->load->view('smartreport/index',$page_data);
     }else{
        redirect('errorpage/error403');
     }
  }

  function add_analysis_data(){
    $user_level = $this->session->userdata('user_level');
    $check_permission =  $this->Rolespermissions_model->check_permissions($this->contoller_name,$this->function_name,$user_level);    
    if($check_permission->num_rows() == 1){
    $idhotels = $_POST['idhotels'];
    $room_sold = $_POST['room_sold'];
    $avg_roomrate = $_POST['avg_roomrate'];
    $remark = $_POST['remark'];
    $date_analysis = date_php_to_mysql($this->input->post('date_analysis'));
    $data_analysis = array();
    $count_anl = 0;
    //$idanlysis = str_replace(".", "", uniqid('',true));
    foreach($idhotels as $idh ){       
        
        if($idh != ''){
              $dt_hotel = $this->Smartreport_hca_model->select_hotelcompbydate($idh,$date_analysis)->num_rows();
            if($dt_hotel > 0){
              $this->Smartreport_hca_model->delete_hotelcompbydate($idh,$date_analysis);
            }
            array_push($data_analysis,array(
              //'idanalysis'=> $idhotels[$count_anl].str_replace("-","",$date_analysis),
              'idhotels'=> $idhotels[$count_anl],
              'room_sold'=>$room_sold[$count_anl],
              'avg_roomrate'=>$avg_roomrate[$count_anl],
              'remark'=>$remark[$count_anl],
              'date_analysis'=>$date_analysis,
              'date_created' => date("Y-m-d H:i:s")
              
            ));
            $count_anl++;
      }
    }
    $this->Smartreport_hca_model->insert_analysis_data('smartreport_hca',$data_analysis); 
    $this->session->set_flashdata('input_success','message');        
        redirect(site_url('smartreport/hotel-competitor-analysis'));
      }else{
        redirect('errorpage/error403');
    } 
  }
  

  function add_analysis_data_byhotel(){
    $user_level = $this->session->userdata('user_level');
    $check_permission =  $this->Rolespermissions_model->check_permissions($this->contoller_name,$this->function_name,$user_level);    
    if($check_permission->num_rows() == 1){
      //$idanlysis = str_replace(".", "", uniqid('',true));
      $idhotels= $this->input->post('idhotels', TRUE);
      $date_analysis = date_php_to_mysql($this->input->post('date_analysis'));
     $dt_hotel = $this->Smartreport_hca_model->select_hotelcompbydate($idhotels,$date_analysis);
        if($dt_hotel->num_rows() > 0){
          $data = array(    
            'room_sold'=>$this->input->post('room_sold', TRUE),
            'avg_roomrate'=>$this->input->post('avg_roomrate', TRUE),
            'remark'=>$this->input->post('remark', TRUE));  
            $this->Smartreport_hca_model->update_hotelcompbyid($dt_hotel->row()->idanalysis,$data);

        }else{
          $data = array(       
            'idhotels'=> $idhotels,
            'room_sold'=>$this->input->post('room_sold', TRUE),
            'avg_roomrate'=>$this->input->post('avg_roomrate', TRUE),
            'remark'=>$this->input->post('remark', TRUE),
            'date_analysis'=>$date_analysis,
            'date_created' => date("Y-m-d H:i:s")
            );  
            $this->Smartreport_hca_model->insertData('smartreport_hca',$data);
        }
        $this->session->set_flashdata('input_success','message');        
        redirect(site_url('smartreport/hotel-competitor-analysis'));
    }else{
      redirect('errorpage/error403');
    } 

  }


/*FUNCTION AJAX*/
  function get_idhotels_availability() {
		if (isset($_POST['idhotels'])) {
			$idhotels = $_POST['idhotels'];
			$results = $this->Smartreport_hotels_model->get_idhotels($idhotels);
			if ($results === TRUE) {
				echo '<span class="form-text text-danger">Hotel ID Already Used</span>';
			} else {
				echo '<span class="form-text text-success">Hotel ID Available</span>';
			}
		} else {
			echo '<span class="form-text text-danger">Hotel ID Required</span>';
		}
  }
  
  function get_idcompetitor_availability() {
		if (isset($_POST['idcompetitor'])) {
			$idcompetitor = $_POST['idcompetitor'];
			$results = $this->Smartreport_hotels_model->get_idcompetitor($idcompetitor);
			if ($results === TRUE) {
				echo '<span class="form-text text-danger">Competitor ID Already Used</span>';
			} else {
				echo '<span class="form-text text-success">Competitor ID Available</span>';
			}
		} else {
			echo '<span class="form-text text-dager">Competitor ID Required</span>';
		}
	}


  //function 
  /*function correction_data_analysis(){
    $user_level = $this->session->userdata('user_level');
    if($user_level === '1' || $user_level === '2' ){

        $getdate_analysis = strtotime($this->input->get('date_analysis', TRUE));
        $date_analysis= date("Y-m-d", $getdate_analysis);
        $page_data['page_name'] = 'correction_analysis_data';

        $page_data['lang_dashboard'] = $this->lang->line('dashboard');
        $page_data['lang_user'] = $this->lang->line('user');
        $page_data['lang_add_user'] = $this->lang->line('add_user');
        $page_data['lang_list_users'] = $this->lang->line('list_users');
        $page_data['lang_departement'] = $this->lang->line('departement');
        $page_data['lang_add_departement'] = $this->lang->line('add_departement');
        $page_data['lang_list_departement'] = $this->lang->line('list_departement');
        $page_data['lang_hotel'] = $this->lang->line('hotel');
        $page_data['lang_add_hotel'] = $this->lang->line('add_hotel');
        $page_data['lang_list_hotels'] = $this->lang->line('list_hotels');
        $page_data['lang_competitor_hotels'] = $this->lang->line('competitor_hotels');        
        $page_data['lang_analysis'] = $this->lang->line('analysis');        
        $page_data['lang_hotel_comp_anl'] = $this->lang->line('hotel_comp_anl');        
        $page_data['lang_dsr'] = $this->lang->line('dsr');
        $page_data['lang_view_data'] = $this->lang->line('view_data');
        $page_data['lang_add_data'] = $this->lang->line('add_data');
        $page_data['lang_city'] = $this->lang->line('city');
        $page_data['lang_add_city'] = $this->lang->line('add_city');
        $page_data['lang_list_city'] = $this->lang->line('list_city');
        $page_data['lang_setting'] = $this->lang->line('setting');

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
        $page_data['lang_search'] = $this->lang->line('search');

        $page_data['lang_hotel_name'] = $this->lang->line('hotel_name');
        $page_data['lang_room_sold'] = $this->lang->line('room_sold');
        $page_data['lang_avg_room_rate'] = $this->lang->line('avg_room_rate');
        $page_data['lang_rooms'] = $this->lang->line('rooms');
        $page_data['lang_gr_last_night'] = $this->lang->line('gr_last_night');
        $page_data['lang_date'] = $this->lang->line('date');
        $page_data['lang_edit'] = $this->lang->line('edit');
        $page_data['lang_delete'] = $this->lang->line('delete');

        $smartreport_hca_edithotel = $this->Smartreport_hca_model->get_update_hotel_correction($date_analysis);
        
        $page_data['smartreport_hca_edithotel_data'] = $smartreport_hca_edithotel;

        $this->load->view('smartreport/index', $page_data);

    }else{
      redirect('errorpage/error403');
    } 
  }

  function correction_data_analysis_update(){

  }*/

  
  

}
