<?php
$get_allparenthotel = $this->Smartreport_dsr_model->get_allparenthotel();
?>
<script>
/* ------------------------------------------------------------------------------
 *
 *  # Echarts - Bar and Tornado charts
 *
 *  Demo JS code for echarts_bars_tornados.html page
 *
 * ---------------------------------------------------------------------------- */


// Setup module
// ------------------------------

var EchartsBarsTornados = function() {


    //
    // Setup module components
    //

    // Bar and tornado charts
    var _barsTornadosExamples = function() {
        if (typeof echarts == 'undefined') {
            console.warn('Warning - echarts.min.js is not loaded.');
            return;
        }

        // Define elements
        var bars_basic_element = document.getElementById('bars_basic');
        

        //
        // Charts configuration
        //

        // Basic bar chart
        if (bars_basic_element) {

            // Initialize chart
            var bars_basic = echarts.init(bars_basic_element);


            //
            // Chart config
            //

            // Options
            bars_basic.setOption({

                // Global text styles
                textStyle: {
                    fontFamily: 'Roboto, Arial, Verdana, sans-serif',
                    fontSize: 13
                },

                // Chart animation duration
                animationDuration: 750,

                // Setup grid
                grid: {
                    left: 0,
                    right: 30,
                    top: 60,
                    bottom: 25,
                    containLabel: true
                },

                // Add legend
                /*legend: {
                    data: ['Achievement'],
                    itemHeight: 8,
                    itemGap: 20,
                    textStyle: {
                        padding: [0, 5]
                    }
                },*/

                title: {
                text: 'Achievement',
                subtext: '<?php echo $perdate.' '.$monthObj->format('F').' '.$peryear ?>',
                left: 'center',
                    textStyle: {
                        fontSize: 17,
                        fontWeight: 500
                    },
                    subtextStyle: {
                        fontSize: 12
                    }
                },
                toolbox: {
                    right: 30,
                    show: true,
                    feature: {                        
                        saveAsImage: {title: 'Save As picture'}
                    }
                },

                // Add tooltip
                tooltip: {
                    trigger: 'axis',
                    backgroundColor: 'rgba(0,0,0,0.75)',
                    padding: [10, 15],
                    textStyle: {
                        fontSize: 13,
                        fontFamily: 'Roboto, sans-serif'
                    },
                    axisPointer: {
                        type: 'shadow',
                        shadowStyle: {
                            color: 'rgba(0,0,0,0.025)'
                        }
                    }
                },

                // Horizontal axis
                xAxis: [{
                    type: 'value',
                    boundaryGap: [0, 0.01],
                    axisLabel: {
                        color: '#333',
                        formatter: '{value} %',
                    },
                    axisLine: {
                        lineStyle: {
                            color: '#999'
                        }
                    },
                    splitLine: {
                        show: true,
                        lineStyle: {
                            color: '#eee',
                            type: 'dashed'
                        }
                    }
                }],

                // Vertical axis
                yAxis: [{
                    type: 'category',
                    data: [<?php
                        foreach ($get_allparenthotel as $allparenthotel){

                            echo "'".$allparenthotel->hotels_name."',";
                        }
                    ?>],
                    axisLabel: {
                        color: '#333'
                    },
                    axisLine: {
                        lineStyle: {
                            color: '#999'
                        }
                    },
                    splitLine: {
                        show: true,
                        lineStyle: {
                            color: ['#eee']
                        }
                    },
                    splitArea: {
                        show: true,
                        areaStyle: {
                            color: ['rgba(250,250,250,0.1)', 'rgba(0,0,0,0.015)']
                        }
                    }
                }],

                // Add series
                series: [
                    {
                        name: 'Achievement',
                        type: 'bar',
                        itemStyle: {
                            normal: {
                                color: '#00838F',
                            }
                        },
                        label: {
                            normal: {
                                show: true,
                                position: 'inside'
                            }
                        },

                        data: [<?php
                        foreach ($get_allparenthotel as $allparenthotel){

                            $dt_analystoday = $this->Smartreport_hca_model->select_competitoranalysisondate_perhotel($allparenthotel->idhotels,$dateToView);
                            $dt_dsrtoday = $this->Smartreport_dsr_model->select_dsrondate_perhotel($allparenthotel->idhotels,$dateToView);
                            
                            $dt_trrmtd = $this->Smartreport_hca_model->select_trrmtd_perhotel($startdate_mtd,$enddate_mtd,$allparenthotel->idhotels);                                    
                            $dt_fnbmtd = $this->Smartreport_dsr_model->select_fnbmtd_perhotel($startdate_mtd,$enddate_mtd,$allparenthotel->idhotels);
                            $dt_othmtd = $this->Smartreport_dsr_model->select_othmtd_perhotel($startdate_mtd,$enddate_mtd,$allparenthotel->idhotels);

                            $budget_rooms =  $this->Smartreport_pnl_model->get_rooms_budget($allparenthotel->idhotels, $permonth, $peryear);
                            $budget_fnb =  $this->Smartreport_pnl_model->get_fnb_budget($allparenthotel->idhotels, $permonth, $peryear);
                            $budget_other =  $this->Smartreport_pnl_model->get_other_budget($allparenthotel->idhotels,$permonth, $peryear);
                            $budget_laundry =  $this->Smartreport_pnl_model->get_laundry_budget($allparenthotel->idhotels, $permonth, $peryear);
                            $budget_sport =  $this->Smartreport_pnl_model->get_sport_budget($smartreport_hotelbrand->idhotels, $permonth, $peryear);
                            $budget_spa =  $this->Smartreport_pnl_model->get_spa_budget($smartreport_hotelbrand->idhotels, $permonth, $peryear);

                            
                            
                            if($dt_analystoday != NULL   ){
                                $rs_today = $dt_analystoday->room_sold;
                                $arr_today = $dt_analystoday->avg_roomrate;
                            }else{
                                $rs_today = 0;
                                $arr_today =0;                                        
                            } 

                            if($dt_dsrtoday != NULL){
                                $fnb_today = $dt_dsrtoday->sales_fnb;
                                $oth_today = $dt_dsrtoday->sales_other;   
                            }else{
                                $fnb_today = 0;
                                $oth_today = 0; 
                            }
                            
                            if($dt_trrmtd != NULL && $dt_fnbmtd !=NULL && $dt_othmtd != NULL){                                        
                                $trr_mtd = $dt_trrmtd->TRR_MTD;                                  
                                $fnb_mtd = $dt_fnbmtd->FNB_MTD;                                    
                                $oth_mtd = $dt_othmtd->OTH_MTD;                                        
                            }else{
                                $trr_mtd = 0;
                                $fnb_mtd = 0;
                                $oth_mtd =0;                                        
                            }

                            
                                $getbudget_roomsmtd = ($budget_rooms->BUDGET_ROOMS/$days_this_month)*$perdate;
                                $getbudget_laundrymtd = ($budget_laundry->BUDGET_LAUNDRY/$days_this_month)*$perdate;
                                $getbudget_othermtd = ($budget_other->BUDGET_OTHER/$days_this_month)*$perdate;
                                $getbudget_fnbmtd = ($budget_fnb->BUDGET_FNB/$days_this_month)*$perdate;
                                $getbudget_sportmtd = ($budget_sport->BUDGET_SPORT/$days_this_month)*$perdate;
                                $getbudget_spamtd = ($budget_spa->BUDGET_SPA/$days_this_month)*$perdate;

                                $trr_today = $rs_today * $arr_today;
                                $tot_sales_today = $trr_today + $fnb_today + $oth_today;
                                $tot_sales_mtd = $trr_mtd + $fnb_mtd + $oth_mtd;
                                $totalbudget_mtd = $getbudget_roomsmtd+$getbudget_fnbmtd+$getbudget_laundrymtd+$getbudget_othermtd+$getbudget_sportmtd+$getbudget_spamtd;

                                if($tot_sales_mtd != 0 && $totalbudget_mtd != 0){echo number_format(($tot_sales_mtd/$totalbudget_mtd)*100,2).',';}else{
                                    echo (0).',';
                                }
                            
                        }
                    ?>]
                    }
                ]
            });
        }



        //
        // Resize charts
        //

        // Resize function
        var triggerChartResize = function() {
            bars_basic_element && bars_basic.resize();
      
        };

        // On sidebar width change
        $(document).on('click', '.sidebar-control', function() {
            setTimeout(function () {
                triggerChartResize();
            }, 0);
        });

        // On window resize
        var resizeCharts;
        window.onresize = function () {
            clearTimeout(resizeCharts);
            resizeCharts = setTimeout(function () {
                triggerChartResize();
            }, 200);
        };
    };


    //
    // Return objects assigned to module
    //

    return {
        init: function() {
            _barsTornadosExamples();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    EchartsBarsTornados.init();
});
</script>