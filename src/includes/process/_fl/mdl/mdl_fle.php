<?php
// Modificación de Registro
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdMdlFle")) { 
$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_FLE." SET fle_dsc=%s, fle_kyw=%s, fle_pbl=%s, fle_sch=%s WHERE id_fle=%s",
                       GtSQLVlStr(ctjTx($_POST['fle_dsc'],'out'), "text"),
                       GtSQLVlStr(ctjMlt($_POST['fle_kyw']), "text"),
                       GtSQLVlStr( _NoNll(Html_chck_vl($_POST['fle_pbl'])) , "int"),
                       GtSQLVlStr($_POST['fle_sch'], "int"),
                       GtSQLVlStr($_POST['id_fle'], "int"));
	
	$Result = $__cnx->_prc($updateSQL); 
	if($Result){
		
		if(Html_chck_vl($_POST['fle_pbl']) == 1){
			$_tp = $_POST['fle_us_exc'];
			$_est = 2;
		}elseif(Html_chck_vl($_POST['fle_pbl']) == 2){
			$_tp = $_POST['fle_us_inc'];
			$_est = 1;
		}
		
		if($_tp != NULL){
			foreach($_tp as $_v){
				$insertSQL = sprintf("INSERT INTO "._BdStr(DBM).TB_FLE_US_EST." (fleusest_fle, fleusest_us, fleusest_est) VALUES ( %s, %s, %s )",
                       GtSQLVlStr($_POST['id_fle'], "int"),
                       GtSQLVlStr($_v, "int"),
                       GtSQLVlStr($_est, "int"));
				$ResultInsert = $__cnx->_prc($insertSQL);
			}
		}else{
			$insertSQL = sprintf("DELETE FROM "._BdStr(DBM).TB_FLE_US_EST." WHERE fleusest_fle = %s AND fleusest_est = %s ",
                       GtSQLVlStr($_POST['id_fle'], "int"),
                       GtSQLVlStr($_est, "int"));
			$ResultInsert = $__cnx->_prc($insertSQL);
		}
		
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		$rsp['qry'] = $updateSQL;
	}else{
		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		$rsp['w'] = $__cnx->c_p->error;
		_ErrSis(array('p'=>$updateSQL, 'd'=>$__cnx->c_p->error));
	} 
}

// Elimino el Registro
/*if ((isset($_POST['uid'])) && ($_POST['uid'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdMdlFle'))) { 
	$deleteSQL = sprintf('DELETE FROM '.TB_FLE.' WHERE fle_enc=%s', GtSQLVlStr($_POST['uid'], 'text'));
	 $Result = $__cnx->_prc($deleteSQL); if($Result){$rsp['e'] = 'ok'; $rsp['m'] = 1; 
	 //$rsp['a'] = Aud_Sis(Aud_Dsc(372, $_POST['fle_fle'], $_POST['uid']), $rsp['v']);
	 }else{$rsp['e'] = 'no';$rsp['m'] = 2;  _ErrSis(array('p'=>$deleteSQL, 'd'=>$__cnx->c_p->error));}
}*/

?>