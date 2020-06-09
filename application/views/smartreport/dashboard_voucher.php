<script src="<?php echo base_url();?>assets/backend/global_assets/js/plugins/forms/selects/select2.min.js"></script>
<script src="<?php echo base_url();?>assets/backend/global_assets/js/plugins/tables/datatables/datatables.min.js"></script> 
<script src="<?php echo base_url();?>assets/backend/global_assets/js/plugins/tables/datatables/extensions/fixed_columns.min.js"></script>
<script src="<?php echo base_url();?>assets/backend/global_assets/js/demo_pages/datatables_extension_fixed_columns.js"></script>

<?php
$minDate = strtotime("+7 Day"); 
$nextWeek = date("d-m-Y", $minDate);
?>
	<script type="text/javascript">
	    
		$(document).ready(function() {

				$('.daterange-single').daterangepicker({
				singleDatePicker: true,
				locale: {
					format: 'DD-MM-YYYY'
				},
				minDate: '<?php echo $nextWeek; ?>',
				maxDate: '31-12-2021'
				});

				$('.table-togglable').footable();
				$('.custom_category').select2();

				$(function(){
					$(".letternumber").keypress(function(event){
						var ew = event.which;
						if(ew == 32)
							return true;
						if(48 <= ew && ew <= 57)
							return true;
						if(65 <= ew && ew <= 90)
							return true;
						if(97 <= ew && ew <= 122)
							return true;
						return false;
					});
				});

				$('.unlock_voucher').on('click',function(){
				
					var url = $(this).attr('href');

					var idvoucher = $(this).attr('idvoucher');
					
					swal({
						title: '<?php echo $lang_unlock_voucher; ?>' + ' ' + idvoucher + '?',					
						type: 'question',
						showCancelButton: true,
						confirmButtonColor: '#ffa801',
						cancelButtonColor: ' #3085d6',
						confirmButtonText: '<?php echo $lang_unlock_voucher_confirm; ?>',
						confirmButtonClass: 'btn btn-success',
						cancelButtonClass: 'btn btn-danger',
						
						}).then(function(result) {
							if(result.value) {
								window.location.href = url
							}
							else if(result.dismiss === swal.DismissReason.cancel) {
								
							}
						});
					
					return false;
				});

				$('.redeem_voucher').on('click',function(){
				
				var url = $(this).attr('href');

				var idvoucher = $(this).attr('idvoucher');
				
				swal({
					title: '<?php echo $lang_redeem_voucher; ?>' + ' ' + idvoucher + '?',					
					type: 'success',
					showCancelButton: true,
					confirmButtonColor: '#44bd32',
					cancelButtonColor: ' #3085d6',
					confirmButtonText: '<?php echo $lang_redeem_voucher_confirm; ?>',
					confirmButtonClass: 'btn btn-success',
					cancelButtonClass: 'btn btn-danger',
					
					}).then(function(result) {
						if(result.value) {
							window.location.href = url
						}
						else if(result.dismiss === swal.DismissReason.cancel) {
							
						}
					});
				
				return false;
			});
		});


	</script>

	<?php   
	 if ($yearvoucher == NULL && $monthvoucher == NULL){
        $yearvoucher = date('Y');
		$monthvoucher = date('m');
		}
     //$url_hotel = $listhotel;
    ?>  
		<!-- Page header -->
        <div class="page-header page-header-light">
            <div class="page-header-content header-elements-md-inline">
                <div class="page-title d-flex">
                    <h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold"> <?php echo $lang_voucher_hotels; ?></span> - <?php echo $lang_dashboard_voucher; ?></h4>
                    <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
                </div>

                <div class="header-elements d-none">
                    <form action="<?php echo base_url()?>smartreportvoucher/dashboard" method="get" accept-charset="utf-8">
                        <div class="d-flex justify-content-center">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-prepend">
                                        <span class="input-group-text"><i class="icon-calendar22"></i></span>
                                    </span>							
                                    <select name="monthvoucher" class="form-control" required>
                                        <option <?php if ($monthvoucher === '01') {echo 'selected="selected"';} ?> value="01">January</option>
                                        <option <?php if ($monthvoucher === '02') {echo 'selected="selected"';} ?> value="02">February</option>
                                        <option <?php if ($monthvoucher === '03') {echo 'selected="selected"';} ?> value="03">March</option>
                                        <option <?php if ($monthvoucher === '04') {echo 'selected="selected"';} ?> value="04">April</option>
                                        <option <?php if ($monthvoucher === '05') {echo 'selected="selected"';} ?> value="05">May</option>
                                        <option <?php if ($monthvoucher === '06') {echo 'selected="selected"';} ?> value="06">June</option>
                                        <option <?php if ($monthvoucher === '07') {echo 'selected="selected"';} ?> value="07">July</option>
                                        <option <?php if ($monthvoucher === '08') {echo 'selected="selected"';} ?> value="08">August</option>
                                        <option <?php if ($monthvoucher === '09') {echo 'selected="selected"';} ?> value="09">September</option>
                                        <option <?php if ($monthvoucher === '10') {echo 'selected="selected"';} ?> value="10">October</option>
                                        <option <?php if ($monthvoucher === '11') {echo 'selected="selected"';} ?> value="11">November</option>
                                        <option <?php if ($monthvoucher === '12') {echo 'selected="selected"';} ?> value="12">December</option>
                                    </select>
                                    <select name="yearvoucher" class="form-control" required>
                                        <?php
                                            for($i=date('Y'); $i>=2019; $i--) {
                                            $selected = '';
                                            if ($yearvoucher == $i) $selected = ' selected="selected"';
                                            print('<option value="'.$i.'"'.$selected.'>'.$i.'</option>'."\n");
                                        }?>
                                    </select>  
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
        <!-- Scrollable datatable -->
        <br/>
        <div class="row animated zoomIn">
            <div class="col-md-8"> 
                <div class="card">                   
                    
                    <table class="table table-bordered table-togglable table-hover table-xs customEryan datatable-nobutton-voucher text-nowrap" width="100%">
                        <thead>
                            <tr>
                                <th><?php echo $lang_idvoucher; ?></th>
                                <th><?php echo $lang_guest_info; ?></th>
                                <th><?php echo $lang_voucher_info; ?></th>
                                <th><?php echo $lang_stay_info; ?></th>
                                <th><?php echo $lang_action; ?></th>
                                <th class="text-center" style="width: 30px;"><i class="icon-menu-open2"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($smartreport_vouchers_data as $smartreport_vouchers){?>
                            <tr>
                                <td><?php echo $smartreport_vouchers->idvoucher; ?></td>
                                <td>
                                    <?php 
                                    $phone = $smartreport_vouchers->guest_phone;
                                    $phone_show = sprintf("%s-%s-%s",
                                                        substr($phone, 0, 4),
                                                        substr($phone, 4, 4),
                                                        substr($phone, 8));
                                    echo "<strong>".ucwords($smartreport_vouchers->guest_name)."</strong><br/>".$phone_show."<br/>".$smartreport_vouchers->guest_email; ?></td>								
                                </td>
                                <td>
                                    <?php 
                                    $created_date = strtotime($smartreport_vouchers->created_at);
                                    $last_lock_date = strtotime($smartreport_vouchers->lock_at);
                                    $redeem_date = strtotime($smartreport_vouchers->redeem_at);

                                    echo $lang_created_at.": ".date('d M Y',$created_date)."<br/>";
                                    echo $smartreport_vouchers->lock_at !== '1970-01-01 00:00:00' ? $lang_last_update.": ".date('d M Y',$last_lock_date)."<br/>" : $lang_last_update.": -"."<br/>";
                                    echo $smartreport_vouchers->redeem_at !== '1970-01-01 00:00:00' ? $lang_redeem_at.": ".date('d M Y',$redeem_date)."<br/>" : $lang_redeem_at.": -"."<br/>";
                                    ?>
                                </td>
                                <td>
                                <?php 
                                    $stay_date = strtotime($smartreport_vouchers->stay_date);
                                    echo $smartreport_vouchers->fk_idhotels !== ''? $lang_hotel.": ".$smartreport_vouchers->hotels_name.' - ' : $lang_hotel.": - ";
                                    if($smartreport_vouchers->fk_idtyperoom == 1 ){
                                        echo 'Superior Room <br/>';
                                    }else if($smartreport_vouchers->fk_idtyperoom == 2){
                                        echo 'Deluxe Room <br/>';
                                    }else{
                                        echo '<br/>';
                                    }
                                    echo $smartreport_vouchers->stay_date !== '1970-01-01 00:00:00' ? $lang_stay_date.": ".date('d M Y',$stay_date)."<br/>" : $lang_stay_date.": -"."<br/>";
                                    ?>

                                    <?php if($smartreport_vouchers->status_voucher === '0') { ?>
                                        <span class="badge badge-danger d-block">Used</span> 
                                    <?php }else if($smartreport_vouchers->status_voucher === '1') { ?>
                                        <span class="badge badge-success d-block">Not Used</span> 
                                    <?php }else if ($smartreport_vouchers->status_voucher === '2'){ ?>
                                        <span class="badge bg-orange d-block">Lock</span>
                                    <?php } ?>
                                </td>
                                <td>
                                    <?php if($smartreport_vouchers->status_voucher === '0') { ?>
                                        <div class="text-center">	
                                            <button type="button" data-popup="tooltip" title="Voucher Used" class="btn btn-outline bg-danger border-danger text-danger-800 btn-icon border-2 ml-2"><i class="icon-cross2"></i></button>
                                        </div>
                                    <?php }else if($smartreport_vouchers->status_voucher === '1') { ?>
                                        <div class="text-center">	
                                            <button type="button" data-popup="tooltip" title="Lock" class="btn btn-outline bg-orange border-orange text-orange-800 btn-icon border-2 ml-2" data-toggle="modal" data-target="#modal_lock_voucher<?=$smartreport_vouchers->idvoucher;?>"><i class="icon-lock5"></i></button>
                                        </div>
                                    <?php } else if($smartreport_vouchers->status_voucher === '2') { ?>
                                        <div class="text-center">
                                            <a href="<?php echo base_url('smartreportvoucher/unlock_voucher/'.$smartreport_vouchers->idvoucher);?>"
                                            type="button" data-popup="tooltip" title="Unlock" idvoucher=<?php echo $smartreport_vouchers->idvoucher; ?> class="btn btn-outline bg-danger border-danger text-danger-800 btn-icon border-2 ml-2 unlock_voucher"><i class="icon-unlocked2"></i></a>

                                            <a href="<?php echo base_url('smartreportvoucher/redeem_voucher/'.$smartreport_vouchers->idvoucher);?>"
                                            type="button" data-popup="tooltip" title="Redeem" idvoucher=<?php echo $smartreport_vouchers->idvoucher; ?> class="btn btn-outline bg-success border-success text-success-800 btn-icon border-2 ml-2 redeem_voucher"><i class="icon-checkmark3"></i></a>
                                        </div>
                                    <?php } ?>
                                </td>
                                <td class="text-center">
                                    <div class="list-icons">
                                        <div class="dropdown">
                                            <a href="#" class="list-icons-item" data-toggle="dropdown">
                                                <i class="icon-menu9"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a href="<?php echo base_url('smartreportvoucher/export_voucher_pdf/'.$smartreport_vouchers->idvoucher);?>" class="dropdown-item "><i class="icon-ticket"></i><?php echo $lang_export_voucher; ?></a>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-4">
                <div class="">
                    <div class="card card-body bg-teal-600 has-bg-image animated flipInY">
                        <div class="media">
                            <div class="media-body">
                                <h3 class="mb-0"><?php echo $count_voucher->count_create; ?></h3>
                                <span class="text-uppercase font-size-xs"><?php echo $lang_voucher_created; ?></span>
                            </div>

                            <div class="ml-3 align-self-center">
                                <i class="icon-3x opacity-75 icon-ticket"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="">
                    <div class="card card-body bg-info-600 has-bg-image animated flipInY">
                        <div class="media">
                            <div class="media-body">
                                <h3 class="mb-0"><?php echo $count_voucher_lock->count_lock; ?></h3>
                                <span class="text-uppercase font-size-xs"><?php echo $lang_voucher_lock; ?>	</span>
                            </div>

                            <div class="ml-3 align-self-center">
                                <i class="icon-3x opacity-75 icon-lock2"></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="">
                    <div class="card card-body bg-grey-700 has-bg-image animated flipInY">
                        <div class="media">
                            <div class="media-body">
                                <h3 class="mb-0"><?php echo $count_voucher_redeem->count_redeem; ?></h3>
                                <span class="text-uppercase font-size-xs"><?php echo $lang_voucher_redeem; ?></span>
                            </div>

                            <div class="ml-3 align-self-center">
                                <i class="icon-3x opacity-75 icon-checkmark3"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		<!-- /scrollable datatable -->
