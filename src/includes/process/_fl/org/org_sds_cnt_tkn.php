<?php 
	// Ingreso de Registro

	if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdOrgSdsCntTkn")) { 
		
        $__enc = Enc_Rnd($_POST['orgsdscntpss_eml'].' - '.$_POST['orgsdscntpss_pss']);
        
        $___cntemldt = GtCntEmlDt(['id'=>$_POST['orgsdscntpss_eml'], 'tp'=>'enc', 'd'=>['plcy'=>'ok'] ]);

		$insertSQL = sprintf("INSERT INTO ".TB_ORG_SDS_CNT_PSS." (orgsdscntpss_enc, orgsdscntpss_orgsdscnt, orgsdscntpss_orgsds, orgsdscntpss_eml, orgsdscntpss_pss, orgsdscntpss_est) 
														VALUES (%s, %s, %s, %s, AES_ENCRYPT( %s , '".ENCRYPT_PASSPHRASE."' ), %s )",

						GtSQLVlStr(ctjTx($__enc, 'out'), "text"),
						GtSQLVlStr(ctjTx($_POST['orgsdscntpss_orgsdscnt'], 'out'), "int"),
						GtSQLVlStr(ctjTx($_POST['orgsdscntpss_orgsds'], 'out'), "int"),
						GtSQLVlStr(ctjTx($___cntemldt->eml, 'out'), "text"),
						GtSQLVlStr(ctjTx($_POST['orgsdscntpss_pss'], 'out'), "text"),
						GtSQLVlStr(1, "int"));
			
		$Result = $__cnx->_prc($insertSQL);
 		if($Result){

			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
			
		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			_ErrSis(['p'=>$insertSQL, 'd'=>$__cnx->c_p->error]);
        }
	}
	

	// Modificación de Registro primero este
	if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdOrgSdsCntTkn")) {

		$updateSQL = sprintf("UPDATE ".TB_ORG_SDS_CNT_PSS." SET orgsdscntpss_pss = AES_ENCRYPT( %s, '".ENCRYPT_PASSPHRASE."' ) , orgsdscntpss_est=%s WHERE orgsdscntpss_enc=%s",
						GtSQLVlStr(ctjTx($_POST['orgsdscntpss_pss'], 'out'), "text"),
						GtSQLVlStr(Html_chck_vl($_POST['orgsdscntpss_est']), "int"),
					   	GtSQLVlStr(ctjTx($_POST['orgsdscntpss_enc'], 'out'), "text"));

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