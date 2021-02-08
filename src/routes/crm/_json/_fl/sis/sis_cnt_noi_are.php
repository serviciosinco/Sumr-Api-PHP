<?php 
	try{

		$_tp = Php_Ls_Cln($_POST['t']);
		$_dt = Php_Ls_Cln($_POST['d']);
		$_est = Php_Ls_Cln($_POST['est']);

		$_id_are = Php_Ls_Cln($_POST['_id_are']);
		$_id_cntnoi = Php_Ls_Cln($_POST['_id_cntnoi']);

		$__Cl = new CRM_Cl(); 
		$__Cl->post = $_POST; 
		$__Cl->db = $_tp;
		
		$__Cl->cntnoi_id = $_id_cntnoi;
		$__Cl->are_id = $_id_are;
		

			
		if($_dt == 'are' && ($_est == 'in' || $_est == 'del')){

			if($_est == 'in'){
				$PrcDt = $__Cl->SisCntNoiAre_In();		
			}elseif($_est == 'del'){
				$PrcDt = $__Cl->SisCntNoiAre_Del();	
			}

			if($PrcDt->e == 'ok'){	
				$rsp['e'] = $PrcDt->e;
			}else{
				throw new Exception((ChckSESS_superadm()) ? "- ".$PrcDt->w : "");
			}
			
		}
		
		if(!isN($PrcDt->w_n)){ $rsp['w_n'] = $PrcDt->w_n; }
		
		$rsp['cnt']['noi']['are'] = $__Cl->SisCntNoiAre_Ls();
		
		
	}catch(Exception $e){
		$rsp['e'] = 'no';
		$rsp['w'] = TX_NSPPCSR .$e->getMessage();
	}
	
?>