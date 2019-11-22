
<style>

.customEryan{
	font-size: 11px;
	width: 100%;  
}

</style>
<script type="text/javascript">       
$(document).ready(function(){ 	
     $('.daterange-single').daterangepicker({ 
        singleDatePicker: true,
        locale: {
            format: 'DD-MM-YYYY'
        }
    });	
});

function formatAngka(){
    this.value = this.value.replace(/[^\d]/, '').replace(/(\..*)\./g, '$1');
}
</script>
<script src="<?php echo base_url();?>assets/backend/global_assets/js/plugins/tables/datatables/datatables.min.js"></script> 
<script src="<?php echo base_url();?>assets/backend/global_assets/js/plugins/tables/datatables/extensions/fixed_columns.min.js"></script>
<script src="<?php echo base_url();?>assets/backend/global_assets/js/demo_pages/datatables_extension_fixed_columns.js"></script>

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

                  
?>

		<!-- Page header -->
        <div class="page-header page-header-light">
				<div class="page-header-content header-elements-md-inline">
					<div class="page-title d-flex">
						<h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold"> <?php echo $lang_analysis; ?></span> - <?php echo $lang_dsr; ?></h4>
						<a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
					</div>
				</div>
		</div>
		<!-- /page header -->                
				
		<!-- Row toggler -->
				<div class="card">
					<div class="card-header header-elements-inline">
					<div class="col-md-10">
					<div class="form-group row">
						<div class="col-lg-3">
							<button type="button" class="btn bg-teal-400 btn-labeled btn-labeled-left" data-toggle="modal" data-target="#modal_add_dsr"><b><i class="icon-cabinet"></i></b> <?php echo $lang_add_dsr; ?></button>
						</div>
						
						<div class="col-lg-5">
                            <form action="<?php echo base_url()?>smartreportdsr/daily-sales-report" method="get" accept-charset="utf-8">
                            <div class="d-flex ">						
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-prepend">
                                            <span class="input-group-text"><i class="icon-calendar22"></i></span>
                                        </span>
                                        <input type="text" data-mask="99-99-9999" name="date_dsr" class="form-control daterange-single" value="<?php echo ($date_dsr === NULL) ? date('d-m-Y',$d) : $date_dsr; ?>" required  />
                                    </div>
                                </div>
                                <div class="form-group">											
                                    <button type="submit" class="btn bg-teal-400 "><?php echo $lang_search; ?></button>
                                </div>
                            </div>
                            </form>										
						</div>
					</div>
					</div>	
					<div class="header-elements">
							<div class="list-icons">
		                		<a class="list-icons-item" data-action="collapse"></a>
		                	</div>
	                </div>
					</div>
                    
                    <div class="table-responsive">
                        <table class="table table-bordered table-togglable table-hover customEryan datatable-nobutton-1column text-nowrap" >
                            <thead style="vertical-align: middle; text-align: center">
                                <tr>
                                    <th rowspan="2">Category</th>
                                    <th colspan="4"><?php echo $lang_today; ?></th>
                                    <th colspan="4">MTD</th>
                                    <th colspan="4">YTD</th>
                                </tr>
                                <tr>
                                    <th><?php echo $lang_actual; ?></th>
                                    <th>%</th>
                                    <th><?php echo $lang_budget; ?></th>
                                    <th>%</th>

                                    <th><?php echo $lang_actual; ?></th>
                                    <th>%</th>
                                    <th><?php echo $lang_budget; ?></th>
                                    <th>%</th>

                                    <th><?php echo $lang_actual; ?></th>
                                    <th>%</th>
                                    <th><?php echo $lang_budget; ?></th>
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
                                }
                                
                                //Room Inventory
                               // $dt_riytd = $this->Smartreport_hca_model->select_RIYTD_perhotel($startdate_ytd,$enddate_ytd,$user_ho);
                                    //$ri_ytd = $dt_riytd->RI_YTD;

                                    $diffdateytd= date_diff(new DateTime($startdate_ytd), new DateTime($enddate_ytd)); 
                                    $ri_ytd = $getHotelByUser->total_rooms * ($diffdateytd->days + 1);

                                //total room revenue
                                $trrDailyData = $this->Smartreport_hca_model->getDailyTrrForGraphById($getHotelByUser->idhotels,$enddate_mtd);
                                    $trr_today = $trrDailyData->graph_TrrDaily;
                                $dt_trrmtd = $this->Smartreport_hca_model->select_trrmtd_perhotel($startdate_mtd,$enddate_mtd,$user_ho);
                                    $trr_mtd = $dt_trrmtd->TRR_MTD;
                                $dt_trrytd = $this->Smartreport_hca_model->select_trrytd_perhotel($startdate_ytd,$enddate_ytd,$user_ho);
                                    $trr_ytd = $dt_trrytd->TRR_YTD;                                    
                                //room sold
                                $dt_rsmtd = $this->Smartreport_hca_model->select_rsmtd_perhotel($startdate_mtd,$enddate_mtd,$user_ho);
                                    $rs_mtd = $dt_rsmtd->RS_MTD;
                                $dt_rsytd = $this->Smartreport_hca_model->select_rsytd_perhotel($startdate_ytd,$enddate_ytd,$user_ho);                                    
                                    $rs_ytd += $dt_rsytd->RS_YTD;
                                    
                                //Average Room Rate
                                if($rs_mtd != 0 && $trr_mtd != 0){
                                    $arr_mtd = $trr_mtd / $rs_mtd;
                                    
                                }
                                if($trr_ytd != 0 && $rs_ytd != 0){
                                    $arr_ytd = $trr_ytd /$rs_ytd;
                                }
                                // occupancy
                                $occDailyData = $this->Smartreport_hca_model->getDailyOccForGraphById($getHotelByUser->idhotels,$enddate_mtd);
                                    $occ_today = $occDailyData->graph_OccDaily.'%';                                
                                 //number of guest
                                 $dt_guestmtd = $this->Smartreport_dsr_model->select_guestmtd_perhotel($startdate_mtd,$enddate_mtd,$user_ho);
                                    $guest_mtd = $dt_guestmtd->GUEST_MTD;
                                 $dt_guestytd = $this->Smartreport_dsr_model->select_guestytd_perhotel($startdate_ytd,$enddate_ytd,$user_ho);                                  
                                    $guest_ytd = $dt_guestytd->GUEST_YTD;
                                  
                                 //sales fnb
                                 $dt_fnbmtd = $this->Smartreport_dsr_model->select_fnbmtd_perhotel($startdate_mtd,$enddate_mtd,$user_ho);
                                    $fnb_mtd = $dt_fnbmtd->FNB_MTD;
                                $dt_fnbytd = $this->Smartreport_dsr_model->select_fnbytd_perhotel($startdate_ytd,$enddate_ytd,$user_ho);                                  
                                    $fnb_ytd = $dt_fnbytd->FNB_YTD;
                                 //sales others 
                                 $dt_othmtd = $this->Smartreport_dsr_model->select_othmtd_perhotel($startdate_mtd,$enddate_mtd,$user_ho);
                                    $oth_mtd = $dt_othmtd->OTH_MTD;
                                 $dt_othytd = $this->Smartreport_dsr_model->select_othytd_perhotel($startdate_ytd,$enddate_ytd,$user_ho);                                  
                                    $oth_ytd = $dt_othytd->OTH_YTD;        
                                 //total sales  
                                   $tot_sales_today = $trr_today + $fnb_today + $oth_today;
                                   $tot_sales_mtd = $trr_mtd + $fnb_mtd + $oth_mtd;
                                   $tot_sales_ytd = $trr_ytd + $fnb_ytd + $oth_ytd;

                                   //budget
                                   $lastmtd = $permonth - 1;
                                   $budget_roomsold = $this->Smartreport_pnl_model->get_roomsold_budget($user_ho, $permonth, $peryear);
                                   $budget_guest = $this->Smartreport_pnl_model->get_guest_budget($user_ho, $permonth, $peryear);
                                   $budget_arr =  $this->Smartreport_pnl_model->get_arr_budget($user_ho, $permonth, $peryear);
                                   $budget_rooms =  $this->Smartreport_pnl_model->get_rooms_budget($user_ho, $permonth, $peryear);
                                   $budget_fnb =  $this->Smartreport_pnl_model->get_fnb_budget($user_ho, $permonth, $peryear);
                                   $budget_other =  $this->Smartreport_pnl_model->get_other_budget($user_ho, $permonth, $peryear);
                                   $budget_laundry =  $this->Smartreport_pnl_model->get_laundry_budget($user_ho, $permonth, $peryear);
                                   
                                   $budget_roomsoldytd = $this->Smartreport_pnl_model->get_roomsold_budgetytd($user_ho, $lastmtd, $peryear);
                                   $budget_guestytd = $this->Smartreport_pnl_model->get_guest_budgetytd($user_ho, $lastmtd, $peryear);
                                   //$budget_arrytd = $this->Smartreport_pnl_model->get_arr_budgetytd($user_ho, $permonth, $peryear);
                                   $budget_roomsytd = $this->Smartreport_pnl_model->get_rooms_budgetytd($user_ho, $lastmtd, $peryear);
                                   $budget_fnbytd = $this->Smartreport_pnl_model->get_fnb_budgetytd($user_ho, $lastmtd, $peryear);
                                   $budget_otherytd = $this->Smartreport_pnl_model->get_other_budgetytd($user_ho, $lastmtd, $peryear);
                                   $budget_laundryytd = $this->Smartreport_pnl_model->get_laundry_budgetytd($user_ho, $lastmtd, $peryear);

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
                                   
                                   $totalbudget_now = $getbudget_roomsnow+$getbudget_fnbnow+$getbudget_laundrynow+$getbudget_othernow;
                                   $totalbudget_mtd = $getbudget_roomsmtd+$getbudget_fnbmtd+$getbudget_laundrymtd+$getbudget_othermtd;
                                   $totalbudget_ytd = $getbudget_roomsytd+$getbudget_fnbytd+$getbudget_laundryytd+$getbudget_otherytd;
                                ?>
                                
                                <tr>
                                   <td><strong><?php echo $lang_statistic; ?></strong></td> 
                                   <td colspan="12"></td>
									<td style="display: none;"></td>
									<td style="display: none;"></td>
									<td style="display: none;"></td>
									<td style="display: none;"></td>
									<td style="display: none;"></td>
									<td style="display: none;"></td>
									<td style="display: none;"></td>
									<td style="display: none;"></td>	
                                    <td style="display: none;"></td>
                                    <td style="display: none;"></td>	
                                    <td style="display: none;"></td>
                                </tr>
                                <!-- NUMBER OF DAYS -->
                                <tr>
                                   <td>&emsp;&emsp;<?php echo $lang_number_days; ?></td> 
                                   <td><?php echo  $perdate; ?></td>
                                   <td></td>
                                   <td><?php echo  $perdate; ?></td>
                                   <td></td>

                                   <td><?php echo  $perdate; ?></td>
                                   <td></td>
                                   <td><?php echo  $perdate; ?></td>
                                   <td></td>

                                   <td><?php  echo $diffdateytd->days + 1; ?></td>
                                   <td></td>
                                   <td><?php  echo $diffdateytd->days + 1; ?></td>
                                   <td></td>
                                </tr>

                                <!-- ROOM AVAILABLE / ROOM INVENTORY -->
                                <tr>
                                   <td>&emsp;&emsp;<?php echo $lang_room_available; ?></td>
                                   <td><?php echo number_format($getHotelByUser->total_rooms); ?></td>
                                   <td></td>
                                   <td><?php echo number_format($getHotelByUser->total_rooms); ?></td>
                                   <td></td>

                                   <td><?php echo number_format($getHotelByUser->total_rooms * $perdate); ?></td>
                                   <td></td>
                                   <td><?php echo number_format($getHotelByUser->total_rooms * $perdate); ?></td>
                                   <td></td>
                                   
                                   <td><?php  echo number_format($ri_ytd,0);?></td>
                                   <td></td>
                                   <td><?php  echo number_format($ri_ytd,0);?></td>
                                   <td></td> 
                                </tr>

                                <!-- ROOM SOLD/ OCCUPIED ROOM -->
                                <tr>
                                   <td>&emsp;&emsp;<?php echo $lang_room_sold; ?></td>

                                   <td><?php echo number_format($rs_today); ?></td>
                                   <td><?php //if ($rs_today != 0 && $getHotelByUser->total_rooms != 0) {echo number_format(($rs_today/$getHotelByUser->total_rooms)*100,2).'%';}?></td>

                                   <td><?php echo number_format($budget_roomsold->BUDGET_ROOMSOLD/$days_this_month,0); ?> </td>
                                   <td></td>

                                   <td><?php echo number_format($rs_mtd);?></td>
                                   <td><?php //if ($rs_mtd != 0 && $getHotelByUser->total_rooms != 0) {echo number_format(($rs_mtd/($getHotelByUser->total_rooms*$perdate))*100,2).'%';}?></td>

                                   <td><?php echo number_format(($budget_roomsold->BUDGET_ROOMSOLD/$days_this_month)*$perdate,0);?></td>
                                   <td></td>

                                   <td><?php echo number_format($rs_ytd); ?></td>
                                   <td><?php // if ($rs_ytd != 0 && $ri_ytd != 0) {echo number_format(($rs_ytd/$ri_ytd)*100,2).'%';}?></td>

                                   <td><?php echo number_format($getbudget_roomsoldytd); ?></td>
                                   <td></td> 
                                </tr>

                                <!-- OCCUPANCY -->
                                <tr>
                                   <td>&emsp;&emsp;<?php echo $lang_occupancy; ?></td>

                                   <td><?php echo $occ_today;?></td>
                                   <td></td>

                                   <td><?php  if($getHotelByUser->total_rooms != 0){echo number_format((($budget_roomsold->BUDGET_ROOMSOLD/$days_this_month)/($getHotelByUser->total_rooms))*100,2).'%';}    ?></td>
                                   <td></td>
                                   
                                   <td><?php $ri_mtd = $getHotelByUser->total_rooms * $perdate;
											 if($rs_mtd != 0 && $ri_mtd != 0){
													$occ_mtd = ($rs_mtd / $ri_mtd) * 100;
											}
											echo number_format($occ_mtd,2).'%';?></td>
                                   <td></td>
                                   
                                   <td><?php if($getHotelByUser->total_rooms != 0){ echo number_format(((($budget_roomsold->BUDGET_ROOMSOLD/$days_this_month)*$perdate)/($getHotelByUser->total_rooms * $perdate))*100,2).'%';} ?></td>
                                   <td></td>

                                   <td><?php if($rs_ytd != 0 && $ri_ytd != 0){
                                        echo number_format($occ_ytd = ($rs_ytd / $ri_ytd) * 100,2).'%';
                                        } ?></td>
                                   <td></td>

                                   <td><?php if($getHotelByUser->total_rooms != 0){echo number_format((($budget_roomsoldytd->BUDGET_ROOMSOLDYTD+($budget_roomsold->BUDGET_ROOMSOLD/$days_this_month)*$perdate)/$ri_ytd)*100,2).'%';} ?></td>
                                   <td></td> 
                                </tr>

                                <!-- NUMBER OF GUEST -->
                                <tr>
                                   <td>&emsp;&emsp;<?php echo $lang_number_guest; ?></td>

                                   <td><?php echo number_format($guest_today);?></td>
                                   <td></td>

                                   <td><?php echo number_format($budget_guest->BUDGET_GUEST/$days_this_month,0); ?></td>
                                   <td></td>

                                   <td><?php echo number_format($guest_mtd);?></td>
                                   <td></td>

                                   <td><?php echo number_format(($budget_guest->BUDGET_GUEST/$days_this_month)*$perdate,0);?></td>
                                   <td></td>

                                   <td><?php echo number_format($guest_ytd);?></td>
                                   <td></td>

                                   <td><?php echo number_format($budget_guestytd->BUDGET_GUESTYTD+($budget_guest->BUDGET_GUEST/$days_this_month)*$perdate); ?></td>
                                   <td></td> 
                                </tr>
                                
                                <!--Average Room Rate-->
                                <tr>
                                   <td>&emsp;&emsp;<?php echo $lang_arr; ?></td>

                                   <td><?php echo number_format($arr_today); ?></td>
                                   <td></td>

                                   <td><?php echo number_format($budget_arr->BUDGET_ARR,0); ?></td>
                                   <td></td>

                                   <td><?php echo number_format($arr_mtd);?></td>
                                   <td></td>

                                   <td><?php echo number_format($budget_arr->BUDGET_ARR,0); ?></td>
                                   <td></td>

                                   <td><?php echo number_format($arr_ytd);?></td>
                                   <td></td>
                                   
                                   <td><?php if($getHotelByUser->total_rooms != 0){ echo number_format($getbudget_roomsytd/$getbudget_roomsoldytd);} ?></td>
                                   <td></td> 
                                </tr>

                                <tr>
                                   <td><strong><?php echo $lang_sales; ?></strong></td> 
                                    <td colspan="12"></td>
									<td style="display: none;"></td>
									<td style="display: none;"></td>
									<td style="display: none;"></td>
									<td style="display: none;"></td>
									<td style="display: none;"></td>
									<td style="display: none;"></td>
									<td style="display: none;"></td>
									<td style="display: none;"></td>	
                                    <td style="display: none;"></td>
                                    <td style="display: none;"></td>	
                                    <td style="display: none;"></td>	
                                       
                                </tr>
                                
                                <!--Total Rooms Revenue / Rooms-->
                                <tr>
                                   <td>&emsp;&emsp;<?php echo $lang_rooms; ?></td>

                                   <td><?php echo number_format($trr_today);?></td>
                                   <td><?php if($trr_today != 0 && $tot_sales_today != 0){ echo number_format(($trr_today/$tot_sales_today)*100,2).'%';} ?></td>
                                   
                                   <td><?php echo number_format($getbudget_roomsnow,0); ?></td>
                                   <td><?php if ($totalbudget_now != 0 && $getbudget_roomsnow !=0){echo number_format(($getbudget_roomsnow/$totalbudget_now)*100,2).'%';}?></td>

                                   <td><?php echo number_format($trr_mtd);?></td>
                                   <td><?php if($trr_mtd != 0 && $tot_sales_mtd != 0){ echo number_format(($trr_mtd/$tot_sales_mtd)*100,2).'%';} ?></td>

                                   <td><?php echo number_format($getbudget_roomsmtd,0);?></td>
                                   <td><?php if ($totalbudget_mtd != 0 && $getbudget_roomsmtd !=0){echo number_format(($getbudget_roomsmtd/$totalbudget_mtd)*100,2).'%';}?></td>

                                   <td><?php echo number_format($trr_ytd); ?></td>
                                   <td><?php if($trr_ytd != 0 && $tot_sales_ytd != 0){ echo number_format(($trr_ytd/$tot_sales_ytd)*100,2).'%';} ?></td>

                                   <td><?php echo number_format($getbudget_roomsytd);  ?></td>
                                   <td><?php if ($totalbudget_ytd != 0 && $getbudget_roomsytd !=0){echo number_format(($getbudget_roomsytd/$totalbudget_ytd)*100,2).'%';}?></td> 
                                </tr>

                                <!--FNB-->
                                <tr>
                                   <td>&emsp;&emsp;<?php echo $lang_fnb; ?></td>

                                   <td><?php echo number_format($fnb_today);?></td>
                                   <td><?php if($fnb_today != 0 && $tot_sales_today !=0 ){echo number_format(($fnb_today/$tot_sales_today)*100,2).'%';}?></td>

                                   <td><?php echo number_format($getbudget_fnbnow ,0); ?></td>
                                   <td><?php if ($totalbudget_now != 0 && $getbudget_fnbnow !=0){echo number_format(($getbudget_fnbnow/$totalbudget_now)*100,2).'%';}?></td>

                                   <td><?php echo number_format($fnb_mtd);?></td>
                                   <td><?php if($fnb_mtd != 0 && $tot_sales_mtd !=0 ){echo number_format(($fnb_mtd/$tot_sales_mtd)*100,2).'%';}?></td>

                                   <td><?php echo number_format($getbudget_fnbmtd ,0);?></td>
                                   <td><?php if ($totalbudget_mtd != 0 && $getbudget_fnbmtd !=0){echo number_format(($getbudget_fnbmtd/$totalbudget_mtd)*100,2).'%';}?></td>

                                   <td><?php echo number_format($fnb_ytd);?></td>
                                   <td><?php if($fnb_ytd != 0 && $tot_sales_ytd !=0 ){echo number_format(($fnb_ytd/$tot_sales_ytd)*100,2).'%';}?></td>

                                   <td><?php echo  number_format($getbudget_fnbytd); ?></td>
                                   <td><?php if ($totalbudget_ytd != 0 && $getbudget_fnbytd !=0){echo number_format(($getbudget_fnbytd/$totalbudget_ytd)*100,2).'%';}?></td> 
                                </tr>
                               
                                <!--Laundry & Other-->
                                <tr>
                                   <td>&emsp;&emsp;<?php echo $lang_other.' + '.$lang_laundry; ?></td>

                                   <td><?php echo number_format($oth_today);?></td>
                                   <td><?php if($oth_today != 0 && $tot_sales_today != 0){ echo number_format(($oth_today/$tot_sales_today)*100,2).'%';}?></td>

                                   <td><?php echo number_format($getbudget_laundrynow+$getbudget_othernow);?></td>
                                   <td><?php if ($totalbudget_now != 0 && $getbudget_othernow !=0 && $getbudget_laundrynow){echo number_format((($getbudget_laundrynow+$getbudget_othernow)/$totalbudget_now)*100,2).'%';}?></td>

                                   <td><?php echo number_format($oth_mtd);?></td>
                                   <td><?php if($oth_mtd != 0 && $tot_sales_mtd != 0){ echo number_format(($oth_mtd/$tot_sales_mtd)*100,2).'%';}?></td>

                                   <td><?php echo number_format($getbudget_laundrymtd+$getbudget_othermtd);?></td>
                                   <td><?php if ($totalbudget_mtd != 0 && $getbudget_othermtd !=0 && $getbudget_laundrymtd){echo number_format((($getbudget_laundrymtd+$getbudget_othermtd)/$totalbudget_mtd)*100,2).'%';}?></td>

                                   <td><?php echo number_format($oth_ytd);?></td>
                                   <td><?php if($oth_ytd != 0 && $tot_sales_ytd != 0){ echo number_format(($oth_ytd/$tot_sales_ytd)*100,2).'%';}?></td>

                                   <td><?php echo number_format($getbudget_laundryytd+$getbudget_otherytd);?></td>
                                   <td><?php if ($totalbudget_ytd != 0 && $getbudget_otherytd !=0 && $getbudget_laundryytd){echo number_format((($getbudget_laundryytd+$getbudget_otherytd)/$totalbudget_ytd)*100,2).'%';}?></td> 
                                </tr>

                                <!--Total-->
                                <tr>
                                   <td><strong><?php echo $lang_total_sales; ?></strong></td> 

                                   <td><strong><?php echo number_format($tot_sales_today); ?></strong></td>
                                   <td><?php if ($tot_sales_today != 0){echo number_format(($tot_sales_today/$tot_sales_today)*100,2).'%';} ?></td>

                                   <td><strong><?php echo number_format($totalbudget_now,0); ?></strong></td>
                                   <td><?php if ($totalbudget_now !=0){echo number_format(($totalbudget_now/$totalbudget_now)*100,2).'%';}?></td>

                                   <td><strong><?php echo number_format($tot_sales_mtd);?></strong></td>
                                   <td><?php if ($tot_sales_mtd != 0){echo number_format(($tot_sales_mtd/$tot_sales_mtd)*100,2).'%';} ?></td>

                                   <td><strong><?php echo number_format($totalbudget_mtd,0); ?></strong></td>
                                   <td><?php if ($totalbudget_mtd !=0){echo number_format(($totalbudget_mtd/$totalbudget_mtd)*100,2).'%';}?></td>

                                   <td><strong><?php echo number_format($tot_sales_ytd);?></strong></td>
                                   <td><?php if ($tot_sales_ytd != 0){echo number_format(($tot_sales_ytd/$tot_sales_ytd)*100,2).'%';} ?></td>

                                   <td><strong><?php echo number_format($totalbudget_ytd,0); ?></strong></td>
                                   <td><?php if ($totalbudget_ytd !=0){echo number_format(($totalbudget_ytd/$totalbudget_ytd)*100,2).'%';}?></td>
                                </tr>

                            </tbody>
                            <?php } ?>
                        </table>
                    </div>
						
					
				</div>
				<!-- /row toggler -->
				
				<!-- Vertical form modal -->
				<div id="modal_add_dsr" class="modal fade" tabindex="-1" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title"><?php echo $lang_add_dsr; ?></h5>
								<button type="button" class="close"  data-dismiss="modal" aria-hidden="true">&times;</button>
							</div>

							<form action="<?=base_url()?>smartreportdsr/insert_dsr" method="post">
								<div class="modal-body">
									<div class="form-group">
										<div class="row">
											<div class="col-sm-6">
												<label><?php echo $lang_number_guest; ?></label>
												<input type="text"  oninput="this.value = this.value.replace(/[^\d]/, '').replace(/(\..*)\./g, '$1');" name="dsr_guest" class="form-control" required>
											</div>

											<div class="col-sm-6">
												<label><?php echo $lang_fnb; ?></label>
												<input type="text" oninput="this.value = this.value.replace(/[^\d]/, '').replace(/(\..*)\./g, '$1');" name="dsr_fnb"  class="form-control" required>
                                            </div>
                                            
										</div>
                                    </div>
                                    <div class="form-group">
										<div class="row">											
                                            <div class="col-sm-6">
												<label><?php echo $lang_other.' + '.$lang_laundry; ?></label>
												<input type="text" oninput="this.value = this.value.replace(/[^\d]/, '').replace(/(\..*)\./g, '$1');" name="dsr_other"  class="form-control" required>
                                            </div>
                                            <div class="col-sm-6">
                                            <label><?php echo $lang_date; ?></label>
                                                <div class="input-group">
                                                    <span class="input-group-prepend">
                                                        <span class="input-group-text"><i class="icon-calendar22"></i></span>
                                                    </span>
                                                    <input type="text" data-mask="99-99-9999" <?php if ($user_le > '2'){ echo "readonly";} ?> name="date_dsr" class="form-control <?php if ($user_le <= '2'){ echo "daterange-single";} ?>" value="<?php echo date('d-m-Y',strtotime("-1 Day")); ?>" required  />
                                                </div>
                                         </div>
										</div>
									</div>

									
								</div>

								<div class="modal-footer">
									<button type="button" class="btn btn-link" aria-hidden="true" data-dismiss="modal"><?php echo $lang_close; ?></button>
									<button type="submit" class="btn bg-primary"><?php echo $lang_submit; ?></button>
								</div>
							</form>
						</div>
					</div>
				</div>
				<!-- /vertical form modal -->
