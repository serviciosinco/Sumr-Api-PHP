<?php
	
$__CntIn = new CRM_Cnt();	
	
$__gteml = _ChckCntEml([ 'id'=>$_POST['cnteml_eml'] ]);
$__gteml_bfr = _ChckCntEml([ 'id'=>$_POST['cnteml_eml_bfr'] ]); 
		
// Ingreso de Registro
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdCntEml")) { 
				
	if (filter_var( $_POST['cnteml_eml'] , FILTER_VALIDATE_EMAIL)) {
		
		$__dteml = _ChckCntEml([ 'id'=>$_POST['cnteml_eml'] ]);
		$__enc = Enc_Rnd($_POST['cnteml_eml'].'-'.$_POST['cnteml_cnt']);
		
		if($__dteml->e == 'no'){
			
			$insertSQL = sprintf("INSERT INTO ".TB_CNT_EML." (cnteml_enc, cnteml_eml, cnteml_tp, cnteml_cnt, cnteml_cld, cnteml_est, cnteml_prty) VALUES (%s, %s, %s,(SELECT id_cnt FROM ".TB_CNT." WHERE cnt_enc=%s), %s, %s, %s)",			
	                       GtSQLVlStr($__enc, "text"),
	                       GtSQLVlStr( strtolower(ctjTx($_POST['cnteml_eml'],'out')) , "text"),
	                       GtSQLVlStr($__gteml->chk->tp, "int"),
						   GtSQLVlStr($_POST['cnteml_cnt'], "text"),
						   GtSQLVlStr(_CId('ID_CLD_RGLR'), "int"),
						   GtSQLVlStr(_CId('ID_SISEMLEST_NOCHCK'), "int"),
						   GtSQLVlStr(1, "int"));			
			
			
			$Result = $__cnx->_prc($insertSQL);

	 		if($Result){
		 		$___plcydt = GtClPlcyDt([ 'id'=>Php_Ls_Cln($_POST['_cnt_plcy_eml']), 't'=>'enc' ]);
		 		$__CntIn->plcy_id = $___plcydt->id;
		 		$__CntIn->InCntEml_Plcy(['cnteml'=>$__cnx->c_p->insert_id]);
		 		
		 		$__CntIn->UpdCntFA([ 'id'=>$_POST['cnteml_cnt'] ]); 

				//$rsp['i'] = $__cnx->c_p->insert_id;				   
				$rsp['e'] = 'ok';
				$rsp['m'] = 1;
				$rsp['a'] = Aud_Sis(Aud_Dsc(241, 'Se ingresó el email del contacto', $__cnx->c_p->insert_id), $rsp['v']);
			}else{
				$rsp['e'] = 'no';
				$rsp['m'] = 2;
				$rsp['err'] = $insertSQL.$__cnx->c_p->error;
			}	
		}else{	
			
			if(($__gteml->cnt->id != $_POST['cnteml_cnt'])){ $_c1 = $__gteml->cnt->id; $_c2 = $_POST['cnteml_cnt']; }
			if($__gteml->e == 'ok'){ $rsp['cl'] = " SUMR_Main.cnt_mtch({id:'".$__gteml->cnt->id."', rld:'".DV_LSFL."bad_eml', tb:2, _c1:'{$_c1}', _c2:'{$_c2}' }); "; }
			$rsp['cn'] = $__dteml->cnt;
			//$rsp['w'] = 'El correo ya esta asociada con el usuario '.$__dteml->cnt->id.' '.$__dteml->cnt->nm.' '.$__dteml->cnt->ap;
		}	
	}else{
		$rsp['m'] = 8;		
	}
}

// Modificación de Registro
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdCntEml")) { 

	
	if (filter_var( $_POST['cnteml_eml'] , FILTER_VALIDATE_EMAIL)) { 	
		
		$updateSQL = sprintf("UPDATE ".TB_CNT_EML." SET cnteml_eml=%s WHERE cnteml_enc=%s LIMIT 1",
						   GtSQLVlStr( strtolower( trim(ctjTx($_POST['cnteml_eml'],'out')) ) , "text"),	
	                       GtSQLVlStr($_POST['cnteml_enc'], "text"));
		
		$Result = $__cnx->_prc($updateSQL); 
		
		if($Result){
			
			$__CntIn->UpdCntFA([ 'id'=>$_POST['cnteml_cnt'] ]); 
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
			$rsp['a'] = Aud_Sis(Aud_Dsc(242, 'Se ingresó el email del contacto', $_POST['id_cnteml']), $rsp['v']);
		
		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			
			if(($__gteml->cnt->id != $__gteml_bfr->cnt->id)){ $_c1 = $__gteml->cnt->id; $_c2 = $__gteml_bfr->cnt->id; }
			if($__gteml->e == 'ok'){ $rsp['cl'] = " SUMR_Main.cnt_mtch({id:'".$__gteml->cnt->id."', rld:'".DV_LSFL."bad_eml', tb:2, _c1:'{$_c1}', _c2:'{$_c2}' }); "; }
			
		}
	}else{	
		$rsp['m'] = 8;		
	} 
}

// Elimino el Registro
if ((isset($_POST['id_cnteml'])) && ($_POST['id_cnteml'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdCntEml'))) { 
	$deleteSQL = sprintf('DELETE FROM '.TB_CNT_EML.' WHERE cnteml_enc=%s', GtSQLVlStr($_POST['cnteml_enc'], 'text'));
	$Result = $__cnx->_prc($deleteSQL); if($Result){$rsp['e'] = 'ok'; $rsp['m'] = 1;
	$rsp['a'] = Aud_Sis(Aud_Dsc(243, 'Se ingresó el email del contacto', $_POST['id_cnteml']), $rsp['v']);
	}else{$rsp['e'] = 'no';$rsp['m'] = 2; _ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);}
}

?>