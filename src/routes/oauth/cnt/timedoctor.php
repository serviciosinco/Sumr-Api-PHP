<?php
	

	$__tmedctr_oauth_code = Php_Ls_Cln($_GET['code']);
	$__tmedctr_succcess = Php_Ls_Cln($_GET['success']);
	$__tmedctr_api = Php_Ls_Cln($_GET['_api']);
	
	
	if($__tmedctr_api != '' && $__tmedctr_succcess != 'ok'){

		$data = TmeDctr_Tkn(['code'=>$__tmedctr_oauth_code, 'api'=>$__tmedctr_api, 'us'=>$__us, 'cl'=>$__cl]);
		$data = json_decode($data); 

		if(!isN($data->access_token)){
			
			$ustkn = TmeDctr_Us(['tkn'=>$data->access_token]);		
			$__us = GtUsDt($__us, 'enc');
			
			$__SclBd = new CRM_Thrd(); 
			$__SclBd->__t = 'scl';
			$__SclBd->cl = $__cl;
			$__SclBd->us = $__us->id;
			$__SclBd->_scl_nm = $ustkn->full_name;
			$__SclBd->_scl_prf = $ustkn->user_id; 
			$__SclBd->scl_attr = [
				'access_token'=>$data->access_token,
				'expires_in'=>$data->expires_in,
				'token_type'=>$data->token_type,
				'refresh_token'=>$data->refresh_token,
				'profile_picture'=>$ustkn->avatar			
			];
		
			$__SclBd->scl = Php_Ls_Cln($_GET['_api']);		
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
	
		
		
	}else{
		
		echo '<script> this.close(); </script>';
		
	}	

?>