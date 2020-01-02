<!DOCTYPE html>
<html lang="en">

<head>

<?php
    if ($dateToView == NULL){
		$dateToView = date("Y");
	}
	$url_year = $dateToView;
   
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


    <meta charset="UTF-8">
    <title><?php // echo $lang_pnl_budget.' '.$perdate.' '.$monthObj->format('F').' '.$peryear; ?></title>



</head>

<body>
    <style>
        #pdfreport {
            font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            margin-left: auto;
            margin-right: auto;
            font-size: 9px;


        }
        .hidden{
            display: none !important;
        }

        #pdfreport td {
            border: 1px solid #ddd;
            padding: 3px;

        }

        #pdfreport th {
            border: 1px solid #ddd;
            padding: 5px;
        }



        #pdfreport tr:hover {
            background-color: #ddd;
        }

        #pdfreport th {
            background-color: #353b48;
            color: white;
            text-align: center;
        }

        .rata-kanan {
            vertical-align: middle;
            text-align: right;
        }
    </style>
    <!-- partial:index.partial.html -->
    <div class="container">
        <table id="pdfreport">
            <caption><strong style="font-size: 14px;"><?php //echo 'STATISTIC DSR '.$perdate.' '.$monthObj->format('F').' '.$peryear; ?></strong>
                <br /></caption>

            <thead>
                <tr>
                    <th rowspan="2">Description</th>
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
                    <th>Year To Date</th>
                    <th>(%)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td colspan="15"><strong>STATISCTIC</strong></td>                   
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
                    <td class="rata-kanan">
                        <?php echo number_format(cal_days_in_year($dateToView)* $total_rooms->total_rooms,0); ?></td>
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
                    <tr>
                    <?php if ($smartreport_pnlcategory->idpnlcategory != 1) { ?>
                        <td  colspan="15"> <strong><?php echo $smartreport_pnlcategory->pnl_category;?></strong></td>
                    <?php } ?>
                        
                    </tr>
                <?php foreach ($smartreport_pnllist_data as $smartreport_pnllist ){
                    $total_budget = $this->Smartreport_pnl_model->get_total_budget( $smartreport_pnllist->idpnl, $idhotel_custom, $dateToView);?>
                    <tr>
                        <td>&emsp;&emsp;<?= $smartreport_pnllist->pnl_name;?></td>
                        <td class="rata-kanan">
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
                                    
                                }
                                else if($smartreport_pnllist->idpnlcategory !=1 && $smartreport_pnllist->idpnlcategory !=2 && $smartreport_pnllist->idpnlcategory !=6 ){
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
                        <td <?php  if ($smartreport_pnlcategory->idpnlcategory == 1) {echo "class='hidden'";} ?>>
                            <strong><?php echo "TOTAL ".$smartreport_pnlcategory->pnl_category;?></strong></td>
                        <td
                            <?php  if ($smartreport_pnlcategory->idpnlcategory == 1) {echo "class='hidden'";}else{echo "class='rata-kanan'";}?>>
                            <strong><?php echo number_format($grandtotal_pnlcategory->GRANDTOTAL_PNLCATEGORY,0);?></strong>
                        </td>
                        <td
                            <?php  if ($smartreport_pnlcategory->idpnlcategory == 1) {echo "class='hidden'";}else{echo "class='rata-kanan'";}?>>
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
                        <td
                            <?php  if ($smartreport_pnlcategory->idpnlcategory == 1) {echo "class='hidden'";}else{echo "class='rata-kanan'";}?>>
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
                        echo number_format(($grandtotal_und_exp/$grandtotal_totalsales->GRANDTOTAL_PNLCATEGORY)*100,2).'%';
                    ?>
                        </strong>
                    </td>

                    <?php for($month= 1; $month<=12; $month++ ){ ?>
                    <td class='rata-kanan'>
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
                        echo number_format(($grandtotal_gross_opr_profit/$grandtotal_totalsales->GRANDTOTAL_PNLCATEGORY)*100,2).'%';
                    ?>
                        </strong>
                    </td>

                    <?php for($month= 1; $month<=12; $month++ ){ ?>
                    <td class='rata-kanan'>
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
                            $grandtotal_gop = ($grandtotal_gross_opr_profit / $grandtotal_total_sales->GRANDTOTAL_PNLCATEGORY)*100;													
                        ?>
                        <strong><?php echo number_format($grandtotal_gop,2).'%';?></strong>
                    </td>


                    <?php for($month= 1; $month<=12; $month++ ){ ?>
                    <td class='rata-kanan'>
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
                            $grandtotal_all_payroll = (($grandtotal_payroll_rel->GRANDTOTAL_PNLCATEGORY + $grandtotal_und_payroll->GRANDTOTAL_PNLCATEGORY)  / $grandtotal_total_sales->GRANDTOTAL_PNLCATEGORY)*100;
                            
                        ?>
                        <strong><?php echo number_format($grandtotal_all_payroll,2).'%';?></strong>
                    </td>


                    <?php for($month= 1; $month<=12; $month++ ){ ?>
                    <td class='rata-kanan'>
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
                            $grandtotal_budget_energycost = ($grandtotal_energy_cost->TOTAL_BUDGET / $grandtotal_total_sales->GRANDTOTAL_PNLCATEGORY)*100;													
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
                            $grandtotal_budget_expense = (($grandtotal_ang_und_exp->TOTAL_BUDGET + $grandtotal_pomec_und_exp->TOTAL_BUDGET + $grandtotal_snm_und_exp->TOTAL_BUDGET + $grandtotal_other_expense->GRANDTOTAL_PNLCATEGORY)/$grandtotal_total_sales->GRANDTOTAL_PNLCATEGORY)*100;														
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
                            $grandtotal_budget_cos = ($grandtotal_cost_of_sales->GRANDTOTAL_PNLCATEGORY / $grandtotal_total_sales->GRANDTOTAL_PNLCATEGORY)*100;
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
                            $grandtotal_budget_salesmarketing = ($grandtotal_snm_und_exp->TOTAL_BUDGET / $grandtotal_total_sales->GRANDTOTAL_PNLCATEGORY)*100;
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

            <tfoot>
                <tr>
                    <td colspan="11" style="font-size: 9px;">Sources: Kagum Hotels Smartdata.</td>
                </tr>
            </tfoot>
        </table>
    </div>

</body>

</html>