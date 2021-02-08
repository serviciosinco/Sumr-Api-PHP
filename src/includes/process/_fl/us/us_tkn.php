<?php
$__rnd_1 = enCad(Gn_Rnd(20));
$__rnd_2 = enCad(Gn_Rnd(40));	

// Ingreso de Registro
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdUsTkn")) { 
	
	$__enc = Enc_Rnd( $__dt_cl->id.'-'.$_POST['ustkn_us'].'-'.$__rnd_1.'-'.$__rnd_2 ); 
	
	$insertSQL = sprintf("INSERT INTO "._BdStr(DBM).TB_US_TKN." (ustkn_enc, ustkn_cl, ustkn_us, ustkn_key, ustkn_pass) VALUES (%s, %s, %s, %s, %s)",
                   GtSQLVlStr($__enc, "text"),
                   GtSQLVlStr($__dt_cl->id, "int"),
                   GtSQLVlStr($_POST['ustkn_us'], "int"),
				   GtSQLVlStr(enCad($__rnd_1), "text"),
				   GtSQLVlStr(enCad($__rnd_2), "text"));			

	$Result = $__cnx->_prc($insertSQL);

		if($Result){
		$rsp['i'] = $__cnx->c_p->insert_id;
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		$rsp['a'] = Aud_Sis(Aud_Dsc(539, 'Usuario - Token', $__cnx->c_p->insert_id), $rsp['v']);
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['w'] = $__cnx->c_p->error;
		_ErrSis(['p'=>$insertSQL, 'd'=>$__cnx->c_p->error]);
	}

}

// Elimino el Registro
if ((isset($_POST['id_us'])) && ($_POST['id_us'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdUsTkn'))) { 
	$deleteSQL = sprintf('DELETE FROM '.TB_US_TKN.' WHERE ustkn_enc=%s', GtSQLVlStr($_POST['ustkn_enc'], 'text'));
	$Result = $__cnx->_prc($deleteSQL); if($Result){$rsp['e'] = 'ok'; $rsp['m'] = 1;
	$rsp['a'] = Aud_Sis(Aud_Dsc(540, 'Usuario - Token', $_POST['id_us']), $rsp['v']);
	}else{$rsp['e'] = 'no';$rsp['m'] = 2; _ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);}
}
?>