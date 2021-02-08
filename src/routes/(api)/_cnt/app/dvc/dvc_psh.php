<?php
	
	if( !isN($__dt_us->id) && !isN($_uses_enc) && !isN($_usdvc_tp) ){ 

		$__dvc = GtUsDvcDt([ 't'=>'ses', 'id'=>$_uses_enc ]);

		if($__dvc->e == 'ok'){

			$_aws = new API_CRM_Aws();
			$_ws = new CRM_Ws;
		
			$_endpoint = $_aws->_psh_epnt([ 'tkn'=>$_usdvc_tkn, 'p'=>$_usdvc_tp ]);
			
			if(!isN($_endpoint->id)){	
				
				$Result_Dvc = $_ws->UpdF([ 
									't'=>'dvc', 
									'f'=>[ 
										'usdvc_token'=>$_usdvc_tkn,
										'usdvc_aws_id'=>$_endpoint->id,
										'usdvc_'.$_usdvc_tp=>1 
									],
									'id'=>$__dvc->id 
								]);
			
				if($Result_Dvc->e == 'ok'){
				
					$rsp['e'] = 'ok';
					
				}else{
			
					$rsp['e'] = 'no';
			
				}
			}

		}
	
	}else{

		$rsp['e'] = 'no';
		$rsp['w'] = 'no user';
		
	}
	
?>