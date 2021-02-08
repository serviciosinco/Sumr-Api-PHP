<?php 
if($__t == 'cl_tex'){ 
	$__bd_go = ['d'=>'cl']; 
	$__bd = MDL_TEX_BD; // Base de Datos
	$__bdauto = '_cl_lng';
}else{
	$__bd = _BdStr(DBM).MDL_SIS_TEX_BD; // Base de Datos
	$__bdauto = '_sis_lng';
}
	
// Ingreso de Registro
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdSisTex")) { 
		
		$__enc = Enc_Rnd($_POST['sistex_tt'].'-'.$_POST['sistex_var']);
		
		$insertSQL = sprintf("INSERT INTO ".$__bd." ( sistex_enc, sistex_tt, sistex_var, sistex_dsc, sistex_vl_es, sistex_vl_en, sistex_vl_it, sistex_vl_fr, sistex_vl_gr, sistex_vl_krn, sistex_vl_jpn, sistex_vl_ptg, sistex_vl_mdn, sistex_tp) VALUES ( %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GtSQLVlStr(ctjTx($__enc,'out'), "text"),
                       GtSQLVlStr(ctjTx($_POST['sistex_tt'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['sistex_var'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['sistex_dsc'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['sistex_vl_es'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['sistex_vl_en'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['sistex_vl_it'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['sistex_vl_fr'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['sistex_vl_gr'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['sistex_vl_krn'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['sistex_vl_jpn'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['sistex_vl_ptg'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['sistex_vl_mdn'],'out'), "text"),
					   GtSQLVlStr($_POST['sistex_tp'], "int"));			
		
		$Result = $__cnx->_prc($insertSQL);
		
 		if($Result){
			
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
			$rsp['a'] = $insertSQL;
			$rsp['auto'] = __AutoRUN([ 't'=>'sis_cns', 't2'=>'sis_cns', 's2'=>'sis_lng', 'bd'=>$__bdauto ]);
		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			$rsp['w'] = $__cnx->c_p->error;
			_ErrSis(['p'=>$insertSQL, 'd'=>$__cnx->c_p->error]);
		}
		$rtrn = json_encode($rsp);
}

// Modificación de Registro
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdSisTex")) { 
	
	$updateSQL = sprintf("UPDATE ".$__bd." SET sistex_tt=%s, sistex_var=%s, sistex_dsc=%s, sistex_vl_es=%s, sistex_vl_en=%s, sistex_vl_it=%s, sistex_vl_fr=%s, sistex_vl_gr=%s, sistex_vl_krn=%s, sistex_vl_jpn=%s, sistex_vl_ptg=%s, sistex_vl_mdn=%s, sistex_tp=%s WHERE sistex_enc=%s",
					   GtSQLVlStr(ctjTx($_POST['sistex_tt'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['sistex_var'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['sistex_dsc'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['sistex_vl_es'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['sistex_vl_en'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['sistex_vl_it'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['sistex_vl_fr'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['sistex_vl_gr'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['sistex_vl_krn'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['sistex_vl_jpn'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['sistex_vl_ptg'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['sistex_vl_mdn'],'out'), "text"),
					   GtSQLVlStr($_POST['sistex_tp'], "int"),
					   GtSQLVlStr(ctjTx($_POST['sistex_enc'],'out'), "text"));
	
	$Result = $__cnx->_prc($updateSQL); 
	
	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		//$rsp['a'] = Aud_Sis(Aud_Dsc(126, $_POST['tex_tt'], $_POST['id_tex']), $rsp['v']);
		$rsp['auto'] = __AutoRUN([ 't'=>'sis_cns', 't2'=>'sis_cns', 's2'=>'sis_lng', 'bd'=>$__bdauto ]);
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['w'] = $__cnx->c_p->error;
		_ErrSis(['p'=>$updateSQL, 'd'=>$__cnx->c_p->error]);
	} 
	$rtrn = json_encode($rsp);
}

// Elimino el Registro
if ((isset($_POST['uid'])) && ($_POST['uid'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdSisTex'))) { 
	$deleteSQL = sprintf('DELETE FROM '.$__bd.' WHERE sistex_enc=%s', GtSQLVlStr($_POST['uid'], 'text'));
	$Result = $__cnx->_prc($deleteSQL); if($Result){$rsp['e'] = 'ok'; $rsp['m'] = 3; $rsp['a'] = Aud_Sis(Aud_Dsc(127, $_POST['sistex_tt'], $_POST['uid']), $rsp['v']); }else{$rsp['e'] = 'no';$rsp['m'] = 2; _ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);} $rtrn = json_encode($rsp);
}
?>