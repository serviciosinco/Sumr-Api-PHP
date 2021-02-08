<?php 

	
	try{
		
		$_tp = Php_Ls_Cln($_POST['t']);
		$_dt = Php_Ls_Cln($_POST['d']);
		$_est = Php_Ls_Cln($_POST['est']);
		$_id_eml = Php_Ls_Cln($_POST['eml_enc']);
		$_id_us = Php_Ls_Cln($_POST['id_us']);
		$_id_are = Php_Ls_Cln($_POST['id_are']);
		
		$__Form = new CRM_Thrd();
		
		$__Form->id_eml = $_id_eml;
		$__Form->id_us = $_id_us;
		$__Form->id_are = $_id_are;
		$__Form->est = $_est;
	
	
		if(!isN($_id_eml) && !isN($_id_us) && $_dt == 'us'){
			
			if($_est == 'ok'){
				$PrcDt = $__Form->EmlUs_In();	
			}elseif($_est == 'del'){
				$PrcDt = $__Form->EmlUs_Del();		
			}
			
			if($PrcDt->e == 'ok'){	
				$rsp['e'] = $PrcDt->e;
			}else{
				$rsp['e'] = $PrcDt;	
			}
			
		}elseif(!isN($_id_eml) && !isN($_id_are) && $_dt == 'are'){
			
			if($_est == 'ok'){
				$PrcDt = $__Form->EmlAre_In();	
			}elseif($_est == 'del'){
				$PrcDt = $__Form->EmlAre_Del();		
			}

			if($PrcDt->e == 'ok'){	
				$rsp['e'] = $PrcDt->e;
			}else{
				$rsp['e'] = $PrcDt;	
			}
			
		}		
		
		$rsp['eml']['us'] = $__Form->EmlUsLs(['id'=>$_id_eml]);
		$rsp['eml']['are'] = $__Form->EmlAreLs(['id'=>$_id_eml]);
		
	}catch(Exception $e){
		$rsp['e'] = 'no';
		$rsp['w'] = TX_NSPPCSR .$e->getMessage();
	}
?>