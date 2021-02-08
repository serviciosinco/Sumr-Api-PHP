<?php 
	
	
	$___Gt = GtSisPrcDt(Php_Ls_Cln($_POST['__e']));	
	
	
	if($___Gt->tp == 1){ 
		$___cls = 'ok';
		$rsp['tt'] = TX_EX;
	}else{ 
		$___cls = 'no'; 
		$rsp['tt'] = TX_PRBLHST;
	}  
	
	$___tt = $___Gt->tt; 
	
	
	$rsp['e'] = $___cls;
	$rsp['sbt'] = $___tt;
	
?>