<?php
	
// Ingreso de Registro


if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdSisLng")) { 
		
		$__enc = Enc_Rnd($_POST['sislng_nm'].'-'.$_POST['sislng_cod']);
		
		$insertSQL = sprintf("INSERT INTO ".TB_SIS_LNG." ( sislng_enc, sislng_nm, sislng_cod, sislng_tt_es, sislng_tt_en, sislng_tt_it, sislng_tt_fr, sislng_tt_gr) VALUES ( %s, %s, %s, %s, %s, %s, %s, %s)",

                       GtSQLVlStr(ctjTx($__enc,'out'), "text"),
                       GtSQLVlStr(ctjTx($_POST['sislng_nm'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['sislng_cod'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['sislng_tt_es'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['sislng_tt_en'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['sislng_tt_it'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['sislng_tt_fr'],'out'), "text"),
                       GtSQLVlStr(ctjTx($_POST['sislng_tt_gr'],'out'), "text"));	

		$Result = $__cnx->_prc($insertSQL);
		
 		if($Result){
			//$rsp['i'] = $__cnx->c_p->insert_id;
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
			$rsp['a'] = Aud_Sis(Aud_Dsc(71, $_POST['sislng_cod'], $__cnx->c_p->insert_id, $_POST['sislng_nm']), $rsp['v']);
			__AutoRUN([ 't'=>'sis_cns', 'bd'=>$__bdauto ]);
		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			_ErrSis(['p'=>$insertSQL, 'd'=>$__cnx->c_p->error]);
		}
}

// Modificación de Registro
if (($_POST["MM_update"] == "EdSisLng")) { 
$updateSQL = sprintf("UPDATE ".TB_SIS_LNG." SET sislng_nm=%s, sislng_cod=%s, sislng_tt_es=%s, sislng_tt_en=%s, sislng_tt_it=%s, sislng_tt_fr=%s, sislng_tt_gr=%s WHERE sislng_enc =%s",
					   GtSQLVlStr(ctjTx($_POST['sislng_nm'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['sislng_cod'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['sislng_tt_es'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['sislng_tt_en'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['sislng_tt_it'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['sislng_tt_fr'],'out'), "text"),
                       GtSQLVlStr(ctjTx($_POST['sislng_tt_gr'],'out'), "text"),
                       GtSQLVlStr(ctjTx($_POST['sislng_enc'],'out'), "text"));

	$Result = $__cnx->_prc($updateSQL); 
	
	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		$rsp['a'] = Aud_Sis(Aud_Dsc(72, $_POST['sislng_cod'], $_POST['sis_enc'], $_POST['sislng_nm']), $rsp['v']);
		__AutoRUN([ 't'=>'sis_cns', 'bd'=>$__bdauto ]);
	}else{
		$rsp['e'] = 'nop';
		$rsp['m'] = 2;
		$rsp['ms'] = $__cnx->c_p->error;
		_ErrSis(['p'=>$updateSQL, 'd'=>$__cnx->c_p->error]);
	} 
}

// Elimino el Registro
if ((isset($_POST['uid'])) && ($_POST['uid'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdSisLng'))) { 
	
	$deleteSQL = sprintf('DELETE FROM '.TB_SIS_LNG.' WHERE sislng_enc=%s', GtSQLVlStr($_POST['uid'], 'text'));
	$Result = $__cnx->_prc($deleteSQL); 
	
	if($Result){$rsp['e'] = 'ok'; $rsp['m'] = 1; $rsp['a'] = Aud_Sis(Aud_Dsc(73, $_POST['sislng_cod'], $_POST['uid'], $_POST['sislng_nm']), $rsp['v']);}
	else{$rsp['e'] = 'no';$rsp['m'] = 2; _ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);}
}
?>