<?php 
// Ingreso de Registro
if (!isN($_POST["MM_insert"]) && ($_POST["MM_insert"] == "EdMdlGen")) { 
	
	$__enc = Enc_Rnd($_POST['mdlgen_tt'].'-'.$_POST['mdlgen_tp']);
	
	$insertSQL = sprintf("INSERT INTO ".TB_MDL_GEN." (mdlgen_enc, mdlgen_lnd, mdlgen_tp, mdlgen_tt, mdlgen_pml, mdlgen_s_ph, mdlgen_all) VALUES (%s, %s, %s, %s, %s, %s, %s)",                    
					   GtSQLVlStr($__enc, "text"),
					   GtSQLVlStr($_POST['mdlgen_lnd'], "int"),
					   GtSQLVlStr($_POST['mdlgen_tp'], "int"),											
					   GtSQLVlStr(ctjTx($_POST['mdlgen_tt'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['mdlgen_pml'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['mdlgen_s_ph'],'out'), "text"),
					   GtSQLVlStr($_POST['mdlgen_all'], "int"));	
					   		
	
	$Result = $__cnx->_prc($insertSQL);
	
	if($Result){

		$rsp['i'] = $__cnx->c_p->insert_id;
		$rsp['e'] = 'ok';
		$rsp['enc'] = $__enc;
		$rsp['m'] = 1;
		$rsp['a'] = Aud_Sis(Aud_Dsc(332, $_POST['mdlgen_tt'], $__cnx->c_p->insert_id), $rsp['v']);
		
		if(!isN($_POST['mdlgen_mdlstp'])){
				
			$__enc = Enc_Rnd($__cnx->c_p->insert_id.'-'.$_POST['mdlgentp_mdlstp']);
			
			$insertSQL = sprintf("INSERT INTO ".TB_MDL_GEN_TP." (mdlgentp_enc, mdlgentp_mdlgen, mdlgentp_mdlstp) VALUES (%s, %s, %s)",                    
					   GtSQLVlStr($__enc, "text"),
					   GtSQLVlStr($__cnx->c_p->insert_id, "int"),
					   GtSQLVlStr($_POST['mdlgen_mdlstp'], "int"));
					   
			$Result = $__cnx->_prc($insertSQL);
			$rsp['ed'] = $insertSQL;
		}
								
	}else{
		$rsp['e'] = 'no';
		$rsp['er'] = $__cnx->c_p->error;
		$rsp['m'] = 2;
	}
}

// Modificación de Registro
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdMdlGen")) { 
	
	$updateSQL = sprintf("UPDATE ".TB_MDL_GEN." SET mdlgen_lnd=%s, mdlgen_tp=%s, mdlgen_tt=%s, mdlgen_pml=%s, mdlgen_s_ph=%s, mdlgen_all=%s, mdlgen_s3='2' WHERE mdlgen_enc=%s",
						   GtSQLVlStr($_POST['mdlgen_lnd'], "int"),
						   GtSQLVlStr($_POST['mdlgen_tp'], "int"),
						   GtSQLVlStr(ctjTx($_POST['mdlgen_tt'],'out'), "text"),	
						   GtSQLVlStr(ctjTx($_POST['mdlgen_pml'],'out'), "text"),
						   GtSQLVlStr(ctjTx($_POST['mdlgen_s_ph'],'out'), "text"),
						   GtSQLVlStr($_POST['mdlgen_all'], "int"),
	                       GtSQLVlStr($_POST['mdlgen_enc'], "text"));				   
	
	$Result = $__cnx->_prc($updateSQL);
	
	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		//$rsp['a'] = Aud_Sis(Aud_Dsc(333, $_POST['mdlgen_tt'], $_POST['id_mdlgen']), $rsp['v']);

	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['w'] = $__cnx->c_p->error;
	} 
}

// Elimino el Registro
if ((isset($_POST['id_mdlgen'])) && ($_POST['id_mdlgen'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdMdlGen'))) { 
	$deleteSQL = sprintf("DELETE FROM ".TB_MDL_GEN." WHERE id_mdlgen=%s", GtSQLVlStr($_POST['id_mdlgen'], 'int'));
	$Result = $__cnx->_prc($deleteSQL); if($Result){$rsp['e'] = 'ok'; $rsp['m'] = 1; $rsp['a'] = Aud_Sis(Aud_Dsc(334, $_POST['mdlgen_tt'], $_POST['id_mdlgen']), $rsp['v']);}else{$rsp['e'] = 'no';$rsp['m'] = 2;}
}
?>