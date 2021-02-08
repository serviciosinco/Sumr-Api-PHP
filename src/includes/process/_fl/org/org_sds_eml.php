<?php 

	//-------------------- SETUP - START --------------------//
			
			
		$__cl = GtClDt( Gt_SbDMN(), "sbd" );
		$__org = new CRM_Org([ 'cl'=>$__cl->id ]);
		
		
	//-------------------- START PROCESS --------------------//
	
	

	if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdOrgSdsEml")) { 
				
		$__org->orgsds_enc = $_POST['orgsdseml_orgsds'];
		$__org->org_sds_eml = $_POST['orgsdseml_eml'];
		
		$prc = $__org->In();
		//$rsp['prc'] = $prc;	
			
		if($prc->sds->eml->e == 'ok'){
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;		 	
			//$_id = $__cnx->c_p->insert_id;			 				 		
		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
		}
		
	}
	

	// Modificación de Registro primero este
	if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdOrgSdsEml")) {
		
		// Invoke class to update some field
		
	}
	
		
	// Elimino el Registro
	if ((isset($_POST['uid'])) && ($_POST['uid'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdOrgSdsEml'))) { 
		$deleteSQL = sprintf("DELETE FROM "._BdStr(DBM).TB_ORG_SDS_EML." WHERE orgsdseml_enc=%s", GtSQLVlStr(ctjTx($_POST['uid'], 'out'), "text"));
		$Result = $__cnx->_prc($deleteSQL); if($Result){$rsp['e'] = 'ok'; $rsp['m'] = 1; 
		//$rsp['a'] = Aud_Sis(Aud_Dsc(144, $_POST['lndfld_tt'], $_POST['id_lndfld']), $rsp['v']);
		}else{$rsp['e'] = 'no';$rsp['m'] = 2; _ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);}
	}
?>