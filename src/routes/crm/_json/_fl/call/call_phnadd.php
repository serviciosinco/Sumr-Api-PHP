<?php 
	
	
	$___id = Php_Ls_Cln($_POST['__id']);
	$___p = Php_Ls_Cln($_POST['__p']);

	
	if($___p == 'dt'){
		
		$_ustel = GtUsTelDt(['id'=>$___id]);
		
		if($_ustel->est == 'ok'){
			$rsp['e'] = 'ok';
			$rsp['tel']['est'] = 'ok';
		}else{
			$rsp['e'] = 'no';
			$rsp['tel']['est'] = 'no';
		}
	
	}else{
		
		$__call = _Call_PhnAdd(['id'=>$___id]);
		
		//$rsp['tmp'] = $__call;
		$rsp['api'] = $__call->api;
		
		if($__call->e == 'ok'){
			$rsp['e'] = 'ok';
			$rsp['cod'] = $__call->code;
		}else{
			$rsp['e'] = 'no';
		}
	}
	
?>
