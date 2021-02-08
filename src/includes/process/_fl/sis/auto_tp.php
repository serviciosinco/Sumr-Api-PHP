<?php

// Ingreso de Registro
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdAutoTp")) { 

        $__enc = Enc_Rnd($_POST['autotp_nm'].'-'.$_POST['autotp_key']);

		$insertSQL = sprintf("INSERT INTO "._BdStr(DBA).TB_AUTO_TP." (autotp_enc, autotp_prnt, autotp_nm, autotp_key, autotp_e, autotp_lmt_rg) VALUES (%s, %s, %s, %s, %s, %s)",
                       GtSQLVlStr($__enc, "text"),
                       GtSQLVlStr(ctjTx($_POST['autotp_prnt'],'out'), "int"),
					   GtSQLVlStr(ctjTx($_POST['autotp_nm'],'out'), "text"),
					   GtSQLVlStr(ctjTx($_POST['autotp_key'],'out'), "text"),
                       GtSQLVlStr(Html_chck_vl($_POST['autotp_e']), "int"),
                       GtSQLVlStr(ctjTx($_POST['autotp_lmt_rg'],'out'), "int"));			
		$Result = $__cnx->_prc($insertSQL);
		
 		if($Result){
			//$rsp['i'] = $__cnx->c_p->insert_id;
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
			$rsp['a'] = Aud_Sis(Aud_Dsc(415, $_POST['audtx_dsc'], $__cnx->c_p->insert_id), $rsp['v']);

		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			
			_ErrSis(['p'=>$insertSQL, 'd'=>$__cnx->c_p->error]);
		}
}

// Modificación de Registro
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdAutoTp")) { 
$updateSQL = sprintf("UPDATE "._BdStr(DBA).TB_AUTO_TP." SET autotp_prnt=%s, autotp_nm=%s, autotp_key=%s, autotp_e=%s, autotp_lmt_rg=%s WHERE autotp_enc=%s",
                        GtSQLVlStr(ctjTx($_POST['autotp_prnt'],'out'), "int"),
                        GtSQLVlStr(ctjTx($_POST['autotp_nm'],'out'), "text"),
                        GtSQLVlStr(ctjTx($_POST['autotp_key'],'out'), "text"),
                        GtSQLVlStr(Html_chck_vl($_POST['autotp_e']), "int"),
                        GtSQLVlStr(ctjTx($_POST['autotp_lmt_rg'],'out'), "int"),
					    GtSQLVlStr(ctjTx($_POST['autotp_enc'],'out'), "text"));
    
                        $rsp['m'] = $updateSQL;
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
}

// Modificación de Registro
if ((isset($_POST["MM_update_est"])) && ($_POST["MM_update_est"] == "EdAutoTp")) { 
    $updateSQL = sprintf("UPDATE "._BdStr(DBA).TB_AUTO_TP." SET autotp_e=%s WHERE autotp_enc=%s",
  
                            GtSQLVlStr(Html_chck_vl($_POST['autotp_e']), "int"),
                            GtSQLVlStr(ctjTx($_POST['autotp_enc'],'out'), "text"));
                            
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
    }

?>