<!DOCTYPE html>
<html lang="en" >
    <head>
       
        <style>
            @page { size: 902px 301px; margin: 0px;}

            .box{
                position: relative;
                display: inline-block; /* Make the width of box same as image */
            }
            .box .text{
                position: absolute;
                z-index: 999;
                margin: 0 auto;
                left: 3%;        
                text-align: left;
                top: 28%; /* Adjust this value to move the positioned div up and down */
               
                font-family:  Courier, monospace;
                font-size: 22.5px;
                color: #233B77;
                width: 60%; /* Set the width of the positioned div */
            }
            .box .soldout{
                position: absolute;
                z-index: 999;
                margin: 0 auto;
                left: 25%;        
                text-align: left;
                top: 35%; /* Adjust this value to move the positioned div up and down */
               
                font-size: 24px;
            }
            
        </style>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="robots" content="noindex"/>
        <meta name="googlebot" content="noindex"/>
        <meta name="robots" content="noindex, nofollow"/>
        <meta charset="UTF-8">
        <title><?php echo $idvoucher; ?></title>
    </head>
    <body>
        <div class="box">
            <img src="<?php echo base_url();?>assets/backend/global_assets/images/voucher_kagum_hebat.jpg" alt="" >   
            <div class="text">
                <strong><?php echo $idvoucher; ?></strong>
            </div>   
            <?php if($status_voucher === '0'){ ?>      
            <div class="soldout">
                <img src="<?php echo base_url();?>assets/backend/global_assets/images/soldout.png" alt="" > 
            </div>
            <?php }?>
        </div>
    </body>
</html>