<?php 

       
	if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdOrgSds")) { 
		
		$__enc = Enc_Rnd($_POST['orgsds_org']."-".$_POST['orgsds_nm']);
		
		$insertSQL = sprintf("INSERT INTO "._BdStr(DBM).TB_ORG_SDS." 
													(
														orgsds_enc, 
														orgsds_org, 
														orgsds_nm, 
														orgsds_dir,
														orgsds_cd,
														orgsds_rsp,
														orgsds_jrd_mna,
														orgsds_jrd_trd,
														orgsds_jrd_nch,
														orgsds_jrd_cmp,
														orgsds_jrd_sbt,
														orgsds_jrd_unc,
														orgsds_jrd_con,
														orgsds_cln,
														orgsds_sx,
														orgsds_grd,
														orgsds_est,
														orgsds_g_lat,
														orgsds_g_lng,
														orgsds_g_zom,
														orgsds_g_pov_lat,
														orgsds_g_pov_lon,
														orgsds_g_pov_hed,
														orgsds_g_pov_ptc,
														orgsds_g_pov_zom
													) 
														VALUES 
													(
														%s,
														( SELECT id_org FROM "._BdStr(DBM).TB_ORG." WHERE org_enc=%s), 
														%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s
													) 
						",
	                	GtSQLVlStr(ctjTx($__enc, 'out'), "text"),
	                	GtSQLVlStr($_POST['orgsds_org'], "text"),
	                	GtSQLVlStr(ctjTx($_POST['orgsds_nm'], 'out'), "text"),
	                	GtSQLVlStr(ctjTx($_POST['orgsds_dir'], 'out'), "text"),
	                	GtSQLVlStr($_POST["orgsds_cd"], "int"),
	                	GtSQLVlStr($_POST["orgsds_rsp"], "int"),
	                	GtSQLVlStr(Html_chck_vl($_POST['orgsds_jrd_mna']), "int"),
                        GtSQLVlStr(Html_chck_vl($_POST['orgsds_jrd_trd']), "int"),
                        GtSQLVlStr(Html_chck_vl($_POST['orgsds_jrd_nch']), "int"),
                        GtSQLVlStr(Html_chck_vl($_POST['orgsds_jrd_cmp']), "int"),
                        GtSQLVlStr(Html_chck_vl($_POST['orgsds_jrd_sbt']), "int"),
                        GtSQLVlStr(Html_chck_vl($_POST['orgsds_jrd_unc']), "int"),
                        GtSQLVlStr(Html_chck_vl($_POST['orgsds_jrd_con']), "int"),
	                	GtSQLVlStr($_POST["orgsds_cln"], "int"),
	                	GtSQLVlStr($_POST["orgsds_sx"], "int"),
	                	GtSQLVlStr($_POST["orgsds_grd"], "int"),
	                	GtSQLVlStr($_POST["orgsds_est"], "int"),
	                	GtSQLVlStr(ctjTx($_POST["orgsds_g_lat"], 'out'), "text"),
	                	GtSQLVlStr(ctjTx($_POST["orgsds_g_lng"], 'out'), "text"),
	                	GtSQLVlStr(ctjTx($_POST["orgsds_g_zom"], 'out'), "text"),
	                	GtSQLVlStr(ctjTx($_POST["orgsds_g_pov_lat"], 'out'), "text"),
	                	GtSQLVlStr(ctjTx($_POST["orgsds_g_pov_lon"], 'out'), "text"),
	                	GtSQLVlStr(ctjTx($_POST["orgsds_g_pov_hed"], 'out'), "text"),
	                	GtSQLVlStr(ctjTx($_POST["orgsds_g_pov_ptc"], 'out'), "text"),
	                	GtSQLVlStr(ctjTx($_POST["orgsds_g_pov_zom"], 'out'), "text")
                	);
			
			
		$Result = $__cnx->_prc($insertSQL);
 		if($Result){
	 		
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
			$_id = $__cnx->c_p->insert_id;
			
		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			$rsp['hoa'] = $insertSQL;
			_ErrSis(['p'=>$insertSQL, 'd'=>$__cnx->c_p->error]);
		}
		
	}

	// Modificación de Registro primero este
	if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdOrgSds")) {
		$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_ORG_SDS." SET 
											orgsds_nm=%s, orgsds_dir=%s,
											orgsds_cd=%s, orgsds_rsp=%s,
											orgsds_jrd_mna=%s, orgsds_jrd_trd=%s,
											orgsds_jrd_nch=%s, orgsds_jrd_cmp=%s,
											orgsds_jrd_sbt=%s, orgsds_jrd_unc=%s,
											orgsds_jrd_con=%s, orgsds_cln=%s,
											orgsds_sx=%s, orgsds_grd=%s,
											orgsds_est=%s, orgsds_g_lat=%s,
											orgsds_g_lng=%s, orgsds_g_zom=%s,
											orgsds_g_pov_lat=%s, orgsds_g_pov_lon=%s,
											orgsds_g_pov_hed=%s, orgsds_g_pov_ptc=%s,
											orgsds_g_pov_zom=%s
											WHERE orgsds_enc=%s
							",
							GtSQLVlStr(ctjTx($_POST['orgsds_nm'], 'out'), "text"),
							GtSQLVlStr(ctjTx($_POST['orgsds_dir'], 'out'), "text"),
							GtSQLVlStr($_POST["orgsds_cd"], "int"),
							GtSQLVlStr($_POST["orgsds_rsp"], "int"),
							GtSQLVlStr(Html_chck_vl($_POST['orgsds_jrd_mna']), "int"),
							GtSQLVlStr(Html_chck_vl($_POST['orgsds_jrd_trd']), "int"),
							GtSQLVlStr(Html_chck_vl($_POST['orgsds_jrd_nch']), "int"),
							GtSQLVlStr(Html_chck_vl($_POST['orgsds_jrd_cmp']), "int"),
							GtSQLVlStr(Html_chck_vl($_POST['orgsds_jrd_sbt']), "int"),
							GtSQLVlStr(Html_chck_vl($_POST['orgsds_jrd_unc']), "int"),
							GtSQLVlStr(Html_chck_vl($_POST['orgsds_jrd_con']), "int"),
							GtSQLVlStr($_POST["orgsds_cln"], "int"),
							GtSQLVlStr($_POST["orgsds_sx"], "int"),
							GtSQLVlStr($_POST["orgsds_grd"], "int"),
							GtSQLVlStr($_POST["orgsds_est"], "int"),
							GtSQLVlStr(ctjTx($_POST["orgsds_g_lat"], 'out'), "text"),
							GtSQLVlStr(ctjTx($_POST["orgsds_g_lng"], 'out'), "text"),
							GtSQLVlStr(ctjTx($_POST["orgsds_g_zom"], 'out'), "text"),
							GtSQLVlStr(ctjTx($_POST["orgsds_g_pov_lat"], 'out'), "text"),
							GtSQLVlStr(ctjTx($_POST["orgsds_g_pov_lon"], 'out'), "text"),
							GtSQLVlStr(ctjTx($_POST["orgsds_g_pov_hed"], 'out'), "text"),
							GtSQLVlStr(ctjTx($_POST["orgsds_g_pov_ptc"], 'out'), "text"),
							GtSQLVlStr(ctjTx($_POST["orgsds_g_pov_zom"], 'out'), "text"),
							GtSQLVlStr(ctjTx($_POST["orgsds_enc"], 'out'), "text")
					   );
                   
                   

		$Result = $__cnx->_prc($updateSQL); 
		if($Result){
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			$rsp['w'] = $__cnx->c_p->error;
			_ErrSis(['p'=>$updateSQL, 'd'=>$__cnx->c_p->error]);
		} 
	}

		
	// Elimino el Registro
	if ((isset($_POST['uid'])) && ($_POST['uid'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdOrgSds'))) { 
		
		$deleteSQL = sprintf("DELETE FROM "._BdStr(DBM).TB_ORG_SDS." WHERE orgsds_enc=%s", GtSQLVlStr(ctjTx($_POST['uid'], 'out'), "text"));
		$Result = $__cnx->_prc($deleteSQL); if($Result){$rsp['e'] = 'ok'; $rsp['m'] = 1; 
		//$rsp['a'] = Aud_Sis(Aud_Dsc(144, $_POST['lndfld_tt'], $_POST['id_lndfld']), $rsp['v']);
		
		}
	}

?>