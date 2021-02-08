<?php

$__data = _jEnc(Php_Ls_Cln($_POST['data']));
$__key = $__data->key;
$__usr = $__data->{'usr'.$__data->key};
$__pss = $__data->{'pss'.$__data->key};


if(!isN($__usr) && !isN($__pss)) {

	$___ses = new CRM_SES();

	$___ses->lgin_acc = 'ok';
	$___ses->lgin_usdt = 'ok';
	$___ses->lgin_user = $__usr;
	$___ses->lgin_pass = $__pss;
	$___ses->lgin_sve = 1;
	$Prc = $___ses->_Lgin();


    if(!isN($Prc->us->enc)){

	    $__dt_cnt = GtUsDt($Prc->us->enc, 'enc', [ 'cl_dtl'=>['tag'=>'ok'] ]);

	    if(!isN($__dt_cnt->enc)){
   			$rsp['e'] = 'ok';
   			$rsp['m'] = 1;
   			$rsp['cl'] = $__dt_cnt->cl;
   			$rsp['us']['enc'] = $__dt_cnt->enc;
   		}else{
			$rsp['w'] = 'User details failed';
		}

	}else{
		$rsp['w'] = 'Process login failed';
		//$rsp['tmp'] = $Prc;
	}

} else {

    $rsp['e'] = 'no'; $rsp['m'] = 2;

}


$rtrn = json_encode($rsp);

?>