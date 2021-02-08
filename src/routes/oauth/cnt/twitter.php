<?php
	
	$__tpscl = Php_Ls_Cln($_GET['tp']);
	$__tw_oauth_token = Php_Ls_Cln($_GET['oauth_token']);
	$__tw_succcess = Php_Ls_Cln($_GET['success']);
	$__rdrct = Php_Ls_Cln($_GET['redirect_uri']);
	$__ses_tw_oauth_token = Php_Ls_Cln($_GET['ses_oauth_token']);
	$__ses_tw_oauth_token_secret = Php_Ls_Cln($_GET['ses_oauth_token_secret']);


	if($__tw_succcess == 'ok'){
		
		$CntJV .= 'setTimeout(function(){ this.close(); }, 3000);';
		
	}elseif($__rdrct != ''){
		
		$_SESSION['oauth_token'] = $__ses_tw_oauth_token;
		$_SESSION['oauth_token_secret'] = $__ses_tw_oauth_token_secret;	
		$CntJV .= 'var _new_url = "'.$__rdrct.'"; window.location.href = _new_url;';
		
	}elseif($__tw_oauth_token != '' && $__tw_succcess != 'ok'){
		
		$__Tw = new CRM_Twitter([ 'conn_tkn'=>$_SESSION['oauth_token'], 'conn_tkns'=>$_SESSION['oauth_token_secret'] ]);
		$__Tw->o_vrfr = $_GET['oauth_verifier'];
		$_tkn = $__Tw->_oAuth(['t'=>'a']);
		
		
		if(!isN($_tkn)){
			
			$__us = GtUsDt($__us, 'enc');
			
			$__TwD = new CRM_Twitter([ 'conn_tkn'=>$_tkn->oauth_token, 'conn_tkns'=>$_tkn->oauth_token_secret ]);
			$__TwDC = $__TwD->_ChckCrdn();

			
			$__SclBd = new CRM_Thrd(); 
			$__SclBd->__t = 'scl';
			$__SclBd->cl = $__cl;
			$__SclBd->us = $__us->id;
			$__SclBd->_scl_nm = $__TwDC->name;
			$__SclBd->_scl_prf = $_tkn->user_id; 
			$__SclBd->scl_attr = [
				'oauth_token'=>$_tkn->oauth_token,
				'oauth_token_secret'=>$_tkn->oauth_token_secret,
				'screen_name'=>$_tkn->screen_name,
				'location'=>$__TwDC->location,
				'description'=>$__TwDC->description,
				'profile_background_color'=>$__TwDC->profile_background_color,
				'profile_background_image_url_https'=>$__TwDC->profile_background_image_url_https,
				'profile_image_url_https'=> str_replace('_normal','',$__TwDC->profile_image_url_https) 					
			];
		
			$__SclBd->scl = Php_Ls_Cln($_GET['_scl']);			
			$__Prc = $__SclBd->In();
			
			if($__Prc->e == 'ok'){
				$CntJV .= 'var _new_url = location.href + "&success=ok"; window.location.href = _new_url;';	
			}else{
				echo 'Error Request, close it please';	
			}
			
			unset($_SESSION['oauth_token']);
			unset($_SESSION['oauth_token_secret']);	
			
		}	
		
	}	

?>