<?php

	//sleep(60);

	try{ 

		$rsp['e'] = 'ok';
		$rsp['v']['js'] = E_TAG;
		$rsp['v']['css'] = E_TAG;
		
		if(defined('SISUS_ID') && !isN( SISUS_ID )){

			$_us = GtUsDt(SISUS_ID,'',[ 'prvt'=>'ok', 'cl_no'=>'ok' ]);
			$rsp['us']['enc'] = $_us->enc; 
			$rsp['us']['gnr'] = $_us->gnr;
			$rsp['us']['img'] = $_us->img; 
			$rsp['us']['nivel'] = $_us->lvl; 

			if(ChckSESS_superadm()){
				$rsp['spr'] = 'ok';
			}else{
				$rsp['spr'] = 'no';
			}
		}

		if(defined('SISUS_SES_ID') && !isN( SISUS_SES_ID )){
			$rsp['ses']['id'] = SISUS_SES_ID;
		}

		if ((isset($_SESSION[DB_CL_ENC_SES.MM_ADM])) && $_SESSION[DB_CL_ENC_SES.MM_ACNT] === DB_CL_ENC){
			$rsp['ses']['on'] = 'ok';	
		}else{
			$rsp['ses']['on'] = 'no';
		}

	}catch(Exception $e){

		$rsp['e'] = 'no';

	}
	
?>