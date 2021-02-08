<?php

	$_us = _GetPost('user');
	$_pass = enCad(ctjTx(_GetPost('pass'),'in'));
	$_dvc = _GetPost('dvc');

	$GtUsDt = GtUsDt($_us, "usr", ["pass"=>$_pass, 'cl_dtl'=>[ 'tag'=>'ok'  ] ]);
	
	if(_GetPost('tp') != "sess"){
	
		if( $GtUsDt->e == 'ok' ){
			
			$__massive = new API_CRM_Massive();
			
			if(!isN( $GtUsDt->msv_usr )){
				$__lgin = $__massive->us_actv([ 'us'=>$GtUsDt->msv_usr, 'actv'=>'on' ]);
			}

			$rsp["e"] = "ok";
			$rsp["us"] = $GtUsDt;
			
		}else{
			$rsp["e"] = "no";
			$rsp["w"] = "Usuario o contraseña incorrecta";
		}
	
	}
	
?>