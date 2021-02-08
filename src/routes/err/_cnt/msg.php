<!DOCTYPE html>
<html>
<head>
    <title>404 Error | SUMR</title>
    <link rel="stylesheet" href="<?php echo DMN_CSS ?>sb/err/main.css">
    <link rel="stylesheet" href="<?php echo DMN_CSS ?>sb/err/d2.css">
    <base href="<?php echo DMN_ERR; ?>" target="_self">
</head>
<body class="permission_denied">
    <div class="denied__wrapper">  
        <div class="box">
            <?php 
                if(!isN($__p1_g)){ 
                    include(DIR_CNT.'msg/'.$__p1_g.'.php'); 
                }elseif(!isN($__p1_o)){ 
                    include(DIR_CNT.'msg/'.$__p1_o.'.php'); 
                }
            ?>
		</div>
		<div id="sumr" style="background-image: url(<?php echo DMN_IMG_ESTR.LOGO_MAIN; ?>); "></div>
    </div>
</body>
</html>