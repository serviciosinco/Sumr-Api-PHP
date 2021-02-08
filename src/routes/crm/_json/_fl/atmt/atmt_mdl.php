<?php
	try{
		
		$_tp = Php_Ls_Cln($_POST['t']);
		$_dt = Php_Ls_Cln($_POST['d']);
		$_est = Php_Ls_Cln($_POST['est']);
		$_atmt_enc = Php_Ls_Cln($_POST['_atmt_enc']);
		$_mdl_enc = Php_Ls_Cln($_POST['_mdl_enc']);
		
		$__Atmt = new CRM_Atmt(); 
		$__Atmt->atmt_enc = $_atmt_enc;
		$__Atmt->mdl_enc = $_mdl_enc;
		$__Atmt->bd = DB_PRFX_CL."{$__sbdmn}.";
		
		
		if($_dt == "mdl"){
			if($_est == "in"){
				$PrcDt = $__Atmt->_Mdl_In();
			}else if($_est == "del"){
				$PrcDt = $__Atmt->_Mdl_Eli();
			}
			
		}
		
		if($PrcDt->e == 'ok'){	
			$rsp['e'] = $PrcDt->e;
		}
		
		if(!isN($PrcDt->w_n)){ $rsp['w_n'] = $PrcDt->w_n; }
		
		$rsp['atmt_mdl']['mdl'] = $__Atmt->_Mdl_Ls();
			
	}catch(Exception $e){
		
		$rsp['e'] = 'no';
		$rsp['w'] = TX_NSPPCSR .$e->getMessage();
	
	} 
?>