<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Smartreport_pnl_model extends CI_Model
{

    
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }


    // Query Data from Table with Order;
    public function getDataAll($table, $order_column, $order_type){
        $this->db->order_by("$order_column", "$order_type");
        $query = $this->db->get("$table");
        $result = $query->result();
        $this->db->save_queries = false;
        return $result;
    }

    // insert all
    public function insertData($table,$data)
    {
        $this->db->insert($table, $data);
    }    

    function total_rows_pnlcategory($q = NULL) {            
	    $this->db->like('pnl_category', $q);
        $this->db->from('smartreport_pnlcategory');
    return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data_pnlcategory($limit, $start = 0, $q = NULL) {        
        $this->db->order_by('pnl_category', 'ASC');
	    $this->db->or_like('pnl_category', $q);
        $this->db->from('smartreport_pnlcategory');
        $this->db->limit($limit, $start);
    return $this->db->get()->result();
    }

    public function update_data_pnlcategory($table, $data, $idpnlcategory)
    {
        $this->db->where('idpnlcategory', $idpnlcategory);
        $this->db->update("$table", $data);

        return true;
    }
    

    function total_rows_pnllist($q = NULL) {       
        $this->db->select('pl.idpnl, pl.pnl_name, pc.idpnlcategory, pc.pnl_category, pl.pnl_order, pl.pnl_status');    
        $this->db->like('pl.pnl_name', $q);
        $this->db->from('smartreport_pnllist as pl');
        $this->db->join('smartreport_pnlcategory as pc', 'pl.idpnlcategory = pc.idpnlcategory', 'left');
    return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data_pnllist($limit, $start = 0, $q = NULL) {
        $this->db->select('pl.idpnl, pl.pnl_name,  pc.idpnlcategory,pc.pnl_category, pl.pnl_order, pl.pnl_status');  
        $this->db->order_by('pl.pnl_name', 'ASC');  
        $this->db->like('pl.pnl_name', $q);  
        $this->db->from('smartreport_pnllist as pl');
        $this->db->join('smartreport_pnlcategory as pc', 'pl.idpnlcategory = pc.idpnlcategory', 'left'); 
        $this->db->limit($limit, $start);
    return $this->db->get()->result();
    }

    public function update_data_pnllist($table, $data, $idpnllist){
        $this->db->where('idpnl', $idpnllist);
        $this->db->update("$table", $data);
        return true;
    }
    /*function delete_dana_pnlcategory($idpnlcategory){
        $this->db->where('idpnlcategory', $idpnlcategory);
        $this->db->delete('smartreport_pnlcategory');
    }*/

    
    function get_data_pnlcategory() {        
        $this->db->order_by("pnlcategory_order", "ASC");	    
        $this->db->from("smartreport_pnlcategory");
        $this->db->where("pnlcategory_status = 'active'");
        return $this->db->get()->result();
    }

    function select_pnllist_percategory($idpnlcategory){
        $this->db->select('pl.idpnl, pl.pnl_name,  pc.idpnlcategory, pc.pnl_category, pl.pnl_status, pl.pnl_order');  
        $this->db->order_by('pl.pnl_order', 'ASC');  
        $this->db->like('pl.pnl_name');  
        $this->db->from('smartreport_pnllist as pl');
        $this->db->join('smartreport_pnlcategory as pc', 'pl.idpnlcategory = pc.idpnlcategory', 'left'); 
        $this->db->where('pc.idpnlcategory', $idpnlcategory);
        return $this->db->get()->result();
    }

    function select_pnlbyiddate($idhotels,$idp, $date_budget){
        $this->db->select('*');
        $this->db->from('smartreport_budget');
        $this->db->where('idpnl', $idp);
        $this->db->where('idhotels', $idhotels);
        $this->db->where('date_budget', $date_budget);
        return $this->db->get();
    }

    function delete_pnlbyiddate($idhotels,$idp, $date_budget){       
        
        $this->db->where('idhotels', $idhotels);
        $this->db->where('idpnl', $idp );
        $this->db->where('date_budget', $date_budget);
        $this->db->delete('smartreport_budget');
    }

    function insert_batch_data($table, $data_pnl){
        $this->db->insert_batch($table, $data_pnl);
    }

    function get_data_budget($idpnl, $idhotels, $month, $year){
        $this->db->select("COALESCE(sum(budget_value),0) as BUDGET");
        $this->db->from("smartreport_budget");
        $this->db->where("idpnl = '$idpnl' AND idhotels='$idhotels' AND MONTH(date_budget) ='$month' AND YEAR(date_budget)=$year");
        return $this->db->get()->row();
    }

    function get_data_budgetroomsold($idhotels, $month, $year){ //Room Sold dan Occupied Room artinya sama
        $this->db->select("COALESCE(sum(budget_value),0) as BUDGETROOMSOLD");
        $this->db->from("smartreport_budget");
        $this->db->where("idpnl = '7' AND idhotels='$idhotels' AND MONTH(date_budget) ='$month' AND YEAR(date_budget)=$year");
        return $this->db->get()->row();
    }

    function get_total_budget($idpnl, $idhotels, $year ){
        $this->db->select("sum(budget_value) as TOTAL_BUDGET");
        $this->db->from("smartreport_budget");
        $this->db->where("idpnl ='$idpnl' AND YEAR(date_budget) = '$year' AND idhotels = '$idhotels'");
        return $this->db->get()->row();
    }

    function get_grandtotal_pnlcategory($idpnlcategory, $idhotels, $year){
        $this->db->select("sum(sb.budget_value) as GRANDTOTAL_PNLCATEGORY");
        $this->db->from("smartreport_budget as sb");
        $this->db->join("smartreport_pnllist as sp", "sb.idpnl = sp.idpnl", "left");
        $this->db->where("sp.idpnlcategory= '$idpnlcategory' and YEAR(sb.date_budget) = '$year' and sb.idhotels = '$idhotels'");
        return $this->db->get()->row();
    }

    function get_total_pnlcategorybymonth($idpnlcategory, $idhotels, $month, $year){
        $this->db->select("sum(sb.budget_value) as TOTAL_PNLCATEGORYBYMONTH");
        $this->db->from("smartreport_budget as sb");
        $this->db->join("smartreport_pnllist as sp", "sb.idpnl = sp.idpnl", "left");
        $this->db->where("sp.idpnlcategory= '$idpnlcategory' AND MONTH(sb.date_budget) ='$month' AND YEAR(sb.date_budget) = '$year' AND sb.idhotels = '$idhotels'");
        return $this->db->get()->row();
    }
    
    /* BEGIN - UNTUK DSR ambil dari BUDGET */
    function get_roomsold_budget($idhotels, $month, $year){
        $this->db->select("sum(sb.budget_value) as BUDGET_ROOMSOLD");
        $this->db->from("smartreport_budget as sb");
        $this->db->join("smartreport_pnllist as sp", "sb.idpnl = sp.idpnl", "left");
        $this->db->where("sp.idpnlcategory= '1' and  sb.idpnl='7' AND MONTH(sb.date_budget) ='$month' AND YEAR(sb.date_budget) = '$year' AND sb.idhotels = '$idhotels'");
        return $this->db->get()->row();
    }

    function get_roomsold_budgetytd($idhotels, $month, $year){
        $this->db->select("sum(sb.budget_value) as BUDGET_ROOMSOLDYTD");
        $this->db->from("smartreport_budget as sb");
        $this->db->join("smartreport_pnllist as sp", "sb.idpnl = sp.idpnl", "left");
        $this->db->where("sp.idpnlcategory= '1' AND sb.idpnl='7' AND MONTH(sb.date_budget) BETWEEN '01' AND '$month' AND YEAR(sb.date_budget) = '$year' AND sb.idhotels = '$idhotels'");
        return $this->db->get()->row();
    }

    function get_guest_budget($idhotels, $month, $year){
        $this->db->select("sum(sb.budget_value) as BUDGET_GUEST");
        $this->db->from("smartreport_budget as sb");
        $this->db->join("smartreport_pnllist as sp", "sb.idpnl = sp.idpnl", "left");
        $this->db->where("sp.idpnlcategory= '1' and  sb.idpnl='2' AND MONTH(sb.date_budget) ='$month' AND YEAR(sb.date_budget) = '$year' AND sb.idhotels = '$idhotels'");
        return $this->db->get()->row();
    }

    function get_guest_budgetytd($idhotels, $month, $year){
        $this->db->select("sum(sb.budget_value) as BUDGET_GUESTYTD");
        $this->db->from("smartreport_budget as sb");
        $this->db->join("smartreport_pnllist as sp", "sb.idpnl = sp.idpnl", "left");
        $this->db->where("sp.idpnlcategory= '1' AND sb.idpnl='2' AND MONTH(sb.date_budget) BETWEEN '01' AND '$month' AND YEAR(sb.date_budget) = '$year' AND sb.idhotels = '$idhotels'");
        return $this->db->get()->row();
    }

    function get_arr_budget($idhotels, $month, $year){
        $this->db->select("sum(sb.budget_value) as BUDGET_ARR");
        $this->db->from("smartreport_budget as sb");
        $this->db->join("smartreport_pnllist as sp", "sb.idpnl = sp.idpnl", "left");
        $this->db->where("sp.idpnlcategory= '1' and  sb.idpnl='1' AND MONTH(sb.date_budget) ='$month' AND YEAR(sb.date_budget) = '$year' AND sb.idhotels = '$idhotels'");
        return $this->db->get()->row();
    }

    function get_arr_budgetytd($idhotels, $month, $year){ // beda rumus
        $this->db->select("sum(sb.budget_value) as BUDGET_ARRYTD");
        $this->db->from("smartreport_budget as sb");
        $this->db->join("smartreport_pnllist as sp", "sb.idpnl = sp.idpnl", "left");
        $this->db->where("sp.idpnlcategory= '1' AND sb.idpnl='1' AND MONTH(sb.date_budget) BETWEEN '01' AND '$month' AND YEAR(sb.date_budget) = '$year' AND sb.idhotels = '$idhotels'");
        return $this->db->get()->row();
    }

    function get_rooms_budget($idhotels, $month, $year){
        $this->db->select("sum(sb.budget_value) as BUDGET_ROOMS");
        $this->db->from("smartreport_budget as sb");
        $this->db->join("smartreport_pnllist as sp", "sb.idpnl = sp.idpnl", "left");
        $this->db->where("sp.idpnlcategory= '2' and  sb.idpnl='4' AND MONTH(sb.date_budget) ='$month' AND YEAR(sb.date_budget) = '$year' AND sb.idhotels = '$idhotels'");
        return $this->db->get()->row();
    }

    function get_rooms_budgetytd($idhotels, $month, $year){
        $this->db->select("sum(sb.budget_value) as BUDGET_ROOMSYTD");
        $this->db->from("smartreport_budget as sb");
        $this->db->join("smartreport_pnllist as sp", "sb.idpnl = sp.idpnl", "left");
        $this->db->where("sp.idpnlcategory= '2' AND sb.idpnl='4' AND MONTH(sb.date_budget) BETWEEN '01' AND '$month' AND YEAR(sb.date_budget) = '$year' AND sb.idhotels = '$idhotels'");
        return $this->db->get()->row();
    }

    function get_fnb_budget($idhotels, $month, $year){
        $this->db->select("sum(sb.budget_value) as BUDGET_FNB");
        $this->db->from("smartreport_budget as sb");
        $this->db->join("smartreport_pnllist as sp", "sb.idpnl = sp.idpnl", "left");
        $this->db->where("sp.idpnlcategory= '2' and  sb.idpnl='3' AND MONTH(sb.date_budget) ='$month' AND YEAR(sb.date_budget) = '$year' AND sb.idhotels = '$idhotels'");
        return $this->db->get()->row();
    }

    function get_fnb_budgetytd($idhotels, $month, $year){
        $this->db->select("sum(sb.budget_value) as BUDGET_FNBYTD");
        $this->db->from("smartreport_budget as sb");
        $this->db->join("smartreport_pnllist as sp", "sb.idpnl = sp.idpnl", "left");
        $this->db->where("sp.idpnlcategory= '2' AND sb.idpnl='3' AND MONTH(sb.date_budget) BETWEEN '01' AND '$month' AND YEAR(sb.date_budget) = '$year' AND sb.idhotels = '$idhotels'");
        return $this->db->get()->row();
    }

    function get_laundry_budget($idhotels, $month, $year){
        $this->db->select("sum(sb.budget_value) as BUDGET_LAUNDRY");
        $this->db->from("smartreport_budget as sb");
        $this->db->join("smartreport_pnllist as sp", "sb.idpnl = sp.idpnl", "left");
        $this->db->where(" sp.idpnlcategory= '2' AND sb.idpnl='5'  AND MONTH(sb.date_budget) ='$month' AND YEAR(sb.date_budget) = '$year' AND sb.idhotels = '$idhotels'");
        return $this->db->get()->row();
    }

    function get_laundry_budgetytd($idhotels, $month, $year){
        $this->db->select("sum(sb.budget_value) as BUDGET_LAUNDRYYTD");
        $this->db->from("smartreport_budget as sb");
        $this->db->join("smartreport_pnllist as sp", "sb.idpnl = sp.idpnl", "left");
        $this->db->where(" sp.idpnlcategory= '2' AND sb.idpnl='5'   AND MONTH(sb.date_budget) BETWEEN '01' AND '$month' AND YEAR(sb.date_budget) = '$year' AND sb.idhotels = '$idhotels'");
        return $this->db->get()->row();
    }

    function get_other_budget($idhotels, $month, $year){
        $this->db->select("sum(sb.budget_value) as BUDGET_OTHER");
        $this->db->from("smartreport_budget as sb");
        $this->db->join("smartreport_pnllist as sp", "sb.idpnl = sp.idpnl", "left");
        $this->db->where(" sp.idpnlcategory= '2' AND sb.idpnl='6'  AND MONTH(sb.date_budget) ='$month' AND YEAR(sb.date_budget) = '$year' AND sb.idhotels = '$idhotels'");
        return $this->db->get()->row();
    }

    function get_other_budgetytd($idhotels, $month, $year){
        $this->db->select("sum(sb.budget_value) as BUDGET_OTHERYTD");
        $this->db->from("smartreport_budget as sb");
        $this->db->join("smartreport_pnllist as sp", "sb.idpnl = sp.idpnl", "left");
        $this->db->where(" sp.idpnlcategory= '2' AND sb.idpnl='6'   AND MONTH(sb.date_budget) BETWEEN '01' AND '$month' AND YEAR(sb.date_budget) = '$year' AND sb.idhotels = '$idhotels'");
        return $this->db->get()->row();
    }

    function get_sport_budget($idhotels, $month, $year){
        $this->db->select("sum(sb.budget_value) as BUDGET_SPORT");
        $this->db->from("smartreport_budget as sb");
        $this->db->join("smartreport_pnllist as sp", "sb.idpnl = sp.idpnl", "left");
        $this->db->where(" sp.idpnlcategory= '2' AND sb.idpnl='24'  AND MONTH(sb.date_budget) ='$month' AND YEAR(sb.date_budget) = '$year' AND sb.idhotels = '$idhotels'");
        return $this->db->get()->row();
    }

    function get_sport_budgetytd($idhotels, $month, $year){
        $this->db->select("sum(sb.budget_value) as BUDGET_SPORTYTD");
        $this->db->from("smartreport_budget as sb");
        $this->db->join("smartreport_pnllist as sp", "sb.idpnl = sp.idpnl", "left");
        $this->db->where(" sp.idpnlcategory= '2' AND sb.idpnl='24'   AND MONTH(sb.date_budget) BETWEEN '01' AND '$month' AND YEAR(sb.date_budget) = '$year' AND sb.idhotels = '$idhotels'");
        return $this->db->get()->row();
    }

    function get_spa_budget($idhotels, $month, $year){
        $this->db->select("sum(sb.budget_value) as BUDGET_SPA");
        $this->db->from("smartreport_budget as sb");
        $this->db->join("smartreport_pnllist as sp", "sb.idpnl = sp.idpnl", "left");
        $this->db->where(" sp.idpnlcategory= '2' AND sb.idpnl='25'  AND MONTH(sb.date_budget) ='$month' AND YEAR(sb.date_budget) = '$year' AND sb.idhotels = '$idhotels'");
        return $this->db->get()->row();
    }

    function get_spa_budgetytd($idhotels, $month, $year){
        $this->db->select("sum(sb.budget_value) as BUDGET_SPAYTD");
        $this->db->from("smartreport_budget as sb");
        $this->db->join("smartreport_pnllist as sp", "sb.idpnl = sp.idpnl", "left");
        $this->db->where(" sp.idpnlcategory= '2' AND sb.idpnl='25'   AND MONTH(sb.date_budget) BETWEEN '01' AND '$month' AND YEAR(sb.date_budget) = '$year' AND sb.idhotels = '$idhotels'");
        return $this->db->get()->row();
    }
    /* END- UNTUK DSR ambil dari BUDGET */
    
    function get_sub_category($idpnlcategory){
		$query = $this->db->get_where('smartreport_pnllist', array('idpnlcategory' => $idpnlcategory));
		return $query;
    }
    
    function select_budgetpnlbydate($idh, $idpnl, $date_budget){
        $this->db->select('*');
        $this->db->from('smartreport_budget');
        $this->db->where('idhotels', $idh );
        $this->db->where('idpnl', $idpnl);
        $this->db->where('date_budget', $date_budget);
        return $this->db->get();
    }

    function update_budgetpnlbyid($id,$data){
        $this->db->where('idbudget', $id);
        $this->db->update('smartreport_budget',$data);
        return true;
    }
  

}