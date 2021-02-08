<?php 
		
	$__ec = Php_Ls_Cln($_GET['__ec_i']);
	$__tp = Php_Ls_Cln($_POST['_tp']);
	$__lst = Php_Ls_Cln($_POST['_lst']);
	
	
	if($__t == 'snd_ec'){	
		
		if(!isN($__lst)){ $__ec_dt = GtEcDt($__lst, 'enc'); }

		$rsp = GtEcLs([ /*'tp'=>$__tp,*/ 'lst'=>$__ec_dt->id ]);
		
	}else{		
		
		$__dtec = GtEcDt($__ec);
		
		$rsp['tt'] = $__dtec->tt;
		$rsp['enc'] = $__dtec->enc;
	
	}
	
?>