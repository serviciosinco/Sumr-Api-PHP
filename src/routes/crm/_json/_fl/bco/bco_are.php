<?php 
	
	
	try{
		

		$_tp = Php_Ls_Cln($_POST['t']);
		$_dt = Php_Ls_Cln($_POST['d']);
		$_est = Php_Ls_Cln($_POST['est']);

		$_id_are = Php_Ls_Cln($_POST['_id_are']);
		$_id_bco = Php_Ls_Cln($_POST['_id_bco']);
		$_id_tp = Php_Ls_Cln($_POST['_id_tp']);

		$__Cl = new CRM_Bco(); 
		$__Cl->post = $_POST; 
		$__Cl->db = $_tp;
		
		$__Cl->bco_id = $_id_bco;
		$__Cl->are_id = $_id_are;

		if(!isN($_id_tp)){
			$__Cl->bco_tp = $_id_tp;	
		}
		
			
		if($_dt == 'are' && ($_est == 'in' || $_est == 'del')){

			if($_est == 'in'){
				$PrcDt = $__Cl->BcoAre_In();		
			}elseif($_est == 'del'){
				$PrcDt = $__Cl->BcoAre_Del();	
			}

			if($PrcDt->e == 'ok'){	
				$rsp['e'] = $PrcDt->e;
			}else{
				throw new Exception((ChckSESS_superadm()) ? "- ".$PrcDt->w : "");
			}
			
		}
		
		if(!isN($PrcDt->w_n)){ $rsp['w_n'] = $PrcDt->w_n; }
		
		$rsp['bco']['are'] = $__Cl->BcoAre_Ls();
		
		
	}catch(Exception $e){
		$rsp['e'] = 'no';
		$rsp['w'] = TX_NSPPCSR .$e->getMessage();
	}
	
?>