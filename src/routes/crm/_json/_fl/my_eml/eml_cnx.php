<?php 
	
//---------------------- VARIABLES GET ----------------------//

	$__inbox_eml = Php_Ls_Cln($_POST['_eml']);
		
	$__eml_dt = GtEmlDt([ 'id'=>$__inbox_eml, 't'=>'enc', 'pss'=>'ok' ]);

	if($__eml_dt->e == 'ok'){
		
		$rsp['e'] = 'ok';
		
		$__Eml = new CRM_Imap();
		$__Mic = new CRM_Microsoft();
		
		if($__eml_dt->tp->id == _Cns('ID_SISEML_OFC')){
				
			if(!isN($__eml_dt->attr->access_token)){ 
				
				$__Mic->access_token = $__eml_dt->attr->access_token;
				$__Mic->refresh_token = $__eml_dt->attr->refresh_token;
				
				$__prfl = json_decode( $__Mic->_Rqu([ 't'=>'me' ]), true); 
				
				if(!isN($__prfl['displayName'])) {
					$__Cnc['e'] = 'ok'; 
					$__Prc = $__Eml->Upd_Eml_Fld([ 
											't'=>'eml', 
											'id'=>$__eml_dt->enc, 
											'fld'=>[[
												'k'=>'eml_onl',
												'v'=>1
											]],
											'vle'=>1 
										]);
				}else{
					$__Cnc['e'] = 'no';
					$__Prc = $__Eml->Upd_Eml_Fld([ 
										't'=>'eml', 
										'id'=>$__eml_dt->enc, 
										'fld'=>[[
											'k'=>'eml_onl',
											'v'=>2
										]],
										'vle'=>2 
									]);
				}
			
			}
				
		}elseif($__eml_dt->tp->id == _Cns('ID_SISEML_IMAP')){
			
			$__Eml->c_eml = $__eml_dt->id;
			$__Chck = $__Eml->_cnct();
			
			if($__Chck->e == 'ok'){
				$__Cnc['e'] = 'ok';
				$__Prc = $__Eml->Upd_Eml_Fld([ 
								't'=>'eml', 
								'id'=>$__eml_dt->enc, 
								'fld'=>[[
									'k'=>'eml_onl',
									'v'=>1
								]]
							]);
			}else{
				$__Cnc['e'] = 'no';
				$__Prc = $__Eml->Upd_Eml_Fld([ 
									't'=>'eml', 
									'id'=>$__eml_dt->enc, 
									'fld'=>[[
										'k'=>'eml_onl',
										'v'=>2
									]]
								]);
			}
				
		}elseif($__eml_dt->tp->id == _Cns('ID_SISEML_GMAIL')){
			
			$client = _gapi_str();
			$sumrgapi = new API_GAPI();
			
			$sumrgapi->cl = DB_CL_ENC;
			$sumrgapi->eml = $__eml_dt->enc;
			$sumrgapi->us = SISUS_ENC;
			$__ustkn = $sumrgapi->tkn_chk(); $rsp['tmp_tkn'] = $__ustkn;
			
			if($__ustkn->e == 'ok' && !isN($__ustkn->cod)) {
				
				$sumrgapi->service_token = $__ustkn->cod;
		   		$client->setAccessToken( $__ustkn->cod );
			  	$gmail = new Google_Service_Gmail($client);			
				$labels = $gmail->users_labels->listUsersLabels('me');
				
				if (count($labels->getLabels()) > 0) {
					$__Cnc['e'] = 'ok'; 
					$__Prc = $__Eml->Upd_Eml_Fld([ 
									't'=>'eml', 
									'id'=>$__eml_dt->enc, 
									'fld'=>[[
										'k'=>'eml_onl',
										'v'=>1
									]]
								]);
				}else{
					$__Cnc['e'] = 'no';
					$__Prc = $__Eml->Upd_Eml_Fld([ 
									't'=>'eml', 
									'id'=>$__eml_dt->enc, 
									'fld'=>[[
										'k'=>'eml_onl',
										'v'=>2
									]]
								]);
				}
			}	
					
		}
		
		$rsp['cnx'] = $__Cnc;
		
	}
	
	
//---------------------- SELECCIONA CORREO ----------------------//		



?>