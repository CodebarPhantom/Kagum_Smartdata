<!DOCTYPE html>
<html lang="en" >
<head>
    <?php

        if($idhotel_custom == NULL){
            $idhotel_custom = $user_ho; 
        } 
        $url_date = '';
        $d = '';
        if($date_dsr === NULL){
            $d=strtotime("-1 Day"); 
        }
        if ($dateToView == '1970-01-01') {
            $dateToView = date('Y-m-d',$d);
            $peryear = date('Y',$d);
            $permonth = date('m',$d);
            $perdate = date('d',$d);
        }else{
            $url_date =$dateToView;                            
            $date =  $dateToView;	
            $peryear = substr($dateToView,0,4);
            $permonth= substr($dateToView,5,2);
            $perdate = substr($dateToView,8,2);	
        }

        $startdate_ytd = $peryear.'-01-'.'01';
        $enddate_ytd = $dateToView;
        $startdate_mtd = $peryear.'-'.$permonth.'-'.'01';
        $enddate_mtd = $dateToView;   
        $diffdateytd = date_diff(new DateTime($startdate_ytd), new DateTime($enddate_ytd));
        $monthObj  = DateTime::createFromFormat('!m', $permonth);  

        $days_this_month = cal_days_in_month(CAL_GREGORIAN,$permonth,$peryear);

        function cal_days_in_year($peryear){
            $days=0; 
            for($month=1;$month<=12;$month++){ 
                    $days = $days + cal_days_in_month(CAL_GREGORIAN,$month,$peryear);
                }
            return $days;
            }


        //occupancy
        $occ_today = 0;$occ_mtd = 0;$occ_ytd = 0;
        //avg room rate
        $trr_today = 0;$trr_mtd = 0;$trr_ytd = 0;
        //avg room rate
        $arr_today = 0;$arr_mtd = 0;$arr_ytd = 0;
        //room sold
        $rs_today = 0;$rs_mtd = 0;$rs_ytd = 0;
        //fnb
        $fnb_today = 0; $fnb_mtd = 0; $fnb_ytd = 0;
        //other
        $oth_today = 0; $oth_mtd = 0; $oth_ytd = 0;
        //number of gues
        $guest_today = 0; $guest_mtd = 0; $guest_ytd = 0;
        //total sales
        $tot_sales_today = 0; $tot_sales_mtd = 0; $tot_sales_ytd = 0;
        //room inventory
        $ri_mtd = 0; $ri_ytd = 0; 

        //outoforder
        $outoforder_today = 0; $outoforder_mtd=0; $outoforder_ytd=0;
                        
    ?>
    <meta charset="UTF-8">
    <title><?php echo $lang_dsr.' '.$perdate.' '.$monthObj->format('F').' '.$peryear; ?></title>
    
</head>

<body>

    <style>
        #pdfreport {
        font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        margin-left:auto; 
        margin-right:auto;
        font-size: 8.5px;

        
        }

        #pdfreport td {
        border: 1px solid #ddd;
        padding: 3px;
        
        }
        #pdfreport th{
            border: 1px solid #ddd;
            padding: 5px;
        }



        #pdfreport tr:hover {background-color: #ddd;}

        #pdfreport th {
        background-color: #353b48;
        color: white;
        text-align: center;
        }

        .rata-kanan{
            vertical-align: middle; 
            text-align: right;
        }
        
    </style>



