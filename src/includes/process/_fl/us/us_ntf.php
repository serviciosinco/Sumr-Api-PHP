<?php

if ((isset($_POST["MMR_update"])) && ($_POST["MMR_update"] == "EdUsDvc")) { 
	
	if(!isN($_POST["gcm_sbsc"])){ $_upd[] = sprintf('usdvc_gcm_sbsc=%s', GtSQLVlStr($_POST["gcm_sbsc"], "text")); }
	if(!isN($_POST["gcm_tkn"])){ $_upd[] = sprintf('usdvc_gcm_tkn=%s', GtSQLVlStr($_POST["gcm_tkn"], "text")); }

	if(!isN( $_upd ) && defined('SISUS_ID')){

		$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_US_DVC." SET ".implode(',', $_upd)." WHERE usdvc_us=%s AND usdvc_id=%s",
							GtSQLVlStr(SISUS_ID, "int"),
							GtSQLVlStr($_POST["dvc"], "text"));

		$Result = $__cnx->_prc($updateSQL); 
		//$rsp['q'] = $updateSQL;

	}

	if($Result){
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['w'] = $__cnx->c_p->error;
	} 
	
	$__cnx->_clsr($Result);
	
}

?>