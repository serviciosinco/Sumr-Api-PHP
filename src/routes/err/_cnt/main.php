<!DOCTYPE html>
<html>
<head>
    <title>404 Error | SUMR</title>
    <link rel="stylesheet" href="<?php echo DMN_CSS ?>sb/err/main.css">
    <base href="<?php echo DMN_ERR; ?>" target="_self">
</head>

<body class="permission_denied">
    <div id="particles-js"></div>

    <div class="denied__wrapper">
        <?php 
			if(!isN($__p1_o)){ include(DIR_CNT.'msg/'.$__p1_o.'.php'); }
		?>
        <div id="astronaut" style="background-image: url(<?php echo DMN_IMG_ESTR_ERR; ?>astron.svg); "></div>
        <div id="planet" style="background-image: url(<?php echo DMN_IMG_ESTR_ERR; ?>moon.svg); "></div>
		<button class="denied__link">Go Home</button>
		<div id="sumr" style="background-image: url(<?php echo DMN_IMG_ESTR ?>logo_gray.svg);?>); "></div>
    </div>
</body>
</html>
<script src="<?php echo DMN_JS ?>particles/particles.js"></script>
<script src="<?php echo DMN_JS ?>particles/main.js"></script>