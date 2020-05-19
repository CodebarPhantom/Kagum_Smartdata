<!DOCTYPE html>
<html lang="en">

	<head>	    
	    <?php include 'includes_top.php';?>
    </head>
    
        <?php $sidebar ="";
        if ($tk_m == 'hotel_competitor_analysis' || $tk_m == 'budget_pnl' || $tk_m == 'daily_sales_report' || $tk_m == 'actual_pnl' || $tk_m == 'statistic_dsr' || $tk_m == 'competitor_hotel' || $tk_m == 'dashboard' || $tk_m == 'index' || $tk_m == 'voucher_hotels') { 
            $sidebar = "sidebar-xs";
        }?>
    
	<body class="navbar-top <?php echo $sidebar;?>">
        <!-- Start Main Navbar -->
        <?php include 'main_navbar.php';?>
        <!-- END Main Navbar -->

        <!-- Page content -->
		<div class="page-content">
            <?php include 'main_sidebar.php';?>            
            <div class="content-wrapper">
                <?php include $page_name . '.php'; ?>
                <?php include 'includes_bottom.php';?>
            </div>
        </div>
        <!-- END Page content -->
        <?php include 'js.php';?>
        
	</body>
</html>
