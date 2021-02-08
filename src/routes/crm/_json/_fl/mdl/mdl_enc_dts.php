<?php 
	
	$__tp = Php_Ls_Cln($_POST['_tp']); // true para buscar solo los registros que estan relacionados
	$__id = Php_Ls_Cln($_POST['_i']);
	$__clr = Php_Ls_Cln($_POST['_clr']);
	
	if($__clr == "_god"){ 
		$__clr = 1; $__clr_tt = "#43B05C"; $__qly = "Bueno"; 
	}elseif($__clr == "_ntr"){ 
		$__clr = 2; $__clr_tt = "#AFAFAF"; $__qly = "Neutral"; 
	}elseif($__clr == "_bad"){ 
		$__clr = 3; $__clr_tt = "#E04F5F"; $__qly = "Malo"; 
	}
	

	$query_DtRg = "UPDATE _enc_dts SET encdts_qly = ".$__clr." WHERE id_encdts = $__id ";
	$DtRg = $__cnx->_prc($query_DtRg);
	

	if($DtRg){	
		$rsp['e'] = 'ok';
		//$rsp['qry'] = $query_DtRg;
		$rsp['clr_tt'] = $__clr_tt;
		$rsp['a'] = Aud_Sis(Aud_Dsc(35,  $__clr, $__id), $rsp['v']);
		//$rsp['a'] = Aud_Sis(Aud_Dsc(35, $_POST['encdts_qly'], $_POST[$__id]), $rsp['v']);
	}else{
		$rsp['e'] = 'no';
		$rsp['err'] = $__cnx->c_p->error;
	}
	
?>