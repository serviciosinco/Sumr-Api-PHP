<?php

	define('STUP_SND_LMT_MAX', 500);


	function GtEcSndDt($_p=NULL){

		global $__cnx;

		$Vl['e'] = 'no';
		//$Vl['p'] = $_p;

		if(!isN($_p['id'])){

			if($_p['tp'] == 'enc'){ $__f = 'ecsnd_enc'; $__ft = 'text'; }
			elseif($_p['tp'] == 'id'){ $__f = 'ecsnd_id'; $__ft = 'text'; }
			else{ $__f = 'id_ecsnd'; $__ft = 'int'; }

			if(!isN($_p['bd'])){ $_bd = _BdStr($_p['bd']); }else{ $_bd = ''; }

			$c_DtRg = "-1";if (isset($_p['id'])){$c_DtRg = $_p['id']; }

			if($_p['dtl']['cmpg']=='ok'){
				$_sl_cmpg = '
					,

				    (	SELECT ecsndcmpg_cmpg
				    	FROM '.$_bd.TB_EC_SND_CMPG.'
				    	WHERE ecsndcmpg_snd = id_ecsnd
				    	LIMIT 1
				    ) AS __eccmpg

				';
			}

			if($_p['dtl']['mdlcnt']=='ok'){

				$_sl_mcnt = '
					,

				    (	SELECT mdlcntec_mdlcnt
				    	FROM '.$_bd.TB_CNT_SND.'
				    	WHERE mdlcntec_ecsnd = id_ecsnd
				    	LIMIT 1
				    ) AS __mdlcnt

				';

			}

			$query_DtRg = sprintf('
									SELECT id_ecsnd, ecsnd_enc, ecsnd_btch, ecsnd_html, ecsnd_html_btch, ecsnd_eml, ecsnd_cnt, ecsnd_ec, ecsnd_plcy_id
									    '.$_sl_mcnt.'
									    '.$_sl_cmpg.'
								    FROM '.$_bd.TB_EC_SND.'
								    WHERE '.$__f.'=%s
								    LIMIT 1', GtSQLVlStr($c_DtRg, $__ft)
								);


			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				//$Vl['q'] = $query_DtRg;
				$Vl['tot'] = $Tot_DtRg;

				if($Tot_DtRg > 0){

					$Vl['id'] = $row_DtRg['id_ecsnd'];
					$Vl['enc'] = $row_DtRg['ecsnd_enc'];
					$Vl['btch'] = ctjTx($row_DtRg['ecsnd_btch'],'in');
					$Vl['html']['e'] = mBln($row_DtRg['ecsnd_html']);
					$Vl['html']['btch'] = ctjTx($row_DtRg['ecsnd_html_btch'],'in');

					$Vl['enc1'] = $row_DtRg['ecsnd_eml'];
					$Vl['enc2'] = $_bd;

					if($_p['dtl']['eml']=='ok'){
						$Vl['eml'] = GtCntEmlDt([ 'id'=>$row_DtRg['ecsnd_eml'], 'tp'=>'eml', 'bd'=>$_bd, 'd'=>['plcy'=>'ok'] ]);
					}

					if($_p['dtl']['cnt']=='ok'){
						$Vl['cnt'] = GtCntDt([  'id'=>$row_DtRg['ecsnd_cnt'], 'cl'=>$_p['cl'], 'bd'=>$_bd ]);
					}

					if($_p['dtl']['ec']=='ok'){
						$Vl['ec'] = GtEcDt($row_DtRg['ecsnd_ec'], '');
					}

					if(!isN($row_DtRg['__eccmpg'])){
						$Vl['cmpg'] = GtEcCmpgDt([ 'id'=>$row_DtRg['__eccmpg'], 'bd'=>$_bd, 'lsts'=>['e'=>'ok'] ]);
					}

					if(!isN($row_DtRg['__mdlcnt'])){
						$Vl['mdlcnt'] = GtMdlCntDt([ 'id'=>$row_DtRg['__mdlcnt'], 'bd'=>$_bd ]);
					}

					if($_p['dtl']['plcy']=='ok' && !isN($row_DtRg['ecsnd_plcy_id'])){
						$Vl['plcy'] = GtClPlcyDt([ 'id'=>$row_DtRg['ecsnd_plcy_id'] ]);
					}

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




	function GtEcSndBtch($_p=NULL){

		global $__cnx;

		$Vl['e'] = 'no';

		if(!isN($_p['id'])){

			if($_p['tp'] == 'enc'){ $__f = 'ecsnd_enc'; $__ft = 'text'; }
			elseif($_p['tp'] == 'id'){ $__f = 'ecsnd_id'; $__ft = 'text'; }
			else{ $__f = 'id_ecsnd'; $__ft = 'int'; }

			if(!isN($_p['bd'])){ $_bd = _BdStr($_p['bd']); }else{ $_bd = ''; }

			$query_DtRg = sprintf('	SELECT id_ecsnd, ecsnd_btch, ecsnd_html_btch
								    FROM '.$_bd.TB_EC_SND.'
								    WHERE '.$__f.' = %s LIMIT 1', GtSQLVlStr($_p['id'], $__ft));

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				$Vl['tot'] = $Tot_DtRg;

				if($Tot_DtRg > 0){
					$Vl['id'] = $row_DtRg['id_ecsnd'];
					$Vl['btch'] = ctjTx($row_DtRg['ecsnd_btch'],'in');
					$Vl['html']['btch'] = ctjTx($row_DtRg['ecsnd_html_btch'],'in');
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




	function GtEcCmpgLstsEmlDt($Id){

		global $__cnx;

		$query_DtRg = sprintf('	SELECT id_eccmpg, eccmpg_nm, sisbd_nm, id_sisbd, COUNT(*) as __tot
								FROM  '._BdStr(DBM).TB_EC_CMPG.'
									  INNER JOIN '._BdStr(DBM).TB_EC_CMPG_LSTS.' ON eccmpglsts_cmpg = id_eccmpg
									  INNER JOIN '._BdStr(DBM).TB_EC_LSTS.' eccmpglsts_lsts = id_eclsts
									  INNER JOIN '.TB_EC_LSTS_EML.' ON eclstseml_lsts = id_eclsts
									  INNER JOIN '.TB_CNT_EML.' ON eclstseml_eml = cnteml_eml
									  INNER JOIN '.TB_CNT.' ON cnteml_cnt = id_cnt
									  INNER JOIN '.TB_CNT_BD.' ON cntbd_cnt = id_cnt
									  INNER JOIN '._BdStr(DBM).TB_SIS_BD.' ON cntbd_bd = id_sisbd
								WHERE eccmpg_enc = %s GROUP BY id_sisbd', GtSQLVlStr($Id['enc'],'text'));

		$query_DtRg = sprintf('	SELECT id_eclstseml, eclstseml_bdt, COUNT(*) AS __tot
								FROM '._BdStr(DBM).TB_EC_CMPG.'
									 INNER JOIN '._BdStr(DBM).TB_EC_CMPG_LSTS.' ON eccmpglsts_cmpg = id_eccmpg
									 INNER JOIN '._BdStr(DBM).TB_EC_LSTS.' ON eccmpglsts_lsts = id_eclsts
									 INNER JOIN '.TB_EC_LSTS_EML.' ON eclstseml_lsts = id_eclsts
								WHERE 	eclstseml_bdt IS NOT NULL AND
										eccmpg_enc = %s
								GROUP BY eclstseml_bdt', GtSQLVlStr($Id['enc'],'text'));

		$DtRg = $__cnx->_qry($query_DtRg);

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;

			if($Tot_DtRg > 0){

				do{

					$Vl[$row_DtRg['id_eclstseml']]['tot'] = $row_DtRg['__tot'];
					$Vl[$row_DtRg['id_eclstseml']]['nm'] = $row_DtRg['eclstseml_bdt'];

				}while($row_DtRg = $DtRg->fetch_assoc());

			}else{
				$Vl['no'] = $query_DtRg;
			}

		}else{

			echo 'GtEcCmpgLstsEmlDt:'.$__cnx->c_r->error;

		}

		$__cnx->_clsr($DtRg);

		return(_jEnc($Vl));

	}


	function GtEcCmpgBdDt($Id){

		global $__cnx;

			$query_DtRg = sprintf('	SELECT id_eccmpg, eccmpg_nm, sisbd_nm, id_sisbd, COUNT(*) as __tot
									FROM  '._BdStr(DBM).TB_EC_CMPG.'
										  INNER JOIN '._BdStr(DBM).TB_EC_CMPG_LSTS.' ON eccmpglsts_cmpg = id_eccmpg
										  INNER JOIN '._BdStr(DBM).TB_EC_LSTS.' ON eccmpglsts_lsts = id_eclsts
										  INNER JOIN '.TB_EC_LSTS_EML.' ON eclstseml_lsts = id_eclsts
										  INNER JOIN '.TB_CNT_EML.' ON eclstseml_eml = cnteml_eml
										  INNER JOIN '.TB_CNT.' ON cnteml_cnt = id_cnt
										  INNER JOIN '.TB_CNT_BD.' ON cntbd_cnt = id_cnt
										  INNER JOIN '._BdStr(DBM).TB_SIS_BD.' ON cntbd_bd = id_sisbd
									WHERE eccmpg_enc = %s
									GROUP BY id_sisbd', GtSQLVlStr($Id['enc'],'text'));

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg > 0){

					do{
						$Vl[$row_DtRg['id_sisbd']]['tot'] = $row_DtRg['__tot'];
						$Vl[$row_DtRg['id_sisbd']]['nm'] = $row_DtRg['sisbd_nm'];
					}while($row_DtRg = $DtRg->fetch_assoc());

				}else{
					$Vl['no'] = $query_DtRg;
				}

			}else{

				echo 'GtEcCmpgBdDt:'.$__cnx->c_r->error;

			}

			$__cnx->_clsr($DtRg);

		return(_jEnc($Vl));

	}


	function GtEcAreLs($p){

		global $__cnx;

		$Vl['e'] = 'no';

		if( !isN($p)){

			if(!isN($p['ec'])){ $__fl .= " AND ecare_ec = ".GtSQLVlStr($p['ec'],'int')." "; }

			$query_DtRg = sprintf('	SELECT  id_clare, clare_tt, clare_clr, clare_logo,
											clare_img, clare_logo, clare_hdr
									FROM '._BdStr(DBM).TB_EC_ARE.'
										 INNER JOIN '._BdStr(DBM).TB_CL_ARE.' ON ecare_are = id_clare
									WHERE id_clare IS NOT NULL '.$__fl);

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				$Vl['tot'] = $Tot_DtRg;

				if($Tot_DtRg > 0){

					$Vl['e'] = 'ok';

					do {

						$__img = _ImVrs(['img'=>ctjTx($row_DtRg['clare_img'],'in'), 'f'=>DMN_FLE_CL_ARE ]);
						$__img_lgo = _ImVrs(['img'=>ctjTx($row_DtRg['clare_logo'],'in'), 'f'=>DMN_FLE_CL_ARE_LGO ]);
						$__img_hdr = _ImVrs(['img'=>ctjTx($row_DtRg['clare_hdr'],'in'), 'f'=>DMN_FLE_CL_ARE_HDR ]);

						$___id = $row_DtRg['id_clare'];

						$Vl['ls'][$___id] = [
												'id'=>$___id,
												'tt'=>ctjTx($row_DtRg['clare_tt'],'in'),
												'clr'=>ctjTx($row_DtRg['clare_clr'],'in'),
												'logo'=>ctjTx($row_DtRg['clare_logo'],'in'),
												'tp'=>[
													'id'=>ctjTx($row_DtRg['tipo_id_sisslc'],'in'),
													'tt'=>ctjTx($row_DtRg['tipo_sisslc_tt'],'in'),
													'enc'=>ctjTx($row_DtRg['tipo_sisslc_enc'],'in')
												],
												'img'=>[
													'main'=>$__img,
													'hdr'=>$__img_hdr,
													'lgo'=>$__img_lgo
												]
											];

						if(!isN($row_DtRg['clare_clr'])){
							$_clr = Spn('','','_clr','background-color:'.ctjTx($row_DtRg['clare_clr'],'in'));
						}else{
							$_clr = '';
						}

						$_html_li .= li($_clr.ctjTx($row_DtRg['clare_tt'],'in'));

					}while($row_DtRg = $DtRg->fetch_assoc());


					$Vl['html'] = ul($_html_li, 'are_ls');

				}

			}

			$__cnx->_clsr($DtRg);

		}

		return(_jEnc($Vl));

	}



	function GtEcTpLs($p){

		global $__cnx;

		$Vl['e'] = 'no';

		if( !isN($p)){

			if(!isN($p['ec'])){ $__fl .= " AND ecmdlstp_ec = ".GtSQLVlStr($p['ec'],'int')." "; }

			$query_DtRg = sprintf('	SELECT *
									FROM '._BdStr(DBM).TB_EC_TP.'
										 INNER JOIN '._BdStr(DBM).TB_MDL_S_TP.' ON ecmdlstp_mdlstp = id_mdlstp
									WHERE id_ecmdlstp IS NOT NULL '.$__fl);

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				$Vl['tot'] = $Tot_DtRg;

				if($Tot_DtRg > 0){

					$Vl['e'] = 'ok';

					do {

						$__img = _ImVrs(['img'=>ctjTx($row_DtRg['ecmdlstp_img'],'in'), 'f'=>DMN_FLE_MDL_TP ]);

						$___id = $row_DtRg['id_ecmdlstp'];

						$Vl['ls'][$___id] = [
												'id'=>$___id,
												'tp'=>[
													'id'=>ctjTx($row_DtRg['id_mdlstp'],'in'),
													'tt'=>ctjTx($row_DtRg['mdlstp_nm'],'in'),
													'clr'=>ctjTx($row_DtRg['mdlstp_clr'],'in'),
													'img'=>[
														'main'=>$__img
													]
												]

											];

						if(!isN($row_DtRg['mdlstp_clr'])){
							$_clr = Spn('','','_clr','background-color:'.ctjTx($row_DtRg['mdlstp_clr'],'in'));
						}else{
							$_clr = '';
						}

						$_html_li .= li($_clr.ctjTx($row_DtRg['mdlstp_nm'],'in'));

					}while($row_DtRg = $DtRg->fetch_assoc());


					$Vl['html'] = ul($_html_li, 'tp_ls');

				}

			}else{

				$Vl['w'] = $__cnx->c_r->error;

			}

			$__cnx->_clsr($DtRg);

		}

		return(_jEnc($Vl));

	}




	function GtEcLstsAreLs($p){

		global $__cnx;

		$Vl['e'] = 'no';

		if( !isN($p)){

			if(!isN($p['eclsts'])){ $__fl .= " AND eclstsare_eclsts = ".GtSQLVlStr($p['eclsts'],'int')." "; }

			$query_DtRg = sprintf('	SELECT *
									FROM '._BdStr(DBM).TB_EC_LSTS_ARE.'
										 INNER JOIN '._BdStr(DBM).TB_CL_ARE.' ON eclstsare_clare = id_clare
									WHERE id_clare IS NOT NULL '.$__fl);

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				$Vl['tot'] = $Tot_DtRg;

				if($Tot_DtRg > 0){

					$Vl['e'] = 'ok';

					do {

						$__img = _ImVrs(['img'=>ctjTx($row_DtRg['clare_img'],'in'), 'f'=>DMN_FLE_CL_ARE ]);
						$__img_lgo = _ImVrs(['img'=>ctjTx($row_DtRg['clare_logo'],'in'), 'f'=>DMN_FLE_CL_ARE_LGO ]);
						$__img_hdr = _ImVrs(['img'=>ctjTx($row_DtRg['clare_hdr'],'in'), 'f'=>DMN_FLE_CL_ARE_HDR ]);

						$___id = $row_DtRg['id_clare'];

						$Vl['ls'][$___id] = [
												'id'=>$___id,
												'tt'=>ctjTx($row_DtRg['clare_tt'],'in'),
												'clr'=>ctjTx($row_DtRg['clare_clr'],'in'),
												'logo'=>ctjTx($row_DtRg['clare_logo'],'in'),
												'tp'=>[
													'id'=>ctjTx($row_DtRg['tipo_id_sisslc'],'in'),
													'tt'=>ctjTx($row_DtRg['tipo_sisslc_tt'],'in'),
													'enc'=>ctjTx($row_DtRg['tipo_sisslc_enc'],'in')
												],
												'img'=>[
													'main'=>$__img,
													'hdr'=>$__img_hdr,
													'lgo'=>$__img_lgo
												]
											];

						if(!isN($row_DtRg['clare_clr'])){
							$_clr = Spn('','','_clr','background-color:'.ctjTx($row_DtRg['clare_clr'],'in'));
						}else{
							$_clr = '';
						}

						$_html_li .= li($_clr.ctjTx($row_DtRg['clare_tt'],'in'));

					}while($row_DtRg = $DtRg->fetch_assoc());


					$Vl['html'] = ul($_html_li, 'are_ls');

				}

			}

			$__cnx->_clsr($DtRg);

		}

		return(_jEnc($Vl));

	}





	function GtEcDt($Id, $tp=NULL, $p=NULL){

		global $__cnx;

		$Vl['e'] = 'no';

		if(!isN($Id)){

			if($tp == 'enc'){ $__fl = 'ec_enc'; }
			elseif($tp == 'pm'){ $__fl = 'ec_pml'; }
			else{ $__fl = 'id_ec'; }

			$c_DtRg = "-1";if (isset($Id)){$c_DtRg = $Id;}

			$query_DtRg = sprintf('	SELECT  id_ec, ec_enc, ec_tt, ec_dsc, ec_dir, ec_pml,
											ec_shr, ec_img, ec_img_w, ec_img_h, ec_ord, ec_sbj, ec_prhdr, ec_sbt,
											ec_cds, ec_nmr, ec_frw, ec_cd, ec_lnk,
											ec_w, ec_lnk_nxt, ec_em, ec_dir, ec_spn, ec_fnd,
											ec_pdf, ec_pay, ec_sis, ec_act_frm,
											ec_fi, ec_cl, ec_fa, ec_est, ec_frm, ec_us, ec_img,
											ec_cmzrlc, ec_cd_trck, ec_chk_hdr, ec_chk_ftr, ec_upd_img,

										   '._QrySisSlcF([ 'als'=>'e', 'als_n'=>'Estado' ]).',
										   '.GtSlc_QryExtra([ 't'=>'fld', 'p'=>'Estado', 'als'=>'e' ]).'
									FROM '._BdStr(DBM).TB_EC.'
										 INNER JOIN '._BdStr(DBM).TB_CL.' ON ec_cl = id_cl
										 '.GtSlc_QryExtra([ 't'=>'tb', 'col'=>'ec_est', 'als'=>'e' ]).'
									WHERE '.$__fl.' = %s
									LIMIT 1', GtSQLVlStr($c_DtRg,'text'));

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg > 0){

					$Vl['e'] = 'ok';

					$Vl['id'] = $row_DtRg['id_ec'];
					$Vl['tt'] = ctjTx($row_DtRg['ec_tt'],'in');
					$Vl['dsc'] = ctjTx($row_DtRg['ec_dsc'],'in');
					$Vl['dir'] = ctjTx($row_DtRg['ec_dir'],'in');
					$Vl['enc'] = ctjTx($row_DtRg['ec_enc'],'in');
					$Vl['pml'] = ctjTx($row_DtRg['ec_pml'],'in');
					$Vl['shr'] = ctjTx($row_DtRg['ec_shr'],'in');

					$Vl['img'] = ctjTx($row_DtRg['ec_img'],'in');
					$Vl['img_w'] = ctjTx($row_DtRg['ec_img_w'],'in');
					$Vl['img_h'] = ctjTx($row_DtRg['ec_img_h'],'in');

					$Vl['ord'] = ctjTx($row_DtRg['ec_ord'],'in');
					$Vl['sbj'] = ctjTx($row_DtRg['ec_sbj'],'in');
					$Vl['prhdr'] = ctjTx($row_DtRg['ec_prhdr'],'in');

					$Vl['sbt'] = ctjTx($row_DtRg['ec_sbt'],'in');
					$Vl['cds'] = ctjTx($row_DtRg['ec_cds'],'in');
					$Vl['nmr'] = ctjTx($row_DtRg['ec_nmr'],'in');
					$Vl['frw'] = ctjTx($row_DtRg['ec_frw'],'in');

					$Vl['pem'] = CODNM_EC.ctjTx($row_DtRg['id_ec'],'in');

					//$Vl['tp_id'] = $row_DtRg['ec_tp'];

					$Vl['cod'] = ctjTx($row_DtRg['ec_cd'],'in', '', ['html'=>'ok','schr'=>'no','nl2'=>'no','qte'=>'no']);

					$Vl['lnk'] = ctjTx($row_DtRg['ec_lnk'],'in');
					$Vl['lnk_nxt'] = ctjTx($row_DtRg['ec_lnk_nxt'],'in');

					$Vl['sz']['w'] = $row_DtRg['ec_w'];
					$Vl['eml'] = ctjTx($row_DtRg['ec_em'],'in');
					$Vl['fld'] = ctjTx($row_DtRg['ec_dir'],'in');
					$Vl['spn'] = ctjTx($row_DtRg['ec_spn'],'in');
					$Vl['fnd'] = ctjTx($row_DtRg['ec_fnd'],'in');
					//$Vl['evn_f'] = $row_DtRg['ec_evn_f'];
					//$Vl['evn_p'] = ctjTx($row_DtRg['ec_evn_p'],'in');
					$Vl['pdf'] = $row_DtRg['ec_pdf'];
					$Vl['pay'] = $row_DtRg['ec_pay'];
					$Vl['sis'] = $row_DtRg['ec_sis'];

					$Vl['act_frm'] = $row_DtRg['ec_act_frm'];

					$Vl['upd_img'] = mBln($row_DtRg['ec_upd_img']);

					$Vl['fm'] = $row_DtRg['ec_fm'];
					$Vl['fi'] = _LclDte($row_DtRg['ec_fi']);
					//$Vl['hi'] = $row_DtRg['ec_hi'];
					$Vl['fa'] = $row_DtRg['ec_fa'];

					$Vl['est']['id'] = $row_DtRg['ec_est'];
					$Vl['est']['tt'] = $row_DtRg['Estado_sisslc_tt'];

					$__formato_go = __LsDt([ 'id'=>$row_DtRg['ec_frm'], 'no_lmt'=>'ok' ]);
					$Vl['frm'] = $__formato_go->d;

					if($p['dtl']['us']=='ok'){
						$Vl['us'] = GtUsDt($row_DtRg['ec_us'],'');
					}

					if($p['dtl']['are']=='ok'){
						$Vl['are'] = GtEcAreLs([ 'ec'=>$row_DtRg['id_ec'] ]);
					}

					if($p['dtl']['tp']=='ok'){
						$Vl['tp'] = GtEcTpLs([ 'ec'=>$row_DtRg['id_ec'] ]);
					}
					//$Vl['tp'] = $row_DtRg['mdlstp_tp'];

					if($p['dtl']['cl']=='ok'){
						$Vl['cl'] = GtClDt($row_DtRg['ec_cl'], '', [ 'dtl' => [ 'tag' => 'ok' ] ]);
					}else{
						$Vl['cl']['id'] = $row_DtRg['ec_cl'];
					}

					$Vl['img_v'] = _ImVrs([ 'img'=>$row_DtRg['ec_img'], 'f'=>DMN_FLE_EC_IMG, 'img_ste'=>$row_DtRg['ec_enc'], 'img_ste_d'=>DMN_FLE_EC ]);

					if($p['cmz']=='ok'){
						$Vl['cmzrlc'] = GtEcCmzDt([ 'cmz'=>$row_DtRg['ec_cmzrlc'] ]);
					}

					if($p['dtl']['cod_trck']=='ok'){
						$Vl['cod_trck'] = ctjTx($row_DtRg['ec_cd_trck'],'in', '', ['html'=>'ok','schr'=>'no','nl2'=>'no','qte'=>'no']);
					}


					$Vl['chk']['hdr'] = mBln($row_DtRg['ec_chk_hdr']);
					$Vl['chk']['ftr'] = mBln($row_DtRg['ec_chk_ftr']);

				}else{

					$Vl['tot'] = $Tot_DtRg;

				}

			}else{

				$Vl['w'] = $__cnx->c_r->error;

			}

			$__cnx->_clsr($DtRg);

		}else{

			$Vl['w'] = 'No get ID';

		}

		return _jEnc($Vl);

	}



	function GtEcLs($p=NULL){

		global $__cnx;

		$Vl['e'] = 'no';

		$___Dt = new CRM_Dt();
		$___Dt->sch->f = 'id_ec, ec_ord, ec_cd, ec_tt, ec_cd';
		$___Dt->_sch();

		if(!isN($p['tp'])){ $__fl .= " AND mdlstp_tp = '".$p['tp']."' "; ; }
		if(!isN($p['lst']) && isN($___Dt->_sch)){ $__fl .= " AND id_ec < '".$p['lst']."' "; ; }
		if(isN($p['sis'])){ $__fl .= " AND ec_sis=2 "; ; }
		if(isN($p['cmz'])){ $__fl .= " AND ec_cmz=2 "; ; }


		if(!isN($___Dt->sch->cod)){
			$__fl .= $___Dt->sch->cod;
			$__lmt = 100;
		}else{
			$__lmt = 10;
		}

		$Ls_Qry = "	SELECT *
					FROM "._BdStr(DBM).TB_EC."
						 INNER JOIN "._BdStr(DBM).TB_CL." ON ec_cl = id_cl
						 LEFT JOIN "._BdStr(DBM).TB_EC_TP." ON ecmdlstp_ec = id_ec
						 LEFT JOIN "._BdStr(DBM).TB_MDL_S_TP." ON ecmdlstp_mdlstp = id_mdlstp
					WHERE
						cl_enc = '".DB_CL_ENC."' AND (ec_est = '"._CId('ID_SISEST_OK')."' || ec_est = '"._CId('ID_SISEST_APRB')."') AND id_ec != '' {$__fl}
					ORDER BY id_ec DESC
					LIMIT {$__lmt}";

		$Ls_Rg = $__cnx->_qry($Ls_Qry);

		if($Ls_Rg){

			$row_Ls_Rg = $Ls_Rg->fetch_assoc();
			$Tot_Ls_Rg = $Ls_Rg->num_rows;


			$Vl['e'] = 'ok';
			$Vl['tot'] = $Tot_Ls_Rg;

			if($Tot_Ls_Rg > 0){

				$_i = 0;

                do{

                    $Vl['ls'][$_i]['id'] = ctjTx($row_Ls_Rg['id_ec'],'in');
                    $Vl['ls'][$_i]['tt'] = ctjTx($row_Ls_Rg['ec_tt'],'in');
                    $Vl['ls'][$_i]['enc'] = ctjTx($row_Ls_Rg['ec_enc'],'in');
                    $Vl['ls'][$_i]['ord'] = ctjTx($row_Ls_Rg['ec_ord'],'in');
					$Vl['ls'][$_i]['img'] = _ImVrs([ 'img'=>$row_Ls_Rg['ec_img'], 'f'=>DMN_FLE_EC_IMG, 'img_ste'=>$row_Ls['ec_enc'], 'img_ste_d'=>DMN_FLE_EC ]);

					$_i++;

                } while ($row_Ls_Rg = $Ls_Rg->fetch_assoc());

            }
        }

		$__cnx->_clsr($Ls_Rg);

		$rtrn = _jEnc($Vl);
		return($rtrn);

	}




	function GtEcLnkDt($p=NULL){

		global $__cnx;

		if((!isN($p['id'])) || (!isN($p['ec']) && !isN($p['lnk']))){

			if(!isN($p['bd'])){
				$_bd = $p['bd'];
				//$Ls_TotLnk = ", (SELECT COUNT(*) FROM ".$_bd.TB_EC_TRCK." WHERE ectrck_lnk = id_eclnk) AS __tot_lnk ";
			}else{
				$_bd = '';
			}

			if($p['d']['lnk'] == 'ok'){ $__slc_lnk = ' , eclnk_lnk, eclnk_lnk_c '; }

			if($p['tp'] == 'enc'){

				$query_DtRg = sprintf('	SELECT id_eclnk, eclnk_enc, eclnk_ec '.$__slc_lnk.' '.$Ls_TotLnk.'
										FROM '._BdStr(DBM).TB_EC_LNK.'
										WHERE eclnk_enc=%s
										LIMIT 1', GtSQLVlStr($p['id'], 'text') );

			}elseif(!isN($p['ec'])){

				$query_DtRg = sprintf('	SELECT id_eclnk, eclnk_enc, eclnk_ec '.$__slc_lnk.' '.$Ls_TotLnk.'
										FROM '._BdStr(DBM).TB_EC_LNK.'
										WHERE eclnk_lnk=%s AND eclnk_ec=%s
										LIMIT 1', GtSQLVlStr($p['lnk'], 'text'), GtSQLVlStr($p['ec'], 'int'));

			}else{

				$query_DtRg = sprintf('	SELECT id_eclnk, eclnk_enc, eclnk_ec '.$__slc_lnk.' '.$Ls_TotLnk.'
										FROM '._BdStr(DBM).TB_EC_LNK.'
										WHERE id_eclnk=%s
										LIMIT 1', GtSQLVlStr($p['id'], 'text'));

			}

			if(!isN($query_DtRg)){

				if($p['cmmt'] == 'ok'){
					$DtRg = $__cnx->_prc($query_DtRg);
				}else{
					$DtRg = $__cnx->_qry($query_DtRg);
				}

				if($DtRg){

					$Vl['e'] = 'ok';
					$row_DtRg = $DtRg->fetch_assoc();
					$Tot_DtRg = $DtRg->num_rows;

					if($Tot_DtRg > 0){

						$Vl['id'] = $row_DtRg['id_eclnk'];
						$Vl['enc'] = $row_DtRg['eclnk_enc'];
						$Vl['tt'] = $row_DtRg['eclnk_lnk_c'];

						if(!isN($p['d'])){

							if($p['d']['ec'] == 'ok'){
								$Vl['ec'] = GtEcDt($row_DtRg['eclnk_ec'], '' );
							}

							if($p['d']['lnk'] == 'ok'){
								if(!isN($row_DtRg['eclnk_lnk_c'])){ $Vl['lnk'] = str_replace(['%5D','%5B'], [']', '['], $row_DtRg['eclnk_lnk_c']); }
							}
						}

						if(!isN($row_DtRg['__tot_lnk'])){
							$Vl['tot_trck'] = $row_DtRg['__tot_lnk'];
						}

					}

				}else{

					if($p['cmmt'] == 'ok'){
						$Vl['w'] = 'Error:'.$__cnx->c_p->error.' on '.compress_code($query_DtRg);
					}else{
						$Vl['w'] = 'Error:'.$__cnx->c_r->error.' on '.compress_code($query_DtRg);
					}

				}

				if(!isN($query_DtRg)){ $__cnx->_clsr($DtRg); }

			}else{

				$Vl['w'] = 'No query to execute';

			}

		}

		return _jEnc($Vl);

	}



	function GtEcLnkChk($p=NULL){

		global $__cnx;

		if(!isN($p['ec']) && !isN($p['lnk'])){

			$query_DtRg = sprintf("	CALL ".DBM.".Dt_EcLnk(%s, %s)",
									GtSQLVlStr($p['lnk'], 'text'),
									GtSQLVlStr($p['ec'], 'int'));

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc(); //print_r( $row_DtRg );
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg > 0){
					$Vl['e'] = 'ok';
					$Vl['id'] = $row_DtRg['id_eclnk'];
					$Vl['enc'] = $row_DtRg['eclnk_enc'];
				}

			}else{

				$Vl['w'] = $__cnx->c_r->error;

			}

			$__cnx->_clsr($DtRg);


		}else{

			$Vl['w'] = 'No all data for process';

		}

		return _jEnc($Vl);

	}




	function GtEcLnkLs($p=NULL){

		global $__cnx;

		if(!isN($p['i'])){

			$Ls_Qry_His = "SELECT *,
								 eclnk_ec AS ____ec,

								 (SELECT COUNT(*) FROM ".TB_EC_TRCK." WHERE ectrck_lnk = id_eclnk) AS __tot_lnk,
								 (SELECT COUNT(*) FROM ".TB_EC_TRCK.", "._BdStr(DBM).TB_EC_LNK." WHERE ectrck_lnk = id_eclnk AND eclnk_ec = ____ec) AS __tot_sum

						   FROM "._BdStr(DBM).TB_EC_LNK."
					   	   WHERE eclnk_ec = ".$p['i']."
					   	   ORDER BY __tot_lnk DESC";

			$Ls_Rg = $__cnx->_qry($Ls_Qry_His); $row_Ls_Rg = $Ls_Rg->fetch_assoc(); $Tot_Ls_Rg = $Ls_Rg->num_rows;

			if($Tot_Ls_Rg > 0){

                    $_r_li .= '<tr><th>Clics</th><th>%</th><th>Link</th></tr>';

                    do{
	                    $_n_p = ($row_Ls_Rg['__tot_lnk'] / $row_Ls_Rg['__tot_sum']) * 100;
						$_r_li .= '<tr><td>'.Strn($row_Ls_Rg['__tot_lnk']).'</td>
									   <td>'. _Nmb($_n_p , 1).'</td>
									   <td>'. ShortTx($row_Ls_Rg['eclnk_lnk'], 160, 'Pt').'</td>
								   </tr>';
                    } while ($row_Ls_Rg = $Ls_Rg->fetch_assoc());

                    $_r['html'] = '<table class="Ls_Rg" width="100%">'.$_r_li.'</table>';
            }

			$__cnx->_clsr($Ls_Rg);

			$rtrn = _jEnc($_r);
			if($p['r'] == 'c'){ return($__c); }else{ return($rtrn); }
		}
	}


	function GtEcLstsDt($_p=NULL){

		global $__cnx;

		if(!isN($_p['id'])){

			if($_p['t'] == 'enc'){ $__f = 'eclsts_enc'; $__ft = 'text'; }else{ $__f = 'id_eclsts'; $__ft = 'int'; }

			if( !isN($_p["bd"]) ){
				$_tot_eml = ", ( SELECT COUNT(*) FROM ".$_p["bd"].".".TB_EC_LSTS_EML." WHERE eclstseml_lsts = id_eclsts ) as _tot_eml";
			}

			$query_DtRg = sprintf("	SELECT *
									FROM "._BdStr(DBM).TB_EC_LSTS."
										 INNER JOIN "._BdStr(DBM).TB_CL." ON eclsts_cl = id_cl
									WHERE {$__f} = %s
									LIMIT 1", GtSQLVlStr($_p['id'], $__ft));

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg > 0){

					$Vl['e'] = 'ok';
					$Vl['id'] = $row_DtRg['id_eclsts'];
					$Vl['enc'] = $row_DtRg['eclsts_enc'];
					$Vl['nm'] = ctjTx($row_DtRg['eclsts_nm'],'in');
					$Vl['frm'] = ctjTx($row_DtRg['eclsts_frm'],'in');
					$Vl['rsgnup'] = ctjTx($row_DtRg['eclsts_rsgnup'],'in');
					$Vl['org'] = ctjTx($row_DtRg['eclsts_org'],'in');
					$Vl['adrs'] = ctjTx($row_DtRg['eclsts_adrs'],'in');
					$Vl['tel'] = ctjTx($row_DtRg['eclsts_tel'],'in');
					$Vl['auto'] = $row_DtRg['eclsts_auto'];
					$Vl['plcy'] = $row_DtRg['eclsts_plcy'];
					$Vl['tot_eml'] = $row_DtRg['eclsts_tot_eml'];

					if( !isN($_p["bd"]) ){
						//$Vl['tot'] = $row_DtRg['_tot_eml'];
					}

					if($_p['ls'] == 'ok'){

						$Vl['qry_r'] = GtEcEmlLs([
											'bd'=>$_p['bd'],
											'cl'=>$row_DtRg['cl_enc'],
											'lsts'=>[ 'id'=>$row_DtRg['id_eclsts'] ],
											'q_tot'=>'ok',
											'lmt'=>STUP_SND_LMT_MAX,
											'invk'=>'Lsts_QryR'
										]);

					}

					$Vl['qry_t'] = GtEcEmlTot([
											'bd'=>$_p['bd'],
											'cl'=>$row_DtRg['cl_enc'],
											'lsts'=>[ 'id'=>$row_DtRg['id_eclsts'] ]
									]);

					if(!isN($_p['cmpg'])){

						$Vl['snd_n'] = GtEcEmlLs([
											'ord'=>'rndm',
											'cl'=>$row_DtRg['cl_enc'],
											'bd'=>$_p['bd'],
											'lsts'=>[ 'id'=>$row_DtRg['id_eclsts'] ],
											'cmpg_nol'=>$_p['cmpg'],
											'lmt'=>STUP_SND_LMT_MAX,
											'invk'=>'Lsts_SndN'
										]);
					}

				}else{

					$Vl['e'] = 'no';

				}

			}else{

				$Vl['w'] = $query_DtRg.'->'.$__cnx->c_r->error;

			}

			$__cnx->_clsr($DtRg);

		}

		return(_jEnc($Vl));

	}



	function GtEcLstsSgmLs($_p=NULL){

		global $__cnx;

		if(!isN($_p['bd'])){ $__bd = _BdStr($_p['bd']); }

		if(!isN($_p['cmpg'])){ $_fl = " AND id_eclsts IN ( SELECT eccmpglsts_lsts FROM "._BdStr(DBM).TB_EC_CMPG_LSTS." WHERE eccmpglsts_cmpg = ".$_p['cmpg']." ) "; }

		$query_DtRg = "SELECT * FROM "._BdStr(DBM).TB_EC_LSTS_SGM."
						INNER JOIN "._BdStr(DBM).TB_EC_LSTS." ON eclstssgm_lsts = id_eclsts
						WHERE id_eclstssgm != '' {$_fl} ";

		$DtRg = $__cnx->_qry($query_DtRg);

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;

			if($Tot_DtRg > 0){

				do{

					$Vl[$row_DtRg['eclstssgm_enc']]['e'] = 'ok';
					$Vl[$row_DtRg['eclstssgm_enc']]['id'] = $row_DtRg['id_eclstssgm'];
					$Vl[$row_DtRg['eclstssgm_enc']]['enc'] = $row_DtRg['eclstssgm_enc'];
					$Vl[$row_DtRg['eclstssgm_enc']]['nm'] = ctjTx($row_DtRg['eclstssgm_nm'],'in');

				}while ($row_DtRg = $DtRg->fetch_assoc());

			}else{
				$Vl['e'] = 'no';
			}

		}else{

			echo $Vl['w'] = $__cnx->c_r->error;
		}

		$__cnx->_clsr($DtRg);

		return(_jEnc($Vl));

	}



	function GtEcLstsSgmDt($_p=NULL){

		global $__cnx;

		if(!isN($_p['id'])){

			if($_p['t'] == 'enc'){ $__f = 'eclstssgm_enc'; $__ft = 'text'; }else{ $__f = 'id_eclstssgm'; $__ft = 'int'; }

			if(!isN($_p['bd'])){
				$__bd = _BdStr($_p['bd']);
			}elseif(defined('DB_CL')){
				$__bd = _BdStr(DB_CL);
			}

			$query_DtRg = sprintf("
									SELECT id_eclstssgm, eclstssgm_enc, eclstssgm_nm, eclsts_nm, eclstssgm_tot_eml
									FROM "._BdStr(DBM).TB_EC_LSTS_SGM."
								   		 INNER JOIN "._BdStr(DBM).TB_EC_LSTS." ON eclstssgm_lsts = id_eclsts
								   	WHERE {$__f} = %s", GtSQLVlStr($_p['id'], $__ft)
								);

			$DtRg = $__cnx->_qry($query_DtRg); //$Vl['q'] = $query_DtRg;

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg > 0){

					$Vl['e'] = 'ok';
					$Vl['id'] = $row_DtRg['id_eclstssgm'];
					$Vl['enc'] = $row_DtRg['eclstssgm_enc'];
					$Vl['nm'] = ctjTx($row_DtRg['eclstssgm_nm'],'in');

					if($_p['d']['var'] == 'ok'){

						$Vl['var'] = GtEcLstsSgmVarLs([
										'bd'=>$__bd,
										'id'=>$row_DtRg['id_eclstssgm'],
										'cmpg_nol'=>$_p['cmpg'],
										'sgm_no'=>$_p['sgm_no'], // Not loaded in other segments
										'cmpg'=>$_p['cmpg'],
										'ls'=>$_p['ls'],
										'lmt'=>$_p['lmt']
									]);

					}

					$Vl['lsts']['id'] = ctjTx($row_DtRg['id_eclsts'],'in');
					$Vl['lsts']['nm'] = ctjTx($row_DtRg['eclsts_nm'],'in');
					$Vl['tot_eml'] = ctjTx($row_DtRg['eclstssgm_tot_eml'],'in');

				}else{
					$Vl['e'] = 'no';
				}

			}else{

				$Vl['w'] = $__cnx->c_r->error;
			}

			$__cnx->_clsr($DtRg);

			return(_jEnc($Vl));

		}

	}

	function GtEcLstsSgmEmlCount($_p=NULL){

		global $__cnx;

		if(!isN($_p['id'])){

			if($_p['t'] == 'enc'){
				$__f = 'eclstssgm_enc';
				$__ft = 'text';
			}else{
				$__f = 'id_eclstssgm';
				$__ft = 'int';
			}

			if($_p['d']['mlt'] == 'ok'){
				$__ft_w = 'IN (%s)';
				$_fl = $_p['id'];
			}else{
				$__ft_w = '= %s';
				$_fl = GtSQLVlStr($_p['id'], $__ft);
			}

			if(!isN($_p['bd'])){
				$__bd = _BdStr($_p['bd']);
			}elseif(defined('DB_CL')){
				$__bd = _BdStr(DB_CL);
			}


			$query_DtRg = sprintf("
									SELECT COUNT(DISTINCT id_cnteml) AS tot
									FROM ".TB_EC_LSTS_EML_SGM."
										INNER JOIN "._BdStr(DBM).TB_EC_LSTS_SGM." ON eclstsemlsgm_lstssgm = id_eclstssgm
										INNER JOIN "._BdStr(DBM).TB_EC_LSTS." ON eclstssgm_lsts = id_eclsts
										INNER JOIN "._BdStr(DBM).TB_EC_LSTS_PLCY." ON eclstsplcy_eclsts = id_eclsts
										INNER JOIN ".TB_CNT_EML." ON eclstsemlsgm_eml = id_cnteml
										INNER JOIN ".TB_CNT_EML_PLCY." ON cntemlplcy_cnteml = id_cnteml
									WHERE {$__f} {$__ft_w} AND
										   cnteml_est = "._CId('ID_SISEMLEST_ACT')." AND
										   cntemlplcy_sndi = 1 AND
										   eclstsplcy_e = 1", $_fl
								);

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg > 0){

					$Vl['e'] = 'ok';
					$Vl['tot'] = $row_DtRg['tot'];

				}else{
					$Vl['e'] = 'no';
				}

			}else{

				$Vl['w'] = $__cnx->c_r->error;
			}

			$__cnx->_clsr($DtRg);

			return(_jEnc($Vl));

		}

	}


	function GtEcLstsSgmVarLs($_p=NULL){

		global $__cnx;

		if( !isN($_p['id']) ){

			if(!isN($_p['bd'])){ $__bd = _BdStr($_p['bd']); }

			$query_DtRg = sprintf('SELECT *

								   FROM '._BdStr(DBM).TB_EC_LSTS_SGM_VAR.'
								   		INNER JOIN '._BdStr(DBM).TB_EC_LSTS_SGM.' ON eclstssgmvar_sgm = id_eclstssgm
								   		INNER JOIN '._BdStr(DBM).TB_EC_LSTS.' ON eclstssgm_lsts = id_eclsts
										INNER JOIN '._BdStr(DBM).TB_CL.' ON eclsts_cl = id_cl
								   		INNER JOIN '._BdStr(DBM).TB_SIS_EC_SGM_VAR.' ON eclstssgmvar_var = id_sisecsgmvar
								   		INNER JOIN '._BdStr(DBM).TB_SIS_EC_SGM.' ON sisecsgmvar_sgm = id_sisecsgm
								   		INNER JOIN '._BdStr(DBM).TB_SIS_EC_SGM_VAR_TP.' ON sisecsgmvar_tp = id_sisecsgmvartp

								   WHERE eclstssgmvar_sgm = %s', GtSQLVlStr($_p['id'], 'int'));

			$DtRg = $__cnx->_qry($query_DtRg);


			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				$Vl['tot'] = $Tot_DtRg;

				if(defined('SISUS_ID') && SISUS_ID == 163){ $Vl['qry'] = $query_DtRg; }

				if($Tot_DtRg > 0){

					do{

						$__sgm_id = $row_DtRg['id_eclstssgm'];
						$__lsts_id = $row_DtRg['eclstssgm_lsts'];

						$_id_sgm = $row_DtRg['id_eclstssgmvar'];
						$_cl_enc = $row_DtRg['cl_enc'];

						$Vl['ls'][$_id_sgm] = [
												'id'=>$_id_sgm,
												'vl'=>$row_DtRg['eclstssgmvar_vl'],
												'sgm_nm'=>ctjTx($row_DtRg['sisecsgm_nm'],'in'),
												'var_nm'=>ctjTx($row_DtRg['sisecsgmvar_nm'],'in'),
												'qry'=>$_opr." ".$row_DtRg['sisecsgmvar_qry']
											];

						$__eml_sgm[ $row_DtRg['id_eclstssgm'] ];


					} while ($row_DtRg = $DtRg->fetch_assoc());


					if($_p['ls'] == 'ok'){

						$Vl['qry_r'] = GtEcEmlLs([
											'bd'=>$__bd,
											'cl'=>$_cl_enc,
											'lsts'=>[ 'id'=>$__lsts_id ],
											'sgm'=>[ 'id'=>$__sgm_id, 'no'=>$_p['sgm_no'] ],
											'lmt'=>( (!isN($_p['lmt']))? $_p['lmt'] : STUP_SND_LMT_MAX ),
											'invk'=>'Sgm_QryR'
										]);

					}

					$Vl['qry_t'] = GtEcEmlTot([
											'bd'=>$__bd,
											'cl'=>$_cl_enc,
											'lsts'=>[ 'id'=>$__lsts_id ],
											'sgm'=>[ 'id'=>$__sgm_id, 'no'=>$_p['sgm_no'] ]
										]);

					if(!isN($_p['cmpg'])){

						$__fix_snd_n = GtEcEmlLs([
											'ord'=>'rndm',
											'bd'=>$__bd,
											'cl'=>$_cl_enc,
											'lsts'=>[ 'id'=>$__lsts_id, 'no'=>$_p['sgm_no'] ],
											'sgm'=>[ 'id'=>$__sgm_id, 'no'=>$_p['sgm_no'] ],
											'cmpg_nol'=>$_p['cmpg'],
											'lmt'=>STUP_SND_LMT_MAX,
											'invk'=>'Sgm_SndN'
										]);

						if($__fix_snd_n->tot > 0){
							$Vl['snd_n'] = $__fix_snd_n;
							$Vl['snd_n_q'] = $__fix_snd_n->qrym;
						}else{
							$Vl['snd_n'] = '';
							$Vl['snd_n_q'] = $__fix_snd_n->qrym;
						}

					}


				}

			}

			$__cnx->_clsr($DtRg);

			return _jEnc($Vl);
		}
	}

	function GtSisEcSgmDt($_p=NULL){

		global $__cnx;

		if(!isN($_p['id'])){

			if($_p['t'] == 'enc'){ $__f = 'sisecsgm_enc'; $__ft = 'text'; }else{ $__f = 'id_sisecsgm'; $__ft = 'int'; }

			$query_DtRg = sprintf("	SELECT *
								   	FROM "._BdStr(DBM).TB_SIS_EC_SGM."
								   	WHERE ".$__f." = %s", GtSQLVlStr($_p['id'], $__ft));

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg > 0){

					$Vl['e'] = 'ok';
					$Vl['id'] = $row_DtRg['id_sisecsgm'];
					$Vl['enc'] = $row_DtRg['sisecsgm_enc'];
					$Vl['nm'] = ctjTx($row_DtRg['sisecsgm_nm'],'in');

				}else{
					$Vl['e'] = 'no';
				}

			}

			$__cnx->_clsr($DtRg);

			return(_jEnc($Vl));
		}

	}


	function GtSisEcSgmVarDt($_p=NULL){

		global $__cnx;

		if(!isN($_p['id'])){

			if($_p['t'] == 'enc'){ $__f = 'sisecsgmvar_enc'; $__ft = 'text'; }else{ $__f = 'id_sisecsgmvar'; $__ft = 'int'; }

			$query_DtRg = sprintf("	SELECT *
								   	FROM "._BdStr(DBM).TB_SIS_EC_SGM_VAR."
								   		 INNER JOIN "._BdStr(DBM).TB_SIS_EC_SGM_VAR_TP." ON sisecsgmvar_tp = id_sisecsgmvartp
								   	WHERE ".$__f." = %s", GtSQLVlStr($_p['id'], $__ft));

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg > 0){

					$Vl['e'] = 'ok';
					$Vl['id'] = $row_DtRg['id_sisecsgmvar'];
					$Vl['nm'] = ctjTx($row_DtRg['sisecsgmvar_nm'],'in');

					if(!isN($row_DtRg['sisecsgmvar_ls'])){

						$Vl['ls']['l'] = ctjTx($row_DtRg['sisecsgmvar_ls'],'in');
						$Vl['ls']['d'] = ctjTx($row_DtRg['sisecsgmvar_dt'],'in');

					}


					$Vl['tp']['id'] = ctjTx($row_DtRg['id_sisecsgmvartp'], 'in');
					$Vl['tp']['nm'] = ctjTx($row_DtRg['sisecsgmvartp_nm'], 'in');
					$Vl['tp']['gts'] = ctjTx($row_DtRg['sisecsgmvartp_gts'], 'in');
					$Vl['tp']['ls'] = ctjTx($row_DtRg['sisecsgmvar_ls'], 'in');
					$Vl['tp']['dt'] = ctjTx($row_DtRg['sisecsgmvar_dt'], 'in');


				}else{
					$Vl['e'] = 'no';
				}

			}

			$__cnx->_clsr($DtRg);

			return(_jEnc($Vl));
		}

	}


	function GtEcCmpgBtchTot($_p=NULL){

		global $__cnx;


		$Vl['e'] = 'no';

		if(!isN($_p['id'])){

			if(!isN($_p['bd'])){ $__bd = _BdStr($_p['bd']); }

			if( !isN($_p['glb']) && $_p['glb'] == 'ok' ){ $__fl_tot = " AND ecsndcmpg_cmpg IS NOT NULL "; }else{ $__fl_tot = sprintf(" AND ecsndcmpg_cmpg=%s ", GtSQLVlStr($_p['id'], 'int')); }


			if($_p['t'] == 'l'){

				$__qry_btch = "
								SELECT DISTINCT COUNT(*) AS __tot
								FROM ".$__bd.TB_EC_SND_CMPG."
									 INNER JOIN ".$__bd.TB_EC_SND." ON ecsndcmpg_snd = id_ecsnd
								WHERE ecsnd_test = 2 $__fl_tot
							";

			}elseif($_p['t'] == 'in'){

				$__qry_btch = "
						    	SELECT DISTINCT COUNT(*) AS __tot
								FROM ".$__bd.TB_EC_SND_CMPG."
									 INNER JOIN ".$__bd.TB_EC_SND." ON ecsndcmpg_snd = id_ecsnd
								WHERE ecsnd_test = 2 $__fl_tot
							";

			}elseif($_p['t'] == 'snd'){

				$__qry_btch = "
						    	SELECT DISTINCT COUNT(*) AS __tot
								FROM ".$__bd.TB_EC_SND_CMPG."
									 INNER JOIN ".$__bd.TB_EC_SND." ON ecsndcmpg_snd = id_ecsnd
								WHERE  (	ecsnd_est = "._CId('ID_SNDEST_SND')." ||
																		ecsnd_est = "._CId('ID_SNDEST_ACPT')." ||
																		ecsnd_est = "._CId('ID_SNDEST_RBT')."
																	) AND ecsnd_test = 2 $__fl_tot
							";

			}elseif($_p['t'] == 'p'){

				$__qry_btch = "
						    	SELECT DISTINCT COUNT(*) AS __tot
								FROM ".$__bd.TB_EC_SND_CMPG."
									 INNER JOIN ".$__bd.TB_EC_SND." ON ecsndcmpg_snd = id_ecsnd
								WHERE ecsnd_est = "._CId('ID_SNDEST_PRG')." AND ecsnd_test = 2 $__fl_tot

							";

			}elseif($_p['t'] == 'w'){

				$__qry_btch = "
						    	SELECT DISTINCT COUNT(*) AS __tot
								FROM ".$__bd.TB_EC_SND_CMPG."
									 INNER JOIN ".$__bd.TB_EC_SND." ON ecsndcmpg_snd = id_ecsnd
								WHERE ecsnd_est = "._CId('ID_SNDEST_RBT')." AND ecsnd_test = 2 $__fl_tot

							";

			}

			if(!isN($__qry_btch)){

				$query_DtRg = sprintf($__qry_btch);
				$DtRg = $__cnx->_qry($query_DtRg);

			}

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg > 0){

					$Vl['e'] = 'ok';
					$Vl['tot'] = $row_DtRg['__tot'];

				}

			}

			$__cnx->_clsr($DtRg);

			return(_jEnc($Vl));
		}

	}


	function GtEcSndTot($_p=NULL){

		global $__cnx;

		$Vl['e'] = 'no';

		$_f_flg = 'no';
		if(!isN($_p['fi']) && !isN($_p['ff'])){
            $__dt_1 = date("Y-m", strtotime($_p['fi']));
			$__dt_2 = date("Y-m", strtotime($_p['ff']));
			$_f_flg = 'ok';
        }

		if(!isN($_p['bd'])){ $__bd = _BdStr($_p['bd']); }

		if($_p['t'] == 'all'){

			if($_f_flg == 'ok'){ $__fl = " AND DATE_FORMAT( ecsnd_fi, '%Y-%m' ) BETWEEN '".$__dt_1."' AND '".$__dt_2."'"; }

			$__qry_btch = "
							SELECT DISTINCT COUNT(*) AS __tot
							FROM ".$__bd.TB_EC_SND."
							WHERE ecsnd_test = 2 $__fl
						";


		}elseif($_p['t'] == 'snd'){

			if($_f_flg == 'ok'){ $__fl = " AND DATE_FORMAT( ecsnd_fi, '%Y-%m' ) BETWEEN '".$__dt_1."' AND '".$__dt_2."'"; }

			$__qry_btch = "
							SELECT DISTINCT COUNT(*) AS __tot
							FROM ".$__bd.TB_EC_SND."
							WHERE
									ecsnd_test = 2 AND
									( ecsnd_est = "._CId('ID_SNDEST_SND')." ||
									ecsnd_est = "._CId('ID_SNDEST_ACPT')." ||
									ecsnd_est = "._CId('ID_SNDEST_RBT')."
									)
									$__fl_tot $__fl
						";

		}elseif($_p['t'] == 'in'){

			if($_f_flg == 'ok'){ $__fl = " AND DATE_FORMAT( ecsnd_fi, '%Y-%m' ) BETWEEN '".$__dt_1."' AND '".$__dt_2."'"; }

			$__qry_btch = "
							SELECT DISTINCT COUNT(*) AS __tot
							FROM ".$__bd.TB_EC_SND."
							WHERE ecsnd_test = 2 $__fl_tot $__fl
						";

		}elseif($_p['t'] == 'err'){

			if($_f_flg == 'ok'){ $__fl = " AND DATE_FORMAT( ecsnd_fi, '%Y-%m' ) BETWEEN '".$__dt_1."' AND '".$__dt_2."'"; }

			$__qry_btch = "
							SELECT DISTINCT COUNT(*) AS __tot
							FROM ".$__bd.TB_EC_SND."
							WHERE ecsnd_test = 2 AND

									(	ecsnd_est = "._CId('ID_SNDEST_SND')." ||
									ecsnd_est = "._CId('ID_SNDEST_ACPT')." ||
									ecsnd_est = "._CId('ID_SNDEST_RBT')."
									) AND

									(ecsnd_bnc_tp = '"._CId('ID_SISSNDBNCTP_PRMN')."') AND
									(ecsnd_bnc_tp_sub = '"._CId('ID_SISSNDBNCTPS_GEN')."' || ecsnd_bnc_tp_sub = '"._CId('ID_SISSNDBNCTPS_NOEML')."')

									$__fl_tot $__fl
						";

		}elseif($_p['t'] == 'op'){

			if($_f_flg == 'ok'){ $__fl = " AND DATE_FORMAT( ecsnd_fi, '%Y-%m' ) BETWEEN '".$__dt_1."' AND '".$__dt_2."'"; }

			$__qry_btch = "
							SELECT DISTINCT COUNT(*) AS __tot
							FROM ".$__bd.TB_EC_OP.", ".$__bd.TB_EC_SND."
							WHERE ecop_snd = id_ecsnd AND ecsnd_test = 2 $__fl
						";

		}elseif($_p['t'] == 'trck'){

			if($_f_flg == 'ok'){ $__fl = " AND DATE_FORMAT( ecsnd_fi, '%Y-%m' ) BETWEEN '".$__dt_1."' AND '".$__dt_2."'"; }

			$__qry_btch = "
							SELECT DISTINCT COUNT(*) AS __tot
							FROM ".$__bd."ec_trck, ".$__bd.TB_EC_SND."
							WHERE ectrck_snd = id_ecsnd AND ecsnd_test = 2 $__fl

						";

		}elseif($_p['t'] == 'rmv'){


			if($_f_flg == 'ok'){ $__fl = " AND DATE_FORMAT( ecsnd_fi, '%Y-%m' ) BETWEEN '".$__dt_1."' AND '".$__dt_2."'"; }
			$__qry_btch = "
							SELECT DISTINCT COUNT(*) AS __tot
							FROM ".$__bd.TB_EC_SND."
							WHERE ecsnd_test = 2 AND id_ecsnd IN (	SELECT cntemlrmv_snd
																			FROM ".$__bd.TB_CNT_EML_RMV."
																		)
									$__fl_tot $__fl
						";

		}


		if(!isN($__qry_btch)){

			$query_DtRg = $__qry_btch;
			$DtRg = $__cnx->_qry($query_DtRg);
		}

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;

			if($Tot_DtRg > 0){

				$Vl['e'] = 'ok';
				$Vl['tot'] = $row_DtRg['__tot'];

			}

		}

		$__cnx->_clsr($DtRg);

		return(_jEnc($Vl));

	}


	function GtEcCmpgSndTot($_p=NULL){

		global $__cnx;


		$Vl['e'] = 'no';

		if(!isN($_p['id'])){

			if(!isN($_p['bd'])){ $__bd = _BdStr($_p['bd']); }

			if( !isN($_p['glb']) && $_p['glb'] == 'ok' ){ $__fl_tot = " AND ecsndcmpg_cmpg IS NOT NULL "; }else{ $__fl_tot = sprintf(" AND ecsndcmpg_cmpg=%s ", GtSQLVlStr($_p['id'], 'int')); }


			if($_p['t'] == 'snd'){

				$__qry_btch = "
								SELECT DISTINCT COUNT(*) AS __tot
								FROM ".$__bd.TB_EC_SND_CMPG."
								 	 INNER JOIN ".$__bd.TB_EC_SND." ON ecsndcmpg_snd = id_ecsnd
								WHERE
									  ecsnd_test = 2 AND
									  ( ecsnd_est = "._CId('ID_SNDEST_SND')." ||
									  	ecsnd_est = "._CId('ID_SNDEST_ACPT')." ||
									  	ecsnd_est = "._CId('ID_SNDEST_RBT')."
									  )
									  $__fl_tot
							";

			}elseif($_p['t'] == 'in'){

				$__qry_btch = "
						    	SELECT DISTINCT COUNT(*) AS __tot
								FROM ".$__bd.TB_EC_SND_CMPG."
								 	INNER JOIN ".$__bd.TB_EC_SND." ON ecsndcmpg_snd = id_ecsnd
								WHERE ecsnd_test = 2 $__fl_tot
							";

			}elseif($_p['t'] == 'err'){

				$__qry_btch = "
						    	SELECT DISTINCT COUNT(*) AS __tot
								FROM ".$__bd.TB_EC_SND_CMPG."
									 INNER JOIN ".$__bd.TB_EC_SND." ON ecsndcmpg_snd = id_ecsnd
								WHERE ecsnd_test = 2 AND

									  (	ecsnd_est = "._CId('ID_SNDEST_SND')." ||
									  	ecsnd_est = "._CId('ID_SNDEST_ACPT')." ||
									  	ecsnd_est = "._CId('ID_SNDEST_RBT')."
									  ) AND

									  (ecsnd_bnc_tp = '"._CId('ID_SISSNDBNCTP_PRMN')."') AND
									  (ecsnd_bnc_tp_sub = '"._CId('ID_SISSNDBNCTPS_GEN')."' || ecsnd_bnc_tp_sub = '"._CId('ID_SISSNDBNCTPS_NOEML')."')

									  $__fl_tot
							";

			}elseif($_p['t'] == 'op'){

				$__qry_btch = "
						    	SELECT DISTINCT COUNT(*) AS __tot
								FROM ".$__bd.TB_EC_SND_CMPG."
								WHERE ecsndcmpg_snd IN (	SELECT ecop_snd
						    								FROM ".TB_EC_OP.", ".$__bd.TB_EC_SND."
															WHERE ecop_snd = id_ecsnd AND ecop_snd = ecsndcmpg_snd AND ecsnd_test = 2
														) $__fl_tot
							";

			}elseif($_p['t'] == 'trck'){

				$__qry_btch = "
						    	SELECT DISTINCT COUNT(*) AS __tot
								FROM ".$__bd.TB_EC_SND_CMPG."
								WHERE ecsndcmpg_snd IN (	SELECT ectrck_snd
						    								FROM ec_trck, ".$__bd.TB_EC_SND."
															WHERE ectrck_snd = id_ecsnd AND ectrck_snd = ecsndcmpg_snd AND ecsnd_test = 2
														) $__fl_tot

							";

			}elseif($_p['t'] == 'rmv'){

				$__qry_btch = "
						    	SELECT DISTINCT COUNT(*) AS __tot
								FROM ".$__bd.TB_EC_SND_CMPG."
									 INNER JOIN ".$__bd.TB_EC_SND." ON ecsndcmpg_snd = id_ecsnd
								WHERE ecsnd_test = 2 AND ecsndcmpg_snd IN 	(	SELECT cntemlrmv_snd
																				FROM ".TB_CNT_EML_RMV."
																			)
									  $__fl_tot
							";

			}

			if(!isN($__qry_btch)){

				$query_DtRg = sprintf($__qry_btch);
				$DtRg = $__cnx->_qry($query_DtRg);

			}

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg > 0){

					$Vl['e'] = 'ok';
					$Vl['tot'] = $row_DtRg['__tot'];

				}

			}

			$__cnx->_clsr($DtRg);

			return(_jEnc($Vl));
		}

	}


	function GtEcCmpgDt($_p=NULL){

		global $__cnx;

		$Vl['e'] = 'no';

		if(!isN($_p['id'])){

			if($_p['t'] == 'enc'){ $__f = 'eccmpg_enc'; $__ft = 'text'; }else{ $__f = 'id_eccmpg'; $__ft = 'int'; }
			if(!isN($_p['bd'])){ $__bd = _BdStr($_p['bd']); }

			$__fl_tot = " AND ecsndcmpg_cmpg = id_eccmpg ";

			if($_p['q_tot'] == 'ok'){
				if( !isN($_p['glb']) && $_p['glb'] == 'ok' ){ $__fl_tot = " AND ecsndcmpg_cmpg IS NOT NULL "; }
			}

			if($_p['sgm']['tot']){

				$__qry_tot .= "

					(
				     	SELECT COUNT(*)
						FROM "._BdStr(DBM).TB_EC_CMPG_SGM."
						WHERE eccmpgsgm_cmpg = id_eccmpg
					) AS ___sgm_tot,

				";

			}


			if($_p['sgm']['e'] == 'ok'){
				$__qry_tot .= "

					(	SELECT GROUP_CONCAT(eccmpgsgm_sgm SEPARATOR ',')
						FROM "._BdStr(DBM).TB_EC_CMPG_SGM."
						WHERE eccmpgsgm_cmpg = id_eccmpg
				    ) AS ___sgm_rlc,

				";
			}

			if($_p['lsts']['e'] == 'ok'){
				$__qry_tot .= "

					(	SELECT GROUP_CONCAT(eccmpglsts_lsts SEPARATOR ',')
						FROM "._BdStr(DBM).TB_EC_CMPG_LSTS."
						WHERE eccmpglsts_cmpg = id_eccmpg
					) AS ___lsts_rlc,

				";
			}

			if( !isN($_p['glb']) && $_p['glb'] == 'ok' ){
				$__fl_w = " id_eccmpg IS NOT NULL ";
			}else{
				$__fl_w = " {$__f} = %s ";
				$__lmt_w = " LIMIT 1 ";
			}

			$query_DtRg = sprintf("SELECT *,
											"._QrySisSlcF([ 'als'=>'e', 'als_n'=>'Estado' ]).",
											".GtSlc_QryExtra([ 't'=>'fld', 'p'=>'Estado', 'als'=>'e' ]).",
											"._QrySisSlcF([ 'als'=>'s', 'als_n'=>'Sender' ]).",
											".GtSlc_QryExtra([ 't'=>'fld', 'p'=>'Sender', 'als'=>'s' ]).",
										    {$__qry_tot}
										    {$__qry_btch}
									        ( CONCAT(eccmpg_p_f,' ',eccmpg_p_h) < NOW()) AS __dteon

								   FROM "._BdStr(DBM).TB_EC_CMPG."
								   	     ".GtSlc_QryExtra([ 't'=>'tb', 'col'=>'eccmpg_est', 'als'=>'e' ])."
								   		 ".GtSlc_QryExtra([ 't'=>'tb', 'col'=>'eccmpg_sndr', 'als'=>'s' ])."

								   WHERE $__fl_w
								   $__lmt_w

								   ", GtSQLVlStr($_p['id'], $__ft));

			$DtRg = $__cnx->_qry($query_DtRg);

			//$Vl['qry'] = $query_DtRg;

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg > 0){

					$__estado = json_decode($row_DtRg['___Estado']);

					foreach($__estado as $__estado_k=>$__estado_v){
						$__estado_go->{$__estado_v->key} = $__estado_v;
					}

					$Vl['e'] = 'ok';
					$Vl['id'] = $row_DtRg['id_eccmpg'];
					$Vl['enc'] = $row_DtRg['eccmpg_enc'];
					$Vl['nm'] = ctjTx($row_DtRg['eccmpg_nm'],'in');
					$Vl['sbj'] = ctjTx($row_DtRg['eccmpg_sbj'],'in');
					$Vl['frm'] = ctjTx($row_DtRg['eccmpg_frm'],'in');

					$Vl['p_f'] = ctjTx($row_DtRg['eccmpg_p_f'],'in');
					$Vl['p_h'] = ctjTx($row_DtRg['eccmpg_p_h'],'in');

					$___f1 = new DateTime($row_DtRg['eccmpg_p_f'].' '.$row_DtRg['eccmpg_p_h']);
					$___f2 = new DateTime(SIS_F_D2);
					$___diff = $___f1->diff($___f2);

					$Vl['tme']['diff'] = $___diff;

					if($___diff->invert == 0 && !isN($___diff->d) && $___diff->d > 2){
						$Vl['tme']['out'] = 'ok';
					}

					$Vl['fi'] = ctjTx($row_DtRg['eccmpg_fi'],'in');

					if($_p['ec'] == 'ok'){
						$Vl['ec'] = GtEcDt($row_DtRg['eccmpg_ec'], 'id');
					}

					$Vl['scl'] = ($row_DtRg['eccmpg_scl']==1?'ok':'no');
					$Vl['tll'] = ($row_DtRg['eccmpg_tll']==1?'ok':'no');
					$Vl['prhdr'] = ctjTx($row_DtRg['eccmpg_prhdr'],'in');
					$Vl['rply'] = ctjTx($row_DtRg['eccmpg_rply'],'in');
					$Vl['out_lsts'] = ctjTx($row_DtRg['eccmpg_out_lsts'],'in');
					$Vl['cod'] = CODNM_EC_CMPG.ctjTx($row_DtRg['id_eccmpg'],'in');
					$Vl['est']['id'] = ctjTx($row_DtRg['eccmpg_est'],'in');
					$Vl['est']['nm'] = ctjTx($row_DtRg['Estado_sisslc_tt'],'in');
					$Vl['est']['clr'] = $__estado_go->clr->vl;
					$Vl['nprb_dsc'] = ctjTx($row_DtRg['eccmpg_nprb_dsc'],'in');
					$Vl['allw'] = mBln($row_DtRg['__dteon']);
					$Vl['opn'] = mBln($row_DtRg['eccmpg_opn']);


					if($_p['ec'] == 'us'){
						$Vl['us'] = GtUsDt($row_DtRg['eccmpg_us'],'');
					}

					if($_p['lsts']['trck'] == 'ok'){
						$Vl['ls']['trck'] = GtEcCmpgTrckLs([ 'id'=>$row_DtRg['id_eccmpg'], 'bd'=>$__bd ]);
					}

					if($_p['lsts']['usop'] == 'ok'){
						$Vl['ls']['usop'] = GtEcCmpgUsOpLs([ 'id'=>$row_DtRg['id_eccmpg'], 'bd'=>$__bd]);
					}

					if($_p['lsts']['snd'] == 'ok'){
						$Vl['ls']['snd'] = GtEcCmpgDlvrLs([ 'id'=>$row_DtRg['id_eccmpg'], 'bd'=>$__bd, 's_f'=>$row_DtRg['eccmpg_p_f'], 's_h'=>$row_DtRg['eccmpg_p_h']]);
					}

					$Vl['sndr']['id'] = ctjTx($row_DtRg['eccmpg_sndr'],'in');
					$Vl['sndr']['tt'] = ctjTx($row_DtRg['Sender_sisslc_tt'],'in');
					$Vl['sndr']['img'] = DMN_FLE_SIS_SLC.ctjTx($row_DtRg['Sender_sisslc_img'],'in');
					$Vl['eml']['id'] = ctjTx($row_DtRg['eccmpg_eml'],'in');

					$Vl['tot']['lds'] = $row_DtRg['eccmpg_tot_lds'];
					$Vl['tot']['nallw'] = $row_DtRg['eccmpg_tot_nallw'];
					$Vl['tot']['html'] = $row_DtRg['eccmpg_tot_html'];


					if($_p['q_btch'] == 'ok'){
						$Vl['btch']['l'] = GtEcCmpgBtchTot([  'glb'=>$_p['glb'], 'bd'=>$__bd, 't'=>'l', 'id'=>$row_DtRg['id_eccmpg'] ])->tot;
						$Vl['btch']['in'] = GtEcCmpgBtchTot([  'glb'=>$_p['glb'], 'bd'=>$__bd, 't'=>'in', 'id'=>$row_DtRg['id_eccmpg'] ])->tot;
						$Vl['btch']['snd'] = GtEcCmpgBtchTot([  'glb'=>$_p['glb'], 'bd'=>$__bd, 't'=>'snd', 'id'=>$row_DtRg['id_eccmpg'] ])->tot;
						$Vl['btch']['p'] = GtEcCmpgBtchTot([  'glb'=>$_p['glb'], 'bd'=>$__bd, 't'=>'p', 'id'=>$row_DtRg['id_eccmpg'] ])->tot;
						$Vl['btch']['w'] = GtEcCmpgBtchTot([  'glb'=>$_p['glb'], 'bd'=>$__bd, 't'=>'w', 'id'=>$row_DtRg['id_eccmpg'] ])->tot;
					}


					if($_p['q_tot'] == 'ok'){

						$Vl['_tot_snd'] = GtEcCmpgSndTot([  'glb'=>$_p['glb'], 'bd'=>$__bd, 't'=>'snd', 'id'=>$row_DtRg['id_eccmpg'] ])->tot;
						$Vl['_tot_err'] = GtEcCmpgSndTot([  'glb'=>$_p['glb'], 'bd'=>$__bd, 't'=>'err', 'id'=>$row_DtRg['id_eccmpg'] ])->tot;
						$Vl['_tot_op'] = GtEcCmpgSndTot([  'glb'=>$_p['glb'], 'bd'=>$__bd, 't'=>'op', 'id'=>$row_DtRg['id_eccmpg'] ])->tot;
						$Vl['_tot_trck'] = GtEcCmpgSndTot([  'glb'=>$_p['glb'], 'bd'=>$__bd, 't'=>'trck', 'id'=>$row_DtRg['id_eccmpg'] ])->tot;
						$Vl['_tot_rmv'] = GtEcCmpgSndTot([  'glb'=>$_p['glb'], 'bd'=>$__bd, 't'=>'rmv', 'id'=>$row_DtRg['id_eccmpg'] ])->tot;
						$Vl['_tot_efct'] = $Vl['_tot_snd']-$Vl['_tot_err'];

						if($Vl['btch']['l'] > 0){ $Vl['_tot_snd_p'] = ($Vl['_tot_snd']*100)/$Vl['btch']['l']; }else{ $Vl['_tot_snd_p'] = 0; }

						if($Vl['_tot_snd'] > 0){
							$Vl['_tot_err_p'] = ($Vl['_tot_err']*100)/$Vl['_tot_snd'];
							$Vl['_tot_op_p'] = ($Vl['_tot_op']*100)/$Vl['_tot_snd'];
							$Vl['_tot_trck_p'] = ($Vl['_tot_trck']*100)/$Vl['_tot_snd'];
							$Vl['_tot_efct_p'] = ($Vl['_tot_efct']*100)/$Vl['_tot_snd'];
							$Vl['_tot_rmv_p'] = ($Vl['_tot_rmv']*100)/$Vl['_tot_snd'];
						}else{
							$Vl['_tot_err_p'] = 0;
							$Vl['_tot_op_p'] = 0;
							$Vl['_tot_trck_p'] = 0;
							$Vl['_tot_efct_p'] = 0;
							$Vl['_tot_rmv_p'] = 0;
						}

					}

					if($_p['sgm']['lsall'] == 'ok'){
						$Vl['sgm']['ls_all'] = GtEcLstsSgmLs([ 'bd'=>$_p['bd'], 'id'=>$_k, 'cmpg'=>$row_DtRg['id_eccmpg'], 'ls'=>$_p['lsts']['ls'] ]);
					}

					if($_p['sgm']['tot']){
						$Vl['sgm']['tot'] = $row_DtRg['___sgm_tot'];
					}

					if(!isN($row_DtRg['___sgm_rlc']) && $_p['sgm']['e'] == 'ok'){

						$Vl['eml']['snd'] = GtEcCmpgSndLs([ 'bd'=>$_p['bd'], 'cmpg'=>$row_DtRg['id_eccmpg'], 'bd'=>$_p['bd'], 't'=>'sgm', 'lmt'=>3 ]);

						$__sgm_all = explode(',',$row_DtRg['___sgm_rlc']);

						$__sgm_prcs = []; //----- Processed Segments -----//

						foreach($__sgm_all as $_k){

							$Lsts = GtEcLstsSgmDt([
										'bd'=>$_p['bd'],
										'id'=>$_k,
										'cmpg'=>$row_DtRg['id_eccmpg'],
										'sgm_no'=>$__sgm_prcs,
										'ls'=>$_p['lsts']['ls'],
										'd'=>[
											'var'=>'ok'
										]
									]);

							$__sgm_prcs[] = $Lsts->id;

							$Vl['sgm']['ls'][$_k] = $Lsts;

							$Vl['sgm']['eml_allw'] = $Vl['sgm']['eml_allw'] + $Lsts->var->qry_t->tot->allw;
							$Vl['sgm']['eml_noallw']['all'] = $Vl['sgm']['eml_noallw']['all'] + $Lsts->var->qry_t->tot->noallw->all;
							$Vl['sgm']['eml_noallw']['rjct'] = $Vl['sgm']['eml_noallw']['rjct'] + $Lsts->var->qry_t->tot->noallw->rjct;
							$Vl['sgm']['eml_noallw']['sndi'] = $Vl['sgm']['eml_noallw']['sndi'] + $Lsts->var->qry_t->tot->noallw->sndi;

						}

						$Vl['eml_allw'] = $Vl['sgm']['eml_allw'];
						$Vl['eml_noallw']['all'] = $Vl['sgm']['eml_noallw']['all'];
						$Vl['eml_noallw']['rjct'] = $Vl['sgm']['eml_noallw']['rjct'];
						$Vl['eml_noallw']['sndi'] = $Vl['sgm']['eml_noallw']['sndi'];

						if(!isN($Vl['eml_allw']) || !isN($row_DtRg['___sgm_rlc'])){
							$___no_count_lsts = 'ok'; // No count on lists foreach, all emails are now by segment
						}

					}


					if(!isN($row_DtRg['___lsts_rlc']) && $_p['lsts']['e'] == 'ok'){

						if($___no_count_lsts != 'ok'){
							$Vl['eml']['snd'] = GtEcCmpgSndLs([ 'bd'=>$_p['bd'], 'cmpg'=>$row_DtRg['id_eccmpg'], 't'=>'lsts', 'lmt'=>3 ]);
						}

						$__lsts_all = explode(',',$row_DtRg['___lsts_rlc']);

						foreach($__lsts_all as $_k){

							$Lsts = GtEcLstsDt([ 'bd'=>$_p['bd'], 'id'=>$_k, 'cmpg'=>$row_DtRg['id_eccmpg'], 'ls'=>$_p['lsts']['ls'] ]);

							$Vl['lsts']['ls'][$_k] = $Lsts;

							if($___no_count_lsts != 'ok'){
								$Vl['lsts']['eml_allw'] = $Vl['lsts']['eml_allw'] + $Lsts->qry_t->tot->allw;
								$Vl['lsts']['eml_noallw']['all'] = $Vl['lsts']['eml_noallw']['all'] + $Lsts->qry_t->tot->noallw->all;
								$Vl['lsts']['eml_noallw']['rjct'] = $Vl['lsts']['eml_noallw']['rjct'] + $Lsts->qry_t->tot->noallw->rjct;
								$Vl['lsts']['eml_noallw']['sndi'] = $Vl['lsts']['eml_noallw']['sndi'] + $Lsts->qry_t->tot->noallw->sndi;
							}

						}

						if($___no_count_lsts != 'ok'){
							$Vl['eml_allw'] = $Vl['lsts']['eml_allw'];
							$Vl['eml_noallw']['all'] = $Vl['lsts']['eml_noallw']['all'];
							$Vl['eml_noallw']['rjct'] = $Vl['lsts']['eml_noallw']['rjct'];
							$Vl['eml_noallw']['sndi'] = $Vl['lsts']['eml_noallw']['sndi'];
						}

					}


					if(!isN( $Vl['lsts']['ls'] )){

						foreach($Vl['lsts']['ls'] as $_k=>$_v){
							if(!isN($_v->nm)){
								$__lst_shw[] = $_v->nm;
							}
						}

						if(!isN($__lst_shw)){ $Vl['lsts']['html'] = implode(',', $__lst_shw); }


						if(!isN( $Vl['sgm']['ls'] )){

							foreach($Vl['sgm']['ls'] as $_k){

								if(!isN($_k->nm)){

									$__sgm_shw[] = $_k->nm;

									if(!isN($_k->var->lsts)){
										foreach($_k->var->ls as $_k2=>$_v2){
											$__sgm_shw[] = $_v2->sgm_nm.' '.Spn($_v2->var_nm.' '.$_v2->vl);
										}
									}

								}

							}

							if(!isN($__sgm_shw)){ $Vl['sgm']['html'] = implode(',', $__sgm_shw); }

						}

					}

				}

			}else{

				$Vl['w'] = $__cnx->c_r->error;
				//$Vl['q'] = $query_DtRg;

			}

			$__cnx->_clsr($DtRg);

		}

		return(_jEnc($Vl));

	}



	function GtEcCmpg_ToSend($_p=NULL){

		global $__cnx;

		$Vl['e'] = 'no';

		if(!isN($_p['bd'])){

			if($_p['ctp']=='html'){
				$__chk_ctp = 'eccmpg_f_chk_html';
			}elseif($_p['ctp']=='snd'){
				$__chk_ctp = 'eccmpg_f_chk_snd';
			}else{
				$__chk_ctp = 'eccmpg_rd_f';
			}

			if(!isN($_p['bd'])){ $__bd = _BdStr($_p['bd']); }
			if(!isN($_p['cl'])){ $__fl .= " AND eccmpg_cl='".$_p['cl']."' "; }

			if($_p['rd']!='no'){ $__fl_rd = " AND ( eccmpg_rd = 2 || ".$__chk_ctp." < NOW() - INTERVAL 1 MINUTE ) "; }

			if(!isN($_p['fl'])){ $__fl .= $_p['fl']; }

			if($_p['bld']=='ok'){

				$__pbld .= "

					(
						eccmpg_est = '"._CId('ID_ECCMPGEST_APRBD')."' ||
						eccmpg_est = '"._CId('ID_ECCMPGEST_SNDIN')."'
					)

					{$__fl_rd}

				";

			}else{

				$__pbld .= "
					eccmpg_est = '"._CId('ID_ECCMPGEST_SNDIN')."' AND
					CONCAT(eccmpg_p_f,' ',eccmpg_p_h) < NOW()
					{$__fl_rd}
				";

			}


			if($_p['ord']=='asc'){ $_ord_by=' eccmpg_p_f ASC, eccmpg_p_h ASC '; }else{ $_ord_by=' RAND() '; }
			if(!isN($_p['rdy'])){ $__fl .= ' AND eccmpg_rdy='.$_p['rdy'].' '; }


			$query_DtRg = sprintf("	SELECT id_eccmpg,
										   eccmpg_enc
									FROM "._BdStr(DBM).TB_EC_CMPG."
								   	WHERE id_eccmpg != '' AND
								   		  eccmpg_sndr = '"._CId('ID_SISEML_SUMR')."' AND
								   		  {$__pbld}
								   		  {$__fl}
								   	ORDER BY {$_ord_by}
									LIMIT 1");

			//echo compress_code('GtEcCmpg_ToSend:'.$query_DtRg);

			$Vl['qry'] = compress_code($query_DtRg);

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$Vl['e'] = 'ok';
				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg > 0){
					$Vl['id'] = $row_DtRg['id_eccmpg'];
					$Vl['enc'] = $row_DtRg['eccmpg_enc'];
				}else{
					$Vl['w'] = 'No records for '.compress_code($query_DtRg);
				}

			}else{

				$Vl['w'] = $__cnx->c_r->error;
				//$Vl['q'] = $query_DtRg;

			}

			$__cnx->_clsr($DtRg);

		}else{

			$Vl['w'] = 'No database';

		}

		return(_jEnc($Vl));

	}


	function GtEcCmpgSndLs($p=NULL){ //Enviados

		if(!isN($p['bd']) ){

			global $__cnx;

			if(!isN($p['cmpg'])){

				if($p['t'] == 'lsts'){

					$_f_in .= ' AND ecsndcmpg_cmpg IN ( SELECT eccmpglsts_cmpg
													    FROM '._BdStr(DBM).TB_EC_CMPG_LSTS.'
													    WHERE eccmpglsts_cmpg = '.$p['cmpg'].') ';
				}

				if($p['t'] == 'sgm'){

					$_f_in .= ' AND ecsndcmpg_cmpg IN ( SELECT eccmpgsgm_cmpg
														FROM '._BdStr(DBM).TB_EC_CMPG_SGM.'
														WHERE eccmpgsgm_cmpg = '.$p['cmpg'].') ';
				}
			}

			if(!isN($p['lmt'])){ $_lmt = ' LIMIT '.$p['lmt'].' '; }

			if(!isN($p['bd'])){
				$_bd = _BdStr($p['bd']);
			}elseif(defined('DB_CL') && !isN(DB_CL)){
				$_bd = _BdStr(DB_CL);
			}else{
				$_bd = '';
			}

			$Ls_Qry = " SELECT *
						FROM ".$_bd.TB_EC_SND_CMPG."
							 INNER JOIN ".TB_EC_SND." ON ecsndcmpg_snd = id_ecsnd
						WHERE ecsnd_test = 2 $_f_in
						ORDER BY id_ecsndcmpg ASC $_lmt";

			$LsTp_Rg = $__cnx->_qry($Ls_Qry);

			if($LsTp_Rg){

				$row_LsTp_Rg = $LsTp_Rg->fetch_assoc();
				$Tot_LsTp_Rg = $LsTp_Rg->num_rows;
				$_r['tot'] = $Tot_LsTp_Rg;

			    if($Tot_LsTp_Rg > 0){

	                do{

						$_v[] = ['id'=>ctjTx($row_LsTp_Rg['id_ecsnd'],'in'), 'msj'=>ctjTx($row_LsTp_Rg['ecsnd_msj'],'in'), 'eml'=>$row_LsTp_Rg['ecsnd_eml']];

					} while ($row_LsTp_Rg = $LsTp_Rg->fetch_assoc());
				}


	          	$_r['ls'] = $_v;

	      	}

		    $__cnx->_clsr($LsTp_Rg);

		}


	    return _jEnc($_r);
	}

	function GtEcCmpgUsTrckLs($_p=NULL){ //Abiertos

		global $__cnx;

		if(!isN($_p['id'])){

			if(!isN($_p['bd'])){ $__bd = _BdStr($_p['bd']); }

			if( !isN($_p['lmt']) ){

				if( $_p['lmt'] != 'no' ){
					$_fl_lmt = " LIMIT ".$_p['lmt']." ";
				}

			}else{
				$_fl_lmt = " LIMIT 10 ";
			}


			$Ls_Qry = sprintf(" SELECT *,
								COUNT(*) AS ___tot,
								( SELECT cnttel_tel FROM ".$__bd.TB_CNT_TEL." WHERE cnttel_cnt = id_cnt LIMIT 1) as _tel
								FROM ".$__bd.TB_EC_TRCK."
									 INNER JOIN ".$__bd.TB_EC_SND." ON ectrck_snd = id_ecsnd
									 INNER JOIN ".$__bd.TB_CNT." ON ecsnd_cnt = id_cnt
								WHERE id_ecsnd IN (SELECT ecsndcmpg_snd FROM ".$__bd.TB_EC_SND_CMPG." WHERE ecsndcmpg_cmpg = %s )

								GROUP BY ectrck_snd
								ORDER BY ___tot DESC
								$_fl_lmt
								", GtSQLVlStr($_p['id'], 'int'));

			$LsTp_Rg = $__cnx->_qry($Ls_Qry);

			if($LsTp_Rg){

				$row_LsTp_Rg = $LsTp_Rg->fetch_assoc();
				$Tot_LsTp_Rg = $LsTp_Rg->num_rows;

				$_r['tot'] = $Tot_LsTp_Rg;

			    if($Tot_LsTp_Rg > 0){
	                do{


						$_v[] = ['id'=>ctjTx($row_LsTp_Rg['id_ectrck'],'in'),
									  'nm'=>ctjTx($row_LsTp_Rg['cnt_nm'].' '.$row_LsTp_Rg['cnt_ap'],'in'),
									  'eml'=>ctjTx($row_LsTp_Rg['ecsnd_eml'],'in'),
									  'tel'=>$row_LsTp_Rg['_tel'],
									  'tot'=>$row_LsTp_Rg['___tot']];


					} while ($row_LsTp_Rg = $LsTp_Rg->fetch_assoc());
				}

	          	$_r['ls'] = $_v;

          	}else{

	          	echo 'GtEcCmpgUsOpLs:'.$__cnx->c_r->error;

          	}

          	$__cnx->_clsr($LsTp_Rg);

		}

	    return _jEnc($_r);
	}


	function GtEcCmpgTrckLs($_p=NULL){

		global $__cnx;

		if(!isN($_p['id'])){

			if(!isN($_p['bd'])){ $__bd = _BdStr($_p['bd']); }

			if($_p['t'] == 'enc'){ $__f = 'eclstseml_enc'; $__ft = 'text'; }else{ $__f = 'id_eclstseml'; $__ft = 'int'; }

			$Ls_Qry = sprintf(" SELECT *, COUNT(DISTINCT ectrck_snd) AS ___tot

								FROM ".$__bd.TB_EC_TRCK."
									 INNER JOIN ".$__bd.TB_EC_SND." ON ectrck_snd = id_ecsnd
									 INNER JOIN "._BdStr(DBM).TB_EC_LNK." ON ectrck_lnk = id_eclnk
								WHERE id_ecsnd IN (SELECT ecsndcmpg_snd FROM ".$__bd.TB_EC_SND_CMPG." WHERE ecsndcmpg_cmpg = %s )

								GROUP BY ectrck_lnk
								ORDER BY ___tot DESC
								", GtSQLVlStr($_p['id'], 'int'));

			$LsTp_Rg = $__cnx->_qry($Ls_Qry);

			if($LsTp_Rg){

				$row_LsTp_Rg = $LsTp_Rg->fetch_assoc();
				$Tot_LsTp_Rg = $LsTp_Rg->num_rows;

				$_r['tot'] = $Tot_LsTp_Rg;

			    if($Tot_LsTp_Rg > 0){
	                do{

						$_v[] = ['id'=>ctjTx($row_LsTp_Rg['id_eclnk'],'in'), 'lnk'=>ctjTx($row_LsTp_Rg['eclnk_lnk'],'in'), 'tot'=>$row_LsTp_Rg['___tot']];

					} while ($row_LsTp_Rg = $LsTp_Rg->fetch_assoc());
				}

	          	$_r['ls'] = $_v;

          	}else{

	          	echo 'GtEcCmpgTrckLs:'.$__cnx->c_r->error;

          	}

          	$__cnx->_clsr($LsTp_Rg);

		}

	    return _jEnc($_r);
	}

	function GtEcCmpgUsOpLs($_p=NULL){ //Abiertos

		global $__cnx;

		if(!isN($_p['id'])){

			if(!isN($_p['bd'])){ $__bd = _BdStr($_p['bd']); }

			if( !isN($_p['lmt']) ){

				if( $_p['lmt'] != 'no' ){
					$_fl_lmt = " LIMIT ".$_p['lmt']." ";
				}

			}else{
				$_fl_lmt = " LIMIT 10 ";
			}


			$Ls_Qry = sprintf(" SELECT *,
								COUNT(*) AS ___tot,
								( SELECT cnttel_tel FROM ".$__bd.TB_CNT_TEL." WHERE cnttel_cnt = id_cnt LIMIT 1) as _tel
								FROM ".$__bd.TB_EC_OP."
									 INNER JOIN ".$__bd.TB_EC_SND." ON ecop_snd = id_ecsnd
									 INNER JOIN ".$__bd.TB_CNT." ON ecsnd_cnt = id_cnt
								WHERE id_ecsnd IN (SELECT ecsndcmpg_snd FROM ".$__bd.TB_EC_SND_CMPG." WHERE ecsndcmpg_cmpg = %s )

								GROUP BY ecop_snd
								ORDER BY ___tot DESC
								$_fl_lmt
								", GtSQLVlStr($_p['id'], 'int'));


			$LsTp_Rg = $__cnx->_qry($Ls_Qry);

			if($LsTp_Rg){

				$row_LsTp_Rg = $LsTp_Rg->fetch_assoc();
				$Tot_LsTp_Rg = $LsTp_Rg->num_rows;

				$_r['tot'] = $Tot_LsTp_Rg;

			    if($Tot_LsTp_Rg > 0){
	                do{


						$_v[] = ['id'=>ctjTx($row_LsTp_Rg['id_eclnk'],'in'),
									  'nm'=>ctjTx($row_LsTp_Rg['cnt_nm'].' '.$row_LsTp_Rg['cnt_ap'],'in'),
									  'eml'=>ctjTx($row_LsTp_Rg['ecsnd_eml'],'in'),
									  'tel'=>$row_LsTp_Rg['_tel'],
									  'tot'=>$row_LsTp_Rg['___tot']];


					} while ($row_LsTp_Rg = $LsTp_Rg->fetch_assoc());
				}

	          	$_r['ls'] = $_v;

          	}else{

	          	echo 'GtEcCmpgUsOpLs:'.$__cnx->c_r->error;

          	}


			$__cnx->_clsr($LsTp_Rg);

		}

		return _jEnc($_r);

	}




	function GtEcDlvr_T_Ls($_p=NULL){

		global $__cnx;

		$_f_flg = 'no';
		if(!isN($_p['fi']) && !isN($_p['ff'])){
            $__dt_1 = date("Y-m", strtotime($_p['fi']));
			$__dt_2 = date("Y-m", strtotime($_p['ff']));
			$_f_flg = 'ok';
        }


		if(!isN($_p['bd'])){ $__bd = _BdStr($_p['bd']); }

		if($_p['t'] == 'op'){

			if($_p['c'] == 'h'){ $__f_grp = " DATE_FORMAT(CONCAT(ecop_f,' ', ecop_h),'%Y-%m-%d-%H') "; }else{ $__f_grp = " DATE_FORMAT(ecop_f,'%Y-%m-%d') "; }

			$__qry = "SELECT $__f_grp AS __f, COUNT( DISTINCT ecop_snd ) AS __tot

				    				FROM ".$__bd.TB_EC_OP." INNER JOIN ".$__bd.TB_EC_SND." ON ecop_snd = id_ecsnd
									WHERE ecsnd_test = 2 GROUP BY $__f_grp ";
		}elseif($_p['t'] == 'clc'){

			if($_p['c'] == 'h'){ $__f_grp = " DATE_FORMAT(CONCAT(ectrck_f,' ', ectrck_h),'%Y-%m-%d-%H') "; }else{ $__f_grp = " DATE_FORMAT(ectrck_f,'%Y-%m-%d') "; }

			$__qry = "SELECT $__f_grp AS __f, COUNT( DISTINCT ectrck_snd ) AS __tot

				    				FROM ".$__bd.TB_EC_TRCK." INNER JOIN ".$__bd.TB_EC_SND." ON ectrck_snd = id_ecsnd
									WHERE ecsnd_test = 2 GROUP BY $__f_grp ";
		}elseif($_p['t'] == 'rmv'){

			if($_p['c'] == 'h'){ $__f_grp = " DATE_FORMAT(cntemlrmv_fi,'%Y-%m-%d-%H') "; }else{ $__f_grp = " DATE_FORMAT(cntemlrmv_fi,'%Y-%m-%d') "; }

			$__qry = "SELECT $__f_grp AS __f, COUNT( DISTINCT cntemlrmv_snd ) AS __tot

				    				FROM ".$__bd.TB_CNT_EML_RMV." INNER JOIN ".$__bd.TB_EC_SND." ON cntemlrmv_snd = id_ecsnd
									WHERE  ecsnd_test = 2 GROUP BY $__f_grp ";
		}elseif($_p['t'] == 'dsp'){

			if($_f_flg == 'ok'){ $__fl = " AND DATE_FORMAT( ecop_f, '%Y-%m' ) BETWEEN '".$__dt_1."' AND '".$__dt_2."'"; }

			$__qry = "SELECT *, ecop_m AS __id, sisslc_tt AS __nm, COUNT(*) AS __tot

				    				FROM ".$__bd.TB_EC_OP."
				    					 INNER JOIN "._BdStr(DBM).TB_SIS_SLC." ON ecop_m = id_sisslc
				    					 INNER JOIN ".$__bd.TB_EC_SND." ON ecop_snd = id_ecsnd
									WHERE ecsnd_test = 2 $__fl
									GROUP BY ecop_m
									ORDER BY __tot DESC";

			$__tp_ls = 'grp';

		}elseif($_p['t'] == 'os'){

			if($_f_flg == 'ok'){ $__fl = " AND DATE_FORMAT( ecop_f, '%Y-%m' ) BETWEEN '".$__dt_1."' AND '".$__dt_2."'"; }

			$__qry = "SELECT *, ecop_brw_p AS __id, ecop_brw_p AS __nm, COUNT(*) AS __tot

				    				FROM ".$__bd.TB_EC_OP."
				    				INNER JOIN ".$__bd.TB_EC_SND." ON ecop_snd = id_ecsnd
									WHERE ecop_m != '"._CId('ID_SISDSP_DSKTP')."' AND ecsnd_test = 2 $__fl
									GROUP BY ecop_brw_p
									ORDER BY __tot DESC";

			$__tp_ls = 'grp';

		}elseif($_p['t'] == 'clnt'){

			if($_f_flg == 'ok'){ $__fl = " AND DATE_FORMAT( ecop_f, '%Y-%m' ) BETWEEN '".$__dt_1."' AND '".$__dt_2."'"; }

			$_emlmysql = " SUBSTRING_INDEX(SUBSTRING_INDEX(ecsnd_eml, '@', -1), '.', 1) ";

			$__qry = "SELECT *, {$_emlmysql} AS __id, {$_emlmysql} AS __nm, COUNT(*) AS __tot

				    				FROM ".$__bd.TB_EC_OP."
				    					 INNER JOIN ".$__bd.TB_EC_SND." ON ecop_snd = id_ecsnd
									WHERE ecsnd_test = 2 $__fl
									GROUP BY {$_emlmysql}
									ORDER BY __tot DESC
									LIMIT 5 ";

			$__tp_ls = 'grp';

		}elseif($_p['t'] == 'brws'){

			if($_f_flg == 'ok'){ $__fl = " AND DATE_FORMAT( ecop_f, '%Y-%m' ) BETWEEN '".$__dt_1."' AND '".$__dt_2."'"; }

			$__qry = "SELECT *, ecop_brw_t AS __id, ecop_brw_t AS __nm, COUNT(*) AS __tot

				    				FROM ".$__bd.TB_EC_OP."
				    				INNER JOIN ".$__bd.TB_EC_SND." ON ecop_snd = id_ecsnd
									WHERE ecop_m != '"._CId('ID_SISDSP_DSKTP')."' AND ecsnd_test = 2 $__fl
									GROUP BY ecop_brw_t
									ORDER BY __tot DESC";

			$__tp_ls = 'grp';

		}elseif($_p['t'] == 'bnct'){

			if($_f_flg == 'ok'){ $__fl = " AND DATE_FORMAT( ecsnd_fi, '%Y-%m' ) BETWEEN '".$__dt_1."' AND '".$__dt_2."'"; }

			$__qry = "SELECT *, ecsnd_bnc_tp AS __id, sisslc_tt AS __nm, COUNT(*) AS __tot

				    				FROM ".$__bd.TB_EC_SND."
				    					INNER JOIN "._BdStr(DBM).TB_SIS_SLC." ON ecsnd_bnc_tp = id_sisslc
									WHERE ecsnd_bnc_tp IS NOT NULL AND ecsnd_test = 2 $__fl
									GROUP BY ecsnd_bnc_tp
									ORDER BY __tot DESC";

			$__tp_ls = 'grp';

		}elseif($_p['t'] == 'opnp'){

			$__qry = "SELECT *, ecop_ps AS __id, sisps_tt AS __nm, sisps_img AS __img, COUNT(*) AS __tot

				    				FROM ".$__bd.TB_EC_OP."
				    					INNER JOIN "._BdStr(DBM).TB_SIS_PS." ON ecop_ps = sisps_iso2
				    					INNER JOIN ".$__bd.TB_EC_SND." ON ecop_snd = id_ecsnd
									WHERE ecop_m != '"._CId('ID_SISDSP_DSKTP')."' AND ecsnd_test = 2

									GROUP BY ecop_ps
									ORDER BY __tot DESC";

			$__tp_ls = 'grp';
		}


		if(!isN($__qry)){

			$LsTp_Rg = $__cnx->_qry($__qry);

			if($LsTp_Rg){

				$row_LsTp_Rg = $LsTp_Rg->fetch_assoc();
				$Tot_LsTp_Rg = $LsTp_Rg->num_rows;
				$_r['tot'] = $Tot_LsTp_Rg;
				$_r['e'] = 'ok';
				$_r['qry'] = $__qry;

				if($Tot_LsTp_Rg > 0){

					do{
						try{
							$___datprcs[] = $row_LsTp_Rg;
						} catch (Exception $e) {
							echo $this->err($e->getMessage());
						}
					} while ($row_LsTp_Rg = $LsTp_Rg->fetch_assoc());

					$__cnx->_clsr($LsTp_Rg);

					foreach($___datprcs as $___datprcs_k=>$___datprcs_v){
						if($__tp_ls == 'grp'){
							$img = _ImVrs(['img'=>$___datprcs_v['__img'], 'f'=>DMN_FLE_PS ]);
							$_v[ $___datprcs_v['__id'] ] = ['id'=>$___datprcs_v['__id'], 'nm'=>ctjTx($___datprcs_v['__nm'],'in'), 'img'=>$img, 'tot'=>$___datprcs_v['__tot']];
						}else{
							$_v[ $___datprcs_v['__f'] ] = ['f'=>$___datprcs_v['__f'], 'tot'=>$___datprcs_v['__tot']];
						}
					}
					$_r['ls'] = $_v;

		    		do{
						if($__tp_ls == 'grp'){
							$img = _ImVrs(['img'=>$row_LsTp_Rg['__img'], 'f'=>DMN_FLE_PS ]);
							$_v[ $row_LsTp_Rg['__id'] ] = ['id'=>$row_LsTp_Rg['__id'], 'nm'=>ctjTx($row_LsTp_Rg['__nm'],'in'), 'img'=>$img, 'tot'=>$row_LsTp_Rg['__tot']];
						}else{
							$_v[ $row_LsTp_Rg['__f'] ] = ['f'=>$row_LsTp_Rg['__f'], 'tot'=>$row_LsTp_Rg['__tot']];
						}
					} while ($row_LsTp_Rg = $LsTp_Rg->fetch_assoc());
					$_r['ls'] = $_v;
				}

			}else{

				$_r['e'] = "no";

			}

		}else{
			$_r['e'] = "no";
		}

      	$__cnx->_clsr($LsTp_Rg);

	  	return _jEnc($_r);

	}



	function GtEcCmpgDlvr_T_Ls($_p=NULL){

		global $__cnx;

		if(!isN($_p['id'])){

			$__qry_f = sprintf(" ecsndcmpg_cmpg = %s ", GtSQLVlStr($_p['id'], 'int') );

   			if(!isN($_p['bd'])){ $__bd = _BdStr($_p['bd']); }

			if($_p['t'] == 'op'){

				if($_p['c'] == 'h'){ $__f_grp = " DATE_FORMAT(CONCAT(ecop_f,' ', ecop_h),'%Y-%m-%d-%H') "; }else{ $__f_grp = " DATE_FORMAT(ecop_f,'%Y-%m-%d') "; }

				$__qry = "SELECT $__f_grp AS __f, COUNT( DISTINCT ecop_snd ) AS __tot

					    				FROM ".$__bd.TB_EC_OP."
										WHERE ecop_snd IN (SELECT ecsndcmpg_snd FROM ".$__bd.TB_EC_SND_CMPG." WHERE {$__qry_f})

										GROUP BY $__f_grp ";
			}elseif($_p['t'] == 'clc'){

				if($_p['c'] == 'h'){ $__f_grp = " DATE_FORMAT(CONCAT(ectrck_f,' ', ectrck_h),'%Y-%m-%d-%H') "; }else{ $__f_grp = " DATE_FORMAT(ectrck_f,'%Y-%m-%d') "; }

				$__qry = "SELECT $__f_grp AS __f, COUNT( DISTINCT ectrck_snd ) AS __tot

					    				FROM ".$__bd.TB_EC_TRCK."
										WHERE ectrck_snd IN (SELECT ecsndcmpg_snd FROM ".$__bd.TB_EC_SND_CMPG." WHERE {$__qry_f})

										GROUP BY $__f_grp ";
			}elseif($_p['t'] == 'rmv'){

				if($_p['c'] == 'h'){ $__f_grp = " DATE_FORMAT(cntemlrmv_fi,'%Y-%m-%d-%H') "; }else{ $__f_grp = " DATE_FORMAT(cntemlrmv_fi,'%Y-%m-%d') "; }

				$__qry = "SELECT $__f_grp AS __f, COUNT( DISTINCT cntemlrmv_snd ) AS __tot

					    				FROM ".$__bd.TB_CNT_EML_RMV."
										WHERE cntemlrmv_snd IN (SELECT ecsndcmpg_snd FROM ".$__bd.TB_EC_SND_CMPG." WHERE {$__qry_f})

										GROUP BY $__f_grp ";
			}elseif($_p['t'] == 'dsp'){

				$__qry = "SELECT *, ecop_m AS __id, sisslc_tt AS __nm, COUNT(*) AS __tot

					    				FROM ".$__bd.TB_EC_OP."
					    					 INNER JOIN "._BdStr(DBM).TB_SIS_SLC." ON ecop_m = id_sisslc
										WHERE ecop_snd IN (SELECT ecsndcmpg_snd FROM ".$__bd.TB_EC_SND_CMPG." WHERE {$__qry_f})

										GROUP BY ecop_m
										ORDER BY __tot DESC";

				$__tp_ls = 'grp';

			}elseif($_p['t'] == 'os'){

				$__qry = "SELECT *, ecop_brw_p AS __id, ecop_brw_p AS __nm, COUNT(*) AS __tot

					    				FROM ".$__bd.TB_EC_OP."
										WHERE ecop_m != '"._CId('ID_SISDSP_DSKTP')."' AND ecop_snd IN (SELECT ecsndcmpg_snd FROM ".$__bd.TB_EC_SND_CMPG." WHERE {$__qry_f})

										GROUP BY ecop_brw_p
										ORDER BY __tot DESC";

				$__tp_ls = 'grp';

			}elseif($_p['t'] == 'clnt'){

				$_emlmysql = " SUBSTRING_INDEX(SUBSTRING_INDEX(ecsnd_eml, '@', -1), '.', 1) ";

				$__qry = "SELECT *, {$_emlmysql} AS __id, {$_emlmysql} AS __nm, COUNT(*) AS __tot

					    				FROM ".$__bd.TB_EC_OP."
					    					 INNER JOIN ".$__bd.TB_EC_SND." ON ecop_snd = id_ecsnd
										WHERE ecop_snd IN (SELECT ecsndcmpg_snd FROM ".$__bd.TB_EC_SND_CMPG." WHERE {$__qry_f})

										GROUP BY {$_emlmysql}
										ORDER BY __tot DESC
										LIMIT 5 ";

				$__tp_ls = 'grp';

			}elseif($_p['t'] == 'brws'){

				$__qry = "SELECT *, ecop_brw_t AS __id, ecop_brw_t AS __nm, COUNT(*) AS __tot

					    				FROM ".$__bd.TB_EC_OP."
										WHERE ecop_m != '"._CId('ID_SISDSP_DSKTP')."' AND ecop_snd IN (SELECT ecsndcmpg_snd FROM ".$__bd.TB_EC_SND_CMPG." WHERE {$__qry_f})

										GROUP BY ecop_brw_t
										ORDER BY __tot DESC";

				$__tp_ls = 'grp';

			}elseif($_p['t'] == 'bnct'){

				$__qry = "SELECT *, ecsnd_bnc_tp AS __id, sisslc_tt AS __nm, COUNT(*) AS __tot

					    				FROM ".$__bd.TB_EC_SND."
					    					 INNER JOIN "._BdStr(DBM).TB_SIS_SLC." ON ecsnd_bnc_tp = id_sisslc
										WHERE ecsnd_bnc_tp IS NOT NULL AND id_ecsnd IN (SELECT ecsndcmpg_snd FROM ".$__bd.TB_EC_SND_CMPG." WHERE {$__qry_f})

										GROUP BY ecsnd_bnc_tp
										ORDER BY __tot DESC";

				$__tp_ls = 'grp';

			}elseif($_p['t'] == 'opnp'){

				$__qry = "SELECT *, ecop_ps AS __id, sisps_tt AS __nm, sisps_img AS __img, COUNT(*) AS __tot

					    				FROM ".$__bd.TB_EC_OP."
					    					 INNER JOIN "._BdStr(DBM).TB_SIS_PS." ON ecop_ps = sisps_iso2
										WHERE ecop_m != '"._CId('ID_SISDSP_DSKTP')."' AND ecop_snd IN (SELECT ecsndcmpg_snd FROM ".$__bd.TB_EC_SND_CMPG." WHERE {$__qry_f})

										GROUP BY ecop_ps
										ORDER BY __tot DESC";

				$__tp_ls = 'grp';
			}


			if(!isN($__qry)){

				$LsTp_Rg = $__cnx->_qry($__qry,['cmps'=>'ok']);

				if($LsTp_Rg){

					$row_LsTp_Rg = $LsTp_Rg->fetch_assoc();
					$Tot_LsTp_Rg = $LsTp_Rg->num_rows;
					$_r['tot'] = $Tot_LsTp_Rg;

				}else{

					//echo 'GtEcCmpgDlvr_T_Ls '.$_p['t'].':'.$__cnx->c_r->error;

				}

			}

		    if($Tot_LsTp_Rg > 0){

                do{

	                if($__tp_ls == 'grp'){

		                $img = _ImVrs(['img'=>$row_LsTp_Rg['__img'], 'f'=>DMN_FLE_PS ]);
						$_v[ $row_LsTp_Rg['__id'] ] = ['id'=>$row_LsTp_Rg['__id'], 'nm'=>ctjTx($row_LsTp_Rg['__nm'],'in'), 'img'=>$img, 'tot'=>$row_LsTp_Rg['__tot']];

					}else{
						$_v[ $row_LsTp_Rg['__f'] ] = ['f'=>$row_LsTp_Rg['__f'], 'tot'=>$row_LsTp_Rg['__tot']];

					}

				} while ($row_LsTp_Rg = $LsTp_Rg->fetch_assoc());
			}

          	$_r['ls'] = $_v;

          		$__cnx->_clsr($LsTp_Rg);

		}

	    return _jEnc($_r);
	}

	function GtEcCmpgDlvrLs($_p=NULL){

		if(!isN($_p['id'])){

   			//-------------- INFORMACION SEMANA --------------//

   				if(!isN($_p['bd'])){ $__bd = _BdStr($_p['bd']); }

   				$_w_op = GtEcCmpgDlvr_T_Ls(['id'=>$_p['id'], 't'=>'op', 'bd'=>$__bd ]);
   				$_w_clc = GtEcCmpgDlvr_T_Ls(['id'=>$_p['id'], 't'=>'clc', 'bd'=>$__bd ]);
   				$_w_rmv = GtEcCmpgDlvr_T_Ls(['id'=>$_p['id'], 't'=>'rmv', 'bd'=>$__bd ]);

				$__fw1 = $_p['s_f'];
				$__fw2 = date('Y-m-d', strtotime($__fw1. ' +7 day'));

				for($i=$__fw1;$i<=$__fw2;$i = date("Y-m-d", strtotime($i ."+ 1 days"))){

					$_r['week']['opn']['grp'][$i] = _Nmb(($_w_op->ls->$i->tot!=NULL)?$_w_op->ls->$i->tot:'0', 6);
					$_r['week']['clc']['grp'][$i] = _Nmb(($_w_clc->ls->$i->tot!=NULL)?$_w_clc->ls->$i->tot:'0', 6);
					$_r['week']['rmv']['grp'][$i] = _Nmb(($_w_rmv->ls->$i->tot!=NULL)?$_w_rmv->ls->$i->tot:'0', 6);


					$_r['week']['opn']['d'][$i] = ['f'=>$i, 'tot'=>$_w_op->ls->$i->tot];
					$_r['week']['clc']['d'][$i] = ['f'=>$i, 'tot'=>$_w_clc->ls->$i->tot];
					$_r['week']['rmv']['d'][$i] = ['f'=>$i, 'tot'=>$_w_rmv->ls->$i->tot];


					$_r['week']['dates'][] = $i; // Construye listado de fechas como Array
					$_r['week']['grp']['c'][] = "'".$i."'"; //  Construye listado de fechas para Graficas

				}

			//-------------- INFORMACION DIA --------------//


				$_h_op = GtEcCmpgDlvr_T_Ls(['id'=>$_p['id'], 't'=>'op', 'c'=>'h', 'bd'=>$__bd ]);
				$_h_clc = GtEcCmpgDlvr_T_Ls(['id'=>$_p['id'], 't'=>'clc', 'c'=>'h', 'bd'=>$__bd ]);
				$_h_rmv = GtEcCmpgDlvr_T_Ls(['id'=>$_p['id'], 't'=>'rmv', 'c'=>'h', 'bd'=>$__bd ]);


				$__fh1 = $_p['s_f'].' '.$_p['s_h'];
				$__fh2 = date('Y-m-d H:i:s', strtotime($__fh1. ' +24 hour'));


				for($i=$__fh1;$i<=$__fh2;$i = date("Y-m-d H:i:s", strtotime($i ."+ 1 hour"))){

					$_inw = date('Y-m-d-H', strtotime($i));

					$_r['day']['opn']['grp'][$_inw] = _Nmb(($_h_op->ls->$_inw->tot!=NULL)?$_h_op->ls->$_inw->tot:'0', 6);
					$_r['day']['clc']['grp'][$_inw] = _Nmb(($_h_clc->ls->$_inw->tot!=NULL)?$_h_clc->ls->$_inw->tot:'0', 6);
					$_r['day']['rmv']['grp'][$_inw] = _Nmb(($_h_rmv->ls->$_inw->tot!=NULL)?$_h_rmv->ls->$_inw->tot:'0', 6);


					$_r['day']['opn']['d'][$_inw] = ['f'=>$_inw, 'tot'=>$_h_op->ls->$_inw->tot];
					$_r['day']['clc']['d'][$_inw] = ['f'=>$_inw, 'tot'=>$_h_clc->ls->$_inw->tot];
					$_r['day']['rmv']['d'][$_inw] = ['f'=>$_inw, 'tot'=>$_h_rmv->ls->$_inw->tot];


					$_r['day']['hours'][] = $_inw; // Construye listado de fechas como Array
					$_r['day']['grp']['c'][] = "'".$_inw."'"; //  Construye listado de fechas para Graficas

				}

			//-------------- INFORMACION DIA --------------//



			$_r['dsp']['grp'] = GtEcCmpgDlvr_T_Ls(['id'=>$_p['id'], 't'=>'dsp' , 'bd'=>$__bd ]);
			$_r['os']['grp'] = GtEcCmpgDlvr_T_Ls(['id'=>$_p['id'], 't'=>'os', 'bd'=>$__bd ]);
			$_r['clnt']['grp'] = GtEcCmpgDlvr_T_Ls(['id'=>$_p['id'], 't'=>'clnt', 'bd'=>$__bd ]);
			$_r['brws']['grp'] = GtEcCmpgDlvr_T_Ls(['id'=>$_p['id'], 't'=>'brws', 'bd'=>$__bd ]);
			$_r['bnct']['grp'] = GtEcCmpgDlvr_T_Ls(['id'=>$_p['id'], 't'=>'bnct', 'bd'=>$__bd ]);
			$_r['opnp']['grp'] = GtEcCmpgDlvr_T_Ls(['id'=>$_p['id'], 't'=>'opnp', 'bd'=>$__bd ]);


		}

	    return _jEnc($_r);
	}

	function GtDshEcCmpg($_p=NULL){

        global $__cnx;

		$Vl['e'] = 'no';

        if(!isN($_p['fi']) && !isN($_p['ff'])){
            $__dt_1 = date("Y-m", strtotime($_p['fi']));
			$__dt_2 = date("Y-m", strtotime($_p['ff']));
        }else{
            $__dt_1 = date('Y-01');
			$__dt_2 = date('Y-m');
        }

        $query_DtRg = " SELECT  DATE_FORMAT( eccmpg_fi, '%Y-%m' ) as f_i,
                                COUNT(DISTINCT id_eccmpg) as tot
                        FROM    "._BdStr(DBM).TB_EC_CMPG."
                        WHERE   eccmpg_cl = ".DB_CL_ID." AND
								DATE_FORMAT( eccmpg_fi, '%Y-%m' ) BETWEEN '".$__dt_1."' AND '".$__dt_2."'
                                {$_fl}
                        GROUP BY
                            DATE_FORMAT( eccmpg_fi, '%Y-%m' )";

		$DtRg = $__cnx->_qry($query_DtRg);

		$Vl['casd'] = $Vl_Grph;

        if($DtRg){

            $Vl['e'] = 'ok';

            $row_DtRg = $DtRg->fetch_assoc();
            $Tot_DtRg = $DtRg->num_rows;

                do{

                    $_r['ctg'][$row_DtRg['f_i']] = $row_DtRg['f_i'];
                    $_r['d'][$row_DtRg['f_i']]['tot'] = $row_DtRg['tot'];

                }while($row_DtRg = $DtRg->fetch_assoc());

				$Vl_Grph = _jEnc($_r);

                for($i=$__dt_1;$i<=$__dt_2;$i = date('Y-m', strtotime($i .'+ 1 month'))){

                    $__ctg[] = $i;
					$_d[] = ( !isN($Vl_Grph->d->{$i}->tot) ) ? (int)$Vl_Grph->d->{$i}->tot : 0 ;

                }
				$Vl['casd'] = $Vl_Grph;
                $Vl['c'] = $__ctg;
                $Vl['o'] = $_d;

        }else{

            $Vl['w'] = $__cnx->c_r->error;

        }

        $__cnx->_clsr($DtRg);

        return(_jEnc($Vl));

    }

    function GtDshEcSnd($_p=NULL){

        global $__cnx;

        $Vl['e'] = 'no';

        if(!isN($_p['fi']) && !isN($_p['ff'])){
            $__dt_1 = date("Y-m", strtotime($_p['fi']));
			$__dt_2 = date("Y-m", strtotime($_p['ff']));
        }else{
            $__dt_1 = date('Y-01');
			$__dt_2 = date('Y-m');
        }

        $query_DtRg = " SELECT
                            DATE_FORMAT( ecsnd_fi, '%Y-%m' ) AS f_i,
                            COUNT( DISTINCT id_ecsnd ) AS tot
                        FROM
                            ec_snd
                            INNER JOIN cnt ON ecsnd_cnt = id_cnt
                        WHERE
							DATE_FORMAT( ecsnd_fi, '%Y-%m' ) BETWEEN '".$__dt_1."' AND '".$__dt_2."'
                        GROUP BY
                            DATE_FORMAT( ecsnd_fi, '%Y-%m' )";

        $DtRg = $__cnx->_qry($query_DtRg);

        if($DtRg){

            $Vl['e'] = 'ok';

            $row_DtRg = $DtRg->fetch_assoc();
            $Tot_DtRg = $DtRg->num_rows;

                do{

                    $_r['ctg'][$row_DtRg['f_i']] = $row_DtRg['f_i'];
                    $_r['d'][$row_DtRg['f_i']]['tot'] = $row_DtRg['tot'];

                }while($row_DtRg = $DtRg->fetch_assoc());

				$Vl_Grph = _jEnc($_r);

                for($i=$__dt_1;$i<=$__dt_2;$i = date('Y-m', strtotime($i .'+ 1 month'))){

                    $__ctg[] = $i;
                    $_d[] = ( !isN($Vl_Grph->d->{$i}->tot) ) ? (int)$Vl_Grph->d->{$i}->tot : 0 ;



                }

                $Vl['c'] = $__ctg;
                $Vl['o'] = $_d;

        }else{

            $Vl['w'] = $__cnx->c_r->error;

        }

        $__cnx->_clsr($DtRg);

        return(_jEnc($Vl));

    }

	function GtEcEmlLs($_p=NULL){

		global $__cnx;

		$Vl['e'] = 'no';

		if(!isN($_p['lsts'])){

			if(!isN($_p['bd'])){ $_bd = _BdStr($_p['bd']); }else{ $_bd = ''; }

			if($_p['t'] == 'enc'){ $__f = 'eclstseml_enc'; $__ft = 'text'; }else{ $__f = 'id_eclstseml'; $__ft = 'int'; }


			if(!isN($_p['cmpg_nol'])){

				$__f_flt .= sprintf(' AND ( cnteml_eml NOT IN (	SELECT ecsnd_eml
																FROM '.$_bd.TB_EC_SND_CMPG.' _s1
																	 INNER JOIN '.$_bd.TB_EC_SND.' _s2 ON _s1.ecsndcmpg_snd = _s2.id_ecsnd
																WHERE _s1.ecsndcmpg_cmpg=%s AND
																	  _s2.ecsnd_test = 2
										  )
								  ) ', GtSQLVlStr($_p['cmpg_nol'], 'int'));
			}


			if(!isN($_p['mlchmp']) && $_p['mlchmp'] == 'no'){
				$__f_flt .= sprintf('AND ( eclstseml_mlchmp_id IS NULL || eclstseml_mlchmp_id != "" )');
			}


			if(!isN($_p['sgm']) && !isN($_p['sgm']['id'])){

				$__fl_innr = "
								INNER JOIN ".$_bd.TB_EC_LSTS_EML_SGM." ON eclstsemlsgm_eml = id_cnteml

								/*
								INNER JOIN ".$_bd.TB_MDL_CNT." ON mdlcnt_cnt = id_cnt
								INNER JOIN ".$_bd.TB_MDL." ON id_mdl = mdlcnt_mdl
								INNER JOIN "._BdStr(DBM).TB_MDL_S." ON id_mdls = mdl_mdls
								INNER JOIN ".$_bd.TB_MDL_ARE." ON mdlare_mdl = mdlcnt_mdl
								*/

								LEFT JOIN ".$_bd.TB_CNT_CD." ON cntcd_cnt = id_cnt
								LEFT JOIN ".$_bd.TB_CNT_ATTR." ON cntattr_cnt = id_cnt
							";

				$__f_sgm = sprintf(' AND eclstsemlsgm_lstssgm=%s ', GtSQLVlStr($_p['sgm']['id'], 'int'));

			}



			if(!isN($_p['sgm']['no'])){

				$__fnols = implode(',', $_p['sgm']['no']);

				$__f_flt .= sprintf(' AND ( id_cnteml NOT IN (	SELECT eclstsemlsgm_eml
																FROM '._BdStr($_bd).TB_EC_LSTS_EML_SGM.'
																WHERE eclstsemlsgm_lstssgm IN (%s)
										  )
								  ) ', $__fnols );

			}


			if(!isN($_p['lsts']['id'])){
				$__f_flt .= sprintf(' AND eclstseml_lsts=%s ', GtSQLVlStr($_p['lsts']['id'], $__ft));
			}

			if(!isN($_p['lmt'])){ $__f_lmt .= $_p['lmt']; }else{ $__f_lmt .= '200'; /*1000 before*/ }


			if( $_p['q_tot'] == 'ok'){
				$__sl_qry = ' COUNT( DISTINCT id_cnteml ) AS ___tot ';
				$__grpby_qry = '';
			}else{
				$__sl_qry = ' id_eclstseml, eclstseml_eml, id_cnteml, cntemlplcy_cnteml, id_cnteml, cnteml_enc, cnteml_eml, cnteml_cnt, id_cnt, cnt_nm, cnt_ap, cnt_test, cntplcy_cnt, cntemlplcy_plcy, id_clplcy, eclstsplcy_eclsts, eclstseml_lsts, clplcy_e, cntplcy_plcy, cntplcy_sndi, cntemlplcy_sndi, cnteml_rjct, cnteml_est ';
				$__grpby_qry = ' GROUP BY id_cnteml ';
			}

			if($_p['ord'] == 'rndm'){ $_orderby = ' RAND()'; }else{ $_orderby = ' id_eclstseml ASC'; }


			$____plcy = GtEcLstsPlcyLs([ 'eclsts'=>$_p['lsts']['id'], 'cl'=>$_p['cl'], 'e'=>'on' ]);


			$query_LsEml = sprintf("	SELECT $__sl_qry
								   		FROM ".$_bd.TB_EC_LSTS_EML."
								   			INNER JOIN ".$_bd.TB_CNT_EML." ON eclstseml_eml = id_cnteml
								   			INNER JOIN ".$_bd.TB_CNT_EML_PLCY." ON cntemlplcy_cnteml = id_cnteml
								   			INNER JOIN ".$_bd.TB_CNT." ON cnteml_cnt = id_cnt
								   			INNER JOIN ".$_bd.TB_CNT_PLCY." ON cntplcy_cnt = id_cnt
								   			INNER JOIN "._BdStr(DBM).TB_CL_PLCY." ON cntemlplcy_plcy = id_clplcy
								   			INNER JOIN "._BdStr(DBM).TB_EC_LSTS_PLCY." ON eclstsplcy_eclsts = eclstseml_lsts
								   			{$__fl_innr}

								   		WHERE clplcy_e = 1 AND
								   			  cntplcy_sndi = 1 AND
								   			  cntemlplcy_sndi = 1 AND
								   			  cnteml_rjct=2 AND
								   			  cnteml_est="._CId('ID_SISEMLEST_ACT')." {$__f_sgm} {$__f_flt}


								   		{$__grpby_qry}
								   		ORDER BY {$_orderby}
								   		LIMIT {$__f_lmt}");


			$query_LsEml_Go = str_replace('[pcnt]', '%', $query_LsEml);

			$LsEml = $__cnx->_qry($query_LsEml_Go, ['cmps'=>'ok']);

			if($LsEml){

				$row_LsEml = $LsEml->fetch_assoc();
				$Tot_LsEml = $LsEml->num_rows;

				if( $_p['q_tot'] == 'ok'){

					$Vl['tot'] = $row_LsEml['___tot'];

				}else{

					$Vl['fm'] = 'ls';
					$Vl['plcy'] = $____plcy;
					$Vl['tot'] = $Tot_LsEml;

					if($Tot_LsEml > 0){

						$Vl['e'] = 'ok';
						$tmpi = 1;

						do{

							if($____plcy->tot > 0){

								$__cnt_sndi = 'no';
								$__cnt_eml_sndi = 'no';


								foreach($____plcy->ls as $____plcy_k=>$____plcy_v){
									if($row_LsEml['cntplcy_plcy'] == $____plcy_v->id && $row_LsEml['cntplcy_sndi'] == 'ok'){ $__cnt_sndi = 'ok'; }
									if($row_LsEml['cntemlplcy_plcy'] == $____plcy_v->id && $row_LsEml['cntemlplcy_sndi'] == 'ok'){ $__cnt_eml_sndi = 'ok'; }
								}


								$_id_eml = $row_LsEml['id_eclstseml'];

								$Vl['ls'][$_id_eml]['id'] = $_id_eml;
								$Vl['ls'][$_id_eml]['enc'] = $row_LsEml['cnteml_enc'];
								$Vl['ls'][$_id_eml]['eml'] = ctjTx($row_LsEml['cnteml_eml'],'in');
								$Vl['ls'][$_id_eml]['sndi'] = $__cnt_eml_sndi;
								$Vl['ls'][$_id_eml]['eml_id'] = $row_LsEml['id_cnteml'];
								$Vl['ls'][$_id_eml]['cnt'] = $row_LsEml['id_cnt'];
								$Vl['ls'][$_id_eml]['test'] = mBln($row_LsEml['cnt_test']);

								/*
								$Vl['ls'][$_id_eml]['nm'] = ctjTx($row_LsEml['cnt_nm'],'in');
								$Vl['ls'][$_id_eml]['ap'] = ctjTx($row_LsEml['cnt_ap'],'in');

								*/


							}

							$tmpi++;

						} while ($row_LsEml = $LsEml->fetch_assoc());

					}

				}

			}else{

				$Vl['w'] = $__cnx->c_r->error.' on '.$query_LsEml_Go;

			}

			$__cnx->_clsr($LsEml);

		}

		return(_jEnc($Vl));

	}





	function GtEcEmlTot_Count($_p=NULL){

		global $__cnx;

		$Vl['e'] = 'no';

		if(!isN($_p['lsts'])){

			if(!isN($_p['bd'])){ $_bd = _BdStr($_p['bd']); }else{ $_bd = ''; }

			if($_p['t'] == 'enc'){ $__f = 'eclstseml_enc'; $__ft = 'text'; }else{ $__f = 'id_eclstseml'; $__ft = 'int'; }

			$____plcy = GtEcLstsPlcyLs([ 'eclsts'=>$_p['lsts']['id'], 'cl'=>$_p['cl'], 'e'=>'on' ]);

			if($____plcy->tot > 0){
				foreach($____plcy->ls as $____plcy_k=>$____plcy_v){
					$__plcy[] = $____plcy_v->id;
				}
				$__plcy_q = implode(',', $__plcy);
			}

			if(!isN($_p['cmpg_nol'])){

				$__f_flt .= sprintf(' AND ( id_cnteml NOT IN (	SELECT id_cnteml
																FROM '.$_bd.TB_EC_SND_CMPG.' _s1
																	 INNER JOIN '.$_bd.TB_EC_SND.' _s2 ON _s1.ecsndcmpg_snd = _s2.id_ecsnd
																	 INNER JOIN '.$_bd.TB_CNT_EML.' _s3 ON _s2.ecsnd_eml) = _s3.cnteml_eml
																WHERE _s1.ecsndcmpg_cmpg = %s AND
																	  _s2.ecsnd_test = 2
										  )
								  ) ', GtSQLVlStr($_p['cmpg_nol'], 'int'));
			}


			if(!isN($_p['sgm']['no'])){

				$__fnols = implode(',', $_p['sgm']['no']);

				$__f_flt .= sprintf(' AND ( id_cnteml NOT IN (	SELECT eclstsemlsgm_eml
																FROM '._BdStr($_bd).TB_EC_LSTS_EML_SGM.'
																WHERE eclstsemlsgm_lstssgm IN (%s)
										  )
								  ) ', $__fnols );

			}


			if($_p['nallw'] == 'ok'){

				$__f_flt .= ' AND  ( id_cnt IN (
													SELECT cntplcy_cnt
													FROM '.$_bd.TB_CNT_PLCY.'
													WHERE cntplcy_sndi=2 AND cntplcy_plcy IN ('.$__plcy_q.')
												)

												|| cnteml_rjct=1

											) ';

			}else{

				if(!isN($_p['sndi'])){

					$__f_flt .= ' AND EXISTS (
										SELECT cntplcy_cnt
										FROM '.$_bd.TB_CNT_PLCY.'
											 INNER JOIN '._BdStr(DBM).TB_CL_PLCY.' ON cntplcy_plcy = id_clplcy
										WHERE 	cntplcy_cnt = id_cnt AND
												clplcy_e = 1 AND
												cntplcy_sndi='.$_p['sndi'].' AND
												cntplcy_plcy IN ('.$__plcy_q.')
									)
								  AND EXISTS (
										SELECT cntemlplcy_cnteml
										FROM '.$_bd.TB_CNT_EML_PLCY.'
											 INNER JOIN '._BdStr(DBM).TB_CL_PLCY.' ON cntemlplcy_plcy = id_clplcy
										WHERE 	cntemlplcy_cnteml = id_cnteml AND
												clplcy_e = 1 AND
												cntemlplcy_sndi='.$_p['sndi'].' AND
												cntemlplcy_plcy IN ('.$__plcy_q.')
									)	 ';

				}

				if(!isN($_p['rjct'])){

					$__f_flt .= ' AND cnteml_rjct='.$_p['rjct'].' ';

				}

			}

			if(!isN($_p['est'])){ $__f_flt .= ' AND cnteml_est='.$_p['est'].' '; }


			if(!isN($_p['sgm']) && !isN($_p['sgm']['id'])){

				$__fl_innr = "
								INNER JOIN ".$_bd.TB_EC_LSTS_EML_SGM." ON eclstsemlsgm_eml = id_cnteml

								/*
								INNER JOIN ".$_bd.TB_MDL_CNT." ON mdlcnt_cnt = id_cnt
								INNER JOIN ".$_bd.TB_MDL." ON id_mdl = mdlcnt_mdl
								INNER JOIN "._BdStr(DBM).TB_MDL_S." ON id_mdls = mdl_mdls
								INNER JOIN ".$_bd.TB_MDL_ARE." ON mdlare_mdl = mdlcnt_mdl
								*/

								LEFT JOIN ".$_bd.TB_CNT_CD." ON cntcd_cnt = id_cnt
								LEFT JOIN ".$_bd.TB_CNT_ATTR." ON cntattr_cnt = id_cnt
							";

				$__f_sgm = sprintf(' AND eclstsemlsgm_lstssgm=%s ', GtSQLVlStr($_p['sgm']['id'], 'int'));

			}

			$query_LsEml = sprintf("
										SELECT COUNT(DISTINCT id_cnteml) AS ___tot
								   		FROM ".$_bd.TB_EC_LSTS_EML."
								   			 INNER JOIN ".$_bd.TB_CNT_EML." ON eclstseml_eml = id_cnteml
								   			 INNER JOIN ".$_bd.TB_CNT." ON cnteml_cnt = id_cnt
								   			 {$__fl_innr}
								   		WHERE eclstseml_lsts = %s {$__f_sgm} {$__f_flt}
								   		ORDER BY id_eclstseml ASC
								   		LIMIT 1", GtSQLVlStr($_p['lsts']['id'], $__ft));


			$query_LsEml_Go = str_replace('[pcnt]', '%', $query_LsEml);

			$LsEml = $__cnx->_qry($query_LsEml_Go, ['cmps'=>'ok']);

			$Vl['qry'] = $query_LsEml_Go;

			//echo $query_LsEml_Go.HTML_BR.HTML_BR;

			if($LsEml){

				$row_LsEml = $LsEml->fetch_assoc();
				$Tot_LsEml = $LsEml->num_rows;

				//$Vl['tot'] = $Tot_LsEml;

				if($Tot_LsEml > 0){
					$Vl['e'] = 'ok';
					$Vl['tot'] = $row_LsEml['___tot'];
				}

			}else{

				$Vl['w'] = $__cnx->c_r->error;

				//echo $__cnx->c_r->error.HTML_BR.HTML_BR;

			}

			$__cnx->_clsr($LsEml);

		}

		return(_jEnc($Vl));

	}



	function GtEcEmlTot($_p=NULL){

		$_a = ['sndi'=>1, 'rjct'=>2, 'est'=>_CId('ID_SISEMLEST_ACT')];

		$_tot_allw = GtEcEmlTot_Count(array_merge($_p, $_a));
		$Vl['tot']['allw'] = $_tot_allw->tot;
		$Vl['qry']['allw'] = $_tot_allw->qry;

		$_na = ['nallw'=>'ok'];
		$Vl['tot']['noallw']['all'] = GtEcEmlTot_Count(array_merge($_p, $_na))->tot;

		$_r = ['rjct'=>1];
		$Vl['tot']['noallw']['rjct'] = GtEcEmlTot_Count(array_merge($_p, $_r))->tot;

		$_s = ['sndi'=>2];
		$Vl['tot']['noallw']['sndi'] = GtEcEmlTot_Count(array_merge($_p, $_s))->tot;

		return _jEnc($Vl);

	}



	function GtSisTagCnctLs($p=NULL){

		$_tags = __LsDt([ 'k'=>'sis_tag_cnct' ]);


		//--------------- Basic Tags ---------------//

			foreach($_tags->ls->sis_tag_cnct as $_ls_k=>$_ls_v){
				$_o[] = $_ls_v->tag->vl;
			}

		//--------------- Module Tags ---------------//

			$__mdl_attr_sis = __LsDt([ 'k'=>'mdls_tp_attr' ]);

			foreach($__mdl_attr_sis->ls->mdls_tp_attr as $_sis_k=>$_sis_v){
				if(!isN($_sis_v->cnct->vl)){
					$_o[] = '[MODULO_'.strtoupper($_sis_v->cnct->vl).']';
				}
			}

		//--------------- Oportunity Tags ---------------//

			$__mdlcnt_attr= __LsDt([ 'k'=>'mdl_cnt_attr' ]);

			foreach($__mdlcnt_attr->ls->mdl_cnt_attr as $_sis_k=>$_sis_v){
				if(!isN($_sis_v->cnct->vl)){
					$_o[] = '[OPORTUNIDAD_'.strtoupper($_sis_v->cnct->vl).']';
				}
			}

		//--------------- Lead Tags ---------------//

			$__mdl_attr_cnt = __LsDt([ 'k'=>'cnt_attr' ]);

			foreach($__mdl_attr_cnt->ls->cnt_attr as $_sis_k=>$_sis_v){
				if(!isN($_sis_v->cnct->vl)){
					$_o[] = '[LEAD_'.strtoupper($_sis_v->cnct->vl).']';
				}
			}

		//--------------- Aplicacion Tags ---------------//

			$__appl_attr_cnt = __LsDt([ 'k'=>'appl_attr' ]);

			foreach($__appl_attr_cnt->ls->appl_attr as $_sis_k=>$_sis_v){
				if(!isN($_sis_v->cnct->vl)){
					$_o[] = '[APLICACION_'.strtoupper($_sis_v->cnct->vl).']';
				}
			}

		//--------------- Build Html ---------------//

			$_o = array_unique($_o);

			foreach($_o as $_o_k=>$_o_v){
				$_r_li .= li( $_o_v );
			}

		//--------------- Return ---------------//


      	if($_r_li != ''){ $_r['html'] = ul($_r_li, '_anm ls_ec_tag', '', $p['id']); }

	    return _jEnc($_r);

	}







	function GtEcEtpDt($p=NULL){

		global $__cnx;

		if(($p['id']!='')){
			$query_DtRg = sprintf('SELECT *
								   FROM '._BdStr(DBM).TB_CL_ETP.'
								   WHERE id_cletp = %s LIMIT 1', GtSQLVlStr($p['id'],'int'));
			$DtRg = $__cnx->_qry($query_DtRg);
			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;

			if($Tot_DtRg > 0){

				$Vl['id'] = $row_DtRg['id_cletp'];
				$Vl['tt'] = ctjTx($row_DtRg['cletp_nm'],'in');

			}

			$__cnx->_clsr($DtRg);

		return(_jEnc($Vl));
		}
	}


	/*Ec Lsts Auto*/
	function GtEcLstsAuto($_id){

		global $__cnx;

		if(!isN($_id)){
			$Ls_Qry_auto = "SELECT * FROM ec_lsts_auto WHERE eclstsauto_eclsts = {$_id}";
			$Ls_Rg_auto = $__cnx->_qry($Ls_Qry_auto); $row_Ls_Rg_auto = $Ls_Rg_auto->fetch_assoc(); $Tot_Ls_Rg_auto = $Ls_Rg_auto->num_rows;

			$i = 0;
			do{

				$_r[$i]['id'] = $row_Ls_Rg_auto['id_eclstsauto'];
				$_r[$i]['cpo'] = $row_Ls_Rg_auto['eclstsauto_cpo'];
				$_r[$i]['chk'] = $row_Ls_Rg_auto['eclstsauto_chk'];
				$_r[$i]['cnd'] = $row_Ls_Rg_auto['eclstsauto_cnd'];

				$i ++;

			}while($row_Ls_Rg_auto = $Ls_Rg_auto->fetch_assoc());

			$__cnx->_clsr($Ls_Rg_auto);

			$__r = _jEnc($_r);
			return $__r;
		}
	}



	function GtEcActDt($_p=NULL){

		global $__cnx;

		if(is_array($_p)){
			if(isN($_p['id'])){

				$query_DtRg = sprintf("SELECT * FROM ".TB_SIS_EC_ACT." WHERE id_ecact = %s", GtSQLVlStr($_p['id'], 'int'));

				$DtRg = $__cnx->_qry($query_DtRg);
				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;



				if($Tot_DtRg > 0){
					$Vl['e'] = 'ok';
					$Vl['id'] = $row_DtRg['id_ecact'];

					if($row_DtRg['ecact_ls'] != ''){
						$_ls_j = json_decode($row_DtRg['ecact_ls']);
						$Vl['ls']['l'] = $_ls_j->l;
						$Vl['ls']['v'] = $_ls_j->v;
					}

				}else{
					$Vl['e'] = 'no';
				}

				$__cnx->_clsr($DtRg);

				return _jEnc($Vl);
			}
		}
	}


	function GtEcCndcDt($_p=NULL){

		global $__cnx;

		if(is_array($_p)){
			if(!isN($_p['id'])){

				$query_DtRg = sprintf("SELECT * FROM ".TB_SIS_EC_CNDC." WHERE id_eccndc = %s", GtSQLVlStr($_p['id'], 'int'));

				$DtRg = $__cnx->_qry($query_DtRg);
				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg > 0){
					$Vl['e'] = 'ok';
					$Vl['id'] = $row_DtRg['id_eccndc'];

					if($row_DtRg['eccndc_ls'] != ''){
						$_ls_j = json_decode($row_DtRg['eccndc_ls']);
						$Vl['ls']['l'] = $_ls_j->l;
						$Vl['ls']['v'] = $_ls_j->v;
					}

				}else{
					$Vl['e'] = 'no';
				}

				$__cnx->_clsr($DtRg);

				return _jEnc($Vl);
			}
		}
	}






	/* ec_cmz */

	function GtEcCmzSgmDt($_p=NULL){

		global $__cnx;

		if(!isN($_p['cmz'])){

			$query_DtRg = sprintf('	SELECT eccmzsgm_sgm, eccmzsgm_eccmz, eccmzsgm_vle, eccmzsgm_hb
									FROM '._BdStr(DBM).TB_EC_CMZ_SGM.'
									WHERE eccmzsgm_eccmz = %s', GtSQLVlStr($_p['cmz'], 'int'));
			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				do{
					$_key_id = $row_DtRg['eccmzsgm_sgm'];

					$Vl[$_key_id]['cmz'] = $row_DtRg['eccmzsgm_eccmz'];
					$Vl[$_key_id]['sgm'] = $row_DtRg['eccmzsgm_sgm'];
					$Vl[$_key_id]['vle'] = ctjTx($row_DtRg['eccmzsgm_vle'],'in','',['html'=>'ok','schr'=>'no','nl2'=>'no']);
					$Vl[$_key_id]['hb'] = mBln($row_DtRg['eccmzsgm_hb']);

				} while ($row_DtRg = $DtRg->fetch_assoc());

			}else{

				echo $__cnx->c_r->error;

			}

			$__cnx->_clsr($DtRg);

			$rtrn = _jEnc($Vl);
			return($rtrn);
		}
	}

	function ChkEcEdtSgm($_p=NULL){

		global $__cnx;

		if(!isN($_p['eccmz']) && !isN($_p['sgm'])){ $_hb='ok'; $_id_r = 'id_eccmzsgm'; $_id_enc = 'eccmzsgm_enc'; }
		elseif( !isN($_p['ec']) && !isN($_p['mdl']) && !isN($_p['sgm'])){ $_hb='ok'; $_id_r = 'id_mdleccrt'; $_id_enc = 'mdleccrt_enc'; }

		if($_hb == 'ok'){

			if(!isN($_p['bd'])){ $_bd = _BdStr($_p['bd']); }else{ $_bd = ''; }

			if(!isN($_p['ec'])){
				$query_DtRg = sprintf('	SELECT id_mdleccrt, mdleccrt_enc, mdleccrt_vl_es, mdleccrt_tag_es
										FROM '.$_bd.TB_MDL_EC_CRT.'
										WHERE 	mdleccrt_mdl=(SELECT id_mdl FROM '.$_bd.TB_MDL.' WHERE mdl_enc=%s) AND
												mdleccrt_eccrt=%s AND mdleccrt_ec = %s
										LIMIT 1',
										GtSQLVlStr($_p['mdl'], 'text'),
										GtSQLVlStr($_p['sgm'], 'int'),
										GtSQLVlStr($_p['ec'], 'int')
									);
			}else{
				$query_DtRg = sprintf('	SELECT id_eccmzsgm, eccmzsgm_enc
										FROM '._BdStr(DBM).TB_EC_CMZ_SGM.'
										WHERE 	eccmzsgm_eccmz = %s  AND
												eccmzsgm_sgm = %s
										LIMIT 1',
										GtSQLVlStr($_p['eccmz'], 'int'),
										GtSQLVlStr($_p['sgm'], 'int'));
			}

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg == 1){

					$Vl['r'] = 'ok';
					$Vl['id'] = $row_DtRg[$_id_r];
					$Vl['enc'] = $row_DtRg[$_id_enc];

					if(!isN($row_DtRg['mdleccrt_vl_es'])){
						$Vl['cod'] = ctjTx($row_DtRg['mdleccrt_vl_es'],'in','',['html'=>'ok','schr'=>'no','nl2'=>'no']);
					}

					if(!isN($row_DtRg['mdleccrt_tag_es'])){
						$Vl['tag'] = ctjTx($row_DtRg['mdleccrt_tag_es'],'in','',['html'=>'ok','schr'=>'no','nl2'=>'no']);
					}

				}else{
					$Vl['r'] = 'no';
				}
			}

			$__cnx->_clsr($DtRg);

		}else{

			$Vl['r'] = 'no';

		}



		return(_jEnc($Vl));
	}


	function GtEcCmzSgmChrLs($_p=NULL){

		global $__cnx;

		if(!isN($_p['sgm'])){

			$query_DtRg = sprintf('	SELECT id_sisecchr, id_eccmzsgmchr, sisecchr_tt, sisecchr_css, eccmzsgmchr_vle, sisecchr_end
									FROM '._BdStr(DBM).TB_SIS_EC_CHR.'
										 LEFT JOIN '._BdStr(DBM).TB_EC_CMZ_SGM_CHR.' ON id_sisecchr = eccmzsgmchr_chr
									WHERE sisecchr_sgm = 1 AND eccmzsgmchr_eccmzsgm = %s
									ORDER BY id_sisecchr ASC', GtSQLVlStr($_p['sgm'], 'int'));

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){
				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;
				$i = 0;
				do{
					if($_p['arr'] == 'ok'){
						$i = $row_DtRg['id_sisecchr'];
					}

					$Vl[$i]['id_chr'] = $row_DtRg['id_sisecchr'];
					$Vl[$i]['id'] = $row_DtRg['id_eccmzsgmchr'];
					$Vl[$i]['tt'] = $row_DtRg['sisecchr_tt'];
					$Vl[$i]['css'] = $row_DtRg['sisecchr_css'];
					$Vl[$i]['vle'] = ctjTx($row_DtRg['eccmzsgmchr_vle'],'in');
					$Vl[$i]['end'] = $row_DtRg['sisecchr_end'];

					$i++;
				} while ($row_DtRg = $DtRg->fetch_assoc());
			}

			if($_p['arr'] == 'ok'){
				$rtrn = $Vl;
			}else{
				$rtrn = _jEnc($Vl);
			}

			$__cnx->_clsr($DtRg);

			return($rtrn);

		}
	}

	function ChkEcCmzImg($_p=NULL){

		global $__cnx;

		if(!isN($_p['eccmz']) && !isN($_p['img'])){

			$query_DtRg = sprintf('	SELECT id_eccmzimg, eccmzimg_fle
									FROM '._BdStr(DBM).TB_EC_CMZ_IMG.'
									WHERE eccmzimg_eccmz=%s AND eccmzimg_img=%s
									LIMIT 1',
						GtSQLVlStr($_p['eccmz'], 'int'), GtSQLVlStr($_p['img'], 'int'));

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				//$Vl['q'] = $query_DtRg;

				if($Tot_DtRg == 1){
					$Vl['r'] = 'ok';
					$Vl['id'] = $row_DtRg['id_eccmzimg'];
					$Vl['img']['c'] = $row_DtRg['eccmzimg_fle']; // Cut
					$Vl['img']['o'] = str_replace('.','_o.',$row_DtRg['eccmzimg_fle']); // Original
				}else{
					$Vl['r'] = 'no';
				}

			}else{

				echo $__cnx->c_r->error;

			}


			}else{
				$Vl['r'] = 'no';
			}

			$__cnx->_clsr($DtRg);

			return(_jEnc($Vl));
	}

	function ChkEcCmzImgChr($_p=NULL){

		global $__cnx;

		if(!isN($_p['eccmzimg']) && !isN($_p['chr'])){
			$query_DtRg = sprintf('SELECT * FROM '._BdStr(DBM).TB_EC_CMZ_IMG_CHR.' WHERE eccmzimgchr_eccmzimg = %s  AND eccmzimgchr_chr = %s LIMIT 1', GtSQLVlStr($_p['eccmzimg'], 'int'), GtSQLVlStr($_p['chr'], 'int'));
			$DtRg = $__cnx->_qry($query_DtRg);
			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;

			if($Tot_DtRg == 1){
				$Vl['r'] = 'ok';
				$Vl['id'] = $row_DtRg['id_eccmzimgchr'];
				$Vl['vle'] = $row_DtRg['eccmzimgchr_vle'];
			}else{
				$Vl['r'] = 'no';
			}
		}else{
			$Vl['r'] = 'no';
		}

		$__cnx->_clsr($DtRg);

		return(_jEnc($Vl));
	}

	function GtEcCmzImgChrLs($_p=NULL){

		global $__cnx;

		if(($_p['img'] != '' || !isN($_p['img']))){

			$query_DtRg = sprintf('	SELECT id_eccmzimgchr, sisecchr_tt, sisecchr_css, eccmzimgchr_vle, sisecchr_end
									FROM '._BdStr(DBM).TB_EC_CMZ_IMG_CHR.'
										 INNER JOIN '._BdStr(DBM).TB_SIS_EC_CHR.' ON eccmzimgchr_chr = id_sisecchr
									WHERE eccmzimgchr_eccmzimg = %s', GtSQLVlStr($_p['img'], 'int'));

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg > 0){
					$i = 0;
					do{
						$Vl[$i]['id'] = $row_DtRg['id_eccmzimgchr'];
						$Vl[$i]['tt'] = $row_DtRg['sisecchr_tt'];
						$Vl[$i]['css'] = $row_DtRg['sisecchr_css'];
						$Vl[$i]['vle'] = ctjTx($row_DtRg['eccmzimgchr_vle'],'in');
						$Vl[$i]['end'] = $row_DtRg['sisecchr_end'];
						$i++;
					} while ($row_DtRg = $DtRg->fetch_assoc());
				}
			}

			$__cnx->_clsr($DtRg);

		$rtrn = _jEnc($Vl);
		return($rtrn);
		}
	}

	function ChkEcEdtSgmChr($_p=NULL){

		global $__cnx;

		if(!isN($_p['eccmzsgm']) && !isN($_p['chr'])){
			$query_DtRg = sprintf('SELECT * FROM '._BdStr(DBM).TB_EC_CMZ_SGM_CHR.' WHERE eccmzsgmchr_eccmzsgm = %s  AND eccmzsgmchr_chr = %s LIMIT 1', GtSQLVlStr($_p['eccmzsgm'], 'int'), GtSQLVlStr($_p['chr'], 'int'));
			$DtRg = $__cnx->_qry($query_DtRg);
			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;

			if($Tot_DtRg == 1){
				$Vl['r'] = 'ok';
				$Vl['id'] = $row_DtRg['id_eccmzsgmchr'];
				$Vl['vle'] = $row_DtRg['eccmzsgmchr_vle'];
			}else{
				$Vl['r'] = 'no';
			}
		}else{
			$Vl['r'] = 'no';
		}

			$__cnx->_clsr($DtRg);

		return(_jEnc($Vl));
	}

	function GtEcCmzDt($_p=NULL){

		global $__cnx;

		if(!isN($_p['cmz'])){

			$Vl['e'] = 'no';

			if($_p['tp'] == 'nm'){
				$_fl = 'eccmz_nm'; $_vlr = $_p['eccmz_nm']; $_tp = 'text';
			}elseif($_p['tp'] == 'enc'){
				$_fl = 'eccmz_enc'; $_vlr = $_p['cmz']; $_tp = 'text';
			}else{
				$_fl = 'id_eccmz'; $_vlr = $_p['cmz']; $_tp = 'int';
			}

			$query_DtRg = sprintf('	SELECT 	id_eccmz, eccmz_nm, eccmz_ec, eccmz_rlctp, eccmz_rlchdr,
											eccmz_are, eccmz_cl, eccmz_est, eccmz_rbld, id_us, us_enc, us_user
									FROM '._BdStr(DBM).TB_EC_CMZ.'
										 INNER JOIN '._BdStr(DBM).TB_US.' ON eccmz_us = id_us
									WHERE '.$_fl.' = %s', GtSQLVlStr($_vlr, $_tp));


			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg > 0){

					$Vl['e'] = 'ok';

					do{

						$Vl['id'] = $row_DtRg['id_eccmz'];
						$Vl['nm'] = ctjTx($row_DtRg['eccmz_nm'],'in');
						$Vl['ec'] = $row_DtRg['eccmz_ec'];

						$Vl['rlc']['tp'] = $row_DtRg['eccmz_rlctp'];
						$Vl['rlc']['hdr'] = $row_DtRg['eccmz_rlchdr'];
						$Vl['are'] = $row_DtRg['eccmz_are'];
						$Vl['cl'] = $row_DtRg['eccmz_cl'];
						$Vl['est'] = $row_DtRg['eccmz_est'];

						$Vl['rbld'] = mBln($row_DtRg['eccmz_rbld']);

						$Vl['us']['id'] = ctjTx($row_DtRg['id_us'],'in');
						$Vl['us']['enc'] = ctjTx($row_DtRg['us_enc'],'in');
						$Vl['us']['user'] = ctjTx($row_DtRg['us_user'],'in');

					} while ($row_DtRg = $DtRg->fetch_assoc());

				}else{
					$Vl['w'] = 'No records';
					$Vl['q'] = compress_code($query_DtRg);
				}

			}else{
				$Vl['w'] = 'error query:'.$__cnx->c_r->error;
				$Vl['q'] = compress_code($query_DtRg);
			}

			$__cnx->_clsr($DtRg);

		}else{
			$Vl['w'] = 'No id data';
		}

		return _jEnc($Vl);
	}

	function ChkEcCmzHdr($_p=NULL){

		global $__cnx;

		if(!isN($_p['eccmz'])){

			$query_DtRg = sprintf('SELECT * FROM '._BdStr(DBM).TB_EC_CMZ_HDR.' WHERE eccmzhdr_eccmz = %s LIMIT 1', GtSQLVlStr($_p['eccmz'], 'int'));
			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){
				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg == 1){
					$Vl['r'] = 'ok';
					$Vl['id'] = $row_DtRg['id_eccmzhdr'];
					$Vl['img'] = $row_DtRg['eccmzhdr_fle'];
				}else{
					$Vl['r'] = 'no';
				}
			}

			}else{
				$Vl['r'] = 'no';
			}

			$__cnx->_clsr($DtRg);

			return(_jEnc($Vl));
	}

	function ChkEcCmzLsts($_p=NULL){

		global $__cnx;

		if(!isN($_p['eccmz'])){

			if($_p['up'] == 'ok'){ $_col = ", (SELECT GROUP_CONCAT(up_hdr) FROM "._BdStr(DB_PRC).TB_UP_BD.", ".TB_EC_LSTS_UP."  WHERE eclstsup_up = id_up AND eccmzlsts_lsts = eclstsup_lsts LIMIT 1) AS __col "; }

			$query_DtRg = sprintf('SELECT * '.$_col.' FROM ec_cmz_lsts WHERE eccmzlsts_eccmz = %s LIMIT 1', GtSQLVlStr($_p['eccmz'], 'int'));
			$DtRg = $__cnx->_qry($query_DtRg);
			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;

			if($Tot_DtRg == 1){
				$Vl['r'] = 'ok';
				$Vl['id'] = $row_DtRg['id_eccmzlsts'];

				$Vl['lsts'] = GtEcLstsDt([ 'id'=>$row_DtRg['eccmzlsts_lsts']]);


				if($_p['up']  == 'ok'){
					$Vl['col'] = $row_DtRg['__col'];
				}

			}else{
				$Vl['r'] = 'no';
			}
			}else{
				$Vl['r'] = 'no';
			}

			$__cnx->_clsr($DtRg);

		return(_jEnc($Vl));
	}

	function ChkEcCmzEc($_p=NULL){

		global $__cnx;

		if(!isN($_p['eccmz'])){

			$query_DtRg = sprintf('	SELECT id_ec, ec_enc, ec_cmzrlc, ec_dir, ec_est
									FROM '._BdStr(DBM).TB_EC.'
									WHERE ec_cmzrlc = %s
									LIMIT 1', GtSQLVlStr($_p['eccmz'], 'int'));

			//$Vl['q'] = $query_DtRg;

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){
				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg == 1){

					$Vl['r'] = 'ok';
					$Vl['id'] = $row_DtRg['id_ec'];
					$Vl['enc'] = $row_DtRg['ec_enc'];
					$Vl['cmzrlc'] = $row_DtRg['ec_cmzrlc'];
					$Vl['dir'] = $row_DtRg['ec_dir'];

					if(!isN($_p['d']) && $_p['d']['ec'] == 'ok'){
						$Vl['d'] = GtEcDt($row_DtRg['id_ec']);
					}

					$Vl['est'] = $row_DtRg['ec_est'];

				}else{
					$Vl['r'] = 'no';
				}

			}else{

				$Vl['w'] = 'error query:'.$__cnx->c_r->error;

			}

			$__cnx->_clsr($DtRg);

		}else{

			$Vl['r'] = 'no';
			$Vl['m'] = 'no ID';

		}


		return(_jEnc($Vl));
	}


	function GtEcSgmDt($_p=NULL){

		global $__cnx;

		$Vl['e'] = 'no';

		if(is_array($_p)){

			if(!isN($_p['id'])){

				if($_p['t'] == 'enc'){ $__f = 'eclstssgm_enc'; $__ft = 'text'; }else{ $__f = 'id_eclstssgm'; $__ft = 'int'; }

				$query_DtRg = sprintf(" SELECT *
										FROM  "._BdStr(DBM).TB_EC_LSTS_SGM."
										WHERE ".$__f." = %s", GtSQLVlStr($_p['id'], $__ft));

				$DtRg = $__cnx->_qry($query_DtRg);

				if($DtRg){
					$row_DtRg = $DtRg->fetch_assoc();
					$Tot_DtRg = $DtRg->num_rows;

					if($Tot_DtRg > 0){
						$Vl['e'] = 'ok';
						$Vl['id'] = $row_DtRg['id_eclstssgm'];
					}
				}else{
					$Vl['w'] = $__cnx->c_r->error;
				}
			}

				$__cnx->_clsr($DtRg);
		}

		return _jEnc($Vl);
	}


	function GtEcLstsVar($_p=NULL){

		global $__cnx;

		if(is_array($_p)){
			if(!isN($_p['id'])){

				if($_p['t'] == 'enc'){ $__f = 'eclstsvar_enc'; $__ft = 'text'; }else{ $__f = 'id_eclstsvar'; $__ft = 'int'; }

				$query_DtRg = sprintf(" SELECT *

										FROM  "._BdStr(DBM).TB_EC_LSTS_VAR."
											  INNER JOIN "._BdStr(DBM).TB_SIS_EC_SGM_VAR." ON eclstsvar_var = id_sisecsgmvar
										WHERE ".$__f." = %s", GtSQLVlStr($_p['id'], $__ft));

				$DtRg = $__cnx->_qry($query_DtRg);
				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg > 0){

					$Vl['e'] = 'ok';
					$Vl['id'] = $row_DtRg['id_eclstsvar'];
					$Vl['enc'] = $row_DtRg['eclstsvar_enc'];
					$Vl['vl'] = $row_DtRg['eclstsvar_vl'];


					if($row_DtRg['sisecsgmvar_ls'] != ''){
						$_ls_j = json_decode($row_DtRg['sisecsgmvar_ls']);
						$Vl['ls']['l'] = $_ls_j->l;
						$Vl['ls']['v'] = $_ls_j->v;

						if(!isN($_ls_j->d) && $_p['dt'] == 'ok'){
							$myf = $_ls_j->d;
							$Vl['ls']['d'] = $myf($row_DtRg['eclstsvar_vl']);
						}
					}

				}else{
					$Vl['e'] = 'no';
				}

				$__cnx->_clsr($DtRg);

				return _jEnc($Vl);
			}
		}

	}

	function GtEcSgmVarDt($_p=NULL){

		global $__cnx;

		if(is_array($_p)){
			if(!isN($_p['id'])){

				if($_p['t'] == 'enc'){ $__f = 'eclstssgmvar_enc'; $__ft = 'text'; }else{ $__f = 'id_eclstssgmvar'; $__ft = 'int'; }

				$query_DtRg = sprintf(" SELECT *

										FROM  "._BdStr(DBM).TB_EC_LSTS_SGM_VAR."
											  INNER JOIN "._BdStr(DBM).TB_SIS_EC_SGM_VAR." ON eclstssgmvar_var = id_sisecsgmvar
										WHERE ".$__f." = %s", GtSQLVlStr($_p['id'], $__ft));

				$DtRg = $__cnx->_qry($query_DtRg);
				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg > 0){

					$Vl['e'] = 'ok';
					$Vl['id'] = $row_DtRg['id_eclstssgmvar'];
					$Vl['enc'] = $row_DtRg['eclstssgmvar_enc'];
					$Vl['vl'] = $row_DtRg['eclstssgmvar_vl'];


					if($row_DtRg['sisecsgmvar_ls'] != ''){
						$_ls_j = json_decode($row_DtRg['sisecsgmvar_ls']);
						$Vl['ls']['l'] = $_ls_j->l;
						$Vl['ls']['v'] = $_ls_j->v;

						if(!isN($_ls_j->d) && $_p['dt'] == 'ok'){
							$myf = $_ls_j->d;
							$Vl['ls']['d'] = $myf($row_DtRg['eclstssgmvar_vl']);
						}
					}

				}else{
					$Vl['e'] = 'no';
				}

				$__cnx->_clsr($DtRg);

				return _jEnc($Vl);
			}
		}
	}

	function LsEcCmzRlcTp($__id, $__v, $__va=NULL, $__rq=NULL){
		if(!isN($__id)){
			if($__va == 1){ $_slc = 'ok'; }elseif($__va == 2){ $_slc2 = 'ok'; }
			$LsBld .= HTML_OpVl(['ct'=>'off']);
			$LsBld .= HTML_OpVl(['t'=>'Area o Departamento', 'v'=>1, 's'=>$_slc]);
			$LsBld .= HTML_OpVl(['t'=>'-En Convenio-', 'v'=>2, 's'=>$_slc2]);
			$_rtrn2 = /*bdiv(['c'=>*/HTML_Slct(['id'=>$__id, 'ph'=>/*FM_LS_SLTP*/'', 'rq'=>$__rq, 'c'=>$LsBld])/*, 'cls'=>$_cls])*/;
			return($_rtrn2);
		}
	}




	function EcCmzImgTag($string, $tagname) {

		$_e = explode($tagname.'=', str_replace('&nbsp;', '', $string) );

	    $_e = str_replace(['[',']'],'',explode(' ', $_e[1]));

	    $r['v'] = $_e[0];

	    if($tagname == 'w'){ $_html = 'width="'.$r['v'].'"'; }
	    if($tagname == 'h'){ $_html = 'height="'.$r['v'].'"'; }
	    $r['t'] = $_html;

	    return _jEnc($r);
	}


	function EcCmzImgDt($_p=NULL){

		global $__cnx;

		if(!isN($_p['id'])){
			$query_DtRg = sprintf('SELECT * FROM '._BdStr(DBM).TB_EC_CMZ_IMG.' WHERE id_eccmzimg = %s LIMIT 1', GtSQLVlStr($_p['id'], 'int'));
			$DtRg = $__cnx->_qry($query_DtRg);
			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;

			//$Vl['q'] = $query_DtRg;

			if($Tot_DtRg == 1){
				$Vl['r'] = 'ok';
				$Vl['id'] = $row_DtRg['id_eccmzimg'];
				$Vl['img']['c'] = $row_DtRg['eccmzimg_fle']; // Cut
				$Vl['img']['o'] = str_replace('.','_o.',$row_DtRg['eccmzimg_fle']); // Original

				$Vl['img']['cut']['w'] = $row_DtRg['eccmzimg_w'];
				$Vl['img']['cut']['h'] = $row_DtRg['eccmzimg_h'];
				$Vl['img']['cut']['x'] = $row_DtRg['eccmzimg_x'];
				$Vl['img']['cut']['x2'] = $row_DtRg['eccmzimg_x2'];
				$Vl['img']['cut']['y'] = $row_DtRg['eccmzimg_y'];
				$Vl['img']['cut']['y2'] = $row_DtRg['eccmzimg_y2'];
			}else{
				$Vl['r'] = 'no';
			}
			}else{
				$Vl['r'] = 'no';
			}

			$__cnx->_clsr($DtRg);

		return(_jEnc($Vl));
	}

	function GtSisEcCmnt($_p=NULL){

		global $__cnx;

		if(($_p['id']!=NULL)){
			$c_DtRg = "-1";if($_p['id']!=NULL){$c_DtRg = $_p['id'];}

			if($_p['tp'] == 'ec'){ $__f = 'eccmnt_ec'; $__ft = 'int'; }

			$query_DtRg = sprintf("	SELECT *
									FROM "._BdStr(DBM).TB_EC_CMNT."
										 INNER JOIN "._BdStr(DBM).TB_US." ON eccmnt_us = id_us
									WHERE {$__f} = %s ORDER BY id_eccmnt DESC ", GtSQLVlStr($c_DtRg, $__ft));
			$DtRg = $__cnx->_qry($query_DtRg);
			$Tot_DtRg = $DtRg->num_rows;
			$Vl['tot'] = $Tot_DtRg;

			if($Tot_DtRg > 0){
				do{

					$_id = $row_DtRg['id_eccmnt'];

					$Vl[$_id]['id'] = $row_DtRg['id_eccmnt'];
					$Vl[$_id]['user'] = $row_DtRg['eccmnt_us'];
					$Vl[$_id]['cmnt'] = ctjTx($row_DtRg['eccmnt_cmnt'],'in');
					$Vl[$_id]['f'] = ctjTx($row_DtRg['eccmnt_f'],'in');
					$Vl[$_id]['us']['nm'] = ctjTx($row_DtRg['us_nm'],'in');
					$Vl[$_id]['us']['img'] = ctjTx($row_DtRg['us_img'],'in');


					if( !isN($row_DtRg['us_img']) ){

						$Vl[$_id]['us']['img'] = _ImVrs(['img'=>$row_DtRg['us_img'], 'f'=>DMN_FLE_US ]);

					}else{

						$_img = GtUsImg([ 'img'=>$row_DtRg['us_img'], 'gnr'=>$row_DtRg['us_gnr'] ]);

						$Vl[$_id]['us']['img'] = $_img;

					}



				}while($row_DtRg = $DtRg->fetch_assoc());
			}

			$__cnx->_clsr($DtRg);

				$rtrn = json_decode(json_encode($Vl));
		return($rtrn);
		}
	}

	function GtSisEcCmntRd($_p=NULL){

		global $__cnx;

		if(!isN($_p['id_ec'])){

			$c_DtRg = "-1";if(!isN($_p['id_ec'])){$c_DtRg = $_p['id'];}


			if($_p['tp']=="us"){ $_fl = "AND eccmntrd_us = ".$_p['us'].""; }

			$query_DtRg = sprintf("	SELECT * FROM "._BdStr(DBM).TB_EC_CMNT_RD." WHERE eccmntrd_eccmnt = %s ".$_fl." ",
									GtSQLVlStr($_p['id_ec'], 'int'));
			$DtRg = $__cnx->_qry($query_DtRg);
			$Tot_DtRg = $DtRg->num_rows;
			$row_DtRg = $DtRg->fetch_assoc();
			$Vl['tot'] = $Tot_DtRg;

			if($Tot_DtRg > 0){
				$Vl['id'] = $row_DtRg['id_eccmntrd'];
				$Vl['id_eccmnt'] = $row_DtRg['eccmntrd_eccmnt'];
				$Vl['us'] = $row_DtRg['eccmntrd_us'];
				$Vl['e'] = 'ok';
				$VL['tot'] = $Tot_DtRg;
			}

			$__cnx->_clsr($DtRg);

			return(_jEnc($Vl));
		}
	}

	function GtSisEcCmntRdTot($_p=NULL){

		global $__cnx;

		if(!isN($_p['id_ec'])){

			$c_DtRg = "-1";if(!isN($_p['id_ec'])){$c_DtRg = $_p['id'];}

			$query_DtRg = sprintf("	SELECT COUNT(*) AS _tot
									FROM "._BdStr(DBM).TB_EC_CMNT."
									WHERE id_eccmnt NOT IN( SELECT eccmntrd_eccmnt FROM "._BdStr(DBM).TB_EC_CMNT_RD." ) AND eccmnt_ec = %s ",
									GtSQLVlStr($_p['id_ec'], 'int'));

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$Tot_DtRg = $DtRg->num_rows;
				$row_DtRg = $DtRg->fetch_assoc();
				$Vl['tot'] = $Tot_DtRg;

				if($Tot_DtRg > 0){
					$Vl['_tot'] = $row_DtRg['_tot'];
				}

			}

			$__cnx->_clsr($DtRg);

			return(_jEnc($Vl));

		}
	}

	function GtClFljLs($p=NULL){

		global $__cnx;

		$Vl['e'] = 'no';

		if(!isN($p['flj']) && !isN($p['tp'])){

			if($p['flj']){ $Vl['q']['flj'] = $p['flj']; $__fl .= sprintf(' AND clflj_flj=%s ', GtSQLVlStr($p['flj'], 'int')); }
			if($p['tp']){ $Vl['q']['tp'] = $p['tp']; $__fl .= sprintf(' AND clflj_tp=%s ', GtSQLVlStr($p['tp'], 'int')); }

			$Ls_Qry = "

						SELECT *
						FROM "._BdStr(DBM).TB_CL_FLJ."
							 INNER JOIN "._BdStr(DBM).TB_CL." ON clflj_cl = id_cl
							 LEFT JOIN "._BdStr(DBM).TB_US." ON clflj_us = id_us
						WHERE
							cl_enc = '".DB_CL_ENC."' AND clflj_on = 1 {$__fl}
						ORDER BY id_clflj DESC
					";

			$Ls_Rg = $__cnx->_qry($Ls_Qry);

			if($Ls_Rg){

				$row_Ls_Rg = $Ls_Rg->fetch_assoc();
				$Tot_Ls_Rg = $Ls_Rg->num_rows;

				$Vl['e'] = 'ok';
				$Vl['tot'] = $Tot_Ls_Rg;

				if($Tot_Ls_Rg > 0){

					$_i = 0;

	                do{

	                    if(!isN($row_Ls_Rg['id_us'])){ $Vl['ls'][$_i]['us']['id'] = ctjTx($row_Ls_Rg['id_us'],'in'); }
	                    if(!isN($row_Ls_Rg['us_enc'])){ $Vl['ls'][$_i]['us']['enc'] = ctjTx($row_Ls_Rg['us_enc'],'in'); }
						if(!isN($row_Ls_Rg['us_user'])){ $Vl['ls'][$_i]['us']['usr'] = ctjTx($row_Ls_Rg['us_user'],'in'); }
						if(!isN($row_Ls_Rg['us_nm'])){ $Vl['ls'][$_i]['us']['nm'] = ctjTx($row_Ls_Rg['us_nm'],'in'); }
						if(!isN($row_Ls_Rg['us_ap'])){ $Vl['ls'][$_i]['us']['ap'] = ctjTx($row_Ls_Rg['us_ap'],'in'); }

	                    $Vl['ls'][$_i]['flj']['id'] = ctjTx($row_Ls_Rg['id_clflj'],'in');
	                    $Vl['ls'][$_i]['flj']['enc'] = ctjTx($row_Ls_Rg['clflj_enc'],'in');
						$Vl['ls'][$_i]['flj']['user'] = mBln($row_Ls_Rg['clflj_user']);
						$Vl['ls'][$_i]['flj']['ntf']['eml'] = mBln($row_Ls_Rg['clflj_ntf_eml']);
						$Vl['ls'][$_i]['flj']['ntf']['sms'] = mBln($row_Ls_Rg['clflj_ntf_sms']);
						$Vl['ls'][$_i]['flj']['ntf']['whtsp'] = mBln($row_Ls_Rg['clflj_ntf_whtsp']);
						$Vl['ls'][$_i]['flj']['q'] = $Tot_Ls_Rg;

						$_i++;

	                } while ($row_Ls_Rg = $Ls_Rg->fetch_assoc());

	            }
	        }

	        $__cnx->_clsr($Ls_Rg);

		}

		return _jEnc($Vl);

	}

	function __GtSisEcSgmVarTp_Slc($_p=NULL){

		$__t_sub = $_p['t_sub'];
		$_Lsts_Enc = $_p['lsts'];

		$_p = _jEnc($_p);


		$_attr = [
					'sgm-enc'=>$_p->{'sgm-enc'},
					'var-enc'=>$_p->{'var-enc'},
					'sis-sgm-enc'=>$_p->{'sis-sgm-enc'},
					'sis-var-enc'=>$_p->{'sis-var-enc'}
				];

		$__f_snd = "

			var _sgm = $(this).attr('sgm-enc');
			var _var = $(this).attr('var-enc');
			var _sis_sgm = $(this).attr('sis-sgm-enc');
	    	var _sis_var = $(this).attr('sis-var-enc');


			var _p = ".json_encode($_p).";

			var _vle = $(this).val();

			if(!isN(_sgm) && !isN(_sis_var)){

				_Rqu({
					t:'ec_lsts_sgm',
					tp:'var_upd',
					t_sub:'".$__t_sub."',
					lsts:'".$_Lsts_Enc."',
					sgm:_sgm,
					var:_var,

					sis_sgm:_sis_sgm,
					sis_var:_sis_var,

					tp_ls:_p.tp.ls,

					vle:_vle,

					_bs:function(){
						$('#f_var_vl_'+_var).addClass('_ld');
					},
					_cm:function(){
						$('#f_var_vl_'+_var).removeClass('_ld');
					},
					_cl:function(_r){
						if(!isN(_r)){
							if(!isN(_r.e) && _r.e == 'ok'){

								$('#li_sgm_'+_sgm).removeClass('off').addClass('on');
								$('#li_sgm_var_'+_var).removeClass('off').addClass('on');

								if(_p.tp.ls == 'LsCntAttr'){

									if( $('#cntapplattr_vl_'+_p['var-enc']).length == 0 ){
										$('.f_var_vl_sub_'+_p['var-enc']).append(_r.html);
										if( !isN(_r.js) ){
											eval( _r.js );
										}

										var _slc_txt = $( '#".$_p->id." option:selected' ).html();
										$( '#f_var_vl_'+_p['var-enc']+' > div' ).remove();
										$( '#f_var_vl_'+_p['var-enc'] ).html(_slc_txt);

									}

								}

							}
						}
					}

				});
			}


		";

		if($_p->tp->id == '2'){

			$_r['html'] = SlDt([
									'id'=>$_p->id,
									'yr'=>'ok',
									'lmt'=>'no',
									'va'=>!isN($_p->va)?$_p->va:'',
									'ph'=>'',
									'cls'=>CLS_CLND. !isN($_p->va)?' _fl':'',
									'attr'=>$_attr,
									'onc'=>'
												'.$__f_snd.'

												if(!isN(__v.val())){
													__v.addClass("_fl");
												}else{
													__v.removeClass("_fl");
												}
											'
							]);

		}elseif($_p->tp->id == '3'){


			if($_p->tp->ls == 'LsMdl'){
				$_r['html'] = LsMdl($_p->id, 'mdl_enc', $_p->va, '', 1, '', ['ino'=>'id_mdl', 'attr'=>$_attr] );
				$_r['js'] = JQ_Ls($_p->id, TX_SLCNMDL);
			}elseif($_p->tp->ls == 'LsCntEst'){
				$_r['html'] = LsCntEst([ 'id'=>$_p->id, 'v'=>'id_siscntest', 'va'=>$_p->va, 'v_go'=>'enc', 'rq'=>1, 'attr'=>$_attr ]);
				$_r['js'] = JQ_Ls($_p->id,FM_LS_EST, '', '_slcClr', ['ac'=>'no']);
			}elseif($_p->tp->ls == 'LsSis_Md'){
				$_r['html'] = LsSis_Md($_p->id,'sismd_enc',$_p->va, '', 1, '', ['ino'=>'id_sismd', 'attr'=>$_attr] );
				$_r['js'] = JQ_Ls($_p->id, FM_LS_MD);
			}elseif($_p->tp->ls == 'LsSis_PsOLD'){
				$_r['html'] = LsSis_PsOLD($_p->id, 'sisps_enc',$_p->va, TX_SLCPS, 2, '', '', '',['ino'=>'id_sisps', 'attr'=>$_attr] );
		      	$_r['js'] = JQ_Ls($_p->id, TX_SLCPS,'','psFlg');
			}elseif($_p->tp->ls == 'LsSis_Cd'){
				$_r['html'] = LsCdOld([ 'id'=>$_p->id, 'v'=>'siscd_enc', 'va'=>$_p->va, 'ph'=>TX_SLCCD, 'rq'=>2, 'ino'=>'id_siscd', 'attr'=>$_attr ]);
		      	$_r['js'] = JQ_Ls($_p->id, TX_SLCCD,'','psFlg');
			}elseif($_p->tp->ls == 'LsSis_Dp'){
				$_r['html'] = LsCdDpTmp([ 'id'=>$_p->id, 'v'=>'siscddp_enc', 'va'=>$_p->va, 'ph'=>'Seleccione Departamento', 'rq'=>2, 'ino'=>'id_siscddp', 'attr'=>$_attr ]);
		      	$_r['js'] = JQ_Ls($_p->id, TX_SLCCD,'','psFlg');
			}elseif($_p->tp->ls == 'LsEcCmpg'){
				$_r['html'] = LsEcCmpg([ 'id'=>$_p->id, 'v'=>'eccmpg_enc', 'va'=>$_p->va, 'rq'=>2, 'ino'=>'id_eccmpg', 'attr'=>$_attr ]);
		      	$_r['js'] = JQ_Ls($_p->id, FM_LS_SLCMPG);
			}elseif($_p->tp->ls == 'LsAtmt'){
				$_r['html'] = LsAtmt([ 'id'=>$_p->id, 'v'=>'atmt_enc', 'va'=>$_p->va, 'rq'=>2, 'ino'=>'id_atmt', 'attr'=>$_attr ]);
		      	$_r['js'] = JQ_Ls($_p->id, FM_LS_SLCATMT);
			}elseif($_p->tp->ls == 'LsMdlSTp'){
				$_r['html'] = LsMdlSTp($_p->id, 'id_mdlstp', $_p->va, TX_TP, '', '', '', ['attr'=>$_attr]);
		      	$_r['js'] = JQ_Ls($_p->id, 'Seleccione Tipo');
			}elseif($_p->tp->ls == 'LsClAre'){
				$_r['html'] = LsClAre([ 'id'=>$_p->id, 'v'=>'id_clare', 'va'=>$_p->va, 'rq'=>2, 'ino'=>'id_atmt', 'attr'=>$_attr ]);
		      	$_r['js'] = JQ_Ls($_p->id, 'Seleccione Area');
			}elseif($_p->tp->ls == 'LsCntAttr'){
				$l = __Ls(['k'=>'cnt_attr', 'id'=>$_p->id, 'va'=>$_p->va , 'ph'=>TX_ATTR, 'attr'=>$_attr, 'cls'=>'slc_eclstssgmvar_vl_sub']);
				$_r['html'] = $l->html; $_r['js'] = $l->js;
			}elseif($_p->tp->ls == 'LsMdlSPrd'){
				$_r['html'] = LsMdlSPrd($_p->id, 'id_mdlsprd', $_p->va, '', '', '', ['attr'=>$_attr]);
		      	$_r['js'] = JQ_Ls($_p->id, 'Seleccione Periodo');
			}elseif($_p->tp->ls == 'LsCntTp'){
				$_r['html'] = LsCntTp($_p->id, 'siscnttp_enc', $_p->va, '', '', '', ['attr'=>$_attr] );
		      	$_r['js'] = JQ_Ls($_p->id, 'Seleccione Vinculo');
			}elseif($_p->tp->ls == 'LsCntEstTp'){
				$_r['html'] = LsCntEstTp($_p->id,'id_siscntesttp', $_p->va, 'Seleccione Etapa','','', ['attr'=>$_attr] );
				$_r['js'] = JQ_Ls($_p->id, 'Seleccione Etapa');
			}elseif($_p->tp->ls == 'LsBcoPay'){
				$_r['html'] = LsBcoPay($_p->id,'id_sisslc', $_p->va, 'Seleccione Estado de Pago','','', ['attr'=>$_attr] );
				$_r['js'] = JQ_Ls($_p->id, 'Seleccione Estado de Pago');
			}else{
				$_r['html'] .= 'Display '.$_p->tp->ls;
			}


			$_r['js'] .= "

				$('#".$_p->id."').change(function(){
					".$__f_snd."
				});

			";

		}elseif($_p->tp->id == '6'){

			$__sis_cld = LsSis_Cld([ 'id'=>$_p->id, 'va'=>$_p->va, 'attr'=>$_attr ]);
			$_r['html'] = $__sis_cld->html;
			$_r['js'] = $__sis_cld->js;

			$_r['js'] .= "

				$('input:radio[name=\"".$_p->id."\"]').change(function() {
			    	".$__f_snd."
			    });

			";

		}elseif($_p->tp->id == '7'){

			$_r['html'] = HTML_inp_tx($_p->id,'',!isN($_p->va)?$_p->va:'',FMRQD,'','','','','',[ 'attr'=>$_attr ]);

			$_r['js'] .= "

				$('#".$_p->id."').focusout(function() {
					".$__f_snd."
			    });

			";


		}elseif($_p->tp->id == '9'){

			$_r['html'] = HTML_inp_tx($_p->id,'',!isN($_p->va)?$_p->va:'',FMRQD,'','','','','',[ 'attr'=>$_attr ]);

			$_r['js'] .= "

				$('#".$_p->id."').focusout(function() {
					".$__f_snd."
			    });

			";

		}

		return _jEnc($_r);

	}


	function GtClSndTot($_p=NULL){

		global $__cnx;

		$Vl['e'] = 'no';

		if(!isN($_p['bd'])){

			if(!isN($_p['bd'])){ $_bd = _BdStr($_p['bd']); }

			$query_DtRg = "	SELECT COUNT(*) AS _tot
							FROM ".$_bd.TB_EC_SND."
							WHERE ecsnd_est = '"._CId('ID_SNDEST_PRG')."' AND
								  ecsnd_id IS NULL AND
								  ecsnd_html = 1 AND
								  CONCAT(ecsnd_f,' ',ecsnd_h) <= NOW() AND
								  ecsnd_f = DATE_FORMAT(NOW(), '%Y-%m-%d')
						";

			if(!isN($query_DtRg)){

				$DtRg = $__cnx->_qry($query_DtRg);

				if($DtRg){

					$Tot_DtRg = $DtRg->num_rows;
					$row_DtRg = $DtRg->fetch_assoc();

					if($Tot_DtRg > 0){
						$Vl['e'] = 'ok';
						$Vl['tot'] = $row_DtRg['_tot'];
					}

				}else{
					$Vl['w'] = 'Error:'.$__cnx->c_r->error;
					$Vl['q'] = 'Query:'.$query_DtRg;
				}

				$__cnx->_clsr($DtRg);

			}

		}else{

			$Vl['w'] = 'No database';

		}

		return(_jEnc($Vl));

	}


	function GtClSndHtmlTot($_p=NULL){

		global $__cnx;
		$Vl['e'] = 'no';

		if(!isN($_p['bd'])){

			if(!isN($_p['bd'])){ $_bd = _BdStr($_p['bd']); }

			$query_DtRg = sprintf("	SELECT 	id_eccmpg,
											(eccmpg_tot_lds - eccmpg_tot_html) AS __tot_bld
									FROM "._BdStr(DBM).TB_EC_CMPG."
									WHERE 	( eccmpg_est = '"._CId('ID_ECCMPGEST_SNDIN')."' || eccmpg_est = '"._CId('ID_ECCMPGEST_APRBD')."' ) AND
											eccmpg_tot_lds != eccmpg_tot_html AND
											eccmpg_tot_lds > eccmpg_tot_html AND
											eccmpg_cl = '".$_p['cl']."'
									ORDER BY __tot_bld DESC
								");

			//echo compress_code($query_DtRg);

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$Tot_DtRg = $DtRg->num_rows;
				$row_DtRg = $DtRg->fetch_assoc();

				if($Tot_DtRg > 0){

					do{

						$Vl['tot'] = $Vl['tot']+$row_DtRg['__tot_bld'];

					}while($row_DtRg = $DtRg->fetch_assoc());

				}else{
					$Vl['no'] = $query_DtRg;
					$Vl['m'] = 'No recors on:'.compress_code($query_DtRg);
				}

			}else{

				$Vl['w'] = $__cnx->c_r->error.' / Problem executing:'.compress_code($query_DtRg);

			}

			$__cnx->_clsr($DtRg);


		}else{
			$Vl['w'] = 'No bd to execute';
		}

		return(_jEnc($Vl));


	}

	function GtEcSndRDt($_p=NULL){

		global $__cnx;

		$Vl['e'] = 'no';
		//$Vl['p'] = $_p;

		if(!isN($_p['id'])){

			if($_p['tp'] == 'enc'){ $__f = 'ecsndr_enc'; $__ft = 'text'; }
			elseif($_p['tp'] == 'id'){ $__f = 'ecsndr_id'; $__ft = 'text'; }
			else{ $__f = 'id_ecsndr'; $__ft = 'int'; }

			if(!isN($_p['bd'])){ $_bd = _BdStr($_p['bd']); }else{ $_bd = ''; }

			$query_DtRg = sprintf('
									SELECT id_ecsndr, ecsndr_enc, ecsndr_tp, ecsndr_id
								    FROM '.$_bd.TB_EC_SND_R.'
								    WHERE '.$__f.'=%s
								    LIMIT 1', GtSQLVlStr($_p['id'], $__ft)
								);

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;
				$Vl['tot'] = $Tot_DtRg;

				if($Tot_DtRg > 0){

					$Vl['id'] = $row_DtRg['id_ecsndr'];
					$Vl['enc'] = $row_DtRg['ecsndr_enc'];

					if(!isN($row_DtRg['ecsndr_tp'])){
						if($row_DtRg['ecsndr_tp'] == 'vtex_ins_rfd'){
							$Vl['vtex']['ins_rfd'] = GtVtexCmpgInsRfdDt([ 'id'=>$row_DtRg['ecsndr_id'], 'bd'=>$_bd ]);
							if(!isN( $Vl['vtex']['ins_rfd']->w )){
								$Vl['w'] = $Vl['vtex']['ins_rfd']->w;
							}
						}elseif($row_DtRg['ecsndr_tp'] == 'vtex_ins'){
							$Vl['vtex']['ins'] = GtVtexCmpgInsDt([ 'id'=>$row_DtRg['ecsndr_id'], 'bd'=>$_bd, 'm'=>[ 'pss'=>'ok' ] ]);
							if(!isN( $Vl['vtex']['ins']->w )){
								$Vl['w'] = $Vl['vtex']['ins']->w;
							}
						}
					}

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


	function GtEcCmpgOutCronTot($_p=NULL){

		global $__cnx;

		if(!isN($_p['t']) && !isN($_p['inst'])){

			if($_p['t'] == 'snd'){
				$_fltr .= " AND CONCAT(eccmpg_p_f,' ',eccmpg_p_h) < NOW() AND eccmpg_est = '"._CId('ID_ECCMPGEST_SNDIN')."' ";
			}elseif($_p['t'] == 'que'){
				$_fltr .= "	AND (
									eccmpg_est = '"._CId('ID_ECCMPGEST_APRBD')."' OR
									eccmpg_est = '"._CId('ID_ECCMPGEST_PRC')."'
								)
							AND eccmpg_rdy = 2
							AND eccmpg_tot_lds != eccmpg_tot_que
							";
			}elseif($_p['t'] == 'html'){
				$_fltr .= "	AND (
									eccmpg_est = '"._CId('ID_ECCMPGEST_APRBD')."' OR
									eccmpg_est = '"._CId('ID_ECCMPGEST_SNDIN')."'
								)
							AND eccmpg_tot_html != eccmpg_tot_lds";
			}

			$query_DtRg = sprintf("	SELECT COUNT(*) AS _tot
									FROM "._BdStr(DBM).TB_EC_CMPG."
									WHERE
										eccmpg_sndr = '"._CId('ID_SISEML_SUMR')."' AND
										NOT EXISTS (
											SELECT eccmpgcron_cmpg
											FROM "._BdStr(DBM).TB_EC_CMPG_CRON."
											WHERE 	eccmpgcron_cmpg = id_eccmpg AND
													eccmpgcron_instance=%s AND
													eccmpgcron_tp=%s
										)
										".$_fltr."
									",
							GtSQLVlStr($_p['inst'], 'text'),
							GtSQLVlStr($_p['t'], 'text'));

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$Tot_DtRg = $DtRg->num_rows;
				$row_DtRg = $DtRg->fetch_assoc();

				if($Tot_DtRg > 0){
					$Vl['tot'] = $row_DtRg['_tot'];
				}

			}else{
				$Vl['w'] = $__cnx->c_r->error;
			}

			$__cnx->_clsr($DtRg);

			return(_jEnc($Vl));

		}
	}


	function GtEcCmpgOutCronLs($_p=NULL){

		global $__cnx;

		if(!isN($_p['t']) && !isN($_p['inst'])){

			if($_p['t'] == 'snd'){
				$_fltr .= " AND CONCAT(eccmpg_p_f,' ',eccmpg_p_h) < NOW() AND eccmpg_est = '"._CId('ID_ECCMPGEST_SNDIN')."' ";
			}elseif($_p['t'] == 'que'){
				$_fltr .= "	AND (
									eccmpg_est = '"._CId('ID_ECCMPGEST_APRBD')."' OR
									eccmpg_est = '"._CId('ID_ECCMPGEST_PRC')."' OR
									eccmpg_est = '"._CId('ID_ECCMPGEST_SNDIN')."'
								)
							AND eccmpg_rdy = 2
							AND eccmpg_tot_lds != eccmpg_tot_que
							";
			}elseif($_p['t'] == 'html'){
				$_fltr .= "	AND (
									eccmpg_est = '"._CId('ID_ECCMPGEST_APRBD')."' OR
									eccmpg_est = '"._CId('ID_ECCMPGEST_SNDIN')."'
								)
							AND eccmpg_tot_html != eccmpg_tot_lds ";
			}else{
				$Vl['w'] = $__cnx->c_r->error;
			}

			$query_DtRg = sprintf("	SELECT id_eccmpg, eccmpg_enc,
											(
												SELECT COUNT(*)
												FROM "._BdStr(DBM).TB_EC_CMPG_CRON."
												WHERE eccmpgcron_cmpg = id_eccmpg AND
													  eccmpgcron_instance=%s AND
													  eccmpgcron_tp=%s
											) AS exst
									FROM "._BdStr(DBM).TB_EC_CMPG."
									WHERE eccmpg_sndr = '"._CId('ID_SISEML_SUMR')."' ".$_fltr."
									ORDER BY eccmpg_p_f ASC, eccmpg_p_h ASC
									LIMIT 50
								",
								GtSQLVlStr($_p['inst'], 'text'),
								GtSQLVlStr($_p['t'], 'text'));

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$Tot_DtRg = $DtRg->num_rows;
				$row_DtRg = $DtRg->fetch_assoc();

				$Vl['tot'] = $Tot_DtRg;

				if($Tot_DtRg > 0){

					do{

						$Vl['ls'][$row_DtRg['eccmpg_enc']]['id'] = $row_DtRg['id_eccmpg'];
						$Vl['ls'][$row_DtRg['eccmpg_enc']]['enc'] = $row_DtRg['eccmpg_enc'];
						$Vl['ls'][$row_DtRg['eccmpg_enc']]['exst'] = $row_DtRg['exst'];

					}while($row_DtRg = $DtRg->fetch_assoc());

				}

			}

			$__cnx->_clsr($DtRg);

			return(_jEnc($Vl));

		}
	}

?>