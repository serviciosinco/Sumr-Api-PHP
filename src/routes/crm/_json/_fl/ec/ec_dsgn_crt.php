<?php 
	
	$__cmprss = 'no';
	
	$_id_s = Php_Ls_Cln($_POST['s_id']);
	$_id_ec = Php_Ls_Cln($_POST['ec_id']);
	$_id_mdl = Php_Ls_Cln($_POST['mdl_id']);
	
	$__dtec = GtEcDt($_id_ec, 'enc');	
	
	$_chk_sgm = ChkEcEdtSgm([ 'sgm'=>$_id_s, 'ec'=>$__dtec->id, 'mdl'=>$_id_mdl ]);
	
	//$rsp['chk_sgm'] = $_chk_sgm;
	
	if($_chk_sgm->r == 'ok'){
		
		$rsp['e'] = 'ok';
		$rsp['cod'] = $_chk_sgm->cod;
		$rsp['tag'] = $_chk_sgm->tag;
		
	}else{
		
		$rsp['e'] = 'no';
		
	}
	
	
?>