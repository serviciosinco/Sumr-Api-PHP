<?php
	
$__snd = new API_CRM_Snd();
	
	
if(!isN($___Prc->mdlstp)){
	$__rlc_tp = 'ok';
	$__rlc_id = $___Prc->mdlstp;
}	

	
// Ingreso de Registro
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdSndEcCmpg")) { 
	
	if(!isN($_POST['eccmpg_sndr'])){ $__siseml = __LsDt([ 'k'=>'sis_eml', 'id'=>$_POST['eccmpg_sndr'], 'tp'=>'enc' ]); }
	if(!isN($_POST['eccmpg_ec'])){ $__dtec = GtEcDt($_POST['eccmpg_ec'], 'enc'); }
	if(!isN($_POST['eccmpg_lsts'])){ $__dtec_lsts = GtEcLstsDt([ 'id'=>$_POST['eccmpg_lsts'], 't'=>'enc' ]); }
	if(!isN($_POST['eccmpg_eml'])){ $__sndreml = GtEmlDt([ 'id'=>$_POST['eccmpg_eml'], 't'=>'enc' ]); }

		
	if(Php_Ls_Cln($_POST['eccmpg_est_c']) == _CId('ID_ECCMPGEST_SNDIN')){ 
		$_est = _CId('ID_ECCMPGEST_SNDIN');
	}elseif(_ChckMd('snd_noaprb')){
		$_est = _CId('ID_ECCMPGEST_APRBD'); 
	}else{ 
		$_est = _CId('ID_ECCMPGEST_PSD'); 
	}
	
	
	$__cmpg_enc = Enc_Rnd(DB_CL_ENC.'-'.$_POST['eccmpg_nm']);
	
	
	$insertSQL = sprintf("INSERT INTO "._BdStr(DBM).TB_EC_CMPG." (eccmpg_enc, eccmpg_cl, eccmpg_nm, eccmpg_tp, eccmpg_sbj, eccmpg_prhdr, eccmpg_frm, eccmpg_opn, eccmpg_ec, eccmpg_sndr, eccmpg_eml, eccmpg_p_f, eccmpg_p_h, eccmpg_p_fe, eccmpg_p_he, eccmpg_scl, eccmpg_tll, eccmpg_rply, eccmpg_est, eccmpg_out_lsts, eccmpg_us) VALUES (%s, (SELECT id_cl FROM "._BdStr(DBM).TB_CL." WHERE cl_enc = %s), %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
				   GtSQLVlStr(ctjTx($__cmpg_enc,'out'), "text"),
				   GtSQLVlStr(DB_CL_ENC, "text"),
				   GtSQLVlStr(ctjTx($_POST['eccmpg_nm'],'out'), "text"),
				   GtSQLVlStr($_POST['eccmpg_tp'], "int"),
				   GtSQLVlStr(trim( ctjTx($_POST['eccmpg_sbj'],'out') ), "text"),
				   GtSQLVlStr(ctjTx($_POST['eccmpg_prhdr'],'out'), "text"),
				   GtSQLVlStr(ctjTx($_POST['eccmpg_frm'],'out'), "text"),
				   GtSQLVlStr(Html_chck_vl($_POST['eccmpg_opn']), "int"),
				   GtSQLVlStr($__dtec->id, "int"),
				   GtSQLVlStr($__siseml->d->id, "int"),
				   GtSQLVlStr($__sndreml->id, "int"),
				   GtSQLVlStr($_POST['eccmpg_p_f'], "date"),
				   GtSQLVlStr($_POST['eccmpg_p_h'], "date"),
				   GtSQLVlStr($_POST['eccmpg_p_fe'], "date"),
				   GtSQLVlStr($_POST['eccmpg_p_he'], "date"),
				   GtSQLVlStr(_NoNll(Html_chck_vl($_POST['eccmpg_scl'])) , "int"),
				   GtSQLVlStr(_NoNll(Html_chck_vl($_POST['eccmpg_tll'])) , "int"),
				   GtSQLVlStr(ctjTx($_POST['eccmpg_rply'],'out'), "text"),
				   GtSQLVlStr($_est , "int"),
				   GtSQLVlStr(ctjTx($_POST['eccmpg_out_lsts'],'out'), "text"),
				   GtSQLVlStr(SISUS_ID , "int"));
	
	
	//$rsp['q'] = $insertSQL;
				   	
	
	$Result = $__cnx->_prc($insertSQL);
		
	if($Result){
 		
 		$_POST['id_eccmpg'] = $__i = $__cnx->c_p->insert_id;
 		
 		$_Crm_Aud->In_Aud([ "aud"=>_CId('ID_AUDDSC_CMPG'), "db"=>$__t, "post"=>$_POST ]);
 		
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		
		
		//-------------- RELACIONES DE REGISTRO --------------//
		
		
			if(!isN($__i) && !isN($__dtec_lsts->id)){
				$insertSQL = sprintf("INSERT INTO "._BdStr(DBM).TB_EC_CMPG_LSTS." (eccmpglsts_enc, eccmpglsts_lsts, eccmpglsts_cmpg) VALUES (%s, %s, %s)",
							   GtSQLVlStr(Enc_Rnd($__dtec_lsts->id.'-'.$__i), "text"),
							   GtSQLVlStr($__dtec_lsts->id, "int"),
							   GtSQLVlStr($__i, "int"));				   	
				$Result = $__cnx->_prc($insertSQL);
			}
			
			
			if(!isN($__i) && !isN($_POST['ec_lsts_sgm'])){
				
				foreach($_POST['ec_lsts_sgm'] as $__sgm_k=>$__sgm_v){
					
					$__dtec_lsts_sgm = GtEcLstsSgmDt([ 'id'=>$__sgm_v, 't'=>'enc', 'd'=>[ 'var'=>'ok' ] ]);
				
					if(!isN($__dtec_lsts_sgm->id)){
						
						$insertSQL = sprintf("INSERT INTO "._BdStr(DBM).TB_EC_CMPG_SGM." (eccmpgsgm_enc, eccmpgsgm_sgm, eccmpgsgm_cmpg) VALUES (%s, %s, %s)",
									   GtSQLVlStr(Enc_Rnd($__dtec_lsts_sgm->id.'-'.$__i), "text"),
									   GtSQLVlStr($__dtec_lsts_sgm->id, "int"),
									   GtSQLVlStr($__i, "int"));
						$Result = $__cnx->_prc($insertSQL);
					
					}	

				}
				
			}
			
			if(!isN($__i) && !isN($__rlc_id->id)){
				
				$insertSQL = sprintf("INSERT INTO "._BdStr(DBM).TB_EC_CMPG_TP." (eccmpgtp_enc, eccmpgtp_cmpg, eccmpgtp_tp) VALUES (%s, %s, %s)",
							   GtSQLVlStr(Enc_Rnd($__rlc_id->id.'-'.$__i), "text"),
							   GtSQLVlStr($__i, "int"),
							   GtSQLVlStr($__rlc_id->id, "int"));				   	
				$Result = $__cnx->_prc($insertSQL);
				
			}
		
		
		//--------------------------- Actualizo Totales de acuerdo a parametros ---------------------------//
		
				
			$__cmpg_dt = GtEcCmpgDt(['id'=>$__i, 'sgm'=>'ok', 'sgm'=>['e'=>'ok'], 'lsts'=>['e'=>'ok'] ]);
			
			$__snd->eccmpg_enc = $__cmpg_dt->enc;
			$__snd->eccmpg_tot_lds = $__cmpg_dt->eml_allw;
			$__snd->eccmpg_tot_nallw = $__cmpg_dt->eml_noallw->all;
			
			
			$rsp['dt'] = $__cmpg_dt;
			$rsp['upd'] = $__snd->_ec_cmpg_upd();
		
		
		//-------------- ENVIA CORREO DE ACUERDO A FLUJO INSCRITO --------------//
		
		
		if(!_ChckMd('snd_noaprb')){		
			$__Cl = new CRM_Cl();
			$__Cl->clflj_t = 'cmpg_new'; 
			$__Cl->clflj_mre->ec_cmpg = $__cmpg_enc;
			$rsp['flj'] = $__Cl->__flj();
		}
		
		
		
	}else{
		
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['w'] = 'Error:'.$__cnx->c_p->error;
		_ErrSis([ 'p'=>$insertSQL, 'd'=>$__cnx->c_p->error ]);
		
	}
}

