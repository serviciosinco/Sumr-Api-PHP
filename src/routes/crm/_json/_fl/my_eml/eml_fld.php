<?php 
	
//---------------------- VARIABLES GET ----------------------//
	
	$rsp['e'] = 'no';	

	$__inbox_eml = Php_Ls_Cln($_POST['_eml']);
	$__inbox_fld = Php_Ls_Cln($_POST['_fld']);
	$__inbox_fenc = Php_Ls_Cln($_POST['_fenc']);
	$__inbox_vle = Php_Ls_Cln($_POST['_vle']);
	
	
	if($__inbox_fenc == enCad($__inbox_fld)){
		
		if($__inbox_fld == 'eml_pss'){ $__pss = 'ok'; }
		
		$__Eml = new CRM_Eml();
		$__Prc = $__Eml->Upd_Eml_Fld([ 
							't'=>'eml', 
							'id'=>$__inbox_eml,
							'fld'=>[[
								'k'=>$__inbox_fld,
								'v'=>$__inbox_vle,
								'pss'=>$__pss 
							]]
						]);
		
		$rsp['sve'] = $__Prc;
		
		if($__Prc->e == 'ok'){
			$rsp['sve'] = $__Prc;
		}
	}
//---------------------- SELECCIONA CORREO ----------------------//		



?>