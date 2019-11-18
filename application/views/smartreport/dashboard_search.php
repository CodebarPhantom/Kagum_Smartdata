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
</script> 

<?php


							
   $date =  $dateToView;	
   $peryear = substr($dateToView,0,4);
   $permonth= substr($dateToView,5,2);
   $perdate = substr($dateToView,8,2);	

	$startdate_ytd = $peryear.'-01-'.'01';
	$enddate_ytd = $dateToView;
	$startdate_mtd = $peryear.'-'.$permonth.'-'.'01';
	$enddate_mtd = $dateToView;  

//$d=strtotime("-1 Day"); 
$graphYear = $peryear;
$graphMonth =  $permonth;
$graphDate =  $perdate;
//$graphAllDate = date('Y-m-d');

$dateDailyGraph = $peryear.'-'.$permonth.'-';
//$startdate_ytd = $graphYear.'-01-'.'01';
//$enddate_ytd =  date("Y-m-d", $d);

//$startdate_mtd = $graphYear.'-'.$graphMonth.'-'.'01';
//$enddate_mtd = date("Y-m-d"); 

$enddate_mtd = $dateToView;
$dashboardDate = $perdate;
$monthObj  = DateTime::createFromFormat('!m', $graphMonth); 

// Baris Occupancy
// room inventory
$ri_mtd = 0; $ri_ytd = 0; 
//room sold
$rs_mtd = 0; $rs_ytd=0;
//occupancy 
$occ_ytd = 0; $occ_mtd =0;

//average room rate
$arr_mtd = 0; $arr_ytd=0; $trr_ytd= 0;
//fnb
$fnb_today = 0; $fnb_mtd = 0; $fnb_ytd = 0;
//other
$oth_today = 0; $oth_mtd = 0; $oth_ytd = 0;
$dt_rsmtd = $this->Smartreport_hca_model->select_rsmtd_perhotel($startdate_mtd,$enddate_mtd,$user_ho);
$rs_mtd = $dt_rsmtd->RS_MTD;
$dt_rsytd = $this->Smartreport_hca_model->select_rsytd_perhotel($startdate_ytd,$enddate_ytd,$user_ho);
$rs_ytd += $dt_rsytd->RS_YTD;

$dt_trrmtd = $this->Smartreport_hca_model->select_trrmtd_perhotel($startdate_mtd,$enddate_mtd,$user_ho);
$trr_mtd = $dt_trrmtd->TRR_MTD;
$dt_trrytd = $this->Smartreport_hca_model->select_trrytd_perhotel($startdate_ytd,$enddate_ytd,$user_ho);
$trr_ytd = $dt_trrytd->TRR_YTD;


$ri_ytd  = $this->Smartreport_hca_model->select_RIYTD_perhotel($startdate_ytd,$enddate_ytd,$user_ho);
if($rs_ytd != 0 && $ri_ytd->RI_YTD != 0){
		$occ_ytd = ($rs_ytd / $ri_ytd->RI_YTD) * 100;
	}

//Baris Average Room Rate
if($rs_mtd != 0 && $rs_ytd != 0){
	$arr_mtd = $trr_mtd / $rs_mtd;
	
}
if($trr_ytd != 0 && $trr_ytd != 0){
$arr_ytd = $trr_ytd /$rs_ytd;
}
?>


<script src="<?php echo base_url();?>assets/backend/global_assets/js/plugins/notifications/pnotify.min.js"></script>
<script src="<?php echo base_url();?>assets/backend/global_assets/js/plugins/visualization/echarts/echarts.min.js"></script>




