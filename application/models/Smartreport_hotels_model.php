<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Smartreport_hotels_model extends CI_Model
{


    function __construct()
    {
        parent::__construct();
    }

    // get all
    public function insertData($table,$data)
    {
        $this->db->insert($table, $data);
    }  


    function get_idhotels($idhotels) {
      
		$this->db->where('idhotels', $idhotels);
		$this->db->limit(1);
		$query = $this->db->get("smartreport_hotels");

		if ($query->num_rows() == 1) {
			return TRUE;
		}
		
		return FALSE;
    }
    
    function get_idcompetitor($idcompetitor) {
      
		$this->db->where('idhotels', $idcompetitor);
		$this->db->limit(1);
		$query = $this->db->get("smartreport_hotels");

		if ($query->num_rows() == 1) {
			return TRUE;
		}
		
		return FALSE;
	}

    // Query Data from Table with Order;
    public function getDataAll($table, $order_column, $order_type){
        $this->db->order_by("$order_column", "$order_type");
        $query = $this->db->get("$table");
        $result = $query->result();
        $this->db->save_queries = false;
        return $result;
    }
    public function getDataParent($table, $order_column, $parent, $order_type ){
        $this->db->where("parent = '$parent' and status = 'active' ");
        $this->db->order_by("$order_column", "$order_type");
        $query = $this->db->get("$table");
        $result = $query->result();
        $this->db->save_queries = false;
        return $result;
    }

    public function getDataHotelParent($table, $order_column, $parent, $order_type ){
        $this->db->where("parent = '$parent'");
        $this->db->order_by("$order_column", "$order_type");
        $query = $this->db->get("$table");
        $result = $query->result();
        $this->db->save_queries = false;
        return $result;
    }

    // get total rows
    function total_rows_hotels($q = NULL) {
        $this->db->select('h.idhotels, h.idcity, c.city_name, hct.idhotelscategory, hct.hotels_category, h.parent, h.hotels_name, h.total_rooms, h.hotel_star, h.status, h.date_created');       
        $this->db->from('smartreport_hotels as h');
        $this->db->join('smartreport_city as c', 'h.idcity=c.idcity','left');
        $this->db->join('smartreport_hotelscategory as hct', 'hct.idhotelscategory=h.idhotelscategory','left');
        if ($q !== NULL){
            $this->db->like('h.hotels_name', $q);
        } 
        $this->db->where('h.parent', 'PARENT');
        $this->db->order_by('h.hotels_name', 'ASC');
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data_hotels($limit, $start = 0, $q = NULL) {
        $this->db->select('h.idhotels, h.idcity, c.city_name, hct.idhotelscategory, hct.hotels_category, h.parent, h.hotels_name, h.total_rooms, h.hotel_star, h.status, h.date_created');       
        $this->db->from('smartreport_hotels as h');
        $this->db->join('smartreport_city as c', 'h.idcity=c.idcity','left');
        $this->db->join('smartreport_hotelscategory as hct', 'hct.idhotelscategory=h.idhotelscategory','left');
        if ($q !== NULL){
            $this->db->like('h.hotels_name', $q);
        } 
        $this->db->where('h.parent', 'PARENT');
        $this->db->order_by('h.hotels_name', 'ASC');
        $this->db->limit($limit, $start);
        return $this->db->get()->result();
    }

    // update data
    public function updateDataHotels($table, $data, $idhotels_old)
    {
        $this->db->where('idhotels', $idhotels_old);
        $this->db->update("$table", $data);

        return true;
    }

    function deleteDataHotels($idhotels){
        $this->db->where('idhotels', $idhotels);
        $this->db->delete('smartreport_hotels');
    }

        // get total rows
    function total_rows_competitor($competitor = NULL, $city = NULL, $listhotel = NULL) {
        $this->db->select('h1.idhotels as idcompetitor, h.idhotels, h1.idcity, c.city_name, h.hotels_name, h1.hotels_name as competitor, h1.total_rooms, h1.hotel_star, h1.status, h1.type_competitor, h1.date_created');       
        $this->db->from('smartreport_hotels as h');        
        $this->db->join('smartreport_hotels as h1', 'h.idhotels=h1.parent','left');
        $this->db->join('smartreport_city as c', 'h1.idcity=c.idcity','left');
        if($city !== 'all'){
            $this->db->like('h1.idcity', $city);
        }
        if($listhotel !== 'all'){
            $this->db->like('h.idhotels', $listhotel);
        }
        if ($competitor !== NULL){
            $this->db->like('h1.hotels_name', $competitor);
        } 
        $this->db->where('h1.parent !=', 'PARENT');
        $this->db->order_by('h1.hotels_name', 'ASC');
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data_competitor($limit, $start = 0, $competitor = NULL, $city = NULL, $listhotel = NULL) {
        $this->db->select('h1.idhotels as idcompetitor, h.idhotels, h1.idcity, c.city_name,  h.hotels_name, h1.hotels_name as competitor, h1.total_rooms, h1.hotel_star, h1.status, h1.type_competitor, h1.date_created');       
        $this->db->from('smartreport_hotels as h');
              
        $this->db->join('smartreport_hotels as h1', 'h.idhotels=h1.parent','left');
        $this->db->join('smartreport_city as c', 'h1.idcity=c.idcity','left');  
        if($city !== 'all'){
            $this->db->like('h1.idcity', $city);
        }
        if($listhotel !== 'all'){
            $this->db->like('h.idhotels', $listhotel);
        }
        if ($competitor !== NULL){
            $this->db->like('h1.hotels_name', $competitor);
        } 
        $this->db->where('h1.parent !=', 'PARENT');
        $this->db->order_by('h1.hotels_name', 'ASC');
        $this->db->limit($limit, $start);
        return $this->db->get()->result();
    }

    function total_rows_categoryhotels($q = NULL) {        
        $this->db->like('hotels_category', $q);
        $this->db->from('smartreport_hotelscategory');
    return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data_categoryhotels($limit, $start = 0, $q = NULL) {        
        $this->db->order_by('hotels_category', 'ASC');
        $this->db->like('hotels_category', $q);
        $this->db->from('smartreport_hotelscategory');
        $this->db->limit($limit, $start);
    return $this->db->get()->result();
    }

    function updatedata_categoryhotels($table, $data, $ididcategoryhotels){
        $this->db->where('idhotelscategory', $ididcategoryhotels);
        $this->db->update("$table", $data);

        return true;
    }

    function deletedata_categoryhotels($idhotels){
        $this->db->where('idhotelscategory', $idhotels);
        $this->db->delete('smartreport_hotelscategory');
    }

}
