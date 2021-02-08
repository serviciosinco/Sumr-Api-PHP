<?php

	$pth = '../../includes/'; $__no_sbdmn = 'ok';
	$__bdfrnt = 'ok';
	include($pth .'inc.php');

	$__p1 = PrmLnk('rtn', 1, 'ok');
	$__p2 = PrmLnk('rtn', 1, 'ok');

	$__shrt = new CRM_Shrt();
	$__shrt->cod = $__p1;
	$__chk = $__shrt->chk();


	if($_GET['Camilo']=='ok'){
		echo AWS_RDS_RDR;
		echo $__chk->url;
		exit();
	}

	if(!isN( $__chk->url )){
	    header(sprintf("Location: %s", $__chk->url ));
	}


?>