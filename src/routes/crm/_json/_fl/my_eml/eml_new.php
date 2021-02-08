<?php 
	
//---------------------- VARIABLES GET ----------------------//

	$rsp['e'] = 'no';	

	$__eml_nm = Php_Ls_Cln($_POST['_nm']);
	$__eml_eml = Php_Ls_Cln($_POST['_eml']);
	$__eml_tp = Php_Ls_Cln($_POST['_tpe']);
	$__eml_avtr = Php_Ls_Cln($_POST['_avtr']);
	$__eml_us = Php_Ls_Cln($_POST['_us']);
	
	
	if( !isN($__eml_eml) ){
		
		
		$__emltp = __LsDt([ 'k'=>'sis_eml', 'id'=>$__eml_tp, 'tp'=>'enc' ]);
		$__avtr = __LsDt([ 'k'=>'sis_avtrs', 'id'=>$__eml_avtr, 'tp'=>'enc' ]);
		$__cl = GtClDt(DB_CL_ENC, 'enc');
		$__us = GtUsDt($__eml_us, 'enc');
			
			
		$__Eml = new CRM_Eml();
		$__Eml->__t = 'eml';
        $__Eml->eml_eml = $__eml_eml;
        $__Eml->eml_nm = $__eml_nm;
        $__Eml->eml_tp = $__emltp->d->id;
        $__Eml->eml_avtr = $__avtr->d->id;
        $__Eml->eml_us = $__us->id;
        $__Eml->eml_cl = $__cl->id;
        
        $__Prc = $__Eml->In();
		
		$rsp['sve'] = $__Prc;
		
		if($__Prc->e == 'ok'){
			$rsp['sve'] = $__Prc;
		}
		
	}
//---------------------- SELECCIONA CORREO ----------------------//		



?>