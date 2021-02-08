<?php 
	
	$_aws = new API_CRM_Aws();
	$__ec_cmz = new API_CRM_ec_Cmz();	

	$Ls_Qry = sprintf('SELECT * FROM '._BdStr(DBM).TB_EC_CMZ.' 
									LEFT JOIN '._BdStr(DBM).TB_CL.' ON eccmz_cl = id_cl 
									LEFT JOIN '._BdStr(DBM).TB_EC.' ON ec_cmzrlc = id_eccmz 
									LEFT JOIN '._BdStr(DBM).TB_EC_CMZ_SGM.' ON eccmzsgm_eccmz = id_eccmz 
									WHERE id_eccmz = %s',
									GtSQLVlStr($_GET['id'], "int"));
									
	$Ls_Rg = $__cnx->_qry($Ls_Qry); 
	
	if($Ls_Rg){
		
		$row_Ls_Rg = $Ls_Rg->fetch_assoc();
		$Tot_Ls_Rg = $Ls_Rg->num_rows;
	
		if($Tot_Ls_Rg > 0){
			
			$__enc = Enc_Rnd($row_Ls_Rg['eccmz_ec'].'-'.$row_Ls_Rg['eccmz_nm'].'-'.SISUS_ID);

			if($row_Ls_Rg['eccmz_rlchdr'] == 0){ $vl = 0; }else{ $vl = $row_Ls_Rg['eccmz_rlchdr']; }
			
			$insertSQL = sprintf('INSERT INTO '._BdStr(DBM).TB_EC_CMZ.' (eccmz_enc, eccmz_cl, eccmz_nm, eccmz_ec, eccmz_rlctp, eccmz_us, eccmz_rlchdr, eccmz_est, eccmz_are, eccmz_sbj, eccmz_to, eccmz_bd, eccmz_f_snd, eccmz_h_snd, eccmz_sndr, eccmz_dsc) VALUES (%s, (SELECT id_cl FROM '._BdStr(DBM).TB_CL.' WHERE cl_enc=%s) ,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)',
								GtSQLVlStr($__enc, "text"),
								GtSQLVlStr(DB_CL_ENC, "text"),
								GtSQLVlStr(ctjTx($row_Ls_Rg['eccmz_nm']." ".SIS_H." - Copia",'out'), "text"),
								GtSQLVlStr($row_Ls_Rg['eccmz_ec'], "int"),
								GtSQLVlStr($row_Ls_Rg['eccmz_rlctp'], "int"),							
								GtSQLVlStr($_POST['_actfl_us'], "int"),
								$vl,
								GtSQLVlStr($row_Ls_Rg['eccmz_est'], "int"),
								GtSQLVlStr($row_Ls_Rg['eccmz_are'], "int"),
								GtSQLVlStr(ctjTx($row_Ls_Rg['eccmz_sbj'],'out'), "text"),
								GtSQLVlStr(ctjTx($row_Ls_Rg['eccmz_to'],'out'), "text"),
								GtSQLVlStr(ctjTx($row_Ls_Rg['eccmz_bd'],'out'), "text"),
								GtSQLVlStr(ctjTx($row_Ls_Rg['eccmz_f_snd'],'out'), "text"),
								GtSQLVlStr(ctjTx($row_Ls_Rg['eccmz_h_snd'],'out'), "text"),
								GtSQLVlStr($row_Ls_Rg['eccmz_sndr'], "int"),
								GtSQLVlStr(ctjTx($row_Ls_Rg['eccmz_dsc'],'out'), "text"));
		
			$Result = $__cnx->_prc($insertSQL);
			
			
			if($Result){
				
				$rsp['i'] = $__cnx->c_p->insert_id;

				do{
					
					if(!isN($row_Ls_Rg_Sgm['id_eccmzsgm'])){
						
						$__enc = Enc_Rnd($_POST['id_eccmz'].'-'.$_POST['eccmzsgm_sgm'].'-'.SISUS_ID);
						
						$_Qry = sprintf("INSERT INTO "._BdStr(DBM).TB_EC_CMZ_SGM." (eccmzsgm_enc, eccmzsgm_eccmz, eccmzsgm_sgm, eccmzsgm_vle, eccmzsgm_hb) VALUES (%s, %s, %s, %s, %s)",
							   GtSQLVlStr($__enc, "text"),
							   GtSQLVlStr($rsp['i'], "int"),
							   GtSQLVlStr($row_Ls_Rg_Sgm['eccmzsgm_sgm'], "int"),
							   GtSQLVlStr(ctjTx( _SpclChng($row_Ls_Rg_Sgm['eccmzsgm_vle']) ,'out','',true, array('qt'=>'no')), "text"),
							   GtSQLVlStr($row_Ls_Rg_Sgm['eccmzsgm_hb'], "int"));
							   
							   
						$_Rlst_Qry = $__cnx->_prc($_Qry);
					}
					
				}while($row_Ls_Rg_Sgm = $Ls_Rg->fetch_assoc());
				
				
				
				$Ls_Qry_img = sprintf('SELECT * FROM '._BdStr(DBM).TB_EC_CMZ_IMG.', '._BdStr(DBM).TB_EC_CMZ.' WHERE eccmzimg_eccmz = id_eccmz AND eccmzimg_eccmz = %s',
						GtSQLVlStr($_GET['id'], "int"));
				
				$Ls_Rg_img = $__cnx->_qry($Ls_Qry_img); 
				
				
				do{
					
					if(!isN($row_Ls_Rg_img['id_eccmzimg'])){
						
						
						//--------------------- Duplica Registro de Imagen ---------------------//
						
							
							$_Qry_img = sprintf("INSERT INTO "._BdStr(DBM).TB_EC_CMZ_IMG." (eccmzimg_eccmz, eccmzimg_img, eccmzimg_fle, eccmzimg_w, eccmzimg_h, eccmzimg_x, eccmzimg_x2, eccmzimg_y, eccmzimg_y2) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
								   GtSQLVlStr($rsp['i'], "int"),
								   GtSQLVlStr($row_Ls_Rg_img['eccmzimg_img'], "int"),
								   GtSQLVlStr(ctjTx($row_Ls_Rg_img['eccmzimg_fle'],'out'), "text"),
								   GtSQLVlStr($row_Ls_Rg_img['eccmzimg_w'], "int"),
								   GtSQLVlStr($row_Ls_Rg_img['eccmzimg_h'], "int"),
								   GtSQLVlStr($row_Ls_Rg_img['eccmzimg_x'], "int"),
								   GtSQLVlStr($row_Ls_Rg_img['eccmzimg_x2'], "int"),
								   GtSQLVlStr($row_Ls_Rg_img['eccmzimg_y'], "int"),
								   GtSQLVlStr($row_Ls_Rg_img['eccmzimg_y2'], "int"));
								   
							$_Rlst_Qry = $__cnx->_prc($_Qry_img);
							
							if($_Rlst_Qry){
								$__img_new_id = $__cnx->c_p->insert_id;
							}else{
								$__img_new_id = '';
							}
						
						//--------------------- Nuevo Nombre de Imagen - Copia Archivo ---------------------//
						
				
							if(!isN($__img_new_id)){
								
								$__nm_img_new = str_replace('cmz_'.$row_Ls_Rg_img['id_eccmzimg'], 'cmz_'.$__img_new_id, $row_Ls_Rg_img['eccmzimg_fle']);
								
								
								//UPDATE
								
								$_Qry_img_copy = sprintf("UPDATE "._BdStr(DBM).TB_EC_CMZ_IMG." SET eccmzimg_fle = %s WHERE id_eccmzimg = %s",
													GtSQLVlStr($__nm_img_new, "text"),
													GtSQLVlStr($__img_new_id, "int"));
								   
								$_Rlst_Qry = $__cnx->_prc($_Qry_img_copy);
								
								$file = DMN_FLE_EC_CMZ.$row_Ls_Rg_img['eccmzimg_fle'];
								$newfile = '../../../'.DIR_TMP_FLE.'ec/cmz/'.$__nm_img_new;
								$newfile_nmm = '../../../'.DIR_TMP_FLE.'ec/cmz/'.$row_Ls_Rg_img['eccmzimg_fle'];
								
								if(file_exists($newfile_nmm)){
									
									$_sve = $_aws->_s3_put([ 'b'=>'fle', 'fle'=>_TmpFixDir('ec/cmz/'.$__nm_img_new), 'src'=>$newfile_nmm, 'ctp'=>mime_content_type($newfile_nmm)/*, 'cfr'=>'ok'*/ ]);
	
									if ( copy($file, $newfile) && $_sve->e == 'ok') {
										
										$rsp['e_c'] = "Copy success!";
	
										$__nm_o_img_old = str_replace($row_Ls_Rg_img['id_eccmzimg'], $row_Ls_Rg_img['id_eccmzimg']."_o", $row_Ls_Rg_img['eccmzimg_fle']);
										$__nm_o_img_new = str_replace($row_Ls_Rg_img['id_eccmzimg'], $__img_new_id, $__nm_o_img_old);
										
										$file = DMN_FLE_EC_CMZ.$__nm_o_img_old;
										$newfile = '../../../'.DIR_TMP_FLE.'ec/cmz/'.$__nm_o_img_new;
										
										if ( copy($file, $newfile) ) {
											$rsp['e_c_o'] = "Copy Original success!";
										}else{
											$errors= error_get_last(); 
											$rsp['e_c_o'] = "COPY Original ERROR: ".$errors['type']; 
											$rsp['m_c_o'] = $errors['message'];
										}
									
									}else{
										$errors= error_get_last(); 
										$rsp['e_c'] = "COPY ERROR: ".$errors['type']; 
										$rsp['m_c'] = $errors['message'];
									}
								
								}
								
							}
							
						
						
						
					}
					
				}while($row_Ls_Rg_img = $Ls_Rg_img->fetch_assoc());
				
				
				$_ec_snd = new API_CRM_ec();
					
				$_ec_snd->ec_cl = $row_Ls_Rg['cl_enc'];	
				$_ec_snd->ec_frm = $row_Ls_Rg['ec_frm'];	
				$_ec_snd->ec_est = _CId('ID_SISEST_PRC');
				$_ec_snd->ec_cds = $row_Ls_Rg['ec_cds'];
				$_ec_snd->ec_tt = $row_Ls_Rg['ec_tt']." ".SIS_H." - Copia";
				$_ec_snd->ec_sbt = $row_Ls_Rg['ec_sbt'];
				$_ec_snd->ec_dsc = $row_Ls_Rg['ec_dsc'];
				//img	
				$_ec_snd->ec_em = $row_Ls_Rg['ec_em'];
				$_ec_snd->ec_cd = $row_Ls_Rg['ec_cd'];
				$_ec_snd->ec_fnd = $row_Ls_Rg['ec_fnd'];
				$_ec_snd->ec_spn = $row_Ls_Rg['ec_spn'];
				$_ec_snd->ec_w = $row_Ls_Rg['ec_w'];
				$_ec_snd->ec_fm = $row_Ls_Rg['ec_fm'];
				$_ec_snd->ec_pdf = $row_Ls_Rg['ec_pdf'];
				$_ec_snd->ec_ord = $row_Ls_Rg['ec_ord'];
				$_ec_snd->ec_pay = $row_Ls_Rg['ec_pay'];
				$_ec_snd->ec_nmr = $row_Ls_Rg['ec_nmr'];
				$_ec_snd->ec_lnk = $row_Ls_Rg['ec_lnk'];
				$_ec_snd->ec_lnk_nxt = $row_Ls_Rg['ec_lnk_nxt'];	
				$_ec_snd->ec_frw = $row_Ls_Rg['ec_frw'];
				$_ec_snd->ec_pml = $row_Ls_Rg['ec_pml'].SIS_F;
				//shr
				$_ec_snd->ec_sis = $row_Ls_Rg['ec_sis'];
				$_ec_snd->ec_us = $_POST['_actfl_us'];
				//us_nft
				$_ec_snd->ec_act_frm = $row_Ls_Rg['ec_act_frm'];
				$_ec_snd->ec_sbj = $row_Ls_Rg_POST['ec_sbj'];
				//fa
				$_ec_snd->ec_flj = $row_Ls_Rg['ec_flj'];
				$_ec_snd->ec_cmz = $row_Ls_Rg['ec_cmz'];
				$_ec_snd->ec_oth = $row_Ls_Rg['ec_oth'];
				$_ec_snd->ec_dmo = $row_Ls_Rg['ec_dmo'];
				//fi
				$_ec_snd->ec_cmzrlc = $rsp['i'];
				$_ec_snd->ec_tp = $row_Ls_Rg['_ec_tp'];
				
				$Result = $_ec_snd->_EcSve();
				
				if($Result->e == 'ok'){
					 
					$rsp['i'] = $Result->i;
					
					//$rsp['u_o'] = __AutoRUN([ 't'=>'ec', 's2'=>'ec_cmz', 'id'=>$rsp['i'] ]);

					$__ec_cmz->ec_cmz = $rsp['i'];
					$rsp['upd_cod'] = $_upd_cod = $__ec_cmz->_bld_ec([ 'cche'=>'ok' ]);

					if($_upd_cod->e == 'ok'){
						$rsp['e'] = 'ok';
						$rsp['m'] = 1;
					}

				}else{
					$rsp['e'] = 'no';
					$rsp['m'] = 2;
					$rsp['w'] = $Result->w;
				}
			
			}else{
				$rsp['e'] = 'no';
				$rsp['w'] = 'No ejecuto query '.$__cnx->c_p->error.' on '.$insertSQL;
			}
			
			
			
		}else{
			$rsp['e'] = 'no';
			$rsp['w'] = 'No se encontro registro '.$__cnx->c_p->error;
		}
	
	}else{
		
		$rsp['w'] = 'No se encontro registro '.$__cnx->c_p->error;
		
	} 
	
?>