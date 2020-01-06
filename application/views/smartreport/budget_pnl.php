<style>
.form-control:focus {

  box-shadow: inset 1px 2px 4px rgba(0, 0, 0, 0.01), 0px 0px 8px rgba(0, 0, 0, 0.2);
}

.customEryan{
	font-size: 11px;
	width: 100%;  
}

.hidden{
	display: none !important;
}


.header-print {
    display: table-header-group;
}

.rata-kanan{
	vertical-align: middle; 
	text-align: right;
}

</style>

<script src="<?php echo base_url();?>assets/backend/global_assets/js/plugins/tables/datatables/datatables.min.js"></script>
<script src="<?php echo base_url();?>assets/backend/global_assets/js/plugins/tables/datatables/extensions/fixed_columns.min.js"></script>

<script src="<?php echo base_url();?>assets/backend/global_assets/js/plugins/tables/datatables/extensions/jszip/jszip.min.js"></script>
<!--<script src="<?php //echo base_url();?>assets/backend/global_assets/js/plugins/tables/datatables/extensions/buttons.min.js"></script>-->



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

		$('.custom_select').select2();

		$('#categorypnl').change(function(){ 
		var id=$(this).val();
			$.ajax({
				url : "<?php echo site_url('smartreportpnl/get_pnllist');?>",
				method : "POST",
				data : {id: id},
				async : true,
				dataType : 'json',
				success: function(data){
					
					var html = '<option value=""><?php echo $lang_choose_pnl_list;?></option>';
					var i;
					for(i=0; i<data.length; i++){
						html += '<option value='+data[i].idpnl+'>'+data[i].pnl_name+'</option>';
					}
					$('#pnllist').html(html);

				}
			});
			return false;
		}); 
	});

	function isNumberKeyDash(evt){
		var charCode = (evt.which) ? evt.which : event.keyCode
		if (charCode != 45  && charCode > 31 && (charCode < 48 || charCode > 57))
			return false;

		return true;
	}
</script> 
<?php
	if ($dateToView == NULL){
		$dateToView = date("Y");
	}
	$url_year = $dateToView;
   /*$url_date = '';
   $url_date = $date_analysis;
   									
   $date =  $dateToView;	
   $peryear = substr($dateToView,0,4);
   $permonth= substr($dateToView,5,2);
   $perdate = substr($dateToView,8,2);	

	$startdate_ytd = $peryear.'-01-'.'01';
	$enddate_ytd = $dateToView;
	$startdate_mtd = $peryear.'-'.$permonth.'-'.'01';
	$enddate_mtd = $dateToView;  */
$total_rooms = $this->Dashboard_model->getDataHotel($idhotel_custom);
$total_room_revenue = $this->Smartreport_pnl_model->get_total_budget( "4", $idhotel_custom, $dateToView); //4 adalah idpnl Room
$occupied_room = $this->Smartreport_pnl_model->get_total_budget( "7", $idhotel_custom, $dateToView); //7 adalah idpnl occupied room / room sold

function cal_days_in_year($dateToView){
	$days=0; 
	for($month=1;$month<=12;$month++){ 
			$days = $days + cal_days_in_month(CAL_GREGORIAN,$month,$dateToView);
		}
	return $days;
	}
	
