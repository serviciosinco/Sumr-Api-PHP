<?php
	
$___plcy_id = $_POST['applfm_plcy'];

if(!isN($___plcy_id)){
	$___plcydt = GtClPlcyDt([ 'id'=>$___plcy_id, 't'=>'enc' ]);
}	
	
// Ingreso de Registro
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdApplFm")) { 
	
	$__enc = Enc_Rnd( $_POST['applfm_nm'].'-'.$_POST['applfm_plcy'] ); 
	
	$insertSQL = sprintf("INSERT INTO "._BdStr(DBM).TB_APPL_FM." (applfm_enc, applfm_cl, applfm_nm, applfm_thm, applfm_plcy, applfm_thx_top, applfm_thx_url, applfm_s_sch, applfm_plcytt, applfm_plcytx, applfm_plcylnk) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GtSQLVlStr($__enc, "text"),
                       GtSQLVlStr($__dt_cl->id, "int"),
                       GtSQLVlStr(ctjTx($_POST['applfm_nm'],'out'), "text"),
                       GtSQLVlStr($_POST['applfm_thm'], "int"),
                       GtSQLVlStr($___plcydt->id, "int"),
                       GtSQLVlStr(Html_chck_vl($_POST['applfm_thx_top']), "int"),
                       GtSQLVlStr(ctjTx($_POST['applfm_thx_url'],'out'), "text"),
                       GtSQLVlStr(Html_chck_vl($_POST['applfm_s_sch']), "int"),
                       GtSQLVlStr(ctjTx($_POST['applfm_plcytt'],'out'), "text"),
                       GtSQLVlStr(ctjTx($_POST['applfm_plcytx'],'out'), "text"),
                       GtSQLVlStr(ctjTx($_POST['applfm_plcylnk'],'out'), "text"));	 
                       	
	
	$Result = $__cnx->_prc($insertSQL);

	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['er'] = $__cnx->c_p->error;
		_ErrSis(['p'=>$insertSQL, 'd'=>$__cnx->c_p->error]);
	}
}

// Modificación de Registro
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdApplFm")) { 
	
	$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_APPL_FM." SET applfm_nm=%s, applfm_thm=%s, applfm_plcy=%s, applfm_thx_top=%s ,applfm_thx_url=%s, applfm_s_sch=%s, applfm_plcytt=%s, applfm_plcytx=%s, applfm_plcylnk=%s WHERE applfm_enc=%s",
					
                       GtSQLVlStr(ctjTx($_POST['applfm_nm'],'out'), "text"),
                       GtSQLVlStr($_POST['applfm_thm'], "int"),
                       GtSQLVlStr($__dt_cl->id, "int"),
                       GtSQLVlStr(Html_chck_vl($_POST['applfm_thx_top']), "int"),
                       GtSQLVlStr(ctjTx($_POST['applfm_thx_url'],'out'), "text"),
                       GtSQLVlStr(Html_chck_vl($_POST['applfm_s_sch']), "int"),
                       GtSQLVlStr(ctjTx($_POST['applfm_plcytt'],'out'), "text"),
                       GtSQLVlStr(ctjTx($_POST['applfm_plcytx'],'out'), "text"),
                       GtSQLVlStr(ctjTx($_POST['applfm_plcylnk'],'out'), "text"),
                       GtSQLVlStr(ctjTx($_POST['applfm_enc'],'out'), "text"));
	
	$Result = $__cnx->_prc($updateSQL); 
	
	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		$rsp['ms'] = $updateSQL;
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['w'] = $__cnx->c_p->error;
	} 
}

// Elimino el Registro
if ((isset($_POST['uid'])) && ($_POST['uid'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdApplFm'))) { 
	$deleteSQL = sprintf('DELETE FROM '._BdStr(DBM).TB_APPL_FM.' WHERE applfm_enc=%s', GtSQLVlStr($_POST['uid'], 'text'));
	 $Result = $__cnx->_prc($deleteSQL); if($Result){$rsp['e'] = 'ok'; $rsp['m'] = 1; 
	 //$rsp['a'] = Aud_Sis(Aud_Dsc(483, $_POST['mdls_nm'], $_POST['id_mdls']), $rsp['v']);
	 }else{$rsp['e'] = 'no';$rsp['m'] = 2; _ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);}
}
?>