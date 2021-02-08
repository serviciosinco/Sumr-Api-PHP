<?php 

	// Ingreso de Registro

	if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdOrgSdsEtd")) { 
		
		$__enc = Enc_Rnd($_POST['orgsdsetd_grd']."-".$_POST['orgsdsetd_ctd']);
		
		
		$insertSQL = sprintf("INSERT INTO ".TB_ORG_SDS_ETD." (orgsdsetd_enc, orgsdsetd_grd, orgsdsetd_ctd, orgsdsetd_orgsds) VALUES (%s, %s, %s, (SELECT id_orgsds FROM ".TB_ORG_SDS." WHERE orgsds_enc = %s) )",
                    	GtSQLVlStr(ctjTx($__enc, 'out'), "text"),
                    	GtSQLVlStr($_POST['orgsdsetd_grd'], "int"),
                    	GtSQLVlStr($_POST['orgsdsetd_ctd'], "int"),
                    	GtSQLVlStr(ctjTx($_POST['orgsdsetd_orgsds'], 'out'), "text")); 

		
		$Result = $__cnx->_prc($insertSQL);
 		
 		if($Result){
	 		
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
			$_id = $__cnx->c_p->insert_id;
			
		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			_ErrSis(['p'=>$insertSQL, 'd'=>$__cnx->c_p->error]);
		}
		
	}
	

	// Modificación de Registro primero este
	if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdOrgSdsEtd")) {
		
		$updateSQL = sprintf("UPDATE ".TB_ORG_SDS_ETD." SET orgsdsetd_grd=%s, orgsdsetd_ctd=%s WHERE orgsdsetd_enc=%s",
		
					   GtSQLVlStr($_POST['orgsdsetd_grd'], "int"),
					   GtSQLVlStr($_POST['orgsdsetd_ctd'], "int"),
					   GtSQLVlStr(ctjTx($_POST['orgsdsetd_enc'], 'out'), "text"));
					   
					  
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
	if ((isset($_POST['uid'])) && ($_POST['uid'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdOrgSdsEtd'))) { 
		$deleteSQL = sprintf("DELETE FROM ".TB_ORG_SDS_ETD." WHERE orgsdsetd_enc=%s", GtSQLVlStr(ctjTx($_POST['uid'], 'out'), "text"));
		$Result = $__cnx->_prc($deleteSQL); if($Result){$rsp['e'] = 'ok'; $rsp['m'] = 1; 
		//$rsp['a'] = Aud_Sis(Aud_Dsc(144, $_POST['lndfld_tt'], $_POST['id_lndfld']), $rsp['v']);
		}else{$rsp['e'] = 'no';$rsp['m'] = 2; _ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);}
	}
?>