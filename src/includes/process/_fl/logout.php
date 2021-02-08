<?php

	if ((isset($_POST['doLogout']))&&($_POST['doLogout'] == "true")){
		
	
	  	$___ses_chk = new CRM_SES();
		//$___ses_chk->__ses_cln();
		$___ses_chk->__ck_cln();
		  
		  
		if (ini_get("session.use_cookies")) {
			$params = session_get_cookie_params();
			setcookie(session_name(), '', time() - 42000,
				$params["path"], $params["domain"],
				$params["secure"], $params["httponly"]
			);
		}
	
		session_destroy();

		
		UPDus_Onl([ 'rst'=>'ok' ]);
		$rsp['ses']['off'] = UPD_UsSes([ 'id'=>SISUS_SES_ID, 'est'=>2 ]);
		
	  	$rsp['e'] = 'ok'; $rsp['m'] = 1;
	  
	  
	}else{
		$rsp['e'] = 'no'; $rsp['m'] = 2;
	}

?>