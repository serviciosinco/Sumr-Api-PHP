<?php

	function GtClWdgtDt($p=NULL){

		global $__cnx;

		$Vl['e'] = 'no';

		if(!isN($p['id'])){

			if($p['t'] == 'enc'){ $__f = 'clwdgt_enc'; $__ft = 'text'; }
			else{ $__f = 'id_clwdgt'; $__ft = 'int'; }

			$___days_week = _WkDays();

			foreach($___days_week as $_k => $_v){
				$_slc_sql[] = 'clwdgt_sch_d_'.$_v->id;
				$_slc_sql[] = 'clwdgt_sch_d_'.$_v->id.'_s';
				$_slc_sql[] = 'clwdgt_sch_d_'.$_v->id.'_e';
				$_slc_sql[] = 'clwdgt_sch_mbl_d_'.$_v->id;
				$_slc_sql[] = 'clwdgt_sch_mbl_d_'.$_v->id.'_s';
				$_slc_sql[] = 'clwdgt_sch_mbl_d_'.$_v->id.'_e';
			}

			$query_DtRg = sprintf('	SELECT
											id_clwdgt, clwdgt_enc, clwdgt_cl, clwdgt_nm,

											clwdgt_pwd, clwdgt_puff, clwdgt_shwtt,
											clwdgt_mbl_pwd, clwdgt_mbl_puff, clwdgt_mbl_shwtt,

											clwdgt_pst_top, clwdgt_pst_top_v,
											clwdgt_pst_right, clwdgt_pst_right_v,
											clwdgt_pst_bottom, clwdgt_pst_bottom_v,
											clwdgt_pst_left, clwdgt_pst_left_v,

											clwdgt_pst_mbl_top, clwdgt_pst_mbl_top_v,
											clwdgt_pst_mbl_right, clwdgt_pst_mbl_right_v,
											clwdgt_pst_mbl_bottom, clwdgt_pst_mbl_bottom_v,
											clwdgt_pst_mbl_left, clwdgt_pst_mbl_left_v,

											clwdgt_tx_btn_tt, clwdgt_tx_pop_tt, clwdgt_tx_pop_intro,
											clwdgt_tx_call_ph, clwdgt_test_url, clwdgt_test_inline,
											clwdgt_clr_strt, clwdgt_clr_hdr, clwdgt_img,
											clwdgtact_enc, clwdgtact_nm, clwdgtact_dsc, clwdgtact_lnk_sms, clwdgtact_e, clwdgtact_img, clwdgtact_mdlgen,
											clwdgtact_clr_bck, clwdgtact_clr_fnt, clwdgtact_tx_ph, id_cl, cl_nm, cl_prfl, cl_sbd, cl_rsllr,

										   '._QrySisSlcF([ 'als'=>'chnl', 'als_n'=>'channel' ]).',
										   '.GtSlc_QryExtra(['t'=>'fld', 'p'=>'channel', 'als'=>'chnl']).',

										   '._QrySisSlcF([ 'als'=>'thm', 'als_n'=>'theme' ]).',
										   '.GtSlc_QryExtra(['t'=>'fld', 'p'=>'theme', 'als'=>'thm']).',

											'.implode(',', $_slc_sql).'

									FROM '._BdStr(DBM).TB_CL_WDGT.'
										 INNER JOIN '._BdStr(DBM).TB_CL.' ON clwdgt_cl = id_cl
										 INNER JOIN '._BdStr(DBM).TB_CL_WDGT_ACT.' ON clwdgtact_clwdgt = id_clwdgt
										 '.GtSlc_QryExtra(['t'=>'tb', 'col'=>'clwdgtact_chnl', 'als'=>'chnl']).'
										 '.GtSlc_QryExtra(['t'=>'tb', 'col'=>'clwdgt_thm', 'als'=>'thm']).'
									WHERE '.$__f.' = %s', GtSQLVlStr($p['id'], $__ft));

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg > 0){

					$Vl['e'] = 'ok';

					do{

						$__attr = json_decode($row_DtRg['___channel']);

						foreach($__attr as $__attr_k=>$__attr_v){
							$__chnl->{$__attr_v->key} = $__attr_v;
						}

						$__attr_thm = json_decode($row_DtRg['___theme']);

						foreach($__attr_thm as $__attr_thm_k=>$__attr_thm_v){
							$__thm->{$__attr_thm_v->key} = $__attr_thm_v;
						}


						$Vl['id'] = $row_DtRg['id_clwdgt'];
						$Vl['enc'] = ctjTx($row_DtRg['clwdgt_enc'],'in');
						$Vl['nm'] = ctjTx($row_DtRg['clwdgt_nm'],'in');
						$Vl['thm'] = $__thm;

						if(!isN($row_DtRg['clwdgt_img'])){
							$Vl['img'] = _ImVrs([ 'img'=>$row_DtRg['clwdgt_img'], 'f'=>DMN_FLE_CL_WDGT ]);
						}

						$Vl['pwd'] = mBln($row_DtRg['clwdgt_pwd']);
						$Vl['puff'] = mBln($row_DtRg['clwdgt_puff']);
						$Vl['shwtt'] = mBln($row_DtRg['clwdgt_shwtt']);

						$Vl['mbl']['pwd'] = mBln($row_DtRg['clwdgt_mbl_pwd']);
						$Vl['mbl']['puff'] = mBln($row_DtRg['clwdgt_mbl_puff']);
						$Vl['mbl']['shwtt'] = mBln($row_DtRg['clwdgt_mbl_shwtt']);

						$Vl['pst']['top']['e'] = mBln($row_DtRg['clwdgt_pst_top']);
						$Vl['pst']['top']['v'] = $row_DtRg['clwdgt_pst_top_v'];
						$Vl['pst']['right']['e'] = mBln($row_DtRg['clwdgt_pst_right']);
						$Vl['pst']['right']['v'] = $row_DtRg['clwdgt_pst_right_v'];
						$Vl['pst']['bottom']['e'] = mBln($row_DtRg['clwdgt_pst_bottom']);
						$Vl['pst']['bottom']['v'] = $row_DtRg['clwdgt_pst_bottom_v'];
						$Vl['pst']['left']['e'] = mBln($row_DtRg['clwdgt_pst_left']);
						$Vl['pst']['left']['v'] = $row_DtRg['clwdgt_pst_left_v'];

						$Vl['pst']['mbl']['top']['e'] = mBln($row_DtRg['clwdgt_pst_mbl_top']);
						$Vl['pst']['mbl']['top']['v'] = $row_DtRg['clwdgt_pst_mbl_top_v'];
						$Vl['pst']['mbl']['right']['e'] = mBln($row_DtRg['clwdgt_pst_mbl_right']);
						$Vl['pst']['mbl']['right']['v'] = $row_DtRg['clwdgt_pst_mbl_right_v'];
						$Vl['pst']['mbl']['bottom']['e'] = mBln($row_DtRg['clwdgt_pst_mbl_bottom']);
						$Vl['pst']['mbl']['bottom']['v'] = $row_DtRg['clwdgt_pst_mbl_bottom_v'];
						$Vl['pst']['mbl']['left']['e'] = mBln($row_DtRg['clwdgt_pst_mbl_left']);
						$Vl['pst']['mbl']['left']['v'] = $row_DtRg['clwdgt_pst_mbl_left_v'];

						$Vl['tx']['btn_tt'] = ctjTx($row_DtRg['clwdgt_tx_btn_tt'],'in');
						$Vl['tx']['pop_tt'] = ctjTx($row_DtRg['clwdgt_tx_pop_tt'],'in');
						$Vl['tx']['pop_intro'] = ctjTx($row_DtRg['clwdgt_tx_pop_intro'],'in');
						$Vl['tx']['call_ph'] = ctjTx($row_DtRg['clwdgt_tx_call_ph'],'in');

						$Vl['test']['url'] = ctjTx($row_DtRg['clwdgt_test_url'],'in');
						$Vl['test']['inline'] = mBln($row_DtRg['clwdgt_test_inline']);
						$Vl['test']['image']['back'] = _ImVrs([ 'img'=>$row_DtRg['clwdgt_enc'].'.jpg', 'f'=>DMN_FLE_CL_WDGT_TEST ]);


						$Vl['clr']['strt'] = !isN($row_DtRg['clwdgt_clr_strt']) ? ctjTx($row_DtRg['clwdgt_clr_strt'],'in') : '#26C281';
						$Vl['clr']['hdr'] = !isN($row_DtRg['clwdgt_clr_hdr']) ? ctjTx($row_DtRg['clwdgt_clr_hdr'],'in') : '#26C281';

						$iosl = $__chnl->srv->vl;
						$ioac = $row_DtRg['clwdgtact_enc'];

						if(!isN($iosl) && !isN($ioac)){

							$Vl['act'][$iosl][$ioac]['id'] = $ioac;
							$Vl['act'][$iosl][$ioac]['srv'] = $iosl;
							$Vl['act'][$iosl][$ioac]['tt'] = ctjTx($row_DtRg['clwdgtact_nm'],'in');
							$Vl['act'][$iosl][$ioac]['dsc'] = ctjTx($row_DtRg['clwdgtact_dsc'],'in');
							$Vl['act'][$iosl][$ioac]['tx']['ph'] = ctjTx($row_DtRg['clwdgtact_tx_ph'],'in');
							$Vl['act'][$iosl][$ioac]['clr']['bck'] = ctjTx($row_DtRg['clwdgtact_clr_bck'],'in');
							$Vl['act'][$iosl][$ioac]['clr']['fnt'] = ctjTx($row_DtRg['clwdgtact_clr_fnt'],'in');

							$Vl['act'][$iosl][$ioac]['lnk']['sms'] = mBln($row_DtRg['clwdgtact_lnk_sms']);

							if(!isN($row_DtRg['clwdgtact_mdlgen'])){
								$_mdlgen = GtMdlGenDt([ 't'=>'id', 'id'=>$row_DtRg['clwdgtact_mdlgen'], 'bd'=>DB_PRFX_CL.ctjTx($row_DtRg['cl_sbd'],'in') ]);
								$Vl['act'][$iosl][$ioac]['mdl']['gen']['enc'] = $_mdlgen->enc;
							}

							$Vl['act'][$iosl][$ioac]['e'] = mBln($row_DtRg['clwdgtact_e']);

							if(!isN($row_DtRg['clwdgtact_img'])){
								$Vl['act'][$iosl][$ioac]['img']['icn'] = _ImVrs([ 'img'=>$row_DtRg['clwdgtact_img'], 'f'=>DMN_FLE_CL_WDGT_ACT ]);
							}

						}

						if(!isN($row_DtRg['clwdgtact_img'])){
							$Vl['act'][$row_DtRg['channel_sisslc_cns']][$ioac]['img']['bck'] = _ImVrs([ 'img'=>$row_DtRg['clwdgtact_img'], 'f'=>DMN_FLE_CL_BCK ]);
						}

						$Vl['cl']['id'] = ctjTx($row_DtRg['id_cl'],'in');
						$Vl['cl']['nm'] = ctjTx($row_DtRg['cl_nm'],'in');
						$Vl['cl']['sbd'] = ctjTx($row_DtRg['cl_sbd'],'in');
						$Vl['cl']['prfl'] = ctjTx($row_DtRg['cl_prfl'],'in');


						if(!isN($row_DtRg['cl_rsllr'])){
							$__rsllr = GtClDt($row_DtRg['cl_rsllr']);
							$Vl['rsllr']['nm'] = $__rsllr->nm;
							$Vl['rsllr']['web'] = $__rsllr->web;
						}

						foreach($___days_week as $_k=>$_v){

							$Vl['sch']['d'][$_v->id]['e'] = mBln($row_DtRg['clwdgt_sch_d_'.$_v->id]);

							if(!isN( $row_DtRg['clwdgt_sch_d_'.$_v->id.'_s'] )){
								$Vl['sch']['d'][$_v->id]['hour']['s'] = /*_LclTme(*/ $row_DtRg['clwdgt_sch_d_'.$_v->id.'_s'] /*)*/;
							}else{
								$Vl['sch']['d'][$_v->id]['hour']['s'] = NULL;
							}

							if(!isN( $row_DtRg['clwdgt_sch_d_'.$_v->id.'_e'] )){
								$Vl['sch']['d'][$_v->id]['hour']['e'] = /*_LclTme(*/ $row_DtRg['clwdgt_sch_d_'.$_v->id.'_e'] /*)*/;
							}else{
								$Vl['sch']['d'][$_v->id]['hour']['e'] = NULL;
							}

							$Vl['sch']['mbl']['d'][$_v->id]['e'] = mBln($row_DtRg['clwdgt_sch_mbl_d_'.$_v->id]);

							if(!isN( $row_DtRg['clwdgt_sch_mbl_d_'.$_v->id.'_s'] )){
								$Vl['sch']['mbl']['d'][$_v->id]['hour']['s'] = /*_LclTme(*/ $row_DtRg['clwdgt_sch_mbl_d_'.$_v->id.'_s'] /*)*/;
							}else{
								$Vl['sch']['mbl']['d'][$_v->id]['hour']['s'] = NULL;
							}

							if(!isN( $row_DtRg['clwdgt_sch_mbl_d_'.$_v->id.'_e'] )){
								$Vl['sch']['mbl']['d'][$_v->id]['hour']['e'] = /*_LclTme(*/ $row_DtRg['clwdgt_sch_mbl_d_'.$_v->id.'_e'] /*)*/;
							}else{
								$Vl['sch']['mbl']['d'][$_v->id]['hour']['e'] = NULL;
							}

						}

					}while($row_DtRg = $DtRg->fetch_assoc());

				}else{

					//$Vl['q'] = compress_code($query_DtRg);

				}

			}else{

				$Vl['w'] = $__cnx->c_r->error;

			}

			$__cnx->_clsr($DtRg);

		}else{

			$Vl['w'] = 'No all data';

		}

		return(_jEnc($Vl));
	}




	function GtClWdgtActDt($p=NULL){

		global $__cnx;

		$Vl['e'] = 'no';

		if(!isN($p['id'])){

			if($p['t'] == 'enc'){ $__f = 'clwdgtact_enc'; $__ft = 'text'; }
			else{ $__f = 'id_clwdgtact'; $__ft = 'int'; }

			$query_DtRg = sprintf('	SELECT id_clwdgtact, clwdgtact_nm, clwdgtact_dsc, clwdgtact_clr_bck, clwdgtact_clr_fnt,
										   clwdgtact_chnl, clwdgtact_chnl_acc, clwdgtact_chnl_key, clwdgtact_chnl_lne, clwdgtact_chnl_que,
										   clwdgtact_wa_wlcm, clwdgtact_awsacc, clwdgt_cl,
										   '._QrySisSlcF([ 'als'=>'chnl', 'als_n'=>'channel' ]).',
										   '.GtSlc_QryExtra(['t'=>'fld', 'p'=>'channel', 'als'=>'chnl']).'
									FROM '._BdStr(DBM).TB_CL_WDGT_ACT.'
										 INNER JOIN '._BdStr(DBM).TB_CL_WDGT.' ON clwdgtact_clwdgt = id_clwdgt
										 '.GtSlc_QryExtra(['t'=>'tb', 'col'=>'clwdgtact_chnl', 'als'=>'chnl']).'
									WHERE '.$__f.' = %s
									LIMIT 1', GtSQLVlStr($p['id'], $__ft));

			$DtRg = $__cnx->_qry($query_DtRg);

			//$Vl['q'] = compress_code($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg > 0){

					$Vl['e'] = 'ok';

					$__attr = json_decode($row_DtRg['___channel']);

					foreach($__attr as $__attr_k=>$__attr_v){
						$__chnl->{$__attr_v->key} = $__attr_v;
					}

					$Vl['id'] = $row_DtRg['id_clwdgtact'];
					$Vl['tt'] = ctjTx($row_DtRg['clwdgtact_nm'],'in');
					$Vl['dsc'] = ctjTx($row_DtRg['clwdgtact_dsc'],'in');
					$Vl['clr']['bck'] = ctjTx($row_DtRg['clwdgtact_clr_bck'],'in');
					$Vl['clr']['fnt'] = ctjTx($row_DtRg['clwdgtact_clr_fnt'],'in');

					$Vl['chnl']['id'] = ctjTx($row_DtRg['clwdgtact_chnl'],'in');
					$Vl['chnl']['acc'] = ctjTx($row_DtRg['clwdgtact_chnl_acc'],'in');
					$Vl['chnl']['key'] = ctjTx($row_DtRg['clwdgtact_chnl_key'],'in');
					$Vl['chnl']['lne'] = ctjTx($row_DtRg['clwdgtact_chnl_lne'],'in');
					$Vl['chnl']['que'] = ctjTx($row_DtRg['clwdgtact_chnl_que'],'in');
					$Vl['chnl']['attr'] = $__chnl;

					$Vl['wa']['wlcm'] = ctjTx($row_DtRg['clwdgtact_wa_wlcm'],'in');

					if(!isN($p['d']['cl']) && $p['d']['cl'] == 'ok'){
						$Vl['cl'] = $_cl_dt = GtClDt($row_DtRg['clwdgt_cl']);
					}

					if(!isN($p['d']['aws']) && $p['d']['aws'] == 'ok'){
						$Vl['aws'] = GtClAwsAccDt([ 'id'=>$row_DtRg['clwdgtact_awsacc'] ]);
					}

				}

			}

			$__cnx->_clsr($DtRg);

		}else{

			$Vl['w'] = 'No all data';

		}

		return _jEnc($Vl);
	}




?>