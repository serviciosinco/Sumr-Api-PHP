<?php
	
$__CntIn = new CRM_Cnt();
	
$__gtdc = _ChckCntTel(['id'=>$_POST['cnttel_tel'], 'cnt'=>$_POST['cnttel_cnt'] ]);
$__gtdc_bfr = _ChckCntTel(['id'=>$_POST['cnttel_tel_bfr'], 'cnt'=>$_POST['cnttel_cnt']]); 
			
// Ingreso de Registro
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdCntTel")) { 
				
	if ( $_POST['cnttel_tel'] != '') {

		$__dtdc = _ChckCntTel([ 'id'=>$_POST['cnttel_tel'], 'cnt'=>$_POST['cnttel_cnt'] ]);
		
		if($__dtdc->e == 'ok' && isN($__dtdc->id)){
			
			$__enc = Enc_Rnd($_POST['cnttel_tel'].'-'.$_POST['cnttel_cnt']);

			$insertSQL = sprintf("INSERT INTO ".TB_CNT_TEL." (cnttel_enc, cnttel_tel, cnttel_cnt, cnttel_tp, cnttel_ps, cnttel_est) VALUES (%s, %s, (SELECT id_cnt FROM ".TB_CNT." WHERE cnt_enc=%s) , %s, %s, %s)",
	                       	GtSQLVlStr($__enc, "text"),
						   	GtSQLVlStr(ctjTx($_POST['cnttel_tel'],'out'), "text"),
						   	GtSQLVlStr($_POST['cnttel_cnt'], "text"),
						   	GtSQLVlStr($_POST['cnttel_tp'], "int"),
						   	GtSQLVlStr($_POST['cnttel_ps'], "int"),
						   	GtSQLVlStr(_CId('ID_SISTELEST_ACTV')	, "int"));	
						   	
			$Result = $__cnx->_prc($insertSQL);
			
	 		if($Result){
		 		
		 		$__id_ing = $__cnx->c_p->insert_id;
		 		
		 		$__CntIn->UpdCntFA([ 'id'=>$_POST['cnttel_cnt'] ]); 
		 		
		 		$___plcydt = GtClPlcyDt([ 'id'=>Php_Ls_Cln($_POST['_cnt_plcy_tel']), 't'=>'enc' ]);
		 		$__CntIn->plcy_id = $___plcydt->id;
		 		$__CntIn->InCntTel_Plcy(['cnttel'=>$__id_ing]);
		 		
				$rsp['enc'] = $__enc;   
				$rsp['e'] = 'ok';
				$rsp['m'] = 1;
				$rsp['a'] = Aud_Sis(Aud_Dsc(247, 'telefono del contacto', $__id_ing), $rsp['v']);
				
			}else{
				$rsp['e'] = 'no';
				$rsp['m'] = 2;
				
				if(($__gtdc->cnt->id != $__gtdc_bfr->cnt->id)){ $_c1 = $__gtdc->cnt->id; $_c2 = $__gtdc_bfr->cnt->id; }
				if($__gtdc->e == 'ok' && !isN($__gtdc->e)){ $rsp['cl'] = " SUMR_Main.cnt_mtch({id:'".$__gtdc->cnt->id."', rld:'".DV_LSFL."bad_tel', tb:2, _c1:'{$_c1}', _c2:'{$_c2}' }); "; }	
			}
			
		}else{
			
			$rsp['cn'] = $__dtdc->cnt;
			$rsp['w_us'] = 'El telefono ya esta asociado con el usuario '.$__dtdc->cnt->nm.' '.$__dtdc->cnt->ap;
		
		}
			
	}else{
		
		$rsp['m'] = 8;
			
	}
}

// Modificación de Registro
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdCntTel")) { 

	
	if ( $_POST['cnttel_tel'] != '') { 	
		$updateSQL = sprintf("UPDATE ".TB_CNT_TEL." SET cnttel_tel=%s, cnttel_tp=%s, cnttel_ps=%s WHERE cnttel_enc=%s",
						   GtSQLVlStr(ctjTx($_POST['cnttel_tel'],'out'), "text"),
						   GtSQLVlStr($_POST['cnttel_tp'], "int"),
						   GtSQLVlStr($_POST['cnttel_ps'], "int"),	
	                       GtSQLVlStr($_POST['cnttel_enc'], "text"));
		
		$Result = $__cnx->_prc($updateSQL); 
		
		if($Result){
			
			$__CntIn->UpdCntFA([ 'id'=>$_POST['cnttel_cnt'] ]); 
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
			$rsp['a'] = Aud_Sis(Aud_Dsc(248, 'telefono del contacto', $_POST['id_cnttel']), $rsp['v']);
			
		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;

			if(($__gtdc->cnt->id != $__gtdc_bfr->cnt->id)){ $_c1 = $__gtdc->cnt->id; $_c2 = $__gtdc_bfr->cnt->id; }
			if($__gtdc->e == 'ok'){ $rsp['cl'] = " SUMR_Main.cnt_mtch({id:'".$__gtdc->cnt->id."', rld:'".DV_LSFL."bad_tel', tb:2, _c1:'{$_c1}', _c2:'{$_c2}' }); "; }			
		}
	}else{	
		$rsp['m'] = 8;		
	} 
}

// Elimino el Registro
if ((isset($_POST['id_cnttel'])) && ($_POST['id_cnttel'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdCntTel'))) { 
	$deleteSQL = sprintf('DELETE FROM '.TB_CNT_TEL.' WHERE cnttel_enc=%s', GtSQLVlStr($_POST['cnttel_enc'], 'text'));
	$Result = $__cnx->_prc($deleteSQL); if($Result){$rsp['e'] = 'ok'; $rsp['m'] = 1; 
	$rsp['a'] = Aud_Sis(Aud_Dsc(249, 'telefono del contacto', $_POST['id_cnttel']), $rsp['v']);
	}else{$rsp['e'] = 'no';$rsp['m'] = 2; _ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);}
}
?>