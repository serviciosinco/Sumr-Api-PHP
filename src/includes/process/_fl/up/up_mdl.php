<?php 
	
$__tsim = Php_Ls_Cln($_POST['__tsim']);

if($__tsim == 'mdl_fle'){
	$__rlc_bd = TB_MDL_FLE;
	$__rlc_px = 'mdlfle'; 
	$__rlc_px2 = 'mdl';
}	

if (((isset($_POST['MM_update_fle']))&&($_POST['MM_update_fle'] == 'FleUplNw'))) {
	
	if (!empty($_FILES)) {
		
		$__i_f = Php_Ls_Cln($_POST['_id_fle']);
		$__i_r = Php_Ls_Cln($_POST['_id_rlc']);
		$____fl_fld = DIR_FLE_SIM;
		$____fl_nm = 'fle';
		
		$Sch = array(DMN_BS);
		$Chn = array('');
		
		$Fldr_Rl = str_replace($Sch,$Chn,$____fl_fld);
		
		if($__tsim == 'sv_ctc_adj' || $__tsim == 'sim_evn_evd'){
			$allowed = ['docx','doc'];
		}elseif($__tsim == 'clg_fle'){
			$allowed = ['pdf'];
		}elseif($__tsim == 'mdl_fle' || $__tsim == 'sim_bd_fle' || $__tsim == 'sim_frmt_fle' || $__tsim == 'sim_alrt_fle'){
			$allowed = ['docx', 'doc', 'pdf', 'xls', 'pptx', 'pst', '.ppt', 'xlsx', 'pps', 'xps', 'xlt', 'pdf', 'xlsb', 'png', 'jpg', 'gif', 'pot'];
		}elseif($__tsim == 'brf_fle' || $__tsim == 'sim_brf_gst_fle'){
			$allowed = ['jpg','jpeg','pdf','png','docx','pptx','doc','ppt','.pst','xlsx'];
		}else{
			$allowed = ['jpg','jpeg','gif','pdf','png'];
		}
		
		
		$__fl_nm_bfr = $_FILES['upl']['name'];
		
		
		if(isset($_FILES['upl']) && $_FILES['upl']['error'] == 0){
			
			$__fl_ext = pathinfo($_FILES['upl']['name'], PATHINFO_EXTENSION);
			
			if(!in_array(strtolower($__fl_ext), $allowed)){
				
				$rsp['status'] = 'error'; $rsp['w'] = TX_FLE_NO_SUP;
				
			}else{
				
				global $__cnx;
				
				$__fl_nm = $_FILES['upl']['name'];
				$__fl_sze = $_FILES['upl']['size'];
				$__tmp_nm = $_FILES['upl']['tmp_name'];
				
				if($__i_f == '' || $__i_f == NULL){
					
					$__enc = Enc_Rnd($__fl_nm.'-'.$__nw_nm);
					
					$insertSQL = sprintf("INSERT INTO "._BdStr(DBM).TB_FLE." (fle_enc, fle_fle, fle_us, fle_nm, fle_sze, fle_ext, fle_fi) VALUES (%s, %s, %s, %s, %s, %s, %s)",
							GtSQLVlStr($__enc, "text"),
							GtSQLVlStr($__nw_nm, "text"),
							GtSQLVlStr(SISUS_ID, "int"),
							GtSQLVlStr($__fl_nm_bfr, "text"),
							GtSQLVlStr($__fl_sze, "double"),
							GtSQLVlStr($__fl_ext, "text"),
							GtSQLVlStr(SIS_F_D, "date"));	

					$Result = $__cnx->_prc($insertSQL);		
					
					$_i = $__cnx->c_p->insert_id;
					
					//$rsp['w_i'] = $__cnx->c_p->error;
					
					if($_i != ''){
						
						$__enc = Enc_Rnd($_i.'-'.$__i_r);
						$insertSQL_Rlc = sprintf("INSERT INTO ".$__rlc_bd." ({$__rlc_px}_enc, {$__rlc_px}_fle, {$__rlc_px}_{$__rlc_px2}, {$__rlc_px}_fi, {$__rlc_px}_fa) VALUES (%s,%s,(SELECT id_mdl FROM ".TB_MDL." WHERE mdl_enc = %s), %s, %s)",
								GtSQLVlStr($__enc, "text"),
								GtSQLVlStr($_i, "int"),
								GtSQLVlStr($__i_r, "text"),
								GtSQLVlStr(SIS_F_D, "date"),
								GtSQLVlStr(SIS_F_D, "date"));
						$ResultRlc = $__cnx->_prc($insertSQL_Rlc);
						//$rsp['w_i_r'] = $insertSQL_Rlc.' - '.$__cnx->c_p->error;
						
					}
					
				}else{
					$_i = $__i_f;
				}
				
				if(!isN($_i)){
					
					$rsp['i'] = $_i;
					
					$__nw_nm = $____fl_nm.'_'.$_i.'.'.$__fl_ext;
					$__nw_fld = '../../'.$Fldr_Rl;
					$__nw_fld = '../../../'.DIR_TMP_FLE_FLE;
					
					//$rsp['move_to'] = $__nw_fld.$__nw_nm;
											
					try{	
						$_sve = $_aws->_s3_put([ 'b'=>'anx', 'fle'=>_TmpFixDir($__nw_fld.$__nw_nm), 'src'=>$__tmp_nm, 'ctp'=>mime_content_type($__tmp_nm), 'cfr'=>'ok' ]);
					}catch(Exception $e){
						$rsp['e'] = 'no';
						$rsp['w'] = $e->getMessage();
					}				
										
					if(move_uploaded_file($__tmp_nm, $__nw_fld.$__nw_nm) && $_sve->e == 'ok'){
						
						$updateSQL = sprintf("UPDATE "._BdStr(DBM).TB_FLE." SET fle_sze=%s, fle_fle=%s, fle_ext=%s WHERE id_fle=%s",                    				
												GtSQLVlStr($__fl_sze, "double"),
												GtSQLVlStr($__nw_nm, "text"),
												GtSQLVlStr($__fl_ext, "text"),                						 			
												GtSQLVlStr($_i, "int"));	

						$Result = $__cnx->_prc($updateSQL);
						
						if(!$Result){ _ErrSis([ 'p'=>$updateSQL, 'd'=>$__cnx->c_p->error ]); }
						$rsp['w_update'] = $__cnx->c_p->error;
						
						//$rsp['mm'] = $updateSQL;
						
						$rsp['_enc'] = enCad($_i);
					
					}else{
						$rsp['status'] = 'error'; $rsp['w'] = TX_PRB_MOV_FLE;
					}
					
					$rsp['status'] = 'success';
					
				}else{
					
					$rsp['status'] = 'error'; $rsp['w'] = TX_NO_GRN_DB;
					_ErrSis([ 'p'=>$insertSQL, 'd'=>$__cnx->c_p->error ]);	
					
				}
				
			}			
		
		}else{
			
			$rsp['status'] = 'error'; $rsp['w'] = TX_NO_RCV_FLE; 
		
		}
		
	}

}else{
	
	$rsp['e'] = 'no'; $rsp['m'] = 2; $rsp['status'] = 'error';	$rsp['w'] = 'No Upd File';

}


Hdr_JSON();
$rtrn = json_encode($rsp); echo $rtrn;
?>