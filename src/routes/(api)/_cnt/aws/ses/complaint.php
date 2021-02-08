<?php 
												
													
	if($__mail_flj == 'cl'){
		
		foreach($j_msj->complaint->complainedRecipients as $_eml_k=>$_eml_v){
			
			$_eml_b_dt = GtUsDt($_eml_v->emailAddress, 'usr');
			
			if(!isN($_eml_b_dt->enc)){
				
				$__upd = $__Cl->__flj_snd_us([ 
				
									'id'=>$_eml_b_dt->enc, 
									'dnc'=>$j_msj->complaint->complaintFeedbackType,
									'sndi'=>2, 
								
								]);
							
			}				
							
		}
						
	
	}elseif($__mail_flj == 'ec'){
		
		foreach($j_msj->complaint->complainedRecipients as $_eml_k=>$_eml_v){
			
			$_eml_b_dt = GtCntEmlDt([ 'id'=>$_eml_v->emailAddress, 'tp'=>'eml', 'bd'=>$_cl_dt->bd.'.', 'd'=>['plcy'=>'ok'] ]);
			
			if(!isN($_eml_b_dt->enc)){
				
				$rsp['eml_upd'][] = UPDCntEml_Cld([ 
										'bd'=>$_cl_dt->bd, 
										'id'=>$_eml_b_dt->enc, 
										'rjct'=>1,
										'sndi'=>2,
										'dnc'=>$j_msj->complaint->complaintFeedbackType,
										'cld'=>_CId('ID_CLD_BAD')
									]);	
										
			}							
								
		}		
				
	}
	
	
	
?>