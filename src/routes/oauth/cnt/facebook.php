<?php 
	
	
	$__code = Php_Ls_Cln($_GET['code']);
	
	
	if($__scc == 'ok'){
		
		$CntJV .= 'setTimeout(function(){ this.close(); }, 3000);';
		
	}elseif(!isN($__code)){ 
		
		$_SESSION['FBRLH_state']=$_GET['state'];
		
		$fb = _NwFb();
		$helper = $fb->getRedirectLoginHelper();
		
		try {
			$accessToken = $helper->getAccessToken();
		} catch(Facebook\Exceptions\FacebookResponseException $e) {
			$_rdrct_w = 'ok';
			$_rdrct_w_m = 'api';
		} catch(Facebook\Exceptions\FacebookSDKException $e) {
			$_rdrct_w = 'ok';
			$_rdrct_w_m = 'api';
		}
		
		if(!isN($accessToken)){ 

			$__tkn_lvd = (string)_NwFb_LAT(['access_token'=>$accessToken]);
			
		}
		
		if(!isN($__tkn_lvd)){
			
			
			if(!isN($_SESSION['oauth_cl'])){ $__cl=$_SESSION['oauth_cl'];  }
			if(!isN($_SESSION['oauth_us'])){ $__us=$_SESSION['oauth_us']; }
			if(!isN($_SESSION['oauth_eml'])){ $__eml=$_SESSION['oauth_eml']; }
			if(!isN($_SESSION['oauth_scl'])){ $__scl=$_SESSION['oauth_scl']; }
		
		
			$__us = GtUsDt($__us, 'enc'); 
			
			
			if(!isN($__us) && !isN($__scl)){
				
				$__prfl = _NwFb_Dt([ 'access_token'=>$__tkn_lvd ]); 
				
				$__SclBd = new CRM_Thrd(); 
				$__SclBd->__t = 'scl';
				$__SclBd->cl = $__cl;
				$__SclBd->us = $__us->id;
				$__SclBd->_scl_nm = $__prfl->name;
				$__SclBd->_scl_prf = $__prfl->id; 
				$__SclBd->scl_attr = [
					'tknlvd'=>$__tkn_lvd,
					'img'=>$__prfl->picture->url
				];
			
				$__SclBd->scl = $__scl;			
				$__Prc = $__SclBd->In(); 
				
				//print_r( $__Prc ); exit();
				
				if($__Prc->e == 'ok'){
					header('Location: ' . DMN_OAUTH.'facebook/?success=ok&_r='.Gn_Rnd(10));
				}else{
					echo 'Error Request, close it please';	
				}
				
			}else{
				
				$_rdrct_w = 'ok';
				$_rdrct_w_m = 'no_us';
				
			}
			
		}
		
		exit();

	}else{ 
		
		if(!isN($__cl)){ $_SESSION['oauth_cl'] = $__cl;  }
		if(!isN($__us)){ $_SESSION['oauth_us'] = $__us; }
		if(!isN($__eml)){ $_SESSION['oauth_eml'] = $__eml; }
		if(!isN($__scl)){ $_SESSION['oauth_scl'] = $__scl; }
		
		$_SESSION['oauth_frw']++;
		
		if($_SESSION['oauth_frw'] > 2){ 
			$_rdrct_w = 'ok';
			$_rdrct_w_m = 'no_cod';
			$_SESSION['oauth_frw'] = 0;
		}
	
		$__url = _NwFb_Login(); //if($_SESSION['oauth_frw'] > 2){ echo h1($_SESSION['oauth_frw']); print_r($__url->url); exit(); }
		
		if(!isN($__url->url)){
			header('Location: ' . filter_var($__url->url, FILTER_SANITIZE_URL));
		}
		
	}
	
	if($_rdrct_w == 'ok'){
		header('Location: '.DMN_OAUTH.'facebook/?_error=ok&_error_m='.$_rdrct_w_m.'&_r='.Gn_Rnd(20) );
	}
	
?>