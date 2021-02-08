<?php 
	// Ingreso de Registro
	if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdClAwsAcc")) { 

		$__enc = Enc_Rnd($_POST['awsacc_id'].'-'.$_POST['awsacc_key']);
		
        $insertSQL = sprintf("INSERT INTO "._BdStr(DBT).TB_AWS_ACC." (awsacc_enc, awsacc_cl, awsacc_id, awsacc_key, awsacc_scrt) VALUES 
                                                    (%s, (SELECT id_cl from "._BdStr(DBM).TB_CL." WHERE cl_enc = %s), %s, AES_ENCRYPT(%s, '".ENCRYPT_PASSPHRASE."'), AES_ENCRYPT(%s, '".ENCRYPT_PASSPHRASE."'))",
                        GtSQLVlStr(ctjTx($__enc, 'out'), "text"),
                        GtSQLVlStr(ctjTx($_POST['awsacc_cl'], 'out'), "text"),
		 				GtSQLVlStr(ctjTx($_POST['awsacc_id'], 'out'), "text"),
                        GtSQLVlStr(ctjTx($_POST['awsacc_key'], 'out'), "text"),
		 				GtSQLVlStr(ctjTx($_POST['awsacc_scrt'], 'out'), "text"));
			
        $Result = $__cnx->_prc($insertSQL);
        
 		if($Result){
	 		
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
			
		}else{
			$rsp['e'] = 'no';
            $rsp['m'] = 2;
            $rsp['ms'] = $insertSQL;
			_ErrSis(['p'=>$insertSQL, 'd'=>$__cnx->c_p->error]);
		}
	}

	// Modificación de Registro
	if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdClAwsAcc")) {

		$updateSQL = sprintf("UPDATE "._BdStr(DBT).TB_AWS_ACC." SET awsacc_id=%s, awsacc_key=AES_ENCRYPT(%s, '".ENCRYPT_PASSPHRASE."'), awsacc_scrt=AES_ENCRYPT(%s, '".ENCRYPT_PASSPHRASE."') WHERE awsacc_enc=%s",
                        GtSQLVlStr(ctjTx($_POST['awsacc_id'], 'out'), "text"),
                        GtSQLVlStr(ctjTx($_POST['awsacc_key'], 'out'), "text"),
                        GtSQLVlStr(ctjTx($_POST['awsacc_scrt'], 'out'), "text"),
                        GtSQLVlStr($_POST['awsacc_enc'], "text"));
		
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