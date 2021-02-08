<?php

	$pth = '../../includes/';

	$__bdfrnt = 'ok';

	include($pth .'inc.php');

	$__pm_1 = PrmLnk('rtn', 1, 'ok');

?>
<!DOCTYPE html>
<html>
<head>
    <title>Privacy</title>
    <base href="<?php echo DMN_LEGAL ?>" target="_self">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
	<div class="_wrp">
    	<?php include('cnt/'.$__pm_1.'.php'); ?>
	</div>
</body>
<style>

	@import url('https://fonts.googleapis.com/css?family=Sunflower:300,500,700');
	@import url('https://fonts.googleapis.com/css?family=PT+Sans+Narrow:400,700');

	body{ font-family:'Sunflower', Tahoma; font-weight:300; font-size: 11px; background-color: #eceeef; }
	h1,h2,h3{ font-family:'PT Sans Narrow', Tahoma; text-transform: uppercase; }
	h1{ text-align:center; margin: 40px 0 30px; font-size: 30px; font-weight: 400; color: #818689; }
	p{ text-align: justify; }
	figure{ width:200px; margin-left: auto; margin-right: auto; text-align: center; }
	figure img{ width: 140px; margin-left: auto; margin-right: auto; opacity: 0.4; }

	._wrp header{ display: flex; margin: 20px 0; }
	._wrp header figure{ width: 30%; border-right: 1px solid #b6b7b8; padding: 0; }
	._wrp header h1{ width: 70%; text-align: right; padding: 0; margin: 0; line-height: 30px; padding-top: 20px; }

	._wrp ._cnt{ background-color: #fff; border-radius:8px; -moz-border-radius:8px; -webkit-border-radius:8px; padding:40px 50px; border:none; }

	@media only screen and (min-width: 768px) {
	    /* tablets and desktop */

	    ._wrp{ width: 50%; margin-left: auto; margin-right: auto; }
	    ._wrp header{ width: 100%; }
	}

	@media only screen and (max-width: 767px) {
	    /* phones */
	}

	@media only screen and (max-width: 767px) and (orientation: portrait) {
	    /* portrait phones */
	}

</style>
</html>