// Modificación de Registro
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdSndEcCmpg")) { 
	
	$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_EC_CMPG." SET 
								eccmpg_opn=%s, eccmpg_p_fe=%s, eccmpg_p_he=%s WHERE  id_eccmpg=%s",	
						GtSQLVlStr(Html_chck_vl($_POST['eccmpg_opn']), "int"),
						GtSQLVlStr($_POST['eccmpg_p_fe'], "date"),
						GtSQLVlStr($_POST['eccmpg_p_he'], "date"),
						GtSQLVlStr($_POST['id_eccmpg'], "int"));
	
	$Result = $__cnx->_prc($updateSQL); 

	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		$rsp['a'] = Aud_Sis(Aud_Dsc(254, $_POST['eccmpg_nm'], $_POST['id_eccmpg']), $rsp['v']);
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['w'] = $__cnx->c_p->error;
		_ErrSis([ 'p'=>$updateSQL, 'd'=>$__cnx->c_p->error ]);
	} 
}

// Elimino el Registro
if ((isset($_POST['uid'])) && !isN($_POST['uid']) && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdSndEcCmpg'))) { 
	
	$__cl = GtClDt(CL_ENC, 'enc');

	$deleteSQL = sprintf("DELETE ec_s FROM ".$__cl->bd.".".TB_EC_SND." ec_s 
							INNER JOIN ".$__cl->bd.".".TB_EC_SND_CMPG." ON ecsndcmpg_snd = id_ecsnd 
							INNER JOIN "._BdStr(DBM).TB_EC_CMPG." ON ecsndcmpg_cmpg = id_eccmpg 
						WHERE eccmpg_enc = %s", 
						GtSQLVlStr($_POST['uid'], 'text'));

	
	$Result = $__cnx->_prc($deleteSQL);
	
	if($Result){
		$__cmpg_dt = GtEcCmpgDt(['id'=>$_POST['uid'], 't'=>'enc' ]);	
		$__cmpg_id = $__cmpg_dt->id; 

		$deleteSQL1 = sprintf('DELETE FROM '._BdStr(DBM).TB_EC_CMPG.' WHERE eccmpg_enc=%s', GtSQLVlStr($_POST['uid'], 'text')); 
		$Result1 = $__cnx->_prc($deleteSQL1);
		
		if($Result1){
			$rsp['e'] = 'ok'; 
			$rsp['m'] = 1; 											
			$_Crm_Aud->In_Aud([ 'aud'=>_CId('ID_AUDDSC_CMPG_ELI'), "db"=>TB_EC_SND, "iddb"=>$__cmpg_id, "post"=>$_POST]);
		}else{
			$rsp['e'] = 'no'; 
			$rsp['m'] = 2; 
			$rsp['error'] = $__cnx->c_p->error; 
			_ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);	
		}
		
	}else{ 	
		$rsp['e'] = 'no'; 
		$rsp['m'] = 2; 
		$rsp['error'] = $__cnx->c_p->error; 
		_ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);
	}
}


