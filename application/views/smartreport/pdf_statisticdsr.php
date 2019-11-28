<!DOCTYPE html>
<html lang="en" >
<head>

<?php
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
?>


<meta charset="UTF-8">
<title><?php echo $lang_statistic_dsr.' '.$perdate.' '.$monthObj->format('F').' '.$peryear; ?></title>



</head>

<body>
    <style>



#pdfreport {
  font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  margin-left:auto; 
  margin-right:auto;
  font-size: 10px;

  
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
    <caption><strong style="font-size: 14px;"><?php echo 'STATISTIC DSR '.$perdate.' '.$monthObj->format('F').' '.$peryear; ?></strong> <br/></caption>
    
    <thead>
        <tr>
            <th rowspan="2"><?php echo $lang_hotel_name; ?></th>
            <th rowspan="2">Rooms</th>
            <th rowspan="2">Rooms Sold</th>
            <th rowspan="2">Occ</th>
            <th rowspan="2">ARR</th>
            <th rowspan="2">Today Rev</th>
            <th colspan="2">MTD Rev</th>
            <th rowspan="2">%</th>                                    
        </tr>
        <tr>
            <th>Actual</th>
            <th>Budget</th>
        </tr>
    </thead>

    

    <tbody>

        

        <?php foreach ($smartreport_brand_data as $smartreport_brand){
        
                                $smartreport_hotelbrand_data = $this->Smartreport_dsr_model->select_hotel_bybrand($smartreport_brand->idhotelscategory);

                                $total_today_revroom = $this->Smartreport_dsr_model->room_revenue_today($dateToView,$smartreport_brand->idhotelscategory);
                                $total_today_revfnbother = $this->Smartreport_dsr_model->fnbother_revenue_today($dateToView,$smartreport_brand->idhotelscategory);
                                if ($total_today_revroom != NULL && $total_today_revfnbother != NULL){
                                        $grandtotal_today_rev = $total_today_revroom->room_revenue_today  + $total_today_revfnbother->fnb_rev_today + $total_today_revfnbother->oth_rev_other;
                                    }

                                $total_mtd_revroom = $this->Smartreport_dsr_model->room_revenue_mtd($startdate_mtd,$enddate_mtd,$smartreport_brand->idhotelscategory);
                                $total_mtd_revfnbother = $this->Smartreport_dsr_model->fnbother_revenue_mtd($startdate_mtd,$enddate_mtd,$smartreport_brand->idhotelscategory);
                                if ($total_mtd_revroom != NULL && $total_mtd_revfnbother != NULL){
                                    $grandtotal_mtd_rev = $total_mtd_revroom->room_revenue_today  + $total_mtd_revfnbother->fnb_rev_today + $total_mtd_revfnbother->oth_rev_other;
                                }

                                $mtd_budgetbybrand = $this->Smartreport_dsr_model->mtd_budgetbybrand($permonth,$peryear,$smartreport_brand->idhotelscategory);
                                if($mtd_budgetbybrand != NULL){
                                   $grandtotal_mtd_budgetbybrand =  (($mtd_budgetbybrand->budget_brand/$days_this_month)*$perdate);
                                }
                             ?>
                                <tr>
                                    <td colspan="9" style="text-align: center; color: white; background-color: #40739e;" ><?= $smartreport_brand->hotels_category; ?></td>
                                    
                                </tr>
                                <?php foreach ($smartreport_hotelbrand_data  as $smartreport_hotelbrand ){ 
                                    $dt_analystoday = $this->Smartreport_hca_model->select_competitoranalysisondate_perhotel($smartreport_hotelbrand->idhotels,$dateToView);
                                    $dt_dsrtoday = $this->Smartreport_dsr_model->select_dsrondate_perhotel($smartreport_hotelbrand->idhotels,$dateToView);
                                    
                                    $dt_trrmtd = $this->Smartreport_hca_model->select_trrmtd_perhotel($startdate_mtd,$enddate_mtd,$smartreport_hotelbrand->idhotels);                                    
                                    $dt_fnbmtd = $this->Smartreport_dsr_model->select_fnbmtd_perhotel($startdate_mtd,$enddate_mtd,$smartreport_hotelbrand->idhotels);
                                    $dt_othmtd = $this->Smartreport_dsr_model->select_othmtd_perhotel($startdate_mtd,$enddate_mtd,$smartreport_hotelbrand->idhotels);

                                    $budget_rooms =  $this->Smartreport_pnl_model->get_rooms_budget($smartreport_hotelbrand->idhotels, $permonth, $peryear);
                                    $budget_fnb =  $this->Smartreport_pnl_model->get_fnb_budget($smartreport_hotelbrand->idhotels, $permonth, $peryear);
                                    $budget_other =  $this->Smartreport_pnl_model->get_other_budget($smartreport_hotelbrand->idhotels,$permonth, $peryear);
                                    $budget_laundry =  $this->Smartreport_pnl_model->get_laundry_budget($smartreport_hotelbrand->idhotels, $permonth, $peryear);

                                    
                                    
                                    if($dt_analystoday != NULL   ){
                                        $rs_today = $dt_analystoday->room_sold;
                                        $arr_today = $dt_analystoday->avg_roomrate;
                                    }else{
                                        $rs_today = 0;
                                        $arr_today =0;                                        
                                    } 

                                    if($dt_dsrtoday != NULL){
                                        $fnb_today = $dt_dsrtoday->sales_fnb;
                                        $oth_today = $dt_dsrtoday->sales_other;   
                                    }else{
                                        $fnb_today = 0;
                                        $oth_today = 0; 
                                    }
                                    
                                    if($dt_trrmtd != NULL && $dt_fnbmtd !=NULL && $dt_othmtd != NULL){                                        
                                        $trr_mtd = $dt_trrmtd->TRR_MTD;                                  
                                        $fnb_mtd = $dt_fnbmtd->FNB_MTD;                                    
                                        $oth_mtd = $dt_othmtd->OTH_MTD;                                        
                                    }else{
                                        $trr_mtd = 0;
                                        $fnb_mtd = 0;
                                        $oth_mtd =0;                                        
                                    }

                                    
                                        $getbudget_roomsmtd = ($budget_rooms->BUDGET_ROOMS/$days_this_month)*$perdate;
                                        $getbudget_laundrymtd = ($budget_laundry->BUDGET_LAUNDRY/$days_this_month)*$perdate;
                                        $getbudget_othermtd = ($budget_other->BUDGET_OTHER/$days_this_month)*$perdate;
                                        $getbudget_fnbmtd = ($budget_fnb->BUDGET_FNB/$days_this_month)*$perdate;

                                        $trr_today = $rs_today * $arr_today;
                                        $tot_sales_today = $trr_today + $fnb_today + $oth_today;
                                        $tot_sales_mtd = $trr_mtd + $fnb_mtd + $oth_mtd;
                                        $totalbudget_mtd = $getbudget_roomsmtd+$getbudget_fnbmtd+$getbudget_laundrymtd+$getbudget_othermtd;
                                        
                                    ?>
                                <tr>
                                    <td><?= $smartreport_hotelbrand->hotels_name;?></td>
                                    <td style="text-align: right;"><?= $smartreport_hotelbrand->total_rooms;?></td>
                                    <td style="text-align: right;"> <?php echo  number_format($rs_today,0); ?></td>
                                    <td style="text-align: right;"><?php if ($rs_today != 0 && $smartreport_hotelbrand->total_rooms !=0){
                                        echo number_format(($rs_today/$smartreport_hotelbrand->total_rooms)*100,2).'%';
                                        } ?>
                                    </td>
                                    <td style="text-align: right;"><?php echo  number_format($arr_today,0); ?></td>
                                    <td style="text-align: right;"><?php echo number_format($tot_sales_today,0); ?></td>
                                    <td style="text-align: right;"><?php echo number_format($tot_sales_mtd,0); ?></td>
                                    <td style="text-align: right;"><?php echo number_format($totalbudget_mtd,0);?></td>
                                    <td style="text-align: right;"><?php if($tot_sales_mtd != 0 && $totalbudget_mtd != 0){echo number_format(($tot_sales_mtd/$totalbudget_mtd)*100,2).'%';} ?></td>
                                </tr>                                
                                <?php } ?>
                                <tr>
                                    <td colspan="5"><strong><?php echo "Total ".$smartreport_brand->hotels_category; ?></strong></td>                                    
                                    <td style="text-align: right;"><strong><?php echo number_format($grandtotal_today_rev,0); ?></strong></td>
                                    <td style="text-align: right;"><strong><?php echo number_format($grandtotal_mtd_rev,0); ?></strong></td>
                                    <td style="text-align: right;"><strong><?php echo number_format($grandtotal_mtd_budgetbybrand,0); ?></strong></td>
                                    <td style="text-align: right;"><strong><?php if($grandtotal_mtd_rev != 0 && $grandtotal_mtd_budgetbybrand != 0 ){echo number_format(($grandtotal_mtd_rev/$grandtotal_mtd_budgetbybrand)*100,2).'%';} ?></strong></td>


                                </tr>
                            <?php } ?>

                            <?php
                                $alltotal_today_revroom = $this->Smartreport_dsr_model->room_revenue_today($dateToView,"ALL");
                                $alltotal_today_revfnbother = $this->Smartreport_dsr_model->fnbother_revenue_today($dateToView,"ALL");
                                if ($alltotal_today_revroom != NULL && $alltotal_today_revfnbother != NULL){
                                        $alltotal_today_rev = $alltotal_today_revroom->room_revenue_today  + $alltotal_today_revfnbother->fnb_rev_today + $alltotal_today_revfnbother->oth_rev_other;
                                    }

                                $alltotal_mtd_revroom = $this->Smartreport_dsr_model->room_revenue_mtd($startdate_mtd,$enddate_mtd,"ALL");
                                $alltotal_mtd_revfnbother = $this->Smartreport_dsr_model->fnbother_revenue_mtd($startdate_mtd,$enddate_mtd,"ALL");
                                if ($alltotal_mtd_revroom != NULL && $alltotal_mtd_revfnbother != NULL){
                                        $alltotal_mtd_rev = $alltotal_mtd_revroom->room_revenue_today  + $alltotal_mtd_revfnbother->fnb_rev_today + $alltotal_mtd_revfnbother->oth_rev_other;
                                    }

                                $mtd_budgetallbrand = $this->Smartreport_dsr_model->mtd_budgetbybrand($permonth,$peryear,"ALL");
                                if($mtd_budgetallbrand != NULL){
                                        $alltotal_mtd_budgetbybrand =  (($mtd_budgetallbrand->budget_brand/$days_this_month)*$perdate);
                                    }    
                                    
                            ?>

                            <tr>
                                <td style="font-size: 11px; color: #EA2027;" colspan="5"><strong>GRAND TOTAL</strong></td>                                    
                                <td style="font-size: 11px;text-align: right; color: #EA2027;"><strong><?php echo number_format($alltotal_today_rev,0); ?></strong></td>
                                <td style="font-size: 11px;text-align: right; color: #EA2027;"><strong><?php echo number_format($alltotal_mtd_rev,0); ?></strong></td>
                                <td style="font-size: 11px;text-align: right; color: #EA2027;"><strong><?php echo number_format($alltotal_mtd_budgetbybrand,0); ?></strong></td>
                                <td></td>
                            </tr>

                            <tr>
                                <td style="font-size: 11px;color: #EA2027;" colspan="5"><strong>ACHIEVEMENT / DAY</strong></td>                                    
                                <td colspan="4" style="font-size: 11px;text-align: right; color: #EA2027;"><strong><?php echo number_format($alltotal_mtd_rev/$perdate)?></strong></td>                                
                            </tr>

                            <tr>
                                <td style="font-size: 11px;color: #EA2027;" colspan="5"><strong>ACHIEVEMENT</strong></td>                                    
                                <td colspan="4" style="font-size: 11px;text-align: right; color: #EA2027;"><strong><?php echo number_format(($alltotal_mtd_rev/$alltotal_mtd_budgetbybrand)*100,2).'%';?></strong></td>
                            </tr>

                            </tbody>     

    <tfoot>
      <tr>
        <td colspan="9" style="font-size: 9px;">Sources: Kagum Hotels Smartdata. </td>
      </tr>
    </tfoot>
  </table>
</div>

</body>
</html>