<?php 	
	
// Ingreso de Registro
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdAtmtEtp")) { 
		
	$__enc = Enc_Rnd($_POST['atmtetp_nm'].'-'.$_POST['atmtetp_atmt'].'-'.SISUS_ID);
	
	$insertSQL = sprintf("INSERT INTO "._BdStr(DBA).TB_ATMT_ETP." (atmtetp_enc, atmtetp_nm, atmtetp_on, atmtetp_atmt, atmtetp_ord, atmtetp_d_bfr, atmtetp_etp) VALUES (%s,%s,%s, (SELECT id_atmt FROM "._BdStr(DBA).TB_ATMT." WHERE atmt_enc=%s), %s,%s, (SELECT id_cletp FROM "._BdStr(DBM).TB_CL_ETP." WHERE cletp_enc=%s) )",
				   GtSQLVlStr($__enc, "text"),
				   GtSQLVlStr(ctjTx($_POST['atmtetp_nm'],'out'), "text"),
				   GtSQLVlStr(Html_chck_vl($_POST['atmtetp_on']), "int"),
				   GtSQLVlStr($_POST['atmtetp_atmt'], "text"),
				   GtSQLVlStr($_POST['atmtetp_ord'], "int"),
				   GtSQLVlStr(ctjTx($_POST['atmtetp_d_bfr'],'out'), "text"),
				   GtSQLVlStr($_POST['atmtetp_etp'], "text"));
				   	
	
	$Result = $__cnx->_prc($insertSQL); $rsp['w'] = $__cnx->c_p->error;
		
	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		//$rsp['enc'] = $__enc;
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		
	}
}

// Modificación de Registro
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdAtmtEtp")) { 

	
	$updateSQL = sprintf("UPDATE "._BdStr(DBA).TB_ATMT_ETP." SET atmtetp_nm=%s, atmtetp_on=%s, atmtetp_atmt=%s, atmtetp_ord=%s, atmtetp_d_bfr=%s, atmtetp_etp=%s WHERE atmtetp_enc=%s",			
	                    GtSQLVlStr(ctjTx($_POST['atmtetp_nm'],'out'), "text"),
	                    GtSQLVlStr(Html_chck_vl($_POST['atmtetp_on']), "int"),
	                    GtSQLVlStr($_POST['atmtetp_atmt'], "int"),
						GtSQLVlStr($_POST['atmtetp_ord'], "int"),
						GtSQLVlStr(ctjTx($_POST['atmtetp_d_bfr'],'out'), "text"),
						GtSQLVlStr($_POST['atmtetp_etp'], "int"),
						GtSQLVlStr($_POST['atmtetp_enc'], "text"));
	 
	$Result = $__cnx->_prc($updateSQL); 

	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
	} 
}


// Modificación de Registro
if ((isset($_POST["MMM_Update_auto"])) && ($_POST["MMM_Update_auto"] == "EdAtmtEtp")) { 

	
	$updateSQL = sprintf("UPDATE "._BdStr(DBA).TB_ATMT_ETP." SET atmtetp_on=%s WHERE atmtetp_enc=%s",			
	                    GtSQLVlStr(Html_chck_vl($_POST['atmtetp_on']), "int"),
						GtSQLVlStr($_POST['atmtetp_enc'], "text"));
	 
	$Result = $__cnx->_prc($updateSQL); 

	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
	} 
}


// Elimino el Registro
if ((isset($_POST['id_atmtetp'])) && ($_POST['id_atmtetp'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdAtmtEtp'))) { 
	$deleteSQL = sprintf('DELETE FROM '._BdStr(DBA).TB_ATMT_ETP.' WHERE atmtetp_enc=%s', GtSQLVlStr($_POST['atmtetp_enc'], 'text'));
	 $Result = $__cnx->_prc($deleteSQL); if($Result){$rsp['e'] = 'ok'; $rsp['m'] = 1; 
	 }else{ $rsp['e'] = 'no'; $rsp['m'] = 2; _ErrSis(array('p'=>$deleteSQL, 'd'=>$__cnx->c_p->error));}
}
?>