// Pausa de estado
if ((isset($_POST["MMM_update_est"])) && ($_POST["MMM_update_est"] == "EdSndEcCmpg")) { 
	
	$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_EC_CMPG." SET eccmpg_est=%s, eccmpg_nprb_dsc=%s WHERE eccmpg_enc=%s",						
						GtSQLVlStr($_POST['eccmpg_est'], "int"),
						GtSQLVlStr(ctjTx($_POST['eccmpg_nprb_dsc'],'out'), "text"),
						GtSQLVlStr($_POST['eccmpg_enc'], "text"));            
	
	$Result = $__cnx->_prc($updateSQL); 
	
	if($Result){
		
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;

		$_Crm_Aud->In_Aud([ "aud"=>2368, "db"=>$__t, "post"=>$_POST ]);

		//$rsp['a'] = Aud_Sis(Aud_Dsc(255, $_POST['eccmpg_nm'], $_POST['id_eccmpg']), $rsp['v']);
		
		$rsp['est'] = __LsDt([ 'k'=>'ec_cmpg_est', 'id'=>$_POST['eccmpg_est'], 'no_lmt'=>'ok' ]); 
		
		
		if($_POST['eccmpg_est'] == _CId('ID_ECCMPGEST_APRBD')){
			
			$__Cl = new CRM_Cl();
			$__Cl->clflj_t = 'cmpg_aprb'; 
			$__Cl->clflj_mre->ec_cmpg = $_POST['eccmpg_enc'];
			$rsp['flj'] = $__Cl->__flj();	
			
		}elseif($_POST['eccmpg_est'] == _CId('ID_ECCMPGEST_NAPRBD')){
			
			$__Cl = new CRM_Cl();
			$__Cl->clflj_t = 'cmpg_aprb_no'; 
			$__Cl->clflj_mre->ec_cmpg = $_POST['eccmpg_enc'];
			$rsp['flj'] = $__Cl->__flj();	
			
		}
		
		
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		//$rsp['qr'] = $updateSQL;
		$rsp['w'] = $__cnx->c_p->error;
		_ErrSis([ 'p'=>$updateSQL, 'd'=>$__cnx->c_p->error ]);
	} 
}


