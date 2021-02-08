<?php 
	
// Ingreso de Registro
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdClAre")) { 
		
		
	if(isN($_POST['clare_ord'])){
		$__prnt = GtClAreDt([ 'id'=>$_POST['clare_prnt'] ]);
		$rsp['prnt'] = $__prnt;	
		
		$__ord = 1;
		if(!isN($__prnt->lst->ord)){ 
			$__ord = ($__prnt->lst->ord+1); 
		}
	}else{
		$__ord = ctjTx($_POST['clare_ord'],'out');
	}
	
	$__Enc = Enc_Rnd($_POST['clare_cl'].'-'.$_POST['clare_tt']);
	
	$insertSQL = sprintf("INSERT INTO "._BdStr(DBM).TB_CL_ARE." (clare_enc, clare_cl, clare_est, clare_tt, clare_tp, clare_prnt, clare_cod, clare_clr, clare_tel, clare_ext, clare_ord) VALUES (%s, (SELECT id_cl FROM "._BdStr(DBM).TB_CL." WHERE cl_enc = %s), %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                   GtSQLVlStr(ctjTx($__Enc,'out'), "text"),
				   GtSQLVlStr($_POST['clare_cl'], "text"),
				   GtSQLVlStr(Html_chck_vl($_POST['clare_est']), "int"),
                   GtSQLVlStr(ctjTx($_POST['clare_tt'],'out'), "text"),
                   GtSQLVlStr($_POST['clare_tp'], "int"),
				   GtSQLVlStr($_POST['clare_prnt'], "int"),
				   GtSQLVlStr(ctjTx($_POST['clare_cod'],'out'), "text"),
				   GtSQLVlStr(ctjTx($_POST['clare_clr'],'out'), "text"),
				   GtSQLVlStr(ctjTx($_POST['clare_tel'],'out'), "text"),
				   GtSQLVlStr(ctjTx($_POST['clare_ext'],'out'), "text"),
				   GtSQLVlStr($__ord, "text"));			
				   
	
	$Result = $__cnx->_prc($insertSQL); $rsp['w'] = $__cnx->c_p->error;
	
	if($Result){

		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		
	}else{
		
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		
		_ErrSis(['p'=>$insertSQL, 'd'=>$__cnx->c_p->error]);
		
	}
	
}

// Modificación de Registro
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdClAre")) { 
	
	$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_CL_ARE." SET clare_tt=%s, clare_est=%s,  clare_tp=%s, clare_prnt=%s, clare_cod=%s, clare_clr=%s, clare_tel=%s, clare_ext=%s, clare_ord=%s WHERE clare_enc=%s",
					   GtSQLVlStr(ctjTx($_POST['clare_tt'],'out'), "text"),
					   GtSQLVlStr(Html_chck_vl($_POST['clare_est']), "int"),
					   GtSQLVlStr($_POST['clare_tp'], "int"),
					   GtSQLVlStr($_POST['clare_prnt'], "int"),
					   GtSQLVlStr(ctjTx($_POST['clare_cod'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['clare_clr'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['clare_tel'],'out'), "int"),
					   GtSQLVlStr(ctjTx($_POST['clare_ext'],'out'), "int"),
					   GtSQLVlStr(ctjTx($_POST['clare_ord'],'out'), "text"),
                       GtSQLVlStr($_POST['clare_enc'], "text"));
	
	$Result = $__cnx->_prc($updateSQL); 
	
	if($Result){
		$rsp['enc'] = $_POST['clare_enc'];
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		_ErrSis(['p'=>$updateSQL, 'd'=>$__cnx->c_p->error]);
	} 
}

if ((isset($_POST['id_clare'])) && ($_POST['id_clare'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdClAre'))) { 
	$deleteSQL = sprintf("DELETE FROM "._BdStr(DBM).TB_CL_ARE." WHERE clare_enc=%s", GtSQLVlStr($_POST['clare_enc'], 'text'));
	$Result = $__cnx->_prc($deleteSQL); 
	 
	if($Result){
		$rsp['e'] = 'ok'; $rsp['m'] = 1;
		$rsp['a'] = Aud_Sis(Aud_Dsc(417, $_POST['clare_dsc'], $_POST['id_clare']), $rsp['v']);
		$rsp['auto'] = __AutoRUN([ 't'=>'sis_cns', 'bd'=>'_cl_mnu' ]);
	}else{
		$rsp['e'] = 'no';$rsp['m'] = 2; 
		_ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);
	}
}


?>