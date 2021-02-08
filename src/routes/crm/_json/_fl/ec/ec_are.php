<?php 
	try{

		$_tp = Php_Ls_Cln($_POST['t']);
		$_dt = Php_Ls_Cln($_POST['d']);
		$_est = Php_Ls_Cln($_POST['est']);

		$_id_are = Php_Ls_Cln($_POST['_id_are']);
		$_id_est = Php_Ls_Cln($_POST['_id_est']);

		$__Cl = new CRM_Cl(); 
		$__Cl->post = $_POST; 
		$__Cl->db = $_tp;
		
		$__Cl->ec_id = $_id_est;
		$__Cl->mdl_id = $_id_are;
		
			
		if($_dt == 'are' && ($_est == 'in' || $_est == 'del')){

			if($_est == 'in'){
				$PrcDt = $__Cl->EcTp_In();		
			}elseif($_est == 'del'){
				$PrcDt = $__Cl->EcTp_Del();	
			}

			if($PrcDt->e == 'ok'){	
				$rsp['e'] = $PrcDt->e;
			}else{
				throw new Exception((ChckSESS_superadm()) ? "- ".$PrcDt->w : "");
			}
			
		}elseif(!isN($_dt) && $_dt == 'new_est'){
			
			$__Cl->cntest_tt = Php_Ls_Cln($_POST['siscntest_tt']);
			$__Cl->cntest_tp = Php_Ls_Cln($_POST['siscntest_tp']);
			$__Cl->cntest_clr_bck = Php_Ls_Cln($_POST['siscntest_clr_bck']);
			$PrcDt = $__Cl->ClCntEst_In(); 	
			
			if($PrcDt->e == 'ok'){	
				$rsp['e'] = $PrcDt->e;
			}else{
				$rsp['w_n'] = $PrcDt->w_n;
				throw new Exception((ChckSESS_superadm()) ? "- ".$PrcDt->w : "");
			}
			
		}
		
		if(!isN($PrcDt->w_n)){ $rsp['w_n'] = $PrcDt->w_n; }
		
		$rsp['cl']['ec']['are'] = $__Cl->EcTp_Ls();
		
		
	}catch(Exception $e){
		$rsp['e'] = 'no';
		$rsp['w'] = TX_NSPPCSR .$e->getMessage();
	}
	
?>