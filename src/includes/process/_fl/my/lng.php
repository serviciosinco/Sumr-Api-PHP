<?php
		
if(ChckSESS_usr()){
	
	$___lng = Php_Ls_Cln($_POST['lng']);
	$___iso = Php_Ls_Cln($_POST['iso']);
	
	$___ses_lng = new CRM_SES();
	$_Prc = $___ses_lng->__lng([ 'lng'=>$___lng, 'iso'=>$___iso ]);
	
	$rsp = $_Prc;

}

?>