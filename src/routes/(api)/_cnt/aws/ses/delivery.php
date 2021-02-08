<?php 
												
													
	if($__mail_flj == 'cl'){
		
		$__upd = $__Cl->__flj_snd_upd([ 
					'id'=>$__snd_dt->enc, 
					'est'=>_CId('ID_SNDEST_ACPT'),
					'dlvry_tmmls'=>$j_msj->delivery->processingTimeMillis,
					'dlvry_tmstmp'=>$j_msj->delivery->timestamp,
					'dlvry_smtrsp'=>$j_msj->delivery->smtpResponse,
					'dlvry_rmtmta'=>$j_msj->delivery->reportingMTA,
					'dlvry_rmtmta_ip'=>$j_msj->delivery->remoteMtaIp
				]);	
	
	}elseif($__mail_flj == 'ec'){
		
		$__upd = $__ec->_SndEc_UPD([ 
					'enc'=>$__snd_dt->enc, 
					'est'=>_CId('ID_SNDEST_ACPT'),
					'dlvry_tmmls'=>$j_msj->delivery->processingTimeMillis,
					'dlvry_tmstmp'=>$j_msj->delivery->timestamp,
					'dlvry_smtrsp'=>$j_msj->delivery->smtpResponse,
					'dlvry_rmtmta'=>$j_msj->delivery->reportingMTA,
					'dlvry_rmtmta_ip'=>$j_msj->delivery->remoteMtaIp
				]);	
		
		//$insertSQL = "INSERT INTO ____RQ (rq, raw, field, field_unb, field_urw, field_post, field_get, field_srv, field_raw) VALUES ('AWS Delivery','".print_r($__upd, true)."','','','','','','','')";		
		//$Result = $__cnx->_prc($insertSQL);

	}

?>