<script src="<?php echo base_url();?>assets/backend/global_assets/js/plugins/visualization/echarts/echarts.min.js"></script>

<style>
.customEryan{
	font-size: 11px;
	width: 100%;  
}

.tile  {
  font-size: 100px;
  overflow:hidden;
  position: absolute;
  
  top: 0;
  right: 0;
  bottom: 0;
  left: 50;
  display: -webkit-box;
  padding-right: 10px;
  padding-top: 10px;
  padding-bottom: 15px;
  /* Safari */
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 1;
}

.rata-kanan{
	text-align: right;
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


		<!-- Page header -->
        <div class="page-header page-header-light">
				<div class="page-header-content header-elements-md-inline">

					<div class="page-title d-flex">
						<h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold"> <?php echo $lang_dashboard; ?></span> - <?php echo $lang_statistic_dsr.' '.$perdate.' '.$monthObj->format('F').' '.$peryear; ?></h4>
						<a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
                    </div>
                    <div class="header-elements d-none">
                        <form action="<?php echo base_url()?>smartreportdsr/statistic-dsr" method="get" accept-charset="utf-8">
                            <div class="d-flex justify-content-center">						
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
                                    <a href="<?php echo base_url('smartreportdsr/statistic_dsrpdf?date_dsr='.$dateToView);?>"><button type="button" class="btn bg-teal-400 ">Export to PDF <i class="icon-file-pdf ml-2"></i></button></a>
                                </div>
                            </div>
                        </form>
				    </div>
                </div>  
		</div>
		<!-- /page header -->                
				
		<!-- Row toggler -->
				<div class="card">
					<div class="card-header header-elements-inline">
                        <div class="col-md-12">
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
                            <!-- Quick stats boxes -->
                            <div class="row">
                                <div class="col-lg-2">

                                    <!-- Members online -->
                                    <div class="card bg-teal-600 animated flipInY">                                    
                                        <div class="card-body " >
                                            
                                            <!--<i style="color: #4DB6AC;"class="icon-cash2 tile"></i>-->
                                            <div class="d-flex">
                                                <h3 class="font-weight-semibold mb-0 " ><?php echo number_format($alltotal_today_rev,0);?></h3>
                                            </div>
                                            
                                            <div>
                                                <?php echo $lang_rev_today;?>										
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /members online -->

                                </div>

                                <div class="col-lg-3">
                                    <!-- Current server load -->
                                    <div class="card bg-success-600 animated flipInY">
                                        <div class="card-body">
                                        <i style="color: #2E7D32;"class="icon-cash2 tile"></i>
                                            <div class="d-flex">
                                                <h3 class="font-weight-semibold mb-0"><?php echo number_format($alltotal_mtd_rev,0);?></h3>											
                                            </div>
                                            <div>
                                                <?php echo $lang_mtd_rev.' '.$lang_actual;?>										
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /current server load -->

                                </div>

                                <div class="col-lg-3">
                                    <!-- Today's revenue -->
                                    <div class="card bg-info-600 animated flipInY " >
                                        <div class="card-body">
                                        <i style="color: #0097A7;" class="icon-stats-growth2 tile"></i>
                                            <div class="d-flex">
                                                <h3 class="font-weight-semibold mb-0"><?php echo number_format($alltotal_mtd_budgetbybrand,0);?></h3>											
                                            </div>					                	
                                            <div>
                                                <?php echo $lang_mtd_rev.' '.$lang_budget;?>										
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /today's revenue -->
                                </div>                           
                                
                                
                                <div class="col-lg-2">
                                    <!-- Today's revenue -->
                                    <div class="card bg-grey-700 animated flipInY">
                                        <div class="card-body">
                                            <div class="d-flex">
                                                <h3 class="font-weight-semibold mb-0"><?php echo number_format($alltotal_mtd_rev/$perdate)?></h3>
                                                
                                            </div>
                                            
                                            <div>
                                                <?php echo $lang_achv.' / Day';?>										
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /today's revenue -->
                                </div>
                                
                                <div class="col-lg-2">
                                    <!-- Today's revenue -->
                                    <div class="card bg-brown-600 animated flipInY">
                                        <div class="card-body">
                                            <div class="d-flex">
                                                <h3 class="font-weight-semibold mb-0"><?php echo number_format(($alltotal_mtd_rev/$alltotal_mtd_budgetbybrand)*100,2).'%';?></h3>											
                                            </div>
                                            
                                            <div>
                                                <?php echo $lang_achv;?>										
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /today's revenue -->
                                </div>
                            </div>
                            <!-- /quick stats boxes -->
                        </div>					
					</div>
                </div>
                <div class="row">
                    <div class="col-md-7">
                        <div class="card">
                            <div class="table-responsive animated zoomIn ">
                                <table class="table table-bordered table-togglable table-hover table-xs customEryan datatable-nobutton-1column text-nowrap" >
                                    <thead style="vertical-align: middle; text-align: center">
                                        <tr>
                                            <th rowspan="2"><?php echo $lang_hotel_name; ?></th>
                                            <th rowspan="2">Rooms</th>
                                            <th rowspan="2">R. Sold</th>
                                            <th colspan="3">Today</th>
                                            <th colspan="4">MTD</th>
                                            <th rowspan="2">%</th>
                                            
                                        </tr>
                                        <tr>
                                            <th>OCC</th>
                                            <th>ARR</th>
                                            <th>REV</th>
                                            <th>OCC</th>
                                            <th>ARR</th>
                                            <th>REV</th>
                                            <th><?php echo $lang_budget;?></th>
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
                                            <td><strong><?= $smartreport_brand->hotels_category; ?></strong></td>
                                            <td colspan="10"></td>
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
                                        <?php foreach ($smartreport_hotelbrand_data  as $smartreport_hotelbrand ){ 
                                            $dt_analystoday = $this->Smartreport_hca_model->select_competitoranalysisondate_perhotel($smartreport_hotelbrand->idhotels,$dateToView);
                                            $dt_dsrtoday = $this->Smartreport_dsr_model->select_dsrondate_perhotel($smartreport_hotelbrand->idhotels,$dateToView);
                                            
                                            $dt_trrmtd = $this->Smartreport_hca_model->select_trrmtd_perhotel($startdate_mtd,$enddate_mtd,$smartreport_hotelbrand->idhotels);                                    
                                            $dt_fnbmtd = $this->Smartreport_dsr_model->select_fnbmtd_perhotel($startdate_mtd,$enddate_mtd,$smartreport_hotelbrand->idhotels);
                                            $dt_othmtd = $this->Smartreport_dsr_model->select_othmtd_perhotel($startdate_mtd,$enddate_mtd,$smartreport_hotelbrand->idhotels);
                                            $dt_ooomtd = $this->Smartreport_dsr_model->select_outofordermtd_perhotel($startdate_mtd,$enddate_mtd,$smartreport_hotelbrand->idhotels);

                                            $budget_rooms =  $this->Smartreport_pnl_model->get_rooms_budget($smartreport_hotelbrand->idhotels, $permonth, $peryear);
                                            $budget_fnb =  $this->Smartreport_pnl_model->get_fnb_budget($smartreport_hotelbrand->idhotels, $permonth, $peryear);
                                            $budget_other =  $this->Smartreport_pnl_model->get_other_budget($smartreport_hotelbrand->idhotels,$permonth, $peryear);
                                            $budget_laundry =  $this->Smartreport_pnl_model->get_laundry_budget($smartreport_hotelbrand->idhotels, $permonth, $peryear);

                                            /* Mulai -  Hitung Room Sold*/	
                                            $rs_mtd = 0; $ri_mtd = 0;	 $arr_mtd = 0;
                                            $dt_trrmtd = $this->Smartreport_hca_model->select_trrmtd_perhotel($startdate_mtd,$enddate_mtd,$smartreport_hotelbrand->idhotels);
                                            if($dt_trrmtd != NULL)
                                            {
                                                $trr_mtd = $dt_trrmtd->TRR_MTD;
                                            }

                                            $dt_rsmtd = $this->Smartreport_hca_model->select_rsmtd_perhotel($startdate_mtd,$enddate_mtd,$smartreport_hotelbrand->idhotels);
                                            if($dt_rsmtd != NULL){
                                                $rs_mtd += $dt_rsmtd->RS_MTD;
                                            }
                                            
                                            if($dt_trrmtd != NULL && $dt_fnbmtd !=NULL && $dt_othmtd != NULL){                                        
                                                $trr_mtd = $dt_trrmtd->TRR_MTD;                                  
                                                $fnb_mtd = $dt_fnbmtd->FNB_MTD;                                    
                                                $oth_mtd = $dt_othmtd->OTH_MTD; 
                                                $ooo_mtd = $dt_ooomtd->OUTOFORDER_MTD;                                       
                                            }else{
                                                $trr_mtd = 0;
                                                $fnb_mtd = 0;
                                                $oth_mtd = 0;
                                                $ooo_mtd = 0;                                        
                                            }

                                            $ri_mtd += $smartreport_hotelbrand->total_rooms * $perdate;
                                            if($rs_mtd != 0 && $ri_mtd != 0){
                                                $occ_mtd = ($rs_mtd / ($ri_mtd-$ooo_mtd)) * 100;
                                            }else{
                                                $occ_mtd = 0;
                                            }

                                            if($rs_mtd != 0 && $rs_mtd != 0 ){
                                                $arr_mtd = $trr_mtd / $rs_mtd;
                                                
                                            }
                                            
                                            
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
                                                $outoforder_today = $dt_dsrtoday->sales_outoforder;  
                                            }else{
                                                $fnb_today = 0;
                                                $oth_today = 0; 
                                                $outoforder_today = 0;
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
                                            <td>&emsp;&emsp;<?= $smartreport_hotelbrand->hotels_name;?></td>
                                            <td class="rata-kanan"><?= $smartreport_hotelbrand->total_rooms;?></td>
                                            <td class="rata-kanan"> <?php echo  number_format($rs_today,0); ?></td>
                                            <td class="rata-kanan"><?php if ($rs_today != 0 && $smartreport_hotelbrand->total_rooms !=0){
                                                echo number_format(($rs_today/($smartreport_hotelbrand->total_rooms-$outoforder_today))*100,2).'%';
                                                } ?>
                                            </td>
                                            <td class="rata-kanan"><?php echo  number_format($arr_today,0); ?></td>
                                            <td class="rata-kanan"><?php echo number_format($tot_sales_today,0); ?></td>
                                            <td><?php echo number_format($occ_mtd,2).'%'; ?></td>
                                            <td><?php echo number_format($arr_mtd);?></td>
                                            <td class="rata-kanan"><?php echo number_format($tot_sales_mtd,0); ?></td>
                                            <td class="rata-kanan"><?php echo number_format($totalbudget_mtd,0);?></td>
                                            <td class="rata-kanan"><?php if($tot_sales_mtd != 0 && $totalbudget_mtd != 0){echo number_format(($tot_sales_mtd/$totalbudget_mtd)*100,2).'%';} ?></td>
                                        </tr>                                
                                        <?php } ?>
                                        <tr>
                                            <td><strong><?php echo "Total ".$smartreport_brand->hotels_category; ?></strong></td>
                                            <td colspan="4"></td>
                                            <td style="display: none;"></td>
                                            <td style="display: none;"></td>
                                            <td style="display: none;"></td>                                            
                                            <td class="rata-kanan"><?php  echo number_format($grandtotal_today_rev,0); ?></td>
                                            <td colspan="2"></td>
                                            <td style="display: none;"></td>
                                            <td class="rata-kanan"><?php echo number_format($grandtotal_mtd_rev,0); ?></td>
                                            <td class="rata-kanan"><?php echo number_format($grandtotal_mtd_budgetbybrand,0); ?></td>
                                            <td class="rata-kanan"><?php if($grandtotal_mtd_rev != 0 && $grandtotal_mtd_budgetbybrand != 0 ){echo number_format(($grandtotal_mtd_rev/$grandtotal_mtd_budgetbybrand)*100,2).'%';} ?></td>


                                        </tr>
                                    <?php } ?>
                                    </tbody>
                            
                                </table>
                            </div>
                        </div>  
                    </div>

                    <div class="col-md-5">
                        <div class="card ">
                            <div class="card-body">
                                <div class="chart-container animated zoomIn">
                                    <div class="chart" style="min-width: 350px; height: 500px;" id="bars_basic"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>    
                <!-- /row toggler -->
                <?php include 'statistic_dsr_graph.php';?>
				
			