// Cambio de fecha en campañas abiertas
if ((isset($_POST["MMM_update_opn"])) && ($_POST["MMM_update_opn"] == "EdSndEcCmpg")) { 
	
	$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_EC_CMPG." SET eccmpg_p_fe=%s, eccmpg_p_he=%s WHERE id_eccmpg=%s",						
						GtSQLVlStr($_POST['_fe'], "date"),
						GtSQLVlStr($_POST['_he'], "date"),
						GtSQLVlStr($_POST['id_eccmpg'], "int"));
    
	
	$Result = $__cnx->_prc($updateSQL); 

	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		//$rsp['a'] = Aud_Sis(Aud_Dsc(255, $_POST['eccmpg_nm'], $_POST['id_eccmpg']), $rsp['v']);
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['w'] = $__cnx->c_p->error;
		_ErrSis([ 'p'=>$updateSQL, 'd'=>$__cnx->c_p->error ]);
	} 
}


// Cambio de estado en campañas abiertas
if ((isset($_POST["MMM_update_opn_est"])) && ($_POST["MMM_update_opn_est"] == "EdSndEcCmpg")) { 
	
	if($_POST['_est_cmpg'] == 'ok'){
		$_fl = ', eccmpg_est = '._CId('ID_ECCMPGEST_SNDIN');	
	}
	
	$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_EC_CMPG." SET eccmpg_opn=%s ".$_fl." WHERE id_eccmpg=%s",						
						GtSQLVlStr($_POST['_est'], "int"),
						GtSQLVlStr($_POST['id_eccmpg'], "int"));
           
	
	$Result = $__cnx->_prc($updateSQL); 

	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		//$rsp['a'] = Aud_Sis(Aud_Dsc(255, $_POST['eccmpg_nm'], $_POST['id_eccmpg']), $rsp['v']);
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['w'] = $__cnx->c_p->error;
		_ErrSis(array('p'=>$updateSQL, 'd'=>$__cnx->c_p->error));
	} 
}


// Cambio de sender en campañas 
if ((isset($_POST["MMM_update_sndr"])) && ($_POST["MMM_update_sndr"] == "EdSndEcCmpg")) { 
	
	$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_EC_CMPG." SET eccmpg_sndr=%s WHERE eccmpg_enc = %s",						
						GtSQLVlStr($_POST['eccmpg_sndr'], "int"),
						GtSQLVlStr($_POST['eccmpg_enc'], "text"));
           
	
	$Result = $__cnx->_prc($updateSQL); 

	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		$rsp['nm'] = __LsDt([ 'k'=>'sis_eml'])->ls->sis_eml->{$_POST['eccmpg_sndr']}->tt;
		//$rsp['a'] = Aud_Sis(Aud_Dsc(255, $_POST['eccmpg_nm'], $_POST['id_eccmpg']), $rsp['v']);
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['w'] = $__cnx->c_p->error;
		_ErrSis(array('p'=>$updateSQL, 'd'=>$__cnx->c_p->error));
	} 
}

