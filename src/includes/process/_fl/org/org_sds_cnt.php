<?php
	
// Ingreso de Registro
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdOrgSdsCnt")) { 
		
		$__CntIn = new CRM_Cnt();
		
		if( !isN($_POST['orgsdscnt_orgsds_new']) ){ $_orgsds = $_POST['orgsdscnt_orgsds_new']; }
		elseif( !isN($_POST['orgsdscnt_orgsds']) ){ $_orgsds = $_POST['orgsdscnt_orgsds']; }
		
		$__CntIn->cnt_org[] = [
			'id'=>$_orgsds,
			/*'tpr'=>$_POST['orgsdscnt_tpr_i'],*/
			'tpr'=>$_POST['orgsdscnt_tpr'],
			'tpr_o'=>$_POST['orgsdscnt_tpr_o'],
			'are'=>$_POST['orgsdscnt_are'],
			'crs'=>$_POST['orgsdscnt_crs'],
			'smst'=>$_POST['orgsdscnt_smst']
		];
		
		if( !isN($_POST['cnt_enc']) ){
			
			$__CntIn->cnt_id = $_POST['cnt_enc'];
			
			$__CntIn->cnt_dc = $_POST['cnt_dc_new'];
			$__CntIn->cnt_dc_tp = $_POST['cnt_dc_tp_new'];
			$__CntIn->cnt_eml = ctjTx($_POST['cnt_eml_new'],'out');
			$__CntIn->cnt_tel = ['no'=>ctjTx($_POST['cnt_tel_new'],'out'),
								 'tp'=>ctjTx($_POST['cnt_tel_tp_new'],'out')
								];
			$inc = 'ok';
			
		}else{
			
			$__CntIn->cnt_nm = $_POST['cnt_nm'];
			$__CntIn->cnt_ap = $_POST['cnt_ap'];
			$__CntIn->cnt_dc = $_POST['cnt_dc'];
			
			$__CntIn->cnt_dc_tp = $_POST['cnt_dc_tp'];
			$__CntIn->cnt_eml = ctjTx($_POST['cnt_eml'],'out');
			$__CntIn->cnt_sx = $_POST['cnt_sx'];
			
			$__CntIn->cnt_sds = $_POST['orgsdscnt_sds'];
			
			$__CntIn->cnt_tel = ['no'=>ctjTx($_POST['cnt_tel'],'out'),
								 'tp'=>ctjTx($_POST['cnt_tel_tp'],'out'),
								 'ext'=>ctjTx($_POST['cnt_tel_ext'],'out'),
								 'ps'=>ctjTx($_POST['cnt_tel_ps'],'out')
								];

			$sndi = $_POST['orgcnt_sndi'];
			
			if(!isN($sndi)){
				$inc = 'ok';
				$__CntIn->plcy_id = $_POST['orgcnt_plcy'];
			}else{
				$inc = 'no';
			}
			
		}

		if($inc == 'ok'){
			$__dtus_in = $__CntIn->_Cnt();
		}elseif($inc == 'no'){
			$__dtus_in->w = 'Para guardar, debes acertar la politica de datos.';	
		}	

			
		
		
		if($__dtus_in->e == 'ok'){
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			$rsp['w'] = $__dtus_in->w;
			$rsp['i'] = $__dtus_in->i;
			$rsp['o'] = $__CntIn;
			_ErrSis(['p'=>$insertSQL, 'd'=>$__dtus_in->w]);
		}
		
		
}

// Modificación de Registro
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdCnt")) { 


}

// Elimino el Registro
if ((isset($_POST['id_cnt'])) && ($_POST['id_cnt'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdCnt'))) { 
	$deleteSQL = sprintf('DELETE FROM '.TB_CNT.' WHERE cnt_enc=%s', GtSQLVlStr($_POST['cnt_enc'], 'text'));
	$Result = $__cnx->_prc($deleteSQL); if($Result){$rsp['e'] = 'ok'; $rsp['m'] = 1; $rsp['a'] = Aud_Sis(Aud_Dsc(28, $_POST['cnt_nm'], $__cnx->c_p->insert_id), $rsp['v']);}else{$rsp['e'] = 'no';$rsp['m'] = 2; _ErrSis(['p'=>$deleteSQL, 'd'=>$__cnx->c_p->error]);}
}
?>