<style>
.form-control:focus {     
    border-color: #009688;    
}

.rata-kanan{
	vertical-align: middle; 
	text-align: right;
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
            <h4><i class="icon-arrow-left52 mr-2"></i> <span class="font-weight-semibold"><?php echo $lang_sevendays_forecast; ?></h4>
            <a href="#" class="header-elements-toggle text-default d-md-none"><i class="icon-more"></i></a>
        </div>

        <div class="header-elements d-none">
            <div class="form-group">										
                <a href="<?php echo base_url('smartreportforecast/forecast7days_export');?>"><button type="button" class="btn bg-teal-400 ">Export to XLSX <i class="icon-file-excel ml-2"></i></button></a>
            </div>
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
            <li class="nav-item"><a href="#right-fr1" class="nav-link active" data-toggle="tab"><i class="icon-cloud mr-2"></i><?php echo $lang_forecast; ?></a></li>
            <li class="nav-item"><a href="#right-fr2" class="nav-link" data-toggle="tab"><i class="icon-stack-plus mr-2"></i><?php echo $lang_add_data; ?></a></li>	
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
                                                        <th><?php echo $lang_description; ?></th>
                                                        <?php for($days= 1; $days<=7; $days++ ){ ?>	
                                                        <th class="rata-kanan"><?php echo date('D',strtotime("+$days days")).', '.date('d-M',strtotime("+$days days")); ?></th>
                                                        <?php } ?>    
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td><?php echo $lang_room_available; ?></td>
                                                        <?php for($days= 1; $days<=7; $days++ ){ ?>	
                                                        <td class="rata-kanan">
                                                            <?php 
                                                                $date_check = date('Y-m-d',strtotime("+$days days"));  
                                                                $roomout_forecast = $this->Smartreport_forecast_model->room_out_forecast($get_hotels->idhotels, $date_check);
                                                                if($roomout_forecast != NULL){
                                                                    $outoforder = $roomout_forecast->ROOM_OUT;
                                                                }else{
                                                                    $outoforder = 0;
                                                                }

                                                                echo number_format($get_hotels->total_rooms - $outoforder);  
                                                            ?>
                                                        </td>
                                                        <?php } ?>  
                                                    </tr>
                                                    <tr>
                                                        <td>Confirmed</td>
                                                        <?php for($days= 1; $days<=7; $days++ ){ ?>	
                                                        <td class="rata-kanan">
                                                            <?php
                                                                $date_check = date('Y-m-d',strtotime("+$days days"));                                                                
                                                                $confirmed_forecast = $this->Smartreport_forecast_model->confirmed_forecast($get_hotels->idhotels, $date_check);
                                                                if($confirmed_forecast != NULL){
                                                                    echo number_format($confirmed_forecast->CONFIRMED_FORECAST);
                                                                }else{
                                                                    echo 0;
                                                                }
                                                            ?>
                                                        </td>
                                                        <?php } ?>
                                                    </tr>
                                                    <tr>
                                                        <td>Tentative</td>
                                                        <?php for($days= 1; $days<=7; $days++ ){ ?>	
                                                        <td class="rata-kanan">
                                                            <?php
                                                                $date_check = date('Y-m-d',strtotime("+$days days"));                                                                
                                                                $tentative_forecast = $this->Smartreport_forecast_model->tentative_forecast($get_hotels->idhotels, $date_check);
                                                                if($tentative_forecast != NULL){
                                                                    echo number_format($tentative_forecast->TENTATIVE_FORECAST);
                                                                }else{
                                                                    echo 0;
                                                                }
                                                            ?>
                                                        </td>
                                                        <?php } ?>
                                                    </tr>
                                                    <tr>
                                                        <td>On Hand Confirmed + Tentative</td>
                                                        <?php for($days= 1; $days<=7; $days++ ){ ?>	
                                                        <td class="rata-kanan">
                                                            <?php
                                                                $date_check = date('Y-m-d',strtotime("+$days days"));                                                                
                                                                $confirmed_tentative_forecast = $this->Smartreport_forecast_model->data_forecast($get_hotels->idhotels, $date_check);
                                                                if($confirmed_tentative_forecast != NULL){
                                                                    echo number_format($confirmed_tentative_forecast->TENTATIVE_FORECAST + $confirmed_tentative_forecast->CONFIRMED_FORECAST);
                                                                }else{
                                                                    echo 0;
                                                                }
                                                            ?>
                                                        </td>
                                                        <?php } ?>
                                                    </tr>
                                                    <tr>
                                                        <td>% Occ Confirmed</td>
                                                        <?php for($days= 1; $days<=7; $days++ ){ ?>
                                                        <td class="rata-kanan">
                                                            <?php 
                                                                $date_check = date('Y-m-d',strtotime("+$days days"));  
                                                                $occ_confirmed_forecast = $this->Smartreport_forecast_model->data_forecast($get_hotels->idhotels, $date_check);
                                                                if($occ_confirmed_forecast != NULL){
                                                                    $outoforder = $occ_confirmed_forecast->ROOM_OUT;
                                                                    $confirmed = $occ_confirmed_forecast->CONFIRMED_FORECAST;
                                                                }else{
                                                                    $outoforder = 0;
                                                                    $confirmed = 0;
                                                                }

                                                                echo number_format(($confirmed/($get_hotels->total_rooms - $outoforder))*100,2).'%';  
                                                            ?>
                                                        </td>
                                                        <?php } ?>
                                                    </tr>
                                                    <tr>
                                                        <td>% Occ Confirmed + Tentative</td>
                                                        <?php for($days= 1; $days<=7; $days++ ){ ?>
                                                        <td class="rata-kanan">
                                                            <?php 
                                                                $date_check = date('Y-m-d',strtotime("+$days days"));
                                                                $outoforder = 0;
                                                                $confirmed = 0;
                                                                $tentative = 0;  
                                                                $occ_confirmed_tentative_forecast = $this->Smartreport_forecast_model->data_forecast($get_hotels->idhotels, $date_check);
                                                                if($occ_confirmed_tentative_forecast != NULL){
                                                                    $outoforder = $occ_confirmed_tentative_forecast->ROOM_OUT;
                                                                    $confirmed = $occ_confirmed_tentative_forecast->CONFIRMED_FORECAST;
                                                                    $tentative = $occ_confirmed_tentative_forecast->TENTATIVE_FORECAST;
                                                                }else{
                                                                    $outoforder = 0;
                                                                    $confirmed = 0;
                                                                    $tentative = 0;
                                                                }

                                                                echo number_format((($confirmed+$tentative)/($get_hotels->total_rooms - $outoforder))*100,2).'%';  
                                                            ?>
                                                        </td>
                                                        <?php } ?>
                                                    </tr>
                                                    <tr>
                                                        <td><?php echo $lang_avg_room_rate; ?></td>
                                                        <?php for($days= 1; $days<=7; $days++ ){ ?>	
                                                        <td class="rata-kanan">
                                                            <?php 
                                                                $date_check = date('Y-m-d',strtotime("+$days days"));                                                                
                                                                $arr_forecast = $this->Smartreport_forecast_model->avg_roomrate_forecast($get_hotels->idhotels, $date_check);
                                                                if($arr_forecast != NULL){
                                                                    echo number_format($arr_forecast->ARR_FORECAST);
                                                                }else{
                                                                    echo 0;
                                                                }
                                                            ?>
                                                         </td>
                                                        <?php } ?> 
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="card-footer bg-transparent d-sm-flex align-items-sm-center border-top-0 pt-0">
                                        <span class="text-muted"><?php echo $lang_last_update; ?>
                                            <?php 
                                                
                                                $check_update_forecast = $this->Smartreport_forecast_model->check_lastupdate_forecast($get_hotels->idhotels);
                                                if($check_update_forecast != NULL){
                                                    $username = $check_update_forecast->user_name;
                                                    $datetime_update = $check_update_forecast->date_created;
                                                }else{
                                                    $username = "No Body";
                                                    $datetime_update = "1970-01-01 00:00:00"; 
                                                }

                                                echo date('d F Y H:i', strtotime($datetime_update)).' by '.$username; 
                                            
                                            ?>
                                        </span>
                                    
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
                                    <th><?php echo $lang_description; ?></th>
                                    <?php for($days= 1; $days<=7; $days++ ){ ?>	
                                    <th class="rata-kanan"><?php echo date('D',strtotime("+$days days")).', '. date('d-M',strtotime("+$days days")); ?></th>
                                    <?php } ?>
                                </tr>
							</thead>

							<tbody>
								<tr>
									<td><?php echo $lang_outoforder; ?></td>                                    
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
									<td><?php echo $lang_avg_room_rate; ?></td>                                    
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
</div>
    <!-- /inner container -->
<!--</div>-->
<!-- /content area -->