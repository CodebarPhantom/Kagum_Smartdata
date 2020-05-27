<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Smartreport_vouchers_model extends CI_Model{

    function __construct(){
        parent::__construct();
    }

    // get total rows
    function total_rows_vouchers($guestname = NULL, $listhotel = NULL, $idvoucher = NULL, $month = NULL, $year = NULL) {
        $this->db->select('vh.idvoucher, vh.guest_name, vh.guest_phone, vh.guest_email, vh.fk_iduser_generate, vh.fk_iduser_lock, vh.fk_iduser_redeem, ug.user_name as user_generate, ul.user_name as user_lock, ur.user_name as user_redeem, vh.stay_date, vh.fk_idhotels, ht.hotels_name, vh.created_at, vh.lock_at, vh.redeem_at, vh.status_voucher, vh.type_voucher, vh.type_sales');       
        $this->db->from('smartreport_voucherhotels as vh');        
        $this->db->join('smartreport_hotels as ht', 'ht.idhotels=vh.fk_idhotels','left');
        $this->db->join('smartreport_users as ug', 'ug.iduser=vh.fk_iduser_generate ','left');
        $this->db->join('smartreport_users as ul', 'ul.iduser=vh.fk_iduser_lock ','left');
        $this->db->join('smartreport_users as ur', 'ur.iduser=vh.fk_iduser_redeem ','left');     
        if ($idvoucher !== NULL){
            $this->db->like('vh.idvoucher', $idvoucher);
        }        
        if ($guestname !== NULL){
            $this->db->like('vh.guest_name', $guestname);
        }       
        if($listhotel !== 'all'){
            $this->db->like('vh.fk_idhotels', $listhotel);
        }
        if($month !== ''){
            $this->db->where("MONTH(vh.created_at) = '$month'");
        }
        if($year !== ''){
            $this->db->where("YEAR(vh.created_at) = '$year'");
        }


        $this->db->order_by('vh.idvoucher', 'ASC');
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data_vouchers($limit, $start = 0, $guestname = NULL,  $listhotel = NULL, $idvoucher = NULL, $month = NULL, $year = NULL) {
        $this->db->select('vh.idvoucher, vh.guest_name, vh.guest_phone, vh.guest_email, vh.fk_iduser_generate, vh.fk_iduser_lock, vh.fk_iduser_redeem, ug.user_name as user_generate, ul.user_name as user_lock, ur.user_name as user_redeem, vh.stay_date, vh.fk_idhotels, ht.hotels_name, vh.created_at, vh.lock_at, vh.redeem_at, vh.status_voucher, vh.type_voucher, vh.type_sales');       
        $this->db->from('smartreport_voucherhotels as vh');        
        $this->db->join('smartreport_hotels as ht', 'ht.idhotels=vh.fk_idhotels','left');
        
        $this->db->join('smartreport_users as ug', 'ug.iduser=vh.fk_iduser_generate ','left');
        $this->db->join('smartreport_users as ul', 'ul.iduser=vh.fk_iduser_lock ','left');
        $this->db->join('smartreport_users as ur', 'ur.iduser=vh.fk_iduser_redeem ','left');
        if ($idvoucher !== NULL){
            $this->db->like('vh.idvoucher', $idvoucher);
        }        
        if ($guestname !== NULL){
            $this->db->like('vh.guest_name', $guestname);
        }       
        if($listhotel !== 'all'){
            $this->db->like('vh.fk_idhotels', $listhotel);
        }
        if($month !== ''){
            $this->db->where("MONTH(vh.created_at) = '$month'");
        }
        if($year !== ''){
            $this->db->where("YEAR(vh.created_at) = '$year'");
        }

        $this->db->order_by('vh.idvoucher', 'ASC');
        $this->db->limit($limit, $start);
        return $this->db->get()->result();
    }

    function set_idvoucher(){
        $voucherdate = date("Ym");	
        $check_voucher_date = $this->db->query("SELECT SUBSTR(idvoucher,7,6) AS datevoucher  FROM smartreport_voucherhotels ORDER BY idvoucher DESC LIMIT 1 ")->first_row();
        
        if($check_voucher_date->datevoucher === $voucherdate){
            $check = $this->db->query("SELECT RIGHT(idvoucher,6) AS codevoucher  FROM smartreport_voucherhotels ORDER BY idvoucher DESC LIMIT 1 ");
            if($check->num_rows()>0){
                foreach($check->result() as $query){
                    $codevoucher = ((int)$query->codevoucher)+1;
                }							 		
            }else{
                $codevoucher = 1;	
            }
        }else{
            $codevoucher = 1;	
        }
        $uniquecode = str_pad($codevoucher,6,"0",STR_PAD_LEFT);
		return "KGMHTL".$voucherdate.$uniquecode;
        /*$check = $this->db->query("SELECT RIGHT(idvoucher,6) AS codevoucher  FROM smartreport_voucherhotels ORDER BY idvoucher DESC LIMIT 1 ");
		   if($check->num_rows()>0){
				foreach($check->result() as $query){
                      $codevoucher = ((int)$query->codevoucher)+1;
                    }							 		
			}else{
				$codevoucher = 1;	
            }
            $uniquecode = str_pad($codevoucher,6,"0",STR_PAD_LEFT);
			return "KGMHTL".$voucherdate.$uniquecode;*/
	   
	 
    }

    function insert_voucher($idvoucher,$data) {
        
        $this->db->set('idvoucher',$idvoucher);
        $this->db->insert('smartreport_voucherhotels',$data);        
    } 

    public function update_data_voucher($table, $data, $idvoucher)
    {
        $this->db->where('idvoucher', $idvoucher);
        $this->db->update("$table", $data);

        return true;
    }

    

}