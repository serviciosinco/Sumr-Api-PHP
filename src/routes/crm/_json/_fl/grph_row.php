<?php  
	Hdr_JSON();
	$_tp = Php_Ls_Cln($_POST['_tp']);
	$_dms = Php_Ls_Cln($_POST['_dms']);
	$_mtrc = Php_Ls_Cln($_POST['_mtrc']);
	$_tt = Php_Ls_Cln($_POST['_tt']);
	$_row = Php_Ls_Cln($_POST['_bx']);
	
	$_clr_bc = Php_Ls_Cln($_POST['_clr_bc']);
	$_clr = Php_Ls_Cln($_POST['_clr']);
	
	//Cuando se crea la grafica
	if($_POST['_sve'] == "MM_insert"){
		$query_DtRg = "INSERT INTO "._BdStr(DBM).TB_DSH_GRPH_BX." (dshgrphbx_tt, dshgrphbx_bx, dshgrphbx_mtrc, dshgrphbx_grph, dshgrphbx_us, dshgrphbx_clr_bc, dshgrphbx_clr) VALUES ('".$_tt."', ".$_row.", ".$_mtrc.", ".$_tp.", ".SISUS_ID.", '".$_clr_bc."','".$_clr."')";
		$DtRg = $__cnx->_prc($query_DtRg);
		
		$_id = $__cnx->c_p->insert_id;
		$_enc = enCad(ctjTx($_id.$_tt,'out'));
		$query_Enc = "UPDATE "._BdStr(DBM).TB_DSH_GRPH_BX." SET dshgrphbx_enc = '".$_enc."' WHERE id_dshgrphbx = ".$_id."";
		$DtEnc = $__cnx->_prc($query_Enc);
		
	}
	
	//Cuando se modifica la grafica
	elseif($_POST['_sve'] == "MM_update"){
		$_i = Php_Ls_Cln($_POST['id_grphbx']);
		$_enc = enCad(ctjTx($_i.$_tt,'out'));
		$query_DtRg = "UPDATE "._BdStr(DBM).TB_DSH_GRPH_BX." SET dshgrphbx_tt='".$_tt."', dshgrphbx_bx=".$_row.", dshgrphbx_mtrc=".$_mtrc.", dshgrphbx_grph=".$_tp.", dshgrphbx_us=".SISUS_ID.", dshgrphbx_enc = '".$_enc."', dshgrphbx_clr_bc = '".$_clr_bc."', dshgrphbx_clr = '".$_clr."' WHERE id_dshgrphbx = ".$_i."";
		$DtRg = $__cnx->_prc($query_DtRg);
	}
	
	
	if($DtRg){	
		$rsp['e'] = 'ok';
	}else{
		$rsp['e'] = 'no';
		$rsp['t'] = $query_DtRg;
	} 
	
?>