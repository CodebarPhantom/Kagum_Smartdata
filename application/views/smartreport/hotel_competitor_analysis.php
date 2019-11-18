<style>
.form-control:focus {

  box-shadow: inset 1px 2px 4px rgba(0, 0, 0, 0.01), 0px 0px 8px rgba(0, 0, 0, 0.2);
}

.customEryan{
	font-size: 9px;
	width: 100%;  
}

.customstarsize{
	font-size:0.75em;
}
.hidden{
	display: none !important;
}

.header-print {
    display: table-header-group;
  }

</style>

<script src="<?php echo base_url();?>assets/backend/global_assets/js/plugins/tables/datatables/datatables.min.js"></script>
<script src="<?php echo base_url();?>assets/backend/global_assets/js/plugins/tables/datatables/extensions/fixed_columns.min.js"></script>

<script src="<?php echo base_url();?>assets/backend/global_assets/js/plugins/tables/datatables/extensions/jszip/jszip.min.js"></script>
<!--<script src="<?php //echo base_url();?>assets/backend/global_assets/js/plugins/tables/datatables/extensions/buttons.min.js"></script>-->

<!-- Begin Datatables External khuhus untuk buat multi header -->
<script src="<?php echo base_url();?>assets/backend/global_assets/js/plugins/tables/datatables/extensions/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url();?>assets/backend/global_assets/js/plugins/tables/datatables/extensions/buttons.print.min.js"></script>
<script src="<?php echo base_url();?>assets/backend/global_assets/js/plugins/tables/datatables/extensions/buttons.html5.min.js"></script>
<!-- END Datatables External khuhus untuk buat multi header -->

<script src="<?php echo base_url();?>assets/backend/global_assets/js/demo_pages/datatables_extension_fixed_columns.js"></script>



<script type="text/javascript">
	   $(document).ready(function(){  	
	
        $('.daterange-single').daterangepicker({ 
            singleDatePicker: true,
            locale: {
                format: 'DD-MM-YYYY'
            }
        });
		$('.custom_category').select2({
			//minimumInputLength: 3
		});
		$('.custom_city').select2();		
	});
</script> 
<?php
   $url_city = '';
   $url_date = '';
   $url_city = $city;
   $url_date = $date_analysis;
   									
   $date =  $dateToView;	
   $peryear = substr($dateToView,0,4);
   $permonth= substr($dateToView,5,2);
   $perdate = substr($dateToView,8,2);	

	$startdate_ytd = $peryear.'-01-'.'01';
	$enddate_ytd = $dateToView;
	$startdate_mtd = $peryear.'-'.$permonth.'-'.'01';
	$enddate_mtd = $dateToView;   
	//Total avg room rate diambil dari setiap model perbintang
	//Total occupany diambil dari setiap model perbintang 	
	// Total room inventory tahunan diambil daro model perbitnang
	$total_ri_today4star = 0;
	$total_ri_mtd4star = 0;
	$total_ri_today3star = 0;
	$total_ri_mtd3star = 0;
	$total_ri_today2star = 0;
	$total_ri_mtd2star = 0;
	$total_ri_todaybyuser = 0;
	$total_ri_mtdbyuser = 0;

	//room sold
	$total_rs_today4star = 0;
	$total_rs_mtd4star = 0;
	$total_rs_ytd4star = 0;
	$total_rs_today3star = 0;
	$total_rs_mtd3star = 0;
	$total_rs_ytd3star = 0;
	$total_rs_today2star = 0;
	$total_rs_mtd2star = 0;
	$total_rs_ytd2star = 0;
	$total_rs_todaybyuser = 0;
	$total_rs_mtdbyuser = 0;
	$total_rs_ytdbyuser = 0;

	//total room revenue
	$total_trr_today4star = 0;
	$total_trr_mtd4star = 0;
	$total_trr_ytd4star = 0;
	$total_trr_today3star = 0;
	$total_trr_mtd3star = 0;
	$total_trr_ytd3star = 0;
	$total_trr_today2star = 0;
	$total_trr_mtd2star = 0;
	$total_trr_ytd2star = 0;
	$total_trr_todaybyuser = 0;
	$total_trr_mtdbyuser = 0;
	$total_trr_ytdbyuser = 0;

	// total revpar
	$total_rvr_today4star = 0;
	$total_rvr_mtd4star = 0;
	$total_rvr_ytd4star = 0;	
	$total_rvr_today3star = 0;
	$total_rvr_mtd3star = 0;
	$total_rvr_ytd3star = 0;
	$total_rvr_today2star = 0;
	$total_rvr_mtd2star = 0;
	$total_rvr_ytd2star = 0;	
	$total_rvr_todaybyuser = 0;
	$total_rvr_mtdbyuser = 0;
	$total_rvr_ytdbyuser = 0;									

	
	/* Untuk Occupany pembagi  MPI ARI RGI perhotel ga bisa dari looping @_@ Hadeeh*/
	$data_occToday4StarTotal = $this->Smartreport_hca_model->getOccTodayAllStar($date, $city, "4");
	$data_occMTD4StarTotal = $this->Smartreport_hca_model->getOccMTDAllStar($startdate_mtd, $enddate_mtd, $city, "4");
	$data_occYTD4StarTotal = $this->Smartreport_hca_model->getOccYTDAllStar($startdate_ytd, $enddate_ytd, $city, "4");
	$data_trrToday4StarTotal = $this->Smartreport_hca_model->getTrrTodayAllStar($date, $city, "4");
	$data_trrMTD4StarTotal = $this->Smartreport_hca_model->getTrrMTDAllStar($startdate_mtd, $enddate_mtd, $city, "4");
	$data_trrYTD4StarTotal = $this->Smartreport_hca_model->getTrrYTDAllStar($startdate_ytd, $enddate_ytd, $city, "4");	
	$data_arrToday4StarTotal = $this->Smartreport_hca_model->getArrTodayAllStar($date, $city , "4");
	$data_arrMTD4StarTotal = $this->Smartreport_hca_model->getArrMTDAllStar($startdate_mtd, $enddate_mtd, $city, "4");
	$data_arrYTD4StarTotal = $this->Smartreport_hca_model->getArrYTDAllStar($startdate_ytd, $enddate_ytd, $city, "4");
	$data_riYTD4StarTotal = $this->Smartreport_hca_model->getRIYTDAllStar($startdate_ytd, $enddate_ytd, $city, "4");

	$data_occToday3StarTotal = $this->Smartreport_hca_model->getOccTodayAllStar($date, $city, "3");
	$data_occMTD3StarTotal = $this->Smartreport_hca_model->getOccMTDAllStar($startdate_mtd, $enddate_mtd, $city, "3");
	$data_occYTD3StarTotal = $this->Smartreport_hca_model->getOccYTDAllStar($startdate_ytd, $enddate_ytd, $city, "3");
	$data_trrToday3StarTotal = $this->Smartreport_hca_model->getTrrTodayAllStar($date, $city, "3");
	$data_trrMTD3StarTotal = $this->Smartreport_hca_model->getTrrMTDAllStar($startdate_mtd, $enddate_mtd, $city, "3");
	$data_trrYTD3StarTotal = $this->Smartreport_hca_model->getTrrYTDAllStar($startdate_ytd, $enddate_ytd, $city, "3");	
	$data_arrToday3StarTotal = $this->Smartreport_hca_model->getArrTodayAllStar($date, $city , "3");
	$data_arrMTD3StarTotal = $this->Smartreport_hca_model->getArrMTDAllStar($startdate_mtd, $enddate_mtd, $city, "3");
	$data_arrYTD3StarTotal = $this->Smartreport_hca_model->getArrYTDAllStar($startdate_ytd, $enddate_ytd, $city, "3");
	$data_riYTD3StarTotal = $this->Smartreport_hca_model->getRIYTDAllStar($startdate_ytd, $enddate_ytd, $city, "3");

	$data_occToday2StarTotal = $this->Smartreport_hca_model->getOccTodayAllStar($date, $city, "2");
	$data_occMTD2StarTotal = $this->Smartreport_hca_model->getOccMTDAllStar($startdate_mtd, $enddate_mtd, $city, "2");
	$data_occYTD2StarTotal = $this->Smartreport_hca_model->getOccYTDAllStar($startdate_ytd, $enddate_ytd, $city, "2");
	$data_trrToday2StarTotal = $this->Smartreport_hca_model->getTrrTodayAllStar($date, $city, "2");
	$data_trrMTD2StarTotal = $this->Smartreport_hca_model->getTrrMTDAllStar($startdate_mtd, $enddate_mtd, $city, "2");
	$data_trrYTD2StarTotal = $this->Smartreport_hca_model->getTrrYTDAllStar($startdate_ytd, $enddate_ytd, $city, "2");	
	$data_arrToday2StarTotal = $this->Smartreport_hca_model->getArrTodayAllStar($date, $city , "2");
	$data_arrMTD2StarTotal = $this->Smartreport_hca_model->getArrMTDAllStar($startdate_mtd, $enddate_mtd, $city, "2");
	$data_arrYTD2StarTotal = $this->Smartreport_hca_model->getArrYTDAllStar($startdate_ytd, $enddate_ytd, $city, "2");
	$data_riYTD2StarTotal = $this->Smartreport_hca_model->getRIYTDAllStar($startdate_ytd, $enddate_ytd, $city, "2");
	
	
	
	$data_occTodayByUserTotal = $this->Smartreport_hca_model->getOccTodayByUser($date, $user_ho); //ok
	$data_occMTDByUserTotal = $this->Smartreport_hca_model->getOccMTDByUser($startdate_mtd, $enddate_mtd, $user_ho); //ok
	$data_occYTDByUserTotal = $this->Smartreport_hca_model->getOccYTDByUser($startdate_ytd, $enddate_ytd, $user_ho); //ok
	$data_trrTodayByUserTotal = $this->Smartreport_hca_model->getTrrTodayByUser($date, $user_ho); //ok
	$data_trrMTDByUserTotal = $this->Smartreport_hca_model->getTrrMTDByUser($startdate_mtd, $enddate_mtd, $user_ho); //ok
	$data_trrYTDByUserTotal = $this->Smartreport_hca_model->getTrrYTDByUser($startdate_ytd, $enddate_ytd, $user_ho);	//ok
	$data_arrTodayByUserTotal = $this->Smartreport_hca_model->getArrTodayByUser($date, $user_ho); //ok
	$data_arrMTDByUserTotal = $this->Smartreport_hca_model->getArrMTDByUser($startdate_mtd, $enddate_mtd, $user_ho); //ok
	$data_arrYTDByUserTotal = $this->Smartreport_hca_model->getArrYTDByUser($startdate_ytd, $enddate_ytd, $user_ho); //ok
	$data_riYTDByUserTotal = $this->Smartreport_hca_model->getRIYTDByUser($startdate_ytd, $enddate_ytd, $user_ho); // ok 
	

