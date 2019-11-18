
<!-- Main sidebar -->
<div class="sidebar sidebar-dark sidebar-main sidebar-fixed sidebar-expand-md">

<!-- Sidebar mobile toggler -->
<div class="sidebar-mobile-toggler text-center">
    <a href="#" class="sidebar-mobile-main-toggle">
        <i class="icon-arrow-left8"></i>
    </a>
    Navigation
    <a href="#" class="sidebar-mobile-expand">
        <i class="icon-screen-full"></i>
        <i class="icon-screen-normal"></i>
    </a>
</div>
<!-- /sidebar mobile toggler -->


<!-- Sidebar content -->
<div class="sidebar-content">

    <!-- User menu -->
    <div class="sidebar-user">
        <div class="card-body">
            <div class="media">
                <div class="mr-3">
                    <a href="#"><img src="<?php echo base_url();?>assets/backend/global_assets/images/placeholders/placeholder.jpg" width="38" height="38" class="rounded-circle" alt=""></a>
                </div>

                <div class="media-body">
                    <div class="media-title font-weight-semibold"><?php echo $user_na; ?></div>
                    <div class="font-size-xs opacity-50">
                        <i class="icon-vcard font-size-sm"></i> &nbsp;
                            <?php if ($user_le == '1'){
                                echo "Superadmin";
                            }else if ($user_le == '2'){
                                echo "Manager";
                            }else if ($user_le == '3'){
                                echo "Staff";
                            } ?><br/>
                        
                    </div>
                    
                    
                </div>
            </div>
        </div>
    </div>
    <!-- /user menu -->


    <!-- Main navigation -->
    <div class="card card-sidebar-mobile">
        <ul class="nav nav-sidebar" data-nav-type="accordion">

            <!-- Main -->
            
            <li class="nav-item-header"><div class="text-uppercase font-size-xs line-height-xs">Main</div> <i class="icon-menu" title="Main"></i></li>
            
            <?php if ($user_le === '1' || $user_le === '2' || $user_le === '3' ) {?>
            <li class="nav-item">
                <a href="<?=base_url()?>smartreport" class="nav-link <?php if ($tk_m == 'index' || $tk_m == 'dashboard') { ?><?php echo 'active'; } ?>">
                    <i class="icon-home4"></i>
                    <span>
                        <?php echo $lang_dashboard; ?>
                    </span>
                </a>
            </li>
            <?php } ?>            

            <?php if ($user_le === '1' ) {?>
            <li class="nav-item nav-item-submenu <?php if ($tk_m == 'list_city' ) { ?><?php echo 'nav-item-open'; } else { echo '';} ?>">
                <a href="#" class="nav-link"><i class="icon-city"></i> <span><?php echo $lang_city; ?></span></a>
                <ul class="nav nav-group-sub" data-submenu-title="<?php echo $lang_city; ?>" <?php if ($tk_m == 'list_city') { ?>  <?php echo 'style="display: block;"'; } else { echo 'style="display: none;"';} ?>>
                    <li class="nav-item"><a href="<?=base_url()?>smartreport/list-city" class="nav-link <?php if ($tk_m == 'list_city') { ?>  <?php echo 'active'; } ?>" ><?php echo $lang_list_city; ?></a></li>                                      
                </ul>
            </li>
            <?php } ?>

            <?php if ($user_le === '1' ) {?>
            <li class="nav-item nav-item-submenu <?php if ($tk_m == 'list_departement' ) { ?><?php echo 'nav-item-open'; } else { echo '';} ?>">
                <a href="#" class="nav-link"><i class="icon-tree6"></i> <span><?php echo $lang_departement; ?></span></a>
                <ul class="nav nav-group-sub" data-submenu-title="<?php echo $lang_departement; ?>" <?php if ($tk_m == 'list_departement') { ?>  <?php echo 'style="display: block;"'; } else { echo 'style="display: none;"';} ?>>
                    <li class="nav-item"><a href="<?=base_url()?>smartreport/list-departement" class="nav-link <?php if ($tk_m == 'list_departement') { ?>  <?php echo 'active'; } ?>" ><?php echo $lang_list_departement; ?></a></li>                                      
                </ul>
            </li>
            <?php } ?>     

            <?php if ($user_le === '1' || $user_le === '2' ) {?>
            <li class="nav-item nav-item-submenu <?php if ($tk_m == 'list_hotel' || $tk_m == 'competitor_hotel' ) { ?><?php echo 'nav-item-open'; } else { echo '';} ?>">
                <a href="#" class="nav-link"><i class="icon-office"></i> <span><?php echo $lang_hotel; ?></span></a>
                <ul class="nav nav-group-sub" data-submenu-title="<?php echo $lang_hotel; ?>" <?php if ($tk_m == 'list_hotel' || $tk_m == 'competitor_hotel') { ?>  <?php echo 'style="display: block;"'; } else { echo 'style="display: none;"';} ?>>
                    <li class="nav-item"><a href="<?=base_url()?>smartreport/list-hotel" class="nav-link <?php if ($tk_m == 'list_hotel') { ?>  <?php echo 'active'; } ?>"><?php echo $lang_list_hotels; ?></a></li>     
                    <li class="nav-item"><a href="<?=base_url()?>smartreport/competitor-hotel" class="nav-link <?php if ($tk_m == 'competitor_hotel') { ?>  <?php echo 'active'; } ?>"><?php echo $lang_competitor_hotels; ?></a></li>                                      
                </ul>
            </li>
            <?php } ?>

            <?php if ($user_le === '1' || $user_le === '2' ) {?>
            <li class="nav-item nav-item-submenu <?php if ($tk_m == 'pnl_category' || $tk_m == 'pnl_list' || $tk_m == 'actual_pnl'  || $tk_m == 'budget_pnl' ) { ?><?php echo 'nav-item-open'; } else { echo '';} ?>">
                <a href="#" class="nav-link"><i class="icon-align-left"></i> <span><?php echo $lang_pnl; ?></span></a>
                <ul class="nav nav-group-sub" data-submenu-title="<?php echo $lang_pnl; ?>" <?php if ($tk_m == 'pnl_category' || $tk_m == 'pnl_list' || $tk_m == 'actual_pnl'  || $tk_m == 'budget_pnl' ) { ?>  <?php echo 'style="display: block;"'; } else { echo 'style="display: none;"';} ?>>
                    <li class="nav-item"><a href="<?=base_url()?>smartreportpnl/actual-pnl" class="nav-link <?php if ($tk_m == 'actual_pnl') { ?>  <?php echo 'active'; } ?>"><?php echo $lang_pnl_expense; ?></a></li>    
                    <li class="nav-item"><a href="<?=base_url()?>smartreportpnl/budget-pnl" class="nav-link <?php if ($tk_m == 'budget_pnl') { ?>  <?php echo 'active'; } ?>"><?php echo $lang_pnl_budget; ?></a></li>
                    <li class="nav-item"><a href="<?=base_url()?>smartreportpnl/pnl-category" class="nav-link <?php if ($tk_m == 'pnl_category') { ?>  <?php echo 'active'; } ?>"><?php echo $lang_pnl_category; ?></a></li>
                    <li class="nav-item"><a href="<?=base_url()?>smartreportpnl/pnl-list" class="nav-link <?php if ($tk_m == 'pnl_list') { ?>  <?php echo 'active'; } ?>"><?php echo $lang_pnl_list; ?></a></li>     
                </ul>
            </li>
            <?php } ?>

            <?php if ($user_le === '1' || $user_le === '2' || $user_le ==='3' ) {?>
            <li class="nav-item nav-item-submenu <?php if ($tk_m == 'hotel_competitor_analysis' || $tk_m == 'daily_sales_report' ) { ?><?php echo 'nav-item-open'; } else { echo '';} ?>">
                <a href="#" class="nav-link"><i class="icon-chart"></i> <span><?php echo $lang_analysis; ?></span></a>
                <ul class="nav nav-group-sub" data-submenu-title="<?php echo $lang_analysis; ?>" <?php if ($tk_m == 'hotel_competitor_analysis' || $tk_m == 'daily_sales_report' ) { ?>  <?php echo 'style="display: block;"'; } else { echo 'style="display: none;"';} ?>>
                    <li class="nav-item"><a href="<?=base_url()?>smartreportdsr/daily-sales-report" class="nav-link <?php if ($tk_m == 'daily_sales_report') { ?>  <?php echo 'active'; } ?>"><i class="icon-cabinet"></i><?php echo $lang_dsr; ?></a></li>    
                    <li class="nav-item"><a href="<?=base_url()?>smartreport/hotel-competitor-analysis" class="nav-link <?php if ($tk_m == 'hotel_competitor_analysis') { ?>  <?php echo 'active'; } ?>"><i class="icon-archive"></i><?php echo $lang_hotel_comp_anl; ?></a></li>
                </ul>
            </li>
            <?php } ?>

            <?php if ($user_le === '1' ) {?>
            <li class="nav-item nav-item-submenu <?php if ($tk_m == 'list_users' /*AND 'add_user'*/) { ?><?php echo 'nav-item-open'; } else { echo '';} ?> ">
                <a href="#" class="nav-link"><i class="icon-users2"></i> <span><?php echo $lang_user; ?></span></a>
                <ul class="nav nav-group-sub" data-submenu-title="<?php echo $lang_user; ?>" <?php if ($tk_m == 'list_users') { ?>  <?php echo 'style="display: block;"'; } else { echo 'style="display: none;"';} ?>>
                    <!--<li class="nav-item"><a href="<?//=base_url()?>admin/add_user" class="nav-link <?php //if ($tk_m == 'add_user') { ?>  <?php //echo 'active'; } ?>"><?php //echo $lang_add_user; ?></a></li> --> 
                    <li class="nav-item"><a href="<?=base_url()?>smartreport/list-users" class="nav-link <?php if ($tk_m == 'list_users') { ?>  <?php echo 'active'; } ?>"><?php echo $lang_list_users; ?></a></li>                                      
                </ul>
            </li>
            <?php } ?>

            <?php if ($user_le === '1') {?>
            <li class="nav-item nav-item-submenu <?php if ($tk_m == 'list_slider' || $tk_m == 'add_slider' || $tk_m == 'update_slider') { ?><?php echo 'nav-item-open'; } else { echo '';} ?>">
                <a href="#" class="nav-link"><i class="icon-cog4 spinner"></i> <span><?php echo $lang_setting; ?></span></a>
                <ul class="nav nav-group-sub" data-submenu-title="Layouts" <?php if ($tk_m == 'list_slider' || $tk_m == 'add_slider' || $tk_m == 'update_slider') { ?>  <?php echo 'style="display: block;"'; } else { echo 'style="display: none;"';} ?> >
                    <!--<li class="nav-item"><a href="#" class="nav-link"><?php //echo $lang_site_setting; ?></a></li>-->
                    <li class="nav-item"><a href="<?=base_url()?>smartreport/list-slider" class="nav-link <?php if ($tk_m == 'list_slider' || $tk_m == 'add_slider' || $tk_m == 'update_slider') { ?>  <?php echo 'active'; } ?>"><i class="icon-images3"></i><?php echo "Maintenance" ?></a></li>                    
                </ul>
            </li>
            <?php } ?>
            
            
            
            <!-- /page kits -->

        </ul>
    </div>
    <!-- /main navigation -->

</div>
<!-- /sidebar content -->

</div>
<!-- /main sidebar -->