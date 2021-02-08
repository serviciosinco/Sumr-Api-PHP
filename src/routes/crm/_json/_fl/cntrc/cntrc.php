<?php 
	
	try{
		
		
	
		$_tp = Php_Ls_Cln($_POST['t']);
		$_dt = Php_Ls_Cln($_POST['d']);
		$_cntrc = Php_Ls_Cln($_POST['_id_cntrc']);
		$_cntrc_sht = Php_Ls_Cln($_POST['_id_sht']);
		$__ord = Php_Ls_Cln($_POST['_ord']);
		
		$__Cl = new CRM_Cl(); 
		$__Cl->cntrc = $_cntrc;
		$__Cl->cntrc_sht = $_cntrc_sht;
		
		if(!isN($_dt) && $_dt == '_est_prnt'){
			
			$_prnt = Php_Ls_Cln($_POST['_id_prnt']);
			$_est = Php_Ls_Cln($_POST['_id_est']);
			
			$__Cl->id_prnt = $_prnt;
			$__Cl->id_est = $_est;
			
			$Prcs = $__Cl->CntPrntEst_Chk();	

			if($Prcs->tot >= 1){
				$Prc = $__Cl->CntPrntEst_Upd();	
			}else{
				$Prc = $__Cl->CntPrntEst_In();	
			}
			
			$rsp['cnt_prnt'] = $Prc;
			
		}
		
		if(!isN($__ord)){
			$__Cl->ord = $__ord;
			$Prc = $__Cl->CntrcSht_Ord();
			$rsp['ord'] = $Prc;	
		}
		
		if(!isN($_dt) && $_dt == 'frst'){
			$rsp['cntr']['frst'] = $__Cl->CntrcFrst_Ls();	
		}
		
		if(!isN($_dt) && $_dt == 'edt'){
			$_sgm_vle = Php_Ls_Cln($_POST['_sgm_vle']);
			$__Cl->sgm_vle = $_sgm_vle;
			
			$Prc = $__Cl->CntrcSht_Upd();	
			
			if($Prc->e == 'ok'){
				$rsp['rsl'] = 'ok';	
			}else{
				$rsp['rsl'] = $Prc;	
			}
				
		}
		
		if(!isN($_dt) && $_dt == 'eli'){
			
			$Prc = $__Cl->CntrcSht_Eli();	
			
			if($Prc->e == 'ok'){
				$rsp['e'] = 'ok';
				$rsp['cntr']['frst'] = $__Cl->CntrcFrst_Ls();		
			}else{
				$rsp['e'] = $Prc;	
			}
				
		}
		
		if(!isN($_dt) && $_dt == 'new'){ 
			
			$Prc = $__Cl->CntrcSht_New();	
			
			if($Prc->e == 'ok'){
				$rsp['rsl'] = 'ok';
				$__Cl->cntrc_sht = $Prc->enc;
				$rsp['sht'] = $__Cl->CntrcSht_Html();		
			}else{
				$rsp['rsl'] = $Prc;	
			}
				
		}
		
		if(!isN($_cntrc_sht)){
			$rsp['sht'] = $__Cl->CntrcSht_Html();		
		}
		
		
		
		$rsp['cntr']['sht'] = $__Cl->CntrcSht_Ls();	
		
		

	}catch(Exception $e){
		$rsp['e'] = 'no';
		$rsp['w'] = TX_NSPPCSR.$e->getMessage();
	}
	
?>