<?php 

	try{
		
		$__Cl = new CRM_Cl();
		$__cntappl = Php_Ls_Cln($_POST['cnt_appl']);
		$__dtcl = Php_Ls_Cln($_POST['cl']);
		
		
		$__Cl->cntappl = $__cntappl;
		$__Cl->cl = $__dtcl;
		
		$rsp['cnt']['anx'] = $__Cl->CntAnx();
		
	}catch(Exception $e){
		
		$rsp['e'] = 'no';
		$rsp['w'] = TX_NSPPCSR.$e->getMessage();
		
	}

?>