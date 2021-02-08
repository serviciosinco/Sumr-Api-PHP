<?php 

	
	$_tp_id = $__snd->__BnceId([ 'key'=>$j_msj->bounce->bounceType ]);
	$_tps_id = $__snd->__BnceId([ 't'=>'sub', 'key'=>$j_msj->bounce->bounceSubType, 'prnt'=>$_tp_id->cns ]);	
											
	
	//$insertSQL = "INSERT INTO ____RQ (rq, raw, field, field_unb, field_urw, field_post, field_get, field_srv, field_raw) VALUES ('AWS Bounce','','','','','','','','')";		
	//$Result = $__cnx->_prc($insertSQL);
			
															
	if($__mail_flj == 'cl'){
		
		$__upd = $__Cl->__flj_snd_upd([ 	
							'id'=>$__snd_dt->enc, 
							'est'=>_CId('ID_SNDEST_RBT'),
							'bnc'=>json_encode($j_msj->bounce), 
							'bnc_sbj'=>'',
							'bnc_msg'=>$j_msj->bounce->bouncedRecipients[0]->diagnosticCode,
							'bnc_rpr'=>$j_msj->bounce->reportingMTA,
							'bnc_tp'=>$_tp_id->id,
							'bnc_tp_sub'=>$_tps_id->id
						]);
	
	}elseif($__mail_flj == 'ec'){
		
		$__upd = $__ec->_SndEc_UPD([ 
						'enc'=>$__snd_dt->enc, 
						'est'=>_CId('ID_SNDEST_RBT'),
						'bnc'=>json_encode($j_msj->bounce), 
						'bnc_sbj'=>'',
						'bnc_msg'=>$j_msj->bounce->bouncedRecipients[0]->diagnosticCode,
						'bnc_rpr'=>$j_msj->bounce->reportingMTA,
						'bnc_tp'=>$_tp_id->id,
						'bnc_tp_sub'=>$_tps_id->id
					]);
		
		if($_tp_id->id == _CId('ID_SISSNDBNCTP_PRMN')){
			
			foreach($j_msj->bounce->bouncedRecipients as $_eml_k=>$_eml_v){
				
				$_eml_b_dt = GtCntEmlDt([ 'id'=>$_eml_v->emailAddress, 'tp'=>'eml', 'bd'=>$_cl_dt->bd.'.', 'd'=>['plcy'=>'ok'] ]);
				
				if($_tps_id->id == _CId('ID_SISSNDBNCTPS_GEN') || $_tps_id->id == _CId('ID_SISSNDBNCTPS_NOEML')){
					
					$rsp['eml_upd'][] = UPDCntEml_Cld([ 
											'bd'=>$_cl_dt->bd, 
											'rjct'=>1,
											'sndi'=>2,
											'lck'=>'ok',
											'id'=>$_eml_b_dt->enc, 
											'cld'=>_CId('ID_CLD_BAD')
										]);
				}					
									
			}
			
		}
				
	}

	
	$__cnx->_clsr($Result);
	
?>