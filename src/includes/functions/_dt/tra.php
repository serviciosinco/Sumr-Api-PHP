<?php


	function GtTra_Flds($p=NULL){ // Extend Fields

		$_prvt = $p['prvt'];

		$___v = $p['v'];
		$___clr = json_decode( ctjTx($p['color'],'in','',['html'=>'ok']) );
		$___icn = json_decode( ctjTx($p['icon'],'in','',['html'=>'ok']) );
		$___tp = json_decode( ctjTx($p['tipo'],'in','',['html'=>'ok']) );
		$___rw = $p['rw'];


		$___v['clr']['tmp'][1] = ctjTx($p['color'],'in','',['html'=>'ok']);
		$___v['clr']['tmp'][2] = $___clr;

		if(!is_object($___clr) && !isN($___clr[0])){ $___clr = $___clr[0]; }
		if(!is_object($___icn) && !isN($___icn[0])){ $___icn = $___icn[0]; }
		if(!is_object($___tp) && !isN($___tp[0])){ $___tp = $___tp[0]; }


		if($___rw != ''){

			if($_prvt != 'ok'){ $___v['clr']['id'] = $___clr->id; }
			$___v['clr']['enc'] = $___clr->enc;
			$___v['clr']['vl'] = $___clr->vl;
			$___v['clr']['slc']['id'] = $___rw['color_id_sisslc'];
			$___v['clr']['slc']['enc'] = $___rw['color_sisslc_enc'];
			$___v['clr']['slc']['tt'] = $___rw['color_sisslc_tt'];

			if(!isN($___rw['color_sisslc_img'])){
				$___v['clr']['slc']['img'] = DMN_FLE_SIS_SLC.ctjTx($___rw['color_sisslc_img'],'in');
			}elseif(!isN($___rw['___color_src'])){
				$___v['clr']['slc']['img'] = DMN_FLE_SIS_SLC.ctjTx($___rw['___color_src'],'in');
			}

			if($_prvt != 'ok'){ $___v['icn']['id'] = $___icn->id; }
			$___v['icn']['enc'] = $___icn->enc;
			$___v['icn']['vl'] = $___icn->vl;
			$___v['icn']['slc']['id'] = ctjTx($___rw['icon_id_sisslc'],'in');
			$___v['icn']['slc']['enc'] = ctjTx($___rw['icon_sisslc_enc'],'in');
			$___v['icn']['slc']['tt'] = ctjTx($___rw['icon_sisslc_tt'],'in');


			if($_prvt != 'ok'){ $___v['tp']['id'] = $___tp->id; }
			$___v['tp']['enc'] = $___tp->enc;
			$___v['tp']['vl'] = $___tp->vl;

			$___v['tp']['shwid']['e'] = mBln($___tp->shw_id->e->vl);
			$___v['tp']['slc']['id'] = ctjTx($___rw['tipo_id_sisslc'],'in');
			$___v['tp']['slc']['enc'] = ctjTx($___rw['tipo_sisslc_enc'],'in');
			$___v['tp']['slc']['tt'] = ctjTx($___rw['tipo_sisslc_tt'],'in');

			if(!isN($___rw['color_sisslc_img'])){
				$___v['clr']['slc']['img'] = DMN_FLE_SIS_SLC.ctjTx($___rw['color_sisslc_img'],'in');
			}elseif(!isN($___rw['___color_src'])){
				$___v['clr']['slc']['img'] = DMN_FLE_SIS_SLC.ctjTx($___rw['___color_src'],'in');
			}


			if(!isN($___rw['icon_sisslc_img'])){
				$___v['icn']['slc']['img'] = DMN_FLE_SIS_SLC.ctjTx($___rw['icon_sisslc_img'],'in');
			}elseif(!isN($___rw['___icon_src'])){
				$___v['icn']['slc']['img'] = DMN_FLE_SIS_SLC.ctjTx($___rw['___icon_src'],'in');
			}

		}

		return $___v;
	}


	function GtTraColLsAll($p=NULL){

		global $__cnx;

		$query_DtRg = "SELECT id_tracol, tracol_enc, tracol_tt,

							 "._QrySisSlcF(['als'=>'c', 'als_n'=>'color']).", "._QrySisSlcF(['als'=>'i', 'als_n'=>'icon']).",
							 (SELECT tracolord_ord FROM "._BdStr(DBM).TB_TRA_COL_ORD." WHERE tracolord_us = ".SISUS_ID." ORDER BY tracolord_ord DESC LIMIT 1) AS _ult,
							 ".GtSlc_QryExtra(['t'=>'fld', 'p'=>'icon', 'als'=>'i']).",
							 ".GtSlc_QryExtra(['t'=>'fld', 'p'=>'color', 'als'=>'c'])."

						FROM "._BdStr(DBM).TB_TRA_COL."
							 INNER JOIN "._BdStr(DBM).TB_CL." ON tracol_cl = id_cl
							 LEFT JOIN "._BdStr(DBM).TB_TRA_COL_ORD." ON tracolord_tracol = id_tracol
							 ".GtSlc_QryExtra(['t'=>'tb', 'col'=>'tracol_icn', 'als'=>'i'])."
							 ".GtSlc_QryExtra(['t'=>'tb', 'col'=>'tracol_clr', 'als'=>'c'])."

						WHERE id_tracol != '' AND
						      tracol_enc != '".$p['enc']."' AND
							  tracolord_us = '".SISUS_ID."' AND
							  cl_enc = '".CL_ENC."'

						GROUP BY tracolord_tracol
						ORDER BY tracolord_ord ASC";

		$DtRg = $__cnx->_qry($query_DtRg);


		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;

			$Vl['tot'] = $Tot_DtRg;

			if($Tot_DtRg > 0){
				do{

					$Vl['ls'][$row_DtRg['tracol_enc']]['id']  = $row_DtRg['id_tracol'];
					$Vl['ls'][$row_DtRg['tracol_enc']]['enc'] = $row_DtRg['tracol_enc'];
					$Vl['ls'][$row_DtRg['tracol_enc']]['tt']  = $row_DtRg['tracol_tt'];

				}while($row_DtRg = $DtRg->fetch_assoc());
			}

		}

		$__cnx->_clsr($DtRg);

		return(_jEnc($Vl));

	}


	function GtTraDshColLs($p=NULL){

		global $__cnx;

		$_prvt = $p['prvt'];

		if(!isN($p['flt'])){ $_fl .= $p['flt']; }
		if(!isN($p['lst'])){ $_fl .= sprintf(" AND tracol_fa IS NOT NULL AND tracol_fa > %s ", GtSQLVlStr($p['lst'], 'date')); }

		$_CRM_Cl = new CRM_Cl();
		$_Grp_Col_Prnt = $_CRM_Cl->ClGrpCol_Prnt([ 'us'=>( ( !isN($p['id_us']) )? $p['id_us'] : SISUS_ID ), 'cl_enc'=>$p['cl_enc'] ]);

		if(!isN($_Grp_Col_Prnt->qry)){
			$__tracol_prnt = " AND  ( tracolgrp_grp IN (".$_Grp_Col_Prnt->qry.") ||
									  (/*cl_enc = '".CL_ENC."' ||*/ tracol_chk_pblc = 1)
									) ";
		}

		$query_DtRg = "	SELECT *
						FROM "._BdStr(DBM).VW_TRA_COL."
							 LEFT JOIN "._BdStr(DBM).TB_TRA_COL_ORD." ON (tracolord_tracol = id_tracol AND tracolord_us = ".( ( !isN($p['id_us']) )? $p['id_us'] : SISUS_ID )." )
						WHERE 	(cl_enc = '".CL_ENC."' || tracol_chk_pblc = 1)
								$_fl
								$_fl_us
								$__tracol_prnt
						ORDER BY tracol_chk_pblc ASC, tracolord_ord ASC
					";

		$DtRg = $__cnx->_qry($query_DtRg);
		//$Vl['q'] = compress_code($_Grp_Col_Prnt->q);

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;

			$Vl['tot'] = $Tot_DtRg;
			$Vl['e'] = "ok";

			if($Tot_DtRg > 0){

				do{

					if($p['t_id'] == 'enc'){
						$_icol = $row_DtRg['tracol_enc'];
					}else{
						$_icol = $row_DtRg['id_tracol'];
					}

					if($_prvt != 'ok'){ $Vl['ls'][$_icol]['id'] = $row_DtRg['id_tracol']; }

					$Vl['ls'][$_icol]['enc'] = $row_DtRg['tracol_enc'];
					$Vl['ls'][$_icol]['tt'] = ctjTx($row_DtRg['tracol_tt'],'in');
					$Vl['ls'][$_icol]['ttasd'] = 123;

					if(!isN($row_DtRg['___icon_src'])){
						$Vl['ls'][$_icol]['img'] = DMN_FLE_SIS_SLC.ctjTx($row_DtRg['___icon_src'],'in');
					}

					$Vl['ls'][$_icol]['dsc'] = ctjTx($row_DtRg['tracol_dsc'],'in');

					$Vl['ls'][$_icol] = GtTra_Flds([
											'v'=>$Vl['ls'][$row_DtRg['id_tracol']],
											'color'=>$row_DtRg['___color'],
											'icon'=>$row_DtRg['___icon'],
											'tipo'=>$row_DtRg['___tipo'],
											'rw'=>$row_DtRg,
											'prvt'=>$_prvt
										]);

					$Vl['ls'][$_icol]['ord'] = $row_DtRg['tracolord_ord'];
					$Vl['ls'][$_icol]['qry_tra'] = $row_DtRg['tracolord_ord'];
					$Vl['ls'][$_icol]['chk']['tck'] = $row_DtRg['tracol_chk_tck']; // Tickets Sumr - Helpdesk
					$Vl['ls'][$_icol]['chk']['pqr'] = $row_DtRg['tracol_chk_pqr']; // Tickets PQR - Cliente (Account)
					$Vl['ls'][$_icol]['chk']['pblc'] = $row_DtRg['tracol_chk_pblc'];

				}while($row_DtRg = $DtRg->fetch_assoc());
			}

		}

		$__cnx->_clsr($DtRg);

		return(_jEnc($Vl));

	}


	function GtTraDhsLs($p=NULL){

		global $__cnx;

		$_prvt = $p['prvt'];

		if(!isN($p['flt'])){ $__fl .= $p['flt']; }
		if(!isN($p['lst'])){ $__fl .= sprintf(" AND tracol_fa IS NOT NULL AND tracol_fa > %s ", GtSQLVlStr($p['lst'], 'date')); }
		if(!isN($p['fl_tra'])){ $__fl .= ' '.$p['fl_tra']; }

		if(!_ChckMd('tra_sprvw')){
			$__fl .= " AND trarsp_us = '".SISUS_ID."' ";
		}else{
			$__grp_by = " GROUP BY id_tra";
		}

		$_CRM_Cl = new CRM_Cl();
		$_Grp_Col_Prnt = $_CRM_Cl->ClGrpCol_Prnt([ 'us'=>( ( !isN($p['id_us']) )? $p['id_us'] : SISUS_ID ), 'cl_enc'=>$p['cl_enc'] ]);

		if(!isN($_Grp_Col_Prnt->qry)){
			$__tracol_prnt = " AND  ( tracolgrp_grp IN (".$_Grp_Col_Prnt->qry.") ||
									  (tracol_chk_pblc = 1 AND col_cl_enc = '".CL_ENC."')
									) ";
		}

		if(!ClMain()){ $__fl .= " AND tra_cl_enc='".CL_ENC."' "; }

		$query_DtRg = "SELECT 	".VW_TRA.".*,
								mdlcnttra_mdlcnt, mdlcnt_fi, cnt_nm, cnt_ap, mdl_nm,
								mdlstp_tp, mdlstp_img, tracolord_ord, traord_ord, mdlcnt__attributes
						FROM 	"._BdStr(DBM).VW_TRA."
							 	LEFT JOIN ".VW_TRA_MDL_CNT." ON mdlcnttra_tra = id_tra
							 	LEFT JOIN "._BdStr(DBM).TB_TRA_COL_ORD." ON (tracolord_tracol = id_tracol AND tracolord_us = ".( ( !isN($p['id_us']) )? $p['id_us'] : SISUS_ID )." )
							 	LEFT JOIN "._BdStr(DBM).TB_TRA_ORD." ON (traord_tra = id_tra AND traord_us = ".( ( !isN($p['id_us']) )? $p['id_us'] : SISUS_ID )." )
						WHERE 	(trarsp_tp = '"._CId('ID_USROL_RSP')."' || trarsp_tp = '"._CId('ID_USROL_OBS')."') AND
								(col_cl_enc = '".CL_ENC."' || tracol_chk_pblc = 1) AND
								(mdlcnttra_mdlcnt IS NOT NULL || tracol_chk_pqr = 2)
								$__fl
								$_fl_us
								$__tracol_prnt
						{$__grp_by}
						ORDER BY tracolord_ord ASC, traord_ord ASC
					";

		$DtRg = $__cnx->_qry($query_DtRg);

		$Vl['q'] = compress_code($query_DtRg);

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;

			$Vl['tot'] = $Tot_DtRg;
			$Vl['e'] = "ok";

			if($Tot_DtRg > 0){

				do{

					if($p['t_id'] == 'enc'){
						$_icol = $row_DtRg['tracol_enc'];
					}else{
						$_icol = $row_DtRg['id_tracol'];
					}

					if($_prvt != 'ok'){ $Vl['ls'][$_icol]['id'] = $row_DtRg['id_tracol']; }

					$Vl['ls'][$_icol]['enc'] = $row_DtRg['tracol_enc'];
					$Vl['ls'][$_icol]['tt'] = ctjTx($row_DtRg['tracol_tt'],'in');

					if(!isN($row_DtRg['___icon_src'])){
						$Vl['ls'][$_icol]['img'] = DMN_FLE_SIS_SLC.ctjTx($row_DtRg['___icon_src'],'in');
					}

					$Vl['ls'][$_icol]['dsc'] = ctjTx($row_DtRg['tracol_dsc'],'in');

					$Vl['ls'][$_icol] = GtTra_Flds([
											'v'=>$Vl['ls'][$row_DtRg['id_tracol']],
											'color'=>$row_DtRg['___color'],
											'icon'=>$row_DtRg['___icon'],
											'tipo'=>$row_DtRg['___tipo'],
											'rw'=>$row_DtRg,
											'prvt'=>$_prvt
										]);

					$Vl['ls'][$_icol]['ord'] = $row_DtRg['tracolord_ord'];
					$Vl['ls'][$_icol]['qry_tra'] = $row_DtRg['tracolord_ord'];
					$Vl['ls'][$_icol]['chk']['tck'] = $row_DtRg['tracol_chk_tck']; // Tickets Sumr - Helpdesk
					$Vl['ls'][$_icol]['chk']['pqr'] = $row_DtRg['tracol_chk_pqr']; // Tickets PQR - Cliente (Account)
					$Vl['ls'][$_icol]['chk']['pblc'] = $row_DtRg['tracol_chk_pblc'];

					if(!isN($p) && $p['d']['tra'] == 'ok'){

						if($p['t_id_tra'] == 'enc'){
                            $_id_k = 'tra_enc'; $p['k'] = "enc";
                        }else{
                            $_id_k = 'id_tra'; $p['k'] = "id";
                        }

						if(!isN($_id_k)){ $_itra = $row_DtRg[$_id_k]; }

						if($_prvt!='ok'){
							$Vl['ls'][$_icol]['tra']['ls'][$_itra]['id'] = $row_DtRg['id_tra'];
						}

						$Vl['ls'][$_icol]['tra']['ls'][$_itra]['enc'] = $row_DtRg['tra_enc'];
						$Vl['ls'][$_icol]['tra']['ls'][$_itra]['tt'] = ctjTx($row_DtRg['tra_tt'],'in');
						$Vl['ls'][$_icol]['tra']['ls'][$_itra]['dsc'] = ctjTx($row_DtRg['tra_dsc'],'in','',['sslh'=>'ok']);

						//Orden
						$Vl['ls'][$_icol]['tra']['ls'][$_itra]['ord'] = !isN($row_DtRg['traord_ord'])?$row_DtRg['traord_ord']:1;

						//$Vl[$_itra]['ord'] = $row_DtRg['tra_ord'];

						$Vl['ls'][$_icol]['tra']['ls'][$_itra]['est'] = $row_DtRg['tra_est'];
						$Vl['ls'][$_icol]['tra']['ls'][$_itra]['f'] = $row_DtRg['tra_f'];
						$Vl['ls'][$_icol]['tra']['ls'][$_itra]['h'] = $row_DtRg['tra_h'];
						$Vl['ls'][$_icol]['tra']['ls'][$_itra]['bfr'] = $row_DtRg['tra_bfr'];

						//$Vl[$_itra]['aud'] = $_Crm_Aud->Shw_Aud( [ "key"=>["tra", "tra_col", "tra_cmnt"],  "iddb"=>$row_DtRg['id_tra'], "dbrlc"=>"tra_ctrl" ] );

						$Vl['ls'][$_icol]['tra']['ls'][$_itra]['us'] = ctjTx($row_DtRg['tra_us'],'in');
						$Vl['ls'][$_icol]['tra']['ls'][$_itra]['hra'] = $row_DtRg['tra_h'];

						//$Vl[$_itra]['qryy'] = $query_DtRg;

						if(!isN($row_DtRg['rsp_nm'])){
							//$__rsp_us = GtUsDt($row_DtRg['_rsp']/*,'enc'*/);
							$Vl['ls'][$_icol]['tra']['ls'][$_itra]['rsp']['nm'] = ctjTx($row_DtRg['rsp_nm'],'in');
							$Vl['ls'][$_icol]['tra']['ls'][$_itra]['rsp']['ap'] = ctjTx($row_DtRg['rsp_ap'],'in');
							$Vl['ls'][$_icol]['tra']['ls'][$_itra]['rsp']['sg'] = strtoupper( substr($row_DtRg['rsp_nm'], 0, 1).substr($row_DtRg['rsp_ap'], 0, 1) );

							$_img = GtUsImg([ 'img'=>$row_DtRg['rsp_img'], 'gnr'=>$row_DtRg['rsp_gnr'] ]);
							$Vl['ls'][$_icol]['tra']['ls'][$_itra]['rsp']['img']['th_50'] = $_img->th_50;
						}

						if( $p['dtl'] == 'ok' || isN($p['dtl']) ){

							/*
							$Vl['ls'][$_icol]['tra']['ls'][$_itra]['obs'] = GtTraObsLs([
														'tra'=>$row_DtRg['tra_enc'],
														'us'=>( ( !isN($p['id_us']) )? $p['id_us'] : SISUS_ID ),
														'k'=>'enc',
														'bd'=>$p['bd'],
														'cl_enc'=>$p["cl_enc"],
														'prvt'=>$_prvt
													]);	*/
						}

						$Vl['ls'][$_icol]['tra']['ls'][$_itra]['tot']['cmnt'] = $row_DtRg['_cmnt_count'];
						$Vl['ls'][$_icol]['tra']['ls'][$_itra]['tot']['tag'] = $row_DtRg['_tag_count'];
						$Vl['ls'][$_icol]['tra']['ls'][$_itra]['tot']['ctrl'] = $row_DtRg['_ctrl_count'];
						$Vl['ls'][$_icol]['tra']['ls'][$_itra]['tot']['ctrl_rdy'] = $row_DtRg['_ctrl_rdy'];

						$Vl['ls'][$_icol]['tra']['ls'][$_itra]['fi']['m'] = $row_DtRg['tra_fi'];
						$Vl['ls'][$_icol]['tra']['ls'][$_itra]['fa']['m'] = $row_DtRg['tra_fa'];

						if(!isN($row_DtRg['tra_fi'])){

							$time = new DateTime($row_DtRg['tra_fi']);
							$date = $time->format('Y-m-d');
							$time = $time->format('H:i a');

							if(date('Ymd', strtotime($date)) == date('Ymd', strtotime('yesterday')) ){
								$_fgo = 'Ayer';
							}elseif(date('Ymd', strtotime($date)) == date('Ymd', strtotime('today')) ){
								$_fgo = 'Hoy';
							}else{
								$_fgo = $date;
							}

							$Vl['ls'][$_icol]['tra']['ls'][$_itra]['fi']['d'] = $_fgo;
							$Vl['ls'][$_icol]['tra']['ls'][$_itra]['fi']['h'] = $time;

						}

						if($_prvt!='ok'){
							$Vl['ls'][$_icol]['tra']['ls'][$_itra]['col']['id'] = $row_DtRg['id_tracol'];
						}

						$Vl['ls'][$_icol]['tra']['ls'][$_itra]['col']['enc'] = $row_DtRg['tracol_enc'];

						$Vl['ls'][$_icol]['tra']['ls'][$_itra]['col']['attr'] = GtTra_Flds([
																	'v'=>$Vl['ls'][$_itra]['col'],
																	'color'=>$row_DtRg['___color'],
																	'icon'=>$row_DtRg['___icon'],
																	'rw'=>$row_DtRg
																]);

						/*
						$Vl['ls'][$_icol]['tra']['ls'][$_itra]['tme']['l'] = GtTraTmeRgsDt([ 'tra'=>$row_DtRg['id_tra'], 'us'=>( ( !isN($p['id_us']) )? $p['id_us'] : SISUS_ID ), 'k'=>$p['k'], 'tp'=>'lst' ])->lst;

						if( $p['dtl'] == 'ok' || isN($p['dtl']) ){
							$Vl['ls'][$_icol]['tra']['ls'][$_itra]['tme']['h'] = GtTraTmeRgsDt([ 'tra'=>$row_DtRg['id_tra'], 'k'=>$p['k'] ]);
							$Vl['ls'][$_icol]['tra']['ls'][$_itra]['tme']['u'] = GtTraTmeRgsxUsDt([ 'tra'=>$row_DtRg['id_tra'], 'us'=>( ( !isN($p['id_us']) )? $p['id_us'] : SISUS_ID ), 'k'=>$p['k'] ]);
						}*/

						$Vl['ls'][$_icol]['tra']['ls'][$_itra]['tckid'] = $row_DtRg['id_tra'];

						if(!isN($row_DtRg['mdlcnttra_mdlcnt']) && $row_DtRg['mdlstp_tp'] == 'sac'){
							$Vl['ls'][$_icol]['tra']['ls'][$_itra]['sac']['tckid'] = $row_DtRg['mdlcnttra_mdlcnt'];
						}

						if(!isN($row_DtRg['mdlcnttra_mdlcnt'])){

							$Vl['ls'][$_icol]['tra']['ls'][$_itra]['mdl_cnt']['cnt']['nm'] = ctjTx($row_DtRg['cnt_nm'],'in');
							$Vl['ls'][$_icol]['tra']['ls'][$_itra]['mdl_cnt']['cnt']['ap'] = ctjTx($row_DtRg['cnt_ap'],'in');
							$Vl['ls'][$_icol]['tra']['ls'][$_itra]['mdl_cnt']['mdl']['nm'] = ctjTx($row_DtRg['mdl_nm'],'in');
							$Vl['ls'][$_icol]['tra']['ls'][$_itra]['mdl_cnt']['mdl']['tp']['img'] = _ImVrs(['img'=>ctjTx($row_DtRg['mdlstp_img'],'in'), 'f'=>DMN_FLE_MDL_TP ]);


							$time = new DateTime($row_DtRg['mdlcnt_fi']);
							$date = $time->format('Y-m-d');
							$time = $time->format('H:i a');

							if(date('Ymd', strtotime($date)) == date('Ymd', strtotime('yesterday')) ){
								$_fgo = 'Ayer';
							}elseif(date('Ymd', strtotime($date)) == date('Ymd', strtotime('today')) ){
								$_fgo = 'Hoy';
							}else{
								$_fgo = $date;
							}

							$Vl['ls'][$_icol]['tra']['ls'][$_itra]['mdl_cnt']['f']['d'] = $_fgo;
							$Vl['ls'][$_icol]['tra']['ls'][$_itra]['mdl_cnt']['f']['h'] = $time;
							$Vl['ls'][$_icol]['tra']['ls'][$_itra]['mdl_cnt']['attr_o'] = json_decode(ctjTx($row_DtRg['mdlcnt__attributes'],'in'));

						}

						if(!isN( $row_DtRg['storebrnd_img'] )){
							$_img_brnd = _ImVrs(['img'=>$row_DtRg['storebrnd_img'], 'f'=>DMN_FLE_CL_STORE_BRND ]);
							$Vl['ls'][$_icol]['tra']['ls'][$_itra]['store']['brnd']['id'] = $row_DtRg['id_storebrnd'];
							$Vl['ls'][$_icol]['tra']['ls'][$_itra]['store']['brnd']['img'] = $_img_brnd->th_100;
							$Vl['ls'][$_icol]['tra']['ls'][$_itra]['store']['brnd']['nm'] = ctjTx($row_DtRg['storebrnd_nm'],'in');
						}

						if(ClMain() && mBln($row_DtRg['tracol_chk_tck']) == 'ok' && !isN($row_DtRg['tra_cl_img'])){
							$_img_cl = _ImVrs(['img'=>$row_DtRg['tra_cl_img'], 'f'=>DMN_FLE_CL ]);
							$Vl['ls'][$_icol]['tra']['ls'][$_itra]['cl']['logo'] = $_img_cl->th_100;
						}

						$Vl['ls'][$_icol]['tra']['tot'] = count( $Vl['ls'][$_icol]['tra']['ls'] );

						$VlCtrl[] = $id;
						$VlTag[$_itra] = $id;
						$VlRsp[] = $id;
						$VlCmnt[] = $id;

					}

				}while($row_DtRg = $DtRg->fetch_assoc());
			}

		}

		$__cnx->_clsr($DtRg);

		return(_jEnc($Vl));

    }



	function GtTraColLs($p=NULL){

		global $__cnx;

		$_prvt = $p['prvt'];

		if(!isN($p['flt'])){ $__fl .= $p['flt']; }
		if(!isN($p['lst'])){ $__fl .= sprintf(" AND tracol_fa IS NOT NULL AND tracol_fa > %s ", GtSQLVlStr($p['lst'], 'date')); }

		$_CRM_Cl = new CRM_Cl();
		$_Grp_Col_Prnt = $_CRM_Cl->ClGrpCol_Prnt([ 'us'=>( ( !isN($p['id_us']) )? $p['id_us'] : SISUS_ID ), 'cl_enc'=>$p['cl_enc'] ]);

		if(!isN($_Grp_Col_Prnt->qry)){

			$__tracol_prnt = " AND ( id_tracol IN (
												SELECT tracolgrp_tracol
												FROM "._BdStr(DBM).TB_TRA_COL_GRP."
												WHERE tracolgrp_grp IN (".$_Grp_Col_Prnt->qry.")
											) ||
									  	(
											tracol_chk_pblc = 1 AND
											cl_enc = '".CL_ENC."'
									  	)
									) ";
		}

		$query_DtRg = "SELECT tracol_enc, id_tracol, tracol_tt, tracol_dsc, tracol_chk_tck, tracol_chk_pqr, tracol_chk_pblc,

							 "._QrySisSlcF(['als'=>'c', 'als_n'=>'color']).",
							 "._QrySisSlcF(['als'=>'i', 'als_n'=>'icon']).",
							 "._QrySisSlcF(['als'=>'t', 'als_n'=>'tipo']).",

							 (	SELECT tracolord_ord
							 	FROM "._BdStr(DBM).TB_TRA_COL_ORD."
							 	WHERE tracolord_us = ".( ( !isN($p['id_us']) )? $p['id_us'] : SISUS_ID )."
							 	ORDER BY tracolord_ord DESC LIMIT 1

							 ) AS _ult,

							 (	SELECT COUNT(*)
							 	FROM "._BdStr(DBM).TB_TRA_COL_ORD."
							 	WHERE tracolord_tracol = id_tracol AND tracolord_us = ".( ( !isN($p['id_us']) )? $p['id_us'] : SISUS_ID )."

							 ) AS _ord_tot,

							 ".GtSlc_QryExtra(['t'=>'fld', 'p'=>'icon', 'als'=>'i']).",
							 ".GtSlc_QryExtra(['t'=>'fld', 'p'=>'color', 'als'=>'c']).",
							 ".GtSlc_QryExtra(['t'=>'fld', 'p'=>'tipo', 'als'=>'t'])."

						FROM "._BdStr(DBM).TB_TRA_COL."
							 INNER JOIN "._BdStr(DBM).TB_CL." ON tracol_cl = id_cl
							 LEFT JOIN "._BdStr(DBM).TB_TRA_COL_ORD." ON (tracolord_tracol = id_tracol AND tracolord_us = ".( ( !isN($p['id_us']) )? $p['id_us'] : SISUS_ID )." )
							 ".GtSlc_QryExtra(['t'=>'tb', 'col'=>'tracol_icn', 'als'=>'i'])."
							 ".GtSlc_QryExtra(['t'=>'tb', 'col'=>'tracol_clr', 'als'=>'c'])."
							 ".GtSlc_QryExtra(['t'=>'tb', 'col'=>'tracol_tp', 'als'=>'t'])."

						WHERE 	id_tracol != '' AND
								(cl_enc = '".CL_ENC."' || tracol_chk_pblc = 1)
								$__fl
								$_fl_us
								$__tracol_prnt

						GROUP BY tracolord_tracol
						ORDER BY tracolord_ord ASC";

		$DtRg = $__cnx->_qry($query_DtRg);

		$Vl['q'] = compress_code($query_DtRg);

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;

			$Vl['tot'] = $Tot_DtRg;
			$Vl['e'] = "ok";

			$_CRM_Tra = new CRM_Tra();

			if($Tot_DtRg > 0){

				$_CRM_Tra->tracolord_ord = $row_DtRg['_ult'];

				do{

					if($p['t_id'] == 'enc'){ $__id = $row_DtRg['tracol_enc']; }else{ $__id = $row_DtRg['id_tracol']; }

					if($_prvt != 'ok'){ $Vl['ls'][$__id]['id'] = $row_DtRg['id_tracol']; }

					$Vl['ls'][$__id]['enc'] = $row_DtRg['tracol_enc'];
					$Vl['ls'][$__id]['tt'] = ctjTx($row_DtRg['tracol_tt'],'in');

					if($row_DtRg['i.sisslc_img'] != ''){
						$Vl['ls'][$__id]['img'] = DMN_FLE_SIS_SLC.ctjTx($row_DtRg['i.sisslc_img'],'in');
					}

					$Vl['ls'][$__id]['dsc'] = ctjTx($row_DtRg['tracol_dsc'],'in');

					$Vl['ls'][$__id] = GtTra_Flds([
											'v'=>$Vl['ls'][$row_DtRg['id_tracol']],
											'color'=>$row_DtRg['___color'],
											'icon'=>$row_DtRg['___icon'],
											'tipo'=>$row_DtRg['___tipo'],
											'rw'=>$row_DtRg,
											'prvt'=>$_prvt
										]);

					//Orden
					$GtTraColOrdDt = GtTraColOrdDt([ 'col'=>$row_DtRg['id_tracol'], 'bd'=>$p['bd'] ]);

					$Vl['ls'][$__id]['ord'] = $GtTraColOrdDt->ord;
					$Vl['ls'][$__id]['qry_tra'] = $GtTraColOrdDt->ord;
					$Vl['ls'][$__id]['chk']['tck'] = $row_DtRg['tracol_chk_tck']; // Tickets Sumr - Helpdesk
					$Vl['ls'][$__id]['chk']['pqr'] = $row_DtRg['tracol_chk_pqr']; // Tickets PQR - Cliente (Account)
					$Vl['ls'][$__id]['chk']['pblc'] = $row_DtRg['tracol_chk_pblc'];

					//$Vl['ls'][$__id]['tra_all'] = GtTraLs([ 'k'=>'enc' ]);

					if(!isN($p) && $p['d']['tra'] == 'ok'){

						$Vl['ls'][$__id]['tra'] = GtTraLs([
															'id_tracol'=>$row_DtRg['id_tracol'],
														   	'tracol_enc'=>$row_DtRg['tracol_enc'],
														   	'tracol_clr_id'=>ctjTx($row_DtRg['color_id_sisslc'],'in'),
														   	'tracol_clr_enc'=>ctjTx($row_DtRg['color_sisslc_enc'],'in'),
														   	'tracol_clr_vl'=>ctjTx($___clr->vl,'in'),
														   	'fl'=>$p['fl_tra'],
														   	't_id'=>$p['t_id_tra'],
														   	'bd'=>$p['bd'],
														   	'id_us'=>$p['id_us'],
															"cl_enc"=>$p["cl_enc"],
															'dtl'=>$p["dtl"],
															'prvt'=>$_prvt
														]);
					}


					//Orden de la columna
					if($row_DtRg['_ord_tot'] == 0){

						if($_CRM_Tra->tracolord_ord > 0){
							$_CRM_Tra->tracolord_ord = ($_CRM_Tra->tracolord_ord+1);
						}else{
							$_CRM_Tra->tracolord_ord = 1;
						}

						$_CRM_Tra->In_Tra_Col_Ord([ 'col'=>$row_DtRg['id_tracol'] ]);

					}

					$Vl['ult'] = $row_DtRg['_ult'];

				}while($row_DtRg = $DtRg->fetch_assoc());
			}

		}

		$__cnx->_clsr($DtRg);

		return(_jEnc($Vl));

	}

	function GtTraColDt($p=NULL){

		global $__cnx;

		$_prvt = $p['prvt'];

		if($p['t'] == 'enc'){ $__f = 'tracol_enc'; $__ft = 'text'; }else{ $__f = 'id_tracol'; $__ft = 'int'; $__lmt = ' LIMIT 1'; }

		if(!isN($p['id'])){
			$c_f = sprintf(" AND ".$__f." = %s ", GtSQLVlStr($p['id'], $__ft));
			$__lmt = ' LIMIT 1';
		}else{
			$__ordby = 'ORDER BY tracolord_ord ASC';
		}

		if( $p['noord'] != 'ok' ){
			if(defined('SISUS_ID') && !isN(SISUS_ID)){
				$_s_ult = " (SELECT tracolord_ord FROM "._BdStr(DBM).TB_TRA_COL_ORD." WHERE tracolord_us = ".SISUS_ID." ORDER BY tracolord_ord DESC LIMIT 1) AS _ult, ";
				$_l_join = " LEFT JOIN "._BdStr(DBM).TB_TRA_COL_ORD." ON (tracolord_tracol = id_tracol AND tracolord_us = ".SISUS_ID." ) ";
				if(isN($p['nous'])){ $_f_us = " AND tracolord_us = '".SISUS_ID."' "; }
			}
		}

		$query_DtRg = "	SELECT id_tracol,tracol_enc,tracol_tt,tracol_dsc,
								"._QrySisSlcF(['als'=>'c', 'als_n'=>'color']).",
								"._QrySisSlcF(['als'=>'i', 'als_n'=>'icon']).",
								"._QrySisSlcF(['als'=>'t', 'als_n'=>'tipo']).",
								".GtSlc_QryExtra(['t'=>'fld', 'p'=>'icon', 'als'=>'i']).",
								".GtSlc_QryExtra(['t'=>'fld', 'p'=>'color', 'als'=>'c']).",
								".GtSlc_QryExtra(['t'=>'fld', 'p'=>'tipo', 'als'=>'t']).",
								{$_s_ult}
								(SELECT COUNT(*) FROM "._BdStr(DBM).TB_TRA." WHERE tra_col = id_tracol ) as _tot
						FROM "._BdStr(DBM).TB_TRA_COL."
							 {$_l_join}
							 ".GtSlc_QryExtra(['t'=>'tb', 'col'=>'tracol_icn', 'als'=>'i'])."
							 ".GtSlc_QryExtra(['t'=>'tb', 'col'=>'tracol_clr', 'als'=>'c'])."
							 ".GtSlc_QryExtra(['t'=>'tb', 'col'=>'tracol_tp', 'als'=>'t'])."
						WHERE id_tracol != '' {$c_f} {$_f_us}
						{$__ordby}
						{$__lmt}";

		$DtRg = $__cnx->_qry($query_DtRg);
		$Vl['q'] = compress_code($query_DtRg);

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;

			//$Vl['ids'] = $query_DtRg;

			if($Tot_DtRg > 0){

				if($_prvt != 'ok'){ $Vl['id'] = $row_DtRg['id_tracol']; }

				$Vl['id'] = $row_DtRg['id_tracol'];
				$Vl['enc'] = $row_DtRg['tracol_enc'];
				$Vl['tt'] = ctjTx($row_DtRg['tracol_tt'],'in');
				$Vl['dsc'] = ctjTx($row_DtRg['tracol_dsc'],'in');

				//Orden
				$GtTraColOrdDt = GtTraColOrdDt([ "col"=>$row_DtRg['id_tracol'] ]);
				$Vl['ord'] = $GtTraColOrdDt->ord;

				if(!isN($row_DtRg['_ult'])){
					$Vl['ult'] = $row_DtRg['_ult'];
				}

				$Vl['tra']['tot'] = $row_DtRg['_tot'];

				//$Vl['tra_all'] = GtTraLs([ "k"=>'enc' ]);

				$Vl = GtTra_Flds([
							'v'=>$Vl,
							'color'=>$row_DtRg['___color'],
							'icon'=>$row_DtRg['___icon'],
							'tipo'=>$row_DtRg['___tipo'],
							'rw'=>$row_DtRg
						]);

			}

		}else{

			$Vl['w'] = $__cnx->c_r->error;

		}

		$__cnx->_clsr($DtRg);

		return(_jEnc($Vl));

	}

	function GtTraColOrdDt($p=NULL){

		global $__cnx;

		$query_DtRg = sprintf("	SELECT id_tracolord,tracolord_enc,tracolord_tracol,tracolord_us,tracolord_ord
								FROM "._BdStr(DBM).TB_TRA_COL_ORD."
								WHERE tracolord_tracol = %s AND tracolord_us = %s
								ORDER BY id_tracolord DESC
								LIMIT 1 ",
								GtSQLVlStr($p['col'], 'int'),
								GtSQLVlStr(SISUS_ID, 'int')
							 );

		$DtRg = $__cnx->_qry($query_DtRg);

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;

			if($Tot_DtRg > 0){
				$Vl['id'] = $row_DtRg['id_tracolord'];
				$Vl['enc'] = $row_DtRg['tracolord_enc'];
				$Vl['col'] = $row_DtRg['tracolord_tracol'];
				$Vl['us'] = $row_DtRg['tracolord_us'];
				$Vl['ord'] = $row_DtRg['tracolord_ord'];
			}

		}

		$__cnx->_clsr($DtRg);

		return(_jEnc($Vl));

	}

	function GtTraColUsDt($p=NULL){

		global $__cnx;

		$query_DtRg = sprintf("	SELECT id_tracolus, tracolus_tracol, tracolord_traord
								FROM "._BdStr(DBM).TB_TRA_COL_US."
								WHERE tracolus_tracol = %s AND tracolus_us = %s
								LIMIT 1 ",
								GtSQLVlStr($p['col'], 'int'),
								GtSQLVlStr(SISUS_ID, 'int')
							 );

		$DtRg = $__cnx->_qry($query_DtRg);

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;

			if($Tot_DtRg > 0){
				$Vl['id'] = $row_DtRg['id_tracolus'];
				$Vl['tra_col'] = $row_DtRg['tracolus_tracol'];
				$Vl['tra_ord'] = $row_DtRg['tracolord_traord'];
			}

		}

		$__cnx->_clsr($DtRg);

		return(_jEnc($Vl));

	}

	function GtTraOrdDt($p=NULL){

		global $__cnx;

		if(!isN($p['bd'])){ $_bd = _BdStr($p['bd']); }

		$query_DtRg = sprintf("	SELECT id_traord,traord_enc,traord_tra,traord_us,traord_ord
								FROM "._BdStr(DBM).TB_TRA_ORD."
								WHERE traord_tra = %s AND traord_us = %s
								ORDER BY id_traord DESC
								LIMIT 1 ",
								GtSQLVlStr($p['tra'], 'int'),
								GtSQLVlStr(( ( !isN($p['id_us']) )? $p['id_us'] : SISUS_ID ), 'int')
							 );

		$DtRg = $__cnx->_qry($query_DtRg);
		$row_DtRg = $DtRg->fetch_assoc();
		$Tot_DtRg = $DtRg->num_rows;

		if($Tot_DtRg > 0){

			$Vl['id'] = $row_DtRg['id_traord'];
			$Vl['enc'] = $row_DtRg['traord_enc'];
			$Vl['tra'] = $row_DtRg['traord_tra'];
			$Vl['us'] = $row_DtRg['traord_us'];
			$Vl['ord'] = $row_DtRg['traord_ord'];

		}

		$__cnx->_clsr($DtRg);

		return(_jEnc($Vl));

	}

	function GtTraLs($p=NULL){

		global $__cnx;

		$_prvt = $p['prvt'];

		if(!isN($p['bd'])){ $_bd = _BdStr($p['bd']); }

		if($p['t'] == 'enc'){
			$__fl .= sprintf("AND tra_enc = %s ", GtSQLVlStr($p['id'], 'text') ); $_id = "tra_enc"; $_ctrl_id='enc'; $_cmnt_id='enc'; $_rsp_id='enc';$_tag_id='enc';
		}elseif($p['t'] == 'id'){
			$__fl .= sprintf("AND id_tra = ".$p['id']." ");
			if($p['k'] == 'enc'){
				//Cuando queremos que el key sea el enc de la tarea
				$_id = "tra_enc"; $_ctrl_id='tra_enc'; $_cmnt_id='tra_enc'; $_rsp_id='tra_enc';$_tag_id='tra_enc';
			}else{
				//Cuando queremos que el key sea el id de la tarea
				$_id = "id_tra"; $_ctrl_id='tra'; $_cmnt_id='tra';  $_rsp_id='tra';$_tag_id='tra';
			}
		}else{
			$_id = "id_tra"; $_ctrl_id='tra'; $_cmnt_id='tra'; $_rsp_id='tra';$_tag_id='tra';
		}

		if($p['t'] == 'ord'){ $__fl_ord .= sprintf("AND tra_col = %s ", GtSQLVlStr($p['id'], 'text') );  }
		if($p['id_tracol'] != ''){ $__fl .= "AND tra_col = ".$p['id_tracol']." "; }
		if(!isN($p['lst'])){ $__fl .= sprintf(" AND tra_fa > %s ", GtSQLVlStr($p['lst'], 'date')); }


		$_est_on = [ID_TRAEST_PRC, ID_TRAEST_CMPL];

		if(!isN($_est_on) && $p['est'] != 'no'){
			if(is_array($_est_on)){
				foreach($_est_on as $_est_k=>$_est_v){
					$__fl_est[] = sprintf(" tra_est = %s ", GtSQLVlStr($_est_v, 'text'));
				}
				$__fl .= ' AND ('.implode(' || ', $__fl_est) .') ';
			}else{
				$__fl .= sprintf(" AND tra_est = %s ", GtSQLVlStr($_est_on, 'text'));
			}
		}


		if( !isN($p['tracol_enc']) ){
			$_fl_ord = " AND traord_tra IN ( SELECT id_tra FROM "._BdStr(DBM).TB_TRA." WHERE tra_col IN (SELECT id_tracol FROM "._BdStr(DBM).TB_TRA_COL." WHERE tracol_enc = '".$p['tracol_enc']."') ) ";
		}

		if(!isN($p['fl'])){ $__fl .= $p['fl']; }

		$_Crm_Aud = new CRM_Aud();
		/*if(!ChckSESS_superadm()){*/ $__lmt_cl = " AND cl_1.cl_enc = '".CL_ENC."' "; /*}*/

		if(!_ChckMd('tra_sprvw')){
			$__lmt_usrsp = " AND id_tra IN (SELECT trarsp_tra FROM "._BdStr(DBM).TB_TRA_RSP." WHERE trarsp_us = ".( ( !isN($p['id_us']) )? $p['id_us'] : SISUS_ID ).") ";
		}

		$_CRM_Cl = new CRM_Cl();
		$_Grp_Col_Prnt = $_CRM_Cl->ClGrpCol_Prnt([ 'us'=>( ( !isN($p['id_us']) )? $p['id_us'] : SISUS_ID ), 'cl_enc'=>CL_ENC ]);

		if(!isN($_Grp_Col_Prnt->qry)){

			$__lmt_col = " AND ( id_tracol IN (
												SELECT tracolgrp_tracol
												FROM "._BdStr(DBM).TB_TRA_COL_GRP."
												WHERE tracolgrp_grp IN (".$_Grp_Col_Prnt->qry.")
											) ||
									  (
										  tracol_chk_pblc = 1 AND
										  tracol_cl = '".DB_CL_ID."'
									  )
									) ";
		}

		if(Dvlpr()){
			$__lmt = 700;
		}else{
			$__lmt = 1000;
		}

		$query_DtRg = " SELECT id_tra,tra_enc,tra_tt,tra_dsc,tra_est,tra_f,tra_h,tra_us,tra_h,tra_bfr,tra_fi,tra_fa,id_tracol,tracol_enc,

							"._QrySisSlcF(['als'=>'c', 'als_n'=>'color']).",
							"._QrySisSlcF(['als'=>'i', 'als_n'=>'icon']).",

							".GtSlc_QryExtra(['t'=>'fld', 'p'=>'icon', 'als'=>'i']).",
							".GtSlc_QryExtra(['t'=>'fld', 'p'=>'color', 'als'=>'c']).",

							(SELECT traord_ord FROM "._BdStr(DBM).TB_TRA_ORD." WHERE traord_us = ".( ( !isN($p['id_us']) )? $p['id_us'] : SISUS_ID )." $_fl_ord ORDER BY traord_ord DESC LIMIT 1) AS _ult,
							(SELECT COUNT(*) FROM "._BdStr(DBM).TB_TRA_ORD." WHERE traord_tra = id_tra AND traord_us = ".( ( !isN($p['id_us']) )? $p['id_us'] : SISUS_ID ).") AS _ord_tot,

							_tra_rsp_us.us_nm AS rsp_nm,
							_tra_rsp_us.us_ap AS rsp_ap,
							_tra_rsp_us.us_img AS rsp_img,
							_tra_rsp_us.us_gnr AS rsp_gnr,

							tra_tot_cmnt AS _cmnt_count,
							tra_tot_tag AS _tag_count,
							tra_tot_ctrl AS _ctrl_count,
							tra_tot_ctrl_rdy AS _ctrl_rdy,

							_mdl_cnt.mdlcnttra_mdlcnt AS _mdl_cnt,
							id_storebrnd, storebrnd_nm, storebrnd_img

					    FROM  "._BdStr(DBM).TB_TRA."
							  INNER JOIN "._BdStr(DBM).TB_CL." AS cl_1 ON tra_cl = cl_1.id_cl
							  LEFT JOIN "._BdStr(DBM).TB_TRA_COL." ON tra_col = id_tracol
							  LEFT JOIN "._BdStr(DBM).TB_CL." AS cl_2 ON tracol_cl = cl_2.id_cl
					    	  LEFT JOIN "._BdStr(DBM).TB_TRA_ORD." ON (traord_tra = id_tra AND traord_us = ".SISUS_ID.")
							  LEFT JOIN "._BdStr(DBS).TB_STORE_BRND." ON tra_sbrnd = id_storebrnd


							  LEFT JOIN "._BdStr(DBM).TB_TRA_RSP." AS _tra_rsp ON (trarsp_tra = id_tra AND trarsp_tp = '"._CId('ID_USROL_RSP')."')
							  LEFT JOIN "._BdStr(DBM).TB_US." AS _tra_rsp_us ON _tra_rsp.trarsp_us = id_us
							  LEFT JOIN "._BdStr($_bd).TB_MDL_CNT_TRA." AS _mdl_cnt ON _mdl_cnt.mdlcnttra_tra = id_tra

					    	  ".GtSlc_QryExtra(['t'=>'tb', 'l'=>'ok', 'col'=>'tracol_icn', 'als'=>'i'])."
							  ".GtSlc_QryExtra(['t'=>'tb', 'l'=>'ok', 'col'=>'tracol_clr', 'als'=>'c'])."

					    WHERE 	id_tra != '' AND
					    		cl_2.cl_enc = '".CL_ENC."'
					    		$__lmt_usrsp
								$__lmt_cl
								$__lmt_col
								$__fl
						ORDER BY traord_ord ASC
						LIMIT {$__lmt}";

		//$Vl["q"] = compress_code($query_DtRg);
		$DtRg = $__cnx->_qry($query_DtRg);

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;

			$Vl['tot'] = $Tot_DtRg;

			if($Tot_DtRg > 0){

				$_CRM_Tra = new CRM_Tra();
				$_CRM_Tra->traord_ord = $row_DtRg['_ult'];

				do{
					$___datprcs[]=$row_DtRg;
				}while($row_DtRg = $DtRg->fetch_assoc());

				$__cnx->_clsr($DtRg);


				foreach($___datprcs as $___datprcs_k=>$___datprcs_v){

					if(!isN($___datprcs_v['id_tra']) && !isN($___datprcs_v['id_tra'])){

						if($p['t_id'] == 'enc'){ $_id_k = 'tra_enc'; $p['k'] = "enc"; }else{ $_id_k = 'id_tra'; $p['k'] = "id"; }
						if(!isN($_id_k)){ $id = $___datprcs_v[$_id_k]; }

						if($_prvt!='ok'){ $Vl['ls'][$id]['id'] = $___datprcs_v['id_tra']; }

						$Vl['ls'][$id]['enc'] = $___datprcs_v['tra_enc'];
						$Vl['ls'][$id]['tt'] = ctjTx($___datprcs_v['tra_tt'],'in');
						$Vl['ls'][$id]['dsc'] = ctjTx($___datprcs_v['tra_dsc'],'in','',['sslh'=>'ok']);

						$Vl['ls'][$id]['tckid'] = $___datprcs_v['id_tra'];


						//Orden
						$GtTraOrdDt = GtTraOrdDt([ 'tra'=>$___datprcs_v['id_tra'], 'bd'=>$p['bd'] ]);
						$Vl['ls'][$id]['ord'] = $GtTraOrdDt->ord;

						//$Vl[$id]['ord'] = $___datprcs_v['tra_ord'];

						$Vl['ls'][$id]['est'] = $___datprcs_v['tra_est'];
						$Vl['ls'][$id]['f'] = $___datprcs_v['tra_f'];
						$Vl['ls'][$id]['h'] = $___datprcs_v['tra_h'];
						$Vl['ls'][$id]['bfr'] = $___datprcs_v['tra_bfr'];

						//$Vl[$id]['aud'] = $_Crm_Aud->Shw_Aud( [ "key"=>["tra", "tra_col", "tra_cmnt"],  "iddb"=>$___datprcs_v['id_tra'], "dbrlc"=>"tra_ctrl" ] );

						$Vl['ls'][$id]['us'] = ctjTx($___datprcs_v['tra_us'],'in');
						$Vl['ls'][$id]['hra'] = $___datprcs_v['tra_h'];

						//$Vl[$id]['qryy'] = $query_DtRg;

						if(!isN($___datprcs_v['rsp_nm'])){
							//$__rsp_us = GtUsDt($___datprcs_v['_rsp']/*,'enc'*/);
							$Vl['ls'][$id]['rsp']['nm'] = ctjTx($___datprcs_v['rsp_nm'],'in');
							$Vl['ls'][$id]['rsp']['ap'] = ctjTx($___datprcs_v['rsp_ap'],'in');
							$Vl['ls'][$id]['rsp']['sg'] = strtoupper( substr($___datprcs_v['rsp_nm'], 0, 1).substr($___datprcs_v['rsp_ap'], 0, 1) );

							$_img = GtUsImg([ 'img'=>$___datprcs_v['rsp_img'], 'gnr'=>$___datprcs_v['rsp_gnr'] ]);
							$Vl['ls'][$id]['rsp']['img']['th_50'] = $_img->th_50;
						}

						if( $p['dtl'] == 'ok' || isN($p['dtl']) ){

							$Vl['ls'][$id]['obs'] = GtTraObsLs([
														'tra'=>$___datprcs_v['tra_enc'],
														'us'=>( ( !isN($p['id_us']) )? $p['id_us'] : SISUS_ID ),
														'k'=>'enc',
														'bd'=>$p['bd'],
														'cl_enc'=>$p["cl_enc"],
														'prvt'=>$_prvt
													]);
						}

						$Vl['ls'][$id]['tot']['cmnt'] = $___datprcs_v['_cmnt_count'];
						$Vl['ls'][$id]['tot']['tag'] = $___datprcs_v['_tag_count'];
						$Vl['ls'][$id]['tot']['ctrl'] = $___datprcs_v['_ctrl_count'];
						$Vl['ls'][$id]['tot']['ctrl_rdy'] = $___datprcs_v['_ctrl_rdy'];

						$Vl['ls'][$id]['fi'] = $___datprcs_v['tra_fi'];
						$Vl['ls'][$id]['fa'] = $___datprcs_v['tra_fa'];


						if($_prvt!='ok'){ $Vl['ls'][$id]['col']['id'] = $___datprcs_v['id_tracol']; }
						$Vl['ls'][$id]['col']['enc'] = $___datprcs_v['tracol_enc'];

						$Vl['ls'][$id]['col']['attr'] = GtTra_Flds([
																	'v'=>$Vl['ls'][$id]['col'],
																	'color'=>$___datprcs_v['___color'],
																	'icon'=>$___datprcs_v['___icon'],
																	'rw'=>$row_DtRg
																]);


						//$Vl['ls'][$id]['us_est'] = GtTraUsEstLs( ["tra"=>$___datprcs_v['tra_enc']] );

						//$Vl['ls'][$id]['p'] = $p; Ver que viene en P

						$Vl['ls'][$id]['tme']['l'] = GtTraTmeRgsDt([ 'tra'=>$___datprcs_v['id_tra'], 'us'=>( ( !isN($p['id_us']) )? $p['id_us'] : SISUS_ID ), 'k'=>$p['k'], 'tp'=>'lst' ])->lst;

						if( $p['dtl'] == 'ok' || isN($p['dtl']) ){
							$Vl['ls'][$id]['tme']['h'] = GtTraTmeRgsDt([ 'tra'=>$___datprcs_v['id_tra'], 'k'=>$p['k'] ]);
							$Vl['ls'][$id]['tme']['u'] = GtTraTmeRgsxUsDt([ 'tra'=>$___datprcs_v['id_tra'], 'us'=>( ( !isN($p['id_us']) )? $p['id_us'] : SISUS_ID ), 'k'=>$p['k'] ]);
						}

						//$Vl['ls'][$id]['obs'] = GtTraObsLs( ["tra"=>$___datprcs_v['tra_enc'], "us"=>SISUS_ID, "k"=>$p['k']] );

						if(!isN($___datprcs_v['_mdl_cnt'])){

							$Vl['ls'][$id]['mdl_cnt'] = $_mdlcnt = GtMdlCntDt([ 'id'=>$___datprcs_v['_mdl_cnt'], 'shw'=>['attr'=>'ok'] ]);

							if($_mdlcnt->mdl->tp->key == 'sac'){
								$Vl['ls'][$id]['sac']['tckid'] = $___datprcs_v['_mdl_cnt'];
							}
						}

						if(!isN( $___datprcs_v['storebrnd_img'] )){
							$_img_brnd = _ImVrs(['img'=>$___datprcs_v['storebrnd_img'], 'f'=>DMN_FLE_CL_STORE_BRND ]);
							$Vl['ls'][$id]['store']['brnd']['id'] = $___datprcs_v['id_storebrnd'];
							$Vl['ls'][$id]['store']['brnd']['img'] = $_img_brnd->th_100;
							$Vl['ls'][$id]['store']['brnd']['nm'] = ctjTx($___datprcs_v['storebrnd_nm'],'in');
						}

						if(!isN($___datprcs_v['_ult']) || !isN($___datprcs_v['_ult'])){ $Vl['ult'] = $___datprcs_v['_ult']; }

						$VlCtrl[] = $id;
						$VlTag[$id] = $id;
						$VlRsp[] = $id;
						$VlCmnt[] = $id;

						if($___datprcs_v['_ord_tot'] == 0){
							if($_CRM_Tra->traord_ord > 0){
								$_CRM_Tra->traord_ord = ($_CRM_Tra->traord_ord+1);
							}else{
								$_CRM_Tra->traord_ord = 1;
							}
							$_CRM_Tra->In_Tra_Ord([ 'tra'=>$___datprcs_v['id_tra'] ]);
						}

					}

				}


				if($p['t'] != 'ord'){
					/*Version Anterior - $Vl[$v->{$_ctrl_id}]['ctrl'][$v->enc]['ord'] = $v->ord;*/
					if( $p['dtl'] == 'ok' || isN($p['dtl']) ){
						foreach($VlCtrl as $_v_ctrl){
							$Tra_Ls = GtTraCtrlLs(["id_tra"=>$_v_ctrl, "t"=>"tra", "k"=>$p['k']]);
							foreach($Tra_Ls->ls as $k => $v){
								if(!isN($v->enc) && !isN($v->enc)){
									$Vl['ls'][$v->tra_enc]['ctrl'][$v->enc]['tt'] = $v->tt;
									$Vl['ls'][$v->tra_enc]['ctrl'][$v->enc]['enc'] = $v->enc;
									$Vl['ls'][$v->tra_enc]['ctrl'][$v->enc]['est'] = $v->est;
									$Vl['ls'][$v->tra_enc]['ctrl'][$v->enc]['ord'] = $v->ord;
								}
							}
						}
					}

					foreach($VlTag as $_v_tag){

						$TraTag_Ls = GtTraTag_Ls([ 'id'=>$_v_tag, 'tp'=>$p['k'] ]);

						if(!isN( $TraTag_Ls->ls )){
							foreach($TraTag_Ls->ls as $k_tag => $v_tag){

								if(!isN($v_tag->enc) && !isN($v_tag->enc)){
									//$Vl['ls'][$v_tag->tra_enc]['tag'][$v_tag->enc]['id'] = $v_tag->id;
									$Vl['ls'][$v_tag->tra->enc]['tag']['ls'][$v_tag->enc]['enc'] = $v_tag->enc;
									$Vl['ls'][$v_tag->tra->enc]['tag']['ls'][$v_tag->enc]['tra'] = $v_tag->tra;
									$Vl['ls'][$v_tag->tra->enc]['tag']['ls'][$v_tag->enc]['tag'] = $v_tag->tag;
									$Vl['ls'][$v_tag->tra->enc]['tag']['ls'][$v_tag->enc]['nm'] = $v_tag->nm;
									$Vl['ls'][$v_tag->tra->enc]['tag']['ls'][$v_tag->enc]['clr'] = $v_tag->clr;
									$Vl['ls'][$v_tag->tra->enc]['tag']['tot']++;
								}
							}
						}
					}

					if( $p['dtl'] == 'ok' || isN($p['dtl']) ){
						foreach($VlCmnt as $_v_cmnt){
							$TraCmnt_Ls = GtTraCmntLs(["id_tra"=>$_v_cmnt, "t"=>"tra", "k"=>$p['k']]);
							foreach($TraCmnt_Ls as $k_cmnt => $v_cmnt){
								if(!isN($v_cmnt->enc) && !isN($v_cmnt->enc)){
									$Vl['ls'][$v_cmnt->tra_enc]['cmnt'][$v_cmnt->enc]['tt'] = $v_cmnt->tt;
									$Vl['ls'][$v_cmnt->tra_enc]['cmnt'][$v_cmnt->enc]['enc'] = $v_cmnt->enc;
									$Vl['ls'][$v_cmnt->tra_enc]['cmnt'][$v_cmnt->enc]['us'] = $v_cmnt->us;
									$Vl['ls'][$v_cmnt->tra_enc]['cmnt'][$v_cmnt->enc]['fi'] = $v_cmnt->fi;
									$Vl['ls'][$v_cmnt->tra_enc]['cmnt'][$v_cmnt->enc]['fa'] = $v_cmnt->fa;
									$Vl['ls'][$v_cmnt->tra_enc]['cmnt'][$v_cmnt->enc]['_us_nm'] = $v_cmnt->us_nm;
									$Vl['ls'][$v_cmnt->tra_enc]['cmnt'][$v_cmnt->enc]['us_img'] = $v_cmnt->us_img;
								}
							}
						}
					}



				}
			}

		}else{

			$Vl['w'] = $__cnx->c_r->error;

		}

		return(_jEnc($Vl));

	}

	function GtTraRspDt($p=NULL){

		global $__cnx;

		$_id_tra = implode(",",$p['id_tra']);

		if($p['tp'] == 'rsp'  ){
			$__fl .= " AND  trarsp_tp = "._CId('ID_USROL_RSP')." ";
		}elseif($p['tp'] == "obs"  ){
			$__fl .= " AND  trarsp_tp = "._CId('ID_USROL_OBS')." ";
		}

		if($p['t'] == 'tra'){
			if($p['k'] == "enc"){
				//Cuando viene una tarea con el tra_enc
				$__fl .= "AND trarsp_tra IN (SELECT id_tra FROM "._BdStr(DBM).TB_TRA." WHERE tra_enc = '".$p['id_tra']."') ";
			}elseif(!isN($_id_tra)){
				//Cuando vienen varias tareas con el id_tra
				$__fl .= "AND trarsp_tra IN ($_id_tra) ";
			}
		}

		if( !isN($p['us']) ){

			$__fl .= " AND trarsp_us IN ( SELECT id_us FROM "._BdStr(DBM).TB_US." WHERE us_enc = '".$p['us']."' ) ";
		}

		$query_DtRg = "	SELECT id_trarsp,trarsp_enc,trarsp_us_asg,trarsp_tp,trarsp_dsc,trarsp_fi,trarsp_us,trarsp_tra,tra_enc,id_us,us_nm,us_ap,us_img,us_enc
						FROM "._BdStr(DBM).TB_TRA_RSP."
							 INNER JOIN "._BdStr(DBM).TB_TRA." ON trarsp_tra = id_tra
							 INNER JOIN "._BdStr(DBM).TB_US." ON trarsp_us = id_us
						WHERE  id_trarsp != '' $__fl
						ORDER BY id_trarsp ASC $__fl_lmt";

		$DtRg = $__cnx->_qry($query_DtRg);

		if($DtRg){

			$Vl['e'] = "ok";

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;

			$Vl['tot'] = $Tot_DtRg;

			if($Tot_DtRg > 0){

				do{

					if(!isN($row_DtRg['id_trarsp'])){

						$Vl['ls'][$row_DtRg['id_trarsp']]['id'] = $row_DtRg['id_trarsp'];
						$Vl['ls'][$row_DtRg['id_trarsp']]['us_id'] = $row_DtRg['id_us'];
						$Vl['ls'][$row_DtRg['id_trarsp']]['us_enc'] = $row_DtRg['us_enc'];
						$Vl['ls'][$row_DtRg['id_trarsp']]['us_nm'] = $row_DtRg['us_nm'];
						$Vl['ls'][$row_DtRg['id_trarsp']]['us_ap'] = $row_DtRg['us_ap'];

						$Vl['id'] = $row_DtRg['id_trarsp'];
						$Vl[$row_DtRg['id_trarsp']]['enc'] = $row_DtRg['trarsp_enc'];

						$Vl['us_asg'] = $row_DtRg['trarsp_us_asg'];
						$Vl['tra']['id'] = $row_DtRg['trarsp_tra'];
						$Vl['tra']['enc'] = $row_DtRg['tra_enc'];
						$Vl['tp'] = $row_DtRg['trarsp_tp'];
						$Vl['dsc'] = $row_DtRg['trarsp_dsc'];
						$Vl['fi'] = $row_DtRg['trarsp_fi'];

						$Vl['us'] = $row_DtRg['trarsp_us'];
						$Vl['us_nm'] = $row_DtRg['us_nm'];
						$Vl['us_ap'] = $row_DtRg['us_ap'];
						$Vl['us_img'] = $row_DtRg['us_img'];

					}

				}while($row_DtRg = $DtRg->fetch_assoc());

			}else{
				$Vl['e'] = "no";
			}
		}


		$__cnx->_clsr($DtRg);

		return(_jEnc($Vl));

	}





	function GtTraRspLs($p=NULL){

		global $__cnx;

		if($p['t'] == 'tra'){
			if($p['k'] == 'enc'){
				//Cuando viene una tarea con el tra_enc
				$__fl .= "AND trarsp_tra IN (SELECT id_tra FROM "._BdStr(DBM).TB_TRA." WHERE tra_enc = '".$p['tra']."') ";
			}else{
				//Cuando vienen varias tareas con el id_tra
				$__fl .= "AND trarsp_tra = '".$p['tra']."' ";
			}
		}
		//$_sb_Qry = ", ( SELECT us_nm FROM "._BdStr(DBM).TB_US." WHERE id_us = trarsp_us) as _us_nm, ( SELECT us_ap FROM "._BdStr(DBM).TB_US." WHERE id_us = trarsp_us) as _us_ap,( SELECT us_img FROM "._BdStr(DBM).TB_US." WHERE id_us = trarsp_us ) as _us_img";

		$query_DtRg = "	SELECT 	id_trarsp,trarsp_enc,trarsp_us_asg,trarsp_tra,
								trarsp_tp,trarsp_dsc,trarsp_fi,trarsp_us,
								us_enc, us_nm, us_ap, us_img, tra_enc
						FROM "._BdStr(DBM).TB_TRA_RSP."
							 INNER JOIN "._BdStr(DBM).TB_US." ON trarsp_us=id_us
							 INNER JOIN "._BdStr(DBM).TB_TRA." ON trarsp_tra=id_tra
						WHERE  id_trarsp != '' $__fl
						ORDER BY id_trarsp ASC $__fl_lmt";

		if($p['cmmt']=='ok'){ //-- If use it on commit process --//
			$DtRg = $__cnx->_prc($query_DtRg);
		}else{
			$DtRg = $__cnx->_qry($query_DtRg);
		}

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;

			$Vl['tot'] = $Tot_DtRg;

			do{

				if(!isN($row_DtRg['id_trarsp']) && !isN($row_DtRg['id_trarsp'])){

					$Vl['ls'][$row_DtRg['id_trarsp']]['id'] = $row_DtRg['id_trarsp'];
					$Vl['ls'][$row_DtRg['id_trarsp']]['enc'] = $row_DtRg['trarsp_enc'];

					$Vl['ls'][$row_DtRg['id_trarsp']]['asg']['id'] = $row_DtRg['trarsp_us_asg'];

					$Vl['ls'][$row_DtRg['id_trarsp']]['tp'] = $row_DtRg['trarsp_tp'];
					$Vl['ls'][$row_DtRg['id_trarsp']]['dsc'] = $row_DtRg['trarsp_dsc'];
					$Vl['ls'][$row_DtRg['id_trarsp']]['fi'] = $row_DtRg['trarsp_fi'];

					$Vl['ls'][$row_DtRg['id_trarsp']]['us']['id'] = $row_DtRg['trarsp_us'];
					$Vl['ls'][$row_DtRg['id_trarsp']]['us']['enc'] = $row_DtRg['us_enc'];
					$Vl['ls'][$row_DtRg['id_trarsp']]['us']['nm'] = $row_DtRg['us_nm'];
					$Vl['ls'][$row_DtRg['id_trarsp']]['us']['ap'] = $row_DtRg['us_ap'];
					$Vl['ls'][$row_DtRg['id_trarsp']]['us']['img'] = $row_DtRg['us_img'];

					$Vl['ls'][$row_DtRg['id_trarsp']]['tra']['id'] = $row_DtRg['trarsp_tra'];
					$Vl['ls'][$row_DtRg['id_trarsp']]['tra']['enc'] = $row_DtRg['tra_enc'];

					//$Vl['id'] = $row_DtRg['id_trarsp'];

				}

			}while($row_DtRg = $DtRg->fetch_assoc());

		}

		$__cnx->_clsr($DtRg);

		return(_jEnc($Vl));

	}

	function GtTraUs($p=NULL){

		global $__cnx;

		$_id_tra = implode(",",$p['id_tra']);

		if($p['t'] == 'tra'){
			if($p['k'] == "rsp"){
				$__fl .= "AND id_us = trarsp_us ";
			}
		}

		$query_DtRg = "	SELECT id_us,us_enc,us_user,us_nm,us_ap
						FROM "._BdStr(DBM).TB_US."
						WHERE id_us != '' $__fl ";

		$DtRg = $__cnx->_qry($query_DtRg);

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;

			if($Tot_DtRg > 0){

				do{

					$Vl[$row_DtRg[$_id]]['id'] = $row_DtRg['id_us'];
					$Vl[$row_DtRg[$_id]]['enc'] = $row_DtRg['us_enc'];
					$Vl[$row_DtRg[$_id]]['user'] = $row_DtRg['us_user'];
					$Vl[$row_DtRg[$_id]]['nm'] = $row_DtRg['us_nm'];
					$Vl[$row_DtRg[$_id]]['ap'] = $row_DtRg['us_ap'];

				}while($row_DtRg = $DtRg->fetch_assoc());

			}

		}

		$__cnx->_clsr($DtRg);

		return(_jEnc($Vl));

	}

	function GtTraCmntLs($p=NULL){

		global $__cnx;

		$_id_tra = implode(",",$p['id_tra']);

		if($p['t'] == 'tra'){
			if($p['k'] == "enc"){
				//Cuando viene una tarea con el tra_enc
				$__fl .= "AND tracmnt_tra IN (SELECT id_tra FROM "._BdStr(DBM).TB_TRA." WHERE tra_enc = '".$p['id_tra']."') ";
			}elseif(!isN($_id_tra)){
				//Cuando vienen varias tareas con el id_tra
				$__fl .= "AND tracmnt_tra IN ($_id_tra) ";
			}
		}

		$_sb_Qry = ", ( SELECT CONCAT(us_nm,' ',us_ap) FROM "._BdStr(DBM).TB_US." WHERE id_us = tracmnt_us ) as _us_nm, ( SELECT us_img FROM "._BdStr(DBM).TB_US." WHERE id_us = tracmnt_us ) as _us_img";

		$query_DtRg = "	SELECT id_tracmnt,tracmnt_enc,tracmnt_tt,tracmnt_us,tracmnt_fi,tracmnt_fa,tracmnt_tra,tra_enc $_sb_Qry
						FROM "._BdStr(DBM).TB_TRA_CMNT."
							 INNER JOIN "._BdStr(DBM).TB_TRA." ON tracmnt_tra = id_tra
						WHERE id_tracmnt != '' $__fl
						ORDER BY id_tracmnt ASC $__fl_lmt";

		$DtRg = $__cnx->_qry($query_DtRg);

		//$Vl['q'] = compress_code($query_DtRg);

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;
			$Vl['tot'] = $Tot_DtRg;

			if($Tot_DtRg > 0){

				do{

					if(!isN($row_DtRg['id_tracmnt']) && !isN($row_DtRg['id_tracmnt'])){

						$Vl['ls'][$row_DtRg['id_tracmnt']]['id'] = $row_DtRg['id_tracmnt'];
						//$Vl['ls'][$row_DtRg['id_tracmnt']]['qry'] = $query_DtRg;
						$Vl['ls'][$row_DtRg['id_tracmnt']]['enc'] = $row_DtRg['tracmnt_enc'];
						$Vl['ls'][$row_DtRg['id_tracmnt']]['tt'] = ctjTx($row_DtRg['tracmnt_tt'], 'in');
						$Vl['ls'][$row_DtRg['id_tracmnt']]['us'] = $row_DtRg['tracmnt_us'];
						$Vl['ls'][$row_DtRg['id_tracmnt']]['us_nm'] = $row_DtRg['_us_nm'];
						$Vl['ls'][$row_DtRg['id_tracmnt']]['us_img'] = $row_DtRg['_us_img'];
						$Vl['ls'][$row_DtRg['id_tracmnt']]['fi'] = $row_DtRg['tracmnt_fi'];
						$Vl['ls'][$row_DtRg['id_tracmnt']]['fa'] = $row_DtRg['tracmnt_fa'];
						$Vl['ls'][$row_DtRg['id_tracmnt']]['tra']['id'] = $row_DtRg['tracmnt_tra'];
						$Vl['ls'][$row_DtRg['id_tracmnt']]['tra']['enc'] = $row_DtRg['tra_enc'];
						//$Vl['id'] = $row_DtRg['id_tracmnt'];

					}

				}while($row_DtRg = $DtRg->fetch_assoc());

			}

		}


		$__cnx->_clsr($DtRg);

		return(_jEnc($Vl));

	}




	function GtTraCmntLast($p=NULL){

		global $__cnx;

		if(!isN($p['id'])){

			$query_DtRg = "	SELECT id_tracmnt,tracmnt_tt,us_nm,us_ap,us_img,tracmnt_fi
							FROM "._BdStr(DBM).TB_TRA_CMNT."
								INNER JOIN "._BdStr(DBM).TB_TRA." ON tracmnt_tra = id_tra
								INNER JOIN "._BdStr(DBM).TB_US." ON tracmnt_us = id_us
							WHERE id_tracmnt != '' AND id_tra='".$p['id']."'
							ORDER BY tracmnt_fi DESC
							LIMIT 1";

			$DtRg = $__cnx->_qry($query_DtRg);

			//$Vl['q'] = compress_code($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg > 0){
					$Vl['tt'] = ctjTx($row_DtRg['tracmnt_tt'], 'in');
					$Vl['us']['nm'] = ctjTx($row_DtRg['us_nm'].' '.$row_DtRg['us_ap'],'in');
					$Vl['us']['img'] = _ImVrs(['img'=>ctjTx($row_DtRg['us_img'],'in'), 'f'=>DMN_FLE_US ]);
					$Vl['fi'] = $row_DtRg['tracmnt_fi'];
				}

			}


			$__cnx->_clsr($DtRg);

		}

		return(_jEnc($Vl));

	}

	function GtTraCtrlDt($p=NULL){

		global $__cnx;

		if(!isN($p['id']) && !isN($p['tp'])){

			if($p['tp'] == 'enc'){ $__f = 'tractrl_enc'; $__ft = 'text'; }
			elseif($p['tp'] == 'id'){ $__f = 'id_tractrl'; $__ft = 'text'; }

			$query_DtRg = sprintf("	SELECT id_tractrl,tractrl_enc,tractrl_tt,tractrl_est,tractrl_ord,tractrl_tra,tra_enc
									FROM "._BdStr(DBM).TB_TRA_CTRL."
										INNER JOIN "._BdStr(DBM).TB_TRA." ON tractrl_tra = id_tra
									WHERE id_tractrl != '' '.$__f.'=%s
									LIMIT 1",
									GtSQLVlStr($p['id'], $__ft)
								);

			//echo  $query_DtRg; exit();

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;
				$Vl['tot'] = $Tot_DtRg;

				if($Tot_DtRg > 0){
					$Vl['id'] = $row_DtRg['id_tractrl'];
					$Vl['enc'] = $row_DtRg['tractrl_enc'];
					$Vl['tt'] = ctjTx($row_DtRg['tractrl_tt'], 'in');
					$Vl['est'] = $row_DtRg['tractrl_est'];
					$Vl['ord'] = $row_DtRg['tractrl_ord'];
					$Vl['tra']['od'] = $row_DtRg['tractrl_tra'];
					$Vl['tra']['enc'] = $row_DtRg['tra_enc'];
				}

			}

			$__cnx->_clsr($DtRg);

		}

		return(_jEnc($Vl));

	}

	function GtTraCtrlLs($p=NULL){

		global $__cnx;

		if(is_array($p['id_tra'])){ $_id_tra = implode(",",$p['id_tra']);	}

		if($p['t'] == 'tra'){
			if($p['k'] == "enc"){
				//Cuando viene una tarea con el tra_enc
				$__fl .= "AND tractrl_tra IN (SELECT id_tra FROM "._BdStr(DBM).TB_TRA." WHERE tra_enc = '".$p['id_tra']."') ";
			}elseif(!isN($_id_tra)){
				//Cuando vienen varias tareas con el id_tra
				$__fl .= "AND tractrl_tra IN ($_id_tra) ";
			}
		}

		//Cuando se necesita saber el ultimo
		if($p['t'] == 'ult'){ $__fl .= "AND tractrl_tra IN (SELECT id_tra FROM "._BdStr(DBM).TB_TRA." WHERE tra_enc = '".$p['id_tra']."') "; $__fl_lmt = "LIMIT 1"; }
		if($p['t'] == 'tractrl_enc'){ $__fl .= "AND tractrl_enc = '".$p['id']."' "; $__fl_lmt = "LIMIT 1"; }

		$query_DtRg = "	SELECT id_tractrl,tractrl_enc,tractrl_tt,tractrl_est,tractrl_ord,tractrl_tra, tra_enc
						FROM "._BdStr(DBM).TB_TRA_CTRL."
							 INNER JOIN "._BdStr(DBM).TB_TRA." ON tractrl_tra = id_tra
						WHERE id_tractrl != '' $__fl
						ORDER BY tractrl_ord DESC $__fl_lmt";

		//echo  $query_DtRg; exit();

		$DtRg = $__cnx->_qry($query_DtRg);

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;
			$Vl['tot'] = $Tot_DtRg;

			if($Tot_DtRg > 0){

				do{

					$Vl['ls'][$row_DtRg['id_tractrl']]['id'] = $row_DtRg['id_tractrl'];
					$Vl['ls'][$row_DtRg['id_tractrl']]['enc'] = $row_DtRg['tractrl_enc'];
					$Vl['ls'][$row_DtRg['id_tractrl']]['tt'] = ctjTx($row_DtRg['tractrl_tt'], 'in');
					$Vl['ls'][$row_DtRg['id_tractrl']]['est'] = mBln($row_DtRg['tractrl_est']);
					$Vl['ls'][$row_DtRg['id_tractrl']]['ord'] = $row_DtRg['tractrl_ord'];
					$Vl['ls'][$row_DtRg['id_tractrl']]['tra']['id'] = $row_DtRg['tractrl_tra'];
					$Vl['ls'][$row_DtRg['id_tractrl']]['tra']['enc'] = $row_DtRg['tra_enc'];
					$Vl['ult'] = $row_DtRg['tractrl_ord'];
					$Vl['id'] = $row_DtRg['id_tractrl'];

				}while($row_DtRg = $DtRg->fetch_assoc());

			}

		}

		$__cnx->_clsr($DtRg);

		return(_jEnc($Vl));

	}

	function GtTraUsEstLs($p=NULL){

		global $__cnx;

		$__fl = sprintf("AND trausest_tra = (SELECT id_tra FROM "._BdStr(DBM).TB_TRA." WHERE tra_enc = %s LIMIT 1)", GtSQLVlStr(ctjTx($p['tra'],'out'), "text"));

		$query_DtRg = "	SELECT id_trausest,trausest_tra,trausest_est,trausest_fi, CONCAT(us_nm, ' ', us_ap) AS us_nm_f
						FROM "._BdStr(DBM).TB_TRA_US_EST."
							 INNER JOIN "._BdStr(DBM).TB_US." ON trausest_us = id_us
						WHERE id_trausest != '' $__fl
						ORDER BY trausest_fi DESC
						LIMIT 1";

		$DtRg = $__cnx->_qry($query_DtRg);

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;

			if($Tot_DtRg > 0){

				do{

					$Vl['ls'][ $row_DtRg['id_trausest'] ] = [
																'tra'=>$row_DtRg['trausest_tra'],
																'est'=>$row_DtRg['trausest_est'],
																'us'=>ctjTx($row_DtRg['us_nm_f'], 'in'),
																'f'=>$row_DtRg['trausest_fi']
															];

				}while($row_DtRg = $DtRg->fetch_assoc());

			}

		}

		$__cnx->_clsr($DtRg);

		return(_jEnc($Vl));

	}

	function GtTraTmeRgsDt($p=NULL){

		global $__cnx;

		if($p['tp'] == 'lst'){
			$_fl = 'ORDER BY id_tratmergs DESC LIMIT 1';
		}

		if(!isN($p['us'])){
			$_fl1 = "AND tratmergs_us = '".$p['us']."'";
		}

		$query_DtRg = sprintf("	SELECT tratmergs_act,us_enc,tratmergs_fi,id_tratmergs,tratmergs_hf,tratmergs_enc,tratmergs_tra,tratmergs_us,tratmergs_est
						FROM "._BdStr(DBM).TB_TRA_TME."
							 INNER JOIN "._BdStr(DBM).TB_TRA." ON tratmergs_tra = id_tra
							 INNER JOIN "._BdStr(DBM).TB_US." ON tratmergs_us = id_us
						WHERE id_tra=%s $_fl ", GtSQLVlStr($p['tra'],'int'));

		$DtRg = $__cnx->_qry($query_DtRg);

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;

			if($Tot_DtRg > 0){

				$i=1;

				do{

					if($p['tp'] == 'lst' && $i==1){

						$Vl['lst']['est'] = $row_DtRg['tratmergs_act'];
						$Vl['lst']['us']['enc'] = $row_DtRg['us_enc'];
						$Vl['lst']['fi'] = $row_DtRg['tratmergs_fi'];
						//$Vl['lst']['id'] = $row_DtRg['id_tratmergs'];
						$Vl['lst']['enc'] = $row_DtRg['tratmergs_enc'];
						$Vl['lst']['ff'] = $row_DtRg['tratmergs_ff'];

						$fecha1 = new DateTime($row_DtRg['tratmergs_fi']);
						$fecha2 = new DateTime(SIS_F_TS);
						$intervalo = $fecha1->diff($fecha2);

						$Vl['lst']['time']['y'] = $intervalo->format('%Y');
						$Vl['lst']['time']['m'] = $intervalo->format('%m');
						$Vl['lst']['time']['d'] = $intervalo->format('%d');
						$Vl['lst']['time']['h'] = $intervalo->format('%H');
						$Vl['lst']['time']['m'] = $intervalo->format('%i');
						$Vl['lst']['time']['s'] = $intervalo->format('%s');

					}else{

						$fecha1 = new DateTime($row_DtRg['tratmergs_fi']);//fecha inicial
						$fecha2 = new DateTime($row_DtRg['tratmergs_hf']);//fecha de cierre

						$intervalo = $fecha1->diff($fecha2);

						$id = $row_DtRg['tratmergs_enc'];

						$Vl['ls'][$id]['tot_tme'] = $intervalo->format('%Y-%m-%d %H:%i:%s');
						$Vl['ls'][$id]['enc'] = $row_DtRg['tratmergs_enc'];

						$Vl['ls'][$id]['tra'] = $row_DtRg['tratmergs_tra'];
						$Vl['ls'][$id]['us'] = $row_DtRg['tratmergs_us'];
						$Vl['ls'][$id]['est'] = $row_DtRg['tratmergs_est'];
						$Vl['ls'][$id]['fi'] = $row_DtRg['tratmergs_fi'];
						$Vl['ls'][$id]['ff'] = $row_DtRg['tratmergs_hf'];

						$seg_total += $intervalo->format('%s');
						$min_total += $intervalo->format('%i');
						$hor_total += $intervalo->format('%h');
						$day_total += $intervalo->format('%d');

					}

					/*
					if($p['tp'] == 'lst' && $i==1){

						if($day_total>=1 || ($hor_total/24)>=1){
							$t = 'day'; $fmt = 'd H:i';
						}elseif($hor_total>=1 || ($min_total/60)>=1){
							$t = 'hrs'; $fmt = 'H:i';
						}elseif($min_total>=1 || ($seg_total/60)>=1){
							$t = 'min'; $fmt = 'i:s';
						}else{
							$t = 'seg'; $fmt = 's';
						}

						$nuevaFecha = strtotime ( '+'.$day_total.' day '.$hor_total.' hours '.$min_total.' minute '.$seg_total.' seconds' , strtotime ( date ( '0000-00-00 00:00:00') ) ) ;
						$Vf = date ( $fmt , $nuevaFecha );

						$Vl['lst']['time']['tot'] = $Vf.' '.$t;

					}*/

					$i++;

				}while($row_DtRg = $DtRg->fetch_assoc());



			}

		}

		$__cnx->_clsr($DtRg);

		return(_jEnc($Vl));

	}

	function GtTraTmeRgsxUsDt($p=NULL){

		global $__cnx;

		$query_DtRg = "	SELECT tratmergs_fi,tratmergs_hf,tratmergs_enc,tratmergs_us, us_nm, us_img
						FROM "._BdStr(DBM).TB_TRA_TME."
							 INNER JOIN "._BdStr(DBM).TB_TRA." ON tratmergs_tra = id_tra
							 INNER JOIN "._BdStr(DBM).TB_US." ON tratmergs_us = id_us
						WHERE id_tra = '".$p['tra']."'
						ORDER BY id_tratmergs DESC
					";

		$DtRg = $__cnx->_qry($query_DtRg);


		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;

			$Vl['tot'] = $Tot_DtRg;

			if($Tot_DtRg > 0){


				do{

					$fecha1 = new DateTime($row_DtRg['tratmergs_fi']);//fecha inicial
					$fecha2 = new DateTime($row_DtRg['tratmergs_hf']);//fecha de cierre
					$intervalo = $fecha1->diff($fecha2);



					$__c = [
						'tot_tme'=>$intervalo->format('%Y-%m-%d %H:%i:%s'),
						'fi'=>date("d/m/Y", strtotime($row_DtRg['tratmergs_fi'])),
						'enc'=>$row_DtRg['tratmergs_enc'],
						'us'=>[
							'id'=>$row_DtRg['tratmergs_us'],
							'nm'=>$row_DtRg['us_nm'],
							'img'=>$row_DtRg['us_img']
						],
						'tot'=>[
							'tme'=>[
								's'=>$intervalo->format('%s'),
								'i'=>$intervalo->format('%i'),
								'h'=>$intervalo->format('%h'),
								'd'=>$intervalo->format('%d'),
								'tot'=>$intervalo->format('%H:%I:%S'),
							]
						],
						'f'=>[
							'html'=>[
								'start'=>str_replace(' ',HTML_BR,$row_DtRg['tratmergs_fi']),
								'end'=>str_replace(' ',HTML_BR,$row_DtRg['tratmergs_hf'])
							]
						]
					];



					$Vl['ls']['o'][$row_DtRg['tratmergs_enc']] = $__c;
					$Vl['ls']['a'][] = $__c;


				}while($row_DtRg = $DtRg->fetch_assoc());

			}

		}

		$__cnx->_clsr($DtRg);

		return(_jEnc($Vl));

	}

	function GtTraObsLs($p=NULL){

		global $__cnx;

		$_prvt = $p['prvt'];

		if(!isN($p['bd'])){ $_bd = _BdStr($p['bd']); }

		$query_DtRg = "SELECT
							*
						FROM
							"._BdStr(DBM).TB_US."
							INNER JOIN "._BdStr(DBM).TB_US_CL." ON uscl_us = id_us
							INNER JOIN "._BdStr(DBM).TB_CL." ON uscl_cl = id_cl
						WHERE 	cl_enc = '".( ( !isN($p["cl_enc"]) )? $p["cl_enc"] : CL_ENC )."' AND
							  	id_us IN (
									SELECT
										trarsp_us
									FROM
										"._BdStr(DBM).TB_TRA_RSP.",
										"._BdStr(DBM).TB_TRA."
									WHERE	trarsp_tra = id_tra AND
											id_tra = (SELECT id_tra FROM "._BdStr(DBM).TB_TRA." where tra_enc = '".$p['tra']."') AND
											trarsp_tp = '"._CId('ID_USROL_OBS')."'
								)
						ORDER BY us_ap ASC, us_nm ASC"; //echo "<---".$query_DtRg."--->";

		$DtRg = $__cnx->_qry($query_DtRg);

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Vl['tot'] = $DtRg->num_rows;

			if($Vl['tot'] > 0){

				do{

					if($_prvt!='ok'){ $Vl['ls'][$row_DtRg['us_enc']]['id'] = $row_DtRg['id_us']; }

					$Vl['ls'][$row_DtRg['us_enc']]['enc'] = $row_DtRg['us_enc'];
					$Vl['ls'][$row_DtRg['us_enc']]['nm'] = ctjTx($row_DtRg['us_nm'], 'in').' '.ctjTx($row_DtRg['us_ap'], 'in');

					if( !isN($row_DtRg['us_img']) ){

						$Vl['ls'][$row_DtRg['us_enc']]['img'] = _ImVrs([ 'img'=>$row_DtRg['us_img'], 'f'=>DMN_FLE_US ]);

					}else{
						$_img = GtUsImg([ 'img'=>$row_DtRg['us_img'], 'gnr'=>$row_DtRg['us_gnr'] ]);
						$Vl['ls'][$row_DtRg['us_enc']]['img'] = $_img;
					}

				}while($row_DtRg = $DtRg->fetch_assoc());

			}
		}

		$__cnx->_clsr($DtRg);

		return(_jEnc($Vl));

	}

	function GtTraCmntDt($p=NULL){

		global $__cnx;

		if(!isN($p['id'])){

			if($p['t'] == 'enc'){
				$__f = 'tracmnt_enc'; $__ft = 'text';
			}else{
				$__f = 'id_tracmnt'; $__ft = 'int';
			}

			$query_DtRg = sprintf('	SELECT tracmnt_enc, tracmnt_tt, tracmnt_fi, us_nm, us_ap, us_img, us_gnr
									FROM '._BdStr(DBM).TB_TRA_CMNT.'
										 INNER JOIN '._BdStr(DBM).TB_US.' ON tracmnt_us=id_us
									WHERE '.$__f.'=%s', GtSQLVlStr($p['id'],$__ft));

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg > 0){

					$Vl['enc'] = $row_DtRg['tracmnt_enc'];
					$Vl['tt'] = ctjTx($row_DtRg['tracmnt_tt'],'in');
					$Vl['us']['nm'] = ctjTx($row_DtRg['us_nm'],'in');
					$Vl['us']['ap'] = ctjTx($row_DtRg['us_ap'],'in');

					$_img = GtUsImg([ 'img'=>$row_DtRg['us_img'], 'gnr'=>$row_DtRg['us_gnr'] ]);
					$Vl['us']['img'] = $_img->th_50;
					$Vl['fi'] = ctjTx($row_DtRg['tracmnt_fi'],'in');
				}

			}

			$__cnx->_clsr($DtRg);
			return(_jEnc($Vl));
		}
	}

	function GtTraTagLs($p=NULL){

		global $__cnx;

		$_id_tra = implode(",",$p['id_tra']);

		if($p['t'] == 'tra'){
			if($p['k'] == "enc"){
				//Cuando viene una tarea con el tra_enc
				$__fl .= "AND tratag_tra IN (SELECT id_tra FROM "._BdStr(DBM).TB_TRA." WHERE tra_enc = '".$p['id_tra']."') ";
			}elseif(!isN($_id_tra)){
				//Cuando vienen varias tareas con el id_tra
				$__fl .= "AND tratag_tra IN ($_id_tra) ";
			}
		}

		$_sb_Qry = ", (SELECT sisslcf_vl FROM "._BdStr(DBM).TB_SIS_SLC_F.", "._BdStr(DBM).TB_SIS_SLC."  WHERE id_sisslc = sisslcf_slc AND id_sisslc = tratag_tag ) AS _clr_tag";
		$query_DtRg = "SELECT id_tratag,tratag_enc,tratag_tra,tratag_tag,tra_enc $_sb_Qry ,
								(	SELECT sisslc_tt FROM "._BdStr(DBM).TB_SIS_SLC."
									WHERE id_sisslc = tratag_tag
								) AS _tt_tag
						FROM "._BdStr(DBM).TB_TRA_TAG."
							 INNER JOIN "._BdStr(DBM).TB_TRA." ON tratag_tra = id_tra
						WHERE id_tratag != '' $__fl
						ORDER BY id_tratag DESC";

		$DtRg = $__cnx->_qry($query_DtRg);

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;
			$Vl['tot'] = $Tot_DtRg;

			if($Tot_DtRg > 0){

				do{
					if(!isN($row_DtRg['id_tratag']) && !isN($row_DtRg['id_tratag'])){

						$Vl[$row_DtRg['id_tratag']]['id']  = $row_DtRg['id_tratag'];
						$Vl[$row_DtRg['id_tratag']]['enc'] = $row_DtRg['tratag_enc'];

						$Vl[$row_DtRg['id_tratag']]['tra']['id'] = $row_DtRg['tratag_tra'];
						$Vl[$row_DtRg['id_tratag']]['tra']['enc'] = $row_DtRg['tra_enc'];

						$Vl[$row_DtRg['id_tratag']]['tag'] = $row_DtRg['tratag_tag'];
						$Vl[$row_DtRg['id_tratag']]['tt_tag'] = $row_DtRg['_tt_tag'];
						$Vl[$row_DtRg['id_tratag']]['clr_tag'] = $row_DtRg['_clr_tag'];

						$Vl['id'] = $row_DtRg['id_tratag'];

					}

				}while($row_DtRg = $DtRg->fetch_assoc());
			}

		}

		$__cnx->_clsr($DtRg);

		return(_jEnc($Vl));

	}



	function GtTraDt($p=NULL){

		global $__cnx;

		$_prvt = $p['prvt'];

		$Vl['e'] = 'no';

		if(!isN($p['id'])){

			$c_DtRg = "-1";if (isset($p['id'])){$c_DtRg = $p['id'];}

			if($p['t'] == 'enc'){
				$__f = 'tra_enc'; $__ft = 'text';
			}else{
				$__f = 'id_tra'; $__ft = 'int';
			}

			if(!isN($p['bd'])){ $_bd = _BdStr($p['bd']); }

			$query_DtRg = sprintf("	SELECT 	id_tracol,id_tra,tra_enc,tra_tt,tra_dsc,tra_f,tra_h,tra_est,tra_fi,tra_bfr,
											tra_fa,tracol_tt,tracol_enc,tracol_chk_pqr,tracol_chk_tck,tracol_chk_pblc,tracol_icn,

											"._QrySisSlcF(['als'=>'c', 'als_n'=>'color']).",
											"._QrySisSlcF(['als'=>'i', 'als_n'=>'icon']).",
											".GtSlc_QryExtra(['t'=>'fld', 'p'=>'icon', 'als'=>'i']).",
											".GtSlc_QryExtra(['t'=>'fld', 'p'=>'color', 'als'=>'c']).",
											".GtSlc_QryExtra(['t'=>'fld', 'p'=>'tipo', 'als'=>'t']).",

											tra_tot_cmnt AS _tot_cmnt,
											tra_tot_tag AS _tot_tag,
											tra_tot_ctrl AS _tot_ctrl,
											tra_tot_ctrl_rdy AS _tot_ctrl_rdy,

											us_rsp.id_us AS rsp_id_us,
											us_rsp.us_nm AS rsp_us_nm,
											us_rsp.us_ap AS rsp_us_ap,
											us_rsp.us_img AS rsp_us_img,
											us_rsp.us_gnr AS rsp_us_gnr,

											/*
											(	SELECT id_us
												FROM "._BdStr(DBM).TB_US."
													 INNER JOIN "._BdStr(DBM).TB_TRA_RSP." ON trarsp_us = id_us
												WHERE trarsp_tra = id_tra AND trarsp_tp = '"._CId('ID_USROL_RSP')."'
												ORDER BY id_trarsp DESC
												LIMIT 1
											) as _rsp,*/

											_mdl_cnt.mdlcnttra_mdlcnt AS _mdl_cnt,
											id_storebrnd, storebrnd_img, storebrnd_nm

									FROM 	"._BdStr(DBM).TB_TRA."
										 	LEFT JOIN "._BdStr(DBM).TB_TRA_ORD." ON traord_tra = id_tra
											LEFT JOIN "._BdStr(DBM).TB_TRA_COL." ON tra_col = id_tracol
											LEFT JOIN "._BdStr(DBM).TB_TRA_RSP." ON (trarsp_tra = id_tra AND trarsp_tp = '"._CId('ID_USROL_RSP')."')
											LEFT JOIN "._BdStr(DBM).TB_US." AS us_rsp ON trarsp_us = us_rsp.id_us
											LEFT JOIN "._BdStr(DBS).TB_STORE_BRND." ON tra_sbrnd = id_storebrnd
											LEFT JOIN ".$_bd.TB_MDL_CNT_TRA." AS _mdl_cnt ON _mdl_cnt.mdlcnttra_tra = id_tra

										 	".GtSlc_QryExtra(['t'=>'tb', 'l'=>'ok', 'col'=>'tracol_icn', 'als'=>'i'])."
											".GtSlc_QryExtra(['t'=>'tb', 'l'=>'ok', 'col'=>'tracol_clr', 'als'=>'c'])."
											".GtSlc_QryExtra(['t'=>'tb', 'l'=>'ok', 'col'=>'tracol_tp', 'als'=>'t'])."

									WHERE ".$__f." = %s
									LIMIT 1", GtSQLVlStr($c_DtRg,$__ft));

			if($p['cmmt']=='ok'){ //-- If use it on commit process --//
				$DtRg = $__cnx->_prc($query_DtRg);
			}else{
				$DtRg = $__cnx->_qry($query_DtRg);
			}

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg > 0){

					$Vl['e'] = 'ok';

					$_Crm_Aud = new CRM_Aud();

					$Vl = GtTra_Flds([
						'v'=>$Vl['ls'][$row_DtRg['id_tracol']],
						'color'=>$row_DtRg['___color'],
						'icon'=>$row_DtRg['___icon'],
						'tipo'=>$row_DtRg['___tipo'],
						'rw'=>$row_DtRg
					]);

					if($_prvt!='ok'){ $Vl['id'] = $row_DtRg['id_tra']; }

					$Vl['enc'] = ctjTx($row_DtRg['tra_enc'],'in');
					$Vl['tt'] = ctjTx($row_DtRg['tra_tt'],'in');
					$Vl['dsc'] = ctjTx($row_DtRg['tra_dsc'],'in','',['sslh'=>'ok']);
					$Vl['f'] = $row_DtRg['tra_f'];
					$Vl['h'] = $row_DtRg['tra_h'];
					$Vl['bfr'] = $row_DtRg['tra_bfr'];
					$Vl['est'] = $row_DtRg['tra_est'];
					$Vl['fi']['m'] = $row_DtRg['tra_fi'];
					$Vl['fa']['m'] = $row_DtRg['tra_fa'];


					if(!isN($row_DtRg['tra_fi'])){

						$time = new DateTime($row_DtRg['tra_fi']);
						$date = $time->format('Y-m-d');
						$time = $time->format('H:i a');

						if(date('Ymd', strtotime($date)) == date('Ymd', strtotime('yesterday')) ){
							$_fgo = 'Ayer';
						}elseif(date('Ymd', strtotime($date)) == date('Ymd', strtotime('today')) ){
							$_fgo = 'Hoy';
						}else{
							$_fgo = $date;
						}

						$Vl['fi']['d'] = $_fgo;
						$Vl['fi']['h'] = $time;

					}

					//$__usdt = GtUsDt($row_DtRg['_rsp']);
					//$__rsp_us = GtUsDt($row_DtRg['_rsp']/*,'enc'*/);

					if(!isN( $row_DtRg['rsp_id_us'] )){
						if($_prvt!='ok'){  $Vl['rsp']['id'] = $row_DtRg['rsp_id_us']; }
						$Vl['rsp']['nm'] = ctjTx($row_DtRg['rsp_us_nm'],'in');
						$Vl['rsp']['ap'] = ctjTx($row_DtRg['rsp_us_ap'],'in');
						$_img = GtUsImg([ 'img'=>$row_DtRg['rsp_us_img'], 'gnr'=>$row_DtRg['rsp_us_gnr'] ]);
						$Vl['rsp']['img'] = $_img;
					}

					if($_prvt!='ok'){ $Vl['col']['id'] = $row_DtRg['id_tracol']; }

					$Vl['col']['tt'] = ctjTx($row_DtRg['tracol_tt'],'in');
					$Vl['col']['enc'] = $row_DtRg['tracol_enc'];
					$Vl['col']['icn'] = DMN_FLE_SIS_SLC.'slc_'.$row_DtRg['tracol_icn'].'.svg';
					$Vl['col']['chk']['pqr'] = mBln($row_DtRg['tracol_chk_pqr']);
					$Vl['col']['chk']['tck'] = mBln($row_DtRg['tracol_chk_tck']);
					$Vl['col']['chk']['pblc'] = mBln($row_DtRg['tracol_chk_pblc']);

					$Vl['tot']['cmnt'] = $row_DtRg['_tot_cmnt'];
					$Vl['tot']['tag'] = $row_DtRg['_tot_tag'];
					$Vl['tot']['ctrl'] = $row_DtRg['_tot_ctrl'];
					$Vl['tot']['ctrl_rdy'] = $row_DtRg['_tot_ctrl_rdy'];

					if($p['ext']['usest']=='ok' || $p['ext']['all']=='ok'){
						$Vl['his']['est'] = GtTraUsEstLs([  'tra'=>$row_DtRg['tra_enc'] ]);
					}

					if($p['ext']['tme']=='ok' || $p['ext']['all']=='ok'){
						$Vl['tme']['l'] = GtTraTmeRgsDt([ 'tra'=>$row_DtRg['id_tra'], 'us'=>SISUS_ID, 'k'=>$p['k'], 'tp'=>'lst' ])->lst;
						$Vl['tme']['h'] = GtTraTmeRgsDt([ 'tra'=>$row_DtRg['id_tra'], 'us'=>'', 'k'=>$p['k']] );
						$Vl['tme']['u'] = GtTraTmeRgsxUsDt([ 'tra'=>$row_DtRg['id_tra'], 'us'=>SISUS_ID, 'k'=>'enc' ]);
					}

					if($p['ext']['ctrl']=='ok' || $p['ext']['all']=='ok'){
						$_ctrl_ls = GtTraCtrlLs([  'id_tra'=>$row_DtRg['tra_enc'], 't'=>'tra', 'k'=>'enc' ]);
						$Vl['ctrl']['ls'] = $_ctrl_ls->ls;
						$Vl['ctrl']['tot'] = $_ctrl_ls->tot;
					}

					if($p['ext']['obs']=='ok' || $p['ext']['all']=='ok'){
						$Vl['obs'] = GtTraObsLs([ 'tra'=>$row_DtRg['tra_enc'], 'us'=>SISUS_ID, 'k'=>'enc', 'prvt'=>$_prvt ]);
					}

					if($p['ext']['cmnt']=='ok' || $p['ext']['all']=='ok'){
						$_cmnt_ls = GtTraCmntLs([ 'id_tra'=>$row_DtRg['tra_enc'], 't'=>'tra', 'k'=>'enc', 'prvt'=>$_prvt ]);
						if(!isN($_cmnt_ls->ls)){ $Vl['cmnt']['ls'] = $_cmnt_ls->ls; }
						$Vl['cmnt']['tot'] = $_cmnt_ls->tot;
					}

					if($p['ext']['tag']=='ok' || $p['ext']['all']=='ok'){
						$_tag_ls = GtTraTag_Ls([ 'tp'=>'enc', 'id'=>$row_DtRg['tra_enc'], 'tag'=>'ok' ]);
						$Vl['tag']['ls'] = $_tag_ls->ls;
						$Vl['tag']['tot'] = $_tag_ls->tot;
					}

					//$Vl['aud'] = $_Crm_Aud->Shw_Aud([  'key'=>['tra', 'tra_col', 'tra_cmnt'], 'iddb'=>$row_DtRg['id_tra'], 'dbrlc'=>'tra_ctrl' ] );

					if(!isN($row_DtRg['_mdl_cnt'])){

						$Vl['mdl_cnt'] = $_mdlcnt = GtMdlCntDt([
														'id'=>$row_DtRg['_mdl_cnt'],
														'shw'=>[
															'attr'=>$p['ext']['mdlcnt']['attr'],
															'attch'=>$p['ext']['mdlcnt']['attch']
														],
														'cmmt'=>$p['cmmt']
													]);

						if($_mdlcnt->mdl->tp->key == 'sac'){
							$Vl['sac']['tckid'] = $row_DtRg['_mdl_cnt'];
						}

					}

					$Vl['tckid'] = $row_DtRg['id_tra'];


					if(!isN( $row_DtRg['storebrnd_img'] )){
						$_img_brnd = _ImVrs(['img'=>$row_DtRg['storebrnd_img'], 'f'=>DMN_FLE_CL_STORE_BRND ]);
						$Vl['store']['brnd']['id'] = $row_DtRg['id_storebrnd'];
						$Vl['store']['brnd']['nm'] = ctjTx($row_DtRg['storebrnd_nm'],'in');
						$Vl['store']['brnd']['img'] = $_img_brnd->th_100;
					}

				}else{

					$Vl['w'] = 'no_records';

				}

			}else{

				if($p['cmmt']=='ok'){
					$Vl['w'] = $__cnx->c_p->error;
				}else{
					$Vl['w'] = $__cnx->c_r->error;
				}

			}

			$__cnx->_clsr($DtRg);

		}else{

			$Vl['w'] = 'No data for process';

		}

		return _jEnc($Vl);

	}

	function GtTraColDt_Chk($p=NULL){

		global $__cnx;

		if($p['tck'] == 'ok' && !isN($p['tck'])){ $__flt .= "AND tracol_chk_tck = 1 "; }
		elseif($p['pqr'] == 'ok' && !isN($p['tck'])){ $__flt .= "AND tracol_chk_pqr = 1 "; }
		elseif($p['pblc'] == 'ok' && !isN($p['pblc'])){ $__flt .= "AND tracol_chk_pblc = 1 "; }

		$Vl['e'] = 'no';

		$query_DtRg = sprintf("	SELECT tracol_enc,id_tracol,tracol_tt,tracol_dsc,tracol_chk_pqr,tracol_chk_tck
								FROM "._BdStr(DBM).TB_TRA_COL."
								WHERE id_tracol IS NOT NULL $__flt ");

		//$Vl['qry'] = $query_DtRg;

		$DtRg = $__cnx->_qry($query_DtRg);

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;
			$Vl['tot'] = $Tot_DtRg;

			if($Tot_DtRg > 0){

				$Vl['e'] = 'ok';

				do{
					$Vl['enc'] = $row_DtRg['tracol_enc'];
					$Vl['id'] = ctjTx($row_DtRg['id_tracol'],'in');
					$Vl['tt'] = ctjTx($row_DtRg['tracol_tt'],'in');
					$Vl['dsc'] = $row_DtRg['tracol_dsc'];
					$Vl['chk']['pqr'] = $row_DtRg['tracol_chk_pqr'];
					$Vl['chk']['tck'] = $row_DtRg['tracol_chk_tck'];
				}while($row_DtRg = $DtRg->fetch_assoc());
			}

		}else{ $Vl['w'] = $__cnx->c_r->error; }

		$__cnx->_clsr($DtRg);

		return _jEnc($Vl);
	}


	function GtMdlCntTraDt($p=NULL){

		global $__cnx;

		if(!isN($p['id'])){
			if($p['tp'] == 'tra'){ $__f = 'mdlcnttra_tra'; $__ft = 'int'; }
			elseif($p['tp'] == 'mdl_cnt'){ $__f = 'mdlcnttra_mdlcnt'; $__ft = 'int'; }
			else{ $__f = 'id_mdlcnttra'; $__ft = 'int'; }

			$query_DtRg = sprintf('SELECT
										id_mdlcnttra, mdlcnttra_mdlcnt, mdlcnttra_tra
									FROM '.TB_MDL_CNT_TRA.'
										WHERE id_mdlcnttra != "" AND
										'.$__f.' = %s',
										GtSQLVlStr($p['id'], $__ft));
			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg > 0){

					if($Tot_DtRg > 0){
						do{

							$Vl['ls'][$row_DtRg['id_mdlcnttra']]['id']  = $row_DtRg['id_mdlcnttra'];
							$Vl['ls'][$row_DtRg['id_mdlcnttra']]['enc'] = $row_DtRg['mdlcnttra_enc'];

							if($p['shw']['mdlcnt'] == 'ok'){
								$Vl['ls'][$row_DtRg['id_mdlcnttra']]['mdl_cnt'] = GtMdlCntDt($row_DtRg['mdlcnttra_mdlcnt']);
							}

							if($p['shw']['tra'] == 'ok'){
								$Vl['ls'][$row_DtRg['id_mdlcnttra']]['tra'] = GtTraDt([
																							'id'=>$row_DtRg['mdlcnttra_tra'],
																							'ext'=>[
																									'obs'=>$p['shw']['obs'],
																									'cmnt'=>$p['shw']['cmnt']
																								   ]
																					  ]);
							}else{

							}

						}while($row_DtRg = $DtRg->fetch_assoc());
					}
				}
			}

			$__cnx->_clsr($DtRg);


			return(_jEnc($Vl));

		}

	}




	function GtMdlCntUsDt($p=NULL){

		global $__cnx;

		if(!isN($p['us']) && !isN($p['mdlcnt']) && !isN($p['tp'])){

			$query_DtRg = sprintf('	SELECT id_mdlcntus, mdlcntus_enc
									FROM '.TB_MDL_CNT_US.'
									WHERE 	mdlcntus_mdlcnt=%s AND
											mdlcntus_us=%s AND
											mdlcntus_tp=%s
									LIMIT 1',
									GtSQLVlStr($p['mdlcnt'],'int'),
									GtSQLVlStr($p['us'],'int'),
									GtSQLVlStr($p['tp'],'int')
							);

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$Vl['e'] = 'ok';
				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				if($Tot_DtRg > 0){
					if($Tot_DtRg > 0){
						$Vl['id'] = $row_DtRg['id_mdlcntus'];
						$Vl['enc'] = $row_DtRg['mdlcntus_enc'];
					}
				}
			}

			$__cnx->_clsr($DtRg);

			return(_jEnc($Vl));

		}

	}



	function MdlCntUsIn($p=NULL){

		global $__cnx;

		if(!isN($p['us']) && !isN($p['mdlcnt']) && !isN($p['tp'])){

			$__enc = Enc_Rnd($p['us'].'-'.$p['mdlcnt'].'-'.$p['tp']);

			$query_DtRg =   sprintf("INSERT INTO ".TB_MDL_CNT_US." (mdlcntus_enc, mdlcntus_us, mdlcntus_us_asg, mdlcntus_mdlcnt, mdlcntus_tp) VALUES (%s,%s,%s,%s,%s)",
							GtSQLVlStr($__enc, "text"),
							GtSQLVlStr($p['us'], "int"),
							GtSQLVlStr(!isN($p['us_asg'])?$p['us_asg']:SISUS_ID, "int"),
							GtSQLVlStr($p['mdlcnt'], "int"),
							GtSQLVlStr($p['tp'], "int"));

			$Result = $__cnx->_prc($query_DtRg);

			if($Result){
				$rsp['id'] = $__cnx->c_p->insert_id;
				$rsp['enc'] = $__enc;
				$rsp['e'] = 'ok';
				$rsp['m'] = 1;
			}else{
				$rsp['e'] = 'no';
				$rsp['m'] = 2;
				$rsp['w'] = $__cnx->c_p->error;
				$rsp['w_n'] = $__cnx->c_p->errno;
			}

		}

		return _jEnc($rsp);

	}



	function GtTraTag_Ls($p=NULL){

		global $__cnx;

		$Vl['e'] = 'no';

		if($p['tp'] == 'enc'){ $__fl = 'tra_enc'; }else{ $__fl = 'id_tra'; }

		if(!isN($p['id'])){

			$query_DtRg = "	SELECT tratag_enc, tratag_tra, tratag_tag, tra_enc, sisslc_enc, sisslc_tt, sisslcf_vl
							FROM "._BdStr(DBM).TB_TRA_TAG."
								 INNER JOIN "._BdStr(DBM).TB_TRA." ON tratag_tra = id_tra
								 INNER JOIN "._BdStr(DBM).TB_SIS_SLC." ON tratag_tag = id_sisslc
								 INNER JOIN "._BdStr(DBM).TB_SIS_SLC_TP." ON sisslc_tp = id_sisslctp
								 INNER JOIN "._BdStr(DBM).TB_SIS_SLC_F." ON sisslcf_slc = id_sisslc
								".$___fl."
							WHERE $__fl='".$p['id']."'
							ORDER BY id_sisslc DESC";

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				$Vl['tot'] = $Tot_DtRg;

				if($Tot_DtRg > 0){

					$Vl['e'] = 'ok';

					do{

						$_id = $row_DtRg['tratag_enc'];
						//$Vl['ls'][$row_DtRg['sisslc_enc']]['qry'] = $query_DtRg;;
						$Vl['ls'][$_id]['enc'] = $row_DtRg['tratag_enc'];
						$Vl['ls'][$_id]['nm'] = ctjTx($row_DtRg['sisslc_tt'],'in');
						$Vl['ls'][$_id]['clr'] = $row_DtRg['sisslcf_vl'];

						$Vl['ls'][$_id]['tag']['id'] = $row_DtRg['tratag_tag'];
						$Vl['ls'][$_id]['tag']['enc'] = $row_DtRg['sisslc_enc'];
						$Vl['ls'][$_id]['tra']['id'] = $row_DtRg['tratag_tra'];
						$Vl['ls'][$_id]['tra']['enc'] = $row_DtRg['tra_enc'];

					}while($row_DtRg = $DtRg->fetch_assoc());
				}

			}else{

				$Vl['w'] = $this->c_r->error;

			}

			$__cnx->_clsr($DtRg);

		}

		return _jEnc($Vl);
	}

	function GtTraTag($p=NULL){

		$Vl['e'] = 'no';
		$__chk = GtTraTag_Chk([ 'tra' => $p['tra'], 'tag' => $p['tag'] ]);

		if(isN($__chk->id)){

			$__in = GtTraTag_In([ 'tra' => $p['tra'], 'tag' => $p['tag'] ]);

			if($__in->e == 'ok'){
				$Vl['e'] = 'ok';
				$Vl['enc'] = $__in->enc;
			}

		}elseif(!isN($__in) || !isN($__chk->id)){

			$__upd = GtTraTag_Del([ 'tra' => $p['tra'], 'tag' => $p['tag'] ]);
			//$Vl['_upd']=$__upd;

			if($__upd->e == 'ok'){
				$Vl['enc'] = $__chk->enc;
				$Vl['upd']='ok';
				$Vl['e']='ok';
			}else{
				$Vl['e']='no';
			}

		}

		return(_jEnc($Vl));
	}

	function GtTraTag_Chk($p=NULL){

		global $__cnx;

		if( !isN($p['tra']) && !isN($p['tag']) ){

			$Vl['e'] = 'no';

			$query_DtRg = sprintf("	SELECT id_tratag, tratag_enc
									FROM "._BdStr(DBM).TB_TRA_TAG."
									WHERE tratag_tra = (SELECT id_tra FROM "._BdStr(DBM).TB_TRA." WHERE tra_enc = %s) AND
										  tratag_tag = (SELECT id_sisslc FROM "._BdStr(DBM).TB_SIS_SLC." WHERE sisslc_enc = %s)
								   	LIMIT 1", GtSQLVlStr($p['tra'],'text'), GtSQLVlStr($p['tag'],'text'));

			$DtRg = $__cnx->_qry($query_DtRg);

			if($DtRg){

				$row_DtRg = $DtRg->fetch_assoc();
				$Tot_DtRg = $DtRg->num_rows;

				$Vl['tot'] = $Tot_DtRg;

				if($Tot_DtRg > 0){
					$Vl['e'] = 'ok';
					$Vl['id'] = $row_DtRg['id_tratag'];
					$Vl['enc'] = ctjTx($row_DtRg['tratag_enc'],'in');
				}
			}

			$__cnx->_clsr($DtRg);

		}

		return(_jEnc($Vl));
	}

	function GtTraTag_In($p=NULL){

		global $__cnx;

		$__enc = Enc_Rnd($p['tra'].'-'.$p['tag']);

		$query_DtRg =   sprintf("INSERT INTO "._BdStr(DBM).TB_TRA_TAG." (tratag_enc, tratag_tra, tratag_tag)
									VALUES (%s, (SELECT id_tra FROM "._BdStr(DBM).TB_TRA." WHERE tra_enc = %s),
									(SELECT id_sisslc FROM "._BdStr(DBM).TB_SIS_SLC." WHERE sisslc_enc = %s))",
						GtSQLVlStr($__enc, "text"),
						GtSQLVlStr($p['tra'], "text"),
						GtSQLVlStr($p['tag'], "text"));

		$Result = $__cnx->_prc($query_DtRg);

		if($Result){
			$rsp['i'] = $__cnx->c_p->insert_id;
			$rsp['enc'] = $__enc;
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			$rsp['w'] = $__cnx->c_p->error;
			$rsp['w_n'] = $__cnx->c_p->errno;
		}

		return _jEnc($rsp);

	}

	function GtTraTag_Del($p=NULL){

		global $__cnx;

		$query_DtRg = sprintf("DELETE FROM "._BdStr(DBM).TB_TRA_TAG." WHERE
								tratag_tra = (SELECT id_tra FROM "._BdStr(DBM).TB_TRA." WHERE tra_enc = %s) AND
								tratag_tag = (SELECT id_sisslc FROM "._BdStr(DBM).TB_SIS_SLC." WHERE sisslc_enc = %s)",
								GtSQLVlStr($p['tra'], "text"),
								GtSQLVlStr($p['tag'], "text")
							);

		$Result = $__cnx->_prc($query_DtRg);

		if($Result){
			$rsp['e'] = 'ok';
			$rsp['m'] = 1;
		}else{
			$rsp['e'] = 'no';
			$rsp['m'] = 2;
			$rsp['w'] = $__cnx->c_p->error.' <-> '.$query_DtRg;
			$rsp['w_n'] = $__cnx->c_p->errno;
		}

		return _jEnc($rsp);

	}

	function GtTraDshDt($p=NULL){

		global $__cnx;

		$Vl['e'] = 'no';

		if(!isN($p['fi']) && !isN($p['ff'])){
			$__dt_1 = $p['fi'];
			$__dt_2 = $p['ff'];
		}else{
			$__dt_1 = date('Y-m-01');
			$__dt_2 = date('Y-m-d');
		}

		if(!ClMain()){ $_fl .= ' AND tracol_chk_pblc=2'; }else{ $_fl .= ' AND tracol_chk_pblc=1'; }

		$query_DtRg = "	SELECT	DATE_FORMAT( tra_fi, '%Y-%m-%d' ) as f_i,
								COUNT(DISTINCT id_tra) as tot,
								tracol_tp,
								"._QrySisSlcF(['als'=>'t', 'als_n'=>'tipo']).",
								".GtSlc_QryExtra(['t'=>'fld', 'p'=>'tipo', 'als'=>'t'])."
						FROM 	"._BdStr(DBM).TB_TRA."
								INNER JOIN "._BdStr(DBM).TB_TRA_COL." ON tra_col = id_tracol
								".GtSlc_QryExtra(['t'=>'tb', 'col'=>'tracol_tp', 'als'=>'t'])."
						WHERE 	tra_cl = ".DB_CL_ID." AND
								DATE_FORMAT( tra_fi, '%Y-%m-%d' ) BETWEEN '".$__dt_1."' AND '".$__dt_2."'
								{$_fl}
						GROUP BY
							DATE_FORMAT( tra_fi, '%Y-%m-%d' ), tracol_tp";

		$DtRg = $__cnx->_qry($query_DtRg);

		//$Vl['tmp_q'] = compress_code($query_DtRg);

		if($DtRg){

			$Vl['e'] = 'ok';

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;



				do{

					$_r['ctg'][$row_DtRg['f_i']] = $row_DtRg['f_i'];
					$_r['d'][$row_DtRg['tipo_sisslc_cns']]['nm'] = $row_DtRg['tipo_sisslc_tt'];
					$_r['d'][$row_DtRg['tipo_sisslc_cns']][$row_DtRg['f_i']]['tot'] = $row_DtRg['tot'];

				}while($row_DtRg = $DtRg->fetch_assoc());

				$Vl_Grph = _jEnc($_r);

				for($i=$__dt_1;$i<=$__dt_2;$i = date('Y-m-d', strtotime($i .'+ 1 days'))){

					$__ctg[] = $i;

					foreach($Vl_Grph->d as $_k => $_v){
						$_d[$_k]['name'] = $_v->nm;
						$_d[$_k]['data'][] = ( !isN($_v->{$i}->tot) ) ? (int)$_v->{$i}->tot : 0 ;
					}

				}

				$Vl['c'] = $__ctg;
				$Vl['o'] = $_d;


		}else{

			$Vl['w'] = $__cnx->c_r->error;

		}

		$__cnx->_clsr($DtRg);

		return(_jEnc($Vl));

	}

	function GtTraDshFntDt($p=NULL){

		global $__cnx;

		$Vl['e'] = 'no';

		if(!isN($p['fi']) && !isN($p['ff'])){
			$__dt_1 = $p['fi'];
			$__dt_2 = $p['ff'];
			$_fl .= "AND DATE_FORMAT( tra_fi, '%Y-%m-%d' ) BETWEEN '".$__dt_1."' AND '".$__dt_2."'";
		}else{
			$__dt_1 = date('Y-m-01');
			$__dt_2 = date('Y-m-d');
		}

		if(!ClMain()){ $_fl .= ' AND tracol_chk_pblc=2'; }else{ $_fl .= ' AND tracol_chk_pblc=1'; }

		$query_DtRg = "	SELECT id_sisfnt, sisfnt_nm, COUNT(DISTINCT id_mdlcnt) as tot
						FROM ".TB_MDL_CNT."
							 INNER JOIN ".TB_MDL_CNT_TRA." ON mdlcnttra_mdlcnt = id_mdlcnt
							 INNER JOIN "._BdStr(DBM).TB_TRA." ON mdlcnttra_tra = id_tra
							 INNER JOIN "._BdStr(DBM).TB_TRA_COL." ON tra_col = id_tracol
							 INNER JOIN "._BdStr(DBM).TB_SIS_FNT." ON mdlcnt_fnt = id_sisfnt
						WHERE	id_sisfnt != ''
								{$_fl}
						GROUP BY mdlcnt_fnt";

		$DtRg = $__cnx->_qry($query_DtRg);

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;

			if($Tot_DtRg > 0){

				$Vl['e'] = 'ok';

				do{

					$_r['d'][$row_DtRg['id_sisfnt']]['nm'] = $row_DtRg['sisfnt_nm'];
					$_r['d'][$row_DtRg['id_sisfnt']]['tot'] = $row_DtRg['tot'];

				}while($row_DtRg = $DtRg->fetch_assoc());

				$Vl_Grph = _jEnc($_r);

				foreach($Vl_Grph->d as $_k => $_v){
					$_d[$_k]['name'] = $_v->nm;
					$_d[$_k]['y'] = ( !isN($_v->tot) ) ? (int)$_v->tot : 0 ;
				}

				$Vl['o'] = $_d;
			}

		}else{

			$Vl['w'] = $__cnx->c_r->error;

		}

		$__cnx->_clsr($DtRg);

		return(_jEnc($Vl));

	}

	function GtTraDshAvgDt($p=NULL){

		global $__cnx;

		$Vl['e'] = 'no';

		if(!isN($p['fi']) && !isN($p['ff'])){
			$__dt_1 = $p['fi'];
			$__dt_2 = $p['ff'];
			$_fl .= "AND DATE_FORMAT( tra_fi, '%Y-%m-%d' ) BETWEEN '".$__dt_1."' AND '".$__dt_2."'";
		}else{
			$__dt_1 = date('Y-m-01');
			$__dt_2 = date('Y-m-d');
		}

		if(!ClMain()){ $_fl .= ' AND tracol_chk_pblc=2'; }else{ $_fl .= ' AND tracol_chk_pblc=1'; }

		$query_DtRg = "	SELECT
							tra_fi,
							tra_f_cmpl,
							id_tra,
							tracol_tp,
							"._QrySisSlcF(['als'=>'t', 'als_n'=>'tipo']).",
							".GtSlc_QryExtra(['t'=>'fld', 'p'=>'tipo', 'als'=>'t'])."
						FROM
							"._BdStr(DBM).TB_TRA."
							INNER JOIN "._BdStr(DBM).TB_TRA_COL." ON tra_col = id_tracol
							".GtSlc_QryExtra(['t'=>'tb', 'col'=>'tracol_tp', 'als'=>'t'])."
						WHERE
							tra_cl = ".DB_CL_ID." AND
							(tra_est = "._CId('ID_TRAEST_CMPL')." OR tra_est = "._CId('ID_TRAEST_ARCHV').") AND
							tra_f_cmpl IS NOT NULL
							{$_fl}
						";

		$DtRg = $__cnx->_qry($query_DtRg);
		//$Vl['q'] = $query_DtRg;

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;

			if($Tot_DtRg > 0){

				$Vl['e'] = 'ok';

				do{

					$date_f = strtotime($row_DtRg['tra_f_cmpl']);
					$date_i = strtotime($row_DtRg['tra_fi']);

					$tot = $date_f - $date_i;

					$_r['d'][$row_DtRg['id_tra']]['nm'] = $row_DtRg['tipo_sisslc_tt'];
					$_r['d'][$row_DtRg['id_tra']]['tp'] = $row_DtRg['tipo_sisslc_cns'];
					$_r['d'][$row_DtRg['id_tra']]['tot'] = $tot;

					$_d['datas'][] = $tot;

				}while($row_DtRg = $DtRg->fetch_assoc());

				$Vl_Grph = _jEnc($_r);

				foreach($Vl_Grph->d as $_k => $_v){


					$_tot = $_tot + $_v->tot;


				}


				$_d[$_k]['name'] = 'Promedio';
				$_d[$_k]['y'] = ( !isN($_tot) ) ? (int)(($_tot/$Tot_DtRg)/3600) : 0 ;

				$Vl['o'] = $_d;
			}

		}else{

			$Vl['w'] = $__cnx->c_r->error;

		}

		$__cnx->_clsr($DtRg);

		return(_jEnc($Vl));

	}

	function GtTraDshTp($p=NULL){

		global $__cnx;

		$Vl['e'] = 'no';

		if(!isN($p['fi']) && !isN($p['ff'])){
			$__dt_1 = $p['fi'];
			$__dt_2 = $p['ff'];
			$_fl .= "AND DATE_FORMAT( tra_fi, '%Y-%m-%d' ) BETWEEN '".$__dt_1."' AND '".$__dt_2."'";
		}else{
			$__dt_1 = date('Y-m-01');
			$__dt_2 = date('Y-m-d');
		}

		if(!ClMain()){ $_fl .= ' AND tracol_chk_pblc=2'; }else{ $_fl .= ' AND tracol_chk_pblc=1'; }

		$query_DtRg = "	SELECT
							mdls_nm, mdls_enc, COUNT(*) AS tot
						FROM
							"._BdStr(DBM).TB_TRA."
							INNER JOIN "._BdStr(DBM).TB_TRA_COL." ON tra_col = id_tracol
							INNER JOIN ".TB_MDL_CNT_TRA." ON mdlcnttra_tra = id_tra
							INNER JOIN ".TB_MDL_CNT." ON mdlcnttra_mdlcnt = id_mdlcnt
							INNER JOIN ".TB_MDL." ON mdlcnt_mdl = id_mdl
							INNER JOIN "._BdStr(DBM).TB_MDL_S." ON mdl_mdls = id_mdls
						WHERE
							tra_cl = ".DB_CL_ID."
							{$_fl}
						GROUP BY id_mdls";

		$Vl['q'] = $query_DtRg;

		$DtRg = $__cnx->_qry($query_DtRg);

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;

			if($Tot_DtRg > 0){

				$Vl['e'] = 'ok';

				do{
					$_r['d'][$row_DtRg['mdls_enc']]['nm'] = $row_DtRg['mdls_nm'];
					$_r['d'][$row_DtRg['mdls_enc']]['tot'] = $row_DtRg['tot'];
				}while($row_DtRg = $DtRg->fetch_assoc());

				$Vl_Grph = _jEnc($_r);

				foreach($Vl_Grph->d as $_k => $_v){
					$_d[$_k]['name'] = $_v->nm;
					$_d[$_k]['data'][] = ( !isN($_v->tot) ) ? (int)$_v->tot : 0 ;
				}

				$Vl['o'] = $_d;
			}
		}else{
			$Vl['w'] = $__cnx->c_r->error;
		}

		$__cnx->_clsr($DtRg);

		return(_jEnc($Vl));
	}

	function GtTraDshAre($p=NULL){

		global $__cnx;

		$Vl['e'] = 'no';

		if(!ClMain()){ $_fl .= ' AND tracol_chk_pblc=2'; }else{ $_fl .= ' AND tracol_chk_pblc=1'; }

		$query_DtRg = "	SELECT
							clare_tt, clare_enc, COUNT(*) as tot
						FROM
							"._BdStr(DBM).TB_TRA_COL."
							INNER JOIN "._BdStr(DBM).TB_TRA_COL_GRP." ON tracolgrp_tracol = id_tracol
							INNER JOIN "._BdStr(DBM).TB_CL_GRP." ON tracolgrp_grp = id_clgrp
							INNER JOIN "._BdStr(DBM).TB_CL_GRP_ARE." ON clgrpare_clgrp = id_clgrp
							INNER JOIN "._BdStr(DBM).TB_CL_ARE." ON clgrpare_clare = id_clare
						WHERE
							tracol_cl = ".DB_CL_ID."
							{$_fl}
						GROUP BY id_clare";

		$DtRg = $__cnx->_qry($query_DtRg);

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;

			if($Tot_DtRg > 0){

				$Vl['e'] = 'ok';

				do{
					$_r['d'][$row_DtRg['clare_enc']]['nm'] = $row_DtRg['clare_tt'];
					$_r['d'][$row_DtRg['clare_enc']]['tot'] = $row_DtRg['tot'];
				}while($row_DtRg = $DtRg->fetch_assoc());

				$Vl_Grph = _jEnc($_r);

				foreach($Vl_Grph->d as $_k => $_v){
					$_d[$_k]['name'] = $_v->nm;
					$_d[$_k]['data'][] = ( !isN($_v->tot) ) ? (int)$_v->tot : 0 ;
				}

				$Vl['o'] = $_d;
			}
		}else{
			$Vl['w'] = $__cnx->c_r->error;
		}

		$__cnx->_clsr($DtRg);

		return(_jEnc($Vl));
	}

	function GtTraDshEst($p=NULL){

		global $__cnx;

		if(!isN($p['fi']) && !isN($p['ff'])){
			$__dt_1 = $p['fi'];
			$__dt_2 = $p['ff'];
			$_fl .= "AND DATE_FORMAT( tra_fi, '%Y-%m-%d' ) BETWEEN '".$__dt_1."' AND '".$__dt_2."'";
		}else{
			$__dt_1 = date('Y-m-01');
			$__dt_2 = date('Y-m-d');
		}

		$Vl['e'] = 'no';

		if(!ClMain()){ $_fl .= ' AND tracol_chk_pblc=2'; }else{ $_fl .= ' AND tracol_chk_pblc=1'; }

		$query_DtRg = "	SELECT
							COUNT(*) AS tot,
							"._QrySisSlcF([ 'als'=>'e', 'als_n'=>'Estado' ]).",
							".GtSlc_QryExtra([ 't'=>'fld', 'p'=>'Estado', 'als'=>'e' ])."
						FROM
							"._BdStr(DBM).TB_TRA."
							INNER JOIN "._BdStr(DBM).TB_TRA_COL." ON tra_col = id_tracol
							".GtSlc_QryExtra([ 't'=>'tb', 'col'=>'tra_est', 'als'=>'e' ])."
						WHERE tra_cl = ".DB_CL_ID."
							  {$_fl}
						GROUP BY Estado_id_sisslc";

		$DtRg = $__cnx->_qry($query_DtRg);

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;

			if($Tot_DtRg > 0){

				$Vl['e'] = 'ok';
				$Vl['tot'] = $Tot_DtRg;
				$Vl['q'] = $query_DtRg;

				do{
					$_r['d'][$row_DtRg['Estado_sisslc_enc']]['nm'] = $row_DtRg['Estado_sisslc_enc'];
					$_r['d'][$row_DtRg['Estado_sisslc_enc']]['tt'] = $row_DtRg['Estado_sisslc_tt'];
					$_r['d'][$row_DtRg['Estado_sisslc_enc']]['tot'] = $row_DtRg['tot'];

					$__tipo = json_decode($row_DtRg['___Estado']);

					foreach($__tipo as $__tipo_k=>$__tipo_v){
						$__tipo_attr[$__tipo_v->key] = $__tipo_v->vl;
					}

					$_r['d'][$row_DtRg['Estado_sisslc_enc']]['clr'] = $__tipo_attr['clr'];

				}while($row_DtRg = $DtRg->fetch_assoc());

				$Vl['o'] = $_r;
			}
		}else{
			$Vl['w'] = $__cnx->c_r->error;
		}

		$__cnx->_clsr($DtRg);

		return(_jEnc($Vl));
	}

	function GtTraDshMdlCnt($p=NULL){

		global $__cnx;

		$Vl['e'] = 'no';

		if(!isN($p['fi']) && !isN($p['ff'])){
			$__dt_1 = $p['fi'];
			$__dt_2 = $p['ff'];
			$_fl .= "AND DATE_FORMAT( tra_fi, '%Y-%m-%d' ) BETWEEN '".$__dt_1."' AND '".$__dt_2."'";
		}else{
			$__dt_1 = date('Y-m-01');
			$__dt_2 = date('Y-m-d');
		}

		if(!ClMain()){ $_fl .= ' AND tracol_chk_pblc=2'; }else{ $_fl .= ' AND tracol_chk_pblc=1'; }

		$query_DtRg = "	SELECT
							cnt_enc, cnt_nm, cnt_ap, tra_enc, mdlcnt_fi, id_mdlcnt,
							"._QrySisSlcF(['als'=>'c', 'als_n'=>'color']).",
							".GtSlc_QryExtra(['t'=>'fld', 'p'=>'color', 'als'=>'c'])."
						FROM
							".TB_MDL_CNT."
							INNER JOIN ".TB_MDL_CNT_TRA." ON mdlcnttra_mdlcnt = id_mdlcnt
							INNER JOIN "._BdStr(DBM).TB_TRA." ON mdlcnttra_tra = id_tra
							INNER JOIN "._BdStr(DBM).TB_TRA_COL." ON tra_col = id_tracol
							INNER JOIN ".TB_CNT." ON mdlcnt_cnt = id_cnt
							".GtSlc_QryExtra(['t'=>'tb', 'l'=>'ok', 'col'=>'tracol_clr', 'als'=>'c'])."
						WHERE tra_est = "._CId('ID_TRAEST_PRC')."
								{$_fl}
						ORDER BY mdlcnt_fi ASC LIMIT 10";

		$DtRg = $__cnx->_qry($query_DtRg);

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;

			if($Tot_DtRg > 0){

				$Vl['e'] = 'ok';
				$Vl['tot'] = $Tot_DtRg;

				do{

					$__tipo = json_decode($row_DtRg['___color']);

					foreach($__tipo as $__tipo_k=>$__tipo_v){
						$__tipo_attr[$__tipo_v->key] = $__tipo_v->vl;
					}

					$_r['d'][$row_DtRg['cnt_enc']]['clr'] = $__tipo_attr['clr'];
					$_r['d'][$row_DtRg['cnt_enc']]['id'] = ctjTx($row_DtRg['id_mdlcnt'],'in');
					$_r['d'][$row_DtRg['cnt_enc']]['nm'] = ctjTx($row_DtRg['cnt_nm'],'in').' '.ctjTx($row_DtRg['cnt_ap'],'in') ;
					$_r['d'][$row_DtRg['cnt_enc']]['tra'] = ctjTx($row_DtRg['tra_enc'],'in');
					$_r['d'][$row_DtRg['cnt_enc']]['fi'] = FechaESP([ 'f'=>$row_DtRg['mdlcnt_fi'], 't'=>'cmpr' ]);

				}while($row_DtRg = $DtRg->fetch_assoc());

				$Vl['o'] = $_r;
			}
		}else{
			$Vl['w'] = $__cnx->c_r->error;
		}

		$__cnx->_clsr($DtRg);

		return(_jEnc($Vl));
	}

	function GtTraDshRspUs($p=NULL){

		global $__cnx;

		$Vl['e'] = 'no';

		if(!isN($p['fi']) && !isN($p['ff'])){
			$__dt_1 = $p['fi'];
			$__dt_2 = $p['ff'];
			$_fl .= "AND DATE_FORMAT( tra_fi, '%Y-%m-%d' ) BETWEEN '".$__dt_1."' AND '".$__dt_2."'";
		}else{
			$__dt_1 = date('Y-m-01');
			$__dt_2 = date('Y-m-d');
		}

		if(!ClMain()){ $_fl .= ' AND tracol_chk_pblc=2'; }else{ $_fl .= ' AND tracol_chk_pblc=1'; }

		$query_DtRg = "SELECT
							us_nm, us_ap, us_enc, COUNT(*) AS tot
						FROM
							"._BdStr(DBM).TB_TRA_RSP."
							INNER JOIN "._BdStr(DBM).TB_TRA." ON trarsp_tra = id_tra
							INNER JOIN "._BdStr(DBM).TB_TRA_COL." ON tra_col = id_tracol
							INNER JOIN "._BdStr(DBM).TB_US." ON trarsp_us = id_us
						WHERE
							tra_cl = ".DB_CL_ID." AND
							trarsp_tp = "._CId('ID_USROL_RSP')." AND
							tra_est = "._CId('ID_TRAEST_PRC')."
							{$_fl}
						GROUP BY id_us
						ORDER BY tot DESC";

		$DtRg = $__cnx->_qry($query_DtRg);

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;

			if($Tot_DtRg > 0){

				$Vl['e'] = 'ok';
				$Vl['tot'] = $Tot_DtRg;

				do{
					$_r['d'][$row_DtRg['us_enc']]['nm'] = ctjTx($row_DtRg['us_nm'],'in').' '.ctjTx($row_DtRg['us_ap'],'in') ;
					$_r['d'][$row_DtRg['us_enc']]['tot'] = $row_DtRg['tot'];
				}while($row_DtRg = $DtRg->fetch_assoc());

				$Vl['o'] = $_r;
			}
		}else{
			$Vl['w'] = $__cnx->c_r->error;
		}

		$__cnx->_clsr($DtRg);

		return(_jEnc($Vl));
	}

	function GtTraDshCmpl($p=NULL){

		global $__cnx;

		$Vl['e'] = 'no';

		if(!isN($p['fi']) && !isN($p['ff'])){
			$__dt_1 = $p['fi'];
			$__dt_2 = $p['ff'];
		}else{
			$__dt_1 = date('Y-m-01');
			$__dt_2 = date('Y-m-d');
		}

		if(!ClMain()){ $_fl .= ' AND tracol_chk_pblc=2'; }else{ $_fl .= ' AND tracol_chk_pblc=1'; }

		$query_DtRg = " SELECT
							id_siscntest, siscntest_tt,
							DATE_FORMAT( tra_fi, '%Y-%m-%d' ) as f_i,
							COUNT( DISTINCT mdlcntest_mdlcnt ) as tot
						FROM
							".TB_MDL_CNT_EST."
							INNER JOIN ".TB_MDL_CNT." ON mdlcntest_mdlcnt = id_mdlcnt
							INNER JOIN ".TB_MDL_CNT_TRA." ON mdlcnttra_mdlcnt = id_mdlcnt
							INNER JOIN "._BdStr(DBM).TB_TRA." ON mdlcnttra_tra = id_tra
							INNER JOIN "._BdStr(DBM).TB_TRA_COL." ON tra_col = id_tracol
							INNER JOIN "._BdStr(DBM).TB_SIS_CNT_EST." ON mdlcntest_est = id_siscntest
						WHERE
							(siscntest_tra_archv = 1 OR siscntest_tra_cmpl = 1) AND
							DATE_FORMAT( tra_fi, '%Y-%m-%d' ) BETWEEN '".$__dt_1."' AND '".$__dt_2."'
							{$_fl}
						GROUP BY DATE_FORMAT( tra_fi, '%Y-%m-%d' )
						";

		$DtRg = $__cnx->_qry($query_DtRg);

		//$Vl['tmp_q'] = compress_code($query_DtRg);

		if($DtRg){

			$Vl['e'] = 'ok';

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;



				do{

					$_r['ctg'][$row_DtRg['f_i']] = $row_DtRg['f_i'];
					$_r['d'][$row_DtRg['id_siscntest']]['nm'] = $row_DtRg['siscntest_tt'];
					$_r['d'][$row_DtRg['id_siscntest']][$row_DtRg['f_i']]['tot'] = $row_DtRg['tot'];

				}while($row_DtRg = $DtRg->fetch_assoc());

				$Vl_Grph = _jEnc($_r);

				for($i=$__dt_1;$i<=$__dt_2;$i = date('Y-m-d', strtotime($i .'+ 1 days'))){

					$__ctg[] = $i;

					foreach($Vl_Grph->d as $_k => $_v){
						$_d[$_k]['name'] = 'Ticket Resuelto - '.$_v->nm;
						$_d[$_k]['data'][] = ( !isN($_v->{$i}->tot) ) ? (int)$_v->{$i}->tot : 0 ;
					}

				}
				$Vl['c'] = $__ctg;
				$Vl['o'] = $_d;


		}else{

			$Vl['w'] = $__cnx->c_r->error;

		}

		$__cnx->_clsr($DtRg);

		return(_jEnc($Vl));

	}

	function GtTraDshUsCmpl($p=NULL){

		global $__cnx;

		$Vl['e'] = 'no';

		if(!isN($p['fi']) && !isN($p['ff'])){
			$__dt_1 = $p['fi'];
			$__dt_2 = $p['ff'];
			$_fl .= "AND DATE_FORMAT( mdlcntest_fi, '%Y-%m-%d' ) BETWEEN '".$__dt_1."' AND '".$__dt_2."'";
		}else{
			$__dt_1 = date('Y-m-01');
			$__dt_2 = date('Y-m-d');
		}

		if(!ClMain()){ $_fl .= ' AND tracol_chk_pblc=2'; }else{ $_fl .= ' AND tracol_chk_pblc=1'; }

		$query_DtRg = " SELECT
							id_siscntest, us_nm, id_us, us_ap,
							DATE_FORMAT( mdlcntest_fi, '%Y-%m-%d' ) as f_i,
							COUNT( DISTINCT mdlcntest_mdlcnt ) as tot
						FROM
							".TB_MDL_CNT_EST."
							INNER JOIN ".TB_MDL_CNT." ON mdlcntest_mdlcnt = id_mdlcnt
							INNER JOIN ".TB_MDL_CNT_TRA." ON mdlcnttra_mdlcnt = id_mdlcnt
							INNER JOIN "._BdStr(DBM).TB_TRA." ON mdlcnttra_tra = id_tra
							INNER JOIN "._BdStr(DBM).TB_TRA_COL." ON tra_col = id_tracol
							INNER JOIN "._BdStr(DBM).TB_SIS_CNT_EST." ON mdlcntest_est = id_siscntest
							INNER JOIN "._BdStr(DBM).TB_US." ON mdlcntest_us = id_us
						WHERE
							(siscntest_tra_archv = 1 OR siscntest_tra_cmpl = 1)
							{$_fl}
						GROUP BY DATE_FORMAT( mdlcntest_fi, '%Y-%m-%d' ), id_us
						";

		$DtRg = $__cnx->_qry($query_DtRg);

		//$Vl['tmp_q'] = compress_code($query_DtRg);

		if($DtRg){

			$Vl['e'] = 'ok';

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;



				do{

					$_r['ctg'][$row_DtRg['f_i']] = $row_DtRg['f_i'];

					$_r['d'][$row_DtRg['id_us']]['nm'] = $row_DtRg['us_nm'].' '.$row_DtRg['us_ap'];
					$_r['d'][$row_DtRg['id_us']][$row_DtRg['f_i']]['tot'] = $row_DtRg['tot'];

				}while($row_DtRg = $DtRg->fetch_assoc());

				$Vl_Grph = _jEnc($_r);

				for($i=$__dt_1;$i<=$__dt_2;$i = date('Y-m-d', strtotime($i .'+ 1 days'))){

					$__ctg[] = $i;

					foreach($Vl_Grph->d as $_k => $_v){
						$_d[$_k]['name'] = $_v->nm;
						$_d[$_k]['data'][] = ( !isN($_v->{$i}->tot) ) ? (int)$_v->{$i}->tot : 0 ;
					}

				}

				$Vl['c'] = $__ctg;
				$Vl['o'] = $_d;


		}else{

			$Vl['w'] = $__cnx->c_r->error;

		}

		$__cnx->_clsr($DtRg);

		return(_jEnc($Vl));

	}

	function GtTraDshTag($p=NULL){

		global $__cnx;

		$Vl['e'] = 'no';

		if(!isN($p['fi']) && !isN($p['ff'])){
			$__dt_1 = $p['fi'];
			$__dt_2 = $p['ff'];
			$_fl .= "AND DATE_FORMAT( tra_fi, '%Y-%m-%d' ) BETWEEN '".$__dt_1."' AND '".$__dt_2."'";
		}else{
			$__dt_1 = date('Y-m-01');
			$__dt_2 = date('Y-m-d');
		}

		if(!ClMain()){ $_fl .= ' AND tracol_chk_pblc=2'; }else{ $_fl .= ' AND tracol_chk_pblc=1'; }

		$query_DtRg = "	SELECT
							COUNT( DISTINCT id_tra ) as tot,
							"._QrySisSlcF(['als'=>'t', 'als_n'=>'tag']).",
							".GtSlc_QryExtra(['t'=>'fld', 'p'=>'tag', 'als'=>'t'])."
						FROM
							"._BdStr(DBM).TB_TRA."
							INNER JOIN "._BdStr(DBM).TB_TRA_COL." ON tra_col = id_tracol
							INNER JOIN "._BdStr(DBM).TB_TRA_TAG." ON tratag_tra = id_tra
							".GtSlc_QryExtra(['t'=>'tb', 'col'=>'tratag_tag', 'als'=>'t'])."
						WHERE tra_cl = ".DB_CL_ID."
							  {$_fl}
						GROUP BY id_sisslc";

		$DtRg = $__cnx->_qry($query_DtRg);

		if($DtRg){

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;

			if($Tot_DtRg > 0){

				$Vl['e'] = 'ok';

				do{

					$__tipo = json_decode($row_DtRg['___tag']);

					foreach($__tipo as $__tipo_k=>$__tipo_v){
						$__tipo_attr[$__tipo_v->key] = $__tipo_v->vl;
					}

					$_r['d'][$row_DtRg['tag_sisslc_enc']]['clr'] = $__tipo_attr['clr_tag'];
					$_r['d'][$row_DtRg['tag_sisslc_enc']]['nm'] = $row_DtRg['tag_sisslc_tt'];
					$_r['d'][$row_DtRg['tag_sisslc_enc']]['tot'] = $row_DtRg['tot'];

				}while($row_DtRg = $DtRg->fetch_assoc());

				$Vl_Grph = _jEnc($_r);

				foreach($Vl_Grph->d as $_k => $_v){
					$_d[$_k]['name'] = $_v->nm;
					$_d[$_k]['color'] = $_v->clr;
					$_d[$_k]['data'][] = ( !isN($_v->tot) ) ? (int)$_v->tot : 0 ;
				}

				$Vl['o'] = $_d;
			}
		}else{
			$Vl['w'] = $__cnx->c_r->error;
		}

		$__cnx->_clsr($DtRg);

		return(_jEnc($Vl));
	}

	function GtTraDshColUs($p=NULL){

		global $__cnx;

		$Vl['e'] = 'no';

		if(!isN($p['fi']) && !isN($p['ff'])){
			$__dt_1 = $p['fi'];
			$__dt_2 = $p['ff'];
			$_fl .= "AND DATE_FORMAT( tra_fi, '%Y-%m-%d' ) BETWEEN '".$__dt_1."' AND '".$__dt_2."'";
		}else{
			$__dt_1 = date('Y-m-01');
			$__dt_2 = date('Y-m-d');
		}

		$query_DtRg = "	SELECT
							id_us,
							us_nm,
							us_ap,
							us_enc,
							COUNT( id_us ) as tot
						FROM
							"._BdStr(DBM).TB_US."
							INNER JOIN "._BdStr(DBM).TB_TRA_HIS_COL." ON trahiscol_byus = id_us
							INNER JOIN "._BdStr(DBM).TB_TRA." ON trahiscol_tra = id_tra
							  {$_fl}
						WHERE tra_cl = ".DB_CL_ID." AND
						DATE_FORMAT( tra_fi, '%Y-%m-%d' ) BETWEEN '".$__dt_1."' AND '".$__dt_2."'
						GROUP BY id_us";

		$DtRg = $__cnx->_qry($query_DtRg);

		//$Vl['ed'] = $query_DtRg;

		if($DtRg){

			$Vl['e'] = 'ok';

			$row_DtRg = $DtRg->fetch_assoc();
			$Tot_DtRg = $DtRg->num_rows;

			if($Tot_DtRg > 0){

				do{

					$_r['ctg'][] = $row_DtRg['us_nm'];
					$_r['d'][] = (int)$row_DtRg['tot'];

				}while($row_DtRg = $DtRg->fetch_assoc());

				$Vl['c'] = $_r['ctg'];
				$Vl['o'] = $_r['d'];
			}

		}else{

			$Vl['w'] = $__cnx->c_r->error;

		}

		$__cnx->_clsr($DtRg);

		return(_jEnc($Vl));

	}

?>