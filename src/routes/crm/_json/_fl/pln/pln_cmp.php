<?php 
	
	
	try{
		
		$_tp = Php_Ls_Cln($_POST['t']);
		$_dt = Php_Ls_Cln($_POST['d']);
		$__tp = Php_Ls_Cln($_POST['tp']);
		$_cmp = Php_Ls_Cln($_POST['_id_cmp']);
		$_est = Php_Ls_Cln($_POST['est']);
		$_tx = Php_Ls_Cln($_POST['tx']);
		
		$__Cl = new CRM_Cmp(); 
		$__Cl->post = $_POST; 
		$__Cl->db = $_tp;
		$__Cl->id_cmp = $_cmp;
		
		if($_est == 'in' && $__tp = 'pln_cmp_kyw'){
			
			$__Cl->kyw_tt = $_dt;
			
			$PrcDt = $__Cl->PlnCmpKyw_In();
			
			$rsp['prc'] = $PrcDt;
					
		}elseif($_est == 'eli' && $__tp = 'pln_cmp_kyw'){
			
			$__Cl->enc = $_dt;
			
			$PrcDt = $__Cl->PlnCmpKyw_Eli();
			
			$rsp['prc'] = $PrcDt;
					
		}elseif($_est == 'edt' && $__tp = 'pln_cmp_kyw'){
			
			$__Cl->enc = $_dt;
			$__Cl->tx = $_tx;
			
			$PrcDt = $__Cl->PlnCmpKyw_Edt();
			
			$rsp['prc'] = $PrcDt;
					
		}elseif($_est == 'sch' && $__tp = 'pln_cmp_kyw'){

			$__Cl->tx = $_tx;
			
			$PrcDt = $__Cl->PlnCmpKyw_Sch();
			
			$rsp['sch'] = $PrcDt;
					
		}elseif($_est == 'in_onl' && $__tp = 'pln_cmp_kyw'){

			$_key_rel= Php_Ls_Cln($_POST['key_rel']);
			$__Cl->key_rel = $_key_rel;
			
			$PrcDt = $__Cl->PlnCmpKywMod_In();
			
			$rsp['prc'] = $PrcDt;
					
		}
 
		$rsp['cmp'] = $__Cl->PlnCmpLs();
		
	}catch(Exception $e){
		$rsp['e'] = 'no';
		$rsp['w'] = TX_NSPPCSR.$e->getMessage();
	}
	
?>