<?php 
	
	
	try{
		
		$_tp = Php_Ls_Cln($_POST['t']);
		$_tp2 = Php_Ls_Cln($_POST['t2']);
		$_dt = Php_Ls_Cln($_POST['d']);
		$_est = Php_Ls_Cln($_POST['est']);
		
		$_id_tpc = Php_Ls_Cln($_POST['_id_tpc']);
		$_id_cl= Php_Ls_Cln($_POST['_id_cl']);

		$__Cl = new CRM_Cl(); 
		$__Cl->post = $_POST; 
		$__Cl->db = $_tp;
		$__Cl->id_tpc =$_id_tpc;

		if(!isN($_id_tpc) && !isN($_id_cl) && $_dt == 'cl'){
			
			$__Cl->id_cl = $_id_cl;
			
			if($_est == 'in'){
				$PrcDt = $__Cl->TpcCl_In();	
			}elseif($_est == 'del'){
				$PrcDt = $__Cl->TpcCl_Del();	
			}
			
			
			if($PrcDt->e == 'ok'){	
				$rsp['e'] = $PrcDt->e;
			}else{
				$rsp['e'] = $PrcDt;	
			}
			
		}
		
		if(!isN($PrcDt->w_n)){ $rsp['w_n'] = $PrcDt->w_n; }
		
		$rsp['tpc']['cl'] = $__Cl->TpcCl_Ls();
		
	}catch(Exception $e){
		$rsp['e'] = 'no';
		$rsp['w'] = TX_NSPPCSR .$e->getMessage();
	}
	
?>