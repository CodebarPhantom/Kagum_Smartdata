	<script src="<?php echo base_url();?>assets/backend/global_assets/js/plugins/forms/selects/select2.min.js"></script>
	<script src="<?php echo base_url();?>assets/backend/global_assets/js/plugins/pickers/daterangepicker.js"></script>	
	<script src="<?php echo base_url();?>assets/backend/global_assets/js/plugins/ui/moment/moment.min.js"></script>
	
	<script type="text/javascript">
	    $(document).ready(function(){
			$('.custom_category').select2();

			$('.daterange-single').daterangepicker({ 
            singleDatePicker: true,
            locale: {
                format: 'DD-MM-YYYY'
            }
        	});
		});
	</script>
	<?php
    //initialization
     
     //$url_city = '';
     //$url_hotel = '';

     //get from function
     //$url_city = $city;
     //$url_hotel = $listhotel;
    ?>  
		<!-- Page header -->
        <div class="page-header page-header-light">
			<div class="page-header-content header-elements-md-inline">
				<div class="page-title d-flex">
					<h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold"> <?php echo $lang_analysis; ?></span> - <?php echo $lang_correction_anl; ?></h4>
					<a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
				</div>
			</div>
		</div>
		<!-- /page header -->                
                <!-- Row toggler -->
				<div class="card">
					<div class="card-header header-elements-inline">
						<div class="col-md-12">
							<form action="<?php echo base_url()?>smartreport/correction_data_analysis" method="get" accept-charset="utf-8">								
								<div class="row">
									<div class="col-md-2">
										<div class="form-group">
											<label><?php echo $lang_date; ?></label>
											<input type="text" name="date_analysis" class="form-control daterange-single"   />
										</div>
									</div>
									
									<div class="col-md-1">
										<div class="form-group">
											<label>&nbsp;</label>
											<button type="submit" class="btn bg-teal-400 "><?php echo $lang_search; ?></button>
										</div>
									</div>
									<div class="col-md-1">
										<div class="form-group">
											<?php //if ($date_analysis != ''){?>
												<label>&nbsp;</label>
												<a href="<?php echo site_url('smartreport/correction-data-analysis'); ?>" class="btn btn-warning">Reset</a>
											<?php //} ?>
										</div>
									</div>
									
								</div>
							</form>	
						</div>					
					</div>

					<table class="table table-bordered table-togglable table-hover  ">
						<thead>
							<tr>
								<th>#</th>
								<th><?php echo $lang_hotel_name; ?></th>                                
								<th><?php echo $lang_room_sold; ?></th>
								<th><?php echo $lang_avg_room_rate; ?></th>
								<th><?php echo $lang_gr_last_night; ?></th>
								<th><?php echo $lang_date; ?></th>							
								<th class="text-center" style="width: 30px;"><i class="icon-menu-open2"></i></th>
							</tr>
						</thead>
						<tbody>
						<?php $start=''; 
							foreach ($smartreport_hca_edithotel_data as $smartreport_hca_edithotel){?>
							<tr>
								<td><?php  echo ++$start; ?></td>
								<td><strong><?= $smartreport_hca_edithotel->hotels_name; ?></strong></td>
								<td><?= $smartreport_hca_edithotel->room_sold; ?></td>
								<td><?= $smartreport_hca_edithotel->avg_roomrate; ?></td>
								<td><?= $smartreport_hca_edithotel->remark; ?></td>
								<td><?= $smartreport_hca_edithotel->date_analysis; ?></td>
								<td class="text-center">
									<div class="list-icons">
										<div class="dropdown">
											<a href="#" class="list-icons-item" data-toggle="dropdown">
												<i class="icon-menu9"></i>
											</a>

											<div class="dropdown-menu dropdown-menu-right">
												<a data-toggle="modal" data-target="#modal_edit_hotel<?=$smartreport_hca_edithotel->idanalysis;?>" class="dropdown-item"><i class="icon-pencil"></i><?php echo $lang_edit; ?></a>
												<?php if ($user_le === '1') { ?>
												<a href="<?php echo base_url('smartreport/correction_data_analysis_delete/'.$smartreport_hca_edithotel->idanalysis);?>" class="dropdown-item delete_data"><i class="icon-cross2"></i><?php echo $lang_delete; ?></a>
												<?php } ?>
											</div>
										</div>
									</div>
								</td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
						
					
				</div>
				<!-- /row toggler -->

				<!-- Vertical form modal -->
			
				<!-- /vertical form modal -->