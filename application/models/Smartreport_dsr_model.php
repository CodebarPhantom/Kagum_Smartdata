<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Smartreport_dsr_model extends CI_Model
{

    
    function __construct()
    {
        parent::__construct();
    }

    function insertData($table,$data)
    {
        $this->db->insert($table,$data);
    } 

    function select_hoteldsrbydate($idh, $date_dsr){
        $this->db->select('*');
        $this->db->from('smartreport_dsr');
        $this->db->where('idhotels', $idh );
        $this->db->where('date_dsr', $date_dsr);
        return $this->db->get();
    }

    function update_hoteldsrbyid($id,$data){
        $this->db->where('iddsr', $id);
        $this->db->update('smartreport_dsr',$data);
        return true;
    }

    function select_dsrondate_perhotel($hotel=NULL, $date=NULL){
        $this->db->select("*");
        $this->db->from("smartreport_dsr as ds");
        $this->db->where("ds.idhotels", $hotel);
        $this->db->where("ds.date_dsr", $date);
        return $this->db->get()->row();
    }

    function select_guestmtd_perhotel($startdate,$enddate,$hotel) {
        $this->db->select("COALESCE(SUM(ds.numberofguest),0) AS GUEST_MTD"); // ane ubah biar dapet return 0
        $this->db->from("smartreport_dsr as ds");
        $this->db->where("ds.date_dsr BETWEEN '$startdate' AND '$enddate'");
        $this->db->where("ds.idhotels", $hotel);
        return $this->db->get()->row();        
    }

    function select_fnbmtd_perhotel($startdate,$enddate,$hotel) {
        $this->db->select("COALESCE(SUM(ds.sales_fnb),0) AS FNB_MTD"); // ane ubah biar dapet return 0
        $this->db->from("smartreport_dsr as ds");
        $this->db->where("ds.date_dsr BETWEEN '$startdate' AND '$enddate'");
        $this->db->where("ds.idhotels", $hotel);
        return $this->db->get()->row();        
    }

    function select_othmtd_perhotel($startdate,$enddate,$hotel) {
        $this->db->select("COALESCE(SUM(ds.sales_other),0) AS OTH_MTD"); // ane ubah biar dapet return 0
        $this->db->from("smartreport_dsr as ds");
        $this->db->where("ds.date_dsr BETWEEN '$startdate' AND '$enddate'");
        $this->db->where("ds.idhotels", $hotel);
        return $this->db->get()->row();        
    }

    function select_guestytd_perhotel($startdate,$enddate,$hotel){
        $this->db->select("SUM(ds.numberofguest) AS GUEST_YTD");
        $this->db->from("smartreport_dsr as ds");
        $this->db->where("ds.date_dsr BETWEEN '$startdate' AND '$enddate'");
        $this->db->where("ds.idhotels", $hotel);
        return $this->db->get()->row(); 
    }

    function select_fnbytd_perhotel($startdate,$enddate,$hotel){
        $this->db->select("SUM(ds.sales_fnb) AS FNB_YTD");
        $this->db->from("smartreport_dsr as ds");
        $this->db->where("ds.date_dsr BETWEEN '$startdate' AND '$enddate'");
        $this->db->where("ds.idhotels", $hotel);
        return $this->db->get()->row(); 
    }

    function select_othytd_perhotel($startdate,$enddate,$hotel){
        $this->db->select("SUM(ds.sales_other) AS OTH_YTD");
        $this->db->from("smartreport_dsr as ds");
        $this->db->where("ds.date_dsr BETWEEN '$startdate' AND '$enddate'");
        $this->db->where("ds.idhotels", $hotel);
        return $this->db->get()->row(); 
    }

}