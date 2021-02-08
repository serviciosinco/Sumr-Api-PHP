<?php
	
if($___Prc->pst->tsb == 'cl'){
	$__bd_go = ['d'=>'cl']; 
	$__bd = _BdStr(DBM).TB_CL_SLC_TP_F;
	$__bd2 = _BdStr(DBM).TB_CL_SLC_TP;
}else{
	$__bd = _BdStr(DBM).TB_SIS_SLC_TP_F;
	$__bd2 = _BdStr(DBM).TB_SIS_SLC_TP;
}

	
// Ingreso de Registro
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdSisSlcTpF")) { 
	
		$__enc = Enc_Rnd($_POST['sisslctpf_tt'].'-'.$_POST['sisslctpf_key']);
	
		$insertSQL = sprintf("INSERT INTO ".$__bd." (sisslctpf_enc, sisslctpf_tt, sisslctpf_key, sisslctpf_cns, sisslctpf_tp, sisslctpf_tpd, sisslctpf_rqd, sisslctpf_ord) VALUES (%s, %s, %s, %s, (SELECT id_sisslctp FROM ".$__bd2." WHERE sisslctp_enc = %s), %s, %s, %s)",
					   GtSQLVlStr(ctjTx($__enc,'out'), "text"),
                       GtSQLVlStr(ctjTx($_POST['sisslctpf_tt'],'out'), "text"),
                       GtSQLVlStr(ctjTx($_POST['sisslctpf_key'],'out'), "text"),
                       GtSQLVlStr(ctjTx($_POST['sisslctpf_cns'],'out'), "text"),
                       GtSQLVlStr(ctjTx($_POST['sisslctpf_tp'],'out'), "text"),
                       GtSQLVlStr($_POST['sisslctpf_tpd'], "int"),
					   GtSQLVlStr(Html_chck_vl($_POST['sisslctpf_rqd']), "int"),
					   GtSQLVlStr($_POST['sisslctpf_ord'], "int"));	
					   	
		$Result = $__cnx->_prc($insertSQL);
		//echo $insertSQL; exit();
 		if($Result){
			//$rsp['i'] = $__cnx->c_p->insert_id;
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
			//$rsp['a'] = Aud_Sis(Aud_Dsc(142, $_POST['cd_tt'], $__cnx->c_p->insert_id), $rsp['v']);
		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			$rsp['mdd'] = $insertSQL;
			$rsp['d'] = $__cnx->c_p->error.' -> '.$insertSQL;
			_ErrSis(['p'=>$insertSQL, 'd'=>$__cnx->c_p->error]);
		}
}

// Modificación de Registro
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdSisSlcTpF")) { 
	
	$updateSQL = sprintf("UPDATE ".$__bd." SET sisslctpf_tt=%s, sisslctpf_key=%s, sisslctpf_cns=%s, sisslctpf_tpd=%s, sisslctpf_rqd=%s, sisslctpf_ord=%s WHERE sisslctpf_enc=%s",
					   GtSQLVlStr(ctjTx($_POST['sisslctpf_tt'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['sisslctpf_key'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['sisslctpf_cns'],'out'), "text"),
					   GtSQLVlStr($_POST['sisslctpf_tpd'], "int"),
					   GtSQLVlStr(Html_chck_vl($_POST['sisslctpf_rqd']), "int"),
					   GtSQLVlStr($_POST['sisslctpf_ord'], "int"),	   
					   GtSQLVlStr(ctjTx($_POST['sisslctpf_enc'],'out'), "text"));
					    
	$Result = $__cnx->_prc($updateSQL); 
	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		$rsp['msss'] = $updateSQL;
		
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['w'] = $updateSQL.$__cnx->c_p->error;
		_ErrSis(['p'=>$updateSQL, 'd'=>$__cnx->c_p->error]);
	} 
}

// Elimino el Registro
if ((isset($_POST['uid'])) && ($_POST['uid'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdSisSlcTpF'))) { 
	$deleteSQL = sprintf('DELETE FROM '.$__bd.' WHERE sisslctpf_enc=%s', GtSQLVlStr(ctjTx($_POST['uid'],'out'), "text"));
	$Result = $__cnx->_prc($deleteSQL); if($Result){$rsp['e'] = 'ok'; $rsp['m'] = 1; 
	 //$rsp['a'] = Aud_Sis(Aud_Dsc(144, $_POST['lndfld_tt'], $_POST['id_lndfld']), $rsp['v']);
	 }else{$rsp['e'] = 'no';$rsp['m'] = 2; _ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);}
}
?>