?>
<!-- Page header -->
        <div class="page-header page-header-light">
				<div class="page-header-content header-elements-md-inline">
					<div class="page-title d-flex">
						<h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold"><?php echo $lang_analysis; ?></span> - <?php echo $lang_hotel_comp_anl; ?></h4>
						<a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
					</div>

					<div class="header-elements d-none">
						
					</div>
				</div>
			</div>
			<!-- /page header -->


			<!-- Content area -->
			<div class="card">
				<div class="card-header header-elements-inline">
					<h6 class="card-title"><strong><?php  $hotel = $this->Dashboard_model->getDataHotel($user_ho); echo $hotel->hotels_name .' - '.$lang_hotel_comp_anl; ?></strong></h6>
					<div class="header-elements">
						<div class="list-icons">
				            <a class="list-icons-item" data-action="collapse"></a>
				            
				        </div>
			        </div>
				</div>

				<div class="card-body">
					<ul class="nav nav-tabs nav-tabs-highlight justify-content-end">
						<li class="nav-item"><a href="#right-hca1" class="nav-link <?php if ($tab === 'hca1' || $tab === NULL){ echo "active"; } ?>" data-toggle="tab"><i class="icon-table2 mr-2"></i><?php echo $lang_view_data_all;?></a></li>
						<li class="nav-item"><a href="#right-hca2" class="nav-link <?php if ($tab === 'hca2'){ echo "active"; } ?>" data-toggle="tab"><i class="icon-table2 mr-2"></i><?php echo $lang_view_data;?></a></li>
						<li class="nav-item"><a href="#right-hca3" class="nav-link" data-toggle="tab"><i class="icon-stack-plus mr-2"></i><?php echo $lang_add_data?></a></li>
						<li class="nav-item"><a href="#right-hca4" class="nav-link" data-toggle="tab"><i class="icon-plus3 mr-2"></i><?php echo $lang_add_data_byhotel?></a></li>				
					</ul>

				    <div class="tab-content">
						<div class="tab-pane fade <?php if ($tab === 'hca1' || $tab === NULL){ echo "show active"; } ?> " id="right-hca1">
							<div class="col-md-12">
								<form action="<?php echo base_url()?>smartreport/hotel-competitor-analysis" method="get" accept-charset="utf-8">
								<input type="hidden" name = "tab" value="hca1">							
								<div class="row">
									<div class="col-md-2">
										<div class="form-group">
											<label><?php echo $lang_date; ?></label>
											<div class="input-group">
													<span class="input-group-prepend">
														<span class="input-group-text"><i class="icon-calendar22"></i></span>
													</span>
													<input type="text" data-mask="99-99-9999" name="date_analysis"  class="form-control daterange-single" value="<?php echo $date_analysis; ?>" required  />
											</div>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
										<label><?php echo $lang_city; ?></label>
											<select name="city" class="form-control custom_city" required autocomplete="off">
													<option value><?php echo $lang_choose_city; ?></option>
												<?php
													$cityData = $this->Smartreport_hotels_model->getDataAll('smartreport_city', 'idcity', 'ASC');
													for ($p = 0; $p < count($cityData); ++$p) {
														$idcity = $cityData[$p]->idcity;
														$cityname = $cityData[$p]->city_name;?>
														<option  value="<?php echo $idcity; ?>" <?php if ($url_city == $idcity) {
														echo 'selected="selected"';
														} ?>>
															<?php echo $cityname; ?>
														</option>
												<?php
														unset($idcity);
														unset($cityname);
													}
												?>
											</select>
										</div>   
										 
									</div>	
									
									<div class="col-md-1">
										<div class="form-group">
											<label>&emsp; &emsp; &emsp;</label><br/>
											<button type="submit" class="btn bg-teal-400 "><?php echo $lang_search; ?></button>
										</div>
									</div>
									<?php if ($tab === "hca1"){ ?>
									<div class="col-md-2">
										<div class="form-group">
											<label>&emsp; &emsp; &emsp;</label><br/>
											<button type="button" id="ExportReporttoExcel" class="btn bg-teal-400 ">Export to XLSX <i class="icon-file-excel ml-2"></i></button>
										</div>
									</div>
									<?php } ?>

								</div>
								</form>	
							</div>

							<?php if($tab === "hca1"){ ?>	
							<div class="table-responsive">
								<table class="table table-bordered text-nowrap table-hover customEryan datatable-fixed-complex">
									<thead>
										<tr style="vertical-align: middle; text-align: center">
											<th rowspan="2">Hotel Name</th>
											<th rowspan="2">R. Inv</th>
											<th colspan="3">Room Sold</th>
											<th colspan="3">Occupancy</th>
											<th colspan="3">ARR</th>
											<th colspan="3">Total Room Revenue</th>
											<th colspan="3">RevPar</th>
											<th colspan="3">MPI</th>
											<th colspan="3">ARI</th>
											<th colspan="3">RGI</th>
											<th rowspan="2">Group Last Night</th>
										</tr>
										<tr style="vertical-align: middle; text-align: center">
											<th>NOW</th>
											<th>MTD</th>
											<th>YTD</th>

											<th>NOW(%)</th>
											<th>MTD(%)</th>
											<th>YTD(%)</th>

											<th>NOW</th>
											<th>MTD</th>
											<th>YTD</th>

											<th>NOW</th>
											<th>MTD</th>
											<th>YTD</th>

											<th>NOW</th>
											<th>MTD</th>
											<th>YTD</th>

											<th>NOW</th>
											<th>MTD</th>
											<th>YTD</th>

											<th>NOW</th>
											<th>MTD</th>
											<th>YTD</th>

											<th>NOW</th>
											<th>MTD</th>
											<th>YTD</th>
										</tr>
									</thead>
									<tbody>								
									<?php foreach ($getHotel4Star_data->result() as $getHotel4Star){ /*Looping nama Hotel bintang 4 dan kamarnya*/ 										
										//room inventory		
										$ri_today = 0;$ri_mtd = 0;$ri_ytd = 0;
										//room sold
										$rs_today = 0;$rs_mtd = 0;$rs_ytd = 0;
										//avg room rate
										$arr_today = 0;$arr_mtd = 0;$arr_ytd = 0;
										//occupany
										$occ_today = 0;$occ_mtd = 0;$occ_ytd = 0;
										//total room revenue
										$trr_today = 0;$trr_mtd = 0;$trr_ytd = 0;								
										//Rev Par
										$rvr_today = 0;$rvr_mtd = 0;$rvr_ytd = 0;
										//MPI
										$mpi_today = 0;$mpi_mtd = 0;$mpi_ytd = 0;
										//RGI
										$rgi_today = 0;$rgi_mtd = 0;$rgi_ytd = 0;
										//ARI
										$ari_today = 0;$ari_mtd = 0;$ari_ytd = 0;

										$group_ln = "";

										/* $dateToView its GET from controller hotel_competitor_analysis */										
										$dt_analystoday = $this->Smartreport_hca_model->select_competitoranalysisondate_perhotel($getHotel4Star->idhotels,$dateToView);
										if($dt_analystoday != NULL){
											$rs_today = $dt_analystoday->room_sold;
											$arr_today = $dt_analystoday->avg_roomrate;
											$group_ln = $dt_analystoday->remark;
										}

										/* Mulai -  Hitung Room Sold*/										
										$dt_rsmtd = $this->Smartreport_hca_model->select_rsmtd_perhotel($startdate_mtd,$enddate_mtd,$getHotel4Star->idhotels);
										if($dt_rsmtd != NULL)
										{
											$rs_mtd += $dt_rsmtd->RS_MTD;
										}

										
										$dt_rsytd = $this->Smartreport_hca_model->select_rsytd_perhotel($startdate_ytd,$enddate_ytd,$getHotel4Star->idhotels);
										if($dt_rsytd != NULL)
										{
											$rs_ytd += $dt_rsytd->RS_YTD;
										}
										/* Selesai -  Hitung Room Sold*/

										/* Mulai -  Hitung Total Room Revenue*/
										$trr_today = $rs_today * $arr_today;

										$dt_trrmtd = $this->Smartreport_hca_model->select_trrmtd_perhotel($startdate_mtd,$enddate_mtd,$getHotel4Star->idhotels);
										if($dt_trrmtd != NULL)
										{
											$trr_mtd = $dt_trrmtd->TRR_MTD;
										}
				
										$dt_trrytd = $this->Smartreport_hca_model->select_trrytd_perhotel($startdate_ytd,$enddate_ytd,$getHotel4Star->idhotels);
										if($dt_trrytd != NULL)
										{
											 $trr_ytd = $dt_trrytd->TRR_YTD;
										}
										/* Selesai -  Hitung Total Room Revenue*/

										/* Mulai -  Hitung Average Room Rate MTD - YTD*/
										if($rs_mtd != 0 && $rs_ytd != 0 ){
											$arr_mtd = $trr_mtd / $rs_mtd;
											
										}

										if($trr_ytd != 0 && $trr_ytd != 0){
											$arr_ytd = $trr_ytd /$rs_ytd;
										}
										/* Selesai -  Hitung Average Room Rate*/

										/* Mulai -  Occupancy*/
										$ri_today += $getHotel4Star->total_rooms;
										$ri_mtd += $getHotel4Star->total_rooms * $perdate;
										$ri_ytd = $this->Smartreport_hca_model->select_RIYTD_perhotel($startdate_ytd,$enddate_ytd,$getHotel4Star->idhotels);

										if($rs_today != 0 && $ri_today !=0){
											$occ_today = ($rs_today / $ri_today) * 100;
										}
										if($rs_mtd != 0 && $ri_mtd != 0){
											$occ_mtd = ($rs_mtd / $ri_mtd) * 100;
										}
										if($rs_ytd != 0 && $ri_ytd->RI_YTD != 0)
										{
											$occ_ytd = ($rs_ytd / $ri_ytd->RI_YTD) * 100;
										}
										/* Selesai -  Occupancy*/

										/* Mulai -  Rev Par*/
										if($trr_today != 0 && $ri_today !=0){
											$rvr_today = $trr_today / $ri_today;
										}
										if($trr_mtd != 0 && $ri_mtd !=0){
											$rvr_mtd = $trr_mtd / $ri_mtd;
										}
										if($trr_ytd != 0 && $ri_ytd->RI_YTD != 0){
											$rvr_ytd = $trr_ytd / $ri_ytd->RI_YTD;
										}
										/* Selesai -  Rev Par*/

										$total_ri_today4star += $getHotel4Star->total_rooms;
										$total_ri_mtd4star += $getHotel4Star->total_rooms * $perdate;

										$total_rs_today4star += $rs_today;
										$total_rs_mtd4star += $rs_mtd;
										$total_rs_ytd4star += $rs_ytd;

									

										$total_trr_today4star += $trr_today;
										$total_trr_mtd4star += $trr_mtd;
										$total_trr_ytd4star += $trr_ytd;




										if($occ_today != 0 ){
											$mpi_today = ($rs_today / $ri_today) / $data_occToday4StarTotal->OCC_TODAYAllStar ;
										}
										if($occ_mtd != 0 && $total_rs_mtd4star !=0 ){
											$mpi_mtd = ($rs_mtd / $ri_mtd) / $data_occMTD4StarTotal->OCC_MTDAllStar;
										}
										if($occ_ytd != 0 ){
											$mpi_ytd = ($rs_ytd / $ri_ytd->RI_YTD) / $data_occYTD4StarTotal->OCC_YTDAllStar;
										}

										if($arr_today !=0  ){
											$ari_today = $arr_today / $data_arrToday4StarTotal->ARR_TodayAllStar;
										}

										if ($arr_mtd != 0 ){
											$ari_mtd = $arr_mtd / $data_arrMTD4StarTotal->ARR_MTDAllStar;
										}

										if($arr_ytd != 0 ){
											$ari_ytd = $arr_ytd / $data_arrYTD4StarTotal->ARR_YTDAllStar;
										}

										

										if($occ_today != 0 ){
											$rgi_today = ($rs_today / $ri_today) / $data_occToday4StarTotal->OCC_TODAYAllStar ;
										}

										if ($trr_today != 0 && $data_trrToday4StarTotal->TRR_TodayAllStar != 0){
											$rgi_today = $trr_today / $data_trrToday4StarTotal->TRR_TodayAllStar;
										}

										if ($trr_mtd != 0 && $data_trrMTD4StarTotal->TRR_MTDAllStar != 0){
											$rgi_mtd = $trr_mtd  / $data_trrMTD4StarTotal->TRR_MTDAllStar;
										}

										if ($trr_ytd != 0 && $data_trrYTD4StarTotal->TRR_YTDAllStar != 0){
											$rgi_ytd = $trr_ytd  / $data_trrYTD4StarTotal->TRR_YTDAllStar;
										}
										
										
										
										
										if($total_trr_today4star != 0 && $total_ri_today4star != 0){
											$total_rvr_today4star = $total_trr_today4star/$total_ri_today4star;
										}
										if($total_trr_mtd4star !=0 && $total_ri_mtd4star !=0){
											$total_rvr_mtd4star = $total_trr_mtd4star/$total_ri_mtd4star;
										}
										if($data_trrYTD4StarTotal->TRR_YTDAllStar != 0 && $data_riYTD4StarTotal->RI_YTDAllStar !=0){
											$total_rvr_ytd4star = $data_trrYTD4StarTotal->TRR_YTDAllStar / $data_riYTD4StarTotal->RI_YTDAllStar;
										}

										?>			
										<tr>
											<!-- Hotel and Room Inventory -->
											<td><?= $getHotel4Star->hotels_name;?>	
												<br/>										
												<span>
													<i class="icon-star-full2 customstarsize text-warning-300"></i>
													<i class="icon-star-full2 customstarsize text-warning-300"></i>
													<i class="icon-star-full2 customstarsize text-warning-300"></i>
													<i class="icon-star-full2 customstarsize text-warning-300"></i>
												</span>
											</td>
											<td><?= number_format($getHotel4Star->total_rooms);?></td>

											<!-- Room Sold -->
											<td><?php echo number_format($rs_today); ?></td>
											<td><?php echo number_format($rs_mtd); ?></td>										
											<td><?php echo number_format($rs_ytd); ?></td>

											<!-- Occupancy -->
											<td><?php echo number_format($occ_today,1).'%'; ?></td>
											<td><?php echo number_format($occ_mtd,2).'%'; ?></td>
											<td><?php echo number_format($occ_ytd,2).'%'; ?></td>

											<!-- Average Room Rate -->
											<td><?php echo number_format($arr_today,0); ?></td>
											<td><?php echo number_format($arr_mtd,0);?></td>
											<td><?php echo number_format($arr_ytd,0);?></td>

											<!-- Total Room Revenue -->
											<td><?php echo number_format($trr_today); ?></td>
											<td><?php echo number_format($trr_mtd); ?></td>
											<td><?php echo number_format($trr_ytd); ?></td>

											<!-- Rev Par -->
											<td><?php echo number_format($rvr_today);?></td>
											<td><?php echo number_format($rvr_mtd);?></td>
											<td><?php echo number_format($rvr_ytd);?></td>

											<!-- MPI -->
											<td><?php echo number_format($mpi_today,2); ?></td>
											<td><?php echo number_format($mpi_mtd,2); ?></td>
											<td><?php echo number_format($mpi_ytd,2); ?></td>

											<!-- ARI -->
											<td><?php echo number_format($ari_today,2); ?></td>
											<td><?php echo number_format($ari_mtd,2); ?></td>
											<td><?php echo number_format($ari_ytd,2); ?></td>

											<!-- RGI -->
											<td><?php echo number_format($rgi_today,2); ?></td>
											<td><?php echo number_format($rgi_mtd,2); ?></td>
											<td><?php echo number_format($rgi_ytd,2); ?></td>

											<td><?php 
												echo $group_ln
											 ?></td>

											
										</tr>

										
										
									<?php } ?>
									<tr style="font-weight:bold"> <!-- Baris Total untuk bintang 4 -->
											<!-- Hotel and Room Inventory -->
											<td>Total - 4 Stars Hotels</td>
											<td><?php echo number_format($total_ri_today4star); ?></td>

											<!-- Room Sold -->
											<td><?php echo number_format($total_rs_today4star); ?></td>
											<td><?php echo number_format($total_rs_mtd4star); ?></td>										
											<td><?php echo number_format($total_rs_ytd4star); ?></td>

											<!-- Occupancy -->
											
											<td><?php echo number_format($data_occToday4StarTotal->OCC_TODAYAllStar*100,1).'%'; ?></td>
											<td><?php echo number_format($data_occMTD4StarTotal->OCC_MTDAllStar*100,2).'%'; ?></td>
											<td><?php echo number_format($data_occYTD4StarTotal->OCC_YTDAllStar*100,2).'%'; ?></td>

											<!-- Average Room Rate -->
											<td><?php echo number_format($data_arrToday4StarTotal->ARR_TodayAllStar,0); ?></td>
											<td><?php echo number_format($data_arrMTD4StarTotal->ARR_MTDAllStar,0);?></td>
											<td><?php echo number_format($data_arrYTD4StarTotal->ARR_YTDAllStar,0); ?></td>

											<!-- Total Room Revenue -->
											<td><?php echo number_format($data_trrToday4StarTotal->TRR_TodayAllStar,0); ?></td>
											<td><?php echo number_format($data_trrMTD4StarTotal->TRR_MTDAllStar,0); ?></td>
											<td><?php echo number_format($data_trrYTD4StarTotal->TRR_YTDAllStar,0); ?></td>

											<!-- Rev Par -->
											<td><?php echo number_format($total_rvr_today4star); ?></td>
											<td><?php echo number_format($total_rvr_mtd4star); ?></td>
											<td><?php echo number_format($total_rvr_ytd4star); ?></td>

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
									<tr>
											<td style="display: none; "></td>
											<td colspan="27"></td>
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
											<td style="display: none;"></td>
											<td style="display: none;"></td>
											<td style="display: none;"></td>
											<td style="display: none;"></td>
											<td style="display: none;"></td>
									</tr>
									
									<?php foreach ($getHotel3Star_data->result() as $getHotel3Star){ /*Looping nama Hotel bintang 3 dan kamarnya*/
										//room inventory		
										$ri_today = 0;$ri_mtd = 0;$ri_ytd = 0;
										//room sold
										$rs_today = 0;$rs_mtd = 0;$rs_ytd = 0;
										//avg room rate
										$arr_today = 0;$arr_mtd = 0;$arr_ytd = 0;
										//occupany
										$occ_today = 0;$occ_mtd = 0;$occ_ytd = 0;
										//total room revenue
										$trr_today = 0;$trr_mtd = 0;$trr_ytd = 0;								
										//Rev Par
										$rvr_today = 0;$rvr_mtd = 0;$rvr_ytd = 0;
										//MPI
										$mpi_today = 0;$mpi_mtd = 0;$mpi_ytd = 0;
										//RGI
										$rgi_today = 0;$rgi_mtd = 0;$rgi_ytd = 0;
										//ARI
										$ari_today = 0;$ari_mtd = 0;$ari_ytd = 0;
										$group_ln = "";

										/* $dateToView its GET from controller hotel_competitor_analysis */										
										$dt_analystoday = $this->Smartreport_hca_model->select_competitoranalysisondate_perhotel($getHotel3Star->idhotels,$dateToView);
										if($dt_analystoday != NULL){
											$rs_today = $dt_analystoday->room_sold;
											$arr_today = $dt_analystoday->avg_roomrate;
											$group_ln = $dt_analystoday->remark;
										}

										/* Mulai -  Hitung Room Sold*/										
										$dt_rsmtd = $this->Smartreport_hca_model->select_rsmtd_perhotel($startdate_mtd,$enddate_mtd,$getHotel3Star->idhotels);
										if($dt_rsmtd != NULL)
										{
											$rs_mtd += $dt_rsmtd->RS_MTD;
										}

										
										$dt_rsytd = $this->Smartreport_hca_model->select_rsytd_perhotel($startdate_ytd,$enddate_ytd,$getHotel3Star->idhotels);
										if($dt_rsytd != NULL)
										{
											$rs_ytd += $dt_rsytd->RS_YTD;
										}
										/* Selesai -  Hitung Room Sold*/

										/* Mulai -  Hitung Total Room Revenue*/
										$trr_today = $rs_today * $arr_today;

										$dt_trrmtd = $this->Smartreport_hca_model->select_trrmtd_perhotel($startdate_mtd,$enddate_mtd,$getHotel3Star->idhotels);
										if($dt_trrmtd != NULL)
										{
											$trr_mtd = $dt_trrmtd->TRR_MTD;
										}
				
										$dt_trrytd = $this->Smartreport_hca_model->select_trrytd_perhotel($startdate_ytd,$enddate_ytd,$getHotel3Star->idhotels);
										if($dt_trrytd != NULL)
										{
											 $trr_ytd = $dt_trrytd->TRR_YTD;
										}
										/* Selesai -  Hitung Total Room Revenue*/

										/* Mulai -  Hitung Average Room Rate MTD - YTD*/
										if($rs_mtd != 0 && $rs_ytd != 0) {
											$arr_mtd = $trr_mtd / $rs_mtd;
											
										}

										if($trr_ytd != 0 && $trr_ytd != 0){
											$arr_ytd = $trr_ytd /$rs_ytd;
										}
										/* Selesai -  Hitung Average Room Rate*/

										/* Mulai -  Occupancy*/
										$ri_today += $getHotel3Star->total_rooms;
										$ri_mtd += $getHotel3Star->total_rooms * $perdate;
										$ri_ytd = $this->Smartreport_hca_model->select_RIYTD_perhotel($startdate_ytd,$enddate_ytd,$getHotel3Star->idhotels);

										if($rs_today != 0 && $ri_today !=0){
											$occ_today = ($rs_today / $ri_today) * 100;
										}
										if($rs_mtd != 0 && $ri_mtd != 0)
										{
											$occ_mtd = ($rs_mtd / $ri_mtd) * 100;
										}
										if($rs_ytd != 0 && $ri_ytd->RI_YTD != 0)
										{
											$occ_ytd = ($rs_ytd / $ri_ytd->RI_YTD) * 100;
										}
										/* Selesai -  Occupancy*/

										/* Mulai -  Rev Par*/
										if($trr_today != 0 && $ri_today !=0){
											$rvr_today = $trr_today / $ri_today;
										}
										if($trr_mtd != 0 && $ri_mtd !=0){
											$rvr_mtd = $trr_mtd / $ri_mtd;
										}
										if($trr_ytd != 0 && $ri_ytd->RI_YTD != 0){
											$rvr_ytd = $trr_ytd / $ri_ytd->RI_YTD;
										}
										/* Selesai -  Rev Par*/

										$total_ri_today3star += $getHotel3Star->total_rooms;
										$total_ri_mtd3star += $getHotel3Star->total_rooms * $perdate;

										$total_rs_today3star += $rs_today;
										$total_rs_mtd3star += $rs_mtd;
										$total_rs_ytd3star += $rs_ytd;

									

										$total_trr_today3star += $trr_today;
										$total_trr_mtd3star += $trr_mtd;
										$total_trr_ytd3star += $trr_ytd;




										if($occ_today != 0 ){
											$mpi_today = ($rs_today / $ri_today) / $data_occToday3StarTotal->OCC_TODAYAllStar ;
										}
										if($occ_mtd != 0 && $total_rs_mtd3star !=0 ){
											$mpi_mtd = ($rs_mtd / $ri_mtd) / $data_occMTD3StarTotal->OCC_MTDAllStar;
										}
										if($occ_ytd != 0 ){
											$mpi_ytd = ($rs_ytd / $ri_ytd->RI_YTD) / $data_occYTD3StarTotal->OCC_YTDAllStar;
										}

										if($arr_today !=0  ){
											$ari_today = $arr_today / $data_arrToday3StarTotal->ARR_TodayAllStar;
										}

										if ($arr_mtd != 0 ){
											$ari_mtd = $arr_mtd / $data_arrMTD3StarTotal->ARR_MTDAllStar;
										}

										if($arr_ytd != 0 ){
											$ari_ytd = $arr_ytd / $data_arrYTD3StarTotal->ARR_YTDAllStar;
										}

										

										if($occ_today != 0 ){
											$rgi_today = ($rs_today / $ri_today) / $data_occToday3StarTotal->OCC_TODAYAllStar ;
										}

										if ($trr_today != 0 && $data_trrToday3StarTotal->TRR_TodayAllStar != 0){
											$rgi_today = $trr_today / $data_trrToday3StarTotal->TRR_TodayAllStar;
										}

										if ($trr_mtd != 0 && $data_trrMTD3StarTotal->TRR_MTDAllStar != 0){
											$rgi_mtd = $trr_mtd  / $data_trrMTD3StarTotal->TRR_MTDAllStar;
										}

										if ($trr_ytd != 0 && $data_trrYTD3StarTotal->TRR_YTDAllStar != 0){
											$rgi_ytd = $trr_ytd  / $data_trrYTD3StarTotal->TRR_YTDAllStar;
										}
										
										
										
										
										if($total_trr_today3star != 0 && $total_ri_today3star != 0){
											$total_rvr_today3star = $total_trr_today3star/$total_ri_today3star;
										}
										if($total_trr_mtd3star !=0 && $total_ri_mtd3star !=0){
											$total_rvr_mtd3star = $total_trr_mtd3star/$total_ri_mtd3star;
										}
										if($data_trrYTD3StarTotal->TRR_YTDAllStar != 0 && $data_riYTD3StarTotal->RI_YTDAllStar !=0){
											$total_rvr_ytd3star = $data_trrYTD3StarTotal->TRR_YTDAllStar / $data_riYTD3StarTotal->RI_YTDAllStar;
										}

										?>			
										<tr>
											<!-- Hotel and Room Inventory -->
											<td><?= $getHotel3Star->hotels_name;?>	
												<br/>										
												<span>
													<i class="icon-star-full2 customstarsize text-warning-300"></i>
													<i class="icon-star-full2 customstarsize text-warning-300"></i>
													<i class="icon-star-full2 customstarsize text-warning-300"></i>
												</span>
											</td>
											<td><?= number_format($getHotel3Star->total_rooms);?></td>

											<!-- Room Sold -->
											<td><?php echo number_format($rs_today); ?></td>
											<td><?php echo number_format($rs_mtd); ?></td>										
											<td><?php echo number_format($rs_ytd); ?></td>

											<!-- Occupancy -->
											<td><?php echo number_format($occ_today,1).'%'; ?></td>
											<td><?php echo number_format($occ_mtd,2).'%'; ?></td>
											<td><?php echo number_format($occ_ytd,2).'%'; ?></td>

											<!-- Average Room Rate -->
											<td><?php echo number_format($arr_today,0); ?></td>
											<td><?php echo number_format($arr_mtd,0);?></td>
											<td><?php echo number_format($arr_ytd,0);?></td>

											<!-- Total Room Revenue -->
											<td><?php echo number_format($trr_today); ?></td>
											<td><?php echo number_format($trr_mtd); ?></td>
											<td><?php echo number_format($trr_ytd); ?></td>

											<!-- Rev Par -->
											<td><?php echo number_format($rvr_today);?></td>
											<td><?php echo number_format($rvr_mtd);?></td>
											<td><?php echo number_format($rvr_ytd);?></td>

											<!-- MPI -->
											<td><?php echo number_format($mpi_today,2); ?></td>
											<td><?php echo number_format($mpi_mtd,2); ?></td>
											<td><?php echo number_format($mpi_ytd,2); ?></td>

											<!-- ARI -->
											<td><?php echo number_format($ari_today,2); ?></td>
											<td><?php echo number_format($ari_mtd,2); ?></td>
											<td><?php echo number_format($ari_ytd,2); ?></td>

											<!-- RGI -->
											<td><?php echo number_format($rgi_today,2); ?></td>
											<td><?php echo number_format($rgi_mtd,2); ?></td>
											<td><?php echo number_format($rgi_ytd,2); ?></td>

											<td><?php echo $group_ln; ?></td>

											
										</tr>
									<?php } ?>
									<tr style="font-weight:bold;"> <!-- Baris Total untuk bintang 3 -->
											<!-- Hotel and Room Inventory -->
											<td>Total - 3 Stars Hotels</td>
											<td><?php echo number_format($total_ri_today3star); ?></td>

											<!-- Room Sold -->
											<td><?php echo number_format($total_rs_today3star); ?></td>
											<td><?php echo number_format($total_rs_mtd3star); ?></td>										
											<td><?php echo number_format($total_rs_ytd3star); ?></td>

											<!-- Occupancy -->
											
											<td><?php echo number_format($data_occToday3StarTotal->OCC_TODAYAllStar*100,1).'%'; ?></td>
											<td><?php echo number_format($data_occMTD3StarTotal->OCC_MTDAllStar*100,2).'%'; ?></td>
											<td><?php echo number_format($data_occYTD3StarTotal->OCC_YTDAllStar*100,2).'%'; ?></td>

											<!-- Average Room Rate -->
											<td><?php echo number_format($data_arrToday3StarTotal->ARR_TodayAllStar,0); ?></td>
											<td><?php echo number_format($data_arrMTD3StarTotal->ARR_MTDAllStar,0);?></td>
											<td><?php echo number_format($data_arrYTD3StarTotal->ARR_YTDAllStar,0); ?></td>

											<!-- Total Room Revenue -->
											<td><?php echo number_format($data_trrToday3StarTotal->TRR_TodayAllStar,0); ?></td>
											<td><?php echo number_format($data_trrMTD3StarTotal->TRR_MTDAllStar,0); ?></td>
											<td><?php echo number_format($data_trrYTD3StarTotal->TRR_YTDAllStar,0); ?></td>

											<!-- Rev Par -->
											<td><?php echo number_format($total_rvr_today3star); ?></td>
											<td><?php echo number_format($total_rvr_mtd3star); ?></td>
											<td><?php echo number_format($total_rvr_ytd3star); ?></td>

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
									<tr>
											<td style="display: none; "></td>
											<td colspan="27"></td>
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
											<td style="display: none;"></td>
											<td style="display: none;"></td>
											<td style="display: none;"></td>
											<td style="display: none;"></td>
											<td style="display: none;"></td>
									</tr>

									<?php foreach ($getHotel2Star_data->result() as $getHotel2Star){ /*Looping nama Hotel bintang 2 dan kamarnya*/
										//room inventory		
										$ri_today = 0;$ri_mtd = 0;$ri_ytd = 0;
										//room sold
										$rs_today = 0;$rs_mtd = 0;$rs_ytd = 0;
										//avg room rate
										$arr_today = 0;$arr_mtd = 0;$arr_ytd = 0;
										//occupany
										$occ_today = 0;$occ_mtd = 0;$occ_ytd = 0;
										//total room revenue
										$trr_today = 0;$trr_mtd = 0;$trr_ytd = 0;								
										//Rev Par
										$rvr_today = 0;$rvr_mtd = 0;$rvr_ytd = 0;
										//MPI
										$mpi_today = 0;$mpi_mtd = 0;$mpi_ytd = 0;
										//RGI
										$rgi_today = 0;$rgi_mtd = 0;$rgi_ytd = 0;
										//ARI
										$ari_today = 0;$ari_mtd = 0;$ari_ytd = 0;

										$group_ln = "";

										/* $dateToView its GET from controller hotel_competitor_analysis */										
										$dt_analystoday = $this->Smartreport_hca_model->select_competitoranalysisondate_perhotel($getHotel2Star->idhotels,$dateToView);
										if($dt_analystoday != NULL){
											$rs_today = $dt_analystoday->room_sold;
											$arr_today = $dt_analystoday->avg_roomrate;
											$group_ln = $dt_analystoday->remark;
										}

										/* Mulai -  Hitung Room Sold*/										
										$dt_rsmtd = $this->Smartreport_hca_model->select_rsmtd_perhotel($startdate_mtd,$enddate_mtd,$getHotel2Star->idhotels);
										if($dt_rsmtd != NULL)
										{
											$rs_mtd += $dt_rsmtd->RS_MTD;
										}

										
										$dt_rsytd = $this->Smartreport_hca_model->select_rsytd_perhotel($startdate_ytd,$enddate_ytd,$getHotel2Star->idhotels);
										if($dt_rsytd != NULL)
										{
											$rs_ytd += $dt_rsytd->RS_YTD;
										}
										/* Selesai -  Hitung Room Sold*/

										/* Mulai -  Hitung Total Room Revenue*/
										$trr_today = $rs_today * $arr_today;

										$dt_trrmtd = $this->Smartreport_hca_model->select_trrmtd_perhotel($startdate_mtd,$enddate_mtd,$getHotel2Star->idhotels);
										if($dt_trrmtd != NULL)
										{
											$trr_mtd = $dt_trrmtd->TRR_MTD;
										}
				
										$dt_trrytd = $this->Smartreport_hca_model->select_trrytd_perhotel($startdate_ytd,$enddate_ytd,$getHotel2Star->idhotels);
										if($dt_trrytd != NULL)
										{
											 $trr_ytd = $dt_trrytd->TRR_YTD;
										}
										/* Selesai -  Hitung Total Room Revenue*/

										/* Mulai -  Hitung Average Room Rate MTD - YTD*/
										if($rs_mtd != 0 && $rs_ytd != 0 ){
											$arr_mtd = $trr_mtd / $rs_mtd;
											
										}

										if($trr_ytd != 0 && $trr_ytd != 0){
											$arr_ytd = $trr_ytd /$rs_ytd;
										}
										/* Selesai -  Hitung Average Room Rate*/

										/* Mulai -  Occupancy*/
										$ri_today += $getHotel2Star->total_rooms;
										$ri_mtd += $getHotel2Star->total_rooms * $perdate;
										$ri_ytd = $this->Smartreport_hca_model->select_RIYTD_perhotel($startdate_ytd,$enddate_ytd,$getHotel2Star->idhotels);

										if($rs_today != 0 && $ri_today !=0){
											$occ_today = ($rs_today / $ri_today) * 100;
										}
										if($rs_mtd != 0 && $ri_mtd != 0)
										{
											$occ_mtd = ($rs_mtd / $ri_mtd) * 100;
										}
										if($rs_ytd != 0 && $ri_ytd->RI_YTD != 0)
										{
											$occ_ytd = ($rs_ytd / $ri_ytd->RI_YTD) * 100;
										}
										/* Selesai -  Occupancy*/

										/* Mulai -  Rev Par*/
										if($trr_today != 0 && $ri_today !=0){
											$rvr_today = $trr_today / $ri_today;
										}
										if($trr_mtd != 0 && $ri_mtd !=0){
											$rvr_mtd = $trr_mtd / $ri_mtd;
										}
										if($trr_ytd != 0 && $ri_ytd->RI_YTD != 0){
											$rvr_ytd = $trr_ytd / $ri_ytd->RI_YTD;
										}
										/* Selesai -  Rev Par*/

										$total_ri_today2star += $getHotel2Star->total_rooms;
										$total_ri_mtd2star += $getHotel2Star->total_rooms * $perdate;

										$total_rs_today2star += $rs_today;
										$total_rs_mtd2star += $rs_mtd;
										$total_rs_ytd2star += $rs_ytd;

									

										$total_trr_today2star += $trr_today;
										$total_trr_mtd2star += $trr_mtd;
										$total_trr_ytd2star += $trr_ytd;




										if($occ_today != 0 ){
											$mpi_today = ($rs_today / $ri_today) / $data_occToday2StarTotal->OCC_TODAYAllStar ;
										}
										if($occ_mtd != 0 && $total_rs_mtd2star !=0 ){
											$mpi_mtd = ($rs_mtd / $ri_mtd) / $data_occMTD2StarTotal->OCC_MTDAllStar;
										}
										if($occ_ytd != 0 ){
											$mpi_ytd = ($rs_ytd / $ri_ytd->RI_YTD) / $data_occYTD2StarTotal->OCC_YTDAllStar;
										}

										if($arr_today !=0  ){
											$ari_today = $arr_today / $data_arrToday2StarTotal->ARR_TodayAllStar;
										}

										if ($arr_mtd != 0 ){
											$ari_mtd = $arr_mtd / $data_arrMTD2StarTotal->ARR_MTDAllStar;
										}

										if($arr_ytd != 0 ){
											$ari_ytd = $arr_ytd / $data_arrYTD2StarTotal->ARR_YTDAllStar;
										}

										

										if($occ_today != 0 ){
											$rgi_today = ($rs_today / $ri_today) / $data_occToday2StarTotal->OCC_TODAYAllStar ;
										}

										if ($trr_today != 0 && $data_trrToday2StarTotal->TRR_TodayAllStar != 0){
											$rgi_today = $trr_today / $data_trrToday2StarTotal->TRR_TodayAllStar;
										}

										if ($trr_mtd != 0 && $data_trrMTD2StarTotal->TRR_MTDAllStar != 0){
											$rgi_mtd = $trr_mtd  / $data_trrMTD2StarTotal->TRR_MTDAllStar;
										}

										if ($trr_ytd != 0 && $data_trrYTD2StarTotal->TRR_YTDAllStar != 0){
											$rgi_ytd = $trr_ytd  / $data_trrYTD2StarTotal->TRR_YTDAllStar;
										}
										
										
										
										
										if($total_trr_today2star != 0 && $total_ri_today2star != 0){
											$total_rvr_today2star = $total_trr_today2star/$total_ri_today2star;
										}
										if($total_trr_mtd2star !=0 && $total_ri_mtd2star !=0){
											$total_rvr_mtd2star = $total_trr_mtd2star/$total_ri_mtd2star;
										}
										if($data_trrYTD2StarTotal->TRR_YTDAllStar != 0 && $data_riYTD2StarTotal->RI_YTDAllStar !=0){
											$total_rvr_ytd2star = $data_trrYTD2StarTotal->TRR_YTDAllStar / $data_riYTD2StarTotal->RI_YTDAllStar;
										}

										?>			
										<tr>
											<!-- Hotel and Room Inventory -->
											<td><?= $getHotel2Star->hotels_name;?>	
												<br/>										
												<span>
													<i class="icon-star-full2 customstarsize text-warning-300"></i>
													<i class="icon-star-full2 customstarsize text-warning-300"></i>
												</span>
											</td>
											<td><?= number_format($getHotel2Star->total_rooms);?></td>

											<!-- Room Sold -->
											<td><?php echo number_format($rs_today); ?></td>
											<td><?php echo number_format($rs_mtd); ?></td>										
											<td><?php echo number_Format($rs_ytd); ?></td>

											<!-- Occupancy -->
											<td><?php echo number_format($occ_today,1).'%'; ?></td>
											<td><?php echo number_format($occ_mtd,2).'%'; ?></td>
											<td><?php echo number_format($occ_ytd,2).'%'; ?></td>

											<!-- Average Room Rate -->
											<td><?php echo number_format($arr_today,0); ?></td>
											<td><?php echo number_format($arr_mtd,0);?></td>
											<td><?php echo number_format($arr_ytd,0);?></td>

											<!-- Total Room Revenue -->
											<td><?php echo number_format($trr_today); ?></td>
											<td><?php echo number_format($trr_mtd); ?></td>
											<td><?php echo number_format($trr_ytd); ?></td>

											<!-- Rev Par -->
											<td><?php echo number_format($rvr_today);?></td>
											<td><?php echo number_format($rvr_mtd);?></td>
											<td><?php echo number_format($rvr_ytd);?></td>

											<!-- MPI -->
											<td><?php echo number_format($mpi_today,2); ?></td>
											<td><?php echo number_format($mpi_mtd,2); ?></td>
											<td><?php echo number_format($mpi_ytd,2); ?></td>

											<!-- ARI -->
											<td><?php echo number_format($ari_today,2); ?></td>
											<td><?php echo number_format($ari_mtd,2); ?></td>
											<td><?php echo number_format($ari_ytd,2); ?></td>

											<!-- RGI -->
											<td><?php echo number_format($rgi_today,2); ?></td>
											<td><?php echo number_format($rgi_mtd,2); ?></td>
											<td><?php echo number_format($rgi_ytd,2); ?></td>

											<td><?php echo $group_ln; ?></td>

											
										</tr>
									<?php } ?>
									<tr style="font-weight:bold;"> <!-- Baris Total untuk bintang 2 -->
											<!-- Hotel and Room Inventory -->
											<td>Total - 2 Stars Hotels</td>
											<td><?php echo number_format($total_ri_today2star); ?></td>

											<!-- Room Sold -->
											<td><?php echo number_format($total_rs_today2star); ?></td>
											<td><?php echo number_format($total_rs_mtd2star); ?></td>										
											<td><?php echo number_format($total_rs_ytd2star); ?></td>

											<!-- Occupancy -->
											
											<td><?php echo number_format($data_occToday2StarTotal->OCC_TODAYAllStar*100,1).'%'; ?></td>
											<td><?php echo number_format($data_occMTD2StarTotal->OCC_MTDAllStar*100,2).'%'; ?></td>
											<td><?php echo number_format($data_occYTD2StarTotal->OCC_YTDAllStar*100,2).'%'; ?></td>

											<!-- Average Room Rate -->
											<td><?php echo number_format($data_arrToday2StarTotal->ARR_TodayAllStar,0); ?></td>
											<td><?php echo number_format($data_arrMTD2StarTotal->ARR_MTDAllStar,0);?></td>
											<td><?php echo number_format($data_arrYTD2StarTotal->ARR_YTDAllStar,0); ?></td>

											<!-- Total Room Revenue -->
											<td><?php echo number_format($data_trrToday2StarTotal->TRR_TodayAllStar,0); ?></td>
											<td><?php echo number_format($data_trrMTD2StarTotal->TRR_MTDAllStar,0); ?></td>
											<td><?php echo number_format($data_trrYTD2StarTotal->TRR_YTDAllStar,0); ?></td>

											<!-- Rev Par -->
											<td><?php echo number_format($total_rvr_today2star); ?></td>
											<td><?php echo number_format($total_rvr_mtd2star); ?></td>
											<td><?php echo number_format($total_rvr_ytd2star); ?></td>

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
									</tbody>
								</table>
							</div>
							<?php } ?>

						</div>
						<div class="tab-pane fade <?php if ($tab === 'hca2'){ echo "show active"; } ?>" id="right-hca2">
							<div class="col-md-12">
								<form action="<?php echo base_url()?>smartreport/hotel-competitor-analysis" method="get" accept-charset="utf-8">
								<input type="hidden" name="tab" value="hca2">								
								<div class="row">
									<div class="col-md-2">
										<div class="form-group">
											<label><?php echo $lang_date; ?></label>
											<div class="input-group">
													<span class="input-group-prepend">
														<span class="input-group-text"><i class="icon-calendar22"></i></span>
													</span>
													<input type="text" data-mask="99-99-9999" name="date_analysis"   class="form-control daterange-single" value="<?php echo $date_analysis; ?>" required  />
											</div>
										</div>
									</div>
									
									<div class="col-md-1">
										<div class="form-group">
											<label>&emsp; &emsp; &emsp;</label><br/>
											<button type="submit" class="btn bg-teal-400 "><?php echo $lang_search; ?></button>
										</div>
									</div>
									<?php if ($tab === "hca2"){ ?>
									<div class="col-md-2">
										<div class="form-group">
											<label>&emsp; &emsp; &emsp;</label><br/>
											<button type="button" id="ExportReporttoExcel" class="btn bg-teal-400 ">Export to XLSX <i class="icon-file-excel ml-2"></i></button>
										</div>
									</div>
									<?php } ?>								
								</div>
								</form>	
							</div>

							<?php if($tab === "hca2"){ ?>				
							<div class="table-responsive">
								<table class="table table-bordered text-nowrap table-hover customEryan datatable-fixed-complex"  >
									<thead>
										<tr style="vertical-align: middle; text-align: center">
											<th rowspan="2">Hotel Name</th>
											<th rowspan="2">R. Inv</th>
											<th colspan="3">Room Sold</th>
											<th colspan="3">Occupancy</th>
											<th colspan="3">ARR</th>
											<th colspan="3">Total Room Revenue</th>
											<th colspan="3">RevPar</th>
											<th colspan="3">MPI</th>
											<th colspan="3">ARI</th>
											<th colspan="3">RGI</th>
											<th rowspan="2">Group Last Night</th>
										</tr>
										<tr style="vertical-align: middle; text-align: center">
											<th>NOW</th>
											<th>MTD</th>
											<th>YTD</th>

											<th>NOW(%)</th>
											<th>MTD(%)</th>
											<th>YTD(%)</th>

											<th>NOW</th>
											<th>MTD</th>
											<th>YTD</th>

											<th>NOW</th>
											<th>MTD</th>
											<th>YTD</th>

											<th>NOW</th>
											<th>MTD</th>
											<th>YTD</th>

											<th>NOW</th>
											<th>MTD</th>
											<th>YTD</th>

											<th>NOW</th>
											<th>MTD</th>
											<th>YTD</th>

											<th>NOW</th>
											<th>MTD</th>
											<th>YTD</th>
										</tr>
									</thead>
									<tbody>											
									<?php foreach ($getHotelByUser_data->result() as $getHotelByUser){ /*Looping nama Hotel bintang 4 dan kamarnya*/ 										
										//room inventory		
										$ri_today = 0;$ri_mtd = 0;$ri_ytd = 0;
										//room sold
										$rs_today = 0;$rs_mtd = 0;$rs_ytd = 0;
										//avg room rate
										$arr_today = 0;$arr_mtd = 0;$arr_ytd = 0;
										//occupany
										$occ_today = 0;$occ_mtd = 0;$occ_ytd = 0;
										//total room revenue
										$trr_today = 0;$trr_mtd = 0;$trr_ytd = 0;								
										//Rev Par
										$rvr_today = 0;$rvr_mtd = 0;$rvr_ytd = 0;
										//MPI
										$mpi_today = 0;$mpi_mtd = 0;$mpi_ytd = 0;
										//RGI
										$rgi_today = 0;$rgi_mtd = 0;$rgi_ytd = 0;
										//ARI
										$ari_today = 0;$ari_mtd = 0;$ari_ytd = 0;
										$group_ln = "";
										/* $dateToView its GET from controller hotel_competitor_analysis */										
										$dt_analystoday = $this->Smartreport_hca_model->select_competitoranalysisondate_perhotel($getHotelByUser->idhotels,$dateToView);
										if($dt_analystoday != NULL){
											$rs_today = $dt_analystoday->room_sold;
											$arr_today = $dt_analystoday->avg_roomrate;
											$group_ln = $dt_analystoday->remark;
										}

										/* Mulai -  Hitung Room Sold*/										
										$dt_rsmtd = $this->Smartreport_hca_model->select_rsmtd_perhotel($startdate_mtd,$enddate_mtd,$getHotelByUser->idhotels);
										if($dt_rsmtd != NULL)
										{
											$rs_mtd += $dt_rsmtd->RS_MTD;
										}

										
										$dt_rsytd = $this->Smartreport_hca_model->select_rsytd_perhotel($startdate_ytd,$enddate_ytd,$getHotelByUser->idhotels);
										if($dt_rsytd != NULL)
										{
											$rs_ytd += $dt_rsytd->RS_YTD;
										}
										/* Selesai -  Hitung Room Sold*/

										/* Mulai -  Hitung Total Room Revenue*/
										$trr_today = $rs_today * $arr_today;

										$dt_trrmtd = $this->Smartreport_hca_model->select_trrmtd_perhotel($startdate_mtd,$enddate_mtd,$getHotelByUser->idhotels);
										if($dt_trrmtd != NULL)
										{
											$trr_mtd = $dt_trrmtd->TRR_MTD;
										}
				
										$dt_trrytd = $this->Smartreport_hca_model->select_trrytd_perhotel($startdate_ytd,$enddate_ytd,$getHotelByUser->idhotels);
										if($dt_trrytd != NULL)
										{
											 $trr_ytd = $dt_trrytd->TRR_YTD;
										}
										/* Selesai -  Hitung Total Room Revenue*/

										/* Mulai -  Hitung Average Room Rate MTD - YTD*/
										if($rs_mtd != 0 && $rs_ytd != 0 ){
											$arr_mtd = $trr_mtd / $rs_mtd;
											
										}

										if($trr_ytd != 0 && $trr_ytd != 0){
											$arr_ytd = $trr_ytd /$rs_ytd;
										}
										/* Selesai -  Hitung Average Room Rate*/

										/* Mulai -  Occupancy*/
										$ri_today += $getHotelByUser->total_rooms;
										$ri_mtd += $getHotelByUser->total_rooms * $perdate;
										$ri_ytd = $this->Smartreport_hca_model->select_RIYTD_perhotel($startdate_ytd,$enddate_ytd,$getHotelByUser->idhotels);

										if($rs_today != 0 && $ri_today !=0){
											$occ_today = ($rs_today / $ri_today) * 100;
										}
										if($rs_mtd != 0 && $ri_mtd != 0)
										{
											$occ_mtd = ($rs_mtd / $ri_mtd) * 100;
										}
										if($rs_ytd != 0 && $ri_ytd->RI_YTD != 0)
										{
											$occ_ytd = ($rs_ytd / $ri_ytd->RI_YTD) * 100;
										}
										/* Selesai -  Occupancy*/

										/* Mulai -  Rev Par*/
										if($trr_today != 0 && $ri_today !=0){
											$rvr_today = $trr_today / $ri_today;
										}
										if($trr_mtd != 0 && $ri_mtd !=0){
											$rvr_mtd = $trr_mtd / $ri_mtd;
										}
										if($trr_ytd != 0 && $ri_ytd->RI_YTD != 0){
											$rvr_ytd = $trr_ytd / $ri_ytd->RI_YTD;
										}
										/* Selesai -  Rev Par*/

										$total_ri_todaybyuser += $getHotelByUser->total_rooms;
										$total_ri_mtdbyuser += $getHotelByUser->total_rooms * $perdate;

										$total_rs_todaybyuser += $rs_today;
										$total_rs_mtdbyuser += $rs_mtd;
										$total_rs_ytdbyuser += $rs_ytd;

									

										$total_trr_todaybyuser += $trr_today;
										$total_trr_mtdbyuser += $trr_mtd;
										$total_trr_ytdbyuser += $trr_ytd;




										if($occ_today != 0 ){
											$mpi_today = ($rs_today / $ri_today) / $data_occTodayByUserTotal->OCC_TODAYByUser ;
										}
										if($occ_mtd != 0 && $total_rs_mtdbyuser !=0 ){
											$mpi_mtd = ($rs_mtd / $ri_mtd) / $data_occMTDByUserTotal->OCC_MTDByUser;
										}
										if($occ_ytd != 0 ){
											$mpi_ytd = ($rs_ytd / $ri_ytd->RI_YTD) / $data_occYTDByUserTotal->OCC_YTDByUser;
										}

										if($arr_today !=0  ){
											$ari_today = $arr_today / $data_arrTodayByUserTotal->ARR_TodayByUser;
										}

										if ($arr_mtd != 0 ){
											$ari_mtd = $arr_mtd / $data_arrMTDByUserTotal->ARR_MTDByUser;
										}

										if($arr_ytd != 0 ){
											$ari_ytd = $arr_ytd / $data_arrYTDByUserTotal->ARR_YTDByUser;
										}

										

										if($occ_today != 0 ){
											$rgi_today = ($rs_today / $ri_today) / $data_occTodayByUserTotal->OCC_TODAYByUser ;
										}

										if ($trr_today != 0 && $data_trrTodayByUserTotal->TRR_TodayByUser != 0){
											$rgi_today = $trr_today / $data_trrTodayByUserTotal->TRR_TodayByUser;
										}

										if ($trr_mtd != 0 && $data_trrMTDByUserTotal->TRR_MTDByUser != 0){
											$rgi_mtd = $trr_mtd  / $data_trrMTDByUserTotal->TRR_MTDByUser;
										}

										if ($trr_ytd != 0 && $data_trrYTDByUserTotal->TRR_YTDByUser != 0){
											$rgi_ytd = $trr_ytd  / $data_trrYTDByUserTotal->TRR_YTDByUser;
										}
										
										
										
										
										if($total_trr_todaybyuser != 0 && $total_ri_todaybyuser != 0){
											$total_rvr_todaybyuser = $total_trr_todaybyuser/$total_ri_todaybyuser;
										}
										if($total_trr_mtdbyuser !=0 && $total_ri_mtdbyuser !=0){
											$total_rvr_mtdbyuser = $total_trr_mtdbyuser/$total_ri_mtdbyuser;
										}
										if($data_trrYTDByUserTotal->TRR_YTDByUser != 0 && $data_riYTDByUserTotal->RI_YTDByUser !=0){
											$total_rvr_ytdbyuser = $data_trrYTDByUserTotal->TRR_YTDByUser / $data_riYTDByUserTotal->RI_YTDByUser;
										}

										?>			
										<tr>
											<!-- Hotel and Room Inventory -->
											<td><?= $getHotelByUser->hotels_name;?>	
												<br/>										
												<span>
													<i class="icon-star-full2 customstarsize text-warning-300"></i>
													<i class="icon-star-full2 customstarsize text-warning-300"></i>
													<i class="icon-star-full2 customstarsize text-warning-300"></i>
													<i class="icon-star-full2 customstarsize text-warning-300"></i>
												</span>
											</td>
											<td><?= number_format($getHotelByUser->total_rooms);?></td>

											<!-- Room Sold -->
											<td><?php echo number_format($rs_today); ?></td>
											<td><?php echo number_format($rs_mtd); ?></td>										
											<td><?php echo number_format($rs_ytd); ?></td>

											<!-- Occupancy -->
											<td><?php echo number_format($occ_today,1).'%'; ?></td>
											<td><?php echo number_format($occ_mtd,2).'%'; ?></td>
											<td><?php echo number_format($occ_ytd,2).'%'; ?></td>

											<!-- Average Room Rate -->
											<td><?php echo number_format($arr_today,0); ?></td>
											<td><?php echo number_format($arr_mtd,0);?></td>
											<td><?php echo number_format($arr_ytd,0);?></td>

											<!-- Total Room Revenue -->
											<td><?php echo number_format($trr_today); ?></td>
											<td><?php echo number_format($trr_mtd); ?></td>
											<td><?php echo number_format($trr_ytd); ?></td>

											<!-- Rev Par -->
											<td><?php echo number_format($rvr_today);?></td>
											<td><?php echo number_format($rvr_mtd);?></td>
											<td><?php echo number_format($rvr_ytd);?></td>

											<!-- MPI -->
											<td><?php echo number_format($mpi_today,2); ?></td>
											<td><?php echo number_format($mpi_mtd,2); ?></td>
											<td><?php echo number_format($mpi_ytd,2); ?></td>

											<!-- ARI -->
											<td><?php echo number_format($ari_today,2); ?></td>
											<td><?php echo number_format($ari_mtd,2); ?></td>
											<td><?php echo number_format($ari_ytd,2); ?></td>

											<!-- RGI -->
											<td><?php echo number_format($rgi_today,2); ?></td>
											<td><?php echo number_format($rgi_mtd,2); ?></td>
											<td><?php echo number_format($rgi_ytd,2); ?></td>

											<td><?php echo $group_ln; ?></td>
											
										</tr>

										
										
									<?php } ?>
									<tr style="font-weight:bold"> <!-- Baris Total untuk bintang 4 -->
											<!-- Hotel and Room Inventory -->
											<td>Total </td>
											<td><?php echo number_format($total_ri_todaybyuser); ?></td>

											<!-- Room Sold -->
											<td><?php echo number_format($total_rs_todaybyuser); ?></td>
											<td><?php echo number_format($total_rs_mtdbyuser); ?></td>										
											<td><?php echo number_format($total_rs_ytdbyuser); ?></td>

											<!-- Occupancy -->
											
											<td><?php echo number_format($data_occTodayByUserTotal->OCC_TODAYByUser*100,1).'%'; ?></td>
											<td><?php echo number_format($data_occMTDByUserTotal->OCC_MTDByUser*100,2).'%'; ?></td>
											<td><?php echo number_format($data_occYTDByUserTotal->OCC_YTDByUser*100,2).'%'; ?></td>

											<!-- Average Room Rate -->
											<td><?php echo number_format($data_arrTodayByUserTotal->ARR_TodayByUser,0); ?></td>
											<td><?php echo number_format($data_arrMTDByUserTotal->ARR_MTDByUser,0);?></td>
											<td><?php echo number_format($data_arrYTDByUserTotal->ARR_YTDByUser,0); ?></td>

											<!-- Total Room Revenue -->
											<td><?php echo number_format($data_trrTodayByUserTotal->TRR_TodayByUser,0); ?></td>
											<td><?php echo number_format($data_trrMTDByUserTotal->TRR_MTDByUser,0); ?></td>
											<td><?php echo number_format($data_trrYTDByUserTotal->TRR_YTDByUser,0); ?></td>

											<!-- Rev Par -->
											<td><?php echo number_format($total_rvr_todaybyuser); ?></td>
											<td><?php echo number_format($total_rvr_mtdbyuser); ?></td>
											<td><?php echo number_format($total_rvr_ytdbyuser); ?></td>

											

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
									
									</tbody>
								</table>
							</div>
							<?php } ?>

						</div>
						<div class="tab-pane fade" id="right-hca3">							
							<form action="<?php echo base_url()?>smartreport/add_analysis_data" method="post" accept-charset="utf-8" enctype="multipart/form-data">								
								<div class="col-md-5">	
									<div class="form-group row">
										<label class="col-form-label col-lg-2"><strong><?php echo $lang_date; ?></strong></label>
										<div class="col-lg-10">
											<div class="input-group">
												<span class="input-group-prepend">
													<span class="input-group-text"><i class="icon-calendar22"></i></span>
												</span>
												<input type="text" data-mask="99-99-9999" name="date_analysis" <?php if ($user_le > '2'){ echo "readonly";} ?>  class="form-control <?php if ($user_le <= '2'){ echo "daterange-single";} ?> " value="<?php $d=strtotime("-1 Day"); echo date("d-m-Y", $d); ?>" required  />
											</div>
										</div>
									</div>
								</div>	
								<div  class="table-responsive">
									<table class="table text-nowrap table-hover" id="example">
										<thead>
											<tr>
												<th>#</th>
												<th><?php echo $lang_competitor_hotels; ?></th>
												<th><?php echo $lang_room_sold; ?></th>
												<th><?php echo $lang_avg_room_rate; ?></th>
												<th><?php echo $lang_gr_last_night; ?></th>
												
											</tr>
										</thead>
										
										<tbody>
											
										<?php
											$start=0;
											foreach ($smartreport_hca_addlist_data as $smartreport_hca_addlist){?>
											<tr>
												<td><?php  echo ++$start; ?></td>
												<td><strong><?php echo $smartreport_hca_addlist->competitor; ?></strong>
													<div class="text-muted font-size-sm">
													<?php if ($smartreport_hca_addlist->hotel_star === '1') { ?>
														<span>
															<i class="icon-star-full2 font-size-base text-warning-300"></i>
														</span>
													<?php } else if ($smartreport_hca_addlist->hotel_star === '2') { ?>
														<span>
															<i class="icon-star-full2 font-size-base text-warning-300"></i>
															<i class="icon-star-full2 font-size-base text-warning-300"></i>
														</span>
													<?php } else if ($smartreport_hca_addlist->hotel_star === '3') { ?>
														<span>
															<i class="icon-star-full2 font-size-base text-warning-300"></i>
															<i class="icon-star-full2 font-size-base text-warning-300"></i>
															<i class="icon-star-full2 font-size-base text-warning-300"></i>
														</span>
													<?php } else if ($smartreport_hca_addlist->hotel_star === '4') { ?>	
														<span>
															<i class="icon-star-full2 font-size-base text-warning-300"></i>
															<i class="icon-star-full2 font-size-base text-warning-300"></i>
															<i class="icon-star-full2 font-size-base text-warning-300"></i>
															<i class="icon-star-full2 font-size-base text-warning-300"></i>
														</span>
													<?php } else if ($smartreport_hca_addlist->hotel_star === '5') { ?>
														<span>
															<i class="icon-star-full2 font-size-base text-warning-300"></i>
															<i class="icon-star-full2 font-size-base text-warning-300"></i>
															<i class="icon-star-full2 font-size-base text-warning-300"></i>
															<i class="icon-star-full2 font-size-base text-warning-300"></i>	
															<i class="icon-star-full2 font-size-base text-warning-300"></i>		
														</span>
													<?php } ?>
													</div>
													<input type="hidden" name="idhotels[]" value="<?= $smartreport_hca_addlist->idcompetitor ?>">
												</td>
												<td><input type="text" oninput="this.value = this.value.replace(/[^\d]/, '').replace(/(\..*)\./g, '$1');" name="room_sold[]" class="form-control" required></td>
												<td><input type="text" oninput="this.value = this.value.replace(/[^\d]/, '').replace(/(\..*)\./g, '$1');" name="avg_roomrate[]" class="form-control" required></td>
												<td><input type="text" name="remark[]" class="form-control"></td>
												
												
											</tr>
											<?php } ?>
										</tbody>
									</table>
									
									<div class="text-center">
										<button type="submit" class="btn bg-teal-400" ><?php echo $lang_submit;?></button>
									</div>
								
								</div>
							</form>
						</div>
						
						<div class="tab-pane fade" id="right-hca4">
							<form action="<?php echo base_url()?>smartreport/add_analysis_data_byhotel" method="post" accept-charset="utf-8">
								<div class="col-md-7">	
									<div class="form-group row">
										<label class="col-form-label col-lg-2"><strong><?php echo $lang_date; ?></strong></label>
										<div class="col-lg-10">
											<div class="input-group">
												<span class="input-group-prepend">
													<span class="input-group-text"><i class="icon-calendar22"></i></span>
												</span>
												<input type="text" name="date_analysis" data-mask="99-99-9999" <?php if ($user_le > '2'){ echo "readonly";} ?>  class="form-control <?php if ($user_le <= '2'){ echo "daterange-single";} ?> " value="<?php echo date('d-m-Y',strtotime("-1 Day")); ?>" required  />
											</div>
										</div>
									</div>

									<div class="form-group row">
										<label class="col-form-label col-lg-2"><strong><?php echo $lang_competitor_hotels; ?></strong></label>
										<div class="col-lg-10">
											<div class="input-group">												
											<select  name="idhotels" class="form-control custom_category" required autocomplete="off">
													<option ><?php echo $lang_choose_hotels; ?></option>
												<?php												
													$hotelsData = $this->Smartreport_hca_model->get_add_list($user_ho);
													for ($p = 0; $p < count($hotelsData); ++$p) {
														$idhotels = $hotelsData[$p]->idcompetitor;
														$hotels_name = $hotelsData[$p]->competitor;?>
														<option  value="<?php echo $idhotels;?>" >
															<?php echo $hotels_name; ?>
														</option>
												<?php
														unset($idhotels);
														unset($hotels_name);
													}
												?>
											</select>
											</div>
										</div>
									</div>

									<div class="form-group row">
										<label class="col-form-label col-lg-2"><strong><?php echo $lang_room_sold; ?></strong></label>
										<div class="col-lg-10">
											<div class="input-group">
												
												<input type="text" name="room_sold" class="form-control" oninput="this.value = this.value.replace(/[^\d]/, '').replace(/(\..*)\./g, '$1');" required />
											</div>
										</div>
									</div>
									
									<div class="form-group row">
										<label class="col-form-label col-lg-2"><strong><?php echo $lang_avg_room_rate; ?></strong></label>
										<div class="col-lg-10">
											<div class="input-group">												
												<input type="text" name="avg_roomrate" class="form-control" oninput="this.value = this.value.replace(/[^\d]/, '').replace(/(\..*)\./g, '$1');" required />
											</div>
										</div>
									</div>

									<div class="form-group row">
										<label class="col-form-label col-lg-2"><strong><?php echo $lang_gr_last_night; ?></strong></label>
										<div class="col-lg-10">
											<div class="input-group">												
												<input type="input" name="remark" class="form-control"/>
											</div>
										</div>
									</div>
									<div class="text-right">
										<button type="submit" class="btn bg-teal-400" ><?php echo $lang_submit;?></button>
									</div>
								</div>	
								
							</form>
						</div>
						
					</div>
				</div>
			</div>
			<!-- /content area -->