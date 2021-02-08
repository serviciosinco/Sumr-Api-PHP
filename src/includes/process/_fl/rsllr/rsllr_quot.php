<?php
	
// Ingreso de Registro
if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdRsllrQuot")) { 
	
	$_cl_dt = GtClDt( CL_ENC, 'enc' );
	$_org_dt = GtOrgSdsDt([ 't'=>'enc', 'i'=>$_POST['quot_org'] ]);
	
	//$rsp['tmp_cl'] = $_cl_dt;
	//$rsp['tmp_org'] = $_org_dt;
	
	if(!isN($_cl_dt->id) && !isN($_org_dt->id)){
		
		$__enc = Enc_Rnd($_POST['quot_nm'].'-'.$_cl_dt->id.'-'.$_org_dt->id);
		
		$insertSQL = sprintf("INSERT INTO "._BdStr(DBR).TB_RSLLR_QUOT." (quot_enc, quot_cl, quot_org, quot_nm) VALUES (%s, %s, %s, %s)",	
	                   GtSQLVlStr(ctjTx($__enc,'out'), "text"),
	                   GtSQLVlStr($_cl_dt->id, "text"),
	                   GtSQLVlStr($_org_dt->id, "int"),
	                   GtSQLVlStr(ctjTx($_POST['quot_nm'],'out'), "text"));					   
		
		$Result = $__cnx->_prc($insertSQL);
			
		if($Result){	
			$_id = $__cnx->c_p->insert_id;
			$rsp['e'] = 'ok';
			$rsp['enc'] = $__enc;
			$rsp['m'] = 1;
		}else{
			$rsp['e'] = 'no';	 
			$rsp['m'] = 2;
			$rsp['w'] = $__cnx->c_p->error.' on '.$insertSQL;
			_ErrSis(['p'=>$insertSQL, 'd'=>$__cnx->c_p->error]);
		}
		
		
		/*	
		$__CntIn = new CRM_Cnt();
		
		if( !isN($_POST['orgsdscnt_orgsds_new']) ){ $_orgsds = $_POST['orgsdscnt_orgsds_new']; }
		elseif( !isN($_POST['orgsdscnt_orgsds']) ){ $_orgsds = $_POST['orgsdscnt_orgsds']; }
		
		$__CntIn->cnt_org[] = [
			'id'=>$_orgsds,
			'tpr'=>$_POST['orgsdscnt_tpr'],
			'tpr_o'=>$_POST['orgsdscnt_tpr_o'],
			'crg'=>$_POST['orgsdscnt_crg'],
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
														
			
		}
				
		$__dtus_in = $__CntIn->_Cnt();	
		
		
		if($__dtus_in->e == 'ok'){
			//$rsp['enc'] = $__dtus_in->enc;
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
		
		*/	
	
	}
		
}




// Modificación de Registro
if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdCnt")) { 


}

?>