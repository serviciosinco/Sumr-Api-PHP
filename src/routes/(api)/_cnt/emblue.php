<?php
	global $__cnx;
		
	$rsp = null;
	
	
	$__hub_c = Php_Ls_Cln($_GET['hub_challenge']);
	$__hub_t = Php_Ls_Cln($_GET['hub_verify_token']);
	$___entry  = _jEnc(_GetPost('entry'));
	
	
	//-------------- FOLDERS INTERNOS --------------//
		
		define('API_F_EMBLUE', dirname(__FILE__).'/emblue/');
	
	//-------------- FOLDERS INTERNOS --------------//
		

	
	$j_unb  = json_encode(_PostR_JData()) ;
	$j_urw  = json_encode( _PostRw() );
	$j_post = json_encode($_POST);
	$j_get = json_encode($_GET);
	$j_srv = json_encode($_SERVER);
	$j_raw = $HTTP_RAW_POST_DATA;	

	$insertSQL = sprintf("INSERT INTO ____RQ (rq, raw, field, field_unb, field_urw, field_post, field_get, field_srv, field_raw) VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s)",
				   GtSQLVlStr($j_unb, "text"),
				   GtSQLVlStr($j_urw.print_r($j_raw, true), "text"),
				   GtSQLVlStr($j_post.$j_get.$j_srv, "text"));

	$Result = $__cnx->_prc($insertSQL);
	
	
	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		$rsp['emblue'] = 'registered '.$__cnx->c_p->insert_id;
	}else{
		$rsp['w'] = $__cnx->c_p->error;
	}
	
	$__cnx->_clsr($Result);
	
?>