<?php 
	
	
	//---------------- Get Parameters ----------------//
	
		$__pm_2 = PrmLnk('rtn', 2, 'ok');
		$__mod = Php_Ls_Cln($_GET['_mod']);
	
	//---------------- Get Details ----------------//
	
		$__lnd_dt = GtLndDt([ 'id'=>$__pm_2, 't'=>'enc' ]);
	
	//---------------- Process ----------------//
	
	
	Hdr_JS(); 
	ob_start("cmpr_js"); 

	if(!isN($__mod) && $__mod == 'ok'){ include('js/mod.js'); }

	echo $__lnd_dt->js;
	
	
	ob_end_flush(); 


?>