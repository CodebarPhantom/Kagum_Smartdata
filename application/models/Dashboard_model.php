<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dashboard_model extends CI_Model
{

    

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getDataHotel($user_ho){
        $this->db->select('u.idhotels, h.hotels_name, h.total_rooms');
        $this->db->from('smartreport_users as u');
        $this->db->join('smartreport_hotels as h', 'u.idhotels=h.idhotels','left');
        $this->db->where('parent','PARENT');
        $this->db->where('h.idhotels', $user_ho);
        $query = $this->db->get()->row();
        //$result = $query->result();
        $this->db->save_queries = false;
        return $query;
    }
    
    
}    