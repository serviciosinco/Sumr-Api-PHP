<?php

	$__ins_oauth_code = Php_Ls_Cln($_GET['code']);
	$__ins_succcess = Php_Ls_Cln($_GET['success']);

	
	
	if($__ins_succcess == 'ok'){
		
		$CntJV .= 'setTimeout(function(){ this.close(); }, 3000);';
		
	}elseif($__ins_oauth_code != ''){
		
		$__Rdrct = DMN_OAUTH.'instagram/?_scl='.Php_Ls_Cln($_GET['_scl']).'&_us='.Php_Ls_Cln($_GET['_us']).'&_cl='.Php_Ls_Cln($_GET['_cl']);
		$data = _InsTkn(['code'=>$__ins_oauth_code, 'cll'=>$__Rdrct]);
			
			if(!isN($data->access_token)){
				
				$__us = GtUsDt($__us, 'enc');
				
				$__SclBd = new CRM_Thrd(); 
				$__SclBd->__t = 'scl';
				$__SclBd->cl = $__cl;
				$__SclBd->us = $__us->id;
				$__SclBd->_scl_nm = $data->user->username;
				$__SclBd->_scl_prf = $data->user->id; 
				$__SclBd->scl_attr = [
					'access_token'=>$data->access_token,
					'full_name'=>$data->user->full_name,
					'bio'=>$data->user->bio,
					'profile_picture'=>$data->user->profile_picture				
				];
			
				$__SclBd->scl = Php_Ls_Cln($_GET['_scl']);			
				$__Prc = $__SclBd->In();
				
				if($__Prc->e == 'ok'){
					echo '
						<script> 
							var _new_url = location.href + "&success=ok";
							window.location.href = _new_url;
						</script>';
				}else{
					echo 'Error Request, close it please';	
				}
				
			}	
			
	
	}	

?>