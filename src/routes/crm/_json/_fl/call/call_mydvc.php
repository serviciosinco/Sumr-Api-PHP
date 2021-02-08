<?php 

	$___id = Php_Ls_Cln($_POST['__sid']);
	$___p = Php_Ls_Cln($_POST['__p']);

	
	if($___p == 'dt'){
		
		$__CallIn = new CRM_Call();
		$__CallDt = $__CallIn->ChckCall( ['sid'=>$___id] );
		
		$rsp['call'] = $__CallDt;
		
	}else{
		
		$rsp['e'] = 'no';
		
	}
	
?>
