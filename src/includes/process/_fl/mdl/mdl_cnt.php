<?php 

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "EdMdlCnt")) { 

	$__dtmdl = GtMdlDt([ 't'=>'enc', 'id'=>$_POST['mdlcnt_mdl'], 't2'=>( (!isN($_POST["t2"]) && $_POST["t2"] == "act")? "act" : "" ) ]);
	$__dtest = GtCntEstDt([ 'id'=>$_POST['mdlcnt_est'], 't'=>'enc' ]);

	//Actividades
	if($_POST["t2"] == "act"){	
		$rsp['f'] = $__dtmdl->act->f;
		$rsp['h'] = $__dtmdl->act->h;
		$rsp['tx'] = $__dtmdl->tt;	
	}

	if(!isN($__dtmdl->id) /*&& !isN($__dtest->id)*/){
		

		$__cnx->c_p->autocommit(FALSE);
		$__prc_all = 'ok';
		$__CntIn = new CRM_Cnt();
		
		$__CntIn->gt_cl_id = DB_CL_ID;
		$__CntIn->gt_mdl_id = $__dtmdl->id;
		$__CntIn->mdlcnt_md = $_POST['mdlcnt_m'];
		
		$__CntIn->cnt_id = $_POST['mdlcnt_cnt'];
		$__CntIn->cnt_nm = $_POST['cnt_nm'];
		$__CntIn->cnt_ap = $_POST['cnt_ap'];
		$__CntIn->cnt_dc = $_POST['cnt_dc'];
		$__CntIn->cnt_dc_tp = $_POST['cnt_dctp'];
		$__CntIn->cnt_eml = ctjTx($_POST['cnt_eml'],'out');
		
		$__CntIn->cnt_cd[] = [		
								'id'=>ctjTx($_POST['cnt_cd_id'],'out'),
								'rel'=>ctjTx($_POST['cnt_cd_rel'],'out')
							];
		
		
		$__CntIn->cnt_tel = [
								'no'=>ctjTx($_POST['cnt_tel'],'out'),
								'tp'=>ctjTx($_POST['cnt_tel_tp'],'out'),
								'ext'=>ctjTx($_POST['cnt_tel_ext'],'out'),
								'ps'=>ctjTx($_POST['cnt_tel_ps'],'out')
							];

		$__CntIn->cnt_emp = ctjTx($_POST['mdlcnt_em'],'out');
		$__CntIn->cnt_prf = ctjTx($_POST['mdlcnt_prf'],'out');
		$__CntIn->cnt_cmn = ctjTx($_POST['mdlcnt_cmn'],'out');
		
		$__CntIn->cnt_prd = $_POST['mdlcnt_prd'];
		$__CntIn->cnt_bd = $_POST['mdlcnt_bd'];
		$__CntIn->cnt_fnt = $_POST['mdlcnt_fnt'];
		$__CntIn->cnt_clsds = $_POST['mdlcnt_cl_sds'];
		$__CntIn->cnt_est = $__dtest->id;
		$__CntIn->cnt_sndi = $_POST['cnt_sndi'];
		$__CntIn->cnt_nw = 'ok';
		$__CntIn->cnt_prty = 1;
		
		$__CntIn->rgs = 2;
		
		$__CntIn->snd->eml->adm = 'no';
		$__CntIn->snd->eml->us = 'no';
		$__CntIn->ck_in = 'ok';
		
		if(!isN(Php_Ls_Cln($_POST['_cnt_plcy']))){
			$___plcydt = GtClPlcyDt([ 'id'=>Php_Ls_Cln($_POST['_cnt_plcy']), 't'=>'enc' ]);
			$__CntIn->plcy_id = $___plcydt->id;	
		}
		
		if(!isN(Php_Ls_Cln($_POST['mdlcnt_sch']))){
			$__CntIn->cnt_sch = Php_Ls_Cln($_POST['mdlcnt_sch']);	
		}

		if(!isN(Php_Ls_Cln($_POST['maincnv_enc']))){
			$__CntIn->maincnv_enc = Php_Ls_Cln($_POST['maincnv_enc']);	
		}
		
		$__CntIn->invk->by = _CId('ID_SISINVK_CRM');

		if(!isN($_POST['cnt_sndi'])){
			$PrcDt = $__CntIn->MdlCnt();
			if(Dvlpr()){ $rsp['tmppppp___prc'] = $PrcDt; }
		}else{
			$rsp['w'][] = 'Para guardar se necesita aceptar la politica de datos.';	
			$rsp['w_us'] = 'Para guardar se necesita aceptar la política de datos.';
		}
		

	}			
					
	if(!isN($PrcDt->i) && isN($PrcDt->w)){
		
		//$rsp['i'] = $PrcDt->enc;
		$rsp['enc'] = $PrcDt->enc;
		$rsp['e'] = 'ok';
		$rsp['m'] = 1;
		$rsp['a'] = Aud_Sis(Aud_Dsc(326, $_POST['cnt_nm'], $PrcDt->i), $rsp['v']);
		
		$__CntIn->cnt_id = $PrcDt->i;
		$__CntIn->cnt_org[] = [ 'id'=>$_POST['orgsdscnt_clg'], 'tpr'=>ID_ORGCNTRTP_ESTD_PRST, 'tpr_o'=>ID_ORGTP_CLG, 'crs'=>$_POST['orgsdscnt_crs'] ];
		$__CntIn->cnt_org[] = [ 'id'=>$_POST['orgsdscnt_uni'], 'tpr'=>ID_ORGCNTRTP_ESTD_PRST, 'tpr_o'=>ID_ORGTP_UNI ];
		$__CntIn->cnt_org[] = [ 'id'=>$_POST['orgsdscnt_emp'], 'tpr'=>ID_ORGCNTRTP_TRB_PRST, 'tpr_o'=>ID_ORGTP_EMP ];
			
		$__dtus_in = $__CntIn->_Cnt();	


		if(!isN($_POST['mdlcnt_tracol'])){

			unset($rsp['enc']);
			unset($rsp['m']);

			$rsp['c'] = 'ok';
			$rsp['fcl'] = 'ok'; //Force Only Callback

			$_mdlstp_dt = GtMdlSTpTraLs([ 'id'=>$__dtmdl->tp->id ]);
			$_tra_col_dt = GtTraColDt(['id'=>$_POST['mdlcnt_tracol'], 't'=>'enc']);
			
			if($__dtmdl->tot->ctrl > 0){
				$_mdl_ctrl_ls = GtMdlCtrlLs(['id'=>$__dtmdl->id]);
			}

			if(!isN( $_tra_col_dt->id )){

				$__tra = new CRM_Tra();

				if($_tra_col_dt->id){
					$__tra->tra_col = $_tra_col_dt->id;
				}else{
					$__tra->tra_col = $_mdlstp_dt->dt->col;
				}
				
				if($_tra_col_dt->id){

					if(!isN($_POST['mdlcnt_tra_sbrnd'])){
						$_store_brnd_dt = GtStoreBrndDt(['id'=>$_POST['mdlcnt_tra_sbrnd'], 't'=>'enc' ]);
						if(!isN($_store_brnd_dt->id)){
							$__tra->tra_sbrnd = $_store_brnd_dt->id;
						}else{
							$rsp['w'][] = 'Problem on save Brand Related to Task';
							$__prc_all = 'no';
						}
					}else{
						$__tra->tra_sbrnd = $_tra_col_dt->store_brnd->id;
					}

				}else{
					$rsp['w'][] = 'Problem on get column details step 2';
					$__prc_all = 'no';
				}

				if(!isN($_POST['mdlcnt_traus'])){
					$__tra->trarsp_us_asg = $_POST['mdlcnt_traus'];
				}else{
					$__tra->trarsp_us_asg = $_mdlstp_dt->us;
				}

				$__tra->tra_cl = $_mdlstp_dt->cl;
				$__tra->tra_tt = $_mdlstp_dt->tt;
				$__tra->invk->by = _CId('ID_SISINVK_CRM');
				$__tra->trarsp_us = SISUS_ID;
				
				if(!isN($__tra->tra_tt)){ 

					$PrcDtTra = $__tra->In_Tra();
					//$rsp['tmppppp___prc_tra'] = $PrcDtTra;

					if($PrcDtTra->e != 'ok'){ 
						$rsp['e'] = 'no'; 
						$rsp['w'][] = 'TraW:'.$PrcDtTra->w;
					}

				}else{
					$rsp['w'][] = 'No title for task';
				}

				if($PrcDtTra->e == 'ok' && !isN($PrcDt->i)){

					//$rsp['tmpmsgggg'][] = $PrcDt; 
					//$rsp['tmpmsgggg'][] = 'mdlcnttra_mdlcnt to match '.$PrcDt->i; 

					$__tra->mdlcnttra_mdlcnt = $PrcDt->i;
					$__tra->mdlcnttra_tra = $PrcDtTra->i;
					$PrcDtMdlTra = $__tra->MdlCnt();
					
					if($PrcDtMdlTra->e != 'ok'){ 

						$rsp['e'] = 'no'; 
						$rsp['w'][] = 'Problem on match tra and mdlcnt';
						$rsp['w'][] = $PrcDtMdlTra->w;

					}else{

						$_tra_d = GtTraDt([ 'id'=>$PrcDtTra->enc, 't'=>'enc', 'ext'=>['all'=>'ok'], 'cmmt'=>'ok' ]);

						if(!isN($_tra_d->id)){

							$rsp['tra'] = $_tra_d;

							if(!isN(Php_Ls_Cln($_POST['maincnv_enc']))){
								$_tra_cb = "
									SUMR_Main.pnl.f.shw({ all:'ok' });
									SUMR_Tra.bxajx.enc = d.tra.enc;
									SUMR_Tra.f.Shw({ o:'ok' });
								";
							}
							
							$rsp['cl'] = " 	if(!isN(d.tra) && !isN(d.tra.enc)){
												SUMR_Tra.f.add({ enc:d.tra.enc, d:d.tra, popx:'ok', swl:'ok' }); 
												".$_tra_cb."
											}";

							if(!isN($_POST['mdlcnt_tracmnt']) && $PrcDtMdlTra->e == 'ok'){

								$__tra->val = $_POST['mdlcnt_tracmnt'];
								$__tra->tra = $PrcDtTra->i;
								$PrcDtTraCmnt = $__tra->Ins_Tra_Cmnt();

								if($PrcDtTraCmnt->e != 'ok'){ 
									$rsp['e'] = 'no'; 
									$rsp['w'][] = 'Problem on save ticket comment';
									$rsp['w'][] = $PrcDtTraCmnt->w;
									$__prc_all = 'no';
								}else{
									$rsp['e'] = 'ok';						
								}

							}

						}else{

							$rsp['w'][] = 'Problem on get tra detail';
							$rsp['w'][] = $_tra_d->w;
							$rsp['tmpppppp_tra_d'] = $_tra_d;
							$__prc_all = 'no';

						}
					
					}	

				}else{

					$rsp['w'][] = '$PrcDtTra->e or $PrcDt problems';
					$__prc_all = 'no';
					if($PrcDtTra->e != 'ok'){ $rsp['w'][] = 'PrcDtTra not success'; }
					if(isN($PrcDt->i)){ $rsp['w'][] = '$PrcDt->i empty'; }	
					$rsp['w'][] = $PrcDtTra->w;
					$rsp['w'][] = $PrcDtTra;
				}

			}else{	
				$rsp['w'][] = 'No column detail';	
			}

			if(!isN($_mdl_ctrl_ls) && !isN( $_mdl_ctrl_ls->tot ) && $_mdl_ctrl_ls->tot > 0 && !isN( $PrcDtTra->i ) && $__dtmdl->tot->ctrl > 0){
				
				$__tra->tra = $PrcDtTra->i;

				foreach($_mdl_ctrl_ls->ls as $_ctrl_k => $_ctrl_v){
					
					$__tra->vl = $_ctrl_v->tx;
					$__tra->ord = $_ctrl_v->ord;	
					$__tra->id_cntrl = $_ctrl_v->id;

					$PrcDtCtrl = $__tra->In_TraCtrl();	
					
					if($PrcDtCtrl->e != 'ok'){
						$__prc_all = 'no';
						$rsp['ws'][] = $PrcDtCtrl;
						$rsp['w'][] = 'No List Control';
					}
				} 
			}

		}

	}else{

		if(isN($PrcDt->i)){ 
			$rsp['w'][] = '$PrcDt->i empty';
		}

		$rsp['e'] = 'no';
		$rsp['m'] = 2;
		
		if(!isN($PrcDt->w)){ $rsp['w'][] = $PrcDt->w; }
		$__prc_all = 'no';
		
	}

	if($__prc_all == 'ok'){
		if($__cnx->c_p->commit()){
			$rsp['e'] = 'ok';	
		}else{
			$rsp['w'][] = 'Commit fails';
			$rsp['e'] = 'no';
		}
	}else{
		$rsp['e'] = 'no';
		$rsp['w'][] = 'Has to do rollback';
		$__cnx->c_p->rollback();
	}

	$__cnx->c_p->autocommit(TRUE);

}


