<?php
// Ingreso de Registro
/*if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdCntApplAttr")) { 
				
	if ( $_POST['cntdc_dc'] != '') {
		
			$__enc = Enc_Rnd($_POST['cntapplattr_attr'].'-'.$_POST['cntapplattr_vl']);
			
			$insertSQL = sprintf("INSERT INTO ".TB_CNT_APPL_ATTR." (cntdc_enc, cntdc_dc, cntdc_exp, cntdc_cnt, cntdc_tp) VALUES (%s, %s, %s, (SELECT id_cnt FROM ".TB_CNT." WHERE cnt_enc = %s), %s)",
	                       GtSQLVlStr($__enc, "text"),
	                       GtSQLVlStr(ctjTx($_POST['cntdc_dc'],'out'), "text"),
						   GtSQLVlStr($_POST['cntdc_exp'], "date"),
						   GtSQLVlStr($_POST['cntdc_cnt'], "text"),
						   GtSQLVlStr($_POST['cntdc_tp_p'], "int"));
			
			
			$Result = $__cnx->_prc($insertSQL); 
			
	 		if($Result){
				$rsp['e'] = 'ok';
				$rsp['m'] = 1;
				$rsp['a'] = Aud_Sis(Aud_Dsc(238, 'El documento del contacto', $__cnx->c_p->insert_id), $rsp['v']);
			}else{
				$rsp['e'] = 'no';
				$rsp['m'] = 2;
				$rsp['err'] = $__cnx->c_p->error;
			}				
			
	}else{
		
		$rsp['m'] = 8;
			
	}
}*/

// Modificación de Registro
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdCntAppl")) { 

		$updateSQL = sprintf("UPDATE ".TB_CNT_APPL." SET cntappl_idappl=%s , cntappl_idcntrc=%s , cntappl_est=%s WHERE cntappl_enc=%s",
						   GtSQLVlStr($_POST['cntappl_idappl'], "int"),	
						   GtSQLVlStr($_POST['cntappl_idcntrc'], "int"),
						   GtSQLVlStr(Html_chck_vl($_POST['cntappl_est']), "int"),	
	                       GtSQLVlStr($_POST['cntappl_enc'], "text"));
		
		$Result = $__cnx->_prc($updateSQL); 
		
		if($Result){
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
	 	}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
		} 
		
}

// Elimino el Registro
/*if ((isset($_POST['id_cntdc'])) && ($_POST['id_cntdc'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdCntDc'))) { 
	$deleteSQL = sprintf('DELETE FROM '.TB_CNT_DC.' WHERE cntdc_enc=%s', GtSQLVlStr($_POST['cntdc_enc'], 'text'));
	$Result = $__cnx->_prc($deleteSQL); if($Result){$rsp['e'] = 'ok'; $rsp['m'] = 1;
	$rsp['a'] = Aud_Sis(Aud_Dsc(240, 'El documento del contacto', $_POST['id_cntdc']), $rsp['v']);
	}else{$rsp['e'] = 'no';$rsp['m'] = 2; _ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);}
}*/
?>