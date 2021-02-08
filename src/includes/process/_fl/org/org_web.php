<?php 
	
	//-------------------- SETUP - START --------------------//
			
			
		$__cl = GtClDt( Gt_SbDMN(), "sbd" );
		$__org = new CRM_Org([ 'cl'=>$__cl->id ]);
		
		
	//-------------------- START PROCESS --------------------//


	if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdOrgWeb")) { 
		
		$__org->org_enc = $_POST['orgweb_org'];
		$__org->org_web = $_POST['orgweb_web'];
		
		$prc = $__org->In();
		//$rsp['prc'] = $prc;	
			
		if($prc->web->e == 'ok'){
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;		 	
			//$_id = $__cnx->c_p->insert_id;			 				 		
		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
		}
		
	}
	

	// Modificación de Registro primero este
	if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdOrgWeb")) {
		
		// Invoke class to update some field
		
	}
	
		
	// Elimino el Registro
	if ((isset($_POST['uid'])) && ($_POST['uid'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdOrgWeb'))) { 
		$deleteSQL = sprintf("DELETE FROM ".TB_ORG_WEB." WHERE orgweb_enc=%s", GtSQLVlStr(ctjTx($_POST['uid'], 'out'), "text"));
		$Result = $__cnx->_prc($deleteSQL); if($Result){$rsp['e'] = 'ok'; $rsp['m'] = 1; 
		}else{$rsp['e'] = 'no';$rsp['m'] = 2; _ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);}
	}
?>