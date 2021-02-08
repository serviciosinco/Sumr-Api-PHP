<?php 
	
// Ingreso de Registro
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdClFlj")) { 
		
	$__Enc = Enc_Rnd($_POST['flj'].'- flj');
	$_fl1 = "( SELECT id_sisslc FROM "._BdStr(DBM).TB_SIS_SLC." WHERE sisslc_enc = '".$_POST['clflj_flj']."' )";
	$_fl2 = "( SELECT id_sisslc FROM "._BdStr(DBM).TB_SIS_SLC." WHERE sisslc_enc = '".$_POST['clflj_tp']."')";
	$_fl3 = "( SELECT id_us FROM "._BdStr(DBM).TB_US." WHERE us_enc = '".$_POST['clflj_us']."')";
	
	
	if(!isN($_POST['clflj_user'])){ $_user = $_POST['clflj_user']; }else{ $_user = 2; }
	if(!isN($_POST['clflj_on'])){ $_on = $_POST['clflj_on']; }else{ $_on = 1; }
	if(!isN($_POST['clflj_ntf_eml'])){ $_ntf_eml = $_POST['clflj_ntf_eml']; }else{ $_ntf_eml = 1; }
	if(!isN($_POST['clflj_ntf_sms'])){ $_ntf_sms = $_POST['clflj_ntf_sms']; }else{ $_ntf_sms = 1; }
	if(!isN($_POST['clflj_ntf_whtsp'])){ $_ntf_whtsp = $_POST['clflj_ntf_whtsp']; }else{ $_ntf_whtsp = 1; }
	
	$insertSQL = sprintf("INSERT INTO "._BdStr(DBM).TB_CL_FLJ." (clflj_enc, clflj_cl, clflj_us, clflj_flj, clflj_tp, clflj_user, clflj_on, clflj_ntf_eml, clflj_ntf_sms, clflj_ntf_whtsp, clflj_ntf_eml, clflj_ntf_sms, clflj_ntf_whtsp) VALUES (%s, (SELECT id_cl FROM "._BdStr(DBM).TB_CL." WHERE cl_enc = %s), $_fl3, $_fl1, $_fl2, %s, %s, %s, %s, %s, %s, %s, %s)",
                   GtSQLVlStr(ctjTx($__Enc,'out'), "text"),                   
                   GtSQLVlStr(CL_ENC, "text"),
                   GtSQLVlStr($_user, "int"),
				   GtSQLVlStr($_on, "int"),
				   GtSQLVlStr($_ntf_eml, "int"),
				   GtSQLVlStr($_ntf_sms, "int"),
				   GtSQLVlStr($_ntf_whtsp, "int"));
	
	$Result = $__cnx->_prc($insertSQL);
		
	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['w'] = $__cnx->c_p->error;
		_ErrSis(['p'=>$insertSQL, 'd'=>$__cnx->c_p->error]);
	}

}

// Modificación de Registro
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdClFlj")) { 
	
	$Enc = $_POST['clflj_enc'];

	$_fl1 = "( SELECT id_sisslc FROM "._BdStr(DBM).TB_SIS_SLC." WHERE sisslc_enc = '".$_POST['clflj_flj']."' )";
	$_fl2 = "( SELECT id_sisslc FROM "._BdStr(DBM).TB_SIS_SLC." WHERE sisslc_enc = '".$_POST['clflj_tp']."')";
	$_fl3 = "( SELECT id_us FROM "._BdStr(DBM).TB_US." WHERE us_enc = '".$_POST['clflj_us']."')";
	
	$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_CL_FLJ." SET clflj_flj=$_fl1, clflj_tp=$_fl2, clflj_us=$_fl3, clflj_user=%s, clflj_on=%s, clflj_ntf_eml=%s, clflj_ntf_sms=%s, clflj_ntf_whtsp=%s WHERE clflj_enc = '".$Enc."' ", 
									GtSQLVlStr($_POST['clflj_user'], "int"),
									GtSQLVlStr($_POST['clflj_on'], "int"),
									GtSQLVlStr($_POST['clflj_ntf_eml'], "int"),
									GtSQLVlStr($_POST['clflj_ntf_sms'], "int"),
									GtSQLVlStr($_POST['clflj_ntf_whtsp'], "int"));
  	
	$Result = $__cnx->_prc($updateSQL);

	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
	}else{
		$rsp['m'] = 2;
		$rsp['e'] = 'no';
		_ErrSis(['p'=>$updateSQL,'d'=>$__cnx->c_p->error]);
	}

}

if ((isset($_POST['uid'])) && ($_POST['uid'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdClFlj'))){
	
	$deleteSQL = sprintf('DELETE FROM '.DBM.''.TB_CL_FLJ.' WHERE clflj_enc=%s', GtSQLVlStr($_POST['uid'], 'text'));
	$Result = $__cnx->_prc($deleteSQL);

	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		//$rsp['a'] = Aud_Sis(Aud_Dsc(417, $_POST['clare_dsc'], $_POST['id_clare']), $rsp['v']);
		$rsp['auto'] = __AutoRUN([ 't'=>'sis_cns', 'bd'=>'_cl_mnu' ]);
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		_ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);
	}

}


?>