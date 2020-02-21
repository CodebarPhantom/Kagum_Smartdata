<?php 
/* Ambil DATE SEMUANYA DARI DASHBOARD.PHP jaga2 buat minta tiba2 minta sortir dinamanis berdasarkan tanggal*/ 
$dt_OccMTD = $this->Smartreport_hca_model->getOccTotalMTDAllStarById($startdate_mtd,$enddate_mtd);
$session_hotel = $this->Dashboard_model->getDataHotel($idhotel_dashboard);


?>

<script>


var EchartsColumnsWaterfalls = function() {    
    var arr_daily_element = document.getElementById('arrDaily');
    var occ_daily_element = document.getElementById('occDaily');
    var revpar_daily_element = document.getElementById('revparDaily');
    var mpi_mtd_element = document.getElementById('mpi_MTD');

    if (occ_daily_element) {
        // Initialize chart
        var occ_daily = echarts.init(occ_daily_element);
            //
            // Chart config
            //

            // Options
            occ_daily.setOption({

                // Define colors
                color: ['#f6e58d', '#ffbe76', '#2196f3', '#badc58', '#c23616', '#7ed6df', 
                        '#e056fd', '#686de0', '#30336b', '#5758BB', '#f9ca24', '#f0932b', 
                        '#eb4d4b', '#6ab04c', '#44bd32', '#22a6b3', '#be2edd', '#4834d4', 
                        '#130f40','#006266'],

                // Global text styles
                textStyle: {
                    fontFamily: 'Roboto, Arial, Verdana, sans-serif',
                    fontSize: 13
                },

                // Chart animation duration
                animationDuration: 1500,

                // Setup grid
                grid: {
                    left: 20,
                    right: 50,
                    top: 120,
                    bottom: 0,
                    containLabel: true
                },

                title: {
                    text: 'Occupancy',
                    subtext: '<?php echo $session_hotel->hotels_name.' - '. $monthObj->format('F').' '. $graphYear; ?>',
                    left: 'center',
               
                    textStyle: {
                        fontSize: 17,
                        fontWeight: 500
                    },
                    subtextStyle: {
                        fontSize: 12
                    }
                },

                // Add legend
                legend: {
                    
                    data: [<?php foreach ($getHotelAllStarByUser_data->result() as $getHotelAllStarByUser){ 
                        //error sini kadang suka ga muncul harus ganti idhotels jangan ada komanya di nama hotel
                        echo "'".$getHotelAllStarByUser->hotels_name."'".",";
                    } ?>],
                    itemHeight: 5,
                    itemGap: 10,
                    top: 50,
                    left: 'center',
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
                    }
                    
                },

                // Horizontal axis
                xAxis: [{
                    type: 'category',
                    boundaryGap: false,
                    data: [<?php $dayInMonth = cal_days_in_month(CAL_GREGORIAN, $graphMonth, $graphYear);
                            for ($mn = 1; $mn <= $dayInMonth; ++$mn) {
                                $timestamp = strtotime($graphYear.'-'.$graphMonth.'-'.$mn);
                                $day = date('D',$timestamp);
                                echo "'".$mn.'-'.$day."',";
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
                        lineStyle: {
                            color: ['#eee']
                        }
                    }
                }],

                // Vertical axis
                yAxis: [{
                    type: 'value',
                    axisLabel: {
                            //formatter: function(){
                            //return (this.value/1000000)+" JT"}
                            //}
                        formatter: '{value} %',
                        color: '#333'
                    },
                    axisLine: {
                        lineStyle: {
                            color: '#999'
                        }
                    },
                    splitLine: {
                        lineStyle: {
                            color: ['#eee']
                        }
                    },
                    splitArea: {
                        show: true,
                        areaStyle: {
                            color: ['rgba(250,250,250,0.1)', 'rgba(0,0,0,0.01)']
                        }
                    }
                }],

                // Add series
                series: [
                    <?php foreach ($getHotelAllStarByUser_data->result() as $getHotelAllStarByUser){ ?>
                    {
                        name: "<?php echo $getHotelAllStarByUser->hotels_name;?>",
                        type: 'line',
                    
                        data: [<?php $dayInMonth = cal_days_in_month(CAL_GREGORIAN,$graphMonth, $graphYear);
                            for ($mn = 1; $mn <= $dayInMonth; ++$mn) {
                                if ($mn <= 9){
                                    $tgl = '0'.$mn;
                                }else{
                                    $tgl = $mn;
                                }
                                $dateDailyGraph = $graphYear.'-'.$graphMonth.'-'.$tgl; 
                                $occDailyData = $this->Smartreport_hca_model->getDailyOccForGraphById($getHotelAllStarByUser->idhotels,$dateDailyGraph);
                                echo "'".$occDailyData->graph_OccDaily."',";
                            }
                        ?>],
                        smooth: true,
                        symbolSize: 7,                       
                        itemStyle: {
                            normal: {
                                borderWidth: 2
                            }
                        }
                    },
                    <?php  } ?>
                
                ]
            });
    }

    if (arr_daily_element) {
        // Initialize chart
        var arr_daily = echarts.init(arr_daily_element);
            //
            // Chart config
            //

            // Options
            arr_daily.setOption({

                // Define colors
                color: ['#f6e58d', '#ffbe76', '#2196f3', '#badc58', '#c23616', '#7ed6df', 
                        '#e056fd', '#686de0', '#30336b', '#5758BB', '#f9ca24', '#f0932b', 
                        '#eb4d4b', '#6ab04c', '#44bd32', '#22a6b3', '#be2edd', '#4834d4', 
                        '#130f40','#006266'],

                // Global text styles
                textStyle: {
                    fontFamily: 'Roboto, Arial, Verdana, sans-serif',
                    fontSize: 13
                },

                // Chart animation duration
                animationDuration: 1500,

                // Setup grid
                grid: {
                    left: 20,
                    right: 50,
                    top: 120,
                    bottom: 0,
                    containLabel: true
                },

                title: {
                    text: 'Average Room Rate',
                    subtext: '<?php $session_hotel = $this->Dashboard_model->getDataHotel($idhotel_dashboard); echo $session_hotel->hotels_name.' - '. $monthObj->format('F').' '. $graphYear; ?>',
                    left: 'center',
               
                    textStyle: {
                        fontSize: 17,
                        fontWeight: 500
                    },
                    subtextStyle: {
                        fontSize: 12
                    }
                },

                // Add legend
                legend: {
                    
                    data: [<?php foreach ($getHotelAllStarByUser_data->result() as $getHotelAllStarByUser){ 
                        //error sini kadang suka ga muncul harus ganti idhotels
                        echo "'".$getHotelAllStarByUser->hotels_name."',";
                    } ?>],
                    itemHeight: 5,
                    itemGap: 10,
                    top: 50,
                    left: 'center',
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
                    }
                },

                // Horizontal axis
                xAxis: [{
                    type: 'category',
                    boundaryGap: false,
                    data: [<?php $dayInMonth = cal_days_in_month(CAL_GREGORIAN, $graphMonth, $graphYear);
                                    
                            for ($mn = 1; $mn <= $dayInMonth; ++$mn) {
                                $timestamp = strtotime($graphYear.'-'.$graphMonth.'-'.$mn);
                                $day = date('D',$timestamp);
                                echo "'".$mn.'-'.$day."',";
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
                        lineStyle: {
                            color: ['#eee']
                        }
                    }
                }],

                // Vertical axis
                yAxis: [{
                    type: 'value',
                    axisLabel: {
                        color: '#333'
                    },
                    axisLine: {
                        lineStyle: {
                            color: '#999'
                        }
                    },
                    splitLine: {
                        lineStyle: {
                            color: ['#eee']
                        }
                    },
                    splitArea: {
                        show: true,
                        areaStyle: {
                            color: ['rgba(250,250,250,0.1)', 'rgba(0,0,0,0.01)']
                        }
                    }
                }],

                // Add series
                series: [
                    <?php foreach ($getHotelAllStarByUser_data->result() as $getHotelAllStarByUser){ ?>
                    {
                        name: "<?php echo $getHotelAllStarByUser->hotels_name;?>",
                        type: 'line',
                    
                        data: [<?php $dayInMonth = cal_days_in_month(CAL_GREGORIAN,$graphMonth, $graphYear);
                            for ($mn = 1; $mn <= $dayInMonth; ++$mn) {
                               // if ($mn <= 9){
                                //    $tgl = '0'.$mn;
                               // }else{
                                    $tgl = $mn;
                               // }
                                $dateDailyGraph = $graphYear.'-'.$graphMonth.'-'.$tgl; 
                                $arrDailyData = $this->Smartreport_hca_model->getDailyArrForGraphById($getHotelAllStarByUser->idhotels,$dateDailyGraph);
                                echo "'".$arrDailyData->graph_ArrDaily."',";
                            }
                        ?>],
                        smooth: true,
                        symbolSize: 7,                       
                        itemStyle: {
                            normal: {
                                borderWidth: 2
                            }
                        }
                    },
                    <?php  } ?>
                
                ]
            });
    }

    if (revpar_daily_element) {
        // Initialize chart
        var revpar_daily = echarts.init(revpar_daily_element);
            //
            // Chart config
            //

            // Options
            revpar_daily.setOption({

                // Define colors
                color: ['#f6e58d', '#ffbe76', '#2196f3', '#badc58', '#c23616', '#7ed6df', 
                        '#e056fd', '#686de0', '#30336b', '#5758BB', '#f9ca24', '#f0932b', 
                        '#eb4d4b', '#6ab04c', '#44bd32', '#22a6b3', '#be2edd', '#4834d4', 
                        '#130f40','#006266'],

                // Global text styles
                textStyle: {
                    fontFamily: 'Roboto, Arial, Verdana, sans-serif',
                    fontSize: 13
                },

                // Chart animation duration
                animationDuration: 1500,

                // Setup grid
                grid: {
                    left: 20,
                    right: 50,
                    top: 120,
                    bottom: 0,
                    containLabel: true
                },

                title: {
                    text: 'Rev Par',
                    subtext: '<?php $session_hotel = $this->Dashboard_model->getDataHotel($idhotel_dashboard); echo $session_hotel->hotels_name.' - '. $monthObj->format('F').' '. $graphYear; ?>',
                    left: 'center',
               
                    textStyle: {
                        fontSize: 17,
                        fontWeight: 500
                    },
                    subtextStyle: {
                        fontSize: 12
                    }
                },

                // Add legend
                legend: {
                    
                    data: [<?php foreach ($getHotelAllStarByUser_data->result() as $getHotelAllStarByUser){ 
                        //error sini kadang suka ga muncul harus ganti idhotels
                        echo "'".$getHotelAllStarByUser->hotels_name."',";
                    } ?>],
                    itemHeight: 5,
                    itemGap: 10,
                    top: 50,
                    left: 'center',
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
                    }
                    
                },

                // Horizontal axis
                xAxis: [{
                    type: 'category',
                    boundaryGap: false,
                    data: [<?php $dayInMonth = cal_days_in_month(CAL_GREGORIAN, $graphMonth, $graphYear);
                            for ($mn = 1; $mn <= $dayInMonth; ++$mn) {
                                $timestamp = strtotime($graphYear.'-'.$graphMonth.'-'.$mn);
                                $day = date('D',$timestamp);
                                echo "'".$mn.'-'.$day."',";
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
                        lineStyle: {
                            color: ['#eee']
                        }
                    }
                }],

                // Vertical axis
                yAxis: [{
                    type: 'value',
                    axisLabel: {
                        color: '#333'
                    },
                    axisLine: {
                        lineStyle: {
                            color: '#999'
                        }
                    },
                    splitLine: {
                        lineStyle: {
                            color: ['#eee']
                        }
                    },
                    splitArea: {
                        show: true,
                        areaStyle: {
                            color: ['rgba(250,250,250,0.1)', 'rgba(0,0,0,0.01)']
                        }
                    }
                }],

                // Add series
                series: [
                    <?php foreach ($getHotelAllStarByUser_data->result() as $getHotelAllStarByUser){ ?>
                    {
                        name: "<?php echo $getHotelAllStarByUser->hotels_name;?>",
                        type: 'line',
                    
                        data: [<?php $dayInMonth = cal_days_in_month(CAL_GREGORIAN,$graphMonth, $graphYear);
                            for ($mn = 1; $mn <= $dayInMonth; ++$mn) {
                                if ($mn <= 9){
                                    $tgl = '0'.$mn;
                                }else{
                                    $tgl = $mn;
                                }
                                $dateDailyGraph = $graphYear.'-'.$graphMonth.'-'.$tgl; 
                                $revparDailyData = $this->Smartreport_hca_model->getDailyRevparForGraphById($getHotelAllStarByUser->idhotels,$dateDailyGraph);
                                echo "'".$revparDailyData->graph_RevparDaily."',";
                            }
                        ?>],
                        smooth: true,
                        symbolSize: 7,                       
                        itemStyle: {
                            normal: {
                                borderWidth: 2
                            }
                        }
                    },
                    <?php  } ?>
                
                ]
            });
    }
    // Rose without labels
    if (mpi_mtd_element) {

        // Initialize chart
        var mpi_mtd = echarts.init(mpi_mtd_element);


        //
        // Chart config
        //

        // Options
        mpi_mtd.setOption({

            // Colors
            color: ['#f6e58d', '#ffbe76', '#2196f3', '#badc58', '#c23616', '#7ed6df', 
                        '#e056fd', '#686de0', '#30336b', '#5758BB', '#f9ca24', '#f0932b', 
                        '#eb4d4b', '#6ab04c', '#44bd32', '#22a6b3', '#be2edd', '#4834d4', 
                        '#130f40','#006266'],

            // Global text styles
            textStyle: {
                fontFamily: 'Roboto, Arial, Verdana, sans-serif',
                fontSize: 13
            },
            animationDuration: 3000,

            // Add title
            title: {
                text: 'Market Penetration Index',
                subtext: '<?php echo $session_hotel->hotels_name.' - '. $dashboardDate.' '. $monthObj->format('F').' '. $graphYear; ?>',
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
                trigger: 'item',
                backgroundColor: 'rgba(0,0,0,0.75)',
                padding: [10, 15],
                textStyle: {
                    fontSize: 13,
                    fontFamily: 'Roboto, sans-serif'
                },
                formatter: '{a} <br/>{b}: ({c})'
            },

            // Add legend
           /* legend: {
                orient: 'vertical',
                top: 'center',
                left: 0,
                data: [<?php //foreach ($getHotelAllStarByUser_data->result() as $getHotelAllStarByUser){ 
                        //echo "'".$getHotelAllStarByUser->hotels_name."',";
                    //} ?>],
                itemHeight: 8,
                itemWidth: 8
            },*/

            // Add series
            series: [
                {
                    name: 'MPI',
                    type: 'pie',
                    radius: ['10%', '60%'],
                    center: ['50%', '50%'],
                    roseType: 'radius',
                    label: {
                        formatter: '{b}:  ({c})',
                        //position: 'inside'
                    },
                    itemStyle: {
                            normal: {
                                borderWidth: 1,
                                borderColor: '#fff'
                            }
                        },
                    data: [<?php 
                        $rs_mtd = 0; $ri_mtd = 0; $occ_mtd = 0;
                        //

                        foreach ($getHotelAllStarByUser_data->result() as $getHotelAllStarByUser){ 
                        $dt_rsmtd = $this->Smartreport_hca_model->select_rsmtd_perhotel($startdate_mtd,$enddate_mtd,$getHotelAllStarByUser->idhotels);
                        $rs_mtd = $dt_rsmtd->RS_MTD;
						
                        $ri_mtd= $getHotelAllStarByUser->total_rooms * $dashboardDate;

                        if($ri_mtd != 0 && $rs_mtd  != 0 && $dt_OccMTD->graph_OccMTD  != 0){
                            $mpi_mtd = (($rs_mtd / $ri_mtd) / $dt_OccMTD->graph_OccMTD) ;
                        }else{
                            $mpi_mtd = 0;
                        }
                        //error sini kadang suka ga muncul harus ganti idhotels
                        ?>
                        {value: '<?php echo number_format($mpi_mtd,2); ?>', name: '<?php echo $getHotelAllStarByUser->hotels_name;?>'},


                    <?php } ?>
                    ]
                }
            ]
        });
    }

    var triggerChartResize = function() {
        arr_daily_element && arr_daily.resize();
        occ_daily_element && occ_daily.resize();
        revpar_daily_element && revpar_daily.resize();
        mpi_mtd_element && mpi_mtd.resize();
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

    return {
        init: function() {
            EchartsColumnsWaterfalls();
        }
    }
    }();

// Initialize module
// ------------------------------



</script>