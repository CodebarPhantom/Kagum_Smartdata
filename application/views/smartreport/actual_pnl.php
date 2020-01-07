<style>
.form-control:focus {

	border-color: #009688;
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

    $lm=strtotime("-1 Month");
    $ly=strtotime("-1 Year");

	if ($yearact == NULL && $monthact == NULL){
        $yearact = date('Y');
        $monthact = date('m');
        $lastmonth = date('m',$lm);
        $lastyear = date('Y',$ly);
	}else if ($monthact == '01'){//jika difilter adalah bulan januari 2019 maka last monthnya adalah desember 2018 tahun sebelumnya
         $lastmonth = '12' ;
         $lastyear = $yearact - 1;
    }else{
        $lastmonth = $monthact - 1;
    }

    $dayInMonth = cal_days_in_month(CAL_GREGORIAN,$monthact, $yearact);
    $dayInMonthLast = cal_days_in_month(CAL_GREGORIAN,$lastmonth, $yearact);
    $startdate_ytd = $yearact.'-01-'.'01';
	$enddate_ytd = $yearact.'-'.$monthact.'-'.$dayInMonth;
    $diffdateytd = date_diff(new DateTime($startdate_ytd), new DateTime($enddate_ytd)); 
   
    $url_year = $yearact;
    $url_monthact = $monthact;
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
    
$arr_actual_ytd =0;

$total_rooms = $this->Dashboard_model->getDataHotel($idhotel_custom);
$trr_actual_mtd = $this->Smartreport_actual_model->get_total_actual( "4", $idhotel_custom, $monthact, $yearact); //4 adalah idpnl Room
$rs_actual_mtd = $this->Smartreport_actual_model->get_total_actual( "7", $idhotel_custom, $monthact, $yearact); //7 adalah idpnl occupied room / room sold
$trr_budget_mtd = $this->Smartreport_actual_model->get_total_budget( "4", $idhotel_custom, $monthact, $yearact); //4 adalah idpnl Room
$rs_budget_mtd = $this->Smartreport_actual_model->get_total_budget( "7", $idhotel_custom, $monthact, $yearact); //7 adalah idpnl occupied room / room sold

if ($monthact == '01'){ //jika difilter adalah bulan januari 2019 maka last monthnya adalah desember 2018 tahun sebelumnya
    $trr_actual_lastmtd = $this->Smartreport_actual_model->get_total_actual( "4", $idhotel_custom, $lastmonth, $lastyear); //4 adalah idpnl Room
	$rs_actual_lastmtd = $this->Smartreport_actual_model->get_total_actual( "7", $idhotel_custom, $lastmonth, $lastyear); //7 adalah idpnl occupied room / room sold
	$trr_budget_lastmtd = $this->Smartreport_actual_model->get_total_budget( "4", $idhotel_custom, $lastmonth, $lastyear); //4 adalah idpnl Room
    $rs_budget_lastmtd = $this->Smartreport_actual_model->get_total_budget( "7", $idhotel_custom, $lastmonth, $lastyear); //7 adalah idpnl occupied room / room sold
    
}else{
    $trr_actual_lastmtd = $this->Smartreport_actual_model->get_total_actual( "4", $idhotel_custom, $lastmonth, $yearact); //4 adalah idpnl Room
	$rs_actual_lastmtd = $this->Smartreport_actual_model->get_total_actual( "7", $idhotel_custom, $lastmonth, $yearact); //7 adalah idpnl occupied room / room sold
	$trr_budget_lastmtd = $this->Smartreport_actual_model->get_total_budget( "4", $idhotel_custom, $lastmonth, $yearact); //4 adalah idpnl Room
    $rs_budget_lastmtd = $this->Smartreport_actual_model->get_total_budget( "7", $idhotel_custom, $lastmonth, $yearact); //7 adalah idpnl occupied room / room sold
}

$trr_actual_ytd = $this->Smartreport_actual_model->get_total_actual_ytd( "4", $idhotel_custom, $startdate_ytd, $enddate_ytd); //4 adalah idpnl Room
$rs_actual_ytd = $this->Smartreport_actual_model->get_total_actual_ytd( "7", $idhotel_custom, $startdate_ytd, $enddate_ytd); //7 adalah idpnl occupied room / room sold
$trr_budget_ytd = $this->Smartreport_actual_model->get_total_budget_ytd( "4", $idhotel_custom, $startdate_ytd, $enddate_ytd); //4 adalah idpnl Room
$rs_budget_ytd = $this->Smartreport_actual_model->get_total_budget_ytd( "7", $idhotel_custom, $startdate_ytd, $enddate_ytd); //7 adalah idpnl occupied room / room sold



function cal_days_in_year($yearact){
	$days=0; 
	for($month=1;$month<=12;$month++){ 
			$days = $days + cal_days_in_month(CAL_GREGORIAN,$month,$yearact);
		}
	return $days;
	}
	
?>
<!-- Page header -->
        <div class="page-header page-header-light">
				<div class="page-header-content header-elements-md-inline">
					<div class="page-title d-flex">
						<h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold"><?php echo $lang_pnl; ?></span> - <?php echo $lang_pnl_expense; ?></h4>
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
					<h6 class="card-title"><strong><?php  $hotel = $this->Dashboard_model->getDataHotel($idhotel_custom); echo $hotel->hotels_name .' - '.$lang_pnl_expense; ?></strong></h6>
					<div class="header-elements">
						<div class="list-icons">
				            <a class="list-icons-item" data-action="collapse"></a>
				            
				        </div>
			        </div>
				</div>
				
				<div class="card-body">
					<ul class="nav nav-tabs nav-tabs-highlight justify-content-end">
						<li class="nav-item"><a href="#right-pnl1" class="nav-link active" data-toggle="tab"><i class="icon-stats-dots mr-2"></i><?php echo $lang_actual_data?></a></li>
						<li class="nav-item"><a href="#right-pnl2" class="nav-link" data-toggle="tab"><i class="icon-stack-plus mr-2"></i><?php echo $lang_add_data?></a></li>
						<li class="nav-item"><a href="#right-pnl3" class="nav-link" data-toggle="tab"><i class="icon-plus3 mr-2"></i><?php echo $lang_add_data_bypnl?></a></li>	
					</ul>

				    <div class="tab-content">
						
						<div class="tab-pane fade show active" id="right-pnl1">
							<form action="<?php echo base_url()?>smartreportpnl/actual_pnl" method="get" accept-charset="utf-8" enctype="multipart/form-data">		
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
													<select name="month_actual" class="form-control" required>
														<option <?php if ($monthact === '01') {echo 'selected="selected"';} ?> value="01">January</option>
														<option <?php if ($monthact === '02') {echo 'selected="selected"';} ?> value="02">February</option>
														<option <?php if ($monthact === '03') {echo 'selected="selected"';} ?> value="03">March</option>
														<option <?php if ($monthact === '04') {echo 'selected="selected"';} ?> value="04">April</option>
														<option <?php if ($monthact === '05') {echo 'selected="selected"';} ?> value="05">May</option>
														<option <?php if ($monthact === '06') {echo 'selected="selected"';} ?> value="06">June</option>
														<option <?php if ($monthact === '07') {echo 'selected="selected"';} ?> value="07">July</option>
														<option <?php if ($monthact === '08') {echo 'selected="selected"';} ?> value="08">August</option>
														<option <?php if ($monthact === '09') {echo 'selected="selected"';} ?> value="09">September</option>
														<option <?php if ($monthact === '10') {echo 'selected="selected"';} ?> value="10">October</option>
														<option <?php if ($monthact === '11') {echo 'selected="selected"';} ?> value="11">November</option>
														<option <?php if ($monthact === '12') {echo 'selected="selected"';} ?> value="12">December</option>
													</select>
											</div>										
                                            <div class="col-sm-3">
												<label><?php echo $lang_year ?></label>
												<select name="year_actual" class="form-control" required>
													<?php
														for($i=date('Y'); $i>=2018; $i--) {
														$selected = '';
														if ($yearact == $i) $selected = ' selected="selected"';
														print('<option value="'.$i.'"'.$selected.'>'.$i.'</option>'."\n");
													}?>
												</select>  
											</div>

											

											<div class="col-sm-1">
												<div class="form-group">
													<label>&emsp;</label><br/>
													<button type="submit" class="btn bg-teal-400 "><?php echo $lang_search; ?></button>
												</div>
											</div>
                                            
                                        </div>
                                    </div> 
								</div>
							</form>	
							<div class="table-responsive">
								<table class="table table-bordered text-nowrap table-hover table-xs customEryan datatable-nobutton-1column">
									<thead style="vertical-align: middle; text-align: center">
										<tr >
											<th rowspan="2"><?php echo $lang_description; ?></th>											
											<th colspan="5">MTD</th>											
											<th colspan="5">LAST MONTH</th>
											<th colspan="5">YTD</th>																						
										</tr>
										<tr>
											<td>Actual</td>
                                            <td>(%)</td>
                                            <td>Budget</td>
                                            <td>(%)</td>
                                            <td>Variance</td>

                                            <td>Actual</td>
                                            <td>(%)</td>
                                            <td>Budget</td>
                                            <td>(%)</td>
                                            <td>Variance</td>

                                            <td>Actual</td>
                                            <td>(%)</td>
                                            <td>Budget</td>
                                            <td>(%)</td>
                                            <td>Variance</td>
										</tr>
									</thead>
									<tbody>
											<tr>
												<td><strong>STATISCTIC</strong></td>
												<td colspan="15"></td>
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
											
											<!--Number of Days-->
											<tr>
                                                <td>&emsp;&emsp;Number of Days</td>
                                                
												<td class="rata-kanan"><?= $dayInMonth; ?></td>
												<td class="rata-kanan">-</td>												
                                                <td class="rata-kanan"><?= $dayInMonth; ?></td>
                                                <td class="rata-kanan">-</td>	
                                                <td class="rata-kanan">-</td>	

                                                <td class="rata-kanan"><?= $dayInMonthLast; ?></td>
												<td class="rata-kanan">-</td>												
                                                <td class="rata-kanan"><?= $dayInMonthLast; ?></td>
                                                <td class="rata-kanan">-</td>	
                                                <td class="rata-kanan">-</td>	

                                                <td class="rata-kanan"><?= $diffdateytd->days + 1 ;?></td>
												<td class="rata-kanan">-</td>												
                                                <td class="rata-kanan"><?= $diffdateytd->days + 1 ;?></td>
                                                <td class="rata-kanan">-</td>	
                                                <td class="rata-kanan">-</td>	
																							
											</tr>
											
											<!--Number of Rooms Available-->
											<tr>
                                                <td>&emsp;&emsp;Number of Rooms Available</td>
                                                
												<td class="rata-kanan"><?= $dayInMonth * $total_rooms->total_rooms; ?></td>
												<td class="rata-kanan">-</td>												
                                                <td class="rata-kanan"><?= $dayInMonth * $total_rooms->total_rooms; ?></td>
                                                <td class="rata-kanan">-</td>	
                                                <td class="rata-kanan">-</td>	

                                                <td class="rata-kanan"><?= $dayInMonthLast * $total_rooms->total_rooms; ?></td>
												<td class="rata-kanan">-</td>												
                                                <td class="rata-kanan"><?= $dayInMonthLast * $total_rooms->total_rooms; ?></td>
                                                <td class="rata-kanan">-</td>	
                                                <td class="rata-kanan">-</td>		

                                                <td class="rata-kanan"><?= ($diffdateytd->days + 1) * $total_rooms->total_rooms; ?></td>
												<td class="rata-kanan">-</td>												
                                                <td class="rata-kanan"><?=($diffdateytd->days + 1) * $total_rooms->total_rooms;?></td>
                                                <td class="rata-kanan">-</td>	
                                                <td class="rata-kanan">-</td>	

												
											</tr>
											
											<!--Occupancy-->
											<tr>
                                                <td>&emsp;&emsp;% of Occupancy</td>
                                                
												<td class="rata-kanan">
													<?php if($total_rooms->total_rooms != 0){
															$occupancy_actual_mtd = ($rs_actual_mtd->TOTAL_ACTUAL / ($dayInMonth * $total_rooms->total_rooms))*100;
															echo number_format($occupancy_actual_mtd,2).'%';}?>
												</td>
												<td class="rata-kanan">-</td>																								
                                                <td class="rata-kanan">
													<?php if($total_rooms->total_rooms != 0){$occupancy_budget_mtd = ($rs_budget_mtd->TOTAL_BUDGET / ($dayInMonth * $total_rooms->total_rooms))*100;
														echo number_format($occupancy_budget_mtd,2).'%';}?> 
												</td> 
                                                <td class="rata-kanan">-</td>
												<td class="rata-kanan"> 
													<?php if($total_rooms->total_rooms != 0){
													 $variance_occ_mtd = $occupancy_actual_mtd - $occupancy_budget_mtd;
												 	($variance_occ_mtd < 0) ? $textcolor='text-danger-600' : $textcolor='text-success-600';} ?>
													<div class="<?php if($total_rooms->total_rooms != 0){echo $textcolor;} ?>"><?php if($total_rooms->total_rooms != 0){echo number_format($variance_occ_mtd,2).'%';} ?></div>
												</td> 

                                                <td class="rata-kanan">
														<?php if($total_rooms->total_rooms != 0){$occupancy_actual_lastmtd = ($rs_actual_lastmtd->TOTAL_ACTUAL / ($dayInMonthLast * $total_rooms->total_rooms))*100;
															echo number_format($occupancy_actual_lastmtd,2).'%';}?>
												</td>
												<td class="rata-kanan">-</td>																								
                                                <td class="rata-kanan">
													<?php if($total_rooms->total_rooms != 0){$occupancy_budget_lastmtd = ($rs_budget_lastmtd->TOTAL_BUDGET / ($dayInMonthLast * $total_rooms->total_rooms))*100;
															echo number_format($occupancy_budget_lastmtd,2).'%';}?>
												</td> 
                                                <td class="rata-kanan">-</td>
                                                <td class="rata-kanan">
													<?php if($total_rooms->total_rooms != 0){
														$variance_occ_lastmtd = $occupancy_actual_lastmtd - $occupancy_budget_lastmtd;
												 	($variance_occ_lastmtd < 0) ? $textcolor='text-danger-600' : $textcolor='text-success-600';} ?>
													<div class="<?php if($total_rooms->total_rooms != 0){echo $textcolor;} ?>"><?php if($total_rooms->total_rooms != 0){echo number_format($variance_occ_lastmtd,2).'%';} ?></div>
												</td> 

                                                <td class="rata-kanan">
													<?php if($total_rooms->total_rooms != 0){$occupancy_actual_ytd = ($rs_actual_ytd->TOTAL_ACTUAL / (($diffdateytd->days + 1) * $total_rooms->total_rooms))*100;
															echo number_format($occupancy_actual_ytd,2).'%';}?></td>
												<td class="rata-kanan">-</td>																								
                                                <td class="rata-kanan">
													<?php if($total_rooms->total_rooms != 0){$occupancy_budget_ytd = ($rs_budget_ytd->TOTAL_BUDGET / (($diffdateytd->days + 1) * $total_rooms->total_rooms))*100;
															echo number_format($occupancy_budget_ytd,2).'%';}?></td> 
                                                <td class="rata-kanan">-</td>
                                                <td class="rata-kanan">
													<?php if($total_rooms->total_rooms != 0){
													$variance_occ_ytd = $occupancy_actual_ytd - $occupancy_budget_ytd;
												 	($variance_occ_ytd < 0) ? $textcolor='text-danger-600' : $textcolor='text-success-600';} ?>
													<div class="<?php if($total_rooms->total_rooms != 0){echo $textcolor;} ?>"><?php if($total_rooms->total_rooms != 0){echo number_format($variance_occ_ytd,2).'%';} ?></div>
												</td> 
												
											</tr>
										<?php foreach ($smartreport_pnlcategory_data as $smartreport_pnlcategory){
												/* Terlalu Dinamis parah, PNL Statistic sudah hilang karena sudah jadi header diatas IDPNLCATEGORY 1 itu adalah STATISTIC*/
												//$yearact itu ada year
												$smartreport_pnllist_data = $this->Smartreport_actual_model->select_pnllist_percategory($smartreport_pnlcategory->idpnlcategory);
												$grandtotal_pnlcategory = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_actual($smartreport_pnlcategory->idpnlcategory, $idhotel_custom, $monthact, $yearact);
												$grandtotal_pnlcategorybudget = $this->Smartreport_actual_model->get_grandtotal_pnlcategorybudget($smartreport_pnlcategory->idpnlcategory, $idhotel_custom, $monthact, $yearact);

												$grandtotal_totalsalesactual= $this->Smartreport_actual_model->get_grandtotal_pnlcategory_actual('2', $idhotel_custom, $monthact, $yearact);
												$grandtotal_totalsalesbudget = $this->Smartreport_actual_model->get_grandtotal_pnlcategorybudget('2', $idhotel_custom, $monthact, $yearact);
                                                if($monthact == '01'){ //jika difilter adalah bulan januari 2019 maka last monthnya adalah desember 2018 tahun sebelumnya
													$grandtotal_pnlcategorylastmtd = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_actual($smartreport_pnlcategory->idpnlcategory, $idhotel_custom, $lastmonth, $lastyear); 
													$grandtotal_pnlcategorybudgetlastmtd = $this->Smartreport_actual_model->get_grandtotal_pnlcategorybudget($smartreport_pnlcategory->idpnlcategory, $idhotel_custom, $lastmonth, $lastyear); 
													
													$grandtotal_totalsalesactual_lastmtd= $this->Smartreport_actual_model->get_grandtotal_pnlcategory_actual('2', $idhotel_custom, $lastmonth, $lastyear);
													$grandtotal_totalsalesbudget_lastmtd = $this->Smartreport_actual_model->get_grandtotal_pnlcategorybudget('2', $idhotel_custom, $lastmonth, $lastyear);
                                                }else{
													$grandtotal_pnlcategorylastmtd = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_actual($smartreport_pnlcategory->idpnlcategory, $idhotel_custom, $lastmonth, $yearact);   
													$grandtotal_pnlcategorybudgetlastmtd = $this->Smartreport_actual_model->get_grandtotal_pnlcategorybudget($smartreport_pnlcategory->idpnlcategory, $idhotel_custom, $lastmonth, $yearact);
													
													$grandtotal_totalsalesactual_lastmtd = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_actual('2', $idhotel_custom, $lastmonth, $yearact);
													$grandtotal_totalsalesbudget_lastmtd = $this->Smartreport_actual_model->get_grandtotal_pnlcategorybudget('2', $idhotel_custom, $lastmonth, $yearact);
                                                } 
												$grandtotal_pnlcategory_actual_ytd = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_actual_ytd($smartreport_pnlcategory->idpnlcategory, $idhotel_custom,$startdate_ytd, $enddate_ytd);
												$grandtotal_pnlcategory_budget_ytd = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_budget_ytd($smartreport_pnlcategory->idpnlcategory, $idhotel_custom,$startdate_ytd, $enddate_ytd);
												$grandtotal_totalsalesactual_ytd = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_actual_ytd('2', $idhotel_custom, $startdate_ytd, $enddate_ytd);
												$grandtotal_totalsalesbudget_ytd = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_budget_ytd('2', $idhotel_custom, $startdate_ytd, $enddate_ytd);
												?>
                                                
											<tr >
												<td <?php if ($smartreport_pnlcategory->idpnlcategory == 1) {echo "class='hidden'";} ?> ><strong><?php echo $smartreport_pnlcategory->pnl_category;?></strong></td>	
												<td <?php if ($smartreport_pnlcategory->idpnlcategory == 1) {echo "class='hidden'";} ?> colspan="15"></td>
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
												<td <?php if ($smartreport_pnlcategory->idpnlcategory == 1) {echo "class='hidden'";} ?> style="display: none;"></td>	
                                                <td <?php if ($smartreport_pnlcategory->idpnlcategory == 1) {echo "class='hidden'";} ?> style="display: none;"></td> 
                                                <td <?php if ($smartreport_pnlcategory->idpnlcategory == 1) {echo "class='hidden'";} ?> style="display: none;"></td>	
												<td <?php if ($smartreport_pnlcategory->idpnlcategory == 1) {echo "class='hidden'";} ?> style="display: none;"></td>                                												
											</tr>		
												<?php foreach ($smartreport_pnllist_data as $smartreport_pnllist ){
														$total_actual_mtd = $this->Smartreport_actual_model->get_total_actual( $smartreport_pnllist->idpnl, $idhotel_custom, $monthact, $yearact);
														$total_budget_mtd = $this->Smartreport_actual_model->get_total_budget( $smartreport_pnllist->idpnl, $idhotel_custom, $monthact, $yearact);
                                                        if($monthact == '01'){ //jika difilter adalah bulan januari 2019 maka last monthnya adalah desember 2018 tahun sebelumnya
															$total_actual_lastmtd = $this->Smartreport_actual_model->get_total_actual( $smartreport_pnllist->idpnl, $idhotel_custom, $lastmonth, $lastyear);
															$total_budget_lastmtd = $this->Smartreport_actual_model->get_total_budget( $smartreport_pnllist->idpnl, $idhotel_custom, $lastmonth, $lastyear);
                                                        }else{
															$total_actual_lastmtd = $this->Smartreport_actual_model->get_total_actual( $smartreport_pnllist->idpnl, $idhotel_custom, $lastmonth, $yearact);
															$total_budget_lastmtd = $this->Smartreport_actual_model->get_total_budget( $smartreport_pnllist->idpnl, $idhotel_custom, $lastmonth, $yearact);
                                                        }
														$total_actual_ytd = $this->Smartreport_actual_model->get_total_actual_ytd( $smartreport_pnllist->idpnl, $idhotel_custom, $startdate_ytd, $enddate_ytd);
														$total_budget_ytd = $this->Smartreport_actual_model->get_total_budget_ytd( $smartreport_pnllist->idpnl, $idhotel_custom, $startdate_ytd, $enddate_ytd);?>
                                                      
                                                        <tr>															
                                                            <td>&emsp;&emsp;<?= $smartreport_pnllist->pnl_name;?></td>
                                                            <!--START MTD-->
															<td class="rata-kanan">
                                                                <?php echo number_format($total_actual_mtd->TOTAL_ACTUAL);?>	
                                                            </td>
															<td class="rata-kanan">
                                                                <?php if($smartreport_pnllist->idpnlcategory == 2){
																	if($total_actual_mtd->TOTAL_ACTUAL !=0 && $grandtotal_pnlcategory->GRANDTOTAL_PNLCATEGORY !=0 ){
																		echo number_format(($total_actual_mtd->TOTAL_ACTUAL/$grandtotal_pnlcategory->GRANDTOTAL_PNLCATEGORY)*100,2).'%';
																	}else{
																		echo '0%';
																	}
																}else if ($smartreport_pnllist->idpnlcategory == 6){
																	$total_room_sales = $this->Smartreport_actual_model->get_total_actual('4', $idhotel_custom, $monthact, $yearact);
																	$total_fnb_sales = $this->Smartreport_actual_model->get_total_actual('3', $idhotel_custom, $monthact, $yearact);
																	$total_laundry_sales = $this->Smartreport_actual_model->get_total_actual('5', $idhotel_custom, $monthact, $yearact);
																	$total_business_sales = $this->Smartreport_actual_model->get_total_actual('6', $idhotel_custom, $monthact, $yearact);
																	$total_sport_sales = $this->Smartreport_actual_model->get_total_actual('24', $idhotel_custom, $monthact, $yearact);
																	$total_spa_sales = $this->Smartreport_actual_model->get_total_actual('25', $idhotel_custom, $monthact, $yearact);

																	$total_room_profit = $this->Smartreport_actual_model->get_total_actual('14', $idhotel_custom, $monthact, $yearact);
																	$total_fnb_profit = $this->Smartreport_actual_model->get_total_actual('15', $idhotel_custom, $monthact, $yearact);
																	$total_laundry_profit = $this->Smartreport_actual_model->get_total_actual('26', $idhotel_custom, $monthact, $yearact);
																	$total_business_profit = $this->Smartreport_actual_model->get_total_actual('16', $idhotel_custom, $monthact, $yearact);
																	$total_sport_profit = $this->Smartreport_actual_model->get_total_actual('27', $idhotel_custom, $monthact, $yearact);
																	$total_spa_profit = $this->Smartreport_actual_model->get_total_actual('28', $idhotel_custom, $monthact, $yearact);

																	if ($smartreport_pnllist->idpnl == 14){
																		if ($total_room_profit->TOTAL_ACTUAL !=0 && $total_room_sales->TOTAL_ACTUAL !=0){
																			echo number_format(($total_room_profit->TOTAL_ACTUAL / $total_room_sales->TOTAL_ACTUAL)*100,2).'%';
																		}else{
																			echo '0%';
																		}
																	}else if ($smartreport_pnllist->idpnl == 15){
																		if ($total_fnb_profit->TOTAL_ACTUAL !=0 && $total_fnb_sales->TOTAL_ACTUAL !=0){
																			echo number_format(($total_fnb_profit->TOTAL_ACTUAL / $total_fnb_sales->TOTAL_ACTUAL)*100,2).'%';
																		}else{
																			echo '0%';
																		}
																	}else if ($smartreport_pnllist->idpnl == 26){
																		if ($total_laundry_profit->TOTAL_ACTUAL !=0 && $total_laundry_sales->TOTAL_ACTUAL !=0){
																			echo number_format(($total_laundry_profit->TOTAL_ACTUAL / $total_laundry_sales->TOTAL_ACTUAL)*100,2).'%';
																		}else{
																			echo '0%';
																		}
																	}else if ($smartreport_pnllist->idpnl == 16){
																		if ($total_business_profit->TOTAL_ACTUAL !=0 && $total_business_sales->TOTAL_ACTUAL !=0){
																			echo number_format(($total_business_profit->TOTAL_ACTUAL / $total_business_sales->TOTAL_ACTUAL)*100,2).'%';
																		}else{
																			echo '0%';
																		}
																	}else if ($smartreport_pnllist->idpnl == 27){
																		if ($total_sport_profit->TOTAL_ACTUAL !=0 && $total_sport_sales->TOTAL_ACTUAL !=0){
																			echo number_format(($total_sport_profit->TOTAL_ACTUAL / $total_sport_sales->TOTAL_ACTUAL)*100,2).'%';
																		}else{
																			echo '0%';
																		}
																	}else if ($smartreport_pnllist->idpnl == 28){
																		if ($total_spa_profit->TOTAL_ACTUAL !=0 && $total_spa_sales->TOTAL_ACTUAL !=0){
																			echo number_format(($total_spa_profit->TOTAL_ACTUAL / $total_spa_sales->TOTAL_ACTUAL)*100,2).'%';
																		}else{
																			echo '0%';
																		}
																	}
																}else if ($smartreport_pnllist->idpnlcategory !=1 && $smartreport_pnllist->idpnlcategory !=2 && $smartreport_pnllist->idpnlcategory !=6 ){
																	if($total_actual_mtd->TOTAL_ACTUAL !=0 && $grandtotal_totalsalesactual->GRANDTOTAL_PNLCATEGORY !=0 ){
																		echo number_format(($total_actual_mtd->TOTAL_ACTUAL/$grandtotal_totalsalesactual->GRANDTOTAL_PNLCATEGORY)*100,2).'%';
																	}else{
																		echo '0%';
																	}
																}
																  ?>
                                                            </td>													
                                                            <td class="rata-kanan"><?php echo number_format($total_budget_mtd->TOTAL_BUDGET);?></td> 
                                                            <td class="rata-kanan">
																<?php 
																	if($smartreport_pnllist->idpnlcategory == 2){
																		if($total_budget_mtd->TOTAL_BUDGET !=0 && $grandtotal_pnlcategorybudget->GRANDTOTAL_PNLCATEGORY !=0 ){
																			echo number_format(($total_budget_mtd->TOTAL_BUDGET/$grandtotal_pnlcategorybudget->GRANDTOTAL_PNLCATEGORY)*100,2).'%';
																		}else{
																			echo '0%';
																		}
																	}else if ($smartreport_pnllist->idpnlcategory == 6){
																		
																		$total_room_sales = $this->Smartreport_actual_model->get_total_budget('4', $idhotel_custom, $monthact, $yearact);
																		$total_fnb_sales = $this->Smartreport_actual_model->get_total_budget('3', $idhotel_custom, $monthact, $yearact);
																		$total_laundry_sales = $this->Smartreport_actual_model->get_total_budget('5', $idhotel_custom, $monthact, $yearact);
																		$total_business_sales = $this->Smartreport_actual_model->get_total_budget('6', $idhotel_custom, $monthact, $yearact);
																		$total_sport_sales = $this->Smartreport_actual_model->get_total_budget('24', $idhotel_custom, $monthact, $yearact);
																		$total_spa_sales = $this->Smartreport_actual_model->get_total_budget('25', $idhotel_custom, $monthact, $yearact);

																		$total_room_profit = $this->Smartreport_actual_model->get_total_budget('14', $idhotel_custom, $monthact, $yearact);
																		$total_fnb_profit = $this->Smartreport_actual_model->get_total_budget('15', $idhotel_custom, $monthact, $yearact);
																		$total_laundry_profit = $this->Smartreport_actual_model->get_total_budget('26', $idhotel_custom, $monthact, $yearact);
																		$total_business_profit = $this->Smartreport_actual_model->get_total_budget('16', $idhotel_custom, $monthact, $yearact);
																		$total_sport_profit = $this->Smartreport_actual_model->get_total_budget('27', $idhotel_custom, $monthact, $yearact);
																		$total_spa_profit = $this->Smartreport_actual_model->get_total_budget('28', $idhotel_custom, $monthact, $yearact);

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
																	}else if ($smartreport_pnllist->idpnlcategory !=1 && $smartreport_pnllist->idpnlcategory !=2 && $smartreport_pnllist->idpnlcategory !=6 ){
																		if($total_budget_mtd->TOTAL_BUDGET !=0 && $grandtotal_totalsalesbudget->GRANDTOTAL_PNLCATEGORY !=0 ){
																			echo number_format(($total_budget_mtd->TOTAL_BUDGET/$grandtotal_totalsalesbudget->GRANDTOTAL_PNLCATEGORY)*100,2).'%';
																		}else{
																			echo '0%';
																		}
																	}
																?>
															</td> 
															<td class="rata-kanan">
																<?php $variance_pnl = $total_actual_mtd->TOTAL_ACTUAL - $total_budget_mtd->TOTAL_BUDGET;
																($variance_pnl <= 0) ? $textcolor='text-danger-600' : $textcolor='text-success-600'; ?>
																<div class="<?php echo $textcolor?>"><?php echo number_format($variance_pnl,0); ?></div>
															</td>
															<!--END MTD-->
															
															<!--START LAST MONTH-->
                                                            <td class="rata-kanan">
                                                                <?php echo number_format($total_actual_lastmtd->TOTAL_ACTUAL);?>	
                                                            </td>
															<td class="rata-kanan">
                                                                <?php if($smartreport_pnllist->idpnlcategory == 2){
																	if($total_actual_lastmtd->TOTAL_ACTUAL !=0 && $grandtotal_pnlcategorylastmtd->GRANDTOTAL_PNLCATEGORY !=0 ){
																		echo number_format(($total_actual_lastmtd->TOTAL_ACTUAL/$grandtotal_pnlcategorylastmtd->GRANDTOTAL_PNLCATEGORY)*100,2).'%';
																	}else{
																		echo '0%';
																	}
																}else if ($smartreport_pnllist->idpnlcategory == 6){
																	if($monthact == '01'){ //jika difilter adalah bulan januari 2019 maka last monthnya adalah desember 2018 tahun sebelumnya
																		$total_room_sales_actual_lastmtd = $this->Smartreport_actual_model->get_total_actual('4', $idhotel_custom, $lastmonth, $lastyear);
																		$total_fnb_sales_actual_lastmtd = $this->Smartreport_actual_model->get_total_actual('3', $idhotel_custom, $lastmonth, $lastyear);
																		$total_laundry_sales_actual_lastmtd = $this->Smartreport_actual_model->get_total_actual('5', $idhotel_custom, $lastmonth, $lastyear);
																		$total_business_sales_actual_lastmtd = $this->Smartreport_actual_model->get_total_actual('6', $idhotel_custom, $lastmonth, $lastyear);
																		$total_sport_sales_actual_lastmtd = $this->Smartreport_actual_model->get_total_actual('24', $idhotel_custom, $lastmonth, $lastyear);
																		$total_spa_sales_actual_lastmtd = $this->Smartreport_actual_model->get_total_actual('25', $idhotel_custom, $lastmonth, $lastyear);
																		$total_room_profit_actual_lastmtd = $this->Smartreport_actual_model->get_total_actual('14', $idhotel_custom, $lastmonth, $lastyear);
																		$total_fnb_profit_actual_lastmtd = $this->Smartreport_actual_model->get_total_actual('15', $idhotel_custom, $lastmonth, $lastyear);
																		$total_laundry_profit_actual_lastmtd = $this->Smartreport_actual_model->get_total_actual('26', $idhotel_custom, $lastmonth, $lastyear);
																		$total_business_profit_actual_lastmtd = $this->Smartreport_actual_model->get_total_actual('16', $idhotel_custom, $lastmonth, $lastyear);
																		$total_sport_profit_actual_lastmtd = $this->Smartreport_actual_model->get_total_actual('27', $idhotel_custom, $lastmonth, $lastyear);
																		$total_spa_profit_actual_lastmtd = $this->Smartreport_actual_model->get_total_actual('28', $idhotel_custom, $lastmonth, $lastyear);
																	}else{
																		$total_room_sales_actual_lastmtd = $this->Smartreport_actual_model->get_total_actual('4', $idhotel_custom, $lastmonth, $yearact);
																		$total_fnb_sales_actual_lastmtd = $this->Smartreport_actual_model->get_total_actual('3', $idhotel_custom, $lastmonth, $yearact);
																		$total_laundry_sales_actual_lastmtd = $this->Smartreport_actual_model->get_total_actual('5', $idhotel_custom, $lastmonth, $yearact);
																		$total_business_sales_actual_lastmtd = $this->Smartreport_actual_model->get_total_actual('6', $idhotel_custom, $lastmonth, $yearact);
																		$total_sport_sales_actual_lastmtd = $this->Smartreport_actual_model->get_total_actual('24', $idhotel_custom, $lastmonth, $yearact);
																		$total_spa_sales_actual_lastmtd = $this->Smartreport_actual_model->get_total_actual('25', $idhotel_custom, $lastmonth, $yearact);
																		$total_room_profit_actual_lastmtd = $this->Smartreport_actual_model->get_total_actual('14', $idhotel_custom, $lastmonth, $yearact);
																		$total_fnb_profit_actual_lastmtd = $this->Smartreport_actual_model->get_total_actual('15', $idhotel_custom, $lastmonth, $yearact);
																		$total_laundry_profit_actual_lastmtd = $this->Smartreport_actual_model->get_total_actual('26', $idhotel_custom, $lastmonth, $yearact);
																		$total_business_profit_actual_lastmtd = $this->Smartreport_actual_model->get_total_actual('16', $idhotel_custom, $lastmonth, $yearact);
																		$total_sport_profit_actual_lastmtd = $this->Smartreport_actual_model->get_total_actual('27', $idhotel_custom, $lastmonth, $yearact);
																		$total_spa_profit_actual_lastmtd = $this->Smartreport_actual_model->get_total_actual('28', $idhotel_custom, $lastmonth, $yearact);
																	}

																	if ($smartreport_pnllist->idpnl == 14){
																		if ($total_room_profit_actual_lastmtd->TOTAL_ACTUAL !=0 && $total_room_sales_actual_lastmtd->TOTAL_ACTUAL !=0){
																			echo number_format(($total_room_profit_actual_lastmtd->TOTAL_ACTUAL / $total_room_sales_actual_lastmtd->TOTAL_ACTUAL)*100,2).'%';
																		}else{
																			echo '0%';
																		}
																	}else if ($smartreport_pnllist->idpnl == 15){
																		if ($total_fnb_profit_actual_lastmtd->TOTAL_ACTUAL !=0 && $total_fnb_sales_actual_lastmtd->TOTAL_ACTUAL !=0){
																			echo number_format(($total_fnb_profit_actual_lastmtd->TOTAL_ACTUAL / $total_fnb_sales_actual_lastmtd->TOTAL_ACTUAL)*100,2).'%';
																		}else{
																			echo '0%';
																		}
																	}else if ($smartreport_pnllist->idpnl == 26){
																		if ($total_laundry_profit_actual_lastmtd->TOTAL_ACTUAL !=0 && $total_laundry_sales_actual_lastmtd->TOTAL_ACTUAL !=0){
																			echo number_format(($total_laundry_profit_actual_lastmtd->TOTAL_ACTUAL / $total_laundry_sales_actual_lastmtd->TOTAL_ACTUAL)*100,2).'%';
																		}else{
																			echo '0%';
																		}
																	}else if ($smartreport_pnllist->idpnl == 16){
																		if ($total_business_profit_actual_lastmtd->TOTAL_ACTUAL !=0 && $total_business_sales_actual_lastmtd->TOTAL_ACTUAL !=0){
																			echo number_format(($total_business_profit_actual_lastmtd->TOTAL_ACTUAL / $total_business_sales_actual_lastmtd->TOTAL_ACTUAL)*100,2).'%';
																		}else{
																			echo '0%';
																		}
																	}else if ($smartreport_pnllist->idpnl == 27){
																		if ($total_sport_profit_actual_lastmtd->TOTAL_ACTUAL !=0 && $total_sport_sales_actual_lastmtd->TOTAL_ACTUAL !=0){
																			echo number_format(($total_sport_profit_actual_lastmtd->TOTAL_ACTUAL / $total_sport_sales_actual_lastmtd->TOTAL_ACTUAL)*100,2).'%';
																		}else{
																			echo '0%';
																		}
																	}else if ($smartreport_pnllist->idpnl == 28){
																		if ($total_spa_profit_actual_lastmtd->TOTAL_ACTUAL !=0 && $total_spa_sales_actual_lastmtd->TOTAL_ACTUAL !=0){
																			echo number_format(($total_spa_profit_actual_lastmtd->TOTAL_ACTUAL / $total_spa_sales_actual_lastmtd->TOTAL_ACTUAL)*100,2).'%';
																		}else{
																			echo '0%';
																		}
																	}
																}else if($smartreport_pnllist->idpnlcategory !=1 && $smartreport_pnllist->idpnlcategory !=2 && $smartreport_pnllist->idpnlcategory !=6 ){
																	if($total_actual_lastmtd->TOTAL_ACTUAL !=0 && $grandtotal_totalsalesactual_lastmtd->GRANDTOTAL_PNLCATEGORY !=0 ){
																		echo number_format(($total_actual_lastmtd->TOTAL_ACTUAL/$grandtotal_totalsalesactual_lastmtd->GRANDTOTAL_PNLCATEGORY)*100,2).'%';
																	}else{
																		echo '0%';
																	}
																} ?>
                                                            </td>													
                                                            <td class="rata-kanan"><?php echo number_format($total_budget_lastmtd->TOTAL_BUDGET);?>	</td> 
                                                            <td class="rata-kanan">
																<?php 
																	if($smartreport_pnllist->idpnlcategory == 2){
																		if($total_budget_lastmtd->TOTAL_BUDGET !=0 && $grandtotal_pnlcategorybudgetlastmtd->GRANDTOTAL_PNLCATEGORY !=0 ){
																			echo number_format(($total_budget_lastmtd->TOTAL_BUDGET/$grandtotal_pnlcategorybudgetlastmtd->GRANDTOTAL_PNLCATEGORY)*100,2).'%';
																		}else{
																			echo '0%';
																		}
																	}else if($smartreport_pnllist->idpnlcategory == 6){
																		if($monthact == '01'){ //jika difilter adalah bulan januari 2019 maka last monthnya adalah desember 2018 tahun sebelumnya
																			$total_room_sales_budget_lastmtd = $this->Smartreport_actual_model->get_total_budget('4', $idhotel_custom, $lastmonth, $lastyear);
																			$total_fnb_sales_budget_lastmtd = $this->Smartreport_actual_model->get_total_budget('3', $idhotel_custom, $lastmonth, $lastyear);
																			$total_laundry_sales_budget_lastmtd = $this->Smartreport_actual_model->get_total_budget('5', $idhotel_custom, $lastmonth, $lastyear);
																			$total_business_sales_budget_lastmtd = $this->Smartreport_actual_model->get_total_budget('6', $idhotel_custom, $lastmonth, $lastyear);
																			$total_sport_sales_budget_lastmtd = $this->Smartreport_actual_model->get_total_budget('24', $idhotel_custom, $lastmonth, $lastyear);
																			$total_spa_sales_budget_lastmtd = $this->Smartreport_actual_model->get_total_budget('25', $idhotel_custom, $lastmonth, $lastyear);
																			$total_room_profit_budget_lastmtd = $this->Smartreport_actual_model->get_total_budget('14', $idhotel_custom, $lastmonth, $lastyear);
																			$total_fnb_profit_budget_lastmtd = $this->Smartreport_actual_model->get_total_budget('15', $idhotel_custom, $lastmonth, $lastyear);
																			$total_laundry_profit_budget_lastmtd = $this->Smartreport_actual_model->get_total_budget('26', $idhotel_custom, $lastmonth, $lastyear);
																			$total_business_profit_budget_lastmtd = $this->Smartreport_actual_model->get_total_budget('16', $idhotel_custom, $lastmonth, $lastyear);
																			$total_sport_profit_budget_lastmtd = $this->Smartreport_actual_model->get_total_budget('27', $idhotel_custom, $lastmonth, $lastyear);
																			$total_spa_profit_budget_lastmtd = $this->Smartreport_actual_model->get_total_budget('28', $idhotel_custom, $lastmonth, $lastyear);
																		}else{
																			$total_room_sales_budget_lastmtd = $this->Smartreport_actual_model->get_total_budget('4', $idhotel_custom, $lastmonth, $yearact);
																			$total_fnb_sales_budget_lastmtd = $this->Smartreport_actual_model->get_total_budget('3', $idhotel_custom, $lastmonth, $yearact);
																			$total_laundry_sales_budget_lastmtd = $this->Smartreport_actual_model->get_total_budget('5', $idhotel_custom, $lastmonth, $yearact);
																			$total_business_sales_budget_lastmtd = $this->Smartreport_actual_model->get_total_budget('6', $idhotel_custom, $lastmonth, $yearact);
																			$total_sport_sales_budget_lastmtd = $this->Smartreport_actual_model->get_total_budget('24', $idhotel_custom, $lastmonth, $yearact);
																			$total_spa_sales_budget_lastmtd = $this->Smartreport_actual_model->get_total_budget('25', $idhotel_custom, $lastmonth, $yearact);
																			$total_room_profit_budget_lastmtd = $this->Smartreport_actual_model->get_total_budget('14', $idhotel_custom, $lastmonth, $yearact);
																			$total_fnb_profit_budget_lastmtd = $this->Smartreport_actual_model->get_total_budget('15', $idhotel_custom, $lastmonth, $yearact);
																			$total_laundry_profit_budget_lastmtd = $this->Smartreport_actual_model->get_total_budget('26', $idhotel_custom, $lastmonth, $yearact);
																			$total_business_profit_budget_lastmtd = $this->Smartreport_actual_model->get_total_budget('16', $idhotel_custom, $lastmonth, $yearact);
																			$total_sport_profit_budget_lastmtd = $this->Smartreport_actual_model->get_total_budget('27', $idhotel_custom, $lastmonth, $yearact);
																			$total_spa_profit_budget_lastmtd = $this->Smartreport_actual_model->get_total_budget('28', $idhotel_custom, $lastmonth, $yearact);
																			
																		}

																		if ($smartreport_pnllist->idpnl == 14){
																			if ($total_room_profit_budget_lastmtd->TOTAL_BUDGET !=0 && $total_room_sales_budget_lastmtd->TOTAL_BUDGET !=0){
																				echo number_format(($total_room_profit_budget_lastmtd->TOTAL_BUDGET / $total_room_sales_budget_lastmtd->TOTAL_BUDGET)*100,2).'%';
																			}else{
																				echo '0%';
																			}
																		}else if ($smartreport_pnllist->idpnl == 15){
																			if ($total_fnb_profit_budget_lastmtd->TOTAL_BUDGET !=0 && $total_fnb_sales_budget_lastmtd->TOTAL_BUDGET !=0){
																				echo number_format(($total_fnb_profit_budget_lastmtd->TOTAL_BUDGET / $total_fnb_sales_budget_lastmtd->TOTAL_BUDGET)*100,2).'%';
																			}else{
																				echo '0%';
																			}
																		}else if ($smartreport_pnllist->idpnl == 26){
																			if ($total_laundry_profit_budget_lastmtd->TOTAL_BUDGET !=0 && $total_laundry_sales_budget_lastmtd->TOTAL_BUDGET !=0){
																				echo number_format(($total_laundry_profit_budget_lastmtd->TOTAL_BUDGET / $total_laundry_sales_budget_lastmtd->TOTAL_BUDGET)*100,2).'%';
																			}else{
																				echo '0%';
																			}
																		}else if ($smartreport_pnllist->idpnl == 16){
																			if ($total_business_profit_budget_lastmtd->TOTAL_BUDGET !=0 && $total_business_sales_budget_lastmtd->TOTAL_BUDGET !=0){
																				echo number_format(($total_business_profit_budget_lastmtd->TOTAL_BUDGET / $total_business_sales_budget_lastmtd->TOTAL_BUDGET)*100,2).'%';
																			}else{
																				echo '0%';
																			}
																		}else if ($smartreport_pnllist->idpnl == 27){
																			if ($total_sport_profit_budget_lastmtd->TOTAL_BUDGET !=0 && $total_sport_sales_budget_lastmtd->TOTAL_BUDGET !=0){
																				echo number_format(($total_sport_profit_budget_lastmtd->TOTAL_BUDGET / $total_sport_sales_budget_lastmtd->TOTAL_BUDGET)*100,2).'%';
																			}else{
																				echo '0%';
																			}
																		}else if ($smartreport_pnllist->idpnl == 28){
																			if ($total_spa_profit_budget_lastmtd->TOTAL_BUDGET !=0 && $total_spa_sales_budget_lastmtd->TOTAL_BUDGET !=0){
																				echo number_format(($total_spa_profit_budget_lastmtd->TOTAL_BUDGET / $total_spa_sales_budget_lastmtd->TOTAL_BUDGET)*100,2).'%';
																			}else{
																				echo '0%';
																			}
																		}
																	}else if($smartreport_pnllist->idpnlcategory !=1 && $smartreport_pnllist->idpnlcategory !=2 && $smartreport_pnllist->idpnlcategory !=6 ){
																		if($total_budget_lastmtd->TOTAL_BUDGET !=0 && $grandtotal_totalsalesbudget_lastmtd->GRANDTOTAL_PNLCATEGORY !=0 ){
																			echo number_format(($total_budget_lastmtd->TOTAL_BUDGET/$grandtotal_totalsalesbudget_lastmtd->GRANDTOTAL_PNLCATEGORY)*100,2).'%';
																		}else{
																			echo '0%';
																		}
																	}
																?>
															</td> 
															<td class="rata-kanan">
																<?php $variance_pnllastmtd = $total_actual_lastmtd->TOTAL_ACTUAL - $total_budget_lastmtd->TOTAL_BUDGET;
																($variance_pnllastmtd <= 0) ? $textcolor='text-danger-600' : $textcolor='text-success-600'; ?>
																<div class="<?php echo $textcolor?>"><?php echo number_format($variance_pnllastmtd,0); ?></div>
															</td>
															<!--END LAST MONTH-->

															<!--START YTD-->
                                                            <td class="rata-kanan">
																		<?php 
																		if($smartreport_pnllist->idpnl == 1){ //idpnl 1 ada average room rate cara menghitungnya beda sendiri																			
																			if($trr_actual_ytd->TOTAL_ACTUAL!=0 && $rs_actual_ytd->TOTAL_ACTUAL !=0){
																				$arr_actual_ytd = $trr_actual_ytd->TOTAL_ACTUAL/$rs_actual_ytd->TOTAL_ACTUAL;
																				echo number_format($arr_actual_ytd,0);
																			}
																		}else{																			 
																			echo number_format($total_actual_ytd->TOTAL_ACTUAL);
                                                                        }?>	
                                                            </td>
															<td class="rata-kanan">
																<?php 
																if($smartreport_pnllist->idpnlcategory == 2){
																	if($total_actual_ytd->TOTAL_ACTUAL !=0 && $grandtotal_pnlcategory_actual_ytd->GRANDTOTAL_PNLCATEGORY !=0 ){
																		echo number_format(($total_actual_ytd->TOTAL_ACTUAL/$grandtotal_pnlcategory_actual_ytd->GRANDTOTAL_PNLCATEGORY)*100,2).'%';
																	}else{
																		echo '0%';
																	}
																}else if($smartreport_pnllist->idpnlcategory == 6){
																		$total_room_sales_ytd = $this->Smartreport_actual_model->get_total_actual_ytd('4', $idhotel_custom, $startdate_ytd, $enddate_ytd);
																		$total_fnb_sales_ytd = $this->Smartreport_actual_model->get_total_actual_ytd('3', $idhotel_custom, $startdate_ytd, $enddate_ytd);
																		$total_laundry_sales_ytd = $this->Smartreport_actual_model->get_total_actual_ytd('5', $idhotel_custom, $startdate_ytd, $enddate_ytd);
																		$total_business_sales_ytd = $this->Smartreport_actual_model->get_total_actual_ytd('6', $idhotel_custom, $startdate_ytd, $enddate_ytd);
																		$total_sport_sales_ytd = $this->Smartreport_actual_model->get_total_actual_ytd('24', $idhotel_custom, $startdate_ytd, $enddate_ytd);
																		$total_spa_sales_ytd = $this->Smartreport_actual_model->get_total_actual_ytd('25', $idhotel_custom, $startdate_ytd, $enddate_ytd);

																		$total_room_profit_ytd = $this->Smartreport_actual_model->get_total_actual_ytd('14', $idhotel_custom, $startdate_ytd, $enddate_ytd);
																		$total_fnb_profit_ytd = $this->Smartreport_actual_model->get_total_actual_ytd('15', $idhotel_custom, $startdate_ytd, $enddate_ytd);
																		$total_laundry_profit_ytd = $this->Smartreport_actual_model->get_total_actual_ytd('26', $idhotel_custom, $startdate_ytd, $enddate_ytd);
																		$total_business_profit_ytd = $this->Smartreport_actual_model->get_total_actual_ytd('16', $idhotel_custom, $startdate_ytd, $enddate_ytd);
																		$total_sport_profit_ytd = $this->Smartreport_actual_model->get_total_actual_ytd('27', $idhotel_custom, $startdate_ytd, $enddate_ytd);
																		$total_spa_profit_ytd = $this->Smartreport_actual_model->get_total_actual_ytd('28', $idhotel_custom, $startdate_ytd, $enddate_ytd);

																		if ($smartreport_pnllist->idpnl == 14){
																			if ($total_room_profit_ytd->TOTAL_ACTUAL !=0 && $total_room_sales_ytd->TOTAL_ACTUAL !=0){
																				echo number_format(($total_room_profit_ytd->TOTAL_ACTUAL / $total_room_sales_ytd->TOTAL_ACTUAL)*100,2).'%';
																			}else{
																				echo '0%';
																			}
																		}else if ($smartreport_pnllist->idpnl == 15){
																			if ($total_fnb_profit_ytd->TOTAL_ACTUAL !=0 && $total_fnb_sales_ytd->TOTAL_ACTUAL !=0){
																				echo number_format(($total_fnb_profit_ytd->TOTAL_ACTUAL / $total_fnb_sales_ytd->TOTAL_ACTUAL)*100,2).'%';
																			}else{
																				echo '0%';
																			}
																		}else if ($smartreport_pnllist->idpnl == 26){
																			if ($total_laundry_profit_ytd->TOTAL_ACTUAL !=0 && $total_laundry_sales_ytd->TOTAL_ACTUAL !=0){
																				echo number_format(($total_laundry_profit_ytd->TOTAL_ACTUAL / $total_laundry_sales_ytd->TOTAL_ACTUAL)*100,2).'%';
																			}else{
																				echo '0%';
																			}
																		}else if ($smartreport_pnllist->idpnl == 16){
																			if ($total_business_profit_ytd->TOTAL_ACTUAL !=0 && $total_business_sales_ytd->TOTAL_ACTUAL !=0){
																				echo number_format(($total_business_profit_ytd->TOTAL_ACTUAL / $total_business_sales_ytd->TOTAL_ACTUAL)*100,2).'%';
																			}else{
																				echo '0%';
																			}
																		}else if ($smartreport_pnllist->idpnl == 27){
																			if ($total_sport_profit_ytd->TOTAL_ACTUAL !=0 && $total_sport_sales_ytd->TOTAL_ACTUAL !=0){
																				echo number_format(($total_sport_profit_ytd->TOTAL_ACTUAL / $total_sport_sales_ytd->TOTAL_ACTUAL)*100,2).'%';
																			}else{
																				echo '0%';
																			}
																		}else if ($smartreport_pnllist->idpnl == 28){
																			if ($total_spa_profit_ytd->TOTAL_ACTUAL !=0 && $total_spa_sales_ytd->TOTAL_ACTUAL !=0){
																				echo number_format(($total_spa_profit_ytd->TOTAL_ACTUAL / $total_spa_sales_ytd->TOTAL_ACTUAL)*100,2).'%';
																			}else{
																				echo '0%';
																			}
																		}
																}else if($smartreport_pnllist->idpnlcategory !=1 && $smartreport_pnllist->idpnlcategory !=2 && $smartreport_pnllist->idpnlcategory !=6 ){
																	if($total_actual_ytd->TOTAL_ACTUAL !=0 && $grandtotal_totalsalesactual_ytd->GRANDTOTAL_PNLCATEGORY !=0 ){
																		echo number_format(($total_actual_ytd->TOTAL_ACTUAL/$grandtotal_totalsalesactual_ytd->GRANDTOTAL_PNLCATEGORY)*100,2).'%';
																	}else{
																		echo '0%';
																	}
																} ?>
                                                            </td>													
                                                            <td class="rata-kanan"><?php if($smartreport_pnllist->idpnl == 1){ //idpnl 1 ada average room rate cara menghitungnya beda sendiri																			
																			if($trr_budget_ytd->TOTAL_BUDGET!=0 && $rs_budget_ytd->TOTAL_BUDGET !=0){
																				$arr_budget_ytd = $trr_budget_ytd->TOTAL_BUDGET/$rs_budget_ytd->TOTAL_BUDGET;
																				echo number_format($arr_budget_ytd,0);
																			}else{
																				$arr_budget_ytd =0;
																			}
																		}else{																			 
																			echo number_format($total_budget_ytd->TOTAL_BUDGET);
																		}?>	
															</td> 
                                                            <td class="rata-kanan">
																<?php if($smartreport_pnllist->idpnlcategory == 2){
																		if($total_budget_ytd->TOTAL_BUDGET !=0 && $grandtotal_pnlcategory_budget_ytd->GRANDTOTAL_PNLCATEGORY !=0 ){
																			echo number_format(($total_budget_ytd->TOTAL_BUDGET/$grandtotal_pnlcategory_budget_ytd->GRANDTOTAL_PNLCATEGORY)*100,2).'%';
																		}else{
																			echo '0%';
																		}
																	}else if ($smartreport_pnllist->idpnlcategory == 6){
																		$total_room_sales_ytd = $this->Smartreport_actual_model->get_total_budget_ytd('4', $idhotel_custom, $startdate_ytd, $enddate_ytd);
																		$total_fnb_sales_ytd = $this->Smartreport_actual_model->get_total_budget_ytd('3', $idhotel_custom, $startdate_ytd, $enddate_ytd);
																		$total_laundry_sales_ytd = $this->Smartreport_actual_model->get_total_budget_ytd('5', $idhotel_custom, $startdate_ytd, $enddate_ytd);
																		$total_business_sales_ytd = $this->Smartreport_actual_model->get_total_budget_ytd('6', $idhotel_custom, $startdate_ytd, $enddate_ytd);
																		$total_sport_sales_ytd = $this->Smartreport_actual_model->get_total_budget_ytd('24', $idhotel_custom, $startdate_ytd, $enddate_ytd);
																		$total_spa_sales_ytd = $this->Smartreport_actual_model->get_total_budget_ytd('25', $idhotel_custom, $startdate_ytd, $enddate_ytd);

																		$total_room_profit_ytd = $this->Smartreport_actual_model->get_total_budget_ytd('14', $idhotel_custom, $startdate_ytd, $enddate_ytd);
																		$total_fnb_profit_ytd = $this->Smartreport_actual_model->get_total_budget_ytd('15', $idhotel_custom, $startdate_ytd, $enddate_ytd);
																		$total_laundry_profit_ytd = $this->Smartreport_actual_model->get_total_budget_ytd('26', $idhotel_custom, $startdate_ytd, $enddate_ytd);
																		$total_business_profit_ytd = $this->Smartreport_actual_model->get_total_budget_ytd('16', $idhotel_custom, $startdate_ytd, $enddate_ytd);
																		$total_sport_profit_ytd = $this->Smartreport_actual_model->get_total_budget_ytd('27', $idhotel_custom, $startdate_ytd, $enddate_ytd);
																		$total_spa_profit_ytd = $this->Smartreport_actual_model->get_total_budget_ytd('28', $idhotel_custom, $startdate_ytd, $enddate_ytd);

																		if ($smartreport_pnllist->idpnl == 14){
																			if ($total_room_profit_ytd->TOTAL_BUDGET !=0 && $total_room_sales_ytd->TOTAL_BUDGET !=0){
																				echo number_format(($total_room_profit_ytd->TOTAL_BUDGET / $total_room_sales_ytd->TOTAL_BUDGET)*100,2).'%';
																			}else{
																				echo '0%';
																			}
																		}else if ($smartreport_pnllist->idpnl == 15){
																			if ($total_fnb_profit_ytd->TOTAL_BUDGET !=0 && $total_fnb_sales_ytd->TOTAL_BUDGET !=0){
																				echo number_format(($total_fnb_profit_ytd->TOTAL_BUDGET / $total_fnb_sales_ytd->TOTAL_BUDGET)*100,2).'%';
																			}else{
																				echo '0%';
																			}
																		}else if ($smartreport_pnllist->idpnl == 26){
																			if ($total_laundry_profit_ytd->TOTAL_BUDGET !=0 && $total_laundry_sales_ytd->TOTAL_BUDGET !=0){
																				echo number_format(($total_laundry_profit_ytd->TOTAL_BUDGET / $total_laundry_sales_ytd->TOTAL_BUDGET)*100,2).'%';
																			}else{
																				echo '0%';
																			}
																		}else if ($smartreport_pnllist->idpnl == 16){
																			if ($total_business_profit_ytd->TOTAL_BUDGET !=0 && $total_business_sales_ytd->TOTAL_BUDGET !=0){
																				echo number_format(($total_business_profit_ytd->TOTAL_BUDGET / $total_business_sales_ytd->TOTAL_BUDGET)*100,2).'%';
																			}else{
																				echo '0%';
																			}
																		}else if ($smartreport_pnllist->idpnl == 27){
																			if ($total_sport_profit_ytd->TOTAL_BUDGET !=0 && $total_sport_sales_ytd->TOTAL_BUDGET !=0){
																				echo number_format(($total_sport_profit_ytd->TOTAL_BUDGET / $total_sport_sales_ytd->TOTAL_BUDGET)*100,2).'%';
																			}else{
																				echo '0%';
																			}
																		}else if ($smartreport_pnllist->idpnl == 28){
																			if ($total_spa_profit_ytd->TOTAL_BUDGET !=0 && $total_spa_sales_ytd->TOTAL_BUDGET !=0){
																				echo number_format(($total_spa_profit_ytd->TOTAL_BUDGET / $total_spa_sales_ytd->TOTAL_BUDGET)*100,2).'%';
																			}else{
																				echo '0%';
																			}
																		}
																	}else if ($smartreport_pnllist->idpnlcategory !=1 && $smartreport_pnllist->idpnlcategory !=2 && $smartreport_pnllist->idpnlcategory !=6 ){
																		if($total_budget_ytd->TOTAL_BUDGET !=0 && $grandtotal_totalsalesbudget_ytd->GRANDTOTAL_PNLCATEGORY !=0 ){
																			echo number_format(($total_budget_ytd->TOTAL_BUDGET/$grandtotal_totalsalesbudget_ytd->GRANDTOTAL_PNLCATEGORY)*100,2).'%';
																		}else{
																			echo '0%';
																		}
																	}
																?>
															</td> 
															<td class="rata-kanan">
																<?php if($smartreport_pnllist->idpnl == 1){ 
																	if($total_rooms->total_rooms != 0){$variance_pnlytd = $arr_actual_ytd - $arr_budget_ytd;}
																}else{
																	$variance_pnlytd = $total_actual_ytd->TOTAL_ACTUAL - $total_budget_ytd->TOTAL_BUDGET;
																}																
																($variance_pnlytd <= 0) ? $textcolor='text-danger-600' : $textcolor='text-success-600'; ?>
																<div class="<?php echo $textcolor?>"><?php echo number_format($variance_pnlytd,0); ?></div>
															</td>
															<!--END YTD-->
													  		                                        
                                                        </tr>
												<?php } ?>
												<tr>
													<!--START TOTAL MTD-->
													<td <?php  if ($smartreport_pnlcategory->idpnlcategory == 1) {echo "class='hidden'";} ?>"><strong><?php echo "TOTAL ".$smartreport_pnlcategory->pnl_category;?></strong></td>                                                    
                                                    <td <?php  if ($smartreport_pnlcategory->idpnlcategory == 1) {echo "class='hidden'";}else{echo "class='rata-kanan'";} ?>><strong><?php echo number_format($grandtotal_pnlcategory->GRANDTOTAL_PNLCATEGORY,0);?></strong></td>
													<td <?php  if ($smartreport_pnlcategory->idpnlcategory == 1) {echo "class='hidden'";}else{echo "class='rata-kanan'";} ?>>
														<strong>
														<?php  
															if($smartreport_pnllist->idpnlcategory == 2){
																if($grandtotal_pnlcategory->GRANDTOTAL_PNLCATEGORY != 0){echo number_format(($grandtotal_pnlcategory->GRANDTOTAL_PNLCATEGORY/$grandtotal_pnlcategory->GRANDTOTAL_PNLCATEGORY)*100,2).'%';
																}else{
																	echo '0%';
																}
															}else if($smartreport_pnllist->idpnlcategory !=2 && $smartreport_pnllist->idpnlcategory !=1){
																if($grandtotal_pnlcategory->GRANDTOTAL_PNLCATEGORY != 0 && $grandtotal_totalsalesactual->GRANDTOTAL_PNLCATEGORY != 0){
																	echo number_format(($grandtotal_pnlcategory->GRANDTOTAL_PNLCATEGORY/$grandtotal_totalsalesactual->GRANDTOTAL_PNLCATEGORY)*100,2).'%';
																}else{
																	echo '0%';
																}
															} ?>
															</strong>
													</td>	
                                                    <td <?php  if ($smartreport_pnlcategory->idpnlcategory == 1) {echo "class='hidden'";}else{echo "class='rata-kanan'";} ?>><strong><?php echo number_format($grandtotal_pnlcategorybudget->GRANDTOTAL_PNLCATEGORY,0);?></strong></td>
													<td <?php  if ($smartreport_pnlcategory->idpnlcategory == 1) {echo "class='hidden'";}else{echo "class='rata-kanan'";} ?>>
														<strong>
														<?php  
															if($smartreport_pnllist->idpnlcategory == 2){
																if($grandtotal_pnlcategorybudget->GRANDTOTAL_PNLCATEGORY != 0){
																	echo number_format(($grandtotal_pnlcategorybudget->GRANDTOTAL_PNLCATEGORY/$grandtotal_pnlcategorybudget->GRANDTOTAL_PNLCATEGORY)*100,2).'%';
																}else{
																	echo '0%';
																}
															}else if($smartreport_pnllist->idpnlcategory !=2 && $smartreport_pnllist->idpnlcategory !=1){
																if($grandtotal_pnlcategorybudget->GRANDTOTAL_PNLCATEGORY != 0 && $grandtotal_totalsalesbudget->GRANDTOTAL_PNLCATEGORY != 0){
																	echo number_format(($grandtotal_pnlcategorybudget->GRANDTOTAL_PNLCATEGORY/$grandtotal_totalsalesbudget->GRANDTOTAL_PNLCATEGORY)*100,2).'%';
																}else{
																	echo '0%';
																}
															} 
														?>
														</strong>
													</td>	
													<td <?php  if ($smartreport_pnlcategory->idpnlcategory == 1) {echo "class='hidden'";}else{echo "class='rata-kanan'";}?>>
														<?php 	
															$variance_grandtotal_pnlcategory = $grandtotal_pnlcategory->GRANDTOTAL_PNLCATEGORY - $grandtotal_pnlcategorybudget->GRANDTOTAL_PNLCATEGORY;
															($variance_grandtotal_pnlcategory <= 0) ? $textcolor='text-danger-600' : $textcolor='text-success-600'; 
														?>
															<strong><div class="<?php echo $textcolor?>"><?php echo number_format($variance_grandtotal_pnlcategory,0); ?></div></strong>
													</td>
													<!--END TOTAL MTD-->

													<!--START TOTAL LAST MTD-->
                                                    <td <?php  if ($smartreport_pnlcategory->idpnlcategory == 1) {echo "class='hidden'";}else{echo "class='rata-kanan'";}?>><strong><?php echo number_format($grandtotal_pnlcategorylastmtd->GRANDTOTAL_PNLCATEGORY,0);?></strong></td>
													<td <?php  if ($smartreport_pnlcategory->idpnlcategory == 1) {echo "class='hidden'";}else{echo "class='rata-kanan'";}?>>
														<strong>
														<?php  if($smartreport_pnllist->idpnlcategory == 2){
																	if($grandtotal_pnlcategorylastmtd->GRANDTOTAL_PNLCATEGORY != 0){
																		echo number_format(($grandtotal_pnlcategorylastmtd->GRANDTOTAL_PNLCATEGORY/$grandtotal_pnlcategorylastmtd->GRANDTOTAL_PNLCATEGORY)*100,2).'%';
																	}else{
																		echo '0%';
																	}
																}else if($smartreport_pnllist->idpnlcategory !=2 && $smartreport_pnllist->idpnlcategory !=1){
																	if($grandtotal_pnlcategorylastmtd->GRANDTOTAL_PNLCATEGORY != 0 && $grandtotal_totalsalesactual_lastmtd->GRANDTOTAL_PNLCATEGORY != 0){
																		echo number_format(($grandtotal_pnlcategorylastmtd->GRANDTOTAL_PNLCATEGORY/$grandtotal_totalsalesactual_lastmtd->GRANDTOTAL_PNLCATEGORY)*100,2).'%';
																	}else{
																		echo '0%';
																	}
																		
																}	?>
														</strong>
													</td>	
                                                    <td <?php  if ($smartreport_pnlcategory->idpnlcategory == 1) {echo "class='hidden'";}else{echo "class='rata-kanan'";}?>><strong><?php echo number_format($grandtotal_pnlcategorybudgetlastmtd->GRANDTOTAL_PNLCATEGORY,0);?></strong></td>
													<td <?php  if ($smartreport_pnlcategory->idpnlcategory == 1) {echo "class='hidden'";}else{echo "class='rata-kanan'";}?>>
														<strong>
														<?php  
														if($smartreport_pnllist->idpnlcategory == 2){
															if($grandtotal_pnlcategorybudgetlastmtd->GRANDTOTAL_PNLCATEGORY != 0){
																echo number_format(($grandtotal_pnlcategorybudgetlastmtd->GRANDTOTAL_PNLCATEGORY/$grandtotal_pnlcategorybudgetlastmtd->GRANDTOTAL_PNLCATEGORY)*100,2).'%';
															}else{
																echo '0%';
															}
														}else if($smartreport_pnllist->idpnlcategory !=2 && $smartreport_pnllist->idpnlcategory !=1){
																if($grandtotal_pnlcategorybudgetlastmtd->GRANDTOTAL_PNLCATEGORY != 0 && $grandtotal_totalsalesbudget_lastmtd->GRANDTOTAL_PNLCATEGORY != 0){
																echo number_format(($grandtotal_pnlcategorybudgetlastmtd->GRANDTOTAL_PNLCATEGORY/$grandtotal_totalsalesbudget_lastmtd->GRANDTOTAL_PNLCATEGORY)*100,2).'%';
																}else{
																	echo '0%';
																}
														}	 ?>
														</strong>
													</td>	
													<td <?php  if ($smartreport_pnlcategory->idpnlcategory == 1) {echo "class='hidden'";}else{echo "class='rata-kanan'";}?>>
														<?php 	$variance_grandtotal_pnlcategorylastmtd = $grandtotal_pnlcategorylastmtd->GRANDTOTAL_PNLCATEGORY - $grandtotal_pnlcategorybudgetlastmtd->GRANDTOTAL_PNLCATEGORY;
																($variance_grandtotal_pnlcategorylastmtd <= 0) ? $textcolor='text-danger-600' : $textcolor='text-success-600'; ?>
																<strong><div class="<?php echo $textcolor?>"><?php echo number_format($variance_grandtotal_pnlcategorylastmtd,0); ?></div></strong>
													</td>	
													<!--END TOTAL LAST MTD-->

													<!--START TOTAL YTD-->		
                                                    <td <?php  if ($smartreport_pnlcategory->idpnlcategory == 1) {echo "class='hidden'";}else{echo "class='rata-kanan'";}?>><strong><?php echo number_format($grandtotal_pnlcategory_actual_ytd->GRANDTOTAL_PNLCATEGORY,0);?></strong></td>
													<td <?php  if ($smartreport_pnlcategory->idpnlcategory == 1) {echo "class='hidden'";}else{echo "class='rata-kanan'";}?>>
														<strong>
														<?php  if($smartreport_pnllist->idpnlcategory == 2){  
																	if($grandtotal_pnlcategory_actual_ytd->GRANDTOTAL_PNLCATEGORY != 0){
																		echo number_format(($grandtotal_pnlcategory_actual_ytd->GRANDTOTAL_PNLCATEGORY/$grandtotal_pnlcategory_actual_ytd->GRANDTOTAL_PNLCATEGORY)*100,2).'%';
																	}else{
																		echo '0%';
																	}
																}else if($smartreport_pnllist->idpnlcategory !=2 && $smartreport_pnllist->idpnlcategory !=1){
																	if($grandtotal_pnlcategory_actual_ytd->GRANDTOTAL_PNLCATEGORY != 0 && $grandtotal_totalsalesactual_ytd->GRANDTOTAL_PNLCATEGORY != 0){
																		echo number_format(($grandtotal_pnlcategory_actual_ytd->GRANDTOTAL_PNLCATEGORY/$grandtotal_totalsalesactual_ytd->GRANDTOTAL_PNLCATEGORY)*100,2).'%';
																	}else{
																		echo '0%';
																	}
																}?>
														</strong>
													</td>	
                                                    <td <?php  if ($smartreport_pnlcategory->idpnlcategory == 1) {echo "class='hidden'";}else{echo "class='rata-kanan'";}?>><strong><?php echo number_format($grandtotal_pnlcategory_budget_ytd->GRANDTOTAL_PNLCATEGORY,0);?></strong></td>
													<td <?php  if ($smartreport_pnlcategory->idpnlcategory == 1) {echo "class='hidden'";}else{echo "class='rata-kanan'";}?>>
														<strong>
															<?php  if($smartreport_pnllist->idpnlcategory == 2){
																	if($grandtotal_pnlcategory_budget_ytd->GRANDTOTAL_PNLCATEGORY != 0){
																		echo number_format(($grandtotal_pnlcategory_budget_ytd->GRANDTOTAL_PNLCATEGORY/$grandtotal_pnlcategory_budget_ytd->GRANDTOTAL_PNLCATEGORY)*100,2).'%';
																		}else{
																			echo '0%';
																		}
															 }else if($smartreport_pnllist->idpnlcategory !=2 && $smartreport_pnllist->idpnlcategory !=1){
																	if($grandtotal_pnlcategory_budget_ytd->GRANDTOTAL_PNLCATEGORY != 0 && $grandtotal_totalsalesbudget_ytd->GRANDTOTAL_PNLCATEGORY != 0){
																		echo number_format(($grandtotal_pnlcategory_budget_ytd->GRANDTOTAL_PNLCATEGORY/$grandtotal_totalsalesbudget_ytd->GRANDTOTAL_PNLCATEGORY)*100,2).'%';
																		}else{
																			echo '0%';
																		}
															 } ?>
														</strong>	 
													</td>	
													<td <?php  if ($smartreport_pnlcategory->idpnlcategory == 1) {echo "class='hidden'";}else{echo "class='rata-kanan'";}?>>
														<?php $variance_grandtotal_pnlcategoryytd = $grandtotal_pnlcategory_actual_ytd->GRANDTOTAL_PNLCATEGORY - $grandtotal_pnlcategory_budget_ytd->GRANDTOTAL_PNLCATEGORY;
																($variance_grandtotal_pnlcategoryytd <= 0) ? $textcolor='text-danger-600' : $textcolor='text-success-600'; ?>
																<strong><div class="<?php echo $textcolor?>"><?php echo number_format($variance_grandtotal_pnlcategoryytd,0); ?></div></strong>
													</td>	
													<!--END TOTAL YTD-->
												</tr>	
											<?php } ?>
											<tr>
												<td><strong>TOTAL UNDISTRIBUTED EXPENSE</strong></td>
												
												<!-- BEGIN MTD -->
												<td class='rata-kanan'>
													<?php 
														$grandtotal_und_payroll_actual = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_actual('7', $idhotel_custom, $monthact, $yearact);
														$grandtotal_und_opr_exp_actual = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_actual('8', $idhotel_custom, $monthact, $yearact);
														$grandtotal_und_exp_actual = $grandtotal_und_payroll_actual->GRANDTOTAL_PNLCATEGORY + $grandtotal_und_opr_exp_actual->GRANDTOTAL_PNLCATEGORY;
													?>	
													<strong><?php echo number_format($grandtotal_und_exp_actual,0);?></strong>
												</td>
												<td class='rata-kanan'> 
													<strong>
														<?php
															if($grandtotal_und_exp_actual !=0 && $grandtotal_totalsalesactual->GRANDTOTAL_PNLCATEGORY != 0){
																echo number_format(($grandtotal_und_exp_actual/$grandtotal_totalsalesactual->GRANDTOTAL_PNLCATEGORY)*100,2).'%';
															}else{
																echo '0%';
															}															
														?>
													</strong>
												</td>
												<td class='rata-kanan'>
													<?php 
														$grandtotal_und_payroll_budget = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_budget('7', $idhotel_custom, $monthact, $yearact);
														$grandtotal_und_opr_exp_budget = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_budget('8', $idhotel_custom, $monthact, $yearact);
														$grandtotal_und_exp_budget = $grandtotal_und_payroll_budget->GRANDTOTAL_PNLCATEGORY + $grandtotal_und_opr_exp_budget->GRANDTOTAL_PNLCATEGORY;
													?>	
													<strong><?php echo number_format($grandtotal_und_exp_budget,0);?></strong>
												</td>
												<td class='rata-kanan'> 
													<strong>
														<?php
															if($grandtotal_und_exp_budget !=0 && $grandtotal_totalsalesbudget->GRANDTOTAL_PNLCATEGORY != 0){
																echo number_format(($grandtotal_und_exp_budget/$grandtotal_totalsalesbudget->GRANDTOTAL_PNLCATEGORY)*100,2).'%';
															}else{
																echo '0%';
															}															
														?>
													</strong>
												</td>
												<td class='rata-kanan'>
													<?php 	
														$variance_grandtotal_und_exp = $grandtotal_und_exp_actual - $grandtotal_und_exp_budget;
														($variance_grandtotal_und_exp <= 0) ? $textcolor='text-danger-600' : $textcolor='text-success-600'; 
													?>
													<strong><div class="<?php echo $textcolor?>"><?php echo number_format($variance_grandtotal_und_exp,0); ?></div></strong>													
												</td>
												<!-- END MTD -->
												
												<!-- BEGIN LAST MTD -->
												<td class='rata-kanan'>
													<?php 
														if($monthact == '01'){ //jika difilter adalah bulan januari 2019 maka last monthnya adalah desember 2018 tahun sebelumnya
															$grandtotal_und_payroll_actual_lastmtd = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_actual('7', $idhotel_custom, $lastmonth, $lastyear);
															$grandtotal_und_opr_exp_actual_lastmtd = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_actual('8', $idhotel_custom, $lastmonth, $lastyear);
														}else{
															$grandtotal_und_payroll_actual_lastmtd = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_actual('7', $idhotel_custom, $lastmonth, $yearact);
															$grandtotal_und_opr_exp_actual_lastmtd = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_actual('8', $idhotel_custom, $lastmonth, $yearact);
														}
														
														$grandtotal_und_exp_actual_lastmtd = $grandtotal_und_payroll_actual_lastmtd->GRANDTOTAL_PNLCATEGORY + $grandtotal_und_opr_exp_actual_lastmtd->GRANDTOTAL_PNLCATEGORY;
													?>	
													<strong><?php echo number_format($grandtotal_und_exp_actual_lastmtd,0);?></strong>
												</td>
												<td class='rata-kanan'> 
													<strong>
														<?php
															if($grandtotal_und_exp_actual_lastmtd !=0 && $grandtotal_totalsalesactual_lastmtd->GRANDTOTAL_PNLCATEGORY != 0){
																echo number_format(($grandtotal_und_exp_actual_lastmtd/$grandtotal_totalsalesactual_lastmtd->GRANDTOTAL_PNLCATEGORY)*100,2).'%';
															}else{
																echo '0%';
															}															
														?>
													</strong>
												</td>
												<td class='rata-kanan'>
													<?php 
														if($monthact == '01'){ //jika difilter adalah bulan januari 2019 maka last monthnya adalah desember 2018 tahun sebelumnya
															$grandtotal_und_payroll_budget_lastmtd = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_budget('7', $idhotel_custom, $lastmonth, $lastyear);
															$grandtotal_und_opr_exp_budget_lastmtd = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_budget('8', $idhotel_custom, $lastmonth, $lastyear);
														}else{
															$grandtotal_und_payroll_budget_lastmtd = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_budget('7', $idhotel_custom, $lastmonth, $yearact);
															$grandtotal_und_opr_exp_budget_lastmtd = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_budget('8', $idhotel_custom, $lastmonth, $yearact);
														}
														
														$grandtotal_und_exp_budget_lastmtd = $grandtotal_und_payroll_budget_lastmtd->GRANDTOTAL_PNLCATEGORY + $grandtotal_und_opr_exp_budget_lastmtd->GRANDTOTAL_PNLCATEGORY;
													?>	
													<strong><?php echo number_format($grandtotal_und_exp_budget_lastmtd,0);?></strong>
												</td>
												<td class='rata-kanan'> 
													<strong>
														<?php
															if($grandtotal_und_exp_budget_lastmtd !=0 && $grandtotal_totalsalesbudget_lastmtd->GRANDTOTAL_PNLCATEGORY != 0){
																echo number_format(($grandtotal_und_exp_budget_lastmtd/$grandtotal_totalsalesbudget_lastmtd->GRANDTOTAL_PNLCATEGORY)*100,2).'%';
															}else{
																echo '0%';
															}															
														?>
													</strong>
												</td>
												<td class='rata-kanan'>
													<?php 	
														$variance_grandtotal_und_exp_lastmtd = $grandtotal_und_exp_actual_lastmtd - $grandtotal_und_exp_budget_lastmtd;
														($variance_grandtotal_und_exp_lastmtd <= 0) ? $textcolor='text-danger-600' : $textcolor='text-success-600'; 
													?>
													<strong><div class="<?php echo $textcolor?>"><?php echo number_format($variance_grandtotal_und_exp_lastmtd,0); ?></div></strong>													
												</td>
												<!-- END LAST MTD -->

												<!-- BEGIN YTD -->
												<td class='rata-kanan'>
													<?php 
														$grandtotal_und_payroll_actual_ytd = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_actual_ytd('7', $idhotel_custom, $startdate_ytd, $enddate_ytd);
														$grandtotal_und_opr_exp_actual_ytd = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_actual_ytd('8', $idhotel_custom, $startdate_ytd, $enddate_ytd);
														$grandtotal_und_exp_actual_ytd = $grandtotal_und_payroll_actual_ytd->GRANDTOTAL_PNLCATEGORY + $grandtotal_und_opr_exp_actual_ytd->GRANDTOTAL_PNLCATEGORY;
													?>	
													<strong><?php echo number_format($grandtotal_und_exp_actual_ytd,0);?></strong>
												</td>
												<td class='rata-kanan'> 
													<strong>
														<?php
															if($grandtotal_und_exp_actual_ytd !=0 && $grandtotal_totalsalesactual_ytd->GRANDTOTAL_PNLCATEGORY != 0){
																echo number_format(($grandtotal_und_exp_actual_ytd/$grandtotal_totalsalesactual_ytd->GRANDTOTAL_PNLCATEGORY)*100,2).'%';
															}else{
																echo '0%';
															}															
														?>
													</strong>
												</td>
												<td class='rata-kanan'>
													<?php 
														$grandtotal_und_payroll_budget_ytd = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_budget_ytd('7', $idhotel_custom, $startdate_ytd, $enddate_ytd);
														$grandtotal_und_opr_exp_budget_ytd = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_budget_ytd('8', $idhotel_custom, $startdate_ytd, $enddate_ytd);
														$grandtotal_und_exp_budget_ytd = $grandtotal_und_payroll_budget_ytd->GRANDTOTAL_PNLCATEGORY + $grandtotal_und_opr_exp_budget_ytd->GRANDTOTAL_PNLCATEGORY;
													?>	
													<strong><?php echo number_format($grandtotal_und_exp_budget_ytd,0);?></strong>
												</td>
												<td class='rata-kanan'> 
													<strong>
														<?php
															if($grandtotal_und_exp_budget_ytd !=0 && $grandtotal_totalsalesbudget_ytd->GRANDTOTAL_PNLCATEGORY != 0){
																echo number_format(($grandtotal_und_exp_budget_ytd/$grandtotal_totalsalesbudget_ytd->GRANDTOTAL_PNLCATEGORY)*100,2).'%';
															}else{
																echo '0%';
															}															
														?>
													</strong>
												</td>
												<td class='rata-kanan'>
													<?php 	
														$variance_grandtotal_und_exp_ytd = $grandtotal_und_exp_actual_ytd - $grandtotal_und_exp_budget_ytd;
														($variance_grandtotal_und_exp_ytd <= 0) ? $textcolor='text-danger-600' : $textcolor='text-success-600'; 
													?>
													<strong><div class="<?php echo $textcolor?>"><?php echo number_format($variance_grandtotal_und_exp_ytd,0); ?></div></strong>													
												</td>
												<!-- END YTD -->
											</tr>

											<tr>
												<td><strong>GROSS OPERATING PROFIT</strong></td>
												
												<!-- BEGIN MTD -->
												<td class='rata-kanan'>
													<?php 
														$grandtotal_dept_profit_actual = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_actual('6', $idhotel_custom, $monthact, $yearact);
														$grandtotal_und_payroll_actual = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_actual('7', $idhotel_custom, $monthact, $yearact);
														$grandtotal_und_opr_exp_actual = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_actual('8', $idhotel_custom, $monthact, $yearact);
														$grandtotal_gross_opr_profit_actual = $grandtotal_dept_profit_actual->GRANDTOTAL_PNLCATEGORY - ($grandtotal_und_payroll_actual->GRANDTOTAL_PNLCATEGORY + $grandtotal_und_opr_exp_actual->GRANDTOTAL_PNLCATEGORY);														
													?>	
													<strong><?php echo number_format($grandtotal_gross_opr_profit_actual,0);?></strong>
												</td>
												<td class='rata-kanan'>
													<strong>
														<?php
															if($grandtotal_gross_opr_profit_actual != 0 && $grandtotal_totalsalesactual->GRANDTOTAL_PNLCATEGORY != 0){
																echo number_format(($grandtotal_gross_opr_profit_actual/$grandtotal_totalsalesactual->GRANDTOTAL_PNLCATEGORY)*100,2).'%';
															}else{
																echo '0%';
															}
															
														?>
													</strong>
												</td>												
												<td class='rata-kanan'>
													<?php 
														$grandtotal_dept_profit_budget = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_budget('6', $idhotel_custom, $monthact, $yearact);
														$grandtotal_und_payroll_budget = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_budget('7', $idhotel_custom, $monthact, $yearact);
														$grandtotal_und_opr_exp_budget = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_budget('8', $idhotel_custom, $monthact, $yearact);
														$grandtotal_gross_opr_profit_budget = $grandtotal_dept_profit_budget->GRANDTOTAL_PNLCATEGORY - ($grandtotal_und_payroll_budget->GRANDTOTAL_PNLCATEGORY + $grandtotal_und_opr_exp_budget->GRANDTOTAL_PNLCATEGORY);														
													?>	
													<strong><?php echo number_format($grandtotal_gross_opr_profit_budget,0);?></strong>
												</td>
												<td class='rata-kanan'>
													<strong>
														<?php
															if($grandtotal_gross_opr_profit_budget != 0 && $grandtotal_totalsalesbudget->GRANDTOTAL_PNLCATEGORY != 0){
																echo number_format(($grandtotal_gross_opr_profit_budget/$grandtotal_totalsalesbudget->GRANDTOTAL_PNLCATEGORY)*100,2).'%';
															}else{
																echo '0%';
															}
															
														?>
													</strong>
												</td>	
												<td class='rata-kanan'>
													<?php 	
														$variance_grandtotal_gross_opr_profit = $grandtotal_gross_opr_profit_actual - $grandtotal_gross_opr_profit_budget;
														($variance_grandtotal_gross_opr_profit <= 0) ? $textcolor='text-danger-600' : $textcolor='text-success-600'; 
													?>
													<strong><div class="<?php echo $textcolor?>"><?php echo number_format($variance_grandtotal_gross_opr_profit,0); ?></div></strong>
													
												</td>
												<!-- END MTD -->
												
												<!-- BEGIN LAST MTD -->
												<td class='rata-kanan'>
													<?php 
														if($monthact == '01'){ //jika difilter adalah bulan januari 2019 maka last monthnya adalah desember 2018 tahun sebelumnya
															$grandtotal_dept_profit_actual_lastmtd = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_actual('6', $idhotel_custom, $lastmonth, $lastyear);
															$grandtotal_und_payroll_actual_lastmtd  = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_actual('7', $idhotel_custom, $lastmonth, $lastyear);
															$grandtotal_und_opr_exp_actual_lastmtd  = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_actual('8', $idhotel_custom, $lastmonth, $lastyear);
														}else{
															$grandtotal_dept_profit_actual_lastmtd  = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_actual('6', $idhotel_custom, $lastmonth, $yearact);
															$grandtotal_und_payroll_actual_lastmtd  = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_actual('7', $idhotel_custom, $lastmonth, $yearact);
															$grandtotal_und_opr_exp_actual_lastmtd  = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_actual('8', $idhotel_custom, $lastmonth, $yearact);
														}
														
														$grandtotal_gross_opr_profit_actual_lastmtd  = $grandtotal_dept_profit_actual_lastmtd->GRANDTOTAL_PNLCATEGORY - ($grandtotal_und_payroll_actual_lastmtd->GRANDTOTAL_PNLCATEGORY + $grandtotal_und_opr_exp_actual_lastmtd->GRANDTOTAL_PNLCATEGORY);
													?>	
													<strong><?php echo number_format($grandtotal_gross_opr_profit_actual_lastmtd ,0);?></strong>
												</td>
												<td class='rata-kanan'>
													<strong>
														<?php
															if($grandtotal_gross_opr_profit_actual_lastmtd != 0 && $grandtotal_totalsalesactual_lastmtd->GRANDTOTAL_PNLCATEGORY != 0){
																echo number_format(($grandtotal_gross_opr_profit_actual_lastmtd/$grandtotal_totalsalesactual_lastmtd->GRANDTOTAL_PNLCATEGORY)*100,2).'%';
															}else{
																echo '0%';
															}
															
														?>
													</strong>
												</td>
												<td class='rata-kanan'>
													<?php 
														if($monthact == '01'){ //jika difilter adalah bulan januari 2019 maka last monthnya adalah desember 2018 tahun sebelumnya
															$grandtotal_dept_profit_budget_lastmtd  = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_budget('6', $idhotel_custom, $lastmonth, $lastyear);
															$grandtotal_und_payroll_budget_lastmtd  = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_budget('7', $idhotel_custom, $lastmonth, $lastyear);
															$grandtotal_und_opr_exp_budget_lastmtd  = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_budget('8', $idhotel_custom, $lastmonth, $lastyear);
														}else{
															$grandtotal_dept_profit_budget_lastmtd  = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_budget('6', $idhotel_custom, $lastmonth, $yearact);
															$grandtotal_und_payroll_budget_lastmtd  = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_budget('7', $idhotel_custom, $lastmonth, $yearact);
															$grandtotal_und_opr_exp_budget_lastmtd  = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_budget('8', $idhotel_custom, $lastmonth, $yearact);
														}
														
														$grandtotal_gross_opr_profit_budget_lastmtd  = $grandtotal_dept_profit_budget_lastmtd->GRANDTOTAL_PNLCATEGORY - ($grandtotal_und_payroll_budget_lastmtd->GRANDTOTAL_PNLCATEGORY + $grandtotal_und_opr_exp_budget_lastmtd->GRANDTOTAL_PNLCATEGORY);
													?>	
													<strong><?php echo number_format($grandtotal_gross_opr_profit_budget_lastmtd ,0);?></strong>
												</td>
												<td class='rata-kanan'>
													<strong>
														<?php
															if($grandtotal_gross_opr_profit_budget_lastmtd != 0 && $grandtotal_totalsalesbudget_lastmtd->GRANDTOTAL_PNLCATEGORY != 0){
																echo number_format(($grandtotal_gross_opr_profit_budget_lastmtd/$grandtotal_totalsalesbudget_lastmtd->GRANDTOTAL_PNLCATEGORY)*100,2).'%';
															}else{
																echo '0%';
															}
															
														?>
													</strong>
												</td>											
												<td class='rata-kanan'>
													<?php 	
														$variance_grandtotal_gross_opr_profit_lastmtd = $grandtotal_gross_opr_profit_actual_lastmtd - $grandtotal_gross_opr_profit_budget_lastmtd;
														($variance_grandtotal_gross_opr_profit_lastmtd <= 0) ? $textcolor='text-danger-600' : $textcolor='text-success-600'; 
													?>
													<strong><div class="<?php echo $textcolor?>"><?php echo number_format($variance_grandtotal_gross_opr_profit_lastmtd,0); ?></div></strong>
													
												</td>
												<!-- END LAST MTD -->
												
												<!-- BEGIN YTD -->
												<td class='rata-kanan'>
													<?php 
														$grandtotal_dept_profit_actual_ytd = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_actual_ytd('6', $idhotel_custom, $startdate_ytd, $enddate_ytd);
														$grandtotal_und_payroll_actual_ytd = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_actual_ytd('7', $idhotel_custom, $startdate_ytd, $enddate_ytd);
														$grandtotal_und_opr_exp_actual_ytd = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_actual_ytd('8', $idhotel_custom, $startdate_ytd, $enddate_ytd);
														$grandtotal_gross_opr_profit_actual_ytd = $grandtotal_dept_profit_actual_ytd->GRANDTOTAL_PNLCATEGORY - ($grandtotal_und_payroll_actual_ytd->GRANDTOTAL_PNLCATEGORY + $grandtotal_und_opr_exp_actual_ytd->GRANDTOTAL_PNLCATEGORY);														
													?>	
													<strong><?php echo number_format($grandtotal_gross_opr_profit_actual_ytd,0);?></strong>
												</td>
												<td class='rata-kanan'>
													<strong>
														<?php
															if($grandtotal_gross_opr_profit_actual_ytd != 0 && $grandtotal_totalsalesactual_ytd->GRANDTOTAL_PNLCATEGORY != 0){
																echo number_format(($grandtotal_gross_opr_profit_actual_ytd/$grandtotal_totalsalesactual_ytd->GRANDTOTAL_PNLCATEGORY)*100,2).'%';
															}else{
																echo '0%';
															}
															
														?>
													</strong>
												</td>												
												<td class='rata-kanan'>
													<?php 
														$grandtotal_dept_profit_budget_ytd = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_budget_ytd('6', $idhotel_custom, $startdate_ytd, $enddate_ytd);
														$grandtotal_und_payroll_budget_ytd = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_budget_ytd('7', $idhotel_custom, $startdate_ytd, $enddate_ytd);
														$grandtotal_und_opr_exp_budget_ytd = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_budget_ytd('8', $idhotel_custom, $startdate_ytd, $enddate_ytd);
														$grandtotal_gross_opr_profit_budget_ytd = $grandtotal_dept_profit_budget_ytd->GRANDTOTAL_PNLCATEGORY - ($grandtotal_und_payroll_budget_ytd->GRANDTOTAL_PNLCATEGORY + $grandtotal_und_opr_exp_budget_ytd->GRANDTOTAL_PNLCATEGORY);														
													?>	
													<strong><?php echo number_format($grandtotal_gross_opr_profit_budget_ytd,0);?></strong>
												</td>
												<td class='rata-kanan'>
													<strong>
														<?php
															if($grandtotal_gross_opr_profit_budget_ytd != 0 && $grandtotal_totalsalesbudget_ytd->GRANDTOTAL_PNLCATEGORY != 0){
																echo number_format(($grandtotal_gross_opr_profit_budget_ytd/$grandtotal_totalsalesbudget_ytd->GRANDTOTAL_PNLCATEGORY)*100,2).'%';
															}else{
																echo '0%';
															}
															
														?>
													</strong>
												</td>	
												<td class='rata-kanan'>
													<?php 	
														$variance_grandtotal_gross_opr_profit_ytd = $grandtotal_gross_opr_profit_actual_ytd - $grandtotal_gross_opr_profit_budget_ytd;
														($variance_grandtotal_gross_opr_profit_ytd <= 0) ? $textcolor='text-danger-600' : $textcolor='text-success-600'; 
													?>
													<strong><div class="<?php echo $textcolor?>"><?php echo number_format($variance_grandtotal_gross_opr_profit_ytd,0); ?></div></strong>
													
												</td>
												<!-- END YTD -->
											</tr>
											
											<tr>
												<td><strong>G.O.P. %</strong></td>	
												
												<!-- BEGIN MTD -->
												<td class='rata-kanan'>-</td>												
												<td class='rata-kanan'>
													<?php 
														$grandtotal_total_sales_actual = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_actual('2', $idhotel_custom, $monthact, $yearact);
														$grandtotal_dept_profit_actual = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_actual('6', $idhotel_custom, $monthact, $yearact);
														$grandtotal_und_payroll_actual = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_actual('7', $idhotel_custom, $monthact, $yearact);
														$grandtotal_und_opr_exp_actual = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_actual('8', $idhotel_custom, $monthact, $yearact);
														
														$grandtotal_gross_opr_profit_actual = $grandtotal_dept_profit_actual->GRANDTOTAL_PNLCATEGORY - ($grandtotal_und_payroll_actual->GRANDTOTAL_PNLCATEGORY + $grandtotal_und_opr_exp_actual->GRANDTOTAL_PNLCATEGORY);	
														if($grandtotal_gross_opr_profit_actual != 0 && $grandtotal_total_sales_actual->GRANDTOTAL_PNLCATEGORY !=0){
															$grandtotal_gop_actual = ($grandtotal_gross_opr_profit_actual / $grandtotal_total_sales_actual->GRANDTOTAL_PNLCATEGORY)*100;	
														}else{
															$grandtotal_gop_actual = 0;
														}
																										
													?>	
													<strong><?php echo number_format($grandtotal_gop_actual,2).'%';?></strong>
												</td>
												<td class='rata-kanan'>-</td>	
												<td class='rata-kanan'>
													<?php 
														$grandtotal_total_sales_budget = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_budget('2', $idhotel_custom, $monthact, $yearact);
														$grandtotal_dept_profit_budget = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_budget('6', $idhotel_custom, $monthact, $yearact);
														$grandtotal_und_payroll_budget = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_budget('7', $idhotel_custom, $monthact, $yearact);
														$grandtotal_und_opr_exp_budget = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_budget('8', $idhotel_custom, $monthact, $yearact);
														
														$grandtotal_gross_opr_profit_budget = $grandtotal_dept_profit_budget->GRANDTOTAL_PNLCATEGORY - ($grandtotal_und_payroll_budget->GRANDTOTAL_PNLCATEGORY + $grandtotal_und_opr_exp_budget->GRANDTOTAL_PNLCATEGORY);	
														if($grandtotal_gross_opr_profit_budget != 0 && $grandtotal_total_sales_budget->GRANDTOTAL_PNLCATEGORY !=0){
															$grandtotal_gop_budget = ($grandtotal_gross_opr_profit_budget / $grandtotal_total_sales_budget->GRANDTOTAL_PNLCATEGORY)*100;	
														}else{
															$grandtotal_gop_budget = 0;
														}
																										
													?>	
													<strong><?php echo number_format($grandtotal_gop_budget,2).'%';?></strong>
												</td>
												<td class='rata-kanan'>
													<?php 	
														$variance_grandtotal_gop = $grandtotal_gop_actual - $grandtotal_gop_budget;
														($variance_grandtotal_gop <= 0) ? $textcolor='text-danger-600' : $textcolor='text-success-600'; 
													?>
													<strong><div class="<?php echo $textcolor?>"><?php echo number_format($variance_grandtotal_gop,2).'%'; ?></div></strong>													
												</td>
												<!-- END MTD -->
												
												<!-- BEGIN LAST MTD -->
												<td class='rata-kanan'>-</td>
												<td class='rata-kanan'>
													<?php 
														if($monthact == '01'){ //jika difilter adalah bulan januari 2019 maka last monthnya adalah desember 2018 tahun sebelumnya
															$grandtotal_total_sales_actual_lastmtd = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_actual('2', $idhotel_custom, $lastmonth, $yearact);
															$grandtotal_dept_profit_actual_lastmtd = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_actual('6', $idhotel_custom, $lastmonth, $yearact);
															$grandtotal_und_payroll_actual_lastmtd = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_actual('7', $idhotel_custom, $lastmonth, $yearact);
															$grandtotal_und_opr_exp_actual_lastmtd = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_actual('8', $idhotel_custom, $lastmonth, $yearact);
														}else{
															$grandtotal_total_sales_actual_lastmtd = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_actual('2', $idhotel_custom, $lastmonth, $yearact);
															$grandtotal_dept_profit_actual_lastmtd = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_actual('6', $idhotel_custom, $lastmonth, $yearact);
															$grandtotal_und_payroll_actual_lastmtd = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_actual('7', $idhotel_custom, $lastmonth, $yearact);
															$grandtotal_und_opr_exp_actual_lastmtd = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_actual('8', $idhotel_custom, $lastmonth, $yearact);
														}
														
														$grandtotal_gross_opr_profit_actual_lastmtd = $grandtotal_dept_profit_actual_lastmtd->GRANDTOTAL_PNLCATEGORY - ($grandtotal_und_payroll_actual_lastmtd->GRANDTOTAL_PNLCATEGORY + $grandtotal_und_opr_exp_actual_lastmtd->GRANDTOTAL_PNLCATEGORY);	
														if($grandtotal_gross_opr_profit_actual_lastmtd != 0 && $grandtotal_total_sales_actual_lastmtd->GRANDTOTAL_PNLCATEGORY !=0){
															$grandtotal_gop_actual_lastmtd = ($grandtotal_gross_opr_profit_actual_lastmtd / $grandtotal_total_sales_actual_lastmtd->GRANDTOTAL_PNLCATEGORY)*100;	
														}else{
															$grandtotal_gop_actual_lastmtd = 0;
														}
																										
													?>	
													<strong><?php echo number_format($grandtotal_gop_actual_lastmtd,2).'%';?></strong>
												</td>
												<td class='rata-kanan'>-</td>
												<td class='rata-kanan'>
													<?php 
														if($monthact == '01'){ //jika difilter adalah bulan januari 2019 maka last monthnya adalah desember 2018 tahun sebelumnya
															$grandtotal_total_sales_budget_lastmtd = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_budget('2', $idhotel_custom, $lastmonth, $lastyear);
															$grandtotal_dept_profit_budget_lastmtd = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_budget('6', $idhotel_custom, $lastmonth, $lastyear);
															$grandtotal_und_payroll_budget_lastmtd = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_budget('7', $idhotel_custom, $lastmonth, $lastyear);
															$grandtotal_und_opr_exp_budget_lastmtd = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_budget('8', $idhotel_custom, $lastmonth, $lastyear);
														}else{
															$grandtotal_total_sales_budget_lastmtd = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_budget('2', $idhotel_custom, $lastmonth, $yearact);
															$grandtotal_dept_profit_budget_lastmtd = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_budget('6', $idhotel_custom, $lastmonth, $yearact);
															$grandtotal_und_payroll_budget_lastmtd = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_budget('7', $idhotel_custom, $lastmonth, $yearact);
															$grandtotal_und_opr_exp_budget_lastmtd = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_budget('8', $idhotel_custom, $lastmonth, $yearact);
														}
														
														$grandtotal_gross_opr_profit_budget_lastmtd = $grandtotal_dept_profit_budget_lastmtd->GRANDTOTAL_PNLCATEGORY - ($grandtotal_und_payroll_budget_lastmtd->GRANDTOTAL_PNLCATEGORY + $grandtotal_und_opr_exp_budget_lastmtd->GRANDTOTAL_PNLCATEGORY);	
														if($grandtotal_gross_opr_profit_budget_lastmtd != 0 && $grandtotal_total_sales_budget_lastmtd->GRANDTOTAL_PNLCATEGORY !=0){
															$grandtotal_gop_budget_lastmtd = ($grandtotal_gross_opr_profit_budget_lastmtd / $grandtotal_total_sales_budget_lastmtd->GRANDTOTAL_PNLCATEGORY)*100;	
														}else{
															$grandtotal_gop_budget_lastmtd = 0;
														}
																										
													?>	
													<strong><?php echo number_format($grandtotal_gop_budget_lastmtd,2).'%';?></strong>
												</td>
												<td class='rata-kanan'>
													<?php 	
														$variance_grandtotal_gop_lastmtd = $grandtotal_gop_actual_lastmtd  - $grandtotal_gop_budget_lastmtd ;
														($variance_grandtotal_gop_lastmtd  <= 0) ? $textcolor='text-danger-600' : $textcolor='text-success-600'; 
													?>
													<strong><div class="<?php echo $textcolor?>"><?php echo number_format($variance_grandtotal_gop_lastmtd ,2).'%'; ?></div></strong>													
												</td>
												<!-- END LAST MTD -->
												
												<!-- BEGIN YTD -->
												<td class='rata-kanan'>-</td>	
												<td class='rata-kanan'>
													<?php 
														$grandtotal_total_sales_actual_ytd = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_actual_ytd('2', $idhotel_custom, $startdate_ytd, $enddate_ytd);
														$grandtotal_dept_profit_actual_ytd = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_actual_ytd('6', $idhotel_custom, $startdate_ytd, $enddate_ytd);
														$grandtotal_und_payroll_actual_ytd = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_actual_ytd('7', $idhotel_custom, $startdate_ytd, $enddate_ytd);
														$grandtotal_und_opr_exp_actual_ytd = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_actual_ytd('8', $idhotel_custom, $startdate_ytd, $enddate_ytd);
														
														$grandtotal_gross_opr_profit_actual_ytd = $grandtotal_dept_profit_actual_ytd->GRANDTOTAL_PNLCATEGORY - ($grandtotal_und_payroll_actual_ytd->GRANDTOTAL_PNLCATEGORY + $grandtotal_und_opr_exp_actual_ytd->GRANDTOTAL_PNLCATEGORY);	
														if($grandtotal_gross_opr_profit_actual_ytd != 0 && $grandtotal_total_sales_actual_ytd->GRANDTOTAL_PNLCATEGORY !=0){
															$grandtotal_gop_actual_ytd = ($grandtotal_gross_opr_profit_actual_ytd / $grandtotal_total_sales_actual_ytd->GRANDTOTAL_PNLCATEGORY)*100;	
														}else{
															$grandtotal_gop_actual_ytd = 0;
														}
																										
													?>	
													<strong><?php echo number_format($grandtotal_gop_actual_ytd,2).'%';?></strong>
												</td>
												<td class='rata-kanan'>-</td>	
												<td class='rata-kanan'>
													<?php 
														$grandtotal_total_sales_budget_ytd = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_budget_ytd('2', $idhotel_custom, $startdate_ytd, $enddate_ytd);
														$grandtotal_dept_profit_budget_ytd = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_budget_ytd('6', $idhotel_custom, $startdate_ytd, $enddate_ytd);
														$grandtotal_und_payroll_budget_ytd = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_budget_ytd('7', $idhotel_custom, $startdate_ytd, $enddate_ytd);
														$grandtotal_und_opr_exp_budget_ytd = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_budget_ytd('8', $idhotel_custom, $startdate_ytd, $enddate_ytd);
														
														$grandtotal_gross_opr_profit_budget_ytd = $grandtotal_dept_profit_budget_ytd->GRANDTOTAL_PNLCATEGORY - ($grandtotal_und_payroll_budget_ytd->GRANDTOTAL_PNLCATEGORY + $grandtotal_und_opr_exp_budget_ytd->GRANDTOTAL_PNLCATEGORY);	
														if($grandtotal_gross_opr_profit_budget_ytd != 0 && $grandtotal_total_sales_budget_ytd->GRANDTOTAL_PNLCATEGORY !=0){
															$grandtotal_gop_budget_ytd = ($grandtotal_gross_opr_profit_budget_ytd / $grandtotal_total_sales_budget_ytd->GRANDTOTAL_PNLCATEGORY)*100;	
														}else{
															$grandtotal_gop_budget_ytd = 0;
														}
																										
													?>	
													<strong><?php echo number_format($grandtotal_gop_budget_ytd,2).'%';?></strong>
												</td>
												<td class='rata-kanan'>
													<?php 	
														$variance_grandtotal_gop_ytd = $grandtotal_gop_actual_ytd - $grandtotal_gop_budget_ytd;
														($variance_grandtotal_gop_ytd <= 0) ? $textcolor='text-danger-600' : $textcolor='text-success-600'; 
													?>
													<strong><div class="<?php echo $textcolor?>"><?php echo number_format($variance_grandtotal_gop_ytd,2).'%'; ?></div></strong>													
												</td>
												<!-- END YTD -->
											</tr>

											<tr>
												<td><strong>PAYROLL</strong></td>
												
												<!-- BEGIN MTD -->
												<td class='rata-kanan'>-</td>	
												<td class="rata-kanan">
													<?php
													$grandtotal_total_sales_actual = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_actual('2', $idhotel_custom, $monthact, $yearact);
													$grandtotal_payroll_rel_actual = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_actual('4', $idhotel_custom, $monthact, $yearact);
													$grandtotal_und_payroll_actual = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_actual('7', $idhotel_custom, $monthact, $yearact);
													if($grandtotal_payroll_rel_actual->GRANDTOTAL_PNLCATEGORY != 0 && $grandtotal_und_payroll_actual->GRANDTOTAL_PNLCATEGORY != 0 && $grandtotal_total_sales_actual->GRANDTOTAL_PNLCATEGORY !=0){
														$grandtotal_all_payroll_actual = (($grandtotal_payroll_rel_actual->GRANDTOTAL_PNLCATEGORY + $grandtotal_und_payroll_actual->GRANDTOTAL_PNLCATEGORY)  / $grandtotal_total_sales_actual->GRANDTOTAL_PNLCATEGORY)*100;
													}else{
														$grandtotal_all_payroll_actual = 0;
													}
													?>
													<strong><?php echo number_format($grandtotal_all_payroll_actual,2).'%';?></strong>
												</td>
												<td class='rata-kanan'>-</td>	
												<td class="rata-kanan">
													<?php
													$grandtotal_total_sales_budget = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_budget('2', $idhotel_custom, $monthact, $yearact);
													$grandtotal_payroll_rel_budget = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_budget('4', $idhotel_custom, $monthact, $yearact);
													$grandtotal_und_payroll_budget = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_budget('7', $idhotel_custom, $monthact, $yearact);
													if($grandtotal_payroll_rel_budget->GRANDTOTAL_PNLCATEGORY != 0 && $grandtotal_und_payroll_budget->GRANDTOTAL_PNLCATEGORY != 0 && $grandtotal_total_sales_budget->GRANDTOTAL_PNLCATEGORY !=0){
														$grandtotal_all_payroll_budget = (($grandtotal_payroll_rel_budget->GRANDTOTAL_PNLCATEGORY + $grandtotal_und_payroll_budget->GRANDTOTAL_PNLCATEGORY)  / $grandtotal_total_sales_budget->GRANDTOTAL_PNLCATEGORY)*100;
													}else{
														$grandtotal_all_payroll_budget = 0;
													}
													?>
													<strong><?php echo number_format($grandtotal_all_payroll_budget,2).'%';?></strong>
												</td>
												<td class='rata-kanan'>
													<?php 	
														$variance_grandtotal_all_payroll = $grandtotal_all_payroll_actual - $grandtotal_all_payroll_budget;
														($variance_grandtotal_all_payroll <= 0) ? $textcolor='text-danger-600' : $textcolor='text-success-600'; 
													?>
													<strong><div class="<?php echo $textcolor?>"><?php echo number_format($variance_grandtotal_all_payroll,2).'%'; ?></div></strong>													
												</td>
												<!-- END MTD -->
												
												<!-- BEGIN LAST MTD -->
												<td class='rata-kanan'>-</td>
												<td class='rata-kanan'>
													<?php 
														if($monthact == '01'){ //jika difilter adalah bulan januari 2019 maka last monthnya adalah desember 2018 tahun sebelumnya
															$grandtotal_total_sales_actual_lastmtd = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_actual('2', $idhotel_custom, $lastmonth, $lastyear);
															$grandtotal_payroll_rel_actual_lastmtd = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_actual('4', $idhotel_custom, $lastmonth, $lastyear);
															$grandtotal_und_payroll_actual_lastmtd = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_actual('7', $idhotel_custom, $lastmonth, $lastyear);
														}else{
															$grandtotal_total_sales_actual_lastmtd = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_actual('2', $idhotel_custom, $lastmonth, $yearact);
															$grandtotal_payroll_rel_actual_lastmtd = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_actual('4', $idhotel_custom, $lastmonth, $yearact);
															$grandtotal_und_payroll_actual_lastmtd = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_actual('7', $idhotel_custom, $lastmonth, $yearact);
														}
														
														if($grandtotal_payroll_rel_actual_lastmtd->GRANDTOTAL_PNLCATEGORY != 0 && $grandtotal_und_payroll_actual_lastmtd->GRANDTOTAL_PNLCATEGORY != 0 && $grandtotal_total_sales_actual_lastmtd->GRANDTOTAL_PNLCATEGORY !=0){
															$grandtotal_all_payroll_actual_lastmtd = (($grandtotal_payroll_rel_actual_lastmtd->GRANDTOTAL_PNLCATEGORY + $grandtotal_und_payroll_actual_lastmtd->GRANDTOTAL_PNLCATEGORY)  / $grandtotal_total_sales_actual_lastmtd->GRANDTOTAL_PNLCATEGORY)*100;
														}else{
															$grandtotal_all_payroll_actual_lastmtd = 0;
														}
														?>
														<strong><?php echo number_format($grandtotal_all_payroll_actual_lastmtd,2).'%';?></strong>
												</td>
												<td class='rata-kanan'>-</td>
												<td class='rata-kanan'>
													<?php 
														if($monthact == '01'){ //jika difilter adalah bulan januari 2019 maka last monthnya adalah desember 2018 tahun sebelumnya
															$grandtotal_total_sales_budget_lastmtd = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_budget('2', $idhotel_custom, $lastmonth, $lastyear);
															$grandtotal_payroll_rel_budget_lastmtd = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_budget('4', $idhotel_custom, $lastmonth, $lastyear);
															$grandtotal_und_payroll_budget_lastmtd = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_budget('7', $idhotel_custom, $lastmonth, $lastyear);
														}else{
															$grandtotal_total_sales_budget_lastmtd = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_budget('2', $idhotel_custom, $lastmonth, $yearact);
															$grandtotal_payroll_rel_budget_lastmtd = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_budget('4', $idhotel_custom, $lastmonth, $yearact);
															$grandtotal_und_payroll_budget_lastmtd = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_budget('7', $idhotel_custom, $lastmonth, $yearact);
														}
														
														if($grandtotal_payroll_rel_budget_lastmtd->GRANDTOTAL_PNLCATEGORY != 0 && $grandtotal_und_payroll_budget_lastmtd->GRANDTOTAL_PNLCATEGORY != 0 && $grandtotal_total_sales_budget_lastmtd->GRANDTOTAL_PNLCATEGORY !=0){
															$grandtotal_all_payroll_budget_lastmtd = (($grandtotal_payroll_rel_budget_lastmtd->GRANDTOTAL_PNLCATEGORY + $grandtotal_und_payroll_budget_lastmtd->GRANDTOTAL_PNLCATEGORY)  / $grandtotal_total_sales_budget_lastmtd->GRANDTOTAL_PNLCATEGORY)*100;
														}else{
															$grandtotal_all_payroll_budget_lastmtd = 0;
														}
														?>
														<strong><?php echo number_format($grandtotal_all_payroll_budget_lastmtd,2).'%';?></strong>
												</td>
												<td class='rata-kanan'>
													<?php 	
														$variance_grandtotal_all_payroll_lastmtd = $grandtotal_all_payroll_actual_lastmtd - $grandtotal_all_payroll_budget_lastmtd;
														($variance_grandtotal_all_payroll_lastmtd <= 0) ? $textcolor='text-danger-600' : $textcolor='text-success-600'; 
													?>
													<strong><div class="<?php echo $textcolor?>"><?php echo number_format($variance_grandtotal_all_payroll_lastmtd,2).'%'; ?></div></strong>													
												</td>
												<!-- END LAST MTD -->
												
												<!-- BEGIN YTD -->
												<td class='rata-kanan'>-</td>	
												<td class="rata-kanan">
													<?php
													$grandtotal_total_sales_actual_ytd = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_actual_ytd('2', $idhotel_custom, $startdate_ytd, $enddate_ytd);
													$grandtotal_payroll_rel_actual_ytd = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_actual_ytd('4', $idhotel_custom, $startdate_ytd, $enddate_ytd);
													$grandtotal_und_payroll_actual_ytd = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_actual_ytd('7', $idhotel_custom, $startdate_ytd, $enddate_ytd);
													if($grandtotal_payroll_rel_actual_ytd->GRANDTOTAL_PNLCATEGORY != 0 && $grandtotal_und_payroll_actual_ytd->GRANDTOTAL_PNLCATEGORY != 0 && $grandtotal_total_sales_actual_ytd->GRANDTOTAL_PNLCATEGORY !=0){
														$grandtotal_all_payroll_actual_ytd = (($grandtotal_payroll_rel_actual_ytd->GRANDTOTAL_PNLCATEGORY + $grandtotal_und_payroll_actual_ytd->GRANDTOTAL_PNLCATEGORY)  / $grandtotal_total_sales_actual_ytd->GRANDTOTAL_PNLCATEGORY)*100;
													}else{
														$grandtotal_all_payroll_actual_ytd = 0;
													}
													?>
													<strong><?php echo number_format($grandtotal_all_payroll_actual_ytd,2).'%';?></strong>
												</td>
												<td class='rata-kanan'>-</td>	
												<td class="rata-kanan">
													<?php
													$grandtotal_total_sales_budget_ytd = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_budget_ytd('2', $idhotel_custom, $startdate_ytd, $enddate_ytd);
													$grandtotal_payroll_rel_budget_ytd = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_budget_ytd('4', $idhotel_custom, $startdate_ytd, $enddate_ytd);
													$grandtotal_und_payroll_budget_ytd = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_budget_ytd('7', $idhotel_custom, $startdate_ytd, $enddate_ytd);
													if($grandtotal_payroll_rel_budget_ytd->GRANDTOTAL_PNLCATEGORY != 0 && $grandtotal_und_payroll_budget_ytd->GRANDTOTAL_PNLCATEGORY != 0 && $grandtotal_total_sales_budget_ytd->GRANDTOTAL_PNLCATEGORY !=0){
														$grandtotal_all_payroll_budget_ytd = (($grandtotal_payroll_rel_budget_ytd->GRANDTOTAL_PNLCATEGORY + $grandtotal_und_payroll_budget_ytd->GRANDTOTAL_PNLCATEGORY)  / $grandtotal_total_sales_budget_ytd->GRANDTOTAL_PNLCATEGORY)*100;
													}else{
														$grandtotal_all_payroll_budget_ytd = 0;
													}
													?>
													<strong><?php echo number_format($grandtotal_all_payroll_budget_ytd,2).'%';?></strong>
												</td>
												<td class='rata-kanan'>
													<?php 	
														$variance_grandtotal_all_payroll_ytd = $grandtotal_all_payroll_actual_ytd - $grandtotal_all_payroll_budget_ytd;
														($variance_grandtotal_all_payroll_ytd <= 0) ? $textcolor='text-danger-600' : $textcolor='text-success-600'; 
													?>
													<strong><div class="<?php echo $textcolor?>"><?php echo number_format($variance_grandtotal_all_payroll_ytd,2).'%'; ?></div></strong>													
												</td>
												<!-- END YTD -->
											</tr>

											<tr>
												<td><strong>ENERGY COST</strong></td>	
												
												<!-- BEGIN MTD -->
												<td class='rata-kanan'>-</td>	
												<td class="rata-kanan">
													<?php
													$grandtotal_total_sales_actual = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_actual('2', $idhotel_custom, $monthact, $yearact);
													$grandtotal_energy_cost_actual = $this->Smartreport_actual_model->get_total_actual('22', $idhotel_custom, $monthact, $yearact);
													if($grandtotal_energy_cost_actual->TOTAL_ACTUAL != 0 && $grandtotal_total_sales_actual->GRANDTOTAL_PNLCATEGORY != 0 ){
														$grandtotal_actual_energycost = ($grandtotal_energy_cost_actual->TOTAL_ACTUAL / $grandtotal_total_sales_actual->GRANDTOTAL_PNLCATEGORY)*100;	
													}else{
														$grandtotal_actual_energycost = 0;
													}
																									
													?>
													<strong><?php echo number_format($grandtotal_actual_energycost,2).'%';?></strong>
												</td>
												<td class='rata-kanan'>-</td>	
												<td class="rata-kanan">
													<?php
													$grandtotal_total_sales_budget = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_budget('2', $idhotel_custom, $monthact, $yearact);
													$grandtotal_energy_cost_budget = $this->Smartreport_actual_model->get_total_budget('22', $idhotel_custom, $monthact, $yearact);
													if($grandtotal_energy_cost_budget->TOTAL_BUDGET != 0 && $grandtotal_total_sales_budget->GRANDTOTAL_PNLCATEGORY != 0 ){
														$grandtotal_budget_energycost = ($grandtotal_energy_cost_budget->TOTAL_BUDGET / $grandtotal_total_sales_budget->GRANDTOTAL_PNLCATEGORY)*100;	
													}else{
														$grandtotal_budget_energycost = 0;
													}
																									
													?>
													<strong><?php echo number_format($grandtotal_budget_energycost,2).'%';?></strong>
												</td>
												<td class='rata-kanan'>
													<?php 	
														$variance_grandtotal_energycost = $grandtotal_actual_energycost - $grandtotal_budget_energycost;
														($variance_grandtotal_energycost <= 0) ? $textcolor='text-danger-600' : $textcolor='text-success-600'; 
													?>
													<strong><div class="<?php echo $textcolor?>"><?php echo number_format($variance_grandtotal_energycost,2).'%'; ?></div></strong>
													
												</td>
												<!-- END MTD -->

												<!-- BEGIN LAST MTD -->
												<td class='rata-kanan'>-</td>
												<td class='rata-kanan'>
													<?php 
														if($monthact == '01'){ //jika difilter adalah bulan januari 2019 maka last monthnya adalah desember 2018 tahun sebelumnya
															$grandtotal_total_sales_actual_lastmtd = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_actual('2', $idhotel_custom, $lastmonth, $lastyear);
															$grandtotal_energy_cost_actual_lastmtd = $this->Smartreport_actual_model->get_total_actual('22', $idhotel_custom, $lastmonth, $lastyear);
														}else{
															$grandtotal_total_sales_actual_lastmtd = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_actual('2', $idhotel_custom, $lastmonth, $yearact);
															$grandtotal_energy_cost_actual_lastmtd = $this->Smartreport_actual_model->get_total_actual('22', $idhotel_custom, $lastmonth, $yearact);
														}
														
														if($grandtotal_energy_cost_actual_lastmtd->TOTAL_ACTUAL != 0 && $grandtotal_total_sales_actual_lastmtd->GRANDTOTAL_PNLCATEGORY != 0 ){
															$grandtotal_actual_energycost_lastmtd = ($grandtotal_energy_cost_actual_lastmtd->TOTAL_ACTUAL / $grandtotal_total_sales_actual_lastmtd->GRANDTOTAL_PNLCATEGORY)*100;	
														}else{
															$grandtotal_actual_energycost_lastmtd = 0;
														}
																										
														?>
														<strong><?php echo number_format($grandtotal_actual_energycost_lastmtd,2).'%';?></strong>
												</td>
												<td class='rata-kanan'>-</td>
												<td class='rata-kanan'>
													<?php 
														if($monthact == '01'){ //jika difilter adalah bulan januari 2019 maka last monthnya adalah desember 2018 tahun sebelumnya
															$grandtotal_total_sales_budget_lastmtd = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_budget('2', $idhotel_custom, $lastmonth, $lastyear);
															$grandtotal_energy_cost_budget_lastmtd = $this->Smartreport_actual_model->get_total_budget('22', $idhotel_custom, $lastmonth, $lastyear);
														}else{
															$grandtotal_total_sales_budget_lastmtd = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_budget('2', $idhotel_custom, $lastmonth, $yearact);
															$grandtotal_energy_cost_budget_lastmtd = $this->Smartreport_actual_model->get_total_budget('22', $idhotel_custom, $lastmonth, $yearact);
														}
														
														if($grandtotal_energy_cost_budget_lastmtd->TOTAL_BUDGET != 0 && $grandtotal_total_sales_budget_lastmtd->GRANDTOTAL_PNLCATEGORY != 0 ){
															$grandtotal_budget_energycost_lastmtd = ($grandtotal_energy_cost_budget_lastmtd->TOTAL_BUDGET / $grandtotal_total_sales_budget_lastmtd->GRANDTOTAL_PNLCATEGORY)*100;	
														}else{
															$grandtotal_budget_energycost_lastmtd = 0;
														}
																										
														?>
														<strong><?php echo number_format($grandtotal_budget_energycost_lastmtd,2).'%';?></strong>
												</td>
												<td class='rata-kanan'>
													<?php 	
														$variance_grandtotal_energycost_lastmtd = $grandtotal_actual_energycost_lastmtd - $grandtotal_budget_energycost_lastmtd;
														($variance_grandtotal_energycost_lastmtd <= 0) ? $textcolor='text-danger-600' : $textcolor='text-success-600'; 
													?>
													<strong><div class="<?php echo $textcolor?>"><?php echo number_format($variance_grandtotal_energycost_lastmtd,2).'%'; ?></div></strong>
													
												</td>
												<!-- END LAST MTD -->

												<!-- BEGIN YTD -->
												<td class='rata-kanan'>-</td>	
												<td class="rata-kanan">
													<?php
													$grandtotal_total_sales_actual_ytd = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_actual_ytd('2', $idhotel_custom, $startdate_ytd, $enddate_ytd);
													$grandtotal_energy_cost_actual_ytd = $this->Smartreport_actual_model->get_total_actual_ytd('22', $idhotel_custom,$startdate_ytd, $enddate_ytd);
													if($grandtotal_energy_cost_actual_ytd->TOTAL_ACTUAL != 0 && $grandtotal_total_sales_actual_ytd->GRANDTOTAL_PNLCATEGORY != 0 ){
														$grandtotal_actual_energycost_ytd = ($grandtotal_energy_cost_actual_ytd->TOTAL_ACTUAL / $grandtotal_total_sales_actual_ytd->GRANDTOTAL_PNLCATEGORY)*100;	
													}else{
														$grandtotal_actual_energycost_ytd = 0;
													}
																									
													?>
													<strong><?php echo number_format($grandtotal_actual_energycost_ytd,2).'%';?></strong>
												</td>
												<td class='rata-kanan'>-</td>	
												<td class="rata-kanan">
													<?php
													$grandtotal_total_sales_budget_ytd = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_budget_ytd('2', $idhotel_custom, $startdate_ytd, $enddate_ytd);
													$grandtotal_energy_cost_budget_ytd = $this->Smartreport_actual_model->get_total_budget_ytd('22', $idhotel_custom, $startdate_ytd, $enddate_ytd);
													if($grandtotal_energy_cost_budget_ytd->TOTAL_BUDGET != 0 && $grandtotal_total_sales_budget_ytd->GRANDTOTAL_PNLCATEGORY != 0 ){
														$grandtotal_budget_energycost_ytd = ($grandtotal_energy_cost_budget_ytd->TOTAL_BUDGET / $grandtotal_total_sales_budget_ytd->GRANDTOTAL_PNLCATEGORY)*100;	
													}else{
														$grandtotal_budget_energycost_ytd = 0;
													}
																									
													?>
													<strong><?php echo number_format($grandtotal_budget_energycost_ytd,2).'%';?></strong>
												</td>
												<td class='rata-kanan'>
													<?php 	
														$variance_grandtotal_energycost_ytd = $grandtotal_actual_energycost_ytd - $grandtotal_budget_energycost_ytd;
														($variance_grandtotal_energycost_ytd <= 0) ? $textcolor='text-danger-600' : $textcolor='text-success-600'; 
													?>
													<strong><div class="<?php echo $textcolor?>"><?php echo number_format($variance_grandtotal_energycost_ytd,2).'%'; ?></div></strong>
													
												</td>
												<!-- END YTD -->
											</tr>

											<tr>
												<td><strong>EXPENSE</strong></td>
												
												<!-- BEGIN MTD -->
												<td class='rata-kanan'>-</td>	
												<td class="rata-kanan">
													<?php
														$grandtotal_total_sales_actual = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_actual('2', $idhotel_custom, $monthact, $yearact);
														$grandtotal_other_expense_actual = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_actual('5', $idhotel_custom, $monthact, $yearact);
														$grandtotal_ang_und_exp_actual = $this->Smartreport_actual_model->get_total_actual('20', $idhotel_custom, $monthact, $yearact);
														$grandtotal_pomec_und_exp_actual = $this->Smartreport_actual_model->get_total_actual('21', $idhotel_custom, $monthact, $yearact);
														$grandtotal_snm_und_exp_actual = $this->Smartreport_actual_model->get_total_actual('23', $idhotel_custom, $monthact, $yearact);
														if($grandtotal_ang_und_exp_actual->TOTAL_ACTUAL !=0 && $grandtotal_pomec_und_exp_actual->TOTAL_ACTUAL !=0 && $grandtotal_snm_und_exp_actual->TOTAL_ACTUAL !=0 &&  $grandtotal_other_expense_actual->GRANDTOTAL_PNLCATEGORY !=0 && $grandtotal_total_sales_actual->GRANDTOTAL_PNLCATEGORY !=0 ){
															$grandtotal_actual_expense = (($grandtotal_ang_und_exp_actual->TOTAL_ACTUAL + $grandtotal_pomec_und_exp_actual->TOTAL_ACTUAL + $grandtotal_snm_und_exp_actual->TOTAL_ACTUAL + $grandtotal_other_expense_actual->GRANDTOTAL_PNLCATEGORY)/$grandtotal_total_sales_actual->GRANDTOTAL_PNLCATEGORY)*100;
														}else{
															$grandtotal_actual_expense = 0;
														}
																												
													?>
													<strong><?php echo number_format($grandtotal_actual_expense,2).'%';?></strong>
												</td>
												<td class='rata-kanan'>-</td>	
												<td class="rata-kanan">
													<?php
														$grandtotal_total_sales_budget = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_budget('2', $idhotel_custom, $monthact, $yearact);
														$grandtotal_other_expense_budget = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_budget('5', $idhotel_custom, $monthact, $yearact);
														$grandtotal_ang_und_exp_budget = $this->Smartreport_actual_model->get_total_budget('20', $idhotel_custom, $monthact, $yearact);
														$grandtotal_pomec_und_exp_budget = $this->Smartreport_actual_model->get_total_budget('21', $idhotel_custom, $monthact, $yearact);
														$grandtotal_snm_und_exp_budget = $this->Smartreport_actual_model->get_total_budget('23', $idhotel_custom, $monthact, $yearact);
														if($grandtotal_ang_und_exp_budget->TOTAL_BUDGET !=0 && $grandtotal_pomec_und_exp_budget->TOTAL_BUDGET !=0 && $grandtotal_snm_und_exp_budget->TOTAL_BUDGET !=0 &&  $grandtotal_other_expense_budget->GRANDTOTAL_PNLCATEGORY !=0 && $grandtotal_total_sales_budget->GRANDTOTAL_PNLCATEGORY !=0 ){
															$grandtotal_budget_expense = (($grandtotal_ang_und_exp_budget->TOTAL_BUDGET + $grandtotal_pomec_und_exp_budget->TOTAL_BUDGET + $grandtotal_snm_und_exp_budget->TOTAL_BUDGET + $grandtotal_other_expense_budget->GRANDTOTAL_PNLCATEGORY)/$grandtotal_total_sales_budget->GRANDTOTAL_PNLCATEGORY)*100;
														}else{
															$grandtotal_budget_expense = 0;
														}
																												
													?>
													<strong><?php echo number_format($grandtotal_budget_expense,2).'%';?></strong>
												</td>
												<td class='rata-kanan'>
													<?php 	
														$variance_grandtotal_expense = $grandtotal_actual_expense - $grandtotal_budget_expense;
														($variance_grandtotal_expense <= 0) ? $textcolor='text-danger-600' : $textcolor='text-success-600'; 
													?>
													<strong><div class="<?php echo $textcolor?>"><?php echo number_format($variance_grandtotal_expense,2).'%'; ?></div></strong>													
												</td>
												<!-- END MTD -->
												
												<!-- BEGIN LAST MTD -->
												<td class='rata-kanan'>-</td>
												<td class='rata-kanan'>
													<?php 
														if($monthact == '01'){ //jika difilter adalah bulan januari 2019 maka last monthnya adalah desember 2018 tahun sebelumnya
															$grandtotal_total_sales_actual_lastmtd = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_actual('2', $idhotel_custom, $lastmonth, $lastyear);
															$grandtotal_other_expense_actual_lastmtd = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_actual('5', $idhotel_custom, $lastmonth, $lastyear);
															$grandtotal_ang_und_exp_actual_lastmtd = $this->Smartreport_actual_model->get_total_actual('20', $idhotel_custom, $lastmonth, $lastyear);
															$grandtotal_pomec_und_exp_actual_lastmtd = $this->Smartreport_actual_model->get_total_actual('21', $idhotel_custom, $lastmonth, $lastyear);
															$grandtotal_snm_und_exp_actual_lastmtd = $this->Smartreport_actual_model->get_total_actual('23', $idhotel_custom, $lastmonth, $lastyear);
														}else{
															$grandtotal_total_sales_actual_lastmtd = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_actual('2', $idhotel_custom, $lastmonth, $yearact);
															$grandtotal_other_expense_actual_lastmtd = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_actual('5', $idhotel_custom,  $lastmonth, $yearact);
															$grandtotal_ang_und_exp_actual_lastmtd = $this->Smartreport_actual_model->get_total_actual('20', $idhotel_custom,  $lastmonth, $yearact);
															$grandtotal_pomec_und_exp_actual_lastmtd = $this->Smartreport_actual_model->get_total_actual('21', $idhotel_custom,  $lastmonth, $yearact);
															$grandtotal_snm_und_exp_actual_lastmtd = $this->Smartreport_actual_model->get_total_actual('23', $idhotel_custom,  $lastmonth, $yearact);
														}
														
														if($grandtotal_ang_und_exp_actual_lastmtd->TOTAL_ACTUAL !=0 && $grandtotal_pomec_und_exp_actual_lastmtd->TOTAL_ACTUAL !=0 && $grandtotal_snm_und_exp_actual_lastmtd->TOTAL_ACTUAL !=0 &&  $grandtotal_other_expense_actual_lastmtd->GRANDTOTAL_PNLCATEGORY !=0 && $grandtotal_total_sales_actual_lastmtd->GRANDTOTAL_PNLCATEGORY !=0 ){
															$grandtotal_actual_expense_lastmtd = (($grandtotal_ang_und_exp_actual_lastmtd->TOTAL_ACTUAL + $grandtotal_pomec_und_exp_actual_lastmtd->TOTAL_ACTUAL + $grandtotal_snm_und_exp_actual_lastmtd->TOTAL_ACTUAL + $grandtotal_other_expense_actual_lastmtd->GRANDTOTAL_PNLCATEGORY)/$grandtotal_total_sales_actual_lastmtd->GRANDTOTAL_PNLCATEGORY)*100;
														}else{
															$grandtotal_actual_expense_lastmtd = 0;
														}
																												
														?>
													<strong><?php echo number_format($grandtotal_actual_expense_lastmtd,2).'%';?></strong>
												</td>
												<td class='rata-kanan'>-</td>
												<td class='rata-kanan'>
													<?php 
														if($monthact == '01'){ //jika difilter adalah bulan januari 2019 maka last monthnya adalah desember 2018 tahun sebelumnya
															$grandtotal_total_sales_budget_lastmtd = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_budget('2', $idhotel_custom, $lastmonth, $lastyear);
															$grandtotal_other_expense_budget_lastmtd = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_budget('5', $idhotel_custom, $lastmonth, $lastyear);
															$grandtotal_ang_und_exp_budget_lastmtd = $this->Smartreport_actual_model->get_total_budget('20', $idhotel_custom, $lastmonth, $lastyear);
															$grandtotal_pomec_und_exp_budget_lastmtd = $this->Smartreport_actual_model->get_total_budget('21', $idhotel_custom, $lastmonth, $lastyear);
															$grandtotal_snm_und_exp_budget_lastmtd = $this->Smartreport_actual_model->get_total_budget('23', $idhotel_custom, $lastmonth, $lastyear);
														}else{
															$grandtotal_total_sales_budget_lastmtd = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_budget('2', $idhotel_custom, $lastmonth, $yearact);
															$grandtotal_other_expense_budget_lastmtd = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_budget('5', $idhotel_custom,  $lastmonth, $yearact);
															$grandtotal_ang_und_exp_budget_lastmtd = $this->Smartreport_actual_model->get_total_budget('20', $idhotel_custom,  $lastmonth, $yearact);
															$grandtotal_pomec_und_exp_budget_lastmtd = $this->Smartreport_actual_model->get_total_budget('21', $idhotel_custom,  $lastmonth, $yearact);
															$grandtotal_snm_und_exp_budget_lastmtd = $this->Smartreport_actual_model->get_total_budget('23', $idhotel_custom,  $lastmonth, $yearact);
														}
														
														if($grandtotal_ang_und_exp_budget_lastmtd->TOTAL_BUDGET !=0 && $grandtotal_pomec_und_exp_budget_lastmtd->TOTAL_BUDGET !=0 && $grandtotal_snm_und_exp_budget_lastmtd->TOTAL_BUDGET !=0 &&  $grandtotal_other_expense_budget_lastmtd->GRANDTOTAL_PNLCATEGORY !=0 && $grandtotal_total_sales_budget_lastmtd->GRANDTOTAL_PNLCATEGORY !=0 ){
															$grandtotal_budget_expense_lastmtd = (($grandtotal_ang_und_exp_budget_lastmtd->TOTAL_BUDGET + $grandtotal_pomec_und_exp_budget_lastmtd->TOTAL_BUDGET + $grandtotal_snm_und_exp_budget_lastmtd->TOTAL_BUDGET + $grandtotal_other_expense_budget_lastmtd->GRANDTOTAL_PNLCATEGORY)/$grandtotal_total_sales_budget_lastmtd->GRANDTOTAL_PNLCATEGORY)*100;
														}else{
															$grandtotal_budget_expense_lastmtd = 0;
														}
																												
														?>
													<strong><?php echo number_format($grandtotal_budget_expense_lastmtd,2).'%';?></strong>
												</td>
												<td class='rata-kanan'>
													<?php 	
														$variance_grandtotal_expense_lastmtd = $grandtotal_actual_expense_lastmtd - $grandtotal_budget_expense_lastmtd;
														($variance_grandtotal_expense_lastmtd <= 0) ? $textcolor='text-danger-600' : $textcolor='text-success-600'; 
													?>
													<strong><div class="<?php echo $textcolor?>"><?php echo number_format($variance_grandtotal_expense_lastmtd,2).'%'; ?></div></strong>													
												</td>
												<!-- END LAST MTD -->
												
												<!-- BEGIN YTD -->
												<td class='rata-kanan'>-</td>	
												<td class="rata-kanan">
													<?php
														$grandtotal_total_sales_actual_ytd = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_actual_ytd('2', $idhotel_custom, $startdate_ytd, $enddate_ytd);
														$grandtotal_other_expense_actual_ytd = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_actual_ytd('5', $idhotel_custom, $startdate_ytd, $enddate_ytd);
														$grandtotal_ang_und_exp_actual_ytd = $this->Smartreport_actual_model->get_total_actual_ytd('20', $idhotel_custom, $startdate_ytd, $enddate_ytd);
														$grandtotal_pomec_und_exp_actual_ytd = $this->Smartreport_actual_model->get_total_actual_ytd('21', $idhotel_custom, $startdate_ytd, $enddate_ytd);
														$grandtotal_snm_und_exp_actual_ytd = $this->Smartreport_actual_model->get_total_actual_ytd('23', $idhotel_custom, $startdate_ytd, $enddate_ytd);
														if($grandtotal_ang_und_exp_actual_ytd->TOTAL_ACTUAL !=0 && $grandtotal_pomec_und_exp_actual_ytd->TOTAL_ACTUAL !=0 && $grandtotal_snm_und_exp_actual_ytd->TOTAL_ACTUAL !=0 &&  $grandtotal_other_expense_actual_ytd->GRANDTOTAL_PNLCATEGORY !=0 && $grandtotal_total_sales_actual_ytd->GRANDTOTAL_PNLCATEGORY !=0 ){
															$grandtotal_actual_expense_ytd = (($grandtotal_ang_und_exp_actual_ytd->TOTAL_ACTUAL + $grandtotal_pomec_und_exp_actual_ytd->TOTAL_ACTUAL + $grandtotal_snm_und_exp_actual_ytd->TOTAL_ACTUAL + $grandtotal_other_expense_actual_ytd->GRANDTOTAL_PNLCATEGORY)/$grandtotal_total_sales_actual_ytd->GRANDTOTAL_PNLCATEGORY)*100;
														}else{
															$grandtotal_actual_expense_ytd = 0;
														}
																												
													?>
													<strong><?php echo number_format($grandtotal_actual_expense_ytd,2).'%';?></strong>
												</td>
												<td class='rata-kanan'>-</td>	
												<td class="rata-kanan">
													<?php
														$grandtotal_total_sales_budget_ytd = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_budget_ytd('2', $idhotel_custom, $startdate_ytd, $enddate_ytd);
														$grandtotal_other_expense_budget_ytd = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_budget_ytd('5', $idhotel_custom, $startdate_ytd, $enddate_ytd);
														$grandtotal_ang_und_exp_budget_ytd = $this->Smartreport_actual_model->get_total_budget_ytd('20', $idhotel_custom, $startdate_ytd, $enddate_ytd);
														$grandtotal_pomec_und_exp_budget_ytd = $this->Smartreport_actual_model->get_total_budget_ytd('21', $idhotel_custom, $startdate_ytd, $enddate_ytd);
														$grandtotal_snm_und_exp_budget_ytd = $this->Smartreport_actual_model->get_total_budget_ytd('23', $idhotel_custom, $startdate_ytd, $enddate_ytd);
														if($grandtotal_ang_und_exp_budget_ytd->TOTAL_BUDGET !=0 && $grandtotal_pomec_und_exp_budget_ytd->TOTAL_BUDGET !=0 && $grandtotal_snm_und_exp_budget_ytd->TOTAL_BUDGET !=0 &&  $grandtotal_other_expense_budget_ytd->GRANDTOTAL_PNLCATEGORY !=0 && $grandtotal_total_sales_budget_ytd->GRANDTOTAL_PNLCATEGORY !=0 ){
															$grandtotal_budget_expense_ytd = (($grandtotal_ang_und_exp_budget_ytd->TOTAL_BUDGET + $grandtotal_pomec_und_exp_budget_ytd->TOTAL_BUDGET + $grandtotal_snm_und_exp_budget_ytd->TOTAL_BUDGET + $grandtotal_other_expense_budget_ytd->GRANDTOTAL_PNLCATEGORY)/$grandtotal_total_sales_budget_ytd->GRANDTOTAL_PNLCATEGORY)*100;
														}else{
															$grandtotal_budget_expense_ytd = 0;
														}
																												
													?>
													<strong><?php echo number_format($grandtotal_budget_expense_ytd,2).'%';?></strong>
												</td>
												<td class='rata-kanan'>
													<?php 	
														$variance_grandtotal_expense_ytd = $grandtotal_actual_expense_ytd - $grandtotal_budget_expense_ytd;
														($variance_grandtotal_expense_ytd <= 0) ? $textcolor='text-danger-600' : $textcolor='text-success-600'; 
													?>
													<strong><div class="<?php echo $textcolor?>"><?php echo number_format($variance_grandtotal_expense_ytd,2).'%'; ?></div></strong>													
												</td>
												<!-- END YTD -->
											</tr>

											<tr>
												<td><strong>COST OF SALES</strong></td>	
												
												<!-- BEGIN MTD -->
												<td class='rata-kanan'>-</td>	
												<td class="rata-kanan">
													<?php
														$grandtotal_total_sales_actual = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_actual('2', $idhotel_custom, $monthact, $yearact);
														$grandtotal_cost_of_sales_actual = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_actual('3', $idhotel_custom, $monthact, $yearact);
														if($grandtotal_cost_of_sales_actual->GRANDTOTAL_PNLCATEGORY !=0 && $grandtotal_total_sales_actual->GRANDTOTAL_PNLCATEGORY !=0){
															$grandtotal_actual_cos = ($grandtotal_cost_of_sales_actual->GRANDTOTAL_PNLCATEGORY / $grandtotal_total_sales_actual->GRANDTOTAL_PNLCATEGORY)*100;
														}else{
															$grandtotal_actual_cos = 0;
														}
														
													?>
													<strong><?php echo number_format($grandtotal_actual_cos,2).'%';?></strong>
												</td>
												<td class='rata-kanan'>-</td>	
												<td class="rata-kanan">
													<?php
														$grandtotal_total_sales_budget = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_budget('2', $idhotel_custom, $monthact, $yearact);
														$grandtotal_cost_of_sales_budget = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_budget('3', $idhotel_custom, $monthact, $yearact);
														if($grandtotal_cost_of_sales_budget->GRANDTOTAL_PNLCATEGORY !=0 && $grandtotal_total_sales_budget->GRANDTOTAL_PNLCATEGORY !=0){
															$grandtotal_budget_cos = ($grandtotal_cost_of_sales_budget->GRANDTOTAL_PNLCATEGORY / $grandtotal_total_sales_budget->GRANDTOTAL_PNLCATEGORY)*100;
														}else{
															$grandtotal_budget_cos = 0;
														}
														
													?>
													<strong><?php echo number_format($grandtotal_budget_cos,2).'%';?></strong>
												</td>
												<td class='rata-kanan'>
													<?php 	
														$variance_grandtotal_cos = $grandtotal_actual_cos - $grandtotal_budget_cos;
														($variance_grandtotal_cos <= 0) ? $textcolor='text-danger-600' : $textcolor='text-success-600'; 
													?>
													<strong><div class="<?php echo $textcolor?>"><?php echo number_format($variance_grandtotal_cos,2).'%'; ?></div></strong>													
												</td>
												<!-- END MTD -->
												
												<!-- BEGIN LAST MTD -->
												<td class='rata-kanan'>-</td>
												<td class='rata-kanan'>
													<?php 
														if($monthact == '01'){ //jika difilter adalah bulan januari 2019 maka last monthnya adalah desember 2018 tahun sebelumnya
															$grandtotal_total_sales_actual_lastmtd = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_actual('2', $idhotel_custom, $lastmonth, $lastyear);
															$grandtotal_cost_of_sales_actual_lastmtd = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_actual('3', $idhotel_custom, $lastmonth, $lastyear);
														}else{
															$grandtotal_total_sales_actual_lastmtd = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_actual('2', $idhotel_custom, $lastmonth, $yearact);
															$grandtotal_cost_of_sales_actual_lastmtd = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_actual('3', $idhotel_custom, $lastmonth, $yearact);
														}
														
														if($grandtotal_cost_of_sales_actual_lastmtd->GRANDTOTAL_PNLCATEGORY !=0 && $grandtotal_total_sales_actual_lastmtd->GRANDTOTAL_PNLCATEGORY !=0){
															$grandtotal_actual_cos_lastmtd = ($grandtotal_cost_of_sales_actual_lastmtd->GRANDTOTAL_PNLCATEGORY / $grandtotal_total_sales_actual_lastmtd->GRANDTOTAL_PNLCATEGORY)*100;
														}else{
															$grandtotal_actual_cos_lastmtd = 0;
														}
														
														?>
														<strong><?php echo number_format($grandtotal_actual_cos_lastmtd,2).'%';?></strong>
												</td>
												<td class='rata-kanan'>-</td>
												<td class='rata-kanan'>
													<?php 
														if($monthact == '01'){ //jika difilter adalah bulan januari 2019 maka last monthnya adalah desember 2018 tahun sebelumnya
															$grandtotal_total_sales_budget_lastmtd = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_budget('2', $idhotel_custom, $lastmonth, $lastyear);
															$grandtotal_cost_of_sales_budget_lastmtd = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_budget('3', $idhotel_custom, $lastmonth, $lastyear);
														}else{
															$grandtotal_total_sales_budget_lastmtd = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_budget('2', $idhotel_custom, $lastmonth, $yearact);
															$grandtotal_cost_of_sales_budget_lastmtd = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_budget('3', $idhotel_custom, $lastmonth, $yearact);
														}
														
														if($grandtotal_cost_of_sales_budget_lastmtd->GRANDTOTAL_PNLCATEGORY !=0 && $grandtotal_total_sales_budget_lastmtd->GRANDTOTAL_PNLCATEGORY !=0){
															$grandtotal_budget_cos_lastmtd = ($grandtotal_cost_of_sales_budget_lastmtd->GRANDTOTAL_PNLCATEGORY / $grandtotal_total_sales_budget_lastmtd->GRANDTOTAL_PNLCATEGORY)*100;
														}else{
															$grandtotal_budget_cos_lastmtd = 0;
														}
														
														?>
														<strong><?php echo number_format($grandtotal_budget_cos_lastmtd,2).'%';?></strong>
												</td>
												<td class='rata-kanan'>
													<?php 	
														$variance_grandtotal_cos_lastmtd = $grandtotal_actual_cos_lastmtd - $grandtotal_budget_cos_lastmtd;
														($variance_grandtotal_cos_lastmtd <= 0) ? $textcolor='text-danger-600' : $textcolor='text-success-600'; 
													?>
													<strong><div class="<?php echo $textcolor?>"><?php echo number_format($variance_grandtotal_cos_lastmtd,2).'%'; ?></div></strong>													
												</td>
												<!-- END LAST MTD -->
												
												<!-- BEGIN YTD -->
												<td class='rata-kanan'>-</td>	
												<td class="rata-kanan">
													<?php
														$grandtotal_total_sales_actual_ytd = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_actual_ytd('2', $idhotel_custom, $startdate_ytd, $enddate_ytd);
														$grandtotal_cost_of_sales_actual_ytd = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_actual_ytd('3', $idhotel_custom,$startdate_ytd, $enddate_ytd);
														if($grandtotal_cost_of_sales_actual_ytd->GRANDTOTAL_PNLCATEGORY !=0 && $grandtotal_total_sales_actual_ytd->GRANDTOTAL_PNLCATEGORY !=0){
															$grandtotal_actual_cos_ytd = ($grandtotal_cost_of_sales_actual_ytd->GRANDTOTAL_PNLCATEGORY / $grandtotal_total_sales_actual_ytd->GRANDTOTAL_PNLCATEGORY)*100;
														}else{
															$grandtotal_actual_cos_ytd = 0;
														}
														
													?>
													<strong><?php echo number_format($grandtotal_actual_cos_ytd,2).'%';?></strong>
												</td>
												<td class='rata-kanan'>-</td>	
												<td class="rata-kanan">
													<?php
														$grandtotal_total_sales_budget_ytd = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_budget_ytd('2', $idhotel_custom, $startdate_ytd, $enddate_ytd);
														$grandtotal_cost_of_sales_budget_ytd = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_budget_ytd('3', $idhotel_custom, $startdate_ytd, $enddate_ytd);
														if($grandtotal_cost_of_sales_budget_ytd->GRANDTOTAL_PNLCATEGORY !=0 && $grandtotal_total_sales_budget_ytd->GRANDTOTAL_PNLCATEGORY !=0){
															$grandtotal_budget_cos_ytd = ($grandtotal_cost_of_sales_budget_ytd->GRANDTOTAL_PNLCATEGORY / $grandtotal_total_sales_budget_ytd->GRANDTOTAL_PNLCATEGORY)*100;
														}else{
															$grandtotal_budget_cos_ytd = 0;
														}
														
													?>
													<strong><?php echo number_format($grandtotal_budget_cos_ytd,2).'%';?></strong>
												</td>
												<td class='rata-kanan'>
													<?php 	
														$variance_grandtotal_cos_ytd = $grandtotal_actual_cos_ytd - $grandtotal_budget_cos_ytd;
														($variance_grandtotal_cos_ytd <= 0) ? $textcolor='text-danger-600' : $textcolor='text-success-600'; 
													?>
													<strong><div class="<?php echo $textcolor?>"><?php echo number_format($variance_grandtotal_cos_ytd,2).'%'; ?></div></strong>													
												</td>
												<!-- END YTD -->
											</tr>

											<tr>
												<td><strong>MARKETING EXPENSE</strong></td>	
												
												<!-- BEGIN MTD -->
												<td class='rata-kanan'>-</td>	
												<td class="rata-kanan">
													<?php
														$grandtotal_total_sales_actual = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_actual('2', $idhotel_custom, $monthact, $yearact);
														$grandtotal_snm_und_exp_actual = $this->Smartreport_actual_model->get_total_actual('23', $idhotel_custom, $monthact, $yearact);
														if($grandtotal_snm_und_exp_actual->TOTAL_ACTUAL != 0 && $grandtotal_total_sales_actual->GRANDTOTAL_PNLCATEGORY != 0){
															$grandtotal_actual_salesmarketing = ($grandtotal_snm_und_exp_actual->TOTAL_ACTUAL / $grandtotal_total_sales_actual->GRANDTOTAL_PNLCATEGORY)*100;
														}else{
															$grandtotal_actual_salesmarketing = 0;
														}
														
													?>
													<strong><?php echo number_format($grandtotal_actual_salesmarketing,2).'%';?></strong>
												</td>
												<td class='rata-kanan'>-</td>	
												<td class="rata-kanan">
													<?php
														$grandtotal_total_sales_budget = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_budget('2', $idhotel_custom, $monthact, $yearact);
														$grandtotal_snm_und_exp_budget = $this->Smartreport_actual_model->get_total_budget('23', $idhotel_custom, $monthact, $yearact);
														if($grandtotal_snm_und_exp_budget->TOTAL_BUDGET != 0 && $grandtotal_total_sales_budget->GRANDTOTAL_PNLCATEGORY != 0){
															$grandtotal_budget_salesmarketing = ($grandtotal_snm_und_exp_budget->TOTAL_BUDGET / $grandtotal_total_sales_budget->GRANDTOTAL_PNLCATEGORY)*100;
														}else{
															$grandtotal_budget_salesmarketing = 0;
														}
														
													?>
													<strong><?php echo number_format($grandtotal_budget_salesmarketing,2).'%';?></strong>
												</td>
												<td class='rata-kanan'>
													<?php 	
														$variance_grandtotal_salesmarketing = $grandtotal_actual_salesmarketing - $grandtotal_budget_salesmarketing;
														($variance_grandtotal_salesmarketing <= 0) ? $textcolor='text-danger-600' : $textcolor='text-success-600'; 
													?>
													<strong><div class="<?php echo $textcolor?>"><?php echo number_format($variance_grandtotal_salesmarketing,2).'%'; ?></div></strong>													
												</td>
												<!-- END MTD -->
												
												<!-- BEGIN LAST MTD -->
												<td class='rata-kanan'>-</td>
												<td class='rata-kanan'>
													<?php 
														if($monthact == '01'){ //jika difilter adalah bulan januari 2019 maka last monthnya adalah desember 2018 tahun sebelumnya
															$grandtotal_total_sales_actual_lastmtd = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_actual('2', $idhotel_custom, $lastmonth, $lastyear);
															$grandtotal_snm_und_exp_actual_lastmtd = $this->Smartreport_actual_model->get_total_actual('23', $idhotel_custom, $lastmonth, $lastyear);
														}else{
															$grandtotal_total_sales_actual_lastmtd = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_actual('2', $idhotel_custom, $lastmonth, $yearact);
															$grandtotal_snm_und_exp_actual_lastmtd = $this->Smartreport_actual_model->get_total_actual('23', $idhotel_custom, $lastmonth, $yearact);
														}
														
														if($grandtotal_snm_und_exp_actual_lastmtd->TOTAL_ACTUAL != 0 && $grandtotal_total_sales_actual_lastmtd->GRANDTOTAL_PNLCATEGORY != 0){
															$grandtotal_actual_salesmarketing_lastmtd = ($grandtotal_snm_und_exp_actual_lastmtd->TOTAL_ACTUAL / $grandtotal_total_sales_actual_lastmtd->GRANDTOTAL_PNLCATEGORY)*100;
														}else{
															$grandtotal_actual_salesmarketing_lastmtd = 0;
														}
														
													?>
													<strong><?php echo number_format($grandtotal_actual_salesmarketing,2).'%';?></strong>
												</td>
												<td class='rata-kanan'>-</td>
												<td class='rata-kanan'>
													<?php 
														if($monthact == '01'){ //jika difilter adalah bulan januari 2019 maka last monthnya adalah desember 2018 tahun sebelumnya
															$grandtotal_total_sales_budget_lastmtd = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_budget('2', $idhotel_custom, $lastmonth, $lastyear);
															$grandtotal_snm_und_exp_budget_lastmtd = $this->Smartreport_actual_model->get_total_budget('23', $idhotel_custom, $lastmonth, $lastyear);
														}else{
															$grandtotal_total_sales_budget_lastmtd = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_budget('2', $idhotel_custom, $lastmonth, $yearact);
															$grandtotal_snm_und_exp_budget_lastmtd = $this->Smartreport_actual_model->get_total_budget('23', $idhotel_custom, $lastmonth, $yearact);
														}
														
														if($grandtotal_snm_und_exp_budget_lastmtd->TOTAL_BUDGET != 0 && $grandtotal_total_sales_budget_lastmtd->GRANDTOTAL_PNLCATEGORY != 0){
															$grandtotal_budget_salesmarketing_lastmtd = ($grandtotal_snm_und_exp_budget_lastmtd->TOTAL_BUDGET / $grandtotal_total_sales_budget_lastmtd->GRANDTOTAL_PNLCATEGORY)*100;
														}else{
															$grandtotal_budget_salesmarketing_lastmtd = 0;
														}
														
													?>
													<strong><?php echo number_format($grandtotal_budget_salesmarketing_lastmtd,2).'%';?></strong>
												</td>
												<td class='rata-kanan'>
													<?php 	
														$variance_grandtotal_salesmarketing_lastmtd = $grandtotal_actual_salesmarketing_lastmtd - $grandtotal_budget_salesmarketing_lastmtd;
														($variance_grandtotal_salesmarketing_lastmtd <= 0) ? $textcolor='text-danger-600' : $textcolor='text-success-600'; 
													?>
													<strong><div class="<?php echo $textcolor?>"><?php echo number_format($variance_grandtotal_salesmarketing_lastmtd,2).'%'; ?></div></strong>													
												</td>
												<!-- END LAST MTD -->
												
												<!-- BEGIN YTD -->
												<td class='rata-kanan'>-</td>	
												<td class="rata-kanan">
													<?php
														$grandtotal_total_sales_actual_ytd = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_actual_ytd('2', $idhotel_custom, $startdate_ytd, $enddate_ytd);
														$grandtotal_snm_und_exp_actual_ytd = $this->Smartreport_actual_model->get_total_actual_ytd('23', $idhotel_custom, $startdate_ytd, $enddate_ytd);
														if($grandtotal_snm_und_exp_actual_ytd->TOTAL_ACTUAL != 0 && $grandtotal_total_sales_actual_ytd->GRANDTOTAL_PNLCATEGORY != 0){
															$grandtotal_actual_salesmarketing_ytd = ($grandtotal_snm_und_exp_actual_ytd->TOTAL_ACTUAL / $grandtotal_total_sales_actual_ytd->GRANDTOTAL_PNLCATEGORY)*100;
														}else{
															$grandtotal_actual_salesmarketing_ytd = 0;
														}
														
													?>
													<strong><?php echo number_format($grandtotal_actual_salesmarketing_ytd,2).'%';?></strong>
												</td>
												<td class='rata-kanan'>-</td>	
												<td class="rata-kanan">
													<?php
														$grandtotal_total_sales_budget_ytd = $this->Smartreport_actual_model->get_grandtotal_pnlcategory_budget_ytd('2', $idhotel_custom, $startdate_ytd, $enddate_ytd);
														$grandtotal_snm_und_exp_budget_ytd = $this->Smartreport_actual_model->get_total_budget_ytd('23', $idhotel_custom, $startdate_ytd, $enddate_ytd);
														if($grandtotal_snm_und_exp_budget_ytd->TOTAL_BUDGET != 0 && $grandtotal_total_sales_budget_ytd->GRANDTOTAL_PNLCATEGORY != 0){
															$grandtotal_budget_salesmarketing_ytd = ($grandtotal_snm_und_exp_budget_ytd->TOTAL_BUDGET / $grandtotal_total_sales_budget_ytd->GRANDTOTAL_PNLCATEGORY)*100;
														}else{
															$grandtotal_budget_salesmarketing_ytd = 0;
														}
														
													?>
													<strong><?php echo number_format($grandtotal_budget_salesmarketing_ytd,2).'%';?></strong>
												</td>
												<td class='rata-kanan'>
													<?php 	
														$variance_grandtotal_salesmarketing_ytd = $grandtotal_actual_salesmarketing_ytd - $grandtotal_budget_salesmarketing_ytd;
														($variance_grandtotal_salesmarketing_ytd <= 0) ? $textcolor='text-danger-600' : $textcolor='text-success-600'; 
													?>
													<strong><div class="<?php echo $textcolor?>"><?php echo number_format($variance_grandtotal_salesmarketing_ytd,2).'%'; ?></div></strong>													
												</td>
												<!-- END YTD -->
											</tr>
									</tbody>
								</table>
							</div>
						</div>

						<div class="tab-pane fade" id="right-pnl2">							
							<form action="<?php echo base_url()?>smartreportpnl/insert_actual_pnl" method="post" accept-charset="utf-8" enctype="multipart/form-data">								
								<div class="col-md-5">	
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
													<select name="month_actual" class="form-control" required>
														<option value="">-- <?php echo $lang_select_month;?> --</option>
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
                                            <div class="col-sm-4">
												<label><?php echo $lang_year ?></label>
												<select name="year_actual" class="form-control" required>
												<option value="">-- <?php echo $lang_select_year;?> --</option>
													<?php
														for($i=date('Y'); $i>=2018; $i--) {
														
														print('<option value="'.$i.'"'.$selected.'>'.$i.'</option>'."\n");
													}?>
												</select>  
											</div>
                                            
                                        </div>
                                    </div> 
								</div>	
								<div class="table-responsive">
									<table class="table text-nowrap table-hover">
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
                                                <?php $smartreport_pnllist_data = $this->Smartreport_actual_model->select_pnllist_percategory($smartreport_pnlcategory->idpnlcategory);
                                                      foreach ($smartreport_pnllist_data as $smartreport_pnllist ){?>
                                                        <tr>
                                                            <td>&emsp;&emsp;<?= $smartreport_pnllist->pnl_name;?></td>
                                                            <td>
																<input type="hidden" name="idpnl[]" value="<?php echo $smartreport_pnllist->idpnl;?>">
																<input type="text" onkeypress="return isNumberKeyDash(event)" name="actual_value[]" class="form-control border-grey border-1" required>
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
							<form action="<?php echo base_url()?>smartreportpnl/add_actual_data_bypnl" method="post" accept-charset="utf-8">
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
												<select name="month_actual" class="form-control" required>
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
												<select name="year_actual" class="form-control" required>
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
													$pnlcategoryData = $this->Smartreport_actual_model->getDataAll('smartreport_pnlcategory', 'idpnlcategory', 'ASC');
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
										<label class="col-form-label col-lg-2"><strong><?php echo $lang_actual; ?></strong></label>
										<div class="col-lg-10">
											<div class="input-group">												
												<input type="text" onkeypress="return isNumberKeyDash(event)"  name="actual_value" class="form-control" required>
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