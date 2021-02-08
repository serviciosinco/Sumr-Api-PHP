<?php
	
$__CntIn = new CRM_Cnt();
	
$__gtdc = _ChckCntDc([ 'id'=>$_POST['cntdc_dc'] ]);
$__gtdc_bfr = _ChckCntDc([ 'id'=>$_POST['cntdc_dc_bfr'] ]); 
			
// Ingreso de Registro
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdCntDc")) { 
				
	if ( !isN($_POST['cntdc_dc']) ){
		
		$__dtdc = _ChckCntDc([ 'id'=>$_POST['cntdc_dc'] ]);
		
		if($__dtdc->e == 'ok' && isN($__dtdc->id)){
			
			$__enc = Enc_Rnd($_POST['cntdc_dc'].'-'.$_POST['cntdc_tp']);
			
			$insertSQL = sprintf("INSERT INTO ".TB_CNT_DC." (cntdc_enc, cntdc_dc, cntdc_exp, cntdc_cnt, cntdc_tp) VALUES (%s, %s, %s, (SELECT id_cnt FROM ".TB_CNT." WHERE cnt_enc = %s), %s)",
	                       GtSQLVlStr($__enc, "text"),
	                       GtSQLVlStr(ctjTx($_POST['cntdc_dc'],'out'), "text"),
						   GtSQLVlStr($_POST['cntdc_exp'], "date"),
						   GtSQLVlStr($_POST['cntdc_cnt'], "text"),
						   GtSQLVlStr($_POST['cntdc_tp_p'], "int"));
			
			$Result = $__cnx->_prc($insertSQL); 
			
	 		if($Result){
		 		
		 		$__CntIn->UpdCntFA([ 'id'=>$_POST['cntdc_cnt'] ]); 				    
				$rsp['e'] = 'ok';
				$rsp['m'] = 1;
				$rsp['a'] = Aud_Sis(Aud_Dsc(238, 'El documento del contacto', $__cnx->c_p->insert_id), $rsp['v']);
				
			}else{
				
				$rsp['e'] = 'no';
				$rsp['m'] = 2;
				$rsp['err'] = $__cnx->c_p->error;
					
			}
			
		}else{
			
			if(($__gtdc->cnt->id != $_POST['cntdc_cnt'])){ $_c1 = $__gtdc->cnt->id; $_c2 = $_POST['cntdc_cnt']; }
			/*if($__gtdc->e == 'ok'){ $rsp['cl'] = " SUMR_Main.cnt_mtch({id:'".$__gtdc->cnt->id."', rld:'".DV_LSFL."bad_dc', tb:2, _c1:'{$_c1}', _c2:'{$_c2}' }); "; }*/
			$rsp['cn'] = $__dtdc->cnt;
			$rsp['w'] = 'El documento ya esta asociado con el usuario '.$__dtdc->cnt->nm.' '.$__dtdc->cnt->ap;
		
		}				
			
	}else{
		
		$rsp['m'] = 8;
			
	}
}

// Modificación de Registro
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdCntDc")) { 

	
	if ( $_POST['cntdc_dc'] != '') { 	
		
		$updateSQL = sprintf("UPDATE ".TB_CNT_DC." SET cntdc_dc=%s, cntdc_exp=%s, cntdc_tp=%s WHERE cntdc_enc=%s",
						   GtSQLVlStr(trim(ctjTx($_POST['cntdc_dc'],'out')), "text"),
						   GtSQLVlStr($_POST['cntdc_exp'], "date"),
						   GtSQLVlStr(ctjTx($_POST['cntdc_tp_p'],'out'), "text"),	
	                       GtSQLVlStr($_POST['cntdc_enc'], "text"));
		
		$Result = $__cnx->_prc($updateSQL); 
		
		if($Result){
			$__CntIn->UpdCntFA([ 'id'=>$_POST['cntdc_cnt'] ]);
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
			$rsp['a'] = Aud_Sis(Aud_Dsc(239, 'El documento del contacto', $_POST['id_cntdc']), $rsp['v']);
	 	}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;

			if(($__gtdc->cnt->id != $__gtdc_bfr->cnt->id)){ $_c1 = $__gtdc->cnt->id; $_c2 = $__gtdc_bfr->cnt->id; }
			if($__gtdc->e == 'ok'){ $rsp['cl'] = " SUMR_Main.cnt_mtch({id:'".$__gtdc->cnt->id."', rld:'".DV_LSFL."bad_dc', tb:2, _c1:'{$_c1}', _c2:'{$_c2}' }); "; }			
		}
	}else{	
		$rsp['m'] = 8;		
	} 
}

// Elimino el Registro
if ((isset($_POST['id_cntdc'])) && ($_POST['id_cntdc'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdCntDc'))) { 
	$deleteSQL = sprintf('DELETE FROM '.TB_CNT_DC.' WHERE cntdc_enc=%s', GtSQLVlStr($_POST['cntdc_enc'], 'text'));
	$Result = $__cnx->_prc($deleteSQL); if($Result){$rsp['e'] = 'ok'; $rsp['m'] = 1;
	$rsp['a'] = Aud_Sis(Aud_Dsc(240, 'El documento del contacto', $_POST['id_cntdc']), $rsp['v']);
	}else{$rsp['e'] = 'no';$rsp['m'] = 2; _ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);}
}
?>