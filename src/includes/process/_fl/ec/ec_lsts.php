<?php 
	
	
if(!isN($___Prc->mdlstp)){
	$__rlc_tp = 'ok';
	$__rlc_id = $___Prc->mdlstp;
}

	
// Ingreso de Registro
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdSndEcLsts")) { 
	
	$__enc = Enc_Rnd(DB_CL_ENC.'-'.$_POST['eclsts_nm']);
	
	$insertSQL = sprintf("INSERT INTO "._BdStr(DBM).TB_EC_LSTS." (eclsts_enc, eclsts_cl, eclsts_nm, eclsts_frm, eclsts_auto, eclsts_rsgnup, eclsts_org, eclsts_adrs, eclsts_cd, eclsts_ps, eclsts_tel, eclsts_sndr, eclsts_plcy) VALUES (%s, (SELECT id_cl FROM "._BdStr(DBM).TB_CL." WHERE cl_enc = %s), %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
				   GtSQLVlStr(ctjTx($__enc,'out'), "text"),
				   GtSQLVlStr(DB_CL_ENC, "text"),
				   GtSQLVlStr(ctjTx($_POST['eclsts_nm'],'out'), "text"),
				   GtSQLVlStr(ctjTx($_POST['eclsts_frm'],'out'), "text"),
				   GtSQLVlStr(ctjTx(2,'out'), "int"),
				   GtSQLVlStr(ctjTx($_POST['eclsts_rsgnup'],'out'), "text"),
				   GtSQLVlStr(ctjTx($_POST['eclsts_org'],'out'), "text"),
				   GtSQLVlStr(ctjTx($_POST['eclsts_adrs'],'out'), "text"),
				   GtSQLVlStr($_POST['eclsts_cd'], "int"),
				   GtSQLVlStr($_POST['eclsts_ps'], "int"),
				   GtSQLVlStr(ctjTx($_POST['eclsts_tel'],'out'), "text"),
				   GtSQLVlStr($_POST['eclsts_sndr'], "int"),
				   GtSQLVlStr(Html_chck_vl($_POST['eclsts_plcy']), "int"));
				   	
	
	$Result = $__cnx->_prc($insertSQL); 
		
	if($Result){
 		
 		//$rsp['i'] = $__cnx->c_p->insert_id;
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;

		
		if(!isN($__rlc_id->id)){	
			$insertSQL = sprintf("INSERT INTO "._BdStr(DBM).TB_EC_LSTS_TP." (eclststp_lsts, eclststp_tp) VALUES (%s, %s)",
						   GtSQLVlStr($rsp['i'], "int"),
						   GtSQLVlStr($__rlc_id->id, "int"));				   	
			$Result = $__cnx->_prc($insertSQL);
		}	
		
		$___are = Php_Ls_Cln($_POST['eclsts_are']);
		
		if(!isN($___are) && is_array($___are)){
			
			$__Cl = new CRM_Cl(); 
			$__Cl->ec_lsts_id = $__enc;
			
			foreach($___are as $___are_k=>$___are_v){
				$__Cl->id_are = $___are_v;
				$PrcDt = $__Cl->EcLstsAre_In();
			}
		}
	
			
	}else{
		
		$rsp['w'] = $__cnx->c_p->error;
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		_ErrSis(['p'=>$insertSQL, 'd'=>$__cnx->c_p->error]);
		
	}
	
	
}

// Modificación de Registro
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdSndEcLsts")) { 
	
	$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_EC_LSTS." SET eclsts_nm=%s, eclsts_sndr=%s WHERE eclsts_enc =%s",						
	                    GtSQLVlStr(ctjTx($_POST['eclsts_nm'],'out'), "text"),
	                    GtSQLVlStr($_POST['eclsts_sndr'], "int"),
	                    GtSQLVlStr($_POST['eclsts_enc'], "text"));
	
	$Result = $__cnx->_prc($updateSQL); 

	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		$rsp['a'] = Aud_Sis(Aud_Dsc(257, $_POST['eclsts_nm'], $_POST['id_eclsts']), $rsp['v']);
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['w'] = $__cnx->c_p->error;
		_ErrSis(['p'=>$updateSQL, 'd'=>$__cnx->c_p->error]);
	} 
}



if ((isset($_POST["MMM_Update_auto"])) && ($_POST["MMM_Update_auto"] == "EdEclsts")) { 
	
	$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_EC_LSTS." SET eclsts_auto=%s WHERE eclsts_enc=%s",			
	                    GtSQLVlStr(Html_chck_vl($_POST['eclsts_auto']), "int"),
						GtSQLVlStr($_POST['id_eclsts'], "text"));
	
	$Result = $__cnx->_prc($updateSQL);

	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
	} 
}

if ((isset($_POST["MMM_Update_plcy"])) && ($_POST["MMM_Update_plcy"] == "EdEclsts")) { 
	
	$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_EC_LSTS." SET eclsts_plcy=%s WHERE eclsts_enc=%s",			
	                    GtSQLVlStr(Html_chck_vl($_POST['eclsts_plcy']), "int"),
						GtSQLVlStr($_POST['id_eclsts'], "text"));
	
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
if ((isset($_POST['uid'])) && ($_POST['uid'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdSndEcLsts'))) { 
	
	$deleteSQL = sprintf('DELETE FROM '._BdStr(DBM).TB_EC_LSTS.' WHERE eclsts_enc=%s', GtSQLVlStr($_POST['uid'], 'text'));
	
	$Result = $__cnx->_prc($deleteSQL); 
	
	if($Result){$rsp['e'] = 'ok'; $rsp['m'] = 1; $rsp['a'] = Aud_Sis(Aud_Dsc(73, $_POST['eclsts_nm'], $_POST['uid'], $_POST['id_eclsts']), $rsp['v']);}
	else{$rsp['e'] = 'no';$rsp['m'] = 2; _ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);}
} 

?>