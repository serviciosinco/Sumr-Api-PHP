<?php 


	//-------------------- Parametros POST  --------------------/
	
		
		$__cmpg = Php_Ls_Cln($_POST['cmpg']);	
		$__eml= Php_Ls_Cln($_POST['eml']);	
		$__nm = Php_Ls_Cln($_POST['nm']);	
	
	
	//-------------------- Ingreso de Registro  --------------------/
	
	
	if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdEcCmpgTest")) {
			
			
			//-------------------- Detalles de Pushmail  --------------------/
			
				
				$__cmpg_dt = GtEcCmpgDt([ 't'=>'enc', 'id'=>$__cmpg, 'e'=>'ok', 'ec' => 'ok' ]);
				
			
			//-------------------- DEtalles de CNT  --------------------/
			
				$__CntIn = new CRM_Cnt();
				$__CntIn->cnt_eml = $__eml;
				$__CntIn->cnt_nm = $__nm;
				$__Cnt = $__CntIn->_Cnt();
				
			//-------------------- Ingreso Envio  --------------------/
						
				if(!isN($__Cnt->d->id) && !isN($__cmpg_dt->id)){
			
					$_ec_snd = new API_CRM_ec();
												
					$_ec_snd->snd_f = SIS_F;
					$_ec_snd->snd_h = SIS_H2;
					$_ec_snd->snd_ec = $__cmpg_dt->ec->id;
					$_ec_snd->snd_eml = $__eml;
					$_ec_snd->snd_cnt = $__Cnt->i;
					$_ec_snd->snd_us = SISUS_ID;
					$_ec_snd->snd_cmpg = $__cmpg_dt->id;
					$_ec_snd->snd_test = 'ok';
					$_snd = $_ec_snd->_SndEc([ 't'=>'cmpg' ]);
					
					$rsp['snd'] = $_snd;
					$rsp['u_o'] = __AutoRUN([ 'cl'=>'ok', 't'=>'snd' ]);	
					
					if($_snd->e == 'ok'){
						$rsp['e'] = 'ok';
						$rsp['m'] = 1;	
					}else{
						$rsp['e'] = 'no';
						$rsp['m'] = 2;
						$rsp['msss'] = $__cmpg_dt;
					}
					
				}else{
					
					$rsp['e'] = 'no';
					$rsp['m'] = 2;
					
				}
			
			
	}

	
?>