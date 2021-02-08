<?php 
use App\GmailEmail;

if($__scc == 'ok'){
		
	$CntJV .= 'setTimeout(function(){ this.close(); }, 3000);';
	
}else{

	$client = _gapi_str();

	$sumrgapi = new API_GAPI();
	$client->setAccessType("offline");
	$client->setApprovalPrompt("force");

	$client->setRedirectUri(GOAPI_URI);
	$client->addScope("https://mail.google.com/");
	$client->addScope("https://www.googleapis.com/auth/gmail.readonly");
	$client->addScope("https://www.googleapis.com/auth/gmail.compose");
	$client->addScope("https://www.googleapis.com/auth/gmail.send");
	$client->addScope('https://www.googleapis.com/auth/userinfo.email');
	$client->addScope('https://www.googleapis.com/auth/userinfo.profile');
	$client->addScope('https://www.googleapis.com/auth/calendar');
	$client->addScope('https://www.googleapis.com/auth/analytics');
	$client->addScope('https://www.googleapis.com/auth/adwords');


	$___font = __font();
		

	//-------------- --------------//
		
		if(!isN($__Oauth->_Ses('cl')) && !isN($__Oauth->_Ses('us'))){
			
			$sumrgapi->cl = $__Oauth->_Ses('cl'); 
			$sumrgapi->us = $__Oauth->_Ses('us');
			$sumrgapi->eml = $__Oauth->_Ses('eml');
			$__ustkn = $sumrgapi->tkn_chk();
			
		}else{
			$__noses = 'ok';
		}

		
	//-------------- --------------//

		if(!isN($__Oauth->__code)){ 
			
			$___auth = $client->authenticate($__Oauth->__code);
			$actkn = $client->getAccessToken();

			if(!isN($actkn)){

				$client->setAccessToken($actkn);
				//$client->revokeToken();
				$actkn_r = $client->getRefreshToken();	
				$gmail = new Google_Service_Gmail($client);
				$gmaild = $gmail->users->getProfile('me');
				
				if(!isN($actkn_r)){
					
					if(!isN($gmaild->emailAddress) && !isN($__Oauth->dt->eml->id) && $gmaild->emailAddress == $__Oauth->dt->eml->eml){
						
						$__Eml->eml_id_upd = $__Oauth->dt->eml->id;
						$__Eml->eml_attr = $actkn;
						//$__Eml->eml_attr['cod'] = json_decode($actkn);
						$__Prc = $__Eml->Eml_Attr(['tp'=>'eml']);
						
					}
					
					if($__Prc->e == 'ok'){
						header('Location: ' . DMN_OAUTH.'google/?success=ok&_r='.Gn_Rnd(10));
					}else{
						echo 'Error Request, close it please';	
					}
					
				}
					
				if($_sve_tkn->e == 'ok'){	
			
					unset($_SESSION['oauth']);
					
					$redirect = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'].'?success=ok';
					header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
					die();
				}

			}
			
		}else{
				
			if ($__ustkn->e != 'ok' || isN($__ustkn->cod)) {
				
				$authUrl = $client->createAuthUrl();
				
			}else{
				
				
				try{	

					$client->setAccessToken( $__ustkn->cod ); 
		
					if($client->isAccessTokenExpired()){ 
						
						$authUrl = $client->createAuthUrl();
						
					}else{
						
						$gmail = new Google_Service_Gmail($client);
						$gmaild = $gmail->users->getProfile('me');		
						
						if($gmaild->emailAddress != NULL){
							
							include(CNT_GOOGLE_HTML.'email.php');
						}
						
					}
				
					
					
				} catch (Exception $e) {
					
					echo $e->getMessage();
					
				}
			}
			
			
		}


		if(!isN($authUrl)){
			if($__noses != 'ok'){
				header('Location: ' . filter_var($authUrl, FILTER_SANITIZE_URL));
			}else{
				echo 'No id session';
			}
		}
		
		if (strpos(GOAPI_ID, "googleusercontent") == false) {
		echo missingClientSecretsWarning();
		exit;
		}

}
	
?>