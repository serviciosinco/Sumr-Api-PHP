<?php 

	if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdStore")) { 
		
		$__enc = Enc_Rnd($_POST['store_nm'].'-'.$_POST['store_pml'].'-'.$_POST['store_cl']);

		$insertSQL = sprintf("INSERT INTO ".DBS.".".TB_STORE." (store_enc, store_cl, store_nm, store_pml) VALUES (%s, (SELECT id_cl FROM "._BdStr(DBM).TB_CL." WHERE cl_enc = %s), %s, %s)",
						GtSQLVlStr(ctjTx($__enc, 'out'), "text"),
						GtSQLVlStr($_POST['store_cl'], "text"),
		 				GtSQLVlStr(ctjTx($_POST['store_nm'], 'out'), "text"),
		 				GtSQLVlStr(ctjTx($_POST['store_pml'], 'out'), "text"));
			
		$Result = $__cnx->_prc($insertSQL);

 		if($Result){	
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
			$rsp['i']  = $__enc;
		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			$rsp['w'] = $__cnx->c_p->error;
			_ErrSis(['p'=>$insertSQL, 'd'=>$__cnx->c_p->error]);
		}
		
	}

	// Modificación de Registro
	if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdStore") && !isN($_POST['store_enc'])) {
		
		if($__enc == 'reset'){
			$__enc = $__enc = Enc_Rnd($_POST['store_nm'].'-'.$_POST['store_pml'].'-'.$_POST['store_dir']);
		}else{
			$__enc = $_POST['store_enc'];
		}
		
		if(!isN($_POST['store_on'])){ $__est_cl=$_POST['store_on']; }else{ $__est_cl=2; }
		
		$updateSQL = sprintf("UPDATE ".DBS.".".TB_STORE." SET store_nm=%s, store_pml=%s WHERE store_enc=%s",
					   GtSQLVlStr( ctjTx($_POST['store_nm'],'out') , "text"),
                       GtSQLVlStr(ctjTx($_POST['store_pml'], 'out'), "text"),
                       GtSQLVlStr($_POST['store_enc'], "text"));
		
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
	if ((isset($_POST['id_cl'])) && ($_POST['id_cl'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdStore'))) { 
		$deleteSQL = sprintf("DELETE FROM ".DBS.".".TB_STORE." WHERE store_enc=%s", GtSQLVlStr($_POST['store_enc'], 'text'));
		 $Result = $__cnx->_prc($deleteSQL); if($Result){$rsp['e'] = 'ok'; $rsp['m'] = 1; 
		 //$rsp['a'] = Aud_Sis(Aud_Dsc(144, $_POST['lndfld_tt'], $_POST['id_lndfld']), $rsp['v']);
		 }else{$rsp['e'] = 'no';$rsp['m'] = 2; _ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);}
	}


	if ( !isN($_POST['store_enc']) && !isN($_POST['MM_rebuild']) && $_POST['MM_rebuild'] == 'EdStore' ) { 

		$__store = new CRM_Store();
		$__store->id_store = $_POST['store_enc'];
		$rsp['csve'] = $_w_sve = $__store->sve_json();
		
		if($_w_sve->e == 'ok'){
			$rsp['e'] = 'ok';
		}
	
	}


?>