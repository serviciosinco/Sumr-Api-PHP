<?php 
	
if (!session_id() && $__tp != 'js') { session_start(); }
 
$__key = Php_Ls_Cln($_POST['____key']);
$__dvc = Php_Ls_Cln($_POST['____dvc']);
$__oauth = Php_Ls_Cln($_POST['____oauth']);
$__sve = Php_Ls_Cln($_POST['securepc_ok'.$__key]);
 
if(
	(	
		isset($_POST['user_form'.$__key]) &&
		isset($_POST['passwor_for'.$__key])
	)
	||
	!isN($__oauth)
) {
   	
	$___ses = new CRM_SES();
	
	$___ses->lgin_user = strtolower(Php_Ls_Cln($_POST['user_form'.$__key]));
	$___ses->lgin_pass = Php_Ls_Cln($_POST['passwor_for'.$__key]);
	$___ses->lgin_sve = $__sve;
	$___ses->lgin_dvc = $__dvc;	

	if(!isN($__oauth)){
		$___ses->lgin_oauth = $__oauth;	
	}

	$___ses->lgin_dvc_web = 'ok';
	$___ses->lgin_usdt = 'ok';
	$rsp = $___ses->_Lgin();

} else {
	
    $rsp['e'] = 'no'; 
	$rsp['m'] = 2;
	
}
 
 
$rtrn = json_encode($rsp); 
 
?>