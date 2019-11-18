
	<script type="text/javascript">
	    $(function(){
			$('.table-togglable').footable();
		});
	</script>
		<!-- Page header -->
        <div class="page-header page-header-light">
				<div class="page-header-content header-elements-md-inline">
					<div class="page-title d-flex">
						<h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold"> <?php echo $lang_pnl; ?></span> - <?php echo $lang_pnl_category; ?></h4>
						<a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
					</div>
				</div>
		</div>
		<!-- /page header -->                
                <!-- Row toggler -->
				<div class="card">
					<div class="card-header header-elements-inline">
					<div class="col-md-12">
					<div class="form-group row">
						<div class="col-lg-3">
							<button type="button" class="btn bg-teal-400 btn-labeled btn-labeled-left" data-toggle="modal" data-target="#modal_add_pnlcategory"><b><i class="icon-align-left"></i></b> <?php echo $lang_add_pnl_category; ?></button>
						</div>
						
						<div class="col-lg-9">
							<div class="input-group">
								<span class="input-group-prepend">
									<span class="input-group-text bg-primary border-primary text-white">
										<i class="icon-search4"></i>
									</span>
								</span>
								<form action="<?php echo site_url('smartreportpnl/pnl_category'); ?>" class="form-inline" method="get">
									<input type="text" class="form-control border-left-0"  name="q" value="<?php echo $q; ?>" placeholder="<?php echo $lang_search_pnl_category; ?>">
									<span class="input-group-append">									
										<button class="btn btn-light" type="submit"> <?php echo $lang_search; ?></button>
										<?php if ($q <> ''){?>
											<a href="<?php echo site_url('smartreportpnl/pnl_category'); ?>" class="btn btn-light">Reset</a>
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
								<th data-toggle="true"><?php echo $lang_pnl_category; ?></th>								
								<th data-hide="phone"><?php echo $lang_order; ?></th>
								<th data-hide="phone"><?php echo $lang_status; ?></th>
								<th class="text-center" style="width: 30px;"><i class="icon-menu-open2"></i></th>
							</tr>
						</thead>
						<tbody>
						<?php foreach ($smartreport_pnlcategory_data as $smartreport_pnlcategory){?>
							<tr>
								<td><?php echo ++$start; ?></td>
								<td><?php echo $smartreport_pnlcategory->pnl_category; ?></td>
								<td><?php echo $smartreport_pnlcategory->pnlcategory_order; ?></td>
                                <td><?php if($smartreport_pnlcategory->pnlcategory_status === 'inactive') { ?>
									<span class="badge badge-danger d-block">Inactive</span> 
								<?php }else if ($smartreport_pnlcategory->pnlcategory_status === 'active'){ ?>
									<span class="badge badge-success d-block">Active</span>
								<?php } ?></td>
								
								<td class="text-center">
									<div class="list-icons">
										<div class="dropdown">
											<a href="#" class="list-icons-item" data-toggle="dropdown">
												<i class="icon-menu9"></i>
											</a>

											<div class="dropdown-menu dropdown-menu-right">
												<a data-toggle="modal" data-target="#modal_edit_pnlcategory<?=$smartreport_pnlcategory->idpnlcategory;?>" class="dropdown-item"><i class="icon-pencil"></i><?php echo $lang_edit_pnl_category; ?></a>
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
				<div id="modal_add_pnlcategory" class="modal fade" tabindex="-1" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title"><?php echo $lang_add_pnl_category; ?></h5>
								<button type="button" class="close"  data-dismiss="modal" aria-hidden="true">&times;</button>
							</div>

							<form action="<?=base_url()?>smartreportpnl/insert_pnl_category" method="post">
								<div class="modal-body">
									<div class="form-group">
										<div class="row">
											<div class="col-sm-6">
												<label><?php echo $lang_pnl_category; ?></label>
												<input type="text" name="pnlcategory_name" placeholder="Category PNL" class="form-control" required>
                                            </div>
                                            <div class="col-sm-6">
												<label><?php echo $lang_status; ?></label>
												<select name="pnlcategory_status" class="form-control" required autocomplete="off">
													<option><?php echo $lang_choose_status; ?></option>
													<option value="active"><?php echo $lang_active; ?></option>
													<option value="inactive"><?php echo $lang_inactive; ?></option>
												</select>
                                            </div>											
										</div>
									</div>
									<div class="form-group">
										<div class="row">
											<div class="col-sm-6">
												<label><?php echo $lang_order; ?></label>
												<input type="text" oninput="this.value = this.value.replace(/[^\d]/, '').replace(/(\..*)\./g, '$1');" name="pnlcategory_order" placeholder="<?php echo $lang_order; ?>" class="form-control" required>												
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
				<?php foreach ($smartreport_pnlcategory_data as $smartreport_pnlcategory){?>
				<div id="modal_edit_pnlcategory<?=$smartreport_pnlcategory->idpnlcategory;?>" class="modal fade" tabindex="-1"  aria-hidden="true">
				<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title"><?php echo $lang_edit_pnl_category; ?></h5>
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							</div>
							<form action="<?=base_url()?>smartreportpnl/update_pnl_category" method="post">
								<div class="modal-body">
									<div class="form-group">
										<div class="row">
											<div class="col-sm-6">
												<label><?php echo $lang_add_pnl_category; ?></label>
												<input type="text" name="pnlcategory_name" placeholder="Category PNL" class="form-control" value="<?=$smartreport_pnlcategory->pnl_category;?>" required>
                                            </div>
                                            <div class="col-sm-6">
												<label><?php echo $lang_status; ?></label>
												<select name="pnlcategory_status" class="form-control" required autocomplete="off">
													<option><?php echo $lang_choose_status; ?></option>
													<option <?php if ($smartreport_pnlcategory->pnlcategory_status === 'active') {echo 'selected="selected"';} ?> value="active"><?php echo $lang_active; ?></option>
													<option <?php if ($smartreport_pnlcategory->pnlcategory_status === 'inactive') {echo 'selected="selected"';} ?>value="inactive"><?php echo $lang_inactive; ?></option>
												</select>
                                            </div>
                                        </div>
									</div> 
									
									<div class="form-group">
										<div class="row">
											<div class="col-sm-6">
												<label><?php echo $lang_order; ?></label>
												<input type="text" oninput="this.value = this.value.replace(/[^\d]/, '').replace(/(\..*)\./g, '$1');" name="pnlcategory_order" value="<?=$smartreport_pnlcategory->pnlcategory_order;?>" placeholder="<?php echo $lang_order; ?>" class="form-control" required>												
                                            </div>
                                        </div>
									</div>	
								</div>
						

								<div class="modal-footer">
									<input type="hidden" name="idpnlcategory" class="form-control" value="<?=$smartreport_pnlcategory->idpnlcategory;?>" required>
									<button type="button" class="btn btn-link" aria-hidden="true" data-dismiss="modal"><?php echo $lang_close; ?></button>
									<button type="submit" class="btn bg-primary"><?php echo $lang_submit; ?></button>
								</div>
							</form>
						</div>
					</div>
				</div>
				<?php } ?>
				<!-- /vertical form modal -->