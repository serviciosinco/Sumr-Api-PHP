<?php
	
// Ingreso de Registro
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdRd")) { 
			
	$__sbdmn = Gt_SbDMN();
	$__dt_cl = __Cl([ 'id'=>$__sbdmn, 't'=>'sbd' ]);	
			
	$__enc = Enc_Rnd($_POST['rd_tt'].'-'.DB_CL_ENC);
	$__dir = date("Y").'_'.$__dt_cl->sbd.'_'.Gn_Rnd(10);

	if(!isN($_POST['rd_logo'])){ $_logo=$_POST['rd_logo']; }else{ $_logo=2; }
	
	$insertSQL = sprintf("INSERT INTO "._BdStr(DBM).TB_RD." ( rd_enc, rd_cl, rd_are, rd_pg, rd_ord, rd_tt, rd_st, rd_dsc, rd_dir, rd_w, rd_h, rd_w_z, rd_h_z, rd_fnd, rd_clr, rd_pml, rd_tp, rd_issuu, rd_authid, rd_est, rd_pay, rd_logo, rd_thme, rd_bckg) VALUES ( %s, (SELECT id_cl FROM "._BdStr(DBM).TB_CL." WHERE cl_enc=%s), %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                  
				GtSQLVlStr(ctjTx($__enc,'out'), "text"),
				GtSQLVlStr(DB_CL_ENC, "text"),
				GtSQLVlStr($_POST['rd_are'], "int"),
				GtSQLVlStr($_POST['rd_pg'], "int"),
				GtSQLVlStr(ctjTx($_POST['rd_ord'],'out'), "text"),
				GtSQLVlStr(ctjTx($_POST['rd_tt'],'out'), "text"),
				GtSQLVlStr(ctjTx($_POST['rd_st'],'out'), "text"),
				GtSQLVlStr(ctjTx($_POST['rd_dsc'],'out'), "text"),
				GtSQLVlStr(ctjTx($_POST['rd_dir'],'out'), "text"),
				GtSQLVlStr(ctjTx($_POST['rd_w'],'out'), "text"),
				GtSQLVlStr(ctjTx($_POST['rd_h'],'out'), "text"),
				GtSQLVlStr(ctjTx($_POST['rd_w_z'],'out'), "text"),
				GtSQLVlStr(ctjTx($_POST['rd_w_h'],'out'), "text"),
				GtSQLVlStr(ctjTx($_POST['rd_fnd'],'out'), "text"),
				GtSQLVlStr(ctjTx($_POST['rd_clr'],'out'), "text"),
				GtSQLVlStr(ctjTx($_POST['rd_pml'],'out'), "text"),
				GtSQLVlStr($_POST['rd_tp'], "int"), 
				GtSQLVlStr(ctjTx($_POST['rd_issuu'],'out'), "text"), 
				GtSQLVlStr(ctjTx($_POST['rd_authid'],'out'), "text"), 
				GtSQLVlStr($_POST['rd_est'], "int"), 
				GtSQLVlStr($_POST['rd_pay'], "int"),
				GtSQLVlStr($_logo, "int"),
				GtSQLVlStr($_POST['rd_thme'], "int"),
				GtSQLVlStr($_POST['rd_bckg'], "int")
            );	
                   
                   		
	
	$Result = $__cnx->_prc($insertSQL);

	if($Result){
		$rsp['i'] = $__enc;
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		//$rsp['a'] = Aud_Sis(Aud_Dsc(71, $_POST['upfld_vl'], $__cnx->c_p->insert_id, $_POST['lnd_tt']), $rsp['v']);
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['m2'] = $insertSQL;
		_ErrSis(['p'=>$insertSQL, 'd'=>$__cnx->c_p->error]);
	}
}

// Modificación de Registro
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdRd")) { 
	
	if(!isN($_POST['rd_logo'])){ $_logo=$_POST['rd_logo']; }else{ $_logo=2; }

	$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_RD." SET rd_are=%s, rd_pg=%s, rd_ord=%s, rd_tt=%s, rd_st=%s, rd_dsc=%s, rd_dir=%s, rd_w=%s, rd_h=%s, rd_w_z=%s, rd_w_z=%s, rd_fnd=%s, rd_clr=%s, rd_pml=%s, rd_tp=%s, rd_issuu=%s, rd_authid=%s, rd_est=%s, rd_pay=%s, rd_logo=%s, rd_thme=%s, rd_bckg=%s, rd_s3=2 WHERE rd_enc =%s",
 
					GtSQLVlStr($_POST['rd_are'], "int"),
					GtSQLVlStr($_POST['rd_pg'], "int"),
					GtSQLVlStr(ctjTx($_POST['rd_ord'],'out'), "text"),
					GtSQLVlStr(ctjTx($_POST['rd_tt'],'out'), "text"),
					GtSQLVlStr(ctjTx($_POST['rd_st'],'out'), "text"),
					GtSQLVlStr(ctjTx($_POST['rd_dsc'],'out'), "text"),
					GtSQLVlStr(ctjTx($_POST['rd_dir'],'out'), "text"),
					GtSQLVlStr(ctjTx($_POST['rd_w'],'out'), "text"),
					GtSQLVlStr(ctjTx($_POST['rd_h'],'out'), "text"),
					GtSQLVlStr(ctjTx($_POST['rd_w_z'],'out'), "text"),
					GtSQLVlStr(ctjTx($_POST['rd_h_z'],'out'), "text"),
					GtSQLVlStr(ctjTx($_POST['rd_fnd'],'out'), "text"),
					GtSQLVlStr(ctjTx($_POST['rd_clr'],'out'), "text"),
					GtSQLVlStr(ctjTx($_POST['rd_pml'],'out'), "text"),
					GtSQLVlStr($_POST['rd_tp'], "int"), 
					GtSQLVlStr(ctjTx($_POST['rd_issuu'],'out'), "text"), 
					GtSQLVlStr(ctjTx($_POST['rd_authid'],'out'), "text"), 
					GtSQLVlStr($_POST['rd_est'], "int"), 
					GtSQLVlStr($_POST['rd_pay'], "int"),
					GtSQLVlStr($_logo, "int"),
					GtSQLVlStr($_POST['rd_thme'], "int"),
					GtSQLVlStr($_POST['rd_bckg'], "int"),
					GtSQLVlStr(ctjTx($_POST['rd_enc'],'out'), "text")
				);
					
	 
	$Result = $__cnx->_prc($updateSQL); 
	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		//$rsp['a'] = Aud_Sis(Aud_Dsc(72, $_POST['upfld_vl'], $_POST['id_lnd'], $_POST['lnd_tt']), $rsp['v']);
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['qry'] = $__cnx->c_p->error;
		_ErrSis(['p'=>$updateSQL, 'd'=>$__cnx->c_p->error]);
	} 
}

// Elimino el Registro
if ((isset($_POST['uid'])) && ($_POST['uid'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdRd'))) { 
	
	$deleteSQL = sprintf('DELETE FROM '._BdStr(DBM).TB_RD.' WHERE rd_enc=%s', GtSQLVlStr($_POST['uid'], 'text'));
	 
	$Result = $__cnx->_prc($deleteSQL); 
	
	if($Result){$rsp['e'] = 'ok'; $rsp['m'] = 1; /*$rsp['a'] = Aud_Sis(Aud_Dsc(73, $_POST['upfld_vl'], $_POST['uid'], $_POST['lnd_tt']), $rsp['v']);*/}
	else{$rsp['e'] = 'no';$rsp['m'] = 2; _ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);}
}
?>