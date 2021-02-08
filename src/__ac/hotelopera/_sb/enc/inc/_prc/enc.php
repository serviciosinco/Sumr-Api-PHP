<?php $_enc_dt = GtEncDt(['id'=>$_POST['enc_id']]); 
if ((isset($_POST["ENC_insert"])) && ($_POST["ENC_insert"] == "EdEncCnt")) { 
	
	
						$__CntIn = new CRM_Cnt([ 'cl'=>$row_Ls_Up_Rg['up_cl'] ]);
						$__CntIn->enc_id = $_POST['enc_id'];
						$__CntIn->mdlcnt_md = $_POST['cnt_m'];

						$__CntIn->cnt_nm = $_POST['cnt_nm'];
						$__CntIn->cnt_ap = $_POST['cnt_ap'];
						$__CntIn->cnt_dc = $_POST['cnt_dc'];
						$__CntIn->cnt_dc_tp = $_POST['cnt_dctp'];
						$__CntIn->cnt_sx = $_POST['cnt_sx'];
						$__CntIn->cnt_eml = ctjTx($_POST['cnt_eml'],'out');
						
						$__CntIn->cnt_cd = [		
												'id'=>ctjTx($_POST['cnt_cd'],'out'),
												'rel'=>ctjTx($_POST['cnt_cd_rel'],'out')
											];
						
						$__CntIn->cnt_tel = [
												'no'=>ctjTx($_POST['cnt_tel'],'out'), 
												'tp'=>ctjTx($_POST['cnt_tel_tp'],'out'),
												'ext'=>ctjTx($_POST['cnt_tel_ext'],'out'),
												'ps'=>ctjTx($_POST['cnt_tel_ps'],'out')
											];
						
						$__CntIn->cnt_emp = ctjTx($_POST['cnt_em'],'out');
						$__CntIn->cnt_prf = ctjTx($_POST['cnt_prf'],'out');
						$__CntIn->cnt_cmn = ctjTx($_POST['cnt_cmn'],'out');
						
						$__CntIn->cnt_bd = $_POST['cnt_bd'];
						$__CntIn->cnt_fnt = $_POST['cnt_fnt'];
						$__CntIn->cnt_est = $_POST['cnt_est'];
						$__CntIn->cnt_nw = 'ok';
						$__CntIn->tp_enc = '_enc';
						
						
						foreach($_enc_dt->fld as $_k){
							foreach($_k as $_k2 => $_v2){
								if($_POST[$_v2->key.'_Fld'] != '' || $_POST[$_v2->key.'_Fld'] != NULL){
									$__CntIn->dts[] = $_POST[$_v2->key.'_Fld'].' -|- '.$_POST[$_v2->key];
								}
							}
						}
						
						$PrcDt = $__CntIn->InEncCnt();
						
 		if($PrcDt->e == 'ok'){
			$rsp['i'] = $PrcDt->i;
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
			//$rsp['a'] = Aud_Sis(Aud_Dsc(40, $__rsp_i, $__rsp_i), $rsp['v']);
		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			$rsp['w'] = $PrcDt->w.' '.$PrcDt->w_all;
			$rsp['a'] = print_r($PrcDt, true);
		}
}

?>