<?php 
	try{

		$_tp = Php_Ls_Cln($_POST['t']);
		$_dt = Php_Ls_Cln($_POST['d']);
		$_est = Php_Ls_Cln($_POST['est']);

		$_id_eccmpg = Php_Ls_Cln($_POST['_id_eccmpg']);
		$_id_est = Php_Ls_Cln($_POST['_id_sgm']);

		$__Cl = new CRM_Cl(); 
		$__Cl->post = $_POST; 
		$__Cl->db = $_tp;
		
		$__Cl->ec_id = $_id_eccmpg;
		$__Cl->sgm_id = $_id_est;
		
			
		if($_dt == 'ec_sgm' && ($_est == 'in' || $_est == 'del')){

			if($_est == 'in'){
				$PrcDt = $__Cl->EcSgm_In();		
			}elseif($_est == 'del'){
				$PrcDt = $__Cl->EcSgm_Del();	
			}

			if($PrcDt->e == 'ok'){	
				$rsp['e'] = $PrcDt->e;
			}else{
				throw new Exception((ChckSESS_superadm()) ? "- ".$PrcDt->w : "");
			}
			
		}

		if(!isN($PrcDt->w_n)){ $rsp['w_n'] = $PrcDt->w_n; }
		
		$rsp['cl']['ec']['sgm'] = $__Cl->EcSgm_Ls();
		
		
	}catch(Exception $e){
		$rsp['e'] = 'no';
		$rsp['w'] = TX_NSPPCSR .$e->getMessage();
	}
	
?>