?>
<!-- Page header -->
        <div class="page-header page-header-light">
				<div class="page-header-content header-elements-md-inline">
					<div class="page-title d-flex">
						<h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold"><?php echo $lang_pnl; ?></span> - <?php echo $lang_pnl_budget; ?></h4>
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
					<h6 class="card-title"><strong><?php  $hotel = $this->Dashboard_model->getDataHotel($idhotel_custom); echo $hotel->hotels_name .' - '.$lang_pnl_budget; ?></strong></h6>
					<div class="header-elements">
						<div class="list-icons">
				            <a class="list-icons-item" data-action="collapse"></a>
				            
				        </div>
			        </div>
				</div>
				
				<div class="card-body">
					<ul class="nav nav-tabs nav-tabs-highlight justify-content-end">
						<li class="nav-item"><a href="#right-pnl1" class="nav-link active" data-toggle="tab"><i class="icon-stats-dots mr-2"></i><?php echo $lang_budget_data?></a></li>
						<li class="nav-item"><a href="#right-pnl2" class="nav-link" data-toggle="tab"><i class="icon-stack-plus mr-2"></i><?php echo $lang_add_data?></a></li>						
						<li class="nav-item"><a href="#right-pnl3" class="nav-link" data-toggle="tab"><i class="icon-plus3 mr-2"></i><?php echo $lang_add_data_bypnl?></a></li>	
					</ul>

				    <div class="tab-content">
						
						<div class="tab-pane fade show active" id="right-pnl1">
							<form action="<?php echo base_url()?>smartreportpnl/budget_pnl" method="get" accept-charset="utf-8" enctype="multipart/form-data">		
								<div class="col-md-10">	
									<div class="form-group">
										<div class="row">											
                                            <div class="col-sm-2">
												<label><?php echo $lang_year ?></label>
												<select name="year_budget" class="form-control" required>
													<?php
														for($i=date('Y'); $i>=2018; $i--) {
														$selected = '';
														if ($dateToView == $i) $selected = ' selected="selected"';
														print('<option value="'.$i.'"'.$selected.'>'.$i.'</option>'."\n");
													}?>
												</select>  
											</div>

											<?php if($user_le === '1' ){ ?>
											<div class="col-sm-3">
												<div class="form-group">
												<label><?php echo $lang_hotel ?></label>								
													<select name="idhotelcustom" class="form-control custom_select" required autocomplete="off">
														<option value=""><?php echo $lang_choose_hotels; ?></option>
														<?php $hotel = $idhotel_custom;
															$hotelData = $this->Smartreport_hotels_model->getDataParent('smartreport_hotels', 'idhotels','PARENT', 'ASC');
															for ($p = 0; $p < count($hotelData); ++$p) {
																$idhotel = $hotelData[$p]->idhotels;
																$hotelname = $hotelData[$p]->hotels_name;?>
														<option value="<?php echo $idhotel; ?>" <?php if ($hotel == $idhotel) {	echo 'selected="selected"';	} ?>>
															<?php echo $hotelname; ?>
														</option>
														<?php
															unset($idhotel);
															unset($hotelname);
															}
														?>
													</select>									
												</div>

											</div>
											<?php } ?>   

											<div class="col-sm-1">
												<div class="form-group">
													<label>&emsp;</label><br/>
													<button type="submit" class="btn bg-teal-400 "><?php echo $lang_search; ?></button>
												</div>
											</div>
											<!--<div class="col-sm-4">
												<div class="form-group">
													<label>&emsp;</label><br/>
													<a href="<?php // echo base_url('smartreportpnl/budget_pnlpdf?year_budget='.$dateToView.'&idhotelcustom='.$idhotel_custom);?>"><button type="button" class="btn bg-teal-400 ">Export to PDF <i class="icon-file-pdf ml-2"></i></button></a>
												</div>
											</div>-->
                                        </div>
                                    </div> 
								</div>
							</form>	
							

							<div class="table-responsive">
								<table class="table table-bordered text-nowrap table-hover table-xs customEryan datatable-nobutton">
									<thead style="vertical-align: middle; text-align: center">
										<tr >
											<th rowspan="2"><?php echo $lang_description; ?></th>											
											<th colspan="2">Summary</th>											
											<th rowspan="2">January</th>
											<th rowspan="2">February</th>
											<th rowspan="2">March</th>
											<th rowspan="2">April</th>
											<th rowspan="2">May</th>
											<th rowspan="2">June</th>
											<th rowspan="2">July</th>
											<th rowspan="2">August</th>
											<th rowspan="2">September</th>
											<th rowspan="2">October</th>
											<th rowspan="2">November</th>
											<th rowspan="2">December</th>												
										</tr>
										<tr>
											<td>Year To Date</td>
											<td>(%)</td>
										</tr>
									</thead>
									<tbody>
											<tr>
												<td colspan="3"><strong>STATISCTIC</strong></td>
												<td style="display: none;"></td>
												<td style="display: none;"></td>
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

											<tr>
												<td>&emsp;&emsp;Number of Days</td>
												<td class="rata-kanan"><?php echo cal_days_in_year($dateToView); ?></td>
												<td></td>
												<?php for($month= 1; $month<=12; $month++ ){ ?>
													<?php $dayInMonth = cal_days_in_month(CAL_GREGORIAN,$month, $dateToView);?>
													<td class="rata-kanan"><?php echo $dayInMonth; ?></td>
												<?php }  ?>												
											</tr>

											<tr>
												<td>&emsp;&emsp;Number of Rooms Available</td>
												<td class="rata-kanan"><?php echo number_format(cal_days_in_year($dateToView)* $total_rooms->total_rooms,0); ?></td>
												<td></td>
												<?php for($month= 1; $month<=12; $month++ ){
														   $dayInMonth = cal_days_in_month(CAL_GREGORIAN,$month, $dateToView);														   
														   $room_available = $dayInMonth * $total_rooms->total_rooms;
														   ?>
															<td class="rata-kanan">
																<?php if ($dayInMonth !=0 && $total_rooms->total_rooms !=0){
																	echo number_format($room_available,0);
																}else{
																	echo '0';
																} ?>
															</td>
												<?php }  ?>
											</tr>

											<tr>
												<td>&emsp;&emsp;% of Occupancy</td>
												<td class="rata-kanan"><?php 
													if($total_rooms->total_rooms != 0){ 
														echo number_format($occupied_room->TOTAL_BUDGET/(cal_days_in_year($dateToView)* $total_rooms->total_rooms)*100,2).'%';
													}else{
														echo '0%';
													} ?>
												</td>
												<td></td>
												<?php for($month= 1; $month<=12; $month++ ){ ?>													
												<td class="rata-kanan"><?php 
														if($total_rooms->total_rooms != 0){
															$budget_roomsold = $this->Smartreport_pnl_model->get_data_budgetroomsold($idhotel_custom, $month, $dateToView);
															$dayInMonth = cal_days_in_month(CAL_GREGORIAN,$month, $dateToView);
															$occupancy = ($budget_roomsold->BUDGETROOMSOLD / ($dayInMonth * $total_rooms->total_rooms))*100;
															
															echo number_format($occupancy,2).'%';
														}else{
															echo '0%';
														} ?>
													</td>  
												<?php } ?> 
											</tr>
										<?php foreach ($smartreport_pnlcategory_data as $smartreport_pnlcategory){
												/* Terlalu Dinamis parah, PNL Statistic sudah hilang karena sudah jadi header diatas IDPNLCATEGORY 1 itu adalah STATISTIC*/
												//$dateToView itu ada year
												$smartreport_pnllist_data = $this->Smartreport_pnl_model->select_pnllist_percategory($smartreport_pnlcategory->idpnlcategory);
												$grandtotal_pnlcategory = $this->Smartreport_pnl_model->get_grandtotal_pnlcategory($smartreport_pnlcategory->idpnlcategory, $idhotel_custom, $dateToView);
												$grandtotal_totalsales = $this->Smartreport_pnl_model->get_grandtotal_pnlcategory('2', $idhotel_custom, $dateToView); ?>
											<tr >
												<td <?php if ($smartreport_pnlcategory->idpnlcategory == 1) {echo "class='hidden'";} ?> colspan="3"><strong><?php echo $smartreport_pnlcategory->pnl_category;?></strong></td>	
												<td <?php if ($smartreport_pnlcategory->idpnlcategory == 1) {echo "class='hidden'";} ?> style="display: none;"></td>
												<td <?php if ($smartreport_pnlcategory->idpnlcategory == 1) {echo "class='hidden'";} ?> style="display: none;"></td>    
												<td <?php if ($smartreport_pnlcategory->idpnlcategory == 1) {echo "class='hidden'";} ?> colspan="12"></td>
												<td <?php if ($smartreport_pnlcategory->idpnlcategory == 1) {echo "class='hidden'";} ?> style="display: none;"></td>
												<td <?php if ($smartreport_pnlcategory->idpnlcategory == 1) {echo "class='hidden'";} ?> style="display: none;"></td>
												<td <?php if ($smartreport_pnlcategory->idpnlcategory == 1) {echo "class='hidden'";} ?> style="display: none;"></td>
												<td <?php if ($smartreport_pnlcategory->idpnlcategory == 1) {echo "class='hidden'";} ?> style="display: none;"></td>
												<td <?php if ($smartreport_pnlcategory->idpnlcategory == 1) {echo "class='hidden'";} ?> style="display: none;"></td>
												<td <?php if ($smartreport_pnlcategory->idpnlcategory == 1) {echo "class='hidden'";} ?> style="display: none;"></td>
												<td <?php if ($smartreport_pnlcategory->idpnlcategory == 1) {echo "class='hidden'";} ?> style="display: none;"></td>
												<td <?php if ($smartreport_pnlcategory->idpnlcategory == 1) {echo "class='hidden'";} ?> style="display: none;"></td>
												<td <?php if ($smartreport_pnlcategory->idpnlcategory == 1) {echo "class='hidden'";} ?> style="display: none;"></td>
												<td <?php if ($smartreport_pnlcategory->idpnlcategory == 1) {echo "class='hidden'";} ?> style="display: none;"></td>	
												<td <?php if ($smartreport_pnlcategory->idpnlcategory == 1) {echo "class='hidden'";} ?> style="display: none;"></td>                                												
											</tr>		
												<?php foreach ($smartreport_pnllist_data as $smartreport_pnllist ){
													  $total_budget = $this->Smartreport_pnl_model->get_total_budget( $smartreport_pnllist->idpnl, $idhotel_custom, $dateToView);?>
                                                        <tr>															
															<td>&emsp;&emsp;<?= $smartreport_pnllist->pnl_name;?></td>
															<td class="rata-kanan" >
																	<?php 
																		if($smartreport_pnllist->idpnl == 1){ //idpnl 1 ada average room rate cara menghitungnya beda sendiri																			
																			if($total_room_revenue->TOTAL_BUDGET!=0 && $occupied_room->TOTAL_BUDGET !=0){
																			echo number_format($total_room_revenue->TOTAL_BUDGET/$occupied_room->TOTAL_BUDGET,0);
																			}else{
																				echo '0';
																			}
																		}else{																			 
																			echo number_format($total_budget->TOTAL_BUDGET);
																	}?>																
															</td>
															<td class="rata-kanan">
																<?php if($smartreport_pnllist->idpnlcategory == 2){
																	if($total_budget->TOTAL_BUDGET !=0 && $grandtotal_pnlcategory->GRANDTOTAL_PNLCATEGORY !=0 ){
																		echo number_format(($total_budget->TOTAL_BUDGET/$grandtotal_pnlcategory->GRANDTOTAL_PNLCATEGORY)*100,2).'%';
																	}else{
																		echo '0%';
																	}
																}else if ($smartreport_pnllist->idpnlcategory == 6) {
																	
																	$total_room_sales = $this->Smartreport_pnl_model->get_total_budget('4', $idhotel_custom, $dateToView);
																	$total_fnb_sales = $this->Smartreport_pnl_model->get_total_budget('3', $idhotel_custom, $dateToView);
																	$total_laundry_sales = $this->Smartreport_pnl_model->get_total_budget('5', $idhotel_custom, $dateToView);
																	$total_business_sales = $this->Smartreport_pnl_model->get_total_budget('6', $idhotel_custom, $dateToView);
																	$total_sport_sales = $this->Smartreport_pnl_model->get_total_budget('24', $idhotel_custom, $dateToView);
																	$total_spa_sales = $this->Smartreport_pnl_model->get_total_budget('25', $idhotel_custom, $dateToView);

																	$total_room_profit = $this->Smartreport_pnl_model->get_total_budget('14', $idhotel_custom, $dateToView);
																	$total_fnb_profit = $this->Smartreport_pnl_model->get_total_budget('15', $idhotel_custom, $dateToView);
																	$total_laundry_profit = $this->Smartreport_pnl_model->get_total_budget('26', $idhotel_custom, $dateToView);
																	$total_business_profit = $this->Smartreport_pnl_model->get_total_budget('16', $idhotel_custom, $dateToView);
																	$total_sport_profit = $this->Smartreport_pnl_model->get_total_budget('27', $idhotel_custom, $dateToView);
																	$total_spa_profit = $this->Smartreport_pnl_model->get_total_budget('28', $idhotel_custom, $dateToView);

																	if ($smartreport_pnllist->idpnl == 14){
																		if ($total_room_profit->TOTAL_BUDGET !=0 && $total_room_sales->TOTAL_BUDGET !=0){
																			echo number_format(($total_room_profit->TOTAL_BUDGET / $total_room_sales->TOTAL_BUDGET)*100,2).'%';
																		}else{
																			echo '0%';
																		}
																	}else if ($smartreport_pnllist->idpnl == 15){
																		if ($total_fnb_profit->TOTAL_BUDGET !=0 && $total_fnb_sales->TOTAL_BUDGET !=0){
																			echo number_format(($total_fnb_profit->TOTAL_BUDGET / $total_fnb_sales->TOTAL_BUDGET)*100,2).'%';
																		}else{
																			echo '0%';
																		}
																	}else if ($smartreport_pnllist->idpnl == 26){
																		if ($total_laundry_profit->TOTAL_BUDGET !=0 && $total_laundry_sales->TOTAL_BUDGET !=0){
																			echo number_format(($total_laundry_profit->TOTAL_BUDGET / $total_laundry_sales->TOTAL_BUDGET)*100,2).'%';
																		}else{
																			echo '0%';
																		}
																	}else if ($smartreport_pnllist->idpnl == 16){
																		if ($total_business_profit->TOTAL_BUDGET !=0 && $total_business_sales->TOTAL_BUDGET !=0){
																			echo number_format(($total_business_profit->TOTAL_BUDGET / $total_business_sales->TOTAL_BUDGET)*100,2).'%';
																		}else{
																			echo '0%';
																		}
																	}else if ($smartreport_pnllist->idpnl == 27){
																		if ($total_sport_profit->TOTAL_BUDGET !=0 && $total_sport_sales->TOTAL_BUDGET !=0){
																			echo number_format(($total_sport_profit->TOTAL_BUDGET / $total_sport_sales->TOTAL_BUDGET)*100,2).'%';
																		}else{
																			echo '0%';
																		}
																	}else if ($smartreport_pnllist->idpnl == 28){
																		if ($total_spa_profit->TOTAL_BUDGET !=0 && $total_spa_sales->TOTAL_BUDGET !=0){
																			echo number_format(($total_spa_profit->TOTAL_BUDGET / $total_spa_sales->TOTAL_BUDGET)*100,2).'%';
																		}else{
																			echo '0%';
																		}
																	}
																	
																}else if($smartreport_pnllist->idpnlcategory !=1 && $smartreport_pnllist->idpnlcategory !=2 && $smartreport_pnllist->idpnlcategory !=6 ){
																	if($total_budget->TOTAL_BUDGET !=0 && $grandtotal_totalsales->GRANDTOTAL_PNLCATEGORY !=0 ){
																		echo number_format(($total_budget->TOTAL_BUDGET/$grandtotal_totalsales->GRANDTOTAL_PNLCATEGORY)*100,2).'%';
																	}else{
																		echo '0%';
																	}
																}
																?>
															</td>
															<?php for($month= 1; $month<=12; $month++ ){ ?>																
															<td class="rata-kanan">
																<?php $budget_data = $this->Smartreport_pnl_model->get_data_budget( $smartreport_pnllist->idpnl, $idhotel_custom, $month, $dateToView);
																echo number_format($budget_data->BUDGET,0);?>
															</td>  
													  		<?php } ?>                                           
                                                        </tr>
												<?php } ?>
												<tr>
													<td <?php  if ($smartreport_pnlcategory->idpnlcategory == 1) {echo "class='hidden'";} ?>><strong><?php echo "TOTAL ".$smartreport_pnlcategory->pnl_category;?></strong></td>
													<td <?php  if ($smartreport_pnlcategory->idpnlcategory == 1) {echo "class='hidden'";}else{echo "class='rata-kanan'";}?>><strong><?php echo number_format($grandtotal_pnlcategory->GRANDTOTAL_PNLCATEGORY,0);?></strong></td>
													<td <?php  if ($smartreport_pnlcategory->idpnlcategory == 1) {echo "class='hidden'";}else{echo "class='rata-kanan'";}?>>
														<strong>
															<?php if($smartreport_pnllist->idpnlcategory == 2){
																	if($grandtotal_pnlcategory->GRANDTOTAL_PNLCATEGORY !=0 ){
																		echo number_format(($grandtotal_pnlcategory->GRANDTOTAL_PNLCATEGORY/$grandtotal_pnlcategory->GRANDTOTAL_PNLCATEGORY)*100,2).'%';
																	}else{
																		echo '0%';
																	}
																}else if($smartreport_pnllist->idpnlcategory !=2 && $smartreport_pnllist->idpnlcategory !=1){
																	if($grandtotal_pnlcategory->GRANDTOTAL_PNLCATEGORY !=0 && $grandtotal_totalsales->GRANDTOTAL_PNLCATEGORY !=0 ){
																		echo number_format(($grandtotal_pnlcategory->GRANDTOTAL_PNLCATEGORY/$grandtotal_totalsales->GRANDTOTAL_PNLCATEGORY)*100,2).'%';
																	}else{
																		echo '0%';
																	}
																}
															?>
														</strong>
													</td>
													
													<?php for($month= 1; $month<=12; $month++ ){ ?>					
													<td  <?php  if ($smartreport_pnlcategory->idpnlcategory == 1) {echo "class='hidden'";}else{echo "class='rata-kanan'";}?>> 
														<strong>
															<?php $total_pnlcategorybymonth = $this->Smartreport_pnl_model->get_total_pnlcategorybymonth($smartreport_pnlcategory->idpnlcategory, $idhotel_custom, $month, $dateToView); 
															echo number_format($total_pnlcategorybymonth->TOTAL_PNLCATEGORYBYMONTH,0); ?>	
														 </strong>													
													</td>
													<?php } ?> 
												</tr>	
											<?php } ?>


											<tr>
												<td><strong>TOTAL UNDISTRIBUTED EXPENSE</strong></td>												
												<td class='rata-kanan'>
													<?php 
														$grandtotal_und_payroll = $this->Smartreport_pnl_model->get_grandtotal_pnlcategory('7', $idhotel_custom, $dateToView);
														$grandtotal_und_opr_exp = $this->Smartreport_pnl_model->get_grandtotal_pnlcategory('8', $idhotel_custom, $dateToView);
														$grandtotal_und_exp = $grandtotal_und_payroll->GRANDTOTAL_PNLCATEGORY + $grandtotal_und_opr_exp->GRANDTOTAL_PNLCATEGORY;
													?>	
													<strong><?php echo number_format($grandtotal_und_exp,0);?></strong>
												</td>
												<td class='rata-kanan'> 
													<strong>
														<?php
															if($grandtotal_und_exp !=0 && $grandtotal_totalsales->GRANDTOTAL_PNLCATEGORY != 0){
																echo number_format(($grandtotal_und_exp/$grandtotal_totalsales->GRANDTOTAL_PNLCATEGORY)*100,2).'%';
															}else{
																echo '0%';
															}
															
														?>
													</strong>
												</td>

												<?php for($month= 1; $month<=12; $month++ ){ ?>					
													<td  class='rata-kanan'> 
														<strong>
															<?php $total_und_payroll = $this->Smartreport_pnl_model->get_total_pnlcategorybymonth('7', $idhotel_custom, $month, $dateToView); 
															$total_und_opr_exp = $this->Smartreport_pnl_model->get_total_pnlcategorybymonth('8', $idhotel_custom, $month, $dateToView); 
															$total_und_exp =  $total_und_payroll->TOTAL_PNLCATEGORYBYMONTH + $total_und_opr_exp->TOTAL_PNLCATEGORYBYMONTH;
															echo number_format($total_und_exp ,0); ?>	
														 </strong>													
													</td>
												<?php } ?> 
											</tr>
											
											<tr>
												<td><strong>GROSS OPERATING PROFIT</strong></td>
												<td class='rata-kanan'>
													<?php 
														$grandtotal_dept_profit = $this->Smartreport_pnl_model->get_grandtotal_pnlcategory('6', $idhotel_custom, $dateToView);
														$grandtotal_und_payroll = $this->Smartreport_pnl_model->get_grandtotal_pnlcategory('7', $idhotel_custom, $dateToView);
														$grandtotal_und_opr_exp = $this->Smartreport_pnl_model->get_grandtotal_pnlcategory('8', $idhotel_custom, $dateToView);
														$grandtotal_gross_opr_profit = $grandtotal_dept_profit->GRANDTOTAL_PNLCATEGORY - ($grandtotal_und_payroll->GRANDTOTAL_PNLCATEGORY + $grandtotal_und_opr_exp->GRANDTOTAL_PNLCATEGORY);														
													?>	
													<strong><?php echo number_format($grandtotal_gross_opr_profit,0);?></strong>
												</td>
												<td class='rata-kanan'>
													<strong>
														<?php
															if($grandtotal_gross_opr_profit != 0 && $grandtotal_totalsales->GRANDTOTAL_PNLCATEGORY != 0){
																echo number_format(($grandtotal_gross_opr_profit/$grandtotal_totalsales->GRANDTOTAL_PNLCATEGORY)*100,2).'%';
															}else{
																echo '0%';
															}
															
														?>
													</strong>
												</td>

												<?php for($month= 1; $month<=12; $month++ ){ ?>					
													<td  class='rata-kanan'> 
														<strong>
															<?php $total_dept_profit = $this->Smartreport_pnl_model->get_total_pnlcategorybymonth('6', $idhotel_custom, $month, $dateToView); 
															$total_und_payroll = $this->Smartreport_pnl_model->get_total_pnlcategorybymonth('7', $idhotel_custom, $month, $dateToView); 
															$total_und_opr_exp = $this->Smartreport_pnl_model->get_total_pnlcategorybymonth('8', $idhotel_custom, $month, $dateToView);
															$gross_opr_profit = $total_dept_profit->TOTAL_PNLCATEGORYBYMONTH - ($total_und_payroll->TOTAL_PNLCATEGORYBYMONTH + $total_und_opr_exp->TOTAL_PNLCATEGORYBYMONTH);
															echo number_format($gross_opr_profit ,0); ?>	
														 </strong>													
													</td>
												<?php } ?> 
											</tr>

											<tr>
												<td><strong>G.O.P. %</strong></td>
												<td></td>
												<td class='rata-kanan'>
													<?php 
														$grandtotal_total_sales = $this->Smartreport_pnl_model->get_grandtotal_pnlcategory('2', $idhotel_custom, $dateToView);
														$grandtotal_dept_profit = $this->Smartreport_pnl_model->get_grandtotal_pnlcategory('6', $idhotel_custom, $dateToView);
														$grandtotal_und_payroll = $this->Smartreport_pnl_model->get_grandtotal_pnlcategory('7', $idhotel_custom, $dateToView);
														$grandtotal_und_opr_exp = $this->Smartreport_pnl_model->get_grandtotal_pnlcategory('8', $idhotel_custom, $dateToView);
														
														$grandtotal_gross_opr_profit = $grandtotal_dept_profit->GRANDTOTAL_PNLCATEGORY - ($grandtotal_und_payroll->GRANDTOTAL_PNLCATEGORY + $grandtotal_und_opr_exp->GRANDTOTAL_PNLCATEGORY);	
														if($grandtotal_gross_opr_profit != 0 && $grandtotal_total_sales->GRANDTOTAL_PNLCATEGORY !=0){
															$grandtotal_gop = ($grandtotal_gross_opr_profit / $grandtotal_total_sales->GRANDTOTAL_PNLCATEGORY)*100;	
														}else{
															$grandtotal_gop = 0;
														}
																										
													?>	
													<strong><?php echo number_format($grandtotal_gop,2).'%';?></strong>
												</td>
												

												<?php for($month= 1; $month<=12; $month++ ){ ?>					
													<td  class='rata-kanan'> 
														<strong>
															<?php 
															$total_sales = $this->Smartreport_pnl_model->get_total_pnlcategorybymonth('2', $idhotel_custom, $month, $dateToView); 
															$total_dept_profit = $this->Smartreport_pnl_model->get_total_pnlcategorybymonth('6', $idhotel_custom, $month, $dateToView); 
															$total_und_payroll = $this->Smartreport_pnl_model->get_total_pnlcategorybymonth('7', $idhotel_custom, $month, $dateToView); 
															$total_und_opr_exp = $this->Smartreport_pnl_model->get_total_pnlcategorybymonth('8', $idhotel_custom, $month, $dateToView);

															if($total_dept_profit->TOTAL_PNLCATEGORYBYMONTH != 0 && $total_und_payroll->TOTAL_PNLCATEGORYBYMONTH !=0 && $total_und_opr_exp->TOTAL_PNLCATEGORYBYMONTH != 0 && $total_sales->TOTAL_PNLCATEGORYBYMONTH != 0 ){
																$gross_opr_profit = $total_dept_profit->TOTAL_PNLCATEGORYBYMONTH - ($total_und_payroll->TOTAL_PNLCATEGORYBYMONTH + $total_und_opr_exp->TOTAL_PNLCATEGORYBYMONTH);
																$gop = ($gross_opr_profit / $total_sales->TOTAL_PNLCATEGORYBYMONTH )*100;
																echo number_format($gop ,2).'%';
															}else{
																echo '0%';
															} ?>	
														 </strong>													
													</td>
												<?php } ?> 
											</tr>

											<tr>
												<td><strong>PAYROLL</strong></td>
												<td></td>
												<td class="rata-kanan">
													<?php
													$grandtotal_total_sales = $this->Smartreport_pnl_model->get_grandtotal_pnlcategory('2', $idhotel_custom, $dateToView);
													$grandtotal_payroll_rel = $this->Smartreport_pnl_model->get_grandtotal_pnlcategory('4', $idhotel_custom, $dateToView);
													$grandtotal_und_payroll = $this->Smartreport_pnl_model->get_grandtotal_pnlcategory('7', $idhotel_custom, $dateToView);
													if($grandtotal_payroll_rel->GRANDTOTAL_PNLCATEGORY != 0 && $grandtotal_und_payroll->GRANDTOTAL_PNLCATEGORY != 0 && $grandtotal_total_sales->GRANDTOTAL_PNLCATEGORY !=0){
														$grandtotal_all_payroll = (($grandtotal_payroll_rel->GRANDTOTAL_PNLCATEGORY + $grandtotal_und_payroll->GRANDTOTAL_PNLCATEGORY)  / $grandtotal_total_sales->GRANDTOTAL_PNLCATEGORY)*100;
													}else{
														$grandtotal_all_payroll = 0;
													}
													
													
													?>
													<strong><?php echo number_format($grandtotal_all_payroll,2).'%';?></strong>
												</td>
												

												<?php for($month= 1; $month<=12; $month++ ){ ?>					
													<td  class='rata-kanan'> 
														<strong>
															<?php 
															$total_sales = $this->Smartreport_pnl_model->get_total_pnlcategorybymonth('2', $idhotel_custom, $month, $dateToView); 
															$total_payroll_rel = $this->Smartreport_pnl_model->get_total_pnlcategorybymonth('4', $idhotel_custom, $month, $dateToView);  
															$total_und_payroll = $this->Smartreport_pnl_model->get_total_pnlcategorybymonth('7', $idhotel_custom, $month, $dateToView); 
															if($total_payroll_rel->TOTAL_PNLCATEGORYBYMONTH !=0 && $total_und_payroll->TOTAL_PNLCATEGORYBYMONTH !=0 && $total_sales->TOTAL_PNLCATEGORYBYMONTH !=0){
																$total_all_payroll = (($total_payroll_rel->TOTAL_PNLCATEGORYBYMONTH + $total_und_payroll->TOTAL_PNLCATEGORYBYMONTH)  / $total_sales->TOTAL_PNLCATEGORYBYMONTH)*100;															
																echo number_format($total_all_payroll,2).'%';
															}else{
																echo '0%';
															} ?>	
														 </strong>													
													</td>
												<?php } ?> 
											</tr>

											<tr>
												<td><strong>ENERGY COST</strong></td>
												<td></td>
												<td class="rata-kanan">
													<?php
													$grandtotal_total_sales = $this->Smartreport_pnl_model->get_grandtotal_pnlcategory('2', $idhotel_custom, $dateToView);
													$grandtotal_energy_cost = $this->Smartreport_pnl_model->get_total_budget('22', $idhotel_custom, $dateToView);
													if($grandtotal_energy_cost->TOTAL_BUDGET != 0 && $grandtotal_total_sales->GRANDTOTAL_PNLCATEGORY != 0 ){
														$grandtotal_budget_energycost = ($grandtotal_energy_cost->TOTAL_BUDGET / $grandtotal_total_sales->GRANDTOTAL_PNLCATEGORY)*100;	
													}else{
														$grandtotal_budget_energycost = 0;
													}
																									
													?>
													<strong><?php echo number_format($grandtotal_budget_energycost,2).'%';?></strong>
												</td>

												<?php for($month= 1; $month<=12; $month++ ){ ?>																
													<td class="rata-kanan">
													<strong>
														<?php 
														
														$total_sales = $this->Smartreport_pnl_model->get_total_pnlcategorybymonth('2', $idhotel_custom, $month, $dateToView); 
														$energy_cost = $this->Smartreport_pnl_model->get_data_budget('22', $idhotel_custom, $month, $dateToView);
														if($energy_cost->BUDGET !=0 && $total_sales->TOTAL_PNLCATEGORYBYMONTH !=0 ){
															$budget_energycost = ($energy_cost->BUDGET / $total_sales->TOTAL_PNLCATEGORYBYMONTH)*100;
															echo number_format($budget_energycost,2).'%';
														}else{
															echo '0%';
														}
														?>
													</strong>	
													</td>  
												<?php } ?>    
											</tr>

											<tr>
												<td><strong>EXPENSE</strong></td>
												<td></td>
												<td class="rata-kanan">
													<?php
														$grandtotal_total_sales = $this->Smartreport_pnl_model->get_grandtotal_pnlcategory('2', $idhotel_custom, $dateToView);
														$grandtotal_other_expense = $this->Smartreport_pnl_model->get_grandtotal_pnlcategory('5', $idhotel_custom, $dateToView);
														$grandtotal_ang_und_exp = $this->Smartreport_pnl_model->get_total_budget('20', $idhotel_custom, $dateToView);
														$grandtotal_pomec_und_exp = $this->Smartreport_pnl_model->get_total_budget('21', $idhotel_custom, $dateToView);
														$grandtotal_snm_und_exp = $this->Smartreport_pnl_model->get_total_budget('23', $idhotel_custom, $dateToView);
														if($grandtotal_ang_und_exp->TOTAL_BUDGET !=0 && $grandtotal_pomec_und_exp->TOTAL_BUDGET !=0 && $grandtotal_snm_und_exp->TOTAL_BUDGET !=0 &&  $grandtotal_other_expense->GRANDTOTAL_PNLCATEGORY !=0 && $grandtotal_total_sales->GRANDTOTAL_PNLCATEGORY !=0 ){
															$grandtotal_budget_expense = (($grandtotal_ang_und_exp->TOTAL_BUDGET + $grandtotal_pomec_und_exp->TOTAL_BUDGET + $grandtotal_snm_und_exp->TOTAL_BUDGET + $grandtotal_other_expense->GRANDTOTAL_PNLCATEGORY)/$grandtotal_total_sales->GRANDTOTAL_PNLCATEGORY)*100;
														}else{
															$grandtotal_budget_expense = 0;
														}
																												
													?>
													<strong><?php echo number_format($grandtotal_budget_expense,2).'%';?></strong>
												</td>

												<?php for($month= 1; $month<=12; $month++ ){ ?>																
													<td class="rata-kanan">
													<strong>
														<?php 
														$total_sales = $this->Smartreport_pnl_model->get_total_pnlcategorybymonth('2', $idhotel_custom, $month, $dateToView); 
														$other_expense = $this->Smartreport_pnl_model->get_total_pnlcategorybymonth('5', $idhotel_custom, $month, $dateToView); 
														$ang_und_exp = $this->Smartreport_pnl_model->get_data_budget('20', $idhotel_custom, $month, $dateToView);
														$pomec_und_exp = $this->Smartreport_pnl_model->get_data_budget('21', $idhotel_custom, $month, $dateToView);
														$snm_und_exp = $this->Smartreport_pnl_model->get_data_budget('23', $idhotel_custom, $month, $dateToView);
														if($ang_und_exp->BUDGET !=0 && $pomec_und_exp->BUDGET !=0 && $snm_und_exp->BUDGET !=0 && $other_expense->TOTAL_PNLCATEGORYBYMONTH !=0 && $total_sales->TOTAL_PNLCATEGORYBYMONTH !=0){
															$budget_expense = (($ang_und_exp->BUDGET + $pomec_und_exp->BUDGET + $snm_und_exp->BUDGET + $other_expense->TOTAL_PNLCATEGORYBYMONTH)/$total_sales->TOTAL_PNLCATEGORYBYMONTH)*100;
															echo number_format($budget_expense,2).'%';
														}else{
															echo '0%';
														}
														?>
													</strong>	
													</td>  
												<?php } ?>   
											</tr>

											<tr>
												<td><strong>COST OF SALES</strong></td>
												<td></td>
												<td class="rata-kanan">
													<?php
														$grandtotal_total_sales = $this->Smartreport_pnl_model->get_grandtotal_pnlcategory('2', $idhotel_custom, $dateToView);
														$grandtotal_cost_of_sales = $this->Smartreport_pnl_model->get_grandtotal_pnlcategory('3', $idhotel_custom, $dateToView);
														if($grandtotal_cost_of_sales->GRANDTOTAL_PNLCATEGORY !=0 && $grandtotal_total_sales->GRANDTOTAL_PNLCATEGORY !=0){
															$grandtotal_budget_cos = ($grandtotal_cost_of_sales->GRANDTOTAL_PNLCATEGORY / $grandtotal_total_sales->GRANDTOTAL_PNLCATEGORY)*100;
														}else{
															$grandtotal_budget_cos = 0;
														}
														
													?>
													<strong><?php echo number_format($grandtotal_budget_cos,2).'%';?></strong>
												</td>
												
												<?php for($month= 1; $month<=12; $month++ ){ ?>																
													<td class="rata-kanan">
													<strong>
														<?php 
														$total_sales = $this->Smartreport_pnl_model->get_total_pnlcategorybymonth('2', $idhotel_custom, $month, $dateToView); 
														$cost_of_sales = $this->Smartreport_pnl_model->get_total_pnlcategorybymonth('3', $idhotel_custom, $month, $dateToView); 
														if($cost_of_sales->TOTAL_PNLCATEGORYBYMONTH !=0 && $total_sales->TOTAL_PNLCATEGORYBYMONTH !=0){
															$budget_cos = ($cost_of_sales->TOTAL_PNLCATEGORYBYMONTH / $total_sales->TOTAL_PNLCATEGORYBYMONTH)*100;
															echo number_format($budget_cos,2).'%';
														}else{
															echo '0%';
														}
														?>
													</strong>	
													</td>  
												<?php } ?> 
												
											</tr>

											<tr>
												<td><strong>MARKETING EXPENSE</strong></td>
												<td></td>
												<td class="rata-kanan">
													<?php
														$grandtotal_total_sales = $this->Smartreport_pnl_model->get_grandtotal_pnlcategory('2', $idhotel_custom, $dateToView);
														$grandtotal_snm_und_exp = $this->Smartreport_pnl_model->get_total_budget('23', $idhotel_custom, $dateToView);
														if($grandtotal_snm_und_exp->TOTAL_BUDGET != 0 && $grandtotal_total_sales->GRANDTOTAL_PNLCATEGORY != 0){
															$grandtotal_budget_salesmarketing = ($grandtotal_snm_und_exp->TOTAL_BUDGET / $grandtotal_total_sales->GRANDTOTAL_PNLCATEGORY)*100;
														}else{
															$grandtotal_budget_salesmarketing = 0;
														}
														
													?>
													<strong><?php echo number_format($grandtotal_budget_salesmarketing,2).'%';?></strong>
												</td>

												<?php for($month= 1; $month<=12; $month++ ){ ?>																
													<td class="rata-kanan">
													<strong>
														<?php 
														$total_sales = $this->Smartreport_pnl_model->get_total_pnlcategorybymonth('2', $idhotel_custom, $month, $dateToView); 														
														$snm_und_exp = $this->Smartreport_pnl_model->get_data_budget('23', $idhotel_custom, $month, $dateToView);
														if($snm_und_exp->BUDGET != 0 && $total_sales->TOTAL_PNLCATEGORYBYMONTH !=0){
															$budget_salesmarketing = ($snm_und_exp->BUDGET / $total_sales->TOTAL_PNLCATEGORYBYMONTH)*100;
															echo number_format($budget_salesmarketing,2).'%';
														}else{
															echo '0%';
														}
														?>
													</strong>	
													</td>  
												<?php } ?>   
											</tr>
									</tbody>
								</table>
							</div>
						</div>

						<div class="tab-pane fade" id="right-pnl2">							
							<form action="<?php echo base_url()?>smartreportpnl/insert_budget_pnl" method="post" accept-charset="utf-8" enctype="multipart/form-data">								
								<div class="col-md-6">	
									<div class="form-group">
										<div class="row">
										<?php if($user_le === '1' ){ ?>
											<div class="col-md-4">
												<div class="form-group">
												<label><?php echo $lang_hotel ?></label>								
													<select name="idhotelcustom" class="form-control custom_select" required autocomplete="off">
														<option value=""><?php echo $lang_choose_hotels; ?></option>
														<?php $hotel = $idhotel_custom;
															$hotelData = $this->Smartreport_hotels_model->getDataParent('smartreport_hotels', 'idhotels','PARENT', 'ASC');
															for ($p = 0; $p < count($hotelData); ++$p) {
																$idhotel = $hotelData[$p]->idhotels;
																$hotelname = $hotelData[$p]->hotels_name;?>
														<option value="<?php echo $idhotel; ?>" <?php if ($hotel == $idhotel) {	echo 'selected="selected"';	} ?>>
															<?php echo $hotelname; ?>
														</option>
														<?php
															unset($idhotel);
															unset($hotelname);
															}
														?>
													</select>									
												</div>

											</div>
											<?php } ?> 
											<div class="col-sm-4">
												<label><?php echo $lang_month; ?></label>
													<select name="month_budget" class="form-control" required>
														<option  value="" >--  <?php echo $lang_select_month;?> --</option>
														<option value="01">January</option>
														<option value="02">February</option>
														<option value="03">March</option>
														<option value="04">April</option>
														<option value="05">May</option>
														<option value="06">June</option>
														<option value="07">July</option>
														<option value="08">August</option>
														<option value="09">September</option>
														<option value="10">October</option>
														<option value="11">November</option>
														<option value="12">December</option>
													</select>
											</div>
                                            <div class="col-sm-3">
												<label><?php echo $lang_year ?></label>
												<select name="year_budget" class="form-control" required>
												<option value="">-- <?php echo $lang_select_year;?> --</option>
													<?php
														for($i=date('Y'); $i>=2018; $i--) {
														$selected = '';
														if ($tahun == $i) $selected = ' selected="selected"';
														print('<option value="'.$i.'"'.$selected.'>'.$i.'</option>'."\n");
													}?>
												</select>  
											</div>
                                            
                                        </div>
                                    </div> 
								</div>	
								<div class="table-responsive">
									<table class="table text-nowrap table-hover table-xs">
										<thead>
											<tr>
												<th><?php echo $lang_description; ?></th>
												<th></th>												
											</tr>
										</thead>
										
										<tbody>										
										<?php
											foreach ($smartreport_pnlcategory_data as $smartreport_pnlcategory){?>
											<tr>
                                                <td><strong><?= $smartreport_pnlcategory->pnl_category;?></strong></td>	    
                                                <td>&nbsp;</td>                                            												
                                            </tr>
                                                <?php $smartreport_pnllist_data = $this->Smartreport_pnl_model->select_pnllist_percategory($smartreport_pnlcategory->idpnlcategory);
                                                      foreach ($smartreport_pnllist_data as $smartreport_pnllist ){?>
                                                        <tr>
                                                            <td>&emsp;&emsp;<?= $smartreport_pnllist->pnl_name;?></td>
                                                            <td>
																<input type="hidden" name="idpnl[]" value="<?php echo $smartreport_pnllist->idpnl;?>">
																<input type="text" onkeypress="return isNumberKeyDash(event)" name="budget_value[]" class="form-control" required>
															</td>                                             
                                                        </tr>
                                                <?php }?>
											<?php } ?>
										</tbody>
									</table>
									<div class="text-center">
										<button type="submit" class="btn bg-teal-400" ><?php echo $lang_submit;?></button>
									</div>
								
								</div>
							</form>
						</div>
						

						<div class="tab-pane fade" id="right-pnl3">
							<form action="<?php echo base_url()?>smartreportpnl/add_budget_data_bypnl" method="post" accept-charset="utf-8">
								<div class="col-md-7">
								<?php if($user_le === '1' ){ ?>
									<div class="form-group row">
										<label class="col-form-label col-lg-2"><strong><?php echo $lang_hotel; ?></strong></label>
										<div class="col-lg-10">
											<div class="input-group">												
												<select name="idhotelcustom" class="form-control custom_select" required autocomplete="off">
													<option value=""><?php echo $lang_choose_hotels; ?></option>
													<?php $hotel = $idhotel_custom;
														$hotelData = $this->Smartreport_hotels_model->getDataParent('smartreport_hotels', 'idhotels','PARENT', 'ASC');
														for ($p = 0; $p < count($hotelData); ++$p) {
															$idhotel = $hotelData[$p]->idhotels;
															$hotelname = $hotelData[$p]->hotels_name;?>
													<option value="<?php echo $idhotel; ?>" <?php if ($hotel == $idhotel) {	echo 'selected="selected"';	} ?>>
														<?php echo $hotelname; ?>
													</option>
													<?php
														unset($idhotel);
														unset($hotelname);
														}
													?>
												</select>	
											</div>
										</div>
									</div>
									<?php } ?>

									<div class="form-group row">
										<label class="col-form-label col-lg-2"><strong><?php echo $lang_month; ?></strong></label>
										<div class="col-lg-10">
											<div class="input-group">												
												<select name="month_budget" class="form-control" required>
														<option  value="" >--  <?php echo $lang_select_month;?> --</option>
														<option  value="01">January</option>
														<option  value="02">February</option>
														<option  value="03">March</option>
														<option  value="04">April</option>
														<option  value="05">May</option>
														<option  value="06">June</option>
														<option  value="07">July</option>
														<option  value="08">August</option>
														<option  value="09">September</option>
														<option  value="10">October</option>
														<option  value="11">November</option>
														<option  value="12">December</option>
												</select>
											</div>
										</div>
									</div>

									<div class="form-group row">
										<label class="col-form-label col-lg-2"><strong><label><?php echo $lang_year ?></label></strong></label>
										<div class="col-lg-10">
											<div class="input-group">	
												<select name="year_budget" class="form-control" required>
													<option value="">-- <?php echo $lang_select_year;?> --</option>
													<?php
														for($i=date('Y'); $i>=2018; $i--) {														
														print('<option value="'.$i.'"'.$selected.'>'.$i.'</option>'."\n");
													}?>
												</select>  
											</div>
										</div>
									</div>

									<div class="form-group row">
										<label class="col-form-label col-lg-2"><strong><?php echo $lang_pnl_category; ?></strong></label>
										<div class="col-lg-10">
											<div class="input-group">												
											<select name="idpnlcategory" class="form-control" required id="categorypnl" autocomplete="off">
													<option value=""><?php echo $lang_choose_pnl_category; ?></option>
												<?php
													$pnlcategoryData = $this->Smartreport_pnl_model->getDataAll('smartreport_pnlcategory', 'idpnlcategory', 'ASC');
													for ($p = 0; $p < count($pnlcategoryData); ++$p) {
														$idpnlcategory = $pnlcategoryData[$p]->idpnlcategory;
														$pnlcategoryname = $pnlcategoryData[$p]->pnl_category;?>
														<option  value="<?php echo $idpnlcategory; ?>">
															<?php echo $pnlcategoryname; ?>
														</option>
												<?php
														unset($idpnlcategory);
														unset($pnlcategoryname);
													}
												?>
												</select>
											</div>
										</div>
									</div>
									
									<div class="form-group row">
										<label class="col-form-label col-lg-2"><strong><?php echo $lang_pnl_list; ?></strong></label>
										<div class="col-lg-10">
											<div class="input-group">												
											<select class="form-control" id="pnllist" name="idpnllist" required>
												<option value=""><?php echo $lang_choose_pnl_list;?></option>

											</select>
											</div>
										</div>
									</div>

									<div class="form-group row">
										<label class="col-form-label col-lg-2"><strong><?php echo $lang_budget; ?></strong></label>
										<div class="col-lg-10">
											<div class="input-group">												
												<input type="text" onkeypress="return isNumberKeyDash(event)" name="budget_value" class="form-control" required>
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