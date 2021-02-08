<?php
	
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdMdlSPrd")) { 
	
	$__enc = Enc_Rnd($_POST['mdlsprd_nm'].' - '.$_POST['mdlsprd_tp']);		
		
	$insertSQL = sprintf("INSERT INTO "._BdStr(DBM).TB_MDL_S_PRD." (mdlsprd_enc, mdlsprd_cl, mdlsprd_nm, mdlsprd_y, mdlsprd_s, mdlsprd_tp, mdlsprd_est) 
	VALUES (%s, (SELECT id_cl FROM "._BdStr(DBM).TB_CL." WHERE cl_enc = %s), %s, %s, %s, %s, %s)",
                   GtSQLVlStr($__enc, "text"),
                   GtSQLVlStr(ctjTx(CL_ENC,'out'), "text"),
                   GtSQLVlStr(ctjTx($_POST['mdlsprd_nm'],'out'), "text"),
				   GtSQLVlStr( $_POST['mdlsprd_y'] , "int"),
				   GtSQLVlStr( $_POST['mdlsprd_s'] , "int"),
				   GtSQLVlStr( $_POST['mdlsprd_tp'] , "int"),
				   GtSQLVlStr(Html_chck_vl($_POST['mdlsprd_est']), "int"));

	$Result = $__cnx->_prc($insertSQL);
	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;

	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['sm'] = $insertSQL;
		_ErrSis(['p'=>$insertSQL, 'd'=>$__cnx->c_p->error]);
	}
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdMdlSPrd")) { 
	
	$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_MDL_S_PRD." SET mdlsprd_nm=%s, mdlsprd_y=%s, mdlsprd_s=%s, mdlsprd_tp=%s, mdlsprd_est=%s WHERE mdlsprd_enc=%s ",
						GtSQLVlStr(ctjTx($_POST['mdlsprd_nm'],'out'), "text"),
						GtSQLVlStr( $_POST['mdlsprd_y'] , "int"),
						GtSQLVlStr( $_POST['mdlsprd_s'] , "int"),
						GtSQLVlStr( $_POST['mdlsprd_tp'] , "int"),
						GtSQLVlStr(Html_chck_vl($_POST['mdlsprd_est']), "int"),
						GtSQLVlStr( $_POST['mdlsprd_enc'], "text"));
	
	$Result = $__cnx->_prc($updateSQL); 
	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		//$rsp['a'] = Aud_Sis(Aud_Dsc(482, $_POST['mdls_nm'], $_POST['id_mdls']), $rsp['v']);
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
	} 
}


if ((isset($_POST['uid'])) && ($_POST['uid'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdMdlSPrd'))) { 
	$deleteSQL = sprintf('DELETE FROM '.TB_MDL_S_PRD.' WHERE mdlsprd_enc=%s', GtSQLVlStr($_POST['uid'], 'text'));
	 $Result = $__cnx->_prc($deleteSQL); if($Result){$rsp['e'] = 'ok'; $rsp['m'] = 1; 
	 $rsp['a'] = Aud_Sis(Aud_Dsc(483, $_POST['mdlsprd_nm'], $_POST['uid']), $rsp['v']);
	 }else{$rsp['e'] = 'no';$rsp['m'] = 2; _ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);}
}
?>