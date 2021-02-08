<?php 

	if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdCl")) { 
		
		$__enc = Enc_Rnd($_POST['cl_nm'].'-'.$_POST['cl_sbd'].'-'.$_POST['cl_dir']);
		
		if(!isN($_POST['cl_on'])){ $__est_cl=$_POST['cl_on']; }else{ $__est_cl=2; }
		
		$__sbd = preg_replace("/[^A-Za-z]/",'',$_POST['cl_sbd']);

		$insertSQL = sprintf("INSERT INTO "._BdStr(DBM).TB_CL." (cl_enc, cl_nm, cl_sbd, cl_dir, cl_on, cl_prfl, cl_rsllr, cl_web) VALUES (%s, %s, %s, %s, %s, %s, %s, %s)",
		 				GtSQLVlStr(ctjTx($__enc, 'out'), "text"),
		 				GtSQLVlStr(ctjTx($_POST['cl_nm'], 'out'), "text"),
		 				GtSQLVlStr(ctjTx($__sbd, 'out'), "text"),
		 				GtSQLVlStr(ctjTx($_POST['cl_dir'], 'out'), "text"),
		 				GtSQLVlStr($__est_cl, "int"),
		 				GtSQLVlStr(ctjTx(Gn_Rnd(10),'out'), "text"),
		 				GtSQLVlStr($_POST['cl_rsllr'], "int"),
		 				GtSQLVlStr(ctjTx($_POST['cl_web'], 'out'), "text"));
			
		$Result = $__cnx->_prc($insertSQL);
		 
		if($Result){	

			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
			$rsp['i']  = $__enc;

			$createDbSQL = sprintf("CREATE DATABASE IF NOT EXISTS ".DB_PRFX_CL.ctjTx($_POST['cl_sbd'], 'out')." ");
			
			$ResultDb = $__cnx->_prc($createDbSQL);

			if($ResultDb){ $rsp['edb'] = 'ok'; }

		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			_ErrSis(['p'=>$insertSQL, 'd'=>$__cnx->c_p->error]);
		}
		
	}

	// Modificación de Registro
	if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdCl") && !isN($_POST['cl_enc'])) {
		
		if($__enc == 'reset'){
			$__enc = $__enc = Enc_Rnd($_POST['cl_nm'].'-'.$_POST['cl_sbd'].'-'.$_POST['cl_dir']);
		}else{
			$__enc = $_POST['cl_enc'];
		}
		
		$__sbd = preg_replace("/[^A-Za-z]/",'',$_POST['cl_sbd']);

		if(!isN($_POST['cl_on'])){ $__est_cl=$_POST['cl_on']; }else{ $__est_cl=2; }
		
		$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_CL." SET cl_nm=%s, cl_sbd=%s, cl_dir=%s, cl_on=%s, cl_enc=%s, cl_rsllr=%s, cl_web=%s WHERE cl_enc=%s",
					   GtSQLVlStr( ctjTx($_POST['cl_nm'],'out') , "text"),
                       GtSQLVlStr(ctjTx($__sbd, 'out'), "text"),
                       GtSQLVlStr(ctjTx($_POST['cl_dir'], 'out'), "text"),
                       GtSQLVlStr($__est_cl, "int"),
                       GtSQLVlStr(ctjTx($__enc, 'out'), "text"),
                       GtSQLVlStr($_POST['cl_rsllr'], "int"),
                       GtSQLVlStr(ctjTx($_POST['cl_web'], 'out'), "text"),
                       GtSQLVlStr($_POST['cl_enc'], "text"));
		
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
	if ((isset($_POST['id_cl'])) && ($_POST['id_cl'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdCl'))) { 
		$deleteSQL = sprintf("DELETE FROM "._BdStr(DBM).TB_CL." WHERE cl_enc=%s", GtSQLVlStr($_POST['cl_enc'], 'text'));
		 $Result = $__cnx->_prc($deleteSQL); if($Result){$rsp['e'] = 'ok'; $rsp['m'] = 1; 
		 //$rsp['a'] = Aud_Sis(Aud_Dsc(144, $_POST['lndfld_tt'], $_POST['id_lndfld']), $rsp['v']);
		 }else{$rsp['e'] = 'no';$rsp['m'] = 2; _ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);}
	}


	if ( !isN($_POST['cl_enc']) && !isN($_POST['MM_rebuild']) && $_POST['MM_rebuild'] == 'EdClJson' ) { 

		$__cl = new CRM_Cl();
		$__cl->id_cl = $_POST['cl_enc'];
		$rsp['csve'] = $_w_sve = $__cl->sve_json();
		
		if($_w_sve->e == 'ok'){
			$rsp['e'] = 'ok';
		}
	
	}


?>