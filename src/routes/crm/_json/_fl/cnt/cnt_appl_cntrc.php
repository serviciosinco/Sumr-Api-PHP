<?php 
	try{

		$_tp = Php_Ls_Cln($_POST['t']);
		$_dt = Php_Ls_Cln($_POST['d']);
		$_est = Php_Ls_Cln($_POST['est']);

		$_cntappl_enc = Php_Ls_Cln($_POST['_cntappl_enc']);
		$_cntrc_enc= Php_Ls_Cln($_POST['_cntrc_enc']);

		$__Cl = new CRM_Cl(); 
		$__Cl->post = $_POST; 
		$__Cl->db = $_tp;
		
		$__Cl->cntappl = $_cntappl_enc;
		$__Cl->cntrc = $_cntrc_enc;
		
			
		if($_dt == 'appl' && ($_est == 'in' || $_est == 'del')){

			if($_est == 'in'){
				$PrcDt = $__Cl->CntApplCntrc_In();		
			}elseif($_est == 'del'){
				$PrcDt = $__Cl->CntApplCntrc_Del();	
			}

			if($PrcDt->e == 'ok'){	
				$rsp['e'] = $PrcDt->e;
			}else{
				$rsp['w'] = $PrcDt;
				throw new Exception((ChckSESS_superadm()) ? "- ".$PrcDt->w : "");
			}
			
		}
		
		if($_dt == 'view'){

			$PrcDt = $__Cl->CntApplCntrc_Dt();	

			if($PrcDt->e == 'ok'){	
				$rsp['e'] = $PrcDt->e;
				$rsp['view'] = $PrcDt;
			}else{
				$rsp['w'] = $PrcDt;
				throw new Exception((ChckSESS_superadm()) ? "- ".$PrcDt->w : "");
			}
			
		}else{
			if(!isN($PrcDt->w_n)){ $rsp['w_n'] = $PrcDt; }		
		}
		
		$rsp['cnt']['appl'] = $__Cl->CntApplCntrc_Ls();
		
		
	}catch(Exception $e){
		$rsp['e'] = 'no';
		$rsp['w'] = TX_NSPPCSR .$e->getMessage();
	}
	
?>