if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "EdMdlCnt")){
	
	$__dtmdl = GtMdlDt([ 't'=>'enc', 'id'=>$_POST['mdlcnt_mdl'] ]);
	$__dtmdlcnt = GtMdlCntDt([ 't'=>'enc', 'id'=>$_POST['mdlcnt_enc'] ]);
	$__dtest = GtCntEstDt([ 'id'=>$_POST['mdlcnt_est'], 't'=>'enc' ]);
	
	if(!isN($__dtmdlcnt->id)){
	
		if(!isN($_POST['mdlcnt_noi'])){ $_noi = $_POST['mdlcnt_noi']; }
		if(!isN($_POST['mdlcnt_noi_otc'])){ $_oth_noi = $_POST['mdlcnt_noi_otc']; }
		if(!isN($_POST['mdlcnt_bd'])){ $_bd = $_POST['mdlcnt_bd']; }else{ $_bd = 5; }
		
		$updateSQL = sprintf("UPDATE ".TB_MDL_CNT." SET mdlcnt_m=%s, mdlcnt_mdl=%s, mdlcnt_est=%s, mdlcnt_fnt=%s, mdlcnt_bd=%s, mdlcnt_noi=%s, mdlcnt_noi_otc=%s, mdlcnt_pgd=%s, mdlcnt_chk_rga=%s, mdlcnt_chk_dcc=%s, mdlcnt_chk_nop=%s, mdlcnt_chk_rpt=%s, mdlcnt_chk_mlt=%s, mdlcnt_chk_vll=%s, mdlcnt_chk_pin=%s, mdlcnt_chk_rvp=%s, mdlcnt_chk_ner=%s, mdlcnt_chk_spp=%s, mdlcnt_cl_sds=%s WHERE id_mdlcnt=%s",	
						   GtSQLVlStr($_POST['mdlcnt_m'], "int"),
						   GtSQLVlStr($__dtmdl->id, "int"),
						   GtSQLVlStr($__dtest->id, "int"),
						   GtSQLVlStr($_POST['mdlcnt_fnt'], "int"),
						   GtSQLVlStr($_bd, "int"),
						   GtSQLVlStr($_noi, "int"),
						   GtSQLVlStr($_oth_noi, "int"),
						   GtSQLVlStr($_POST['mdlcnt_pgd'], "text"),
	                       GtSQLVlStr( _NoNll(Html_chck_vl($_POST['mdlcnt_chk_rga'])) , "int"),
						   GtSQLVlStr( _NoNll(Html_chck_vl($_POST['mdlcnt_chk_dcc'])) , "int"),
						   GtSQLVlStr( _NoNll(Html_chck_vl($_POST['mdlcnt_chk_nop'])) , "int"),
						   GtSQLVlStr( _NoNll(Html_chck_vl($_POST['mdlcnt_chk_rpt'])) , "int"),
						   GtSQLVlStr( _NoNll(Html_chck_vl($_POST['mdlcnt_chk_mlt'])) , "int"),
						   GtSQLVlStr( _NoNll(Html_chck_vl($_POST['mdlcnt_chk_no_vll'])) , "int"),
						   GtSQLVlStr( _NoNll(Html_chck_vl($_POST['mdlcnt_chk_pin'])) , "int"),
						   GtSQLVlStr( _NoNll(Html_chck_vl($_POST['mdlcnt_chk_rvp'])) , "int"),
						   GtSQLVlStr( _NoNll(Html_chck_vl($_POST['mdlcnt_chk_ner'])) , "int"),
						   GtSQLVlStr( _NoNll(Html_chck_vl($_POST['mdlcnt_chk_spp'])) , "int"),
						   GtSQLVlStr($_POST['mdlcnt_cl_sds'], "int"),
						   GtSQLVlStr($__dtmdlcnt->id, "int")); 
		
	}
	
	if(!isN($updateSQL)){

		$Result = $__cnx->_prc($updateSQL);
		
		MdlCntLck([ 'id'=>$__dtmdlcnt->id ]);
		
		if($Result){
			
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
			$rsp['enc'] = $_POST['mdlcnt_enc'];
			
			$_cnt_dt = GtCntDt([  'id'=>$__dtmdlcnt->cnt->id ]);		
			
			$rsp['upd'] = UPDCnt_Cld([ 'id'=>$_cnt_dt->enc, 'e'=>$__dtest->id, 'c_a'=>$_cnt_dt->cld ]);
			
			$__est_now = GtCntEstDt([ 'id'=>$__dtest->id ]);
			$rsp['est']['now'] = $__est_now;
			
			$__est_lst = GtMdlCntEst_Lst(['id'=>$__dtmdlcnt->id, 'nw'=>$__dtest->id ]);
			$rsp['est']['lst'] = $__est_lst;
			
			if($__est_lst->df == 'ok'){ 
				$_cnt_est = __MdlCntEst([ 'c'=>$__dtmdlcnt->id, 'e'=>$__dtest->id ]); 
				$rsp['est']['upd'] = $_cnt_est;
			}

			if($_POST['t2'] == 'sac' && !isN($__dtest->id)){

				$__dtmdlcnttra = GtMdlCntTraDt([ 'tp'=>'mdl_cnt', 'id'=>$__dtmdlcnt->id, 'shw'=>[ 'tra'=>'ok' ] ]);
				$__dthmlg = GtCntEstMdlCntTra([ 'cl'=>DB_CL_ID, 'est'=>$__dtest->id ]);

				foreach($__dtmdlcnttra->ls as $k => $v){

					if(!isN($v->id)){

						if(!isN($__dthmlg->id_est)){
	
							$__tra = new CRM_Tra(); 
							$__tra->tra_est = $__dthmlg->id_est; 
							$__tra->id_tra = $v->tra->id;
	
							$rsp['tmpupdmdlcntest'] = $__tra->Upd_Tra_Est();

							if(!isN($v->tra->id) && !isN($__dthmlg->id_est)){
								if($__dthmlg->id_est == _CId('ID_TRAEST_CMPL')){
									$__prc = $__tra->Upd_Tra_F([ 't'=>'tra', 'k'=>'f_cmpl', 'v'=>date('Y-m-d H:i:s'), 'id'=>$v->tra->enc ]);
									$rsp['est_cmpl'] = $__prc;
								}
							}

						}
						
					}

				}

			} 

			if(mBln($__dt_cl->tag->sis->asggstest->v) == 'ok'){
				
				$__dtmdlcntus = GtMdlCntUsDt([ 'us'=>SISUS_ID, 'mdlcnt'=>$__dtmdlcnt->id, 'tp'=>_CId('ID_USROL_OBS') ]);

				if($__dtmdlcntus->e == 'ok' && !isN($__dtmdlcntus->id)){
					
					$rsp['mdlcntus']['e'] = 'ok';
					$rsp['mdlcntus']['id'] = $__dtmdlcntus->enc;

				}else{

					$__dtmdlcntusin = MdlCntUsIn([ 'us'=>SISUS_ID, 'mdlcnt'=>$__dtmdlcnt->id, 'tp'=>_CId('ID_USROL_OBS') ]);

					if($__dtmdlcntusin->e == 'ok' && !isN($__dtmdlcntusin->id)){
						$rsp['mdlcntus']['e'] = 'ok';
						$rsp['mdlcntus']['id'] = $__dtmdlcntusin->enc;
					}

				}

			}
			
		}else{

			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			$rsp['w'][] = 'No query result on '.$__cnx->c_p->error;
			$rsp['w_q'] = $updateSQL;

		} 
	
	}else{

		$rsp['w'][] = 'No UpdateSQL';

	}

}

// Elimino el Registro
if ((isset($_POST['id_mdlcnt'])) && ($_POST['id_mdlcnt'] != '') && ((isset($_POST['MM_delete']))&&($_POST['MM_delete'] == 'EdMdlCnt'))) { 
	$deleteSQL = sprintf("DELETE FROM ".TB_MDL_CNT." WHERE mdlcnt_enc=%s", GtSQLVlStr($_POST['mdlcnt_enc'], 'text'));
	$Result = $__cnx->_prc($deleteSQL); if($Result){$rsp['e'] = 'ok'; $rsp['m'] = 1; 
	$rsp['a'] = Aud_Sis(Aud_Dsc(328, $_POST['cnt_nm'], $_POST['id_mdlcnt']), $rsp['v']);
	}else{$rsp['e'] = 'no'; $rsp['m'] = 2; }
}

?>