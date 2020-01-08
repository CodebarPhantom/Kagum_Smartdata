<?php defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Smartreportforecast extends CI_Controller{

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
      $this->load->model('Smartreport_forecast_model');
      $this->load->library('form_validation');
      $this->load->library('pagination');
      $this->load->library('session');
      $this->load->library('uploadfile');
     
      $this->load->helper('form');
      $this->load->helper('url');
      $this->load->helper('mydate');
      $this->load->helper('text');
      
  }

  function forecast7days_export(){
    $excelForecast = new Spreadsheet();
    // Settingan awal file excel
    $excelForecast->getProperties()->setCreator('Eryan Fauzan')
    ->setLastModifiedBy('Eryan Fauzan')
    ->setTitle("Forecast Kagum Hotels")
    ->setSubject("Forecast Kagum Hotels")
    ->setDescription("Created By Eryan Fauzan")
    ->setKeywords("Forecast Kagum Hotels");

    $jj=2;
    $kk=9;
    $ll=4;

    $sheet = $excelForecast->getActiveSheet();
    $sheet->mergeCells('A1:H1');
    $sheet->setCellValue('A1', "Forecast Kagum Hotels ".date("d F Y"));
    $hotelsResult = $this->db
                        ->select("h.idhotels, h.idcity, c.city_name, hct.idhotelscategory, hct.hotels_category, h.parent, h.hotels_name, h.total_rooms, h.hotel_star, h.status, h.date_created")       
                        ->from("smartreport_hotels as h")
                        ->join("smartreport_city as c", "h.idcity=c.idcity","left")
                        ->join("smartreport_hotelscategory as hct", "hct.idhotelscategory=h.idhotelscategory","left")     
                        ->where("h.parent='parent' and h.status='active'")
                        ->order_by("h.hotels_name", "ASC")->get();
    $hotelsRows = $hotelsResult->num_rows();  
    if($hotelsRows > 0){
      $hotelsData = $hotelsResult->result();
      
        
      for($hd=0; $hd<count($hotelsData); $hd++){
        $hotels_name = $hotelsData[$hd]->hotels_name;
        
        $sheet->mergeCells('A'.$jj.':A'.$kk);
        $sheet->setCellValue("A$jj", "$hotels_name"); 
        
        $jj+=8;
        $kk+=8;
        
      }

      
      unset($hotelsData);
    }
    unset($hotelsResult);
    unset($hotelsRows);                        

		
        
		$writer = new Xlsx($excelForecast);
		
		$filename = 'Forecast Kagum Hotels';
		
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'. $filename .'.xlsx"'); 
		header('Cache-Control: max-age=0');
		$writer->save('php://output');
	}

  function forecast7days(){
      //Allowing akses to smartreport only
    $user_level = $this->session->userdata('user_level');
    $user_HotelForForecast = $this->session->userdata('user_hotel');
    // buat ngecek misal si user nakal main masukin URL
    $check_permission =  $this->Rolespermissions_model->check_permissions($this->contoller_name,$this->function_name,$user_level);    
      if($check_permission->num_rows() == 1){

        
        
        $page_data['page_name'] = 'forecast7days';

        $page_data['lang_sevendays_forecast'] = $this->lang->line('sevendays_forecast');
        $page_data['lang_hotel'] = $this->lang->line('hotel');
        $page_data['lang_choose_hotels'] = $this->lang->line('choose_hotels');
        $page_data['lang_description'] = $this->lang->line('description');
        $page_data['lang_room_available'] = $this->lang->line('room_available');
        $page_data['lang_avg_room_rate'] = $this->lang->line('avg_room_rate');
        $page_data['lang_last_update'] = $this->lang->line('last_update');
        $page_data['lang_forecast'] = $this->lang->line('forecast');
        $page_data['lang_add_data'] = $this->lang->line('add_data');
        $page_data['lang_outoforder'] = $this->lang->line('outoforder');



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
        
        $get_data_hotels =  $this->Smartreport_forecast_model->get_data_hotels();
        $page_data['get_data_hotels'] = $get_data_hotels;
        $page_data['idhotel_custom'] = $user_HotelForForecast;
        

        $this->load->view('smartreport/index',$page_data);
     }else{
        redirect('errorpage/error403');
     }
  }

  function add_forecast7days_data(){
  //Allowing akses to smartreport only
  $user_level = $this->session->userdata('user_level');
  $user_HotelForForecast = $this->session->userdata('user_hotel');
  // buat ngecek misal si user nakal main masukin URL
  $check_permission =  $this->Rolespermissions_model->check_permissions($this->contoller_name,$this->function_name,$user_level);    
    if($check_permission->num_rows() == 1){
        $idhotels= $this->session->userdata('user_hotel');
        $getidhotel_custom = $this->input->post('idhotelcustom', TRUE);
            if($getidhotel_custom == NULL || $getidhotel_custom == '' ){
                $getidhotel_custom = $idhotels; 
            }
        $room_out = $_POST['room_out'];
        $confirmed = $_POST['confirmed'];
        $tentative = $_POST['tentative'];
        $arr = $_POST['arr'];
        $date_forecast = $_POST['date_forecast'];
        $count_forecast = 0;
        $data_forecast = array();
        
        foreach($room_out as $roo ){
            if($roo != ''){
                $dt_forecast = $this->Smartreport_forecast_model->select_forecast_byiddate($getidhotel_custom)->num_rows();
                if($dt_forecast > 0){
                  $this->Smartreport_forecast_model->delete_forecast_byiddate($getidhotel_custom);
                }
                array_push($data_forecast,array(             
                  'idhotels'=>$getidhotel_custom,
                  'iduser'=>$this->session->userdata('iduser'),
                  'outoforder'=>$room_out[$count_forecast],
                  'confirmed'=>$confirmed[$count_forecast],
                  'tentative'=>$tentative[$count_forecast],
                  'arr'=>$arr[$count_forecast],
                  'date_forecast'=>$date_forecast[$count_forecast],
                  'date_created' => date("Y-m-d H:i:s")
                  
                ));
                $count_forecast++;
          }
        }
            $this->Smartreport_forecast_model->insert_batch_data('smartreport_forecast',$data_forecast); 
            $this->session->set_flashdata('input_success','message');        
            redirect(site_url('smartreportforecast/forecast7days'));
    }else{
      redirect('errorpage/error403');
    }
  }

}