<!-- partial:index.partial.html -->
<div class="container">
  <table  id="pdfreport">
    <caption><strong style="font-size: 14px;"><?php echo $hotelsName->hotels_name.' - '.$lang_dsr.' '.$perdate.' '.$monthObj->format('F').' '.$peryear; ?></strong> <br/></caption>
    
    <thead>
        <tr>
            <th rowspan="2" width="100px">Category</th>
            <th colspan="4">Today</th>
            <th colspan="4">MTD</th>
            <th colspan="4">YTD</th>
                                                       
        </tr>
        <tr>
            <th>Actual</th>
            <th>%</th>
            <th>Budget</th>
            <th>%</th>

            <th>Actual</th>
            <th>%</th>
            <th>Budget</th>
            <th>%</th>

            <th>Actual</th>
            <th>%</th>
            <th>Budget</th>
            <th>%</th>
            
        </tr>
    </thead>   

    <tbody>
        <?php foreach ($getHotelByUser_data->result() as $getHotelByUser){                                 
            // data dari table hca
            $dt_analystoday = $this->Smartreport_hca_model->select_competitoranalysisondate_perhotel($getHotelByUser->idhotels,$dateToView);
            if($dt_analystoday != NULL){
                $rs_today = $dt_analystoday->room_sold;
                $arr_today = $dt_analystoday->avg_roomrate;
            }

            //data dari table dsr
            $dt_dsrtoday = $this->Smartreport_dsr_model->select_dsrondate_perhotel($getHotelByUser->idhotels,$dateToView);
            if($dt_dsrtoday != NULL){
                $fnb_today = $dt_dsrtoday->sales_fnb;
                $guest_today = $dt_dsrtoday->numberofguest;
                $oth_today = $dt_dsrtoday->sales_other;
                $outoforder_today = $dt_dsrtoday->sales_outoforder;
            }

            //Room Inventory
            // $dt_riytd = $this->Smartreport_hca_model->select_RIYTD_perhotel($startdate_ytd,$enddate_ytd,$idhotel_custom);
                //$ri_ytd = $dt_riytd->RI_YTD;

                $diffdateytd= date_diff(new DateTime($startdate_ytd), new DateTime($enddate_ytd)); 
                $ri_ytd = $getHotelByUser->total_rooms * ($diffdateytd->days + 1);

            //total room revenue
            $trrDailyData = $this->Smartreport_hca_model->getDailyTrrForGraphById($getHotelByUser->idhotels,$enddate_mtd);
                $trr_today = $trrDailyData->graph_TrrDaily;
            $dt_trrmtd = $this->Smartreport_hca_model->select_trrmtd_perhotel($startdate_mtd,$enddate_mtd,$idhotel_custom);
                $trr_mtd = $dt_trrmtd->TRR_MTD;
            $dt_trrytd = $this->Smartreport_hca_model->select_trrytd_perhotel($startdate_ytd,$enddate_ytd,$idhotel_custom);
                $trr_ytd = $dt_trrytd->TRR_YTD;                                    
            //room sold
            $dt_rsmtd = $this->Smartreport_hca_model->select_rsmtd_perhotel($startdate_mtd,$enddate_mtd,$idhotel_custom);
                $rs_mtd = $dt_rsmtd->RS_MTD;
            $dt_rsytd = $this->Smartreport_hca_model->select_rsytd_perhotel($startdate_ytd,$enddate_ytd,$idhotel_custom);                                    
                $rs_ytd += $dt_rsytd->RS_YTD;
                
            //Average Room Rate
            if($rs_mtd != 0 && $trr_mtd != 0){
                $arr_mtd = $trr_mtd / $rs_mtd;
                
            }
            if($trr_ytd != 0 && $rs_ytd != 0){
                $arr_ytd = $trr_ytd /$rs_ytd;
            }
            // occupancy
            //$occDailyData = $this->Smartreport_hca_model->getDailyOccForGraphById($getHotelByUser->idhotels,$enddate_mtd);
            //    $occ_today = $occDailyData->graph_OccDaily.'%';                                
            //number of guest
            $dt_guestmtd = $this->Smartreport_dsr_model->select_guestmtd_perhotel($startdate_mtd,$enddate_mtd,$idhotel_custom);
                $guest_mtd = $dt_guestmtd->GUEST_MTD;
            $dt_guestytd = $this->Smartreport_dsr_model->select_guestytd_perhotel($startdate_ytd,$enddate_ytd,$idhotel_custom);                                  
                $guest_ytd = $dt_guestytd->GUEST_YTD;

            //room out of order
            $dt_outofordermtd = $this->Smartreport_dsr_model->select_outofordermtd_perhotel($startdate_mtd,$enddate_mtd,$idhotel_custom);
                $outoforder_mtd = $dt_outofordermtd->OUTOFORDER_MTD;
            $dt_outoforderytd = $this->Smartreport_dsr_model->select_outoforderytd_perhotel($startdate_ytd,$enddate_ytd,$idhotel_custom);                                  
                $outoforder_ytd = $dt_outoforderytd->OUTOFORDER_YTD;

            //sales fnb
            $dt_fnbmtd = $this->Smartreport_dsr_model->select_fnbmtd_perhotel($startdate_mtd,$enddate_mtd,$idhotel_custom);
                $fnb_mtd = $dt_fnbmtd->FNB_MTD;
            $dt_fnbytd = $this->Smartreport_dsr_model->select_fnbytd_perhotel($startdate_ytd,$enddate_ytd,$idhotel_custom);                                  
                $fnb_ytd = $dt_fnbytd->FNB_YTD;
            //sales others 
            $dt_othmtd = $this->Smartreport_dsr_model->select_othmtd_perhotel($startdate_mtd,$enddate_mtd,$idhotel_custom);
                $oth_mtd = $dt_othmtd->OTH_MTD;
            $dt_othytd = $this->Smartreport_dsr_model->select_othytd_perhotel($startdate_ytd,$enddate_ytd,$idhotel_custom);                                  
                $oth_ytd = $dt_othytd->OTH_YTD;        
            //total sales  
            $tot_sales_today = $trr_today + $fnb_today + $oth_today;
            $tot_sales_mtd = $trr_mtd + $fnb_mtd + $oth_mtd;
            $tot_sales_ytd = $trr_ytd + $fnb_ytd + $oth_ytd;

            //budget
            $lastmtd = $permonth - 1;
            $budget_roomsold = $this->Smartreport_pnl_model->get_roomsold_budget($idhotel_custom, $permonth, $peryear);
            $budget_guest = $this->Smartreport_pnl_model->get_guest_budget($idhotel_custom, $permonth, $peryear);
            $budget_arr =  $this->Smartreport_pnl_model->get_arr_budget($idhotel_custom, $permonth, $peryear);
            $budget_rooms =  $this->Smartreport_pnl_model->get_rooms_budget($idhotel_custom, $permonth, $peryear);
            $budget_fnb =  $this->Smartreport_pnl_model->get_fnb_budget($idhotel_custom, $permonth, $peryear);
            $budget_other =  $this->Smartreport_pnl_model->get_other_budget($idhotel_custom, $permonth, $peryear);
            $budget_laundry =  $this->Smartreport_pnl_model->get_laundry_budget($idhotel_custom, $permonth, $peryear);
            $budget_sport =  $this->Smartreport_pnl_model->get_sport_budget($idhotel_custom, $permonth, $peryear);
            $budget_spa =  $this->Smartreport_pnl_model->get_spa_budget($idhotel_custom, $permonth, $peryear);
            
            $budget_roomsoldytd = $this->Smartreport_pnl_model->get_roomsold_budgetytd($idhotel_custom, $lastmtd, $peryear);
            $budget_guestytd = $this->Smartreport_pnl_model->get_guest_budgetytd($idhotel_custom, $lastmtd, $peryear);
            //$budget_arrytd = $this->Smartreport_pnl_model->get_arr_budgetytd($idhotel_custom, $permonth, $peryear);
            $budget_roomsytd = $this->Smartreport_pnl_model->get_rooms_budgetytd($idhotel_custom, $lastmtd, $peryear);
            $budget_fnbytd = $this->Smartreport_pnl_model->get_fnb_budgetytd($idhotel_custom, $lastmtd, $peryear);
            $budget_otherytd = $this->Smartreport_pnl_model->get_other_budgetytd($idhotel_custom, $lastmtd, $peryear);
            $budget_laundryytd = $this->Smartreport_pnl_model->get_laundry_budgetytd($idhotel_custom, $lastmtd, $peryear);
            $budget_sportytd = $this->Smartreport_pnl_model->get_sport_budgetytd($idhotel_custom, $lastmtd, $peryear);
            $budget_spaytd = $this->Smartreport_pnl_model->get_spa_budgetytd($idhotel_custom, $lastmtd, $peryear);

            $getbudget_roomsoldytd = $budget_roomsoldytd->BUDGET_ROOMSOLDYTD+($budget_roomsold->BUDGET_ROOMSOLD/$days_this_month)*$perdate;

            $getbudget_roomsnow = $budget_rooms->BUDGET_ROOMS/$days_this_month;
            $getbudget_roomsmtd = ($budget_rooms->BUDGET_ROOMS/$days_this_month)*$perdate;
            $getbudget_roomsytd = $budget_roomsytd->BUDGET_ROOMSYTD+($budget_rooms->BUDGET_ROOMS/$days_this_month)*$perdate;

            $getbudget_fnbnow = $budget_fnb->BUDGET_FNB/$days_this_month;
            $getbudget_fnbmtd = ($budget_fnb->BUDGET_FNB/$days_this_month)*$perdate;
            $getbudget_fnbytd = $budget_fnbytd->BUDGET_FNBYTD+($budget_fnb->BUDGET_FNB/$days_this_month)*$perdate;

            $getbudget_laundrynow = $budget_laundry->BUDGET_LAUNDRY/$days_this_month; 
            $getbudget_laundrymtd = ($budget_laundry->BUDGET_LAUNDRY/$days_this_month)*$perdate;
            $getbudget_laundryytd = $budget_laundryytd->BUDGET_LAUNDRYYTD+($budget_laundry->BUDGET_LAUNDRY/$days_this_month)*$perdate; 

            $getbudget_othernow = $budget_other->BUDGET_OTHER/$days_this_month; 
            $getbudget_othermtd = ($budget_other->BUDGET_OTHER/$days_this_month)*$perdate;
            $getbudget_otherytd = $budget_otherytd->BUDGET_OTHERYTD+($budget_other->BUDGET_OTHER/$days_this_month)*$perdate;

            $getbudget_sportnow = $budget_sport->BUDGET_SPORT/$days_this_month; 
            $getbudget_sportmtd = ($budget_sport->BUDGET_SPORT/$days_this_month)*$perdate;
            $getbudget_sportytd = $budget_sportytd->BUDGET_SPORTYTD+($budget_sport->BUDGET_SPORT/$days_this_month)*$perdate;

            $getbudget_spanow = $budget_spa->BUDGET_SPA/$days_this_month; 
            $getbudget_spamtd = ($budget_spa->BUDGET_SPA/$days_this_month)*$perdate;
            $getbudget_spaytd = $budget_spaytd->BUDGET_SPAYTD+($budget_spa->BUDGET_SPA/$days_this_month)*$perdate;
            
            $totalbudget_now = $getbudget_roomsnow+$getbudget_fnbnow+$getbudget_laundrynow+$getbudget_othernow+$getbudget_sportnow+$getbudget_spanow;
            $totalbudget_mtd = $getbudget_roomsmtd+$getbudget_fnbmtd+$getbudget_laundrymtd+$getbudget_othermtd+$getbudget_sportmtd+$getbudget_spamtd;
            $totalbudget_ytd = $getbudget_roomsytd+$getbudget_fnbytd+$getbudget_laundryytd+$getbudget_otherytd+$getbudget_sportytd+$getbudget_spaytd;
            ?>

            <tr>
            <td colspan="13" style="text-align: center; color: white; background-color: #40739e;"><strong><?php echo $lang_statistic; ?></strong></td>
            
            
            </tr>
            <!-- NUMBER OF DAYS -->
            <tr>
            <td><?php echo $lang_number_days; ?></td>
            <td style="text-align: right;"><?php echo  $perdate; ?></td>
            <td></td>
            <td style="text-align: right;"><?php echo  $perdate; ?></td>
            <td></td>

            <td style="text-align: right;"><?php echo  $perdate; ?></td>
            <td></td>
            <td style="text-align: right;"><?php echo  $perdate; ?></td>
            <td></td>

            <td style="text-align: right;"><?php  echo $diffdateytd->days + 1; ?></td>
            <td></td>
            <td style="text-align: right;"><?php  echo $diffdateytd->days + 1; ?></td>
            <td style="border: 1px solid #ddd;"></td>
            </tr>

            <!-- ROOM AVAILABLE / ROOM INVENTORY -->
            <tr>
            <td><?php echo $lang_room_available; ?></td>
            <td style="text-align: right;"><?php echo number_format($getHotelByUser->total_rooms); ?></td>
            <td></td>
            <td style="text-align: right;"><?php echo number_format($getHotelByUser->total_rooms); ?></td>
            <td></td>

            <td style="text-align: right;"><?php echo number_format($getHotelByUser->total_rooms * $perdate); ?></td>
            <td></td>
            <td style="text-align: right;"><?php echo number_format($getHotelByUser->total_rooms * $perdate); ?></td>
            <td></td>

            <td style="text-align: right;"><?php  echo number_format($ri_ytd,0);?></td>
            <td></td>
            <td style="text-align: right;"><?php  echo number_format($ri_ytd,0);?></td>
            <td></td>
            </tr>

            <!-- ROOM OUT OF ORDER -->
            <tr>
            <td><?php echo $lang_outoforder; ?></td>
            <td style="text-align: right;"><?php echo number_format($outoforder_today);?></td>
            <td></td>
            <td></td>
            <td></td>

            <td style="text-align: right;"><?php echo number_format($outoforder_mtd);?></td>
            <td></td>
            <td></td>
            <td></td>

            <td style="text-align: right;"><?php echo number_format($outoforder_ytd);?></td>
            <td></td>
            <td></td>
            <td></td>

            </tr>

            <!-- ROOM SOLD/ OCCUPIED ROOM -->
            <tr>
            <td><?php echo $lang_room_sold; ?></td>

            <td style="text-align: right;"><?php echo number_format($rs_today); ?></td>
            <td><?php //if ($rs_today != 0 && $getHotelByUser->total_rooms != 0) {echo number_format(($rs_today/$getHotelByUser->total_rooms)*100,2).'%';}?>
            </td>

            <td style="text-align: right;"><?php echo number_format($budget_roomsold->BUDGET_ROOMSOLD/$days_this_month,0); ?> </td>
            <td></td>

            <td style="text-align: right;"><?php echo number_format($rs_mtd);?></td>
            <td><?php //if ($rs_mtd != 0 && $getHotelByUser->total_rooms != 0) {echo number_format(($rs_mtd/($getHotelByUser->total_rooms*$perdate))*100,2).'%';}?>
            </td>

            <td style="text-align: right;"><?php echo number_format(($budget_roomsold->BUDGET_ROOMSOLD/$days_this_month)*$perdate,0);?>
            </td>
            <td></td>

            <td style="text-align: right;"><?php echo number_format($rs_ytd); ?></td>
            <td><?php // if ($rs_ytd != 0 && $ri_ytd != 0) {echo number_format(($rs_ytd/$ri_ytd)*100,2).'%';}?>
            </td>

            <td style="text-align: right;"><?php echo number_format($getbudget_roomsoldytd); ?></td>
            <td></td>
            </tr>


            <!-- OCCUPANCY -->
            <tr>
            <td><?php echo $lang_occupancy; ?></td>

            <td style="text-align: right;"><?php $ri_today =  $getHotelByUser->total_rooms - $outoforder_today;
            if($rs_today != 0 && $ri_today != 0){
                $occ_today = ($rs_today / $ri_today) * 100;
            }
            echo number_format($occ_today,2).'%';?> 

            </td>
            <td></td>

            <td style="text-align: right;"><?php  if($getHotelByUser->total_rooms != 0){echo number_format((($budget_roomsold->BUDGET_ROOMSOLD/$days_this_month)/($getHotelByUser->total_rooms))*100,2).'%';}    ?>
            </td>
            <td></td>

            <td style="text-align: right;"><?php $ri_mtd = ($getHotelByUser->total_rooms * $perdate) - $outoforder_mtd;
                        if($rs_mtd != 0 && $ri_mtd != 0){
                                $occ_mtd = ($rs_mtd / $ri_mtd) * 100;
                        }
                        echo number_format($occ_mtd,2).'%';?></td>
            <td></td>

            <td style="text-align: right;"><?php if($getHotelByUser->total_rooms != 0){ echo number_format(((($budget_roomsold->BUDGET_ROOMSOLD/$days_this_month)*$perdate)/($getHotelByUser->total_rooms * $perdate))*100,2).'%';} ?>
            </td>
            <td></td>

            <td style="text-align: right;"><?php if($rs_ytd != 0 && $ri_ytd != 0){
                    echo number_format($occ_ytd = ($rs_ytd / ($ri_ytd-$outoforder_ytd)) * 100,2).'%';
                    } ?></td>
            <td></td>

            <td style="text-align: right;"><?php if($getHotelByUser->total_rooms != 0){echo number_format((($budget_roomsoldytd->BUDGET_ROOMSOLDYTD+($budget_roomsold->BUDGET_ROOMSOLD/$days_this_month)*$perdate)/$ri_ytd)*100,2).'%';} ?>
            </td>
            <td></td>
            </tr>

            <!-- NUMBER OF GUEST -->
            <tr>
            <td><?php echo $lang_number_guest; ?></td>

            <td style="text-align: right;"><?php echo number_format($guest_today);?></td>
            <td></td>

            <td style="text-align: right;"><?php echo number_format($budget_guest->BUDGET_GUEST/$days_this_month,0); ?></td>
            <td></td>

            <td style="text-align: right;"><?php echo number_format($guest_mtd);?></td>
            <td></td>

            <td style="text-align: right;"><?php echo number_format(($budget_guest->BUDGET_GUEST/$days_this_month)*$perdate,0);?></td>
            <td></td>

            <td style="text-align: right;"><?php echo number_format($guest_ytd);?></td>
            <td></td>

            <td style="text-align: right;"><?php echo number_format($budget_guestytd->BUDGET_GUESTYTD+($budget_guest->BUDGET_GUEST/$days_this_month)*$perdate); ?>
            </td>
            <td></td>
            </tr>

            <!--Average Room Rate-->
            <tr>
            <td><?php echo $lang_arr; ?></td>

            <td style="text-align: right;"><?php echo number_format($arr_today); ?></td>
            <td></td>

            <td style="text-align: right;"><?php echo number_format($budget_arr->BUDGET_ARR,0); ?></td>
            <td></td>

            <td style="text-align: right;"><?php echo number_format($arr_mtd);?></td>
            <td></td>

            <td style="text-align: right;"><?php echo number_format($budget_arr->BUDGET_ARR,0); ?></td>
            <td></td>

            <td style="text-align: right;"><?php echo number_format($arr_ytd);?></td>
            <td></td>

            <td style="text-align: right;"><?php if($getHotelByUser->total_rooms != 0 && $getbudget_roomsytd !=0 && $getbudget_roomsoldytd != 0 ){ echo number_format($getbudget_roomsytd/$getbudget_roomsoldytd);} ?>
            </td>
            <td></td>
            </tr>

            <tr>
            <td colspan="13" style="text-align: center; color: white; background-color: #40739e;"><strong><?php echo $lang_sales; ?></strong></td>  

            </tr>

            <!--Total Rooms Revenue / Rooms-->
            <tr>
            <td><?php echo $lang_rooms; ?></td>

            <td style="text-align: right;"><?php echo number_format($trr_today);?></td>
            <td style="text-align: right;"><?php if($trr_today != 0 && $tot_sales_today != 0){ echo number_format(($trr_today/$tot_sales_today)*100,2).'%';} ?>
            </td>

            <td style="text-align: right;"><?php echo number_format($getbudget_roomsnow,0); ?></td>
            <td style="text-align: right;"><?php if ($totalbudget_now != 0 && $getbudget_roomsnow !=0){echo number_format(($getbudget_roomsnow/$totalbudget_now)*100,2).'%';}?>
            </td>

            <td style="text-align: right;"><?php echo number_format($trr_mtd);?></td>
            <td style="text-align: right;"><?php if($trr_mtd != 0 && $tot_sales_mtd != 0){ echo number_format(($trr_mtd/$tot_sales_mtd)*100,2).'%';} ?>
            </td>

            <td style="text-align: right;"><?php echo number_format($getbudget_roomsmtd,0);?></td>
            <td style="text-align: right;"><?php if ($totalbudget_mtd != 0 && $getbudget_roomsmtd !=0){echo number_format(($getbudget_roomsmtd/$totalbudget_mtd)*100,2).'%';}?>
            </td>

            <td style="text-align: right;"><?php echo number_format($trr_ytd); ?></td>
            <td style="text-align: right;"><?php if($trr_ytd != 0 && $tot_sales_ytd != 0){ echo number_format(($trr_ytd/$tot_sales_ytd)*100,2).'%';} ?>
            </td>

            <td style="text-align: right;"><?php echo number_format($getbudget_roomsytd);  ?></td>
            <td style="text-align: right;"><?php if ($totalbudget_ytd != 0 && $getbudget_roomsytd !=0){echo number_format(($getbudget_roomsytd/$totalbudget_ytd)*100,2).'%';}?>
            </td>
            </tr>

            <!--FNB-->
            <tr>
            <td><?php echo $lang_fnb; ?></td>

            <td style="text-align: right;"><?php echo number_format($fnb_today);?></td>
            <td style="text-align: right;"><?php if($fnb_today != 0 && $tot_sales_today !=0 ){echo number_format(($fnb_today/$tot_sales_today)*100,2).'%';}?>
            </td>

            <td style="text-align: right;"><?php echo number_format($getbudget_fnbnow ,0); ?></td>
            <td style="text-align: right;"><?php if ($totalbudget_now != 0 && $getbudget_fnbnow !=0){echo number_format(($getbudget_fnbnow/$totalbudget_now)*100,2).'%';}?>
            </td>

            <td style="text-align: right;"><?php echo number_format($fnb_mtd);?></td>
            <td style="text-align: right;"><?php if($fnb_mtd != 0 && $tot_sales_mtd !=0 ){echo number_format(($fnb_mtd/$tot_sales_mtd)*100,2).'%';}?>
            </td>

            <td style="text-align: right;"><?php echo number_format($getbudget_fnbmtd ,0);?></td>
            <td style="text-align: right;"><?php if ($totalbudget_mtd != 0 && $getbudget_fnbmtd !=0){echo number_format(($getbudget_fnbmtd/$totalbudget_mtd)*100,2).'%';}?>
            </td>

            <td style="text-align: right;"><?php echo number_format($fnb_ytd);?></td>
            <td style="text-align: right;"><?php if($fnb_ytd != 0 && $tot_sales_ytd !=0 ){echo number_format(($fnb_ytd/$tot_sales_ytd)*100,2).'%';}?>
            </td>

            <td style="text-align: right;"><?php echo  number_format($getbudget_fnbytd); ?></td>
            <td style="text-align: right;"><?php if ($totalbudget_ytd != 0 && $getbudget_fnbytd !=0){echo number_format(($getbudget_fnbytd/$totalbudget_ytd)*100,2).'%';}?>
            </td>
            </tr>

            <!--Laundry & Other & SPA-->
            <tr>
            <td><?php echo $lang_other.' + '.$lang_laundry.' + '.$lang_spa; ?></td>

            <td style="text-align: right;"<?php echo number_format($oth_today);?></td>
            <td style="text-align: right;"><?php if($oth_today != 0 && $tot_sales_today != 0){ echo number_format(($oth_today/$tot_sales_today)*100,2).'%';}?>
            </td>

            <td style="text-align: right;"><?php echo number_format($getbudget_laundrynow+$getbudget_othernow+$getbudget_sportnow+$getbudget_spanow);?></td>
            <td style="text-align: right;"><?php if ($totalbudget_now != 0 ){echo number_format((($getbudget_laundrynow+$getbudget_othernow+$getbudget_sportnow+$getbudget_spanow)/$totalbudget_now)*100,2).'%';}?>
            </td>

            <td style="text-align: right;"><?php echo number_format($oth_mtd);?></td>
            <td style="text-align: right;"><?php if($oth_mtd != 0 && $tot_sales_mtd != 0){ echo number_format(($oth_mtd/$tot_sales_mtd)*100,2).'%';}?>
            </td>

            <td style="text-align: right;"><?php echo number_format($getbudget_laundrymtd+$getbudget_othermtd+$getbudget_sportmtd+$getbudget_spamtd);?></td>
            <td style="text-align: right;"><?php if ($totalbudget_mtd != 0 ){echo number_format((($getbudget_laundrymtd+$getbudget_othermtd+$getbudget_sportmtd+$getbudget_spamtd)/$totalbudget_mtd)*100,2).'%';}?>
            </td>

            <td style="text-align: right;"><?php echo number_format($oth_ytd);?></td>
            <td style="text-align: right;"><?php if($oth_ytd != 0 && $tot_sales_ytd != 0){ echo number_format(($oth_ytd/$tot_sales_ytd)*100,2).'%';}?>
            </td>

            <td style="text-align: right;"><?php echo number_format($getbudget_laundryytd+$getbudget_otherytd+$getbudget_sportytd+$getbudget_spaytd);?></td>
            <td style="text-align: right;"><?php if ($totalbudget_ytd != 0  ){echo number_format((($getbudget_laundryytd+$getbudget_otherytd+$getbudget_sportytd+$getbudget_spaytd)/$totalbudget_ytd)*100,2).'%';}?>
            </td>
            </tr>

            <!--Total-->
            <tr>
            <td><strong><?php echo $lang_total_sales; ?></strong></td>

            <td style="text-align: right;"><strong><?php echo number_format($tot_sales_today); ?></strong></td>
            <td style="text-align: right;"><?php if ($tot_sales_today != 0){echo number_format(($tot_sales_today/$tot_sales_today)*100,2).'%';} ?>
            </td>

            <td style="text-align: right;"><strong><?php echo number_format($totalbudget_now,0); ?></strong></td>
            <td style="text-align: right;"><?php if ($totalbudget_now !=0){echo number_format(($totalbudget_now/$totalbudget_now)*100,2).'%';}?>
            </td>

            <td style="text-align: right;"><strong><?php echo number_format($tot_sales_mtd);?></strong></td>
            <td style="text-align: right;"><?php if ($tot_sales_mtd != 0){echo number_format(($tot_sales_mtd/$tot_sales_mtd)*100,2).'%';} ?>
            </td>

            <td style="text-align: right;"><strong><?php echo number_format($totalbudget_mtd,0); ?></strong></td>
            <td style="text-align: right;"><?php if ($totalbudget_mtd !=0){echo number_format(($totalbudget_mtd/$totalbudget_mtd)*100,2).'%';}?>
            </td>

            <td style="text-align: right;"><strong><?php echo number_format($tot_sales_ytd);?></strong></td>
            <td style="text-align: right;"><?php if ($tot_sales_ytd != 0){echo number_format(($tot_sales_ytd/$tot_sales_ytd)*100,2).'%';} ?>
            </td>

            <td style="text-align: right;"><strong><?php echo number_format($totalbudget_ytd,0); ?></strong></td>
            <td style="text-align: right;"><?php if ($totalbudget_ytd !=0){echo number_format(($totalbudget_ytd/$totalbudget_ytd)*100,2).'%';}?>
            </td>
            </tr>


        <?php } ?>  
    </tbody>   

    <tfoot>
      <tr>
        <td colspan="13" style="font-size: 9px;">Sources: Kagum Hotels Smartdata.</td>
      </tr>
    </tfoot>
  </table>
</div>

</body>
</html>