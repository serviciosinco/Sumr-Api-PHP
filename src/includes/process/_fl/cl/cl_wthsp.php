<?php 
	// Ingreso de Registro
	if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdClWthsp")) { 

		$__enc = Enc_Rnd($_POST['wthsp_no'].'-'.$_POST['whtsp_api']);
		
        $insertSQL = sprintf("INSERT INTO "._BdStr(DBT).TB_WHTSP." (wthsp_enc, wthsp_cl, wthsp_no, whtsp_e, whtsp_api) VALUES 
                                                    (%s, (SELECT id_cl from "._BdStr(DBM).TB_CL." WHERE cl_enc = %s), %s, %s, %s)",
                        GtSQLVlStr(ctjTx($__enc, 'out'), "text"),
                        GtSQLVlStr(ctjTx($_POST['wthsp_cl'], 'out'), "text"),
		 				GtSQLVlStr(ctjTx($_POST['wthsp_no'], 'out'), "text"),
                        GtSQLVlStr(Html_chck_vl($_POST['whtsp_e']), "int"),
		 				GtSQLVlStr(ctjTx($_POST['whtsp_api'], 'out'), "int"));
			
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
	if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdClWthsp")) {

		$updateSQL = sprintf("UPDATE "._BdStr(DBT).TB_WHTSP." SET wthsp_no=%s, whtsp_e=%s, whtsp_api=%s WHERE wthsp_enc=%s",
                        GtSQLVlStr(ctjTx($_POST['wthsp_no'], 'out'), "text"),
                        GtSQLVlStr(Html_chck_vl($_POST['whtsp_e']), "int"),
                        GtSQLVlStr(ctjTx($_POST['whtsp_api'], 'out'), "int"),
                        GtSQLVlStr($_POST['wthsp_enc'], "text"));
		
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