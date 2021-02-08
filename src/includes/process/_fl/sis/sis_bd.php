<?php
// Ingreso de Registro
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdSisBd")) { 	
	
	$__enc = Enc_Rnd($_POST['sisbd_nm']);		
		
	$insertSQL = sprintf("INSERT INTO "._BdStr(DBM).TB_SIS_BD." (sisbd_enc, sisbd_cl, sisbd_nm, sisbd_usnvl, sisbd_tabs, sisbd_eml, sisbd_dc, sisbd_tel, sisbd_cd, sisbd_uni, sisbd_clg, sisbd_emp, sisbd_md, sisbd_fnt, sisbd_fn, sisbd_gnr, sisbd_comp, sisbd_fld_nm, sisbd_fld_ap) VALUES (%s, (SELECT id_cl FROM "._BdStr(DBM).TB_CL." WHERE cl_enc = %s), %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                   GtSQLVlStr($__enc, "text"),
                   GtSQLVlStr(ctjTx(CL_ENC,'out'), "text"),
                   GtSQLVlStr(ctjTx($_POST['sisbd_nm'],'out'), "text"),
                   GtSQLVlStr($_POST['sisbd_usnvl'], "int"),
                   GtSQLVlStr( _NoNll(Html_chck_vl($_POST['sisbd_tabs'])) , "int"),
                   GtSQLVlStr( _NoNll(Html_chck_vl($_POST['sisbd_eml'])) , "int"),
                   GtSQLVlStr( _NoNll(Html_chck_vl($_POST['sisbd_dc'])) , "int"),
                   
                   GtSQLVlStr( _NoNll(Html_chck_vl($_POST['sisbd_tel'])) , "int"),
                   GtSQLVlStr( _NoNll(Html_chck_vl($_POST['sisbd_cd'])) , "int"),
                   
                   GtSQLVlStr( _NoNll(Html_chck_vl($_POST['sisbd_uni'])) , "int"),
                   GtSQLVlStr( _NoNll(Html_chck_vl($_POST['sisbd_clg'])) , "int"),
                   GtSQLVlStr( _NoNll(Html_chck_vl($_POST['sisbd_emp'])) , "int"),
                   GtSQLVlStr( _NoNll(Html_chck_vl($_POST['sisbd_md'])) , "int"),
                   GtSQLVlStr( _NoNll(Html_chck_vl($_POST['sisbd_fnt'])) , "int"),
                   GtSQLVlStr( _NoNll(Html_chck_vl($_POST['sisbd_fn'])) , "int"),
                   GtSQLVlStr( _NoNll(Html_chck_vl($_POST['sisbd_gnr'])) , "int"),
                   GtSQLVlStr( _NoNll(Html_chck_vl($_POST['sisbd_comp'])) , "int"),
                   GtSQLVlStr( _NoNll(Html_chck_vl($_POST['sisbd_fld_nm'])) , "int"),
                   GtSQLVlStr( _NoNll(Html_chck_vl($_POST['sisbd_fld_ap'])) , "int"));
                   
	
	
	$Result = $__cnx->_prc($insertSQL);
		if($Result){
		//$rsp['i'] = $__cnx->c_p->insert_id;
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;

	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['sm'] = $insertSQL;
		_ErrSis(['p'=>$insertSQL, 'd'=>$__cnx->c_p->error]);
	}
}

// Modificación de Registro
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdSisBd")) { 
	
	$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_SIS_BD." SET sisbd_nm=%s, sisbd_usnvl=%s, sisbd_tabs=%s, sisbd_eml=%s, sisbd_dc=%s, sisbd_tel=%s, sisbd_cd=%s, sisbd_uni=%s, sisbd_clg=%s, sisbd_emp=%s, sisbd_md=%s, sisbd_fnt=%s, sisbd_fn=%s, sisbd_gnr=%s, sisbd_comp=%s, sisbd_fld_nm=%s, sisbd_fld_ap=%s WHERE sisbd_enc=%s",
						GtSQLVlStr(ctjTx($_POST['sisbd_nm'],'out'), "text"),
						GtSQLVlStr(ctjTx($_POST['sisbd_usnvl'],'out'), "text"),
						GtSQLVlStr( _NoNll(Html_chck_vl($_POST['sisbd_tabs'])) , "int"),
						GtSQLVlStr( _NoNll(Html_chck_vl($_POST['sisbd_eml'])) , "int"),
						GtSQLVlStr( _NoNll(Html_chck_vl($_POST['sisbd_dc'])) , "int"),
						GtSQLVlStr( _NoNll(Html_chck_vl($_POST['sisbd_tel'])) , "int"),
						GtSQLVlStr( _NoNll(Html_chck_vl($_POST['sisbd_cd'])) , "int"),
						GtSQLVlStr( _NoNll(Html_chck_vl($_POST['sisbd_uni'])) , "int"),
						GtSQLVlStr( _NoNll(Html_chck_vl($_POST['sisbd_clg'])) , "int"),
						GtSQLVlStr( _NoNll(Html_chck_vl($_POST['sisbd_emp'])) , "int"),
						GtSQLVlStr( _NoNll(Html_chck_vl($_POST['sisbd_md'])) , "int"),
						GtSQLVlStr( _NoNll(Html_chck_vl($_POST['sisbd_fnt'])) , "int"),
						GtSQLVlStr( _NoNll(Html_chck_vl($_POST['sisbd_fn'])) , "int"),
						GtSQLVlStr( _NoNll(Html_chck_vl($_POST['sisbd_gnr'])) , "int"),
						GtSQLVlStr( _NoNll(Html_chck_vl($_POST['sisbd_comp'])) , "int"),
						GtSQLVlStr( _NoNll(Html_chck_vl($_POST['sisbd_fld_nm'])) , "int"),
						GtSQLVlStr( _NoNll(Html_chck_vl($_POST['sisbd_fld_ap'])) , "int"),
						GtSQLVlStr(ctjTx($_POST['sisbd_enc'],'out'), "text"));
						
	
	$Result = $__cnx->_prc($updateSQL); 
	
	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['w'] = $updateSQL;
		_ErrSis(['p'=>$updateSQL, 'd'=>$__cnx->c_p->error]);
	} 
}

// Elimino el Registro
if ((isset($_POST['uid'])) && ($_POST['uid'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdSisBd'))) { 
	$deleteSQL = sprintf('DELETE FROM '._BdStr(DBM).TB_SIS_BD.' WHERE sisbd_enc=%s', GtSQLVlStr($_POST['uid'], 'text'));
	 $Result = $__cnx->_prc($deleteSQL); if($Result){$rsp['e'] = 'ok'; $rsp['m'] = 1; 
	 }else{$rsp['e'] = 'no';$rsp['m'] = 2; _ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);}
}
?>