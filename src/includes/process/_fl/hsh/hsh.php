<?php
	
// Ingreso de Registro
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdHsh")) { 
			
	$__sbdmn = Gt_SbDMN();
	$__dt_cl = __Cl([ 'id'=>$__sbdmn, 't'=>'sbd' ]);	
			
	$__enc = Enc_Rnd($_POST['hsh_tt'].'-'.DB_CL_ENC);
	
	$insertSQL = sprintf("INSERT INTO "._BdStr(DBM).TB_HSH." ( hsh_enc, hsh_cl, hsh_tt, hsh_tx, hsh_hsh, hsh_bck_clr, hsh_on, hsh_hdr_bdclr, hsh_msg_bck, hsh_msg_bdclr, hsh_msg_bdwd, hsh_frm, hsh_sng, hsh_tme_hdr, hsh_tme_hdr_drt, hsh_tme_hsh, hsh_tme_hsh_drt, hsh_emb, hsh_dsgn) VALUES ( %s, (SELECT id_cl FROM ".TB_CL." WHERE cl_enc=%s), %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                  
				GtSQLVlStr(ctjTx($__enc,'out'), "text"),
				GtSQLVlStr(DB_CL_ENC ,"int"),	
				GtSQLVlStr(ctjTx($_POST['hsh_tt'],'out'), "text"),
				GtSQLVlStr(ctjTx($_POST['hsh_tx'],'out'), "text"),
				GtSQLVlStr(ctjTx($_POST['hsh_hsh'],'out'), "text"),
				GtSQLVlStr(ctjTx(str_replace("#", "", $_POST['hsh_bck_clr']),'out'), "text"),
				GtSQLVlStr($_POST['hsh_on'], "int"),
				GtSQLVlStr(ctjTx(str_replace("#", "", $_POST['hsh_hdr_bdclr']), 'out'), "text"),
				GtSQLVlStr(ctjTx(str_replace("#", "", $_POST['hsh_msg_bck']), 'out'), "text"),
				GtSQLVlStr(ctjTx(str_replace("#", "", $_POST['hsh_msg_bdclr']) ,'out'), "text"),
				GtSQLVlStr($_POST['hsh_msg_bdwd'] , "int"),
				GtSQLVlStr(ctjTx($_POST['hsh_frm'],'out'), "text"),
				GtSQLVlStr($_POST['hsh_sng'] , "int"),
				GtSQLVlStr(ctjTx($_POST['hsh_tme_hdr'],'out'), "text"),
				GtSQLVlStr(ctjTx($_POST['hsh_tme_hdr_drt'],'out'), "text"),
				GtSQLVlStr(ctjTx($_POST['hsh_tme_hsh'],'out'), "text"),
				GtSQLVlStr($_POST['hsh_tme_hsh_drt'], "int"), 
				GtSQLVlStr(ctjTx($_POST['hsh_emb'],'out'), "text"), 
				GtSQLVlStr(ctjTx($_POST['hsh_dsgn'],'out'), "text")
								  
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
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdHsh")) { 
	
	$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_HSH." SET hsh_tt=%s, hsh_tx=%s, hsh_hsh=%s, hsh_bck_clr=%s, hsh_on=%s, hsh_hdr_bdclr=%s, hsh_msg_bck=%s, hsh_msg_bdclr=%s, hsh_msg_bdwd=%s, hsh_frm=%s, hsh_sng=%s, hsh_tme_hdr=%s, hsh_tme_hdr_drt=%s, hsh_tme_hsh=%s, hsh_tme_hsh_drt=%s, hsh_emb=%s, hsh_dsgn=%s WHERE hsh_enc =%s",
	
				GtSQLVlStr(ctjTx($_POST['hsh_tt'],'out'), "text"),
				GtSQLVlStr(ctjTx($_POST['hsh_tx'],'out'), "text"),
				GtSQLVlStr(ctjTx($_POST['hsh_hsh'],'out'), "text"),
				GtSQLVlStr(ctjTx(str_replace("#", "", $_POST['hsh_bck_clr']),'out'), "text"),
				GtSQLVlStr($_POST['hsh_on'], "int"),
				GtSQLVlStr(ctjTx(str_replace("#", "", $_POST['hsh_hdr_bdclr']), 'out'), "text"),
				GtSQLVlStr(ctjTx(str_replace("#", "", $_POST['hsh_msg_bck']), 'out'), "text"),
				GtSQLVlStr(ctjTx(str_replace("#", "", $_POST['hsh_msg_bdclr']) ,'out'), "text"),
				GtSQLVlStr($_POST['hsh_msg_bdwd'] , "int"),
				GtSQLVlStr(ctjTx($_POST['hsh_frm'],'out'), "text"),
				GtSQLVlStr($_POST['hsh_sng'] , "int"),
				GtSQLVlStr(ctjTx($_POST['hsh_tme_hdr'],'out'), "text"),
				GtSQLVlStr(ctjTx($_POST['hsh_tme_hdr_drt'],'out'), "text"),
				GtSQLVlStr(ctjTx($_POST['hsh_tme_hsh'],'out'), "text"),
				GtSQLVlStr($_POST['hsh_tme_hsh_drt'], "int"), 
				GtSQLVlStr(ctjTx($_POST['hsh_emb'],'out'), "text"), 
				GtSQLVlStr(ctjTx($_POST['hsh_dsgn'],'out'), "text"),
				GtSQLVlStr(ctjTx($_POST['hsh_enc'],'out'), "text")
				
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

?>