<!-- Page header -->
        <div class="page-header page-header-light">
				<div class="page-header-content header-elements-md-inline">
					<div class="page-title d-flex">
						<h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">Home</span> - Dashboard</h4>
						<a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
					</div>

					<div class="header-elements d-none">
						<form action="<?php echo base_url()?>smartreport/dashboard" method="post" accept-charset="utf-8">
						<div class="d-flex justify-content-center">						
							<div class="form-group">
								<div class="input-group">
									<span class="input-group-prepend">
										<span class="input-group-text"><i class="icon-calendar22"></i></span>
									</span>
									<input type="text" data-mask="99-99-9999" name="date_dashboard" class="form-control daterange-single" value="<?php echo $date_dashboard; ?>" required  />
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
			<!-- /page header -->


			<!-- Content area -->
			<div class="">
				<!-- Nightingale roses -->
				<div class="row">
					<div class="col-md-6">
						<!-- Nightingale roses (hidden labels) -->
						<div class="card">
								<div class="card-header header-elements-sm-inline">
									<h6 class="card-title">Summary</h6>								
								</div>

								<div class="card-body d-md-flex align-items-md-center justify-content-md-between flex-md-wrap">
									<div class="d-flex align-items-center mb-3 mb-md-0">
										<!--<div id="tickets-status"></div>-->
										<div class="ml-3">
											<span class="badge badge-mark border-success mr-1"></span> <span class="text-muted">
												<?php echo date($dashboardDate).' '. $monthObj->format('F').' '. $graphYear;?></span>
										</div>
									</div>

									<div class="d-flex align-items-center mb-3 mb-md-0">
										<a href="#" class="btn bg-transparent border-indigo-400 text-indigo-400 rounded-round border-2 btn-icon">
											<i class="icon-store2"></i>
										</a>
										<div class="ml-3">
											<h5 class="font-weight-semibold mb-0"><?php echo $rs_mtd;?></h5>
											<span class="text-muted">Room Sold</span>
										</div>
									</div>

									<div class="d-flex align-items-center mb-3 mb-md-0">
										<a href="#" class="btn bg-transparent border-indigo-400 text-indigo-400 rounded-round border-2 btn-icon">
											<i class="icon-cash4"></i>
										</a>
										<div class="ml-3">
											<h5 class="font-weight-semibold mb-0">Rp.<?php echo number_format($trr_mtd,0);?></h5>
											<span class="text-muted">Room Revenue This Month</span>
										</div>
									</div>
								</div>

								<div class="table-responsive"  style=" min-height: 305px;">
									<table class="table table-bordered text-nowrap customEryan">
										<thead style="vertical-align: middle; text-align: center">
											<tr>
												<th rowspan="2">Report</th>
												<th>Now</th>
												<th>MTD</th>
												<th>YTD</th>
											</tr>
											<tr>
												<th>Actual</th>											
												<th>Actual</th>											
												<th>Actual</th>												
											</tr>
										</thead>
										
										<tbody>
											
											<?php 
											
											foreach ($getHotelByUser_data->result() as $getHotelByUser){ 
												$dt_dsrtoday = $this->Smartreport_dsr_model->select_dsrondate_perhotel($getHotelByUser->idhotels,$dateToView);
												if($dt_dsrtoday != NULL){
													$fnb_today = $dt_dsrtoday->sales_fnb;
													$guest_today = $dt_dsrtoday->numberofguest;
													$oth_today = $dt_dsrtoday->sales_other;
												}?>
											<tr>										
												<td>
													<a href="#" class="text-default table-border-double">
														<div class="font-weight-300">Occupancy</div>														
													</a>
												</td>
												<td>
													<a href="#" class="text-default">
														<div class="font-weight-300">
															<?php $occDailyData = $this->Smartreport_hca_model->getDailyOccForGraphById($getHotelByUser->idhotels,$enddate_mtd);
															echo  $occDailyData->graph_OccDaily.'%';?>
														</div>														
													</a>
												</td>
												<td>
													<a href="#" class="text-default">
														<div class="font-weight-300">
															<?php $ri_mtd = $getHotelByUser->total_rooms * $dashboardDate;
																	if($rs_mtd != 0 && $ri_mtd != 0){
																		$occ_mtd = ($rs_mtd / $ri_mtd) * 100;
																	}
															echo number_format($occ_mtd,2).'%';?>
														</div>														
													</a>
												</td>
												<td>
													<a href="#" class="text-default">
														<div class="font-weight-300"><?php echo number_format($occ_ytd,2).'%'; ?></div>														
													</a>
												</td>
											</tr>

											<tr>										
												<td>
													<a href="#" class="text-default">
														<div class="font-weight-300">Average Room Rate</div>														
													</a>
												</td>
												<td>
													<a href="#" class="text-default">
														<div class="font-weight-300">
															<?php $arrDailyData = $this->Smartreport_hca_model->getDailyArrForGraphById($getHotelByUser->idhotels,$enddate_mtd);
															echo  number_format($arrDailyData->graph_ArrDaily);?>
														</div>														
													</a>
												</td>
												<td>
													<a href="#" class="text-default">
														<div class="font-weight-300">
															<?php echo  number_format($arr_mtd);?>
														</div>														
													</a>
												</td>
												<td>
													<a href="#" class="text-default">
														<div class="font-weight-300"><?php echo number_format($arr_ytd); ?></div>														
													</a>
												</td>
											</tr>

											<tr>										
												<td>
													<a href="#" class="text-default">
														<div class="font-weight-300">Room Revenue</div>														
													</a>
												</td>
												<td>
													<a href="#" class="text-default">
														<div class="font-weight-300">
															<?php $trrDailyData = $this->Smartreport_hca_model->getDailyTrrForGraphById($getHotelByUser->idhotels,$enddate_mtd);
															echo  number_format($trrDailyData->graph_TrrDaily);?>
														</div>														
													</a>
												</td>
												<td>
													<a href="#" class="text-default">
														<div class="font-weight-300">
															<?php echo  number_format($trr_mtd);?>
														</div>														
													</a>
												</td>
												<td>
													<a href="#" class="text-default">
														<div class="font-weight-300"><?php echo number_format($trr_ytd); ?></div>														
													</a>
												</td>
											</tr>

											<tr>										
												<td>
													<a href="#" class="text-default">
														<div class="font-weight-300">Food & Beverage</div>														
													</a>
												</td>
												<td>
													<a href="#" class="text-default">
														<div class="font-weight-300">
															<?php echo  number_format($fnb_today);?>
														</div>														
													</a>
												</td>
												<td>
													<a href="#" class="text-default">
														<div class="font-weight-300">
															<?php  $dt_fnbmtd = $this->Smartreport_dsr_model->select_fnbmtd_perhotel($startdate_mtd,$enddate_mtd,$user_ho);
                                   									echo $fnb_mtd = number_format($dt_fnbmtd->FNB_MTD); ?>
														</div>														
													</a>
												</td>
												<td>
													<a href="#" class="text-default">
														<div class="font-weight-300">
															<?php $dt_fnbytd = $this->Smartreport_dsr_model->select_fnbytd_perhotel($startdate_ytd,$enddate_ytd,$user_ho);                                  
                                   								   echo $fnb_ytd = number_format($dt_fnbytd->FNB_YTD); ?></div>														
													</a>
												</td>
											</tr>

											<tr>										
												<td>
													<a href="#" class="text-default">
														<div class="font-weight-300">Others</div>														
													</a>
												</td>
												<td>
													<a href="#" class="text-default">
														<div class="font-weight-300">
															<?php echo number_format($oth_today);;?>
														</div>														
													</a>
												</td>
												<td>
													<a href="#" class="text-default">
														<div class="font-weight-300">
															<?php $dt_othmtd = $this->Smartreport_dsr_model->select_othmtd_perhotel($startdate_mtd,$enddate_mtd,$user_ho);
                                    								echo $oth_mtd = number_format($dt_othmtd->OTH_MTD);?>
														</div>														
													</a>
												</td>
												<td>
													<a href="#" class="text-default">
														<div class="font-weight-300">
															<?php $dt_othytd = $this->Smartreport_dsr_model->select_othytd_perhotel($startdate_ytd,$enddate_ytd,$user_ho);                                  
                                   									echo $oth_ytd = number_format($dt_othytd->OTH_YTD); ?></div>														
													</a>
												</td>
											</tr>
											<?php } ?>
										</tbody>
										
									</table>
								</div>
							</div>
						<!-- /nightingale roses (hidden labels) -->

					</div>

					<div class="col-md-6">

						<!-- Nightingale roses (hidden labels) -->
						<div class="card">
							

							<div class="card-body">
								<div class="chart-container">
									<div class="chart" style="min-width: 250px; height: 400px;" id="mpi_MTD"></div>
								</div>
							</div>
						</div>
						<!-- /nightingale roses (hidden labels) -->

					</div>
				</div>
				<!-- /nightingale roses -->
				<!-- Basic columns -->
				<div class="card">
					

					<div class="card-body">
						<div class="chart-container">
							<div class="chart" style="min-width: 350px; height: 400px;" id="occDaily"></div>
						</div>
					</div>
				</div>


				<div class="card">
					

					<div class="card-body">
						<div class="chart-container">
							<div class="chart" style="min-width: 350px; height: 400px;" id="arrDaily"></div>
						</div>
					</div>
				</div>

				<div class="card">
					

					<div class="card-body">
						<div class="chart-container">
							<div class="chart" style="min-width: 350px; height: 400px;" id="revparDaily"></div>
						</div>
					</div>
				</div>
				<!-- /basic columns -->



				<!-- Dashboard content -->
				
				<!-- /dashboard content -->

			</div>
			<!-- /content area -->
			<?php include 'graph.php';?>