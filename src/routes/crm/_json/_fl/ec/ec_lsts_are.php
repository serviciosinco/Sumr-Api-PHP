<?php 
	try{

		$_tp = Php_Ls_Cln($_POST['t']);
		$_dt = Php_Ls_Cln($_POST['d']);
		$_est = Php_Ls_Cln($_POST['est']);

		$_lsts_enc = Php_Ls_Cln($_POST['_lsts_enc']);
		$_id_are = Php_Ls_Cln($_POST['_id_are']);

		$__Cl = new CRM_Cl(); 
		$__Cl->post = $_POST; 
		$__Cl->db = $_tp;
		
		$__Cl->ec_lsts_id = $_lsts_enc;
		$__Cl->id_are = $_id_are;
		
			
		if($_dt == 'are'){

			if($_est == 'ok'){
				$PrcDt = $__Cl->EcLstsAre_In();		
			}elseif($_est == 'del'){
				$PrcDt = $__Cl->EcLstsAre_Del();	
			}

			if($PrcDt->e == 'ok'){	
				$rsp['e'] = $PrcDt->e;
			}else{
				throw new Exception((ChckSESS_superadm()) ? "- ".$PrcDt->w : "");
			}
			
		}
		
		if(!isN($PrcDt->w_n)){ $rsp['w_n'] = $PrcDt->w_n; }
		
		$rsp['ec']['lsts']['are'] = $__Cl->EcLstsAre_Ls();
		
	}catch(Exception $e){
		$rsp['e'] = 'no';
		$rsp['w'] = TX_NSPPCSR .$e->getMessage();
	}
	
?>