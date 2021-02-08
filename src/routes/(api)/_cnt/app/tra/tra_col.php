<?php

	header("access-control-allow-origin: *");
	header("Access-Control-Allow-Origin: *");
	header("Access-Control-Allow-Credentials: true");
	header("Access-Control-Allow-Methods: GET,HEAD,OPTIONS,POST,PUT");
	header("Access-Control-Allow-Headers: Access-Control-Allow-Headers, Origin,Accept, X-Requested-With, Content-Type, Access-Control-Request-Method, Access-Control-Request-Headers");
	
	$_cl_enc = _GetPost('cl_enc');
	$_tracol_tt_fl = _GetPost('tracol_tt');
	
	if( !isN($_tracol_tt_fl) ){
		$__fl = " AND tracol_tt LIKE '%".$_tracol_tt_fl."%' ";
	}
	
	$_clDt = GtClDt($_cl_enc, 'enc');
	$TraColLs = GtTraColLs([ "id_us"=>181, "cl_enc"=>$_cl_enc, "bd"=>$_clDt->bd, "flt"=>$__fl ]);
	
	if( $TraColLs->e == "ok" ){
		
		$rsp["e"] = "ok";
		$rsp["tra_col"] = $TraColLs;
		
	}else{
		
		$rsp["e"] = "no";
		$rsp["w"] = "No existen columnas";
		
	}
	
?>