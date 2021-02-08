<?php 

	
	try{
		
		$_tp = Php_Ls_Cln($_POST['t']);
		$_dt = Php_Ls_Cln($_POST['d']);
		$_est = Php_Ls_Cln($_POST['est']);
		$_id_eml = Php_Ls_Cln($_POST['_id_eml']);
		$_id_cl = Php_Ls_Cln($_POST['_id_cl']);
		
		$__Form = new CRM_Thrd();
		
		$__Form->id_eml = $_id_eml;
		$__Form->id_cl = $_id_cl;
		$__Form->est = $_est;
		
	
		if(!isN($_id_eml) && !isN($_id_cl) && $_dt == 'cl'){
			
			$__Cl->id_cl = $_id_cl;
			
			if($_est == 'in'){
				$PrcDt = $__Form->ClEml_In();	
			}elseif($_est == 'del'){
				$PrcDt = $__Form->ClEml_Del();		
			}
			
			if($PrcDt->e == 'ok'){	
				$rsp['e'] = $PrcDt->e;
			}else{
				$rsp['ed'] = $PrcDt;	
			}
			
		}elseif( $_dt == 'cleml_dft'){

			$_chk = $__Form->Chk_ClEml(['eml'=>$_id_eml, 'cl'=>$_id_cl]);

			if($_chk->e == 'ok'){

				$__Form->id_cleml = $_chk->id;
				if($_est == 'in'){
					$__Form->cleml_dft = 1;
				}elseif($_est == 'del'){
					$__Form->cleml_dft = 2;
				}

				$PrcDt = $__Form->ClEml_Upd();	

				if($PrcDt->e == 'ok'){	
					$rsp['e'] = $PrcDt->e;
				}else{
					$rsp['ed'] = $PrcDt;	
				}
			}
			
			 

		}
		
		$rsp['cl'] = $__Form->ClEmlLs(['id'=>$_id_eml]);
		
	}catch(Exception $e){
		$rsp['e'] = 'no';
		$rsp['w'] = TX_NSPPCSR .$e->getMessage();
	}
?>