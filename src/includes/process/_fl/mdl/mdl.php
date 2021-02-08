<?php
	
// Ingreso de Registro
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdMdl")) { 
	
	$__enc = Enc_Rnd($_POST['mdl_nm'].'-'.$_POST['mdl_mdls']);
	
	if(isN($_POST['mdl_id'])){
		$__mdl_id = Gn_Rnd(4);
	}else{
		$__mdl_id = $_POST['mdl_id'];
	}
	
	if(!isN($_POST['mdl_mdlstp'])){
		$__mdl_mdlstp = $_POST['mdl_mdlstp'];
	}else{
		$__mdl_mdlstp = "";
	}
	
	if(!isN($_POST['mdl_est'])){ $_est = $_POST['mdl_est']; }else{ $_est = _CId('ID_SISMDLEST_ACTV'); }
		
	$insertSQL = sprintf("INSERT INTO ".TB_MDL." (mdl_enc, mdl_lnd, mdl_est, mdl_nm, mdl_pml, mdl_id, mdl_mdls, mdl_mdlstp) VALUES (%s, %s, %s, %s, %s, %s, %s, (SELECT id_mdlstp FROM ".DBM."._mdl_s_tp WHERE mdlstp_tp = %s))",
                   GtSQLVlStr($__enc, "text"),
                   GtSQLVlStr($_POST['mdl_lnd'], "int"),
                   GtSQLVlStr($_est, "int"),
                   GtSQLVlStr(ctjTx($_POST['mdl_nm'],'out'), "text"),
                   GtSQLVlStr(ctjTx($_POST['mdl_pml'],'out'), "text"),
                   GtSQLVlStr(ctjTx($__mdl_id,'out'), "text"),
				   GtSQLVlStr($_POST['mdl_mdls'], "int"),
				   GtSQLVlStr($__mdl_mdlstp, "text"));
				   
	
	$Result = $__cnx->_prc($insertSQL);
	
	if($Result){
		//$rsp['i'] = $__cnx->c_p->insert_id;
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		//Aud_Sis(Aud_Dsc(23, $_POST['mdl_nm'], $__cnx->c_p->insert_id), $rsp['v']);
		$_POST['id_mdl'] = $__cnx->c_p->insert_id;
		$_Crm_Aud->In_Aud([ 'aud'=>_Cns('ID_AUDDSC_MDL_ING'), "db"=>TB_MDL, "post"=>$_POST ]);

	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['w'] = $__cnx->c_p->error;
		$rsp['qry'] = $insertSQL;
		_ErrSis(['p'=>$insertSQL, 'd'=>$__cnx->c_p->error]);
	}
}

// Modificación de Registro
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdMdl")) { 
	
	$__dt = GtMdlDt([ 't'=>'enc', 'id'=>$_POST['mdl_enc']]);
	
	if(!isN($__dt->id)){
		
		if(!isN($_POST['mdl_est'])){ $_est = $_POST['mdl_est']; }else{ $_est = _CId('ID_SISMDLEST_ACTV'); }
			
		$updateSQL = sprintf("UPDATE ".TB_MDL." SET mdl_lnd=%s, mdl_nm=%s, mdl_est=%s, mdl_pml=%s, mdl_id=%s, mdl_mdls=%s, mdl_s3='2' WHERE id_mdl=%s",
							GtSQLVlStr($_POST['mdl_lnd'], "int"),
							GtSQLVlStr(ctjTx($_POST['mdl_nm'],'out'), "text"),
							GtSQLVlStr($_est, "int"),
							GtSQLVlStr(ctjTx($_POST['mdl_pml'],'out'), "text"),
							GtSQLVlStr(ctjTx($_POST['mdl_id'],'out'), "text"),
						    GtSQLVlStr($_POST['mdl_mdls'], "int"),
							GtSQLVlStr($__dt->id, "int"));
		
		$Result = $__cnx->_prc($updateSQL); 
		
		if($Result){
			//$rsp['enc'] = $_POST['mdl_enc'];
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
			//Aud_Sis(Aud_Dsc(24, $_POST['mdl_nm'], $__cnx->c_p->insert_id), $rsp['v']);
			$_POST['id_mdl'] = $__dt->id;
			$_Crm_Aud->In_Aud([ 'aud'=>_Cns('ID_AUDDSC_MDL_MOD'), "db"=>TB_MDL, "post"=>$_POST ]);
		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			$rsp['w'] = $__cnx->c_p->error;
			_ErrSis(['p'=>$updateSQL, 'd'=>$__cnx->c_p->error]);
		}
	
	} 
	
}

// Elimino el Registro
if ((isset($_POST['uid'])) && !isN($_POST['uid']) && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdMdl'))) { 
	
	$__dt = GtMdlDt([ 't'=>'enc', 'id'=>$_POST['uid'] ]);
	
	if(!isN($__dt->id)){
		$deleteSQL = sprintf('DELETE FROM '.TB_MDL.' WHERE mdl_enc=%s', GtSQLVlStr($_POST['uid'], 'text'));
		$Result = $__cnx->_prc($deleteSQL);
		if($Result){ 
			$rsp['e'] = 'ok'; $rsp['m'] = 1; Aud_Sis(Aud_Dsc(25, $_POST['mdl_nm'], $__cnx->c_p->insert_id), $rsp['v']);
		}else{
			$rsp['e'] = 'no'; $rsp['m'] = 2; _ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]); $rsp['w'] = $__cnx->c_p->error;
		}
	}
	
}
?>