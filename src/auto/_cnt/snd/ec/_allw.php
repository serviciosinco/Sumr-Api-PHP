<?php 
	
	try {
			
		$___allw_snd = 'no';
		
		
		//----- If is mail test - mark as allow -----//
		
			if($___datprcs_v['ecsnd_test'] == 1){
				$___allw_snd = 'ok'; $___allw_snd_m .= 'It is a test'; 
			}
		
		//----- If campaign in sending status - mark as allow -----//
		
			if($__cmpg_dt->est->id == _CId('ID_ECCMPGEST_SNDIN')){ 
				$___allw_snd = 'ok'; $___allw_snd_m .= 'Campaign in sending status'; 
			}else{
				$___allw_snd_m .= 'Campaign (CMPG-'.$__cmpg_dt->id.') in other status instead of sending';
			}
		
		//----- If campaign in aprobed status - mark as allow -----//
		
			if($__cmpg_dt->est->id == _CId('ID_ECCMPGEST_APRBD') && $__cmpg_dt->sndr->id == _CId('ID_SISEML_SUMR')){ 
				$___allw_snd = 'ok'; 
			}
		
		//----- If is not a campaign mail - mark as allow -----//
		
			if(isN($__cmpg_dt->id)){ 
				$___allw_snd = 'ok'; $___allw_snd_m .= 'Campaign is null'; 
			}
		
		//----- If is developer - mark as not allow -----//
		
			if((Dvlpr() && mBln($___datprcs_v['cnt_test']) == 'no') && (!defined('SYS_AUTO')) ){ 
				$___allw_snd = 'no'; $___allw_snd_m .= 'Is developer and not a test'; 
			}
		
		//----- If is developer or in other batch - mark as allow -----//
		
			if((Dvlpr() && mBln($___datprcs_v['cnt_test']) == 'no') && (!defined('SYS_AUTO')) ){ 
				$___allw_snd = 'no'; $___allw_snd_m .= 'Is processing by another batch'; 
			}
		
		//----- If is not a campaign mail - mark as allow -----//
		
			if(isN($__cmpg_dt->id)){ 
				$___allw_snd = 'ok'; $___allw_snd_m .= 'Campaign is null'; 
			}
		
	} catch (Exception $e) {
	    
	    $___lck = $this->Rqu([ 't'=>$__rqu_tp, 'cl'=>$_cl_v->id, 'lck'=>2 ]);
	    if($this->g__s3 == 'cmpg_snd'){ $__rd_cmpg_p = $this->EcCmpg_Rd(); }
	    
	    echo $this->err($e->getMessage());

	    
	}
	
	
?>