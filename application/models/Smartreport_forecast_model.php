<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Smartreport_forecast_model extends CI_Model
{


    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function insert_batch_data($table,$data){
        $this->db->insert_batch($table, $data);
    } 

    function get_data_hotels() {
        $this->db->select("h.idhotels, h.idcity, c.city_name, hct.idhotelscategory, hct.hotels_category, h.parent, h.hotels_name, h.total_rooms, h.hotel_star, h.status, h.date_created");       
        $this->db->from("smartreport_hotels as h");
        $this->db->join("smartreport_city as c", "h.idcity=c.idcity","left");
        $this->db->join("smartreport_hotelscategory as hct", "hct.idhotelscategory=h.idhotelscategory","left");        
        $this->db->where("h.parent='parent' and h.status='active'");
        $this->db->order_by("h.hotels_name", "ASC");       
        return $this->db->get()->result();
    }

    function select_forecast_byiddate($idhotels){
        $this->db->select('*');
        $this->db->from('smartreport_forecast');
        $this->db->where('idhotels', $idhotels);
        //$this->db->where('date_forecast', $date_forecast);
        return $this->db->get();
    }

    function delete_forecast_byiddate($idhotels){       
        
        $this->db->where('idhotels', $idhotels);
        //$this->db->where('date_forecast', $date_forecast);
        $this->db->delete('smartreport_forecast');
    }

}