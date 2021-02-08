<?php 	

//$__Atmt = new CRM_Atmt(); 
	
// Ingreso de Registro
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdAtmtTrgrCndc")) { 
		
		$__enc = Enc_Rnd($_POST['atmttrgrcndc_trgr'].'-'.$_POST['atmttrgrcndc_cndc'].'-'.SISUS_ID);
		
		$insertSQL = sprintf("INSERT INTO "._BdStr(DBA).TB_ATMT_TRGR_CNDC." (atmttrgrcndc_enc, atmttrgrcndc_trgr, atmttrgrcndc_cndc, atmttrgrcndc_v_vl, atmttrgrcndc_hbl) VALUES (%s, (SELECT id_atmttrgr FROM "._BdStr(DBA).TB_ATMT_TRGR." WHERE atmttrgr_enc=%s), %s, %s, %s)",
					   GtSQLVlStr($__enc, "text"),
					   GtSQLVlStr(ctjTx($_POST['atmttrgrcndc_trgr'],'out'), "text"),
					   GtSQLVlStr($_POST['atmttrgrcndc_cndc'], "int"),
					   GtSQLVlStr(ctjTx($_POST['atmttrgrcndc_v_vl'],'out'), "text"),
					   GtSQLVlStr(Html_chck_vl($_POST['atmttrgrcndc_hbl']), "int"));
		
		$Result = $__cnx->_prc($insertSQL); 
 		if($Result){	
	 		$rsp['e'] = 'ok';
			$rsp['m'] = 1;		
			
			if(!isN($_POST['atmttrgrcndc_trgr'])){	
				//$PrcDt = $__Atmt->_Trgr_Upd([ 'enc'=>$_POST['atmttrgract_trgr'], 'fa'=>SIS_F_D2 ]);
				$rsp['p'] = $PrcDt;
			}
		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			$rsp['w'] = $__cnx->c_p->error;
			_ErrSis(array('p'=>$insertSQL, 'd'=>$__cnx->c_p->error));
		}
}

// Modificación de Registro
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdAtmtTrgrCndc")) { 
	
	 if(!isN($_POST['atmttrgrcndc_hbl'])){ $_hbl=$_POST['v']; }else{ $_hbl=2; }
	
	$updateSQL = sprintf("UPDATE "._BdStr(DBA).TB_ATMT_TRGR_CNDC." SET atmttrgrcndc_cndc=%s, atmttrgrcndc_hbl=%s, atmttrgrcndc_v_vl=%s WHERE atmttrgrcndc_enc=%s",			
	                    GtSQLVlStr($_POST['atmttrgrcndc_cndc'], "int"),
						GtSQLVlStr(Html_chck_vl($_POST['atmttrgrcndc_hbl']), "int"),
						GtSQLVlStr(ctjTx($_POST['atmttrgrcndc_v_vl'],'out'), "text"),
	                    GtSQLVlStr(ctjTx($_POST['atmttrgrcndc_enc'],'out'), "text"));
	 
	$Result = $__cnx->_prc($updateSQL);

	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['w'] = $__cnx->c_p->error;
		_ErrSis(array('p'=>$updateSQL, 'd'=>$__cnx->c_p->error));
	} 
}

// Elimino el Registro
if (((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdAtmtTrgrCndc'))){ 
	$deleteSQL = sprintf('DELETE FROM '._BdStr(DBA).TB_ATMT_TRGR_CNDC.' WHERE atmttrgrcndc_enc=%s', GtSQLVlStr($_POST['uid'], 'text'));
	 $Result = $__cnx->_prc($deleteSQL); if($Result){$rsp['e'] = 'ok'; $rsp['m'] = 1; 
	//$rsp['a'] = Aud_Sis(Aud_Dsc(258, $_POST['atmttrgract_v_ls'], $_POST['id_atmttrgract']), $rsp['v']);
	 }else{ $rsp['e'] = 'no'; $rsp['m'] = 2; _ErrSis(array('p'=>$deleteSQL, 'd'=>$__cnx->c_p->error));}
}
?>