<?php 
	
	
	//-------------------- SETUP - START --------------------//
			
		$__cl = GtClDt( Gt_SbDMN(), "sbd" );
		$__org = new CRM_Org([ 'cl'=>$__dt_cl->id ]);	
		
	//-------------------- START PROCESS --------------------//
	
	

	if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdOrgSdsDc")) { 
		
		$__org->orgsds_enc = $_POST['orgsdsdc_orgsds'];
		$__org->org_sds_dc = $_POST['orgsdsdc_dc'];
		$__org->org_sds_dc_tp = $_POST['orgsdsdc__tp'];	
		
		$prc = $__org->In();
		//$rsp['prc'] = $prc;	
			
		if($prc->sds->dc->e == 'ok'){
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;		 	
			//$_id = $__cnx->c_p->insert_id;			 				 		
		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
		}
		
	}
	

	// Modificación de Registro primero este
	if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdOrgSdsDc")) {
		
		// Invoke class to update some field
		
	}
	
		
	// Elimino el Registro
	if ((isset($_POST['uid'])) && ($_POST['uid'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdOrgSdsDc'))) { 
		$deleteSQL = sprintf("DELETE FROM "._BdStr(DBM).TB_ORG_SDS_DC." WHERE orgsdsdc_enc=%s", GtSQLVlStr(ctjTx($_POST['uid'], 'out'), "text"));
		$Result = $__cnx->_prc($deleteSQL); if($Result){$rsp['e'] = 'ok'; $rsp['m'] = 1; 
		//$rsp['a'] = Aud_Sis(Aud_Dsc(144, $_POST['lndfld_tt'], $_POST['id_lndfld']), $rsp['v']);
		}else{$rsp['e'] = 'no';$rsp['m'] = 2; _ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);}
	}
?>