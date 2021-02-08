<?php 
	
// Ingreso de Registro
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdClFtp")) { 
	
	$__Enc = Enc_Rnd($_POST['nm'].'- ftp');
	
	$insertSQL = sprintf("INSERT INTO ".TB_CL_FTP." (clftp_enc, clftp_cl,clftp_nm,clftp_hst,clftp_prt,clftp_tmout,clftp_psv,clftp_usr,clftp_pssw) VALUES (%s, (SELECT id_cl FROM "._BdStr(DBM).TB_CL." WHERE cl_enc = %s), %s, %s, %s, %s, %s, %s, AES_ENCRYPT(%s, '".ENCRYPT_PASSPHRASE."'))",
	
                   GtSQLVlStr(ctjTx($__Enc,'out'), "text"),
                   GtSQLVlStr(CL_ENC, "text"),
                   GtSQLVlStr(ctjTx($_POST['nm'],'out'), "text"),
                   GtSQLVlStr(ctjTx($_POST['hst'],'out'), "text"),
                   GtSQLVlStr($_POST['prt'], "int"),
                   GtSQLVlStr($_POST['tmout'], "int"),
                   GtSQLVlStr($_POST['psv'], "int"),
                   GtSQLVlStr(ctjTx($_POST['usr'],'out'), "text"),
                   GtSQLVlStr(ctjTx($_POST['pssw'],'out'), "text"));		
				   
	
	$Result = $__cnx->_prc($insertSQL); $rsp['w'] = $__cnx->c_p->error;
		
	if($Result){
		
	$_id = $__cnx->c_p->insert_id;
	
	$insertSQL1 = sprintf("INSERT INTO ".TB_CL_FTP_SVC." (clftpsvc_enc,clftpsvc_clftp,clftpsvc_pth,clftpsvc_rmte,clftpsvc_tp) VALUES (%s, %s ,%s ,%s ,(SELECT id_sisslc FROM "._BdStr(DBM).TB_SIS_SLC." WHERE sisslc_enc = %s))",
	
	               GtSQLVlStr(ctjTx($__Enc,'out'), "text"),
	               GtSQLVlStr($_id, "int"),
                   GtSQLVlStr(ctjTx($_POST['pth'],'out'), "text"),
                   GtSQLVlStr(ctjTx($_POST['rmte'],'out'), "text"),
                   GtSQLVlStr(ctjTx($_POST['ftp_svc'],'out'), "text"));		
	
	
	$Result = $__cnx->_prc($insertSQL1); $rsp['w'] = $__cnx->c_p->error;

		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		
	}else{
		$rsp['e'] = 'no';	 
		$rsp['m'] = 2;
		
		_ErrSis(['p'=>$insertSQL, 'd'=>$__cnx->c_p->error]);
	}
}
// Modificación de Registro
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdClFtp")) { 
	
	
	$updateSQL = sprintf("UPDATE ".TB_CL_FTP." SET clftp_nm=%s, clftp_hst=%s, clftp_prt=%s, clftp_tmout=%s, clftp_psv=%s, clftp_usr=%s, clftp_pssw=AES_ENCRYPT(%s,'".ENCRYPT_PASSPHRASE."') WHERE clftp_enc=%s",
				   GtSQLVlStr(ctjTx($_POST['nm'],'out'), "text"),
                   GtSQLVlStr(ctjTx($_POST['hst'],'out'), "text"),
                   GtSQLVlStr($_POST['prt'], "int"),
                   GtSQLVlStr($_POST['tmout'], "int"),
                   GtSQLVlStr($_POST['psv'], "int"),
                   GtSQLVlStr(ctjTx($_POST['usr'],'out'), "text"),
                   GtSQLVlStr(ctjTx($_POST['pssw'],'out'), "text"),
				   GtSQLVlStr(ctjTx($_POST['clftp_enc'],'out'), "text"));
				   
  	$rsp['q'] = $updateSQL;
	$Result = $__cnx->_prc($updateSQL); 

	if($Result){
		$rsp['e'] = 'ok';		
		$rsp['m'] = 1;
	}else{
		$rsp['m'] = 2;
		$rsp['e'] = 'no';
		_ErrSis(['p'=>$updateSQL, 'd'=>$__cnx->c_p->error]);
	} 
}

if ((isset($_POST['uid'])) && ($_POST['uid'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdClFtp'))) { 
	
	$deleteSQL = sprintf('DELETE '.TB_CL_FTP_SVC.' , '.TB_CL_FTP.' FROM '.TB_CL_FTP_SVC.' INNER JOIN  '.TB_CL_FTP.'  ON( id_clftp = clftpsvc_clftp)  WHERE clftp_enc=%s and clftpsvc_enc=%s ',
	GtSQLVlStr($_POST['uid'], 'text'),
	GtSQLVlStr($_POST['uid'], 'text'));
	$Result = $__cnx->_prc($deleteSQL); 

	if($Result){
		$rsp['e'] = 'ok'; $rsp['m'] = 1;
		//$rsp['a'] = Aud_Sis(Aud_Dsc(417, $_POST['clare_dsc'], $_POST['id_clare']), $rsp['v']);
		$rsp['auto'] = __AutoRUN([ 't'=>'sis_cns', 'bd'=>'_cl_mnu' ]);
	}else{
		$rsp['e'] = 'no';$rsp['m'] = 2; 
		_ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);
	}
}


?>