<?php

	function GtClDt($Id, $Tp=NULL, $p=NULL){

		global $__cnx;

		$__tme_s = microtime(true);

		$Vl['e'] = 'no';

		if(!isN($Id)){

			if($Tp == 'enc'){ $__f = 'cl_enc'; $__ft = 'text'; }
			elseif($Tp == 'sbd'){ $__f = 'cl_sbd'; $__ft = 'text'; }
			elseif($Tp == 'prfl'){ $__f = 'cl_prfl'; $__ft = 'text'; }
			else{ $__f = 'id_cl'; $__ft = 'int'; }

			$c_DtRg = "-1";if (isset($Id)){$c_DtRg = $Id;}

			$query_DtRg = sprintf('	SELECT 	id_cl,
							 				cl_nm,
							 				cl_dir,
											cl_sbd,
							 				cl_web,
							 				cl_rsllr

									FROM '._BdStr(DBM).TB_CL.'
									WHERE '.$__f.' = %s
									LIMIT 1', GtSQLVlStr($c_DtRg, $__ft));

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg > 0){

					$Vl['e'] = 'ok';

					$__dataext = Cl_CData([ 'id'=>$row_DtRg['cl_sbd'] ]);

					$Vl['id'] = $row_DtRg['id_cl'];
					$Vl['nm'] = ctjTx($row_DtRg['cl_nm'],'in');
					$Vl['sbd'] = $__dataext->sbd;
					$Vl['dir'] = ctjTx($row_DtRg['cl_dir'],'in');
					$Vl['enc'] = $__dataext->enc;
					$Vl['prfl'] = $__dataext->prfl;
					$Vl['web'] = ctjTx($row_DtRg['cl_web'],'in');
					$Vl['chat'] = $__dataext->chat;
					$Vl['on'] = $__dataext->on;
					$Vl['bd'] = $__dataext->bd;

					if($p['dtl']['tag']=='ok'){
						$Vl['tag'] = $__dataext->tag;
					}

					if($p['dtl']['dmn']=='ok'){
						$Vl['dmn'] = $__dataext->dmn;
					}

					if($p['dtl']['eml']=='ok'){
						$Vl['eml'] = $__dataext->eml;
					}

					$Vl['img'] = $__dataext->img;
					$Vl['bck'] = $__dataext->bck;
					$Vl['lgo'] = $__dataext->lgo;

					if(!isN($row_DtRg['cl_rsllr'])){
						$Vl['rsllr'] = GtClDt($row_DtRg['cl_rsllr']);
					}

				}

			}

			$__cnx->_clsr($DtRg);

		}else{

			$Vl['w'] = 'No all data';

		}

		return(_jEnc($Vl));
	}





	function GtClAppDt($p=NULL){

		global $__cnx;

		$Vl['e'] = 'no';

		if(!isN($p['id'])){

			if($p['t'] == 'enc'){ $__f = 'clapp_enc'; $__ft = 'text'; }
			elseif($p['t'] == 'pml'){ $__f = 'clapp_pml'; $__ft = 'text'; }
			else{ $__f = 'id_clapp'; $__ft = 'int'; }

			$query_DtRg = sprintf('SELECT * FROM '._BdStr(DBM).TB_CL_APP.' WHERE '.$__f.'=%s LIMIT 1', GtSQLVlStr($p['id'], $__ft));
			$DtRg = $__cnx->_qry($query_DtRg);

			//$Vl['q'] = compress_code($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				$Vl['tot'] = $Tot_DtRg;

				if($Tot_DtRg > 0){

					$Vl['e'] = 'ok';

					$Vl['id'] = $row_DtRg['id_clapp'];
					$Vl['enc'] = ctjTx($row_DtRg['clapp_enc'],'in');
					$Vl['tt'] = ctjTx($row_DtRg['clapp_tt'],'in');
					$Vl['pml'] = ctjTx($row_DtRg['clapp_pml'],'in');
					$Vl['dir'] = ctjTx($row_DtRg['clapp_dir'],'in');
					$Vl['on'] = mBln($row_DtRg['clapp_e']);
					$Vl['stup']['act'] = mBln($row_DtRg['clapp_stup_act']);
					$Vl['stup']['csfle'] = mBln($row_DtRg['clapp_stup_csfle']);
					$Vl['icn'] = GtClAppIcnLs([ 'cl_app'=>$row_DtRg['id_clapp'] ]);
					$Vl['tp'] = GtClAppTpLs([ 'cl_app'=>$row_DtRg['id_clapp'] ]);
					$Vl['img'] = _ImVrs([ 'img'=>$row_DtRg['clapp_img'], 'f'=>DMN_FLE_CL_BCK_APP_CSTM ]);

				}

			}else{

				$_r['w'] = $__cnx->c_r->error;

			}

			$__cnx->_clsr($DtRg);

		}else{

			$_r['w'] = 'No all data';

		}

		return _jEnc($Vl);

	}


	function GtClAppIcnLs($p){

		global $__cnx;


		if(!isN($p['cl_app'])){ $__fl = sprintf( ' AND clappicn_clapp=%s ', GtSQLVlStr($p['cl_app'], 'int') ); }


		$query_DtRg = sprintf("	SELECT *,
										"._QrySisSlcF([ 'als'=>'icn', 'als_n'=>'icon' ]).",
										".GtSlc_QryExtra(['t'=>'fld', 'p'=>'icon', 'als'=>'icn'])."
								FROM "._BdStr(DBM).TB_CL_APP_ICN."
									  ".GtSlc_QryExtra([ 't'=>'tb', 'col'=>'clappicn_icn', 'als'=>'icn' ])."
								WHERE id_clappicn IS NOT NULL {$__fl}");

		$DtRg = $__cnx->_qry($query_DtRg);

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;

			$Vl['tot'] = $Tot_DtRg;

			if($Tot_DtRg > 0){

				do{

					if(mBln($row_DtRg['clappicn_e']) == 'ok'){

						$__attr = json_decode($row_LsFld['___icon']);

						foreach($__attr as $__attr_k=>$__attr_v){
							$__icn->{$__attr_v->key} = $__attr_v;
						}

						$__id = $row_DtRg['id_clappicn'];

						$Vl['ls'][$__id]['id'] = $row_DtRg['id_clappicn'];
						$Vl['ls'][$__id]['tt'] = !isN($row_DtRg['clappicn_tt'])?ctjTx($row_DtRg['clappicn_tt'],'in'):ctjTx($row_DtRg['icon_sisslc_tt'],'in');
						$Vl['ls'][$__id]['img'] = !isN($row_DtRg['clappicn_img'])?ctjTx($row_DtRg['clappicn_img'],'in'):DMN_FLE_SIS_SLC.ctjTx($row_DtRg['icon_sisslc_img'],'in');
						$Vl['ls'][$__id]['rel'] = !isN($row_DtRg['clappicn_rel'])?ctjTx($row_DtRg['clappicn_rel'],'in'):ctjTx($row_DtRg['icon_sisslc_cns'],'in');

						$Vl['ls'][$__id]['ord'] = ctjTx($row_DtRg['clappicn_ord'],'in');
						$Vl['ls'][$__id]['e'] = mBln($row_DtRg['clappicn_e']);

						$Vl['ls'][$__id]['attr'] = $__icn;

					}

				}while($row_DtRg = $DtRg->fetch_assoc());

			}

		}else{

			$Vl['w'] = $__cnx->c_r->error;

		}

		$__cnx->_clsr($DtRg);

		return _jEnc($Vl);

	}


	function GtClAppTpLs($p){

		global $__cnx;

		if(!isN($p['cl_app'])){ $__fl = sprintf( ' AND clapptp_clapp=%s ', GtSQLVlStr($p['cl_app'], 'int') ); }

		$query_DtRg = sprintf("	SELECT *
								FROM "._BdStr(DBM).TB_CL_APP_TP."
									 INNER JOIN "._BdStr(DBM).TB_MDL_S_TP." ON clapptp_tp = id_mdlstp
								WHERE id_clapptp IS NOT NULL {$__fl}");

		$DtRg = $__cnx->_qry($query_DtRg);

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;

			$Vl['tot'] = $Tot_DtRg;

			if($Tot_DtRg > 0){

				do{

					if(mBln($row_DtRg['clapptp_e']) == 'ok'){

						$__id = $row_DtRg['id_clapptp'];

						$Vl['ls'][$__id]['id'] = $row_DtRg['id_clapptp'];
						$Vl['ls'][$__id]['tt'] = ctjTx($row_DtRg['clapptp_tt'],'in');
						$Vl['ls'][$__id]['tp']['id'] = ctjTx($row_DtRg['clapptp_tp'],'in');
						$Vl['ls'][$__id]['tp']['key'] = ctjTx($row_DtRg['mdlstp_tp'],'in');

						$Vl['ls'][$__id]['img'] = DMN_FLE_SIS_SLC.$row_DtRg['clapptp_img'];
						$Vl['ls'][$__id]['fm'] = ctjTx($row_DtRg['clapptp_fm'],'in');

						$Vl['ls'][$__id]['ord'] = ctjTx($row_DtRg['clappicn_ord'],'in');
						$Vl['ls'][$__id]['e'] = mBln($row_DtRg['clappicn_e']);

					}

				}while($row_DtRg = $DtRg->fetch_assoc());

			}

		}else{

			$Vl['w'] = $__cnx->c_r->error;

		}

		$__cnx->_clsr($DtRg);

		return _jEnc($Vl);

	}



	function GtClDmnLs($p){

		global $__cnx;

		if(!isN($p['id'])){

			$__f = 'cldmn_cl'; $__ft = 'int';

			$c_DtRg = "-1";if (isset($p['id'])){$c_DtRg = $p['id'];}


			$query_DtRg = sprintf("	SELECT *
									FROM "._BdStr(DBM).TB_CL_DMN."
										 LEFT JOIN "._BdStr(DBM).TB_CL_DMN_SUB." ON cldmnsub_cldmn = id_cldmn
									WHERE ".$__f." = %s", GtSQLVlStr($c_DtRg, $__ft));

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				$Vl['tot'] = $Tot_DtRg;

				if($Tot_DtRg > 0){

					do{

						$__id=$row_DtRg['cldmn_enc'];
						$Vl['main']['ls'][$__id]['id'] = $row_DtRg['id_cldmn'];
						$Vl['main']['ls'][$__id]['url'] = ctjTx($row_DtRg['cldmn_dmn'],'in');

						if(!isN($row_DtRg['cldmnsub_sub'])){
							$__tp=$row_DtRg['cldmnsub_tp'];
							$Vl['sbd'][$__tp]['id'] = $row_DtRg['id_cldmnsub'];
							$Vl['sbd'][$__tp]['url'] = ctjTx($row_DtRg['cldmnsub_sub'].'.'.$row_DtRg['cldmn_dmn'],'in');
							$Vl['sbd'][$__tp]['ssl'] = mBln($row_DtRg['cldmnsub_ssl']);
						}

					}while($row_DtRg = $DtRg->fetch_assoc());

				}

			}

			$__cnx->_clsr($DtRg);

			return _jEnc($Vl);
		}
	}

	function GtClDmnSubDt($p=NULL){

		global $__cnx;

		$Vl['e'] = 'no';

		if(!isN($p['id'])){

			if(!isN($p['cl'])){ $__cl = $p['cl']; }else{ $__cl = CL_ENC; }

			if($p['t'] == 'tp'){
				$__f = 'cldmnsub_tp'; $__ft = 'text';
			}else{
				$__f = 'id_cldmnsub'; $__ft = 'int';
			}

			if(!isN($p['sub'])){ $__fl .= sprintf(' AND cldmnsub_sub=%s ', GtSQLVlStr($p['sub'], 'text')); }
			if(!isN($p['dmn'])){ $__fl .= sprintf(' AND cldmn_dmn=%s ', GtSQLVlStr($p['dmn'], 'text')); }
			if(!isN($__cl)){ $__fl .= sprintf(' AND cl_enc=%s ', GtSQLVlStr($__cl, 'text')); }

			if(!isN($__cl)){

				$query_DtRg = sprintf("	SELECT id_cldmnsub, cldmn_dmn, cldmn_cl, cldmnsub_sub, cldmnsub_ssl, cldmn_dmn
										FROM "._BdStr(DBM).TB_CL_DMN_SUB."
											INNER JOIN "._BdStr(DBM).TB_CL_DMN." ON cldmnsub_cldmn = id_cldmn
											INNER JOIN "._BdStr(DBM).TB_CL." ON cldmn_cl = id_cl
										WHERE ".$__f." = %s {$__fl}
										LIMIT 1", GtSQLVlStr($p['id'], $__ft));

				$DtRg = $__cnx->_qry($query_DtRg);
				//$Vl['q'] = $query_DtRg;

				if($DtRg){

					$row_DtRg = $DtRg->fetch_assoc();
					$Tot_DtRg = $DtRg->num_rows;;

					if($Tot_DtRg > 0){

						$Vl['e'] = 'ok';
						$Vl['id'] = $row_DtRg['id_cldmnsub'];
						$Vl['cl']['id'] = $row_DtRg['cldmn_cl'];
						$Vl['ssl'] = mBln($row_DtRg['cldmnsub_ssl']);


						if( $Vl['ssl'] == 'ok'){ $__h='https://'; }else{ $__h='http://'; }
						$Vl['url'] = $__h.ctjTx($row_DtRg['cldmnsub_sub'].'.'.$row_DtRg['cldmn_dmn'],'in').'/';
						$Vl['dmn']['url'] = 'https://'.ctjTx($row_DtRg['cldmn_dmn'],'in');
					}
				}

			}

			$__cnx->_clsr($DtRg);

		}else{

			$Vl['w'] = 'no data';

		}

		return _jEnc($Vl);
	}

	function GtClEmlLs($p){

		global $__cnx;

		$Vl['e'] = 'no';

		if($p['on']=='ok'){ $_fl .= " AND cl_on = 1"; }
		if($p['onl']=='ok'){ $_fl .= " AND eml_onl = 1"; }
		if(!isN($p['tp'])){ $_fl .= " AND eml_tp = '".$p['tp']."' "; }

		if(!isN($p['id'])){ $_fl .= sprintf(" AND cleml_cl=%s ", GtSQLVlStr($p['id'], 'int')); }
		if($p['rnd']=='ok'){ $_orby = "ORDER BY RAND()"; }else{ $_orby = "ORDER BY id_eml ASC"; }

		$query_DtRg = sprintf("	SELECT 	id_eml, id_cleml, cleml_enc, cleml_cl, cleml_dfl, cl_nm, eml_enc, eml_nm, eml_eml, eml_tp, eml_usr,
										eml_ssl, eml_srv_in, eml_prt_in, eml_srv_out, eml_prt_out, cleml_dfl, eml_sndr, eml_aws_ses,
										AES_DECRYPT(eml_pss, '".ENCRYPT_PASSPHRASE."') AS __pss,
										AES_DECRYPT(eml_api_key, '".ENCRYPT_PASSPHRASE."') AS __apikey
								FROM "._BdStr(DBM).TB_CL_EML."
										INNER JOIN "._BdStr(DBT).TB_THRD_EML." ON cleml_eml = id_eml
										INNER JOIN "._BdStr(DBM).TB_CL." ON cleml_cl = id_cl
								WHERE id_cleml != '' {$_fl}
								{$_orby}
								",
								GtSQLVlStr($c_DtRg, $__ft)
							);

		$DtRg = $__cnx->_qry($query_DtRg); //echo $query_DtRg.HTML_BR.HTML_BR.HTML_BR;

		//$Vl['qry'] = $query_DtRg;

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;

			$Vl['e'] = 'ok';
			$Vl['tot'] = $Tot_DtRg;

			if($Tot_DtRg > 0){

				do{

					$__id = $row_DtRg['cleml_enc'];

					$__o = [
						'id'=>ctjTx($row_DtRg['id_eml'],'in'),
						'enc'=>$row_DtRg['eml_enc'],
						'nm'=>ctjTx($row_DtRg['eml_nm'],'in'),
						'eml'=>ctjTx($row_DtRg['eml_eml'],'in'),
						'tp'=>ctjTx($row_DtRg['eml_tp'],'in'),
						'usr'=>ctjTx($row_DtRg['eml_usr'],'in'),
						//'pss'=>ctjTx($row_DtRg['__pss'],'in'),
						'api'=>[
							'key'=>ctjTx($row_DtRg['__apikey'],'in')
						],
						'ssl'=>mBln($row_DtRg['eml_ssl']),
						'in'=>[
							'srv'=>ctjTx($row_DtRg['eml_srv_in'],'in'),
							'prt'=>ctjTx($row_DtRg['eml_prt_in'],'in'),
						],
						'out'=>[
							'srv'=>ctjTx($row_DtRg['eml_srv_out'],'in'),
							'prt'=>ctjTx($row_DtRg['eml_prt_out'],'in'),
						],
						'dfl'=>mBln($row_DtRg['cleml_dfl']),
						'sndr'=>mBln($row_DtRg['eml_sndr']),
						'aws'=>[
							'ses'=>mBln($row_DtRg['eml_aws_ses'])
						]
					];


					$Vl['ls'][$__id]['id'] = $row_DtRg['id_cleml'];
					$Vl['ls'][$__id]['eml'] = $__o;
					$Vl['ls'][$__id]['cl']['id'] = $row_DtRg['cleml_cl'];
					$Vl['ls'][$__id]['cl']['nm'] = ctjTx($row_DtRg['cl_nm'],'in');

					if(mBln($row_DtRg['cleml_dfl']) == 'ok'){
						$Vl['dfl'] = $__o;
					}


				}while($row_DtRg = $DtRg->fetch_assoc());

			}else{

				$Vl['w'] = 'No records';

			}

		}else{

			$Vl['w'] = $__cnx->c_r->error;

		}


		$__cnx->_clsr($DtRg);

		return _jEnc($Vl);

	}



	function GtClEmlBoxLs($p){

		global $__cnx;

		$Vl['e'] = 'no';

		if(!isN($p['eml'])){

			$query_DtRg = sprintf("	SELECT 	id_emlbox, emlbox_enc, emlbox_id,  emlbox_lbl, emlbox_out_sve
									FROM "._BdStr(DBT).TB_THRD_EML_BOX."
									WHERE emlbox_eml=%s",
									GtSQLVlStr($p['eml'], 'int')
								);

			//$Vl['q'] = $query_DtRg;
			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				$Vl['e'] = 'ok';
				$Vl['tot'] = $Tot_DtRg;

				if($Tot_DtRg > 0){

					do{

						$__id = $row_DtRg['emlbox_enc'];

						$Vl['ls'][$__id] = [
							'id'=>ctjTx($row_DtRg['id_emlbox'],'in'),
							'cid'=>ctjTx($row_DtRg['emlbox_id'],'in'),
							'enc'=>$__id,
							'lbl'=>ctjTx($row_DtRg['emlbox_lbl'],'in'),
							'out'=>[
								'sve'=>mBln($row_DtRg['emlbox_out_sve'])
							]
						];

					}while($row_DtRg = $DtRg->fetch_assoc());

				}else{

					$Vl['w'] = 'No records';

				}

			}else{

				$Vl['w'] = $__cnx->c_r->error;

			}

			$__cnx->_clsr($DtRg);

		}

		return _jEnc($Vl);

	}

	function GtClEmlDt($p){

		global $__cnx;

		$Vl['e'] = "no";

		if(!isN($p['id'])){

			if($p['t'] == 'enc'){
				$__f = 'eml_enc'; $__ft = 'text';
			}else{
				$__f = 'id_eml'; $__ft = 'int';
			}

			$query_DtRg = sprintf("	SELECT *,
										   AES_DECRYPT(eml_pss, '".ENCRYPT_PASSPHRASE."') AS __pss,
										   AES_DECRYPT(eml_api_key, '".ENCRYPT_PASSPHRASE."') AS __apikey
									FROM "._BdStr(DBT).TB_THRD_EML."
										 INNER JOIN "._BdStr(DBM).TB_CL_EML." ON cleml_eml = id_eml
									WHERE ".$__f." = %s
									LIMIT 1", GtSQLVlStr($p['id'], $__ft));

			$DtRg = $__cnx->_qry($query_DtRg);
			//$Vl['q'] = compress_code( $query_DtRg );

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				$Vl['tot'] = $Tot_DtRg;

				if($Tot_DtRg > 0){

					do{

						$__id = $row_DtRg['cleml_enc'];

						$Vl = [
							'id'=>ctjTx($row_DtRg['id_eml'],'in'),
							'cl'=>[
								'id'=>$row_DtRg['cleml_cl']
							],
							'nm'=>ctjTx($row_DtRg['eml_nm'],'in'),
							'eml'=>ctjTx($row_DtRg['eml_eml'],'in'),
							'tp'=>ctjTx($row_DtRg['eml_tp'],'in'),
							'usr'=>ctjTx($row_DtRg['eml_usr'],'in'),
							'pss'=>ctjTx($row_DtRg['__pss'],'in'),
							'api'=>[
								'tkn'=>ctjTx($row_DtRg['__apikey'],'in')
							],
							'ssl'=>mBln($row_DtRg['eml_ssl']),
							'in'=>[
								'srv'=>ctjTx($row_DtRg['eml_srv_in'],'in'),
								'prt'=>ctjTx($row_DtRg['eml_prt_in'],'in'),
							],
							'out'=>[
								'srv'=>ctjTx($row_DtRg['eml_srv_out'],'in'),
								'prt'=>ctjTx($row_DtRg['eml_prt_out'],'in'),
							],
							'dfl'=>mBln($row_DtRg['cleml_dfl']),
							'sndr'=>mBln($row_DtRg['eml_sndr']),
							'aws'=>[
								'ses'=>mBln($row_DtRg['eml_aws_ses'])
							],
							'bx'=>( (!isN($p['box']) && $p['box'] == 'ok' ) ? GtClEmlBoxLs([ 'eml'=>$row_DtRg['id_eml'] ]):'' )
						];


					}while($row_DtRg = $DtRg->fetch_assoc());

				}

			}

			$__cnx->_clsr($DtRg);

		}

		return _jEnc($Vl);

	}

	function GtClPlcyDt($p){

		global $__cnx;

		$Vl['e'] = "no";

		if(!isN($p['id'])){


			if($p['t'] == 'enc'){
				$__f = 'clplcy_enc'; $__ft = 'text';
			}else{
				$__f = 'id_clplcy'; $__ft = 'int';
			}

			$query_DtRg = sprintf("	SELECT *
									FROM "._BdStr(DBM).TB_CL_PLCY."
									WHERE ".$__f." = %s
									LIMIT 1", GtSQLVlStr($p['id'], $__ft));

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				$Vl['tot'] = $Tot_DtRg;

				if($Tot_DtRg > 0){

					$Vl = [
						'id'=>ctjTx($row_DtRg['id_clplcy'],'in'),
						'enc'=>ctjTx($row_DtRg['clplcy_enc'],'in'),
						'nm'=>ctjTx($row_DtRg['clplcy_nm'],'in'),
						'tx'=>ctjTx($row_DtRg['clplcy_tx'],'in'),
						'cl'=>[
							'id'=>ctjTx($row_DtRg['clplcy_cl'],'in')
						],
						'lnk'=>[
							'tt'=>ctjTx($row_DtRg['clplcy_lnk_tt'],'in'),
							'url'=>ctjTx($row_DtRg['clplcy_lnk'],'in')
						]
					];

				}

			}

			$__cnx->_clsr($DtRg);
			return _jEnc($Vl);

		}

	}

	function GtClPlcyDflt($p){

		global $__cnx;

		$Vl['e'] = "no";

		if(!isN($p['cl'])){


			$query_DtRg = sprintf("	SELECT *
									FROM "._BdStr(DBM).TB_CL_PLCY."
										 INNER JOIN "._BdStr(DBM).TB_CL." ON clplcy_cl = id_cl
									WHERE id_cl=%s
									LIMIT 1", GtSQLVlStr($p['cl'], 'int'));

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				$Vl['tot'] = $Tot_DtRg;

				if($Tot_DtRg > 0){

					$Vl = [
						'id'=>ctjTx($row_DtRg['id_clplcy'],'in'),
						'enc'=>ctjTx($row_DtRg['clplcy_enc'],'in'),
						'nm'=>ctjTx($row_DtRg['clplcy_nm'],'in'),
						'tx'=>ctjTx($row_DtRg['clplcy_tx'],'in'),
						'lnk'=>[
							'tt'=>ctjTx($row_DtRg['clplcy_lnk_tt'],'in'),
							'url'=>ctjTx($row_DtRg['clplcy_lnk'],'in')
						]
					];

				}

			}

			$__cnx->_clsr($DtRg);
			return _jEnc($Vl);
		}
	}



	function GtClRow_Ls($Id, $mdl){

		global $__cnx;

		$__Cl = new CRM_Cl();
		$query_DtRg = sprintf('SELECT * FROM '._BdStr(DBM).TB_CL_ROW.' WHERE clrow_id = (SELECT id_mdlstp FROM '._BdStr(DBM).TB_MDL_S_TP.' WHERE mdlstp_tp = "'.$Id.'") AND clrow_cl = (SELECT id_cl FROM '._BdStr(DBM).TB_CL.' WHERE cl_enc = "'.CL_ENC.'") ORDER BY clrow_ord ASC');

		$DtRg = $__cnx->_qry($query_DtRg);

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;

			if($Tot_DtRg > 0){

				do{
					$Vl[$row_DtRg['clrow_ord']]['id'] = $row_DtRg['id_clrow'];
					$Vl[$row_DtRg['clrow_ord']]['cols'] = $row_DtRg['clrow_cols'];
					$Vl[$row_DtRg['clrow_ord']]['flds'] = $__Cl->ClRowFld_Ls(['id'=>$row_DtRg['id_clrow'], 'mdl'=>$mdl]);
				}while($row_DtRg = $DtRg->fetch_assoc());

			}else{
				$Vl['no'] = $query_DtRg;
			}

		}

		$__cnx->_clsr($DtRg);

		return(_jEnc($Vl));
	}

	function GtClAreDt($p=NULL){

		global $__cnx;

		if(!isN($p['id'])){ $_fl .= " AND id_clare = ".$p['id'].""; }
		if(!isN($p['enc'])){ $_fl .= " AND clare_enc = '".$p['enc']."'"; }
		if(!isN($p['prnt'])){ $_fl .= " AND clare_prnt = ".$p['prnt'].""; }

		$Dt_Qry = "	SELECT id_clare, clare_enc, clare_tt, clare_img, clare_logo, clare_hdr, clare_clr,
							(
								SELECT _sub.clare_ord
							 	FROM "._BdStr(DBM).TB_CL_ARE." AS _sub
							 	WHERE _sub.clare_ord IS NOT NULL AND _sub.clare_prnt = _main.id_clare
							 	ORDER BY _sub.clare_ord DESC
							 	LIMIT 1
							) AS __ord_lst
						FROM "._BdStr(DBM).TB_CL_ARE." AS _main
						WHERE _main.id_clare != '' {$_fl} AND _main.clare_est = 1
						LIMIT 1";

		$DtRg = $__cnx->_qry($Dt_Qry);

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;

			if($Tot_DtRg > 0){

	            $__img = _ImVrs(['img'=>ctjTx($row_DtRg['clare_img'],'in'), 'f'=>DMN_FLE_CL_ARE ]);
	            $__img_lgo = _ImVrs(['img'=>ctjTx($row_DtRg['clare_logo'],'in'), 'f'=>DMN_FLE_CL_ARE_LGO ]);
				$__img_hdr = _ImVrs(['img'=>ctjTx($row_DtRg['clare_hdr'],'in'), 'f'=>DMN_FLE_CL_ARE_HDR ]);

				$_r['id'] = $row_DtRg['id_clare'];
				$_r['enc'] = $row_DtRg['clare_enc'];
				$_r['tt'] = ctjTx($row_DtRg['clare_tt'],'in');
				$_r['clr'] = ctjTx($row_DtRg['clare_clr'],'in');

				$_r['lst']['ord'] = $row_DtRg['__ord_lst'];
				$_r['img']['main'] = $__img;
				$_r['img']['hdr'] = $__img_hdr;
				$_r['img']['lgo'] = $__img_lgo;

	        }
        }

		$__cnx->_clsr($DtRg);

		return _jEnc($_r);

	}

	function GtClGrpDt($p=NULL){

		global $__cnx;

		if(!isN($p['id'])){ $_fl .= " AND id_clgrp = ".$p['id'].""; }
		if(!isN($p['enc'])){ $_fl .= " AND clgrp_enc = '".$p['enc']."'"; }

		$Dt_Qry = "	SELECT id_clgrp, clgrp_enc, clgrp_nm
					FROM "._BdStr(DBM).TB_CL_GRP."
					WHERE id_clgrp != '' {$_fl}
					LIMIT 1";

		$DtRg = $__cnx->_qry($Dt_Qry);

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;

			if($Tot_DtRg > 0){

				$_r['id'] = $row_DtRg['id_clgrp'];
				$_r['enc'] = $row_DtRg['clgrp_enc'];
				$_r['tt'] = ctjTx($row_DtRg['clgrp_nm'],'in');

	        }
        }

		$__cnx->_clsr($DtRg);

		return _jEnc($_r);

	}

	function GtMnuClDt($p=NULL){

		global $__cnx;

		if(!isN($p['cl'])){ $_fl .= " AND clmnur_cl = ".$p['cl'].""; }
		if(!isN($p['mnu'])){ $_fl .= " AND clmnur_clmnu = ".$p['mnu'].""; }
		if(!isN($p['mnu_enc'])){ $_fl .= " AND clmnur_enc = '".$p['mnu_enc']."'"; }

		$Dt_Qry = "	SELECT *
						FROM "._BdStr(DBM).TB_CL_MNU_R."
						WHERE id_clmnur != '' {$_fl} LIMIT 1";

		$DtRg = $__cnx->_qry($Dt_Qry);

		if($DtRg){
			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;

			if($Tot_DtRg > 0){

				$_r['id'] = $row_DtRg['id_clmnur'];
				$_r['enc'] = $row_DtRg['clmnur_enc'];
				$_r['clr']['fnt'] = ctjTx($row_DtRg['clmnur_clr_fnt'],'in');
				$_r['clr']['bck'] = ctjTx($row_DtRg['clmnur_clr_bck'],'in');

	        }
        }else{
	     	$_r['w'] = $__cnx->c_r->error;
        }

        $__cnx->_clsr($DtRg);

		return _jEnc($_r);

	}

	function GtClLs($p=NULL){

		global $__cnx;

		$_r['e'] = 'no';

		if($p['on']=='ok'){ $_fl .= " AND cl_on = 1"; }
		if($p['rnd']=='ok'){ $_ordby = 'RAND()'; }else{ $_ordby = 'id_cl ASC'; }

		$Dt_Qry = "	SELECT *
					FROM "._BdStr(DBM).TB_CL."
					WHERE id_cl != '' {$_fl}
					ORDER BY {$_ordby}
				";

		$DtRg = $__cnx->_qry($Dt_Qry); //echo compress_code( $Dt_Qry );

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;

			$_r['e'] = 'ok';
			$_r['tot'] = $Tot_DtRg;

			if($Tot_DtRg > 0){

	            do{

					$__cl_img = _ImVrs(['img'=>ctjTx($row_DtRg['cl_img'],'in'), 'f'=>DMN_FLE_CL ]);

					$__enc = $row_DtRg['cl_enc'];

					$_r['ls'][$__enc]['id'] = ctjTx($row_DtRg['id_cl'],'in');
					$_r['ls'][$__enc]['enc'] = ctjTx($row_DtRg['cl_enc'],'in');
					$_r['ls'][$__enc]['nm'] = ctjTx($row_DtRg['cl_nm'],'in');

					if(!isN($row_DtRg['cl_sbd'])){
						$_r['ls'][$__enc]['sbd'] = ctjTx($row_DtRg['cl_sbd'],'in');
						$_r['ls'][$__enc]['bd'] = DB_PRFX_CL.ctjTx($row_DtRg['cl_sbd'],'in');
					}

					$_r['ls'][$__enc]['img'] = $__cl_img;

					$_r['ls'][$__enc]['lgo']['main'] = _ImVrs([ 'img'=>$row_DtRg['cl_enc'].'.svg', 'f'=>DMN_FLE_CL_LGO ]);
					$_r['ls'][$__enc]['lgo']['lght'] = _ImVrs([ 'img'=>$row_DtRg['cl_enc'].'.svg', 'f'=>DMN_FLE_CL_LGO_LGHT ]);
					$_r['ls'][$__enc]['lgo']['ico'] = _ImVrs([ 'img'=>$row_DtRg['cl_enc'].'.ico', 'f'=>DMN_FLE_CL_LGO_ICO ]);


					$_r['ls'][$__enc]['auto']['ec'] = mBln($row_DtRg['cl_auto_ec']);



				} while ($row_DtRg = $DtRg->fetch_assoc());
	        }

        }else{

	        $_r['w'] = $__cnx->c_r->error;

        }

		$__cnx->_clsr($DtRg);

		return _jEnc($_r);

	}

	function GtMnuClLs($p=NULL){

		global $__cnx;

		if(!isN($p['cl'])){ $_fl .= " AND clmnur_cl = ".$p['cl'].""; }
		if(!isN($p['mnu'])){ $_fl .= " AND clmnur_clmnu = ".$p['mnu'].""; }

		$Dt_Qry = "	SELECT *
						FROM "._BdStr(DBM).TB_CL_MNU_R."
							 INNER JOIN "._BdStr(DBM).TB_CL." ON clmnur_cl = id_cl
						WHERE id_clmnur != '' {$_fl}";

		$DtRg = $__cnx->_qry($Dt_Qry);

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;

			$_r['e'] = 'ok';
			$_r['tot'] = $Tot_DtRg;

			if($Tot_DtRg > 0){

	            do{
					$__cl_img = _ImVrs(['img'=>ctjTx($row_DtRg['cl_img'],'in'), 'f'=>DMN_FLE_CL ]);

					$__enc = $row_DtRg['cl_enc'];

					$_r['ls'][$__enc]['r']['id'] = $row_DtRg['id_clmnur'];
					$_r['ls'][$__enc]['r']['enc'] = $row_DtRg['clmnur_enc'];
					$_r['ls'][$__enc]['r']['clr']['fnt'] = ctjTx($row_DtRg['clmnur_clr_fnt'],'in');
					$_r['ls'][$__enc]['r']['clr']['bck'] = ctjTx($row_DtRg['clmnur_clr_bck'],'in');


					$_r['ls'][$__enc]['cl']['id'] = ctjTx($row_DtRg['id_cl'],'in');
					$_r['ls'][$__enc]['cl']['enc'] = ctjTx($row_DtRg['cl_enc'],'in');
					$_r['ls'][$__enc]['cl']['nm'] = ctjTx($row_DtRg['cl_nm'],'in');
					$_r['ls'][$__enc]['cl']['img'] = $__cl_img;

				} while ($row_DtRg = $DtRg->fetch_assoc());
	        }
        }

		$__cnx->_clsr($DtRg);
		return _jEnc($_r);

	}


	function GtClFtpDt($p=NULL){

		global $__cnx;

		$Vl['e'] = 'no';
		$query_DtRg = sprintf("	SELECT *,
										"._QrySisSlcF([ 'als'=>'s', 'als_n'=>'svc' ]).",
										".GtSlc_QryExtra(['t'=>'fld', 'p'=>'tp', 'als'=>'s']).",
										AES_DECRYPT(clftp_pssw, '".ENCRYPT_PASSPHRASE."') AS __pss

								FROM "._BdStr(DBM).TB_CL_FTP."
									 INNER JOIN "._BdStr(DBM).TB_CL_FTP_SVC." ON clftpsvc_clftp = id_clftp
									 ".GtSlc_QryExtra(['t'=>'tb', 'col'=>'clftpsvc_tp', 'als'=>'s'])."
								WHERE id_clftp = %s",
								GtSQLVlStr($p['id'], "int"));

		$DtRg = $__cnx->_qry($query_DtRg);

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;

			if($Tot_DtRg > 0){

				$Vl['e'] = 'ok';
				$Vl['tot'] = $Tot_DtRg;

				do{

					$Vl['id'] = $row_DtRg['id_clftp'];
					$Vl['enc'] = ctjTx($row_DtRgp['clftp_enc'],'in');
					$Vl['cl'] = ctjTx($row_DtRg['clftp_cl'],'in');
					$Vl['nm'] = ctjTx($row_DtRg['clftp_nm'],'in');
					$Vl['hst'] = ctjTx($row_DtRg['clftp_hst'],'in');
					$Vl['prt'] = ctjTx($row_DtRg['clftp_prt'],'in');
					$Vl['tmout'] = ctjTx($row_DtRg['clftp_tmout'],'in');
					$Vl['psv'] = ctjTx($row_DtRg['clftp_psv'],'in');
					$Vl['usr'] = ctjTx($row_DtRg['clftp_usr'],'in');
					$Vl['pssw'] = ctjTx($row_DtRg['__pss'],'in');


					$__cns = $row_DtRg['sisslc_cns'];

					$Vl['svc'][$__cns] = [

						'id'=>$row_DtRg['id_clftpsvc'],
						'enc'=>ctjTx($row_DtRg['clftpsvc_enc'],'in'),
						'pth'=>ctjTx($row_DtRg['clftpsvc_pth'],'in')

					];

				} while ($row_DtRg = $DtRg->fetch_assoc());

			}

		}

		$__cnx->_clsr($DtRg);

		return(_jEnc($Vl));
	}


	function GtClAwsAccLs($p=NULL){

		global $__cnx;

		$Vl['e'] = 'no';

		if(!isN($p['cl'])){

			$Ls_Qry = "

						SELECT *,
								AES_DECRYPT(awsacc_key, '".ENCRYPT_PASSPHRASE."') AS awsacc_key_v,
								AES_DECRYPT(awsacc_scrt, '".ENCRYPT_PASSPHRASE."') AS awsacc_scrt_v
						FROM "._BdStr(DBT).TB_AWS_ACC."
							 INNER JOIN "._BdStr(DBM).TB_CL." ON awsacc_cl = id_cl
						WHERE
							cl_enc='".$p['cl']."'
						ORDER BY id_awsacc DESC
					";

			$Ls_Rg = $__cnx->_qry($Ls_Qry);

			if($Ls_Rg){

				$row_Ls_Rg = $Ls_Rg->fetch_assoc();
				$Tot_Ls_Rg = $Ls_Rg->num_rows;

				$Vl['e'] = 'ok';
				$Vl['tot'] = $Tot_Ls_Rg;

				if($Tot_Ls_Rg > 0){

	                do{
	                    $_id = $row_Ls_Rg['awsacc_enc'];
	                    $Vl['ls'][$_id]['id'] = ctjTx($row_Ls_Rg['id_awsacc'],'in');
						$Vl['ls'][$_id]['enc'] = ctjTx($row_Ls_Rg['awsacc_enc'],'in');
						$Vl['ls'][$_id]['key'] = ctjTx($row_Ls_Rg['awsacc_key_v'],'in');
						$Vl['ls'][$_id]['scrt'] = ctjTx($row_Ls_Rg['awsacc_scrt_v'],'in');
	                } while ($row_Ls_Rg = $Ls_Rg->fetch_assoc());

	            }
	        }

	        $__cnx->_clsr($Ls_Rg);

		}

		return _jEnc($Vl);

	}



	function GtClAwsAccDt($p=NULL){

		global $__cnx;

		$Vl['e'] = 'no';

		if(!isN($p['id'])){

			if($p['t'] == 'enc'){ $__f = 'awsacc_enc'; $__ft = 'text'; }
			else{ $__f = 'id_awsacc'; $__ft = 'int'; }

			$query_DtRg = sprintf("	SELECT id_awsacc, awsacc_enc,
											AES_DECRYPT(awsacc_key, '".ENCRYPT_PASSPHRASE."') AS awsacc_key_v,
											AES_DECRYPT(awsacc_scrt, '".ENCRYPT_PASSPHRASE."') AS awsacc_scrt_v
									FROM "._BdStr(DBT).TB_AWS_ACC."
									WHERE ".$__f." = %s
									LIMIT 1", GtSQLVlStr($p['id'], $__ft));

			$DtRg = $__cnx->_qry($query_DtRg);
			//$Vl['tmp_q'] = $query_DtRg;

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg > 0){

					$Vl['e'] = 'ok';
					$Vl['id'] = $row_DtRg['id_awsacc'];
					$Vl['enc'] = ctjTx($row_DtRg['awsacc_enc'],'in');
					$Vl['key'] = ctjTx($row_DtRg['awsacc_key_v'],'in');
					$Vl['scrt'] = ctjTx($row_DtRg['awsacc_scrt_v'],'in');

				}

			}else{

				$_r['w'] = $__cnx->c_r->error;

			}

			$__cnx->_clsr($DtRg);

		}

		return _jEnc($Vl);

	}



	function GtClGtwyPayLs($p=NULL){

		global $__cnx;

		$Vl['e'] = 'no';

		if(!isN($p['cl'])){

			$Ls_Qry = "

						SELECT id_clgtwypay, clgtwypay_enc, clgtwypay_e,
								"._QrySisSlcF([ 'als'=>'gtwy', 'als_n'=>'gtwy' ]).",
								".GtSlc_QryExtra(['t'=>'fld', 'p'=>'gtwy', 'als'=>'gtwy'])."
						FROM "._BdStr(DBM).TB_CL_GTWY_PAY."
							 INNER JOIN "._BdStr(DBM).TB_CL." ON clgtwypay_cl = id_cl
							 ".GtSlc_QryExtra([ 't'=>'tb', 'col'=>'clgtwypay_gtwy', 'als'=>'gtwy' ])."
						WHERE
							cl_enc='".$p['cl']."'
						ORDER BY id_clgtwypay DESC
					";

			$Ls_Rg = $__cnx->_qry($Ls_Qry);

			if($Ls_Rg){

				$row_Ls_Rg = $Ls_Rg->fetch_assoc();
				$Tot_Ls_Rg = $Ls_Rg->num_rows;

				$Vl['e'] = 'ok';
				$Vl['tot'] = $Tot_Ls_Rg;

				if($Tot_Ls_Rg > 0){

	                do{

						$__attr = json_decode($row_Ls_Rg['___gtwy']);

						foreach($__attr as $__attr_k=>$__attr_v){
							$__gtwy->{$__attr_v->key} = $__attr_v;
						}

	                    $_id = $row_Ls_Rg['clgtwypay_enc'];
	                    $Vl['ls'][$_id]['id'] = ctjTx($row_Ls_Rg['id_clgtwypay'],'in');
						$Vl['ls'][$_id]['enc'] = ctjTx($row_Ls_Rg['clgtwypay_enc'],'in');

						$Vl['ls'][$_id]['tt'] = ctjTx($row_Ls_Rg['gtwy_sisslc_tt'],'in');
						$Vl['ls'][$_id]['img'] = DMN_FLE_SIS_SLC.ctjTx($row_Ls_Rg['gtwy_sisslc_img'],'in');
						$Vl['ls'][$_id]['e'] = mBln($row_Ls_Rg['clgtwypay_e']);
						$Vl['ls'][$_id]['rel'] = ctjTx($row_Ls_Rg['gtwy_sisslc_cns'],'in');

						$Vl['ls'][$_id]['attr'] = $__gtwy;

	                } while ($row_Ls_Rg = $Ls_Rg->fetch_assoc());

	            }
	        }

	        $__cnx->_clsr($Ls_Rg);

		}

		return _jEnc($Vl);

	}



	function GtClGtwyPayDt($p){

		global $__cnx;

		$Vl['e'] = "no";

		if(!isN($p['id'])){

			if($p['t'] == 'enc'){
				$__f = 'clgtwypay_enc'; $__ft = 'text';
			}else{
				$__f = 'id_clgtwypay'; $__ft = 'int';
			}

			$query_DtRg = sprintf("	SELECT *,
											AES_DECRYPT(clgtwypay_sndbx_key, '".ENCRYPT_PASSPHRASE."') AS clgtwypay_sndbx_key,
											AES_DECRYPT(clgtwypay_sndbx_tkn, '".ENCRYPT_PASSPHRASE."') AS clgtwypay_sndbx_tkn,
											AES_DECRYPT(clgtwypay_prd_key, '".ENCRYPT_PASSPHRASE."') AS clgtwypay_prd_key,
											AES_DECRYPT(clgtwypay_prd_tkn, '".ENCRYPT_PASSPHRASE."') AS clgtwypay_prd_tkn,
											"._QrySisSlcF([ 'als'=>'gtwy', 'als_n'=>'gtwy' ]).",
											".GtSlc_QryExtra(['t'=>'fld', 'p'=>'gtwy', 'als'=>'gtwy'])."
									FROM "._BdStr(DBM).TB_CL_GTWY_PAY."
										 ".GtSlc_QryExtra([ 't'=>'tb', 'col'=>'clgtwypay_gtwy', 'als'=>'gtwy' ])."
									WHERE ".$__f." = %s
									LIMIT 1", GtSQLVlStr($p['id'], $__ft));

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				$Vl['tot'] = $Tot_DtRg;

				if($Tot_DtRg > 0){

					$Vl = [
						'id'=>ctjTx($row_DtRg['id_clgtwypay'],'in'),
						'enc'=>ctjTx($row_DtRg['clgtwypay_enc'],'in'),
						'nm'=>ctjTx($row_DtRg['clgtwypay_nm'],'in'),
						'sndbx'=>[
							'e'=>mBln($row_DtRg['clgtwypay_sndbx']),
							'key'=>ctjTx($row_DtRg['clgtwypay_sndbx_key'],'in'),
							'tkn'=>ctjTx($row_DtRg['clgtwypay_sndbx_tkn'],'in')
						],
						'prd'=>[
							'key'=>ctjTx($row_DtRg['clgtwypay_prd_key'],'in'),
							'tkn'=>ctjTx($row_DtRg['clgtwypay_prd_tkn'],'in')
						],
						'url'=>[
							'scss'=>ctjTx($row_DtRg['clgtwypay_url_success'],'in'),
							'flr'=>ctjTx($row_DtRg['clgtwypay_url_failure'],'in'),
							'pndg'=>ctjTx($row_DtRg['clgtwypay_url_pending'],'in')
						],
						'e'=>mBln($row_DtRg['clgtwypay_e']),
						'gtwy'=>[
							'tt'=>ctjTx($row_DtRg['gtwy_sisslc_tt'],'in'),
							'img'=>DMN_FLE_SIS_SLC.ctjTx($row_DtRg['gtwy_sisslc_img'],'in'),
							'e'=>mBln($row_DtRg['clgtwypay_e']),
							'rel'=>ctjTx($row_DtRg['gtwy_sisslc_cns'],'in')
						]
					];

				}

			}

			$__cnx->_clsr($DtRg);
			return _jEnc($Vl);

		}

	}



	function GtClMdlSTpLs($p){

		global $__cnx;

		if(!isN($p['id'])){

			$__f = 'mdlstpcl_cl'; $__ft = 'int';

			$c_DtRg = "-1";if (isset($p['id'])){$c_DtRg = $p['id'];}

			$query_DtRg = sprintf("	SELECT 	id_mdlstp, mdlstp_tp, mdlstp_nm, mdlstpcol_e,
											"._QrySisSlcF([ 'als'=>'c', 'als_n'=>'col' ]).",
											".GtSlc_QryExtra(['t'=>'fld', 'p'=>'col', 'als'=>'c'])."
									FROM "._BdStr(DBM).TB_MDL_S_TP."
										 INNER JOIN "._BdStr(DBM).TB_MDL_S_TP_CL." ON mdlstpcl_mdlstp = id_mdlstp
										 INNER JOIN "._BdStr(DBM).TB_CL." ON id_cl = mdlstpcl_cl
										 LEFT JOIN "._BdStr(DBM).TB_MDL_S_TP_COL." ON (mdlstpcol_cl = id_cl AND mdlstpcol_mdlstp = id_mdlstp)
										 ".GtSlc_QryExtra([ 't'=>'tb', 'col'=>'mdlstpcol_col', 'als'=>'c', 'l'=>'ok' ])."
									WHERE ".$__f." = %s", GtSQLVlStr($c_DtRg, $__ft));

			//echo $query_DtRg.PHP_EOL.PHP_EOL.PHP_EOL.PHP_EOL.PHP_EOL;

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;
				//$Vl['tot'] = $Tot_DtRg;

				if($Tot_DtRg > 0){

					do{

						//echo 'GtSlcF_JAttr:'.PHP_EOL;
						$___col_a = GtSlcF_JAttr($row_DtRg['___col']); //print_r( $___col_a );

						$__id = $row_DtRg['mdlstp_tp'];
						$Vl[$__id]['id'] = $row_DtRg['id_mdlstp'];
						$Vl[$__id]['nm'] = ctjTx($row_DtRg['mdlstp_nm'],'in');

						$__cid = $___col_a->key->vl;
						$Vl[$__id]['col'][ $__cid ]['id'] = ctjTx($row_DtRg['id_mdlstpcol'],'in');

						if(mBln($___col_a->allw->vl) == 'ok' && mBln($row_DtRg['mdlstpcol_e']) == 'ok'){
							$Vl[$__id]['col'][ $__cid ]['allw'] = 'ok';
						}else{
							$Vl[$__id]['col'][ $__cid ]['allw'] = 'no';
						}

					}while($row_DtRg = $DtRg->fetch_assoc());

				}

			}

			$__cnx->_clsr($DtRg);

		}

		return _jEnc($Vl);

	}



?>