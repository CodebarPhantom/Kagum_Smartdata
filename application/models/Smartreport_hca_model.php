<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Smartreport_hca_model extends CI_Model
{

    
    function __construct()
    {
        parent::__construct();
    }


    function get_add_hotel($user_hotel) {
        $this->db->select('idhotels, hotels_name, hotel_star');       
        $this->db->from('smartreport_hotels'); 
        $this->db->where('idhotels', $user_hotel); 
        $this->db->where('parent', 'PARENT');
        $this->db->where('status', 'active');
        //$this->db->where('h1.parent !=', 'PARENT');
        //$this->db->order_by('h1.hotels_name', 'ASC');
        return $this->db->get()->row();
    }

    function get_add_list($user_hotel) {
        $this->db->select('h1.idhotels as idcompetitor, h.idhotels, h1.idcity, c.city_name,  h.hotels_name, h1.hotels_name as competitor, h1.total_rooms, h1.hotel_star, h1.status, h1.date_created');       
        $this->db->from('smartreport_hotels as h');              
        $this->db->join('smartreport_hotels as h1', 'h.idhotels=h1.idhotels','left');
        $this->db->join('smartreport_city as c', 'h1.idcity=c.idcity','left');
        $this->db->where('h1.parent', $user_hotel);
        $this->db->where('h1.status', 'active');
        $this->db->or_where('h1.idhotels', $user_hotel);
        //$this->db->where('h1.parent !=', 'PARENT');
        $this->db->order_by('h1.hotels_name', 'ASC');
        return $this->db->get()->result();
    }

    /*function get_update_hotel_correction($date_analysis=NULL) {
        $user_hotel = $this->session->userdata('user_hotel');
        return $this->db->query("SELECT hc.idanalysis, hc.idhotels, ho.hotels_name, hc.room_sold, hc.avg_roomrate,hc.remark, hc.date_analysis
        from smartreport_hca as hc
        left join smartreport_hotels as ho on hc.idhotels=ho.idhotels
        WHERE  ho.idhotels = '$user_hotel' and hc.date_analysis >= '$date_analysis 00:00:00' and hc.date_analysis <= '$date_analysis 23:59:59'
        
        UNION
        
        SELECT hc.idanalysis, hc.idhotels, ho.hotels_name, hc.room_sold, hc.avg_roomrate, hc.remark,hc.date_analysis
        from smartreport_hca as hc
        left join smartreport_hotels as ho on hc.idhotels=ho.idhotels
        WHERE  ho.parent = '$user_hotel' and hc.date_analysis >= '$date_analysis 00:00:00' and hc.date_analysis <= '$date_analysis 23:59:59'
        ORDER BY hotels_name ASC")->result();
    }*/

    /*function get_hotel4starnow($date_analysis = NULL, $idcity = NULL){
        $this->db->select("
        ht.hotels_name, ht.status, ht.total_rooms, 
        COALESCE(hc.room_sold,0) as roomsold_now, 
        truncate(COALESCE((hc.room_sold/ht.total_rooms)*100,0),2) as occupancy_now,
        COALESCE(hc.avg_roomrate,0) as arr_now,
        COALESCE((hc.room_sold*hc.avg_roomrate),0) as roomrevenue_now,
        truncate(COALESCE((hc.avg_roomrate*hc.room_sold)/ht.total_rooms,0),2) as revpar_now,
        hc.remark as groupln");
        $this->db->from("smartreport_hotels as ht");
        $this->db->join("smartreport_city as ct", "ht.idcity=ct.idcity", "left");
        $this->db->join("smartreport_hca as hc","hc.idhotels=ht.idhotels and hc.date_analysis = '$date_analysis'","left");
        //$this->db->join("smartreport_calendar as ca","ca.calendar_date ='$date_analysis'"  ,"left");
        $whereHotel4Star="ht.status = 'active' AND ht.hotel_star = '4' AND ht.idcity ='$idcity' ";
        $this->db->where($whereHotel4Star);
        $this->db->group_by("ht.idhotels");
        return $this->db->get();
    }*/

    //summary
    function getHotelByUserHotel($idhotels){
        $this->db->select("*");
        $this->db->from("smartreport_hotels as ht");   
        $this->db->where("idhotels", $idhotels);
        return $this->db->get();
    }
    function getOccTotalMTDHotelById($startdate,$enddate,$idhotels){
        $this->db->select("(sum(hc.room_sold)/sum(ht.total_rooms)) as graph_OccMTD");
        $this->db->from("smartreport_hotels as ht");
        $this->db->join("smartreport_hca as hc ", "ht.idhotels = hc.idhotels", "LEFT");
        $this->db->where("hc.date_analysis BETWEEN '$startdate' AND '$enddate' AND ht.idhotels ='$idhotels'");
        return $this->db->get()->row();   
    }

    //perhitungan untuk Graph
    function getHotelAllStarByUserHotel($idhotels){
        $this->db->select('h1.idhotels as idcompetitor, h.idhotels, h1.idcity, c.city_name,  h.hotels_name, h1.hotels_name as competitor, h1.total_rooms, h1.hotel_star, h1.status, h1.date_created');       
        $this->db->from('smartreport_hotels as h');              
        $this->db->join('smartreport_hotels as h1', 'h.idhotels=h1.idhotels','left');
        $this->db->join('smartreport_city as c', 'h1.idcity=c.idcity','left');
        $this->db->where('h1.parent', $idhotels);
        $this->db->where('h1.status', 'active');
        $this->db->or_where('h1.idhotels', $idhotels);
        //$this->db->where('h1.parent !=', 'PARENT');
        $this->db->order_by('h1.hotels_name', 'ASC');
        return $this->db->get();
    }

    function getDailyArrForGraphById($idhotels, $daily){
        $this->db->select("truncate(COALESCE(sum(hc.avg_roomrate),0),0) as graph_ArrDaily");
        $this->db->from("smartreport_hca as hc");   
        $this->db->where("date_analysis = '$daily' and hc.idhotels = '$idhotels'");
        return $this->db->get()->row();
    }

    function getDailyOccForGraphById($idhotels, $daily){
        $this->db->select("truncate(COALESCE(sum(hc.room_sold/ht.total_rooms),0)*100,2) as graph_OccDaily");
        $this->db->from("smartreport_hca as hc");
        $this->db->join("smartreport_hotels as ht", "hc.idhotels = ht.idhotels", "left");  
        $this->db->where("date_analysis = '$daily' and hc.idhotels = '$idhotels'");
        return $this->db->get()->row();
    }

    function getDailyTrrForGraphById($idhotels, $daily){
        $this->db->select("truncate(COALESCE(sum((hc.room_sold*hc.avg_roomrate)),0),0) as graph_TrrDaily");
        $this->db->from("smartreport_hca as hc");
        $this->db->join("smartreport_hotels as ht", "hc.idhotels = ht.idhotels", "left");     
        $this->db->where("date_analysis = '$daily' and hc.idhotels = '$idhotels'");
        return $this->db->get()->row();
    }

    function getDailyRevparForGraphById($idhotels, $daily){
        $this->db->select("truncate(COALESCE(sum((hc.room_sold*hc.avg_roomrate)/ht.total_rooms),0),0) as graph_RevparDaily");
        $this->db->from("smartreport_hca as hc");
        $this->db->join("smartreport_hotels as ht", "hc.idhotels = ht.idhotels", "left");     
        $this->db->where("date_analysis = '$daily' and hc.idhotels = '$idhotels'");
        return $this->db->get()->row();
    }

    function getOccTotalMTDAllStarById($startdate,$enddate){
        $this->db->select("(sum(hc.room_sold)/sum(ht.total_rooms)) as graph_OccMTD");
        $this->db->from("smartreport_hotels as ht");
        $this->db->join("smartreport_hca as hc ", "ht.idhotels = hc.idhotels", "LEFT");
        $this->db->where("hc.date_analysis BETWEEN '$startdate' AND '$enddate'");
        return $this->db->get()->row();   
    }



    // Filter UTAMA biar bisa per Kota / CITY untuk hotel competitor anlysis
    function getHotelAllStar($idcity = NULL, $star = NULL){
        $this->db->select("ht.idhotels,ht.hotels_name, ht.status, ht.total_rooms");
        $this->db->from("smartreport_hotels as ht");
        $this->db->join("smartreport_city as ct", "ht.idcity=ct.idcity", "left");
        $whereHotelAllStar="ht.status = 'active' AND ht.hotel_star = '$star' AND ht.idcity ='$idcity'  ";
        $this->db->group_by("ht.idhotels");
        $this->db->where($whereHotelAllStar);
        return $this->db->get();
    }

    function select_competitoranalysisondate_perhotel($hotel=NULL, $date=NULL){
        $this->db->select("hc.idhotels, hc.room_sold, hc.date_analysis, hc.avg_roomrate, hc.remark");
        $this->db->from("smartreport_hca as hc");
        $this->db->where("hc.idhotels", $hotel);
        $this->db->where("hc.date_analysis", $date);
        return $this->db->get()->row();
    }

    function select_rsmtd_perhotel($startdate,$enddate,$hotel) {
        $this->db->select("COALESCE(SUM(hc.room_sold),0) AS RS_MTD"); // ane ubah biar dapet return 0
        $this->db->from("smartreport_hca as hc");
        $this->db->where("hc.date_analysis BETWEEN '$startdate' AND '$enddate'");
        $this->db->where("hc.idhotels", $hotel);
        return $this->db->get()->row();        
    }

    function select_rsytd_perhotel($startdate,$enddate,$hotel){
        $this->db->select("SUM(hc.room_sold) AS RS_YTD");
        $this->db->from("smartreport_hca as hc");
        $this->db->where("hc.date_analysis BETWEEN '$startdate' AND '$enddate'");
        $this->db->where("hc.idhotels", $hotel);
        return $this->db->get()->row(); 
    }

    function select_trrmtd_perhotel($startdate,$enddate,$hotel) {
        $this->db->select("COALESCE(SUM(hc.room_sold * hc.avg_roomrate),0) AS TRR_MTD");// ane ubah biar dapet return 0
        $this->db->from("smartreport_hca as hc");
        $this->db->where("hc.date_analysis BETWEEN '$startdate' AND '$enddate'");
        $this->db->where("hc.idhotels", $hotel);
        return $this->db->get()->row();         
    }

    function select_trrytd_perhotel($startdate,$enddate,$hotel) {
        $this->db->select("SUM(hc.room_sold * hc.avg_roomrate) AS TRR_YTD");
        $this->db->from("smartreport_hca as hc");
        $this->db->where("hc.date_analysis BETWEEN '$startdate' AND '$enddate'");
        $this->db->where("hc.idhotels", $hotel);
        return $this->db->get()->row();   
    }


    // kalo error ganti fungsi datediffnya seperti di daily_sales_report.php baris ke 182/183 function $diffdateytd
    function select_RIYTD_perhotel($startdate,$enddate,$hotel){
        $this->db->select("ht.total_rooms * (DATEDIFF('$enddate', '$startdate') +1) as RI_YTD");
        $this->db->from("smartreport_hotels as ht");
        $this->db->join("smartreport_hca as hc","ht.idhotels = hc.idhotels", "LEFT");
        $this->db->where("hc.date_analysis BETWEEN '$startdate' AND '$enddate'");
        $this->db->where("ht.idhotels", $hotel);
        return $this->db->get()->row();   
    }

    function getRIYTDAllStar($startdate, $enddate, $city, $star){
        $this->db->select(" sum(ht.total_rooms * (DATEDIFF('$enddate', '$startdate') +1)) as RI_YTDAllStar ");
        $this->db->from("smartreport_hotels as ht");
        $this->db->join("smartreport_hca as hc","ht.idhotels = hc.idhotels", "LEFT");
        $this->db->where("hc.date_analysis BETWEEN '$startdate' AND '$enddate'");     
        $this->db->where("ht.hotel_star", $star);
        $this->db->where("ht.idcity", $city);
        return $this->db->get()->row();   
    }

    function getOccTodayAllStar($date = NULL, $city = NULL, $star=NULL){
        $this->db->select("(sum(hc.room_sold)/sum(ht.total_rooms)) as OCC_TODAYAllStar");
        $this->db->from("smartreport_hotels as ht");
        $this->db->join("smartreport_hca as hc ", "ht.idhotels = hc.idhotels", "LEFT");
        $this->db->where("hc.date_analysis ='$date' AND ht.idcity = '$city' AND ht.status = 'active' AND ht.hotel_star = '$star'");
        return $this->db->get()->row();   
    }

    function getOccMTDAllStar($startdate = NULL, $enddate = NULL, $city = NULL, $star = NULL){
        $this->db->select("(sum(hc.room_sold)/sum(ht.total_rooms)) as OCC_MTDAllStar");
        $this->db->from("smartreport_hotels as ht");
        $this->db->join("smartreport_hca as hc ", "ht.idhotels = hc.idhotels", "LEFT");
        $this->db->where("hc.date_analysis BETWEEN '$startdate' AND '$enddate' AND ht.idcity = '$city' AND ht.status = 'active' AND ht.hotel_star = '$star'");
        return $this->db->get()->row();   
    }

    function getOccYTDAllStar($startdate = NULL, $enddate = NULL, $city = NULL, $star = NULL){
        $this->db->select("(sum(hc.room_sold)) / (sum(ht.total_rooms) * (DATEDIFF('$enddate', '$startdate') +1)) as OCC_YTDAllStar");
        $this->db->from("smartreport_hotels as ht");
        $this->db->join("smartreport_hca as hc ", "ht.idhotels = hc.idhotels", "LEFT");
        $this->db->where("hc.date_analysis BETWEEN '$startdate' AND '$enddate' AND ht.idcity = '$city' AND ht.status = 'active' AND ht.hotel_star = '$star'");
        return $this->db->get()->row();   
    }

    function getTrrTodayAllStar($date = NULL, $city = NULL, $star = NULL ){
        $this->db->select("truncate(sum(hc.avg_roomrate*hc.room_sold),0) as TRR_TodayAllStar");
        $this->db->from("smartreport_hotels as ht");
        $this->db->join("smartreport_hca as hc ", "ht.idhotels = hc.idhotels", "LEFT");
        $this->db->where("hc.date_analysis ='$date' AND ht.idcity = '$city' AND ht.status = 'active' AND ht.hotel_star = '$star'");
        return $this->db->get()->row();   
    }

    function getTrrMTDAllStar($startdate = NULL, $enddate = NULL, $city = NULL, $star = NULL){
        $this->db->select("truncate(sum(hc.avg_roomrate*hc.room_sold),0) as TRR_MTDAllStar");
        $this->db->from("smartreport_hotels as ht");
        $this->db->join("smartreport_hca as hc ", "ht.idhotels = hc.idhotels", "LEFT");
        $this->db->where("hc.date_analysis BETWEEN '$startdate' AND '$enddate' AND ht.idcity = '$city' AND ht.status = 'active' AND ht.hotel_star = '$star'");
        return $this->db->get()->row();   
    }

    function getTrrYTDAllStar($startdate = NULL, $enddate = NULL, $city = NULL, $star = NULL){
        $this->db->select("truncate(sum(hc.avg_roomrate*hc.room_sold),0) as TRR_YTDAllStar");
        $this->db->from("smartreport_hotels as ht");
        $this->db->join("smartreport_hca as hc ", "ht.idhotels = hc.idhotels", "LEFT");
        $this->db->where("hc.date_analysis BETWEEN '$startdate' AND '$enddate' AND ht.idcity = '$city' AND ht.status = 'active' AND ht.hotel_star = '$star'");
        return $this->db->get()->row();   
    }

    function getArrTodayAllStar($date = NULL, $city = NULL, $star = NULL){
        $this->db->select("truncate(sum(hc.avg_roomrate*hc.room_sold) / sum(hc.room_sold),0) as ARR_TodayAllStar");
        $this->db->from("smartreport_hotels as ht");
        $this->db->join("smartreport_hca as hc ", "ht.idhotels = hc.idhotels", "LEFT");
        $this->db->where("hc.date_analysis ='$date' AND ht.idcity = '$city' AND ht.status = 'active' AND ht.hotel_star = '$star'");
        return $this->db->get()->row();   
    }

    function getArrMTDAllStar($startdate = NULL, $enddate = NULL, $city = NULL, $star = NULL){
        $this->db->select("truncate(sum(hc.avg_roomrate*hc.room_sold) / sum(hc.room_sold),0) as ARR_MTDAllStar");
        $this->db->from("smartreport_hotels as ht");
        $this->db->join("smartreport_hca as hc ", "ht.idhotels = hc.idhotels", "LEFT");
        $this->db->where("hc.date_analysis BETWEEN '$startdate' AND '$enddate' AND ht.idcity = '$city' AND ht.status = 'active' AND ht.hotel_star = '$star'");
        return $this->db->get()->row();   
    }

    function getArrYTDAllStar($startdate = NULL, $enddate = NULL, $city = NULL, $star = NULL){
        $this->db->select("truncate(sum(hc.avg_roomrate*hc.room_sold) / sum(hc.room_sold),0) as ARR_YTDAllStar");
        $this->db->from("smartreport_hotels as ht");
        $this->db->join("smartreport_hca as hc ", "ht.idhotels = hc.idhotels", "LEFT");
        $this->db->where("hc.date_analysis BETWEEN '$startdate' AND '$enddate' AND ht.idcity = '$city' AND ht.status = 'active' AND ht.hotel_star = '$star'");
        return $this->db->get()->row();   
    }


    /*function get_hotel4starmtd($date_analysis = NULL, $idcity = NULL, $date_analysisMTD = NULL){
        $this->db->select("
        COALESCE(sum(hc.room_sold),0) as roomsold_mtd, 
        TRUNCATE(COALESCE((sum(hc.room_sold)/sum(ht.total_rooms))*100,0),2) as occupancy_mtd,
        TRUNCATE(COALESCE(SUM(hc.room_sold*hc.avg_roomrate)/sum(hc.room_sold),0),0) as arr_mtd,
        TRUNCATE(COALESCE(sum(hc.room_sold*hc.avg_roomrate),0),0) as roomrevenue_mtd,
        TRUNCATE(COALESCE((sum(hc.room_sold*hc.avg_roomrate) / sum(ht.total_rooms)),0),0) as revpar_mtd");
        $this->db->from("smartreport_hotels as ht");
        $this->db->join("smartreport_city as ct", "ht.idcity=ct.idcity", "left");
        $this->db->join("smartreport_hca as hc","hc.idhotels=ht.idhotels and hc.date_analysis BETWEEN '$date_analysisMTD'-01 AND '$date_analysis'","left");        
        $whereHotel4Star="ht.status = 'active' AND ht.hotel_star = '4' AND ht.idcity ='$idcity' ";
        $this->db->where($whereHotel4Star);
        $this->db->group_by("ht.idhotels");
        return $this->db->get();
    }
    function get_add_list($user_hotel) {
        $this->db->select('h1.idhotels as idcompetitor, h.idhotels, h1.idcity, c.city_name,  h.hotels_name, h1.hotels_name as competitor, h1.total_rooms, h1.hotel_star, h1.status, h1.date_created');       
        $this->db->from('smartreport_hotels as h');              
        $this->db->join('smartreport_hotels as h1', 'h.idhotels=h1.parent','left');
        $this->db->join('smartreport_city as c', 'h1.idcity=c.idcity','left');
        $this->db->where('h1.parent', $user_hotel);
        $this->db->where('h1.status', 'active');
        //$this->db->where('h1.parent !=', 'PARENT');
        $this->db->order_by('h1.hotels_name', 'ASC');
        return $this->db->get()->result();
    }*/


    function getOccTodayByUser($date = NULL, $idhotels = NULL, $typecomp){
        $this->db->select("(sum(hc.room_sold)/sum(ht.total_rooms)) as OCC_TODAYByUser");
        $this->db->from("smartreport_hotels as ht");
        $this->db->join("smartreport_hca as hc ", "ht.idhotels = hc.idhotels and hc.date_analysis ='$date' ", "LEFT");
        $this->db->where("ht.status = 'active' AND ht.parent = '$idhotels' AND ht.type_competitor ='$typecomp' ");
        if($typecomp == 'direct'){
            $this->db->or_where('ht.idhotels', $idhotels);
        }
        return $this->db->get()->row();   
    }

    function getOccMTDByUser($startdate = NULL, $enddate = NULL,  $idhotels = NULL, $typecomp){
        $this->db->select("(sum(hc.room_sold)/sum(ht.total_rooms)) as OCC_MTDByUser, sum(hc.room_sold) as room_sold, sum(ht.total_rooms) as tot_room  ");
        $this->db->from("smartreport_hotels as ht");
        $this->db->join("smartreport_hca as hc ", "ht.idhotels = hc.idhotels and hc.date_analysis BETWEEN '$startdate' AND '$enddate'", "LEFT");
        $this->db->where(" ht.status = 'active' AND ht.parent = '$idhotels' AND ht.type_competitor ='$typecomp' ");
        if($typecomp == 'direct'){
            $this->db->or_where('ht.idhotels', $idhotels);
        }
        return $this->db->get()->row();   
    }

    function getOccYTDByUser($startdate = NULL, $enddate = NULL, $idhotels = NULL, $typecomp = NULL){
        $this->db->select("(sum(hc.room_sold)) / (sum(ht.total_rooms) * (DATEDIFF('$enddate', '$startdate') +1)) as OCC_YTDByUser");
        $this->db->from("smartreport_hotels as ht");
        $this->db->join("smartreport_hca as hc ", "ht.idhotels = hc.idhotels and hc.date_analysis BETWEEN '$startdate' AND '$enddate'", "LEFT");
        $this->db->where(" ht.status = 'active' AND ht.parent = '$idhotels' AND ht.type_competitor ='$typecomp' ");
        if($typecomp == 'direct'){
            $this->db->or_where('ht.idhotels', $idhotels);
        }
        return $this->db->get()->row();   
    }

    function getTrrTodayByUser($date = NULL, $idhotels = NULL, $typecomp = NULL ){
        $this->db->select("truncate(sum(hc.avg_roomrate*hc.room_sold),0) as TRR_TodayByUser");
        $this->db->from("smartreport_hotels as ht");
        $this->db->join("smartreport_hca as hc ", "ht.idhotels = hc.idhotels and hc.date_analysis ='$date'", "LEFT");
        $this->db->where(" ht.status = 'active' AND  ht.parent = '$idhotels' AND ht.type_competitor ='$typecomp' ");
        if($typecomp == 'direct'){
            $this->db->or_where('ht.idhotels', $idhotels);
        }
        return $this->db->get()->row();   
    }

    function getTrrMTDByUser($startdate = NULL, $enddate = NULL, $idhotels = NULL, $typecomp = NULL){
        $this->db->select("truncate(sum(hc.avg_roomrate*hc.room_sold),0) as TRR_MTDByUser");
        $this->db->from("smartreport_hotels as ht");
        $this->db->join("smartreport_hca as hc ", "ht.idhotels = hc.idhotels and hc.date_analysis BETWEEN '$startdate' AND '$enddate'", "LEFT");
        $this->db->where(" ht.status = 'active' AND ht.parent = '$idhotels' AND ht.type_competitor ='$typecomp'");
        if($typecomp == 'direct'){
            $this->db->or_where('ht.idhotels', $idhotels);
        }
        return $this->db->get()->row();   
    }

    function getTrrYTDByUser($startdate = NULL, $enddate = NULL, $idhotels = NULL, $typecomp = NULL){
        $this->db->select("truncate(sum(hc.avg_roomrate*hc.room_sold),0) as TRR_YTDByUser");
        $this->db->from("smartreport_hotels as ht");
        $this->db->join("smartreport_hca as hc ", "ht.idhotels = hc.idhotels AND hc.date_analysis BETWEEN '$startdate' AND '$enddate'", "LEFT");
        $this->db->where("ht.status = 'active' AND ht.parent = '$idhotels' AND ht.type_competitor ='$typecomp'");
        if($typecomp == 'direct'){
            $this->db->or_where('ht.idhotels', $idhotels);
        }
        return $this->db->get()->row();   
    }

    function getArrTodayByUser($date = NULL, $idhotels = NULL, $typecomp = NULL){
        $this->db->select("truncate(sum(hc.avg_roomrate*hc.room_sold) / sum(hc.room_sold),0) as ARR_TodayByUser");
        $this->db->from("smartreport_hotels as ht");
        $this->db->join("smartreport_hca as hc ", "ht.idhotels = hc.idhotels AND hc.date_analysis ='$date' ", "LEFT");
        $this->db->where("ht.status = 'active' AND ht.parent = '$idhotels' AND ht.type_competitor ='$typecomp' ");
        if($typecomp == 'direct'){
            $this->db->or_where('ht.idhotels', $idhotels);
        }
        return $this->db->get()->row();   
    }

    function getArrMTDByUser($startdate = NULL, $enddate = NULL, $idhotels = NULL, $typecomp = NULL){
        $this->db->select("truncate(sum(hc.avg_roomrate*hc.room_sold) / sum(hc.room_sold),0) as ARR_MTDByUser");
        $this->db->from("smartreport_hotels as ht");
        $this->db->join("smartreport_hca as hc ", "ht.idhotels = hc.idhotels AND hc.date_analysis BETWEEN '$startdate' AND '$enddate'", "LEFT");
        $this->db->where("ht.status = 'active' AND ht.parent = '$idhotels' AND ht.type_competitor ='$typecomp'");
        if($typecomp == 'direct'){
            $this->db->or_where('ht.idhotels', $idhotels);
        }
        return $this->db->get()->row();   
    }

    function getArrYTDByUser($startdate = NULL, $enddate = NULL, $idhotels = NULL, $typecomp = NULL){
        $this->db->select("truncate(sum(hc.avg_roomrate*hc.room_sold) / sum(hc.room_sold),0) as ARR_YTDByUser");
        $this->db->from("smartreport_hotels as ht");
        $this->db->join("smartreport_hca as hc ", "ht.idhotels = hc.idhotels AND hc.date_analysis BETWEEN '$startdate' AND '$enddate'", "LEFT");
        $this->db->where("ht.status = 'active' AND ht.parent = '$idhotels' AND ht.type_competitor ='$typecomp'");
        if($typecomp == 'direct'){
            $this->db->or_where('ht.idhotels', $idhotels);
        }
        return $this->db->get()->row();   
    }

    function getRIYTDByUser($startdate = NULL, $enddate = NULL, $idhotels = NULL, $typecomp = NULL){
        $this->db->select(" ht.total_rooms * (DATEDIFF('$enddate', '$startdate') +1) as RI_YTDByUser ");
        $this->db->from("smartreport_hotels as ht");
        $this->db->join("smartreport_hca as hc","ht.idhotels = hc.idhotels AND hc.date_analysis BETWEEN '$startdate' AND '$enddate'", "LEFT");
        $this->db->where("ht.status = 'active' AND ht.parent = '$idhotels' AND ht.type_competitor ='$typecomp' ");
        if($typecomp == 'direct'){
            $this->db->or_where('ht.idhotels', $idhotels);
        }
        return $this->db->get()->row();   
    }

   

    // get total rows
    function total_rows($q = NULL) {
        $this->db->like('idanalysis', $q);
	$this->db->or_like('idhotels', $q);
	$this->db->or_like('room_sold', $q);
	$this->db->or_like('avg_roomrate', $q);
	$this->db->or_like('remark', $q);
	$this->db->or_like('date_created', $q);
	$this->db->or_like('date_updated', $q);
	$this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL) {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('idanalysis', $q);
	$this->db->or_like('idhotels', $q);
	$this->db->or_like('room_sold', $q);
	$this->db->or_like('avg_roomrate', $q);
	$this->db->or_like('remark', $q);
	$this->db->or_like('date_created', $q);
	$this->db->or_like('date_updated', $q);
	$this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }

    // insert data
    function insert_analysis_data($table, $data_analysis){
        $this->db->insert_batch($table, $data_analysis);
    }
    
    function insertData($table,$data)
    {
        $this->db->insert($table,$data);
    } 

    // update data
    function update($id, $data)
    {
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
    }

    // delete data
    function delete($id)
    {
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
    }

    function select_hotelcompbydate($idh, $date_analysis){
        $this->db->select('*');
        $this->db->from('smartreport_hca');
        $this->db->where('idhotels', $idh );
        $this->db->where('date_analysis', $date_analysis);
        return $this->db->get();
    }

    function delete_hotelcompbydate($idh, $date_analysis){
        
        $this->db->where('idhotels', $idh );
        $this->db->where('date_analysis', $date_analysis);
        $this->db->delete('smartreport_hca');
    }

    function update_hotelcompbyid($id,$data){
        $this->db->where('idanalysis', $id);
        $this->db->update('smartreport_hca',$data);
        return true;
    }

    /* Direct and Incdirect Competitor */
    function getHotelByUserHotelTypeComp($idhotels, $typecomp){
        $this->db->select('h1.idhotels as idcompetitor, h.idhotels, h1.idcity, c.city_name,  h.hotels_name, h1.hotels_name as competitor, h1.total_rooms, h1.type_competitor, h1.hotel_star, h1.status, h1.date_created');       
        $this->db->from('smartreport_hotels as h');              
        $this->db->join('smartreport_hotels as h1', 'h.idhotels=h1.idhotels','left');
        $this->db->join('smartreport_city as c', 'h1.idcity=c.idcity','left');
        $this->db->where('h1.parent', $idhotels);
        $this->db->where('h1.type_competitor', $typecomp);
        $this->db->where('h1.status', 'active');
        if($typecomp == 'direct'){
            $this->db->or_where('h1.idhotels', $idhotels);
        }        
        $this->db->order_by('h1.hotels_name', 'ASC');
        return $this->db->get();
    }
    

}

