<?php 
	
	$__i = Php_Ls_Cln($_POST['__emp']);
	$__w = Php_Ls_Cln($_POST['__emp_web']);
	$_dt_emp = GtEmpDt($__i/*, array( 'fll'=>'ok' )*/);
	
	if($_dt_emp->id != NULL){ 
		
		if($__w != ''){ $__web = $__w; }else{ $__web = $_dt_emp->web; }
		
		$__Fll = new CRM_Fll();
		$__Fll->c_dmn = $__web;
		$__Fll->sve();
									
									
		$_dt_emp = GtEmpDt($__i);
		
		$rsp['e'] = 'ok';
		$rsp['img']['s_200'] = $_dt_emp->logo_s->th_200;
		$rsp['img']['s_50'] = $_dt_emp->logo_s->th_50;
		
	}
?>