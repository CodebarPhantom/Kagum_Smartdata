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
        $this->db->select("ds.iddsr, ds.idhotels, ds.sales_fnb, ds.sales_other, ds.numberofguest, ds.date_dsr, ds.sales_outoforder, ds.date_created");
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

    function select_outofordermtd_perhotel($startdate,$enddate,$hotel) {
        $this->db->select("COALESCE(SUM(ds.sales_outoforder),0) AS OUTOFORDER_MTD"); // ane ubah biar dapet return 0
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

    function select_outoforderytd_perhotel($startdate,$enddate,$hotel){
        $this->db->select("SUM(ds.sales_outoforder) AS OUTOFORDER_YTD");
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

    function get_data_brand() {     
        $this->db->from("smartreport_hotelscategory");
        $this->db->order_by('hotelscategory_order', 'ASC');
        return $this->db->get()->result();
    }

    function select_hotel_bybrand($idhotelscategory){
        $this->db->select('idhotels, idhotelscategory, hotels_name, total_rooms, status');  
        $this->db->order_by('hotels_name', 'ASC'); 
        $this->db->from('smartreport_hotels');
        $this->db->where('idhotelscategory', $idhotelscategory);
        $this->db->where('status', 'active');
        return $this->db->get()->result();
    }

    function room_revenue_today($date, $brandhotel){
        $this->db->select("sum(hc.room_sold *hc.avg_roomrate) as room_revenue_today");
        $this->db->from("smartreport_hca as hc");
        $this->db->join("smartreport_hotels as ht", "hc.idhotels = ht.idhotels", "left");
        $this->db->join("smartreport_hotelscategory as ha", "ht.idhotelscategory = ha.idhotelscategory", "left");
        if($brandhotel === 'ALL'){
            $this->db->where("hc.date_analysis = '$date' AND ht.parent = 'PARENT' ");
        }else{
            $this->db->where("hc.date_analysis = '$date' AND ht.idhotelscategory = '$brandhotel'");
        }
        
        return $this->db->get()->row();
    }

    function fnbother_revenue_today($date, $brandhotel){
        $this->db->select("sum(sales_fnb) as fnb_rev_today, sum(sales_other) as oth_rev_other");
        $this->db->from("smartreport_dsr as ds");
        $this->db->join("smartreport_hotels as ht", "ds.idhotels = ht.idhotels", "left");
        $this->db->join("smartreport_hotelscategory as ha", "ht.idhotelscategory = ha.idhotelscategory", "left");
        if($brandhotel === 'ALL'){
            $this->db->where("ds.date_dsr = '$date' AND ht.parent = 'PARENT'");
        }else{
            $this->db->where("ds.date_dsr = '$date' AND ht.idhotelscategory = '$brandhotel'");
        }
        return $this->db->get()->row();
    }

    function room_revenue_mtd($startdate,$enddate,$brandhotel){
        $this->db->select("sum(hc.room_sold *hc.avg_roomrate) as room_revenue_today");
        $this->db->from("smartreport_hca as hc");
        $this->db->join("smartreport_hotels as ht", "hc.idhotels = ht.idhotels", "left");
        $this->db->join("smartreport_hotelscategory as ha", "ht.idhotelscategory = ha.idhotelscategory", "left");
        if($brandhotel === 'ALL'){
            $this->db->where("hc.date_analysis BETWEEN '$startdate' AND '$enddate' AND ht.parent = 'PARENT'");
        }else{
            $this->db->where("hc.date_analysis BETWEEN '$startdate' AND '$enddate' AND ht.idhotelscategory = '$brandhotel'");
        }
        return $this->db->get()->row();
    }

    function fnbother_revenue_mtd($startdate,$enddate,$brandhotel){
        $this->db->select("sum(sales_fnb) as fnb_rev_today, sum(sales_other) as oth_rev_other");
        $this->db->from("smartreport_dsr as ds");
        $this->db->join("smartreport_hotels as ht", "ds.idhotels = ht.idhotels", "left");
        $this->db->join("smartreport_hotelscategory as ha", "ht.idhotelscategory = ha.idhotelscategory", "left");
        if($brandhotel === 'ALL'){
            $this->db->where("ds.date_dsr BETWEEN '$startdate' AND '$enddate' AND ht.parent = 'PARENT'");
        }else{
            $this->db->where("ds.date_dsr BETWEEN '$startdate' AND '$enddate' AND ht.idhotelscategory = '$brandhotel'");
        }
        return $this->db->get()->row();
    }

    function mtd_budgetbybrand($permonth, $peryear, $brandhotel){
        $this->db->select("sum(budget_value) as budget_brand");
        $this->db->from("smartreport_budget as sb");
        $this->db->join("smartreport_pnllist as sp", "sb.idpnl = sp.idpnl", "left");
        $this->db->join("smartreport_hotels as ht", "sb.idhotels = ht.idhotels", "left");
        $this->db->join("smartreport_hotelscategory as ha", "ht.idhotelscategory = ha.idhotelscategory", "left");
        if($brandhotel === 'ALL'){
            $this->db->where("MONTH(sb.date_budget) ='$permonth' AND YEAR(sb.date_budget) = '$peryear' AND sp.idpnlcategory = '2'  AND ht.parent = 'PARENT'");
        }else{
            $this->db->where("MONTH(sb.date_budget) ='$permonth' AND YEAR(sb.date_budget) = '$peryear' AND sp.idpnlcategory = '2' AND ht.idhotelscategory = '$brandhotel'");
        }
        
        return $this->db->get()->row();
    }

    function get_allparenthotel(){
        $this->db->select("idhotels, hotels_name");
        $this->db->from("smartreport_hotels");
        $this->db->where("parent","PARENT");
        $this->db->where("status", "active");
        $this->db->order_by("hotels_name", "DESC");
        return $this->db->get()->result();
    }

}