// Cambio de fecha dia promanado en campañas 
if ((isset($_POST["MMM_update_f_eccmp"])) && ($_POST["MMM_update_f_eccmp"] == "EdSndEcCmpg")) { 
	
	$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_EC_CMPG." SET eccmpg_p_f=%s WHERE eccmpg_enc=%s",						
						GtSQLVlStr($_POST['eccmpg_p_f'], "date"),
						GtSQLVlStr($_POST['eccmpg_enc'], "text"));

	$Result = $__cnx->_prc($updateSQL); 

	if($Result){
		
		$cl = GtClDt(DB_CL_ENC, 'enc');

		$updateSQL1 = sprintf("	UPDATE ".$cl->bd.".".TB_EC_SND." 
										INNER JOIN ".$cl->bd.".".TB_EC_SND_CMPG." ON id_ecsnd = ecsndcmpg_snd 
										INNER JOIN "._BdStr(DBM).TB_EC_CMPG." ON id_eccmpg = ecsndcmpg_cmpg 
								SET ecsnd_f = %s 
								WHERE eccmpg_enc = %s ", GtSQLVlStr($_POST['eccmpg_p_f'], "date"), GtSQLVlStr($_POST['eccmpg_enc'], "text") 
							);
									
		$Result1 = $__cnx->_prc($updateSQL1); 
		
		if($Result1){

			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
			$rsp['nm'] = FechaESP_OLD($_POST['eccmpg_p_f']);
			
			$_Crm_Aud->In_Aud([ 'aud'=>_Cns('ID_AUDDSC_ECCMPG_P_F'), "db"=>$__t, "post"=>$_POST ]);

		}else{
			$rsp['e'] = 'no';
			$rsp['w'] = $__cnx->c_p->error;
		}
		
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['w'] = $__cnx->c_p->error;
		_ErrSis(array('p'=>$updateSQL, 'd'=>$__cnx->c_p->error));
	} 
}

// Cambio de hora dia promanado en campañas 
if ((isset($_POST["MMM_update_h_eccmp"])) && ($_POST["MMM_update_h_eccmp"] == "EdSndEcCmpg")) { 
	
	$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_EC_CMPG." SET eccmpg_p_h=%s WHERE eccmpg_enc = %s",						
						GtSQLVlStr($_POST['eccmpg_p_h'], "date"),
						GtSQLVlStr($_POST['eccmpg_enc'], "text"));
         
	
	$Result = $__cnx->_prc($updateSQL); 

	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		$rsp['nm'] = $_POST['eccmpg_p_h'];
		$_Crm_Aud->In_Aud([ "aud"=>2370, "db"=>$__t, "post"=>$_POST ]);
		
		$cl = GtClDt(DB_CL_ENC, 'enc');
		
		$updateSQL1 = sprintf("UPDATE ".$cl->bd.".".TB_EC_SND." 
										INNER JOIN ".$cl->bd.".".TB_EC_SND_CMPG." ON id_ecsnd = ecsndcmpg_snd 
										INNER JOIN "._BdStr(DBM).TB_EC_CMPG." ON id_eccmpg = ecsndcmpg_cmpg 
									SET ecsnd_h = %s 
									WHERE eccmpg_enc = %s ", GtSQLVlStr($_POST['eccmpg_p_h'], "date"), GtSQLVlStr($_POST['eccmpg_enc'], "text") );
									
		
		$Result1 = $__cnx->_prc($updateSQL1); 
		if($Result1){
			$rsp['e'] = 'ok';
		}else{
			$rsp['e'] = 'no';
			$rsp['w'] = $__cnx->c_p->error;
		}
		
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['w'] = $__cnx->c_p->error;
		_ErrSis(array('p'=>$updateSQL, 'd'=>$__cnx->c_p->error));
	}
}

// Cambio de Reply To programado en campañas 
if ((isset($_POST["MMM_update_rply_eccmp"])) && ($_POST["MMM_update_rply_eccmp"] == "EdSndEcCmpg")) { 
	
	$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_EC_CMPG." SET eccmpg_rply=%s WHERE eccmpg_enc = %s",						
						GtSQLVlStr($_POST['eccmpg_rply'], "date"),
						GtSQLVlStr($_POST['eccmpg_enc'], "text"));
         
	
	$Result = $__cnx->_prc($updateSQL); 

	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		$rsp['nm'] = $_POST['eccmpg_rply'];									
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['w'] = $__cnx->c_p->error;
		_ErrSis(array('p'=>$updateSQL, 'd'=>$__cnx->c_p->error));
	}
}

// Cambio de Reply To programado en campañas 
if ((isset($_POST["MMM_update_sbj_eccmp"])) && ($_POST["MMM_update_sbj_eccmp"] == "EdSndEcCmpg")) { 
	
	$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_EC_CMPG." SET eccmpg_sbj=%s WHERE eccmpg_enc = %s",						
						GtSQLVlStr($_POST['eccmpg_sbj'], "date"),
						GtSQLVlStr($_POST['eccmpg_enc'], "text"));
         
	
	$Result = $__cnx->_prc($updateSQL); 

	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		$rsp['nm'] = $_POST['eccmpg_sbj'];									
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['w'] = $__cnx->c_p->error;
		_ErrSis(array('p'=>$updateSQL, 'd'=>$__cnx->c_p->error));
	}
}

?>