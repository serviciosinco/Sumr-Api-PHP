<?php 
	
	
	$__tp = Php_Ls_Cln($_POST['_tp']);
	$__ac = Php_Ls_Cln($_POST['_ac']);

	
	if($__tp == 'msg_ls'){
		$___to_inc_sub = GL_MYEML.'msg_ls.php';
	}elseif($__tp == 'eml_fld'){	
		$___to_inc_sub = GL_MYEML.'eml_fld.php';
	}elseif($__tp == 'eml_cnx'){	
		$___to_inc_sub = GL_MYEML.'eml_cnx.php';
	}elseif($__tp == 'eml_new'){	
		$___to_inc_sub = GL_MYEML.'eml_new.php';
	}
		
	if($___to_inc_sub != ''){ include($___to_inc_sub); }

	if($__tp != 'eml_cnx'){	
		$__Eml = new CRM_Eml();
		$box = $__Eml->_box([ 'enc'=>$__ac ]);
		$eml = $__Eml->_eml([ 'us'=>SISUS_ID, 'cl'=>DB_CL_ENC ]);
		$acc = GtSclAccLs([ 'us'=>SISUS_ID, 'cl'=>DB_CL_ENC, 'est'=>1 ]);
	}
	
	//$rsp['scl']['q'] = $acc->q;
	
	
	if($acc->e == 'ok'){
		$rsp['scl']['network'] = $acc->network;
	}
	
	if(!isN($box)){ $rsp['box'] = $box; }
	if(!isN($eml)){ $rsp['eml'] = $eml; }

?>