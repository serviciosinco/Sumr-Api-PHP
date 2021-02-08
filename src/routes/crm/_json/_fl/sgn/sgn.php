<?php 	
	$__ec = Php_Ls_Cln($_GET['__sgn_i']);
	$__dtec = GtSgnDt($__ec, 'id');
			
	$rsp['tt'] = $__dtec->tt;
	$rsp['enc'] = $__dtec->enc;
?>