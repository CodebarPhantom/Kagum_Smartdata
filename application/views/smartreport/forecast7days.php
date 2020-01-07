<style>
.form-control:focus {     
    border-color: #009688;    
}
</style>

<script type="text/javascript">
	   $(document).ready(function(){ 
	        $('.custom_select').select2();		
	});

	
</script> 
<!-- Page header -->
<div class="page-header page-header-light">
    <div class="page-header-content header-elements-md-inline">
        <div class="page-title d-flex">
            <h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold">7 Days Forecast</h4>
            <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
        </div>

        <div class="header-elements d-none">
            
        </div>
    </div>
</div>
<!-- /page header -->
<!-- Content area -->
<!--<div class="content">-->
    <!-- Inner container -->
<div class="card">
    <div class="card-body">
        <ul class="nav nav-tabs nav-tabs-highlight justify-content-end">
            <li class="nav-item"><a href="#right-fr1" class="nav-link active" data-toggle="tab"><i class="icon-cloud mr-2"></i>Forecast</a></li>
            <li class="nav-item"><a href="#right-fr2" class="nav-link" data-toggle="tab"><i class="icon-stack-plus mr-2"></i>Add Data</a></li>	
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade show active" id="right-fr1">
                <div class="d-flex align-items-start flex-column flex-md-row">
                    <!-- Left content -->
                    <div class="w-100 overflow-auto order-2 order-md-1">

                        <!-- Questions list -->
                        <div class="card-group-control card-group-control-right">
                            <?php foreach ($get_data_hotels as $get_hotels){ ?>    
                            <div class="card mb-2">
                                <div class="card-header">
                                    <h6 class="card-title">
                                        <a class="text-default collapsed" data-toggle="collapse" href="#<?=$get_hotels->idhotels;?>">
                                            <strong><?=$get_hotels->hotels_name;?></strong>
                                        </a>
                                    </h6>
                                </div>

                                <div id="<?=$get_hotels->idhotels;?>" class="collapse">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered table-hover text-nowrap table-xs ">
                                                <thead>
                                                    <tr>
                                                        <th>Description</th>
                                                        <?php for($days= 1; $days<=7; $days++ ){ ?>	
                                                        <th><?php echo date('d-M',strtotime("+$days days")); ?></th>
                                                        <?php } ?>    
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>Room Available</td>
                                                        <?php for($days= 1; $days<=7; $days++ ){ ?>	
                                                        <th><?php echo $get_hotels->total_rooms;  ?></th>
                                                        <?php } ?>  
                                                    </tr>
                                                    <tr>
                                                        <td>Confirmed</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Tentative</td>
                                                    </tr>
                                                    <tr>
                                                        <td>On Hand Confirmed + Tentative</td>
                                                    </tr>
                                                    <tr>
                                                        <td>% Occ Confirmed</td>
                                                    </tr>
                                                    <tr>
                                                        <td>% Occ Confirmed + Tentative</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Avg. Room Rate</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="card-footer bg-transparent d-sm-flex align-items-sm-center border-top-0 pt-0">
                                        <span class="text-muted">Latest update: May 25, 2015</span>
                                    
                                    </div>
                                </div>
                            </div>
                            <?php } ?>

                            
                        </div>
                        <!-- /questions list -->
                    </div>
                    <!-- /left content -->
                </div>
            </div>
            <div class="tab-pane fade" id="right-fr2">
                <form action="<?php echo base_url()?>smartreportforecast/add_forecast7days_data" method="post" accept-charset="utf-8"	enctype="multipart/form-data">	
                <div class="col-md-8">	
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
                            </div>
                        </div> 
                    </div>
					<div class="table-responsive">
						<table class="table text-nowrap table-hover" id="example">
							<thead>
								<tr>
                                    <th>Description</th>
                                    <?php for($days= 1; $days<=7; $days++ ){ ?>	
                                    <th><?php echo date('d-M',strtotime("+$days days")); ?></th>
                                    <?php } ?> 
									

								</tr>
							</thead>

							<tbody>
								<tr>
									<td>Room Out of Order</td>                                    
                                    <?php for($days= 1; $days<=7; $days++ ){ ?>	
                                        <td><input type="text"
											oninput="this.value = this.value.replace(/[^\d]/, '').replace(/(\..*)\./g, '$1');"
											name="room_out[]" class="form-control border-grey border-1" required></td>
                                    <?php } ?> 	
                                </tr>
                                
                                <tr>
									<td>Confirmed</td>                                    
                                    <?php for($days= 1; $days<=7; $days++ ){ ?>	
                                        <td><input type="text"
											oninput="this.value = this.value.replace(/[^\d]/, '').replace(/(\..*)\./g, '$1');"
											name="confirmed[]" class="form-control border-grey border-1" required></td>
                                    <?php } ?> 	
                                </tr>
                                
                                <tr>
									<td>Tentative</td>                                    
                                    <?php for($days= 1; $days<=7; $days++ ){ ?>	
                                        <td><input type="text"
											oninput="this.value = this.value.replace(/[^\d]/, '').replace(/(\..*)\./g, '$1');"
											name="tentative[]" class="form-control border-grey border-1" required></td>
                                    <?php } ?> 	
                                </tr>
                                
                                <tr>
									<td>Avg. Room Rate</td>                                    
                                    <?php for($days= 1; $days<=7; $days++ ){ ?>	
                                        <td><input type="text"
											oninput="this.value = this.value.replace(/[^\d]/, '').replace(/(\..*)\./g, '$1');"
											name="arr[]" class="form-control border-grey border-1" required></td>
                                    <?php } ?> 	
                                </tr>
                                <tr>
                                <?php for($days= 1; $days<=7; $days++ ){ ?>	
                                    <td><input type="hidden" name="date_forecast[]"value="<?php echo date('Y-m-d',strtotime("+$days days"));?>"> </td>
                                    <?php } ?> 
                                </tr>
								
							</tbody>
						</table>

						<div class="text-center">
							<button type="submit" class="btn bg-teal-400"><?php echo $lang_submit;?></button>
						</div>

					</div>
				</form>
            </div>
        </div>
    
</div>
    <!-- /inner container -->
<!--</div>-->
<!-- /content area -->