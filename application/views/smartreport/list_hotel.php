
	<script type="text/javascript">
	    $(function(){
			$('.table-togglable').footable();
		});
	</script>
		<!-- Page header -->
        <div class="page-header page-header-light">
				<div class="page-header-content header-elements-md-inline">
					<div class="page-title d-flex">
						<h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold"> <?php echo $lang_hotel; ?></span> - <?php echo $lang_list_hotels; ?></h4>
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
						<div class="col-lg-2">
							<button type="button" class="btn bg-teal-400 btn-labeled btn-labeled-left" data-toggle="modal" data-target="#modal_add_hotel"><b><i class="icon-office"></i></b> <?php echo $lang_add_hotel; ?></button>
						</div>
						
						<div class="col-lg-8">
							<div class="input-group">
								<span class="input-group-prepend">
									<span class="input-group-text bg-primary border-primary text-white">
										<i class="icon-search4"></i>
									</span>
								</span>
								<form action="<?php echo site_url('smartreport/list_hotel'); ?>" class="form-inline" method="get">
									<input type="text" class="form-control border-left-0"  name="q" value="<?php echo $q; ?>" placeholder="<?php echo $lang_search_hotel; ?>">
									<span class="input-group-append">									
										<button class="btn btn-light" type="submit"> <?php echo $lang_search; ?></button>
										<?php if ($q <> ''){?>
											<a href="<?php echo site_url('smartreport/list_hotel'); ?>" class="btn btn-light">Reset</a>
										<?php } ?>
									</span>
								</form>
							</div>										
						</div>
					</div>
					</div>	
					<div class="header-elements">
							<div class="list-icons">
		                		<a class="list-icons-item" data-action="collapse"></a>
		                	</div>
	                	</div>
					</div>

					<table class="table table-bordered table-togglable table-hover  ">
						<thead>
							<tr>
								<th data-hide="phone">#</th>
								<th data-hide="phone"><?php echo $lang_idhotel; ?></th>
								<th data-toggle="true"><?php echo $lang_hotel_name; ?></th>
								<th data-hide="phone,tablet"><?php echo $lang_city; ?></th>
								<th data-hide="phone"><?php echo $lang_total_rooms; ?></th>
								<th data-hide="phone,tablet"><?php echo $lang_hotel_star; ?></th>
								<th data-hide="phone,tablet"><?php echo $lang_status; ?></th>								
								<th class="text-center" style="width: 30px;"><i class="icon-menu-open2"></i></th>
							</tr>
						</thead>
						<tbody>
						<?php
							foreach ($smartreport_hotel_data as $smartreport_hotel){?>
							<tr>
								<td><?php echo ++$start; ?></td>
								<td><?php echo $smartreport_hotel->idhotels; ?></td>
								<td><?php echo $smartreport_hotel->hotels_name; ?></td>	
								<td><?php echo $smartreport_hotel->city_name; ?></td>	
								<td><?php echo $smartreport_hotel->total_rooms.' '.$lang_rooms; ?> </td>
								<td><?php if ($smartreport_hotel->hotel_star === '1') { ?>
									<span>
										<i class="icon-star-full2 font-size-base text-warning-300"></i>
									</span>
								<?php } else if ($smartreport_hotel->hotel_star === '2') { ?>
									<span>
										<i class="icon-star-full2 font-size-base text-warning-300"></i>
										<i class="icon-star-full2 font-size-base text-warning-300"></i>
									</span>
								<?php } else if ($smartreport_hotel->hotel_star === '3') { ?>
									<span>
										<i class="icon-star-full2 font-size-base text-warning-300"></i>
										<i class="icon-star-full2 font-size-base text-warning-300"></i>
										<i class="icon-star-full2 font-size-base text-warning-300"></i>
									</span>
								<?php } else if ($smartreport_hotel->hotel_star === '4') { ?>	
									<span>
										<i class="icon-star-full2 font-size-base text-warning-300"></i>
										<i class="icon-star-full2 font-size-base text-warning-300"></i>
										<i class="icon-star-full2 font-size-base text-warning-300"></i>
										<i class="icon-star-full2 font-size-base text-warning-300"></i>
									</span>
								<?php } else if ($smartreport_hotel->hotel_star === '5') { ?>
									<span>
										<i class="icon-star-full2 font-size-base text-warning-300"></i>
										<i class="icon-star-full2 font-size-base text-warning-300"></i>
										<i class="icon-star-full2 font-size-base text-warning-300"></i>
										<i class="icon-star-full2 font-size-base text-warning-300"></i>	
										<i class="icon-star-full2 font-size-base text-warning-300"></i>		
									</span>
								<?php } ?>
								</td>
								<td><?php if($smartreport_hotel->status === 'inactive') { ?>
									<span class="badge badge-danger d-block">Inactive</span> 
								<?php }else if ($smartreport_hotel->status === 'active'){ ?>
									<span class="badge badge-success d-block">Active</span>
								<?php } ?></td>										
								<td class="text-center">
									<div class="list-icons">
										<div class="dropdown">
											<a href="#" class="list-icons-item" data-toggle="dropdown">
												<i class="icon-menu9"></i>
											</a>

											<div class="dropdown-menu dropdown-menu-right">
												<a data-toggle="modal" data-target="#modal_edit_hotel<?=$smartreport_hotel->idhotels;?>" class="dropdown-item"><i class="icon-pencil"></i><?php echo $lang_edit_hotel; ?></a>
												<?php if ($user_le === '1') { ?>
												<a href="<?php echo base_url('smartreport/delete_hotel/'.$smartreport_hotel->idhotels);?>" class="dropdown-item delete_data"><i class="icon-cross2"></i><?php echo $lang_delete_hotel; ?></a>
												<?php } ?>
											</div>
										</div>
									</div>
								</td>
							</tr>
							<?php } ?>
						</tbody>
					</table>
						
					<div >													
						<?php echo $pagination ?>									
					</div>
				</div>
				<!-- /row toggler -->

				<!-- Vertical form modal -->
				<div id="modal_add_hotel" class="modal fade" tabindex="-1" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title"><?php echo $lang_add_hotel; ?></h5>
								<button type="button" class="close"  data-dismiss="modal" aria-hidden="true">&times;</button>
							</div>

							<form action="<?=base_url()?>smartreport/insert_hotel" method="post">
								<div class="modal-body">
									<div class="form-group">
										<div class="row">
											<div class="col-sm-6">
												<label><?php echo $lang_idhotel; ?></label>
												<input type="text" name="idhotels" placeholder="ID Hotel..." class="form-control" required>
											</div>

											<div class="col-sm-6">
												<label><?php echo $lang_hotel_name; ?></label>
												<input type="text" name="hotels_name" placeholder="Hotels Name..." class="form-control" required>
											</div>											
										</div>
									</div>	
									
									<div class="form-group">
										<div class="row">
											<div class="col-sm-6">
												<label><?php echo $lang_total_rooms; ?></label>
												<input type="number" name="total_rooms" placeholder="Total Rooms" class="form-control" required>
											</div>	
											
											<div class="col-sm-6">
												<label><?php echo $lang_city; ?></label>
												<select name="idcity" class="form-control" required autocomplete="off">
													<option value=""><?php echo $lang_choose_city; ?></option>
												<?php
													$cityData = $this->Smartreport_hotels_model->getDataAll('smartreport_city', 'idcity', 'ASC');
													for ($p = 0; $p < count($cityData); ++$p) {
														$idcity = $cityData[$p]->idcity;
														$cityname = $cityData[$p]->city_name;?>
														<option  value="<?php echo $idcity; ?>">
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
									</div>
									
									<div class="form-group">
										<div class="row">
											<div class="col-sm-6">
												<label><?php echo $lang_hotel_star; ?></label>
												<select name="hotel_star" class="form-control" required autocomplete="off">
													<option ><?php echo $lang_choose_star; ?></option>
													<option value="5"><?php echo "5 Star"; ?></option>
													<option value="4"><?php echo "4 Star"; ?></option>
													<option value="3"><?php echo "3 Star"; ?></option>
													<option value="2"><?php echo "2 Star"; ?></option>
													<option value="1"><?php echo "1 Star"; ?></option>
												</select>
											</div>	
											
											<div class="col-sm-6">
												<label><?php echo $lang_status; ?></label>
												<select name="status" class="form-control" required autocomplete="off">
													<option ><?php echo $lang_choose_status; ?></option>
													<option value="active"><?php echo "Active"; ?></option>
													<option value="inactive"><?php echo "Inactive"; ?></option>
													
												</select>
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

				<!-- Vertical form modal -->
				<?php foreach ($smartreport_hotel_data as $smartreport_hotel){?>
				<div id="modal_edit_hotel<?=$smartreport_hotel->idhotels;?>" class="modal fade" tabindex="-1"  aria-hidden="true">
				<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title"><?php echo $lang_edit_hotel; ?></h5>
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							</div>

							<form action="<?=base_url()?>smartreport/update_hotel" method="post">
								<div class="modal-body">
									<div class="form-group">
										<div class="row">
											<div class="col-sm-6">
												<label><?php echo $lang_hotel_name; ?></label>
												<input type="text" name="hotels_name" placeholder="Hotels Name..." class="form-control" value="<?=$smartreport_hotel->hotels_name;?>" required>
											</div>
											<div class="col-sm-6">
												<label><?php echo $lang_total_rooms; ?></label>
												<input type="number" name="total_rooms" placeholder="Total Rooms" class="form-control" value="<?=$smartreport_hotel->total_rooms;?>"required>
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="row">
											<input type="hidden" readonly name="idhotels" placeholder="ID Hotel..." class="form-control" value="<?=$smartreport_hotel->idhotels;?>"required>
											<div class="col-sm-6">
												<label><?php echo $lang_city; ?></label>
												<select name="idcity" class="form-control" required autocomplete="off">
													<option value=""><?php echo $lang_choose_city; ?></option>
												<?php
													$city = $smartreport_hotel->idcity;
													$cityData = $this->Smartreport_hotels_model->getDataAll('smartreport_city', 'idcity', 'ASC');
													for ($p = 0; $p < count($cityData); ++$p) {
														$idcity = $cityData[$p]->idcity;
														$cityname = $cityData[$p]->city_name;?>
														<option  value="<?php echo $idcity; ?>" <?php if ($city == $idcity) {
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
											<div class="col-sm-6">
												<label><?php echo $lang_hotel_star; ?></label>
												<select name="hotel_star" class="form-control" required autocomplete="off">
													<option ><?php echo $lang_choose_star; ?></option>
													<option <?php if ($smartreport_hotel->hotel_star === '5') {echo 'selected="selected"';} ?> value="5"><?php echo "5 Star"; ?></option>
													<option <?php if ($smartreport_hotel->hotel_star === '4') {echo 'selected="selected"';} ?>value="4"><?php echo "4 Star"; ?></option>
													<option <?php if ($smartreport_hotel->hotel_star === '3') {echo 'selected="selected"';} ?>value="3"><?php echo "3 Star"; ?></option>
													<option <?php if ($smartreport_hotel->hotel_star === '2') {echo 'selected="selected"';} ?>value="2"><?php echo "2 Star"; ?></option>
													<option <?php if ($smartreport_hotel->hotel_star === '1') {echo 'selected="selected"';} ?>value="1"><?php echo "1 Star"; ?></option>
												</select>
											</div>
										</div>
									</div>

									<div class="form-group">
										<div class="row">
											
											
											<div class="col-sm-6">
												<label><?php echo $lang_status; ?></label>
												<select name="status" class="form-control" required autocomplete="off">
													<option ><?php echo $lang_choose_status; ?></option>
													<option value="active" <?php if ($smartreport_hotel->status === 'active') {echo 'selected="selected"';} ?>><?php echo "Active"; ?></option>
													<option value="inactive" <?php if ($smartreport_hotel->status === 'inactive') {echo 'selected="selected"';} ?>><?php echo "Inactive"; ?></option>
													
												</select>
											</div>
										</div>
									</div>
								</div>

								<div class="modal-footer">
									<input type="hidden" name="idhotels_old" class="form-control" value="<?=$smartreport_hotel->idhotels;?>" required>
									<button type="button" class="btn btn-link" aria-hidden="true" data-dismiss="modal"><?php echo $lang_close; ?></button>
									<button type="submit" class="btn bg-primary"><?php echo $lang_submit; ?></button>
								</div>
							</form>
						</div>
					</div>
				</div>
							<?php } ?>
				<!-- /vertical form modal -->
		