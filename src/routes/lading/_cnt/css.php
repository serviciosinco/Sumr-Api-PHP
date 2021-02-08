<?php 
	
	
	//---------------- Get Parameters ----------------//
	
		$__pm_2 = PrmLnk('rtn', 2, 'ok');
		$__mod = Php_Ls_Cln($_GET['_mod']);
	
	//---------------- Get Details ----------------//
	
		$__lnd_dt = GtLndDt([ 'id'=>$__pm_2, 't'=>'enc' ]);
	
	//---------------- Process ----------------//
	
	
	Hdr_CSS(); 
	ob_start("cmpr_css"); 

	if(!isN($__mod) && $__mod == 'ok'){ include('css/mod.css'); }

	echo $__lnd_dt->css;
	
	
	ob_end_flush(); 


?>