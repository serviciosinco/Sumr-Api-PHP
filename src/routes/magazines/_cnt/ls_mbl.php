<?php $pth = '../../'; $div_prtn = 'no'; include($pth.'inc/inc.php'); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <meta name="apple-mobile-web-app-status-bar-style" content="black" />
        <title>
        </title>
        <link rel="stylesheet" href="https://ajax.aspnetcdn.com/ajax/jquery.mobile/1.2.0/jquery.mobile-1.2.0.min.css" />
        <link rel="stylesheet" href="inc/sty/all_mbl.css" />
        
        <link rel= "http://fonts.googleapis.com/css?family=Roboto+Condensed:400,700"/>
        <link rel= "http://fonts.googleapis.com/css?family=Oswald"/>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
        <script src="https://ajax.aspnetcdn.com/ajax/jquery.mobile/1.2.0/jquery.mobile-1.2.0.min.js"></script>
    </head>
    <body>  
    <div data-role="page" id="home">
            <?php include('inc/estr/mbl_hdr.php'); ?>
            <div data-role="content">
               <?php include('ls_mbl_rd.php'); ?>
        	</div>
            <?php include('inc/estr/mbl_ftr.php'); ?>
    </div>
    
    <div data-role="page" id="planes">
            <?php include('inc/estr/mbl_hdr.php'); ?>
            <div data-role="content">
             Planes
        	</div>
            <?php include('inc/estr/mbl_ftr.php'); ?>
    </div>
    
    </body>
</html>