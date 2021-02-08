<?php
// Ingreso de Registro
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdVtexCmpg")) {
	
	$__enc = Enc_Rnd($_POST['vtexcmpg_nm'].'-'.$_POST['vtexcmpg_pml'].'-'.SISUS_ID);
	
	$insertSQL = sprintf("INSERT INTO "._BdStr(DBT).TB_VTEX_CMPG." (
								vtexcmpg_enc, vtexcmpg_vtex, vtexcmpg_nm, 
								vtexcmpg_pml, vtexcmpg_sndr, vtexcmpg_ec_rfd, vtexcmpg_ec_rfd_in,
								vtexcmpg_ec_ins, vtexcmpg_ec_ins_ord, 
								vtexcmpg_ec_rfd_coup, vtexcmpg_vlr_mnd,
								vtexcmpg_vlr_cod, vtexcmpg_plcy
							) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GtSQLVlStr($__enc, "text"),
                       GtSQLVlStr(ctjTx($_POST['vtexcmpg_clvtex'],'out'), "text"),
                       GtSQLVlStr(ctjTx($_POST['vtexcmpg_nm'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['vtexcmpg_pml'],'out'), "text"),
					   GtSQLVlStr($_POST['vtexcmpg_sndr'], "int"),
					   GtSQLVlStr($_POST['vtexcmpg_ec_rfd'], "int"),
					   GtSQLVlStr($_POST['vtexcmpg_ec_rfd_in'], "int"),
					   GtSQLVlStr($_POST['vtexcmpg_ec_ins'], "int"),
					   GtSQLVlStr($_POST['vtexcmpg_ec_ins_ord'], "int"),
					   GtSQLVlStr($_POST['vtexcmpg_ec_rfd_coup'], "int"),
					   GtSQLVlStr($_POST['vtexcmpg_vlr_mnd'], "int"),
					   GtSQLVlStr($_POST['vtexcmpg_vlr_cod'], "int"),
					   GtSQLVlStr($_POST['vtexcmpg_plcy'], "int"));	

	$Result = $__cnx->_prc($insertSQL);
	
	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		_ErrSis(['p'=>$insertSQL, 'd'=>$__cnx->c_p->error]);
	}
	
	$__cnx->_clsr($Result);
	
}

// Modificación de Registro
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdVtexCmpg")) { 
	
	$updateSQL = sprintf("UPDATE "._BdStr(DBT).TB_VTEX_CMPG." SET 
								vtexcmpg_nm=%s, vtexcmpg_pml=%s, vtexcmpg_sndr=%s, 
								vtexcmpg_ec_rfd=%s, vtexcmpg_ec_rfd_in=%s, vtexcmpg_ec_ins=%s, vtexcmpg_ec_ins_ord=%s, vtexcmpg_ec_rfd_coup=%s,
								vtexcmpg_vlr_mnd=%s, vtexcmpg_vlr_cod=%s, vtexcmpg_plcy=%s
						WHERE vtexcmpg_enc=%s",
						GtSQLVlStr(ctjTx($_POST['vtexcmpg_nm'],'out'), "text"),
						GtSQLVlStr(ctjTx($_POST['vtexcmpg_pml'],'out'), "text"),
						GtSQLVlStr($_POST['vtexcmpg_sndr'], "int"),
						GtSQLVlStr($_POST['vtexcmpg_ec_rfd'], "int"),
						GtSQLVlStr($_POST['vtexcmpg_ec_rfd_in'], "int"),
						GtSQLVlStr($_POST['vtexcmpg_ec_ins'], "int"),
						GtSQLVlStr($_POST['vtexcmpg_ec_ins_ord'], "int"),
						GtSQLVlStr($_POST['vtexcmpg_ec_rfd_coup'], "int"),
						GtSQLVlStr($_POST['vtexcmpg_vlr_mnd'], "int"),
						GtSQLVlStr($_POST['vtexcmpg_vlr_cod'], "int"),
						GtSQLVlStr($_POST['vtexcmpg_plcy'], "int"),
						GtSQLVlStr($_POST['vtexcmpg_enc'], "text"));

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
	
	$__cnx->_clsr($Result);
	
}

?>