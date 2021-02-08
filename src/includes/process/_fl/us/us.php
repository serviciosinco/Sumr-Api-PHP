<?php

$__Us = new CRM_Us();

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdUs")) {

		$__Us->us_user = $_POST['us_user'];
		$__Us->us_nm = $_POST['us_nm'];
		$__Us->us_ap = $_POST['us_ap'];
		$__Us->us_fn = $_POST['us_fn'];
		$__Us->us_pass = $_POST['us_pass'];
		$__Us->us_nivel = $_POST['us_nivel'];
		$__Us->us_est = $_POST['us_est'];
		$__Us->us_age = $_POST['us_age'];
		$__Us->us_frm = $_POST['us_frm'];
		$__Us->us_crg = $_POST['us_crg'];
		$__Us->us_gnr = $_POST['us_gnr'];
		$__Us->us_chk_pqr = ($_POST['us_chk_pqr'] == 1) ? "1" : "2";
		$__Us->us_chk_tck = ($_POST['us_chk_tck'] == 1) ? "1" : "2";
		$__Us->us_chk_obs = ($_POST['us_chk_obs'] == 1) ? "1" : "2";

		$Prc = $__Us->Us();

 		if($Prc->e == 'ok'){

	 		//$rsp['i'] = $___id_us = $Prc->i;
	 		$rsp['enc'] = $Prc->enc;
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
			$_Crm_Aud->In_Aud([ "aud"=>"393", "db"=>$__t, "post"=>$_POST ]);

		}else{
			$rsp['m'] = 2;
			$rsp['w'] = $Prc->w;
			_ErrSis(['p'=>$insertSQL, 'd'=>$__cnx->c_p->error]);
		}
}

// Modificación de Registro
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdUs")) {

	$__Us->us_user = $_POST['us_user'];
	$__Us->us_msv_user = $_POST['us_msv_user'];
	$__Us->us_nm = $_POST['us_nm'];
	$__Us->us_ap = $_POST['us_ap'];
	$__Us->us_fn = $_POST['us_fn'];
	$__Us->us_pass = $_POST['us_pass'];
	$__Us->us_nivel = $_POST['us_nivel'];
	$__Us->us_est = $_POST['us_est'];
	$__Us->us_age = $_POST['us_age'];
	$__Us->us_frm = $_POST['us_frm'];
	$__Us->us_crg = $_POST['us_crg'];
	$__Us->us_gnr = $_POST['us_gnr'];
	$__Us->us_chk_pqr = ($_POST['us_chk_pqr'] == 1) ? "1" : "2";
	$__Us->us_chk_tck = ($_POST['us_chk_tck'] == 1) ? "1" : "2";
	$__Us->us_chk_obs = ($_POST['us_chk_obs'] == 1) ? "1" : "2";
	$Prc = $__Us->Us();

	//$rsp['prc'] = $Prc;

	if($Prc->e == 'ok'){

		$_Crm_Aud->In_Aud([ 'aud'=>_Cns('ID_AUDDSC_US_MOD'), "db"=>$__t, "post"=>$_POST]);
		$rsp['e'] = 'ok';
		$rsp['enc'] = $Prc->enc;
		$rsp['m'] = 1;
		$rsp['a'] = Aud_Sis(Aud_Dsc(21, $_POST['us_user'], $__cnx->c_p->insert_id), $rsp['v']);

	}else{

		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['w'] = $Prc->w;
		$rsp['tmp'] = $Prc;

		_ErrSis(['p'=>$updateSQL, 'd'=>$__cnx->c_p->error]);
	}

}

// Elimino el Registro
if ((isset($_POST['id_us'])) && ($_POST['id_us'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdUs'))) {

	$deleteSQL = sprintf('DELETE FROM '._BdStr(DBM).TB_US.' WHERE id_us=%s', GtSQLVlStr($_POST['id_us'], 'int'));

	 $Result = $__cnx->_prc($deleteSQL);
	 if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		//$rsp['a'] = Aud_Sis(Aud_Dsc(22, $_POST['us_user'], $_POST['id_us']), $rsp['v']);
		$_Crm_Aud->In_Aud([ 'aud'=>_Cns('ID_AUDDSC_US_ELI'), "db"=>$__t, "post"=>$_POST]);
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		_ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);}
	$__cnx->_clsr($Result);

}




// Ingreso de Registro de Archivo
if ((isset($_POST['MM_insert'])) && ($_POST['MM_insert'] == 'EdUsMdl')){
	global $__cnx;
	$insertSQL = sprintf('INSERT INTO '._BdStr(DBM).TB_US_MDL.' (usmdl_mdl, usmdl_us, usmdl_fa) VALUES (%s, %s, %s)', GtSQLVlStr($_POST['usmdl_mdl'], 'int'),GtSQLVlStr($_POST['usmdl_us'], 'int'),GtSQLVlStr(SIS_F, 'date'));
	$Result = $__cnx->_prc($insertSQL);
	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['er'] = _ErrSis(['p'=>$insertSQL, 'd'=>$__cnx->c_p->error]);
	}
	$__cnx->_clsr($Result);
}

// Elimino el Registro de Archivo
if((isset($_POST['id_usmdl']))&&($_POST['id_usmdl'] != '')&&((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdUsMdl'))){
	global $__cnx;
	$deleteSQL = sprintf('DELETE FROM '._BdStr(DBM).TB_US_MDL.' WHERE id_usmdl=%s',GtSQLVlStr($_POST['id_usmdl'], 'int'));
	$Result = $__cnx->_prc($deleteSQL);
	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 3;
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['w'] = $__cnx->c_p->error;
		$rsp['er'] = _ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);
	}
	$__cnx->_clsr($Result);
}


// Ingreso de Registro estado contactos permitidos
if ((isset($_POST['MM_insert'])) && ($_POST['MM_insert'] == 'EdUsFac')){
	global $__cnx;
	$insertSQL = sprintf('INSERT INTO '._BdStr(DBM).MDL_US_FAC_BD.' (usfac_fac, usfac_us, usfac_fa) VALUES (%s, %s, %s)', GtSQLVlStr($_POST['usfac_fac'], 'int'),GtSQLVlStr($_POST['usfac_us'], 'int'),GtSQLVlStr(SIS_F, 'date'));
	$Result = $__cnx->_prc($insertSQL);
	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['er'] = _ErrSis(['p'=>$insertSQL, 'd'=>$__cnx->c_p->error]);
	}
	$__cnx->_clsr($Result);
}

// Eliminacion Registro estado contactos permitidos
if((isset($_POST['id_usfac']))&&($_POST['id_usfac'] != '')&&((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdUsFac'))){
	global $__cnx;
	$deleteSQL = sprintf('DELETE FROM '._BdStr(DBM).MDL_US_FAC_BD.' WHERE id_usfac=%s',GtSQLVlStr($_POST['id_usfac'], 'int'));
	$Result = $__cnx->_prc($deleteSQL);
	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['w'] = $__cnx->c_p->error;
		$rsp['er'] = _ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);
	}
	$__cnx->_clsr($Result);
}
?>