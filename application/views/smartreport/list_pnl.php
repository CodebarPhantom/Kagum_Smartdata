	
	<script type="text/javascript">
	    $(function(){
			$('.table-togglable').footable();
		});
	</script>
		<!-- Page header -->
        <div class="page-header page-header-light">
				<div class="page-header-content header-elements-md-inline">
					<div class="page-title d-flex">
						<h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold"> <?php echo $lang_pnl; ?></span> - <?php echo $lang_pnl_list; ?></h4>
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
							<button type="button" class="btn bg-teal-400 btn-labeled btn-labeled-left" data-toggle="modal" data-target="#modal_add_pnllist"><b><i class="icon-align-left"></i></b> <?php echo $lang_add_pnl_list; ?></button>
						</div>
						
						<div class="col-lg-9">
							<div class="input-group">
								<span class="input-group-prepend">
									<span class="input-group-text bg-primary border-primary text-white">
										<i class="icon-search4"></i>
									</span>
								</span>
								<form action="<?php echo site_url('smartreportpnl/pnl_list'); ?>" class="form-inline" method="get">
									<input type="text" class="form-control border-left-0"  name="q" value="<?php echo $q; ?>" placeholder="<?php echo $lang_search_pnl_list; ?>">
									<span class="input-group-append">									
										<button class="btn btn-light" type="submit"> <?php echo $lang_search; ?></button>
										<?php if ($q <> ''){?>
											<a href="<?php echo site_url('smartreportpnl/pnl_list'); ?>" class="btn btn-light">Reset</a>
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
                                <th data-toggle="true"><?php echo $lang_pnl_list; ?></th>
								<th data-hide="phone"><?php echo $lang_pnl_category; ?></th>
								<th data-hide="phone"><?php echo $lang_order; ?></th>
                                <th data-hide="phone"><?php echo $lang_status; ?></th>
								<th class="text-center" style="width: 30px;"><i class="icon-menu-open2"></i></th>
							</tr>
						</thead>
						<tbody>
						<?php foreach ($smartreport_pnllist_data as $smartreport_pnllist){?>
							<tr>
								<td><?php echo ++$start; ?></td>
                                <td><?php echo $smartreport_pnllist->pnl_name; ?></td>
								<td><?php echo $smartreport_pnllist->pnl_category;?></td>								
                                <td><?php echo $smartreport_pnllist->pnl_order;?></td>
                                <td><?php if($smartreport_pnllist->pnl_status === 'inactive') { ?>
									<span class="badge badge-danger d-block">Inactive</span> 
								<?php }else if ($smartreport_pnllist->pnl_status === 'active'){ ?>
									<span class="badge badge-success d-block">Active</span>
								<?php } ?></td>
								
								<td class="text-center">
									<div class="list-icons">
										<div class="dropdown">
											<a href="#" class="list-icons-item" data-toggle="dropdown">
												<i class="icon-menu9"></i>
											</a>

											<div class="dropdown-menu dropdown-menu-right">
												<a data-toggle="modal" data-target="#modal_edit_pnllist<?=$smartreport_pnllist->idpnl;?>" class="dropdown-item"><i class="icon-pencil"></i><?php echo $lang_edit_pnl_list; ?></a>
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
				<div id="modal_add_pnllist" class="modal fade" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title"><?php echo $lang_add_pnl_list; ?></h5>
								<button type="button" class="close"  data-dismiss="modal" aria-hidden="true">&times;</button>
							</div>

							<form action="<?=base_url()?>smartreportpnl/insert_pnl_list" method="post">
								<div class="modal-body">
									<div class="form-group">
										<div class="row">
											<div class="col-sm-6">
												<label><?php echo $lang_pnl_list; ?></label>
												<input type="text" name="pnl_name" placeholder="<?php echo $lang_pnl_list; ?>" class="form-control" required>
											</div>
											<div class="col-sm-6">
												<label><?php echo $lang_pnl_category; ?></label>
												<select name="idpnlcategory" class="form-control" required autocomplete="off">
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

									<div class="form-group">
										<div class="row">
                                            <div class="col-sm-6">
												<label><?php echo $lang_status; ?></label>
												<select name="pnl_status" class="form-control" required autocomplete="off">
													<option><?php echo $lang_choose_status; ?></option>
													<option value="active"><?php echo $lang_active; ?></option>
													<option value="inactive"><?php echo $lang_inactive; ?></option>
												</select>
											</div>
											<div class="col-sm-6">
												<label><?php echo $lang_order; ?></label>
												<input type="text" oninput="this.value = this.value.replace(/[^\d]/, '').replace(/(\..*)\./g, '$1');" name="pnl_order"  placeholder="<?php echo $lang_order; ?>" class="form-control" required>												
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
				<?php foreach ($smartreport_pnllist_data as $smartreport_pnllist){?>
				<div id="modal_edit_pnllist<?=$smartreport_pnllist->idpnl;?>" class="modal fade" tabindex="-1"  aria-hidden="true">
				<div class="modal-dialog">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title"><?php echo $lang_edit_pnl_list; ?></h5>
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							</div>
							<form action="<?=base_url()?>smartreportpnl/update_pnl_list" method="post">
								<div class="modal-body">
									<div class="form-group">
										<div class="row">
											<div class="col-sm-6">
												<label><?php echo $lang_add_pnl_list; ?></label>
												<input type="text" name="pnl_name" placeholder="list PNL" class="form-control" value="<?=$smartreport_pnllist->pnl_name;?>" required>
                                            </div>
                                            <div class="col-sm-6">
												<label><?php echo $lang_pnl_category; ?></label>
												<select name="idpnlcategory" class="form-control" required autocomplete="off">
													<option value=""><?php echo $lang_choose_pnl_category; ?></option>
                                                <?php
                                                    $pnlcategory = $smartreport_pnllist->idpnlcategory;
                                                    $pnlcategoryData = $this->Smartreport_pnl_model->getDataAll('smartreport_pnlcategory', 'idpnlcategory', 'ASC');                                                    
													for ($p = 0; $p < count($pnlcategoryData); ++$p) {
														$idpnlcategory = $pnlcategoryData[$p]->idpnlcategory;
														$pnlcategoryname = $pnlcategoryData[$p]->pnl_category;?>
														<option  value="<?php echo $idpnlcategory; ?>" <?php if ($pnlcategory == $idpnlcategory) {
																echo 'selected="selected"';
															} ?>>
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
                                    
                                    <div class="form-group">
										<div class="row">
                                            <div class="col-sm-6">
												<label><?php echo $lang_status; ?></label>
												<select name="pnl_status" class="form-control" required autocomplete="off">
													<option><?php echo $lang_choose_status; ?></option>
													<option <?php if ($smartreport_pnllist->pnl_status === 'active') {echo 'selected="selected"';} ?> value="active"><?php echo $lang_active; ?></option>
													<option <?php if ($smartreport_pnllist->pnl_status === 'inactive') {echo 'selected="selected"';} ?>value="inactive"><?php echo $lang_inactive; ?></option>
												</select>
											</div>
											
											<div class="col-sm-6">
												<label><?php echo $lang_order; ?></label>
												<input type="text" oninput="this.value = this.value.replace(/[^\d]/, '').replace(/(\..*)\./g, '$1');" name="pnl_order"  placeholder="<?php echo $lang_order; ?>" class="form-control" value="<?php echo $smartreport_pnllist->pnl_order;?>" required>												
                                       	 	</div>	
										</div>
									</div>	
								</div>
						

								<div class="modal-footer">
									<input type="hidden" name="idpnl" class="form-control" value="<?=$smartreport_pnllist->idpnl;?>" required>
									<button type="button" class="btn btn-link" aria-hidden="true" data-dismiss="modal"><?php echo $lang_close; ?></button>
									<button type="submit" class="btn bg-primary"><?php echo $lang_submit; ?></button>
								</div>
							</form>
						</div>
					</div>
				</div>
							<?php } ?>
				<!-- /vertical form modal -->